<?php

namespace Controllers;

use MVC\Router;
use Model\ProductModel;
use PDOException;

class EditarProductosController {
    public static function renderAdminView(Router $router)
    {
        $ProductModel = new ProductModel();
        $platillos = $ProductModel->getPlatillos();
        $categorias = $ProductModel->getCategories();

        $router->render('admin/editar_productos', [
            'platillos' => $platillos,
            'categorias' => $categorias
        ], 'layoutAdmin');
    }

    // Obtener lista de productos
    public function getPlatillos() {
        return $this->model->getPlatillos();
    }

    public function getCategories() {
        return $this->model->getCategories();
    }

    public static function eliminarPlatillo(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $id = $_REQUEST['id'] ?? '';
            $ProductModel = new ProductModel();
            $result = $ProductModel->eliminarPlatillo($id);
    
            echo json_encode($result);
            exit;
        }
    }

    public static function editarPlatillo(Router $router) {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $platilloId = $_POST['platilloId'] ?? null;
            $nombrePlatillo = $_POST['nombrePlatilloEditar'] ?? null;
            $categoriaId = $_POST['categoriaPlatilloEditar'] ?? null;
            $disponibilidadPlatillo = $_POST['disponibilidadPlatilloEditar'] ?? null;
            $descripcionPlatillo = $_POST['descripcionPlatilloEditar'] ?? null;
            $precioPlatillo = $_POST['precioPlatilloEditar'] ?? null;
            $imagenExistente = $_POST['imagenExistente'] ?? null;
    
            if (empty($platilloId) || empty($nombrePlatillo) || empty($categoriaId) || $disponibilidadPlatillo === null || empty($descripcionPlatillo) || empty($precioPlatillo)) {
                echo json_encode(['success' => false, 'error' => 'ID, nombre del platillo, categoría, disponibilidad, descripción y precio son necesarios.']);
                exit;
            }
    
            $imgNombre = $imagenExistente; 
    
            if (isset($_FILES['imgPlatilloEditar']) && $_FILES['imgPlatilloEditar']['error'] === UPLOAD_ERR_OK) {
                $nombreImagen = $_FILES['imgPlatilloEditar']['name'];
                $rutaTemporal = $_FILES['imgPlatilloEditar']['tmp_name'];
    
                $carpetaDestino = __DIR__ . '/../public/uploads/';
    
                if (!is_dir($carpetaDestino)) {
                    mkdir($carpetaDestino, 0755, true);
                }
    
                $rutaDestino = $carpetaDestino . $nombreImagen;
    
                if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                    $imgNombre = $nombreImagen; 
                } else {
                    echo json_encode(['success' => false, 'error' => 'Error al subir la nueva imagen']);
                    exit;
                }
            } elseif (!$imagenExistente) {
                echo json_encode(['success' => false, 'error' => 'Debe proporcionar una imagen.']);
                exit;
            }
    
            $ProductModel = new ProductModel();
            $result = $ProductModel->editarPlatillo($platilloId, $nombrePlatillo, $categoriaId, $disponibilidadPlatillo, $descripcionPlatillo, $precioPlatillo, $imgNombre);
    
            echo json_encode($result);
            exit;
        }
    }

}
