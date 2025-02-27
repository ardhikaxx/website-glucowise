document.addEventListener("DOMContentLoaded", function() {
    // Menambahkan class 'loaded' untuk memulai animasi halaman
    document.querySelector('.page-wrapper').classList.add('loaded');

    // Menambahkan class 'visible' untuk tabel secara keseluruhan
    let tableWrapper = document.querySelector('.table-wrapper');
    tableWrapper.classList.add('visible');

    // Menambahkan class 'visible' pada setiap baris tabel secara dinamis
    let rows = document.querySelectorAll('.table tbody tr');
    rows.forEach(function(row, index) {
        setTimeout(function() {
            row.classList.add('visible');
        }, index * 200); // Delay untuk setiap baris tabel muncul, misalnya 200ms
    });

    // Menampilkan tombol dengan efek animasi
    let buttons = document.querySelectorAll('.btn-warning, .btn-info');
    buttons.forEach(function(button) {
        button.classList.add('visible');
    });

    // Menampilkan kartu (jika ada) dengan animasi
    let cards = document.querySelectorAll('.card');
    cards.forEach(function(card) {
        card.classList.add('visible');
    });
});
