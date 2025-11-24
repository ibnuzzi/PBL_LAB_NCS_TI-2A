    <!--  ALl JS Plugins =====================
    ====================================== -->
    <!--  jquery-3.7.0 js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/jquery/jquery-3.7.0.min.js"></script>
    <!--  Bootstrap js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>/public/vendors/bootstrap-select/bootstrap-select.min.js"></script>
    <!--  jarallax js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/jarallax/jarallax.min.js"></script>
    <!--  jquery-ui js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/jquery-ui/jquery-ui.js"></script>
    <!--  jquery-ajaxchimp js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js"></script>
    <!--  jquery-appear js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/jquery-appear/jquery.appear.min.js"></script>
    <!-- jquery-circle-progress js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/jquery-circle-progress/jquery.circle-progress.min.js"></script>
    <!--  magnific-popup js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js"></script>
    <!--  validate js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/jquery-validate/jquery.validate.min.js"></script>
    <!--  nouislider js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/nouislider/nouislider.min.js"></script>
    <!--  wnumb js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/wnumb/wNumb.min.js"></script>
    <!--  owl-carousel js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/owl-carousel/js/owl.carousel.min.js"></script>
    <!--  Bootstrap js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/wow/wow.js"></script>
    <!--  wow js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/imagesloaded/imagesloaded.min.js"></script>
    <!--  isotope js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/isotope/isotope.js"></script>
    <!--  countdown js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/countdown/countdown.min.js"></script>
    <!--  Chart.js js plugins -->
    <script src="<?= BASE_URL ?>/public/js/Chart.min.js"></script>
    <!--  jquery-circleType js plugins -->
    <script src="<?= BASE_URL ?>/public/vendors/jquery-circleType/jquery.circleType.js"></script>
    <script src="<?= BASE_URL ?>/public/vendors/jquery-lettering/jquery.lettering.min.js"></script>
    <!-- template js -->
    <script src="<?= BASE_URL ?>/public/js/laboix.js"></script>
    <script>
        // Back to top: show after scrolling and smooth animate to top
        (function($){
            $(function(){
                var $btn = $('#back-to-top');
                if (!$btn.length) return;
                function toggleBtn(){
                    if ($(window).scrollTop() > 220) {
                        $btn.addClass('show');
                    } else {
                        $btn.removeClass('show');
                    }
                }
                toggleBtn();
                $(window).on('scroll', toggleBtn);
                $btn.on('click', function(e){
                    e.preventDefault();
                    $('html, body').animate({ scrollTop: 0 }, 600);
                });
            });
        })(jQuery);
    </script>
</body>
</html>