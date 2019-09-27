<div class="card m-3 animated fadeIn" id="pnlTablero" style="background-color:  #fff !important;">
    <div class="card-body " style="padding: 7px 10px 10px 10px;">
        <div class="row"> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <h5 class="text-danger font-italic"><span class="fa fa-exchange-alt"></span> APLICA DEVOLUCIONES PENDIENTES</h5>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <label>Cliente</label>
                        <select id="ClienteDevolucion" name="ClienteDevolucion" class="form-control">
                            <option></option>
                            <?php
                            /* YA CONTIENE LOS BLOQUEOS DE VENTA */
                            foreach ($this->db->query("SELECT C.Clave AS CLAVE, CONCAT(C.Clave, \" - \",C.RazonS) AS CLIENTE, C.Zona AS ZONA, C.ListaPrecios AS LISTADEPRECIO FROM clientes AS C "
                                    . "LEFT JOIN bloqueovta AS B ON C.Clave = B.cliente "
                                    . "WHERE C.Estatus IN('ACTIVO') AND B.cliente IS NULL  OR C.Estatus IN('ACTIVO') AND B.`status` = 2 ORDER BY ABS(C.Clave) ASC;")->result() as $k => $v) {
                                print "<option value='{$v->CLAVE}'>{$v->CLIENTE}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Fecha</label>
                        <input type="text" id="FechaDevolucion" name="FechaDevolucion" class="form-control form-control-sm date notEnter">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                        <label>TP</label>
                        <select  id="TP" name="TP" class="form-control form-control-sm">
                            <option></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>  
                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                        <label>Aplicar</label>
                        <input type="text" id="AplicaDevolucion" name="AplicaDevolucion" class="form-control form-control-sm">
                    </div>

                    <div class="w-100"></div>

                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                        <label>Precio</label>
                        <input type="text" id="Precio" name="Precio" class="form-control form-control-sm numbersOnly">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                        <label>Nota c.</label>
                        <input type="text" id="NotaCredito" name="NotaCredito" class="form-control form-control-sm numbersOnly">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                        <label>Control</label>
                        <input type="text" id="Control" name="Control" class="form-control form-control-sm numbersOnly" readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                        <label>Estilo</label>
                        <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm" readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                        <label>Color</label>
                        <input type="text" id="Color" name="Color" class="form-control form-control-sm" readonly="">
                        <input type="text" id="ColorT" name="ColorT" class="form-control form-control-sm" readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <button type="button" id="btnAcepta" name="btnAcepta" class="btn btn-info" disabled="">
                            <span class="fa fa-check"></span> Acepta
                        </button>
                        <button type="button" id="btnCierraNC" name="btnCierraNC" class="btn btn-info" disabled="">
                            <span class="fa fa-file-code"></span> Cierra N-c
                        </button>
                        <button type="button" id="btnPagos" name="btnPagos" class="btn btn-info">
                            <span class="fa fa-coins"></span> Pagos
                        </button>
                        <button type="button" id="btnMovimientos" name="btnMovimientos" class="btn btn-info">
                            <span class="fa fa-exchange-alt"></span> Movimientos
                        </button>
                        <button type="button" id="btnRastreoCtrlDoc" name="btnRastreoCtrlDoc" class="btn btn-info">
                            <span class="fa fa-search"></span> Rastreo ctr/doc
                        </button> 
                        <button type="button" id="btnRastreoEstCte" name="btnRastreoEstCte" class="btn btn-info">
                            <span class="fa fa-search"></span> Rastreo est/cte
                        </button> 
                    </div>
                </div><!--ROW-->
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <p class="font-weight-bold text-danger">DOCUMENTADOS DE ESTE CLIENTE CON SALDO</p>

                <table id="tblDocDeEsteCteConSaldo" class="table table-hover table-sm display nowrap"  style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Tp</th><!--1-->
                            <th scope="col">Docto</th><!--2-->
                            <th scope="col">Fecha</th><!--3-->
                            <th scope="col">Importe</th><!--4-->
                            <th scope="col">Pagos</th><!--5-->
                            <th scope="col">Saldo</th><!--6--><!--1-->
                            <th scope="col">St</th><!--7--><!--2--> 
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p class="font-weight-bold text-danger">CONTROLES POR APLICAR DE ESTE CLIENTE</p>
                <table id="tblDevCtrlXAplicarDeEsteCliente" class="table table-hover table-sm display nowrap"  style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Cte</th><!--1-->
                            <th scope="col">Docto</th><!--2-->
                            <th scope="col">Control</th><!--3-->
                            <th scope="col">Pares</th><!--4-->
                            <th scope="col">Def</th><!--5-->
                            <th scope="col">Det</th><!--6-->
                            <th scope="col">Cla</th><!--7--> 
                            <th scope="col">Cargo</th><!--8--> 
                            <th scope="col">Maq</th><!--9--> 
                            <th scope="col">Fecha</th><!--10--> 
                            <th scope="col">TP</th><!--11--> 
                            <th scope="col">Concepto</th><!--12--> 
                            <th scope="col">Pre-dv</th><!--13--> 
                            <th scope="col">Pre-cg</th><!--14--> 
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p class="font-weight-bold text-danger">DETALLE DE LA DEVOLUCIÓN</p>

                <table id="tblDevolucionDetalle" class="table table-hover table-sm display nowrap"  style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Cte</th><!--1-->
                            <th scope="col">Docto</th><!--2-->
                            <th scope="col">Aplica</th><!--3-->
                            <th scope="col">N-C</th><!--4-->
                            <th scope="col">Control</th><!--5-->
                            <th scope="col">Pares</th><!--6-->
                            <th scope="col">Def</th><!--7--> 
                            <th scope="col">Det</th><!--8--> 
                            <th scope="col">Cla</th><!--9--> 
                            <th scope="col">Cargo</th><!--10--> 
                            <th scope="col">Fecha</th><!--11--> 
                            <th scope="col">TP</th><!--12--> 
                            <th scope="col">Concepto</th><!--13-->  
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>


        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), ClienteDevolucion = pnlTablero.find('#ClienteDevolucion'),
            FechaDevolucion = pnlTablero.find('#FechaDevolucion'),
            TP = pnlTablero.find('#TP'),
            AplicaDevolucion = pnlTablero.find('#AplicaDevolucion'),
            Precio = pnlTablero.find('#Precio'),
            NotaCredito = pnlTablero.find('#NotaCredito'),
            Control = pnlTablero.find('#Control'), Estilo = pnlTablero.find('#Estilo'),
            Color = pnlTablero.find('#Color'), ColorT = pnlTablero.find('#ColorT'),
            DocDeEsteCteConSaldo,
            tblDocDeEsteCteConSaldo = pnlTablero.find('#tblDocDeEsteCteConSaldo'),
            DevCtrlXAplicarDeEsteCliente,
            tblDevCtrlXAplicarDeEsteCliente = pnlTablero.find('#tblDevCtrlXAplicarDeEsteCliente'),
            DevolucionDetalle,
            tblDevolucionDetalle = pnlTablero.find('#tblDevolucionDetalle'),
            Hoy = '<?php print Date('d/m/Y'); ?>',
            btnAcepta = pnlTablero.find("#btnAcepta"),
            btnCierraNC = pnlTablero.find("#btnCierraNC"),
            btnPagos = pnlTablero.find("#btnPagos"),
            btnMovimientos = pnlTablero.find("#btnMovimientos"),
            btnRastreoCtrlDoc = pnlTablero.find("#btnRastreoCtrlDoc"),
            btnRastreoEstCte = pnlTablero.find("#btnRastreoEstCte");

    $(document).ready(function () {

        handleEnterDiv(pnlTablero);

        AplicaDevolucion.on('keydown', function (e) {
            if (e.keyCode === 13 && $(this).val() && ClienteDevolucion.val()) {
                $.getJSON('<?php print base_url('AplicaDevolucionesDeClientes/onComprobarFacturaXCliente'); ?>', {
                    CLIENTE: ClienteDevolucion.val(),
                    DOCUMENTO: $(this).val(),
                    TP: TP.val() ? TP.val() : ''
                }).done(function (aaa) {
                    console.log(aaa);
                    if (aaa.length <= 0) {
                        onBeep(2);
                        iMsg('ESTE DOCUMENTO NO PERTENECE A ESTE CLIENTE O NO EXISTE, INTENTE CON OTRO NUMERO DE DOCUMENTO', 'w', function () {
                            AplicaDevolucion.focus();
                        }); 
                    }
                }).fail(function (x) {
                    getError(x);
                });
            }
        });

        btnPagos.click(function () {
            onOpenWindow('<?php print base_url('PagosDeClientes.shoes'); ?>');
        });

        btnRastreoEstCte.click(function () {
            onOpenWindow('<?php print base_url('RastreoDeEstilosEnPedidos'); ?>');
        });

        btnRastreoCtrlDoc.click(function () {
            onOpenWindow('<?php print base_url('RastreoDeControlesEnDocumentosClientes'); ?>');
        });

        btnMovimientos.click(function () {
            onOpenWindow('<?php print base_url('MovimientosCliente'); ?>');
        });

        pnlTablero.find("input[name='ReporteX']").change(function () {
            DocDeEsteCteConSaldo.ajax.reload();
        });

        ClienteDevolucion.change(function () {
            DocDeEsteCteConSaldo.ajax.reload();
            DevCtrlXAplicarDeEsteCliente.ajax.reload();
            DevolucionDetalle.ajax.reload();
        });

        ClienteDevolucion[0].selectize.focus();

        FechaDevolucion.val(Hoy);

        $.fn.dataTable.ext.errMode = 'throw';
        DocDeEsteCteConSaldo = tblDocDeEsteCteConSaldo.DataTable({
            dom: 'rtp',
            "ajax": {
                "url": '<?php print base_url('AplicaDevolucionesDeClientes/getDocumentadosDeEsteClienteConSaldo'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = ClienteDevolucion.val() ? ClienteDevolucion.val() : '';
                }
            },
            "columns": [
                {"data": "ID"}, {"data": "TP"},
                {"data": "DOCUMENTO"}, {"data": "FECHA"},
                {"data": "IMPORTE"}, {"data": "PAGOS"},
                {"data": "SALDO"}, {"data": "ST"}
            ],
            "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": 250,
            "scrollX": true,
            "order": [[3, "desc"]],
            responsive: {
                orthogonal: 'responsive'
            },
            "initComplete": function (settings, json) {
            }
        });

        DevCtrlXAplicarDeEsteCliente = tblDevCtrlXAplicarDeEsteCliente.DataTable({
            dom: 'rtp',
            "ajax": {
                "url": '<?php print base_url('AplicaDevolucionesDeClientes/getControlesPorAplicarDeEsteCliente'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = ClienteDevolucion.val() ? ClienteDevolucion.val() : '';
                }
            },
            "columns": [
                {"data": "ID"}, {"data": "CLIENTE"},
                {"data": "DOCUMENTO"}, {"data": "CONTROL"},
                {"data": "PARES"}, {"data": "DEFECTOS"},
                {"data": "DETALLE"}, {"data": "CLASIFICACION"},
                {"data": "CARGO"},
                {"data": "MAQUILA"}, {"data": "FECHA"},
                {"data": "TP"}, {"data": "CONCEPTO"},
                {"data": "PREDV"}, {"data": "PRECG"}
            ],
            "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": 250,
            "scrollX": true,
            "order": [[10, "desc"]],
            responsive: {
                orthogonal: 'responsive'
            },
            "initComplete": function (settings, json) {
            }
        });

        tblDevCtrlXAplicarDeEsteCliente.find('tbody').on('click', 'tr', function () {
            var dtm = DevCtrlXAplicarDeEsteCliente.row(this).data();
            $.post('<?php print base_url('AplicaDevolucionesDeClientes/getInfoXControl'); ?>', {
                CONTROL: dtm.CONTROL
            }).done(function (aaa) {
                console.log(aaa);
            }).fail(function (x) {
                getError(x);
            });
        });

        DevolucionDetalle = tblDevolucionDetalle.DataTable({
            dom: 'rtp',
            "ajax": {
                "url": '<?php print base_url('AplicaDevolucionesDeClientes/getDetalleDevolucion'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = ClienteDevolucion.val() ? ClienteDevolucion.val() : '';
                }
            },
            "columns": [
                {"data": "ID"}, {"data": "CLIENTE"},
                {"data": "DOCUMENTO"}, {"data": "APLICA"},
                {"data": "NC"}, {"data": "CONTROL"},
                {"data": "PARES"}, {"data": "DEFECTOS"},
                {"data": "DETALLES"}, {"data": "CLASIFICACION"},
                {"data": "CARGO"}, {"data": "FECHA"},
                {"data": "TP"}, {"data": "CONCEPTO"}
            ],
            "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": 250,
            "scrollX": true,
            "order": [[11, "desc"]],
            responsive: {
                orthogonal: 'responsive'
            },
            "initComplete": function (settings, json) {
            }
        });
    });
</script>