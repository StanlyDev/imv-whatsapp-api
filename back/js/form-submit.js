document.addEventListener('DOMContentLoaded', function() {
    // Evento para manejar la carga del archivo
    document.getElementById('file-upload').addEventListener('change', function(e) {
        let file = e.target.files[0];
        let reader = new FileReader();

        reader.onload = function(event) {
            let data = new Uint8Array(event.target.result);
            let workbook = XLSX.read(data, { type: 'array' });

            // Supón que la hoja que contiene los datos es la primera
            let sheet = workbook.Sheets[workbook.SheetNames[0]];
            let jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

            // Procesamos los datos para que se vea bien
            let clientes = jsonData.slice(1).map((row, index) => {
                return {
                    id: index + 1,  // Asignamos un ID para la visualización
                    nombre_cliente: row[0] || '',  // Si el nombre está vacío, asignamos una cadena vacía
                    apellido_cliente: row[1] || '',  // Lo mismo para el apellido
                    numero_telefono: row[2] || '',  // Lo mismo para el teléfono
                    asesor_ventas: row[3] || ''  // Lo mismo para el asesor
                };
            });

            console.log(clientes);  // Muestra los datos de los clientes

            // Cargar los datos en la tabla HTML
            let tbody = document.querySelector('#clientes-table tbody');
            tbody.innerHTML = '';  // Limpiar la tabla antes de agregar nuevas filas
            clientes.forEach(cliente => {
                let row = `<tr>
                            <td>${cliente.id}</td> <!-- Mostrar ID en la tabla -->
                            <td>${cliente.nombre_cliente}</td>
                            <td>${cliente.apellido_cliente}</td>
                            <td>${cliente.numero_telefono}</td>
                            <td>${cliente.asesor_ventas}</td>
                        </tr>`;
                tbody.innerHTML += row;  // Agregar una fila por cliente
            });

            // Manejar el envío del formulario
            document.getElementById('client-form').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevenir que el formulario se envíe por defecto

                // Crear el objeto FormData con los datos del formulario
                let formData = new FormData();
                formData.append('nombre_base_datos', document.getElementById('dbName').value);
                formData.append('campana', document.getElementById('campaign').value);
                formData.append('fecha_ingreso', document.getElementById('date').value);
                formData.append('clientes', JSON.stringify(clientes.map(cliente => {
                    // Excluir el ID antes de enviarlo al servidor
                    return {
                        nombre_cliente: cliente.nombre_cliente,
                        apellido_cliente: cliente.apellido_cliente,
                        numero_telefono: cliente.numero_telefono,
                        asesor_ventas: cliente.asesor_ventas
                    };
                }))); // Convertir el array de clientes a un JSON string, sin el ID

                // Enviar el FormData al servidor
                fetch('/back/php/save_client_data.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json()) // Convertir respuesta a JSON
                .then(data => {
                    if (data.success) {
                        alert(data.success); // Mostrar mensaje de éxito
                        document.getElementById('client-form').reset(); // Limpiar formulario
                        tbody.innerHTML = `<tr><td colspan="5" class="border px-4 py-2 text-center">No hay datos disponibles</td></tr>`; // Limpiar la tabla
                    } else {
                        alert(`Error: ${data.error}`); // Mostrar mensaje de error si ocurre
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al guardar los datos.');
                });
            });
        };

        reader.readAsArrayBuffer(file);
    });
});