<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WhatsApp Imvesa</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script defer src="/front/js/menu.js"></script>
  <script defer src="/front/js/chartsData.js"></script>
  <link rel="stylesheet" href="/front/css/index.css">
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
          <a href="/front/pages/charts.php">
            <button class="flex w-full items-center justify-between rounded-lg p-2">
              <span>Métricas</span>
            </button>
            </a>
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
        <!-- Template Form -->
        <h1 class="text-3xl font-bold mb-6">Portal de Métricas</h1>
            <!-- Filtro de Fechas -->
            <div class="card mb-6 p-6 rounded-lg shadow-sm" style="background-color: #312f30;">
                <div class="mb-4">
                <h2 class="text-xl font-bold">Filtro de Fechas</h2>
                <p class="text-gray-400">Selecciona el rango de fechas para visualizar las métricas</p>
                </div>
                <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="start-date" class="block text-sm font-medium text-gray-400">Fecha de inicio</label>
                    <input type="date" id="start-date" class="border rounded-lg w-full px-3 py-2">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label for="end-date" class="block text-sm font-medium text-gray-400">Fecha de fin</label>
                    <input type="date" id="end-date" class="border rounded-lg w-full px-3 py-2">
                </div>
                <div class="flex items-end">
                    <button id="apply-filter" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Aplicar Filtro
                    </button>
                </div>
                </div>
            </div>
            <!-- Filtro de Clientes por Base de Datos -->
            <div class="card mb-6 p-6 rounded-lg shadow-sm" style="background-color: #312f30;">
                <h2 class="text-xl font-bold">Filtrar Clientes por Base de Datos</h2>
                <p class="text-gray-400">Filtra por cantidad mínima de clientes y nombre de base de datos</p>
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <label for="min-clients" class="block text-sm font-medium text-gray-400">Cantidad mínima de clientes</label>
                        <input type="number" id="min-clients" class="border rounded-lg px-3 py-2 w-32" min="0" value="0">
                    </div>
                    <div class="flex-1">
                        <label for="database-name" class="block text-sm font-medium text-gray-400">Selecciona Base de Datos</label>
                        <select id="database-name" class="border rounded-lg px-3 py-2 w-full">
                            <option value="">Todas</option> <!-- Opción por defecto -->
                        </select>
                    </div>
                    <button id="apply-client-filter" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Aplicar Filtro</button>
                </div>
            </div>
            <!-- Filtro de Mes para Bases de Datos -->
            <div class="card mb-6 p-6 rounded-lg shadow-sm" style="background-color: #312f30;">
                <h2 class="text-xl font-bold">Comparar Bases de Datos por Mes</h2>
                <p class="text-gray-400">Selecciona la cantidad de meses a comparar</p>
                <div class="flex items-center gap-4">
                    <input type="number" id="months-count" min="1" max="12" value="1" class="border rounded-lg px-3 py-2 w-20">
                    <button id="generate-month-filters" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Generar Filtros</button>
                </div>
                <div id="month-filters" class="mt-4"></div>
                <!-- Botón para comparar meses -->
                <button id="compare-months" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Comparar Meses</button>
            </div>
            <!-- Gráficos -->
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Gráfico de Mensajes -->
                <div class="card p-6 rounded-lg shadow-sm" style="background-color: #312f30;">
                <h2 class="text-xl font-bold">Mensajes Enviados por Día</h2>
                <canvas id="messagesChart" class="h-[300px]"></canvas>
                </div>
                <!-- Gráfico de Clientes -->
                <div class="card p-6 rounded-lg shadow-sm" style="background-color: #312f30;">
                <h2 class="text-xl font-bold">Clientes por Base de Datos</h2>
                <canvas id="clientsChart" class="h-[300px]"></canvas>
                </div>
                <!-- Gráfico de Bases de Datos -->
                <div class="card p-6  rounded-lg shadow-sm md:col-span-2" style="background-color: #312f30;">
                <h2 class="text-xl font-bold">Evolución de Bases de Datos</h2>
                <canvas id="databasesChart" class="h-[300px]"></canvas>
                </div>
            </div>
      </div>
    </main>
  </div>

  <!-- Overlay for mobile -->
  <div id="overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden hidden"></div>
</body>
</html>