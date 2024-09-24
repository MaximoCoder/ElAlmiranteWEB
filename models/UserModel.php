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
        try {
            $query = "SELECT * FROM usuario WHERE Correo = :Correo";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':Correo', $email);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC); // Devuelve un solo resultado como array asociativo
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $this->handleError($e);
        }
    }

    // Función para crear un nuevo usuario
    public function create($name, $email, $hashedPassword)
    {
        try {
            $query = "INSERT INTO usuario (Nombre, Correo, Password, FechaCreacion, Estado) 
                      VALUES (:Nombre, :Correo, :Password, NOW(), 0)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':Nombre', $name);
            $stmt->bindParam(':Correo', $email);
            $stmt->bindParam(':Password', $hashedPassword);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $this->handleError($e);
        }
    }

    // Método para obtener los datos de un usuario
    public function getUserData($value, $field = 'IdUsuario')
    {
        try{
            $query = "SELECT * FROM usuario WHERE $field = :value";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':value', $value);
            $stmt->execute();
            $userData = $stmt->fetch();
            return $userData;
        }catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $this->handleError($e);
        }
    }
    // Método para obtener el rol de un usuario
    public function getUserRole($userId)
    {
        try {
            // Aquí obtendremos el rol del usuario desde las tablas 'asignacion' y 'rol'
            $query = "SELECT r.NombreRol FROM asignación a 
                      JOIN rol r ON a.IdRol = r.IdRol 
                      WHERE a.IdUsuario = :userId";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            return $stmt->fetchColumn(); // Devolver solo el nombre del rol
        } catch (\PDOException $e) {
            // Manejar el error de la base de datos y devolver null o algún valor predeterminado
            echo "Error al obtener el rol del usuario: " . $e->getMessage();
            return null; // O un valor por defecto
        }
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
        try {
            $query = "UPDATE usuario SET Estado = 1 WHERE IdUsuario = :IdUsuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':IdUsuario', $userId);
            $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error en setActive: " . $e->getMessage();
            return false;
        }
    }
    public function setInactive($userId)
    {
        try {
            $query = "UPDATE usuario SET Estado = 0 WHERE IdUsuario = :IdUsuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':IdUsuario', $userId);
            $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error en setInactive: " . $e->getMessage();
            return false;
        }
    }

    public function setCode($Correo, $codigo)
    {
        try {
            $stmt = $this->db->prepare("UPDATE usuario SET Code = :Code WHERE Correo = :Correo");
            $stmt->bindParam(':Code', $codigo);
            $stmt->bindParam(':Correo', $Correo);
            $stmt->execute();
            return true;
        } catch (\PDOException $e) {
            echo "Error en setCode: " . $e->getMessage();
            return false;
        }
    }
    public function verifyCode($code)
    {
        try {
            $query = "SELECT * FROM usuario WHERE Code = :Code";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':Code', $code);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC); // Devuelve un solo resultado como array asociativo
        } catch (\PDOException $e) {
            // Manejar el error usando la funcion handleError
            return $this->handleError($e);
        }
    }
    public function changePassword($email, $newPassword)
    {
        try {
            $query = "UPDATE usuario SET Password = :newPassword WHERE Correo = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':newPassword', $newPassword);
            $stmt->bindParam(':email', $email);
            $result = $stmt->execute();
            return $result;
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
