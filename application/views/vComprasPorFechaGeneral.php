<div class="modal " id="mdlComprasPorFechaGeneral"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reporte de Órdenes de Compra por Fechas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">

                    <div class="row">
                        <div class="col-4">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIni" name="FechaIni" >
                        </div>
                        <div class="col-4">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFin" name="FechaFin" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4">
                            <label>Tp <span class="badge badge-info mb-2" style="font-size: 12px;">Dejar en blanco para todo</span></label>
                            <input type="text" class="form-control form-control-sm  numbersOnly" name="Tp"  id="Tp" maxlength="1" >
                        </div>
                        <div class="col-8 col-sm-8">
                            <label>Tipo <span class="badge badge-info mb-2" style="font-size: 12px;">0 DIRECTAS, 10 Piel/Forro, 80 Suela, 90 Peletería</span></label>
                            <select class="form-control form-control-sm required selectize" id="Tipo" name="Tipo" >
                                <option value=""></option>
                                <option value="0">0 DIRECTAS</option>
                                <option value="10">10 PIEL Y FORRO</option>
                                <option value="80">80 SUELA</option>
                                <option value="90">90 INDIRECTOS</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="genSemMaq" name="genSemMaq" >
                                <label class="custom-control-label text-info labelCheck" for="genSemMaq">Compras Generales con Maq-Sem</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-fullscreen" id="mdlReporte"  role="dialog">
    <div class="modal-dialog modal-dialog-centered" id="Reporte" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vista Previa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#normal">Compras General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#desglose">Compras General a Detalle</a>
                    </li>
                </ul>
                <div id="tcReportes" class="tab-content"  style="width: 100%; height: 95%">
                    <div class="tab-pane fade show active" id="normal"  style="height: inherit;">
                        <iframe id="ifReporte1" frameborder="0" scrolling="no" style="width: 100%; height: 100%"></iframe>
                    </div>
                    <div class="tab-pane fade" id="desglose" style="height: inherit;">
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
    var mdlComprasPorFechaGeneral = $('#mdlComprasPorFechaGeneral');
    var mdlReporte = $('#mdlReporte');
    var generado = false;
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlExplosionSemanal);
        setFocusSelectToInputOnChange('#Tipo', '#btnImprimir', mdlComprasPorFechaGeneral);

        mdlComprasPorFechaGeneral.on('shown.bs.modal', function () {
            handleEnterDiv(mdlComprasPorFechaGeneral);
            mdlComprasPorFechaGeneral.find("input").val("");
            $.each(mdlComprasPorFechaGeneral.find("select"), function (k, v) {
                mdlComprasPorFechaGeneral.find("select")[k].selectize.clear(true);
            });
            mdlComprasPorFechaGeneral.find('#FechaFin').val(getToday());
            mdlComprasPorFechaGeneral.find('#FechaIni').focus();
        });


        mdlComprasPorFechaGeneral.find('#btnImprimir').on("click", function () {
            if (mdlComprasPorFechaGeneral.find("#genSemMaq")[0].checked) {

                onReporteGeneral();

            } else {
                generado = false;
                onReporteUno();
            }


        });

        function onReporteGeneral() {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlComprasPorFechaGeneral.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesMaterialesJasper/onReporteComprasGeneralSemMaq',
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
                        text: "NO EXISTEN DATOS PARA EL REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlComprasPorFechaGeneral.find('#FechaIni').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        }

        function onReporteUno() {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            mdlReporte.find(".nav-tabs li a").removeClass("active show");
            $(mdlReporte.find(".nav-tabs li a")[0]).addClass("active show");
            mdlReporte.find("#normal").addClass("active show");
            mdlReporte.find("#desglose").removeClass("active show");
            var frm = new FormData(mdlComprasPorFechaGeneral.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesCompras/onReporteComprasGeneralSinDesglose',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    mdlReporte.find('#ifReporte1').attr('src', base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs');
                    mdlReporte.modal({backdrop: false});

                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA EL REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlReporte.modal('hide');
                        mdlComprasPorFechaGeneral.find('#FechaIni').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        }

        mdlReporte.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href"); // activated tab
            if (target === '#desglose') {
                if (!generado) {
                    onReporteDos();
                }

            }
        });

        function onReporteDos() {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlComprasPorFechaGeneral.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesCompras/onReporteComprasGeneralDesglose',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
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
                        text: "NO EXISTEN RECIBOS DE EFECTIVO PARA ESTE PROVEEDOR",
                        icon: "error"
                    });
                    mdlReporte.find(".nav-tabs li a").removeClass("active show");
                    $(mdlReporte.find(".nav-tabs li a")[0]).addClass("active show");
                    mdlReporte.find("#relacion").addClass("active show");
                    mdlReporte.find("#recibos").removeClass("active show");
                }
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        }

        mdlComprasPorFechaGeneral.find("#Tp").change(function () {
            onVerificarTp($(this));
        });
    });

    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false,
                buttons: false,
                timer: 1000
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }
</script>