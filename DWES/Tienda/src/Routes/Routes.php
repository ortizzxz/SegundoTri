<?php
    namespace Routes;
    use Controllers\ErrorController;
    use Controllers\AuthController;
    use Lib\Router;
    
    
    class Routes{

        public static function index(){

            Router::add('GET', '/', function(){
                (new AuthController()) -> login();                
            });

            /* AUTH */
            Router::add('GET', '/register', function(){
                (new AuthController()) -> register();
            });

            Router::add('POST', '/register', function(){
                (new AuthController())->register();
            });
            
            Router::add('GET', '/login', function(){
                (new AuthController()) -> login();                
            });
            
            Router::add('POST', '/login', function(){
                (new AuthController()) -> login();                
            });

            /* ERROR */
            Router::add('GET', '/Error', function(){
                ErrorController::error404();
            });

            Router::dispatch();
        }
    }

?>