<?php
// File: /app/core/App.php

class App {
    
    // Properti untuk controller, method, dan parameter default
    protected $controller = 'HomeController'; // Controller default
    protected $method = 'index';             // Method default
    protected $params = [];                  // Parameter default

    public function __construct() {
        // Panggil fungsi untuk mem-parsing URL
        $url = $this->parseURL();

        // --- 1. LOGIKA UNTUK CONTROLLER ---

        // Cek apakah ada file controller yang sesuai dengan nama di URL
        // (Misal: /berita -> cek file BeritaController.php)
        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller'; // (Jadi 'BeritaController')
            
            if (file_exists('app/controllers/' . $controllerName . '.php')) {
                // Jika file ada, set sebagai controller
                $this->controller = $controllerName;
                // Hapus controller dari array $url agar sisa parameternya saja
                unset($url[0]);
            }
            // (Tambahan): Anda bisa tambahkan 'else' di sini untuk halaman 404
        }

        // Load file controller yang sudah ditentukan
        require_once 'app/controllers/' . $this->controller . '.php';
        
        // Buat instance dari controller tersebut
        // (Misal: new HomeController() atau new BeritaController())
        $this->controller = new $this->controller;

        // --- 2. LOGIKA UNTUK METHOD ---

        // Cek apakah ada method yang dikirim di URL (segmen kedua)
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                // Jika method-nya ada di dalam controller
                $this->method = $url[1];
                // Hapus method dari array $url
                unset($url[1]);
            }
            // (Tambahan): Anda bisa tambahkan 'else' di sini untuk halaman 404
        }

        // --- 3. LOGIKA UNTUK PARAMETER ---

        // Cek apakah masih ada sisa di array $url
        if (!empty($url)) {
            // Ambil sisa array-nya sebagai parameter
            $this->params = array_values($url);
        }

        // --- 4. JALANKAN CONTROLLER & METHOD ---

        // Panggil controller, method, dengan parameter yang ada
        // (Contoh: $homeController->index() atau $beritaController->detail(['5']))
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Fungsi helper untuk mem-parsing URL
     * @return array URL yang sudah dipecah-pecah
     */
    public function parseURL() {
        if (isset($_GET['url'])) {
            // 1. Ambil URL dari query string
            $url = $_GET['url'];
            
            // 2. Bersihkan URL dari karakter '/' di akhir
            $url = rtrim($url, '/');
            
            // 3. Bersihkan URL dari karakter-karakter aneh (filter)
            $url = filter_var($url, FILTER_SANITIZE_URL);
            
            // 4. Pecah URL berdasarkan karakter '/'
            $url = explode('/', $url);
            
            return $url;
        } else {
            // Jika tidak ada URL, kembalikan array kosong
            return [];
        }
    }
}
?>