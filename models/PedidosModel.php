<?php
// models/PedidoModel.php
namespace Model;

class PedidosModel
{
    private $db;

    public function __construct()
    {
        $this->db = connectDB(); // Conectar a la base de datos
    }

    // Función para obtener todos los pedidos pendientes
    public function getPedidosPendientes()
    {
        try {
            $query = "
                            SELECT 
                o.IdOrden,
                o.IdVenta,
                o.MontoOrden,
                v.EstadoPago,
                GROUP_CONCAT(CONCAT(d.Cantidad, ' x ', p.NombrePlatillo) SEPARATOR ', ') AS Platillos,
                o.Observaciones AS Nota,
                o.EstadoOrden,
                o.FechaOrden AS Fecha
            FROM orden o
            INNER JOIN detalleorden d ON o.IdOrden = d.IdOrden
            INNER JOIN platillo p ON d.IdPlatillo = p.IdPlatillo
            INNER JOIN venta v ON o.IdVenta = v.IdVenta
            WHERE o.EstadoOrden = 'Pendiente'
            AND DATE(o.FechaOrden) = CURDATE()
            GROUP BY 
                o.IdOrden, 
                o.IdVenta, 
                o.MontoOrden, 
                v.EstadoPago, 
                o.Observaciones, 
                o.EstadoOrden, 
                o.FechaOrden
            ORDER BY 
                o.FechaOrden ASC, 
                o.IdOrden ASC;";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            // Retornar los resultados como un array asociativo
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Manejo de errores
            echo "Error al obtener los pedidos: " . $e->getMessage();
            return null;
        }
    }
    // Funcion para obtener todos los pedidos completados
    public function getPedidosCompletados()
    {
        try {
            $query = "SELECT 
                o.IdOrden,
                o.MontoOrden,
                v.EstadoPago,
                GROUP_CONCAT(CONCAT(d.Cantidad, ' x ', p.NombrePlatillo) SEPARATOR ', ') AS Platillos,
                o.Observaciones AS Nota,
                o.EstadoOrden,
                o.FechaOrden AS Fecha
            FROM orden o
            INNER JOIN detalleorden d ON o.IdOrden = d.IdOrden
            INNER JOIN platillo p ON d.IdPlatillo = p.IdPlatillo
            INNER JOIN venta v ON o.IdVenta = v.IdVenta
            WHERE o.EstadoOrden = 'Completada' 
              AND DATE(o.FechaOrden) = CURDATE()
            GROUP BY o.IdOrden, o.MontoOrden, v.EstadoPago, o.Observaciones, o.EstadoOrden, o.FechaOrden
            ORDER BY o.FechaOrden ASC;";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            // Retornar los resultados como un array asociativo
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Manejo de errores
            echo "Error al obtener los pedidos: " . $e->getMessage();
            return null;
        }
    }
    // Actualizar el estado del pago
    public function updateData($data, $table, $where){
        try{
            // Construir la parte SET de la consulta
            $setParts = [];
            foreach (array_keys($data) as $column) {
                $setParts[] = "$column = ?";
            }
            $setClause = implode(',', $setParts);

            // Construir la parte WHERE de la consulta
            $whereParts = [];
            foreach (array_keys($where) as $column) {
                $whereParts[] = "$column = ?";
            }
            $whereClause = implode(' AND ', $whereParts);

            // Construir la consulta completa
            $query = "UPDATE $table SET $setClause WHERE $whereClause";

            // Preparar y ejecutar la consulta
            $stmt = $this->db->prepare($query);

            // Combinar los valores de data y where para la ejecución
            $values = array_merge(array_values($data), array_values($where));
            $stmt->execute($values);

            return $stmt->rowCount();
        }catch (\PDOException $e) {
            // Manejo de errores
            echo "Error " . $e->getMessage();
        }
    }
}
