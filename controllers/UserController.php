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
            $name = htmlspecialchars(trim($_POST['Nombre']), ENT_QUOTES, 'UTF-8');
            $email = filter_var(trim($_POST['Correo']), FILTER_SANITIZE_EMAIL);
            $Password = trim($_POST['Password']);
            $confirmPassword = trim($_POST['confirm_password']);

            // Validar los datos
            if ($Password !== $confirmPassword) {
                $error = "Las contraseñas no coinciden.";
            } else {
                $userModel = new UserModel();

                if ($userModel->findByEmail($email)) {
                    $error = "El correo ya está en uso.";
                } else {
                    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
                    $userCreated = $userModel->createUser($name, $email, $hashedPassword);

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
            $email = trim($_POST['Correo']);
            $Password = $_POST['Password'];

            $userModel = new UserModel();
            $sessionController = new SessionController();

            // Validar los datos
            $userData = $userModel->findByemail($email, 'Correo');
            if (!$userData) {
                $error = "El correo que has introducido no existe.";
            } else {
                if (!password_verify($Password, $userData['Password'])) {
                    $error = "La contraseña es incorrecta.";
                } else {
                    // Iniciar sesión
                    $sessionController->startSession();
                    $_SESSION['user_id'] = $userData['IdUsuario']; // Guardar el ID del usuario en la sesión
                    //Redririgir segun el rol PENDIENTE
                    header('Location: /');

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
        // Lógica para cambiar la Password
    }

    public function forgotPassword()
    {
        // Lógica para recuperación de Password
    }
*/
