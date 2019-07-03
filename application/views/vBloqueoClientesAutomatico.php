<div class="modal " id="mdlBloqueoClientesAutomatico"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bloqueo automático de clientes morosos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pnlCapturaBloqueoAut">
                <form id="frmCaptura">

                    <div class="row">
                        <div class="col-4">
                            <div class="form-group" id ="dDiasBloq">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="rBloAut1" name="customRadio" class="custom-control-input" data-value="45">
                                    <label class="custom-control-label text-info labelCheck" for="rBloAut1">45 Días</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="rBloAut2" name="customRadio" class="custom-control-input" data-value="60">
                                    <label class="custom-control-label text-info labelCheck" for="rBloAut2">60 Días</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="rBloAut3" name="customRadio" class="custom-control-input" data-value="90">
                                    <label class="custom-control-label text-info labelCheck" for="rBloAut3">90 Días</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-3">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="chFactAut" name="chFactAut">
                                <label class="custom-control-label text-danger labelCheck" for="chFactAut">Facturación</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="chPedAut" name="chPedAut">
                                <label class="custom-control-label text-danger labelCheck" for="chPedAut">Pedidos</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptar">ACEPTAR</button>
                <button type="button" class="btn btn-success" id="btnConsultarBloqueadosAut">CONSULTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlBloqueoClientesAutomatico = $('#mdlBloqueoClientesAutomatico');
    var dias = 0;
    $(document).ready(function () {
        mdlBloqueoClientesAutomatico.on('shown.bs.modal', function () {
            handleEnterDiv(mdlBloqueoClientesAutomatico);
            mdlBloqueoClientesAutomatico.find("input").val("");
            $.each(mdlBloqueoClientesAutomatico.find("select"), function (k, v) {
                mdlBloqueoClientesAutomatico.find("select")[k].selectize.clear(true);
            });
        });

        mdlBloqueoClientesAutomatico.find('#btnConsultarBloqueadosAut').click(function () {
            $('#mdlConsultaClientesBloqueoAut').modal('show');
        });

        mdlBloqueoClientesAutomatico.find('#dDiasBloq .custom-radio').on('click', function (event) {
            dias = $(this).find('input').attr('data-value');
        });

        mdlBloqueoClientesAutomatico.find('#btnAceptar').click(function () {
            if (dias > 0) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlBloqueoClientesAutomatico.find("#frmCaptura")[0]);
                frm.append('Dias', dias);
                frm.append('Facturacion', (mdlBloqueoClientesAutomatico.find("#chFactAut")[0].checked) ? '1' : '0');
                frm.append('Pedido', (mdlBloqueoClientesAutomatico.find("#chPedAut")[0].checked) ? '1' : '0');
                $.ajax({
                    url: base_url + 'index.php/Clientes/onGuardarBloqueoAut',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    if (data === '1') {
                        swal({
                            title: "ATENCIÓN",
                            text: "NO EXISTEN CLIENTES MOROSOS ACTUALMENTE",
                            icon: "error"
                        });
                    }
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE SELECCIONAR UNA OPCIÓN DE DÍAS",
                    icon: "error"
                });
            }
        });
    });
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
    td{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>

<?php
$this->load->view('vConsultaClientesBloqueoAut');
