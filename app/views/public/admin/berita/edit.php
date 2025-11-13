<?php
// Use admin templates (header, sidebar, footer) to render this dashboard page
include  './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<!-- CONTENT -->
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold m-0">Edit Berita</h4>
                <a href="<?php echo BASE_URL; ?>/admin/berita" class="btn btn-outline-secondary">
                  <i class="bx bx-left-arrow-alt"></i> Kembali
                </a>
              </div>

              <div class="card mb-4">
                <div class="card-body">
                  <!-- ganti action ke file php mu -->
                  <form action="<?php echo BASE_URL; ?>/admin/berita/update/<?php echo htmlspecialchars($berita['id_berita'] ?? ''); ?>" method="POST" enctype="multipart/form-data">
                    <!-- Judul -->
                    <div class="mb-3">
                      <label for="judul_berita" class="form-label">Judul Berita</label>
                      <input
                        type="text"
                        class="form-control"
                        id="judul_berita"
                        name="judul_berita"
                        placeholder="Masukkan judul berita"
                        value="<?php echo htmlspecialchars($berita['judul_berita'] ?? ''); ?>"
                        required
                      />
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                      <label for="slug_berita" class="form-label">Slug (otomatis / manual)</label>
                      <input
                        type="text"
                        class="form-control"
                        id="slug_berita"
                        name="slug_berita"
                        placeholder="contoh: pelatihan-keamanan-siber"
                        value="<?php echo htmlspecialchars($berita['slug_berita'] ?? ''); ?>"
                      />
                      <small class="text-muted">Kalau dikosongkan nanti bisa dibuat otomatis di backend.</small>
                    </div>

                    <!-- Isi -->
                    <div class="mb-3">
                      <label for="isi_berita" class="form-label">Isi Berita</label>
                      <textarea
                        id="isi_berita"
                        name="isi_berita"
                        rows="5"
                        class="form-control"
                        placeholder="Tulis isi berita di sini..."
                        required
                      ><?php echo htmlspecialchars($berita['isi_berita'] ?? ''); ?></textarea>
                    </div>

                    <!-- Gambar -->
                    <div class="mb-3">
                      <label for="gambar_berita" class="form-label">Gambar Berita</label>
                      <?php if (!empty($berita['gambar_berita'])): ?>
                        <div class="mb-2">
                          <img src="<?php echo BASE_URL; ?>/public/uploads/berita/<?php echo htmlspecialchars($berita['gambar_berita']); ?>" alt="gambar" width="160" class="rounded-2" />
                        </div>
                      <?php else: ?>
                        <div class="text-muted small mb-2">Belum ada gambar.</div>
                      <?php endif; ?>
                      <input class="form-control" type="file" id="gambar_berita" name="gambar_berita" />
                      <small class="text-muted">Format: JPG, PNG. Disarankan ukuran landscape.</small>
                    </div>

                    <!-- Tanggal Publish -->
                    <div class="mb-3">
                      <label for="tanggal_publish" class="form-label">Tanggal Publish</label>
                      <?php
                        $tanggalValue = '';
                        if (!empty($berita['tanggal_publish'])) {
                          $dt = date_create($berita['tanggal_publish']);
                          if ($dt) $tanggalValue = date_format($dt, 'Y-m-d\TH:i');
                        }
                      ?>
                      <input
                        type="datetime-local"
                        class="form-control"
                        id="tanggal_publish"
                        name="tanggal_publish"
                        value="<?php echo $tanggalValue; ?>"
                        required
                      />
                    </div>

                    <!-- (opsional) id admin penulis -->
                    <input type="hidden" name="id_admin_penulis" value="1" />

                    <button type="submit" class="btn btn-primary">
                      <i class="bx bx-save"></i> Simpan
                    </button>
                    <button type="reset" class="btn btn-light">Reset</button>
                  </form>
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

            <div class="content-backdrop fade"></div>
          </div>
          <!-- /CONTENT -->
           <?php
// Footer (includes scripts)
include './app/views/templates/admin/footer_admin.php';
?>