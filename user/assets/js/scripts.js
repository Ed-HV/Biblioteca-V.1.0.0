// assets/js/scripts.js

document.addEventListener('DOMContentLoaded', function () {
    window.loadPage = function (page) {
        const contentArea = document.getElementById('content-area');
        contentArea.innerHTML = '<p class="text-center">Cargando...</p>';

        fetch(page)
            .then(response => {
                if (!response.ok) throw new Error('No se pudo cargar el contenido.');
                return response.text();
            })
            .then(data => contentArea.innerHTML = data)
            .catch(error => contentArea.innerHTML = `<p class="text-danger text-center">${error.message}</p>`);
    };
});
