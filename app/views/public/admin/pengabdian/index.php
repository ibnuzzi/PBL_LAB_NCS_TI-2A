<?php
// Use admin templates (header, sidebar, footer) to render this dashboard page
include  './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Manajemen Arsip /</span> Pengabdian</h4>
                <a href="<?php echo BASE_URL; ?>/admin/pengabdian/create" class="btn btn-primary">
                  <i class="bx bx-plus"></i> Tambah Pengabdian
                </a>
              </div>

              <div class="card">
                <h5 class="card-header">Daftar Pengabdian</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>ID Pengabdian</th>
                        <th>Judul Kegiatan</th>
                        <th>Tim Pengabdi</th>
                        <th>Tahun</th>
                        <th>Deskripsi Kegiatan</th>
                        <th>File Dokumen</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <!-- Example data (replace with actual data from DB) -->
                      <tr>
                        <td>1</td>
                        <td>Pengabdian Masyarakat di Desa Cempaka</td>
                        <td>Dr. Budi, Tim A</td>
                        <td>2025</td>
                        <td>Penyuluhan dan pelatihan mengenai teknologi pertanian</td>
                        <td><a href="file_dokumen.pdf">Download</a></td>
                        <td>
                          <a href="<?php echo BASE_URL; ?>/admin/pengabdian/edit" class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-edit"></i> Edit
                          </a>
                          <button class="btn btn-sm btn-outline-danger">
                            <i class="bx bx-trash"></i> Hapus
                          </button>
                        </td>
                      </tr>
                      <!-- End Example -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- FOOTER -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , dibuat dengan ❤️ oleh
                  <a href="#" class="footer-link fw-bolder">Lab NCS</a>
                </div>
              </div>
            </footer>
            <!-- /FOOTER -->



<?php
// Footer (includes scripts)
include './app/views/templates/admin/footer_admin.php';
?>
<script>
      $(document).ready(function () {
        $('.btn-view-berita').on('click', function () {
          var judul = $(this).data('judul');
          var deskripsi = $(this).data('deskripsi');
          var gambar = $(this).data('gambar');
          var tanggal = $(this).data('tanggal');

          $('#modalDetailJudul').text(judul);
          $('#modalDetailDeskripsi').text(deskripsi);
          $('#modalDetailGambar').attr('src', gambar);
          $('#modalDetailTanggal').text(tanggal);

          var modal = new bootstrap.Modal(document.getElementById('modalDetailBerita'));
          modal.show();
        });
      });
    </script>