<div class="card m-3 animated fadeIn" id="pnlTablero" style="background-color:  #fff !important;">
    <div class="card-header" align="center" style="padding: 5px 5px 0px 5px !important;">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">

            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <h4 class="font-weight-bold font-italic text-danger">DOCUMENTOS DIRECTOS DE CLIENTES VARIOS</h4>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4" align="right">
                <button type="button" id="btnNuevo" name="btnNuevo" 
                        class="btn btn-default animated flipInX d-none" 
                        disabled="true"
                        data-toggle="tooltip" data-placement="bottom" title="Hecho" 
                        style="padding: 3px 6px 3px 6px !important;    background-color: #9e9e9e00; box-shadow: none !important; color: #9E9E9E !important; border-color: ">
                    <span class="fa fa-check fa-2x"></span>
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
            <div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4"> 
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
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-1 d-none">
                <label>L-P</label>
                <input type="text" id="LPFactura" name="LPFactura" readonly="" data-toggle="tooltip" data-placement="bottom" title="Lista de precios"  class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2">
                <label>TP</label>
                <select id="TPFactura" name="TPFactura" class="form-control form-control-sm" >
                    <option></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2">
                <label>T-MNDA</label>
                <input type="text" id="TMNDAFactura" name="TMNDAFactura" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2">
                <label>DOCTO</label>
                <input type="text" id="Documento" name="Documento" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-6 col-md-2 col-lg-4 col-xl-2"> 
                <label>Fecha</label>
                <input type="text" id="FechaFactura" name="FechaFactura" class="form-control form-control-sm date notEnter">
            </div>
        </div>
        <div class="w-100"></div>
        <div class="row">    
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label>Cantidad</label>
                <input type="number" id="Cantidad" name="Cantidad" max="2" min="0" class="form-control form-control-sm">
            </div>  
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label>Estilo</label>
                <input type="text" id="Estilo" name="Estilo" maxlength="40" minlength="0" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-3 col-xl-3" >
                <label>Concepto</label>
                <textarea rows="2" cols="2" id="Estilo" name="Estilo"  class="form-control form-control-sm">
                </textarea>
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label>Precio</label>
                <input type="number" id="Precio" name="Precio" max="99" min="0" class="form-control form-control-sm numbersOnly">
            </div>  
            <div class="col-6 col-xs-6 col-sm-3 col-md-1 col-lg-1 col-xl-1" >
                <label>Talla</label>
                <input type="text" id="Talla" name="Talla" maxlength="15" minlength="0" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label>SUBTOTAL</label>
                <span class="text-danger font-weight-bold subtotaldocvarios">$ 0.0 </span>
                <input type="text" id="Subtotal" name="Subtotal"  class="form-control form-control-sm" readonly="">
            </div>
            <div class="w-100"></div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label>Producto SAT</label>
                <span class="text-danger font-weight-bold productoSAT">-</span>
                <input type="text" id="ProductoSAT" name="ProductoSAT" class="form-control form-control-sm d-none">
            </div>
            <div class="col-6 col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label>Pedido</label> 
                <input type="text" id="Pedido" name="Pedido" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-9 col-md-8 col-lg-8 col-xl-8" >
                <label>Observaciones</label> 
                <input type="text" id="Observaciones" name="Observaciones" class="form-control form-control-sm">
            </div>

            <div class="w-100 my-1"></div>

            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <div class="form-group">
                    <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                        <input type="checkbox" class="custom-control-input selectNotEnter" id="cNoIva" name="cNoIva" style="cursor: pointer !important;">
                        <label class="custom-control-label text-danger labelCheck" for="cNoIva" style="cursor: pointer !important;">No genera I.V.A</label>
                    </div>
                </div>      
            </div>
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <div class="form-group">
                    <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                        <input type="checkbox" class="custom-control-input selectNotEnter" id="cTimbrar" name="cTimbrar" style="cursor: pointer !important;">
                        <label class="custom-control-label text-danger labelCheck" for="cNoIva" style="cursor: pointer !important;">Timbrar</label>
                    </div>
                </div>      
            </div>
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <div class="form-group">
                    <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                        <input type="checkbox" class="custom-control-input selectNotEnter" id="cPorAnticipo" name="cPorAnticipo" style="cursor: pointer !important;">
                        <label class="custom-control-label text-danger labelCheck" for="cNoIva" style="cursor: pointer !important;">Por anticipo</label>
                    </div>
                </div>      
            </div>

            <div class="w-100"></div>

            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <label>Pedimento o tax id destinatario</label>
                <input type="text" id="PedimientoXTaxDestinatario" name="PedimientoXTaxDestinatario" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-4">
            </div>
            <div class="col-6 col-xs-6 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <label>Orden de compra o clave incotem</label>
                <input type="text" id="FolioFactura" name="FolioFactura" class="form-control form-control-sm">
            </div>

            <div class="w-100 my-1"></div>

            <div id="TotalLetra" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                <span class="font-weight-bold font-italic text-danger"> - </span>
            </div> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12  my-1" align="right">
                <button type="button" id="btnAcepta" name="btnAcepta" class="btn btn-primary" disabled="">
                    <span class="fa fa-check"></span> Acepta
                </button>
            </div>

            <div class="w-100 my-2"></div>

            <!--DETALLE DE LA FACTURA-->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="center"> 
                <hr>
            </div>

            <div class="col-12 col-lg-12 col-xl-12">
                <div class="row"> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8" align="center">
                        <h4 class="font-weight-bold text-danger font-italic">
                            DOCUMENTOS DEL CLIENTE
                        </h4>
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
                            <th scope="col">Importe</th><!--5-->
                            <th scope="col">Pagos</th><!--5-->
                            <th scope="col">Saldo</th><!--5-->  
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>    
            </div> 
            <div class="col-12 col-lg-12 col-xl-12">
                <div class="row"> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8" align="center">
                        <h4 class="font-weight-bold text-danger font-italic">
                            DETALLE DE ESTE DOCTO
                        </h4>
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
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2" align="right">
                <h3 class="font-weight-bold text-danger font-italic totalfacturadopie">$ 0.0</h3>
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
            FolioFactura = pnlTablero.find('#FolioFactura'),
            btnAcepta = pnlTablero.find("#btnAcepta"),
            Hoy = '<?php print Date('d/m/Y'); ?>',
            Documentos, tblDocumentos = pnlTablero.find("#tblDocumentos"),
            DetalleDocumento, tblDetalleDocumento = pnlTablero.find("#tblDetalleDocumento");

    $(document).ready(function () {

        FechaFactura.val(Hoy);

        handleEnterDiv(pnlTablero);

        btnAcepta.click(function () {
            if (ClienteFactura.val() && TPFactura.val() && TMNDAFactura.val()
                    && Documento.val() && FechaFactura.val() && FechaFactura.val()) {

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
            Documento = tblParesFacturados.DataTable({
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
        ClienteFactura[0].selectize.focus();
    });
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