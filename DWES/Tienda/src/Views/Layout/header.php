<nav>
  <ul>
    <li><a class="active" href="<?php echo BASE_URL; ?>">Tienda Online</a></li>
    <?php if(isset($_SESSION['identity'])):?>
      <p>Hola <?= $_SESSION['identity']['nombre']; ?> </p>
      <?php if($_SESSION['identity']['rol'] === 'admin'):?>
        <li><a href="<?=  BASE_URL; ?>">Gestionar pedidos</a></li>
        <li><a href="<?=  BASE_URL; ?>">Gestionar productos</a></li>
        <li><a href="<?=  BASE_URL; ?>">Gestionar categorias</a></li>
      <?php endif; ?> 
      <li><a href="<?=  BASE_URL; ?>">Carrito</a></li>
      <li><a href="<?=  BASE_URL; ?>">Cerrar Sesión</a></li>
    <?php else: ?> 
      <li><a href="<?=  BASE_URL; ?>login">Log In</a></li>
      <li><a href="<?= BASE_URL; ?>register">Register</a></li>
    <?php endif; ?> 
  </ul>
</nav>
