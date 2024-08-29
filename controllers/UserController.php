<?php

namespace Controllers;

use Model\UserModel;
use Controllers\SessionController;
use MVC\Router;

class UserController
{
    public static function indexRegister(Router $router)
    {
        $error = ''; // Inicializar variable de error
        $router->render('auth/register', [
            'error' => $error
        ]);
    }

    public static function indexLogin(Router $router)
    {
        $error = ''; // Inicializar variable de error
        $router->render('auth/login', [
            'error' => $error
        ]);
    }
    public static function register(Router $router)
    {
        $error = ''; // Inicializar variable de error
        // Lógica para registrar un nuevo usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del formulario
            $full_name = trim($_POST['full_name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            // Validar los datos
            if ($password !== $confirmPassword) {
                $error = "Las contraseñas no coinciden.";
            } else {
                $userModel = new UserModel();

                if ($userModel->findByEmail($email)) {
                    $error = "El correo ya está en uso.";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $userCreated = $userModel->createUser($full_name, $email, $hashedPassword);

                    if ($userCreated) {
                        header('Location: login');
                        exit();
                    } else {
                        $error = "Error al crear la cuenta. Inténtalo de nuevo.";
                    }
                }
            }
        }

        // Mostrar la vista con el mensaje de error
        $router->render('auth/register', [
            'error' => $error
        ]);
    }




    public static function login(Router $router)
    {
        $error = ''; // Inicializar variable de error

        // Lógica para iniciar sesión
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del formulario
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $userModel = new UserModel();
            $sessionController = new SessionController();

            // Validar los datos
            $userData = $userModel->findByEmail($email, 'email');
            if (!$userData) {
                $error = "El correo que has introducido no existe.";
            } else {
                if (!password_verify($password, $userData['password'])) {
                    $error = "La contraseña es incorrecta.";
                } else {
                    // Iniciar sesión
                    $sessionController->startSession();
                    $_SESSION['user_id'] = $userData['id_user']; // Guardar el ID del usuario en la sesión

                    if ($userData['is_admin'] == 1) {
                        header('Location: admin/');
                    } else {
                        header('Location: /');
                    }
                    exit();
                }
            }
        }

        // Renderizar la vista con el mensaje de error
        $router->render('auth/login', [
            'error' => $error
        ]);
    }

    public static function logout()
    {
        // Iniciar la sesión si aún no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si la sesión está activa
        if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['user_id'])) {
            // Obtener el ID del usuario de la sesión
            $userId = $_SESSION['user_id'];

            // Actualizar el estado del usuario a inactivo
            $userModel = new UserModel();
            $userModel->setInactive($userId);

            // Destruir la sesión
            $sessionController = new SessionController();
            $sessionController->destroySession();

            // Redirigir a la página de inicio
            header('Location: /');
            exit();
        } else {
            // La sesión no está activa o no hay un ID de usuario en la sesión
            echo "La sesión no está activa o el usuario no está conectado.";
        }
    }
}
/*
    public function updatePassword()
    {
        // Lógica para cambiar la contraseña
    }

    public function forgotPassword()
    {
        // Lógica para recuperación de contraseña
    }
*/
