<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Captura Pagos a Proveedores</legend>
            </div>
            <div class="col-sm-4" align="right">
                <button type="button" class="btn btn-warning btn-sm " id="btnImprimirEdoCtaProveedor" >
                    <span class="fa fa-file-pdf" ></span> EDO. CTA PROVEEDOR
                </button>
            </div>
        </div>
        <hr>
        <div class="row" id="Encabezado">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly captura" id="TpPago" maxlength="1" required="">
            </div>
            <div class="col-1">
                <label>Proveedor</label>
                <input type="text" class="form-control form-control-sm  numbersOnly captura" id="iProveedor" name="iProveedor" maxlength="5" required="">
            </div>
            <div class="col-12 col-sm-3 col-md-3 col-xl-3" >
                <label for="" >-</label>
                <select id="sProveedor" name="sProveedor" class="form-control form-control-sm required captura NotSelectize" required="" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-4 col-sm-3 col-md-3 col-lg-3 col-xl-2" >
                <label for="" >Documento</label>
                <select id="Factura" name="Factura" class="form-control form-control-sm required captura" required="" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-4 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label>Fecha Doc.</label>
                <input type="text" class="form-control form-control-sm disabledForms" readonly="" id="FechaDoc" name="FechaDoc">
            </div>
            <div class="col-4 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Días</label>
                <input type="text" class="form-control form-control-sm  disabledForms" id="Dias" readonly="">
            </div>
            <div class="w-100"></div>
            <div class="col-4 col-sm-3 col-md-2 col-lg-2 col-xl-1" >
                <label>Importe</label>
                <input type="text" class="form-control form-control-sm disabledForms" id="ImporteDoc" name="ImporteDoc" readonly="">
            </div>
            <div class="col-4 col-sm-3 col-md-2 col-lg-2 col-xl-1" >
                <label>Pagos</label>
                <input type="text" class="form-control form-control-sm disabledForms" id="Pagos_Doc" name="Pagos_Doc" readonly="">
            </div>
            <div class="col-4 col-sm-3 col-md-2 col-lg-2 col-xl-1" >
                <label>Saldo</label>
                <input type="text" class="form-control form-control-sm disabledForms" id="Saldo_Doc" name="Saldo_Doc" readonly="">
            </div>
        </div>
        <hr>
        <div class="row" id="Detalle">
            <div class="col-4 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label>Fecha Pago.</label>
                <input type="text" class="form-control form-control-sm date notEnter " id="Fecha" name="Fecha" required="">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Importe</label>
                <input type="text" class="form-control form-control-sm numbersOnly " id="Importe" name="Importe" maxlength="15" required>
            </div>

            <!--            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <label>Doc Pago/Finanzas</label>
                            <input type="text" class="form-control form-control-sm" id="DocPago" name="DocPago" maxlength="15">
                        </div>-->

            <div class="col-12 col-sm-4 col-md-3 col-xl-2">

                <label for="" >Tipo Pago</label>

                <select id="TipoPago" name="TipoPago" class="form-control form-control-sm required" >
                    <?php
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
                    if ($Origen === 'MATERIALES') {
                        print '<option value=""></option>
                       <option value="4">4 DESC. SIN COMPROBANTE</option>
                    <option value="5">5 DEVOLUCIÓN</option>
                    <option value="6">6 CARGOS</option>';
                    } else if ($Origen === 'CONTABILIDAD') {
                        print '<option value=""></option>
                    <option value="1">1 EFECTIVO</option>
                    <option value="2">2 TRANSFERENCIA</option>
                    <option value="3">3 CHEQUE</option>
                    <option value="4">4 DESC. SIN COMPROBANTE</option>
                    <option value="5">5 DEVOLUCIÓN</option>
                    <option value="6">6 CARGOS</option>';
                    } else if ($Origen === 'PROVEEDORES') {
                        print '<option value=""></option>
                    <option value="1">1 EFECTIVO</option>
                    <option value="2">2 TRANSFERENCIA</option>
                    <option value="3">3 CHEQUE</option>
                    <option value="4">4 DESC. SIN COMPROBANTE</option>
                    <option value="5">5 DEVOLUCIÓN</option>
                    <option value="6">6 CARGOS</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                <label>Referencia</label>
                <input type="text" class="form-control form-control-sm" id="DocPago" name="DocPago" maxlength="15">
            </div>
            <div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                <label>Banco</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Banco" name="Banco" maxlength="3" required="">
            </div>
            <div class="col-12 col-sm-4 col-md-2 col-xl-2" >
                <label for="" >-</label>
                <select id="sBanco" name="sBanco" class="form-control form-control-sm required NotSelectize" required="" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary captura" id="btnGuardar">
                    <i class="fa fa-check"></i> ACEPTAR
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal " id="mdlEstadoCuentaProveedorInt"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estado de Cuenta de Proveedores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmEdoCta">

                    <div class="row">
                        <div class="col-6">
                            <label>Tp <span class="badge badge-warning mb-2" style="font-size: 12px;">Para consultar todo deja en blanco</span></label>
                            <input type="text" maxlength="1" class="form-control form-control-sm numbersOnly" id="Tp" name="Tp" >
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12 col-sm-12">
                            <label>Del Proveedor</label>
                            <select class="form-control form-control-sm required" id="Proveedor" name="Proveedor" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-12">
                            <label>Al Proveedor</label>
                            <select class="form-control form-control-sm required" id="aProveedor" name="aProveedor" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="Desglosado">
                                <label class="custom-control-label text-info labelCheck" for="Desglosado">Desglosado</label>
                            </div>
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
<script>     var master_url = base_url + 'index.php/PagosProveedores/';
    var pnlTablero = $("#pnlTablero");
    var mdlEstadoCuentaProveedor = $('#mdlEstadoCuentaProveedorInt');
    var btnGuardar = pnlTablero.find('#btnGuardar');
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToSelectOnChange('#iProveedor', '#Factura', pnlTablero);
        setFocusSelectToInputOnChange('#TipoPago', '#DocPago', pnlTablero);
        setFocusSelectToInputOnChange('#sBanco', '#btnGuardar', pnlTablero);
        //handleEnterDiv(pnlTablero);
        init();
        pnlTablero.find("#TpPago").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {

                    pnlTablero.find("#sBanco")[0].selectize.clear(true);
                    pnlTablero.find("#sBanco")[0].selectize.clearOptions();

                    onVerificarTpPagosProv($(this));
                    getBancos($(this).val());
                }
            }
        });
        pnlTablero.find('#iProveedor').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtprov = $(this).val();
                if (txtprov) {
                    $.getJSON(master_url + 'onVerificarProveedor', {Proveedor: txtprov}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sProveedor")[0].selectize.addItem(txtprov, true);


                            var tp = pnlTablero.find("#TpPago").val();
                            $.getJSON(master_url + 'getDocumentosByTpByProveedor', {
                                Tp: tp,
                                Proveedor: txtprov
                            }).done(function (data) {
                                pnlTablero.find("#Factura")[0].selectize.clear(true);
                                pnlTablero.find("#Factura")[0].selectize.clearOptions();
                                if (data.length > 0) {//Existe
                                    $.each(data, function (k, v) {
                                        pnlTablero.find("#Factura")[0].selectize.addOption({text: v.Doc + ' ----> [' + v.FechaDoc + ']', value: v.Doc});
                                    });
                                    $.notify({
                                        // options
                                        icon: 'fa fa-check',
                                        title: '',
                                        message: 'DOCUMENTOS PENDIENTES CARGADOS'
                                    }, {
                                        // settings
                                        type: 'success',
                                        allow_dismiss: true,
                                        newest_on_top: false,
                                        showProgressbar: false,
                                        delay: 3000,
                                        timer: 1000,
                                        placement: {
                                            from: "bottom",
                                            align: "left"
                                        },
                                        animate: {
                                            enter: 'animated fadeInDown',
                                            exit: 'animated fadeOutUp'
                                        }
                                    });
                                    pnlTablero.find('#Factura')[0].selectize.focus();
                                } else {//NO TIENE DOCUMENTOS PENDIENTES DE PAGO
                                    $.notify({
                                        // options
                                        icon: 'fa fa-exclamation',
                                        title: 'Atención',
                                        message: 'PROVEEDOR NO TIENE DOCUMENTOS PENDIENTES DE PAGO'
                                    }, {
                                        // settings
                                        type: 'danger',
                                        allow_dismiss: true,
                                        newest_on_top: false,
                                        showProgressbar: false,
                                        delay: 3000,
                                        timer: 1000,
                                        placement: {
                                            from: "bottom",
                                            align: "left"
                                        },
                                        animate: {
                                            enter: 'animated fadeInDown',
                                            exit: 'animated fadeOutUp'
                                        }
                                    });
                                    pnlTablero.find('#iProveedor').focus();
                                }
                            }).fail(function (x, y, z) {
                                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                                console.log(x.responseText);
                            });
                        } else {
                            swal('ERROR', 'EL PROVEEDOR NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sProveedor")[0].selectize.clear(true);
                                pnlTablero.find('#iProveedor').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sProveedor").change(function () {
            if ($(this).val()) {
                var tp = pnlTablero.find("#TpPago").val();
                pnlTablero.find('#iProveedor').val($(this).val());
                $.getJSON(master_url + 'getDocumentosByTpByProveedor', {
                    Tp: tp,
                    Proveedor: $(this).val()
                }).done(function (data) {
                    pnlTablero.find("#Factura")[0].selectize.clear(true);
                    pnlTablero.find("#Factura")[0].selectize.clearOptions();
                    if (data.length > 0) {//Existe
                        $.each(data, function (k, v) {
                            pnlTablero.find("#Factura")[0].selectize.addOption({text: v.Doc + ' ----> [' + v.FechaDoc + ']', value: v.Doc});
                        });
                        $.notify({
                            // options
                            icon: 'fa fa-check',
                            title: '',
                            message: 'DOCUMENTOS PENDIENTES CARGADOS'
                        }, {
                            // settings
                            type: 'success',
                            allow_dismiss: true,
                            newest_on_top: false,
                            showProgressbar: false,
                            delay: 3000,
                            timer: 1000,
                            placement: {
                                from: "bottom",
                                align: "left"
                            },
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                        pnlTablero.find('#Factura')[0].selectize.focus();
                    } else {//NO TIENE DOCUMENTOS PENDIENTES DE PAGO
                        $.notify({
                            // options
                            icon: 'fa fa-exclamation',
                            title: 'Atención',
                            message: 'PROVEEDOR NO TIENE DOCUMENTOS PENDIENTES DE PAGO'
                        }, {
                            // settings
                            type: 'danger',
                            allow_dismiss: true,
                            newest_on_top: false,
                            showProgressbar: false,
                            delay: 3000,
                            timer: 1000,
                            placement: {
                                from: "bottom",
                                align: "left"
                            },
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                        pnlTablero.find('#iProveedor').focus();
                    }
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });
        pnlTablero.find("#Factura").change(function () {
            if ($(this).val()) {
                var tp = pnlTablero.find("#TpPago").val();
                var prov = pnlTablero.find("#iProveedor").val();
                onVerificarExisteDocumento($(this), tp, prov);
            }
        });
        pnlTablero.find("#Fecha").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    pnlTablero.find("#Importe").focus().select();
                }
            }
        });
        pnlTablero.find("#Importe").keypress(function (e) {
            if (e.keyCode === 13) {
                var importe = parseFloat($(this).val());
                if (importe) {
                    var saldo = parseFloat(pnlTablero.find('#Saldo_Doc').val());
                    if (parseFloat(importe) > saldo) {
                        swal({//No Existe
                            title: "ATENCIÓN",
                            text: "IMPORTE A LIQUIDAR ES MAYOR AL DEL DOCUMENTO",
                            icon: "error"
                        }).then((value) => {
                            pnlTablero.find("#Importe").val('').focus();
                        });
                    } else {
                        pnlTablero.find("#TipoPago")[0].selectize.open();
                        pnlTablero.find("#TipoPago")[0].selectize.focus();
                    }
                }
            }
        });
        pnlTablero.find("#TipoPago").change(function () {
            if ($(this).val()) {
                switch (parseInt($(this).val())) {
                    case 1:
                        pnlTablero.find("#sBanco")[0].selectize.disable();
                        pnlTablero.find("#DocPago").val('Efectivo');
                        btnGuardar.focus();
                        break;
                    case 2:
                        pnlTablero.find("#sBanco")[0].selectize.enable();
                        pnlTablero.find("#DocPago").val('Transf-').focus();
                        break;
                    case 3:
                        pnlTablero.find("#sBanco")[0].selectize.enable();
                        pnlTablero.find("#DocPago").val('Che-').focus();
                        break;
                    case 4:
                        pnlTablero.find("#sBanco")[0].selectize.disable();
                        pnlTablero.find("#DocPago").focus();
                        break;
                    case 5:
                        pnlTablero.find("#sBanco")[0].selectize.disable();
                        pnlTablero.find("#DocPago").focus();
                        break;
                    case 6:
                        pnlTablero.find("#sBanco")[0].selectize.disable();
                        pnlTablero.find("#DocPago").focus();
                        break;
                }
            }
        });
        pnlTablero.find("#DocPago").keypress(function (e) {
            if (e.keyCode === 13) {
                var ref = ($(this).val());
                if (ref) {
                    pnlTablero.find("#Banco").focus();
                }
            }
        });
        pnlTablero.find('#Banco').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtbco = $(this).val();
                if (txtbco) {
                    var tp = pnlTablero.find("#TpPago").val();
                    $.getJSON(master_url + 'onVerificarBanco', {Banco: txtbco, Tp: tp}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sBanco")[0].selectize.addItem(txtbco, true);
                            btnGuardar.focus();
                        } else {
                            swal('ERROR', 'EL BANCO NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sBanco")[0].selectize.clear(true);
                                pnlTablero.find('#Banco').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sBanco").change(function () {
            if ($(this).val()) {
                pnlTablero.find('#Banco').val($(this).val());
                btnGuardar.focus();
            }
        });
        btnGuardar.click(function () {
            btnGuardar.attr('disabled', true);
            isValid('pnlTablero');
            if (valido) {
                swal({
                    buttons: ["Cancelar", "Aceptar"],
                    title: 'Estás Seguro?',
                    text: "Esta acción no se puede revertir",
                    icon: "warning",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {
                        var tp = pnlTablero.find("#TpPago").val();
                        var prov = pnlTablero.find("#iProveedor").val();
                        var fact = pnlTablero.find('#Factura').val();
                        var fecPago = pnlTablero.find('#Fecha').val();
                        var importe = pnlTablero.find("#Importe").val();
                        var TipoPago = pnlTablero.find("#TipoPago").val();
                        var docPago = pnlTablero.find("#DocPago").val();
                        var banco = pnlTablero.find("#Banco").val();
                        $.post(master_url + 'onAgregar', {

                            Tp: tp,
                            Proveedor: prov,
                            Factura: fact,
                            Fecha: fecPago,
                            Importe: importe,
                            TipoPago: TipoPago,
                            DocPago: docPago,
                            Banco: banco
                        }).done(function (data) {
                            btnGuardar.attr('disabled', false);
                            swal({//No Existe
                                title: "ATENCIÓN",
                                text: "PAGO REGISTRADO EXITOSAMENTE",
                                icon: "success"
                            }).then((value) => {
                                init();
                            });

                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        });
                    }
                });
            } else {
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
            }

        });


        /*********************** PARA REPORTE ******/
        validacionSelectPorContenedor(mdlEstadoCuentaProveedor);
        setFocusSelectToInputOnChange('#aProveedor', '#btnImprimir', mdlEstadoCuentaProveedor);
        handleEnterDiv(mdlEstadoCuentaProveedor);
        $('#btnImprimirEdoCtaProveedor').click(function () {
            mdlEstadoCuentaProveedor.modal('show');
        });

        mdlEstadoCuentaProveedor.find("#Tp").change(function () {
            onVerificarTpPagosProv($(this));
        });

        mdlEstadoCuentaProveedor.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});

            var frm = new FormData(mdlEstadoCuentaProveedor.find("#frmEdoCta")[0]);
            var desgloce = mdlEstadoCuentaProveedor.find("#Desglosado")[0].checked ? '1' : '0';
            var reporte = '';
            if (desgloce === '1') {
                reporte = 'onReporteEdosCuentaDesgloce';
            } else {
                reporte = 'onReporteEdosCuenta';
            }

            $.ajax({
                url: master_url_remota + reporte,
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
                        text: "NO EXISTEN DOCUMENTOS PARA ESTE PROVEEDOR",
                        icon: "error"
                    }).then((action) => {
                        mdlEstadoCuentaProveedor.find('#Tp').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        mdlEstadoCuentaProveedor.on('shown.bs.modal', function () {
            mdlEstadoCuentaProveedor.find("input").val("");
            $.each(mdlEstadoCuentaProveedor.find("select"), function (k, v) {
                mdlEstadoCuentaProveedor.find("select")[k].selectize.clear(true);
            });
            getProveedoresModalEdoCta();
            mdlEstadoCuentaProveedor.find('#Tp').focus();
        });
    });
    function init() {
        disableFieldsDetalle();
        enableFieldsEncabezado();
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#Fecha").val(getToday());
        pnlTablero.find("#TpPago").focus();
    }
    function getBancos(tp) {
        $.getJSON(master_url + 'getBancos', {Tp: tp}).done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sBanco")[0].selectize.addOption({text: v.Banco, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function onVerificarExisteDocumento(v, tp, prov) {
        $.getJSON(master_url + 'onVerificarExisteDocumento', {
            Doc: $(v).val(),
            Tp: tp,
            Proveedor: prov
        }).done(function (data) {
            if (data.length > 0) {//Existe
                if (parseFloat(data[0].Pagos_Doc) >= parseFloat(data[0].ImporteDoc)) { //Si la  factura ya fue pagada
                    swal({//No Existe
                        title: "ATENCIÓN",
                        text: "LA FACTURA YA FUE SALDADA, IMPOSIBLE CAPTURAR PAGO",
                        icon: "warning"
                    }).then((value) => {
                        init();
                    });
                } else {
                    pnlTablero.find('#FechaDoc').val(data[0].FechaDoc);
                    pnlTablero.find('#ImporteDoc').val(data[0].ImporteDoc);
                    pnlTablero.find('#Pagos_Doc').val(data[0].Pagos_Doc);
                    pnlTablero.find('#Saldo_Doc').val(data[0].Saldo_Doc);
                    pnlTablero.find('#Dias').val(data[0].Dias);
                    enableFieldsDetalle();
                    disableFieldsEncabezado();
                    $('#Detalle').find("#sBanco")[0].selectize.disable();
                    pnlTablero.find('#Fecha').focus();
                }
            } else {//EL DOCUMENTO NO EXISTE
                swal({//No Existe
                    title: "ATENCIÓN",
                    text: "NO EXISTE DOCUMENTO CON ESTOS DATOS",
                    icon: "warning"
                }).then((value) => {
                    $(v).val('').focus();
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function onVerificarTpPagosProv(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            getProveedoresPagosProv(tp);

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
    function getProveedoresPagosProv(tp) {
        pnlTablero.find("#sProveedor")[0].selectize.clear(true);
        pnlTablero.find("#sProveedor")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sProveedor")[0].selectize.addOption({text: (tp === 1) ? v.ProveedorF : v.ProveedorI, value: v.ID});
            });
            pnlTablero.find('#iProveedor').focus();
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function disableFieldsDetalle() {
        $.each($('#Detalle').find("select"), function (k, v) {
            $('#Detalle').find("select")[k].selectize.disable();
        });
        $('#Detalle').find("input").prop("readonly", true);
    }
    function enableFieldsDetalle() {
        $.each($('#Detalle').find("select"), function (k, v) {
            $('#Detalle').find("select")[k].selectize.enable();
        });
        $('#Detalle').find("input").prop("readonly", false);
    }
    function disableFieldsEncabezado() {
        $.each($('#Encabezado').find("select"), function (k, v) {
            $('#Encabezado').find("select")[k].selectize.disable();
        });
        $('#Encabezado').find("input").prop("readonly", true);
    }
    function enableFieldsEncabezado() {
        $.each($('#Encabezado').find("select"), function (k, v) {
            $('#Encabezado').find("select")[k].selectize.enable();
        });
        $('#Encabezado').find("input").prop("readonly", false);
    }

    /*Prov para reporte*/
    function getProveedoresModalEdoCta() {
        mdlEstadoCuentaProveedor.find("#Proveedor")[0].selectize.clear(true);
        mdlEstadoCuentaProveedor.find("#Proveedor")[0].selectize.clearOptions();
        $.getJSON(master_url_remota + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                mdlEstadoCuentaProveedor.find("#Proveedor")[0].selectize.addOption({text: v.ProveedorF, value: v.ID});
                mdlEstadoCuentaProveedor.find("#aProveedor")[0].selectize.addOption({text: v.ProveedorF, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
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

    td span.badge{
        font-size: 100% !important;
    }
</style>
