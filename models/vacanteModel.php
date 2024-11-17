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
            return $this->handleError($e);
        }
    }

    // Función para obtener todas las vacantes
    public function getAllVacantes()
    {
        try {
            $query = "SELECT * FROM vacante";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $this->handleError($e);
        }
    }

    // Función para obtener una vacante por su ID
    public function getVacanteById($idVacante)
    {
        try {
            $query = "SELECT * FROM vacante WHERE IdVacante = :idVacante";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':idVacante' => $idVacante]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $this->handleError($e);
        }
    }

    private function handleError(\PDOException $e)
    {
        // Manejar el error usando la funcion handleError
        return $e;
    }

    public function updateVacante($idVacante, $nombreVacante, $descripcionVacante, $activa)
    {
        try {
            $query = "UPDATE vacante SET nombreVacante = :nombreVacante, descripcionVacante = :descripcionVacante, Activa = :Activa WHERE IdVacante = :idVacante";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':idVacante', $idVacante);
            $stmt->bindParam(':nombreVacante', $nombreVacante);
            $stmt->bindParam(':descripcionVacante', $descripcionVacante);
            $stmt->bindParam(':Activa', $activa);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $this->handleError($e);
        }
    }

    public function deleteVacante($idVacante)
    {
        try {
            $query = "DELETE FROM vacante WHERE IdVacante = :idVacante";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':idVacante', $idVacante);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $e;
        }
    }

    // Con esta funcion nos vamos a traer todos los datos de las vacantes.
    public function getVacantes(){
        try{
            $query = $this->db->query("SELECT * FROM vacante WHERE Activa = 1");
            return $query->fetchAll(); 
        }catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $e;
        }
    }

}