<div class="modal" id="mdlSolicitudDeMantenimiento" tabindex="-1" role="dialog" 
     aria-labelledby="mdlSolicitudDeMantenimiento" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable " style="min-width: 40%;max-width: 70%; "  role="document" >
        <div class="modal-content notresizable">
            <div class="modal-header">

                <span id="atrassolmto" class="fa fa-arrow-left mt-2 mr-2 fa-lg atras_solmto d-none" style="cursor: pointer;" onclick="onVolverSolMto(this)"></span>
                <span id="atrassolmton" class="fa fa-arrow-left mt-2 mr-2 fa-lg atras_solmton d-none" style="cursor: pointer;" onclick="onVolverSolMtoN(this)"></span>

                <h5 class="modal-title" id="exampleModalCenterTitle">
                    <span class="fa fa-wrench"></span> Solicitud de mantenimiento
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row d-none" id="AltaSolicitudMto">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-8">
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
                            <div class="col-4">
                                <label>Vale</label>
                                <div class="row">
                                    <div class="col-8">
                                        <input type="text" id="SolicitudMtoVale" name="SolicitudMtoVale" class="form-control" maxlength="15">
                                    </div>
                                    <div class="col-4"> 
                                        <button type="button" id="btnImprimeSolicitudDeMToXVale" class="btn btn-info">
                                            <span class="fa fa-print"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-12">
                                <label>Id</label> 
                                <div class="row">
                                    <div class="col-4 col-xs-4 col-sm-4">
                                        <input type="text" id="CodigoMaquinaria" name="CodigoMaquinaria" class="form-control" maxlength="15">
                                    </div>
                                    <div class="col-8 col-xs-8 col-sm-8"> 
                                        <select id="MaquinariaRefaccion" name="MaquinariaRefaccion" class="form-control form-control-sm">
                                            <option></option>         
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label>Código</label>
                                <input type="text" id="CodigoSolicitud" name="CodigoSolicitud" class="form-control" maxlength="15">
                            </div>
                            <div class="col-12">
                                <label>Descripción</label>
                                <textarea id="DescripcionSolicitud" name="DescripcionSolicitud" class="form-control" maxlength="500" rows="3" cols="5"  style="resize: none;">
                                </textarea>
                            </div>
                            <div class="col-6">
                                <label>Marca</label>
                                <input type="text" id="MarcaSolicitud" name="MarcaSolicitud" class="form-control" maxlength="15">
                            </div>
                            <div class="col-6">
                                <label>Modelo</label>
                                <input type="text" id="ModeloSolicitud" name="ModeloSolicitud" class="form-control" maxlength="15">
                            </div>
                            <div class="col-12">
                                <label>Serie</label>
                                <input type="text" id="SerieSolicitud" name="SerieSolicitud" class="form-control" maxlength="50">
                            </div>
                            <div class="col-4">
                                <label>Fecha alta</label>
                                <input type="text" id="FechaAltaSolicitud" name="FechaAltaSolicitud" class="form-control date" maxlength="15">
                            </div>
                            <div class="col-4">
                                <label>Último mto</label>
                                <input type="text" id="UltimoMantenimientoSolicitud" name="UltimoMantenimientoSolicitud" class="form-control date">
                            </div>
                            <div class="col-4">
                                <label>Dias de mto</label>
                                <input type="text" id="DiasSolicitud" name="DiasSolicitud" class="form-control numbersOnly" maxlength="2">
                            </div> 
                            <div class="col-6 my-4">
                                <div class="w-100"></div>
                                <span class="switch switch-lg">
                                    <input id="ClaveCriticidadSolicitud" name="ClaveCriticidadSolicitud"  type="checkbox" class="switch">
                                    <label for="ClaveCriticidadSolicitud">Criticidad</label>
                                </span>
                            </div>
                            <div class="col-6 my-4">
                                <div class="w-100"></div>
                                <span class="switch switch-lg">
                                    <input id="ClaveEstatusSolicitud" name="ClaveEstatusSolicitud"  type="checkbox" class="switch">
                                    <label for="ClaveEstatusSolicitud">Estatus</label>
                                </span> 
                            </div>
                            <div class="col-12">
                                <label>Descripción del problema</label>
                                <textarea id="DescripcionDelProblemaSolicitud" name="DescripcionDelProblemaSolicitud" class="form-control" maxlength="500" rows="3" cols="5"  style="resize: none;">
                                </textarea>
                            </div>
                            <div class="col-12 mt-1">
                                <h6 style="color:#cc0000;">NOTA: PARA REIMPRIMIR UN VALE SOLO TECLE EL NUMERO DE VALE Y ENTER.</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12 font-weight-bold text-center">
                                <div class="row">
                                    <div class="col-4" align="left">
                                        <button type="button" class="btn btn-primary" style="background-color: #4A148C; border-color: #4A148C;">
                                            <span class="fa fa-arrow-left"></span>
                                        </button>
                                    </div>
                                    <div class="col-4"><h3>Foto</h3></div>
                                    <div class="col-4" align="right">
                                        <button type="button" class="btn btn-primary" style="background-color: #4A148C; border-color: #4A148C;">
                                            <span class="fa fa-arrow-right"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 imagen_principal_maquina">
                                        <a href="<?php print base_url('img/camera.png'); ?>" data-fancybox>
                                            <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="max-height: 633px;">
                                        </a>
                                    </div>
                                    <div class="w-100 my-2"></div>
                                    <div class="col-2 foto_uno">
                                        <img src="<?php print base_url('img/camera.png'); ?>" width="100%"  style="max-height: 82px;">

                                    </div>
                                    <div class="col-2 foto_dos">
                                        <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="max-height: 82px;">
                                        </a>
                                    </div>
                                    <div class="col-2 foto_tres">
                                        <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="max-height: 82px;">
                                        </a>
                                    </div>
                                    <div class="col-2 foto_cuatro">
                                        <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="max-height: 82px;">

                                    </div>
                                    <div class="col-2 foto_cinco">
                                        <a href="<?php print base_url('img/camera.png'); ?>" data-fancybox>
                                            <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="max-height: 82px;">
                                        </a>
                                    </div>
                                    <div class="col-2 foto_seis">
                                        <a href="<?php print base_url('img/camera.png'); ?>" data-fancybox>
                                            <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="max-height: 82px;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="row d-none" id="CierraSolicitudDeMto">
                    <div class="row ml-2 my-2">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-2">
                                    <label>Vale</label>  
                                    <input type="text" id="CSSolicitudMtoVale" name="CSSolicitudMtoVale" class="form-control" maxlength="15">
                                </div>
                                <div class="col-10">
                                    <label>Depto</label>
                                    <div class="row">
                                        <div class="col-4 col-xs-4 col-sm-4">
                                            <input type="text" id="CSDeptoClaveMaquina" name="CSDeptoClaveMaquina" readonly="" class="form-control" maxlength="3">
                                        </div>
                                        <div class="col-8 col-xs-8 col-sm-8"> 
                                            <select id="CSDeptoMaquina" name="CSDeptoMaquina" class="form-control form-control-sm">
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
                                <div class="w-100"></div>
                                <div class="col-9">
                                    <label>Id</label> 
                                    <div class="row">
                                        <div class="col-4 col-xs-4 col-sm-4">
                                            <input type="text" id="CSIdMaquinariaRefaccion" name="CSIdMaquinariaRefaccion" readonly="" class="form-control" maxlength="15">
                                        </div>
                                        <div class="col-8 col-xs-8 col-sm-8"> 
                                            <select id="CSMaquinariaRefaccion" name="CSMaquinariaRefaccion" class="form-control form-control-sm">
                                                <option></option>         
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label>Código</label>
                                    <input type="text" id="CSCodigoSolicitud" name="CSCodigoSolicitud" readonly="" class="form-control" maxlength="15">
                                </div>
                                <div class="col-12">
                                    <label>Descripción</label>
                                    <textarea id="CSDescripcionSolicitud" name="CSDescripcionSolicitud" readonly="" class="form-control" maxlength="500" rows="3" cols="5"  style="resize: none;">
                                    </textarea>
                                </div>
                                <div class="col-6">
                                    <label>Marca</label>
                                    <input type="text" id="CSMarcaSolicitud" name="CSMarcaSolicitud" readonly="" class="form-control" maxlength="15">
                                </div>
                                <div class="col-6">
                                    <label>Modelo</label>
                                    <input type="text" id="CSModeloSolicitud" name="CSModeloSolicitud" readonly="" class="form-control" maxlength="15">
                                </div>
                                <div class="col-12">
                                    <label>Serie</label>
                                    <input type="text" id="CSSerieSolicitud" name="CSSerieSolicitud" readonly="" class="form-control" maxlength="50">
                                </div>
                                <div class="col-4">
                                    <label>Fecha alta</label>
                                    <input type="text" id="CSFechaAltaSolicitud" name="CSFechaAltaSolicitud" readonly="" class="form-control date" maxlength="15">
                                </div>
                                <div class="col-4">
                                    <label>Último mto</label>
                                    <input type="text" id="CSUltimoMantenimientoSolicitud" name="CSUltimoMantenimientoSolicitud" readonly="" class="form-control date">
                                </div>
                                <div class="col-4">
                                    <label>Dias de mto</label>
                                    <input type="text" id="CSDiasSolicitud" name="CSDiasSolicitud" class="form-control numbersOnly" readonly="" maxlength="2">
                                </div> 
                                <div class="col-6 my-4">
                                    <div class="w-100"></div>
                                    <span class="switch switch-lg">
                                        <input id="CSClaveCriticidadSolicitud" name="CSClaveCriticidadSolicitud"  type="checkbox" class="switch">
                                        <label for="CSClaveCriticidadSolicitud">Criticidad</label>
                                    </span>
                                </div>
                                <div class="col-6 my-4">
                                    <div class="w-100"></div>
                                    <span class="switch switch-lg">
                                        <input id="CSClaveEstatusSolicitud" name="CSClaveEstatusSolicitud"  type="checkbox" class="switch">
                                        <label for="CSClaveEstatusSolicitud">Estatus</label>
                                    </span> 
                                </div>
                                <div class="col-12">
                                    <label>Descripción del problema</label>
                                    <textarea id="CSDescripcionDelProblemaSolicitud" name="CSDescripcionDelProblemaSolicitud" readonly="" class="form-control" maxlength="500" rows="3" cols="5"  style="resize: none;">
                                    </textarea>
                                </div> 
                                <div class="col-12">
                                    <label>Descripción de lo realizado</label>
                                    <textarea id="CSDescripcionDeloRealizado" name="CSDescripcionDeloRealizado" class="form-control"  maxlength="500" rows="3" cols="5"  style="resize: none;">
                                    </textarea>
                                </div> 
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row"> 
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 imagen_principal_maquina_cs">
                                            <a href="<?php print base_url('img/camera.png'); ?>" data-fancybox>
                                                <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="max-height: 633px;">
                                            </a>
                                        </div>
                                        <div class="w-100 my-2"></div>
                                        <div class="col-2 foto_uno_cs">
                                            <img src="<?php print base_url('img/camera.png'); ?>" width="100%"  style="max-height: 82px;">

                                        </div>
                                        <div class="col-2 foto_dos_cs">
                                            <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="max-height: 82px;">
                                            </a>
                                        </div>
                                        <div class="col-2 foto_tres_cs">
                                            <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="max-height: 82px;">
                                            </a>
                                        </div>
                                        <div class="col-2 foto_cuatro_cs">
                                            <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="max-height: 82px;">

                                        </div>
                                        <div class="col-2 foto_cinco_cs">
                                            <a href="<?php print base_url('img/camera.png'); ?>" data-fancybox>
                                                <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="max-height: 82px;">
                                            </a>
                                        </div>
                                        <div class="col-2 foto_seis_cs">
                                            <a href="<?php print base_url('img/camera.png'); ?>" data-fancybox>
                                                <img src="<?php print base_url('img/camera.png'); ?>" width="100%" style="max-height: 82px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <label>Refacción</label>
                            <input type="text" id="refa1" class="form-control">
                            <input type="text" id="refa3" class="form-control my-1">
                            <input type="text" id="refa5" class="form-control">
                            <input type="text" id="refa7" class="form-control my-1"> 
                            <input type="text" id="refa9" class="form-control"> 
                        </div>
                        <div class="col-1">
                            <label>Cantidad</label>
                            <input type="text" id="cant1" class="form-control">
                            <input type="text" id="cant3" class="form-control my-1">
                            <input type="text" id="cant5" class="form-control">
                            <input type="text" id="cant7" class="form-control my-1">
                            <input type="text" id="cant9" class="form-control">
                        </div>
                        <div class="col-1">
                            <label>Precio</label>
                            <input type="text" id="pre1" class="form-control">
                            <input type="text" id="pre3" class="form-control my-1">
                            <input type="text" id="pre5" class="form-control">
                            <input type="text" id="pre7" class="form-control my-1">
                            <input type="text" id="pre9" class="form-control">
                        </div>
                        <div class="col-4">
                            <label>Refacción</label>
                            <input type="text" id="refa2" class="form-control">
                            <input type="text" id="refa4" class="form-control my-1">
                            <input type="text" id="refa6" class="form-control">
                            <input type="text" id="refa8" class="form-control my-1">
                            <input type="text" id="refa10" class="form-control">
                        </div>
                        <div class="col-1">
                            <label>Cantidad</label>
                            <input type="text" id="cant2" class="form-control">
                            <input type="text" id="cant4" class="form-control my-1">
                            <input type="text" id="cant6" class="form-control">
                            <input type="text" id="cant8" class="form-control my-1">
                            <input type="text" id="cant10" class="form-control">
                        </div>
                        <div class="col-1">
                            <label>Precio</label>
                            <input type="text" id="pre2" class="form-control">
                            <input type="text" id="pre4" class="form-control my-1">
                            <input type="text" id="pre6" class="form-control">
                            <input type="text" id="pre8" class="form-control my-1">
                            <input type="text" id="pre10" class="form-control">
                        </div>
                    </div>
                    <div class="col-1">
                        <label>TP</label>
                        <input type="text" id="CSTP" name="CSTP" class="form-control">
                    </div>
                    <div class="col-2">
                        <label>Factura</label>
                        <input type="text" id="numfac" name="numfac" class="form-control">
                    </div>
                    <div class="col-6">
                        <label>Proveedor</label>
                        <input type="text" id="numpro" name="numpro" class="form-control">
                    </div>
                    <div class="col-3">
                        <label>Costo Mano de obra</label>
                        <input type="text" id="ctomaho" name="ctomaho" class="form-control">
                    </div>
                </div> 
                <div class="row" id="SolicitudesDeManto">
                    <div class="col-12 col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2" align="left">
                        <button type="button" class="btn btn-info font-weight-bold" id="btnCierraSolicitudMto">
                            <span class="fa fa-file-archive"></span> CIERRA SOLICITUD
                        </button>  
                    </div>
                    <div class="col-12 col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4" align="left">
                        <div class="row">
                            <div class="col-4">
                                <input type="text" id="NoVale" name="NoVale" class="form-control" autofocus="">
                            </div>
                            <div class="col-8">
                                <button type="button" class="btn btn-info font-weight-bold" id="btnImprimeXNoVale">
                                    <span class="fa fa-print"></span> 
                                </button> 
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6" align="right">
                        <button type="button" id="btnNuevaSolicitud" class="btn btn-info" style="background-color: #4CAF50; border-color: #4CAF50;">
                            <span class="fa fa-star"></span> NUEVO 
                        </button>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblSolicitudesMto" class="table  table-sm table-bordered nowrap" style="width:  100%;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th> 
                                    <th scope="col">CÓDIGO</th> 
                                    <th scope="col">DESCRIPCIÓN</th> 

                                    <th scope="col">DESCRIPCION REFACCIÓN</th> 
                                    <th scope="col">HORA DE LLEGADA</th> 
                                    <th scope="col">HORA DE ENTRADA</th> 

                                    <th scope="col">REFACCION UNO</th> 
                                    <th scope="col">CANTIDAD UNO</th> 
                                    <th scope="col">PRECIO UNO</th> 

                                    <th scope="col">REFACCION DOS</th> 
                                    <th scope="col">CANTIDAD DOS</th> 
                                    <th scope="col">PRECIO DOS</th>  
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer"> 
                <button type="button" id="btnImprimeGuardaSolicitudMto" class="btn btn-secondary d-none"  style="background-color: #000000;    border-color: #000000;"><span class="fa fa-save"></span> GUARDAR </button> 
                <button type="button" class="btn btn-secondary d-none" id="btnGuardarCierreSolicitud" style="background-color: #000000;    border-color: #000000;"><span class="fa fa-save"></span> GUARDAR </button> 
            </div>
        </div>
    </div>
