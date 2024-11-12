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
if (isset($data['dbName'], $data['campaign'], $data['date'], $data['clientes']) && is_array($data['clientes'])) {
    $dbName = $data['dbName'];
    $campaign = $data['campaign'];
    $date = $data['date'];
    
    // Preparar la consulta para insertar los datos en la tabla
    $stmt = $conn->prepare("
        INSERT INTO Clientes 
        (nombre_cliente, apellido_cliente, numero_telefono, asesor_ventas, nombre_base_datos, campaña, fecha_ingreso) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssssss", $nombre_cliente, $apellido_cliente, $numero_telefono, $asesor_ventas, $dbName, $campaign, $date);

    // Iterar sobre los datos de clientes y realizar las inserciones
    foreach ($data['clientes'] as $row) {
        // Separar el nombre completo en nombre y apellido
        $names = explode(' ', $row['fullName'], 2);
        $nombre_cliente = $names[0];
        $apellido_cliente = isset($names[1]) ? $names[1] : '';

        $numero_telefono = $row['phone'];
        $asesor_ventas = $row['advisor'];

        // Ejecutar la inserción en la base de datos
        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Error al guardar datos en cliente: ' . $stmt->error]);
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
    echo json_encode(['success' => false, 'message' => 'Datos incompletos o inválidos']);
}
?>