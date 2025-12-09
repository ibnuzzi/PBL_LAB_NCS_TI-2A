<?php
// File: /app/controllers/AdminPerformaController.php

class AdminPerformaController extends Controller
{
    /**
     * Middleware: Check if admin is logged in
     */
    public function __construct()
    {
        if (!isset($_SESSION['admin_logged_in'])) {
            $_SESSION['error_message'] = 'Anda harus login untuk mengakses halaman ini!';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    /**
     * Display performance ranking dashboard
     */
    public function index()
    {
        // Load model
        $performanceModel = $this->model('PerformanceEvaluation');

        // Get filter year from GET parameter (optional)
        $tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : null;

        // Calculate ranking
        $ranking = $performanceModel->calculateRanking($tahun);

        // Get available years for filter dropdown
        $years = $performanceModel->getAvailableYears();

        // Prepare data for view
        $data = [
            'ranking' => $ranking,
            'years' => $years,
            'selected_year' => $tahun
        ];

        // Pass to view
        $this->view('public/admin/performa/index', $data);
    }
}
