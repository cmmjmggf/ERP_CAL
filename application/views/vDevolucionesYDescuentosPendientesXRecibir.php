<div class="card m-3 animated fadeIn" id="pnlTablero" style="background-color:  #fff !important;">
    <div class="card-body " style="padding: 7px 10px 10px 10px;"> 
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h5 class="text-danger font-italic"><span class="fa fa-exchange-alt"></span> DEVOLUCIONES Y DESCUENTOS PENDIENTES POR RECIBIR</h5>
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
            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                <label>TP</label>
                <select  id="TP" name="TP" class="form-control form-control-sm">
                    <option></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                <label>Docto</label>
                <input type="text" id="Documento" name="Documento" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                <label>Fecha</label>
                <input type="text" id="FechaDevolucion" name="FechaDevolucion" class="form-control form-control-sm date notEnter">
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-1">
                <p class="font-weight-bold text-danger">Tipos de movimiento 5 = Descuentos  6 = Devoluciones</p>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label>Mov</label>
                <select id="Mov" name="Mov" class="form-control form-control-sm">
                    <option></option>
                    <option value="5">5 Descuentos</option>
                    <option value="6">6 Devoluciones</option>
                </select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Importe</label>
                <input type="text" id="Importe" name="Importe" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Referencia</label>
                <input type="text" id="Referencia" name="Referencia" class="form-control form-control-sm">
            </div>

            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Importe</label>
                <input type="text" id="ImporteTT" name="ImporteTT" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Pagos</label>
                <input type="text" id="Pagos" name="Pagos" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Saldo</label>
                <input type="text" id="Saldo" name="Saldo" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10">
                <p class="font-weight-bold text-danger">DESCUENTOS Y DEVOLUCIONES DE ESTE CLIENTE</p>
                <table id="tblDescuentosYDevoluciones" class="table table-hover table-sm display nowrap"  style="width: 100%!important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Cte</th><!--1-->
                            <th scope="col">Docto</th><!--2-->
                            <th scope="col">Fecha</th><!--3-->
                            <th scope="col">Importe</th><!--4-->
                            <th scope="col">Mov</th><!--5-->
                            <th scope="col">Concepto</th><!--6--><!--1-->
                            <th scope="col">Agt</th><!--7--><!--2--> 
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10">
                <p class="font-weight-bold text-danger">DOCUMENTOS CON SALDO DE ESTE CLIENTE</p>
                <table id="tblDocumentosConSaldoDeEsteCliente" class="table table-hover table-sm display nowrap"  style="width: 100%!important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Cte</th><!--1-->
                            <th scope="col">Docto</th><!--2-->
                            <th scope="col">TP</th><!--3-->
                            <th scope="col">Fecha-DEP</th><!--4-->
                            <th scope="col">Importe</th><!--5-->
                            <th scope="col">Pagos</th><!--6-->
                            <th scope="col">Saldo</th><!--7--> 
                            <th scope="col">St</th><!--8--> 
                            <th scope="col">Dias</th><!--9--> 
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <div class="row">
                    <div class="col-12">
                        <button type="button" id="btnAcepta" name="btnAcepta" class="btn btn-info btn-block" disabled="">
                            <span class="fa fa-check"></span> Acepta
                        </button>
                    </div>
                    <div class="col-12 my-2">
                        <button type="button" id="btnActualizaSTSDescDevol" name="btnActualizaSTSDescDevol" class="btn btn-info btn-block">
                            <span class="fa fa-recycle"></span> Actualiza sts.descu-devol
                        </button>
                    </div>
                    <div class="col-12">
                        <button type="button" id="btnPagosDeClientes" name="btnPagosDeClientes" class="btn btn-info btn-block">
                            <span class="fa fa-check"></span> Pagos de clientes
                        </button>
                    </div>
                    <div class="col-12 my-1"></div>
                    <div class="col-6">
                        <button type="button" id="btnLocPlazas" name="btnLocPlazas" class="btn btn-info btn-block">
                            <span class="fa fa-map"></span> Loc-Plazas
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" id="btnNotaCreditoDD" name="btnNotaCreditoDD" class="btn btn-info btn-block">
                            <span class="fa fa-arrow-down"></span> Nota credito
                        </button>
                    </div>
                    <div class="col-12 my-1"></div>
                    <div class="col-6 ">
                        <button type="button" id="btnMovimientosDD" name="btnMovimientosDD" class="btn btn-info btn-block">
                            <span class="fa fa-compress"></span> Movimientos
                        </button>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

<script>
    var pnlTablero = $("#pnlTablero"), DescuentosYDevoluciones,
            tblDescuentosYDevoluciones = pnlTablero.find("#tblDescuentosYDevoluciones"),
            DocumentosConSaldoDeEsteCliente, tblDocumentosConSaldoDeEsteCliente = pnlTablero.find("#tblDocumentosConSaldoDeEsteCliente"),
            btnPagosDeClientes = pnlTablero.find("#btnPagosDeClientes"),
            ClienteDevolucion = pnlTablero.find('#ClienteDevolucion'),
            TP = pnlTablero.find('#TP'),
            Documento = pnlTablero.find('#Documento'),
            FechaDevolucion = pnlTablero.find('#FechaDevolucion'),
            Mov = pnlTablero.find('#Mov'),
            Importe = pnlTablero.find('#Importe'),
            Referencia = pnlTablero.find('#Referencia'),
            ImporteTT = pnlTablero.find('#ImporteTT'),
            Pagos = pnlTablero.find('#Pagos'),
            Saldo = pnlTablero.find('#Saldo');

    $(document).ready(function () {
        getidsInputSelect(pnlTablero);
        btnPagosDeClientes.click(function () {
            onOpenWindow('<?php print base_url('PagosDeClientes.shoes'); ?>');
        });

        DescuentosYDevoluciones = tblDescuentosYDevoluciones.DataTable({
            dom: 'rtp',
            "ajax": {
                "url": '<?php print base_url('DevolucionesYDescuentosPendientesXRecibir/getDevoluciones'); ?>',
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

        DocumentosConSaldoDeEsteCliente = tblDocumentosConSaldoDeEsteCliente.DataTable({
            dom: 'rtp',
            "ajax": {
                "url": '<?php print base_url('DevolucionesYDescuentosPendientesXRecibir/getDevoluciones'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = ClienteDevolucion.val() ? ClienteDevolucion.val() : '';
                }
            },
            "columns": [
                {"data": "ID"}, {"data": "CLIENTE"},
                {"data": "DOCUMENTO"}, {"data": "TP"},
                {"data": "FECHA_DEP"}, {"data": "IMPORTE"},
                {"data": "PAGOS"}, {"data": "SALDO"},
                {"data": "ST"}, {"data": "DIAS"}
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
    });
</script>