<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header"> 
        <div class="row">
            <div class="w-100  my-2"></div>
            <div class="col-4 col-md-4 col-lg-4 col-xl-4">
                <button type="button" id="btnRefrescar" name="btnRefrescar" class="btn btn-sm btn-warning " data-toggle="tooltip" data-placement="top" title="Refrescar">
                    <span class="fa fa-retweet"></span>
                </button>
                <button type="button" id="btnImprimeXDia" name="btnImprimeXDia" class="btn btn-sm btn-info " data-toggle="tooltip" data-placement="top" title="Imprime x dia">
                    <span class="fa fa-print"></span> X dia
                </button>
                <button type="button" id="btnImprimeXSem" name="btnImprimeXSem" class="btn btn-sm btn-info " data-toggle="tooltip" data-placement="top" title="Imprime x Sem">
                    <span class="fa fa-print"></span> X sem
                </button>
            </div>
            <div class="col-4 col-md-4 col-lg-4 col-xl-4">
                <h4 class="font-weight-bold text-center">
                    Asigna dia semana a control para corte
                </h4> 
            </div>
            <div class="col-4 col-md-4 col-lg-4 col-xl-4 text-center">
                <button type="button" id="btnTiemposXEstilos" name="btnTiemposXEstilos" class="btn btn-sm btn-danger "  >
                    <span class="fa fa-clock"></span> Tiempos x estilo
                </button>

                <button type="button" id="btnFracciones" name="btnFracciones" class="btn btn-sm btn-ok mx-4" >
                    <span class="fa fa-puzzle-piece"></span> Fracciones
                </button>

                <button type="button" id="btnFraccionesXEstilos" name="btnFraccionesXEstilos" class="btn btn-sm btn-indigo"  >
                    <span class="fa fa-check-double"></span> Fracciones x estilo
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-2">
            </div>
            <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8" align="center"> 
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-indigo">
                        <input type="radio" name="btnPiel" id="btnPiel" autocomplete="off" checked>
                        <span class="fa fa-dot-circle"></span> PIEL
                    </label>
                    <label class="btn btn-indigo">
                        <input type="radio" name="btnForro" id="btnForro" autocomplete="off"> <span class="fa fa-dot-circle"></span> FORRO
                    </label>
                    <label class="btn btn-indigo">
                        <input type="radio" name="btnAmbas" id="btnAmbas" autocomplete="off"> <span class="fa fa-dot-circle"></span> AMBAS
                    </label>
                </div>
            </div>
            <div class="col-2">
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                <label>Año</label>
                <input type="text" id="Anio" name="Anio" class="form-control form-control-sm numbersOnly" maxlength="4">
            </div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                <label>Semana</label>
                <input type="text" id="Semana" name="Semana" class="form-control form-control-sm numbersOnly" maxlength="2">
            </div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                <label>Dia</label>
                <input type="text" id="Dia" name="Dia" class="form-control form-control-sm numbersOnly" maxlength="1"  data-toggle="tooltip" data-placement="left" title="Dias entre 1 y 7">
            </div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2"> 
                <label>Dia/Nombre</label>
                <input type="text" id="DiaNombre" name="DiaNombre" class="form-control form-control-sm" readonly="" maxlength="2">
            </div>
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>Fracción</label>
                <input type="text" id="Fraccion" name="Fraccion" class="form-control form-control-sm" maxlength="7">

                <input type="text" id="FraccionesSeleccionadas" class="form-control-sm d-none" readonly="">
                <button type="button" class="btn btn-primary d-none" id="btnFraccionCheck">Obtener</button>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                <label>Cortador</label>
                <div class="row">
                    <div class="col-2">
                        <input type="text" id="xCortadorADSCPC" name="xCortadorADSCPC" class="form-control form-control-sm">
                    </div>
                    <div class="col-10">
                        <select id="CortadorADSCPC" name="CortadorADSCPC" class="form-control form-control-sm selectNotEnter">
                        </select>
                    </div>
                </div> 
            </div> 
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                <label>Control</label>
                <input type="text" id="Control" name="Control" class="form-control form-control-sm numbersOnly" maxlength="10">
            </div>
            <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                <label>Estilo</label>
                <input type="text" id="Estilo" name="Estilo" readonly="" class="form-control form-control-sm" maxlength="10">
            </div>
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>Color</label>
                <input type="text" id="Color" name="Color" class="form-control form-control-sm d-none" maxlength="10">
                <input type="text" id="ColorNombre" name="ColorNombre" class="form-control form-control-sm" readonly="" maxlength="10">
            </div>
            <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                <label>Pares</label>
                <input type="text" id="Pares" name="Pares"  readonly="" class="form-control form-control-sm numbersOnly" maxlength="10">
            </div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                <label>TxPar</label>
                <input type="text" id="TxPar" name="TxPar"  readonly="" class="form-control form-control-sm numbersOnly" maxlength="10">
            </div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                <label>Precio</label>
                <input type="text" id="Precio" name="Precio" readonly=""  class="form-control form-control-sm numbersOnly" maxlength="10">
            </div>
            <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                <label>Tiempo</label>
                <input type="text" id="Tiempo" name="Tiempo" readonly=""  class="form-control form-control-sm numbersOnly" maxlength="10">
            </div>
            <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 d-none">
                <label>Articulo</label>
                <input type="text" id="ClaveArticulo" name="ClaveArticulo" class="form-control form-control-sm d-none" readonly="" maxlength="50">
                <input type="text" id="Articulo" name="Articulo" class="form-control form-control-sm d-none" readonly="" maxlength="250">
            </div> 
            <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                <label>Pesos</label>
                <input type="text" id="Pesos" name="Pesos" readonly=""  class="form-control form-control-sm numbersOnly" maxlength="10">
            </div> 
            <button type="button" class="btn btn-info btn-lg btn-float animated tada" id="btnGuardar" name="btnGuardar"  data-toggle="tooltip" data-placement="left" title="Guardar">
                <i class="fa fa-save"></i>
            </button>
            <div class="w-100 my-2"></div>
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <h3>Controles por asignar</h3> 
                <table id="tblControlesSinAsignarAlDia" class="table table-hover table-sm table-bordered  compact nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Control</th><!--1-->
                            <th scope="col">Cliente</th><!--2-->
                            <th scope="col">Estilo</th><!--3-->
                            <th scope="col">Color</th><!--4-->
                            <th scope="col">Pares</th><!--5-->
                            <th scope="col">Semana</th><!--6-->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>0</td><!--0-->                            <td>1</td><!--1-->
                            <td>2</td><!--2-->                            <td>3</td><!--3-->
                            <td>4</td><!--4-->                            <td>5</td><!--5-->
                            <td>6</td><!--6-->
                        </tr>
                    </tbody>
                </table> 
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1 d-flex align-items-center justify-content-center flex-column"> 
                <button id="Anadir" name="Anadir" class="btn d-none btn-primary m-1 animated slideInRight" data-toggle="tooltip" data-placement="left" title="Añadir"><span class="fa fa-arrow-right"></span></button>
                <button id="Quitar" name="Quitar" class="btn btn-danger m-1 animated slideInLeft"  data-toggle="tooltip" data-placement="left" title="Quitar"><span class="fa fa-trash"></span></button>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <h3>Controles asignados a este día</h3> 
                <table id="tblControlesAsignadosAlDia" class="table table-hover table-sm table-bordered  compact nowrap"  style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Emp</th><!--1-->
                            <th scope="col">Control</th><!--2-->
                            <th scope="col">Año</th><!--3-->
                            <th scope="col">Sem</th><!--4-->
                            <th scope="col">D&iacute;a</th><!--5-->
                            <th scope="col">Frac.</th><!--6-->
                            <th scope="col">Fecha</th><!--7-->
                            <th scope="col">Estilo</th><!--8-->
                            <th scope="col">Pares</th><!--9-->
                            <th scope="col">Tiempo</th><!--10-->
                            <th scope="col">Precio</th><!--11-->
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table> 
            </div>

        </div><!--END ROW-->
    </div><!--END CARD BODY-->
