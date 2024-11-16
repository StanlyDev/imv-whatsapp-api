<?php
header('Content-Type: application/json');

// Obtener datos de la solicitud
$input = json_decode(file_get_contents('php://input'), true);
$tabla = $input['tabla'] ?? null;

if ($tabla) {
    $host = 'localhost';
    $user = 'bventura';
    $password = 'Stanlyv_00363';
    $dbname = 'ClientesDB';

    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos']);
        exit;
    }

    // Intentar eliminar la tabla
    $query = "DROP TABLE `$tabla`";
    if ($conn->query($query) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Tabla no especificada']);
}
?>