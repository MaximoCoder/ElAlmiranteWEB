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
    public function create($nombreVacante, $descripcionVacante)
    {
        try {
            $query = "INSERT INTO vacante (nombreVacante, descpricionVacante) 
                      VALUES (:nombreVacante, :descripcionVacante)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombreVacante', $nombreVacante);
            $stmt->bindParam(':descripcionVacante', $descripcionVacante);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $e;
        }
    }
}