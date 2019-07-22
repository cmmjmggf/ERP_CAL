<div class="modal animated flipInY modal-fullscreen" id="mdlColoresEstiloVista"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="iframe-container">
                    <iframe id="EstilosColoresConsulta"  width="100%"style="border:none" frameborder="0">Colores"></iframe>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script>

    var mdlColoresEstiloVista = $('#mdlColoresEstiloVista');
    $(document).ready(function () {


        mdlColoresEstiloVista.on('shown.bs.modal', function () {
            mdlColoresEstiloVista.find('#EstilosColoresConsulta').attr('src', base_url + 'index.php/Colores/?origen=CONSULTA');
        });
    });

</script>
<style>
    .iframe-container {
        overflow: hidden;
        padding-top: 56.25%;
        position: relative;
    }

    .iframe-container iframe {
        border: 0;
        height: 100%;
        left: 0;
        position: absolute;
        top: 0;
        width: 100%;
    }

</style>