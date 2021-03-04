<div class="card m-1 animated fadeIn" id="pnlTablero" style="border:none;">
    <div class="card-body" style="border:none;">
        <div class="row">
            <div class="col-sm-6 col-md-6 float-left">
                <legend class="float-left">Control Piochas</legend>
            </div>
            <div class="col-12 col-sm-6 col-md-6 animated bounceInLeft" align="right" id="Acciones">
                <button type="button" class="btn btn-secondary btn-sm " id="btnVerDefectos" >
                    <span class="fa fa-check-double" ></span> DEFECTOS
                </button>
                <button type="button" class="btn btn-info btn-sm " id="btnVerDetalles" >
                    <span class="fa fa-cube" ></span> DETALLES
                </button>
                <button type="button" class="btn btn-success btn-sm" id="btnImprimir" style="background-color: #4caf50; border-color: #4caf50; ">
                    <i class="fa fa-print"></i> REPORTES
                </button>
                <button type="button" class="btn btn-warning btn-sm" id="btnCalidad">
                    <i class="fa fa-check"></i> CALIDAD
                </button>
            </div>
        </div>
    </div>
    <hr>
    <div class="card-body" style="padding-top: 0px; padding-bottom: 10px;">
        <form id="frmCaptura">
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                    <label>Control</label>
                    <input type="text" id="Control" name="Control" maxlength="10" class="form-control form-control-sm numeric" required="">
                </div>
                <div class="col-12 col-xs-12 col-sm-2 col-lg-2 col-xl-2">
                    <label>Estilo</label>
                    <input type="text" id="Estilo" name="Estilo"readonly="" required="" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-xs-12 col-sm-2 col-lg-1 col-xl-1">
                    <label>Color</label>
                    <input type="text" id="Color" name="Color"readonly="" required="" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-xs-12 col-sm-2 col-lg-1 col-xl-1">
                    <label>Talla</label>
                    <input type="text" id="Talla" maxlength="4" name="Talla" required="" class="form-control form-control-sm numbersOnly">
                </div>
                <div class="col-12 col-xs-12 col-sm-3 col-lg-2 col-xl-2">
                    <label>Parte</label>
                    <select id="ParteZapato" name="ParteZapato" class="form-control form-control-sm required">
                        <option value=""></option>
                        <option value="1">1 IZQUIERDO</option>
                        <option value="2">2 DERECHO</option>
                        <option value="3">3 PAR</option>
                    </select>
                </div>
                <div class="col-12 col-xs-12 col-sm-2 col-lg-1 col-xl-1">
                    <label>Pares</label>
                    <input type="text" id="Pares" maxlength="4" name="Pares" required="" class="form-control form-control-sm numeric">
                </div>
                <div class="col-12 col-xs-12 col-sm-3 col-lg-2 col-xl-2">
                    <label>Cargo</label>
                    <select id="TipoCargo" name="TipoCargo" class="form-control form-control-sm required">
                        <option value=""></option>
                        <option value="1">1 A EMPLEADO, CÉLULA ó DEPTO</option>
                        <option value="2">2 SIN CARGO</option>
                    </select>
                </div>
                <div class="col-12 col-xs-12 col-sm-3 col-lg-2 col-xl-2">
                    <label>Departamento</label>
                    <select id="Departamento" name="Departamento" class="form-control form-control-sm required">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-12 col-xs-12 col-sm-3 col-lg-2 col-xl-2">
                    <label>Fracción</label>
                    <select id="Fraccion" name="Fraccion" class="form-control form-control-sm required">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-12 col-xs-12 col-sm-4 col-lg-3 col-xl-3">
                    <label>Empleado</label>
                    <select id="Empleado" name="Empleado" class="form-control form-control-sm required">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-12 col-xs-12 col-sm-3 col-lg-2 col-xl-2">
                    <label>Pieza</label>
                    <select id="Pieza" name="Pieza" class="form-control form-control-sm required">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-12 col-xs-12 col-sm-4 col-lg-3 col-xl-3">
                    <label>Artículo</label>
                    <input type="text" id="Material" name="Material" readonly="" required="" class="form-control form-control-sm numeric">
                </div>
                <div class="col-12 col-xs-12 col-sm-2 col-lg-1 col-xl-1">
                    <label>Consumo</label>
                    <input type="text" id="Consumo" name="Consumo" readonly="" required="" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-xs-12 col-sm-2 col-lg-1 col-xl-1">
                    <label>U.M.</label>
                    <input type="text" id="Unidad" name="Unidad" readonly="" required="" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-xs-12 col-sm-2 col-lg-1 col-xl-1">
                    <label>Total</label>
                    <input type="text" id="ConsumoTotal" name="ConsumoTotal" readonly="" required="" class="form-control form-control-sm">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-2" >
                    <label for="" >Defecto</label>
                    <select id="Defecto" name="Defecto" class="form-control form-control-sm required" >
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-2" >
                    <label for="" >Detalle</label>
                    <select id="DetalleDefecto" name="DetalleDefecto" class="form-control form-control-sm required">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3 d-sm-block pt-4">
                    <button type="button" id="btnAceptar" class="btn btn-primary btn-sm ">
                        <span class="fa fa-check"></span> ACEPTAR
                    </button>
                    <label class="badge badge-danger mb-2" style="font-size: 14px;">Nota: para dar por reparada una piocha dar click en columna de [REPARADA]</label>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-12">
                <table id="tblPiochas" class="table table-sm display" style="width:  100%;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Control</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Fec-Rep</th>
                            <th scope="col">Estilo</th>
                            <th scope="col">Color</th>
                            <th scope="col">Depto</th>
                            <th scope="col">Empleado</th>
                            <th scope="col">I-D-P</th>
                            <th scope="col">Pieza</th>
                            <th scope="col">Fraccion</th>
                            <th scope="col">Artículo</th>
                            <th scope="col">Talla</th>
                            <th scope="col">Pares</th>
                            <th scope="col">Def</th>
                            <th scope="col">Det</th>
                            <th scope="col">REPARADA</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>


    </div>
