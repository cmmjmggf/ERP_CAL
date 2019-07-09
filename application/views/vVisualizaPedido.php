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
                        <div class="col-12 col-xs-12 col-sm-12">
                            <label>Cliente</label>
                            <select id="ClienteVisPed" name="Cliente" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
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
        validacionSelectPorContenedor(mdlReimprimirPedido);
        setFocusSelectToInputOnChange('#ClienteVisPed', '#Pedido', mdlReimprimirPedido);

        handleEnterDiv(mdlReimprimirPedido);

        mdlReimprimirPedido.on('shown.bs.modal', function () {
            mdlReimprimirPedido.find("input").val("");
            $.each(mdlReimprimirPedido.find("select"), function (k, v) {
                mdlReimprimirPedido.find("select")[k].selectize.clear(true);
            });
            getClientesVisPed();
            mdlReimprimirPedido.find('#ClienteVisPed')[0].selectize.focus();
        });

        mdlReimprimirPedido.find('#Pedido').on("keyup", function (e) {

        });

        mdlReimprimirPedido.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var cliente = mdlReimprimirPedido.find("#ClienteVisPed").val();
            var clave = mdlReimprimirPedido.find("#Pedido").val();
            $.post(base_url + 'index.php/Pedidos/onImprimirPedidoReducido', {ID: clave, CLIENTE: cliente}).done(function (data) {
                //check Apple device

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
                HoldOn.close();
                console.log(x, y, z);
                swal('ATENCIÓN', 'NO HA SIDO POSIBLE MOSTRAR EL PEDIDO PARA SU IMPRESIÓN,VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'warning');
            }).always(function () {
                HoldOn.close();
            });

        });


    });

    function getClientesVisPed() {
        $.getJSON(base_url + 'index.php/PrioridadesPorCliente/getClientes').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlReimprimirPedido.find("#ClienteVisPed")[0].selectize.addOption({text: v.Cliente, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

</script>
