<div class="card" id="pnlTablero" style="background-color:  #fff !important;">
    <div class="card-body" style="padding-top: 0px;">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <button type="button" id="btnControlesXFac" name="btnControlesXFac" class="btn btn-info d-none">
                    <span class="fa fa-exclamation"></span> CONTROLES X FACTURAR
                </button>
                <button type="button" id="btnNuevaFactura" name="btnNuevaFactura" class="btn btn-success selectNotEnter font-weight-bold" style="background-color: #3F51B5;">
                    <span class="fa fa-star"></span> Nuevo
                </button>
                <div class="btn-group selectNotEnter d-none">
                    <a class="btn btn-info btn-sm dropdown-toggle font-weight-bold" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        CATÁLOGOS
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#" onclick="btnClientes.trigger('click');"><span class="fa fa-users"></span> CLIENTES</a>
                        <a class="dropdown-item" href="#" onclick="btnMovClientes.trigger('click');"><span class="fa fa-exchange-alt"></span> MOVIMIENTOS CLIENTES</a>
                    </div>
                </div>
                <button type="button" id="btnReimprimeDocto" name="btnReimprimeDocto" class="btn btn-primary selectNotEnter font-weight-bold" >
                    <span class="fa fa-print"></span>  REIMPRIMIR DOCTO
                </button>
                <button type="button" id="btnVistaPreviaF" name="btnVistaPreviaF" class="btn btn-info" disabled="">
                    <span class="fa fa-eye-slash"></span> VISTA PREVIA
                </button>
                <button type="button" id="btnCambiaFolio" name="btnCambiaFolio" class="btn btn-warning" style="background-color: #5D4037; border-color: #5D4037;">
                    <span class="fa fa-pen"></span> FOLIO 
                </button>
                <button type="button" id="btnFacAnticipos" name="btnFacAnticipos" class="btn btn-info" style="background-color: #689f38; border-color: #689f38;">
                    <span class="fa fa-file-invoice"></span> ANTICIPOS 
                </button>
                <button type="button" id="btnVerTienda" name="btnVerTienda" class="btn btn-info d-none" style="background-color: #689F38; border-color: #689F38;">
                    <span class="fa fa-eye"></span> TIENDA 
                </button>
                <button type="button" id="btnClientes" name="btnClientes" class="btn btn-primary d-none">
                    <span class="fa fa-users"></span>  CLIENTES
                </button>
                <button type="button" id="btnMovClientes" name="btnMovClientes" class="btn btn-warning d-none">
                    <span class="fa fa-exchange-alt"></span>  MOV-CLIENTES
                </button>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2" align="center">
                <div class="row">
                    <div class="col-10">
                        <h4 class="font-weight-bold font-italic text-danger text-nowrap" style="cursor: pointer;" onclick="getHistorial()">FACTURACIÓN</h4>
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
                <button type="button" id="btnAnticipoX" name="btnAnticipoX" class="btn btn-info">
                    <span class="fa fa-file-archive"></span> ANTICIPOS X
                </button>
                <button type="button" id="btnCierraDocto" name="btnCierraDocto" class="btn btn-danger" disabled="">
                    <span class="fa fa-file-archive"></span>   CIERRA DOCTO
                </button>
                <button type="button" id="btnAdendaCoppel" name="btnAdendaCoppel" class="btn btn-info font-weight-bold">
                    <span class="fa fa-file-archive"></span>   ADDENDA COPPEL 
                </button> 
                <button type="button" id="btnCancelaDoc" name="btnCancelaDoc" class="btn btn-danger d-none" disabled="">
                    <span class="fa fa-file-archive"></span>   CANCELA DOC 
                </button>
                <button type="button" id="btnDevolucion" name="btnDevolucion" class="btn btn-primary selectNotEnter d-none">
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
            <div class="col-12 col-xs-12 col-sm-2 col-md-2 col-lg-4 col-xl-1"   style="padding-right: 5px;"> 
                <label>Fecha</label>
                <input type="text" id="FechaFactura" name="FechaFactura" class="form-control form-control-sm date notEnter">
            </div>
            <div class="col-12 col-xs-12 col-sm-10 col-md-4 col-lg-4 col-xl-4"  style="padding-left: 5px; padding-right: 5px;"> 
                <label class="control-label">Cliente</label>
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-1">
                        <input type="text" id="ClienteClave" name="ClienteClave" autofocus="" class="form-control form-control-sm" placeholder="CLAVE">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-6 col-md-8 col-lg-9 col-xl-9">
                        <select id="ClienteFactura" name="ClienteFactura" class="form-control form-control-sm">
                            <option></option>
                            <?php