</div>


<div class="modal " id="mdlReportePiochas"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md notdraggable notresizable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-print"></span> Imprimir Reporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmParametros">
                    <div class="row">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIni" name="FechaIni" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFin" name="FechaFin" >
                        </div> 
                        <div class="col-12 col-xs-12 col-sm-12 col-lg-12 col-xl-12">
                            <label>Imprimir por: </label>
                            <select id="Tipo" name="Tipo" class="form-control form-control-sm required">
                                <option value=""></option>
                                <option value="1">1 MAQUILA</option>
                                <option value="2">2 LINEA</option>
                                <option value="3">3 ESTILO</option>
                                <option value="4">4 DEPARTAMENTO</option>
                                <option value="5">5 DEFECTO</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <p style="color: #CC0000" class="font-weight-bold font-italic">*SOLO SE MUESTRAN LOS CONTROLES CON DEFECTOS EN ALMACEN DE ADORNO*</p>
                        </div> 
                    </div> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimirReporte"><span class="fa fa-print"></span>  IMPRIMIR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal"><span class="fa fa-times"></span> SALIR</button>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/ControlPiochas/';
    var pnlTablero = $("#pnlTablero div.card-body");
    var ParteZapato = pnlTablero.find("#ParteZapato"),
            Precio = pnlTablero.find("#Precio"), Control = pnlTablero.find("#Control"),
            Docto = pnlTablero.find("#Docto"), Estilo = pnlTablero.find("#Estilo"),
            Color = pnlTablero.find("#Color"), Semana = pnlTablero.find("#Semana"),
            Pares = pnlTablero.find("#Pares"), Departamento = pnlTablero.find("#Departamento"),
            Talla = pnlTablero.find("#Talla"), Pieza = pnlTablero.find("#Pieza"),
            Material = pnlTablero.find("#Material"), Consumo = pnlTablero.find("#Consumo"),
            Unidad = pnlTablero.find("#Unidad"), ConsumoTotal = pnlTablero.find("#ConsumoTotal"),
            Piochas, tblPiochas = pnlTablero.find("#tblPiochas"),
            btnAceptar = pnlTablero.find("#btnAceptar");
    var btnVerDefectos = pnlTablero.find('#btnVerDefectos');
    var btnVerDetalles = pnlTablero.find('#btnVerDetalles');
    var btnCalidad = pnlTablero.find('#btnCalidad');
    var btnImprimir = pnlTablero.find('#btnImprimir');

    var nuevo = true;
    var serie = '', maquila = 0, material = '';

    var mdlReportePiochas = $('#mdlReportePiochas'), btnImprimirReporte = mdlReportePiochas.find("#btnImprimirReporte");

    $(document).ready(function () {

        //validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToInputOnChange('#ParteZapato', '#Pares', pnlTablero);
        setFocusSelectToSelectOnChange('#TipoCargo', '#Departamento', pnlTablero);
        setFocusSelectToSelectOnChange('#Departamento', '#Fraccion', pnlTablero);
        setFocusSelectToSelectOnChange('#Fraccion', '#Empleado', pnlTablero);
        setFocusSelectToSelectOnChange('#Empleado', '#Pieza', pnlTablero);
        //setFocusSelectToSelectOnChange('#Pieza', '#Defecto', pnlTablero);
        setFocusSelectToSelectOnChange('#Defecto', '#DetalleDefecto', pnlTablero);
        setFocusSelectToInputOnChange('#DetalleDefecto', '#btnAceptar', pnlTablero);
        init();
        handleEnter();


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
        btnCalidad.click(function () {
            $.fancybox.open({
                src: base_url + '/CalidadProduccion',
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
            var control = $(this).val();
            if ($(this).val()) {
                $.getJSON(master_url + 'getExistePiocha', {
                    Control: control
                }).done(function (data) {
                    if (data.length > 0) {
                        swal({
                            title: "ATENCIÓN",
                            text: "EL CONTROL YA HA SIDO CAPTURADO EN PIOCHAS ",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            if (action) {
                                Control.val('').focus();
                            }
                        });

                    } else {
                        $.getJSON(master_url + 'getControl', {
                            Control: control
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

                                    $.each(data[0], function (k, v) {
                                        pnlTablero.find("#" + k).val(v);
                                    });
                                    serie = data[0].Serie;
                                    maquila = data[0].Maquila;
                                    pnlTablero.find('#Talla').focus();

                                    //Nos traemos las piezas
                                    getPiezasOrdPrdByControl(control);

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
                    }

                }).done(function (data) {
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

        });
        Departamento.change(function () {
            pnlTablero.find("#Fraccion")[0].selectize.clear(true);
            pnlTablero.find("#Fraccion")[0].selectize.clearOptions();
            pnlTablero.find("#Empleado")[0].selectize.clear(true);
            pnlTablero.find("#Empleado")[0].selectize.clearOptions();
            getFraccionesXDepartamento($(this).val());
            getEmpleadosXDepartamento($(this).val());
        });
        Talla.change(function () {
            var existe = false;
            var talla = $(this).val();
            $.getJSON(master_url + 'onVeriricarTallas', {
                Serie: serie
            }).done(function (data) {
                if (data.length > 0) {

                    $.each(data[0], function (k, v) {
                        if (v === talla) {
                            existe = true;
                        }
                    });

                    if (!existe) {
                        swal({
                            title: "ERROR",
                            text: "NO EXISTE LA TALLA EN ESTA SERIE",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            if (action) {
                                Talla.val('').focus();
                            }
                        });
                    } else {
                        ParteZapato[0].selectize.focus();
                    }


                }
            });
        });
        Pieza.change(function () {
            if (ParteZapato.val()) {
                if (Pares.val()) {
                    Material.val('');
                    getArticuloConsumoUnidadByPieza($(this).val());
                } else {
                    swal({
                        title: "ERROR",
                        text: "DEBES DE CAPTURAR LOS PARES",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        if (action) {
                            Pieza[0].selectize.clear(true);
                            Pares.val('').focus();
                        }
                    });
                }
            } else {
                swal({
                    title: "ERROR",
                    text: "DEBES DE CAPTURAR SI ES UN PIÉ O EL PAR",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    if (action) {
                        Pieza[0].selectize.clear(true);
                        ParteZapato[0].selectize.focus();
                    }
                });
            }
        });
        btnAceptar.click(function () {
            onAgregar();
        });
        /*FUNCIONES X BOTON*/
        btnImprimir.click(function () {
            mdlReportePiochas.modal({backdrop: 'static', keyboard: false});
        });
        mdlReportePiochas.on('shown.bs.modal', function () {
            mdlReportePiochas.find("input").val("");
            mdlReportePiochas.find('#FechaFin').val(getToday());
            mdlReportePiochas.find('#FechaIni').val(getFirstDayMonth()).focus();
        });
        btnImprimirReporte.click(function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlReportePiochas.find("#frmParametros")[0]);

            $.ajax({
                url: master_url + 'onReportePiochas',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {

                    $.fancybox.open({
                        src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
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
                                    width: "95%",
                                    height: "95%"
                                },
                                // Iframe tag attributes
                                attr: {
                                    scrolling: "auto"
                                }
                            }
                        }
                    });


                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlReportePiochas.find('#FechaIni').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

    });

    function getArticuloConsumoUnidadByPieza(Pieza) {
        var control = Control.val();
        var pares = parseInt(Pares.val());
        var parteZap = parseInt(ParteZapato.val());
        var consumoTotal = 0;
        $.getJSON(master_url + 'getArticuloConsumoUnidadByPieza', {Pieza: Pieza, Control: control}).done(function (data, x, jq) {
            if (data.length > 0) {
                Material.val(data[0].Material);
                Unidad.val(data[0].Unidad);
                Consumo.val(data[0].Consumo);
                material = data[0].ClaveMaterial;

                //Calculo consumo total --ConsumoTotal
                if (pares > 0 && parteZap === 1 || parteZap === 2) {
                    consumoTotal = (data[0].Consumo * pares) / 2;
                    ConsumoTotal.val(consumoTotal.toFixed(3));
                } else if (pares > 0 && parteZap === 3) {
                    consumoTotal = (data[0].Consumo * pares);
                    ConsumoTotal.val(consumoTotal.toFixed(3));
                }

                pnlTablero.find("#Defecto")[0].selectize.focus();


            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getPiezasOrdPrdByControl(control) {
        pnlTablero.find("#Pieza")[0].selectize.clear(true);
        pnlTablero.find("#Pieza")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getPiezasOrdPrdByControl', {Control: control}).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Pieza")[0].selectize.addOption({text: v.Pieza, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function onAgregar() {
        isValid('pnlTablero');
        if (valido) {
            var frm = new FormData(pnlTablero.find("#frmCaptura")[0]);
            frm.append('Maquila', maquila);
            frm.append('ClaveArt', material);
            $.ajax({
                url: master_url + 'onAgregar',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                serie = '';
                maquila = '';
                material = '';

                Piochas.ajax.reload();
                pnlTablero.find("input").val('');
                $.each(pnlTablero.find("select"), function (k, v) {
                    pnlTablero.find("select")[k].selectize.clear(true);
                });
                pnlTablero.find("#Control").focus();
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        } else {
            swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
        }
    }

    function getPiochas() {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblPiochas')) {
            tblPiochas.DataTable().destroy();
        }
        Piochas = tblPiochas.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getPiochas',
                "dataType": "json",
                "type": 'GET',
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"},
                {"data": "Control"},
                {"data": "Fecha"},
                {"data": "FechaReparacion"},
                {"data": "Estilo"},
                {"data": "Color"},
                {"data": "Departamento"},
                {"data": "Empleado"},
                {"data": "ParteZapato"},
                {"data": "Pieza"},
                {"data": "Fraccion"},
                {"data": "Material"},
                {"data": "Talla"},
                {"data": "Pares"},
                {"data": "Defecto"},
                {"data": "Detalle"},
                {"data": "Eliminar"}
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
                        case 10:
                            /*PZXPAR*/
                            c.addClass('text-strong');
                            break;
                        case 15:
                            /*ELIMINAR*/
                            c.addClass('text-strong text-warning');
                            break;
                    }
                });
            },
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 20,
            "scrollX": false,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: true,
            "bSort": true,
            "aaSorting": [
                [1, 'asc']/*ID*/
            ],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        tblPiochas.find('tbody').on('click', 'tr', function () {
            tblPiochas.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }

    function init() {
        nuevo = true;
        getDefectos();
        getDetallesDefectos();
        getDepartamentos();
        getPiochas();
        pnlTablero.find("#Control").focus();
        serie = '';
        maquila = '';
        material = '';
    }

    function getEmpleadosXDepartamento(Departamento) {
        if (Departamento !== '' && Departamento !== undefined && Departamento !== null) {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            $.getJSON('<?php print base_url('ControlPiochas/getEmpleadosXDepartamento'); ?>', {Departamento: Departamento}).done(function (data, x, jq) {
                $.each(data, function (k, v) {
                    pnlTablero.find("#Empleado")[0].selectize.addOption({text: v.Empleado, value: v.ID});
                });
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            }).always(function () {
                HoldOn.close();
            });
        }
    }

    function getFraccionesXDepartamento(Departamento) {
        if (Departamento !== '' && Departamento !== undefined && Departamento !== null) {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            $.getJSON(master_url + 'getFraccionesXDepartamento', {Departamento: Departamento}).done(function (data, x, jq) {
                $.each(data, function (k, v) {
                    pnlTablero.find("#Fraccion")[0].selectize.addOption({text: v.Fraccion, value: v.ID});
                });
                pnlTablero.find("#Fraccion")[0].selectize.focus();
                pnlTablero.find("#Fraccion")[0].selectize.open();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            }).always(function () {
                HoldOn.close();
            });
        }
    }

    function getDepartamentos() {
        pnlTablero.find("#Departamento")[0].selectize.clear(true);
        pnlTablero.find("#Departamento")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getDepartamentos').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Departamento")[0].selectize.addOption({text: v.Departamento, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
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

    function onEliminarDetalleByID(Control) {

        swal({
            buttons: ["Cancelar", "Aceptar"],
            title: 'Estas Seguro?',
            text: "Desea dar por reparada esta piocha? \nControl: " + Control,
            icon: "warning",
            closeOnEsc: false,
            closeOnClickOutside: false
        }).then((action) => {
            if (action) {
                $.ajax({
                    url: master_url + 'onEliminarDetalleByID',
                    type: "POST",
                    data: {
                        Control: Control
                    }
                }).done(function (data, x, jq) {
                    if (parseInt(data) > 0) {
                        //Actualizamos las tablas
                        Piochas.ajax.reload();
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "ESTA PIOCHA NO PUEDE SER ELIMINADA PORQUE YA ESTÁ TERMINADA",
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

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>

