<?php

namespace Controllers;
use MVC\Router;
use Model\MenuModel;
use Model\HistoryModel;
use Controllers\SessionController;

class PagesController{
    // PAGES CONTROLLER PARA PAGINAS ESTATICAS LOCATION, CONTACTO, THANK YOU
    public static function renderPagesView(Router $router, $viewName, $data = [])
    {
        // Renderizamos la vista pasando solo los datos que sean necesarios
        $router->render('pages/' . $viewName, $data); 
    }
    //PLATILLO PAGE
    public static function platillo(Router $router, $data)
    {
        $router->render('pages/platillo', [
            'platillo' => $data
        ]);
    }
    // PLATILLO OBTENER DATA
    public static function platilloData($IdPlatillo){
        $menuModel = new MenuModel();
        return $menuModel->getProductById($IdPlatillo);
    }
    // PROFILE PAGE
    public static function renderProfileView(Router $router, $viewName, $data = [])
    {
        $sessionController = new SessionController();
        $sessionController->startSession();
        $user = $sessionController->getUser();
        
        // Get order history if needed
        $orderHistory = [];
        if (isset($user['IdUsuario'])) {
            $orderHistory = self::profileHistory($user['IdUsuario']);
        }
        
        $router->render('pages/' . $viewName, [
            'user' => $user,
            'orderHistory' => $orderHistory
        ]);
    }
    // PROFILE OBTENER ORDENES
    public static function profileHistory($IdUser){
        $historyModel = new HistoryModel();
        return $historyModel->getHistory($IdUser);
    }
}