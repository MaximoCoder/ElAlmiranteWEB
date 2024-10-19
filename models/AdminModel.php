<?php
// models/AdminModel.php
namespace Model;

class AdminModel
{
    private $db;
    public function __construct()
    {
        $this->db = connectDB(); // Conectar a la base de datos
    }

    // FUNCIONES PARA INSERTAR DATOS EN LA BASE DE DATOS
    public function insertData($data, $table)
    {
        try {
            $columns = implode(',', array_keys($data));
            $placeholders = implode(',', array_fill(0, count($data), '?'));

            $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array_values($data));

            return $stmt->rowCount();
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            //return $this->handleError($e);
            // Re-throw the exception to be caught by the controller
            throw $e;
        }
    }
    // FUNCIONES PARA OBTENER DATOS DE LA BASE DE DATOS
    public function getData($table)
    {
        try {
            $query = "SELECT * FROM $table";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $this->handleError($e);
        }
    }

    // Función para manejar errores y devolver respuesta
    private function handleError($e)
    {
        return [
            'status' => 'error',
            'message' => $e->getMessage()
        ];
    }

}
