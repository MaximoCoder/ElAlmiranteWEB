<!-- NAVBAR -->
<nav>
    <i class='bx bx-menu'></i>
    <a href="#" class="nav-link">Categories</a>
    <form action="#">
        <div class="form-input">
            <input type="search" placeholder="Search...">
            <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
        </div>
    </form>
    <input type="checkbox" id="switch-mode" hidden>
    <label for="switch-mode" class="switch-mode"></label>

</nav>
<!-- NAVBAR -->

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
                        <div class="col-md-8">
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
                        <div class="col-md-4 d-flex align-items-center justify-content-end">
                            <button id="btn-rpt-unidades-vendidas-cliente" class="btn btn-block btn-success">
                                <i class="fa fa-file-alt fa-1x"></i>&nbsp;&nbsp;Ver reporte
                            </button>
                        </div>
                    </div>
                </div>

                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-title">Top Productos</div>
                    </div>
                    <div class="card-body">
                        <h5>
                            <div class="row mb-2 text-center">
                                <label>Haga clic sobre uno de los siguientes botones para obtener un reporte en PDF</label>
                            </div>
                        </h5>
                        <div class="row mb-2 d-flex justify-content-center">
                            <div class="col-md-5 mb-2">
                                <button id="btn-rpt-top-mas-vendido" class="btn btn-block btn-success">
                                    <i class="fa fa-file-alt fa-1x"></i>&nbsp;&nbsp;Top 20 de Productos más vendidos
                                </button>
                            </div>
                            <div class="col-md-5 mb-2">
                                <button id="btn-rpt-top-menos-vendido" class="btn btn-block btn-danger">
                                    <i class="fa fa-file-alt fa-1x"></i>&nbsp;&nbsp;Top 20 de Productos menos vendidos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dentro de la vista admin/Ventas.php -->
<script>
document.getElementById('btn-rpt-unidades-vendidas-cliente').addEventListener('click', function () {
    const platilloId = document.getElementById('IdPlatillo').value;
    if (platilloId) {
        window.open(`/admin/VentaController/generarDetalleVentaPdf?platilloId=${platilloId}`, '_blank');
    } else {
        alert('Por favor, selecciona un platillo.');
    }
});
document.getElementById('btn-rpt-top-mas-vendido').addEventListener('click', function() {
    window.open('/admin/ventas/generarTopPlatillosPdf', '_blank');
});


document.getElementById('btn-rpt-top-menos-vendido').addEventListener('click', function() {
    window.open('/admin/ventas/generarTopPlatillosMenosVendidosPdf', '_blank');
});

</script>

