<?php

namespace MVC;

class Router
{
    public $routesGET = [];
    public $routesPOST = [];
    public $routesPUT = [];
    public $routesPATCH = [];
    public $routesDELETE = [];

    // Métodos GET
    public function get($url, $function)
    {
        $this->routesGET[$url] = $function;
    }

    // Métodos POST
    public function post($url, $function)
    {
        $this->routesPOST[$url] = $function;
    }

    // Métodos PUT
    public function put($url, $function)
    {
        $this->routesPUT[$url] = $function;
    }

    // Métodos PATCH
    public function patch($url, $function)
    {
        $this->routesPATCH[$url] = $function;
    }

    // Métodos DELETE
    public function delete($url, $function)
    {
        $this->routesDELETE[$url] = $function;
    }

    public function checkRoutes()
    {
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];
        $function = null;

        try {
            switch ($method) {
                case 'GET':
                    $function = $this->routesGET[$currentUrl] ?? null;
                    break;
                case 'POST':
                    $function = $this->routesPOST[$currentUrl] ?? null;
                    break;
                case 'PUT':
                    $function = $this->routesPUT[$currentUrl] ?? null;
                    break;
                case 'PATCH':
                    $function = $this->routesPATCH[$currentUrl] ?? null;
                    break;
                case 'DELETE':
                    $function = $this->routesDELETE[$currentUrl] ?? null;
                    break;
                default:
                    $this->handleError(405); // Método no permitido
                    return;
            }

            if ($function) {
                // Ejecuta la función asociada con la ruta y método
                call_user_func($function, $this);
            } else {
                // URL no encontrada (404)
                $this->handleError(404);
            }
        } catch (\Exception $e) {
            // Manejo de errores generales (500)
            $this->handleError(500);
        }
    }

    // Método para renderizar vistas, útil en peticiones que no son API
    public function render($view, $datos = [], $layout = 'layout')
    {
        // Si el API responde en JSON
        if (isset($datos['json'])) {
            header('Content-Type: application/json');
            echo json_encode($datos['json']);
            return;
        }

        // Manejo tradicional de vistas 
        foreach ($datos as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean();
        include_once __DIR__ . "/views/{$layout}.php";
    }


    private function handleError($code, $layout = 'layout')
    {
        http_response_code($code);

        $errorMessages = [
            404 => 'Página no encontrada',
            500 => 'Error interno del servidor',
            403 => 'Acceso prohibido',
            405 => 'Método no permitido',
        ];

        $errorTitle = $errorMessages[$code] ?? 'Error desconocido';

        // Renderiza la vista de error usando el layout proporcionado
        $this->render('templates_errors/error', [
            'errorCode' => $code,
            'errorTitle' => $errorTitle
        ], $layout); // Pasamos el layout para que maneje ambos layouts
    }
}
