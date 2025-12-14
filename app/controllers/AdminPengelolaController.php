<?php

class AdminPengelolaController extends Controller
{

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
        $keminatanModel = $this->model('Keminatan');

        $pengelola_list = $model->getAll();

        // Ambil keminatan untuk setiap pengelola
        foreach ($pengelola_list as &$pengelola) {
            $pengelola['keminatan_list'] = $keminatanModel->getByPengelolaId($pengelola['id_pengelola']);
        }

        $data = [
            'judul_halaman' => 'Struktur Pengelola - Lab NCS',
            'pengelola_list' => $pengelola_list
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
        $jabatanModel = $this->model('Jabatan');
        $keminatanModel = $this->model('Keminatan');

        $data = [
            'judul_halaman' => 'Tambah Pengelola',
            'jabatan_list' => $jabatanModel->getAll(),
            'keminatan_list' => $keminatanModel->getAll()
        ];

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

        $nama      = trim($_POST['nama_pengelola'] ?? '');
        $nid_nip   = trim($_POST['nid_nip'] ?? '');
        $id_jabatan = (int)($_POST['id_jabatan'] ?? 0);
        $id_admin  = $_SESSION['admin_id'] ?? 1;
        $keminatan_ids = $_POST['keminatan'] ?? [];
        $linkedin_url = trim($_POST['linkedin_url'] ?? '');

        if (empty($nama)) {
            $_SESSION['error_message'] = 'Nama pengelola wajib diisi.';
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
            'nama_pengelola'    => $nama,
            'nid_nip'           => $nid_nip,
            'id_jabatan'        => $id_jabatan > 0 ? $id_jabatan : null,
            'foto_pengelola'    => $foto,
            'id_admin_pencatat' => $id_admin
        ];

        $ok = $model->insert($payload);

        if ($ok) {
            // Get last inserted ID and assign keminatan
            $id_pengelola = $model->getLastInsertId();
            if (!empty($keminatan_ids)) {
                $model->assignKeminatan($id_pengelola, $keminatan_ids);
            }
            // Update LinkedIn URL
            if (!empty($linkedin_url)) {
                $model->updateLinkedIn($id_pengelola, $linkedin_url);
            }
        }

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

        $jabatanModel = $this->model('Jabatan');
        $keminatanModel = $this->model('Keminatan');
        $selectedKeminatan = $model->getKeminatanIds($id);

        $data = [
            'judul_halaman' => 'Edit Pengelola',
            'pengelola'     => $row,
            'jabatan_list'  => $jabatanModel->getAll(),
            'keminatan_list' => $keminatanModel->getAll(),
            'selected_keminatan' => $selectedKeminatan
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

        $nama      = trim($_POST['nama_pengelola']);
        $nid_nip   = trim($_POST['nid_nip'] ?? '');
        $id_jabatan = (int)($_POST['id_jabatan'] ?? 0);
        $keminatan_ids = $_POST['keminatan'] ?? [];
        $linkedin_url = trim($_POST['linkedin_url'] ?? '');

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
            'nid_nip'        => $nid_nip,
            'id_jabatan'     => $id_jabatan > 0 ? $id_jabatan : null,
            'foto_pengelola' => $foto,
        ];

        $ok = $model->update($payload);

        if ($ok) {
            // Update keminatan
            $model->assignKeminatan($id, $keminatan_ids);
            // Update LinkedIn URL
            $model->updateLinkedIn($id, $linkedin_url);
        }

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
