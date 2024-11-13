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
        if (cells.length > 0) {  // Ignorar filas vacías
            const cliente = {
                nombre_cliente: cells[1].textContent.trim(),
                apellido_cliente: cells[2].textContent.trim(),
                numero_telefono: cells[3].textContent.trim(),
                asesor_ventas: cells[4].textContent.trim()
            };
            clientes.push(cliente);
        }
    });

    // Verificar si los campos son válidos
    if (!nombreBaseDatos || !campana || !fechaIngreso || clientes.length === 0) {
        alert("Por favor, complete todos los campos y asegúrese de que haya datos en la tabla.");
        return;
    }

    // Preparar los datos para enviar
    const formData = new FormData();
    formData.append("nombre_base_datos", nombreBaseDatos);
    formData.append("campana", campana);
    formData.append("fecha_ingreso", fechaIngreso);
    formData.append("clientes", JSON.stringify(clientes));

    // Enviar los datos al servidor con AJAX
    fetch("/back/php/save_client_data.php", {
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