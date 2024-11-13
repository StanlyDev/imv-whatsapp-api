<?php
$servername = "localhost";
$username = "bventura";  // Cambia a tu usuario
$password = "Stanlyv_00363";      // Cambia a tu contraseña
$dbname = "ClientesDB";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos desde el POST (luego de AJAX)
$nombreBaseDatos = $_POST['nombre_base_datos'];
$campana = $_POST['campana'];
$fechaIngreso = $_POST['fecha_ingreso'];
$clientes = json_decode($_POST['clientes']);  // Lista de clientes desde el formulario

// Insertar la información de la base de datos y campaña
$sql = "INSERT INTO Clientes (nombre_base_datos, campana, fecha_ingreso) VALUES ('$nombreBaseDatos', '$campana', '$fechaIngreso')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;  // Obtener el ID de la última base de datos insertada
    
    // Ahora insertar cada cliente en la tabla Clientes
    foreach ($clientes as $cliente) {
        $nombreCliente = $cliente->nombre_cliente;
        $apellidoCliente = $cliente->apellido_cliente;
        $numeroTelefono = $cliente->numero_telefono;
        $asesorVentas = $cliente->asesor_ventas;

        $sqlCliente = "INSERT INTO Clientes (nombre_cliente, apellido_cliente, numero_telefono, asesor_ventas, nombre_base_datos, campana, fecha_ingreso) 
                       VALUES ('$nombreCliente', '$apellidoCliente', '$numeroTelefono', '$asesorVentas', '$nombreBaseDatos', '$campana', '$fechaIngreso')";
        
        if ($conn->query($sqlCliente) !== TRUE) {
            echo "Error: " . $sqlCliente . "<br>" . $conn->error;
        }
    }
    
    echo "Datos guardados correctamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>