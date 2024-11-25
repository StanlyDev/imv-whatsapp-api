let headerType = 'none';

function setHeaderType(type) {
  headerType = type;
  const headerInput = document.getElementById('headerInput');
  const headerImagePreview = document.getElementById('headerImagePreview');
  const imageInput = document.getElementById('imageInput');
  
  // Mostrar el input de archivo si se selecciona 'media', ocultar el campo de texto
  if (type === 'media') {
    headerInput.classList.add('hidden');
    headerImagePreview.classList.remove('hidden');
    imageInput.click();  // Abrir el selector de archivo
  } else {
    headerInput.classList.toggle('hidden', type !== 'text');
    headerImagePreview.classList.add('hidden');
  }
}

function previewImage(event) {
  const file = event.target.files[0];
  const imagePreview = document.getElementById('headerImage');
  
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      imagePreview.src = e.target.result; // Mostrar la imagen seleccionada
    }
    reader.readAsDataURL(file);
  }
}

function openPreview() {
  const headerPreview = document.getElementById('headerPreview');
  const bodyPreview = document.getElementById('bodyPreview');
  const headerText = document.querySelector('#headerInput input')?.value || '';
  const bodyText = document.getElementById('bodyText').value || 'Contenido del mensaje';

  // Mostrar encabezado como texto o imagen
  if (headerType === 'text') {
    headerPreview.innerHTML = headerText;
  } else if (headerType === 'media') {
    const image = document.getElementById('headerImage');
    headerPreview.innerHTML = `<img src="${image.src}" alt="Imagen de encabezado" class="w-full rounded-lg mb-4">`;
  }

  bodyPreview.textContent = bodyText;
  document.getElementById('previewModal').classList.remove('hidden');
}

function closePreview() {
  document.getElementById('previewModal').classList.add('hidden');
}