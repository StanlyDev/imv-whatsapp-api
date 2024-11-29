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

// Obtener todas las tablas de la base de datos
$result = $conn->query("SHOW TABLES");
$tablas = [];

if ($result->num_rows > 0) {
    // Almacenar todos los nombres de las tablas
    while ($row = $result->fetch_assoc()) {
        $tablas[] = $row['Tables_in_' . $dbname];  // Obtener el nombre de la tabla
    }
}

// Cerrar la conexión
$conn->close();
?>