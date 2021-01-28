<div class="card m-2" id="pnlTablero">
    <div class="card-body" style="padding-top: 10px;    padding-bottom: 10px;">
        <div class="row">
            <div class="col-6">
                <legend class="font-weight-bold" style="margin-bottom: 0px;">AVANCE POR EMPLEADO Y PAGO DE NÓMINA</legend>
            </div>
            <div class="col-6" align="right">
                <a class="btn btn-sm mt-1" style="background-color: #8c0a00; color: #fff" href="<?php print base_url('Sesion/onSalir'); ?>"><i class="fa fa-sign-out-alt"></i> Salir</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <label>Empleado</label>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-2 col-xl-2">
                <input type="text"  style="height: 50px; font-weight: bold; font-size: 45px;"  id="NumeroDeEmpleado" name="NumeroDeEmpleado" class="form-control form-control-sm shadow-lg numeric" maxlength="8" style="height: 50px; font-weight: bold; font-size: 25px;" autofocus="" data-toggle="tooltip" data-placement="bottom" title="Ingrese un empleado del depto de corte">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-9 col-lg-10 col-xl-10 text-center">
                <h1 style="color: #3F51B5 !important" class="nombre_empleado">-</h1>
                <input type="text" id="NombreEmpleado" name="NombreEmpleado" class="form-control form-control-sm d-none" placeholder="-" disabled="" style="height: 50px; font-weight: bold; font-size: 25px; text-align: center;">
            </div>
            <!--FIN BLOQUE 2 COL 6-->
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="center">
                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-8">
                        <h6 class="font-weight-bold">FRACCIONES DE ESTE EMPLEADO</h6>
                    </div>
                    <div class="col-2">
                    </div>
                </div>

                <table id="tblAvance" class="table table-hover table-sm table-bordered  compact nowrap" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Control</th>

                            <th scope="col">Estilo</th>
                            <th scope="col">Fracción</th>
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
                        </tr>
                    </tfoot>
                </table> 
                <div class="col-12">
                    <div class="row" align="center">
                        <div class="col-2">
                            <label>Año</label>
                            <input type="text" id="AnoFiltro" name="AnoFiltro" maxlength="4" class="form-control form-control-sm numbersOnly selectNotEnter noBorders">
                        </div> 
                        <div class="col-2">
                            <label>Semana</label>
                            <input type="text" id="SemanaFiltro" name="SemanaFiltro" maxlength="2" class="form-control form-control-sm  numbersOnly selectNotEnter noBorders">

                        </div> 
                        <div class="col-2">
                            <label>Fraccion</label>
                            <input type="text" id="FraccionFiltro" name="FraccionFiltro" maxlength="4" class="form-control numbersOnly form-control-sm selectNotEnter noBorders">
                        </div>
                        <div class="col-3">
                            <button type="button" id="btnRevisarFraccionesXEstilo" name="btnRevisarFraccionesXEstilo" class="btn btn-sm mt-3" style="background-color: #673AB7; border-color: #673AB7; color: #fff">
                                <span class="fa fa-search"></span> Fracciones X Estilo
                            </button>
                        </div>
                        <div class="col-3">
                            <button type="button" id="btnRevisarPagoFraccion" name="btnRevisarPagoFraccion" class="btn btn-sm mt-3"  style="background-color: #673AB7; border-color: #673AB7; color: #fff">
                                <span class="fa fa-search"></span> Revisar fracciónes</button>
                        </div>
                    </div>
                </div>
            </div><!--FIN BLOQUE 2 COL 6-->
            <!--INICIO BLOQUE 2 COL 6-->
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="row">

                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-4">
                        <?php
                        $F = Date('d/m/Y');
                        $SP = $this->db->select('SP.Sem AS Semana, SP.FechaIni AS FEINI, SP.FechaFin AS FEFI', false)
                                        ->from('semanasnomina AS SP')
                                        ->where("STR_TO_DATE('{$F}', \"%d/%m/%Y\") "
                                                . "BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") "
                                                . "AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\") ")
                                        ->get()->result();
                        ?>
                        <label>Semana</label>
                        <input type="text" id="Semana" name="Semana" readonly="" class="d-none form-control form-control-sm  numeric" maxlength="2">
                        <div class="w-100"></div>
                        <span class="font-weight-bold semana_avance8" style="color: #c1850c !important; font-size: 40px; "></span>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-4">
                        <label>Fecha</label>
                        <input type="text" id="Fecha" name="Fecha" class="d-none form-control form-control-sm  " readonly="">
                        <div class="w-100"></div>
                        <span class="font-weight-bold fecha_avance8" style="color: #c1850c !important; font-size: 40px; "></span>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Departamento</label>
                        <input type="text" id="Departamento" name="Departamento" readonly="" class="form-control d-none form-control-sm numeric " maxlength="3">
                        <div class="w-100"></div>
                        <span class="font-weight-bold depto_avance8" style="color: #c1850c !important; font-size: 40px; "></span>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Control</label>
                        <input type="text" id="Control" name="Control" style="height: 50px; font-weight: bold; font-size: 45px;" class="form-control form-control-sm  numeric" maxlength="10">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Estilo</label>
                        <h1 style="color: #c1850c !important;" class="estilo_control">-</h1>
                        <input type="text" id="Estilo" name="Estilo" readonly=""  class="form-control form-control-sm d-none">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Pares</label>
                        <h1 style="color: #c1850c !important;"  class="pares_control">-</h1>
                        <input type="text" id="Pares" name="Pares" readonly=""  class="form-control form-control-sm  numeric  d-none">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Avance</label>
                        <h1 style="color: #c1850c !important;"  class="avance_control">-</h1>
                        <input type="text" id="Avance" name="Avance" readonly=""  class="form-control form-control-sm  numeric d-none">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 mx-auto d-none">
                        <button type="button" class="btn btn-success mt-3" id="btnAceptar" name="btnAceptar" data-toggle="tooltip" data-placement="top" title="Aceptar"><span class="fa fa-check"></span></button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div id="ManoDeObra" class="col-6">
                        <label class="text-danger">Seleccione Fracción</label>
                        <div  class="row  bg-danger text-white" style="border-radius: 5px; height: 435px; overflow-y: auto;" >
                            <?php
                            $fracciones = $this->db->query("SELECT Clave, Descripcion FROM fracciones AS F WHERE F.Clave IN(51,70,60,62,78,204,205,198,127,80,396,397,34,106,306,308,337,321,333,506,72,75,71,607,606,301,23,24,325,74,130,210) ORDER BY ABS(F.Clave) ASC;")->result();
                            $row = "";
                            foreach ($fracciones as $k => $v) {
                                $row .= "<div class=\"col-12\">
                                <div class=\"custom-control custom-checkbox\">
                                    <input type=\"checkbox\" class=\"custom-control-input\" id=\"chk{$v->Clave}\" description=\"{$v->Descripcion}\" fraccion=\"{$v->Clave}\">
                                    <label class=\"custom-control-label\" for=\"chk{$v->Clave}\">{$v->Clave} {$v->Descripcion}</label>
                                </div>
                            </div>";
                            }
                            print $row;
                            ?>
                        </div>
                    </div>

                    <div class="col-6">
                        <h5 class="text-info">PAGO DE NÓMINA</h5>
                        <div id="DiasPagoDeNomina" class="row">
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">
                                <h5>JUEVES</h5>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtJUEVES" name="txtJUEVES" readonly="" class="form-control form-control-sm d-none" placeholder="0" style="font-weight: bold;">
                                <span class="txtJUEVES"  style="font-size: 25px; color: #673AB7 !important; font-weight: bold;">0</span>
                            </div>
                            <div class="w-100"><hr></div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">
                                <h5>VIERNES</h5>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtVIERNES" name="txtVIERNES" readonly="" class="form-control form-control-sm d-none" placeholder="0" style="font-weight: bold;">
                                <span class="txtVIERNES"  style="font-size: 25px; color: #673AB7 !important; font-weight: bold;">0</span>
                            </div>
                            <div class="w-100"><hr></div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">
                                <h5>SABADO</h5>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtSABADO" name="txtSABADO" readonly="" class="form-control form-control-sm d-none" placeholder="0" style="font-weight: bold;">
                                <span class="txtSABADO"  style="font-size: 25px; color: #673AB7 !important; font-weight: bold;">0</span>
                            </div>
                            <div class="w-100"><hr></div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">
                                <h5>DOMINGO</h5>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtDOMINGO" name="txtDOMINGO" readonly="" class="form-control form-control-sm d-none" placeholder="0" style="font-weight: bold;">
                                <span class="txtDOMINGO"  style="font-size: 25px; color: #673AB7 !important; font-weight: bold;">0</span>
                            </div>
                            <div class="w-100"><hr></div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">
                                <h5>LUNES</h5>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtLUNES" name="txtLUNES" readonly="" class="form-control form-control-sm d-none" placeholder="0" style="font-weight: bold;">
                                <span class="txtLUNES"  style="font-size: 25px; color: #673AB7 !important; font-weight: bold;">0</span>
                            </div>
                            <div class="w-100"><hr></div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">
                                <h5>MARTES</h5>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtMARTES" name="txtMARTES" readonly="" class="form-control form-control-sm d-none" placeholder="0" style="font-weight: bold;">
                                <span class="txtMARTES" style="font-size: 25px; color: #673AB7 !important; font-weight: bold;">0</span>
                            </div>
                            <div class="w-100"><hr></div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">
                                <h5>MIERCOLES</h5>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtMIERCOLES" name="txtMIERCOLES" readonly="" class="form-control form-control-sm d-none" placeholder="0" style="font-weight: bold;" readonly="">
                                <span class="txtMIERCOLES"style="font-size: 25px; color: #673AB7 !important; font-weight: bold;">0</span>
                            </div>
                            <div class="col-12"><hr></div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <h3>TOTAL</h3>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="center">
                                <input type="text" id="txtTotal" disabled="" name="txtTotal" class="form-control form-control-sm d-none" placeholder="0" style="font-weight: bold;">
                                <h3 class="total_cobrado_x_empleado" style="color:#FF0000; font-weight: bold;"></h3>
                            </div>
                        </div>
                        <div class="w-100 my-2"></div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none" align="center">
                            <h2 class="text-danger">ESTATUS ACTUAL DEL AVANCE</h2>
                            <input type="text" id="EstatusAvance" name="EstatusAvance" class="form-control form-control-sm ">
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                            <h4 class="font-weight-bold" style="color : #3F51B5 !important;">ESTATUS ACTUAL DEL AVANCE </h4>  
                            <div class="w-100"></div>
                            <h4 class="font-weight-bold estatus_de_avance" style="color : #ef1000 !important">-</h4>
                        </div>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-2 d-none">
                        <div class="row">
                            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="GeneraAvance" name="GeneraAvance" class="form-control form-control-sm">
                            </div>
                            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="Depto" name="Depto" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                        <label>MO</label>
                        <input type="text" id="ManoDeOB" name="ManoDeOB" class="form-control form-control-sm  numeric" readonly="">
                        <label>AN</label>
                        <input type="text" id="Anio" name="Anio" class="form-control form-control-sm  numeric" readonly="">
                    </div>
                </div>
            </div><!--FIN BLOQUE 2 COL 6-->

            <div class="col-12 text-center">
                <span class="text-danger font-weight-bold font-italic">8 8 8 8 8 8</span>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="mdlFraccionesXEstilo">
    <div class="modal-dialog notdraggable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-puzzle-piece"></span> Fracciones x estilo </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label>Estilo</label>
                        <input type="text" id="xEstiloABuscar" name="xEstiloABuscar" class="form-control form-control-sm" maxlength="8">
                    </div> 
                    <div class="col-6">
                        <label>Fraccion</label>
                        <input type="text" id="xFraccionABuscar" name="xFraccionABuscar" class="form-control form-control-sm" maxlength="8">
                    </div> 
                    <div class="w-100 mb-2"></div>
                    <div class="col-12">
                        <table id="tblFraccionesXEstilo" class="table table-hover table-sm nowrap" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">Estilo</th>
                                    <th scope="col">Fraccion</th>
                                    <th scope="col">Costo</th> 
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <span class="fa fa-times"></span>    Cerrar 
                </button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="mdlFraccionesPagadasXControl">
    <div class="modal-dialog notdraggable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="fa fa-piggy-bank"></span> Fracciones pagadas x control </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label>Control</label>
                        <input type="text" id="xControlBuscado" name="xControlBuscado" class="form-control form-control-sm" maxlength="12">
                    </div> 
                    <div class="col-6">
                        <label>Fraccion</label>
                        <input type="text" id="xFraccionPagada" name="xFraccionPagada" class="form-control form-control-sm" maxlength="8">
                    </div> 
                    <div class="w-100 mb-2"></div>
                    <div class="col-12">
                        <table id="tblFraccionesPagadas" class="table table-hover table-sm nowrap" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">Control</th>
                                    <th scope="col">Pares</th> 
                                    <th scope="col">Fraccion</th>
                                    <th scope="col">Empleado</th> 
                                    <th scope="col">Semana</th> 
                                    <th scope="col">Subtotal</th> 
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <span class="fa fa-times"></span>    Cerrar 
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    var dias = ["JUEVES", "VIERNES", "SABADO", "DOMINGO", "LUNES", "MARTES", "MIERCOLES"],
            ndias = ["LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO", "DOMINGO"],
            pnlTablero = $("#pnlTablero").find("div.card-body"),
            DiasPagoDeNomina = pnlTablero.find("#DiasPagoDeNomina"), Avance,
            tblAvance = pnlTablero.find("#tblAvance"),
            NumeroDeEmpleado = pnlTablero.find("#NumeroDeEmpleado"),
            NombreEmpleado = pnlTablero.find("#NombreEmpleado"),
            GeneraAvance = pnlTablero.find("#GeneraAvance"),
            Depto = pnlTablero.find("#Depto"),
            Semana = pnlTablero.find("#Semana"),
            Fecha = pnlTablero.find("#Fecha"),
            Control = pnlTablero.find("#Control"),
            Departamento = pnlTablero.find("#Departamento"),
            Estilo = pnlTablero.find("#Estilo"),
            Pares = pnlTablero.find("#Pares"),
            SigAvance = pnlTablero.find("#Avance"),
            EstatusAvance = pnlTablero.find("#EstatusAvance"),
            ManoDeOB = pnlTablero.find("#ManoDeOB"),
            estatus_de_avance = pnlTablero.find("H4.estatus_de_avance"),
            Anio = pnlTablero.find("#Anio"), btnAceptar = pnlTablero.find("#btnAceptar"),
            btnRevisarFraccionesXEstilo = pnlTablero.find("#btnRevisarFraccionesXEstilo"),
            mdlFraccionesXEstilo = $("#mdlFraccionesXEstilo"), FraccionesXEstilo,
            tblFraccionesXEstilo = mdlFraccionesXEstilo.find("#tblFraccionesXEstilo"),
            btnRevisarPagoFraccion = pnlTablero.find("#btnRevisarPagoFraccion"),
            mdlFraccionesPagadasXControl = $("#mdlFraccionesPagadasXControl");

    var AVANO = {
        NUMERO_EMPLEADO: 0,
        CONTROL: '',
        ESTILO: '',
        FRACCION: '',
        NUMERO_FRACCION: 0,
        PRECIO_FRACCION: 0,
        PARES: 0,
        FECHA: '',
        SEMANA: 0,
        DEPARTAMENTO: 0,
        ANIO: 0
    };
    // IIFE - Immediately Invoked Function Expression
    $(document).ready(function () {

        btnRevisarPagoFraccion.click(function () {
            mdlFraccionesPagadasXControl.modal('show');
        });

        mdlFraccionesXEstilo.find("#xFraccionABuscar").keydown(function (e) {
            if ($(this).val() && e.keyCode === 13) {
                onOpenOverlay('Cargando...');
                FraccionesXEstilo.ajax.reload(function () {
                    onCloseOverlay();
                });
            } else if ($(this).val() === '' && e.keyCode === 13) {
                onOpenOverlay('Cargando...');
                FraccionesXEstilo.ajax.reload(function () {
                    onCloseOverlay();
                });
            }
        });

        mdlFraccionesXEstilo.find("#xEstiloABuscar").keydown(function (e) {
            if ($(this).val() && e.keyCode === 13) {
                onOpenOverlay('Cargando...');
                FraccionesXEstilo.ajax.reload(function () {
                    onCloseOverlay();
                });
            } else if ($(this).val() === '' && e.keyCode === 13) {
                onOpenOverlay('Cargando...');
                FraccionesXEstilo.ajax.reload(function () {
                    onCloseOverlay();
                });
            }
        });

        mdlFraccionesXEstilo.on('shown.bs.modal', function () {
            onClearInputs(mdlFraccionesXEstilo);
            mdlFraccionesXEstilo.find("#xEstiloABuscar").focus();

            $.fn.dataTable.ext.errMode = 'throw';
            if ($.fn.DataTable.isDataTable('#tblFraccionesXEstilo')) {
                onOpenOverlay('Cargando...');
                FraccionesXEstilo.ajax.reload(function () {
                    onCloseOverlay();
                });
                return;
            }
            onOpenOverlay('Cargando...');
            FraccionesXEstilo = tblFraccionesXEstilo.DataTable({
                "dom": 'rt',
                buttons: buttons,
                orderCellsTop: true,
                fixedHeader: true,
                "ajax": {
                    "url": '<?php print base_url('Avance8/getFraccionesXEstilo'); ?>',
                    "dataSrc": "",
                    "data": function (d) {
                        d.ESTILO = mdlFraccionesXEstilo.find("#xEstiloABuscar").val() ?
                                mdlFraccionesXEstilo.find("#xEstiloABuscar").val() : '';
                        d.FRACCION = mdlFraccionesXEstilo.find("#xFraccionABuscar").val() ?
                                mdlFraccionesXEstilo.find("#xFraccionABuscar").val() : '';
                    }
                },
                "columns": [
                    {"data": "ESTILO"},
                    {"data": "FRACCION"},
                    {"data": "COSTO"}
                ],
                language: lang,
                "autoWidth": true,
                "colReorder": true,
                "displayLength": 400,
                "scrollX": true,
                "scrollY": 300,
                "bLengthChange": false,
                "deferRender": true,
                "scrollCollapse": false,
                "bSort": true,
                "aaSorting": [
                    [0, 'asc'], [1, 'asc']
                ],
                initComplete: function () {
                    onCloseOverlay();
                }
            });
        });

        btnRevisarFraccionesXEstilo.click(function () {
            mdlFraccionesXEstilo.modal('show');
        });

        var fff = "";
        $.each(pnlTablero.find("input[type='checkbox']"), function (k, v) {
            fff += $(v).attr('fraccion') + ",";
        });
        console.log(fff);
        Semana.val('<?php print $SP[0]->Semana; ?>');
        pnlTablero.find("span.semana_avance8").text('<?php print $SP[0]->Semana; ?>');
        Fecha.val('<?php print $F; ?>');
        pnlTablero.find("span.fecha_avance8").text('<?php print $F ?>');
        handleEnter();

        btnAceptar.click(function () {
            onAgregarAvance();
        });

        Anio.val(new Date().getFullYear());

        Control.on('keydown', function (e) {
            if (e.keyCode === 13 && Control.val()) {
                pnlTablero.find("#SemanaFiltro").val('');
                pnlTablero.find("#FraccionFiltro").val('');
                getInfoXControl(onAgregarAvance);
            }
        });

        pnlTablero.find("input[type='checkbox']").change(function () {
            var mo = pnlTablero.find("#ManoDeObra");
            if (NumeroDeEmpleado.val()) {
                onCheckFraccion(this);
                if ($(this)[0].checked) {
                    onBeep(3);
                    Control.focus().select();
                    mo.find("input[type='checkbox']:not(:checked)").parent().find("label.custom-control-label").removeClass("highlight");
                    mo.find("input[type='checkbox']:checked").parent().find("label.custom-control-label").addClass("highlight");
                } else {
                    onBeep(1);
                    if (pnlTablero.find("input[type='checkbox']:checked").length <= 0) {
                        mo.find("label.custom-control-label").addClass("highlight");
                    } else {
                        mo.find("label.custom-control-label").removeClass("highlight");
                    }
                }
            } else {
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR UN NUMERO DE EMPLEADO', 'warning').then((value) => {
                    NumeroDeEmpleado.focus().select();
                    $.each(mo.find("input[type='checkbox']"), function (k, v) {
                        $(v)[0].checked = false;
                    });
                });
            }
            Control.focus().select();
        });

        NumeroDeEmpleado.on('keydown', function (e) {
            if (e.keyCode === 13) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Revisando si el empleado cumple con los requisitos...'
                });
                Avance.ajax.reload();
                $.post('<?php print base_url('Avance8/onComprobarDeptoXEmpleado') ?>', {EMPLEADO: NumeroDeEmpleado.val()})
                        .done(function (data) {
                            var dt = JSON.parse(data);
                            if (dt.NOEXISTE !== undefined) {
                                onCampoInvalido(pnlTablero, 'ESTE EMPLEADO NO ES APTO PARA DAR AVANCES O ESTA DADO DE BAJA', function () {
                                    NumeroDeEmpleado.focus().select();
                                });
                                return;
                            }
                            if (dt.length > 0) {
                                var r = dt[0];
                                GeneraAvance.val(r.GENERA_AVANCE);
                                Depto.val(r.DEPTO);
                                NombreEmpleado.val(r.NOMBRE_COMPLETO);
                                pnlTablero.find(".nombre_empleado").text(dt[0].NOMBRE_COMPLETO);
                                Departamento.val(r.DEPTOCTO);
                                pnlTablero.find(".depto_avance8").text(r.DEPTOCTO);
                                $.getJSON('<?php print base_url('Avance8/getSemanaByFecha'); ?>').done(function (data) {
                                    var rr = data[0];
                                    Semana.val((data.length > 0) ? rr.Sem : '');
                                    Fecha.val((data.length > 0) ? rr.Fecha : '');
                                    getPagosXEmpleadoXSemana();
                                }).fail(function (x, y, z) {
                                    console.log(x.responseText);
                                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
                                }).always(function () {

                                });
                                //                                swal('ATENCIÓN', 'SELECCIONE UNA FRACCIÓN', 'success').then((value) => {
                                pnlTablero.find("#ManoDeObra label.custom-control-label").addClass("highlight");
                                //                                });
                            } else {
                                NombreEmpleado.val('');
                                pnlTablero.find(".nombre_empleado").text('');
                                onBeep(2);
                                swal('ATENCIÓN', 'ESTE EMPLEADO NO ES APTO PARA DAR AVANCES O ESTA DADO DE BAJA', 'warning').then((value) => {
                                    NumeroDeEmpleado.focus().select();
                                });
                            }
                        }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
                }).always(function () {
                    HoldOn.close();
                    getPagosXEmpleadoXSemana();
                });
            }
        });


        /*AVOID C&P*/
