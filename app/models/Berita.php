<?php
// File: /app/models/Berita.php

class Berita {
    private $db;
    private $table = 'tbl_berita'; // Nama tabel Anda

    public function __construct() {
        // Menggunakan Singleton Pattern dari Database.php
        $this->db = Database::getInstance();
    }

    /**
     * Mengambil semua data berita, diurutkan dari yang terbaru
     */
    public function getAllBerita() {
        // PostgreSQL dan MySQL sama untuk query ini
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY tanggal_publish DESC");
        return $this->db->resultSet();
    }

    /**
     * Mengambil data berita dengan pagination
     * @param int $limit jumlah data per halaman
     * @param int $offset offset (untuk page)
     * @return array
     */
    public function getBeritaPaginated($limit = 6, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . " ORDER BY tanggal_publish DESC LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        $this->db->bind(':limit', (int)$limit, PDO::PARAM_INT);
        $this->db->bind(':offset', (int)$offset, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    /**
     * Menghitung total berita untuk kebutuhan pagination
     * @return int
     */
    public function countBerita() {
        $this->db->query("SELECT COUNT(*) AS total FROM " . $this->table);
        $row = $this->db->single();
        return isset($row['total']) ? (int)$row['total'] : 0;
    }

    /**
     * Mengambil data berita terbaru (misal: 3 berita) untuk homepage
     */
    public function getBeritaTerbaru($limit = 3) {
        // Sintaks LIMIT di PostgreSQL dan MySQL sama
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY tanggal_publish DESC LIMIT :limit");
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    /**
     * Mengambil satu data berita berdasarkan ID
     */
    public function getBeritaById($id) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id_berita = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    /**
     * Menambah data berita baru (untuk Admin)
     */
    public function tambahBerita($data) {
        // Catatan: id_berita menggunakan SERIAL atau BIGSERIAL di PostgreSQL
        $query = "INSERT INTO " . $this->table . " 
                    (judul_berita, slug_berita, isi_berita, gambar_berita, id_admin_penulis, tanggal_publish) 
                  VALUES 
                    (:judul, :slug, :isi, :gambar, :id_admin, :tanggal)";

        $this->db->query($query);

        // Binding data
        $this->db->bind(':judul', $data['judul_berita']);
        $this->db->bind(':slug', $data['slug_berita']);
        $this->db->bind(':isi', $data['isi_berita']);
        $this->db->bind(':gambar', $data['gambar_berita']);
        $this->db->bind(':id_admin', $data['id_admin_penulis'], PDO::PARAM_INT);
        $this->db->bind(':tanggal', $data['tanggal_publish']);

        // Eksekusi
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Mengupdate data berita (untuk Admin)
     */
    public function updateBerita($data) {
                $query = "UPDATE " . $this->table . " SET
                                        judul_berita = :judul,
                                        slug_berita = :slug,
                                        isi_berita = :isi,
                                        gambar_berita = :gambar,
                                        tanggal_publish = :tanggal
                                    WHERE id_berita = :id";
        
        $this->db->query($query);

        // Binding data
        $this->db->bind(':judul', $data['judul_berita']);
        $this->db->bind(':slug', $data['slug_berita']);
        $this->db->bind(':isi', $data['isi_berita']);
        $this->db->bind(':gambar', $data['gambar_berita']);
        $this->db->bind(':tanggal', $data['tanggal_publish']);
        $this->db->bind(':id', $data['id_berita'], PDO::PARAM_INT);

        // Eksekusi
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Menghapus data berita (untuk Admin)
     */
    public function hapusBerita($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_berita = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id, PDO::PARAM_INT);

        // Eksekusi
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}