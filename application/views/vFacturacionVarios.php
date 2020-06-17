
<div class="card m-3 animated fadeIn" id="pnlTablero" style="background-color:  #fff !important;">
    <!--    <div class="card-header" align="center" style="padding: 5px 5px 0px 5px !important;">
            
        </div>-->
    <div class="card-body " style="padding: 7px 10px 10px 10px !important;">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-3">

            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-6 text-center">
                <h5 class="font-weight-bold font-italic text-danger">DOCUMENTOS DIRECTOS DE CLIENTES VARIOS</h5>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-3" align="right">
                <button type="button" id="btnNuevo" name="btnNuevo" 
                        class="btn btn-default d-none" 
                        disabled="true"
                        data-toggle="tooltip" data-placement="bottom" title="Hecho" 
                        style="padding: 3px 6px 3px 6px !important;    background-color: #9e9e9e00; box-shadow: none !important; color: #9E9E9E !important; border-color: ">
                    <span class="fa fa-check"></span>
                </button>
                <button type="button" id="btnDeshacer" name="btnDeshacer" 
                        class="btn btn-default d-none" 
                        disabled="true" style="padding: 3px 6px 3px 6px !important;    background-color: #9e9e9e00; box-shadow: none !important; color: #9E9E9E !important; border-color: ">
                    <span class="fa fa-trash"></span>
                </button>
            </div>
        </div>
        <div class="row">    
            <div class="col-12 d-none"> 
                <label>Referencia</label>
                <input type="text" id="ReferenciaFacturacion" name="ReferenciaFacturacion" class="form-control form-control-sm" readonly="">
                <input type="text" id="TIPODECAMBIO" name="TIPODECAMBIO" class="form-control form-control-sm" readonly="">
                <input type="text" id="ZonaFacturacion" name="ZonaFacturacion" class="form-control form-control-sm" readonly="">
                <input type="text" id="AgenteCliente" name="AgenteCliente"  class="form-control form-control-sm" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                <label class="control-label">Cliente</label>
                <div class="row">
                    <div class="col-2">
                        <input type="text" id="ClienteClave" name="ClienteClave" class="form-control form-control-sm numbersOnly" maxlength="8">
                    </div>
                    <div class="col-10">
                        <div class="form-group"> 
                            <div class="form-group">
                                <div class="input-group mb-3"> 
                                    <select id="ClienteFactura" name="ClienteFactura" class="form-control">
                                        <option></option>
                                        <?php
