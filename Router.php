<?php
namespace MVC;
class Router
{
    public $routesGET = [];
    public $routesPOST = [];

    public function get($url, $function){
        $this->routesGET[$url] = $function;
    }

    public function post($url, $function){
        $this->routesPOST[$url] = $function;
    }

    public function checkRoutes(){
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        try {
            if ($method === 'GET') {
                $function = $this->routesGET[$currentUrl] ?? null;
            } elseif ($method === 'POST') {
                $function = $this->routesPOST[$currentUrl] ?? null;
            }

            if ($function) {
                // La URL existe y ejecuta la función asociada
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

    public function render($view, $datos = [], $layout = 'layout') {
        // Leer lo que le pasamos a la vista
        foreach ($datos as $key => $value) {
            $$key = $value;  
        }
    
        ob_start(); // Almacenamiento en memoria durante un momento...
    
        // Incluir la vista
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Limpia el Buffer
    
        // Seleccionar el layout (por defecto 'layout.php')
        include_once __DIR__ . "/views/{$layout}.php";
    }

    private function handleError($code)
    {
        http_response_code($code);

        $errorMessages = [
            404 => 'Página no encontrada',
            500 => 'Error interno del servidor',
            403 => 'Acceso prohibido',
        ];

        $errorTitle = $errorMessages[$code] ?? 'Error desconocido';

        $this->render('templates_errors/error', [
            'errorCode' => $code,
            'errorTitle' => $errorTitle
        ]);
    }
}
