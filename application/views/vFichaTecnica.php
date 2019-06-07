<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Fichas Técnicas</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-primary" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar"><span class="fa fa-plus"></span><br></button>
            </div>
        </div>
        <div class="card-block">
            <div class="table-responsive" id="FichaTecnica">
                <table id="tblFichaTecnica" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>EstiloId</th>
                            <th>ColorId</th>
                            <th>Estilo</th>
                            <th>Color</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--GUARDAR-->
<div class="card border-0 m-3 d-none animated fadeIn" style="z-index: 99 !important" id="pnlDatos">
    <div class="card-body text-dark">
        <form id="frmNuevo">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-2 float-left">
                    <legend class="float-left">Ficha Técnica</legend>
                </div>

                <div class="col-12 col-sm-12 col-md-10" align="right">



                    <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                        <span class="fa fa-arrow-left" ></span> REGRESAR
                    </button>
                    <button type="button" class="btn btn-danger btn-sm d-none" id="btnEliminar">
                        <span class="fa fa-trash fa-1x"></span> ELIMINAR
                    </button>
                    <button type="button" class="btn btn-warning btn-sm d-none" id="btnImprimirFichaTecnica">
                        <span class="fa fa-file-invoice fa-1x"></span> FRACCIONES POR ESTILO
                    </button>
                </div>

            </div>

            <div class=" row">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center my-2">
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnColor" >
                        <span class="fa fa-fill-drip"></span> Color comb.
                    </button>
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnArticulos" >
                        <span class="fa fa-swatchbook"></span> Articulos
                    </button>
                    <button type="button" class="btn btn-danger btn-sm my-1" id="btnEliminarFT" >
                        <span class="fa fa-trash-alt"></span> Elimina F.T.
                    </button>
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnEstilos" >
                        <span class="fa fa-palette"></span> Estilos
                    </button>
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnImprimeCostoFT" data-toggle="modal" data-target="#mdlFichaTecnicaCompra">
                        <span class="fa fa-palette"></span> Imp.costo F.T
                    </button>
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnFotos" >
                        <span class="fa fa-images"></span> Fotos
                    </button>
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnCopyFTaFT" >
                        <span class="fa fa-paste"></span> Copy F.T - F.T
                    </button>
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnMatSemProd" data-toggle="modal" data-target="#mdlMaterialSemanaProduccionEstilo">
                        <span class="fa fa-boxes"></span> Mat.sem.Prod
                    </button>   
                    <button type="button" class="btn btn-danger btn-sm my-1" id="btnAdicionaMaterialFijo" disabled="">
                        <span class="fa fa-plus"></span> Adiciona material fijo
                    </button>   
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnSupleMaFT " data-toggle="modal" data-target="#mdlSuplePiezaEnFT">
                        <span class="fa fa-magic"></span> Suple pieza x pieza en F.T
                    </button>      
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnSupleMaFT " data-toggle="modal" data-target="#mdlSupleMaterialEnFT">
                        <span class="fa fa-magic"></span> Suple mat
                    </button>             
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnSupleMaXLinFTLinea" data-toggle="modal" data-target="#mdlSupleMaterialEnFTXLinea">
                        <span class="fa fa-magic"></span> Suple mat X linea
                    </button>     
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnArtConsumoXEstiloColor" data-toggle="modal" data-target="#mdlArticuloYConsumoXEstiloColor">
                        <span class="fa fa-chart-pie"></span> Art. y consumo x estilo color
                    </button> 
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnActualizaConsumoEstiloFT">
                        <span class="fa fa-band-aid"></span> Actualiza consumo estilo/ficha técnica
                    </button>
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnAdicionaMatXLin" data-toggle="modal" data-target="#mdlAdicionaMaterialXLinea">
                        <span class="fa fa-capsules"></span> Adiciona material X linea
                    </button>
                </div>

                <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                    <label for="Estilo">Estilo*</label>
                    <select class="form-control form-control-sm required " id="Estilo" name="Estilo" required>
                    </select>
                </div>
                <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                    <label for="Color">Color*</label>
                    <select class="form-control form-control-sm required " id="Color" name="Color" required>
                    </select>
                </div>
                <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                    <label for="FechaAlta">Fecha de alta</label>
                    <input type="text" class="form-control form-control-sm notEnter" id="FechaAlta" name="FechaAlta"  >
                </div>
            </div>
        </form>
        <!--AGREGAR DETALLE-->
        <div class="d-none" id="pnlControlesDetalle">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-4 col-lg-2">
                    <label for="Pieza">Pieza</label>
                    <select class="form-control form-control-sm" id="Pieza"  name="Pieza">
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-2">
                    <label for="Articulo">Articulo</label>
                    <select class="form-control form-control-sm" id="Articulo"   name="Articulo">
                        <option value=""></option>
                    </select>
                </div>

                <div class="col-12 col-sm-12 col-md-4 col-lg-2">
                    <label for="Consumo">PzXPar</label>
                    <input type="text" id="PzXPar" name="PzXPar" class="form-control form-control-sm numbersOnly" maxlength="4">
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-2">
                    <label for="Consumo">Consumo</label>
                    <input type="text"  id="Consumo" name="Consumo" class="form-control form-control-sm numbersOnly" maxlength="7">
                </div>

                <div class="col-12 col-sm-12 col-md-4 col-lg-2">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="Consumo">Afecta PV</label>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="AfectaPV" name="AfectaPV" >
                                <label class="custom-control-label" for="AfectaPV"></label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <button type="button" id="btnAgregar" class="btn btn-primary mt-4"><span class="fa fa-save"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--DETALLE-->
<div class="card d-none m-3 animated fadeIn" id="pnlDetalle">
    <div class="card-body" >
        <!--DETALLE-->
        <div class="row">
            <div class=" col-md-9 ">
                <div class="row">
                    <div class="table-responsive" id="FichaTecnicaDetalle">
                        <table id="tblFichaTecnicaDetalle" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Pieza_ID</th>
                                    <th>Pieza</th>
                                    <th>Articulo_ID</th>

                                    <th>Articulo</th>
                                    <th>Unidad</th>


                                    <th>Consumo</th>

                                    <th>PzaXPar</th>


                                    <th>ID</th>
                                    <th>Eliminar</th>
                                    <th>DeptoCat</th>
                                    <th>DEP</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <label for="">Fotografía</label>
                <div id="VistaPrevia" >
                    <img src="<?php echo base_url(); ?>img/camera.png" class="img-thumbnail img-fluid"/>
                </div>
            </div>
        </div>
        <!--FIN DETALLE-->
    </div>
</div>

<!--EDITAR RENGLON-->
<div class="modal " id="mdlEditarArticulo"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edición</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmEditarRenglon">
                    <div class="d-none">
                        <input type="text"  name="ID" class="form-control form-control-sm" >
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Pieza</label>
                            <select class="form-control form-control-sm required disabledForms" id="ePieza" name="Pieza" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Articulo</label>
                            <select class="form-control form-control-sm required" id="eArticulo"   name="eArticulo">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                            <label for="Consumo">PzXPar</label>
                            <input type="text" id="ePzXPar" name="PzXPar" class="form-control form-control-sm numbersOnly"  maxlength="4">
                        </div>
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                            <label for="Consumo">Consumo</label>
                            <input type="text"  id="eConsumo" name="Consumo" class="form-control form-control-sm numbersOnly" required="" maxlength="7">
                        </div>
                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                            <label for="Consumo">Afecta PV</label>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="eAfectaPV" name="AfectaPV" >
                                <label class="custom-control-label" for="eAfectaPV"></label>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnEditarRenglon">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>

