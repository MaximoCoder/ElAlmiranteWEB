<?php

namespace Controllers;

use MVC\Router;
use Dotenv\Dotenv; // PARA VARIABLES DE ENTORNO
use Model\VentaModel; // PARA CREAR UNA VENTA,ORDEN, DETALLE DE VENTA Y DETALLE DE ORDEN
use Dompdf\Dompdf; // PARA CREAR EL TICKET
use Controllers\SessionController; // PARA VERIFICAR SESIÓN  Y OBTENER USUARIO


// Cargar el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
class PaymentController
{
    //Funcion para procesar el pago en tienda fisica.
    public static function pagoPendiente()
    {
        session_start();

        $userData = new SessionController();
        $isLoggedIn = $userData->checkSession();
        if (!$isLoggedIn) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Por favor inicia sesión para proceder al pago.'
            ]);
            exit();
        }

        $ventaModel = new VentaModel();

        $cart = $_SESSION['cart'];
        $total = 0;
        $nota = $_POST['observaciones'] ?? '';

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        try {
            $ventaId = $ventaModel->createVenta(
                $userData->getUser()['IdUsuario'],
                date('Y-m-d H:i:s'),
                $total,
                'pago en tienda',
                'Pendiente',
                null,  // No hay IdPagoENLINEA
                'pendiente'
            );

            $ordenId = $ventaModel->createOrden(
                $ventaId,
                $userData->getUser()['IdUsuario'],
                date('Y-m-d H:i:s'),
                $total,
                'Pendiente',
                $nota
            );

            foreach ($cart as $item) {
                $ventaModel->createDetalleVenta(
                    $ventaId,
                    $item['id'],
                    $item['quantity'],
                    $item['price']
                );

                $ventaModel->createDetalleOrden(
                    $ordenId,
                    $item['id'],
                    $item['quantity'],
                    $item['price']
                );
            }

            $_SESSION['session_id'] = $ventaId;

            // Limpiar el carrito después de registrar el pago pendiente
            unset($_SESSION['cart']);

            // Generar el ticket inmediatamente después de crear la venta
            self::createTicket(['ventaId' => $ventaId]);

            // Redirigir a la ruta de mostrar ticket
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Pedido registrado correctamente',
                'venta_id' => $ventaId,
                'redirect_url' => "/tickets/show-{$ventaId}"
            ]);
            exit();
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Hubo un error al registrar el pago pendiente: ' . $e->getMessage()
            ]);
        }
    }


    public static function checkout()
    {
        // Inicia la sesión para almacenar los detalles de la orden
        session_start();
        // Recupera los datos JSON enviados en la solicitud
        $data = file_get_contents('php://input');
        // Crea una instancia de la clase SessionController
        $userData = new SessionController();
        // Extrae los detalles de la orden del JSON
        $json = json_decode($data, true);
        $pedidos = $json['pedidos'];
        $productos = $json['productos'];
        // Recibe la nota
        $nota = $_POST['observaciones'] ?? '';
        if (is_array($pedidos) && is_array($productos)) {
            // Id del usuario
            $IdCliente = $userData->getUser()['IdUsuario'];
            $MontoTotal = $pedidos['purchase_units'][0]['amount']['value'];
            $FechaVenta = date('Y-m-d H:i:s');
            $nombre = $pedidos['payer']['name']['given_name'];
            $apellido = $pedidos['payer']['name']['surname'];
            $direccion = $pedidos['purchase_units'][0]['shipping']['address']['address_line_1'];
            $ciudad = $pedidos['purchase_units'][0]['shipping']['address']['admin_area_2'];
            $status = $pedidos['status'];
            $order_id = $pedidos['id'];

            // Crea una instancia de la clase VentaModel
            $ventaModel = new VentaModel();
            // Crea una nueva venta
            $ventaId = $ventaModel->createVenta(
                $IdCliente,
                $FechaVenta,
                $MontoTotal,
                'Pago en linea',
                'Completado',
                $order_id,
                'pendiente'
            );
            // Crea una nueva orden
            $ordenId = $ventaModel->createOrden(
                $ventaId,
                $IdCliente,
                $FechaVenta,
                $MontoTotal,
                'Pendiente',
                $nota
            );
            
            // Crea los detalles de la venta y la orden
            foreach ($productos as $item) {
                $ventaModel->createDetalleVenta(
                    $ventaId,
                    $item['id'],
                    $item['quantity'],
                    $item['price']
                );
                $ventaModel->createDetalleOrden(
                    $ordenId,
                    $item['id'],
                    $item['quantity'],
                    $item['price']
                );
            }

            $_SESSION['session_id'] = $ventaId;

            // Limpiar el carrito después de registrar el PAGO EN PAYPAL
            unset($_SESSION['cart']);

            // Generar el ticket inmediatamente después de crear la venta
            self::createTicket(['ventaId' => $ventaId]);

            // Redirigir a la ruta de mostrar ticket
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Pago realizado correctamente',
                'venta_id' => $ventaId,
                'redirect_url' => "/tickets/show-{$ventaId}"
            ]);
            exit();
        }
    }

    public static function createTicket($params)
    {
        //session_start();

        $ventaId = $params['ventaId'] ?? null;

        if ($ventaId) {
            $ventaModel = new VentaModel();
            $venta = $ventaModel->getVentaById($ventaId);
            $detalles = $ventaModel->getDetalleVentaById($ventaId);

            if (!$venta) {
                echo "Error: Venta no encontrada.";
                return;
            }

            try {
                // Cargar el contenido del archivo HTML
                $htmlTemplate = file_get_contents(__DIR__ . '/../views/templates_tickets/ticket.html');

                // Datos de la empresa
                $datosEmpresa = [
                    'nombre' => 'Mariscos El Almirante',
                    'direccion' => 'Valle de Santa María, 66670 Pesquería, N.L.',
                    'telefono' => '+52 81 8277 7311',
                    'rfc' => 'XAXX010101000'
                ];

                // Generar el HTML de los detalles
                $detallesHtml = '';
                $total = 0;

                foreach ($detalles as $detalle) {
                    $subtotal = $detalle['Subtotal'];
                    $total += $subtotal;

                    $detallesHtml .= sprintf(
                        "<tr>
                        <td>%s</td>
                        <td>%d</td>
                        <td>$%.2f</td>
                        <td>$%.2f</td>
                        </tr>",
                        htmlspecialchars($detalle['nombre_producto']),
                        $detalle['Cantidad'],
                        number_format($detalle['PrecioUnitario'], 2),
                        number_format($detalle['Subtotal'], 2)
                    );
                }

                // Reemplazar la sección Twig de los detalles con el HTML generado
                $htmlTemplate = preg_replace_callback(
                    '/{% for detalle in detalles %}.*?{% endfor %}/s',
                    function () use ($detallesHtml) {
                        return $detallesHtml;
                    },
                    $htmlTemplate
                );

                // validar el TipoPago de la venta, Si es pago en tienda, mostrar instrucciones
                if ($venta['TipoPago'] == 'pago en tienda') {
                    $htmlTemplate = preg_replace_callback(
                        '/{{ nota }}/s',
                        function () {
                            return 'Muestra este ticket, para realizar el pago en tienda';
                        },
                        $htmlTemplate
                    );
                }
                // Reemplazar las demás variables
                $replacements = [
                    '{{ empresa.nombre }}' => $datosEmpresa['nombre'],
                    '{{ empresa.direccion }}' => $datosEmpresa['direccion'],
                    '{{ empresa.telefono }}' => $datosEmpresa['telefono'],
                    '{{ empresa.rfc }}' => $datosEmpresa['rfc'],
                    '{{ venta.IdVenta }}' => htmlspecialchars($venta['IdVenta']),
                    '{{ fecha }}' => date('d/m/Y H:i:s', strtotime($venta['FechaVenta'])),
                    '{{ venta.TipoPago }}' => htmlspecialchars($venta['TipoPago']),
                    '{{ total }}' => number_format($total, 2)
                ];

                // Realizar todas las sustituciones
                $html = str_replace(
                    array_keys($replacements),
                    array_values($replacements),
                    $htmlTemplate
                );

                // Opciones de Dompdf
                $options = new \Dompdf\Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isPhpEnabled', true);
                $options->set('isRemoteEnabled', true);

                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A5');
                $dompdf->render();
                // Guardar el ticket en el servidor
                $uploadDir = __DIR__ . '/../uploads/tickets';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                // Generar un nombre de archivo unico
                $filename = 'ticket_' . $ventaId . '_' . uniqid() . '.pdf';
                $filePath = $uploadDir . '/' . $filename;

                file_put_contents($filePath, $dompdf->output());

                $_SESSION['ticket_path'] = $filePath;
            } catch (\Exception $e) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al generar el ticket: ' . $e->getMessage()
                ]);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo encontrar la venta.'
            ]);
        }
    }

    public static function showTicket($filePath, $ventaId)
    {
        if (file_exists($filePath)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
            header('Cache-Control: no-cache, no-store, must-revalidate');
            readfile($filePath);

            // Limpiamos las variables de sesión relacionadas con la venta
            if (isset($_SESSION['venta_id'])) {
                unset($_SESSION['venta_id']);
            }
            if (isset($_SESSION['ticket_path'])) {
                unset($_SESSION['ticket_path']);
            }
        } else {
            // Enviar respuesta de error
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo encontrar el archivo de ticket.'
            ]);
        }
    }
}
