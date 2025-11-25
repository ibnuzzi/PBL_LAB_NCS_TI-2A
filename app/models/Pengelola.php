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
        $sql = "SELECT * FROM tbl_pengelola ORDER BY urutan ASC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM tbl_pengelola WHERE id_pengelola = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        return $this->db->single();
    }

    public function insert($data)
    {
        $sql = "INSERT INTO tbl_pengelola
                (nama_pengelola, jabatan, foto_pengelola, urutan, id_admin_pencatat)
                VALUES (:nama, :jabatan, :foto, :urutan, :admin)";

        $this->db->query($sql);
        $this->db->bind(":nama", $data['nama_pengelola']);
        $this->db->bind(":jabatan", $data['jabatan']);
        $this->db->bind(":foto", $data['foto_pengelola']);
        $this->db->bind(":urutan", $data['urutan']);
        $this->db->bind(":admin", $data['id_admin_pencatat']);

        return $this->db->execute();
    }

    public function update($data)
    {
        $sql = "UPDATE tbl_pengelola SET
                    nama_pengelola = :nama,
                    jabatan = :jabatan,
                    foto_pengelola = :foto,
                    urutan = :urutan
                WHERE id_pengelola = :id";

        $this->db->query($sql);
        $this->db->bind(":nama", $data['nama_pengelola']);
        $this->db->bind(":jabatan", $data['jabatan']);
        $this->db->bind(":foto", $data['foto_pengelola']);
        $this->db->bind(":urutan", $data['urutan']);
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
}
