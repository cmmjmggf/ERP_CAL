<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Captura Información Suajes por Estilo</legend>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="right">
                <button type="button" id="btnImprimirReporte" name="btnImprimirReporte" class="btn btn-info">
                    <span class="fa fa-print"></span> Imprimir Reporte
                </button>
            </div>
        </div>
        <hr>
        <div class="card-block">
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-1">
                    <label>Estilo</label>
                    <input type="text" id="estilo" name="estilo" class="form-control form-control-sm" maxlength="7">
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-1">
                    <label>Golpes Piel</label>
                    <input type="text" id="glpsuajepiel" name="glpsuajepiel" class="form-control form-control-sm numbersOnly" maxlength="3">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-1 col-xl-2">
                    <label>Fecha Compra Suaje Piel</label>
                    <input type="text" id="fechaaltasuajepiel" name="fechaaltasuajepiel" class="form-control form-control-sm date">
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-1">
                    <label>Golpes Forro</label>
                    <input type="text" id="glpsuajeforro" name="glpsuajeforro" class="form-control form-control-sm numbersOnly" maxlength="3">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-1 col-xl-2">
                    <label>Fecha Compra Suaje Forro</label>
                    <input type="text" id="fechaaltasuajeforro" name="fechaaltasuajeforro" class="form-control form-control-sm date">
                </div>
                <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-3 mt-4">
                    <button type="button" class="btn btn-primary btn-sm" id="btnAceptar">
                        <i class="fa fa-check"></i> ACEPTAR
                    </button>
                </div>

                <div class="w-100 mt-2 mb-2"><hr></div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                    <table id="tblGolpesSuajesEstilo" class="table table-sm table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Estilo</th>
                                <th scope="col">Golpes Piel</th>
                                <th scope="col">Fecha Ini Piel</th>
                                <th scope="col">Golpes Forro</th>
                                <th scope="col">Fecha Ini Forro</th>
                                <th scope="col">(-)</th>
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
    var master_url = base_url + 'index.php/GolpesSuajesEstilo/';
    var tblGolpesSuajesEstilo = $('#tblGolpesSuajesEstilo');
    var GolpesSuajesEstilo;
    var pnlTablero = $('#pnlTablero');
    var Estilo = pnlTablero.find("#estilo");
    var glpsuajepiel = pnlTablero.find("#glpsuajepiel");
    var glpsuajeforro = pnlTablero.find("#glpsuajeforro");
    var fechaaltasuajepiel = pnlTablero.find("#fechaaltasuajepiel");
    var fechaaltasuajeforro = pnlTablero.find("#fechaaltasuajeforro");
    var btnAceptar = pnlTablero.find("#btnAceptar");
    var btnImprimirReporte = pnlTablero.find("#btnImprimirReporte");

    $(document).ready(function () {
        init();

        Estilo.keypress(function (e) {
            if (e.keyCode === 13) {
                var estilo = $(this).val();
                if (estilo) {
                    $.getJSON(base_url + 'index.php/Pedidos/onVerificaEstilo', {Estilo: estilo}).done(function (data) {
                        if (data.length > 0) {
                            glpsuajepiel.focus();
                        } else {
                            swal('ERROR', 'EL ESTILO NO EXISTE', 'warning').then((value) => {
                                Estilo.focus().val('');
                            });
                        }
                    });
                }
            }
        });
        glpsuajepiel.keypress(function (e) {
            if (e.keyCode === 13) {
                var value = $(this).val();
                if (value) {
                    fechaaltasuajepiel.focus();
                }
            }
        });
        fechaaltasuajepiel.keypress(function (e) {
            if (e.keyCode === 13) {
                var value = $(this).val();
                if (value) {
                    glpsuajeforro.focus();
                }
            }
        });
        glpsuajeforro.keypress(function (e) {
            if (e.keyCode === 13) {
                var value = $(this).val();
                if (value) {
                    fechaaltasuajeforro.focus();
                }
            }
        });
        fechaaltasuajeforro.keypress(function (e) {
            if (e.keyCode === 13) {
                var value = $(this).val();
                if (value) {
                    btnAceptar.focus();
                }
            }
        });
        btnAceptar.on("click", function () {
            $.post(master_url + 'onAgregarInfoSuajes', {
                estilo: Estilo.val(),
                glpsuajepiel: glpsuajepiel.val(),
                glpsuajeforro: glpsuajeforro.val(),
                fechaaltasuajepiel: fechaaltasuajepiel.val(),
                fechaaltasuajeforro: fechaaltasuajeforro.val()
            }).done(function (data) {
                console.log(data);
                onNotifyOld('', 'REGISTRO AGREGADO', 'success');
                GolpesSuajesEstilo.ajax.reload();
                glpsuajeforro.val('');
                glpsuajepiel.val('');
                fechaaltasuajepiel.val('');
                fechaaltasuajeforro.val('');
                Estilo.val('').focus();
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });
        });

        btnImprimirReporte.on("click", function () {
            if (Estilo.val()) {
                onOpenOverlay("Generando reporte");
                $.post(master_url + 'onImprimirReporteSuajes', {
                    estilo: Estilo.val()
                }).done(function (data) {
                    onCloseOverlay();
                    console.log(data);
                    onImprimirReporteFancyAFC(data, function (a, b) {

                    });
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            } else {
                swal('ERROR', 'DEBES DE SELECCIONAR UN ESTILO', 'warning').then((value) => {
                    Estilo.focus().val('');
                });
            }
        });
    });
    function init() {
        Estilo.focus();
        getRecords();
    }

    function getRecords() {
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblGolpesSuajesEstilo')) {
            tblGolpesSuajesEstilo.DataTable().destroy();
        }
        GolpesSuajesEstilo = tblGolpesSuajesEstilo.DataTable({
            "dom": 'frt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "type": 'GET'
            },
            "columns": [
                {"data": "ID"},
                {"data": "estilo"},
                {"data": "glpsuajepiel"},
                {"data": "fechaaltasuajepiel"},
                {"data": "glpsuajeforro"},
                {"data": "fechaaltasuajeforro"},
                {"data": "BTN"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 400,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "scrollY": 380,
            "bSort": true,
            "aaSorting": [
                [1, 'asc']
            ],
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });
    }
    function onEliminarByID(ID) {
        onBeep(1);
        swal({
            title: "¿Estas seguro?",
            text: "El registro será eliminado, una vez aceptada la acción",
            icon: "warning",
            buttons: true
        }).then((value) => {
            if (value) {
                $.post('<?php print base_url('GolpesSuajesEstilo/onEliminarByID'); ?>',
                        {ID: ID}).done(function (a) {
                    GolpesSuajesEstilo.ajax.reload();
                }).fail(function (x) {
                    getError(x);
                }).always(function () {

                });
            }
        });
    }
</script>
<style>
    .text-strong {
        font-weight: bolder;
    }

    tr.group-start:hover td{
        background-color: #e0e0e0 !important;
        color: #000 !important;
    }
    tr.group-end td{
        background-color: #FFF !important;
        color: #000!important;
    }

    td span.badge{
        font-size: 100% !important;
    }
</style>