<!--SCRIPT-->
<div class="modal" id="mdlEstilosFotos">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ESTILOS (FOTO)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <select id="EstiloFoto" name="EstiloFoto" class="form-control"></select>
                    </div>
                    <div class="col-8 text-center">
                        <a href="<?php print base_url('img/LS.png'); ?>"  data-fancybox="images" data-caption="">
                            <img src="<?php print base_url('img/LS.png'); ?>" class="img-thumbnail" id="imgsrc" >
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal animated flipInX" id="mdlEliminaFTXEstilo">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar fichas tecnicas x estilo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-10">
                        <input type="text" id="EstiloElimina" name="EstiloElimina" autofocus="" class="form-control" placeholder="Estilo...">
                    </div>
                    <div class="col-2">
                        <button type="button" id="btnEliminarFichasXEstilo" class="btn btn-danger">
                            <span class="fa fa-trash"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal animated fadeIn" id="mdlCopiarFT">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Copia ficha tecnica a ficha tecnica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <p class="text-danger font-weight-bold">Copiar Estilo/Color </p>
                    </div>
                    <div class="col-12">
                        <label>Estilo</label>
                        <input type="text" id="EstiloACopiar" name="EstiloACopiar" class="form-control" maxlength="8" placeholder="Estilo...">
                    </div>
                    <div class="col-12">
                        <label>Color</label>
                        <input type="text" id="ColorACopiar" name="ColorACopiar" class="form-control" maxlength="4" placeholder="Color...">
                    </div>
                    <div class="col-12 my-2">
                        <p class="text-danger font-weight-bold">Al Estilo/Color</p>
                    </div>
                    <div class="col-12">
                        <label>Estilo</label>
                        <input type="text" id="EstiloAReemplazar" name="EstiloAReemplazar" class="form-control" maxlength="8" placeholder="Estilo...">
                    </div> 
                    <div class="col-12">
                        <label>Color</label>
                        <input type="text" id="ColorAReemplazar" name="ColorAReemplazar" class="form-control" maxlength="4" placeholder="Color...">
                    </div> 
                </div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-primary" id="btnAceptar">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal animated fadeIn" id="mdlSuplePiezaEnFT">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-retweet"></span> Suple piezas en ficha tecnica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-5">
                        <label>Pieza a suplir</label>
                        <select id="PiezaASuplir" name="PiezaASuplir" class="form-control"></select>
                    </div>  
                    <div class="col-5">
                        <label>Pieza nueva</label>
                        <select id="PiezaNueva" name="PiezaNueva" class="form-control"></select>
                    </div>
                    <div class="col-2">
                        <button type="button" id="btnSuplirPieza" name="btnSuplirPieza" class="btn btn-info-blue mt-3">
                            Suplir
                        </button>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 text-center mt-2">
                        <p class="text-danger font-weight-bold">Detalle de la ficha técnica</p>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblDetalleFT" class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Estilo</th>
                                    <th scope="col">Col</th>
                                    <th scope="col">Pza</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Sec</th>
                                    <th scope="col">Art</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Cons</th>
                                    <th scope="col">Rango</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>  
                </div>
                <div class="modal-footer"> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal animated fadeIn" id="mdlSupleMaterialEnFT">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-retweet"></span> Suple material en ficha tecnica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-5">
                        <label>Material a suplir</label>
                        <select id="MaterialASuplir" name="MaterialASuplir" class="form-control"></select>
                    </div>  
                    <div class="col-5">
                        <label>Material nuevo</label>
                        <select id="MaterialNuevo" name="MaterialNuevo" class="form-control"></select>
                    </div>
                    <div class="col-2">
                        <button type="button" id="btnSuplirMaterial" name="btnSuplirMaterial" class="btn btn-info-blue mt-3">
                            Suplir
                        </button>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 text-center mt-2">
                        <p class="text-danger font-weight-bold">Detalle de la ficha técnica</p>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblDetalleFTMaterial" class="table table-hover table-sm" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Estilo</th>
                                    <th scope="col">Col</th>
                                    <th scope="col">Pza</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Sec</th>
                                    <th scope="col">Art</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Cons</th>
                                    <th scope="col">Rango</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>  
                </div>
                <div class="modal-footer"> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal animated fadeIn" id="mdlSupleMaterialEnFTXLinea">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-retweet"></span> Suple material en ficha tecnica x linea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label>Linea</label>
                        <select id="LineaDefinidora" name="LineaDefinidora" class="form-control"></select>
                    </div>  
                    <div class="w-100"></div>
                    <div class="col-5">
                        <label>Material a suplir</label>
                        <select id="MaterialASuplirXLinea" name="MaterialASuplirXLinea" class="form-control"></select>
                    </div>  
                    <div class="col-5">
                        <label>Material nuevo</label>
                        <select id="MaterialNuevoXLinea" name="MaterialNuevoXLinea" class="form-control"></select>
                    </div>  
                    <div class="col-2">
                        <label>Consumo</label>
                        <input type="text" id="ConsumoXLinea" name="ConsumoXLinea" class="form-control form-control-sm numbersOnly" maxlength="8">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12" align="right">
                        <button type="button" id="btnSuplirMaterialXLinea" name="btnSuplirMaterialXLinea" class="btn btn-info-blue mt-3">
                            Suplir
                        </button>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 text-center">
                        <p class="text-danger font-weight-bold">Detalle de la ficha técnica</p>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblDetalleFTMaterialXLinea" class="table table-hover table-sm" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Estilo</th>
                                    <th scope="col">Col</th>
                                    <th scope="col">Pza</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Sec</th>
                                    <th scope="col">Art</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Cons</th>
                                    <th scope="col">Rango</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>  
                </div>
                <div class="modal-footer"> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal animated fadeIn" id="mdlArticuloYConsumoXEstiloColor">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-retweet"></span> Suple consumo x estilo, pieza y material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <label>Estilo</label>
                        <select id="EstiloConsumo" name="EstiloConsumo" class="form-control"></select>
                    </div>
                    <div class="col-4">
                        <label>Pieza</label>
                        <select id="PiezaConsumo" name="PiezaConsumo" class="form-control"></select>
                    </div>
                    <div class="col-4">
                        <label>Material</label>
                        <select id="MaterialConsumo" name="MaterialConsumo" class="form-control"></select>
                    </div>
                    <div class="col-4">
                        <label>Consumo</label>
                        <input type="text" id="ConsumoXLineaEstiloColor" name="ConsumoXLineaEstiloColor" class="form-control form-control-sm numbersOnly" maxlength="8">
                    </div>
                    <div class="col-4">
                        <label>Consumo nuevo</label>
                        <input type="text" id="ConsumoNuevoXLineaEstiloColor" name="ConsumoNuevoXLineaEstiloColor" class="form-control form-control-sm numbersOnly" maxlength="8">
                    </div>
                    <div class="col-4" align="center">
                        <button type="button" id="btnSupleConsumo" name="btnSupleConsumo" class="btn btn-info-blue mt-4">
                            Suplir
                        </button>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 text-center">
                        <p class="text-danger font-weight-bold">Detalle de la ficha técnica</p>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblDetalleFTConsumo" class="table table-hover table-sm" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Estilo</th>
                                    <th scope="col">Col</th>
                                    <th scope="col">Pza</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Sec</th>
                                    <th scope="col">Art</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Cons</th>
                                    <th scope="col">Rango</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>  
                </div>
                <div class="modal-footer"> 
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal animated fadeIn" id="mdlAdicionaMaterialXLinea">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-retweet"></span> Adiciona material x linea en ficha técnica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <label>Linea</label>
                        <select id="LineaAdiciona" name="LineaAdiciona" class="form-control"></select>
                    </div>
                    <div class="col-4">
                        <label>Pieza</label>
                        <select id="PiezaAdiciona" name="PiezaAdiciona" class="form-control"></select>
                    </div>
                    <div class="col-4">
                        <label>Articulo</label>
                        <select id="ArticuloAdiciona" name="ArticuloAdiciona" class="form-control"></select>
                    </div>
                    <div class="col-4">
                        <label>Consumo</label>
                        <input type="text" id="ConsumoAdiciona" name="ConsumoAdiciona" class="form-control form-control-sm numbersOnly">
                    </div>
                    <div class="col-4">
                        <label>Piezas x par</label>
                        <input type="text" id="PiezasXParAdiciona" name="PiezasXParAdiciona" class="form-control form-control-sm numbersOnly" maxlength="8">
                    </div>
                    <div class="col-12" align="right">
                        <button type="button" id="btnAdiciona" name="btnAdiciona" class="btn btn-info-blue mt-4">
                            Adiciona
                        </button>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 text-center">
                        <p class="text-danger font-weight-bold">Detalle de la ficha técnica</p>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblDetalleFTAdiciona" class="table table-hover table-sm" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Linea</th>
                                    <th scope="col">Estilo</th>
                                    <th scope="col">Col</th>
                                    <th scope="col">Pza</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Sec</th>
                                    <th scope="col">Art</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Cons</th>
                                    <th scope="col">Rango</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>  
                </div>
                <div class="modal-footer"> 
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var hoy = '<?php print Date('d/m/Y'); ?>';
    var master_url = base_url + 'index.php/FichaTecnica/';
    var pnlDatos = $("#pnlDatos");
    var pnlControlesDetalle = $('#pnlControlesDetalle');
    var pnlTablero = $("#pnlTablero");
    var pnlDetalle = $("#pnlDetalle");
    var btnNuevo = $("#btnNuevo");
    var btnCancelar = pnlDatos.find("#btnCancelar");
    var btnEliminar = $("#btnEliminar");
    var Estilo = pnlDatos.find("#Estilo");
    var Color = pnlDatos.find("#Color");
    var IdMovimiento = 0;
    var nuevo = true;
    var btnAgregar = pnlControlesDetalle.find("#btnAgregar");

    var tblFichaTecnicaDetalle = pnlDetalle.find('#tblFichaTecnicaDetalle');
    var FichaTecnicaDetalle;
    var tblFichaTecnica = $('#tblFichaTecnica');
    var FichaTecnica;
    var mdlEditarArticulo = $('#mdlEditarArticulo');
    var btnEditarRenglon = mdlEditarArticulo.find('#btnEditarRenglon');
    var FechaAlta = pnlDatos.find("#FechaAlta");
    var Selectizer = function () {
        return {
            loadOptions: function (query, callback) {

                if (query.length >= 2) {
                    //HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                    $.ajax({
                        url: this.settings.remoteUrl,
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            Articulo: query
                        }
                    }).done(function (data, x, jq) {
                        callback(data);
                        //HoldOn.close();
                    }).fail(function (x, y, z) {
                        callback();
                        console.log(x, y, z);
                        //HoldOn.close();
                    }).always(function () {
                    });

                } else {
                    return callback();
                }
            },
            renderOptions: function (data, escape) {
                return '<div class="list-group" style="border-bottom: 0.5px solid #000;">' +
                        '<div class="d-flex w-100 justify-content-between">' +
                        '<span class="text-dark" style="font-size: 14px;"><strong>' + data.Clave + '</strong></span>' +
                        // '<p><strong>' + data.Clave + '</strong></p>' +
                        '</div>' +
                        '<span class="text-info" style="font-size: 13px;"><strong>' + data.Articulo + '</strong></span>' +
                        '</div>';
            }
        };
    }();

    var btnArticulos = pnlDatos.find("#btnArticulos"),
            btnEstilos = pnlDatos.find("#btnEstilos"),
            btnColor = pnlDatos.find("#btnColor"),
            btnEliminarFT = pnlDatos.find("#btnEliminarFT"),
            btnFotos = pnlDatos.find("#btnFotos"), btnCopyFTaFT = pnlDatos.find("#btnCopyFTaFT"),
            mdlEstilosFotos = $("#mdlEstilosFotos"),
            EstiloFotos = mdlEstilosFotos.find("#EstiloFoto"),
            mdlEliminaFTXEstilo = $("#mdlEliminaFTXEstilo"),
            mdlCopiarFT = $("#mdlCopiarFT"), btnAceptarCopiar = mdlCopiarFT.find("#btnAceptar"),
            btnMatSemProd = pnlDatos.find("#btnMatSemProd"), mdlSuplePiezaEnFT = $("#mdlSuplePiezaEnFT"),
            PiezaASuplir = mdlSuplePiezaEnFT.find("#PiezaASuplir"), PiezaNueva = mdlSuplePiezaEnFT.find("#PiezaNueva"),
            btnSuplirPieza = mdlSuplePiezaEnFT.find("#btnSuplirPieza"),
            tblDetalleFT = mdlSuplePiezaEnFT.find("#tblDetalleFT"), DetalleFT,
            mdlSupleMaterialEnFT = $("#mdlSupleMaterialEnFT"), MaterialASuplir = mdlSupleMaterialEnFT.find("#MaterialASuplir"),
            MaterialNuevo = mdlSupleMaterialEnFT.find("#MaterialNuevo"),
            btnSuplirMaterial = mdlSupleMaterialEnFT.find("#btnSuplirMaterial"),
            tblDetalleFTMaterial = mdlSupleMaterialEnFT.find("#tblDetalleFTMaterial"), DetalleFTMaterial;
    var mdlSupleMaterialEnFTXLinea = $("#mdlSupleMaterialEnFTXLinea"),
            MaterialASuplirXLinea = mdlSupleMaterialEnFTXLinea.find("#MaterialASuplirXLinea"),
            MaterialNuevoXLinea = mdlSupleMaterialEnFTXLinea.find("#MaterialNuevoXLinea"),
            btnSuplirMaterialXLinea = mdlSupleMaterialEnFTXLinea.find("#btnSuplirMaterialXLinea"),
            tblDetalleFTMaterialXLinea = mdlSupleMaterialEnFTXLinea.find("#tblDetalleFTMaterialXLinea"),
            LineaDefinidora = mdlSupleMaterialEnFTXLinea.find("#LineaDefinidora"), ConsumoXLinea = mdlSupleMaterialEnFTXLinea.find("#ConsumoXLinea"),
            DetalleFTMaterialXLinea;

    var mdlArticuloYConsumoXEstiloColor = $("#mdlArticuloYConsumoXEstiloColor"),
            EstiloConsumo = mdlArticuloYConsumoXEstiloColor.find("#EstiloConsumo"),
            PiezaConsumo = mdlArticuloYConsumoXEstiloColor.find("#PiezaConsumo"),
            MaterialConsumo = mdlArticuloYConsumoXEstiloColor.find("#MaterialConsumo"),
            ConsumoXLineaEstiloColor = mdlArticuloYConsumoXEstiloColor.find("#ConsumoXLineaEstiloColor"),
            ConsumoNuevoXLineaEstiloColor = mdlArticuloYConsumoXEstiloColor.find("#ConsumoNuevoXLineaEstiloColor"),
            btnSupleConsumo = mdlArticuloYConsumoXEstiloColor.find("#btnSupleConsumo"),
            tblDetalleFTConsumo = mdlArticuloYConsumoXEstiloColor.find("#tblDetalleFTConsumo"),
            DetalleFTConsumo;

    var mdlAdicionaMaterialXLinea = $("#mdlAdicionaMaterialXLinea"),
            LineaAdiciona = mdlAdicionaMaterialXLinea.find("#LineaAdiciona"),
            PiezaAdiciona = mdlAdicionaMaterialXLinea.find("#PiezaAdiciona"),
            ArticuloAdiciona = mdlAdicionaMaterialXLinea.find("#ArticuloAdiciona"),
            ConsumoAdiciona = mdlAdicionaMaterialXLinea.find("#ConsumoAdiciona"),
            btnAdiciona = mdlAdicionaMaterialXLinea.find("#btnAdiciona"),
            tblDetalleFTAdiciona = mdlAdicionaMaterialXLinea.find("#tblDetalleFTAdiciona"),
            DetalleFTAdiciona;

    var btnAdicionaMaterialFijo = pnlDatos.find("#btnAdicionaMaterialFijo");

    var onSuplirConsumo = function () {
        if (EstiloConsumo.val() && PiezaConsumo.val() &&
                MaterialConsumo.val() && ConsumoXLineaEstiloColor.val() &&
                ConsumoNuevoXLineaEstiloColor.val()) {
            btnSupleConsumo.attr('disabled', false);
        } else {
            btnSupleConsumo.attr('disabled', true);
        }
    };

    $(document).ready(function () {

        btnAdicionaMaterialFijo.click(function () {
            if (Estilo.val() && Color.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Trabajando en ello... por favor espere'
                });
                $.post('<?php print base_url('FichaTecnica/getFichaTecnicaFija'); ?>', {ESTILO: Estilo.val(), COLOR: Color.val()}).done(function (a) {
                    console.log(a);
                    var dtm = {
                        EstiloId: Estilo.val(),
                        ColorId: Color.val()
                    };
                    getFichaTecnicaByEstiloByColor(dtm);
                    btnAdicionaMaterialFijo.attr('disabled', true);
                    swal('ATENCIÓN', 'SE HA GUARDADO LA FICHA TECNICA CON LOS MATERIALES FIJOS', 'success').then((value) => {
                        pnlControlesDetalle.find("[name='Pieza']")[0].selectize.focus();
                    });
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR EL ESTILO, COLOR Y FECHA DE ALTA', 'warning');
            }
        });

        btnAdiciona.click(function () {
            if (LineaAdiciona.val() && PiezaAdiciona.val() && ArticuloAdiciona.val()) {

            } else {
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR LA LINEA, PIEZA, ARTICULO/MATERIAL, CONSUMO Y EL NUEVO CONSUMO', 'warning');
            }
        });

        ArticuloAdiciona.change(function () {
            if ($(this).val()) {
                DetalleFTAdiciona.ajax.reload();
            }
        });

        PiezaAdiciona.change(function () {
            if ($(this).val()) {
                DetalleFTAdiciona.ajax.reload();
            }
        });

        LineaAdiciona.change(function () {
            if ($(this).val()) {
                DetalleFTAdiciona.ajax.reload();
            }
        });

        mdlAdicionaMaterialXLinea.on('shown.bs.modal', function () {

            if ($.fn.DataTable.isDataTable('#tblDetalleFTAdiciona')) {
                DetalleFTAdiciona.ajax.reload(function () {
                    HoldOn.close();
                });
            } else {
                var coldefs = [
                    {
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    }
                ];
                DetalleFTAdiciona = tblDetalleFTAdiciona.DataTable({
                    "dom": 'ritp',
                    "ajax": {
                        "url": '<?php print base_url('FichaTecnica/getLineaPiezasMaterialXConsumos'); ?>',
                        "contentType": "application/json",
                        "dataSrc": "",
                        "data": function (d) {
                            d.LINEA = (LineaAdiciona.val() ? LineaAdiciona.val() : '');
                            d.PIEZA = (PiezaAdiciona.val() ? PiezaAdiciona.val() : '');
                            d.MATERIAL = (ArticuloAdiciona.val() ? ArticuloAdiciona.val() : '');
                        }
                    },
                    buttons: buttons,
                    "columns": [
                        {"data": "ID"}/*0*/,
                        {"data": "LINEA"}/*1*/,
                        {"data": "ESTILO"}/*1*/,
                        {"data": "COLOR"}/*2*/,
                        {"data": "PIEZA"}/*4*/,
                        {"data": "PIEZAT"}/*5*/,
                        {"data": "SEC"}/*6*/,
                        {"data": "ARTICULO"}/*7*/,
                        {"data": "ARTICULOT"}/*8*/,
                        {"data": "CONSUMO"}/*10*/,
                        {"data": "RANGO"}/*11*/
                    ],
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
                    "scrollY": "498px",
                    "scrollX": true,
                    "aaSorting": [
                        [0, 'desc']
                    ],
                    initComplete: function () {
                    }
                });
            }
        });

        /*CONSUMO*/
        ConsumoNuevoXLineaEstiloColor.on('keydown keyup', function () {
            onSuplirConsumo();
        });

        ConsumoXLineaEstiloColor.on('keydown keyup', function () {
            onSuplirConsumo();
        });

        btnSupleConsumo.click(function () {
            if (EstiloConsumo.val() && PiezaConsumo.val() &&
                    MaterialConsumo.val() && ConsumoXLineaEstiloColor.val() &&
                    ConsumoNuevoXLineaEstiloColor.val()) {
                $.getJSON('<?php print base_url('FichaTecnica/getNumMaterialesASuplirXConsumo'); ?>', {
                    ESTILO: EstiloConsumo.val(), PZA: PiezaConsumo.val(),
                    MATERIAL: MaterialConsumo.val()
                }).done(function (a) {
                    swal({
                        title: "Se suplirán el consumo de " + a[0].MATERIALES_A_SUPLIR + " materiales/articulos, ¿Estas seguro?",
                        text: "Nota: Esta acción no se puede deshacer",
                        icon: "warning",
                        buttons: {
                            cancelar: {
                                text: "Cancelar",
                                value: "no"
                            },
                            cambiar: {
                                text: "Aceptar",
                                value: "ok"
                            }
                        }
                    }).then((value) => {
                        switch (value) {
                            case "ok":
                                HoldOn.open({
                                    theme: 'sk-rect',
                                    message: 'Supliendo...'
                                });
                                $.post('<?php print base_url('FichaTecnica/onSuplirConsumos'); ?>', {
                                    ESTILO: EstiloConsumo.val(), PIEZA: PiezaConsumo.val(),
                                    MATERIAL: MaterialConsumo.val(), CONSUMO: ConsumoXLinea.val(),
                                    NUEVOCONSUMO: ConsumoNuevoXLineaEstiloColor.val()
                                }).done(function (aa, bb, cc) {
                                    swal('ATENCIÓN', 'SE HAN SUPLIDO  ' + a[0].MATERIALES_A_SUPLIR + '  FICHAS TECNICAS', 'success');
                                }).always(function () {
                                    HoldOn.close();
                                });
                                break;
                            case "cancelar":
                                swal.close();
                                HoldOn.close();
                                break;
                        }
                    });
                }).fail(function (x, y, z) {
                    getError(x);
                });
            } else {
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR TODOS LOS CAMPOS', 'warning');
            }
        });

        MaterialConsumo.change(function () {
            if (EstiloConsumo.val() || PiezaConsumo.val() ||
                    MaterialConsumo.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                DetalleFTConsumo.ajax.reload(function () {
                    HoldOn.close();
                });
            }
        });

        PiezaConsumo.change(function () {
            if (EstiloConsumo.val() || PiezaConsumo.val() ||
                    MaterialConsumo.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                DetalleFTConsumo.ajax.reload(function () {
                    HoldOn.close();
                });
            }
        });

        EstiloConsumo.change(function () {
            if (EstiloConsumo.val() || PiezaConsumo.val() ||
                    MaterialConsumo.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                DetalleFTConsumo.ajax.reload(function () {
                    HoldOn.close();
                });
            }
        });

        mdlArticuloYConsumoXEstiloColor.on('shown.bs.modal', function () {
            btnSupleConsumo.attr('disabled', true);

            EstiloConsumo[0].selectize.clear(true);
            PiezaConsumo[0].selectize.clear(true);
            MaterialConsumo[0].selectize.clear(true);

            if ($.fn.DataTable.isDataTable('#tblDetalleFTConsumo')) {
                DetalleFTConsumo.ajax.reload(function () {
                    HoldOn.close();
                });
            } else {
                var coldefs = [
                    {
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    }
                ];
                DetalleFTConsumo = tblDetalleFTConsumo.DataTable({
                    "dom": 'ritp',
                    "ajax": {
                        "url": '<?php print base_url('FichaTecnica/getPiezasMaterialXConsumos'); ?>',
                        "contentType": "application/json",
                        "dataSrc": "",
                        "data": function (d) {
                            d.ESTILO = (EstiloConsumo.val() ? EstiloConsumo.val() : '');
                            d.PIEZA = (PiezaConsumo.val() ? PiezaConsumo.val() : '');
                            d.MATERIAL = (MaterialConsumo.val() ? MaterialConsumo.val() : '');
                        }
                    },
                    buttons: buttons,
                    "columns": [
                        {"data": "ID"}/*0*/,
                        {"data": "ESTILO"}/*1*/,
                        {"data": "COLOR"}/*2*/,
                        {"data": "PIEZA"}/*4*/,
                        {"data": "PIEZAT"}/*5*/,
                        {"data": "SEC"}/*6*/,
                        {"data": "ARTICULO"}/*7*/,
                        {"data": "ARTICULOT"}/*8*/,
                        {"data": "CONSUMO"}/*10*/,
                        {"data": "RANGO"}/*11*/
                    ],
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
                    "scrollY": "498px",
                    "scrollX": true,
                    "aaSorting": [
                        [0, 'desc']
                    ],
                    initComplete: function () {
                    }
                });
            }
        });
        /*LINEA*/
        btnSuplirMaterialXLinea.click(function () {
            if (LineaDefinidora.val() && MaterialASuplirXLinea.val() && MaterialNuevoXLinea.val()) {
                $.getJSON('<?php print base_url('FichaTecnica/getNumMaterialesASuplirXLinea'); ?>',
                        {
                            LINEA: LineaDefinidora.val(), MATERIAL: MaterialASuplirXLinea.val()
                        }).done(function (a) {
                    if (parseInt(a[0].MATERIALES_A_SUPLIR_X_LIN) > 0) {
                        swal({
                            title: "Se suplirán " + a[0].MATERIALES_A_SUPLIR_X_LIN + " materiales/articulos, ¿Estas seguro?",
                            text: "Nota: Esta acción no se puede deshacer",
                            icon: "warning",
                            buttons: {
                                cancelar: {
                                    text: "Cancelar",
                                    value: "no"
                                },
                                cambiar: {
                                    text: "Aceptar",
                                    value: "ok"
                                }
                            }
                        }).then((value) => {
                            switch (value) {
                                case "ok":
                                    HoldOn.open({
                                        theme: 'sk-rect',
                                        message: 'Supliendo...'
                                    });
                                    $.post('<?php print base_url('FichaTecnica/onSuplirMaterialArticuloXLinea'); ?>', {
                                        LINEA: LineaDefinidora.val(), MATERIAL: MaterialASuplirXLinea.val(),
                                        MATERIALNUEVO: MaterialNuevo.val(), CONSUMO: ConsumoXLinea.val()
                                    }).done(function (aa, bb, cc) {
                                        swal('ATENCIÓN', 'SE HAN SUPLIDO  ' + a[0].MATERIALES_A_SUPLIR_X_LIN + '  FICHAS TECNICAS', 'success');
                                    }).always(function () {
                                        HoldOn.close();
                                    });
                                    break;
                                case "cancelar":
                                    swal.close();
                                    HoldOn.close();
                                    break;
                            }
                        });
                    } else {
                        swal('ATENCIÓN', 'NO EXISTEN MATERIALES A SUPLIR, ELIJA OTRA LINEA U OTRO MATERIAL', 'warning').then((value) => {
                            MaterialASuplirXLinea[0].selectize.focus();
                        });
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR UNA LINEA, UN MATERIAL A SUPLIR Y EL NUEVO MATERIAL, EL CONSUMO PUEDE QUEDAR VACIO EN CASO DE QUE NO QUIERA MODIFICARLO', 'warning');
            }
        });

        MaterialASuplirXLinea.change(function () {
            if ($(this).val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                DetalleFTMaterialXLinea.ajax.reload(function () {
                    HoldOn.close();
                });
            }
        });

        LineaDefinidora.change(function () {
            if ($(this).val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                DetalleFTMaterialXLinea.ajax.reload(function () {
                    HoldOn.close();
                });
            }
        });

        mdlSupleMaterialEnFTXLinea.on('shown.bs.modal', function () {
            MaterialASuplirXLinea[0].selectize.clear(true);
            MaterialNuevoXLinea[0].selectize.clear(true);
            if ($.fn.DataTable.isDataTable('#tblDetalleFTMaterialXLinea')) {
                DetalleFTMaterialXLinea.ajax.reload(function () {
                    HoldOn.close();
                });
            } else {
                var coldefs = [
                    {
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    }
                ];
                DetalleFTMaterialXLinea = tblDetalleFTMaterialXLinea.DataTable({
                    "dom": 'ritp',
                    "ajax": {
                        "url": '<?php print base_url('FichaTecnica/getPiezasMaterialXLinea'); ?>',
                        "contentType": "application/json",
                        "dataSrc": "",
                        "data": function (d) {
                            d.LINEA = (LineaDefinidora.val().trim());
                            d.MATERIAL = (MaterialASuplirXLinea.val().trim());
                        }
                    },
                    buttons: buttons,
                    "columns": [
                        {"data": "ID"}/*0*/,
                        {"data": "ESTILO"}/*1*/,
                        {"data": "COLOR"}/*2*/,
                        {"data": "PIEZA"}/*4*/,
                        {"data": "PIEZAT"}/*5*/,
                        {"data": "SEC"}/*6*/,
                        {"data": "ARTICULO"}/*7*/,
                        {"data": "ARTICULOT"}/*8*/,
                        {"data": "CONSUMO"}/*10*/,
                        {"data": "RANGO"}/*11*/
                    ],
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
                    "scrollY": "498px",
                    "scrollX": true,
                    "aaSorting": [
                        [0, 'desc']
                    ],
                    initComplete: function () {
                    }
                });
            }
        });

        /*MATERIAL*/
        btnSuplirMaterial.click(function () {
            if (MaterialASuplir.val() && MaterialNuevo.val()) {
                $.getJSON('<?php print base_url('FichaTecnica/getNumMaterialesASuplir'); ?>',
                        {MATERIAL: MaterialASuplir.val()}).done(function (a) {
                    console.log(a);
                    if (parseInt(a[0].MATERIALES_A_SUPLIR) > 0) {
                        swal({
                            title: "Se suplirán " + a[0].MATERIALES_A_SUPLIR + " materiales/articulos, ¿Estas seguro?",
                            text: "Nota: Esta acción no se puede deshacer",
                            icon: "warning",
                            buttons: {
                                cancelar: {
                                    text: "Cancelar",
                                    value: "no"
                                },
                                cambiar: {
                                    text: "Aceptar",
                                    value: "ok"
                                }
                            }
                        }).then((value) => {
                            switch (value) {
                                case "ok":
                                    HoldOn.open({
                                        theme: 'sk-rect',
                                        message: 'Supliendo...'
                                    });
                                    $.post('<?php print base_url('FichaTecnica/onSuplirMaterialArticulo'); ?>', {
                                        MATERIAL: MaterialASuplir.val(), MATERIALNUEVO: MaterialNuevo.val()
                                    }).done(function (aa, bb, cc) {
                                        swal('ATENCIÓN', 'SE HAN SUPLIDO  ' + a[0].MATERIALES_A_SUPLIR + '  FICHAS TECNICAS', 'success');
                                    }).always(function () {
                                        HoldOn.close();
                                    });
                                    break;
                                case "cancelar":
                                    swal.close();
                                    HoldOn.close();
                                    break;
                            }
                        });
                    } else {
                        swal('ATENCIÓN', 'NO EXISTEN PIEZAS A SUPLIR, ELIJA OTRA PIEZA', 'warning').then((value) => {
                            MaterialASuplir[0].selectize.focus();
                        });
                    }
                });
            } else {
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR LOS MATERIALES', 'warning');
            }
        });

        MaterialASuplir.change(function () {
            console.log($(this).val());
            if ($(this).val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                DetalleFTMaterial.ajax.reload(function () {
                    HoldOn.close();
                });
            } else {
                DetalleFTMaterial.ajax.reload(function () {
                    HoldOn.close();
                });
            }
        });

        mdlSupleMaterialEnFT.on('shown.bs.modal', function () {
            MaterialASuplir[0].selectize.clear(true);
            MaterialNuevo[0].selectize.clear(true);
            if ($.fn.DataTable.isDataTable('#tblDetalleFTMaterial')) {
                DetalleFTMaterial.ajax.reload(function () {
                    HoldOn.close();
                });
            } else {
                var coldefs = [
                    {
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    }
                ];
                DetalleFTMaterial = tblDetalleFTMaterial.DataTable({
                    "dom": 'ritp',
                    "ajax": {
                        "url": '<?php print base_url('FichaTecnica/getPiezasMaterial'); ?>',
                        "contentType": "application/json",
                        "dataSrc": "",
                        "data": function (d) {
                            d.MATERIAL = (MaterialASuplir.val().trim());
                        }
                    },
                    buttons: buttons,
                    "columns": [
                        {"data": "ID"}/*0*/,
                        {"data": "ESTILO"}/*1*/,
                        {"data": "COLOR"}/*2*/,
                        {"data": "PIEZA"}/*4*/,
                        {"data": "PIEZAT"}/*5*/,
                        {"data": "SEC"}/*6*/,
                        {"data": "ARTICULO"}/*7*/,
                        {"data": "ARTICULOT"}/*8*/,
                        {"data": "CONSUMO"}/*10*/,
                        {"data": "RANGO"}/*11*/
                    ],
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
                    "scrollY": "498px",
                    "scrollX": true,
                    "aaSorting": [
                        [0, 'desc']
                    ],
                    initComplete: function () {
                    }
                });
            }
        });

        btnSuplirPieza.click(function () {
            if (PiezaASuplir.val() && PiezaNueva.val()) {
                $.getJSON('<?php print base_url('FichaTecnica/getNumPiezasASuplir'); ?>',
                        {PZA: PiezaASuplir.val()}).done(function (a) {
                    console.log(a);
                    if (parseInt(a[0].PIEZAS_A_SUPLIR) > 0) {
                        swal({
                            title: "Se suplirán " + a[0].PIEZAS_A_SUPLIR + " piezas, ¿Estas seguro?",
                            text: "Nota: Esta acción no se puede deshacer",
                            icon: "warning",
                            buttons: {
                                cancelar: {
                                    text: "Cancelar",
                                    value: "no"
                                },
                                cambiar: {
                                    text: "Aceptar",
                                    value: "ok"
                                }
                            }
                        }).then((value) => {
                            switch (value) {
                                case "ok":
                                    HoldOn.open({
                                        theme: 'sk-rect',
                                        message: 'Supliendo...'
                                    });
                                    $.post('<?php print base_url('FichaTecnica/onSuplirPieza'); ?>', {
                                        PZA: PiezaASuplir.val(), PZANUEVA: PiezaNueva.val()
                                    }).done(function (aa, bb, cc) {
                                        swal('ATENCIÓN', 'SE HAN SUPLIDO ' + a[0].PIEZAS_A_SUPLIR + ' FICHAS TECNICAS', 'success');
                                    }).always(function () {
                                        HoldOn.close();
                                    });
                                    break;
                                case "cancelar":
                                    swal.close();
                                    HoldOn.close();
                                    break;
                            }
                        });
                    } else {
                        swal('ATENCIÓN', 'NO EXISTEN PIEZAS A SUPLIR, ELIJA OTRA PIEZA', 'warning').then((value) => {
                            PiezaASuplir[0].selectize.focus();
                        });
                    }
                });
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR LAS PIEZAS', 'warning');
            }
        });

        PiezaASuplir.change(function () {
            if ($(this).val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                if ($(this).val()) {
                    DetalleFT.ajax.reload(function () {
                        HoldOn.close();
                    });
                }
            }
        });

        mdlSuplePiezaEnFT.on('shown.bs.modal', function () {
            HoldOn.open({
                theme: 'sk-rect',
                message: 'Cargando...'
            });
            PiezaASuplir[0].selectize.clear(true);
            PiezaNueva[0].selectize.clear(true);
            if ($.fn.DataTable.isDataTable('#tblDetalleFT')) {
                DetalleFT.ajax.reload(function () {
                    HoldOn.close();
                });
            } else {
                var coldefs = [
                    {
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    }
                ];
                DetalleFT = tblDetalleFT.DataTable({
                    "dom": 'ritp',
                    "ajax": {
                        "url": '<?php print base_url('FichaTecnica/getPiezasTable'); ?>',
                        "contentType": "application/json",
                        "dataSrc": "",
                        "data": function (d) {
                            d.PZA = (PiezaASuplir.val().trim());
                        }
                    },
                    buttons: buttons,
                    "columns": [
                        {"data": "ID"}/*0*/,
                        {"data": "ESTILO"}/*1*/,
                        {"data": "COLOR"}/*2*/,
                        {"data": "PIEZA"}/*4*/,
                        {"data": "PIEZAT"}/*5*/,
                        {"data": "SEC"}/*6*/,
                        {"data": "ARTICULO"}/*7*/,
                        {"data": "ARTICULOT"}/*8*/,
                        {"data": "CONSUMO"}/*10*/,
                        {"data": "RANGO"}/*11*/
                    ],
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
                    "scrollY": "498px",
                    "scrollX": true,
                    "aaSorting": [
                        [0, 'desc']
                    ],
                    initComplete: function () {
                        HoldOn.close();
                    }
                });
            }
        });

        btnAceptarCopiar.click(function () {
            HoldOn.open({
                theme: 'sk-rect',
                message: 'Espere...'
            });
            if (mdlCopiarFT.find("#EstiloACopiar").val() && mdlCopiarFT.find("#ColorACopiar").val() &&
                    mdlCopiarFT.find("#ColorAReemplazar").val() && mdlCopiarFT.find("#EstiloAReemplazar").val()) {
                $.getJSON('<?php print base_url('FichaTecnica/getFichasXEstilo'); ?>',
                        {ESTILO: mdlCopiarFT.find("#EstiloAReemplazar").val()}).done(function (a) {
                    console.log(a);
                    if (parseInt(a[0].FICHAS_X_ESTILO) > 0) {
                        swal('ATENCIÓN', 'NO SE PUEDE COPIAR LA FICHA TECNICA DE ESTE ESTILO-COLOR A ESTE ESTILO-COLOR, PORQUE YA TIENE ESTABLECIDAS FICHAS TECNICAS', 'warning').then((value) => {
                            mdlCopiarFT.find("#EstiloACopiar").focus().select();
                        });
                    } else {
                        $.post('<?php print base_url('FichaTecnica/onCopiarFT'); ?>',
                                {
                                    ESTILOACOPIAR: mdlCopiarFT.find("#EstiloACopiar").val(),
                                    COLORACOPIAR: mdlCopiarFT.find("#ColorACopiar").val(),
                                    ESTILO: mdlCopiarFT.find("#EstiloAReemplazar").val(),
                                    COLOR: mdlCopiarFT.find("#ColorAReemplazar").val()
                                }).done(function (a) {
                            console.log(a);
                            swal('ATENCIÓN', 'SE HA COPIADO LA FICHA TÉCNICA CON EL ESTILO ' + mdlCopiarFT.find("#EstiloACopiar").val() + ' COLOR ' + mdlCopiarFT.find("#ColorACopiar").val(), 'warning')
                                    .then((value) => {
                                        mdlCopiarFT.find("#EstiloACopiar").val('');
                                        mdlCopiarFT.find("#ColorACopiar").val('');
                                        mdlCopiarFT.find("#EstiloAReemplazar").val('');
                                        mdlCopiarFT.find("#ColorAReemplazar").val('');
                                    });
                        }).fail(function (x, y, z) {
                            getError(x);
                        });
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                HoldOn.close();
                swal('ATENCIÓN', 'TODOS LOS CAMPOS SON REQUERIDOS', 'warning').then((value) => {
                    mdlCopiarFT.find("#EstiloACopiar").focus().select();
                });
            }
        });

        mdlCopiarFT.on('shown.bs.modal', function () {
            mdlCopiarFT.find("#EstiloACopiar").val('');
            mdlCopiarFT.find("#EstiloACopiar").focus();
        });

        btnCopyFTaFT.click(function () {
            mdlCopiarFT.modal('show');
        });

        mdlEliminaFTXEstilo.find("#btnEliminarFichasXEstilo").click(function () {
            if (mdlEliminaFTXEstilo.find("#EstiloElimina").val()) {
                $.getJSON('<?php print base_url('FichaTecnica/getFichasAEliminarXEstilo'); ?>', {
                    ESTILO: mdlEliminaFTXEstilo.find("#EstiloElimina").val()
                }).done(function (a, b, c) {
                    console.log(a);
                    if (parseInt(a[0].FICHAS_A_ELIMINAR) > 0) {
                        swal({
                            title: "Se eliminarán " + a[0].FICHAS_A_ELIMINAR + " fichas técnicas, ¿Estas seguro?",
                            text: "Nota: Esta acción no se puede deshacer",
                            icon: "warning",
                            buttons: {
                                cancelar: {
                                    text: "Cancelar",
                                    value: "no"
                                },
                                cambiar: {
                                    text: "Aceptar",
                                    value: "ok"
                                }
                            }
                        }).then((value) => {
                            switch (value) {
                                case "ok":
                                    HoldOn.open({
                                        theme: 'sk-rect',
                                        message: 'Eliminando...'
                                    });
                                    $.post('<?php print base_url('FichaTecnica/onEliminarFTXEstilo'); ?>', {
                                        ESTILO: mdlEliminaFTXEstilo.find("#EstiloElimina").val()
                                    }).done(function (aa, bb, cc) {
                                        mdlEliminaFTXEstilo.find("#EstiloElimina").val('');
                                        swal('ATENCIÓN', 'SE HAN ELIMINADO ' + a[0].FICHAS_A_ELIMINAR + ' FICHAS TECNICAS', 'success').then((value) => {
                                            mdlEliminaFTXEstilo.find("#EstiloElimina").focus().select();
                                        });
                                    }).always(function () {
                                        HoldOn.close();
                                    });
                                    break;
                                case "cancelar":
                                    swal.close();
                                    HoldOn.close();
                                    break;
                            }
                        });
                    } else {
                        swal('ATENCION', 'ESTE ESTILO NO TIENE NINGUNA FICHA TECNICA ESTABLECIDA', 'warning').then((value) => {
                            mdlEliminaFTXEstilo.find("#EstiloElimina").focus().select();
                        });
                    }
                });

            } else {
                swal('ATENCION', 'ES NECESARIO ESTABLECER UN ESTILO', 'warning').then((value) => {
                    mdlEliminaFTXEstilo.find("#EstiloElimina").focus().select();
                });
            }
        });

        mdlEliminaFTXEstilo.on('shown.bs.modal', function () {
            mdlEliminaFTXEstilo.find("#EstiloElimina").val('');
            mdlEliminaFTXEstilo.find("#EstiloElimina").focus();
        });

        btnEliminarFT.click(function () {
            mdlEliminaFTXEstilo.modal('show');
            mdlEliminaFTXEstilo.find("#EstiloElimina").focus();
        });

        $.fancybox.defaults.animationEffect = "zoom-in-out";

        mdlEstilosFotos.find('[data-fancybox="images"]').fancybox({
            keyboard: true,
            arrows: true,
            transitionEffect: "rotate",
            buttons: true
        });

        EstiloFotos.change(function () {
            console.log($(this).val());
            mdlEstilosFotos.find("#imgsrc").parent().attr('data-caption', $(this).find("option:selected").text());
            mdlEstilosFotos.find("#imgsrc").attr('src', $(this).val());
            mdlEstilosFotos.find("#imgsrc").parent().attr('href', $(this).val());
        });

        btnFotos.click(function () {
            EstiloFotos[0].selectize.clear(true);
            $.when($.getJSON('<?php print base_url('FichaTecnica/getEstilosFoto'); ?>').done(function (a, b, c) {
                $.each(a, function (k, v) {
                    EstiloFotos[0].selectize.addOption({text: v.CLAVE, value: v.URL});
                });
            })).then(function (x) {
                mdlEstilosFotos.modal('show');
            });
        });

        btnEstilos.click(function () {
            $.fancybox.open({
                src: '<?php print base_url('Estilos'); ?>',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
                        console.info('done!');
                    },
                    afterClose: function () {
                        HoldOn.open({
                            theme: 'sk-rect',
                            message: 'Espere...'
                        });
                        $.when($.getJSON(master_url + 'getEstilos').done(function (data, x, jq) {
                            pnlDatos.find("#Estilo")[0].selectize.clear(true);
                            $.each(data, function (k, v) {
                                pnlDatos.find("#Estilo")[0].selectize.addOption({text: v.Estilo, value: v.Clave});
                            });
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        })).done(function (a) {
                            HoldOn.close();
                            onNotifyOld('<span><span>', 'SE HAN ACTUALIZADO LOS ESTILOS', 'info');
                        });
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
        });
        btnArticulos.click(function () {
            $.fancybox.open({
                src: '<?php print base_url('Articulos'); ?>',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
                        console.info('done!');
                    },
                    afterClose: function () {
                        HoldOn.open({
                            theme: 'sk-rect',
                            message: 'Espere...'
                        });
                        $.when($.getJSON(master_url + 'getArticulos').done(function (data, x, jq) {
                            pnlDatos.find("#Articulo")[0].selectize.clear(true);
                            $.each(data, function (k, v) {
                                pnlDatos.find("#Articulo")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                            });
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        })).done(function (a) {
                            HoldOn.close();
                            onNotifyOld('<span><span>', 'SE HAN ACTUALIZADO LOS ARTICULOS', 'info');
                        });
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
        });
        btnColor.click(function () {
            $.fancybox.open({
                src: '<?php print base_url('Colores'); ?>',
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
        });
        pnlControlesDetalle.find('#Articulo').selectize({
            valueField: 'Clave',
            labelField: 'Articulo',
            searchField: ['Articulo', 'Clave'],
            create: false,
            maxItems: 1,
            sortField: [
                {
                    field: 'Clave',
                    direction: 'asc'
                }
            ],
            loadingClass: 'loading',
            render: {option: Selectizer.renderOptions},
            remoteUrl: master_url + 'getArticulosByClave',
            load: Selectizer.loadOptions
        });
        validacionSelectPorContenedor(pnlDatos);
        setFocusSelectToSelectOnChange('#Estilo', '#Color', pnlDatos);
        setFocusSelectToInputOnChange('#Color', '#FechaAlta', pnlDatos);
        setFocusSelectToSelectOnChange('#Pieza', '#Articulo', pnlDatos);
        setFocusSelectToInputOnChange('#Articulo', '#PzXPar', pnlDatos);
        pnlDatos.find("#FechaAlta").inputmask({alias: "date"});
        btnAgregar.click(function () {
            isValid('pnlDatos');
            if (valido) {
                pnlDatos.find("#FechaAlta").prop("readonly", true);
                onAgregarFila();
            }
        });
        pnlDatos.find("[name='Estilo']").change(function () {
            if (nuevo) {
                pnlDatos.find("[name='Color']")[0].selectize.clear(true);
                pnlDatos.find("[name='Color']")[0].selectize.clearOptions();
                temp = $(this).val();
                getColoresXEstilo($(this).val());
                getFotoXEstilo($(this).val());
            }
        });
        pnlDatos.find("[name='Color']").change(function () {
            if (nuevo) {
                onComprobarExisteEstiloColor(pnlDatos.find("[name='Estilo']").val(), $(this).val());
                btnAdicionaMaterialFijo.attr('disabled', true);
            } else {
                btnAdicionaMaterialFijo.attr('disabled', false);
            }
        });
        btnEliminar.click(function () {
            if (temp !== 0 && temp !== undefined && temp > 0) {
                swal({
                    buttons: ["Cancelar", "Aceptar"],
                    title: 'Estas Seguro?',
                    text: "Esta acción no se puede revertir",
                    icon: "warning",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {
                        $.post(master_url + 'onEliminar', {ID: temp}).done(function (data, x, jq) {
                            onNotify('<span class="fa fa-exclamation fa-lg"></span>', 'REIGISTRO ELIMINADO', 'danger');
                            getRecords();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        }).always(function () {
                            HoldOn.close();
                        });
                    }
                });
            } else {
                onNotify('<span class="fa fa-exclamation fa-lg"></span>', 'DEBE DE ELEGIR UN REGISTRO', 'danger');
            }
        });
        btnNuevo.click(function () {
            pnlTablero.addClass("d-none");
            pnlDatos.removeClass('d-none');
            pnlDatos.find("input").val("");
            pnlControlesDetalle.find("input").val("");
            pnlControlesDetalle.removeClass('d-none');
            pnlDetalle.find("#tblFichaTecnicaDetalle tbody").html('');
            Estilo[0].selectize.enable();
            Color[0].selectize.enable();
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
            $(':input:text:enabled:visible:first').focus();
            nuevo = true;
            if ($.fn.DataTable.isDataTable('#tblFichaTecnicaDetalle')) {
                FichaTecnicaDetalle.clear().draw();
            }
            pnlDatos.find("#Estilo")[0].selectize.focus();
            pnlDatos.find("#FechaAlta").prop("readonly", false);
            FechaAlta.val(hoy);
        });
        btnCancelar.click(function () {
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass('d-none');
            pnlDetalle.addClass('d-none');
            validaSelect = false;
        });
        btnEditarRenglon.click(function () {
            isValid('mdlEditarArticulo');
            if (valido) {
                var frm = new FormData(mdlEditarArticulo.find("#frmEditarRenglon")[0]);
                frm.append('AfectaPV', mdlEditarArticulo.find("#eAfectaPV")[0].checked ? 1 : 0);
                $.ajax({
                    url: master_url + 'onModificarDetalle',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    FichaTecnicaDetalle.ajax.reload();
                    mdlEditarArticulo.modal('hide');
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
            }
        });
        getRecords();
        getEstilos();
        getPiezas();
        getArticulos();
        handleEnter();
        getCombos();
    });

    function getCombos() {
        $.when($.getJSON('<?php print base_url('FichaTecnica/getLineas'); ?>').done(function (data, x, jq) {
            LineaAdiciona[0].selectize.clear(true);
            LineaDefinidora[0].selectize.clear(true);
            $.each(data, function (k, v) {
                LineaAdiciona[0].selectize.addOption({text: v.LINEA, value: v.CLAVE});
                LineaDefinidora[0].selectize.addOption({text: v.LINEA, value: v.CLAVE});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        })).done(function (a) {
            HoldOn.close();
        });
        $.when($.getJSON(master_url + 'getArticulosSuplex').done(function (data, x, jq) {
            MaterialConsumo[0].selectize.clear(true);
            MaterialASuplir[0].selectize.clear(true);
            MaterialNuevo[0].selectize.clear(true);
            MaterialASuplirXLinea[0].selectize.clear(true);
            MaterialNuevoXLinea[0].selectize.clear(true);
            ArticuloAdiciona[0].selectize.clear(true);
            $.each(data, function (k, v) {
                ArticuloAdiciona[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                MaterialASuplirXLinea[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                MaterialNuevoXLinea[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                MaterialASuplir[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                MaterialNuevo[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                MaterialConsumo[0].selectize.addOption({text: v.Descripcion, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        })).done(function (a) {
            HoldOn.close();
        });
        $.when($.getJSON('<?php print base_url('FichaTecnica/getEstilosConsumos'); ?>').done(function (data, x, jq) {
            EstiloConsumo[0].selectize.clear(true);
            $.each(data, function (k, v) {
                EstiloConsumo[0].selectize.addOption({text: v.ESTILO, value: v.CLAVE});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        })).done(function (a) {
        });
    }

    function getFichaTecnicaDetalleByID(Estilo, Color) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblFichaTecnicaDetalle')) {
            tblFichaTecnicaDetalle.DataTable().destroy();
        }
        FichaTecnicaDetalle = tblFichaTecnicaDetalle.DataTable({
            "ajax": {
                "url": master_url + 'getFichaTecnicaDetalleByID',
                "dataSrc": "",
                "data": {
                    "Estilo": Estilo,
                    "Color": Color
                }
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [2],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [7],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [9],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [10],
                    "visible": false,
                    "searchable": false
                }
            ],
            "columns": [
                {"data": "Pieza_ID"}, /*0*/
                {"data": "Pieza"}, /*1*/
                {"data": "Articulo_ID"}, /*2*/
                {"data": "Articulo"}, /*3*/
                {"data": "Unidad"}, /*4*/
                {"data": "Consumo"}, /*5*/
                {"data": "PzXPar"}, /*6*/
                {"data": "ID"}, /*7*/
                {"data": "Eliminar"}, /*8*/
                {"data": "DeptoCat"}, /*9*/
                {"data": "DEPTO"}/*10*/
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 2:
                            /*UNIDAD*/
                            c.addClass('text-warning text-strong');
                            break;
                        case 3:
                            /*CONSUMO*/
                            c.addClass('');
                            break;
                        case 4:
                            /*PZXPAR*/
                            c.addClass('text-info text-strong');
                            break;
                        case 5:
                            /*ELIMINAR*/
                            c.addClass('text-danger');
                            break;
                    }
                });
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(); //Get access to Datatable API
                // Update footer
                var total = api.column(5).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(5).footer()).html(api.column(5, {page: 'current'}).data().reduce(function (a, b) {
                    return  $.number(parseFloat(total), 3, '.', ',');
                }, 0));
            },
            "dom": 'frt',
            "autoWidth": true,
            language: lang,
            "displayLength": 500,
            "colReorder": true,
            "bLengthChange": false,
            "deferRender": true,
            "scrollY": 295,
            "scrollCollapse": true,
            "bSort": true,
            "keys": true,
            order: [[10, 'asc']],
            rowGroup: {
                endRender: function (rows, group) {
                    var stc = $.number(rows.data().pluck('Consumo').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 4, '.', ',');
                    return $('<tr>').
                            append('<td></td><td colspan="2">Totales de: ' + group + '</td>').append('<td>' + stc + '</td><td colspan="2"></td><td></td></tr>');
                },
                dataSrc: "DeptoCat"
            },
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        tblFichaTecnicaDetalle.find('tbody').on('click', 'tr', function () {
            HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
            tblFichaTecnicaDetalle.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = FichaTecnicaDetalle.row(this).data();
            HoldOn.close();
            mdlEditarArticulo.find("input").val("");
            $.each(mdlEditarArticulo.find("select"), function (k, v) {
                mdlEditarArticulo.find("select")[k].selectize.clear(true);
            });
            mdlEditarArticulo.modal('show');
            $.each(dtm, function (k, v) {
                mdlEditarArticulo.find("[name='" + k + "']").val(v);
            });
            (dtm.AfectaPV === '1') ? mdlEditarArticulo.find("#eAfectaPV").prop('checked', true) : mdlEditarArticulo.find("#eAfectaPV").prop('checked', false);
            mdlEditarArticulo.find("[name='Pieza']")[0].selectize.addItem(dtm.Pieza_ID, true);
            mdlEditarArticulo.find("[name='eArticulo']")[0].selectize.addItem(dtm.Articulo_ID, true);
            mdlEditarArticulo.find('#eArticulo')[0].selectize.focus();
        });
    }

    function onEliminarArticuloFijo(e) {
        FichaTecnicaDetalle.row(e).remove();
    }
    function getRecords() {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblFichaTecnica')) {
            tblFichaTecnica.DataTable().destroy();
        }
        FichaTecnica = tblFichaTecnica.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataType": "json",
                "type": 'POST',
                "dataSrc": ""
            },
            "columns": [
                {"data": "EstiloId"},
                {"data": "ColorId"},
                {"data": "Estilo"},
                {"data": "Color"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [1],
                    "visible": false,
                    "searchable": false
                }],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 20,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: true,
            "bSort": true,
            "aaSorting": [
                [0, 'desc']/*ID*/
            ],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        $('#tblFichaTecnica_filter input[type=search]').focus();
        tblFichaTecnica.find('tbody').on('click', 'tr', function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            nuevo = false;
            tblFichaTecnica.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = FichaTecnica.row(this).data();
            getFichaTecnicaByEstiloByColor(dtm);
        });
    }

    function getFichaTecnicaByEstiloByColor(dtm) {
        $.getJSON(master_url + 'getFichaTecnicaByEstiloByColor', {Estilo: dtm.EstiloId, Color: dtm.ColorId}).done(function (data, x, jq) {
            pnlDatos.find("input").val("");
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
            Estilo[0].selectize.disable();
            Color[0].selectize.disable();
            pnlDatos.find("#FechaAlta").prop("readonly", true);
            $.getJSON(master_url + 'getColoresXEstilo', {Estilo: dtm.EstiloId}).done(function (data, x, jq) {
                $.each(data, function (k, v) {
                    pnlDatos.find("[name='Color']")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                });
                pnlDatos.find("[name='Color']")[0].selectize.addItem(dtm.ColorId, true);
            }).fail(function (x, y, z) {
                getError(x);
            }).always(function () {
            });
            pnlDatos.find("#Estilo")[0].selectize.addItem(data[0].Estilo, true);
            getFotoXEstilo(dtm.EstiloId);
            getFichaTecnicaDetalleByID(dtm.EstiloId, dtm.ColorId);
            pnlTablero.addClass("d-none");
            pnlDetalle.removeClass('d-none');
            pnlControlesDetalle.removeClass('d-none');
            pnlDatos.removeClass('d-none');

            pnlControlesDetalle.find("[name='Pieza']")[0].selectize.focus();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
        });
    }
    function getEstilos() {
        $.getJSON(master_url + 'getEstilos').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlDatos.find("#Estilo")[0].selectize.addOption({text: v.Estilo, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getPiezas() {
        $.getJSON(master_url + 'getPiezas').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlDatos.find("[name='Pieza']")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                mdlEditarArticulo.find("[name='Pieza']")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                PiezaASuplir[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                PiezaNueva[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                PiezaConsumo[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                PiezaAdiciona[0].selectize.addOption({text: v.Descripcion, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getArticulos() {
        $.getJSON(master_url + 'getArticulos').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlControlesDetalle.find("#Articulo")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                mdlEditarArticulo.find("[name='eArticulo']")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getColoresXEstilo(Estilo) {
        $.getJSON(master_url + 'getColoresXEstilo', {Estilo: Estilo}).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlDatos.find("[name='Color']")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            pnlDatos.find("#Color")[0].selectize.focus();
        });
    }

    function getFotoXEstilo(Estilo) {
        $.getJSON(master_url + 'getEstiloByID', {Estilo: Estilo}).done(function (data, x, jq) {
            if (data.length > 0) {
                var dtm = data[0];
                var vp = pnlDetalle.find("#VistaPrevia");
                if (dtm.Foto !== null && dtm.Foto !== undefined && dtm.Foto !== '') {
                    var ext = getExt(dtm.Foto);
                    if (ext === "gif" || ext === "jpg" || ext === "png" || ext === "jpeg") {
                        vp.html('<img src="' + base_url + dtm.Foto + '" class="img-thumbnail img-fluid" width="400px" />');
                    }
                    if (ext !== "gif" && ext !== "jpg" && ext !== "jpeg" && ext !== "png" && ext !== "PDF" && ext !== "Pdf" && ext !== "pdf") {
                        vp.html('<img src="' + base_url + 'img/camera.png" class="img-thumbnail img-fluid"/>');
                    }
                } else {
                    vp.html('<img src="' + base_url + 'img/camera.png" class="img-thumbnail img-fluid"/>');
                }
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
        });
    }

    function onComprobarExisteEstiloColor(Estilo, Color) {
        $.getJSON(master_url + 'onComprobarExisteEstiloColor', {Estilo: Estilo, Color: Color}).done(function (data, x, jq) {
            if (parseInt(data[0].EXISTE) > 0) {
                onNotify('<span class="fa fa-exclamation fa-lg"></span>', 'EL ESTILO YA HA SIDO CAPTURADO', 'danger');
                pnlDatos.find("[name='Estilo']")[0].selectize.clear();
                //pnlDatos.find("[name='Color']")[0].selectize.focus();
                btnAdicionaMaterialFijo.attr('disabled', true);
            } else {
                btnAdicionaMaterialFijo.attr('disabled', false);
                getFotoXEstilo(Estilo);
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
        });
    }

    function onAgregarFila() {
        var Pieza = pnlControlesDetalle.find("[name='Pieza']"), Articulo = pnlControlesDetalle.find("[name='Articulo']");
        var PzXPar = pnlControlesDetalle.find("[name='PzXPar']");
        var Consumo = pnlControlesDetalle.find("[name='Consumo']"), Estilo = pnlDatos.find("[name='Estilo']");
        var Color = pnlDatos.find("[name='Color']");
        /*COMPROBAR SI YA SE AGREGÓ*/
        var registro_existe = false;
        /*VALIDAR QUE ESTEN TODOS LOS CAMPOS LLENOS PARA AGREGARLO*/
        if (Estilo.val() !== "" && Color.val() !== "" && Pieza.val() !== "" && Articulo.val() !== "" && Consumo.val() !== "")
        {

            if (pnlDetalle.find("#tblFichaTecnicaDetalle tbody tr").length > 0) {
                FichaTecnicaDetalle.rows().eq(0).each(function (index) {
                    var row = FichaTecnicaDetalle.row(index);
                    var data = row.data();
                    if (parseFloat(data.Pieza_ID) === parseFloat(Pieza.val())) {
                        registro_existe = true;
                        return false;
                    }
                });
            }

            /*VALIDAR QUE EXISTA*/
            if (!registro_existe) {
                var frm = new FormData();
                frm.append('Estilo', Estilo.val());
                frm.append('Color', Color.val());
                frm.append('Pieza', Pieza.val());
                frm.append('Articulo', Articulo.val());
                frm.append('PzXPar', PzXPar.val());
                frm.append('Consumo', Consumo.val());
                frm.append('AfectaPV', pnlControlesDetalle.find("#AfectaPV")[0].checked ? 1 : 0);
                $.ajax({
                    url: master_url + 'onAgregar',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    if (nuevo) {
                        Estilo[0].selectize.disable();
                        Color[0].selectize.disable();
                        pnlDetalle.removeClass('d-none');
                        nuevo = false;
                        FichaTecnica.ajax.reload();
                        getFichaTecnicaDetalleByID(Estilo.val(), Color.val());
                    } else {
                        FichaTecnicaDetalle.ajax.reload();
                    }
                    onReset();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                swal({
                    title: 'INFO',
                    text: "YA HAS AGREGADO ESTA PIEZA",
                    icon: "warning",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {
                        onReset();
                    }
                });
            }
        } else {
            swal('INFO', 'DEBES COMPLETAR TODOS LOS CAMPOS', 'warning');
        }
    }

    function onReset() {
        pnlControlesDetalle.find("[name='Articulo']")[0].selectize.clear(true);
        pnlControlesDetalle.find("[name='Pieza']")[0].selectize.focus();
        pnlControlesDetalle.find("[name='Pieza']")[0].selectize.clear(true);
        pnlControlesDetalle.find("[name='Precio']").val('');
        pnlControlesDetalle.find("[name='Consumo']").val('');
        pnlControlesDetalle.find("[name='PzXPar']").val('');
    }

    function onEliminarArticuloID(IDX) {
        swal({
            title: "¿Deseas eliminar el registro? ", text: "*El registro se eliminará de forma permanente*", icon: "warning", buttons: ["Cancelar", "Aceptar"]
        }).then((willDelete) => {
            if (willDelete) {
                $.post(master_url + 'onEliminarArticuloID', {ID: IDX}).done(function () {
                    $.notify({
                        // options
                        message: 'SE HA ELIMINADO EL REGISTRO'
                    }, {
                        // settings
                        type: 'success',
                        delay: 500,
                        animate: {
                            enter: 'animated flipInX',
                            exit: 'animated flipOutX'
                        },
                        placement: {
                            from: "top",
                            align: "right"
                        }
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    FichaTecnicaDetalle.ajax.reload();
                });
            }
        });
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
    td{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
    .btn-info-blue{
        color: #fff;
        background-color: #3F51B5 !important;
        border-color: #3F51B5 !important;
    } 
</style>