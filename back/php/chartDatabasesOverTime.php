<?php
header('Content-Type: application/json');

// Configuración de la conexión a la base de datos
$host = 'localhost';
$db = 'ClientesDB';
$user = 'bventura';
$password = 'Stanlyv_00363';

try {
    // Crear conexión PDO
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener todas las tablas de la base de datos
    $tablesQuery = $conn->query("SHOW TABLES");
    $tables = $tablesQuery->fetchAll(PDO::FETCH_COLUMN);

    // Crear una consulta dinámica que une todas las tablas
    $unionQueries = [];
    foreach ($tables as $table) {
        // Verificar si la tabla tiene la columna `fecha_ingreso`
        $checkColumn = $conn->query("SHOW COLUMNS FROM `$table` LIKE 'fecha_ingreso'");
        if ($checkColumn->rowCount() > 0) {
            // Agregar consulta para esta tabla
            $unionQueries[] = "SELECT fecha_ingreso FROM `$table`";
        }
    }

    if (count($unionQueries) === 0) {
        echo json_encode(['error' => 'No se encontraron tablas con la columna fecha_ingreso.']);
        exit;
    }

    // Construir consulta final uniendo todas las tablas dinámicamente
    $finalQuery = implode(" UNION ALL ", $unionQueries);
    $sql = "
        SELECT DATE_FORMAT(fecha_ingreso, '%Y-%m') AS month_created, COUNT(*) AS table_count
        FROM ($finalQuery) AS all_clients
        GROUP BY month_created
        ORDER BY month_created ASC
    ";

    // Ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obtener resultados
    $monthlyData = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $monthlyData[] = [
            'month' => $row['month_created'],
            'databases' => intval($row['table_count'])
        ];
    }

    // Devolver resultados en formato JSON
    echo json_encode($monthlyData);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la conexión: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Error inesperado: ' . $e->getMessage()]);
} finally {
    $conn = null;  // Cerrar la conexión
}
?>