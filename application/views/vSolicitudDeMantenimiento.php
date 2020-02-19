<div class="modal fade" id="mdlSolicitudDeMantenimiento" tabindex="-1" role="dialog" 
     aria-labelledby="mdlSolicitudDeMantenimiento" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">
                    <span class="fa fa-wrench"></span> Solicitud de mantenimiento
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button> 
            </div>
        </div>
    </div>
</div>
<script>
    var mdlSolicitudDeMantenimiento = $("#mdlSolicitudDeMantenimiento");
    $(document).ready(function () {
        mdlSolicitudDeMantenimiento.on('shown.bs.modal', function () {
            mdlSolicitudDeMantenimiento.find("input").val('');
        });
    });
</script>