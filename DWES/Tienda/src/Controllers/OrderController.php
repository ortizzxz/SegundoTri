<?php
namespace Controllers;

use Lib\Pages;
use Services\OrderService;
use Services\ProductService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Models\Order;
use Models\User;

session_start();

class OrderController
{
    private Pages $pages;
    private OrderService $orderService;
    private ProductService $productService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->orderService = new OrderService();
        $this->productService = new ProductService();
    }

    public function createOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            
            $user = User::fromArray($_SESSION['identity']);
            $_POST['shipping']['userId'] = $user->getId();
            $_POST['shipping']['cost'] = $_SESSION['cart']['total'];
            $shippingAddress = Order::fromArray($_POST['shipping']);

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
            
            $orderId = $this->orderService->createOrder($userId, $cartItems);

            if ($orderId && $shippingAddress->validation()) {
                $this->updateProductStock($cartItems);
                $this->sendOrderConfirmationEmail($_SESSION['identity']['email'], $orderId, $cartItems);
                unset($_SESSION['cart']);
                $_SESSION['success'] = "Pedido realizado con éxito. Tu número de pedido es: " . $orderId;
                header("Location: " . BASE_URL . "cart");
                exit();
            } else {
                $this->setErrorAndRedirect("Hubo un problema al crear tu pedido. Por favor, inténtalo de nuevo.", "cart");
            }
        } else {
            header("Location: " . BASE_URL . "cart");
            exit();
        }
    }


    public function shippingForm(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->pages->render('Order/shippingForm');
        }else{
            echo 'get';
        }
    }

    private function isUserLoggedIn(): bool {
        return isset($_SESSION['identity']['id']);
    }

    private function isCartEmpty(): bool {
        return empty($_SESSION['cart']);
    }

    private function setErrorAndRedirect(string $message, string $redirect): void {
        $_SESSION['error'] = $message;
        header("Location: " . BASE_URL . $redirect);
        exit();
    }

    private function checkStockAvailability(array $cartItems): bool {
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
    
    private function updateProductStock(array $cartItems): void {
        if (isset($cartItems['items']) && is_array($cartItems['items'])) {
            foreach ($cartItems['items'] as $item) {
                if (isset($item['id']) && isset($item['quantity'])) {
                    $this->productService->updateStock($item['id'], $item['quantity']);
                }
            }
        }
    }
    

    private function sendOrderConfirmationEmail(string $userEmail, int $orderId, array $cartItems): void {
        // Crear una instancia de PHPMailer
        $mail = new PHPMailer(true);
        
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();                                      // Configurar para usar SMTP
            $mail->Host       = 'smtp.gmail.com';                 // Especificar el servidor SMTP
            $mail->SMTPAuth   = true;                             // Habilitar autenticación SMTP
            $mail->Username   = $_ENV["EMAIL"];
            $mail->Password   = $_ENV["EMAIL_PASSWORD"];                   // Tu contraseña de correo electrónico (o App Password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Habilitar cifrado TLS
            $mail->Port       = 587;                              // Puerto TCP a usar


            // Destinatarios
            $mail->setFrom('from@example.com', 'Nombre del Remitente');
            $mail->addAddress($userEmail);                        // Agregar destinatario

            // Contenido del correo
            $mail->isHTML(true);                                  // Establecer formato de correo a HTML
            $mail->Subject = 'Confirmación de Pedido #' . htmlspecialchars($orderId);
            
            // Crear contenido del mensaje
            ob_start(); // Iniciar captura de salida
            ?>
            <h1>Gracias por tu Pedido!</h1>
            <p>Tu número de pedido es: <strong><?php echo htmlspecialchars($orderId); ?></strong></p>
            <h2>Detalles del Pedido:</h2>
            <ul>
                <?php foreach ($cartItems as $item): ?>
                    <li><?php echo htmlspecialchars($item['nombre']); ?> - Cantidad: <?php echo htmlspecialchars($item['quantity']); ?> - Precio: €<?php echo number_format($item['precio'], 2); ?></li>
                <?php endforeach; ?>
            </ul>
            <p>¡Gracias por comprar con nosotros!</p>
            <?php
            $bodyContent = ob_get_clean(); // Obtener contenido y limpiar buffer
            
            $mail->Body    = $bodyContent;

            // Enviar el correo
            $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar el correo: {$mail->ErrorInfo}");
        }
    }
}