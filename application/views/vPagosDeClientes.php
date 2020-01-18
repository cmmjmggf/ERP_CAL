<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-xs-12 col-lg-4 col-xl-4">
                <h4 class="card-title">Pagos de clientes</h4>
            </div>
            <div class="col-12 col-sm-12 col-xs-12 col-lg-8 col-xl-8" align="right">
                <button type="button" id="btnActualizaDescuentos" name="btnActualizaDescuentos" disabled="" class="btn btn-info btn-sm">
                    Actualiza descuentos
                </button>
                <button type="button" id="btnActualizaDevoluciones" name="btnActualizaDevoluciones" disabled="" class="btn btn-info my-1 btn-sm">
                    Actualiza devoluciones
                </button>
                <button type="button" id="btnAplicaAnticiposDeClientes" name="btnAplicaAnticiposDeClientes" disabled="" class="btn btn-info  btn-sm">
                    Aplica anticipos de clientes
                </button>
                <button type="button" id="btnLocPlazas" disabled="" name="btnLocPlazas" class="btn btn-warning  btn-sm">
                    Loc-Plazas
                </button>
                <button type="button" id="btnNotaDeCredito" name="btnNotaDeCredito" class="btn btn-danger  btn-sm">
                    Nota de credito
                </button>
                <button type="button" id="btnMovimientos" name="btnMovimientos" class="btn btn-info  btn-sm">
                    Movimientos
                </button>
            </div>
        </div>
        <hr>
        <!--1er Renglon Captura-->
        <div class="row">
            <div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                <label>Cliente</label>
                <input type="text" id="ClientePDC" name="ClientePDC"  class="form-control form-control-sm  numbersOnly "maxlength="5" required="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-4 col-xl-4">
                <label for="">-</label>
                <select id="sClientePDC" name="sClientePDC" class="form-control form-control-sm NotSelectize">
                    <option></option>
                    <?php
                    $q = $this->db->query("SELECT C.Clave AS CLAVE,  C.RazonS AS CLIENTE FROM clientes AS C WHERE C.Estatus IN('ACTIVO') ORDER BY C.RazonS ASC")->result();
                    foreach ($q as $k => $v) {
                        print "<option value='{$v->CLAVE}'>{$v->CLIENTE} </option>";
                    }
                    ?>
                </select>
                <input type="text" id="AgentePDC" name="AgentePDC" class="d-none" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <label for="">Deposito</label>
                <input type="text" id="DepositoPDC" name="DepositoPDC" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <label for="">Docto</label>
                <input type="text" id="DoctoPDC" name="DoctoPDC" class="form-control form-control-sm numbersOnly" maxlength="10">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-1 col-xl-1">
                <label for="">Fecha</label>
                <input type="text" id="FechaPDC" name="FechaPDC" readonly="" class="form-control notEnter form-control-sm date">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="TPPDC" maxlength="1" required="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-1 col-xl-1">
                <label for="">Captura</label>
                <input type="text" id="CapturaPDC" name="CapturaPDC" class="form-control form-control-sm date">
            </div>
            <div class="w-100"></div>
            <!--2do Renglon Captura-->
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-1">
                <label for="">Importe</label>
                <input type="text" id="ImportePDC" name="ImportePDC" class="form-control form-control-sm numbersOnly" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-1">
                <label for="">Pagos</label>
                <input type="text" id="PagosPDC" name="PagosPDC" class="form-control form-control-sm numbersOnly" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-1">
                <label for="">Saldo</label>
                <input type="text" id="SaldoPDC" name="SaldoPDC" class="form-control form-control-sm numbersOnly" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-5 col-xl-5">
                <h5 class="">Tipos de movimiento</h5>
                <span class="badge badge-info border border-primary">2 = Efec </span>
                <span class="badge badge-info border border-primary">3 = Chec.posf </span>
                <span class="badge badge-info border border-primary">5 = Decto </span>
                <span class="badge badge-info border border-primary">7 = Dif precio </span>
                <span class="badge badge-info border border-primary">9 = Otros </span>
            </div>
            <div class="w-100"><hr></div>
            <!--3er Renglon Captura-->
            <div class="col-12 col-xs-12 col-sm-12 col-lg-5 col-xl-5 ">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label for="">Mov(1)</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="MovUno" name="MovUno" maxlength="1">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <label for="">Importe</label>
                        <input type="text" id="ImporteUno" name="ImporteUno" class="form-control form-control-sm numbersOnly">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <label for="">Ref</label>
                        <input type="text" id="RefUno" name="RefUno" class="form-control form-control-sm">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label for="">Mov(3)</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="MovTres" name="MovTres" maxlength="1">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <label for="">Importe</label>
                        <input type="text" id="ImporteTres" name="ImporteTres" class="form-control form-control-sm numbersOnly">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <label for="">Ref</label>
                        <input type="text" id="RefTres" name="RefTres" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <!-- Dias -->
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-1  d-flex align-items-stretch">
                <div class="row">
                    <label for="">Días</label>
                    <div class="w-100"></div>
                    <input type="text" id="Dias" name="Dias" placeholder="" style="font-size: 45px !important;" maxlength="3" readonly="" class="form-control form-control-sm numeric display-1" autocomplete="off">
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-5 col-xl-5 ">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label for="">Mov(2)</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="MovDos" name="MovDos" maxlength="1">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <label for="">Importe</label>
                        <input type="text" id="ImporteDos" name="ImporteDos" class="form-control form-control-sm numbersOnly">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <label for="">Ref</label>
                        <input type="text" id="RefDos" name="RefDos" class="form-control form-control-sm">
                    </div>

                    <div class="w-100"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label for="">Mov(4)</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="MovCuatro" name="MovCuatro" maxlength="1">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <label for="">Importe</label>
                        <input type="text" id="ImporteCuatro" name="ImporteCuatro" class="form-control form-control-sm numbersOnly">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <label for="">Ref</label>
                        <input type="text" id="RefCuatro" name="RefCuatro" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-1 col-xl-1 ">
                <div class="row">
                    <div class="col-12">
                        <label for="">Posfechado</label>
                        <input type="text" id="Posfechado" name="Posfechado" class="form-control form-control-sm date selectNotEnter">
                    </div>
                    <div class="col-12">
                        <label for="">Deposito</label>
                        <input type="text" id="DepositoFecha" name="DepositoFecha" class="form-control form-control-sm date selectNotEnter">
                    </div>
                </div>
            </div>
            <!-- Ultimo renglón captura -->
            <div class="w-100"><hr></div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-6 col-xl-6">
                <label for="">Folio fiscal</label>
                <input type="text" id="FolioFiscal" name="FolioFiscal" class="form-control form-control-sm" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-1 col-xl-1">
                <label for="">Saldo Actual</label>
                <input type="text" id="SaldoActual" name="SaldoActual" class="form-control form-control-sm" readonly="">
            </div>


            <!-- Ultimo renglón captura pt2 -->
            <div class="w-100"><hr></div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-3 col-xl-3 text-center" style="cursor:pointer !important; ">
                <p class="text-danger font-weight-bold font-italic">SÓLO EN CASO DE * * * EFECTIVO Y DEPÓSITO * * *</p>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-3 col-xl-3">
                <label>Banco</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Banco" name="Banco" maxlength="4">
                    </div>
                    <div class="col-9">
                        <select id="sBanco" name="sBanco" class="form-control form-control-sm required NotSelectize" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-1">
                <label for="">Cuenta</label>
                <input type="text" id="Cuenta" name="Cuenta" class="form-control form-control-sm selectNotEnter" maxlength="99">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-1 col-xl-1">
                <br>
                <button type="button" id="btnAceptaPagos" name="btnAceptaPagos" class="btn btn-info btn-sm ">
                    <span class="fa fa-check"></span>  Aceptar
                </button>
            </div>
            <div class="col-2 col-sm-2">
                <br>
                <div class="custom-control custom-checkbox d-none" id ="dMinicartera">
                    <input type="checkbox" class="custom-control-input" id="chMinicartera" name="chMinicartera" >
                    <label class="custom-control-label text-info labelCheck" for="chMinicartera">Pasa a Minicartera</label>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-1 col-xl-2">
                <label for="">Saldo del depósito</label>
                <input type="text" id="SaldoDelDeposito" name="SaldoDelDeposito" class="form-control form-control-sm" readonly="" >
            </div>

            <div class="w-100"><hr></div>
        </div>


        <div class="row">
            <!--TABLA DE DOCUMENTOS CON SALDO POR CLIENTE-->
            <div id="DocumentosConSaldoXClientes" class="col-12 col-sm-12 col-md-6">
                <h5>Documentos con saldo de este cliente</h5>
                <table id="tblDocumentosConSaldoXClientes" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th><!--0-->
                            <th>Cliente</th>
                            <th>Docto</th><!--2-->
                            <th>TP</th>
                            <th>Fec-dep</th><!--4-->
                            <th>Importe</th>
                            <th>Pagos</th><!--6-->
                            <th>Saldo</th>
                            <th>St</th><!--8: 1 SIN PAGOS; 2 CON PAGOS; 3 PAGADO-->
                            <th>Dias</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!--TABLA DE PAGOS POR DOCUMENTO-->
            <div id="PagosDeEsteDocumento" class="col-12 col-sm-12 col-md-6">
                <h5>Pagos de este documento</h5>
                <table id="tblPagosDeEsteDocumento" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Docto</th>
                            <th>TP</th>
                            <th>Fec-dep</th>
                            <th>Fec-cap</th>
                            <th>Importe</th>
                            <th>Mv</th>
                            <th>Referencia</th>
                            <th>Dias</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="SaldoTotalPendiente" class="col-12">
                <h4 class="text-danger font-weight-bold">Saldo </h4>
            </div>
        </div>
    </div>
