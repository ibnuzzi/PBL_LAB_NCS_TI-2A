<?php
// File: /app/models/Berita.php

class Berita
{
    private $db;
    private $table = 'tbl_berita';

    public $id_berita;
    public $judul_berita;
    public $slug_berita;
    public $isi_berita;
    public $gambar_berita;
    public $id_admin_penulis;
    public $tanggal_publish;

    public function __construct($data = [])
    {
        $this->db = Database::getInstance();
        if (!empty($data)) {
            $this->id_berita = $data['id_berita'] ?? null;
            $this->judul_berita = $data['judul_berita'] ?? '';
            $this->slug_berita = $data['slug_berita'] ?? '';
            $this->isi_berita = $data['isi_berita'] ?? '';
            $this->gambar_berita = $data['gambar_berita'] ?? null;
            $this->id_admin_penulis = $data['id_admin_penulis'] ?? null;
            $this->tanggal_publish = $data['tanggal_publish'] ?? null;
        }
    }

    /**
     * Mengambil semua data berita
     */
    public function getAllBerita()
    {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY tanggal_publish DESC");
        return $this->db->resultSet();
    }

    /**
     * Mengambil data berita dengan pagination
     */
    public function getBeritaPaginated($limit = 6, $offset = 0)
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY tanggal_publish DESC LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        $this->db->bind(':limit', (int)$limit, PDO::PARAM_INT);
        $this->db->bind(':offset', (int)$offset, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    /**
     * Menghitung total berita
     */
    public function countBerita()
    {
        $this->db->query("SELECT COUNT(*) AS total FROM " . $this->table);
        $row = $this->db->single();
        return isset($row['total']) ? (int)$row['total'] : 0;
    }

    /**
     * Mengambil berita terbaru
     */
    public function getBeritaTerbaru($limit = 3)
    {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY tanggal_publish DESC LIMIT :limit");
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    /**
     * Mengambil berita berdasarkan ID
     */
    public function getBeritaById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id_berita = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    /**
     * Mengambil berita berdasarkan SLUG
     */
    public function getBeritaBySlug($slug)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE slug_berita = :slug");
        $this->db->bind(':slug', $slug);
        return $this->db->single();
    }

    /**
     * Membuat berita baru dengan validasi
     */
    public function createBerita($data)
    {
        // Validasi input
        if (empty($data['judul_berita']) || empty($data['isi_berita'])) {
            throw new Exception('Judul dan isi berita tidak boleh kosong.');
        }

        // Buat slug jika kosong
        if (empty($data['slug_berita'])) {
            $data['slug_berita'] = $this->generateSlug($data['judul_berita']);
        }

        // Set tanggal publish jika kosong
        if (empty($data['tanggal_publish'])) {
            $data['tanggal_publish'] = date('Y-m-d');
        }

        $query = "INSERT INTO " . $this->table . "
                    (judul_berita, slug_berita, isi_berita, gambar_berita, id_admin_penulis, tanggal_publish)
                  VALUES
                    (:judul, :slug, :isi, :gambar, :id_admin, :tanggal)";

        $this->db->query($query);

        $this->db->bind(':judul', $data['judul_berita']);
        $this->db->bind(':slug', $data['slug_berita']);
        $this->db->bind(':isi', $data['isi_berita']);
        $this->db->bind(':gambar', $data['gambar_berita']);
        $this->db->bind(':id_admin', $data['id_admin_penulis'], PDO::PARAM_INT);
        $this->db->bind(':tanggal', $data['tanggal_publish']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update berita dengan validasi
     */
    public function updateBerita($data)
    {
        // Validasi input
        if (empty($data['judul_berita']) || empty($data['isi_berita'])) {
            throw new Exception('Judul dan isi berita tidak boleh kosong.');
        }

        // Buat slug jika kosong
        if (empty($data['slug_berita'])) {
            $data['slug_berita'] = $this->generateSlug($data['judul_berita']);
        }

        $query = "UPDATE " . $this->table . " SET
                                        judul_berita = :judul,
                                        slug_berita = :slug,
                                        isi_berita = :isi,
                                        gambar_berita = :gambar,
                                        tanggal_publish = :tanggal
                                    WHERE id_berita = :id";

        $this->db->query($query);

        $this->db->bind(':judul', $data['judul_berita']);
        $this->db->bind(':slug', $data['slug_berita']);
        $this->db->bind(':isi', $data['isi_berita']);
        $this->db->bind(':gambar', $data['gambar_berita']);
        $this->db->bind(':tanggal', $data['tanggal_publish']);
        $this->db->bind(':id', $data['id_berita'], PDO::PARAM_INT);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Hapus berita
     */
    public function deleteBerita($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id_berita = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id, PDO::PARAM_INT);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Generate slug dari judul
     */
    private function generateSlug($title)
    {
        return strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($title)));
    }

    /**
     * Get formatted date for display
     */
    public function getFormattedDate()
    {
        if ($this->tanggal_publish) {
            return date('d M Y', strtotime($this->tanggal_publish));
        }
        return '';
    }

    /**
     * Get excerpt of content
     */
    public function getExcerpt($length = 150)
    {
        if (strlen($this->isi_berita) > $length) {
            return substr($this->isi_berita, 0, $length) . '...';
        }
        return $this->isi_berita;
    }
}
