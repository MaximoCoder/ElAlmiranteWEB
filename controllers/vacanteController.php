<?php

namespace Controllers;

use Model\vacanteModel;
use MVC\Router;

// Funcion para registrar una nueva vacante
class VacanteController
{

    public static function getAllVacantes()
    {
        $vacanteModel = new vacanteModel();
        return $vacanteModel->getAllVacantes();
    }

    public static function registroVacante()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['nombreVacante']) || empty($data['descripcionVacante'])) {
                echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios.']);
                return;
            }

            $nombreVacante = $data['nombreVacante'];
            $descripcionVacante = $data['descripcionVacante'];
            $disponibilidadVacante = $data['Activa'];

            // Validar la disponibilidad
            if ($disponibilidadVacante == 'Disponible') {
                $activa = 1;
            } else {
                $activa = 0;
            }

            // Crear instancia del modelo
            $vacanteModel = new vacanteModel();

            // Crear la vacante
            $vacanteCreate = $vacanteModel->createVacante($nombreVacante, $descripcionVacante, $activa);

            // Redirigir a la vista de vacante o mostrar un error
            if ($vacanteCreate) {
                echo json_encode(['status' => 'success', 'message' => 'Vacante creada correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al crear la vacante.']);
            }

            // Redirigir a la vista de vacante o mostrar un error
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
            return;
        }
    }

    public static function eliminarVacante()
    {
        header('Content-Type: application/json');

        try {
            // Verificar el método HTTP
            if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
                throw new \Exception('Método no permitido');
            }

            // Obtener el cuerpo de la solicitud
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            if (!isset($data['idVacante'])) {
                throw new \Exception('El ID de la vacante es requerido');
            }

            $idVacante = $data['idVacante'];

            // Instanciar el modelo de vacante
            $vacanteModel = new vacanteModel();
            $vacanteDelete = $vacanteModel->deleteVacante($idVacante);

            if ($vacanteDelete) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Vacante eliminada correctamente'
                ]);
            } else {
                throw new \Exception('Error al eliminar la vacante');
            }
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    public static function editarVacante()
    {
        header('Content-Type: application/json');
        
        try {
            // Verificar el método HTTP
            if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
                throw new \Exception('Método no permitido');
            }
    
            // Obtener el cuerpo de la solicitud
            $data = json_decode(file_get_contents('php://input'), true);
    
            if (!isset($data['idVacante'])) {
                throw new \Exception('El ID de la vacante es requerido');
            }
    
            $idVacante = $data['idVacante'];
            $nombreVacante = $data['nombreVacante'];
            $descripcionVacante = $data['descripcionVacante'];
            $activa = $data['Activa'] === 'Disponible' ? 1 : 0;
    
            // Instanciar el modelo de vacante
            $vacanteModel = new vacanteModel();
            $vacanteUpdate = $vacanteModel->updateVacante($idVacante, $nombreVacante, $descripcionVacante, $activa);
    
            if ($vacanteUpdate) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Vacante actualizada correctamente'
                ]);
            } else {
                throw new \Exception('Error al actualizar la vacante');
            }
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
