<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-5"> 
                <button type="button" id="btnControlesXFac" name="btnControlesXFac" class="btn btn-info">
                    Controles x facturar
                </button>
                <button type="button" id="btnClientes" name="btnClientes" class="btn btn-info">
                    Clientes
                </button>
                <button type="button" id="btnClientes" name="btnClientes" class="btn btn-info">
                    Mov-Ctes
                </button>
                <button type="button" id="btnReimprimeDocto" name="btnReimprimeDocto" class="btn btn-info">
                    Reimprimer docto
                </button>
                <button type="button" id="btnVistaPreviaF" name="btnVistaPreviaF" class="btn btn-info">
                    Vista previa
                </button>
            </div>
            <div class="col-sm-2" align="center"> 
                <h4 class="font-weight-bold font-italic">FACTURACIÓN</h4>
            </div> 
            <div class="col-sm-5" align="right"> 
                <button type="button" id="btnCierraDocto" name="btnCierraDocto" class="btn btn-danger">
                    Cierra docto
                </button>
                <button type="button" id="btnAdendaCoppel" name="btnAdendaCoppel" class="btn btn-info">
                    Adenda COPPEL
                </button>
                <button type="button" id="btnTimbrarFac" name="btnTimbrarFac" class="btn btn-warning">
                    Timbrar fac
                </button>
                <button type="button" id="btnCancelaDoc" name="btnCancelaDoc" class="btn btn-danger">
                    Cancela doc
                </button>
                <button type="button" id="btnDevolucion" name="btnDevolucion" class="btn btn-primary">
                    Devolución
                </button>
                <button type="button" id="btnEtiquetasParaCaja" name="btnEtiquetasParaCaja" class="btn btn-primary">
                    Etiquetas para caja
                </button>
            </div>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="w-100 mt-4"></div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-2 col-lg-4 col-xl-1">
                    <label>Fecha</label>
                    <input type="text" id="FechaFactura" name="FechaFactura" class="form-control form-control-sm date notEnter">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-2"> 
                    <div class="form-group">
                        <label class="control-label">Cliente</label>
                        <div class="form-group">
                            <div class="input-group mb-3"> 
                                <select id="ClienteFactura" name="ClienteFactura" class="form-control">
                                    <option></option>
                                    <?php
                                    foreach ($this->db->select("C.Clave AS CLAVE, CONCAT(C.Clave, \" - \",C.RazonS) AS CLIENTE, C.ListaPrecios AS LISTADEPRECIO", false)
                                            ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('ABS(C.Clave)', 'ASC')->get()->result() as $k => $v) {
                                        print "<option value='{$v->CLAVE}' lista='{$v->LISTADEPRECIO}'>{$v->CLIENTE}</option>";
                                    }
                                    ?>
                                </select>
                                <div class="input-group-append">
                                    <button type="button" id="btnVerTienda" name="btnVerTienda" class="btn btn-info btn-sm mx-1 grouped d-none animated fadeIn">
                                        <span class="fa fa-exclamation"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1 ">
                    <label>L-P</label>
                    <input type="text" id="LPFactura" name="LPFactura" readonly="" data-toggle="tooltip" data-placement="bottom" title="Lista de precios"  class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1 ">
                    <label>TP</label>
                    <input type="text" id="TPFactura" name="TPFactura" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1">
                    <label>FA-PE.ORCO</label>
                    <input type="text" id="FAPEORCOFactura" name="FAPEORCOFactura" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1">
                    <label>FC.A</label>
                    <input type="number" id="FCAFactura" name="FCAFactura" max="2" min="0" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1">
                    <label>PAG</label>
                    <input type="number" id="PAGFactura" name="PAGFactura" max="2" min="0" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1">
                    <label>T-MNDA</label>
                    <input type="number" id="TMNDAFactura" name="TMNDAFactura" max="2" min="0" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1">
                    <label>FOLIO</label>
                    <input type="number" id="FolioFactura" name="FolioFactura" max="2" min="0" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1">
                    <div class="form-group"> 
                        <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                            <input type="checkbox" class="custom-control-input selectNotEnter" id="cCST" name="cCST" style="cursor: pointer !important;">
                            <label class="custom-control-label text-danger labelCheck" for="cCST" style="cursor: pointer !important;">CTRL SIN TERMINAR</label>
                        </div>
                    </div>      
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1">
                    <div class="form-group">  
                        <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                            <input type="checkbox" class="custom-control-input selectNotEnter" id="cNoIva" name="cNoIva" style="cursor: pointer !important;">
                            <label class="custom-control-label text-danger labelCheck" for="cNoIva" style="cursor: pointer !important;">NO I.V.A</label>
                        </div>
                    </div>      
                </div>
                <div id="ConsignarATienda" style="z-index: 5 !important;" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none animated fadeIn">
                    <div class="row">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-1 col-xl-1"></div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <div class="alert alert-info  alert-dismissible m-2" role="alert">
                                <h4 class="alert-heading">Consignar a</h4>

                                <select id="Tienda" name="Tienda" class="form-control">
                                    <option></option>
                                    <?php
                                    foreach ($this->db->select("C.Clave AS CLAVE, CONCAT(C.Clave, \" - \",C.Consignatario) AS CONSIGNATARIO", false)
                                            ->from('consignatarios AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('ABS(C.Clave)', 'ASC')->get()->result() as $k => $v) {
                                        print "<option value='{$v->CLAVE}'>{$v->CONSIGNATARIO}</option>";
                                    }
                                    ?>
                                </select> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100"></div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1">
                    <label>Control</label>
                    <input type="text" id="Control" name="Control" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1">
                    <label>Corrida</label>
                    <input type="text" id="Corrida" name="Corrida" class="form-control form-control-sm" readonly="">
                </div>

                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-1 col-xl-1"></div>

                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-11 col-xl-10">
                    <div class="table-responsive" style="overflow-x:auto; white-space: nowrap;">
                        <label class="font-weight-bold" for="Tallas"></label>
                        <table id="tblTallasF" class="Tallas">
                            <thead></thead>
                            <tbody>
                                <tr id="rTallasBuscaManual">
                                    <td class="font-weight-bold">Tallas</td>
                                    <?php
                                    for ($index = 1; $index < 21; $index++) {
                                        print '<td><input type="text" style="width: 55px;" id="T' . $index . '" name="T' . $index . '"   readonly="" data-toggle="tooltip" data-placement="top" title="XXX" class="form-control form-control-sm"></td>';
                                    }
                                    ?>
                                    <td></td> 
                                </tr>  
                                <tr class="rCapturaCantidades" id="rCantidades">
                                    <td class="font-weight-bold">Pares d'control</td>
                                    <?php
                                    for ($index = 1; $index < 21; $index++) {
                                        print '<td><input type="text" style="width: 55px;" id="C' . $index . '" maxlength="3"  readonly="" class="form-control form-control-sm numbersOnly " name="C' . $index . '"  data-toggle="tooltip" data-placement="top" title="-" onfocus="onCalcularPares(this,1);" onchange="onCalcularPares(this,1);" keyup="onCalcularPares(this,1);" onfocusout="onCalcularPares(this,1);"></td>';
                                    }
                                    ?>
                                    <td class="font-weight-bold"><input type="text" style="width: 55px;" id="TotalParesEntrega" class="form-control form-control-sm " readonly=""  data-toggle="tooltip" data-placement="top" title="0"></td>
                                    <td>
                                    </td>
                                </tr>
                                <tr class="rCapturaCantidades" id="rCantidades">
                                    <td class="font-weight-bold">Facturado</td>
                                    <?php
                                    for ($index = 1; $index < 21; $index++) {
                                        print '<td><input type="text" style="width: 55px;" id="CF' . $index . '" maxlength="3"  readonly="" class="form-control form-control-sm numbersOnly " name="CF' . $index . '" onfocus="onCalcularPares(this,2);" onchange="onCalcularPares(this,2);" keyup="onCalcularPares(this,2);" onfocusout="onCalcularPares(this,2);"></td>';
                                    }
                                    ?>
                                    <td class="font-weight-bold">
                                        <input type="text" style="width: 55px;" id="TotalParesEntregaF" 
                                               class="form-control form-control-sm " readonly="" data-toggle="tooltip" data-placement="right" title="0">
                                    </td>
                                </tr>
                                <tr class="rCapturaCantidades" id="rCantidades">
                                    <td class="font-weight-bold">A Facturar</td>
                                    <?php
                                    for ($index = 1; $index < 21; $index++) {
                                        print '<td><input type="text" style="width: 55px;" id="CAF' . $index . '" maxlength="3" class="form-control form-control-sm numbersOnly " name="CAF' . $index . '" onfocus="onCalcularPares(this,3);" onchange="onCalcularPares(this,3);" keyup="onCalcularPares(this,3);" onfocusout="onCalcularPares(this,3);"></td>';
                                    }
                                    ?>
                                    <td class="font-weight-bold"><input type="text" style="width: 55px;" id="TotalParesEntregaAF" class="form-control form-control-sm " readonly=""  data-toggle="tooltip" data-placement="right" title="0"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                    <div class="row">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <button type="button" class="btn btn-info">
                                Factura por anticipo de producto
                            </button>
                            <button type="button" class="btn btn-info">
                                Control incompleto
                            </button>
                            <button type="button" class="btn btn-info">
                                Control completo o saldo del control
                            </button>
                        </div> 
                    </div>
                </div>

                <div class="w-100"></div>

                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                    <label>Referencia</label>
                    <input type="text" id="ReferenciaFacturacion" name="ReferenciaFacturacion" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                    <label>Cajas</label>
                    <input type="text" id="CajasFacturacion" name="CajasFacturacion" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                    <label>Estilo</label>
                    <input type="text" id="EstiloFacturacion" name="EstiloFacturacion" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                    <label>Color</label>
                    <input type="text" id="ColorFacturacion" name="ColorFacturacion" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                    <label>Corrida</label>
                    <input type="text" id="CorridaFacturacion" name="CorridaFacturacion" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                    <label>Precio</label>
                    <input type="text" id="PrecioFacturacion" name="PrecioFacturacion" class="form-control form-control-sm">
                </div>
                <div class="w-100"></div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                    <label>Subtotal</label>
                    <input type="text" id="SubtotalFacturacion" name="SubtotalFacturacion" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2">
                    <div class="form-group mt-4">  
                        <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                            <input type="checkbox" class="custom-control-input selectNotEnter" id="xRefacturacion" name="xRefacturacion" style="cursor: pointer !important;">
                            <label class="custom-control-label text-danger labelCheck" for="xRefacturacion" style="cursor: pointer !important;">X Refacturación</label>
                        </div>
                    </div>      
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <label>Observación</label>
                    <textarea id="ObservacionFacturacion" name="ObservacionFacturacion" class="form-control form-control-sm" rows="2" cols="3"></textarea>
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                    <label>Descuento</label>
                    <input type="text" id="DescuentoFacturacion" name="DescuentoFacturacion" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                    <label>Pares Facturados</label>
                    <input type="text" id="ParesFacturadosFacturacion" name="ParesFacturadosFacturacion" readonly="" class="form-control form-control-sm">
                </div>
                <div class="w-100 my-3"></div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <table id="tblParesFacturados" class="table table-hover table-sm"  style="width: 100% !important;">
                        <thead>
                            <tr>
                                <th scope="col">ID</th><!--0-->
                                <th scope="col">Factura</th><!--1-->
                                <th scope="col">Cliente</th><!--2-->
                                <th scope="col">Control</th><!--3-->
                                <th scope="col">Fecha</th><!--4-->
                                <th scope="col">Pares</th><!--5-->
                                <th scope="col">-</th><!--6--><!--1-->
                                <th scope="col">-</th><!--7--><!--2-->
                                <th scope="col">-</th><!--8--><!--3-->
                                <th scope="col">-</th><!--9--><!--4-->
                                <th scope="col">-</th><!--10--><!--5-->
                                <th scope="col">-</th><!--11--><!--6-->
                                <th scope="col">-</th><!--12--><!--7-->
                                <th scope="col">-</th><!--13--><!--8-->
                                <th scope="col">-</th><!--14--><!--9-->
                                <th scope="col">-</th><!--15--><!--10-->
                                <th scope="col">-</th><!--16--><!--11-->
                                <th scope="col">-</th><!--17--><!--12-->
                                <th scope="col">-</th><!--18--><!--13-->
                                <th scope="col">-</th><!--19--><!--14-->
                                <th scope="col">-</th><!--20--><!--15-->
                                <th scope="col">-</th><!--21--><!--16-->
                                <th scope="col">-</th><!--22--><!--17-->
                                <th scope="col">-</th><!--23--><!--18-->
                                <th scope="col">-</th><!--23--><!--19-->
                                <th scope="col">-</th><!--25--><!--20-->
                                <th scope="col">-</th><!--26--><!--21-->
                                <th scope="col">-</th><!--27--><!--22--> 

                                <th scope="col">Precio</th><!--30--> 
                                <!--OUT-->
                                <th scope="col">PrecioT</th><!--34--> 
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div><!--        END CARD BLOCK-->
    </div>
</div>
<!--CONTROLES X FACTURAR--> 
<div class="modal" id="mdlControlesXFacturar">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: 950px !important;">

            <div class="modal-body">
                <p class="font-italic font-weight-bold">
                    NOTA: Solo se muestran los registros con control y con estatus diferente a 
                    <span class="font-weight-bold text-info">"FACTURADO"</span> y 
                    <span class="font-weight-bold text-danger">"CANCELADO"</span>
                </p>
                <table id="tblControlesXFacturar"  class="table table-hover table-sm"  style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">CONTROL</th>
                            <th scope="col">PEDIDO</th>
                            <th scope="col">CLIENTE</th>
                            <th scope="col">FECHA-PED</th>
                            <th scope="col">FECHA-ENT</th>
                            <th scope="col">ESTILO</th>
                            <th scope="col">COLOR</th>
                            <th scope="col">PARES</th>
                            <th scope="col">FAC</th>
                            <th scope="col">MAQ</th>
                            <th scope="col">SEM</th>
                            <th scope="col">PRECIO</th>
                            <th scope="col">PRECIOT</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div> 
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), ParesFacturados,
            btnClientes = pnlTablero.find("#btnClientes"),
            btnVerTienda = pnlTablero.find("#btnVerTienda"),
            btnControlesXFac = pnlTablero.find("#btnControlesXFac"),
            tblParesFacturados = pnlTablero.find("#tblParesFacturados"),
            ClienteFactura = pnlTablero.find("#ClienteFactura"),
            Tienda = pnlTablero.find("#Tienda"),
            FechaFactura = pnlTablero.find('#FechaFactura'),
            LPFactura = pnlTablero.find('#LPFactura'),
            TPFactura = pnlTablero.find('#TPFactura'),
            FAPEORCOFactura = pnlTablero.find('#FAPEORCOFactura'),
            FCAFactura = pnlTablero.find('#FCAFactura'),
            PAGFactura = pnlTablero.find('#PAGFactura'),
            TMNDAFactura = pnlTablero.find('#TMNDAFactura'),
            FolioFactura = pnlTablero.find('#FolioFactura'),
            cCST = pnlTablero.find('#cCST'),
            cNoIva = pnlTablero.find('#cNoIva'),
            Control = pnlTablero.find('#Control'),
            Corrida = pnlTablero.find('#Corrida'),
            TotalParesEntrega = pnlTablero.find('#TotalParesEntrega'),
            TotalParesEntregaF = pnlTablero.find('#TotalParesEntregaF'),
            TotalParesEntregaAF = pnlTablero.find('#TotalParesEntregaAF'),
            ReferenciaFacturacion = pnlTablero.find('#ReferenciaFacturacion'),
            CajasFacturacion = pnlTablero.find('#CajasFacturacion'),
            EstiloFacturacion = pnlTablero.find('#EstiloFacturacion'),
            ColorFacturacion = pnlTablero.find('#ColorFacturacion'),
            CorridaFacturacion = pnlTablero.find('#CorridaFacturacion'),
            PrecioFacturacion = pnlTablero.find('#PrecioFacturacion'),
            SubtotalFacturacion = pnlTablero.find('#SubtotalFacturacion'),
            xRefacturacion = pnlTablero.find('#xRefacturacion'),
            DescuentoFacturacion = pnlTablero.find('#DescuentoFacturacion'),
            ParesFacturadosFacturacion = pnlTablero.find('#ParesFacturadosFacturacion'),
            onoffhandle = true, Hoy = '<?php print Date('d/m/Y'); ?>',
            mdlControlesXFacturar = $("#mdlControlesXFacturar"), ControlesXFacturar,
            tblControlesXFacturar = mdlControlesXFacturar.find("#tblControlesXFacturar");

    $("button:not(.grouped)").addClass("my-1");

    $(document).ready(function () {

        mdlControlesXFacturar.on('shown.bs.modal', function () {
            $.fn.dataTable.ext.errMode = 'throw';
            if (!$.fn.DataTable.isDataTable('#tblControlesXFacturar')) {
                ControlesXFacturar = tblControlesXFacturar.DataTable({
                    dom: 'frtip', "ajax": {
                        "url": '<?php print base_url('FacturacionProduccion/getPedidosXFacturar'); ?>',
                        "dataSrc": ""
                    },
                    "columns": [
                        {"data": "ID"},
                        {"data": "CONTROL"}, {"data": "PEDIDO"},
                        {"data": "CLIENTE"}, {"data": "FECHA_PEDIDO"},
                        {"data": "FECHA_ENTREGA"},
                        {"data": "ESTILO"}, {"data": "COLOR"},
                        {"data": "PARES"}, {"data": "FAC"},
                        {"data": "MAQUILA"}, {"data": "SEMANA"},
                        {"data": "PRECIOT"}, {"data": "PRECIO"}
                    ],
                    "columnDefs": [
                        //ID
                        {
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "targets": [13],
                            "visible": false,
                            "searchable": false
                        }],
                    language: lang,
                    select: true,
                    "autoWidth": true,
                    "colReorder": true,
                    "displayLength": 99,
                    "bLengthChange": false,
                    "deferRender": true,
                    "scrollCollapse": false,
                    "bSort": true,
                    "scrollY": 450,
                    "scrollX": true
                });
                tblControlesXFacturar.on('click', 'tr', function () {
                    onOpenOverlay('Por favor espere...');
                    var xxx = ControlesXFacturar.row($(this)).data();
                    if (xxx.length > 0) {
                        Control.val(xxx.CONTROL);
                    }
                    Control.val(xxx.CONTROL);
                    getInfoXControl(); 
                    onCloseOverlay();
                    mdlControlesXFacturar.modal('hide');
                });
            } else if ($.fn.DataTable.isDataTable('#tblControlesXFacturar')) {
                ControlesXFacturar.ajax.reload();
            }
        });

        btnControlesXFac.click(function () {
            mdlControlesXFacturar.modal({backdrop: false, keyboard: false});
        });

        TPFactura.on('keydown', function (e) {
            var x = parseInt(TPFactura.val()) === 1 ? 1 : 2;
            if (x === 1 || x === 2) {
                if (e.keyCode === 13) {
                    onOpenOverlay('');
                    $.getJSON('<?php print base_url('FacturacionProduccion/getUltimaFactura') ?>', {
                        TP: x
                    }).done(function (a) {
                        if (a.length > 0) {
                            var r = parseInt(TPFactura.val()) === 1 ? a[0].ULFAC : a[0].ULFACR;
                            FAPEORCOFactura.val(r);
                            ReferenciaFacturacion.val(r);
                        }
                        FCAFactura.val(0);
                        PAGFactura.val(1);

                    }).fail(function (xyz) {
                        getError(xyz);
                    }).always(function () {
                        onCloseOverlay();
                    });
                }
            } else {
                swal('ATENCIÓN', 'SOLO SE ACEPTA 1 Y 2', 'warning').then((value) => {
                    TPFactura.focus().select();
                });
            }
        });

        btnClientes.click(function () {
            onOpenWindow('<?php print base_url('Clientes'); ?>');
        });

        Control.on('keydown', function (e) {
            if (Control.val() && e.keyCode === 13) {
                onOpenOverlay('Buscando...');
                getInfoXControl();
            }
        });

        FechaFactura.val(Hoy);
        ClienteFactura[0].selectize.focus();
        handleEnterDiv(pnlTablero);

        TPFactura.on('keyup', function () {
            if (!onoffhandle && parseInt(ClienteFactura.val()) === 2121) {
                handleEnterDiv(pnlTablero);
                onoffhandle = true;
            }
        });

        Tienda.change(function () {
            if (Tienda.val()) {
                $("#ConsignarATienda").addClass("d-none");
                TPFactura.focus().select();
            } else {
                Tienda[0].selectize.focus();
            }
        });

        btnVerTienda.click(function () {
            if (parseInt(ClienteFactura.val()) === 2121) {
                onVerTienda();
            }
        });

        ClienteFactura.change(function () {
            if (ClienteFactura.val()) {
                if (parseInt(ClienteFactura.val()) === 2121) {
                    onVerTienda();
                } else {
                    btnVerTienda.addClass("d-none");
                }
                onOpenOverlay('');
                $.post('<?php print base_url('FacturacionProduccion/getListaDePreciosXCliente') ?>', {
                    CLIENTE: ClienteFactura.val()
                }).done(function (a) {
                    if (a.length > 0) {
                        var xxx = JSON.parse(a);
                        LPFactura.val(xxx[0].LP);
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    onCloseOverlay();
                });
            } else {
                $("#ConsignarATienda").addClass("d-none");
            }
        });

        ParesFacturados = tblParesFacturados.DataTable({
            dom: 'rt',
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 999,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": 450,
            "scrollX": true
        });
    });

    function getInfoXControl() {
        $.getJSON('<?php print base_url('FacturacionProduccion/getInfoXControl'); ?>', {
            CONTROL: Control.val()
        }).done(function (a) {
            if (a.length > 0) {
                var xx = a[0];
                Corrida.val(xx.Serie);
                var t = 0;
                for (var i = 1; i < 21; i++) {
                    if (parseInt(xx["T" + i]) > 0) {
                        pnlTablero.find("#T" + i).val(xx["T" + i]);
                        pnlTablero.find("#T" + i).attr("title", xx["T" + i]);
                        pnlTablero.find("#T" + i).attr("data-original-title", xx["T" + i]);
                        pnlTablero.find("#C" + i).val(xx["C" + i]);
                        pnlTablero.find("#C" + i).attr("title", xx["C" + i]);
                        pnlTablero.find("#C" + i).attr("data-original-title", xx["C" + i]);
                        t += parseInt(xx["C" + i]);
                        pnlTablero.find("#TotalParesEntrega").val(t)
                    }
                }
            } else {
                Control.focus().select();
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            onCloseOverlay();
        });
    }

    function onVerTienda() {
        $("#ConsignarATienda").toggleClass("d-none");
        btnVerTienda.toggleClass('d-none');
        pnlTablero.off("keydown");
        onoffhandle = !onoffhandle;
        Tienda[0].selectize.focus();
    }

    function onCalcularPares(e, i) {
        console.log("tbl ", $(e).parents('tr'));
        var total_pares = 0;
        $.each($(e).parents('tr').find("td"), function (k, v) {

            switch (i) {
                case 1:
                    total_pares += (parseInt($(v).find("input:not(#TotalParesEntrega)").val()) > 0) ? parseInt($(v).find("input:not(#TotalParesEntrega)").val()) : 0;
                    pnlTablero.find("#TotalParesEntrega").val(total_pares);
                    break;
                case 2:
                    total_pares += (parseInt($(v).find("input:not(#TotalParesEntregaF)").val()) > 0) ? parseInt($(v).find("input:not(#TotalParesEntregaF)").val()) : 0;
                    pnlTablero.find("#TotalParesEntregaF").val(total_pares);
                    break;
                case 3:
                    total_pares += (parseInt($(v).find("input:not(#TotalParesEntregaAF)").val()) > 0) ? parseInt($(v).find("input:not(#TotalParesEntregaAF)").val()) : 0;
                    pnlTablero.find("#TotalParesEntregaAF").val(total_pares);
                    break;
            }
        });
    }

    function getReferencia() {
        ReferenciaFacturacion.val(0);
    }
</script>
<style> 
    .card{border: solid 3px #607D8B;}
</style>