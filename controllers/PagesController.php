<?php

namespace Controllers;
use MVC\Router;
use Model\MenuModel;

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
}