<?php
    namespace Routes;
    use Controllers\ErrorController;
    use Controllers\AuthController;
    use Lib\Router;
    
    
    class Routes{

        public static function index(){

            Router::add('GET', '/', function(){
                echo '<h1>Ruta Principal de Prueba</h1>';   
            });

            /* AUTH */
            Router::add('GET', '/register', function(){
                (new AuthController()) -> register();
            });

            Router::add('POST', '/register', function(){
                (new AuthController())->register();
            });
            

            /* ERROR */
            Router::add('GET', '/Error', function(){
                ErrorController::error404();
            });

            Router::dispatch();
        }
    }

?>