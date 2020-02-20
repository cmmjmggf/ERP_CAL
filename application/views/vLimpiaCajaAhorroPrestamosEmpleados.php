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
                        <div class="col-12">
                            <span class="badge badge-info" style="font-size: 14px;">
                                Nota. Para limpiar los campos de un sólo empleado capturelo, de lo contrario sólo oprima ACEPTAR
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-2" >
                            <label for="" >Empleado</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="4" required=""  id="EmpleadoLimpiaCA" name="EmpleadoLimpiaCA"   >
                        </div>
                        <div class="col-6">
                            <label>-</label>
                            <select id="sEmpleadoLimpiaCA" name="sEmpleadoLimpiaCA" class="form-control form-control-sm  ">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
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
            getEmpleadosParaLimpiarAhorraPrestamosPLimpiarCampos();
            getEmpleadosLimpiaCaptura();
            mdlLimpiaCajaAhorroPrestamosEmpleados.find('#sEmpleadoLimpiaCA')[0].selectize.clear(true);
            mdlLimpiaCajaAhorroPrestamosEmpleados.find('#sEmpleadoLimpiaCA')[0].selectize.clearOptions();
            mdlLimpiaCajaAhorroPrestamosEmpleados.find('#EmpleadoLimpiaCA').val('').focus();
        });
        mdlLimpiaCajaAhorroPrestamosEmpleados.find('#EmpleadoLimpiaCA').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtempl = $(this).val();
                if (txtempl) {
                    $.getJSON(base_url + 'index.php/ConceptosVariablesNomina/onVerificarEmpleadoComidas', {Empleado: txtempl}).done(function (data) {
                        if (data.length > 0) {
                            mdlLimpiaCajaAhorroPrestamosEmpleados.find("#sEmpleadoLimpiaCA")[0].selectize.addItem(txtempl, true);
                            mdlLimpiaCajaAhorroPrestamosEmpleados.find('#btnImprimir').focus();
                        } else {
                            swal('ERROR', 'EMPLEADO NO EXISTE O DADO DE BAJA', 'warning').then((value) => {
                                mdlLimpiaCajaAhorroPrestamosEmpleados.find('#sEmpleadoLimpiaCA')[0].selectize.clear(true);
                                mdlLimpiaCajaAhorroPrestamosEmpleados.find('#EmpleadoLimpiaCA').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                } else {
                    mdlLimpiaCajaAhorroPrestamosEmpleados.find('#sEmpleadoLimpiaCA')[0].selectize.clear(true);
                    mdlLimpiaCajaAhorroPrestamosEmpleados.find('#btnImprimir').focus();
                }
            }
        });
        mdlLimpiaCajaAhorroPrestamosEmpleados.find('#btnImprimir').on("click", function () {
            var txtempl = mdlLimpiaCajaAhorroPrestamosEmpleados.find('#EmpleadoLimpiaCA').val();
            var mensj = (txtempl) ? txtempl : 'TODOS LOS EMPLEADOS';
            swal({
                title: "ESTÁS SEGURO?",
                text: 'Esta acción reiniciará los valores de los préstamos y cajas de ahorro de ' + mensj,
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
                            type: "POST",
                            data: {
                                Empleado: mdlLimpiaCajaAhorroPrestamosEmpleados.find('#EmpleadoLimpiaCA').val()
                            }
                        }).done(function (data, x, jq) {
                            console.log(data);
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
        tblEmpleadosParaLimpiarAhorraPrestamos.find('tbody').on('click', 'tr', function () {
            tblEmpleadosParaLimpiarAhorraPrestamos.find("tbody tr").removeClass("success");
            $(this).addClass("success");
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
            "dom": 'rt',
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
    }
    function getEmpleadosLimpiaCaptura() {
        $.getJSON(base_url + 'index.php/Empleados/getEmpleadosComidasSelect', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlLimpiaCajaAhorroPrestamosEmpleados.find("#sEmpleadoLimpiaCA")[0].selectize.addOption({text: v.Nombre, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }
</script>