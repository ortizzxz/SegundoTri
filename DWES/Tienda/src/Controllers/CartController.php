<?php
namespace Controllers;
use Lib\Pages;
use Services\ProductService;
use Models\Cart;

session_start();

class CartController
{
    private Pages $pages;
    private ProductService $productService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->productService = new ProductService();
    }

    public function addProduct($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = $this->productService->getById($id);

            if ($product) {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = ['items' => [], 'total' => 0];
                }

                $productInCart = false;
                foreach ($_SESSION['cart']['items'] as &$item) {
                    if ($item['id'] == $id) {
                        $item['quantity']++;
                        $item['subtotal'] = $item['precio'] * $item['quantity'];
                        $productInCart = true;
                        break;
                    }
                }

                if (!$productInCart) {
                    $_SESSION['cart']['items'][] = [
                        'id' => $id,
                        'nombre' => $product['nombre'],
                        'precio' => $product['precio'],
                        'quantity' => 1,
                        'subtotal' => $product['precio']
                    ];
                }

                $this->recalculateTotal();
                $_SESSION['success'] = "Producto añadido al carrito correctamente.";
            } else {
                $_SESSION['error'] = "No se pudo encontrar el producto.";
            }

            header("Location: " . BASE_URL . "products");
            exit();
        } else { // get
            header("Location: " . BASE_URL . "products");
            exit();
        }
    }

    public function displayCart()
    {
        $cart = $_SESSION['cart'] ?? ['items' => [], 'total' => 0];
        $cartItems = $cart['items'] ?? [];

        // Obtener el stock para cada item en el carrito
        foreach ($cartItems as &$item) {
            if (isset($item['id'])) {
                $item['stock'] = $this->productService->getStockById($item['id']);
            } else {
                $item['stock'] = 0; // O cualquier otro valor predeterminado
            }
        }

        $this->pages->render('Cart/display', ['cartItems' => $cartItems, 'total' => $cart['total']]);
    }

    public function removeProduct($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['cart']['items'])) {
                foreach ($_SESSION['cart']['items'] as $key => $item) {
                    if ($item['id'] == $id) {
                        unset($_SESSION['cart']['items'][$key]);
                        $_SESSION['success'] = "Producto eliminado del carrito.";
                        break;
                    }
                }
                $_SESSION['cart']['items'] = array_values($_SESSION['cart']['items']); //reindexar el array
                $this->recalculateTotal();
            }

            header("Location: " . BASE_URL . "cart");
            exit();
        }
    }

    public function updateQuantity($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $stock = $this->productService->getStockById($id);

            foreach ($_SESSION['cart']['items'] as &$item) {
                if ($item['id'] == $id) {
                    if ($action === 'increase' && $item['quantity'] < $stock) {
                        $item['quantity']++;
                    } elseif ($action === 'decrease' && $item['quantity'] > 1) {
                        $item['quantity']--;
                    }
                    $item['subtotal'] = $item['precio'] * $item['quantity'];
                    break;
                }
            }

            $this->recalculateTotal();
            header("Location: " . BASE_URL . "cart");
            exit();
        }
    }

    private function recalculateTotal()
    {
        $total = 0;
        foreach ($_SESSION['cart']['items'] as $item) {
            $total += $item['subtotal'];
        }
        $_SESSION['cart']['total'] = $total;
    }
}
