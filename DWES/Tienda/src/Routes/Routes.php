<?php
    namespace Routes;
    use Controllers\ErrorController;
    use Controllers\ProductController;
    use Controllers\CategoryController;
    use Controllers\AuthController;
    use Lib\Router;
    
    
    class Routes{

        public static function index(){

            /* LANDING PAGE */
            Router::add('GET', '/', function(){
                (new ProductController()) -> index();
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
            
            Router::add('GET', '/logout', function(){
                (new AuthController()) -> logout();                
            });

            /* ADMIN FUNCTIONS */
            /* CATEGORIES */
            Router::add('GET', '/categories', function(){
                (new CategoryController()) -> index();                
            });
            
            Router::add('POST', '/categories', function(){
                (new CategoryController()) -> addCategory();                
            });
            
            Router::add('POST', '/categories/delete', function(){
                (new CategoryController()) -> deleteCategory();                
            });
            
            /* PRODUCTS */
            Router::add('GET', '/products', function(){
                (new ProductController()) -> index();                
            });
            
            Router::add('POST', '/products', function(){
                (new ProductController()) -> addProduct();                
            });

            /* ERROR */
            Router::add('GET', '/Error', function(){
                ErrorController::error404();
            });

            Router::dispatch();
        }
    }

?>