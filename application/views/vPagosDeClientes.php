<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header"> 
        <div class="row">
            <div class="col-12 col-sm-12 col-xs-12 col-lg-4 col-xl-4">
                <h4 class="card-title">Pagos de clientes</h4>  
            </div> 
            <div class="col-12 col-sm-12 col-xs-12 col-lg-8 col-xl-8" align="right"> 
                <button type="button" id="btnActualizaDescuentos" name="btnActualizaDescuentos" class="btn btn-info btn-sm">
                    Actualiza descuentos
                </button>
                <button type="button" id="btnActualizaDevoluciones" name="btnActualizaDevoluciones" class="btn btn-info my-1 btn-sm">
                    Actualiza devoluciones
                </button> 
                <button type="button" id="btnAplicaAnticiposDeClientes" name="btnAplicaAnticiposDeClientes" class="btn btn-info  btn-sm">
                    Aplica anticipos de clientes
                </button> 
                <button type="button" id="btnLocPlazas" name="btnLocPlazas" class="btn btn-warning  btn-sm">
                    Loc-Plazas
                </button>
                <button type="button" id="btnNotaDeCredito" name="btnNotaDeCredito" class="btn btn-danger  btn-sm">
                    Nota de credito
                </button> 
                <button type="button" id="btnMovimientos" name="btnMovimientos" class="btn btn-primary  btn-sm">
                    Movimientos
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-lg-5 col-xl-5">
                <label for="">Cliente</label>
                <select id="ClientePDC" name="ClientePDC" class="form-control form-control-sm">                        
                </select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <label for="">Deposito</label>
                <input type="text" id="DepositoPDC" name="DepositoPDC" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <label for="">Docto</label>
                <input type="text" id="DoctoPDC" name="DoctoPDC" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-1 col-xl-1">
                <label for="">Fecha</label>
                <input type="text" id="FechaPDC" name="FechaPDC" readonly="" class="form-control notEnter form-control-sm date">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-1 col-xl-1">
                <label for="">TP</label>
                <select id="TPPDC" name="TPPDC" class="form-control form-control-sm">
                    <option></option>
                    <option value="1">1 F</option>
                    <option value="2">2 R</option>
                </select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-1 col-xl-1">
                <label for="">Captura</label>
                <input type="text" id="CapturaPDC" name="CapturaPDC" class="form-control form-control-sm date">
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-3 col-xl-3">
                <label for="">Importe</label>
                <input type="text" id="ImportePDC" name="ImportePDC" class="form-control form-control-sm numbersOnly" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <label for="">Pagos</label>
                <input type="text" id="PagosPDC" name="PagosPDC" class="form-control form-control-sm numbersOnly" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <label for="">Saldo</label>
                <input type="text" id="SaldoPDC" name="SaldoPDC" class="form-control form-control-sm numbersOnly" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-5 col-xl-5">
                <h3 class="">Tipos de movimiento</h3>
                <span class="badge badge-info border border-primary">2 = Efec </span>
                <span class="badge badge-info border border-primary">3 = Chec.posf </span>
                <span class="badge badge-info border border-primary">5 = Decto </span>
                <span class="badge badge-info border border-primary">7 = Dif precio </span>
                <span class="badge badge-info border border-primary">9 = Otros </span>
            </div>
            <div class="w-100 my-3"><hr></div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-5 col-xl-5 ">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label for="">Mov(1)</label>
                        <select id="MovUno" name="MovUno" class="form-control form-control-sm">
                            <option value=""></option>
                            <option value="2">2 Efectivo</option>
                            <option value="3">3 Chec.posf</option>
                            <option value="5">5 Decto</option>
                            <option value="7">7 Dif precio</option>
                            <option value="9">9 Otros</option>
                        </select>
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
                        <select id="MovTres" name="MovTres" class="form-control form-control-sm">
                            <option value=""></option>
                            <option value="2">2 Efectivo</option>
                            <option value="3">3 Chec.posf</option>
                            <option value="5">5 Decto</option>
                            <option value="7">7 Dif precio</option>
                            <option value="9">9 Otros</option>
                        </select>
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

            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-1 mt-2 d-flex align-items-stretch">
                <label for="">DIAS</label>
                <input type="text" id="Dias" name="Dias" placeholder="" style="font-size: 80px !important;" maxlength="2" class="form-control form-control-sm numeric display-1" autocomplete="off">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-5 col-xl-5 ">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label for="">Mov(2)</label>
                        <select id="MovDos" name="MovDos" class="form-control form-control-sm">
                            <option value=""></option>
                            <option value="2">2 Efectivo</option>
                            <option value="3">3 Chec.posf</option>
                            <option value="5">5 Decto</option>
                            <option value="7">7 Dif precio</option>
                            <option value="9">9 Otros</option>
                        </select>
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
                        <select id="MovCuatro" name="MovCuatro" class="form-control form-control-sm">
                            <option value=""></option>
                            <option value="2">2 Efectivo</option>
                            <option value="3">3 Chec.posf</option>
                            <option value="5">5 Decto</option>
                            <option value="7">7 Dif precio</option>
                            <option value="9">9 Otros</option>
                        </select>
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
                        <input type="text" id="Posfechado" name="Posfechado" class="form-control form-control-sm date">
                    </div>
                    <div class="col-12">
                        <label for="">Deposito</label>
                        <input type="text" id="DepositoFecha" name="DepositoFecha" class="form-control form-control-sm date">
                    </div>
                </div>
            </div>
            <div class="w-100 my-3"><hr></div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-4 col-xl-4 text-center mt-1" style="cursor:pointer !important; ">
                <p class="text-danger font-weight-bold font-italic">SOLO EN CASO DE * * * EFECTIVO Y DEPOSITO * * *</p>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-4 col-xl-4">
                <label for="">Banco</label>
                <select id="Banco" name="Banco" class="form-control form-control-sm"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <label for="">Cuenta</label>
                <input type="text" id="Cuenta" name="Cuenta" class="form-control form-control-sm" maxlength="99">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <button type="button" id="btnAceptaPagos" name="btnAceptaPagos" class="btn btn-primary">
                    Acepta
                </button>
            </div>
            <div class="w-100 my-3"><hr></div>
            <!--TABLA DE PAGOS POR DOCUMENTO-->
            <div class="col-12 col-xs-12 col-sm-12 col-lg-10 col-xl-10" align="center">
                <h3 class="text-info font-italic">Pagos de este documento</h3>
            </div>

            <div class="col-12 col-xs-12 col-sm-12 col-lg-10 col-xl-10" align="">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-lg-8 col-xl-8">
                        <label for="">Folio fiscal</label>
                        <input type="text" id="FolioFiscal" name="FolioFiscal" class="form-control form-control-sm" readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                        <label for="">SALDO ACTUAL</label>
                        <input type="text" id="SaldoActual" name="SaldoActual" class="form-control form-control-sm" readonly="">
                    </div>
                </div>
                <div class="w-100 my-3"><hr></div>
                <div id="PagosDeEsteDocumento" class="table-responsive">
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
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <label for="">Saldo del deposito</label>
                <input type="text" id="SaldoDelDeposito" name="SaldoDelDeposito" class="form-control form-control-sm" readonly="" >
            </div>
            <div class="w-100"></div>
            <!--TABLA DE DOCUMENTOS CON SALDO POR CLIENTE-->
            <div class="w-100 my-3"><hr></div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-10 col-xl-10" align="center">
                <h3 class="text-info font-italic">Documentos con saldo de este cliente</h3>
                <div id="DocumentosConSaldoXClientes" class="table-responsive">
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
            </div><!--END TABLE-->
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
            Cuenta = pnlTablero.find("#Cuenta"),
            PagosDeEsteDocumento,
            tblPagosDeEsteDocumento = pnlTablero.find("#tblPagosDeEsteDocumento"),
            ClientePDC = pnlTablero.find("#ClientePDC"),
            DocumentosConSaldoXClientes,
            tblDocumentosConSaldoXClientes = pnlTablero.find("#tblDocumentosConSaldoXClientes"),
            SaldoTotalPendiente = pnlTablero.find("#SaldoTotalPendiente"),
            FechaActual = '<?php print Date('d/m/Y'); ?>', DepositoFecha = pnlTablero.find("#DepositoFecha"),
            SaldoDelDeposito = pnlTablero.find("#SaldoDelDeposito"),
            btnAceptaPagos = pnlTablero.find("#btnAceptaPagos");

    $(document).ready(function () {
        RefUno.on('keydown keyup', function (e) {
            if (RefUno.val() && e.keyCode === 13) {
                MovDos[0].selectize.focus();
            }
        });
        btnAceptaPagos.click(function () {
            if (ClientePDC.val() && DepositoPDC.val() && DoctoPDC.val() && FechaPDC.val() && TPPDC.val() && CapturaPDC.val()) {
                var p = {
                    CLIENTE: ClientePDC.val(),
                    NUMERO_RF: DoctoPDC.val(),
                    FECHA: FechaPDC.val(),
                    TIPO: TPPDC.val(),
                    MOVIMIENTO: MovUno.val()/*POR DEFECTO INICIA EN ESTE CAMPO*/,
                    IMPORTE: ImporteUno.val()/*POR DEFECTO INICIA EN ESTE CAMPO*/,
                    REF: RefUno.val()/*POR DEFECTO INICIA EN ESTE CAMPO*/,
                    CLAVE_BANCO: Banco.val() ? Banco.val() : ''
                };
                var npagos = 0;
                if (MovUno.val() && ImporteUno.val() && RefUno.val()) {
                    npagos += 1;
                    onPagoCliente(p);
                }
                if (MovDos.val() && ImporteDos.val() && RefDos.val()) {
                    npagos += 1;
                    onPagoCliente(p);
                }
                if (MovTres.val() && ImporteTres.val() && RefTres.val()) {
                    npagos += 1;
                    onPagoCliente(p);
                }
                if (MovCuatro.val() && ImporteCuatro.val() && RefCuatro.val()) {
                    npagos += 1;
                    onPagoCliente(p);
                }
                console.log('PAGOS : ' + npagos);
                if (npagos > 0) {
                    console.log("\n P CONTIENE \n", p);
                } else {
                    onBeep(2);
                    swal('ATENCIÓN', 'ES NECESARIO AÑADIR LOS DATOS DEL PAGO', 'warning').then((value) => {
                        MovUno[0].selectize.focus();
                        MovUno[0].selectize.open();
                    });
                }
                /*ACTUALIZAR SALDO EN CARTCLIENTE*/

                /*TERMINAR PROCESO */

                pnlTablero.find("input").val('');
                $.each(pnlTablero.find("select"), function (k, v) {
                    $(v)[0].selectize.clear(true);
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
                ClientePDC[0].selectize.focus();
                ClientePDC[0].selectize.open();
            } else {
                swal('ATENCIÓN', 'ES NECESARIO CAPTURAR LA INFORMACIÓN DEL CLIENTE,DEPOSITO,DOCUMENTO,TIPO,FECHAS', 'warning')
                        .then((value) => {
                            if (!ClientePDC.val()) {
                                ClientePDC[0].selectize.open();
                                ClientePDC[0].selectize.focus();
                            } else {
                                DepositoPDC.focus().select();
                            }
                        });
            }
        });

        Banco.change(function () {
            if ($(this).val()) {
                $.getJSON('<?php print base_url('PagosDeClientes/getCtaCheques'); ?>', {CLAVE_BANCO: Banco.val()})
                        .done(function (a) {
                            if (a.length > 0) {
                                Cuenta.val(a[0].CTACHEQUE);
                            }
                        }).fail(function (x) {
                    getError(x);
                }).always(function () {

                });
            } else {
                Cuenta.val('');
            }
        });

        DoctoPDC.on('keydown keyup', function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                onNotifyOld('', 'OBTENIENDO INFORMACIÓN DEL DOCUMENTO...', 'info');
                $.getJSON('<?php print base_url('PagosDeClientes/getDatosDelDocumentoConSaldo'); ?>', {DOCUMENTO: DoctoPDC.val()})
                        .done(function (a) {
                            PagosDeEsteDocumento.ajax.reload();
                            DocumentosConSaldoXClientes.ajax.reload();
                            if (a.length > 0) {
                                ImportePDC.val(a[0].IMPORTE);
                                PagosPDC.val(a[0].PAGOS);
                                SaldoPDC.val(a[0].SALDO);
                                TPPDC[0].selectize.setValue(a[0].TIPO);
                                Dias.val(a[0].DIAS);
                                /*OBTENER UUID*/
                                $.getJSON('<?php print base_url('PagosDeClientes/getUUID'); ?>', {DOCUMENTO: DoctoPDC.val()}).done(function (a) {
                                    console.log(a);
                                    if (a.length > 0) {
                                        FolioFiscal.val(a[0].UUID);
                                        CapturaPDC.focus();
                                    }
                                }).fail(function (x) {
                                    getError(x);
                                }).always(function () {
                                });
                            }
                        }).fail(function (x) {
                    getError(x);
                }).always(function () {
                });
            }
        });

        DepositoPDC.on('keydown', function (e) {
            if (e.keyCode === 13) {
                SaldoDelDeposito.val(DepositoPDC.val());
            } else {
                SaldoDelDeposito.val(DepositoPDC.val());
            }
        });

        FechaPDC.val(FechaActual);
        CapturaPDC.val(FechaActual);
        DepositoFecha.val(FechaActual);

        getClientes();
        getBancos();
        ClientePDC.change(function (e) {
            pnlTablero.find("input:not(#FechaPDC):not(#CapturaPDC):not(#DepositoFecha)").val('');
            $.each(pnlTablero.find("select:not(#ClientePDC)"), function (k, v) {
                $(v)[0].selectize.clear(true);
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
        });

    });

    function getPagosDocumento() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblPagosDeEsteDocumento')) {
            tblPagosDeEsteDocumento.DataTable().destroy();
        }
        PagosDeEsteDocumento = tblPagosDeEsteDocumento.DataTable({
            "dom": 'rtip',
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
            "scrollY": "300px",
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
            "dom": 'rtip',
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
            "scrollY": "300px",
            "bSort": true,
            "aaSorting": [
                [0, 'desc']/*ID*/
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

    function getClientes() {
        $.getJSON('<?php print base_url('PagosDeClientes/getClientes'); ?>').done(function (a) {
            a.forEach(function (x) {
                ClientePDC[0].selectize.addOption({text: x.Cliente, value: x.Clave});
            });
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            handleEnterDiv(pnlTablero);
            ClientePDC[0].selectize.focus();
            ClientePDC[0].selectize.open();

        });
    }

    function getBancos() {
        $.getJSON('<?php print base_url('PagosDeClientes/getBancos') ?>')
                .done(function (a) {
                    a.forEach(function (e) {
                        Banco[0].selectize.addOption({text: e.BANCO, value: e.CLAVE});
                    });
                }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }

    function onPagoCliente(p) {
        $.post('<?php print base_url('PagosDeClientes/onPagoCliente') ?>', p)
                .done(function (a) {
                    console.log(a);
                    onBeep(1);
                    onNotifyOld('', 'SE HAN REALIZADO LOS PAGOS', 'success');
                }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }
</script>
<style>
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid; 
        /*border-image: linear-gradient(to bottom,  #2196F3, #cc0066, rgb(0,0,0,0)) 1 100% ;*/
        border-image: linear-gradient(to bottom,  #0099cc, #003366, rgb(0,0,0,0)) 1 100% ;
    }
    table tbody td{
        color: #000 !important;
        font-weight: bold ;
    }
    table tbody tr:hover td{
        color: #fff !important;
        font-weight: bold ;
    }
</style>