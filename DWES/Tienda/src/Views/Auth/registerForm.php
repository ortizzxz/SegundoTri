<h3>Registrarse</h3>
<form action="<?=BASE_URL?>register" method='POST'> 
    <label for="name">Nombre</label>
    <input type="text" id="name" name="data[name]"><br>
    <label for="lastname">Apellido</label>
    <input type="text" id="lastname" name="data[lastname]"><br>
    <label for="email">Email</label>
    <input type="email" id="email" name="data[email]"><br>
    <label for="password">Contraseña</label>
    <input type="password" name="data[password]" id="password"> <br>
    <input type="submit" value="register">
</form>