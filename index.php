<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/front/css/index.css">
</head>
<body>
  <div class="min-h-screen flex items-center justify-center">
    <div class="form-container p-8 rounded-lg shadow-xl w-full max-w-md">
      <div class="flex h-20 items-center justify-center border-b px-8">
        <span class="text-2xl font-semibold"><img src="/front/pics/logo/Imvesa_white.png" alt=""></span>
      </div>
      <h2 class="text-3xl font-bold mb-6 text-white text-center">Iniciar Sesión</h2>
      <form class="space-y-6">
        <div>
          <label for="username" class="block text-sm font-medium text-gray-300 mb-2">Nombre de Usuario</label>
          <input
            id="username"
            name="username"
            type="text"
            required
            class="w-full px-3 py-2 input-field rounded-md text-white focus:outline-none focus:ring-2"
            placeholder="Ingrese su nombre de usuario"
          />
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Contraseña</label>
          <div class="relative">
            <input
              id="password"
              name="password"
              type="password"
              required
              class="w-full px-3 py-2 input-field rounded-md text-white focus:outline-none focus:ring-2"
              placeholder="Ingrese su contraseña"
            />
            <button
              type="button"
              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-300"
              onclick="togglePasswordVisibility()"
            >
              <span id="eye-icon" class="h-5 w-5">👁️</span>
            </button>
          </div>
        </div>
        <div>
          <button
            type="submit"
            class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white button hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
          >
            Iniciar Sesión
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function togglePasswordVisibility() {
      const passwordField = document.getElementById('password');
      const eyeIcon = document.getElementById('eye-icon');
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.textContent = '🙈'; // Ojo cerrado
      } else {
        passwordField.type = 'password';
        eyeIcon.textContent = '👁️'; // Ojo abierto
      }
    }
  </script>
</body>
</html>