//        var _0x6b99 = ["\x63\x75\x74\x20\x63\x6F\x70\x79\x20\x70\x61\x73\x74\x65",
//            "\x70\x72\x65\x76\x65\x6E\x74\x44\x65\x66\x61\x75\x6C\x74",
//            "\x6F\x6E",
//            "\x62\x6F\x64\x79"];
//        $(_0x6b99[3])[_0x6b99[2]]
//                (_0x6b99[0], function (_0xd777x1) {
//                    _0xd777x1[_0x6b99[1]]();
//                });


        var cols = [
            {"data": "ID"}/*0*/, {"data": "FECHA"}/*1*/,
            {"data": "CONTROL"}/*2*/, {"data": "ESTILO"},
            {"data": "FRAC"}, {"data": "PARES"},
            {"data": "PRECIO"}, {"data": "SUBTOTAL_SPAN"}
        ];
        var coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ];
        var xoptions = {
            "dom": 'rt',
            buttons: buttons,
            "columns": cols,
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 99999999,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "490px",
            "scrollX": true,
            initComplete: function () {
                pnlTablero.find("#AnoFiltro").val(<?php print Date('Y'); ?>);
            },
            "drawCallback": function (settings) {
                var api = this.api();
                var r = 0, prs = 0;
                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };
                $.each(api.rows().data(), function (k, v) {
                    r += parseFloat(intVal(v.SUBTOTAL));
                    prs += parseInt(v.PARES);
                });
                $(api.column(5).footer()).html(
                        '<span class="font-weight-bold">' + prs + ' pares</span>');
                $(api.column(7).footer()).html(
                        '<span class="font-weight-bold">$' +
                        $.number(r, 2, '.', ',') + '</span>');
                $(api.column(4)).find("span").css("color", "yellow");
                console.log(api.column(4));
//$("table tbody  tr:eq(3) td:eq(3)").find("span").css( "color", "black" ); 
            }
        };
        xoptions.ajax = {
            "url": '<?php print base_url('Avance8/getFraccionesPagoNomina'); ?>',
            "dataSrc": "",
            "data": function (d) {
                d.EMPLEADO = NumeroDeEmpleado.val() ? NumeroDeEmpleado.val() : '';
                d.ANO_FILTRO = pnlTablero.find("#AnoFiltro").val() ? pnlTablero.find("#AnoFiltro").val() : '';
                d.SEMANA_FILTRO = pnlTablero.find("#SemanaFiltro").val() ? pnlTablero.find("#SemanaFiltro").val() : (Semana.val() ? Semana.val() : '');
                d.FRACCION_FILTRO = pnlTablero.find("#FraccionFiltro").val() ? pnlTablero.find("#FraccionFiltro").val() : '';
                d.FRACCIONES = "51,70,60,62,24,78,204,205,198,127,80,397,34,106,306,337,333,506,72,607,606";
            },
            "aaSorting": [
                [2, 'desc']
            ]

//$("table tbody  tr:eq(3) td:eq(3)").find("span").css( "color", "black" ); 
        };
        $.fn.dataTable.ext.errMode = 'throw';
        Avance = tblAvance.DataTable(xoptions);

        pnlTablero.find("#AnoFiltro").on('keydown', function (e) {
            if (e.keyCode === 13) {
                onOpenOverlay('Buscando...');
                Avance.ajax.reload(function () {
                    pnlTablero.find("#AnoFiltro").focus().select();
                    onCloseOverlay();
                });
            }
        });

        pnlTablero.find("#SemanaFiltro").on('keydown', function (e) {
            if (e.keyCode === 13) {
                onOpenOverlay('Buscando...');
                Avance.ajax.reload(function () {
                    pnlTablero.find("#SemanaFiltro").focus().select();
                    onCloseOverlay();
                });
            }
        });

        pnlTablero.find("#FraccionFiltro").on('keydown', function (e) {
            if (e.keyCode === 13) {
                Avance.ajax.reload(function () {
                    pnlTablero.find("#FraccionFiltro").focus().select();
                    onCloseOverlay();
                });
            }
        });
    });

    function onAgregarAvance() {
        var cks = pnlTablero.find("input[type='checkbox']:checked");
        var fra = cks.attr('fraccion');
        console.log("FRACCION * ", fra);




        var fracciones = [];
        $.each(pnlTablero.find("input[type='checkbox']"), function (k, v) {
            if ($(this)[0].checked) {
                fracciones.push({
                    NUMERO_FRACCION: $(v).attr('fraccion'),
                    DESCRIPCION: $(v).attr('description')
                });
            }
        });
//        console.log(fracciones, JSON.stringify(fracciones));


        if (cks.length > 0) {
            if (Control.val()) {
                $.getJSON('<?php print base_url('Avance8/onComprobarFraccionXEstilo'); ?>',
                        {CONTROL: Control.val(), FRACCIONES: JSON.stringify(fracciones)}).done(function (a) {
//                    console.log(a, a.FRACCIONES_VALIDAS, fracciones.length);
//                    if (parseInt(a.FRACCIONES_VALIDAS) < fracciones.length) {
//                        iMsg(a.FALTAN + ' DE LAS FRACCIONES SELECCIONADAS NO CORRESPONDEN A ESTE ESTILO', 'w', function () {
//                            Control.focus().select();
//                        });
                    //                    } else {
                    Estilo.val(a.ESTILO);
                    Pares.val(a.PARES);
                    pnlTablero.find(".estilo_control").text(a.ESTILO);
                    pnlTablero.find(".pares_control").text(a.PARES);
                    $.getJSON('<?php print base_url('Avance9/getUltimoAvanceXControl'); ?>',
                            {C: Control.val()}).done(function (data) {
                        var x = data[0];
                        if (data.length > 0) {
                            SigAvance.val(x.Departamento);
                            EstatusAvance.val(x.DepartamentoT);
                            estatus_de_avance.text(x.DepartamentoT);
                            pnlTablero.find(".avance_control").text(x.Departamento);
                            onAvanzar();
                        }
                    });

//                    }
//                    if (a.length > 0) {
//                        var r = a[0];
//                        Estilo.val(r.Estilo);
//                        Pares.val(r.Pares);
//                        ManoDeOB.val(r.CostoMO);
//                        $.getJSON('<?php print base_url('Avance8/getUltimoAvanceXControl'); ?>', {C: Control.val()}).done(function (b) {
//                            if (b.length > 0) {
//                                SigAvance.val(b[0].Departamento);
//                                EstatusAvance.val(b[0].DepartamentoT);
//                                var d = new Date();
//                                var n = d.getDay();
//                                DiasPagoDeNomina.find("#txt" + ndias[n - 1]).val(parseFloat(r.Pares) * parseFloat(r.CostoMO));
//                                var tt = 0;
//                                ndias.forEach(function (i) {
//                                    tt += parseFloat(pnlTablero.find("#txt" + i).val());
//                                });
//                                DiasPagoDeNomina.find("#txtTotal").val(parseFloat(r.Pares) * parseFloat(r.CostoMO));
//                                onAvanzar();
//                            }
//                        }).fail(function (x, y, z) {
//                            console.log(x.responseText);
//                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
//                        }).always(function () {
//                            HoldOn.close();
//                        });
//                    } else {
//                        swal('ATENCIÓN', 'LA FRACCIÓN O EL CONTROL NO SON CORRECTAS, ELIJA OTRA FRACCIÓN O ESPECIFIQUE UN CONTROL CON LA FRACCIÓN SELECCIONADA', 'error').then((value) => {
//                            Control.focus().select();
//                            Estilo.val('');
//                            Pares.val('');
//                            SigAvance.val('');
                    //                        });
                    //                    }
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CONTROL', 'error').then((value) => {
                    Control.focus().select();
                });
            }
        } else {
            swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UNA FRACCIÓN', 'error').then((value) => {
                Control.focus().select();
                getPagosXEmpleadoXSemana();
            });
        }
    }

    var fracciones = [51, 70, 60, 62, 24, 78, 204, 205, 198, 127, 80, 397, 34, 106, 306, 337, 333, 506, 72, 607, 606];

    function onCheckFraccion(e) {
//        $.each(pnlTablero.find("input[type='checkbox']"), function (k, v) {
//            if ($(e)[0].id !== $(v)[0].id) {
//                $(v)[0].checked = false;
        //            }
        //        });
    }

    function onClearMO() {
        Control.focus().select();
        Estilo.val('');
        Pares.val('');
        SigAvance.val('');
//        $.each(pnlTablero.find("input[type='checkbox']"), function (k, v) {
//            $(v)[0].checked = false;
        //        });
    }

    function onAvanzar() {

        AVANO.NUMERO_EMPLEADO = NumeroDeEmpleado.val();
        AVANO.CONTROL = Control.val();
        AVANO.ESTILO = Estilo.val();
        AVANO.NUMERO_FRACCION = pnlTablero.find("#ManoDeObra input[type='checkbox']:checked").attr('fraccion');
        AVANO.FRACCION = pnlTablero.find("#ManoDeObra input[type='checkbox']:checked").attr('description');
        AVANO.PRECIO_FRACCION = ManoDeOB.val();
        AVANO.PARES = Pares.val();
        AVANO.FECHA = Fecha.val();
        AVANO.SEMANA = Semana.val();
        AVANO.DEPARTAMENTO = Departamento.val();
        AVANO.ANIO = pnlTablero.find("#Anio").val();

        var fracciones = [], xfracciones = [];
        $.each(pnlTablero.find("input[type='checkbox']"), function (k, v) {
            if ($(v)[0].checked) {
                xfracciones.push({
                    NUMERO_FRACCION: parseInt($(v).attr('fraccion')),
                    DESCRIPCION: $(v).attr('description')
                });
            }
        });

        if (pnlTablero.find("#chk606")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 606,
                DESCRIPCION: "ARMAR PLANTA D MUESTRA"
            });
        }
        if (pnlTablero.find("#chk34")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 34,
                DESCRIPCION: "PEGAR TRANSFER"
            });
        }
        if (pnlTablero.find("#chk607")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 607,
                DESCRIPCION: "ARMAR PLANTILLA ADORNO"
            });
        }
        if (pnlTablero.find("#chk72")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 72,
                DESCRIPCION: "TROQUELAR NORMA"
            });
        }
        if (pnlTablero.find("#chk506")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 506,
                DESCRIPCION: "PEGADO CIUCCANI"
            });
        }
        if (pnlTablero.find("#chk333")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 333,
                DESCRIPCION: "PONER CASCO A PESPUNTE"
            });
        }
        if (pnlTablero.find("#chk321")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 321,
                DESCRIPCION: "FORRAR PLATADORMA MUESTRA"
            });
        }
        if (pnlTablero.find("#chk337")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 337,
                DESCRIPCION: "RECORTAR FORRO LASER"
            });
        }

        if (pnlTablero.find("#chk306")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 306,
                DESCRIPCION: "FORRAR PLATAFORMA"
            });
        }
        if (pnlTablero.find("#chk106")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 106,
                DESCRIPCION: "DOBLILLADO"
            });
        }
        if (pnlTablero.find("#chk80")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 80,
                DESCRIPCION: "CONTAR TAREA"
            });
        }
        if (pnlTablero.find("#chk127")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 127,
                DESCRIPCION: "ENTRETELAR MUESTRA"
            });
        }
        if (pnlTablero.find("#chk198")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 198,
                DESCRIPCION: "LOTEAR PARA LASER"
            });
        }
        if (pnlTablero.find("#chk205")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 205,
                DESCRIPCION: "APLICA PEGA PARA LASER"
            });
        }
        if (pnlTablero.find("#chk204")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 204,
                DESCRIPCION: "EMPALMAR PARA LASER"
            });
        }
        if (pnlTablero.find("#chk78")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 78,
                DESCRIPCION: "LIMPIA LASER"
            });
        }
        if (pnlTablero.find("#chk24")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 24,
                DESCRIPCION: "DOMAR"
            });
        }
        if (pnlTablero.find("#chk23")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 23,
                DESCRIPCION: "DOMAR CHINELA MUESTRA"
            });
        }
        if (pnlTablero.find("#chk62")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 62,
                DESCRIPCION: "SERIGRAFIA FORRO"
            });
        }
        if (pnlTablero.find("#chk60")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 60,
                DESCRIPCION: "FOLEAR CORTE Y CALIDAD"
            });
        }
        if (pnlTablero.find("#chk71")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 71,
                DESCRIPCION: "TROQUELAR MUESTRA"
            });
        }
        if (pnlTablero.find("#chk70")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 70,
                DESCRIPCION: "TROQUELAR PLANTILLA"
            });
        }
        if (pnlTablero.find("#chk75")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 75,
                DESCRIPCION: "TROQUELAR CORTE"
            });
        }
        if (pnlTablero.find("#chk301")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 301,
                DESCRIPCION: "PESPUNTAR PLANTILLA"
            });
        }
        if (pnlTablero.find("#chk308")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 308,
                DESCRIPCION: "TEJER APLICACION"
            });
        }
        if (pnlTablero.find("#chk24")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 24,
                DESCRIPCION: "DOMAR CHINELA"
            });
        }
        if (pnlTablero.find("#chk325")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 325,
                DESCRIPCION: "EMPALMAR MALLA A CHINELA"
            });
        }
        if (pnlTablero.find("#chk74")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 74,
                DESCRIPCION: "COTEJAR PIEL Y FORRO"
            });
        }
        if (pnlTablero.find("#chk130")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 130,
                DESCRIPCION: "RAYAR PLANTILLA"
            });
        }
        if (pnlTablero.find("#chk210")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 210,
                DESCRIPCION: "PINTAR FILOS"
            });
        }




        /*AVANZA EL CONTROL A ENTRETELADO A ALMACEN DE CORTE*/
        if (pnlTablero.find("#chk51")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 51,
                DESCRIPCION: "ENTRETELADO"
            });
        }
        /*AVANZA EL CONTROL A ENSUELADO*/
        if (pnlTablero.find("#chk397")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 397,
                DESCRIPCION: "JUNTAR SUELA A CORTE"
            });
        }
        if (pnlTablero.find("#chk396")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 396,
                DESCRIPCION: "JUNTAR SUELA A CORTE (MUESTRA)"
            });
        }
        AVANO.FRACCIONES = JSON.stringify(fracciones);


        var depa_empleado = parseInt(Departamento.val());
        var registro_valido = true;
        if (depa_empleado === 80 && pnlTablero.find("#chk60")[0].checked) {
            $.getJSON('<?php print base_url('Avance8/onRevisarCobroDeRayadoParaFOLEADO') ?>', {
                CONTROL: Control.val()
            }).done(function (a) {
                var r = a[0];
                switch (r.PUEDE_AVANZAR_A_FOLEADO_VALIDA) {
                    case 0:
                        registro_valido = false;
                        onCampoInvalido(pnlTablero, "CONTROL FUERA DE AVANCE, RAYADO NO HA CAPTURADO", function () {
                            Control.focus().select();
                            Avance.ajax.reload();
                        });
                        return;
                        break;
                    case 1:
                        registro_valido = true;
                        onPagarFraccion(AVANO);
                        break;
                }
            }).fail(function (x) {
                getError(x);
            });
        } else {
            if (depa_empleado === 90 && pnlTablero.find("#chk51")[0].checked) {
                $.getJSON('<?php print base_url('Avance8/onRevisarCobroDeEntreteladoParaALMCORTEOMAQUILA') ?>', {
                    CONTROL: Control.val()
                }).done(function (a) {
                    var r = a[0];
                    switch (r.PUEDE_AVANZAR_A_ALMCORTEOMAQUILA_VALIDA) {
                        case 0:
                            registro_valido = false;
                            onCampoInvalido(pnlTablero, "CONTROL FUERA DE AVANCE, REBAJADO NO HA CAPTURADO", function () {
                                Control.focus().select();
                                Avance.ajax.reload();
                            });
                            return;
                            break;
                        case 1:
                            registro_valido = true;
                            onPagarFraccion(AVANO);
                            break;
                    }
                }).fail(function (x) {
                    getError(x);
                });
            } else {
                if (depa_empleado === 120 && pnlTablero.find("#chk397")[0].checked || depa_empleado === 120 && pnlTablero.find("#chk396")[0].checked) {
                    $.getJSON('<?php print base_url('Avance8/onRevisarCobroDeEnsueladoParaALMPESPUNTE') ?>', {
                        CONTROL: Control.val()
                    }).done(function (a) {
                        var r = a[0];
                        switch (r.PUEDE_AVANZAR_A_ALMPESPUNTE_VALIDA) {
                            case 0:
                                registro_valido = false;
                                onCampoInvalido(pnlTablero, "CONTROL FUERA DE AVANCE, PESPUNTE NO HA CAPTURADO.", function () {
                                    Control.focus().select();
                                    Avance.ajax.reload();
                                });
                                return;
                                break;
                            case 1:
                                registro_valido = true;
                                onPagarFraccion(AVANO);
                                break;
                        }
                    }).fail(function (x) {
                        getError(x);
                    });
                } else {
                    onPagarFraccion(AVANO);
                }
            }
        }
    }

    function  onPagarFraccion(AVANO) {
        $.post('<?php print base_url('Avance8/onAgregarAvanceXEmpleadoYPagoDeNomina') ?>', AVANO).done(function (c) {
            getPagosXEmpleadoXSemana();
            var dt = JSON.parse(c);
            if (c !== undefined && c.length > 0) {
                if (dt.AVANZO > 0) {
                    onNotifyOld('<span class="fa fa-check"></span>', 'SE HA HECHO EL PAGO DE LA(S) FRACCION(ES)', 'success');
                    onClearMO();
                    $.getJSON('<?php print base_url('Avance8/getInfoXControl'); ?>', {
                        CONTROL: Control.val()
                    }).done(function (a) {
                        var r = a[0];
                        estatus_de_avance.text(r.ESTATUS_PRODUCCION);
                        Avance.ajax.reload(function () {
                            Control.val('');
                            Control.focus().select();
                            getPagosXEmpleadoXSemana();
                        });
                        onBeep(5);
                    });
                } else {
                    onBeep(2);
                    swal('ATENCIÓN', 'ESTE CONTROL (' + Control.val() + ') YA TIENE UN AVANCE EN ESTA FRACCIÓN, POR FAVOR ESPECIFIQUE UN CONTROL DIFERENTE O UNA FRACCIÓN DIFERENTE, DE LO CONTRARIO REVISE CON EL AREA CORRESPONDIENTE', 'warning').then((value) => {
                        onClearMO();
                        Avance.ajax.reload(function () {
                            Control.val('');
                            Control.focus().select();
                            getPagosXEmpleadoXSemana();
                        });
                    });
                }
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            Avance.ajax.reload();
        }).always(function () {
            Avance.ajax.reload();
            getPagosXEmpleadoXSemana();
        });
    }

    function getInfoXControl(f) {
        $.getJSON('<?php print base_url('Avance8/getInfoXControl'); ?>', {
            CONTROL: Control.val()
        }).done(function (a) {
            console.log(a, a.length);
            var r = a[0];
            Estilo.val(r.ESTILO);
            Pares.val(r.PARES);
            SigAvance.val(r.DEPTOAVANCE);
            pnlTablero.find(".estilo_control").text(r.ESTILO);
            pnlTablero.find(".pares_control").text(r.PARES);
            pnlTablero.find(".avance_control").text(r.DEPTOAVANCE);
            estatus_de_avance.text(r.ESTATUS_PRODUCCION);
            f();
        });
    }
    function getTotalPagado() {
        ndias.forEach(function (e) {
            console.log(e);
        });
    }
    function getPagosXEmpleadoXSemana() {
        $.getJSON('<?php print base_url('Avance8/getPagosXEmpleadoXSemana'); ?>',
                {EMPLEADO: NumeroDeEmpleado.val(),
                    SEMANA: Semana.val() ? Semana.val() : (pnlTablero.find("#SemanaFiltro").val() ? pnlTablero.find("#SemanaFiltro").val() : ''),
                    FRACCIONES: "51,70,60,62,24,78,204,205,198,127,80,397,34,106,306,337,333,506,72,607,606"}).done(function (a) {
            if (a.length > 0) {
                var b = a[0];
                var tt = 0;
                ndias.forEach(function (i) {
                    pnlTablero.find("#txt" + i).val(b[i]);
                    pnlTablero.find("span.txt" + i).text(b[i]);
                    tt += $.isNumeric(b[i]) ? parseFloat(b[i]) : 0;
                });
                pnlTablero.find("#txtTotal").val(tt);
                pnlTablero.find("h3.total_cobrado_x_empleado").text(tt);
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            onBeep(3);
            swal('ERROR', ' ERROR AL OBTENER LO PAGADO AL EMPLEADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
        }).always(function () {
        });
    }
</script>
<style>
    .btn-success {
        color: #fff;
        background-color: #2196F3;
        border-color: #03A9F4;
    }

    .btn-success:hover {
        color: #fff;
        background-color: #1976D2;
        border-color: #0288D1;
    }

    .custom-checkbox:hover, .custom-checkbox label:hover{
        cursor: pointer;
    }

    .custom-control-label{
        margin-top: 2px;
        border-radius: 4px;
        padding-left: 10px;
        padding-right: 10px;
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently
                              supported by Chrome and Opera */
        -webkit-transition: background-color 0.5s ease-out;
        -moz-transition: background-color 0.5s ease-out;
        -o-transition: background-color 0.5s ease-out;
        transition: background-color 0.5s ease-out;
    }

    .card-body .custom-control-label::after {
        background-color: #3F51B5;
    }

    .highlight{
        border-radius: 4px;
        padding-left: 10px;
        padding-right: 10px;
        background:#99cc00;
        background:#4CAF50;
        font-weight: bold;
        color:#fff;
        -webkit-transition: background-color .1s ease-out;
        -moz-transition: background-color .1s ease-out;
        -o-transition: background-color .1s ease-out;
        transition: background-color .1s ease-out;
    }

    .custom-control-label:hover{
        border-radius: 4px;
        padding-left: 10px;
        padding-right: 10px;
        background:#03a9f4;
        font-weight: bold;
        color:#fff;
        -webkit-transition: background-color .1s ease-out;
        -moz-transition: background-color .1s ease-out;
        -o-transition: background-color .1s ease-out;
        transition: background-color .1s ease-out;
    }
    input[type='text']{
        color: #c1850c !important;
        font-weight: bold !important;
    }
</style>
<style> 
    .card-header{
        background-color: transparent;
        border-bottom: 0px;
    }
    table tbody tr {
        font-size: 0.75rem !important;
    }

    div.datatable-wide {
        padding-left: 0;
        padding-right: 0;
    }
    label {
        margin-top: 0.0rem;
        margin-bottom: 0.0rem;
    }

    .alert-success{
        background: rgba(148,180,71,1);
        background: -moz-linear-gradient(top, rgba(148,180,71,1) 0%, rgba(93,110,30,1) 100%);
        background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(148,180,71,1)), color-stop(100%, rgba(93,110,30,1)));
        background: -webkit-linear-gradient(top, rgba(148,180,71,1) 0%, rgba(93,110,30,1) 100%);
        background: -o-linear-gradient(top, rgba(148,180,71,1) 0%, rgba(93,110,30,1) 100%);
        background: -ms-linear-gradient(top, rgba(148,180,71,1) 0%, rgba(93,110,30,1) 100%);
        background: linear-gradient(to bottom, rgba(148,180,71,1) 0%, rgba(93,110,30,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#94b447', endColorstr='#5d6e1e', GradientType=0 );
    }
    .text-success{
        color: #9aa531 !important;
    }
    .text-info{
        color: #2196F3 !important;
    }
    .text-black{
        color: #000 !important;
        color: #388E3C  !important;
        font-weight: bold !important;
    }

    tr:hover span.text-success,tr:hover span.text-info,tr:hover span.text-black, tr:hover span{
        color: #fff !important;
        font-weight: bold !important;
    }

    table tbody tr:hover { 
        color: #fff !important;
    }

    table tbody tr:hover td{
        background-color: #000 !important; 
        font-weight: bold !important;
    }

    table thead th{
        text-transform: uppercase;
        background-color: #000000 !important;
        color : #ffffff;
    }

    table tbody td, button{
        font-weight: bold !important;
        font-size: 18px;
    }
    table tbody td:nth-child(2){
        color: #3F51B5;
    }
    table tbody td:nth-child(7){ 
        color: #81BC44;
        -webkit-text-stroke-width: 1px;
        -webkit-text-stroke-color: #437C2D;
    }
    table tbody  tr:hover td:nth-child(2), table tbody tr:hover td:nth-child(4),
    table tbody tr:hover td:nth-child(7),
    table tbody tr:hover td:nth-child(4) > span{
        color: #fff !important
    } 
    div.custom-checkbox label,label, button{
        text-transform: uppercase;
    }

    .form-control:disabled, .form-control[readonly] {
        background-color: #ffffff;
        opacity: 1;
        font-size: 20px;
        color: #673AB7 !important;
    }    
    body{
        /* The image used */
        background-image: url("<?php print base_url('media/x5.jpg'); ?>");

        /* Full height */
        height: 100%;

        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>