//                                YA CONTIENE LOS BLOQUEOS DE VENTA
                            foreach ($this->db->query("SELECT C.Clave AS CLAVE, C.RazonS AS CLIENTE, C.Zona AS ZONA, C.ListaPrecios AS LISTADEPRECIO FROM clientes AS C LEFT JOIN bloqueovta AS B ON C.Clave = B.cliente WHERE C.Estatus IN('ACTIVO') AND B.cliente IS NULL  OR C.Estatus IN('ACTIVO') AND B.`status` = 2 ORDER BY ABS(C.Clave) ASC;")->result() as $k => $v) {
                                print "<option value='{$v->CLAVE}' lista='{$v->LISTADEPRECIO}' zona='{$v->ZONA}'>{$v->CLIENTE}</option>";
                            }
                            ?>
                        </select>
                    </div> 
                </div>
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1 " style="padding-left: 5px; padding-right: 5px;">
                <label>L-P</label>
                <input type="text" id="LPFactura" name="LPFactura" readonly="" data-toggle="tooltip" data-placement="bottom" title="Lista de precios"  class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1 " style="padding-left: 5px; padding-right: 5px;">
                <label>TP</label> 
                <input type="text" id="TPFactura" name="TPFactura" class="form-control form-control-sm  numbersOnly" maxlength="1">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1" style="padding-left: 5px; padding-right: 5px;">
                <label>FA-PE.ORCO</label>
                <input type="text" id="Documento" name="Documento" class="form-control form-control-sm" readonly="">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1 d-none"  style="padding-left: 5px; padding-right: 5px;">
                <label>FC.A</label>
                <input type="number" id="FCAFactura" name="FCAFactura" max="2" min="0" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1"  style="padding-left: 5px; padding-right: 5px;">
                <label>PAG</label>
                <input type="number" id="PAGFactura" name="PAGFactura" max="2" min="0" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1"  style="padding-left: 5px; padding-right: 5px;">
                <label>T-MNDA</label>
                <input type="text" id="TMNDAFactura" name="TMNDAFactura"  class="form-control form-control-sm numbersOnly" maxlength="1"> 
                <span class="font-weight-bold">Tipo de cambio</span> 
                <span class="font-weight-bold tipo_de_cambio text-danger">0.0</span>
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
            <div id="ConsignarATiendax" style="z-index: 5 !important;" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none animated fadeIn">
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
                        <span class="input-group-text text-dark btn-info font-weight-bold" 
                              style=" color: #FFF !important;   
                              cursor: pointer !important;  padding-top: 3px; padding-bottom: 3px; border-top-right-radius: 5px; border-bottom-right-radius:5px;" 
                              id="btnElijeControl" onclick="btnControlesXFac.trigger('click')" data-toggle="tooltip" 
                              data-placement="top" title="ELIJE UN CONTROL">
                            <i class="fa fa-hand-pointer mr-2 "></i>  SELECCIONA UN CONTROL
                        </span>
                    </span>
                </div>
                <input type="text" id="FolioFactura" name="FolioFactura" readonly="" class="form-control form-control-sm d-none">
            </div> 
            <div class="col-6 col-xs-6 col-sm-3 col-md-1 col-lg-2 col-xl-2"> 
                <div class="form-group mt-3">  
                    <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                        <input type="checkbox" class="custom-control-input selectNotEnter" id="chkConsignacion" name="chkConsignacion" style="cursor: pointer !important;">
                        <label class="custom-control-label text-danger labelCheck" for="chkConsignacion" style="cursor: pointer !important;">A CONSIGNACIÓN</label>
                    </div>
                </div>      
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1 d-none">
                <label>Corrida</label>
                <input type="text" id="Corrida" name="Corrida" class="form-control form-control-sm" readonly="">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="row">
                    <div class="col-6" style="border-bottom: 1px solid #0202; ">
                        <div class="row">
                            <div class="col-12" align="center"  style="padding: 0px 10px 0px 10px !important;">
                                <span class="font-weight-bold">PRODUCCIÓN</span>
                            </div>
                            <div class="col-4 font-weight-bold" style="padding: 0px 10px 0px 10px !important;">
                                Fabricados 
                                <span class="font-weight-bold text-danger produccionfabricados"> 0 </span> 
                                <input type="text" id="PrsFabricados" name="PrsFabricados" readonly="" class="d-none form-control form-control-sm">
                            </div>
                            <div class="col-4 font-weight-bold" style="padding: 0px 10px 0px 10px !important;">
                                Facturados 
                                <span class="font-weight-bold text-danger produccionfacturados"> 0 </span> 
                                <input type="text" id="PrsFacturados" name="PrsFacturados" readonly=""  class="d-none form-control form-control-sm">
                            </div>
                            <div class="col-4 font-weight-bold" style="padding: 0px 10px 0px 10px !important;">
                                Saldo 
                                <span class="font-weight-bold text-danger produccionsaldo"> 0 </span>  
                                <input type="text" id="PrsSaldo" name="PrsSaldo" readonly=""  class="d-none form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="col-6" style="border-bottom: 1px solid #0202; ">
                        <div class="row">
                            <div class="col-12 font-weight-bold" align="center"  style="padding: 0px 10px 0px 10px !important;">
                                <span class="font-weight-bold">DEVOLUCIONES</span>
                            </div>
                            <div class="col-4 " style="padding: 0px 10px 0px 10px !important;">
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
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2" align="center">  
                <button type="button" id="btnRefrescaRegistro" name="btnRefrescaRegistro" class="btn btn-sm btn-info d-none">
                    <span class="fa fa-retweet"></span>
                </button>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8" align="center">  

                <div class="table-responsive" style="overflow-x:auto; white-space: nowrap;"> 
                    <table id="tblTallasF" class="Tallas">
                        <thead></thead>
                        <tbody>
                            <tr id="rTallasBuscaManual" style="font-weight: bold !important;">
                                <td class="font-weight-bold">Tallas</td>
                                <?php
                                $style_input = "width: 35px; border: 1px solid #000 !important; font-weight: bold !important;text-align: center;padding-left: 4px;padding-right: 4px;";
                                for ($index = 1; $index < 23; $index++) {
//                                    print '<td><input type="text" style="width: 40px;font-weight: 300 !important; padding-left: 4px; padding-right: 4px;" id="T' . $index . '" name="T' . $index . '"   readonly="" data-toggle="tooltip" data-placement="top" title="XXX" class="form-control form-control-sm"></td>';
                                    print "<td align='center'><span class=\"T{$index}\">-</span></td>";
                                }
                                ?>                        
                                <td></td> 
                            </tr>  
                            <tr class="rCapturaCantidades" id="rCantidades">
                                <td class="font-weight-bold">Pares d'control</td>
                                <?php
                                for ($index = 1; $index < 23; $index++) {
                                    print '<td><input type="text" style="' . $style_input . '" id="C' . $index . '" maxlength="3"  readonly="" class="form-control form-control-sm numbersOnly " name="C' . $index . '"  data-toggle="tooltip" data-placement="top" title="-" onfocus="onCalcularPares(this, 1);
                                    " onchange="onCalcularPares(this, 1);
                                    " keyup="onCalcularPares(this, 1);
                                    " onfocusout="onCalcularPares(this, 1);
                                    "></td>';
                                }
                                ?>
                                <td class="font-weight-bold">
                                    <input type="text" style="<?php print $style_input; ?>" id="TotalParesEntrega" class="form-control form-control-sm " readonly=""  data-toggle="tooltip" data-placement="top" title="0"></td>
                                <td>
                                </td>
                            </tr>
                            <tr class="rCapturaCantidades" id="rCantidades">
                                <td class="font-weight-bold">Facturado</td>
                                <?php
                                for ($index = 1; $index < 23; $index++) {
                                    print '<td><input type="text"  style="' . $style_input . '"  id="CF' . $index . '" maxlength="3"  readonly="" class="form-control form-control-sm numbersOnly " name="CF' . $index . '" onfocus="onCalcularPares(this, 2);
                                    " onchange="onCalcularPares(this, 2);
                                    " keyup="onCalcularPares(this, 2);
                                    " onfocusout="onCalcularPares(this, 2);
                                    "></td>';
                                }
                                ?>
                                <td class="font-weight-bold">
                                    <input type="text"  style="<?php print $style_input; ?>" id="TotalParesEntregaF" 
                                           class="form-control form-control-sm " readonly="" data-toggle="tooltip" data-placement="right" title="0">
                                </td>
                            </tr>
                            <tr class="rCapturaCantidades" id="rCantidades">
                                <td class="font-weight-bold">A Facturar</td>
                                <?php
                                for ($index = 1; $index < 23; $index++) {
                                    print '<td><input type="text"  style="' . $style_input . '"  id="CAF' . $index . '" maxlength="3" class="form-control form-control-sm numbersOnly notdot notminus" name="CAF' . $index . '" onfocus="onCalcularPares(this, 3);
                                    " onchange="onCalcularPares(this, 3);
                                    " keyup="onCalcularPares(this, 3);
                                    " onfocusout="onCalcularPares(this, 3);
                                    "></td>';
                                }
                                ?>
                                <td class="font-weight-bold">
                                    <input type="text" style="<?php print $style_input; ?>"  id="TotalParesEntregaAF" class="form-control form-control-sm " readonly=""  data-toggle="tooltip" data-placement="right" title="0">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-1" align="center">
                <div class="row" align="center">
                    <button type="button" style="background-color: #4CAF50;" class="btn btn-warning notEnter selectNotEnter btn-block" id="btnFacturaXAnticipoDeProducto" disabled="">
                        <span class="fa fa-exclamation"></span> POR ANTICIPO DE PRODUCTO
                    </button>  
                    <div class="w-100"></div>
                    <button type="button" class="btn btn-danger notEnter selectNotEnter btn-block" disabled="" id="btnControlInCompleto" style="border-color: #C62828 !important; background-color: #C62828 !important;">
                        <span class="fa fa-exclamation"></span> CONTROL INCOMPLETO
                    </button> 
                    <div class="w-100"></div>
                    <button type="button" class="btn btn-success notEnter selectNotEnter  btn-block" id="btnControlCompleto" disabled="">
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
                <input type="text" id="CajasFacturacion" name="CajasFacturacion" style="color: #ff0000 !important;" class="form-control form-control-sm numbersOnly font-weight-bold">
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
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-1" style="padding-left: 5px; padding-right: 5px;">
                <label>Corrida</label>
                <input type="text" id="CorridaFacturacion" name="CorridaFacturacion" readonly="" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-1" style="padding-left: 5px; padding-right: 5px;">
                <label>Precio</label>
                <input type="text" id="PrecioFacturacion" name="PrecioFacturacion" style="color: #673AB7 !important;font-size: 14px !important;font-weight: bold !important;padding-top: 1px;border: solid 1px #000 !important;" class="form-control form-control-sm font-weight-bold numbersOnly">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2" style="padding-left: 5px; padding-right: 5px;">
                <label>Subtotal</label>
                <input type="text" id="SubtotalFacturacion" name="SubtotalFacturacion" readonly="" class="form-control form-control-sm">
                <input type="text" id="SubtotalFacturacionIVA" name="SubtotalFacturacionIVA" readonly="" class="d-none form-control form-control-sm">
            </div>
            <div class = "w-100"></div>
            <div class = "col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2">
                <div class = "form-group mt-4">
                    <div class = "custom-control custom-checkbox" align = "center" style = "cursor: pointer !important;">
                        <input type = "checkbox" class = "custom-control-input selectNotEnter" id = "xRefacturacion" name = "xRefacturacion" style = "cursor: pointer !important;">
                        <label class = "custom-control-label text-danger labelCheck" for = "xRefacturacion" style = "cursor: pointer !important;">X Refacturación</label>
                    </div>
                </div>
            </div>
            <div class = "col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-5" style = "padding-left: 5px; padding-right: 5px;">
                <label>Observación</label>
                <textarea id = "ObservacionFacturacion" name = "ObservacionFacturacion" class = "form-control form-control-sm" rows = "2" cols = "3"></textarea>
            </div>
            <div class = "col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-1" style = "padding-left: 5px; padding-right: 5px;">
                <label>Descuento</label>
                <input type = "text" id = "DescuentoFacturacion" name = "DescuentoFacturacion" class = "form-control form-control-sm numbersOnly">
            </div>
            <div class = "col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2" style = "padding-left: 5px; padding-right: 5px;">
                <label>Pares Facturados</label>
                <input type = "text" id = "ParesFacturadosFacturacion" name = "ParesFacturadosFacturacion" readonly = "" class = "form-control form-control-sm">
            </div>
            <div class = "col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                <button type = "button" id = "btnAcepta" name = "btnAcepta" class = "btn btn-info mt-4" disabled = "">
                    <span class = "fa fa-check"></span> ACEPTA
                </button>
            </div>
            <div id = "TotalLetra" class = "col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                <span class = "font-weight-bold font-italic text-danger">
                    -
                </span>
            </div>
            <div class="w-100 my-2">
            </div>

            <!--DETALLE DE LA FACTURA-->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none" align="center">
                <hr>
            </div>

            <div class="col-12 col-lg-12 col-xl-12">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 d-none"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 d-none" align="center">
                        <h5 class="font-weight-bold text-danger font-italic">
                            DETALLE DE LA FACTURA
                        </h5>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 d-none" align="right">
                        <h4 class="font-weight-bold text-danger font-italic totalfacturadohead">$ 0.0</h4>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <table id="tblParesFacturados" class="table table-hover table-sm" style="width: 100% !important;">
                    <thead>
                        <tr style="background-color:#000000; color: #ffffff;">
                            <th scope="col">ID</th>
                            <!--0 -->
                            <th scope="col">Factura</th>
                            <!--1 -->
                            <th scope="col">Cliente</th>
                            <!--2 -->
                            <th scope="col">Control</th>
                            <!--3 -->
                            <th scope="col">Fecha</th>
                            <!--4 -->
                            <th scope="col">Pares</th>
                            <!--5 -->
                            <th scope="col">T1</th>
                            <!--6 -->
                            <!--1 -->
                            <th scope="col">T2</th>
                            <!--7 -->
                            <!--2 -->
                            <th scope="col">T3</th>
                            <!--8 -->
                            <!--3 -->
                            <th scope="col">T4</th>
                            <!--9 -->
                            <!--4 -->
                            <th scope="col">T5</th>
                            <!--10 -->
                            <!--5 -->
                            <th scope="col">T6</th>
                            <!--11 -->
                            <!--6 -->
                            <th scope="col">T7</th>
                            <!--12 -->
                            <!--7 -->
                            <th scope="col">T8</th>
                            <!--13 -->
                            <!--8 -->
                            <th scope="col">T9</th>
                            <!--14 -->
                            <!--9 -->
                            <th scope="col">T10</th>
                            <!--15 -->
                            <!--10 -->
                            <th scope="col">T11</th>
                            <!--16 -->
                            <!--11 -->
                            <th scope="col">T12</th>
                            <!--17 -->
                            <!--12 -->
                            <th scope="col">T13</th>
                            <!--18 -->
                            <!--13 -->
                            <th scope="col">T14</th>
                            <!--19 -->
                            <!--14 -->
                            <th scope="col">T15</th>
                            <!--20 -->
                            <!--15 -->
                            <th scope="col">T16</th>
                            <!--21 -->
                            <!--16 -->
                            <th scope="col">T17</th>
                            <!--22 -->
                            <!--17 -->
                            <th scope="col">T18</th>
                            <!--23 -->
                            <!--18 -->
                            <th scope="col">T19</th>
                            <!--23 -->
                            <!--19 -->
                            <th scope="col">T20</th>
                            <!--25 -->
                            <!--20 -->
                            <th scope="col">T21</th>
                            <!--26 -->
                            <!--21 -->
                            <th scope="col">T22</th>
                            <!--27 -->
                            <!--22 -->

                            <th scope="col">Precio</th>
                            <!--28 -->
                            <!--OUT-->
                            <th scope="col">PrecioT</th>
                            <!--29 -->
                            <th scope="col">SubTotal</th>
                            <!--30 -->
                            <th scope="col">SubTotalT</th>
                            <!--31 -->
                            <th scope="col">-</th>
                            <!--32 -->
                            <th scope="col">CAJAS</th>
                            <!--34 -->
                            <th scope="col">OBSER</th>
                            <!--35 -->
                            <th scope="col">DESCUENTO</th>
                            <!--36 -->
                            <th scope="col">PRS-FAC</th>
                            <!--37 -->
                            <th scope="col">FOLIO</th>
                            <!--38 -->
                            <th scope="col">MONDA</th>
                            <!--39 -->
                            <th scope="col">PAG</th>
                            <!--40 -->
                            <th scope="col">STS-CTRL</th>
                            <!--41 -->
                            <th scope="col">NO-IVA</th>
                            <!--42 -->
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5" align="right">
                <h3 style="color: #1976D2 !important;" class="font-weight-bold font-italic pares_totales_facturados"> 0 PARES</h3>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5" align="right">
                <h3 class="font-weight-bold text-danger font-italic">SUBTOTAL</h3>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2" align="right">
                <h3 class="font-weight-bold text-danger font-italic subtotalfacturadopie">$ 0.0</h3>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10" align="right">
                <h3 class="font-weight-bold text-danger font-italic">I.V.A</h3>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2" align="right">
                <h3 class="font-weight-bold text-danger font-italic totalivafacturadopie">$ 0.0</h3>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10" align="left">
                <h3 class="font-weight-bold text-danger font-italic totalfacturadoenletrapie">-</h3>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10" align="left">
                <h3 class="d-none font-weight-bold text-danger font-italic totalfacturadoenletrapieDLLS">-</h3>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2" align="right">
                <h3 class="font-weight-bold text-danger font-italic totalfacturadopie">$ 0.0</h3>
            </div>
        </div>
        <!--END CARD BLOCK-->
    </div>
