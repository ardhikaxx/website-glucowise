
    document.addEventListener("DOMContentLoaded", function() {
        let card = document.querySelector('.card');
        card.classList.add('visible');

        let rows = document.querySelectorAll('.table-row');
        rows.forEach(function(row, index) {
            setTimeout(function() {
                row.classList.add('visible');
            }, index * 200);
        });

        let button = document.querySelector('.btn-animated');
        setTimeout(function() {
            button.classList.add('visible');
        }, 1000);
    });
