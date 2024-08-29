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

$router = new Router();
/*                 DEFINIR RUTAS                  */

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
$router->get('/auth/register', [UserController::class, 'indexRegister']);
$router->post('/auth/register', [UserController::class, 'register']);
$router->get('/auth/login', [UserController::class, 'indexLogin']);
$router->post('/auth/login', [UserController::class, 'login']);
$router->get('/auth/logout', [UserController::class, 'logout']);


// Manejar la solicitud
$router->checkRoutes();