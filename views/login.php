<?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>

<form action="index.php?action=login" method="POST">
    <label>Nombre de usuario:</label>
    <input type="text" name="username" required><br>

    <label>Contraseña:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Iniciar sesión</button>
</form>

<a href="index.php?action=register">¿No tienes cuenta? - Regístrate aquí</a>