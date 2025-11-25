<?php
// File: /app/controllers/AdminKategoriArsipController.php

class AdminDokumenKategoriController extends Controller {

    /**
     * Constructor "MIDDLEWARE"
     */
    public function __construct()
    {
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    /**
     * Menampilkan daftar kategori (READ)
     */
    public function index() {
        $data['judul_halaman'] = 'Manajemen Kategori Arsip';
        $data['kategori'] = $this->model('KategoriArsip')->getAllKategori();

        $this->view('public/admin/dokumen_kategori/index', $data); 
    }

    /**
     * Proses Tambah Kategori (CREATE)
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $data = [
                'nama_kategori' => $_POST['nama_kategori']
            ];

            if ($this->model('KategoriArsip')->tambahKategori($data)) {
                $_SESSION['success_message'] = 'Kategori berhasil ditambahkan!';
            } else {
                $_SESSION['error_message'] = 'Gagal menambahkan kategori.';
            }

            header('Location: ' . BASE_URL . '/admin/dokumen_kategori');
            exit;
        }
    }

    /**
     * Proses Update Kategori (UPDATE)
     * Menggunakan ID dari POST (Hidden Input) seperti pada Konsultasi
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $data = [
                'id_kategori_arsip' => $_POST['id_kategori_arsip'],
                'nama_kategori' => $_POST['nama_kategori']
            ];

            if ($this->model('KategoriArsip')->updateKategori($data)) {
                $_SESSION['success_message'] = 'Kategori berhasil diperbarui!';
            } else {
                $_SESSION['error_message'] = 'Gagal memperbarui kategori.';
            }

            header('Location: ' . BASE_URL . '/admin/dokumen_kategori');
            exit;
        }
    }

    /**
     * Proses Hapus Kategori (DELETE)
     */
    public function delete($id) {
        if ($this->model('KategoriArsip')->hapusKategori($id)) {
            $_SESSION['success_message'] = 'Kategori berhasil dihapus!';
        } else {
            $_SESSION['error_message'] = 'Gagal menghapus kategori.';
        }

        header('Location: ' . BASE_URL . '/admin/dokumen_kategori');
        exit;
    }
}