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
                fullName: `${row[0]} ${row[1]}`.trim(),
                phone: row[2]?.trim() || '', // Validación para prevenir undefined
                advisor: row[3]?.trim() || '' // Validación para prevenir undefined
            }));

            // Insertamos los datos en la tabla
            const tbody = document.querySelector('table tbody');
            tbody.innerHTML = ''; // Limpiamos las filas previas

            jsonData.forEach((row, index) => {
                const tr = document.createElement('tr');

                // ID
                const tdID = document.createElement('td');
                tdID.textContent = index + 1;
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

            // Almacenar los datos para enviarlos al servidor cuando el usuario haga clic en "Guardar"
            window.loadedData = jsonData;
        };

        reader.readAsText(file);
    }
});

// Evento para guardar los datos en la base de datos
document.querySelector('.button-save').addEventListener('click', function() {
    const dbName = document.getElementById('dbName').value.trim();
    const campaign = document.getElementById('campaign').value.trim();
    const date = document.getElementById('date').value.trim();

    if (!dbName || !campaign || !date) {
        alert('Por favor, complete todos los campos antes de guardar.');
        return;
    }

    if (!window.loadedData || window.loadedData.length === 0) {
        alert('No hay datos cargados para guardar.');
        return;
    }

    const payload = {
        nombre_base_datos: dbName,
        campana: campaign,
        date: date,
        clientes: window.loadedData
    };

    fetch('/back/php/save_client.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(payload),
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`Error del servidor: ${text}`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Los datos han sido guardados correctamente en la base de datos');
        } else {
            alert('Hubo un error al guardar los datos: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(`Hubo un error: ${error.message}`);
    });
});

// Evento para limpiar la tabla y resetear el input
document.querySelector('.button-delete').addEventListener('click', function() {
    const tbody = document.querySelector('table tbody');
    tbody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No hay datos disponibles</td></tr>';
    const fileInput = document.getElementById('file-upload');
    fileInput.value = ''; // Reseteamos el input
    window.loadedData = [];
});