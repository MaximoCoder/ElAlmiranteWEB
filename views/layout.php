<?php
// Obtener el usuario actual
$sessionController = new \Controllers\SessionController();
$sessionController->startSession(); // Asegúrate de que la sesión esté iniciada
$user = $sessionController->getUser();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project</title>
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- SWEET ALERT -->
    <script src="../js/sweetalert2.all.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="../">
                <img class="img-fluid w-25 h-25" src="../images/almiranteNOBG.png" alt="LOGO">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav text-uppercase font-weight-bold">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/menu">Menú</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/location">Ubicación</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/contact">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/jobVacancy">Bolsa de trabajo</a>
                    </li>
                    <?php if ($user): ?>
                        <li class="nav-item">
                            <a class="nav-link"><i class="bi bi-person-circle heading"><?php echo htmlspecialchars($user['Nombre'] ?? 'Usuario'); ?></i></a>
                        </li>
                        <!-- Comprobar si el usuario es admin -->
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/">Panel Admin</a> <!-- Enlace al inicio de admin -->
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../auth/logout"><i class="bi bi-box-arrow-right"></i></a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../auth/register"><i class="bi bi-person-circle heading">Perfil</i></a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/cart"><i class="bi bi-cart heading"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Loader -->
    <div class="loader-container">
        <div class="loader"></div>
    </div>

    <div>
        <?php echo $contenido; ?>
    </div> <!-- End of container -->

    <footer class=" text-center text-lg-start  text-muted mt-4">
        <!-- Section: Social media -->
        <section
            class="d-flex justify-content-between p-4"
            style="background-color: #A91D3A">
            <!-- Left -->
            <div class="me-5 text-white">
                <span>Siguenos en nuestras redes sociales:</span>
            </div>
            <!-- Left -->

            <!-- Right -->
            <div>
                <a href="https://www.facebook.com/profile.php?id=100049553063567" target="_blank" class="text-white text-decoration-none me-4">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="https://www.instagram.com/mariscosalmirante?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="text-white text-decoration-none me-4" target="_blank">
                    <i class="bi bi-instagram"></i>
                </a>
            </div>
            <!-- Right -->
        </section>
        <!-- Section: Social media -->

        <!-- Section: Links  -->
        <section class="text-white">
            <div class="container text-center text-md-start mt-5">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold">Mariscos El Almirante</h6>
                        <hr
                            class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p>
                            ¡Gracias por visitar nuestra página! Te invitamos a descubrir nuestro delicioso menú y probar la mejor comida que ofrecemos. ¡Esperamos verte pronto en Mariscos el Almirante!.
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold">Menu</h6>
                        <hr
                            class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p>
                            <a href="../pages/menu" class="text-white">Menu</a>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold">Links utiles</h6>
                        <hr
                            class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p>
                            <a href="../auth/login" class="text-white">Tu cuenta</a>
                        </p>
                        <p>
                            <a href="../pages/jobVacancy" class="text-white">Unete a nuestro equipo</a>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold">Contacto</h6>
                        <hr
                            class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p><i class="fas fa-home mr-3"></i>Mariscos El almirante, 66670 Valle de Santa María, N.L.</p>
                        <p><i class="fas fa-envelope mr-3"></i>mariscosAlmirante@gmail.com</p>
                        <p><i class="fas fa-phone mr-3"></i> +52 81 8277 7311</p>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div
            class="text-center p-3 text-white"
            style="background-color: rgba(0, 0, 0, 0.2)">
            © 2024 Copyright:
            <a class="text-white" href="https://www.facebook.com/profile.php?id=100049553063567" target="_blank">Mariscos El Almirante</a>
        </div>
        <!-- Copyright -->
    </footer>

    <!-- MAIN JS -->
    <script src="../js/main.js"></script>
    <!-- Bootstrap JS -->
    <script src="../js/bootstrap.bundle.min.js"></script>

    <!-- JQUERY -->
    <script src="../js/jquery-3.6.0.min.js"></script>

</body>

</html>