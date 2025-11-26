<?php

class AdminPengabdianController extends Controller
{
    public function __construct()
    {
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    /**
     * INDEX
     */
    public function index()
    {
        $pengabdianModel = $this->model('Pengabdian');

        $data = [
            'judul_halaman'   => 'Pengabdian - Lab NCS',
            'pengabdian_list' => $pengabdianModel->getAll()
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/pengabdian/index', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * CREATE FORM
     */
    public function create()
    {
        $pengelolaModel = $this->model('Pengelola');
        $data['list_pengelola'] = $pengelolaModel->getAll();
        $data['judul_halaman'] = 'Tambah Pengabdian';

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/pengabdian/create', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * STORE
     */
    public function store()
    {
        // 1. Cek Method Request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/pengabdian");
            exit;
        }

        // 2. Ambil & Bersihkan Data Input
        $judul     = trim($_POST['judul_pengabdian'] ?? '');
        $tahun     = trim($_POST['tahun_pengabdian'] ?? '');
        $deskripsi = trim($_POST['deskripsi_kegiatan'] ?? '');

        // PENTING: Ambil array ID Anggota dari select multiple
        // Pastikan di view name-nya adalah "anggota[]"
        $anggota_ids = $_POST['anggota'] ?? [];

        // 3. Validasi Input Data
        if (empty($judul) || empty($tahun) || empty($deskripsi)) {
            $_SESSION['error_message'] = "Judul, Tahun, dan Deskripsi wajib diisi.";
            header("Location: " . BASE_URL . "/admin/pengabdian/create");
            exit;
        }

        // Validasi Anggota Tim (Harus pilih minimal 1)
        if (empty($anggota_ids) || !is_array($anggota_ids)) {
            $_SESSION['error_message'] = "Tim Pengabdi wajib dipilih minimal satu orang.";
            header("Location: " . BASE_URL . "/admin/pengabdian/create");
            exit;
        }

        // 4. Proses Upload File (Menggunakan FileService Anda)
        include_once __DIR__ . '/../services/FileService.php';

        // Cek apakah file ada
        if (empty($_FILES['file_dokumen']['name'])) {
            $_SESSION['error_message'] = "File dokumen laporan wajib diupload.";
            header("Location: " . BASE_URL . "/admin/pengabdian/create");
            exit;
        }

        $file_pdf = FileService::uploadFile($_FILES['file_dokumen'], 'pengabdian', 'pengabdian_');

        if ($file_pdf === false) {
            $_SESSION['error_message'] = "Gagal upload file. Pastikan format PDF/DOC/ZIP dan ukuran <= 5MB.";
            header("Location: " . BASE_URL . "/admin/pengabdian/create");
            exit;
        }

        $payload = [
            'judul_kegiatan'     => $judul,
            'tahun_kegiatan'     => $tahun,
            'deskripsi_kegiatan' => $deskripsi,
            'file_dokumen_pdf'   => $file_pdf,
            'id_admin_pencatat'  => $_SESSION['admin_id'] ?? 1,
            'anggota_ids'        => $anggota_ids
        ];

        $model = $this->model('Pengabdian');
        $ok = $model->insert($payload);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? "Data Pengabdian berhasil ditambahkan." : "Gagal menyimpan data ke database.";

        header("Location: " . BASE_URL . "/admin/pengabdian");
        exit;
    }

    public function edit($id = null)
    {
        if (!$id) {
            header("Location: " . BASE_URL . "/admin/pengabdian");
            exit;
        }

        $pengabdianModel = $this->model('Pengabdian');
        $pengelolaModel = $this->model('Pengelola');

        $row = $pengabdianModel->getById($id);

        if (!$row) {
            $_SESSION['error_message'] = "Data tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/pengabdian");
            exit;
        }

        $all_pengelola = $pengelolaModel->getAll();

        $selected_anggota = $pengabdianModel->getAnggotaIds($id);

        $data = [
            'judul_halaman'    => 'Edit Pengabdian',
            'pengabdian'       => $row,
            'list_pengelola'   => $all_pengelola,
            'selected_anggota' => $selected_anggota
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/pengabdian/edit', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * UPDATE
     */
    /**
     * UPDATE DATA
     */
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/pengabdian");
            exit;
        }

        $model = $this->model('Pengabdian');
        $existing = $model->getById($id);

        if (!$existing) {
            $_SESSION['error_message'] = "Data tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/pengabdian");
            exit;
        }

        // 1. AMBIL DATA INPUT
        $judul     = trim($_POST['judul_pengabdian']);
        $tahun     = trim($_POST['tahun_pengabdian']);
        $deskripsi = trim($_POST['deskripsi_kegiatan']);

        // 2. AMBIL ARRAY ANGGOTA (MULTIPLE SELECT)
        $anggota_ids = $_POST['anggota'] ?? [];

        // 3. VALIDASI
        if (empty($judul) || empty($tahun) || empty($deskripsi)) {
            $_SESSION['error_message'] = "Judul, Tahun, dan Deskripsi wajib diisi.";
            header("Location: " . BASE_URL . "/admin/pengabdian/edit/" . $id);
            exit;
        }

        if (empty($anggota_ids) || !is_array($anggota_ids)) {
            $_SESSION['error_message'] = "Tim Pengabdi wajib dipilih minimal satu orang.";
            header("Location: " . BASE_URL . "/admin/pengabdian/edit/" . $id);
            exit;
        }

        // 4. HANDLE FILE UPLOAD (Ganti file jika ada upload baru)
        include_once __DIR__ . '/../services/FileService.php';

        $file_pdf = $existing['file_dokumen_pdf'];

        if (!empty($_FILES['file_dokumen']['name'])) {
            // replaceFile akan otomatis menghapus file lama jika upload baru sukses
            $newFile = FileService::replaceFile(
                $existing['file_dokumen_pdf'],
                $_FILES['file_dokumen'],
                'pengabdian',
                'pengabdian_'
            );

            if ($newFile !== false) {
                $file_pdf = $newFile;
            } else {
                $_SESSION['error_message'] = "Gagal upload file baru. Cek format & ukuran.";
                header("Location: " . BASE_URL . "/admin/pengabdian/edit/" . $id);
                exit;
            }
        }

        // 5. SIAPKAN PAYLOAD
        $payload = [
            'id_pengabdian'      => $id,
            'judul_kegiatan'     => $judul,
            'tahun_kegiatan'     => $tahun,
            'deskripsi_kegiatan' => $deskripsi,
            'file_dokumen_pdf'   => $file_pdf,
            'anggota_ids'        => $anggota_ids // Array ID anggota baru
        ];

        // 6. UPDATE VIA MODEL
        $ok = $model->update($payload);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? "Pengabdian berhasil diperbarui." : "Gagal memperbarui data.";

        header("Location: " . BASE_URL . "/admin/pengabdian");
        exit;
    }


    /**
     * DELETE DATA
     */
    public function delete($id = null)
    {
        if (!$id) {
            header("Location: " . BASE_URL . "/admin/pengabdian");
            exit;
        }

        $pengabdianModel = $this->model('Pengabdian');
        $existing = $pengabdianModel->getById($id);

        if (!$existing) {
            $_SESSION['error_message'] = 'Data tidak ditemukan.';
            header("Location: " . BASE_URL . "/admin/pengabdian");
            exit;
        }

        // 1. HAPUS FILE FISIK
        include_once __DIR__ . '/../services/FileService.php';
        if (!empty($existing['file_dokumen_pdf'])) {
            FileService::deleteFile($existing['file_dokumen_pdf'], 'pengabdian');
        }

        $ok = $pengabdianModel->delete($id);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? 'Pengabdian berhasil dihapus.' : 'Gagal menghapus data.';

        header("Location: " . BASE_URL . "/admin/pengabdian");
        exit;
    }
}
