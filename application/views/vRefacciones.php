<div class="modal fade" id="mdlRefacciones" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"  
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
                            <div class="col-12 d-none">
                                <input type="text" id="IDR" name="IDR" class="form-control" readonly="">
                            </div>
                            <div class="col-12">
                                <label>Código</label>
                                <input type="text" id="CodigoRefaccion" name="CodigoRefaccion" readonly="" class="form-control d-none" maxlength="15">
                                <p id="xCodigoRefaccion" class="font-weight-bold text-center font-italic" style="color: #3F51B5 !important; font-size: 38px;">-</p>
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
                                <input type="text" id="CostoRefaccion" name="CostoRefaccion" class="form-control numbersOnly">
                            </div>
                            <div class="w-100"></div>

                            <div class="col-12">
                                <label>Departamento</label>
                                <div class="row">
                                    <div class="col-4 col-xs-4 col-sm-4">
                                        <input type="text" id="DeptoClaveMaquinaRefacciones" name="DeptoClaveMaquinaRefacciones" class="form-control" maxlength="3">
                                    </div>
                                    <div class="col-8 col-xs-8 col-sm-8"> 
                                        <select id="DeptoMaquinaRefacciones" name="DeptoMaquinaRefacciones" class="form-control form-control-sm">
                                            <option></option>                                   
                                            <?php
                                            $departamentos = $this->db->query("SELECT Clave, Descripcion FROM departamentos ORDER BY Descripcion ASC;")->result();
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
                            <div class="col-12 font-weight-bold text-center">
                                <div class="row">
                                    <div class="col-10">
                                        <h3>Fotos</h3> 
                                    </div>
                                    <div class="col-2">
                                        <button id="btnSubirFotosRefacciones" type="button" class="btn btn-success" style="background-color: #673AB7; border-color: #673AB7;"><span class="fa fa-upload"></span></button> 
                                        <input type="file" id="FotosRefacciones" name="FotosRefacciones[]" class="d-none" style="display: none;" multiple=""> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <a href="<?php print base_url('img/camera.png'); ?>" data-fancybox>
                                    <img src="<?php print base_url('img/camera.png'); ?>" width="100%" class="img-fluid imagen_principal" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);" style="cursor: pointer;">
                                </a>   
                            </div> 
                            <div id="Contenedor" class="col-12">
                                <div class="row"></div>
                            </div>
                        </div>
                    </div> 
                    <div class="row d-none">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                            <table id="tblRefaccionesMto" class="table  table-sm table-bordered" style="width:  100%;">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th> 
                                        <th scope="col">CÓDIGO</th> 
                                        <th scope="col">DESCRIPCIÓN</th>   

                                        <th scope="col">FECHA ALTA</th> 
                                        <th scope="col">COSTO</th> 
                                        <th scope="col">DEPARTAMENTO</th>  
                                        <th scope="col">PROVEEDOR UNO</th>  
                                        <th scope="col">PROVEEDOR DOS</th>  
                                        <th scope="col">PROVEEDOR TRES</th>  
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-6">
                    <div align="left">
                        <button type="button" class="btn btn-success" style="background-color: #0D47A1; border-color: #0D47A1;">Ver Refacciones</button> 
                    </div>
                </div>
                <div class="col-6">
                    <div align="right">
                        <button type="button" class="btn btn-secondary" id="btnGuardarRefaccion" style="background-color: #000000; border-color: #000000;">
                            <span class="fa fa-save"></span> Guardar
                        </button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlRefacciones = $("#mdlRefacciones"),
            CodigoRefaccion = mdlRefacciones.find("#CodigoRefaccion"),
            DeptoMaquinaRefacciones = mdlRefacciones.find("#DeptoMaquinaRefacciones"),
            DeptoClaveMaquinaRefacciones = mdlRefacciones.find("#DeptoClaveMaquinaRefacciones"),
            btnSubirFotosRefacciones = mdlRefacciones.find("#btnSubirFotosRefacciones"),
            tblRefaccionesMto = mdlRefacciones.find("#tblRefaccionesMto"), RefaccionesMto;

    $(document).ready(function () {

        DeptoMaquinaRefacciones.change(function () {
            console.log(DeptoMaquinaRefacciones.val());
            if (DeptoMaquinaRefacciones.val()) {
                DeptoClaveMaquinaRefacciones.val(DeptoMaquinaRefacciones.val());
            }
        });

        mdlRefacciones.on('shown.bs.modal', function () {
            mdlRefacciones.find("input").val('');
            mdlRefacciones.find("#Contenedor div.row").html('');
            getUltimoCodigo();
            return;
            if ($.fn.DataTable.isDataTable('#tblRefaccionesMto')) {
                RefaccionesMto.ajax.reload(function () {
                    CodigoRefaccion.focus().select();
                });
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
        });

        mdlRefacciones.on('hidden.bs.modal', function () {
            mdlRefacciones.find("#Contenedor div.row").html('');
            mdlRefacciones.find("img.imagen_principal")[0].src = '<?php print base_url('img/camera.png'); ?>';
            mdlRefacciones.find("img.imagen_principal").parent("a")[0].href = '<?php print base_url('img/camera.png'); ?>';
        });

        mdlRefacciones.find("#FotosRefacciones").change(function () {
            onOpenOverlay('Cargando fotos...');
            var io = 0;
            Array.from(mdlRefacciones.find("#FotosRefacciones")[0].files).forEach(f => {
                const r = new FileReader();
                r.addEventListener("load", function () {
                    mdlRefacciones.find("#Contenedor div.row").append('<div class="col-2 text-center card-image-generated"><button class="btn btn-danger mb-1" onclick="onEliminarFoto(this)"><span class="fa fa-trash"></span></button><a href="' + r.result + '" data-fancybox="images"><img src="' + r.result + '" class="img-fluid imagen_generada' + io + '" onclick="onPrevisualizaImage(this)" style="cursor:pointer;" /></a></div>');
                }, false);
                if (f) {
                    r.readAsDataURL(f);
                }
                io += 1;
            });
            onCloseOverlay();
        });

        btnSubirFotosRefacciones.click(function () {
            mdlRefacciones.find("#FotosRefacciones").trigger('click');
        });
    });

    function getUltimoCodigo() {
        $.getJSON('<?php print base_url('Refacciones/getUltimoCodigo'); ?>').done(function (a) {
            if (a.length > 0) {
                CodigoRefaccion.val(a[0].CODIGO);
                mdlRefacciones.find("p#xCodigoRefaccion").text(a[0].CODIGO);
            }
        });
    }


    function onImagenOut(e) {
        $(e)[0].src = '<?php print base_url('img/camera.png'); ?>';
    }

    function onImagenOver(e) {
        $(e)[0].src = '<?php print base_url('img/camera_hover.png'); ?>';
    }

    /*DRAG AND DROP*/

    function dragOverHandler(ev) {
        console.log('File(s) in drop zone');
        // Prevent default behavior (Prevent file from being opened)
        ev.preventDefault();
    }

    function dropHandler(ev) {
        var io = 1;
        onOpenOverlay('Cargando fotos...');
        console.log('File(s) dropped');
        // Prevent default behavior (Prevent file from being opened)
        ev.preventDefault();
        if (ev.dataTransfer.items) {
            // Use DataTransferItemList interface to access the file(s)
            for (var i = 0; i < ev.dataTransfer.items.length; i++) {
                // If dropped items aren't files, reject them
                if (ev.dataTransfer.items[i].kind === 'file') {
                    var f = ev.dataTransfer.items[i].getAsFile();
                    console.log('... file[' + i + '].name = ' + f.name);
                    const r = new FileReader();
                    r.addEventListener("load", function () {
                        mdlRefacciones.find("#Contenedor div.row").append('<div class="col-2 text-center card-image-generated"><button class="btn btn-danger mb-1" onclick="onEliminarFoto(this)"><span class="fa fa-trash"></span></button><a href="' + r.result + '" data-fancybox="images"><img src="' + r.result + '" class="img-fluid imagen_generada' + io + '" onclick="onPrevisualizaImage(this)" style="cursor:pointer;" /></a></div>');
                    }, false);
                    if (f) {
                        r.readAsDataURL(f);
                    }
                }
            }
            onCloseOverlay();
        } else {
            // Use DataTransfer interface to access the file(s)
            for (var i = 0; i < ev.dataTransfer.files.length; i++) {
                console.log('... file[' + i + '].name = ' + ev.dataTransfer.files[i].name);
            }
        }
        // Pass event to removeDragData for cleanup
        removeDragData(ev);
    }

    function removeDragData(ev) {
        console.log('Removing drag data');
        if (ev.dataTransfer.items) {
            // Use DataTransferItemList interface to remove the drag data
            ev.dataTransfer.items.clear();
        } else {
            // Use DataTransfer interface to remove the drag data
            ev.dataTransfer.clearData();
        }
    }

    function onEliminarFoto(e) {
        onOpenOverlay('Eliminando foto...');
        $(e).parent().remove();
        onCloseOverlay();
    }

    function onPrevisualizaImage(imgn) {
        onOpenOverlay('Cargando foto...');
        mdlRefacciones.find("img.imagen_principal")[0].src = $(imgn)[0].src;
        mdlRefacciones.find("img.imagen_principal").parent("a")[0].href = $(imgn)[0].src;
        onCloseOverlay();
    }
</script>
<style>
    .resize-imagen{
        cursor: pointer;
        height: 60px; 
        min-width: 60px;
    } 
</style>