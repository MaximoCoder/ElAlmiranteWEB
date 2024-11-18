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

    // 6. Categorías con más pedidos
    public static function getTopOrderedCategories()
    {
        // Instanciamos el modelo
        $model = new ReportModel();
        return $model->getTopOrderedCategories();
    }
}