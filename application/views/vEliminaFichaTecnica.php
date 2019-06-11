<div class="modal animated flipInX" id="mdlEliminaFTXEstilo">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar fichas tecnicas x estilo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-10">
                        <input type="text" id="EstiloElimina" name="EstiloElimina" autofocus="" class="form-control" placeholder="Estilo...">
                    </div>
                    <div class="col-2">
                        <button type="button" id="btnEliminarFichasXEstilo" class="btn btn-danger">
                            <span class="fa fa-trash"></span>
                        </button>
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
var mdlEliminaFTXEstilo = $("#mdlEliminaFTXEstilo");
    $(document).ready(function () {


        mdlEliminaFTXEstilo.find("#btnEliminarFichasXEstilo").click(function () {
            if (mdlEliminaFTXEstilo.find("#EstiloElimina").val()) {
                $.getJSON('<?php print base_url('FichaTecnica/getFichasAEliminarXEstilo'); ?>', {
                    ESTILO: mdlEliminaFTXEstilo.find("#EstiloElimina").val()
                }).done(function (a, b, c) {
                    console.log(a);
                    if (parseInt(a[0].FICHAS_A_ELIMINAR) > 0) {
                        swal({
                            title: "Se eliminarán " + a[0].FICHAS_A_ELIMINAR + " fichas técnicas, ¿Estas seguro?",
                            text: "Nota: Esta acción no se puede deshacer",
                            icon: "warning",
                            buttons: {
                                cancelar: {
                                    text: "Cancelar",
                                    value: "no"
                                },
                                cambiar: {
                                    text: "Aceptar",
                                    value: "ok"
                                }
                            }
                        }).then((value) => {
                            switch (value) {
                                case "ok":
                                    HoldOn.open({
                                        theme: 'sk-rect',
                                        message: 'Eliminando...'
                                    });
                                    $.post('<?php print base_url('FichaTecnica/onEliminarFTXEstilo'); ?>', {
                                        ESTILO: mdlEliminaFTXEstilo.find("#EstiloElimina").val()
                                    }).done(function (aa, bb, cc) {
                                        mdlEliminaFTXEstilo.find("#EstiloElimina").val('');
                                        swal('ATENCIÓN', 'SE HAN ELIMINADO ' + a[0].FICHAS_A_ELIMINAR + ' FICHAS TECNICAS', 'success').then((value) => {
                                            mdlEliminaFTXEstilo.find("#EstiloElimina").focus().select();
                                        });
                                    }).always(function () {
                                        HoldOn.close();
                                    });
                                    break;
                                case "cancelar":
                                    swal.close();
                                    HoldOn.close();
                                    break;
                            }
                        });
                    } else {
                        swal('ATENCION', 'ESTE ESTILO NO TIENE NINGUNA FICHA TECNICA ESTABLECIDA', 'warning').then((value) => {
                            mdlEliminaFTXEstilo.find("#EstiloElimina").focus().select();
                        });
                    }
                });

            } else {
                swal('ATENCION', 'ES NECESARIO ESTABLECER UN ESTILO', 'warning').then((value) => {
                    mdlEliminaFTXEstilo.find("#EstiloElimina").focus().select();
                });
            }
        });

        mdlEliminaFTXEstilo.on('shown.bs.modal', function () {
            mdlEliminaFTXEstilo.find("#EstiloElimina").val('');
            mdlEliminaFTXEstilo.find("#EstiloElimina").focus();
        }); 
    });
</script>