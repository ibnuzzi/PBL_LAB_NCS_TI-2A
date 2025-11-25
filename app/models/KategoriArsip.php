<?php
// File: /app/models/KategoriArsip.php

class KategoriArsip {
    private $db;
    private $table = 'tbl_kategori_arsip';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Ambil semua kategori
     */
    public function getAllKategori() {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY id_kategori_arsip ASC");
        return $this->db->resultSet();
    }

    /**
     * Ambil satu kategori berdasarkan ID (untuk Edit)
     */
    public function getKategoriById($id) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id_kategori_arsip = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    /**
     * Tambah Kategori Baru
     */
    public function tambahKategori($data) {
        $query = "INSERT INTO " . $this->table . " (nama_kategori) VALUES (:nama_kategori)";
        
        $this->db->query($query);
        $this->db->bind(':nama_kategori', $data['nama_kategori']);

        return $this->db->execute();
    }

    /**
     * Update Kategori
     */
    public function updateKategori($data) {
        $query = "UPDATE " . $this->table . " SET nama_kategori = :nama_kategori WHERE id_kategori_arsip = :id";
        
        $this->db->query($query);
        $this->db->bind(':nama_kategori', $data['nama_kategori']);
        $this->db->bind(':id', $data['id_kategori_arsip'], PDO::PARAM_INT);

        return $this->db->execute();
    }

    /**
     * Hapus Kategori
     */
    public function hapusKategori($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_kategori_arsip = :id";
        
        $this->db->query($query);
        $this->db->bind(':id', $id, PDO::PARAM_INT);

        return $this->db->execute();
    }
}