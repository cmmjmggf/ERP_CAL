<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-3 float-left">
                <legend class="float-left">Historial Clientes</legend>

            </div>
            <div class="col-sm-9" align="right">
                <button type="button" class="btn btn-success btn-sm " id="btnVerMovimientos" >
                    <span class="fa fa-dollar-sign" ></span> MOVIMIENTOS
                </button>
                <button type="button" class="btn btn-primary btn-sm " id="btnVerClientes" >
                    <span class="fa fa-search" ></span> CLIENTES
                </button>
                <button type="button" class="btn btn-warning btn-sm " id="btnVerRanking" >
                    <span class="fa fa-dollar-sign" ></span> VENTAS EST-COL
                </button>
                <button type="button" class="btn btn-danger btn-sm " id="btnVerCartera" >
                    <span class="fa fa-dollar-sign" ></span> EDO. CUENTA
                </button>
                <button type="button" class="btn btn-danger btn-sm " id="" >
                    <span class="fa fa-file-pdf" ></span> PEDIDOS X ENTREGAR
                </button>
                <button type="button" class="btn btn-info btn-sm " id="btnImprimePedidosCliente" >
                    <span class="fa fa-file-pdf" ></span> IMP. TODOS PEDIDOS
                </button>
            </div>
        </div>
        <hr>
        <div class="row ">
            <!--primer columna-->
            <div class="col-7" >
                <div class="row">
                    <div class="col-12 col-sm-8 col-md-6 col-xl-5" >
                        <label for="" >Cliente</label>
                        <select id="Cliente" name="Cliente" class="form-control form-control-sm required" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="row" style="height: 700px; overflow-y: auto;">
                    <!--Primer tabla-->
                    <div class="col-12 mt-1" >
                        <div class="col-12" align="center">
                            <label class="badge badge-success" style="font-size: 14px;">Pedidos Entregados</label>
                        </div>
                        <div class="card-block">
                            <div id="EntregadosCliente" class="datatable-wide">
                                <table id="tblEntregadosCliente" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Pedido</th>
                                            <th>Maq</th>
                                            <th>Fec-Ped</th>
                                            <th>Fec-Ent</th>
                                            <th>Sem</th>
                                            <th>Pares fab</th>
                                            <th>Pares ent</th>
                                            <th>Control</th>
                                            <th>Estilo</th>
                                            <th>Col</th>
                                            <th>Precio</th>
                                            <th>Av</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 border border-info mt-1 border-right-0  border-left-0 border-bottom-0"></div>
                    <!--segunda tabla-->
                    <div class="col-12 mt-1" >
                        <div class="col-12" align="center">
                            <label class="badge badge-warning" style="font-size: 14px;">Pedidos por Entregar</label>
                        </div>
                        <div class="card-block ">
                            <div id="NoEntregadosCliente" class="datatable-wide">
                                <table id="tblNoEntregadosCliente" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Pedido</th>
                                            <th>Maq</th>
                                            <th>Fec-Ped</th>
                                            <th>Fec-Ent</th>
                                            <th>Sem</th>
                                            <th>Pares fab</th>
                                            <th>Pares ent</th>
                                            <th>Control</th>
                                            <th>Estilo</th>
                                            <th>Col</th>
                                            <th>Precio</th>
                                            <th>Av</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 border border-info mt-1 border-right-0  border-left-0 border-bottom-0"></div>
                    <!--tercera tabla-->
                    <div class="col-12 mt-1" >
                        <div class="col-12" align="center">
                            <label class="badge badge-danger" style="font-size: 14px;">Facturado a este cliente</label>
                        </div>
                        <div class="card-block ">
                            <div id="CartCliente">
                                <table id="tblCartCliente" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Docto</th>
                                            <th>Fecha</th>
                                            <th>Importe</th>
                                            <th>Pagos</th>
                                            <th>Saldo</th>
                                            <th>Status</th>
                                            <th>Dias</th>
                                            <th>Tp</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--segunda columna-->
            <div class="col-5 border border-info border-top-0  border-right-0 border-bottom-0">
                <div class="row">
                    <div class="col-12" align="center">
                        <label class="badge badge-info" style="font-size: 14px;">Estadísticas</label>
                    </div>

                    <!--                    primer renglon-->
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" align="center">
                        <label class="text-strong text-danger" style="font-size: 20px;">Pares</label>
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" align="center">
                        <label class="text-strong text-danger" style="font-size: 20px;">Pesos</label>
                    </div>

                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Agente</label>
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="Agente" name="Agente"   >
                    </div>



                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Ped. Entregados</label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="PedEntregados" name="PedEntregados"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label></label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="PedEntregadosPesos" name="PedEntregadosPesos"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Ciudad</label>
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="Ciudad" name="Ciudad"  >
                    </div>


                    <!--                    2do renglon-->
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Ped. X Entregar</label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="PedXEntregar" name="PedXEntregar"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label></label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="PedXEntregarPesos" name="PedXEntregarPesos"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Estado</label>
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="Estado" name="Estado"  >
                    </div>

                    <!--                    3er renglon-->
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Facturación 1</label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="FacturacionUno" name="FacturacionUno"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label></label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="FacturacionUnoPesos" name="FacturacionUnoPesos"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Tel-1</label>
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="Tel1" name="Tel1"  >
                    </div>

                    <!--                    4to renglon-->
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Facturación 2</label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="FacturacionDos" name="FacturacionDos"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label></label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="FacturacionDosPesos" name="FacturacionDosPesos"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Tel-2</label>
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="Tel2" name="Tel2"  >
                    </div>

                    <!--                    5to renglon-->
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label class="text-danger">Total</label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="TotalPares" name="TotalPares"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label></label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="TotalPesos" name="TotalPesos"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Atn. Pagos</label>
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="ResponsablePagos" name="ResponsablePagos"  >
                    </div>
                    <!--                    6to renglon-->
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Pagados</label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="PagadoPares" name="PagadoPares"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label></label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="PagadoPesos" name="PagadoPesos"  >
                    </div>
                    <div class="w-100"></div>
                    <!--                    7mo renglon-->
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Cancelado</label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="CanceladoPares" name="CanceladoPares"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label></label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="CanceladoPesos" name="CanceladoPesos"  >
                    </div>
                    <!--                    8vo renglon-->
                    <div class="w-100"></div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Devolución</label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="DevolPesos" name="DevolPesos"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label></label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="DevolPares" name="DevolPares"  >
                    </div>

                    <div class="w-100"></div>
                    <div class="col-8" align="center">
                        <label class="text-strong text-danger" style="font-size: 20px;">Fechas Último(a)</label>
                    </div>
                    <div class="w-100"></div>

                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Pedido</label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="UltPedido" name="UltPedido"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Venta</label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="UltVenta" name="UltVenta"  >
                    </div>
                    <div class="w-100"></div>


                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Pago</label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="UltPago" name="UltPago"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Devolución</label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="UltDevol" name="UltDevol"  >
                    </div>

                    <div class="w-100"></div>

                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Días Promedio</label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="DiasProm" name="DiasProm"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Pagos Promedio</label>
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="PagosProm" name="PagosProm"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Saldo Actual</label>
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="SaldoFinal" name="SaldoFinal"  >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal " id="mdlDatosDetalle"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de la factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12">
                            <div id="DetalleFactura">
                                <table id="tblDetalleFactura" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Factura</th>
                                            <th>Tp</th>
                                            <th>Control</th>
                                            <th>Fecha</th>
                                            <th>Par</th>
                                            <th>Estilo</th>
                                            <th>Col</th>
                                            <th>Precio</th>
                                            <th>Subtot</th>
                                            <th>St</th>
                                            <th>Agt</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <legend class="float-left">Pagos de esta factura</legend>
                            <div id="DetallePagosFactura">
                                <table id="tblDetallePagosFactura" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Docto</th>
                                            <th>Fec-dep</th>
                                            <th>Fec-cap</th>
                                            <th>Importe</th>
                                            <th>Mov</th>
                                            <th>Ref</th>
                                            <th>Días</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/HistoricoClientePedidoFacturado/';
    var pnlTablero = $("#pnlTablero");
    var tblEntregadosCliente = $('#tblEntregadosCliente');
    var EntregadosCliente;
    var tblNoEntregadosCliente = $('#tblNoEntregadosCliente');
    var NoEntregadosCliente;
    var tblCartCliente = $('#tblCartCliente');
    var CartCliente;
    var tblDetalleFactura = $('#tblDetalleFactura');
    var DetalleFactura;
    var tblDetallePagosFactura = $('#tblDetallePagosFactura');
    var DetallePagosFactura;


    function onImprimirReporteRanking() {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        var frm = new FormData();
        var cliente = pnlTablero.find("#Cliente").val();
        frm.append('Cliente', cliente);
        frm.append('NomCliente', pnlTablero.find("#Cliente option:selected").text());

        $.ajax({
            url: base_url + 'index.php/HistoricoClientePedidoFacturado/onImprimirReporteRanking',
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
                    text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                    icon: "error"
                }).then((action) => {
                    pnlTablero.find("#Cliente")[0].selectize.focus();
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }

    function onImprimirReportePedidosEntregados() {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        var frm = new FormData();
        var cliente = pnlTablero.find("#Cliente").val();
        frm.append('Cliente', cliente);
        $.ajax({
            url: base_url + 'index.php/HistoricoClientePedidoFacturado/onImprimirReportePedidoEntregadosCliente',
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
                    text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                    icon: "error"
                }).then((action) => {
                    pnlTablero.find("#Cliente")[0].selectize.focus();
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }

    $(document).ready(function () {



        getClientes();
        getPedidosEntregados(0);
        getPedidosNoEntregados(0);
        pnlTablero.find("#Cliente")[0].selectize.focus();
        pnlTablero.find("#Cliente").change(function () {
            if ($(this).val()) {
                onOpenOverlay('Cargando datos, por favor espere...');
                var cliente = $(this).val();
                //Obtener registros entregados pedidos

                getPedidosEntregados(cliente);
                getPedidosNoEntregados(cliente);
                getCartCliente(cliente);

                //TODO EN UNO ---------------------------------------------------------------------------------------------------------------
                $.getJSON(master_url + 'getInfoTodo', {Cliente: cliente}).done(function (data) {
                    var f1pesos = 0;
                    var f1pares = 0;
                    var f2pares = 0;
                    var f2pesos = 0;
                    var tpares = 0;
                    var tpesos = 0;
                    //DATOS CLIENTE GENERALES ---------------------------------------------------------------------------------------------------------------
                    var datosCliente = JSON.parse(data['UNO'])[0];
                    pnlTablero.find("#Agente").val(datosCliente.Agente);
                    pnlTablero.find("#Ciudad").val(datosCliente.Ciudad);
                    pnlTablero.find("#Estado").val(datosCliente.Estado);
                    pnlTablero.find("#Tel2").val(datosCliente.TelOficina);
                    pnlTablero.find("#Tel1").val(datosCliente.TelPart);
                    pnlTablero.find("#ResponsablePagos").val(datosCliente.EncargadoDePagos);
                    //SACA LOS PARES Y PESOS DE LO QUE ESTA EN PEDIDOS ENTREGADOS  ---------------------------------------------------------------------------
                    var datosEntregados = JSON.parse(data['DOS'])[0];
                    pnlTablero.find("#PedEntregados").val($.number(parseFloat(datosEntregados.paresEntregados), 0, '.', ','));
                    pnlTablero.find("#PedEntregadosPesos").val('$' + $.number(parseFloat(datosEntregados.pesosEntregados), 2, '.', ','));
                    pnlTablero.find("#UltPedido").val(datosEntregados.FechaPedido);
                    //SACA LOS PARES Y PESOS DE LO QUE ESTA EN PEDIDOS SIN ENTREGAR  ---------------------------------------------------------------------------
                    var datosNoEntregados = JSON.parse(data['TRES'])[0];
                    pnlTablero.find("#PedXEntregar").val($.number(parseFloat(datosNoEntregados.paresNoEntregados), 0, '.', ','));
                    pnlTablero.find("#PedXEntregarPesos").val('$' + $.number(parseFloat(datosNoEntregados.pesosNoEntregados), 2, '.', ','));
                    //SACA LOS PARES Y PESOS DE LO QUE ESTA FACTURADO como tp - 1 ECEPTO CANCELADO -------------------------------------------------------------------------- -
                    var datosFactUno = JSON.parse(data['CUATRO']);
                    pnlTablero.find("#FacturacionUno").val($.number(parseFloat(datosFactUno[0].paresFacturadosUno), 0, '.', ','));
                    pnlTablero.find("#FacturacionUnoPesos").val('$' + $.number(parseFloat(datosFactUno[0].pesosFacturadosUno), 2, '.', ','));
                    pnlTablero.find("#UltVenta").val(datosFactUno[0].fecha);
                    //Llenamos las variables para sumatoria total tp y tp 2
                    f1pesos = parseFloat(datosFactUno[0].pesosFacturadosUno);
                    f1pares = parseFloat(datosFactUno[0].paresFacturadosUno);
                    //SACA LOS PARES Y PESOS DE LO QUE ESTA FACTURADO como tp-2 ECEPTO CANCELADO ---------------------------------------------------------------------------
                    var datosFactDos = JSON.parse(data['CINCO']);
                    pnlTablero.find("#FacturacionDos").val($.number(parseFloat(datosFactDos[0].paresFacturadosDos), 0, '.', ','));
                    pnlTablero.find("#FacturacionDosPesos").val('$' + $.number(parseFloat(datosFactDos[0].pesosFacturadosDos), 2, '.', ','));
                    //Si trae datos en tp 2 se ponen para sumarlo a las variables
                    f2pares = parseFloat(datosFactDos[0].paresFacturadosDos);
                    f2pesos = parseFloat(datosFactDos[0].pesosFacturadosDos);
                    //Actualizamos variables con datos de la suma
                    tpares = f1pares + f2pares;
                    tpesos = f1pesos + f2pesos;
                    //Sumamos totales
                    pnlTablero.find("#TotalPares").val($.number(tpares, 0, '.', ','));
                    pnlTablero.find("#TotalPesos").val('$' + $.number(tpesos, 2, '.', ','));
                    //SACA LOS PARES Y PESOS DE LO QUE ESTA FACTURADO pero CANCELADO ---------------------------------------------------------------------------
                    var datosCancelado = JSON.parse(data['SEIS']);
                    pnlTablero.find("#CanceladoPares").val($.number(parseFloat(datosCancelado[0].paresCancelados), 0, '.', ','));
                    pnlTablero.find("#CanceladoPesos").val('$' + $.number(parseFloat(datosCancelado[0].pesosCancelados), 2, '.', ','));
                    //SACA LOS PARES Y PESOS DE LO QUE NOS PAGO ------------------------------------------------------------------------------------------------------------------
                    var datosPagado = JSON.parse(data['SIETE']);
                    pnlTablero.find("#PagadoPares").val($.number(parseFloat(datosPagado[0].ParesPagados), 0, '.', ','));
                    pnlTablero.find("#PagadoPesos").val('$' + $.number(parseFloat(datosPagado[0].PesosPagados), 2, '.', ','));
                    pnlTablero.find("#UltPago").val(datosPagado[0].ultPago);
                    //SACA LOS PARES Y PESOS DE LO QUE NOS devolvio ------------------------------------------------------------------------------------------------------------------
                    var datosDevol = JSON.parse(data['OCHO']);
                    pnlTablero.find("#DevolPesos").val($.number(parseFloat(datosDevol[0].ParesDevueltos), 0, '.', ','));
                    pnlTablero.find("#DevolPares").val('$' + $.number(parseFloat(datosDevol[0].ParesPagados), 2, '.', ','));
                    pnlTablero.find("#UltDevol").val(datosDevol[0].UltDevol);
                    //SACA LOS DIAS PROMEDIO --------------------------------------------------------------------------------------------------------------------
                    var datosPromedio = JSON.parse(data['NUEVE']);
                    pnlTablero.find("#DiasProm").val($.number(parseFloat(datosPromedio[0].diasPromedio), 0, '.', ','));
                    pnlTablero.find("#PagosProm").val('$' + $.number(parseFloat(datosPromedio[0].promedioPagos), 2, '.', ','));
                    //SACA SALDO DE ESTE CLIENTE  ---------------------------------------------------------------------------
                    var datosSaldo = JSON.parse(data['DIEZ']);
                    pnlTablero.find("#SaldoFinal").val('$' + $.number(parseFloat(datosSaldo[0].saldo), 2, '.', ','));
                    onCloseOverlay();
                }).fail(function (x) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });
        /*Botones*/
        pnlTablero.find("#btnVerRanking").click(function () {
            var cliente = pnlTablero.find("#Cliente").val();
            if (cliente) {
                onImprimirReporteRanking();
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE SELECCIONAR UN CLIENTE",
                    icon: "error",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    pnlTablero.find("#Cliente")[0].selectize.focus();
                });
            }
        });

        pnlTablero.find("#btnImprimePedidosCliente").click(function () {
            var cliente = pnlTablero.find("#Cliente").val();
            if (cliente) {
                onImprimirReportePedidosEntregados();
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE SELECCIONAR UN CLIENTE",
                    icon: "error",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    pnlTablero.find("#Cliente")[0].selectize.focus();
                });
            }
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
        pnlTablero.find("#btnVerClientes").click(function () {
            $.fancybox.open({
                src: base_url + '/Clientes',
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
        pnlTablero.find('#btnVerCartera').on("click", function () {
            var cliente = pnlTablero.find("#Cliente").val();
            if (cliente) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                $.ajax({
                    url: base_url + 'index.php/MovimientosCliente/' + 'imprimirReportesCartera',
                    type: "POST",
                    data: {
                        Cliente: cliente
                    }
                }).done(function (data, x, jq) {
                    console.log(data);
                    onImprimirReporteFancyArray(JSON.parse(data));
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE SELECCIONAR UN CLIENTE",
                    icon: "error",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    pnlTablero.find("#Cliente")[0].selectize.focus();
                });
            }
        });
    });

    function getClientes() {
        pnlTablero.find("#Cliente")[0].selectize.clear(true);
        pnlTablero.find("#Cliente")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getClientes').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Cliente")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
            pnlTablero.find("#Cliente")[0].selectize.open();
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getDetallePagosFactura(cliente, tp, fact) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDetallePagosFactura')) {
            tblDetallePagosFactura.DataTable().destroy();
        }

        DetallePagosFactura = tblDetallePagosFactura.DataTable({
            "dom": 'frtp',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getDetallePagosFactura',
                "dataSrc": "",
                "data": {Cliente: cliente, Tp: tp, Factura: fact},
                "type": "GET"
            },
            "columns": [
                {"data": "remicion"},
                {"data": "fechadep"},
                {"data": "fechacap"},
                {"data": "importe"},
                {"data": "mov"},
                {"data": "doctopa"},
                {"data": "dias"}
            ],
            "columnDefs": [
                {
                    "targets": [3],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 100,
            "scrollX": true,
            "scrollY": 200,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [1, 'desc']
            ]
        });
        tblDetallePagosFactura.find('tbody').on('click', 'tr', function () {
            tblDetallePagosFactura.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }
    function getDetalleFactura(cliente, tp, fact) {
        $('#mdlDatosDetalle').modal('show');
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDetalleFactura')) {
            tblDetalleFactura.DataTable().destroy();
        }

        DetalleFactura = tblDetalleFactura.DataTable({
            "dom": 'frtp',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getDetalleFactura',
                "dataSrc": "",
                "data": {Cliente: cliente, Tp: tp, Factura: fact},
                "type": "GET"
            },
            "columns": [
                {"data": "factura"},
                {"data": "tp"},
                {"data": "contped"},
                {"data": "fecha"},
                {"data": "pareped"},
                {"data": "estilo"},
                {"data": "combin"},
                {"data": "precto"},
                {"data": "subtot"},
                {"data": "status"},
                {"data": "agente"}
            ],
            "columnDefs": [
                {
                    "targets": [7, 8],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }

            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 100,
            "scrollX": true,
            "scrollY": 200,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [5, 'asc']
            ]
        });
        tblDetalleFactura.find('tbody').on('click', 'tr', function () {
            tblDetalleFactura.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        tblDetalleFactura.find('tbody').on('dblclick', 'tr', function () {
            tblDetalleFactura.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = DetalleFactura.row(this).data();
            getDetallePagosFactura(cliente, dtm.tp, dtm.factura);

        });
    }
    function getCartCliente(cliente) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblCartCliente')) {
            tblCartCliente.DataTable().destroy();
        }

        CartCliente = tblCartCliente.DataTable({
            "dom": 'frtp',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getCartCliente',
                "dataSrc": "",
                "data": {Cliente: cliente},
                "type": "GET"
            },
            "columns": [
                {"data": "cliente"},
                {"data": "remicion"},
                {"data": "fecha"},
                {"data": "importe"},
                {"data": "pagos"},
                {"data": "saldo"},
                {"data": "status"},
                {"data": "numpol"},
                {"data": "tipo"}
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 100,
            "scrollX": true,
            "scrollY": 220,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [2, 'desc']
            ]
        });
        tblCartCliente.find('tbody').on('click', 'tr', function () {
            tblCartCliente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        tblCartCliente.find('tbody').on('dblclick', 'tr', function () {
            tblCartCliente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = CartCliente.row(this).data();
            getDetalleFactura(dtm.cliente, dtm.tipo, dtm.remicion);
        });
    }
    function getPedidosEntregados(cliente) {
        $.fn.dataTable.ext.errMode = 'throw';

        if ($.fn.DataTable.isDataTable('#tblEntregadosCliente')) {
            tblEntregadosCliente.DataTable().destroy();
        }

        EntregadosCliente = tblEntregadosCliente.DataTable({
            "dom": 'frtp',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getPedidosEntregados',
                "dataSrc": "",
                "data": {Cliente: cliente},
                "type": "GET"
            },
            "columns": [
                {"data": "cliente"},
                {"data": "pedido"},
                {"data": "maquila"},
                {"data": "fechaped"},
                {"data": "fechaentrega"},
                {"data": "semana"},
                {"data": "pares"},
                {"data": "paresfacturados"},
                {"data": "control"},
                {"data": "estilo"},
                {"data": "color"},
                {"data": "precio"},
                {"data": "avance"}
            ],

            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 100,
            "scrollX": true,
            "scrollY": 220,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [3, 'desc']
            ]
        });
        tblEntregadosCliente.find('tbody').on('click', 'tr', function () {
            tblEntregadosCliente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });

        tblEntregadosCliente.find('tbody').on('dblclick', 'tr', function () {
            tblEntregadosCliente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = EntregadosCliente.row(this).data();

            swal("Imprimir", "Pedido: " + dtm.pedido + ' \nCliente: ' + dtm.cliente, {
                buttons: ["Cancelar", true]
            }).then((value) => {
                if (value) {
                    HoldOn.open({theme: 'sk-cube', message: 'CARGANDO...'});
                    $.post(base_url + 'index.php/Pedidos/onImprimirPedidoReducido', {ID: dtm.pedido, CLIENTE: dtm.cliente}).done(function (data) {
                        //check Apple device

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

                    }).fail(function (x, y, z) {
                        HoldOn.close();
                        console.log(x, y, z);
                        swal('ATENCIÓN', 'NO HA SIDO POSIBLE MOSTRAR EL PEDIDO PARA SU IMPRESIÓN,VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'warning');
                    }).always(function () {
                        HoldOn.close();
                    });
                }
            });

        });
    }
    function getPedidosNoEntregados(cliente) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblNoEntregadosCliente')) {
            tblNoEntregadosCliente.DataTable().destroy();
        }

        NoEntregadosCliente = tblNoEntregadosCliente.DataTable({
            "dom": 'frtp',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getPedidosNoEntregados',
                "dataSrc": "",
                "data": {Cliente: cliente},
                "type": "GET"
            },
            "columns": [
                {"data": "cliente"},
                {"data": "pedido"},
                {"data": "maquila"},
                {"data": "fechaped"},
                {"data": "fechaentrega"},
                {"data": "semana"},
                {"data": "pares"},
                {"data": "paresfacturados"},
                {"data": "control"},
                {"data": "estilo"},
                {"data": "color"},
                {"data": "precio"},
                {"data": "avance"}
            ],

            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 100,
            "scrollX": true,
            "scrollY": 220,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [3, 'desc']
            ]
        });
        tblNoEntregadosCliente.find('tbody').on('click', 'tr', function () {
            tblNoEntregadosCliente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        tblNoEntregadosCliente.find('tbody').on('dblclick', 'tr', function () {
            tblNoEntregadosCliente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = NoEntregadosCliente.row(this).data();

            swal("Imprimir", "Pedido: " + dtm.pedido + ' \nCliente: ' + dtm.cliente, {
                buttons: ["Cancelar", true]
            }).then((value) => {
                if (value) {
                    HoldOn.open({theme: 'sk-cube', message: 'CARGANDO...'});
                    $.post(base_url + 'index.php/PrioridadesPorCliente/' + 'onImprimirReportePedidoControl', {Pedido: dtm.pedido, Cliente: dtm.cliente}).done(function (data) {
                        onNotifyOld('fa fa-check', 'REPORTE GENERADO', 'success');
                        onImprimirReporteFancy(data);
                        HoldOn.close();
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            });

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

    .verde  {
        background-color: #4BEFF1 !important;
    }

    .rojo {
        background-color: #FFBEAC !important;

    }
    label {
        margin-top: 0.14rem;
        margin-bottom: 0.0rem;
    }

    .form-control-sm,  .form-control {
        padding: 0.15rem 0.5rem;
    }
</style>
