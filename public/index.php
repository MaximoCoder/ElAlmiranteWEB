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
$router->get('/api/platillos', [MenuController::class, 'getProducts']);
// PLATILLO PAGE
$router->get('/pages/platillo-{IdPlatillo}', function($router, $params) {
    $IdPlatillo = $params[0];  // Captura el valor del parámetro 'IdPlatillo'
    // Obtener los datos del platillo utilizando el controlador
    $data = PagesController::platilloData($IdPlatillo);
    // Llamar a la función del controlador para renderizar la vista
    PagesController::platillo($router, $data);
});
// JOBCONTROLLER
$router->get('/pages/jobVacancy', [JobController::class, 'index']);
// CARTCONTROLLER
$router->get('/pages/cart', [CartController::class, 'index']);
// USERCONTROLLER
$router->get('/auth/register', function($router) {
    UserController::renderAuthView($router, 'register');
});
$router->post('/auth/register', [UserController::class, 'apiRegister']); // NUEVA RUTA PARA API REST

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
    //Obtenemos los datos de las categorías
    $categorias = ProductController::getCategories();
    // Renderizamos y pasamos las categorías
    AdminController::renderAdminView($router, 'Agregar_Productos', 'layoutAdmin', [
        'categorias' => $categorias
    ]);
});
// Control para agregar productos
$router->post('/admin/Agregar_Productos' ,[ProductController::class, 'addProduct']);
 
// Control Categorias
$router->get('/admin/Categorias', function($router) {
    //Obtenemos los datos de las categorías
    $categorias = CategoriasController::getCategories();
    // Renderizamos y pasamos las categorías
    AdminController::renderAdminView($router, 'Categorias', 'layoutAdmin', [
        'categorias' => $categorias
    ]);
});

// Control Agregar Categorias

// Agregar Categoría
$router->post('/categorias/agregar', [Controllers\CategoriasController::class, 'agregarCategoria']);
$router->post('/categorias/editar',  [CategoriasController::class, 'editarCategoria']);
$router->delete('/admin/categorias/eliminar', [CategoriasController::class, 'eliminarCategoria']); 


// Control Editar Productos
$router->get('/admin/Editar_Productos', function($router) {
    EditarProductosController::renderAdminView($router, 'Editar_Productos');
});

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
