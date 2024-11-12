  document.getElementById('file-upload').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();

      reader.onload = function(e) {
        const csvData = e.target.result;
        
        // Convertimos el CSV a filas usando ';' como delimitador
        const rows = csvData.split('\n').map(row => row.split(';'));
        
        // Extraemos las columnas (sin encabezados) y generamos los datos
        const jsonData = rows.slice(1).map((row, index) => ({
          id: index + 1,
          fullName: `${row[0]} ${row[1]}`.trim(),
          phone: row[2].trim(),
          advisor: row[3].trim()
        }));

        // Insertamos los datos en la tabla
        const tbody = document.querySelector('table tbody');
        tbody.innerHTML = ''; // Limpiamos las filas previas

        jsonData.forEach(row => {
          const tr = document.createElement('tr');

          // ID
          const tdID = document.createElement('td');
          tdID.textContent = row.id;
          tr.appendChild(tdID);

          // Nombre completo
          const tdFullName = document.createElement('td');
          tdFullName.textContent = row.fullName;
          tr.appendChild(tdFullName);

          // Número de teléfono
          const tdPhone = document.createElement('td');
          tdPhone.textContent = row.phone;
          tr.appendChild(tdPhone);

          // Asesor de ventas
          const tdAdvisor = document.createElement('td');
          tdAdvisor.textContent = row.advisor;
          tr.appendChild(tdAdvisor);

          tbody.appendChild(tr);
        });
      };

      reader.readAsText(file);
    }
  });

  // Evento para limpiar la tabla y resetear el input
  document.querySelector('.button-delete').addEventListener('click', function() {
    // Limpiar la tabla
    const tbody = document.querySelector('table tbody');
    tbody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No hay datos disponibles</td></tr>';

    // Resetear el input de archivo
    const fileInput = document.getElementById('file-upload');
    fileInput.value = ''; // Reseteamos el input
  });