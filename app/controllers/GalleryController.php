<?php
// File: /app/controllers/GalleryController.php

class GalleryController extends Controller {

    public function index() {
        $galleryModel = $this->model('Gallery');

        $perPage = 9; // show 9 images per page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $perPage;

        $galleries = $galleryModel->getGalleryPaginated($perPage, $offset);
        $total = $galleryModel->countGallery();
        $totalPages = ($total > 0) ? (int)ceil($total / $perPage) : 1;

        $data = [
            'judul_halaman' => 'Galeri - Lab NCS',
            'galleries' => $galleries,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'perPage' => $perPage,
            'totalGallery' => $total
        ];
        // Build categories list if model/table contains 'kategori' column
        $all = $galleryModel->getAll();
        $categories = ['All'];
        foreach ($all as $item) {
            if (isset($item['kategori']) && trim($item['kategori']) !== '') {
                $k = trim($item['kategori']);
                if (!in_array($k, $categories)) $categories[] = $k;
            }
        }

        // Merge categories into data
        $data['categories'] = $categories;

        $this->view('public/galeri', $data);
    }
}

?>
