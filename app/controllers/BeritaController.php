<?php
// File: /app/controllers/BeritaController.php

class BeritaController extends Controller
{

    public function index()
    {
        $beritaModel = $this->model('Berita');

        // Pagination settings
        $perPage = 6;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $perPage;

        $beritas = $beritaModel->getBeritaPaginated($perPage, $offset);
        $total = $beritaModel->countBerita();
        $totalPages = ($total > 0) ? (int)ceil($total / $perPage) : 1;

        $data = [
            'judul_halaman' => 'Berita - Lab NCS',
            'beritas' => $beritas,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'perPage' => $perPage,
            'totalBerita' => $total
        ];

        $this->view('public/berita', $data);
    }

    public function detail($id)
    {
        $beritaModel = $this->model('Berita');
        $adminModel = $this->model('Admin');

        $berita = $beritaModel->getBeritaById($id);
        $admin = $berita && $berita['id_admin_penulis'] ? $adminModel->getAdminById($berita['id_admin_penulis']) : null;

        $data = [
            'judul_halaman' => 'Detail Berita - Lab NCS',
            'berita' => $berita,
            'admin' => $admin,
            'latestPosts' => $beritaModel->getBeritaTerbaru(5)
        ];

        if (!$data['berita']) {
            // Handle 404 for non-existent news
            header("HTTP/1.0 404 Not Found");
            $this->view('templates/public/header', ['judul_halaman' => '404 Not Found']);
            $this->view('errors/404');
            $this->view('templates/public/footer');
            return;
        }

        // Load detail view (which includes header and footer internally)
        $this->view('public/berita/detail', $data);
    }
}
