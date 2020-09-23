<div class="modal fade" id="mdlMaquinaria" tabindex="-1" role="dialog" 
     aria-labelledby="mdlMaquinaria" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content notresizable">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">
                    <span class="fa fa-cogs"></span> Maquinaria
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="RegistroMaquinaria">
                    <div class="col-6">
                        <ul class="nav nav-tabs" id="MaquinariaTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="datos_maquina-tab" data-toggle="tab" href="#datos_maquina" role="tab" aria-controls="datos_maquina" aria-selected="true">Datos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="mantenimiento-tab" data-toggle="tab" href="#mantenimiento" role="tab" aria-controls="mantenimiento" aria-selected="false">Mantenimiento</a>
                            </li> 
                        </ul>
                        <div class="tab-content" id="MiMaquinariaTab">
                            <div class="tab-pane fade show active" id="datos_maquina" role="tabpanel" aria-labelledby="datos_maquina-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <label>Código</label>
                                        <span class="font-weight-bold" style="color:#cc0000;">-</span>
                                        <input type="text" id="Maquinaria_ID" name="Maquinaria_ID" readonly="" class="form-control form-control-sm d-none">
                                        <input type="text" id="CodigoMaquina" name="CodigoMaquina" readonly="" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-5">
                                        <label>Id</label>
                                        <input type="text" id="IdMaquina" name="IdMaquina" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-7 ultimo_maqid_ingresado" >  
                                    </div>
                                    <div class="col-12">
                                        <label>Maquila</label>
                                        <div class="row">
                                            <div class="col-4 col-xs-4 col-sm-4">
                                                <input type="text" id="MaquilaClaveMaquina" name="MaquilaClaveMaquina" class="form-control" maxlength="3">
                                            </div>
                                            <div class="col-8 col-xs-8 col-sm-8"> 
                                                <select id="MaquilaMaquina" name="MaquilaMaquina" class="form-control form-control-sm">
                                                    <option></option>                                   
                                                    <?php
                                                    $maquilas = $this->db->query("SELECT Clave, Nombre FROM maquilas;")->result();
                                                    foreach ($maquilas as $k => $v) {
                                                        print "<option value='{$v->Clave}'>{$v->Nombre}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label>Descripción</label>
                                        <input type="text" id="DescripcionMaquina" name="DescripcionMaquina" maxlength="500" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12">
                                        <label>Marca</label>
                                        <input type="text" id="MarcaMaquina" name="MarcaMaquina" maxlength="99" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12">
                                        <label>Modelo</label>
                                        <input type="text" id="ModeloMaquina" name="ModeloMaquina" maxlength="99" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12">
                                        <label>Serie</label>
                                        <input type="text" id="SerieMaquina" name="SerieMaquina" maxlength="99" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12">
                                        <label>Departamento</label>
                                        <div class="row">
                                            <div class="col-4 col-xs-4 col-sm-4">
                                                <input type="text" id="DeptoClaveMaquinaria" name="DeptoClaveMaquinaria" class="form-control" maxlength="3">
                                            </div>
                                            <div class="col-8 col-xs-8 col-sm-8"> 
                                                <select id="DeptoMaquinaria" name="DeptoMaquinaria" class="form-control form-control-sm">
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
                                        <div class="row">
                                            <div class="col-12 col-xs-12 col-md-12 col-lg-4 col-xl-4">
                                                <label>Fecha alta</label>
                                                <input type="text" id="FechaAltaMaquina" name="FechaAltaMaquina" class="form-control form-control-sm date notEnter">
                                            </div>
                                            <div class="col-12 col-xs-12 col-md-12 col-lg-4 col-xl-4">
                                                <label>Factura</label>
                                                <input type="text" id="FacturaMaquina" name="FacturaMaquina" maxlength="15" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-12 col-xs-12 col-md-12 col-lg-4 col-xl-4">
                                                <label>Costo</label>
                                                <input type="text" id="CostoMaquina" name="CostoMaquina" class="form-control form-control-sm numbersOnly" maxlength="45">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="mantenimiento" role="tabpanel" aria-labelledby="mantenimiento-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <label>Ultimo Mantenimiento</label>
                                        <input type="text" id="UltimoMantenimientoMaquina" name="UltimoMantenimientoMaquina" class="form-control form-control-sm date notEnter">
                                    </div>
                                    <div class="col-12">
                                        <label>Dias de mantenimiento</label>
                                        <input type="text" id="DiasDeMantenimientoMaquina" name="DiasDeMantenimientoMaquina" class="form-control form-control-sm numbersOnly" maxlength="3">
                                    </div>
                                    <div class="col-6 my-4">
                                        <div class="w-100"></div>
                                        <span class="switch switch-lg">
                                            <input id="ClaveCriticidadMaquina" name="ClaveCriticidadMaquina"  type="checkbox" class="switch">
                                            <label for="ClaveCriticidadMaquina">Criticidad</label>
                                        </span>
                                    </div>
                                    <div class="col-6 my-4">
                                        <div class="w-100"></div>
                                        <span class="switch switch-lg">
                                            <input id="ClaveEstatusMaquina" name="ClaveEstatusMaquina"  type="checkbox" class="switch">
                                            <label for="ClaveEstatusMaquina">Estatus</label>
                                        </span> 
                                    </div>
                                    <div class="col-12">
                                        <label>Baja</label>
                                        <input type="text" id="FechaBajaMaquina" name="FechaBajaMaquina" class="form-control form-control-sm date notEnter">
                                    </div>
                                    <div class="col-12">
                                        <label>Motivo</label>
                                        <textarea id="MotivoMaquina" name="MotivoMaquina" class="form-control form-control-sm" rows="5">
                                        </textarea>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row"> 
                            <div class="col-12 font-weight-bold text-center">
                                <div class="row">
                                    <div class="col-4 mt-1">
                                        <button type="button" id="span_left_img" class="btn btn-info">
                                            <span class="fa fa-arrow-left fa-lg " style="cursor: pointer !important;"></span>   
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <h3>Fotos</h3>
                                    </div>
                                    <div class="col-4 mt-1">
                                        <button type="button" id="span_right_img" class="btn btn-info">
                                            <span class="fa fa-arrow-right fa-lg " style="cursor: pointer !important;"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12"> 
                                <img id="xImagenMaquina" name="xImagenMaquina" src="<?php print base_url('img/camera.png'); ?>" width="100%" height="366">
                            </div>
                            <div class="col-12 align-items-center my-2"> 
                                <div class="row">
                                    <div class="col-6 col-xs-4 col-md-4 col-lg-2 col-xl-2 my-2">  
                                        <img id="xImagenUno" name="xImagenUno" style="width: 50px; height: 50px; cursor: pointer;">
                                        <div class="w-100"></div>
                                        <button type="button" id="btnEscogerImagenUno" name="btnEscogerImagenUno" class="btn btn-success btn-block selectNotEnter" style="background-color: #673AB7; border-color: #673AB7; width: 50px;">
                                            <span class="fa fa-plus"></span>  
                                        </button>
                                        <button type="button" id="btnEliminaImagenUno" name="btnEliminaImagenUno" class="btn btn-success btn-block selectNotEnter" style="background-color: #cc0000; border-color: #cc0000; width: 50px;">
                                            <span class="fa fa-trash"></span>  
                                        </button>
                                    </div>
                                    <div class="col-6 col-xs-4 col-md-4 col-lg-2 col-xl-2 my-2">
                                        <img id="xImagenDos" name="xImagenDos" style="width: 50px; height: 50px; cursor: pointer;">
                                        <div class="w-100"></div>
                                        <button type="button" id="btnEscogerImagenDos" name="btnEscogerImagenDos" class="btn btn-success btn-block selectNotEnter" style="background-color: #673AB7; border-color: #673AB7; width: 50px;">
                                            <span class="fa fa-plus"></span>  
                                        </button>
                                        <button type="button" id="btnEliminaImagenDos" name="btnEliminaImagenDos" class="btn btn-success btn-block selectNotEnter" style="background-color: #cc0000; border-color: #cc0000; width: 50px;">
                                            <span class="fa fa-trash"></span>  
                                        </button>
                                    </div>
                                    <div class="col-6 col-xs-4 col-md-4 col-lg-2 col-xl-2 my-2">
                                        <img id="xImagenTres" name="xImagenTres" style="width: 50px; height: 50px; cursor: pointer;">
                                        <button type="button" id="btnEscogerImagenTres" name="btnEscogerImagenTres" class="btn btn-success btn-block selectNotEnter" style="background-color: #673AB7; border-color: #673AB7; width: 50px;">
                                            <span class="fa fa-plus"></span>  
                                        </button>
                                        <button type="button" id="btnEliminaImagenTres" name="btnEliminaImagenTres" class="btn btn-success btn-block selectNotEnter" style="background-color: #cc0000; border-color: #cc0000; width: 50px;">
                                            <span class="fa fa-trash"></span>  
                                        </button>
                                    </div>
                                    <div class="col-6 col-xs-4 col-md-4 col-lg-2 col-xl-2 my-2">
                                        <img id="xImagenCuatro" name="xImagenCuatro" style="width: 50px; height: 50px; cursor: pointer;">

                                        <button type="button" id="btnEscogerImagenCuatro" name="btnEscogerImagenCuatro" class="btn btn-success btn-block selectNotEnter" style="background-color: #673AB7; border-color: #673AB7;width: 50px;">
                                            <span class="fa fa-plus"></span>  
                                        </button>
                                        <button type="button" id="btnEliminaImagenCuatro" name="btnEliminaImagenCuatro" class="btn btn-success btn-block selectNotEnter" style="background-color: #cc0000; border-color: #cc0000; width: 50px;">
                                            <span class="fa fa-trash"></span>  
                                        </button>
                                    </div>
                                    <div class="col-6 col-xs-4 col-md-4 col-lg-2 col-xl-2 my-2">
                                        <img id="xImagenCinco" name="xImagenCinco" style="width: 50px; height: 50px; cursor: pointer;">

                                        <button type="button" id="btnEscogerImagenCinco" name="btnEscogerImagenCinco" class="btn btn-success btn-block selectNotEnter" style="background-color: #673AB7; border-color: #673AB7;width: 50px;">
                                            <span class="fa fa-plus"></span>  
                                        </button>
                                        <button type="button" id="btnEliminaImagenCinco" name="btnEliminaImagenCinco" class="btn btn-success btn-block selectNotEnter" style="background-color: #cc0000; border-color: #cc0000; width: 50px;">
                                            <span class="fa fa-trash"></span>  
                                        </button>
                                    </div>
                                    <div class="col-6 col-xs-4 col-md-4 col-lg-2 col-xl-2 my-2">
                                        <img id="xImagenSeis" name="xImagenSeis" style="width: 50px; height: 50px; cursor: pointer;">

                                        <button type="button" id="btnEscogerImagenSeis" name="btnEscogerImagenSeis" class="btn btn-success btn-block selectNotEnter" style="background-color: #673AB7; border-color: #673AB7;width: 50px;">
                                            <span class="fa fa-plus"></span>  
                                        </button>
                                        <button type="button" id="btnEliminaImagenSeis" name="btnEliminaImagenSeis" class="btn btn-success btn-block selectNotEnter" style="background-color: #cc0000; border-color: #cc0000; width: 50px;">
                                            <span class="fa fa-trash"></span>  
                                        </button>
                                    </div>
                                </div> 
                            </div> 
                            <div class="col-12 d-none"> 
                                <input type="file" id="xFileMaquinaUno" name="xFileMaquinaUno"> 
                                <input type="file" id="xFileMaquinaDos" name="xFileMaquinaDos" > 
                                <input type="file" id="xFileMaquinaTres" name="xFileMaquinaTres"> 
                                <input type="file" id="xFileMaquinaCuatro" name="xFileMaquinaCuatro" > 
                                <input type="file" id="xFileMaquinaCinco" name="xFileMaquinaCinco"> 
                                <input type="file" id="xFileMaquinaSeis" name="xFileMaquinaSeis"> 
                            </div> 
                        </div>
                    </div>
                    <div class="col-12 order-0">
                        <p class="font-weight-bold" style="color:#cc0000;">*PUEDES AGREGAR HASTA 6 FOTOS*</p>
                        <hr>

                    </div>
                    <div class="col-6 order-2" align="right"> 
                        <button type="button" id="btnGuardaMaquina" name="btnGuardaMaquina" class="btn btn-sm " style="background-color: #4CAF50; border-color: #4CAF50;    color: #fff;">
                            <span class="fa fa-save"></span> GUARDAR
                        </button> 
                    </div>
                    <div class="col-6 order-1" align="left">
                        <button id="btnVerMaquinaria" type="button" class="btn btn-success" style="background-color: #3F51B5; border-color: #3F51B5;">
                            <span class="fa fa-eye"></span> VER MAQUINARIA
                        </button> 
                    </div>  
                </div> 
                <div class="w-100 my-2"></div> 
                <div id="Maquinaria" class="row d-none">
                    <div class="w-100"></div>
                    <div class="col-12 mb-2" align="right">
                        <button id="btnNuevaMaquina" type="button" class="btn btn-success" style="background-color: #4CAF50; border-color: #3F51B5;">
                            <span class="fa fa-star"></span> NUEVO
                        </button>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblMaquinaria" class="table table-hover table-sm text-nowrap" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Id</th>
                                    <th scope="col">Maquila</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Modelo</th>
                                    <th scope="col">Serie</th>
                                    <th scope="col">Depto</th>
                                    <th scope="col">Fecha-alta</th>
                                    <th scope="col">Factura</th>
                                    <th scope="col">Costo</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                        </div>
                        <div class="col-6" align="right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <span class="fa fa-times"></span> Cerrar
                            </button> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlMaquinaria = $("#mdlMaquinaria"),
            Maquinaria_ID = mdlMaquinaria.find("#Maquinaria_ID"),
            CodigoMaquina = mdlMaquinaria.find("#CodigoMaquina"),
            IdMaquina = mdlMaquinaria.find("#IdMaquina"),
            btnNuevaMaquina = mdlMaquinaria.find("#btnNuevaMaquina"),
            RegistroMaquinaria = mdlMaquinaria.find("#RegistroMaquinaria"),
            btnVerMaquinaria = mdlMaquinaria.find("#btnVerMaquinaria"),
            btnEscogerImagenUno = mdlMaquinaria.find("#btnEscogerImagenUno"),
            btnEscogerImagenDos = mdlMaquinaria.find("#btnEscogerImagenDos"),
            btnEscogerImagenTres = mdlMaquinaria.find("#btnEscogerImagenTres"),
            btnEscogerImagenCuatro = mdlMaquinaria.find("#btnEscogerImagenCuatro"),
            btnEscogerImagenCinco = mdlMaquinaria.find("#btnEscogerImagenCinco"),
            btnEscogerImagenSeis = mdlMaquinaria.find("#btnEscogerImagenSeis"),
            btnEliminaImagenUno = mdlMaquinaria.find("#btnEliminaImagenUno"),
            btnEliminaImagenDos = mdlMaquinaria.find("#btnEliminaImagenDos"),
            btnEliminaImagenTres = mdlMaquinaria.find("#btnEliminaImagenTres"),
            btnEliminaImagenCuatro = mdlMaquinaria.find("#btnEliminaImagenCuatro"),
            btnEliminaImagenCinco = mdlMaquinaria.find("#btnEliminaImagenCinco"),
            btnEliminaImagenSeis = mdlMaquinaria.find("#btnEliminaImagenSeis"),
            xImagenMaquina = mdlMaquinaria.find("#xImagenMaquina"),
            xImagenUno = mdlMaquinaria.find("#xImagenUno"),
            xImagenDos = mdlMaquinaria.find("#xImagenDos"),
            xImagenTres = mdlMaquinaria.find("#xImagenTres"),
            xImagenCuatro = mdlMaquinaria.find("#xImagenCuatro"),
            xImagenCinco = mdlMaquinaria.find("#xImagenCinco"),
            xImagenSeis = mdlMaquinaria.find("#xImagenSeis"),
            xFileMaquinaUno = mdlMaquinaria.find("#xFileMaquinaUno"),
            xFileMaquinaDos = mdlMaquinaria.find("#xFileMaquinaDos"),
            xFileMaquinaTres = mdlMaquinaria.find("#xFileMaquinaTres"),
            xFileMaquinaCuatro = mdlMaquinaria.find("#xFileMaquinaCuatro"),
            xFileMaquinaCinco = mdlMaquinaria.find("#xFileMaquinaCinco"),
            xFileMaquinaSeis = mdlMaquinaria.find("#xFileMaquinaSeis"),
            xMaquinaria, tblMaquinaria = mdlMaquinaria.find("#tblMaquinaria"),
            btnGuardaMaquina = mdlMaquinaria.find("#btnGuardaMaquina"),
            nuevo = true;
    var MaquilaClaveMaquina = mdlMaquinaria.find('#MaquilaClaveMaquina'),
            MaquilaMaquina = mdlMaquinaria.find('#MaquilaMaquina'),
            DescripcionMaquina = mdlMaquinaria.find('#DescripcionMaquina'),
            MarcaMaquina = mdlMaquinaria.find('#MarcaMaquina'),
            ModeloMaquina = mdlMaquinaria.find('#ModeloMaquina'),
            SerieMaquina = mdlMaquinaria.find('#SerieMaquina'),
            DeptoClaveMaquinaria = mdlMaquinaria.find('#DeptoClaveMaquinaria'),
            DeptoMaquinaria = mdlMaquinaria.find('#DeptoMaquinaria'),
            FechaAltaMaquina = mdlMaquinaria.find('#FechaAltaMaquina'),
            FacturaMaquina = mdlMaquinaria.find('#FacturaMaquina'),
            CostoMaquina = mdlMaquinaria.find('#CostoMaquina'),
            UltimoMantenimientoMaquina = mdlMaquinaria.find('#UltimoMantenimientoMaquina'),
            DiasDeMantenimientoMaquina = mdlMaquinaria.find('#DiasDeMantenimientoMaquina'),
            ClaveCriticidadMaquina = mdlMaquinaria.find('#ClaveCriticidadMaquina'),
            ClaveEstatusMaquina = mdlMaquinaria.find('#ClaveEstatusMaquina'),
            EstatusMaquina = mdlMaquinaria.find('#EstatusMaquina'),
            FechaBajaMaquina = mdlMaquinaria.find('#FechaBajaMaquina'),
            MotivoMaquina = mdlMaquinaria.find('#MotivoMaquina'),
            indice = 1, indice_imagen = 1,
            sin_foto = "<?php print base_url('img/sin_foto_sm.jpg'); ?>",
            imgns = [xImagenUno, xImagenUno, xImagenDos, xImagenTres, xImagenCuatro, xImagenCinco, xImagenSeis];

    function onEliminarImagenMaquinaria(ID, indice) {
        swal({
            title: "¿Estas seguro?",
            text: "Nota: Esta acción no se puede deshacer",
            icon: "warning",
            buttons: {
                cancelar: {
                    text: "CANCELAR",
                    value: "cancelar"
                },
                eliminar: {
                    text: "ELIMINAR",
                    value: "eliminar"
                }
            }
        }).then((value) => {
            switch (value) {
                case "eliminar":
                    onOpenOverlay('Eliminando...');
                    $.post("<?php print base_url('Maquinaria/onEliminarImagen') ?>", {
                        IDE: ID,
                        INDICE: indice
                    }).done(function (a) {
                        console.log(a);
                        onCloseOverlay();
                        swal({
                            title: "ATENCIÓN",
                            text: "SE HA ELIMINADO LA IMAGEN",
                            icon: "success",
                            buttons: false,
                            timer: 750
                        });
                        switch (indice) {
                            case 1:
                                xImagenUno[0].src = xImagenDos[0].src;
                                xImagenDos[0].src = xImagenTres[0].src;
                                xImagenTres[0].src = xImagenCuatro[0].src;
                                xImagenCuatro[0].src = xImagenCinco[0].src;
                                xImagenCinco[0].src = xImagenSeis[0].src;
                                xImagenSeis[0].src = sin_foto;
                                break;
                            case 2:
                                xImagenDos[0].src = xImagenTres[0].src;
                                xImagenTres[0].src = xImagenCuatro[0].src;
                                xImagenCuatro[0].src = xImagenCinco[0].src;
                                xImagenCinco[0].src = xImagenSeis[0].src;
                                xImagenSeis[0].src = sin_foto;
                                break;
                            case 3:
                                xImagenTres[0].src = xImagenCuatro[0].src;
                                xImagenCuatro[0].src = xImagenCinco[0].src;
                                xImagenCinco[0].src = xImagenSeis[0].src;
                                xImagenSeis[0].src = sin_foto;
                                break;
                            case 4:
                                xImagenCuatro[0].src = xImagenCinco[0].src;
                                xImagenCinco[0].src = xImagenSeis[0].src;
                                xImagenSeis[0].src = sin_foto;
                                break;
                            case 5:
                                xImagenCinco[0].src = xImagenSeis[0].src;
                                xImagenSeis[0].src = sin_foto;
                                break;
                        }
                        xImagenMaquina[0].src = xImagenUno[0].src;
                        onCheckImagenes();
                    }).fail(function (x) {
                        onCloseOverlay();
                        getError(x);
                    });
                    break;
                case "cancelar":
                    swal.close();
                    HoldOn.close();
                    break;
            }
        });
    }

    $(document).ready(function () {
        onVolverPrimerPestana();
        handleEnterDiv(mdlMaquinaria);
        mdlMaquinaria.on('keydown', function (e) {
            if (e.keyCode === 39) {
                mdlMaquinaria.find("#span_right_img").trigger('click');
            }
            if (e.keyCode === 37) {
                mdlMaquinaria.find("#span_left_img").trigger('click');
            }
        });

        mdlMaquinaria.find("#span_left_img").click(function () {
            if (indice_imagen >= 2) {
                indice_imagen -= 1;
                xImagenMaquina[0].src = imgns[indice_imagen][0].src;
            }
            console.log(indice_imagen);
        });

        mdlMaquinaria.find("#span_right_img").click(function () {
            if (indice_imagen <= 5) {
                indice_imagen += 1;
                xImagenMaquina[0].src = imgns[indice_imagen][0].src;
            }
            console.log(indice_imagen);
        });

        btnEliminaImagenSeis.click(function () {
            if (nuevo) {
                xImagenMaquina[0].src = sin_foto;
                xImagenSeis[0].src = sin_foto;
                xFileMaquinaSeis[0].type = 'text';
                xFileMaquinaSeis[0].type = 'file';
            } else {
                onEliminarImagenMaquinaria(Maquinaria_ID.val(), 6);
            }
        });

        btnEliminaImagenCinco.click(function () {
            if (nuevo) {
                xImagenMaquina[0].src = sin_foto;
                xImagenCinco[0].src = sin_foto;
                xFileMaquinaCinco[0].type = 'text';
                xFileMaquinaCinco[0].type = 'file';
            } else {
                onEliminarImagenMaquinaria(Maquinaria_ID.val(), 5);
            }
        });

        btnEliminaImagenCuatro.click(function () {
            if (nuevo) {
                xImagenMaquina[0].src = sin_foto;
                xImagenCuatro[0].src = sin_foto;
                xFileMaquinaCuatro[0].type = 'text';
                xFileMaquinaCuatro[0].type = 'file';
            } else {
                onEliminarImagenMaquinaria(Maquinaria_ID.val(), 4);
            }
        });

        btnEliminaImagenTres.click(function () {
            if (nuevo) {
                xImagenMaquina[0].src = sin_foto;
                xImagenTres[0].src = sin_foto;
                xFileMaquinaTres[0].type = 'text';
                xFileMaquinaTres[0].type = 'file';
            } else {
                onEliminarImagenMaquinaria(Maquinaria_ID.val(), 3);
            }
        });

        btnEliminaImagenDos.click(function () {
            if (nuevo) {
                xImagenMaquina[0].src = sin_foto;
                xImagenDos[0].src = sin_foto;
                xFileMaquinaDos[0].type = 'text';
                xFileMaquinaDos[0].type = 'file';
            } else {
                onEliminarImagenMaquinaria(Maquinaria_ID.val(), 2);
            }
        });

        btnEliminaImagenUno.click(function () {
            if (nuevo) {
                xImagenMaquina[0].src = sin_foto;
                xImagenUno[0].src = sin_foto;
                xFileMaquinaUno[0].type = 'text';
                xFileMaquinaUno[0].type = 'file';
            } else {
                onEliminarImagenMaquinaria(Maquinaria_ID.val(), 1);
            }
        });

        DeptoClaveMaquinaria.on('keydown', function (e) {
            if (e.keyCode === 13 && DeptoClaveMaquinaria.val()) {
                setValueSelectize(DeptoMaquinaria, DeptoClaveMaquinaria.val());
                onDisable(DeptoMaquinaria);
            }
            if (e.keyCode === 13 && DeptoClaveMaquinaria.val() === '' ||
                    e.keyCode === 8 && DeptoClaveMaquinaria.val() === '') {
                onClear(DeptoMaquinaria);
                onEnable(DeptoMaquinaria);
            }
            if (e.keyCode === 13 && DeptoClaveMaquinaria.val() !== '' && DeptoMaquinaria.val() === '') {
                onCampoInvalido(mdlMaquinaria, "DEBE DE ESPECIFICAR UN DEPARTAMENTO VÁLIDO.", function () {
                    DeptoClaveMaquinaria.focus().select();
                });
            }
        });

        DeptoMaquinaria.change(function () {
            console.log(DeptoClaveMaquinaria.val());
            console.log(DeptoMaquinaria.val());
            DeptoClaveMaquinaria.val(DeptoMaquinaria.val());
            console.log(DeptoClaveMaquinaria.val());
            console.log(DeptoMaquinaria.val());
            FechaAltaMaquina.focus();
        });

        MaquilaClaveMaquina.on('keydown', function (e) {
            if (e.keyCode === 13 && MaquilaClaveMaquina.val()) {
                setValueSelectize(MaquilaMaquina, MaquilaClaveMaquina.val());
                onDisable(MaquilaMaquina);
            }
            if (e.keyCode === 13 && MaquilaClaveMaquina.val() === '' ||
                    e.keyCode === 8 && MaquilaClaveMaquina.val() === '') {
                onClear(MaquilaMaquina);
                onEnable(MaquilaMaquina);
            }
            if (e.keyCode === 13 && MaquilaClaveMaquina.val() && MaquilaMaquina.val() === '') {
                onCampoInvalido(mdlMaquinaria, "DEBE DE ESPECIFICAR UNA MAQUILA VÁLIDA", function () {
                    MaquilaClaveMaquina.focus().select();
                });
            }
        });

        MaquilaMaquina.change(function () {
            if (MaquilaMaquina.val()) {
                MaquilaClaveMaquina.val(MaquilaMaquina.val());
                DescripcionMaquina.focus().select();
            }
        });

        btnGuardaMaquina.click(function () {
            if (!IdMaquina.val()) {
                onCampoInvalido(mdlMaquinaria, "DEBE DE ESPECIFICAR AL MENOS UN ID.", function () {
                    IdMaquina.focus().select();
                });
                return;
            }
            if (DescripcionMaquina.val() === '' && DescripcionMaquina.val().length <= 1) {
                onCampoInvalido(mdlMaquinaria, "DEBE DE ESPECIFICAR AL MENOS UNA DESCRIPCION DE MÁS DE 2 CARACTERES.", function () {
                    DescripcionMaquina.focus().select();
                });
                return;
            }
            onDisable(btnGuardaMaquina);
            onEnable(MaquilaMaquina);
            onEnable(DeptoMaquinaria);
            onOpenOverlay('Guardando...');
            var f = new FormData();
            /*CAMPOS*/
            f.append('CodigoMaquina', CodigoMaquina.val());
            f.append('IdMaquina', IdMaquina.val());
            f.append('MaquilaClaveMaquina', MaquilaClaveMaquina.val());
            f.append('MaquilaMaquina', MaquilaMaquina.val());
            f.append('DescripcionMaquina', DescripcionMaquina.val());
            f.append('MarcaMaquina', MarcaMaquina.val());
            f.append('ModeloMaquina', ModeloMaquina.val());
            f.append('SerieMaquina', SerieMaquina.val());
            f.append('DeptoClaveMaquina', DeptoClaveMaquinaria.val());
            f.append('DeptoMaquina', DeptoMaquinaria.val());
            f.append('FechaAltaMaquina', FechaAltaMaquina.val());
            f.append('FacturaMaquina', FacturaMaquina.val());
            f.append('CostoMaquina', CostoMaquina.val());
            f.append('UltimoMantenimientoMaquina', UltimoMantenimientoMaquina.val() ? UltimoMantenimientoMaquina.val() : '');
            f.append('DiasDeMantenimientoMaquina', DiasDeMantenimientoMaquina.val());
            f.append('CriticidadMaquina', ClaveCriticidadMaquina[0].checked ? 2 : 1);
            f.append('EstatusMaquina', ClaveEstatusMaquina[0].checked ? 2 : 1);
            f.append('FechaBajaMaquina', FechaBajaMaquina.val() ? FechaBajaMaquina.val() : '');
            f.append('MotivoMaquina', MotivoMaquina.val());

            /*ARCHIVOS*/
            f.append('FotoUno', xFileMaquinaUno[0].files[0]);
            f.append('FotoDos', xFileMaquinaDos[0].files[0]);
            f.append('FotoTres', xFileMaquinaTres[0].files[0]);
            f.append('FotoCuatro', xFileMaquinaCuatro[0].files[0]);
            f.append('FotoCinco', xFileMaquinaCinco[0].files[0]);
            f.append('FotoSeis', xFileMaquinaSeis[0].files[0]);

            if (nuevo) {
                $.ajax({
                    url: '<?php print base_url('Maquinaria/onGuardar'); ?>',
                    type: "POST",
                    cache: true,
                    contentType: false,
                    processData: false,
                    data: f
                }).done(function (a, b, c) {
                    nuevo = false;
                    console.log(a);
                    onCloseOverlay();
                    onEnable(btnGuardaMaquina);
                    iMsg("MAQUINA GUARDADA", "s", function () {
//                    onClear(MaquilaMaquina);
//                    onClear(DeptoMaquina);
//                    onClear(ClaveCriticidadMaquina);
//                    onClear(ClaveEstatusMaquina);
                    });
                }).fail(function (x) {
                    onCloseOverlay();
                    onEnable(btnGuardaMaquina);
                    getError(x);
                });
            } else {
                console.log('Modificando...');
                f.append('ID', Maquinaria_ID.val());
                $.ajax({
                    url: '<?php print base_url('Maquinaria/onModificar'); ?>',
                    type: "POST",
                    cache: true,
                    contentType: false,
                    processData: false,
                    data: f
                }).done(function (a, b, c) {
                    console.log(a);
                    onCloseOverlay();
                    onEnable(btnGuardaMaquina);
                    iMsg("MAQUINA GUARDADA", "s", function () {
//                    onClear(MaquilaMaquina);
//                    onClear(DeptoMaquina);
//                    onClear(ClaveCriticidadMaquina);
//                    onClear(ClaveEstatusMaquina);
                    });
                }).fail(function (x) {
                    onCloseOverlay();
                    onEnable(btnGuardaMaquina);
                    getError(x);
                });
            }
        });

        xImagenMaquina.click(function () {
            var imagenes = [];
            if (xImagenUno[0].src !== undefined && xImagenUno[0].src !== "") {
                imagenes.push({
                    src: xImagenUno[0].src,
                    opts: {
                        caption: 'Primer imagen'
                    }
                });
            }
            if (xImagenDos[0].src !== undefined && xImagenDos[0].src !== "") {
                imagenes.push({
                    src: xImagenDos[0].src,
                    opts: {
                        caption: 'Segunda imagen'
                    }
                });
            }
            if (xImagenTres[0].src !== undefined && xImagenTres[0].src !== "") {
                imagenes.push({
                    src: xImagenTres[0].src,
                    opts: {
                        caption: 'Tercera imagen'
                    }
                });
            }
            if (xImagenCuatro[0].src !== undefined && xImagenCuatro[0].src !== "") {
                imagenes.push({
                    src: xImagenCuatro[0].src,
                    opts: {
                        caption: 'Cuarta imagen'
                    }
                });
            }
            if (xImagenCinco[0].src !== undefined && xImagenCinco[0].src !== "") {
                imagenes.push({
                    src: xImagenCinco[0].src,
                    opts: {
                        caption: 'Quinta imagen'
                    }
                });
            }
            if (xImagenSeis[0].src !== undefined && xImagenSeis[0].src !== "") {
                imagenes.push({
                    src: xImagenSeis[0].src,
                    opts: {
                        caption: 'Sexta imagen'
                    }
                });
            }

            $.fancybox.open(imagenes, {
                loop: false
            });
        });

        xImagenSeis.click(function () {
            xImagenMaquina[0].src = xImagenSeis[0].src;
        });

        xFileMaquinaSeis.change(function (e) {
            console.log(xFileMaquinaSeis);
            var imageType = /image.*/;
            if (xFileMaquinaSeis[0].files[0] !== undefined && xFileMaquinaSeis[0].files[0].type.match(imageType)) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    xImagenMaquina[0].src = reader.result;
                    xImagenSeis[0].src = reader.result;
                    xImagenSeis.parent("a")[0].href = reader.result;
                };
                reader.readAsDataURL(xFileMaquinaSeis[0].files[0]);
                if (!nuevo) {
                    onModificarImagen(6, xFileMaquinaSeis);
                }
            } else {
                swal('ATENCIÓN', 'EL ELEMENTO TIENE QUE SER UNA IMAGEN.', 'warning');
            }
        });

        btnEscogerImagenSeis.click(function () {
            onBeep(1);
            xFileMaquinaSeis.trigger('click');
        });

        xImagenCinco.click(function () {
            xImagenMaquina[0].src = xImagenCinco[0].src;
        });

        xFileMaquinaCinco.change(function (e) {
            console.log(xFileMaquinaCinco);
            var imageType = /image.*/;
            if (xFileMaquinaCinco[0].files[0] !== undefined && xFileMaquinaCinco[0].files[0].type.match(imageType)) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    xImagenMaquina[0].src = reader.result;
                    xImagenCinco[0].src = reader.result;
                };
                reader.readAsDataURL(xFileMaquinaCinco[0].files[0]);
                if (!nuevo) {
                    onModificarImagen(5, xFileMaquinaCinco);
                }
            } else {
                swal('ATENCIÓN', 'EL ELEMENTO TIENE QUE SER UNA IMAGEN.', 'warning');
            }
        });

        btnEscogerImagenCinco.click(function () {
            onBeep(1);
            xFileMaquinaCinco.trigger('click');
        });

        xImagenCuatro.click(function () {
            xImagenMaquina[0].src = xImagenCuatro[0].src;
        });

        xFileMaquinaCuatro.change(function (e) {
            console.log(xFileMaquinaCuatro);
            var imageType = /image.*/;
            if (xFileMaquinaCuatro[0].files[0] !== undefined && xFileMaquinaCuatro[0].files[0].type.match(imageType)) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    xImagenMaquina[0].src = reader.result;
                    xImagenCuatro[0].src = reader.result;
                };
                reader.readAsDataURL(xFileMaquinaCuatro[0].files[0]);
                if (!nuevo) {
                    onModificarImagen(4, xFileMaquinaCuatro);
                }
            } else {
                swal('ATENCIÓN', 'EL ELEMENTO TIENE QUE SER UNA IMAGEN.', 'warning');
            }
        });

        btnEscogerImagenCuatro.click(function () {
            onBeep(1);
            xFileMaquinaCuatro.trigger('click');
        });

        xImagenTres.click(function () {
            xImagenMaquina[0].src = xImagenTres[0].src;
        });

        xFileMaquinaTres.change(function (e) {
            console.log(xFileMaquinaTres);
            var imageType = /image.*/;
            if (xFileMaquinaTres[0].files[0] !== undefined && xFileMaquinaTres[0].files[0].type.match(imageType)) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    xImagenMaquina[0].src = reader.result;
                    xImagenTres[0].src = reader.result;
//                    xImagenTres.parent("a")[0].href = reader.result;
                };
                reader.readAsDataURL(xFileMaquinaTres[0].files[0]);
                if (!nuevo) {
                    onModificarImagen(3, xFileMaquinaTres);
                }
            } else {
                swal('ATENCIÓN', 'EL ELEMENTO TIENE QUE SER UNA IMAGEN.', 'warning');
            }
        });

        btnEscogerImagenTres.click(function () {
            onBeep(1);
            xFileMaquinaTres.trigger('click');
        });

        xImagenDos.click(function () {
            xImagenMaquina[0].src = xImagenDos[0].src;
        });

        xFileMaquinaDos.change(function (e) {
            console.log(xFileMaquinaDos);
            var imageType = /image.*/;
            if (xFileMaquinaDos[0].files[0] !== undefined && xFileMaquinaDos[0].files[0].type.match(imageType)) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    xImagenMaquina[0].src = reader.result;
                    xImagenDos[0].src = reader.result;
                };
                reader.readAsDataURL(xFileMaquinaDos[0].files[0]);
                if (!nuevo) {
                    onModificarImagen(2, xFileMaquinaDos);
                }
            } else {
                swal('ATENCIÓN', 'EL ELEMENTO TIENE QUE SER UNA IMAGEN.', 'warning');
            }
        });

        btnEscogerImagenDos.click(function () {
            onBeep(1);
            xFileMaquinaDos.trigger('click');
        });

        xImagenUno.click(function () {
            xImagenMaquina[0].src = xImagenUno[0].src;
        });

        xFileMaquinaUno.change(function (e) {
            console.log(xFileMaquinaUno);
            var imageType = /image.*/;
            if (xFileMaquinaUno[0].files[0] !== undefined && xFileMaquinaUno[0].files[0].type.match(imageType)) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    xImagenMaquina[0].src = reader.result;
                    xImagenUno[0].src = reader.result;
                };
                reader.readAsDataURL(xFileMaquinaUno[0].files[0]);
                if (!nuevo) {
                    onModificarImagen(1, xFileMaquinaUno);
                }
            } else {
                swal('ATENCIÓN', 'EL ELEMENTO TIENE QUE SER UNA IMAGEN.', 'warning');
            }
        });

        btnEscogerImagenUno.click(function () {
            onBeep(1);
            xFileMaquinaUno.trigger('click');
        });

        btnNuevaMaquina.click(function () {
            onVolverPrimerPestana();
            mdlMaquinaria.find("#RegistroMaquinaria").find("input").val("");
            onClearPanelInputSelect(mdlMaquinaria.find("#RegistroMaquinaria"), function () {
                indice_imagen = 1;
                mdlMaquinaria.find("#RegistroMaquinaria").removeClass("d-none");
                mdlMaquinaria.find("#Maquinaria").addClass("d-none");
                btnVerMaquinaria.removeClass("d-none");
                btnNuevaMaquina.addClass("d-none");
                getUltimaMaquinaria(function () {
                    getUltimaIDMaquinaria(function () {
                        IdMaquina.focus();
                    });
                });
                IdMaquina.focus().select();
                xImagenUno[0].src = sin_foto;
                xImagenDos[0].src = sin_foto;
                xImagenTres[0].src = sin_foto;
                xImagenCuatro[0].src = sin_foto;
                xImagenCinco[0].src = sin_foto;
                xImagenSeis[0].src = sin_foto;

            });
        });

        btnVerMaquinaria.click(function () {
            nuevo = true;
            mdlMaquinaria.find("#RegistroMaquinaria").addClass("d-none");
            mdlMaquinaria.find("#Maquinaria").removeClass("d-none");
            btnVerMaquinaria.addClass("d-none");
            btnNuevaMaquina.removeClass("d-none");
            getInfoMaquinarias();
        });

        mdlMaquinaria.on('hidden.bs.modal', function () {
            mdlMaquinaria.find("input").val('');
            onClear(MaquilaMaquina);
            onClear(DeptoMaquinaria);
            onClear(ClaveCriticidadMaquina);
            onClear(ClaveEstatusMaquina);
            onClear(xImagenUno);
            onVolverPrimerPestana();
        });

        mdlMaquinaria.on('shown.bs.modal', function () {
            onVolverPrimerPestana();
            getUltimaMaquinaria(function () {
                getUltimaIDMaquinaria(function () {
                    IdMaquina.focus();
                });
            });
        });

        mdlMaquinaria.find("#datos_maquina-tab").on('shown.bs.tab', function () {
            IdMaquina.focus();
        });

        mdlMaquinaria.find("#mantenimiento-tab").on('shown.bs.tab', function () {
            mdlMaquinaria.find("#UltimoMantenimientoMaquina").focus();
        });

    });

    function getInfoMaquinarias() {
        onOpenOverlay('Cargando...');
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblMaquinaria')) {
            xMaquinaria.ajax.reload(function () {
                onCloseOverlay();
            });
            return;
        }
        xMaquinaria = tblMaquinaria.DataTable({
            "dom": 'fritp',
            "ajax": {
                "url": '<?php print base_url('Maquinaria/getMaquinaria'); ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
//                    d.CONTROL = ControlRXCTROL.val() ? ControlRXCTROL.val() : ''; 
                }
            },
            buttons: buttons,
            "columns": [
                {"data": "IDE"}/*0*/,
                {"data": "CODIGO"}/*1*/,
                {"data": "ID"}/*2*/,
                {"data": "MAQUILA"}/*3*/,
                {"data": "DESCRIPCION"}/*4*/,
                {"data": "MARCA"}/*4*/,
                {"data": "MODELO"}/*5*/,
                {"data": "SERIE"}/*6*/,
                {"data": "DEPTO"}/*7*/,
                {"data": "FECHA_ALTA"}/*8*/,
                {"data": "FACTURA"}/*10*/,
                {"data": "COSTO"}/*10*/
            ],
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "350px",
            "scrollX": true,
            "aaSorting": [
                [0, 'desc']
            ],
            initComplete: function () {
                onCloseOverlay();
            }
        });

        tblMaquinaria.find('tbody').on('click', 'tr', function () {
            onOpenOverlay('Espere...');
            mdlMaquinaria.find("#RegistroMaquinaria").find("input").val("");
            onClearPanelInputSelect(mdlMaquinaria.find("#RegistroMaquinaria"), function () {
                mdlMaquinaria.find("#RegistroMaquinaria").removeClass("d-none");
                mdlMaquinaria.find("#Maquinaria").addClass("d-none");
                btnVerMaquinaria.removeClass("d-none");
                btnNuevaMaquina.addClass("d-none");
                IdMaquina.focus().select();
            });
            onVolverPrimerPestana();
            nuevo = false;
            tblMaquinaria.find("tbody tr").removeClass("success");
            $(this).addClass("success");

            var dtm = xMaquinaria.row(this).data();
            console.log(dtm);
            getMaquinaByID(dtm);
            xImagenMaquina[0].src = xImagenUno[0].src;
            indice_imagen = 1;
            IdMaquina.focus().select();
            onCloseOverlay();
        });
    }

    function getMaquinaByID(dtm) {
        Maquinaria_ID.val(dtm.IDE);
        CodigoMaquina.val(dtm.CODIGO);
        IdMaquina.val(dtm.ID);
        MaquilaClaveMaquina.val(dtm.MAQUILA);
        setValueSelectize(MaquilaMaquina, dtm.MAQUILA);
        DescripcionMaquina.val(dtm.DESCRIPCION);
        MarcaMaquina.val(dtm.MARCA);
        ModeloMaquina.val(dtm.MODELO);
        SerieMaquina.val(dtm.SERIE);
        DeptoClaveMaquinaria.val(dtm.DEPTO);
        setValueSelectize(DeptoMaquinaria, dtm.DEPTO);
        FechaAltaMaquina.val(dtm.FECHA_ALTA);
        FacturaMaquina.val(dtm.FACTURA);
        CostoMaquina.val(dtm.COSTOSF);
        UltimoMantenimientoMaquina.val(dtm.FECHA_ULTIMO_MANTENIMIENTO);
        DiasDeMantenimientoMaquina.val(dtm.DIAS_M);
        switch (parseInt(dtm.CRITISIDAD)) {
            case 1:
                onUnCheck(ClaveCriticidadMaquina);
                break;
            case 2:
                onCheck(ClaveCriticidadMaquina);
                break;
        }
        switch (parseInt(dtm.ESTATUS_MAQ)) {
            case 1:
                onUnCheck(ClaveEstatusMaquina);
                break;
            case 2:
                onCheck(ClaveEstatusMaquina);
                break;
        }
        FechaBajaMaquina.val(dtm.FECHA_BAJA);
        MotivoMaquina.val(dtm.MOTIVO_BAJA);

        xImagenUno[0].src = dtm.FOTO_UNO !== null ? '<?php print base_url(); ?>' + dtm.FOTO_UNO : sin_foto;
        xImagenDos[0].src = dtm.FOTO_DOS !== null ? '<?php print base_url(); ?>' + dtm.FOTO_DOS : sin_foto;
        xImagenTres[0].src = dtm.FOTO_TRES !== null ? '<?php print base_url(); ?>' + dtm.FOTO_TRES : sin_foto;
        xImagenCuatro[0].src = dtm.FOTO_CUATRO !== null ? '<?php print base_url(); ?>' + dtm.FOTO_CUATRO : sin_foto;
        xImagenCinco[0].src = dtm.FOTO_CINCO !== null ? '<?php print base_url(); ?>' + dtm.FOTO_CINCO : sin_foto;
        xImagenSeis[0].src = dtm.FOTO_SEIS !== null ? '<?php print base_url(); ?>' + dtm.FOTO_SEIS : sin_foto;
        onCheckImagenes();
    }

    function onCheckImagenes() {
        if (xImagenUno[0].src !== sin_foto) {
            onEnable(btnEliminaImagenUno);
        } else {
            onDisable(btnEliminaImagenUno);
        }
        if (xImagenDos[0].src !== sin_foto) {
            onEnable(btnEliminaImagenDos);
        } else {
            onDisable(btnEliminaImagenDos);
        }
        if (xImagenTres[0].src !== sin_foto) {
            onEnable(btnEliminaImagenTres);
        } else {
            onDisable(btnEliminaImagenTres);
        }
        if (xImagenCuatro[0].src !== sin_foto) {
            onEnable(btnEliminaImagenCuatro);
        } else {
            onDisable(btnEliminaImagenCuatro);
        }
        if (xImagenCinco[0].src !== sin_foto) {
            onEnable(btnEliminaImagenCinco);
        } else {
            onDisable(btnEliminaImagenCinco);
        }
        if (xImagenSeis[0].src !== sin_foto) {
            onEnable(btnEliminaImagenSeis);
        } else {
            onDisable(btnEliminaImagenSeis);
        }
    }

    function getUltimaMaquinaria(f) {
        $.getJSON('<?php print base_url('Maquinaria/getUltimaMaquinaria') ?>').done(function (a, b, c) {
            console.log(a);
            CodigoMaquina.val(a[0].ULTIMO_CODIGO);
            f();
        }).fail(function (x) {
            getError(x);
        });
    }

    function getUltimaIDMaquinaria(f) {
        $.getJSON('<?php print base_url('Maquinaria/getUltimaIDMaquinaria') ?>').done(function (a, b, c) {
            console.log(a);
            mdlMaquinaria.find("div.ultimo_maqid_ingresado").html("<p>ULTIMO ID INGRESADO: </p><span style=\"color: #cc0000; font-weight:bold;\">" + a[0].UID + "</span>");
            f();
        }).fail(function (x) {
            getError(x);
        });
    }

    function onVolverPrimerPestana() {
        mdlMaquinaria.find("li a").removeClass("active");
        mdlMaquinaria.find("li a").attr("aria-selected", false);
        mdlMaquinaria.find("li:eq(0) a").attr("aria-selected", true);
        mdlMaquinaria.find("li:eq(0) a").addClass("active");
        mdlMaquinaria.find("#datos_maquina").addClass("show active");
        mdlMaquinaria.find("#mantenimiento").removeClass("show active");

        xImagenMaquina[0].src = '<?php print base_url('img/sin_foto_sm.jpg'); ?>';
        xImagenUno[0].src = '<?php print base_url('img/sin_foto_sm.jpg'); ?>';
        onClear(xImagenDos);
        xImagenDos[0].src = '<?php print base_url('img/sin_foto_sm.jpg'); ?>';
        onClear(xImagenTres);
        xImagenTres[0].src = '<?php print base_url('img/sin_foto_sm.jpg'); ?>';
        onClear(xImagenCuatro);
        xImagenCuatro[0].src = '<?php print base_url('img/sin_foto_sm.jpg'); ?>';
        onClear(xImagenCinco);
        xImagenCinco[0].src = '<?php print base_url('img/sin_foto_sm.jpg'); ?>';
        onClear(xImagenSeis);
        xImagenSeis[0].src = '<?php print base_url('img/sin_foto_sm.jpg'); ?>';

        xFileMaquinaUno[0].type = 'text';
        xFileMaquinaUno[0].type = 'file';

        xFileMaquinaDos[0].type = 'text';
        xFileMaquinaDos[0].type = 'file';

        xFileMaquinaTres[0].type = 'text';
        xFileMaquinaTres[0].type = 'file';

        xFileMaquinaCuatro[0].type = 'text';
        xFileMaquinaCuatro[0].type = 'file';

        xFileMaquinaCinco[0].type = 'text';
        xFileMaquinaCinco[0].type = 'file';

        xFileMaquinaSeis[0].type = 'text';
        xFileMaquinaSeis[0].type = 'file';
    }

    function onModificarImagen(indice, archivo) {
        onOpenOverlay('Modificando...');
        var f = new FormData();
        f.append('INDICE', indice);
        f.append('CodigoMaquina', CodigoMaquina.val());
        f.append('IDE', Maquinaria_ID.val());
        f.append('FotoUno', archivo[0].files[0]);
        $.ajax({
            url: '<?php print base_url('Maquinaria/onModificarImagen'); ?>',
            type: "POST",
            cache: true,
            contentType: false,
            processData: false,
            data: f
        }).done(function (a, b, c) {
            onBeep(1);
            onCloseOverlay();
            swal({
                title: "ATENCIÓN",
                text: "SE HA GUARDADO LA IMAGEN",
                icon: "success",
                buttons: false,
                timer: 1500
            });
            $.getJSON('<?php print base_url('Maquinaria/getMaquinaByID') ?>',
                    {IDE: Maquinaria_ID.val()}).done(function (a) {
                getMaquinaByID(a[0]);
                xImagenMaquina[0].src = xImagenUno[0].src;
            }).fail(function (x) {
                getError(x);
            });
        }).fail(function (x) {
            onCloseOverlay();
            getError(x);
        });
    }
