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
        $error = ''; // Inicializar variable de error,d
        $router->render('auth/' . $viewName, [
            'error' => $error
        ]);
    }
    // Funcion para registrar un nuevo usuario 
    public static function apiRegister()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            $name = htmlspecialchars(trim($data['Nombre']), ENT_QUOTES, 'UTF-8');
            $email = filter_var(trim($data['Correo']), FILTER_SANITIZE_EMAIL);
            $password = trim($data['Password']);
            $confirmPassword = trim($data['confirm_password']);

            // verificar que el correo no este en uso
            $userModel = new UserModel();
            if ($userModel->findByEmail($email)) {
                echo json_encode(['status' => 'error', 'message' => 'El correo ya está en uso.']);
                return;
            }
            // validar que password sea igual a confirmar password
            if ($password !== $confirmPassword) {
                echo json_encode(['status' => 'error', 'message' => 'Las contraseñas no coinciden.']);
                return;
            }
            // Hashear la nueva contraseña antes de almacenarla
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // Crear el usuario
            $userCreated = $userModel->create($name, $email, $hashedPassword);
            // Redirigir a la vista de inicio de sesión o mostrar un error
            echo json_encode(
                $userCreated
                    ? ['status' => 'success', 'message' => 'Usuario registrado correctamente.']
                    : ['status' => 'error', 'message' => 'Error al crear la cuenta.']
            );
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
            return;
        }
    }

    public static function apiLogin()
    {
        header('Content-Type: application/json');

        // Lógica para iniciar sesión
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener los datos del formulario 
            $data = json_decode(file_get_contents('php://input'), true);
            $email = filter_var(trim($data['Correo']), FILTER_SANITIZE_EMAIL);
            $Password = trim($data['Password']);


            $userModel = new UserModel();
            $sessionController = new SessionController();

            // Validar los datos
            $userData = $userModel->findByemail($email, 'Correo');
            if (!$userData) {
                echo json_encode(['status' => 'error', 'message' => 'El correo que has introducido no existe.']);
                return;
            } else {
                if (!password_verify($Password, $userData['Password'])) {
                    echo json_encode(['status' => 'error', 'message' => 'La contraseña es incorrecta.']);
                    return;
                } else {
                    // Iniciar sesión
                    $sessionController->startSession();
                    $_SESSION['user_id'] = $userData['IdUsuario'];

                    // Obtener y guardar el rol del usuario
                    $userRole = $userModel->getUserRole($userData['IdUsuario']);
                    $_SESSION['user_role'] = $userRole;

                    // Redirigir según el rol
                    if ($userRole === 'Admin') {
                        //enviar el rol
                        echo json_encode(['status' => 'success', 'rol' => 'Admin']);
                    } else {
                        //enviar el rol
                        echo json_encode(['status' => 'success', 'rol' => 'User']);
                    }

                    exit();
                }
            }
        }
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
    public static function sendMailCode()
    {
        header('Content-Type: application/json');
        // Datos para enviar el correo
        $mailUser = $_ENV['MAIL_USERNAME'] ?? null;
        $mailPass = $_ENV['MAIL_PASSWORD'] ?? null;
        #echo "Mail: " . $MailUser . " Pass: " . $MailPass;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener los datos del formulario 
            $data = json_decode(file_get_contents('php://input'), true);
            $correo = filter_var(trim($data['Correo']), FILTER_SANITIZE_EMAIL);

            // Validar que el correo exista en la base de datos
            $userModel = new UserModel();
            $userVerify = $userModel->findByEmail($correo, 'Correo');
            if (!$userVerify) {
                echo json_encode(['status' => 'error', 'message' => 'El correo no existe.']);
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
                        // Redireccionar a la pagina que sigue y mostrar un mensaje de exito
                        echo json_encode(['status' => 'success', 'message' => 'El correo ha sido enviado.']);
                    } catch (Exception $e) {
                        // En caso de error, mostrar un mensaje de error
                        echo json_encode(['status' => 'error', 'message' => 'Error al enviar el correo:' . $mail->ErrorInfo]);
                        return;
                    }
                } else {
                    // Error al generar y guardar el codigo en la db
                    echo json_encode(['status' => 'error', 'message' => 'Lo sentimos, ha ocurrido un error. Por favor, intenta de nuevo.']);
                    return;
                }
            }
        }
    }
    // Lógica para cambiar la Password
    public static function verifyCode()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener los datos del formulario 
            $data = json_decode(file_get_contents('php://input'), true);
            // Obtener el código ingresado
            $code = htmlspecialchars(trim($data['Code']), ENT_QUOTES, 'UTF-8');

            // Verificar si el código es válido
            $userModel = new UserModel();
            $userData = $userModel->verifyCode($code);

            if (!$userData) {
                echo json_encode(['status' => 'error', 'message' => 'El codigo ingresado es invalido.']);
                return;
            } else {
                session_start();
                $_SESSION['user_email'] = $userData['Correo'];

                // Redireccionar a la pagina que sigue y mostrar un mensaje de exito
                echo json_encode(['status' => 'success', 'message' => 'El codigo es valido.']);
                exit();
            }
        }
    }

    public static function changePassword()
    {
        session_start(); // Iniciar la sesión
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_email'])) {
            // Si no hay un correo en la sesión, redirigir a la página de login o mostrar un error
            echo json_encode(['status' => 'error', 'message' => 'Lo sentimos, ocurrio un error.']);
            exit();
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtener los datos del formulario 
                $data = json_decode(file_get_contents('php://input'), true);
                $newPassword = htmlspecialchars(trim($data['newPassword']), ENT_QUOTES, 'UTF-8');
                $confirmPassword = htmlspecialchars(trim($data['confirmPassword']), ENT_QUOTES, 'UTF-8');
                $userEmail = $_SESSION['user_email'];  // Obtener el correo del usuario de la sesión

                // validar que new password sea igual a confirmar password
                if ($newPassword !== $confirmPassword) {
                    echo json_encode(['status' => 'error', 'message' => 'Las contraseñas no coinciden.']);
                    return;
                } else {
                    // Hashear la nueva contraseña antes de almacenarla
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    $userModel = new UserModel();
                    if ($userModel->changePassword($userEmail, $hashedPassword)) {
                        // Eliminar el correo de la sesión después de cambiar la contraseña
                        unset($_SESSION['user_email']);
                        // Redirigir a la página de login o mostrar un mensaje de exito
                        echo json_encode(['status' => 'success', 'message' => 'La contraseña ha sido cambiada.']);
                        exit();
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error al intentar cambiar la contraseña.']);
                        return;
                    }
                }
            }
        }
    }
}
