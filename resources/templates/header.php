<?php
/**
 * @author Ernesto Orellana <eorellana5c@gmail.com>
 * @date 16/02/2022 - 13:43
 */

$error = false;
$arrConfig = include 'config.php';

try {
    $strbd = 'mysql:host=' . $arrConfig['db']['host'] . ';dbname=' . $arrConfig['db']['name'];
    $strConexion = new PDO($strbd, $arrConfig['db']['user'], $arrConfig['db']['pass'], $arrConfig['db']['options']);

    function getCancha($strConexion){
        $strQuery = "SELECT c.id FROM ws_cancha c";

        $qTMP = $strConexion->prepare($strQuery);
        $qTMP->execute();

        return $qTMP->fetchAll();
    }
    function getTipoPago($strConexion){
        $strQuery = "SELECT tp.id, tp.tipo_de_pago FROM ws_tipo_de_pago tp";

        $qTMP = $strConexion->prepare($strQuery);
        $qTMP->execute();

        return $qTMP->fetchAll();
    }

    $objCanchas = getCancha($strConexion);
    $objTipoPagos = getTipoPago($strConexion);

} catch(PDOException $error) {
    $error= $error->getMessage();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>FUTECA - RESERVACIONES</title>
    <link href="./resources/css/bootstrap.min.css" rel="stylesheet">
    <meta name="theme-color" content="#7952b3">
    <link href='./resources/js/fullcalendar/main.css' rel='stylesheet' />
    <script src='./resources/js/fullcalendar/main.js'></script>
    <script src='./resources/js/fullcalendar/locales/es.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="./resources/js/bootstrap.bundle.min.js"></script>
    <script src="./resources/js/app.js"></script>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        /* Show it is fixed to the top */
        body {
            min-height: 75rem;
            padding-top: 4.5rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">FUTECA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Realizar Reservación</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled">Registro</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container">
    <div class="bg-light p-5 rounded">
        <h1>Realizar Reservación</h1>
        <p class="lead">Realiza tu reservación para jugar con tus cuates.</p>
        <div id='calendar'></div>
        <div class="modal fade " id="myModal" tabindex="-1" aria-labelledby="Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulo">Registro de Eventos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="frmReservacion" autocomplete="off">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <label for="title">Cancha</label>
                                        <select class="form-control" id="canchasSelect" required>
                                            <option hidden value="">Selecciona una Cancha</option>
                                            <?php
                                                foreach($objCanchas as $cancha){
                                            ?>
                                                    <option value="<?=$cancha['id']?>">Cancha <?=$cancha['id']?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <label for="" class="form-label">Fecha</label>
                                        <input class="form-control" id="fechaInput" value="text" disabled type="text" name="start" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <label for="title">Tipo Pago</label>
                                        <select class="form-control" id="pagoSelect" required>
                                            <option hidden value="">Selecciona una Tipo de Pago</option>
                                            <?php
                                            foreach($objTipoPagos as $tp){
                                                ?>
                                                <option value="<?=$tp['id']?>">Cancha <?=$tp['tipo_de_pago']?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnAccion">Reservar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>


<script src='./resources/js/fullcalendar/main.js'></script>


</body>
</html>
