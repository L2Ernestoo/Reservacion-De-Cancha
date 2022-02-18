$(function () {
    const selectCanchas = $('#canchasSelect')
    const selectTipoPago = $('#pagoSelect')
    const txtPrecio = $('#preciotxt')
    const frmFecha = $('#fechaInput')
    $("#frmReservacion").submit(function (e) {

        e.preventDefault();
        e.stopImmediatePropagation();

        $("#btnAccion").prop("disabled", true);
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
    function consultarHorario() {
        $('#horaSelect, #horaSelectFinal').empty()
        $.ajax({
            type: "POST",
            url: 'resources/templates/reservacion/registro.php',
            data: {form: $('#frmReservacion').serialize(), key: 'horarios'},
            success: function (data) {
                var $select = $('#horaSelect');
                var $select_final = $('#horaSelectFinal')
                $.each(JSON.parse(data),function(key, value)
                {
                    $select.append('<option value=' + value + ':00:00' + '>' + value + ':00</option>');
                    $select_final.append('<option value=' + value + ':00:00' + '>' + value + ':00</option>');
                });
            }
        });
    }
    selectCanchas.change(function () {
        sinCancha = selectCanchas.val().split('@')
        txtPrecio.html('El Precio de la cancha es Q' + Number.parseFloat(sinCancha['1']).toFixed(2))
        consultarHorario()
    });
});


