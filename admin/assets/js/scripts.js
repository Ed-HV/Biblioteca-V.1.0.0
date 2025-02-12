// assets/js/scripts.js

document.addEventListener('DOMContentLoaded', function () {
    // 1. Alternar el menú lateral
    const menuToggle = document.getElementById('menu-toggle');
    const wrapper = document.getElementById('wrapper');

    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            wrapper.classList.toggle('toggled');
        });
    }

    // 2. Confirmación antes de eliminar libros
    const deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            const confirmDelete = confirm("¿Estás seguro de que deseas eliminar este libro? Esta acción no se puede deshacer.");
            if (!confirmDelete) {
                event.preventDefault();
            }
        });
    });

    // 3. Alerta de éxito después de acciones (agregar, editar, eliminar)
    const alertSuccess = document.querySelector('.alert-success');
    if (alertSuccess) {
        setTimeout(() => {
            alertSuccess.style.display = 'none';
        }, 3000); // Ocultar la alerta después de 3 segundos
    }

    // 4. Validación de formularios antes de enviar
    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // 5. Filtrado en la tabla de reportes (búsqueda en tiempo real)
    const searchInput = document.getElementById('search-reports');
    const reportRows = document.querySelectorAll('.report-row');

    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const filter = searchInput.value.toLowerCase();

            reportRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                if (rowText.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
