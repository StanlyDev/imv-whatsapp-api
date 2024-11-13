<?php
// Conexión a la base de datos
$host = 'localhost';
$user = 'bventura';
$password = 'Stanlyv_00363';
$dbname = 'ClientesDB';

// Crear la conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre_base_datos = $_POST['nombre_base_datos'];
$campana = $_POST['campana'];
$fecha_ingreso = $_POST['fecha_ingreso'];

// Validar que los datos no estén vacíos
if (empty($nombre_base_datos) || empty($campana) || empty($fecha_ingreso)) {
    die("Error: Los campos obligatorios no pueden estar vacíos.");
}

// Obtener los datos de los clientes del CSV
$clientes = json_decode($_POST['clientes_data'], true);  // Suponiendo que 'clientes_data' es el JSON con los datos del CSV

// Preparar la consulta SQL
$stmt = $conn->prepare("INSERT INTO Clientes (nombre_cliente, numero_telefono, asesor_ventas, nombre_base_datos, campana, fecha_ingreso) 
                        VALUES (?, ?, ?, ?, ?, ?)");

foreach ($clientes as $cliente) {
    // Enlazar los parámetros de cada cliente
    $stmt->bind_param("ssssss", $cliente['nombre_cliente'], $cliente['numero_telefono'], $cliente['asesor_ventas'], $nombre_base_datos, $campana, $fecha_ingreso);
    
    // Ejecutar la consulta para cada cliente
    if (!$stmt->execute()) {
        echo "Error al guardar los datos: " . $stmt->error;
        exit;
    }
}

echo "Datos guardados exitosamente.";

// Cerrar la conexión
$stmt->close();
$conn->close();
?>