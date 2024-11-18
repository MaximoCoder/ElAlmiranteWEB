<?php
// controllers/VentasController.php

namespace Controllers;

use MVC\Router;
use Model\VentaModel;
use PDOException;
use Dompdf\Dompdf;
use Dompdf\Options;


class VentasController {

    public static function renderAdminView(Router $router, $viewName)
    {
        $VentaModel = new VentaModel();
        $platillos = $VentaModel->getAllProducts();

        $router->render('admin/Ventas', [
            'platillos' => $platillos,
        ], 'layoutAdmin');
    }

    public static function getPlatillos()
    {
        $adminModel = new AdminModel();
        $platillos = $adminModel->getData('platillo');
    
        var_dump($platillos); // Esto te permitirá ver si los datos están siendo recuperados correctamente
        return $platillos;
    }
    
    public static function listarPlatillos(Router $router)
    {
        $ventaModel = new VentaModel();
        $platillos = $ventaModel->getAllProducts();
    
        $router->render('admin/Ventas', [
            'platillos' => $platillos
        ], 'layoutAdmin');
    }
    

    public static function getDetalleVenta(Router $router)
    {
        $ventaModel = new VentaModel();
        $platillos = $ventaModel->getAllDetalleVenta();

        $router->render('admin/Ventas', [
            'platillos' => $platillos,
            
        ], 'layoutAdmin');
    }
    public static function generarDetalleVentaPdf($params)
    {
        $platilloId = $params['platilloId'] ?? null;
    
        if ($platilloId) {
            $ventaModel = new VentaModel();
            $venta = $ventaModel->getVentaByPlatillo($platilloId);
            $detalles = $ventaModel->getDetalleVentaByPlatillo($platilloId);
    
            if (!$venta) {
                echo "Error: Venta no encontrada.";
                return;
            }
    
            try {
                // Configurar opciones para Dompdf
                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isRemoteEnabled', true);
    
                $dompdf = new Dompdf($options);
                
                // Generar contenido HTML del PDF
                ob_start();
                include __DIR__ . '/../views/templates_detalleVentas/detalleVentaTemplate.php';
                $html = ob_get_clean();
    
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
    
                // Descargar PDF
                $dompdf->stream('Detalle_Venta_' . $platilloId . '.pdf', ['Attachment' => true]);
    
            } catch (\Exception $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al generar el PDF: ' . $e->getMessage()
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo encontrar la venta.'
            ]);
        }
    }
    
    public static function generarDetalleOrdenPdf($params)
    {
        $ordenId = $params['ordenId'] ?? null;
    
        if ($ordenId) {
            // Lógica para generar el PDF
        } else {
            echo "Error: ID de orden no proporcionado.";
        }
    }


    public static function getDetalleVentas(Router $router)
    {
        $ventaModel = new VentaModel();
        // Obtener platillos con sus ventas totales
        $platillos = $ventaModel->getAllDetalleVenta();
    
        $router->render('admin/Ventas', [
            'platillos' => $platillos,
        ], 'layoutAdmin');
    }
    public static function generarTopPlatillosPdf()
    {
        $ventaModel = new VentaModel();
        $platillos = $ventaModel->getTopPlatillosVendidos();
    
        // Verificación si no hay datos
        if (!$platillos) {
            echo "No se encontraron platillos vendidos.";
            return;
        }
    
        try {
            // Configurar Dompdf
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            
            $dompdf = new Dompdf($options);
    
            // Generar el contenido HTML para el PDF
            ob_start();
            include __DIR__ . '/../views/templates_detalleVentas/top-platillos-pdf.php';
            $html = ob_get_clean();
    
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
    
            // Descargar el PDF
            $dompdf->stream('Top_Platillos_Mas_Vendidos.pdf', ['Attachment' => true]);
    
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al generar el PDF: ' . $e->getMessage()
            ]);
        }
    }

    public static function generarTopPlatillosMenosVendidosPdf()
    {
        $ventaModel = new VentaModel();
        $platillos = $ventaModel->getTopPlatillosMenosVendidos();
    
        // Verificación si no hay datos
        if (!$platillos) {
            echo "No se encontraron platillos vendidos.";
            return;
        }
    
        try {
            // Configurar Dompdf
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            
            $dompdf = new Dompdf($options);
    
            // Generar el contenido HTML para el PDF
            ob_start();
            include __DIR__ . '/../views/templates_detalleVentas/top-platillosdes-pdf.php';
            $html = ob_get_clean();
    
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
    
            // Descargar el PDF
            $dompdf->stream('Top_Platillos_Menos_Vendidos.pdf', ['Attachment' => true]);
    
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al generar el PDF: ' . $e->getMessage()
            ]);
        }
    }
    public function showTopSellingDishesChart()
{
    $model = new VentaModel();
    $data = $model->getTopSellingDishes();
    
    echo json_encode($data);
}
// VentaController.php
public function showMonthlyIncomeChart()
{
    header('Content-Type: application/json');

    try {
        $model = new VentaModel(); // Crear instancia del modelo
        $datos = $model->getMonthlyIncome();

        // Verificamos si los datos fueron obtenidos correctamente
        if ($datos) {
            // Creamos los arrays para etiquetas y valores
            $labels = array_column($datos, 'Mes');
            $values = array_column($datos, 'TotalIngresos');

            echo json_encode([
                'labels' => $labels,
                'values' => $values
            ]);
        } else {
            echo json_encode([
                'labels' => [],
                'values' => []
            ]);
        }
    } catch (\Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}


}
    
    

    
    
