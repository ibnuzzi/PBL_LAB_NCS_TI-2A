<?php
// File: /app/models/JasaLayanan.php

class JasaLayanan
{
    private $db;
    private $table = "tbl_layanan"; // pastikan ini sesuai dengan nama tabel di DB-mu

    public function __construct()
    {
        // pakai singleton Database seperti model lain (misal Berita)
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY id_layanan DESC");
        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE id_layanan = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} 
            (nama_layanan, deskripsi_layanan, icon_layanan, id_admin_pencatat) 
            VALUES (:nama_layanan, :deskripsi_layanan, :icon_layanan, :id_admin_pencatat)";

        $this->db->query($sql);
        $this->db->bind(':nama_layanan',      $data['nama_layanan']);
        $this->db->bind(':deskripsi_layanan', $data['deskripsi_layanan']);
        $this->db->bind(':icon_layanan',      $data['icon_layanan']);
        $this->db->bind(':id_admin_pencatat', $data['id_admin_pencatat'], PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET
                    nama_layanan      = :nama_layanan,
                    deskripsi_layanan = :deskripsi_layanan,
                    icon_layanan      = :icon_layanan,
                    updated_at        = NOW()
                WHERE id_layanan = :id";

        $this->db->query($sql);
        $this->db->bind(':nama_layanan',      $data['nama_layanan']);
        $this->db->bind(':deskripsi_layanan', $data['deskripsi_layanan']);
        $this->db->bind(':icon_layanan',      $data['icon_layanan']);
        $this->db->bind(':id',                $id, PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id_layanan = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->execute();
    }
}
