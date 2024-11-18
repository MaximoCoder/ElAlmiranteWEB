<?php

namespace Model;


class ReportModel
{
    private $db;
    // ESTA FUNCION DE __CONSTRUCT ES PARA TRAER LA CONEXION A LA BASE DE DATOS, SIEMPRE DEBE DE IR EN LOS MODELOS.
    public function __construct()
    {
        $this->db = connectDB(); // Conectar a la base de datos
    }

    // 1. Ventas por categoría
    public function getSalesByCategory()
    {
        try {
            $sql = $this->db->query("
            SELECT 
                c.NombreCategoría, 
                SUM(dv.Cantidad) AS TotalVendidos, 
                SUM(dv.Subtotal) AS TotalGanancias
            FROM 
                categoria c
            INNER JOIN 
                platillo p ON c.IdCategoría = p.IdCategoria
            INNER JOIN 
                detalleventa dv ON p.IdPlatillo = dv.IdPlatillo
            GROUP BY 
                c.IdCategoría, c.NombreCategoría
            ");
            return $sql->fetchAll(); // Devuelve todos los registros de la consulta
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    // 2. Ventas por día
    public function getDailySales()
    {
        try {
            $sql = $this->db->query("
            SELECT 
                DATE(v.FechaVenta) AS Fecha, 
                COUNT(v.IdVenta) AS TotalVentas, 
                SUM(v.MontoTotal) AS TotalGanancias
            FROM 
                venta v
            GROUP BY 
                DATE(v.FechaVenta)
            ORDER BY 
                Fecha ASC
            ");
            return $sql->fetchAll();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    // 6. Categorías con más pedidos
    public function getTopOrderedCategories()
    {
        try {
            $sql = $this->db->query("
            SELECT 
                c.NombreCategoría, 
                COUNT(dv.IdDetalleVenta) AS TotalPedidos
            FROM 
                categoria c
            INNER JOIN 
                platillo p ON c.IdCategoría = p.IdCategoria
            INNER JOIN 
                detalleventa dv ON p.IdPlatillo = dv.IdPlatillo
            GROUP BY 
                c.IdCategoría, c.NombreCategoría
            ORDER BY 
                TotalPedidos DESC
            LIMIT 5
        ");
            return $sql->fetchAll();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}