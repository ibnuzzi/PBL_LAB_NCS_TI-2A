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
     * 
     * @param array $keminatan_ids Array of required keminatan IDs
     * @return array Ranked list of candidates with match scores
     */
    public function findCandidates($keminatan_ids)
    {
        if (empty($keminatan_ids) || !is_array($keminatan_ids)) {
            return [];
        }

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

        $candidates = [];

        foreach ($pengelola_list as $pengelola) {
            $id = $pengelola['id_pengelola'];
            
            // Get pengelola's keminatan
            $pengelola_keminatan = $this->getPengelolaKeminatan($id);
            
            // Calculate match score
            $match_score = $this->calculateMatchScore($pengelola_keminatan, $keminatan_ids);
            
            // Get workload (current year)
            $workload = $this->getWorkload($id);
            
            // Apply workload modifier
            $final_score = $match_score;
            if ($workload > 5) {
                $final_score -= 20; // Penalty for high workload
            }

            // Get keminatan names as string
            $keminatan_names = $this->getKeminatanNames($pengelola_keminatan);

            $candidates[] = [
                'id_pengelola' => $id,
                'nama_pengelola' => $pengelola['nama_pengelola'],
                'nid_nip' => $pengelola['nid_nip'],
                'foto_pengelola' => $pengelola['foto_pengelola'],
                'nama_jabatan' => $pengelola['nama_jabatan'] ?? '-',
                'keminatan' => $keminatan_names,
                'keminatan_count' => count($pengelola_keminatan),
                'match_count' => $this->countMatches($pengelola_keminatan, $keminatan_ids),
                'workload' => $workload,
                'match_score' => $match_score,
                'final_score' => max(0, $final_score) // Ensure non-negative
            ];
        }

        // Sort by final score descending
        usort($candidates, function($a, $b) {
            return $b['final_score'] <=> $a['final_score'];
        });

        // Add ranking
        $rank = 1;
        foreach ($candidates as &$candidate) {
            $candidate['rank'] = $rank++;
        }

        return $candidates;
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
}
