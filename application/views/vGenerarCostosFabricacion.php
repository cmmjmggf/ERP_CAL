<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3 float-left">
                <legend class="float-left">Costeo inventarios</legend>
            </div>
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-sm " id="btnCapturarGastos" >
                    <span class="fa fa-check" ></span> GASTOS FABRICACIÓN
                </button>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-primary btn-sm " id="btnVerFichaTecnica" >
                    <span class="fa fa-search" ></span> FICHA TÉCNICA
                </button>
                <button type="button" class="btn btn-secondary btn-sm " id="btnVerFracciones" >
                    <span class="fa fa-search" ></span> FRACCIONES
                </button>
                <button type="button" class="btn btn-danger btn-sm " id="btnVerEstilos" >
                    <span class="fa fa-search" ></span> ESTILOS
                </button>
                <button type="button" class="btn btn-warning btn-sm " id="btnVerColores" >
                    <span class="fa fa-search" ></span> COLORES
                </button>
                <button type="button" class="btn btn-success btn-sm " id="btnGeneraCostos" >
                    <span class="fa fa-dollar-sign" ></span> GENERA COSTOS
                </button>
            </div>
        </div>
        <div class="card-block">
            <div class="table-responsive" id="CosteaInventariosProceso">
                <table id="tblCosteaInventariosProceso" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Maq</th>
                            <th>Linea</th>
                            <th>Estilo</th>
                            <th>Color</th>
                            <th></th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--GUARDAR-->
<div class="card border-0 m-3 d-none animated fadeIn" style="z-index: 99 !important" id="pnlDatos">
    <div class="card-body text-dark">
        <form id="frmNuevo">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 float-left">
                    <legend class="float-left">Costo por Estilo</legend>
                </div>
                <div class="col-12 col-sm-6 col-md-8" align="right">
                    <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                        <span class="fa fa-arrow-left" ></span> REGRESAR
                    </button>
                    <button type="button" class="btn btn-warning btn-sm d-none" id="btnImprimirCosteaInventariosProceso">
                        <span class="fa fa-file-invoice fa-1x"></span> IMPRIMIR
                    </button>
                </div>
            </div>
            <div class=" row">
                <div class="col-12 col-sm-4 col-md-6 col-lg-3">
                    <label for="Estilo">Estilo*</label>
                    <input type="text" id="Estilo" name="Estilo" readonly="" class="form-control form-control-sm" >
                </div>
                <div class="col-12 col-sm-4 col-md-6 col-lg-3">
                    <label for="" >Color</label>
                    <input type="text" id="Color" name="Color" readonly="" class="form-control form-control-sm" >
                </div>
                <div class="col-12 col-sm-4 col-md-6 col-lg-3">
                    <label for="" >Maquila</label>
                    <input type="text" id="Maquila" name="Maquila" readonly="" class="form-control form-control-sm" >
                </div>
            </div>
        </form>
    </div>
</div>
<!--DETALLE-->
<div class="card d-none m-3 animated fadeIn" id="pnlDetalle">
    <div class="card-body" >
        <!--DETALLE-->
        <div class="row">
            <div class=" col-md-9 ">
                <div class="row">
                    <div class="table-responsive" id="CosteaInventariosProcesoDetalle">
                        <table id="tblCosteaInventariosProcesoDetalle" class="table table-sm  " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Departamento</th>
                                    <th>Costo M.O.</th>
                                    <th>Costo Materiales</th>
                                    <th>Gastos</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Totales:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <label for="">Fotografía</label>
                <div id="VistaPrevia" >
                    <img src="<?php echo base_url(); ?>img/camera.png" class="img-thumbnail img-fluid"/>
                </div>
            </div>
        </div>
        <!--FIN DETALLE-->
    </div>
</div>

<!--MODAL DE CAPTURA DE GASTOS-->
<div class="modal " id="mdlCapturaGastosFabricacion"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Captura gastos por Departamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-9">
                        <label class="text-info " style="font-size: 15px;">Si no visualiza nada hacer click en el botón de [LIMPIA Y CAPTURA]--></label>
                    </div>
                    <div class="col-sm-3 float-right" align="right">
                        <button type="button" class="btn btn-danger btn-sm"  id="btnLimpiarTabla">
                            <span class="fa fa-cogs" ></span> LIMPIA Y CAPTURA
                        </button>
                    </div>


                    <div class="col-sm-12 mt-3">
                        <div class="table-responsive" id="GastosFabrica">
                            <table id="tblGastosFabrica" class="table table-sm  " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Clave</th>
                                        <th>Departamento</th>
                                        <th>Costo</th>
                                        <th>Costo Oculto</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total:</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12" align="center">
                        <label class="badge badge-danger" style="font-size: 15px;">CUALQUIER MODIFICACIÓN, TENDRÁ QUE VOLVER A REGENERAR LOS COSTOS</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"  id="btnAceptar" data-dismiss="modal">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>

