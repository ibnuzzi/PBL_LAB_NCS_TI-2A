<?php
// File: /app/models/Konsultasi.php

class Konsultasi
{
    private $db;
    private $table = "tbl_konsultasi";

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
        // Insert with explicit 'menunggu' status for approval workflow
        // Column 'tanggal_tanya' will use CURRENT_TIMESTAMP (Default DB)

        $sql = "INSERT INTO {$this->table} (nama_penanya, email_penanya, pertanyaan, status_jawaban) 
                VALUES (:nama_penanya, :email_penanya, :pertanyaan, 'menunggu')";

        $this->db->query($sql);

        $this->db->bind(':nama_penanya',  $data['nama_penanya']);
        $this->db->bind(':email_penanya', $data['email_penanya']);
        $this->db->bind(':pertanyaan',    $data['pertanyaan']);

        return $this->db->execute();
    }

    public function updateAnswer($id, $data)
    {
        // Update jawaban admin (legacy method - still used by old code)
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
     * Mengambil semua konsultasi yang SUDAH DITERIMA dan DIJAWAB admin.
     * Digunakan untuk halaman publik (Guest).
     */
    public function getAllDijawab()
    {
        // Filter WHERE status_jawaban = 'diterima'
        // Diurutkan berdasarkan tanggal dijawab terbaru
        $this->db->query("SELECT * FROM {$this->table} WHERE status_jawaban = 'diterima' ORDER BY tanggal_jawab DESC");
        return $this->db->resultSet();
    }

    /**
     * Mengambil konsultasi dijawab dengan pagination
     */
    public function getPaginatedDijawab($limit, $offset)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE status_jawaban = 'diterima' ORDER BY tanggal_jawab DESC LIMIT :limit OFFSET :offset");
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    /**
     * Menghitung total konsultasi yang sudah dijawab
     */
    public function countDijawab()
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE status_jawaban = 'diterima'");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    /**
     * Accept consultation and provide answer
     * 
     * @param int $id Consultation ID
     * @param string $jawaban Admin's answer
     * @param int $id_admin_penjawab Admin ID who answered
     * @return bool Success status
     */
    public function updateStatusAccept($id, $jawaban, $id_admin_penjawab)
    {
        $sql = "UPDATE {$this->table} SET 
                    jawaban = :jawaban, 
                    id_admin_penjawab = :id_admin_penjawab, 
                    status_jawaban = 'diterima', 
                    tanggal_jawab = CURRENT_TIMESTAMP 
                WHERE id_konsultasi = :id";

        $this->db->query($sql);

        $this->db->bind(':jawaban',           $jawaban);
        $this->db->bind(':id_admin_penjawab', $id_admin_penjawab, PDO::PARAM_INT);
        $this->db->bind(':id',                $id, PDO::PARAM_INT);

        return $this->db->execute();
    }

    /**
     * Reject consultation with reason
     * 
     * @param int $id Consultation ID
     * @param string $alasan_tolak Rejection reason
     * @param int $id_admin_penjawab Admin ID who rejected
     * @return bool Success status
     */
    public function updateStatusReject($id, $alasan_tolak, $id_admin_penjawab)
    {
        $sql = "UPDATE {$this->table} SET 
                    alasan_tolak = :alasan_tolak,
                    id_admin_penjawab = :id_admin_penjawab, 
                    status_jawaban = 'ditolak', 
                    tanggal_jawab = CURRENT_TIMESTAMP 
                WHERE id_konsultasi = :id";

        $this->db->query($sql);

        $this->db->bind(':alasan_tolak',      $alasan_tolak);
        $this->db->bind(':id_admin_penjawab', $id_admin_penjawab, PDO::PARAM_INT);
        $this->db->bind(':id',                $id, PDO::PARAM_INT);

        return $this->db->execute();
    }
}
