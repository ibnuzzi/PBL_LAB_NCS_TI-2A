<?php
// File: /app/controllers/AdminPenelitianController.php

class AdminPenelitianController extends Controller
{
    public function __construct()
    {
        // Middleware for checking if the user is logged in as an admin
        if (!isset($_SESSION['admin_logged_in'])) {
            $_SESSION['error_message'] = 'You must be logged in!';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    // Display the list of penelitian
    public function index()
    {
        $penelitianModel = $this->model('Penelitian');
        $penelitianList = $penelitianModel->getAll();

        $data = [
            'judul_halaman' => 'Manajemen Penelitian',
            'penelitian_list' => $penelitianList
        ];

        // Render the views
        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/penelitian/index', $data);
        $this->view('templates/admin/footer_admin');
    }

    // Show the form to add a new penelitian
    public function create()
    {
        // Load daftar pengelola untuk dropdown/checkbox
        $pengelolaModel = $this->model('Pengelola');
        $list_pengelola = $pengelolaModel->getAll();

        $data = [
            'judul_halaman' => 'Tambah Penelitian',
            'list_pengelola' => $list_pengelola
        ];

        // Render the views
        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/penelitian/create', $data);
        $this->view('templates/admin/footer_admin');
    }

    // Store the new penelitian data
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/penelitian');
            exit;
        }

        // Get POST data
        $judul_penelitian = $_POST['judul_penelitian'] ?? null;
        $tahun_penelitian = $_POST['tahun_penelitian'] ?? null;
        $deskripsi_singkat = $_POST['deskripsi_singkat'] ?? null;
        $peneliti_array = $_POST['peneliti'] ?? [];  // Array dari checkbox
        $link_publikasi = $_POST['link_publikasi'] ?? null;

        // Validate required fields
        if (empty($judul_penelitian)) {
            $_SESSION['error_message'] = "Judul Penelitian tidak boleh kosong!";
            header('Location: ' . BASE_URL . '/admin/penelitian/create');
            exit;
        }

        // Validasi tim peneliti minimal 1
        if (empty($peneliti_array)) {
            $_SESSION['error_message'] = "Tim Peneliti wajib dipilih minimal satu orang.";
            header('Location: ' . BASE_URL . '/admin/penelitian/create');
            exit;
        }

        // Handle file upload
        $file_name = null;
        if (isset($_FILES['file_dokumen']) && $_FILES['file_dokumen']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = './public/uploads/penelitian/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $file_tmp = $_FILES['file_dokumen']['tmp_name'];
            $file_original = $_FILES['file_dokumen']['name'];
            $file_ext = strtolower(pathinfo($file_original, PATHINFO_EXTENSION));
            
            // Validasi PDF
            if ($file_ext !== 'pdf') {
                $_SESSION['error_message'] = "Hanya file PDF yang diperbolehkan.";
                header('Location: ' . BASE_URL . '/admin/penelitian/create');
                exit;
            }

            // Validasi ukuran (10MB)
            if ($_FILES['file_dokumen']['size'] > 10 * 1024 * 1024) {
                $_SESSION['error_message'] = "Ukuran file maksimal 10MB.";
                header('Location: ' . BASE_URL . '/admin/penelitian/create');
                exit;
            }

            $file_name = 'penelitian_' . time() . '_' . rand(1000, 9999) . '.pdf';
            $file_destination = $upload_dir . $file_name;

            if (!move_uploaded_file($file_tmp, $file_destination)) {
                $_SESSION['error_message'] = "Gagal mengupload file.";
                header('Location: ' . BASE_URL . '/admin/penelitian/create');
                exit;
            }
        }

        // Prepare data
        $data = [
            'judul_penelitian' => $judul_penelitian,
            'tahun_penelitian' => $tahun_penelitian,
            'deskripsi_singkat' => $deskripsi_singkat,
            'link_publikasi' => $link_publikasi,
            'file_dokumen_pdf' => $file_name,
            'peneliti' => $peneliti_array  // Array ID
        ];

        // Pass data to the model
        $penelitianModel = $this->model('Penelitian');
        $inserted = $penelitianModel->insert($data);

        if ($inserted) {
            $_SESSION['success_message'] = 'Penelitian berhasil ditambahkan.';
        } else {
            $_SESSION['error_message'] = 'Gagal menambahkan penelitian.';
        }

        // Redirect to the list
        header('Location: ' . BASE_URL . '/admin/penelitian');
        exit;
    }

