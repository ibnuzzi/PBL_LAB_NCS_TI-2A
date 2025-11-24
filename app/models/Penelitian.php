<?php
// File: /app/models/Penelitian.php

class Penelitian
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Get all penelitian records
    public function getAll()
    {
        $this->db->query("SELECT * FROM tbl_penelitian ORDER BY id_penelitian DESC");
        return $this->db->resultSet();
    }

    // Get a single penelitian record by its ID
    public function getById($id)
    {
        $this->db->query("SELECT * FROM tbl_penelitian WHERE id_penelitian = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Insert a new penelitian record
    public function insert($data)
    {
        $this->db->query("
            INSERT INTO tbl_penelitian 
            (judul_penelitian, tahun_penelitian, deskripsi_singkat, peneliti, link_publikasi, created_at, updated_at)
            VALUES
            (:judul_penelitian, :tahun_penelitian, :deskripsi_singkat, :peneliti, :link_publikasi, NOW(), NOW())
        ");
        $this->db->bind(':judul_penelitian', $data['judul_penelitian']);
        $this->db->bind(':tahun_penelitian', $data['tahun_penelitian']);
        $this->db->bind(':deskripsi_singkat', $data['deskripsi_singkat']);
        $this->db->bind(':peneliti', $data['peneliti']);
        $this->db->bind(':link_publikasi', $data['link_publikasi']);

        return $this->db->execute();
    }

    // Update an existing penelitian record
    public function update($id, $data)
    {
        $this->db->query("
            UPDATE tbl_penelitian SET
                judul_penelitian = :judul_penelitian,
                tahun_penelitian = :tahun_penelitian,
                deskripsi_singkat = :deskripsi_singkat,
                peneliti = :peneliti,
                link_publikasi = :link_publikasi,
                updated_at = NOW()
            WHERE id_penelitian = :id
        ");
        $this->db->bind(':judul_penelitian', $data['judul_penelitian']);
        $this->db->bind(':tahun_penelitian', $data['tahun_penelitian']);
        $this->db->bind(':deskripsi_singkat', $data['deskripsi_singkat']);
        $this->db->bind(':peneliti', $data['peneliti']);
        $this->db->bind(':link_publikasi', $data['link_publikasi']);
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    // Delete a penelitian
    public function delete($id)
    {
        $this->db->query("DELETE FROM tbl_penelitian WHERE id_penelitian = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
