<?php
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>

<section class="login-page">
    <div class="container">
        <div class="login-page__inner">
            <div class="row gutter-x-94 justify-content-center">
                <div class="col-lg-6 wow fadeInUp animated" data-wow-delay="300ms">
                    <div class="login-card">
                        <h3 class="login-page__wrap__title">Login Admin</h3>

                        <?php if (!empty($error)): ?>
                            <div style="color: red; background: #ffebee; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        
                        <form class="login-page__form" method="POST" action="<?php echo BASE_URL; ?>/login">
                            
                            <div class="login-page__form-input-box">
                                <input type="email" name="email" placeholder="masukkan email" required>
                            </div>
                            
                            <div class="login-page__form-input-box">
                                <input type="password" name="password" placeholder="masukkan password" required>
                            </div>
                            
                            <div class="login-page__checked-box">
                                <div class="login-page__checked-inner">
                                    <input type="checkbox" name="save-data" id="save-data">
                                    <label for="save-data"><span></span>Remember me?</label>
                                </div>
                                <div class="login-page__form-forgot-password">
                                    <a href="#" class="login-page__form-forgot-password__item">Forget password?</a>
                                </div>
                            </div>
                            
                            <div class="login-page__form-btn-box">
                                <button type="submit" class="laboix-btn laboix-btn--secondary"><span>Login</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>