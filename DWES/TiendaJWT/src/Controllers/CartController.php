<?php
namespace Controllers;
use Lib\Pages;
use Services\ProductService;
use Models\Cart;
use Services\CartService;

session_start();

class CartController
{
    private Pages $pages;
    private ProductService $productService;
    private CartService $cartService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->productService = new ProductService();
        $this->cartService = new CartService();
    }

    public function addProduct($id)
    {
        $product = $this->productService->getById($id);
        if (!$product) {
            $_SESSION['error'] = "Product not found.";
            header('Location: ' . BASE_URL . 'products');
            exit;
        }

        $userId = $_SESSION['identity']['id'] ?? null;
        if ($userId) {
            // User is logged in, add to database cart
            $cartId = $this->cartService->getCartForUser($userId);
            $result = $this->cartService->addToCart($cartId, $id, 1, $product['precio']);
        } else {
            // User is not logged in, add to session cart
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            $result = $this->addToSessionCart($id, 1, $product['precio']);
        }

        if ($result) {
            $_SESSION['success'] = "Producto añadido exitosamente.";
        } else {
            $_SESSION['error'] = "Ha ocurrido un error al añadir el producto.";
        }

        header('Location: ' . BASE_URL . 'products');
        exit;
    }

    private function addToSessionCart($productId, $quantity, $price)
    {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'quantity' => $quantity,
                'price' => $price
            ];
        }
        return true;
    }

    public function displayCart()
    {
        $userId = $_SESSION['identity']['id'] ?? null;
        if ($userId) {
            $cartId = $this->cartService->getCartForUser($userId);
            $cartItems = $this->cartService->getCartItems($cartId);
            $total = $this->cartService->getCartTotal($cartId);
        } else {
            $cartItems = $this->getSessionCartItems();
            $total = $this->calculateSessionCartTotal();
        }

        $this->pages->render('Cart/display', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }

    private function getSessionCartItems()
    {
        $cartItems = [];
        foreach ($_SESSION['cart'] ?? [] as $productId => $item) {
            $product = $this->productService->getById($productId);
            $cartItems[] = [
                'id' => $productId,
                'nombre' => $product['nombre'],
                'precio' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
                'stock' => $product['stock'] // Add this line to include stock information
            ];
        }
        return $cartItems;
    }


    private function calculateSessionCartTotal()
    {
        $total = 0;
        foreach ($_SESSION['cart'] ?? [] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function removeProduct($productId)
    {
        $userId = $_SESSION['identity']['id'] ?? null;

        if ($userId) {
            $cartId = $this->cartService->getCartForUser($userId);
            $result = $this->cartService->removeFromCart($cartId, $productId);
        } else {
            unset($_SESSION['cart'][$productId]);
            $result = true;
        }

        if ($result) {
            $_SESSION['success'] = "Producto eliminado del carrito exitosamente.";
        } else {
            $_SESSION['error'] = "Ha habido un fallo al eliminar el producto del carrito.";
        }

        error_log("Final result: " . ($_SESSION['success'] ?? $_SESSION['error']));
        header('Location: ' . BASE_URL . 'cart');
        exit;
    }


    public function updateQuantity($id)
    {
        $action = $_POST['action'] ?? '';
        if (!in_array($action, ['increase', 'decrease'])) {
            $_SESSION['error'] = "Invalid action.";
            header('Location: ' . BASE_URL . 'cart');
            exit;
        }

        $userId = $_SESSION['identity']['id'] ?? null;
        if ($userId) {
            $cartId = $this->cartService->getCartForUser($userId);
            $result = $this->cartService->updateQuantity($cartId, $id, $action);
        } else {
            $result = $this->updateSessionCartQuantity($id, $action);
        }

        if ($result) {
            $_SESSION['success'] = "Cart updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update cart.";
        }

        header('Location: ' . BASE_URL . 'cart');
        exit;
    }

    private function updateSessionCartQuantity($productId, $action)
    {
        if (!isset($_SESSION['cart'][$productId])) {
            return false;
        }

        if ($action === 'increase') {
            $_SESSION['cart'][$productId]['quantity']++;
        } elseif ($action === 'decrease') {
            $_SESSION['cart'][$productId]['quantity'] = max(1, $_SESSION['cart'][$productId]['quantity'] - 1);
        }

        return true;
    }
}
