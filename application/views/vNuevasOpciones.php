<div id="mdlNuevoModulo" class="modal">
    <div class="modal-dialog modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-puzzle-piece"></span> Nuevo módulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label>Nombre</label>
                        <input type="text" id="NombreModulo" name="NombreModulo" class="form-control form-control-sm ">
                    </div>
                    <div class="col-6">
                        <label>Icono</label>
                        <input type="text" id="NombreIcono" name="NombreIcono" class="form-control form-control-sm">                            
                    </div>
                    <div class="col-6 vista_previa justify-content-center text-center"> 
                    </div>
                    <div class="col-6">
                        <label>Orden</label>
                        <input type="text" id="Orden" name="Orden" class="form-control form-control-sm ">
                    </div>
                    <div class="col-12">
                        <label>Referencia</label>
                        <input type="text" id="ReferenciaModulo" name="ReferenciaModulo" class="form-control form-control-sm ">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="btnGuardarModulo"><span class="fa fa-save"></span> Guardar</button> 
            </div>
        </div>
    </div>
</div>
<div id="mdlNuevaOpcionXModulo" class="modal">
    <div class="modal-dialog modal-dialog-centered  notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-puzzle-piece"></span> Nueva opción por módulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label>Modulo</label>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" id="xModuloXOpcion" name="xModuloXOpcion" class="form-control form-control-sm">
                            </div>
                            <div class="col-8">
                                <select id="ModuloXOpcion" name="ModuloXOpcion" class="form-control form-control-sm">
                                </select> 
                            </div>
                        </div> 
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-12">
                        <label>Nombre</label>
                        <input type="text" id="NombreOpcion" name="NombreOpcion" class="form-control form-control-sm ">
                    </div>
                    <div class="col-6">
                        <label>Icono</label>
                        <input type="text" id="NombreIconoOpcion" name="NombreIconoOpcion" class="form-control form-control-sm">                            
                    </div>
                    <div class="col-6 vista_previa justify-content-center text-center"> 
                    </div>
                    <div class="col-6">
                        <label>Orden</label>
                        <input type="text" id="OrdenOpcion" name="OrdenOpcion" class="form-control form-control-sm numbersOnly" maxlength="99">
                    </div>
                    <div class="col-12">
                        <label>Referencia</label>
                        <input type="text" id="ReferenciaOpcion" name="ReferenciaOpcion" class="form-control form-control-sm ">
                    </div>
                    <div class="col-4 mt-3"> 
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="EsBoton" name="EsBoton">
                            <label class="custom-control-label" for="EsBoton" >Es Boton</label>
                        </div> 
                    </div>
                    <div class="col-8">
                        <label>Clase(css)</label>
                        <input type="text" id="ClaseCss" name="ClaseCss" placeholder="info,warning, success..." class="form-control form-control-sm " maxlength="999">
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="btnGuardarOpcionxModulo"><span class="fa fa-save"></span> Guardar</button> 
            </div>
        </div>
    </div>
