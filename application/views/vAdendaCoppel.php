<div class="modal fade" id="mdlAddendaCoppel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg notdraggable" role="document" style="min-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="fa fa-file-archive"></span> Prepara Addenda Coppel
                </h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label>Tienda</label>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" id="xTiendaCoppel" name="xTiendaCoppel" class="form-control form-control-sm numbersOnly" maxlength="5">
                            </div>
                            <div class="col-8">
                                <select id="TiendaCoppel" name="TiendaCoppel" class="form-control form-control-sm">
                                    <option></option>
                                    <?php
                                    $data = $this->db->query("SELECT numtda, nomtda, dirtda, numetda, numitda, coltda, ciutda, edotda, teltda1, teltda2, teltda3, coptda, tpprov, provee FROM tiendas AS T ORDER BY ABS(T.numtda) ASC ")->result();
                                    foreach ($data as $k => $v) {
                                        print "<option value='{$v->numtda}'>{$v->nomtda}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-none">
                        <table id="tblTiendas" class="table table-hover table-sm table-responsive d-none" style="height: 150px !important;">
                            <thead>
                                <tr>
                                    <th scope="col">numtda</th><th scope="col">nomtda</th>
                                    <th scope="col">dirtda</th><th scope="col">numetda</th>
                                    <th scope="col">numitda</th><th scope="col">coltda</th>
                                    <th scope="col">ciutda</th><th scope="col">edotda</th>
                                    <th scope="col">teltda1</th><th scope="col">teltda2</th>
                                    <th scope="col">teltda3</th><th scope="col">coptda</th>
                                    <th scope="col">tpprov</th><th scope="col">provee</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php
                                foreach ($data as $k => $v) {
                                    $row = "<tr>"
                                            . "<td>{$v->numtda}</td>" . "<td th scope=\"row\">{$v->nomtda}</td>"
                                            . "<td>{$v->dirtda}</td>" . "<td>{$v->numetda}</td>"
                                            . "<td>{$v->numitda}</td>";
                                    $row .= "<td>{$v->coltda}</td>";
                                    $row .= "<td>{$v->ciutda}</td>";
                                    $row .= "<td>{$v->edotda}</td>";
                                    $row .= "<td>{$v->teltda1}</td>";
                                    $row .= "<td>{$v->teltda2}</td>";
                                    $row .= "<td>{$v->teltda3}</td>";
                                    $row .= "<td>{$v->coptda}</td>";
                                    $row .= "<td>{$v->tpprov}</td>";
                                    $row .= "<td>{$v->provee}</td>";
                                    $row .= "</tr>";
                                    print $row;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-2">
                        <label>Factura</label>
                        <input type="text" id="FacturaCoppel" name="FacturaCoppel" class="form-control form-control-sm">
                    </div>
                    <div class="col-2">
                        <label>Fecha</label>
                        <input type="text" id="FechaFacturaCoppel" name="FechaFacturaCoppel" readonly="" class="form-control date notEnter form-control-sm solo_de_lectura">
                        <input type="text" id="FechaPedidoCoppel" name="FechaPedidoCoppel" readonly="" class="form-control date notEnter form-control-sm solo_de_lectura d-none">
                    </div>
                    <div class="col-2">
                        <label>Pedido</label>
                        <input type="text" id="PedidoCoppel" name="PedidoCoppel" class="form-control form-control-sm">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-4">
                        <label>Proveedor</label>
                        <input type="text" id="CoppelProveedor" name="CoppelProveedor" class="form-control form-control-sm">
                    </div>
                    <div class="col-2">
                        <label>T-Provee</label>
                        <input type="text" id="TProveedor" name="TProveedor" class="form-control form-control-sm">
                    </div>
                    <div class="col-3">
                        <label>N.Bodega</label>
                        <input type="text" id="NBodega" name="NBodega" class="form-control form-control-sm solo_de_lectura">
                    </div>
                    <div class="col-3">
                        <label>Direccion</label>
                        <input type="text" id="DireccionBodega" name="DireccionBodega" class="form-control form-control-sm solo_de_lectura">
                    </div>
                    <div class="w-100"></div> 
                    <div class="col-4">
                        <label>Ciudad</label>
                        <input type="text" id="CiudadTiendaCoppel" name="CiudadTiendaCoppel" class="form-control form-control-sm solo_de_lectura">
                    </div>
                    <div class="col-2">
                        <label>Código Postal</label>
                        <input type="text" id="CodigoPostalTienda" name="CodigoPostalTienda" class="form-control form-control-sm numbersOnly solo_de_lectura">
                    </div>
                    <div class="col-2">
                        <label>No.Bodega</label>
                        <input type="text" id="NoBodegaCoppel" name="NoBodegaCoppel" class="form-control form-control-sm">
                    </div> 
                    <div class="col-2">
                        <label>C.Lotes</label>
                        <input type="text" id="CantidadLotes" name="CantidadLotes" class="form-control form-control-sm numbersOnly">
                    </div>
                    <div class="col-2">
                        <label>CantidadPrepack</label>
                        <input type="text" id="CantidadPrepack" name="CantidadPrepack" class="form-control form-control-sm numbersOnly">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-2">
                        <label>Importe</label>
                        <input type="text" id="ImporteAddenda" name="ImporteAddenda" class="form-control form-control-sm numbersOnly numericdot solo_de_lectura" readonly="">
                    </div>
                    <div class="col-2">
                        <label>Descuento</label>
                        <input type="text" id="DescuentoAddenda" name="DescuentoAddenda" class="form-control form-control-sm numbersOnly numericdot solo_de_lectura" readonly="">
                    </div>
                    <div class="col-3">
                        <label>Subtotal</label>
                        <input type="text" id="SubtotalAddenda" name="SubtotalAddenda" class="form-control form-control-sm numbersOnly numericdot solo_de_lectura" readonly="">
                    </div>
                    <div class="col-2">
                        <label>I.V.A</label>
                        <input type="text" id="IVAAddenda" name="IVAAddenda" class="form-control form-control-sm numbersOnly numericdot solo_de_lectura" readonly="">
                    </div>
                    <div class="col-3">
                        <label>TOTAL</label>
                        <input type="text" id="TotalAddenda" name="TotalAddenda" class="form-control form-control-sm numbersOnly numericdot solo_de_lectura" readonly="">
                    </div>
                    <div class="col-12 mt-2" align="right">
                        <button type="button" id="btnAceptaAddendaCoppel" name="btnAceptaAddendaCoppel" class="btn btn-info btn-sm">
                            <span class="fa fa-check"></span> Acepta
                        </button>
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-12">
                        <table id="tblAddendasCoppel" 
                               class="table table-hover table-sm nowrap" 
                               style="width: 100% !important;">
                            <thead>
                                <tr> 
                                    <th>FACTURA</th>
                                    <th>R.SOC</th>
                                    <th>EST.CTE</th>
                                    <th>TALLA</th>
                                    <th>EST.4E</th>

                                    <th>PARES</th>
                                    <th>PRECIO</th>
                                    <th>PRECIO.DES</th>
                                    <th>CANTIDAD</th>
                                    <th>%DECTO</th>

                                    <th>MON.DESCTO</th>
                                    <th>TOTAL</th>
                                    <th>TOTAL.CON.DESCUENTO</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>

                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>

                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnCerrarModalAdenda" type="button" class="btn btn-secondary"   style="background-color: #000; border-color: #000;">
                    <span class="fa fa-times"></span> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    var mdlAddendaCoppel = $("#mdlAddendaCoppel"), Tiendas,
            tblTiendas = mdlAddendaCoppel.find("#tblTiendas"), AddendasCoppel,
            tblAddendasCoppel = mdlAddendaCoppel.find("#tblAddendasCoppel"),
            xTiendaCoppel = mdlAddendaCoppel.find("#xTiendaCoppel"),
            TiendaCoppel = mdlAddendaCoppel.find("#TiendaCoppel"),
            FacturaCoppel = mdlAddendaCoppel.find("#FacturaCoppel"),
            FechaFacturaCoppel = mdlAddendaCoppel.find("#FechaFacturaCoppel"),
            FechaPedidoCoppel = mdlAddendaCoppel.find("#FechaPedidoCoppel"),
            ImporteAddenda = mdlAddendaCoppel.find("#ImporteAddenda"),
            SubtotalAddenda = mdlAddendaCoppel.find("#SubtotalAddenda"),
            DescuentoAddenda = mdlAddendaCoppel.find("#DescuentoAddenda"),
            IVAAddenda = mdlAddendaCoppel.find("#IVAAddenda"),
            TotalAddenda = mdlAddendaCoppel.find("#TotalAddenda"),
            PedidoCoppel = mdlAddendaCoppel.find("#PedidoCoppel"),
            NoBodegaCoppel = mdlAddendaCoppel.find("#NoBodegaCoppel"),
            CantidadLotes = mdlAddendaCoppel.find("#CantidadLotes"),
            CantidadPrepack = mdlAddendaCoppel.find("#CantidadPrepack"),
            CoppelProveedor = mdlAddendaCoppel.find("#CoppelProveedor"),
            DireccionBodega = mdlAddendaCoppel.find("#DireccionBodega"),
            CiudadTiendaCoppel = mdlAddendaCoppel.find("#CiudadTiendaCoppel"),
            CodigoPostalTienda = mdlAddendaCoppel.find("#CodigoPostalTienda"),
            TProveedor = mdlAddendaCoppel.find("#TProveedor"),
            NBodega = mdlAddendaCoppel.find("#NBodega"),
            btnAceptaAddendaCoppel = mdlAddendaCoppel.find("#btnAceptaAddendaCoppel"),
            btnCerrarModalAdenda = mdlAddendaCoppel.find("#btnCerrarModalAdenda");

    $(document).ready(function () {

        /*INICIO MODAL ADDENDA*/

        handleEnterDiv(mdlAddendaCoppel);

        btnCerrarModalAdenda.click(function () {
            if (xTiendaCoppel.val() || FacturaCoppel.val() || NoBodegaCoppel.val() || CantidadLotes.val() ||
                    CantidadPrepack.val()) {
                swal({
                    title: "¿ESTAS SEGURO?",
                    text: "SEGURO QUE DESEAS SALIR.",
                    icon: "warning",
                    buttons: {
                        cancelar: {
                            text: "CANCELAR",
                            value: 0
                        },
                        cambiar: {
                            text: "SALIR DE TODAS FORMAS",
                            value: 1
                        }
                    }
                }).then((value) => {
                    switch (value) {
                        case 0:
                            swal.close();
                            break;
                        case 1:
                            mdlAddendaCoppel.modal('hide');
                            break;
                    }
                });
            } else {
                mdlAddendaCoppel.modal('hide');
            }
        });

        btnAceptaAddendaCoppel.click(function () {
            if (xTiendaCoppel.val() && FacturaCoppel.val() && CoppelProveedor.val()
                    && TProveedor.val() && PedidoCoppel.val() && NoBodegaCoppel.val()
                    && CantidadLotes.val() && CantidadPrepack.val()) {
                onOpenOverlay('Espere...');
                onEnable(TiendaCoppel);
                var p = {
                    TIENDA: TiendaCoppel.val(),
                    FACTURA: FacturaCoppel.val(),
                    FECHA_FACTURA: FechaFacturaCoppel.val(),
                    FECHA_PEDIDO: FechaPedidoCoppel.val(),
                    PEDIDO: PedidoCoppel.val(),
                    NO_BODEGA: NoBodegaCoppel.val(),
                    CANTIDAD_LOTES: CantidadLotes.val(),
                    CANTIDAD_PREPACK: CantidadPrepack.val(),
                    IMPORTE: ImporteAddenda.val(),
                    DESCUENTO: DescuentoAddenda.val(),
                    SUBTOTAL: SubtotalAddenda.val(),
                    IVA: IVAAddenda.val(),
                    TOTAL: TotalAddenda.val(),
                };
                $.post('<?php print base_url('AdendaCoppel/onGuardar'); ?>', p).done(function (a) {
                    onCloseOverlay();
                    console.log(a);
                    swal({
                        title: "ATENCIÓN",
                        text: "SE HAN GENERADO LA ADENDA",
                        icon: "success",
                        buttons: false,
                        timer: 2000
                    }).then((action) => {
                        onResetAdendaCoppel();
                    });
                }).fail(function (x) {
                    onCloseOverlay();
                    getError(x);
                }).always(function () {

                });
            } else {
                onCloseOverlay();
                onCampoInvalido(mdlAddendaCoppel, "ES NECESARIO ESPECIFICAR TODOS LOS CAMPOS: \n # DE TIENDA \n # DE FACTURA \n # DE BODEGA \n CANTIDAD DE LOTES \n CANTIDAD PREPACK", function () {
                    if (!xTiendaCoppel.val()) {
                        xTiendaCoppel.focus().select();
                        return;
                    }
                    if (!FacturaCoppel.val()) {
                        FacturaCoppel.focus().select();
                        return;
                    }
                    if (!CoppelProveedor.val()) {
                        CoppelProveedor.focus().select();
                        return;
                    }
                    if (!TProveedor.val()) {
                        TProveedor.focus().select();
                        return;
                    }
                    if (!NoBodegaCoppel.val()) {
                        NoBodegaCoppel.focus().select();
                        return;
                    }
                    if (!CantidadLotes.val()) {
                        CantidadLotes.focus().select();
                        return;
                    }
                    if (!CantidadPrepack.val()) {
                        CantidadPrepack.focus().select();
                        return;
                    }
                });
            }
        });

        FacturaCoppel.on('keydown', function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                onOpenOverlay('Espere un momento por favor...');
                onComprobarFacturaTiendaCoppel();
            }
        });

        TiendaCoppel.change(function () {
            var tienda = $(this).val();
            if (tienda) {
                xTiendaCoppel.val(tienda);
            }
        });

        xTiendaCoppel.on('keydown keyup', function (e) {
            var tcp = $(this).val();
            if (e.keyCode === 13 && tcp) {
                var index = 0;
                $.each(mdlAddendaCoppel.find("#tblTiendas tbody tr"), function (k, v) {
                    var nmtda = $(v).find("td");
                    if ($(nmtda).eq(0).text() === tcp) {
                        console.log(v);
                        var r = nmtda;
                        TiendaCoppel[0].selectize.setValue(r.eq(0).text());
                        if (TiendaCoppel.val()) {
                            onDisable(TiendaCoppel);
                        } else {
                            onEnable(TiendaCoppel);
                        }
                        CoppelProveedor.val(r.eq(13).text());
                        DireccionBodega.val(r.eq(2).text());
                        CiudadTiendaCoppel.val(r.eq(6).text());
                        CodigoPostalTienda.val(r.eq(11).text());
                        TProveedor.val(r.eq(12).text());
                        NBodega.val(r.eq(1).text());
                        FacturaCoppel.focus().select();
                        index = 1;

                        AddendasCoppel.ajax.reload(function () {
                            mdlAddendaCoppel.find("input:not(#CoppelProveedor):not(#TProveedor):not(.solo_de_lectura)").attr('readonly', false);
                            FacturaCoppel.focus().select();
                        });
                        NoBodegaCoppel.val(xTiendaCoppel.val());
                        onEnable(btnAceptaAddendaCoppel);
                        return false;
                    } else {
                        index = 0;
                    }
                });
                if (index <= 0) {
                    onDisable(TiendaCoppel);
                    onClearInputs(mdlAddendaCoppel);
                    onClearSelects(mdlAddendaCoppel);
                    if (tcp !== '') {
                        onDisable(TiendaCoppel);
                        onCampoInvalido(mdlAddendaCoppel, "TIENDA INEXISTENTE", function () {
                            xTiendaCoppel.focus().select();
                        });
                    }
                }
            }
            if (xTiendaCoppel.val() && FacturaCoppel.val()) {
                onComprobarFacturaTiendaCoppel();
            }
            if (xTiendaCoppel.val() === '' ||
                    e.keyCode === 8 && xTiendaCoppel.val() === '') {
                onDisable(btnAceptaAddendaCoppel);
                onClearInputs(mdlAddendaCoppel);
                onClearSelects(mdlAddendaCoppel);
                AddendasCoppel.ajax.reload();
            }
        });

        mdlAddendaCoppel.on('shown.bs.modal', function () {
            mdlAddendaCoppel.find("input").val("");

            $.each(mdlAddendaCoppel.find("select"), function (k, v) {
                $(v)[0].selectize.clear();
                onEnable($(v));
            });
            xTiendaCoppel.focus().select();

            mdlAddendaCoppel.find("input:not(#xTiendaCoppel):not([readonly])").attr('readonly', true);

            $.fn.dataTable.ext.errMode = 'throw';
            if ($.fn.DataTable.isDataTable('#tblAddendasCoppel')) {
                AddendasCoppel.ajax.reload(function () {
                    xTiendaCoppel.focus().select();
                });
            } else {
                AddendasCoppel = tblAddendasCoppel.DataTable({
                    dom: 'rtip',
                    "ajax": {
                        "url": '<?php print base_url('AdendaCoppel/getFacturasDetalles'); ?>',
                        "dataSrc": "",
                        "data": function (d) {
                            d.FACTURA = FacturaCoppel.val() ? FacturaCoppel.val() : '';
                            d.TIENDA = xTiendaCoppel.val() ? xTiendaCoppel.val() : '';
                        }
                    },
                    "columns": [
                        {"data": "FACTURA"},
                        {"data": "RAZON_SOCIAL"},
                        {"data": "EST_CTE"},
                        {"data": "TALLA"},
                        {"data": "EST_4E"},

                        {"data": "PARES"},
                        {"data": "PRECIO_F"},
                        {"data": "PRE_CON_DES_F"},
                        {"data": "CANTIDAD"},
                        {"data": "PORCENTAJE_DESCUENTO"},

                        {"data": "MONTO_DESCUENTO"},
                        {"data": "TOTAL_F"},
                        {"data": "TOTAL_CON_DESCUENTO_F"}
                    ],
                    "columnDefs": [
                        {
                            "targets": [0],
                            "visible": true,
                            "searchable": true
                        },
                        {
                            "targets": [5],
                            "width": 50
                        }],
                    language: lang,
                    select: true,
                    "autoWidth": true,
                    "colReorder": true,
                    "displayLength": 999,
                    "bLengthChange": false,
                    "deferRender": true,
                    "scrollCollapse": false,
                    "processing": true,
                    "bSort": true,
                    "scrollY": 300,
                    "scrollX": true,
                    responsive: false,
                    "aaSorting": [
                        [0, 'desc']/*ID*/
                    ],
                    initComplete: function () {
                        xTiendaCoppel.focus().select();
                    },
                    "drawCallback": function (settings) {
                        var api = this.api();
                        var prs = 0, stt = 0.0;
                        $.each(api.rows().data(), function (k, v) {
                            prs += parseFloat(v.PARES);
                            stt += parseFloat(v.TOTAL);
                        });
                        $(api.column(5).footer()).html(
                                '<h4 class="font-weight-bold" style="color:#8e1b0f ;">' + prs + ' PARES</h4>');
//                       $(api.column(6).footer()).html(
//                                '<h4 class="font-weight-bold" style="color:#8e1b0f ;"> $ ' + $.number(parseFloat(stt), 3, '.', ',') + ' TOTAL</h4>');
                    }
                });

                tblAddendasCoppel.on('click', 'tr', function () {

                });
            }
        });

        btnAdendaCoppel.click(function () {
            mdlAddendaCoppel.modal('show');
        });

        /*FIN MODAL ADDENDA*/
    });
    function onComprobarFacturaTiendaCoppel() {
        $.getJSON('<?php print base_url('AdendaCoppel/onComprobarFactura'); ?>', {
            TIENDA: xTiendaCoppel.val(),
            FACTURA: FacturaCoppel.val()
        }).done(function (a) {
            onCloseOverlay();
            console.log(a);
            if (parseInt(a.FACTURA_EXISTE) > 0) {
                onResetAdendaCoppel();
                onCampoInvalido(mdlAddendaCoppel, "LA FACTURA YA FUE GENERADA.", function () {
                    FacturaCoppel.focus().select();
                });
                return;
            } else {
                if (parseInt(a.FACTURA_ENCONTRADA) > 0) {
                    onEnable(btnAceptaAddendaCoppel);
                    FechaFacturaCoppel.val(a.FECHA_FACTURA);
                    FechaPedidoCoppel.val(a.FECHA_PEDIDO);
                    PedidoCoppel.val(a.CLAVE_PEDIDO);
                    ImporteAddenda.val(a.SUBTOTAL);
                    SubtotalAddenda.val(a.SUBTOTAL);
                    DescuentoAddenda.val(a.DESCUENTO);
                    IVAAddenda.val(a.IVA);
                    TotalAddenda.val(a.TOTAL);
                    AddendasCoppel.ajax.reload(function () {
                        PedidoCoppel.focus().select();
                        onCloseOverlay();
                    });
                } else {
                    onResetAdendaCoppel();
                    onCampoInvalido(mdlAddendaCoppel, "NO SE ENCONTRO NINGUNA FACTURA CON ESTE FOLIO O YA FUE GENERADA.", function () {
                        FacturaCoppel.focus().select();
                    });
                }
            }
        }).fail(function (x) {
            onCloseOverlay();
            getError(x);
        }).always(function () {

        });
    }

    function onResetAdendaCoppel() {
        FechaFacturaCoppel.val("");
        FechaPedidoCoppel.val("");
        PedidoCoppel.val("");
        ImporteAddenda.val("");
        SubtotalAddenda.val("");
        DescuentoAddenda.val("");
        IVAAddenda.val("");
        TotalAddenda.val("");
        onDisable(btnAceptaAddendaCoppel);
    }
</script>
<style>
    #tblAddendasCoppel tbody td {
        font-size: 16px !important;
    }
    #tblAddendasCoppel tbody tr td   {
        font-weight: bold !important; 
    }
    #tblAddendasCoppel tbody td:first-child{ 
        color: #ef1000  !important;
    } 
    #tblAddendasCoppel tbody tr td:nth-child(5) { 
        color:  #773e0c  !important;
    }
    #tblAddendasCoppel tbody tr td:nth-child(6) { 
        color:  #330066  !important;
    }
    #tblAddendasCoppel tbody tr td:nth-child(9) { 
        color: #f38221  !important;
    }
    #tblAddendasCoppel tbody tr td:nth-child(7),#tblAddendasCoppel tbody tr td:nth-child(12) { 
        color: #008000 !important;
    }
    #tblAddendasCoppel tbody tr td:nth-child(8),#tblAddendasCoppel tbody tr td:nth-child(13){ 
        color: #3f51b5 !important;
    }
</style>