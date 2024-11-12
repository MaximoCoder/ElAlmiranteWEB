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

        // Establecer el layout predeterminado
        $layout = 'layout'; // Layout por defecto

        // En las rutas de admin, utiliza el layoutAdmin
        if (strpos($currentUrl, '/admin') === 0) {
            $layout = 'layoutAdmin';
        }

        $matchedRoute = null;
        $params = [];

        try {
            // Buscar una ruta coincidente con parámetros
            foreach ($this->{"routes$method"} as $route => $function) {
                $pattern = $this->convertRouteToRegex($route);
                if (preg_match($pattern, $currentUrl, $matches)) {
                    $matchedRoute = $route;
                    array_shift($matches); // Eliminar la coincidencia completa
                    $params = $matches;
                    break;
                }
            }

            if ($matchedRoute) {
                $function = $this->{"routes$method"}[$matchedRoute];
                // Llamar a la función con el Router y los parámetros
                call_user_func($function, $this, $params);
            } else {
                // URL no encontrada (404)
                $this->handleError(404, $layout);
            }
        } catch (\Exception $e) {
            // Manejo de errores generales (500)
            $this->handleError(500, $layout);
        }
    }

    private function convertRouteToRegex($route)
    {
        return '#^' . preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route) . '$#';
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

        // URL PARA VOLVER AL INICIO SEGUN EL LAYOUT
        $url = $layout === 'layoutAdmin' ? '/admin/dashboard' : '/';

        // Renderiza la vista de error usando el layout proporcionado
        $this->render('templates_errors/error', [
            'errorCode' => $code,
            'errorTitle' => $errorTitle,
            'url' => $url
        ], $layout); // Pasamos el layout para que maneje ambos layouts ,d
    }
}
