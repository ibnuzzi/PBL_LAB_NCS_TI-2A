<?php

class AdminJabatanController extends Controller {

    public function __construct()
    {
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    /**
     * INDEX - LIST DATA JABATAN
     */
    public function index()
    {
        $model = $this->model('Jabatan');

        $data = [
            'judul_halaman' => 'Kelola Jabatan - Lab NCS',
            'jabatan_list' => $model->getAll()
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/jabatan/index', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * STORE JABATAN BARU
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/jabatan");
            exit;
        }

        $nama_jabatan = trim($_POST['nama_jabatan'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');

        if (empty($nama_jabatan)) {
            $_SESSION['error_message'] = 'Nama jabatan wajib diisi.';
            header("Location: " . BASE_URL . "/admin/jabatan/create");
            exit;
        }

        $model = $this->model('Jabatan');

        $payload = [
            'nama_jabatan' => $nama_jabatan,
            'deskripsi' => $deskripsi
        ];

        $ok = $model->insert($payload);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? "Jabatan berhasil ditambahkan." : "Gagal menambahkan jabatan.";

        header("Location: " . BASE_URL . "/admin/jabatan");
        exit;
    }

    /**
     * UPDATE JABATAN
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/jabatan");
            exit;
        }

        $id = $_POST['id_jabatan'] ?? null;

        if (!$id) {
            $_SESSION['error_message'] = "ID jabatan tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/jabatan");
            exit;
        }

        $model = $this->model('Jabatan');
        $existing = $model->getById($id);

        if (!$existing) {
            $_SESSION['error_message'] = "Data tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/jabatan");
            exit;
        }

        $nama_jabatan = trim($_POST['nama_jabatan'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');

        if (empty($nama_jabatan)) {
            $_SESSION['error_message'] = 'Nama jabatan wajib diisi.';
            header("Location: " . BASE_URL . "/admin/jabatan");
            exit;
        }

        $payload = [
            'id_jabatan' => $id,
            'nama_jabatan' => $nama_jabatan,
            'deskripsi' => $deskripsi
        ];

        $ok = $model->update($payload);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? "Jabatan berhasil diperbarui." : "Gagal memperbarui jabatan.";

        header("Location: " . BASE_URL . "/admin/jabatan");
        exit;
    }

    /**
     * DELETE JABATAN
     */
    public function delete($id = null)
    {
        if (!$id) {
            header("Location: " . BASE_URL . "/admin/jabatan");
            exit;
        }

        $model = $this->model('Jabatan');
        $existing = $model->getById($id);

        if (!$existing) {
            $_SESSION['error_message'] = "Data tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/jabatan");
            exit;
        }

        // Check if jabatan is being used
        if ($model->isUsed($id)) {
            $_SESSION['error_message'] = "Jabatan tidak dapat dihapus karena masih digunakan oleh pengelola.";
            header("Location: " . BASE_URL . "/admin/jabatan");
            exit;
        }

        $ok = $model->delete($id);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? "Jabatan berhasil dihapus." : "Gagal menghapus data.";

        header("Location: " . BASE_URL . "/admin/jabatan");
        exit;
    }
}
?>
