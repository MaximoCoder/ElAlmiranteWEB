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
<!-- NAVBAR -->

<!-- CONTENT -->
<main>
    <div class="charts-container">
        <h2>Gráficos de Reportes</h2>

        <!-- Botón para generar PDF -->
        <div style="text-align: right; margin: 10px;">
            <button id="generatePDF" class="btn">Generar PDF</button>
        </div>

        <div class="grid-container">
            <div class="chart-item">
                <h3>Distribución de Ventas por Categoría</h3>
                <canvas id="salesByCategory"></canvas>
            </div>
            <div class="chart-item">
                <h3>Evolución de Ventas Diarias</h3>
                <canvas id="dailySales"></canvas>
            </div>
            <div class="chart-item">
                <h3>Categorías Más Ordenadas</h3>
                <canvas id="topOrderedCategories"></canvas>
            </div>
        </div>
    </div>
</main>


<!-- Importar Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Importar jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script>
    // Gráfico de Pastel: Ventas por Categoría
    const salesByCategory = document.getElementById('salesByCategory').getContext('2d');
    new Chart(salesByCategory, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_column($categoria, 'NombreCategoría')); ?>,
            datasets: [{
                data: <?php echo json_encode(array_column($categoria, 'TotalVendidos')); ?>,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            const total = <?php echo array_sum(array_column($categoria, 'TotalVendidos')); ?>;
                            const value = tooltipItem.raw;
                            const percentage = ((value / total) * 100).toFixed(2);
                            return `${tooltipItem.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Gráfico de Línea: Ventas Diarias
    const dailySales = document.getElementById('dailySales').getContext('2d');
    new Chart(dailySales, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($diarias, 'Fecha')); ?>,
            datasets: [{
                label: 'Total Ganancias',
                data: <?php echo json_encode(array_column($diarias, 'TotalGanancias')); ?>,
                borderColor: '#36A2EB',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: true,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
        }
    });


    // Gráfico de linea: Categorías Más Ordenadas
    const topOrderedCategories = document.getElementById('topOrderedCategories').getContext('2d');
    new Chart(topOrderedCategories, {
        type: 'line', // Cambiar a 'bar' o 'pie' si lo prefieres
        data: {
            labels: <?php echo json_encode(array_column($top, 'NombreCategoría')); ?>,
            datasets: [{
                label: 'Total Pedidos',
                data: <?php echo json_encode(array_column($top, 'TotalPedidos')); ?>,
                borderColor: '#FF6384',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            const total = <?php echo array_sum(array_column($top, 'TotalPedidos')); ?>;
                            const value = tooltipItem.raw;
                            const percentage = ((value / total) * 100).toFixed(2);
                            return `${tooltipItem.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Función para generar PDF
    document.getElementById('generatePDF').addEventListener('click', () => {
        const {
            jsPDF
        } = window.jspdf;
        const pdf = new jsPDF();

        // Título del PDF
        pdf.setFontSize(18);
        pdf.text('Reporte de Datos', 105, 10, {
            align: 'center'
        });

        let yOffset = 20; // Margen superior inicial

        // Función para agregar una tabla al PDF
        function addTableToPDF(title, headers, data) {
            pdf.setFontSize(14);
            pdf.text(title, 10, yOffset);
            yOffset += 5;

            // Calcular el ancho de las columnas
            const columnWidths = headers.map(() => 190 / headers.length);

            // Agregar cabeceras
            pdf.setFontSize(12);
            pdf.setTextColor(255, 255, 255); // Texto blanco
            pdf.setFillColor(0, 112, 192); // Fondo azul
            headers.forEach((header, index) => {
                pdf.rect(10 + index * columnWidths[index], yOffset, columnWidths[index], 7, 'F');
                pdf.text(header, 12 + index * columnWidths[index], yOffset + 5);
            });

            yOffset += 8;

            // Agregar datos
            pdf.setFontSize(10);
            pdf.setTextColor(0, 0, 0); // Texto negro
            data.forEach(row => {
                headers.forEach((_, colIndex) => {
                    pdf.text(row[colIndex].toString(), 12 + colIndex * columnWidths[colIndex], yOffset);
                });
                yOffset += 7;

                // Crear nueva página si el espacio se acaba
                if (yOffset + 10 > pdf.internal.pageSize.height) {
                    pdf.addPage();
                    yOffset = 10;
                }
            });

            yOffset += 10; // Espacio entre tablas
        }

        // Datos para la tabla: Categorías Más Ordenadas
        const topOrderedCategoriesData = <?php echo json_encode($top); ?>;
        if (topOrderedCategoriesData.length > 0) {
            addTableToPDF(
                'Categorías Más Ordenadas',
                ['Categoría', 'Total Pedidos'],
                topOrderedCategoriesData.map(row => [row.NombreCategoría, row.TotalPedidos])
            );
        }

        // Datos para la tabla: Ventas por Categoría
        const salesByCategoryData = <?php echo json_encode($categoria); ?>;
        if (salesByCategoryData.length > 0) {
            addTableToPDF(
                'Ventas por Categoría',
                ['Categoría', 'Total Vendidos'],
                salesByCategoryData.map(row => [row.NombreCategoría, row.TotalVendidos])
            );
        }

        // Datos para la tabla: Ventas Diarias
        const dailySalesData = <?php echo json_encode($diarias); ?>;
        if (dailySalesData.length > 0) {
            addTableToPDF(
                'Ventas Diarias',
                ['Fecha', 'Total Ganancias'],
                dailySalesData.map(row => [row.Fecha, row.TotalGanancias])
            );
        }

        // Guardar PDF
        pdf.save('Reportes.pdf');
    });
</script>