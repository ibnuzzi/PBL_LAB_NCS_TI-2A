
<?php
// File: /app/controllers/AdminKonsultasiController.php

class AdminKonsultasiController extends Controller
{
    public function __construct()
    {
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    public function index()
    {
        $konsultasiModel = $this->model('Konsultasi');

        $data = [
            'judul_halaman' => 'Manajemen Konsultasi - Lab NCS',
            'konsultasi'    => $konsultasiModel->getAll()
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/konsultasi/index', $data); // reuse view folder with changes
        $this->view('templates/admin/footer_admin');
    }

    public function create()
    {
        // Admin may not create konsultasi manually, so redirect to index
        header('Location: ' . BASE_URL . '/admin/konsultasi');
        exit;
    }

    public function store()
    {
        // Admin typically does not store konsultasi, so redirect to index
        header('Location: ' . BASE_URL . '/admin/konsultasi');
        exit;
    }

    public function edit()
    {
        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;

        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        $konsultasiModel = $this->model('Konsultasi');
        $row = $konsultasiModel->getById($id);

        if (!$row) {
            $_SESSION['error_message'] = 'Data konsultasi tidak ditemukan.';
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        $data = [
            'judul_halaman' => 'Jawab Konsultasi',
            'konsultasi'    => $row
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/jasa_layanan/edit', $data); // reuse edit view with changes
        $this->view('templates/admin/footer_admin');
    }

    // File: /app/controllers/AdminKonsultasiController.php

    public function update()
    {
        // Legacy method - redirects to index
        // Use approve() or reject() instead
        header('Location: ' . BASE_URL . '/admin/konsultasi');
        exit;
    }

    /**
     * Approve (accept) a consultation and send email notification
     */
    public function approve()
    {
        // Check POST method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        // Get consultation ID from POST
        $id = isset($_POST['id_konsultasi']) ? (int)$_POST['id_konsultasi'] : 0;

        // Validate ID
        if ($id <= 0) {
            $_SESSION['error_message'] = 'ID Konsultasi tidak valid.';
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        // Get answer
        $jawaban = trim($_POST['jawaban'] ?? '');

        if (empty($jawaban)) {
            $_SESSION['error_message'] = 'Jawaban tidak boleh kosong.';
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        // Get admin ID
        $id_admin_penjawab = $_SESSION['admin_id'] ?? 1;

        $konsultasiModel = $this->model('Konsultasi');
        
        // Get consultation details for email
        $consultation = $konsultasiModel->getById($id);
        
        if (!$consultation) {
            $_SESSION['error_message'] = 'Data konsultasi tidak ditemukan.';
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        // Update status to 'diterima'
        $ok = $konsultasiModel->updateStatusAccept($id, $jawaban, (int)$id_admin_penjawab);

        if ($ok) {
            // Send acceptance email
            require_once './app/services/EmailService.php';
            $emailService = new EmailService();
            
            $emailSent = $emailService->sendAcceptanceEmail(
                $consultation['email_penanya'],
                $consultation['nama_penanya'],
                $consultation['pertanyaan'],
                $jawaban
            );

            if ($emailSent) {
                $_SESSION['success_message'] = 'Konsultasi berhasil diterima dan email notifikasi telah dikirim.';
            } else {
                $_SESSION['success_message'] = 'Konsultasi berhasil diterima, namun email gagal dikirim.';
            }
        } else {
            $_SESSION['error_message'] = 'Gagal menerima konsultasi.';
        }

        header('Location: ' . BASE_URL . '/admin/konsultasi');
        exit;
    }

    /**
     * Reject a consultation and send email notification
     */
    public function reject()
    {
        // Check POST method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        // Get consultation ID from POST
        $id = isset($_POST['id_konsultasi']) ? (int)$_POST['id_konsultasi'] : 0;

        // Validate ID
        if ($id <= 0) {
            $_SESSION['error_message'] = 'ID Konsultasi tidak valid.';
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        // Get rejection reason
        $alasan_tolak = trim($_POST['alasan_tolak'] ?? '');

        if (empty($alasan_tolak)) {
            $_SESSION['error_message'] = 'Alasan penolakan tidak boleh kosong.';
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        // Get admin ID
        $id_admin_penjawab = $_SESSION['admin_id'] ?? 1;

        $konsultasiModel = $this->model('Konsultasi');
        
        // Get consultation details for email
        $consultation = $konsultasiModel->getById($id);
        
        if (!$consultation) {
            $_SESSION['error_message'] = 'Data konsultasi tidak ditemukan.';
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        // Update status to 'ditolak'
        $ok = $konsultasiModel->updateStatusReject($id, $alasan_tolak, (int)$id_admin_penjawab);

        if ($ok) {
            // Send rejection email
            require_once './app/services/EmailService.php';
            $emailService = new EmailService();
            
            $emailSent = $emailService->sendRejectionEmail(
                $consultation['email_penanya'],
                $consultation['nama_penanya'],
                $consultation['pertanyaan'],
                $alasan_tolak
            );

            if ($emailSent) {
                $_SESSION['success_message'] = 'Konsultasi berhasil ditolak dan email notifikasi telah dikirim.';
            } else {
                $_SESSION['success_message'] = 'Konsultasi berhasil ditolak, namun email gagal dikirim.';
            }
        } else {
            $_SESSION['error_message'] = 'Gagal menolak konsultasi.';
        }

        header('Location: ' . BASE_URL . '/admin/konsultasi');
        exit;
    }

    public function delete()
    {
        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;

        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/konsultasi');
            exit;
        }

        $konsultasiModel = $this->model('Konsultasi');
        $ok = $konsultasiModel->delete($id);

        if ($ok) {
            $_SESSION['success_message'] = 'Konsultasi berhasil dihapus.';
        } else {
            $_SESSION['error_message'] = 'Gagal menghapus konsultasi.';
        }

        header('Location: ' . BASE_URL . '/admin/konsultasi');
        exit;
    }
}
