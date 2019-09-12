<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-2 float-left">
                <legend class="float-left">Empleados</legend>
            </div>
            <div class="col-sm-5">
                <input type="text" id="NumeroEmpleado" name="NumeroEmpleado" class="form-control form-control-sm noBorders notEnter numbersOnly" autofocus="" placeholder="####">
            </div>
            <div class="col-sm-5 float-right" align="right">
                <button type="button" class="btn btn-primary selectNotEnter" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar"><span class="fa fa-plus"></span><br></button>
                <button type="button" class="btn btn-success selectNotEnter" id="btnVerTodos" data-toggle="tooltip" data-placement="left" title="Ver todos">
                    <span class="fa fa-eye"></span> VER TODOS
                </button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Empleados" class="table-responsive">
                <table id="tblEmpleados" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>No</th>
                            <th>Nombre</th>
                            <th>Dire</th>
                            <th>Col</th>
                            <th>Ciu</th>
                            <th>RFC</th>
                            <th># de seg. social</th>
                            <th>St  </th>
                            <th>Ingreso</th>
                            <th>T-S</th>
                            <th>Depto</th>
                            <th>Salario</th>
                            <th>Cel</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card m-3 d-none animated fadeIn" id="pnlDatos">
    <div class="card-body text-dark">
        <form id="frmNuevo">
            <fieldset>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 float-left">
                        <legend >Empleado</legend>
                    </div>
                    <div class="col-12 col-sm-6 col-md-8" align="right">
                        <div class="card text-white bg-danger mb-2 d-none" id="dMotivoBaja">
                            <div class="card-header">Motivo de Baja: <span id="tMotivoBaja"></span></div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm d-none" id="btnBajaEmpleado" >
                            <span class="fa fa-user-times" ></span> DAR DE BAJA
                        </button>
                        <button type="button" class="btn btn-info btn-sm" id="btnImprimeContrato" >
                            <span class="fa fa-file-pdf" ></span> CONTRATO
                        </button>
                        <button type="button" class="btn btn-foto btn-sm" id="btnCambiarFoto" >
                            <span class="fa fa-images" ></span> CAMBIAR FOTO
                        </button>
                        <button type="button" class="btn btn-lobo btn-sm" id="btnCredencial" >
                            <span class="fa fa-id-card" ></span> CREDENCIAL
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                            <span class="fa fa-arrow-left" ></span> REGRESAR
                        </button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-7">

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active show" data-toggle="tab" href="#datos">Datos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#perfil">Perfil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#nomina">Nomina</a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <!--DATOS-->
                            <div class="tab-pane fade active show" id="datos">
                                <div class="row">
                                    <div class="d-none">
                                        <input type="text"  name="ID" class="form-control form-control-sm" >
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                        <label for="Numero" >Número*</label>
                                        <input type="text" class="form-control form-control-sm" id="Numero" name="Numero" required autofocus="">
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                        <label for="NumFis" >N-fis*</label>
                                        <input type="text" class="form-control form-control-sm" id="NumFis" name="NumFis" required >
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-2 col-xl-2 mt-4" align="center">
                                        <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                                            <input type="checkbox" class="custom-control-input selectNotEnter" id="Egresos" name="Egresos" style="cursor: pointer !important;">
                                            <label class="custom-control-label text-danger labelCheck" for="Egresos" style="cursor: pointer !important;">Egresos</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-2 col-xl-2 mt-4" align="center">
                                        <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                                            <input type="checkbox" class="custom-control-input selectNotEnter" id="Activos" name="Activos" style="cursor: pointer !important;">
                                            <label class="custom-control-label text-danger labelCheck" for="Activos" style="cursor: pointer !important;">Activos</label>
                                        </div>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <label for="PrimerNombre" >1er Nombre*</label>
                                        <input type="text" id="PrimerNombre" name="PrimerNombre" class="form-control form-control-sm" placeholder="" required="">
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <label for="SegundoNombre" >2do Nombre*</label>
                                        <input type="text" id="SegundoNombre" name="SegundoNombre" class="form-control form-control-sm" placeholder="" >
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <label for="Paterno" >Paterno*</label>
                                        <input type="text" id="Paterno" name="Paterno" class="form-control form-control-sm" placeholder="" required="">
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <label for="Materno" >Materno*</label>
                                        <input type="text" id="Materno" name="Materno" class="form-control form-control-sm" placeholder="" required="">
                                    </div>
                                    <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                        <label for="Direccion" >Dirección*</label>
                                        <input type="text" id="Direccion" name="Direccion"  class="form-control form-control-sm" placeholder="" required="">
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <label for="Colonia" >Colonia*</label>
                                        <input type="text" id="Colonia" name="Colonia" class="form-control form-control-sm" placeholder="" required="">
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                                        <label for="Ciudad" >Ciudad*</label>
                                        <input type="text" id="Ciudad" name="Ciudad"  class="form-control form-control-sm" placeholder="" required="">
                                    </div>
                                    <div class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                                        <label for="Estado" >Estado*</label>
                                        <select id="Estado" name="Estado" class="form-control form-control-sm">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="CP" >C.P.*</label>
                                        <input type="text" id="CP" name="CP"  class="form-control form-control-sm numbersOnly" placeholder="" >
                                    </div>

                                    <div class="w-100"></div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <label for="RFC" >R.F.C.*</label>
                                        <input type="text" id="RFC" name="RFC"  class="form-control form-control-sm" placeholder="" >
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <label for="CURP" >CURP*</label>
                                        <input type="text" id="CURP" name="CURP"  class="form-control form-control-sm" placeholder="" >
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                        <label for="NoIMSS" >No.IMSS*</label>
                                        <input type="text" id="NoIMSS" name="NoIMSS"  class="form-control form-control-sm" placeholder="" required="">
                                        <div class="custom-control custom-checkbox mt-2"  align="center" style="cursor: pointer !important;">
                                            <input type="checkbox" class="custom-control-input selectNotEnter" id="Incapacitado" name="Incapacitado" style="cursor: pointer !important;">
                                            <label class="custom-control-label text-danger labelCheck" for="Incapacitado" style="cursor: pointer !important;">Incapacitado</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                        <label for="FechaIngreso" >Fecha Ingreso*</label>
                                        <input type="text" id="FechaIngreso" name="FechaIngreso"  class="form-control form-control-sm date notEnter" placeholder="" >
                                    </div>
                                    <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                        <label for="Nacimiento" >Nacimiento*</label>
                                        <input type="text" id="Nacimiento" name="Nacimiento"  class="form-control form-control-sm date notEnter" placeholder="" >
                                    </div>
                                    <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                        <label for="FechaIMSS" >Fecha IMSS*</label>
                                        <input type="text" id="FechaIMSS" name="FechaIMSS"  class="form-control form-control-sm date notEnter" placeholder="" >
                                    </div>
                                    <div class="w-100"></div>

                                    <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8 d-none" id="dIncapacidad">
                                        <div class="card text-white bg-info ml-3" >
                                            <div class="card-header">Capture el periodo de incapacidad</div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                        <label for="FeIniInc" >Fecha Inicio</label>
                                                        <input type="text" id="FechaIncapacidad" name="FechaIncapacidad"  class="form-control form-control-sm date notEnter">
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                        <label for="FeIniInc" >Fecha Fin</label>
                                                        <input type="text" id="FechaIncapacidadFin" name="FechaIncapacidadFin"  class="form-control form-control-sm date notEnter">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-100"></div>
                                    <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                        <label for="Sexo" >Sexo*</label>
                                        <select id="Sexo" name="Sexo"  class="form-control form-control-sm" placeholder="" >
                                            <option></option>
                                            <option value="M">M</option>
                                            <option value="F">F</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                        <label for="EstadoCivil" >Edo.Civil*</label>
                                        <input type="text" id="EstadoCivil" name="EstadoCivil"  class="form-control form-control-sm" placeholder="" >
                                    </div>
                                    <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                        <label for="Tel" >Tel*</label>
                                        <input type="tel" id="Tel" name="Tel"  class="form-control form-control-sm numbersOnly" placeholder="" >
                                    </div>
                                    <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                        <label for="Cel" >Tel.Cel*</label>
                                        <input type="tel" id="Cel" name="Cel"  class="form-control form-control-sm numbersOnly notEnter" placeholder="" onfocus="" >
                                    </div>
                                </div>
                            </div>
                            <!--FIN DATOS-->
                            <!--PERFIL-->
                            <div class="tab-pane fade" id="perfil">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <label>Departamento*</label>
                                        <select id="DepartamentoFisico" name="DepartamentoFisico" class="form-control form-control-sm" required="">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-12 col-sm-4col-md-4 col-lg-4 col-xl-4">
                                        <label for="AltaBaja" >Alta/Baja*</label>
                                        <select id="AltaBaja" name="AltaBaja" class="form-control form-control-sm">
                                            <option value="1">1 Alta</option>
                                            <option value="2">2 Baja</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <label for="Puesto" >Puesto*</label>
                                        <input type="text" class="form-control form-control-sm" id="Puesto" name="Puesto" required >
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <label for="Tarjeta" >C/Tarj | S/Tarj*</label>
                                        <select id="Tarjeta" name="Tarjeta" class="form-control form-control-sm">
                                            <option value="1">1 C/Tarj</option>
                                            <option value="2">2 S/Tarj</option>
                                        </select>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="Egreso" >Egreso*</label>
                                        <input type="text" id="Egreso" name="Egreso" class="form-control form-control-sm date notEnter" required="">
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="Comedor" >Comedor*</label>
                                        <select id="Comedor" name="Comedor" class="form-control form-control-sm">
                                            <option value="1">1 Si</option>
                                            <option value="2">2 No</option>
                                        </select>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <label for="TBanamex" >T.Banamex*</label>
                                        <input type="text" id="TBanamex" name="TBanamex" class="form-control form-control-sm numbersOnly">
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <label for="TBanbajio" >Tarj.BB*</label>
                                        <input type="text" id="TBanbajio" name="TBanbajio" class="form-control form-control-sm numbersOnly">
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <label for="FijoDestajoAmbos" >Fijo/Destajo/Ambos*</label>
                                        <select id="FijoDestajoAmbos" name="FijoDestajoAmbos" class="form-control form-control-sm">
                                            <option value="1">1 Fijo</option>
                                            <option value="2">2 Destajo</option>
                                            <option value="3">3 Ambos</option>
                                        </select>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                        <label for="CuentaBB" >Cta-BB*</label>
                                        <input type="text" id="CuentaBB" name="CuentaBB" class="form-control form-control-sm numbersOnly">
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <label for="Beneficiario" >Beneficiario*</label>
                                        <input type="text" id="Beneficiario" name="Beneficiario" class="form-control form-control-sm" required="">
                                    </div>
                                    <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                        <label for="Parentesco" >Parentesco*</label>
                                        <input type="text" id="Parentesco" name="Parentesco" class="form-control form-control-sm" required="">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="Porcentaje" >%*</label>
                                        <input type="text" id="Porcentaje" name="Porcentaje" class="form-control form-control-sm numbersOnly" required="">
                                    </div>
                                </div>
                            </div>
                            <!--FIN PERFIL-->
                            <!--NOMINA-->
                            <div class="tab-pane fade" id="nomina">
                                <div class="row">
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="Sueldo" >Sueldo*</label>
                                        <input type="text" id="Sueldo" name="Sueldo" class="form-control form-control-sm numbersOnly" required="">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="IMSS" >I.M.S.S*</label>
                                        <input type="text" id="IMSS" name="IMSS" class="form-control form-control-sm numbersOnly" required="">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="Fierabono" >Fierabono*</label>
                                        <input type="text" id="Fierabono" name="Fierabono" class="form-control form-control-sm numbersOnly">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="Infonavit" >Infonavit*</label>
                                        <input type="text" id="Infonavit" name="Infonavit" class="form-control form-control-sm numbersOnly" required="">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="Ahorro" >Ahorro*</label>
                                        <input type="text" id="Ahorro" name="Ahorro" class="form-control form-control-sm numbersOnly">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="PressAcum" >Press Acum</label>
                                        <input type="text" id="PressAcum" name="PressAcum" class="form-control form-control-sm numbersOnly" readonly="">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="AbonoPres" >Abono Pres</label>
                                        <input type="text" id="AbonoPres" name="AbonoPres" class="form-control form-control-sm numbersOnly">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="SaldoPres" >Saldo Pres.</label>
                                        <input type="text" id="SaldoPres" name="SaldoPres" class="form-control form-control-sm numbersOnly" readonly="">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="Comida" >Comida*</label>
                                        <input type="text" id="Comida" name="Comida" class="form-control form-control-sm numbersOnly" required="">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="Celula" >Celula*</label>
                                        <input type="text" id="Celula" name="Celula" class="form-control form-control-sm numbersOnly" required="">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="CelulaPorcentaje" >% Celula*</label>
                                        <input type="text" id="CelulaPorcentaje" name="CelulaPorcentaje" class="form-control form-control-sm numbersOnly" required="">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="Funeral" >Funeral*</label>
                                        <input type="text" id="Funeral" name="Funeral" class="form-control form-control-sm numbersOnly" >
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="SueldoFijo" >Sueldo Fijo*</label>
                                        <input type="text" id="SueldoFijo" name="SueldoFijo" class="form-control form-control-sm numbersOnly" required="">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="SalarioDiarioIMSS" >Sueldo Diario I.M.S.S.*</label>
                                        <input type="text" id="SalarioDiarioIMSS" name="SalarioDiarioIMSS" class="form-control form-control-sm numbersOnly" required="">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="ZapatosTDA" >Zapatos tda*</label>
                                        <input type="text" id="ZapatosTDA" name="ZapatosTDA" class="form-control form-control-sm numbersOnly">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="AbonoZap" >Abono zap*</label>
                                        <input type="text" id="AbonoZap" name="AbonoZap" class="form-control form-control-sm numbersOnly">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label for="Fonacot" >Fonacot*</label>
                                        <input type="text" id="Fonacot" name="Fonacot" class="form-control form-control-sm numbersOnly">
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <label for="EntregaDeMaterialYPrecio" >Entrega de material y precio*</label>
                                        <input type="text" id="EntregaDeMaterialYPrecio" name="EntregaDeMaterialYPrecio" class="form-control form-control-sm numbersOnly" required="">
                                    </div>
                                </div>
                            </div>
                            <!--FIN NOMINA-->
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5" align="center">
                        <img id="FotoPerfil" src="<?php print base_url('img/empleado_sin_foto.png'); ?>" class="img-fluid" style="cursor: pointer;"
                             onclick="onCambiarImagen(this)">
                        <input type="file" id="Foto" name="Foto" class="d-none">
                    </div>
                    <div class="row pt-2 pl-3">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <h6 class="text-danger">Los campos con * son obligatorios</h6>
                        </div>
                        <button type="button" class="btn btn-info btn-lg btn-float" id="btnGuardar" data-toggle="tooltip" data-placement="left" title="Guardar">
                            <i class="fa fa-save"></i>
                        </button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/Empleados/';
    var btnNuevo = $("#btnNuevo"), btnVerTodos = $("#btnVerTodos"),
            btnCancelar = $("#btnCancelar"), btnGuardar = $("#btnGuardar"),
            pnlTablero = $("#pnlTablero"), pnlDatos = $("#pnlDatos"),
            tblEmpleados = $("#tblEmpleados"), Empleados, Foto = $("#Foto"),
            FotoPerfil = $("#FotoPerfil"), btnCredencial = $("#btnCredencial"),
            btnCambiarFoto = $("#btnCambiarFoto"), btnImprimeContrato = $("#btnImprimeContrato"),
            btnBajaEmpleado = $("#btnBajaEmpleado"),
            NumeroEmpleado = pnlTablero.find("#NumeroEmpleado"), nuevo = false, tfoto,
            numeroEmp = 0, prestamo, zaptda;

    $(document).ready(function () {
        handleEnter();
        getRecords(1);
        getEstados();
        getDepartamentos();
        pnlTablero.find("#tblEmpleados_filter").find('input[type="search"]').addClass('selectNotEnter');
        NumeroEmpleado.unbind();
        NumeroEmpleado.on('keydown keyup', function (e) {
            onBuscar($(this).val(), e, tblEmpleados, Empleados, $(this), 1);
        });
        btnVerTodos.click(function () {
            getRecords(2);
        });

        btnBajaEmpleado.click(function () {
            if (zaptda > 0 && prestamo > 0) {
                swal('ATENCIÓN', 'USUARIO CON PRÉSTAMO O CARGO DE ZAPATOS, IMPOSIBLE DAR DE BAJA', 'error');
            } else {
                swal({
                    buttons: ["Cancelar", "Aceptar"],
                    title: 'Estás Seguro?',
                    text: "Esta acción no se puede revertir",
                    icon: "warning",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {
                        $('#mdlBajaEmpleado').modal('show');
                    }
                });
            }
        });

        btnCambiarFoto.click(function () {
            FotoPerfil.trigger('click');
        });

        btnImprimeContrato.click(function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData();
            frm.append('Empleado', pnlDatos.find('#Numero').val());
            $.ajax({
                url: base_url + 'index.php/ReportesNominaJasper/onImprimirContrato',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length !== '0') {

                    $.fancybox.open({
                        src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
                        type: 'iframe',
                        opts: {
                            afterShow: function (instance, current) {
                                console.info('done!');
                            },
                            iframe: {
                                // Iframe template
                                tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                                preload: true,
                                // Custom CSS styling for iframe wrapping element
                                // You can use this to set custom iframe dimensions
                                css: {
                                    width: "100%",
                                    height: "100%"
                                },
                                // Iframe tag attributes
                                attr: {
                                    scrolling: "auto"
                                }
                            }
                        }
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        btnImprimeContrato.focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        btnCredencial.click(function () {
            getCredencial();
        });


        pnlDatos.find("#Incapacitado").change(function () {
            if ($("#pnlDatos").find("#Incapacitado")[0].checked) {
                pnlDatos.find("#dIncapacidad").removeClass('d-none');
                pnlDatos.find('#FechaIncapacidad').focus().select();
            } else {
                pnlDatos.find("#dIncapacidad").addClass('d-none');
                pnlDatos.find('#FechaIngreso').focus().select();
            }
        });

        pnlDatos.find("#Cel").keydown(function (e) {
            if (e.keyCode === 13) {
                $('.nav-tabs li:eq(1) a').tab('show');
            }
        });

        pnlDatos.find("#Porcentaje").keydown(function (e) {
            if (e.keyCode === 13) {
                $('.nav-tabs li:eq(2) a').tab('show');
            }
        });

        $('.nav-tabs a').on('shown.bs.tab', function (event) {
            var cur_tab = $(event.target).text()/*TAB ACTUAL*/, before_tab = $(event.relatedTarget).text()/*TAB ANTERIOR*/;
            switch (cur_tab) {
                case 'Datos':
                    pnlDatos.find("#Numero").focus();
                    break;
                case 'Perfil':
                    pnlDatos.find("#DepartamentoFisico")[0].selectize.focus();
                    break;
                case 'Nomina':
                    pnlDatos.find("#Sueldo").focus();
                    break;
            }
        });

        Foto.change(function () {
            var imageType = /image.*/;
            if (Foto[0].files[0] !== undefined && Foto[0].files[0].type.match(imageType)) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    FotoPerfil[0].src = reader.result;
                };
                reader.readAsDataURL(Foto[0].files[0]);
                tfoto = true;
            } else {
                swal('ATENCIÓN', 'EL ELEMENTO TIENE QUE SER UNA IMAGEN.', 'warning');
                tfoto = false;
            }
        });

        btnGuardar.click(function () {
            //console.log('guardando...');
            if (tfoto) {
                isValid('pnlDatos');
                if (valido) {
                    var frm = new FormData(pnlDatos.find("#frmNuevo")[0]);
                    frm.append('Incapacitado', pnlDatos.find("#Incapacitado")[0].checked ? 1 : 0);
                    frm.append('Egresos', pnlDatos.find("#Egresos")[0].checked ? 1 : 0);
                    frm.append('Activos', pnlDatos.find("#Activos")[0].checked ? 1 : 0);
                    if (!nuevo) {
                        $.ajax({
                            url: master_url + 'onModificar',
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: frm
                        }).done(function (data, x, jq) {
                            //console.log(data);
                            onBeep(1);
                            swal('ATENCIÓN', 'SE HAN GUARDADO LOS CAMBIOS', 'success');
                            nuevo = false;
                            Empleados.ajax.reload();
                            pnlDatos.addClass("d-none");
                            pnlTablero.removeClass("d-none");
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        }).always(function () {
                            HoldOn.close();
                        });
                    } else {
                        $.ajax({
                            url: master_url + 'onAgregar',
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: frm
                        }).done(function (data, x, jq) {
                            //console.log(data);
                            pnlDatos.find("[name='ID']").val(data);
                            nuevo = false;
                            Empleados.ajax.reload();
                            swal({
                                title: "ATENCIÓN",
                                text: "EMPLEADO GUARDADO",
                                icon: "success",
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                                buttons: false,
                                timer: 1200
                            }).then((action) => {
                            });
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        }).always(function () {
                            HoldOn.close();
                        });
                    }
                } else {
                    onBeep(2);
                    swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error').then((value) => {
                        $('.nav-tabs li:eq(0) a').tab('show');
                    });
                }
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBE DE CARGAR UNA FOTOFRAFÍA DEL EMPLEADO ",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    Foto.focus();
                });
            }
        });

        btnCancelar.click(function () {
            FotoPerfil[0].src = '<?php print base_url('img/empleado_sin_foto.png'); ?>';
            $('.nav-tabs li:eq(0) a').tab('show');
            pnlTablero.toggleClass('d-none');
            pnlDatos.toggleClass('d-none');
            btnCredencial.addClass("d-none");
            NumeroEmpleado.focus().select();

        });

        btnNuevo.click(function () {
            btnCredencial.addClass("d-none");
            FotoPerfil[0].src = '<?php print base_url('img/empleado_sin_foto.png'); ?>';
            nuevo = true;
            tfoto = false;
            pnlDatos.find("input").val("");
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
            $.each(pnlDatos.find("input[type='checkbox']"), function (k, v) {
                $(v)[0].checked = false;
            });
            pnlTablero.addClass('d-none');
            pnlDatos.removeClass('d-none');


            $.getJSON(master_url + 'getUltimo').done(function (data, x, jq) {
                if (data.length > 0) {
                    var Numero = $.isNumeric(data[0].Numero) ? parseInt(data[0].Numero) + 1 : 1;
                    pnlDatos.find("#Numero").val(Numero);
                } else {
                    pnlDatos.find("#Numero").val('1');
                }
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            });
            btnBajaEmpleado.addClass('d-none');
            pnlDatos.find('#dMotivoBaja').addClass('d-none');
            pnlDatos.find("#Numero").focus().select();


        });
    });


    function getRecords(altabaja) {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblEmpleados')) {
            tblEmpleados.DataTable().destroy();
        }
        Empleados = tblEmpleados.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "dataType": "json",
                "type": 'GET',
                "data": {Estatus: altabaja}
            },
            "columns": [
                {"data": "ID"}, {"data": "No"}, {"data": "Nombre"}, {"data": "Dire"}, {"data": "Col"},
                {"data": "Ciu"}, {"data": "RFC"}, {"data": "Seg"}, {"data": "FijoDestajoAmbos"}, {"data": "FechaIngreso"},
                {"data": "FijoDestajoAmbos"}, {"data": "DepartamentoFisico"}, {"data": "SaldoPres"}, {"data": "Celula"}, {"data": "CelulaPorcentaje"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 20,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [1, 'desc']/*ID*/
            ],
            initComplete: function (a, b) {
                HoldOn.close();
                NumeroEmpleado.focus();
            }
        });

        tblEmpleados.find('tbody').on('click', 'tr', function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'CARGANDO...'
            });
            nuevo = false;
            tblEmpleados.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Empleados.row(this).data();
            temp = parseInt(dtm.ID);

            FotoPerfil[0].src = '<?php print base_url('img/empleado_sin_foto.png'); ?>';
            pnlDatos.find("input").val("");
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
            $.each(pnlDatos.find("input[type='checkbox']"), function (k, v) {
                $(v)[0].checked = false;
            });
            getEmpleadoByID(temp);
        });

    }

    function getEmpleadoByID(XXX) {
        $.getJSON(master_url + 'getEmpleadoByID', {ID: XXX}).done(function (data) {
            nuevo = false;
            //console.log(data);
            var dtm = data[0];
            numeroEmp = parseInt(dtm.Numero);
            zaptda = data[0].ZapatosTDA;
            prestamo = data[0].SaldoPres;
            pnlDatos.find("input").val("");
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });

            /*Si es baja puede consultar*/
            if (data[0].AltaBaja === '1') {
                btnBajaEmpleado.removeClass('d-none');
                btnGuardar.removeClass('d-none');
                btnImprimeContrato.removeClass('d-none');
                btnCredencial.removeClass('d-none');
                pnlDatos.find('#dMotivoBaja').addClass('d-none');
            } else {
                btnGuardar.addClass('d-none');
                btnImprimeContrato.addClass('d-none');
                btnCredencial.addClass('d-none');
                btnBajaEmpleado.addClass('d-none');
                pnlDatos.find('#dMotivoBaja').removeClass('d-none');
                pnlDatos.find('#tMotivoBaja').html(data[0].MotivoBaja);
            }

            $.each(data[0], function (k, v) {
                pnlDatos.find("[name='" + k + "']").val(v);
                if (pnlDatos.find("[name='" + k + "']").is('select')) {
                    pnlDatos.find("[name='" + k + "']")[0].selectize.addItem(v, true);
                }
                if (pnlDatos.find("[name='" + k + "']").is(':checkbox')) {
                    if (v !== null && v !== 'null') {
                        pnlDatos.find("[name='" + k + "']")[0].checked = parseInt(v);
                    }
                }
            });
            var ext = getExt(dtm.FOTOEMPLEADO);
            $.ajax({
                url: base_url + dtm.FOTOEMPLEADO,
                type: 'HEAD',
                error: function ()
                {
                    FotoPerfil[0].src = '<?php print base_url('img/empleado_sin_foto.png'); ?>';
                    tfoto = false;
                },
                success: function ()
                {
                    if (ext === "gif" || ext === "jpg" || ext === "png" || ext === "jpeg" || ext === "GIF") {
                        FotoPerfil[0].src = base_url + dtm.FOTOEMPLEADO;
                        tfoto = true;
                    } else {
                        tfoto = false;
                        FotoPerfil[0].src = '<?php print base_url('img/empleado_sin_foto.png'); ?>';
                    }
                }
            });



            pnlTablero.addClass("d-none");
            pnlDatos.removeClass('d-none');
            btnCredencial.removeClass("d-none");
        }).fail(function (x, y, z) {
            onBeep(2);
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        }).always(function () {
            HoldOn.close();
            $('.nav-tabs li:eq(0) a').tab('show');
        });
    }

    function onCambiarImagen(e) {
        Foto.trigger('click');
        Foto.attr("type", "file");
        Foto.val('');
    }


    function getEstados() {
        $.getJSON(master_url + 'getEstados').done(function (data) {
            $.each(data, function (k, v) {
                pnlDatos.find("#Estado")[0].selectize.addOption({text: v.Estado, value: v.ID});
            });
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getDepartamentos() {
        $.getJSON(master_url + 'getDepartamentos').done(function (data) {
            $.each(data, function (k, v) {
                pnlDatos.find("#DepartamentoFisico")[0].selectize.addOption({text: v.Departamento, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getCredencial() {
        $.getJSON(master_url + 'getCredencial', {ID: $("#Numero").val()}).done(function (data, x, jq) {
            $.fancybox.open({
                src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data.URL + '#pagemode=thumbs',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
                        console.info('done!');
                    },
                    iframe: {
                        // Iframe template
                        tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                        preload: true,
                        // Custom CSS styling for iframe wrapping element
                        // You can use this to set custom iframe dimensions
                        css: {
                            width: "80%",
                            height: "50%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        }
        ).fail(function (x, y, z) {
            console.log(x.responseText);
            swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'error');
        });
    }

    function onBuscar(search_value, evt, tbl, objeto, input, index_column) {
        tbl.DataTable().column(index_column).search(search_value).draw();
        if (evt.keyCode === 13) {
            HoldOn.open({
                theme: 'sk-rect',
                message: 'Buscando...'
            });
            tbl.DataTable().column(index_column).search("^" + search_value + "$", true, false, true).draw();
            var row_count = objeto.page.info().recordsDisplay;
            if (row_count > 0) {
                var EX = 0;
                $.each(tbl.find("tbody > tr"), function (k, v) {
                    var row = objeto.row($(this)).data();
                    EX = row.ID;
                    return false;
                });
                getEmpleadoByID(EX);
            } else {
                input.focus().select();
            }
        } else {
            if (input.val().length <= 0) {
                tbl.DataTable().column(index_column).search("").draw();
            }
        }
    }
</script>
<style>
    .nav-tabs {
        border-bottom: 1px solid #2196F3;
    }
    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
        color: #7b8a8b;
        background-color: #fff;
        border-color: #2196F3 #2196F3 #fff;
    }
    .nav-tabs .nav-link.active, .nav-tabs .nav-link.active:focus, .nav-tabs .nav-link.active:hover, .nav-tabs .nav-item.open .nav-link, .nav-tabs .nav-item.open .nav-link:focus, .nav-tabs .nav-item.open .nav-link:hover {
        color: #2196F3;
    }
    .btn-lobo{
        color: #fff;
        background-color: #795548;
        border-color: #4E342E;
    }
    .btn-foto{
        color: #fff;
        background-color: #99cc00;
        border: 2px solid #99cc00;
    }
</style>
<?php
$this->load->view('vBajaEmpleado');
