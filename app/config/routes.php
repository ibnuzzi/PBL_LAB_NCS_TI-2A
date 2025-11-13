<?php
// File: /app/core/Route.php

class Route {
    
    // Properti untuk menyimpan semua rute yang terdaftar
    private static $routes = [];

    /**
     * Mendaftarkan rute baru
     * @param string $method (GET, POST, dll)
     * @param string $path (URL path, misal: /berita/detail/{id})
     * @param string $controller (Nama class Controller, misal: BeritaController)
     * @param string $action (Nama method, misal: detail)
     */
    public static function add($method, $path, $controller, $action) {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    /**
     * Menjalankan router untuk mencocokkan URL
     * @param string $requestPath (URL bersih dari index.php, misal: /berita/detail/5)
     * @param string $requestMethod (Metode HTTP, misal: GET)
     */
    public static function dispatch($requestPath, $requestMethod) {
        foreach (self::$routes as $route) {
            
            // Cocokkan metode (GET/POST)
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            // Ubah path rute (misal: /berita/{id}) menjadi Pola Regex
            $pattern = self::buildRegexPattern($route['path']);

            // Coba cocokkan URL browser dengan pola regex
            if (preg_match($pattern, $requestPath, $matches)) {
                
                // Ambil nama controller dan action
                $controllerName = $route['controller'];
                $actionName = $route['action'];
                
                // Ambil parameter dari URL (misal: '5' dari /berita/detail/5)
                $params = self::getParams($matches);

                // ============ INI SOLUSI ANDA ============
                // 1. Tentukan path ke file controller
                $controllerFile = 'app/controllers/' . $controllerName . '.php';

                // 2. Cek apakah file controller-nya ada
                if (file_exists($controllerFile)) {
                    
                    // 3. Load file controller tersebut
                    require_once $controllerFile;

                    // 4. Buat instance controller (new HomeController())
                    $controllerInstance = new $controllerName();
                    
                    // 5. Panggil method-nya dengan parameter
                    call_user_func_array([$controllerInstance, $actionName], $params);
                    
                    return; // Berhenti mencari rute lain
                }
                // ===========================================
            }
        }

        // Jika loop selesai dan tidak ada rute yang cocok
        self::handleNotFound();
    }

    // --- FUNGSI HELPER (BANTUAN) ---

    private static function buildRegexPattern($path) {
        // Ganti {id} menjadi pola regex yang bisa menangkap parameter
        $pattern = preg_replace('/\/\{([^\/]+)\}/', '/(?<$1>[^\/]+)', $path);
        // Pastikan cocok dari awal sampai akhir
        $pattern = '#^' . $pattern . '$#';
        return $pattern;
    }

    private static function getParams($matches) {
        // Ambil parameter bernama (bukan angka) dari hasil regex
        $params = [];
        foreach ($matches as $key => $value) {
            if (is_string($key)) {
                $params[] = $value;
            }
        }
        return $params;
    }

    private static function handleNotFound() {
        http_response_code(404);
        echo "404 Not Found: Halaman tidak ditemukan.";
    }
}
?>