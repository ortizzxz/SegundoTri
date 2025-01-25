<?php
namespace Controllers;

use Lib\Pages;
use Models\User;
use Services\UserService;
use Security\Security;
use Lib\EmailSender;
use Exception;

session_start();

class AuthController
{
    private Pages $pages;
    private UserService $userService;
    private Security $security;
    private EmailSender $emailSender;

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    public function __construct()
    {
        $this->pages = new Pages();
        $this->userService = new UserService();
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
                    if ($userDB) { // password_verify($userPassword, $userDB['password'])
                        if ($this->security->validatePassword($userPassword, $userDB['password'])) {
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
                            header('Location: ' . BASE_URL . 'login');
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

    public function confirmAccount($token)
    {
        try {
            $payload = Security::decode($token, Security::secretKey());
            $email = $payload['data']['email'];

            $user = $this->userService->findByEmail($email);
            if (!$user) {
                $_SESSION['error'] = 'No existe un usuario con este correo.';
                $this->pages->render('Auth/confirmation');
            }
            if ($user['confirmado'] === TRUE) {
                $_SESSION['confirmation'] = 'already';
                header('Location: ' . BASE_URL);
                exit();
            }

            if ($this->userService->updateConfirmation($email)) {
                $_SESSION['confirmation'] = 'success';
                $this->pages->render('Auth/confirmation');
                exit();
            } else {
                $_SESSION['confirmation'] = 'fail';
                $this->pages->render('Auth/confirmation');
                exit();
            }

        } catch (Exception $e) {
            $_SESSION['error'] = 'Token inválido o expirado.';
            header('Location: ' . BASE_URL);
            exit();
        }
    }


    public function logout()
    {
        session_destroy(); // Destruir la sesión
        header("Location: " . BASE_URL); // Redirigir a la página principal o login
        exit();
    }
}
