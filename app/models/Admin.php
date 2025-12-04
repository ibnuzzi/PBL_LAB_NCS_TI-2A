<?php
// File: /app/models/Admin.php

// PASTIKAN NAMA CLASS-NYA "Admin", BUKAN "admin" atau "AdminModel"
class Admin {
    private $db;
    private $table = 'tbl_admin';

    public function __construct() {
        // Pastikan Anda menggunakan getInstance() seperti yang kita setel
        $this->db = Database::getInstance();
    }

    /**
     * Cari admin berdasarkan email
     * @param string $email
     * @return array|false Data admin jika ditemukan, false jika tidak
     */
    public function getAdminByEmail($email) {
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
    public function getAdminById($id) {
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
     * @param array $data (email, password_hash, nama_lengkap)
     */
    public function tambahAdmin($data) {
        $query = "INSERT INTO " . $this->table . " (email, password, nama_lengkap) 
                  VALUES (:email, :password, :nama)";

        $this->db->query($query);
        
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']); // Ini harus HASH
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
    public function updateProfile($data) {
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
    public function updatePassword($id_admin, $new_password_hash) {
        $query = "UPDATE " . $this->table . " 
                  SET password = :password 
                  WHERE id_admin = :id";

        $this->db->query($query);
        $this->db->bind(':password', $new_password_hash);
        $this->db->bind(':id', $id_admin);

        return $this->db->execute();
    }
}
?>