<?php

class Keminatan {

    private $db;

    public function __construct()
    {
        // ✔ HARUS MENGGUNAKAN SINGLETON
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM tbl_keminatan ORDER BY nama_keminatan ASC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM tbl_keminatan WHERE id_keminatan = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        return $this->db->single();
    }

    public function insert($data)
    {
        $sql = "INSERT INTO tbl_keminatan (nama_keminatan, deskripsi)
                VALUES (:nama_keminatan, :deskripsi)";

        $this->db->query($sql);
        $this->db->bind(":nama_keminatan", $data['nama_keminatan']);
        $this->db->bind(":deskripsi", $data['deskripsi'] ?? null);

        return $this->db->execute();
    }

    public function update($data)
    {
        $sql = "UPDATE tbl_keminatan SET
                    nama_keminatan = :nama_keminatan,
                    deskripsi = :deskripsi,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id_keminatan = :id";

        $this->db->query($sql);
        $this->db->bind(":nama_keminatan", $data['nama_keminatan']);
        $this->db->bind(":deskripsi", $data['deskripsi'] ?? null);
        $this->db->bind(":id", $data['id_keminatan']);

        return $this->db->execute();
    }

    public function delete($id)
    {
        // Check if keminatan is being used by pengelola
        $checkSql = "SELECT COUNT(*) as count FROM tbl_pengelola_keminatan WHERE id_keminatan = :id";
        $this->db->query($checkSql);
        $this->db->bind(":id", $id);
        $result = $this->db->single();
        
        if ($result['count'] > 0) {
            return false; // Cannot delete if being used
        }

        $sql = "DELETE FROM tbl_keminatan WHERE id_keminatan = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        return $this->db->execute();
    }

    /**
     * Check if keminatan is being used by any pengelola
     */
    public function isUsed($id)
    {
        $sql = "SELECT COUNT(*) as count FROM tbl_pengelola_keminatan WHERE id_keminatan = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        $result = $this->db->single();
        return $result['count'] > 0;
    }

    /**
     * Get all keminatan for a specific pengelola
     */
    public function getByPengelolaId($id_pengelola)
    {
        $sql = "SELECT k.* FROM tbl_keminatan k
                INNER JOIN tbl_pengelola_keminatan pk ON k.id_keminatan = pk.id_keminatan
                WHERE pk.id_pengelola = :id_pengelola
                ORDER BY k.nama_keminatan ASC";
        
        $this->db->query($sql);
        $this->db->bind(":id_pengelola", $id_pengelola);
        return $this->db->resultSet();
    }
}
