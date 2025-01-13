<?php
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/auth.css">
    <link rel="stylesheet" href="./css/category.css">
    <link rel="stylesheet" href="./css/product.css"> -->

    
    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="../../public/css/auth.css">
    <link rel="stylesheet" href="../../public/css/category.css">
    <link rel="stylesheet" href="../../public/css/product.css">
    <link rel="stylesheet" href="../../public/css/cart.css">
 
  </head>
  <body>
    
<nav>
  <ul>
    
    <?php if(isset($_SESSION['identity'])):?>
      <?php if($_SESSION['identity']['rol'] === 'admin'):?>
        <li><a class="active" href="<?=  BASE_URL; ?>">Admin Dashboard</a></li>
        <li><a href="<?=  BASE_URL; ?>register">Registrar usuario</a></li>
        <li><a href="<?=  BASE_URL; ?>">Gestionar pedidos</a></li>
        <li><a href="<?=  BASE_URL; ?>products">Gestionar productos</a></li>
        <li><a href="<?=  BASE_URL;?>categories">Gestionar categorias</a></li>
      <?php else: ?>   
        <li><a class="active" href="<?=  BASE_URL; ?>">Tienda Online</a></li>
        <li><a href="<?=  BASE_URL; ?>cart">Carrito 🛒</a></li>
        <li><a href="<?=  BASE_URL;?>products">Productos</a></li>
      <?php endif; ?>   
        <li><a href="<?= BASE_URL; ?>logout">Cerrar Sesión <?= ucfirst(strtolower($_SESSION['identity']['nombre'])); ?></a></li>
    <?php else: ?> 
      <li><a class="active" href="<?php echo BASE_URL; ?>">Tienda Online</a></li>
      <li><a href="<?=  BASE_URL; ?>login">Log In</a></li>        
      <li><a href="<?= BASE_URL; ?>register">Register</a></li>
    <?php endif; ?>   
  </ul>
</nav>
