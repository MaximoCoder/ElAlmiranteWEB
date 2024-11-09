<?php
// controllers/CategoriasController.php

namespace Controllers;

use MVC\Router;
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
                $error = "El nombre de la categoría no puede estar vacío.";
            } else {
                try {
                    $db = connectDB();
                    $stmt = $db->prepare("INSERT INTO categoria (NombreCategoría, FechaCreación) VALUES (?, NOW())");
                    $stmt->execute([$nombreCategoria]);
                    header("Location: /admin/categorias");
                    exit;
                } catch (PDOException $e) {
                    $error = "Error al insertar la categoría: " . $e->getMessage();
                }
            }
        }

        $router->render('admin/Categorias', [
            'error' => $error
        ], 'layoutAdmin');
    }

    public static function eliminarCategoria(Router $router) {
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        require_once __DIR__ . '/../includes/config/database.php';

        $id = $_GET['id'] ?? '';

        try {
            $db = connectDB();
            $stmt = $db->prepare("DELETE FROM categoria WHERE IdCategoría = ?");
            $stmt->execute([$id]);

            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }
}


    public static function editarCategoria(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../includes/config/database.php';

            $id = $_POST['categoriaId'] ?? '';
            $nombreCategoria = $_POST['nombreCategoriaEditar'] ?? '';

            if (empty($nombreCategoria)) {
                echo json_encode(['success' => false, 'error' => 'El nombre no puede estar vacío.']);
                exit;
            }

            try {
                $db = connectDB();
                $stmt = $db->prepare("UPDATE categoria SET NombreCategoría = ? WHERE IdCategoría = ?");
                $stmt->execute([$nombreCategoria, $id]);

                echo json_encode([
                    'success' => true,
                    'id' => $id,
                    'nombre' => $nombreCategoria
                ]);
            } catch (PDOException $e) {
                echo json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ]);
            }
            exit;
        }
    }*/
}
