<div class="modal " id="mdlCajasFlete"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica cajas p/ flete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pnlCapturaCajasFlete">
                <form id="frmCaptura">
                    <div class="row" id='selectEmpRecibos'>
                        <div class="col-9" >
                            <label>Cliente</label>
                            <select id="ClienteCajasFlete" name="ClienteCajasFlete" class="form-control form-control-sm ">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>Tp</label>
                            <input type="text" maxlength="1" class="form-control form-control-sm numbersOnly " id="TpCajaFlete" name="TpCajaFlete" required="">
                        </div>
                        <div class="col-6">
                            <label>Documento</label>
                            <input type="text" maxlength="15" class="form-control form-control-sm" id="DocCajasFlete" name="DocCajasFlete" required="">
                        </div>
                        <div class="col-3">
                            <label>Cajas</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly " id="CajasFlete" name="CajasFlete" required="">
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
    var mdlCajasFlete = $('#mdlCajasFlete');
    var existe = 0;
    $(document).ready(function () {
        mdlCajasFlete.on('shown.bs.modal', function () {
            mdlCajasFlete.find("input").val("");
            $.each(mdlCajasFlete.find("select"), function (k, v) {
                mdlCajasFlete.find("select")[k].selectize.clear(true);
            });
            mdlCajasFlete.find('#ClienteCajasFlete')[0].selectize.focus();
            getClientesCajasFlete();
        });
        mdlCajasFlete.find('#ClienteCajasFlete').change(function () {
            if ($(this).val()) {
                mdlCajasFlete.find("#TpCajaFlete").focus().select();
            }
        });

        mdlCajasFlete.find("#TpCajaFlete").keydown(function (e) {
            if (e.keyCode === 13) {
                var tp = parseInt($(this).val());
                if (tp === 1 || tp === 2) {
                    mdlCajasFlete.find("#DocCajasFlete").focus().select();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        buttons: false,
                        timer: 1000
                    }).then((action) => {
                        $(this).val('').focus();
                    });
                }
            }
        });

        mdlCajasFlete.find("#DocCajasFlete").keydown(function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                if ($(this).val()) {
                    var tp = mdlCajasFlete.find("#TpCajaFlete").val();
                    var cliente = mdlCajasFlete.find("#ClienteCajasFlete").val();
                    $.getJSON(base_url + 'index.php/Clientes/onVerificarExistePedidoFactura', {Doc: $(this).val(), Tp: tp, Cliente: cliente}).done(function (data) {
                        if (data.length > 0) {
                            mdlCajasFlete.find("#CajasFlete").focus().select();
                        } else {
                            swal({
                                title: "ATENCIÓN",
                                text: "NO EXISTEN DOCUMENTOS DE ESTE CLIENTE,TP",
                                icon: "error",
                                closeOnClickOutside: false,
                                closeOnEsc: false
                            }).then((action) => {
                                mdlCajasFlete.find("#DocCajasFlete").val('').focus();
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlCajasFlete.find("#CajasFlete").keydown(function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                if ($(this).val()) {
                    mdlCajasFlete.find("#btnAceptar").focus();
                }
            }
        });

        mdlCajasFlete.find('#btnAceptar').click(function () {
            onDisable(mdlCajasFlete.find('#btnAceptar'));
            isValid('pnlCapturaCajasFlete');
            if (valido) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlCajasFlete.find("#frmCaptura")[0]);
                $.ajax({
                    url: base_url + 'index.php/Clientes/onCapturarCajasFlete',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    mdlCajasFlete.find("input").val("");
                    $.each(mdlCajasFlete.find("select"), function (k, v) {
                        mdlCajasFlete.find("select")[k].selectize.clear(true);
                    });
                    mdlCajasFlete.find('#ClienteCajasFlete')[0].selectize.focus();
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                }).always(function () {
                    onEnable(mdlCajasFlete.find('#btnAceptar'));
                });
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });
    });

    function getClientesCajasFlete() {
        $.getJSON(base_url + 'index.php/Clientes/getClientes', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlCajasFlete.find("#ClienteCajasFlete")[0].selectize.addOption({text: v.Cliente, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

</script>
