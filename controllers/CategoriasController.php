<?php
// controllers/CategoriasController.php

namespace Controllers;

use MVC\Router;
use PDO;
use PDOException;

class CategoriasController {
    public static function renderAdminView(Router $router, $viewName) {
        $sessionController = new \Controllers\SessionController();
        $sessionController->startSession();
        $user = $sessionController->getUser();

        if ($user === null) {
            echo "Usuario no identificado";
            return;
        }

        $categorias = self::getCategorias();

        $router->render('admin/' . $viewName, [
            'user' => $user,
            'categorias' => $categorias
        ], 'layoutAdmin');
    }
        
    public static function listarCategorias(Router $router) {
        $sessionController = new \Controllers\SessionController();
        $sessionController->startSession();
        $user = $sessionController->getUser();

        if ($user === null) {
            echo "Usuario no identificado";
            return;
        }

        $categorias = self::getCategorias();

        $router->render('admin/Categorias', [
            'categorias' => $categorias,
            'user' => $user
        ], 'layoutAdmin');
    }

    private static function getCategorias() {
        require_once __DIR__ . '/../includes/config/database.php';
        $db = connectDB();
        
        $stmt = $db->prepare("SELECT IdCategoría, NombreCategoría, FechaCreación FROM categoria");
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function agregarCategoria(Router $router) {
        header('Content-Type: application/json');
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
        header('Content-Type: application/json');
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
    header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once __DIR__ . '/../includes/config/database.php';

        $id = $_POST['categoriaId'] ?? '';
        $nombreCategoria = $_POST['nombreCategoriaEditar'] ?? '';

        if (empty($id) || empty($nombreCategoria)) {
            echo json_encode(['success' => false, 'error' => 'Todos los campos deben estar completos.']);
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
}

}
