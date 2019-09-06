<div class="card m-3 animated fadeIn" id="pnlTablero" style="background-color:  #fff !important;">
    <div class="card-body " style="padding: 7px 10px 10px 10px;">
        <div class="row">
            <div class="col-sm-4">
                <button type="button" id="btnControlesXFac" name="btnControlesXFac" class="btn btn-info d-none">
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
                <button type="button" id="btnReimprimeDocto" name="btnReimprimeDocto" class="btn btn-info" disabled="">
                    <span class="fa fa-print"></span>  REIMPRIMIR DOCTO
                </button>
                <button type="button" id="btnVistaPreviaF" name="btnVistaPreviaF" class="btn btn-info" disabled="">
                    <span class="fa fa-eye-slash"></span> VISTA PREVIA
                </button>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3" align="center">
                <div class="row">
                    <div class="col-10">
                        <h4 class="font-weight-bold font-italic text-danger">F A C T U R A C I Ó N</h4>
                    </div>
                    <div class="col-2">
                        <button type="button" id="btnNuevo" name="btnNuevo" 
                                class="btn btn-default animated flipInX d-none" 
                                disabled="true"
                                data-toggle="tooltip" data-placement="bottom"  
                                style="padding: 6px 9px 6px 9px !important; 
                                background-color: #99cc00; 
                                box-shadow: none !important; 
                                color: #fff !important;">
                            <span class="fa fa-check"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-5 col-md-5" align="right"> 
                <button type="button" id="btnCierraDocto" name="btnCierraDocto" class="btn btn-danger" disabled="">
                    <span class="fa fa-file-archive"></span>   CIERRA DOCTO
                </button>
                <button type="button" id="btnAdendaCoppel" name="btnAdendaCoppel" class="btn btn-info" disabled="">
                    <span class="fa fa-file-archive"></span>   ADDENDA COPPEL 
                </button> 
                <button type="button" id="btnCancelaDoc" name="btnCancelaDoc" class="btn btn-danger" disabled="">
                    <span class="fa fa-file-archive"></span>   CANCELA DOC 
                </button>
                <button type="button" id="btnDevolucion" name="btnDevolucion" class="btn btn-primary">
                    <span class="fa fa-file-archive"></span>   DEVOLUCIÓN
                </button>
                <button type="button" id="btnEtiquetasParaCaja" name="btnEtiquetasParaCaja" class="btn btn-primary d-none">
                    <span class="fa fa-file-archive"></span>    ETIQ.P CAJA
                </button>
            </div>
        </div>

        <div class="row">    
            <div class="col-12 d-none">
                <input type="text" id="TIPODECAMBIO" name="TIPODECAMBIO" class="form-control form-control-sm" readonly="">
                <input type="text" id="EstatusControl" name="EstatusControl" class="form-control form-control-sm" readonly="">
                <input type="text" id="ZonaFacturacion" name="ZonaFacturacion" class="form-control form-control-sm" readonly="">
                <input type="text" id="AgenteCliente" name="AgenteCliente"   readonly="">

            </div>
            <div class="col-12 col-xs-12 col-sm-6 col-md-2 col-lg-4 col-xl-1"   style="padding-right: 5px;"> 
                <label>Fecha</label>
                <input type="text" id="FechaFactura" name="FechaFactura" class="form-control form-control-sm date notEnter">
            </div>
            <div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-3"  style="padding-left: 5px; padding-right: 5px;"> 
                <div class="form-group">
                    <label class="control-label">Cliente</label>
                    <div class="form-group">
                        <div class="input-group mb-3"> 
                            <select id="ClienteFactura" name="ClienteFactura" class="form-control">
                                <option></option>
                                <?php
