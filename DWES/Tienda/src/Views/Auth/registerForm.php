<div class="form-container">
    <h3>Registrarse</h3>
    <form action="<?= BASE_URL ?>register" method="POST" class="registration-form">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="data[name]" value="<?= isset($_POST['data']['name']) ? htmlspecialchars($_POST['data']['name']) : '' ?>">
            <?php if (isset($_SESSION['errors']['name'])): ?>
                <p class="error"><?= $_SESSION['errors']['name'] ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="lastname">Apellido</label>
            <input type="text" id="lastname" name="data[lastname]" value="<?= isset($_POST['data']['lastname']) ? htmlspecialchars($_POST['data']['lastname']) : '' ?>">
            <?php if (isset($_SESSION['errors']['lastname'])): ?>
                <p class="error"><?= $_SESSION['errors']['lastname'] ?></p>
            <?php endif; ?>
        </div>

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

        <input type="submit" value="Registrar" class="submit-button">
    </form>
</div>

<?php
if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}
?>