<!--RASTREO X CONTROL-->
<div class="modal " id="mdlRastreoXControl">
    <div class="modal-dialog modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-search"></span> RASTREO POR CONTROL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Control</label>
                        <input type="text" id="ControlRXCTROL" name="ControlRXCTROL" class="form-control form-control-sm numeric">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Semana</label>
                        <input type="text" id="SemanaRXCTROL" name="SemanaRXCTROL" class="form-control form-control-sm numeric">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <label>Empleado</label>
                        <select id="EmpleadoRXCTROL" name="EmpleadoRXCTROL" class="form-control"></select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <label>Desc.fraccion</label>
                        <input id="FraccionRXCTROL" name="FraccionRXCTROL" class="form-control"> 
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Avance actual</label>
                        <input type="text" id="AvanceActual" name="AvanceActual" class="form-control form-control-sm" readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblxRastreoXControl" class="table table-hover table-sm" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Control</th>
                                    <th scope="col">Emp</th>
                                    <th scope="col">Estilo</th>
                                    <th scope="col">Frac</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Semana</th>
                                    <th scope="col">Pares</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">SubTotal</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="right">
                        <p class="font-weight-bold total_pesos" style="color: #cc0033 !important;" >$0.0</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">Acepta</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlRastreoXControl = $("#mdlRastreoXControl"),
            RastreoXConcepto,
            xRastreoXControl, tblxRastreoXControl = mdlRastreoXControl.find("#tblxRastreoXControl"),
            ControlRXCTROL = mdlRastreoXControl.find("#ControlRXCTROL"),
            SemanaRXCTROL = mdlRastreoXControl.find("#SemanaRXCTROL"),
            EmpleadoRXCTROL = mdlRastreoXControl.find("#EmpleadoRXCTROL"),
            FraccionRXCTROL = mdlRastreoXControl.find("#FraccionRXCTROL"),
            AvanceActual = mdlRastreoXControl.find("#AvanceActual");
    var coldefs = [
        {
            "targets": [0],
            "visible": false,
            "searchable": false
        }
    ];
    $(document).ready(function () {
        handleEnterDiv(mdlRastreoXControl);

        FraccionRXCTROL.on('keyup change', function () {
            if ($(this).val()) {
                xRastreoXControl.ajax.reload();
            }
        });

        EmpleadoRXCTROL.change(function (e) {
            xRastreoXControl.ajax.reload();
        });
        SemanaRXCTROL.on('keydown', function (e) {
            if (e.keyCode === 13) {
                xRastreoXControl.ajax.reload();
            }
        });

        ControlRXCTROL.on('keydown', function (e) {
            if (e.keyCode === 13) {
                xRastreoXControl.ajax.reload();
            }
        });
        mdlRastreoXControl.on('hidden.bs.modal', function () {
            Control.focus().select();
        });

        mdlRastreoXControl.on('shown.bs.modal', function () {
            onClear(EmpleadoRXCTROL);
            onClearSelect(EmpleadoRXCTROL);
            $.getJSON('<?php print base_url('Avance/getEmpleados'); ?>').done(function (d) {
                d.forEach(function (v) {
                    EmpleadoRXCTROL[0].selectize.addOption({text: v.EMPLEADO, value: v.CLAVE});
                });
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            });
            if ($.fn.DataTable.isDataTable('#tblxRastreoXControl')) {
                xRastreoXControl.ajax.reload();
                return;
            } else {
                xRastreoXControl = tblxRastreoXControl.DataTable({
                    "dom": 'ritp',
                    "ajax": {
                        "url": '<?php print base_url('Avance/getRastreoXControl'); ?>',
                        "contentType": "application/json",
                        "dataSrc": "",
                        "data": function (d) {
                            d.CONTROL = ControlRXCTROL.val() ? ControlRXCTROL.val() : '';
                            d.SEMANA = SemanaRXCTROL.val() ? SemanaRXCTROL.val() : '';
                            d.EMPLEADO = EmpleadoRXCTROL.val() ? EmpleadoRXCTROL.val() : '';
                        }
                    },
                    buttons: buttons,
                    "columns": [
                        {"data": "ID"}/*0*/,
                        {"data": "CONTROL"}/*1*/,
                        {"data": "EMPLEADO"}/*2*/,
                        {"data": "ESTILO"}/*3*/,
                        {"data": "NUM_FRACCION"}/*4*/,
                        {"data": "FECHA"}/*5*/,
                        {"data": "SEMANA"}/*6*/,
                        {"data": "PARES"}/*7*/,
                        {"data": "PRECIO_FRACCION"}/*8*/,
                        {"data": "SUBTOTAL"}/*10*/
                    ],
                    "columnDefs": coldefs, language: lang,
                    select: true,
                    "autoWidth": true,
                    "colReorder": true,
                    "displayLength": 50,
                    "bLengthChange": false,
                    "deferRender": true,
                    "scrollCollapse": false,
                    "bSort": true,
                    "scrollY": "250px",
                    "scrollX": true,
                    "aaSorting": [
                        [0, 'desc']
                    ],
                    "drawCallback": function (settings) {
                        var api = this.api();
                        var r = 0, prs = 0;
                        $.each(api.rows().data(), function (k, v) {
                            r += parseFloat(v.SUBTOTAL);
                        });
                        mdlRastreoXControl.find(".total_pesos").text("$ " + r.toFixed(3));
                    }
                });
                tblxRastreoXControl.find('tbody').on('click', 'tr', function () {
                    var row = xRastreoXControl.row(this).data();
                    console.log(row);
                    SemanaRXCTROL.val(row.SEMANA);
                    EmpleadoRXCTROL[0].selectize.setValue(row.EMPLEADO);
                    $.post('<?php print base_url('Avance/getInfoXControlParaRastreo'); ?>', {
                        CONTROL: row.CONTROL,
                        FRACCION: row.NUM_FRACCION
                    }).done(function (a) {
                        console.log(a, a.length);
                        if (a.length > 0) {
                            var r = JSON.parse(a);
                            console.log(r);
                            FraccionRXCTROL.val(r[0].FRACCION_DES);
                            AvanceActual.val(r[0].AVANCE_ACTUAL);
                        }
                    }).fail(function (x) {
                        getError(x);
                    });
                });
            }
            mdlRastreoXControl.find("input").val('');
            $.each(mdlRastreoXControl.find("select"), function (k, v) {
                mdlRastreoXControl.find("select")[k].selectize.clear(true);
            });
            ControlRXCTROL.focus();
        });
    });
</script>