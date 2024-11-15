<?php
// models/vacanteModel.php
namespace Model;

class vacanteModel
{
    private $db;

    public function __construct()
    {
        $this->db = connectDB(); // Conectar a la base de datos
    }

    // Función para crear un nueva vacante
    public function createVacante($nombreVacante, $descripcionVacante, $activa)
    {
        try {
            $query = "INSERT INTO vacante (nombreVacante, descripcionVacante, Activa) 
                      VALUES (:nombreVacante, :descripcionVacante, :Activa)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombreVacante', $nombreVacante);
            $stmt->bindParam(':descripcionVacante', $descripcionVacante);
            $stmt->bindParam(':Activa', $activa);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $e;
        }
    }
}