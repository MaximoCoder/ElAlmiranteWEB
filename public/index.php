<?php
// autoload
require_once __DIR__ . '/../vendor/autoload.php';
// app
require_once __DIR__ . '/../includes/app.php';
// router
use MVC\Router;
// controllers
use Controllers\HomeController;
use Controllers\PagesController;
use Controllers\MenuController;
use Controllers\JobController;
use Controllers\CartController;
use Controllers\UserController;
use Controllers\AdminController;
use Controllers\CategoriasController;
use Controllers\AgregarProductosController;
use Controllers\EditarProductosController;
use Controllers\VentasController;
use Controllers\PedidosController;
use Controllers\ConfiguracionAdminController;

$router = new Router();

/*                 DEFINIR RUTAS                  */
$userController = new UserController(); // Aquí se ejecuta el constructor 
// HOMECONTROLLER
$router->get('/', [HomeController::class, 'index']);
// PAGESCONTROLLER
$router->get('/pages/location', [PagesController::class, 'location']);
$router->get('/pages/contact', [PagesController::class, 'contact']);
// MENUCONTROLLER
$router->get('/pages/menu', [MenuController::class, 'index']);
// JOBCONTROLLER
$router->get('/pages/jobVacancy', [JobController::class, 'index']);
// CARTCONTROLLER
$router->get('/pages/cart', [CartController::class, 'index']);
// USERCONTROLLER
$router->get('/auth/register', function($router) {
    UserController::renderAuthView($router, 'register');
});
$router->post('/auth/register', [UserController::class, 'apiRegister']); // NUEVA RUTA PARA API REST
//$router->post('/auth/register', [UserController::class, 'register']); // Routes Register

$router->get('/auth/login', function($router) {
    UserController::renderAuthView($router, 'login');
});
$router->post('/auth/login', [UserController::class, 'apiLogin']); // Routes Login

$router->get('/auth/logout', [UserController::class, 'logout']); // Routes Logout

$router->get('/auth/forgot-Password', function($router) {
    UserController::renderAuthView($router, 'forgot-Password');
});
$router->post('/auth/forgot-Password', [UserController::class, 'sendMailCode']); // Routes Forgot Password


$router->get('/auth/verify-Code', function($router) {
    UserController::renderAuthView($router, 'verify-Code');
});
$router->post('/auth/verify-Code', [UserController::class, 'verifyCode']); // Routes Verify Code

$router->get('/auth/change-Password', function($router) {
    UserController::renderAuthView($router, 'change-Password');
});
$router->post('/auth/change-Password', [UserController::class, 'changePassword']); // Routes Change Password

/*USAR LAYOUT ADMINISTRATIVO*/
$router->get('/admin/dashboard', function(Router $router) {
    $adminController = new \Controllers\AdminController();
    return $adminController->dashboard();
});

// ---------------- Controles de Administrador ----------------
// Control Dashboard
$router->get('/admin/dashboard', [\Controllers\AdminController::class, 'dashboard']);
// Control Categorias
$router->get('/admin/Categorias', function($router) {
    Controllers\CategoriasController::renderAdminView($router, 'Categorias');
});


// Control Agregar Categorias
$router->get('/admin/categorias', [Controllers\CategoriasController::class, 'listarCategorias']);

// Agregar Categoría
$router->post('/categorias/agregar', [Controllers\CategoriasController::class, 'agregarCategoria']);
$router->post('/categorias/editar',  [CategoriasController::class, 'editarCategoria']);
$router->delete('/admin/categorias/eliminar', [CategoriasController::class, 'eliminarCategoria']); 

// Control Productos
$router->get('/admin/Agregar_Productos', function($router) {
    AgregarProductosController::renderAdminView($router, 'Agregar_Productos');
});
// Control para agregar productos
$router->post('/productos/agregar', function() {
    // ESTO NO VA AQUI.
    $nombrePlatillo = $_POST['nombrePlatillo'];
    $descripcionPlatillo = $_POST['descripcionPlatillo'];
    $precioPlatillo = $_POST['precioPlatillo'];
    $disponibilidad = $_POST['disponibilidad'];
    $categoriaId = $_POST['categoria'];

    if (isset($_FILES['imagenProducto']) && $_FILES['imagenProducto']['error'] === UPLOAD_ERR_OK) {
        $nombreImagen = $_FILES['imagenProducto']['name'];  
        $rutaTemporal = $_FILES['imagenProducto']['tmp_name'];

        $carpetaDestino = __DIR__ . '../Uploads/';  

        if (!is_dir($carpetaDestino)) {
            mkdir($carpetaDestino, 0755, true);
        }

        $rutaDestino = $carpetaDestino . $nombreImagen;

        if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
            $imgNombre = $nombreImagen;
        } else {
            echo "Error al subir la imagen";
            exit;
        }
    } else {
        $imgNombre = null; 
    }

    try {
        $db = connectDB();
        $stmt = $db->prepare("INSERT INTO platillo (NombrePlatillo, DescripciónPlatillo, PrecioPlatillo, Disponibilidad, IdCategoría, img) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombrePlatillo, $descripcionPlatillo, $precioPlatillo, $disponibilidad, $categoriaId, $imgNombre]);

        header('Location: /admin/Agregar_Productos?success=1');
        exit;
    } catch (PDOException $e) {
        echo "Error al agregar el producto: " . $e->getMessage();
    }
});


// Control Editar Productos
$router->get('/admin/Editar_Productos', function($router) {
    EditarProductosController::renderAdminView($router, 'Editar_Productos');
});

// Control Ventas
$router->get('/admin/Ventas', function($router) {
    VentasController::renderAdminView($router, 'Ventas');
});
// Control Reportes
$router->get('/admin/Reportes', function($router) {
    ReportesController::renderAdminView($router, 'Reportes');
});
// Control Gestion de Usuarios
$router->get('/admin/Gestion_Usuarios', function($router) {
    GestionUsuariosController::renderAdminView($router, 'Gestion_Usuarios');
});
// Control Pedidos
$router->get('/admin/Pedidos', function($router) {
    PedidosController::renderAdminView($router, 'Pedidos');
});
// Control Configuracion de Pagina
$router->get('/admin/Config', function($router) {
    ConfiguracionAdminController::renderAdminView($router, 'Config');
});

// Manejar la solicitud
$router->checkRoutes();
