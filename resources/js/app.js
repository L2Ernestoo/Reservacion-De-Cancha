const calendarEl = document.getElementById('calendar');
const formReservacion = document.getElementById('formulario');
const btnEliminar = document.getElementById('btnEliminar');
const today = new Date();

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        editable: true,
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


$(function(){
    $("#frmReservacion").on("submit", function(e){
        e.preventDefault();
        sendReservation();
    });
});


function sendReservation(){
    let frm = document.getElementById("frmReservacion");
    $.ajax({
        type: "POST",
        url: actionUrl,
        data: frm.serialize(),
        success: function(data)
        {
            document.getElementById("formUsuario").reset();
            Swal.fire(
                'Usuario Registrado!',
                'Todo OK',
                'success'
            )
        }
    });
}