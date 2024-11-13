<?php
// models/HistoryModel.php
namespace Model;

class HistoryModel
{
    private $db;

    public function __construct()
    {
        $this->db = connectDB(); // Conectar a la base de datos
    }
    // Funcion de traer el historial de orden,detalle orden
    public function getHistory($IdUser)
    {
        try {
            $query = "SELECT 
                    orden.IdOrden AS order_id,
                    orden.FechaOrden AS order_date,
                    orden.MontoOrden as MontoTotal,
                    platillo.IdPlatillo AS product_id,
                    platillo.NombrePlatillo AS product_name,
                    platillo.PrecioPlatillo AS product_price,
                    detalleOrden.Cantidad AS quantity
                FROM orden
                JOIN detalleOrden ON orden.IdOrden = detalleOrden.IdOrden
                JOIN platillo ON detalleOrden.IdPlatillo = platillo.IdPlatillo
                WHERE orden.IdCliente = :IdCliente
                ORDER BY orden.FechaOrden DESC, order_id;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':IdCliente' => $IdUser]);

            return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Obtener todas las filas como array asociativo
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            echo $e->getMessage();
        }
    }
    public function getOrderById($orderId)
    {
        try {
            $query = "SELECT 
                    orden.IdOrden AS order_id,
                    platillo.IdPlatillo AS id,
                    platillo.NombrePlatillo AS name,
                    platillo.PrecioPlatillo AS price,
                    detalleOrden.Cantidad AS quantity
                FROM orden
                JOIN detalleOrden ON orden.IdOrden = detalleOrden.IdOrden
                JOIN platillo ON detalleOrden.IdPlatillo = platillo.IdPlatillo
                WHERE orden.IdOrden = :IdOrden
                ORDER BY orden.FechaOrden DESC, order_id;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':IdOrden' => $orderId]);

            return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Obtener todas las filas como array asociativo
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            echo $e->getMessage();
        }
    }
}