    // Show the form to edit an existing penelitian
    public function edit($id)
    {
        $penelitianModel = $this->model('Penelitian');
        $penelitian = $penelitianModel->getById($id);

        if (!$penelitian) {
            $_SESSION['error_message'] = 'Penelitian tidak ditemukan.';
            header('Location: ' . BASE_URL . '/admin/penelitian');
            exit;
        }

        // Load daftar pengelola
        $pengelolaModel = $this->model('Pengelola');
        $list_pengelola = $pengelolaModel->getAll();

        // Load tim peneliti yang sudah terpilih
        $selected_peneliti = $penelitianModel->getTimPenelitiIds($id);

        $data = [
            'judul_halaman' => 'Edit Penelitian',
            'penelitian' => $penelitian,
            'list_pengelola' => $list_pengelola,
            'selected_peneliti' => $selected_peneliti
        ];

        // Render the views
        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/penelitian/edit', $data);
        $this->view('templates/admin/footer_admin');
    }

    // Update the penelitian data
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/penelitian');
            exit;
        }

        // Get POST data
        $judul_penelitian = $_POST['judul_penelitian'] ?? null;
        $tahun_penelitian = $_POST['tahun_penelitian'] ?? null;
        $deskripsi_singkat = $_POST['deskripsi_singkat'] ?? null;
        $peneliti_array = $_POST['peneliti'] ?? [];  // Array dari checkbox
        $link_publikasi = $_POST['link_publikasi'] ?? null;

        // Validasi tim peneliti minimal 1
        if (empty($peneliti_array)) {
            $_SESSION['error_message'] = "Tim Peneliti wajib dipilih minimal satu orang.";
            header('Location: ' . BASE_URL . '/admin/penelitian/edit/' . $id);
            exit;
        }

        // Get existing data for file handling
        $penelitianModel = $this->model('Penelitian');
        $existing = $penelitianModel->getById($id);
        $file_name = $existing['file_dokumen_pdf'] ?? null;

        // Handle file upload
        if (isset($_FILES['file_dokumen']) && $_FILES['file_dokumen']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = './public/uploads/penelitian/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $file_tmp = $_FILES['file_dokumen']['tmp_name'];
            $file_original = $_FILES['file_dokumen']['name'];
            $file_ext = strtolower(pathinfo($file_original, PATHINFO_EXTENSION));
            
            // Validasi PDF
            if ($file_ext !== 'pdf') {
                $_SESSION['error_message'] = "Hanya file PDF yang diperbolehkan.";
                header('Location: ' . BASE_URL . '/admin/penelitian/edit/' . $id);
                exit;
            }

            // Validasi ukuran (10MB)
            if ($_FILES['file_dokumen']['size'] > 10 * 1024 * 1024) {
                $_SESSION['error_message'] = "Ukuran file maksimal 10MB.";
                header('Location: ' . BASE_URL . '/admin/penelitian/edit/' . $id);
                exit;
            }

            // Hapus file lama jika ada
            if ($file_name && file_exists($upload_dir . $file_name)) {
                unlink($upload_dir . $file_name);
            }

            $file_name = 'penelitian_' . time() . '_' . rand(1000, 9999) . '.pdf';
            $file_destination = $upload_dir . $file_name;

            if (!move_uploaded_file($file_tmp, $file_destination)) {
                $_SESSION['error_message'] = "Gagal mengupload file.";
                header('Location: ' . BASE_URL . '/admin/penelitian/edit/' . $id);
                exit;
            }
        }

        // Prepare data
        $data = [
            'judul_penelitian' => $judul_penelitian,
            'tahun_penelitian' => $tahun_penelitian,
            'deskripsi_singkat' => $deskripsi_singkat,
            'link_publikasi' => $link_publikasi,
            'file_dokumen_pdf' => $file_name,
            'peneliti' => $peneliti_array  // Array ID
        ];

        // Pass data to the model
        $updated = $penelitianModel->update($id, $data);

        if ($updated) {
            $_SESSION['success_message'] = 'Penelitian berhasil diperbarui.';
        } else {
            $_SESSION['error_message'] = 'Gagal memperbarui penelitian.';
        }

        // Redirect to the list
        header('Location: ' . BASE_URL . '/admin/penelitian');
        exit;
    }

    // Delete a penelitian
    public function delete($id)
    {
        $penelitianModel = $this->model('Penelitian');
        $deleted = $penelitianModel->delete($id);

        if ($deleted) {
            $_SESSION['success_message'] = 'Penelitian berhasil dihapus.';
        } else {
            $_SESSION['error_message'] = 'Gagal menghapus penelitian.';
        }

        // Redirect to the list
        header('Location: ' . BASE_URL . '/admin/penelitian');
        exit;
    }
}
