<div class="card m-3 animated fadeIn" id="pnlTablero" style="background-color:  #fff !important;">
    <div class="card-header" align="center" style="padding: 5px 5px 0px 5px !important;">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-3">

            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-6">
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
    </div>
    <div class="card-body " style="padding: 7px 10px 10px 10px !important;">
        <div class="row">    
            <div class="col-12 d-none">
                <input type="text" id="TIPODECAMBIO" name="TIPODECAMBIO" class="form-control form-control-sm" readonly="">
                <input type="text" id="EstatusControl" name="EstatusControl" class="form-control form-control-sm" readonly="">
                <input type="text" id="ZonaFacturacion" name="ZonaFacturacion" class="form-control form-control-sm" readonly="">
                <input type="text" id="AgenteCliente" name="AgenteCliente"   readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                <div class="form-group">
                    <label class="control-label">Cliente</label>
                    <div class="form-group">
                        <div class="input-group mb-3"> 
                            <select id="ClienteFactura" name="ClienteFactura" class="form-control">
                                <option></option>
                                <?php
//                                YA CONTIENE LOS BLOQUEOS DE VENTA
                                foreach ($this->db->query("SELECT C.Clave AS CLAVE, CONCAT(C.Clave, \" - \",C.RazonS) AS CLIENTE, C.Zona AS ZONA, C.ListaPrecios AS LISTADEPRECIO FROM clientes AS C LEFT JOIN bloqueovta AS B ON C.Clave = B.cliente WHERE C.Estatus IN('ACTIVO') AND B.cliente IS NULL ORDER BY ABS(C.Clave) ASC;")->result() as $k => $v) {
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
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1 d-none">
                <label>L-P</label>
                <input type="text" id="LPFactura" name="LPFactura" readonly="" data-toggle="tooltip" data-placement="bottom" title="Lista de precios"  class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-1 col-xl-1">
                <label>TP</label>
                <select id="TPFactura" name="TPFactura" class="form-control form-control-sm" >
                    <option></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-3 col-lg-1 col-xl-1">
                <label>T-MNDA</label>
                <input type="text" id="TMNDAFactura" name="TMNDAFactura" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                <label>DOCTO</label>
                <input type="text" id="Documento" name="Documento" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                <label>Fecha</label>
                <input type="text" id="FechaFactura" name="FechaFactura" class="form-control form-control-sm date notEnter">
            </div> 
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-1 col-xl-1">
                <label>Cantidad</label>
                <input type="number" id="Cantidad" name="Cantidad" max="9999" min="0" class="form-control form-control-sm">
            </div>  
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-1 col-xl-1">
                <label>Estilo</label>
                <select class="form-control form-control-sm" id="Estilo" name="Estilo" required placeholder="">
                    <option></option>
                    <?php
                    foreach ($this->db->query("SELECT E.Clave AS Clave,CONCAT(E.Clave,'-',IFNULL(E.Descripcion,'')) AS Estilo FROM estilos AS E  WHERE E.Estatus LIKE 'ACTIVO' GROUP BY E.Clave")->result() as $k => $v) {
                        print "<option value=\"{$v->Clave}\">{$v->Estilo}</option>";
                    }
                    ?>
                </select>
                <!--<input type="text" id="Estilo" name="Estilo" maxlength="40" minlength="0" class="form-control form-control-sm">-->
            </div> 
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-2 col-xl-2">
                <label>Concepto</label>
                <textarea rows="2" cols="2" id="Concepto" name="Concepto"  class="form-control form-control-sm">
                </textarea>
            </div>
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-1 col-xl-1">
                <label>Precio</label>
                <input type="text" id="Precio" name="Precio" class="form-control form-control-sm numbersOnly">
            </div>  
            <div class="col-6 col-xs-6 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                <label>Talla</label>
                <input type="text" id="Talla" name="Talla" maxlength="15" minlength="0" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                <label>SubTotal</label>
                <h5 class="text-danger font-weight-bold subtotaldocvarios">$ 0.0 </h5>
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

            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-1 col-xl-1">
                <div class="form-group">
                    <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                        <input type="checkbox" class="custom-control-input selectNotEnter" id="cNoIva" name="cNoIva" style="cursor: pointer !important;">
                        <label class="custom-control-label text-danger labelCheck" for="cNoIva" style="cursor: pointer !important;">No genera I.V.A</label>
                    </div>
                </div>      
            </div>
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-1 col-xl-1">
                <div class="form-group">
                    <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                        <input type="checkbox" class="custom-control-input selectNotEnter" id="cTimbrar" name="cTimbrar" style="cursor: pointer !important;">
                        <label class="custom-control-label text-danger labelCheck" for="cTimbrar" style="cursor: pointer !important;">Timbrar</label>
                    </div>
                </div>      
            </div>
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-1 col-xl-1">
                <div class="form-group">
                    <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                        <input type="checkbox" class="custom-control-input selectNotEnter" id="cPorAnticipo" name="cPorAnticipo" style="cursor: pointer !important;">
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
                <button type="button" id="btnAcepta" name="btnAcepta" class="btn btn-primary mt-2" disabled="">
                    <span class="fa fa-check"></span> Acepta
                </button>
            </div>

            <div id="TotalLetra" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                <span class="font-weight-bold font-italic text-danger"> - </span>
            </div> 

            <div class="w-100 my-2"></div>

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
                <table id="tblDetalleDocumento" class="table table-hover table-sm"  style="width: 100% !important;">
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

            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-1 col-xl-1" align="right">
                <h4 class="font-weight-bold text-danger font-italic">SUBTOTAL</h4>
                <h4 class="font-weight-bold text-danger font-italic">I.V.A</h4>
                <h4 class="font-weight-bold text-danger font-italic">TOTAL</h4>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3" align="right">
                <h4 class="font-weight-bold text-danger font-italic subtotalfacturadopie">$ 0.0</h4>
                <h4 class="font-weight-bold text-danger font-italic totalivafacturadopie">$ 0.0</h4>
                <h4 class="font-weight-bold text-danger font-italic totalfacturadoenletrapie">$ 0.0</h4>
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
                <table id="tblDocumentos" class="table table-hover table-sm"  style="width: 100% !important;">
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
            <div class="col-2" align="center"></div>
            <div class="col-2" align="center">
                <button type="button" id="CierraDocto" name="CierraDocto" class="btn btn-danger btn-block">
                    <span class="fa fa-lock"></span>   Cierra docto
                </button>
                <button type="button" id="PrevisualizarDocto" name="PrevisualizarDocto" class="btn btn-info btn-block">
                    <span class="fa fa-eye"></span>  Previsualiza docto
                </button>
                <button type="button" id="AddendaCoppel" name="AddendaCoppel" class="btn btn-warning btn-block">
                    <span class="fa fa-file-medical"></span>   Addenda Coppel
                </button> 
            </div>
        </div><!--        END CARD BLOCK-->
    </div>
</div>

<script>
    var pnlTablero = $("#pnlTablero"), TIPODECAMBIO = pnlTablero.find('#TIPODECAMBIO'),
            EstatusControl = pnlTablero.find('#EstatusControl'),
            ZonaFacturacion = pnlTablero.find('#ZonaFacturacion'),
            AgenteCliente = pnlTablero.find('#AgenteCliente'),
            ClienteFactura = pnlTablero.find('#ClienteFactura'),
            LPFactura = pnlTablero.find('#LPFactura'),
            TPFactura = pnlTablero.find('#TPFactura'),
            TMNDAFactura = pnlTablero.find('#TMNDAFactura'),
            Documento = pnlTablero.find('#Documento'),
            FechaFactura = pnlTablero.find('#FechaFactura'),
            Cantidad = pnlTablero.find('#Cantidad'),
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
            btnDeshacer = pnlTablero.find("#btnDeshacer"), nuevo = true;

    $(document).ready(function () {

        Concepto.val('');
        Observaciones.val('');
        FechaFactura.val(Hoy);

        handleEnterDiv(pnlTablero);


        Estilo.change(function () {
            if (Estilo.val()) {
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
        });

        btnDeshacer.click(function () {
            console.log('ok deshacer');
            ClienteFactura[0].selectize.enable();
            TPFactura[0].selectize.enable();

            TMNDAFactura.attr('disabled', false);
            TMNDAFactura.val('');

            Documento.attr('disabled', false);
            Documento.val('');

            FechaFactura.attr('disabled', false);
            btnAcepta.attr('disabled', false);
            btnDeshacer.addClass("d-none");
            btnDeshacer.attr('disabled', true);
            ClienteFactura[0].selectize.clear();
            TPFactura[0].selectize.clear();
            pnlTablero.find("input,textarea").val('');
            FechaFactura.val(Hoy);
            pnlTablero.find("input[type='checkbox']")[0].checked = false;
            ClienteFactura[0].selectize.focus();
            Estilo[0].selectize.clear();
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
                onInHabilitarEncabezado();
            }
        });

        btnAcepta.click(function () {
            /*validar encabezado*/
            onComprobarFactura();
            if (ClienteFactura.val() && TPFactura.val() && TMNDAFactura.val()
                    && Documento.val() && FechaFactura.val()) {

                /*validar detalle*/
                var p = {
                    FACTURA: Documento.val(),
                    TP: TPFactura.val(),
                    CLIENTE: ClienteFactura.val(),
                    TIPO_MONEDA: TMNDAFactura.val(),
                    FECHA: FechaFactura.val(),
                    AGENTE: AgenteCliente.val(),
                    CANTIDAD: Cantidad.val(),
                    ESTILO: Estilo.val(),
                    CONCEPTO: Concepto.val(),
                    PRECIO: Precio.val(),
                    TALLA: Talla.val(),
                    NO_GENERA_IVA: (pnlTablero.find("#cNoIva")[0].checked ? 1 : 0),
                    TIPO_CAMBIO: TIPODECAMBIO.val(),
                    ZONA: ZonaFacturacion.val(),
                    SUBTOTAL: Subtotal.val(),
                    OBS: Observaciones.val(),
                    PEDIMENTO: PedimientoXTaxDestinatario.val(),
                    ORDEN_DE_COMPRA: OrdenCompraClaveIncotem.val()
                };
                if (Cantidad.val() && Estilo.val() && Concepto.val() && Precio.val() && Talla.val()) {
                    onOpenOverlay('Guardando...');
                    if (nuevo) {
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
                            Observaciones.val('');
                            pnlTablero.find("#cNoIva")[0].checked = false;
                            pnlTablero.find("#cTimbrar")[0].checked = false;
                            pnlTablero.find("#cPorAnticipo")[0].checked = false;
                            PedimientoXTaxDestinatario.val('');
                            OrdenCompraClaveIncotem.val('');
                            nuevo = false;
                            Cantidad.focus().select();
                        }).fail(function (x) {
                            getError(x);
                        }).always(function () {
                            onCloseOverlay();
                        });
                    } else {

                    }
                } else {
                    swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR TODA LA INFORMACIÓN', 'error').then((value) => {
                        Cantidad.focus().select();
                    });
                }
            } else {
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR TODA LA INFORMACIÓN', 'error').then((value) => {
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
                            Documento.val(r);
                        }
                        TMNDAFactura.val(0); //0 = pesos mexicanos, 1 = dolares americanos
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
        });

        ClienteFactura.change(function () {
            if (ClienteFactura.val()) {
                onOpenOverlay('');
                $.post('<?php print base_url('FacturacionProduccion/getListaDePreciosXCliente') ?>', {
                    CLIENTE: ClienteFactura.val()
                }).done(function (a) {
                    if (a.length > 0) {
                        var xxx = JSON.parse(a);
                        LPFactura.val(xxx[0].LP);
                        ZonaFacturacion.val(xxx[0].ZONA);
                        AgenteCliente.val(xxx[0].AGENTE);
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    onCloseOverlay();
                });
            }
        });

        Documentos = tblDocumentos.DataTable({
            dom: 'rt',
            "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }, {
                    "targets": [6],
                    "visible": false,
                    "searchable": false
                }, {
                    "targets": [8],
                    "visible": false,
                    "searchable": false
                }, {
                    "targets": [9],
                    "visible": true,
                    "searchable": false
                }, {
                    "targets": [10],
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
            "scrollY": 200,
            "scrollX": true
        });

        ClienteFactura[0].selectize.focus();

        DetalleDocumento = tblDetalleDocumento.DataTable({
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
            "scrollY": 200,
            "scrollX": true
        });
        getDocumentosXCliente();
    });

    function onComprobarFactura() {
        $.getJSON('<?php print base_url('FacturacionProduccion/onComprobarFactura'); ?>',
                {CLIENTE: (ClienteFactura.val() ? ClienteFactura.val() : ''), FACTURA: Documento.val()
                }).done(function (a) {
            if (a.length > 0) {
                if (parseInt(a[0].FACTURA_EXISTE) > 0) {
                    iMsg('LA FACTURA "' + Documento.val() + '" YA EXISTE, INTENTE CON OTRO NUMERO DE FACTURA', 'w', function () {
                        Documento.attr('disabled', false);
                        Documento.focus().select();
                    });
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

    function getReferencia() {
        var reffac = 0, reffac1 = 0, reffac2 = 0,
                reffac2 = Documento.val(), txtreferen2 = 0;
        var txtreferen1 = padLeft(ClienteFactura.val(), 4) + '' + padLeft(Documento.val(), 4);

        var num1 = 0, num2 = 0, num3 = 0, num4 = 0, num5 = 0,
                num6 = 0, num7 = 0, num8 = 0, num9 = 0,
                num10 = 313, num11 = 802, txtreferen3 = 0;

        for (var refe1 = 1; refe1 <= 9; refe1++) {
            txtreferen2 = txtreferen1.substr(refe1, 1);
            switch (refe1) {
                case 1:
                    num1 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 7 : 0);
                    break;
                case 2:
                    num2 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 11 : 0);
                    break;
                case 3:
                    num3 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 13 : 0);
                    break;
                case 4:
                    num4 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 17 : 0);
                    break;
                case 5:
                    num5 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 19 : 0);
                    break;
                case 6:
                    num6 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 23 : 0);
                    break;
                case 7:
                    num7 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 29 : 0);
                    break;
                case 8:
                    num8 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 31 : 0);
                    break;
                case 9:
                    num9 = ($.isNumeric(txtreferen2) ? parseInt(txtreferen2) * 37 : 0);
                    break;
            }
        }
        txtreferen3 = num1 + num2 + num3 + num4 + num5 + num6 + num7 + num8 + num9 + num10 + num11;
        btnAcepta.attr('disabled', false);
    }

    function onInHabilitarEncabezado() {
        if (ClienteFactura.val() && TPFactura.val()
                && TMNDAFactura.val() && Documento.val()
                && FechaFactura.val()) {
            ClienteFactura[0].selectize.disable();
            TPFactura[0].selectize.disable();
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
        onOpenOverlay('');
        $.getJSON('<?php print base_url('FacturacionVarios/getDocumentosXCliente'); ?>', {CLIENTE: ClienteFactura.val() ? ClienteFactura.val() : ''}).done(function (a) {
            if (a.length > 0) {
                var r = [];
                $.each(a, function (k, v) {
                    r.push([v.ID, v.CLIENTE, v.DOCTO, v.FECHA, v.TP,
                        '$' + $.number(v.IMPORTE, 2, '.', ','), v.IMPORTE,
                        '$' + $.number(v.PAGOS, 2, '.', ','), v.PAGOS,
                        (parseFloat(v.SALDO) <= 0)? '<span style="color: #689F38 !important;">$' + $.number(v.SALDO, 2, '.', ',') + '</span>':'<span class="text-danger">$' + $.number(v.SALDO, 2, '.', ',') + '</span>', v.SALDO,
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
</script>

<style> 
    .card{border: solid 1px #607D8B;}
    #tblParesFacturados tbody td{
        font-weight: bold !important;
    }
    #tblParesFacturados thead th{
        font-size: 12px !important;
    }
</style>