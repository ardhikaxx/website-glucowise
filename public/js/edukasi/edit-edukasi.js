
        document.getElementById('gambar').addEventListener('change', function(event) {
            const preview = document.getElementById('preview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block'; // Menampilkan preview gambar
            }

            if (file) {
                reader.readAsDataURL(file);
            }
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
        