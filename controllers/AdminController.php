<?php

namespace Controllers;

use MVC\Router;
use Controllers\SessionController;
class AdminController
{
    // Renderiza las vistas de ADMIN
    public static function renderAdminView(Router $router, $viewName, $layout, $data = [])
    {
        // Validar que el usuario es administrador
        SessionController::requireAdmin();
        // Renderizamos la vista pasando solo los datos que sean necesarios
        $router->render('admin/' . $viewName, $data, $layout);
    }

}
