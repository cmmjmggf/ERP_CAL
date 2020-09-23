<div class="modal fade" id="mdlSolicitudDeMantenimiento" tabindex="-1" role="dialog" 
     aria-labelledby="mdlSolicitudDeMantenimiento" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable " role="document" >
        <div class="modal-content notresizable">
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
                                <input type="text" id="SolicitudMtoVale" name="SolicitudMtoVale" class="form-control" maxlength="15">
                            </div>
                            <div class="w-100"></div>
                            <div class="col-12">
                                <label>Id</label> 
                                <div class="row">
                                    <div class="col-4 col-xs-4 col-sm-4">
                                        <input type="text" id="IdMaquinariaRefaccion" name="IdMaquinariaRefaccion" class="form-control" maxlength="15">
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
                            <div class="col-12 font-weight-bold text-center"><h3>Foto</h3></div>
                            <div class="col-12">
                                <img src="<?php print base_url('img/camera.png'); ?>" width="100%">
                            </div>
                        </div>
                    </div>
                    <div class="col-6" align="left">
                        <button type="button" class="btn btn-success font-weight-bold" style="background-color: #6eb71a; border-color: #6eb71a;" id="btnImprimeGuardaSolicitudMto">
                            <span class="fa fa-check"></span> IMPRIME / GUARDA
                        </button> 
                    </div>
                    <div class="col-6" align="right">
                        <button type="button" class="btn btn-info font-weight-bold" id="btnCierraSolicitudMto">
                            <span class="fa fa-file-archive"></span> CIERRA SOLICITUD
                        </button> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                        <table id="tblSolicitudesMto" class="table  table-sm table-bordered" style="width:  100%;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th> 
                                    <th scope="col">CÓDIGO</th> 
                                    <th scope="col">DESCRIPCIÓN</th> 

                                    <th scope="col">DESCRIPCIONREF</th> 
                                    <th scope="col">HORALLEGADA</th> 
                                    <th scope="col">HORAENTRADA</th> 

                                    <th scope="col">REFACCION_UNO</th> 
                                    <th scope="col">CANTIDAD_UNO</th> 
                                    <th scope="col">PRECIO_UNO</th> 

                                    <th scope="col">REFACCION_DOS</th> 
                                    <th scope="col">CANTIDAD_DOS</th> 
                                    <th scope="col">PRECIO_DOS</th>  
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer"> 
                <div class="col-6" align="left">
                    <button type="button" id="btnVerSolicitudes" class="btn btn-secondary"  style="background-color: #C62828;    border-color: #B71C1C;">Ver solicitudes</button> 
                </div>
                <div class="col-6"  align="right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: #C62828;    border-color: #B71C1C;">Cerrar</button> 
                </div> 
            </div>
        </div>
    </div>
