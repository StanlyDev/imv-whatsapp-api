    // Función para filtrar las filas de la tabla en tiempo real
    document.getElementById('searchInput').addEventListener('input', function() {
        var filter = this.value.toLowerCase();
        var rows = document.querySelectorAll('#tableBody .table-row');
  
        rows.forEach(function(row) {
          var columns = row.querySelectorAll('td');
          var match = false;
  
          // Revisamos si alguna de las columnas contiene el texto de búsqueda
          columns.forEach(function(column) {
            if (column.textContent.toLowerCase().includes(filter)) {
              match = true;
            }
          });
  
          // Mostrar u ocultar la fila dependiendo si coincide con la búsqueda
          if (match) {
            row.style.display = '';
          } else {
            row.style.display = 'none';
          }
        });
      });