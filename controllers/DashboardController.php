<?php
// controllers/DashboardController.php
namespace Controllers; // WACHA A ESTE NUNCA LE MODIFIQUES, SIEMPRE TIENE QUE IR, MERO ARRIBA DE TODO
// llamamos al modelo
use Model\DashboardModel;
class DashboardController {
    // Obtener las ordenes
    public static function getOrders(){
        // Instanciamos el modelo
        $model = new DashboardModel();
        return $model->getOrders();
    }
    // Obtener el total de ordenes de hoy
    public static function getTodayOrders(){
        // Instanciamos el modelo
        $model = new DashboardModel();
        return $model->getTodayOrders();
    }
    // Obtener los visitantes
    public static function getVisitors(){
        // Instanciamos el modelo
        $model = new DashboardModel();
        return $model->getVisitors();
    }
    // Obtener el total de ventas
    public static function getTotalSales(){
        // Instanciamos el modelo
        $model = new DashboardModel();
        return $model->getTotalSales();
    }
}
