<?php
// models/ProductModel.php

namespace Model;

use PDO;
use PDOException;

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = connectDB(); 
    }
//CategoriasController
    public function getAllCategories()
    {
        try {
            $query = "SELECT * FROM categoria";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener las categorías: " . $e->getMessage();
            return null;
        }
    }

    public function insertCategory($nombreCategoria)
    {
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

    // Elimina una categoría por su ID
    public function deleteCategory($id)
    {
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
    

    // Actualiza el nombre de una categoría por su ID
    public function updateCategory($id, $nombreCategoria)
    {
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

//Product Controller
    // Obtiene todos los platillos
    public function getAllProducts()
    {
        try {
            $query = "SELECT * FROM platillo";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los platillos: " . $e->getMessage();
            return null;
        }
    }

    // Insertar un nuevo platillo
    public function insertProduct($nombrePlatillo, $descripcionPlatillo, $precioPlatillo, $disponibilidad, $categoriaId, $img)
    {
        try {
            $query = "INSERT INTO platillo (NombrePlatillo, DescripciónPlatillo, PrecioPlatillo, Disponibilidad, IdCategoría, img) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$nombrePlatillo, $descripcionPlatillo, $precioPlatillo, $disponibilidad, $categoriaId, $img]);
        } catch (PDOException $e) {
            echo "Error al insertar el platillo: " . $e->getMessage();
        }
    }
    // Eliminar un platillo por su ID
    public function deletePlatillo($id)
    {
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
    

    // Actualizar los datos de un platillo por su ID
    public function updateProduct($id, $nombrePlatillo, $descripcionPlatillo, $precioPlatillo, $disponibilidad, $categoriaId)
    {
        try {
            $query = "UPDATE platillo SET NombrePlatillo = ?, DescripciónPlatillo = ?, PrecioPlatillo = ?, Disponibilidad = ?, IdCategoría = ? WHERE IdPlatillo = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$nombrePlatillo, $descripcionPlatillo, $precioPlatillo, $disponibilidad, $categoriaId, $id]);
        } catch (PDOException $e) {
            echo "Error al actualizar el platillo: " . $e->getMessage();
        }
    }

    // Obtener un platillo por su ID
    public function getProductById($id)
    {
        try {
            $query = "SELECT * FROM platillo WHERE IdPlatillo = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener el platillo: " . $e->getMessage();
            return null;
        }
    }

    //Editarproductos
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
    public function eliminarPlatillo($id) {
        try {
            $db = connectDB();
            $stmt = $db->prepare("DELETE FROM platillo WHERE IdPlatillo = ?");
            $stmt->execute([$id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // Método para editar un platillo
    public function editarPlatillo($platilloId, $nombrePlatillo, $categoriaId, $disponibilidadPlatillo, $descripcionPlatillo, $precioPlatillo, $imgNombre) {
        try {
            $db = connectDB();
            $stmt = $db->prepare("UPDATE platillo SET NombrePlatillo = ?, IdCategoría = ?, Disponibilidad = ?, DescripciónPlatillo = ?, PrecioPlatillo = ?, img = ? WHERE IdPlatillo = ?");
            $stmt->execute([$nombrePlatillo, $categoriaId, $disponibilidadPlatillo, $descripcionPlatillo, $precioPlatillo, $imgNombre, $platilloId]);
            return [
                'success' => true,
                'id' => $platilloId,
                'nombre' => $nombrePlatillo,
                'categoria' => $categoriaId,
                'disponibilidad' => $disponibilidadPlatillo,
                'descripcion' => $descripcionPlatillo,
                'precio' => $precioPlatillo,
                'img' => $imgNombre
            ];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
?>
