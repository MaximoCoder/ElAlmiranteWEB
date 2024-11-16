<?php
// models/MenuModel.php
namespace Model;


class MenuModel
{
    private $db;

    public function __construct()
    {
        $this->db = connectDB(); // Conectar a la base de datos
    }

    // FUNCION PARA TRAER LAS CATEGORIAS
    public function getCategories()
    {
        try {
            $query = "SELECT * FROM categoria WHERE Estado = 'Activa'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error al obtener las categorías: " . $e->getMessage();
            return null;
        }
    }

    // FUNCION PARA TRAER TODOS LOS PRODUCTOS
    public function getAllProducts()
    {
        try {
            $query = "SELECT * FROM platillo ORDER BY IdCategoria ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error al obtener los productos: " . $e->getMessage();
            return null;
        }
    }

    // FUNCION PARA TRAER LOS PRODUCTOS POR CATEGORIA
    public function getProductsByCategory($category)
    {
        try {
            $query = "SELECT * FROM platillo WHERE IdCategoria = :IdCategoria";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':IdCategoria', $category); // Pasar el ID de la categoría
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error al obtener los productos por categoría: " . $e->getMessage();
            return null;
        }
    }

    // FUNCION PARA TRAER SOLO UN PRODUCTO
    public function getProductById($id)
    {
        try {
            $query = "SELECT * FROM platillo WHERE IdPlatillo = :IdPlatillo";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':IdPlatillo', $id); // Pasar el ID del platillo
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error al obtener el platillo: " . $e->getMessage();
            return null;
        }
    }
}
