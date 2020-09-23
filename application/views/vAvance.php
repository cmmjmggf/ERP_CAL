<div class="card mx-2 " id="pnlTablero">
    <div class="card-body" style="padding-top: 5px;">
        <div class="row" >
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <h3 class="font-weight-bold "><span class="fa fa-arrow-up"></span> AVANCE</h3>
            </div> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8" align="right">
                <?php
                if ($this->session->TipoAcceso === "SUPER ADMINISTRADOR" ||
                        $this->session->Nombre === "MARTIN" && $this->session->TipoAcceso === "PRODUCCION") {
                    ?>
                    <button type="button" id="btnAdornoFraccionesNomina" name="btnAdornoFraccionesNomina" class="btn btn-sm btn-info" style="background-color: #85520b; border-color: #85520b;" data-toggle="tooltip" data-placement="bottom" title="Busca y selecciona un concepto">
                        <span class="fa fa-tag"></span>
                        Adorno
                    </button>    
                <?php } ?>
                <?php
                if ($this->session->TipoAcceso === "SUPER ADMINISTRADOR" ||
                        $this->session->Nombre === "GUSTAVO" && $this->session->TipoAcceso === "PRODUCCION") {
                    ?>
                    <button type="button" id="btnPespunteFraccionesFail" name="btnPespunteFraccionesFail" class="btn btn-sm btn-info" style="background-color: #940d0d; border-color: #940d0d" data-toggle="tooltip" data-placement="bottom" title="Busca y selecciona un concepto">
                        <span class="fa fa-tag"></span>
                        Pespunte
                    </button>    
                <?php } ?>
                <button type="button" id="btnRastreoXConcepto" name="btnRastreoXConcepto" class="btn  btn-sm btn-info"  data-toggle="tooltip" data-placement="bottom" title="Busca y selecciona un concepto">
                    <span class="fa fa-bullseye"></span>
                    Rastreo X Concepto
                </button>
                <button type="button" id="btnRastreoXControl" name="btnRastreoXControl" class="btn  btn-sm btn-info"   data-toggle="tooltip" data-placement="bottom" title="Busca y selecciona un control">
                    <span class="fa fa-globe"></span>
                    Rastreo X Control
                </button>
                <button type="button" id="btnDesarrolloDeMuestras" name="btnDesarrolloDeMuestras" class="btn  btn-sm btn-info" >
                    <span class="fa fa-paint-brush"></span>
                    Desarrollo de muestras
                </button>
                <button type="button" id="btnImprimePagosCelulas" name="btnImprimePagosCelulas"
                        class="btn  btn-sm btn-info"  data-toggle="tooltip" data-placement="bottom" 
                        title="Imprime por semana o por semana empleado" style="background-color: #43A047; border-color: #43A047;">
                    <span class="fa fa-print"></span>
                    Imprime pago celulas
                </button>
            </div> 
        </div> 
        <div class="row">
            <!--SECCION UNO-->
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                    <h3 style="color: #c1850c !important;" class="usuario_logued font-weight-bold">
                        <?php print $_SESSION['USERNAME']; ?>
                    </h3>
                    <input type="text" id="usuario" name="usuario" class="form-control form-control-sm d-none">
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                    <label>Fecha</label>
                    <input type="text" id="Fecha" name="Fecha" class="form-control form-control-sm date" readonly="">
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label>Departamento</label>
                    <input type="text" id="Departamento" name="Departamento" class="form-control form-control-sm numbersOnly" autofocus="">
                </div> 
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                    <label>Semana</label>
                    <input type="text" id="Semana" name="Semana" readonly="" class="form-control form-control-sm numbersOnly" maxlength="2">
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3"></div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <ul id="deptos" class="list-group my-2">
                        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                            <span class="d-none stsavan" des="REBAJADO">33</span><span class="d-none" des="REBAJADO">30</span>33 - REBAJADO<span class="deptodes d-none">REBAJADO Y PERFORADO</span><span class="deptoclave d-none">30</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                            <span class="d-none stsavan" des="FOLEADO">4</span><span class="d-none" des="FOLEADO">40</span>4 - FOLEADO<span class="deptodes d-none">FOLEADO</span><span class="deptoclave d-none">40</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                            <span class="d-none stsavan" des="ENTRETELADO">40</span><span class="d-none" des="ENTRETELADO">90</span>40 - ENTRETELADO<span class="deptodes d-none">ENTRETELADO</span><span class="deptoclave d-none">90</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                            <span class="d-none stsavan" des="MAQUILA">42</span><span class="d-none" des="MAQUILA">100</span>42 - MAQUILA<span class="deptodes d-none">MAQUILA</span><span class="deptoclave d-none">100</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                            <span class="d-none stsavan" des="ALMACEN CORTE">44</span> <span class="d-none" des="ALMACEN CORTE">105</span>44 - ALMACEN CORTE<span class="deptodes d-none">ALMACEN CORTE</span><span class="deptoclave d-none">105</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                            <span class="d-none stsavan" des="PESPUNTE">5</span> <span class="d-none" des="PESPUNTE">110</span>5 - PESPUNTE<span class="deptodes d-none">PESPUNTE</span><span class="deptoclave d-none">110</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>

                        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                            <span class="d-none stsavan" des="ENSUELADO">55</span> <span class="d-none" des="ENSUELADO">140</span>55 - ENSUELADO<span class="deptodes d-none">ENSUELADO</span><span class="deptoclave d-none">140</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>

                        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                            <span class="d-none stsavan" des="ALMACEN PESPUNTE">6</span> <span class="d-none" des="ALMACEN PESPUNTE">130</span>6 - ALMACEN PESPUNTE<span class="deptodes d-none">ALMACEN PESPUNTE</span><span class="deptoclave d-none">130</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>

                        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                            <span class="d-none stsavan" des="TEJIDO">7</span><span class="d-none" des="TEJIDO">150</span>7 - TEJIDO<span class="deptodes d-none">TEJIDO</span><span class="deptoclave d-none">150</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>

                        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                            <span class="d-none stsavan" des="ALMACEN TEJIDO">8</span><span class="d-none" des="ALMACEN TEJIDO">160</span>8 - ALMACEN TEJIDO<span class="deptodes d-none">ALMACEN TEJIDO</span><span class="deptoclave d-none">160</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>

                        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                            <span class="d-none stsavan" des="MONTADO">9</span><span class="d-none" des="MONTADO ">180</span>9 - MONTADO "A"<span class="deptodes d-none">MONTADO "A"</span><span class="deptoclave d-none">180</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>

                        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                            <span class="d-none stsavan" des="ADORNO ">10</span>10 - ADORNO "A"<span class="deptodes d-none">ADORNO "A"</span><span class="deptoclave d-none">210</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>

                        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                            <span class="d-none stsavan" des="ALMACEN ADORNO">11</span>11 - ALMACEN ADORNO<span class="deptodes d-none">ALMACEN ADORNO</span><span class="deptoclave d-none">230</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                    </ul>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3"></div>
                <div class="w-100"></div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <label>Control</label>
                    <input type="text" id="Control" name="Control" autofocus="" 
                           class="form-control form-control-sm numbersOnly text-center" maxlength="11" 
                           placeholder="Escriba un control..." style="height: 50px; font-size: 35px;">
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                    <label>Proceso maquila</label>
                    <input type="text" id="ProcesoMaquila" name="ProcesoMaquila" class="form-control form-control-sm"> 
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 mt-4"> 
                    <select id="ProcesoMaquilaS" name="ProcesoMaquilaS" class="form-control form-control-sm selectNotEnter"></select>
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                    <label>Empleado</label>
                    <input type="text" id="Empleado" name="Empleado" class="form-control form-control-sm" maxlength="6"> 
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 mt-4"> 
                    <select id="EmpleadoS" name="EmpleadoS" class="form-control form-control-sm">
                        <option></option>
                        <?php
                        $data = $this->db->query("SELECT E.Numero AS CLAVE, "
                                        . "(CASE "
                                        . "WHEN E.FijoDestajoAmbos IN(2,3) AND E.AltaBaja = 1 THEN "
                                        . "CONCAT(E.Numero,' ', (CASE WHEN E.PrimerNombre = \"0\" THEN \"\" ELSE E.PrimerNombre END),' ',"
                                        . "(CASE WHEN E.SegundoNombre = \"0\" THEN \"\" ELSE E.SegundoNombre END),' ',"
                                        . "(CASE WHEN E.Paterno = \"0\" THEN \"\" ELSE E.Paterno END),' ', "
                                        . "(CASE WHEN E.Materno = \"0\" THEN \"\" ELSE E.Materno END)) "
                                        . "WHEN E.AltaBaja = 2 AND E.Celula NOT IN(0) THEN CONCAT(E.Numero,' ',E.Busqueda) "
                                        . "WHEN E.AltaBaja = 2 AND E.Celula IN(0) AND E.Numero IN(991,992,993,1005,1006) THEN CONCAT(E.Numero,' ',E.Busqueda) "
                                        . "END) AS EMPLEADO "
                                        . "FROM empleados AS E "
                                        . "WHERE E.FijoDestajoAmbos IN(2,3) AND E.AltaBaja = 1 "
                                        . "OR E.AltaBaja = 2 AND E.Celula NOT IN(0) OR E.Numero IN(991,992,993,1005,1006)")
                                ->result();
                        foreach ($data as $k => $v) {
                            print "<option value='{$v->CLAVE}'>{$v->EMPLEADO}</option>";
                        }
                        ?>
                    </select> 
                </div>  
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                    <label>Fracción</label>
                    <input type="text" id="Fraccion" name="Fraccion" class="form-control form-control-sm" maxlength="6"> 
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 mt-4"> 
                    <select id="FraccionS" name="FraccionS" class="form-control form-control-sm">
                        <option></option>
                        <?php
                        $fracciones = $this->db->select("F.Clave AS CLAVE, CONCAT(F.Clave,' ',F.Descripcion) AS FRACCION", false)
                                        ->from('fracciones AS F')
                                        ->where_not_in('F.Departamento', array(10, 20))
                                        ->order_by('ABS(F.Clave)', 'ASC')
                                        ->get()->result();
                        foreach ($fracciones as $k => $v) {
                            print "<option value='{$v->CLAVE}'>{$v->FRACCION}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <label>Estilo</label>
                    <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm numbersOnly" maxlength="2"  readonly="">
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                    <label>Depto.Actual</label>
                    <input type="text" id="DeptoActual" name="DeptoActual" class="form-control form-control-sm numbersOnly d-none"  readonly="" maxlength="2">
                    <input type="text" id="AvanceDeptoActual" name="AvanceDeptoActual" class="form-control form-control-sm numbersOnly"  readonly="" maxlength="2">
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                    <label>Pares</label>
                    <input type="text" id="Pares" name="Pares" class="form-control form-control-sm numbersOnly" readonly="" maxlength="5">
                </div>
                <div class="col-12 col-sm-12 col-sm-1 col-lg-1 col-xl-1">
                    <button type="button" id="btnAceptar" name="btnAceptar" disabled="" class="btn btn-sm btn-info mt-3"  data-toggle="tooltip" data-placement="right" title="Aceptar">
                        <span class="fa fa-check"></span> ACEPTA
                    </button>
                </div> 
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 d-none">
                    <label>Depto des</label>
                    <input type="text" id="DeptoDes" name="DeptoDes" class="form-control" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 d-none">
                    <label>Depto Avance</label>
                    <input type="text" id="DeptoAva" name="DeptoAva" class="form-control" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 d-none">
                    <label>Fraccion descripcion</label>
                    <input type="text" id="DescripcionFraccion" name="DescripcionFraccion" class="form-control" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-none">
                    <label>Precio Fraccion</label>
                    <input type="text" id="PrecioFraccion" name="PrecioFraccion" class="form-control" readonly="">
                </div>
            </div>
            <!--SECCION DOS-->
            <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <h4>Fracciones pagadas en nomina de este control</h4>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 d-none">
                        <button type="button" id="btnBorrar" name="btnBorrar" class="btn btn-danger">
                            <span class="fa fa-trash"></span>
                        </button>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblAvance" class="table table-hover table-sm table-bordered  compact nowrap" style="width:100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Empleado</th>
                                    <th scope="col">Semana</th>

                                    <th scope="col">Fecha</th>
                                    <th scope="col">Control</th>
                                    <th scope="col">Maq</th>

                                    <th scope="col">Estilo</th>
                                    <th scope="col">Fracción</th>
                                    <th scope="col">Precio</th>

                                    <th scope="col">Pares</th>
                                    <th scope="col">SubTotal</th>
                                    <th scope="col">Mod</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 " align="right">
                        <p class="font-weight-bold total_pares d-none">0</p>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4" align="right">
                        <p class="font-weight-bold total_fracciones" style="color: #cc0033 !important;  font-size: 30px;" >$0.0</p>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                        <span class="font-weight-bold font-italic" style="color : #3F51B5 !important; font-size: 25px;" style="color: #006699;">ESTATUS ACTUAL DEL AVANCE </span>  
                        <div class="w-100"></div>
                        <span class="font-weight-bold estatus_de_avance font-italic">-</span>
                    </div>
                </div>
            </div>
            <!--SECCION TRES-->
            <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1" align="center">
                <a href="<?php print base_url('img/LS.png'); ?>" data-fancybox="images">
                    <img id="FotoEstilo" src="<?php print base_url('img/LS.png'); ?>" class="img-fluid shadow-lg">
                </a>
            </div>

        </div>
    </div>
</div>
<!--RASTREO X CONCEPTO-->
<div class="modal " id="mdlRastreoXConcepto">
    <div class="modal-dialog modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-search"></span> RASTREO POR CONCEPTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Empleado</label>
                        <select id="EmpleadoRXC" name="EmpleadoRXC" class="form-control">
                            <option></option>
                            <?php
                            foreach ($data as $k => $v) {
                                print "<option value='{$v->CLAVE}'>{$v->EMPLEADO}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Concepto</label>
                        <select id="ConceptoRXC" name="ConceptoRXC" class="form-control"></select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblRastreoXConcepto" class="table table-hover table-sm"   style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Sem</th>
                                    <th scope="col">Empleado</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Per</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col">Ded</th>
                                    <th scope="col">Importe</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">Acepta</button>
            </div>
        </div>
    </div>
</div>

<!--RASTREO X CONTROL-->
<div class="modal " id="mdlRastreoXControl">
    <div class="modal-dialog modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-search"></span> RASTREO POR CONTROL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Control</label>
                        <input type="text" id="ControlRXCTROL" name="ControlRXCTROL" class="form-control form-control-sm numeric">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Semana</label>
                        <input type="text" id="SemanaRXCTROL" name="SemanaRXCTROL" class="form-control form-control-sm numeric">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <label>Empleado</label>
                        <select id="EmpleadoRXCTROL" name="EmpleadoRXCTROL" class="form-control">
                            <option></option>
                            <?php
                            foreach ($data as $k => $v) {
                                print "<option value='{$v->CLAVE}'>{$v->EMPLEADO}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <label>Desc.fraccion</label>
                        <input id="FraccionRXCTROL" name="FraccionRXCTROL" class="form-control"> 
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Avance actual</label>
                        <input type="text" id="AvanceActual" name="AvanceActual" class="form-control form-control-sm" readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblRastreoXControl" class="table table-hover table-sm" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Control</th>
                                    <th scope="col">Empleado</th>
                                    <th scope="col">Estilo</th>
                                    <th scope="col">Fracción</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Semana</th>
                                    <th scope="col">Pares</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">SubTotal</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="right">
                        <p class="font-weight-bold total_pesos" style="color: #cc0033 !important;" >$0.0</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">Acepta</button>
            </div>
        </div>
    </div>
</div>

<!--PESPUNTE FRACCIONES 324,322,309,308-->
<div class="modal" id="mdlPespunteFraccionesFail" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-draw-polygon"></span> PESPUNTE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row"> 
                    <div class="col-2">
                        <a href="<?php print base_url('img/sin_foto_sm.png'); ?>" data-fancybox="images">
                            <img id="FotoEstiloNominaPespunte" src="<?php print base_url('img/sin_foto_sm.png'); ?>" class="img-fluid">
                        </a>
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-2">
                                <label>CONTROL</label>
                                <input id="ControlPespunteFail" name="ControlPespunteFail" class="form-control numbersOnly" maxlength="10"> 
                            </div>
                            <div class="col-5">
                                <label>FRACCION</label>
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" id="ClaveFraccionPespunteFail" name="ClaveFraccionPespunteFail" maxlength="4" class="form-control">
                                    </div>
                                    <div class="col-9">
                                        <select id="FraccionPespunteFail" name="FraccionPespunteFail" class="form-control">
                                            <?php
                                            foreach ($this->db->query("SELECT F.Clave,F.Descripcion FROM fracciones AS F WHERE F.Clave IN(308,309,322,324,405,315) ORDER BY ABS(F.Clave) ASC")->result() as $k => $v) {
                                                print "<option value='{$v->Clave}'>{$v->Clave} {$v->Descripcion}</option>";
                                            }
                                            ?> 
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <label>CELULA</label>
                                <div class="row">
                                    <div class="col-4">
                                        <input type="text" id="ClaveCelulaPespunteFail" name="ClaveCelulaPespunteFail" maxlength="4" class="form-control">
                                    </div>
                                    <div class="col-8">
                                        <select id="CelulaPespunteFail" name="CelulaPespunteFail" class="form-control selectNotEnter notEnter">
                                            <?php
                                            foreach ($this->db->query("SELECT E.Numero, E.Busqueda AS CELULA FROM empleados AS E WHERE E.Numero IN(1000, 1001, 1002, 994, 995, 996, 997, 998, 999)")->result() as $k => $v) {
                                                print "<option value='{$v->Numero}'>{$v->Numero} {$v->CELULA}</option>";
                                            }
                                            ?> 
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-3">
                                <label>Mano de obra</label>
                                <input id="FraccionPrecioMOPespunteFail" style="font-weight: bold;" name="FraccionPrecioMOPespunteFail" class="form-control" readonly=""> 
                            </div>
                            <div class="col-3">
                                <label>Estilo</label>
                                <input id="EstiloControlPespunteFail" style="font-weight: bold;" name="EstiloControlPespunteFail" class="form-control" readonly=""> 
                            </div>

                            <div class="col-2">
                                <label>Pares</label>
                                <input id="ParesControlPespunteFail" style="font-weight: bold;" name="ParesControlPespunteFail" class="form-control" readonly=""> 
                            </div> 
                            <div class="col-4 text-center">
                                <p class="mb-0">TOTAL</p>
                                <p class="total_x_control_pares_x_mo" style="color: #008000; font-weight: bold; font-size: 22px;">$ 0.0</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-100"></div>
                    <div class="col-12">
                        <table id="tblFraccionesPagadasFail" class="table table-striped table-hover table-sm table-bordered  compact nowrap" style="width:100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Emp</th>
                                    <th scope="col">Semana</th>

                                    <th scope="col">Fecha</th>
                                    <th scope="col">Control</th>
                                    <th scope="col">Maq</th>

                                    <th scope="col">Estilo</th>
                                    <th scope="col">Frac</th>
                                    <th scope="col">Precio</th>

                                    <th scope="col">Pares</th>
                                    <th scope="col">SubTotal</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 " align="center">
                        <p class="font-weight-bold total_fracciones_pes_fail" style="color: #cc0033 !important;  font-size: 30px;" >$0.0</p>
                    </div>
                </div> 
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-primary" id="btnAceptaPespunteFail" style="background-color: #43A047; "><span class="fa fa-check"></span> ACEPTA</button>
            </div>
        </div>
    </div>
</div>


<!--ADORNO FRACCIONES 324,322,309,308-->
<div class="modal" id="mdlAdornoFraccionesNomina" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-palette"></span> Adorno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-2">
                        <label>CONTROL</label>
                        <input id="ControlAdornoNomina" name="ControlAdornoNomina" class="form-control numbersOnly" maxlength="10"> 
                    </div>
                    <div class="col-4">
                        <label>FRACCION</label>
                        <select id="FraccionAdornoNomina" name="FraccionAdornoNomina" class="form-control">
                            <?php
                            $fraccionesp = $this->db->query("SELECT F.Clave,F.Descripcion FROM fracciones AS F WHERE F.Clave IN(308,309,322,324,405)")->result();
                            foreach ($fraccionesp as $k => $v) {
                                print "<option value='{$v->Clave}'>{$v->Clave} {$v->Descripcion}</option>";
                            }
                            ?> 
                        </select>
                    </div>
                    <div class="col-4">
                        <label>CELULA</label>
                        <select id="CelulaAdornoNomina" name="CelulaAdornoNomina" class="form-control">
                            <?php
                            $empleadosp = $this->db->query("SELECT E.Numero, E.Busqueda AS CELULA FROM empleados AS E WHERE E.Numero IN(1000, 1001, 1002, 994, 995, 996, 997, 998, 999)")->result();
                            foreach ($empleadosp as $k => $v) {
                                print "<option value='{$v->Numero}'>{$v->Numero} {$v->CELULA}</option>";
                            }
                            ?> 
                        </select>
                    </div> 
                    <DIV class="w-100"></DIV>
                    <div class="col-3">
                        <label>Mano de obra</label>
                        <input id="FraccionPrecioMOAdornoNomina" style="font-weight: bold;" name="FraccionPrecioMOAdornoNomina" class="form-control" readonly=""> 
                    </div>
                    <div class="col-3">
                        <label>Estilo</label>
                        <input id="EstiloControlAdornoNomina" style="font-weight: bold;" name="EstiloControlAdornoNomina" class="form-control" readonly=""> 
                    </div>

                    <div class="col-2">
                        <label>Pares</label>
                        <input id="ParesControlAdornoNomina" style="font-weight: bold;" name="ParesControlAdornoNomina" class="form-control" readonly=""> 
                    </div> 
                    <div class="col-4">
                        <p>TOTAL</p>
                        <p class="total_x_control_pares_x_mo" style="color: #008000; font-weight: bold; font-size: 20px;">$ 0.0</p>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12">
                        <table id="tblFraccionesPagadasNomina" class="table table-striped table-hover table-sm table-bordered  compact nowrap" style="width:100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Emp</th>
                                    <th scope="col">Semana</th>

                                    <th scope="col">Fecha</th>
                                    <th scope="col">Control</th>
                                    <th scope="col">Maq</th>

                                    <th scope="col">Estilo</th>
                                    <th scope="col">Frac</th>
                                    <th scope="col">Precio</th>

                                    <th scope="col">Pares</th>
                                    <th scope="col">SubTotal</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 " align="center">
                        <p class="font-weight-bold total_fracciones_ador_nom" style="color: #cc0033 !important;  font-size: 30px;" >$0.0</p>
                    </div>
                </div> 
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-primary" id="btnAceptaAdornoNomina" style="background-color: #43A047; "><span class="fa fa-check"></span> ACEPTA</button>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = '<?php base_url('Avance/') ?>', pnlTablero = $("#pnlTablero");
    var Fecha = pnlTablero.find("#Fecha"), Departamento = pnlTablero.find("#Departamento"),
            Semana = pnlTablero.find("#Semana"), tblAvance = pnlTablero.find("#tblAvance"),
            Control = pnlTablero.find("#Control"), Avances,
            btnBuscarControl = pnlTablero.find("#btnBuscarControl"),
            Estilo = pnlTablero.find("#Estilo"),
            Fraccion = pnlTablero.find("#Fraccion"),
            FraccionS = pnlTablero.find("#FraccionS"),
            DeptoActual = pnlTablero.find("#DeptoActual"),
            AvanceDeptoActual = pnlTablero.find("#AvanceDeptoActual"),
            Pares = pnlTablero.find("#Pares"),
            btnAceptar = pnlTablero.find("#btnAceptar"), btnBorrar = pnlTablero.find("#btnBorrar"),
            ProcesoMaquila = pnlTablero.find("#ProcesoMaquila"),
            ProcesoMaquilaS = pnlTablero.find("#ProcesoMaquilaS"),
            Empleado = pnlTablero.find("#Empleado"),
            EmpleadoS = pnlTablero.find("#EmpleadoS"),
            PrecioFraccion = pnlTablero.find("#PrecioFraccion"), DeptoDes = pnlTablero.find("#DeptoDes"),
            DeptoAva = pnlTablero.find("#DeptoAva"), DescripcionFraccion = pnlTablero.find("#DescripcionFraccion"),
            btnRastreoXConcepto = pnlTablero.find("#btnRastreoXConcepto"),
            btnRastreoXControl = pnlTablero.find("#btnRastreoXControl"),
            mdlRastreoXConcepto = $("#mdlRastreoXConcepto"), mdlRastreoXControl = $("#mdlRastreoXControl"),
            RastreoXConcepto, tblRastreoXConcepto = mdlRastreoXConcepto.find("#tblRastreoXConcepto"),
            RastreoXControl, tblRastreoXControl = mdlRastreoXControl.find("#tblRastreoXControl"),
            EmpleadoRXC = mdlRastreoXConcepto.find("#EmpleadoRXC"),
            ConceptoRXC = mdlRastreoXConcepto.find("#ConceptoRXC"),
            ControlRXCTROL = mdlRastreoXControl.find("#ControlRXCTROL"),
            SemanaRXCTROL = mdlRastreoXControl.find("#SemanaRXCTROL"),
            EmpleadoRXCTROL = mdlRastreoXControl.find("#EmpleadoRXCTROL"),
            FraccionRXCTROL = mdlRastreoXControl.find("#FraccionRXCTROL"),
            AvanceActual = mdlRastreoXControl.find("#AvanceActual"),
            btnDesarrolloDeMuestras = pnlTablero.find("#btnDesarrolloDeMuestras"),
            btnImprimePagosCelulas = pnlTablero.find("#btnImprimePagosCelulas"),
            FotoEstilo = pnlTablero.find("#FotoEstilo"),
            mono = '<?php print $_SESSION['USERNAME']; ?>',
            btnPespunteFraccionesFail = pnlTablero.find("#btnPespunteFraccionesFail"),
            mdlPespunteFraccionesFail = $("#mdlPespunteFraccionesFail"),
            ControlPespunteFail = mdlPespunteFraccionesFail.find("#ControlPespunteFail"),
            ClaveFraccionPespunteFail = mdlPespunteFraccionesFail.find("#ClaveFraccionPespunteFail"),
            FraccionPespunteFail = mdlPespunteFraccionesFail.find("#FraccionPespunteFail"),
            EstiloControlPespunteFail = mdlPespunteFraccionesFail.find("#EstiloControlPespunteFail"),
            FraccionPrecioMOPespunteFail = mdlPespunteFraccionesFail.find("#FraccionPrecioMOPespunteFail"),
            ClaveCelulaPespunteFail = mdlPespunteFraccionesFail.find("#ClaveCelulaPespunteFail"),
            CelulaPespunteFail = mdlPespunteFraccionesFail.find("#CelulaPespunteFail"),
            btnAceptaPespunteFail = mdlPespunteFraccionesFail.find("#btnAceptaPespunteFail"),
            tblFraccionesPagadasFail = mdlPespunteFraccionesFail.find("#tblFraccionesPagadasFail"),
            FraccionesPagadasFail,
            ParesControlPespunteFail = mdlPespunteFraccionesFail.find("#ParesControlPespunteFail"),
            btnAdornoFraccionesNomina = pnlTablero.find("#btnAdornoFraccionesNomina"),
            mdlAdornoFraccionesNomina = $("#mdlAdornoFraccionesNomina"),
            ControlAdornoNomina = mdlAdornoFraccionesNomina.find("#ControlAdornoNomina");

    function getFraccionesPespunteFail() {
        var cols = [
            {"data": "ID"}/*0*/,
            {"data": "EMPLEADO"}/*1*/,
            {"data": "SEMANA"}/*2*/,
            {"data": "FECHA"}/*3*/,
            {"data": "CONTROL"}/*4*/,
            {"data": "MAQUILA"}/*5*/,
            {"data": "ESTILO"}/*6*/,
            {"data": "NUM_FRACCION"}/*7*/,
            {"data": "PRECIO_FRACCION"}/*8*/,
            {"data": "PARES"}/*9*/,
            {"data": "SUBTOTAL"}/*10*/
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
            "ajax": {
                "url": '<?php print base_url('Avance/getAvancesNominaPespunteFail'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL = ControlPespunteFail.val() ? ControlPespunteFail.val() : '';
                    d.EMPLEADO = CelulaPespunteFail.val() ? CelulaPespunteFail.val() : '';
                }
            },
            buttons: buttons,
            "columns": cols,
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 1000,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "175px",
            "scrollX": true,
            "aaSorting": [
                [0, 'desc']
            ],
            "drawCallback": function (settings) {
                var api = this.api();
                var r = 0, prs = 0;
                $.each(api.rows().data(), function (k, v) {
                    prs += parseInt(v.PARES);
                    r += parseFloat(v.SUBTOTAL);
                });
                mdlPespunteFraccionesFail.find(".total_fracciones_pes_fail").text("$ " + r.toFixed(3));
            }
        };
        if ($.fn.DataTable.isDataTable('#tblFraccionesPagadasFail')) {
            FraccionesPagadasFail.ajax.reload();
            return;
        } else {
            FraccionesPagadasFail = tblFraccionesPagadasFail.DataTable(xoptions);
        }
    }

    $(document).ready(function () {
        pnlTablero.find("input").addClass("font-weight-bold");
        handleEnterDiv(pnlTablero);
        handleEnterDiv(mdlRastreoXConcepto);
        handleEnterDiv(mdlRastreoXControl);
        handleEnterDiv(mdlPespunteFraccionesFail);
        /*ADORNO*/

        btnAdornoFraccionesNomina.click(function () {
            mdlAdornoFraccionesNomina.modal('show');
        });

        mdlAdornoFraccionesNomina.on('hidden.bs.modal', function () {
            onClearPanelInputSelectEnableDisable(mdlAdornoFraccionesNomina);
        });
        mdlAdornoFraccionesNomina.on('shown.bs.modal', function () {
//            Control
        });

        mdlPespunteFraccionesFail.find(".modal-dialog").css("min-width", "950px");

        btnAceptaPespunteFail.click(function () {
            /*REVISA SI YA SE PAGO ESA FRACCION*/
            $.getJSON('<?php print base_url('Avance/onRevisarFraccionPagada') ?>',
                    {
                        CONTROL: ControlPespunteFail.val(),
                        FRACCION: FraccionPespunteFail.val()
                    })
                    .done(function (a) {
                        console.log(a);
                        /*202401043 prueba esta en tejido*/
                        if (parseInt(a[0].COBRADA) === 0) {
                            if (parseInt(a[0].COBRADA) >= 1) {
                                onCampoInvalido(mdlPespunteFraccionesFail, "ESTA FRACCIÓN YA FUE COBRADA", function () {
                                    FraccionPespunteFail[0].selectize.focus();
                                    onClear(FraccionPrecioMOPespunteFail);
                                    onClear(FraccionPespunteFail);
                                    mdlPespunteFraccionesFail.find("p.total_x_control_pares_x_mo").text("$ " + $.number(0, 4, '.', ','));
                                });
                            } else {
                                if (ControlPespunteFail.val() === '') {
                                    onCampoInvalido(mdlPespunteFraccionesFail, "DEBE DE ESPECIFICAR UN CONTROL", function () {
                                        ControlPespunteFail.focus().select();
                                    });
                                    return;
                                }
                                if (FraccionPespunteFail.val() === '') {
                                    onCampoInvalido(mdlPespunteFraccionesFail, "DEBE DE ESPECIFICAR UNA FRACCIÓN", function () {
                                        ClaveFraccionPespunteFail.focus().select();
                                    });
                                    return;
                                }
                                if (CelulaPespunteFail.val() === '') {
                                    onCampoInvalido(mdlPespunteFraccionesFail, "DEBE DE ESPECIFICAR UN EMPLEADO", function () {
                                        ClaveCelulaPespunteFail.focus().select();
                                    });
                                    return;
                                }
                                onDisable(btnAceptaPespunteFail);
                                $.getJSON('<?php print base_url('Avance/onPagarFraccionNominaPespunte') ?>', {
                                    CONTROL: ControlPespunteFail.val(),
                                    FRACCION: FraccionPespunteFail.val(),
                                    CELULA: CelulaPespunteFail.val(),
                                    PARES: ParesControlPespunteFail.val()
                                }).done(function (a) {
                                    swal({
                                        title: "ATENCIÓN",
                                        text: "SE HA HECHO EL PAGO DE LA FRACCIÓN " + FraccionPespunteFail.val() + " AL EMPLEADO " + CelulaPespunteFail.val(),
                                        icon: "success",
                                        buttons: false,
                                        timer: 750
                                    }).then((action) => {
                                        onClear(ControlPespunteFail);
                                        onClear(ClaveFraccionPespunteFail);
                                        onClear(FraccionPespunteFail);
                                        onClear(ClaveCelulaPespunteFail);
                                        onClear(CelulaPespunteFail);
                                        onDisable(btnAceptaPespunteFail);
                                        ControlPespunteFail.focus().select();
                                    });
                                }).fail(function (x) {
                                    console.log(x);
                                    getError(x);
                                });
                            }
                        } else {
                            onCampoInvalido(mdlPespunteFraccionesFail, "ESTA FRACCIÓN NO EXISTE O YA FUE COBRADA", function () {
                                FraccionPespunteFail[0].selectize.focus();
                                onClear(FraccionPrecioMOPespunteFail);
                                onClear(FraccionPespunteFail);
                                mdlPespunteFraccionesFail.find("p.total_x_control_pares_x_mo").text("$ " + $.number(0, 4, '.', ','));
                            });
                        }
                    }).fail(function (x) {
                console.log(x);
                console.log(x);
                getError(x);
            });
        });

        ClaveCelulaPespunteFail.keydown(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                setValueSelectize(CelulaPespunteFail, $(this).val());
                if (CelulaPespunteFail.val()) {
                    onEnable(btnAceptaPespunteFail);
                    btnAceptaPespunteFail.focus();
                } else {
                    onCampoInvalido(mdlPespunteFraccionesFail, "FRACCION INVÁLIDA O NO EXISTE PARA EL ESTILO", function () {
                        ClaveCelulaPespunteFail.focus().select();
                        onClear(CelulaPespunteFail);
                    });
                }
            }
        });

        ClaveFraccionPespunteFail.keydown(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                setValueSelectize(FraccionPespunteFail, $(this).val());
                if (FraccionPespunteFail.val()) {
                } else {
                    onCampoInvalido(mdlPespunteFraccionesFail, "FRACCION INVÁLIDA O NO EXISTE PARA EL ESTILO", function () {
                        ClaveFraccionPespunteFail.focus().select();
                        onClear(FraccionPespunteFail);
                    });
                }
            }
        });

        FraccionPespunteFail.change(function () {
            if (FraccionPespunteFail.val()) {
                $.getJSON('<?php print base_url('Avance/getManoDeObraXFraccionEstiloPespunte') ?>',
                        {
                            ESTILO: EstiloControlPespunteFail.val(),
                            FRACCION: FraccionPespunteFail.val()
                        })
                        .done(function (a) {
                            console.log(a);
                            if (a.length > 0) {
                                var r = a[0];
                                if (parseFloat(r.MANO_DE_OBRA) > 0 || parseInt(r.MANO_DE_OBRA) > 0) {
                                    FraccionPrecioMOPespunteFail.val(r.MANO_DE_OBRA);
                                    ClaveCelulaPespunteFail.focus();
                                    var tt = parseFloat(FraccionPrecioMOPespunteFail.val() ? FraccionPrecioMOPespunteFail.val() : 0) * parseInt(ParesControlPespunteFail.val() ? ParesControlPespunteFail.val() : 0);
                                    mdlPespunteFraccionesFail.find("p.total_x_control_pares_x_mo").text("$ " + $.number(tt, 4, '.', ','));
                                } else {
                                    onCampoInvalido(mdlPespunteFraccionesFail, "ESTE ESTILO NO TIENE MANO DE OBRA VÁLIDA PARA ESTA FRACCIÓN, VERIFIQUE CON INGENIERIA", function () {
                                        ClaveFraccionPespunteFail.focus().select();
                                        onClear(FraccionPrecioMOPespunteFail);
                                        onClear(FraccionPespunteFail);
                                        mdlPespunteFraccionesFail.find("p.total_x_control_pares_x_mo").text("$ " + $.number(0, 4, '.', ','));
                                    });
                                }
                            } else {
                                onCampoInvalido(mdlPespunteFraccionesFail, "ESTE ESTILO NO TIENE ESTA FRACCIÓN", function () {
                                    ClaveFraccionPespunteFail.focus().select();
                                    onClear(FraccionPrecioMOPespunteFail);
                                    onClear(FraccionPespunteFail);
                                    mdlPespunteFraccionesFail.find("p.total_x_control_pares_x_mo").text("$ " + $.number(0, 4, '.', ','));
                                });
                            }
                        }).fail(function (x) {
                    console.log(x);
                    getError(x);
                });
            }
        }).keydown(function () {

        });

        ControlPespunteFail.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (ControlPespunteFail.val()) {
                    onOpenOverlay('Cargando...');
                    FraccionesPagadasFail.ajax.reload();
                    $.getJSON('<?php print base_url('Avance/getInfoXControlPespunte') ?>', {CONTROL: ControlPespunteFail.val()})
                            .done(function (a) {
                                console.log(a);
                                var r = a[0];
                                EstiloControlPespunteFail.val(r.ESTILO);
                                ParesControlPespunteFail.val(r.PARES);
                                mdlPespunteFraccionesFail.find("#FotoEstiloNominaPespunte")[0].src = '<?php print base_url(); ?>/' + r.FOTO;
                                mdlPespunteFraccionesFail.find("#FotoEstiloNominaPespunte").parent("a")[0].href = '<?php print base_url(); ?>/' + r.FOTO;
                            }).fail(function (x) {
                        onCloseOverlay();
                        console.log(x);
                    }).always(function () {
                        onCloseOverlay();
                    });
                } else {
                    onClear(ParesControlPespunteFail);
                    onClear(EstiloControlPespunteFail);
                    onClear(ClaveFraccionPespunteFail);
                    onClear(FraccionPespunteFail);
                    onClear(ClaveCelulaPespunteFail);
                    onClear(FraccionPrecioMOPespunteFail);
                    onClear(CelulaPespunteFail);
                    onDisable(btnAceptaPespunteFail);
                    mdlPespunteFraccionesFail.find("p.total_x_control_pares_x_mo").text("$ " + $.number(0, 4, '.', ','));
                    mdlPespunteFraccionesFail.find("#FotoEstiloNominaPespunte")[0].src = '<?php print base_url('img/sin_foto_sm.png'); ?>';
                    mdlPespunteFraccionesFail.find("#FotoEstiloNominaPespunte").parent("a")[0].href = '<?php print base_url('img/sin_foto_sm.png'); ?>';
                    FraccionesPagadasFail.ajax.reload();
                }
            }
            if (e.keyCode === 8) {
                onClear(ControlPespunteFail);
                onClear(ParesControlPespunteFail);
                onClear(EstiloControlPespunteFail);
                onClear(ClaveFraccionPespunteFail);
                onClear(FraccionPespunteFail);
                onClear(ClaveCelulaPespunteFail);
                onClear(FraccionPrecioMOPespunteFail);
                onClear(CelulaPespunteFail);
                onDisable(btnAceptaPespunteFail);
                mdlPespunteFraccionesFail.find("p.total_x_control_pares_x_mo").text("$ " + $.number(0, 4, '.', ','));
                mdlPespunteFraccionesFail.find("#FotoEstiloNominaPespunte")[0].src = '<?php print base_url('img/sin_foto_sm.png'); ?>';
                mdlPespunteFraccionesFail.find("#FotoEstiloNominaPespunte").parent("a")[0].href = '<?php print base_url('img/sin_foto_sm.png'); ?>';
                FraccionesPagadasFail.ajax.reload();
            }
        }).keypress(function (e) {
            console.log('KP: ');
            console.log(e.keyCode);
            console.log('KP: ');
        });

        mdlPespunteFraccionesFail.on('shown.bs.modal', function () {
            onBeep(1);
            mdlPespunteFraccionesFail.find("input").val('');
            onClear(mdlPespunteFraccionesFail.find("#FraccionPespunteFail"));
            onClear(mdlPespunteFraccionesFail.find("#CelulaPespunteFail"));
            mdlPespunteFraccionesFail.find("#ControlPespunteFail").focus();
            getFraccionesPespunteFail();
            onDisable(btnAceptaPespunteFail);
            mdlPespunteFraccionesFail.find("#FotoEstiloNominaPespunte")[0].src = '<?php print base_url('img/sin_foto_sm.png'); ?>';
            mdlPespunteFraccionesFail.find("#FotoEstiloNominaPespunte").parent("a")[0].href = '<?php print base_url('img/sin_foto_sm.png'); ?>';
        });

        btnPespunteFraccionesFail.click(function () {
            mdlPespunteFraccionesFail.modal('show');
        });

        btnImprimePagosCelulas.click(function () {
            onOpenOverlay('');
            btnImprimePagosCelulas.attr('disabled', true);
            $.post('<?php print base_url('Avance/ImprimePagosCelulas'); ?>', {
                EMPLEADO: Empleado.val() ? Empleado.val() : '',
                SEMANA: Semana.val() ? Semana.val() : '',
                FECHA: Fecha.val() ? Fecha.val() : ''
            }).done(function (a) {
                if (a.length > 0) {
                    onImprimirReporteFancyAFC(a, function (a, b) {
                        btnImprimePagosCelulas.attr('disabled', false);
                    });
                }
            }).fail(function (x) {
                getError(x);
            }).always(function () {
                onCloseOverlay();
            });
        });

        Departamento.on('keydown', function (e) {
            if (e.keyCode === 13 && Departamento.val()) {
                onValidarDepto();
            } else {

            }
        });

        FraccionS.change(function () {
            if (FraccionS.val()) {
                FraccionS[0].selectize.disable();
            } else {
                FraccionS[0].selectize.enable();
            }
        });

        Fraccion.on('keydown', function (e) {
            if (e.keyCode === 13 && Fraccion.val()) {
                FraccionS[0].selectize.setValue(Fraccion.val());
                if (FraccionS.val()) {
                    FraccionS[0].selectize.disable();
                    Fraccion.focus().select();
                } else {
                    FraccionS[0].selectize.enable();
                    FraccionS[0].selectize.clear();
                }
            } else if (Fraccion.val() === '') {
                FraccionS[0].selectize.enable();
                FraccionS[0].selectize.clear();
            }
            if (Fraccion.val() && EmpleadoS.val()) {
                btnAceptar.attr('disabled', false);
            }
        });

        ProcesoMaquila.on('keydown', function (e) {
            if (e.keyCode === 13 && ProcesoMaquila.val()) {
                ProcesoMaquilaS[0].selectize.setValue(ProcesoMaquila.val());
                if (ProcesoMaquilaS.val()) {
                    ProcesoMaquilaS[0].selectize.disable();
                    Empleado.focus().select();
                } else {
                    ProcesoMaquilaS[0].selectize.enable();
                }
            } else {
                ProcesoMaquilaS[0].selectize.enable();
                ProcesoMaquilaS[0].selectize.clear();
            }
        });

        Empleado.on('keydown', function (e) {
            if (e.keyCode === 13)
            {
                Avances.ajax.reload();
            }
            if (Empleado.val() === '' && e.keyCode === 13 || Empleado.val() === '' && e.keyCode === 8)
            {
                Avances.ajax.reload();
                return;
            }
            if (e.keyCode === 13 && Empleado.val()) {
                EmpleadoS[0].selectize.setValue(Empleado.val());
                if (EmpleadoS.val()) {
                    EmpleadoS[0].selectize.disable();
                    Fraccion.focus().select();
                } else {
                    EmpleadoS[0].selectize.enable();
                }
            } else {
                console.log('KEYCODE=>', e.keyCode);
                if (e.keyCode === 13) {
                    EmpleadoS[0].selectize.enable();
                    EmpleadoS[0].selectize.clear();
                }
            }
        });

        mdlRastreoXControl.on('hidden.bs.modal', function () {
            Control.focus().select();
        });

        mdlRastreoXConcepto.on('hidden.bs.modal', function () {
            Control.focus().select();
        });

        mdlRastreoXControl.on('shown.bs.modal', function () {
            mdlRastreoXControl.find("input").val('');
            $.each(mdlRastreoXControl.find("select"), function (k, v) {
                mdlRastreoXControl.find("select")[k].selectize.clear(true);
            });
            ControlRXCTROL.focus();
        });

        mdlRastreoXConcepto.on('shown.bs.modal', function () {
            mdlRastreoXConcepto.find("input").val('');
            $.each(mdlRastreoXConcepto.find("select"), function (k, v) {
                mdlRastreoXConcepto.find("select")[k].selectize.clear(true);
            });
            EmpleadoRXC[0].selectize.focus();
            EmpleadoRXC[0].selectize.open();
        });

        FraccionRXCTROL.on('keyup change', function () {
            if ($(this).val()) {
                RastreoXControl.ajax.reload();
            }
        });
        EmpleadoRXCTROL.on('keydown', function (e) {
            if (e.keyCode === 13) {
                RastreoXControl.ajax.reload();
            }
        });
        SemanaRXCTROL.on('keydown', function (e) {
            if (e.keyCode === 13) {
                RastreoXControl.ajax.reload();
            }
        });

        ControlRXCTROL.on('keydown', function (e) {
            if (e.keyCode === 13) {
                RastreoXControl.ajax.reload();
            }
        });

        ConceptoRXC.on('change', function () {
            if ($(this).val()) {
                RastreoXConcepto.ajax.reload();
            }
        });

        EmpleadoRXC.on('change', function () {
            if ($(this).val()) {
                RastreoXConcepto.ajax.reload();
            }
        });

        btnDesarrolloDeMuestras.click(function () {
            $.fancybox.open({
                src: '<?php print base_url('DesarrolloMuestras/?origen=PRODUCCION'); ?>',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
                        console.info('done!');
                    },
                    iframe: {
                        tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                        preload: true,
                        css: {
                            width: "100%",
                            height: "100%"
                        },
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });

        btnRastreoXControl.click(function () {
            mdlRastreoXControl.modal('show');
        });

        btnRastreoXConcepto.click(function () {
            mdlRastreoXConcepto.modal('show');
        });

        btnBorrar.click(function () {
            var row = Avances.rows({selected: true}).data();
            if (parseInt(row.ID) > 0) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Eliminando avance...'
                });
                $.post('<?php print base_url('Avance/onEliminarAvance') ?>', {ID: row.ID}).done(function (a) {
                    console.log(a);
                }).fail(function (x, y, z) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', 'ES NECESARIO SELECCIONAR UN REGISTRO A ELIMINAR', 'warning');
            }
        });

        btnAceptar.click(function () {

            if (Departamento.val() && Control.val()) {
                var f = new FormData();
                f.append('CONTROL', Control.val());
                f.append('FECHA', Fecha.val());
                f.append('DEPTO', Departamento.val());
                f.append('SEMANA', Semana.val());
                f.append('PROCESO_MAQUILA', ProcesoMaquila.val() ? ProcesoMaquila.val() : 0);
                f.append('EMPLEADO', Empleado.val());
                f.append('FRACCION', Fraccion.val());
                var frt = Fraccion.find("option:selected").text();
                frt = frt.replace(Fraccion.val() + ' ', '');
                f.append('FRACCIONT', frt);
                f.append('ESTILO', Estilo.val());
                f.append('DEPTOACTUAL', DeptoActual.val());
                f.append('AVANCEDEPTOACTUAL', AvanceDeptoActual.val());
                f.append('DEPTOT', DeptoDes.val());
                f.append('PARES', Pares.val());
                f.append('PRECIO_FRACCION', (PrecioFraccion.val() ? PrecioFraccion.val() : ''));
                $.ajax({
                    url: '<?php print base_url('Avance/onAvanzar'); ?>',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: f
                }).done(function (a, b, c) {
                    console.log(a);
                    onNotifyOld('<span class="fa fa-check"></span>', 'SE HA AVANZADO EL CONTROL ' + Control.val(), 'success');
                    Fraccion.val('');
                    FraccionS[0].selectize.clear();
                    Empleado.val('');
                    EmpleadoS[0].selectize.clear();
                    Estilo.val('');
                    DeptoActual.val('');
                    AvanceDeptoActual.val('');
                    pnlTablero.find(".estatus_de_avance").text('');
                    Pares.val('');
                    btnAceptar.attr('disabled', true);
                    Control.focus().select();
                }).fail(function (x, y, z) {
                    getError(x);
                });
            } else {
                if (Departamento.val()) {
                    if (Control.val()) {

                    } else {
                        iMsg('DEBE DE ESPECIFICAR UN CONTROL', 'w', function () {
                            Control.focus().select();
                        });
                    }
                } else {
                    iMsg('DEBE DE ESPECIFICAR UN DEPARTAMENTO', 'w', function () {
                        Departamento.focus().select();
                    });
                }
            }
        });

