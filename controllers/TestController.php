<?php
// controllers/MenuController.php
namespace Controllers;
use MVC\Router;
class TestController
{
    public static function renderAuthView(Router $router, $viewName, $layout)
    {
        $error = ''; // Inicializar variable de errorModel
        $router->render('admin/' . $viewName, [
            'error' => $error
        ], $layout); // Pasamos el layout
    }
}
