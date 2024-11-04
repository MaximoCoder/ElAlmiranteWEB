<?php
// controllers/ProductController.php

namespace Controllers;

use MVC\Router;
use Model\ProductModel;
use PDOException;

class ProductController
{
    // Obtiene las categorías de productos
    public static function getCategories()
    {
        $productModel = new ProductModel();
        return $productModel->getAllCategories();
    }

    // Agrega un nuevo producto con imagen
    public static function addProduct()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombrePlatillo = $_POST['NombrePlatillo'] ?? '';
            $descripcionPlatillo = $_POST['DescripciónPlatillo'] ?? '';
            $precioPlatillo = $_POST['PrecioPlatillo'] ?? '';
            $disponibilidad = $_POST['Disponibilidad'] ?? '';
            $categoriaId = $_POST['IdCategoría'] ?? '';
            $imgNombre = '';

            // Validación de campos obligatorios
            if (empty($nombrePlatillo) || empty($precioPlatillo) || empty($categoriaId)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El nombre, precio y categoría son obligatorios.'
                ]);
                return;
            }

            // Manejo de la imagen
            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $nombreImagen = $_FILES['img']['name'];
                $rutaTemporal = $_FILES['img']['tmp_name'];
                $carpetaDestino = __DIR__ . '/../public/uploads/';

                // Crear la carpeta si no existe
                if (!is_dir($carpetaDestino)) {
                    mkdir($carpetaDestino, 0755, true);
                }

                $rutaDestino = $carpetaDestino . $nombreImagen;

                // Mover la imagen al destino final
                if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                    $imgNombre = $nombreImagen;
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Error al subir la imagen'
                    ]);
                    return;
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'La imagen es obligatoria'
                ]);
                return;
            }

            // Insertar el producto con la imagen en la base de datos
            $productModel = new ProductModel();

            try {
                $productModel->insertProduct($nombrePlatillo, $descripcionPlatillo, $precioPlatillo, $disponibilidad, $categoriaId, $imgNombre);
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Producto agregado correctamente'
                ]);
            } catch (PDOException $e) {
                echo json_encode([
                    'success' => false,
                    'message' => "Error al agregar el producto: " . $e->getMessage()
                ]);
            }
        }
    }

    public static function obtenerPlatillos($router) {
        header('Content-Type: application/json');
        include_once 'config/database.php'; 
    
        $platilloId = $_GET['id'] ?? null;
    
        try {
            if ($platilloId) {
                $stmt = $pdo->prepare('SELECT * FROM platillo WHERE IdPlatillo = ?');
                $stmt->execute([$platilloId]);
                $platillo = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if ($platillo) {
                    echo json_encode($platillo);
                } else {
                    echo json_encode(['error' => 'Platillo no encontrado']);
                }
            } else {
                $stmt = $pdo->query('SELECT * FROM platillo');
                $platillos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($platillos);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    

    // Lista todos los productos
    public static function listarProductos(Router $router)
    {
        $productModel = new ProductModel();
        $productos = $productModel->getAllProducts();

        // Renderiza la vista de productos con los datos obtenidos
        $router->render('admin/Editar_Productos', [
            'productos' => $productos
        ], 'layoutAdmin');
    }
    
}
?>
