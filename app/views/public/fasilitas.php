<?php
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(public/assets/images/bg-gedung.jpg);background-position: center 40%;background-size: cover;"></div>
    <div class="container">
        <h2 class="page-header__title">Fasilitas & Sarana Prasarana</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="<?= BASE_URL ?>">Beranda</a></li>
            <li><span>Layanan</span></li>
            <li><span>Fasilitas Lab</span></li>
        </ul>
    </div>
</section>

<section class="service-details" style="padding: 80px 0; background-color: #f8f9fa;">
    <div class="container">
        <!-- Section Title -->
        <div class="text-center mb-5">
            <h3 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #333; margin-bottom: 15px;">
                Fasilitas Laboratorium
            </h3>
            <p class="section-subtitle" style="font-size: 1.1rem; color: #666; max-width: 700px; margin: 0 auto;">
                Laboratorium NCS dilengkapi dengan berbagai fasilitas dan sarana prasarana modern untuk mendukung kegiatan penelitian dan praktikum
            </p>
        </div>

        <!-- Facilities Grid -->
        <div class="row g-4">
            <?php if (!empty($data['fasilitasList'])):
                foreach ($data['fasilitasList'] as $fasilitas):
            ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="facility-card" style="
                    background: #fff;
                    border-radius: 15px;
                    overflow: hidden;
                    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
                    transition: all 0.3s ease;
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                " onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 20px rgba(0,0,0,0.08)'">

                            <!-- Image -->
                            <div class="facility-image" style="
                        width: 100%;
                        height: 250px;
                        overflow: hidden;
                        position: relative;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    ">
                                <?php if (!empty($fasilitas['foto_sarana'])): ?>
                                    <img src="<?= BASE_URL ?>/public/uploads/sarana/<?= htmlspecialchars($fasilitas['foto_sarana']) ?>"
                                        alt="<?= htmlspecialchars($fasilitas['nama_sarana'] ?? 'Fasilitas') ?>"
                                        style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                                        onmouseover="this.style.transform='scale(1.1)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                <?php else: ?>
                                    <div style="
                                width: 100%;
                                height: 100%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                font-size: 4rem;
                                color: rgba(255,255,255,0.3);
                            ">
                                        <i class="fa fa-microscope"></i>
                                    </div>
                                <?php endif; ?>

                                <!-- Quantity Badge -->
                                <?php if (!empty($fasilitas['jumlah'])): ?>
                                    <div style="
                            position: absolute;
                            top: 15px;
                            right: 15px;
                            background: #2563EB;
                            color: white;
                            padding: 8px 16px;
                            border-radius: 25px;
                            font-weight: 600;
                            font-size: 0.9rem;
                            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                        ">
                                        <i class="fa fa-layer-group"></i> <?= htmlspecialchars($fasilitas['jumlah']) ?> Unit
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Content -->
                            <div class="facility-content" style="padding: 25px; flex: 1; display: flex; flex-direction: column;">
                                <h4 style="
                            font-size: 1.4rem;
                            font-weight: 700;
                            color: #333;
                            margin-bottom: 15px;
                            line-height: 1.4;
                        ">
                                    <?= htmlspecialchars($fasilitas['nama_sarana'] ?? 'Fasilitas') ?>
                                </h4>

                                <p style="
                            color: #666;
                            line-height: 1.8;
                            font-size: 0.95rem;
                            margin-bottom: 20px;
                            flex: 1;
                        ">
                                    <?= nl2br(htmlspecialchars($fasilitas['deskripsi_sarana'] ?? 'Deskripsi tidak tersedia')) ?>
                                </p>

                                <!-- Footer Info -->
                                <div style="
                            padding-top: 15px;
                            border-top: 1px solid #eee;
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                        ">
                                    <span style="color: #999; font-size: 0.85rem;">
                                        <i class="fa fa-clock"></i> Diperbarui: <?= date('d M Y', strtotime($fasilitas['created_at'] ?? date('Y-m-d'))) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
            else:
                ?>
                <!-- No Data Message -->
                <div class="col-12">
                    <div class="alert" style="
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    border: none;
                    border-radius: 15px;
                    padding: 40px;
                    text-align: center;
                    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
                ">
                        <i class="fa fa-info-circle" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.9;"></i>
                        <h4 style="margin-bottom: 10px; font-weight: 600;">Tidak Ada Data Fasilitas</h4>
                        <p style="margin: 0; opacity: 0.9;">Belum ada data fasilitas yang tersedia saat ini.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if (!empty($data['fasilitasList']) && $data['totalPages'] > 1): ?>
            <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="Pagination Navigation">
                        <ul class="pagination justify-content-center" style="gap: 10px; flex-wrap: wrap;">
                            <!-- Previous Button -->
                            <?php if ($data['currentPage'] > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $data['currentPage'] - 1 ?>" style="
                                border: none;
                                border-radius: 10px;
                                padding: 12px 20px;
                                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                color: white;
                                font-weight: 600;
                                transition: all 0.3s ease;
                                box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
                            " onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(102, 126, 234, 0.4)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'">
                                        <i class="fa fa-chevron-left"></i> Sebelumnya
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Page Numbers -->
                            <?php
                            $startPage = max(1, $data['currentPage'] - 2);
                            $endPage = min($data['totalPages'], $data['currentPage'] + 2);

                            for ($i = $startPage; $i <= $endPage; $i++):
                            ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $i ?>" style="
                                border: 2px solid #667eea;
                                border-radius: 10px;
                                padding: 12px 18px;
                                background: <?= $i == $data['currentPage'] ? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' : 'white' ?>;
                                color: <?= $i == $data['currentPage'] ? 'white' : '#667eea' ?>;
                                font-weight: 600;
                                transition: all 0.3s ease;
                                min-width: 50px;
                                text-align: center;
                                box-shadow: <?= $i == $data['currentPage'] ? '0 4px 12px rgba(102, 126, 234, 0.3)' : 'none' ?>;
                            " <?= $i != $data['currentPage'] ? "onmouseover=\"this.style.background='#667eea'; this.style.color='white'\" onmouseout=\"this.style.background='white'; this.style.color='#667eea'\"" : '' ?>>
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next Button -->
                            <?php if ($data['currentPage'] < $data['totalPages']): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $data['currentPage'] + 1 ?>" style="
                                border: none;
                                border-radius: 10px;
                                padding: 12px 20px;
                                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                color: white;
                                font-weight: 600;
                                transition: all 0.3s ease;
                                box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
                            " onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(102, 126, 234, 0.4)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'">
                                        Selanjutnya <i class="fa fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>