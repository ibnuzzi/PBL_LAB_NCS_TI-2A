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

        // Check if there are recommendations from session (after POST-Redirect-GET)
        $recommendations = [];
        $selected_keminatan = [];

        if (isset($_SESSION['rekomtim_results'])) {
            $recommendations = $_SESSION['rekomtim_results'];
            unset($_SESSION['rekomtim_results']); // Clear after reading
        }

        if (isset($_SESSION['rekomtim_selected'])) {
            $selected_keminatan = $_SESSION['rekomtim_selected'];
            unset($_SESSION['rekomtim_selected']); // Clear after reading
        }

        // Prepare data for view
        $data = [
            'keminatan_list' => $keminatan_list,
            'recommendations' => $recommendations,
            'selected_keminatan' => $selected_keminatan
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

        // Store results in session (Post-Redirect-Get pattern)
        $_SESSION['rekomtim_results'] = $recommendations;
        $_SESSION['rekomtim_selected'] = $selected_keminatan;

        // Redirect to index page (prevents form resubmission on refresh)
        header('Location: ' . BASE_URL . '/admin/rekomtim');
        exit;
    }
}
