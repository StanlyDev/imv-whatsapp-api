// Datos iniciales
const messageData = [
    { date: '2023-01-01', messages: 120 },
    { date: '2023-01-02', messages: 150 },
    { date: '2023-01-03', messages: 200 },
    { date: '2023-01-04', messages: 180 },
    { date: '2023-01-05', messages: 250 },
    { date: '2023-01-06', messages: 300 },
    { date: '2023-01-07', messages: 280 },
  ];
  
  const clientsPerDatabaseData = [
    { database: 'Clientes Potenciales', clients: 1500 },
    { database: 'Clientes Actuales', clients: 3000 },
    { database: 'Leads Facebook', clients: 500 },
    { database: 'Campaña Verano', clients: 2000 },
    { database: 'Fidelización', clients: 1800 },
  ];
  
  const databasesOverTimeData = [
    { month: 'Ene', databases: 2 },
    { month: 'Feb', databases: 3 },
    { month: 'Mar', databases: 3 },
    { month: 'Abr', databases: 4 },
    { month: 'May', databases: 4 },
    { month: 'Jun', databases: 5 },
  ];
  
  // Crear gráficos
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
  
  const clientsChart = new Chart(document.getElementById('clientsChart').getContext('2d'), {
    type: 'bar',
    data: {
      labels: clientsPerDatabaseData.map(item => item.database),
      datasets: [{
        label: 'Número de Clientes',
        data: clientsPerDatabaseData.map(item => item.clients),
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
  
  const databasesChart = new Chart(document.getElementById('databasesChart').getContext('2d'), {
    type: 'bar',
    data: {
      labels: databasesOverTimeData.map(item => item.month),
      datasets: [{
        label: 'Número de Bases de Datos',
        data: databasesOverTimeData.map(item => item.databases),
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
  
  // Filtrar datos por fecha
  document.getElementById('apply-filter').addEventListener('click', () => {
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
  
    // Validación de fechas
    if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
      alert('La fecha de inicio no puede ser posterior a la fecha de fin.');
      return;
    }
  
    if (!startDate || !endDate) {
      alert('Por favor, seleccione ambas fechas.');
      return;
    }
  
    // Filtrar los datos de mensajes
    const filteredData = messageData.filter(item => item.date >= startDate && item.date <= endDate);
  
    if (filteredData.length === 0) {
      alert('No hay datos disponibles para este rango de fechas.');
    } else {
      // Actualizar el gráfico de mensajes
      messagesChart.data.labels = filteredData.map(item => item.date);
      messagesChart.data.datasets[0].data = filteredData.map(item => item.messages);
      messagesChart.update();
    }
  });
  
  // Filtrar y comparar los datos por los meses seleccionados
  document.getElementById('generate-month-filters').addEventListener('click', () => {
    const monthsCount = document.getElementById('months-count').value;
    const monthFiltersContainer = document.getElementById('month-filters');
  
    // Limpiar los filtros previos
    monthFiltersContainer.innerHTML = '';
  
    // Generar el número adecuado de selectores de mes
    for (let i = 0; i < monthsCount; i++) {
      const monthSelect = document.createElement('select');
      monthSelect.id = `month-${i + 1}`;
      monthSelect.classList.add('border', 'rounded-lg', 'px-3', 'py-2', 'w-full', 'mb-2');
      monthSelect.innerHTML = `
        <option value="">Selecciona un mes</option>
        ${databasesOverTimeData.map(item => `<option value="${item.month}">${item.month}</option>`).join('')}
      `;
      monthFiltersContainer.appendChild(monthSelect);
    }
  });
  
  // Comparar meses
  document.getElementById('compare-months').addEventListener('click', () => {
    const selectedMonths = [];
    const monthsCount = document.getElementById('months-count').value;
  
    // Recoger los meses seleccionados
    for (let i = 0; i < monthsCount; i++) {
      const monthSelect = document.getElementById(`month-${i + 1}`);
      const selectedMonth = monthSelect.value;
  
      if (selectedMonth) {
        selectedMonths.push(selectedMonth);
      }
    }
  
    if (selectedMonths.length === 0) {
      alert('Por favor selecciona al menos un mes.');
      return;
    }
  
    // Filtrar los datos según los meses seleccionados
    const filteredData = databasesOverTimeData.filter(item => selectedMonths.includes(item.month));
  
    if (filteredData.length === 0) {
      alert('No hay datos disponibles para los meses seleccionados.');
      return;
    }
  
    // Actualizar el gráfico con los datos filtrados
    databasesChart.data.labels = filteredData.map(item => item.month);
    databasesChart.data.datasets[0].data = filteredData.map(item => item.databases);
    databasesChart.update();
  });
  
  // Filtro de Clientes por cantidad mínima y nombre de base de datos
  document.getElementById('apply-client-filter').addEventListener('click', () => {
    const minClients = parseInt(document.getElementById('min-clients').value);
    const selectedDatabase = document.getElementById('database-name').value;
  
    // Filtrar los datos según los valores seleccionados
    const filteredData = clientsPerDatabaseData.filter(item => {
      const isDatabaseMatch = selectedDatabase ? item.database === selectedDatabase : true;
      const isClientCountMatch = item.clients >= minClients;
      return isDatabaseMatch && isClientCountMatch;
    });
  
    // Actualizar el gráfico con los datos filtrados
    if (filteredData.length === 0) {
      alert('No hay datos disponibles para el filtro seleccionado.');
    } else {
      clientsChart.data.labels = filteredData.map(item => item.database);
      clientsChart.data.datasets[0].data = filteredData.map(item => item.clients);
      clientsChart.update();
    }
  });