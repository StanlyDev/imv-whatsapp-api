// Función para leer el archivo CSV y cargar los datos en la tabla
document.getElementById('file-upload').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    
    reader.onload = function(e) {
        const content = e.target.result;
        processCSV(content);
    };
    
    reader.readAsText(file);
});

// Función para procesar el contenido CSV
function processCSV(content) {
    // Limpiar cualquier dato previo en la tabla
    const tbody = document.querySelector('table tbody');
    tbody.innerHTML = '';
    
    // Separar el contenido por líneas
    const lines = content.split('\n');
    
    // Saltar la primera línea (encabezado) y procesar el resto
    lines.slice(1).forEach((line) => {
        if (line.trim() === '') return; // Ignorar líneas vacías
        
        const data = line.split(';');
        
        // Verificar que la línea tenga 4 columnas
        if (data.length === 4) {
            const row = document.createElement('tr');
            
            // Crear celdas para cada dato
            data.forEach(item => {
                const cell = document.createElement('td');
                cell.textContent = item.trim();
                row.appendChild(cell);
            });
            
            // Insertar la fila en el cuerpo de la tabla
            tbody.appendChild(row);
        }
    });

    // Si no hay datos, mostrar el mensaje de "No hay datos disponibles"
    if (tbody.children.length === 0) {
        const noDataRow = document.createElement('tr');
        const noDataCell = document.createElement('td');
        noDataCell.setAttribute('colspan', '4');
        noDataCell.style.textAlign = 'center';
        noDataCell.textContent = 'No hay datos disponibles';
        noDataRow.appendChild(noDataCell);
        tbody.appendChild(noDataRow);
    }
}

// Función para limpiar la tabla al hacer clic en el botón Eliminar
document.querySelector('.button-delete').addEventListener('click', function() {
    const tbody = document.querySelector('table tbody');
    tbody.innerHTML = ''; // Limpiar todas las filas

    // Mostrar el mensaje de "No hay datos disponibles"
    const noDataRow = document.createElement('tr');
    const noDataCell = document.createElement('td');
    noDataCell.setAttribute('colspan', '4');
    noDataCell.style.textAlign = 'center';
    noDataCell.textContent = 'No hay datos disponibles';
    noDataRow.appendChild(noDataCell);
    tbody.appendChild(noDataRow);

    // Limpiar el archivo cargado
    document.getElementById('file-upload').value = ''; // Limpiar el campo de archivo
});