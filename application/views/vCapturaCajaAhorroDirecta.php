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
                        <div class="col-10" >
                            <label>Empleado</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm  numbersOnly " id="Empleado" name="Empleado" maxlength="6" required="">
                                </div>
                                <div class="col-9">
                                    <select id="sEmpleado" name="sEmpleado" class="form-control form-control-sm required NotSelectize selectNotEnter" required="" >
                                        <option value=""></option>
                                        <?php
                                        foreach ($this->db->select("CAST(E.numero AS SIGNED ) AS Clave, CONCAT(E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS Empleado ", false)
                                                ->from('empleados AS E')->where_in('E.altabaja', '1')->order_by('Clave', 'ASC')->get()->result() as $k => $v) {
                                            print "<option value='{$v->Clave}'>{$v->Empleado}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
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
        mdlCapturaCajaAhorroDirecta.find("select").selectize({
            hideSelected: false,
            openOnFocus: false
        });

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
            validacionSelectPorContenedor(mdlCapturaCajaAhorroDirecta);
            mdlCapturaCajaAhorroDirecta.find("input").val("");
            $.each(mdlCapturaCajaAhorroDirecta.find("select"), function (k, v) {
                mdlCapturaCajaAhorroDirecta.find("select")[k].selectize.clear(true);
            });
            getEmpleadosConAhorro();
            mdlCapturaCajaAhorroDirecta.find('#Empleado').focus();
        });

        mdlCapturaCajaAhorroDirecta.find('#Empleado').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtempl = $(this).val();
                if (txtempl) {
                    $.getJSON(base_url + 'index.php/Empleados/getEmpleadoByNumeroExt', {Numero: txtempl}).done(function (data) {
                        if (data.length > 0) {
                            mdlCapturaCajaAhorroDirecta.find("#sEmpleado")[0].selectize.addItem(txtempl, true);
                            mdlCapturaCajaAhorroDirecta.find("#Importe").val(data[0].Ahorro).focus().select();
                        } else {
                            swal('ERROR', 'EMPLEADO NO EXISTE O DADO DE BAJA', 'warning').then((value) => {
                                mdlCapturaCajaAhorroDirecta.find('#sEmpleado')[0].selectize.clear(true);
                                mdlCapturaCajaAhorroDirecta.find('#Importe').val('');
                                mdlCapturaCajaAhorroDirecta.find('#Empleado').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        HoldOn.close();
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });

        mdlCapturaCajaAhorroDirecta.find("#sEmpleado").change(function () {
            if ($(this).val()) {
                mdlCapturaCajaAhorroDirecta.find('#Empleado').val($(this).val());
                $.getJSON(base_url + 'index.php/Empleados/getEmpleadoByNumeroExt', {Numero: $(this).val()}).done(function (data) {
                    mdlCapturaCajaAhorroDirecta.find("#Importe").val(data[0].Ahorro).focus().select();
                }).fail(function (x) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });

        mdlCapturaCajaAhorroDirecta.find('#Importe').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtempl = $(this).val();
                if (txtempl) {
                    mdlCapturaCajaAhorroDirecta.find('#btnImprimir').focus();
                }
            }
        });

        mdlCapturaCajaAhorroDirecta.find('#btnImprimir').on("click", function () {
            onDisable(mdlCapturaCajaAhorroDirecta.find('#btnImprimir'));
            var empleado = mdlCapturaCajaAhorroDirecta.find("#Empleado").val();
            var importe = mdlCapturaCajaAhorroDirecta.find("#Importe").val();
            $.ajax({
                url: base_url + 'index.php/Empleados/onModificarExt',
                type: "POST",
                data: {
                    Numero: empleado,
                    Ahorro: importe
                }
            }).done(function (data, x, jq) {
                onEnable(mdlCapturaCajaAhorroDirecta.find('#btnImprimir'));
                EmpleadosConAhorro.ajax.reload();
                mdlCapturaCajaAhorroDirecta.find("input").val("");
                $.each(mdlCapturaCajaAhorroDirecta.find("select"), function (k, v) {
                    mdlCapturaCajaAhorroDirecta.find("select")[k].selectize.clear(true);
                });
                mdlCapturaCajaAhorroDirecta.find('#Empleado').focus();
            }).fail(function (x, y, z) {
                onEnable(mdlCapturaCajaAhorroDirecta.find('#btnImprimir'));
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });
    function getEmpleadosConAhorro() {
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
            "displayLength": 450,
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
</script>