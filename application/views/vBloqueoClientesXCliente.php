<div class="modal " id="mdlBloqueoClientesXCliente"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bloqueo de clientes para venta y pedidos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pnlCapturaBloqueoInd">
                <form id="frmCaptura">
                    <div class="row" id='selectEmpRecibos'>
                        <div class="col-8" >
                            <label>Cliente</label>
                            <select id="ClienteBloqInd" name="ClienteBloqInd" class="form-control form-control-sm ">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label>Motivo</label>
                            <input type="text" maxlength="150" class="form-control form-control-sm" id="MotivoBloqInd" name="MotivoBloqInd" required="">
                        </div>
                        <div class="col-12">
                            <label>Nota: <span class="badge badge-danger" style="font-size: 14px;">1=Bloquear, 2=Desbloquear</span></label>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-12 col-sm-6 col-md-3 col-xl-3">
                            <label>Bloqueo Venta</label>
                            <input type="text" maxlength="1" class="form-control form-control-sm numbersOnly " id="statusBloqInd" name="statusBloqInd" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-xl-3">
                            <label>Bloqueo Pedido</label>
                            <input type="text" maxlength="1" class="form-control form-control-sm numbersOnly " id="statusPedBloqInd" name="statusPedBloqInd" required="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptar">ACEPTAR</button>
                <button type="button" class="btn btn-success" id="btnConsultarBloqueados">CONSULTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlBloqueoClientesXCliente = $('#mdlBloqueoClientesXCliente');
    var existe = 0;
    $(document).ready(function () {
        mdlBloqueoClientesXCliente.on('shown.bs.modal', function () {
            mdlBloqueoClientesXCliente.find("input").val("");
            $.each(mdlBloqueoClientesXCliente.find("select"), function (k, v) {
                mdlBloqueoClientesXCliente.find("select")[k].selectize.clear(true);
            });
            mdlBloqueoClientesXCliente.find('#ClienteBloqInd')[0].selectize.focus();
            getClientesBloqueoInd();
        });
        mdlBloqueoClientesXCliente.find('#ClienteBloqInd').change(function () {
            if ($(this).val()) {
                //Ver si el cliente ya estaba bloqueado
                $.getJSON(base_url + 'index.php/Clientes/getClienteBloqueado', {Cliente: $(this).val()}).done(function (data) {
                    if (data.length > 0) {
                        mdlBloqueoClientesXCliente.find('#MotivoBloqInd').val(data[0].motivo);
                        mdlBloqueoClientesXCliente.find('#statusBloqInd').val(data[0].status);
                        mdlBloqueoClientesXCliente.find('#statusPedBloqInd').val(data[0].statusped);
                        existe = true;
                        mdlBloqueoClientesXCliente.find("#MotivoBloqInd").focus().select();
                    } else {
                        mdlBloqueoClientesXCliente.find('#MotivoBloqInd').val('');
                        mdlBloqueoClientesXCliente.find('#statusBloqInd').val('');
                        mdlBloqueoClientesXCliente.find('#statusPedBloqInd').val('');
                        existe = false;
                        mdlBloqueoClientesXCliente.find("#MotivoBloqInd").focus().select();
                    }
                }).fail(function (x) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });
        mdlBloqueoClientesXCliente.find("#MotivoBloqInd").keydown(function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                if ($(this).val()) {
                    mdlBloqueoClientesXCliente.find("#statusBloqInd").focus().select();
                }
            }
        });
        mdlBloqueoClientesXCliente.find("#statusBloqInd").keydown(function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                if ($(this).val()) {
                    mdlBloqueoClientesXCliente.find("#statusPedBloqInd").focus().select();
                } else {
                    $(this).val('0');
                    mdlBloqueoClientesXCliente.find("#statusPedBloqInd").focus().select();
                }
            }
        });
        mdlBloqueoClientesXCliente.find("#statusPedBloqInd").keydown(function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                if ($(this).val()) {
                    mdlBloqueoClientesXCliente.find("#btnAceptar").focus();
                } else {
                    $(this).val('0');
                    mdlBloqueoClientesXCliente.find("#btnAceptar").focus();
                }
            }
        });

        mdlBloqueoClientesXCliente.find('#btnConsultarBloqueados').click(function () {
            $('#mdlConsultaClientesBloqueo').modal('show');
        });

        mdlBloqueoClientesXCliente.find('#btnAceptar').click(function () {
            isValid('pnlCapturaBloqueoInd');
            if (valido) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlBloqueoClientesXCliente.find("#frmCaptura")[0]);
                frm.append('Existe', (existe) ? '1' : '0');
                $.ajax({
                    url: base_url + 'index.php/Clientes/onGuardarBloqueoInd',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    mdlBloqueoClientesXCliente.find("input").val("");
                    $.each(mdlBloqueoClientesXCliente.find("select"), function (k, v) {
                        mdlBloqueoClientesXCliente.find("select")[k].selectize.clear(true);
                    });
                    mdlBloqueoClientesXCliente.find('#ClienteBloqInd')[0].selectize.focus();
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }

        });

    });

    function getClientesBloqueoInd() {
        $.getJSON(base_url + 'index.php/Clientes/getClientes', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlBloqueoClientesXCliente.find("#ClienteBloqInd")[0].selectize.addOption({text: v.Cliente, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

</script>
<style>
    .text-strong {
        font-weight: bolder;
    }

    tr.group-start:hover td{
        background-color: #e0e0e0 !important;
        color: #000 !important;
    }
    tr.group-end td{
        background-color: #FFF !important;
        color: #000!important;
    } 

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>

<?php
$this->load->view('vConsultaClientesBloqueo');
