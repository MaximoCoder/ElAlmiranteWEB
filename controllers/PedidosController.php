<?php
// controllers/PedidosController.php

namespace Controllers;

use Model\PedidosModel;
use MVC\Router;

class PedidosController
{


    // Obtener todos los pedidos con estado "PENDIENTE"
    public static function getPedidosPendientes()
    {
        try {
            // Instanciar el modelo de pedidos
            $pedidosModel = new PedidosModel();
            $pedidos = $pedidosModel->getPedidosPendientes();
            // Retornar los pedidos obtenidos
            return $pedidos;
        } catch (\PDOException $e) {
            // Manejar el error utilizando una función de manejo de errores
            return self::handleError($e);
        }
    }
    // Obtener todos los pedidos con estado "Completada"
    public static function getPedidosCompletados()
    {
        try {
            // Instanciar el modelo de pedidos
            $pedidosModel = new PedidosModel();
            $pedidosCompletados = $pedidosModel->getPedidosCompletados();
            // Retornar los pedidos obtenidos
            return $pedidosCompletados;
        } catch (\PDOException $e) {
            // Manejar el error utilizando una función de manejo de errores
            return self::handleError($e);
        }
    }

    // Funcion para marcar el pago como completado
    public static function updatePaymentStatus()
    {
        // Obtener el cuerpo de la solicitud
        $data = json_decode(file_get_contents('php://input'), true);

        // Validar que se recibió el ID de venta
        if (isset($data['idVenta'])) {
            $idVenta = $data['idVenta'];
        }

        // Instanciar al modelo
        $pedidosModel = new PedidosModel();
        // Datos a actualizar
        $updateData = ['EstadoPago' => 'Completado'];

        // Condición para el WHERE
        $whereCondition = ['IdVenta' => $idVenta];

        // Llamar al método del modelo para realizar la actualización
        try {
            $rowsUpdated = $pedidosModel->updateData($updateData, 'venta', $whereCondition);

            if ($rowsUpdated > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Estado de pago actualizado correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se pudo encontrar la venta']);
            }
        } catch (\Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el estado de pago.', 'details' => $e->getMessage()]);
        }
    }

    // Funcion para actualizar el estado de la orden
    public static function updateOrderStatus()
    {
        // Obtener el cuerpo de la solicitud
        $data = json_decode(file_get_contents('php://input'), true);

        // Validar que se recibió el ID de venta y id Orden
        if (isset($data['idOrden']) && isset($data['idVenta'])) {
            $idOrden = $data['idOrden'];
            $idVenta = $data['idVenta'];
        }
        // Instanciar al modelo
        $pedidosModel = new PedidosModel();

        // Datos a actualizar
        $updateDataOrden = ['EstadoOrden' => 'Completada'];
        $updateDataVenta = ['EstadoVenta' => 'Completada'];
        // Condición para el WHERE
        $whereConditionOrden = ['IdOrden' => $idOrden];
        $whereConditionVenta = ['IdVenta' => $idVenta];

        // Llamar al método del modelo para realizar la actualización
        try {
            $rowsUpdatedOrden = $pedidosModel->updateData($updateDataOrden, 'orden', $whereConditionOrden);
            $rowsUpdatedVenta = $pedidosModel->updateData($updateDataVenta, 'venta', $whereConditionVenta);
            // Verificar si ambas actualizaciones se realizaron correctamente
            if ($rowsUpdatedOrden > 0 && $rowsUpdatedVenta > 0) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'El estado de la orden y la venta se actualizaron correctamente.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No se encontraron registros para actualizar.'
                ]);
            }
        } catch (\Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el estado de pago.', 'details' => $e->getMessage()]);
        }
    }
    public static function handleError($e)
    {
        // Handle the error here, e.g., log it, return an error message, etc.
        echo "Error: " . $e->getMessage();
    }
}
