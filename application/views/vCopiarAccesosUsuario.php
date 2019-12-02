<div class="modal " id="mdlCopiaAccesosUsuario"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Copiar Accesos de un Usuario a Otro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pnlCaptura">
                <form id="frmCaptura">
                    <div class="row" >
                        <div class="col-6" >
                            <label>Usuario Asigna</label>
                            <select id="UsuarioAsigna" name="UsuarioAsigna" class="form-control form-control-sm ">
                                <option value=""></option>
                                <?php
                                $usrs = $this->db->query("SELECT U.ID AS ID, U.Usuario AS USUARIO, U.TipoAcceso AS TIPO_ACCESO FROM `usuarios` AS `U` ORDER BY ABS(U.ID) ASC")->result();
                                foreach ($usrs as $k => $v) {
                                    print "<option value='{$v->ID}'>{$v->USUARIO} ({$v->TIPO_ACCESO})</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6" >
                            <label>Usuario Final</label>
                            <select id="UsuarioRecibe" name="UsuarioRecibe" class="form-control form-control-sm ">
                                <option value=""></option>
                                <?php
                                foreach ($usrs as $k => $v) {
                                    print "<option value='{$v->ID}'>{$v->USUARIO} ({$v->TIPO_ACCESO})</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptar">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlCopiaAccesosUsuario = $('#mdlCopiaAccesosUsuario');
    $(document).ready(function () {
        mdlCopiaAccesosUsuario.on('shown.bs.modal', function () {
            mdlCopiaAccesosUsuario.find("input").val("");
            $.each(mdlCopiaAccesosUsuario.find("select"), function (k, v) {
                mdlCopiaAccesosUsuario.find("select")[k].selectize.clear(true);
            });
            handleEnterDiv(mdlCopiaAccesosUsuario);
            mdlCopiaAccesosUsuario.find('#UsuarioAsigna')[0].selectize.focus();
        });

        mdlCopiaAccesosUsuario.find('#btnAceptar').on("click", function () {
            isValid('pnlCaptura');
            if (valido) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlCopiaAccesosUsuario.find("#frmCaptura")[0]);
                $.ajax({
                    url: base_url + 'index.php/Accesos/onCopiarAccesosUsuario',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    swal('ATENCIÓN', '* ACCESOS COPIADOS CORRECTAMENTE *', 'success').then((value) => {
                        mdlCopiaAccesosUsuario.modal('hide');
                    });
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    swal('ATENCIÓN', '* OCURRIÓ UN ERROR AL PROCESAR LA PETICIÓN AL SERVIDOR *', 'error');
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });

    });


</script>

