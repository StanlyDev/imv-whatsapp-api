let headerType = 'none';

function setHeaderType(type) {
  headerType = type;
  const headerInput = document.getElementById('headerInput');
  const imageInput = document.getElementById('imageInput');
  const headerImagePreview = document.getElementById('headerImagePreview');

  // Muestra/oculta los inputs según la selección
  headerInput.classList.toggle('hidden', type !== 'text');
  imageInput.classList.toggle('hidden', type !== 'media');
  headerImagePreview.classList.add('hidden'); // Oculta la imagen previa si se cambia la opción
}

// Previsualizar imagen seleccionada
function previewImage(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const headerImage = document.getElementById('headerImage');
      const headerImagePreview = document.getElementById('headerImagePreview');
      headerImage.src = e.target.result;
      headerImagePreview.classList.remove('hidden');
    };
    reader.readAsDataURL(file); // Lee la imagen como una URL base64
  }
}

// Abre el modal de previsualización
function openPreview() {
  const headerPreview = document.getElementById('headerPreview');
  const bodyPreview = document.getElementById('bodyPreview');
  const headerText = document.querySelector('#headerInput input')?.value || 'Encabezado';
  const bodyText = document.getElementById('bodyText').value || 'Contenido del mensaje';

  // Mostrar texto o imagen en el modal según el tipo de encabezado
  if (headerType === 'text') {
    headerPreview.textContent = headerText;
    headerPreview.classList.remove('hidden');
  } else if (headerType === 'media') {
    const imageSrc = document.getElementById('headerImage').src;
    headerPreview.innerHTML = imageSrc ? `<img src="${imageSrc}" class="w-full rounded-lg mb-2">` : '';
  } else {
    headerPreview.textContent = '';
  }

  bodyPreview.textContent = bodyText;
  document.getElementById('previewModal').classList.remove('hidden');
}

// Cierra el modal de previsualización
function closePreview() {
  document.getElementById('previewModal').classList.add('hidden');
}