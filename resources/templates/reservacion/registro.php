<?php
/**
 * @author Ernesto Orellana <eorellana5c@gmail.com>
 * @date 16/02/2022 - 16:17
 */
$arrResultado = [
    'error' => false,
    'mensaje' => 'Reseravación efectuada con exito'
];

$strDefaultUser = 1;

$arrConfig = include '../../../config/bd.php';

try {
    $strbd = 'mysql:host=' . $arrConfig['db']['host'] . ';dbname=' . $arrConfig['db']['name'];
    $strConexion = new PDO($strbd, $arrConfig['db']['user'], $arrConfig['db']['pass'], $arrConfig['db']['options']);

    //Recibimos Reservacion
    $arrUsuario = array(
        "fecha" => $_POST['fecha'],
        "hora" => $_POST['hora'],
        "cancha" => $_POST['email'],
        'usuario' => $strDefaultUser,
    );

    $strQuery = "INSERT INTO ws_reservacion (fecha_reservacion, hora_reservacion, ws_cancha_id, ws_usuario_id)";
    $strQuery .= "values (:" . implode(", :", array_keys($arrUsuario)) . ")";

    $qTMP = $strConexion->prepare($strQuery);
    $qTMP->execute($arrUsuario);

} catch (PDOException $error) {
    $arrResultado['error'] = true;
    $arrResultado['mensaje'] = $error->getMessage();
}