<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WhatsApp Imvesa</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="/front/js/menu.js"></script>
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
              <input type="text" placeholder="Buscar base de datos..." />
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
            <tbody>
              <?php
              // Mostrar las tablas obtenidas desde la base de datos
              if (empty($tablas)) {
                  echo "<tr><td colspan='5'>No se encontraron bases de datos.</td></tr>";
              } else {
                  foreach ($tablas as $tabla) {
                      // Verificar si la tabla tiene registros
                      $conn = new mysqli($host, $user, $password, $dbname);
                      $query = "SELECT COUNT(*) as count FROM `$tabla`";
                      $countResult = $conn->query($query);
                      if ($countResult) {
                          $countRow = $countResult->fetch_assoc();
                          $numRegistros = $countRow['count'];
                      } else {
                          $numRegistros = 0;
                      }

                      // Mostrar la tabla
                      echo "<tr>
                            <td>{$tabla}</td>
                            <td>Desconocida</td> <!-- Aquí puedes poner la lógica para obtener la campaña -->
                            <td>Desconocida</td> <!-- Aquí puedes poner la lógica para obtener la fecha de creación -->
                            <td>{$numRegistros}</td>
                            <td class='text-right'>
                              <button class='icon'>👁️</button>
                              <button class='icon'>✏️</button>
                              <button class='icon'>🗑️</button>
                            </td>
                          </tr>";

                      // Cerrar la conexión
                      $conn->close();
                  }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
  <!-- Overlay for mobile -->
  <div id="overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden hidden"></div>
</body>
</html>