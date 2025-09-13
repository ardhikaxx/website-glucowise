
document.addEventListener("DOMContentLoaded", function () {
    let buttons = document.querySelectorAll('.btn-rounded');
    buttons.forEach(function (button) {
        setTimeout(function () {
            button.classList.add('visible');
        }, 200); // Memberikan delay untuk animasi muncul, misalnya 200ms
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelector('.page-wrapper').classList.add('loaded');
    let tableWrapper = document.querySelector('.table-wrapper');
    tableWrapper.classList.add('visible');
    let rows = document.querySelectorAll('.table tbody tr');
    rows.forEach(function (row, index) {
        setTimeout(function () {
            row.classList.add('visible');
        }, index * 200);
    });
});

function confirmDelete(event) {
    event.preventDefault(); // Mencegah form dikirim langsung

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data ini akan dihapus secara permanen!",
        icon: 'warning',
        iconColor: '#ffc107',
        showCancelButton: true,
        confirmButtonColor: '#34B3A0',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash me-2"></i> Ya, Hapus!',
        cancelButtonText: '<i class="fas fa-times me-2"></i> Batal',
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.closest('form').submit(); // Mengirim form untuk menghapus
        }
    });
}

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
