<?php
// Configurar la conexión a la base de datos
$servername = "localhost";
$username = "bventura";
$password = "Stanlyv_00363";
$dbname = "ClientesDB";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos enviados desde JavaScript (en formato JSON)
$data = json_decode(file_get_contents("php://input"), true);

// Verificar si los datos fueron recibidos correctamente
if (is_array($data) && count($data) > 0) {
    $stmt = $conn->prepare("INSERT INTO Clientes (nombre_cliente, apellido_cliente, numero_telefono, asesor_ventas) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre_cliente, $apellido_cliente, $numero_telefono, $asesor_ventas);

    // Iterar sobre los datos y realizar las inserciones
    foreach ($data as $row) {
        // Separar el nombre completo en nombre y apellido
        $names = explode(' ', $row['fullName']);
        $nombre_cliente = $names[0];  // Suponemos que el primer nombre es el nombre
        $apellido_cliente = isset($names[1]) ? $names[1] : '';  // El segundo nombre es el apellido

        $numero_telefono = $row['phone'];
        $asesor_ventas = $row['advisor'];

        // Ejecutar la inserción en la base de datos
        if (!$stmt->execute()) {
            // Si hay un error, responder con un mensaje de error
            echo json_encode(['success' => false, 'message' => 'Error al guardar datos']);
            $conn->close();
            exit;
        }
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();

    // Responder con éxito
    echo json_encode(['success' => true]);
} else {
    // Si no se reciben datos válidos
    echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
}
?>