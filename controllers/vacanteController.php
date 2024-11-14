<?php

namespace Controllers;

use Model\vacanteModel;
use MVC\Router;

// Funcion para registrar una nueva vacante
class vacanteController{
    public static function renderVacanteView(Router $router, $viewName)
    {
        $error = ''; // Inicializar variable de error
        $router->render('admin/' . $viewName, [
            'error' => $error
        ]);
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

            // Crear instancia del modelo
            $vacanteModel = new vacanteModel();

            // Crear la vacante
            $vacanteCreate = $vacanteModel->createVacante($nombreVacante, $descripcionVacante);

            // Redirigir a la vista de vacante o mostrar un error
            echo json_encode(
                $vacanteCreate
                    ? ['status' => 'success', 'message' => 'Vacante creada correctamente.']
                    : ['status' => 'error', 'message' => 'Error al crear la vacante.']
            );
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
            return;
        }
    }
}