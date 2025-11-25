<?php
// File: /app/controllers/AdminAgendaController.php

class AdminAgendaController extends Controller
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
        $agendaModel = $this->model('Agenda');

        $data = [
            'judul_halaman' => 'Data Agenda',
            'agenda_list'   => $agendaModel->getAllAgenda()
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/agenda/index', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * CREATE FORM
     */
    public function create()
    {
        $data = ['judul_halaman' => 'Tambah Agenda'];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/agenda/create', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * STORE PROCESS
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ".BASE_URL."/admin/agenda");
            exit;
        }

        $nama       = trim($_POST['nama_agenda'] ?? '');
        $lokasi     = trim($_POST['lokasi'] ?? '');
        $deskripsi  = trim($_POST['deskripsi_agenda'] ?? '');
        $mulai      = $_POST['tanggal_mulai'] ?? null;
        $selesai    = $_POST['tanggal_selesai'] ?? null;
        $id_admin   = $_SESSION['admin_id'] ?? 1;

        include_once './app/services/ImageService.php';

        // Upload gambar jika ada
        $gambar = null;
        if (!empty($_FILES['gambar_agenda']['name'])) {
            $upload = ImageService::uploadImage($_FILES['gambar_agenda'], 'agenda', 'agenda_');
            if (!$upload) {
                $_SESSION['error_message'] = "Gagal mengunggah gambar. Pastikan format JPG/PNG max 5MB.";
                header("Location: ".BASE_URL."/admin/agenda/create");
                exit;
            }
            $gambar = $upload;
        }

        // Simpan
        $agendaModel = $this->model('Agenda');

        $payload = [
            'nama_agenda'      => $nama,
            'lokasi'           => $lokasi,
            'deskripsi_agenda' => $deskripsi,
            'tanggal_mulai'    => $mulai,
            'tanggal_selesai'  => $selesai,
            'gambar_agenda'    => $gambar,
            'id_admin_penulis' => $id_admin
        ];

        $ok = $agendaModel->tambahAgenda($payload);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? 'Agenda berhasil disimpan.' : 'Gagal menyimpan agenda.';

        header("Location: ".BASE_URL."/admin/agenda");
        exit;
    }

    /**
     * EDIT FORM
     */
    public function edit($id = 0)
    {
        $id = (int)$id;

        if ($id <= 0) {
            header("Location: ".BASE_URL."/admin/agenda");
            exit;
        }

        $agendaModel = $this->model('Agenda');
        $row = $agendaModel->getAgendaById($id);

        if (!$row) {
            $_SESSION['error_message'] = "Agenda tidak ditemukan.";
            header("Location: ".BASE_URL."/admin/agenda");
            exit;
        }

        $data = [
            'judul_halaman' => 'Edit Agenda',
            'agenda'        => $row
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/agenda/edit', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * UPDATE PROCESS
     */
    public function update($id = 0)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ".BASE_URL."/admin/agenda");
            exit;
        }

        $id = (int)$id;

        if ($id <= 0) {
            header("Location: ".BASE_URL."/admin/agenda");
            exit;
        }

        $agendaModel = $this->model('Agenda');
        $existing    = $agendaModel->getAgendaById($id);

        if (!$existing) {
            $_SESSION['error_message'] = "Agenda tidak ditemukan.";
            header("Location: ".BASE_URL."/admin/agenda");
            exit;
        }

        $nama       = trim($_POST['nama_agenda'] ?? '');
        $lokasi     = trim($_POST['lokasi'] ?? '');
        $deskripsi  = trim($_POST['deskripsi_agenda'] ?? '');
        $mulai      = $_POST['tanggal_mulai'] ?? null;
        $selesai    = $_POST['tanggal_selesai'] ?? null;

        include_once './app/services/ImageService.php';

        $gambar = $existing['gambar_agenda'];

        // Replace gambar jika upload baru
        if (!empty($_FILES['gambar_agenda']['name'])) {
            $new = ImageService::replaceImage(
                $existing['gambar_agenda'],
                $_FILES['gambar_agenda'],
                'agenda',
                'agenda_'
            );

            if (!$new) {
                $_SESSION['error_message'] = "Gambar baru gagal diupload. Periksa format/ukuran.";
                header("Location: ".BASE_URL."/admin/agenda/edit/$id");
                exit;
            }

            $gambar = $new;
        }

        $payload = [
            'id_agenda'        => $id,
            'nama_agenda'      => $nama,
            'lokasi'           => $lokasi,
            'deskripsi_agenda' => $deskripsi,
            'tanggal_mulai'    => $mulai,
            'tanggal_selesai'  => $selesai,
            'gambar_agenda'    => $gambar
        ];

        $ok = $agendaModel->updateAgenda($payload);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? 'Agenda berhasil diperbarui.' : 'Gagal memperbarui agenda.';

        header("Location: ".BASE_URL."/admin/agenda");
        exit;
    }

    /**
     * DELETE
     */
    public function delete($id = 0)
    {
        $id = (int)$id;

        if ($id <= 0) {
            header("Location: ".BASE_URL."/admin/agenda");
            exit;
        }

        $agendaModel = $this->model('Agenda');
        $existing = $agendaModel->getAgendaById($id);

        include_once './app/services/ImageService.php';

        if (!empty($existing['gambar_agenda'])) {
            ImageService::deleteImage($existing['gambar_agenda'], 'agenda');
        }

        $ok = $agendaModel->hapusAgenda($id);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? 'Agenda berhasil dihapus.' : 'Gagal menghapus agenda.';

        header("Location: ".BASE_URL."/admin/agenda");
        exit;
    }
}
