<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WhatsApp Imvesa</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script defer src="/front/js/popup.js"></script>
  <script defer src="/front/js/menu.js"></script>
  <script defer src="/front/js/searchdb.js"></script>
  <link rel="stylesheet" href="/front/css/dbclient.css">
</head>
<body class="flex h-screen">
  <!-- Sidebar -->
  <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex h-full flex-col">
      <div class="flex h-20 items-center justify-center border-b px-8">
        <span class="text-2xl font-semibold"><img src="/front/pics/logo/Imvesa.png" alt=""></span>
      </div>
      <nav class="flex-1 overflow-y-auto p-4">
        <ul class="space-y-2">
          <li>
            <a href="/index.php">
              <button class="flex w-full items-center justify-between rounded-lg p-2">
                <span>Plantilla de mensajes</span>
              </button>
            </a>
          </li>
          <li>
            <button class="flex w-full items-center justify-between rounded-lg p-2">
              <span>Conversaciones</span>
            </button>
          </li>
          <li>
            <button class="flex w-full items-center justify-between rounded-lg p-2">
              <span>Métricas</span>
            </button>
          </li>
          <li>
            <a href="/front/pages/dbclient.php">
              <button class="flex w-full items-center justify-between rounded-lg p-2">
                <span>Base de datos</span>
              </button>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
  <!-- Main content -->
  <div class="flex flex-1 flex-col overflow-hidden">
    <header class="flex h-20 items-center justify-between border-b px-6">
      <button id="toggleSidebar" class="text-gray-400 focus:outline-none lg:hidden">
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
      </button>
      <div class="flex items-center space-x-4">
        <span class="text-2xl font-semibold">WhatsApp Imvesa</span>
      </div>
      <div class="flex items-center space-x-4">
        <button class="flex items-center space-x-2 rounded-full bg-gray-600 px-4 py-2 text-sm font-medium text-white hover:bg-gray-500 focus:outline-none">
          <span>User</span>
        </button>
      </div>
    </header>
    <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
      <div class="mx-auto max-w-7xl">
        <div class="container">
          <h1 class="main-heading">Bases de Datos de Clientes</h1>
          <div class="flex">
            <div class="relative">
              <input type="text" id="searchInput" placeholder="Buscar base de datos..." class="border p-2" />
            </div>
            <a href="/front/pages/add_ddclient.php">
              <button class="button btn" style="background-color: #4CAF50; color: white;">
                Nueva Base de Datos
              </button>
            </a>
          </div>
          <table>
            <thead>
              <tr>
                <th>Nombre de la Base de Datos</th>
                <th>Campaña</th>
                <th>Fecha de Creación</th>
                <th>Número de Registros</th>
                <th class="text-right">Acciones</th>
              </tr>
            </thead>
            <tbody id="tableBody">
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
            </tbody>
          </table>
        </div>
      </div>
    </main>
    <div id="popup" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
      <div class="bg-white rounded-lg p-6 w-3/4 max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-center">
          <h2 class="text-xl font-semibold">Detalles de Clientes</h2>
          <button id="closePopup" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>
        <div id="popupContent" class="mt-4 overflow-x-auto">
          <!-- Aquí se cargará la tabla con AJAX -->
        </div>
      </div>
    </div>
  </div>
  <!-- Overlay for mobile -->
  <div id="overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden hidden"></div>
</body>
</html>