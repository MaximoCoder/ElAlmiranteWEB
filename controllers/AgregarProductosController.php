<?php
// controllers/AgregarProductosController.php

namespace Controllers;

use MVC\Router;
use PDO;

class AgregarProductosController {
    public static function renderAdminView(Router $router, $viewName)
    {
        $sessionController = new \Controllers\SessionController();
        $sessionController->startSession(); 
        $user = $sessionController->getUser();

        if ($user === null) {
            echo "Usuario no identificado";
            return;
        }

        $db = connectDB();
        $stmt = $db->prepare("SELECT IdCategoría, NombreCategoría FROM categoria");
        $stmt->execute();
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $router->render('admin/' . $viewName, [
            'user' => $user,
            'categorias' => $categorias
        ], 'layoutAdmin');
    }
}
