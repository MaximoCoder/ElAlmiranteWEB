<?php

namespace Controllers;

require __DIR__ . '/../vendor/autoload.php';

use Model\UserModel;
use Controllers\SessionController;
use MVC\Router;
// PARA ENVIO DE CORREOS
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// PARA TEMPLATE DE CORREO
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
// PARA CONTRASEÑAS Y COSAS CONFIDENCIALES
use Dotenv\Dotenv;

class UserController
{
    public function __construct()
    {
        // Cargar el archivo .env
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }
    // Método genérico para renderizar cualquier vista de autenticación
    public static function renderAuthView(Router $router, $viewName)
    {
        $error = ''; // Inicializar variable de error
        $router->render('auth/' . $viewName, [
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
    public static function sendMailCode(Router $router)
    {
        $mailUser = $_ENV['MAIL_USERNAME'] ?? null;
        $mailPass = $_ENV['MAIL_PASSWORD'] ?? null;
        #echo "Mail: " . $MailUser . " Pass: " . $MailPass;
        $error = ''; // Inicializar variable de error
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['Correo'];

            // Validar que el correo exista en la base de datos
            $userModel = new UserModel();
            $userVerify = $userModel->findByEmail($correo, 'Correo');
            if (!$userVerify) {
                $error = 'El correo no existe';
                return;
            } else {
                // Guardar el nombre del usuario  
                $username = $userVerify['Nombre'];
                // Generar un código de verificación
                $codigo = rand(10000, 99999);

                // Enviar el código a la base de datos
                if ($userSetCode = $userModel->setCode($correo, $codigo)) {
                    // Configurar PHPMailer
                    $mail = new PHPMailer(true);

                    try {
                        // Configuración del servidor SMTP
                        $mail->SMTPDebug = 0;
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        // Obtener credenciales desde el archivo .env
                        $mail->Username = $mailUser;
                        $mail->Password = $mailPass;
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        // Remitente y destinatario
                        $mail->setFrom('mariscoselalmiranteweb@gmail.com', 'Mariscos El Almirante');
                        $mail->addAddress($correo);

                        // Configurar Twig para cargar plantillas desde la carpeta "views/templates_email"
                        $loader = new FilesystemLoader(__DIR__ . '/../views/templates_email');
                        $twig = new Environment($loader);

                        // Cargar la plantilla Twig y pasarle el código como variable
                        $htmlContent = $twig->render('AuthCode.html.twig', ['code' => $codigo, 'username' => $username]);

                        // Contenido del correo
                        $mail->isHTML(true);
                        $mail->Subject = 'Recuperacion de clave de acceso a Mariscos El Almirante';
                        $mail->Body = $htmlContent;

                        // Enviar el correo
                        $mail->send();

                        //Redireccionar a changePassword
                        header('Location: verify-Code');
                    } catch (Exception $e) {
                        $error =  "Error al enviar el correo: {$mail->ErrorInfo}";
                    }
                } else {
                    $error = 'Error al guardar el código en la base de datos';
                }
            }
        }

        // Mostrar la vista con el mensaje de error
        $router->render('auth/forgot-Password', [
            'error' => $error
        ]);
    }
    // Lógica para cambiar la Password
    public static function verifyCode(Router $router)
    {
        $error = ''; // Inicializar variable de error

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener el código ingresado
            $code = htmlspecialchars(trim($_POST['Code']), ENT_QUOTES, 'UTF-8');

            // Verificar si el código es válido
            $userModel = new UserModel();
            $userData = $userModel->verifyCode($code); // Asumiendo que tienes un método para buscar por código

            if (!$userData) {
                $error = 'El código ingresado es inválido.';
            } else {
                session_start();
                $_SESSION['user_email'] = $userData['Correo'];

                // Redirigir a la vista de cambiar la Password
                header('Location: change-Password');
                exit();
            }
        }

        // Renderizar la vista con el mensaje de error
        $router->render('auth/verify-Code', [
            'error' => $error
        ]);
    }

    public static function changePassword(Router $router)
    {
        session_start(); // Iniciar la sesión
        $error = ''; // Inicializar variable de error

        if (!isset($_SESSION['user_email'])) {
            // Si no hay un correo en la sesión, redirigir a la página de login o mostrar un error
            header('Location: login');
            exit();
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $newPassword = htmlspecialchars(trim($_POST['newPassword']), ENT_QUOTES, 'UTF-8');
                $confirmPassword = htmlspecialchars(trim($_POST['confirmPassword']), ENT_QUOTES, 'UTF-8');
                $userEmail = $_SESSION['user_email'];  // Obtener el correo del usuario de la sesión

                // validar que new password sea igual a confirmar password
                if ($newPassword !== $confirmPassword) {
                    $error = 'Las contraseñas no coinciden.';
                } else {
                    // Hashear la nueva contraseña antes de almacenarla
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    $userModel = new UserModel();
                    if ($userModel->changePassword($userEmail, $hashedPassword)) {
                        // Eliminar el correo de la sesión después de cambiar la contraseña
                        unset($_SESSION['user_email']);
                        header('Location: login');
                        exit();
                    } else {
                        $error = 'Error al intentar cambiar la contraseña.';
                    }
                }
            }
        }

        // Renderizar la vista con el mensaje de error  
        $router->render('auth/change-Password', [
            'error' => $error
        ]);
    }
}
