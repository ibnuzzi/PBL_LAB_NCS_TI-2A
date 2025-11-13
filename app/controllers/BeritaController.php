<?php
// File: /app/controllers/BeritaController.php

class BeritaController extends Controller {
    
    public function index() {
        $beritaModel = $this->model('Berita');
        
        $data = [
            'judul_halaman' => 'Berita - Lab NCS',
            'berita_list' => $beritaModel->getAllBerita()
        ];

            $this->view('templates/public/header', $data);
            $this->view('public/berita/index', $data);
            $this->view('templates/public/footer');
    }

    public function detail($id) {
        $beritaModel = $this->model('Berita');
        
        $data = [
            'judul_halaman' => 'Detail Berita - Lab NCS',
            'berita' => $beritaModel->getBeritaById($id)
        ];

        if (!$data['berita']) {
            // Handle 404 for non-existent news
            header("HTTP/1.0 404 Not Found");
            $this->view('templates/public/header', ['judul_halaman' => '404 Not Found']);
            $this->view('errors/404');
            $this->view('templates/public/footer');
            return;
        }

        $this->view('templates/public/header', $data);
        $this->view('public/berita/detail', $data);
        $this->view('templates/public/footer');
    }
}