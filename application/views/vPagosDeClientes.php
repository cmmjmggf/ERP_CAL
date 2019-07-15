<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <h4 class="card-title">Pagos de clientes</h4>
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
                <input type="text" id="TPPDC" name="TPPDC" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-1 col-xl-1">
                <label for="">Captura</label>
                <input type="text" id="CapturaPDC" name="CapturaPDC" class="form-control form-control-sm date">
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-3 col-xl-3">
                <label for="">Importe</label>
                <input type="text" id="ImportePDC" name="ImportePDC" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <label for="">Pagos</label>
                <input type="text" id="PagosPDC" name="PagosPDC" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <label for="">Saldo</label>
                <input type="text" id="SaldoPDC" name="SaldoPDC" class="form-control form-control-sm numbersOnly">
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
                        <input type="text" id="MovUno" name="MovUno" class="form-control form-control-sm numbersOnly" maxlength="1" min="2" max="9">
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
                        <input type="text" id="MovTres" name="MovTres" class="form-control form-control-sm numbersOnly" maxlength="1" min="2" max="9">
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
                        <input type="text" id="MovDos" name="MovDos" class="form-control form-control-sm numbersOnly" maxlength="1" min="2" max="9">
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
                        <input type="text" id="MovCuatro" name="MovCuatro" class="form-control form-control-sm numbersOnly" maxlength="1" min="2" max="9">
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
                        <input type="text" id="Deposito" name="Deposito" class="form-control form-control-sm date">
                    </div>
                </div>
            </div>

            <div class="w-100 my-3"><hr></div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-12 col-xl-12 text-center mt-3" style="cursor:pointer !important; ">
                <h3 class="text-danger font-weight-bold font-italic">SOLO EN CASO DE * * * EFECTIVO Y DEPOSITO * * *</h3>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-10 col-xl-10">
                <label for="">Banco</label>
                <select id="Banco" name="Banco" class="form-control form-control-sm"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <label for="">Cuenta</label>
                <input type="text" id="Cuenta" name="Cuenta" class="form-control form-control-sm" maxlength="99">
            </div>
            <div class="w-100 my-3"><hr></div>
            <!--TABLA DE PAGOS POR DOCUMENTO-->
            <div class="col-12 col-xs-12 col-sm-12 col-lg-10 col-xl-10" align="center">
                <h3 class="text-info font-italic">Pagos de este documento</h3>
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
                <input type="text" id="SaldoDelDeposito" name="SaldoDelDeposito" class="form-control form-control-sm" >
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-10 col-xl-10">
                <label for="">Folio fiscal</label>
                <input type="text" id="FolioFiscal" name="FolioFiscal" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <label for="">SALDO ACTUAL</label>
                <input type="text" id="SaldoActual" name="SaldoActual" class="form-control form-control-sm" readonly="">
            </div>
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
            ImportePDC = pnlTablero.find("#ImportePDC"),
            PagosPDC = pnlTablero.find("#PagosPDC"),
            SaldoPDC = pnlTablero.find("#SaldoPDC"),
            FechaPDC = pnlTablero.find("#FechaPDC"),
            PagosDeEsteDocumento,
            tblPagosDeEsteDocumento = pnlTablero.find("#tblPagosDeEsteDocumento"),
            ClientePDC = pnlTablero.find("#ClientePDC"),
            DocumentosConSaldoXClientes,
            tblDocumentosConSaldoXClientes = pnlTablero.find("#tblDocumentosConSaldoXClientes"),
            SaldoTotalPendiente = pnlTablero.find("#SaldoTotalPendiente"),
            FechaActual = '<?php print Date('d/m/Y'); ?>', Deposito = pnlTablero.find("#Deposito"),
            CapturaPDC = pnlTablero.find("#CapturaPDC"),
            SaldoDelDeposito = pnlTablero.find("#SaldoDelDeposito");

    $(document).ready(function () {
        DoctoPDC.on('keydown keyup', function (e) { 
            if (e.keyCode === 13) {
                onNotifyOld('', 'OBTENIENDO INFORMACIÓN DEL DOCUMENTO...', 'info');
                $.getJSON('<?php print base_url('PagosDeClientes/getDatosDelDocumentoConSaldo'); ?>', {DOCUMENTO: DoctoPDC.val()})
                        .done(function (a) {
                            PagosDeEsteDocumento.ajax.reload();
                            DocumentosConSaldoXClientes.ajax.reload();
                            if (a.length > 0) {
                                ImportePDC.val(a[0].IMPORTE);
                                PagosPDC.val(a[0].PAGOS);
                                SaldoPDC.val(a[0].SALDO);
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

        CapturaPDC.val(FechaActual);
        Deposito.val(FechaActual);

        getClientes();
        getPagosDocumento();
        getDocumentosConSaldoXClientes();

        ClientePDC.change(function (e) {
            PagosDeEsteDocumento.ajax.reload(function () {
                onNotifyOld('', 'OBTENIENDO INFORMACIÓN...', 'info');
            });
            DocumentosConSaldoXClientes.ajax.reload();
        });

    });

    function getPagosDocumento() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblPagosDeEsteDocumento')) {
            tblPagosDeEsteDocumento.DataTable().destroy();
        }
        PagosDeEsteDocumento = tblPagosDeEsteDocumento.DataTable({
            "dom": 'frtip',
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
            "displayLength": 20,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "scrollY": "350px",
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
            "dom": 'frtip',
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
            "displayLength": 20,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "scrollY": "350px",
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