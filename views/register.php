<?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>

<form action="index.php?action=register" method="POST">
    <label>Nombre de usuario:</label>
    <input type="text" name="username" required><br>

    <label>Contraseña:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Registrarse</button>
</form>

<a href="index.php?action=login">¿Ya tienes cuenta? Inicia sesión aquí</a>
