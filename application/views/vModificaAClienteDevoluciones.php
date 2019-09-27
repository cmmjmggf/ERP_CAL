<div id="mdlModificaAClienteDevoluciones" class="modal">
    <div class="modal-dialog notdraggable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <span class="fa fa-exchange-alt"></span> Modifica cliente a devoluciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <label>Cliente</label>
                        <select id="ClienteMCD" name="ClienteMCD" class="form-control form-control-sm">
                            <option></option>
                            <?php
                            /* YA CONTIENE LOS BLOQUEOS DE VENTA */
                            $dtm = $this->db->query("SELECT C.Clave AS CLAVE, CONCAT(C.Clave, \" - \",C.RazonS) AS CLIENTE, C.Zona AS ZONA, C.ListaPrecios AS LISTADEPRECIO FROM clientes AS C INNER JOIN devolucionnp AS D ON C.Clave = D.cliente WHERE C.Estatus IN('ACTIVO') AND D.staapl = 1 ORDER BY ABS(C.Clave) ASC;")->result();
                            foreach ($dtm as $k => $v) {
                                print "<option value='{$v->CLAVE}'>{$v->CLIENTE}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <p class="font-weight-bold text-danger">Controles por aplicar de este cliente</p>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblControlesXAplicarDeEsteCliente" class="table table-hover table-sm"  style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th><!--0-->
                                    <th scope="col">Cliente</th><!--1-->
                                    <th scope="col">Control</th><!--2-->
                                    <th scope="col">Pares</th><!--3-->
                                    <th scope="col">Reg</th><!--4--> 
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>

<div id="mdlSeleccionaCliente" class="modal">
    <div class="modal-dialog notdraggable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <span class="fa fa-exchange-alt"></span> Seleccione un cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <input type="text" id="IDANTERIOR" name="IDANTERIOR" class="form-control d-none" readonly="">
                        <input type="text" id="ClienteViejo" name="ClienteViejo" class="form-control d-none" readonly="">
                        <label>Cliente</label>
                        <select id="ClienteAModificar" name="ClienteAModificar" class="form-control form-control-sm">
                            <option></option>
                            <?php
                            /* YA CONTIENE LOS BLOQUEOS DE VENTA */
                            foreach ($dtm as $k => $v) {
                                print "<option value='{$v->CLAVE}'>{$v->CLIENTE}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>

<script>
    var mdlModificaAClienteDevoluciones = $("#mdlModificaAClienteDevoluciones"),
            mdlSeleccionaCliente = $("#mdlSeleccionaCliente"),
            ClienteAModificar = mdlSeleccionaCliente.find("#ClienteAModificar"),
            ClienteMCD = mdlModificaAClienteDevoluciones.find("#ClienteMCD"),
            ControlesXAplicarDeEsteCliente,
            tblControlesXAplicarDeEsteCliente = mdlModificaAClienteDevoluciones.find("#tblControlesXAplicarDeEsteCliente");

    $(document).ready(function () {

        ClienteMCD.change(function () {
            ControlesXAplicarDeEsteCliente.ajax.reload(function () {
                onCloseOverlay();
            });
        });

        mdlSeleccionaCliente.on('shown.bs.modal', function () {
            ClienteAModificar[0].selectize.focus(); 
        });
        
        mdlSeleccionaCliente.on('hidden.bs.modal', function () {
            ClienteAModificar[0].selectize.clear(); 
        });

        ClienteAModificar.change(function () {
            if (ClienteAModificar.val()) {
                var p = {
                    ID: mdlSeleccionaCliente.find("#IDANTERIOR").val(),
                    CLIENTE: mdlSeleccionaCliente.find("#ClienteViejo").val(),
                    CLIENTE_NUEVO: mdlSeleccionaCliente.find("#ClienteAModificar").val()
                };
                $.post('<?php print base_url('ModificaAClienteDevoluciones/onCambiarClienteAcontrol') ?>', p).done(function (aaa) {
                    console.log(aaa);
                    mdlSeleccionaCliente.modal('hide');
                    onNotifyOld('', 'CLIENTE MODIFICADO', 'success');
                    ControlesXAplicarDeEsteCliente.ajax.reload(function () {
                        onCloseOverlay();
                    });
                }).fail(function (x) {
                    getError(x)
                }).always(function () {

                });
            }
        });

        mdlModificaAClienteDevoluciones.on('shown.bs.modal', function () {
            ClienteMCD[0].selectize.clear();
            if ($.fn.DataTable.isDataTable('#tblControlesXAplicarDeEsteCliente')) {
                ControlesXAplicarDeEsteCliente.ajax.reload(function () {
                    onCloseOverlay();
                });
            } else {
                getControlesXAplicarDeEsteCliente();
            }
        });
    });

    function getControlesXAplicarDeEsteCliente() {
        $.fn.dataTable.ext.errMode = 'throw';
        ControlesXAplicarDeEsteCliente = tblControlesXAplicarDeEsteCliente.DataTable({
            "dom": 'rtip',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": '<?php print base_url('ModificaAClienteDevoluciones/getControlesConDevolucionesSinAplicar'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = ClienteMCD.val() ? ClienteMCD.val() : '';
                }
            },
            "columns": [
                {"data": "ID"},
                {"data": "CLIENTE"},
                {"data": "CONTROL"},
                {"data": "PARES"},
                {"data": "REG"}
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
            "displayLength": 99,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "scrollY": 250,
            "scrollX": true,
            "bSort": true,
            "aaSorting": [
                [0, 'desc']
            ],
            initComplete: function (a, b) {
                onCloseOverlay();
            }
        });
        var row_data;
        tblControlesXAplicarDeEsteCliente.find('tbody').on('click', 'tr', function () {
            var dtm = ControlesXAplicarDeEsteCliente.row(this).data();
            row_data = dtm;
            mdlSeleccionaCliente.find("#IDANTERIOR").val(dtm.ID);
            mdlSeleccionaCliente.find("#ClienteViejo").val(dtm.CLIENTE);
            mdlSeleccionaCliente.modal('show');
        });
    }
</script>  

