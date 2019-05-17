<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Inventario proceso por departamento</h3>
    </div>
    <div class="card-body">
        <div class="row" align="center">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-2"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                <label>Año</label>
                <input type="text" id="Ano" name="Ano" class="form-control form-control-sm  numbersOnly" autofocus="">
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-2"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                <label>De la maquila</label>
                <input type="text" id="FechaInicial" name="FechaInicial" class="form-control form-control-sm date" autofocus="">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                <label>A la maquila</label>
                <input type="text" id="FechaFinal" name="FechaFinal" class="form-control form-control-sm date" autofocus="">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-2"></div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-2"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                <label>De la semana</label>
                <input type="text" id="FechaInicial" name="FechaInicial" class="form-control form-control-sm date" autofocus="">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                <label>A la semana</label>
                <input type="text" id="FechaFinal" name="FechaFinal" class="form-control form-control-sm date" autofocus="">
            </div> 
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-2"></div>
            <div class="w-100 my-3"></div>
        </div>
    </div>
    <div class="card-footer">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="right">
            <button type="button" class="btn btn-primary" id="btnAceptar">Aceptar</button>
        </div>
    </div>
</div>
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