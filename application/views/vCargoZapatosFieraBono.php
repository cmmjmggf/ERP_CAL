<div class="modal fade" id="mdlCargoZapatosFieraBono" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Captura de vales de zapato de tiendas a nomina</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-8">
                        <label>Empleado</label>
                        <select id="EmpleadoVZFB" name="EmpleadoVZFB" class="form-control"></select>
                    </div>
                    <div class="col-4">
                        <label>Vale zapato / FieraBono</label>
                        <select id="ValeZapatoFieraBono" name="ValeZapatoFieraBono" class="form-control">
                            <option></option>
                            <option value="1">VALE ZAPATO</option>
                            <option value="2">FIERA BONO</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label>Importe</label>
                        <input type="text" id="ImporteVZFB" name="ImporteVZFB" class="form-control numbersOnly" maxlength="25">
                    </div>
                    <div class="col-6">
                        <label>Descontar en cuantos pagos</label>
                        <input type="text" id="DescuentoPagosVZFB" name="DescuentoPagosVZFB" class="form-control numbersOnly" maxlength="4">
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
            <div class="modal-footer"> 
                <button type="button" class="btn btn-primary" id="btnGuardarValeFiera">GUARDAR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlCargoZapatosFieraBono = $("#mdlCargoZapatosFieraBono"),
            EmpleadoVZFB = mdlCargoZapatosFieraBono.find("#EmpleadoVZFB"), ValesVZFB,
            tblValesVZFB = mdlCargoZapatosFieraBono.find("#tblValesVZFB"),
            ValeZapatoFieraBono = mdlCargoZapatosFieraBono.find("#ValeZapatoFieraBono"),
            btnGuardarValeFiera = mdlCargoZapatosFieraBono.find("#btnGuardarValeFiera"),
            ImporteVZFB = mdlCargoZapatosFieraBono.find("#ImporteVZFB"),
            DescuentoPagosVZFB = mdlCargoZapatosFieraBono.find("#DescuentoPagosVZFB");

    $(document).ready(function () {

        handleEnter();

        btnGuardarValeFiera.click(function () {
            if (EmpleadoVZFB.val() && ValeZapatoFieraBono.val() &&
                    ImporteVZFB.val() && DescuentoPagosVZFB.val()) {
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
                    console.log(a)
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR EL EMPLEADO, TIPO DE DOCUMENTO, IMPORTE Y LOS PAGOS', 'warning');
            }
        });

        mdlCargoZapatosFieraBono.on('shown.bs.modal', function () {
            getEmpleados();
            getValesDeZapatosFieraBono();
        });
    });

    function getEmpleados() {
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
    }

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
                    EmpleadoVZFB[0].selectize.focus();
                }
            });
        }
    }
</script>