<?php
    namespace Controllers;
    use Lib\Pages;
    use Models\User;
    use Services\UserService;
    use Exception;

    class AuthController{
        private Pages $pages; 
        private UserService $userService;

        public function __construct() {
            $this->pages = new Pages();
            $this->userService = new UserService();
        }

        public function login(){
            $this->pages->render('Auth/login');
        }
        
        public function register() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['data'])) {
                    
                    $user = User::fromArray($_POST['data']); 
        
                    if ($user->validation()) { //validar los datos
                        $password = password_hash($user->getPassword(), PASSWORD_BCRYPT, ['cost' => 5]);
                        $user->setPassword($password); // contraseña cifrada
        
                        try {
                            // try - guardar el usuario
                            if ($this->userService->save($user)) {
                                $this->pages->render('Auth/registerSuccess'); //si se guarda correctamente
                            } else {
                                // si no, redirigir con un mensaje de error
                                $_SESSION['register'] = 'fail';
                                $_SESSION['errors'] = 'Error al guardar el usuario'; 
                                $this->pages->render('Auth/registerForm'); 
                            }
                        } catch (Exception $e) {
                            //si ocurre un error, redirigir 
                            $_SESSION['register'] = 'fail';
                            $_SESSION['errors'] = $e->getMessage();
                            $this->pages->render('Auth/registerForm'); 
                        }
                    } else {
                        // si la validacion falla
                        $_SESSION['register'] = 'fail';
                        $_SESSION['errors'] = User::getErrors();
                        $this->pages->render('Auth/registerForm');
                    }
                } else {
                    //si no se envian datos
                    $_SESSION['register'] = 'fail';
                    $_SESSION['errors'] = 'No se enviaron datos válidos';
                    $this->pages->render('Auth/registerForm'); 
                }
            } else {
                $this->pages->render('Auth/registerForm'); // GET
            }
        }
    }        
?>