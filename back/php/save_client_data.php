<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configuración de la base de datos
$host = '192.168.124.133'; // o la IP de tu servidor MySQL
$db = 'ClientesDB';
$user = 'bventura'; // Cambia esto con tu usuario de MySQL
$pass = 'Stanlyv_00363'; // Cambia esto con tu contraseña de MySQL

// Conexión a la base de datos con MySQLi
$conn = new mysqli($host, $user, $pass, $db);

// Verificar si hay errores de conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si los datos fueron enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre_base_datos = $_POST['nombre_base_datos'] ?? '';
    $campana = $_POST['campana'] ?? '';
    $fecha_ingreso = $_POST['fecha_ingreso'] ?? '';
    $clientes = json_decode($_POST['clientes'], true);

    // Verificar si los datos necesarios están presentes
    if (empty($nombre_base_datos) || empty($campana) || empty($fecha_ingreso) || empty($clientes)) {
        echo "Por favor, complete todos los campos y asegúrese de que haya datos válidos.";
        exit;
    }

    // Insertar los datos en la base de datos
    foreach ($clientes as $cliente) {
        $nombre_cliente = $conn->real_escape_string($cliente['nombre_cliente']);
        $apellido_cliente = $conn->real_escape_string($cliente['apellido_cliente']);
        $numero_telefono = $conn->real_escape_string($cliente['numero_telefono']);
        $asesor_ventas = $conn->real_escape_string($cliente['asesor_ventas']);

        // Preparar la consulta SQL para insertar los datos del cliente
        $sql = "INSERT INTO Clientes (nombre_cliente, apellido_cliente, numero_telefono, asesor_ventas, nombre_base_datos, campana, fecha_ingreso)
                VALUES ('$nombre_cliente', '$apellido_cliente', '$numero_telefono', '$asesor_ventas', '$nombre_base_datos', '$campana', '$fecha_ingreso')";

        // Mostrar la consulta SQL para depuración (puedes eliminar esta línea una vez que todo funcione)
        echo $sql . "<br>";  

        if (!$conn->query($sql)) {
            // Si hay un error en la inserción, muestra el error
            echo "Error al insertar cliente: " . $conn->error;
            exit;
        }
    }

    // Si todo fue exitoso
    echo "Los datos se han guardado correctamente.";
} else {
    echo "Método no permitido.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>