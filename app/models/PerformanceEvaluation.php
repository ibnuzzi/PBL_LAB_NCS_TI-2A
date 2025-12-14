<?php
// File: /app/models/PerformanceEvaluation.php

class PerformanceEvaluation
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Calculate performance ranking using SAW (Simple Additive Weighting) method
     * Uses stored procedure: sp_calculate_performance_ranking
     * 
     * @param int|null $tahun Filter by year (optional)
     * @return array Ranked list of pengelola with scores
     */
    public function calculateRanking($tahun = null)
    {
        // Call stored procedure
        $sql = "SELECT * FROM sp_calculate_performance_ranking(:tahun)";

        $this->db->query($sql);
        $this->db->bind(':tahun', $tahun);

        return $this->db->resultSet();
    }

    /**
     * Get count of penelitian for a pengelola
     */
    private function getPenelitianCount($id_pengelola, $tahun = null)
    {
        if ($tahun) {
            $sql = "SELECT COUNT(*) as total 
                    FROM tbl_penelitian_anggota pa
                    JOIN tbl_penelitian p ON pa.id_penelitian = p.id_penelitian
                    WHERE pa.id_pengelola = :id AND p.tahun_penelitian = :tahun";
            $this->db->query($sql);
            $this->db->bind(':id', $id_pengelola);
            $this->db->bind(':tahun', $tahun);
        } else {
            $sql = "SELECT COUNT(*) as total 
                    FROM tbl_penelitian_anggota 
                    WHERE id_pengelola = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $id_pengelola);
        }

        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    /**
     * Get count of pengabdian for a pengelola
     */
    private function getPengabdianCount($id_pengelola, $tahun = null)
    {
        if ($tahun) {
            $sql = "SELECT COUNT(*) as total 
                    FROM tbl_pengabdian_anggota pa
                    JOIN tbl_pengabdian p ON pa.id_pengabdian = p.id_pengabdian
                    WHERE pa.id_pengelola = :id AND p.tahun_kegiatan = :tahun";
            $this->db->query($sql);
            $this->db->bind(':id', $id_pengelola);
            $this->db->bind(':tahun', $tahun);
        } else {
            $sql = "SELECT COUNT(*) as total 
                    FROM tbl_pengabdian_anggota 
                    WHERE id_pengelola = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $id_pengelola);
        }

        $result = $this->db->single();
        return $result['total'] ?? 0;
    }



    /**
     * Normalize data using Max normalization (for Benefit criteria)
     * Formula: Rij = Xij / Max(Xij)
     */
    private function normalizeData($data)
    {
        // Find max values for each criterion
        $max_c1 = max(array_column($data, 'c1_penelitian')) ?: 1;
        $max_c2 = max(array_column($data, 'c2_pengabdian')) ?: 1;

        // Normalize each row
        foreach ($data as &$row) {
            $row['n_c1'] = $row['c1_penelitian'] / $max_c1;
            $row['n_c2'] = $row['c2_pengabdian'] / $max_c2;
        }

        return $data;
    }

    /**
     * Get available years from penelitian and pengabdian
     */
    public function getAvailableYears()
    {
        $sql = "SELECT DISTINCT tahun_penelitian as tahun 
                FROM tbl_penelitian 
                UNION 
                SELECT DISTINCT tahun_kegiatan as tahun 
                FROM tbl_pengabdian 
                ORDER BY tahun DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }
}
