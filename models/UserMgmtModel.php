<?php
// models/UserMgmtModel.php
namespace Model;

class UserMgmtModel
{
    private $db;
    public function __construct()
    {
        $this->db = connectDB(); // Conectar a la base de datos
    }

    // Funcion para obtener todos los usuarios
    public function getAllUsers()
    {
        try {
            $query = "SELECT * FROM usuario";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $this->handleError($e);
        }
    }

    // Funcion para obtener un usuario por su ID
    public function getUserById($idUsuario)
    {
        try {
            $query = "SELECT * FROM usuario WHERE IdUsuario = :idUsuario";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':idUsuario' => $idUsuario]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $this->handleError($e);
        }
    }

    // Funcion para actualizar un usuario
    public function updateUser($idUsuario, $Nombre, $Correo, $Estado)
    {
        try {
            $query = "UPDATE usuario SET Nombre = :Nombre, Correo = :Correo, Estado = :Estado WHERE IdUsuario = :idUsuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':Nombre', $Nombre);
            $stmt->bindParam(':Correo', $Correo);
            $stmt->bindParam(':Estado', $Estado);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $this->handleError($e);
        }
    }

    // Funcion para eliminar un usuario
    public function deleteUser($idUsuario)
    {
        try {
            $query = "DELETE FROM usuario WHERE IdUsuario = :idUsuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':idUsuario', $idUsuario);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $e;
        }
    }

    // Funcion para traer todos los roles
    public function getAllRoles()
    {
        try {
            $query = "SELECT * FROM rol";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $this->handleError($e);
        }
    }

    // Funcion para crear un nuevo rol
    public function crearRol($NombreRol, $DescripcionRol)
    {
        try {
            $query = "INSERT INTO rol (NombreRol, DescripcionRol) VALUES (:NombreRol, :DescripcionRol)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':NombreRol', $NombreRol);
            $stmt->bindParam(':DescripcionRol', $DescripcionRol);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $this->handleError($e);
        }
    }

    // Funcion para actualizar un rol
    public function editarRol($IdRol, $NombreRol, $DescripcionRol)
    {
        try {
            $query = "UPDATE rol SET NombreRol = :NombreRol, DescripcionRol = :DescripcionRol WHERE IdRol = :IdRol";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':IdRol', $IdRol);
            $stmt->bindParam(':NombreRol', $NombreRol);
            $stmt->bindParam(':DescripcionRol', $DescripcionRol);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $this->handleError($e);
        }
    }

    // Funcion para eliminar un rol
    public function eliminarRol($IdRol)
    {
        try {
            $query = "DELETE FROM rol WHERE IdRol = :IdRol";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':IdRol', $IdRol);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $e;
        }
    }

    private function handleError(\PDOException $e)
    {
        // Manejar el error usando la funcion handleError
        return $e;
    }
}