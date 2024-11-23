<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json'); // Devolver JSON

$host = 'localhost';
$user = 'bventura';
$password = 'Stanlyv_00363';
$dbname = 'ClientesDB';

// Conectar a la base de datos
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión: ' . $conn->connect_error]);
    exit();
}

// Obtener y sanitizar los datos del formulario
$nombre_base_datos = trim($_POST['nombre_base_datos'] ?? '');
$campana = trim($_POST['campana'] ?? '');
$fecha_ingreso = trim($_POST['fecha_ingreso'] ?? '');
$clientes = json_decode($_POST['clientes'] ?? '[]', true);

// Validación de campos obligatorios
if (!$nombre_base_datos || !$campana || !$fecha_ingreso || empty($clientes) || !is_array($clientes)) {
    echo json_encode(['error' => 'Datos incompletos o inválidos']);
    exit();
}

// Sanitización del nombre de la tabla
$table_name = $conn->real_escape_string($nombre_base_datos);

// Crear tabla solo si no existe
$sql_create_table = "
    CREATE TABLE IF NOT EXISTS `{$table_name}` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre_cliente TEXT NOT NULL,
        apellido_cliente TEXT NOT NULL,
        numero_telefono TEXT NOT NULL,
        asesor_ventas TEXT NOT NULL,
        nombre_base_datos TEXT NOT NULL,
        campana TEXT NOT NULL,
        fecha_ingreso DATE NOT NULL
    )";

if (!$conn->query($sql_create_table)) {
    echo json_encode(['error' => 'Error al crear la tabla: ' . $conn->error]);
    exit();
}

// Preparar la consulta de inserción
$stmt = $conn->prepare("INSERT INTO `{$table_name}` (nombre_cliente, apellido_cliente, numero_telefono, asesor_ventas, nombre_base_datos, campana, fecha_ingreso) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)");

// Iniciar transacción
$conn->begin_transaction();

$omitted_clients = [];  // Array para almacenar los clientes omitidos

try {
    foreach ($clientes as $cliente) {
        $nombre_cliente = $cliente['nombre_cliente'] ?? '';
        $apellido_cliente = $cliente['apellido_cliente'] ?? '';
        $numero_telefono = $cliente['numero_telefono'] ?? '';
        $asesor_ventas = $cliente['asesor_ventas'] ?? '';

        // Validar datos obligatorios por cliente
        if (!$nombre_cliente || !$numero_telefono || !$asesor_ventas) {
            $omitted_clients[] = $cliente;  // Agregar el cliente omitido
            continue;  // Omitir registros incompletos
        }

        // Insertar cada cliente
        $stmt->bind_param("sssssss", $nombre_cliente, $apellido_cliente, $numero_telefono, $asesor_ventas, $nombre_base_datos, $campana, $fecha_ingreso);
        $stmt->execute();
    }

    $conn->commit(); // Confirmar transacción

    // Devolver respuesta
    if (count($omitted_clients) > 0) {
        echo json_encode([
            'success' => 'Datos guardados parcialmente. Algunos registros fueron omitidos debido a campos incompletos.',
            'omitted_clients' => $omitted_clients
        ]);
    } else {
        echo json_encode(['success' => 'Datos guardados exitosamente en la tabla ' . $table_name]);
    }

} catch (Exception $e) {
    $conn->rollback(); // Revertir en caso de error
    echo json_encode(['error' => 'Error al guardar los datos: ' . $e->getMessage()]);
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>