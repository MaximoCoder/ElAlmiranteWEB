<!-- NAVBAR -->
<nav>
       <i class='bx bx-menu'></i>
       
       <form action="#">
           <div class="form-input">
               
               <button><i class='bx bx-search'></i></button>
           </div>
       </form>
       <input type="checkbox" id="switch-mode" hidden>
       <label for="switch-mode" class="switch-mode"></label>

   </nav>

<!-- CONTENT WRAPPER -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <h3 class=" text-black">Gestión de Ventas</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div style="max-width: 1140px; margin: 0 auto;">
                <!-- Filas para Gráficas -->
                <div class="row">
                    <!-- Gráfica de Platillos Más Vendidos -->
                    <div class="col-md-6">
                        <div class="card card-primary mb-4">
                            <div class="card-header">
                                <div class="card-title">Gráfica de Platillos Más Vendidos</div>
                            </div>
                            <div class="card-body">
                                <canvas id="topSellingChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Gráfica de Ingresos Mensuales -->
                    <div class="col-md-6">
                        <div class="card card-primary mb-4">
                            <div class="card-header">
                                <div class="card-title">Ingreso Mensual - Gráfica</div>
                            </div>
                            <div class="card-body">
                                <canvas id="monthlyIncomeChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección Top Productos -->
                <div class="card card-primary mt-4">
                    <div class="card-header">
                        <div class="card-title">Top Productos</div>
                        <div class="row mb-2 d-flex justify-content-center">
                            <div class="col-md-5 mb-2">
                                <button id="btn-rpt-top-mas-vendido" class="btn btn-block btn-success">
                                    <i class="fa fa-file-alt fa-1x"></i>&nbsp;&nbsp;Top 10 de Productos más vendidos
                                </button>
                            </div>
                            <div class="col-md-5 mb-2">
                                <button id="btn-rpt-top-menos-vendido" class="btn btn-block btn-danger">
                                    <i class="fa fa-file-alt fa-1x"></i>&nbsp;&nbsp;Top 10 de Productos menos vendidos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        async function cargarGraficaIngresosMensuales() {
            try {
                const response = await fetch('/admin/ventas/showMonthlyIncomeChart');

                if (!response.ok) {
                    throw new Error('Error al obtener los datos de la gráfica');
                }

                const data = await response.json();

                if (Array.isArray(data.labels) && Array.isArray(data.values)) {
                    const ctx = document.getElementById('monthlyIncomeChart').getContext('2d');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Ingresos Mensuales (MXN)',
                                data: data.values,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.3
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let value = context.raw || 0;
                                            return `Ingresos: $${value.toLocaleString()}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Ingresos (MXN)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Mes'
                                    }
                                }
                            }
                        }
                    });
                } else {
                    console.error('Datos no válidos para la gráfica:', data);
                }
            } catch (error) {
                console.error('Error al cargar la gráfica de ingresos mensuales:', error);
            }
        }

        cargarGraficaIngresosMensuales();


        async function fetchTopSellingDishes() {
            const response = await fetch('/admin/ventas/showTopSellingDishesChart');
            const data = await response.json();
            return data;
        }

        async function generateTopSellingChart() {
            const data = await fetchTopSellingDishes();
            const nombresPlatillos = data.map(item => item.NombrePlatillo);
            const cantidadesVendidas = data.map(item => item.TotalVendidos);

            const ctx = document.getElementById('topSellingChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: nombresPlatillos,
                    datasets: [{
                        label: 'Cantidad Vendida',
                        data: cantidadesVendidas,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });
        }

        generateTopSellingChart();

        document.getElementById('btn-rpt-top-mas-vendido').addEventListener('click', function() {
            window.open('/admin/ventas/generarTopPlatillosPdf', '_blank');
        });

        document.getElementById('btn-rpt-top-menos-vendido').addEventListener('click', function() {
            window.open('/admin/ventas/generarTopPlatillosMenosVendidosPdf', '_blank');
        });
    </script>