<div class="modal fade" id="mdlMaquinaria" tabindex="-1" role="dialog" 
     aria-labelledby="mdlMaquinaria" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">
                    <span class="fa fa-cogs"></span> Maquinaria
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row"> 
                    <div class="col-5">
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
                                        <input type="text" id="CodigoMaquina" name="CodigoMaquina" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12">
                                        <label>Id</label>
                                        <input type="text" id="IdMaquina" name="IdMaquina" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12">
                                        <label>Maquila</label>
                                        <div class="row">
                                            <div class="col-3">
                                                <input type="text" id="MaquilaClaveMaquina" name="MaquilaClaveMaquina" class="form-control" maxlength="3">
                                            </div>
                                            <div class="col-9"> 
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
                                        <label>Depto</label>
                                        <div class="row">
                                            <div class="col-3">
                                                <input type="text" id="DeptoClaveMaquina" name="DeptoClaveMaquina" class="form-control" maxlength="3">
                                            </div>
                                            <div class="col-9"> 
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
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Fecha alta</label>
                                                <input type="text" id="FechaAltaMaquina" name="FechaAltaMaquina" class="form-control form-control-sm date notEnter">
                                            </div>
                                            <div class="col-4">
                                                <label>Factura</label>
                                                <input type="text" id="FacturaMaquina" name="FacturaMaquina" maxlength="15" class="form-control form-control-sm date notEnter">
                                            </div>
                                            <div class="col-4">
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
                                    <div class="col-12">
                                        <label>Criticidad</label>
                                        <div class="row">
                                            <div class="col-4">
                                                <input type="text" id="ClaveCriticidadMaquina" name="ClaveCriticidadMaquina" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-8">
                                                <input type="text" id="CriticidadMaquina" name="CriticidadMaquina" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label>Estatus</label>
                                        <div class="row">
                                            <div class="col-4">
                                                <input type="text" id="ClaveEstatusMaquina" name="ClaveEstatusMaquina" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-8">
                                                <input type="text" id="EstatusMaquina" name="EstatusMaquina" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label>Baja</label>
                                        <input type="text" id="FechaBajaMaquina" name="FechaBajaMaquina" class="form-control form-control-sm date notEnter">
                                    </div>
                                    <div class="col-12">
                                        <label>Motivo</label>
                                        <input type="text" id="MotivoMaquina" name="MotivoMaquina" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div> 
                        </div>
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
    var mdlMaquinaria = $("#mdlMaquinaria");
    $(document).ready(function () {

        mdlMaquinaria.on('hidden.bs.modal', function () {
            mdlMaquinaria.find("input").val('');
            mdlMaquinaria.find("li a").removeClass("active");
            mdlMaquinaria.find("li a").attr("aria-selected", false);
            mdlMaquinaria.find("li:eq(0) a").attr("aria-selected", true);
            mdlMaquinaria.find("li:eq(0) a").addClass("active");
            mdlMaquinaria.find("#datos_maquina").addClass("show active");
            mdlMaquinaria.find("#mantenimiento").removeClass("show active");
        });

        mdlMaquinaria.on('shown.bs.modal', function () {
            mdlMaquinaria.find("#CodigoMaquina").focus();
        });

        mdlMaquinaria.find("#datos_maquina-tab").on('shown.bs.tab', function () {
            mdlMaquinaria.find("#CodigoMaquina").focus();
        });

        mdlMaquinaria.find("#mantenimiento-tab").on('shown.bs.tab', function () {
            mdlMaquinaria.find("#UltimoMantenimientoMaquina").focus();
        });
    });
</script>
<style>

    #mdlMaquinaria input{
        border-color: #000 !important;
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