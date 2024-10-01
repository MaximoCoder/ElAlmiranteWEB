<?php
// controllers/AgregarProductosController.php

namespace Controllers;

use MVC\Router;
use Model\AdminModel;

class ProductController
{
    // Funcion para agregar un nuevo producto
    public static function addProduct()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //var_dump($_POST);
            //var_dump($_FILES);
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
                $adminModel = new AdminModel();
                $platilloCreated = $adminModel->insertData([
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
    // Funcion para obtener las categorias
    public static function getCategories()
    {
        $adminModel = new AdminModel();
        return $adminModel->getData('categoria');
    }
}
