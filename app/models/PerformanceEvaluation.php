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
     * Calculate performance ranking using Hybrid Point System
     * All lab members ranked together based on total points
     * 
     * @param int|null $tahun Filter by year (optional)
     * @return array Ranked list of all pengelola
     */
    public function calculateRanking($tahun = null)
    {
        // Get all data (both categories combined)
        $allData = [];
        $categories = ['Kepala Laboratorium', 'Peneliti'];

        foreach ($categories as $category) {
            $data = $this->getRawDataByCategory($category, $tahun);
            $allData = array_merge($allData, $data);
        }

        if (empty($allData)) {
            return [];
        }

        // Calculate scores using 100-scale
        $withScores = $this->calculatePointScore($allData);

        // No normalization needed - scores are already 0-100
        // Just ensure total_score is set
        foreach ($withScores as &$row) {
            // total_score already set in calculatePointScore
            $row['normalized_score'] = $row['total_score'] / 100; // For compatibility
        }

        // Sort by score DESC
        usort($withScores, function ($a, $b) {
            if ($a['total_score'] == $b['total_score']) {
                return strcmp($a['nama_pengelola'], $b['nama_pengelola']);
            }
            return $b['total_score'] <=> $a['total_score'];
        });

        // Assign ranks
        $rank = 1;
        foreach ($withScores as &$row) {
            $row['rank'] = $rank++;
        }

        return $withScores;
    }

    /**
     * Get raw data for a specific category
     * 
     * @param string $category Kategori jabatan ('Kepala Laboratorium' or 'Peneliti')
     * @param int|null $tahun Filter by year (optional)
     * @return array Raw data with penelitian and pengabdian counts
     */
    private function getRawDataByCategory($category, $tahun = null)
    {
        $sql = "SELECT 
                    p.id_pengelola,
                    p.nama_pengelola,
                    p.foto_pengelola,
                    p.nid_nip,
                    j.nama_jabatan,
                    j.kategori_jabatan,
                    COALESCE(COUNT(DISTINCT CASE WHEN pen.id_penelitian IS NOT NULL THEN pen.id_penelitian END), 0) as c1_penelitian,
                    COALESCE(COUNT(DISTINCT CASE WHEN peng.id_pengabdian IS NOT NULL THEN peng.id_pengabdian END), 0) as c2_pengabdian
                FROM tbl_pengelola p
                LEFT JOIN tbl_jabatan j ON p.id_jabatan = j.id_jabatan
                LEFT JOIN tbl_penelitian_anggota pen_a ON p.id_pengelola = pen_a.id_pengelola
                LEFT JOIN tbl_penelitian pen ON pen_a.id_penelitian = pen.id_penelitian";

        if ($tahun) {
            $sql .= " AND pen.tahun_penelitian = :tahun";
        }

        $sql .= " LEFT JOIN tbl_pengabdian_anggota peng_a ON p.id_pengelola = peng_a.id_pengelola
                  LEFT JOIN tbl_pengabdian peng ON peng_a.id_pengabdian = peng.id_pengabdian";

        if ($tahun) {
            $sql .= " AND peng.tahun_kegiatan = :tahun";
        }

        $sql .= " WHERE j.kategori_jabatan = :category
                  GROUP BY p.id_pengelola, p.nama_pengelola, p.foto_pengelola, p.nid_nip, j.nama_jabatan, j.kategori_jabatan
                  ORDER BY p.nama_pengelola ASC";

        $this->db->query($sql);
        $this->db->bind(':category', $category);
        if ($tahun) {
            $this->db->bind(':tahun', $tahun);
        }

        return $this->db->resultSet();
    }


    /**
     * Calculate scores using 100-scale system
     * Target: 10 penelitian (50 pts) + 10 pengabdian (50 pts) = 100
     * 
     * @param array $data Raw data with c1_penelitian and c2_pengabdian
     * @return array Data with calculated scores
     */
    private function calculatePointScore($data)
    {
        // Target ideal per year
        $target_penelitian = 10;    // 10 projects = 50 points
        $target_pengabdian = 10;    // 10 projects = 50 points
        $max_score_penelitian = 50;
        $max_score_pengabdian = 50;
        $bonus_threshold = 15;      // Bonus if total > 15 projects
        $bonus_points = 5;          // +5 bonus points
        $outstanding_threshold = 15; // Outstanding performance threshold

        foreach ($data as &$row) {
            $total_proyek = $row['c1_penelitian'] + $row['c2_pengabdian'];

            // Calculate scores (max 50 each)
            $skor_penelitian = min(
                ($row['c1_penelitian'] / $target_penelitian) * $max_score_penelitian,
                $max_score_penelitian
            );

            $skor_pengabdian = min(
                ($row['c2_pengabdian'] / $target_pengabdian) * $max_score_pengabdian,
                $max_score_pengabdian
            );

            // Productivity bonus (+5 if total > 15)
            $bonus = ($total_proyek > $bonus_threshold) ? $bonus_points : 0;

            // Total score (capped at 100)
            $total_score = min($skor_penelitian + $skor_pengabdian + $bonus, 100);

            // Outstanding performance flag
            $is_outstanding = ($total_proyek > $outstanding_threshold);

            // Store detailed breakdown
            $row['skor_penelitian'] = round($skor_penelitian, 1);
            $row['skor_pengabdian'] = round($skor_pengabdian, 1);
            $row['bonus_produktivitas'] = $bonus;
            $row['total_poin'] = round($total_score, 1);
            $row['total_score'] = round($total_score, 1);
            $row['is_outstanding'] = $is_outstanding;
            $row['total_proyek'] = $total_proyek;

            // Keep old field names for compatibility
            $row['poin_penelitian'] = round($skor_penelitian, 1);
            $row['poin_pengabdian'] = round($skor_pengabdian, 1);
        }

        return $data;
    }

    /**
     * Normalize scores within a category
     * Formula: Score / MAX(Score in Category)
     * 
     * @param array $data Data with total_poin
     * @return array Normalized data
     */
    private function normalizeByCategory($data)
    {
        if (empty($data)) return $data;

        // Find MAX score within this category only
        $max_poin = max(array_column($data, 'total_poin')) ?: 1;

        foreach ($data as &$row) {
            $row['normalized_score'] = $row['total_poin'] / $max_poin;
            // Keep total_score for backward compatibility with view
            $row['total_score'] = $row['normalized_score'];
            // Keep n_c1 and n_c2 for modal display
            $row['n_c1'] = $row['normalized_score'];
            $row['n_c2'] = $row['normalized_score'];
        }

        return $data;
    }

    /**
     * Assign ranking based on scores
     * 
     * @param array $data Data with normalized_score
     * @return array Ranked data
     */
    private function rankByScore($data)
    {
        // Sort by normalized_score DESC
        usort($data, function ($a, $b) {
            if ($a['normalized_score'] == $b['normalized_score']) {
                return strcmp($a['nama_pengelola'], $b['nama_pengelola']);
            }
            return $b['normalized_score'] <=> $a['normalized_score'];
        });

        // Assign ranks
        $rank = 1;
        foreach ($data as &$row) {
            $row['rank'] = $rank++;
        }

        return $data;
    }


    /**
     * Get count of penelitian for a pengelola (kept for backward compatibility)
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
     * Get count of pengabdian for a pengelola (kept for backward compatibility)
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
