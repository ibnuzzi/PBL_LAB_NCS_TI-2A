<?php

class AdminPengelolaController extends Controller {

    public function __construct()
    {
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    /**
     * INDEX - LIST DATA PENGELOLA
     */
    public function index()
    {
        $model = $this->model('Pengelola');

        $data = [
            'judul_halaman' => 'Struktur Pengelola - Lab NCS',
            'pengelola_list' => $model->getAll()
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/pengelola/index', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        $data = ['judul_halaman' => 'Tambah Pengelola'];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/pengelola/create', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * STORE PENGELOLA BARU
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/pengelola");
            exit;
        }

        $nama   = trim($_POST['nama_pengelola'] ?? '');
        $jabatan = trim($_POST['jabatan'] ?? '');
        $urutan = (int)($_POST['urutan'] ?? 0);
        $id_admin = $_SESSION['admin_id'] ?? 1;

        if (empty($nama) || empty($jabatan)) {
            $_SESSION['error_message'] = 'Nama dan jabatan wajib diisi.';
            header("Location: " . BASE_URL . "/admin/pengelola/create");
            exit;
        }

        // Upload foto
        include './app/services/ImageService.php';
        $foto = null;

        if (!empty($_FILES['foto_pengelola']['name'])) {
            $upload = ImageService::uploadImage($_FILES['foto_pengelola'], 'pengelola');
            if ($upload === false) {
                $_SESSION['error_message'] = 'Gagal upload foto. Pastikan JPG/PNG/GIF <= 5MB.';
                header("Location: " . BASE_URL . "/admin/pengelola/create");
                exit;
            }
            $foto = $upload;
        }

        $model = $this->model('Pengelola');

        $payload = [
            'nama_pengelola' => $nama,
            'jabatan'        => $jabatan,
            'foto_pengelola' => $foto,
            'urutan'         => $urutan,
            'id_admin_pencatat' => $id_admin
        ];

        $ok = $model->insert($payload);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? "Pengelola berhasil ditambahkan." : "Gagal menambahkan pengelola.";

        header("Location: " . BASE_URL . "/admin/pengelola");
        exit;
    }

    /**
     * SHOW EDIT FORM
     */
    public function edit($id = null)
    {
        if (!$id) {
            header("Location: " . BASE_URL . "/admin/pengelola");
            exit;
        }

        $model = $this->model('Pengelola');
        $row = $model->getById($id);

        if (!$row) {
            $_SESSION['error_message'] = "Data pengelola tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/pengelola");
            exit;
        }

        $data = [
            'judul_halaman' => 'Edit Pengelola',
            'pengelola'     => $row
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/pengelola/edit', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * UPDATE PENGELOLA
     */
    public function update($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/pengelola");
            exit;
        }

        $model = $this->model('Pengelola');
        $existing = $model->getById($id);

        if (!$existing) {
            $_SESSION['error_message'] = "Data tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/pengelola");
            exit;
        }

        $nama   = trim($_POST['nama_pengelola']);
        $jabatan = trim($_POST['jabatan']);
        $urutan = (int)$_POST['urutan'];

        include './app/services/ImageService.php';

        $foto = $existing['foto_pengelola'];

        // Replace foto
        if (!empty($_FILES['foto_pengelola']['name'])) {
            $fotoNew = ImageService::replaceImage(
                $existing['foto_pengelola'],
                $_FILES['foto_pengelola'],
                'pengelola'
            );

            if ($fotoNew === false) {
                $_SESSION['error_message'] = "Gagal mengganti foto.";
                header("Location: " . BASE_URL . "/admin/pengelola/edit/$id");
                exit;
            }

            $foto = $fotoNew;
        }

        $payload = [
            'id_pengelola'   => $id,
            'nama_pengelola' => $nama,
            'jabatan'        => $jabatan,
            'foto_pengelola' => $foto,
            'urutan'         => $urutan,
        ];

        $ok = $model->update($payload);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? "Pengelola berhasil diperbarui." : "Gagal memperbarui pengelola.";

        header("Location: " . BASE_URL . "/admin/pengelola");
        exit;
    }

    /**
     * DELETE PENGELOLA
     */
    public function delete($id = null)
    {
        if (!$id) {
            header("Location: " . BASE_URL . "/admin/pengelola");
            exit;
        }

        $model = $this->model('Pengelola');
        $existing = $model->getById($id);

        if (!$existing) {
            $_SESSION['error_message'] = "Data tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/pengelola");
            exit;
        }

        // Hapus foto
        if (!empty($existing['foto_pengelola'])) {
            include './app/services/ImageService.php';
            ImageService::deleteImage($existing['foto_pengelola'], 'pengelola');
        }

        $ok = $model->delete($id);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? "Pengelola berhasil dihapus." : "Gagal menghapus data.";

        header("Location: " . BASE_URL . "/admin/pengelola");
        exit;
    }
}
?>