</div>
<script>
    var mdlNuevoModulo = $("#mdlNuevoModulo"), modulo_nuevo = $("#modulo_nuevo"),
            btnGuardarModulo = mdlNuevoModulo.find("#btnGuardarModulo"),
            NombreModulo = mdlNuevoModulo.find("#NombreModulo"),
            NombreIcono = mdlNuevoModulo.find("#NombreIcono"),
            Orden = mdlNuevoModulo.find("#Orden"),
            ReferenciaModulo = mdlNuevoModulo.find("#ReferenciaModulo");

    var mdlNuevaOpcionXModulo = $("#mdlNuevaOpcionXModulo"), opciones_nuevo = $("#opciones_nuevo"),
            btnGuardarOpcionxModulo = mdlNuevaOpcionXModulo.find("#btnGuardarOpcionxModulo"),
            NombreOpcion = mdlNuevaOpcionXModulo.find("#NombreOpcion"),
            NombreIconoOpcion = mdlNuevaOpcionXModulo.find("#NombreIconoOpcion"),
            OrdenOpcion = mdlNuevaOpcionXModulo.find("#OrdenOpcion"),
            ReferenciaOpcion = mdlNuevaOpcionXModulo.find("#ReferenciaOpcion"),
            EsBoton = mdlNuevaOpcionXModulo.find("#EsBoton"),
            ClaseCss = mdlNuevaOpcionXModulo.find("#ClaseCss"),
            xModuloXOpcion = mdlNuevaOpcionXModulo.find("#xModuloXOpcion"),
            ModuloXOpcion = mdlNuevaOpcionXModulo.find("#ModuloXOpcion");

    $(document).ready(function () {

        /*OPCION*/
        NombreIconoOpcion.change(function () {
            if ($(this).val()) {
                mdlNuevaOpcionXModulo.find(".vista_previa").html('<div class="mt-2"></div><span class="' + $(this).val() + ' fa-2x mt-2"></span>');
            }
        });

        btnGuardarOpcionxModulo.click(function () {
            if (NombreOpcion.val() && NombreIconoOpcion.val() && OrdenOpcion.val() && ReferenciaOpcion.val()) {
                onOpenOverlay('');
                var p = {
                    MODULO: ModuloXOpcion.val(), NOMBRE_OPCION: NombreOpcion.val(),
                    ICONO: NombreIconoOpcion.val(), REFERENCIA_OPCION: ReferenciaOpcion.val(),
                    ORDEN_OPCION: OrdenOpcion.val(), BOTON: mdlNuevaOpcionXModulo.find("#EsBoton")[0].checked ? 1 : 0,
                    CLASECSS: mdlNuevaOpcionXModulo.find("#ClaseCss").val()
                };
                $.post('<?php print base_url('ResourceManager/onNuevaOpcionXModulo'); ?>', p).done(function (a) {
                    console.log(a);
                    var r = JSON.parse(a);
                    console.log(r);
                    iMsg("OPCION POR MODULO AGREGADA", "s", function () {
                        onClearPanelInputSelect(mdlNuevaOpcionXModulo, function () {
                            NombreOpcion.focus().select();
                        });
                    });
                }).fail(function (x, y, z) {
                    onError(x);
                }).always(function () {
                    onCloseOverlay();
                });
            } else {
                onCampoInvalido(mdlNuevaOpcionXModulo, "ES NECESARIO ESPECIFICAR TODO LOS PARAMETROS", function () {
                    if (!NombreOpcion.val()) {
                        NombreOpcion.focus().select();
                    } else if (!NombreIconoOpcion.val()) {
                        NombreIconoOpcion.focus().select();
                    } else if (!Orden.val()) {
                        Orden.focus().select();
                    } else if (!ReferenciaOpcion.val()) {
                        ReferenciaOpcion.focus().select();
                    }
                });
            }
        });

        opciones_nuevo.click(function () {
            mdlNuevaOpcionXModulo.modal('show');
        });

        mdlNuevaOpcionXModulo.on('shown.bs.modal', function () {
            mdlNuevaOpcionXModulo.find("#NombreOpcion").focus().select();
        });

        mdlNuevaOpcionXModulo.on('hidden.bs.modal', function () {
            mdlNuevaOpcionXModulo.find("input").val('');
        });


        /*MODULO*/
        NombreIcono.change(function () {
            if ($(this).val()) {
                mdlNuevoModulo.find(".vista_previa").html('<div class="mt-2"></div><span class="' + $(this).val() + ' fa-2x mt-2"></span>');
            }
        });

        btnGuardarModulo.click(function () {
            if (NombreModulo.val() && NombreIcono.val() && Orden.val() && ReferenciaModulo.val()) {
                onOpenOverlay('');
                var p = {
                    MODULO: NombreModulo.val(),
                    ICONO: NombreIcono.val(),
                    REFERENCIA: ReferenciaModulo.val(),
                    ORDEN: Orden.val()
                };
                $.post('<?php print base_url('ResourceManager/onNuevoModulo'); ?>', p).done(function (a) {
                    console.log(a);
                    var r = JSON.parse(a);
                    console.log(r);
                    iMsg("MODULO AGREGADO", "s", function () {
                        onClear(NombreModulo);
                        onClear(NombreIcono);
                        onClear(ReferenciaModulo);
                        onClear(Orden);
                        NombreModulo.focus().select();
                    });
                }).fail(function (x, y, z) {
                    onError(x);
                }).always(function () {
                    onCloseOverlay();
                });
            } else {
                onCampoInvalido(mdlNuevoModulo, "ES NECESARIO ESPECIFICAR TODO LOS PARAMETROS", function () {
                    if (!NombreModulo.val()) {
                        NombreModulo.focus().select();
                    } else if (!NombreIcono.val()) {
                        NombreIcono.focus().select();
                    } else if (!Orden.val()) {
                        Orden.focus().select();
                    } else if (!ReferenciaModulo.val()) {
                        ReferenciaModulo.focus().select();
                    }
                });
            }
        });

        modulo_nuevo.click(function () {
            mdlNuevoModulo.modal('show');
        });

        mdlNuevoModulo.on('shown.bs.modal', function () {
            mdlNuevoModulo.find("#NombreModulo").focus().select();
        });

        mdlNuevoModulo.on('hidden.bs.modal', function () {
            mdlNuevoModulo.find("input").val('');
        });
    });

</script>