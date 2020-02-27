<div class="modal fade" id="mdlRefacciones" tabindex="-1" role="dialog" 
     aria-labelledby="mdlRefacciones" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">
                    <span class="fa fa-puzzle-piece"></span> Refacciones
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-5">
                        
                    </div>
                    <div class="col-7">
                        <div class="row">
                            <div class="col-12 font-weight-bold text-center"><h3>Fotos</h3></div>
                            <div class="col-12">
                                <img src="<?php print base_url('img/camera.png'); ?>" width="100%">
                            </div>
                        </div>
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
    var mdlRefacciones = $("#mdlRefacciones");
    $(document).ready(function () {
        mdlRefacciones.on('shown.bs.modal', function () {
            mdlRefacciones.find("input").val('');
        });
    });
</script>