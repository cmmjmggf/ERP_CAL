<div class="card m-3" id="pnlTablero">
    <div class="card-header">
        <div class="row">
            <div class="w-100 my-1"></div> 
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-none">
                <button type="button" class="btn btn-default text-muted" id="btnReload"><span class="fa fa-retweet"></span></button>
            </div> 
            <div class="col-12 col-sm-12 col-md-12 col-lg-8">
                <h4 class="font-weight-bold pr-2 mr-2">
                    Asigna Piel, Forro, Textiles y Sintéticos a corte por control
                </h4> 
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-4" align="right">
                <button type="button" class="btn btn-info" id="btnRetornaMaterial">
                    <span class="fa fa-retweet"></span> Retornar material</button>
            </div>
        </div>
    </div>
    <div class="card-body" style="padding-top: 5px">
        <div class="row" style="padding-left: 15px">
            <div class="col-12 col-sm-6 col-md-6 col-lg-2 col-xl-1" align="left">
                <strong>Semana</strong>
                <input type="text" class="form-control form-control-sm column_filter numeric" id="Semana" autofocus onkeyup="onChecarSemanaValida(this)">
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-2" align="left">
                <strong>Control</strong>
                <input type="text" class="form-control form-control-sm column_filter numeric" id="Control"  >
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-2 col-xl-2" align="left">
                <strong>Fracción</strong>
                <input type="text" class="form-control form-control-sm column_filter numeric" id="Fraccion" data-toggle="tooltip" data-placement="bottom" title="Indique la fracción: 96,99,100">
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-5 col-xl-3" align="left">
                <strong>Artículo</strong>
                <input type="text" class="form-control form-control-sm d-none" id="OrdenDeProduccion" readonly="">
                <input type="text" class="form-control form-control-sm d-none" id="ClaveArticulo" readonly="">
                <input type="text" class="form-control form-control-sm" id="Articulo" readonly="">
                <input type="text" class="form-control form-control-sm d-none" id="ClavePieza" readonly="">
                <input type="text" class="form-control form-control-sm d-none" id="Pieza" readonly="">
                <input type="text" class="form-control form-control-sm d-none" id="Pares" readonly="">
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-1" align="left">
                <strong>Explosion</strong>
                <input type="text" class="form-control form-control-sm" id="Explosion" readonly="">
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-1" align="left">
                <strong>Entregar</strong>
                <input type="text" class="form-control form-control-sm numericdot" readonly="" id="Entregar" onkeyup=""  data-toggle="tooltip" data-placement="bottom" title="Presiona Enter para aceptar">
            </div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-1 col-xl-1 mt-4 text-center" align="center">
                <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                    <input type="checkbox" class="custom-control-input selectNotEnter" id="MaterialExtra" name="MaterialExtra" style="cursor: pointer !important;">
                    <label class="custom-control-label text-danger labelCheck" for="MaterialExtra" style="cursor: pointer !important;">Material Extra</label>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-1 mt-2" align="left">
                <button type="button" id="btnEntregar" class="btn btn-success" style="color: #fff; background-color: #8BC34A; border-color: #8BC34A;" data-toggle="tooltip" data-placement="bottom" title="Presiona Enter para aceptar"><span class="fa fa-check"></span> Acepta</button>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center" data-toggle="tooltip" data-placement="right" title="Selecciona un articulo a entregar de la tabla de Pieles">
                        <h5>PIELES</h5>
                        <table id="tblPieles" class="table table-hover table-sm table-bordered  compact nowrap" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Control</th>
                                    <th scope="col">Articulo</th>

                                    <th scope="col">Descripcion</th>
                                    <th scope="col">U.M.</th>
                                    <th scope="col">Pz.</th>

                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Gpo</th>
                                    <th scope="col" class="sum">Cant.</th>

                                    <th scope="col">Semana</th><!--FILTRO-->
                                    <th scope="col">Fraccion</th><!--FILTRO-->
                                    <th scope="col">Pares</th><!--INFORMATIVO-->
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th></th><!--0-->
                                    <th></th><!--1-->
                                    <th></th><!--2-->

                                    <th></th><!--3-->
                                    <th></th><!--4-->
                                    <th></th><!--5-->

                                    <th></th><!--6-->
                                    <th></th><!--7-->
                                    <th></th><!--8-->

                                    <th></th><!--9-->
                                    <th></th><!--10-->
                                    <th></th><!--11-->
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
                        <h5>FORROS</h5>
                        <table id="tblForros" class="table table-hover table-sm table-bordered  compact nowrap" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Control</th>
                                    <th scope="col">Articulo</th>

                                    <th scope="col">Descripcion</th>
                                    <th scope="col">U.M.</th>
                                    <th scope="col">Pz.</th>

                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Gpo</th>
                                    <th scope="col" class="sum">Cant.</th>

                                    <th scope="col">Semana</th><!--FILTRO-->
                                    <th scope="col">Fraccion</th><!--FILTRO-->
                                    <th scope="col">Pares</th><!--INFORMATIVO-->
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th></th><!--0-->
                                    <th></th><!--1-->
                                    <th></th><!--2-->

                                    <th></th><!--3-->
                                    <th></th><!--4-->
                                    <th></th><!--5-->

                                    <th></th><!--6-->
                                    <th></th><!--7-->
                                    <th></th><!--8-->

                                    <th></th><!--9-->
                                    <th></th><!--10-->
                                    <th></th><!--11-->
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
                        <h5>TEXTILES</h5>
                        <table id="tblTextiles" class="table table-hover table-sm table-bordered compact nowrap" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Control</th>
                                    <th scope="col">Articulo</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">U.M.</th>
                                    <th scope="col">Pz.</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Gpo</th>
                                    <th scope="col" class="sum">Cant.</th>
                                    <th scope="col">Semana</th><!--FILTRO-->
                                    <th scope="col">Fraccion</th><!--FILTRO-->
                                    <th scope="col">Pares</th><!--INFORMATIVO-->
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th></th><!--0-->
                                    <th></th><!--1-->
                                    <th></th><!--2-->

                                    <th></th><!--3-->
                                    <th></th><!--4-->
                                    <th></th><!--5-->

                                    <th></th><!--6-->
                                    <th></th><!--7-->
                                    <th></th><!--8-->

                                    <th></th><!--9-->
                                    <th></th><!--10-->
                                    <th></th><!--11-->
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
                        <h5>SINTÉTICOS</h5>
                        <table id="tblSinteticos" class="table table-hover table-sm table-bordered compact nowrap" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th><!--0-->
                                    <th scope="col">Control</th><!--1-->
                                    <th scope="col">Articulo</th><!--2-->
                                    <th scope="col">Descripcion</th><!--3-->
                                    <th scope="col">U.M.</th><!--4-->

                                    <th scope="col">Pz.</th><!--5-->

                                    <th scope="col">Descripcion</th><!--6-->
                                    <th scope="col">Gpo</th><!--7-->
                                    <th scope="col" class="sum">Cant.</th><!--8-->
                                    <th scope="col">Semana</th><!--FILTRO-->
                                    <th scope="col">Fraccion</th><!--FILTRO-->
                                    <th scope="col">Pares</th><!--INFORMATIVO-->
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th></th><!--0-->
                                    <th></th><!--1-->
                                    <th></th><!--2-->

                                    <th></th><!--3-->
                                    <th></th><!--4-->
                                    <th></th><!--5-->

                                    <th></th><!--6-->
                                    <th></th><!--7-->
                                    <th></th><!--8-->

                                    <th></th><!--9-->
                                    <th></th><!--10-->
                                    <th></th><!--11-->
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="center">
                <h5>CONTROLES ASIGNADOS</h5>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <table id="tblControlesAsignados" class="table table-hover table-sm table-bordered compact nowrap" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Control</th>
                            <th scope="col">Emp</th>
                            <th scope="col">Art.</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Abono</th>
                            <th scope="col">Dev</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="mdlRetornaMaterial">
    <div class="modal-dialog modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header text-center" align="center">
                <h4 class="modal-title"><span class="fa fa-retweet"></span> Regresa materiales de corte a almacen</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                        <input type="text" id="IDA" name="IDA" class="form-control form-control-sm d-none" readonly="">
                        <input type="text" id="Articulo" name="Articulo" class="form-control form-control-sm d-none" readonly="">
                        <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm d-none" readonly="">
                        <input type="text" id="Color" name="Color" class="form-control form-control-sm d-none" readonly="">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
                        <label>Cortador</label>
                        <input type="text" id="CortadorClave" autofocus="" name="CortadorClave" class="form-control form-control-sm" autofocus="" autocomplete="off">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-4">
                        <select id="Cortador" name="Cortador" class="form-control form-control-sm selectNotEnter notEnter">
                            <option></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
                        <label>1 = PIEL / 2 = FORRO</label>
                        <select id="PielForro" name="PielForro" class="form-control form-control-sm">
                            <option></option>
                            <option value="1">1 PIEL</option>
                            <option value="2">2 FORRO</option>
                            <option value="34">34 TEXTIL</option>
                            <option value="40">40 SINTETICO</option>
                        </select>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
                        <label>Control</label>
                        <input type="text" class="form-control form-control-sm numeric" id="Control" name="Control">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-2 col-xl-2">
                        <label>Pares</label>
                        <input type="text" class="form-control form-control-sm notEnter" id="Pares" name="Pares" readonly="">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-2 col-xl-2">
                        <label>Entrego</label>
                        <input type="text" class="form-control form-control-sm" id="Entrego" name="Entrego" readonly="">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-2 col-xl-2">
                        <label>Regreso</label>
                        <input type="text" class="form-control form-control-sm numericdot" id="Regreso" name="Regreso" data-toggle="tooltip" data-placement="bottom" title="Escriba 0 si no devolvio nada.">
                        <input type="text" id="AnteriormenteRetorno" name="AnteriormenteRetorno" class="form-control form-control-sm d-none" readonly="">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-2 col-xl-2">
                        <label>Mat-Malo</label>
                        <input type="text" class="form-control form-control-sm numericdot" id="MatMalo" name="MatMalo"  data-toggle="tooltip" data-placement="bottom" title="Escriba 0 si no devolvio material malo/defectuoso.">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-2 col-sm-12 col-md-6 col-lg-2 col-xl-2 mt-4 text-center" align="center">
                        <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                            <input type="checkbox" class="custom-control-input selectNotEnter" id="MaterialExtraRetorna" name="MaterialExtraRetorna" style="cursor: pointer !important;">
                            <label class="custom-control-label text-danger labelCheck" for="MaterialExtraRetorna" style="cursor: pointer !important;">Material Extra</label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-8 col-lg-10 col-xl-10">
                        <label>Articulo</label>
                        <div class="row">
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                <input type="text" id="Articulo" name="Articulo" class="form-control form-control-sm notEnter" readonly="">
                            </div>
                            <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                <input type="text" id="ArticuloT" name="ArticuloT" class="form-control form-control-sm notEnter" readonly="">
                                <input type="text" id="Precio" name="Precio" class="form-control form-control-sm d-none" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblRegresos" class="table table-hover table-sm" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th><!--0-->
                                    <th scope="col">Cortador</th><!--1-->
                                    <th scope="col">Control</th><!--2-->

                                    <th scope="col">Pi-Fo</th><!--100 = piel, 99 = forro--><!--3-->
                                    <th scope="col">Estilo</th><!--4-->
                                    <th scope="col">Col</th><!--5-->

                                    <th scope="col">Pares</th><!--6-->
                                    <th scope="col">Art.</th><!--7-->
                                    <th scope="col">Art.Des</th><!--8-->

                                    <th scope="col">Entregado</th><!--9-->
                                    <th scope="col">Regreso</th><!--10-->
                                    <th scope="col">Tipo</th><!--PIEL 1 / FORRO 2-->
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6" align="left">
                            <button type="button" class="btn btn-info" id="btnAceptar" name="btnAceptar">
                                <span class="fa fa-check"></span> Aceptar</button>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6" align="right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/AsignaPFTSACXC/';

    var pnlTablero = $("#pnlTablero");

    var Semana = pnlTablero.find("#Semana"),
            Control = pnlTablero.find("#Control"),
            Fraccion = pnlTablero.find("#Fraccion"),
            Articulo = pnlTablero.find("#Articulo"),
            ClaveArticulo = pnlTablero.find("#ClaveArticulo"),
            Pieza = pnlTablero.find("#Pieza"),
            ClavePieza = pnlTablero.find("#ClavePieza"),
            Explosion = pnlTablero.find("#Explosion"),
            Entregar = pnlTablero.find("#Entregar"),
            MaterialExtra = pnlTablero.find("#MaterialExtra"),
            OrdenDeProduccion = pnlTablero.find("#OrdenDeProduccion"),
            Pares = pnlTablero.find("#Pares");

    var Pieles = $("#Pieles"), Forros = $("#Forros"),
            Textiles = $("#Textiles"), Sinteticos = $("#Sinteticos"),
            ControlesAsignados = $("#ControlesAsignados");

    var tblPieles = $("#tblPieles"), tblForros = $("#tblForros"),
            tblTextiles = $("#tblTextiles"), tblSinteticos = $("#tblSinteticos"),
            tblControlesAsignados = $("#tblControlesAsignados");

    var btnReload = $("#btnReload"), btnRetornaMaterial = $("#btnRetornaMaterial");
    var mdlRetornaMaterial = $("#mdlRetornaMaterial");

    var tblRegresos = mdlRetornaMaterial.find("#tblRegresos"),
            Regresos = $("#Regresos");
    var btnAceptar = mdlRetornaMaterial.find("#btnAceptar"),
            ControlRetorna = mdlRetornaMaterial.find("#Control"),
            ArticuloRetorna = mdlRetornaMaterial.find("#Articulo"),
            ArticuloT = mdlRetornaMaterial.find("#ArticuloT"),
            EntregoRetorno = mdlRetornaMaterial.find("#Entrego"),
            Regreso = mdlRetornaMaterial.find("#Regreso"),
            MatMalo = mdlRetornaMaterial.find("#MatMalo"),
            PielForro = mdlRetornaMaterial.find("#PielForro"),
            CortadorClave = mdlRetornaMaterial.find("#CortadorClave"),
            Cortador = mdlRetornaMaterial.find("#Cortador");

    var tipo_consumo = 0, FT = 1;

    $(document).ready(function () {
        handleEnterDiv(pnlTablero);
        handleEnterDiv(mdlRetornaMaterial);
        Semana.on('keydown', function (e) {
            Pieles.ajax.reload();
            Forros.ajax.reload();
            Sinteticos.ajax.reload();
            Textiles.ajax.reload();
            ControlesAsignados.ajax.reload();
        });

        ControlRetorna.on('keydown', function (e) {
            if (ControlRetorna.val() && e.keyCode === 13) {
                var xpifo = 100;
                switch (parseInt(PielForro.val())) {
                    case 1:
                        xpifo = 100;
                        break;
                    case 2:
                        xpifo = 99;
                        break;
                    case 34:
                        xpifo = 34;
                        break;
                    case 40:
                        xpifo = 40;
                        break;
                }
                $.getJSON('<?php print base_url('AsignaPFTSACXC/getInfoXControl') ?>', {
                    CONTROL: ControlRetorna.val(), PIFO: xpifo
                }).done(function (a) {
                    if (a.length > 0) {
                        Regreso.focus().select();
                        EntregoRetorno.val(a[0].ENTREGO);
                        ArticuloRetorna.val(a[0].ARTICULO);
                        ArticuloT.val(a[0].ARTICULO_DESCRIPCION);
                        mdlRetornaMaterial.find("#IDA").val(a[0].IDA);
                        mdlRetornaMaterial.find("#Estilo").val(a[0].ESTILO);
                        mdlRetornaMaterial.find("#Color").val(a[0].COLOR);
                        mdlRetornaMaterial.find("#AnteriormenteRetorno").val(a[0].DEVOLVIO_ANTES);
                        Regresos.ajax.reload();
                    }
                }).fail(function (x) {
                    getError(x)
                });
            }
        });

        btnEntregar.click(function () {
            onEntregarMaterial();
        });

        CortadorClave.on('keydown', function (e) {
            if (e.keyCode === 13 && CortadorClave.val()) {
                onDisable(Cortador);
                Cortador[0].selectize.setValue(CortadorClave.val());
                if (Cortador.val() === '') {
                    iMsg("DEBE DE ESPECIFICAR UN CORTADOR VALIDO", 'w', function () {
                        CortadorClave.focus().select();
                    });
                }
            }

        });

        mdlRetornaMaterial.on('hidden.bs.modal', function () {
            mdlRetornaMaterial.find("input").val("");
            $.each(mdlRetornaMaterial.find("select"), function (k, v) {
                mdlRetornaMaterial.find("select")[k].selectize.clear(true);
            });
        });
        mdlRetornaMaterial.on('shown.bs.modal', function () {
            console.log('okokokokokokook');
            CortadorClave.focus();
            Regresos.ajax.reload();
        });

        mdlRetornaMaterial.find("#Control").focusout(function () {
            if (mdlRetornaMaterial.find("#Control").val()) {
//                swal('SUCCESS', 'AHORA,DEBE DE SELECCIONAR UN REGISTRO DE LA TABLA CON EL CONTROL ESPECIFICADO', 'success').then((value) => {
                mdlRetornaMaterial.find("#tblRegresos tbody tr").addClass("highlight-rows");
                setTimeout(function () {
                    mdlRetornaMaterial.find("#tblRegresos tbody tr").removeClass("highlight-rows");
                }, 2500);
//                });
            }
        });
        mdlRetornaMaterial.find("#PielForro").change(function () {
            if ($(this).val() !== '') {
                mdlRetornaMaterial.find("#Control").focus();
                Regresos.ajax.reload();
//                tblRegresos.DataTable().column(11).search($(this).val()).draw();
            } else {
                Regresos.ajax.reload();
//                tblRegresos.DataTable().column(11).search('').draw();
            }
        }).blur(function () {
            if (mdlRetornaMaterial.find("#PielForro").val() !== '') {
                mdlRetornaMaterial.find("#Control").focus();
                Regresos.ajax.reload();
//                tblRegresos.DataTable().column(11).search(mdlRetornaMaterial.find("#PielForro").val()).draw();
            } else {
                Regresos.ajax.reload();
//                tblRegresos.DataTable().column(11).search('').draw();
            }
        });
        MatMalo.keydown(function (e) {
            if (e.keyCode === 13) {
                btnAceptar.focus();
            }
        });

        btnAceptar.click(function () {
            onEnable(Cortador);
            onDisable(btnAceptar);
            if (mdlRetornaMaterial.find("#Entrego").val() !== '' || mdlRetornaMaterial.find("#Regreso").val() !== '') {
                onDevolverPielForro();
            } else {
                swal('ATENCIÓN', 'DEBE DE SELECCIONAR UN REGISTRO', 'warning').then((value) => {
                    mdlRetornaMaterial.find("#tblRegresos tbody tr").addClass("highlight-rows");
                    setTimeout(function () {
                        mdlRetornaMaterial.find("#tblRegresos tbody tr").removeClass("highlight-rows");
                    }, 2500);
                });
            }
        });

        mdlRetornaMaterial.find("#Control").keydown(function (e) {
            if (e.keyCode === 13) {
                getParesXControl($(this));
            }
        });

        mdlRetornaMaterial.find("#Cortador").change(function () {
            if ($(this).val() !== '') {
                mdlRetornaMaterial.find("#PielForro")[0].selectize.open();
                mdlRetornaMaterial.find("#PielForro")[0].selectize.focus();
            }
        });

        btnRetornaMaterial.click(function () {
            mdlRetornaMaterial.modal('show');
        });
        Entregar.keydown(function (event) {
            if (event.which === 13) {
                onEntregar(this, event);
            }
        });
        btnReload.click(function () {
            Semana.val('');
            Control.val('');
            Fraccion.val('');
            tipo_consumo = 0;
            init();
        });
        $("div > h4").removeClass("d-none");
        Semana.focus();
        var cols = [
            {"data": "ID"}/*0*/, {"data": "CONTROL"}/*1*/,
            {"data": "ARTICULO_CLAVE"}/*2*/, {"data": "ARTICULO_DESCRIPCION"},
            {"data": "UM"}, {"data": "PIEZA"},
            {"data": "PIEZA_DESCRIPCION"}, {"data": "GRUPO"},
            {"data": "CANTIDAD"}, {"data": "SEMANA"},
            {"data": "FRACCION"}, {"data": "PARES"}
        ];
        var coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [9],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [10],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [11],
                "visible": false,
                "searchable": true
            }
        ];
        var xoptions_pieles = {
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('pieles'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.SEMANA = (Semana.val().trim());
                    d.CONTROL = (Control.val().trim());
                }
            },
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
            "scrollY": "125px",
            "scrollX": true,
            createdRow: function (row, data, dataIndex) {
                onCalcularAlBuscar();
            }
        };
        Pieles = tblPieles.DataTable(xoptions_pieles);
        tblPieles.on('click', 'tr', function () {
            if (Semana.val() !== '' && Control.val() !== '' && Fraccion.val() !== '') {
                Forros.rows('.selected').deselect();
                Textiles.rows('.selected').deselect();
                Sinteticos.rows('.selected').deselect();
                var data = Pieles.row(this).data();
                console.log('PIELES', data);
                OrdenDeProduccion.val(data.ID);
                ClaveArticulo.val(data.ARTICULO_CLAVE);
                Articulo.val(data.ARTICULO_DESCRIPCION);
                Pares.val(data.PARES);
                getExplosionXSemanaControlFraccionArticulo(Semana, Control, Fraccion, data.ARTICULO_CLAVE, 1);
                tipo_consumo = 1; /*PIEL*/
            } else {
                onUnSelect();
            }
        });
        var xoptions_forros = xoptions_pieles;
        xoptions_forros.ajax = {
            "url": '<?php print base_url('forros'); ?>',
            "contentType": "application/json",
            "dataSrc": "",
            "data": function (d) {
                d.SEMANA = (Semana.val().trim());
                d.CONTROL = (Control.val().trim());
            }
        };
        Forros = tblForros.DataTable(xoptions_forros);
        tblForros.on('click', 'tr', function () {
            if (Semana.val() !== '' && Control.val() !== '' && Fraccion.val() !== '') {
                Pieles.rows('.selected').deselect();
                Textiles.rows('.selected').deselect();
                Sinteticos.rows('.selected').deselect();
                var data = Forros.row(this).data();
                console.log('FORROS', data);
                OrdenDeProduccion.val(data.ID);
                ClaveArticulo.val(data.ARTICULO_CLAVE);
                Articulo.val(data.ARTICULO_DESCRIPCION);
                Pares.val(data.PARES);
                getExplosionXSemanaControlFraccionArticulo(Semana, Control, Fraccion, data.ARTICULO_CLAVE, 2);
                tipo_consumo = 2; /*FORRO*/
            } else {
                onUnSelect();
            }
        });
        var xoptions_textiles = xoptions_pieles;
        xoptions_textiles.ajax = {
            "url": '<?= base_url('textiles'); ?>',
            "contentType": "application/json",
            "dataSrc": "",
            "data": function (d) {
                d.SEMANA = (Semana.val().trim());
                d.CONTROL = (Control.val().trim());
            }
        };
        Textiles = tblTextiles.DataTable(xoptions_textiles);
        tblTextiles.on('click', 'tr', function () {
            if (Semana.val() !== '' && Control.val() !== '' && Fraccion.val() !== '') {
                Pieles.rows('.selected').deselect();
                Forros.rows('.selected').deselect();
                Sinteticos.rows('.selected').deselect();
                var data = Textiles.row(this).data();
                console.log('TEXTILES', data);
                OrdenDeProduccion.val(data.ID);
                ClaveArticulo.val(data.ARTICULO_CLAVE);
                Articulo.val(data.ARTICULO_DESCRIPCION);
                Pares.val(data.PARES);
                getExplosionXSemanaControlFraccionArticulo(Semana, Control, Fraccion, data.ARTICULO_CLAVE, 34);
                tipo_consumo = 34; /*TEXTIL*/
            } else {
                onUnSelect();
            }
        });
        var xoptions_sinteticos = xoptions_pieles;
        xoptions_sinteticos.ajax = {
            "url": '<?php print base_url('sinteticos'); ?>',
            "contentType": "application/json",
            "dataSrc": "",
            "data": function (d) {
                d.SEMANA = (Semana.val().trim());
                d.CONTROL = (Control.val().trim());
            }
        };
        Sinteticos = tblSinteticos.DataTable(xoptions_sinteticos);
        tblSinteticos.on('click', 'tr', function () {
            if (Semana.val() !== '' && Control.val() !== '' && Fraccion.val() !== '') {
                Pieles.rows('.selected').deselect();
                Forros.rows('.selected').deselect();
                Textiles.rows('.selected').deselect();
                var data = Sinteticos.row(this).data();
                console.log('SINTETICOS', data);
                OrdenDeProduccion.val(data.ID);
                ClaveArticulo.val(data.ARTICULO_CLAVE);
                Articulo.val(data.ARTICULO_DESCRIPCION);
                Pares.val(data.PARES);
                getExplosionXSemanaControlFraccionArticulo(Semana, Control, Fraccion, data.ARTICULO_CLAVE, 40);
                tipo_consumo = 40; /*SINTETICOS*/
            } else {
                onUnSelect();
            }
        });
        Pieles.order([1, 'desc']).draw();
        Forros.order([1, 'desc']).draw();
        Textiles.order([1, 'desc']).draw();
        Sinteticos.order([1, 'desc']).draw();
        Fraccion.on('keydown', function (e) {
            if (e.keyCode === 13) {
                onBuscarX(10, Fraccion.val());
            }
        }).focusout(function () {
            if (Explosion.val() === '') {
                switch (parseInt(Fraccion.val())) {
                    case 100:
                        $(".card div[id='tblPieles_wrapper'], .card div[id='tblSinteticos_wrapper'], .card div[id='tblTextiles_wrapper']").find("thead tr th").addClass("highlight-rows");
                        break;
                    case 99:
                        $(".card div[id='tblForros_wrapper'], .card div[id='tblSinteticos_wrapper'], .card div[id='tblTextiles_wrapper']").find("thead tr th").addClass("highlight-rows");
                        break;
                    case 96:
                        $(".card div[id='tblPieles_wrapper'],.card div[id='tblForros_wrapper'], .card div[id='tblSinteticos_wrapper'], .card div[id='tblTextiles_wrapper']").find("thead tr th").addClass("highlight-rows");
                        break;
                }
            }
        });
        Control.on('keydown', function (e) {
            FT = 0;
            if (e.keyCode === 13 && Semana.val() && Control.val()) {
                HoldOn.open({theme: 'sk-bounce', message: 'Buscando por semana y control...'});
                Pieles.ajax.reload(function () {
                    HoldOn.close();
                });
                Forros.ajax.reload();
                Sinteticos.ajax.reload();
                Textiles.ajax.reload();
                ControlesAsignados.ajax.reload();
            }
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblControlesAsignados')) {
            tblControlesAsignados.DataTable().destroy();
        }
        ControlesAsignados = tblControlesAsignados.DataTable({
            "dom": 'frtip',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('AsignaPFTSACXC/getControlesAsignados'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.SEMANA = (Semana.val() ? Semana.val() : '');
                    d.CONTROL = (Control.val() ? Control.val() : '');
                }
            },
            "columns": [
                {"data": "ID"}, {"data": "Control"},
                {"data": "Empleado"}, {"data": "Articulo"},
                {"data": "Descripcion"}, {"data": "Fecha"},
                {"data": "Cargo"}, {"data": "Abono"},
                {"data": "Dev"}
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
            "scrollY": "250px",
            "aaSorting": [
                [0, 'desc'], [5, 'desc']
            ],
            initComplete: function (a, b) {
                $("#tblControlesAsignados_filter").find("input").addClass("selectNotEnter");
            }
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblRegresos')) {
            tblRegresos.DataTable().destroy();
        }

        Regresos = tblRegresos.DataTable({
            "dom": 'rtp',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('AsignaPFTSACXC/getRegresos'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CORTADOR = CortadorClave.val() ? CortadorClave.val() : '';
                    d.PIFO = PielForro.val() ? PielForro.val() : '';
                    d.CONTROL = mdlRetornaMaterial.find("#Control").val() ? mdlRetornaMaterial.find("#Control").val() : '';
                }
            },
            "columns": [
                {"data": "ID"}/*0*/, {"data": "Cortador"}/*1*/, {"data": "Control"}/*2*/, {"data": "PiFoFraccion"},
                {"data": "Estilo"}, {"data": "Color"}, {"data": "Pares"},
                {"data": "Articulo"}, {"data": "ArticuloT"}, {"data": "Entregado"},
                {"data": "Regreso"}, {"data": "Tipo"}, {"data": "Fecha"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [12],
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
            "bSort": true,
            "scrollY": "250px",
            "aaSorting": [
                [12, 'desc']
            ],
            "deferRender": true,
            "scrollCollapse": false
        });
        tblRegresos.on('click', 'tr', function () {
            var data = Regresos.row(this).data();
            console.log('Regresos', data);
            mdlRetornaMaterial.find("#Articulo").val(data.Articulo);
            mdlRetornaMaterial.find("#ArticuloT").val(data.ArticuloT);
            mdlRetornaMaterial.find("#Entrego").val(data.Entregado);
            mdlRetornaMaterial.find("#IDA").val(data.ID);
            mdlRetornaMaterial.find("#Estilo").val(data.Estilo);
            mdlRetornaMaterial.find("#Color").val(data.Color);
            mdlRetornaMaterial.find("#AnteriormenteRetorno").val(data.Regreso);
            mdlRetornaMaterial.find("#Regreso").focus();
        });
        init();
    });

    function getParesXControl(c) {
        if (c.val() !== '') {
            tblRegresos.DataTable().column(2).search(c.val()).draw();
            $.getJSON('<?php print base_url('AsignaPFTSACXC/getParesXControl'); ?>', {CONTROL: c.val()}).done(function (data) {
                mdlRetornaMaterial.find("#Pares").val(data[0].PARES);
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            });
        } else {
            Regresos.ajax.reload();
        }
    }

    function getExplosionXSemanaControlFraccionArticulo(S, C, F, A, G) {

        if (Semana.val() !== '' && Control.val() !== '' && Fraccion.val() !== '') {
            HoldOn.open({
                theme: 'sk-bounce',
                message: 'Cargando...'
            });
            $.getJSON('<?php print base_url('AsignaPFTSACXC/getExplosionXSemanaControlFraccionArticulo'); ?>',
                    {SEMANA: S.val(), CONTROL: C.val(),
                        FRACCION: F.val(), ARTICULO: A,
                        GRUPO: G}).done(function (data) {
                if (data.length > 0) {
                    Explosion.val(data[0].EXPLOSION);
                    Entregar.prop('readonly', false);
                    Entregar.focus();
                }
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            }).always(function () {
                HoldOn.close();
            });
        } else {
            onUnSelect();
        }
    }

    function onUnSelect() {
        swal('ATENCIÓN', 'ES NECESARIO ESTABLECER UNA SEMANA, UN CONTROL Y UNA FRACCIÓN', 'warning').then((value) => {
            Pieles.rows('.selected').deselect();
            Forros.rows('.selected').deselect();
            Textiles.rows('.selected').deselect();
            Sinteticos.rows('.selected').deselect();
            if (Semana.val().trim() === '') {
                Semana.focus();
            } else if (Control.val().trim() === '') {
                Control.focus();
            } else if (Fraccion.val().trim() === '') {
                Fraccion.focus();
            }
        });
    }

    function onBuscarX(i, v) {
        if (v.length > 0) {
            tblPieles.DataTable().column(i).search(v).draw();
            tblForros.DataTable().column(i).search(v).draw();
            tblTextiles.DataTable().column(i).search(v).draw();
            tblSinteticos.DataTable().column(i).search(v).draw();
            onCalcularAlBuscar();
        } else {
            tblPieles.DataTable().column(i).search('').draw();
            tblForros.DataTable().column(i).search('').draw();
            tblTextiles.DataTable().column(i).search('').draw();
            tblSinteticos.DataTable().column(i).search('').draw();
            onCalcularAlBuscar();
        }
    }

    function onBuscarAlEntregar(i, v) {
        if (v.length > 0) {
            tblRegresos.DataTable().column(i).search(v).draw();
        } else {
            tblRegresos.DataTable().column(i).search('').draw();
        }
    }

    function onCalcularAlBuscar() {
        $(Pieles.column(8).footer()).html($.number(
                Pieles.column(8, {page: 'current'}).data().reduce(function (a, b) {
            return parseFloat(a) + parseFloat(b);
        }, 0), 3, '.', ','));
        $(Forros.column(8).footer()).html($.number(
                Forros.column(8, {page: 'current'}).data().reduce(function (a, b) {
            return parseFloat(a) + parseFloat(b);
        }, 0), 3, '.', ','));
        $(Textiles.column(8).footer()).html($.number(
                Textiles.column(8, {page: 'current'}).data().reduce(function (a, b) {
            return parseFloat(a) + parseFloat(b);
        }, 0), 3, '.', ','));
        $(Sinteticos.column(8).footer()).html($.number(
                Sinteticos.column(8, {page: 'current'}).data().reduce(function (a, b) {
            return parseFloat(a) + parseFloat(b);
        }, 0), 3, '.', ','));
    }

    function init() {
        getEmpleados();
        Semana.focus();
        onBuscarX(1, '');
        onBuscarX(9, '');
        onBuscarX(10, '');
        onCalcularAlBuscar();
    }

    function onComprobarSemana(e) {
        $.getJSON('<?php print base_url('AsignaPFTSACXC/onComprobarSemana'); ?>', {SEMANA: $(e).val()}).done(function (data) {
            console.log(data);
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {

        });
    }

    function getTextiles() {
        Textiles.clear().draw();
        HoldOn.open({
            theme: 'sk-bounce',
            message: 'Obteniendo textiles...'
        });
        $.getJSON('<?php print base_url('AsignaPFTSACXC/getTextiles'); ?>', {SEMANA: (Semana.val() !== '') ? Semana.val() : '', CONTROL: (Control.val() !== '') ? Control.val() : ''})
                .done(function (data) {
                    var tt = 0.0;
                    $.each(data, function (k, v) {
                        Textiles.row.add([v.ID, v.CONTROL, v.ARTICULO_CLAVE, v.ARTICULO_DESCRIPCION, v.UM, v.PIEZA, v.PIEZA_DESCRIPCION, v.GRUPO, v.CANTIDAD, v.SEMANA, v.FRACCION, v.PARES]).draw();
                    });
                }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            onCalcularAlBuscar();
            HoldOn.close();
            Textiles.order([1, 'desc']).draw();
        });
    }

    function getSinteticos() {
        Sinteticos.clear().draw();
        HoldOn.open({
            theme: 'sk-bounce',
            message: 'Obteniendo sinteticos...'
        });
        $.getJSON('<?php print base_url('AsignaPFTSACXC/getSinteticos'); ?>', {SEMANA: (Semana.val() !== '') ? Semana.val() : '', CONTROL: (Control.val() !== '') ? Control.val() : ''})
                .done(function (data) {
                    $.each(data, function (k, v) {
                        Sinteticos.row.add([v.ID, v.CONTROL, v.ARTICULO_CLAVE, v.ARTICULO_DESCRIPCION, v.UM, v.PIEZA, v.PIEZA_DESCRIPCION, v.GRUPO, v.CANTIDAD, v.SEMANA, v.FRACCION, v.PARES]).draw();
                    });
                }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            onCalcularAlBuscar();
            HoldOn.close();
            Sinteticos.order([1, 'desc']).draw();
        });
    }

    function onChecarSemanaValida(e) {
        var n = $(e);
        if (n.val() !== '') {
            $.getJSON('<?php print base_url('AsignaPFTSACXC/onChecarSemanaValida'); ?>', {ID: $(e).val()}).done(function (data) {
                if (parseInt(data[0].Semana) <= 0) {
                    var options = {
                        title: "INDIQUE UNA SEMANA DE PRODUCCIÓN VÁLIDA",
                        text: "LA SEMANA " + $(e).val() + " NO EXISTE O NO HA SIDO GENERADA.",
                        icon: "warning",
                        focusConfirm: true,
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    };
                    swal(options).then((value) => {
                        $(e).val('').focus().select();
                    });
                }
            }).fail(function (x) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            }).always(function () {
            });
        }
    }

    function onEntregar(e, evt) {
        if (evt.keyCode === 13) {
            console.log('KEY CODE 13');
            onEntregarMaterial();
        }
    }

    function onEntregarMaterial() {
        var seguro = true;
        if (Entregar.val() > Explosion.val()) {
            swal({
                title: "ATENCIÓN",
                text: "VA ENTREGAR MATERIAL EXTRA, ¿ESTA SEGURO?",
                icon: "info",
                buttons: {
                    resumetour: {
                        text: "CANCELAR",
                        value: "cancelar"
                    },
                    endtour: {
                        text: "ACEPTAR",
                        value: "aceptar"
                    }
                }}).then((value) => {
                switch (value) {
                    case "aceptar":
                        seguro = true;
                        break;
                    case "cancelar":
                        seguro = false;
                        Entregar.focus();
                        break;
                }
            });
        } else {
            console.log('Entregar.val() > Explosion.val() ELSE');
        }

        if (seguro) {
            $.post('<?php print base_url('AsignaPFTSACXC/onEntregarPielForroTextilSintetico'); ?>', {
                TIPO: tipo_consumo,
                ORDENDEPRODUCCION: OrdenDeProduccion.val(),
                PARES: Pares.val(),
                SEMANA: Semana.val(),
                CONTROL: Control.val(),
                FRACCION: Fraccion.val(),
                ARTICULO: ClaveArticulo.val(),
                ARTICULOT: Articulo.val(),
                EXPLOSION: Explosion.val(),
                ENTREGA: Entregar.val(),
                MATERIAL_EXTRA: MaterialExtra[0].checked ? 1 : 0
            }).done(function (data) {
                console.log(data);
                swal('ATENCIÓN', 'SE HA ENTREGADO ' + Entregar.val() + ' DEL MATERIAL SOLICITADO, EN LA SEMANA ' + Semana.val() + ' PARA LA FRACCIÓN "' + Fraccion.val(), 'success').then((value) => {

                    Fraccion.val('');
                    ClaveArticulo.val('');
                    Articulo.val('');
                    Explosion.val('');
                    Entregar.val('');
                    Entregar.prop('readonly', true);
                    MaterialExtra[0].checked = false;
                    onBuscarX(1, '');
                    onBuscarX(9, '');
                    onBuscarX(10, '');
                    ControlesAsignados.ajax.reload();
                    Fraccion.focus().select();
                    tipo_consumo = 0;
                });
            }).fail(function (x, y, z) {
                console.log(x.responseText);
            }).always(function () {

            });
        }
    }

    function getEmpleados() {
        $.getJSON(master_url + 'getEmpleados').done(function (data) {
            $.each(data, function (k, v) {
                mdlRetornaMaterial.find("#Cortador")[0].selectize.addOption({text: v.EMPLEADO, value: v.CLAVE});
            });
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onDevolverPielForro() {
        var fields = ["Cortador", "PielForro", "Control"];
        var valid = false, ftv = "";
        for (var i = 0; i < fields.length; i++) {
            if (mdlRetornaMaterial.find("#" + fields[i]).val() === '' && mdlRetornaMaterial.find("#" + fields[i]).val().length > 0) {
                ftv = fields[i];
                valid = false;
                break;
            } else {
                valid = true;
            }
        }
        if (valid) {
            var entrego = mdlRetornaMaterial.find("#Entrego").val(),
                    retorno = parseFloat(mdlRetornaMaterial.find("#AnteriormenteRetorno").val()) + parseFloat(mdlRetornaMaterial.find("#Regreso").val());
            console.log(entrego, '|', entrego + ' >=' + retorno, ' ', entrego >= retorno);
            if (entrego >= retorno || parseInt(entrego) === 0) {
                if (mdlRetornaMaterial.find("#ID").val() !== '') {
                    onRetornar();
                } else {
                    onBeep(2);
                    swal('ATENCIÓN', 'DEBE DE SELECCIONAR UN REGISTRO', 'warning').then((value) => {
                        mdlRetornaMaterial.find("#tblRegresos tbody tr").addClass("highlight-rows");
                        setTimeout(function () {
                            mdlRetornaMaterial.find("#tblRegresos tbody tr").removeClass("highlight-rows");
                        }, 2500);
                    });
                }
            } else {
                if (mdlRetornaMaterial.find("#MaterialExtraRetorna")[0].checked) {
                    onRetornar();
                } else {
                    onBeep(2);
                    swal('ATENCIÓN', 'NO SE PUEDE DEVOLVER MÁS PRODUCTO DEL QUE SE ENTREGO', 'warning').then((value) => {
                        mdlRetornaMaterial.find("#Regreso").focus().select();
                    });
                }
            }
        } else {
            swal('ATENCIÓN', 'DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS', 'warning').then((value) => {
                onBeep(2);
                if (mdlRetornaMaterial.find("#" + ftv).is('select')) {
                    mdlRetornaMaterial.find("#" + ftv).parent().addClass("highlight-rows");
                    setTimeout(function () {
                        mdlRetornaMaterial.find("#" + ftv).parent().removeClass("highlight-rows");
                    }, 2500);
                    mdlRetornaMaterial.find("#" + ftv)[0].selectize.open();
                    mdlRetornaMaterial.find("#" + ftv)[0].selectize.focus();
                } else {
                    mdlRetornaMaterial.find("#" + ftv).parent().addClass("highlight-rows");
                    setTimeout(function () {
                        mdlRetornaMaterial.find("#" + ftv).parent().removeClass("highlight-rows");
                    }, 2500);
                    mdlRetornaMaterial.find("#" + ftv).focus();
                }
            });
        }
    }

    function onRetornar() {
        if (mdlRetornaMaterial.find("#Cortador").val() && mdlRetornaMaterial.find("#Regreso").val()) {
            HoldOn.open({
                theme: 'sk-bounce',
                message: 'DEVOLVIENDO...'
            });
            $.post('<?php print base_url('AsignaPFTSACXC/onDevolverPielForro'); ?>', {
                ID: mdlRetornaMaterial.find("#IDA").val(),
                EMPLEADO: mdlRetornaMaterial.find("#CortadorClave").val(),
                ARTICULO: mdlRetornaMaterial.find("#Articulo").val(),
                PIELFORRO: mdlRetornaMaterial.find("#PielForro").val(),
                CONTROL: mdlRetornaMaterial.find("#Control").val(),
                ENTREGO: mdlRetornaMaterial.find("#Entrego").val(),
                REGRESO: mdlRetornaMaterial.find("#Regreso").val(),
                MATERIALMALO: mdlRetornaMaterial.find("#MatMalo").val(),
                EXTRA: mdlRetornaMaterial.find("#MaterialExtraRetorna")[0].checked ? 1 : 0,
                PRECIO: mdlRetornaMaterial.find("#Precio").val()
            }).done(function (data) {
                console.log(data);
                swal('ATENCIÓN', 'SE HA RETORNADO MATERIAL', 'success').then((value) => {
                    CortadorClave.focus().select();
                    onEnable(Cortador);
                    onEnable(btnAceptar);
                    Regresos.ajax.reload();
                    ControlesAsignados.ajax.reload();
                });
            }).fail(function (x, y, z) {
                console.log(x.responseText, y, z);
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO ' + x.responseText, 'warning');
            }).always(function () {
                HoldOn.close();
                mdlRetornaMaterial.find('input').val('');
                mdlRetornaMaterial.find("#Cortador")[0].selectize.clear(true);
            });
        } else {
            swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CORTADOR, SI ES PIEL O FORRO, UN CONTROL VÁLIDO, UN REGISTRO DE ASIGNACIÓN DE CONTROL, CUANTO REGRESO EL CORTADOR Y SI TIENE MATERIAL MALO O DEFECTUOSO O SI ES MATERIAL EXTRA', 'warning').then((value) => {

            });
        }
    }
</script>
<style>
    td {
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }

    tr:hover td{
        background-color: #3276b1 !important;
        color: #fff;
    }
    .highlight-rows{
        width:100px;
        height:20px;
        color: #000;
        background:#ffcc33;
        animation: myfirst 3s;
        -moz-animation:myfirst 3s infinite; /* Firefox */
        -webkit-animation:myfirst 3s infinite; /* Safari and Chrome */
        font-weight: bold;
    }

    @-moz-keyframes myfirst /* Firefox */
    {
        0%   {background:#ffcc33; color:#000;}
        50%  {background:#ffffff;color:#000;}
        100%   {background:#ffcc33;color:#000;}
    }

    @-webkit-keyframes myfirst /* Firefox */
    {
        0%   {background:#ffcc33;color:#000;}
        50%  {background:#ffffff;color:#000;}
        100%   {background:#ffcc33;color:#000;}
    }
</style>
<style>
    .card{
        border-width: 1px 2px 2px;
        border-style: solid;
        border-image: linear-gradient(to bottom,  #2196F3, #99cc00, rgb(0,0,0,0)) 1 100% ;
        border-image: linear-gradient(to bottom,  #2196F3, #99cc00, rgb(0,0,0,0)) 1 100% ;

    }
    .card-header{
        background-color: transparent;
        border-bottom: 0px;
    }
</style>