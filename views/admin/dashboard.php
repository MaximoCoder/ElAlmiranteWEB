<!doctype html>
<html >

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min_.css">
    <link rel="stylesheet" href="../css/Style-Admin.css">
    <title>Panel de Administración</title>

</head>

<body>

    <!-- Contenedor de las tarjetas -->
    <div class="container">
        <!-- Tarjeta Agregar Productos -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-plus"></i> Agregar Productos
            </div>
            <div class="card-body">
                <p>Administra y agrega nuevos productos al catálogo.</p>
                <a href="../admin/Agregar_Productos" class="btn btn-custom">Agregar Producto</a>
            </div>
        </div>

        <!-- Tarjeta Categorías -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-tags"></i> Categorías
            </div>
            <div class="card-body">
                <p>Gestiona las categorías del catálogo de productos.</p>
                <a href="../admin/Categorias" class="btn btn-custom">Ver Categorías</a>
            </div>
        </div>

        <!-- Tarjeta Editar Productos -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-edit"></i> Editar Productos
            </div>
            <div class="card-body">
                <p>Modifica los detalles de los productos existentes.</p>
                <a href="../admin/Editar_Productos" class="btn btn-custom">Editar Productos</a>
            </div>
        </div>

        <!-- Tarjeta Ventas -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-shopping-cart"></i> Ventas
            </div>
            <div class="card-body">
                <p>Gestiona y visualiza las ventas realizadas.</p>
                <a href="../admin/Ventas" class="btn btn-custom">Ventas</a>
            </div>
        </div>

        <!-- Tarjeta Reportes -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-bar-chart"></i> Reportes
            </div>
            <div class="card-body">
                <p>Visualiza y descarga reportes de ventas y actividad.</p>
                <a href="../admin/Reportes" class="btn btn-custom">Ver Reportes</a>
            </div>
        </div>

        <!-- Tarjeta Gestión de Usuarios -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-users"></i> Gestión de Usuarios
            </div>
            <div class="card-body">
                <p>Administra los usuarios del sistema.</p>
                <a href="../admin/Gestion_Usuarios" class="btn btn-custom">Gestión de Usuarios</a>
            </div>
        </div>


    <script src="../js/mainAdmin.js"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    
</body>

</html>
