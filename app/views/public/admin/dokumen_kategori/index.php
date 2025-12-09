<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">Manajemen Arsip /</span> Kategori Dokumen
            </h4>
            <button type="button" class="btn btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modalKategori">
                <i class="bx bx-plus me-1"></i> Tambah Kategori
            </button>
        </div>

        <div class="card">
            <h5 class="card-header">Daftar Kategori Arsip</h5>
            <div class="table-responsive text-nowrap">
                <table id="table-kategori" class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 70px;">No</th>
                            <th>Nama Kategori</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if (empty($kategori) || !is_array($kategori)): ?>
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="bx bx-folder-open bx-lg mb-2"></i>
                                    <p>Belum ada kategori arsip.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($kategori as $row): ?>
                                <tr>
                                    <td><strong><?= $no++ ?></strong></td>
                                    <td>
                                        <span class="fw-medium"><?= htmlspecialchars($row['nama_kategori']) ?></span>
                                    </td>
                                    <td>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info btn-edit"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalKategori"
                                                data-id="<?= $row['id_kategori_arsip'] ?>"
                                                data-nama="<?= htmlspecialchars($row['nama_kategori']) ?>">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </button>

                                        <a href="<?= BASE_URL ?>/admin/dokumen_kategori/delete/<?= $row['id_kategori_arsip'] ?>" 
                                           class="btn btn-sm btn-outline-danger ms-1 btn-delete">
                                            <i class="bx bx-trash me-1"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="content-backdrop fade"></div>
</div>
<?php
  include './app/views/components/modal.php';
  include './app/views/components/toaster.php';
  ?>
<div class="modal fade" id="modalKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="modalTitle">Tambah Kategori</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="formKategori" action="<?= BASE_URL ?>/admin/kategori_arsip/store" method="POST">
                <div class="modal-body">
                    
                    <input type="hidden" name="id_kategori_arsip" id="modal_id_kategori">

                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_kategori" id="modal_nama_kategori" placeholder="Contoh: Modul Praktikum" required>
                        <div class="form-text">Nama kategori untuk pengelompokan dokumen.</div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include './app/views/templates/admin/footer_admin.php';
$table_name = 'kategori';
include './app/views/components/page_scripts.php';
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalKategori');
        const form = document.getElementById('formKategori');
        const modalTitle = document.getElementById('modalTitle');
        
        const inputId = document.getElementById('modal_id_kategori');
        const inputNama = document.getElementById('modal_nama_kategori');

        // URL Dasar
        const baseUrl = '<?= BASE_URL ?>';

        // 1. Logic saat Tombol TAMBAH diklik
        document.querySelector('.btn-tambah').addEventListener('click', function() {
            modalTitle.textContent = 'Tambah Kategori Baru';
            form.action = baseUrl + '/admin/dokumen_kategori/store'; // Arahkan ke method store
            
            // Reset Form
            inputId.value = '';
            inputNama.value = '';
        });

        // 2. Logic saat Tombol EDIT diklik
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Ambil data dari tombol
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                // Ubah Tampilan Modal
                modalTitle.textContent = 'Edit Kategori';
                form.action = baseUrl + '/admin/dokumen_kategori/update'; // Arahkan ke method update

                // Isi Form
                inputId.value = id;
                inputNama.value = nama;
            });
        });
    });
</script>