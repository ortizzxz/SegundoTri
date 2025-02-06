<?php
namespace Controllers;

use Lib\Pages;
use Models\User;
use Services\UserService;
use Services\CartService;
use Security\Security;
use Lib\EmailSender;
use Exception;

session_start();

class AuthController
{
    private Pages $pages;
    private UserService $userService;
    private CartService $cartService;
    private Security $security;
    private EmailSender $emailSender;

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    public function __construct()
    {
        $this->pages = new Pages();
        $this->userService = new UserService();
        $this->cartService = new CartService();
        $this->security = new Security();
        $this->emailSender = new EmailSender();
    }


    public function login()
    {
        if ($_SERVER['REQUEST_METHOD']) {
            if (isset($_POST['data'])) {
                $userEmail = $_POST['data']['email'];
                $userPassword = $_POST['data']['password'];


                if ($this->userService->validateEmail($userEmail)) {
                    $userDB = $this->userService->findByEmail($userEmail);

                    if ($userDB['confirmado'] != 1) {
                        $_SESSION['confirmado'] = 'fail';
                        $_SESSION['login'] = 'no-confirmado';
                        header("Location: " . BASE_URL . '/login'); // Redirigir a la página principal
                        exit();
                    }

                    if ($userDB) { // password_verify($userPassword, $userDB['password'])
                        if ($this->security->validatePassword($userPassword, $userDB['password'])) {
                            $this->cartService->transferSessionCartToDatabase($userDB['id']);
                            $_SESSION['login'] = 'success';
                            $_SESSION['identity'] = $userDB; // Usar datos de la BD
                            header("Location: " . BASE_URL); // Redirigir a la página principal
                            exit();
                        } else {
                            $_SESSION['login'] = 'fail';
                            $_SESSION['errors'] = ['password' => 'Contraseña incorrecta'];
                        }
                    } else {
                        $_SESSION['login'] = 'fail';
                        $_SESSION['errors'] = ['email' => 'Usuario no encontrado'];
                    }
                } else {
                    $_SESSION['login'] = 'fail';
                    $_SESSION['errors'] = User::getErrors();
                }
            } else {
                $_SESSION['login'] = 'fail';
                $_SESSION['errors'] = 'No se enviaron datos válidos';
            }
        }
        $this->pages->render('Auth/loginForm'); // Siempre renderizar el formulario al final
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['data'])) {

                // Validar sesión para asignar rol 
                if (!isset($_SESSION['identity'])) {
                    $_POST['data']['rol'] = $_ENV['DEFAULT_ROL'];
                }

                $user = User::fromArray($_POST['data']);

                if ($user->validation()) { // Validar los datos

                    // Verificar si el correo ya está registrado
                    if ($this->userService->findByEmail($user->getEmail())) {
                        $_SESSION['register'] = 'fail';
                        $_SESSION['emailExists'] = 'true'; // Establecer la existencia del email
                        $_SESSION['errors'] = 'El correo electrónico ya está registrado.'; // Guardar el mensaje de error
                        $this->pages->render('Auth/registerForm');
                        return; // Termina la ejecución aquí
                    }


                    $password = $this->security->encryptPassword($user->getPassword());
                    $user->setPassword($password); // Contraseña cifrada

                    try {
                        // Intentar guardar el usuario
                        if ($this->userService->save($user)) {
                            $_SESSION['register'] = 'success';
                            $token = Security::generateToken($user->getEmail(), $user->getName());
                            $this->emailSender->sendConfirmation($user->getEmail(), $user->getName(), $token);

                            // Enviar la respuesta JSON con el token en lugar de redirigir
                            echo json_encode([
                                'message' => 'Registro exitoso, revisa tu email para confirmar tu cuenta.',
                                'token' => $token
                            ]);
                            exit();
                        } else {
                            $_SESSION['register'] = 'fail';
                            $_SESSION['errors'] = 'Error al guardar el usuario';
                            $this->pages->render('Auth/registerForm');
                        }
                    } catch (Exception $e) {
                        $_SESSION['register'] = 'fail';
                        $_SESSION['errors'] = $e->getMessage();
                    }
                } else {
                    $_SESSION['register'] = 'fail';
                    $_SESSION['errors'] = User::getErrors();
                }
            } else {
                $_SESSION['register'] = 'fail';
                $_SESSION['errors'] = 'No se enviaron datos válidos';
            }
        }
        $this->pages->render('Auth/registerForm'); // Siempre renderizar el formulario al final
    }

    public function confirmAccount()
    {
        // Verifica si la petición contiene el header Authorization con un Bearer Token
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            http_response_code(400);
            echo json_encode(['error' => 'No se encontró el token en el encabezado']);
            exit();
        }

        // Extraer el token del header (Formato: "Bearer token_aqui")
        $authHeader = $headers['Authorization'];
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Formato de token inválido']);
            exit();
        }

        // Validar el token
        $userEmail = Security::validateJWTToken($token);
        if (!$userEmail) {
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido o expirado']);
            exit();
        }

        // Obtener el usuario con ese email
        $user = $this->userService->findByEmail($userEmail);
        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'Usuario no encontrado']);
            exit();
        }

        // Marcar usuario como confirmado
        $user->setConfirmed(true);
        if ($this->userService->updateConfirmation($userEmail)) {
            echo json_encode(['message' => 'Cuenta confirmada exitosamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error confirmando la cuenta']);
        }
    }

    public function verifyUser()
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(['error' => 'No autorizado']);
            exit();
        }

        // Extraer el token del header
        if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
            $token = $matches[1];
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Formato de token inválido']);
            exit();
        }

        // Validar el token
        $userEmail = Security::validateJWTToken($token);
        if (!$userEmail) {
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido o expirado']);
            exit();
        }

        // Obtener el usuario con ese email
        $user = $this->userService->findByEmail($userEmail);
        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'Usuario no encontrado']);
            exit();
        }

        echo json_encode([
            'message' => 'Usuario autenticado correctamente',
            'user' => [
                    'email' => $user->getEmail(),
                    'name' => $user->getName()
                ]
        ]);
    }




    public function logout()
    {
        session_destroy(); // Destruir la sesión
        header("Location: " . BASE_URL); // Redirigir a la página principal o login
        exit();
    }

    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';

            if ($this->userService->validateEmail($email)) {
                $user = $this->userService->findByEmail($email);

                if ($user) {
                    $token = Security::generateToken($user['email'], $user['nombre']);
                    $this->emailSender->sendPasswordRecovery($user['email'], $user['nombre'], $token);
                    $_SESSION['message'] = 'Se ha enviado un correo con instrucciones para recuperar tu contraseña.';
                } else {
                    $_SESSION['error'] = 'No existe una cuenta con ese correo electrónico.';
                }
            } else {
                $_SESSION['error'] = 'Por favor, introduce un correo electrónico válido.';
            }
        }

        $this->pages->render('Auth/forgotPasswordForm');
    }

    public function resetPassword($token)
    {
        try {
            $payload = Security::decode($token, Security::secretKey());
            $email = $payload['data']['email'];
            error_log("Email from token: " . $email); // Log para depuración

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $password = $_POST['password'] ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';
                error_log("Password: " . $password); // Log para depuración

                if ($password === $confirmPassword) {
                    $hashedPassword = $this->security->encryptPassword($password);
                    error_log("Hashed password: " . $hashedPassword); // Log para depuración

                    $result = $this->userService->updatePassword($email, $hashedPassword);
                    error_log("Update result: " . var_export($result, true)); // Log para depuración

                    if ($result) {
                        $_SESSION['authsuccess'] = 'success';
                        header('Location: ' . BASE_URL . 'login');
                        exit();
                    } else {
                        $_SESSION['error'] = 'Hubo un error al actualizar la contraseña.';
                    }
                } else {
                    $_SESSION['error'] = 'Las contraseñas no coinciden.';
                }
            }

            $this->pages->render('Auth/resetPasswordForm', ['token' => $token]);
        } catch (Exception $e) {
            error_log("Exception: " . $e->getMessage()); // Log para depuración
            $_SESSION['error'] = 'Token inválido o expirado.';
            header('Location: ' . BASE_URL . 'login');
            exit();
        }
    }

}
