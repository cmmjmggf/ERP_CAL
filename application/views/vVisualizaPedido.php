<div class="modal " id="mdlReimprimirPedido"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reimprimir Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-9" >
                            <label>Cliente</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm  numbersOnly " id="ClienteVisPed" name="ClienteVisPed" maxlength="6" required="">
                                </div>
                                <div class="col-9">
                                    <select id="sClienteVisPed" name="sClienteVisPed" class="form-control form-control-sm required NotSelectize selectNotEnter" required="" >
                                        <option value=""></option>
                                        <?php
                                        $clientesPnl = $this->db->query("SELECT C.Clave AS CLAVE, C.RazonS AS CLIENTE FROM clientes AS C WHERE C.Estatus IN('ACTIVO') ORDER BY C.RazonS ASC;")->result();
                                        foreach ($clientesPnl as $k => $v) {
                                            print "<option value=\"{$v->CLAVE}\">{$v->CLIENTE}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>Pedido</label>
                            <input type="text" maxlength="15" class="form-control form-control-sm numeric" id="Pedido" name="Pedido" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlReimprimirPedido = $('#mdlReimprimirPedido');
    $(document).ready(function () {

        mdlReimprimirPedido.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });

        mdlReimprimirPedido.on('shown.bs.modal', function () {
            mdlReimprimirPedido.find("input").val("");
            $.each(mdlReimprimirPedido.find("select"), function (k, v) {
                mdlReimprimirPedido.find("select")[k].selectize.clear(true);
            });

            mdlReimprimirPedido.find('#ClienteVisPed').focus();
        });

        mdlReimprimirPedido.find('#ClienteVisPed').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtCliente = $(this).val();
                if (txtCliente) {
                    $.getJSON(base_url + 'index.php/PrioridadesPorCliente/onVerificarClienteAgregarPrioridad', {Cliente: txtCliente}).done(function (data) {
                        if (data.length > 0) {
                            mdlReimprimirPedido.find("#sClienteVisPed")[0].selectize.addItem(txtCliente, true);
                            mdlReimprimirPedido.find('#Pedido').focus().select();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                mdlReimprimirPedido.find('#sClienteVisPed')[0].selectize.clear(true);
                                mdlReimprimirPedido.find('#ClienteVisPed').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });

        mdlReimprimirPedido.find("#sClienteVisPed").change(function () {
            if ($(this).val()) {
                mdlReimprimirPedido.find('#Cliente').val($(this).val());
                mdlReimprimirPedido.find('#Pedido').focus().select();
            }
        });
        mdlReimprimirPedido.find("#Pedido").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlReimprimirPedido.find('#btnImprimir').focus();
                }
            }
        });
        mdlReimprimirPedido.find('#btnImprimir').on("click", function () {
            onDisable(mdlReimprimirPedido.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var cliente = mdlReimprimirPedido.find("#ClienteVisPed").val();
            var clave = mdlReimprimirPedido.find("#Pedido").val();
            $.post(base_url + 'index.php/Pedidos/onImprimirPedidoReducido', {ID: clave, CLIENTE: cliente}).done(function (data) {
                //check Apple device
                onEnable(mdlReimprimirPedido.find('#btnImprimir'));
                $.fancybox.open({
                    src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
                    type: 'iframe',
                    opts: {
                        afterShow: function (instance, current) {
                            console.info('done!');
                        },
                        iframe: {
                            // Iframe template
                            tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                            preload: true,
                            // Custom CSS styling for iframe wrapping element
                            // You can use this to set custom iframe dimensions
                            css: {
                                width: "100%",
                                height: "100%"
                            },
                            // Iframe tag attributes
                            attr: {
                                scrolling: "auto"
                            }
                        }
                    }
                });

            }).fail(function (x, y, z) {
                onEnable(mdlReimprimirPedido.find('#btnImprimir'));
                HoldOn.close();
                console.log(x, y, z);
                swal('ATENCIÓN', 'NO HA SIDO POSIBLE MOSTRAR EL PEDIDO PARA SU IMPRESIÓN,VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'warning');
            }).always(function () {
                onEnable(mdlReimprimirPedido.find('#btnImprimir'));
                HoldOn.close();
            });

        });


    });
</script>
