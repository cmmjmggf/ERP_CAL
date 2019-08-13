<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center" style="padding: 2px 2px 0px 2px !important;">
        <h4 class="font-weight-bold font-italic">FACTURACIÓN</h4>
    </div> 
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6"> 
                <button type="button" id="btnControlesXFac" name="btnControlesXFac" class="btn btn-info">
                    <span class="fa fa-exclamation"></span> CONTROLES X FACTURAR
                </button>
                <div class="btn-group" role="group" aria-label="BOTON CON CATALOGOS">
                    <button type="button" class="btn btn-info button-dropdown">CATÁLOGOS</button>
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop3" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop3">
                            <a class="dropdown-item" href="#" onclick="btnClientes.trigger('click');"><span class="fa fa-users"></span> CLIENTES</a>
                            <a class="dropdown-item" href="#" onclick="btnMovClientes.trigger('click');"><span class="fa fa-exchange-alt"></span> MOVIMIENTOS CLIENTES</a>
                        </div>
                    </div>
                </div>
                <button type="button" id="btnClientes" name="btnClientes" class="btn btn-primary d-none">
                    <span class="fa fa-users"></span>  CLIENTES
                </button>
                <button type="button" id="btnMovClientes" name="btnMovClientes" class="btn btn-warning d-none">
                    <span class="fa fa-exchange-alt"></span>  MOV-CLIENTES
                </button>
                <button type="button" id="btnReimprimeDocto" name="btnReimprimeDocto" class="btn btn-info">
                    <span class="fa fa-print"></span>  REIMPRIMIR DOCTO
                </button>
                <button type="button" id="btnVistaPreviaF" name="btnVistaPreviaF" class="btn btn-info">
                    <span class="fa fa-eye-slash"></span> VISTA PREVIA
                </button>
            </div>
            <div class="col-sm-6" align="right"> 
                <button type="button" id="btnCierraDocto" name="btnCierraDocto" class="btn btn-danger">
                    <span class="fa fa-file-archive"></span>   CIERRA DOCTO
                </button>
                <button type="button" id="btnAdendaCoppel" name="btnAdendaCoppel" class="btn btn-info">
                    <span class="fa fa-file-archive"></span>   ADDENDA COPPEL 
                </button>
                <button type="button" id="btnTimbrarFac" name="btnTimbrarFac" class="btn btn-warning">
                    <span class="fa fa-file-archive"></span>   TIMBRAR FAC 
                </button>
                <button type="button" id="btnCancelaDoc" name="btnCancelaDoc" class="btn btn-danger">
                    <span class="fa fa-file-archive"></span>   CANCELA DOC 
                </button>
                <button type="button" id="btnDevolucion" name="btnDevolucion" class="btn btn-primary">
                    <span class="fa fa-file-archive"></span>   DEVOLUCIÓN
                </button>
                <button type="button" id="btnEtiquetasParaCaja" name="btnEtiquetasParaCaja" class="btn btn-primary">
                    <span class="fa fa-file-archive"></span>    ETIQUETAS PARA CAJA
                </button>
            </div>
        </div>
        
        <div class="card-block">
            <div class="row">
                <div class="w-100 mt-4"></div>
                
                <div class="col-12">
                    <input type="text" id="TIPODECAMBIO" name="TIPODECAMBIO" class="form-control form-control-sm" readonly="">
                </div>
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
                    <select id="TPFactura" name="TPFactura" class="form-control form-control-sm">
                        <option></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
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
                    <input type="text" id="FolioFactura" name="FolioFactura" readonly="" class="form-control form-control-sm">
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
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="center"> 
                    <button type="button" class="btn btn-info"  id="btnFacturaXAnticipoDeProducto">
                        <span class="fa fa-exclamation"></span> FACTURA POR ANTICIPO DE PRODUCTO
                    </button>
                    <button type="button" class="btn btn-info" id="btnControlInCompleto" style="background-color: #C62828 !important;">
                        <span class="fa fa-exclamation"></span>   CONTROL INCOMPLETO
                    </button>
                    <button type="button" class="btn btn-info" id="btnControlCompleto">
                        <span class="fa fa-exclamation"></span> CONTROL COMPLETO O SALDO DEL CONTROL
                    </button> 
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-8 mb-2">
                    <div class="table-responsive" style="overflow-x:auto; white-space: nowrap;">
                        <label class="font-weight-bold" for="Tallas"></label>
                        <table id="tblTallasF" class="Tallas">
                            <thead></thead>
                            <tbody>
                                <tr id="rTallasBuscaManual">
                                    <td class="font-weight-bold">Tallas</td>
                                    <?php
                                    for ($index = 1; $index < 21; $index++) {
                                        print '<td><input type="text" style="width: 45px;" id="T' . $index . '" name="T' . $index . '"   readonly="" data-toggle="tooltip" data-placement="top" title="XXX" class="form-control form-control-sm"></td>';
                                    }
                                    ?>
                                    <td></td> 
                                </tr>  
                                <tr class="rCapturaCantidades" id="rCantidades">
                                    <td class="font-weight-bold">Pares d'control</td>
                                    <?php
                                    for ($index = 1; $index < 21; $index++) {
                                        print '<td><input type="text" style="width: 45px;" id="C' . $index . '" maxlength="3"  readonly="" class="form-control form-control-sm numbersOnly " name="C' . $index . '"  data-toggle="tooltip" data-placement="top" title="-" onfocus="onCalcularPares(this,1);" onchange="onCalcularPares(this,1);" keyup="onCalcularPares(this,1);" onfocusout="onCalcularPares(this,1);"></td>';
                                    }
                                    ?>
                                    <td class="font-weight-bold"><input type="text" style="width: 45px;" id="TotalParesEntrega" class="form-control form-control-sm " readonly=""  data-toggle="tooltip" data-placement="top" title="0"></td>
                                    <td>
                                    </td>
                                </tr>
                                <tr class="rCapturaCantidades" id="rCantidades">
                                    <td class="font-weight-bold">Facturado</td>
                                    <?php
                                    for ($index = 1; $index < 21; $index++) {
                                        print '<td><input type="text" style="width: 45px;" id="CF' . $index . '" maxlength="3"  readonly="" class="form-control form-control-sm numbersOnly " name="CF' . $index . '" onfocus="onCalcularPares(this,2);" onchange="onCalcularPares(this,2);" keyup="onCalcularPares(this,2);" onfocusout="onCalcularPares(this,2);"></td>';
                                    }
                                    ?>
                                    <td class="font-weight-bold">
                                        <input type="text" style="width: 45px;" id="TotalParesEntregaF" 
                                               class="form-control form-control-sm " readonly="" data-toggle="tooltip" data-placement="right" title="0">
                                    </td>
                                </tr>
                                <tr class="rCapturaCantidades" id="rCantidades">
                                    <td class="font-weight-bold">A Facturar</td>
                                    <?php
                                    for ($index = 1; $index < 21; $index++) {
                                        print '<td><input type="text" style="width: 45px;" id="CAF' . $index . '" maxlength="3" class="form-control form-control-sm numbersOnly " name="CAF' . $index . '" onfocus="onCalcularPares(this,3);" onchange="onCalcularPares(this,3);" keyup="onCalcularPares(this,3);" onfocusout="onCalcularPares(this,3);"></td>';
                                    }
                                    ?>
                                    <td class="font-weight-bold"><input type="text" style="width: 45px;" id="TotalParesEntregaAF" class="form-control form-control-sm " readonly=""  data-toggle="tooltip" data-placement="right" title="0"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> 
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-2">
                    <div class="card">
                        <div class="card-body" style="padding: 7px 10px 10px 10px;">
                            <div class="row">
                                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                                    <span class="font-weight-bold text-danger font-italic">Producción</span>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-6">
                                    <label for="PrsFabricados">Fabricados</label>
                                    <input type="text" id="PrsFabricados" name="PrsFabricados" readonly="" class="form-control form-control-sm">
                                </div>
                                <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-6">
                                    <label for="PrsFacturados">Facturados</label>
                                    <input type="text" id="PrsFacturados" name="PrsFacturados" readonly=""  class="form-control form-control-sm">
                                </div>
                                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-6">
                                    <label for="PrsSaldo">Saldo</label>
                                    <input type="text" id="PrsSaldo" name="PrsSaldo" readonly=""  class="form-control form-control-sm">
                                </div> 
                            </div> 
                        </div> 
                    </div> 
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-2">
                    <div class="card">
                        <div class="card-body" style="padding: 7px 10px 10px 10px;">
                            <div class="row">
                                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                                    <span class="font-weight-bold text-danger font-italic">Devoluciones</span> 
                                </div>
                                <div class="w-100"></div>
                                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-6">
                                    <label for="PrsDevueltos">Devueltos</label>
                                    <input type="text" id="PrsDevueltos" name="PrsDevueltos" readonly="" class="form-control form-control-sm">
                                </div>
                                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-6">
                                    <label for="PrsFacturadosDevueltos">Facturados</label>
                                    <input type="text" id="PrsFacturadosDevueltos" name="PrsFacturadosDevueltos" readonly=""  class="form-control form-control-sm">
                                </div>
                                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-6">
                                    <label for="PrsSaldoDevuelto">Saldo</label>
                                    <input type="text" id="PrsSaldoDevuelto" name="PrsSaldoDevuelto" readonly=""  class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100"></div>

                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                    <label>Referencia</label>
                    <span class="text-danger font-weight-bold ReferenciaFactura" style="font-size: 22px !important;">-</span>
                    <input type="text" id="ReferenciaFacturacion" name="ReferenciaFacturacion" readonly="" class="form-control form-control-sm d-none">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-1">
                    <label>Cajas</label>
                    <input type="text" id="CajasFacturacion" name="CajasFacturacion"style="color: #ff0000 !important;" class="form-control form-control-sm font-weight-bold">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-1">
                    <label>Estilo</label>
                    <input type="text" id="EstiloFacturacion" name="EstiloFacturacion" readonly="" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <label>Color</label>
                    <input type="text" id="ColorFacturacion" name="ColorFacturacion" readonly="" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-1">
                    <label>Corrida</label>
                    <input type="text" id="CorridaFacturacion" name="CorridaFacturacion" readonly="" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-1">
                    <label>Precio</label>
                    <input type="text" id="PrecioFacturacion" name="PrecioFacturacion" style="color: #ff0000 !important;" class="form-control form-control-sm font-weight-bold">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                    <label>Subtotal</label>
                    <input type="text" id="SubtotalFacturacion" name="SubtotalFacturacion" readonly="" class="form-control form-control-sm">
                </div>
                <div class="w-100"></div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2">
                    <div class="form-group mt-4">  
                        <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                            <input type="checkbox" class="custom-control-input selectNotEnter" id="xRefacturacion" name="xRefacturacion" style="cursor: pointer !important;">
                            <label class="custom-control-label text-danger labelCheck" for="xRefacturacion" style="cursor: pointer !important;">X Refacturación</label>
                        </div>
                    </div>      
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-5">
                    <label>Observación</label>
                    <textarea id="ObservacionFacturacion" name="ObservacionFacturacion" class="form-control form-control-sm" rows="2" cols="3"></textarea>
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-1">
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
                            <th scope="col">COLORT</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    CERRAR
                </button>
            </div>
        </div>
    </div>
