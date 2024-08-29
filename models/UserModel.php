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
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(); // Devuelve un solo resultado o false si no existe
    }

    public function createUser($full_name, $email, $password)
    {
        $query = "INSERT INTO users (full_name, email, password, is_admin ,date_joined) VALUES (:full_name, :email, :password, 0, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        return $stmt->execute(); // Devuelve true en caso de éxito, false en caso contrario
    }

    // Método para obtener los datos de un usuario
    public function getUserData($value, $field = 'id_user')
    {
        $query = "SELECT * FROM users WHERE $field = :value";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        $userData = $stmt->fetch();
        return $userData;
    }
    // metodo para verificar el password

    public function verifyPassword($userId, $password)
    {
        $query = "SELECT password FROM users WHERE id_user = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        $userData = $stmt->fetch();
        if (password_verify($password, $userData['password'])) {
            //Mostrar que esta activo al campo is_active
            $stmt = $this->db->query("UPDATE users SET is_active = 1 WHERE id_user = $userId");
            $stmt->execute();
            return true;
        } else {
            return false;
        }
    }
    // FUNCIONES PARA MOSTRAR ACTIVO O INACTIVO AL USUARIO
    public function setActive($userId) {
        $query = "UPDATE users SET is_active = 1 WHERE id_user = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
    }
    public function setInactive($userId) {
        $query = "UPDATE users SET is_active = 0 WHERE id_user = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
    }
}
