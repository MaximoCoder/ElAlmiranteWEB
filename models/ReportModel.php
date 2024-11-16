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
                Fecha DESC
            ");
            return $sql->fetchAll();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

    // 3. Platillos más vendidos
    public function getTopSellingDishes()
    {
        try {
            $sql = $this->db->prepare("
                SELECT 
                    p.NombrePlatillo, 
                    SUM(dv.Cantidad) AS TotalVendidos, 
                    SUM(dv.Subtotal) AS TotalGanancias
                FROM 
                    platillo p
                INNER JOIN 
                    detalleventa dv ON p.IdPlatillo = dv.IdPlatillo
                GROUP BY 
                    p.IdPlatillo, p.NombrePlatillo
                ORDER BY 
                    TotalVendidos DESC
                LIMIT 10");

            return $sql->fetchAll();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    // 4. Órdenes pendientes por cliente
    public function getPendingOrdersByClient()
    {
        try {

            $sql = $this->db->prepare("
             SELECT 
            o.IdCliente, 
            c.Nombre AS NombreCliente, 
            COUNT(o.IdOrden) AS OrdenesPendientes, 
            SUM(o.MontoOrden) AS MontoTotalPendiente
        FROM 
            orden o
        INNER JOIN 
            usuario c ON o.IdCliente = c.IdUsuario
        WHERE 
            o.EstadoOrden = 'Pendiente'
        GROUP BY 
            o.IdCliente, c.Nombre
        ");
            return $sql->fetchAll();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    // 5. Ingresos por mes
    public function getMonthlyIncome()
    {
        try {
            $sql = $this->db->prepare("
            SELECT 
                DATE_FORMAT(v.FechaVenta, '%Y-%m') AS Mes, 
                SUM(v.MontoTotal) AS TotalIngresos
            FROM 
                venta v
            GROUP BY 
                DATE_FORMAT(v.FechaVenta, '%Y-%m')
            ORDER BY 
                Mes DESC
        ");
            return $sql->fetchAll();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    // 6. Categorías con más pedidos
    public function getTopOrderedCategories($limit = 5)
    {
        try {
            $sql = $this->db->prepare("
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
            LIMIT 10
        ");
            return $sql->fetchAll();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}