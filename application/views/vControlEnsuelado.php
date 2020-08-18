<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Captura controles para ensuelado</legend>
            </div>
            <div class="col-6" align="right">
            </div>
        </div>
        <hr>
        <div class="row" id = "pnlCaptura">
            <div class="col-12 col-sm-1 col-md-2 col-lg-1 col-xl-1" >
                <label for="" >Empleado</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="6" required=""  id="Empleado" name="Empleado"   >
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-3">
                <label>-</label>
                <select id="sEmpleado" name="sEmpleado" class="form-control form-control-sm required NotSelectize" ></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-1">
                <label>Fecha</label>
                <input type="text" id="Fecha" name="Fecha" class="form-control form-control-sm date notEnter" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-2">
                <label>Control</label>
                <input type="text" id="Control" name="Control" class="form-control form-control-sm numbersOnly" required="">
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-1">
                <label>Estilo</label>
                <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm" readonly="" required="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-3">
                <label>Color</label>
                <input type="text" id="Color" name="Color" class="form-control form-control-sm" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-1">
                <label>Pares</label>
                <input type="text" id="Pares" name="Pares" class="form-control form-control-sm numbersOnly" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 mt-4">
                <button type="button" class="btn btn-primary btn-sm" id="btnAcepta" disabled=""><span class="fa fa-check"></span> ACEPTA </button>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card-block mt-4">
                    <div id="ControlEnsuelado" class="table-responsive">
                        <table id="tblControlEnsuelado" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>No. Emp</th>
                                    <th>Nombre de Empleado</th>
                                    <th>Control</th>
                                    <th>Fecha</th>
                                    <th>-</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var pnlTablero = $("#pnlTablero"), pnlCaptura = $("#pnlCaptura"),
            ControlEnsuelado, tblControlEnsuelado = pnlTablero.find("#tblControlEnsuelado"),
            sEmpleado = pnlTablero.find("#sEmpleado"),
            Empleado = pnlTablero.find("#Empleado"),
            Control = pnlTablero.find("#Control"),
            Estilo = pnlTablero.find("#Estilo"), Color = pnlTablero.find("#Color"),
            Pares = pnlTablero.find("#Pares"), Fecha = pnlTablero.find("#Fecha"),
            btnAcepta = pnlTablero.find("#btnAcepta");

    var FechaActual = '<?php print Date('d/m/Y'); ?>';


    $(document).ready(function () {
        handleEnterDiv(pnlCaptura);
        pnlTablero.find('select').selectize({
            openOnFocus: false
        });
        Fecha.val('<?php print Date('d/m/Y') ?>');
        Empleado.focus();
        getEmpleados();
        getRecords();
        Empleado.on('keydown', function (e) {
            if (e.keyCode === 13) {
                var txtemp = $(this).val();
                if (txtemp) {
                    $.getJSON('<?php print base_url('ControlEnsuelado/onVerificarEmpleado'); ?>', {Empleado: txtemp}).done(function (data) {

                        if (data.length > 0) {
                            sEmpleado[0].selectize.addItem(txtemp, true);
                            Control.focus().select();
                        } else {
                            swal('ERROR', 'EL EMPLEADO CAPTURADO NO EXISTE', 'warning').then((value) => {
                                sEmpleado[0].selectize.clear(true);
                                Empleado.focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });

        sEmpleado.change(function () {
            if ($(this).val()) {
                Empleado.val($(this).val());
                Control.focus().select();
            }
        });

        Control.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    getInfoXControl();
                }
            }
        });

        btnAcepta.click(function () {
            isValid('pnlTablero');
            if (valido) {
                $.post('<?php print base_url('ControlEnsuelado/onGuardar'); ?>', {
                    Empleado: Empleado.val(),
                    EmpleadoT: sEmpleado.find("option:selected").text(),
                    CONTROL: Control.val(),
                    FECHA: Fecha.val()
                }).done(function (data) {
                    ControlEnsuelado.ajax.reload();
                    Estilo.val('');
                    Color.val('');
                    Pares.val('');
                    color = 0;
                    nomcolor = 0;
                    btnAcepta.attr('disabled', true);
                    Control.val('').focus();
                }).fail(function (x) {
                    getError(x);
                });
            } else {
                onNotify('<span class="fa fa-times fa-lg"></span>', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'danger');
            }
        });
    });

    function getRecords() {
        var cols = [
            {"data": "ID"}/*0*/,
            {"data": "NUMEMP"}/*1*/,
            {"data": "NOMEMP"}/*2*/,
            {"data": "CONTROL"}/*3*/,
            {"data": "FECHA"}/*4*/,
            {"data": "BTN"}/*5*/
        ];
        var coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ];
        var xoptions = {
            "dom": 'rt',
            "ajax": {
                "url": '<?php print base_url('ControlEnsuelado/getRecords'); ?>',
                "dataSrc": ""
            },
            buttons: buttons,
            "columns": cols,
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
            "scrollY": "390px",
            "scrollX": true,
            "aaSorting": [
                [0, 'desc']
            ]
        };
        ControlEnsuelado = tblControlEnsuelado.DataTable(xoptions);

    }

    function getEmpleados() {
        $.getJSON('<?php print base_url('ControlEnsuelado/getEmpleados'); ?>').done(function (a) {
            a.forEach(function (e) {
                sEmpleado[0].selectize.addOption({text: e.EMPLEADO, value: e.ID});
            });
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {

        });
    }

    var color, nomcolor;
    function getInfoXControl() {
        $.getJSON('<?php print base_url('ControlEnsuelado/getInfoXControl'); ?>', {
            CONTROL: Control.val()
        }).done(function (a) {
            if (a.length > 0) {
                var r = a[0];
                if (parseInt(r.Empleado) > 0) {
                    swal('ATENCIÓN', 'EL CONTROL YA HA SIDO ASIGNADO A UN MAQUILADOR EN OTRO MÓDULO', 'warning').then((value) => {
                        Estilo.val('');
                        Color.val('');
                        Pares.val('');
                        btnAcepta.attr('disabled', true);
                        Control.val('').focus();
                        return;
                    });
                } else {
                    if (parseInt(r.Asignado) === 1) {
                        swal('ATENCIÓN', 'EL CONTROL YA HA SIDO ASIGNADO', 'warning').then((value) => {
                            Estilo.val('');
                            Color.val('');
                            Pares.val('');
                            btnAcepta.attr('disabled', true);
                            Control.val('').focus();
                            return;
                        });
                    } else {
                        if (parseInt(r.stsavan) === 55) {
                            Estilo.val(r.ESTILO);
                            Pares.val(r.PARES);
                            Color.val(r.COLOR + '-' + r.NOMCOLOR);
                            color = r.COLOR;
                            nomcolor = r.NOMCOLOR;
                            btnAcepta.attr('disabled', false);
                            btnAcepta.focus();
                        } else {
                            swal('ATENCIÓN', 'EL CONTROL DEBE DE ESTAR EN [55-ENSUELADO]', 'warning').then((value) => {
                                Estilo.val('');
                                Color.val('');
                                Pares.val('');
                                btnAcepta.attr('disabled', true);
                                Control.val('').focus();
                                return;
                            });
                        }
                    }
                }
            } else {
                swwt('ES NECESARIO QUE ESPECIFIQUE UN CONTROL VÁLIDO', function () {
                    Control.focus().select();
                    Estilo.val('');
                    Pares.val('');
                });
                btnAcepta.attr('disabled', true);
            }
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {
            Fecha.val(FechaActual);
        });
    }

    function sws(m) {
        swal('ATENCIÓN', m, 'success');
    }

    function swsd(m, f) {
        swal('ATENCIÓN', m, 'success').then((value) => {
            f();
        });
    }

    function swsdv(m, f) {
        swal('ATENCIÓN', m, 'success').then((value) => {
            f(value);
        });
    }

    function sww(m) {
        swal('ATENCIÓN', m, 'warning');
    }

    function swwt(m, f) {
        swal('ATENCIÓN', m, 'warning').then((value) => {
            f();
        });
    }

    function onEliminarControlEnsuelado(Control) {
        onBeep(1);
        swal({
            title: "¿Estas seguro?",
            text: "El registro será eliminado, una vez aceptada la acción",
            icon: "warning",
            buttons: true
        }).then((value) => {
            if (value) {
                $.post('<?php print base_url('ControlEnsuelado/onEliminar'); ?>',
                        {Control: Control}).done(function (a) {
                    sws('SE HA ELIMINADO EL REGISTRO');
                    ControlEnsuelado.ajax.reload();
                }).fail(function (x) {
                    getError(x);
                }).always(function () {

                });
            }
        });
    }

</script>
<style>
    label{
        margin-top: 0.12rem;
        margin-bottom: 0.0rem;
    }
    table tbody tr {
        font-size: 0.75rem !important;
    }
    .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7,
    .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto,
    .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6,
    .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12,
    .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4,
    .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9,
    .col-md-10, .col-md-11, .col-md-12, .col-md,
    .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3,
    .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7,
    .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11,
    .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4,
    .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9,
    .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto {
        padding-right: 10px;
        padding-left: 10px;
    }

</style>