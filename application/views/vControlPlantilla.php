<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Captura plantillas para maquila</legend>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6" align="right">
                <button type="button" id="btnRetorna" name="btnRetorna" class="btn btn-indigo" style="box-shadow: 0 0 0 0.2rem #CDDC39 !important;">
                    <span class="fa fa-retweet"></span>
                    Retorno plantilla
                </button>
                <button type="button" id="btnConceptosPlantilla" name="btnConceptosPlantilla" class="btn btn-green  mx-2" style="box-shadow: 0 0 0 0.2rem #CDDC39 !important;">
                    <span class="fa fa-bullseye"></span>
                    Conceptos plantilla
                </button>
                <button type="button" id="btnReportePago" name="btnReportePago" class="btn btn-red" style="box-shadow: 0 0 0 0.2rem #CDDC39 !important;">
                    <span class="fa fa-exclamation"></span>
                    Reporte pago
                </button>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
                <label>Proveedor</label>
                <select id="Proveedor" name="Proveedor" class="form-control"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
                <label>Tipo Maquila</label>
                <select id="TipoMaquila" name="TipoMaquila" class="form-control"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Documento</label>
                <input type="text" id="Documento" name="Documento" class="form-control form-control-sm">
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <label>Control</label>
                <input type="text" id="Control" name="Control" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Estilo</label>
                <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <label>Color</label>
                <select  id="Color" name="Color" class="form-control"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Pares</label>
                <input type="text" id="Pares" name="Pares" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
                <label>Fracción</label>
                <select  id="Fraccion" name="Fraccion" class="form-control"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Precio</label>
                <input type="text" id="Precio" name="Precio" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Fecha</label>
                <input type="text" id="Fecha" name="Fecha" class="form-control form-control-sm date">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Reimprime</label>
                <input type="text" id="Reimprime" name="Reimprime" class="form-control form-control-sm date">
            </div> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary" id="btnAcepta" disabled=""><span class="fa fa-check"></span> ACEPTA </button>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="right">
                <button type="button" class="btn btn-warning" onclick="ControlPlantilla.ajax.reload()"><span class="fa fa-sync"></span> REFRESCAR</button>
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
<div class="modal animated zoomIn" id="mdlRetorno">
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
                        <input type="text" id="DocumentoRetorno" name="DocumentoRetorno" class="form-control">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Fecha vale</label>
                        <input type="text" id="FechaVale" name="FechaVale" class="form-control">
                    </div>
                </div>
                <br>
                <div class="w-100"></div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <table class="table table-hover" id="tblRetornaDocumento">
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
                                <th scope="col">-</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <button type="button" class="btn btn-primary" id="btnAceptaRetorno" >Acepta</button>
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal animated slideInDown" id="mdlReportePago">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content  modal-lg">
            <div class="modal-header">
                <h5 class="modal-title">Maquila x fecha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>De la fecha</label>
                        <input type="text" id="DeLaFecha" name="DeLaFecha" class="form-control date">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>A la fecha</label>
                        <input type="text" id="ALaFecha" name="ALaFecha" class="form-control date">
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
                <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <button type="button" class="btn btn-primary" id="btnAceptaReportePago">Acepta</button>
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
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
        getProveedores();
        getMaquilasPlantillas();
        getRecords();
        getUltimoDocumento();

        btnAceptaReportePago.click(function () {
            getReport(1);
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
                                    {ID: r.IDDOCTO, FECHA: FechaVale.val()}).done(function (a) {
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
                    {"data": "BTN"}/*8*/
                ];
                var coldefs = [
                    {
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    }
                ];
                var xoptions = {
                    "dom": 'rit',
                    "ajax": {
                        "url": '<?php print base_url('ControlPlantilla/getEntregados'); ?>',
                        "type": "POST",
                        "contentType": "application/json",
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
                        [0, 'desc']
                    ]
                };
                RetornaDocumento = tblRetornaDocumento.DataTable(xoptions);
            } else {
                RetornaDocumento.ajax.reload();
                RetornaDocumento.columns.adjust().draw();
            }
        });

        btnRetorna.click(function () {
            mdlRetorno.modal('show');
            DocumentoRetorno.focus();
            FechaVale.val(FechaActual);
        });

        btnAcepta.click(function () {
            getUltimoDocumento();
            $.post('<?php print base_url('ControlPlantilla/onGuardar'); ?>', {
                PROVEEDOR: Proveedor.val(),
                PROVEEDORT: Proveedor.find("option:selected").text(),
                TIPO: TipoMaquila.val(),
                DOCUMENTO: Documento.val(),
                CONTROL: Control.val(),
                ESTILO: Estilo.val(),
                COLOR: Color.val(),
                COLORT: Color.find("option:selected").text(),
                PARES: Pares.val(),
                FRACCION: Fraccion.val(),
                FRACCIONT: Fraccion.find("option:selected").text(),
                PRECIO: Precio.val(),
                FECHA: Fecha.val()
            }).done(function () {
                swsd('SE HAN GUARDANDO LOS CAMBIOS', function () {
                    ControlPlantilla.ajax.reload();
                    getUltimoDocumento();
                    pnlTablero.find("input").val('');
                    $.each(pnlTablero.find("select"), function (k, v) {
                        pnlTablero.find("select")[k].selectize.clear(true);
                    });
                });
            }).fail(function (x) {
                getError(x);
            }).always(function () {
                Fecha.val(FechaActual);
            });
        });

        Fecha.val('<?php print Date('d/m/Y') ?>');

        Control.on('keydown', function (e) {
            if (e.keyCode === 13) {
                getInfoXControl();
                getUltimoDocumento();
            }
        });

        Fraccion.change(function () {
            $.getJSON('<?php print base_url('ControlPlantilla/getPrecioXFraccionXEstilo') ?>', {
                FRACCION: Fraccion.val(),
                ESTILO: Estilo.val()
            }).done(function (a) {
                Precio.val((a.length > 0) ? a[0].PRECIO_COSTOMO : '');
                Fecha.val(FechaActual);
            }).fail(function (x, y, z) {
                getError(x);
            }).always(function () {
                getUltimoDocumento();
            });
        });
    });

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
                    $.fancybox.defaults.animationEffect = "zoom-in-out";
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
            {"data": "BTN"}/*8*/
        ];
        var coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ];
        var xoptions = {
            "dom": 'rit',
            "ajax": {
                "url": '<?php print base_url('ControlPlantilla/getRecords'); ?>',
                "type": "POST",
                "contentType": "application/json",
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
            "scrollY": "498px",
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

    function getInfoXControl() {
        $.getJSON('<?php print base_url('ControlPlantilla/getInfoXControl'); ?>', {
            CONTROL: Control.val()
        }).done(function (a) {
            if (a.length > 0) {
                var r = a[0];
                Estilo.val(r.ESTILO);
                getColoresXEstilo(r);
                getFraccionesXEstilo(r);
                Pares.val(r.PARES);
                btnAcepta.attr('disabled', false);
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

    function getColoresXEstilo(r) {
        Color[0].selectize.clear(true);
        Color[0].selectize.clearOptions();
        $.when($.getJSON('<?php print base_url('ControlPlantilla/getColoresXEstilo'); ?>', {
            ESTILO: r.ESTILO
        }).done(function (a) {
            a.forEach(function (e) {
                Color[0].selectize.addOption({text: e.COLOR, value: e.CLAVE});
            });
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {
        })).done(function () {
            Color[0].selectize.setValue(r.COLOR);
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
                documento = udoc.ANO + "" + udoc.MES + "" + udoc.DIA + "" + (udoc.CONSECUTIVO);
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
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid; 
        /*border-image: linear-gradient(to bottom,  #2196F3, #cc0066, rgb(0,0,0,0)) 1 100% ;*/
        border-image: linear-gradient(to bottom,  #0099cc, #ccff00, rgb(0,0,0,0)) 1 100% ;
    }
    .card-header{ 
        background-color: transparent;
        border-bottom: 0px;
    }

    .btn-indigo {
        color: #fff;
        background-color: #3F51B5;
        border-color: #3F51B5;
        box-shadow: 0 0 0 0.2rem #CDDC39 !important;
    }

    .btn-indigo {
        color: #fff;
        background-color: #3F51B5;
        border-color: #3F51B5;
        box-shadow: 0 0 0 0.2rem #CDDC39 !important;
    }
    .btn-green {
        color: #fff;
        background-color: #4CAF50;
        border-color: #4CAF50;
    }
    .btn-red {
        color: #fff;
        background-color: #D32F2F;
        border-color: #D32F2F;
    }
</style>