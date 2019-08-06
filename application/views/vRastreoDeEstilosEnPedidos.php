<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Rastreo de estilos clientes en pedidos</legend>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="right">
                <button type="button" id="btnImprimirReporte" name="btnImprimirReporte" class="btn btn-info" disabled="">
                    <span class="fa fa-print"></span> Imprimir
                </button>
            </div>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                    <label>ESTILO</label>
                    <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                    <label>COLOR</label>
                    <select id="Color" name="Color" class="form-control form-control-sm" ></select>
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                    <label>CLIENTE</label>
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
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), Estilo = pnlTablero.find("#Estilo"),
            Color = pnlTablero.find("#Color"), Cliente = pnlTablero.find("#Cliente"),
            Pedidox, tblPedidox = pnlTablero.find("#tblPedidox"),
            btnImprimirReporte = pnlTablero.find("#btnImprimirReporte");

    $(document).ready(function () {
        onOpenOverlay('Cargando...');

        handleEnterDiv(pnlTablero);

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
                    onImprimirReporteFancy('<?php print base_url(); ?>js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs');
                }
            }).fail(function (x, y, z) {
                getError(x);
            }).always(function () {
                onCloseOverlay();
            });
        });

        Estilo.on('keydown', function (e) {
            if (e.keyCode === 13 && Estilo.val()) {
                onOpenOverlay('Buscando...');
                Pedidox.ajax.reload(function () {
                    onCloseOverlay();
                });
                //OBTENER COLORES POR ESTILO
                Color[0].selectize.clearOptions();
                $.getJSON('<?php print base_url('RastreoEstilosClientesXFechasEnVentas/getColoresXEstilo'); ?>', {ESTILO: $(this).val()}).done(function (data) {
                    $.each(data, function (k, v) {
                        Color[0].selectize.addOption({text: v.Color, value: v.Clave});
                    });
                    Color[0].selectize.open();
                }).fail(function (x, y, z) {
                    getError(x);
                }).always(function () {
                    onCloseOverlay();
                    onRevisarRegistros();
                });
            }
        });

        Cliente.change(function (e) {
            onOpenOverlay('Buscando...');
            Pedidox.ajax.reload(function () {
                onCloseOverlay();
                onRevisarRegistros();
            });
        });

        Color.change(function (e) {
            onOpenOverlay('Buscando...');
            Pedidox.ajax.reload(function () {
                onCloseOverlay();
                onRevisarRegistros();
                Cliente[0].selectize.focus();
                Cliente[0].selectize.open();
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
            ordering: false,
            "colReorder": true,
            "displayLength": 250,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "250px",
            "scrollX": true,
            initComplete: function () {
                onCloseOverlay();
                Estilo.focus();
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