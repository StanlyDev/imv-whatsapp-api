document.addEventListener('DOMContentLoaded', function() {
    // Cargar archivo Excel y mostrar los datos en la tabla
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
                    nombre_cliente: row[0],        // Nombre del Cliente
                    apellido_cliente: row[1],      // Apellido del Cliente
                    numero_telefono: row[2],      // Número de Teléfono
                    asesor_ventas: row[3]         // Asesor de Ventas
                };
            });

            console.log(clientes);  // Muestra los datos de los clientes

            // Cargar los datos en la tabla HTML
            let tbody = document.querySelector('#clientes-table tbody');
            tbody.innerHTML = '';  // Limpiar la tabla antes de agregar nuevas filas
            clientes.forEach((cliente, index) => {
                let row = `<tr>
                            <td>${index + 1}</td>
                            <td>${cliente.nombre_cliente}</td>
                            <td>${cliente.apellido_cliente}</td>
                            <td>${cliente.numero_telefono}</td>
                            <td>${cliente.asesor_ventas}</td>
                        </tr>`;
                tbody.innerHTML += row;  // Agregar una fila por cliente
            });

            // Guardar los datos del formulario y los clientes
            document.getElementById('client-form').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevenir que el formulario se envíe por defecto

                let formData = new FormData();
                formData.append('nombre_base_datos', document.getElementById('dbName').value);
                formData.append('campana', document.getElementById('campaign').value);
                formData.append('fecha_ingreso', document.getElementById('date').value);
                formData.append('clientes', JSON.stringify(clientes)); // Convertir los clientes a JSON

                // Enviar los datos al backend
                fetch('/back/php/save_client_data.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.text())
                  .then(response => console.log(response))
                  .catch(error => console.error('Error:', error));
            });
        };

        reader.readAsArrayBuffer(file);
    });
});