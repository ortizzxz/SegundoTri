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
        
        public function register(){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                if($_POST['data']){
                    $user = User::fromArray($_POST['data']);
                    if($user->validation()){    
                        $password = password_hash($user->getPassword(), PASSWORD_BCRYPT, ['cost' => 5]);
                        $user->setPassword($password);
                        try {
                            $userService->save($user);
                        } catch (Exception $e) {
                            $_SESSION['register'] = 'fail'; // Si no hay datos
                            $_SESSION['errors'] = $e->getMessage();
                        }
                    }else{
                        $_SESSION['register'] = 'fail'; // Si no hay datos
                        $_SESSION['errors'] = User::getErrors();
                    }
                }else{
                    $_SESSION['register'] = 'fail'; // Si no hay datos
                }
            }else{
                $this->pages->render('Auth/registerForm');
            }
        }
    }

?>