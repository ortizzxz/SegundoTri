<?php
namespace Controllers;
use Lib\Pages;
use Services\ProductService;
use Models\Cart;

session_start();

class CartController {
    private Pages $pages; 
    private ProductService $productService;

    public function __construct() {
        $this->pages = new Pages();
        $this->productService = new ProductService();
    }

    public function addProduct($id) {
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

    public function displayCart() {
        $cartItems = $_SESSION['cart'] ?? [];
        $this->pages->render('Cart/display', ['cartItems' => $cartItems]);
    }
}
