// Agrega un evento para capturar la entrada del usuario en el campo de búsqueda
document.getElementById('searchInput').addEventListener('input', function() {
    var filter = this.value.toLowerCase();  // Obtén el valor del input
    var rows = document.querySelectorAll('#tableBody .table-row');  // Selecciona todas las filas de la tabla
  
    rows.forEach(function(row) {
      var columns = row.querySelectorAll('td');  // Obtiene las columnas de la fila
      var match = false;
  
      // Recorre cada columna y verifica si contiene el texto de búsqueda
      columns.forEach(function(column) {
        if (column.textContent.toLowerCase().includes(filter)) {
          match = true;
        }
      });
  
      // Si hay una coincidencia, muestra la fila, si no la oculta
      if (match) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });