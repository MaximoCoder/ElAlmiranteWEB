<?php
namespace Controllers;

use MVC\Router;

class AdminController
{
    // Renderiza las vistas de ADMIN
    public static function renderAdminView(Router $router, $viewName, $layout, $data = [])
    {
        // Renderizamos la vista pasando solo los datos que sean necesarios
        $router->render('admin/' . $viewName, $data, $layout); 
    }
    
}

