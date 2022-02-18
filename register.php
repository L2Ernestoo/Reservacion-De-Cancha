<?php

require 'config/database.php';

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $sql = "INSERT INTO ws_usuario (nombre, email, telefono, password) VALUES (:nombre, :email, :telefono, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $_POST['nombre']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':telefono', $_POST['telefono']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        $message = 'Usuario Creado Exitosamente';
    } else {
        $message = 'No se pudo completar su registro.';
    }
}
?>
<?php require 'resources/templates/header.php' ?>

<div class="container w-50 shadow-sm rounded">
    <div class="text-center">
        <?php if (!empty($message)): ?>
        <div class="alert alert-success">
            <p> <?= $message ?></p>
        </div>
        <?php endif; ?>
        <h1>Registrate</h1>
        <span>o <a href="login.php">Inicia Sesión</a></span>

    </div>

    <form action="register.php" method="POST">
        <input class="form-control m-3" name="nombre" type="text" placeholder="Ingrese su nombre" maxlength="45" required>
        <input class="form-control m-3" name="email" type="email" maxlength="45" placeholder="Ingrese su correo" required>
        <input class="form-control m-3" name="telefono" type="text" maxlength="15" placeholder="Ingrese su telefono" required>
        <input class="form-control m-3" name="password" type="password" maxlength="20" placeholder="Enter your Password" required>
        <input class="btn btn-primary m-3" type="submit" value="Submit">
    </form>
</div>
<?php require 'resources/templates/footer.php' ?>
