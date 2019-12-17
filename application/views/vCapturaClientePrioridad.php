<div class="modal " id="mdlCapturaClientePrioridad"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añade Clientes a Lista de Prioridades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row">
                        <div class="col-3">
                            <label for="Cliente" >Cliente</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="Cliente" required="" placeholder="">
                        </div>
                        <div class="col-9" >
                            <label for="" >-</label>
                            <select id="sCliente" class="form-control form-control-sm required NotSelectize" >
                                <option value=""></option>
                                <?php
                                $clientesPnl = $this->db->query("SELECT C.Clave AS CLAVE, C.RazonS AS CLIENTE FROM clientes AS C WHERE C.Estatus IN('ACTIVO') ORDER BY C.RazonS ASC;")->result();
                                foreach ($clientesPnl as $k => $v) {
                                    print "<option value=\"{$v->CLAVE}\">{$v->CLIENTE}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <div class="table-responsive" id="ClientesPrioridad">
                                <table id="tblClientesPrioridad" class="table table-sm  " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nombre</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptar">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlCapturaClientePrioridad = $('#mdlCapturaClientePrioridad');
    var btnVerEmpleados = $("#btnVerEmpleados");


    var tblClientesPrioridad = $('#tblClientesPrioridad');
    var ClientesPrioridad;

    $(document).ready(function () {
        mdlCapturaClientePrioridad.find("select").selectize({
            hideSelected: false,
            openOnFocus: false
        });

        mdlCapturaClientePrioridad.on('shown.bs.modal', function () {
            mdlCapturaClientePrioridad.find("input").val("");
            $.each(mdlCapturaClientePrioridad.find("select"), function (k, v) {
                mdlCapturaClientePrioridad.find("select")[k].selectize.clear(true);
            });
            mdlCapturaClientePrioridad.find('#Cliente').focus();
            getClientesPrioridad();
        });

        mdlCapturaClientePrioridad.find('#Cliente').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtCliente = $(this).val();
                if (txtCliente) {
                    $.getJSON(base_url + 'index.php/PrioridadesPorCliente/onVerificarClienteAgregarPrioridad', {Cliente: txtCliente}).done(function (data) {
                        if (data.length > 0) {
                            mdlCapturaClientePrioridad.find("#sCliente")[0].selectize.addItem(txtCliente, true);
                            mdlCapturaClientePrioridad.find('#btnAceptar').focus();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                mdlCapturaClientePrioridad.find('#sCliente')[0].selectize.clear(true);
                                mdlCapturaClientePrioridad.find('#Cliente').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });

        mdlCapturaClientePrioridad.find("#sCliente").change(function () {
            if ($(this).val()) {
                mdlCapturaClientePrioridad.find('#Cliente').val($(this).val());
                mdlCapturaClientePrioridad.find('#btnAceptar').focus();
            }
        });

        mdlCapturaClientePrioridad.find('#btnAceptar').on("click", function () {
            onDisable(mdlCapturaClientePrioridad.find('#btnAceptar'));
            var cliente = mdlCapturaClientePrioridad.find("#Cliente").val();
            $.ajax({
                url: base_url + 'index.php/PrioridadesPorCliente/onAgregarClientePrioridad',
                type: "POST",
                data: {
                    Cliente: cliente
                }
            }).done(function (data, x, jq) {
                onEnable(mdlCapturaClientePrioridad.find('#btnAceptar'));
                ClientesPrioridad.ajax.reload();
                mdlCapturaClientePrioridad.find('#sCliente')[0].selectize.clear(true);
                mdlCapturaClientePrioridad.find('#Cliente').val('').focus();
                HoldOn.close();
            }).fail(function (x, y, z) {
                onEnable(mdlCapturaClientePrioridad.find('#btnAceptar'));
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x, y, z);
                HoldOn.close();
            });
        });


    });

    function getClientesPrioridad() {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblClientesPrioridad')) {
            tblClientesPrioridad.DataTable().destroy();
        }
        ClientesPrioridad = tblClientesPrioridad.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": base_url + 'index.php/PrioridadesPorCliente/getClientesPrioridad',
                "dataType": "json",
                "type": 'POST',
                "dataSrc": ""
            },
            "columns": [
                {"data": "cliente"},
                {"data": "nomcliente"}
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": false,
            "displayLength": 100,
            scrollY: 300,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: false,
            "bSort": true,
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        $('#tblClientesPrioridad_filter input[type=search]').addClass('selectNotEnter');
        tblClientesPrioridad.find('tbody').on('click', 'tr', function () {
            tblClientesPrioridad.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }
</script>