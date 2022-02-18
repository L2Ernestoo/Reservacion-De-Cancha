<?php

session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
}
require 'config/database.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) {

    $strQuery = $conn->prepare('SELECT id, email, password FROM ws_usuario WHERE email = :email');
    $strQuery->bindParam(':email', $_POST['email']);
    $strQuery->execute();
    $results = $strQuery->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['p    assword'], $results['password'])) {
        $_SESSION['user_id'] = $results['id'];
        header("Location: index.php");
    } else {
        $message = 'Las credenciales no son las correctas.';
    }
}

?>
<?php require 'resources/templates/header.php' ?>

<?php if (!empty($message)): ?>
    <p> <?= $message ?></p>
<?php endif; ?>
<div class="container shadow-sm mt-4 w-50">
    <div class="text-center">
        <h1>Inicia Sesión</h1>
        <span>o <a href="register.php">Registrate</a></span>
    </div>
    <form action="login.php" method="POST">
        <input class="form-control m-3" name="email" type="text" placeholder="Ingresa tu correo">
        <input class="form-control m-3" name="password" type="password" placeholder="Ingresa tu contraseña">
        <input class="btn btn-primary m-3" type="submit" value="Iniciar Sesión">
    </form>
</div>
<?php require 'resources/templates/footer.php' ?>
