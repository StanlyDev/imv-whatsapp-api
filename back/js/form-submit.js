document.addEventListener("DOMContentLoaded", function() {
    const fileUpload = document.getElementById('file-upload');
    
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

                // Procesamos los datos para que se vea bien
                let clientes = jsonData.slice(1).map(row => {
                    return {
                        nombre_cliente: row[0],
                        numero_telefono: row[1],
                        asesor_ventas: row[2]
                    };
                });

                console.log(clientes);  // Muestra los datos de los clientes

                // Guardar los datos del formulario y CSV
                let formData = new FormData();
                formData.append('nombre_base_datos', document.getElementById('dbName').value);
                formData.append('campana', document.getElementById('campaign').value);
                formData.append('fecha_ingreso', document.getElementById('date').value);
                formData.append('file-upload', file);

                // Enviar los datos al backend
                fetch('/back/php/save_client_data.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.text())
                  .then(response => console.log(response))
                  .catch(error => console.error('Error:', error));
            };

            reader.readAsArrayBuffer(file);
        });
    } else {
        console.error('El elemento de carga de archivo no existe.');
    }
});