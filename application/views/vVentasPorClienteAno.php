<div class="modal " id="mdlVentasPorClienteAno"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ventas por cliente y año</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6">
                            <label class="mb-1">Del Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoVtasAnoCliente" name="AnoVtasAnoCliente" >
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3">
                            <label>Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="ClienteVtasAnocliente" name="ClienteVtasAnocliente" maxlength="5" required="">
                        </div>
                        <div class="col-9">
                            <label for="" >-</label>
                            <select id="sClienteVtasAnocliente" name="sClienteVtasAnocliente" class="form-control form-control-sm mb-2 required NotSelectize" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">
                            <label class="mb-1">Tipo <span class="badge badge-danger" style="font-size: 14px;">1 Factura, 2 Pedido</span></label>
                            <select id="TipoVtasAnoCliente" name="TipoVtasAnoCliente" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                                <option value="1">1 Factura</option>
                                <option value="2">2 Pedido</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="mb-1">Tp</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpVtasAnoCliente" name="TpVtasAnoCliente">
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
<script>
    var mdlVentasPorClienteAno = $('#mdlVentasPorClienteAno');
    $(document).ready(function () {
        mdlVentasPorClienteAno.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        mdlVentasPorClienteAno.on('shown.bs.modal', function () {

            mdlVentasPorClienteAno.find("input").val("");
            $.each(mdlVentasPorClienteAno.find("select"), function (k, v) {
                mdlVentasPorClienteAno.find("select")[k].selectize.clear(true);
            });
            getClientesVtasAnoCliente();
            var d = new Date();
            mdlVentasPorClienteAno.find('#AnoVtasAnoCliente').val(d.getFullYear());
            mdlVentasPorClienteAno.find('#AnoVtasAnoCliente').focus().select();
        });
        mdlVentasPorClienteAno.find('#ClienteVtasAnocliente').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'AuxReportesClientesTres/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlVentasPorClienteAno.find("#sClienteVtasAnocliente")[0].selectize.addItem(txtcte, true);
                            mdlVentasPorClienteAno.find("#TipoVtasAnoCliente")[0].selectize.focus();

                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                mdlVentasPorClienteAno.find("#sClienteVtasAnocliente")[0].selectize.clear(true);
                                mdlVentasPorClienteAno.find('#ClienteVtasAnocliente').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlVentasPorClienteAno.find("#sClienteVtasAnocliente").change(function () {
            if ($(this).val()) {
                mdlVentasPorClienteAno.find("#ClienteVtasAnocliente").val($(this).val());
                mdlVentasPorClienteAno.find("#TipoVtasAnoCliente")[0].selectize.focus();
            }
        });
        mdlVentasPorClienteAno.find("#AnoVtasAnoCliente").keypress(function (e) {
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
                        mdlVentasPorClienteAno.find("#AnoVtasAnoCliente").val("");
                        mdlVentasPorClienteAno.find("#AnoVtasAnoCliente").focus();
                    });
                } else {
                    mdlVentasPorClienteAno.find('#ClienteVtasAnocliente').focus();
                }
            }
        });

        mdlVentasPorClienteAno.find("#TipoVtasAnoCliente").change(function () {
            if ($(this).val()) {
                mdlVentasPorClienteAno.find("#TpVtasAnoCliente").focus().select();
            }
        });

        mdlVentasPorClienteAno.find("#TpVtasAnoCliente").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTpVtasAnocliente($(this));
                }
//                else {
//                    mdlVentasPorClienteAno.find("#btnImprimir").focus();
//                }
            }
        });


        mdlVentasPorClienteAno.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlVentasPorClienteAno.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteVentasPorClienteAno',
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
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlVentasPorClienteAno.find('#ClienteVtasAnocliente').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });

    function onVerificarTpVtasAnocliente(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlVentasPorClienteAno.find("#btnImprimir").focus();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }

    function getClientesVtasAnoCliente() {
        mdlVentasPorClienteAno.find("#sClienteVtasAnocliente")[0].selectize.clear(true);
        mdlVentasPorClienteAno.find("#sClienteVtasAnocliente")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/AuxReportesClientes/getClientes').done(function (data) {
            $.each(data, function (k, v) {
                mdlVentasPorClienteAno.find("#sClienteVtasAnocliente")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

</script>
