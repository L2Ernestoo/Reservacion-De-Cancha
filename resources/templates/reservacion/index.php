<?php
/**
 * @author Ernesto Orellana <eorellana5c@gmail.com>
 * @date 16/02/2022 - 13:43
 */
$error = false;
try {
    include 'config/database.php';
    function getCancha(){
        global $conn;
        $strQuery = "SELECT c.id, c.precio FROM ws_cancha c";
        $qTMP = $conn->prepare($strQuery);
        $qTMP->execute();
        return $qTMP->fetchAll();
    }
    function getTipoPago(){
        global $conn;
        $strQuery = "SELECT tp.id, tp.tipo_de_pago FROM ws_tipo_de_pago tp";
        $qTMP = $conn->prepare($strQuery);
        $qTMP->execute();
        return $qTMP->fetchAll();
    }

    function getEventos(){
        global $conn;
        $intUser = $_SESSION['user_id'];
        $strQuery = "SELECT r.id, r.fecha_reservacion, r.hora_reservacion, r.ws_cancha_id, r.ws_usuario_id FROM ws_reservacion r WHERE r.ws_usuario_id = $intUser";
        $qTMP = $conn->prepare($strQuery);
        $qTMP->execute();
        return $qTMP->fetchAll();
    }

    $objCanchas = getCancha();
    $objTipoPagos = getTipoPago();
    $objEventos = getEventos();
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
                                        <select name="cancha" class="form-control" id="canchasSelect" required>
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
                                        <label for="title">Hora</label>
                                        <select name="hora" class="form-control" id="horaSelect" required>
                                            <option hidden value="">Selecciona la hora a reservar</option>
                                            <?php
                                            for($i=16; $i<22; $i++){
                                                ?>
                                                <option value="<?=$i?>:00:00"><?=$i?>:00</option>
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
<script>


    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        const today = new Date();

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            editable: true,
            hiddenDays: [1, 2],
            validRange: {
                start: today,
            },
            dateClick: function (info) {
                $('#myModal').modal('show')
                document.getElementById('fechaInput').value = info.dateStr
            },
            events: [
                <?php foreach($objEventos as $event):

                ?>
                {
                    id: '<?php echo $event['id']; ?>',
                    title: 'Reserva Cancha <?php echo $event['ws_cancha_id']; ?>',
                    start: '<?php echo $event['fecha_reservacion'] .' '.$event['hora_reservacion']; ?>',
                    end: '<?php echo $event['fecha_reservacion'] .' '. ($event['hora_reservacion']); ?>',
                    color: '#0071c5',
                },
                <?php endforeach; ?>
            ],
        });
        calendar.render();
    });
</script>

<?php require 'resources/templates/footer.php' ?>

