<?php
// File: /app/controllers/DashboardController.php

class DashboardController extends Controller {

    /**
     * Constructor ini berfungsi sebagai "MIDDLEWARE"
     */
    public function __construct() {
        // Cek apakah session 'admin_logged_in' TIDAK ada
        if (!isset($_SESSION['admin_logged_in'])) {
            // Jika tidak ada (belum login), tendang ke halaman login
            $_SESSION['error_message'] = 'Anda harus login untuk mengakses halaman ini!';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        // Jika session ada, biarkan lanjut ke method 'index'
    }

    /**
     * Menampilkan halaman dashboard dengan data statistik
     */
    public function index() {
        // Load models
        $beritaModel = $this->model('Berita');
        $agendaModel = $this->model('Agenda');
        $pengabdianModel = $this->model('Pengabdian');
        $penelitianModel = $this->model('Penelitian');
        $konsultasiModel = $this->model('Konsultasi');
        
        // Get statistics
        // Berita: countBerita()
        // Agenda: getAllAgenda()
        // Pengabdian: getAll()
        // Penelitian: getAll()
        $totalBerita = $beritaModel->countBerita();
        $totalAgenda = count($agendaModel->getAllAgenda());
        $totalPengabdian = count($pengabdianModel->getAll());
        $totalPenelitian = count($penelitianModel->getAll());
        $totalPertanyaan = count($konsultasiModel->getAll());
        
        // Get recent data
        // Berita: getBeritaTerbaru(3)
        $recentBerita = $beritaModel->getBeritaTerbaru(3);
        
        // Agenda: getAllAgenda() then slice
        $allAgenda = $agendaModel->getAllAgenda();
        $recentAgenda = array_slice($allAgenda, 0, 5);
        
        // Konsultasi: getAll() then slice
        $allKonsultasi = $konsultasiModel->getAll();
        $recentPertanyaan = array_slice($allKonsultasi, 0, 5);
        
        $data = [
            'totalBerita' => $totalBerita,
            'totalAgenda' => $totalAgenda,
            'totalPengabdian' => $totalPengabdian,
            'totalPenelitian' => $totalPenelitian,
            'totalPertanyaan' => $totalPertanyaan,
            'recentBerita' => $recentBerita,
            'recentAgenda' => $recentAgenda,
            'recentPertanyaan' => $recentPertanyaan
        ];
        
        $this->view('public/admin/dashboard', $data); 
    }

}
?>