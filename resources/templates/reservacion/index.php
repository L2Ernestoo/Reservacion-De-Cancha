<?php
/**
 * @author Ernesto Orellana <eorellana5c@gmail.com>
 * @date 16/02/2022 - 13:43
 */
$error = false;
try {
    include 'config/database.php';

    function getCancha($conn){
        $strQuery = "SELECT c.id, c.precio FROM ws_cancha c";
        $qTMP = $conn->prepare($strQuery);
        $qTMP->execute();
        return $qTMP->fetchAll();
    }
    function getTipoPago($conn){
        $strQuery = "SELECT tp.id, tp.tipo_de_pago FROM ws_tipo_de_pago tp";
        $qTMP = $conn->prepare($strQuery);
        $qTMP->execute();
        return $qTMP->fetchAll();
    }

    $objCanchas = getCancha($conn);
    $objTipoPagos = getTipoPago($conn);

} catch(PDOException $error) {
    $error= $error->getMessage();
}

?>
<?php require 'resources/templates/header.php' ?>

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
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled">Bienvenido <?= $user['nombre']; ?></a>
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
                    <form id="frmReservacion">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 id="preciotxt"></h5>
                                    <div class="form-floating mb-3">
                                        <label for="title">Cancha</label>
                                        <select name="canchas" class="form-control" id="canchasSelect" required>
                                            <option hidden value="">Selecciona una Cancha</option>
                                            <?php
                                            foreach($objCanchas as $cancha){
                                                ?>
                                                <option value="<?=$cancha['id']?>@<?=$cancha['precio']?>">Cancha <?=$cancha['id']?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <label for="" class="form-label">Fecha</label>
                                        <input class="form-control" id="fechaInput" value="text" readonly type="text" name="fecha" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <label for="title">Tipo Pago</label>
                                        <select name="tipo_pago" class="form-control" id="pagoSelect" required>
                                            <option hidden value="">Selecciona una Tipo de Pago</option>
                                            <?php
                                            foreach($objTipoPagos as $tp){
                                                ?>
                                                <option value="<?=$tp['id']?>"><?=$tp['tipo_de_pago']?></option>
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


<?php require 'resources/templates/footer.php' ?>

