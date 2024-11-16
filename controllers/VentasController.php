<?php
// controllers/VentasController.php

namespace Controllers;

use MVC\Router;
use Model\VentaModel;
use PDOException;
use TCPDF;


class VentasController {

    public static function renderAdminView(Router $router, $viewName)
    {
        $VentaModel = new VentaModel();
        $platillos = $VentaModel->getAllProducts();

        $router->render('admin/Ventas', [
            'platillos' => $platillos,
        ], 'layoutAdmin');
    }

    public static function getPlatillos()
    {
        $adminModel = new AdminModel();
        $platillos = $adminModel->getData('platillo');
    
        // Depuración: Verifica los datos
        var_dump($platillos); // Esto te permitirá ver si los datos están siendo recuperados correctamente
        return $platillos;
    }
    
    public static function listarPlatillos(Router $router)
    {
        $ventaModel = new VentaModel();
        $platillos = $ventaModel->getAllProducts();

        $router->render('admin/Ventas', [
            'platillos' => $platillos,
            
        ], 'layoutAdmin');
    }

    public static function getDetalleVenta(Router $router)
    {
        $ventaModel = new VentaModel();
        $platillos = $ventaModel->getAllDetalleVenta();

        $router->render('admin/Ventas', [
            'platillos' => $platillos,
            
        ], 'layoutAdmin');
    }


}
    
    
