<?php
//var_dump($this->session->TipoAcceso);
?>
<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-4 float-left">
                <legend class="float-left">Captura controles para maquilar</legend>
            </div>
            <div class="col-sm-1">
                <label class="text-danger font-weight-bold">Re-Imprime</label>
            </div>
            <div class="col-sm-1">
                <input type="text" id="Reimprime" name="Reimprime" class="form-control form-control-sm numbersOnly" maxlength="6">
            </div>
            <div class="col-6" align="right">
                <button type="button" id="btnAvance" name="btnAvance" class="btn btn-warning btn-sm " >
                    <span class="fa fa-arrow-right"></span>
                    Avance
                </button>
                <button type="button" id="btnRetorna" name="btnRetorna" class="btn btn-indigo btn-sm " >
                    <span class="fa fa-retweet"></span>
                    Retorno plantilla
                </button>
                <button type="button" id="btnConceptosPlantilla" name="btnConceptosPlantilla" class="btn btn-green btn-sm mx-2 " >
                    <span class="fa fa-bullseye"></span>
                    Conceptos plantilla
                </button>
                <button type="button" id="btnReportePago" name="btnReportePago" class="btn btn-red btn-sm ">
                    <span class="fa fa-exclamation"></span>
                    Reporte pago
                </button>
                <button type="button" id="btnCapturaPorcentajes" name="btnCapturaPorcentajes" class="btn btn-info btn-sm ">
                    <span class="fa fa-dollar-sign"></span>
                    Porcentaje Extra X Fracción
                </button>
            </div>
        </div>
        <hr>
        <div class="row" id = "pnlCaptura">
            <div class="col-12 col-sm-1 col-md-2 col-lg-1 col-xl-1" >
                <label for="" >Proveedor</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="6" required=""  id="Proveedor" name="Proveedor"   >
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-3">
                <label>-</label>
                <select id="sProveedor" name="sProveedor" class="form-control form-control-sm required NotSelectize" ></select>
            </div>
            <div class="col-12 col-sm-1 col-md-2 col-lg-1 col-xl-1" >
                <label for="" >Tipo Maq</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" required=""  id="TipoMaquila" name="TipoMaquila"   >
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-3">
                <label>-</label>
                <select id="sTipoMaquila" name="sTipoMaquila" class="form-control form-control-sm required NotSelectize"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-1">
                <label>Documento</label>
                <input type="text" id="Documento" name="Documento" class="form-control form-control-sm" readonly="" >
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
            <div class="w-100"></div>
            <div class="col-12 col-sm-1 col-md-2 col-lg-1 col-xl-1" >
                <label for="" >Fracción</label>
                <input type="text" class="form-control form-control-sm numbersOnly NotSelectize" maxlength="4" required=""  id="Fraccion" name="Fraccion"   >
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-3">
                <label>-</label>
                <select  id="sFraccion" name="sFraccion" class="form-control form-control-sm required"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-1">
                <label>Precio</label>
                <input type="text" id="Precio" name="Precio" class="form-control form-control-sm numbersOnly" required="">
            </div>


            <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 mt-4">
                <button type="button" class="btn btn-primary btn-sm" id="btnAcepta" disabled=""><span class="fa fa-check"></span> ACEPTA </button>
                <button type="button" class="btn btn-success btn-sm" id="btnImprime" disabled=""><span class="fa fa-print"></span> IMPRIMIR </button>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card-block mt-4">
                    <div id="ControlPlantilla" class="table-responsive">
                        <table id="tblControlPlantilla" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Docto</th>
                                    <th>Proveedor</th>
                                    <th>Fecha</th>
                                    <th>Control</th>
                                    <th>Estilo</th>
                                    <th>Pares</th>
                                    <th>Fracc</th>
                                    <th>Precio</th>
                                    <th class="d-none">-</th>
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
<div class="modal" id="mdlRetorno">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content  modal-lg">
            <div class="modal-header">
                <h5 class="modal-title">Retorno de plantilla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3">
                        <label>Documento</label>
                        <input type="text" id="DocumentoRetorno" name="DocumentoRetorno" maxlength="4" class="form-control form-control-sm numeric">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3">
                        <label>Fecha Entrega</label>
                        <input type="text" id="FechaVale" name="FechaVale" class="form-control form-control-sm" readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3">
                        <label>Control</label>
                        <input type="text" id="ControlRetorno" name="ControlRetorno" class="form-control form-control-sm numbersOnly" required="">
                    </div>

                    <div class="col-12 col-sm-3">
                        <div class="custom-control custom-checkbox  ">
                            <input type="checkbox" class="custom-control-input" id="chPorNominaRetorno">
                            <label class="custom-control-label text-info labelCheck" for="chPorNominaRetorno">Es por Nómina?</label>
                        </div>
                    </div>

                    <div class="col-6">
                    </div>
                    <div class="col-6 mt-2" align='right'>
                        <button type="button" class="btn btn-info" id="btnAceptaRetorno"><span class="fa fa-check"></span> Aceptar</button>
                        <button type="button" class="btn btn-success" id="btnImprimirRetorno"><span class="fa fa-print"></span> Imprimir</button>
                    </div>
                </div>
                <br>
                <div class="w-100"></div>
                <table class="table table-hover table-sm" id="tblRetornaDocumento"  style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">TP</th>
                            <th scope="col">Docto</th>
                            <th scope="col">Proveedor</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Llegada</th>
                            <th scope="col">Control</th>
                            <th scope="col">Estilo</th>
                            <th scope="col">-</th>
                            <th scope="col">Pares</th>
                            <th scope="col" class="d-none">-</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="mdlReportePago">
    <div class="modal-dialog  modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-print"></span> Maquila x fecha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>De la fecha</label>
                        <input type="text" id="DeLaFecha" name="DeLaFecha" class="form-control date notEnter">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>A la fecha</label>
                        <input type="text" id="ALaFecha" name="ALaFecha" class="form-control date notEnter">
                    </div>
                    <div class="col-12">
                        <br>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="chkRecibido">
                            <label class="custom-control-label" for="chkRecibido">Lo recibido</label>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="chkSinRecibir">
                            <label class="custom-control-label" for="chkSinRecibir">Sin recibir</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="btnAceptaReportePago"><span class="fa fa-print"></span> Acepta</button>
            </div>
        </div>
    </div>