</div>
<script>
    var mdlSolicitudDeMantenimiento = $("#mdlSolicitudDeMantenimiento"), btnCierraSolicitudMto = mdlSolicitudDeMantenimiento.find("#btnCierraSolicitudMto");

    var DeptoClaveMaquina = mdlSolicitudDeMantenimiento.find('#DeptoClaveMaquina'),
            DeptoMaquina = mdlSolicitudDeMantenimiento.find('#DeptoMaquina'),
            SolicitudMtoVale = mdlSolicitudDeMantenimiento.find('#SolicitudMtoVale'),
            IdMaquinariaRefaccion = mdlSolicitudDeMantenimiento.find('#IdMaquinariaRefaccion'),
            MaquinariaRefaccion = mdlSolicitudDeMantenimiento.find('#MaquinariaRefaccion'),
            CodigoSolicitud = mdlSolicitudDeMantenimiento.find('#CodigoSolicitud'),
            DescripcionSolicitud = mdlSolicitudDeMantenimiento.find('#DescripcionSolicitud'),
            MarcaSolicitud = mdlSolicitudDeMantenimiento.find('#MarcaSolicitud'),
            ModeloSolicitud = mdlSolicitudDeMantenimiento.find('#ModeloSolicitud'),
            SerieSolicitud = mdlSolicitudDeMantenimiento.find('#SerieSolicitud'),
            FechaAltaSolicitud = mdlSolicitudDeMantenimiento.find('#FechaAltaSolicitud'),
            UltimoMantenimientoSolicitud = mdlSolicitudDeMantenimiento.find('#UltimoMantenimientoSolicitud'),
            DiasSolicitud = mdlSolicitudDeMantenimiento.find('#DiasSolicitud'),
            ClaveCriticidadSolicitud = mdlSolicitudDeMantenimiento.find('#ClaveCriticidadSolicitud'),
            ClaveEstatusSolicitud = mdlSolicitudDeMantenimiento.find('#ClaveEstatusSolicitud'),
            DescripcionDelProblemaSolicitud = mdlSolicitudDeMantenimiento.find('#DescripcionDelProblemaSolicitud'),
            btnImprimeGuardaSolicitudMto = mdlSolicitudDeMantenimiento.find('#btnImprimeGuardaSolicitudMto'),
            tblSolicitudesMto = mdlSolicitudDeMantenimiento.find("#tblSolicitudesMto"), Solicitudes;


    $(document).ready(function () {

        mdlSolicitudDeMantenimiento.on('shown.bs.modal', function () {
            getSolicitudesMto();
        });

        btnCierraSolicitudMto.click(function () {
            mdlSolicitudDeMantenimiento.modal('hide');
            mdlCierraSolicitudDeMantenimiento.modal('show');
        });

        mdlSolicitudDeMantenimiento.find("button").addClass("font-weight-bold").css({"text-transform": "uppercase"});

        btnImprimeGuardaSolicitudMto.click(function () {
            if (SolicitudMtoVale.val()) {
                if (DeptoClaveMaquina.val()) {

                } else {
                    onCampoInvalido(mdlSolicitudDeMantenimiento, "DEBE DE ESPECIFICAR UN DEPARTAMENTO", function () {
                        DeptoClaveMaquina.focus().select();
                    });
                }
            } else {
                onCampoInvalido(mdlSolicitudDeMantenimiento, "DEBE DE ESPECIFICAR UN VALE", function () {
                    SolicitudMtoVale.focus().select();
                });
            }
        });

        mdlSolicitudDeMantenimiento.on('shown.bs.modal', function () {
            mdlSolicitudDeMantenimiento.find("input,textarea").val('');
            onClearPanelInputSelect(mdlSolicitudDeMantenimiento, function () {

            });
            DeptoClaveMaquina.focus();
        });

        DeptoClaveMaquina.keydown(function (e) {
            if (e.keyCode === 13) {
            }
        });

        DeptoMaquina.change(function () {
            DeptoClaveMaquina.val($(this).val());
            IdMaquinariaRefaccion.focus();
        });

    });
    function getMaquinaria() {
        $.getJSON('<?php print base_url('SolicitudDeMantenimiento/getMaquinaria'); ?>').done(function (a, b, c) {
            MaquinariaRefaccion[0].selectize.clear(true);
            MaquinariaRefaccion[0].selectize.clearOptions();
            $.each(a, function (k, v) {
                MaquinariaRefaccion[0].selectize.addOption({text: v.nommaq, value: v.id});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {

        });
    }

    function getSolicitudesMto() {
        if ($.fn.DataTable.isDataTable('#tblSolicitudesMto')) {
            Solicitudes.ajax.reload();
            return;
        } else {
            var cols = [
                {"data": "ID"}/*0*/,
                {"data": "CODIGO"}/*1*/,
                {"data": "DESCRIPCION"}/*2*/,
                {"data": "DESCRIPCIONREF"}/*3*/,
                {"data": "HORALLEGADA"}/*4*/,
                {"data": "HORAENTRADA"}/*5*/,
                {"data": "REFACCION_UNO"}/*6*/,
                {"data": "CANTIDAD_UNO"}/*7*/,
                {"data": "PRECIO_UNO"}/*8*/,
                {"data": "REFACCION_DOS"}/*9*/,
                {"data": "CANTIDAD_DOS"}/*10*/,
                {"data": "PRECIO_DOS"}/*11*/
            ];
            var coldefs = [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ];
            Solicitudes = tblSolicitudesMto.DataTable({
                "dom": 'rtp',
                "ajax": {
                    "url": '<?php print base_url('SolicitudDeMantenimiento/getSolicitudes'); ?>',
                    "dataSrc": "",
                    "data": function (d) {
                        d.VALE = 1;
                    }
                },
                buttons: buttons,
                "columns": cols,
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
                    [1, 'desc']
                ]
            });
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
</style>