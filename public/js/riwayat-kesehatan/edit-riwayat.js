document.getElementById('submitBtn').addEventListener('click', function () {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang telah diedit akan disimpan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#34B3A0',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, simpan!',
        cancelButtonText: 'Batal',
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('editForm').submit(); // Submit the form if confirmed
        }
    });
});
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

