<div class="container">
    <div class="row">
        <div class="col-12 mt-3 intro-text">
            <div class="d-flex align-items-center">
                <h1 class="me-4">Bolsa de trabajo</h1>
                <i class="bi bi-search" style="font-size: 30px;"></i>
            </div>
            <p>En Mariscos "El Almirante" buscamos personas entusiastas que quieran formar parte de la tripulación. Te invitamos a postularte y formar parte de nuestro equipo.</p>
            
        </div>
    </div>
</div>

<div class="container mt-4 mb-5">
    <div class="row d-flex justify-content-center">
        <!-- VALIDAR SI HAY VACANTES PARA MOSTRAR -->
        <?php if (empty($vacantes)): ?>
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Lo sentimos, por el momento no tenemos vacantes.</h4>
                    <p>Estamos trabajando para incorporar nuevas vacantes.</p>
                </div>
            </div>
        <?php else: ?>
            <!-- For each para iterar por cada registro -->
            <?php foreach ($vacantes as $vacante): ?>
                <div class="col-12 col-md-6 col-lg-4 mb-4 w-75">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-4">
                            <h5 class="card-title text-danger"><?= htmlspecialchars($vacante['nombreVacante']); ?></h5>
                            <p class="card-text text-muted preformatted">Requisitos y beneficios:
                                <br><?= htmlspecialchars($vacante['descripcionVacante']); ?>
                            </p>
                            <a href="../pages/formVacante" class="btn btn-dark mt-2">Postularme ahora</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- AQUI VAMOS A LLAMAR A LOS DATOS.-->