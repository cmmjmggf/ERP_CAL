<div class="card m-3 border-0" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-6 col-sm-6 float-left">
                <legend class="float-left">Rastreo </legend>
            </div> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <label>Control</label>
                <input type="text" id="Control" name="Control" class="form-control">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <label>Semana</label>
                <input type="text" id="Semana" name="Semana" class="form-control">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <label>Empleado</label>
                <select id="Empleado" name="Empleado" class="form-control"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <label>Desc.Fraccion</label>
                <input type="text" id="DescFraccion" name="DescFraccion" class="form-control">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <label>Avance Actual</label>
                <input type="text" id="AvanceActual" name="AvanceActual" class="form-control">
            </div>
        </div>
        <table id="tblAvance" class="table table-hover table-sm table-bordered  compact nowrap" style="width: 100% !important;">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Control</th>
                    <th scope="col">Empleado</th>

                    <th scope="col">Estilo</th>
                    <th scope="col">Frac.</th>
                    <th scope="col">Fecha</th>
                    
                    <th scope="col">Sem</th>
                    <th scope="col">Pares</th>

                    <th scope="col">Precio</th>
                    <th scope="col">SubTotal</th> 
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>