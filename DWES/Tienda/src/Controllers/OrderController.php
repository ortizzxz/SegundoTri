<?php
namespace Controllers;

use Lib\EmailSender;
use Lib\Pages;
use Services\OrderService;
use Services\ProductService;
use Models\Order;
use Models\User;

session_start();

class OrderController
{
    private Pages $pages;
    private OrderService $orderService;
    private ProductService $productService;

    private EmailSender $emailSender;


    public function __construct()
    {
        $this->pages = new Pages();
        $this->orderService = new OrderService();
        $this->productService = new ProductService();
        $this->emailSender = new EmailSender();
    }

    public function createOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user = User::fromArray($_SESSION['identity']);

            $_POST['shipping']['userId'] = $user->getId();
            $_POST['shipping']['cost'] = $_SESSION['cart']['total'];
            $order = Order::fromArray($_POST['shipping']);

            $userId = $_SESSION['identity']['id'];
            $cartItems = $_SESSION['cart'];

            if (!$this->isUserLoggedIn()) {
                $this->setErrorAndRedirect("Debes iniciar sesión para realizar un pedido.", "login");
            }
            if ($this->isCartEmpty()) {
                $this->setErrorAndRedirect("Tu carrito está vacío.", "cart");
            }
            if (!$this->checkStockAvailability($cartItems)) {
                return;
            }
            //SI ESTÁ VALIDADO
            if ($order->validation()) {
                $orderSuccessful = $this->orderService->createOrder($order, $cartItems);

                if ($orderSuccessful) {
                    $this->updateProductStock($cartItems);
                    unset($_SESSION['cart']);

                    //email
                    if ($this->emailSender->sendEmail($_SESSION['identity']['email'], $_SESSION['identity']['name'], 'Payment Confirmation', '<p>Thank you for your payment!</p>')) {
                        echo 'Message has been sent';
                    } else {
                        echo 'Message could not be sent';
                    }
                    // 
                    $_SESSION['success'] = "Pedido realizado con éxito";
                    header("Location: " . BASE_URL);
                    exit();
                } else {
                    $_SESSION['error'] = "Ha habido un error con el pedido";
                    header("Location: " . BASE_URL);
                    exit();
                }
            } else {
                $this->pages->render('Order/shippingForm');
            }

        } else {
            header("Location: " . BASE_URL . "cart");
            exit();
        }
    }

    public function shippingForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->pages->render('Order/shippingForm');
        } else {
            header('Location: ' . BASE_URL);
        }
    }

    private function isUserLoggedIn(): bool
    {
        return isset($_SESSION['identity']['id']);
    }

    private function isCartEmpty(): bool
    {
        return empty($_SESSION['cart']);
    }

    private function setErrorAndRedirect(string $message, string $redirect): void
    {
        $_SESSION['error'] = $message;
        header("Location: " . BASE_URL . $redirect);
        exit();
    }

    private function checkStockAvailability(array $cartItems): bool
    {
        if (isset($cartItems['items']) && is_array($cartItems['items'])) {
            foreach ($cartItems['items'] as $item) {
                if (!isset($item['id']) || !isset($item['quantity'])) {
                    $_SESSION['error'] = "Invalid item in cart";
                    header("Location: " . BASE_URL . "cart");
                    return false;
                }
                $currentStock = $this->productService->getStockById($item['id']);
                if ($currentStock < $item['quantity']) {
                    $_SESSION['error'] = "No hay suficiente stock para " . htmlspecialchars($item['nombre'] ?? 'Producto desconocido');
                    header("Location: " . BASE_URL . "cart");
                    return false; // Stock insuficiente
                }
            }
        } else {
            $_SESSION['error'] = "Invalid cart structure";
            header("Location: " . BASE_URL . "cart");
            return false;
        }
        return true; // Stock suficiente
    }

    private function updateProductStock(array $cartItems): void
    {
        if (isset($cartItems['items']) && is_array($cartItems['items'])) {
            foreach ($cartItems['items'] as $item) {
                if (isset($item['id']) && isset($item['quantity'])) {
                    $this->productService->updateStock($item['id'], $item['quantity']);
                }
            }
        }
    }
    public function getOrders()
    {
        // Assuming that the client ID is stored in the session
        $clienteId = $_SESSION['identity']['id'];
        
        // Retrieve orders from the service
        if($_SESSION['identity']['rol'] == $_ENV['ADMIN']){
            $pedidos = $this->orderService->getOrders();
        }else{
            $pedidos = $this->orderService->getOrdersByClient($clienteId);
        }
        
        // Render the view and pass the data ('pedidos') to it
        $this->pages->render('Order/myOrder', ['pedidos' => $pedidos]);
    }
    
}