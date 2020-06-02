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
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12">
                                <input type="text" id="IDR" name="IDR" class="form-control" readonly="">
                            </div>
                            <div class="col-12">
                                <label>Código</label>
                                <input type="text" id="CodigoRefaccion" name="CodigoRefaccion" class="form-control" maxlength="15">
                            </div>
                            <div class="col-12">
                                <label>Descripción</label>
                                <input type="text" id="DescripcionRefaccion" name="DescripcionRefaccion" class="form-control">
                            </div>
                            <div class="w-100"></div>
                            <div class="col-6">
                                <label>Fecha alta</label>
                                <input type="text" id="FechaAltaRefaccion" name="FechaAltaRefaccion" class="form-control">
                            </div>
                            <div class="col-6">
                                <label>Costo</label>
                                <input type="text" id="CostoRefaccion" name="CostoRefaccion" class="form-control">
                            </div>
                            <div class="w-100"></div>

                            <div class="col-12">
                                <label>Depto</label>
                                <div class="row">
                                    <div class="col-4 col-xs-4 col-sm-4">
                                        <input type="text" id="DeptoClaveMaquina" name="DeptoClaveMaquina" class="form-control" maxlength="3">
                                    </div>
                                    <div class="col-8 col-xs-8 col-sm-8"> 
                                        <select id="DeptoMaquina" name="DeptoMaquina" class="form-control form-control-sm">
                                            <option></option>                                   
                                            <?php
                                            $departamentos = $this->db->query("SELECT Clave, Descripcion FROM departamentos;")->result();
                                            foreach ($departamentos as $k => $v) {
                                                print "<option value='{$v->Clave}'>{$v->Descripcion}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
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