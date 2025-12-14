<?php
// File: /app/models/TeamRecommendation.php

class TeamRecommendation
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Find candidates based on keminatan using Profile Matching
     * Uses stored procedure: sp_find_team_candidates
     * 
     * @param array $keminatan_ids Array of required keminatan IDs
     * @return array Ranked list of candidates with match scores
     */
    public function findCandidates($keminatan_ids)
    {
        if (empty($keminatan_ids) || !is_array($keminatan_ids)) {
            return [];
        }

        // Convert PHP array to PostgreSQL array format
        $pgArray = '{' . implode(',', array_map('intval', $keminatan_ids)) . '}';

        // Call stored procedure
        $sql = "SELECT * FROM sp_find_team_candidates(:keminatan_ids::INTEGER[])";

        $this->db->query($sql);
        $this->db->bind(':keminatan_ids', $pgArray);

        return $this->db->resultSet();
    }

    /**
     * Get keminatan IDs for a pengelola
     */
    private function getPengelolaKeminatan($id_pengelola)
    {
        $sql = "SELECT id_keminatan 
                FROM tbl_pengelola_keminatan 
                WHERE id_pengelola = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $id_pengelola);
        $results = $this->db->resultSet();

        return array_column($results, 'id_keminatan');
    }

    /**
     * Calculate match score using Profile Matching (Gap Analysis)
     * Perfect match: 100 points per matching keminatan
     */
    private function calculateMatchScore($pengelola_keminatan, $required_keminatan)
    {
        $matches = array_intersect($pengelola_keminatan, $required_keminatan);
        $match_count = count($matches);
        $required_count = count($required_keminatan);

        if ($required_count === 0) {
            return 0;
        }

        // Score = (matched / required) * 100
        $score = ($match_count / $required_count) * 100;

        return round($score, 2);
    }

    /**
     * Count how many keminatan match
     */
    private function countMatches($pengelola_keminatan, $required_keminatan)
    {
        $matches = array_intersect($pengelola_keminatan, $required_keminatan);
        return count($matches);
    }

    /**
     * Get workload: count active penelitian + pengabdian in current year
     */
    private function getWorkload($id_pengelola)
    {
        $current_year = date('Y');

        // Count penelitian
        $sql1 = "SELECT COUNT(*) as total 
                 FROM tbl_penelitian_anggota pa
                 JOIN tbl_penelitian p ON pa.id_penelitian = p.id_penelitian
                 WHERE pa.id_pengelola = :id AND p.tahun_penelitian = :tahun";

        $this->db->query($sql1);
        $this->db->bind(':id', $id_pengelola);
        $this->db->bind(':tahun', $current_year);
        $penelitian = $this->db->single();

        // Count pengabdian
        $sql2 = "SELECT COUNT(*) as total 
                 FROM tbl_pengabdian_anggota pa
                 JOIN tbl_pengabdian p ON pa.id_pengabdian = p.id_pengabdian
                 WHERE pa.id_pengelola = :id AND p.tahun_kegiatan = :tahun";

        $this->db->query($sql2);
        $this->db->bind(':id', $id_pengelola);
        $this->db->bind(':tahun', $current_year);
        $pengabdian = $this->db->single();

        return ($penelitian['total'] ?? 0) + ($pengabdian['total'] ?? 0);
    }

    /**
     * Get keminatan names as comma-separated string
     */
    private function getKeminatanNames($keminatan_ids)
    {
        if (empty($keminatan_ids)) {
            return '-';
        }

        $placeholders = implode(',', array_fill(0, count($keminatan_ids), '?'));
        $sql = "SELECT nama_keminatan 
                FROM tbl_keminatan 
                WHERE id_keminatan IN ($placeholders)
                ORDER BY nama_keminatan ASC";

        $this->db->query($sql);

        // Bind each ID
        foreach ($keminatan_ids as $index => $id) {
            $this->db->bind($index + 1, $id);
        }

        $results = $this->db->resultSet();
        $names = array_column($results, 'nama_keminatan');

        return implode(', ', $names);
    }

    /**
     * Get all keminatan for dropdown
     */
    public function getAllKeminatan()
    {
        $sql = "SELECT id_keminatan, nama_keminatan, deskripsi 
                FROM tbl_keminatan 
                ORDER BY nama_keminatan ASC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    /**
     * Get workload distribution for dashboard chart
     * Returns count of researchers by workload category
     */
    public function getWorkloadDistribution()
    {
        $current_year = date('Y');

        // Get all pengelola with their workloads
        $sql = "SELECT p.id_pengelola, p.nama_pengelola
                FROM tbl_pengelola p
                ORDER BY p.nama_pengelola ASC";

        $this->db->query($sql);
        $pengelola_list = $this->db->resultSet();

        $distribution = [
            'ringan' => 0,  // 0-3 proyek
            'sedang' => 0,  // 4-5 proyek
            'tinggi' => 0   // >5 proyek
        ];

        foreach ($pengelola_list as $pengelola) {
            $workload = $this->getWorkload($pengelola['id_pengelola']);

            if ($workload <= 3) {
                $distribution['ringan']++;
            } elseif ($workload <= 5) {
                $distribution['sedang']++;
            } else {
                $distribution['tinggi']++;
            }
        }

        return $distribution;
    }

    /**
     * Get top 5 most popular keminatan
     * Returns keminatan ranked by number of researchers
     */
    public function getTopKeminatan($limit = 5)
    {
        $sql = "SELECT 
                    k.id_keminatan,
                    k.nama_keminatan,
                    COUNT(pk.id_pengelola) as jumlah_peneliti
                FROM tbl_keminatan k
                LEFT JOIN tbl_pengelola_keminatan pk ON k.id_keminatan = pk.id_keminatan
                GROUP BY k.id_keminatan, k.nama_keminatan
                ORDER BY jumlah_peneliti DESC, k.nama_keminatan ASC
                LIMIT :limit";

        $this->db->query($sql);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }
}
