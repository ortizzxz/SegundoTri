<div class="form-container">
    <h3>Iniciar sesión</h3>
    <form action="<?= BASE_URL ?>login" method="POST" class="registration-form">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="data[email]" value="<?= isset($_POST['data']['email']) ? htmlspecialchars($_POST['data']['email']) : '' ?>">
            <?php if (isset($_SESSION['errors']['email'])): ?>
                <p class="error"><?= $_SESSION['errors']['email'] ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="data[password]" id="password">
            <?php if (isset($_SESSION['errors']['password'])): ?>
                <p class="error"><?= $_SESSION['errors']['password'] ?></p>
            <?php endif; ?>
        </div>

        <input type="submit" value="Iniciar sesión" class="submit-button">
    </form>
</div>

<?php
if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}
?>
