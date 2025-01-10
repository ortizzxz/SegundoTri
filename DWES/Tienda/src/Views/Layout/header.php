<?php
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
?>

<nav>
  <ul>
    
    <?php if(isset($_SESSION['identity'])):?>
      <?php if($_SESSION['identity']['rol'] === 'admin'):?>
        <li><a class="active" href="<?=  BASE_URL; ?>">Admin Dashboard</a></li>
        <li><a href="<?=  BASE_URL; ?>">Gestionar pedidos</a></li>
        <li><a href="<?=  BASE_URL; ?>">Gestionar productos</a></li>
        <li><a href="<?=  BASE_URL;?>categories">Gestionar categorias</a></li>
        <?php endif; ?> 
        <li><a href="<?=  BASE_URL; ?>">Carrito</a></li>
        <li><a href="<?=  BASE_URL; ?>logout">Cerrar Sesión</a></li>
      <?php else: ?> 
        <li><a class="active" href="<?php echo BASE_URL; ?>">Tienda Online</a></li>
        <li><a href="<?=  BASE_URL; ?>login">Log In</a></li>
        <li><a href="<?= BASE_URL; ?>register">Register</a></li>
    <?php endif; ?>   
  </ul>
</nav>
