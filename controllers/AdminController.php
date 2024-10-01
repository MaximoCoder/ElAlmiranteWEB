<?php
namespace Controllers;

use MVC\Router;

class AdminController
{
    public static function renderAuthView(Router $router, $viewName, $layout)
    {
        $error = ''; // Inicializar variable de error
        $router->render('admin/' . $viewName, [
            'error' => $error
        ], $layout); // Pasamos el layout
    }
    public function dashboard()
    {
        // Aquí podrías definir la lógica para mostrar la vista del dashboard
        echo "Bienvenido al Dashboard de Admin";
    }
}

