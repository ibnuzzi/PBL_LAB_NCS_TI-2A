<?php
// Logika PHP untuk data Toast
$toast_message = '';
$toast_type = ''; // 'success' or 'danger'

if (!empty($_SESSION['success_message'])) {
  $toast_message = htmlspecialchars($_SESSION['success_message']);
  $toast_type = 'success';
  unset($_SESSION['success_message']);
} elseif (!empty($_SESSION['error_message'])) {
  $toast_message = htmlspecialchars($_SESSION['error_message']);
  $toast_type = 'danger';
  unset($_SESSION['error_message']);
}

// Variabel dinamis untuk nama tabel dan entitas
$table_name = 'berita'; // Ganti nilai ini sesuai nama tabel yang digunakan
$table_id = 'table-' . $table_name;
$entity_name = $table_name;
?>

<script>
  $(document).ready(function() {

    var imgPath = "<?php echo BASE_URL; ?>/public/assets/images/empty/empty_data.png";

    var noDataHtml = '<div class="text-center p-4">' +
      '  <img src="' + imgPath + '" alt="Data Kosong" style="width: 130px; margin-bottom: 1rem;">' +
      '  <h5 class="mb-0">Belum Ada Data</h5>' +
      '  <p class="text-muted small">Data <?php echo $entity_name; ?> akan muncul di sini setelah Anda menambahkannya.</p>' +
      '</div>';

    $('#<?php echo $table_id; ?>').DataTable({
      "pagingType": "simple_numbers",
      "language": {
        "lengthMenu": "Tampilkan _MENU_ entri per halaman",
        "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
        "infoFiltered": "(difilter dari _MAX_ total entri)",
        "search": "Cari:",
        "infoEmpty": "",
        "emptyTable": noDataHtml,
        "zeroRecords": noDataHtml,
        "paginate": {
          "next": "<i class='bx bx-chevron-right'></i>",
          "previous": "<i class='bx bx-chevron-left'></i>"
        }
      },
      "columnDefs": [{
        "orderable": false,
        "targets": [2, 4]
      }]
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const toastMessage = "<?php echo $toast_message; ?>";
    const toastType = "<?php echo $toast_type; ?>";

    if (toastMessage) {
      const toastLiveExample = document.getElementById('liveToast');
      const toastBody = document.getElementById('toastBody');
      const toastHeader = toastLiveExample.querySelector('.toast-header');

      toastBody.innerHTML = toastMessage;

      toastLiveExample.classList.remove('bg-success', 'bg-danger');
      toastHeader.classList.remove('bg-success', 'bg-danger');

      if (toastType === 'success') {
        toastLiveExample.classList.add('bg-success', 'text-white');
        toastHeader.classList.add('bg-success', 'text-white');
      } else if (toastType === 'danger') {
        toastLiveExample.classList.add('bg-danger', 'text-white');
        toastHeader.classList.add('bg-danger', 'text-white');
      }

      const toast = new bootstrap.Toast(toastLiveExample);
      toast.show();
    }
  });
</script>

<script>
  $(document).ready(function() {
    // Gunakan event delegation untuk tombol .btn-delete di dalam DataTables
    $('#<?php echo $table_id; ?>').on('click', '.btn-delete', function(e) {
      e.preventDefault();
      var deleteUrl = $(this).attr('href');

      Swal.fire({
        // ... (Logika lengkap untuk SweetAlert) ...
        title: 'Yakin ingin menghapus <?php echo $entity_name; ?> ini?',
        text: "Data yang sudah dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        customClass: {
          confirmButton: 'btn btn-danger',
          cancelButton: 'btn btn-outline-secondary ms-2'
        },
        buttonsStyling: false
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = deleteUrl;
        }
      });
    });
  });
</script>