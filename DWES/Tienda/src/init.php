<?php
    use Routes\Routes; 
    require_once '../vendor/autoload.php';
    require_once '../Config/config.php';

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
    
    
    Routes::index();
?>