//        Estilo.on('change keydown keypress', function () {
//            getPrecioFraccionXEstiloFraccion();
//        });
//        Fraccion.on('change keydown keypress', function () {
//            if (Fraccion.val()) {
//                getPrecioFraccionXEstiloFraccion();
//            }
//        });
//        btnBuscarControl.click(function () {
//            if (Fecha.val() && Departamento.val() && Semana.val()) {
//                getDeptosXControl($(this).parent().find("#Control"));
//            } else {
//                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UNA FECHA', 'warning');
        //            }
//        });

        getDepartamentos();
        $("#usuario").val('<?php print $_SESSION['USERNAME']; ?>').prop('disabled', true);
        $(".usuario_logued").text('<?php print $_SESSION['USERNAME']; ?>');

        $.getJSON('<?php print base_url('Avance/getMaquilasPlantillas'); ?>').done(function (d) {
            d.forEach(function (v) {
                ProcesoMaquilaS[0].selectize.addOption({text: v.MaquilasPlantillas, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });

        Control.on('keydown', function (e) {
            if (e.keyCode === 13 && Control.val()) {
                onOpenOverlay('Espere...');
                ProcesoMaquila.attr('disabled', true);
                ProcesoMaquilaS[0].selectize.disable();
                Fraccion.attr('disabled', true);
                FraccionS[0].selectize.disable();
                Empleado.attr('disabled', true);
                EmpleadoS[0].selectize.disable();
                btnAceptar.attr('disabled', true);

                //                getDeptosXControl($(this));
                //                getDeptoActualXControl();
                $.getJSON('<?php print base_url('Avance/getInformacionXControl') ?>', {CONTROL: Control.val() ? Control.val() : ''}).done(function (a, b, c) {
                    console.log("CONTROL", a);
                    onCloseOverlay();
                    if (a.length > 0) {

                        ProcesoMaquila.attr('disabled', false);
                        ProcesoMaquilaS[0].selectize.enable();
                        Fraccion.attr('disabled', false);
                        FraccionS[0].selectize.enable();
                        Empleado.attr('disabled', false);
                        EmpleadoS[0].selectize.enable();
                        btnAceptar.attr('disabled', false);


                        var rr = a[0];
                        AvanceDeptoActual.val(rr.ESTATUS_PRODUCCION);
                        pnlTablero.find(".estatus_de_avance").text(rr.ESTATUS_PRODUCCION_TEXT);
                        if (parseInt(Departamento.val()) === parseInt(rr.ESTATUS_PRODUCCION)) {
                            iMsg('EL DEPARTAMENTO ACTUAL NO CONCUERDA CON EL AVANCE: ' + rr.ESTATUS_PRODUCCION_TEXT, 'w', function () {
                                Control.focus().select();
                            });
                            return;
                        }
                        if (parseInt(rr.ESTATUS_PRODUCCION) !== 13 && parseInt(rr.ESTATUS_PRODUCCION) !== 14) {
                            ProcesoMaquila.val(rr.MAQUILADO);
                            ProcesoMaquilaS[0].selectize.setValue(ProcesoMaquila.val());
                            Estilo.val(rr.ESTILO);
                            DeptoActual.val(rr.DEPTO);
                            AvanceDeptoActual.val(rr.ESTATUS_PRODUCCION);
                            pnlTablero.find(".estatus_de_avance").text(rr.ESTATUS_PRODUCCION_TEXT);

                            if (ProcesoMaquilaS.val()) {
                                ProcesoMaquilaS[0].selectize.disable();
                                Empleado.focus().select();
                                btnAceptar.attr('disabled', false);
                            } else {
                                ProcesoMaquila.focus().select();
                                ProcesoMaquilaS[0].selectize.enable();
                                btnAceptar.attr('disabled', true);
                                btnAceptar.focus();
                            }

                            Pares.val(rr.PARES);
                            var rta = '<?php print base_url(); ?>' + rr.FOTO;
                            FotoEstilo[0].src = rta;
                            FotoEstilo.parent()[0].href = rta;

                            var xDepartamento = Departamento.val() ? parseInt(Departamento.val()) : 0;
                            var stsavan = parseInt(rr.ESTATUS_PRODUCCION);

                            if (xDepartamento === 4 && stsavan === 3) {
                                Fraccion.val(102);
                                FraccionS[0].selectize.setValue(102);
                                onEnable(btnAceptar);
                                if (parseInt(rr.MAQUILA) === 98) {
                                    Fraccion.val(113);
                                    FraccionS[0].selectize.setValue(113);
                                }
                            }
                            if (xDepartamento === 33 && stsavan === 3) {
                                if (parseInt(rr.MAQUILA) === 98) {
                                    Fraccion.val(113);
                                    FraccionS[0].selectize.setValue(113);
                                } else {
                                    Empleado.focus().select();
                                }
                            }
                            if (xDepartamento === 4 && stsavan === 33) {
                                if (parseInt(rr.MAQUILA) === 98) {
                                    Fraccion.val(114);
                                    FraccionS[0].selectize.setValue(114);
                                } else {
                                    Fraccion.val(103);
                                    FraccionS[0].selectize.setValue(103);
                                }
                            }
                            if (xDepartamento === 40 && stsavan === 4) {
                                Fraccion.val(60);
                                FraccionS[0].selectize.setValue(60);
                                onEnable(btnAceptar);
                            }
                            if (xDepartamento === 33 && stsavan === 4) {
                                Fraccion.val(103);
                                FraccionS[0].selectize.setValue(103);
                                onEnable(btnAceptar);
                                if (parseInt(rr.MAQUILA) === 98) {
                                    Fraccion.val(114);
                                    FraccionS[0].selectize.setValue(114);
                                }
                            }
                            if (xDepartamento === 44 && stsavan === 40) {
                                Fraccion.val(60);
                                FraccionS[0].selectize.setValue(60);
                            }
                            /*GUSTAVO*/
                            if (xDepartamento === 42 && stsavan === 40) {
                                Fraccion.val('');
                                onClear(FraccionS);
                                ProcesoMaquila.focus().select();
                                onEnable(btnAceptar);
                            }
                            if (xDepartamento === 44 && stsavan === 42) {
                                Empleado.focus().select();
                                onEnable(btnAceptar);
                            }
                            if (xDepartamento === 5 && stsavan === 44) {
                                Empleado.focus().select();
                                onEnable(btnAceptar);
                            }
//                            if (xDepartamento === 5 && stsavan === 42) {
//                                Empleado.focus().select();
                            //                                onEnable(btnAceptar);
                            //                            }
                            if (xDepartamento === 55 && stsavan === 5) {
                                Empleado.focus().select();
                                if (parseInt(rr.MAQUILA) === 98) {
                                    Fraccion.val(299);
                                    FraccionS[0].selectize.setValue(299);
                                }
                            }
                            if (xDepartamento === 6 && stsavan === 55) {
                                switch (mono) {
                                    case "JUAN":
                                        Empleado.val(1003);
                                        EmpleadoS[0].selectize.setValue(1003);
                                        EmpleadoS[0].selectize.disable();
                                        break;
                                    default :
                                        Empleado.focus().select();
                                        break;
                                }
                            }
                            if (xDepartamento === 7 && stsavan === 6) {
                                Fraccion.val(401);
                                FraccionS[0].selectize.setValue(401);
                                if (parseInt(rr.MAQUILA) === 98) {
                                    Fraccion.val(402);
                                    FraccionS[0].selectize.setValue(402);
                                }
                            }
                            if (xDepartamento === 8 && stsavan === 7) {
                                Fraccion.val(401);
                                FraccionS[0].selectize.setValue(401);
                                Empleado.focus().select();
                                btnAceptar.attr('disabled', false);
                                btnAceptar.focus();
                                if (parseInt(rr.MAQUILA) === 98) {
                                    Fraccion.val(402);
                                    FraccionS[0].selectize.setValue(402);
                                }
                            }
                            if (xDepartamento === 9 && stsavan === 8) {
                                btnAceptar.attr('disabled', false);
                                btnAceptar.focus();
                            }
                            if (xDepartamento === 10 && stsavan === 9) {
                                Empleado.focus().select();
                                Fraccion.val(500);
                                FraccionS[0].selectize.setValue(500);
                                if (parseInt(rr.MAQUILA) === 98) {
                                    Fraccion.val(499);
                                    FraccionS[0].selectize.setValue(499);
                                }
                            }
                            if (xDepartamento === 11 && stsavan === 10) {
                                Empleado.focus().select();
                                Fraccion.val(600);
                                FraccionS[0].selectize.setValue(600);
                                if (parseInt(rr.MAQUILA) === 98) {
                                    Fraccion.val(601);
                                    FraccionS[0].selectize.setValue(601);
                                }
                            }
                        } else if (parseInt(rr.ESTATUS_PRODUCCION) === 13) {
                            onCampoInvalido(pnlTablero, "ESTE CONTROL YA HA SIDO FACTURADO", 'w', function () {
                                Control.focus().select();
                                btnAceptar.attr('disabled', true);
                            });
                        } else if (parseInt(rr.ESTATUS_PRODUCCION) === 14) {
                            onCampoInvalido(pnlTablero, "ESTE CONTROL HA SIDO CANCELADO", 'w', function () {
                                Control.focus().select();
                                btnAceptar.attr('disabled', true);
                            });
                        }

                        if (parseInt(rr.ESTATUS_PRODUCCION) === 11) {
                            Control.focus().select();
                            btnAceptar.attr('disabled', true);
                            return;
                        }
                        if (parseInt(rr.ESTATUS_PRODUCCION) === 12) {
                            iMsg('ESTE CONTROL YA ESTA FACTURADO', 'w', function () {
                                Control.focus().select();
                                btnAceptar.attr('disabled', true);
                            });
                            return;
                        }
                        if (parseInt(rr.ESTATUS_PRODUCCION) === 13) {
                            iMsg('ESTE CONTROL YA ESTA FACTURADO', 'w', function () {
                                Control.focus().select();
                                btnAceptar.attr('disabled', true);
                                return;
                            });
                        }
                        if (parseInt(rr.ESTATUS_PRODUCCION) === 14) {
                            iMsg('ESTE CONTROL ESTA CANCELADO', 'w', function () {
                                Control.focus().select();
                                btnAceptar.attr('disabled', true);
                                return;
                            });
                        }
                        if (parseInt(rr.MAQUILA) === 98) {
                            onEnable(btnAceptar);
                        }
                    } else {
                        $.getJSON('<?php print base_url('Avance/getInformacionXControlFC') ?>', {CONTROL: Control.val() ? Control.val() : ''}).done(function (a, b, c) {
                            if (a.length > 0) {
                                var rr = a[0];
                                switch (parseInt(rr.ESTATUS_PRODUCCION)) {
                                    case 13:
                                        onCampoInvalido(pnlTablero, "CONTROL FACTURADO", 'w', function () {
                                            Control.focus().select();
                                            onDisable(btnAceptar);
                                        });
                                        break;
                                    case 14:
                                        onCampoInvalido(pnlTablero, "CONTROL CANCELADO", 'w', function () {
                                            Control.focus().select();
                                            onDisable(btnAceptar);
                                        });
                                        break;
                                }
                            }
                        }).fail(function (x) {
                            getError(x);
                        }).always(function () {

                        });
                    }
                }).fail(function (x, y, z) {
                    onCloseOverlay();
                    getError(x);
                }).always(function () {
                    onCloseOverlay();
                    Avances.ajax.reload();
                });
            }
        });
        Fecha.val(getActualDate());
        $.post('<?php print base_url('Avance/getSemanaNomina'); ?>', {
            FECHA: Fecha.val()
        }).done(function (d) {
            var s = JSON.parse(d);
            if (s.length > 0) {
                Semana.val(s[0].SEMANA);
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
        var cols = [
            {"data": "ID"}/*0*/,
            {"data": "EMPLEADO"}/*1*/,
            {"data": "SEMANA"}/*2*/,
            {"data": "FECHA"}/*3*/,
            {"data": "CONTROL"}/*4*/,
            {"data": "MAQUILA"}/*5*/,
            {"data": "ESTILO"}/*6*/,
            {"data": "NUM_FRACCION"}/*7*/,
            {"data": "PRECIO_FRACCION"}/*8*/,
            {"data": "PARES"}/*9*/,
            {"data": "SUBTOTAL"}, /*10*/
            {"data": "MODULO"}/*10*/
        ];
        var coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ];
        var xoptions = {
            "dom": 'rtp',
            "ajax": {
                "url": '<?php print base_url('Avance/getAvancesNomina'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL = Control.val() ? Control.val() : '';
                    d.EMPLEADO = Empleado.val() ? Empleado.val() : '';
                }
            },
            buttons: buttons,
            "columns": cols,
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "498px",
            "scrollX": true,
            "aaSorting": [
                [0, 'desc']
            ],
            "drawCallback": function (settings) {
                var api = this.api();
                var r = 0, prs = 0;
                $.each(api.rows().data(), function (k, v) {
                    prs += parseInt(v.PARES);
                    r += parseFloat(v.SUBTOTAL);
                });
                pnlTablero.find(".total_pares").text(prs);
                pnlTablero.find(".total_fracciones").text("$ " + r.toFixed(3));
            }
        };
        Avances = tblAvance.DataTable(xoptions);
        RastreoXConcepto = tblRastreoXConcepto.DataTable({
            "dom": 'ritp',
            "ajax": {
                "url": '<?php print base_url('Avance/getRastreoXConcepto'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.EMPLEADO = EmpleadoRXC.val() ? EmpleadoRXC.val() : '';
                    d.CONCEPTO = ConceptoRXC.val() ? ConceptoRXC.val() : '';
                }
            },
            buttons: buttons,
            "columns": [
                {"data": "ID"}/*0*/,
                {"data": "SEMANA"}/*1*/,
                {"data": "EMPLEADO"}/*2*/,
                {"data": "CONCEPTO"}/*3*/,
                {"data": "FECHA"}/*4*/,
                {"data": "PER"}/*9*/,
                {"data": "IMPORTE"}/*9*/,
                {"data": "DED"}/*9*/,
                {"data": "SUBTOTAL"}/*10*/
            ],
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "350px",
            "scrollX": true,
            "aaSorting": [
                [0, 'desc']
            ]
        });
        RastreoXControl = tblRastreoXControl.DataTable({
            "dom": 'ritp',
            "ajax": {
                "url": '<?php print base_url('Avance/getRastreoXControl'); ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL = ControlRXCTROL.val() ? ControlRXCTROL.val() : '';
                    d.SEMANA = SemanaRXCTROL.val() ? SemanaRXCTROL.val() : '';
                    d.EMPLEADO = EmpleadoRXCTROL.val() ? EmpleadoRXCTROL.val() : '';
                }
            },
            buttons: buttons,
            "columns": [
                {"data": "ID"}/*0*/,
                {"data": "CONTROL"}/*1*/,
                {"data": "EMPLEADO"}/*2*/,
                {"data": "ESTILO"}/*3*/,
                {"data": "NUM_FRACCION"}/*4*/,
                {"data": "FECHA"}/*5*/,
                {"data": "SEMANA"}/*6*/,
                {"data": "PARES"}/*7*/,
                {"data": "PRECIO_FRACCION"}/*8*/,
                {"data": "SUBTOTAL"}/*10*/
            ],
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "250px",
            "scrollX": true,
            "aaSorting": [
                [0, 'desc']
            ],
            "drawCallback": function (settings) {
                var api = this.api();
                var r = 0, prs = 0;
                $.each(api.rows().data(), function (k, v) {
                    r += parseFloat(v.SUBTOTAL);
                });
                mdlRastreoXControl.find(".total_pesos").text("$ " + r.toFixed(3));
            }
        });
        tblRastreoXControl.find('tbody').on('click', 'tr', function () {
            var row = RastreoXControl.row(this).data();
            console.log(row);
            SemanaRXCTROL.val(row.SEMANA);
            EmpleadoRXCTROL[0].selectize.setValue(row.EMPLEADO);
            $.post('<?php print base_url('Avance/getInfoXControlParaRastreo'); ?>', {
                CONTROL: row.CONTROL,
                FRACCION: row.NUM_FRACCION
            }).done(function (a) {
                console.log(a, a.length);
                if (a.length > 0) {
                    var r = JSON.parse(a);
                    console.log(r);
                    FraccionRXCTROL.val(r[0].FRACCION_DES);
                    AvanceActual.val(r[0].AVANCE_ACTUAL);
                }
            }).fail(function (x) {
                getError(x);
            });
        });
        getConceptosNomina();
    });
    function getPrecioFraccionXEstiloFraccion() {
        console.log(Fraccion.val());
        if (Fraccion.val() && Estilo.val()) {
            $.getJSON('<?php print base_url('Avance/getPrecioFraccionXEstiloFraccion') ?>', {
                ESTILO: Estilo.val() ? Estilo.val() : '', FRACCION: Fraccion.val() ? Fraccion.val() : ''
            }).done(function (a) {
                if (a.length > 0) {
                    console.log(a);
                    PrecioFraccion.val(a[0].COSTO_MO);
                    var frt = Fraccion.find("option:selected").text();
                    frt = frt.replace(Fraccion.val() + ' ', '');
                    DescripcionFraccion.val(frt);
                    btnAceptar.attr('disabled', false);
                } else {
//                    onBeep(5);
//                    swal('ATENCIÓN', 'ESTE ESTILO NO TIENE DEFINIDA LA FRACCION SELECCIONADA', 'warning').then((value) => {
                    //                        PrecioFraccion.val('');
                    //                        Fraccion[0].selectize.open();
                    btnAceptar.attr('disabled', false);
                    //                    });
                }
            }).fail(function (x, y, z) {
                getError(x);
            }).always(function () {
                HoldOn.close();
            });
        }
    }

    function getDeptoActualXControl() {
        if (Control.val()) {
            $.post('<?php print base_url('Avance/getDeptoActual'); ?>',
                    {CONTROL: Control.val()}).done(function (d) {
                var r = JSON.parse(d);
                if (r.length > 0) {
                    var rr = r[0];
                    Estilo.val(rr.ESTILO);
                    DeptoActual.val(rr.DEPTO);
                    AvanceDeptoActual.val(rr.ESTATUS_PRODUCCION);
                    pnlTablero.find(".estatus_de_avance").text(rr.ESTATUS_PRODUCCION_TEXT);

                    Pares.val(rr.PARES);
                    var rta = '<?php print base_url(); ?>' + rr.FOTO;
                    FotoEstilo[0].src = rta;
                    FotoEstilo.parent()[0].href = rta;
                }
            }).fail(function (x, y, z) {
                getError(x);
            }).always(function () {
                HoldOn.close();
            });
        }
    }

    function getDeptosXControl(ctrl) {
        HoldOn.open({
            theme: 'sk-rect',
            message: 'Comprobando...'
        });
        $.post('<?php print base_url('Avance/onComprobarAvanceXControl'); ?>',
                {CONTROL: ctrl.val()}
        ).done(function (data, x, y) {
            var deptos = [10, 20], deptos_del_control = JSON.parse(data), c = 0;
            deptos_del_control.forEach(function (item) {
                if (deptos.indexOf(item.DEPARTAMENTO) === -1) {
                    c += 1;
                }
            });
            if (c < deptos.length) {
                onBeep(2);
                swal('ATENCIÓN', 'EL CONTROL NO CUMPLE CON LOS DEPARTAMENTOS REQUERIDOS 10 CORTE, 20 RAYADO', 'warning').then((value) => {
                    ctrl.focus().select();
                });
            } else if (c === deptos.length) {
                onBeep(5);
                //                swal('ATENCIÓN', 'EL CONTROL CUMPLE CON LOS DEPARTAMENTOS REQUERIDOS, SELECCIONE EL SIGUIENTE DEPARTAMENTO', 'success').then((value) => {

                //                });
            }
            /*
             swal('ATENCIÓN', 'ESTE CONTROL NO HA PASADO POR LOS DEPARTAMENTOS REQUERIDOS','warning').then((value) => {
             });*/
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getActualDate() {
        var d = new Date();
        var day = addZero(d.getDate());
        var month = addZero(d.getMonth() + 1);
        var year = addZero(d.getFullYear());
        return day + "/" + month + "/" + year;
    }

    function addZero(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function getConceptosNomina() {
        $.getJSON('<?php print base_url('Avance/getConceptosNomina'); ?>').done(function (a) {
            //            console.log(a);
            a.forEach(function (e) {
                ConceptoRXC[0].selectize.addOption({text: e.CLAVE + ' ' + e.CONCEPTO, value: e.CLAVE});
            });
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {

        });
    }

    function getDepartamentos() {
        var ul = $("#deptos");
        ul.find("li").click(function () {
            ul.find("li").removeClass('li-selected');
            var li = $(this), deptodes = li.find("span.deptodes").text(), clave = li.find("span.deptoclave").text();
            var depto = parseInt(clave);
            if (depto >= 180 || depto === 30 || depto === 40 ||
                    depto === 90 || depto === 100 || depto === 105 ||
                    depto === 110 || depto === 140 || depto === 150) {
                //                if (Control.val()) {
                li.addClass('li-selected');
                Departamento.val(parseInt(li.find("span").first().text()));
                //                    Departamento[0].selectize.setValue(parseInt(li.find("span").first().text()));
                Control.focus().select();
                getDeptoActualXControl();
                DeptoDes.val(deptodes);
                DeptoAva.val(clave);
                onBeep(3);
//                } else {
//                    swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CONTROL', 'warning').then((value) => {
//                        Control.focus().select();
                //                    });
                //                }
            } else {
                swal('ATENCIÓN', 'DEPARTAMENTO ' + clave + ' INVÁLIDO, SELECCIONE UNO DENTRO DEL RANGO DEPARTAMENTOS DE 180,190,210 o 220', 'warning').then((value) => {
                    ul.find("li").removeClass('li-selected');
                });
            }
            onValidarDepto();
        });
    }

    function onBuscarAvanceXControl() {
        $.getJSON('<?php print base_url('avance_buscar_avance_x_control'); ?>').done(function (dta) {
            console.log(dta);
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {

        });
    }

    function onValidarDepto() {
        var fraccion_x_depto = {
            "33": 102, "4": 103, "40": 60,
            "42": 51, "44": 51, "5": "", "55": 300, "6": 397, "7": "", "8": 401/*ALM-TEJIDO*/, "9": "", "10": 500, "11": 600
        };
        switch (mono) {
            case "X":
                Control.focus().select();
                btnAceptar.attr('disabled', false);
                break;
            case "GUSTAVO":
                switch (parseInt(Departamento.val())) {
                    case 40:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 42:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 44:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 5:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 55:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    default :
                        btnAceptar.attr('disabled', true);
                        Control.val('');
                        ProcesoMaquila.val('');
                        ProcesoMaquilaS[0].selectize.clear(true);
                        Empleado.val('');
                        EmpleadoS[0].selectize.clear(true);
                        Fraccion.val('');
                        FraccionS[0].selectize.clear(true);
                        Estilo.val('');
                        AvanceDeptoActual.val('');
                        Pares.val('');
                        iMsg('EL DEPARTAMENTO NO CONCUERDA CON EL AVANCE DEL USUARIO.', 'w', function () {
                            Departamento.focus().select();
                        });
                        return;
                        break;
                }
                break;
            case "JUAN":
                switch (parseInt(Departamento.val())) {
                    case 6:
                        Empleado.val(1003);
                        EmpleadoS[0].selectize.setValue(1003);
                        EmpleadoS[0].selectize.disable();
                        btnAceptar.attr('disabled', false);
                        break;
                    default :
                        btnAceptar.attr('disabled', true);
                        Control.val('');
                        ProcesoMaquila.val('');
                        ProcesoMaquilaS[0].selectize.clear(true);
                        Empleado.val('');
                        EmpleadoS[0].selectize.clear(true);
                        Fraccion.val('');
                        FraccionS[0].selectize.clear(true);
                        Estilo.val('');
                        AvanceDeptoActual.val('');
                        Pares.val('');
                        iMsg('EL DEPARTAMENTO NO CONCUERDA CON EL AVANCE DEL USUARIO.', 'w', function () {
                            Departamento.focus().select();
                        });
                        return;
                        break;
                }
                break;
            case "JOSE":
                /*JOSE PINA */
                switch (parseInt(Departamento.val())) {
                    case 3:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 33:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 4:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 40:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 42:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 44:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    default :
                        btnAceptar.attr('disabled', true);
                        Control.val('');
                        ProcesoMaquila.val('');
                        ProcesoMaquilaS[0].selectize.clear(true);
                        Empleado.val('');
                        EmpleadoS[0].selectize.clear(true);
                        Fraccion.val('');
                        FraccionS[0].selectize.clear(true);
                        Estilo.val('');
                        AvanceDeptoActual.val('');
                        Pares.val('');
                        iMsg('EL DEPARTAMENTO NO CONCUERDA CON EL AVANCE DEL USUARIO.', 'w', function () {
                            Departamento.focus().select();
                        });
                        return;
                        break;
                }
                break;
            case "CHEOK":
                switch (parseInt(Departamento.val())) {
                    case 44:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 5:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 55:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 6:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 7:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 8:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 9:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    default :
                        btnAceptar.attr('disabled', true);
                        Control.val('');
                        ProcesoMaquila.val('');
                        ProcesoMaquilaS[0].selectize.clear(true);
                        Empleado.val('');
                        EmpleadoS[0].selectize.clear(true);
                        Fraccion.val('');
                        FraccionS[0].selectize.clear(true);
                        Estilo.val('');
                        AvanceDeptoActual.val('');
                        Pares.val('');
                        iMsg('EL DEPARTAMENTO NO CONCUERDA CON EL AVANCE DEL USUARIO.', 'w', function () {
                            Departamento.focus().select();
                        });
                        return;
                        break;
                }
                break;
            case "ALICIA":
                switch (parseInt(Departamento.val())) {
                    case 7:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    default :
                        btnAceptar.attr('disabled', true);
                        Control.val('');
                        ProcesoMaquila.val('');
                        ProcesoMaquilaS[0].selectize.clear(true);
                        Empleado.val('');
                        EmpleadoS[0].selectize.clear(true);
                        Fraccion.val('');
                        FraccionS[0].selectize.clear(true);
                        Estilo.val('');
                        AvanceDeptoActual.val('');
                        Pares.val('');
                        iMsg('EL DEPARTAMENTO NO CONCUERDA CON EL AVANCE DEL USUARIO.', 'w', function () {
                            Departamento.focus().select();
                        });
                        return;
                        break;
                }
                break;
            case "MARTIN":
                switch (parseInt(Departamento.val())) {
                    case 9:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 10:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    case 11:
                        Control.focus().select();
                        btnAceptar.attr('disabled', false);
                        break;
                    default :
                        btnAceptar.attr('disabled', true);
                        Control.val('');
                        ProcesoMaquila.val('');
                        ProcesoMaquilaS[0].selectize.clear(true);
                        Empleado.val('');
                        EmpleadoS[0].selectize.clear(true);
                        Fraccion.val('');
                        FraccionS[0].selectize.clear(true);
                        Estilo.val('');
                        AvanceDeptoActual.val('');
                        Pares.val('');
                        iMsg('EL DEPARTAMENTO NO CONCUERDA CON EL AVANCE DEL USUARIO.', 'w', function () {
                            Departamento.focus().select();
                        });
                        return;
                        break;
                }
                break;
            default:
                btnAceptar.attr('disabled', true);
                Control.val('');
                ProcesoMaquila.val('');
                ProcesoMaquilaS[0].selectize.clear(true);
                Empleado.val('');
                EmpleadoS[0].selectize.clear(true);
                Fraccion.val('');
                FraccionS[0].selectize.clear(true);
                Estilo.val('');
                AvanceDeptoActual.val('');
                Pares.val('');
                iMsg('EL USUARIO NO CONCUERDA CON EL AVANCE', 'w', function () {
                    Departamento.focus().select();
                });
                return;
                break;
        }
        Fraccion.val(fraccion_x_depto[Departamento.val()]);
        FraccionS[0].selectize.setValue(Fraccion.val());
        getPrecioFraccionXEstiloFraccion();
        var dptos = pnlTablero.find("ul#deptos li"), depto = 0, clve = 0, deptodes = "";
        pnlTablero.find("ul#deptos li").removeClass("li-selected");
        $.each(dptos, function (k, v) {
            //                    console.log(k, v);
            var spn = $(v).find("span.stsavan").text();
            clve = $.isNumeric(spn) ? parseInt(spn) : 0;
            var cu_clve = parseInt(Departamento.val());
            if (clve === cu_clve) {
                $(v).addClass("li-selected");
                depto = parseInt($(v).find("span.deptoclave").text());
                deptodes = $(v).find("span.deptodes").text();
                return false;
            }
        });
        if (depto >= 180 || depto === 30 || depto === 40 ||
                depto === 90 || depto === 100 || depto === 105 ||
                depto === 110 || depto === 130 || depto === 140 || depto === 150 || depto === 160) {
            //                    Departamento.val(parseInt(li.find("span").first().text())); 
            Control.focus().select();
            DeptoDes.val(deptodes);
            DeptoAva.val(clve);
            onBeep(3);
        } else {
            swal('ATENCIÓN', 'DEPARTAMENTO ' + Departamento.val() + ' INVÁLIDO, SELECCIONE UNO DENTRO DEL RANGO DEPARTAMENTOS DE 180,190,210 o 220', 'warning').then((value) => {
                Departamento.focus().select();
            });
        }

    }
</script>
<style>

    #tblFraccionesPagadasFail tbody tr td:nth-child(8),#tblFraccionesPagadasFail tbody tr td:nth-child(10) { 
        color:#008000;
    }
    #tblFraccionesPagadasFail tbody tr td:nth-child(9) { 
        color:#3f51b5;
    }

    #tblFraccionesPagadasFail tbody tr td{ 
        font-size: 14px;
        font-weight: bold;
    }

    #tblAvance tbody tr td{
        font-size: 14px;
    }
    #tblAvance tbody tr td:nth-child(9) { 
        font-weight: bold;
        color:#3f51b5;
    }
    #tblAvance tbody tr td:nth-child(4) { 
        font-weight: bold;
    }
    #tblAvance tbody tr td:nth-child(9) { 
        font-weight: bold;
        color:#3f51b5;
    }
    #tblAvance tbody tr td:nth-child(8),#tblAvance tbody tr td:nth-child(10) { 
        font-weight: bold;
        color:#008000;
    }

    .fracciones_avance{
        color: #ef1000; 
        font-weight: bold;
    }
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid;
        border-image: linear-gradient(to bottom,  #2196F3, #cc0066, rgb(0,0,0,0)) 1 100% ;
        /*top
        background-image: linear-gradient(to left, #0099cc,  #cc0000, #0099cc) ;
        background-size: 100% 1px;
        background-position: 10% 0%, 0% 100%;
        background-repeat: no-repeat;  */
    }
    li.list-group-item {
        padding-top: 3px;
        padding-bottom: 3px;
    }
    li.list-group-item:hover {
        font-weight: bold;
        color: #fff;
        cursor: pointer;
        background-color: #3f51b5;
        -webkit-box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        -moz-box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        padding-top: 3px;
        padding-bottom: 3px;
        animation: myfirst .4s;
        -moz-animation:myfirst 1.4s infinite; /* Firefox */
        -webkit-animation:myfirst 1.4s infinite; /* Safari and Chrome */
        border-radius: 5px;
    }
    .li-selected{
        font-weight: bold;
        color: #D32F2F;
        cursor: pointer;
        background-color: #fff;
        padding-top: 3px;
        padding-bottom: 3px;
        border-radius: 0px;
        font-weight: bold;
    }
    .li-selected span.badge-primary{
        font-weight: bold;
        color: #fff;
        background-color: #D32F2F;
        padding-top: 3px;
        padding-bottom: 3px;
    }
    ul.list-group {
        animation: highlight .4s;
        -moz-animation:highlight 1.4s infinite; /* Firefox */
        -webkit-animation:highlight 1.4s infinite; /* Safari and Chrome */
        border-radius: 5px;
    }

    table tbody tr:hover {
        font-weight:normal !important;
    }

    .box-success{
        box-shadow: 0 0 0 0.2rem #CDDC39 !important;
    }

    .box-info{
        box-shadow: 0 0 0 0.2rem #33C2E1 !important;
    }
    ul li{
        font-size: 13px !important;
    }

    .estatus_de_avance{
        font-size: 50px !important; 
        color: #006699;
        color: #cc0033;
    }
    input#Control{
        color: #003366 !important;
    }
    table thead th, label, button,h4{
        text-transform:  uppercase !important;   
    } 

    @-moz-keyframes myfirst /* Firefox */
    {
        0%   {    border: 1px solid #2196F3}
        50%  {    border: 1px solid #6610f2;        font-weight: bold;}
        100%   {border: 1px solid #2196F3}
    }

    @-webkit-keyframes myfirst /* Firefox */
    {
        0%   {    border: 1px solid #2196F3}
        50%  {    border: 1px solid #6610f2;font-weight: bold;}
        100%   {border: 1px solid #2196F3}
    }

    @-moz-keyframes highlight /* Firefox */
    {
        0%   {    border: 1px solid #3F51B5}
        50%  {    border: 1px solid #2196f3;        }
        100%   {border: 1px solid #3F51B5}
    }

    @-webkit-keyframes highlight /* Firefox */
    {
        0%   {    border: 1px solid #3F51B5}
        50%  {    border: 1px solid #2196f3;}
        100%   {border: 1px solid #3F51B5}
    }


    @-moz-keyframes avance_high /* Firefox */
    {
        0%   {    color: #003366;}
        25%   {    color: #006699;}
        50%  {    color: #003366;}
        100%   {color: #006699;}
    }

    @-webkit-keyframes avance_high /* Firefox */
    {
        0%   {    color: #003366;}
        25%   {    color: #006699;}
        50%  {    color: #003366;}
        100%   {color: #006699;}
    }
</style>