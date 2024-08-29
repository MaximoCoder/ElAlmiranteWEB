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
        }

        // Suponiendo que has guardado el ID de usuario en la sesión al hacer login
        if (isset($_SESSION['user_id'])) {
            $userModel = new UserModel();
            $userData = $userModel->getUserData($_SESSION['user_id']); // Obtener datos del usuario

            if ($userData) {
                // Guardar los datos del usuario en la sesión
                $_SESSION['user'] = $userData;

                // Opcional: Puedes agregar una lógica adicional para actualizar el estado de la sesión
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
