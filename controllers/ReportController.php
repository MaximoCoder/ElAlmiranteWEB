<?php
// controllers/DashboardController.php
namespace Controllers; // WACHA A ESTE NUNCA LE MODIFIQUES, SIEMPRE TIENE QUE IR, MERO ARRIBA DE TODO
// llamamos al modelo
use Model\ReportModel;
class ReportController
{
    // 1. Ventas por categoría
    public static function getSalesByCategory()
    {
        // Instanciamos el modelo
        $model = new ReportModel();
        return $model->getSalesByCategory();
    }
    // 2. Ventas por día
    public static function getDailySales()
    {
        // Instanciamos el modelo
        $model = new ReportModel();
        return $model->getDailySales();
    }
    // 3. Platillos más vendidos
    public static function getTopSellingDishes($limit = 10)
    {
        // Instanciamos el modelo
        $model = new ReportModel();
        return $model->getTopSellingDishes();
    }
    // 4. Órdenes pendientes por cliente
    public static function getPendingOrdersByClient()
    {
        // Instanciamos el modelo
        $model = new ReportModel();
        return $model->getPendingOrdersByClient();
    }

    // 5. Ingresos por mes
    public static function getMonthlyIncome()
    {
        // Instanciamos el modelo
        $model = new ReportModel();
        return $model->getMonthlyIncome();
    }

    // 6. Categorías con más pedidos
    public static function getTopOrderedCategories()
    {
        // Instanciamos el modelo
        $model = new ReportModel();
        return $model->getTopOrderedCategories();
    }
}
