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
                <input type="text" class="form-control form-control-sm  numbersOnly captura" id="Tp" maxlength="1" required="">
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                <label for="" >Proveedor</label>
                <select id="Proveedor" name="Proveedor" class="form-control form-control-sm required captura" required="" >
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
            <div class="col-12 col-sm-5 col-md-3 col-xl-2">
                <label for="" >Banco</label>
                <select id="Banco" name="Banco" class="form-control form-control-sm" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary captura" id="btnGuardar" data-toggle="tooltip" data-placement="right" title="Capturar Documento">
                    <i class="fa fa-save"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<script>     var master_url = base_url + 'index.php/PagosProveedores/';
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToSelectOnChange('#Proveedor', '#Factura', pnlTablero);
        setFocusSelectToInputOnChange('#TipoPago', '#DocPago', pnlTablero);
        setFocusSelectToInputOnChange('#Banco', '#btnGuardar', pnlTablero);
        handleEnter();
        init();
        pnlTablero.find("#Tp").change(function () {
            pnlTablero.find("#Banco")[0].selectize.clear(true);
            pnlTablero.find("#Banco")[0].selectize.clearOptions();
            onVerificarTp($(this));
            getBancos($(this).val());
        });
        pnlTablero.find("#Proveedor").change(function () {
            var tp = pnlTablero.find("#Tp").val();
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
                }
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });
        });
        pnlTablero.find("#Factura").change(function () {
            var tp = pnlTablero.find("#Tp").val();
            var prov = pnlTablero.find("#Proveedor").val();
            onVerificarExisteDocumento($(this), tp, prov);
        });
        pnlTablero.find("#Importe").change(function () {
            var importe = parseFloat($(this).val());
            var saldo = parseFloat(pnlTablero.find('#Saldo_Doc').val());
            if (importe > saldo) {
                swal({//No Existe
                    title: "IMPORTE A LIQUIDAR ES MAYOR AL DEL DOCUMENTO",
                    text: "ERROR",
                    icon: "error"
                }).then((value) => {
                    $(this).val('').focus();
                });
            }
        });
        pnlTablero.find("#TipoPago").change(function () {
            switch (parseInt($(this).val())) {
                case 1:
                    pnlTablero.find("#Banco")[0].selectize.disable();
                    pnlTablero.find("#DocPago").val('Efectivo');
                    btnGuardar.focus();
                    break;
                case 2:
                    pnlTablero.find("#Banco")[0].selectize.enable();
                    pnlTablero.find("#DocPago").val('Transf-').focus();
                    break;
                case 3:
                    pnlTablero.find("#Banco")[0].selectize.enable();
                    pnlTablero.find("#DocPago").val('Che-').focus();
                    break;
                case 4:
                    pnlTablero.find("#Banco")[0].selectize.disable();
                    pnlTablero.find("#DocPago").focus();
                    break;
                case 5:
                    pnlTablero.find("#Banco")[0].selectize.disable();
                    pnlTablero.find("#DocPago").focus();
                    break;
                case 6:
                    pnlTablero.find("#Banco")[0].selectize.disable();
                    pnlTablero.find("#DocPago").focus();
                    break;
            }
        });
        btnGuardar.click(function () {
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
                        var tp = pnlTablero.find("#Tp").val();
                        var prov = pnlTablero.find("#Proveedor").val();
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
                            swal({//No Existe
                                title: "OPERACIÓN EXITOSA",
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
    });
    function init() {
        disableFieldsDetalle();
        enableFieldsEncabezado();
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#Fecha").val(getToday());
        pnlTablero.find("#Tp").focus();
    }
    function getBancos(tp) {
        $.getJSON(master_url + 'getBancos', {Tp: tp}).done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Banco")[0].selectize.addOption({text: v.Banco, value: v.ID});
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
                    $('#Detalle').find("#Banco")[0].selectize.disable();
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
    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            pnlTablero.find('#Proveedor')[0].selectize.focus();
            getProveedores(tp);
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
    function getProveedores(tp) {
        pnlTablero.find("#Proveedor")[0].selectize.clear(true);
        pnlTablero.find("#Proveedor")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Proveedor")[0].selectize.addOption({text: (tp === 1) ? v.ProveedorF : v.ProveedorI, value: v.ID});
            });
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

    td span.badge{
        font-size: 100% !important;
    }
</style>
