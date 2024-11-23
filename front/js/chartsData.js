// Datos iniciales
const messageData = [
    { date: '2024-01-01', messages: 120 },
    { date: '2024-02-02', messages: 150 },
    { date: '2024-03-03', messages: 200 },
    { date: '2024-04-04', messages: 180 },
    { date: '2024-05-05', messages: 250 },
    { date: '2024-06-06', messages: 300 },
    { date: '2024-07-07', messages: 280 },
    { date: '2024-08-08', messages: 172 },
    { date: '2024-09-09', messages: 559 },
    { date: '2024-10-10', messages: 932 },
    { date: '2024-11-11', messages: 880 },
    { date: '2024-12-12', messages: 480 },
];

// Datos iniciales para el gráfico de evolución de bases de datos
let databasesChartData = [];

// Cargar las bases de datos dinámicamente
fetch('/back/php/chartClientCant.php')
    .then(response => response.json())
    .then(data => {
        const databaseSelect = document.getElementById('database-name');
        databaseSelect.innerHTML = '<option value="">Todas</option>'; // Vaciar opciones previas

        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item.database;
            option.textContent = item.database;
            databaseSelect.appendChild(option);
        });
    })
    .catch(error => console.error('Error al cargar bases de datos:', error));

// Crear gráficos de mensajes
const messagesChart = new Chart(document.getElementById('messagesChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: messageData.map(item => item.date),
        datasets: [{
            label: 'Mensajes Enviados',
            data: messageData.map(item => item.messages),
            borderColor: 'rgba(75, 192, 192, 1)',
            fill: false,
        }],
    },
    options: {
        responsive: true,
        scales: {
            x: { title: { display: true, text: 'Fecha' } },
            y: { title: { display: true, text: 'Mensajes' } },
        },
    },
});

// Gráfico de clientes por base de datos
let clientsChart;
fetch('/back/php/chartClientCant.php')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('clientsChart').getContext('2d');
        clientsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.database),
                datasets: [{
                    label: 'Número de Clientes',
                    data: data.map(item => item.clients),
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                }],
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                scales: {
                    x: { title: { display: true, text: 'Número de Clientes' } },
                    y: { title: { display: true, text: 'Bases de Datos' } },
                },
            },
        });
    })
    .catch(error => console.error('Error al cargar datos:', error));

// Gráfico de evolución de bases de datos
fetch('/back/php/chartDatabasesOverTime.php')
  .then(response => response.text()) // Cambia a text() temporalmente
  .then(text => {
      console.log('Respuesta del servidor:', text); // Verifica aquí la salida
      return JSON.parse(text); // Intenta parsear si todo parece correcto
  })
  .then(data => {
      // Continúa solo si la respuesta es válida
      console.log('Datos procesados:', data);
      const ctx = document.getElementById('databasesChart').getContext('2d');
      databasesChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: data.map(item => item.month),
              datasets: [{
                  label: 'Número de Bases de Datos',
                  data: data.map(item => item.databases),
                  backgroundColor: 'rgba(255, 159, 64, 0.6)',
              }],
          },
          options: {
              responsive: true,
              scales: {
                  x: { title: { display: true, text: 'Mes' } },
                  y: { title: { display: true, text: 'Bases de Datos' } },
              },
          },
      });
  })
  .catch(error => console.error('Error al cargar datos de evolución:', error));

// Funcionalidad de filtro de mensajes
document.getElementById('apply-filter').addEventListener('click', () => {
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;

    if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
        alert('La fecha de inicio no puede ser posterior a la fecha de fin.');
        return;
    }

    if (!startDate || !endDate) {
        alert('Por favor, seleccione ambas fechas.');
        return;
    }

    const filteredData = messageData.filter(item => item.date >= startDate && item.date <= endDate);

    if (filteredData.length === 0) {
        alert('No hay datos disponibles para este rango de fechas.');
    } else {
        messagesChart.data.labels = filteredData.map(item => item.date);
        messagesChart.data.datasets[0].data = filteredData.map(item => item.messages);
        messagesChart.update();
    }
});

// Filtro de Clientes por cantidad mínima y nombre de base de datos
document.getElementById('apply-client-filter').addEventListener('click', () => {
    if (!clientsChart) {
        alert('El gráfico aún no ha sido cargado.');
        return;
    }

    const minClients = parseInt(document.getElementById('min-clients').value) || 0;
    const selectedDatabase = document.getElementById('database-name').value;

    fetch('/back/php/chartClientCant.php')
        .then(response => response.json())
        .then(data => {
            const filteredData = data.filter(item => {
                const isDatabaseMatch = selectedDatabase ? item.database === selectedDatabase : true;
                return item.clients >= minClients && isDatabaseMatch;
            });

            if (filteredData.length === 0) {
                alert('No hay datos disponibles para el filtro seleccionado.');
            } else {
                clientsChart.data.labels = filteredData.map(item => item.database);
                clientsChart.data.datasets[0].data = filteredData.map(item => item.clients);
                clientsChart.update();
            }
        })
        .catch(error => console.error('Error al filtrar datos:', error));
});

// Funcionalidad para generar filtros de meses
document.getElementById('generate-month-filters').addEventListener('click', () => {
    const monthsCount = parseInt(document.getElementById('months-count').value) || 1;
    const monthFiltersContainer = document.getElementById('month-filters');
    monthFiltersContainer.innerHTML = ''; // Limpiar filtros previos

    // Generar los filtros según la cantidad de meses
    for (let i = 0; i < monthsCount; i++) {
        const filterDiv = document.createElement('div');
        filterDiv.classList.add('mb-2');
        filterDiv.innerHTML = `
            <label for="month-${i}" class="text-sm">Mes ${i + 1}</label>
            <input type="month" id="month-${i}" class="border rounded-lg px-3 py-2 w-full mt-1">
        `;
        monthFiltersContainer.appendChild(filterDiv);
    }
});

// Funcionalidad para comparar meses y actualizar el gráfico
document.getElementById('compare-months').addEventListener('click', () => {
    const monthsCount = parseInt(document.getElementById('months-count').value) || 1;
    const selectedMonths = [];

    // Obtener los valores de los filtros de mes
    for (let i = 0; i < monthsCount; i++) {
        const monthValue = document.getElementById(`month-${i}`).value;
        if (monthValue) {
            selectedMonths.push(monthValue);
        }
    }

    if (selectedMonths.length === 0) {
        alert('Por favor, selecciona al menos un mes para comparar.');
        return;
    }

    // Filtrar los datos de acuerdo con los meses seleccionados
    fetch('/back/php/chartDatabasesOverTime.php')
        .then(response => response.json()) // Cambié text() a json() porque es lo que necesitas
        .then(data => {
            databasesChartData = data.filter(item => selectedMonths.includes(item.month));
            
            if (databasesChartData.length === 0) {
                alert('No hay datos disponibles para los meses seleccionados.');
                return;
            }

            // Actualizar el gráfico con los nuevos datos filtrados
            if (databasesChart) {
                databasesChart.data.labels = databasesChartData.map(item => item.month);
                databasesChart.data.datasets[0].data = databasesChartData.map(item => item.databases);
                databasesChart.update();
            }
        })
        .catch(error => console.error('Error al cargar los datos de evolución de bases de datos:', error));
});