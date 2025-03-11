
      document.getElementById('add-jawaban').addEventListener('click', function() {
    var jawabanContainer = document.getElementById('jawaban-container');
    var newJawabanItem = document.createElement('div');
    newJawabanItem.classList.add('jawaban-item');
    newJawabanItem.innerHTML = `
        <select name="jawaban[]" class="form-select mb-2" required>
            <option value="Tidak Pernah">Tidak Pernah</option>
            <option value="Jarang">Jarang</option>
            <option value="Sering">Sering</option>
            <option value="Selalu">Selalu</option>
        </select>
        <input type="number" name="skoring[]" class="form-control mb-2" placeholder="Skoring" required>
        <button type="button" class="btn btn-danger btn-sm remove-jawaban">-</button>
    `;
    jawabanContainer.appendChild(newJawabanItem);

    // Menampilkan tombol minus jika lebih dari satu jawaban
    var jawabanItems = document.querySelectorAll('.jawaban-item');
    jawabanItems.forEach(function(item, index) {
        if (jawabanItems.length > 1) {
            item.querySelector('.remove-jawaban').style.display = 'inline-block';
        }
    });
});

// Menghapus jawaban saat tombol minus diklik
document.getElementById('jawaban-container').addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('remove-jawaban')) {
        e.target.closest('.jawaban-item').remove();

        // Menyembunyikan tombol minus jika hanya ada satu jawaban
        var jawabanItems = document.querySelectorAll('.jawaban-item');
        jawabanItems.forEach(function(item, index) {
            if (jawabanItems.length <= 1) {
                item.querySelector('.remove-jawaban').style.display = 'none';
            }
        });
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
