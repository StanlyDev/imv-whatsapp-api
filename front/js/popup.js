document.addEventListener('DOMContentLoaded', () => {
    // Solo asociar evento a botones con clase específica 'view-button'
    document.querySelectorAll('.view-button').forEach(button => {
        button.addEventListener('click', function () {
            const tableName = this.closest('tr').querySelector('td').innerText;

            // Mostrar el popup solo si hay una tabla seleccionada
            if (tableName) {
                document.getElementById('popup').style.visibility = 'visible'; // Cambiar a visible
                loadTableData(tableName, 1);
            }
        });
    });

    // Evento para cerrar el popup
    document.getElementById('closePopup').addEventListener('click', () => {
        document.getElementById('popup').style.visibility = 'hidden'; // Cambiar a oculto
    });
});

function loadTableData(tableName, page) {
    fetch(`/back/php/getTableData.php?table=${tableName}&page=${page}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('popupContent').innerHTML = data;
        })
        .catch(error => console.error('Error al cargar los datos:', error));
}