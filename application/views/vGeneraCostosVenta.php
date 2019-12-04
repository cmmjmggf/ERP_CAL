<div class="card m-3 animated fadeIn" id="pnlTablero">
    <!--    MENU DE OPCIONES-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-info sticky-top">
        <span class="ml-2 navbar-brand" >
            Genera Precios de Venta
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
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#mdlFichaTecnicaPreciosCostos">Costos Ficha Técnica</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#mdlEstilosFotos">Visualiza Estilo</a>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="btn text-white dropdown-toggle" href="#" id="navUtilerias" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Utilerías</a>
                    <ul class="dropdown-menu animated slideIn" aria-labelledby="navUtilerias">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#mdlLineasAbiertas">Lineas Abiertas</a>
                        <a class="dropdown-item" href="#" onclick="onMarcarLineaParaNoModificar()">Cerrar Linea/Estilos para NO modificar</a>
                        <a class="dropdown-item" href="#" onclick="onDescarmarLineaParaModificar()">Abrir Linea/Estilos para modificar</a>
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
                    <a class="btn btn-secondary" href="#" data-toggle="modal" data-target="#mdlSeleccionaEstiloColorParaEfectoVenta">
                        <i class="fa fa-check-square"></i> Clasifica Estilo p' Precio-Vta
                    </a>
                    <a class="btn btn-secondary" href="#" onclick="onImprimirListaPrecios()"><i class="fa fa-file-invoice-dollar"></i> Imp. Lista Precios</a>
                    <a class="btn btn-secondary" href="#" data-toggle="modal" data-target="#mdlParametrosFijos"><i class="fa fa-cogs"></i> Param. Fijos</a>
                    <button class="btn btn-warning " onclick="init()">
                        <i class="fa fa-file-alt"></i> Otra Linea-Corr-Lista
                    </button>
                    <button class="btn btn-danger " onclick="onImprimirReporteCostos()">
                        <i class="fa fa-print"></i> Imprime
                    </button>
                    <button class="btn btn-success " id ="btnAceptarActualizar">
                        <i class="fa fa-check"></i> Actualiza
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
                    <div class="col-1" >
                        <label for="" >Linea</label>
                        <input type="text" class="form-control form-control-sm numbersOnly NotClean" maxlength="6"  id="Linea" name="Linea"   >
                    </div>
                    <div class="col-3" >
                        <label for="" >-</label>
                        <select id="sLinea" name="sLinea" class="form-control form-control-sm  NotSelectize" >
                            <option value=""></option>
                            <?php
                            foreach ($this->db->select("C.Clave AS CLAVE, C.Descripcion AS LINEA, C.Tipo ", false)
                                    ->from('lineas AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('LINEA', 'ASC')->get()->result() as $k => $v) {
                                print "<option value='{$v->CLAVE}'>{$v->LINEA}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-1" >
                        <label for="" >Lista</label>
                        <input type="text" class="form-control form-control-sm numbersOnly NotClean" maxlength="6" id="ListaPrecios" name="ListaPrecios"   >
                    </div>
                    <div class="col-3" >
                        <label for="" >-</label>
                        <select id="sListaPrecios" name="sListaPrecios" class="form-control form-control-sm  NotSelectize" >
                            <option value=""></option>
                            <?php
                            foreach ($this->db->select("C.Lista AS CLAVE, C.Descripcion AS LISTA ", false)
                                    ->from('listadeprecios AS C')->order_by('LISTA', 'ASC')->get()->result() as $k => $v) {
                                print "<option value='{$v->CLAVE}' >{$v->LISTA}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-1" >
                        <label for="" >Corrida</label>
                        <input type="text" class="form-control form-control-sm numbersOnly NotClean" maxlength="6"  id="Corrida" name="Corrida"   >
                    </div>
                    <div class="col-3" >
                        <label for="" >-</label>
                        <select id="sCorrida" name="sCorrida" class="form-control form-control-sm NotSelectize" >
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
                <div class="row" style="height: 630px; overflow-y: auto;">
                    <!--Primer tabla-->
                    <div class="col-12 mt-1" >
                        <div class="card-block">
                            <div id="Registros" class="datatable-wide">
                                <table id="tblRegistrosGenCostos" class="table table-sm display nowrap " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="d-none">Lta</th>
                                            <th class="d-none">Linea</th>
                                            <th>Estilo</th>
                                            <th>Col</th>
                                            <th class="d-none">Cda</th>
                                            <th>Tipo Piel</th>
                                            <th>Mat.Pri</th>
                                            <th class="d-none">%ExPF</th>
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
            </div>
            <!--segunda columna-->
            <div class="col-5 border border-info border-top-0  border-right-0 border-bottom-0">
                <div class="row">
                    <div class="col-8" align="center">
                        <label class="badge badge-danger" style="font-size: 14px; width: 100%">Analisis de precio por estilo</label>
                    </div>
                    <div class="col-4" align="center">
                        <label class="badge badge-info" style="font-size: 14px; width: 100%">Precio Vta-Aut</label>
                    </div>

                    <div class="w-100 mt-2"></div>
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
                        <input type="text" class="form-control form-control-sm  rojomas" readonly="" id="PreAutoPrincipal" name="PreAutoPrincipal"   >
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
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="mp" name="mp"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  amarillo" readonly="" id="mpPor1" name="mpPor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="mp2" name="mp2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="mpPor2" name="mpPor2"   >
                    </div>

                    <!--                    2do renglon-->
                    <div class="col-2" >
                        <label>%Ext.Piel/Fo</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="pextr" name="pextr"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="mextr" name="mextr"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  amarillo" readonly="" id="mextrPor1" name="mextrPor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="mextr2" name="mextr2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="mextrPor2" name="mextrPor2"   >
                    </div>
                    <!--                    3er renglon-->
                    <div class="col-2" >
                        <label>Tolerancia</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="tolera" name="tolera"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="tolera2" name="tolera2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  amarillo" readonly="" id="toleraPor1" name="toleraPor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="tolera22" name="tolera22"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="toleraPor2" name="toleraPor2"   >
                    </div>

                    <!--                    4to renglon-->
                    <div class="col-2" >
                        <label>Mano Obra</label>
                    </div>
                    <div class="col-2" align="center">

                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="mo" name="mo"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  amarillo" readonly="" id="moPor1" name="moPor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="mo2" name="mo2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="moPor2" name="moPor2"   >
                    </div>

                    <!--                    5to renglon-->
                    <div class="col-2" >
                        <label>Tejida</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="tejida" name="tejida"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="tejida2" name="tejida2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  amarillo" readonly="" id="tejidaPor1" name="tejidaPor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="tejida22" name="tejida22"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="tejidaPor2" name="tejidaPor2"   >
                    </div>

                    <div class="w-100 border border-info border-top-0  border-right-0 border-left-0 mt-1 mb-1 ml-2 mr-2"></div>

                    <!--                    6to renglon-->

                    <div class="col-2" >
                        <label class="text-danger">Cto-Producc</label>
                    </div>
                    <div class="col-2" align="center">

                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="costoProd" name="costoProd"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verdemas" readonly="" id="costoProdPor1" name="costoProdPor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="costoProd2" name="costoProd2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verdemas" readonly="" id="costoProdPor2" name="costoProdPor2"   >
                    </div>

                    <div class="w-100 border border-info border-top-0  border-right-0 border-left-0 mt-1 mb-1 ml-2 mr-2"></div>

                    <!--                    7mo renglon-->
                    <div class="col-2" >
                        <label>Gto. Fabric</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="gfabri" name="gfabri"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="gfabri2" name="gfabri2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="gfabriPor1" name="gfabriPor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="gfabri22" name="gfabri22"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="gfabriPor2" name="gfabriPor2"   >
                    </div>

                    <!--                    8vo renglon-->
                    <div class="col-2" >
                        <label>Gto. Venta</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="gvta" name="gvta"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="gvta2" name="gvta2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="gvtaPor1" name="gvtaPor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="gvta22" name="gvta22"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="gvtaPor2" name="gvtaPor2"   >
                    </div>

                    <!--                    9no renglon-->
                    <div class="col-2" >
                        <label>Gto. Adm</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="gadmon" name="gadmon"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="gadmon2" name="gadmon2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="gadmonPor1" name="gadmonPor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="gadmon22" name="gadmon22"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="gadmonPor2" name="gadmonPor2"   >
                    </div>

                    <!--                    10mo renglon-->
                    <div class="col-2" >
                        <label>Hms</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="hms" name="hms"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="hms2" name="hms2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="hmsPor1" name="hmsPor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="hms22" name="hms22"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="hmsPor2" name="hmsPor2"   >
                    </div>

                    <!--                    11vo renglon-->
                    <div class="col-2" >
                        <label>Flete</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="flete" name="flete"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="flete2" name="flete2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="fletePor1" name="fletePor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="flete22" name="flete22"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verde" readonly="" id="fletePor2" name="fletePor2"   >
                    </div>

                    <div class="w-100 border border-info border-top-0  border-right-0 border-left-0 mt-1 mb-1 ml-2 mr-2"></div>
                    <!--                    Totales gastos-->
                    <div class="col-2" >
                        <label class="text-danger">Gastos</label>
                    </div>
                    <div class="col-2" align="center">

                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="GastoProd" name="GastoProd"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verdemas" readonly="" id="GastoProdPor1" name="GastoProdPor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="GastoProd2" name="GastoProd2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verdemas" readonly="" id="GastoProdPor2" name="GastoProdPor2"   >
                    </div>

                    <div class="w-100 border border-info border-top-0  border-right-0 border-left-0 mt-1 mb-1 ml-2 mr-2"></div>

                    <!--                    13vo renglon-->
                    <div class="col-2" >
                        <label class="text-danger">Subtot</label>
                    </div>
                    <div class="col-2" align="center">
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="subtotal" name="subtotal"   >
                    </div>
                    <div class="col-2" align="center">

                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  rojo" readonly="" id="subtotal2" name="subtotal2"   >
                    </div>
                    <div class="col-2" align="center">
                    </div>

                    <div class="w-100 border border-info border-top-0  border-right-0 border-left-0 mt-1 mb-1 ml-2 mr-2"></div>
                    <!--                    14vo renglon-->
                    <div class="col-2" >
                        <label>Desc</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="desc" name="desc"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="desc2" name="desc2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verdemas" readonly="" id="descPor1" name="descPor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="desc22" name="desc22"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verdemas" readonly="" id="descPor2" name="descPor2"   >
                    </div>


                    <!--                    15vo renglon-->
                    <div class="col-2" >
                        <label>Comisión</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="comic" name="comic"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="comic2" name="comic2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verdemas" readonly="" id="comicPor1" name="comicPor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="comic22" name="comic22"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verdemas" readonly="" id="comicPor2" name="comicPor2"   >
                    </div>


                    <!--                    16vo renglon-->
                    <div class="col-2" >
                        <label>Utilidad</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="utilid" name="utilid"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  lila" readonly="" id="utilid2" name="utilid2"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verdemas" readonly="" id="utilidPor1" name="utilidPor1"   >
                    </div>
                    <div class="col-2" >
                        <input type="text" class="form-control form-control-sm  lila" readonly="" id="utilidReal" name="utilidReal"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  verdemas" readonly="" id="porUtilidReal" name="porUtilidReal"   >
                    </div>


                    <div class="w-100 border border-info border-top-0  border-right-0 border-left-0 mt-1 mb-1 ml-2 mr-2"></div>
                    <!--                    17vo renglon-->
                    <div class="col-4" >
                        <label class="text-success" style="font-size: 16px;">Precio Venta</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  rojomas" readonly="" id="PrecioProm" name="PrecioProm"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm NotClean verde" readonly="" id="porVenta100" name="porVenta100"   >
                    </div>
                    <div class="col-4">

                    </div>

                    <!--                    CAMPOS PRECIO-->
                    <div class="w-100 mt-2 "></div>
                    <div class="col-8" align="center">
                    </div>
                    <div class="col-4" align="center">
                        <label class="badge badge-success text-strong text-white" style="font-size: 14px; width: 100%;">Precio Autorizado</label>
                    </div>
                    <div class="w-100 mb-2"></div>
                    <!--                   Precio -->
                    <div class="w-100"></div>
                    <div class="col-8" >
                    </div>
                    <div class="col-4" align="center">
                        <input type="text" class="form-control  numbersOnly" maxlength="7"  id="PreAutori" name="PreAutori"   >
                    </div>
                    <!--                   Estilo Sel y tot Estilos -->
                    <div class="w-100"></div>
                    <div class="col-3" >
                    </div>
                    <div class="col-5" align="right">
                        <label>Fecha Ult. Act y total-estilos</label>
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm  azul" readonly="" id="FechaUltiActu" name="FechaUltiActu"   >
                    </div>
                    <div class="col-2" align="center">
                        <input type="text" class="form-control form-control-sm NotClean azul" readonly="" id="TotEstilos" name="TotEstilos"   >
                    </div>
                    <!--                   Fecha última actualización -->
                    <div class="w-100"></div>
                    <!--                   Precio Promedio-->
                    <div class="w-100"></div>
                    <div class="col-3" >
                    </div>
                    <div class="col-5" align="right">
                        <label class="text-strong text-info" style="font-size: 16px;">Precio Promedio</label>
                    </div>
                    <div class="col-4" align="center">
                        <input type="text" class="form-control form-control-sm NotClean morado" readonly="" id="PrecioPromFinal" name="PrecioPromFinal"   >
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="dFotoDrag" class="d-none">
        <div class="card cardFoto" id="marcoFoto">
            <div class="card-header card-headerFoto"><span class="float-right close-icon text-danger" id = "btnCerrarFoto"><i class="fa fa-times fa-lg"></i></span></div>
            <div class="card-body card-bodyFoto" style="height: 215px; overflow-y: auto;" align="center">
                <img id="fotoEstilo" src="" alt="" width="250px" height=""/>
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
    var fotoEstilo = $("#fotoEstilo");

    $(document).ready(function () {
        init();
        /*inputs events*/
        pnlTablero.find('#Linea').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtlinea = $(this).val();
                if (txtlinea) {

                    $.getJSON(master_url + 'onVerificarLinea', {Linea: txtlinea}).done(function (data) {
                        if (data.length > 0) {
                            linea = txtlinea;
                            pnlTablero.find("#sLinea")[0].selectize.addItem(txtlinea, true);
                            pnlTablero.find('#ListaPrecios').focus().select();
                        } else {
                            swal('ERROR', 'LA LINEA CAPTURADA NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find('#Linea').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find('#sLinea').change(function () {
            if ($(this).val()) {
                linea = $(this).val();
                pnlTablero.find('#Linea').val(linea);
                pnlTablero.find('#ListaPrecios').focus().select();
            }
        });
        pnlTablero.find('#ListaPrecios').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtlista = $(this).val();
                if (txtlista) {

                    $.getJSON(master_url + 'onVerificarListaPrecios', {Lista: txtlista}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sListaPrecios")[0].selectize.addItem(txtlista, true);
                            pnlTablero.find('#Corrida').focus().select();
                        } else {
                            swal('ERROR', 'LA LISTA DE PRECIOS NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find('#ListaPrecios').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find('#sListaPrecios').change(function () {
            if ($(this).val()) {
                pnlTablero.find('#ListaPrecios').val($(this).val());
                pnlTablero.find('#Corrida').focus().select();
            }
        });
        pnlTablero.find('#Corrida').keypress(function (e) {
            if (e.keyCode === 13) {
                var lista = pnlTablero.find('#ListaPrecios').val();
                var corrida = pnlTablero.find('#Corrida').val();
                if (linea) {
                    if (lista) {
                        if (corrida) {
                            pnlTablero.find("#sCorrida")[0].selectize.addItem(corrida, true);
                            estiloS = 0;
                            //Obtener información inicial
                            getRegistros(linea, lista, corrida);
                            obtenerInfoInicial(linea, lista, corrida);
                        } else {
                            swal('ERROR', 'SELECCIONE UNA CORRIDA', 'warning').then((value) => {
                                pnlTablero.find('#Corrida').focus();
                            });
                        }
                    } else {
                        swal('ERROR', 'SELECCIONE UNA LISTA DE PRECIOS', 'warning').then((value) => {
                            pnlTablero.find('#ListaPrecios').focus();
                        });
                    }
                } else {
                    swal('ERROR', 'SELECCIONE UNA LINEA', 'warning').then((value) => {
                        pnlTablero.find('#Linea').focus();
                    });
                }
            }
        });
        pnlTablero.find('#sCorrida').change(function () {
            if ($(this).val()) {
                pnlTablero.find('#Corrida').val($(this).val());
                var lista = pnlTablero.find('#ListaPrecios').val();
                var corrida = pnlTablero.find('#Corrida').val();
                if (linea) {
                    if (lista) {
                        if (corrida) {
                            pnlTablero.find("#sCorrida")[0].selectize.addItem(corrida, true);
                            estiloS = 0;
                            //Obtener información inicial
                            getRegistros(linea, lista, corrida);
                            obtenerInfoInicial(linea, lista, corrida);
                        } else {
                            swal('ERROR', 'SELECCIONE UNA CORRIDA', 'warning').then((value) => {
                                pnlTablero.find('#Corrida').focus();
                            });
                        }
                    } else {
                        swal('ERROR', 'SELECCIONE UNA LISTA DE PRECIOS', 'warning').then((value) => {
                            pnlTablero.find('#ListaPrecios').focus();
                        });
                    }
                } else {
                    swal('ERROR', 'SELECCIONE UNA LINEA', 'warning').then((value) => {
                        pnlTablero.find('#Linea').focus();
                    });
                }
            }
        });

        /*ACTUALIZAR*/
        pnlTablero.find('#btnAceptarActualizar').click(function () {
            var lista = pnlTablero.find('#ListaPrecios').val();
            var corrida = pnlTablero.find('#Corrida').val();
            if (linea) {
                if (lista) {
                    if (corrida) {
                        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                        $.post(base_url + 'index.php/GeneraCostosVenta/onActualizarCostos', {Lista: lista, Linea: linea, Corrida: corrida}).done(function (data) {
                            console.log(data);

                            if (data === '0') {
                                swal('ERROR', 'LA LISTA DE PRECIOS NO TIENE PARÁMETROS FIJOS', 'warning').then((value) => {
                                    pnlTablero.find('#Corrida').focus();
                                });
                            } else if (data === '1') {
                                swal('ERROR', 'NO EXISTEN ESTILOS EN ESTA LINEA//LISTA//CORRIDA', 'warning').then((value) => {
                                    pnlTablero.find('#Corrida').focus();
                                });
                            } else if (data === '2') {
                                swal('ERROR', 'NO EXISTEN ESTILOS PARA SACAR PRECIO FINAL', 'warning').then((value) => {
                                    pnlTablero.find('#Corrida').focus();
                                });
                            } else {//Se hace la actualización y se manda mensaje en caso de haber incidencias

                                if (data !== '') {
                                    swal('ATENCIÓN', 'Los siguientes estilos no tienen clasificación para venta: \n' + data, 'warning').then((value) => {
                                        onNotifyOld('fa fa-check', 'ACTUALIZACIÓN EXITOSA', 'success');
                                        Registros.ajax.reload();
                                        //Ejecutar funcion para traernos el precio promedio y numero de registros
                                        obtenerInfoInicial(linea, lista, corrida);
                                    });
                                } else {
                                    onNotifyOld('fa fa-check', 'ACTUALIZACIÓN EXITOSA', 'success');
                                    Registros.ajax.reload();
                                    //Ejecutar funcion para traernos el precio promedio y numero de registros
                                    obtenerInfoInicial(linea, lista, corrida);
                                }

                            }

//                            if (data.length > 0) {
//                                //no existen parámetros fijos
//                                onNotifyOld('fa fa-times', 'NO EXISTEN PARÁMETROS FIJOS', 'danger');
//                            } else {
//                                //se ha actualizado con existo
//                                onNotifyOld('fa fa-check', 'ACTUALIZACIÓN EXITOSA', 'success');
//                                Registros.ajax.reload();
//                                //Ejecutar funcion para traernos el precio promedio y numero de registros
//                                obtenerInfoInicial(linea, lista, corrida);
//                            }
                            HoldOn.close();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                            HoldOn.close();
                        });
                    } else {
                        swal('ERROR', 'SELECCIONE UNA CORRIDA', 'warning').then((value) => {
                            pnlTablero.find('#Corrida').focus();
                        });
                    }
                } else {
                    swal('ERROR', 'SELECCIONE UNA LISTA DE PRECIOS', 'warning').then((value) => {
                        pnlTablero.find('#ListaPrecios').focus();
                    });
                }
            } else {
                swal('ERROR', 'SELECCIONE UNA LINEA', 'warning').then((value) => {
                    pnlTablero.find('#Linea').focus();
                });
            }
        });
        /*Foto*/
        var a = 3;
        pnlTablero.find('#marcoFoto').draggable({
            start: function (event, ui) {
                $(this).css("z-index", a++);
            }
        });
        pnlTablero.find('#dFotoDrag div').click(function () {
            $(this).addClass('top').removeClass('bottom');
            $(this).siblings().removeClass('top').addClass('bottom');
            $(this).css("z-index", a++);
        });
        pnlTablero.find('#btnCerrarFoto').click(function () {
            pnlTablero.find('#dFotoDrag').addClass('d-none');
        });
        /*Fin Foto*/
        tblRegistrosGenCostos.find('tbody').on('click', 'tr', function () {
            tblRegistrosGenCostos.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        tblRegistrosGenCostos.find('tbody').on('dblclick', 'tr', function () {
            /*Limpia inputs*/
            pnlTablero.find("input").not('.NotClean').val("");
            var dtm = Registros.row(this).data();
            estiloS = dtm.estilo;
            lineaS = dtm.linea;
            listaS = dtm.lista;
            colorS = dtm.color;
            //Cargar Foto
            $.getJSON(master_url + 'getFotoEstilo', {Estilo: estiloS}).done(function (data) {
                if (data.length > 0) {
                    var dtm = data[0];
                    var ext = getExt(dtm.foto);
                    $.ajax({
                        url: base_url + dtm.foto,
                        type: 'HEAD',
                        error: function ()
                        {
                            fotoEstilo[0].src = '<?php print base_url('uploads/Estilos/1173.gif'); ?>';
                        },
                        success: function ()
                        {
                            if (ext === "gif" || ext === "jpg" || ext === "png" || ext === "jpeg" || ext === "GIF") {
                                fotoEstilo[0].src = base_url + dtm.foto;
                            } else {
                                fotoEstilo[0].src = '<?php print base_url('uploads/Estilos/1173.gif'); ?>';
                            }
                        }
                    });
                } else {
                    fotoEstilo[0].src = '<?php print base_url('uploads/Estilos/1173.gif'); ?>';
                }
                pnlTablero.find('#dFotoDrag').removeClass('d-none');
            }).fail(function (x) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });

            $.getJSON(master_url + 'getInfoCostos', {Lista: listaS, Linea: lineaS, Estilo: estiloS, Color: colorS, Corrida: dtm.corr}).done(function (data) {

                var datosParamFijos = JSON.parse(data['UNO'])[0];

                /*Datos generales*/
                pnlTablero.find('#FechaUltiActu').val(datosParamFijos.fecha);
                pnlTablero.find('#PreAutoPrincipal').val(toFormattedNumber(datosParamFijos.preaut));


                pnlTablero.find("#pextr").val(toFormattedPorcent(datosParamFijos.pextr * 100));
                pnlTablero.find("#tolera").val(toFormattedPorcent(datosParamFijos.toler * 100));
                pnlTablero.find("#gfabri").val(toFormattedNumber(datosParamFijos.gfabri));
                pnlTablero.find("#gvta").val(toFormattedNumber(datosParamFijos.gvta));
                pnlTablero.find("#gadmon").val(toFormattedNumber(datosParamFijos.gadmon));
                pnlTablero.find("#hms").val(toFormattedNumber(datosParamFijos.hms));
                pnlTablero.find("#utilid").val(toFormattedPorcent(datosParamFijos.utili));
                pnlTablero.find("#desc").val(toFormattedPorcent(datosParamFijos.desc * 100));
                pnlTablero.find("#flete").val(toFormattedNumber(datosParamFijos.flete));
                pnlTablero.find("#comic").val(toFormattedPorcent(datosParamFijos.comic * 100));
                pnlTablero.find("#mo").val(toFormattedNumber(datosParamFijos.maob));
                pnlTablero.find("#tejida").val(toFormattedNumber(datosParamFijos.tejida));
                pnlTablero.find("#mp").val(toFormattedNumber(datosParamFijos.matpri));
                pnlTablero.find("#mextr").val(toFormattedNumber(datosParamFijos.mextr));

                var txttol9 = parseFloat(datosParamFijos.matpri) + parseFloat(datosParamFijos.mextr);
                var txttol = parseFloat(txttol9) * parseFloat(datosParamFijos.toler);
                pnlTablero.find("#tolera2").val(toFormattedNumber(txttol));

                pnlTablero.find("#tejida2").val(toFormattedNumber(datosParamFijos.tejida));
                pnlTablero.find("#flete2").val(toFormattedNumber(datosParamFijos.flete));

                var txtctopro = parseFloat(datosParamFijos.matpri) + parseFloat(datosParamFijos.maob) +
                        parseFloat(datosParamFijos.tejida) + parseFloat(txttol) + parseFloat(datosParamFijos.mextr);
                pnlTablero.find("#costoProd").val(toFormattedNumber(txtctopro));

                pnlTablero.find("#gfabri2").val(toFormattedNumber(datosParamFijos.gfabri));
                pnlTablero.find("#gvta2").val(toFormattedNumber(datosParamFijos.gvta));
                pnlTablero.find("#gadmon2").val(toFormattedNumber(datosParamFijos.gadmon));
                pnlTablero.find("#hms2").val(toFormattedNumber(datosParamFijos.hms));

                /*Llena los campos de gastos*/
                var txttotalGastos = parseFloat(datosParamFijos.gvta) + parseFloat(datosParamFijos.gadmon) + parseFloat(datosParamFijos.gfabri) +
                        parseFloat(datosParamFijos.hms) + parseFloat(datosParamFijos.flete);
                pnlTablero.find("#GastoProd").val(toFormattedNumber(txttotalGastos));


                var txtsubt9 = parseFloat(txtctopro) + parseFloat(datosParamFijos.gvta) + parseFloat(datosParamFijos.gadmon) + parseFloat(datosParamFijos.gfabri) +
                        parseFloat(datosParamFijos.hms) + parseFloat(datosParamFijos.flete);

                var porcentaje1 = 0.85;
                var porcentaje2 = parseFloat(datosParamFijos.comic) + parseFloat(datosParamFijos.desc);
                var porcentaje3 = parseFloat(porcentaje1) - parseFloat(porcentaje2);

                var txtsubt99 = parseFloat(txtsubt9) / parseFloat(porcentaje3);

                var txtsubt8 = parseFloat(txtsubt99) * parseFloat(datosParamFijos.utili / 100);//Utilidad
                var txtsubt = parseFloat(txtsubt9);

                pnlTablero.find("#utilid2").val(toFormattedNumber(txtsubt8));
                pnlTablero.find("#subtotal").val(toFormattedNumber(txtsubt));

                //Primero sacamos el valor de la suma general con el descuento y la comicion
                var txtds = parseFloat(txtsubt99).toFixed(2) * parseFloat(datosParamFijos.desc).toFixed(2);
                var txtcm = parseFloat(txtsubt99) * parseFloat(datosParamFijos.comic);
                var txtpreprom = txtsubt + txtds + txtcm + txtsubt8;

                //Se saca el porcentaje y valor del descuento con estas variables ya calculadas con el precio general
                var txtdsfinal = parseFloat(txtpreprom) * parseFloat(datosParamFijos.desc);
                var txtcmfinal = parseFloat(txtpreprom) * parseFloat(datosParamFijos.comic);
                //Pintamos los valores
                pnlTablero.find("#desc2").val(toFormattedNumber(txtdsfinal));
                pnlTablero.find("#comic2").val(toFormattedNumber(txtcmfinal));
                pnlTablero.find("#PrecioProm").val(toFormattedNumber(txtpreprom));

                // ------------------------------- PORCENTAJES COLUMNA 1 ---------------------------------

                var txtpmp = (parseFloat(datosParamFijos.matpri) * 100) / parseFloat(txtctopro);
                pnlTablero.find("#mpPor1").val(toFormattedPorcentDecimals(txtpmp));
                var txtpmextr = (parseFloat(datosParamFijos.mextr) * 100) / parseFloat(txtctopro);
                pnlTablero.find("#mextrPor1").val(toFormattedPorcentDecimals(txtpmextr));
                var txtptl = (parseFloat(txttol) * 100) / parseFloat(txtctopro);
                pnlTablero.find("#toleraPor1").val(toFormattedPorcentDecimals(txtptl));
                var txtpmo = (parseFloat(datosParamFijos.maob) * 100) / parseFloat(txtctopro);
                pnlTablero.find("#moPor1").val(toFormattedPorcentDecimals(txtpmo));
                var txtptj = (parseFloat(datosParamFijos.tejida) * 100) / parseFloat(txtctopro);
                pnlTablero.find("#tejidaPor1").val(toFormattedPorcentDecimals(txtptj));
                var txtpctopro = (parseFloat(txtctopro) * 100) / parseFloat(txtpreprom);
                pnlTablero.find("#costoProdPor1").val(toFormattedPorcentDecimals(txtpctopro));
                var txtpgf = (parseFloat(datosParamFijos.gfabri) * 100) / parseFloat(txtctopro);
                pnlTablero.find("#gfabriPor1").val(toFormattedPorcentDecimals(txtpgf));
                var txtpgv = (parseFloat(datosParamFijos.gvta) * 100) / parseFloat(txtpreprom);
                pnlTablero.find("#gvtaPor1").val(toFormattedPorcentDecimals(txtpgv));
                var txtga = (parseFloat(datosParamFijos.gadmon) * 100) / parseFloat(txtpreprom);
                pnlTablero.find("#gadmonPor1").val(toFormattedPorcentDecimals(txtga));
                var txtphs = (parseFloat(datosParamFijos.hms) * 100) / parseFloat(txtpreprom);
                pnlTablero.find("#hmsPor1").val(toFormattedPorcentDecimals(txtphs));
                var txtpflete = (parseFloat(datosParamFijos.flete) * 100) / parseFloat(txtpreprom);
                pnlTablero.find("#fletePor1").val(toFormattedPorcentDecimals(txtpflete));
                var txtpgastos = (parseFloat(txttotalGastos) * 100) / parseFloat(txtpreprom);
                pnlTablero.find("#GastoProdPor1").val(toFormattedPorcentDecimals(txtpgastos));
                var txtput = (parseFloat(txtsubt8) * 100) / parseFloat(txtsubt99);
                pnlTablero.find("#utilidPor1").val(toFormattedPorcentDecimals(txtput));
                var txtpds = (parseFloat(txtdsfinal) * 100) / parseFloat(txtpreprom);
                pnlTablero.find("#descPor1").val(toFormattedPorcentDecimals(txtpds));
                var txtpcm = (parseFloat(txtcmfinal) * 100) / parseFloat(txtpreprom);
                pnlTablero.find("#comicPor1").val(toFormattedPorcentDecimals(txtpcm));

                // ------------------------------- TOTALES COLUMNA 2 CON PRECIO AUTORIZADO---------------------------------

                pnlTablero.find("#mextr2").val(toFormattedNumber(datosParamFijos.mextr));
                pnlTablero.find("#mp2").val(toFormattedNumber(datosParamFijos.matpri));
                var txttol99 = parseFloat(datosParamFijos.matpri) + parseFloat(datosParamFijos.mextr);
                var txttol1 = parseFloat(txttol99) * parseFloat(datosParamFijos.toler);
                pnlTablero.find("#tolera22").val(toFormattedNumber(txttol1));
                pnlTablero.find("#mo2").val(toFormattedNumber(datosParamFijos.maob));
                pnlTablero.find("#tejida22").val(toFormattedNumber(datosParamFijos.tejida));


                var txtctopro1 = parseFloat(datosParamFijos.preaut) - parseFloat(datosParamFijos.matpri) - parseFloat(datosParamFijos.mextr) - parseFloat(datosParamFijos.maob) -
                        parseFloat(datosParamFijos.tejida) - parseFloat(txttol);

                pnlTablero.find("#costoProd2").val(toFormattedNumber(txtctopro1));

                pnlTablero.find("#gfabri22").val(toFormattedNumber(datosParamFijos.gfabri));
                pnlTablero.find("#gvta22").val(toFormattedNumber(datosParamFijos.gvta));
                pnlTablero.find("#gadmon22").val(toFormattedNumber(datosParamFijos.gadmon));
                pnlTablero.find("#hms22").val(toFormattedNumber(datosParamFijos.hms));
                pnlTablero.find("#flete22").val(toFormattedNumber(datosParamFijos.flete));



                /*Llena los campos de gastos*/
                var txttotalGastos2 = parseFloat(datosParamFijos.gvta) + parseFloat(datosParamFijos.gadmon) + parseFloat(datosParamFijos.gfabri) +
                        parseFloat(datosParamFijos.hms) + parseFloat(datosParamFijos.flete);
                pnlTablero.find("#GastoProd2").val(toFormattedNumber(txttotalGastos2));



                var txtsubt1 = parseFloat(txtctopro1) - parseFloat(datosParamFijos.gfabri) - parseFloat(datosParamFijos.gvta) - parseFloat(datosParamFijos.gadmon) - parseFloat(datosParamFijos.hms) - parseFloat(datosParamFijos.flete);
                pnlTablero.find("#subtotal2").val(toFormattedNumber(txtsubt1));

                var txtds1 = parseFloat(datosParamFijos.preaut) * parseFloat(datosParamFijos.desc);
                var txtcm1 = parseFloat(datosParamFijos.preaut) * parseFloat(datosParamFijos.comic);
                pnlTablero.find("#desc22").val(toFormattedNumber(txtds1));
                pnlTablero.find("#comic22").val(toFormattedNumber(txtcm1));

                var txtutreal = txtsubt1 - txtds1 - txtcm1;
                pnlTablero.find("#utilidReal").val(toFormattedNumber(txtutreal));

                // --------------------- PORCENTAJES COLUMNA 3 --------------------
                var txtpmp1 = (parseFloat(datosParamFijos.matpri) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#mpPor2").val(toFormattedPorcentDecimals(txtpmp1));
                var txtpmextr1 = (parseFloat(datosParamFijos.mextr) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#mextrPor2").val(toFormattedPorcentDecimals(txtpmextr1));
                var txtptl1 = (parseFloat(txttol1) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#toleraPor2").val(toFormattedPorcentDecimals(txtptl1));
                var txtpmo1 = (parseFloat(datosParamFijos.maob) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#moPor2").val(toFormattedPorcentDecimals(txtpmo1));
                var txtptj1 = (parseFloat(datosParamFijos.tejida) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#tejidaPor2").val(toFormattedPorcentDecimals(txtptj1));
                var txtpctopro1 = (parseFloat(txtctopro1) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#costoProdPor2").val(toFormattedPorcentDecimals(txtpctopro1));
                var txtpgf1 = (parseFloat(datosParamFijos.gfabri) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#gfabriPor2").val(toFormattedPorcentDecimals(txtpgf1));
                var txtpgv1 = (parseFloat(datosParamFijos.gvta) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#gvtaPor2").val(toFormattedPorcentDecimals(txtpgv1));
                var txtpga1 = (parseFloat(datosParamFijos.gadmon) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#gadmonPor2").val(toFormattedPorcentDecimals(txtpga1));
                var txtphs1 = (parseFloat(datosParamFijos.hms) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#hmsPor2").val(toFormattedPorcentDecimals(txtphs1));
                var txtpflete1 = (parseFloat(datosParamFijos.flete) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#fletePor2").val(toFormattedPorcentDecimals(txtpflete1));
                var txtpgastos2 = (parseFloat(txttotalGastos2) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#GastoProdPor2").val(toFormattedPorcentDecimals(txtpgastos2));
                var txtpds1 = (parseFloat(txtds1) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#descPor2").val(toFormattedPorcentDecimals(txtpds1));
                var txtpcm1 = (parseFloat(txtcm1) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#comicPor2").val(toFormattedPorcentDecimals(txtpcm1));

                console.log(parseFloat(txtds1));
                console.log(parseFloat(datosParamFijos.preaut));
                var txtputreal = (parseFloat(txtutreal) * 100) / parseFloat(datosParamFijos.preaut);
                pnlTablero.find("#porUtilidReal").val(toFormattedPorcentDecimals(txtputreal));

                //Establecemos foco en pre-aut
                pnlTablero.find("#PreAutori").focus().select();
            }).fail(function (x) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });

        });
        pnlTablero.find('#PreAutori').keypress(function (e) {
            if (e.keyCode === 13) {
                if (estiloS.length > 0) {
                    if ($(this).val()) {
                        $.post(master_url + 'onActualizarPrecioAutorizado', {PrecioAut: $(this).val(), Linea: lineaS, Lista: listaS, Estilo: estiloS, Color: colorS}).done(function (data) {
                            Registros.ajax.reload();
                            estiloS = 0;
                            onNotifyOld('fa fa-check', 'PRECIO GUARDADO CORRECTAMENTE', 'success');
                            pnlTablero.find('#PreAutori').focus().select();
                        }).fail(function (x) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x.responseText);
                        });
                    }
                } else {
                    swal('ATENCIÓN', 'DEBES DE SELECCIONAR UN ESTILO', 'warning').then((value) => {
                        pnlTablero.find('#PreAutori').focus().select();
                    });
                }
            }
        });
    });
    function obtenerInfoInicial(linea, lista, corrida) {
        var pretot = 0;
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
            var totalEstilos = registros + 1;
            //Llenamos los campos con los datos
            pnlTablero.find('#PrecioPromFinal').val('$' + $.number(parseFloat(pretot / totalEstilos), 2, '.', ','));
            pnlTablero.find('#TotEstilos').val(totalEstilos);
            $('#tblRegistrosGenCostos_filter input[type=search]').focus();
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
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
                pnlTablero.find('#Linea').focus();
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
                pnlTablero.find('#Linea').focus();
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
                pnlTablero.find('#Linea').focus();
            });
        }
    }
    function init() {
        pnlTablero.find('#Linea').focus();
        pnlTablero.find("select").selectize();
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
            "dom": 'frt', buttons: buttons,
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
                },
                {
                    "targets": [0, 1, 4, 7],
                    "visible": false,
                    "searchable": false
                }
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            c.addClass('text-strong');
                            break;
                        case 1:
                            c.addClass('text-info text-strong');
                            break;
                        case 2:
                            c.addClass('text-info text-strong');
                            break;
                        case 7:
                            c.addClass('text-strong text-warning');
                            break;
                        case 8:
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
            "scrollY": 550,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [2, 'asc'], [3, 'asc']
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
                pnlTablero.find('#ListaPrecios').focus();
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
                pnlTablero.find('#Linea').focus();
            });
        }
    }
    function toFormattedNumber(number) {
        return '$' + $.number(parseFloat(number), 2, '.', ',');
    }
    function toFormattedPorcent(number) {
        return  $.number(parseFloat(number), 0, '.', ',') + '%';
    }
    function toFormattedPorcentDecimals(number) {
        return  $.number(parseFloat(number), 2, '.', ',') + '%';
    }
</script>
<style>

    #marcoFoto {width: 280px; height:265px; position: absolute; top: 60%; left:59%; z-index: 999;background-color: #FFF;}
    .top {z-index: 2; position: relative}
    .bottom {z-index: 1; position: relative}

    .close-icon {
        cursor: pointer;
    }
    .card-bodyFoto {
        padding: .5em !important;
    }
    .card-headerFoto {
        padding: 0.35rem 1rem;
    }

    .cardFoto {
        box-shadow: 0 8px 14px rgba(0,0,0,0.20), 0 8px 14px rgba(0,0,0,0.20)!important;
    }

    .text-strong {
        font-weight: bolder;
    }

    table tbody tr {
        font-size: 0.85rem !important;
    }

    div.datatable-wide {
        padding-left: 0;
        padding-right: 0;
    }
    .verdemas{
        background-color: #9CD985 !important;
    }

    .lila{

        background-color: #EF85FA !important;
    }
    .amarillo{

        background-color: #FAE985 !important;
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
        margin-top: 0.12rem;
        margin-bottom: 0.0rem;
    }

    .form-control-sm,  .form-control {
        padding: 0.15rem 0.5rem;
        margin-top:  0.08rem;
        margin-bottom: 0.08rem;
        font-weight: bold;
        font-size: 0.85rem !important;
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
