<?php
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="../../public/css/cart.css">
    <link rel="stylesheet" href="../../public/css/auth.css">
    <link rel="stylesheet" href="../../public/css/category.css">
    <link rel="stylesheet" href="../../public/css/product.css">
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
        <?php endif; ?>   
        <li><a href="<?= BASE_URL; ?>logout">Cerrar Sesión <?= ucfirst(strtolower($_SESSION['identity']['nombre'])); ?></a></li>
        <?php else: ?> 
          <li><a class="active" href="<?php echo BASE_URL; ?>">Tienda Online</a></li>
          <li><a href="<?=  BASE_URL;?>products">Productos</a></li>
          <li><a href="<?=  BASE_URL;?>categories">Categorías</a></li>
          <li><a href="<?=  BASE_URL; ?>login">Log In</a></li>        
      <li><a href="<?= BASE_URL; ?>register">Register</a></li>
    <?php endif; ?>   
  </ul>
</nav>
