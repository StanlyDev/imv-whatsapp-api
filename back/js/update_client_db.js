document.querySelector(".button-save").addEventListener("click", function() {
    // Obtener los datos del formulario
    const nombreBaseDatos = document.getElementById("dbName").value;
    const campana = document.getElementById("campaign").value;
    const fechaIngreso = document.getElementById("date").value;

    // Verificar si los campos del formulario están completos
    if (!nombreBaseDatos || !campana || !fechaIngreso) {
        alert("Por favor, complete todos los campos del formulario.");
        return;
    }

    // Obtener los datos de los clientes en la tabla
    let clientes = [];
    const rows = document.querySelectorAll("table tbody tr");

    console.log("Filas de la tabla:", rows);  // Depuración: Verificar las filas de la tabla

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");

        // Verificar si la fila tiene al menos 4 celdas
        if (cells.length >= 4) {
            const nombre_cliente = cells[0] ? cells[0].textContent.trim() : '';
            const apellido_cliente = cells[1] ? cells[1].textContent.trim() : '';
            const numero_telefono = cells[2] ? cells[2].textContent.trim() : '';
            const asesor_ventas = cells[3] ? cells[3].textContent.trim() : '';

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

    console.log("Clientes extraídos:", clientes);  // Depuración: Verificar los datos extraídos

    // Verificar si se han capturado clientes
    if (clientes.length === 0) {
        alert("No se han encontrado datos válidos en la tabla.");
        return;
    }

    // Preparar los datos para enviar
    // Crear un objeto con los datos
    const formData = {
        nombre_base_datos: nombreBaseDatos,
        campana: campana,
        fecha_ingreso: fechaIngreso,
        clientes: JSON.stringify(clientes)
    };

    // Enviar los datos como JSON
    fetch("/back/php/save_client_data.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"  // Aseguramos que el contenido es JSON
        },
        body: JSON.stringify(formData)  // Convertimos los datos en JSON
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