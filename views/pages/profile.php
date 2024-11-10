<?php
$sessionController = new \Controllers\SessionController();
$sessionController->startSession(); // Asegúrate de que la sesión esté iniciada
$user = $sessionController->getUser();
?>
<!-- PAGINA DE PERFIL PARA LOS USUARIOS -->

<div class="mt-5 container mb-3">
    <div class="row">
        <div class="col-12">
            <h3 class="fw-bold text-center">¡Bienvenido a tu perfil!</h3>

            <!-- INFORMACION DEL USUARIO -->
            <div class="col-12 col-md-6  col-lg-12">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="">
                        <?php if ($user): ?>
                            <h5 class=" fw-bold">Información personal</h5>
                            <p>Nombre: <?php echo htmlspecialchars($user['Nombre']); ?></p>
                            <p>Correo: <?php echo $user['Correo']; ?></p>
                            <!-- MOSTRAR HISTORIAL -->
                            
                        <?php else: ?>
                            <h5 class="card-title fw-bold">Aqui podras ver tus datos</h5>
                            <!-- MOSTRAR HISTORIAL -->
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- BOTON DE CERRAR SESION -->
            <div class="col-12 col-md-6 col-lg-12 mb-3">
                <a href="../auth/logout" class="btn btn-danger d-block w-100 mt-4">Cerrar sesion</a>
            </div>
        </div>
    </div>
</div>