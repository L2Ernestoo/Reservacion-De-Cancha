<?php
/**
 * @author Ernesto Orellana <eorellana5c@gmail.com>
 * @date 16/02/2022 - 13:42
 */
session_start();
include('config/database.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
} else {

    $records = $conn->prepare('SELECT id, nombre, email FROM ws_usuario WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
        $user = $results;
    }
}

include('resources/templates/header.php');

include('resources/templates/reservacion/index.php');

include('resources/templates/footer.php');