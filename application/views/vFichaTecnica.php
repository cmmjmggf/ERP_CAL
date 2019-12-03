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
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnSuplePZAFT" data-toggle="modal" data-target="#mdlSuplePiezaEnFT">
                        <span class="fa fa-magic"></span> Suple pieza x pieza en F.T
                    </button>
                    <button type="button" class="btn btn-info-blue btn-sm my-1" id="btnSupleMaFT" data-toggle="modal" data-target="#mdlSupleMaterialEnFT">
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

                <div class="col-12 col-sm-12 col-md-3 col-lg-1">
                    <label for="Consumo">PzXPar</label>
                    <input type="text" id="PzXPar" name="PzXPar" class="form-control form-control-sm numbersOnly" maxlength="4">
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-1">
                    <label for="Unidad">Unidad</label>
                    <input type="text"  id="Unidad" name="Unidad" class="form-control form-control-sm numbersOnly" readonly="" maxlength="7">
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-1">
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
    var btnMatSemProd = pnlDatos.find("#btnMatSemProd"), btnArticulos = pnlDatos.find("#btnArticulos"),
            btnEstilos = pnlDatos.find("#btnEstilos"),
            btnColor = pnlDatos.find("#btnColor"), btnEliminarFT = pnlDatos.find("#btnEliminarFT"),
            btnFotos = pnlDatos.find("#btnFotos"), btnCopyFTaFT = pnlDatos.find("#btnCopyFTaFT");

    var btnSuplePZAFT = pnlDatos.find("#btnSuplePZAFT"), btnSupleMaFT = pnlDatos.find("#btnSupleMaFT"), btnSupleMaXLinFTLinea = pnlDatos.find("#btnSupleMaXLinFTLinea"),
            btnArtConsumoXEstiloColor = pnlDatos.find("#btnArtConsumoXEstiloColor"), btnActualizaConsumoEstiloFT = pnlDatos.find("#btnActualizaConsumoEstiloFT"),
            btnAdicionaMatXLin = pnlDatos.find("#btnAdicionaMatXLin");
    var btnAdicionaMaterialFijo = pnlDatos.find("#btnAdicionaMaterialFijo");

    $(document).ready(function () {

        btnAdicionaMaterialFijo.click(function () {
            if (Estilo.val() && Color.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Trabajando en ello... por favor espere'
                });
                $.post('<?php print base_url('FichaTecnica/getFichaTecnicaFija'); ?>', {ESTILO: Estilo.val(), COLOR: Color.val()}).done(function (a) {
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

        btnCopyFTaFT.click(function () {
            mdlCopiarFT.modal('show');
        });
        btnEliminarFT.click(function () {
            mdlEliminaFTXEstilo.modal('show');
            mdlEliminaFTXEstilo.find("#EstiloElimina").focus();
        });

        btnFotos.click(function () {
            mdlEstilosFotos.modal('show');
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
        pnlDatos.find("[name='Articulo']").change(function () {
            if (nuevo) {
                $.getJSON(master_url + 'onGetInfoArticulo', {Articulo: $(this).val()}).done(function (data) {
                    if (data.length > 0) {
                        pnlDatos.find("#Unidad").val(data[0].unidad);
                    }
                }).fail(function (x) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
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
            onBeep(1);
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
                    console.log(data);
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
        handleEnterDiv(pnlTablero);
        handleEnterDiv(pnlDatos);
        handleEnterDiv(pnlControlesDetalle);
        handleEnterDiv(mdlEditarArticulo);


    });


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
                    "targets": [8],
                    "visible": (seguridad === '1' ? false : true),
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
            tblFichaTecnicaDetalle.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });

        tblFichaTecnicaDetalle.find('tbody').on('dblclick', 'tr', function () {
            if (seguridad === '1') {
                tblFichaTecnicaDetalle.find("tbody tr").removeClass("success");
                $(this).addClass("success");
            } else {
                var dtm = FichaTecnicaDetalle.row(this).data();
                mdlEditarArticulo.find("input").val("");
                $.each(mdlEditarArticulo.find("select"), function (k, v) {
                    mdlEditarArticulo.find("select")[k].selectize.clear(true);
                });
                $.each(dtm, function (k, v) {
                    mdlEditarArticulo.find("[name='" + k + "']").val(v);
                });
                (dtm.AfectaPV === '1') ? mdlEditarArticulo.find("#eAfectaPV").prop('checked', true) : mdlEditarArticulo.find("#eAfectaPV").prop('checked', false);
                mdlEditarArticulo.find("[name='Pieza']")[0].selectize.addItem(dtm.Pieza_ID, true);
                mdlEditarArticulo.find("[name='eArticulo']")[0].selectize.addItem(dtm.Articulo_ID, true);
                mdlEditarArticulo.modal('show');
                mdlEditarArticulo.find('#eArticulo')[0].selectize.focus();
            }
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
            onVerificarEstiloCerradoCostos(dtm.EstiloId, dtm.ColorId);
            getFotoXEstilo(dtm.EstiloId);
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
    var seguridad;
    function onVerificarEstiloCerradoCostos(estilo, color) {
        $.getJSON(master_url + 'getEstiloByID', {Estilo: estilo}).done(function (data, x, jq) {
            if (data.length > 0) {
                seguridad = data[0].Seguridad;
                if (seguridad === '1') {
                    getFichaTecnicaDetalleByID(estilo, color);
                    btnEliminarFT.addClass('d-none');
                    btnAgregar.addClass('d-none');
                    btnAdicionaMaterialFijo.addClass('d-none');
                    btnSuplePZAFT.addClass('d-none');
                    btnSupleMaFT.addClass('d-none');
                    btnSupleMaXLinFTLinea.addClass('d-none');
                    btnActualizaConsumoEstiloFT.addClass('d-none');
                    btnArtConsumoXEstiloColor.addClass('d-none');
                    btnAdicionaMatXLin.addClass('d-none');
                    swal('ESTILO BLOQUEADO', 'PARA MODIFICAR SU FICHA TÉCNICA, CONSULTE AL ING. MARCOS O LA SRA. LAURA CUEVAS PARA DESBLOQUEARLO', 'warning').then((value) => {
                        //Acciones
                    });
                } else {
                    getFichaTecnicaDetalleByID(estilo, color);
                    btnEliminarFT.removeClass('d-none');
                    btnAgregar.removeClass('d-none');
                    btnAdicionaMaterialFijo.removeClass('d-none');
                    btnSuplePZAFT.removeClass('d-none');
                    btnSupleMaFT.removeClass('d-none');
                    btnSupleMaXLinFTLinea.removeClass('d-none');
                    btnActualizaConsumoEstiloFT.removeClass('d-none');
                    btnArtConsumoXEstiloColor.removeClass('d-none');
                    btnAdicionaMatXLin.removeClass('d-none');
                }
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
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


                var esf = '<?php print base_url('uploads/Estilos/esf.jpg'); ?>';
                $.ajax({
                    url: base_url + dtm.Foto,
                    type: 'HEAD',
                    error: function ()
                    {
                        vp.html(' <img src="' + esf + '" class="img-thumbnail img-fluid rounded mx-auto " >');
                    },
                    success: function ()
                    {
                        if (dtm.Foto !== null && dtm.Foto !== undefined && dtm.Foto !== '') {
                            var ext = getExt(dtm.Foto);
                            if (ext === "gif" || ext === "jpg" || ext === "png" || ext === "jpeg") {
                                vp.html('<img src="' + base_url + dtm.Foto + '" class="img-thumbnail img-fluid" width="400px" />');
                            }
                            if (ext !== "gif" && ext !== "jpg" && ext !== "jpeg" && ext !== "png" && ext !== "PDF" && ext !== "Pdf" && ext !== "pdf") {
                                vp.html(' <img src="' + esf + '" class="img-thumbnail img-fluid rounded mx-auto " >');
                            }
                        } else {
                            vp.html(' <img src="' + esf + '" class="img-thumbnail img-fluid rounded mx-auto " >');
                        }
                    }
                });




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
    .btn-info-blue{
        color: #fff;
        background-color: #3F51B5 !important;
        border-color: #3F51B5 !important;
    }
</style>