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
use Controllers\TestController;
use Controllers\UserController;

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


//TEST
$router->get('/admin/dashboard', function($router) {
    TestController::renderAuthView($router, 'dashboard', 'layoutAdmin');
});

/* 
USAR LAYOUT ADMINISTRATIVO
$router->get('/admin/dashboard', function($router) {
    $router->render('admin/dashboard', [], 'layoutAdmin'); // Usa layoutAdmin para el dashboard
});
*/
// Manejar la solicitud
$router->checkRoutes();