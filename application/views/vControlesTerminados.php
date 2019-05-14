<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4 col-md-4 float-left">
                <legend class="float-left">Controles Terminados</legend>
            </div>
            <div class="col-sm-2 col-md-2 float-left">
                <button type="button" class="btn btn-primary btn-sm " id="btnBuscar" >
                    <span class="fa fa-search" ></span> BUSCA DOC
                </button>
                <button type="button" class="btn btn-primary btn-sm " id="btnBuscarControl" >
                    <span class="fa fa-search" ></span> BUSCA CONTROL
                </button>
            </div>
            <div class="col-12 col-sm-6 col-md-6 animated bounceInLeft" align="right" id="Acciones">
                <button type="button" class="btn btn-primary btn-sm " id="btnVerOrdPrd" >
                    <span class="fa fa-eye" ></span> VER ORD. PROD.
                </button>
                <button type="button" class="btn btn-secondary btn-sm " id="btnVerDefectos" >
                    <span class="fa fa-check-double" ></span> DEFECTOS
                </button>
                <button type="button" class="btn btn-info btn-sm " id="btnVerDetalles" >
                    <span class="fa fa-cube" ></span> DETALLES
                </button>
                <button type="button" class="btn btn-warning btn-sm" id="btnListaPrecios" >
                    <span class="fa fa-dollar-sign" ></span> LISTA PRECIOS
                </button>
                <button type="button" class="btn btn-success btn-sm" id="btnGeneralListaPrecios" >
                    <span class="fa fa-dollar-sign" ></span> GEN PRECIOS A MAQ-1
                </button>
                <button type="button" class="btn btn-danger btn-sm" id="btnDevClientes" >
                    <span class="fa fa-ban" ></span> DEV. DE CLIENTES
                </button>

            </div>
            <div class="col-12 col-sm-6 col-md-6 d-none animated flipInX" id="Busqueda">
                <div class="container">
                    <div class="row">
                        <div class="col-4">
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="MaqB" placeholder="Maq">
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control form-control-sm numbersOnly" id="DocB" placeholder="Documento">
                        </div>
                        <div class="col-4 text-right">
                            <button type="button" id="btnAceptarBusqueda" class="btn btn-primary btn-sm ">
                                <span class="fa fa-check"></span> ACEPTAR
                            </button>
                            <button type="button" class="btn btn-success btn-sm" id="btnImprimirB">
                                <i class="fa fa-print"></i> RE-IMPRIMIR
                            </button>
                            <button type="button" id="btnCancelarBusqueda" class="btn btn-secondary btn-sm " data-toggle="tooltip" data-placement="top" title="Cancelar Busqueda">
                                <span class="fa fa-arrow-left"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="card-body" style="padding-top: 0px; padding-bottom: 10px;">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Maquila</label>
                <select id="Maquila" name="Maquila" class="form-control form-control-sm required"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Reproceso</label>
                <select id="Reproceso" name="Reproceso" class="form-control form-control-sm required">
                    <option value=""></option>
                    <option value="1">1 PRODUCCIÓN</option>
                    <option value="2">2 REPROCESO</option>
                </select>
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Control</label>
                <input type="text" id="Control" name="Control" maxlength="10" class="form-control form-control-sm numeric" required="">
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Precio</label>
                <input type="text" id="Precio" name="Precio" maxlength="7" readonly="" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Docto</label>
                <input type="text" id="Docto" name="Docto" readonly="" class="form-control form-control-sm numeric">
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Estilo</label>
                <input type="text" id="Estilo" name="Estilo"readonly="" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Color</label>
                <input type="text" id="Color" name="Color"readonly="" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-1 col-lg-1 col-xl-1">
                <label>Semana</label>
                <input type="text" id="Semana" maxlength="2" name="Semana"  readonly="" class="form-control form-control-sm numeric">
            </div>
            <div class="col-12 col-xs-12 col-sm-1 col-lg-1 col-xl-1">
                <label>Pares</label>
                <input type="text" id="Pares" maxlength="4" name="Pares" readonly="" class="form-control form-control-sm numeric">
            </div>

        </div>
        <div class="row">
            <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-2" >
                <label for="" >Defecto</label>
                <select id="Defecto" name="Defecto" class="form-control form-control-sm " >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-2" >
                <label for="" >Detalle</label>
                <select id="DetalleDefecto" name="DetalleDefecto" class="form-control form-control-sm ">
                    <option value=""></option>
                </select>
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3 d-sm-block pt-4">
                <button type="button" id="btnAceptar" class="btn btn-primary btn-sm ">
                    <span class="fa fa-check"></span> ACEPTAR
                </button>
                <button type="button" class="btn btn-success btn-sm" id="btnImprimir">
                    <i class="fa fa-print"></i> IMPRIMIR
                </button>
            </div>
        </div>

        <div class="w-100 my-2"></div>
        <div class="row">

            <div class="col-12 col-sm-12 col-md-7">
                <h4>Controles terminados</h4>
                <div class="row">
                    <table id="tblControlesTerminados" class="table table-sm display" style="width:  100%;">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Control</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Fca</th>
                                <th scope="col">Sem</th>
                                <th scope="col">Est</th>
                                <th scope="col">Co</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Docto</th>
                                <th scope="col">Pares</th>
                                <th scope="col">Rechaza</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-5">
                <h4>Controles rechazados</h4>
                <div class="row">
                    <table id="tblControlesRechazados" class="table table-sm display" style="width:  100%;">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Control</th>
                                <th scope="col">Defe</th>
                                <th scope="col">Deta</th>
                                <th scope="col">Fca</th>

                                <th scope="col">Sem</th>
                                <th scope="col">Docto</th>
                                <th scope="col">Pares</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-fullscreen" id="mdlReporte"  role="dialog">
    <div class="modal-dialog modal-dialog-centered" id="Reporte" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#ctrlsTerminados">Controles Terminados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#ctrlsRechazados">Controles Rechazados</a>
                    </li>
                </ul>
                <div id="tcReportes" class="tab-content"  style="width: 100%; height: 95%">
                    <div class="tab-pane fade show active" id="ctrlsTerminados"  style="height: inherit;">
                        <iframe id="ifReporte1" frameborder="0" scrolling="no" style="width: 100%; height: 100%"></iframe>
                    </div>
                    <div class="tab-pane fade" id="ctrlsRechazados" style="height: inherit;">
                        <iframe id="ifReporte2" frameborder="0" scrolling="no" style="width: 100%; height: 100%"></iframe>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/ControlesTerminados/';
    var pnlTablero = $("#pnlTablero div.card-body");
    var Maquila = pnlTablero.find("#Maquila"), Reproceso = pnlTablero.find("#Reproceso"),
            Precio = pnlTablero.find("#Precio"), Control = pnlTablero.find("#Control"),
            Docto = pnlTablero.find("#Docto"), Estilo = pnlTablero.find("#Estilo"),
            Color = pnlTablero.find("#Color"), Semana = pnlTablero.find("#Semana"),
            Pares = pnlTablero.find("#Pares"),
            ControlesTerminados, tblControlesTerminados = pnlTablero.find("#tblControlesTerminados"),
            ControlesRechazados, tblControlesRechazados = pnlTablero.find("#tblControlesRechazados"),
            btnAceptar = pnlTablero.find("#btnAceptar");
    var btnVerDefectos = pnlTablero.find('#btnVerDefectos');
    var btnVerOrdPrd = pnlTablero.find('#btnVerOrdPrd');
    var btnVerDetalles = pnlTablero.find('#btnVerDetalles');
    var btnListaPrecios = pnlTablero.find('#btnListaPrecios');
    var btnGeneralListaPrecios = pnlTablero.find('#btnGeneralListaPrecios');
    var btnDevClientes = pnlTablero.find('#btnDevClientes');
    var btnImprimir = pnlTablero.find('#btnImprimir');
    var btnImprimirB = pnlTablero.find('#btnImprimirB');
    var btnBuscarControl = pnlTablero.find('#btnBuscarControl');

    var nuevo = true;
    var Estilo = '', Color = '';

    /*Busqueda*/
    var btnBuscar = $('#btnBuscar');
    var btnAceptarBusqueda = $('#btnAceptarBusqueda');
    var btnCancelarBusqueda = $('#btnCancelarBusqueda');

    /*Reporte*/
    var mdlReporte = $('#mdlReporte');
    var generado = false;
    var reporteBusqueda = false;

    $(document).ready(function () {
        //validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToSelectOnChange('#Maquila', '#Reproceso', pnlTablero);
        setFocusSelectToInputOnChange('#Reproceso', '#Control', pnlTablero);
        setFocusSelectToSelectOnChange('#Defecto', '#DetalleDefecto', pnlTablero);
        setFocusSelectToInputOnChange('#DetalleDefecto', '#btnAceptar', pnlTablero);
        init();
        handleEnter();

        btnBuscarControl.click(function () {
            swal({
                title: 'BÚSQUEDA X CONTROL',
                text: "INTRODUCE EL # DE CONTROL: ",
                content: 'input'
            }).then((value) => {
                $.getJSON(master_url + 'getDocMaqByControlTerm', {
                    Control: value
                }).done(function (data) {
                    console.log(data[0].Maquila, data[0].docto);
                    getControlesRechazados(data[0].docto, data[0].Maquila);
                    getControlesTerminados(data[0].docto, data[0].Maquila);
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
            });

        });
        btnVerDefectos.click(function () {
            $.fancybox.open({
                src: base_url + '/Defectos.shoes/?origen=PRODUCCION',
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
                            width: "85%",
                            height: "85%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });
        btnListaPrecios.click(function () {
            $.fancybox.open({
                src: base_url + '/ListasPrecioMaquilas.shoes/?origen=PRODUCCION',
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
                            width: "85%",
                            height: "85%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });
        btnVerDetalles.click(function () {
            $.fancybox.open({
                src: base_url + '/DetallesDefectos.shoes/?origen=PRODUCCION',
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
                            width: "85%",
                            height: "85%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });
        btnVerOrdPrd.click(function () {
            $.fancybox.open({
                src: base_url + '/OrdenDeProduccionPantalla.shoes/?origen=PRODUCCION',
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
                            width: "85%",
                            height: "85%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });
        Control.change(function () {
            if (Maquila.val()) {
                if ($(this).val()) {
                    $.getJSON(master_url + 'getControl', {
                        Control: $(this).val(),
                        Maq: Maquila.val()
                    }).done(function (data) {
                        if (data.length > 0) { //Si el control existe primero se valida que no este fact o cancelado
                            if (data[0].Depto === '260') {
                                swal({
                                    title: "CONTROL YA FACTURADO",
                                    text: "EL CONTROL YA HA SIDO FACTURADO VERIFIQUE CON VENTAS ",
                                    icon: "warning",
                                    closeOnClickOutside: false,
                                    closeOnEsc: false
                                }).then((action) => {
                                    if (action) {
                                        Control.val('').focus();
                                    }
                                });
                            } else if (data[0].Depto === '270') {
                                swal({
                                    title: "CONTROL CANCELADO POR EL CLIENTE",
                                    text: "****MOTIVO EXTEMPORANEO****",
                                    icon: "warning",
                                    closeOnClickOutside: false,
                                    closeOnEsc: false
                                }).then((action) => {
                                    if (action) {
                                        Control.val('').focus();
                                    }
                                });
                            } else { //si el control no está cancelado o facturado permite continuar
                                if (data[0].Terminado !== '') {// si el control ya se recibio y está en controlterm

                                    swal({
                                        title: "ATENCIÓN",
                                        text: "EL CONTROL YA FUE RECIBIDO CON ANTERIORIDAD",
                                        icon: "warning",
                                        closeOnClickOutside: false,
                                        closeOnEsc: false
                                    }).then((action) => {
                                        if (action) {
                                            Control.val('').focus();
                                        }
                                    });
                                } else { //Si el control no está recibido en controlterm

                                    //Validación sólo para maquilas dif a 98
                                    if (Maquila.val() !== '98') {
                                        if (data[0].Depto !== '230') {
                                            swal({
                                                title: "ATENCIÓN",
                                                text: "EL CONTROL NO CONCUERDA CON EL AVANCE REQUERIDO",
                                                icon: "warning",
                                                closeOnClickOutside: false,
                                                closeOnEsc: false
                                            }).then((action) => {
                                                if (action) {
                                                    Control.val('').focus();
                                                }
                                            });
                                        } else {
                                            //Aquí van las siguientes validaciones
                                            if (parseFloat(data[0].Precio) > 0) {
                                                $.each(data[0], function (k, v) {
                                                    pnlTablero.find("#" + k).val(v);
                                                });
                                                //Si es nuevo crea el folio
                                                if (nuevo) {
                                                    getFolio();
                                                }


                                                Estilo = data[0].ClaveEstilo;
                                                Color = data[0].ClaveColor;
                                                pnlTablero.find('#Defecto')[0].selectize.focus();
                                            } else {
                                                swal({
                                                    title: "ATENCIÓN",
                                                    text: "EL ESTILO NO TIENE PRECIO DE VENTA",
                                                    icon: "warning",
                                                    closeOnClickOutside: false,
                                                    closeOnEsc: false
                                                }).then((action) => {
                                                    if (action) {
                                                        Control.val('').focus();
                                                    }
                                                });
                                            }
                                        }
                                    } else { //No se valida el precio ni el departamento del que viene
                                        $.each(data[0], function (k, v) {
                                            pnlTablero.find("#" + k).val(v);
                                        });
                                        getFolio();
                                        pnlTablero.find('#Defecto')[0].selectize.focus();
                                    }
                                }
                            }
                        } else { //Si el control no existe
                            swal({
                                title: "ATENCIÓN",
                                text: "EL CONTROL NO EXISTE EN PRODUCCIÓN ",
                                icon: "warning",
                                closeOnClickOutside: false,
                                closeOnEsc: false
                            }).then((action) => {
                                if (action) {
                                    Control.val('').focus();
                                }
                            });
                        }
                    });
                } else {//Valida que no esté en blanco el campo
                    swal({
                        title: "ATENCIÓN",
                        text: "DEBES DE CAPTURAR UN # DE CONTROL ",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        if (action) {
                            Control.val('').focus();
                        }
                    });
                }
            } else {//Valida que la maquila se haya capturado
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE CAPTURAR UNA MAQUILA ",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    if (action) {
                        Maquila[0].selectize.focus();
                    }
                });
            }
        });
        Maquila.change(function () {
            Control.val('');
        });
        btnAceptar.click(function () {
            var precio = pnlTablero.find('#Precio').val();
            if (Maquila.val() !== '98') { //Si la maquila no es la 98 hace la validación del precio
                if (parseFloat(precio) > 0) {
                    onAgregar();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "EL PRECIO NO PUEDE IR VACÍO, POR FAVOR REVISA CON VENTAS Y CAPTURA EL PRECIO DE VENTAS",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        if (action) {

                        }
                    });
                }
            } else { //si es la 98 la deja agregar
                onAgregar();
            }
        });
        mdlReporte.draggable();
        mdlReporte.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var maqB = (reporteBusqueda) ? pnlTablero.find('#Busqueda').find('#MaqB').val() : Maquila.val();
            var docB = (reporteBusqueda) ? pnlTablero.find('#Busqueda').find('#DocB').val() : Docto.val();
            var target = $(e.target).attr("href"); // activated tab
            if (target === '#ctrlsRechazados') {
                if (!generado) {
                    onReporteRechazados(maqB, docB);
                }

            }
        });

        /*FUNCIONES X BOTON*/

        btnImprimirB.click(function () {
            var maqB = pnlTablero.find('#Busqueda').find('#MaqB').val();
            var docB = pnlTablero.find('#Busqueda').find('#DocB').val();
            generado = false;
            reporteBusqueda = true;
            onImprimirReportes(maqB, docB);
        });

        btnImprimir.click(function () {
            var doc = Docto.val();
            var maq = Maquila.val();
            generado = false;
            reporteBusqueda = false;
            onImprimirReportes(maq, doc);
        });

        btnBuscar.click(function () {
            pnlTablero.find('#Acciones').addClass('d-none');
            pnlTablero.find('#Busqueda').removeClass('d-none');
            pnlTablero.find('#Busqueda').find('#MaqB').focus();
        });

        btnCancelarBusqueda.click(function () {
            pnlTablero.find('#Acciones').removeClass('d-none');
            pnlTablero.find('#Busqueda').addClass('d-none');
            pnlTablero.find('#Busqueda').find('input').val('');
            getControlesTerminados('', '');
            getControlesRechazados('', '');
            Maquila[0].selectize.focus();
        });

        btnAceptarBusqueda.click(function () {
            var maq = pnlTablero.find('#Busqueda').find('#MaqB').val();
            var doc = pnlTablero.find('#Busqueda').find('#DocB').val();
            getControlesTerminados(doc, maq);
            getControlesRechazados(doc, maq);

        });

        mdlReporte.on("hidden.bs.modal", function () {

            if (!reporteBusqueda) {
                nuevo = true;
                Estilo = '';
                Color = '';
                pnlTablero.find("input").val('');
                pnlTablero.find("#Defecto")[0].selectize.clear(true);
                pnlTablero.find("#DetalleDefecto")[0].selectize.clear(true);
                pnlTablero.find("#Maquila")[0].selectize.clear(true);
                pnlTablero.find("#Reproceso")[0].selectize.clear(true);
                getControlesTerminados('', '');
                getControlesRechazados('', '');
                pnlTablero.find("#Maquila")[0].selectize.focus();
            }
        });

    });

    function onImprimirReportes(maq, doc) {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        mdlReporte.find(".nav-tabs li a").removeClass("active show");
        $(mdlReporte.find(".nav-tabs li a")[0]).addClass("active show");
        mdlReporte.find("#ctrlsTerminados").addClass("active show");
        mdlReporte.find("#ctrlsRechazados").removeClass("active show");

        $.ajax({
            url: master_url + 'onImprimirTerminados',
            type: "POST",
            data: {
                Maquila: maq,
                Doc: doc
            }
        }).done(function (data, x, jq) {

            if (data.length > 0) {
                mdlReporte.find('#ifReporte1').attr('src', base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs');
                mdlReporte.modal({backdrop: false});

            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                    icon: "error"
                }).then((action) => {
                    mdlReporte.modal('hide');
                    btnCancelarBusqueda.trigger('click');
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }

    function onReporteRechazados(maq, doc) {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        $.ajax({
            url: master_url + 'onImprimirRechazados',
            type: "POST",
            data: {
                Maquila: maq,
                Doc: doc
            }
        }).done(function (data, x, jq) {
            console.log(data);
            if (data.length > 0) {
                generado = true;
                mdlReporte.find('#ifReporte2').attr('src', base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs');
                HoldOn.close();
            } else {
                HoldOn.close();
                swal({
                    title: "ATENCIÓN",
                    text: "NO EXISTEN CONTROLES RECHAZADOS",
                    icon: "error"
                });
                mdlReporte.find(".nav-tabs li a").removeClass("active show");
                $(mdlReporte.find(".nav-tabs li a")[0]).addClass("active show");
                mdlReporte.find("#ctrlsTerminados").addClass("active show");
                mdlReporte.find("#ctrlsRechazados").removeClass("active show");
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }

    function onAgregar() {
        var defecto = pnlTablero.find('#Defecto').val();
        var detalledefecto = pnlTablero.find('#DetalleDefecto').val();
        var depto_destino = '';
        var deptoT_destino = '';
        isValid('pnlTablero');
        if (valido) {
            if (defecto === '' && detalledefecto === '') {
                //inserta en control terminado
                $.post(master_url + 'onAgregar', {
                    control: Control.val(),
                    docto: Docto.val(),
                    maq: Maquila.val(),
                    sem: Semana.val(),
                    estilo: Estilo,
                    color: Color,
                    prevta: Precio.val(),
                    pares: Pares.val()
                }).done(function (data) {


                    /*Valida para maq 98 y seguridad*/
                    if (seg === 1 && Maquila.val() === '98') { //Control de muestras
                        depto_destino = '260';
                        deptoT_destino = 'FACTURADO';
                    } else { //Aquí es cuando es un control normal
                        depto_destino = '240';
                        deptoT_destino = 'TERMINADO';
                    }

                    $.post(master_url + 'onAgregarAvanceControl', {
                        Control: Control.val(),
                        Departamento: depto_destino,
                        DepartamentoT: deptoT_destino
                    }).done(function (data) {
                        if (nuevo) {
                            getControlesTerminados(Docto.val(), Maquila.val());
                            getControlesRechazados(Docto.val(), Maquila.val());
                            nuevo = false;
                        } else {
                            ControlesTerminados.ajax.reload();
                            ControlesRechazados.ajax.reload();
                        }

                        pnlTablero.find("input:not(#Docto)").val('');
                        pnlTablero.find("#Defecto")[0].selectize.clear(true);
                        pnlTablero.find("#DetalleDefecto")[0].selectize.clear(true);
                        pnlTablero.find('#Control').focus();
                    }).fail(function (x, y, z) {
                        getError(x);
                    });


                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
            } else if (defecto !== '' && detalledefecto === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE SELECCIONAR DEL DETALLE DEL DEFECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    if (action) {
                        pnlTablero.find('#DetalleDefecto')[0].selectize.focus();
                    }
                });
            } else if (defecto === '' && detalledefecto !== '') {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE SELECCIONAR UN DEFECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    if (action) {
                        pnlTablero.find('#Defecto')[0].selectize.focus();
                    }
                });
            } else {
                //inserta en controlcalidad
                $.post(master_url + 'onAgregarRechazado', {
                    Control: Control.val(),
                    Defecto: defecto,
                    Detalle: detalledefecto,
                    Maq: Maquila.val(),
                    Sem: Semana.val(),
                    Docto: Docto.val(),
                    Pares: Pares.val()
                }).done(function (data) {

                    if (nuevo) {
                        getControlesTerminados(Docto.val(), Maquila.val());
                        getControlesRechazados(Docto.val(), Maquila.val());
                        nuevo = false;
                    } else {
                        ControlesTerminados.ajax.reload();
                        ControlesRechazados.ajax.reload();
                    }

                    pnlTablero.find("input:not(#Docto)").val('');
                    pnlTablero.find("#Defecto")[0].selectize.clear(true);
                    pnlTablero.find("#DetalleDefecto")[0].selectize.clear(true);
                    pnlTablero.find('#Control').focus();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
            }
        } else {
            swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
        }
    }

    function getControlesTerminados(doc, maq) {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblControlesTerminados')) {
            tblControlesTerminados.DataTable().destroy();
        }
        ControlesTerminados = tblControlesTerminados.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getControlesTerminados',
                "dataType": "json",
                "type": 'GET',
                "data": {Docto: doc, Maq: maq},
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"},
                {"data": "control"},
                {"data": "fecha"},
                {"data": "Maquila"},
                {"data": "Semana"},
                {"data": "estilo"},
                {"data": "color"},
                {"data": "prevta"},
                {"data": "docto"},
                {"data": "pares"},
                {"data": "Rechazar"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*UNIDAD*/
                            c.addClass('text-info text-strong');
                            break;
                        case 6:
                            /*CONSUMO*/
                            c.addClass('text-success text-strong');
                            break;
                        case 7:
                            /*PZXPAR*/
                            c.addClass('text-strong');
                            break;
                        case 9:
                            /*ELIMINAR*/
                            c.addClass('text-strong text-danger');
                            break;
                    }
                });
            },
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 20,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "scrollX": true,
            keys: true,
            "bSort": true,
            "aaSorting": [
                [1, 'asc']/*ID*/
            ],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        tblControlesTerminados.find('tbody').on('click', 'tr', function () {
            nuevo = false;
            tblControlesTerminados.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }

    function getControlesRechazados(doc, maq) {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblControlesRechazados')) {
            tblControlesRechazados.DataTable().destroy();
        }
        ControlesRechazados = tblControlesRechazados.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getControlesRechazados',
                "dataType": "json",
                "type": 'GET',
                "data": {Docto: doc, Maq: maq},
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"},
                {"data": "Control"},
                {"data": "Defecto"},
                {"data": "Detalle"},
                {"data": "Maq"},
                {"data": "Sem"},
                {"data": "Docto"},
                {"data": "Pares"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*UNIDAD*/
                            c.addClass('text-info text-strong');
                            break;
                        case 5:
                            /*PZXPAR*/
                            c.addClass('text-strong');
                            break;
                    }
                });
            },
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 20,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: true,
            "scrollX": true,
            "bSort": true,
            "aaSorting": [
                [1, 'asc']/*ID*/
            ],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        tblControlesRechazados.find('tbody').on('click', 'tr', function () {
            nuevo = false;
            tblControlesRechazados.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }

    function init() {
        nuevo = true;
        Estilo = '';
        Color = '';
        getMaquilas();
        getDefectos();
        getDetallesDefectos();
        getControlesTerminados('', '');
        getControlesRechazados('', '');
        pnlTablero.find("#Maquila")[0].selectize.focus();
    }

    function getMaquilas() {
        $.getJSON('<?php print base_url('avance_a_pespunte_x_maquila_maquilas'); ?>').done(function (x, y, z) {
            x.forEach(function (i) {
                Maquila[0].selectize.addOption({text: i.MAQUILA, value: i.CLAVE});
            });
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            swal('OPS!', 'ALGO SALIO MAL, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
        }).always(function () {

        });
    }

    function getDefectos() {
        pnlTablero.find("#Defecto")[0].selectize.clear(true);
        pnlTablero.find("#Defecto")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/InspeccionPielForro/getDefectos').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Defecto")[0].selectize.addOption({text: v.Defecto, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getDetallesDefectos() {
        pnlTablero.find("#DetalleDefecto")[0].selectize.clear(true);
        pnlTablero.find("#DetalleDefecto")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/InspeccionPielForro/getDetallesDefectos').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#DetalleDefecto")[0].selectize.addOption({text: v.DetalleDefecto, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getFolio() {
        var currentdate = new Date();
        var datetime = currentdate.getFullYear().toString().substr(-2)
                + ('0' + (currentdate.getMonth() + 1)).slice(-2)
                + ('0' + currentdate.getDate()).slice(-2)
                + ('0' + currentdate.getHours()).slice(-2)
                + ('0' + currentdate.getMinutes()).slice(-2)
                + ('0' + currentdate.getSeconds()).slice(-2);
        pnlTablero.find('#Docto').val(datetime);
    }

    function onEliminarDetalleByID(Control, Maq, Sem, Doc, Pares) {
        var defecto = pnlTablero.find('#Defecto').val();
        var detalledefecto = pnlTablero.find('#DetalleDefecto').val();
        if (defecto === '' && detalledefecto === '') {
            swal({
                title: "ATENCIÓN",
                text: "DEBES DE SELECCIONAR UN DETALLE Y UN DEFECTO",
                icon: "warning",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                if (action) {
                    pnlTablero.find('#Defecto')[0].selectize.focus();
                    HoldOn.close();
                }
            });
        } else {
            swal({
                buttons: ["Cancelar", "Aceptar"],
                title: 'Estas Seguro?',
                text: "Rechazar control: " + Control + ' de la maquila: ' + Maq,
                icon: "warning",
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then((action) => {
                if (action) {
                    $.ajax({
                        url: master_url + 'onEliminarDetalleByID',
                        type: "POST",
                        data: {
                            Control: Control,
                            Maq: Maq,
                            Sem: Sem,
                            Doc: Doc,
                            Pares: Pares,
                            Detalle: detalledefecto,
                            Defecto: defecto
                        }
                    }).done(function (data, x, jq) {
                        if (parseInt(data) > 0) {

                            //Actualizamos las tablas
                            ControlesTerminados.ajax.reload();
                            ControlesRechazados.ajax.reload();


                        } else {
                            swal({
                                title: "ATENCIÓN",
                                text: "EL CONTROL YA HA SIDO FACTURADO",
                                icon: "warning",
                                closeOnClickOutside: false,
                                closeOnEsc: false
                            });
                        }

                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    }).always(function () {
                        HoldOn.close();
                    });
                } else {
                    HoldOn.close();
                }
            });
        }

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
    td{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>
