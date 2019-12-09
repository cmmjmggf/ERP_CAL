<div id="mdlNuevoModulo" class="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-puzzle-piece"></span> Nuevo modulo</h5>
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
<script>
    var mdlNuevoModulo = $("#mdlNuevoModulo"), modulo_nuevo = $("#modulo_nuevo"),
            btnGuardarModulo = mdlNuevoModulo.find("#btnGuardarModulo"),
            NombreModulo = mdlNuevoModulo.find("#NombreModulo"),
            NombreIcono = mdlNuevoModulo.find("#NombreIcono"),
            Orden = mdlNuevoModulo.find("#Orden"),
            ReferenciaModulo = mdlNuevoModulo.find("#ReferenciaModulo");

    $(document).ready(function () {

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