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

        // Suponiendo que has guardado el ID de usuario en la sesión al hacer login
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
    public function destroySession()
    {
        // Destruir la sesión
        if (session_status() !== PHP_SESSION_NONE) {
            session_unset();
            session_destroy();
        }
    }

    public function checkSession()
    {
        // Verificar si la sesión está activa
        return isset($_SESSION['user_id']);
    }
}
