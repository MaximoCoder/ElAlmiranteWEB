<?php

namespace Controllers;
use MVC\Router;
use Model\MenuModel;

class PagesController{
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
    // UBICACION 
    public static function location(Router $router)
    {
        $router->render('pages/location',[

        ]);
    }
    // CONTACTO
    public static function contact(Router $router)
    {
        $router->render('pages/contact');
    }
}