<?php
// Conexión a la base de datos
$host = 'localhost';
$user = 'bventura';
$password = 'Stanlyv_00363';
$dbname = 'ClientesDB';

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener todas las tablas de la base de datos
$result = $conn->query("SHOW TABLES");
$tablas = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tablas[] = $row['Tables_in_' . $dbname];  // Obtener el nombre de la tabla
    }
} else {
    echo "Error al obtener las tablas: " . $conn->error;
}

if (empty($tablas)) {
    echo "<tr><td colspan='5'>No se encontraron bases de datos.</td></tr>";
} else {
    foreach ($tablas as $tabla) {
        // Verificar si la tabla tiene registros
        $countQuery = "SELECT COUNT(*) as count FROM `$tabla`";
        $countResult = $conn->query($countQuery);
        if ($countResult) {
            $countRow = $countResult->fetch_assoc();
            $numRegistros = $countRow['count'];
        } else {
            $numRegistros = 0;
        }

        // Obtener los detalles de la campaña y fecha desde el primer registro de la tabla
        $detailsQuery = "SELECT campana, fecha_ingreso FROM `$tabla` LIMIT 1";
        $detailsResult = $conn->query($detailsQuery);
        if ($detailsResult && $detailsRow = $detailsResult->fetch_assoc()) {
            $campana = $detailsRow['campana'] ?? 'Desconocida';
            $fecha_ingreso = $detailsRow['fecha_ingreso'] ?? 'Desconocida';
        } else {
            $campana = 'Desconocida';
            $fecha_ingreso = 'Desconocida';
        }

        // Mostrar la fila con los datos
        echo "<tr class='table-row'>
                <td>{$tabla}</td>
                <td>{$campana}</td>
                <td>{$fecha_ingreso}</td>
                <td>{$numRegistros}</td>
                <td class='text-right'>
                  <button class='icon'>👁️</button>
                  <button class='icon'>✏️</button>
                  <button class='icon'>🗑️</button>
                </td>
              </tr>";
    }
}

// Cerrar la conexión
$conn->close();
?>