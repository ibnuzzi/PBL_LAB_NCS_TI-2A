<?php
// File: /app/core/Controller.php

/**
 * Ini adalah Base Controller (Controller Induk)
 * Semua controller lain akan 'extends' ke kelas ini.
 */
class Controller
{

    /**
     * Fungsi helper untuk memanggil file View
     * Fungsi ini akan meload file HTML di dalam folder /app/views/
     *
     * @param string $view Nama file view (misal: 'public/home')
     * @param array $data Data yang ingin dikirim ke view (opsional)
     */
    public function view($view_name, $data = [])
    {

        // Ekstrak array $data menjadi variabel-variabel
        // Contoh: $data['judul'] akan menjadi variabel $judul di dalam file view
        extract($data);

        // Cek apakah file view-nya ada
        if (file_exists('app/views/' . $view_name . '.php')) {

            // Jika ada, panggil file view tersebut
            require_once 'app/views/' . $view_name . '.php';
        } else {
            // Jika file tidak ada, tampilkan error
            die('Error: File View "' . $view_name . '" tidak ditemukan.');
        }
    }

    /**
     * Fungsi helper untuk memanggil file Model
     * Fungsi ini akan membuat instance dari model yang ada di /app/models/
     *
     * @param string $model_name Nama file model (misal: 'Berita')
     * @return object Instance dari model tersebut
     */
    public function model($model_name)
    {

        // Cek apakah file model-nya ada
        if (file_exists('app/models/' . $model_name . '.php')) {

            // Load file model-nya
            require_once 'app/models/' . $model_name . '.php';

            // Buat instance baru dari model tsb (misal: new Berita())
            // dan kembalikan (return) object-nya
            return new $model_name();
        } else {
            // Jika file tidak ada, tampilkan error
            die('Error: File Model "' . $model_name . '" tidak ditemukan.');
        }
    }

    // Service method removed as services are no longer used
}
