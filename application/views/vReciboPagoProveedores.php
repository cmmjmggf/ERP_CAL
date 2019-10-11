<div class="modal " id="mdlGeneraReciboPago"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Genera Recibos Pago a Proveedores</h5>
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
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">IMPRIMIR</button>
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
                        <a class="nav-link active" data-toggle="tab" href="#relacion">Relación de Pagos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#recibos">Recibos de Efectivo</a>
                    </li>
                </ul>
                <div id="tcReportes" class="tab-content"  style="width: 100%; height: 95%">
                    <div class="tab-pane fade show active" id="relacion"  style="height: inherit;">
                        <iframe id="ifReporte1" frameborder="0" scrolling="no" style="width: 100%; height: 100%"></iframe>
                    </div>
                    <div class="tab-pane fade" id="recibos" style="height: inherit;">
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
    var master_url = base_url + 'index.php/ReportesProveedores/';
    var mdlGeneraReciboPago = $('#mdlGeneraReciboPago');
    var mdlReporte = $('#mdlReporte');
    var generado = false;

    $(document).ready(function () {
        handleEnterDiv(mdlGeneraReciboPago);
        mdlReporte.draggable();
        mdlReporte.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href"); // activated tab
            if (target === '#recibos') {
                if (!generado) {
                    onReporteRecibosEfectivo();
                }

            }
        });
        mdlGeneraReciboPago.on('shown.bs.modal', function () {
            mdlGeneraReciboPago.find("input").val("");
            mdlGeneraReciboPago.find('#FechaFin').val(getToday());
            mdlGeneraReciboPago.find('#FechaIni').focus();
        });
        mdlGeneraReciboPago.find('#btnImprimir').on("click", function () {
            generado = false;
            onReporteRelacionPagos();
        });
    });

    function onReporteRelacionPagos() {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        mdlReporte.find(".nav-tabs li a").removeClass("active show");
        $(mdlReporte.find(".nav-tabs li a")[0]).addClass("active show");
        mdlReporte.find("#relacion").addClass("active show");
        mdlReporte.find("#recibos").removeClass("active show");
        var frm = new FormData(mdlGeneraReciboPago.find("#frmParametros")[0]);
        $.ajax({
            url: master_url + 'onReporteRelacionPagos',
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: frm
        }).done(function (data, x, jq) {

            if (data.length > 0) {
                mdlReporte.find('#ifReporte1').attr('src', base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs');
                mdlReporte.modal({backdrop: false});

            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "NO EXISTEN PAGOS PARA ESTE PROVEEDOR",
                    icon: "error"
                }).then((action) => {
                    mdlReporte.modal('hide');
                    mdlGeneraReciboPago.find('#FechaIni').focus();
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }

    function onReporteRecibosEfectivo() {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        var frm = new FormData(mdlGeneraReciboPago.find("#frmParametros")[0]);
        $.ajax({
            url: master_url + 'onReporteRecibosEfectivoProv',
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


</script>

