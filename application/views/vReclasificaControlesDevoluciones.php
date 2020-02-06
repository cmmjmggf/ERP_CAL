<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Reclasifica Controles en Devoluciones</legend>
            </div>
            <div class="col-sm-6 float-right" align="right"></div>
        </div>
        <hr>
        <div class="card-block">
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">
                    <label>Control</label>
                    <input type="text" id="Control" name="Control" class="form-control form-control-sm numbersOnly" maxlength="9">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-1">
                    <label>Estilo</label>
                    <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
                    <label>Color</label>
                    <input type="text" id="Color" name="Color" class="form-control form-control-sm" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-1">
                    <label>Pares</label>
                    <input type="text" id="Pares" name="Pares" class="form-control form-control-sm" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
                    <label>Cliente</label>
                    <div class="row">
                        <div class="col-3">
                            <input type="text" id="xCliente" name="xCliente" class="form-control form-control-sm numbersOnly notdot" readonly="" maxlength="15">
                        </div>
                        <div class="col-9">
                            <input type="text" id="Cliente" name="Cliente" class="form-control form-control-sm" readonly="" maxlength="600">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">
                    <label>Estatus Actual</label>
                    <input type="text" id="ClasifAct" name="ClasifAct" class="form-control form-control-sm azul" readonly="">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                    <label for="" >Estatus <span class="badge badge-info" style="font-size:14px;">1- P'Venta,    2- Saldos,   3- P'Reparacion</span></label>
                    <select id="Clasif" name="Clasif" class="form-control form-control-sm required" required="">
                        <option value=""></option>
                        <option value="1">1 PARA VENTA</option>
                        <option value="2">2 SALDOS</option>
                        <option value="3">3 PARA REPARACIÓN</option>
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-1 mt-4" >
                    <button type="button" id="btnAceptar" class="btn btn-primary btn-sm d-sm-block">
                        <span class="fa fa-check"></span> ACEPTAR
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/ReclasificaControlesDevoluciones/';
    var pnlTablero = $('#pnlTablero');
    var Control = pnlTablero.find('#Control');
    var Clasif = pnlTablero.find('#Clasif');
    var btnAceptar = pnlTablero.find('#btnAceptar');
    $(document).ready(function () {
        init();
        Control.keypress(function (e) {
            var contr = $(this).val();
            if (e.keyCode === 13 && contr) {
                $.getJSON(master_url + 'onVerificarControlDevoluciones', {
                    Control: contr
                }).done(function (data) {
                    console.log(data);
                    if (data.length > 0) {//SI EL CONTROL EXISTE

                        pnlTablero.find('#Estilo').val(data[0].estilo);
                        pnlTablero.find('#Color').val(data[0].comb + ' ' + data[0].nomcolor);
                        pnlTablero.find('#Pares').val(data[0].paredev);
                        pnlTablero.find('#xCliente').val(data[0].cliente);
                        pnlTablero.find('#Cliente').val(data[0].nomcliente);
                        pnlTablero.find('#ClasifAct').val(data[0].clasif);

                        Clasif[0].selectize.clear(true);
                        Clasif[0].selectize.open();
                        Clasif[0].selectize.focus();
                    } else {//EL CONTROL NO EXISTE EN DEVOLUCIONNP
                        swal({
                            title: "ATENCIÓN",
                            text: "EL CONTROL NO EXISTE EN DEVOLUCIONES Ó YA ESTÁ RE-FACTURADO",
                            icon: "warning"
                        }).then((value) => {
                            pnlTablero.find('#Estilo').val('');
                            pnlTablero.find('#Color').val('');
                            pnlTablero.find('#Pares').val('');
                            pnlTablero.find('#xCliente').val('');
                            pnlTablero.find('#Cliente').val('');
                            pnlTablero.find('#ClasifAct').val('');
                            Clasif[0].selectize.clear(true);
                            Control.val('').focus();
                        });
                    }
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });
        Clasif.change(function () {
            if ($(this).val()) {
                btnAceptar.focus();
            }
        });
        btnAceptar.on("click", function () {
            $.post(master_url + 'onReclasificaDevoluciones', {
                Control: Control.val(),
                Clasif: Clasif.val()
            }).done(function (data) {
                console.log(data);
                onNotifyOld('', 'RECLASIFICACION CORRECTA', 'success');
                pnlTablero.find('#Estilo').val('');
                pnlTablero.find('#Color').val('');
                pnlTablero.find('#Pares').val('');
                pnlTablero.find('#xCliente').val('');
                pnlTablero.find('#Cliente').val('');
                pnlTablero.find('#ClasifAct').val('');
                Clasif[0].selectize.clear(true);
                Control.val('').focus();
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });
        });
    });
    function init() {
        Control.focus();
    }
</script>
<style>
    .text-strong {
        font-weight: bolder;
    }
    .azul  {
        background-color: #4BEFF1 !important;
    }

</style>