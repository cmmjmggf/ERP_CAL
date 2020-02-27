<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Rastreo de estilos clientes en pedidos</legend>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="right">
                <button type="button" id="btnImprimirReporte" name="btnImprimirReporte" class="btn btn-info selectNotEnter notEnter" disabled="">
                    <span class="fa fa-print"></span> Imprimir
                </button>
            </div>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-1">
                    <label>ESTILO</label>
                    <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm" maxlength="15">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <label>COLOR</label>
                    <div class="row">
                        <div class="col-3">
                            <input type="text" id="xColor" name="xColor" class="form-control form-control-sm" placeholder="" maxlength="5">
                        </div>
                        <div class="col-9">
                            <select id="Color" name="Color" class="form-control form-control-sm" ></select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <label>CLIENTE</label>
                    <div class="row">
                        <div class="col-3">
                            <input type="text" id="xCliente" name="xCliente" class="form-control form-control-sm" placeholder="CLAVE">
                        </div>
                        <div class="col-9">
                            <select id="Cliente" name="Cliente" class="form-control form-control-sm">
                                <option></option>
                                <?php
                                $clientes = $this->db->select("C.Clave AS Clave, CONCAT(C.Clave, \" - \",C.RazonS) AS Cliente", false)
                                                ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('ABS(C.Clave)', 'ASC')->get()->result();
                                foreach ($clientes as $k => $v) {
                                    print "<option value=\"{$v->Clave}\">{$v->Cliente}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-1 col-xl-2">
                    <label>DE LA FECHA</label>
                    <input type="text" id="DelaFecha" name="DelaFecha" class="form-control form-control-sm date">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-1 col-xl-2">
                    <label>A LA FECHA</label>
                    <input type="text" id="AlaFecha" name="AlaFecha" class="form-control form-control-sm date">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2 d-none">
                    <label>ANIO</label>
                    <input type="text"  id="ANIO" name="ANIO" class="form-control form-control-sm" >
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <table id="tblPedidox" class="table table-sm table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CLIENTE</th>
                                <th scope="col">ESTILO</th>

                                <th scope="col">COLOR</th>
                                <th scope="col">PARES</th>
                                <th scope="col">CONTROL</th>

                                <th scope="col">MAQ</th>

                                <th scope="col">SEM</th>
                                <th scope="col">PEDIDO</th>
                                <th scope="col">FECHA-ENT</th>

                                <th scope="col">FECHA-VTA</th>
                                <th scope="col">PRECIO</th>
                                <th scope="col">AVANCE</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-12" align="center">
                    <h4 class="font-weight-bold PARES_TOTALES text-danger">Pares</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), Estilo = pnlTablero.find("#Estilo"),
            xColor = pnlTablero.find("#xColor"),
            Color = pnlTablero.find("#Color"),
            xCliente = pnlTablero.find("#xCliente"),
            Cliente = pnlTablero.find("#Cliente"),
            Pedidox, tblPedidox = pnlTablero.find("#tblPedidox"),
            btnImprimirReporte = pnlTablero.find("#btnImprimirReporte"),
            AAAA = <?php print Date('Y'); ?>, ANIO = pnlTablero.find('#ANIO'),
            DelaFecha = pnlTablero.find('#DelaFecha'), AlaFecha = pnlTablero.find('#AlaFecha');

    $(document).ready(function () {

        ANIO.val(AAAA);

        Color.change(function () {
            if (Color.val()) {
                xColor.val(Color.val());
                Pedidox.ajax.reload(function () {
                    onRevisarRegistros();
                    xCliente.focus();
                    Color[0].selectize.disable();
                });
            } else {
                Pedidox.ajax.reload(function () {
                    onRevisarRegistros();
                    xColor.val('');
                    Color[0].selectize.enable();
                    Color[0].selectize.clear(true);
                });
            }
        });
        
        xColor.on('keypress', function (e) {
            if (e.keyCode === 13) {
                if (xColor.val()) {
                    Color[0].selectize.setValue(xColor.val());
                    if (Color.val()) {
                        Pedidox.ajax.reload(function () {
                            onRevisarRegistros();
                            Color[0].selectize.disable();
                        });
                    } else {
                        iMsg('NO EXISTE ESTE COLOR, ESPECIFIQUE OTRO', 'w', function () {
                            xColor.focus().select();
                        });
                    }
                } else {
                    Pedidox.ajax.reload(function () {
                        onRevisarRegistros();
                        Color[0].selectize.enable();
                        Color[0].selectize.clear(true);
                        xCliente.focus();
                    });
                }
            } else {
                Pedidox.ajax.reload(function () {
                    onRevisarRegistros();
                    Color[0].selectize.enable();
                    Color[0].selectize.clear(true);
                });
            }
        });

        Cliente.change(function () {
            if (Cliente.val()) {
                xCliente.val(Cliente.val());
                Pedidox.ajax.reload(function () {

                    onRevisarRegistros();
                    Cliente[0].selectize.disable();
                });
            } else {
                xCliente.val('');
                Cliente[0].selectize.enable();
                Cliente[0].selectize.clear(true);
            }
        });
        xCliente.on('keypress', function (e) {
            if (e.keyCode === 13) {
                if (xCliente.val()) {
                    Cliente[0].selectize.setValue(xCliente.val());
                    if (Cliente.val()) {
                        Cliente[0].selectize.disable();
                        DelaFecha.focus();
                    } else {
                        iMsg('NO EXISTE ESTE CLIENTE, ESPECIFIQUE OTRO', 'w', function () {
                            xCliente.focus().select();
                        });
                    }
                } else {
                    Cliente[0].selectize.enable();
                    Cliente[0].selectize.clear(true);
                    DelaFecha.focus();
                }
            } else {
                Cliente[0].selectize.enable();
                Cliente[0].selectize.clear(true);
            }
        });

        DelaFecha.on('keypress', function (e) {
            if (e.keyCode === 13) {
                if (DelaFecha.val()) {
                    AlaFecha.focus();
                } else {
                    AlaFecha.focus();
                }
            }
        });
        AlaFecha.on('keypress', function (e) {
            if (e.keyCode === 13) {
                if (AlaFecha.val() && DelaFecha.val()) {
                    Pedidox.ajax.reload(function () {
                        onRevisarRegistros();
                        btnImprimirReporte.focus();
                    });
                } else {
                    btnImprimirReporte.focus();
                }
            }
        });

        btnImprimirReporte.click(function () {
            onBeep(1);
            onOpenOverlay('Por favor espere...');
            $.post('<?php print base_url('RastreoDeEstilosEnPedidos/getReporte'); ?>',
                    {
                        ESTILO: Estilo.val() ? Estilo.val() : '',
                        COLOR: Color.val() ? Color.val() : '',
                        CLIENTE: Cliente.val() ? Cliente.val() : ''
                    }).done(function (data) {
                if (data.length > 0) {
                    onImprimirReporteFancy(data);
                }
            }).fail(function (x, y, z) {
                getError(x);
            }).always(function () {
            });
        });

        Estilo.on('keydown', function (e) {
            if (e.keyCode === 13 && Estilo.val()) {
                Pedidox.ajax.reload(function () {
                });
                //OBTENER COLORES POR ESTILO
                Color[0].selectize.clearOptions();
                $.getJSON('<?php print base_url('RastreoEstilosClientesXFechasEnVentas/getColoresXEstilo'); ?>', {ESTILO: $(this).val()}).done(function (data) {
                    $.each(data, function (k, v) {
                        Color[0].selectize.addOption({text: v.Color, value: v.Clave});
                    });
                    xColor.focus().select();
                }).fail(function (x, y, z) {
                    getError(x);
                }).always(function () {

                    onRevisarRegistros();
                });
            }
            Pedidox.ajax.reload(function () {
                onRevisarRegistros(); 
            });
        });

        Pedidox = tblPedidox.DataTable({
            "dom": 'ritp',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('RastreoDeEstilosEnPedidos/getPedidos'); ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = (Cliente.val() ? Cliente.val() : '');
                    d.ESTILO = (Estilo.val() ? Estilo.val() : '');
                    d.COLOR = (Color.val() ? Color.val() : '');
                    d.DFECHA = (DelaFecha.val() ? DelaFecha.val() : '');
                    d.AFECHA = (AlaFecha.val() ? AlaFecha.val() : '');
                }
            },
            "columns": [
                {"data": "ID"}/*0*/, {"data": "CLIENTE"}/*1*/,
                {"data": "ESTILO"}/*2*/, {"data": "COLOR"},
                {"data": "PARES"}/*4*/, {"data": "CONTROL"},
                {"data": "MAQUILA"}/*6*/, {"data": "SEMANA"},
                {"data": "PEDIDO"}, {"data": "FECHA_ENTREGA"},
                {"data": "FECHA_VENTA"}/*6*/, {"data": "PRECIO"},
                {"data": "AVANCE"}

            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            select: true,
            "autoWidth": true,
            ordering: true,
            "colReorder": true,
            "displayLength": 250,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "450px",
            "scrollX": true,
            initComplete: function () {

                Estilo.focus();
            },
            "drawCallback": function (settings) {
                var api = this.api();
                var prs = 0;
                $.each(api.rows().data(), function (k, v) {
                    prs = prs + parseInt(v.PARES);
                });
                //                mdlRastreoXControl.find(".total_pesos").text("$ " + r.toFixed(3));
                pnlTablero.find("h4.PARES_TOTALES").text(prs + ' PARES');
            }
        });
    });

    function onRevisarRegistros() {
        console.log(Estilo.val(), Color.val(), Pedidox.data().count());
        if (Estilo.val() && Color.val() && Pedidox.data().count() > 0) {
            btnImprimirReporte.attr('disabled', false);
            if (Estilo.val() && Color.val() && Cliente.val()) {
                btnImprimirReporte.focus();
            }
        } else {
            btnImprimirReporte.attr('disabled', true);
        }
    }
</script>