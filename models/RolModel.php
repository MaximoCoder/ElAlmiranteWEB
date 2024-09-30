<?php
namespace Model;

class RolModel
{
    private $db;

    public function __construct()
    {
        $this->db = connectDB(); 
    }

    public function getUserRoles($userId)
    {
        try {
            $query = "SELECT r.NombreRol FROM asignación a
                      JOIN rol r ON a.IdRol = r.IdRol
                      WHERE a.IdUsuario = :userId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC); 
        } catch (\PDOException $e) {

            echo "Error en getUserRoles: " . $e->getMessage();
            return false;
        }
    }
}
