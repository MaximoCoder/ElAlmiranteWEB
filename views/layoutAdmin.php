<!DOCTYPE html>
<html lang="en">

<head>
  <title>Modulo Administrador</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/stylesAdmin.css">
  <link rel="stylesheet" href="../css/error.css">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <!-- SWEET ALERT -->
  <script src="../js/sweetalert2.all.min.js"></script>
</head>

<body>
  <!-- MENU LATERAL -->
  <!-- SIDEBAR -->
  <section id="sidebar">
    <a href="../admin/dashboard" class="brand mt-3">
      <i class='bx bxs-customize'></i>
      <span class="text">Mariscos El Almirante</span>
    </a>
    <ul class="side-menu top">
      <li>
        <a href="../admin/dashboard">
          <i class='bx bxs-dashboard'></i>
          <span class="text">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="../admin/Agregar_Productos">
          <i class='bx bx-store'></i>
          <span class="text">Agregar Productos</span>
        </a>
      </li>
      <li>
        <a href="../admin/Categorias">
          <i class='bx bxs-dish'></i>
          <span class="text">Categorias</span>
        </a>
      </li>
      <li>
        <a href="../admin/Editar_Productos">
          <i class='bx bxs-food-menu'></i>
          <span class="text">Editar Productos</span>
        </a>
      </li>
      <li>
        <a href="../admin/Ventas">
          <i class='bx bxs-receipt'></i>
          <span class="text">Ventas</span>
        </a>
      </li>
      <li>
        <a href="../admin/Pedidos">
          <i class='bx bx-restaurant'></i>
          <span class="text">Pedidos</span>
        </a>
      </li>
      <li>
        <a href="../admin/Agregar_Vacante">
          <i class='bx bxs-briefcase'></i>
          <span class="text">Agregar vacante</span>
        </a>
      </li>
      <li>
        <a href="../admin/Gestion_Usuarios">
          <i class='bx bxs-group'></i>
          <span class="text">Gestion de Usuarios</span>
        </a>
      </li>
      <li>
        <a href="../admin/Reportes">
          <i class='bx bxs-pie-chart-alt-2'></i>
          <span class="text">Reportes</span>
        </a>
      </li>
      <li>
        <a href="../">
          <i class='bx bx-show'></i>
          <span class="text">Ver sitio</span>
        </a>
      </li>
    </ul>
    <ul class="side-menu">
      <li>
        <a href="../auth/logout" class="logout">
          <i class='bx bxs-log-out-circle'></i>
          <span class="text">Logout</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- SIDEBAR -->

  <!-- Contenedor para centrar el contenido -->
  <section id="content">
    <?php echo $contenido; ?>
  </section>

  <script src="../js/jquery-3.6.0.min.js"></script>
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script src="../js/mainAdmin.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <script src="../js/scriptdash.js"></script>

</body>

</html>