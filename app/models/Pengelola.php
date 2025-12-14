<?php

class Pengelola
{

    private $db;

    public function __construct()
    {
        // ✔ HARUS MENGGUNAKAN SINGLETON
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $sql = "SELECT p.*, j.nama_jabatan, j.deskripsi as jabatan_deskripsi
                FROM tbl_pengelola p
                LEFT JOIN tbl_jabatan j ON p.id_jabatan = j.id_jabatan
                ORDER BY p.created_at ASC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    /**
     * Get all pengelola with their keminatan (expertise)
     */
    public function getAllWithKeminatan()
    {
        $sql = "SELECT p.*, j.nama_jabatan, j.deskripsi as jabatan_deskripsi,
                STRING_AGG(k.nama_keminatan, ', ') as keminatan_list
                FROM tbl_pengelola p
                LEFT JOIN tbl_jabatan j ON p.id_jabatan = j.id_jabatan
                LEFT JOIN tbl_pengelola_keminatan pk ON p.id_pengelola = pk.id_pengelola
                LEFT JOIN tbl_keminatan k ON pk.id_keminatan = k.id_keminatan
                GROUP BY p.id_pengelola, j.id_jabatan, j.nama_jabatan, j.deskripsi
                ORDER BY j.id_jabatan ASC, p.created_at ASC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $sql = "SELECT p.*, j.nama_jabatan, j.deskripsi as jabatan_deskripsi
                FROM tbl_pengelola p
                LEFT JOIN tbl_jabatan j ON p.id_jabatan = j.id_jabatan
                WHERE p.id_pengelola = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        return $this->db->single();
    }

    public function insert($data)
    {
        // Convert keminatan array to PostgreSQL array format
        $keminatanArray = !empty($data['keminatan_ids']) ? '{' . implode(',', array_map('intval', $data['keminatan_ids'])) . '}' : NULL;

        // Call stored procedure with individual parameters
        $sql = "SELECT sp_insert_pengelola_with_keminatan(:nama, :nid_nip, :id_jabatan, :foto, :admin, :keminatan::INTEGER[]) AS id_pengelola";

        $this->db->query($sql);
        $this->db->bind(':nama', $data['nama_pengelola']);
        $this->db->bind(':nid_nip', $data['nid_nip'] ?? null);
        $this->db->bind(':id_jabatan', isset($data['id_jabatan']) ? (int)$data['id_jabatan'] : null);
        $this->db->bind(':foto', $data['foto_pengelola']);
        $this->db->bind(':admin', (int)$data['id_admin_pencatat']);
        $this->db->bind(':keminatan', $keminatanArray);

        $result = $this->db->single();
        return $result ? true : false;
    }

    public function update($data)
    {
        // Convert keminatan array to PostgreSQL array format
        $keminatanArray = !empty($data['keminatan_ids']) ? '{' . implode(',', array_map('intval', $data['keminatan_ids'])) . '}' : NULL;

        // Call stored procedure with individual parameters
        $sql = "SELECT sp_update_pengelola_with_keminatan(:id, :nama, :nid_nip, :id_jabatan, :foto, :keminatan::INTEGER[]) AS success";

        $this->db->query($sql);
        $this->db->bind(':id', $data['id_pengelola']);
        $this->db->bind(':nama', $data['nama_pengelola']);
        $this->db->bind(':nid_nip', $data['nid_nip'] ?? null);
        $this->db->bind(':id_jabatan', isset($data['id_jabatan']) ? (int)$data['id_jabatan'] : null);
        $this->db->bind(':foto', $data['foto_pengelola']);
        $this->db->bind(':keminatan', $keminatanArray);

        $result = $this->db->single();
        return $result ? true : false;
    }

    /**
     * Update LinkedIn URL for a pengelola
     */
    public function updateLinkedIn($id_pengelola, $linkedin_url)
    {
        $sql = "UPDATE tbl_pengelola SET linkedin_url = :linkedin_url WHERE id_pengelola = :id";
        $this->db->query($sql);
        $this->db->bind(':linkedin_url', $linkedin_url);
        $this->db->bind(':id', $id_pengelola);
        return $this->db->execute();
    }

    public function delete($id)
    {
        // Call stored procedure for cascade delete
        $sql = "SELECT sp_delete_pengelola_cascade(:id) AS success";
        $this->db->query($sql);
        $this->db->bind(':id', $id);

        $result = $this->db->single();
        return $result ? true : false;
    }

    /**
     * Get keminatan IDs for a specific pengelola
     */
    public function getKeminatanIds($id_pengelola)
    {
        $sql = "SELECT id_keminatan FROM tbl_pengelola_keminatan WHERE id_pengelola = :id_pengelola";
        $this->db->query($sql);
        $this->db->bind(":id_pengelola", $id_pengelola);
        $results = $this->db->resultSet();

        return array_column($results, 'id_keminatan');
    }

    /**
     * Assign keminatan to pengelola (replace all existing)
     */
    public function assignKeminatan($id_pengelola, $keminatan_ids)
    {
        // First, delete all existing keminatan for this pengelola
        $deleteSql = "DELETE FROM tbl_pengelola_keminatan WHERE id_pengelola = :id_pengelola";
        $this->db->query($deleteSql);
        $this->db->bind(":id_pengelola", $id_pengelola);
        $this->db->execute();

        // Then, insert new keminatan
        if (!empty($keminatan_ids) && is_array($keminatan_ids)) {
            $insertSql = "INSERT INTO tbl_pengelola_keminatan (id_pengelola, id_keminatan) VALUES (:id_pengelola, :id_keminatan)";

            foreach ($keminatan_ids as $id_keminatan) {
                $this->db->query($insertSql);
                $this->db->bind(":id_pengelola", $id_pengelola);
                $this->db->bind(":id_keminatan", $id_keminatan);
                $this->db->execute();
            }
        }

        return true;
    }

    /**
     * Get last inserted ID
     */
    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }
}
