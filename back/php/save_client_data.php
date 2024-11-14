<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

// Crear una nueva tabla con el nombre proporcionado
$table_name = $conn->real_escape_string($nombre_base_datos);  // Evitar inyección SQL

// Consultar para ver si la tabla ya existe
$query = "SHOW TABLES LIKE '$table_name'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    die("Error: La tabla '$table_name' ya existe.");
}

// Crear la tabla con las columnas correspondientes
$sql_create_table = "CREATE TABLE `{$table_name}` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_cliente TEXT NOT NULL,
    apellido_cliente TEXT NOT NULL,
    numero_telefono TEXT NOT NULL,
    asesor_ventas TEXT NOT NULL,
    nombre_base_datos TEXT NOT NULL,
    campana TEXT NOT NULL,
    fecha_ingreso DATE NOT NULL
)";

// Ejecutar la consulta para crear la tabla
if (!$conn->query($sql_create_table)) {
    die("Error al crear la tabla: " . $conn->error);
}

// Preparar la consulta SQL para insertar cada cliente
$stmt = $conn->prepare("INSERT INTO $table_name (nombre_cliente, apellido_cliente, numero_telefono, asesor_ventas, nombre_base_datos, campana, fecha_ingreso) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)");

// Insertar los clientes uno por uno
foreach ($clientes as $cliente) {
    // Validar que los datos del cliente no estén vacíos (solo para los campos obligatorios)
    if (empty($cliente['nombre_cliente']) || empty($cliente['numero_telefono']) || empty($cliente['asesor_ventas'])) {
        continue;  // Omite clientes con datos críticos vacíos
    }

    // Si no hay errores, insertar el cliente
    $nombre_cliente = $cliente['nombre_cliente'];
    $apellido_cliente = isset($cliente['apellido_cliente']) ? $cliente['apellido_cliente'] : '';  // Si no hay apellido, poner vacío
    $numero_telefono = $cliente['numero_telefono'];
    $asesor_ventas = $cliente['asesor_ventas'];

    // Vincular parámetros y ejecutar la consulta
    $stmt->bind_param("sssssss", $nombre_cliente, $apellido_cliente, $numero_telefono, $asesor_ventas, $nombre_base_datos, $campana, $fecha_ingreso);

    if (!$stmt->execute()) {
        echo "Error al guardar los datos del cliente: " . $stmt->error;
    }
}

echo "Datos guardados exitosamente en la tabla '$table_name'.";

// Cerrar la conexión
$stmt->close();
$conn->close();
?>