<?php
// File: /app/models/Gallery.php

class Gallery {
    private $db;
    private $table = 'tbl_galeri';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    /**
     * Ambil data galeri dengan pagination
     */
    public function getGalleryPaginated($limit = 6, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        $this->db->bind(':limit', (int)$limit, PDO::PARAM_INT);
        $this->db->bind(':offset', (int)$offset, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    /**
     * Hitung total item galeri
     */
    public function countGallery() {
        $this->db->query("SELECT COUNT(*) AS total FROM " . $this->table);
        $row = $this->db->single();
        return isset($row['total']) ? (int)$row['total'] : 0;
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id_foto = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    public function tambahFoto($data) {
        // created_at set by DB or use CURRENT_TIMESTAMP
        $query = "INSERT INTO " . $this->table . " (nama_file_foto, judul_foto, deskripsi_foto, id_admin_uploader, created_at) VALUES (:file, :judul, :deskripsi, :id_admin, CURRENT_TIMESTAMP)";
        $this->db->query($query);
        $this->db->bind(':file', $data['nama_file_foto']);
        $this->db->bind(':judul', $data['judul_foto']);
        $this->db->bind(':deskripsi', $data['deskripsi_foto']);
        $this->db->bind(':id_admin', $data['id_admin_uploader'], PDO::PARAM_INT);
        return $this->db->execute();
    }

    public function updateFoto($data) {
        $query = "UPDATE " . $this->table . " SET nama_file_foto = :file, judul_foto = :judul, deskripsi_foto = :deskripsi, updated_at = CURRENT_TIMESTAMP WHERE id_foto = :id";
        $this->db->query($query);
        $this->db->bind(':file', $data['nama_file_foto']);
        $this->db->bind(':judul', $data['judul_foto']);
        $this->db->bind(':deskripsi', $data['deskripsi_foto']);
        $this->db->bind(':id', $data['id_foto'], PDO::PARAM_INT);
        return $this->db->execute();
    }

    public function hapusFoto($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_foto = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->execute();
    }
}

?>
