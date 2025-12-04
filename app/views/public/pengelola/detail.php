<?php
// File: app/views/public/pengelola/detail.php
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';

// Handle photo path
$photoPath = BASE_URL . '/public/assets/images/team/default-avatar.jpg';
if (!empty($pengelola['foto_pengelola'])) {
    $imageName = ltrim(trim($pengelola['foto_pengelola']), '/');
    $photoPath = BASE_URL . '/public/uploads/pengelola/' . $imageName;
    $serverPath = __DIR__ . '/../../../../public/uploads/pengelola/' . $imageName;
    if (!@file_exists($serverPath)) {
        $photoPath = BASE_URL . '/public/assets/images/team/default-avatar.jpg';
    }
}
?>

<!-- Page Header -->
<section class="page-header">
    <div class="page-header__bg" style="background-image: url(<?= BASE_URL ?>/public/assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <div class="container">
        <h2 class="page-header__title">Profil Pengelola</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="<?= BASE_URL ?>">Beranda</a></li>
            <li><a href="<?= BASE_URL ?>/tentang">Tentang Kami</a></li>
            <li><span>Profil Pengelola</span></li>
        </ul>
    </div>
</section>

<!-- Pengelola Detail Section -->
<section class="pengelola-detail-section">
    <div class="container">
        <div class="row">
            <!-- Main Profile Card -->
            <div class="col-lg-4 col-md-5">
                <div class="pengelola-profile-card wow fadeInLeft" data-wow-duration="700ms">
                    <div class="pengelola-profile-card__image">
                        <div class="pengelola-profile-card__image-wrapper">
                            <img src="<?= $photoPath ?>" alt="<?= htmlspecialchars($pengelola['nama_pengelola'] ?? 'Pengelola') ?>" onerror="this.onerror=null;this.src='<?= BASE_URL ?>/public/assets/images/team/default-avatar.jpg';">
                            <div class="pengelola-profile-card__image-overlay"></div>
                        </div>
                    </div>
                    
                    <div class="pengelola-profile-card__content">
                        <h3 class="pengelola-profile-card__name">
                            <?= htmlspecialchars($pengelola['nama_pengelola'] ?? 'Unknown') ?>
                        </h3>
                        
                        <?php if (!empty($pengelola['nama_jabatan'])): ?>
                            <div class="pengelola-profile-card__position">
                                <i class="fas fa-user-tie"></i>
                                <span><?= htmlspecialchars($pengelola['nama_jabatan']) ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($pengelola['nid_nip'])): ?>
                            <div class="pengelola-profile-card__nip">
                                <i class="fas fa-id-card"></i>
                                <span>NIP: <?= htmlspecialchars($pengelola['nid_nip']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Information Section -->
            <div class="col-lg-8 col-md-7">
                <div class="pengelola-detail-content wow fadeInRight" data-wow-duration="700ms">
                    <!-- Informasi Umum -->
                    <div class="pengelola-detail-box">
                        <div class="pengelola-detail-box__header">
                            <div class="pengelola-detail-box__icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h4 class="pengelola-detail-box__title">Informasi Umum</h4>
                        </div>
                        
                        <div class="pengelola-detail-box__content">
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="info-item__label">
                                        <i class="fas fa-user"></i>
                                        Nama Lengkap
                                    </span>
                                    <span class="info-item__value">
                                        <?= htmlspecialchars($pengelola['nama_pengelola'] ?? '-') ?>
                                    </span>
                                </div>
                                
                                <?php if (!empty($pengelola['nid_nip'])): ?>
                                    <div class="info-item">
                                        <span class="info-item__label">
                                            <i class="fas fa-id-badge"></i>
                                            NID/NIP
                                        </span>
                                        <span class="info-item__value">
                                            <?= htmlspecialchars($pengelola['nid_nip']) ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($pengelola['nama_jabatan'])): ?>
                                    <div class="info-item">
                                        <span class="info-item__label">
                                            <i class="fas fa-briefcase"></i>
                                            Jabatan
                                        </span>
                                        <span class="info-item__value">
                                            <?= htmlspecialchars($pengelola['nama_jabatan']) ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($pengelola['jabatan_deskripsi'])): ?>
                                    <div class="info-item info-item--full">
                                        <span class="info-item__label">
                                            <i class="fas fa-file-alt"></i>
                                            Jabatan Deskripsi
                                        </span>
                                        <span class="info-item__value">
                                            <?= htmlspecialchars($pengelola['jabatan_deskripsi']) ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Bidang Keminatan -->
                    <?php if (!empty($keminatanList)): ?>
                        <div class="pengelola-detail-box">
                            <div class="pengelola-detail-box__header">
                                <div class="pengelola-detail-box__icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <h4 class="pengelola-detail-box__title">Bidang Keminatan</h4>
                            </div>
                            
                            <div class="pengelola-detail-box__content">
                                <div class="keminatan-grid">
                                    <?php foreach ($keminatanList as $keminatan): ?>
                                        <div class="keminatan-card">
                                            <div class="keminatan-card__icon">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                            <div class="keminatan-card__content">
                                                <h5 class="keminatan-card__title">
                                                    <?= htmlspecialchars($keminatan['nama_keminatan']) ?>
                                                </h5>
                                                <?php if (!empty($keminatan['deskripsi'])): ?>
                                                    <p class="keminatan-card__desc">
                                                        <?= htmlspecialchars($keminatan['deskripsi']) ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Back Button -->
                    <div class="pengelola-detail-actions">
                        <a href="<?= BASE_URL ?>/tentang#struktur" class="btn-back">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali ke Struktur Pengelola</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Pengelola Detail Section */
