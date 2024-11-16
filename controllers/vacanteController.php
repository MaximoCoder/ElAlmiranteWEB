<?php

namespace Controllers;

use Model\VacanteModel;
use MVC\Router;

// Funcion para registrar una nueva vacante
class VacanteController{
    
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
            $disponibilidadVacante = $data['disponibilidadVacante'];

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
            if($vacanteCreate){
                echo json_encode(['status' => 'success', 'message' => 'Vacante creada correctamente.']);
            }else {
                echo json_encode(['status' => 'error', 'message' => 'Error al crear la vacante.']);
            }

            // Redirigir a la vista de vacante o mostrar un error
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
            return;
        }
    }
}