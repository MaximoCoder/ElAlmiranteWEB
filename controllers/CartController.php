<?php
// controllers/CartController.php
namespace Controllers;

use MVC\Router;
use Includes\Config\Encryption; // Importar la clase de encriptación
use Model\HistoryModel; // para reordenar la orden

class CartController
{
    public static function index(Router $router)
    {
        $router->render('pages/cart', []);
    }

    // FUNCION PARA ENCRIPTAR LOS DATOS DEL CARRITO
    public static function encryptData($data = null)
    {
        $encryptionKey = $_ENV['ENCRYPTION_KEY'] ?? null;
        $encryption = new Encryption($encryptionKey);

        try {
            // Si no se proporciona $data, tomar los datos de $_POST (para añadir al carrito)
            if (is_array($data)) {
                $dataToEncrypt = json_encode($data);
                return $encryption->encrypt($dataToEncrypt);
            } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtener datos del producto
                $productId = $_POST['id'];
                $productName = $_POST['name'];
                $productPrice = $_POST['price'];
                $productQuantity = $_POST['quantity'] ?? 1;

                // Datos a cifrar (Todos los datos del producto selecionado)
                $dataToEncrypt = json_encode([
                    'id' => $productId,
                    'name' => $productName,
                    'price' => $productPrice,
                    'quantity' => $productQuantity ?? 1
                ]);

                // Cifrar los datos
                $encryptedData = $encryption->encrypt($dataToEncrypt);

                // Devolver los datos cifrados
                echo $encryptedData;
            }

            throw new \Exception('Datos incompletos para encriptar.');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return null; // Opcional: puedes devolver un valor predeterminado o manejarlo de otra manera.
        }
    }


    // Método para manejar la gestión del carrito
    public static function manageCart()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $encryptedData = $_POST['encrypted_data'] ?? null;

            if ($encryptedData) {
                $encryptionKey = $_ENV['ENCRYPTION_KEY'] ?? null;
                $encryption = new Encryption($encryptionKey);
                $decryptedData = $encryption->decrypt($encryptedData);

                $productData = json_decode($decryptedData, true);

                if (isset($productData['id'], $productData['name'], $productData['price'])) {
                    $product = [
                        'id' => $productData['id'],
                        'name' => $productData['name'],
                        'price' => $productData['price'],
                        'quantity' => $productData['quantity'] ?? 1
                    ];

                    if (isset($_SESSION['cart'])) {
                        $cart = $_SESSION['cart'];
                        $found = false;
                        foreach ($cart as &$item) {
                            if ($item['id'] == $product['id']) {
                                $item['quantity']++;
                                $found = true;
                                break;
                            }
                        }
                        if (!$found) {
                            $cart[] = $product;
                        }
                    } else {
                        $cart = [$product];
                    }

                    $_SESSION['cart'] = $cart;

                    // Responder sin redireccionar
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Producto agregado al carrito.',
                        'cart' => $_SESSION['cart']
                    ]);
                    return;
                } else {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Datos del producto incompletos.'
                    ]);
                    return;
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al procesar la solicitud de carrito: '
        ]);
        return;
    }
    // Funcion para volver a ordenar una orden anterior
    public static function getOrderById($orderId)
    {
        header('Content-Type: application/json');

        try {
            if (!$orderId) {
                throw new \Exception('ID de orden no proporcionado');
            }

            $orden = new HistoryModel();
            $orderItems = $orden->getOrderById($orderId);

            if (empty($orderItems)) {
                throw new \Exception('No se encontraron productos para esta orden.');
            }

            $encryptedItems = array_map(function ($item) {
                try {
                    return [
                        'encrypted_data' => self::encryptData([
                            'id' => $item['id'],
                            'name' => $item['name'],
                            'price' => $item['price'],
                            'quantity' => $item['quantity']
                        ])
                    ];
                } catch (\Exception $e) {
                    throw new \Exception('Error al encriptar producto: ' . $e->getMessage());
                }
            }, $orderItems);

            echo json_encode([
                'status' => 'success',
                'orderItems' => $encryptedItems
            ]);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al obtener los productos de la orden: ' . $e->getMessage()
            ]);
        }
    }

    // Función para eliminar un producto del carrito
    public static function deleteProduct($router, $id)
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $id;
            if (isset($_SESSION['cart'])) {
                $cart = $_SESSION['cart'];
                $found = false;
                foreach ($cart as $key => $item) {
                    if ($item['id'] == $productId) {
                        unset($cart[$key]);
                        $_SESSION['cart'] = array_values($cart);  // Reindexar el array
                        $found = true;
                        break;
                    }
                }

                header('Content-Type: application/json');
                if ($found) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Producto eliminado del carrito.',
                        'cart' => $_SESSION['cart']
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Producto no encontrado en el carrito.'
                    ]);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El carrito está vacío.'
                ]);
            }
        }
    }

    // Funcion para los botones de aumentar cantidad y disminuir cantidad
    public static function increaseQuantity($router, $id)
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $id;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; // Validar y convertir a entero

            if (isset($_SESSION['cart'])) {
                $cart = $_SESSION['cart'];
                foreach ($cart as $key => $item) {
                    if ($item['id'] == $productId) {
                        // Actualizar la cantidad en el carrito
                        $cart[$key]['quantity'] = $quantity;
                        break;
                    }
                }
                $_SESSION['cart'] = $cart; // Actualizar la sesión

                // Responder con éxito
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Cantidad actualizada.',
                    'cart' => $_SESSION['cart']
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El carrito está vacío.'
                ]);
            }
        }
    }

    // Funcion para disminuir la cantidad de un producto en el carrito
    public static function decreaseQuantity($router, $id)
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $id;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; // Validar y convertir a entero

            if (isset($_SESSION['cart'])) {
                $cart = $_SESSION['cart'];
                foreach ($cart as $key => $item) {
                    if ($item['id'] == $productId) {
                        // Verificar si la nueva cantidad es menor o igual a 0
                        if ($quantity <= 0) {
                            // Si la cantidad es 0 o menos, eliminar el producto del carrito
                            unset($cart[$key]);
                        } else {
                            // Actualizar la cantidad en el carrito
                            $cart[$key]['quantity'] = $quantity;
                        }
                        break;
                    }
                }
                $_SESSION['cart'] = $cart; // Actualizar la sesión

                // Responder con éxito
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Carrito actualizado.',
                    'cart' => $_SESSION['cart']
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El carrito está vacío.'
                ]);
            }
        }
    }
}
