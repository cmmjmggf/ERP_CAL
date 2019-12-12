<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header">
        <div class="row">
            <div class="col-4 col-md-4 col-lg-4 col-xl-4">
                <button type="button" id="btnRefrescar" name="btnRefrescar" class="btn btn-sm btn-warning " data-toggle="tooltip" data-placement="top" title="Refrescar">
                    <span class="fa fa-retweet"></span>
                </button>
            </div>
            <div class="col-4 col-md-4 col-lg-4 col-xl-4">
                <h4 class="font-weight-bold text-center">
                    Asigna dia semana a control para pespunte y preliminar
                </h4>
            </div>
            <div class="col-4 col-md-4 col-lg-4 col-xl-4 text-center">
                <button type="button" id="btnTiemposXEstilos" name="btnTiemposXEstilos" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Tiempos por estilos">
                    <span class="fa fa-clock"></span>
                </button>

                <button type="button" id="btnFracciones" name="btnFracciones" class="btn btn-sm btn-ok mx-4" data-toggle="tooltip" data-placement="top" title="Fracciones">
                    <span class="fa fa-puzzle-piece"></span>
                </button>

                <button type="button" id="btnFraccionesXEstilos" name="btnFraccionesXEstilos" class="btn btn-sm btn-indigo" data-toggle="tooltip" data-placement="top" title="Fracciones por estilos">
                    <span class="fa fa-check-double"></span>
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
                        <input type="radio" name="btnPespunte" id="btnPespunte" autocomplete="off" checked> PESPUNTE
                    </label>
                    <label class="btn btn-indigo">
                        <input type="radio" name="btnPreliminar" id="btnPreliminar" autocomplete="off"> PRELIMINAR
                    </label>
                </div>
            </div>
            <div class="col-2">
            </div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                <label>Año</label>
                <input type="text" id="Anio" name="Anio" class="form-control form-control-sm" maxlength="4">
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
                <!--<select type="text" id="Fraccion" name="Fraccion" class="form-control form-control-sm NotSelectize " maxlength="5" data-toggle="tooltip" data-placement="left" title="300: PESPUNTE GENERAL, 304: PRELIMINAR DE PESPUNTE"></select>-->
            </div> 
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                <label>Cortador</label>
                <div class="row">
                    <div class="col-2">
                        <input type="text" id="xCortador" name="xCortador" class="form-control form-control-sm">
                    </div>
                    <div class="col-10">
                        <select id="Cortador" name="Cortador" class="form-control form-control-sm">
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
                <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm" maxlength="10">
            </div>
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>Color</label>
                <input type="text" id="Color" name="Color" class="form-control form-control-sm d-none" maxlength="10">
                <input type="text" id="ColorNombre" name="ColorNombre" class="form-control form-control-sm" maxlength="10">
            </div>
            <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                <label>Pares</label>
                <input type="text" id="Pares" name="Pares" class="form-control form-control-sm numbersOnly" maxlength="10">
            </div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                <label>TxPar</label>
                <input type="text" id="TxPar" name="TxPar" class="form-control form-control-sm numbersOnly" maxlength="10">
            </div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-1 col-xl-1">
                <label>Precio</label>
                <input type="text" id="Precio" name="Precio" class="form-control form-control-sm numbersOnly" maxlength="10">
            </div>
            <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                <label>Tiempo</label>
                <input type="text" id="Tiempo" name="Tiempo" class="form-control form-control-sm numbersOnly" maxlength="10">
            </div>
            <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 d-none">
                <label>Articulo</label>
                <input type="text" id="ClaveArticulo" name="ClaveArticulo" class="form-control form-control-sm d-none" readonly="" maxlength="50">
                <input type="text" id="Articulo" name="Articulo" class="form-control form-control-sm d-none" readonly="" maxlength="250">
            </div>
            <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                <label>Pesos</label>
                <input type="text" id="Pesos" name="Pesos" class="form-control form-control-sm numbersOnly" maxlength="10">
            </div>
            <button type="button" class="btn btn-info btn-lg btn-float animated tada" id="btnGuardar" name="btnGuardar"  data-toggle="tooltip" data-placement="left" title="Guardar">
                <span class="fa fa-save"></span>
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
                <button id="Anadir" name="Anadir" class="btn btn-primary m-1 animated slideInRight" data-toggle="tooltip" data-placement="left" title="Añadir"><span class="fa fa-arrow-right"></span></button>
                <button id="Quitar" name="Quitar" class="btn btn-danger m-1 animated slideInLeft"  data-toggle="tooltip" data-placement="left" title="Quitar"><span class="fa fa-arrow-left"></span></button>
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

