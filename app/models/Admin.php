<?php
// File: /app/models/Admin.php

// PASTIKAN NAMA CLASS-NYA "Admin", BUKAN "admin" atau "AdminModel"
class Admin
{
    private $db;
    private $table = 'tbl_admin';

    public function __construct()
    {
        // Pastikan Anda menggunakan getInstance() seperti yang kita setel
        $this->db = Database::getInstance();
    }

    /**
     * Cari admin berdasarkan email
     * @param string $email
     * @return array|false Data admin jika ditemukan, false jika tidak
     */
    public function getAdminByEmail($email)
    {
        // Query untuk mencari berdasarkan email
        $this->db->query("SELECT * FROM " . $this->table . " WHERE email = :email");
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // Cek apakah data ditemukan
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    /**
     * Cari admin berdasarkan ID
     * @param int $id
     * @return array|false Data admin jika ditemukan, false jika tidak
     */
    public function getAdminById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id_admin = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    /**
     * Fungsi ini akan Anda perlukan nanti untuk menambah admin baru
     * @param array $data (email, password, nama_lengkap)
     */
    public function tambahAdmin($data)
    {
        $query = "INSERT INTO " . $this->table . " (email, password, nama_lengkap) 
                  VALUES (:email, :password, :nama)";

        $this->db->query($query);

        $this->db->bind(':email', $data['email']);
        // Hash password menggunakan password_hash() untuk keamanan
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':nama', $data['nama_lengkap']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update profile admin
     * @param array $data (id_admin, nama_lengkap, email)
     */
    public function updateProfile($data)
    {
        $query = "UPDATE " . $this->table . " 
                  SET nama_lengkap = :nama, email = :email 
                  WHERE id_admin = :id";

        $this->db->query($query);
        $this->db->bind(':nama', $data['nama_lengkap']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':id', $data['id_admin']);

        return $this->db->execute();
    }

    /**
     * Update password admin
     * @param int $id_admin
     * @param string $new_password_hash
     */
    public function updatePassword($id_admin, $new_password_hash)
    {
        $query = "UPDATE " . $this->table . " 
                  SET password = :password 
                  WHERE id_admin = :id";

        $this->db->query($query);
        $this->db->bind(':password', $new_password_hash);
        $this->db->bind(':id', $id_admin);

        return $this->db->execute();
    }

    /**
     * Simpan token reset password
     * @param int $id_admin
     * @param string $token
     * @param string $expires
     */
    public function saveResetToken($id_admin, $token, $expires)
    {
        $query = "UPDATE " . $this->table . " 
                  SET reset_token = :token, reset_expires = :expires 
                  WHERE id_admin = :id";

        $this->db->query($query);
        $this->db->bind(':token', $token);
        $this->db->bind(':expires', $expires);
        $this->db->bind(':id', $id_admin);

        return $this->db->execute();
    }

    /**
     * Validasi token reset password
     * @param int $id_admin
     * @param string $token
     * @return bool
     */
    public function validateResetToken($id_admin, $token)
    {
        // Ambil data admin dengan token
        $query = "SELECT reset_token, reset_expires FROM " . $this->table . " 
                  WHERE id_admin = :id";

        $this->db->query($query);
        $this->db->bind(':id', $id_admin);

        $row = $this->db->single();

        if (!$row || $this->db->rowCount() == 0) {
            return false;
        }

        // Cek apakah token cocok
        if ($row['reset_token'] !== $token) {
            return false;
        }

        // Cek apakah belum expired (gunakan waktu PHP untuk konsistensi)
        $expiresTime = strtotime($row['reset_expires']);
        $currentTime = time();

        // Token valid jika belum expired
        return $expiresTime > $currentTime;
    }

    /**
     * Hapus token reset password setelah digunakan
     * @param int $id_admin
     */
    public function deleteResetToken($id_admin)
    {
        $query = "UPDATE " . $this->table . " 
                  SET reset_token = NULL, reset_expires = NULL 
                  WHERE id_admin = :id";

        $this->db->query($query);
        $this->db->bind(':id', $id_admin);

        return $this->db->execute();
    }

    /**
     * Reset password menggunakan stored procedure
     * Memvalidasi token dan update password dalam satu transaksi
     * @param string $email
     * @param string $token
     * @param string $new_password_hash Password yang sudah di-hash
     * @return bool
     */
    public function resetPasswordWithSP($email, $token, $new_password_hash)
    {
        // Call stored procedure
        $sql = "SELECT sp_reset_admin_password(:email, :token, :password) AS success";

        $this->db->query($sql);
        $this->db->bind(':email', $email);
        $this->db->bind(':token', $token);
        $this->db->bind(':password', $new_password_hash);

        $result = $this->db->single();
        return $result && $result['success'] === true;
    }
}
