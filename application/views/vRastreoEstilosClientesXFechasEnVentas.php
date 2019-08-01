<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Rastreo de estilos clientes fechas en ventas</legend>
            </div>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                    <label>ESTILO</label>
                    <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm" autofocus="">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                    <label>COLOR</label>
                    <select id="Color" name="Color" class="form-control form-control-sm" ></select>
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                    <label>DE LA FECHA</label>
                    <input type="text" id="DelaFecha" name="DelaFecha" class="form-control form-control-sm date">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                    <label>A LA FECHA</label>
                    <input type="text" id="AlaFecha" name="AlaFecha" class="form-control form-control-sm date">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
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
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <label>PARES</label>
                    <input type="text" id="Pares" name="Pares" class="form-control form-control-sm numbersOnly">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <table id="tblFacturas" class="table table-sm table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CLIENTE</th>
                                <th scope="col">ESTILO</th>

                                <th scope="col">COLOR</th>
                                <th scope="col">PARES</th>
                                <th scope="col">CONTROL</th>

                                <th scope="col">DOCTO</th>
                                <th scope="col">FECHA</th>
                                <th scope="col">TP</th>

                                <th scope="col">PRECIO</th>
                                <th scope="col">STA</th>
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
    var pnlTablero = $("#pnlTablero"), Estilo = pnlTablero.find("#Estilo"), Color = pnlTablero.find("#Color"),
            DelaFecha = pnlTablero.find("#DelaFecha"), AlaFecha = pnlTablero.find("#AlaFecha"),
            Cliente = pnlTablero.find("#Cliente"),
            Pares = pnlTablero.find("#Pares"), Facturas,
            tblFacturas = pnlTablero.find("#tblFacturas"),
            Hoy = '<?php print Date('d/m/Y'); ?>';

    $(document).ready(function () {
        handleEnterDiv(pnlTablero);

        Cliente.change(function (e) {
            onOpenOverlay('Buscando...');
            Facturas.ajax.reload(function () {
                onCloseOverlay();
            });
        });

        AlaFecha.on('keydown', function (e) {
            if (e.keyCode === 13 && DelaFecha.val() && AlaFecha.val()) {
                onOpenOverlay('Buscando...');
                Facturas.ajax.reload(function () {
                    onCloseOverlay();
                });
            }
        });

        DelaFecha.on('keydown', function (e) {
            if (e.keyCode === 13 && DelaFecha.val() && AlaFecha.val()) {
                onOpenOverlay('Buscando...');
                Facturas.ajax.reload(function () {
                    onCloseOverlay();
                });
            }
        });

        Color.change(function (e) {
            onOpenOverlay('Buscando...');
            Facturas.ajax.reload(function () {
                onCloseOverlay();
            });
        });

        Estilo.on('keydown', function (e) {
            if (e.keyCode === 13) {
                onOpenOverlay('Buscando...');
                Facturas.ajax.reload(function () {
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
                });
            }
        });
        Facturas = tblFacturas.DataTable({
            "dom": 'rit',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('RastreoEstilosClientesXFechasEnVentas/getFacturas'); ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.FECHA_INICIO = (DelaFecha.val() ? DelaFecha.val() : '');
                    d.FECHA_FIN = (DelaFecha.val() ? DelaFecha.val() : '');
                    d.CLIENTE = (Cliente.val() ? Cliente.val() : '');
                    d.ESTILO = (Estilo.val() ? Estilo.val() : '');
                    d.COLOR = (Color.val() ? Color.val() : '');
                }
            },
            "columns": [
                {"data": "ID"}/*0*/, {"data": "CLIENTE"}/*1*/,
                {"data": "ESTILO"}/*2*/, {"data": "COLOR"},
                {"data": "PARES"}/*4*/, {"data": "CONTROL"},
                {"data": "DOCUMENTO"}/*6*/, {"data": "FECHA"},
                {"data": "TP"},
                {"data": "PRECIO"}/*6*/, {"data": "ESTATUS"}
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
            "displayLength": 99999999,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "250px",
            "scrollX": true,
            initComplete: function () {
                DelaFecha.val(Hoy);
                AlaFecha.val(Hoy);
            }
        });
    });
</script>