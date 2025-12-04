<?php
class Pengabdian
{
    private $db;
    private $table = "tbl_pengabdian";
    private $table_anggota = "tbl_pengabdian_anggota";

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $sql = "SELECT 
                p.*,
                (
                    SELECT STRING_AGG(pe.nama_pengelola, ', ')
                    FROM tbl_pengabdian_anggota pa
                    JOIN tbl_pengelola pe ON pa.id_pengelola = pe.id_pengelola
                    WHERE pa.id_pengabdian = p.id_pengabdian
                ) AS tim_pengabdi,
                (
                    SELECT pe.nama_pengelola
                    FROM tbl_pengabdian_anggota pa
                    JOIN tbl_pengelola pe ON pa.id_pengelola = pe.id_pengelola
                    WHERE pa.id_pengabdian = p.id_pengabdian
                    LIMIT 1
                ) AS first_author
            FROM tbl_pengabdian p
            ORDER BY p.tahun_kegiatan DESC, p.id_pengabdian DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $this->db->query("
            SELECT * FROM {$this->table}
            WHERE id_pengabdian = :id
        ");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Tambahkan method ini di dalam class Pengabdian
    public function getAnggotaIds($id_pengabdian)
    {
        $query = "SELECT id_pengelola FROM tbl_pengabdian_anggota WHERE id_pengabdian = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id_pengabdian);
        
        // Kita ambil result set
        $result = $this->db->resultSet();
        
        // Kita ubah formatnya menjadi array flat sederhana: [1, 5, 8]
        // Agar mudah dicek menggunakan in_array() nanti
        $ids = [];
        foreach ($result as $row) {
            $ids[] = $row['id_pengelola'];
        }
        return $ids;
    }

    public function insert($data)
    {
        // 1. INSERT DATA UTAMA
        // (Perhatikan: kita tidak simpan string nama tim di sini lagi, tapi di tabel anggota)
        $query = "INSERT INTO {$this->table} 
                    (judul_kegiatan, tahun_kegiatan, deskripsi_kegiatan, file_dokumen_pdf, id_admin_pencatat, anggota_luar) 
                  VALUES 
                    (:judul, :tahun, :deskripsi, :file_pdf, :admin, :anggota_luar)";

        $this->db->query($query);
        $this->db->bind(':judul', $data['judul_kegiatan']);
        $this->db->bind(':tahun', $data['tahun_kegiatan']);
        $this->db->bind(':deskripsi', $data['deskripsi_kegiatan']);
        $this->db->bind(':file_pdf', $data['file_dokumen_pdf']);
        $this->db->bind(':admin', $data['id_admin_pencatat']);
        $this->db->bind(':anggota_luar', $data['anggota_luar']);

        // Eksekusi Insert Utama
        if ($this->db->execute()) {

            // 2. AMBIL ID PENGABDIAN YANG BARU DIBUAT
            $id_pengabdian = $this->db->lastInsertId();

            // 3. INSERT KE TABEL PENGHUBUNG (LOOPING)
            // $data['anggota_ids'] adalah Array ID [1, 3, 5]
            if (!empty($data['anggota_ids']) && is_array($data['anggota_ids'])) {
                foreach ($data['anggota_ids'] as $id_pengelola) {
                    $q_anggota = "INSERT INTO {$this->table_anggota} (id_pengabdian, id_pengelola) VALUES (:id_keg, :id_org)";
                    $this->db->query($q_anggota);
                    $this->db->bind(':id_keg', $id_pengabdian);
                    $this->db->bind(':id_org', $id_pengelola);
                    $this->db->execute();
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function update($data)
    {
        $query = "
            UPDATE {$this->table} SET
                judul_kegiatan = :judul,
                tahun_kegiatan = :tahun,
                deskripsi_kegiatan = :deskripsi,
                file_dokumen_pdf = :file_pdf,
                anggota_luar = :anggota_luar
            WHERE id_pengabdian = :id
        ";

        $this->db->query($query);
        $this->db->bind(':judul', $data['judul_kegiatan']);
        $this->db->bind(':tahun', $data['tahun_kegiatan']);
        $this->db->bind(':deskripsi', $data['deskripsi_kegiatan']);
        $this->db->bind(':file_pdf', $data['file_dokumen_pdf']);
        $this->db->bind(':anggota_luar', $data['anggota_luar']);
        $this->db->bind(':id', $data['id_pengabdian']);

        if (!$this->db->execute()) {
            return false; // Gagal update data utama
        }

        $q_delete = "DELETE FROM {$this->table_anggota} WHERE id_pengabdian = :id";
        $this->db->query($q_delete);
        $this->db->bind(':id', $data['id_pengabdian']);
        $this->db->execute();

        if (!empty($data['anggota_ids']) && is_array($data['anggota_ids'])) {
            foreach ($data['anggota_ids'] as $id_pengelola) {
                $q_insert = "INSERT INTO {$this->table_anggota} (id_pengabdian, id_pengelola) VALUES (:id_keg, :id_org)";
                $this->db->query($q_insert);
                $this->db->bind(':id_keg', $data['id_pengabdian']);
                $this->db->bind(':id_org', $id_pengelola);
                $this->db->execute();
            }
        }

        return true;
    }

    public function delete($id)
    {
        $query_anggota = "DELETE FROM {$this->table_anggota} WHERE id_pengabdian = :id";
        $this->db->query($query_anggota);
        $this->db->bind(':id', $id);
        $this->db->execute();

        // 2. HAPUS DATA UTAMA
        $query_utama = "DELETE FROM {$this->table} WHERE id_pengabdian = :id";
        $this->db->query($query_utama);
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
}