</div>
<!--MODA PARA CAPTURA DE PORCENTAJE X FRACCIONES SOLO LUCY Y YO-->
<div class="modal" id="mdlCapturaPorcentaje">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content  modal-lg">
            <div class="modal-header">
                <h5 class="modal-title">Captura porcentaje extra para maquilas X fracción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3">
                        <label>Fracción</label>
                    </div>
                    <div class="col-8">
                        <label>Porcentaje <span class="badge badge-danger" style="font-size: 14px;"> Ej. Si es 5% capture 0.05</span></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <input type="text" id="FraccionPor" name="FraccionPor" class="form-control form-control-sm numbersOnly" maxlength="3">
                    </div>
                    <div class="col-3">
                        <input type="text" id="PorcenXFraccion" name="PorcenXFraccion" class="form-control form-control-sm numbersOnly" maxlength="5">
                    </div>
                </div>
                <br>
                <div class="w-100"></div>
                <table class="table table-hover table-sm" id="tblPorcentajes"  style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col" class="d-none">ID</th>
                            <th scope="col">Fracción</th>
                            <th scope="col">Porcentaje</th>
                            <th scope="col">Elimina</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary notEnter selectNotEnter" id="btnAceptaPorcentajeFraccion"><span class="fa fa-check"></span> ACEPTAR</button>
                <button type="button" class="btn btn-secondary " id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>

