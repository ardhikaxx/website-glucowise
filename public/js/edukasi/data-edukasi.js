
document.addEventListener("DOMContentLoaded", function() {
let buttons = document.querySelectorAll('.btn-rounded');
buttons.forEach(function(button) {
setTimeout(function() {
    button.classList.add('visible');
}, 200); // Memberikan delay untuk animasi muncul, misalnya 200ms
});
});

document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('.page-wrapper').classList.add('loaded');
    let tableWrapper = document.querySelector('.table-wrapper');
    tableWrapper.classList.add('visible');
    let rows = document.querySelectorAll('.table tbody tr');
    rows.forEach(function(row, index) {
        setTimeout(function() {
            row.classList.add('visible');
        }, index * 200);
    });
});
function confirmDelete(event) {
event.preventDefault();  // Mencegah form dikirim langsung

Swal.fire({
title: 'Apakah Anda yakin?',
text: "Data ini akan dihapus secara permanen!",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Ya, Hapus!',
cancelButtonText: 'Batal'
}).then((result) => {
if (result.isConfirmed) {
    // Jika dikonfirmasi, kirimkan form untuk menghapus
    event.target.closest('form').submit(); // Mengirim form untuk melakukan penghapusan
}
});
}