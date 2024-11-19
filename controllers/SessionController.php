<?php

namespace Controllers;

use Model\UserModel;

class SessionController
{
    public function startSession()
    {
        // Iniciar la sesión si no ha sido iniciada previamente
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            session_regenerate_id(); // Regenerar el ID de sesión para prevenir fijación de sesión
        }

        // Suponiendo que has guardado el ID de usuario en la sesión al hacer login,d
        if (isset($_SESSION['user_id'])) {
            $userModel = new UserModel();
            $userData = $userModel->getUserData($_SESSION['user_id']); // Obtener datos del usuario
            $userRole = $userModel->getUserRole($_SESSION['user_id']); // Obtener el rol
            // Asegurarse de que los datos del usuario se cargan correctamente
            if ($userData) {
                $_SESSION['user'] = $userData;
                $_SESSION['user_role'] = $userRole ?: 'User'; // Asignar rol 'User' si no es Admin
                $userModel->setActive($_SESSION['user_id']);
            } else {
                // Si no se encontraron datos del usuario, destruir la sesión
                $this->destroySession();
            }
        }
    }

    public function getUser()
    {
        // Devolver los datos del usuario desde la sesión
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }
    // FUNCION PARA VALIDAR SI ES ADMIN

    public static function requireAdmin()
    {
        // Iniciar la sesión si no ha sido iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si el usuario es administrador
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
            // Redirigir al usuario si no es Admin
            header('Location: /');
            exit;
        }
    }
    public function destroySession()
    {
        // Destruir la sesión
        if (session_status() !== PHP_SESSION_NONE) {
            // Eliminar únicamente las variables relacionadas con el usuario
            unset($_SESSION['user_id']);
            unset($_SESSION['user']);
            unset($_SESSION['user_role']);
        }
    }

    public function checkSession()
    {
        // Verificar si la sesión está activa
        return isset($_SESSION['user_id']);
    }
}