<div id="mdlFracciones" class="modal  modal-fullscreen">
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
    var pnlTablero = $("#pnlTablero"), Anio = pnlTablero.find("#Anio"), Dia = pnlTablero.find("#Dia"),
            Semana = pnlTablero.find("#Semana"),
            xCortador = pnlTablero.find("#xCortador"),
            Cortador = pnlTablero.find("#Cortador"),
            Fraccion = pnlTablero.find("#Fraccion"), Control = pnlTablero.find("#Control"),
            Estilo = pnlTablero.find("#Estilo"), Color = pnlTablero.find("#Color"), Pares = pnlTablero.find("#Pares"),
            Precio = pnlTablero.find("#Precio"), Tiempo = pnlTablero.find("#Tiempo"), btnGuardar = pnlTablero.find("#btnGuardar"),
            ColorNombre = pnlTablero.find("#ColorNombre"), TxPar = pnlTablero.find("#TxPar"), Pesos = pnlTablero.find("#Pesos"),
            ClaveArticulo = pnlTablero.find("#ClaveArticulo"), Articulo = pnlTablero.find("#Articulo");
    var tblControlesSinAsignarAlDia = pnlTablero.find("#tblControlesSinAsignarAlDia"), ControlesSinAsignarAlDia,
            tblControlesAsignadosAlDia = pnlTablero.find("#tblControlesAsignadosAlDia"), ControlesAsignadosAlDia,
            btnPiel = $("#btnPiel"), btnForro = $("#btnForro"), btnAmbas = $("#btnAmbas"),
            btnAnadir = $("#Anadir"), btnQuitar = $("#Quitar"), btnRefrescar = pnlTablero.find("#btnRefrescar"),
            btnTiemposXEstilos = pnlTablero.find("#btnTiemposXEstilos"), btnFracciones = pnlTablero.find("#btnFracciones"),
            btnFraccionesXEstilos = pnlTablero.find("#btnFraccionesXEstilos");
    var Cortadores = pnlTablero.find("#Cortador"), mdlFracciones = $("#mdlFracciones");
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
                titleAttr: 'Deseleccionar Todos'
            }
        ], "ajax": {
            "url": '<?= base_url('AsignaDiaSemACtrlParaPespuntePreliminar/getRecords') ?>',
            "dataSrc": "",
            "data": function (d) {
                d.ANIO = (Anio.val().trim());
                d.SEMANA = (Semana.val().trim());
                d.CORTADOR = (Cortador.val().trim());
                d.CONTROL = (Control.val().trim());
                d.ESTILO = (Estilo.val().trim());
                d.COLOR = (Color.val().trim());
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
        "displayLength": 50,
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
            Anio.focus();
        }
    };
    $(document).ready(function () {

        handleEnterDiv(pnlTablero);

        btnTiemposXEstilos.click(function () {
            $.fancybox.open({
                src: '<?= base_url('TiemposXEstiloDepto/?origen=PRODUCCION'); ?>',
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

        btnFracciones.click(function () {
            $.fancybox.open({
                src: '<?= base_url('Fracciones/?origen=PRODUCCION'); ?>',
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

        btnFraccionesXEstilos.click(function () {
            $.fancybox.open({
                src: '<?= base_url('FraccionesXEstilo/?origen=PRODUCCION'); ?>',
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

        btnRefrescar.click(function () {
            if ($.fn.DataTable.isDataTable('#tblControlesSinAsignarAlDia') && $.fn.DataTable.isDataTable('#tblControlesAsignadosAlDia')) {
                ControlesSinAsignarAlDia.ajax.reload();
                ControlesAsignadosAlDia.ajax.reload(function () {
                    getCortadores();
                });
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

        Cortador.change(function () {
            if (Cortador.val()) {
                xCortador.val(Cortador.val());
            } else {
                xCortador.val('');
                Cortador[0].selectize.enable();
                Cortador[0].selectize.clear(true);
            }
            ControlesAsignadosAlDia.ajax.reload();
        });

        xCortador.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xCortador.val()) {
                    Cortador[0].selectize.setValue(xCortador.val());
                    if (Cortador.val()) {
                        onDisable(Cortador);
                    } else {
                        onCampoInvalido(pnlTablero, 'NO EXISTE ESTE CORTADOR, ESPECIFIQUE OTRO', function () {
                            xCortador.focus().select();
                        });
                    }
                } else {
                    Cortador[0].selectize.enable();
                    Cortador[0].selectize.clear(true);
                }
            } else {
                Cortador[0].selectize.enable();
                Cortador[0].selectize.clear(true);
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
            onGuardarAsignacionDeDiaXControl();
        });

        Fraccion.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            Fraccion.removeClass('bounceIn animated');
        });

        $("#btnPespunte, #btnPreliminar").change(function () {
            onBeep(3);
            switch ($(this).attr('id')) {
                case 'btnPespunte':
                    Fraccion.val(300);
                    break;
                case 'btnPreliminar':
                    Fraccion.val(304);
                    break;
            }
            Fraccion.addClass('bounceIn animated');
        });

        Dia.on('keydown keypress keyup', function () {
            if (parseInt(Dia.val()) >= 1 && parseInt(Dia.val()) <= 7) {
                if (Dia.val().length !== '') {
                    if (parseInt(Dia.val()) === 0) {
                        Dia.val(1);
                    }
                    $.each(dias, function (k, v) {
                        if (parseInt(Dia.val()) === parseInt(k))
                        {
                            pnlTablero.find("#DiaNombre").val(v);
                            return false;
                        }
                    });
                } else if (Dia.val().length === '') {
                    Dia.val('');
                    pnlTablero.find("#DiaNombre").val('');
                }
            }
        });

        Control.on('keydown focusout keyup', function (e) {
            onEnable(Cortador);
            ControlesSinAsignarAlDia.ajax.reload(function () {
                getEstiloColorParesTxParPorControl($(this).val());
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
                    titleAttr: 'Deseleccionar Todos'
                }
            ],
            "ajax": {
                "url": '<?= base_url('AsignaDiaSemACtrlParaPespuntePreliminar/getProgramacion') ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.ANIO = Anio.val() ? Anio.val() : '';
                    d.SEMANA = Semana.val() ? Semana.val() : '';
                    d.DIA = Dia.val() ? Dia.val() : '';
                    d.FRACCION = Fraccion.val() ? Fraccion.val() : '';
                    d.CORTADOR = Cortador.val() ? Cortador.val() : '';
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
            "displayLength": 50,
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
        $.getJSON('<?= base_url('AsignaDiaSemACtrlParaPespuntePreliminar/getCortadores') ?>').done(function (data) {
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
//        $.getJSON('<?= base_url('AsignaDiaSemACtrlParaPespuntePreliminar/getFracciones') ?>').done(function (data) {
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
        $.getJSON('<?= base_url('AsignaDiaSemACtrlParaPespuntePreliminar/getEstiloColorParesTxParPorControl') ?>', {
            CONTROL: e, TIPO: Fraccion.val()[0]
        }).done(function (data, x, jq) {
            var r = data[0];
            if (r) {
                Estilo.val(r.ESTILO);
                Color.val(r.COLOR);
                ColorNombre.val(r.DES_COLOR);
                Pares.val(r.PARES);
                Precio.val(r.PRECIO);
                TxPar.val(r.TXPAR);
                Tiempo.val(r.TIEMPO);
                Pesos.val(r.PESOS);
                Articulo.val(r.ARTICULO);
                ClaveArticulo.val(r.CLAVE_ARTICULO);
                Estilo.focus().select();
            } else {
                swal('ATENCIÓN', 'NO SE HAN ESTABLECIDO TIEMPOS PARA ESTE CONTROL', 'warning').then((value) => {
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
                Fraccion.val() && Cortador.val() && Control.val() &&
                Estilo.val() && Color.val() && Pesos.val() &&
                Articulo.val() && ClaveArticulo.val()) {
            console.log('GUardando...');
            $.post('<?= base_url('AsignaDiaSemACtrlParaPespuntePreliminar/onGuardarAsignacionDeDiaXControl'); ?>',
                    {
                        CORTADOR: Cortador.val(),
                        CONTROL: Control.val(),
                        ANIO: Anio.val(),
                        SEMANA: Semana.val(),
                        DIA: Dia.val(),
                        FRACCION: Fraccion.val(),
                        ESTILO: Estilo.val(),
                        PARES: Pares.val(),
                        TIEMPO: Pares.val(),
                        PRECIO: Pares.val(),
                        ARTICULO: Articulo.val()
                    }).done(function (data, x, jq) {
                pnlTablero.find("input[type='text'].form-control").val('');
                Cortador[0].selectize.clear(true);
                ControlesSinAsignarAlDia.ajax.reload();
                ControlesAsignadosAlDia.ajax.reload();
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
                if (Cortador.val()) {
                    var row = ControlesSinAsignarAlDia.row(tblControlesSinAsignarAlDia.find("tbody tr.selected")).data();
                    if (row) {
                        row["ANIO"] = Anio.val();
                        row["CONTROL"] = $(row.Control).text();
                        row["DIA"] = Dia.val();
                        row["CORTADOR"] = Cortador.val();
                        row["FRACCION"] = Fraccion.val()[0];
                        $.post('<?= base_url('AsignaDiaSemACtrlParaPespuntePreliminar/onAnadirAsignacion'); ?>', row).done(function (data, x, jq) {
                            Cortador[0].selectize.clear(true);
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
                        Cortador[0].selectize.focus();
                        Cortador[0].selectize.open();
                    });
                }
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR UNA FRACCIÓN', 'warning').then((value) => {
                    Fraccion.focus().addClass("highlight-input");
                    setTimeout(function () {
                        Fraccion.removeClass("highlight-input");
                    }, 1500);
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
            $.post('<?= base_url('AsignaDiaSemACtrlParaPespuntePreliminar/onEliminarAsignacion'); ?>', row).done(function (data, x, jq) {
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
    }
</script>
<style>
    .btn-indigo:not(:disabled):not(.disabled):active,
    .btn-indigo:not(:disabled):not(.disabled).active,
    .show > .btn-indigo.dropdown-toggle {
        color: #fff;
        background-color: #99cc00;
        border: 2px solid #99cc00;
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
        -webkit-animation-delay: 1.7s;
        animation-delay: 1.7s;
    }
</style>