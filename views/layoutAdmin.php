<!DOCTYPE html>
<html lang="en">

<head>
  <title>Modulo Administrador</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/Sidebar.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/stylesAdmin.css">
  <link rel="stylesheet" href="../css/error.css">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">




  <!-- SWEET ALERT -->
  <script src="../js/sweetalert2.all.min.js"></script>
</head>

<body>

  <!-- MENU LATERAL -->
  

  <div class="wrapper">
    <aside id="sidebar">
      <div class="d-flex">
        <button id="toggle-btn" type="button">
          <i class="lni lni-grid-alt"></i>
        </button>
        <div class="sidebar-logo">
          <a href="#">Administrar</a>
        </div>
      </div>
      <ul class="sidebar-nav">
        <li class="sidebar-item">
          <a href="../admin/dashboard" class="sidebar-link">
            <i class="lni lni-bar-chart"></i>
            <span>Resumen</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-gallery"></i>
            <span>Agregar Productos</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-archive"></i>
            <span>Categorias</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-pencil-alt"></i>
            <span>Editar Productos</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-cart"></i>
            <span>Ventas</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-stats-up"></i>
            <span>Reportes</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-users"></i>
            <span>Gestion de Usuarios</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-delivery"></i>
            <span>Pedidos</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-cog"></i>
            <span>Configuración de Pagina</span>
          </a>
        </li>
      </ul>
      <div class="sidebar-footer">
        <a href="#" class="sidebar-link">
          <i class="lni lni-exit"></i>
          <span>Salir</span>
        </a>
      </div>
    </aside>
  </div>


  <!-- FIN MENU LATERAL-->
  <div class="main-content">
    <!-- Contenedor para centrar el contenido -->
    <div class="centered-content">
      <?php echo $contenido; ?>
    </div>
  </div>
  </div>

  <script src="../js/jquery-3.6.0.min.js"></script>
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script src="../js/mainAdmin.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
    <script src="../js/script.js"></script>


</body>

</html>