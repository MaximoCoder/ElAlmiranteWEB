<?php
// controllers/GestionUsuariosController.php

namespace Controllers;

use MVC\Router;

class GestionUsuariosController {
    // Método para renderizar vistas de administración
    public static function renderAdminView(Router $router, $viewName)
    {
        $sessionController = new \Controllers\SessionController();
        $sessionController->startSession(); 
        $user = $sessionController->getUser();
    
        if ($user === null) {
            // Manejar el caso cuando no hay usuario
            echo "Usuario no identificado";
            return;
        }
    
        $router->render('admin/' . $viewName, ['user' => $user], 'layoutAdmin');
    }
}