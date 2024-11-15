<?php
// models/DashboardModel.php
namespace Model;


class DashboardModel
{
    private $db;
    // ESTA FUNCION DE __CONSTRUCT ES PARA TRAER LA CONEXION A LA BASE DE DATOS, SIEMPRE DEBE DE IR EN LOS MODELOS.
    public function __construct()
    {
        $this->db = connectDB(); // Conectar a la base de datos
    }
    // FUNCION PARA OBTENER LAS ORDENES DE LA DB
    public function getOrders(){
       
        try{
            // Aqui podemos decidir si traer las ordenes pendientes, canceladas o completadas, vamos a dejarlo asi de mientras.
            $query = $this->db->query(
                'SELECT o.*, u.Nombre AS NombreCliente 
                 FROM orden o 
                 INNER JOIN usuario u ON o.IdCliente = u.IdUsuario 
                 WHERE DATE(o.FechaOrden) = CURDATE()'
            );
            return $query->fetchAll(); // Devuelve todos los registros de la consulta
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }

    // Funcion para obtener el total de las ordenes de HOY
    public function getTodayOrders() {
        try {
            // Obtener las órdenes cuya FechaOrden sea hoy
            $query = $this->db->prepare('SELECT COUNT(*) AS total FROM orden WHERE DATE(FechaOrden) = CURDATE()');
            $query->execute();
            return $query->fetch(); // Devuelve el registro con el total
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    // FUNCION PARA OBTENER LOS VISITANTES ACTIVOS 
    public function getVisitors(){
        try{
            // Traemos el numero de visitantes activos
            $query = $this->db->query('SELECT * FROM usuario WHERE Estado = 1'); 
            // Devolver el total de registros
            return $query->rowCount(); 
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }

    // FUNCION PARA OBTENER EL TOTAL DE VENTAS OBTENIDO
    public function getTotalSales(){
        try{
            // TRAER EL TOTAL OBTENIDO DE TODAS LAS VENTAS COMPLETADAS
            $query = $this->db->query('SELECT COALESCE(SUM(MontoTotal), 0) AS total FROM venta WHERE EstadoVenta = "Completada" AND DATE(FechaVenta) = CURDATE() ');
            // Devolver el registro
            return $query->fetch();
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }
}