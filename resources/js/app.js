
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    const today = new Date();

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        weekday: 'long',
        editable: true,
        hiddenDays: [1, 2],
        validRange: {
            start: today,
        },
        dateClick: function (info) {
            $('#myModal').modal('show')
            document.getElementById('fechaInput').value = info.dateStr
        },
    });
    calendar.render();
});


$(function () {
    const selectCanchas = $('#canchasSelect')
    const selectTipoPago = $('#pagoSelect')
    const txtPrecio = $('#preciotxt')

    $("#frmReservacion").on("submit", function (e) {
        e.preventDefault();
        sendReservation();
    });

    selectCanchas.change(function () {
        sinCancha = selectCanchas.val().split('@')
        txtPrecio.html('El Precio de la cancha es Q' + Number.parseFloat(sinCancha['1']).toFixed(2))
    });
});

function consultarHorario() {

}

function sendReservation() {
    let frm = document.getElementById("frmReservacion");
    $.ajax({
        type: "POST",
        url: 'reservacion/registro.php',
        data: frm.serialize(),
        success: function (data) {
            document.getElementById("formUsuario").reset();
            Swal.fire(
                'Usuario Registrado!',
                'Todo OK',
                'success'
            )
        }
    });
}