</div>
<script>
    var mdlSolicitudDeMantenimiento = $("#mdlSolicitudDeMantenimiento"), btnCierraSolicitudMto = mdlSolicitudDeMantenimiento.find("#btnCierraSolicitudMto");

    var DeptoClaveMaquina = mdlSolicitudDeMantenimiento.find('#DeptoClaveMaquina'),
            DeptoMaquina = mdlSolicitudDeMantenimiento.find('#DeptoMaquina'),
            SolicitudMtoVale = mdlSolicitudDeMantenimiento.find('#SolicitudMtoVale'),
            CodigoMaquinaria = mdlSolicitudDeMantenimiento.find('#CodigoMaquinaria'),
            MaquinariaRefaccion = mdlSolicitudDeMantenimiento.find('#MaquinariaRefaccion'),
            CodigoSolicitud = mdlSolicitudDeMantenimiento.find('#CodigoSolicitud'),
            DescripcionSolicitud = mdlSolicitudDeMantenimiento.find('#DescripcionSolicitud'),
            MarcaSolicitud = mdlSolicitudDeMantenimiento.find('#MarcaSolicitud'),
            ModeloSolicitud = mdlSolicitudDeMantenimiento.find('#ModeloSolicitud'),
            SerieSolicitud = mdlSolicitudDeMantenimiento.find('#SerieSolicitud'),
            FechaAltaSolicitud = mdlSolicitudDeMantenimiento.find('#FechaAltaSolicitud'),
            UltimoMantenimientoSolicitud = mdlSolicitudDeMantenimiento.find('#UltimoMantenimientoSolicitud'),
            DiasSolicitud = mdlSolicitudDeMantenimiento.find('#DiasSolicitud'), ClaveCriticidadSolicitud = mdlSolicitudDeMantenimiento.find('#ClaveCriticidadSolicitud'),
            ClaveEstatusSolicitud = mdlSolicitudDeMantenimiento.find('#ClaveEstatusSolicitud'),
            DescripcionDelProblemaSolicitud = mdlSolicitudDeMantenimiento.find('#DescripcionDelProblemaSolicitud'),
            btnImprimeGuardaSolicitudMto = mdlSolicitudDeMantenimiento.find('#btnImprimeGuardaSolicitudMto'),
            tblSolicitudesMto = mdlSolicitudDeMantenimiento.find("#tblSolicitudesMto"), Solicitudes,
            AltaSolicitudMto = mdlSolicitudDeMantenimiento.find("#AltaSolicitudMto"),
            btnNuevaSolicitud = mdlSolicitudDeMantenimiento.find("#btnNuevaSolicitud"),
            SolicitudesDeManto = mdlSolicitudDeMantenimiento.find("#SolicitudesDeManto"),
            btnImprimeSolicitudDeMToXVale = mdlSolicitudDeMantenimiento.find("#btnImprimeSolicitudDeMToXVale"),
            btnImprimeXNoVale = mdlSolicitudDeMantenimiento.find("#btnImprimeXNoVale"),
            nuevo = true;
    var CSSolicitudMtoVale = mdlSolicitudDeMantenimiento.find("#CSSolicitudMtoVale"),
            btnGuardarCierreSolicitud = mdlSolicitudDeMantenimiento.find("#btnGuardarCierreSolicitud");

    function onSalirSolMto() {
        $.each(mdlSolicitudDeMantenimiento.find("div.imagen_principal_maquina img, div.foto_uno img, div.foto_dos img, div.foto_tres img,div.foto_cuatro img,div.foto_cinco img,div.foto_seis img"), function (k, v) {
            onSetImagen($(v), '<?php print base_url('img/camera.png'); ?>');
        });
        AltaSolicitudMto.removeClass("d-none");
        SolicitudesDeManto.addClass("d-none");
        onClearPanelInputSelect(mdlSolicitudDeMantenimiento, function () {
            DeptoClaveMaquina.focus().select();
        });
    }

    function getSolicitudXVale() {
        var vale = SolicitudMtoVale.val();
        if (vale) {
            onDisable(SolicitudMtoVale);
            onDisable(btnImprimeSolicitudDeMToXVale);
            onOpenOverlay('Generando...');
            $.getJSON('<?php print base_url('SolicitudDeMantenimiento/onRevisarSiElValeExiste') ?>',
                    {VALE: vale}).done(function (a) {
                var r = a[0];
                switch (parseInt(r.EXISTE)) {
                    case 1:
                        $.post('<?php print base_url('SolicitudDeMantenimiento/getSolicitudMtoXVale') ?>',
                                {VALE: vale}).done(function (a, b, c) {
                            onCloseOverlay();
                            onEnable(SolicitudMtoVale);
                            onEnable(btnImprimeSolicitudDeMToXVale);
                            onImprimirReporteFancyAFC(a, function (a, b) {
                                SolicitudMtoVale.focus().select();
                            });
                        }).fail(function (x, y, z) {
                            getError(x);
                        }).always(function () {

                        });
                        break;
                    default:
                        onEnable(SolicitudMtoVale);
                        onEnable(btnImprimeSolicitudDeMToXVale);
                        onCloseOverlay();
                        onCampoInvalido(mdlSolicitudDeMantenimiento, "EL VALE ESPECIFICADO NO EXISTE", function () {
                            SolicitudMtoVale.focus().select();
                        });
                        break;
                }
            }).fail(function (x, y, z) {
                getError(x);
            });
            onEnable(SolicitudMtoVale);
            onEnable(btnImprimeSolicitudDeMToXVale);
        } else {
            onEnable(SolicitudMtoVale);
            onEnable(btnImprimeSolicitudDeMToXVale);
            onCloseOverlay();
            onCampoInvalido(mdlSolicitudDeMantenimiento, "DEBE DE ESPECIFICAR UN NUMERO DE VALE", function () {
                SolicitudMtoVale.focus().select();
            });
        }
    }

    function onVolverSolMto(e) {
        $(e).addClass("d-none");
        btnGuardarCierreSolicitud.addClass("d-none");
        SolicitudesDeManto.removeClass("d-none");
        btnImprimeGuardaSolicitudMto.addClass("d-none");
        AltaSolicitudMto.addClass("d-none");
        mdlSolicitudDeMantenimiento.find("#CierraSolicitudDeMto").addClass("d-none");
        mdlSolicitudDeMantenimiento.find("#CierraSolicitudDeMto").find("input").val("");
        mdlSolicitudDeMantenimiento.find("#CierraSolicitudDeMto").find("").val("");
        onClearPanelInputSelect(mdlSolicitudDeMantenimiento.find("#CierraSolicitudDeMto"));
        getSolicitudesMto();
    }

    function onVolverSolMtoN(e) {
        $(e).addClass("d-none");
        btnImprimeGuardaSolicitudMto.addClass("d-none");
        mdlSolicitudDeMantenimiento.find("#CierraSolicitudDeMto").addClass("d-none");
        AltaSolicitudMto.addClass("d-none");
        SolicitudesDeManto.removeClass("d-none");
        getSolicitudesMto();
    }

    function getSolicitudXNumeroDeVale(novale, btnvale) {
        var vale = novale.val();
        if (vale) {
            onDisable(novale);
            onDisable(btnvale);
            onOpenOverlay('Generando...');
            $.getJSON('<?php print base_url('SolicitudDeMantenimiento/onRevisarSiElValeExiste') ?>',
                    {VALE: vale}).done(function (a) {
                var r = a[0];
                switch (parseInt(r.EXISTE)) {
                    case 1:
                        $.post('<?php print base_url('SolicitudDeMantenimiento/getSolicitudMtoXVale') ?>',
                                {VALE: vale}).done(function (a, b, c) {
                            onCloseOverlay();
                            onEnable(novale);
                            onEnable(btnvale);
                            onImprimirReporteFancyAFC(a, function (a, b) {
                                novale.focus().select();
                            });
                        }).fail(function (x, y, z) {
                            getError(x);
                        }).always(function () {

                        });
                        break;
                    default:
                        onEnable(novale);
                        onEnable(btnvale);
                        onCloseOverlay();
                        onCampoInvalido(mdlSolicitudDeMantenimiento, "EL VALE ESPECIFICADO NO EXISTE", function () {
                            novale.focus().select();
                        });
                        break;
                }
            }).fail(function (x, y, z) {
                getError(x);
            });
            onEnable(novale);
            onEnable(btnvale);
        } else {
            onEnable(novale);
            onEnable(btnvale);
            onCloseOverlay();
            onCampoInvalido(mdlSolicitudDeMantenimiento, "DEBE DE ESPECIFICAR UN NUMERO DE VALE", function () {
                novale.focus().select();
            });
        }
    }

    var indice_foto = 1;
    $(document).ready(function () {

        btnGuardarCierreSolicitud.click(function () {

        });

        CSSolicitudMtoVale.keydown(function (e) {
            if (e.keyCode === 13 && CSSolicitudMtoVale.val()) {
                onOpenOverlay('Cargando...');
                $.getJSON('<?php print base_url('SolicitudDeMantenimiento/getSolicitudXNumeroDeVale'); ?>', {
                    VALE: CSSolicitudMtoVale.val()
                }).done(function (a, b, c) {
                    if (a.length > 0) {
                        var r = a[0];
                        mdlSolicitudDeMantenimiento.find("#CSDeptoClaveMaquina").val(r.depto);
                        mdlSolicitudDeMantenimiento.find("#CSDeptoMaquina")[0].selectize.setValue(r.depto);
                        mdlSolicitudDeMantenimiento.find("#CSIdMaquinariaRefaccion").val(r.codigo);
                        mdlSolicitudDeMantenimiento.find("#CSMaquinariaRefaccion")[0].selectize.setValue(r.idmaq);
                        mdlSolicitudDeMantenimiento.find("#CSCodigoSolicitud").val(r.nummaq);
                        mdlSolicitudDeMantenimiento.find("#CSDescripcionSolicitud").val(r.nommaq);
                        mdlSolicitudDeMantenimiento.find("#CSMarcaSolicitud").val(r.marmaq);
                        mdlSolicitudDeMantenimiento.find("#CSModeloSolicitud").val(r.modmaq);
                        mdlSolicitudDeMantenimiento.find("#CSSerieSolicitud").val(r.sermaq);
                        mdlSolicitudDeMantenimiento.find("#CSFechaAltaSolicitud").val(r.fechaalt);
                        mdlSolicitudDeMantenimiento.find("#CSUltimoMantenimientoSolicitud").val(r.fecultma);
                        mdlSolicitudDeMantenimiento.find("#CSDiasSolicitud").val(r.diasmaq);
                        mdlSolicitudDeMantenimiento.find("#CSDescripcionDelProblemaSolicitud").val(r.desdpro);
                        mdlSolicitudDeMantenimiento.find("#CSClaveCriticidadSolicitud")[0].checked = parseInt(r.critisida) === 2;
                        mdlSolicitudDeMantenimiento.find("#CSClaveEstatusSolicitud")[0].checked = parseInt(r.stsmaq) === 2;
                        mdlSolicitudDeMantenimiento.find("#CSDescripcionDeloRealizado").val(r.desdrea);
                        mdlSolicitudDeMantenimiento.find("#CSDescripcionDeloRealizado").focus().select();

                        for (var i = 1, max = 10; i <= max; i++) {
                            mdlSolicitudDeMantenimiento.find("#refa" + i).val(r["refa" + i]);
                            mdlSolicitudDeMantenimiento.find("#cant" + i).val(r["cant" + i]);
                            mdlSolicitudDeMantenimiento.find("#pre" + i).val(r["pre" + i]);
                        }
                        mdlSolicitudDeMantenimiento.find("#CSDescripcionDeloRealizado").val(r.desdrea);
                        mdlSolicitudDeMantenimiento.find("#CSTP").val(r.tp);
                        mdlSolicitudDeMantenimiento.find("#numfac").val(r.numfac);
                        mdlSolicitudDeMantenimiento.find("#numpro").val(r.numpro);
                        mdlSolicitudDeMantenimiento.find("#ctomaho").val(r.ctomaho);
                        if (parseInt(r.stsmaq) === 2) {
                            onCampoInvalido(mdlSolicitudDeMantenimiento, "MAQUINA DADA DE BAJA.", function () {
                                CSSolicitudMtoVale.focus().select();
                            });
                        }
                        if (parseInt(r.ident) === 2) {
                            onDisable(btnGuardarCierreSolicitud);
                            onCampoInvalido(mdlSolicitudDeMantenimiento, "SOLICITUD CERRADA.", function () {
                                CSSolicitudMtoVale.focus().select();
                            });
                        } else {
                            onEnable(btnGuardarCierreSolicitud);
                        }
                    }
                    onCloseOverlay();
                }).fail(function (x, y, z) {
                    onCloseOverlay();
                    getError(x);
                });
            }
        });

        SolicitudMtoVale.keydown(function (e) {
            if (e.keyCode === 13 && SolicitudMtoVale.val()) {
                getSolicitudXVale();
            }
        });

        mdlSolicitudDeMantenimiento.find("#NoVale").keydown(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                getSolicitudXNumeroDeVale(mdlSolicitudDeMantenimiento.find("#NoVale"), btnImprimeXNoVale);
            }
        });

        btnImprimeXNoVale.click(function () {
            getSolicitudXNumeroDeVale(mdlSolicitudDeMantenimiento.find("#NoVale"), btnImprimeXNoVale);
        });

        btnImprimeSolicitudDeMToXVale.click(function () {
            getSolicitudXVale();
        });

        mdlSolicitudDeMantenimiento.find("div.foto_uno img, div.foto_dos img, div.foto_tres img,div.foto_cuatro img,div.foto_cinco img,div.foto_seis img").click(function () {
            onSetImagen(mdlSolicitudDeMantenimiento.find("div.imagen_principal_maquina img"), $(this)[0].src);
            mdlSolicitudDeMantenimiento.find("div.imagen_principal_maquina").find("a")[0].href = $(this)[0].src;
        });

        CodigoMaquinaria.keydown(function (e) {
            if (e.keyCode === 13 && CodigoMaquinaria.val()) {
                MaquinariaRefaccion[0].selectize.setValue(CodigoMaquinaria.val());
                if (MaquinariaRefaccion.val() === '') {
                    onCampoInvalido(mdlSolicitudDeMantenimiento, "No. DE MAQUINA INVÁLIDO, INGRESE OTRO O INTENTE MÁS TARDE", function () {
                        CodigoMaquinaria.focus().select();
                        CodigoSolicitud.val("");
                        DescripcionSolicitud.val("");
                        MarcaSolicitud.val("");
                        ModeloSolicitud.val("");
                        SerieSolicitud.val("");
                        FechaAltaSolicitud.val("");
                        UltimoMantenimientoSolicitud.val("");
                        DiasSolicitud.val("");
                        ClaveCriticidadSolicitud[0].checked = false;
                        ClaveEstatusSolicitud[0].checked = false;
                    });
                    return;
                }
                onOpenOverlay('Cargando...');
                $.getJSON('<?php print base_url('SolicitudDeMantenimiento/getMaquinariabyID'); ?>',
                        {ID: CodigoMaquinaria.val()}).done(function (a) {
                    console.log(a.length, a);
                    if (a.length > 0) {
                        var r = a[0];
                        CodigoSolicitud.val(r.nummaq);
                        DescripcionSolicitud.val(r.nommaq);
                        MarcaSolicitud.val(r.marmaq);
                        ModeloSolicitud.val(r.modmaq);
                        SerieSolicitud.val(r.sermaq);
                        FechaAltaSolicitud.val(r.fechaalt);
                        UltimoMantenimientoSolicitud.val(r.fechaalt);
                        DiasSolicitud.val(r.diasmaq);

                        ClaveCriticidadSolicitud[0].checked = (parseInt(r.critisida) === 2) ? true : false;
                        ClaveEstatusSolicitud[0].checked = (parseInt(r.stsmaq) === 2) ? true : false;
                        var url_site = '<?php print base_url(); ?>/';
                        onSetImagen(mdlSolicitudDeMantenimiento.find("div.imagen_principal_maquina img"), url_site + r.FotoUno);
                        mdlSolicitudDeMantenimiento.find("div.imagen_principal_maquina").find("a")[0].href = url_site + r.FotoUno;
                        if (r.FotoUno !== null) {
                            onSetImagen(mdlSolicitudDeMantenimiento.find("div.foto_uno img"), url_site + r.FotoUno);
                        }
                        if (r.FotoDos !== null) {
                            onSetImagen(mdlSolicitudDeMantenimiento.find("div.foto_dos img"), url_site + r.FotoDos);
                        }
                        if (r.FotoTres !== null) {
                            onSetImagen(mdlSolicitudDeMantenimiento.find("div.foto_tres img"), url_site + r.FotoTres);
                        }
                        if (r.FotoCuatro !== null) {
                            onSetImagen(mdlSolicitudDeMantenimiento.find("div.foto_cuatro img"), url_site + r.FotoCuatro);
                        }
                        if (r.FotoCinco !== null) {
                            onSetImagen(mdlSolicitudDeMantenimiento.find("div.foto_cinco img"), url_site + r.FotoCinco);
                        }
                        if (r.FotoSeis !== null) {
                            onSetImagen(mdlSolicitudDeMantenimiento.find("div.foto_seis img"), url_site + r.FotoSeis);
                        }

                        DescripcionDelProblemaSolicitud.focus().select();
                    }
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    onCloseOverlay();
                });
            }
        });

        btnNuevaSolicitud.click(function () {
            mdlSolicitudDeMantenimiento.find("#atrassolmton").removeClass("d-none");
            btnImprimeGuardaSolicitudMto.removeClass("d-none");
            btnGuardarCierreSolicitud.addClass("d-none");
            onSalirSolMto();
            getUltimoVale();
            getMaquinaria();
        });

        mdlSolicitudDeMantenimiento.on('hidden.bs.modal', function () {
            btnImprimeGuardaSolicitudMto.addClass("d-none");
            mdlSolicitudDeMantenimiento.find("#CierraSolicitudDeMto").addClass("d-none");
            mdlSolicitudDeMantenimiento.find("div.modal-header").find("svg#atrassolmto").addClass("d-none");
            mdlSolicitudDeMantenimiento.find("div.modal-header").find("svg#atrassolmton").addClass("d-none");
            onSalirSolMto();
        });

        mdlSolicitudDeMantenimiento.on('shown.bs.modal', function () {
            AltaSolicitudMto.addClass("d-none");
            SolicitudesDeManto.removeClass("d-none");
            getSolicitudesMto();
            nuevo = true;
        });

        btnCierraSolicitudMto.click(function () {
            getMaquinaria();
            btnGuardarCierreSolicitud.removeClass("d-none");
            SolicitudesDeManto.addClass("d-none");
            btnImprimeGuardaSolicitudMto.addClass("d-none");
            AltaSolicitudMto.addClass("d-none");
            mdlSolicitudDeMantenimiento.find("#CierraSolicitudDeMto").removeClass("d-none");
            mdlSolicitudDeMantenimiento.find("#CierraSolicitudDeMto").find("#CSSolicitudMtoVale").focus().select();
            mdlSolicitudDeMantenimiento.find("#atrassolmto").removeClass("d-none");
        });

        mdlSolicitudDeMantenimiento.find("button").addClass("font-weight-bold").css({"text-transform": "uppercase"});

        btnImprimeGuardaSolicitudMto.click(function () {
            if (SolicitudMtoVale.val()) {
                if (DeptoClaveMaquina.val()) {
                    if (DescripcionDelProblemaSolicitud.val()) {
                        onDisable(btnImprimeGuardaSolicitudMto);
                        HoldOn.open({
                            theme: 'sk-rect',
                            message: 'GENERANDO...'
                        });
                        $.post('<?php print base_url('SolicitudDeMantenimiento/onAgregar'); ?>',
                                {
                                    VALE: SolicitudMtoVale.val(),
                                    DEPTO_CLAVE: DeptoClaveMaquina.val(),
                                    CODIGO: CodigoMaquinaria.val(),
                                    DESCRIPCION_PROBLEMA: DescripcionDelProblemaSolicitud.val()
                                }).done(function (data, x, jq) {
                            console.log(data);
                            $.post('<?php print base_url('SolicitudDeMantenimiento/getReporteDeSolicitudMantenimiento'); ?>',
                                    {
                                        VALE: SolicitudMtoVale.val(),
                                    }).done(function (data, x, jq) {
                                onImprimirReporteFancyAFC(data, function (a, b) {
                                    nuevo = true;
                                    mdlSolicitudDeMantenimiento.find("input").val('');
                                    $.each(mdlSolicitudDeMantenimiento.find("select"), function (k, v) {
                                        mdlSolicitudDeMantenimiento.find("select")[k].selectize.clear(true);
                                    });
                                });
                                onCloseOverlay();
                            }).fail(function (x) {
                                onCloseOverlay();
                                console.log(x.responseText);
                                onBeep(2);
                                onEnable(btnImprimeGuardaSolicitudMto);
                            }).fail(function (x, y, z) {
                                onCloseOverlay();
                                console.log(x.responseText);
                                onBeep(2);
                                swal('ATENCIÓN', 'HA OCURRIDO UN PROBLEMA AL GENERAR LOS REPORTES, REVISE LA CONSOLA PARA MÁS DETALLES', 'warning');
                            }).always(function () {
                                console.log('ok');
                                HoldOn.close();
                            });
                        });
                    } else {
                        onEnable(btnImprimeGuardaSolicitudMto);
                        onCampoInvalido(mdlSolicitudDeMantenimiento, "DEBE DE ESPECIFICAR UN PROBLEMA", function () {
                            DescripcionDelProblemaSolicitud.focus().select();
                        });
                    }
                } else {
                    onEnable(btnImprimeGuardaSolicitudMto);
                    onCampoInvalido(mdlSolicitudDeMantenimiento, "DEBE DE ESPECIFICAR UN DEPARTAMENTO", function () {
                        DeptoClaveMaquina.focus().select();
                    });
                }
            } else {
                onEnable(btnImprimeGuardaSolicitudMto);
                onCampoInvalido(mdlSolicitudDeMantenimiento, "DEBE DE ESPECIFICAR UN VALE", function () {
                    SolicitudMtoVale.focus().select();
                });
            }
        });
        mdlSolicitudDeMantenimiento.on('shown.bs.modal', function () {
            mdlSolicitudDeMantenimiento.find("input,textarea").val('');
            DeptoClaveMaquina.focus();
        });
        DeptoClaveMaquina.keydown(function (e) {
            if (e.keyCode === 13 && DeptoClaveMaquina.val() !== '') {
                DeptoMaquina[0].selectize.setValue(DeptoClaveMaquina.val());
            }
        });
        DeptoMaquina.change(function () {
            DeptoClaveMaquina.val($(this).val());
            CodigoMaquinaria.focus();
        });

    });

    function getUltimoVale() {
        $.getJSON('<?php print base_url('SolicitudDeMantenimiento/getUltimoVale'); ?>').done(function (d) {
            SolicitudMtoVale.val(d[0].VALE);
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getMaquinaria() {
        $.getJSON('<?php print base_url('SolicitudDeMantenimiento/getMaquinaria'); ?>').done(function (a, b, c) {
            onClearSelect(MaquinariaRefaccion);
            onClearSelect(mdlSolicitudDeMantenimiento.find("#CSMaquinariaRefaccion"));
            $.each(a, function (k, v) {
                MaquinariaRefaccion[0].selectize.addOption({text: v.nommaq, value: v.id});
                mdlSolicitudDeMantenimiento.find("#CSMaquinariaRefaccion")[0].selectize.addOption({text: v.nommaq, value: v.id});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {

        });
    }

    function getSolicitudesMto() {
        if ($.fn.DataTable.isDataTable('#tblSolicitudesMto')) {
            Solicitudes.ajax.reload(function () {
                mdlSolicitudDeMantenimiento.find("#NoVale").focus();
            });
            return;
        } else {
            var cols = [{"data": "ID"}/*0*/,
                {"data": "CODIGO"}/*1*/,
                {"data": "DESCRIPCION"}/*2*/,
                {"data": "DESCRIPCIONREF"}/*3*/,
                {"data": "HORALLEGADA"}/*4*/, {"data": "HORAENTRADA"}/*5*/,
                {"data": "REFACCION_UNO"}/*6*/,
                {"data": "CANTIDAD_UNO"}/*7*/,
                {"data": "PRECIO_UNO"}/*8*/,
                {"data": "REFACCION_DOS"}/*9*/,
                {"data": "CANTIDAD_DOS"}/*10*/,
                {"data": "PRECIO_DOS"}/*11*/
            ];
            var coldefs = [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ];
            Solicitudes = tblSolicitudesMto.DataTable({
                "dom": 'ritp',
                "ajax": {
                    "url": '<?php print base_url('SolicitudDeMantenimiento/getSolicitudes'); ?>',
                    "dataSrc": "", "data": function (d) {
                        d.VALE = 1;
                    }},
                buttons: buttons,
                "columns": cols,
                "columnDefs": coldefs,
                language: lang, select: true,
                "autoWidth": true,
                "colReorder": true,
                "displayLength": 50, "bLengthChange": false, "deferRender": true, "scrollCollapse": false, "bSort": true,
                "scrollY": "450px",
                "scrollX": true,
                "aaSorting": [
                    [1, 'desc']
                ],
                initComplete: function (a, b) {
                    mdlSolicitudDeMantenimiento.find("#NoVale").focus();
                }
            });
        }
    }

    function onSetImagen(objeto, url) {
        if (url !== null) {
            objeto[0].src = url;
        } else {
            objeto[0].src = '<?php print base_url('img/camera.png'); ?>';
        }
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
    #mdlSolicitudDeMantenimiento input{
        border-color: #000 !important;
    }
    #mdlSolicitudDeMantenimiento .selectize-input{
        font-weight: bold !important;
    }
    @media (min-width: 500px) {
        #mdlSolicitudDeMantenimiento.modal-lg {
            width: 900px !important; 
        }
    }
    #tblSolicitudesMto tbody td{
        font-weight: bold;
        font-size: 18px;
    }
    #tblSolicitudesMto tbody tr:hover span.solicitud_de_mto_codigo{
        color: #FFD700; 
    }
    #mdlSolicitudDeMantenimiento img:hover {
        cursor: pointer;
    }
    .atras_solmto,.atras_solmton{
        transition: all .2s ease-in-out;
    }
    .atras_solmto:hover,.atras_solmton:hover{
        color: #0099ff !important;
        -ms-transform: scale(2,2); /* IE 9 */
        transform: scale(2,2);
    }
</style>