<div class="modal " id="mdlLimpiaCajaAhorroPrestamosEmpleados"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Limpia Campos de Caja de Ahorro y Préstamos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row">

                        <div class="col-sm-12 mt-3">
                            <div class="table-responsive" id="EmpleadosParaLimpiarAhorraPrestamos">
                                <table id="tblEmpleadosParaLimpiarAhorraPrestamos" class="table table-sm  " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nombre</th>
                                            <th>Ahorro</th>
                                            <th>Préstamo</th>
                                            <th>Abono</th>
                                            <th>Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlLimpiaCajaAhorroPrestamosEmpleados = $('#mdlLimpiaCajaAhorroPrestamosEmpleados');
    var btnVerEmpleados = $("#btnVerEmpleados");


    var tblEmpleadosParaLimpiarAhorraPrestamos = $('#tblEmpleadosParaLimpiarAhorraPrestamos');
    var EmpleadosParaLimpiarAhorraPrestamos;

    $(document).ready(function () {


        mdlLimpiaCajaAhorroPrestamosEmpleados.on('shown.bs.modal', function () {
            handleEnterDiv(mdlLimpiaCajaAhorroPrestamosEmpleados);
            getEmpleadosParaLimpiarAhorraPrestamosPLimpiarCampos();
            //mdlLimpiaCajaAhorroPrestamosEmpleados.find('#btnImprimir').focus();
        });

        mdlLimpiaCajaAhorroPrestamosEmpleados.find('#btnImprimir').on("click", function () {
            swal({
                title: "ESTÁS SEGURO?",
                text: 'Esta acción reiniciará los valores de los préstamos y cajas de ahorro de todos los empleados',
                icon: "warning",
                closeOnClickOutside: false,
                closeOnEsc: false,
                buttons: {
                    cancelar: {
                        text: "Cancelar",
                        value: "cancelar"
                    },
                    eliminar: {
                        text: "Continuar",
                        value: "aceptar"
                    }
                }
            }).then((value) => {
                switch (value) {
                    case "aceptar":
                        HoldOn.open({theme: "sk-bounce", message: "CARGANDO DATOS..."});
                        $.ajax({
                            url: base_url + 'index.php/Empleados/onLimpiarCamposAhorroPrestamo',
                            type: "POST"
                        }).done(function (data, x, jq) {
                            EmpleadosParaLimpiarAhorraPrestamos.ajax.reload();
                            HoldOn.close();
                        }).fail(function (x, y, z) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x, y, z);
                            HoldOn.close();
                        });
                    case "cancelar":
                        swal.close();
                        break;
                }
            });

        });


    });

    function getEmpleadosParaLimpiarAhorraPrestamosPLimpiarCampos() {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblEmpleadosParaLimpiarAhorraPrestamos')) {
            tblEmpleadosParaLimpiarAhorraPrestamos.DataTable().destroy();
        }
        EmpleadosParaLimpiarAhorraPrestamos = tblEmpleadosParaLimpiarAhorraPrestamos.DataTable({
            "dom": 'frt',
            buttons: buttons,
            "ajax": {
                "url": base_url + 'index.php/Empleados/getEmpleadosCajaAhorro',
                "dataType": "json",
                "type": 'POST',
                "dataSrc": ""
            },
            "columns": [
                {"data": "Clave"},
                {"data": "Nombre"},
                {"data": "Ahorro"},
                {"data": "PressAcum"},
                {"data": "AbonoPres"},
                {"data": "SaldoPres"}

            ],
            language: lang,
            "autoWidth": true,
            "colReorder": false,
            "displayLength": 500,
            scrollY: 260,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: false,
            "bSort": true,
            "aaSorting": [

            ],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        $('#tblEmpleadosParaLimpiarAhorraPrestamos_filter input[type=search]').focus();
        tblEmpleadosParaLimpiarAhorraPrestamos.find('tbody').on('click', 'tr', function () {
            tblEmpleadosParaLimpiarAhorraPrestamos.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }

</script>