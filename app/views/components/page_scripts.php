<?php
// Toast
$toast_message = '';
$toast_type = '';

if (!empty($_SESSION['success_message'])) {
  $toast_message = htmlspecialchars($_SESSION['success_message']);
  $toast_type = 'success';
  unset($_SESSION['success_message']);
} elseif (!empty($_SESSION['error_message'])) {
  $toast_message = htmlspecialchars($_SESSION['error_message']);
  $toast_type = 'danger';
  unset($_SESSION['error_message']);
}

$table_name = $table_name ?? 'default';
$table_id = 'table-' . $table_name;
$entity_name = $table_name;
?>
<script>
$(document).ready(function () {

  var tableSelector = "#<?= $table_id ?>";

  // Hitung jumlah baris data asli (bukan empty row)
  var hasData = $(tableSelector + " tbody tr:not(.dt-empty-row)").length > 0;

  // DataTables hanya aktif jika ada data
  if (hasData) {

    $(tableSelector).DataTable({
      pagingType: "simple_numbers",
      language: {
        lengthMenu: "Tampilkan _MENU_ entri",
        info: "Halaman _PAGE_ dari _PAGES_",
        infoFiltered: "(difilter dari _MAX_ total entri)",
        search: "Cari:",
        paginate: {
          next: "<i class='bx bx-chevron-right'></i>",
          previous: "<i class='bx bx-chevron-left'></i>"
        }
      },
      columnDefs: [
        { targets: "_all", defaultContent: "" }  // ← FIX ERROR UNKNOWN PARAMETER
      ]
    });

  }

});
</script>

<script>
// Toast handler
document.addEventListener("DOMContentLoaded", function () {
  const msg = "<?= $toast_message ?>";
  const type = "<?= $toast_type ?>";

  if (!msg) return;

  const toastBox = document.getElementById('liveToast');
  const toastBody = document.getElementById('toastBody');
  const toastHeader = toastBox.querySelector('.toast-header');

  toastBody.innerHTML = msg;

  toastBox.classList.remove('bg-success', 'bg-danger');
  toastHeader.classList.remove('bg-success', 'bg-danger');

  if (type === 'success') {
    toastBox.classList.add('bg-success', 'text-white');
    toastHeader.classList.add('bg-success', 'text-white');
  } else {
    toastBox.classList.add('bg-danger', 'text-white');
    toastHeader.classList.add('bg-danger', 'text-white');
  }

  new bootstrap.Toast(toastBox).show();
});
</script>

<script>
// Delete confirm
$(document).on("click", ".btn-delete", function (e) {
  e.preventDefault();
  let url = $(this).attr("href");

  Swal.fire({
    title: 'Hapus data ini?',
    text: "Data yang dihapus tidak dapat dikembalikan.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Hapus',
    cancelButtonText: 'Batal',
    customClass: {
      confirmButton: 'btn btn-danger',
      cancelButton: 'btn btn-outline-secondary ms-2'
    },
    buttonsStyling: false
  }).then((x) => {
    if (x.isConfirmed) {
      window.location.href = url;
    }
  });
});
</script>
