<div class="modal fade" id="mdlCargoZapatosFieraBono" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="fa fa-keyboard"></span> Captura vales de zapato de tiendas a nómina</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row"> 
                    <div class="col-7">
                        <label>Empleado</label>
                        <div class="row">  
                            <div class="col-3"> 
                                <input id="xEmpleadoVZFB" name="xEmpleadoVZFB" class="form-control form-control-sm">
                            </div>
                            <div class="col-9"> 
                                <select id="EmpleadoVZFB" name="EmpleadoVZFB" class="form-control form-control-sm"></select>
                            </div> 
                        </div>
                    </div>
                    <div class="col-5">
                        <label>1 Vale zapato / 2 FieraBono</label>
                        <div class="row"> 
                            <div class="col-4">
                                <input id="xValeZapatoFieraBono" name="xValeZapatoFieraBono" class="form-control form-control-sm">
                            </div>
                            <div class="col-8"> 
                                <select id="ValeZapatoFieraBono" name="ValeZapatoFieraBono" class="form-control form-control-sm">
                                    <option></option>
                                    <option value="1">1 VALE ZAPATO</option>
                                    <option value="2">2 FIERA BONO</option>
                                </select>
                            </div>
                        </div>
                    </div>  
                    <div class="col-3">
                        <label>Importe</label>
                        <input type="text" id="ImporteVZFB" name="ImporteVZFB" class="form-control form-control-sm numbersOnly" maxlength="25">
                    </div>
                    <div class="col-4">
                        <label>Descontar en cuantos pagos</label>
                        <input type="text" id="DescuentoPagosVZFB" name="DescuentoPagosVZFB" class="form-control form-control-sm numbersOnly" maxlength="4">
                    </div>
                    <div class="col-2 mt-4">
                        <button type="button" class="btn btn-info btn-sm" id="btnGuardarValeFiera"><span class="fa fa-save"></span> GUARDAR</button>
                    </div>
                </div>
                <div class="w-100 text-center my-2">
                    <h3>Personal con deuda</h3>
                </div>
                <div id="ValesVZFB" class="table-responsive">
                    <table id="tblValesVZFB" class="table table-sm display " style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>No</th>
                                <th>Nombre</th>
                                <th>Importe</th>
                                <th>Pagos</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
