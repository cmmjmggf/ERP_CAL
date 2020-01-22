<div class="card m-3 animated fadeIn" id="pnlTablero" style="background-color:  #fff !important;">
    <div class="card-body " style="padding: 7px 10px 10px 10px;">
        <div class="row"> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7">
                <div class="row"> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                        <h5 class="text-danger font-italic"><span class="fa fa-exchange-alt"></span> APLICA DEVOLUCIONES PENDIENTES</h5>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <button type="button" style="border-color:#D8317F !important;  background-color: #D8317F !important; color: #fff !important;" id="btnPrecioEnPrice" name="btnPrecioEnPrice" class="btn btn-info btn-sm btn-price">
                            <span class="fa fa-eye"></span> PRECIO EN PRICE
                        </button> 
                    </div> 
                    <div class="w-100"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7">
                        <label>Cliente</label>
                        <div class="row">
                            <div class="col-3">
                                <input type="text" id="xClienteDevolucion" name="xClienteDevolucion" class="form-control" maxlength="12">
                            </div>
                            <div class="col-9">
                                <select id="ClienteDevolucion" name="ClienteDevolucion" class="form-control">
                                    <option></option>
                                    <?php
                                    /* YA CONTIENE LOS BLOQUEOS DE VENTA */
                                    foreach ($this->db->query("SELECT C.Clave AS CLAVE, C.RazonS AS CLIENTE, C.Zona AS ZONA, C.ListaPrecios AS LISTADEPRECIO FROM clientes AS C "
                                            . "LEFT JOIN bloqueovta AS B ON C.Clave = B.cliente "
                                            . "WHERE C.Estatus IN('ACTIVO') AND B.cliente IS NULL  OR C.Estatus IN('ACTIVO') AND B.`status` = 2 ORDER BY ABS(C.Clave) ASC;")->result() as $k => $v) {
                                        print "<option value='{$v->CLAVE}'>{$v->CLIENTE}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                        <label>Fecha</label>
                        <input type="text" id="FechaDevolucion" name="FechaDevolucion" class="form-control form-control-sm date notEnter">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-1 col-xl-1"><label>TP</label>
                        <input type="text" id="TP" name="TP" class="form-control form-control-sm numbersOnly" maxlength="1">                            
                    </div>
                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                        <label>Aplicar</label>
                        <input type="text" id="AplicaDevolucion" name="AplicaDevolucion" class="form-control form-control-sm">
                    </div>
                    <div class="col-12"></div>
                    <div class="col-12">
                        <table id="tblTallas" class="Tallas d-none">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <?php
                                    for ($i = 1; $i < 23; $i++) {
                                        if ($i < 10) {
                                            print "<td><input type=\"text\" style=\"width: 37px;\" maxlength=\"4\"  id=\"xpar0{$i}\" name=\"xpar0{$i}\" class=\"form-control form-control-sm\" readonly=\"\"></td>";
                                        } else {
                                            print "<td><input type=\"text\" style=\"width: 37px;\" maxlength=\"4\"  id=\"xpar{$i}\" name=\"xpar{$i}\" class=\"form-control form-control-sm\" readonly=\"\"></td>";
                                        }
                                    }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="w-100"></div>

                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                        <label>Precio</label>
                        <input type="text" id="Precio" name="Precio" class="form-control form-control-sm numbersOnly">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                        <div class="w-100 mt-3"></div>
                        <span class="font-weight-bold text-danger">Nota c: </span> 
                        <span class="font-weight-bold text-info notac_text" style="color: #1d1d1d !important;">- - - -</span> 
                        <input type="text" id="NotaCredito" name="NotaCredito" readonly="" class="form-control form-control-sm d-none numbersOnly">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                        <div class="w-100 mt-3"></div>
                        <span class="font-weight-bold text-danger">Control: </span> 
                        <span class="font-weight-bold text-info control_text" style="color: #1d1d1d !important;">- - - -</span>
                        <input type="text" id="Control" name="Control" readonly="" class="form-control form-control-sm numbersOnly d-none" readonly="">
                        <input type="text" id="ParesXcontrol" name="ParesXcontrol" readonly="" class="form-control form-control-sm numbersOnly d-none" readonly="">
                        <input type="text" id="Control_ID" name="Control_ID" readonly="" class="form-control form-control-sm numbersOnly d-none" readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                        <div class="w-100 mt-3"></div>
                        <span class="font-weight-bold text-danger">Estilo: </span> 
                        <span class="font-weight-bold text-info estilo_text" style="color: #1d1d1d !important;">----</span>
                        <input type="text" id="Estilo" name="Estilo"  class="form-control form-control-sm d-none" readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                        <div class="w-100 mt-3"></div>
                        <span class="font-weight-bold text-danger">Color: </span> 
                        <span class="font-weight-bold text-info color_text" style="color: #1d1d1d !important;">----</span>
                        <input type="text" id="Color" name="Color" class="form-control form-control-sm d-none" readonly="">
                        <input type="text" id="ColorT" name="ColorT" class="form-control form-control-sm d-none" readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                        <div class="w-100 mt-3"></div>
                        <span class="font-weight-bold text-danger">Serie: </span> 
                        <span class="font-weight-bold text-info serie_text" style="color: #1d1d1d !important;">----</span>
                        <input type="text" id="Serie" name="Serie" class="form-control form-control-sm d-none" readonly=""> 
                    </div>

                    <div class="w-100 my-1"></div>

                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4"> 
                        <span class="font-weight-bold text-danger">Importe factura: </span> 
                        <span class="font-weight-bold text-info importe_factura" style="color: #1d1d1d !important;">$ 0.00</span> 
                    </div>

                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4"> 
                        <span class="font-weight-bold text-danger">Saldo factura: </span> 
                        <span class="font-weight-bold text-info saldo_factura" style="color: #1d1d1d !important;">$ 0.00</span> 
                    </div>

                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4"> 
                        <span class="font-weight-bold text-danger">Importe devuelto: </span> 
                        <span class="font-weight-bold text-info importe_devuelto" style="color: #1d1d1d !important;">$ 0.00</span> 
                    </div>

                    <div class="w-100 my-1"></div>

                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4"> 
                        <span class="font-weight-bold text-danger">Saldo: </span> 
                        <span class="font-weight-bold text-info saldo_total" style="color: #1d1d1d !important;">$ 0.00</span> 
                    </div>

                    <div class="w-100 my-1"></div>

                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                        <label>IMPORTE FACTURA</label>
                        <input type="text" id="ImporteFactura" name="ImporteFactura" class="form-control form-control-sm" readonly="">
                        <p class="importe_fact">0000</p>

                        <label>SALDO FACTURA</label>
                        <input type="text" id="SaldoFactura" name="SaldoFactura" class="form-control form-control-sm" readonly="">
                        <p class="saldo_fact">0000</p>

                        <label>IMPORTE DEVUELTO</label>
                        <input type="text" id="ImporteDev" name="ImporteDev" class="form-control form-control-sm" readonly="">
                        <p class="importe_dev">0000</p>

                        <label>NUEVO SALDO</label>
                        <input type="text" id="NuevoSaldo" name="NuevoSaldo" class="form-control form-control-sm" readonly="">
                        <p class="total_dev">0000</p>
                    </div>

                    <div class="w-100 my-1"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="row">
                            <div class="col-4">
                                <button type="button" id="btnAcepta" name="btnAcepta" class="btn btn-success btn-block" disabled="">
                                    <span class="fa fa-check"></span> Acepta
                                </button>
                            </div>
                            <div class="col-4">
                                <button type="button" id="btnCierraNC" name="btnCierraNC" class="btn btn-info btn-block" disabled="">
                                    <span class="fa fa-file-code"></span> Cierra N-c
                                </button>
                            </div>
                            <div class="col-4">
                                <button type="button" id="btnPagos" name="btnPagos" class="btn btn-info btn-block selectNotEnter">
                                    <span class="fa fa-coins"></span> Pagos
                                </button>
                            </div>
                            <div class="w-100 my-1"></div>
                            <div class="col-4">
                                <button type="button" id="btnMovimientos" name="btnMovimientos" class="btn btn-info btn-block selectNotEnter">
                                    <span class="fa fa-exchange-alt"></span> Movimientos
                                </button>
                            </div>
                            <div class="col-4">
                                <button type="button" id="btnRastreoCtrlDoc" name="btnRastreoCtrlDoc" class="btn btn-info btn-block selectNotEnter">
                                    <span class="fa fa-search"></span> Rastreo ctr/doc
                                </button> 
                            </div>
                            <div class="col-4">
                                <button type="button" id="btnRastreoEstCte" name="btnRastreoEstCte" class="btn btn-info btn-block selectNotEnter">
                                    <span class="fa fa-search"></span> Rastreo est/cte
                                </button> 
                            </div>
                        </div>
                    </div>
                </div><!--ROW-->
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
                <p class="font-weight-bold text-danger">DOCUMENTADOS DE ESTE CLIENTE CON SALDO (CARTCLIENTE)</p>

                <table id="tblDocDeEsteCteConSaldo" class="table table-hover table-sm display nowrap"  style="width: 100%!important;">
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
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <p class="font-weight-bold text-danger">CONTROLES POR APLICAR DE ESTE CLIENTE (DEVOLUCIONNP)</p>
                <table id="tblDevCtrlXAplicarDeEsteCliente" class="table table-hover table-sm display nowrap"  style="width: 100%!important;">
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
                <div class="w-100">
                    <span class="font-weight-bold">*Estos controles desaparecen hasta que se facturen*</span>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 ">
                <p class="font-weight-bold text-danger">DETALLE DE LA DEVOLUCIÓN (DEVCTES)</p>
                <table id="tblDevolucionDetalle" class="table table-hover table-sm display nowrap"  style="width: 100%!important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Cte</th><!--1-->
                            <th scope="col">Docto</th><!--2-->

                            <th scope="col">Aplica</th><!--3-->
                            <th scope="col">N-C</th><!--4-->
                            <th scope="col">Control</th><!--5-->

                            <th scope="col">Pares</th><!--6-->
                            <th scope="col">Precio</th><!--6-->
                            <th scope="col">Total</th><!--6-->

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
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>

                            <td></td>
                            <td></td>
                            <td></td>

                            <td></td>
                            <td></td>
                            <td></td>

                            <td></td>
                            <td></td>
                            <td></td>

                            <td></td>
                            <td></td>
                            <td></td>

                            <td></td> 
                        </tr>
                    </tfoot>
                </table>
                <div class="col-12">
                    <button type="button" id="btnRefrescarDEVCTES" name="btnRefrescarDEVCTES" class="btn btn-warning btn-sm">
                        <span class="fa fa-retweet"></span>
                    </button>
                </div>
            </div>
            <div class="col-12">
                <p class="total_en_letra text-danger font-italic font-weight-bold">-</p>
            </div>
        </div>
    </div>
</div>

<script>
    var pnlTablero = $("#pnlTablero"), xClienteDevolucion = pnlTablero.find('#xClienteDevolucion'),
            ClienteDevolucion = pnlTablero.find('#ClienteDevolucion'),
            FechaDevolucion = pnlTablero.find('#FechaDevolucion'),
            TP = pnlTablero.find('#TP'),
            AplicaDevolucion = pnlTablero.find('#AplicaDevolucion'),
            Precio = pnlTablero.find('#Precio'),
            NotaCredito = pnlTablero.find('#NotaCredito'),
            Control = pnlTablero.find('#Control'),
            ParesXcontrol = pnlTablero.find('#ParesXcontrol'),
            Estilo = pnlTablero.find('#Estilo'),
            Color = pnlTablero.find('#Color'), ColorT = pnlTablero.find('#ColorT'),
            Serie = pnlTablero.find('#Serie'),
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
            btnRastreoEstCte = pnlTablero.find("#btnRastreoEstCte"),
            documento_dtm, devolucion_dtm, btnPrecioEnPrice = pnlTablero.find("#btnPrecioEnPrice"),
            btnRefrescarDEVCTES = pnlTablero.find("#btnRefrescarDEVCTES"),
            nuevo = true;

    $(document).ready(function () {

        handleEnterDiv(pnlTablero);

        btnRefrescarDEVCTES.click(function () {
            DevolucionDetalle.ajax.reload();
        });

        btnPrecioEnPrice.click(function () {
            onOpenWindowAFC("http://proveedores.priceshoes.com/", function () {
                Precio.focus().select();
            });
        });

        ClienteDevolucion.change(function () {
            if (ClienteDevolucion.val()) {
                xClienteDevolucion.val(ClienteDevolucion.val());
                ClienteDevolucion[0].selectize.disable();
                FechaDevolucion.focus();
            } else {
                xClienteDevolucion.val('');
                ClienteDevolucion[0].selectize.enable();
                ClienteDevolucion[0].selectize.clear(true);
            }
            DocDeEsteCteConSaldo.ajax.reload();
            DevCtrlXAplicarDeEsteCliente.ajax.reload();
            DevolucionDetalle.ajax.reload();
        });

        xClienteDevolucion.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xClienteDevolucion.val()) {
                    ClienteDevolucion[0].selectize.setValue(xClienteDevolucion.val());
                    if (ClienteDevolucion.val()) {
                        ClienteDevolucion[0].selectize.disable();
                    } else {
                        onCampoInvalido(pnlTablero, 'NO EXISTE ESTE CLIENTE, ESPECIFIQUE OTRO', function () {
                            xClienteDevolucion.focus().select();
                        });
                    }
                } else {
                    ClienteDevolucion[0].selectize.enable();
                    ClienteDevolucion[0].selectize.clear(true);
                }
            } else {
                ClienteDevolucion[0].selectize.enable();
                ClienteDevolucion[0].selectize.clear(true);
            }
        });

        btnCierraNC.click(function () {
            onEnable(xClienteDevolucion);
            onEnable(ClienteDevolucion);
            onReadAndWrite(FechaDevolucion);
            onReadAndWrite(AplicaDevolucion);
            onEnable(TP);
            getTotal();
            btnCierraNC.attr('disabled', true);

            pnlTablero.find("input,textarea").attr('disabled', false);
            $.each(pnlTablero.find("select:disabled"), function (k, v) {
                $(v)[0].selectize.enable();
            });
            var p = {
                CLIENTE: ClienteDevolucion.val(),
                DOCUMENTO: AplicaDevolucion.val(),
                APLICA: AplicaDevolucion.val(),
                NC: NotaCredito.val(),
                TP: TP.val(),
                FECHA: FechaDevolucion.val(),
                CONTROL: Control.val(),
                ESTILO: Estilo.val(),
                COLOR: Color.val(),
                SERIE: Serie.val(),
                PRECIO: Precio.val(),
                TOTAL_EN_LETRA: pnlTablero.find(".total_en_letra").text()
            };

            $.post('<?php print base_url('AplicaDevolucionesDeClientes/onCerrarNC'); ?>', p).done(function (aaa) {
                console.log(aaa);
                onImprimirReporteFancyAFC(aaa, function (a, b) {
                    nuevo = true;
                    pnlTablero.find("input").val('');
                    $.each(pnlTablero.find("select"), function (k, v) {
                        pnlTablero.find("select")[k].selectize.clear(true);
                    });
                    xClienteDevolucion.focus().select();

                });
            }).fail(function (x) {
                getError(x);
            }).always(function () {
                btnCierraNC.attr('disabled', false);
            });
        });


        btnAcepta.click(function () {
            onDisable(btnAcepta);
            onEnable(xClienteDevolucion);
            onEnable(ClienteDevolucion);
            onReadAndWrite(FechaDevolucion);
            onReadAndWrite(AplicaDevolucion);
            onEnable(TP);
            if (Precio.val() && pnlTablero.find("#Control_ID").val()) {
                var p = {
                    IDX: pnlTablero.find("#Control_ID").val(),
                    CLIENTE: ClienteDevolucion.val(),
                    DOCUMENTO: AplicaDevolucion.val(),
                    APLICA: AplicaDevolucion.val(),
                    NC: NotaCredito.val(),
                    TP: TP.val(),
                    FECHA: FechaDevolucion.val(),
                    CONTROL: Control.val(),
                    PARES: ParesXcontrol.val(),
                    ESTILO: Estilo.val(),
                    COLOR: Color.val(),
                    SERIE: Serie.val(),
                    PRECIO: Precio.val(),
                    TOTAL_EN_LETRA: pnlTablero.find(".total_en_letra").text()
                };

                for (var i = 1; i < 23; i++) {
                    if (i < 10) {
                        p["PAR" + i] = pnlTablero.find("#xpar0" + i).val();
                    } else {
                        p["PAR" + i] = pnlTablero.find("#xpar" + i).val();
                    }
                }

                if (nuevo) {
                    console.log("PARAMETROS => ", p);
                    $.post('<?php print base_url('AplicaDevolucionesDeClientes/onGuardarNC'); ?>', p).done(function (aaa) {
                        console.log(aaa);
                        nuevo = false;
                        DevolucionDetalle.ajax.reload();
                        onNotifyOld('', 'SE HAN GUARDADO LOS CAMBIOS', 'success');
                        onDisable(ClienteDevolucion);
                        FechaDevolucion.attr("readonly", true);
                        AplicaDevolucion.attr("readonly", true);
                        onDisable(TP);
                        tblDevCtrlXAplicarDeEsteCliente.parent().removeClass("blinkb");
                        DevCtrlXAplicarDeEsteCliente.ajax.reload(function () {
                            onEnable(btnCierraNC);
                        });
                        getTotal();
                        Precio.val('');
                        Precio.focus().select();
                        pnlTablero.find("#Control_ID").val('');
                        ParesXcontrol.val(0);
                        onEnable(btnAcepta);
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                    });
                } else {
                    $.post('<?php print base_url('AplicaDevolucionesDeClientes/onGuardarNC'); ?>', p).done(function (aaa) {
                        console.log(aaa);
                        nuevo = false;
                        DevolucionDetalle.ajax.reload();
                        onNotifyOldPC('<span class="fa fa-check"></span>', 'SE HAN GUARDADO LOS CAMBIOS', 'warning', {from: "bottom", align: "center"});
                        onDisable(ClienteDevolucion);
                        FechaDevolucion.attr("readonly", true);
                        AplicaDevolucion.attr("readonly", true);
                        onDisable(TP);
                        tblDevCtrlXAplicarDeEsteCliente.parent().removeClass("blinkb");
                        DevCtrlXAplicarDeEsteCliente.ajax.reload(function () {
                            onEnable(btnCierraNC);
                        });
                        getTotal();
                        Precio.val('');
                        Precio.focus().select();
                        pnlTablero.find("#Control_ID").val('');
                        ParesXcontrol.val(0);
                        onEnable(btnAcepta);
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                    });
                }
            } else {
                onCampoInvalido(pnlTablero, "DEBE DE ESPECIFICAR UN PRECIO Y UN REGISTRO", function () {
                    Precio.focus().select();
                    onEnable(btnAcepta);
                });
            }
        });

        TP.change(function () {
            tblDocDeEsteCteConSaldo.parent().addClass("blinkb");
        });

        TP.keydown(function (e) {
            if (xClienteDevolucion.val()) {
                if (e.keyCode === 13 && parseInt(TP.val()) >= 1 && parseInt(TP.val()) <= 2) {

                } else if (e.keyCode === 13 || e.keyCode === 9) {
                    TP.focus().select();
                    onCampoInvalido(pnlTablero, "SOLO SE PERMITE 1 Y 2", function () {
                        TP.focus().select();
                    });
                    return;
                }
            } else {
                onCampoInvalido(pnlTablero, "DEBE DE ESPECIFICAR UN CLIENTE", function () {
                    xClienteDevolucion.focus().select();
                });
                return;
            }
        }).focusout(function () {
            if (xClienteDevolucion.val()) {
                if (parseInt(TP.val()) >= 1 && parseInt(TP.val()) <= 2) {

                } else {
                    TP.focus().select();
                    onCampoInvalido(pnlTablero, "SOLO SE PERMITE 1 Y 2", function () {
                        TP.focus().select();
                    });
                    return;
                }
            } else {
                onCampoInvalido(pnlTablero, "DEBE DE ESPECIFICAR UN CLIENTE", function () {
                    xClienteDevolucion.focus().select();
                });
                return;
            }
        });

        AplicaDevolucion.on('keydown', function (e) {
            if (e.keyCode === 13 && $(this).val() && ClienteDevolucion.val()) {
                onComprobarFacturaXCliente($(this).val());
            }
            if (e.keyCode === 13) {
                DevolucionDetalle.ajax.reload();
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
        xClienteDevolucion.focus();
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
            "scrollY": 200,
            "scrollX": true,
            "order": [[3, "desc"]],
            "initComplete": function (settings, json) {
            }
        });

        tblDocDeEsteCteConSaldo.find('tbody').on('click', 'tr', function () {
            var dtm = DocDeEsteCteConSaldo.row(this).data();
            getImporteSaldoXDocumento(dtm);
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
                {"data": "PREDVT"}, {"data": "PRECG"}
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
            "scrollY": 200,
            "scrollX": true,
            "order": [[10, "desc"]],
            "initComplete": function (settings, json) {
            }
        });

        tblDevCtrlXAplicarDeEsteCliente.find('tbody').on('click', 'tr', function () {
            var dtm = DevCtrlXAplicarDeEsteCliente.row(this).data();
            if (ClienteDevolucion.val()) {
                pnlTablero.find("#Control_ID").val(dtm.ID);
                ParesXcontrol.val(dtm.PARES);
                getInfoXControl(dtm);
            } else {
                onCampoInvalido(pnlTablero, 'ES NECESARIO ESPECIFICAR UN CLIENTE', function () {
                    xClienteDevolucion.focus().select();
                    DevCtrlXAplicarDeEsteCliente.rows('.important').deselect();
                });
            }
        });

        DevolucionDetalle = tblDevolucionDetalle.DataTable({
            dom: 'rtp',
            "ajax": {
                "url": '<?php print base_url('AplicaDevolucionesDeClientes/getDetalleDevolucion'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = ClienteDevolucion.val() ? ClienteDevolucion.val() : '';
                    d.APLICAR = AplicaDevolucion.val() ? AplicaDevolucion.val() : '';
                    d.NC = NotaCredito.val() ? NotaCredito.val() : '';
                }
            },
            "columns": [
                {"data": "ID"}, {"data": "CLIENTE"},
                {"data": "DOCUMENTO"}, {"data": "APLICA"},
                {"data": "NC"}, {"data": "CONTROL"},
                {"data": "PARES"}, {"data": "PRECIO"}, {"data": "TOTAL"}, {"data": "DEFECTOS"},
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
            "scrollY": 200,
            "scrollX": true,
            "order": [[11, "desc"]],
            responsive: {
                orthogonal: 'responsive'
            },
            "drawCallback": function (settings) {
                var api = this.api();
                var prs = 0, stt = 0.0;
                console.log(api.rows().data());
                $.each(api.rows().data(), function (k, v) {
                    prs += parseFloat(v.PARES);
                    stt += parseFloat(v.TOTAL);
                });
                $(api.column(6).footer()).html(
                        '<span class="font-weight-bold">' + prs + ' pares</span>');
                $(api.column(8).footer()).html(
                        '<span class="font-weight-bold">$' +
                        $.number(stt, 2, '.', ',') + '</span>');
            }
        });

    });

    function onComprobarFacturaXCliente(f) {
        $.getJSON('<?php print base_url('AplicaDevolucionesDeClientes/onComprobarFacturaXCliente'); ?>', {
            CLIENTE: ClienteDevolucion.val(),
            DOCUMENTO: f,
            TP: TP.val() ? TP.val() : ''
        }).done(function (aaa) {
            console.log(aaa);
            if (aaa.length <= 0) {
                onBeep(2);
                onCampoInvalido(pnlTablero, 'ESTE DOCUMENTO NO PERTENECE A ESTE CLIENTE O NO EXISTE, INTENTE CON OTRO NUMERO DE DOCUMENTO', function () {
                    AplicaDevolucion.focus().select();
                });
            } else {
                $.getJSON('<?php print base_url('AplicaDevolucionesDeClientes/getDocumentadosDeEsteClienteConSaldoXDocumento') ?>', {
                    CLIENTE: ClienteDevolucion.val() ? ClienteDevolucion.val() : '',
                    DOCUMENTO: AplicaDevolucion.val() ? AplicaDevolucion.val() : '',
                    TP: TP.val() ? TP.val() : ''
                }).done(function (dtm) {
                    getImporteSaldoXDocumento(dtm[0]);
                }).fail(function (x) {
                    getError(x);
                }).always(function () {

                });
            }
        }).fail(function (x) {
            getError(x);
        });
    }

    function getUltimaNC() {
        $.getJSON('<?php print base_url('AplicaDevolucionesDeClientes/getUltimaNC'); ?>', {TP: TP.val()}).done(function (aaa) {
            console.log(aaa, aaa.length, aaa[0].NCU);
            NotaCredito.val(aaa[0].NCU);
            pnlTablero.find(".notac_text").text(aaa[0].NCU);
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }

    function getInfoXControl(dtm) {

        $.getJSON('<?php print base_url('AplicaDevolucionesDeClientes/getInfoXControl'); ?>', {
            IDX: dtm.ID,
            CONTROL: dtm.CONTROL,
            PARES: dtm.PARES
        }).done(function (aaa) {
            if (aaa.length > 0) {
                console.log(dtm);
                Precio.val(dtm.PREDV);
                Control.val(dtm.CONTROL);

                var z = aaa[0];
                Estilo.val(z.ESTILO);
                Color.val(z.COLOR);
                ColorT.val(z.COLOR_TEXT);
                Serie.val(z.SERIE);
                pnlTablero.find(".control_text").text(dtm.CONTROL);
                pnlTablero.find(".estilo_text").text(z.ESTILO);
                pnlTablero.find(".color_text").text(z.COLOR);
                pnlTablero.find(".serie_text").text(z.SERIE);

                var idv = dtm.PREDV * dtm.PARES;
                var total_final = pnlTablero.find("#SaldoFactura").val() - idv;

                if (total_final < 0) {
                    onBeep(2);
                    onCampoInvalido(pnlTablero,
                            'LA DEVOLUCIÓN SOBREPASA EL SALDO DEL DOCUMENTO CARGADO, SELECCIONE OTRA DEVOLUCIÓN', function () {
                                pnlTablero.find("#ImporteDev").val(0);
                                pnlTablero.find(".importe_dev").text('0');
                                pnlTablero.find(".importe_devuelto").text('0');
                                pnlTablero.find("#NuevoSaldo").val(0);
                                DevCtrlXAplicarDeEsteCliente.rows().deselect();
                                tblDevCtrlXAplicarDeEsteCliente.parent().addClass("blinkb");
                            });
                } else {
                    onBeep(1);
                    pnlTablero.find("#ImporteDev").val(idv);
                    pnlTablero.find(".importe_dev").text(idv);
                    pnlTablero.find(".importe_devuelto").text(idv);
                    pnlTablero.find(".saldo_total").text(total_final);
                    pnlTablero.find("#NuevoSaldo").val(total_final);
                    var pp = {
                        CLIENTE: ClienteDevolucion.val(),
                        NC: NotaCredito.val()
                    };
                    $.post('<?php print base_url('AplicaDevolucionesDeClientes/onObtenerSaldoXDevolucionDocumentoNC') ?>', pp).done(function (aaa) {
                        console.log(aaa);
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {

                    });

                    btnAcepta.attr('disabled', false);
                    console.log("PAR0 => " + z["par01"]);
                    for (var i = 1; i < 23; i++) {
                        if (i < 10) {
                            pnlTablero.find("#xpar0" + i).val(z["par0" + i]);
                        } else {
                            pnlTablero.find("#xpar" + i).val(z["par" + i]);
                        }
                    }
                    devolucion_dtm = dtm;
                    tblDevCtrlXAplicarDeEsteCliente.parent().removeClass("blinkb");
                    Precio.focus().select();
                }
            }
        }).fail(function (x) {
            getError(x);
        });
    }

    function getImporteSaldoXDocumento(dtm) {
        onBeep(1);
        if (nuevo) {
            if (ClienteDevolucion.val()) {
                AplicaDevolucion.val(dtm.DOCUMENTO);
                documento_dtm = dtm;
                pnlTablero.find("#ImporteFactura").val(dtm.IMPORTE);
                pnlTablero.find(".importe_fact").text(dtm.IMPORTE);
                pnlTablero.find(".importe_factura").text(dtm.IMPORTE);
                pnlTablero.find("#SaldoFactura").val(dtm.SALDO);
                pnlTablero.find(".saldo_fact").text(dtm.SALDO);
                pnlTablero.find(".saldo_factura").text(dtm.SALDO);

                getUltimaNC();
                /* BLINK */
                tblDocDeEsteCteConSaldo.parent().removeClass("blinkb");
                tblDevCtrlXAplicarDeEsteCliente.parent().addClass("blinkb");
            } else {
                onCampoInvalido(pnlTablero, 'ES NECESARIO ESPECIFICAR UN CLIENTE', function () {
                    DocDeEsteCteConSaldo.rows('.important').deselect();
                    xClienteDevolucion.focus().select();
                });
            }
        }
    }

    function getTotal() {
        var p = {
            CLIENTE: ClienteDevolucion.val(),
            NC: NotaCredito.val()
        };
        $.getJSON('<?php print base_url('AplicaDevolucionesDeClientes/getTotal'); ?>', p).done(function (xxx) {
            console.log(xxx);
            console.log(NumeroALetras(xxx[0].TOTAL));
            pnlTablero.find(".total_en_letra").text(NumeroALetras(xxx[0].TOTAL * 1.16));
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }
</script>
<style>
    .blinkb{ 
        border: 2px solid #ffffff;
        border-radius: 5px;
        -webkit-animation: myfirst 1.5s linear 0.5s infinite alternate; /* Safari 4.0 - 8.0 */
        animation: myfirst 1.5s linear 0.5s infinite alternate;    
        box-shadow: 0 0px 12px  #03A9F4;
    }

    /* Safari 4.0 - 8.0 */
    @-webkit-keyframes myfirst { 
        25%  { 
            border-color:  #007bff; 
        }
        50%  {  
            border-color:  #ffffff; 
        }
        75%  {  
            border-color:  #007bff; 
        }
        100% {  
            border-color:  #ffffff; 
        }
    }

    /* Standard syntax */
    @keyframes myfirst {
        0%   { 
            border-color:  #007bff; 
        }
        25%  { 
            border-color:  #ffffff; 
        }
        50%  { 
            border-color:  #007bff; 
        }
        75%  {
            border-color:  #ffffff; 
        }
        100% {
            border-color:  #007bff; 
        }
    }
    .btn-success {
        color: #fff;
        background-color: #7CB342;
        border-color: #7CB342;
    }
    .btn-success.disabled, .btn-success:disabled {
        color: #fff;
        background-color: #59802F;
        border-color: #59802F;
    }
    .btn-price:not(:disabled):not(.disabled):active, .btn-price:not(:disabled):not(.disabled).active, .show > .btn-price.dropdown-toggle {
        color: #fff;
        background-color: #AC205F;
        border-color: #AC205F;
    }
</style>
