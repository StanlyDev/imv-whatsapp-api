<?php
// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configurar la respuesta como JSON
header('Content-Type: application/json');

// Configuración de la base de datos
$servername = "localhost";
$username = "bventura";
$password = "Stanlyv_00363";
$dbname = "ClientesDB";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conn->connect_error]);
    exit;
}

// Obtener los datos del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Validar datos
if (empty($data['dbName']) || empty($data['campaign']) || empty($data['date']) || empty($data['clientes'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

// Variables adicionales
$dbName = $data['dbName'];
$campaign = $data['campaign'];
$date = $data['date'];

// Preparar la consulta de inserción
$stmt = $conn->prepare("INSERT INTO Clientes (nombre_cliente, apellido_cliente, numero_telefono, asesor_ventas, db_name, campaign, fecha_ingreso) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $nombre_cliente, $apellido_cliente, $numero_telefono, $asesor_ventas, $dbName, $campaign, $date);

// Iterar sobre los clientes e insertar
foreach ($data['clientes'] as $cliente) {
    $names = explode(' ', $cliente['fullName']);
    $nombre_cliente = $names[0];
    $apellido_cliente = isset($names[1]) ? $names[1] : '';
    $numero_telefono = $cliente['phone'];
    $asesor_ventas = $cliente['advisor'];

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Error al insertar cliente: ' . $stmt->error]);
        exit;
    }
}

// Cerrar conexión
$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'message' => 'Datos guardados correctamente']);
?>