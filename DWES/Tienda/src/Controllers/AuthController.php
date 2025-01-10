<?php
namespace Controllers;

use Lib\Pages;
use Models\User;
use Services\UserService;
use Exception;

session_start(); // Iniciar sesión al principio del archivo

class AuthController {
    private Pages $pages; 
    private UserService $userService;

    public function __construct() {
        $this->pages = new Pages();
        $this->userService = new UserService();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['data'])) {
                $userEmail = $_POST['data']['email'];
                $userPassword = $_POST['data']['password'];                    

                if ($this->userService->validateEmail($userEmail)) {
                    $userDB = $this->userService->findByEmail($userEmail);
                    if ($userDB) {
                        if (password_verify($userPassword, $userDB['password'])) {
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

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['data'])) {
                $user = User::fromArray($_POST['data']); 

                if ($user->validation()) { // Validar los datos
                    $password = password_hash($user->getPassword(), PASSWORD_BCRYPT, ['cost' => 5]);
                    $user->setPassword($password); // Contraseña cifrada

                    try {
                        // Intentar guardar el usuario
                        if ($this->userService->save($user)) {
                            $_SESSION['register'] = 'success';
                            header("Location: " . BASE_URL . "registerSuccess"); // Redirigir después de registro exitoso
                            exit();
                        } else {
                            $_SESSION['register'] = 'fail';
                            $_SESSION['errors'] = 'Error al guardar el usuario'; 
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

    public function logout() {
        session_destroy(); // Destruir la sesión
        header("Location: " . BASE_URL); // Redirigir a la página principal o login
        exit();
    }
}
