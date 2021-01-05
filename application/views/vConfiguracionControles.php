<div id="PanelDeControl" class="card">
    <div class="card-body">
        <h4 class="card-title">CONFIGURACIÓN DE CONTROLES</h4> 
        <div class="row my-2">
            <div class="col-4">
                <label>CONTROL</label> 
                <input type="text" id="ConfigControl" class="form-control form-control-sm" style="font-size: 40px; color: #8BC34A !important; text-align: center;">
            </div>
            <div class="col-4">
                <label style="font-size:32px;">CLIENTE</label> 
                <p class="control_cliente" style="font-size:28px; font-style: italic; color: #FF0000;">-</p>
            </div>
            <div class="col-4"> 
                <label style="font-size:32px;">ESTATUS ACTUAL</label> 
                <p class="control_estatus" style="font-size:28px; font-style: italic; color: #0008ff;">-</p>
            </div>
        </div>

        <ul class="nav nav-tabs" id="MasterTab">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#pedidos">PEDIDOS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#controles">CONTROLES</a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#avances">AVANCES</a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#fechas">FECHAS</a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#nomina">NOMINA</a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#facturacion">FACTURACION</a>
            </li> 
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="pedidos" role="tabpanel" aria-labelledby="pedidos">
                <table id="tblPedidos" class="table table-hover table-sm nowrap" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">PEDIDO</th> 
                            <th scope="col">CLIENTE</th> 
                            <th scope="col">ESTILO</th> 
                            <th scope="col">COLOR</th> 
                            <th scope="col">MAQUILA</th> 
                            <th scope="col">SEMANA</th> 
                            <th scope="col">AÑO</th> 
                            <th scope="col">CONTROL</th> 
                            <th scope="col">PARES</th> 
                            <th scope="col">PARES FACTURADOS</th> 
                            <th scope="col">ESTATUS</th>  
                            <th scope="col">ESTATUSPRODUCCIÓN</th>  
                            <th scope="col">DEPARTAMENTO</th> 
                            <th scope="col"># AVANCE</th> 
                        </tr>
                    </thead>
                    <tbody> 
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="controles" role="tabpanel" aria-labelledby="controles">
                <table id="tblControles" class="table table-hover table-sm nowrap" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th> 
                            <th scope="col">PEDIDO</th> 
                            <th scope="col">PEDIDO DETALLE (ORDENPROD)</th> 
                            <th scope="col">CONTROL</th>  
                            <th scope="col">SEMANA</th>  
                            <th scope="col">MAQUILA</th>  
                            <th scope="col">AÑO</th>  
                            <th scope="col">ESTATUS</th> 
                            <th scope="col">ESTATUS PRODUCCIÓN</th> 
                            <th scope="col">DEPARTAMENTO</th> 
                        </tr>
                    </thead>
                    <tbody> 
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="avances" role="tabpanel" aria-labelledby="avances">
                <table id="tblAvances"  class="table table-hover table-sm nowrap" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th> 
                            <th scope="col">CONTROL</th> 
                            <th scope="col">MODULO</th> 
                            <th scope="col">FECHA A PRODUCCIÓN</th> 
                            <th scope="col">CLAVE DEPTO</th> 

                            <th scope="col">DEPARTAMENTO</th> 
                            <th scope="col">FECHA DE AVANCE</th> 
                            <th scope="col">ESTATUS</th> 
                            <th scope="col">USUARIO AVANZO</th> 
                            <th scope="col">FECHA DEL REGISTRO</th> 

                            <th scope="col">HORA DEL REGISTRO</th> 
                            <th scope="col">FRACCIÓN</th> 
                            <th scope="col">DOCUMENTO</th> 
                        </tr>
                    </thead>
                    <tbody> 
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="fechas" role="tabpanel" aria-labelledby="fechas">
                <table id="tblAvaprd"  class="table table-hover table-sm nowrap" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th> 
                            <th scope="col">CONTROL</th>  
                            <th scope="col">PROGRAMACIÓN</th> 
                            <th scope="col">CORTE</th> 
                            <th scope="col">RAYADO</th> 
                            <th scope="col">REBAJADO</th> 
                            <th scope="col">FOLEADO</th> 
                            <th scope="col">ENTRETELADO</th> 
                            <th scope="col">MAQUILA</th> 
                            <th scope="col">ALMACEN DE CORTE</th> 
                            <th scope="col">PESPUNTE</th> 
                            <th scope="col">ENSUELADO</th> 
                            <th scope="col">ALMACEN PESPUNTE</th> 
                            <th scope="col">TEJIDO</th> 
                            <th scope="col">ALMACEN TEJIDO</th> 
                            <th scope="col">MONTADO</th> 
                            <th scope="col">ADORNO</th> 
                            <th scope="col">ALMACEN ADORNO</th> 
                            <th scope="col">TERMINADO</th> 
                            <th scope="col">FACTURADO</th> 
                            <th scope="col">CANCELADO</th> 
                            <th scope="col">DEVUELTO</th> 
                        </tr>
                    </thead>
                    <tbody> 
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="nomina" role="tabpanel" aria-labelledby="nomina">
                <table id="tblNomina" class="table table-hover table-sm nowrap" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th> 
                            <th scope="col">MÓDULO</th> 
                            <th scope="col">EMPLEADO</th> 
                            <th scope="col">MAQUILA</th> 
                            <th scope="col">CONTROL</th> 
                            <th scope="col">ESTILO</th> 
                            <th scope="col">FRACCIÓN</th> 
                            <th scope="col">PRECIO</th> 
                            <th scope="col">PARES</th> 
                            <th scope="col">SUBTOTAL</th> 
                            <th scope="col">ESTATUS</th> 
                            <th scope="col">FECHA</th> 
                            <th scope="col">SEMANA</th> 
                            <th scope="col">DEPARTAMENTO</th> 
                            <th scope="col">REGISTRO</th> 
                            <th scope="col">AÑO</th> 
                            <th scope="col">AVANCE ID</th> 
                            <th scope="col">REGISTRO</th> 
                        </tr>
                    </thead>
                    <tbody> 
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="facturacion" role="tabpanel" aria-labelledby="facturacion">
                <table id="tblFacturacion"  class="table table-hover table-sm nowrap" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">MODULO</th> 
                            <th scope="col">FACTURA</th> 
                            <th scope="col">FECHA</th> 
                            <th scope="col">CLIENTE</th> 
                            <th scope="col">TP</th> 
                            <th scope="col">CONTROL</th> 
                            <th scope="col">PARES</th> 
                            <th scope="col">PRECIO</th> 
                            <th scope="col">MONEDA</th>  
                            <th scope="col">SUBTOTAL</th> 
                            <th scope="col">I.V.A</th> 
                            <th scope="col">TOTAL</th> 
                            <th scope="col">LETRA</th> 
                            <th scope="col">FACTURA EN CEROS</th> 
                            <th scope="col">USUARIO</th> 
                        </tr>
                    </thead>
                    <tbody> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var PanelDeControl = $("#PanelDeControl"),
            ConfigControl = PanelDeControl.find("#ConfigControl"),
            tblPedidos = PanelDeControl.find("#tblPedidos"), Pedidos,
            tblControles = PanelDeControl.find("#tblControles"), Controles,
            tblAvances = PanelDeControl.find("#tblAvances"), Avances,
            tblAvaprd = PanelDeControl.find("#tblAvaprd"), Avaprd,
            tblNomina = PanelDeControl.find("#tblNomina"), Nomina,
            tblFacturacion = PanelDeControl.find("#tblFacturacion"), Facturacion;
    $(document).ready(function () {
        var cols = [
            {"data": "ID"}/*0*/,
            {"data": "PEDIDO"}/*1*/,
            {"data": "CLIENTE"}/*2*/,
            {"data": "ESTILO"}/*3*/,
            {"data": "COLOR"}/*4*/,
            {"data": "MAQUILA"}/*5*/,

            {"data": "SEMANA"}/*6*/,
            {"data": "ANO"}/*7*/,
            {"data": "CONTROL"}/*8*/,

            {"data": "PARES"}/*9*/,
            {"data": "PARES_FACTURADOS"}, /*10*/
            {"data": "ESTATUS"}, /*11*/
            {"data": "ESTATUS_PRODUCCION"}, /*11*/
            {"data": "DEPTO_PRODUCCION"}, /*12*/
            {"data": "STSAVAN"}/*13*/
        ];
        var coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ];
        var xoptions = {
            "dom": 'rtp',
            "ajax": {
                "url": '<?php print base_url('ConfiguracionControles/getPedidoXControl'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL = ConfigControl.val() ? ConfigControl.val() : '';
                }
            },
            buttons: buttons,
            "columns": cols,
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "250px",
            "scrollX": true,
            "aaSorting": [
                [0, 'desc']
            ]
        };
        Pedidos = tblPedidos.DataTable(xoptions);
        Controles = tblControles.DataTable({
            "dom": 'rtp',
            "ajax": {
                "url": '<?php print base_url('ConfiguracionControles/getControlXControl'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL = ConfigControl.val() ? ConfigControl.val() : '';
                }
            },
            buttons: buttons,
            "columns": [
                {"data": "ID"}/*0*/,
                {"data": "CLAVE_PEDIDO"}/*1*/,
                {"data": "PEDIDO_DETALLE"}/*1*/,
                {"data": "CONTROL"}/*1*/,
                {"data": "SEMANA"}/*1*/,
                {"data": "MAQUILA"}/*1*/,
                {"data": "ANO"}/*1*/,
                {"data": "ESTATUS"}/*1*/,
                {"data": "ESTATUS_PRODUCCION"}/*1*/,
                {"data": "DEPTO_PRODUCCION"}/*1*/
            ],
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "250px",
            "scrollX": true,
            "aaSorting": [
                [0, 'desc']
            ]
        });

        Avances = tblAvances.DataTable({
            "dom": 'rtp',
            "ajax": {
                "url": '<?php print base_url('ConfiguracionControles/getAvancesXControl'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL = ConfigControl.val() ? ConfigControl.val() : '';
                }
            },
            buttons: buttons,
            "columns": [
                {"data": "ID"}/*0*/,
                {"data": "CONTROL"}/*1*/,
                {"data": "MODULO"}/*1*/,
                {"data": "FECHA_A_PRODUCCION"}/*1*/,
                {"data": "CLAVE_DEPTO"}/*1*/,

                {"data": "DEPARTAMENTO"}/*1*/,
                {"data": "FECHA_AVANCE"}/*1*/,
                {"data": "ESTATUS"}/*1*/,
                {"data": "USUARIO_AVANZO"}/*1*/,
                {"data": "FECHA_REGISTRO"}/*1*/,

                {"data": "HORA_REGISTRO"}/*1*/,
                {"data": "FRACCION"}/*1*/,
                {"data": "DOCUMENTO"}/*1*/
            ],
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "250px",
            "scrollX": true,
            "aaSorting": [
                [0, 'ASC']
            ]
        });

        ConfigControl.keydown(function (e) {
            if (e.keyCode === 13) {
                onOpenOverlay('Cargando...');
                $.getJSON('<?php print base_url('ConfiguracionControles/getInformacionXControl'); ?>', {CONTROL: ConfigControl.val()}).done(function (a) {
                    var r = a[0];
                    PanelDeControl.find("p.control_cliente").text(r.CLIENTE);
                    PanelDeControl.find("p.control_estatus").text(r.CONTROL_ESTATUS);
                }).fail(function (x) {
                    getError(x);
                });
                Pedidos.ajax.reload(function () {
                    Controles.ajax.reload(function () {
                        Avances.ajax.reload(function () {
                            onCloseOverlay();
                        });
                    });
                });
            }
        });

        PanelDeControl.find("#MasterTab").on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
            console.log(e, e.currentTarget.hash)
            switch (e.currentTarget.hash.replace("#", "")) {
                case "pedidos":
                    console.log('OK Pedidos');
                    Pedidos.columns.adjust().draw();
                    break;
                case "controles":
                    console.log('OK Controles');
                    Controles.columns.adjust().draw();
                    break;
                case "avances":
                    console.log('OK avances');
                    Controles.columns.adjust().draw();
                    break;
                case "fechas":
                    console.log('OK fechas');
                    Controles.columns.adjust().draw();
                    break;
                case "nomina":
                    console.log('OK nomina');
                    Controles.columns.adjust().draw();
                    break;
                case "facturacion":
                    console.log('OK facturacion');
                    Controles.columns.adjust().draw();
                    break;
            }
        });
    });

    function getInformacionDelControl( ) {
        onOpenOverlay('');
        $.post('<?php print base_url('BajaControles/getInformacionXControl'); ?>',
                {CONTROL: ControlADarDeBaja.val()}).done(function (a) {
            if (a.length > 0) {
                var c = JSON.parse(a)[0];
                mdlBajaControles.find("#ParesADarDeBaja").val(c.Pares);
                mdlBajaControles.find("h4.pares_del_control_baja").html(c.Pares + '<br> PARES');
                mdlBajaControles.find("h4.pares_facturados_del_control_baja").html(c.ParesFacturados + '<br>PARES FACTURADOS');
                mdlBajaControles.find("h4.estatus_del_control_baja").html('<span style="color:#cc0000;">' + c.DeptoProduccion + ' ' + c.EstatusProduccion + '<br>(' + c.stsavan + ')</span>');
                mdlBajaControles.find("h4.cliente_del_control_baja").html('CLIENTE <br><span style="color:#558B2F;">' + c.Cliente + '</span>');
                mdlBajaControles.find("h4.estilo_control_baja").html('ESTILO <br><span style="color:#558B2F;">' + c.Estilo + '</span>');
                mdlBajaControles.find("h4.color_control_baja").html('COLOR <br><span style="color:#cc0000;">' + c.Color + '</span>');

                if (parseInt(c.stsavan) === 12 && parseInt(c.DeptoProduccion) === 240) {
                    onEnable(btnAceptaBajaControl);
                    btnAceptaBajaControl.focus();
                } else {
                    onDisable(btnAceptaBajaControl);
                }
            }
            onCloseOverlay();
        }).fail(function (e) {
            onCloseOverlay();
            getError(e);
        }).always(function () {
            onCloseOverlay();
        });
    }
</script>
<style>

    #PanelDeControl thead tr th,  #PanelDeControl tbody tr td{
        font-weight: bold;
        font-size: 22px;
        text-align: center;
    }

</style>