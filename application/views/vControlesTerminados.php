<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header">   
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-xl-12 col-lg-12 text-center">
                <h3 class="font-weight-bold" style="margin-bottom: 0px;">Controles terminados</h3>
            </div>
        </div>
    </div>
    <div class="card-body" style="padding-top: 0px; padding-bottom: 10px;">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Maquila</label>
                <select id="Maquila" name="Maquila" class="form-control form-control-sm"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Reproceso</label>
                <input type="text" id="Reproceso" name="Reproceso" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Precio</label>
                <input type="text" id="Precio" name="Precio" class="form-control form-control-sm numericdot">
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Control</label>
                <input type="text" id="Control" name="Control" class="form-control form-control-sm numeric">
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Docto</label>
                <input type="text" id="Docto" name="Docto" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Estilo</label>
                <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Color</label>
                <select id="Color" name="Color" class="form-control form-control-sm"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-1 col-lg-1 col-xl-1">
                <label>Semana</label>
                <input type="text" id="Semana" name="Semana" class="form-control form-control-sm numeric">
            </div>
            <div class="col-12 col-xs-12 col-sm-1 col-lg-1 col-xl-1 mt-4">
                <button type="button" id="btnAceptar" name="btnAceptar" class="btn btn-primary">
                    <span class="fa fa-check"></span>
                </button>
            </div>

            <div class="w-100 my-3"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <h4>Controles terminados</h4>
                <table id="tblControlesTerminados" class="table  table-sm table-bordered" style="width:  100%;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Control</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">sts</th>
                            <th scope="col">Fca</th>

                            <th scope="col">Linea</th>
                            <th scope="col">Estilo</th>
                            <th scope="col">Com</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Docto</th>

                            <th scope="col">Def</th>
                            <th scope="col">Deta</th>
                            <th scope="col">Pares</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <h4>Controles rechazados</h4>
                <table id="tblControlesRechazados" class="table table-hover table-sm table-bordered  compact nowrap" style="width:  100%;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Control</th>
                            <th scope="col">Defecto</th>
                            <th scope="col">Detalle</th>
                            <th scope="col">Fca</th>

                            <th scope="col">Sem</th>
                            <th scope="col">Docto</th> 
                            <th scope="col">Fecha</th> 
                            <th scope="col">Pares</th> 
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero div.card-body");
    var Maquila = pnlTablero.find("#Maquila"), Reproceso = pnlTablero.find("#Reproceso"),
            Precio = pnlTablero.find("#Precio"), Control = pnlTablero.find("#Control"),
            Docto = pnlTablero.find("#Docto"), Estilo = pnlTablero.find("#Estilo"),
            Color = pnlTablero.find("#Color"), Semana = pnlTablero.find("#Semana"),
            ControlesTerminados, tblControlesTerminados = pnlTablero.find("#tblControlesTerminados"),
            ControlesRechazados, tblControlesRechazados = pnlTablero.find("#tblControlesRechazados"),
            btnAceptar = pnlTablero.find("#btnAceptar");

    $(document).ready(function () {
        
        getMaquilas();
        
        btnAceptar.click(function () {
            
        });
        
        ControlesTerminados = tblControlesTerminados.DataTable();
        ControlesRechazados = tblControlesRechazados.DataTable();
    });

    function getMaquilas() {
        $.getJSON('<?php print base_url('avance_a_pespunte_x_maquila_maquilas'); ?>').done(function (x, y, z) {
            x.forEach(function (i) {
                Maquila[0].selectize.addOption({text: i.MAQUILA, value: i.CLAVE});
            });
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            swal('OPS!', 'ALGO SALIO MAL, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
        }).always(function () {

        });
    }
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
</style>