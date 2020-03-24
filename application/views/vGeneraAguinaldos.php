<div class="modal " id="mdlGeneraAguinaldos"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Genera Aguinaldos/Vacaciones para el banco</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoAguinaldos" name="AnoAguinaldos" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="SemAguinaldos" name="SemAguinaldos" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Fecha de aplicación</label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaAplicacionAguinaldos" name="FechaAplicacionAguinaldos" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir"><span class="fa fa-file-alt"></span> EXPORTAR TXT </button>
                <button type="button" class="btn btn-danger" id="btnImprimirPDF"><span class="fa fa-file-pdf"></span> IMPRIMIR PDF</button>
                <button type="button" class="btn btn-success" id="btnImprimirXLS"><span class="fa fa-file-excel"></span> EXCEL</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlGeneraAguinaldos = $('#mdlGeneraAguinaldos');

    function onGeneraAguinaldoFiscal() {
        location.href = base_url + "index.php/ReportesNominaJasper/generaArchivoBancoFiscal";
        HoldOn.close();
    }
    function onGeneraAguinaldoFiscalDos() {
        location.href = base_url + "index.php/ReportesNominaJasper/generaArchivoBancoInterna";
        HoldOn.close();
    }
    $(document).ready(function () {
        mdlGeneraAguinaldos.on('shown.bs.modal', function () {
            mdlGeneraAguinaldos.find("input").val("");
            $.each(mdlGeneraAguinaldos.find("select"), function (k, v) {
                mdlGeneraAguinaldos.find("select")[k].selectize.clear(true);
            });
            mdlGeneraAguinaldos.find("#AnoAguinaldos").val(new Date().getFullYear());
            mdlGeneraAguinaldos.find('#AnoAguinaldos').focus().select();
        });
        mdlGeneraAguinaldos.find('#btnImprimirPDF').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlGeneraAguinaldos.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesNominaJasper/onReporteAguinaldosPDF',
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
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA EL REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlGeneraAguinaldos.find('#FechaAplicacionAguinaldos').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
        mdlGeneraAguinaldos.find('#btnImprimirXLS').on("click", function () {
            mdlGeneraAguinaldos.find('#btnImprimirXLS').attr('disabled', true);
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlGeneraAguinaldos.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesNominaJasper/onReporteAguinaldosXLS',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    window.open(data, '_blank');
                    mdlGeneraAguinaldos.find('#btnImprimirXLS').attr('disabled', false);
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA EL REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlGeneraAguinaldos.find('#btnImprimirXLS').attr('disabled', false);
                        mdlGeneraAguinaldos.find('#FechaAplicacionAguinaldos').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                mdlGeneraAguinaldos.find('#btnImprimirXLS').attr('disabled', false);
                console.log(x, y, z);
                HoldOn.close();
            });
        });
        mdlGeneraAguinaldos.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var frm = new FormData(mdlGeneraAguinaldos.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesNominaJasper/onReporteAguinaldos',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                mdlGeneraAguinaldos.find('#btnImprimir').attr('disabled', false);
                console.log(data);
                HoldOn.close();
                onNotifyOld('', 'SE HAN CREADO LOS ARCHIVOS DE DEPOSITOS PARA ESTA SEMANA', 'success');
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                HoldOn.close();
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            }).always(function () {

            });
        });
        mdlGeneraAguinaldos.find("#AnoAguinaldos").keydown(function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                    swal({
                        title: "ATENCIÓN",
                        text: "AÑO INCORRECTO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        buttons: false,
                        timer: 1000
                    }).then((action) => {
                        mdlGeneraAguinaldos.find("#AnoAguinaldos").val("");
                        mdlGeneraAguinaldos.find("#AnoAguinaldos").focus();
                    });
                } else {
                    mdlGeneraAguinaldos.find("#SemAguinaldos").focus().select();
                }
            }
        });
        mdlGeneraAguinaldos.find("#SemAguinaldos").keypress(function (e) {
            if ($(this).val())
                if (e.keyCode === 13) {
                    if (parseInt($(this).val()) > 96 && parseInt($(this).val()) < 100) {
                        //obtener getRecors de la semana, año
                        mdlGeneraAguinaldos.find("#FechaAplicacionAguinaldos").focus();
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "LA SEMANA DEBE DE SER 97, 98 O 99",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            if (action) {
                                $(this).val('').focus();
                            }
                        });
                    }
                }
        });
        mdlGeneraAguinaldos.find("#FechaAplicacionAguinaldos").keyup(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlGeneraAguinaldos.find("#btnImprimir").focus();
                }
            }
        });
    });

</script>