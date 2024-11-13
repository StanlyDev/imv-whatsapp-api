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
            let clientes = jsonData.slice(1).map(row => {
                return {
                    nombre_cliente: row[0],
                    apellido_cliente: row[1],  // Ahora se incluye el apellido
                    numero_telefono: row[2],
                    asesor_ventas: row[3]
                };
            });

            console.log(clientes);  // Muestra los datos de los clientes

            // Cargar los datos en la tabla HTML
            let tbody = document.querySelector('table tbody');
            tbody.innerHTML = '';  // Limpiar la tabla antes de agregar nuevas filas
            clientes.forEach(cliente => {
                let row = `<tr>
                            <td>${cliente.nombre_cliente}</td>
                            <td>${cliente.apellido_cliente}</td>
                            <td>${cliente.numero_telefono}</td>
                            <td>${cliente.asesor_ventas}</td>
                        </tr>`;
                tbody.innerHTML += row;  // Agregar una fila por cliente
            });

            // Enviar los datos al backend
            let formData = new FormData();
            formData.append('nombre_base_datos', document.getElementById('dbName').value);
            formData.append('campana', document.getElementById('campaign').value);
            formData.append('fecha_ingreso', document.getElementById('date').value);
            formData.append('clientes', JSON.stringify(clientes)); // Convertir el array de clientes a un JSON string

            // Manejar el envío del formulario
            document.getElementById('client-form').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevenir que el formulario se envíe por defecto

                // Enviar el FormData al servidor
                fetch('/back/php/save_client_data.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.text())
                  .then(response => {
                      console.log(response);  // Mostrar respuesta del servidor
                      
                      // Limpiar el formulario después de guardar
                      document.getElementById('client-form').reset();

                      // Limpiar la tabla de clientes después de guardar
                      tbody.innerHTML = `<tr><td colspan="4" class="border px-4 py-2 text-center">No hay datos disponibles</td></tr>`;
                  })
                  .catch(error => console.error('Error:', error));
            });
        };

        reader.readAsArrayBuffer(file);
    });
});