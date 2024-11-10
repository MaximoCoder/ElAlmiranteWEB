<?php
// models/VentaModel.php
namespace Model;

class VentaModel
{
    private $db;
    public function __construct()
    {
        $this->db = connectDB(); // Conectar a la base de datos
    }

    // Funcion para crear una venta
    public function createVenta($IdCliente, $FechaVenta, $MontoTotal, $TipoPago, $EstadoPago, $IdPagoPaypal, $EstadoVenta)
    {
        try {
            $query = "INSERT INTO Venta (IdCliente, FechaVenta, MontoTotal, TipoPago, EstadoPago, IdPagoPaypal, EstadoVenta) VALUES (:IdCliente, :FechaVenta, :MontoTotal, :TipoPago, :EstadoPago, :IdPagoPaypal, :EstadoVenta)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':IdCliente' => $IdCliente,
                ':FechaVenta' => $FechaVenta,
                ':MontoTotal' => $MontoTotal,
                ':TipoPago' => $TipoPago,
                ':EstadoPago' => $EstadoPago,
                ':IdPagoPaypal' => $IdPagoPaypal,
                ':EstadoVenta' => $EstadoVenta,
            ]);
            return $this->db->lastInsertId();
        } catch (\PDOException $e) {
            echo "Error al crear la venta: " . $e->getMessage();
            return false;
        }
    }

    // Crear una nueva orden en la tabla Orden
    public function createOrden($IdVenta, $IdCliente, $FechaOrden, $MontoOrden, $EstadoOrden, $Observaciones)
    {
        try {
            $query = "INSERT INTO Orden (IdVenta, IdCliente, FechaOrden, MontoOrden, EstadoOrden, Observaciones) VALUES (:IdVenta, :IdCliente, :FechaOrden, :MontoOrden, :EstadoOrden, :Observaciones)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':IdVenta' => $IdVenta,
                ':IdCliente' => $IdCliente,
                ':FechaOrden' => $FechaOrden,
                ':MontoOrden' => $MontoOrden,
                ':EstadoOrden' => $EstadoOrden,
                ':Observaciones' => $Observaciones,
            ]);
            return $this->db->lastInsertId();
        } catch (\PDOException $e) {
            echo "Error al crear la orden: " . $e->getMessage();
            return false;
        }
    }

    // Crear detalle de venta
    public function createDetalleVenta($IdVenta, $IdProducto, $Cantidad, $PrecioUnitario)
    {
        $Subtotal = $Cantidad * $PrecioUnitario;
        try {
            $query = "INSERT INTO detalleVenta (IdVenta, IdPlatillo, Cantidad, PrecioUnitario, Subtotal) VALUES (:IdVenta, :IdProducto, :Cantidad, :PrecioUnitario, :Subtotal)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':IdVenta' => $IdVenta,
                ':IdProducto' => $IdProducto,
                ':Cantidad' => $Cantidad,
                ':PrecioUnitario' => $PrecioUnitario,
                ':Subtotal' => $Subtotal,
            ]);
            return true;
        } catch (\PDOException $e) {
            echo "Error al crear el detalle de venta: " . $e->getMessage();
            return false;
        }
    }

    // Crear detalle de orden
    public function createDetalleOrden($IdOrden, $IdProducto, $Cantidad, $PrecioUnitario)
    {
        $Subtotal = $Cantidad * $PrecioUnitario;
        try {
            $query = "INSERT INTO detalleOrden (IdOrden, IdPlatillo, Cantidad, PrecioUnitario, Subtotal) VALUES (:IdOrden, :IdProducto, :Cantidad, :PrecioUnitario, :Subtotal)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':IdOrden' => $IdOrden,
                ':IdProducto' => $IdProducto,
                ':Cantidad' => $Cantidad,
                ':PrecioUnitario' => $PrecioUnitario,
                ':Subtotal' => $Subtotal,
            ]);
            return true;
        } catch (\PDOException $e) {
            echo "Error al crear el detalle de orden: " . $e->getMessage();
            return false;
        }
    }
    // Funciones para traer el id de la venta y detalle venta
    public function getVentaById($idVenta)
    {
        try {
            $query = "SELECT * FROM Venta WHERE IdVenta = :idVenta";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':idVenta' => $idVenta]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            echo $e->getMessage();
        }
    }
    public function getDetalleVentaById($idVenta)
    {
        try {
            $query = "SELECT platillo.NombrePlatillo AS nombre_producto, detalleventa.Cantidad, detalleventa.PrecioUnitario, detalleventa.Subtotal
                  FROM detalleventa
                  JOIN platillo ON detalleventa.IdPlatillo = platillo.IdPlatillo
                  WHERE detalleventa.IdVenta = :idVenta";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':idVenta' => $idVenta]);
            $stmt->execute([':idVenta' => $idVenta]);

            $detalles = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $detalles;
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            echo $e->getMessage();
        }
    }
    // FUNCIONES PARA EDITAR EL ESTADO DEL PAGO DE LA VENTA
    public function updateData($data, $table, $where)
    {
        try {
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
        } catch (\PDOException $e) {
            // Re-throw the exception to be caught by the controller
            throw $e;
        }
    }
}