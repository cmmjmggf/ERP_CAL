<div class="card m-3 animated fadeIn" id="pnlTablero">
    <!--    MENU DE OPCIONES-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-info sticky-top">
        <span class="ml-2 navbar-brand" >
            Genera Costos
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav w-100">
                <li class="nav-item dropdown">
                    <a class="btn text-white dropdown-toggle" href="#" id="navCatalogos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Consulta</a>
                    <ul class="dropdown-menu animated slideIn" aria-labelledby="navCatalogos">
                        <a class="dropdown-item" href="#" onclick="consultaEstiloso()">Estilos</a>
                        <a class="dropdown-item" href="#" onclick="consultaFraccionesXEstilo()">Fracciones</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#mdlFichaTecnicaCompra">Costos Ficha Técnica</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#mdlLineasAbiertas">Lineas Abiertas</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#mdlEstilosFotos">Visualiza Estilo</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#mdlParametrosFijos">Parámetros Fijos</a>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="btn text-white dropdown-toggle" href="#" id="navUtilerias" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Utilerías</a>
                    <ul class="dropdown-menu animated slideIn" aria-labelledby="navUtilerias">
                        <a class="dropdown-item" href="#" onclick="onMarcarLineaParaNoModificar()">Marca Linea/Estilos para NO modificarlos</a>
                        <a class="dropdown-item" href="#" onclick="onDescarmarLineaParaModificar()">Desmarca Linea/Estilos para modificarlos</a>
                        <a class="dropdown-item" href="#" onclick="onImprimirListaPrecios()">Imprime Lista de Precios</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#mdlSeleccionaEstiloColorParaEfectoVenta">Clasifica Estilo para Precio Venta</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#mdlSeleccionaEstiloColorParaEfectoVenta">Elimina Estilos Obsoletos</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#mdlConsultaEstiloLineaLista">Verifica Estilos/Lineas</a>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="btn text-white dropdown-toggle" href="#" id="navHerramientas" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Eliminar</a>
                    <ul class="dropdown-menu animated slideIn" aria-labelledby="navHerramientas">
                        <a class="dropdown-item" href="#" onclick="onEliminarLineaListaCorrida()">Elimina Linea, Corrida lista para volver a generar</a>
                        <a class="dropdown-item" href="#" onclick="onEliminarEstilo()">Elimina Estilo Seleccionado</a>
                    </ul>
                </li>
                <li class="nav-item dropdown ml-auto">
                    <button class="btn btn-warning " id="sidebarCollapse" onclick="init()">
                        <i class="fa fa-file-alt"></i> Otra Linea-Corrida lista de precios
                    </button>
                    <button class="btn btn-danger " id="sidebarCollapse" onclick="onImprimirReporteCostos()">
                        <i class="fa fa-print"></i> IMPRIME
                    </button>
                    <button class="btn btn-success " id="sidebarCollapse">
                        <i class="fa fa-check"></i> ACEPTAR
                    </button>
                </li>
            </ul>
        </div>
    </nav>
    <!--    PARÁMETROS-->
    <div class="card-body ">
        <div class="row ">
            <!--primer columna-->
            <div class="col-7" >
                <div class="row">
                    <div class="col-12 col-sm-5 col-md-4 col-xl-4" >
                        <label for="" >Linea</label>
                        <select id="Linea" name="Linea" class="form-control form-control-sm required" >
                            <option value=""></option>
                            <?php
                            foreach ($this->db->select("C.Clave AS CLAVE, CONCAT(C.Clave, \" - \",C.Descripcion) AS LINEA, C.Tipo ", false)
                                    ->from('lineas AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('ABS(C.Clave)', 'ASC')->get()->result() as $k => $v) {
                                print "<option value='{$v->CLAVE}-{$v->Tipo}'>{$v->LINEA}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-sm-5 col-md-4 col-xl-4" >
                        <label for="" >Lista Precios</label>
                        <select id="ListaPrecios" name="ListaPrecios" class="form-control form-control-sm required" >
                            <option value=""></option>
                            <?php
                            foreach ($this->db->select("C.Lista AS CLAVE, CONCAT(C.Lista, \" - \",C.Descripcion) AS LISTA ", false)
                                    ->from('listadeprecios AS C')->order_by('ABS(C.Lista)', 'ASC')->get()->result() as $k => $v) {
                                print "<option value='{$v->CLAVE}' >{$v->LISTA}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-sm-5 col-md-4 col-xl-4" >
                        <label for="" >Corrida</label>
                        <select id="Corrida" name="Corrida" class="form-control form-control-sm NotSelectize" >
                            <option value=""></option>
                            <option value="1">1 - 17/21 &frac12; Nn </option>
                            <option value="2">2 - 22/27 Dn</option>
                            <option value="3">3 - 25/31 Hn</option>
                            <option value="4">4 - 17/21 &frac12; Ne</option>
                            <option value="5">5 - 5/11 De</option>
                            <option value="6">6 - 6/13 He</option>
                        </select>
                    </div>
                </div>
                <!--                Tabla-->
                <div class="row" style="height: 700px; overflow-y: auto;">
                    <!--Primer tabla-->
                    <div class="col-12 mt-1" >
                        <div class="card-block">
                            <div id="Registros" class="datatable-wide">
                                <table id="tblRegistrosGenCostos" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Lta</th>
                                            <th>Linea</th>
                                            <th>Estilo</th>
                                            <th>Col</th>
                                            <th>Cda</th>
                                            <th>Tipo Piel</th>
                                            <th>Mat.Pri</th>
                                            <th>%ExPF</th>
                                            <th>$ExPF</th>
                                            <th>M.OB.</th>
                                            <th>Tejido</th>
                                            <th>PreXEst</th>
                                            <th>P-Aut</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12" align="center">
                    <label class="badge badge-danger" style="font-size: 14px;">Nota: Actualizar es tomar informacion actual en precios y consumos, para efectos de facturación</label>
                </div>
                <div class="col-12" align="center">
                    <label class="badge badge-info" style="font-size: 14px;">Nota: Materia Prima es natural sin desperdicio</label>
                </div>
            </div>
            <!--segunda columna-->
            <div class="col-5 border border-info border-top-0  border-right-0 border-bottom-0">
                <div class="row">
                    <div class="col-12" align="center">
                        <label class="badge badge-danger" style="font-size: 14px;">Analisis de precio por estilo</label>
                    </div>

                    <div class="w-100 mt-3"></div>
                    <!--ENCABEZADOS-->
                    <div class="col-4" align="center">
                        <label class="badge badge-info" style="font-size: 12px; width: 100%;">Parametros Fijos</label>
                    </div>
                    <div class="col-2" align="center">
                        <label class="text-strong">Prec-Natural</label>
                    </div>
                    <div class="col-2" align="center">
                        <label class="badge badge-danger" style="font-size: 12px; width: 100%;">%</label>
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  rojomas" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <label class="badge badge-danger" style="font-size: 12px; width: 100%;">%</label>
                    </div>

                    <div class="w-100"></div>


                    <!--                    primer renglon-->
                    <div class="col-4" >
                        <label>Materia Prima</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>

                    <!--                    2do renglon-->
                    <div class="col-2" >
                        <label>%Ext.Piel/Fo</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <!--                    3er renglon-->
                    <div class="col-2" >
                        <label>Tolerancia</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>

                    <!--                    4to renglon-->
                    <div class="col-2" >
                        <label>Mano Obra</label>
                    </div>
                    <div class="col-2" align="center">

                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>

                    <!--                    5to renglon-->
                    <div class="col-2" >
                        <label>Tejida</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>

                    <!--                    6to renglon-->
                    <div class="col-2" >
                        <label>Gto. Fabric</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>

                    <!--                    7mo renglon-->
                    <div class="col-2" >
                        <label>Cto-Producc</label>
                    </div>
                    <div class="col-2" align="center">

                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>

                    <!--                    8vo renglon-->
                    <div class="col-2" >
                        <label>Gto. Venta</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>

                    <!--                    9no renglon-->
                    <div class="col-2" >
                        <label>Gto. Adm</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>

                    <!--                    10mo renglon-->
                    <div class="col-2" >
                        <label>Hms</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>

                    <!--                    11vo renglon-->
                    <div class="col-2" >
                        <label>Flete</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>

                    <!--                    12vo renglon-->
                    <div class="col-2" >
                        <label>Utilidad</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  rojomas" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" >
                    </div>
                    <div class="col-2" align="center">
                    </div>

                    <!--                    13vo renglon-->
                    <div class="col-2" >
                        <label>Subtot</label>
                    </div>
                    <div class="col-2" align="center">
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">

                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                    </div>

                    <!--                    14vo renglon-->
                    <div class="col-2" >
                        <label>Desc</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>


                    <!--                    15vo renglon-->
                    <div class="col-2" >
                        <label>Comisión</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>

                    <!--                    16vo renglon-->
                    <div class="col-4" >
                        <label>Precio Venta</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  rojomas" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="porVenta100" name="porVenta100"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  rojomas" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="Agente" name="Agente"   >
                    </div>

                    <div class="w-100"></div>
                    <!--                    17vo renglon-->
                    <div class="col-2" align="center">
                    </div>
                    <div class="col-4" >
                        <label class="badge badge-danger" style="font-size: 12px; width: 100%;">Gastos Fijos</label>
                        <input type="text" class="form-control form-control-sm numbersOnly rojo" maxlength="6" id="GastosFijos" name="GastosFijos"  >
                    </div>
                    <div class="col-2" align="center">
                    </div>
                    <div class="col-4" >
                        <label class="badge badge-danger" style="font-size: 12px; width: 100%;">Punto Equilibrio</label>
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="CanceladoPesos" name="CanceladoPesos"  >
                    </div>

                    <!--                    CAMPOS PRECIO-->
                    <div class="w-100 mt-2 "></div>
                    <div class="col-8" align="center">
                    </div>
                    <div class="col-4" align="center">
                        <label class="badge badge-success text-strong text-white" style="font-size: 14px; width: 100%;">Precio Autorizado</label>
                    </div>
                    <div class="w-100 mb-2"></div>
                    <!--                   Estilo color Lista -->
                    <div class="col-8" >
                    </div>
                    <div class="col-1" align="center">
                        <input type="text" class="form-control form-control-sm  morado" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  morado" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <div class="col-1" >
                        <input type="text" class="form-control form-control-sm  morado" readonly="" id="Agente" name="Agente"   >
                    </div>
                    <!--                   Precio -->
                    <div class="w-100"></div>
                    <div class="col-8" >
                    </div>
                    <div class="col-4" align="center">
                        <input type="text" class="form-control form-control-sm  morado numbersOnly" maxlength="7"  id="PreAutori" name="PreAutori"   >
                    </div>
                    <!--                   Estilo Sel y tot Estilos -->
                    <div class="w-100"></div>
                    <div class="col-3" >
                    </div>
                    <div class="col-5" align="right">
                        <label>Estilo seleccionado y tot-estilos</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="EstiloSelecc" name="EstiloSelecc"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="TotEstilos" name="TotEstilos"   >
                    </div>
                    <!--                   Fecha última actualización -->
                    <div class="w-100"></div>
                    <div class="col-3" >
                    </div>
                    <div class="col-5" align="right">
                        <label>Fecha última actualización</label>
                    </div>
                    <div class="col-4" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="FechaUltiActu" name="FechaUltiActu"   >
                    </div>
                    <!--                   Precio Promedio-->
                    <div class="w-100"></div>
                    <div class="col-3" >
                    </div>
                    <div class="col-5" align="right">
                        <label class="text-strong text-info" style="font-size: 16px;">Precio Promedio</label>
                    </div>
                    <div class="col-4" align="center">
                        <input type="text" class="form-control form-control-sm  morado" readonly="" id="PrecioProm" name="PrecioProm"   >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/GeneraCostosVenta/';
    var pnlTablero = $("#pnlTablero");
    var linea;
    var tblRegistrosGenCostos = $('#tblRegistrosGenCostos');
    var Registros;
    var estiloS = 0, colorS = 0, listaS = 0, lineaS = 0;
    $(document).ready(function () {
        init();
        tblRegistrosGenCostos.find('tbody').on('click', 'tr', function () {
            tblRegistrosGenCostos.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        tblRegistrosGenCostos.find('tbody').on('dblclick', 'tr', function () {
            var dtm = Registros.row(this).data();
            estiloS = dtm.estilo;
            lineaS = dtm.linea;
            listaS = dtm.lista;
            colorS = dtm.color;
        });
        pnlTablero.find('#Linea').change(function () {
            var tipoLinea = 0;
            if ($(this).val()) {
                linea = $(this).val().split("-")[0];
                tipoLinea = parseInt($(this).val().split("-")[1]);
                switch (tipoLinea) {
                    case 1:
                        swal('ATENCIÓN', 'Linea en PROTOTIPO', 'info').then((value) => {
                            pnlTablero.find('#ListaPrecios')[0].selectize.focus();
                        });
                        break;
                    case 2:
                        swal('ATENCIÓN', 'Linea en MUESTRA', 'info').then((value) => {
                            pnlTablero.find('#ListaPrecios')[0].selectize.focus();
                        });
                        break;
                    case 3:
                        swal('ATENCIÓN', 'Linea en EXTENCIÓN', 'info').then((value) => {
                            pnlTablero.find('#ListaPrecios')[0].selectize.focus();
                        });
                        break;
                }
                //limpia();
            }
        });
        pnlTablero.find('#ListaPrecios').change(function () {
            if ($(this).val()) {
                pnlTablero.find('#Corrida')[0].selectize.focus();
            }
        });
        pnlTablero.find('#Corrida').change(function () {
            if ($(this).val()) {
                var pretot = 0;
                var corrida = $(this).val();
                var lista = pnlTablero.find('#ListaPrecios').val();
                getRegistros(linea, lista, corrida);
                //Obtener información inicial
                $.getJSON(master_url + 'getInfoInicial', {Linea: linea, Lista: lista, Corrida: corrida}).done(function (data) {
                    var registros = 0;
                    var pre1, pre2, pre3, pre33, pre7, pre11, porcentaje0, porcentaje1, porcentaje2;
                    $.each(data, function (k, v) {
                        registros = k;
                        porcentaje0 = 0.85;
                        porcentaje1 = parseFloat(v.comic) + parseFloat(v.desc);
                        porcentaje2 = parseFloat(porcentaje0) - parseFloat(porcentaje1);
                        pre1 = parseFloat(v.matpri) + parseFloat(v.mextr);
                        pre11 = parseFloat(pre1) * parseFloat(v.toler);
                        pre2 = parseFloat(pre11) + parseFloat(v.matpri) + parseFloat(v.maob) + parseFloat(v.gfabri) + parseFloat(v.tejida) + parseFloat(v.mextr);
                        pre3 = parseFloat(pre2) + parseFloat(v.gvta) + parseFloat(v.gadmon) + parseFloat(v.hms) + parseFloat(v.flete);
                        pre33 = parseFloat(pre3) / parseFloat(porcentaje2);
                        pre7 = parseFloat(pre33);
                        pretot = parseFloat(pretot) + parseFloat(pre7);

                    });
                    var paresTot = registros + 1;
                    //Llenamos los campos con los datos
                    pnlTablero.find('#PrecioProm').val('$' + $.number(parseFloat(pretot / paresTot), 2, '.', ','));
                    pnlTablero.find('#TotEstilos').val(paresTot);
                    pnlTablero.find('#FechaUltiActu').val(data[0].fecha);
                    pnlTablero.find('#GastosFijos').val(data[0].gtosf);

                    $('#tblRegistrosGenCostos_filter input[type=search]').focus();
                }).fail(function (x) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });
        pnlTablero.find('#GastosFijos').keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    $.post(master_url + 'onActualizarGastosFijos', {GastosF: $(this).val()}).done(function (data) {
                        swal('ATENCIÓN', 'LOS GASTOS FIJOS SE HAN ACTUALIZADO CON ÉXITO', 'success').then((value) => {
                            pnlTablero.find('#GastosFijos').focus().select();
                        });
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find('#PreAutori').keypress(function (e) {
            if (e.keyCode === 13) {
                if (estiloS > 0) {
                    if ($(this).val()) {
                        $.post(master_url + 'onActualizarPrecioAutorizado', {PrecioAut: $(this).val(), Linea: lineaS, Lista: listaS, Estilo: estiloS, Color: colorS}).done(function (data) {
                            Registros.ajax.reload();
                            onNotifyOld('fa fa-check', 'PRECIO GUARDADO CORRECTAMENTE', 'success');
                            pnlTablero.find('#PreAutori').focus().select();
                        }).fail(function (x) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x.responseText);
                        });
                    }
                } else {
                    swal('ATENCIÓN', 'SELECCIONA EL ESTILO A ELIMINAR', 'warning');
                }
            }
        });
    });
    function onEliminarEstilo() {
        if (estiloS > 0) {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            $.post(base_url + 'index.php/GeneraCostosVenta/onEliminarEstilo', {Linea: lineaS, Lista: listaS, Estilo: estiloS, Color: colorS}).done(function (data) {
                Registros.ajax.reload();
                onNotifyOld('fa fa-check', 'ESTILO ELIMINADO CORRECTAMENTE', 'success');
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        } else {
            swal('ATENCIÓN', 'SELECCIONA EL ESTILO A ELIMINAR', 'warning');
        }
    }
    function onEliminarLineaListaCorrida() {
        var corrida = pnlTablero.find('#Corrida').val();
        var lista = pnlTablero.find('#ListaPrecios').val();
        if (linea && corrida && lista) {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            $.post(base_url + 'index.php/GeneraCostosVenta/onEliminarLineaListaCorrida', {Linea: linea, Lista: lista, Corrida: corrida}).done(function (data) {
                console.log(data);
                onNotifyOld('fa fa-check', 'REGISTRO ELIMINADO CORRECTAMENTE', 'success');
                init();
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        } else {
            swal('ERROR', 'Debe de seleccionar una LINEA/LISTA/CORRIDA para continuar', 'warning').then((value) => {
                pnlTablero.find('#Linea')[0].selectize.focus();
                pnlTablero.find('#Linea')[0].selectize.open();
            });
        }
    }
    function onMarcarLineaParaNoModificar() {
        if (linea) {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            $.post(base_url + 'index.php/GeneraCostosVenta/onMarcarLineaParaNoModificar', {Linea: linea}).done(function (data) {
                onNotifyOld('fa fa-check', 'LINEAS MARCADAS CORRECTAMENTE', 'success');
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        } else {
            swal('ERROR', 'SELECCIONE UNA LINEA A MARCAR', 'warning').then((value) => {
                pnlTablero.find('#Linea')[0].selectize.focus();
                pnlTablero.find('#Linea')[0].selectize.open();
            });
        }
    }
    function onDescarmarLineaParaModificar() {
        if (linea) {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            $.post(base_url + 'index.php/GeneraCostosVenta/onDescarmarLineaParaModificar', {Linea: linea}).done(function (data) {
                onNotifyOld('fa fa-check', 'LINEAS DESMARCADAS CORRECTAMENTE', 'success');
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        } else {
            swal('ERROR', 'SELECCIONE UNA LINEA A DESMARCAR', 'warning').then((value) => {
                pnlTablero.find('#Linea')[0].selectize.focus();
                pnlTablero.find('#Linea')[0].selectize.open();
            });
        }
    }
    function init() {
        pnlTablero.find('#Linea')[0].selectize.focus();
        pnlTablero.find('#Corrida').selectize({
            hideSelected: false,
            openOnFocus: true,
            score: function (search)
            {
                return function (option)
                {
                    if (option.text.indexOf(search) === 0)
                    {
                        return 1;
                    }
                    return 0;
                };
            }
        });
        limpia();
        getRegistros('', 0, 0);
        estiloS = 0;
        lineaS = 0;
        listaS = 0;
        colorS = 0;
    }
    function limpia() {
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find('#porVenta100').val('100%');
    }
    function getRegistros(linea, lista, corrida) {
        $.fn.dataTable.ext.errMode = 'throw';

        if ($.fn.DataTable.isDataTable('#tblRegistrosGenCostos')) {
            tblRegistrosGenCostos.DataTable().destroy();
        }

        Registros = tblRegistrosGenCostos.DataTable({
            "dom": 'frt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRegistros',
                "dataSrc": "",
                "data": {Linea: linea, Lista: lista, Corrida: corrida},
                "type": "GET"
            },
            "columns": [
                {"data": "lista"},
                {"data": "linea"},
                {"data": "estilo"},
                {"data": "color"},
                {"data": "corr"},
                {"data": "colord"},
                {"data": "matpri"},
                {"data": "pextr"},
                {"data": "mextr"},
                {"data": "maob"},
                {"data": "tejida"},
                {"data": "precto"},
                {"data": "preaut"}
            ],
            "columnDefs": [
                {
                    "targets": [6, 8, 9, 10, 11, 12],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [7],
                    "render": function (data, type, row) {
                        return '%' + $.number(parseFloat(data * 100), 0, '.', ',');
                    }
                }
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 2:
                            /*ARTICULO*/
                            c.addClass('text-info text-strong');
                            break;
                        case 3:
                            /*UNIDAD*/
                            c.addClass('text-info text-strong');
                            break;
                        case 5:
                            /*UNIDAD*/
                            c.addClass('text-strong');
                            break;
                        case 11:
                            /*UNIDAD*/
                            c.addClass('text-strong text-warning');
                            break;
                        case 12:
                            /*UNIDAD*/
                            c.addClass('text-strong text-success');
                            break;
                    }
                });
            },
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 450,
            "scrollX": true,
            "scrollY": 630,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [3, 'desc']
            ],
            "initComplete": function (x, y) {

            }
        });

    }
    function consultaFraccionesXEstilo() {
        onOpenWindow('<?php print base_url('FraccionesXEstilo'); ?>');
    }
    function consultaEstiloso() {
        onOpenWindow('<?php print base_url('Estilos'); ?>');
    }
    function onImprimirListaPrecios() {
        var lista = pnlTablero.find('#ListaPrecios').val();
        if (lista) {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            $.post(base_url + 'index.php/GeneraCostosVenta/onImprimirListaPrecios', {Lista: lista}).done(function (data) {
                onImprimirReporteFancy(data);
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        } else {
            swal('ERROR', 'SELECCIONE UNA LISTA DE PRECIOS', 'warning').then((value) => {
                pnlTablero.find('#ListaPrecios')[0].selectize.focus();
                pnlTablero.find('#ListaPrecios')[0].selectize.open();
            });
        }
    }
    function onImprimirReporteCostos() {
        if (linea) {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            $.post(base_url + 'index.php/GeneraCostosVenta/onImprimirReporteCostos', {Linea: linea}).done(function (data) {
                onImprimirReporteFancy(data);
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        } else {
            swal('ERROR', 'SELECCIONE UNA LINEA', 'warning').then((value) => {
                pnlTablero.find('#Linea')[0].selectize.focus();
                pnlTablero.find('#Linea')[0].selectize.open();
            });
        }
    }
</script>
<style>
    .text-strong {
        font-weight: bolder;
    }

    tr.group-start:hover td{
        background-color: #e0e0e0 !important;
        color: #000 !important;
    }
    tr.group-end td{
        background-color: #FFF !important;
        color: #000!important;
    }
    /*    td{
            -webkit-transition: all .2s ease-in-out;
            transition: all .2s ease-in-out;
        }*/

    td span.badge{
        font-size: 100% !important;
    }

    div.datatable-wide {
        padding-left: 0;
        padding-right: 0;
    }

    .verde {

        background-color: #B9F5A2 !important;
    }

    .azul  {
        background-color: #4BEFF1 !important;
    }

    .rojomas {
        background-color: #EC8E75 !important;

    }
    .rojo {
        background-color: #FFBEAC !important;

    }
    .morado {
        background-color: #CFC7FA !important;
    }
    label {
        margin-top: 0.14rem;
        margin-bottom: 0.0rem;
    }

    .form-control-sm,  .form-control {
        padding: 0.15rem 0.5rem;
        margin-top:  0.15rem;
        margin-bottom: 0.15rem;
    }
    .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7,
    .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto,
    .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6,
    .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12,
    .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4,
    .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9,
    .col-md-10, .col-md-11, .col-md-12, .col-md,
    .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3,
    .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7,
    .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11,
    .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4,
    .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9,
    .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto {
        padding-right: 10px;
        padding-left: 10px;
    }
</style>
