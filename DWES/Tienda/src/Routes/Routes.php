<?php
namespace Routes;
use Controllers\ErrorController;
use Controllers\ProductController;
use Controllers\CategoryController;
use Controllers\CartController;
use Controllers\AuthController;
use Controllers\OrderController;
use Lib\Router;


class Routes
{

    public static function index()
    {

        /* LANDING PAGE */
        Router::add('GET', '/', function () {
            (new ProductController())->index();
        });

        /* AUTH */
        Router::add('GET', '/register', function () {
            (new AuthController())->register();
        });

        Router::add('POST', '/register', function () {
            (new AuthController())->register();
        });

        Router::add('GET', '/login', function () {
            (new AuthController())->login();
        });

        Router::add('POST', '/login', function () {
            (new AuthController())->login();
        });

        Router::add('GET', '/logout', function () {
            (new AuthController())->logout();
        });

        /* ADMIN FUNCTIONS */
        /* CATEGORIES */
        Router::add('GET', '/categories', function () {
            (new CategoryController())->index();
        });

        Router::add('POST', '/categories', function () {
            (new CategoryController())->addCategory();
        });

        Router::add('GET', '/categories/:id', function(int $id) {
            (new CategoryController())->showProducts($id);
        });
        
            
        Router::add('POST', '/categories/delete', function () {
            (new CategoryController())->deleteCategory();
        });


        /* PRODUCTS */
        Router::add('GET', '/products', function () {
            (new ProductController())->index();
        });

        Router::add('POST', '/products', function () {
            (new ProductController())->addProduct();
        });

        Router::add('GET', '/products/category/{id}', function(int $id) {
            (new CategoryController())->showProducts($id);
        });
        


        /* CART */
        Router::add('GET', '/cart', function () {
            (new CartController())->displayCart();
        });
        
        Router::add('GET', '/products/category/:id', function (int $id) {
            (new CategoryController())->showProducts($id);
        });
        

        Router::add('POST', '/cart/update/:id', function (int $id) {
            (new CartController())->updateQuantity($id);
        });

        Router::add('POST', '/cart/remove/:id', function (int $id) {
            (new CartController())->removeProduct($id);
        });

        Router::add('POST', '/order/create', function(){
            (new OrderController()) -> createOrder();                
        });
        

        /* ERROR */
        Router::add('GET', '/Error', function () {
            ErrorController::error404();
        });

        Router::dispatch();
    }
}

?>