<?php

class Pengelola {

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
        $sql = "INSERT INTO tbl_pengelola
                (nama_pengelola, nid_nip, id_jabatan, foto_pengelola, id_admin_pencatat)
                VALUES (:nama, :nid_nip, :id_jabatan, :foto, :admin)";

        $this->db->query($sql);
        $this->db->bind(":nama", $data['nama_pengelola']);
        $this->db->bind(":nid_nip", $data['nid_nip'] ?? null);
        $this->db->bind(":id_jabatan", $data['id_jabatan'] ?? null);
        $this->db->bind(":foto", $data['foto_pengelola']);
        $this->db->bind(":admin", $data['id_admin_pencatat']);

        return $this->db->execute();
    }

    public function update($data)
    {
        $sql = "UPDATE tbl_pengelola SET
                    nama_pengelola = :nama,
                    nid_nip = :nid_nip,
                    id_jabatan = :id_jabatan,
                    foto_pengelola = :foto
                WHERE id_pengelola = :id";

        $this->db->query($sql);
        $this->db->bind(":nama", $data['nama_pengelola']);
        $this->db->bind(":nid_nip", $data['nid_nip'] ?? null);
        $this->db->bind(":id_jabatan", $data['id_jabatan'] ?? null);
        $this->db->bind(":foto", $data['foto_pengelola']);
        $this->db->bind(":id", $data['id_pengelola']);

        return $this->db->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM tbl_pengelola WHERE id_pengelola = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        return $this->db->execute();
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

