<?php
// File: /app/models/Agenda.php

class Agenda {
    private $db;
    private $table = 'tbl_agenda';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllAgenda() {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY tanggal_mulai DESC");
        return $this->db->resultSet();
    }

    public function getAgendaById($id) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id_agenda = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    public function tambahAgenda($data) {
        $query = "INSERT INTO " . $this->table . "
                    (nama_agenda, lokasi, gambar_agenda, id_admin_penulis, tanggal_mulai, tanggal_selesai)
                  VALUES
                    (:nama, :lokasi, :gambar, :id_admin, :tanggal_mulai, :tanggal_selesai)";

        $this->db->query($query);
        $this->db->bind(':nama', $data['nama_agenda']);
        $this->db->bind(':lokasi', $data['lokasi']);
        $this->db->bind(':gambar', $data['gambar_agenda']);
        $this->db->bind(':id_admin', $data['id_admin_penulis'], PDO::PARAM_INT);
        $this->db->bind(':tanggal_mulai', $data['tanggal_mulai']);
        $this->db->bind(':tanggal_selesai', $data['tanggal_selesai']);

        return $this->db->execute();
    }

    public function updateAgenda($data) {
        $query = "UPDATE " . $this->table . " SET
                    nama_agenda = :nama,
                    lokasi = :lokasi,
                    gambar_agenda = :gambar,
                    tanggal_mulai = :tanggal_mulai,
                    tanggal_selesai = :tanggal_selesai
                  WHERE id_agenda = :id";

        $this->db->query($query);
        $this->db->bind(':nama', $data['nama_agenda']);
        $this->db->bind(':lokasi', $data['lokasi']);
        $this->db->bind(':gambar', $data['gambar_agenda']);
        $this->db->bind(':tanggal_mulai', $data['tanggal_mulai']);
        $this->db->bind(':tanggal_selesai', $data['tanggal_selesai']);
        $this->db->bind(':id', $data['id_agenda'], PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function hapusAgenda($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_agenda = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->execute();
    }
}

?>