<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red;"><?php echo $_SESSION['error']; ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['confirmation'])): ?>
    <?php if ($_SESSION['confirmation'] === 'success'): ?>
        <p style="color: green;">Tu cuenta ha sido exitosamente verificada. Ya puedes iniciar sesión.</p>
    <?php elseif ($_SESSION['confirmation'] === 'already'): ?>
        <p>Tu cuenta ya ha sido confirmada.</p>
    <?php else: ?>
        <p style="color: red;">Ha habido un error confirmando tu cuenta. Por favor intentalo nuevamente más tarde.</p>
    <?php endif; ?>
    <?php unset($_SESSION['confirmation']); ?>
<?php else: ?>
    <p>Por favor revise su correo y ingrese al enlace recibido.</p>
<?php endif; ?>

<p><a href="<?php echo BASE_URL; ?>">Volver a la página principal</a></p>