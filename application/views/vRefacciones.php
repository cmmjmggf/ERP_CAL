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
                                <label>Departamento</label>
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
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-12">
                                <label>Proveedores</label>
                                <div class="row">
                                    <div class="col-4 col-xs-4 col-sm-4">
                                        <input type="text" id="RefaccionesProveedorUno" name="RefaccionesProveedorUno" class="form-control" maxlength="3">
                                    </div>
                                    <div class="col-8 col-xs-8 col-sm-8"> 
                                        <input type="text"  id="RefaccionesProveedorUnoDesc" name="RefaccionesProveedorUnoDesc" class="form-control form-control-sm">
                                    </div>
                                    <div class="w-100 my-1"></div>
                                    <div class="col-4 col-xs-4 col-sm-4">
                                        <input type="text" id="RefaccionesProveedorDos" name="RefaccionesProveedorDos" class="form-control" maxlength="3">
                                    </div>
                                    <div class="col-8 col-xs-8 col-sm-8"> 
                                        <input type="text"  id="RefaccionesProveedorDosDesc" name="RefaccionesProveedorDosDesc" class="form-control form-control-sm">
                                    </div>
                                    <div class="w-100 my-1"></div>
                                    <div class="col-4 col-xs-4 col-sm-4">
                                        <input type="text" id="RefaccionesProveedorTres" name="RefaccionesProveedorTres" class="form-control" maxlength="3">
                                    </div>
                                    <div class="col-8 col-xs-8 col-sm-8"> 
                                        <input type="text"  id="RefaccionesProveedorTresDesc" name="RefaccionesProveedorTresDesc" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12 font-weight-bold text-center"><h3>Fotos</h3></div>
                            <div class="col-12">
                                <img src="<?php print base_url('img/camera.png'); ?>" width="100%" class="img-fluid">
                            </div>
                            <div class="col-2" style="height: 100px;     min-width: 90px;">
                                <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="height: 80px;     min-width: 80px;" class="img-fluid">
                            </div>
                            <div class="col-2" style="height: 100px;     min-width: 90px;">
                                <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="height: 80px;     min-width: 80px;" class="img-fluid">
                            </div>
                            <div class="col-2" style="height: 100px;     min-width: 90px;">
                                <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="height: 80px;    min-width: 80px;" class="img-fluid">
                            </div>
                            <div class="col-2" style="height: 100px;     min-width: 90px;">
                                <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="height: 80px;    min-width: 80px;" >
                            </div>
                            <input type="file" id="RefaccionImagenUno" class="d-none">
                            <input type="file" id="RefaccionImagenDos" class="d-none">
                            <input type="file" id="RefaccionImagenTres" class="d-none">
                            <input type="file" id="RefaccionImagenCuatro" class="d-none">
                            <input type="file" id="RefaccionImagenCinco" class="d-none">
                            <input type="file" id="RefaccionImagenSeis" class="d-none">
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