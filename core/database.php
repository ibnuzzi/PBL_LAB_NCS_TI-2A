<?php
// File: /app/core/Database.php

class Database
{
    // Properti untuk menyimpan koneksi
    private $driver = DB_DRIVER;
    private $host = DB_HOST;
    private $port = DB_PORT;
    private $db_name = DB_NAME;
    private $db_user = DB_USER;
    private $db_pass = DB_PASS;

    // Properti untuk PDO dan statement
    private $dbh; // Database handle (instance PDO)
    private $stmt; // Statement (prepared statement)
    private $error; // Error message

    // Instance (untuk pola Singleton)
    private static $instance = null;

    // Constructor (dibuat private untuk Singleton)
    private function __construct()
    {
        // --- INI BAGIAN YANG BERUBAH ---
        // Membuat Data Source Name (DSN) untuk PostgreSQL
        $dsn = $this->driver . ':host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name;
        // --- AKHIR BAGIAN YANG BERUBAH ---

        // Opsi untuk koneksi PDO
        $options = [
            PDO::ATTR_PERSISTENT => true, // Koneksi persistent (opsional)
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Mode error (penting)
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Mode fetch default
        ];

        // Membuat instance PDO baru
        try {
            // Kita gunakan $this->db_user dan $this->db_pass
            $this->dbh = new PDO($dsn, $this->db_user, $this->db_pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            // Tampilkan error jika koneksi gagal
            die("Koneksi Database Gagal: " . $this->error);
        }
    }

    // Pola Singleton untuk memastikan hanya ada satu koneksi
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Fungsi untuk menyiapkan query SQL
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Fungsi untuk binding parameter (misal: :id)
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Fungsi untuk eksekusi statement
    public function execute()
    {
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            die("Query Gagal: " . $this->error);
        }
    }

    // Fungsi untuk mendapatkan semua hasil (SELECT *)
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    // Fungsi untuk mendapatkan satu hasil (SELECT ... WHERE id=:id)
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch();
    }

    // Fungsi untuk menghitung jumlah baris (row count)
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    // Fungsi untuk mendapatkan ID terakhir yang di-insert
    public function lastInsertId()
    {
        // Catatan: PostgreSQL mungkin perlu parameter 'name' (nama sequence)
        // tapi untuk kasus auto-increment 'id' (SERIAL/BIGSERIAL), ini biasanya berfungsi.
        return $this->dbh->lastInsertId();
    }
}