</div>

<div id="mdlFracciones" class="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), Anio = pnlTablero.find("#Anio"), Dia = pnlTablero.find("#Dia"), DiaT = pnlTablero.find("#DiaNombre"),
            Semana = pnlTablero.find("#Semana"),
            xCortadorADSCPC = pnlTablero.find("#xCortadorADSCPC"),
            CortadorADSCPC = pnlTablero.find("#CortadorADSCPC"),
            Fraccion = pnlTablero.find("#Fraccion"), FraccionesSeleccionadas = pnlTablero.find("#FraccionesSeleccionadas"),
            Control = pnlTablero.find("#Control"),
            Estilo = pnlTablero.find("#Estilo"), Color = pnlTablero.find("#Color"), Pares = pnlTablero.find("#Pares"),
            Precio = pnlTablero.find("#Precio"), Tiempo = pnlTablero.find("#Tiempo"), btnGuardar = pnlTablero.find("#btnGuardar"),
            ColorNombre = pnlTablero.find("#ColorNombre"), TxPar = pnlTablero.find("#TxPar"), Pesos = pnlTablero.find("#Pesos"),
            ClaveArticulo = pnlTablero.find("#ClaveArticulo"), Articulo = pnlTablero.find("#Articulo");
    var tblControlesSinAsignarAlDia = pnlTablero.find("#tblControlesSinAsignarAlDia"), ControlesSinAsignarAlDia,
            tblControlesAsignadosAlDia = pnlTablero.find("#tblControlesAsignadosAlDia"), ControlesAsignadosAlDia,
            btnPiel = $("#btnPiel"), btnForro = $("#btnForro"), btnAmbas = $("#btnAmbas"),
            btnAnadir = $("#Anadir"), btnQuitar = $("#Quitar"), btnRefrescar = pnlTablero.find("#btnRefrescar"),
            btnTiemposXEstilos = pnlTablero.find("#btnTiemposXEstilos"), btnFracciones = pnlTablero.find("#btnFracciones"),
            btnFraccionesXEstilos = pnlTablero.find("#btnFraccionesXEstilos"),
            Cortadores = pnlTablero.find("#CortadorADSCPC"), mdlFracciones = $("#mdlFracciones"),
            btnImprimeXDia = pnlTablero.find("#btnImprimeXDia"),
            btnImprimeXSem = pnlTablero.find("#btnImprimeXSem");
    var dias = {
        4: 'LUNES',
        5: 'MARTES',
        6: 'MIERCOLES',
        1: 'JUEVES',
        2: 'VIERNES',
        3: 'SABADO',
        0: 'DOMINGO'
    };
    var c = {};
    var options = {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'selectNone',
                className: 'btn btn-info btn-sm',
                text: 'Ninguno',
                titleAttr: 'Deseleccionar'
            }
        ], "ajax": {
            "url": '<?php print base_url('AsignaDiaSemACtrlParaCorte/getRecords'); ?>',
            "dataSrc": "",
            "data": function (d) {
                d.ANIO = Anio.val() ? Anio.val() : '';
                d.SEMANA = Semana.val() ? Semana.val() : '';
                d.CONTROL = Control.val() ? Control.val() : '';
                d.ESTILO = Estilo.val() ? Estilo.val() : '';
                d.COLOR = Color.val() ? Color.val() : '';
            }
        },
        "columnDefs": [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [6],
                "visible": false,
                "searchable": true
            }],
        "columns": [
            {"data": "ID"}, /*0*/
            {"data": "Control"}, /*1*/
            {"data": "Cliente"}, /*2*/
            {"data": "Estilo"}, /*3*/
            {"data": "Color"}, /*4*/
            {"data": "Pares"}, /*5*/
            {"data": "Semana"} /*6*/
        ],
        language: lang,
        select: {
            style: 'single'
        },
        keys: true,
        "autoWidth": true,
        "colReorder": true,
        "displayLength": 99,
        "scrollY": "250px",
        "scrollX": true,
        "bLengthChange": false,
        "deferRender": true,
        "scrollCollapse": false,
        "bSort": true,
        "aaSorting": [
            [0, 'desc']/*ID*/
        ],
        initComplete: function () {
        }
    };
    $(document).ready(function () {

        handleEnterDiv(pnlTablero);
        btnImprimeXSem.click(function () {
            if (Semana.val()) {

            } else {
                iMsg('DEBE DE ESPECIFICAR UNA SEMANA', 'w', function () {
                    Semana.focus().select();
                });
            }
        });
        btnImprimeXDia.click(function () {
            if (Anio.val()) {
                if (Semana.val()) {
                    if (Dia.val()) {
                        var p = {
                            SEMANA: Semana.val() ? Semana.val() : '',
                            DIA: Dia.val() ? Dia.val() : '',
                            DIAT: DiaT.val() ? DiaT.val() : '',
                            ANO: Anio.val() ? Anio.val() : ''
                        };
                        onOpenOverlay('Espere un momento...');
                        btnImprimeXDia.attr('disabled', true);
                        $.post('<?php print base_url('AsignaDiaSemACtrlParaCorte/getReportesXSemDiaAno'); ?>', p).done(function (xxx) {
                            if (xxx.length > 0) {
                                onImprimirReporteFancyArrayAFC(JSON.parse(xxx), function (instance, current) {
                                    btnImprimeXDia.attr('disabled', false);
                                });
                            } else {
                                iMsg('NO SE HA PODIDO GENERAR LOS REPORTES SOLICITADOS, INTENTE DE NUEVO O MÁS TARDE', 'w', function () {
                                    Semana.focus().select();
                                });
                            }
                        }).fail(function (x, y, z) {
                            getError(x);
                        }).always(function () {
                            onCloseOverlay();
                        });
                    } else {
                        iMsg('DEBE DE ESPECIFICAR UN DIA', 'w', function () {
                            Dia.focus().select();
                        });
                    }
                } else {
                    iMsg('DEBE DE ESPECIFICAR UNA SEMANA', 'w', function () {
                        Semana.focus().select();
                    });
                }
            } else {
                iMsg('DEBE DE ESPECIFICAR UN AÑO', 'w', function () {
                    Anio.focus().select();
                });
            }
        });
        Semana.focus().select();
        pnlTablero.find("#btnFraccionCheck").click(function () {
            console.log(Fraccion.val());
        });
        btnTiemposXEstilos.click(function () {
            btnTiemposXEstilos.attr('disabled', true);
            onOpenWindowAFC('<?php print base_url('TiemposXEstiloDepto/?origen=PRODUCCION'); ?>', function (instance, current) {
                btnTiemposXEstilos.attr('disabled', false);
            });
        });
        btnFracciones.click(function () {
            btnFracciones.attr('disabled', true);
            onOpenWindowAFC('<?php print base_url('Fracciones/?origen=PRODUCCION'); ?>', function (instance, current) {
                btnFracciones.attr('disabled', false);
            });
        });
        btnFraccionesXEstilos.click(function () {
            btnFraccionesXEstilos.attr('disabled', true);
            onOpenWindowAFC('<?php print base_url('FraccionesXEstilo/?origen=PRODUCCION'); ?>', function (instance, current) {
                btnFraccionesXEstilos.attr('disabled', false);
            });
        });
        btnRefrescar.click(function () {
            if ($.fn.DataTable.isDataTable('#tblControlesSinAsignarAlDia') && $.fn.DataTable.isDataTable('#tblControlesAsignadosAlDia')) {
                ControlesSinAsignarAlDia.ajax.reload();
                ControlesAsignadosAlDia.ajax.reload();
                getCortadores();
                pnlTablero.find(".btn-group-toggle label").removeClass("active");
                onBeep(4);
                swal({
                    title: "ATENCIÓN",
                    text: "LOS DATOS HAN SIDO ACTUALIZADOS",
                    icon: "success",
                    buttons: false,
                    timer: 1000
                });
            } else {
                getCortadores();
                getControlesSinAsignarYAsignadosAlDia();
            }
        });


        CortadorADSCPC.change(function () {
            if (CortadorADSCPC.val()) {
                xCortadorADSCPC.val(CortadorADSCPC.val());
            } else {
                xCortadorADSCPC.val('');
                CortadorADSCPC[0].selectize.enable();
                CortadorADSCPC[0].selectize.clear(true);
            }
            ControlesAsignadosAlDia.ajax.reload();
        }).focusout(function () {
            onEnable(CortadorADSCPC);
        });

        xCortadorADSCPC.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xCortadorADSCPC.val()) {
                    CortadorADSCPC[0].selectize.setValue(xCortadorADSCPC.val());
                    if (CortadorADSCPC.val()) {
                        onDisable(CortadorADSCPC);
                    } else {
                        onCampoInvalido(pnlTablero, 'NO EXISTE ESTE CORTADOR, ESPECIFIQUE OTRO', function () {
                            xCortadorADSCPC.focus().select();
                        });
                    }
                } else {
                    CortadorADSCPC[0].selectize.enable();
                    CortadorADSCPC[0].selectize.clear(true);
                }
            } else {
                CortadorADSCPC[0].selectize.enable();
                CortadorADSCPC[0].selectize.clear(true);
            }
            ControlesAsignadosAlDia.ajax.reload();
        });

        btnAnadir.click(function () {
            onAnadirAsignacion();
        });
        btnQuitar.click(function () {
            onEliminarAsignacion();
        });
        btnGuardar.click(function () {
            var FRACCIONES = [];
            $.each(Fraccion.val(), function (k, v) {
                FRACCIONES.push({
                    FRACCIONES: v
                });
            });
            $.getJSON('<?php print base_url('AsignaDiaSemACtrlParaCorte/onRevisarSiYaEstaProgramadoConEsaFraccion'); ?>', {
                CONTROL: Control.val(),
                FRACCIONES: JSON.stringify(FRACCIONES)
            }).done(function (a) {
                if (a.length > 0) {
                    var r = a[0];
                    if (parseInt(r.ENCONTRADOS) <= 0) {
                        onGuardarAsignacionDeDiaXControl();
                    } else {
                        iMsg('YA SE HA PROGRAMADO EL FORRO O LA PIEL PARA ESTE CONTROL, VERIFIQUE ANTES DE AAGREGARLO', 'w', function () {
                            Control.focus().select();
                        });
                    }
                }
            }).fail(function (x) {
                getErro(x);
            });
//            onGuardarAsignacionDeDiaXControl();
        });
        Fraccion.keydown(function (e) {
            if (e.keyCode === 13) {
                ControlesAsignadosAlDia.ajax.reload();
            }
        });
        $("#btnAmbas, #btnPiel, #btnForro").change(function () {
            onBeep(3);
            switch ($(this).attr('id')) {
                case 'btnPiel':
                    Fraccion.val(100);
                    FraccionesSeleccionadas.val(100);
                    break;
                case 'btnForro':
                    Fraccion.val(99);
                    FraccionesSeleccionadas.val(99);
                    break;
                case 'btnAmbas':
                    Fraccion.val("99, 100");
                    FraccionesSeleccionadas.val("99,100");
                    break;
            }
            if (Control.val()) {
                getEstiloColorParesTxParPorControl(Control.val());
            } else {
                CortadorADSCPC[0].selectize.focus();
                CortadorADSCPC[0].selectize.open();
            }
        });
        Dia.on('keydown keypress keyup', function (e) {
            if (parseInt(Dia.val()) >= 0 && parseInt(Dia.val()) <= 7) {
                if (Dia.val().length !== '') {
                    $.each(dias, function (k, v) {
                        if (parseInt(Dia.val()) === parseInt(k))
                        {
                            pnlTablero.find("#DiaNombre").val(v);
                            return false;
                        }
                    });
                } else if (Dia.val() === '') {
                    Dia.val('');
                    pnlTablero.find("#DiaNombre").val('');
                }
            }
            ControlesAsignadosAlDia.ajax.reload();
        });
        Control.on('keydown', function (e) {
            onEnable(CortadorADSCPC);
            if (e.keyCode === 13 && Control.val()) {
//                $.getJSON('<?php print base_url('AsignaDiaSemACtrlParaCorte/getInfoXControl'); ?>',
//                        {
//                            CONTROL: Control.val() ? Control.val() : ''
//                        }).done(function (a) {
//                    if (a.length > 0) {
//                        var z = a[0];
//                        Estilo.val(z.Estilo);

//                    }
//                }).fail(function (x) {
//                    getError(x);
//                }).always(function () {
//
//                });
            }
            ControlesSinAsignarAlDia.ajax.reload(function () {
                getEstiloColorParesTxParPorControl(Control.val());
            });
        });
        Semana.on('keydown', function (e) {
            if (e.keyCode === 13) {
                ControlesSinAsignarAlDia.ajax.reload();
                ControlesAsignadosAlDia.ajax.reload();
            }
        });
        btnRefrescar.trigger('click');
        Anio.val(new Date().getFullYear());
    });
    function getControlesSinAsignarYAsignadosAlDia() {
        HoldOn.open({
            theme: 'sk-rect',
            message: 'Cargando...'
        });
        ControlesSinAsignarAlDia = tblControlesSinAsignarAlDia.DataTable(options);
        ControlesAsignadosAlDia = tblControlesAsignadosAlDia.DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'selectNone',
                    className: 'btn btn-info btn-sm',
                    text: 'Ninguno',
                    titleAttr: 'Deseleccionar'
                }
            ],
            "ajax": {
                "url": '<?php print base_url('AsignaDiaSemACtrlParaCorte/getProgramacion') ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.ANIO = Anio.val() ? Anio.val() : '';
                    d.SEMANA = Semana.val() ? Semana.val() : '';
                    d.DIA = Dia.val() ? Dia.val() : '';
                    d.FRACCION = Fraccion.val() ? Fraccion.val() : '';
                    d.CORTADOR = CortadorADSCPC.val() ? CortadorADSCPC.val() : '';
                    d.CONTROL = Control.val() ? Control.val() : '';
                    d.ESTILO = Estilo.val() ? Estilo.val() : '';
                    d.COLOR = Color.val() ? Color.val() : '';
                }
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }],
            "columns": [
                {"data": "ID"}, /*0*/
                {"data": "Emp"}, /*1*/
                {"data": "Control"}, /*2*/
                {"data": "Ano"}, /*3*/
                {"data": "Sem"}, /*4*/
                {"data": "Dia"}, /*5*/
                {"data": "Frac"}, /*6*/
                {"data": "Fecha"}, /*7*/
                {"data": "Estilo"}, /*8*/
                {"data": "Pares"}, /*9*/
                {"data": "Tiempo"}, /*10*/
                {"data": "Precio"} /*11*/
            ],
            language: lang,
            select: {
                style: 'single'
            },
            keys: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 99,
            "scrollY": "250px",
            "scrollX": true,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'desc']/*ID*/
            ],
            initComplete: function () {
                HoldOn.close();
            }
        });
    }

    function getCortadores() {
        Cortadores[0].selectize.clear(true);
        Cortadores[0].selectize.clearOptions();
        $.getJSON('<?php print base_url('AsignaDiaSemACtrlParaCorte/getCortadores') ?>').done(function (data) {
            $.each(data, function (k, v) {
                Cortadores[0].selectize.addOption({text: v.EMPLEADO, value: v.CLAVE});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getFracciones() {
//        Fraccion.selectize({
//            plugins: ['remove_button'],
//            maxItems: 2,
//            delimiter: ',',
//            persist: true,
//            create: false,
//            hideSelected: true
//        });
//        Fraccion[0].selectize.clear(true);
//        Fraccion[0].selectize.clearOptions();
//        $.getJSON('<?php print base_url('AsignaDiaSemACtrlParaCorte/getFracciones') ?>').done(function (data) {
//            $.each(data, function (k, v) {
//                Fraccion[0].selectize.addOption({text: v.FRACCION, value: v.CLAVE});
//            });
//        }).fail(function (x) {
//            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
//            console.log(x.responseText);
//        });
    }

    function getEstiloColorParesTxParPorControl(e) {
        HoldOn.open({
            theme: 'sk-bounce',
            message: 'Por favor espere un momento...'
        });
        var FRACCIONES = [];
        $.each(Fraccion.val(), function (k, v) {
            FRACCIONES.push({
                FRACCIONES: v
            });
        });
        console.log(FRACCIONES);
        $.getJSON('<?php print base_url('AsignaDiaSemACtrlParaCorte/getEstiloColorParesTxParPorControl'); ?>', {
            CONTROL: e, TIPO: JSON.stringify(FRACCIONES)
        }).done(function (data, x, jq) {
            var r = data[0];
            var precio_final = 0, tx_final = 0;
            console.log("# Fracciones => ", FRACCIONES.length);
            $.each(data, function (k, v) {
                precio_final += parseFloat(v.PRECIO);
                tx_final += parseFloat(v.TXPAR);
            });

            if (data.length > 0) {
                precio_final = precio_final.toFixed(2);
                tx_final = tx_final.toFixed(2);
                Estilo.val(r.ESTILO);
                Color.val(r.COLOR);
                ColorNombre.val(r.DES_COLOR);
                Pares.val(r.PARES);
                Precio.val(r.PRECIO);
                TxPar.val(r.TXPAR);
                var xtiempo = r.TXPAR * r.PARES, xpesos = r.PARES * r.PRECIO;
                Tiempo.val(xtiempo.toFixed(2));
                Pesos.val(xpesos.toFixed(2));
                if (FRACCIONES.length >= 2) {
                    Precio.val(precio_final);
                    TxPar.val(tx_final);
                    xtiempo = tx_final * r.PARES;
                    Tiempo.val(xtiempo.toFixed(2));
                    Pesos.val(r.PARES * precio_final);
                }
                Articulo.val(r.ARTICULO);
                ClaveArticulo.val(r.CLAVE_ARTICULO);
            } else {
                swal('ATENCIÓN', 'NO SE HAN ESTABLECIDO TIEMPOS PARA ESTE CONTROL EN CORTE', 'warning').then((value) => {
                    Control.focus().select();
                });
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function onGuardarAsignacionDeDiaXControl() {
        if (Anio.val() && Semana.val() && Dia.val() &&
                Fraccion.val().length > 0 && CortadorADSCPC.val() && Control.val() &&
                Estilo.val() && Color.val() && Pesos.val() &&
                Articulo.val() && ClaveArticulo.val()) {
            var FRACCIONES = [];
            $.each(Fraccion.val(), function (k, v) {
                FRACCIONES.push({
                    FRACCIONES: v
                });
            });
            onBeep(1);
            $.post('<?php print base_url('AsignaDiaSemACtrlParaCorte/onGuardarAsignacionDeDiaXControl'); ?>',
                    {
                        CORTADOR: CortadorADSCPC.val(),
                        CONTROL: Control.val(),
                        ANIO: Anio.val(),
                        SEMANA: Semana.val(),
                        DIA: Dia.val(),
                        FRACCION: JSON.stringify(FRACCIONES),
                        ESTILO: Estilo.val(),
                        PARES: Pares.val(),
                        TIEMPO: TxPar.val(),
                        PRECIO: Precio.val(),
                        ARTICULO: Articulo.val()
                    }).done(function (data, x, jq) {

                Control.val('');
                Estilo.val('');
                Color.val('');
                Pares.val('');
                TxPar.val('');
                Precio.val('');
                Tiempo.val('');
                Pesos.val('');
                ControlesSinAsignarAlDia.ajax.reload();
                ControlesAsignadosAlDia.ajax.reload(function () {
                    Control.focus().select();
                });
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            });
        } else {
            $.each(pnlTablero.find("input[type='text'].form-control:not(:read-only)"), function (k, v) {
                var field = $(v);
                if (!field.val()) {
                    field.focus();
                    field.addClass("highlight-input");
                    setTimeout(function () {
                        field.removeClass("highlight-input");
                    }, 3500);
                    return false;
                }
            });
        }
    }

    function onAnadirAsignacion() {
        if (Dia.val()) {
            if (Fraccion.val().length > 0) {
                if (CortadorADSCPC.val()) {
                    var row = ControlesSinAsignarAlDia.row(tblControlesSinAsignarAlDia.find("tbody tr.selected")).data();
                    if (row) {
                        row["ANIO"] = Anio.val();
                        row["CONTROL"] = $(row.Control).text();
                        row["DIA"] = Dia.val();
                        row["CORTADOR"] = CortadorADSCPC.val();
                        row["FRACCION"] = Fraccion.val()[0];
                        $.post('<?php print base_url('AsignaDiaSemACtrlParaCorte/onAnadirAsignacion'); ?>', row).done(function (data, x, jq) {
                            CortadorADSCPC[0].selectize.clear(true);
                            ControlesSinAsignarAlDia.ajax.reload();
                            ControlesAsignadosAlDia.ajax.reload();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        });
                    } else {
                        onBeep(2);
                        swal('ATENCIÓN', 'DEBE DE SELECCIONAR UN CONTROL (NO ASIGNADO)', 'warning').then((value) => {
                            tblControlesSinAsignarAlDia.find("tbody tr").addClass("highlight-rows");
                            setTimeout(function () {
                                tblControlesSinAsignarAlDia.find("tbody tr").removeClass("highlight-rows");
                            }, 1500);
                        });
                    }
                } else {
                    onBeep(2);
                    swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR UN CORTADOR', 'warning').then((value) => {
                        CortadorADSCPC[0].selectize.focus();
                        CortadorADSCPC[0].selectize.open();
                    });
                }
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR UNA FRACCIÓN', 'warning').then((value) => {
                    Fraccion[0].selectize.focus();
                    Fraccion[0].selectize.open();
                });
            }
        } else {
            onBeep(2);
            swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR UN DIA', 'warning').then((value) => {
                Dia.focus().addClass("highlight-input");
                setTimeout(function () {
                    Dia.removeClass("highlight-input");
                }, 1500);
            });
        }
    }

    function onEliminarAsignacion() {
        var row = ControlesAsignadosAlDia.row(tblControlesAsignadosAlDia.find("tbody tr.selected")).data();
        console.log(row);
        if (row) {
            HoldOn.open({
                theme: 'sk-bounce',
                message: 'Eliminando...'
            });
            $.post('<?php print base_url('AsignaDiaSemACtrlParaCorte/onEliminarAsignacion'); ?>', row).done(function (data, x, jq) {
                console.log(data);
                HoldOn.close();
                ControlesSinAsignarAlDia.ajax.reload();
                ControlesAsignadosAlDia.ajax.reload();
            }).fail(function (x, y, z) {
                HoldOn.close();
                console.log(x, y, z);
            });
        } else {
            onBeep(2);
            swal('ATENCIÓN', 'DEBE DE SELECCIONAR UN CONTROL ASIGNADO', 'warning').then((value) => {
                tblControlesAsignadosAlDia.find("tbody tr").addClass("highlight-rows");
                setTimeout(function () {
                    tblControlesAsignadosAlDia.find("tbody tr").removeClass("highlight-rows");
                }, 1500);
            });
        }
        Control.focus().select();
    }
</script>
<style>
    table.dataTable tbody>tr.selected, table.dataTable tbody>tr>.selected {
        background-color: #0275d8;
        color:#fff !important;
        font-weight: bold;
    }
    .selectize-control.multi .selectize-input > div {
        cursor: pointer;
        margin: 0 3px 3px 0;
        padding: 1px 3px;
        background: #3F51B5;
        color: #ffffff;
        border: 0 solid rgba(0, 0, 0, 0);
        border-radius: 5px;
        font-weight: bold;
    }
    .selectize-control.multi .selectize-input > div.active {
        background: #3F51B5;
        color: #ffffff;
        border: 0 solid rgba(0, 0, 0, 0);
        font-weight: bold;
    }
    .btn-indigo:not(:disabled):not(.disabled):active, 
    .btn-indigo:not(:disabled):not(.disabled).active, 
    .show > .btn-indigo.dropdown-toggle {
        color: #fff;
        background-color: #99cc00;
        border: 2px solid #99cc00;
        font-weight: bold;
    }   
    .highlight-input,.highlight-input:focus{  
        color: #000;
        background:#ffcc00;
        animation: illuminate .4s;
        font-weight: bold;
        -moz-animation:illuminate .4s infinite; /* Firefox */
        -webkit-animation:illuminate .4s infinite; /* Safari and Chrome */
    } 
    .highlight-rows,.highlight-rows:focus{  
        color: #000;
        background:#ffffff ;
        animation: illuminaterow .4s;
        font-weight: bold;
        -moz-animation:illuminaterow .4s infinite; /* Firefox */
        -webkit-animation:illuminaterow .4s infinite; /* Safari and Chrome */
    } 
    .btn-indigo {
        color: #fff;
        background-color: #3F51B5;
        border-color: #3F51B5;
    }
    .btn-ok{
        color: #fff;
        background-color: #99cc00;
        border-color: #99cc00; 
    }

    @-moz-keyframes illuminaterow /* Firefox */
    {
        0%   {    border: 1px solid #2196F3;        background:#ffffff ;}
        50%  {    border: 1px solid #ff0000;        font-weight: bold;        background:#ffcc00;}
        100%   {border: 1px solid #2196F3; background:#ffffff ;}
    }

    @-webkit-keyframes illuminaterow /* Firefox */
    {
        0%   {    border: 1px solid #2196F3; background:#ffffff;}
        50%  {    border: 1px solid #ff0000;font-weight: bold;        background:#ffcc00;}
        100%   {border: 1px solid #2196F3; background:#ffffff;}
    }


    @-moz-keyframes illuminate /* Firefox */
    {
        0%   {    border: 1px solid #2196F3;        background:#ff3300;}
        50%  {    border: 1px solid #ff0000;        font-weight: bold;        background:#ffcc00;}
        100%   {border: 1px solid #2196F3; background:#ff3300;}
    }

    @-webkit-keyframes illuminate /* Firefox */
    {
        0%   {    border: 1px solid #2196F3; background:#ff3300;}
        50%  {    border: 1px solid #ff0000;font-weight: bold;        background:#ffcc00;}
        100%   {border: 1px solid #2196F3; background:#ff3300;}
    }

    .animation-delay-100 {
        -webkit-animation-delay: 0.1s;
        animation-delay: 0.1s;
    }

    .animation-delay-200 {
        -webkit-animation-delay: 0.2s;
        animation-delay: 0.2s;
    }
</style>