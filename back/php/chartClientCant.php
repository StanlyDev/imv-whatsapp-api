<?php
// Conexión a la base de datos
$host = 'localhost';
$db = 'ClientesDB';
$user = 'bventura';
$password = 'Stanlyv_00363';

$conexion = new mysqli($host, $user, $password, $db);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener todas las tablas
$tablas_result = $conexion->query("SHOW TABLES");
$clientes_por_tabla = [];

while ($tabla = $tablas_result->fetch_array()) {
    $nombre_tabla = $tabla[0];
    // Contar clientes en cada tabla
    $query = "SELECT COUNT(*) AS total FROM `$nombre_tabla`";
    $resultado = $conexion->query($query);
    $fila = $resultado->fetch_assoc();
    $clientes_por_tabla[] = ['database' => $nombre_tabla, 'clients' => $fila['total']];
}

$conexion->close();

// Devolver los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($clientes_por_tabla);
?>