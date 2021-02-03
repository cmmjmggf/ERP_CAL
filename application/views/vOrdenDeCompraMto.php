<div id="pnlTablero" class="card m-2">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title"><span class="fa fa-file"></span> ORDEN DE COMPRA MANTENIMIENTO</h4> 
            </div>
            <div class="col-4" align="right">
                <button type="button" id="btnNuevo" name="btnNuevo" class="btn btn-success">
                    <span class="fa fa-star"></span> NUEVO
                </button>
            </div>
        </div>
        <div class="col-12">
            <table id="tblHerramientas" class="table table-hover table-sm" style="width: 100%;">
                <thead>
                    <tr style="background-color: #000000; color: #ffffff;">
                        <th scope="col">ID</th>
                        <th scope="col">FOLIO</th>
                        <th scope="col">FECHA</th>
                        <th scope="col">PROVEEDOR</th>
                        <th scope="col">DESTINO</th>
                        <th scope="col">OBSERVACIONES</th>
                        <th scope="col">TOTAL</th>
                        <th scope="col">-</th>
                    </tr>
                </thead>
                <tbody> 
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="pnlNuevo" class="card m-2 animated fadeIn d-none">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title"><span class="fa fa-arrow-left atras_arrow" onclick="btnCancelaODCMto.trigger('click')"></span> ORDEN DE COMPRA MANTENIMIENTO</h4> 
            </div> 
            <div class="col-4" align="right">
                <button type="button" id="btnCancelaODCMto" class="btn btn-danger d-none">
                </button>
                <button type="button" id="btnGuardarODCMTO" class="btn btn-success">
                    <span class="fa fa-save"></span>  GUARDAR ORDEN
                </button>
            </div>
            <div class="w-100"></div>  
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-1 text-center">  
                        <button type="button" id="btnImprimeOrdenDeCompraMto" name="btnImprimeOrdenDeCompraMto" class="btn btn-info mt-3">
                            <span class="fa fa-print"></span> IMPRIMIR
                        </button>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">  
                        <label>FOLIO</label>
                        <input type="text" id="FolioOrdenCompraMto" name="FolioOrdenCompraMto" class="form-control" autofocus="" style="color: #d32f2f !important; padding-top: 0px;    padding-bottom: 0px;    font-size: 18px;">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">  
                        <label>FECHA</label>
                        <input type="text" id="FechaOrdenCompraMto" name="FechaOrdenCompraMto" class="form-control date notEnter">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-2 col-md-2 col-lg-5 col-xl-5">  
                        <label>PROVEEDOR</label>
                        <select id="ProveedorOrdenCompraMto"  class="form-control form-control-sm">

                        </select> 
                    </div>
                    <div class="col-2 col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-1">  
                        <button type="button" id="btnAgregaProveedorMto" name="btnAgregaProveedorMto" class="btn btn-primary mt-3 notEnter">
                            <span class="fa fa-plus"></span> PROVEEDORES
                        </button>
                    </div>
                    <div class="col-5">  
                        <label>DESTINO DEL MATERIAL</label>
                        <input type="text" id="DestinoMaterialOrdenCompraMto" name="DestinoMaterialOrdenCompraMto" class="form-control"> 
                    </div>
                    <div class="col-5">  
                        <label>OBSERVACIONES</label>
                        <input type="text" id="ObservacionesOrdenCompraMto" name="ObservacionesOrdenCompraMto" class="form-control"> 
                    </div>
                    <div class="col-2 mt-4">  
                        <span class="switch switch-lg">
                            <input id="FacturaRemisionMto" name="FacturaRemisionMto" type="checkbox" class="switch form-control-sm" value="" checked="">
                            <label for="FacturaRemisionMto">FACTURA</label>
                        </span>
                    </div> 
                    <div class="w-100 my-2"><hr>  </div>
                    <div class="col-2">  
                        <label>CANTIDAD</label>
                        <input type="text" id="CantidadOrdenCompraMto" name="CantidadOrdenCompraMto" class="form-control numbersOnly" maxlength="4"> 
                    </div>
                    <div class="col-2">  
                        <label>UNIDAD</label>
                        <select id="UnidadOrdenCompraMto" class="form-control">

                        </select>
                    </div>
                    <div class="col-1 text-center">  
                        <button type="button" id="btnAgregaUnidad" name="btnAgregaUnidad" class="btn btn-primary mt-4 notEnter" style="background-color: #673ab7;
                                border-color: #673ab7;">
                            <span class="fa fa-plus"></span> UNIDADES
                        </button>
                    </div>
                    <div class="col-4">  
                        <label>DESCRIPCIÓN</label>
                        <input type="text" id="DescripcionOrdenCompraMto" name="DescripcionOrdenCompraMto" class="form-control" maxlength="400"> 
                    </div>
                    <div class="col-2">  
                        <label>PRECIO</label>
                        <input type="text" id="PrecioOrdenCompraMto" name="PrecioOrdenCompraMto" class="form-control numbersOnly"> 
                    </div>
                    <div class="col-1 text-center">  
                        <button type="button" id="btnAceptaMaterial" name="btnAceptaMaterial" class="btn btn-success mt-4" style="background-color: #3f51b5;    border-color: #3f51b5;">
                            <span class="fa fa-check"></span> AGREGAR
                        </button>
                    </div>
                    <div class="w-100 my-2"><hr>  </div>
                    <div class="col-12 mt-2">
                        <table id="tblMaterialesMto" class="table table-hover table-sm nowrap" style="width: 100%;">
                            <thead>
                                <tr style="background-color: #000000; color: #ffffff;">
                                    <th scope="col">ID</th> 
                                    <th scope="col">-</th> 
                                    <th scope="col">CANTIDAD</th> 
                                    <th scope="col">UNIDAD</th> 
                                    <th scope="col">DESCRIPCIÓN</th> 

                                    <th scope="col">PRECIO</th> 
                                    <th scope="col">TOTAL</th> 
                                    <th scope="col">ESTATUS</th> 
                                    <th scope="col">UNIDADID</th> 
                                </tr>
                            </thead>
                            <tbody> 
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
            <div class="col-4 text-center d-none">
                <div class="row">
                    <div class="col-1 text-center">
                        <input type="file" id="FotosMTO" class="d-none" multiple=""></div>
                    <button type="button" class="btn btn-primary btn-sm" onclick="pnlNuevo.find('#FotosMTO').trigger('click')" style="background-color: #660099;">
                        <span class="fa fa-upload"></span>
                    </button>
                </div>
                <div class="col-10 text-center">
                    <a href="<?php print base_url('img/camera.png'); ?>" data-fancybox>
                        <img src="<?php print base_url('img/camera.png'); ?>" id="ImagenPrincipalOCMto" class="img-responsive img-fluid imagen_principal"  ondrop="dropHandler(event);" ondragover="dragOverHandler(event);" style="cursor: pointer;">
                    </a>
                </div>   
                <div class="col-1 text-center">
                </div>
                <div id="ContenedorMTO" class="col-12">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal" id="mdlAgregaUnidad">
    <div class="modal-dialog  modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content"> 
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title">
                            <span class="fa fa-puzzle-piece"></span> Nueva unidad
                        </h5>
                    </div>
                    <div class="col-6">
                        <label>NOMBRE</label>
                        <input type="text" id="NombreUnidad" name="NombreUnidad" class="form-control" maxlength="44">
                    </div>
                    <div class="col-4">
                        <label>ABREVIACIÓN</label>
                        <input type="text" id="AbreviacionUnidad" name="AbreviacionUnidad" class="form-control" maxlength="10">
                    </div>
                    <div class="col-2">
                        <button type="button" id="btnGuardaUnidad" name="btnGuardaUnidad" class="btn btn-info mt-3">
                            <span class="fa fa-check"></span> GUARDAR
                        </button>
                    </div>
                    <div class="w-100 my-2"><hr></div>
                    <div class="col-12">
                        <table id="tblUnidadesMto" class="table table-hover table-sm" style="width: 100%;">
                            <thead>
                                <tr style="background-color: #000; color: #fff;">
                                    <th scope="col">ID</th>
                                    <th scope="col">NOMBRE</th>
                                    <th scope="col">ABREVIACION</th>
                                    <th scope="col">REGISTRO</th>
                                </tr>
                            </thead>
                            <tbody> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="mdlAgregaProveedorMto">
    <div class="modal-dialog  modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content"> 
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title">
                            <span class="fa fa-puzzle-piece"></span> Nuevo Proveedor
                        </h5>
                    </div>  
                    <input type="text" id="IDProveedorMto" name="IDProveedorMto" class="d-none" readonly="">
                    <div class="col-5">
                        <label>NOMBRE</label>
                        <input type="text" id="NombreProveedorMto" name="NombreProveedorMto" class="form-control" maxlength="44">
                    </div> 
                    <div class="col-5">
                        <label>TELÉFONO</label>
                        <input type="text" id="TelefonoProveedorMto" name="TelefonoProveedorMto" class="form-control" maxlength="44">
                    </div> 
                    <div class="col-2">
                        <button type="button" id="btnGuardaProveedorMto" name="btnGuardaProveedorMto" class="btn btn-info mt-3">
                            <span class="fa fa-check"></span> GUARDAR
                        </button>
                    </div>
                    <div class="w-100 my-2"><hr></div>
                    <div class="col-12">
                        <table id="tblProveedoresMto" class="table table-hover table-sm" style="width: 100%;">
                            <thead>
                                <tr style="background-color: #000; color: #fff;">
                                    <th scope="col">ID</th>
                                    <th scope="col">NOMBRE</th> 
                                    <th scope="col">TELÉFONO</th> 
                                    <th scope="col">REGISTRO</th>
                                </tr>
                            </thead>
                            <tbody> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var pnlTablero = $("#pnlTablero"), pnlNuevo = $("#pnlNuevo"), btnNuevo = pnlTablero.find("#btnNuevo"),
            FolioOrdenCompraMto = pnlNuevo.find('#FolioOrdenCompraMto'),
            btnImprimeOrdenDeCompraMto = pnlNuevo.find('#btnImprimeOrdenDeCompraMto'),
            FechaOrdenCompraMto = pnlNuevo.find("#FechaOrdenCompraMto"),
            ProveedorOrdenCompraMto = pnlNuevo.find('#ProveedorOrdenCompraMto'),
            btnAgregaProveedorMto = pnlNuevo.find('#btnAgregaProveedorMto'),
            DestinoMaterialOrdenCompraMto = pnlNuevo.find('#DestinoMaterialOrdenCompraMto'),
            CantidadOrdenCompraMto = pnlNuevo.find('#CantidadOrdenCompraMto'),
            UnidadOrdenCompraMto = pnlNuevo.find('#UnidadOrdenCompraMto'),
            DescripcionOrdenCompraMto = pnlNuevo.find('#DescripcionOrdenCompraMto'),
            PrecioOrdenCompraMto = pnlNuevo.find('#PrecioOrdenCompraMto'), MaterialesMto,
            btnCancelaODCMto = pnlNuevo.find('#btnCancelaODCMto'),
            btnAceptaMaterial = pnlNuevo.find('#btnAceptaMaterial'),
            btnAgregaUnidad = pnlNuevo.find('#btnAgregaUnidad'),
            btnGuardarODCMTO = pnlNuevo.find('#btnGuardarODCMTO'),
            tblHerramientas = pnlTablero.find('#tblHerramientas'), Herramientas,
            tblMaterialesMto = pnlNuevo.find('#tblMaterialesMto'),
            FacturaRemisionMto = pnlNuevo.find('#FacturaRemisionMto'),
            ObservacionesOrdenCompraMto = pnlNuevo.find('#ObservacionesOrdenCompraMto'),
            mdlAgregaUnidad = $('#mdlAgregaUnidad'),
            mdlAgregaProveedorMto = $('#mdlAgregaProveedorMto'),
            tblUnidadesMto = mdlAgregaUnidad.find('#tblUnidadesMto'), UnidadesMto,
            tblProveedoresMto = mdlAgregaProveedorMto.find('#tblProveedoresMto'), ProveedoresMto,
            IDProveedorMto = mdlAgregaProveedorMto.find('#IDProveedorMto'), nuevo_proveedor = true,
            NombreProveedorMto = mdlAgregaProveedorMto.find('#NombreProveedorMto'),
            TelefonoProveedorMto = mdlAgregaProveedorMto.find('#TelefonoProveedorMto'),
            btnGuardaProveedorMto = mdlAgregaProveedorMto.find("#btnGuardaProveedorMto"),
            btnGuardaUnidad = mdlAgregaUnidad.find("#btnGuardaUnidad"),
            hoy = '<?php print Date('d/m/Y'); ?>', nuevo = true;

    onOpenOverlay('Cargando...');
    $(document).ready(function () {
        handleEnterDiv(pnlNuevo);
        handleEnterDiv(mdlAgregaUnidad);
        handleEnterDiv(mdlAgregaProveedorMto);

        btnAgregaProveedorMto.click(function () {
            mdlAgregaProveedorMto.modal('show');
        });

        btnGuardaProveedorMto.click(function () {
            if (NombreProveedorMto.val()) {
                var params = {
                    ID: IDProveedorMto.val(),
                    NOMBRE: NombreProveedorMto.val(),
                    TELEFONO: TelefonoProveedorMto.val()
                };
                if (nuevo_proveedor) {
                    params["NUEVO"] = 1;
                } else {
                    params["NUEVO"] = 2;
                }
                $.post('<?php print base_url('OrdenDeCompraMto/onGuardarProveedorMto'); ?>', params).done(function (a) {
                    nuevo_proveedor = true;
                    swal({
                        title: "ATENCIÓN",
                        text: "PROVEEDOR GUARDADO",
                        icon: "success",
                        buttons: false,
                        timer: 750
                    }).then(value => {
                        ProveedoresMto.ajax.reload(function () {
                            NombreProveedorMto.val('');
                            TelefonoProveedorMto.val('');
                            NombreProveedorMto.focus().select();
                        });
                    });
                }).fail(function (x) {
                    console.log(x.responseText);
                    getError(x);
                });
            } else {
                onCampoInvalido(mdlAgregaProveedorMto, "ES NECESARIO ESPECIFICAR UN NOMBRE PARA EL PROVEEDOR", function () {
                    NombreProveedorMto.focus().select();
                });
            }
        });

        mdlAgregaUnidad.on('shown.bs.modal', function () {
            UnidadesMto.ajax.reload();
        });

        mdlAgregaProveedorMto.on('hidden.bs.modal', function () {
            getProveedoresOrdenDeCompraMto();
            nuevo_proveedor = true;
            mdlAgregaProveedorMto.find("input").val('');
        });

        mdlAgregaProveedorMto.on('shown.bs.modal', function () {
            ProveedoresMto.ajax.reload(function () {
                NombreProveedorMto.focus();
            });
        });

        FacturaRemisionMto.change(function () {
            switch ($(this)[0].checked) {
                case true:
                    $(this).parent().find('label').text('FACTURA');
                    break;
                case false:
                    $(this).parent().find('label').text('REMISIÓN');
                    break;
            }
        });

        btnImprimeOrdenDeCompraMto.click(function () {
            if (FolioOrdenCompraMto.val()) {
                onOpenOverlay('');
                getOrdenXFolio();
            } else {
                onCampoInvalido(pnlNuevo, "DEBE DE ESPECIFICAR UN FOLIO", function () {
                    FolioOrdenCompraMto.focus();
                });
            }
        });

        UnidadOrdenCompraMto.change(function () {
            if (UnidadOrdenCompraMto.val()) {
                onDisable(btnAgregaUnidad);
                onDisableOnTime(btnAgregaUnidad, 1000);
                DescripcionOrdenCompraMto.focus();
            } else {
                onEnable(btnAgregaUnidad);
            }
        }).keydown(function () {
            if (UnidadOrdenCompraMto.val()) {
                onDisable(btnAgregaUnidad);
                onDisableOnTime(btnAgregaUnidad, 1000);
                DescripcionOrdenCompraMto.focus();
            } else {
                onEnable(btnAgregaUnidad);
            }
        });

        btnGuardaUnidad.click(function () {
            var nu = mdlAgregaUnidad.find("#NombreUnidad");
            if (nu.val()) {
                $.post('<?php print base_url('OrdenDeCompraMto/onGuardarUnidad'); ?>',
                        {NOMBRE: nu.val(),
                            ABREVIATURA: mdlAgregaUnidad.find("#AbreviacionUnidad").val()
                        }).done(function (a) {
                    swal({
                        title: "ATENCIÓN",
                        text: "UNIDAD AGREGADA ",
                        icon: "success",
                        buttons: false,
                        timer: 750
                    }).then(value => {
                        UnidadesMto.ajax.reload(function () {
                            nu.val('');
                            mdlAgregaUnidad.find("#AbreviacionUnidad").val('');
                            nu.focus().select();
                        });
                    });
                }).fail(function (x) {
                    console.log(x.responseText);
                    getError(x);
                });
            } else {
                onCampoInvalido(pnlNuevo, "DEBE DE ESPECIFICAR EL NOMBRE DE LA UNIDAD.", function () {
                    mdlAgregaUnidad.find("#NombreUnidad").focus().select();
                });
            }
        });

        mdlAgregaUnidad.on('shown.bs.modal', function () {
            mdlAgregaUnidad.find("input").val('');
            mdlAgregaUnidad.find("#NombreUnidad").focus();
        });

        mdlAgregaUnidad.on('hidden.bs.modal', function () {
            getUnidadesOrdenDeCompraMto();
            mdlAgregaUnidad.find("input").val('');
        });

        btnAgregaUnidad.click(function () {
            mdlAgregaUnidad.modal('show');
        });

        ProveedorOrdenCompraMto.change(function () {
            if ($(this).val()) {
                onDisableOnTime(btnAgregaProveedorMto, 1500);
                DestinoMaterialOrdenCompraMto.focus().select();
            }
        }).keydown(function () {
            if ($(this).val()) {
                onDisableOnTime(btnAgregaProveedorMto, 1000);
                DestinoMaterialOrdenCompraMto.focus().select();
            }
        });

        FolioOrdenCompraMto.keydown(function (e) {
            if (e.keyCode === 13 && FolioOrdenCompraMto.val()) {
                onDisableOnTime(btnImprimeOrdenDeCompraMto, 1000);
            }
        });

        btnGuardarODCMTO.click(function () {
            if (FolioOrdenCompraMto.val() && FechaOrdenCompraMto.val() &&
                    ProveedorOrdenCompraMto.val() && DestinoMaterialOrdenCompraMto.val()
                    && MaterialesMto.data().count() > 0) {
                var hmr = [];
                $.each(MaterialesMto.rows().data(), function (k, v) {
                    console.log(v);
                    switch (v[7]) {
                        case 'NUEVO':
                            hmr.push({
                                CANTIDAD: v[2],
                                UNIDAD: v[8],
                                DESCRIPCION: v[4],
                                PRECIO: v[5],
                                ESTATUS: 1
                            });
                            break;
                    }
                });
                console.log(hmr);
                onOpenOverlay('Guardando...');
                $.post('<?php print base_url('OrdenDeCompraMto/onGuardar') ?>', {
                    FACTURA: FacturaRemisionMto[0].checked ? 1 : 2,
                    FOLIO: FolioOrdenCompraMto.val(),
                    FECHA: FechaOrdenCompraMto.val(),
                    PROVEEDOR: ProveedorOrdenCompraMto.val(),
                    DESTINO: DestinoMaterialOrdenCompraMto.val(),
                    OBSERVACIONES: ObservacionesOrdenCompraMto.val(),
                    HERRAMIENTA_MATERIAL_REFACCION: ProveedorOrdenCompraMto.val(),
                    DETALLE: JSON.stringify(hmr)
                }).done(function (a) {
                    console.log(a);
                    swal({
                        title: "ATENCIÓN",
                        text: "ORDEN GUARDADA",
                        icon: "success"
                    }).then(value => {
                        getOrdenXFolio();
                        Herramientas.ajax.reload(function () {
                            btnCancelaODCMto.trigger('click');
                        });
                    });
                }).fail(function (x) {
                    getError(x);
                });
            } else {
                onCampoInvalido(pnlNuevo, "DEBE DE ESPECIFICAR TODOS LOS CAMPOS REQUERIDOS Y AGREGAR AL MENOS 1 HERRAMIENTA, MATERIAL O REFACCIÓN..", function () {
                    if (!FolioOrdenCompraMto.val()) {
                        FolioOrdenCompraMto.focus().select();
                        return;
                    } else if (!ProveedorOrdenCompraMto.val()) {
                        ProveedorOrdenCompraMto[0].selectize.focus();
                        ProveedorOrdenCompraMto[0].selectize.open();
                        return;
                    } else if (!DestinoMaterialOrdenCompraMto.val()) {
                        DestinoMaterialOrdenCompraMto.focus().select();
                        return;
                    } else if (!ObservacionesOrdenCompraMto.val()) {
                        ObservacionesOrdenCompraMto.focus().select();
                        return;
                    } else if (MaterialesMto.rows().count() === 0) {
                        CantidadOrdenCompraMto.focus().select();
                    }
                });
            }
        });

        btnAceptaMaterial.click(function () {
            onDisableOnTime(btnAceptaMaterial, 1000);
            if (CantidadOrdenCompraMto.val() && parseFloat(CantidadOrdenCompraMto.val()) > 0) {
                var total = parseFloat(CantidadOrdenCompraMto.val()) * parseFloat(PrecioOrdenCompraMto.val());
                MaterialesMto.row.add([0, '<button type="button" class="btn btn-danger btn-sm" style="background-color: #bb0000; border-color: #bb0000;" onclick="onEliminarMaterial(0,this);"><span class="fa fa-trash"></span></button>', CantidadOrdenCompraMto.val(), UnidadOrdenCompraMto.find("option:selected").text(), DescripcionOrdenCompraMto.val(), PrecioOrdenCompraMto.val(), total, 'NUEVO', UnidadOrdenCompraMto.val()]).draw();
                CantidadOrdenCompraMto.val('');
                UnidadOrdenCompraMto.val('');
                DescripcionOrdenCompraMto.val('');
                PrecioOrdenCompraMto.val('');
                onClear(UnidadOrdenCompraMto);
                CantidadOrdenCompraMto.focus().select();
            } else {
                onCampoInvalido(pnlNuevo, "DEBE DE ESPECIFICAR UNA CANTIDAD MAYOR A CERO.", function () {
                    CantidadOrdenCompraMto.focus().select();
                });
            }
        });

        btnCancelaODCMto.click(function () {
            pnlTablero.removeClass("d-none");
            pnlNuevo.addClass("d-none");
            pnlNuevo.find("input").val("");
            $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
            Herramientas.ajax.reload(function () {

            });
        });

        btnNuevo.click(function () {
            FechaOrdenCompraMto.val(hoy);
            pnlTablero.addClass("d-none");
            pnlNuevo.removeClass("d-none");
            FolioOrdenCompraMto.focus().select();
            MaterialesMto.rows().remove().draw();
            MaterialesMto.columns.adjust().draw();
            getUnidadesOrdenDeCompraMto();
            getProveedoresOrdenDeCompraMto();
            $.getJSON('<?php print base_url("OrdenDeCompraMto/getUltimoFolio"); ?>').done(function (a) {
                FolioOrdenCompraMto.val(a[0].ULTIMO_FOLIO);
                FolioOrdenCompraMto.focus().select();
            }).fail(function (e) {
                getError(e);
            });
        });
        var coldefs = [
            {
                "targets": [0],
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
                "visible": false,
                "searchable": false
            }
        ];
        var xoptions = {
            "dom": 'rt',
            buttons: buttons,
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
            ]
        };
        MaterialesMto = tblMaterialesMto.DataTable(xoptions);
        coldefs = [
            {
                "targets": [5],
                "visible": false,
                "searchable": false
            }
        ];
        Herramientas = tblHerramientas.DataTable({
            "dom": 'Brftip',
            "ajax": {
                "url": '<?php print base_url('OrdenDeCompraMto/getHerramientas'); ?>',
                "dataSrc": ""
            },
            buttons: buttons,
            columns: [
                {"data": "ID"}/*0*/,
                {"data": "FOLIO"}/*2*/,
                {"data": "FECHA"}/*1*/,
                {"data": "PROVEEDOR"}/*3*/,
                {"data": "DESTINO_MATERIAL"}/*4*/,
                {"data": "OBSERVACIONES"}/*5*/,
                {"data": "TOTAL"}/*5*/,
                {"data": "IMPRIME"}/*5*/
            ],
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
            ], initComplete: function () {
                onCloseOverlay();
            },
            "preDrawCallback": function () {
            }
        });

        coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ];
        UnidadesMto = tblUnidadesMto.DataTable({
            "dom": 'Brtip',
            "ajax": {
                "url": '<?php print base_url('OrdenDeCompraMto/getUnidadesOrdenDeCompraMto'); ?>',
                "dataSrc": ""
            },
            buttons: buttons,
            columns: [
                {"data": "ID"}/*0*/,
                {"data": "NOMBRE"}/*2*/,
                {"data": "ABREVIACION"}/*2*/,
                {"data": "REGISTRO"}/*1*/
            ],
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
            ]
        });
        coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ];
        ProveedoresMto = tblProveedoresMto.DataTable({
            "dom": 'Brtip',
            "ajax": {
                "url": '<?php print base_url('OrdenDeCompraMto/getProveedoresOrdenDeCompraMto'); ?>',
                "dataSrc": ""
            },
            buttons: buttons,
            columns: [
                {"data": "ID"}/*0*/,
                {"data": "NOMBRE"}/*1*/,
                {"data": "TELEFONO"}/*2*/,
                {"data": "REGISTRO"}/*3*/
            ],
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
            ]
        });

        tblProveedoresMto.find('tbody').on('click', 'tr', function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'CARGANDO...'
            });
            nuevo_proveedor = false;
            var dtm = ProveedoresMto.row(this).data();
            IDProveedorMto.val(dtm.ID);
            NombreProveedorMto.val(dtm.NOMBRE);
            TelefonoProveedorMto.val(dtm.TELEFONO);
            onCloseOverlay();
        });

        pnlNuevo.find("#FotosMTO").change(function () {
            onOpenOverlay('Cargando fotos...');
            var io = 0;
            Array.from(pnlNuevo.find("#FotosMTO")[0].files).forEach(f => {
                const r = new FileReader();
                r.addEventListener("load", function () {
                    pnlNuevo.find("#ContenedorMTO div.row").append('<div class="col-2 text-center card-image-generated"><button class="btn btn-danger mb-1" onclick="onEliminarFoto(this)"><span class="fa fa-trash"></span></button><a href="' + r.result + '" data-fancybox="images"><img src="' + r.result + '" class="img-fluid imagen_generada' + io + '" onclick="onPrevisualizaImage(this)" style="cursor:pointer;" /></a></div>');
                }, false);
                if (f) {
                    r.readAsDataURL(f);
                }
                io += 1;
            });
            onCloseOverlay();
        });
    });

    function getOrdenXFolio() {
        onOpenOverlay('Generando orden...');
        $.post('<?php print base_url('OrdenDeCompraMto/getOrdenXFolio'); ?>', {
            FOLIO: FolioOrdenCompraMto.val()
        }).done(function (a) {
            if (a.length > 0) {
                onCloseOverlay();
                onImprimirReporteFancyAFC(a, function (a, b) {
                    FolioOrdenCompraMto.focus().select();
                });
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            onCloseOverlay();
        });
    }

    function getOrdenXFolioButton(e) {
        onOpenOverlay('Generando orden...');
        $.post('<?php print base_url('OrdenDeCompraMto/getOrdenXFolio'); ?>', {
            FOLIO: e
        }).done(function (a) {
            if (a.length > 0) {
                onCloseOverlay();
                onImprimirReporteFancyAFC(a, function (a, b) {
                    FolioOrdenCompraMto.focus().select();
                });
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            onCloseOverlay();
        });
    }

    function onEliminarMaterial(estatus, e) {
        switch (estatus) {
            case 0:
                /*REMOVER EN TABLA*/
                console.log(e, $(e).parent(), $(e).parent().parent());
                MaterialesMto.row($(e).parent().parent()).remove().draw();
                swal({
                    title: "ATENCIÓN",
                    text: "REGISTRO ELIMINADO ",
                    icon: "success",
                    buttons: false,
                    timer: 750
                });
                break;
            case 1:
                /*ELIMINA EN BD*/
                break;
        }
    }

    function dragOverHandler(ev) {
        console.log('File(s) in drop zone');
        // Prevent default behavior (Prevent file from being opened)
        ev.preventDefault();
    }

    function dropHandler(ev) {
        var io = 1;
        onOpenOverlay('Cargando fotos...');
        console.log('File(s) dropped');
        // Prevent default behavior (Prevent file from being opened)
        ev.preventDefault();
        if (ev.dataTransfer.items) {
            // Use DataTransferItemList interface to access the file(s)
            for (var i = 0; i < ev.dataTransfer.items.length; i++) {
                // If dropped items aren't files, reject them
                if (ev.dataTransfer.items[i].kind === 'file') {
                    var f = ev.dataTransfer.items[i].getAsFile();
                    console.log('... file[' + i + '].name = ' + f.name);
                    const r = new FileReader();
                    r.addEventListener("load", function () {
                        pnlNuevo.find("#ContenedorMTO div.row").append('<div class="col-2 text-center card-image-generated"><button class="btn btn-danger mb-1" onclick="onEliminarFoto(this)"><span class="fa fa-trash"></span></button><a href="' + r.result + '" data-fancybox="images"><img src="' + r.result + '" class="img-fluid imagen_generada' + io + '" onclick="onPrevisualizaImage(this)" style="cursor:pointer;" /></a></div>');
                    }, false);
                    if (f) {
                        r.readAsDataURL(f);
                    }
                }
            }
            onCloseOverlay();
        } else {
            // Use DataTransfer interface to access the file(s)
            for (var i = 0; i < ev.dataTransfer.files.length; i++) {
                console.log('... file[' + i + '].name = ' + ev.dataTransfer.files[i].name);
            }
        }
        // Pass event to removeDragData for cleanup
        removeDragData(ev);
    }


    function removeDragData(ev) {
        console.log('Removing drag data');
        if (ev.dataTransfer.items) {
            // Use DataTransferItemList interface to remove the drag data
            ev.dataTransfer.items.clear();
        } else {
            // Use DataTransfer interface to remove the drag data
            ev.dataTransfer.clearData();
        }
    }


    function onEliminarFoto(e) {
        onOpenOverlay('Eliminando foto...');
        $(e).parent().remove();
        onCloseOverlay();
    }
    function onPrevisualizaImage(imgn) {
        onOpenOverlay('Cargando foto...');
        pnlNuevo.find("img.imagen_principal")[0].src = $(imgn)[0].src;
        pnlNuevo.find("img.imagen_principal").parent("a")[0].href = $(imgn)[0].src;
        onCloseOverlay();
    }

    function getUnidadesOrdenDeCompraMto() {
        if (UnidadOrdenCompraMto.val() === '') {
            onClearSelect(UnidadOrdenCompraMto);
        }
        $.getJSON('<?php print base_url('OrdenDeCompraMto/getUnidadesOrdenDeCompraMto'); ?>').done(function (data) {
            $.each(data, function (k, v) {
                UnidadOrdenCompraMto[0].selectize.addOption({text: v.UNIDAD, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            getError(x);
        });
    }

    function getProveedoresOrdenDeCompraMto() {
        if (ProveedorOrdenCompraMto.val() === '') {
            onClearSelect(ProveedorOrdenCompraMto);
        }
        $.getJSON('<?php print base_url('OrdenDeCompraMto/getProveedoresOrdenDeCompraMto'); ?>').done(function (data) {
            $.each(data, function (k, v) {
                ProveedorOrdenCompraMto[0].selectize.addOption({text: v.NOMBRE, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            getError(x);
        });
    }
</script>
<style>
    #pnlNuevo input{
        text-align: center;
    }
    .card {
        border: none !important;
    }  

    body::-webkit-scrollbar, #tblHerramientas tbody::-webkit-scrollbar{
        width: 1em;
    }

    body::-webkit-scrollbar-track , #tblHerramientas tbody::-webkit-scrollbar-track {
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }

    body::-webkit-scrollbar-thumb, #tblHerramientas tbody::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom,#00BCFF,#007AFF) !important;
        outline: 1px solid slategrey;
    }
    #tblHerramientas tbody tr td, #tblUnidadesMto tbody tr td{
        font-size: 16px;
        font-weight: bold;
    }
    #tblMaterialesMto tbody tr td{
        font-size: 16px;
        font-weight: bold;
        text-align: center !important;
    }
    .atras_arrow {
        transition: all .2s ease-in-out;
    }
    .atras_arrow:hover{
        cursor: pointer;
        color: #0099ff !important;
        -ms-transform: scale(2,2); /* IE 9 */
        transform: scale(2,2);
    }
</style>