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
use Controllers\PaymentController;
use Controllers\UserController;
// Controllers de Administración
use Controllers\AdminController;
use Controllers\CategoriasController;
use Controllers\ProductController;
use Controllers\vacanteController;
use Controllers\EditarProductosController;
use Controllers\VentasController;
use Controllers\PedidosController;
use Controllers\ConfiguracionAdminController;
use Controllers\DashboardController;
use Controllers\ReportController;
use Controllers\VacanteController as ControllersVacanteController;


$router = new Router();
/* ---------------------------------------------
   Rutas Públicas (Clientes)
---------------------------------------------- */

$userController = new UserController(); // Aquí se ejecuta el constructor 
// HomeController
$router->get('/', [HomeController::class, 'index']); // Página de inicio

// PagesController
$router->get('/pages/location', function ($router) {
    PagesController::renderPagesView($router, 'location');
}); // Página de ubicaciones
$router->get('/pages/contact', function ($router) {
    PagesController::renderPagesView($router, 'contact');
});   // Página de contacto

// MenuController
$router->get('/pages/menu', [MenuController::class, 'index']);         // Página de menú
$router->get('/api/platillos', [MenuController::class, 'getProducts']); // API: obtener platillos

// CartController
$router->get('/pages/cart', [CartController::class, 'index']); // Página del carrito
$router->post('/agregar-al-carrito', [CartController::class, 'manageCart']);  // Agregar al carrito
$router->post('/reordenar', function () {
    $orderId = $_POST['order_id'] ?? null;
    CartController::getOrderById($orderId);
});
$router->post('/cart/delete-{id}', function ($router, $params) {
    $id = $params[0]; // Captura el ID del producto
    CartController::deleteProduct($router, $id); // Eliminar producto
});
$router->post('/cart/increase-{id}', function ($router, $params) {
    $id = $params[0]; // Captura el ID del producto
    CartController::increaseQuantity($router, $id); // Aumentar cantidad
});
$router->post('/cart/decrease-{id}', function ($router, $params) {
    $id = $params[0]; // Captura el ID del producto
    CartController::decreaseQuantity($router, $id); // Disminuir cantidad
});
$router->post('/encrypt-data', function () {
    echo CartController::encryptData();
}); // Encriptar datos del producto
// PAYMENTCONTROLLER
$router->get('/tickets/show-{venta_id}', function ($router, $params) {
    // iniciar sesion
    session_start();
    $ventaId = $params[0];
    PaymentController::showTicket($_SESSION['ticket_path'], $ventaId);
}); // Mostrar ticket generado

$router->post('/cart/pago-pendiente', [PaymentController::class, 'pagoPendiente']); // Pago pendiente
// Ruta para procesar el pago de PayPal en checkout
$router->post('/checkout/paypal', [PaymentController::class, 'checkout']);


// Página de platillo individual
$router->get('/pages/platillo-{IdPlatillo}', function ($router, $params) {
    $IdPlatillo = $params[0];  // Captura el ID del platillo
    $data = PagesController::platilloData($IdPlatillo); // Obtiene los datos del platillo
    PagesController::platillo($router, $data); // Renderiza la vista del platillo
});

// JobController
$router->get('/pages/jobVacancy', function ($router) {
    // llamamos a la funcion del controller para obtener los datos
    $data = JobController::getVacantes();
    // Renderizamos con pagesController
    PagesController::vacante($router, $data);
}); // Página de vacantes de trabajo

//Formulario de vacantes
$router->get('/pages/formVacante', function ($router) {
    $router->render('pages/formVacante');
});

// PROFILE PAGE
$router->get('/pages/profile', function ($router) {
    PagesController::renderProfileView($router, 'profile');
});

/* ---------------------------------------------
   Rutas de Autenticación (Usuarios)
---------------------------------------------- */

// Registro de usuarios
$router->get('/auth/register', function ($router) {
    UserController::renderAuthView($router, 'register'); // Formulario de registro
});
$router->post('/auth/register', [UserController::class, 'apiRegister']); // API: registrar usuario

// Inicio de sesión
$router->get('/auth/login', function ($router) {
    UserController::renderAuthView($router, 'login'); // Formulario de inicio de sesión
});
$router->post('/auth/login', [UserController::class, 'apiLogin']); // API: iniciar sesión

// Cierre de sesión
$router->get('/auth/logout', [UserController::class, 'logout']); // Cerrar sesión

// Recuperación de contraseña
$router->get('/auth/forgot-Password', function ($router) {
    UserController::renderAuthView($router, 'forgot-Password'); // Formulario de recuperación de contraseña
});
$router->post('/auth/forgot-Password', [UserController::class, 'sendMailCode']); // API: enviar código de recuperación

// Verificación de código de recuperación
$router->get('/auth/verify-Code', function ($router) {
    UserController::renderAuthView($router, 'verify-Code'); // Formulario de verificación de código
});
$router->post('/auth/verify-Code', [UserController::class, 'verifyCode']); // API: verificar código