.pengelola-detail-section {
    padding: 80px 0;
    background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);
}

/* Profile Card */
.pengelola-profile-card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 30px;
}

.pengelola-profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
}

.pengelola-profile-card__image {
    position: relative;
    padding-top: 100%;
    overflow: hidden;
    background: linear-gradient(135deg, #1a3a6b 0%, #2d5a9e 100%);
}

.pengelola-profile-card__image-wrapper {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.pengelola-profile-card__image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.pengelola-profile-card__image-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 40%;
    background: linear-gradient(to top, rgba(26, 58, 107, 0.8) 0%, transparent 100%);
}

.pengelola-profile-card__content {
    padding: 30px 25px;
    text-align: center;
}

.pengelola-profile-card__name {
    font-size: 24px;
    font-weight: 700;
    color: #1a3a6b;
    margin-bottom: 20px;
    line-height: 1.3;
}

.pengelola-profile-card__position,
.pengelola-profile-card__nip {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 20px;
    margin-bottom: 12px;
    background: linear-gradient(135deg, rgba(26, 58, 107, 0.05) 0%, rgba(45, 90, 158, 0.05) 100%);
    border-radius: 10px;
    font-size: 15px;
    color: #444;
}

.pengelola-profile-card__position i,
.pengelola-profile-card__nip i {
    color: #1a3a6b;
    font-size: 16px;
}

.pengelola-profile-card__position:last-child,
.pengelola-profile-card__nip:last-child {
    margin-bottom: 0;
}

/* Detail Content */
.pengelola-detail-content {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

/* Detail Box */
.pengelola-detail-box {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.pengelola-detail-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
}

.pengelola-detail-box__header {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 25px 30px;
    background: linear-gradient(135deg, #1a3a6b 0%, #2d5a9e 100%);
    border-bottom: 3px solid #0EBD66;
}

.pengelola-detail-box__icon {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.pengelola-detail-box__icon i {
    color: #ffffff;
    font-size: 20px;
}

.pengelola-detail-box__title {
    color: #ffffff;
    font-size: 20px;
    font-weight: 700;
    margin: 0;
}

.pengelola-detail-box__content {
    padding: 30px;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 20px;
    background: linear-gradient(135deg, rgba(26, 58, 107, 0.03) 0%, rgba(45, 90, 158, 0.03) 100%);
    border-radius: 12px;
    border-left: 4px solid #0EBD66;
    transition: all 0.3s ease;
}

.info-item:hover {
    background: linear-gradient(135deg, rgba(26, 58, 107, 0.08) 0%, rgba(45, 90, 158, 0.08) 100%);
    transform: translateX(5px);
}

.info-item__label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 600;
    color: #1a3a6b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-item__label i {
    color: #0EBD66;
    font-size: 14px;
}

.info-item__value {
    font-size: 16px;
    color: #444;
    line-height: 1.6;
    padding-left: 24px;
}

.info-item--full {
    grid-column: 1 / -1;
}

/* Keminatan Grid */
.keminatan-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
}

.keminatan-card {
    display: flex;
    gap: 15px;
    padding: 20px;
    background: linear-gradient(135deg, rgba(14, 189, 102, 0.05) 0%, rgba(26, 58, 107, 0.05) 100%);
    border-radius: 12px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.keminatan-card:hover {
    border-color: #0EBD66;
    background: linear-gradient(135deg, rgba(14, 189, 102, 0.1) 0%, rgba(26, 58, 107, 0.1) 100%);
    transform: translateX(5px);
}

.keminatan-card__icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #0EBD66 0%, #0ca857 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.keminatan-card__icon i {
    color: #ffffff;
    font-size: 18px;
}

.keminatan-card__content {
    flex: 1;
}

.keminatan-card__title {
    font-size: 17px;
    font-weight: 700;
    color: #1a3a6b;
    margin-bottom: 8px;
}

.keminatan-card__desc {
    font-size: 14px;
    color: #666;
    line-height: 1.6;
    margin: 0;
}

/* Actions */
.pengelola-detail-actions {
    display: flex;
    justify-content: center;
    padding-top: 15px;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 30px;
    background: linear-gradient(135deg, #1a3a6b 0%, #2d5a9e 100%);
    color: #ffffff;
    text-decoration: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(26, 58, 107, 0.2);
}

.btn-back:hover {
    background: linear-gradient(135deg, #0EBD66 0%, #0ca857 100%);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(14, 189, 102, 0.3);
}

.btn-back i {
    font-size: 14px;
}

/* Responsive */
@media (max-width: 991px) {
    .pengelola-detail-section {
        padding: 60px 0;
    }
    
    .pengelola-profile-card {
        margin-bottom: 30px;
    }
    
    .pengelola-profile-card__name {
        font-size: 22px;
    }
}

@media (max-width: 575px) {
    .pengelola-detail-box__header {
        padding: 20px;
        flex-direction: column;
        text-align: center;
    }
    
    .pengelola-detail-box__content {
        padding: 20px;
    }
    
    .pengelola-detail-box__title {
        font-size: 18px;
    }
    
    .info-item__value {
        padding-left: 0;
    }
    
    .btn-back {
        width: 100%;
        justify-content: center;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.wow {
    animation-duration: 0.7s;
    animation-fill-mode: both;
}

.fadeInLeft {
    animation-name: fadeInLeft;
}

.fadeInRight {
    animation-name: fadeInRight;
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>

<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>
