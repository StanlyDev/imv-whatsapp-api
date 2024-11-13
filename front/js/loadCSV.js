document.addEventListener("DOMContentLoaded", function() {
    const fileUpload = document.getElementById('file-upload');
    const tableBody = document.getElementById('clientes-table').getElementsByTagName('tbody')[0];
    let clientesData = []; // Variable para almacenar los datos del CSV

    // Verifica si el elemento existe antes de agregar el event listener
    if (fileUpload) {
        fileUpload.addEventListener('change', function(e) {
            let file = e.target.files[0];
            let reader = new FileReader();

            reader.onload = function(event) {
                let data = new Uint8Array(event.target.result);
                let workbook = XLSX.read(data, { type: 'array' });

                // Supón que la hoja que contiene los datos es la primera
                let sheet = workbook.Sheets[workbook.SheetNames[0]];
                let jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

                // Limpiar la tabla antes de agregar los nuevos datos
                tableBody.innerHTML = '';

                // Procesamos los datos para que se vea bien
                clientesData = jsonData.slice(1).map((row, index) => {
                    return {
                        id: index + 1,  // Asigna un ID automático
                        nombre_cliente: row[0],
                        numero_telefono: row[1],
                        asesor_ventas: row[2]
                    };
                });

                // Mostrar los datos en la tabla
                clientesData.forEach(cliente => {
                    let row = tableBody.insertRow();
                    row.insertCell(0).textContent = cliente.id;
                    row.insertCell(1).textContent = cliente.nombre_cliente;
                    row.insertCell(2).textContent = cliente.numero_telefono;
                    row.insertCell(3).textContent = cliente.asesor_ventas;
                });
            };

            reader.readAsArrayBuffer(file);
        });
    } else {
        console.error('El elemento de carga de archivo no existe.');
    }
});