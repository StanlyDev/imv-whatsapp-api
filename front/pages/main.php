<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mercadeo</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script defer src="/front/js/menu.js"></script>
  <script defer src="/front/js/previewMGS.js"></script>
  <link rel="stylesheet" href="/front/css/main.css">
</head>
<body class="flex h-screen">
  <!-- Sidebar -->
  <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex h-full flex-col">
      <div class="flex h-20 items-center justify-center border-b px-8">
        <span class="text-2xl font-semibold"><img src="/front/pics/logo/Imvesa_white.png" alt=""></span>
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
              <div class="space-y-6">
                <!-- Nombre -->
                <div>
                  <label for="name" class="block text-sm font-medium">Nombre</label>
                  <input id="name" placeholder="Nombre de la Plantilla" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <!-- Mensaje -->
                <div class="p-6 rounded-lg shadow-sm" style="background-color: #312f30;">
                  <h2 class="text-lg font-medium mb-4">Mensaje</h2>
                  <!-- Encabezado -->
                  <div class="mb-6">
                    <label class="block text-sm font-medium">Encabezado</label>
                    <p class="text-sm text-gray-400 mb-2">
                      Agregue un título para el mensaje o elija qué tipo de medio usarás para este encabezado
                    </p>
                    <div class="flex gap-4 mb-4">
                      <button class="px-4 py-2 border border-gray-300 rounded-lg" onclick="setHeaderType('none')">Ninguno</button>
                      <button class="px-4 py-2 border border-gray-300 rounded-lg" onclick="setHeaderType('text')">Texto</button>
                      <button class="px-4 py-2 border border-gray-300 rounded-lg" onclick="setHeaderType('media')">Media</button>
                      <!-- Input para seleccionar la imagen (oculto inicialmente) -->
                    </div>
                    <input type="file" id="imageInput" class="hidden" accept="image/*" onchange="previewImage(event)">
                    <div class="relative hidden" id="headerImagePreview">
                      <img id="headerImage" src="" alt="Imagen Previa" class="w-full rounded-lg">
                    </div>
                    <div class="relative hidden" id="headerInput">
                      <input placeholder="Buen día estimado, {{nombre}}" maxlength="60" class="block w-full p-2 border border-gray-300 rounded-lg">
                      <span class="absolute right-2 top-2 text-sm text-gray-400">0/60</span>
                    </div>
                  </div>
                  <!-- Cuerpo -->
                  <div>
                    <label class="block text-sm font-medium">Cuerpo</label>
                    <p class="text-sm text-gray-400 mb-2">
                      Ingrese el texto de su mensaje.
                    </p>
                    <div class="relative">
                      <textarea id="bodyText" placeholder="Aquí tu contenido del mensaje a enviar." class="block w-full p-2 border border-gray-300 rounded-lg min-h-[100px]" maxlength="1024"></textarea>
                      <span class="absolute right-2 bottom-2 text-sm text-gray-400">0/1024</span>
                    </div>
                    <div class="flex items-center gap-2 mt-4 border-t border-gray-700 pt-4">
                      <button class="p-2 border border-gray-300 rounded-lg"><b>B</b></button>
                      <button class="p-2 border border-gray-300 rounded-lg"><i>I</i></button>
                      <button class="p-2 border border-gray-300 rounded-lg"><s>S</s></button>
                      <div class="h-6 w-px bg-gray-200 mx-2"></div>
                      <button class="px-4 py-2 border border-gray-300 rounded-lg" onclick="openPreview()">Previsualizar</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal de Previsualización -->
            <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
              <div class="p-6 rounded-lg max-w-xs w-full" style="background-color: #312f30;">
                <h2 class="text-lg font-semibold mb-4">Previsualización de WhatsApp</h2>
                <div class="p-4 rounded-lg">
                  <div class="relative w-full">
                    <svg width="300" height="600" viewBox="0 0 400 800" xmlns="http://www.w3.org/2000/svg">
                      <rect x="10" y="10" width="280" height="580" rx="30" ry="30" stroke="black" stroke-width="4" fill="white"/>
                      <rect x="130" y="20" width="40" height="10" rx="5" ry="5" fill="black"/>
                      <foreignObject x="20" y="50" width="260" height="500">
                        <div xmlns="http://www.w3.org/1999/xhtml" style="font-family: sans-serif; text-align: justify; padding-top: 30px; background-color: #205441; border-radius: 1rem;">
                          <p id="headerPreview" class="font-medium mb-1" style="padding: 1rem;"></p>
                          <p id="bodyPreview" class="text-white-700" style="margin-left: 1rem;"></p>
                          <p class="text-xs text-white-500 text-right mt-1">12:00 PM</p>
                        </div>
                      </foreignObject>
                    </svg>
                  </div>
                </div>
                <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg" onclick="closePreview()">Cerrar</button>
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