<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WhatsApp Imvesa</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script defer src="/front/js/menu.js"></script>
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
        <div class="flex min-h-screen">
          <div class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-5xl">
              <!-- Header -->
              <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-semibold">Crear plantilla de mensaje de Whatsapp</h1>
                <div class="flex gap-4">
                  <button class="px-4 py-2 border border-gray-300 rounded-lg">Cancelar</button>
                  <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">Crear plantilla</button>
                </div>
              </div>
              <p class="mb-8">
                Las plantillas de mensajes no se pueden editar una vez que han sido enviadas para solicitar su aprobación.
              </p>
              <!-- Form -->
              <div class="space-y-6">
                <div>
                  <label for="name" class="block text-sm font-medium">Nombre</label>
                  <input id="name" placeholder="Nombre de la Plantilla" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <div class="p-6 rounded-lg shadow-sm" style="background-color: #312f30;">
                  <h2 class="text-lg font-medium mb-4">Mensaje</h2>
                  <!-- Header Section -->
                  <div class="mb-6">
                    <label class="block text-sm font-medium">Encabezado</label>
                    <p class="text-sm text-gray-400 mb-2">
                      Agregue un título para el mensaje o elija qué tipo de medio usarás para este encabezado
                    </p>
                    <div class="flex gap-4 mb-4">
                      <button class="dsb-head px-4 py-2 border border-gray-300 rounded-lg">Ninguno</button>
                      <button class="px-4 py-2 border border-gray-300 rounded-lg">Texto</button>
                      <label for="file-input" class="btn px-4 py-2 border border-gray-300 rounded-lg">
                        Media
                        <input id="file-input" type="file" class="hidden">
                      </label>
                    </div>
                    <div class="relative">
                      <input placeholder="Buen dia estimado, {{nombre}}" maxlength="60" class="block w-full p-2 border border-gray-300 rounded-lg">
                      <span class="absolute right-2 top-2 text-sm text-gray-400">0/60</span>
                    </div>
                  </div>
                  <!-- Body Section -->
                  <div>
                    <label class="block text-sm font-medium">Cuerpo</label>
                    <p class="text-sm text-gray-400 mb-2">
                      Ingrese el texto de su mensaje en el idioma que seleccionó.
                    </p>
                    <div class="relative">
                      <textarea placeholder="Aqui tu contenido del mensaje a enviar." class="block w-full p-2 border border-gray-300 rounded-lg min-h-[100px]" maxlength="1024"></textarea>
                      <span class="absolute right-2 bottom-2 text-sm text-gray-400">0/1024</span>
                    </div>
                    <div class="flex items-center gap-2 mt-4 border-t pt-4">
                      <button class="p-2 border border-gray-300 rounded-lg"><b>B</b></button>
                      <button class="p-2 border border-gray-300 rounded-lg"><i>I</i></button>
                      <button class="p-2 border border-gray-300 rounded-lg"><s>S</s></button>
                      <div class="h-6 w-px bg-gray-200 mx-2"></div>
                      <button class="px-4 py-2 border border-gray-300 rounded-lg">Previsualizar</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Overlay for mobile -->
  <div id="overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden hidden"></div>
</body>
</html>