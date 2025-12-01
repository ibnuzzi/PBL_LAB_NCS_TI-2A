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
                        <div style="width: 70px; height: 70px; background: #e0f7fa; color: #006064; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 28px;">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>

                    <h3 class="login-page__wrap__title">Login Admin</h3>

                    <?php if (!empty($error)): ?>
                        <div style="color: #721c24; background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; margin-bottom: 25px; border-radius: 8px; font-size: 14px; display: flex; align-items: center;">
                            <i class="fa fa-exclamation-circle me-2" style="font-size: 18px; margin-right: 10px;"></i>
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
                                <label for="save-data" style="font-size: 13px;">Ingat Saya</label>
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
                    <a href="<?php echo BASE_URL; ?>/" style="color: #6c757d; font-size: 14px; text-decoration: none; transition: color 0.3s;">
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