<?php
// File: /app/controllers/AdminAgendaController.php

class AdminAgendaController extends Controller
{
    /**
     * Constructor "MIDDLEWARE"
     */
    public function __construct()
    {
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    public function index()
    {
        $agendaModel = $this->model('Agenda');
        $data = [
            'judul_halaman' => 'Agenda - Lab NCS',
            'agenda_list' => $agendaModel->getAllAgenda()
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/agenda/index', $data);
        $this->view('templates/admin/footer_admin');
    }

    public function create()
    {
        $data = ['judul_halaman' => 'Tambah Agenda'];
        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/agenda/create', $data);
        $this->view('templates/admin/footer_admin');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/agenda');
            exit;
        }

        $nama = trim($_POST['nama_agenda'] ?? '');
        $lokasi = trim($_POST['lokasi'] ?? '');
        $tanggal_mulai = $_POST['tanggal_mulai'] ?? null;
        $tanggal_selesai = $_POST['tanggal_selesai'] ?? null;
        $id_admin = $_POST['id_admin_penulis'] ?? ($_SESSION['admin_id'] ?? 1);

        // handle image
        include_once __DIR__ . '/../services/ImageService.php';
        $gambar = null;
        if (!empty($_FILES['gambar_agenda']['name'])) {
            $uploaded = ImageService::uploadImage($_FILES['gambar_agenda'], 'agenda', 'agenda_');
            if ($uploaded === false) {
                $_SESSION['error_message'] = 'Gagal mengunggah gambar agenda. Pastikan format JPG/PNG/GIF dan ukuran <= 5MB.';
                header('Location: ' . BASE_URL . '/admin/agenda/create');
                exit;
            }
            $gambar = $uploaded;
        }

        $agendaModel = $this->model('Agenda');
        $payload = [
            'nama_agenda' => $nama,
            'lokasi' => $lokasi,
            'gambar_agenda' => $gambar,
            'id_admin_penulis' => (int)$id_admin,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai
        ];

        $ok = $agendaModel->tambahAgenda($payload);
        if ($ok) $_SESSION['success_message'] = 'Agenda berhasil disimpan.';
        else $_SESSION['error_message'] = 'Gagal menyimpan agenda.';

        header('Location: ' . BASE_URL . '/admin/agenda');
        exit;
    }

    public function show()
    {
        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;
        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/agenda');
            exit;
        }

        $agendaModel = $this->model('Agenda');
        $row = $agendaModel->getAgendaById($id);
        if (!$row) {
            $_SESSION['error_message'] = 'Agenda tidak ditemukan.';
            header('Location: ' . BASE_URL . '/admin/agenda');
            exit;
        }

        $data = ['judul_halaman' => 'Edit Agenda', 'agenda' => $row];
        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/agenda/edit', $data);
        $this->view('templates/admin/footer_admin');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/agenda');
            exit;
        }

        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;
        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/agenda');
            exit;
        }

        $nama = trim($_POST['nama_agenda'] ?? '');
        $lokasi = trim($_POST['lokasi'] ?? '');
        $tanggal_mulai = $_POST['tanggal_mulai'] ?? null;
        $tanggal_selesai = $_POST['tanggal_selesai'] ?? null;

        include_once __DIR__ . '/../services/ImageService.php';
        $agendaModel = $this->model('Agenda');
        $existing = $agendaModel->getAgendaById($id);

        $gambar = $existing['gambar_agenda'] ?? null;
        if (!empty($_FILES['gambar_agenda']['name'])) {
            $replaced = ImageService::replaceImage($existing['gambar_agenda'] ?? null, $_FILES['gambar_agenda'], 'agenda', 'agenda_');
            if ($replaced === false) {
                $_SESSION['error_message'] = 'Gagal mengunggah gambar baru. Periksa format/ukuran.';
                header('Location: ' . BASE_URL . '/admin/agenda/edit/' . $id);
                exit;
            }
            $gambar = $replaced;
        }

        $payload = [
            'id_agenda' => $id,
            'nama_agenda' => $nama,
            'lokasi' => $lokasi,
            'gambar_agenda' => $gambar,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai
        ];

        $ok = $agendaModel->updateAgenda($payload);
        if ($ok) $_SESSION['success_message'] = 'Agenda berhasil diupdate.';
        else $_SESSION['error_message'] = 'Gagal mengupdate agenda.';

        header('Location: ' . BASE_URL . '/admin/agenda');
        exit;
    }

    public function delete()
    {
        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;
        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/agenda');
            exit;
        }

        $agendaModel = $this->model('Agenda');
        $existing = $agendaModel->getAgendaById($id);
        // delete image file too
        if (!empty($existing['gambar_agenda'])) {
            include_once __DIR__ . '/../services/ImageService.php';
            ImageService::deleteImage($existing['gambar_agenda'], 'agenda');
        }

        $ok = $agendaModel->hapusAgenda($id);
        if ($ok) $_SESSION['success_message'] = 'Agenda dihapus.';
        else $_SESSION['error_message'] = 'Gagal menghapus agenda.';

        header('Location: ' . BASE_URL . '/admin/agenda');
        exit;
    }
}
