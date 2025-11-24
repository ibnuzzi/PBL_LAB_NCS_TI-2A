<?php

class AdminSaranaController extends Controller
{
    public function __construct()
    {
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    public function index()
    {
        $model = $this->model('Sarana');

        $data = [
            'judul_halaman' => 'Sarana & Prasarana',
            'list' => $model->getAll()
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/sarana/index', $data);
        $this->view('templates/admin/footer_admin');
    }

    public function create()
    {
        $data = ['judul_halaman' => 'Tambah Sarana'];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/sarana/create');
        $this->view('templates/admin/footer_admin');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/sarana");
            exit;
        }

        include './app/services/ImageService.php';

        $foto = null;
        if (!empty($_FILES['foto_sarana']['name'])) {
            $foto = ImageService::uploadImage($_FILES['foto_sarana'], 'sarana', 'sarana_');
        }

        $model = $this->model('Sarana');

        $ok = $model->insert([
            'nama'      => $_POST['nama_sarana'],
            'deskripsi' => $_POST['deskripsi_sarana'],
            'foto'      => $foto,
            'jumlah'    => $_POST['jumlah'],
            'kondisi'   => $_POST['kondisi'],
            'admin'     => $_SESSION['admin_id'] ?? 1
        ]);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
        $ok ? "Sarana berhasil ditambahkan." : "Gagal menambahkan sarana.";

        header("Location: " . BASE_URL . "/admin/sarana");
        exit;
    }

    public function edit($id)
    {
        $model = $this->model('Sarana');
        $row = $model->getById($id);

        if (!$row) {
            $_SESSION['error_message'] = "Data tidak ditemukan!";
            header("Location: " . BASE_URL . "/admin/sarana");
            exit;
        }

        $data = [
            'judul_halaman' => 'Edit Sarana',
            'sarana' => $row
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/sarana/edit', $data);
        $this->view('templates/admin/footer_admin');
    }

    public function update($id)
    {
        include './app/services/ImageService.php';

        $model = $this->model('Sarana');
        $old = $model->getById($id);

        $foto = $old['foto_sarana'];

        if (!empty($_FILES['foto_sarana']['name'])) {
            $foto = ImageService::uploadImage($_FILES['foto_sarana'], 'sarana', 'sarana_');
        }

        $ok = $model->update($id, [
            'nama'      => $_POST['nama_sarana'],
            'deskripsi' => $_POST['deskripsi_sarana'],
            'foto'      => $foto,
            'jumlah'    => $_POST['jumlah'],
            'kondisi'   => $_POST['kondisi']
        ]);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
        $ok ? "Sarana berhasil diperbarui." : "Gagal memperbarui sarana.";

        header("Location: " . BASE_URL . "/admin/sarana");
        exit;
    }

    public function delete($id)
    {
        $model = $this->model('Sarana');
        $ok = $model->delete($id);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
        $ok ? "Sarana berhasil dihapus." : "Gagal menghapus sarana.";

        header("Location: " . BASE_URL . "/admin/sarana");
        exit;
    }
}