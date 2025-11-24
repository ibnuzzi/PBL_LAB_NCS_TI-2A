<?php
// File: /app/controllers/AdminBeritaController.php

class AdminBeritaController extends Controller {

    /**
     * Constructor "MIDDLEWARE"
     */
    public function __construct()
    {
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    public function index() {
        $beritaModel = $this->model('Berita');
        
        $data = [
            'judul_halaman' => 'Berita - Lab NCS',
            'berita_list' => $beritaModel->getAllBerita()
        ];
        // Render viewsx    
        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/berita/index', $data);
        $this->view('templates/admin/footer_admin');
    }

    public function create() {
        $beritaModel = $this->model('Berita');
        
        $data = [
            'judul_halaman' => 'Berita - Lab NCS',
            'berita_list' => $beritaModel->getAllBerita()
        ];

            $this->view('templates/admin/header_admin', $data);
            $this->view('public/admin/berita/create', $data);
            $this->view('templates/admin/footer_admin');
    }

    public function store() {
        // Hanya terima POST
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/berita');
            exit;
        }

        // Ambil input
        $judul = trim($_POST['judul_berita'] ?? '');
        $slug = trim($_POST['slug_berita'] ?? '');
        $isi = trim($_POST['isi_berita'] ?? '');
        $tanggal = $_POST['tanggal_publish'] ?? date('Y-m-d');
        $id_admin = $_POST['id_admin_penulis'] ?? ($_SESSION['admin_id'] ?? 1);
        

        // Buat slug jika kosong
        if (empty($slug)) {
            $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($judul)));
            $slug = trim($slug, '-');
        }

        // Handle upload gambar jika ada (menggunakan ImageService)
        $gambarName = null;
        include './app/services/ImageService.php';
        if (!empty($_FILES['gambar_berita']['name'])) {
            $uploaded = ImageService::uploadImage($_FILES['gambar_berita']);
            if ($uploaded === false) {
                $_SESSION['error_message'] = 'Gagal mengunggah gambar. Pastikan format JPG/PNG/GIF dan ukuran <= 5MB.';
                header('Location: ' . BASE_URL . '/admin/berita/create');
                exit;
            }
            $gambarName = $uploaded;
        }

        // Persist via model
        $beritaModel = $this->model('Berita');
        $payload = [
            'judul_berita' => $judul,
            'slug_berita' => $slug,
            'isi_berita' => $isi,
            'gambar_berita' => $gambarName,
            'id_admin_penulis' => (int)$id_admin,
            'tanggal_publish' => $tanggal
        ];

        $ok = $beritaModel->createBerita($payload);
        if ($ok) {
            $_SESSION['success_message'] = 'Berita berhasil disimpan.';
        } else {
            $_SESSION['error_message'] = 'Gagal menyimpan berita.';
        }

        header('Location: ' . BASE_URL . '/admin/berita');
        exit;
    }
    
    public function show() {
        // Tampilkan form edit (ex: /admin/berita/edit/{id})
        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;
        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/berita');
            exit;
        }

        $beritaModel = $this->model('Berita');
        $row = $beritaModel->getBeritaById($id);
        if (!$row) {
            $_SESSION['error_message'] = 'Berita tidak ditemukan.';
            header('Location: ' . BASE_URL . '/admin/berita');
            exit;
        }

        $data = [
            'judul_halaman' => 'Edit Berita',
            'berita' => $row
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/berita/edit', $data); // reuse create as edit form
        $this->view('templates/admin/footer_admin');
    }

    public function update() {
        // Terima POST dari form edit
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/berita');
            exit;
        }

        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;
        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/berita');
            exit;
        }

        $judul = trim($_POST['judul_berita'] ?? '');
        $slug = trim($_POST['slug_berita'] ?? '');
        $isi = trim($_POST['isi_berita'] ?? '');

        if (empty($slug)) {
            $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($judul)));
            $slug = trim($slug, '-');
        }

        // Ambil tanggal publish dari form (jika ada)
        $tanggal = $_POST['tanggal_publish'] ?? null;

        // Use ImageService to handle image replacement; if no new image, keep existing
        include './app/services/ImageService.php';
        $beritaModel = $this->model('Berita');
        $existing = $beritaModel->getBeritaById($id);

        $gambarName = $existing['gambar_berita'] ?? null;
        if (!empty($_FILES['gambar_berita']['name'])) {
            $replaced = ImageService::replaceImage($existing['gambar_berita'] ?? null, $_FILES['gambar_berita']);
            if ($replaced === false) {
                $_SESSION['error_message'] = 'Gagal mengunggah gambar baru. Periksa format/ukuran.';
                header('Location: ' . BASE_URL . '/admin/berita/edit/' . $id);
                exit;
            }
            $gambarName = $replaced;
        }

        $payload = [
            'id_berita' => $id,
            'judul_berita' => $judul,
            'slug_berita' => $slug,
            'isi_berita' => $isi,
            'gambar_berita' => $gambarName,
            'tanggal_publish' => $tanggal ?? ($existing['tanggal_publish'] ?? null)
        ];

        $ok = $beritaModel->updateBerita($payload);
        if ($ok) $_SESSION['success_message'] = 'Berita berhasil diupdate.';
        else $_SESSION['error_message'] = 'Gagal mengupdate berita.';

        header('Location: ' . BASE_URL . '/admin/berita');
        exit;
    }

    public function delete() {
        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;
        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/berita');
            exit;
        }

        $beritaModel = $this->model('Berita');
        $ok = $beritaModel->deleteBerita($id);
        if ($ok) $_SESSION['success_message'] = 'Berita dihapus.';
        else $_SESSION['error_message'] = 'Gagal menghapus berita.';

        header('Location: ' . BASE_URL . '/admin/berita');
        exit;
    }
}
?>