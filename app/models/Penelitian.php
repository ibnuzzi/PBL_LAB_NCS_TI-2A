<?php
// File: /app/models/Penelitian.php

class Penelitian
{
    private $db;
    private $table = "tbl_penelitian";
    private $table_anggota = "tbl_penelitian_anggota";

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $sql = "SELECT 
                p.*,
                (
                    SELECT STRING_AGG(pe.nama_pengelola, ', ')
                    FROM tbl_penelitian_anggota pa
                    JOIN tbl_pengelola pe ON pa.id_pengelola = pe.id_pengelola
                    WHERE pa.id_penelitian = p.id_penelitian
                ) AS peneliti
            FROM tbl_penelitian p
            ORDER BY p.tahun_penelitian DESC, p.id_penelitian DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getLatest($limit)
    {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY tahun_penelitian DESC LIMIT :limit");
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    // Get a single penelitian record by its ID
    public function getById($id)
    {
        $this->db->query("SELECT * FROM tbl_penelitian WHERE id_penelitian = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function insert($data)
    {
        // 1. INSERT UTAMA
        $query = "INSERT INTO {$this->table} 
                    (judul_penelitian, tahun_penelitian, deskripsi_singkat, link_publikasi, file_dokumen_pdf, created_at) 
                  VALUES 
                    (:judul, :tahun, :deskripsi, :link, :file_pdf, NOW())";

        $this->db->query($query);
        $this->db->bind(':judul', $data['judul_penelitian']);
        $this->db->bind(':tahun', $data['tahun_penelitian']);
        $this->db->bind(':deskripsi', $data['deskripsi_singkat']);
        $this->db->bind(':link', $data['link_publikasi']);
        $this->db->bind(':file_pdf', $data['file_dokumen_pdf']);

        if ($this->db->execute()) {

            // 2. AMBIL ID BARU
            $id_penelitian = $this->db->lastInsertId();

            // 3. INSERT KE TABEL ANGGOTA
            if (!empty($data['peneliti']) && is_array($data['peneliti'])) {
                foreach ($data['peneliti'] as $id_pengelola) {
                    $q_anggota = "INSERT INTO {$this->table_anggota} (id_penelitian, id_pengelola) VALUES (:id_pen, :id_org)";
                    $this->db->query($q_anggota);
                    $this->db->bind(':id_pen', $id_penelitian);
                    $this->db->bind(':id_org', $id_pengelola);
                    $this->db->execute();
                }
            }
            return true;
        }
        return false;
    }

    // Update an existing penelitian record
    public function update($id, $data)
    {
        // 1. UPDATE DATA UTAMA
        $this->db->query("
            UPDATE tbl_penelitian SET
                judul_penelitian = :judul_penelitian,
                tahun_penelitian = :tahun_penelitian,
                deskripsi_singkat = :deskripsi_singkat,
                link_publikasi = :link_publikasi,
                file_dokumen_pdf = :file_pdf,
                updated_at = NOW()
            WHERE id_penelitian = :id
        ");
        $this->db->bind(':judul_penelitian', $data['judul_penelitian']);
        $this->db->bind(':tahun_penelitian', $data['tahun_penelitian']);
        $this->db->bind(':deskripsi_singkat', $data['deskripsi_singkat']);
        $this->db->bind(':link_publikasi', $data['link_publikasi']);
        $this->db->bind(':file_pdf', $data['file_dokumen_pdf']);
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            // 2. HAPUS ANGGOTA LAMA
            $this->db->query("DELETE FROM {$this->table_anggota} WHERE id_penelitian = :id_penelitian");
            $this->db->bind(':id_penelitian', $id);
            $this->db->execute();

            // 3. INSERT ANGGOTA BARU
            if (!empty($data['peneliti']) && is_array($data['peneliti'])) {
                foreach ($data['peneliti'] as $id_pengelola) {
                    $q_anggota = "INSERT INTO {$this->table_anggota} (id_penelitian, id_pengelola) VALUES (:id_pen, :id_org)";
                    $this->db->query($q_anggota);
                    $this->db->bind(':id_pen', $id);
                    $this->db->bind(':id_org', $id_pengelola);
                    $this->db->execute();
                }
            }
            return true;
        }
        return false;
    }


    // Get Tim Peneliti IDs for edit form
    public function getTimPenelitiIds($id_penelitian)
    {
        $this->db->query("SELECT id_pengelola FROM {$this->table_anggota} WHERE id_penelitian = :id");
        $this->db->bind(':id', $id_penelitian);
        $results = $this->db->resultSet();

        // Return array of IDs
        $ids = [];
        foreach ($results as $row) {
            $ids[] = $row['id_pengelola'];
        }
        return $ids;
    }

    // Delete a penelitian
    public function delete($id)
    {
        $this->db->query("DELETE FROM tbl_penelitian WHERE id_penelitian = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
