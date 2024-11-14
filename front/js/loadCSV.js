document.addEventListener("DOMContentLoaded", function() {
    const fileUpload = document.getElementById('file-upload');
    const tableBody = document.getElementById('clientes-table').getElementsByTagName('tbody')[0];
    let clientesData = [];

    if (fileUpload) {
        fileUpload.addEventListener('change', function(e) {
            let file = e.target.files[0];
            if (!file) {
                alert("Por favor, seleccione un archivo.");
                return;
            }

            let reader = new FileReader();
            reader.onload = function(event) {
                try {
                    let data = new Uint8Array(event.target.result);
                    let workbook = XLSX.read(data, { type: 'array' });

                    let sheetName = workbook.SheetNames[0];
                    let sheet = workbook.Sheets[sheetName];
                    let jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

                    if (jsonData.length <= 1) {
                        alert("El archivo está vacío o no tiene datos válidos.");
                        return;
                    }

                    tableBody.innerHTML = ''; // Limpiar la tabla
                    clientesData = [];

                    jsonData.slice(1).forEach((row, index) => {
                        // Omitir la primera columna (ID) y asignar valores correctamente
                        const nombre_cliente = row[0] || ''; // columna 0 (ahora nombre_cliente)
                        const apellido_cliente = row[1] || ''; // columna 1 (apellido_cliente)
                        const numero_telefono = row[2] || ''; // columna 2 (numero_telefono)
                        const asesor_ventas = row[3] || ''; // columna 3 (asesor_ventas)

                        // Asegurarse de que los datos estén completos
                        if (!nombre_cliente || !numero_telefono || !asesor_ventas) {
                            console.warn(`Faltan datos en la fila ${index + 1}, saltando la fila.`);
                            return; // No insertamos esta fila si faltan datos críticos
                        }

                        // Agregar los datos de cliente a la lista
                        clientesData.push({
                            id: index + 1, // Generar un id secuencial (empieza desde 1)
                            nombre_cliente: nombre_cliente,
                            apellido_cliente: apellido_cliente,
                            numero_telefono: numero_telefono,
                            asesor_ventas: asesor_ventas
                        });
                    });

                    if (clientesData.length === 0) {
                        alert("No se encontraron filas válidas en el archivo.");
                        return;
                    }

                    // Población de la tabla HTML
                    clientesData.forEach(cliente => {
                        let row = tableBody.insertRow();
                        row.insertCell(0).textContent = cliente.id;
                        row.insertCell(1).textContent = cliente.nombre_cliente;
                        row.insertCell(2).textContent = cliente.apellido_cliente;
                        row.insertCell(3).textContent = cliente.numero_telefono;
                        row.insertCell(4).textContent = cliente.asesor_ventas;
                    });

                } catch (error) {
                    console.error("Error al procesar el archivo:", error);
                    alert("Hubo un error al procesar el archivo. Asegúrese de que es un archivo Excel válido.");
                }
            };

            reader.readAsArrayBuffer(file);
        });
    } else {
        console.error('El elemento de carga de archivo no existe.');
    }
});