//                                YA CONTIENE LOS BLOQUEOS DE VENTA
                                        foreach ($this->db->query("SELECT C.Clave AS CLAVE, C.RazonS AS CLIENTE, C.Zona AS ZONA, C.ListaPrecios AS LISTADEPRECIO FROM clientes AS C LEFT JOIN bloqueovta AS B ON C.Clave = B.cliente WHERE C.Estatus IN('ACTIVO') AND B.cliente IS NULL  OR C.Estatus IN('ACTIVO') AND B.`status` = 2 ORDER BY ABS(C.Clave) ASC;")->result() as $k => $v) {
                                            print "<option value='{$v->CLAVE}' lista='{$v->LISTADEPRECIO}' zona='{$v->ZONA}'>{$v->CLIENTE}</option>";
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
                </div>
            </div>



            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1 d-none">
                <label>L-P</label>
                <input type="text" id="LPFactura" name="LPFactura" readonly="" data-toggle="tooltip" data-placement="bottom" title="Lista de precios"  class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-1 col-xl-1">
                <label>TP</label>
                <input type="text" id="TPFactura" name="TPFactura" maxlength="1" class="form-control form-control-sm numbersOnly" >
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-1 col-xl-1">
                <label>T-MNDA</label>
                <input type="text" id="TMNDAFactura" name="TMNDAFactura" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                <label>DOCTO</label>
                <input type="text" id="Documento" name="Documento" class="form-control form-control-sm">
            </div>
            <div class="w-100"></div>
            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-1 col-xl-1">
                <label>Fecha</label>
                <input type="text" id="FechaFactura" name="FechaFactura" class="form-control form-control-sm date notEnter ">
            </div> 
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-1 col-xl-1">
                <div class="row">
                    <div class="col-12 order-2">
                        <label>Cantidad</label>
                        <input type="number" id="Cantidad" name="Cantidad" max="9999" min="0" class="form-control form-control-sm ">
                    </div>
                    <div class="col-12 order-1">
                        <div id="info_control" class="d-none">
                            <label>Control</label>
                            <input type="text" id="ControlV" name="ControlV" style="color: #0D47A1 !important; font-size: 18px;    padding-top: 0px;    padding-bottom: 0px;    padding-left: 4px;    padding-right: 4px;"  class="form-control form-control-sm" maxlength="12">
                            <label>Pares restantes</label>
                            <input type="text" id="ParesDelControlV" readonly="" name="ParesDelControlV" max="36" min="0" class="form-control form-control-sm">
                        </div>  
                    </div>  
                </div>  
            </div>  
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-3 col-xl-3">
                <label>Estilo</label>
                <div class="row">
                    <div class="col-2" style="padding-right: 5px; padding-left: 5px;">
                        <input type="text" id="xEstilo" name="xEstilo" class="form-control form-control-sm">
                    </div>
                    <div class="col-10">
                        <select class="form-control form-control-sm notEnter selectNotEnter" id="Estilo" name="Estilo" required placeholder="">
                            <option></option>
                            <?php
                            foreach ($this->db->query("SELECT E.Clave AS Clave, CONCAT(IFNULL(E.Descripcion,''),CONCAT(\" (\",IFNULL(E.Clave,''),\")\"))  AS Estilo FROM estilos AS E  WHERE E.Estatus LIKE 'ACTIVO' GROUP BY E.Clave")->result() as $k => $v) {
                                print "<option value=\"{$v->Clave}\">{$v->Estilo}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 text-center">
                        <label>Color</label>
                        <div class="row"> 
                            <div class="col-3"  style="padding-right: 5px; padding-left: 5px;"> 
                                <input type="text" readonly="" id="ColorClave" name="ColorClave" class="form-control">
                            </div>
                            <div class="col-9">
                                <p class="color_x_control" style="color: #E74C3C !important; font-weight: bold;">-</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="info_control_pares" class="d-none">
                    <div class="w-100 mb-4"></div> 
                    <span class="font-weight-bold pares_controlv mt-2" style="color: #ef1000">0 pares</span>
                    <div class="w-100 mb-4"></div> 
                    <span class="font-weight-bold pares_facturados mt-2" style="color: #ef1000">0 pares</span>
                    <!--<input type="text" id="Estilo" name="Estilo" maxlength="40" minlength="0" class="form-control form-control-sm">-->
                </div> 
            </div> 
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-2 col-xl-2">
                <label>Concepto</label>
                <textarea rows="2" cols="2" id="Concepto" name="Concepto"  class="form-control form-control-sm">
                </textarea>
            </div>
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-1 col-xl-1">
                <label>Precio</label>
                <input type="text" id="Precio" name="Precio" style="color:#008000 !important; padding-top: 0px; padding-bottom: 0px; font-size: 20px; "  class="form-control form-control-sm numbersOnly">
            </div>  
            <div class="col-6 col-xs-6 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                <label>Talla</label>
                <input type="text" id="Talla" name="Talla" maxlength="15" minlength="0" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                <label>SubTotal</label>
                <h5 style="color:#008000 !important; " class="font-weight-bold subtotaldocvarios">$ 0.0 </h5>
                <input type="text" id="Subtotal" name="Subtotal"  class="d-none form-control form-control-sm" readonly="">
            </div> 
            <div class="col-6 col-xs-6 col-sm-2 col-md-2 col-lg-1 col-xl-1" align="center">
                <label>Producto SAT</label><br>
                <span class="text-danger font-weight-bold productoSAT">-</span>
                <input type="text" id="ProductoSAT" name="ProductoSAT" class="form-control form-control-sm d-none">
            </div>
            <div class="col-6 col-xs-6 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                <label>Pedido</label> 
                <input type="text" id="Pedido" name="Pedido" class="form-control form-control-sm">
            </div>


            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-3 col-xl-3">
                <label>Observaciones</label> 
                <textarea id="Observaciones" name="Observaciones" class="form-control form-control-sm" col="2" rows="2">
                </textarea>
            </div> 

            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-1 col-xl-1 mt-3">
                <div class="form-group">
                    <!--CHECK 1-->
                    <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                        <input type="checkbox" class="custom-control-input" id="cNoIva" name="cNoIva" style="cursor: pointer !important;">
                        <label class="custom-control-label text-danger labelCheck" for="cNoIva" style="cursor: pointer !important;">No genera I.V.A</label>
                    </div>
                </div>      
            </div>
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-1 col-xl-1 mt-3">
                <div class="form-group">
                    <!--CHECK 3-->
                    <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                        <input type="checkbox" class="custom-control-input" id="cTimbrar" name="cTimbrar" style="cursor: pointer !important;">
                        <label class="custom-control-label text-danger labelCheck" for="cTimbrar" style="cursor: pointer !important;">Timbrar</label>
                    </div>
                </div>      
            </div>
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-1 col-xl-1 mt-3">
                <div class="form-group">
                    <!--CHECK 4-->
                    <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                        <input type="checkbox" class="custom-control-input" id="cPorAnticipo" name="cPorAnticipo" style="cursor: pointer !important;">
                        <label class="custom-control-label text-danger labelCheck" for="cPorAnticipo" style="cursor: pointer !important;">Por anticipo</label>
                    </div>
                </div>      
            </div> 

            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-2 col-xl-2">
                <label>Pedimento o tax id destinatario</label>
                <input type="text" id="PedimientoXTaxDestinatario" name="PedimientoXTaxDestinatario" class="form-control form-control-sm">
            </div> 
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-2 col-xl-2">
                <label>Orden de compra o clave incotem</label>
                <input type="text" id="OrdenCompraClaveIncotem" name="OrdenCompraClaveIncotem" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-1 col-xl-1 my-1" align="LEFT">
                <button type="button" id="btnAcepta" name="btnAcepta" class="btn btn-info-g mt-2" disabled="">
                    <span class="fa fa-check"></span> Acepta 
                </button>
            </div>
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-2 col-xl-2">
                <div class="form-group">
                    <!--CHECK 4-->
                    <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                        <input type="checkbox" class="custom-control-input" id="cNoCuentaComoPares" name="cNoCuentaComoPares" style="cursor: pointer !important;">
                        <label class="custom-control-label text-danger labelCheck" for="cNoCuentaComoPares" style="cursor: pointer !important;">No cuenta como pares</label>
                    </div>
                </div>      
            </div> 
            <div id="TotalLetra" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                <span class="font-weight-bold font-italic text-danger"> - </span>
            </div> 

            <div class="w-100"></div>

            <!--DETALLE DE LA FACTURA-->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="center"> 
                <hr>
            </div>

            <div class="col-12 col-lg-12 col-xl-12">
                <div class="row"> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8" align="center">
                        <h6 class="font-weight-bold text-danger font-italic">
                            DETALLE DE ESTE DOCTO
                        </h6>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 d-none"  align="right">
                        <h4 class="font-weight-bold text-danger font-italic totalfacturadohead">$ 0.0</h4>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                <table id="tblDetalleDocumento" class="table table-hover table-sm table-bordered"  style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Cliente</th><!--2-->
                            <th scope="col">Factura</th><!--1-->
                            <th scope="col">Fecha</th><!--4-->
                            <th scope="col">TP</th><!--5-->
                            <th scope="col">Concepto</th><!--5-->
                            <th scope="col">Cantidad</th><!--5-->
                            <th scope="col">Precio</th><!--5-->
                            <th scope="col">Subtotal</th><!--5-->  
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>    
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4" align="right">
                        <h4 class="font-weight-bold font-italic" style="color: #008000">SUBTOTAL</h4>
                        <h4 class="font-weight-bold font-italic" style="color: #008000">I.V.A</h4>
                        <h4 class="font-weight-bold font-italic" style="color: #008000">TOTAL</h4>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8" align="right">
                        <h4 class="font-weight-bold text-danger font-italic subtotalfacturadopie">$ 0.0</h4>
                        <h4 class="font-weight-bold text-danger font-italic totalivafacturadopie">$ 0.0</h4>
                        <h4 class="font-weight-bold text-danger font-italic totalfacturadoenletrapie">$ 0.0</h4>
                        <input type="text" id="total_letra_en_pesos" name="total_letra_en_pesos" class="form-control d-none" readonly="">
                        <input type="text" id="total_letra_en_dolares" name="total_letra_en_dolares" class="form-control d-none" readonly="">
                    </div>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5" align="right">
                <h4 class="font-weight-bold font-italic cantidad_facturada">CANTIDAD 0</h4>
            </div>

            <div class="col-12 col-lg-12 col-xl-12">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8" align="center">
                        <h6 class="font-weight-bold text-danger font-italic">
                            DOCUMENTOS DEL CLIENTE
                        </h6>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 d-none"  align="right">
                        <h4 class="font-weight-bold text-danger font-italic totalfacturadohead">$ 0.0</h4>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                <table id="tblDocumentos" class="table table-hover table-sm table-bordered"  style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Cliente</th><!--2-->
                            <th scope="col">Factura</th><!--1-->
                            <th scope="col">Fecha</th><!--4-->
                            <th scope="col">TP</th><!--5-->
                            <th scope="col">Importe</th><!--6-->
                            <th scope="col">ImporteT</th><!--7-->
                            <th scope="col">Pagos</th><!--8-->
                            <th scope="col">PagosT</th><!--9-->
                            <th scope="col">Saldo</th><!--10-->  
                            <th scope="col">SaldoT</th><!--11-->  
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="col-4" align="center">
                <button type="button" id="btnCierraDocto" name="btnCierraDocto" 
                        class="btn btn-danger btn-block my-2">
                    <span class="fa fa-lock"></span>   Cierra docto
                </button>
                <button type="button" id="PrevisualizarDocto" name="PrevisualizarDocto" 
                        class="btn btn-info btn-block my-2">
                    <span class="fa fa-eye"></span>  Previsualiza docto
                </button>
                <button type="button" id="btnAdendaCoppel" name="btnAdendaCoppel" 
                        class="btn btn-warning btn-block my-2">
                    <span class="fa fa-file-medical"></span>   Addenda Coppel
                </button>
            </div>
        </div><!--        END CARD BLOCK-->
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), TIPODECAMBIO = pnlTablero.find('#TIPODECAMBIO'),
            EstatusControl = pnlTablero.find('#EstatusControl'), ZonaFacturacion = pnlTablero.find('#ZonaFacturacion'),
            AgenteCliente = pnlTablero.find('#AgenteCliente'),
            ClienteClave = pnlTablero.find("#ClienteClave"),
            ClienteFactura = pnlTablero.find('#ClienteFactura'), LPFactura = pnlTablero.find('#LPFactura'),
            TPFactura = pnlTablero.find('#TPFactura'),
            TMNDAFactura = pnlTablero.find('#TMNDAFactura'),
            Documento = pnlTablero.find('#Documento'),
            FechaFactura = pnlTablero.find('#FechaFactura'),
            Cantidad = pnlTablero.find('#Cantidad'),
            xEstilo = pnlTablero.find('#xEstilo'),
            Estilo = pnlTablero.find('#Estilo'),
            Concepto = pnlTablero.find('#Concepto'),
            Precio = pnlTablero.find('#Precio'),
            Talla = pnlTablero.find('#Talla'),
            Subtotal = pnlTablero.find('#Subtotal'),
            ProductoSAT = pnlTablero.find('#ProductoSAT'),
            Pedido = pnlTablero.find('#Pedido'),
            Observaciones = pnlTablero.find('#Observaciones'),
            cNoIva = pnlTablero.find('#cNoIva'),
            cTimbrar = pnlTablero.find('#cTimbrar'),
            cPorAnticipo = pnlTablero.find('#cPorAnticipo'),
            PedimientoXTaxDestinatario = pnlTablero.find('#PedimientoXTaxDestinatario'),
            OrdenCompraClaveIncotem = pnlTablero.find('#OrdenCompraClaveIncotem'),
            btnAcepta = pnlTablero.find("#btnAcepta"),
            Hoy = '<?php print Date('d/m/Y'); ?>',
            Documentos, tblDocumentos = pnlTablero.find("#tblDocumentos"),
            DetalleDocumento, tblDetalleDocumento = pnlTablero.find("#tblDetalleDocumento"),
            btnNuevo = pnlTablero.find("#btnNuevo"),
            btnDeshacer = pnlTablero.find("#btnDeshacer"), nuevo = true,
            btnCierraDocto = pnlTablero.find("#btnCierraDocto"), PrevisualizarDocto = pnlTablero.find("#PrevisualizarDocto"),
            AddendaCoppel = pnlTablero.find("#AddendaCoppel"),
            ReferenciaFacturacion = pnlTablero.find("#ReferenciaFacturacion"),
            ControlV = pnlTablero.find("#ControlV"),
            ParesDelControlV = pnlTablero.find("#ParesDelControlV"),
            btnAdendaCoppel = pnlTablero.find("#btnAdendaCoppel");
    $(document).ready(function () {

        Concepto.val('');
        Observaciones.val('');
        FechaFactura.val(Hoy);

        handleEnterDiv(pnlTablero);

        FechaFactura.keydown(function (e) {
            if (e.keyCode === 13 && parseInt(ClienteFactura.val()) === 2121) {
                Cantidad.addClass("selectNotEnter");
                ControlV.focus();
            }
        });

        ControlV.on('keydown', function (e) {
            if (ControlV.val() && e.keyCode === 13) {
                getInfoXControlVarios();
            }
        });

        cNoIva.change(function () {
            getTotales(true);
        });

        ClienteFactura.click(function () {
            ClienteFactura[0].selectize.enable();
        });

        ClienteFactura.change(function () {
            if (ClienteFactura.val()) {
                onBeep(1);
                ClienteClave.val(ClienteFactura.val());
                ClienteFactura[0].selectize.disable();
                TPFactura.focus();
            } else {
                ClienteClave.val('');
                ClienteFactura[0].selectize.enable();
                ClienteFactura[0].selectize.clear(true);
            }
            if (parseInt(ClienteFactura.val()) === 2121) {
                pnlTablero.find("#info_control_pares").removeClass("d-none");
                pnlTablero.find("#info_control").removeClass("d-none");
            } else {
                pnlTablero.find("#info_control").addClass("d-none");
                pnlTablero.find("#info_control_pares").addClass("d-none");
            }
        });

        ClienteClave.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (ClienteClave.val()) {
                    ClienteFactura[0].selectize.setValue(ClienteClave.val());
                    if (ClienteFactura.val()) {
                        ClienteFactura[0].selectize.disable();
                    } else {
                        btnCierraDocto.attr('disabled', true);
                        PrevisualizarDocto.attr('disabled', true);
                        AddendaCoppel.attr('disabled', true);
                        onCampoInvalido(pnlTablero, 'NO EXISTE ESTE CLIENTE, ESPECIFIQUE OTRO', function () {
                            btnCierraDocto.attr('disabled', false);
                            PrevisualizarDocto.attr('disabled', false);
                            AddendaCoppel.attr('disabled', false);
                            ClienteClave.focus().select();
                        });
                        return;
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

        var busy = false;

        btnCierraDocto.click(function () {
            if (busy) {
                return;
            } else {
                busy = true;
            }

            modo = 2;
            ClienteFactura[0].selectize.enable();
            console.log(DetalleDocumento.rows().count(), ",", DetalleDocumento.data().count());
            onOpenOverlay('Espere un momento por favor...');
            if (!nuevo && ClienteFactura.val() && TPFactura.val() && Documento.val() && FechaFactura.val()) {
                /* 
                 * ID, cliente, remicion, fecha, importe, tipo, numpol, numcia, 
                 * status, pagos, saldo, comiesp, tcamb, tmnda, stscont, nc, factura 
                 */
                var p = {
                    CLIENTE: ClienteFactura.val(),
                    FACTURA: Documento.val(),
                    FECHA: FechaFactura.val(),
                    IMPORTE: Subtotal.val(),
                    TIPO: TPFactura.val(),
                    TIPO_MONEDA: TMNDAFactura.val(),
                    TIPO_CAMBIO: TIPODECAMBIO.val(),
                    NO_GEN_IVA: pnlTablero.find("#cNoIva")[0].checked ? 1 : 0,
                    TIMBRAR: pnlTablero.find("#cTimbrar")[0].checked ? 1 : 0,
                    POR_ANTICIPO: pnlTablero.find("#cPorAnticipo")[0].checked ? 1 : 0,
                    MONEDA_LETRA_PESOS: pnlTablero.find("#total_letra_en_pesos").val(),
                    MONEDA_LETRA_DOLARES: pnlTablero.find("#total_letra_en_dolares").val()
                };
                $.post('<?php print base_url('FacturacionVarios/onCerrarDocumento'); ?>', p).done(function (a) {
                    console.log(a);
                    getVistaPrevia();
                    $.getJSON('<?php print base_url('FacturacionVarios/getUltimaFactura') ?>', {
                        TP: TPFactura.val()
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
                    pnlTablero.find("#info_control, #info_control_pares").addClass("d-none");
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    busy = false;
                });
            } else {
                busy = false;
                onCampoInvalido(pnlTablero, 'DEBE DE AGREGAR UN DOCUMENTO VÁLIDO', function () {
                    ClienteClave.focus().select();
                });
            }
        });

        PrevisualizarDocto.click(function () {
            if (ClienteFactura.val() && Documento.val()) {
                onOpenOverlay('');
                $.post('<?php print base_url('FacturacionVarios/getVistaPrevia'); ?>', {
                    CLIENTE: ClienteFactura.val() !== '' ? ClienteFactura.val() : '',
                    DOCUMENTO_FACTURA: Documento.val() !== '' ? Documento.val() : '',
                    TP: TPFactura.val() !== '' ? TPFactura.val() : '',
                    MODO: 1
                }).done(function (data, x, jq) {
                    onBeep(1);
                    onCloseOverlay();
                    onImprimirReporteFancyAFC(data, function (a, b) {
                    });
                }).fail(function (x, y, z) {
                    swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
                }).always(function () {
                    onCloseOverlay();
                });

            } else {
                onCampoInvalido(pnlTablero, 'DEBE DE ESPECIFICAR UN CLIENTE Y UN DOCUMENTO', function () {
                    if (ClienteFactura.val()) {
                        ClienteClave.focus().select();
                    } else if (Documento.val()) {
                        Documento.focus().select();
                    }
                });
            }
        });

        AddendaCoppel.click(function () {

        });

        Estilo.change(function () {
            if (Estilo.val()) {
                xEstilo.val(Estilo.val());
                onObtenerCodigoSatXEstilo();
            } else {
                xEstilo.val('');
                Estilo[0].selectize.enable();
                Estilo[0].selectize.clear(true);
            }
        });

        xEstilo.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xEstilo.val()) {
                    Estilo[0].selectize.setValue(xEstilo.val());
                    Concepto.focus().select();
                    if (Estilo.val()) {
                        onObtenerCodigoSatXEstilo();
                        Concepto.focus().select();
                    } else {
                        onCampoInvalido(pnlTablero, 'NO EXISTE ESTE ESTILO, ESPECIFIQUE OTRO', function () {
                            xEstilo.focus().select();
                        });
                    }
                } else {
                    Estilo[0].selectize.enable();
                    Estilo[0].selectize.clear(true);
                }
            } else {
                Estilo[0].selectize.enable();
                Estilo[0].selectize.clear(true);
            }
        });

        btnDeshacer.click(function () {
            console.log('ok deshacer');
            ClienteFactura[0].selectize.enable();
            TPFactura.attr('disabled', false);

            TMNDAFactura.attr('disabled', false);
            TMNDAFactura.val('');

            Documento.attr('disabled', false);
            Documento.val('');

            FechaFactura.attr('disabled', false);
            btnAcepta.attr('disabled', true);
            btnDeshacer.addClass("d-none");
            btnDeshacer.attr('disabled', true);
            ClienteFactura[0].selectize.clear();
            TPFactura.val('');
            pnlTablero.find("input,textarea").val('');
            FechaFactura.val(Hoy);
            pnlTablero.find("input[type='checkbox']")[0].checked = false;
            ClienteClave.focus().select();
            Estilo[0].selectize.clear();
            getDetalleDocumento();
            getTotales(false);
        });

        Precio.keydown(function (e) {
            console.log(e.keyCode);
            if (e.keyCode === 13 && $(this).length > 0) {
                onCalcularSubtotal();
            }
        });

        Cantidad.keydown(function (e) {
            console.log(e.keyCode);
            if (e.keyCode === 13 && $(this).length > 0) {
                onCalcularSubtotal();
                getReferencia();
                onInHabilitarEncabezado();
                if (nuevo) {
                    DetalleDocumento.rows().remove().draw();
                }
            }
        });
        TPFactura.keydown(function (e) {
            if (ClienteClave.val()) {
                if (e.keyCode === 13 && parseInt(TPFactura.val()) >= 1 && parseInt(TPFactura.val()) <= 2) {
                    getTipoDeCambioYUltimaFactura();
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
                } else {
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
        });
        btnAcepta.click(function () {
            /*validar encabezado*/
            ClienteClave.attr("disabled", false);
            onEnable(ClienteFactura);
            onEnable(Estilo);
            onEnable(TPFactura);
            onEnable(TMNDAFactura);
            onEnable(Documento);
            onEnable(FechaFactura);
            console.log(ClienteFactura.val(), TPFactura.val(), TMNDAFactura.val()
                    , Documento.val(), FechaFactura.val());
            onCalcularSubtotal();
            $.getJSON('<?php print base_url('FacturacionVarios/onComprobarFactura'); ?>',
                    {CLIENTE: (ClienteFactura.val() ? ClienteFactura.val() : ''),
                        FACTURA: Documento.val()
                    }).done(function (a) {
                if (a.length > 0) {
                    if (parseInt(a[0].FACTURA_EXISTE) > 0 && nuevo) {
                        onCampoInvalido(pnlTablero, 'LA FACTURA "' + Documento.val() + '" YA EXISTE, INTENTE CON OTRO NUMERO DE FACTURA', function () {
                            Documento.attr('disabled', false);
                            Documento.focus().select();
                            onCloseOverlay();
                        });
                    } else {
                        if (ClienteFactura.val() && TPFactura.val() && TMNDAFactura.val() && Documento.val() && FechaFactura.val()) {

                            /*validar detalle*/

                            var numero_letra = "";

                            if (parseInt(TPFactura.val()) === 1 && parseInt(TMNDAFactura.val()) === 1) {
                                numero_letra = NumeroALetras(Subtotal.val() * 1.16);
                            } else if (parseInt(TPFactura.val()) === 2 && parseInt(TMNDAFactura.val()) === 1) {
                                numero_letra = NumeroALetras(Subtotal.val());
                            } else if (parseInt(TPFactura.val()) === 1 && parseInt(TMNDAFactura.val()) === 2 ||
                                    parseInt(TPFactura.val()) === 2 && parseInt(TMNDAFactura.val()) === 2) {
                                numero_letra = NumeroALetras(Subtotal.val());
                            }

                            var p = {
                                FACTURA: Documento.val(),
                                TP: TPFactura.val(),
                                CLIENTE: ClienteFactura.val(),
                                TIPO_MONEDA: TMNDAFactura.val(),
                                FECHA: FechaFactura.val(),
                                AGENTE: AgenteCliente.val(),
                                CANTIDAD: Cantidad.val(),
                                ESTILO: Estilo.val(),
                                CONCEPTO: Concepto.val() ? Concepto.val() : '', PRECIO: Precio.val(),
                                TALLA: Talla.val(),
                                NO_GENERA_IVA: (pnlTablero.find("#cNoIva")[0].checked ? 1 : 0),
                                TIPO_CAMBIO: TIPODECAMBIO.val(),
                                ZONA: ZonaFacturacion.val(),
                                SUBTOTAL: Subtotal.val(),
                                OBS: Observaciones.val() ? Observaciones.val() : '',
                                PEDIMENTO: PedimientoXTaxDestinatario.val(),
                                ORDEN_DE_COMPRA: OrdenCompraClaveIncotem.val(),
                                MONEDA_LETRA: numero_letra,
                                PRODUCTO_SAT: ProductoSAT.val(),
                                REFERENCIA: ReferenciaFacturacion.val(),
                                COLOR_CLAVE: ReferenciaFacturacion.val(),
                                CONTROLV: ControlV.val() ? ControlV.val() : '', PARES_RESTANTES: ParesDelControlV.val()
                            };
                            if (Cantidad.val() && Estilo.val() && Precio.val()) {
                                onOpenOverlay('Guardando...');
//                                if (nuevo) {
                                $.post('<?php print base_url('FacturacionVarios/onGuardar') ?>', p).done(function (a) {
                                    Cantidad.val('');
                                    Estilo[0].selectize.clear();
                                    Concepto.val('');
                                    Precio.val('');
                                    Talla.val('');
                                    Subtotal.val('');
                                    pnlTablero.find("span.subtotaldocvarios").text("$0.0");
                                    pnlTablero.find(".productoSAT").text('-');
                                    Pedido.val('');
                                    pnlTablero.find("#cNoIva")[0].checked = false;
                                    pnlTablero.find("#cTimbrar")[0].checked = false;
                                    pnlTablero.find("#cPorAnticipo")[0].checked = false;
                                    PedimientoXTaxDestinatario.val('');
                                    OrdenCompraClaveIncotem.val('');
                                    Cantidad.focus().select();
                                    getDetalleDocumento();
                                    nuevo = false;
                                    if (parseInt(ClienteFactura.val()) === 2121) {
                                        pnlTablero.find("#info_control_pares").removeClass("d-none");
                                        pnlTablero.find("#info_control").removeClass("d-none");
                                    }
                                    onNotifyOldPCE('', 'REGISTRO EXITOSO', 'success', "bottom", "center");
                                }).fail(function (x) {
                                    getError(x);
                                }).always(function () {
                                    onCloseOverlay();
                                });
                                //                                } else {
//
//                                }
                            } else {
                                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR TODA LA INFORMACIÓN \n Cantidad \n Estilo \n Precio ', 'error').then((value) => {
                                    Cantidad.focus().select();
                                });
                            }
                        } else {
                            swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR TODA LA INFORMACIÓN \n Cliente, TP \n Documento, Fechas \n Cantidad, Estilo \n Precio ', 'error').then((value) => {
                                ClienteClave.focus().select();
                            });
                        }
                    }
                }
            }).fail(function (x) {
                getError(x);
            }).always(function () {
            });
        });

        TPFactura.change(function (e) {
            if (e.keyCode === 13 && parseInt(TPFactura.val()) >= 3 && parseInt(TPFactura.val()) === 0) {
                onCampoInvalido(pnlTablero, "SOLO SE PERMITE 1 Y 2", function () {
                    TPFactura.focus().select();
                });
                return;
            }
            $.getJSON('<?php print base_url('FacturacionVarios/getTipoDeCambio'); ?>').done(function (abcde) {
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
                    $.getJSON('<?php print base_url('FacturacionVarios/getUltimaFactura') ?>', {
                        TP: x
                    }).done(function (a) {
                        if (a.length > 0) {
                            var r = parseInt(TPFactura.val()) === 1 ? a[0].ULFAC : a[0].ULFACR;
                            Documento.val(r);
                        }
                        TMNDAFactura.val(1); //1 = pesos mexicanos, 2 = dolares americanos
                        TMNDAFactura.focus().select();
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
            }
        }).focusout(function () {
            if (ClienteClave.val()) {
                if (parseInt(TPFactura.val()) >= 1 && parseInt(TPFactura.val()) <= 2) {
                    //ALGUNA FUNCION...
                } else {
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
        });

        ClienteFactura.change(function () {
            if (ClienteFactura.val()) {
                $.post('<?php print base_url('FacturacionVarios/getListaDePreciosXCliente') ?>', {
                    CLIENTE: ClienteFactura.val()
                }).done(function (a) {
                    if (a.length > 0) {
                        var xxx = JSON.parse(a);
                        LPFactura.val(xxx[0].LP);
                        ZonaFacturacion.val(xxx[0].ZONA);
                        AgenteCliente.val(xxx[0].AGENTE);
                    }
                    getDocumentosXCliente();
                    getDetalleDocumento();
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    onCloseOverlay();
                });
            }
        });

        Documentos = tblDocumentos.DataTable({
            dom: 'ript',
            "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }, {
                    "targets": [6], "visible": false,
                    "searchable": false
                }, {
                    "targets": [8], "visible": false,
                    "searchable": false
                }, {
                    "targets": [9], "visible": true,
                    "searchable": false
                }, {
                    "targets": [10],
                    "visible": false,
                    "searchable": false
                }],
            language: lang,
            responsive: true,
            "processing": true, select: true,
            "autoWidth": true,
            "colReorder": true, "displayLength": 99,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": 200,
            "scrollX": true
        });

        ClienteClave.focus().select();

        DetalleDocumento = tblDetalleDocumento.DataTable({
            dom: 'rt',
            "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }],
            language: lang,
            responsive: true,
            "serverSide": false,
            "info": true,
            "processing": true, select: true,
            "autoWidth": true,
            "colReorder": true, "displayLength": 9999,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": 200,
            "scrollX": true,
            "drawCallback": function (settings) {
                var api = this.api();
                var prs = 0;
                console.log(api.rows().data());
                $.each(api.rows().data(), function (k, v) {
                    prs = prs + parseInt(v[6]);
                });                 //                mdlRastreoXControl.find(".total_pesos").text("$ " + r.toFixed(3));
                pnlTablero.find("h4.cantidad_facturada").text('CANTIDAD  ' + prs);
            }
            , initComplete: function () {
                ClienteClave.focus();
            }
        });
        getDocumentosXCliente();
        getDetalleDocumento();
    });

    function onComprobarFactura() {
        $.getJSON('<?php print base_url('FacturacionVarios/onComprobarFactura'); ?>',
                {CLIENTE: (ClienteFactura.val() ? ClienteFactura.val() : ''),
                    FACTURA: Documento.val()
                }).done(function (a) {
            if (a.length > 0) {
                if (parseInt(a[0].FACTURA_EXISTE) > 0) {
                    onCampoInvalido(pnlTablero, 'LA FACTURA "' + Documento.val() + '" YA EXISTE, INTENTE CON OTRO NUMERO DE FACTURA', function () {
                        Documento.attr('disabled', false);
                        Documento.focus().select();
                        onCloseOverlay();
                    });
                } else {

                }
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
        });
    }

    function onCalcularSubtotal() {
        var subtotal = 0;
        subtotal = (Cantidad.val() ? Cantidad.val() : 0) * (Precio.val() ? Precio.val() : 0);
        Subtotal.val(subtotal);
        pnlTablero.find(".subtotaldocvarios").text('$' + $.number(subtotal, '2', '.', ','));
        btnAcepta.attr('disabled', false);

    }

    function getReferenciaX() {
        var reffac = 0, reffac1 = 0, reffac2 = 0, reffac2 = Documento.val(), txtreferen2 = 0;
        var txtreferen1 = padLeft(ClienteFactura.val(), 4) + '' + padLeft(Documento.val(), 4);

        var num1 = 0, num2 = 0, num3 = 0, num4 = 0, num5 = 0,
                num6 = 0, num7 = 0, num8 = 0, num9 = 0,
                num10 = 0, num11 = 0, num12 = 0, num13 = 0, num14 = 0, num15 = 0, num16 = 0, num17 = 0, num18 = 0, num19 = 313, num20 = 802, txtreferen3 = 0, txtreferen4 = 0,
                txtreferen9 = 0, txtreferen10 = 0, txtreferen11 = 0;

        for (var refe1 = 0; refe1 <= txtreferen1.length; refe1++) {
            txtreferen2 = txtreferen1.substr(refe1, 1);
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
        txtreferen4 = txtreferen3 / 97;

        txtreferen9 = txtreferen3 * 97;
        txtreferen10 = 99 - txtreferen9;
        txtreferen11 = txtreferen10.length;

        btnAcepta.attr('disabled', false);
    }

    function getReferencia() {
        var txtreferen11 = "000000000000398827";
        txtreferen11 = padLeft(ClienteFactura.val(), 14) + '' + padLeft(Documento.val(), 4);

        var num1 = 0, num2 = 0, num3 = 0, num4 = 0, num5 = 0,
                num6 = 0, num7 = 0, num8 = 0, num9 = 0,
                num10 = 0, num11 = 0, num12 = 0, num13 = 0, num14 = 0, num15 = 0, num16 = 0, num17 = 0, num18 = 0, num19 = 313, num20 = 802, txtreferen2 = 0, txtreferen3 = 0, txtreferen4 = 0,
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
    }
    function onInHabilitarEncabezado() {
        if (ClienteFactura.val() && TPFactura.val()
                && TMNDAFactura.val() && Documento.val() && FechaFactura.val()) {
            ClienteClave.attr('disabled', true);
            ClienteFactura[0].selectize.disable();
            TPFactura.attr('disabled', true);
            TMNDAFactura.attr('disabled', true);
            Documento.attr('disabled', true);
            FechaFactura.attr('disabled', true);
            btnAcepta.attr('disabled', false);
            Cantidad.focus().select();
            btnDeshacer.attr('disabled', false);
            btnDeshacer.removeClass("d-none");
        } else {
            btnAcepta.attr('disabled', true);
        }
    }

    function getDocumentosXCliente() {
        $.getJSON('<?php print base_url('FacturacionVarios/getDocumentosXCliente'); ?>', {CLIENTE: ClienteFactura.val() ? ClienteFactura.val() : ''}).done(function (a) {
            if (a.length > 0) {
                var r = [];
                $.each(a, function (k, v) {
                    r.push([v.ID, v.CLIENTE, v.DOCTO, v.FECHA, v.TP,
                        '$' + $.number(v.IMPORTE, 2, '.', ','), v.IMPORTE,
                        '$' + $.number(v.PAGOS, 2, '.', ','), v.PAGOS,
                        (parseFloat(v.SALDO) <= 0) ? '<span style="color: #689F38 !important;">$' + $.number(v.SALDO, 2, '.', ',') + '</span>' : '<span class="text-danger">$' + $.number(v.SALDO, 2, '.', ',') + '</span>', v.SALDO,
                        '<span class="fa fa-lock"></span>',
                        v.CAJAS_FACTURACION, v.OBS, v.DESCUENTO, v.PARES_FACTURADOS, v.FACTURA, v.TIPO_MONEDA, 1,
                        v.ESTATUS_PRODUCCION, 1]);
                    if (v.ESTATUS_PRODUCCION === 'FACTURADO' && !facturado) {
                        facturado = true;
                    }
                });
                Documentos.rows.add(r).draw(false);
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            onCloseOverlay();
        });
    }

    function getDetalleDocumento() {
        $.getJSON('<?php print base_url('FacturacionVarios/getDetalleDocumento'); ?>',
                {
                    CLIENTE: ClienteFactura.val() ? ClienteFactura.val() : '',
                    FACTURA: Documento.val() ? Documento.val() : ''
                }).done(function (a) {
            if (a.length > 0) {
                var r = [];
                DetalleDocumento.rows().remove().draw();
                $.each(a, function (k, v) {
                    r.push([v.ID, v.CLIENTE, v.DOCTO, v.FECHA, v.TP, v.CONCEPTO, v.CANTIDAD,
                        '$' + $.number(v.PRECIO, 2, '.', ','),
                        '$' + $.number(v.SUBTOTAL, 2, '.', ',')]);
                });
                DetalleDocumento.rows.add(r).draw(false);
                if (ClienteFactura.val() && Documento.val()) {
                    getTotales(true);
                } else {
                    getTotales(false);
                }
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            onCloseOverlay();
        });
    }


    function getTotales(tf) {
        if (tf) {
            var subtotal = 0;
            $.each(DetalleDocumento.rows().data(), function (k, v) {
                subtotal += getNumberFloat(v[8]);
            });
            if (cNoIva[0].checked) {
                pnlTablero.find(".subtotalfacturadopie").text("$" + $.number(subtotal, 2, '.', ','));
                pnlTablero.find(".totalivafacturadopie").text("$" + $.number(0, 2, '.', ','));
                pnlTablero.find(".totalfacturadoenletrapie").text("$" + $.number(subtotal, 2, '.', ','));
                pnlTablero.find("#total_letra_en_pesos").val(NumeroALetras(subtotal));
                var dlls = NumeroALetras(subtotal);
                dlls = dlls.replace("pesos", "Dolares");
                dlls = dlls.replace("m.n", "Dll");
                pnlTablero.find("#total_letra_en_dolares").val(dlls);
            } else {
                pnlTablero.find(".subtotalfacturadopie").text("$" + $.number(subtotal, 2, '.', ','));
                pnlTablero.find(".totalivafacturadopie").text("$" + $.number(subtotal * 0.16, 2, '.', ','));
                pnlTablero.find(".totalfacturadoenletrapie").text("$" + $.number(subtotal * 1.16, 2, '.', ','));
                pnlTablero.find("#total_letra_en_pesos").val(NumeroALetras(subtotal * 1.16));
                var dlls = NumeroALetras(subtotal * 1.16);
                dlls = dlls.replace("PESOS", "DOLARES");
                dlls = dlls.replace("pesos", "Dolares");
                dlls = dlls.replace("m.n", "DLL");
                dlls = dlls.replace("mxn", "DLL");
                dlls = dlls.replace("MXN", "DLL");
                pnlTablero.find("#total_letra_en_dolares").val(dlls);
            }
        } else {
            pnlTablero.find(".subtotalfacturadopie").text("$0.0");
            pnlTablero.find(".totalivafacturadopie").text("$0.0");
            pnlTablero.find(".totalfacturadoenletrapie").text("$0.0");
            pnlTablero.find("#total_letra_en_pesos").val("");
            pnlTablero.find("#total_letra_en_dolares").val("");
        }
    }

    function getReferencia() {
        var txtreferen11 = "000000000000398827";
        txtreferen11 = padLeft(ClienteFactura.val(), 14) + '' + padLeft(Documento.val(), 4);
        var num1 = 0, num2 = 0, num3 = 0, num4 = 0, num5 = 0,
                num6 = 0, num7 = 0, num8 = 0, num9 = 0,
                num10 = 0, num11 = 0, num12 = 0, num13 = 0, num14 = 0, num15 = 0, num16 = 0, num17 = 0, num18 = 0, num19 = 313, num20 = 802, txtreferen2 = 0, txtreferen3 = 0, txtreferen4 = 0,
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
    var modo = 0;
    function  getVistaPrevia() {
        $.post('<?php print base_url('FacturacionVarios/getVistaPrevia'); ?>', {
            CLIENTE: ClienteFactura.val().trim() !== '' ? ClienteFactura.val() : '',
            DOCUMENTO_FACTURA: Documento.val().trim() !== '' ? Documento.val() : '',
            TP: TPFactura.val().trim() !== '' ? TPFactura.val() : '',
            MODO: modo
        }).done(function (data, x, jq) {
            onBeep(1);
            onCloseOverlay();
            onImprimirReporteFancyAFC(data, function (a, b) {
                location.reload();
            });
        }).fail(function (x, y, z) {
            swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
        }).always(function () {
            onCloseOverlay();
        });
    }

    function onObtenerCodigoSatXEstilo() {
        $.getJSON(
                '<?php print base_url('FacturacionVarios/onObtenerCodigoSatXEstilo') ?>',
                {ESTILO: Estilo.val()}).done(function (a) {
            console.log(a);
            if (a.length > 0) {
                pnlTablero.find("span.productoSAT").text(a[0].CPS);
                ProductoSAT.val(a[0].CPS);
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
        });
    }

    function getTipoDeCambioYUltimaFactura() {
        var tpx = parseInt(TPFactura.val());
        if (tpx >= 1 && tpx <= 2) {
            onOpenOverlay('');
            $.getJSON('<?php print base_url('FacturacionProduccion/getTipoDeCambio'); ?>').done(function (abcde) {
                if (abcde.length > 0) {
                    TIPODECAMBIO.val(abcde[0].DOLAR);
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

    function getInfoXControlVarios() {
        $.getJSON('<?php print base_url('FacturacionVarios/getInfoXControlVarios'); ?>', {
            CONTROL: pnlTablero.find("#ControlV").val()
        }).done(function (a) {
            if (a[0].length < 0) {
                console.log(" * * * * * CONTROL INVÁLIDO O NO EXISTE * * * * * ");
                console.log(a);
                console.log(" * * * * * CONTROL INVÁLIDO O NO EXISTE * * * * * ");
                onCampoInvalido(pnlTablero, "CONTROL INVÁLIDO O NO EXISTE, VERIFIQUE.", function () {
                    ControlV.focus().select();
                });
                return;
            }
            console.log("\n DATOS \n");
            console.log(a);
            console.log("\n DATOS \n");
            xEstilo.val(a[0].ESTILO);
            Pedido.val(a[0].PEDIDO);
            pnlTablero.find(".color_x_control").text(a[0].COLOR);
            Cantidad.val(a[0].PARES);
            pnlTablero.find("#ColorClave").val(a[0].COLOR_CLAVE);
            var pares = parseInt(a[0].PARES), pares_restantes = 0, pares_facturados = parseInt(a[0].PARES_FACTURADOS);
            pnlTablero.find("span.pares_controlv").text(a[0].PARES + " PARES");
            pnlTablero.find("span.pares_facturados").text(pares_facturados + " PARES FACTURADOS");
            var prs = parseInt(a[0].PARES) - parseInt(pares_facturados);
            prs = prs - Cantidad.val();
            pares_restantes = pares - pares_facturados;
            if (prs >= 0) {
                onEnable(btnAcepta);
                ParesDelControlV.val(prs);
            } else {
                ParesDelControlV.val(pares_restantes);
                onDisable(btnAcepta);
                onCampoInvalido(pnlTablero, "HA SUPERADO LA CANTIDAD DE PARES SOLO QUEDAN " + pares_restantes, function () {
                    Cantidad.focus().select();
                });
            }
        }
        ).fail(function (x) {
            getError(x);
        });
    }
</script>
<style>  
    .card{ 
        border: 2px solid #000;
        border-image: linear-gradient(to bottom,  #000000, #999999, rgb(0,0,0,0)) 1 100% ;
    }
    #tblParesFacturados tbody td{
        font-weight: bold !important;
    }
    #tblParesFacturados thead th{
        font-size: 12px !important;
    }
    input, .selectize-input {
        font-weight: bold;
    }
    #tblDetalleDocumento tbody td {
        font-weight: bold !important;
    }
    .cantidad_facturada{
        color: #008000;
    }
    .text-danger {
        color: #263238 !important;
    }
    button, label, table thead th{
        text-transform: uppercase !important;
        font-weight: bold !important;
    }
    .btn-info-g {
        color: #fff;
        background-color: #2E7D32 !important;
        border-color: #2E7D32 !important;
    }
    #tblDetalleDocumento tbody td:eq(5){
        color: #008000 !important;
    }
</style>
<?php
$this->load->view('vAdendaCoppel');