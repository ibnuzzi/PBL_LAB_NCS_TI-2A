<?php
// File: /app/controllers/AdminRekomTimController.php

class AdminRekomTimController extends Controller
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
     * Display team recommendation form
     */
    public function index()
    {
        // Load model
        $teamModel = $this->model('TeamRecommendation');

        // Get all keminatan for dropdown
        $keminatan_list = $teamModel->getAllKeminatan();

        // Prepare data for view
        $data = [
            'keminatan_list' => $keminatan_list,
            'recommendations' => []
        ];

        // Pass to view
        $this->view('public/admin/rekomtim/index', $data);
    }

    /**
     * Process recommendation request and display results
     */
    public function recommend()
    {
        // Load model
        $teamModel = $this->model('TeamRecommendation');

        // Get selected keminatan from POST
        $selected_keminatan = isset($_POST['keminatan']) ? $_POST['keminatan'] : [];

        // Validate input
        if (empty($selected_keminatan) || !is_array($selected_keminatan)) {
            $_SESSION['error_message'] = 'Silakan pilih minimal satu keminatan!';
            header('Location: ' . BASE_URL . '/admin/rekomtim');
            exit;
        }

        // Find candidates
        $recommendations = $teamModel->findCandidates($selected_keminatan);

        // Get all keminatan for dropdown (to repopulate form)
        $keminatan_list = $teamModel->getAllKeminatan();

        // Prepare data for view
        $data = [
            'keminatan_list' => $keminatan_list,
            'recommendations' => $recommendations,
            'selected_keminatan' => $selected_keminatan
        ];

        // Pass to view
        $this->view('public/admin/rekomtim/index', $data);
    }
}
