<nav>
  <ul>
    <li><a class="active" href="<?php echo BASE_URL; ?>">Tienda Online</a></li>
    <?php if(isset($_SESSION['identity'])):?>
      <li><p>Hola <?= $_SESSION['identity']['nombre']; ?> </p></li>
      <li><a href="<?=  BASE_URL; ?>">Carrito</a></li>
      <li><a href="<?=  BASE_URL; ?>">Cerrar Sesión</a></li>
    <?php else: ?> 
      <li><a href="<?=  BASE_URL; ?>login">Log In</a></li>
      <li><a href="<?= BASE_URL; ?>register">Register</a></li>
    <?php endif; ?> 
  </ul>
</nav>
