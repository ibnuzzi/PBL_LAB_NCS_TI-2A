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
                        <div class="login-icon-wrapper">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>

                    <h3 class="login-page__wrap__title">Login Admin</h3>

                    <?php if (!empty($error)): ?>
                        <div class="login-error-alert">
                            <i class="fa fa-exclamation-circle me-2 login-error-icon"></i>
                            <div><?php echo $error; ?></div>
                        </div>
                    <?php endif; ?>

                    <form class="login-page__form" method="POST" action="<?php echo BASE_URL; ?>/login">

                        <div class="login-page__form-input-box mb-3">
                            <input type="email" name="email" placeholder="Email Address" required>
                        </div>

                        <div class="login-page__form-input-box mb-4">
                            <input type="password" name="password" placeholder="Password" required>
                        </div>

                        <div class="login-page__checked-box d-flex justify-content-between align-items-center mb-4">
                            <div class="login-page__checked-inner">
                                <input type="checkbox" name="save-data" id="save-data">
                                <label for="save-data" class="login-remember-label">Ingat Saya</label>
                            </div>
                        </div>

                        <div class="login-page__form-btn-box">
                            <button type="submit" class="laboix-btn laboix-btn--secondary">
                                <span>MASUK DASHBOARD</span>
                            </button>
                        </div>

                    </form>
                </div>
                <div class="text-center mt-4">
                    <a href="<?php echo BASE_URL; ?>/" class="login-back-link">
                        <i class="fa fa-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>