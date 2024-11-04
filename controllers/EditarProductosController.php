<?php

namespace Controllers;

use MVC\Router;
use PDO;
use Exception;

class EditarProductosController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getPlatillo($id) {
        try {
            $platillo = $this->getPlatilloById($id);
            if (!$platillo) {
                throw new Exception("Platillo no encontrado.");
            }
            return $platillo;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'error' => 'Error al cargar platillo',
                'message' => $e->getMessage() 
            ]);
            exit;
        }
    }
    
    public function getPlatillos() {
        $sql = "SELECT IdPlatillo, NombrePlatillo, PrecioPlatillo, DescripciónPlatillo, Disponibilidad, IdCategoría, img FROM platillo";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPlatilloById($id) {
        $sql = "SELECT IdPlatillo, NombrePlatillo, PrecioPlatillo, DescripciónPlatillo, Disponibilidad, IdCategoría, img 
                FROM platillo WHERE IdPlatillo = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCategories() {
        $sql = "SELECT * FROM categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePlatillo($data) {
        if(empty($data['NombrePlatillo']) || empty($data['PrecioPlatillo']) || empty($data['DescripciónPlatillo']) || 
           empty($data['Disponibilidad']) || empty($data['IdCategoría'])) {
            return "Error: Todos los campos deben estar completos.";
        }
    
        $img = $data['img'];
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['img']['tmp_name'];
            $imageName = $_FILES['img']['name'];
            $destPath = 'uploads/' . $imageName;
    
            if(!is_dir('uploads')) {
                mkdir('uploads', 0777, true); 
            }
    
            if(move_uploaded_file($imageTmpPath, $destPath)) {
                $img = $destPath; 
            } else {
                return "Error: No se pudo mover el archivo de imagen.";
            }
        }
    
        $sql = "UPDATE platillo SET 
                    NombrePlatillo = :nombre, 
                    PrecioPlatillo = :precio, 
                    DescripciónPlatillo = :descripcion, 
                    Disponibilidad = :disponibilidad, 
                    IdCategoría = :IdCategoría, 
                    img = :imagen
                WHERE IdPlatillo = :id";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $data['NombrePlatillo']);
        $stmt->bindParam(':precio', $data['PrecioPlatillo']);
        $stmt->bindParam(':descripcion', $data['DescripciónPlatillo']);
        $stmt->bindParam(':disponibilidad', $data['Disponibilidad']);
        $stmt->bindParam(':IdCategoría', $data['IdCategoría']);
        $stmt->bindParam(':imagen', $img);
        $stmt->bindParam(':id', $data['IdPlatillo'], PDO::PARAM_INT);
        
        if($stmt->execute()) {
            return "Platillo actualizado con éxito.";
        } else {
            $errorInfo = $stmt->errorInfo();
            return "Error al actualizar el platillo: " . implode(", ", $errorInfo);
        }
    }
    
    public function renderAdminView($router, $view, $layout, $data = []) {
        $data['controller'] = $this; 

        $router->render($view, $data, $layout);
    }
    public static function eliminarPlatillo(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {  
    
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

}
