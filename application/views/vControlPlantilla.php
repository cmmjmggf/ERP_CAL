<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-5 float-left">
                <legend class="float-left">Captura plantillas para maquila</legend>
            </div>
            <div class="col-sm-1">
                <label class="text-danger font-weight-bold">Re-Imprime</label>
            </div>
            <div class="col-sm-2">
                <input type="text" id="Reimprime" name="Reimprime" class="form-control form-control-sm numbersOnly" maxlength="6">
            </div>
            <div class="col-4" align="right">
                <button type="button" id="btnRetorna" name="btnRetorna" class="btn btn-indigo btn-sm" >
                    <span class="fa fa-retweet"></span>
                    Retorno plantilla
                </button>
                <button type="button" id="btnConceptosPlantilla" name="btnConceptosPlantilla" class="btn btn-green btn-sm mx-2" >
                    <span class="fa fa-bullseye"></span>
                    Conceptos plantilla
                </button>
                <button type="button" id="btnReportePago" name="btnReportePago" class="btn btn-red btn-sm">
                    <span class="fa fa-exclamation"></span>
                    Reporte pago
                </button>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-3">
                <label>Proveedor</label>
                <select id="Proveedor" name="Proveedor" class="form-control form-control-sm required" ></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-2">
                <label>Tipo Maquila</label>
                <select id="TipoMaquila" name="TipoMaquila" class="form-control form-control-sm required"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-1">
                <label>Documento</label>
                <input type="text" id="Documento" name="Documento" class="form-control form-control-sm" readonly="" required="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-2">
                <label>Control</label>
                <input type="text" id="Control" name="Control" class="form-control form-control-sm numbersOnly" required="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-1">
                <label>Estilo</label>
                <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm" readonly="" required="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-2">
                <label>Color</label>
                <input type="text" id="Color" name="Color" class="form-control form-control-sm" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-1">
                <label>Pares</label>
                <input type="text" id="Pares" name="Pares" class="form-control form-control-sm numbersOnly" readonly="">
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-3">
                <label>Fracción</label>
                <select  id="Fraccion" name="Fraccion" class="form-control form-control-sm required"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-1">
                <label>Precio</label>
                <input type="text" id="Precio" name="Precio" class="form-control form-control-sm numbersOnly" required="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Fecha</label>
                <input type="text" id="Fecha" name="Fecha" class="form-control form-control-sm date notEnter" readonly="">
            </div>

            <div class="col-12 col-xs-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary btn-sm" id="btnAcepta" disabled=""><span class="fa fa-check"></span> ACEPTA </button>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content  modal-lg">
            <div class="modal-header">
                <h5 class="modal-title">Retorno de plantilla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Documento</label>
                        <input type="text" id="DocumentoRetorno" name="DocumentoRetorno" class="form-control form-control-sm">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Fecha vale</label>
                        <input type="text" id="FechaVale" name="FechaVale" class="form-control form-control-sm" readonly="">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="btnAceptaRetorno"><span class="fa fa-print"></span> Acepta</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="mdlReportePago">
    <div class="modal-dialog  modal-dialog-centered" role="document">
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


