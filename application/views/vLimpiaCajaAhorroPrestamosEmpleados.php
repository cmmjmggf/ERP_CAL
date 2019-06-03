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
                                            <th>Importe</th>
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
            getEmpleadosParaLimpiarAhorraPrestamosPLimpiarCampos();
        });

        mdlLimpiaCajaAhorroPrestamosEmpleados.find('#btnImprimir').on("click", function () {

            HoldOn.open({theme: "sk-bounce", message: "CARGANDO DATOS..."});
            $.ajax({
                url: base_url + 'index.php/Empleados/onModificarExt',
                type: "POST"
            }).done(function (data, x, jq) {
                EmpleadosParaLimpiarAhorraPrestamos.ajax.reload();
                HoldOn.close();
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x, y, z);
                HoldOn.close();
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
                {"data": "Ahorro"}
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": false,
            "displayLength": 50,
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
        $('#tblEmpleadosParaLimpiarAhorraPrestamos_filter input[type=search]').addClass('selectNotEnter');
        tblEmpleadosParaLimpiarAhorraPrestamos.find('tbody').on('click', 'tr', function () {
            tblEmpleadosParaLimpiarAhorraPrestamos.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }

    function getEmpleadosCajaAhorroSelect() {
        $.getJSON(base_url + 'index.php/Empleados/getEmpleadosCajaAhorro', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlLimpiaCajaAhorroPrestamosEmpleados.find("#Empleado")[0].selectize.addOption({text: v.Clave + ' ' + v.Nombre, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

</script>