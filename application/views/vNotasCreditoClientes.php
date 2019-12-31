<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Nota de crédito: <span class="text-info text-strong" id ="FolioNC"></span></legend>
            </div>
            <div class="col-sm-6" align="right">
                <button type="button" class="btn btn-primary btn-sm " id="btnVerMovimientos" >
                    <span class="fa fa-dollar-sign" ></span> MOVIMIENTOS
                </button>
                <button type="button" class="btn btn-danger btn-sm " id="btnImprimir" >
                    <span class="fa fa-file-pdf" ></span> RE-IMPRIME NOTA DE CRÉDITO
                </button>
            </div>
        </div>
        <hr>
        <!--Datos-->
        <div class="row">
            <div class="col-12 col-sm-5 col-md-2 col-lg-1 col-xl-1">
                <label for="Cliente" >Cliente</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="Cliente" name="Cliente" required="" placeholder="">
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                <label for="" >-</label>
                <select id="sCliente" class="form-control form-control-sm required NotSelectize" >
                    <option value=""></option>
                    <?php
                    $clientesPnl = $this->db->query("SELECT C.Clave AS CLAVE, C.RazonS AS CLIENTE FROM clientes AS C WHERE C.Estatus IN('ACTIVO') ORDER BY C.RazonS ASC;")->result();
                    foreach ($clientesPnl as $k => $v) {
                        print "<option value=\"{$v->CLAVE}\">{$v->CLIENTE}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Tp" name="Tp" maxlength="1" required="">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                <label>Docto</label>
                <input type="text" class="form-control form-control-sm numbersOnly " id="Docto" name="Docto" required="">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                <label>Fecha</label>
                <input type="text" class="form-control form-control-sm verde" id="FechaDoc" name="FechaDoc" readonly="" required="">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Importe</label>
                <input type="text" class="form-control form-control-sm azul" id="Importe" name="Importe" readonly="" required="">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Pagos</label>
                <input type="text" class="form-control form-control-sm azul" id="Pagos" name="Pagos" readonly="" required="">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Saldo</label>
                <input type="text" class="form-control form-control-sm azul" id="Saldo" name="Saldo" readonly="" required="">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-6 col-sm-2 col-md-4 col-lg-2 col-xl-2" >
                <label for="" >Tipo <span class="badge badge-danger" style="font-size: 14px;">5=Desc.  7=Dif.Pre  9=Otros</span></label>
                <select id="Tipo" name="Tipo" class="form-control form-control-sm NotSelectize" >
                    <option value=""></option>
                    <option value="5">5 Descuentos</option>
                    <option value="7">7 Diferencia de Precios</option>
                    <option value="9">9 Otros</option>
                </select>
            </div>
            <div class="col-7 col-sm-5 col-md-3 col-xl-2" >
                <label for="" >Moneda <span class="badge badge-danger" style="font-size: 14px;">1=Pesos  2=Dolar</span></label>
                <select id="Moneda" name="Moneda" class="form-control form-control-sm " >
                    <option value=""></option>
                    <option value="0">1 PESOS</option>
                    <option value="2">2 DOLAR</option>
                    <option value="3">3 EURO</option>
                    <option value="4">4 LIBRA</option>
                    <option value="5">5 JEN</option>
                </select>
            </div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                <label>T.C.</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="TipoCambio" name="TipoCambio" maxlength="5" required="">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Fecha Cap</label>
                <input type="text" class="form-control form-control-sm date notEnter" id="fechacap" name="fechacap"  required="">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Fecha Dep</label>
                <input type="text" class="form-control form-control-sm date notEnter" id="fechadep" name="fechadep"  required="">
            </div>
            <div class="col-12 col-sm-2 col-md-6 col-lg-7 col-xl-3">
                <label>UUID</label>
                <input type="text" class="form-control form-control-sm azul" id="UUID" name="UUID" readonly="">
            </div>
            <div class="w-100"></div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Importe NC</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="ImporteNC" name="ImporteNC" required="">
            </div>
            <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-3">
                <label>Concepto</label>
                <input type="text" class="form-control form-control-sm" id="Concepto" name="Concepto" required="">
            </div>
            <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-2 d-none" id="dDefecto">
                <label for="" >Defecto</label>
                <select id="Defecto" name="Defecto" class="form-control form-control-sm" >
                    <option value=""></option>
                    <?php
                    $defectos = $this->db->query("SELECT C.Clave AS CLAVE, concat(c.clave,'-',C.Descripcion) AS DESCRIPCION FROM defectos AS C WHERE C.Estatus IN('ACTIVO') ORDER BY abs(C.Clave) ASC;")->result();
                    foreach ($defectos as $k => $v) {
                        print "<option value=\"{$v->CLAVE}\">{$v->DESCRIPCION}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-2 d-none" id="dDetalle">
                <label for="" >Detalle</label>
                <select id="DetalleDefecto" name="DetalleDefecto" class="form-control form-control-sm">
                    <option value=""></option>
                    <?php
                    $detalle = $this->db->query("SELECT C.Clave AS CLAVE, concat(c.clave,'-',C.Descripcion) AS DESCRIPCION FROM defectosdetalle AS C WHERE C.Estatus IN('ACTIVO') ORDER BY abs(C.Clave) ASC;")->result();
                    foreach ($detalle as $k => $v) {
                        print "<option value=\"{$v->CLAVE}\">{$v->DESCRIPCION}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3 d-sm-block pt-4">
                <button type="button" id="btnAceptar" class="btn btn-primary btn-sm ">
                    <span class="fa fa-save"></span> ACEPTAR
                </button>
                <button type="button" class="btn btn-success btn-sm " id="btnCerrarNotaCredito" >
                    <span class="fa fa-check" ></span> CERRAR NOTA DE CRÉDITO
                </button>
            </div>
        </div>
        <hr>
        <div class="row">
            <!--Primer tabla-->
            <div class="col-6 mt-1" >
                <label>Documentos con saldo del cliente</label>
                <div class="card-block">
                    <div id="DoctosCliente" class="datatable-wide">
                        <table id="tblDoctosCliente" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Docto</th>
                                    <th>Tp</th>
                                    <th>Fecha</th>
                                    <th>Importe</th>
                                    <th>Pagos</th>
                                    <th>Saldo</th>
                                    <th>Estatus</th>
                                    <th>Días</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--segunda tabla-->
            <div class="col-6 mt-1" >
                <label>Detalle Nota Crédito</label>
                <div class="card-block ">
                    <div id="DetalleNC">
                        <table id="tblDetalleNC" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr>
                                    <th>N.C.</th>
                                    <th>Cliente</th>
                                    <th>Docto</th>
                                    <th>Mov</th>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Importe</th>
                                    <th>Subtotal</th>
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

<script>
    var master_url = base_url + 'index.php/NotasCreditoClientes/';
    var tblDoctosCliente = $('#tblDoctosCliente');
    var DoctosCliente;
    var tblDetalleNC = $('#tblDetalleNC');
    var DetalleNC;
    var pnlTablero = $("#pnlTablero");
    var btnImprimir = pnlTablero.find('#btnImprimir');
    var btnAceptar = pnlTablero.find('#btnAceptar');
    var btnCerrarNotaCredito = pnlTablero.find('#btnCerrarNotaCredito');
    var txtcondcte, txtagente, txtcondi, ctipo, notcred, totalFinal, nuevo;

    function init() {
        /*FUNCIONES INICIALES*/
        pnlTablero.find("input").val("");
        pnlTablero.find("select").selectize({
            hideSelected: false,
            openOnFocus: false
        });
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#FolioNC").html('');
        txtcondcte = 0;
        txtagente = 0;
        txtcondi = 0;
        notcred = 0;
        totalFinal = 0;
        nuevo = 1;
        ctipo = false;
        getRecords(0);
        getDetalleNC(0, 0, 0);
        pnlTablero.find("#fechacap").val(getToday());
        pnlTablero.find("#fechadep").val(getToday());
        pnlTablero.find("#Cliente").focus();
    }

    $(document).ready(function () {
        init();
        pnlTablero.find('#Cliente').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtCliente = $(this).val();
                if (txtCliente) {
                    $.getJSON(master_url + 'onVerificarCliente', {Cliente: txtCliente}).done(function (data) {
                        if (data.length > 0) {
                            txtcondcte = data[0].Descuento;
                            txtagente = data[0].Agente;
                            txtcondi = (parseFloat(txtcondcte) * 100) / 1;
                            getRecords(txtCliente);
                            pnlTablero.find("#sCliente")[0].selectize.addItem(txtCliente, true);
                            pnlTablero.find('#Tp').focus().select();
                        } else {
                            swal('ERROR', 'EL CLIENTE CAPTURADO NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find('#sCliente')[0].selectize.clear(true);
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
                var txtCliente = $(this).val();
                $.getJSON(master_url + 'onVerificarCliente', {Cliente: txtCliente}).done(function (data) {
                    if (data.length > 0) {
                        txtcondcte = data[0].Descuento;
                        txtagente = data[0].Agente;
                        txtcondi = (parseFloat(txtcondcte) * 100) / 1;
                        getRecords(txtCliente);
                        pnlTablero.find('#Cliente').val(txtCliente);
                        pnlTablero.find('#Tp').focus().select();
                    }
                }).fail(function (x) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });
        pnlTablero.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTp($(this));
                }
            }
        });
        pnlTablero.find('#Docto').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtDocto = $(this).val();
                var txtCliente = pnlTablero.find('#Cliente').val();
                var txtTp = pnlTablero.find('#Tp').val();
                if (txtDocto) {
                    $.getJSON(master_url + 'onVerificarDocumento', {Remicion: txtDocto, Tp: txtTp, Cliente: txtCliente}).done(function (data) {
                        if (data.length > 0) {
                            if (parseFloat(data[0].saldo) <= 0 || parseInt(data[0].status) >= 3) {
                                swal('ERROR', 'DOCUMENTO SALDADO, APLICACIÓN NO ACEPTADA', 'warning').then((value) => {
                                    pnlTablero.find('#Docto').focus().val('');
                                });
                            } else {
                                pnlTablero.find('#FechaDoc').val(data[0].fecha);
                                pnlTablero.find('#Importe').val(parseFloat(data[0].importe).toFixed(2));
                                pnlTablero.find('#Pagos').val(parseFloat(data[0].pagos).toFixed(2));
                                pnlTablero.find('#Saldo').val(parseFloat(data[0].saldo).toFixed(2));
                                pnlTablero.find('#Tipo')[0].selectize.focus();
                            }
                        } else {
                            swal('ERROR', 'EL DOCUMENTO NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find('#Docto').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                    //Si es factura trae el UUID
                    if (parseInt(txtTp) === 1) {
                        $.getJSON(master_url + 'getUUID', {Remicion: txtDocto, Tp: txtTp, Cliente: txtCliente}).done(function (data) {
                            if (data.length > 0) {
                                pnlTablero.find('#UUID').val((data[0].uuid).toUpperCase());
                            } else {
                                swal('ERROR', 'FACTURA NO TIMBRADA EN SISTEMA DE LOBO SOLO', 'warning').then((value) => {
                                    pnlTablero.find('#Docto').focus().val('');
                                });
                            }
                        }).fail(function (x) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x.responseText);
                        });
                    } else {
                        pnlTablero.find("#UUID").val('');
                    }
                }
            }
        });
        pnlTablero.find("#Tipo").change(function () {
            var tpomov = $(this).val();
            if (tpomov) {
                switch (tpomov) {
                    case '5':
                        pnlTablero.find('#Concepto').val('Desc.' + txtcondi + '% Nc-');
                        pnlTablero.find("#dDefecto").removeClass('d-none');
                        pnlTablero.find("#dDetalle").removeClass('d-none');
                        pnlTablero.find("#Defecto").addClass('required');
                        pnlTablero.find("#DetalleDefecto").addClass('required');
                        break;
                    case '7':
                        pnlTablero.find('#Concepto').val('Dif.pre Nc-');
                        pnlTablero.find("#dDefecto").removeClass('d-none');
                        pnlTablero.find("#dDetalle").removeClass('d-none');
                        pnlTablero.find("#Defecto").addClass('required');
                        pnlTablero.find("#DetalleDefecto").addClass('required');
                        break;
                    case '9':
                        pnlTablero.find('#Concepto').val('otros Nc-');
                        pnlTablero.find("#dDefecto").removeClass('d-none');
                        pnlTablero.find("#dDetalle").removeClass('d-none');
                        pnlTablero.find("#Defecto").addClass('required');
                        pnlTablero.find("#DetalleDefecto").addClass('required');
                        break;
                }
                ctipo = true;
                pnlTablero.find("#Moneda")[0].selectize.focus();
            } else {
                ctipo = false;
                pnlTablero.find('#Concepto').val('');
                pnlTablero.find("#dDefecto").addClass('d-none');
                pnlTablero.find("#dDetalle").addClass('d-none');
                pnlTablero.find("#Defecto").removeClass('required');
                pnlTablero.find("#DetalleDefecto").removeClass('required');
                pnlTablero.find("#Moneda")[0].selectize.focus();
            }
        });
        pnlTablero.find('.selectize-control').find('input#Tipo-selectized').on('keypress', function (e) {
            if (e.keyCode === 13) {
                pnlTablero.find("#Moneda")[0].selectize.focus();
            }
        });
        pnlTablero.find("#Moneda").change(function () {
            if ($(this).val()) {
                getTipoCambio($(this).val());
            } else {
                pnlTablero.find("#TipoCambio").focus().select();
            }
        });
        pnlTablero.find('.selectize-control').find('input#Moneda-selectized').on('keypress', function (e) {
            if (e.keyCode === 13) {
                pnlTablero.find("#TipoCambio").focus().select();
            }
        });
        pnlTablero.find('#TipoCambio').keypress(function (e) {
            if (e.keyCode === 13) {
                var txttc = $(this).val();
                if (txttc) {
                    pnlTablero.find('#fechacap').focus().select();
                }
            }
        });
        pnlTablero.find('#fechacap').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtfc = $(this).val();
                if (txtfc) {
                    pnlTablero.find('#fechadep').focus().select();
                }
            }
        });
        pnlTablero.find('#fechadep').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtfd = $(this).val();
                if (txtfd) {
                    pnlTablero.find('#ImporteNC').focus().select();
                }
            }
        });
        pnlTablero.find('#ImporteNC').keypress(function (e) {
            var tp = pnlTablero.find("#Tp").val();
            var txtsaldo = pnlTablero.find("#Saldo").val();
            var txttc = pnlTablero.find("#TipoCambio").val();
            var total = 0;
            if (e.keyCode === 13) {
                var txtimponc = $(this).val();
                if (txtimponc) {
                    if (parseFloat(txtimponc) > parseFloat(txtsaldo)) {
                        swal('ERROR', 'IMPORTE A PAGAR NO DEBE DE SER MAYOR AL SALDO DEL DOCUMENTO', 'warning').then((value) => {
                            pnlTablero.find('#ImporteNC').focus().val('');
                        });
                    } else {
                        total = txtimponc * txttc;
                        if (parseInt(tp) === 1) {
                            pnlTablero.find('#ImporteNC').val((total / 1.16).toFixed(2));
                        } else {
                            pnlTablero.find('#ImporteNC').val(total.toFixed(2));
                        }
                        pnlTablero.find('#Concepto').focus();
                    }
                }
            }
        });
        pnlTablero.find('#Concepto').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtconc = $(this).val();
                if (txtconc) {
                    if (ctipo) {
                        pnlTablero.find('#Defecto')[0].selectize.focus();
                    } else {
                        btnAceptar.focus();
                    }

                }
            }
        });
        pnlTablero.find('#Defecto').change(function () {
            var txtconc = $(this).val();
            if (txtconc) {
                pnlTablero.find('#DetalleDefecto')[0].selectize.focus();
            }
        });
        pnlTablero.find('#DetalleDefecto').change(function () {
            var txtconc = $(this).val();
            if (txtconc) {
                btnAceptar.focus();
            }
        });
        btnAceptar.click(function () {
            isValid('pnlTablero');
            if (valido) {
                var importenc = pnlTablero.find("#ImporteNC").val();
                var txtsaldo = pnlTablero.find("#Saldo").val();
                if (parseFloat(importenc) > parseFloat(txtsaldo)) {
                    swal({
                        title: "ATENCIÓN",
                        text: "IMPORTE A PAGAR NO DEBE DE SER MAYOR AL SALDO DEL DOCUMENTO",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        pnlTablero.find("#ImporteNC").val('').focus();
                    });
                } else {
                    //HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                    $.post(master_url + 'onAgregar', {
                        tp: pnlTablero.find("#Tp").val(),
                        cliente: pnlTablero.find("#Cliente").val(),
                        numfac: pnlTablero.find("#Docto").val(),
                        orden: pnlTablero.find("#Tipo").val(),
                        fecha: pnlTablero.find("#fechacap").val(),
                        descripcion: pnlTablero.find("#Concepto").val(),
                        precio: importenc,
                        subtot: importenc,
                        defecto: pnlTablero.find("#Defecto").val(),
                        detalle: pnlTablero.find("#DetalleDefecto").val(),
                        tmnda: pnlTablero.find("#Moneda").val(),
                        tcamb: pnlTablero.find("#TipoCambio").val(),
                        uuid: pnlTablero.find("#UUID").val(),
                        nuevo: nuevo,
                        folioact: notcred
                    }).done(function (data) {
                        notcred = data;
                        totalFinal += parseFloat(importenc);
                        if (nuevo === 1) {
                            getDetalleNC(pnlTablero.find("#Cliente").val(), notcred, pnlTablero.find("#Tp").val());
                        } else {
                            DetalleNC.ajax.reload();
                        }
                        nuevo = 0;
                        var conc = pnlTablero.find("#Concepto").val();
                        pnlTablero.find("#Concepto").val(conc + data);
                        pnlTablero.find("#FolioNC").html(data);
                        pnlTablero.find("#ImporteNC").val('');
                        pnlTablero.find("#Concepto").val('');
                        pnlTablero.find("#Defecto")[0].selectize.clear(true);
                        pnlTablero.find("#DetalleDefecto")[0].selectize.clear(true);
                        pnlTablero.find("#Tipo")[0].selectize.clear(true);
                        pnlTablero.find("#Tipo")[0].selectize.focus();
                        HoldOn.close();
                        onNotifyOld('fa fa-check', 'DOCUMENTO GUARDADO', 'info');

                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });
        btnCerrarNotaCredito.click(function () {
            var cliente = pnlTablero.find("#Cliente").val();
            var totalconsinivaletra = (pnlTablero.find("#Tp").val() === '1') ? totalFinal * 1.16 : totalFinal;
            if (cliente !== '' && notcred > 0) {
                swal({
                    buttons: ["Cancelar", "Aceptar"],
                    title: 'Estás Seguro?',
                    text: "Esta acción no se puede revertir",
                    icon: "warning",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {
                        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                        $.post(master_url + 'onCerrarNC', {
                            Tp: pnlTablero.find("#Tp").val(),
                            Cliente: pnlTablero.find("#Cliente").val(),
                            nc: notcred,
                            total: parseFloat(totalFinal).toFixed(2),
                            totalletra: NumeroALetras(parseFloat(totalconsinivaletra).toFixed(2)),
                            agente: txtagente,
                            fechacap: pnlTablero.find('#fechacap').val()
                        }).done(function (data) {
                            console.log(data);
                            if (pnlTablero.find("#Tp").val() === '1') {
                                /*Aquí imprime cuando ya timbremos nosotros*/
                                pnlTablero.find("#dDefecto").addClass('d-none');
                                pnlTablero.find("#dDetalle").addClass('d-none');
                                pnlTablero.find("#Defecto").removeClass('required');
                                pnlTablero.find("#DetalleDefecto").removeClass('required');
                                onNotifyOld('fa fa-check', 'NOTA DE CRÉDITO CERRADA', 'success');
                                init();
                            } else {
                                onImprimirReporteFancyAFC(data, function (a, b) {
                                    pnlTablero.find("#dDefecto").addClass('d-none');
                                    pnlTablero.find("#dDetalle").addClass('d-none');
                                    pnlTablero.find("#Defecto").removeClass('required');
                                    pnlTablero.find("#DetalleDefecto").removeClass('required');
                                    onNotifyOld('fa fa-check', 'NOTA DE CRÉDITO CERRADA', 'success');
                                    init();
                                });
                            }
                            HoldOn.close();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                            HoldOn.close();
                        });
                    }
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "NO HA CAPTURADO LA NOTA DE CRÉDITO",
                    icon: "error",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    pnlTablero.find("#Cliente").focus().select();
                });
            }

        });
        btnImprimir.click(function () {
            $('#mdlReimprimeNotaCredito').modal('show');
        });
        pnlTablero.find("#btnVerMovimientos").click(function () {
            $.fancybox.open({
                src: base_url + '/MovimientosCliente',
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
        });
    });
    function getRecords(cliente) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDoctosCliente')) {
            tblDoctosCliente.DataTable().destroy();
        }
        DoctosCliente = tblDoctosCliente.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "data": {Cliente: cliente},
                "type": "GET"
            },
            "columns": [
                {"data": "docto"},
                {"data": "tipo"},
                {"data": "fecha"},
                {"data": "importe"},
                {"data": "pagos"},
                {"data": "saldo"},
                {"data": "status"},
                {"data": "dias"}
            ],
            "columnDefs": [
                {
                    "targets": [3],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [4],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [5],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 999,
            "scrollX": true,
            "scrollY": 350,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [2, 'asc'], [0, 'asc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ENTREGA*/
                            c.addClass('text-strong');
                            break;

                        case 1:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                        case 3:
                            /*fecha conf*/
                            c.addClass('text-success text-strong');
                            break;
                        case 4:
                            /*fecha conf*/
                            c.addClass('text-strong');
                            break;
                        case 5:
                            /*fecha conf*/
                            c.addClass('text-danger text-strong');
                            break;
                        case 7:
                            /*fecha conf*/
                            c.addClass('text-warning text-strong');
                            break;
                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblDoctosCliente.find('tbody').on('click', 'tr', function () {
            tblDoctosCliente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }
    function getDetalleNC(cliente, doc, tp) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDetalleNC')) {
            tblDetalleNC.DataTable().destroy();
        }
        DetalleNC = tblDetalleNC.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getDetalleNC',
                "dataSrc": "",
                "data": {Tp: tp, Cliente: cliente, NC: doc},
                "type": "GET"
            },
            "columns": [
                {"data": "nc"},
                {"data": "cliente"},
                {"data": "numfac"},
                {"data": "orden"},
                {"data": "fecha"},
                {"data": "descripcion"},
                {"data": "precio"},
                {"data": "subtot"}
            ],
            "columnDefs": [
                {
                    "targets": [6, 7],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 999,
            "scrollX": true,
            "scrollY": 350,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [4, 'desc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 1:
                            /*FECHA ENTREGA*/
                            c.addClass('text-strong');
                            break;

                        case 2:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                        case 6:
                            /*fecha conf*/
                            c.addClass('text-strong');
                            break;
                        case 7:
                            /*FECHA ENTREGA*/
                            c.addClass('text-success text-strong');
                            break;
                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblDetalleNC.find('tbody').on('click', 'tr', function () {
            tblDetalleNC.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }
    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            pnlTablero.find('#ImporteNC').val('');
            pnlTablero.find('#Docto').focus().select().val('');
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                $(v).val('').focus();
            });
        }
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

    div.datatable-wide {
        padding-left: 0;
        padding-right: 0;
    }

    .verde {

        background-color: #B9F5A2 !important;
    }

    .azul  {
        background-color: #4BEFF1 !important;
    }

    .rojomas {
        background-color: #EC8E75 !important;

    }
    .rojo {
        background-color: #FFBEAC !important;

    }
</style>
