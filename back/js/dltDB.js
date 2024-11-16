document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            const tabla = this.getAttribute('data-tabla');
            if (confirm(`¿Seguro que deseas eliminar la base de datos "${tabla}"?`)) {
                fetch('/back/php/delete_table.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ tabla })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Tabla eliminada correctamente');
                        location.reload(); // Actualiza la página para reflejar los cambios
                    } else {
                        alert('Error al eliminar la tabla: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al conectar con el servidor.');
                });
            }
        });
    });
});