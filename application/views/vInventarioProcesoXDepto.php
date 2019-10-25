<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Inventario proceso por departamento</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-1"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-2">
                <label>Año</label>
                <input type="text" id="Ano" name="Ano" class="form-control form-control-sm  numeric" maxlength="4">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-2">
                <label>De la maquila</label>
                <input type="text" id="MaquilaInicial" name="MaquilaInicial" class="form-control form-control-sm numeric" autofocus="" maxlength="2">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-2">
                <label>A la maquila</label>
                <input type="text" id="MaquilaFinal" name="MaquilaFinal" class="form-control form-control-sm numeric" maxlength="2">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-2">
                <label>De la semana</label>
                <input type="text" id="SemanaInicial" name="SemanaInicial" class="form-control form-control-sm numeric" maxlength="2">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-2">
                <label>A la semana</label>
                <input type="text" id="SemanaFinal" name="SemanaFinal" class="form-control form-control-sm numeric" maxlength="2">
            </div>
            <div class="w-100 my-2"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-10"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="SemanaDias" description="SEMANA DIAS">
                    <label class="custom-control-label" for="SemanaDias" >SEMANA DIAS</label>
                </div>
            </div>
            <div class="w-100 my-3"></div>
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
            MaquilaInicial = pnlTablero.find("#MaquilaInicial"),
            MaquilaFinal = pnlTablero.find("#MaquilaFinal"),
            btnAceptar = pnlTablero.find("#btnAceptar"),
            SemanaInicial = pnlTablero.find("#SemanaInicial"),
            SemanaFinal = pnlTablero.find("#SemanaFinal"),
            SemanaDias = pnlTablero.find("#SemanaDias");

    $(document).ready(function () {
        handleEnterDiv(pnlTablero);
        Anio.val(new Date().getFullYear());

        btnAceptar.click(function () {
            if (MaquilaInicial.val() && MaquilaFinal.val() &&
                    SemanaInicial.val() && SemanaFinal.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Por favor espere...'
                });
                btnAceptar.attr('disabled', true);
                var f = new FormData();
                f.append('MAQUILA_INICIAL', MaquilaInicial.val());
                f.append('MAQUILA_FINAL', MaquilaFinal.val());
                f.append('SEMANA_INICIAL', SemanaInicial.val());
                f.append('SEMANA_FINAL', SemanaFinal.val());
                f.append('ANIO', Anio.val());
                f.append('TIPO', (SemanaDias[0].checked) ? 1 : 2);
                $.ajax({
                    url: '<?php print base_url('InventarioProcesoXDepto/getReporte'); ?>',
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
    .card-body{
        padding-top: 10px;
    }
    .card-header{
        padding: 0px;
    }
</style>