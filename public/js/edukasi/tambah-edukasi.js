
        function previewImage(event) {
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
        }
