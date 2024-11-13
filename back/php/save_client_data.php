<?php
// Conexión a la base de datos MySQL
$servername = "localhost";  // o la dirección IP de tu servidor MySQL
$username = "bventura";     // tu nombre de usuario MySQL
$password = "your_password"; // tu contraseña MySQL
$dbname = "ClientesDB";      // nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario
$nombre_base_datos = $_POST['nombre_base_datos'];
$campana = $_POST['campana'];
$fecha_ingreso = $_POST['fecha_ingreso'];

// Preparar la consulta para insertar los datos del formulario
$sql = "INSERT INTO Clientes (nombre_base_datos, campana, fecha_ingreso) VALUES (?, ?, ?)";

// Preparar la declaración
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nombre_base_datos, $campana, $fecha_ingreso);

// Ejecutar la declaración
if ($stmt->execute()) {
    echo "Datos guardados exitosamente";
} else {
    echo "Error al guardar los datos: " . $stmt->error;
}

// Si se ha cargado un archivo Excel
if (isset($_FILES['file-upload']) && $_FILES['file-upload']['error'] == 0) {
    $file = $_FILES['file-upload']['tmp_name'];
    $handle = fopen($file, "r");

    // Leer el archivo CSV línea por línea (dependiendo del tipo de archivo cargado)
    // Usamos una librería para manejar el archivo Excel si es necesario
    require_once 'PHPExcel/IOFactory.php'; // Asegúrate de tener la librería PHPExcel instalada.

    // Cargar el archivo Excel
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    
    foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);

        $rowData = [];
        foreach ($cellIterator as $cell) {
            $rowData[] = $cell->getValue();
        }

        // Guardar los datos de cada fila en la base de datos
        if (count($rowData) >= 4) {
            $nombre_cliente = $rowData[0];
            $apellido_cliente = $rowData[1];
            $numero_telefono = $rowData[2];
            $asesor_ventas = $rowData[3];

            // Insertar en la base de datos
            $sql = "INSERT INTO Clientes (nombre_cliente, apellido_cliente, numero_telefono, asesor_ventas, nombre_base_datos, campana, fecha_ingreso) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            // Preparar la declaración
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $nombre_cliente, $apellido_cliente, $numero_telefono, $asesor_ventas, $nombre_base_datos, $campana, $fecha_ingreso);
            $stmt->execute();
        }
    }

    fclose($handle);
    echo "Datos CSV/Excel cargados exitosamente";
} else {
    echo "No se cargó ningún archivo";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>