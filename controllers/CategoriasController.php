<?php
// controllers/CategoriasController.php

namespace Controllers;

use MVC\Router;

use Model\ProductModel;
use PDOException;

class CategoriasController
{
    public static function renderAdminView(Router $router)
    {
        $ProductModel = new ProductModel();
        $categorias = $ProductModel->getAllCategories();

        // Renderiza la vista de categorías con los datos obtenidos
        $router->render('admin/categorias', [
            'categorias' => $categorias
        ], 'layoutAdmin');
    }

    
    public static function agregarCategoria(Router $router)
    {
        header('Content-Type: application/json');


use Model\AdminModel;

class CategoriasController {
    
    public static function getCategories()
    {
        $adminModel = new AdminModel();
        return $adminModel->getData('categoria');
    }
    /*
    public static function agregarCategoria(Router $router) {
        $error = null;
        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreCategoria = $_POST['nombreCategoria'] ?? '';
            if (empty($nombreCategoria)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El nombre de la categoría no puede estar vacío.'
                ]);
                return;
            }

            $ProductModel = new ProductModel();

            try {
                $ProductModel->insertCategory($nombreCategoria);
                echo json_encode([
                    'success' => true,
                    'message' => 'Categoría agregada correctamente'
                ]);
                header("Location: /admin/Categorias");
                    exit;
            } catch (PDOException $e) {
                echo json_encode([
                    'success' => false,
                    'message' => "Error al insertar la categoría: " . $e->getMessage()
                ]);
            }
        }
        $router->render('admin/Categorias', [
            'error' => $error
        ], 'layoutAdmin');
    
    }

    public static function eliminarCategoria()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $id = $_GET['id'] ?? '';

            if (empty($id)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El ID de la categoría no puede estar vacío.'
                ]);
                return;
            }

            $ProductModel = new ProductModel();

            try {
                $ProductModel->deleteCategory($id);
                echo json_encode([
                    'success' => true,
                    'message' => 'Categoría eliminada correctamente'
                ]);
            } catch (PDOException $e) {
                echo json_encode([
                    'success' => false,
                    'message' => "Error al eliminar la categoría: " . $e->getMessage()
                ]);
            }
        }
    }

    public static function editarCategoria()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['categoriaId'] ?? '';
            $nombreCategoria = $_POST['nombreCategoriaEditar'] ?? '';

            if (empty($id) || empty($nombreCategoria)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El ID y el nombre de la categoría no pueden estar vacíos.'
                ]);
                return;
            }

            $ProductModel = new ProductModel();

            try {
                $ProductModel->updateCategory($id, $nombreCategoria);
                echo json_encode([
                    'success' => true,
                    'message' => 'Categoría actualizada correctamente'
                ]);
            } catch (PDOException $e) {
                echo json_encode([
                    'success' => false,
                    'message' => "Error al actualizar la categoría: " . $e->getMessage()
                ]);
            }
        }
    }*/
}
