<?php
// controllers/MenuController.php
namespace Controllers;

use MVC\Router;
use Model\MenuModel;


class MenuController
{
    public static function index(Router $router)
    {
        // Instanciar el modelo de menú
        $menuModel = new MenuModel();
        $categories = $menuModel->getCategories();
        $products = $menuModel->getAllProducts();

        // Renderizar la vista del menú con categorías y productos
        $router->render('pages/menu', [
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public static function getProducts()
    {
        // Obtener el parámetro de categoría desde la solicitud GET
        $category = isset($_GET['IdCategoria']) ? $_GET['IdCategoria'] : 'all';
        $menuModel = new MenuModel();

        // Verifica si el parámetro es 'all', de lo contrario busca por ID de categoría
        if ($category === 'all') {
            $products = $menuModel->getAllProducts();
        } else {
            // Aquí se espera que el parámetro 'category' sea el ID de la categoría
            $products = $menuModel->getProductsByCategory($category);
        }

        // Devolver los productos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($products);
    }
}
