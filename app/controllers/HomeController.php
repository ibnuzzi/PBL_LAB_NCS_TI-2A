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
        $kategoriArsipModel = $this->model('KategoriArsip');
        $data['kategori_list'] = $kategoriArsipModel->getAllKategori();
        
        $arsipModel = $this->model('DokumenUmum');
        
        // Cek apakah ada parameter kategori di URL
        $kategoriFilter = $_GET['kategori'] ?? 'semua';
        
        // Filter berdasarkan kategori
        if ($kategoriFilter !== 'semua') {
            $data['arsip_list'] = $arsipModel->getAllArsipLengkapByKategori($kategoriFilter);
        } else {
            $data['arsip_list'] = $arsipModel->getAllArsipLengkap();
        }
        
        // Simpan kategori yang sedang aktif untuk highlight di view
        $data['kategori_aktif'] = $kategoriFilter;
        
        $this->view('public/arsip', $data);
    }

        public function indexAgenda()
    {
        $agendaModel = $this->model('Agenda');
        $list = $agendaModel->getAllAgenda();

        $data = [
            'judul_halaman' => 'Agenda - Lab NCS',
            'agendaList'    => $list
        ];

        // The `public/agenda` view includes header, navbar, footer and scripts itself
        $this->view('public/agenda', $data);
    }

    public function indexBerita()
    {

        $beritaModel = $this->model('Berita');

        $list = $beritaModel->getAllBerita(); 

        $data = [
            'judul_halaman' => 'Berita - Lab NCS',
            'beritas'       => $list
        ];

        $this->view('public/berita', $data);
    }

    public function detailBerita($slug)
    {
        $beritaModel = $this->model('Berita');
        $adminModel = $this->model('Admin');

        $berita = $beritaModel->getBeritaBySlug($slug);
        $admin = $berita && $berita['id_admin_penulis'] ? $adminModel->getAdminById($berita['id_admin_penulis']) : null;

        $data = [
            'judul_halaman' => 'Detail Berita - Lab NCS',
            'berita' => $berita,
            'admin' => $admin,
            'latestPosts' => $beritaModel->getBeritaTerbaru(5)
        ];

        if (!$data['berita']) {

            header("HTTP/1.0 404 Not Found");
            $this->view('templates/public/header', ['judul_halaman' => '404 Not Found']);
            $this->view('errors/404');
            $this->view('templates/public/footer');
            return;
        }

        $this->view('public/berita/detail', $data);
    }

    public function indexGaleri() {

        $galleryModel = $this->model('Gallery');

        $list = $galleryModel->getAll();

        $data = [
            'judul_halaman' => 'Galeri - Lab NCS',
            'galleries'     => $list
        ];

        $this->view('public/galeri', $data);
    }

    public function indexFasilitas()
    {
        $fasilitasModel = $this->model('Sarana');
        
        // Pagination settings
        $itemsPerPage = 9; // 3 rows x 3 columns
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = max(1, $currentPage); // Ensure page is at least 1
        
        // Calculate offset
        $offset = ($currentPage - 1) * $itemsPerPage;
        
        // Get paginated data
        $list = $fasilitasModel->getPaginated($itemsPerPage, $offset);
        $totalItems = $fasilitasModel->getTotalCount();
        $totalPages = ceil($totalItems / $itemsPerPage);

        $data = [
            'judul_halaman' => 'Fasilitas - Lab NCS',
            'fasilitasList' => $list,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalItems' => $totalItems
        ];

        $this->view('public/fasilitas', $data);
    }
}
