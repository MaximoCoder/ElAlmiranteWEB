<?php
// controllers/ProductController.php

namespace Controllers;

use MVC\Router;
use Model\AdminModel;

class ProductController
{
    public static function addProduct()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombrePlatillo = $_POST['NombrePlatillo'] ?? null;
            $DescripciónPlatillo = $_POST['DescripciónPlatillo'] ?? null;
            $precioPlatillo = $_POST['PrecioPlatillo'] ?? null;
            $disponibilidad = $_POST['Disponibilidad'] ?? null;
            $categoriaId = $_POST['IdCategoría'] ?? null;

            if (!$nombrePlatillo || !$DescripciónPlatillo || !$precioPlatillo || !$disponibilidad || !$categoriaId) {
                echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios']);
                return;
            }

            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $nombreImagen = $_FILES['img']['name'];
                $rutaTemporal = $_FILES['img']['tmp_name'];
                $carpetaDestino = __DIR__ . '/../public/uploads/';

                if (!is_dir($carpetaDestino)) {
                    mkdir($carpetaDestino, 0755, true);
                }

                $rutaDestino = $carpetaDestino . $nombreImagen;

                if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                    $imgNombre = $nombreImagen;
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al subir la imagen']);
                    return;
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'La imagen es obligatoria']);
                return;
            }

            try {
                $adminModel = new AdminModel();
                $platilloCreated = $adminModel->insertData([
                    'NombrePlatillo' => $nombrePlatillo,
                    'DescripciónPlatillo' => $DescripciónPlatillo,
                    'PrecioPlatillo' => $precioPlatillo,
                    'Disponibilidad' => $disponibilidad,
                    'IdCategoría' => $categoriaId,
                    'img' => $imgNombre
                ], 'platillo');

                if ($platilloCreated) {
                    echo json_encode(['status' => 'success', 'message' => 'El platillo se agregó correctamente.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No se insertaron filas en la base de datos.']);
                }
            } catch (\PDOException $e) {
                echo json_encode(['status' => 'error', 'message' => 'Error al agregar el platillo: ' . $e->getMessage()]);
                return;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
        }
    }

    public static function getCategories()
    {
        $adminModel = new AdminModel();
        return $adminModel->getData('categoria');
    }

public static function listarProductos(Router $router) {
    $sessionController = new \Controllers\SessionController();
    $sessionController->startSession();
    $user = $sessionController->getUser();

    if ($user === null) {
        echo "Usuario no identificado";
        return;
    }

    $platillos = self::getAllProducts(); 
    $categorias = self::getCategories(); 

    $router->render('admin/Editar_Productos', [
        'platillos' => $platillos,
        'categorias' => $categorias, 
        'user' => $user
    ], 'layoutAdmin');
}

    private static function getPlatillos() {
        require_once __DIR__ . '/../includes/config/database.php';
        $db = connectDB();
        
        $stmt = $db->prepare("SELECT IdPlatillo, NombrePlatillo FROM platillo");
        $stmt->execute();
        
        $platillos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    

   public static function getAllProducts() {
    $query = "SELECT IdPlatillo, NombrePlatillo, DescripciónPlatillo, PrecioPlatillo, Disponibilidad, img, IdCategoría FROM platillo";
    $stmt = Database::getInstance()->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public static function eliminarPlatillo(Router $router) {
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {  
        require_once __DIR__ . '/../includes/config/database.php';

        $id = $_REQUEST['id'] ?? '';

        try {
            $db = connectDB();
            $stmt = $db->prepare("DELETE FROM platillo WHERE IdPlatillo = ?");
            $stmt->execute([$id]);

            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }
}
public static function editarPlatillo(Router $router) {
    header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once __DIR__ . '/../includes/config/database.php';

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

        try {
            $db = connectDB();
            $stmt = $db->prepare("UPDATE platillo SET NombrePlatillo = ?, IdCategoría = ?, Disponibilidad = ?, DescripciónPlatillo = ?, PrecioPlatillo = ?, img = ? WHERE IdPlatillo = ?");
            $stmt->execute([$nombrePlatillo, $categoriaId, $disponibilidadPlatillo, $descripcionPlatillo, $precioPlatillo, $imgNombre, $platilloId]);

            echo json_encode([
                'success' => true,
                'id' => $platilloId,
                'nombre' => $nombrePlatillo,
                'categoria' => $categoriaId,
                'disponibilidad' => $disponibilidadPlatillo,
                'descripcion' => $descripcionPlatillo,
                'precio' => $precioPlatillo,
                'img' => $imgNombre
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



public static function obtenerPlatillos($router) {
    header('Content-Type: application/json');
    include_once 'config/database.php'; 

    $platilloId = $_GET['id'] ?? null;

    try {
        if ($platilloId) {
            $stmt = $pdo->prepare('SELECT * FROM platillos WHERE IdPlatillo = ?');
            $stmt->execute([$platilloId]);
            $platillo = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($platillo) {
                echo json_encode($platillo);
            } else {
                echo json_encode(['error' => 'Platillo no encontrado']);
            }
        } else {
            $stmt = $pdo->query('SELECT * FROM platillos');
            $platillos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($platillos);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}




}



