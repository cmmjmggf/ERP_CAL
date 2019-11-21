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
        <div class="row">
            <div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                <label>Cliente</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="ClientePDC" name="ClientePDC" maxlength="5" required="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-4 col-xl-4">
                <label for="">-</label>
                <select id="sClientePDC" name="sClientePDC" class="form-control form-control-sm NotSelectize">
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
            <div class="col-12 col-xs-12 col-sm-12 col-lg-1 col-xl-1">
                <label for="">Tp</label>
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
            <div class="w-100 my-1"><hr></div>
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
                        <input type="text" id="Posfechado" name="Posfechado" class="form-control form-control-sm date selectNotEnter">
                    </div>
                    <div class="col-12">
                        <label for="">Deposito</label>
                        <input type="text" id="DepositoFecha" name="DepositoFecha" class="form-control form-control-sm date selectNotEnter">
                    </div>
                </div>
            </div>
            <div class="w-100 my-1"><hr></div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-4 col-xl-4 text-center" style="cursor:pointer !important; ">
                <p class="text-danger font-weight-bold font-italic">SOLO EN CASO DE * * * EFECTIVO Y DEPÓSITO * * *</p>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-4 col-xl-4">
                <label for="">Banco</label>
                <select id="Banco" name="Banco" class="form-control form-control-sm NotSelectize selectNotEnter"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <label for="">Cuenta</label>
                <input type="text" id="Cuenta" name="Cuenta" class="form-control form-control-sm selectNotEnter" maxlength="99">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <br>
                <button type="button" id="btnAceptaPagos" name="btnAceptaPagos" class="btn btn-info btn-sm ">
                    <span class="fa fa-check"></span>  Acepta
                </button>
            </div>
            <div class="w-100"><hr></div>
            <!--TABLA DE PAGOS POR DOCUMENTO-->
            <div class="col-12 col-xs-12 col-sm-12 col-lg-10 col-xl-10" align="center">
                <h6 class="text-info font-italic font-weight-bold">Pagos de este documento</h6>
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
                <div class="w-100"><hr></div>
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
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-lg-12 col-xl-12">
                        <label for="">Saldo del deposito</label>
                        <input type="text" id="SaldoDelDeposito" name="SaldoDelDeposito" class="form-control form-control-sm" readonly="" >
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-lg-12 col-xl-12 mt-2">
                        <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                            <input type="checkbox" class="custom-control-input selectNotEnter" id="Minicartera" name="Minicartera" style="cursor: pointer !important;">
                            <label class="custom-control-label text-danger labelCheck" for="Minicartera" style="cursor: pointer !important;">Minicartera</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-100"></div>
            <!--TABLA DE DOCUMENTOS CON SALDO POR CLIENTE-->
            <div class="w-100"><hr></div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-10 col-xl-10" align="center">
                <h6 class="text-info font-italic font-weight-bold">Documentos con saldo de este cliente</h6>
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
            SaldoDelDeposito = pnlTablero.find("#SaldoDelDeposito"),
            btnAceptaPagos = pnlTablero.find("#btnAceptaPagos"), btnMovimientos = pnlTablero.find("#btnMovimientos");

    $(document).ready(function () {
        ClientePDC.focus();
        sClientePDC.selectize({
            hideSelected: false,
            openOnFocus: false
        });
        btnMovimientos.click(function () {
            onOpenWindow('<?php print base_url('MovimientosCliente'); ?>');
        });

        ImporteUno.on('keydown keyup', function (e) {
            if (e.keyCode === 13) {
                onRecalcularSaldoActual(1);
            }
        });

        ImporteDos.on('keydown keyup', function (e) {
            if (e.keyCode === 13) {
                onRecalcularSaldoActual(2);
            }
        });

        ImporteTres.on('keydown keyup', function (e) {
            if (e.keyCode === 13) {
                onRecalcularSaldoActual(3);
            }
        });

        ImporteCuatro.on('keydown keyup', function (e) {
            if (e.keyCode === 13) {
                onRecalcularSaldoActual(4);
            }
        });

        MovCuatro.change(function (e) {
            getRefPorMov(MovCuatro.val(), RefCuatro, ImporteCuatro);
            getDescuentoXCliente(ClientePDC, MovCuatro, RefCuatro);
        });

        MovTres.change(function (e) {
            getRefPorMov(MovTres.val(), RefTres, ImporteTres);
            getDescuentoXCliente(ClientePDC, MovTres, RefTres);
        });

        MovDos.change(function (e) {
            getRefPorMov(MovDos.val(), RefDos, ImporteDos);
            getDescuentoXCliente(ClientePDC, MovDos, RefDos);
        });

        MovUno.change(function (e) {
            getRefPorMov(MovUno.val(), RefUno, ImporteUno);
            getDescuentoXCliente(ClientePDC, MovUno, RefUno);
        });

        RefTres.on('keydown keyup', function (e) {
            if (e.keyCode === 13) {
                MovCuatro[0].selectize.focus();
            }
        });

        RefDos.on('keydown keyup', function (e) {
            if (e.keyCode === 13) {
                MovTres[0].selectize.focus();
            }
        });

        RefUno.on('keydown keyup', function (e) {
            if (RefUno.val() && e.keyCode === 13) {
                MovDos[0].selectize.focus();
            }
        });

        btnAceptaPagos.click(function () {
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
                        var p = {
                            CLIENTE: ClientePDC.val(),
                            NUMERO_RF: DoctoPDC.val(),
                            TP: parseInt(TPPDC.val()),
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
                            p.MOVIMIENTO = MovDos.val();
                            p.IMPORTE = ImporteDos.val();
                            p.REF = RefDos.val();
                            onPagoCliente(p);
                        }
                        if (MovTres.val() && ImporteTres.val() && RefTres.val()) {
                            npagos += 1;
                            p.MOVIMIENTO = MovTres.val();
                            p.IMPORTE = ImporteTres.val();
                            p.REF = RefTres.val();
                            onPagoCliente(p);
                        }
                        if (MovCuatro.val() && ImporteCuatro.val() && RefCuatro.val()) {
                            npagos += 1;
                            p.MOVIMIENTO = MovCuatro.val();
                            p.IMPORTE = ImporteCuatro.val();
                            p.REF = RefCuatro.val();
                            onPagoCliente(p);
                        }
                        console.log('PAGOS : ' + npagos);
                        if (npagos > 0) {
                            console.log("\n P CONTIENE \n", p);

                            /*ACTUALIZAR SALDO EN CARTCLIENTE*/
                            $.post('<?php print base_url('PagosDeClientes/onModificaSaldoXDocumento'); ?>', {
                                CLIENTE: ClientePDC.val(),
                                REMISION: DoctoPDC.val(),
                                IMPORTE_INICIAL: ImportePDC.val(),
                                PAGADO: PagosPDC.val(),
                                SALDO: SaldoPDC.val(),
                                NUEVO_PAGADO: (parseFloat(ImportePDC.val()) - parseFloat(SaldoActual.val())),
                                NUEVO_SALDO: SaldoActual.val()
                            }).done(function (a) {
                                console.log(a);
                                /*TERMINAR PROCESO */
                                pnlTablero.find("input:not(#DepositoPDC):not(#Agente)").val('');
                                Banco.empty();
                                MovUno[0].selectize.clear(true);
                                MovDos[0].selectize.clear(true);
                                MovTres[0].selectize.clear(true);
                                MovCuatro[0].selectize.clear(true);
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
                                DoctoPDC.focus().select();
                                onNotifyOld('', 'SE HAN REALIZADO LOS MOVIMIENTOS', 'success');
                            }).fail(function (x) {
                                getError(x);
                            }).always(function () {
                            });
                        } else {
                            onBeep(2);
                            swal('ATENCIÓN', 'ES NECESARIO AÑADIR LOS DATOS DEL PAGO', 'warning').then((value) => {
                                MovUno[0].selectize.focus();
                                MovUno[0].selectize.open();
                            });
                        }
                        HoldOn.close();
                    } else {
                        onBeep(2);
                        swal('ATENCIÓN', 'ES NECESARIO CAPTURAR LA INFORMACIÓN DEL CLIENTE,DEPOSITO,DOCUMENTO,TIPO,FECHAS', 'warning')
                                .then((value) => {
                                    if (!ClientePDC.val()) {
                                        ClientePDC.focus();
                                    } else {
                                        DepositoPDC.focus().select();
                                    }
                                });
                    }
                }
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

                                getBancos(a[0].TIPO);
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
                            } else {
                                swal('ERROR', 'EL DOCUMENTO NO EXISTE', 'warning').then((value) => {
                                    ImportePDC.val('');
                                    PagosPDC.val('');
                                    SaldoPDC.val('');
                                    TPPDC[0].selectize.clear(true);
                                    Dias.val('');
                                    Banco.empty();
                                    DoctoPDC.focus().val('');
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

        ClientePDC.keydown(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON('<?php print base_url('PagosDeClientes/onVerificarCliente'); ?>', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            sClientePDC[0].selectize.addItem(txtcte, true);

                            HoldOn.open({
                                theme: 'sk-rect',
                                message: 'Por favor espere...'
                            });
                            pnlTablero.find("input:not(#FechaPDC):not(#CapturaPDC):not(#DepositoFecha):not(#ClientePDC)").val('');


                            MovUno[0].selectize.clear(true);
                            MovDos[0].selectize.clear(true);
                            MovTres[0].selectize.clear(true);
                            MovCuatro[0].selectize.clear(true);

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
                                            AgentePDC.val(a[0].AGENTE);
                                            DepositoPDC.focus().select();
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
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Por favor espere...'
                });
                ClientePDC.val(sClientePDC.val());
                pnlTablero.find("input:not(#FechaPDC):not(#CapturaPDC):not(#DepositoFecha):not(#ClientePDC)").val('');
                MovUno[0].selectize.clear(true);
                MovDos[0].selectize.clear(true);
                MovTres[0].selectize.clear(true);
                MovCuatro[0].selectize.clear(true);
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
                                DepositoPDC.focus().select();
                            }
                        }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            }
        });

    });

    function getRefPorMov(m, e, nx)
    {
        console.log(m, e);
        switch (parseInt(m)) {
            case 2:
                /*EFECTIVO*/
                e.val("Efe");
                break;
            case 3:
                /*CHEQUE POSFECHADO*/
                e.val("Ch-P");
                break;
            case 5:
                /*DESCUENTO*/
                e.val("Dc17%");
                break;
            case 7:
                /*DIFERENCIA*/
                e.val("Df-P");
                break;
            case 9:
                /*OTROS*/
                e.val("Otr");
                break;
        }
        nx.focus();
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
            "scrollY": "150px",
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
            "scrollY": "150px",
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
                sClientePDC[0].selectize.addOption({text: x.Cliente, value: x.Clave});
            });
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            handleEnterDiv(pnlTablero);
        });
    }

    function getBancos(tp) {
        $.getJSON('<?php print base_url('PagosDeClientes/getBancos') ?>', {Tp: tp})
                .done(function (a) {
                    Banco.append($("<option />").val('').text(''));
                    a.forEach(function (e) {

                        Banco.append($("<option />").val(e.CLAVE).text(e.BANCO));
                    });
                }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }

    function onPagoCliente(p) {
        console.log("\n ONPAGOCLIENTE ", p.IMPORTE, p.MOVIMIENTO, p.REF);
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
        SaldoActual.val(saldo_final);
    }

    function getImporteSinIva(e) {
        var ee = e.val() ? parseFloat(e.val()) : 0;
        return (ee / 1.16);
    }

    function getIntVR(e) {
        return parseInt(e.val() ? e.val() : 0);
    }

    function getDescuentoXCliente(c, mov, ref) {
        if (parseInt(mov.val()) === 5) {
            $.getJSON('<?php print base_url('PagosDeClientes/getDescuentoXCliente'); ?>', {
                CLIENTE: c.val()
            }).done(function (a) {
                if (a.length > 0) {
                    ref.val("DC" + a[0].DESCUENTO + "%");
                }
            }).fail(function (x) {
                getError(x);
            }).always(function () {

            });
        }
    }
</script>
<style>
    .card{
        background-color: #f9f9f9;
        background-color: #f5f6fa;
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
