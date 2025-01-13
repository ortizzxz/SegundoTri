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
                    $_SESSION['cart'] = [];
                }

                $productInCart = false;
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['id'] == $id) {
                        $item['quantity']++;
                        $productInCart = true;
                        break;
                    }
                }

                if (!$productInCart) {
                    $_SESSION['cart'][] = [
                        'id' => $id,
                        'nombre' => $product['nombre'],
                        'precio' => $product['precio'],
                        'quantity' => 1
                    ];
                }

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
        $cartItems = $_SESSION['cart'] ?? [];

        // Obtener el stock para cada item en el carrito
        foreach ($cartItems as &$item) {
            $item['stock'] = $this->productService->getStockById($item['id']);
        }

        $this->pages->render('Cart/display', ['cartItems' => $cartItems]);
    }

    public function removeProduct($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $key => $item) {
                    if ($item['id'] == $id) {
                        unset($_SESSION['cart'][$key]);
                        $_SESSION['success'] = "Producto eliminado del carrito.";
                        break;
                    }
                }
                $_SESSION['cart'] = array_values($_SESSION['cart']); //reindexar el array
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

            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $id) {
                    if ($action === 'increase' && $item['quantity'] < $stock) {
                        $item['quantity']++;
                    } elseif ($action === 'decrease' && $item['quantity'] > 1) {
                        $item['quantity']--;
                    }
                    break;
                }
            }

            header("Location: " . BASE_URL . "cart");
            exit();
        }
    }
}
