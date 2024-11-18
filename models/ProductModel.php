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

    public function insertCategory($nombreCategoria, $estadoCategoria)
    {
        try {
            $db = connectDB();
            $stmt = $db->prepare("INSERT INTO categoria (NombreCategoría, Estado, FechaCreación) VALUES (?, ?, NOW())");
            $stmt->execute([$nombreCategoria, $estadoCategoria]);
            
            // Obtener el ID de la última categoría insertada
            return $db->lastInsertId();
        } catch (PDOException $e) {
            throw new PDOException("Error al insertar la categoría: " . $e->getMessage());
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
    public function updateCategory($id, $nombreCategoria, $Estado)
    {
        try {
            $db = connectDB();
            // Corregir la consulta SQL, agregando una coma entre las columnas.
            $stmt = $db->prepare("UPDATE categoria SET NombreCategoría = ?, Estado = ? WHERE IdCategoría = ?");
            
            // Asegurarse de que los parámetros estén en el orden correcto.
            $stmt->execute([$nombreCategoria, $Estado, $id]);
    
            echo json_encode([
                'success' => true,
                'id' => $id,
                'nombre' => $nombreCategoria,
                'estado' => $Estado
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
    public function insertProduct($data, $table)
    {
        try {
            $columns = implode(',', array_keys($data));
            $placeholders = implode(',', array_fill(0, count($data), '?'));

            $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array_values($data));

            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw $e;
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
        $sql = "SELECT IdPlatillo, NombrePlatillo, PrecioPlatillo, DescripcionPlatillo, Disponibilidad, IdCategoría, img FROM platillo";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPlatilloById($id) {
        $sql = "SELECT IdPlatillo, NombrePlatillo, PrecioPlatillo, DescripcionPlatillo, Disponibilidad, IdCategoría, img 
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
            $stmt = $db->prepare("UPDATE platillo SET NombrePlatillo = ?, IdCategoria = ?, Disponibilidad = ?, DescripcionPlatillo = ?, PrecioPlatillo = ?, img = ? WHERE IdPlatillo = ?");
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