<script>
    var pnlTablero = $("#pnlTablero"), ControlPlantilla, tblControlPlantilla = pnlTablero.find("#tblControlPlantilla"),
            Proveedor = pnlTablero.find("#Proveedor"), TipoMaquila = pnlTablero.find("#TipoMaquila"),
            Control = pnlTablero.find("#Control"), Documento = pnlTablero.find("#Documento"),
            Estilo = pnlTablero.find("#Estilo"), Color = pnlTablero.find("#Color"),
            Pares = pnlTablero.find("#Pares"), Fraccion = pnlTablero.find("#Fraccion"),
            Precio = pnlTablero.find("#Precio"), Fecha = pnlTablero.find("#Fecha"),
            btnAcepta = pnlTablero.find("#btnAcepta"), mdlRetorno = $("#mdlRetorno"),
            btnRetorna = pnlTablero.find("#btnRetorna"), DocumentoRetorno = mdlRetorno.find("#DocumentoRetorno"),
            FechaVale = mdlRetorno.find("#FechaVale"), RetornaDocumento, tblRetornaDocumento = mdlRetorno.find("#tblRetornaDocumento"),
            btnConceptosPlantilla = pnlTablero.find("#btnConceptosPlantilla"),
            btnAceptaRetorno = mdlRetorno.find("#btnAceptaRetorno"), mdlReportePago = $("#mdlReportePago"),
            btnAceptaReportePago = mdlReportePago.find("#btnAceptaReportePago");
    btnReportePago = pnlTablero.find("#btnReportePago");

    var FechaActual = '<?php print Date('d/m/Y'); ?>';

    $(document).ready(function () {
        handleEnterDiv(pnlTablero);
        handleEnterDiv(mdlReportePago);
        handleEnterDiv(mdlRetorno);
        Proveedor[0].selectize.focus();
        getProveedores();
        getMaquilasPlantillas();
        getRecords();
        getUltimoDocumento();

        Proveedor.change(function () {
            ControlPlantilla.ajax.reload();
        });

        btnAceptaReportePago.click(function () {
            getReport(1);
        });

        mdlReportePago.on('shown.bs.modal', function () {
            mdlReportePago.find("input").val('');
            mdlReportePago.find("#chkSinRecibir")[0].checked = false;
            mdlReportePago.find("#chkRecibido")[0].checked = false;
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

        DocumentoRetorno.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    getDocsRetorno();
                }
            }
        });

        btnAceptaRetorno.click(function () {
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
                                    {Docto: DocumentoRetorno.val(), FECHA: FechaVale.val()}).done(function (a) {
                                swsd('SE HA RETORNADO EL DOCUMENTO', function () {
                                    DocumentoRetorno.val('').focus().select();
                                    RetornaDocumento.ajax.reload();
                                });
                            }).fail(function (x) {
                                getError(x);
                            }).always(function () {

                            });
                        } else {
                            swwt('ESTE DOCUMENTO NO ES VÁLIDO O YA FUE ENTREGADO', function () {
                                DocumentoRetorno.focus().select();
                            });
                        }
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {

                });
                /*2.- EN CASO DE QUE ESTE ACTIVO CAMBIARLO A ESTATUS DOS(2)*/

            } else {
                swwt('DEBE DE ESPECIFICAR UN DOCUMENTO', function () {
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

        btnAcepta.click(function () {
            isValid('pnlTablero');
            if (valido) {
                $.post('<?php print base_url('ControlPlantilla/onGuardar'); ?>', {
                    PROVEEDOR: Proveedor.val(),
                    PROVEEDORT: Proveedor.find("option:selected").text(),
                    TIPO: TipoMaquila.val(),
                    DOCUMENTO: Documento.val(),
                    CONTROL: Control.val(),
                    ESTILO: Estilo.val(),
                    COLOR: color,
                    COLORT: nomcolor,
                    PARES: Pares.val(),
                    FRACCION: Fraccion.val(),
                    FRACCIONT: Fraccion.find("option:selected").text(),
                    PRECIO: Precio.val(),
                    FECHA: Fecha.val()
                }).done(function () {
                    ControlPlantilla.ajax.reload();
                    Fraccion[0].selectize.clear(true);
                    Fraccion[0].selectize.clearOptions();
                    Precio.val('');
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

        Fecha.val('<?php print Date('d/m/Y') ?>');

        Control.on('keydown', function (e) {
            if (e.keyCode === 13) {
                getInfoXControl();
            }
        });

        Fraccion.change(function () {
            if ($(this).val()) {
                $.getJSON('<?php print base_url('ControlPlantilla/onVerificaControlFraccion') ?>', {
                    FRACCION: Fraccion.val(),
                    CONTROL: Control.val()
                }).done(function (a) {
                    if (a.length > 0) {
                        swal('ERROR', 'EL CONTROL/FRACCIÓN YA HA SIDO ENVIADO', 'warning').then((value) => {
                            Fraccion[0].selectize.clear(true);
                            Fraccion[0].selectize.clearOptions();
                            Precio.val('');
                            Estilo.val('');
                            Color.val('');
                            Pares.val('');
                            btnAcepta.attr('disabled', true);
                            Control.val('').focus();
                            return;
                        });
                    } else {
                        $.getJSON('<?php print base_url('ControlPlantilla/getPrecioXFraccionXEstilo') ?>', {
                            FRACCION: Fraccion.val(),
                            ESTILO: Estilo.val()
                        }).done(function (a) {
                            Precio.val((a.length > 0) ? a[0].PRECIO_COSTOMO : '');
                            Fecha.val(FechaActual);
                            btnAcepta.attr('disabled', false);
                            btnAcepta.focus();
                        }).fail(function (x, y, z) {
                            getError(x);
                        }).always(function () {
                        });
                    }
                }).fail(function (x, y, z) {
                    getError(x);
                }).always(function () {
                });

            }
        });
    });


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
                "aaSorting": [
                    [0, 'desc']
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
                    d.PROVEEDOR = Proveedor.val() ? Proveedor.val() : '';
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
            "scrollY": "400px",
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
                Proveedor[0].selectize.addOption({text: e.ID + ' ' + e.PROVEEDOR, value: e.ID});
            });
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {

        });
    }

    function getMaquilasPlantillas() {
        TipoMaquila[0].selectize.clear(true);
        TipoMaquila[0].selectize.clearOptions();
        $.getJSON('<?php print base_url('ControlPlantilla/getMaquilasPlantillas'); ?>').done(function (a) {
            a.forEach(function (e) {
                TipoMaquila[0].selectize.addOption({text: e.ID + ' ' + e.MAQPLA, value: e.ID});
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
        Fraccion[0].selectize.clear(true);
        Fraccion[0].selectize.clearOptions();
        $.when($.getJSON('<?php print base_url('ControlPlantilla/getFraccionesXEstilo'); ?>', {
            ESTILO: r.ESTILO
        }).done(function (a) {
            a.forEach(function (e) {
                Fraccion[0].selectize.addOption({text: e.FRACCION, value: e.CLAVE});
            });
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {
        })).done(function () {
        });
    }

    function getUltimoDocumento() {
        HoldOn.open({
            theme: 'sk-rect'
        });
        var documento = "";
        $.getJSON('<?php print base_url('ControlPlantilla/getUltimoDocumento'); ?>').done(function (a) {
            console.log(a);
            /*19(ANO) 03(MES) 07(DIA) 001(CONSECUTIVO) = 190307001*/
            if (a.length > 0) {
                var udoc = a[0];
                documento = udoc.docto;
                Documento.val(documento);
            } else {
                swal('ERROR', 'NO FUE POSIBLE OBTENER EL ULTIMO DOCUMENTO, REVISE LA CONSOLA PARA MAS DETALLE', 'error');
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            HoldOn.close();
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
</script>
<style>

    table tbody tr {
        font-size: 0.75rem !important;
    }

</style>