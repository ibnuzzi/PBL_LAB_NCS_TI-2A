
<?php
// File: /app/controllers/AdminKonsultasiController.php

class AdminKonsultasiController extends Controller
{
    public function __construct()
    {
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    public function index()
    {
        $konsultasiModel = $this->model('Konsultasi');

        $data = [
            'judul_halaman' => 'Manajemen Konsultasi - Lab NCS',
            'konsultasi'    => $konsultasiModel->getAll()
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/konsultasi/index', $data); // reuse view folder with changes
        $this->view('templates/admin/footer_admin');
    }

    public function create()
    {
        // Admin may not create konsultasi manually, so redirect to index
        header('Location: ' . BASE_URL . '/admin/konsultasi');
        exit;
    }

    public function store()
    {
        // Admin typically does not store konsultasi, so redirect to index
        header('Location: ' . BASE_URL . '/admin/konsultasi');
        exit;
    }

    public function edit()
    {
        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;

        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        $konsultasiModel = $this->model('Konsultasi');
        $row = $konsultasiModel->getById($id);

        if (!$row) {
            $_SESSION['error_message'] = 'Data konsultasi tidak ditemukan.';
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        $data = [
            'judul_halaman' => 'Jawab Konsultasi',
            'konsultasi'    => $row
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/jasa_layanan/edit', $data); // reuse edit view with changes
        $this->view('templates/admin/footer_admin');
    }

    // File: /app/controllers/AdminKonsultasiController.php

    public function update()
    {
        // 1. Cek Method harus POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        // 2. PERBAIKAN: Ambil ID dari Hidden Input Form, bukan dari URL
        $id = isset($_POST['id_konsultasi']) ? (int)$_POST['id_konsultasi'] : 0;

        // Validasi ID
        if ($id <= 0) {
            $_SESSION['error_message'] = 'ID Konsultasi tidak valid.';
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        // 3. Ambil data jawaban
        $jawaban = trim($_POST['jawaban'] ?? '');

        // Otomatis set status jadi 'dijawab' jika admin membalas
        $status_jawaban = 'dijawab';

        // Ambil ID Admin yang sedang login
        $id_admin_penjawab = $_SESSION['admin_id'] ?? 1;

        $konsultasiModel = $this->model('Konsultasi');

        $payload = [
            'jawaban'           => $jawaban,
            'status_jawaban'    => $status_jawaban,
            'id_admin_penjawab' => (int)$id_admin_penjawab
        ];

        // 4. Update Database
        $ok = $konsultasiModel->updateAnswer($id, $payload);

        if ($ok) {
            $_SESSION['success_message'] = 'Jawaban konsultasi berhasil disimpan.';
        } else {
            $_SESSION['error_message'] = 'Gagal menyimpan jawaban konsultasi.';
        }

        header('Location: ' . BASE_URL . '/admin/konsultasi');
        exit;
    }

    public function delete()
    {
        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;

        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        $konsultasiModel = $this->model('Konsultasi');
        $ok = $konsultasiModel->delete($id);

        if ($ok) {
            $_SESSION['success_message'] = 'Konsultasi berhasil dihapus.';
        } else {
            $_SESSION['error_message'] = 'Gagal menghapus konsultasi.';
        }

        header('Location: ' . BASE_URL . '/admin/konsultasi');
        exit;
    }
}
