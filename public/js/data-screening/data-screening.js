
document.addEventListener("DOMContentLoaded", function () {
    // Menambahkan kelas 'active' pada menu sidebar yang relevan
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    sidebarLinks.forEach(link => {
        if (window.location.href.indexOf(link.href) > -1) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
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
            event.target.closest('form').submit(); // Mengirim form untuk menghapus
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    let tableWrapper = document.querySelector('.table-wrapper');
    tableWrapper.classList.add('visible');
    let rows = document.querySelectorAll('.table tbody tr');
    rows.forEach(function(row, index) {
        setTimeout(function() {
            row.classList.add('visible');
        }, index * 200);
    });
});
