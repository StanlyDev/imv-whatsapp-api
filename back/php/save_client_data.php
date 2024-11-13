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
$nombre_base_datos = $_POST['nombre_base_datos'];  // Nombre de la base de datos
$campana = $_POST['campana'];  // Nombre de la campaña
$fecha_ingreso = $_POST['fecha_ingreso'];  // Fecha de ingreso

// Validar que los datos no estén vacíos
if (empty($nombre_base_datos) || empty($campana) || empty($fecha_ingreso)) {
    die("Error: Los campos obligatorios no pueden estar vacíos.");
}

// Obtener los datos de los clientes (JSON)
$clientes = isset($_POST['clientes']) ? json_decode($_POST['clientes'], true) : [];  // Convertir JSON a array

// Verificar si se recibieron datos de clientes
if (empty($clientes)) {
    die("No hay datos para guardar.");
}

// Preparar la consulta SQL para insertar cada cliente
$stmt = $conn->prepare("INSERT INTO Clientes (nombre_cliente, apellido_cliente, numero_telefono, asesor_ventas, nombre_base_datos, campana, fecha_ingreso) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)");

// Insertar los clientes uno por uno
foreach ($clientes as $cliente) {
    // Validar que los datos del cliente no estén vacíos
    if (empty($cliente['nombre_cliente']) || empty($cliente['apellido_cliente']) || empty($cliente['numero_telefono']) || empty($cliente['asesor_ventas'])) {
        continue;  // Si algún campo importante está vacío, saltamos este cliente
    }

    $nombre_cliente = $cliente['nombre_cliente'];
    $apellido_cliente = $cliente['apellido_cliente'];
    $numero_telefono = $cliente['numero_telefono'];
    $asesor_ventas = $cliente['asesor_ventas'];

    // Vincular parámetros y ejecutar la consulta
    $stmt->bind_param("sssssss", $nombre_cliente, $apellido_cliente, $numero_telefono, $asesor_ventas, $nombre_base_datos, $campana, $fecha_ingreso);

    if (!$stmt->execute()) {
        echo "Error al guardar los datos del cliente: " . $stmt->error;
    }
}

echo "Datos guardados exitosamente.";

// Cerrar la conexión
$stmt->close();
$conn->close();
?>