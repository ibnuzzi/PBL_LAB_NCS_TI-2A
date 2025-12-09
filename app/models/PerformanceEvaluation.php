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
     * 
     * @param int|null $tahun Filter by year (optional)
     * @return array Ranked list of pengelola with scores
     */
    public function calculateRanking($tahun = null)
    {
        // Get all pengelola
        $sql = "SELECT 
                    p.id_pengelola,
                    p.nama_pengelola,
                    p.nid_nip,
                    p.foto_pengelola,
                    j.nama_jabatan
                FROM tbl_pengelola p
                LEFT JOIN tbl_jabatan j ON p.id_jabatan = j.id_jabatan
                ORDER BY p.nama_pengelola ASC";
        
        $this->db->query($sql);
        $pengelola_list = $this->db->resultSet();

        if (empty($pengelola_list)) {
            return [];
        }

        // Calculate criteria for each pengelola
        $data = [];
        foreach ($pengelola_list as $pengelola) {
            $id = $pengelola['id_pengelola'];
            
            $data[] = [
                'id_pengelola' => $id,
                'nama_pengelola' => $pengelola['nama_pengelola'],
                'nid_nip' => $pengelola['nid_nip'],
                'foto_pengelola' => $pengelola['foto_pengelola'],
                'nama_jabatan' => $pengelola['nama_jabatan'] ?? '-',
                'c1_penelitian' => $this->getPenelitianCount($id, $tahun),
                'c2_pengabdian' => $this->getPengabdianCount($id, $tahun)
            ];
        }

        // Normalize data using SAW method (Max normalization for Benefit criteria)
        $normalized = $this->normalizeData($data);

        // Calculate final scores with weights
        // Weights: C1 = 50%, C2 = 50%
        $weights = [
            'c1' => 0.50,
            'c2' => 0.50
        ];

        foreach ($normalized as &$row) {
            $row['total_score'] = round(
                ($row['n_c1'] * $weights['c1']) +
                ($row['n_c2'] * $weights['c2']),
                4
            );
        }

        // Sort by total score descending
        usort($normalized, function($a, $b) {
            return $b['total_score'] <=> $a['total_score'];
        });

        // Add ranking
        $rank = 1;
        foreach ($normalized as &$row) {
            $row['rank'] = $rank++;
        }

        return $normalized;
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
