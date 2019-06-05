<div class="modal " id="mdlRastreoControlNomina"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rastreo de controles ya capturados en nómina</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoRastreo" name="AnoRastreo" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="SemRastreo" name="SemRastreo" required="">
                        </div>
                        <div class="col-6 col-xs-6 col-sm-3 col-lg-3 col-xl-3">
                            <label>Control</label>
                            <input type="text" id="ControlRastreo" name="ControlRastreo" maxlength="10" class="form-control form-control-sm numeric" required="">
                        </div>
                        <div class="col-5">
                            <label>Estatus Producción</label>
                            <input type="text" class="form-control form-control-sm" readonly="" id="EstatusProduccionRastreo" name="EstatusProduccionRastreo" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <label>Empleado</label>
                            <select id="EmpleadoRastreo" name="EmpleadoRastreo" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-5">
                            <label>Fracción</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" readonly="" id="FraccionRastreo" name="FraccionRastreo" >
                        </div>
                        <div class="col-sm-12 mt-3">
                            <div class="table-responsive" id="ControlesNominaRastreo">
                                <table id="tblControlesNominaRastreo" class="table table-sm  " style="width:100%">
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
    var mdlRastreoControlNomina = $('#mdlRastreoControlNomina');
    var tblControlesNominaRastreo = $('#tblControlesNominaRastreo');
    var ControlesNominaRastreo;


    var sem_ini = 0;
    $(document).ready(function () {

        mdlRastreoControlNomina.on('shown.bs.modal', function () {
            mdlRastreoControlNomina.find("input").not('#SemRastreo').val("");
            $.each(mdlRastreoControlNomina.find("select"), function (k, v) {
                mdlRastreoControlNomina.find("select")[k].selectize.clear(true);
            });
            mdlRastreoControlNomina.find("#AnoRastreo").val(new Date().getFullYear());
            getControlesNominaRastreo('', new Date().getFullYear(), sem_ini, '');
            getEmpleadosRastreoControl();
            mdlRastreoControlNomina.find('#SemRastreo').focus().select();
        });

        mdlRastreoControlNomina.find("#AnoRastreo").change(function () {
            if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    mdlRastreoControlNomina.find("#AnoRastro").val("");
                    mdlRastreoControlNomina.find("#AnoRastro").focus();
                });
            } else {
                anoRastreo = $(this).val();
//                getControlesNominaRastreo(contRastreo, anoRastreo, semRastreo, empRastreo);
            }
        });
        mdlRastreoControlNomina.find("#SemRastreo").keydown(function (e) {
            if (e.keyCode === 13) {
                var ano = mdlRastreoControlNomina.find("#AnoRastreo");
                onComprobarSemanasNominaRastreo($(this), ano.val());

            }
        });
        mdlRastreoControlNomina.find("#EmpleadoRastreo").change(function () {

            var semRastreo = mdlRastreoControlNomina.find("#SemRastreo").val();
            var contRastreo = mdlRastreoControlNomina.find("#ControlRastreo").val();
            var anoRastreo = mdlRastreoControlNomina.find("#AnoRastreo").val();
            var empRastreo = $(this).val();
            getControlesNominaRastreo(contRastreo, anoRastreo, semRastreo, empRastreo);

        });
        mdlRastreoControlNomina.find("#ControlRastreo").change(function () {
            if ($(this).val()) {
                var semRastreo = mdlRastreoControlNomina.find("#SemRastreo").val();
                var contRastreo = $(this).val();
                var anoRastreo = mdlRastreoControlNomina.find("#AnoRastreo").val();
                var empRastreo = mdlRastreoControlNomina.find("#EmpleadoRastreo").val();
                getControlesNominaRastreo(contRastreo, anoRastreo, semRastreo, empRastreo);
            }
        });
        mdlRastreoControlNomina.find('#btnImprimir').on("click", function () {

            var empleado = mdlRastreoControlNomina.find("#Empleado").val();
            var importe = mdlRastreoControlNomina.find("#Importe").val();
            HoldOn.open({theme: "sk-bounce", message: "CARGANDO DATOS..."});
            $.ajax({
                url: base_url + 'index.php/Empleados/onModificarExt',
                type: "POST",
                data: {
                    Numero: empleado,
                    Ahorro: importe
                }
            }).done(function (data, x, jq) {
                ControlesNominaRastreo.ajax.reload();
                mdlRastreoControlNomina.find("input").val("");
                $.each(mdlRastreoControlNomina.find("select"), function (k, v) {
                    mdlRastreoControlNomina.find("select")[k].selectize.clear(true);
                });
                HoldOn.close();
                mdlRastreoControlNomina.find('#Empleado')[0].selectize.focus();
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x, y, z);
                HoldOn.close();
            });
        });

    });

    function getControlesNominaRastreo(cont, ano, sem, empl) {
        //HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblControlesNominaRastreo')) {
            tblControlesNominaRastreo.DataTable().destroy();
        }
        ControlesNominaRastreo = tblControlesNominaRastreo.DataTable({
            "dom": 'frtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getControlesNominaRastreo',
                "dataType": "json",
                "type": 'GET',
                "data": {Control: cont, Ano: ano, Sem: sem, Emp: empl},
                "dataSrc": ""
            },
            "columns": [
                {"data": "control"},
                {"data": "numeroempleado"},
                {"data": "estilo"}
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": false,
            "displayLength": 500,
            scrollY: 320,
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
        $('#tblControlesNominaRastreo_filter input[type=search]').addClass('selectNotEnter');
        tblControlesNominaRastreo.find('tbody').on('click', 'tr', function () {
            tblControlesNominaRastreo.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }

    function getEmpleadosRastreoControl() {
        $.getJSON(master_url + 'getEmpleados', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlRastreoControlNomina.find("#EmpleadoRastreo")[0].selectize.addOption({text: v.Empleado, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function onComprobarSemanasNominaRastreo(v, ano) {
        if ($(v).val() > 52) {
            $(v).val('');
            $(v).focus();
        } else {
            var semRastreo = $(v).val();
            var contRastreo = mdlRastreoControlNomina.find("#ControlRastreo").val();
            var anoRastreo = mdlRastreoControlNomina.find("#AnoRastreo").val();
            var empRastreo = mdlRastreoControlNomina.find("#EmpleadoRastreo").val();
            getControlesNominaRastreo(contRastreo, anoRastreo, semRastreo, empRastreo);
        }
    }

</script>