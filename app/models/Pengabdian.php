<?php
class Pengabdian {
    private $db;
    private $table = "tbl_pengabdian";

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        $this->db->query("
            SELECT * FROM {$this->table}
            ORDER BY tahun_kegiatan DESC, id_pengabdian DESC
        ");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("
            SELECT * FROM {$this->table}
            WHERE id_pengabdian = :id
        ");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function insert($data) {
        $query = "
            INSERT INTO {$this->table}
                (judul_kegiatan, tim_pengabdi, tahun_kegiatan, deskripsi_kegiatan, file_dokumen_pdf, id_admin_pencatat)
            VALUES
                (:judul, :tim, :tahun, :deskripsi, :file_pdf, :admin)
        ";

        $this->db->query($query);
        $this->db->bind(':judul', $data['judul_kegiatan']);
        $this->db->bind(':tim', $data['tim_pengabdi']);
        $this->db->bind(':tahun', $data['tahun_kegiatan']);
        $this->db->bind(':deskripsi', $data['deskripsi_kegiatan']);
        $this->db->bind(':file_pdf', $data['file_dokumen_pdf']);
        $this->db->bind(':admin', $data['id_admin_pencatat']);

        return $this->db->execute();
    }

    public function update($data) {
        $query = "
            UPDATE {$this->table} SET
                judul_kegiatan = :judul,
                tim_pengabdi = :tim,
                tahun_kegiatan = :tahun,
                deskripsi_kegiatan = :deskripsi,
                file_dokumen_pdf = :file_pdf
            WHERE id_pengabdian = :id
        ";

        $this->db->query($query);
        $this->db->bind(':judul', $data['judul_kegiatan']);
        $this->db->bind(':tim', $data['tim_pengabdi']);
        $this->db->bind(':tahun', $data['tahun_kegiatan']);
        $this->db->bind(':deskripsi', $data['deskripsi_kegiatan']);
        $this->db->bind(':file_pdf', $data['file_dokumen_pdf']);
        $this->db->bind(':id', $data['id_pengabdian']);

        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->query("DELETE FROM {$this->table} WHERE id_pengabdian = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
?>