// Cambio de contraseña
$router->get('/auth/change-Password', function ($router) {
    UserController::renderAuthView($router, 'change-Password'); // Formulario para cambiar contraseña
});
$router->post('/auth/change-Password', [UserController::class, 'changePassword']); // API: cambiar contraseña

// ---------------- Controles de Administrador ----------------
// Control RESUMEN
$router->get('/admin/dashboard', function ($router) {
    $ordenes = DashboardController::getOrders();
    $newOrdenes = DashboardController::getTodayOrders();
    $visitantesActivos = DashboardController::getVisitors();
    $Totalventas = DashboardController::getTotalSales();
    AdminController::renderAdminView($router, 'dashboard', 'layoutAdmin', [
        'ordenes' => $ordenes,
        'newOrdenes' => $newOrdenes,
        'visitantesActivos' => $visitantesActivos,
        'Totalventas' => $Totalventas
    ]);
});

// Control Agregar vacante
$router->get('/admin/Agregar_Vacante', function ($router) {
    // Obtenemos los datos de las vacantes
    $vacantes = VacanteController::getAllVacantes();
    AdminController::renderAdminView($router, 'Agregar_Vacante', 'layoutAdmin', [
        'vacantes' => $vacantes
    ]); // Formulario de registro
});

$router->post('/admin/Agregar_Vacante', [VacanteController::class, 'registroVacante']);
$router->put('/admin/Agregar_Vacante/editar', [VacanteController::class, 'editarVacante']);
$router->delete('/admin/Agregar_Vacante/eliminar', [VacanteController::class, 'eliminarVacante']);

// Control Pedidos
$router->get('/admin/Pedidos', function ($router) {
    PedidosController::renderAdminView($router, 'Pedidos');
});
// RUTA A REPORTES (BASATE EN LA RUTA DE DASHBOARD)
$router->get('/admin/Reportes', function ($router) {
    $categoria = ReportController::getSalesByCategory();
    $diarias = ReportController::getDailySales();
    $platillos = ReportController::getTopSellingDishes();
    $mensuales = ReportController::getMonthlyIncome();
    $top = ReportController::getTopOrderedCategories();
    AdminController::renderAdminView($router, 'Reportes', 'layoutAdmin', [
        'categoria' => $categoria,
        'diarias' => $diarias,
        'platillos' => $platillos,
        'mensuales' => $mensuales,
        'top' => $top
    ]);
});
// Control Configuracion de Pagina
$router->get('/admin/Config', function ($router) {
    ConfiguracionAdminController::renderAdminView($router, 'Config');
});

//Agregar Productos
$router->get('/admin/Agregar_Productos', function($router) {
    $categorias = ProductController::getCategories();
    AdminController::renderAdminView($router, 'Agregar_Productos', 'layoutAdmin', [
        'categorias' => $categorias
    ]);
});
$router->post('/admin/Agregar_Productos' ,[ProductController::class, 'addProduct']);

//Editar Productos
$router->post('/admin/platillos/editar', function() use ($db) {
    $controller = new EditarProductosController($db);
    $data = $_POST;
    $result = $controller->updatePlatillo($data);
    if ($result) {
        echo "Producto actualizado con éxito";
    } else {
        echo "Error al actualizar producto";
    }
});

$router->get('/admin/Editar_Productos', function($router) {
    AdminController::renderAdminView($router, 'Editar_Productos', 'layoutAdmin');
});
$router->get('/admin/obtenerPlatillos', [ProductController::class, 'obtenerPlatillos']);
$router->post('/admin/platillos/editar', [EditarProductosController::class, 'editarPlatillo']);
$router->delete('/admin/platillos/eliminar', [EditarProductosController::class, 'eliminarPlatillo']);
$router->get('/admin/Editar_Productos', [ProductController::class, 'listarProductos']);


//Categorias
$router->post('/admin/Categorias-add', [CategoriasController::class, 'agregarCategoria']);
$router->post('/categorias/editar',  [CategoriasController::class, 'editarCategoria']);
$router->delete('/admin/categorias/eliminar', [CategoriasController::class, 'eliminarCategoria']); 

$router->get('/admin/Categorias', function($router) {
    $categorias = CategoriasController::getCategories();
    AdminController::renderAdminView($router, 'Categorias', 'layoutAdmin', [
        'categorias' => $categorias
    ]);
});


//Gestion de Ventas
$router->get('/admin/Ventas', [VentasController::class, 'listarPlatillos']);

// Ruta para generar el reporte de ventas generales
$router->get('/admin/Ventas/reporte', function($router) {
    $controller = new VentasController();
    $controller->reporteVentas($router);
});

$router->get('/admin/VentaController/generarDetalleVentaPdf', function($router) {
    $platilloId = $_GET['platilloId'] ?? null;
    VentasController::generarDetalleVentaPdf(['platilloId' => $platilloId]);
});

$router->get('/admin/ventas/generarTopPlatillosPdf', function() {
    Controllers\VentasController::generarTopPlatillosPdf();
});

$router->get('/admin/ventas/generarTopPlatillosMenosVendidosPdf', function() {
    Controllers\VentasController::generarTopPlatillosMenosVendidosPdf();
});



// Manejar la solicitud
$router->checkRoutes();