</div>
<script>
    var mdlCargoZapatosFieraBono = $("#mdlCargoZapatosFieraBono"),
            xEmpleadoVZFB = mdlCargoZapatosFieraBono.find("#xEmpleadoVZFB"),
            EmpleadoVZFB = mdlCargoZapatosFieraBono.find("#EmpleadoVZFB"),
            ValesVZFB,
            tblValesVZFB = mdlCargoZapatosFieraBono.find("#tblValesVZFB"),
            ValeZapatoFieraBono = mdlCargoZapatosFieraBono.find("#ValeZapatoFieraBono"),
            xValeZapatoFieraBono = mdlCargoZapatosFieraBono.find("#xValeZapatoFieraBono"),
            btnGuardarValeFiera = mdlCargoZapatosFieraBono.find("#btnGuardarValeFiera"),
            ImporteVZFB = mdlCargoZapatosFieraBono.find("#ImporteVZFB"),
            DescuentoPagosVZFB = mdlCargoZapatosFieraBono.find("#DescuentoPagosVZFB");

    $(document).ready(function () {

        ValeZapatoFieraBono.change(function () {
            if ($(this).val()) {
                xValeZapatoFieraBono.val($(this).val());
                ValeZapatoFieraBono[0].selectize.disable();
                ImporteVZFB.focus();
            } else {
                xValeZapatoFieraBono.val('');
            }
        });

        xValeZapatoFieraBono.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xValeZapatoFieraBono.val()) {
                    ValeZapatoFieraBono[0].selectize.setValue(xValeZapatoFieraBono.val());
                    if (ValeZapatoFieraBono.val()) {
                        ValeZapatoFieraBono[0].selectize.disable();
                    } else {
                        iMsg('NUMERO DE DOCUMENTO INVÁLIDO, INTENTE CON OTRO', 'w', function () {
                            xValeZapatoFieraBono.focus().select();
                        });
                    }
                } else {
                    ValeZapatoFieraBono[0].selectize.clear(true);
                    ValeZapatoFieraBono[0].selectize.enable();
                }
            } else {
                ValeZapatoFieraBono[0].selectize.clear(true);
                ValeZapatoFieraBono[0].selectize.enable();
            }
        });

        EmpleadoVZFB.change(function () {
            if ($(this).val()) {
                xEmpleadoVZFB.val($(this).val());
                EmpleadoVZFB[0].selectize.disable();
                ValeZapatoFieraBono[0].selectize.focus();
            } else {
                xEmpleadoVZFB.val('');
            }
        });

        xEmpleadoVZFB.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xEmpleadoVZFB.val()) {
                    EmpleadoVZFB[0].selectize.setValue(xEmpleadoVZFB.val());
                    if (EmpleadoVZFB.val()) {
                        EmpleadoVZFB[0].selectize.disable();
                    } else {
                        iMsg('NUMERO DE EMPLEADO INVÁLIDO, INTENTE CON OTRO', 'w', function () {
                            xEmpleadoVZFB.focus().select();
                        });
                    }
                } else {
                    EmpleadoVZFB[0].selectize.clear(true);
                    EmpleadoVZFB[0].selectize.enable();
                }
            } else {
                EmpleadoVZFB[0].selectize.clear(true);
                EmpleadoVZFB[0].selectize.enable();
            }
        });

        btnGuardarValeFiera.click(function () {
            if (EmpleadoVZFB.val() && ValeZapatoFieraBono.val() &&
                    ImporteVZFB.val() && DescuentoPagosVZFB.val()) {
                EmpleadoVZFB[0].selectize.enable();
                ValeZapatoFieraBono[0].selectize.enable();
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Espere por favor...'
                });
                $.post('<?php print base_url('CargoZapatosFieraBono/onGuardarValeBono'); ?>',
                        {
                            EMPLEADO: EmpleadoVZFB.val(),
                            DOCUMENTO: ValeZapatoFieraBono.val(),
                            IMPORTE: ImporteVZFB.val(),
                            PAGOS: DescuentoPagosVZFB.val()
                        }).done(function (a) {
                    ValesVZFB.ajax.reload();
                    DescuentoPagosVZFB.val('');
                    ImporteVZFB.val('');
                    ValeZapatoFieraBono[0].selectize.clear(true);
                    EmpleadoVZFB[0].selectize.clear(true);
                    EmpleadoVZFB[0].selectize.focus();
                    EmpleadoVZFB[0].selectize.open();

                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR EL EMPLEADO, TIPO DE DOCUMENTO, IMPORTE Y LOS PAGOS', 'warning').then((value) => {
                    xEmpleadoVZFB.focus(); 
                });
            }
        });

        mdlCargoZapatosFieraBono.on('shown.bs.modal', function () {
            $.getJSON('<?php print base_url('CargoZapatosFieraBono/getEmpleados'); ?>').done(function (data) {
                EmpleadoVZFB[0].selectize.clear(true);
                EmpleadoVZFB[0].selectize.clearOptions();
                data.forEach(function (v) {
                    EmpleadoVZFB[0].selectize.addOption({text: v.EMPLEADO, value: v.CLAVE});
                });
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });
            getValesDeZapatosFieraBono();
            handleEnterDiv(mdlCargoZapatosFieraBono);
        });
    });

    function getValesDeZapatosFieraBono() {
        if ($.fn.DataTable.isDataTable('#tblValesVZFB')) {
            ValesVZFB.ajax.reload(function () {
                HoldOn.close();
            });
        } else {
            var coldefs = [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ];
            ValesVZFB = tblValesVZFB.DataTable({
                "dom": 'ritp',
                "ajax": {
                    "url": '<?php print base_url('CargoZapatosFieraBono/getRecords'); ?>',
                    "contentType": "application/json",
                    "dataSrc": "",
                    "data": function (d) {
                        d.EMPLEADO = EmpleadoVZFB.val();
                    }
                },
                buttons: buttons,
                "columns": [
                    {"data": "ID"}/*0*/,
                    {"data": "NUMERO"}/*1*/,
                    {"data": "NOMBRE"}/*2*/,
                    {"data": "IMPORTE"}/*4*/,
                    {"data": "PAGOS"}/*5*/
                ],
                "columnDefs": coldefs,
                language: lang,
                select: true,
                "autoWidth": true,
                "colReorder": true,
                "displayLength": 99999999,
                "bLengthChange": false,
                "deferRender": true,
                "scrollCollapse": false,
                "bSort": true,
                "scrollY": "400px",
                "scrollX": true,
                "aaSorting": [
                    [0, 'desc']
                ],
                initComplete: function () {
                    HoldOn.close();
                    xEmpleadoVZFB.focus();
                }
            });
        }
    }
</script>