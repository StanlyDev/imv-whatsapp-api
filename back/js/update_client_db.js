document.querySelector(".button-save").addEventListener("click", function() {
    // Obtener los datos del formulario
    const nombreBaseDatos = document.getElementById("dbName").value;
    const campana = document.getElementById("campaign").value;
    const fechaIngreso = document.getElementById("date").value;

    // Obtener los datos de los clientes en la tabla
    let clientes = [];
    const rows = document.querySelectorAll("table tbody tr");

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        
        // Verificar que la fila tenga al menos 4 celdas
        if (cells.length >= 4) {  
            // Obtener los valores de las celdas
            const nombre_cliente = cells[1] ? cells[1].textContent.trim() : '';
            const apellido_cliente = cells[2] ? cells[2].textContent.trim() : '';
            const numero_telefono = cells[3] ? cells[3].textContent.trim() : '';
            const asesor_ventas = cells[4] ? cells[4].textContent.trim() : '';

            // Asegurarse de que no haya valores vacíos antes de agregar al array
            if (nombre_cliente && apellido_cliente && numero_telefono && asesor_ventas) {
                clientes.push({
                    nombre_cliente,
                    apellido_cliente,
                    numero_telefono,
                    asesor_ventas
                });
            }
        }
    });

    // Verificar si los campos son válidos
    if (!nombreBaseDatos || !campana || !fechaIngreso || clientes.length === 0) {
        alert("Por favor, complete todos los campos y asegúrese de que haya datos válidos en la tabla.");
        return;
    }

    // Preparar los datos para enviar
    const formData = new FormData();
    formData.append("nombre_base_datos", nombreBaseDatos);
    formData.append("campana", campana);
    formData.append("fecha_ingreso", fechaIngreso);
    formData.append("clientes", JSON.stringify(clientes));

    // Enviar los datos al servidor con AJAX
    fetch("save_client_data.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);  // Mostrar mensaje de éxito o error
        if (data.includes("correctamente")) {
            // Limpiar la tabla después de guardar
            document.querySelector("table tbody").innerHTML = '<tr><td colspan="4" style="text-align: center;">No hay datos disponibles</td></tr>';
        }
    })
    .catch(error => {
        console.error("Error al guardar los datos:", error);
    });
});