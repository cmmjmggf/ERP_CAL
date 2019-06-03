<div class="modal " id="mdlCapturaCajaAhorroDirecta"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Captura Caja de Ahorro Directa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row">
                        <div class="col-8">
                            <label>Empleado</label>
                            <select id="Empleado" name="Empleado" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label>Importe</label>
                            <input type="text" maxlength="7" class="form-control form-control-sm numbersOnly" id="Importe" name="Importe" >
                        </div>
                        <div class="col-sm-12" align="center">
                            <label class="badge badge-primary" style="font-size: 14px;">Personal con ahorro</label>
                        </div>

                        <div class="col-sm-12 mt-3">
                            <div class="table-responsive" id="EmpleadosConAhorro">
                                <table id="tblEmpleadosConAhorro" class="table table-sm  " style="width:100%">
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
                <button type="button" class="btn btn-info" id="btnVerEmpleados">EMPLEADOS</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlCapturaCajaAhorroDirecta = $('#mdlCapturaCajaAhorroDirecta');
    var btnVerEmpleados = $("#btnVerEmpleados");


    var tblEmpleadosConAhorro = $('#tblEmpleadosConAhorro');
    var EmpleadosConAhorro;

    $(document).ready(function () {


        btnVerEmpleados.click(function () {
            $.fancybox.open({
                src: base_url + '/Empleados.shoes/?origen=NOMINAS',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
                        console.info('done!');
                    },
                    iframe: {
                        // Iframe template
                        tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                        preload: true,
                        // Custom CSS styling for iframe wrapping element
                        // You can use this to set custom iframe dimensions
                        css: {
                            width: "100%",
                            height: "100%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });

        mdlCapturaCajaAhorroDirecta.on('shown.bs.modal', function () {
            mdlCapturaCajaAhorroDirecta.find("input").val("");
            $.each(mdlCapturaCajaAhorroDirecta.find("select"), function (k, v) {
                mdlCapturaCajaAhorroDirecta.find("select")[k].selectize.clear(true);
            });
            getEmpleadosConAhorro();
            getEmpleadosCajaAhorroSelect();
            mdlCapturaCajaAhorroDirecta.find('#Empleado')[0].selectize.focus();
        });

        mdlCapturaCajaAhorroDirecta.find("#Empleado").change(function () {
            HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
            $.getJSON(base_url + 'index.php/Empleados/getEmpleadoByNumeroExt', {Numero: $(this).val()}).done(function (data) {
                mdlCapturaCajaAhorroDirecta.find("#Importe").val(data[0].Ahorro);
                HoldOn.close();
            }).fail(function (x) {
                HoldOn.close();
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });
        });

        mdlCapturaCajaAhorroDirecta.find('#btnImprimir').on("click", function () {

            var empleado = mdlCapturaCajaAhorroDirecta.find("#Empleado").val();
            var importe = mdlCapturaCajaAhorroDirecta.find("#Importe").val();
            HoldOn.open({theme: "sk-bounce", message: "CARGANDO DATOS..."});
            $.ajax({
                url: base_url + 'index.php/Empleados/onModificarExt',
                type: "POST",
                data: {
                    Numero: empleado,
                    Ahorro: importe
                }
            }).done(function (data, x, jq) {
                EmpleadosConAhorro.ajax.reload();
                mdlCapturaCajaAhorroDirecta.find("input").val("");
                $.each(mdlCapturaCajaAhorroDirecta.find("select"), function (k, v) {
                    mdlCapturaCajaAhorroDirecta.find("select")[k].selectize.clear(true);
                });
                HoldOn.close();
                mdlCapturaCajaAhorroDirecta.find('#Empleado')[0].selectize.focus();
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x, y, z);
                HoldOn.close();
            });
        });


    });

    function getEmpleadosConAhorro() {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblEmpleadosConAhorro')) {
            tblEmpleadosConAhorro.DataTable().destroy();
        }
        EmpleadosConAhorro = tblEmpleadosConAhorro.DataTable({
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
            scrollY: 240,
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
        $('#tblEmpleadosConAhorro_filter input[type=search]').addClass('selectNotEnter');
        tblEmpleadosConAhorro.find('tbody').on('click', 'tr', function () {
            tblEmpleadosConAhorro.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }

    function getEmpleadosCajaAhorroSelect() {
        $.getJSON(base_url + 'index.php/Empleados/getEmpleadosCajaAhorro', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlCapturaCajaAhorroDirecta.find("#Empleado")[0].selectize.addOption({text: v.Clave + ' ' + v.Nombre, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

</script>