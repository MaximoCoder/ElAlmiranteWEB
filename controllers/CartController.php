<?php
// controllers/CartController.php
namespace Controllers;
use MVC\Router;
class CartController
{
    public static function index(Router $router)
    {
        $router->render('pages/cart',[

        ]);
    }

}
