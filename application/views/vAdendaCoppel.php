<div class="modal fade" id="mdlAddendaCoppel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg notdraggable" role="document">
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
                        <input type="text" id="FechaFacturaCoppel" name="FechaFacturaCoppel" class="form-control date notEnter form-control-sm">
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
                        <input type="text" id="NBodega" name="NBodega" class="form-control form-control-sm">
                    </div>
                    <div class="col-3">
                        <label>Direccion</label>
                        <input type="text" id="DireccionBodega" name="DireccionBodega" class="form-control form-control-sm">
                    </div>
                    <div class="w-100"></div> 
                    <div class="col-4">
                        <label>Ciudad</label>
                        <input type="text" id="CiudadTiendaCoppel" name="CiudadTiendaCoppel" class="form-control form-control-sm">
                    </div>
                    <div class="col-2">
                        <label>Código Postal</label>
                        <input type="text" id="CodigoPostalTienda" name="CodigoPostalTienda" class="form-control form-control-sm numbersOnly">
                    </div>
                    <div class="col-2">
                        <label>No.Bodega</label>
                        <input type="text" id="NoBodegaCoppel" name="NoBodegaCoppel" class="form-control form-control-sm">
                    </div> 
                    <div class="col-2">
                        <label>C.Lotes</label>
                        <input type="text" id="CantidadLotes" name="CantidadLotes" class="form-control form-control-sm">
                    </div>
                    <div class="col-2">
                        <label>CantidadPrepack</label>
                        <input type="text" id="CantidadPrepack" name="CantidadPrepack" class="form-control form-control-sm">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-2">
                        <label>Importe</label>
                        <input type="text" id="ImporteAddenda" name="ImporteAddenda" class="form-control form-control-sm numbersOnly numericdot">
                    </div>
                    <div class="col-2">
                        <label>Descuento</label>
                        <input type="text" id="DescuentoAddenda" name="ImporteAddenda" class="form-control form-control-sm numbersOnly numericdot">
                    </div>
                    <div class="col-3">
                        <label>Subtotal</label>
                        <input type="text" id="SubtotalAddenda" name="SubtotalAddenda" class="form-control form-control-sm numbersOnly numericdot">
                    </div>
                    <div class="col-2">
                        <label>I.V.A</label>
                        <input type="text" id="IVAAddenda" name="IVAAddenda" class="form-control form-control-sm numbersOnly numericdot">
                    </div>
                    <div class="col-3">
                        <label>TOTAL</label>
                        <input type="text" id="TotalAddenda" name="TotalAddenda" class="form-control form-control-sm numbersOnly numericdot">
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
                                    <th>PRECODES</th>
                                    <th>CANTIDAD</th>
                                    <th>%DECTO</th>

                                    <th>MON.DESCTO</th>
                                    <th>TOTAL</th>
                                    <th>TOTALCONDESCUENTO</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
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
            FacturaCoppel = mdlAddendaCoppel.find("#FacturaCoppel");

    $(document).ready(function () {

        /*INICIO MODAL ADDENDA*/

        handleEnterDiv(mdlAddendaCoppel);

        FacturaCoppel.on('keydown', function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                $.getJSON('<?php print base_url('AdendaCoppel/onComprobarFactura'); ?>', {
                    TIENDA: xTiendaCoppel.val(),
                    FACTURA: FacturaCoppel.val()
                }).done(function (a) {
                    console.log(a);
                    if (parseInt(a.FACTURA_EXISTE) > 0) {
                        onCampoInvalido(mdlAddendaCoppel, "LA FACTURA YA FUE GENERADA.", function () {
                            FacturaCoppel.focus().select();
                        });
                    } else {
                         
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {

                });
            }
        });
        mdlAddendaCoppel.find("#TiendaCoppel").change(function () {
            var tienda = $(this).val();
            if (tienda) {
                mdlAddendaCoppel.find("#xTiendaCoppel").val(tienda);
            }
        });


        mdlAddendaCoppel.find("#xTiendaCoppel").on('keydown keyup', function (e) {
            var tcp = $(this).val();
            if (e.keyCode === 13 && tcp) {
                var index = 0;
                $.each(mdlAddendaCoppel.find("#tblTiendas tbody tr"), function (k, v) {
                    var nmtda = $(v).find("td");
                    if ($(nmtda).eq(0).text() === tcp) {
                        console.log(v);
                        var r = nmtda;
                        mdlAddendaCoppel.find("#TiendaCoppel")[0].selectize.setValue(r.eq(0).text());
                        if (mdlAddendaCoppel.find("#TiendaCoppel").val()) {
                            onDisable(mdlAddendaCoppel.find("#TiendaCoppel"));
                        } else {
                            onEnable(mdlAddendaCoppel.find("#TiendaCoppel"));
                        }
                        mdlAddendaCoppel.find("#CoppelProveedor").val(r.eq(1).text());
                        mdlAddendaCoppel.find("#DireccionBodega").val(r.eq(2).text());
                        mdlAddendaCoppel.find("#CiudadTiendaCoppel").val(r.eq(6).text());
                        mdlAddendaCoppel.find("#CodigoPostalTienda").val(r.eq(11).text());
                        mdlAddendaCoppel.find("#TProveedor").val(r.eq(12).text());
                        mdlAddendaCoppel.find("#NBodega").val(r.eq(13).text());
                        mdlAddendaCoppel.find("#FacturaCoppel").focus().select();
                        index = 1;

                        AddendasCoppel.ajax.reload(function () {
                            mdlAddendaCoppel.find("input:not(#CoppelProveedor):not(#TProveedor):not(#NBodega):not(#DireccionBodega):not(#CiudadTiendaCoppel):not(#CodigoPostalTienda)").attr('readonly', false);
                            FacturaCoppel.focus().select();
                        });
                        return false;
                    }
                });
                if (index <= 0) {
                    onEnable(mdlAddendaCoppel.find("#TiendaCoppel"));
                    onClearInputs(mdlAddendaCoppel);
                    onClearSelects(mdlAddendaCoppel);
                }
            }
            if (mdlAddendaCoppel.find("#xTiendaCoppel").val() === '' ||
                    e.keyCode === 8 && mdlAddendaCoppel.find("#xTiendaCoppel").val() === '') {
                onEnable(mdlAddendaCoppel.find("#TiendaCoppel"));
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
            mdlAddendaCoppel.find("#xTiendaCoppel").focus().select();

            mdlAddendaCoppel.find("input:not(#xTiendaCoppel)").attr('readonly', true);

            $.fn.dataTable.ext.errMode = 'throw';
            if ($.fn.DataTable.isDataTable('#tblAddendasCoppel')) {
                AddendasCoppel.ajax.reload(function () {
                    mdlAddendaCoppel.find("#xTiendaCoppel").focus().select();
                });
            } else {
                AddendasCoppel = tblAddendasCoppel.DataTable({
                    dom: 'rtip',
                    "ajax": {
                        "url": '<?php print base_url('FacturacionProduccion/getFacturasDetalles'); ?>',
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
                        {"data": "PRECIO"},
                        {"data": "PRE_CON_DES"},
                        {"data": "CANTIDAD"},
                        {"data": "PORCENTAJE_DESCUENTO"},

                        {"data": "MONTO_DESCUENTO"},
                        {"data": "TOTAL"},
                        {"data": "TOTAL_CON_DESCUENTO"}
                    ],
                    "columnDefs": [
                        {
                            "targets": [0],
                            "visible": true,
                            "searchable": true
                        }],
                    language: lang,
                    select: true,
                    "autoWidth": true,
                    "colReorder": true,
                    "displayLength": 50,
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
                        mdlAddendaCoppel.find("#xTiendaCoppel").focus().select();
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
</script>