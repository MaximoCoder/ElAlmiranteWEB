<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <h1><i class="fas fa-utensils"></i>&nbsp;&nbsp;Listado de Platillos</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary mt-1">
                <div class="card-header">
                    Platillos
                </div>
                <div class="card-body">
                    <div>
                    </div>
                    <div class="btn-group mb-3" role="group">
                        <a href="../admin/Agregar_Productos" class="btn btn-success">Agregar Platillo</a>
                        <button type="button" class="btn btn-primary" id="btn-imprimir">Imprimir</button>
                    </div>


                    <div class="mb-3">
                        <input type="text" id="search-input" class="form-control" placeholder="Buscar platillos...">
                    </div>

                    <div class="table-responsive">
                        <table id="table-platillos" class="table table-bordered table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Disponibilidad</th>
                                    <th>Imagen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($platillos as $platillo): ?>
                                    <tr data-id="<?= $platillo['IdPlatillo']; ?>">
                                        <td><?= $platillo['IdPlatillo']; ?></td>
                                        <td class="nombre-platillo"><?= htmlspecialchars($platillo['NombrePlatillo']); ?></td>
                                        <td class="descripcion-platillo"><?= htmlspecialchars($platillo['DescripciónPlatillo']); ?></td>
                                        <td class="precio-platillo"><?= htmlspecialchars($platillo['PrecioPlatillo']); ?></td>
                                        <td class="disponibilidad-platillo"><?= $platillo['Disponibilidad'] ? 'Disponible' : 'No Disponible'; ?></td>
                                        <td>
                                            <img src="<?= htmlspecialchars($platillo['img']); ?>" alt="<?= htmlspecialchars($platillo['NombrePlatillo']); ?>" style="width: 50px; height: auto;">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <script src="path/to/bootstrap.bundle.min.js"></script>

            <script>
                $(document).ready(function() {
                    loadPlatillos();

                    function loadPlatillos() {
                        $.ajax({
                            url: '/admin/obtenerPlatillos',
                            method: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                var tbody = $('#table-platillos tbody');
                                tbody.empty(); 

                                if (data.length === 0) {
                                    tbody.append('<tr><td colspan="7">No hay platillos registrados</td></tr>');
                                } else {
                                    $.each(data, function(index, platillo) {
                                        tbody.append(`
                                            <tr>
                                                <td>${platillo.IdPlatillo}</td>
                                                <td>${platillo.NombrePlatillo}</td>
                                                <td>${platillo.DescripciónPlatillo}</td>
                                                <td>${platillo.PrecioPlatillo}</td>
                                                <td>${platillo.Disponibilidad ? 'Disponible' : 'No Disponible'}</td>
                                                <td><img src="${platillo.Imagen}" alt="${platillo.NombrePlatillo}" width="50" height="50"></td>
                                            </tr>
                                        `);
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error al cargar los platillos:', error);
                            }
                        });
                    }

                    $('#search-input').on('keyup', function() {
                        var searchTerm = $(this).val().toLowerCase();
                        $('#table-platillos tbody tr').filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(searchTerm) > -1);
                        });
                    });


                    $('#btn-imprimir').on('click', function() {
                        var printContents = document.getElementById('table-platillos').outerHTML;
                        var printWindow = window.open('', '', 'height=400,width=600');
                        printWindow.document.write('<html><head><title>Imprimir Platillos</title>');
                        printWindow.document.write('<link rel="stylesheet" href="path/to/bootstrap.min.css">'); // Agrega aquí tu CSS
                        printWindow.document.write('</head><body>');
                        printWindow.document.write(printContents);
                        printWindow.document.write('</body></html>');
                        printWindow.document.close();
                        printWindow.print();
                    });
                });
            </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