</div>
<!--CONTROLES X FACTURAR-->
<div class="modal" id="mdlControlesXFacturar">
    <div class="modal-dialog modal-lg modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p class="font-italic font-weight-bold">
                    NOTA: Solo se muestran los registros con control y con estatus diferente a
                    <span class="font-weight-bold text-info">"FACTURADO"</span> y
                    <span class="font-weight-bold text-danger">"CANCELADO"</span>
                </p>
                <div class="row">
                    <div class="col-4">
                        <input type="text" id="bControl" name="bControl" class="form-control numbersOnly" maxlength="12" placeholder="Escriba aqui un control...">
                    </div>
                    <div class="col-4">
                        <input type="text" id="bPedido" name="bPedido" class="form-control numbersOnly" maxlength="20" placeholder="Escriba aqui un # de pedido...">
                    </div>
                    <div class="col-4">
                        <input type="text" id="bEstilo" name="bEstilo" class="form-control" maxlength="20" placeholder="Escriba aqui un estilo...">
                    </div>
                    <div class="col-12">
                        <table id="tblControlesXFacturar" class="table table-hover table-sm nowrap" style="width: 100% !important;">
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
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    CERRAR
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal " id="mdlConsignarA">
    <div class="modal-dialog modal-dialog-centered notdraggable" role="document">
        <div class="modal-content blinkb">
            <div class="modal-header">
                <h5 class="modal-title"><span class = "fa fa-store-alt"></span> Consignar a</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;">
                    <span aria-hidden="true">&times;
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <label>Tienda</label>
                        <input type="text" id="TiendaClave" name="TiendaClave" autofocus="" class="form-control form-control-sm" placeholder="CLAVE">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                        <select id="Tienda" name="Tienda" class="form-control form-control-sm mt-4 selectNotEnter">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="btnCerrarTiendaModal">
                    <span class="fa fa-save"></span> Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div id="mdlHistorialFacturas" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-file-invoice"></span> Historial de facturación</h5> 
            </div>
            <div class="modal-body">
                <div class="row"> 
                    <div class="col-3">
                        <input type="text" id="hFactura" name="hFactura" class="form-control numbersOnly" maxlength="12" placeholder="Escriba un # de factura...">
                    </div>
                    <div class="col-3">
                        <input type="text" id="hTP" name="hTP" class="form-control numbersOnly" maxlength="1" placeholder="Escriba un tp...">
                    </div>
                    <div class="col-3">
                        <input type="text" id="hCliente" name="hCliente" class="form-control numbersOnly" maxlength="12" placeholder="Escriba un # de cliente...">
                    </div>
                    <div class="col-3">
                        <input type="text" id="hControl" name="hControl" class="form-control numbersOnly" maxlength="15" placeholder="Escriba un # de control...">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12">
                        <table id="tblFacturas" class="table table-hover table-sm nowrap" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>FACTURA</th>
                                    <th>TP</th>
                                    <th>CLIENTE</th>
                                    <th>FECHA</th>
                                    <th>CONTROL</th>
                                    <th>ESTILO</th>
                                    <th>COLOR</th>
                                    <th>CORRIDA</th>
                                    <th>PARES</th>
                                    <th>PRECIO</th>
                                    <th>SUBTOTAL</th>
                                    <th>IVA</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="mdlFacturasXAnticipo">
    <div class="modal-dialog modal-lg modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Facturas con anticipos</h5> 
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <table id="tblFacturasXAnticipo" class="table table-hover table-sm nowrap" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>-</th>
                                    <th>CLIENTE</th>
                                    <th>FACTURA</th>
                                    <th>FECHA</th>
                                    <th>TP</th>   
                                    <th>TOTAL</th>
                                    <th>xTOTAL</th>
                                    <th>xCLIENTE</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="json_facturas d-none">-</span>
                <span class="font-weight-bold total_anticipado" style="font-size: 18px; color: #C62828;">$ 0.0</span>
                <button id="btnAceptaFacturasConAnticipo" type="button" class="btn btn-success"
                        style="background-color: #4CAF50; border-color:#4CAF50" data-dismiss="modal"><span class="fa fa-check"></span> ACEPTA</button> 
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
            ClienteClave = pnlTablero.find("#ClienteClave"),
            ClienteFactura = pnlTablero.find("#ClienteFactura"),
            AgenteCliente = pnlTablero.find("#AgenteCliente"),
            Tienda = pnlTablero.find("#Tienda"),
            FechaFactura = pnlTablero.find('#FechaFactura'),
            LPFactura = pnlTablero.find('#LPFactura'),
            TPFactura = pnlTablero.find('#TPFactura'),
            Documento = pnlTablero.find('#Documento'),
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
            chkConsignacion = pnlTablero.find("#chkConsignacion"),
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
            bControl = mdlControlesXFacturar.find("#bControl"),
            bPedido = mdlControlesXFacturar.find("#bPedido"),
            bEstilo = mdlControlesXFacturar.find("#bEstilo"),
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
            btnReimprimeDocto = pnlTablero.find("#btnReimprimeDocto"),
            btnElijeControl = pnlTablero.find("#btnElijeControl"),
            mdlConsignarA = $("#mdlConsignarA"), TiendaClave = mdlConsignarA.find("#TiendaClave"),
            ConsignarATienda = mdlConsignarA.find("#Tienda"),
            btnCerrarTiendaModal = mdlConsignarA.find("#btnCerrarTiendaModal"),
            btnNuevaFactura = pnlTablero.find("#btnNuevaFactura"),
            btnRefrescaRegistro = pnlTablero.find("#btnRefrescaRegistro"),
            btnAdendaCoppel = pnlTablero.find("#btnAdendaCoppel");
