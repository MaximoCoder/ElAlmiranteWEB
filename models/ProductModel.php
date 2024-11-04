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
    
}
?>
