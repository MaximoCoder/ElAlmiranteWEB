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

    // Funcion para eliminar un usuario
    public static function eliminarUsuario($idUsuario)
    {
        header('Content-Type: application/json');

        try {
            // Verificar el metodo HTTP
            if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
                throw new \Exception('Método no permitido');
            }

            // Obtener el cuerpo de la solicitud
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            if (!isset($data['IdUsuario'])) {
                throw new \Exception('El ID del usuario es requerido');
            }

            $idUsuario = $data['IdUsuario'];

            // Instanciar el modelo de usuario
            $userMgmtModel = new UserMgmtModel();
            $userDelete = $userMgmtModel->deleteUser($idUsuario);

            if ($userDelete) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Usuario eliminado correctamente'
                ]);
            } else {
                throw new \Exception('Error al eliminar usuario');
            }
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // Funcion para editar un usuario
    public static function editarUsuario($idUsuario)
    {
        header('Content-Type: application/json');

        try {
            // Verificar el metodo HTTP
            if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
                throw new \Exception('Método no permitido');
            }

            // Obtener el cuerpo de la solicitud
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['IdUsuario'])) {
                throw new \Exception('El ID del usuario es requerido');
            }

            $idUsuario = $data['IdUsuario'];
            $Nombre = $data['Nombre'];
            $Correo = $data['Correo'];
            $Estado = $data['Estado'] === 'Activo' ? 1 : 0;

            // Instanciar el modelo de usuario
            $userMgmtModel = new UserMgmtModel();
            $userUpdate = $userMgmtModel->updateUser($idUsuario, $Nombre, $Correo, $Estado);

            if ($userUpdate) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Usuario actualizado correctamente'
                ]);
            } else {
                throw new \Exception('Error al actualizar usuario');
            }
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // Funcion para registrar un rol
    public static function registrarRol()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data['NombreRol']) || empty($data['DescripciónRol'])) {
                echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios']);
                return;
            }

            $NombreRol = $data['NombreRol'];
            $DescripciónRol = $data['DescripciónRol'];

            // Instanciar el modelo de usuario
            $userMgmtModel = new UserMgmtModel();
            $userMgmtModel->crearRol($NombreRol, $DescripciónRol);

            // Crear el rol
            $rolCreate = $userMgmtModel->crearRol($NombreRol, $DescripciónRol);

            //Redirigir a la vista de Gestion de Usuarios o mostrar un error
            if ($rolCreate) {
                echo json_encode(['status' => 'success', 'message' => 'Rol creado correctamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al crear el rol']);
            }
        }
    }

    // Funcion para eliminar un rol
    public static function eliminarRol($idRol)
    {
        header('Content-Type: application/json');

        try {
            // Verificar el metodo HTTP
            if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
                throw new \Exception('Método no permitido');
            }

            // Obtener el cuerpo de la solicitud
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            if (!isset($data['IdRol'])) {
                throw new \Exception('El ID del rol es requerido');
            }

            $idRol = $data['IdRol'];

            // Instanciar el modelo de usuario
            $userMgmtModel = new UserMgmtModel();
            $rolDelete = $userMgmtModel->eliminarRol($idRol);

            if ($rolDelete) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Rol eliminado correctamente'
                ]);
            } else {
                throw new \Exception('Error al eliminar rol');
            }
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    // Funcion para editar un rol
    public static function editarRol($idRol)
    {
        header('Content-Type: application/json');

        try {
            // Verificar el metodo HTTP
            if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
                throw new \Exception('Método no permitido');
            }

            // Obtener el cuerpo de la solicitud
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            if (!isset($data['IdRol'])) {
                throw new \Exception('El ID del rol es requerido');
            }

            $idRol = $data['IdRol'];
            $NombreRol = $data['NombreRol'];
            $DescripciónRol = $data['DescripciónRol'];

            // Instanciar el modelo de usuario
            $userMgmtModel = new UserMgmtModel();
            $rolUpdate = $userMgmtModel->editarRol($idRol, $NombreRol, $DescripciónRol);

            if ($rolUpdate) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Rol actualizado correctamente'
                ]);
            } else {
                throw new \Exception('Error al actualizar rol');
            }
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
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

        if (empty($data['IdUsuario']) || empty($data['IdRol'])) {
            throw new \Exception('El ID del usuario y el ID del rol son obligatorios');
        }

        $idUsuario = $data['IdUsuario'];
        $idRol = $data['IdRol'];

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
}
