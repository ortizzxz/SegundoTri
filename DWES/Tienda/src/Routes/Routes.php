<?php
    namespace Routes;
    use Controllers\ErrorController;
    use Lib\Router;
    
    
    class Routes{

        public static function index(){

            Router::add('GET', '/', function(){
                echo '<h1>Ruta Principal de Prueba</h1>';
            });

            Router::add('GET', '/Error', function(){
                ErrorController::error404();
            });

            Router::dispatch();
        }
    }

?>