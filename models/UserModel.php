<?php
// models/UserModel.php
namespace Model;

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = connectDB(); // Conectar a la base de datos
    }

    // FUNCIONES DE REGISTRO
    public function findByEmail($email)
    {
        $query = "SELECT * FROM usuario WHERE Correo = :Correo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':Correo', $email);
        $stmt->execute();
        return $stmt->fetch(); // Devuelve un solo resultado o false si no existe
    }

    public function createUser($name, $email, $Contraseña)
    {
        try {
            $query = "INSERT INTO usuario (Nombre, Correo, Password, FechaCreacion, Estado) VALUES (:Nombre, :Correo, :Password, NOW(), 0)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':Nombre', $name);
            $stmt->bindParam(':Correo', $email);
            $stmt->bindParam(':Password', $Contraseña);

            $result = $stmt->execute();
            #error_log("Consulta ejecutada. Resultado: " . ($result ? "Éxito" : "Fallo"));
            return $result;
        } catch ( \PDOException $e ) {
            echo "Error en createUser: " . $e->getMessage();
            return false;
        }
    }

    // Método para obtener los datos de un usuario
    public function getUserData($value, $field = 'IdUsuario')
    {
        $query = "SELECT * FROM usuario WHERE $field = :value";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        $userData = $stmt->fetch();
        return $userData;
    }
    // metodo para verificar el password

    public function verifyPassword($userId, $Contraseña)
    {
        $query = "SELECT Password FROM usuario WHERE IdUsuario = :IdUsuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':IdUsuario', $userId);
        $stmt->execute();
        $userData = $stmt->fetch();
        if (password_verify($Contraseña, $userData['Contraseña'])) {
            return true;
        } else {
            return false;
        }
    }
    // FUNCIONES PARA MOSTRAR ACTIVO O INACTIVO AL USUARIO
    public function setActive($userId)
    {
        $query = "UPDATE usuario SET Estado = 1 WHERE IdUsuario = :IdUsuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':IdUsuario', $userId);
        $stmt->execute();
    }
    public function setInactive($userId)
    {
        $query = "UPDATE usuario SET Estado = 0 WHERE IdUsuario = :IdUsuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':IdUsuario', $userId);
        $stmt->execute();
    }
}
