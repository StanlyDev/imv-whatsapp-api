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
    // Depuración: Verifica las tablas obtenidas
    echo "<pre>Tablas obtenidas: ";
    var_dump($tablas);
    echo "</pre>";
} else {
    echo "Error al obtener las tablas: " . $conn->error;
}

// Si no se encontraron tablas, mostrar mensaje
if (empty($tablas)) {
    echo "<tr><td colspan='5'>No se encontraron bases de datos.</td></tr>";
} else {
    foreach ($tablas as $tabla) {
        // Verificar si la tabla tiene registros
        $countQuery = "SELECT COUNT(*) as count FROM `$tabla`";
        $countResult = $conn->query($countQuery);

        // Depuración: Verifica el resultado de la consulta COUNT
        if (!$countResult) {
            echo "Error al ejecutar el conteo de registros para la tabla $tabla: " . $conn->error;
        } else {
            $countRow = $countResult->fetch_assoc();
            $numRegistros = $countRow['count'];

            // Depuración: Verifica los resultados de la cuenta
            echo "<pre>Tabla: $tabla, Registros: $numRegistros</pre>";
        }

        // Obtener los detalles de la campaña y fecha desde el primer registro de la tabla
        $detailsQuery = "SELECT campana, fecha_ingreso FROM `$tabla` LIMIT 1";
        $detailsResult = $conn->query($detailsQuery);

        // Depuración: Verifica el resultado de la consulta para obtener campaña y fecha
        if (!$detailsResult) {
            echo "Error al ejecutar la consulta para obtener detalles en la tabla $tabla: " . $conn->error;
        } else {
            // Verifica si se obtuvieron datos
            $detailsRow = $detailsResult->fetch_assoc();
            if ($detailsRow) {
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
}

// Cerrar la conexión
$conn->close();
?>