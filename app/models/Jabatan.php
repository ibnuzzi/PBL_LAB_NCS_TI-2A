<?php

class Jabatan {

    private $db;

    public function __construct()
    {
        // ✔ HARUS MENGGUNAKAN SINGLETON
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM tbl_jabatan ORDER BY nama_jabatan ASC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM tbl_jabatan WHERE id_jabatan = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        return $this->db->single();
    }

    public function insert($data)
    {
        $sql = "INSERT INTO tbl_jabatan (nama_jabatan, deskripsi)
                VALUES (:nama_jabatan, :deskripsi)";

        $this->db->query($sql);
        $this->db->bind(":nama_jabatan", $data['nama_jabatan']);
        $this->db->bind(":deskripsi", $data['deskripsi'] ?? null);

        return $this->db->execute();
    }

    public function update($data)
    {
        $sql = "UPDATE tbl_jabatan SET
                    nama_jabatan = :nama_jabatan,
                    deskripsi = :deskripsi,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id_jabatan = :id";

        $this->db->query($sql);
        $this->db->bind(":nama_jabatan", $data['nama_jabatan']);
        $this->db->bind(":deskripsi", $data['deskripsi'] ?? null);
        $this->db->bind(":id", $data['id_jabatan']);

        return $this->db->execute();
    }

    public function delete($id)
    {
        // Check if jabatan is being used by pengelola
        $checkSql = "SELECT COUNT(*) as count FROM tbl_pengelola WHERE id_jabatan = :id";
        $this->db->query($checkSql);
        $this->db->bind(":id", $id);
        $result = $this->db->single();
        
        if ($result['count'] > 0) {
            return false; // Cannot delete if being used
        }

        $sql = "DELETE FROM tbl_jabatan WHERE id_jabatan = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        return $this->db->execute();
    }

    /**
     * Check if jabatan is being used by any pengelola
     */
    public function isUsed($id)
    {
        $sql = "SELECT COUNT(*) as count FROM tbl_pengelola WHERE id_jabatan = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        $result = $this->db->single();
        return $result['count'] > 0;
    }
}
