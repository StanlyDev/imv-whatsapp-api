<?php
$host = 'localhost';
$user = 'bventura';
$password = 'Stanlyv_00363';
$dbname = 'ClientesDB';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tableName = $_GET['table'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 50;  // Número de registros por página
$offset = ($page - 1) * $limit;

if (empty($tableName)) {
    echo "No se especificó una tabla.";
    exit;
}

$query = "SELECT id, nombre_cliente, apellido_cliente, numero_telefono, asesor_ventas FROM `$tableName` LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

$totalQuery = "SELECT COUNT(*) as total FROM `$tableName`";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$total = $totalRow['total'];
$totalPages = ceil($total / $limit);

if ($result->num_rows > 0) {
    echo "<table class='w-full border-collapse'>
            <thead>
              <tr>
                <th class='border px-4 py-2'>ID</th>
                <th class='border px-4 py-2'>Nombre del Cliente</th>
                <th class='border px-4 py-2'>Apellido del Cliente</th>
                <th class='border px-4 py-2'>Número de Teléfono</th>
                <th class='border px-4 py-2'>Asesor de Ventas</th>
              </tr>
            </thead>
            <tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td class='border px-4 py-2'>{$row['id']}</td>
                <td class='border px-4 py-2'>{$row['nombre_cliente']}</td>
                <td class='border px-4 py-2'>{$row['apellido_cliente']}</td>
                <td class='border px-4 py-2'>{$row['numero_telefono']}</td>
                <td class='border px-4 py-2'>{$row['asesor_ventas']}</td>
              </tr>";
    }
    echo "</tbody></table>";

    // Navegación de páginas
    echo "<div class='mt-4 flex justify-between'>";
    if ($page > 1) {
        echo "<button onclick='loadTableData(\"$tableName\", " . ($page - 1) . ")' class='px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded'>Anterior</button>";
    }
    if ($page < $totalPages) {
        echo "<button onclick='loadTableData(\"$tableName\", " . ($page + 1) . ")' class='px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded'>Siguiente</button>";
    }
    echo "</div>";
} else {
    echo "<p>No hay datos disponibles para esta tabla.</p>";
}

$conn->close();
?>