<?php
// File: /app/models/DokumenUmum.php

class DokumenUmum {
    private $db;
    private $table = 'tbl_arsip';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id_dokumen = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    public function insert($data) {
        $query = "INSERT INTO {$this->table}
                    (nama_dokumen, nama_file_dokumen, deskripsi_dokumen, id_admin_uploader)
                  VALUES
                    (:nama_dokumen, :nama_file_dokumen, :deskripsi_dokumen, :id_admin_uploader)";

        $this->db->query($query);
        $this->db->bind(':nama_dokumen', $data['nama_dokumen']);
        $this->db->bind(':nama_file_dokumen', $data['nama_file_dokumen']);
        $this->db->bind(':deskripsi_dokumen', $data['deskripsi_dokumen']);
        $this->db->bind(':id_admin_uploader', $data['id_admin_uploader'], PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function update($data) {
        $query = "UPDATE {$this->table} SET
                    nama_dokumen = :nama_dokumen,
                    nama_file_dokumen = :nama_file_dokumen,
                    deskripsi_dokumen = :deskripsi_dokumen,
                    updated_at = NOW()
                  WHERE id_dokumen = :id_dokumen";

        $this->db->query($query);
        $this->db->bind(':nama_dokumen', $data['nama_dokumen']);
        $this->db->bind(':nama_file_dokumen', $data['nama_file_dokumen']);
        $this->db->bind(':deskripsi_dokumen', $data['deskripsi_dokumen']);
        $this->db->bind(':id_dokumen', $data['id_dokumen'], PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id_dokumen = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->execute();
    }
}
