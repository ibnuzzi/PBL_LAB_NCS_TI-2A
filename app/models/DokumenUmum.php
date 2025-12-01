<?php
// File: /app/models/DokumenUmum.php

class DokumenUmum
{
    private $db;
    private $table = 'tbl_arsip';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        // JOIN dengan tabel kategori untuk menampilkan nama kategori
        $sql = "SELECT a.*, k.nama_kategori 
                FROM {$this->table} a
                LEFT JOIN tbl_kategori_arsip k ON a.id_kategori_arsip = k.id_kategori_arsip
                ORDER BY a.created_at DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getAllArsipLengkap()
    {
        // Pastikan Anda sudah menjalankan SQL CREATE VIEW v_arsip_gabungan di PgAdmin
        $this->db->query("SELECT * FROM v_arsip_gabungan ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function getAllArsipLengkapByKategori($namaKategori)
    {
        // Filter berdasarkan kategori dari view v_arsip_gabungan
        $this->db->query("SELECT * FROM v_arsip_gabungan WHERE kategori = :kategori ORDER BY created_at DESC");
        $this->db->bind(':kategori', $namaKategori);
        return $this->db->resultSet();
    }

    public function getDistinctYears()
    {
        // Mengambil tahun yang tersedia dari view v_arsip_gabungan
        $this->db->query("SELECT DISTINCT tahun FROM v_arsip_gabungan WHERE tahun IS NOT NULL ORDER BY tahun DESC");
        return $this->db->resultSet();
    }

    public function getAllArsipLengkapByFilters($kategori = null, $tahun = null, $search = null)
    {
        // Filter berdasarkan kategori, tahun, dan search dari view v_arsip_gabungan
        $sql = "SELECT * FROM v_arsip_gabungan WHERE 1=1";
        
        if ($kategori && $kategori !== 'semua') {
            $sql .= " AND kategori = :kategori";
        }
        
        if ($tahun && $tahun !== 'semua') {
            $sql .= " AND tahun = :tahun";
        }
        
        if ($search && trim($search) !== '') {
            $sql .= " AND (judul ILIKE :search OR penulis_atau_tim ILIKE :search)";
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $this->db->query($sql);
        
        if ($kategori && $kategori !== 'semua') {
            $this->db->bind(':kategori', $kategori);
        }
        
        if ($tahun && $tahun !== 'semua') {
            $this->db->bind(':tahun', $tahun);
        }
        
        if ($search && trim($search) !== '') {
            $this->db->bind(':search', '%' . $search . '%');
        }
        
        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE id_dokumen = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    public function insert($data)
    {
        // TAMBAHKAN id_kategori_arsip
        $query = "INSERT INTO {$this->table}
                    (nama_dokumen, nama_file_dokumen, deskripsi_dokumen, id_admin_uploader, id_kategori_arsip)
                  VALUES
                    (:nama_dokumen, :nama_file_dokumen, :deskripsi_dokumen, :id_admin_uploader, :id_kategori_arsip)";

        $this->db->query($query);
        $this->db->bind(':nama_dokumen', $data['nama_dokumen']);
        $this->db->bind(':nama_file_dokumen', $data['nama_file_dokumen']);
        $this->db->bind(':deskripsi_dokumen', $data['deskripsi_dokumen']);
        $this->db->bind(':id_admin_uploader', $data['id_admin_uploader'], PDO::PARAM_INT);
        $this->db->bind(':id_kategori_arsip', $data['id_kategori_arsip'], PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function update($data)
    {
        // TAMBAHKAN id_kategori_arsip
        $query = "UPDATE {$this->table} SET
                    nama_dokumen = :nama_dokumen,
                    nama_file_dokumen = :nama_file_dokumen,
                    deskripsi_dokumen = :deskripsi_dokumen,
                    id_kategori_arsip = :id_kategori_arsip,
                    updated_at = CURRENT_TIMESTAMP
                  WHERE id_dokumen = :id_dokumen";

        $this->db->query($query);
        $this->db->bind(':nama_dokumen', $data['nama_dokumen']);
        $this->db->bind(':nama_file_dokumen', $data['nama_file_dokumen']);
        $this->db->bind(':deskripsi_dokumen', $data['deskripsi_dokumen']);
        $this->db->bind(':id_kategori_arsip', $data['id_kategori_arsip'], PDO::PARAM_INT);
        $this->db->bind(':id_dokumen', $data['id_dokumen'], PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function delete($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id_dokumen = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->execute();
    }
    public function getLatestByCategory($categoryName, $limit)
    {
        $sql = "SELECT a.*, k.nama_kategori 
                FROM {$this->table} a
                JOIN tbl_kategori_arsip k ON a.id_kategori_arsip = k.id_kategori_arsip
                WHERE k.nama_kategori = :categoryName
                ORDER BY a.created_at DESC
                LIMIT :limit";
        $this->db->query($sql);
        $this->db->bind(':categoryName', $categoryName);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
}
