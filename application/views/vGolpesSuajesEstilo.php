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
                <div class="w-100"><hr></div>
                <div class="col-12">
                    <h5 class="text-info">Suaje Piel</h5>
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-1 col-xl-2">
                    <label>Fecha Compra</label>
                    <input type="text" id="fechaaltasuajepiel" name="fechaaltasuajepiel" class="form-control form-control-sm date">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                    <label>Proveedor</label>
                    <input type="text" id="proveedorpiel" name="proveedorpiel" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-1">
                    <label>Factura</label>
                    <input type="text" id="facturapiel" name="facturapiel" class="form-control form-control-sm" maxlength="10">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-1">
                    <label>Costo</label>
                    <input type="text" id="costopiel" name="costopiel" class="form-control form-control-sm numbersOnly" >
                </div>
                <div class="w-100"><hr></div>
                <div class="col-12">
                    <h5 class="text-info">Suaje Forro</h5>
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-1 col-xl-2">
                    <label>Fecha Compra </label>
                    <input type="text" id="fechaaltasuajeforro" name="fechaaltasuajeforro" class="form-control form-control-sm date">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                    <label>Proveedor</label>
                    <input type="text" id="proveedorforro" name="proveedorforro" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-1">
                    <label>Factura</label>
                    <input type="text" id="facturaforro" name="facturaforro" class="form-control form-control-sm" maxlength="10">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-1">
                    <label>Costo</label>
                    <input type="text" id="costoforro" name="costoforro" class="form-control form-control-sm numbersOnly" >
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
                                <th scope="col">Factura Piel</th>
                                <th scope="col">Fecha Piel</th>
                                <th scope="col">Proveedor Piel</th>
                                <th scope="col">Costo Piel</th>
                                <th scope="col">Factura Forro</th>
                                <th scope="col">Fecha Forro</th>
                                <th scope="col">Proveedor Forro</th>
                                <th scope="col">Costo Forro</th>
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
<div class="modal " id="mdlImprimeReporteCostosSuajes"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Imprime Reporte Costos por Suaje</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12">
                            <label>Linea</label>
                            <select id="Linea" name="Linea" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptaImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
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
    var fechaaltasuajepiel = pnlTablero.find("#fechaaltasuajepiel");
    var fechaaltasuajeforro = pnlTablero.find("#fechaaltasuajeforro");
    var btnAceptar = pnlTablero.find("#btnAceptar");
    var btnImprimirReporte = pnlTablero.find("#btnImprimirReporte");
    var proveedorpiel = pnlTablero.find("#proveedorpiel");
    var facturapiel = pnlTablero.find("#facturapiel");
    var costopiel = pnlTablero.find("#costopiel");

    var proveedorforro = pnlTablero.find("#proveedorforro");
    var facturaforro = pnlTablero.find("#facturaforro");
    var costoforro = pnlTablero.find("#costoforro");


    var mdlImprimeReporteCostosSuajes = $('#mdlImprimeReporteCostosSuajes');
    var btnAceptaImprimir = mdlImprimeReporteCostosSuajes.find('#btnAceptaImprimir');
    var Linea = mdlImprimeReporteCostosSuajes.find("#Linea");

    $(document).ready(function () {
        init();


        mdlImprimeReporteCostosSuajes.on('shown.bs.modal', function () {
            handleEnterDiv(mdlImprimeReporteCostosSuajes);
            $.each(mdlEtiZapica.find("select"), function (k, v) {
                mdlEtiZapica.find("select")[k].selectize.clear(true);
            });
            getLineasCostoSuajes();
            mdlImprimeReporteCostosSuajes.find('#Linea')[0].selectize.open();
        });


        btnImprimirReporte.on("click", function () {
            mdlImprimeReporteCostosSuajes.modal('show');
        });

        Estilo.keypress(function (e) {
            if (e.keyCode === 13) {
                var estilo = $(this).val();
                if (estilo) {
                    $.getJSON(base_url + 'index.php/Pedidos/onVerificaEstilo', {Estilo: estilo}).done(function (data) {
                        if (data.length > 0) {
                            fechaaltasuajepiel.focus();
                        } else {
                            swal('ERROR', 'EL ESTILO NO EXISTE', 'warning').then((value) => {
                                Estilo.focus().val('');
                            });
                        }
                    });
                }
            }
        });
        fechaaltasuajepiel.keypress(function (e) {
            if (e.keyCode === 13) {
                var value = $(this).val();
                if (value) {
                    proveedorpiel.focus();
                }
            }
        });

        proveedorpiel.keypress(function (e) {
            if (e.keyCode === 13) {
                var value = $(this).val();
                if (value) {
                    facturapiel.focus();
                }
            }
        });
        facturapiel.keypress(function (e) {
            if (e.keyCode === 13) {
                var value = $(this).val();
                if (value) {
                    costopiel.focus();
                }
            }
        });
        costopiel.keypress(function (e) {
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
                    proveedorforro.focus();
                }
            }
        });

        proveedorforro.keypress(function (e) {
            if (e.keyCode === 13) {
                var value = $(this).val();
                if (value) {
                    facturaforro.focus();
                }
            }
        });
        facturaforro.keypress(function (e) {
            if (e.keyCode === 13) {
                var value = $(this).val();
                if (value) {
                    costoforro.focus();
                }
            }
        });
        costoforro.keypress(function (e) {
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
                costopiel: costopiel.val(),
                proveedorpiel: proveedorpiel.val(),
                facturapiel: facturapiel.val(),
                costoforro: costoforro.val(),
                proveedorforro: proveedorforro.val(),
                facturaforro: facturaforro.val(),
                fechaaltasuajepiel: fechaaltasuajepiel.val(),
                fechaaltasuajeforro: fechaaltasuajeforro.val()
            }).done(function (data) {
                console.log(data);
                onNotifyOld('', 'REGISTRO AGREGADO', 'success');
                GolpesSuajesEstilo.ajax.reload();
                pnlTablero.find('input').val('');
                Estilo.focus();
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });
        });

        btnAceptaImprimir.on("click", function () {
            if (Linea.val()) {
                onOpenOverlay("Generando reporte");
                $.post(master_url + 'onImprimirReporteSuajes', {
                    linea: Linea.val()
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
                swal('ERROR', 'DEBES DE SELECCIONAR UNA LINEA', 'warning').then((value) => {
                    Linea.focus().val('');
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
                {"data": "facturapiel"},
                {"data": "fechaaltasuajepiel"},
                {"data": "proveedorpiel"},
                {"data": "costopiel"},
                {"data": "facturaforro"},
                {"data": "fechaaltasuajeforro"},
                {"data": "proveedorforro"},
                {"data": "costoforro"},
                {"data": "BTN"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [5, 9],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);

                    if (index > 0 && index <= 4) {
                        c.addClass('text-info text-strong');
                    } else if (index > 4) {
                        c.addClass('text-warning text-strong');
                    } else {
                        c.addClass('text-strong');
                    }

                });
            },
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

    function getLineasCostoSuajes() {
        $.getJSON(base_url + 'index.php/Lineas/' + 'getLineasSelect').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlImprimeReporteCostosSuajes.find("#Linea")[0].selectize.addOption({text: v.Linea, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
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