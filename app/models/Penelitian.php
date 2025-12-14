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
                ) AS peneliti,
                (
                    SELECT pe.nama_pengelola
                    FROM tbl_penelitian_anggota pa
                    JOIN tbl_pengelola pe ON pa.id_pengelola = pe.id_pengelola
                    WHERE pa.id_penelitian = p.id_penelitian
                    LIMIT 1
                ) AS first_author
            FROM tbl_penelitian p
            ORDER BY p.tahun_penelitian DESC, p.id_penelitian DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getLatest($limit)
    {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY created_at DESC, id_penelitian DESC LIMIT :limit");
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
        // Convert peneliti array to PostgreSQL array format
        $penelitiArray = !empty($data['peneliti']) ? '{' . implode(',', array_map('intval', $data['peneliti'])) . '}' : NULL;

        // Call stored procedure with individual parameters
        $sql = "SELECT sp_insert_penelitian(:judul, :tahun, :deskripsi, :link, :file, :anggota_luar, :peneliti::INTEGER[]) AS id_penelitian";

        $this->db->query($sql);
        $this->db->bind(':judul', $data['judul_penelitian']);
        $this->db->bind(':tahun', (int)$data['tahun_penelitian']);
        $this->db->bind(':deskripsi', $data['deskripsi_singkat']);
        $this->db->bind(':link', $data['link_publikasi']);
        $this->db->bind(':file', $data['file_dokumen_pdf']);
        $this->db->bind(':anggota_luar', $data['anggota_luar'] ?? null);
        $this->db->bind(':peneliti', $penelitiArray);

        $result = $this->db->single();
        return $result ? true : false;
    }

    // Update an existing penelitian record
    public function update($id, $data)
    {
        // Convert peneliti array to PostgreSQL array format
        $penelitiArray = !empty($data['peneliti']) ? '{' . implode(',', array_map('intval', $data['peneliti'])) . '}' : NULL;

        // Call stored procedure with individual parameters
        $sql = "SELECT sp_update_penelitian(:id, :judul, :tahun, :deskripsi, :link, :file, :anggota_luar, :peneliti::INTEGER[]) AS success";

        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':judul', $data['judul_penelitian']);
        $this->db->bind(':tahun', (int)$data['tahun_penelitian']);
        $this->db->bind(':deskripsi', $data['deskripsi_singkat']);
        $this->db->bind(':link', $data['link_publikasi']);
        $this->db->bind(':file', $data['file_dokumen_pdf']);
        $this->db->bind(':anggota_luar', $data['anggota_luar'] ?? null);
        $this->db->bind(':peneliti', $penelitiArray);

        $result = $this->db->single();
        return $result ? true : false;
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

    // Get total count of penelitian
    public function getTotalCount()
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        $result = $this->db->single();
        return $result ? (int)$result['total'] : 0;
    }
}