//                                YA CONTIENE LOS BLOQUEOS DE VENTA
                                foreach ($this->db->query("SELECT C.Clave AS CLAVE, CONCAT(C.Clave, \" - \",C.RazonS) AS CLIENTE, C.ListaPrecios AS LISTADEPRECIO FROM clientes AS C LEFT  JOIN bloqueovta AS B ON C.Clave = B.cliente WHERE C.Estatus IN('ACTIVO') AND B.cliente IS NULL ORDER BY ABS(C.Clave) ASC;")->result() as $k => $v) {
                                    print "<option value='{$v->CLAVE}'>{$v->CLIENTE}</option>";
                                }
                                ?>
                            </select>
                            <div class="input-group-append">
                                <button type="button" id="btnVerTienda" name="btnVerTienda" style="padding: 8px 15px 8px 15px !important; " class="btn btn-info btn-sm mx-1 grouped d-none animated fadeIn">
                                    <span class="fa fa-exclamation"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1 " style="padding-left: 5px; padding-right: 5px;">
                <label>L-P</label>
                <input type="text" id="LPFactura" name="LPFactura" readonly="" data-toggle="tooltip" data-placement="bottom" title="Lista de precios"  class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1 " style="padding-left: 5px; padding-right: 5px;">
                <label>TP</label>
                <select id="TPFactura" name="TPFactura" class="form-control form-control-sm">
                    <option></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1" style="padding-left: 5px; padding-right: 5px;">
                <label>FA-PE.ORCO</label>
                <input type="text" id="FAPEORCOFactura" name="FAPEORCOFactura" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1"  style="padding-left: 5px; padding-right: 5px;">
                <label>FC.A</label>
                <input type="number" id="FCAFactura" name="FCAFactura" max="2" min="0" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1"  style="padding-left: 5px; padding-right: 5px;">
                <label>PAG</label>
                <input type="number" id="PAGFactura" name="PAGFactura" max="2" min="0" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1"  style="padding-left: 5px; padding-right: 5px;">
                <label>T-MNDA</label>
                <input type="number" id="TMNDAFactura" name="TMNDAFactura" max="2" min="0" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1" style="padding-left: 5px; padding-right: 5px;">
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
                            <div class="row">
                                <div class="col-10">
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
                                <div class="col-2">

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="w-100"></div>
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <label>Control</label>
                <div class="input-group">               
                    <input type="text" id="Control" name="Control" class="form-control form-control-sm numbersOnly">
                    <span class="input-group-prepend">
                        <span class="input-group-text text-dark" 
                              style="background-color: #007bff; color: #FFF !important;   
                              cursor: pointer !important;  padding-top: 3px; padding-bottom: 3px; border-top-right-radius: 5px; border-bottom-right-radius:5px;" 
                              id="btnElijeControl" onclick="btnControlesXFac.trigger('click')" data-toggle="tooltip" 
                              data-placement="top" title="ELIJE UN CONTROL">
                            <i class="fa fa-chess-pawn"></i> CONTROLES X FACTURAR
                        </span>
                    </span>
                </div>
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1" style="padding-left: 5px; padding-right: 5px;">
                <label>FOLIO</label>
                <input type="text" id="FolioFactura" name="FolioFactura" readonly="" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-1 col-lg-1 col-xl-1">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1 d-none">
                <label>Corrida</label>
                <input type="text" id="Corrida" name="Corrida" class="form-control form-control-sm" readonly="">
            </div> 


            <!--            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-body" style="padding: 7px 10px 10px 10px;">
                                    <div class="row">
                                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                                            <h5 class="font-weight-bold text-danger font-italic" style="margin-bottom: 0px;">Producción</h5>
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                                            <span class="font-weight-bold">Fabricados : </span>
                                            <span class="font-weight-bold text-danger produccionfabricados"> 0 </span> 
                                            <input type="text" id="PrsFabricados" name="PrsFabricados" readonly="" class="d-none form-control form-control-sm">
                                        </div>
                                        <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                                            <span class="font-weight-bold">Facturados : </span>
                                            <span class="font-weight-bold text-danger produccionfacturados"> 0 </span> 
                                            <input type="text" id="PrsFacturados" name="PrsFacturados" readonly=""  class="d-none form-control form-control-sm">
                                        </div>
                                        <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                                            <span class="font-weight-bold">Saldo : </span>
                                            <span class="font-weight-bold text-danger produccionsaldo"> 0 </span>  
                                            <input type="text" id="PrsSaldo" name="PrsSaldo" readonly=""  class="d-none form-control form-control-sm">
                                        </div> 
                                    </div> 
                                </div> 
                            </div> 
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-body" style="padding: 7px 10px 10px 10px;">
                                    <div class="row">
                                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                                            <h5 class="font-weight-bold text-danger font-italic" style="margin-bottom: 0px;">Devoluciones</h5> 
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                                            <span class="font-weight-bold">Devueltos:</span>
                                            <span class="font-weight-bold text-danger devueltos"> 0 </span> 
                                            <input type="text" id="PrsDevueltos" name="PrsDevueltos" readonly="" class="form-control d-none form-control-sm">
                                        </div>
                                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                                            <span class="font-weight-bold">Facturados: </span>
                                            <span class="font-weight-bold text-danger devueltosfacturados"> 0 </span> 
                                            <input type="text" id="PrsFacturadosDevueltos" name="PrsFacturadosDevueltos" readonly=""  class="d-none form-control form-control-sm">
                                        </div>
                                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4"> 
                                            <span class="font-weight-bold">Saldo: </span>
                                            <span class="font-weight-bold text-danger saldodevuelto"> 0 </span> 
                                            <input type="text" id="PrsSaldoDevuelto" name="PrsSaldoDevuelto" readonly=""  class="d-none form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->


            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="row">
                    <div class="col-6" style="border-bottom: 1px solid #0202; ">
                        <div class="row">
                            <div class="col-12" align="center"  style="padding: 0px 10px 0px 10px !important;">
                                <span class="font-weight-bold">Producción</span>
                            </div>
                            <div class="col-4" style="padding: 0px 10px 0px 10px !important;">
                                Fabricados 
                                <span class="font-weight-bold text-danger produccionfabricados"> 0 </span> 
                                <input type="text" id="PrsFabricados" name="PrsFabricados" readonly="" class="d-none form-control form-control-sm">
                            </div>
                            <div class="col-4" style="padding: 0px 10px 0px 10px !important;">
                                Facturados 
                                <span class="font-weight-bold text-danger produccionfacturados"> 0 </span> 
                                <input type="text" id="PrsFacturados" name="PrsFacturados" readonly=""  class="d-none form-control form-control-sm">
                            </div>
                            <div class="col-4" style="padding: 0px 10px 0px 10px !important;">
                                Saldo 
                                <span class="font-weight-bold text-danger produccionsaldo"> 0 </span>  
                                <input type="text" id="PrsSaldo" name="PrsSaldo" readonly=""  class="d-none form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="col-6" style="border-bottom: 1px solid #0202; ">
                        <div class="row">
                            <div class="col-12" align="center"  style="padding: 0px 10px 0px 10px !important;">
                                <span class="font-weight-bold">Devoluciones</span>
                            </div>
                            <div class="col-4" style="padding: 0px 10px 0px 10px !important;">
                                Devueltos 
                                <span class="font-weight-bold text-danger devueltos"> 0 </span> 
                                <input type="text" id="PrsDevueltos" name="PrsDevueltos" readonly="" class="form-control d-none form-control-sm">
                            </div>
                            <div class="col-4" style="padding: 0px 10px 0px 10px !important;">
                                Facturados 
                                <span class="font-weight-bold text-danger devueltosfacturados"> 0 </span> 
                                <input type="text" id="PrsFacturadosDevueltos" name="PrsFacturadosDevueltos" readonly=""  class="d-none form-control form-control-sm">
                            </div>
                            <div class="col-4" style="padding: 0px 10px 0px 10px !important;">
                                Saldo 
                                <span class="font-weight-bold text-danger saldodevuelto"> 0 </span> 
                                <input type="text" id="PrsSaldoDevuelto" name="PrsSaldoDevuelto" readonly=""  class="d-none form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="w-100 my-1"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="center"> 
                <hr>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10" align="center">  
                <!--                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-1" align="center"> 
                                    <button type="button" class="btn btn-info"  id="btnFacturaXAnticipoDeProducto"  disabled="" >
                                        <span class="fa fa-exclamation"></span> FACTURA POR ANTICIPO DE PRODUCTO
                                    </button>
                                    <button type="button" class="btn btn-info" disabled="" id="btnControlInCompleto" style="border-color: #C62828 !important; background-color: #C62828 !important;">
                                        <span class="fa fa-exclamation"></span>   CONTROL INCOMPLETO
                                    </button>
                                    <button type="button" class="btn btn-info" id="btnControlCompleto"  disabled="" >
                                        <span class="fa fa-exclamation"></span> CONTROL COMPLETO O SALDO DEL CONTROL
                                    </button> 
                                </div>-->
                <div class="table-responsive" style="overflow-x:auto; white-space: nowrap;"> 
                    <table id="tblTallasF" class="Tallas">
                        <thead></thead>
                        <tbody>
                            <tr id="rTallasBuscaManual">
                                <td class="font-weight-bold">Tallas</td>
                                <?php
                                for ($index = 1; $index < 23; $index++) {
//                                    print '<td><input type="text" style="width: 40px;font-weight: 300 !important; padding-left: 4px; padding-right: 4px;" id="T' . $index . '" name="T' . $index . '"   readonly="" data-toggle="tooltip" data-placement="top" title="XXX" class="form-control form-control-sm"></td>';
                                    print "<td align='center'><span class=\"T{$index}\">$index</span></td>";
                                }
                                ?>                        
                                <td></td> 
                            </tr>  
                            <tr class="rCapturaCantidades" id="rCantidades">
                                <td class="font-weight-bold">Pares d'control</td>
                                <?php
                                for ($index = 1; $index < 23; $index++) {
                                    print '<td><input type="text" style="width: 40px; font-weight: 300 !important; cursor: no-allowed !important;" id="C' . $index . '" maxlength="3"  readonly="" class="form-control form-control-sm numbersOnly " name="C' . $index . '"  data-toggle="tooltip" data-placement="top" title="-" onfocus="onCalcularPares(this,1);" onchange="onCalcularPares(this,1);" keyup="onCalcularPares(this,1);" onfocusout="onCalcularPares(this,1);"></td>';
                                }
                                ?>
                                <td class="font-weight-bold"><input type="text" style="width: 45px;" id="TotalParesEntrega" class="form-control form-control-sm " readonly=""  data-toggle="tooltip" data-placement="top" title="0"></td>
                                <td>
                                </td>
                            </tr>
                            <tr class="rCapturaCantidades" id="rCantidades">
                                <td class="font-weight-bold">Facturado</td>
                                <?php
                                for ($index = 1; $index < 23; $index++) {
                                    print '<td><input type="text" style="width: 40px;font-weight: 300 !important;  cursor: no-allowed !important;" id="CF' . $index . '" maxlength="3"  readonly="" class="form-control form-control-sm numbersOnly " name="CF' . $index . '" onfocus="onCalcularPares(this,2);" onchange="onCalcularPares(this,2);" keyup="onCalcularPares(this,2);" onfocusout="onCalcularPares(this,2);"></td>';
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
                                for ($index = 1; $index < 23; $index++) {
                                    print '<td><input type="text" style="width: 40px;font-weight: 300 !important;" id="CAF' . $index . '" maxlength="3" class="form-control form-control-sm numbersOnly " name="CAF' . $index . '" onfocus="onCalcularPares(this,3);" onchange="onCalcularPares(this,3);" keyup="onCalcularPares(this,3);" onfocusout="onCalcularPares(this,3);"></td>';
                                }
                                ?>
                                <td class="font-weight-bold"><input type="text" style="width: 45px;" id="TotalParesEntregaAF" class="form-control form-control-sm " readonly=""  data-toggle="tooltip" data-placement="right" title="0"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-1" align="center"> 
                <div class="row"  align="center">
                    <button type="button" style="background-color: #4CAF50;" class="btn btn-success notEnter notnotEnter"  id="btnFacturaXAnticipoDeProducto"  disabled="" >
                        <span class="fa fa-exclamation"></span> POR ANTICIPO DE PRODUCTO
                    </button>
                    <div class="w-100"></div>
                    <button type="button" class="btn btn-info notEnter notnotEnter" disabled="" id="btnControlInCompleto" style="border-color: #C62828 !important; background-color: #C62828 !important;">
                        <span class="fa fa-exclamation"></span>   CONTROL INCOMPLETO
                    </button>
                    <div class="w-100"></div>
                    <button type="button" class="btn btn-info notEnter notnotEnter" id="btnControlCompleto"  disabled="" >
                        <span class="fa fa-exclamation"></span> CONTROL COMPLETO O SALDO
                    </button> 
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="center"> 
                <hr>
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                <label>Referencia</label>
                <span class="text-danger font-weight-bold ReferenciaFactura" style="font-size: 22px !important;">-</span>
                <input type="text" id="ReferenciaFacturacion" name="ReferenciaFacturacion" readonly="" class="form-control form-control-sm d-none">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-1" style="padding-left: 5px; padding-right: 5px;">
                <label>Cajas</label>
                <input type="text" id="CajasFacturacion" name="CajasFacturacion"style="color: #ff0000 !important;" class="form-control form-control-sm numbersOnly font-weight-bold">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-1" style="padding-left: 5px; padding-right: 5px;">
                <label>Estilo</label>
                <input type="text" id="EstiloFacturacion" name="EstiloFacturacion" readonly="" class="form-control form-control-sm">
                <input type="text" id="EstiloTFacturacion" name="EstiloTFacturacion" readonly="" class="d-none form-control form-control-sm">
                <input type="text" id="CodigoSat" name="CodigoSat" class="d-none form-control" readonly="">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-3" style="padding-left: 5px; padding-right: 5px;">
                <label>Color</label>
                <input type="text" id="ColorClaveFacturacion" name="ColorClaveFacturacion" readonly="" class="form-control form-control-sm d-none">
                <input type="text" id="ColorFacturacion" name="ColorFacturacion" readonly="" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-1"  style="padding-left: 5px; padding-right: 5px;">
                <label>Corrida</label>
                <input type="text" id="CorridaFacturacion" name="CorridaFacturacion" readonly="" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-1" style="padding-left: 5px; padding-right: 5px;">
                <label>Precio</label>
                <input type="text" id="PrecioFacturacion" name="PrecioFacturacion" style="color: #ff0000 !important;" class="form-control form-control-sm font-weight-bold numbersOnly">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2" style="padding-left: 5px; padding-right: 5px;">
                <label>Subtotal</label>
                <input type="text" id="SubtotalFacturacion" name="SubtotalFacturacion" readonly="" class="form-control form-control-sm">
                <input type="text" id="SubtotalFacturacionIVA" name="SubtotalFacturacionIVA" readonly="" class="d-none form-control form-control-sm">
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
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-5" style="padding-left: 5px; padding-right: 5px;">
                <label>Observación</label>
                <textarea id="ObservacionFacturacion" name="ObservacionFacturacion" class="form-control form-control-sm" rows="2" cols="3"></textarea>
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-1" style="padding-left: 5px; padding-right: 5px;">
                <label>Descuento</label>
                <input type="text" id="DescuentoFacturacion" name="DescuentoFacturacion" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2"  style="padding-left: 5px; padding-right: 5px;">
                <label>Pares Facturados</label>
                <input type="text" id="ParesFacturadosFacturacion" name="ParesFacturadosFacturacion" readonly="" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                <button type="button" id="btnAcepta" name="btnAcepta" class="btn btn-info mt-4" disabled="">
                    <span class="fa fa-check"></span> ACEPTA
                </button>
            </div>
            <div id="TotalLetra" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                <span class="font-weight-bold font-italic text-danger">
                    -
                </span>
            </div> 

            <div class="w-100 my-2"></div>

            <!--DETALLE DE LA FACTURA-->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="center"> 
                <hr>
            </div>

            <div class="col-12 col-lg-12 col-xl-12">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4" align="center">
                        <h5 class="font-weight-bold text-danger font-italic">
                            DETALLE DE LA FACTURA
                        </h5>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 d-none"  align="right">
                        <h4 class="font-weight-bold text-danger font-italic totalfacturadohead">$ 0.0</h4>
                    </div>
                </div>
            </div>
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
                            <th scope="col">T1</th><!--6--><!--1-->
                            <th scope="col">T2</th><!--7--><!--2-->
                            <th scope="col">T3</th><!--8--><!--3-->
                            <th scope="col">T4</th><!--9--><!--4-->
                            <th scope="col">T5</th><!--10--><!--5-->
                            <th scope="col">T6</th><!--11--><!--6-->
                            <th scope="col">T7</th><!--12--><!--7-->
                            <th scope="col">T8</th><!--13--><!--8-->
                            <th scope="col">T9</th><!--14--><!--9-->
                            <th scope="col">T10</th><!--15--><!--10-->
                            <th scope="col">T11</th><!--16--><!--11-->
                            <th scope="col">T12</th><!--17--><!--12-->
                            <th scope="col">T13</th><!--18--><!--13-->
                            <th scope="col">T14</th><!--19--><!--14-->
                            <th scope="col">T15</th><!--20--><!--15-->
                            <th scope="col">T16</th><!--21--><!--16-->
                            <th scope="col">T17</th><!--22--><!--17-->
                            <th scope="col">T18</th><!--23--><!--18-->
                            <th scope="col">T19</th><!--23--><!--19-->
                            <th scope="col">T20</th><!--25--><!--20-->
                            <th scope="col">T21</th><!--26--><!--21-->
                            <th scope="col">T22</th><!--27--><!--22--> 

                            <th scope="col">Precio</th><!--28--> 
                            <!--OUT-->
                            <th scope="col">PrecioT</th><!--29--> 
                            <th scope="col">SubTotal</th><!--30--> 
                            <th scope="col">SubTotalT</th><!--31--> 
                            <th scope="col">-</th><!--32--> 
                            <th scope="col">CAJAS</th><!--34--> 
                            <th scope="col">OBSER</th><!--35--> 
                            <th scope="col">DESCUENTO</th><!--36--> 
                            <th scope="col">PRS-FAC</th><!--37--> 
                            <th scope="col">FOLIO</th><!--38--> 
                            <th scope="col">MONDA</th><!--39--> 
                            <th scope="col">PAG</th><!--40--> 
                            <th scope="col">STS-CTRL</th><!--41--> 
                            <th scope="col">NO-IVA</th><!--42--> 
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>    
            </div> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10" align="right">
                <span class="font-weight-bold text-danger font-italic">SUBTOTAL</span>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2" align="right">
                <h3 class="font-weight-bold text-danger font-italic subtotalfacturadopie">$ 0.0</h3>
            </div> 
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10" align="right">
                <span class="font-weight-bold text-danger font-italic">I.V.A</span>
            </div> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2" align="right">
                <h3 class="font-weight-bold text-danger font-italic totalivafacturadopie">$ 0.0</h3>
            </div> 
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10" align="left">
                <h3 class="font-weight-bold text-danger font-italic totalfacturadoenletrapie">-</h3>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10" align="left">
                <h3 class="font-weight-bold text-danger font-italic totalfacturadoenletrapieDLLS">-</h3>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2" align="right">
                <h3 class="font-weight-bold text-danger font-italic totalfacturadopie">$ 0.0</h3>
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
<script>
    var pnlTablero = $("#pnlTablero"), ParesFacturados, btnClientes = pnlTablero.find("#btnClientes"),
            btnNuevo = pnlTablero.find("#btnNuevo"),
            btnVerTienda = pnlTablero.find("#btnVerTienda"),
            btnControlesXFac = pnlTablero.find("#btnControlesXFac"),
            tblParesFacturados = pnlTablero.find("#tblParesFacturados"),
            ClienteFactura = pnlTablero.find("#ClienteFactura"),
            AgenteCliente = pnlTablero.find("#AgenteCliente"),
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
            EstiloTFacturacion = pnlTablero.find("#EstiloTFacturacion"),
            CodigoSat = pnlTablero.find("#CodigoSat"),
            ObservacionFacturacion = pnlTablero.find("#ObservacionFacturacion"),
            ColorFacturacion = pnlTablero.find('#ColorFacturacion'),
            ColorClaveFacturacion = pnlTablero.find("#ColorClaveFacturacion"),
            CorridaFacturacion = pnlTablero.find('#CorridaFacturacion'),
            PrecioFacturacion = pnlTablero.find('#PrecioFacturacion'),
            SubtotalFacturacion = pnlTablero.find('#SubtotalFacturacion'),
            EstatusControl = pnlTablero.find("#EstatusControl"),
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
            TIPODECAMBIO = pnlTablero.find("#TIPODECAMBIO"), btnAcepta = pnlTablero.find("#btnAcepta"),
            btnFacturaXAnticipoDeProducto = pnlTablero.find("#btnFacturaXAnticipoDeProducto"),
            TotalLetra = pnlTablero.find("#TotalLetra"), ZonaFacturacion = pnlTablero.find("#ZonaFacturacion"),
            SubtotalFacturacionIVA = pnlTablero.find("#SubtotalFacturacionIVA"),
            btnVistaPreviaF = pnlTablero.find("#btnVistaPreviaF"),
            btnReimprimeDocto = pnlTablero.find("#btnReimprimeDocto"), btnElijeControl = pnlTablero.find("#btnElijeControl");

    $("button:not(.grouped):not(.navbar-brand)").addClass("my-1 btn-sm");
    pnlTablero.find("#tblTallasF").find("input").addClass("form-control-sm");
    pnlTablero.find("input,textarea").addClass("font-weight-bold");
    var nuevo = true; /* 1 = NUEVO, 2 = MODIFICANDO, 3 = CERRADO*/

    $(document).ready(function () {

        btnNuevo.click(function () {
            onOpenOverlay('');
            onDisableInputs(false);
            onResetCampos();
            btnVistaPreviaF.attr('disabled', true);
            btnReimprimeDocto.attr('disabled', true);
            ParesFacturados.rows().remove().draw();

            pnlTablero.find(".ReferenciaFactura").text('-');
            pnlTablero.find(".subtotalfacturadopie").text('$0.0');
            pnlTablero.find(".totalivafacturadopie").text('$0.0');
            pnlTablero.find(".totalfacturadopie").text('$0.0');
            pnlTablero.find(".totalfacturadoenletrapie").text('$0.0');
            CajasFacturacion.attr('disabled', false);
            pnlTablero.find("input").val('');
            FechaFactura.val(Hoy);
            FAPEORCOFactura.val('');
            ClienteFactura[0].selectize.clear(true);
            TPFactura[0].selectize.clear(true);
            LPFactura.val('');
            btnNuevo.attr('disabled', true);
            btnNuevo.addClass("d-none");
            ClienteFactura[0].selectize.focus();
            btnVerTienda.addClass("d-none");
            onCloseOverlay();
        });

        btnReimprimeDocto.click(function () {
            $("#mdlReimprimeDocto").modal('show');
        });

        btnVistaPreviaF.click(function () {

//            $.getJSON('<?php print base_url('FacturacionProduccion/onComprobarCFDI'); ?>', {
//                DOCUMENTO_FACTURA: FAPEORCOFactura.val().trim() !== '' ? FAPEORCOFactura.val() : ''
//            }).done(function (a) {
//                if (a.length > 0) {
            if (ClienteFactura.val() && FAPEORCOFactura.val() && TPFactura.val()) {
                onBeep(1);
                onOpenOverlay('Espere por favor...');
                $.post('<?php print base_url('FacturacionProduccion/getVistaPrevia'); ?>', {
                    CLIENTE: ClienteFactura.val().trim() !== '' ? ClienteFactura.val() : '',
                    DOCUMENTO_FACTURA: FAPEORCOFactura.val().trim() !== '' ? FAPEORCOFactura.val() : '',
                    TP: TPFactura.val().trim() !== '' ? TPFactura.val() : ''
                }).done(function (data, x, jq) {
                    onBeep(1);
                    onImprimirReporteFancy('<?php print base_url(); ?>js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs');
                }).fail(function (x, y, z) {
                    swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
                }).always(function () {
                    onCloseOverlay();
                });
            } else {
                onBeep(2);
                iMsg('DEBE DE ESPECIFICAR UN CLIENTE, DOCUMENTO VÁLIDO Y UN TP', 'w', function () {
                    ClienteFactura[0].selectize.focus();
                });
            }
//                } else {
//                    iMsg('ESTE DOCUMENTO NO TIENE UNA FACTURA ASOCIADA', 'w', function () {
//                        FAPEORCOFactura.focus().select();
//                    });
//                }
//            }).fail(function (x) {
//                getError(x);
//            }).always(function () {
//
//            });
        });

        btnFacturaXAnticipoDeProducto.click(function () {
            onBeep(1);
            getTotalFacturado();
        });

        btnEtiquetasParaCaja.click(function () {
            onBeep(1);
            $("#mdlEtiquetaCajas").modal('show');
        });

        btnMovClientes.click(function () {
            onBeep(1);
            onOpenWindow('<?php print base_url('MovimientosCliente'); ?>');
        });

        btnAcepta.click(function () {
            var pares = 0, pares_facturados = 0, pares_a_facturar = 0, pares_finales = 0, validos = true,
                    pc = 0, pf = 0, paf = 0, pf_mas_paf = 0;
            for (var i = 1; i < 23; i++) {
                pc = pnlTablero.find("#C" + i).val();
                pf = pnlTablero.find("#CF" + i).val();
                paf = pnlTablero.find("#CAF" + i).val();
                pf_mas_paf = parseInt(pf ? pf : 0) + parseInt(paf ? paf : 0);
                pares += parseInt(pc ? pc : 0); /*FIJO*/
                pares_facturados += parseInt(pf ? pf : 0);
                pares_a_facturar += parseInt(paf ? paf : 0);
                if (pares >= 0 && pares_a_facturar >= 0 && pares_a_facturar <= pares && pf_mas_paf <= pc) {
                    validos = true;
                } else {
                    console.log(pc, pf, paf, pf_mas_paf);
                    console.log('LA SUMA DE PARES DE CF' + i + ' + CAF' + i + ' NO CONCUERDAN CON C' + i + ', ESTA CANTIDAD YA SE CONCLUYO O COMPLETO');
                    validos = false;
                    break;
                }
            }

            pares_finales = pares_facturados + pares_a_facturar;

            if (pares_a_facturar > 0) {
                console.log("son pares validos? => ", validos);
                if (pares_finales <= pares && validos) {
                    console.log('PARES OK');
                    onAceptarControl();
                } else {
                    iMsg('NO SE PUEDEN FACTURAR MÁS PARES DE LOS ESTABLECIDOS, INGRESE UNA CANTIDAD MENOR', 'w', function () {
                        pnlTablero.find("#CAF1").focus().select();
                    });
                }
            } else {
                iMsg('ES NECESARIO ESPECIFICAR UNA CANTIDAD A FACTURAR MAYOR A CERO', 'w', function () {
                    pnlTablero.find("#CAF1").focus().select();
                });
            }
        });

        btnCierraDocto.click(function () {
            onBeep(1);
            if (ClienteFactura.val()) {
                onOpenOverlay('Guardando...');
                var p = {
                    FECHA: FechaFactura.val(),
                    CLIENTE: ClienteFactura.val(),
                    TP_DOCTO: TPFactura.val(),
                    FACTURA: FAPEORCOFactura.val(),
                    MONEDA: TMNDAFactura.val(),
                    IMPORTE_TOTAL_SIN_IVA: SubtotalFacturacion.val(),
                    TIPO_DE_CAMBIO: TIPODECAMBIO.val(),
                    REFACTURACION: xRefacturacion[0].cheked ? 1 : 0
                };
                $.post('<?php print base_url('FacturacionProduccion/onCerrarDocto') ?>', p).done(function (abc) {
                    iMsg('SE HA CERRADO EL DOCTO', 's', function () {
                        btnCierraDocto.attr('disabled', true);
                        ClienteFactura[0].selectize.enable();
                        TPFactura[0].selectize.enable();
                        FechaFactura.attr('readonly', false);
                        FAPEORCOFactura.attr('readonly', false);
                        FCAFactura.attr('readonly', false);
                        PAGFactura.attr('readonly', false);
                        TMNDAFactura.attr('readonly', false);
                    });
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    onCloseOverlay();
                });
            } else {
                iMsg('LOS SIGUIENTES CAMPOS SON REQUERIDOS', 'w', function () {
                    ClienteFactura[0].selectize.focus();
                });
            }
        });

        FAPEORCOFactura.on('keydown', function (e) {
            if (e.keyCode === 13) {
                onOpenOverlay('Espere un momento por favor...');
                $.getJSON('<?php print base_url('FacturacionProduccion/onComprobarFactura'); ?>',
                        {CLIENTE: (ClienteFactura.val() ? ClienteFactura.val() : ''), FACTURA: FAPEORCOFactura.val()
                        }).done(function (a) {
                    if (a.length > 0) {
                        console.log("COMPROBANDO FACTURA => ", a, ClienteFactura.val(), a[0].CLIENTE);

                        if (parseInt(a[0].FACTURA_EXISTE) === 0) {
                            btnAcepta.attr('disabled', false);
                            btnVistaPreviaF.attr('disabled', true);
                            btnReimprimeDocto.attr('disabled', true);
                            CajasFacturacion.attr('disabled', false);
                            onCloseOverlay();
                        } else {
                            if (ClienteFactura.val() === a[0].CLIENTE) {
                                btnVistaPreviaF.attr('disabled', false);
                                btnReimprimeDocto.attr('disabled', false);
                                btnAcepta.attr('disabled', true);
                                CajasFacturacion.attr('disabled', true);
                                onDisableInputs(true);
                                $.getJSON('<?php print base_url('FacturacionProduccion/getFacturaXFolio'); ?>',
                                        {
                                            CLIENTE: ClienteFactura.val(),
                                            FACTURA: FAPEORCOFactura.val(),
                                            TP: TPFactura.val()
                                        }).done(function (a) {
                                    if (a.length > 0) {
                                        /*DATOS DEL ENCABEZADO*/
                                        FechaFactura.val(a[0].FECHA_FACTURA);
                                        TMNDAFactura.val(a[0].TIPO_MONEDA);
                                        onNotifyOld('', 'ESTE DOCUMENTO SE ENCUENTRA "' + a[0].ESTATUS_PRODUCCION + '" ', 'info');
                                        /*DATOS DEL DETALLE*/
                                        ParesFacturados.rows().remove().draw();
                                        var facturado = false;
                                        var r = [];
                                        $.each(a, function (k, v) {
                                            r.push([v.ID, v.FACTURA, v.CLIENTE, v.CONTROL, v.FECHA_FACTURA, v.PARES,
                                                v["par01"], v["par02"], v["par03"], v["par04"], v["par05"],
                                                v["par06"], v["par07"], v["par08"], v["par09"], v["par10"],
                                                v["par11"], v["par12"], v["par13"], v["par14"], v["par15"],
                                                v["par16"], v["par17"], v["par18"], v["par19"], v["par20"],
                                                v["par21"], v["par22"],
                                                '$' + $.number(v.PRECIO, 2, '.', ','), v.PRECIO,
                                                '$' + $.number(v.SUBTOTAL, 2, '.', ','), v.SUBTOTAL,
                                                '<span class="fa fa-lock"></span>',
                                                v.CAJAS_FACTURACION, v.OBS, v.DESCUENTO, v.PARES_FACTURADOS, v.FACTURA, v.TIPO_MONEDA, 1,
                                                v.ESTATUS_PRODUCCION, 1]);
                                            if (v.ESTATUS_PRODUCCION === 'FACTURADO' && !facturado) {
                                                facturado = true;
                                            }
                                        });
                                        ParesFacturados.rows.add(r).draw(false);
                                        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
                                        onCloseOverlay();
                                        getTotalFacturado();
                                        pnlTablero.find("#btnNuevo").removeClass("d-none");
                                        pnlTablero.find("#btnNuevo").attr("disabled", false);
                                        Control.attr('disabled', true);
                                        btnElijeControl.attr('disabled', true);
                                        if (facturado) {
                                            ClienteFactura[0].selectize.disable();
                                            TPFactura[0].selectize.disable();
                                            btnElijeControl.addClass("d-none");
                                            btnAcepta.addClass("d-none");
                                        }
                                    } else {
                                        pnlTablero.find("#btnNuevo").addClass("d-none");
                                        pnlTablero.find("#btnNuevo").attr("disabled", true);
                                    }
                                }).fail(function (x) {
                                    getError(x);
                                }).always(function () {
                                });
                            } else {
                                iMsg('ESTA FACTURA NO PERTENECE A ESTE CLIENTE', 'w', function () {
                                    ClienteFactura[0].selectize.focus();
                                });
                            }
                        }

                    } else {
                        btnAcepta.attr('disabled', true);
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {

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
            onBeep(1);
            if (ClienteFactura.val()) {
                if (Control.val()) {
                    for (var i = 1; i < 21; i++) {
                        var x = pnlTablero.find(`#C${i}`).val();
                        var xx = pnlTablero.find(`#CF${i}`).val() ? pnlTablero.find(`#CF${i}`).val() : 0;
                        if (parseFloat(x) > 0) {
                            pnlTablero.find("#CAF" + i).val(x - xx);
                        } else {
                            pnlTablero.find("#CAF" + i).val(0);
                        }
                    }
                    pnlTablero.find("#CAF1").focus().select();
                } else {
                    swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CONTROL', 'warning').then((value) => {
                        Control.focus().select();
                    });
                }
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CLIENTE', 'warning').then((value) => {
                    ClienteFactura[0].selectize.focus();
                });
            }
        });

        btnControlInCompleto.click(function () {
            onBeep(1);
            if (ClienteFactura.val()) {
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
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CLIENTE', 'warning').then((value) => {
                    ClienteFactura[0].selectize.focus();
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
                        {"data": "PRECIOT"}, {"data": "PRECIO"},
                        {"data": "COLORT"}
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
                    Control.val(xxx.CONTROL);
                    EstiloFacturacion.val(xxx.ESTILO);
                    ColorFacturacion.val(xxx.COLORT);
                    ColorClaveFacturacion.val(xxx.COLOR);
                    CajasFacturacion.val(1);
                    CajasFacturacion.focus().select();
                    getInfoXControl();
                    mdlControlesXFacturar.modal('hide');
                    CajasFacturacion.focus().select();
                });
            } else if ($.fn.DataTable.isDataTable('#tblControlesXFacturar')) {
                ControlesXFacturar.ajax.reload();
            }
        });

        btnControlesXFac.click(function () {
            onBeep(1);
            if (ClienteFactura.val()) {
                mdlControlesXFacturar.modal({keyboard: false});
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
//                    onOpenOverlay('');
                    $.getJSON('<?php print base_url('FacturacionProduccion/getUltimaFactura') ?>', {
                        TP: x
                    }).done(function (a) {
                        if (a.length > 0) {
                            var r = parseInt(TPFactura.val()) === 1 ? a[0].ULFAC : a[0].ULFACR;
                            FAPEORCOFactura.val(r);
                            var ref = padLeft(ClienteFactura.val(), 4) + '' + r;
                            getReferencia();
//                            pnlTablero.find(".ReferenciaFactura").text(ref);
//                            ReferenciaFacturacion.val(ref);
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
            onBeep(1);
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
//                onOpenOverlay('');
                $.post('<?php print base_url('FacturacionProduccion/getListaDePreciosXCliente') ?>', {
                    CLIENTE: ClienteFactura.val()
                }).done(function (a) {
                    if (a.length > 0) {
                        var xxx = JSON.parse(a);
                        LPFactura.val(xxx[0].LP);
                        DescuentoFacturacion.val((parseFloat(xxx[0].DESCUENTO) > 1) ? xxx[0].DESCUENTO : (100 * parseFloat(xxx[0].DESCUENTO)));
                        ZonaFacturacion.val(xxx[0].ZONA);
                        AgenteCliente.val(xxx[0].AGENTE);
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
            dom: 'rit',
            "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }, {
                    "targets": [29]/*PRECIOT*/,
                    "visible": false,
                    "searchable": true
                }, {
                    "targets": [31]/*SUBTOTALT*/,
                    "visible": false,
                    "searchable": true
                }, {
                    "targets": [33]/*CAJAS*/,
                    "visible": false,
                    "searchable": true
                }, {
                    "targets": [34]/*OBSERVACIONES*/,
                    "visible": false,
                    "searchable": true
                }, {
                    "targets": [35]/*DESCUENTO*/,
                    "visible": false,
                    "searchable": true
                }, {
                    "targets": [36]/*PARES*/,
                    "visible": false,
                    "searchable": true
                }, {
                    "targets": [37]/*FOLIO*/,
                    "visible": false,
                    "searchable": true
                }, {
                    "targets": [38]/*MONEDA*/,
                    "visible": false,
                    "searchable": true
                }, {
                    "targets": [39]/*PAG*/,
                    "visible": false,
                    "searchable": true
                }, {
                    "targets": [40]/*ESTATUS CONTROL*/,
                    "visible": false,
                    "searchable": true
                }, {
                    "targets": [41]/*NO IVA CONTROL*/,
                    "visible": false,
                    "searchable": true
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

    function getValor(e) {
        return (parseFloat(pnlTablero.find(e).val()) > 0 ? pnlTablero.find(e).val() : 0);
    }

    function getTalla(e) {
        return (parseFloat(pnlTablero.find(e).val()) > 0 ? pnlTablero.find(e).val() : '-');
    }

    function onEliminarFila(r) {
        console.log($(r).parent().parent());
        ParesFacturados.row($(r).parent().parent()).remove().draw();
        getTotalFacturado();
    }

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
        getTotalPares();
    }

    function getTotalPares() {
        var ttp = 0, ttpf = 0, ttpaf = 0;
        for (var i = 1; i < 23; i++) {
            var c_component = pnlTablero.find("#C" + i),
                    cf_component = pnlTablero.find("#CF" + i),
                    caf_component = pnlTablero.find("#CAF" + i);
            ttp += (c_component.val() ? parseInt(c_component.val()) : 0);
            ttpf += (cf_component.val() ? parseInt(cf_component.val()) : 0);
            ttpaf += (caf_component.val() ? parseInt(caf_component.val()) : 0);
        }
        TotalParesEntrega.val(ttp);
        TotalParesEntregaF.val(ttpf);
        TotalParesEntregaAF.val(ttpaf);
        pnlTablero.find(".produccionfabricados").text(ttp);
        pnlTablero.find(".produccionfacturados").text(ttpf);
        pnlTablero.find(".produccionsaldo").text((ttpf > 0) ? ttpaf : ttp);
    }

    function getReferencia() {
        var txtreferen11 = "000000000000398827";
        txtreferen11 = padLeft(ClienteFactura.val(), 14) + '' + padLeft(FAPEORCOFactura.val(), 4);

        var num1 = 0, num2 = 0, num3 = 0, num4 = 0, num5 = 0,
                num6 = 0, num7 = 0, num8 = 0, num9 = 0,
                num10 = 0, num11 = 0, num12 = 0, num13 = 0,
                num14 = 0, num15 = 0, num16 = 0, num17 = 0, num18 = 0,
                num19 = 313, num20 = 802, txtreferen2 = 0, txtreferen3 = 0, txtreferen4 = 0,
                txtreferen9 = 0, txtreferen10 = 0;

        console.log("\n ZERO PAD: ", txtreferen11, txtreferen11.length);

        for (var refe1 = 1; refe1 <= txtreferen11.length; refe1++) {
            txtreferen2 = txtreferen11.substr(refe1 - 1, 1);
            switch (refe1) {
                case 1:
                    num1 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 19 : 0);
                    break;
                case 2:
                    num2 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 23 : 0);
                    break;
                case 3:
                    num3 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 29 : 0);
                    break;
                case 4:
                    num4 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 31 : 0);
                    break;
                case 5:
                    num5 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 37 : 0);
                    break;
                case 6:
                    num6 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 1 : 0);
                    break;
                case 7:
                    num7 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 2 : 0);
                    break;
                case 8:
                    num8 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 3 : 0);
                    break;
                case 9:
                    num9 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 5 : 0);
                    break;
                case 10:
                    num10 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 7 : 0);
                    break;
                case 11:
                    num11 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 11 : 0);
                    break;
                case 12:
                    num12 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 13 : 0);
                    break;
                case 13:
                    num13 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 17 : 0);
                    break;
                case 14:
                    num14 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 19 : 0);
                    break;
                case 15:
                    num15 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 23 : 0);
                    break;
                case 16:
                    num16 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 29 : 0);
                    break;
                case 17:
                    num17 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 31 : 0);
                    break;
                case 18:
                    num18 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 37 : 0);
                    break;
            }
        }


        txtreferen3 = num1 + num2 + num3 + num4 + num5 + num6 + num7 + num8 + num9 +
                num10 + num11 + num12 + num13 + num14 + num15 + num16 + num17 + num18 + num19 + num20;
        var res = 0, res1 = 0, res2 = 0, res3 = 0;
        console.log("txtreferen3 => " + txtreferen3);
        txtreferen4 = txtreferen3 / 97;
        console.log("txtreferen4 => " + txtreferen4, "txtreferen4 res =>" + (txtreferen4 % 1), "txtreferen4 - res=>" + (txtreferen4 - (txtreferen4 % 1)));
        res = (txtreferen4 % 1);
        res1 = res * 100;
        res2 = res1 % 1;
        res3 = res1 - res2;

        console.log("res => " + res, "res1=>" + res1, "res2=>" + res2, "res3=>" + res3);

        var ponderador_fijo = 99;
        if (res3 > 0) {
            txtreferen10 = ponderador_fijo - res3 + 1;
        } else {
            txtreferen10 = ponderador_fijo - res3;
        }
        console.log("txtreferen10 => " + txtreferen10);
        pnlTablero.find(".ReferenciaFactura").text(txtreferen11 + "" + txtreferen10);
        ReferenciaFacturacion.val(txtreferen11 + "" + txtreferen10);
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
                if (abcd.length > 0) {
                    if (abcd[0].CLIENTE === clientesito) {
                        control_pertenece_a_cliente = true;
                    } else {
                        onBeep(2);
                        iMsg('EL CONTROL ESPECIFICADO NO PERTENECE A ESTE CLIENTE, INTENTE CON UNO DIFERENTE', 'w', function () {
                            onResetCampos();
                            Control.focus().select();
                        });
                    }
                    if (clientesito !== '' && clientesito === abcd[0].CLIENTE) {
                        $.getJSON('<?php print base_url('FacturacionProduccion/getFacturacionDiff'); ?>', {
                            CONTROL: Control.val() ? Control.val() : ''
                        }).done(function (aa) {
                            var abc = aa[0];
                            if (abc !== undefined) {
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
                                                pnlTablero.find("span.T" + i).text(xx["T" + i]);
                                                pnlTablero.find("#T" + i).attr("title", xx["T" + i]);
                                                pnlTablero.find("#T" + i).attr("data-original-title", xx["T" + i]);
                                                pnlTablero.find(`#C${i}`).val(xx["C" + i]);
                                                var cf = (parseInt(pnlTablero.find("#CF" + i).val()) > 0 ? parseInt(pnlTablero.find("#CF" + i).val()) : 0);
                                                pnlTablero.find("#CAF" + i).val((parseFloat(xx["C" + i]) > 0 ? parseInt(xx["C" + i]) - cf : 0));
                                                pnlTablero.find("#C" + i).attr("title", xx["C" + i]);
                                                pnlTablero.find("#C" + i).attr("data-original-title", xx["C" + i]);
                                                t += parseInt(xx["C" + i]);
                                                TotalParesEntrega.val(t);
                                                TotalParesEntregaAF.val(t);
                                            }
                                        }
                                        getTotalPares();
                                        /*OBTENER CODIGO DEL SAT X ESTILO*/
                                        onObtenerCodigoSatXEstilo();
                                        FolioFactura.val(xx.CLAVE_PEDIDO);
                                        CorridaFacturacion.val(xx.SERIET);
                                        EstiloFacturacion.val(xx.ESTILOT);
                                        EstiloTFacturacion.val(xx.ESTILO_TEXT);
                                        ColorFacturacion.val(xx.COLORT);
                                        PrecioFacturacion.val(xx.PRECIO);
                                        CajasFacturacion.val(1);
                                        CajasFacturacion.focus().select();
                                        var prs = parseFloat(TotalParesEntregaAF.val() ? TotalParesEntregaAF.val() : 0);
                                        var stt = parseFloat(xx.Precio) * prs;
                                        SubtotalFacturacion.val(stt);
                                        SubtotalFacturacionIVA.val(stt * 0.16);
                                        //                                        pnlTablero.find(".totalfacturadoenletrapie").text(NumeroALetras(stt));
                                        TotalLetra.find("span").text(NumeroALetras(stt));
                                        pnlTablero.find("#cCST")[0].checked = (xx.ESTATUS === 'PRODUCTO TERMINADO');
                                        EstatusControl.val(xx.ESTATUS);
                                        btnFacturaXAnticipoDeProducto.attr('disabled', false);
                                        btnControlInCompleto.attr('disabled', false);
                                        btnControlCompleto.attr('disabled', false);
                                    } else {
                                        Control.focus().select();
                                        btnFacturaXAnticipoDeProducto.attr('disabled', true);
                                        btnControlInCompleto.attr('disabled', true);
                                        btnControlCompleto.attr('disabled', true);
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
                                    btnFacturaXAnticipoDeProducto.attr('disabled', true);
                                    btnControlInCompleto.attr('disabled', true);
                                    btnControlCompleto.attr('disabled', true);
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
                onCloseOverlay();
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
        Control.attr('disabled', false);
        btnFacturaXAnticipoDeProducto.attr('disabled', true);
        btnControlInCompleto.attr('disabled', true);
        btnControlCompleto.attr('disabled', true);
        TotalParesEntrega.val('');
        TotalParesEntregaF.val('');
        TotalParesEntregaAF.val('');
        FolioFactura.val('');
        CorridaFacturacion.val('');
        EstiloFacturacion.val('');
        ColorFacturacion.val('');
        PrecioFacturacion.val('');
        CajasFacturacion.val('');
        getTotalFacturado();
    }

    function getTotalFacturado() {
        var t = 0, indice = 31;
        $.each(ParesFacturados.rows().data(), function (k, v) {
            t += $.isNumeric(v[indice]) ? parseFloat(v[indice]) : 0;
        });
        switch (parseInt(TPFactura.val())) {
            case 1:
                pnlTablero.find(".subtotalfacturadopie").text('$' + $.number(parseFloat(t), 2, '.', ','));
                pnlTablero.find(".totalivafacturadopie").text('$' + $.number(parseFloat(t * 0.16), 2, '.', ','));
                t *= 1.16;
                pnlTablero.find(".totalfacturadohead").text('$' + $.number(parseFloat(t), 2, '.', ','));
                pnlTablero.find(".totalfacturadopie").text('$' + $.number(parseFloat(t), 2, '.', ','));
                TotalLetra.find("span").text(NumeroALetras(t));
                pnlTablero.find(".totalfacturadoenletrapie").text(NumeroALetras(t));
                pnlTablero.find(".totalfacturadoenletrapieDLLS").text(NumeroALetras(t));

                break;
            case 2:
                pnlTablero.find(".totalfacturadohead").text('$' + $.number(parseFloat(t), 2, '.', ','));
                pnlTablero.find(".totalfacturadopie").text('$' + $.number(parseFloat(t), 2, '.', ','));
                TotalLetra.find("span").text(NumeroALetras(t));
                pnlTablero.find(".totalfacturadoenletrapie").text(NumeroALetras(t));

                pnlTablero.find(".totalfacturadoenletrapieDLLS").text(NumeroALetras(t));
                break;
        }
    }

    function onRecalcularSubtotal() {
        var pares = 0;
        for (var i = 1; i < 23; i++) {
            pares += parseInt(getValor('#CAF' + i));
        }
        SubtotalFacturacion.val(pares * PrecioFacturacion.val());
    }

    function onObtenerCodigoSatXEstilo() {
        /*OBTENER CODIGO DEL SAT X ESTILO*/
        $.getJSON('<?php print base_url('FacturacionProduccion/onObtenerCodigoSatXEstilo'); ?>', {ESTILO: EstiloFacturacion.val()}).done(function (abcd) {
            if (abcd.length > 0) {
                CodigoSat.val(abcd[0].CPS);
            }
        });
    }
    function onAceptarControl() {

        onBeep(1);
        onOpenOverlay('Guardando...');
        onRecalcularSubtotal();
        var a = '<div class="row"><div class="col-12 text-danger text-nowrap talla font-weight-bold" align="center">';
        var b = '</div><div class="col-12 cantidad" align="center">';
        var c = '</div></div>';
        var rowx = [
            123456789010, FAPEORCOFactura.val(), ClienteFactura.val(), Control.val(), FechaFactura.val(),
            TotalParesEntregaAF.val()
        ];
        for (var i = 1; i < 23; i++) {
            rowx.push(a + getTalla('#T' + i) + b + getValor('#CAF' + i) + c);
        }
        rowx.push('$' + $.number(parseFloat(PrecioFacturacion.val()), 2, '.', ','));
        rowx.push(PrecioFacturacion.val());
        rowx.push('$' + $.number(parseFloat(SubtotalFacturacion.val()), 2, '.', ','));
        rowx.push(SubtotalFacturacion.val());
        rowx.push('<button type="button" class="btn btn-danger" onclick="onEliminarFila(this);"><span class="fa fa-trash"></span></button>');
        rowx.push(CajasFacturacion.val());
        rowx.push(ObservacionFacturacion.val());
        rowx.push(DescuentoFacturacion.val());
        rowx.push(ParesFacturadosFacturacion.val());
        rowx.push(FAPEORCOFactura.val());
        rowx.push(TMNDAFactura.val());
        rowx.push(PAGFactura.val());
        rowx.push(EstatusControl.val());
        rowx.push((pnlTablero.find("#cNoIva")[0].checked ? 1 : 0));
        //            console.log(rowx);
        ParesFacturados.row.add(rowx).draw(false);
        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
        getTotalFacturado();
        /*DESHABILITAR CAMPOS*/
        FechaFactura.attr('readonly', true);
        FAPEORCOFactura.attr('readonly', true);
        FCAFactura.attr('readonly', true);
        PAGFactura.attr('readonly', true);
        TMNDAFactura.attr('readonly', true);
        ClienteFactura[0].selectize.disable();
        TPFactura[0].selectize.disable();
        /*REGISTRAR EN FACTURACION*/
        var p = {
            FECHA: FechaFactura.val(),
            CLIENTE: ClienteFactura.val(),
            AGENTE: AgenteCliente.val(),
            TP_DOCTO: TPFactura.val(),
            FOLIO: FolioFactura.val(),
            FACTURA: FAPEORCOFactura.val(),
            CONTROL: Control.val(),
            SERIE: CorridaFacturacion.val(),
            ESTILO: EstiloFacturacion.val(),
            ESTILOT: EstiloTFacturacion.val(),
            CODIGO_SAT: CodigoSat.val(),
            COLOR: ColorClaveFacturacion.val(),
            PARES: TotalParesEntrega.val(),
            PARES_FACTURADOS: TotalParesEntregaF.val(),
            PARES_A_FACTURAR: TotalParesEntregaAF.val(),
            TIENDA: Tienda.val()
        };
        for (var i = 1; i < 23; i++) {
            p["C" + i] = ($.isNumeric(pnlTablero.find("#C" + i).val()) ? parseInt(pnlTablero.find("#C" + i).val()) : 0);
            p["CF" + i] = ($.isNumeric(pnlTablero.find("#CF" + i).val()) ? parseInt(pnlTablero.find("#CF" + i).val()) : 0);
            p["CAF" + i] = ($.isNumeric(pnlTablero.find("#CAF" + i).val()) ? parseInt(pnlTablero.find("#CAF" + i).val()) : 0);
        }
        p["PRECIO"] = PrecioFacturacion.val();
        p["SUBTOTAL"] = SubtotalFacturacion.val();
        p["IVA"] = (SubtotalFacturacion.val() * 0.16);
        p["TOTAL_EN_LETRA"] = NumeroALetras(SubtotalFacturacion.val());
        p["MONEDA"] = TMNDAFactura.val();
        p["TIPO_CAMBIO"] = TIPODECAMBIO.val();
        p["CAJAS"] = CajasFacturacion.val();
        p["REFERENCIA"] = ReferenciaFacturacion.val();
        p["COLOR_TEXT"] = ColorFacturacion.val();
        p["ZONA"] = ZonaFacturacion.val();
        p["OBSERVACIONES"] = ObservacionFacturacion.val();
//        console.log("\p PARAMETROS ", p);
        $.post('<?php print base_url('FacturacionProduccion/onGuardarDocto'); ?>', p).done(function (a) {
            nuevo = false;
            /*REINICIAR VALORES POR DEFECTO PARA EL DETALLE*/
            for (var i = 1; i < 23; i++) {
                pnlTablero.find("#T" + i).val('');
                pnlTablero.find("#C" + i).val('');
                pnlTablero.find("#CF" + i).val('');
                pnlTablero.find("#CAF" + i).val('');
            }
            pnlTablero.find(".produccionfabricados").text('0');
            pnlTablero.find(".produccionfacturados").text('0');
            pnlTablero.find(".produccionsaldo").text('0');
            TotalParesEntrega.val('');
            TotalParesEntregaF.val('');
            TotalParesEntregaAF.val('');
            CajasFacturacion.val('');
            EstiloFacturacion.val('');
            EstiloTFacturacion.val('');
            CodigoSat.val('');
            ColorClaveFacturacion.val('');
            ColorFacturacion.val('');
            CorridaFacturacion.val('');
            PrecioFacturacion.val('');
            SubtotalFacturacion.val('');
            SubtotalFacturacionIVA.val('');
            ObservacionFacturacion.val('');
            ParesFacturadosFacturacion.val('');
            btnCierraDocto.attr('disabled', false);
            btnFacturaXAnticipoDeProducto.attr('disabled', true);
            btnControlInCompleto.attr('disabled', true);
            btnControlCompleto.attr('disabled', true);

            btnVistaPreviaF.attr('disabled', false);
            btnReimprimeDocto.attr('disabled', false);
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            onCloseOverlay();
        });
        /*VOLVER AL CAMPO DE CONTROL*/
        Control.val('');
        Control.focus().select();
    }
    function onCargarDoctoByNumero() {
        var docto = FAPEORCOFactura.val();
    }

    function onDisableInputs(tf) {
        if (tf) {
            FechaFactura.attr('disabled', true);
            ClienteFactura[0].selectize.disable();
            TPFactura[0].selectize.disable();
            FAPEORCOFactura.attr('disabled', true);
            FCAFactura.attr('disabled', true);
            PAGFactura.attr('disabled', true);
            TMNDAFactura.attr('disabled', true);
            Control.attr('disabled', true);
            CajasFacturacion.attr('disabled', true);
            PrecioFacturacion.attr('disabled', true);
            ObservacionFacturacion.attr('disabled', true);
            FAPEORCOFactura.attr('disabled', true);
            for (var i = 1; i < 23; i++) {
                pnlTablero.find("#CAF" + i).attr('disabled', true);
            }
        } else {
            FechaFactura.attr('disabled', false);
            ClienteFactura[0].selectize.enable();
            TPFactura[0].selectize.enable();
            FAPEORCOFactura.attr('disabled', false);
            FCAFactura.attr('disabled', false);
            PAGFactura.attr('disabled', false);
            TMNDAFactura.attr('disabled', false);
            Control.attr('disabled', false);
            CajasFacturacion.attr('disabled', false);
            PrecioFacturacion.attr('disabled', false);
            ObservacionFacturacion.attr('disabled', false);
            for (var i = 1; i < 23; i++) {
                pnlTablero.find("#CAF" + i).attr('disabled', false);
            }
        }

    }
</script>

<style> 
    .card{border: solid 1px #607D8B;}
    #tblParesFacturados tbody td{
        font-weight: bold !important;
    }
    #tblParesFacturados thead th{
        font-size: 12px !important;
    }
    .hr-vertical{ 
        border:         none;
        border-left:    1px solid #ccc;
        height:         10vh;
        width:          1px;       
    }
</style>