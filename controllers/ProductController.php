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
    // Funcion para agregar un nuevo producto
    public static function addProduct()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener los datos del formulario
            $nombrePlatillo = $_POST['NombrePlatillo'] ?? null;
            $descripcionPlatillo = $_POST['DescripcionPlatillo'] ?? null;
            $precioPlatillo = $_POST['PrecioPlatillo'] ?? null;
            $disponibilidad = $_POST['Disponibilidad'] ?? null;
            $categoriaId = $_POST['IdCategoria'] ?? null;

            // Manejar la subida de la imagen
            if (isset($_FILES['imagenProducto']) && $_FILES['imagenProducto']['error'] === UPLOAD_ERR_OK) {
                $nombreImagen = $_FILES['imagenProducto']['name'];
                $rutaTemporal = $_FILES['imagenProducto']['tmp_name'];
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
            }
            try {
                $productModel = new ProductModel();
                $platilloCreated = $productModel->insertProduct([
                    'NombrePlatillo' => $nombrePlatillo,
                    'DescripcionPlatillo' => $descripcionPlatillo,
                    'PrecioPlatillo' => $precioPlatillo,
                    'Disponibilidad' => $disponibilidad,
                    'IdCategoria' => $categoriaId,
                    'img' => $imgNombre
                ], 'platillo');

                if ($platilloCreated) {
                    echo json_encode(['status' => 'success', 'message' => 'El platillo se agregó correctamente.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No se insertaron filas en la base de datos.']);
                }
            } catch (\PDOException $e) {
                // En caso de error, mostrar un mensaje de error
                echo json_encode(['status' => 'error', 'message' => 'Error al agregar el platillo:' . $e->getMessage()]);
                return;
            }
        }
    }

    public static function obtenerPlatillos($router)
    {
        header('Content-Type: application/json');
        include_once 'config/database.php';

        $platilloId = $_GET['id'] ?? null;

        try {
            if ($platilloId) {
                $stmt = $pdo->prepare('SELECT * FROM platillo WHERE IdPlatillo = ?');
                $stmt->execute([$platilloId]);
                $platillo = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($platillo) {
                    echo json_encode($platillo);
                } else {
                    echo json_encode(['error' => 'Platillo no encontrado']);
                }
            } else {
                $stmt = $pdo->query('SELECT * FROM platillo');
                $platillos = $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
