<?php
// File: /app/models/Konsultasi.php

class Konsultasi
{
    private $db;
    private $table = "tbl_konsultasi"; // PERBAIKAN: Sesuaikan nama tabel dengan DB

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        // Mengambil semua data diurutkan dari yang terbaru
        $this->db->query("SELECT * FROM {$this->table} ORDER BY tanggal_tanya DESC");
        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE id_konsultasi = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    public function insert($data)
    {
        // PERBAIKAN PENTING:
        // 1. Kita hanya insert 3 kolom utama. 
        // 2. Kolom 'status_jawaban' akan otomatis 'pending' (Default DB)
        // 3. Kolom 'tanggal_tanya' akan otomatis CURRENT_TIMESTAMP (Default DB)
        // Cara ini jauh lebih aman dari error syntax di PostgreSQL.
        
        $sql = "INSERT INTO {$this->table} (nama_penanya, email_penanya, pertanyaan) 
                VALUES (:nama_penanya, :email_penanya, :pertanyaan)";

        $this->db->query($sql);
        
        $this->db->bind(':nama_penanya',  $data['nama_penanya']);
        $this->db->bind(':email_penanya', $data['email_penanya']);
        $this->db->bind(':pertanyaan',    $data['pertanyaan']);

        return $this->db->execute();
    }

    public function updateAnswer($id, $data)
    {
        // Update jawaban admin
        // CURRENT_TIMESTAMP aman digunakan di sini karena bagian dari SET
        $sql = "UPDATE {$this->table} SET 
                    jawaban = :jawaban, 
                    id_admin_penjawab = :id_admin_penjawab, 
                    status_jawaban = :status_jawaban, 
                    tanggal_jawab = CURRENT_TIMESTAMP 
                WHERE id_konsultasi = :id";

        $this->db->query($sql);
        
        $this->db->bind(':jawaban',           $data['jawaban']);
        $this->db->bind(':id_admin_penjawab', $data['id_admin_penjawab'], PDO::PARAM_INT);
        $this->db->bind(':status_jawaban',    $data['status_jawaban']);
        $this->db->bind(':id',                $id, PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id_konsultasi = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->execute();
    }

    /**
     * Mengambil semua konsultasi yang SUDAH DIJAWAB admin.
     * Digunakan untuk halaman publik (Guest).
     */
    public function getAllDijawab()
    {
        // Filter WHERE status_jawaban = 'dijawab'
        // Diurutkan berdasarkan tanggal dijawab terbaru
        $this->db->query("SELECT * FROM {$this->table} WHERE status_jawaban = 'dijawab' ORDER BY tanggal_jawab DESC");
        return $this->db->resultSet();
    }
}