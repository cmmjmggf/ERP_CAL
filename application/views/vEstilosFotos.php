<div class="modal" id="mdlEstilosFotos">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
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
<script>
    var mdlEstilosFotos = $("#mdlEstilosFotos"),
            EstiloFotos = mdlEstilosFotos.find("#EstiloFoto");
    $(document).ready(function () { 

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
        mdlEstilosFotos.on('shown.bs.modal', function () {
            EstiloFotos[0].selectize.clear(true);
            $.when($.getJSON('<?php print base_url('FichaTecnica/getEstilosFoto'); ?>').done(function (a, b, c) {
                $.each(a, function (k, v) {
                    EstiloFotos[0].selectize.addOption({text: v.CLAVE, value: v.URL});
                });
            })).then(function (x) {
                mdlEstilosFotos.modal('show');
            });

        });
    });
</script>