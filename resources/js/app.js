$(function () {
    const selectCanchas = $('#canchasSelect')
    const selectTipoPago = $('#pagoSelect')
    const txtPrecio = $('#preciotxt')

    $("#frmReservacion").submit(function(e){

        e.preventDefault();
        e.stopImmediatePropagation();

        $("#btnAccion").prop( "disabled", true);
        $.ajax({
            type: "POST",
            url: 'resources/templates/reservacion/registro.php',
            data: $(this).serialize(),
            success: function (data) {
                $('#frmReservacion').trigger("reset");
                $('#myModal').modal('hide')

                Swal.fire(
                    'Cancha Reservada!',
                    'Todo OK',
                    'success'
                )
                location.reload();
            }
        });

        return false;
    });

    selectCanchas.change(function () {
        sinCancha = selectCanchas.val().split('@')
        txtPrecio.html('El Precio de la cancha es Q' + Number.parseFloat(sinCancha['1']).toFixed(2))
    });
});

function consultarHorario() {

}
