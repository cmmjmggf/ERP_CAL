<div class="card m-3 animated fadeIn bg-danger">
    <div class="card-body ">
        <div class="row">
            <div class="col-12 float-left">
                <label class="float-left  text-white" style="font-size: 16px;">
                    IMPORTANTE: <br>Sí el documento no fue timbrado por el sistema,
                    sólo se cancelará la factura de manera interna,
                    sin realizar la cancelación ante el SAT, y sólo se timbrará la NOTA DE CRÉDITO</label>
            </div>
        </div>
    </div>
</div>

<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Cancela Documentos de Venta/Facturación con Nota de Crédito</legend>
            </div>
            <div class="col-sm-4" align="right">

            </div>
        </div>
        <hr>
        <div class="row mb-2">
            <div class="col-12 form-inline">
                <div class="form-group">
                    <div class="custom-control custom-radio mr-2">
                        <input type="radio" id="rXProduccion" name="CancelaDocsVentas" class="custom-control-input" checked="" tipo ="1">
                        <label class="custom-control-label text-success" for="rXProduccion">Por producción</label>
                    </div>
                    <div class="custom-control custom-radio mr-2">
                        <input type="radio" id="rXDevolucion" name="CancelaDocsVentas" class="custom-control-input" tipo ="2">
                        <label class="custom-control-label text-danger" for="rXDevolucion">Por devoluciones</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="rXFlete" name="CancelaDocsVentas" class="custom-control-input" tipo ="3">
                        <label class="custom-control-label text-info" for="rXFlete">Por flete</label>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div id="pnlDatos">
            <form id="frmCapturaCancelaDctoVta">
                <div class="row">
                    <div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                        <label>Cliente</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Cliente" name="Cliente" maxlength="5" required="">
                    </div>
                    <div class="col-7 col-sm-5 col-md-5 col-xl-3" >
                        <label for="" >--</label>
                        <select id="sCliente" name="sCliente" class="form-control form-control-sm required NotSelectize" required="" >
                            <option value=""></option>
                            <?php
                            foreach ($this->db->select("C.Clave AS CLAVE, C.RazonS AS CLIENTE ", false)
                                    ->from('CLIENTES AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('CLIENTE', 'ASC')->get()->result() as $k => $v) {
                                print "<option value='{$v->CLAVE}'>{$v->CLIENTE}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                        <label>Docto</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Doc" name="Doc" readonly="" maxlength="8" required="">
                    </div>
                    <div class="col-7 col-sm-5 col-md-3 col-xl-2" >
                        <label for="" >--</label>
                        <select id="sDoc" name="sDoc" class="form-control form-control-sm required NotSelectize" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-2 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                        <label>Tp</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly " readonly="" id="Tp" name="Tp" maxlength="1" required="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                        <label>N.C.</label>
                        <input type="text" class="form-control form-control-sm numbersOnly" id="NC" name="NC" readonly="" required="">
                    </div>

                    <div class="col-7 col-sm-5 col-md-3 col-xl-2" >
                        <label for="" >Moneda</label>
                        <select id="Moneda" name="Moneda" class="form-control form-control-sm " >
                            <option value=""></option>
                            <option value="0">PESOS</option>
                            <option value="2">DOLAR</option>
                            <option value="3">EURO</option>
                            <option value="4">LIBRA</option>
                            <option value="5">JEN</option>
                        </select>
                    </div>
                    <div class="col-2 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                        <label>T.C.</label>
                        <input type="text" class="form-control form-control-sm numbersOnly" id="TipoCambio" name="TipoCambio" maxlength="5" required="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-8 col-sm-7 col-md-7 col-lg-4 col-xl-4" >
                        <label>Concepto</label>
                        <input type="text" class="form-control form-control-sm " id="Concepto" name="Concepto" maxlength="50" required="" >
                    </div>
                    <div class="col-4 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4">
                        <button type="button" class="btn btn-primary btn-sm" id="btnAceptar">
                            <i class="fa fa-check"></i> CANCELAR
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/CancelaDocumentosVentaCobranza/';
    var tblDepositosClientes = $('#tblDepositosClientes');
    var DepositosClientes;
    var pnlTablero = $("#pnlTablero");
    var btnAceptar = pnlTablero.find('#btnAceptar');
    var remi = 0;
    $(document).ready(function () {
        /*BOTONES*/
        init();

        pnlTablero.find("input[name='CancelaDocsVentas']").change(function () {
            pnlTablero.find('#Cliente').focus().select();
        });
        pnlTablero.find("#btnImprimir").click(function () {
            var fecha = pnlTablero.find("#FechaDoc");
            if (fecha.val()) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData();
                frm.append('Fecha', fecha.val());
                $.ajax({
                    url: base_url + 'index.php/CapturaDepositosCliente/onImprimirDepositoClientes',
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
                            text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                            icon: "error"
                        }).then((action) => {
                            fecha.focus();
                        });
                    }
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "CAPTURE LA FECHA PARA IMPRIMIR EL REPORTE",
                    icon: "warning"
                }).then((value) => {
                    fecha.focus();
                });
            }
        });
        pnlTablero.find('#Cliente').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    tipo = 0;
                    remi = 0;
                    status = 0;
                    mes = 0;
                    mes_act;
                    pnlTablero.find('#Doc').val('');
                    $.getJSON(master_url + 'onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sCliente")[0].selectize.addItem(txtcte, true);
                            getDocumentosByCliente(txtcte);
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find('#Cliente').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find('#sCliente').change(function () {
            if ($(this).val()) {
                tipo = 0;
                remi = 0;
                status = 0;
                mes = 0;
                mes_act;
                pnlTablero.find('#Doc').val('');
                pnlTablero.find('#Cliente').val($(this).val());
                getDocumentosByCliente($(this).val());

            }
        });
        pnlTablero.find('#sDoc').change(function () {
            if ($(this).val()) {
                pnlTablero.find('#Doc').val($(this).val());
                var cte = pnlTablero.find('#Cliente').val();
                onVerificarExisteDocumento(cte, $(this).val());
            }
        });
        pnlTablero.find('#Concepto').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcon = $(this).val();
                if (txtcon) {
                    btnAceptar.focus();
                }
            }
        });
        /*Tipo de Cambio*/
        pnlTablero.find("#Moneda").change(function () {
            if ($(this).val()) {
                getTipoCambio($(this).val());
            }
        });
        pnlTablero.find('#TipoCambio').keypress(function (e) {
            if (e.keyCode === 13) {
                var txttc = $(this).val();
                if (txttc) {
                    pnlTablero.find('#Concepto').focus().select();
                }
            }
        });

        btnAceptar.click(function () {
            isValid('pnlDatos');
            if (valido) {
                onOpenOverlay('Cancelando Documento...');
                var frm = new FormData(pnlTablero.find("#frmCapturaCancelaDctoVta")[0]);
                var tipo = $("input[name='CancelaDocsVentas']:checked").attr('tipo');
                frm.append('Tipo', tipo);
                $.ajax({
                    url: master_url + 'onCancelarDocto',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    if (parseInt(data) === 3) {
                        swal('ATENCIÓN', 'EL DOCUMENTO YA FUE CANCELADO', 'warning').then((value) => {
                            pnlTablero.find('#Doc').val('');
                            pnlTablero.find("#Tp").val('');
                            pnlTablero.find("#NC").val('');
                            pnlTablero.find("#Concepto").val('');
                            pnlTablero.find("#sDoc")[0].selectize.clear(true);
                            pnlTablero.find("#sDoc")[0].selectize.focus();
                        });
                    } else if (parseInt(data) === 5) {
                        swal('NO CANCELADO EN EL SAT', 'Existe un error en la generación de la factura electronica no se encuentra el uuid', 'error').then((value) => {
                            init();
                        });
                    } else {
                        swal('CANCELACIÓN CORRECTA', 'El documento se ha cancelado correctamente', 'success').then((value) => {
                            init();
                        });
                    }
                    onCloseOverlay();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });

            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });
    });
    function init() {
        /*FUNCIONES INICIALES*/
        pnlTablero.find("#Cliente").focus();
        tipo = 0;
        remi = 0;
        status = 0;
        mes = 0;
        mes_act;
        pnlTablero.find("input").val("");
        pnlTablero.find("select").selectize({
            hideSelected: false,
            openOnFocus: false
        });
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#Moneda")[0].selectize.addItem('0', true);
        pnlTablero.find("#TipoCambio").val('1');

    }
    var tipo, remi, importe, status, mes, mes_act;
    function onVerificarExisteDocumento(cte, remicion) {
        $.getJSON(master_url + 'onVerificarExisteDocumento', {
            Remicion: remicion,
            Cliente: cte
        }).done(function (data) {
            if (data.length > 0) {
                tipo = data[0].tipo;
                remi = data[0].remicion;
                status = data[0].status;

                if (parseInt(status) > 2) {
                    swal('ATENCIÓN', 'DOCUMENTO CON PAGOS, IMPOSIBLE MODIFICAR', 'warning').then((value) => {
                        pnlTablero.find('#Doc').val('');
                        pnlTablero.find("#Tp").val('');
                        pnlTablero.find("#NC").val('');
                        pnlTablero.find("#sDoc")[0].selectize.clear(true);
                        pnlTablero.find("#sDoc")[0].selectize.focus();
                    });
                    return;
                }
                if (parseInt(tipo) === 1) {
                    $.getJSON(master_url + 'getFolioNCFiscal').done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find('#NC').val(data[0].nc);
                        } else {
                            pnlTablero.find('#NC').val(1);
                        }
                    });
                }
                if (parseInt(tipo) === 2) {
                    $.getJSON(master_url + 'getFolioNC').done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find('#NC').val(data[0].nc);
                        } else {
                            pnlTablero.find('#NC').val(1);
                        }
                    });
                }
                //Verifica si tiene pagos anticipados
                $.getJSON(master_url + 'onVerificarExistenPagos', {
                    Remicion: remicion,
                    Cliente: cte,
                    Tp: data[0].tipo
                }).done(function (data) {
                    if (parseFloat(data[0].pagos) > 0) {
                        swal('ATENCIÓN', 'NO ES POSIBLE CANCELAR EL DOCUMENTO, TIENE PAGOS ANTICIPADOS', 'warning').then((value) => {
                            pnlTablero.find('#Doc').val('');
                            pnlTablero.find("#Tp").val('');
                            pnlTablero.find("#NC").val('');
                            pnlTablero.find("#sDoc")[0].selectize.clear(true);
                            pnlTablero.find("#sDoc")[0].selectize.focus();
                        });
                        return;
                    }
                    pnlTablero.find("#Concepto").focus().select();
                });

                pnlTablero.find("#Tp").val(data[0].tipo);

            } else {//EL DOCUMENTO NO EXISTE
                swal({
                    title: "ATENCIÓN",
                    text: "NO EXISTE DOCUMENTO",
                    icon: "warning"
                }).then((value) => {
                    pnlTablero.find("#sDoc")[0].selectize.clear(true);
                    pnlTablero.find("#sDoc")[0].selectize.focus();
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getDocumentosByCliente(cte) {
        pnlTablero.find("#sDoc")[0].selectize.clear(true);
        pnlTablero.find("#sDoc")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getDocumentosByCliente', {Cliente: cte}).done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sDoc")[0].selectize.addOption({text: v.documento, value: v.remicion});
            });
            pnlTablero.find("#sDoc")[0].selectize.focus();
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getTipoCambio(mnda) {
        $.getJSON(base_url + 'index.php/DocDirecSinAfectacion/getTipoCambio').done(function (data) {
            if (data.length > 0) {
                switch (mnda) {
                    case '0':
                        pnlTablero.find('#TipoCambio').val(1).focus().select();
                        break;
                    case '2':
                        pnlTablero.find('#TipoCambio').val(data[0].Dolar).focus().select();
                        break;
                    case '3':
                        pnlTablero.find('#TipoCambio').val(data[0].Euro).focus().select();
                        break;
                    case '4':
                        pnlTablero.find('#TipoCambio').val(data[0].Libra).focus().select();
                        break;
                    case '5':
                        pnlTablero.find('#TipoCambio').val(data[0].Jen).focus().select();
                        break;
                    default:
                        pnlTablero.find('#TipoCambio').val(1).focus().select();
                }
            }
        }).fail(function (x, y, z) {
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
<?php