</script>
<style>
    button.swal-button--cancelar{
        background-color: #424242 !important;
    }
    button.swal-button--eliminar{
        background-color: #D32F2F !important;
    }
    #tblMaquinaria tbody tr td{ 
        font-size: 15px !important;
        font-weight: bold !important;
    }
    #tblMaquinaria tbody tr:hover td{ 
        font-size: 15px !important;
        font-weight: bold !important;
    }
    #xImagenMaquina:hover{
        cursor: pointer !important;
    }
    #mdlMaquinaria input{
        border-color: #000 !important;
    }
    #mdlMaquinaria .selectize-input{
        font-weight: bold !important;
    }
    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
        color: #000;
        background-color: #fff;
        border-color: #060606 #161617 #fff;
    }
    .nav-tabs {
        border-bottom: 1px solid #060606;
    }
    .nav-tabs .nav-link.active, .nav-tabs .nav-link.active:focus, .nav-tabs .nav-link.active:hover, .nav-tabs .nav-item.open .nav-link, .nav-tabs .nav-item.open .nav-link:focus, .nav-tabs .nav-item.open .nav-link:hover {
        color: #000;
        font-weight: bold !important;
    }
    .text-infinite {
        width:100px;
        height:20px;
        background:red;
        animation:myfirst 5s;
        -moz-animation:myfirst 5s infinite; /* Firefox */
        -webkit-animation:myfirst 5s infinite; /* Safari and Chrome */
    }

    .selectize-control.single .selectize-input, 
    .selectize-control.single .selectize-input input {
        border: 1px solid #000;
    }

    @-moz-keyframes myfirst /* Firefox */
    {
        0%   {background:red;}
        50%  {background:yellow;}
        100%   {background:red;}
    }

    @-webkit-keyframes myfirst /* Firefox */
    {
        0%   {background:red;}
        50%  {background:yellow;}
        100%   {background:red;}
    }
</style>