document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.icon').forEach(button => {
      button.addEventListener('click', function () {
        const tableName = this.closest('tr').querySelector('td').innerText;
  
        // Mostrar el popup
        document.getElementById('popup').classList.remove('hidden');
  
        // Inicializar paginación
        loadTableData(tableName, 1);
      });
    });
  
    document.getElementById('closePopup').addEventListener('click', () => {
      document.getElementById('popup').classList.add('hidden');
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