</div>
<script>     var pnlTablero = $("#pnlTablero"), ParesFacturados, btnClientes = pnlTablero.find("#btnClientes"),
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
            CajasFacturacion = pnlTablero.find('#CajasFacturacion'), EstiloFacturacion = pnlTablero.find('#EstiloFacturacion'),
            ColorFacturacion = pnlTablero.find('#ColorFacturacion'),
            CorridaFacturacion = pnlTablero.find('#CorridaFacturacion'),
            PrecioFacturacion = pnlTablero.find('#PrecioFacturacion'),
            SubtotalFacturacion = pnlTablero.find('#SubtotalFacturacion'),
            xRefacturacion = pnlTablero.find('#xRefacturacion'),
            DescuentoFacturacion = pnlTablero.find('#DescuentoFacturacion'),
            ParesFacturadosFacturacion = pnlTablero.find('#ParesFacturadosFacturacion'),
            onoffhandle = true, Hoy = '<?php print Date('d/m/Y'); ?>',
            mdlControlesXFacturar = $("#mdlControlesXFacturar"), ControlesXFacturar,
            tblControlesXFacturar = mdlControlesXFacturar.find("#tblControlesXFacturar"),
            btnControlInCompleto = pnlTablero.find("#btnControlInCompleto"), btnControlCompleto = pnlTablero.find("#btnControlCompleto"),
            btnCierraDocto = pnlTablero.find("#btnCierraDocto"),
            btnMovClientes = pnlTablero.find("#btnMovClientes"),
            btnEtiquetasParaCaja = pnlTablero.find("#btnEtiquetasParaCaja"),
            TIPODECAMBIO = pnlTablero.find("#TIPODECAMBIO");

    $("button:not(.grouped):not(.navbar-brand)").addClass("my-1 btn-sm");
    pnlTablero.find("#tblTallasF").find("input").addClass("form-control-sm");
    pnlTablero.find("input,textarea").addClass("font-weight-bold");

    $(document).ready(function () {

        btnEtiquetasParaCaja.click(function () {
            $("#mdlEtiquetaCajas").modal('show');
        });

        btnMovClientes.click(function () {
            onOpenWindow('<?php print base_url('MovimientosCliente'); ?>');
        });

        btnCierraDocto.click(function () {
            if (ClienteFactura.val()) {
                onOpenOverlay('Guardando...');
                var p = {
                    FECHA: FechaFactura.val(),
                    CLIENTE: ClienteFactura.val(),
                    TP_DOCTO: TPFactura.val(),
                    FACTURA: FAPEORCOFactura.val(),
                    MONEDA: TMNDAFactura.val(),
                    IMPORTE_TOTAL: SubtotalFacturacion.val(),
                    TIPO_DE_CAMBIO: TIPODECAMBIO.val(),
                    REFACTURACION: xRefacturacion[0].cheked ? 1 : 0
                };
                swal({
                    text: "How was your experience getting help with this issue?",
                    buttons: {
                        cancel: "Close",
                    },
                    content: '<button type="buttton" onclick="onPick" class="btn btn-info">a prro</button><button type="buttton" onclick="onPick">a prro</button>'
                });
//                $.post('<?php print base_url('FacturacionProduccion/onCerrarDocto') ?>', p).done(function (abc) {
//
//                }).fail(function (x) {
//                    getError(x);
//                }).always(function () {
                onCloseOverlay();
//                });
            } else {
                iMsg('LOS SIGUIENTES CAMPOS SON REQUERIDOS', 'w', function () {
                    ClienteFactura[0].selectize.focus();
                });
            }
        });

        CajasFacturacion.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val() ? $(this).val() : 0) <= 0) {
                    swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN NUMERO DE CAJAS', 'warning').then((value) => {
                        CajasFacturacion.focus().select();
                    });
                }
            }
        });

        tblControlesXFacturar.find("#CAF20").on('keydown', function (e) {
            console.log('ok ok ok');
        });

        btnControlCompleto.click(function () {
            if (Control.val()) {
                for (var i = 1; i < 21; i++) {
                    var x = pnlTablero.find(`#C${i}`).val();
                    var xx = pnlTablero.find(`#CF${i}`).val() ? pnlTablero.find(`#CF${i}`).val() : 0;
                    if (parseFloat(x) > 0) {
                        pnlTablero.find("#CAF" + i).val(x - xx);
                    }
                }
                pnlTablero.find("#CAF1").focus().select();
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CONTROL', 'warning').then((value) => {
                    Control.focus().select();
                });
            }
        });
        btnControlInCompleto.click(function () {
            if (Control.val()) {
                for (var i = 1; i < 21; i++) {
                    pnlTablero.find("#CAF" + i).val('');
                }
                pnlTablero.find("#CAF1").focus().select();
                onNotifyOld('', 'POR FAVOR ESPECIFIQUE LAS CANTIDADES', 'info');
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CONTROL', 'warning').then((value) => {
                    Control.focus().select();
                });
            }
        });

        mdlControlesXFacturar.on('shown.bs.modal', function () {
            $.fn.dataTable.ext.errMode = 'throw';
            if (!$.fn.DataTable.isDataTable('#tblControlesXFacturar')) {
                ControlesXFacturar = tblControlesXFacturar.DataTable({
                    dom: 'frtip', "ajax": {
                        "url": '<?php print base_url('FacturacionProduccion/getPedidosXFacturar'); ?>',
                        "dataSrc": "",
                        "data": function (d) {
                            d.CLIENTE = ClienteFactura.val();
                        }
                    },
                    "columns": [
                        {"data": "ID"},
                        {"data": "CONTROL"}, {"data": "PEDIDO"},
                        {"data": "CLIENTE"}, {"data": "FECHA_PEDIDO"},
                        {"data": "FECHA_ENTREGA"},
                        {"data": "ESTILO"}, {"data": "COLOR"},
                        {"data": "PARES"}, {"data": "FAC"},
                        {"data": "MAQUILA"}, {"data": "SEMANA"},
                        {"data": "PRECIOT"}, {"data": "PRECIO"}, {"data": "COLORT"}
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
                        },
                        {
                            "targets": [14],
                            "visible": false,
                            "searchable": false
                        }],
                    language: lang,
                    select: true,
                    "autoWidth": true,
                    "colReorder": true,
                    "displayLength": 100,
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
                    console.log(xxx);
                    Control.val(xxx.CONTROL);
                    EstiloFacturacion.val(xxx.ESTILO);
                    ColorFacturacion.val(xxx.COLORT);
                    CajasFacturacion.val(1);
                    CajasFacturacion.focus().select();
                    getInfoXControl();
                    mdlControlesXFacturar.modal('hide');
                });
            } else if ($.fn.DataTable.isDataTable('#tblControlesXFacturar')) {
                ControlesXFacturar.ajax.reload();
            }
        });

        btnControlesXFac.click(function () {
            if (ClienteFactura.val()) {
                mdlControlesXFacturar.modal({backdrop: false, keyboard: false});
            } else {
                swal('ATENCION', 'DEBE DE ESPECIFICAR UN CLIENTE', 'warning').then((value) => {
                    ClienteFactura[0].selectize.focus();
                });
            }
        });

        TPFactura.change(function (e) {
            $.getJSON('<?php print base_url('FacturacionProduccion/getTipoDeCambio'); ?>').done(function (abcde) {
                if (abcde.length > 0) {
                    TIPODECAMBIO.val(abcde[0].DOLAR);
                }
            }).fail(function (x) {
                getError(x);
            }).always(function () {

            });
            if (ClienteFactura.val() && TPFactura.val()) {
                var x = parseInt(TPFactura.val()) === 1 ? 1 : 2;
                if (x === 1 || x === 2) {
                    onOpenOverlay('');
                    $.getJSON('<?php print base_url('FacturacionProduccion/getUltimaFactura') ?>', {
                        TP: x
                    }).done(function (a) {
                        if (a.length > 0) {
                            var r = parseInt(TPFactura.val()) === 1 ? a[0].ULFAC : a[0].ULFACR;
                            FAPEORCOFactura.val(r);
                            var ref = padLeft(ClienteFactura.val(), 4) + '' + r;
                            pnlTablero.find(".ReferenciaFactura").text(ref);
                            ReferenciaFacturacion.val(ref);
                        }
                        FCAFactura.val(0);
                        PAGFactura.val(1);
                        TMNDAFactura.val(0); //0 = pesos mexicanos, 1 = dolares americanos
                    }).fail(function (xyz) {
                        getError(xyz);
                    }).always(function () {
                        onCloseOverlay();
                    });
                } else {
                    swal('ATENCIÓN', 'SOLO SE ACEPTA 1 Y 2', 'warning').then((value) => {
                        TPFactura.focus().select();
                    });
                }
            } else {
            }
        });

        btnClientes.click(function () {
            onOpenWindow('<?php print base_url('Clientes'); ?>');
        });

        Control.on('keydown', function (e) {
            if (ClienteFactura.val()) {
                if (Control.val() && e.keyCode === 13) {
                    onOpenOverlay('Buscando...');
                    getInfoXControl();
                }
            } else {
                swal('ATENCION', 'DEBE DE ESPECIFICAR UN CLIENTE', 'warning').then((value) => {
                    ClienteFactura[0].selectize.focus();
                });
                $(".swal-button--confirm").focus();
            }
        });

        FechaFactura.val(Hoy);
        ClienteFactura[0].selectize.focus();
        handleEnterDiv(pnlTablero);

        TPFactura.on('change', function () {
            if (!onoffhandle && parseInt(ClienteFactura.val()) === 2121) {
                handleEnterDiv(pnlTablero);
                onoffhandle = true;
            }
        });

        Tienda.change(function () {
            if (Tienda.val()) {
                $("#ConsignarATienda").addClass("d-none");
                TPFactura[0].selectize.focus();
                TPFactura[0].selectize.open();
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
            "columnDefs": [{
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
        onBeep(3);
        getFacturacionDiff();
    }

    function onVerTienda() {
        $("#ConsignarATienda").toggleClass("d-none");
        btnVerTienda.toggleClass('d-none');
        pnlTablero.off("keydown");
        onoffhandle = !onoffhandle;
        Tienda[0].selectize.focus();
    }

    function onDesactivarEnter() {
        pnlTablero.off("keydown");
        onoffhandle = false;
    }

    function onActivarEnter() {
        handleEnterDiv(pnlTablero);
        onoffhandle = true;
    }

    function onCalcularPares(e, i) {
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

    function iMsg(msg, t, f) {
        swal('ATENCIÓN', msg,
                (t === 's' ? 'success' : (t === 'i' ? 'info' : (t === 'w' ? 'warning' : 'error')))).then(function () {
            f();
        });
    }

    var control_pertenece_a_cliente = false;
    function getFacturacionDiff() {
        if (Control.val()) {
            onOpenOverlay('Cargando...');
            var clientesito = ClienteFactura.val() ? ClienteFactura.val() : '';
            $.getJSON('<?php print base_url('FacturacionProduccion/onComprobarControlXCliente'); ?>', {
                CONTROL: Control.val() ? Control.val() : ''
            }).done(function (abcd) {
                console.log(abcd, abcd.length);
                if (abcd.length > 0) {
                    if (abcd[0].CLIENTE === clientesito) {
                        control_pertenece_a_cliente = true;
                    }
                    if (clientesito !== '' && clientesito === abcd[0].CLIENTE) {
                        $.getJSON('<?php print base_url('FacturacionProduccion/getFacturacionDiff'); ?>', {
                            CONTROL: Control.val() ? Control.val() : ''
                        }).done(function (aa) {
                            var abc = aa[0];
                            if (abc !== undefined) {
                                //                    par01, par02, par03, par04, par05, par06, par07, par08, par09, par10, 
                                //                            par11, par12, par13, par14, par15, par16, par17, par18, par19, par20, par21, par22

                                if (control_pertenece_a_cliente) {
                                    for (var i = 1; i < 21; i++) {
                                        var ccc = 0;
                                        if (i < 10) {
                                            ccc = parseInt(abc[`par0${i}`]) > 0 ? abc[`par0${i}`] : 0;
                                            pnlTablero.find(`#CF${i}`).val(ccc);
                                        } else {
                                            ccc = parseInt(abc[`par${i}`]) > 0 ? abc[`par${i}`] : 0;
                                            pnlTablero.find(`#CF${i}`).val(ccc);
                                        }
                                    }
                                }
                            }
                            if (control_pertenece_a_cliente) {
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
                                                pnlTablero.find(`#C${i}`).val(xx["C" + i]);
                                                pnlTablero.find("#CAF" + i).val(parseFloat(xx["C" + i]) > 0 ? xx["C" + i] : 0);
                                                pnlTablero.find("#C" + i).attr("title", xx["C" + i]);
                                                pnlTablero.find("#C" + i).attr("data-original-title", xx["C" + i]);
                                                t += parseInt(xx["C" + i]);
                                                pnlTablero.find("#TotalParesEntrega").val(t);
                                                pnlTablero.find("#TotalParesEntregaAF").val(t);
                                            }
                                        }
                                        FolioFactura.val(xx.CLAVE_PEDIDO);
                                        CorridaFacturacion.val(xx.SERIET);
                                        EstiloFacturacion.val(xx.ESTILOT);
                                        ColorFacturacion.val(xx.COLORT);
                                        PrecioFacturacion.val(xx.PRECIO);
                                        CajasFacturacion.val(1);
                                        CajasFacturacion.focus().select();
                                        var prs = parseFloat(pnlTablero.find("#TotalParesEntregaAF").val() ? pnlTablero.find("#TotalParesEntregaAF").val() : 0);
                                        var stt = parseFloat(xx.Precio) * prs;
                                        SubtotalFacturacion.val(stt);
                                        pnlTablero.find("#CAF1").focus().select();
                                    } else {
                                        Control.focus().select();
                                    }
                                }).fail(function (x) {
                                    getError(x);
                                }).always(function () {
                                    onCloseOverlay();
                                });
                            } else {
                                onResetCampos();
                                iMsg('ESTE CONTROL NO PERTENECE A ESTE CLIENTE 1', 'w', function () {
                                    Control.focus().select();
                                });
                            }
                        }).fail(function (x) {
                            getError(x);
                        }).always(function () {
                            onCloseOverlay();
                        });
                    }
                } else {
                    iMsg('EL CONTROL ESPECIFICADO NO PERTENECE A ESTE CLIENTE, INTENTE CON UNO DIFERENTE', 'w', function () {
                        onResetCampos();
                        Control.focus().select();
                    });
                }
            }).fail(function (x) {
                getError(x);
            }).always(function () {
            });
        }
    }

    function onResetCampos() {
        Corrida.val('');
        for (var i = 1; i < 21; i++) {
            pnlTablero.find("#T" + i).val("");
            pnlTablero.find(`#C${i}`).val("");
            pnlTablero.find("#CAF" + i).val("");
        }
        pnlTablero.find("#TotalParesEntrega").val('');
        pnlTablero.find("#TotalParesEntregaAF").val('');
        FolioFactura.val('');
        CorridaFacturacion.val('');
        EstiloFacturacion.val('');
        ColorFacturacion.val('');
        PrecioFacturacion.val('');
        CajasFacturacion.val('');
    }

</script>
<style> 
    .card{border: solid 1px #607D8B;}
</style>