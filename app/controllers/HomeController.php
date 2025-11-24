<?php
// File: /app/controllers/HomeController.php

class HomeController extends Controller {
    
    public function index() {
        $this->view('public/home');
    }

    public function news() {
        $this->view('public/berita');
    }

    public function layanan() {

        $konsultasiModel = $this->model('Konsultasi');
        $data['daftar_konsultasi'] = $konsultasiModel->getAllDijawab();
        $data['judul_halaman'] = 'Layanan Konsultasi - Lab NCS';

        $this->view('templates/public/header', $data);
        $this->view('public/layanan', $data);
        $this->view('templates/public/footer');
    }

    public function kirimLayanan()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/layanan');
            exit;
        }
        
        // Trim inputs
        $nama_penanya = trim($_POST['nama_penanya'] ?? '');
        $email_penanya = trim($_POST['email_penanya'] ?? '');
        $pertanyaan = trim($_POST['pertanyaan'] ?? '');

        // Basic validation
        $errors = [];
        if ($nama_penanya === '') {
            $errors[] = 'Nama lengkap harus diisi.';
        }
        if ($email_penanya === '' || !filter_var($email_penanya, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email tidak valid atau kosong.';
        }
        if ($pertanyaan === '') {
            $errors[] = 'Pertanyaan harus diisi.';
        }

        if (!empty($errors)) {
            $_SESSION['flash_message'] = implode('<br>', $errors);
            header('Location: ' . BASE_URL . '/layanan');
            exit;
        }

        // Insert konsultasi
        $konsultasiModel = $this->model('Konsultasi');
        $payload = [
            'nama_penanya' => $nama_penanya,
            'email_penanya' => $email_penanya,
            'pertanyaan' => $pertanyaan
        ];
        $ok = $konsultasiModel->insert($payload);

        if ($ok) {
            $_SESSION['flash_message'] = 'Pertanyaan Anda berhasil dikirim. Terima kasih!';
        } else {
            $_SESSION['flash_message'] = 'Gagal mengirim pertanyaan. Silakan coba lagi.';
        }

        header('Location: ' . BASE_URL . '/layanan');
        exit;
    }

    public function arsip() {
        $this->view('public/arsip');
    }
}
