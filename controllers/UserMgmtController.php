<?php

namespace Controllers;

use Model\UserMgmtModel;
use MVC\Router;

class UserMgmtController
{
    public static function getAllUsers()
    {
        $userMgmtModel = new UserMgmtModel();
        return $userMgmtModel->getAllUsers();
    }

    public static function getAllRoles()
    {
        $userMgmtModel = new UserMgmtModel();
        return $userMgmtModel->getAllRoles();
    }
    public static function asignarRol()
    {
        header('Content-Type: application/json');

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Método no permitido');
            }

            // Obtener los datos de la solicitud
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['idUsuario']) || empty($data['idRol'])) {
                throw new \Exception('El ID del usuario y el ID del rol son obligatorios');
            }

            $idUsuario = $data['idUsuario'];  // Cambiado a minúsculas
            $idRol = $data['idRol'];          // Cambiado a minúsculas

            // Instanciar el modelo de usuario
            $userMgmtModel = new UserMgmtModel();
            $asignacion = $userMgmtModel->asignarRol($idUsuario, $idRol);

            if ($asignacion) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Rol asignado correctamente'
                ]);
            } else {
                throw new \Exception('Error al asignar el rol');
            }
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    public static function quitarRol()
    {
        header('Content-Type: application/json');

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Método no permitido');
            }

            // Obtener los datos de la solicitud
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['idUsuario'])) {
                throw new \Exception('El ID del usuario es obligatorio');
            }

            $idUsuario = $data['idUsuario']; // Cambiado a minúsculas

            // Instanciar el modelo de usuario
            $userMgmtModel = new UserMgmtModel();
            $resultado = $userMgmtModel->quitarRol($idUsuario);

            if ($resultado) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Rol eliminado correctamente'
                ]);
            } else {
                throw new \Exception('Error al eliminar el rol');
            }
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
