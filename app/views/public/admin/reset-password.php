<?php
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>

<section class="login-page">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-5 col-md-8 wow fadeInUp animated" data-wow-delay="300ms">

                <div class="login-card">

                    <div class="text-center mb-4">
                        <div class="login-logo-wrapper">
                            <img src="<?php echo BASE_URL; ?>/public/assets/images/ClearLogoJTI.png" alt="Lab NCS JTI" class="login-logo-img">
                        </div>
                    </div>

                    <h3 class="login-page__wrap__title">Reset Password</h3>
                    <p class="text-center text-muted mb-4">Masukkan password baru Anda</p>

                    <?php if (!empty($error)): ?>
                        <div class="login-error-alert">
                            <i class="fa fa-exclamation-circle me-2 login-error-icon"></i>
                            <div><?php echo $error; ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="login-success-alert">
                            <i class="fa fa-check-circle me-2 login-success-icon"></i>
                            <div><?php echo $success; ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!$tokenValid): ?>
                        <div class="text-center">
                            <div class="invalid-token-icon mb-4">
                                <i class="fa fa-times-circle"></i>
                            </div>
                            <p class="text-muted mb-4">Link reset password tidak valid atau sudah kadaluarsa.</p>
                            <a href="<?php echo BASE_URL; ?>/forgot-password" class="laboix-btn laboix-btn--secondary">
                                <span>Minta Link Baru</span>
                            </a>
                        </div>
                    <?php else: ?>
                        <form class="login-page__form" method="POST" action="<?php echo BASE_URL; ?>/reset-password">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

                            <div class="login-page__form-input-box mb-3">
                                <input type="password" name="password" placeholder="Password Baru" required minlength="6">
                            </div>

                            <div class="login-page__form-input-box mb-4">
                                <input type="password" name="password_confirm" placeholder="Konfirmasi Password" required minlength="6">
                            </div>

                            <div class="login-page__form-btn-box">
                                <button type="submit" class="laboix-btn laboix-btn--secondary">
                                    <span><i class="fa fa-save me-2"></i>SIMPAN PASSWORD</span>
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <a href="<?php echo BASE_URL; ?>/login" class="back-to-login-link">
                                    <i class="fa fa-arrow-left me-2"></i>Kembali ke Login
                                </a>
                            </div>

                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'app/views/templates/public/scripts.php';
?>