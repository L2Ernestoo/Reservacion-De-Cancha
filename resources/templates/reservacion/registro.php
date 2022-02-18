<?php
/**
 * @author Ernesto Orellana <eorellana5c@gmail.com>
 * @date 16/02/2022 - 16:17
 */
$arrResultado = ['error' => false, 'mensaje' => 'Reseravación efectuada con exito'];

$strDefaultUser = 1;

$arrConfig = include '../../../config/database.php';

try {
    global $conn;

    if (isset($_POST['key'])) {
        parse_str($_POST['form'], $form);
        $fecha = $form['fecha'];
        $arrCancha = explode('@', $form['cancha']);
        $intCancha = $arrCancha['0'];

        $strQuery = "SELECT r.id, r.fecha_reservacion, r.hora_reservacion_inicio, r.hora_reservacion_final FROM ws_reservacion r where r.ws_cancha_id = $intCancha and r.fecha_reservacion = '$fecha'";
        $qTMP = $conn->prepare($strQuery);
        $qTMP->execute();
        $strHoras = $qTMP->fetchAll();
        $arrHorasPermitidas = array(16, 17, 18, 19, 20, 21);

        $arrHorasPermitidasAlter = array(
            1 => 16,
            2 => 17,
            3 => 18,
            4 => 19,
            5 => 20,
            6 => 21
        );
        if ($qTMP->rowCount() > 0) {
            foreach ($strHoras as $h) {
                $arrHorasReservadas[] = null;
                //Una Hora
                if ($h['hora_reservacion_inicio'] == $h['hora_reservacion_final']) {
                    $strHora = date('H', strtotime($h['hora_reservacion_inicio']));
                    $arrHorasReservadas[] = $strHora;
                } else {
                    //Varias Horas
                    $strHoraInicio = date('H', strtotime($h['hora_reservacion_inicio']));
                    $strHoraFinal = date('H', strtotime($h['hora_reservacion_final']));
                    $strRangoHoras = range($strHoraInicio, $strHoraFinal);
                    $arrHorasReservadas = array_merge($arrHorasReservadas, $strRangoHoras);
                }
            }
            echo json_encode(array_diff($arrHorasPermitidas, $arrHorasReservadas));
            return 1;

        } else {
            echo json_encode($arrHorasPermitidasAlter);
            return 1;
        }
    } else {
        $intCancha = explode('@', $_POST['cancha']);
        $intUser = 1;

        //Recibimos Reservacion
        $arrUsuario = array("fecha" => $_POST['fecha'], "hora_inicio" => $_POST['hora_inicio'], "hora_final" => $_POST['hora_final'], "cancha" => $intCancha['0'], 'usuario' => $strDefaultUser,);

        $strQuery = "INSERT INTO ws_reservacion (fecha_reservacion, hora_reservacion_inicio, hora_reservacion_final, ws_cancha_id, ws_usuario_id)";
        $strQuery .= "values (:" . implode(", :", array_keys($arrUsuario)) . ")";
        $qTMP = $conn->prepare($strQuery);
        $qTMP->execute($arrUsuario);
    }
} catch (PDOException $error) {
    $arrResultado['error'] = true;
    $arrResultado['mensaje'] = $error->getMessage();
}
