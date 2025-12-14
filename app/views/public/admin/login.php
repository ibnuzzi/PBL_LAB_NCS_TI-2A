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

                    <h3 class="login-page__wrap__title">Admin</h3>

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

                    <form class="login-page__form" method="POST" action="<?php echo BASE_URL; ?>/login">

                        <div class="login-page__form-input-box mb-3">
                            <input type="email" name="email" placeholder="Email Address" required>
                        </div>

                        <div class="login-page__form-input-box mb-4">
                            <input type="password" name="password" placeholder="Password" required>
                        </div>

                        <div class="login-page__form-btn-box">
                            <button type="submit" class="laboix-btn laboix-btn--secondary">
                                <span>LOGIN</span>
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <a href="<?php echo BASE_URL; ?>/forgot-password" class="forgot-password-link" style="color: #1d4ed8;">
                                <i class="fa fa-key me-2"></i>Lupa Password?
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'app/views/templates/public/scripts.php';
?>