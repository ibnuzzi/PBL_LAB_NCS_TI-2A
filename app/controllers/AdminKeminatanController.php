<?php

class AdminKeminatanController extends Controller {

    public function __construct()
    {
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    /**
     * INDEX - LIST DATA KEMINATAN
     */
    public function index()
    {
        $model = $this->model('Keminatan');

        $data = [
            'judul_halaman' => 'Kelola Keminatan - Lab NCS',
            'keminatan_list' => $model->getAll()
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/keminatan/index', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * STORE KEMINATAN BARU
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/keminatan");
            exit;
        }

        $nama_keminatan = trim($_POST['nama_keminatan'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');

        if (empty($nama_keminatan)) {
            $_SESSION['error_message'] = 'Nama keminatan wajib diisi.';
            header("Location: " . BASE_URL . "/admin/keminatan/create");
            exit;
        }

        $model = $this->model('Keminatan');

        $payload = [
            'nama_keminatan' => $nama_keminatan,
            'deskripsi' => $deskripsi
        ];

        $ok = $model->insert($payload);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? "Keminatan berhasil ditambahkan." : "Gagal menambahkan keminatan.";

        header("Location: " . BASE_URL . "/admin/minat_ilmu");
        exit;
    }

    /**
     * UPDATE KEMINATAN
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/minat_ilmu");
            exit;
        }

        $id = $_POST['id_keminatan'] ?? null;

        if (!$id) {
            $_SESSION['error_message'] = "ID keminatan tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/minat_ilmu");
            exit;
        }

        $model = $this->model('Keminatan');
        $existing = $model->getById($id);

        if (!$existing) {
            $_SESSION['error_message'] = "Data tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/minat_ilmu");
            exit;
        }

        $nama_keminatan = trim($_POST['nama_keminatan'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');

        if (empty($nama_keminatan)) {
            $_SESSION['error_message'] = 'Nama keminatan wajib diisi.';
            header("Location: " . BASE_URL . "/admin/minat_ilmu");
            exit;
        }

        $payload = [
            'id_keminatan' => $id,
            'nama_keminatan' => $nama_keminatan,
            'deskripsi' => $deskripsi
        ];

        $ok = $model->update($payload);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? "Keminatan berhasil diperbarui." : "Gagal memperbarui keminatan.";

        header("Location: " . BASE_URL . "/admin/minat_ilmu");
        exit;
    }

    /**
     * DELETE KEMINATAN
     */
    public function delete($id = null)
    {
        if (!$id) {
            header("Location: " . BASE_URL . "/admin/keminatan");
            exit;
        }

        $model = $this->model('Keminatan');
        $existing = $model->getById($id);

        if (!$existing) {
            $_SESSION['error_message'] = "Data tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/minat_ilmu");
            exit;
        }

        // Check if keminatan is being used
        if ($model->isUsed($id)) {
            $_SESSION['error_message'] = "Keminatan tidak dapat dihapus karena masih digunakan oleh pengelola.";
            header("Location: " . BASE_URL . "/admin/minat_ilmu");
            exit;
        }

        $ok = $model->delete($id);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? "Keminatan berhasil dihapus." : "Gagal menghapus data.";

        header("Location: " . BASE_URL . "/admin/minat_ilmu");
        exit;
    }
}
?>
