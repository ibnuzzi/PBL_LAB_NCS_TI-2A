<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
      <div class="mb-2 mb-md-0">
        ©
        <script>
          document.write(new Date().getFullYear());
        </script>
        , Lab NCS
      </div>
    </div>
  </footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="<?= BASE_URL ?>/public/admin/vendor/libs/jquery/jquery.js"></script>
<script src="<?= BASE_URL ?>/public/admin/vendor/libs/popper/popper.js"></script>
<script src="<?= BASE_URL ?>/public/admin/vendor/js/bootstrap.js"></script>
<script src="<?= BASE_URL ?>/public/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?= BASE_URL ?>/public/admin/vendor/libs/chartjs/chartjs.js"></script>
<script src="<?= BASE_URL ?>/public/admin/vendor/js/menu.js"></script>
<script src="<?= BASE_URL ?>/public/admin/js/main.js"></script>

<script src="<?= BASE_URL ?>/public/admin/vendor/libs/pickr/pickr.js"></script>
<script src="<?= BASE_URL ?>/public/admin/vendor/libs/hammer/hammer.js"></script>
<script src="<?= BASE_URL ?>/public/admin/vendor/libs/i18n/i18n.js"></script>
<!-- Vendors JS -->
<script src="<?= BASE_URL ?>/public/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<!-- Flat Picker -->
<script src="<?= BASE_URL ?>/public/admin/vendor/libs/moment/moment.js"></script>
<script src="<?= BASE_URL ?>/public/admin/vendor/libs/flatpickr/flatpickr.js"></script>
<!-- Form Validation -->
<script src="<?= BASE_URL ?>/public/admin/vendor/libs/@form-validation/popular.js"></script>
<script src="<?= BASE_URL ?>/public/admin/vendor/libs/@form-validation/bootstrap5.js"></script>
<script src="<?= BASE_URL ?>/public/admin/vendor/libs/@form-validation/auto-focus.js"></script>

<!-- Main JS -->

<script src="<?= BASE_URL ?>/public/admin/js/main.js"></script>


<!-- Page JS -->
<script src="<?= BASE_URL ?>/public/admin/js/tables-datatables-basic.js"></script>

<script>
$(document).ready(function() {
 
  $(document).on('show.bs.modal', '.modal', function (event) {

    var button = $(event.relatedTarget); 
    if (!button.length) {
      return;
    }

    var modal = $(this);

    var data = button.data();

    modal.find('[data-fill-text]').each(function() {
      var key = $(this).data('fill-text'); 
      if (data[key] !== undefined) {
        $(this).text(data[key]);
      }
    });

    modal.find('[data-fill-src]').each(function() {
      var key = $(this).data('fill-src'); 
      if (data[key] !== undefined) {
        $(this).attr('src', data[key]);
      }
    });

    modal.find('[data-fill-href]').each(function() {
      var key = $(this).data('fill-href');
      if (data[key] !== undefined) {
        $(this).attr('href', data[key]);
      }
    });

    modal.find('[data-fill-html]').each(function() {
      var key = $(this).data('fill-html'); 
      if (data[key] !== undefined) {
        $(this).html(data[key]);
      }
    });

  });
});
</script>
</body>

</html>