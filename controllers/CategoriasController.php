<?php
// controllers/CategoriasController.php

namespace Controllers;

use MVC\Router;

use Model\ProductModel;
use Model\AdminModel;
use PDOException;

class CategoriasController
{
    public static function renderAdminView(Router $router)
    {
        $ProductModel = new ProductModel();
        $categorias = $ProductModel->getAllCategories();

        // Renderiza la vista de categorías con los datos obtenidos
        $router->render('admin/Categorias', [
            'categorias' => $categorias
        ], 'layoutAdmin');
    }


    public static function getCategories()
    {
        $adminModel = new AdminModel();
        return $adminModel->getData('categoria');
    }

    public static function agregarCategoria()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $nombreCategoria = $data['nombreCategoria'] ?? '';
            $estadoCategoria = $data['estadoCategoria'] ?? 'Activo';
    
            if (empty($nombreCategoria)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El nombre de la categoría no puede estar vacío.'
                ]);
                return;
            }
    
            $ProductModel = new ProductModel();
            
            try {
                // Insertar categoría
                $id = $ProductModel->insertCategory($nombreCategoria, $estadoCategoria);
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Categoría agregada correctamente',
                    'id' => $id  // Devolver el ID de la nueva categoría
                ]);
            } catch (PDOException $e) {
                echo json_encode([
                    'success' => false,
                    'message' => "Error al insertar la categoría: " . $e->getMessage()
                ]);
            }
        }
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
            $estado = $_POST['estadoCategoriaEditar'] ?? '';
    
            if (empty($id) || empty($nombreCategoria) || empty($estado)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El ID, el nombre y el estado de la categoría no pueden estar vacíos.'
                ]);
                return;
            }
    
            $ProductModel = new ProductModel();
    
            try {
                $ProductModel->updateCategory($id, $nombreCategoria, $estado);
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
    }
    
    
    
}
