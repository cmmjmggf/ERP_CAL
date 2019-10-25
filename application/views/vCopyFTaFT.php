<div class="modal animated" id="mdlCopiarFT">
    <div class="modal-dialog modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-clipboard"></span> Copia ficha tecnica a ficha tecnica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <p class="text-danger font-weight-bold">Copiar Estilo/Color </p>
                    </div>
                    <div class="col-6">
                        <label>Estilo</label>
                        <input type="text" id="EstiloACopiar" name="EstiloACopiar" class="form-control" maxlength="8" placeholder="Estilo...">
                    </div>
                    <div class="col-6">
                        <label>Color</label>
                        <input type="text" id="ColorACopiar" name="ColorACopiar" class="form-control" maxlength="4" placeholder="Color...">
                    </div>
                    <div class="col-12 my-2">
                        <p class="text-danger font-weight-bold">Al Estilo/Color</p>
                    </div>
                    <div class="col-6">
                        <label>Estilo</label>
                        <input type="text" id="EstiloAReemplazar" name="EstiloAReemplazar" class="form-control" maxlength="8" placeholder="Estilo...">
                    </div> 
                    <div class="col-6">
                        <label>Color</label>
                        <input type="text" id="ColorAReemplazar" name="ColorAReemplazar" class="form-control" maxlength="4" placeholder="Color...">
                    </div> 
                </div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-info" id="btnAceptar"><span class="fa fa-check"></span> Aceptar</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlCopiarFT = $("#mdlCopiarFT"), btnAceptarCopiar = mdlCopiarFT.find("#btnAceptar");

    $(document).ready(function () {  
        handleEnterDiv(mdlCopiarFT);
        btnAceptarCopiar.click(function () {
            HoldOn.open({
                theme: 'sk-rect',
                message: 'Espere...'
            });
            if (mdlCopiarFT.find("#EstiloACopiar").val() && mdlCopiarFT.find("#ColorACopiar").val() &&
                    mdlCopiarFT.find("#ColorAReemplazar").val() && mdlCopiarFT.find("#EstiloAReemplazar").val()) {
                $.getJSON('<?php print base_url('FichaTecnica/getFichasXEstilo'); ?>',
                        {
                            ESTILO: mdlCopiarFT.find("#EstiloAReemplazar").val(),
                            COLOR: mdlCopiarFT.find("#ColorAReemplazar").val()
                        }).done(function (a) {
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
    });
</script>