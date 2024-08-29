<?php

namespace Controllers;
use MVC\Router;

class PagesController{
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