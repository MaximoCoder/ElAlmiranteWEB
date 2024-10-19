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
}
