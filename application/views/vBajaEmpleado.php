<div class="modal " id="mdlBajaEmpleado"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Capture Fecha de Egreso y Motivo de Egreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pnlCapturaBajaEmpleado">
                <form id="frmCaptura">
                    <div class="row" id='selectEmpRecibos'>
                        <div class="col-4" >
                            <label>Fecha Egreso</label>
                            <input type="text" maxlength="10" class="form-control form-control-sm date notEnter" id="Egreso" name="Egreso" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label>Motivo: <span class="badge badge-danger" style="font-size: 14px;">Capture el motivo de la baja</span></label>
                            <input type="text" maxlength="500" class="form-control form-control-sm " id="MotivoBaja" name="MotivoBaja" required="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptar">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlBajaEmpleado = $('#mdlBajaEmpleado');

    $(document).ready(function () {
        handleEnterDiv(mdlBajaEmpleado);
        mdlBajaEmpleado.on('shown.bs.modal', function () {
            mdlBajaEmpleado.find("input").val("");
            mdlBajaEmpleado.find('#Egreso').focus();
        });

        mdlBajaEmpleado.find('#btnAceptar').click(function () {
            isValid('pnlCapturaBajaEmpleado');
            if (valido) {
                var frm = new FormData(mdlBajaEmpleado.find("#frmCaptura")[0]);
                frm.append('Numero', numeroEmp);
                frm.append('AltaBaja', 2);
                $.ajax({
                    url: base_url + 'index.php/Empleados/onModificarExt',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    swal({
                        title: "ATENCIÓN",
                        text: "EMPLEADO DADO DE BAJA CORRECTAMENTE",
                        icon: "success",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        mdlBajaEmpleado.modal('hide');
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });
    });
</script>
