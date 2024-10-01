<!DOCTYPE html>
<html lang="en">

<head>
  <title>Modulo Administrador</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/style_menuLateral.css">
  <link rel="stylesheet" href="../css/bootstrap.min_.css">
  <link rel="stylesheet" href="../css/Style-Admin.css">
</head>

<body>
<nav class="navbar navbar-expand-lg FondoLateralHeader">
  <div class="custom-menu">
    <!-- Menú o contenido adicional aquí -->
  </div>

  <div class="container-fluid d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="/admin">
      <img class="img-fluid" src="../images/almiranteNOBG.png" alt="LOGO" style="width: 100px; height: 100px;">
    </a>

    <div class="flex-container">
      <h2 class="text-center text-white font-weight-bold" style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
        MODULO ADMINISTRADOR
      </h2>
    </div>

    <a href="../auth/logout" class="btn btn-danger ml-2" style="font-size: 0.9em;">Salir</a>
  </div>
</nav>

<div class="wrapper d-flex">
  <i class="fa fa-bars" aria-hidden="true" id="sidebarCollapse"></i>
  <nav id="sidebar">
    <div class="img bg-wrap text-center py-4" style="background-color: #000;">
      <div class="user-logo">
        <div class="img" style="background-image: url('../images/login.jpg'); background-size: cover; background-position: center; width: 100px; height: 100px;"></div>
        <h3 class="text-capitalize" style="margin-top: 2%; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
        <a class="nav-link text-white">
          <i class="bi bi-person-circle" style="font-size: 1.5em;">
            <?php if (isset($user) && isset($user['Nombre'])): ?>
              <?php echo htmlspecialchars($user['Nombre']); ?>
            <?php else: ?>
              Usuario no identificado
            <?php endif; ?>
    </i>      
  </a>
</h3>

      </div>
    </div>

    <ul class="list-unstyled components navbar-custom">
      <li><a href="../admin/Agregar_Productos"><span class="fa fa-plus mr-3"></span> Agregar Productos</a></li>
      <li><a href="../admin/Categorias"><span class="fa fa-tags mr-3"></span> Categorías</a></li>
      <li><a href="../admin/Editar_Productos"><span class="fa fa-edit mr-3"></span> Editar Productos</a></li>
      <li><a href="../admin/Ventas"><span class="fa fa-shopping-cart mr-3"></span> Ventas</a></li>
      <li><a href="../admin/Reportes"><span class="fa fa-bar-chart mr-3"></span> Reportes</a></li>
      <li><a href="../admin/Gestion_Usuarios"><span class="fa fa-users mr-3"></span> Gestión de Usuarios</a></li>
      <li><a href="../admin/Pedidos"><span class="fa fa-list-alt mr-3"></span> Pedidos</a></li>
      <li><a href="../admin/Config"><span class="fa fa-cog mr-3"></span> Configuración de Página</a></li>
      <div
            class="text-center p-3 text-white"
            style="background-color: rgba(0, 0, 0, 0.2)">
            © 2024 Copyright:
            <a class="text-white" href="https://www.facebook.com/profile.php?id=100049553063567" target="_blank">Mariscos El Almirante</a>
    </div>
    </ul>
    
  </nav>

  <div class="main-content">
    <!-- Contenedor para centrar el contenido -->
    <div class="centered-content">
      <?php echo $contenido; ?>
    </div>
  </div>
</div>

<script src="../js/jquery.min.js"></script>
<script src="../js/popper.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/mainAdmin.js"></script>
</body>

</html>