//            mdlAddendaCoppel = $("#mdlAddendaCoppel"), Tiendas,
//            tblTiendas = mdlAddendaCoppel.find("#tblTiendas"), AddendasCoppel,
//            tblAddendasCoppel = mdlAddendaCoppel.find("#tblAddendasCoppel"),
//            xTiendaCoppel = mdlAddendaCoppel.find("#xTiendaCoppel"),
//            FacturaCoppel = mdlAddendaCoppel.find("#FacturaCoppel");

    var mdlFacturasXAnticipo = $("#mdlFacturasXAnticipo"), FacturasXAnticipo,
            btnAceptaFacturasConAnticipo = mdlFacturasXAnticipo.find("#btnAceptaFacturasConAnticipo"),
            btnFacAnticipos = pnlTablero.find("#btnFacAnticipos"),
            tblFacturasXAnticipo = mdlFacturasXAnticipo.find("#tblFacturasXAnticipo"),
            json_facturas = [], btnAnticipoX = pnlTablero.find("#btnAnticipoX");

    $("button:not(.grouped):not(.navbar-brand)").addClass("my-1 btn-sm");
    pnlTablero.find("#tblTallasF").find("input").addClass("form-control-sm");
    pnlTablero.find("input,textarea").addClass("font-weight-bold");
    var nuevo = true; /* 1 = NUEVO, 2 = MODIFICANDO, 3 = CERRADO*/

    function onKeyDownOK(input, keyevt, fn) {
        if (keyevt.keyCode === 13) {
            fn();
        }
    }
    function onKeyDownValOK(input, keyevt, fn) {
        if (keyevt.keyCode === 13 && input.val()) {
            fn();
        }
    }

    $(document).ready(function () {
        handleEnterDiv(mdlConsignarA);

        btnAnticipoX.click(function () {
            $.post('<?php print base_url('FacturacionProduccion/onAnticiposTest') ?>', {
                ANTICIPOS: JSON.stringify(json_facturas)
            }).done(function (a) {

            }).fail(function () {

            });
        });

        btnAceptaFacturasConAnticipo.click(function () {
            onCalcularMontoXAnticipo();
        });

        btnFacAnticipos.click(function () {
            if (ClienteClave.val()) {
                mdlFacturasXAnticipo.modal('show');
            } else {
                onCampoInvalido(pnlTablero, "DEBE DE SELECCIONAR UN CLIENTE", function () {
                    ClienteClave.focus().select();
                });
            }
        });

        mdlFacturasXAnticipo.on('hide.bs.modal', function () {
            FacturasXAnticipo.search('').draw();
            mdlFacturasXAnticipo.find("input[type='search']").val('');
        });

        mdlFacturasXAnticipo.on('hidden.bs.modal', function () {
            onHabilitarPanel(pnlTablero);
            if (json_facturas.length > 0) {
                btnFacAnticipos.html('ANTICIPOS (' + json_facturas.length + ')');
            } else {
                btnFacAnticipos.text('ANTICIPOS');
            }
            PAGFactura.focus().select();
        });

        mdlFacturasXAnticipo.on('shown.bs.modal', function () {
            onDesabilitarPanel(pnlTablero);
            if ($.fn.DataTable.isDataTable('#tblFacturasXAnticipo')) {
                onOpenOverlay('');
                FacturasXAnticipo.ajax.reload(function () {
                    onCloseOverlay();
                });
                return;
            } else {
                FacturasXAnticipo = tblFacturasXAnticipo.DataTable({
                    dom: 'rtip', "ajax": {
                        "url": '<?php print base_url('FacturacionProduccion/getFacturasXAnticipo'); ?>',
                        "dataSrc": "",
                        "data": function (d) {
                            d.CLIENTE = ClienteFactura.val() ? ClienteFactura.val() : '';
                        }
                    },
                    "columns": [
                        {"data": "ID"},
                        {"data": "CHEK",
                            render: function (data, type, row) {
                                return '<input type="checkbox" class="form-control editor-active check_facturas_x_anticipo" style="height: 25px; cursor:pointer;" onclick="onCalcularMontoXAnticipo(this)">';
                                return data;
                            }},
                        {"data": "CLIENTE"},
                        {"data": "FACTURA"},
                        {"data": "FECHA"},
                        {"data": "TP"},
                        {"data": "TOTAL"},
                        {"data": "TOTAL_SIN_FORMATO"},
                        {"data": "CLAVE_CLIENTE"}
                    ],
                    "columnDefs": [
                        //ID
                        {
                            "targets": [0],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "targets": [7],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "targets": [8],
                            "visible": false,
                            "searchable": false
                        }],
                    language: lang,
                    select: false,
                    "autoWidth": true,
                    "colReorder": true,
                    "displayLength": 99999,
                    "bLengthChange": false,
                    "deferRender": true,
                    "scrollCollapse": false,
                    "bSort": true,
                    "scrollY": 250,
                    "scrollX": true,
                    responsive: false,
                    "aaSorting": [
                        [3, 'desc']/*ID*/
                    ],
                    drawCallback: function (settings) {
                        if (json_facturas.length > 0) {
                            console.log(FacturasXAnticipo.rows().data())
                            $.each(json_facturas, function (k, v) {
                                $.each(tblFacturasXAnticipo.find("tbody tr"), function (kk, vv) {
                                    var cell = $(vv).find("input.check_facturas_x_anticipo")[0];
                                    var data = FacturasXAnticipo.row(vv).data();
                                    console.log(v.ID, data.ID, v.FACTURA, data.FACTURA, v, data);
                                    if (v.ID === data.ID && v.FACTURA === data.FACTURA
                                            && v.CLAVE_CLIENTE === data.CLAVE_CLIENTE) {
                                        cell.checked = true;
                                    }
                                });
                            });
                        }
                    }
                });
                tblFacturasXAnticipo.on('click', 'tr', function () {
                    var checf = $(this).find("td input[type='checkbox']")[0];
                    if (checf.checked) {
                        checf.checked = false;
                    } else {
                        checf.checked = true;
                    }
                    onCalcularMontoXAnticipo();
                });
            }
        });
        TMNDAFactura.on('keydown', function (e) {
            if (e.keyCode === 13 && TMNDAFactura.val()) {
                $.getJSON('<?php print base_url('FacturacionProduccion/getTipoDeCambio'); ?>').done(function (abcde) {
                    if (abcde.length > 0) {
                        switch (parseInt(TMNDAFactura.val())) {
                            case 1:
                                TIPODECAMBIO.val(abcde[0].DOLAR);
                                pnlTablero.find("span.tipo_de_cambio").text(abcde[0].DOLAR);
                                break;
                            case 2:
                                TIPODECAMBIO.val(abcde[0].DOLAR);
                                pnlTablero.find("span.tipo_de_cambio").text(abcde[0].DOLAR);
                                break;
                            case 3:
                                TIPODECAMBIO.val(abcde[0].EURO);
                                pnlTablero.find("span.tipo_de_cambio").text(abcde[0].EURO);
                                break;
                        }
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    onCloseOverlay();
                });
            }
        });

        btnRefrescaRegistro.click(function () {
            $.getJSON('<?php print base_url('FacturacionProduccion/getRegistrosPreFacturados') ?>', {
                CLIENTE: ClienteFactura.val(),
                TP: TPFactura.val(),
                DOCUMENTO: Documento.val()
            }).done(function (a) {
                console.log(a);
            }).fail(function (x) {
                getError(x);
            });
        });

        $('.modal').on('show.bs.modal', function (e) {
            $('body').addClass("example-open");
        }).on('hide.bs.modal', function (e) {
            $('body').removeClass("example-open");
        });
        $('input.notdot').keydown(function (e) {
            console.log(e.keyCode);
            /*
             * 190 = dot .
             * 109 = minus -
             */
            if (e.keyCode === 110 || e.keyCode === 109) {
                e.preventDefault();
            }
        });
        btnNuevaFactura.click(function () {
            location.reload();
        });
        bControl.on('keydown', function (e) {
            if (e.keyCode === 13) {
                ControlesXFacturar.ajax.reload();
            }
        });
        bPedido.on('keydown', function (e) {
            if (e.keyCode === 13) {
                ControlesXFacturar.ajax.reload();
            }
        });
        bEstilo.on('keydown', function (e) {
            if (e.keyCode === 13) {
                ControlesXFacturar.ajax.reload();
            }
        });

        pnlTablero.find("#btnCambiaFolio").click(function () {
            onReadAndWrite(pnlTablero.find("#Documento"));
            pnlTablero.find("#Documento").focus().select();
        });

        ClienteFactura.change(function () {
            if (ClienteFactura.val()) {
                ClienteClave.val(ClienteFactura.val());
                ClienteFactura[0].selectize.disable();
                if (json_facturas.length > 0) {
                    $.each(json_facturas, function (k, v) {
                        console.log("CLIENTE ", ClienteClave.val(), v.CLAVE_CLIENTE);
                        if (ClienteClave.val() !== v.CLAVE_CLIENTE) {
                            json_facturas = [];
                            mdlFacturasXAnticipo.find("span.json_facturas").text('');
                            mdlFacturasXAnticipo.find("div.modal-footer").find("span.total_anticipado").text("$ " + $.number(0, 2, '.', ','));
                            return false;
                        }
                    });
                }
            } else {
                ClienteClave.val('');
                ClienteFactura[0].selectize.enable();
                ClienteFactura[0].selectize.clear(true);
            }
        });
        ClienteClave.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (ClienteClave.val()) {
                    ClienteFactura[0].selectize.setValue(ClienteClave.val());
                    if (ClienteFactura.val()) {
                        ClienteFactura[0].selectize.disable();
                    } else {
                        /*REVISA SI ESTA BLOQUEADO EN BLOQUEVTA*/
                        $.getJSON('<?php print base_url('FacturacionProduccion/onRevisarBloqueoDeVta'); ?>', {
                            CLIENTE: ClienteClave.val()
                        }).done(function (a) {
                            console.log(a, a.BLOQUEADO);
                            switch (parseInt(a.BLOQUEADO)) {
                                case 0:
                                    onCampoInvalido(pnlTablero, 'NO EXISTE ESTE CLIENTE, ESPECIFIQUE OTRO', function () {
                                        ClienteClave.focus().select();
                                    });
                                    break;
                                case 1:
                                    onCampoInvalido(pnlTablero, 'ESTE CLIENTE ESTA BLOQUEADO POR COBRANZA. UNA VEZ DESBLOQUEADO, ACTUALICE LA PÁGINA CON "F5".', function () {
                                        ClienteClave.focus().select();
                                    });
                                    break;
                            }
                        }).fail(function (x) {
                            getError(x);
                        }).always(function () {

                        });
                    }
                } else {
                    ClienteFactura[0].selectize.enable();
                    ClienteFactura[0].selectize.clear(true);
                }
            } else {
                ClienteFactura[0].selectize.enable();
                ClienteFactura[0].selectize.clear(true);
            }
        });
        TiendaClave.on('keydown', function (e) {
            if (e.keyCode === 13) {
                ConsignarATienda[0].selectize.setValue(TiendaClave.val());
                onDisable(ConsignarATienda);
            }
        });
        PrecioFacturacion.on('keydown keypress keyup focusout', function () {
            onRecalcularSubtotal();
        });
        mdlConsignarA.on('shown.bs.modal', function () {
            //            console.log(ConsignarATienda.val());
            if (TiendaClave.val() === '') {
                TiendaClave.focus().select();
            } else {
                TiendaClave.focus().select();
            }
        });
        btnCerrarTiendaModal.on('keydown', function (e) {
            if (e.keyCode === 13) {
                mdlConsignarA.modal('hide');
                btnVerTienda.removeClass("d-none");
                if (TPFactura.val()) {
                    PAGFactura.focus().select();
                } else {
                    TPFactura.focus().select();
                }
                onEnable(ConsignarATienda);
                handleEnterDiv(pnlTablero);
            }
        }).click(function () {
            mdlConsignarA.modal('hide');
            btnVerTienda.removeClass("d-none");
            TPFactura.focus().select();
            handleEnterDiv(pnlTablero);
        });
        btnNuevo.click(function () {
            onOpenOverlay('');
            onDisableInputs(false);
            onResetCampos();
            btnVistaPreviaF.attr('disabled', true);
            ParesFacturados.rows().remove().draw();
            pnlTablero.find(".ReferenciaFactura").text('-');
            pnlTablero.find(".subtotalfacturadopie").text('$0.0');
            pnlTablero.find(".totalivafacturadopie").text('$0.0');
            pnlTablero.find(".totalfacturadopie").text('$0.0');
            pnlTablero.find(".totalfacturadoenletrapie").text('-');
            pnlTablero.find(".totalfacturadoenletrapieDLLS").text('-');
            CajasFacturacion.attr('disabled', false);
            pnlTablero.find("input").val('');
            FechaFactura.val(Hoy);
            Documento.val('');
            ClienteFactura[0].selectize.clear(true);
            TPFactura.val('');
            LPFactura.val('');
            btnNuevo.attr('disabled', true);
            btnNuevo.addClass("d-none");
            ClienteClave.focus().select();
            btnVerTienda.addClass("d-none");
            onCloseOverlay();
        });
        mdlReimprimeDocto.on('hidden.bs.modal', function () {
            ClienteClave.focus().select();
        });
        btnReimprimeDocto.click(function () {
            $("#mdlReimprimeDocto").modal('show');
        });
        btnVistaPreviaF.click(function () {

            //            $.getJSON('<?php print base_url('FacturacionProduccion/onComprobarCFDI'); ?>', {
            //                DOCUMENTO_FACTURA: Documento.val().trim() !== '' ? Documento.val() : ''
            //            }).done(function (a) {
            //                if (a.length > 0) {
            if (ClienteFactura.val() && Documento.val() && TPFactura.val()) {
                getVistaPreviaDocumentoCerrado(function () {
                    ClienteClave.focus().select();
                });
            } else {
                onBeep(2);
                onCampoInvalido(pnlTablero, 'DEBE DE ESPECIFICAR UN CLIENTE, DOCUMENTO VÁLIDO Y UN TP', function () {
                    ClienteClave.focus().select();
                });
            }
            //                } else {
            //                    iMsg('ESTE DOCUMENTO NO TIENE UNA FACTURA ASOCIADA', 'w', function () {
            //                        Documento.focus().select();
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

        btnAcepta.click(function () {             /*REVISAR CANTIDAD FACTURADA*/

            switch (parseInt(TMNDAFactura.val())) {
                case '':
                case "":
                case 0: 
                    TMNDAFactura.val(1);
                    getTotalFacturado();
                    break;
            }

            if (Control.val() && ClienteClave.val()) {
                $.getJSON('<?php print base_url('FacturacionProduccion/getParesFacturadosPedidox'); ?>',
                        {
                            CLIENTE: ClienteClave.val(),
                            CONTROL: Control.val()
                        }).done(function (a) {
                    var r = a[0];
                    var pares_finales_a_facturar = parseFloat(r.PARES_FACTURADOS) + parseFloat(TotalParesEntregaAF.val());

                    pnlTablero.find(".produccionfacturados").text(r.PARES_FACTURADOS);
                    pnlTablero.find(".produccionsaldo").text(r.PARES - r.PARES_FACTURADOS);
                    TotalParesEntregaF.val(r.PARES_FACTURADOS);
                    var total_para_facturar = r.PARES - r.PARES_FACTURADOS;



                    TotalParesEntregaAF.val(total_para_facturar);

                    /* 36 ES MENOR QUE 40*/
                    if (parseInt(r.PARES) < pares_finales_a_facturar) {
                        onCampoInvalido(pnlTablero, 'NO SE PUEDEN FACTURAR MÁS PARES DE LOS ESTABLECIDOS, INGRESE UNA CANTIDAD MENOR', function () {
                            pnlTablero.find("#CAF1").focus().select();
                        });
                        return;
                    } else {

                        if (PrecioFacturacion.val() === '' || parseFloat(PrecioFacturacion.val()) < 0) {
                            onCampoInvalido(pnlTablero, "DEBE DE ESPECIFICAR UN PRECIO", function () {
                                PrecioFacturacion.focus().select();
                            });
                            return;
                        }
                        if (Control.val()) {

                            ClienteFactura[0].selectize.enable();
                            $.post('<?php print base_url('FacturacionProduccion/onComprobarFactura'); ?>',
                                    {CLIENTE: (ClienteFactura.val() ? ClienteFactura.val() : ''),
                                        FACTURA: Documento.val(),
                                        TP: TPFactura.val()
                                    }).done(function (a) {
                                if (parseInt(a[0].FACTURA_EXISTE) >= 1 && nuevo) {
                                    onCampoInvalido(pnlTablero, 'ESTA DOCUMENTO YA EXISTE, INTENTE CON OTRO', function () {
                                        Documento.focus().select();
                                    });
                                    return;
                                } else {
                                    /*ES UN NUEVO REGISTRO, PERO EL DOCUMENTO/FACTURA NO EXISTE*/
                                }
                            }).fail(function (x) {
                                getError(x);
                            }).always(function () {

                            });
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
                                    //                    console.log(pc, pf, paf, pf_mas_paf);
                                    //                    console.log('LA SUMA DE PARES DE CF' + i + ' + CAF' + i + ' NO CONCUERDAN CON C' + i + ', ESTA CANTIDAD YA SE CONCLUYO O COMPLETO');
                                    validos = false;
                                    break;
                                }
                            }
                            pares_finales = pares_facturados + pares_a_facturar;
                            if (pares_a_facturar > 0) {
                                TotalParesEntregaAF.val(pares_a_facturar);
                                console.log("son pares validos? => ", validos);
                                //                                if (pares_finales <= pares && validos) {
                                console.log('PARES OK');
                                onAceptarControl();
                                //                                } else {
                                //                                    onCampoInvalido(pnlTablero, 'NO SE PUEDEN FACTURAR MÁS PARES DE LOS ESTABLECIDOS, INGRESE UNA CANTIDAD MENOR', function () {
                                //                                        pnlTablero.find("#CAF1").focus().select();
                                //                                    });
                                //                                    return;
                                //                                }
                            } else {
                                onCampoInvalido(pnlTablero, 'ES NECESARIO ESPECIFICAR UNA CANTIDAD A FACTURAR MAYOR A CERO', function () {
                                    pnlTablero.find("#CAF1").focus().select();
                                });
                                return;
                            }
                        } else {
                            $(".swal-button--confirm").focus();
                            onCampoInvalido(pnlTablero, 'ES NECESARIO ESPECIFICAR UN CONTROL A FACTURAR', function () {
                                Control.focus().select();
                            });
                            $(".swal-button--confirm").focus();
                            return;
                        }
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    onCloseOverlay();
                });
            }

        });

        btnCierraDocto.click(function () {
            onBeep(1);
            pnlTablero.find("input,textarea").attr('disabled', false);
            $.each(pnlTablero.find("select:disabled"), function (k, v) {
                $(v)[0].selectize.enable();
            });
            if (ClienteFactura.val()) {
                nuevo = true;
                onOpenOverlay('Cerrando...');
                var p = {
                    FECHA: FechaFactura.val(), CLIENTE: ClienteFactura.val(),
                    TP_DOCTO: TPFactura.val(), FACTURA: Documento.val(),
                    MONEDA: TMNDAFactura.val(), CAJAS: CajasFacturacion.val(),
                    IMPORTE_TOTAL_SIN_IVA: SubtotalFacturacion.val(),
                    IMPORTE_TOTAL_CON_IVA: SubtotalFacturacionIVA.val(),
                    TIPO_DE_CAMBIO: TIPODECAMBIO.val(),
                    REFACTURACION: (xRefacturacion[0].cheked ? 1 : 0),
                    TOTAL_EN_LETRA: TotalLetra.find("span").text(),
                    REFERENCIA: ReferenciaFacturacion.val(),
                    CONSIGNACION: chkConsignacion[0].checked ? 1 : 0,
                    ANTICIPOS: JSON.stringify(json_facturas)
                };
                $.post('<?php print base_url('FacturacionProduccion/onCerrarDocto') ?>', p).done(function (abc) {
                    btnCierraDocto.attr('disabled', true);
                    btnAcepta.attr('disabled', true);
                    onNotifyOldPCE('', 'SE HA CERRADO EL DOCUMENTO', 'info', "top", "center");
                    ClienteFactura[0].selectize.enable();
                    Documento.attr('readonly', false);
                    TPFactura.attr('disabled', false);
                    onCloseOverlay();
                    getVistaPreviaDocumentoCerrado(function () {
                        iMsg("SE HA CERRADO EL DOCUMENTO", "s", function () {
                            nuevo = true;
                            pnlTablero.find("input").val('');
                            $.each(pnlTablero.find("select"), function (k, v) {
                                pnlTablero.find("select")[k].selectize.clear(true);
                            });
                            ParesFacturados.rows().remove().draw(false);
                            pnlTablero.find(".subtotalfacturadopie").text('$' + $.number(0, 2, '.', ','));
                            pnlTablero.find(".totalivafacturadopie").text('$' + $.number(0, 2, '.', ','));
                            pnlTablero.find(".totalfacturadohead").text('$' + $.number(0, 2, '.', ','));
                            pnlTablero.find(".totalfacturadopie").text('$' + $.number(0, 2, '.', ','));
                            TotalLetra.find("span").text('');
                            pnlTablero.find(".totalfacturadoenletrapie").text('');
                            pnlTablero.find(".totalfacturadoenletrapieDLLS").text('');
                            btnCierraDocto.attr('disabled', true);
                            btnFacturaXAnticipoDeProducto.attr('disabled', false);
                            btnControlInCompleto.attr('disabled', true);
                            btnControlCompleto.attr('disabled', true);
                            btnVistaPreviaF.attr('disabled', true);
                            FechaFactura.attr('readonly', false);
                            Documento.attr('readonly', false);
                            FCAFactura.attr('readonly', false);
                            PAGFactura.attr('readonly', false);
                            TMNDAFactura.attr('readonly', false);
                            ClienteFactura[0].selectize.enable();
                            TPFactura.attr('disabled', false);
                            ClienteClave.focus().select();
                            FechaFactura.val(Hoy);
                            ClienteClave.focus().select();
                            chkConsignacion[0].checked = false;
                            onReadOnly(pnlTablero.find("#Documento"));
                        });
                    });
                }).fail(function (x) {
                    onCloseOverlay();
                    getError(x);
                }).always(function () {
                });
            } else {
                onCampoInvalido(pnlTablero, 'LOS SIGUIENTES CAMPOS SON REQUERIDOS', function () {
                    ClienteClave.focus().select();
                });
                return;
            }
        });

        Documento.on('keydown', function (e) {
            if (e.keyCode === 13) {
                $.post('<?php print base_url('FacturacionProduccion/onComprobarFactura'); ?>',
                        {CLIENTE: (ClienteFactura.val() ? ClienteFactura.val() : ''),
                            FACTURA: Documento.val(),
                            TP: TPFactura.val()
                        }).done(function (a) {
                    //                        console.log("COMPROBANDO FACTURA => ", a, ClienteFactura.val(), a[0].CLIENTE);
                    console.log(a, JSON.parse(a), a[0], a[0].CLIENTE, a.CLIENTE);
                    var r = JSON.parse(a);
                    if (parseInt(r.FACTURA_EXISTE) === 2) {
                        btnAcepta.attr('disabled', false);
                        btnVistaPreviaF.attr('disabled', true);
                        CajasFacturacion.attr('disabled', false);
                        onCloseOverlay();
                        return;
                    }
                    console.log(parseInt(ClienteFactura.val()) === r.CLIENTE, r);
                    if (parseInt(ClienteFactura.val()) === parseInt(r.CLIENTE)) {
                        onOpenOverlay('Espere...');
                        $.getJSON('<?php print base_url('FacturacionProduccion/getFacturaXFolio'); ?>',
                                {
                                    CLIENTE: ClienteFactura.val(),
                                    FACTURA: Documento.val(),
                                    TP: TPFactura.val()
                                }).done(function (a) {
                            onCloseOverlay();
                            if (a.length > 0) {
                                /*DATOS DEL ENCABEZADO*/
                                FechaFactura.val(a[0].FECHA_FACTURA);
                                TMNDAFactura.val(a[0].TIPO_MONEDA);
                                var r = a[0];
                                switch (parseInt(r.EXISTE_CARTCLIENTE)) {
                                    case 1:
                                        onNotifyOld('', 'ESTE DOCUMENTO SE ENCUENTRA "' + a[0].ESTATUS_PRODUCCION + '" PERO NO ESTA CERRADA.', 'info');
                                        onEnable(btnCierraDocto);
                                        onEnable(btnVistaPreviaF);
                                        onEnable(btnAcepta);
                                        onEnable(CajasFacturacion);
                                        onEnable(Control);
                                        onEnable(btnElijeControl);
                                        onEnable(btnAcepta);
                                        onReadOnly(Documento);
                                        onDisable(ClienteFactura);
                                        onDisable(TPFactura);
                                        onDisable(pnlTablero.find("#btnNuevo"));
                                        pnlTablero.find("#btnNuevo").addClass("d-none");
                                        Control.focus().select();
                                        nuevo = false;
                                        break;
                                    case 2:
                                        onNotifyOld('', 'ESTE DOCUMENTO YA ESTA CERRADO.', 'info');
                                        btnVistaPreviaF.attr('disabled', false);
                                        btnAcepta.attr('disabled', true);
                                        CajasFacturacion.attr('disabled', true);
                                        onDisableInputs(true);
                                        onDisable(btnCierraDocto);
                                        onReadOnly(Documento);
                                        pnlTablero.find("#btnNuevo").removeClass("d-none");
                                        pnlTablero.find("#btnNuevo").attr("disabled", false);
                                        Control.attr('disabled', true);
                                        btnElijeControl.attr('disabled', true);
                                        ClienteFactura[0].selectize.disable();
                                        TPFactura.attr('disabled', true);
                                        btnElijeControl.addClass("d-none");
                                        btnAcepta.addClass("d-none");
                                        break;
                                }

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
                                    //                                            if (v.ESTATUS_PRODUCCION === 'FACTURADO' && !facturado) {
                                    //                                                facturado = true;
                                    //                                            }
                                });
                                ParesFacturados.rows.add(r).draw(false);
                                $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
                                onCloseOverlay();
                                getTotalFacturado();
                            } else {
                                pnlTablero.find("#btnNuevo").addClass("d-none");
                                pnlTablero.find("#btnNuevo").attr("disabled", true);
                            }
                        }).fail(function (x) {
                            onCloseOverlay();
                            getError(x);
                        }).always(function () {
                        });
                    } else {
                        onCampoInvalido(pnlTablero, 'ESTA FACTURA NO PERTENECE A ESTE CLIENTE', function () {
                            ClienteClave.focus().select();
                        });
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
                    /*SUMAR TODO EL SALDO*/
                    for (var i = 1; i < 21; i++) {
                        var pares = pnlTablero.find(`#C${i}`),
                                pares_facturados = pnlTablero.find(`#CF${i}`),
                                pares_a_facturar = pnlTablero.find(`#CAF${i}`);
                        var pares_disponibles_para_facturar = parseInt(pares.val()) - parseInt(pares_facturados.val() ? pares_facturados.val() : 0);
                        if (pares_disponibles_para_facturar >= 1) {
                            var x = pnlTablero.find(`#C${i}`).val();
                            var xx = pnlTablero.find(`#CF${i}`).val() ? pnlTablero.find(`#CF${i}`).val() : 0;
                            if (parseFloat(x) > 0) {
                                pnlTablero.find("#CAF" + i).val(x - xx);
                            } else {
                                pnlTablero.find("#CAF" + i).val('');
                            }

                            if (parseFloat(pares.val()) > 0) {
                                onEnable(pares_a_facturar);
                            } else {
                                onDisable(pares_a_facturar);
                            }
                        } else {
                            onDisable(pares_a_facturar);
                        }
                    }
                    var saldo_pares = 0;
                    for (var i = 1; i < 21; i++) {
                        var x = pnlTablero.find(`#CF${i}`);
                        saldo_pares += $.isNumeric(x) ? parseInt(x) : 0;
                    }
                    if (saldo_pares <= 0) {
                        CajasFacturacion.focus().select();
                        return;
                    }
                    pnlTablero.find("#CAF1").focus().select();
                } else {
                    swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CONTROL', 'warning').then((value) => {
                        Control.focus().select();
                    });
                }
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CLIENTE', 'warning').then((value) => {
                    ClienteClave.focus().select();
                });
            }
        });

        btnControlInCompleto.click(function () {
            onBeep(1);
            if (ClienteFactura.val()) {
                if (Control.val()) {
                    for (var i = 1; i < 23; i++) {
                        pnlTablero.find("#CAF" + i).val('');
                    }

                    for (var i = 1; i < 23; i++) {
                        var pares = pnlTablero.find(`#C${i}`),
                                pares_a_facturar = pnlTablero.find(`#CAF${i}`);
                        if (parseFloat(pares.val()) > 0) {
                            onEnable(pares_a_facturar);
                        } else {
                            onDisable(pares_a_facturar);
                        }
                    }
                    pnlTablero.find("input[id^='CAF']:not(:disabled):eq(0)").focus().select();
                    onNotifyOldPCE('', 'POR FAVOR ESPECIFIQUE LAS CANTIDADES', 'info', "bottom", "center");
                } else {
                    swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CONTROL', 'warning').then((value) => {
                        Control.focus().select();
                    });
                }
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CLIENTE', 'warning').then((value) => {
                    ClienteClave.focus().select();
                });
            }
        });
        mdlControlesXFacturar.on('shown.bs.modal', function () {
            $.fn.dataTable.ext.errMode = 'throw';
            if (!$.fn.DataTable.isDataTable('#tblControlesXFacturar')) {
                if (ClienteFactura.val()) {
                    ControlesXFacturar = tblControlesXFacturar.DataTable({
                        dom: 'rtip', "ajax": {
                            "url": '<?php print base_url('FacturacionProduccion/getPedidosXFacturar'); ?>',
                            "dataSrc": "",
                            "data": function (d) {
                                d.CLIENTE = ClienteFactura.val();
                                d.CONTROL = bControl.val() ? bControl.val() : '';
                                d.PEDIDO = bPedido.val() ? bPedido.val() : '';
                                d.ESTILO = bEstilo.val() ? bEstilo.val() : '';
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
                        "displayLength": 50,
                        "bLengthChange": false,
                        "deferRender": true,
                        "scrollCollapse": false,
                        "bSort": true,
                        "scrollY": 300,
                        "scrollX": true,
                        responsive: false,
                        "aaSorting": [
                            [4, 'desc']/*ID*/
                        ],
                        initComplete: function () {
                            mdlControlesXFacturar.find("#bControl").focus().select();
                        }
                    });
                    tblControlesXFacturar.on('click', 'tr', function () {
                        onOpenOverlay('Por favor espere...');
                        var xxx = ControlesXFacturar.row($(this)).data();
                        console.log("TR XXX = ", xxx);
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
                } else {
                    swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CLIENTE', 'warning').then((value) => {
                        ClienteClave.focus().select();
                    });
                }
            } else if ($.fn.DataTable.isDataTable('#tblControlesXFacturar')) {
                ControlesXFacturar.ajax.reload(function () {
                    mdlControlesXFacturar.find("#bControl").focus().select();
                });
            }
        });
        btnControlesXFac.click(function () {
            onBeep(1);
            if (ClienteFactura.val()) {
                mdlControlesXFacturar.modal({keyboard: false});
            } else {
                swal('ATENCION', 'DEBE DE ESPECIFICAR UN CLIENTE', 'warning').then((value) => {
                    ClienteClave.focus().select();
                });
            }
        });
        btnClientes.click(function () {
            onBeep(1);
            onOpenWindow('<?php print base_url('Clientes'); ?>');
        });

        Control.on('keydown', function (e) {

            $.post('<?php print base_url('FacturacionProduccion/onComprobarFactura'); ?>',
                    {CLIENTE: (ClienteFactura.val() ? ClienteFactura.val() : ''),
                        FACTURA: Documento.val(),
                        TP: TPFactura.val()
                    }).done(function (a) {
                //                        console.log("COMPROBANDO FACTURA => ", a, ClienteFactura.val(), a[0].CLIENTE);
                console.log(a, JSON.parse(a), a[0], a[0].CLIENTE, a.CLIENTE);
                var r = JSON.parse(a);
                if (parseInt(r.FACTURA_EXISTE) === 2) {
                    btnAcepta.attr('disabled', false);
                    btnVistaPreviaF.attr('disabled', true);
                    CajasFacturacion.attr('disabled', false);
                    onCloseOverlay();
                    return;
                }
            }).fail(function (x) {
                getError(x);
            }).always(function () {

            });
            if (TPFactura.val()) {
                if (ClienteFactura.val()) {
                    if (Control.val() && e.keyCode === 13) {
                        onOpenOverlay('Buscando...');
                        getInfoXControl();
                    }
                } else {
                    swal('ATENCION', 'DEBE DE ESPECIFICAR UN CLIENTE', 'warning').then((value) => {
                        ClienteClave.focus().select();
                    });
                    $(".swal-button--confirm").focus();
                }
            } else {
                $(".swal-button--confirm").focus();
                swal('ATENCION', 'DEBE DE ESPECIFICAR UN TIPO DE DOCUMENTO 1 O 2', 'warning').then((value) => {
                    TPFactura.focus().select();
                });
                $(".swal-button--confirm").focus();
            }
        });

        FechaFactura.val(Hoy);
        ClienteClave.focus().select();
        handleEnterDiv(pnlTablero);
        TPFactura.keydown(function (e) {
            if (ClienteClave.val()) {
                if (e.keyCode === 13 && parseInt(TPFactura.val()) >= 1 && parseInt(TPFactura.val()) <= 2) {
                    getTipoDeCambioYUltimaFactura();
                    onComprobarFacturasXAnticipo();
                } else if (e.keyCode === 13) {
                    TPFactura.focus().select();
                    onCampoInvalido(pnlTablero, "SOLO SE PERMITE 1 Y 2", function () {
                        TPFactura.focus().select();
                    });
                    return;
                }
            } else {
                onCampoInvalido(pnlTablero, "DEBE DE ESPECIFICAR UN CLIENTE", function () {
                    ClienteClave.focus().select();
                });
                return;
            }
        }).focusout(function () {
            if (ClienteClave.val()) {
                if (parseInt(TPFactura.val()) >= 1 && parseInt(TPFactura.val()) <= 2) {
                    getTipoDeCambioYUltimaFactura();
                    onComprobarFacturasXAnticipo();
                } else {
                    TPFactura.focus().select();
                    return;
                }
            } else {
                onCampoInvalido(pnlTablero, "DEBE DE ESPECIFICAR UN CLIENTE", function () {
                    ClienteClave.focus().select();
                });
                return;
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
                    TPFactura.focus().select();
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
            dom: 'rt',
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
                }], language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 9999,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": 250,
            "scrollX": true,
            initComplete: function () {
                onCloseOverlay();
            }, "drawCallback": function (settings) {
                var api = this.api();
                var prs = 0;
                console.log(api.rows().data());
                $.each(api.rows().data(), function (k, v) {
                    prs = prs + parseInt(v[5]);
                });
                //                mdlRastreoXControl.find(".total_pesos").text("$ " + r.toFixed(3));
                pnlTablero.find("h3.pares_totales_facturados").text(prs + ' PARES');
            }
        });
    }
    );

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
        if (Control.val() && ClienteFactura.val()) {
            getFacturacionDiff();
            $.getJSON('<?php print base_url('FacturacionProduccion/getParesFacturadosPedidox'); ?>',
                    {
                        CLIENTE: ClienteFactura.val(),
                        CONTROL: Control.val()
                    }).done(function (a) {
                if (a.length > 0) {
                    var r = a[0];
                    pnlTablero.find(".produccionfabricados").text(r.PARES);
                    pnlTablero.find(".produccionfacturados").text(r.PARES_FACTURADOS);
                    pnlTablero.find(".produccionsaldo").text(r.PARES - r.PARES_FACTURADOS);
                    var xrow = pnlTablero.find("#tblTallasF tr#rCantidades:eq(1)").find("td");
                    xrow.eq(1).find("input").val(0);
                    xrow.eq(2).find("input").val(0);
                    xrow.eq(3).find("input").val(0);
                    xrow.eq(4).find("input").val(0);
                    xrow.eq(5).find("input").val(0);
                    xrow.eq(6).find("input").val(0);
                    xrow.eq(7).find("input").val(0);
                    xrow.eq(8).find("input").val(0);
                    xrow.eq(9).find("input").val(0);
                    xrow.eq(10).find("input").val(0);
                    xrow.eq(11).find("input").val(0);
                    xrow.eq(12).find("input").val(0);
                    xrow.eq(13).find("input").val(0);
                    xrow.eq(14).find("input").val(0);
                    xrow.eq(15).find("input").val(0);
                    xrow.eq(16).find("input").val(0);
                    xrow.eq(17).find("input").val(0);
                    xrow.eq(18).find("input").val(0);
                    xrow.eq(19).find("input").val(0);
                    xrow.eq(20).find("input").val(0);
                    xrow.eq(21).find("input").val(0);
                    xrow.eq(22).find("input").val(0);
                    var index = 1;
                    $.each(pnlTablero.find("#tblTallasF tr#rCantidades:eq(0) td"), function (k, v) {
                        //                    console.log(v, $(v).index());
                        if ($(v).find("input").val() === '') {
                            onDisable(pnlTablero.find("#tblTallasF tr#rCantidades:eq(2) td:eq(" + $(v).index() + ") input"));
                        }
                    });
                }
            }).fail(function (x) {
                getError(x);
            }).always(function () {

            });
        }
    }

    function onVerTienda() {
        //        $("#ConsignarATienda").toggleClass("d-none");
        //        btnVerTienda.removeClass('d-none');
        pnlTablero.off("keydown");
        //        onoffhandle = !onoffhandle;
        //        Tienda[0].selectize.focus();

        mdlConsignarA.modal('show');
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
        $.getJSON('<?php print base_url('FacturacionProduccion/getParesFacturadosPedidox'); ?>',
                {
                    CLIENTE: ClienteClave.val(),
                    CONTROL: Control.val()
                }).done(function (a) {
            if (a.length > 0) {
                var r = a[0];
                pnlTablero.find(".produccionfacturados").text(r.PARES_FACTURADOS);
                pnlTablero.find(".produccionsaldo").text(ttp - r.PARES_FACTURADOS);
                TotalParesEntregaF.val(r.PARES_FACTURADOS);
                var total_para_facturar = r.PARES - r.PARES_FACTURADOS;
                TotalParesEntregaAF.val(ttpaf);
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
        });
    }

    function getReferencia() {
        var txtreferen11 = "000000000000398827";
        txtreferen11 = padLeft(ClienteFactura.val(), 14) + '' + padLeft(Documento.val(), 4);
        var num1 = 0, num2 = 0, num3 = 0, num4 = 0, num5 = 0,
                num6 = 0, num7 = 0, num8 = 0, num9 = 0,
                num10 = 0, num11 = 0, num12 = 0, num13 = 0,
                num14 = 0, num15 = 0, num16 = 0, num17 = 0, num18 = 0,
                num19 = 313, num20 = 802, txtreferen2 = 0, txtreferen3 = 0, txtreferen4 = 0, txtreferen9 = 0, txtreferen10 = 0;
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

        txtreferen3 = num1 + num2 + num3 + num4 + num5 + num6 + num7 + num8 + num9 + num10 + num11 + num12 + num13 + num14 + num15 + num16 + num17 + num18 + num19 + num20;
        var res = 0, res1 = 0, res2 = 0, res3 = 0;
        //        console.log("txtreferen3 => " + txtreferen3);
        txtreferen4 = txtreferen3 / 97;
        //        console.log("txtreferen4 => " + txtreferen4, "txtreferen4 res =>" + (txtreferen4 % 1), "txtreferen4 - res=>" + (txtreferen4 - (txtreferen4 % 1)));         res = (txtreferen4 % 1);         res1 = res * 100;
        res2 = res1 % 1;
        res3 = res1 - res2;
        //        console.log("res => " + res, "res1=>" + res1, "res2=>" + res2, "res3=>" + res3);

        var ponderador_fijo = 99;
        if (res3 > 0) {
            txtreferen10 = ponderador_fijo - res3 + 1;
        } else {
            txtreferen10 = ponderador_fijo - res3;
        }
        //        console.log("txtreferen10 => " + txtreferen10);
        pnlTablero.find(".ReferenciaFactura").text(txtreferen11 + "" + txtreferen10);
        ReferenciaFacturacion.val(txtreferen11 + "" + txtreferen10);
    }

    function iMsg(msg, t, f) {
        swal('ATENCIÓN', msg, (t === 's' ? 'success' : (t === 'i' ? 'info' : (t === 'w' ? 'warning' : 'error')))).then(function () {
            f();
        });
    }
    var control_pertenece_a_cliente = false;
    function getFacturacionDiff() {
        if (Control.val()) {
            onOpenOverlay('Cargando...');
            $.getJSON('<?php print base_url('FacturacionProduccion/getParesFabricadosFacturadosSaldo'); ?>',
                    {
                        CONTROL: Control.val()
                    }).done(function (a) {
                if (a.length > 0) {
                    var r = a[0];
                    pnlTablero.find(".produccionfabricados").text(r.PARES);
                    pnlTablero.find(".produccionfacturados").text(r.PARES_FACTURADOS);
                    pnlTablero.find(".produccionsaldo").text(r.PARES - r.PARES_FACTURADOS);
                }
            });
            $.getJSON('<?php print base_url('FacturacionProduccion/onComprobarControlXCliente'); ?>', {
                CONTROL: Control.val() ? Control.val() : '',
                CLIENTE: ClienteClave.val() ? ClienteClave.val() : ''
            }).done(function (abcd) {
                control_pertenece_a_cliente = true;
                $.getJSON('<?php print base_url('FacturacionProduccion/getFacturacionDiff'); ?>', {
                    CONTROL: Control.val() ? Control.val() : ''
                }).done(function (aa) {
                    var abc = aa[0];
                    if (abc !== undefined) {
                        if (control_pertenece_a_cliente) {
                            for (var i = 1; i < 23; i++) {
                                var ccc = 0;
                                if (i < 10) {
                                    ccc = parseInt(abc[`par0${i}`]) > 0 ? abc[`par0${i}`] : "";
                                    pnlTablero.find(`#CF${i}`).val(ccc);
                                } else {
                                    ccc = parseInt(abc[`par${i}`]) > 0 ? abc[`par${i}`] : "";
                                    pnlTablero.find(`#CF${i}`).val(ccc);
                                }
                            }
                        }
                    }
                    if (control_pertenece_a_cliente) {
                        $.getJSON('<?php print base_url('FacturacionProduccion/getInfoXControl'); ?>', {
                            CLIENTE: ClienteClave.val(),
                            CONTROL: Control.val()
                        }).done(function (a) {
                            if (a.length > 0) {
                                var xx = a[0];
                                Corrida.val(xx.Serie);
                                var t = 0;
                                for (var i = 1; i < 23; i++) {
                                    if (parseInt(xx["T" + i]) > 0) {
                                        pnlTablero.find("#T" + i).val(xx["T" + i]);
                                        pnlTablero.find("span.T" + i).text(xx["T" + i]);
                                        pnlTablero.find("#T" + i).attr("title", xx["T" + i]);
                                        pnlTablero.find("#T" + i).attr("data-original-title", xx["T" + i]);
                                        pnlTablero.find(`#C${i}`).val(parseFloat(xx["C" + i]) > 0 ? xx["C" + i] : "");
                                        var cf = (parseInt(pnlTablero.find("#CF" + i).val()) > 0 ? parseInt(pnlTablero.find("#CF" + i).val()) : 0);
                                        pnlTablero.find("#CAF" + i).val((parseFloat(xx["C" + i]) > 0 ? parseInt(xx["C" + i]) - cf : ""));
                                        pnlTablero.find("#C" + i).attr("title", xx["C" + i]);
                                        pnlTablero.find("#C" + i).attr("data-original-title", xx["C" + i]);
                                        t += parseInt(xx["C" + i]);
                                        TotalParesEntrega.val(t);
                                        TotalParesEntregaAF.val(t);
                                        var pares = pnlTablero.find(`#C${i}`),
                                                pares_a_facturar = pnlTablero.find(`#CAF${i}`);
                                        if (parseFloat(pares.val()) > 0) {
                                            onEnable(pares_a_facturar);
                                        } else {
                                            onDisable(pares_a_facturar);
                                        }
                                    }
                                }
                                getTotalPares();
                                /*OBTENER CODIGO DEL SAT X ESTILO*/
                                FolioFactura.val(xx.CLAVE_PEDIDO);
                                CorridaFacturacion.val(xx.SERIET);
                                EstiloFacturacion.val(xx.ESTILOT);
                                EstiloTFacturacion.val(xx.ESTILO_TEXT);
                                ColorFacturacion.val(xx.COLORT);
                                ColorClaveFacturacion.val(xx.COLOR_CLAVE);
                                PrecioFacturacion.val(xx.PRECIO);
                                CajasFacturacion.val(1);
                                CajasFacturacion.focus().select();
                                onObtenerCodigoSatXEstilo();
                                var prs = parseFloat(TotalParesEntregaAF.val() ? TotalParesEntregaAF.val() : 0);
                                var stt = parseFloat(xx.Precio) * prs;
                                SubtotalFacturacion.val(stt);
                                switch (parseInt(TMNDAFactura.val())) {
                                    case 0:
                                    case 1:
                                        switch (parseInt(TPFactura.val())) {
                                            case 0:
                                            case 1:
                                                SubtotalFacturacionIVA.val(stt * 0.16);
                                                TotalLetra.find("span").text(NumeroALetras(stt * 0.16));
                                                break;
                                            case 2:
                                                SubtotalFacturacionIVA.val(stt);
                                                TotalLetra.find("span").text(NumeroALetras(stt));
                                                break;
                                        }
                                        break;
                                    case 2:
                                        SubtotalFacturacionIVA.val(0);
                                        TotalLetra.find("span").text(NumeroALetras(stt));
                                        break;
                                }
                                //                                        pnlTablero.find(".totalfacturadoenletrapie").text(NumeroALetras(stt));

                                pnlTablero.find("#cCST")[0].checked = (xx.ESTATUS === 'PRODUCTO TERMINADO');
                                EstatusControl.val(xx.ESTATUS);
                                btnFacturaXAnticipoDeProducto.attr('disabled', false);
                                btnControlInCompleto.attr('disabled', false);
                                btnControlCompleto.attr('disabled', false);
                                onEnable(btnAcepta);
                            } else {
                                onDisable(btnAcepta);
                                Control.focus().select();
                                btnFacturaXAnticipoDeProducto.attr('disabled', true);
                                btnControlInCompleto.attr('disabled', true);
                                btnControlCompleto.attr('disabled', true);
                                onNotifyOldPCE('', 'EL CONTROL AUN NO ESTA TERMINADO O YA ESTA FACTURADO COMPLETAMENTE.', 'info', "bottom", "center");
                                onCampoInvalido(pnlTablero, ' * EL CONTROL AÚN NO ESTÁ TERMINADO O YA ESTA FACTURADO COMPLETAMENTE. * ', function () {

                                    Control.focus().select();
                                    btnFacturaXAnticipoDeProducto.attr('disabled', true);
                                    btnControlInCompleto.attr('disabled', true);
                                    btnControlCompleto.attr('disabled', true);
                                });
                                return;
                            }
                        }).fail(function (x) {
                            getError(x);
                        }).always(function () {
                            onCloseOverlay();
                        });
                    } else {
                        onResetCampos();
                        onCampoInvalido(pnlTablero, ' * ESTE CONTROL NO PERTENECE A ESTE CLIENTE * ', function () {
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
        switch (parseInt(TMNDAFactura.val())) {
            case 1: 
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
                break;
            case 2:
                var total_en_letras = NumeroALetras(t);
                total_en_letras = total_en_letras.replace("PESOS", "DÓLARES");
                total_en_letras = total_en_letras.replace("MXN", "DLL");
                pnlTablero.find(".totalfacturadohead").text('$' + $.number(parseFloat(t), 2, '.', ','));
                pnlTablero.find(".totalfacturadopie").text('$' + $.number(parseFloat(t), 2, '.', ','));
                TotalLetra.find("span").text(total_en_letras);
                pnlTablero.find(".totalfacturadoenletrapie").text(total_en_letras);
                pnlTablero.find(".totalfacturadoenletrapieDLLS").text(total_en_letras);
                break;
        }
    }
    function onRecalcularSubtotal() {
        var pares = 0;
        for (var i = 1; i < 23; i++) {
            pares += parseInt(getValor('#CAF' + i));
        }
        SubtotalFacturacion.val(pares * PrecioFacturacion.val());
        getTotalFacturado();
    }

    function onObtenerCodigoSatXEstilo() {
        /*OBTENER CODIGO DEL SAT X ESTILO*/
        $.getJSON('<?php print base_url('FacturacionProduccion/onObtenerCodigoSatXEstilo'); ?>', {ESTILO: EstiloFacturacion.val()}).done(function (abcd) {
            CodigoSat.val(abcd[0].CPS);

        }).always(function () {
        });
    }

    function onAceptarControl() {
        onBeep(1);
        onOpenOverlay('Guardando...');
        onRecalcularSubtotal();
        onObtenerCodigoSatXEstilo();
        var a = '<div class="row"><div class="col-12 text-danger text-nowrap talla font-weight-bold" align="center">';
        var b = '</div><div class="col-12 cantidad" align="center">';
        var c = '</div></div>';

        var total_pares_a_facturar = 0;
        for (var i = 1; i < 23; i++) {
            total_pares_a_facturar += parseInt(($.isNumeric(pnlTablero.find("#CAF" + i).val()) ? parseInt(pnlTablero.find("#CAF" + i).val()) : 0));
            TotalParesEntregaAF.val(total_pares_a_facturar);
        }
        var rowx = [
            123456789010, Documento.val(), ClienteFactura.val(), Control.val(), FechaFactura.val(),
            TotalParesEntregaAF.val()];
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
        rowx.push(Documento.val());
        rowx.push(TMNDAFactura.val());
        rowx.push(PAGFactura.val());
        rowx.push(EstatusControl.val());
        rowx.push((pnlTablero.find("#cNoIva")[0].checked ? 1 : 0));
        ParesFacturados.row.add(rowx).draw(false);
        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
        getTotalFacturado();
        TPFactura.attr('disabled', false);
        ClienteFactura[0].selectize.enable();
        var total_pares_a_facturar = 0;
        for (var i = 1; i < 23; i++) {
            total_pares_a_facturar += parseInt(($.isNumeric(pnlTablero.find("#CAF" + i).val()) ? parseInt(pnlTablero.find("#CAF" + i).val()) : 0));
            TotalParesEntregaAF.val(total_pares_a_facturar);
        }
        var p = {
            FECHA: FechaFactura.val(),
            CLIENTE: ClienteFactura.val(),
            AGENTE: AgenteCliente.val(),
            TP_DOCTO: TPFactura.val(),
            FOLIO: FolioFactura.val(),
            FACTURA: Documento.val(),
            CONTROL: Control.val(),
            SERIE: CorridaFacturacion.val(),
            ESTILO: EstiloFacturacion.val(),
            ESTILOT: EstiloTFacturacion.val(),
            CODIGO_SAT: CodigoSat.val(),
            COLOR: ColorClaveFacturacion.val(),
            PARES: TotalParesEntrega.val(),
            PARES_FACTURADOS: TotalParesEntregaF.val(),
            PARES_A_FACTURAR: TotalParesEntregaAF.val(),
            TIENDA: ConsignarATienda.val() ? ConsignarATienda.val() : ''
        };
        //        console.log("PARAMETROS 1: ", p);
        for (var i = 1; i < 23; i++) {
            p["C" + i] = ($.isNumeric(pnlTablero.find("#C" + i).val()) ? parseInt(pnlTablero.find("#C" + i).val()) : 0);
            p["CF" + i] = ($.isNumeric(pnlTablero.find("#CF" + i).val()) ? parseInt(pnlTablero.find("#CF" + i).val()) : 0);
            p["CAF" + i] = ($.isNumeric(pnlTablero.find("#CAF" + i).val()) ? parseInt(pnlTablero.find("#CAF" + i).val()) : 0);
        }
        p["PRECIO"] = PrecioFacturacion.val();
        p["SUBTOTAL"] = SubtotalFacturacion.val();
        switch (parseInt(TPFactura.val())) {
            case 0:
            case 1:
                p["IVA"] = (SubtotalFacturacion.val() * 0.16);
                p["TOTAL_EN_LETRA"] = NumeroALetras(SubtotalFacturacion.val());
                break;
            case 2:
                p["IVA"] = 0;
                p["TOTAL_EN_LETRA"] = NumeroALetras(SubtotalFacturacion.val());
                break;
        }
        p["MONEDA"] = TMNDAFactura.val();
        p["TIPO_CAMBIO"] = TIPODECAMBIO.val();
        p["CAJAS"] = CajasFacturacion.val();
        p["REFERENCIA"] = ReferenciaFacturacion.val();
        p["COLOR_TEXT"] = ColorFacturacion.val();
        p["ZONA"] = ZonaFacturacion.val();
        p["OBSERVACIONES"] = ObservacionFacturacion.val();
        p["CONSIGNACION"] = chkConsignacion[0].checked ? 1 : 0;
        //        console.log("PARAMETROS 2 : ", p);
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
            ParesFacturadosFacturacion.val('');
            btnCierraDocto.attr('disabled', false);
            btnFacturaXAnticipoDeProducto.attr('disabled', true);
            btnControlInCompleto.attr('disabled', true);
            btnControlCompleto.attr('disabled', true);
            btnVistaPreviaF.attr('disabled', false);
            /*DESHABILITAR CAMPOS*/
            FechaFactura.attr('readonly', true);
            Documento.attr('readonly', true);
            FCAFactura.attr('readonly', true);
            PAGFactura.attr('readonly', true);
            TMNDAFactura.attr('readonly', true);
            ClienteFactura[0].selectize.disable();
            TPFactura.attr('disabled', true);
            onNotifyOldPCE('', 'SE HA REGISTRADO EL CONTROL', 'success', "bottom", "center");
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            onCloseOverlay();
        });
        /*VOLVER AL CAMPO DE CONTROL*/
        Control.val('');
        Control.focus().select();
    }

    function onDisableInputs(tf) {
        if (tf) {
            FechaFactura.attr('disabled', true);
            ClienteFactura[0].selectize.disable();
            //            TPFactura[0].selectize.disable();
            TPFactura.attr('disabled', true);
            Documento.attr('disabled', true);
            FCAFactura.attr('disabled', true);
            PAGFactura.attr('disabled', true);
            TMNDAFactura.attr('disabled', true);
            Control.attr('disabled', true);
            CajasFacturacion.attr('disabled', true);
            PrecioFacturacion.attr('disabled', true);
            ObservacionFacturacion.attr('disabled', true);
            Documento.attr('disabled', true);
            for (var i = 1; i < 23; i++) {
                pnlTablero.find("#CAF" + i).attr('disabled', true);
            }
        } else {
            FechaFactura.attr('disabled', false);
            ClienteFactura[0].selectize.enable();
            TPFactura.val('');
            onEnable(TPFactura);
            Documento.attr('disabled', false);
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

    function onComprobarFacturasXAnticipo() {
        /*REVISAR SI TIENE FACTURAS POR ANTICIPO*/
        $.getJSON('<?php print base_url('FacturacionProduccion/getFacturasXAnticipo'); ?>', {
            CLIENTE: ClienteFactura.val()
        }).done(function (a) {
            if (a.length > 0) {
                if (json_facturas.length > 0) {
                    onCalcularMontoXAnticipo();
                    mdlFacturasXAnticipo.modal('show');
                } else {
                    mdlFacturasXAnticipo.modal('show');
                }
            }
        }).fail(function (x) {
            console.log(x);
            getError(x);
        });
    }

    function  onCalcularMontoXAnticipo() {
        var total = 0;

        var facturas = [];
        console.log(tblFacturasXAnticipo.find("tbody tr"));
        $.each(tblFacturasXAnticipo.find("tbody tr"), function (k, v) {
            var cell = $(v).find("input.check_facturas_x_anticipo");
            if (cell[0].checked) {
                var data = FacturasXAnticipo.row(v).data();
                total += parseFloat(data.TOTAL_SIN_FORMATO);
                facturas.push({
                    ID: data.ID,
                    FACTURA: data.FACTURA,
                    CLAVE_CLIENTE: data.CLAVE_CLIENTE,
                    TOTAL: data.TOTAL_SIN_FORMATO
                });
            }
        });

        json_facturas = facturas;
        console.log(facturas);
        mdlFacturasXAnticipo.find("span.json_facturas").text(JSON.stringify(facturas));
        mdlFacturasXAnticipo.find("div.modal-footer").find("span.total_anticipado").text("$ " + $.number(total, 2, '.', ','));

    }

    function getTipoDeCambioYUltimaFactura() {
        var tpx = parseInt(TPFactura.val());
        if (tpx >= 1 && tpx <= 2) {
            onOpenOverlay('');
            $.getJSON('<?php print base_url('FacturacionProduccion/getTipoDeCambio'); ?>').done(function (abcde) {
                if (abcde.length > 0) {
                    TIPODECAMBIO.val(abcde[0].DOLAR);
                    pnlTablero.find("span.tipo_de_cambio").text(abcde[0].DOLAR);
                }
            }).fail(function (x) {
                getError(x);
            }).always(function () {
                onCloseOverlay();
            });
            if (ClienteFactura.val() && TPFactura.val()) {
                var x = tpx === 1 ? 1 : 2;
                if (x === 1 || x === 2) {
                    $.getJSON('<?php print base_url('FacturacionProduccion/getUltimaFactura') ?>', {
                        TP: x
                    }).done(function (a) {
                        if (a.length > 0) {
                            var r = parseInt(TPFactura.val()) === 1 ? a[0].ULFAC : a[0].ULFACR;
                            Documento.val(r);
                            getReferencia();
                        }
                        FCAFactura.val(0);
                        PAGFactura.val(0);
                        TMNDAFactura.val(1); //1 = pesos mexicanos, 2 = dolares americanos
                    }).fail(function (xyz) {
                        getError(xyz);
                    }).always(function () {
                        onCloseOverlay();
                    });
                } else {
                    swal('ATENCIÓN', 'SOLO SE ACEPTA 1 Y 2 x', 'warning').then((value) => {
                        TPFactura.focus().select();
                    });
                }
            } else {
            }
            onCloseOverlay();
        } else {
            swal('ATENCIÓN', 'SOLO SE ACEPTA 1 Y 2 xx', 'warning').then((value) => {
                TPFactura.focus().select();
            });
        }
    }

    function getUltimoFolio() {
        if (nuevo) {
            $.getJSON('<?php print base_url('FacturacionProduccion/getUltimaFactura') ?>', {
                TP: parseInt(TPFactura.val())
            }).done(function (a) {
                if (a.length > 0) {
                    var r = parseInt(TPFactura.val()) === 1 ? a[0].ULFAC : a[0].ULFACR;
                    Documento.val(r);
                }
            }).fail(function (xyz) {
                getError(xyz);
            }).always(function () {
                onCloseOverlay();
            });
        }
    }

    function getListaDePreciosXCliente() {
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
    }
    var mdlHistorialFacturas = $("#mdlHistorialFacturas"),
            tblFacturas = mdlHistorialFacturas.find("#tblFacturas"),
            hFactura = mdlHistorialFacturas.find("#hFactura"),
            hTP = mdlHistorialFacturas.find("#hTP"),
            hCliente = mdlHistorialFacturas.find("#hCliente"),
            hControl = mdlHistorialFacturas.find("#hControl");
    function getHistorial() {
        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
        if ($.fn.DataTable.isDataTable('#tblFacturas')) {
            HistorialFacturados.ajax.reload();
            mdlHistorialFacturas.modal('show');
            return;
        } else {
            HistorialFacturados = tblFacturas.DataTable({
                dom: 'ritp',
                "ajax": {
                    "url": '<?php print base_url('FacturacionProduccion/getHistorialFacturacion'); ?>',
                    "dataSrc": "",
                    "data": function (d) {
                        d.FACTURA = hFactura.val() ? hFactura.val() : '';
                        d.TP = hTP.val() ? hTP.val() : '';
                        d.CLIENTE = hCliente.val() ? hCliente.val() : '';
                        d.CONTROL = hControl.val() ? hControl.val() : '';
                    }
                },
                "columns": [
                    {"data": "ID"},
                    {"data": "FACTURA"}, {"data": "TP"},
                    {"data": "CLIENTE"}, {"data": "FECHA"},
                    {"data": "CONTROL"},
                    {"data": "ESTILO"}, {"data": "COLOR"},
                    {"data": "CORRIDA"}, {"data": "PARES"},
                    {"data": "PRECIO"}, {"data": "SUBTOTAL"},
                    {"data": "IVA"}, {"data": "TOTAL"}
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
                "scrollY": 450,
                "scrollX": true,
                "aaSorting": [
                    [4, 'desc']/*ID*/
                ],
                initComplete: function () {
                    var tblFacturas_info = mdlHistorialFacturas.find("#tblFacturas_info");
                    //ENCIERRA EL DIV
                    tblFacturas_info.wrap('<div class="row"></div>');
                    // CONCATENA DESPUES DEL DIV
                    tblFacturas_info.after("<div class='font-weight-bold pares_totales' style='color: #cc2418;'> Pares 0 < /div>");
                    //ENCIERRA EL DIV            
                    tblFacturas_info.wrap('<div class="col-6"></div>');
                    //ENCIERRA EL DIV
                    mdlHistorialFacturas.find(".pares_totales").wrap('<div class="col-6 mt-2 text-center"></div>');
                    onCalcularParesHistorial();
                }
            });
            hControl.on('keydown', function (e) {
                if (e.keyCode === 13) {
                    onOpenOverlay('');
                    HistorialFacturados.ajax.reload(function () {
                        onCalcularParesHistorial();
                        onCloseOverlay();
                    });
                }
            });
            hCliente.on('keydown', function (e) {
                if (e.keyCode === 13) {
                    onOpenOverlay('');
                    HistorialFacturados.ajax.reload(function () {
                        onCalcularParesHistorial();
                        onCloseOverlay();
                    });
                }
            });
            hTP.on('keydown', function (e) {
                if (e.keyCode === 13) {
                    onOpenOverlay('');
                    HistorialFacturados.ajax.reload(function () {
                        onCalcularParesHistorial();
                        onCloseOverlay();
                    });
                }
            });
            hFactura.on('keydown', function (e) {
                if (e.keyCode === 13) {
                    onOpenOverlay('');
                    HistorialFacturados.ajax.reload(function () {
                        onCalcularParesHistorial();
                        onCloseOverlay();
                    });
                }
            });
            mdlHistorialFacturas.on('shown.bs.modal', function () {
                hFactura.val('');
                hTP.val('');
                hCliente.val('');
                hControl.val('');
                hFactura.focus().select();
            });
            mdlHistorialFacturas.modal('show');
        }
    }

    function onCalcularParesHistorial() {
        var prs = 0;
        $.each(HistorialFacturados.rows().data(), function (k, v) {
            prs += $.isNumeric(v.PARES) ? parseInt(v.PARES) : 0;
        });
        mdlHistorialFacturas.find("div.pares_totales").text("Pares " + prs);
    }
    onOpenOverlay('');
    function getVistaPreviaDocumentoCerrado(f) {
        onBeep(1);
        onOpenOverlay('Espere un momento por favor...');
        $.post('<?php print base_url('FacturacionProduccion/getVistaPrevia'); ?>', {CLIENTE: ClienteFactura.val() !== '' ? ClienteFactura.val() : '', DOCUMENTO_FACTURA: Documento.val() !== '' ? Documento.val() : '', TP: TPFactura.val().trim() !== '' ? TPFactura.val() : ''
        }).done(function (data, x, jq) {
            onBeep(1);
            onImprimirReporteFancyAFC(data, f);
        }).fail(function (x, y, z) {
            swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
        }).always(function () {
            onCloseOverlay();
        });
    }

</script>

<style>  
    table tbody tr {
        -webkit-touch-callout: none !important; /* iOS Safari */
        -webkit-user-select: none !important; /* Safari */
        -khtml-user-select: none !important; /* Konqueror HTML */
        -moz-user-select: none !important; /* Old versions of Firefox */
        -ms-user-select: none !important; /* Internet Explorer/Edge */
        user-select: none !important; /* Non-prefixed version, currently
                              supported by Chrome, Opera and Firefox */
    }

    #tblFacturasXAnticipo tbody td { 
        font-size: 18px; 
        font-weight: bold;
    }

    #tblFacturasXAnticipo tbody td:nth-child(3){
        color: #CC0000 !important; 
    }

    #tblFacturasXAnticipo tbody td:nth-child(5){
        color: #007bff !important; 
    }

    #tblFacturasXAnticipo tbody td:nth-child(6){
        color: #669900 !important; 
    }

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
    input{
        padding-top: 2px !important;
        padding-bottom:  2px !important; 
    } 
    input,textarea{
        padding-top: 2px !important;
        padding-bottom:  2px !important; 
    } 
    .text-danger {
        color: #b71a0a !important;
    }
    button {
        font-weight: bold !important;
    }
    table thead tr{
        background-color: #000 !important;
        color: #fff !important;
    } 
</style>
<?php
$this->load->view('vAdendaCoppel');
