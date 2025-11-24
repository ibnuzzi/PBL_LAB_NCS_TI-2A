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
        $data = ['judul_halaman' => 'Tambah Pengabdian'];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/pengabdian/create', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * STORE
     */
     public function store()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . BASE_URL . "/admin/pengabdian");
        exit;
    }

    $judul      = trim($_POST['judul_pengabdian']);
    $tim        = trim($_POST['tim_pengabdi']);
    $tahun      = trim($_POST['tahun_pengabdian']);
    $deskripsi  = trim($_POST['deskripsi_kegiatan']);

    if ($judul == "" || $tim == "" || $tahun == "" || $deskripsi == "") {
        $_SESSION['error_message'] = "Semua field wajib diisi.";
        header("Location: " . BASE_URL . "/admin/pengabdian/create");
        exit;
    }

    include_once __DIR__ . '/../services/FileService.php';

    // Upload file
    $file_pdf = FileService::uploadFile($_FILES['file_dokumen'], 'pengabdian', 'pengabdian_');

    if ($file_pdf === false) {
        $_SESSION['error_message'] = "Gagal upload file. File harus PDF/DOC/DOCX/ZIP dan <= 5MB.";
        header("Location: " . BASE_URL . "/admin/pengabdian/create");
        exit;
    }

    $model = $this->model('Pengabdian');

    $payload = [
        'judul_kegiatan'     => $judul,
        'tim_pengabdi'       => $tim,
        'tahun_kegiatan'     => $tahun,
        'deskripsi_kegiatan' => $deskripsi,
        'file_dokumen_pdf'   => $file_pdf
    ];

    $ok = $model->insert($payload);

    $_SESSION[$ok ? 'success_message' : 'error_message'] =
        $ok ? "Pengabdian berhasil ditambahkan." : "Gagal menyimpan data.";

    header("Location: " . BASE_URL . "/admin/pengabdian");
    exit;
}



    /**
     * EDIT
     */
    public function edit($id = null)
    {
        if (!$id) {
            header("Location: " . BASE_URL . "/admin/pengabdian");
            exit;
        }

        $pengabdianModel = $this->model('Pengabdian');
        $row = $pengabdianModel->getById($id);

        if (!$row) {
            $_SESSION['error_message'] = "Data tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/pengabdian");
            exit;
        }

        $data = [
            'judul_halaman' => 'Edit Pengabdian',
            'pengabdian'    => $row
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/pengabdian/edit', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * UPDATE
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

    $judul      = trim($_POST['judul_pengabdian']);
    $tim        = trim($_POST['tim_pengabdi']);
    $tahun      = trim($_POST['tahun_pengabdian']);
    $deskripsi  = trim($_POST['deskripsi_kegiatan']);

    include_once __DIR__ . '/../services/FileService.php';

    $file_pdf = $existing['file_dokumen_pdf'];

    // Jika ada file baru
    if (!empty($_FILES['file_dokumen']['name'])) {
        $newFile = FileService::replaceFile(
            $existing['file_dokumen_pdf'],
            $_FILES['file_dokumen'],
            'pengabdian',
            'pengabdian_'
        );

        if ($newFile !== false) {
            $file_pdf = $newFile;
        }
    }

    $payload = [
        'id_pengabdian'      => $id,
        'judul_kegiatan'     => $judul,
        'tim_pengabdi'       => $tim,
        'tahun_kegiatan'     => $tahun,
        'deskripsi_kegiatan' => $deskripsi,
        'file_dokumen_pdf'   => $file_pdf
    ];

    $ok = $model->update($payload);

    $_SESSION[$ok ? 'success_message' : 'error_message'] =
        $ok ? "Pengabdian berhasil diperbarui." : "Gagal memperbarui data.";

    header("Location: " . BASE_URL . "/admin/pengabdian");
    exit;
}


    /**
     * DELETE
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
