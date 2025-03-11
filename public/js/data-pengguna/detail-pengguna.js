
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
    
