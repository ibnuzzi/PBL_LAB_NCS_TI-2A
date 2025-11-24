<?php

class Sarana
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $this->db->query("SELECT * FROM tbl_sarana_prasarana ORDER BY id_sarana DESC");
        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $this->db->query("SELECT * FROM tbl_sarana_prasarana WHERE id_sarana = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function insert($data)
    {
        $this->db->query("
            INSERT INTO tbl_sarana_prasarana 
            (nama_sarana, deskripsi_sarana, foto_sarana, jumlah, kondisi, id_admin_pencatat)
            VALUES (:nama, :deskripsi, :foto, :jumlah, :kondisi, :admin)
        ");

        $this->db->bind(':nama',      $data['nama']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':foto',      $data['foto']);
        $this->db->bind(':jumlah',    $data['jumlah']);
        $this->db->bind(':kondisi',   $data['kondisi']);
        $this->db->bind(':admin',     $data['admin']);

        return $this->db->execute();
    }

    public function update($id, $data)
    {
        $this->db->query("
            UPDATE tbl_sarana_prasarana SET
                nama_sarana = :nama,
                deskripsi_sarana = :deskripsi,
                foto_sarana = :foto,
                jumlah = :jumlah,
                kondisi = :kondisi
            WHERE id_sarana = :id
        ");

        $this->db->bind(':nama',      $data['nama']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':foto',      $data['foto']);
        $this->db->bind(':jumlah',    $data['jumlah']);
        $this->db->bind(':kondisi',   $data['kondisi']);
        $this->db->bind(':id',        $id);

        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM tbl_sarana_prasarana WHERE id_sarana = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}