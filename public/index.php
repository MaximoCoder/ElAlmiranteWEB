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
// Controllers de Administración
use Controllers\AdminController;
use Controllers\CategoriasController;
use Controllers\ProductController;
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

// ---------------- Controles de Administrador ----------------
// Control RESUMEN
$router->get('/admin/dashboard', function($router) {
    AdminController::renderAdminView($router, 'dashboard', 'layoutAdmin');
});

// Controles de Productos
$router->get('/admin/Agregar_Productos', function($router) {
    $categorias = ProductController::getCategories();
    AdminController::renderAdminView($router, 'Agregar_Productos', 'layoutAdmin', [
        'categorias' => $categorias
    ]);
});

$router->post('/admin/Agregar_Productos', [Controllers\ProductController::class, 'addProduct']);
$router->get('/admin/Editar_Productos', [Controllers\ProductController::class, 'listarProductos']);

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

// Control Editar Productos
$router->get('/admin/Editar_Productos', function($router) use ($db) {
    try {
        $controller = new \Controllers\EditarProductosController($db);
        $productos = $controller->getPlatillos(); 
        $categorias = $controller->getCategories(); 
        
        $controller->renderAdminView($router, 'admin/Editar_Productos', 'layoutAdmin', [
            'platillos' => $productos,
            'categorias' => $categorias
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
});
// Rutas para obtener platillos
$router->get('/admin/obtenerPlatillos', [ProductController::class, 'obtenerPlatillos']);

$router->post('/admin/platillos/editar', [ProductController::class, 'editarPlatillo']);
$router->delete('/admin/platillos/eliminar', [ProductController::class, 'eliminarPlatillo']);


// Control Ventas
$router->get('/admin/Ventas', function($router) {
    VentasController::renderAdminView($router, 'Ventas');
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
