<div class="card m-3 animated fadeIn" id="mdlConsumosPielForro">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Consumo piel forro, cortador</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Maquila</label>
                <input type="text" id="Maquila" name="Maquila" class="form-control form-control-sm" autofocus="">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>De sem</label>
                <input type="text" id="SemanaInicial" name="SemanaInicial" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>A sem</label>
                <input type="text" id="SemanaFinal" name="SemanaFinal" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Año</label>
                <input type="text" id="Ano" name="Ano" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Cortador</label>
                <select id="Cortador" name="Cortador" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Articulo</label>
                <select id="Articulo" name="Articulo" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Fecha Inicial</label>
                <input type="text" id="FechaInicial" name="FechaInicial"  class="form-control form-control-sm date notEnter" placeholder="" >
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Fecha Final</label>
                <input type="text" id="FechaFinal" name="FechaFinal"  class="form-control form-control-sm date notEnter" placeholder="" >
            </div> 
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-2">
                <div class="alert alert-dismissible alert-danger"> 
                    <strong>Nota!</strong> Si desea información entre fechas solo capture maquila y fechas.
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-2">
                <div class="alert alert-dismissible alert-danger"> 
                    <strong>Nota!</strong> El resultado de este reporte es lo que se ha entregado de almacen a corte solamente. No tiene que ser el programa completo.
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2" align="center">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info" id="btnAceptarPiel" name="btnAceptarPiel">CONSUMO DE PIEL</button>
                    <button type="button" class="btn btn-primary" id="btnAceptarForro" name="btnAceptarForro">CONSUMO DE FORRO</button>
                    <button type="button" class="btn btn-warning" id="btnAceptarPielGeneral" name="btnAceptarPielGeneral">CONSUMO DE PIEL GENERAL</button>
                    <button type="button" class="btn btn-danger" id="btnAceptarForroGeneral" name="btnAceptarForroGeneral">CONSUMO DE FORRO GENERAL</button>
                </div>
            </div>
        </div>
    </div>
</div>