</div>

<script>
    var pnlTablero = $("#pnlTablero"),
            DepositoPDC = pnlTablero.find("#DepositoPDC"),
            DoctoPDC = pnlTablero.find("#DoctoPDC"),
            AgentePDC = pnlTablero.find("#AgentePDC"),
            TPPDC = pnlTablero.find("#TPPDC"),
            CapturaPDC = pnlTablero.find("#CapturaPDC"),
            ImportePDC = pnlTablero.find("#ImportePDC"),
            PagosPDC = pnlTablero.find("#PagosPDC"),
            SaldoPDC = pnlTablero.find("#SaldoPDC"),
            FechaPDC = pnlTablero.find("#FechaPDC"),
            Dias = pnlTablero.find("#Dias"),
            MovUno = pnlTablero.find("#MovUno"),
            ImporteUno = pnlTablero.find("#ImporteUno"),
            RefUno = pnlTablero.find("#RefUno"),
            MovDos = pnlTablero.find("#MovDos"),
            ImporteDos = pnlTablero.find("#ImporteDos"),
            RefDos = pnlTablero.find("#RefDos"),
            MovTres = pnlTablero.find("#MovTres"),
            ImporteTres = pnlTablero.find("#ImporteTres"),
            RefTres = pnlTablero.find("#RefTres"),
            MovCuatro = pnlTablero.find("#MovCuatro"),
            ImporteCuatro = pnlTablero.find("#ImporteCuatro"),
            RefCuatro = pnlTablero.find("#RefCuatro"),
            FolioFiscal = pnlTablero.find("#FolioFiscal"),
            Banco = pnlTablero.find("#Banco"),
            sBanco = pnlTablero.find("#sBanco"),
            Cuenta = pnlTablero.find("#Cuenta"),
            SaldoActual = pnlTablero.find("#SaldoActual"),
            Posfechado = pnlTablero.find("#Posfechado"),
            PagosDeEsteDocumento,
            tblPagosDeEsteDocumento = pnlTablero.find("#tblPagosDeEsteDocumento"),
            ClientePDC = pnlTablero.find("#ClientePDC"),
            sClientePDC = pnlTablero.find("#sClientePDC"),
            DocumentosConSaldoXClientes,
            tblDocumentosConSaldoXClientes = pnlTablero.find("#tblDocumentosConSaldoXClientes"),
            SaldoTotalPendiente = pnlTablero.find("#SaldoTotalPendiente"),
            FechaActual = '<?php print Date('d/m/Y'); ?>', DepositoFecha = pnlTablero.find("#DepositoFecha"),
            SaldoDelDeposito = pnlTablero.find("#SaldoDelDeposito"), dMinicartera = pnlTablero.find("#dMinicartera"),
            chMinicartera = pnlTablero.find("#chMinicartera"),
            btnAceptaPagos = pnlTablero.find("#btnAceptaPagos"), btnMovimientos = pnlTablero.find("#btnMovimientos");
    txtCondicion = 0;

    $(document).ready(function () {
        init();

        /*BOTONES*/
        btnMovimientos.click(function () {
            onOpenWindow('<?php print base_url('MovimientosCliente'); ?>');
        });
        ClientePDC.on('keypress', function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON('<?php print base_url('PagosDeClientes/onVerificarCliente'); ?>', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            onOpenOverlay('Por favor espere...');
                            pnlTablero.find("input:not(#CapturaPDC):not(#DepositoFecha):not(#ClientePDC)").val('');
                            sClientePDC[0].selectize.addItem(txtcte, true);

                            MovUno.val('');
                            MovDos.val('');
                            MovTres.val('');
                            MovCuatro.val('');



                            if (!$.fn.DataTable.isDataTable('#tblPagosDeEsteDocumento')) {
                                getPagosDocumento();
                            } else {
                                PagosDeEsteDocumento.ajax.reload();
                            }
                            if (!$.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientes')) {
                                getDocumentosConSaldoXClientes();
                            } else {
                                DocumentosConSaldoXClientes.ajax.reload();
                            }
                            $.getJSON('<?php print base_url('PagosDeClientes/getAgenteXCliente'); ?>', {CLIENTE: txtcte})
                                    .done(function (a) {
                                        if (a.length > 0) {
                                            console.log(a[0].Descuento);
                                            AgentePDC.val(a[0].AGENTE);
                                            txtCondicion = (parseFloat(a[0].Descuento) * 100);
                                            DepositoPDC.focus();
                                        }
                                    }).fail(function (x) {
                                getError(x);
                            }).always(function () {
                                HoldOn.close();
                            });

                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                sClientePDC[0].selectize.clear(true);
                                ClientePDC.focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        sClientePDC.change(function (e) {
            if ($(this).val()) {
                ClientePDC.val(sClientePDC.val());
                pnlTablero.find("input:not(#CapturaPDC):not(#DepositoFecha):not(#ClientePDC)").val('');
                MovUno.val('');
                MovDos.val('');
                MovTres.val('');
                MovCuatro.val('');
                if (!$.fn.DataTable.isDataTable('#tblPagosDeEsteDocumento')) {
                    getPagosDocumento();
                } else {
                    PagosDeEsteDocumento.ajax.reload();
                }
                if (!$.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientes')) {
                    getDocumentosConSaldoXClientes();
                } else {
                    DocumentosConSaldoXClientes.ajax.reload();
                }
                $.getJSON('<?php print base_url('PagosDeClientes/getAgenteXCliente'); ?>', {CLIENTE: sClientePDC.val()})
                        .done(function (a) {
                            if (a.length > 0) {
                                AgentePDC.val(a[0].AGENTE);
                                txtCondicion = parseFloat(a[0].Descuento) * 100;
                                DepositoPDC.focus().select();
                            }
                        }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            }
        });
        DepositoPDC.on('keypress', function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                SaldoDelDeposito.val(DepositoPDC.val());
                DoctoPDC.focus().select();
            } else {
                SaldoDelDeposito.val(DepositoPDC.val());
            }
        });
        DoctoPDC.on('keypress', function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                onNotifyOld('', 'OBTENIENDO INFORMACIÓN DEL DOCUMENTO...', 'info');
                $.getJSON('<?php print base_url('PagosDeClientes/getDatosDelDocumentoConSaldo'); ?>',
                        {
                            DOCUMENTO: DoctoPDC.val(),
                            CLIENTE: ClientePDC.val()
                        })
                        .done(function (a) {
                            if (a.length > 0) {
                                if (parseFloat(a[0].SALDO) <= 1) {
                                    swal('ERROR', 'FACTURA SALDADA, IMPOSIBLE MODIFICAR ', 'warning').then((value) => {
                                        ImportePDC.val('');
                                        PagosPDC.val('');
                                        SaldoPDC.val('');
                                        TPPDC.val('');
                                        Dias.val('');
                                        Banco.val('');
                                        sBanco[0].selectize.clear(true);
                                        sBanco[0].selectize.clearOptions();
                                        DoctoPDC.focus().val('');
                                    });
                                } else {
                                    PagosDeEsteDocumento.ajax.reload();
                                    DocumentosConSaldoXClientes.ajax.reload();
                                    ImportePDC.val(parseFloat(a[0].IMPORTE).toFixed(2));
                                    PagosPDC.val(parseFloat(a[0].PAGOS).toFixed(2));
                                    SaldoPDC.val(parseFloat(a[0].SALDO).toFixed(2));
                                    TPPDC.val(a[0].TIPO);
                                    Dias.val(a[0].DIAS);
                                    FechaPDC.val(a[0].FECHA);
                                    getBancosPagos(a[0].TIPO);
                                    /*OBTENER UUID*/
                                    $.getJSON('<?php print base_url('PagosDeClientes/getUUID'); ?>', {DOCUMENTO: DoctoPDC.val()}).done(function (a) {
                                        console.log(a);
                                        if (a.length > 0) {
                                            FolioFiscal.val(a[0].UUID);
                                            CapturaPDC.focus();
                                        } else {
                                            CapturaPDC.focus();
                                        }
                                    }).fail(function (x) {
                                        getError(x);
                                    }).always(function () {
                                    });
                                }
                            } else {
                                swal('ERROR', 'EL DOCUMENTO NO EXISTE', 'warning').then((value) => {
                                    ImportePDC.val('');
                                    PagosPDC.val('');
                                    SaldoPDC.val('');
                                    TPPDC.val('');
                                    Dias.val('');
                                    Banco.val('');
                                    sBanco[0].selectize.clear(true);
                                    sBanco[0].selectize.clearOptions();
                                    DoctoPDC.focus().val('');
                                });
                            }
                        }).fail(function (x) {
                    getError(x);
                }).always(function () {
                });
            }
        });
        TPPDC.keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTp($(this));
                }
            }
        });
        CapturaPDC.on('keypress', function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                MovUno.focus();
            }
        });

        /*PAGO 1*/
        MovUno.on('keypress', function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                var val = $(this).val();
                if (val === '2' || val === '3' || val === '5' || val === '7' || val === '9') {

                    switch (parseInt(val)) {
                        case 2:
                            /*EFECTIVO*/
                            RefUno.val("Efe");
                            break;
                        case 3:
                            /*CHEQUE POSFECHADO*/
                            RefUno.val("Ch-P");
                            break;
                        case 5:
                            /*DESCUENTO*/
                            RefUno.val("Dc" + txtCondicion + "%");
                            break;
                        case 7:
                            /*DIFERENCIA*/
                            RefUno.val("Df-P");
                            break;
                        case 9:
                            /*OTROS*/
                            RefUno.val("Otr");
                            break;
                    }
                    onValidaOpcionMinicartera();
                    ImporteUno.focus();
                } else {
                    swal('ERROR', 'Tipo de movimiento debe ser sólo: 2,3,5,7 ó 9', 'warning').then((value) => {
                        MovUno.focus().val('');
                    });
                }
            }
        });
        ImporteUno.on('keypress', function (e) {
            var total_de_pagos = 0;
            total_de_pagos += ImporteUno.val() ? parseFloat(ImporteUno.val()) : 0;
            total_de_pagos += ImporteDos.val() ? parseFloat(ImporteDos.val()) : 0;
            total_de_pagos += ImporteTres.val() ? parseFloat(ImporteTres.val()) : 0;
            total_de_pagos += ImporteCuatro.val() ? parseFloat(ImporteCuatro.val()) : 0;
            if (e.keyCode === 13 && $(this).val()) {
                if (parseFloat(total_de_pagos) > parseFloat(SaldoPDC.val())) {
                    swal('ATENCIÓN', 'EL IMPORTE DEL PAGO SUPERA AL SALDO DEL DOCUMENTO', 'warning').then((value) => {
                        ImporteUno.val('').focus().select();
                    });
                } else {
                    onRecalcularSaldoActual(1);
                    RefUno.focus();
                }
            }
        });
        RefUno.on('keypress', function (e) {
            if (RefUno.val() && e.keyCode === 13) {
                MovDos.focus();
            }
        });
        /*PAGO 2*/
        MovDos.on('keypress', function (e) {
            if (e.keyCode === 13) {
                var val = $(this).val();
                if (val) {
                    if (val === '2' || val === '3' || val === '5' || val === '7' || val === '9') {

                        switch (parseInt(val)) {
                            case 2:
                                /*EFECTIVO*/
                                RefDos.val("Efe");
                                break;
                            case 3:
                                /*CHEQUE POSFECHADO*/
                                RefDos.val("Ch-P");
                                break;
                            case 5:
                                /*DESCUENTO*/
                                RefDos.val("Dc" + txtCondicion + "%");
                                break;
                            case 7:
                                /*DIFERENCIA*/
                                RefDos.val("Df-P");
                                break;
                            case 9:
                                /*OTROS*/
                                RefDos.val("Otr");
                                break;
                        }
                        onValidaOpcionMinicartera();
                        ImporteDos.focus();
                    } else {
                        swal('ERROR', 'Tipo de movimiento debe ser sólo: 2,3,5,7 ó 9', 'warning').then((value) => {
                            MovDos.focus().val('');
                        });
                    }
                } else {
                    Banco.focus();
                }
            }
        });
        ImporteDos.on('keypress', function (e) {
            var total_de_pagos = 0;
            total_de_pagos += ImporteUno.val() ? parseFloat(ImporteUno.val()) : 0;
            total_de_pagos += ImporteDos.val() ? parseFloat(ImporteDos.val()) : 0;
            total_de_pagos += ImporteTres.val() ? parseFloat(ImporteTres.val()) : 0;
            total_de_pagos += ImporteCuatro.val() ? parseFloat(ImporteCuatro.val()) : 0;
            if (e.keyCode === 13 && $(this).val()) {
                if (parseFloat(total_de_pagos) > parseFloat(SaldoPDC.val())) {
                    swal('ATENCIÓN', 'EL IMPORTE DEL PAGO SUPERA AL SALDO DEL DOCUMENTO', 'warning').then((value) => {
                        ImporteDos.val('').focus().select();
                    });
                } else {
                    onRecalcularSaldoActual(2);
                    RefDos.focus();
                }
            }
        });
        RefDos.on('keypress', function (e) {
            if (RefDos.val() && e.keyCode === 13) {
                MovTres.focus();
            }
        });
        /*PAGO 3*/
        MovTres.on('keypress', function (e) {
            if (e.keyCode === 13) {
                var val = $(this).val();
                if (val) {
                    if (val === '2' || val === '3' || val === '5' || val === '7' || val === '9') {

                        switch (parseInt(val)) {
                            case 2:
                                /*EFECTIVO*/
                                RefTres.val("Efe");
                                break;
                            case 3:
                                /*CHEQUE POSFECHADO*/
                                RefTres.val("Ch-P");
                                break;
                            case 5:
                                /*DESCUENTO*/
                                RefTres.val("Dc" + txtCondicion + "%");
                                break;
                            case 7:
                                /*DIFERENCIA*/
                                RefTres.val("Df-P");
                                break;
                            case 9:
                                /*OTROS*/
                                RefTres.val("Otr");
                                break;
                        }
                        onValidaOpcionMinicartera();
                        ImporteTres.focus();
                    } else {
                        swal('ERROR', 'Tipo de movimiento debe ser sólo: 2,3,5,7 ó 9', 'warning').then((value) => {
                            MovTres.focus().val('');
                        });
                    }
                } else {
                    Banco.focus();
                }
            }
        });
        ImporteTres.on('keypress', function (e) {
            var total_de_pagos = 0;
            total_de_pagos += ImporteUno.val() ? parseFloat(ImporteUno.val()) : 0;
            total_de_pagos += ImporteDos.val() ? parseFloat(ImporteDos.val()) : 0;
            total_de_pagos += ImporteTres.val() ? parseFloat(ImporteTres.val()) : 0;
            total_de_pagos += ImporteCuatro.val() ? parseFloat(ImporteCuatro.val()) : 0;
            if (e.keyCode === 13 && $(this).val()) {
                if (parseFloat(total_de_pagos) > parseFloat(SaldoPDC.val())) {
                    swal('ATENCIÓN', 'EL IMPORTE DEL PAGO SUPERA AL SALDO DEL DOCUMENTO', 'warning').then((value) => {
                        ImporteTres.val('').focus().select();
                    });
                } else {
                    onRecalcularSaldoActual(3);
                    RefTres.focus();
                }
            }
        });
        RefTres.on('keypress', function (e) {
            if (RefTres.val() && e.keyCode === 13) {
                MovCuatro.focus();
            }
        });
        /*PAGO 4*/
        MovCuatro.on('keypress', function (e) {
            if (e.keyCode === 13) {
                var val = $(this).val();
                if (val) {
                    if (val === '2' || val === '3' || val === '5' || val === '7' || val === '9') {

                        switch (parseInt(val)) {
                            case 2:
                                /*EFECTIVO*/
                                RefCuatro.val("Efe");
                                break;
                            case 3:
                                /*CHEQUE POSFECHADO*/
                                RefCuatro.val("Ch-P");
                                break;
                            case 5:
                                /*DESCUENTO*/
                                RefCuatro.val("Dc" + txtCondicion + "%");
                                break;
                            case 7:
                                /*DIFERENCIA*/
                                RefCuatro.val("Df-P");
                                break;
                            case 9:
                                /*OTROS*/
                                RefCuatro.val("Otr");
                                break;
                        }
                        onValidaOpcionMinicartera();
                        ImporteCuatro.focus();
                    } else {
                        swal('ERROR', 'Tipo de movimiento debe ser sólo: 2,3,5,7 ó 9', 'warning').then((value) => {
                            MovCuatro.focus().val('');
                        });
                    }
                } else {
                    Banco.focus();
                }
            }
        });
        ImporteCuatro.on('keypress', function (e) {
            var total_de_pagos = 0;
            total_de_pagos += ImporteUno.val() ? parseFloat(ImporteUno.val()) : 0;
            total_de_pagos += ImporteDos.val() ? parseFloat(ImporteDos.val()) : 0;
            total_de_pagos += ImporteTres.val() ? parseFloat(ImporteTres.val()) : 0;
            total_de_pagos += ImporteCuatro.val() ? parseFloat(ImporteCuatro.val()) : 0;
            if (e.keyCode === 13 && $(this).val()) {
                if (parseFloat(total_de_pagos) > parseFloat(SaldoPDC.val())) {
                    swal('ATENCIÓN', 'EL IMPORTE DEL PAGO SUPERA AL SALDO DEL DOCUMENTO', 'warning').then((value) => {
                        ImporteCuatro.val('').focus().select();
                    });
                } else {
                    onRecalcularSaldoActual(4);
                    RefCuatro.focus();
                }
            }
        });
        RefCuatro.on('keypress', function (e) {
            if (RefCuatro.val() && e.keyCode === 13) {
                Banco.focus();
            }
        });
        Banco.keypress(function (e) {
            if (e.keyCode === 13) {
                var txtbco = $(this).val();
                if (txtbco) {
                    $.getJSON('<?php print base_url('PagosDeClientes/onVerificarBanco'); ?>', {Banco: txtbco, Tp: TPPDC.val()}).done(function (data) {
                        if (data.length > 0) {
                            sBanco[0].selectize.addItem(txtbco, true);
                            Cuenta.val(data[0].CTACHEQUE);
                            btnAceptaPagos.focus();
                        } else {
                            swal('ERROR', 'EL BANCO NO EXISTE', 'warning').then((value) => {
                                Cuenta.val('');
                                sBanco[0].selectize.clear(true);
                                Banco.focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                } else {
                    Cuenta.val('');
                    btnAceptaPagos.focus();
                }
            }
        });
        sBanco.change(function () {
            if ($(this).val()) {
                Banco.val($(this).val());
                $.getJSON('<?php print base_url('PagosDeClientes/getCtaCheques'); ?>', {CLAVE_BANCO: Banco.val()}).done(function (a) {
                    if (a.length > 0) {
                        Cuenta.val(a[0].CTACHEQUE);
                        btnAceptaPagos.focus();
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                });
            } else {
                Cuenta.val('');
            }
        });

        btnAceptaPagos.click(function () {
            swal({
                buttons: ["Cancelar", "Aceptar"],
                title: 'Estás Seguro?',
                text: "Esta acción no se puede revertir",
                icon: "warning",
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then((action) => {
                if (action) {
                    var movs = [getIntVR(MovUno), getIntVR(MovDos), getIntVR(MovTres), getIntVR(MovCuatro)];
                    /*VALIDAR FECHA DEL CHEQUE POSFECHADO EN CASO DE PONER 3 Chec.posf*/
                    if (movs.indexOf(3) >= 0 && !Posfechado.val()) {
                        onBeep(2);
                        swal('ATENCIÓN', 'DEBE DE CAPTURAR LA FECHA DEL CHEQUE POSFECHADO', 'warning')
                                .then((value) => {
                                    Posfechado.focus().select();
                                });
                    } else {
                        /*VALIDAR BANCO EN CASO DE PONER 2 EFECTIVO O DEPOSITO*/
                        if (movs.indexOf(2) >= 0 && !Banco.val()) {
                            onBeep(2);
                            swal('ATENCIÓN', 'EN CASO DE EFECTIVO, DEBE DE CAPTURAR EL BANCO', 'warning')
                                    .then((value) => {
                                        Banco.focus();
                                    });
                        } else {
                            if (ClientePDC.val() && DepositoPDC.val() && DoctoPDC.val() && FechaPDC.val() && TPPDC.val() && CapturaPDC.val()) {
                                HoldOn.open({
                                    theme: 'sk-rect',
                                    message: 'Guardando pagos...'
                                });

                                /*Datos generales*/
                                var p = {
                                    CLIENTE: ClientePDC.val(),
                                    AGENTE: AgentePDC.val(),
                                    NUMERO_RF: DoctoPDC.val(),
                                    TP: parseInt(TPPDC.val()),
                                    FECHA: CapturaPDC.val(),
                                    FECHAFAC: FechaPDC.val(),
                                    IMPORTEFAC: ImportePDC.val(),
                                    TIPO: TPPDC.val(),
                                    UUID: FolioFiscal.val(),
                                    MOVIMIENTO: MovUno.val()/*POR DEFECTO INICIA EN ESTE CAMPO*/,
                                    IMPORTE: ImporteUno.val()/*POR DEFECTO INICIA EN ESTE CAMPO*/,
                                    REF: RefUno.val()/*POR DEFECTO INICIA EN ESTE CAMPO*/,
                                    CLAVE_BANCO: Banco.val() ? Banco.val() : ''
                                };
                                /*Graba Minicartera*/
                                if (chMinicartera[0].checked) {
                                    if (MovUno.val() === '5') {
                                        p.MOVIMIENTO = MovUno.val();
                                        p.IMPORTE = (TPPDC.val() === '1') ? (ImporteUno.val() * 1.16) : ImporteUno.val();
                                        p.REF = RefUno.val();
                                        onRegistraMinicartera(p);
                                    } else if (MovDos.val() === '5') {
                                        p.MOVIMIENTO = MovDos.val();
                                        p.IMPORTE = (TPPDC.val() === '1') ? (ImporteDos.val() * 1.16) : ImporteDos.val();
                                        p.REF = RefDos.val();
                                        onRegistraMinicartera(p);
                                    } else if (MovTres.val() === '5') {
                                        p.MOVIMIENTO = MovTres.val();
                                        p.IMPORTE = (TPPDC.val() === '1') ? (ImporteTres.val() * 1.16) : ImporteTres.val();
                                        p.REF = RefTres.val();
                                        onRegistraMinicartera(p);
                                    } else if (MovCuatro.val() === '5') {
                                        p.MOVIMIENTO = MovCuatro.val();
                                        p.IMPORTE = (TPPDC.val() === '1') ? (ImporteCuatro.val() * 1.16) : ImporteCuatro.val();
                                        p.REF = RefCuatro.val();
                                        onRegistraMinicartera(p);
                                    }

                                }
                                var npagos = 0;
                                if (MovUno.val() && ImporteUno.val() && RefUno.val()) {
                                    npagos += 1;
                                    p.MOVIMIENTO = MovUno.val();
                                    p.IMPORTE = (TPPDC.val() === '1' && MovUno.val() === '5') ? (ImporteUno.val() * 1.16) : ImporteUno.val();
                                    p.REF = RefUno.val();
                                    onPagoCliente(p);
                                }
                                if (MovDos.val() && ImporteDos.val() && RefDos.val()) {
                                    npagos += 1;
                                    p.MOVIMIENTO = MovDos.val();
                                    p.IMPORTE = (TPPDC.val() === '1' && MovDos.val() === '5') ? (ImporteDos.val() * 1.16) : ImporteDos.val();
                                    p.REF = RefDos.val();
                                    onPagoCliente(p);
                                }
                                if (MovTres.val() && ImporteTres.val() && RefTres.val()) {
                                    npagos += 1;
                                    p.MOVIMIENTO = MovTres.val();
                                    p.IMPORTE = (TPPDC.val() === '1' && MovTres.val() === '5') ? (ImporteTres.val() * 1.16) : ImporteTres.val();
                                    p.REF = RefTres.val();
                                    onPagoCliente(p);
                                }
                                if (MovCuatro.val() && ImporteCuatro.val() && RefCuatro.val()) {
                                    npagos += 1;
                                    p.MOVIMIENTO = MovCuatro.val();
                                    p.IMPORTE = (TPPDC.val() === '1' && MovCuatro.val() === '5') ? (ImporteCuatro.val() * 1.16) : ImporteCuatro.val();
                                    p.REF = RefCuatro.val();
                                    onPagoCliente(p);
                                }
                                console.log('PAGOS : ' + npagos);
                                if (npagos > 0) {
                                    console.log("\n P CONTIENE \n", p);
                                    /*TERMINAR PROCESO */
                                    //Recalcula el saldo final del deposito
                                    var depos = parseFloat((ImporteUno.val() !== '') ? ImporteUno.val() : 0) +
                                            parseFloat((ImporteDos.val() !== '') ? ImporteDos.val() : 0) +
                                            parseFloat((ImporteTres.val() !== '') ? ImporteTres.val() : 0) +
                                            parseFloat((ImporteCuatro.val() !== '') ? ImporteCuatro.val() : 0)

                                    var nuevo_saldo = SaldoDelDeposito.val() - depos;
                                    pnlTablero.find("input:not(#DepositoPDC):not(#Agente):not(#SaldoDelDeposito):not(#ClientePDC):not(#CapturaPDC)").val('');
                                    Banco.val('');
                                    sBanco[0].selectize.clear(true);
                                    TPPDC.val('');
                                    MovUno.val('');
                                    MovDos.val('');
                                    MovTres.val('');
                                    MovCuatro.val('');
                                    if (!$.fn.DataTable.isDataTable('#tblPagosDeEsteDocumento')) {
                                        getPagosDocumento();
                                    } else {
                                        PagosDeEsteDocumento.ajax.reload();
                                    }
                                    if (!$.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientes')) {
                                        getDocumentosConSaldoXClientes();
                                    } else {
                                        DocumentosConSaldoXClientes.ajax.reload();
                                    }

                                    //Pinta nuevo saldo del deposito inicial y si no pone el cursor en el nuevo deposito
                                    if (parseInt(nuevo_saldo) > 0) {
                                        SaldoDelDeposito.val(parseFloat(nuevo_saldo).toFixed(2));
                                        DoctoPDC.val('').focus().select();
                                    } else {
                                        DepositoPDC.val('').focus();
                                    }
                                    chMinicartera.prop('checked', false);
                                    dMinicartera.addClass("d-none");
                                    onNotifyOld('', 'SE HAN REALIZADO LOS MOVIMIENTOS', 'success');

                                } else {
                                    onBeep(2);
                                    swal('ATENCIÓN', 'ES NECESARIO AÑADIR LOS DATOS DEL PAGO', 'warning').then((value) => {
                                        MovUno.focus();
                                    });
                                }
                                HoldOn.close();
                            } else {
                                onBeep(2);
                                swal('ATENCIÓN', 'ES NECESARIO CAPTURAR LA INFORMACIÓN DEL CLIENTE,DEPOSITO,DOCUMENTO,TIPO,FECHAS', 'warning').then((value) => {
                                    if (!ClientePDC.val()) {
                                        ClientePDC.focus();
                                    } else {
                                        DepositoPDC.focus().select();
                                    }
                                });
                            }
                        }
                    }
                }
            });

        });
    });

    function init() {
        ClientePDC.focus();
        CapturaPDC.val(FechaActual);
        DepositoFecha.val(FechaActual);
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        if (!$.fn.DataTable.isDataTable('#tblPagosDeEsteDocumento')) {
            getPagosDocumento();
        } else {
            PagosDeEsteDocumento.ajax.reload();
        }
        if (!$.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientes')) {
            getDocumentosConSaldoXClientes();
        } else {
            DocumentosConSaldoXClientes.ajax.reload();
        }
    }
    function getPagosDocumento() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblPagosDeEsteDocumento')) {
            tblPagosDeEsteDocumento.DataTable().destroy();
        }
        PagosDeEsteDocumento = tblPagosDeEsteDocumento.DataTable({
            "dom": 'rtp',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('PagosDeClientes/getPagosXDocumentos'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = getVR(ClientePDC);
                    d.DOCUMENTO = getVR(DoctoPDC);
                }
            },
            "columns": [
                {"data": "ID"}, {"data": "CLIENTE"}, {"data": "DOCUMENTO"},
                {"data": "TP"}, {"data": "FECHA_DEPOSITO"}, {"data": "FECHA_CAPTURA"},
                {"data": "IMPORTE"}, {"data": "MV"}, {"data": "REFERENCIA"},
                {"data": "DIAS"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "scrollY": "250px",
            "bSort": true,
            "aaSorting": [
                [0, 'desc']/*ID*/
            ],
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });
    }
    function getDocumentosConSaldoXClientes() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientes')) {
            tblDocumentosConSaldoXClientes.DataTable().destroy();
        }
        DocumentosConSaldoXClientes = tblDocumentosConSaldoXClientes.DataTable({
            "dom": 'rtp',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('PagosDeClientes/getDocumentosConSaldoXClientes'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = getVR(ClientePDC);
                    d.DOCUMENTO = getVR(DoctoPDC);
                }
            },
            "columns": [
                {"data": "ID"}/*0*/, {"data": "CLIENTE"}/*1*/, {"data": "DOCUMENTO"}/*2*/,
                {"data": "TP"}/*3*/, {"data": "FECHA_DEPOSITO"}/*4*/,
                {"data": "IMPORTE"}/*5*/, {"data": "PAGOS"}/*6*/, {"data": "SALDO"}/*7*/,
                {"data": "ST"}/*8*/, {"data": "DIAS"}/*9*/, {"data": "SALDOX"}/*10*/
            ],
            "columnDefs": [
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
            ],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "scrollY": "250px",
            "bSort": true,
            "aaSorting": [
                [1, 'asc']/*ID*/
            ],
            initComplete: function (a, b) {
                HoldOn.close();
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                var saldox = api.column(10).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(b) ? parseFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                pnlTablero.find("#SaldoTotalPendiente h4").text('Saldo $' + $.number(parseFloat(saldox), 2, '.', ','));
            }
        });
    }
    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            //getBancos(tp);
            CapturaPDC.focus().select();
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
    function getBancosPagos(tp) {
        sBanco[0].selectize.clear(true);
        sBanco[0].selectize.clearOptions();
        $.getJSON('<?php print base_url('PagosDeClientes/getBancos') ?>', {Tp: tp}).done(function (a) {
            $.each(a, function (k, v) {
                sBanco[0].selectize.addOption({text: v.BANCO, value: v.CLAVE});
            });
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }
    function onRecalcularSaldoActual(index) {
        var saldo = parseFloat(SaldoPDC.val());
        var total_de_pagos = 0;
        var saldo_final = 0;
        if (index === 1 && parseInt(MovUno.val()) === 5 && parseInt(TPPDC.val()) === 1) {
            ImporteUno.val(getImporteSinIva(ImporteUno));
            ImporteUno.focus().select();
        }
        if (index === 2 && parseInt(MovDos.val()) === 5 && parseInt(TPPDC.val()) === 1) {
            ImporteDos.val(getImporteSinIva(ImporteDos));
            ImporteDos.focus().select();
        }
        if (index === 3 && parseInt(MovTres.val()) === 5 && parseInt(TPPDC.val()) === 1) {
            ImporteTres.val(getImporteSinIva(ImporteTres));
            ImporteTres.focus().select();
        }
        if (index === 4 && parseInt(MovCuatro.val()) === 5 && parseInt(TPPDC.val()) === 1) {
            ImporteCuatro.val(getImporteSinIva(ImporteCuatro));
            ImporteCuatro.focus().select();
        }
        total_de_pagos += ImporteUno.val() ? parseFloat(ImporteUno.val()) : 0;
        total_de_pagos += ImporteDos.val() ? parseFloat(ImporteDos.val()) : 0;
        total_de_pagos += ImporteTres.val() ? parseFloat(ImporteTres.val()) : 0;
        total_de_pagos += ImporteCuatro.val() ? parseFloat(ImporteCuatro.val()) : 0;
        saldo_final = saldo - total_de_pagos;
        SaldoActual.val(parseFloat(saldo_final).toFixed(2));
    }
    function getImporteSinIva(e) {
        var ee = e.val() ? parseFloat(e.val()) : 0;
        return parseFloat((ee / 1.16)).toFixed(2);
    }
    function getIntVR(e) {
        return parseInt(e.val() ? e.val() : 0);
    }
    function onPagoCliente(p) {
        console.log("\n ONPAGOCLIENTE ", p.IMPORTE, p.MOVIMIENTO, p.REF);
        $.post('<?php print base_url('PagosDeClientes/onPagoCliente') ?>', p)
                .done(function (a) {
                    console.log(a);
                    //onBeep(1);
                    //onNotifyOld('', 'SE HAN REALIZADO LOS PAGOS', 'success');
                }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }
    function onRegistraMinicartera(p) {
        console.log("\n ONPAGOMINICARTERA ", p.IMPORTE, p.MOVIMIENTO, p.REF);
        $.post('<?php print base_url('PagosDeClientes/onRegistraMinicartera') ?>', p)
                .done(function (a) {
                    console.log(a);
                    //onBeep(1);
                    //onNotifyOld('', 'SE HAN GUARDADO EN MINICARTERA', 'success');
                }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }
    function onValidaOpcionMinicartera() {
        if (MovUno.val() === '5' || MovDos.val() === '5' || MovTres.val() === '5' || MovCuatro.val() === '5') {
            dMinicartera.removeClass("d-none");
        } else {
            chMinicartera.prop('checked', false);
            dMinicartera.addClass("d-none");
        }
    }
</script>
<style>
    table tbody td{
        color: #000 !important;
        font-weight: bold ;
    }
    table tbody tr:hover td{
        color: #fff !important;
        font-weight: bold ;
    }
    label {
        margin-top: 0.02rem;
        margin-bottom: 0.0rem;
    }
    table tbody tr {
        font-size: 0.75rem !important;
    }
</style>