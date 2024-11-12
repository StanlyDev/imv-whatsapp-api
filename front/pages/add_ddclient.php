<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WhatsApp Imvesa</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="/front/js/menu.js"></script>
  <script defer src="/front/js/update_client_db.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <link rel="stylesheet" href="/front/css/add_dbclient.css">
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
          <h1>Base de Datos de Clientes</h1>
          <!-- Formulario -->
          <div>
            <div class="form-group">
              <label for="dbName">Nombre de Base de Datos</label>
              <input type="text" id="dbName" placeholder="Ingrese el nombre de la base de datos">
            </div>
            <div class="form-group">
              <label for="campaign">Campaña</label>
              <input type="text" id="campaign" placeholder="Ingrese el nombre de la campaña">
            </div>
            <div class="form-group">
              <label for="date">Fecha</label>
              <input type="date" id="date">
            </div>
            <div class="form-group">
              <label for="file-upload">Cargar archivo Excel</label>
              <input type="file" id="file-upload" accept=".xlsx, .xls">
            </div>
          </div>
          <!-- Tabla de clientes -->
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre del Cliente</th>
                <th>Número de Teléfono</th>
                <th>Asesor de Ventas</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="4" style="text-align: center;">No hay datos disponibles</td>
              </tr>
            </tbody>
          </table>
          <!-- Botones de acción -->
          <div style="margin-top: 20px;">
            <button class="button button-save">Guardar</button>
            <button class="button button-delete">Eliminar</button>
          </div>
        </div>
      </div>
    </main>
  </div>
  <!-- Overlay for mobile -->
  <div id="overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden hidden"></div>
</body>
</html>