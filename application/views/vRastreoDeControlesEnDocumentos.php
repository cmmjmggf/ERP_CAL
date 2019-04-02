<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Rastreo de controles en documentos</legend>
            </div>
            <div class="col-sm-6 float-right" align="right"></div>
        </div>
        <div class="card-block">
            <div class="row  mb-2">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
                    <label>Control</label>
                    <input type="text" id="Control" name="Control" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">
                    <label>Estilo</label>
                    <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
                    <label>Color</label>
                    <select id="Color" name="Color" class="form-control"></select>
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-1">
                    <label>Pares</label>
                    <input type="text" id="Pares" name="Pares" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
                    <label>Cliente</label>
                    <select id="Cliente" name="Cliente" class="form-control"></select>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-4">
                    <table id="tblFechasDelPedido" class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Pedido</th>
                                <th scope="col">Entrega</th>
                                <th scope="col">Captura</th>
                                <th scope="col">Produ.</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-4">
                    <table id="tblFechasDeFacturacion" class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Factura</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">St</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-4">
                    <table id="tblFechasDevolucion" class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Factura(s)</th>
                                <th scope="col">-</th>
                                <th scope="col">-</th>
                                <th scope="col">Fecha</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <table id="tblFechasDeAvance" class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Corte</th>
                                <th scope="col">Rayado</th>
                                <th scope="col">Rebajado</th>
                                <th scope="col">Foleado</th>
                                <th scope="col">Entretelado</th>
                                <th scope="col">Alm-Corte</th>
                                <th scope="col">Pespunte</th>
                                <th scope="col">Alm-Pespunte</th>
                                <th scope="col">Tejido</th>
                                <th scope="col">Alm-Tejido</th>
                                <th scope="col">Montado</th>
                                <th scope="col">Adorno</th>
                                <th scope="col">Alm-Adorno</th>
                                <th scope="col">Terminado</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                    <table id="tblRastreoDeControlesEnNomina" class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Empleado</th>
                                <th scope="col">Control</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Estilo</th>
                                <th scope="col">Fraccion</th>
                                <th scope="col">Semana</th>
                                <th scope="col">Pares</th>
                                <th scope="col">Depto</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                    <div class="row">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <label>Estatus en producción</label>
                            <input type="text" id="EstatusProduccion" name="EstatusProduccion" class="form-control" placeholder="Estatus en producción">
                        </div>
                        <div class="w-100"></div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                            <label>Empleado</label>
                            <select id="Empleado" name="Empleado" class="form-control"></select>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                            <label>Fracción</label>
                            <input type="text" id="Fraccion" name="Fraccion" class="form-control form-control-sm    ">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), Control = pnlTablero.find("#Control"), 
        Estilo = pnlTablero.find("#Estilo"), Cliente = pnlTablero.find("#Cliente"),
        Empleado = pnlTablero.find("#Empleado");

    $(document).ready(function () {
        getClientes();
        getEmpleados();
        Control.focus();
        Estilo.on('keydown', function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                getColoresXEstilo($(this).val());
            }
        }).focusout(function () {
            if ($(this).val()) {
                getColoresXEstilo($(this).val());
            }
        });
    });

    function getClientes() {
        Cliente[0].selectize.clear(true);
        Cliente[0].selectize.clearOptions();
        $.getJSON('<?php print base_url('RastreoDeControlesEnDocumentos/getClientes'); ?>').done(function (a) {
            if (a.length > 0) {
                a.forEach(function (x) {
                    Cliente[0].selectize.addOption({text: x.CLIENTE, value: x.CLAVE});
                });
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
        });
    }

    function getEmpleados() {
        Empleado[0].selectize.clear(true);
        Empleado[0].selectize.clearOptions();
        $.getJSON('<?php print base_url('RastreoDeControlesEnDocumentos/getEmpleados'); ?>').done(function (a) {
            if (a.length > 0) {
                a.forEach(function (x) {
                    Empleado[0].selectize.addOption({text: x.EMPLEADO, value: x.CLAVE});
                });
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
        });
    }

    function getColoresXEstilo(e) {
        $.getJSON("<?php print base_url('RastreoDeControlesEnDocumentos/getColoresXEstilo') ?>", {ESTILO: e}).done(function (x, y, z) {
            x.forEach(function (i) {
                Color[0].selectize.addOption({text: i.COLOR, value: i.CLAVE});
            });
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {
            HoldOn.close();
        });
    }
</script>