<?php
// controllers/CartController.php
namespace Controllers;

use MVC\Router;
use Includes\Config\Encryption; // Importar la clase de encriptación

class CartController
{
    public static function index(Router $router)
    {
        $router->render('pages/cart', []);
    }

    // FUNCION PARA ENCRIPTAR LOS DATOS DEL CARRITO
    public static function encryptData()
    {
        $encryptionKey = $_ENV['ENCRYPTION_KEY'] ?? null; // Obtener la clave de encriptación de la variable de entorno
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $encryption = new Encryption($encryptionKey);

            // Obtener datos del producto
            $productId = $_POST['id'];
            $productName = $_POST['name'];
            $productPrice = $_POST['price'];

            // Datos a cifrar (Todos los datos del producto selecionado)
            $dataToEncrypt = json_encode([
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice
            ]);

            // Cifrar los datos
            $encryptedData = $encryption->encrypt($dataToEncrypt);

            // Devolver los datos cifrados
            echo $encryptedData;
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
                        'quantity' => 1
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
            'message' => 'Error al procesar la solicitud.'
        ]);
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
