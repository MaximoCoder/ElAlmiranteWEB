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
            // Unir la tabla 'usuario' con la tabla 'asignación' y la tabla 'rol' para mostrar el rol del usuario
            $query = "SELECT u.*, r.NombreRol FROM usuario u 
                      LEFT JOIN asignación a ON u.IdUsuario = a.IdUsuario 
                      LEFT JOIN rol r ON a.IdRol = r.IdRol";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
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

    // Función para asignar un rol
    public function asignarRol($IdUsuario, $IdRol)
    {
        try {
            //En caso de que el usuario ya tenga un rol, se actualiza el rol
            $query = "INSERT INTO asignación (IdUsuario, IdRol) VALUES (:idUsuario, :idRol)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':idUsuario', $IdUsuario);
            $stmt->bindParam(':idRol', $IdRol);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $e;
        }
    }
    public function quitarRol($IdUsuario)
    {
        try {
            // Elimina el rol del usuario en la tabla 'asignación'
            $query = "DELETE FROM asignación WHERE IdUsuario = :idUsuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':idUsuario', $IdUsuario, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Manejar el error usando la función handleError
            return $this->handleError($e);
        }
    }
    private function handleError(\PDOException $e)
    {
        // Manejar el error usando la funcion handleError
        return $e;
    }
}