<!--SCRIPT-->
<script>
    var master_url = base_url + 'index.php/GenerarCostosFabricacion/';
    var pnlDatos = $("#pnlDatos");
    var pnlTablero = $("#pnlTablero");
    var pnlDetalle = $("#pnlDetalle");
    var btnNuevo = $("#btnNuevo");
    var btnGeneraCostos = $("#btnGeneraCostos");
    var btnCapturarGastos = $("#btnCapturarGastos");


    var btnVerFichaTecnica = $('#btnVerFichaTecnica');
    var btnVerFracciones = $('#btnVerFracciones');
    var btnVerEstilos = $('#btnVerEstilos');
    var btnVerColores = $('#btnVerColores');

    var mdlCapturaGastosFabricacion = $('#mdlCapturaGastosFabricacion');

    var btnCancelar = pnlDatos.find("#btnCancelar");
    var IdMovimiento = 0;
    var nuevo = true;
    $(document).ready(function () {

        btnVerColores.click(function () {
            $.fancybox.open({
                src: base_url + '/Colores.shoes/?origen=PRODUCCION',
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

        btnVerEstilos.click(function () {
            $.fancybox.open({
                src: base_url + '/Estilos.shoes/?origen=PRODUCCION',
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

        btnVerFracciones.click(function () {
            $.fancybox.open({
                src: base_url + '/FraccionesXEstilo.shoes/?origen=PRODUCCION',
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

        btnVerFichaTecnica.click(function () {
            $.fancybox.open({
                src: base_url + '/FichaTecnica.shoes/?origen=PRODUCCION',
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

        btnCancelar.click(function () {
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass('d-none');
            pnlDetalle.addClass('d-none');
        });
        getRecords();
        handleEnter();
        btnGeneraCostos.click(function () {

            swal({
                title: "¿Estás seguro?",
                text: "Nota: Esta acción no se puede revertir",
                icon: "warning",
                closeOnClickOutside: false,
                closeOnEsc: false,
                buttons: {
                    cancelar: {
                        text: "Cancelar",
                        value: "cancelar"
                    },
                    eliminar: {
                        text: "Aceptar",
                        value: "aceptar"
                    }
                }
            }).then((value) => {
                switch (value) {
                    case "aceptar":
                        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
                        $.ajax({
                            url: master_url + 'onValidaExisteFichaTecnicaManoObra',
                            type: "POST",
                            dataType: "JSON"
                        }).done(function (data, x, jq) {
                            var mensaje = 'Los siguientes registros no tienen ficha técnica: \n\n';
                            var mensaje2 = 'Los siguientes registros no tienen mano de obra: \n\n';

                            if (data.length > 0) { //Hay estilos sin ficha técnica o mano de obra
                                $.each(data, function (k, v) {
                                    if (v.msg === 'FT') {
                                        mensaje += 'Estilo: ' + v.estilo + ' <--> Color: ' + v.color + ' \n';
                                    } else {
                                        mensaje2 += 'Estilo: ' + v.estilo + ' \n';
                                    }
                                });

                                HoldOn.close();
                                //Mandamos mensaje al usuario si quiere continuar o cancela la operacion
                                swal({
                                    title: "ATENCION",
                                    text: mensaje + ' \n' + mensaje2,
                                    icon: "warning",
                                    closeOnClickOutside: false,
                                    closeOnEsc: false,
                                    buttons: {
                                        cancelar: {
                                            text: "Cancelar",
                                            value: "cancelar"
                                        },
                                        eliminar: {
                                            text: "Continuar",
                                            value: "aceptar"
                                        }
                                    }
                                }).then((value) => {
                                    switch (value) {
                                        case "aceptar":
                                            onGenerarCostos();
                                        case "cancelar":
                                            swal.close();
                                            break;
                                    }
                                });

                            } else {//Se generan los costos sin ningun mensaje
                                onGenerarCostos();
                            }
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                            HoldOn.close();
                        });

                    case "cancelar":
                        swal.close();
                        break;
                }
            });
        });

        btnCapturarGastos.click(function () {
            mdlCapturaGastosFabricacion.modal('show');
        });

        mdlCapturaGastosFabricacion.on('shown.bs.modal', function () {
            mdlCapturaGastosFabricacion.find("input").val("");
            $.each(mdlCapturaGastosFabricacion.find("select"), function (k, v) {
                mdlCapturaGastosFabricacion.find("select")[k].selectize.clear(true);
            });
            getDeptosParaGastosDepto();
        });

        mdlCapturaGastosFabricacion.find('#btnLimpiarTabla').click(function () {
            HoldOn.open({theme: "sk-bounce", message: "CARGANDO DATOS..."});
            $.ajax({
                url: master_url + 'onLimpiarTabla',
                type: "POST"
            }).done(function (data, x, jq) {
                GastosFabrica.ajax.reload();
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

    });
    function onGenerarCostos() {
        HoldOn.open({theme: "sk-bounce", message: "GENERANDO COSTOS,POR FAVOR ESPERE..."});
        $.ajax({
            url: master_url + 'onGenerarCostosInventarioProceso',
            type: "POST"
        }).done(function (data, x, jq) {
            swal('ATENCIÓN', 'SE HAN GENERADO LOS COSTOS', 'success');
            CosteaInventariosProceso.ajax.reload();
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }
    var tblCosteaInventariosProceso = $('#tblCosteaInventariosProceso');
    var CosteaInventariosProceso;
    function getRecords() {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblCosteaInventariosProceso')) {
            tblCosteaInventariosProceso.DataTable().destroy();
        }
        CosteaInventariosProceso = tblCosteaInventariosProceso.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataType": "json",
                "type": 'POST',
                "dataSrc": ""
            },
            "columns": [
                {"data": "maq"},
                {"data": "linea"},
                {"data": "estilo"},
                {"data": "color"},
                {"data": "colorT"},
                {"data": "totalmp"}
            ],
            "columnDefs": [
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 20,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: true,
            "bSort": true,
            "aaSorting": [

            ],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        $('#tblCosteaInventariosProceso_filter input[type=search]').focus();
        tblCosteaInventariosProceso.find('tbody').on('click', 'tr', function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            nuevo = false;
            tblCosteaInventariosProceso.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = CosteaInventariosProceso.row(this).data();
            temp = dtm.EstiloId;
            $.getJSON(master_url + 'getDetalleByEstiloColorMaq', {estilo: dtm.estilo, color: dtm.color, maq: dtm.maq}).done(function (data, x, jq) {
                pnlDatos.find("input").val("");
                pnlDatos.find("#Estilo").val(dtm.estilo);
                pnlDatos.find("#Color").val(dtm.color + ' ' + dtm.colorT);
                pnlDatos.find("#Maquila").val(dtm.maq);
                getFotoXEstilo(dtm.estilo);
                getCosteaInventariosProcesoDetalleByID(dtm.estilo, dtm.color, dtm.maq);
                pnlTablero.addClass("d-none");
                pnlDetalle.removeClass('d-none');
                pnlDatos.removeClass('d-none');
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            }).always(function () {
            });
        });
    }
    var tblGastosFabrica = $('#tblGastosFabrica');
    var GastosFabrica;
    function getDeptosParaGastosDepto() {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblGastosFabrica')) {
            tblGastosFabrica.DataTable().destroy();
        }
        GastosFabrica = tblGastosFabrica.DataTable({
            "dom": 'frt',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getDeptosParaGastosDepto',
                "dataType": "json",
                "type": 'POST',
                "dataSrc": ""
            },
            "columns": [
                {"data": "clave"},
                {"data": "departamento"},
                {"data": "costo"},
                {"data": "costoHide"}
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(); //Get access to Datatable API
                // Update footer

                var totalCV = api.column(3).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(2).footer()).html(api.column(2, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(totalCV), 2, '.', ',');
                }, 0));
            },
            "columnDefs": [
                {
                    "targets": [3],
                    "visible": false,
                    "searchable": false
                },
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": false,
            "displayLength": 50,
            scrollY: 240,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: true,
            "bSort": true,
            "aaSorting": [

            ],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        $('#tblGastosFabrica_filter input[type=search]').focus();
        tblGastosFabrica.find('tbody').on('click', 'tr', function () {
            tblGastosFabrica.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }
    function onChangeCosto(costo, depto) {
        HoldOn.open({theme: "sk-bounce", message: "CARGANDO DATOS..."});
        $.ajax({
            url: master_url + 'onChangeCosto',
            type: "POST",
            data: {
                costo: costo === 0 ? 0 : costo,
                depto: depto
            }
        }).done(function (data, x, jq) {
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }
    function validate(event, val) {
        if (((event.which !== 46 || (event.which === 46 && val === '')) || val.indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    }
    var tblCosteaInventariosProcesoDetalle = pnlDetalle.find('#tblCosteaInventariosProcesoDetalle');
    var CosteaInventariosProcesoDetalle;
    function getCosteaInventariosProcesoDetalleByID(Estilo, Color, Maquila) {

        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblCosteaInventariosProcesoDetalle')) {
            tblCosteaInventariosProcesoDetalle.DataTable().destroy();
        }
        CosteaInventariosProcesoDetalle = tblCosteaInventariosProcesoDetalle.DataTable({
            "ajax": {
                "url": master_url + 'getDetalleByEstiloColorMaq',
                "dataSrc": "",
                "data": {
                    "estilo": Estilo,
                    "color": Color,
                    "maq": Maquila
                }
            },
            "columnDefs": [

                {
                    "targets": [1],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }, {
                    "targets": [2],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [3],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [4],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [5],
                    "visible": false,
                    "searchable": false
                }

            ],
            "columns": [
                {"data": "depto"}, /*0*/
                {"data": "costomo"}, /*1*/
                {"data": "costomp"}, /*2*/
                {"data": "gastos"}, /*3*/
                {"data": "total"}, /*4*/
                {"data": "orden"} /*4*/
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(); //Get access to Datatable API
                // Update footer
                var totalMO = api.column(1).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(1).footer()).html(api.column(1, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(totalMO), 2, '.', ',');
                }, 0));
                var totalMP = api.column(2).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(2).footer()).html(api.column(2, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(totalMP), 2, '.', ',');
                }, 0));
                var totalG = api.column(3).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(3).footer()).html(api.column(3, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(totalG), 2, '.', ',');
                }, 0));
                var totalGEN = api.column(4).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(4).footer()).html(api.column(4, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(totalGEN), 2, '.', ',');
                }, 0));
            },
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*COSTO MO*/
                            c.addClass('text-info text-strong');
                            break;
                        case 4:
                            /*ELIMINAR*/
                            c.addClass('text-strong');
                            break;
                    }
                });
            },
            "dom": 'frt',
            "autoWidth": true,
            language: lang,
            "displayLength": 500,
            "colReorder": true,
            "bLengthChange": false,
            "deferRender": true,
            "scrollY": 350,
            "scrollCollapse": true,
            "bSort": true,
            "keys": true,
            order: [[5, 'asc']],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        tblCosteaInventariosProcesoDetalle.find('tbody').on('click', 'tr', function () {
            tblCosteaInventariosProcesoDetalle.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var tr = $(this);
        });
    }
    function getFotoXEstilo(Estilo) {
        $.getJSON(base_url + 'index.php/FraccionesXEstilo/' + 'getEstiloByID', {Estilo: Estilo}).done(function (data, x, jq) {

            if (data.length > 0) {
                var dtm = data[0];
                var vp = pnlDetalle.find("#VistaPrevia");
                if (dtm.Foto !== null && dtm.Foto !== undefined && dtm.Foto !== '') {
                    var ext = getExt(dtm.Foto);
                    if (ext === "gif" || ext === "jpg" || ext === "png" || ext === "jpeg") {
                        vp.html('<img src="' + base_url + dtm.Foto + '" class="img-thumbnail img-fluid" width="400px" />');
                    }
                    if (ext !== "gif" && ext !== "jpg" && ext !== "jpeg" && ext !== "png" && ext !== "PDF" && ext !== "Pdf" && ext !== "pdf") {
                        vp.html('<img src="' + base_url + 'img/camera.png" class="img-thumbnail img-fluid"/>');
                    }
                } else {
                    vp.html('<img src="' + base_url + 'img/camera.png" class="img-thumbnail img-fluid"/>');
                }
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
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
</style>

<style>
    .table-sm th, .table-sm td {
        padding: 0.05rem;
    }
</style>