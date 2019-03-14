<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body "> 
        <div class="row">
            <div class="col-sm-2 float-left">
                <legend class="float-left">Piochas</legend>
            </div>
            <div class="col-sm-9">
                <input type="text" id="NumeroDePedido" name="NumeroDePedido" style="font-size: 19px; font-style: italic;" class="form-control form-control-sm noBorders notEnter numbersOnly" autofocus="" placeholder="# # # # #">
            </div>
            <div class="col-sm-1 float-right" align="right">
                <button type="button" class="btn btn-primary selectNotEnter" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar">
                    <span class="fa fa-plus"></span><br>
                </button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Piochas" class="table-responsive">
                <table id="tblPiochas" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Clave</th>
                            <th>Cliente</th>
                            <th>Agente</th>  
                            <th>Pares</th>
                            <th>Fecha de entrega</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="d-none animated fadeIn text-dark" id="pnlDatos">
    <form id="frmNuevo">
        <fieldset>
            <!--PRIMER CONTENEDOR-->
            <div class="card  m-3 ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 float-left">
                            <legend >Pedido</legend>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6" align="center">
                            <button type="button" class="btn btn-primary btn-sm" id="btnCapacidad" onclick="onComprobarCapacidades('#Maquila')" data-toggle="tooltip" data-placement="bottom" title="Comprobar capacidad de la maquila">
                                <span class="fa fa-eye" ></span>
                            </button>
                        </div>
                        <div class="col-12 col-sm-12 col-md-3  col-lg-3" align="right">
                            <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                                <span class="fa fa-arrow-left" ></span> REGRESAR
                            </button>
                            <button type="button" class="btn btn-info btn-sm" id="btnImprimir" >
                                <span class="fa fa-print" ></span> IMPRIMIR
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="d-none">
                            <input type="text" id="ID" name="ID" class="form-control form-control-sm d-none" readonly="" >
                            <input type="text" id="pedcte" name="pedcte" class="form-control form-control-sm" readonly="" >
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-2 col-xl-1">
                            <label for="Pedido" >Pedido*</label>
                            <input type="text" class="form-control form-control-sm numbersOnly selectNotEnter" id="Clave" required="" placeholder="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                            <label for="Cliente" >Cliente*</label>
                            <select class="form-control form-control-sm" id="Cliente" name="Cliente" required="" placeholder="">
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                            <label for="Agente" >Agente*</label>
                            <select class="form-control form-control-sm" id="Agente" name="Agente" required="" placeholder="">
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-2">
                            <label for="FechaPedido" >Fec-Pedido*</label>
                            <input type="text" id="FechaPedido" name="FechaPedido" class="form-control form-control-sm date notEnter" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                            <label for="FechaEntrega" >Fec-Entrega*</label>
                            <input type="text" id="FechaEntrega" name="FechaEntrega" class="form-control form-control-sm date notEnter">
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-1">
                            <label for="FechaRecepcion" >Fec-Recep*</label>
                            <input type="text" id="FechaRecepcion" name="FechaRecepcion" class="form-control form-control-sm date notEnter" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-1">
                            <label for="Recibido" >Recibido*</label>
                            <select class="form-control form-control-sm" id="Recibido" name="Recibido" required placeholder="">
                                <option></option>
                                <option value="1">1 - Age</option>
                                <option value="3">3 - Tel</option>
                                <option value="4">4 - Per</option>
                                <option value="5">5 - Int</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<script>
    var master_url = base_url + 'index.php/Piochas/';
    var pnlTablero = $("#pnlTablero");

    $(document).ready(function () {
        
    });
</script>