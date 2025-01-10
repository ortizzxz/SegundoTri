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
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                if(isset($_POST['data'])){
                    $userEmail = $_POST['data']['email'];
                    $userPassword = $_POST['data']['password'];                    

                    if($this->userService->validateEmail($userEmail)){
                        $userDB = $this->userService->findByEmail($userEmail);
                        if($userDB){
                            if(password_verify($userPassword, $userDB['password'])){
                                $_SESSION['login'] = 'success';
                                $_SESSION['identity'] = $userDB; // Usar datos de la BD en lugar de $_POST
                                $this->pages->render('Product/landPage');
                            }
                            else{
                                $_SESSION['login'] = 'fail';
                                $_SESSION['errors'] = ['password' => 'Contraseña incorrecta'];
                                $this->pages->render('Auth/loginForm');
                            }
                        }else{
                            $_SESSION['login'] = 'fail';
                            $_SESSION['errors'] = ['email' => 'Usuario no encontrado'];
                            $this->pages->render('Auth/loginForm');
                        }
                    }else{
                        $_SESSION['login'] = 'fail';
                        $_SESSION['errors'] = User::getErrors();
                        $this->pages->render('Auth/loginForm');
                    }
                }else{
                    $_SESSION['login'] = 'fail';
                    $_SESSION['errors'] = 'No se enviaron datos válidos';
                    $this->pages->render('Auth/loginForm');
                }
            }else{
                $this->pages->render('Auth/loginForm');
            }
            
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
                                $_SESSION['register'] = 'success';
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