<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                    <h3 class="text-center text-black">Gestión de Ventas</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div style="max-width: 1140px;margin: 0 auto;">
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-title">Unidades Vendidas por Cliente</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                            <label for="platillo" class="form-label text-black">Selecciona un Platillo:</label>
                            <select class="form-control form-select border-0 input-color" name="IdPlatillo" id="IdPlatillo" required>
                                <?php if (!empty($platillos)) : ?>
                                    <?php foreach ($platillos as $platillo) : ?>
                                        <option value="<?= $platillo['IdPlatillo'] ?>"><?= $platillo['NombrePlatillo'] ?></option> <!-- Asegúrate de que 'NombrePlatillo' sea la clave correcta -->
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option disabled>No hay platillos disponibles</option>
                                <?php endif; ?>
                            </select>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Inicio</label>
                                    <input type="date" name="date_from" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Fin</label>
                                    <input type="date" name="date_to" class="form-control">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4" >
                                <button id="btn-rpt-unidades-vendidas-cliente" class="btn btn-block btn-success">
                                    <i class="fa fa-file-alt fa-1x"></i>&nbsp;&nbsp;Ver reporte
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-title">Top Productos</div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <label>Haga clic sobre uno de los siguientes botones para obtener un reporte en PDF</label>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3"></div>
                            <div class="col-md-6" >
                                <button id="btn-rpt-top-mas-vendido" class="btn btn-block btn-success">
                                    <i class="fa fa-file-alt fa-1x"></i>&nbsp;&nbsp;Top 20 de Productos más vendidos
                                </button>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <button id="btn-rpt-top-menos-vendido" class="btn btn-block btn-danger">
                                    <i class="fa fa-file-alt fa-1x"></i>&nbsp;&nbsp;Top 20 de Productos menos vendidos
                                </button>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
 
            </div>
        </div>
    </div>
</div>

<!-- Dentro de la vista admin/Ventas.php -->
<script>
$(document).on("click", "#btn-rpt-unidades-vendidas-cliente", function(){
    window.open("../../models/PdfModel");
});

    document.getElementById('btn-rpt-top-mas-vendido').addEventListener('click', function() {
        window.location.href = '/admin/Ventas/reporte?mode=1';
    });

    document.getElementById('btn-rpt-top-menos-vendido').addEventListener('click', function() {
        window.location.href = '/admin/Ventas/reporte?mode=2';
    });
</script>

