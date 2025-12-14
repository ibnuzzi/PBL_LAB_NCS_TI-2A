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
        // Convert anggota array to PostgreSQL array format
        $anggotaArray = !empty($data['anggota_ids']) ? '{' . implode(',', array_map('intval', $data['anggota_ids'])) . '}' : NULL;

        // Call stored procedure with individual parameters
        $sql = "SELECT sp_insert_pengabdian(:judul, :tahun, :deskripsi, :file, :admin, :anggota_luar, :anggota::INTEGER[]) AS id_pengabdian";

        $this->db->query($sql);
        $this->db->bind(':judul', $data['judul_kegiatan']);
        $this->db->bind(':tahun', (int)$data['tahun_kegiatan']);
        $this->db->bind(':deskripsi', $data['deskripsi_kegiatan']);
        $this->db->bind(':file', $data['file_dokumen_pdf']);
        $this->db->bind(':admin', (int)$data['id_admin_pencatat']);
        $this->db->bind(':anggota_luar', $data['anggota_luar'] ?? null);
        $this->db->bind(':anggota', $anggotaArray);

        $result = $this->db->single();
        return $result ? true : false;
    }

    public function update($data)
    {
        // Convert anggota array to PostgreSQL array format
        $anggotaArray = !empty($data['anggota_ids']) ? '{' . implode(',', array_map('intval', $data['anggota_ids'])) . '}' : NULL;

        // Call stored procedure with individual parameters
        $sql = "SELECT sp_update_pengabdian(:id, :judul, :tahun, :deskripsi, :file, :anggota_luar, :anggota::INTEGER[]) AS success";

        $this->db->query($sql);
        $this->db->bind(':id', $data['id_pengabdian']);
        $this->db->bind(':judul', $data['judul_kegiatan']);
        $this->db->bind(':tahun', (int)$data['tahun_kegiatan']);
        $this->db->bind(':deskripsi', $data['deskripsi_kegiatan']);
        $this->db->bind(':file', $data['file_dokumen_pdf']);
        $this->db->bind(':anggota_luar', $data['anggota_luar'] ?? null);
        $this->db->bind(':anggota', $anggotaArray);

        $result = $this->db->single();
        return $result ? true : false;
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

    // Get latest pengabdian for homepage
    public function getLatest($limit = 3)
    {
        $sql = "SELECT 
                p.*,
                (
                    SELECT pe.nama_pengelola
                    FROM tbl_pengabdian_anggota pa
                    JOIN tbl_pengelola pe ON pa.id_pengelola = pe.id_pengelola
                    WHERE pa.id_pengabdian = p.id_pengabdian
                    LIMIT 1
                ) AS first_author
            FROM tbl_pengabdian p
            ORDER BY p.tahun_kegiatan DESC, p.id_pengabdian DESC
            LIMIT :limit";

        $this->db->query($sql);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    // Get total count of pengabdian
    public function getTotalCount()
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        $result = $this->db->single();
        return $result ? (int)$result['total'] : 0;
    }
}