<script>
    var pnlTablero = $("#pnlTablero"), pnlCaptura = $("#pnlCaptura"),
            ControlPlantilla, tblControlPlantilla = pnlTablero.find("#tblControlPlantilla"),
            sProveedor = pnlTablero.find("#sProveedor"),
            Proveedor = pnlTablero.find("#Proveedor"),
            TipoMaquila = pnlTablero.find("#TipoMaquila"),
            sTipoMaquila = pnlTablero.find("#sTipoMaquila"),
            Control = pnlTablero.find("#Control"), Documento = pnlTablero.find("#Documento"),
            Estilo = pnlTablero.find("#Estilo"), Color = pnlTablero.find("#Color"),
            Pares = pnlTablero.find("#Pares"),
            Fraccion = pnlTablero.find("#Fraccion"),
            sFraccion = pnlTablero.find("#sFraccion"),
            Precio = pnlTablero.find("#Precio"), Fecha = pnlTablero.find("#Fecha"),
            Reimprime = pnlTablero.find("#Reimprime"), btnAcepta = pnlTablero.find("#btnAcepta"),
            btnAvance = pnlTablero.find("#btnAvance"),
            btnImprime = pnlTablero.find("#btnImprime"), mdlRetorno = $("#mdlRetorno"),
            btnRetorna = pnlTablero.find("#btnRetorna"), DocumentoRetorno = mdlRetorno.find("#DocumentoRetorno"),
            FechaVale = mdlRetorno.find("#FechaVale"), RetornaDocumento, tblRetornaDocumento = mdlRetorno.find("#tblRetornaDocumento"),
            btnConceptosPlantilla = pnlTablero.find("#btnConceptosPlantilla"),
            btnAceptaRetorno = mdlRetorno.find("#btnAceptaRetorno"), mdlReportePago = $("#mdlReportePago"),
            btnImprimirRetorno = mdlRetorno.find("#btnImprimirRetorno"),
            btnCapturaPorcentajes = pnlTablero.find("#btnCapturaPorcentajes"),
            ControlRetorno = mdlRetorno.find("#ControlRetorno"),
            mdlCapturaPorcentaje = $("#mdlCapturaPorcentaje"),
            btnAceptaPorcentajeFraccion = mdlCapturaPorcentaje.find("#btnAceptaPorcentajeFraccion"),
            Porcentajes, tblPorcentajes = mdlCapturaPorcentaje.find("#tblPorcentajes"),
            btnAceptaReportePago = mdlReportePago.find("#btnAceptaReportePago"),
            btnReportePago = pnlTablero.find("#btnReportePago");

    var FechaActual = '<?php print Date('d/m/Y'); ?>';
    var nuevo;

    $(document).ready(function () {
        nuevo = true;
        handleEnterDiv(pnlCaptura);
        handleEnterDiv(mdlReportePago);
        pnlTablero.find('select').selectize({
            openOnFocus: false
        });
        Proveedor.focus();
        getProveedores();
        getMaquilasPlantillas();
        getRecords();


        Proveedor.on('keydown', function (e) {
            if (e.keyCode === 13) {
                var txtprov = $(this).val();
                if (txtprov) {
                    $.getJSON('<?php print base_url('ControlPlantilla/onVerificarProveedor'); ?>', {Proveedor: txtprov}).done(function (data) {
                        if (data.length > 0) {
                            sProveedor[0].selectize.addItem(txtprov, true);
                            TipoMaquila.focus().select();
                        } else {
                            swal('ERROR', 'EL PROVEEDOR CAPTURADO NO EXISTE', 'warning').then((value) => {
                                sProveedor[0].selectize.clear(true);
                                Proveedor.focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });

        sProveedor.change(function () {
            if ($(this).val()) {
                Proveedor.val($(this).val());
                TipoMaquila.focus().select();
            }
        });

        TipoMaquila.on('keydown', function (e) {
            if (e.keyCode === 13) {
                var txtMP = $(this).val();
                if (txtMP) {
                    $.getJSON('<?php print base_url('ControlPlantilla/onVerificarPlantilla'); ?>', {Maquila: txtMP}).done(function (data) {
                        if (data.length > 0) {
                            sTipoMaquila[0].selectize.addItem(txtMP, true);
                            Control.focus().select();
                        } else {
                            swal('ERROR', 'LA MAQUILA/PLANTILLA NO EXISTE', 'warning').then((value) => {
                                sTipoMaquila[0].selectize.clear(true);
                                TipoMaquila.focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });

        sTipoMaquila.change(function () {
            if ($(this).val()) {
                TipoMaquila.val($(this).val());
                Control.focus().select();
            }
        });

        btnAceptaReportePago.click(function () {
            getReport(1);
        });

        mdlReportePago.on('shown.bs.modal', function () {
            mdlReportePago.find("input").val('');
            mdlReportePago.find("#chkSinRecibir")[0].checked = false;
            mdlReportePago.find("#chkRecibido")[0].checked = false;
            mdlReportePago.find("#DeLaFecha").val(getToday());
            mdlReportePago.find("#ALaFecha").val(getToday());
            mdlReportePago.find("#DeLaFecha").focus();
        });

        mdlReportePago.find("#chkRecibido").change(function () {
            mdlReportePago.find("#chkSinRecibir")[0].checked = false;
        });

        mdlReportePago.find("#chkSinRecibir").change(function () {
            mdlReportePago.find("#chkRecibido")[0].checked = false;
        });

        btnReportePago.click(function () {
            mdlReportePago.modal('show');
        });

        DocumentoRetorno.on('keypress', function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    /*1.- COMPROBAR SI EXISTE ESE DOCUMENTO Y ESTA ACTIVO*/
                    $.getJSON('<?php print base_url('ControlPlantilla/onComprobarEstatusDocumento'); ?>', {
                        DOCTO: DocumentoRetorno.val()
                    }).done(function (a) {
                        console.log(a);
                        if (a.length > 0) {
                            var r = a[0];
                            if (parseInt(r.VALIDO) > 0) {
                                getDocsRetorno();
                                ControlRetorno.val('').focus();
                            } else {
                                swwt('ESTE DOCUMENTO NO EXISTE O YA FUE ENTREGADO', function () {
                                    DocumentoRetorno.val().focus().select();
                                });
                            }
                        }
                    }).fail(function (x) {
                        getError(x);
                    })
                }
            }
        });

        ControlRetorno.on('keypress', function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    /*1.- COMPROBAR SI EXISTE ESE DOCUMENTO Y ESTA ACTIVO*/
                    $.getJSON('<?php print base_url('ControlPlantilla/onComprobarControlDocumento'); ?>', {
                        DOCTO: DocumentoRetorno.val(),
                        Control: ControlRetorno.val()
                    }).done(function (a) {
                        console.log(a);
                        if (a.length > 0) {
                            btnAceptaRetorno.focus();
                        } else {
                            swwt('ESTE CONTROL NO EXISTE EN ESTE DOCUMENTO', function () {
                                ControlRetorno.val().focus().select();
                            });
                        }
                    }).fail(function (x) {
                        getError(x);
                    })
                }
            }
        });

        btnImprimirRetorno.click(function () {
            onOpenOverlay('Generando Reporte...');
            onDisable(btnImprimirRetorno);
            if (DocumentoRetorno.val()) {
                $.post('<?php print base_url('ControlPlantilla/onImprimirRetornoParcial'); ?>', {Docto: DocumentoRetorno.val(), FECHA: FechaVale.val()}).done(function (data) {
                    console.log(data);
                    if (data.length > 0) {//Si es de empleado imprime el reporte de su pago
                        onImprimirReporteFancyAFC(data, function (a, b) {
                            onCloseOverlay();
                        });
                    }
                }).fail(function (x) {
                    onEnable(btnAceptaRetorno);
                    getError(x);
                });
            } else {
                swwt('DEBE DE ESPECIFICAR UN DOCUMENTO', function () {
                    onEnable(btnImprimirRetorno);
                    DocumentoRetorno.focus().select();
                });
            }
        });

        btnAceptaRetorno.click(function () {
            onDisable(btnAceptaRetorno);
            var esNomina = mdlRetorno.find("#chPorNominaRetorno")[0].checked ? '1' : '0';
            if (DocumentoRetorno.val()) {
                /*1.- COMPROBAR SI EXISTE ESE DOCUMENTO Y ESTA ACTIVO*/
                $.getJSON('<?php print base_url('ControlPlantilla/onComprobarEstatusDocumento'); ?>', {
                    DOCTO: DocumentoRetorno.val()
                }).done(function (a) {
                    console.log(a);
                    if (a.length > 0) {
                        var r = a[0];
                        if (parseInt(r.VALIDO) > 0) {
                            $.post('<?php print base_url('ControlPlantilla/onRetornaDocumento'); ?>',
                                    {
                                        Docto: DocumentoRetorno.val(),
                                        FECHA: FechaVale.val(),
                                        Control: ControlRetorno.val(),
                                        EsNomina: esNomina
                                    }).done(function (data) {
                                console.log(data);
                                onEnable(btnAceptaRetorno);
                                ControlRetorno.val('').focus();
                                RetornaDocumento.ajax.reload();
                            }).fail(function (x) {
                                onEnable(btnAceptaRetorno);
                                getError(x);
                            });
                        } else {
                            swwt('ESTE DOCUMENTO NO ES VÁLIDO O YA FUE ENTREGADO', function () {
                                onEnable(btnAceptaRetorno);
                                DocumentoRetorno.focus().select();
                            });
                        }
                    }
                }).fail(function (x) {
                    onEnable(btnAceptaRetorno);
                    getError(x);
                });
                /*2.- EN CASO DE QUE ESTE ACTIVO CAMBIARLO A ESTATUS DOS(2)*/

            } else {
                swwt('DEBE DE ESPECIFICAR UN DOCUMENTO', function () {
                    onEnable(btnAceptaRetorno);
                    DocumentoRetorno.focus().select();
                });
            }
        });

        btnConceptosPlantilla.click(function () {
            $.fancybox.open({
                src: '<?= base_url('MaqPlantillas/?TIPO=1'); ?>',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
                        console.info('done!');
                    },
                    afterClose: function (instance, current) {
                        getMaquilasPlantillas();
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

        mdlRetorno.on('shown.bs.modal', function () {
            DocumentoRetorno.val('');
            getDocsRetorno();
            DocumentoRetorno.focus();
        });

        btnRetorna.click(function () {
            mdlRetorno.modal('show');
            DocumentoRetorno.focus();
            FechaVale.val(FechaActual);
        });

        /*CAPTURA PORCENTAJES */
        btnCapturaPorcentajes.click(function () {
            if (usuario === 'LUCY' || usuario === 'CMEDINA') {
                mdlCapturaPorcentaje.modal('show');
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "USUARIO NO AUTORIZADO PARA ESTE MÓDULO ",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    if (action) {
                    }
                });
            }

        });

        mdlCapturaPorcentaje.on('shown.bs.modal', function () {
            getPorcentajes();
            mdlCapturaPorcentaje.find("input").val('');
            mdlCapturaPorcentaje.find("#FraccionPor").focus();
        });

        mdlCapturaPorcentaje.find('#FraccionPor').on('keypress', function (e) {
            if (e.keyCode === 13) {
                var fra = $(this).val();
                if (fra) {
                    $.getJSON('<?php print base_url('ControlPlantilla/onVerificarFraccionExiste'); ?>', {
                        Fraccion: fra
                    }).done(function (a) {
                        if (a.length > 0) {
                            mdlCapturaPorcentaje.find('#PorcenXFraccion').focus().select();
                        } else {
                            swal('ERROR', 'LA FRACCIÓN ' + fra + ' NO EXISTE', 'warning').then((value) => {
                                mdlCapturaPorcentaje.find('#FraccionPor').val('').focus().select();
                            });
                        }
                    }).fail(function (x, y, z) {
                        getError(x);
                    });
                }
            }
        });
        mdlCapturaPorcentaje.find('#PorcenXFraccion').on('keypress', function (e) {
            if (e.keyCode === 13) {
                var porce = $(this).val();
                if (porce) {
                    btnAceptaPorcentajeFraccion.focus();
                }
            }
        });

        btnAceptaPorcentajeFraccion.click(function () {
            $.post('<?php print base_url('ControlPlantilla/onGuardarPorcentaje'); ?>', {
                Fraccion: mdlCapturaPorcentaje.find('#FraccionPor').val(),
                Porcentaje: mdlCapturaPorcentaje.find('#PorcenXFraccion').val()
            }).done(function () {
                Porcentajes.ajax.reload();
                Porcentajes.columns.adjust().draw();
                mdlCapturaPorcentaje.find("input").val('');
                mdlCapturaPorcentaje.find("#FraccionPor").focus();
            }).fail(function (x) {
                getError(x);
            });
        });

        btnAcepta.click(function () {
            isValid('pnlTablero');
            if (valido) {
                $.post('<?php print base_url('ControlPlantilla/onGuardar'); ?>', {
                    DOCUMENTO: (nuevo) ? '0' : Documento.val(),
                    PROVEEDOR: Proveedor.val(),
                    PROVEEDORT: sProveedor.find("option:selected").text(),
                    TIPO: TipoMaquila.val(),
                    CONTROL: Control.val(),
                    ESTILO: Estilo.val(),
                    COLOR: color,
                    COLORT: nomcolor,
                    PARES: Pares.val(),
                    FRACCION: Fraccion.val(),
                    FRACCIONT: sFraccion.find("option:selected").text(),
                    PRECIO: Precio.val(),
                    FECHA: Fecha.val()
                }).done(function (data) {

                    if (nuevo) {
                        Documento.val(data);
                        nuevo = false;
                    }
                    ControlPlantilla.ajax.reload();
                    Fraccion.val('');
                    sFraccion[0].selectize.clear(true);
                    sFraccion[0].selectize.clearOptions();
                    Precio.val('');
                    Estilo.val('');
                    Color.val('');
                    Pares.val('');
                    color = 0;
                    nomcolor = 0;
                    btnImprime.attr('disabled', false);
                    btnAcepta.attr('disabled', true);
                    Control.val('').focus();
                }).fail(function (x) {
                    getError(x);
                });



            } else {
                onNotify('<span class="fa fa-times fa-lg"></span>', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'danger');
            }
        });


        btnImprime.click(function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            btnImprime.attr('disabled', true);
            $.post('<?php print base_url('ControlPlantilla/onImprimir'); ?>', {
                DOCUMENTO: Documento.val()
            }).done(function (data) {
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function (a, b) {
                        nuevo = true;
                        Documento.val('');
                        Proveedor.val('');
                        sProveedor[0].selectize.clear(true);
                        TipoMaquila.val('');
                        sTipoMaquila[0].selectize.clear(true);
                        Fraccion.val('');
                        sFraccion[0].selectize.clear(true);
                        sFraccion[0].selectize.clearOptions();
                        Precio.val('');
                        Estilo.val('');
                        Color.val('');
                        Pares.val('');
                        color = 0;
                        nomcolor = 0;
                        btnAcepta.attr('disabled', true);
                        ControlPlantilla.ajax.reload();
                        HoldOn.close();
                        Proveedor.focus();
                    });
                }
            }).fail(function (x) {
                getError(x);
            });
        });

        Fecha.val('<?php print Date('d/m/Y') ?>');

        var handler = function (e) {
            if (e.keyCode === 13) {
                if (Reimprime.val()) {
                    Reimprime.off("keypress");
                    HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                    $.post('<?php print base_url('ControlPlantilla/onImprimir'); ?>', {
                        DOCUMENTO: Reimprime.val()
                    }).done(function (data) {
                        if (data.length > 0) {
                            onImprimirReporteFancyAFC(data, function (a, b) {
                                HoldOn.close();
                                Reimprime.on('keypress', handler);
                                Reimprime.focus().select();
                            });
                        }
                    }).fail(function (x) {
                        getError(x);
                    });
                } else {
                    swal('ERROR', 'CAPTURE EL DOCUMENTO', 'warning').then((value) => {
                        Reimprime.focus().select();
                        return;
                    });
                }
            }
        };

        Reimprime.on('keypress', handler);

        Control.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    getInfoXControl();
                }
            }
        });

        Fraccion.on('keydown', function (e) {
            if (e.keyCode === 13) {
                var txtfr = $(this).val();
                if (txtfr) {
                    if (usuario === 'JULIANNA') {

                        switch (parseInt(txtfr)) {
                            case 69:

                            case 77:

                            case 83:
                                onCapturarFraccion();
                                break;
                            default:
                                swal('ERROR', 'FRACCIÓN NO PERMITIDA PARA ESTE USUARIO', 'warning').then((value) => {
                                    sFraccion[0].selectize.clear(true);
                                    Precio.val('');
                                    btnAcepta.attr('disabled', true);
                                    Fraccion.val('');
                                    Fraccion.val('').focus();
                                    return;
                                });
                                break;
                        }
                    } else {
                        //Para todos los demás
                        onCapturarFraccion();
                    }
                }
            }
        });

        sFraccion.change(function () {
            var txtfr = $(this).val();
            if (txtfr) {
                Fraccion.val(sFraccion.val());

                if (usuario === 'JULIANNA') {

                    switch (parseInt(txtfr)) {
                        case 69:

                        case 77:

                        case 83:
                            onCapturarFraccionSelect();
                            break;
                        default:
                            swal('ERROR', 'FRACCIÓN NO PERMITIDA PARA ESTE USUARIO', 'warning').then((value) => {
                                sFraccion[0].selectize.clear(true);
                                Precio.val('');
                                btnAcepta.attr('disabled', true);
                                Fraccion.val('');
                                Fraccion.val('').focus();
                                return;
                            });
                            break;
                    }
                } else {
                    //Para todos los demás
                    onCapturarFraccionSelect();
                }

            }


        });
    });

    function onCapturarFraccion() {

        $.get('<?php print base_url('ControlPlantilla/onVerificaFraccionControlFraccionCobrada'); ?>', {
            ESTILO: Estilo.val(),
            FRACCION: Fraccion.val(),
            CONTROL: Control.val()
        }).done(function (data) {
            console.log(data);
            if (data === '0') {//No existe fracción en fracciones por estilo
                swal('ERROR', 'LA FRACCIÓN NO EXISTE EN ESTE ESTILO', 'warning').then((value) => {
                    sFraccion[0].selectize.clear(true);
                    Precio.val('');
                    btnAcepta.attr('disabled', true);
                    Fraccion.val('');
                    Fraccion.val('').focus();
                    return;
                });
            } else if (data === '88') {
                swal('ERROR', 'EL CONTROL/FRACCIÓN YA HA SIDO ENVIADO A MAQUILAR', 'warning').then((value) => {
                    sFraccion[0].selectize.clear(true);
                    Precio.val('');
                    btnAcepta.attr('disabled', true);
                    Fraccion.val('').focus();
                    return;
                });
            } else if (data === '99') {
                swal('ERROR', 'EL CONTROL/FRACCIÓN YA HA SIDO REPORTADO EN NÓMINA', 'warning').then((value) => {
                    sFraccion[0].selectize.clear(true);
                    Precio.val('');
                    btnAcepta.attr('disabled', true);
                    Fraccion.val('').focus();
                    return;
                });
            } else if (data === '77') {
                swal('ERROR', 'EL CONTROL DEBE DE ESTAR EN ENSUELADO PARA CONTINUAR', 'warning').then((value) => {
                    sFraccion[0].selectize.clear(true);
                    Precio.val('');
                    btnAcepta.attr('disabled', true);
                    Fraccion.val('').focus();
                    return;
                });
            } else {
                Precio.val(data);
                Fecha.val(FechaActual);
                sFraccion[0].selectize.addItem(Fraccion.val(), true);
                btnAcepta.attr('disabled', false);
                btnAcepta.focus();
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onCapturarFraccionSelect() {
        $.get('<?php print base_url('ControlPlantilla/onVerificaFraccionControlFraccionCobrada'); ?>', {
            ESTILO: Estilo.val(),
            FRACCION: Fraccion.val(),
            CONTROL: Control.val()
        }).done(function (data) {
            console.log(data);
            if (data === '0') {//No existe fracción en fracciones por estilo
                swal('ERROR', 'LA FRACCIÓN NO EXISTE EN ESTE ESTILO', 'warning').then((value) => {
                    sFraccion[0].selectize.clear(true);
                    Precio.val('');
                    btnAcepta.attr('disabled', true);
                    Fraccion.val('');
                    Fraccion.val('').focus();
                    return;
                });
            } else if (data === '88') {
                swal('ERROR', 'EL CONTROL/FRACCIÓN YA HA SIDO ENVIADO A MAQUILAR', 'warning').then((value) => {
                    sFraccion[0].selectize.clear(true);
                    Precio.val('');
                    btnAcepta.attr('disabled', true);
                    Fraccion.val('').focus();
                    return;
                });
            } else if (data === '99') {
                swal('ERROR', 'EL CONTROL/FRACCIÓN YA HA SIDO REPORTADO EN NÓMINA', 'warning').then((value) => {
                    sFraccion[0].selectize.clear(true);
                    Precio.val('');
                    btnAcepta.attr('disabled', true);
                    Fraccion.val('').focus();
                    return;
                });
            } else if (data === '77') {
                swal('ERROR', 'EL CONTROL DEBE DE ESTAR EN ENSUELADO PARA CONTINUAR', 'warning').then((value) => {
                    sFraccion[0].selectize.clear(true);
                    Precio.val('');
                    btnAcepta.attr('disabled', true);
                    Fraccion.val('').focus();
                    return;
                });
            } else {
                Precio.val(data);
                Fecha.val(FechaActual);
                btnAcepta.attr('disabled', false);
                btnAcepta.focus();
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });

    }

    function getPorcentajes() {
        if (!$.fn.DataTable.isDataTable('#tblPorcentajes')) {
            var cols = [
                {"data": "ID"}/*0*/,
                {"data": "FRACCION"}/*1*/,
                {"data": "PORCENTAJE"}/*2*/,
                {"data": "BTN"}/*9*/
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
                    "url": '<?php print base_url('ControlPlantilla/getPorcentajes'); ?>',
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
                "scrollY": "300px",
                "scrollX": true,
                "aaSorting": [
                    [1, 'asc']
                ]
            };
            Porcentajes = tblPorcentajes.DataTable(xoptions);
        } else {
            Porcentajes.ajax.reload();
            Porcentajes.columns.adjust().draw();
        }
    }

    function getDocsRetorno() {
        if (!$.fn.DataTable.isDataTable('#tblRetornaDocumento')) {
            var cols = [
                {"data": "ID"}/*0*/,
                {"data": "ESTATUS"}/*1*/,
                {"data": "DOCUMENTO"}/*2*/,
                {"data": "PROVEEDOR"}/*2*/,
                {"data": "FECHA"}/*3*/,
                {"data": "FECHA_RETORNA"}/*3*/,
                {"data": "CONTROL"}/*4*/,
                {"data": "ESTILO"}/*6*/,
                {"data": "COLOR"}/*7*/,
                {"data": "PARES"}/*9*/,
                {"data": "BTN"}/*9*/
            ];
            var coldefs = [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [10],
                    "visible": false,
                    "searchable": false
                }
            ];
            var xoptions = {
                "dom": 'rt',
                "ajax": {
                    "url": '<?php print base_url('ControlPlantilla/getEntregados'); ?>',
                    "dataSrc": "",
                    "data": function (d) {
                        d.DOCUMENTO = DocumentoRetorno.val() ? DocumentoRetorno.val() : '';
                    }
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
                "scrollY": "300px",
                "scrollX": true,
                "createdRow": function (row, data, index) {
                    $.each($(row).find("td"), function (k, v) {
                        var c = $(v);
                        var index = parseInt(k);
                        switch (index) {
                            case 4:
                                /*fecha conf*/
                                c.addClass('text-danger text-strong');
                                break;
                        }
                    });
                },
                "aaSorting": [
                    [6, 'asc']
                ]
            };
            RetornaDocumento = tblRetornaDocumento.DataTable(xoptions);
        } else {
            RetornaDocumento.ajax.reload();
            RetornaDocumento.columns.adjust().draw();
        }
    }

    function getReport(pdfxls) {

        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        var f = new FormData();
        f.append('FECHAINICIAL', mdlReportePago.find("#DeLaFecha").val());
        f.append('FECHAFINAL', mdlReportePago.find("#ALaFecha").val());
        var sts = 0;
        if (mdlReportePago.find("#chkSinRecibir")[0].checked) {
            sts = 1;
        } else if (mdlReportePago.find("#chkRecibido")[0].checked) {
            sts = 2;
        }
        f.append('STS', sts);
        f.append('TDOC', pdfxls);
        $.ajax({
            url: '<?php print base_url('ControlPlantilla/getReporteDePago'); ?>',
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: f
        }).done(function (data, x, jq) {
            console.log(data);
            var ext = getExt(data);
            if (data.length > 0) {
                if (ext === "pdf" || ext === "PDF" || ext === "Pdf") {
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
                } else if (ext === "xls" || ext === "XLS" || ext === "Xls") {
                    window.open(data, '_blank');
                }
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "NO EXISTEN DOCUMENTOS",
                    icon: "error"
                }).then((action) => {

                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }

    function getRecords() {

        var cols = [
            {"data": "ID"}/*0*/,
            {"data": "DOCUMENTO"}/*1*/,
            {"data": "PROVEEDOR"}/*2*/,
            {"data": "FECHA"}/*3*/,
            {"data": "CONTROL"}/*4*/,
            {"data": "ESTILO"}/*6*/,
            {"data": "PARES"}/*9*/,
            {"data": "FRACCION"}/*7*/,
            {"data": "PRECIO"}/*8*/,
            {"data": "BTN"}/*9*/
        ];
        var coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [9],
                "visible": false,
                "searchable": false
            }
        ];
        var xoptions = {
            "dom": 'rt',
            "ajax": {
                "url": '<?php print base_url('ControlPlantilla/getRecords'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.DOCUMENTO = Documento.val() ? Documento.val() : '';
                }

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
        ControlPlantilla = tblControlPlantilla.DataTable(xoptions);

    }

    function getProveedores() {
        $.getJSON('<?php print base_url('ControlPlantilla/getProveedoresMaquilas'); ?>').done(function (a) {
            a.forEach(function (e) {
                sProveedor[0].selectize.addOption({text: e.PROVEEDOR, value: e.ID});
            });
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {

        });
    }

    function getMaquilasPlantillas() {
        sTipoMaquila[0].selectize.clear(true);
        sTipoMaquila[0].selectize.clearOptions();
        $.getJSON('<?php print base_url('ControlPlantilla/getMaquilasPlantillas'); ?>').done(function (a) {
            a.forEach(function (e) {
                sTipoMaquila[0].selectize.addOption({text: e.MAQPLA, value: e.ID});
            });
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {

        });
    }
    var color, nomcolor;
    function getInfoXControl() {
        $.getJSON('<?php print base_url('ControlPlantilla/getInfoXControl'); ?>', {
            CONTROL: Control.val()
        }).done(function (a) {
            if (a.length > 0) {
                var r = a[0];
                if ('<?php print $this->session->TipoAcceso; ?>' !== 'SUPER ADMINISTRADOR') {
                    if (parseInt(r.stsavan) === 12) {
                        swal('ERROR', 'EL CONTROL YA ESTÁ EN TERMINADO', 'warning').then((value) => {
                            Estilo.val('');
                            Color.val('');
                            Pares.val('');
                            btnAcepta.attr('disabled', true);
                            Control.val('').focus();
                            return;
                        });
                    }
                    if (parseInt(r.stsavan) === 13) {
                        swal('ERROR', 'EL CONTROL YA ESTÁ FACTURADO', 'warning').then((value) => {
                            Estilo.val('');
                            Color.val('');
                            Pares.val('');
                            btnAcepta.attr('disabled', true);
                            Control.val('').focus();
                            return;
                        });
                    }
                    if (parseInt(r.stsavan) === 14) {
                        swal('ERROR', 'EL CONTROL HA SIDO CANCELADO', 'warning').then((value) => {
                            Estilo.val('');
                            Color.val('');
                            Pares.val('');
                            btnAcepta.attr('disabled', true);
                            Control.val('').focus();
                            return;
                        });
                    }
                }
                Estilo.val(r.ESTILO);
                getFraccionesXEstilo(r);
                Pares.val(r.PARES);
                Color.val(r.COLOR + '-' + r.NOMCOLOR);
                color = r.COLOR;
                nomcolor = r.NOMCOLOR;
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


    function getFraccionesXEstilo(r) {
        sFraccion[0].selectize.clear(true);
        sFraccion[0].selectize.clearOptions();
        $.when($.getJSON('<?php print base_url('ControlPlantilla/getFraccionesXEstilo'); ?>', {
            ESTILO: r.ESTILO
        }).done(function (a) {
            a.forEach(function (e) {
                sFraccion[0].selectize.addOption({text: e.FRACCION, value: e.CLAVE});
            });
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {
        })).done(function () {
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

    function onEliminarControlPlantilla(ID) {
        onBeep(1);
        swal({
            title: "¿Estas seguro?",
            text: "El registro será eliminado, una vez aceptada la acción",
            icon: "warning",
            buttons: true
        }).then((value) => {
            if (value) {
                $.post('<?php print base_url('ControlPlantilla/onEliminar'); ?>',
                        {ID: ID}).done(function (a) {
                    sws('SE HA ELIMINADO EL REGISTRO');
                    ControlPlantilla.ajax.reload();
                }).fail(function (x) {
                    getError(x);
                }).always(function () {

                });
            }
        });
    }

    function onEliminarPorcentajeByID(ID) {
        onBeep(1);
        swal({
            title: "¿Estas seguro?",
            text: "El registro será eliminado, una vez aceptada la acción",
            icon: "warning",
            buttons: true
        }).then((value) => {
            if (value) {
                $.post('<?php print base_url('ControlPlantilla/onEliminarPorcentajeByID'); ?>',
                        {ID: ID}).done(function (a) {
                    Porcentajes.ajax.reload();
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