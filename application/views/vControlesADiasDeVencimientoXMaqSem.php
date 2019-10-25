<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Controles a dias de vencimiento por maquila</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-3">
                <label>Año</label>
                <input type="text" id="Ano" name="Ano" class="form-control form-control-sm  numeric" maxlength="4">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-3">
                <label>De la maquila</label>
                <input type="text" id="MaqInicial" name="MaqInicial" class="form-control form-control-sm numeric" autofocus="" maxlength="2">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-3">
                <label>A la maquila</label>
                <input type="text" id="MaqFinal" name="MaqFinal" class="form-control form-control-sm numeric" maxlength="2">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-3">
                <label>Dias</label>
                <input type="text" id="Dias" name="Dias" class="form-control form-control-sm numeric" maxlength="2">
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="right">
            <button type="button" class="btn btn-primary" id="btnAceptar">Aceptar</button>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), Anio = pnlTablero.find("#Ano"),
            MaquilaInicial = pnlTablero.find("#MaqInicial"),
            MaquilaFinal = pnlTablero.find("#MaqFinal"),
            btnAceptar = pnlTablero.find("#btnAceptar"),
            Dias = pnlTablero.find("#Dias");

    $(document).ready(function () {
        handleEnterDiv(pnlTablero);
        Anio.val(new Date().getFullYear());
        btnAceptar.click(function () {
            if (MaquilaInicial.val() && MaquilaFinal.val() &&
                    Dias.val() && Anio.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Por favor espere...'
                });
                btnAceptar.attr('disabled', true);
                var f = new FormData();
                f.append('MAQUILA_INICIAL', MaquilaInicial.val());
                f.append('MAQUILA_FINAL', MaquilaFinal.val());
                f.append('DIAS', Dias.val());
                f.append('ANIO', Anio.val());
                $.ajax({
                    url: '<?php print base_url('ControlesADiasDeVencimientoXMaqSem/getReporte'); ?>',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: f
                }).done(function (data, x, jq) {
                    onImprimirReporteFancy(data);
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                    btnAceptar.attr('disabled', false);
                });
            } else {
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR TODOS LOS CAMPOS', 'warning').then((value) => {
                    MaquilaInicial.focus().select();
                });
            }
        });
    });
</script>
<style>
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid;
        /*border-image: linear-gradient(to bottom,  #2196F3, #cc0066, rgb(0,0,0,0)) 1 100% ;*/
        border-image: linear-gradient(to bottom,  #0099cc, #ccff00, rgb(0,0,0,0)) 1 100% ;
    }
    .card-header{
        background-color: transparent;
        border-bottom: 0px;
    }
    #pnlTablero.card-body{
        padding-top: 10px;
    }
    .card-header{
        padding: 0px;
    }
</style>