<div id="mdlNuevoModulo" class="modal">
    <div class="modal-dialog modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-puzzle-piece"></span> Nuevo módulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 d-none">
                        <input type="text" id="IDGM" name="IDGM" class="form-control d-none" readonly="">
                    </div>
                    <div class="col-12">
                        <label>Nombre</label>
                        <input type="text" id="NombreModulo" name="NombreModulo" class="form-control form-control-sm notUpperCase">
                    </div>
                    <div class="col-6">
                        <label>Icono</label>
                        <input type="text" id="NombreIcono" name="NombreIcono" class="form-control form-control-sm notUpperCase">                            
                    </div> 
                    <div class="col-6">
                        <label>Orden</label>
                        <input type="text" id="Orden" name="Orden" class="form-control form-control-sm numbersOnly " maxlength="2">
                    </div>
                    <div class="col-12">
                        <label>Referencia</label>
                        <input type="text" id="ReferenciaModulo" name="ReferenciaModulo" class="form-control form-control-sm notUpperCase">
                    </div>
                    <div class="col-12 my-2" align="right">
                        <button type="button" class="btn btn-info" id="btnGuardarModulo"><span class="fa fa-save"></span> Guardar</button> 
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 mt-1">
                        <div id="Modulos" class="table-responsive">
                            <table id="tblModulos" class="table table-sm display nowrap " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Modulo</th> 
                                        <th>Fecha</th>
                                        <th>Icon</th>
                                        <th>Ref</th>
                                        <th>Order</th> 
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>

<div id="mdlNuevaOpcionXModulo" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered  notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-puzzle-piece"></span> Nueva opción por módulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 d-none">
                        <input type="text" id="IDGMXO" name="IDGMXO" class="form-control d-none" readonly="">
                    </div>
                    <div class="col-12">
                        <label>Modulo</label>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" id="xModuloXOpcion" name="xModuloXOpcion" maxlength="2" class="form-control form-control-sm numbersOnly">
                            </div>
                            <div class="col-8">
                                <select id="ModuloXOpcion" name="ModuloXOpcion" class="form-control form-control-sm">
                                </select> 
                            </div>
                        </div> 
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-12">
                        <label>Nombre</label>
                        <input type="text" id="NombreOpcion" name="NombreOpcion" class="form-control form-control-sm notUpperCase">
                    </div>
                    <div class="col-6">
                        <label>Icono</label>
                        <input type="text" id="NombreIconoOpcion" name="NombreIconoOpcion" class="form-control form-control-sm notUpperCase">                            
                    </div>
                    <div class="col-6 vista_previa justify-content-center text-center"> 
                    </div>
                    <div class="col-6">
                        <label>Orden</label>
                        <input type="text" id="OrdenOpcion" name="OrdenOpcion" class="form-control form-control-sm numbersOnly" maxlength="99">
                    </div>
                    <div class="col-12">
                        <label>Referencia</label>
                        <input type="text" id="ReferenciaOpcion" name="ReferenciaOpcion" class="form-control form-control-sm notUpperCase">
                    </div>
                    <div class="col-4 mt-3"> 
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="EsBoton" name="EsBoton">
                            <label class="custom-control-label" for="EsBoton" >Es Boton</label>
                        </div> 
                    </div>
                    <div class="col-8">
                        <label>Clase(css)</label>
                        <input type="text" id="ClaseCss" name="ClaseCss" placeholder="info,warning, success..." class="form-control form-control-sm notUpperCase" maxlength="999">
                    </div>
                    <div class="w-100 my-1"></div>
                    <div class="col-6 order-11" align="right">
                        <button type="button" class="btn btn-info" id="btnGuardarOpcionxModulo"><span class="fa fa-save"></span> Guardar</button> 
                        <button type="button" class="btn btn-danger" id="btnCancelarOpcionxModulo"><span class="fa fa-ban"></span> Cancelar</button> 
                    </div>
                    <div class="col-6 order-10" align="left">
                        <button type="button" class="btn btn-danger btn-sm" onclick="onEliminarOpcionXModuloByID()">
                            <span class="fa fa-trash"></span>
                        </button>
                    </div>
                    <div class="w-100 my-1"></div>
                    <div class="col-12 order-12 mt-1">
                        <div id="Opciones" class="table-responsive">
                            <table id="tblOpciones" class="table table-sm display nowrap " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Modulo</th>
                                        <th>Opción</th>
                                        <th>Fecha</th>
                                        <th>Icon</th>
                                        <th>Ref</th>
                                        <th>Order</th>
                                        <th>Button</th>
                                        <th>Class</th> 
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<script>
    var mdlNuevoModulo = $("#mdlNuevoModulo"), modulo_nuevo = $("#modulo_nuevo"),
            btnGuardarModulo = mdlNuevoModulo.find("#btnGuardarModulo"),
            NombreModulo = mdlNuevoModulo.find("#NombreModulo"),
            NombreIcono = mdlNuevoModulo.find("#NombreIcono"),
            Orden = mdlNuevoModulo.find("#Orden"),
            ReferenciaModulo = mdlNuevoModulo.find("#ReferenciaModulo");

    var tblModulos = mdlNuevoModulo.find("#tblModulos"), Modulos;

    var mdlNuevaOpcionXModulo = $("#mdlNuevaOpcionXModulo"), opciones_nuevo = $("#opciones_nuevo"),
            btnGuardarOpcionxModulo = mdlNuevaOpcionXModulo.find("#btnGuardarOpcionxModulo"),
            NombreOpcion = mdlNuevaOpcionXModulo.find("#NombreOpcion"),
            NombreIconoOpcion = mdlNuevaOpcionXModulo.find("#NombreIconoOpcion"),
            OrdenOpcion = mdlNuevaOpcionXModulo.find("#OrdenOpcion"),
            ReferenciaOpcion = mdlNuevaOpcionXModulo.find("#ReferenciaOpcion"),
            EsBoton = mdlNuevaOpcionXModulo.find("#EsBoton"),
            ClaseCss = mdlNuevaOpcionXModulo.find("#ClaseCss"),
            xModuloXOpcion = mdlNuevaOpcionXModulo.find("#xModuloXOpcion"),
            ModuloXOpcion = mdlNuevaOpcionXModulo.find("#ModuloXOpcion"),
            btnCancelarOpcionxModulo = mdlNuevaOpcionXModulo.find("#btnCancelarOpcionxModulo");

    var tblOpciones = mdlNuevaOpcionXModulo.find("#tblOpciones"), OpcionesXModulo;
    var nuevo = true;

    $(document).ready(function () {
        handleEnterDiv(mdlNuevoModulo);
        handleEnterDiv(mdlNuevaOpcionXModulo);
        /*OPCION*/

        btnCancelarOpcionxModulo.click(function () {
            onClearPanelInputSelect(mdlNuevaOpcionXModulo, function () {
                OpcionesXModulo.ajax.reload();
                xModuloXOpcion.focus().select();
                nuevo = true;
                rgistro = {};
            });
        });

        NombreOpcion.on('keydown', function (e) {
            if (e.keyCode === 13 || e.keyCode === 9) {
                onEnable(ModuloXOpcion);
            }
        });

        ModuloXOpcion.change(function () {
            onOpenOverlay('');
            if (ModuloXOpcion.val()) {
                xModuloXOpcion.val(ModuloXOpcion.val());
                NombreOpcion.focus().select();
            } else {
                xModuloXOpcion.val('');
                ModuloXOpcion[0].selectize.enable();
                ModuloXOpcion[0].selectize.clear(true);
            }
            $.getJSON('<?php print base_url('ResourceManager/getUltimoOrdenOXM') ?>', {MODULO: ModuloXOpcion.val()}).done(function (a) {
                if (a.length > 0) {
                    OrdenOpcion.val(a[0].ULTIMO_ORDEN);
                }
            }).fail(function (x) {
                getError(x);
            }).always(function () {
                onCloseOverlay();
                OpcionesXModulo.ajax.reload();
            });
        });

        xModuloXOpcion.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xModuloXOpcion.val()) {
                    ModuloXOpcion[0].selectize.setValue(xModuloXOpcion.val());
                    if (ModuloXOpcion.val()) {
                        onDisable(ModuloXOpcion);
                    } else {
                        onCampoInvalido(mdlNuevaOpcionXModulo, 'NO EXISTE ESTE MODULO, ESPECIFIQUE OTRO', function () {
                            xModuloXOpcion.focus().select();
                        });
                        return;
                    }
                } else {
                    ModuloXOpcion[0].selectize.enable();
                    ModuloXOpcion[0].selectize.clear(true);
                }
            } else {
                ModuloXOpcion[0].selectize.enable();
                ModuloXOpcion[0].selectize.clear(true);
            }
        });
        NombreIconoOpcion.change(function () {
            if ($(this).val()) {
                mdlNuevaOpcionXModulo.find(".vista_previa").html('<div class="mt-2"></div><span class="' + $(this).val() + ' fa-2x mt-2"></span>');
            }
        });

        btnGuardarOpcionxModulo.click(function () {
            onEnable(ModuloXOpcion);
            onOpenOverlay('');
            var p = {
                ID: mdlNuevaOpcionXModulo.find("#IDGMXO").val(),
                NUEVO: nuevo ? 1 : 0,
                MODULO: ModuloXOpcion.val(), NOMBRE_OPCION: NombreOpcion.val(),
                ICONO_OPCION: NombreIconoOpcion.val(), REFERENCIA_OPCION: ReferenciaOpcion.val(),
                ORDEN_OPCION: OrdenOpcion.val(), BOTON: mdlNuevaOpcionXModulo.find("#EsBoton")[0].checked ? 1 : 0,
                CLASECSS: mdlNuevaOpcionXModulo.find("#ClaseCss").val()
            };
            if (!ModuloXOpcion.val()) {
                onCampoInvalido(mdlNuevaOpcionXModulo, "ES NECESARIO ESPECIFICAR UN MODULO", function () {
                    xModuloXOpcion.focus().select();
                    onCloseOverlay();
                });
                return;
            }
            if (!NombreOpcion.val()) {
                onCampoInvalido(mdlNuevaOpcionXModulo, "ES NECESARIO ESPECIFICAR UN NOMBRE", function () {
                    NombreOpcion.focus().select();
                    onCloseOverlay();
                });
                return;
            }
            if (!NombreIconoOpcion.val()) {
                onCampoInvalido(mdlNuevaOpcionXModulo, "ES NECESARIO ESPECIFICAR UN ICONO", function () {
                    NombreIconoOpcion.focus().select();
                    onCloseOverlay();
                });
                return;
            }
            if (!ReferenciaOpcion.val()) {
                onCampoInvalido(mdlNuevaOpcionXModulo, "ES NECESARIO ESPECIFICAR UNA REFERENCIA", function () {
                    ReferenciaOpcion.focus().select();
                    onCloseOverlay();
                });
                return;
            }
            if (!OrdenOpcion.val()) {
                onCampoInvalido(mdlNuevaOpcionXModulo, "ES NECESARIO ESPECIFICAR UN ORDEN", function () {
                    OrdenOpcion.focus().select();
                    onCloseOverlay();
                });
                return;
            }
            if (!ClaseCss.val()) {
                onCampoInvalido(mdlNuevaOpcionXModulo, "ES NECESARIO ESPECIFICAR UNA CLASE CSS", function () {
                    ClaseCss.focus().select();
                    onCloseOverlay();
                });
                return;
            }

            $.post('<?php print base_url('ResourceManager/onGuardarOpcionXModulo'); ?>', p).done(function (a) {
                console.log(a);
                var r = JSON.parse(a);
                console.log(r);
                nuevo = true;
                iMsg("OPCION POR MODULO GUARDADA", "s", function () {
                    onClearPanelInputSelect(mdlNuevaOpcionXModulo, function () {
                        xModuloXOpcion.focus().select();
                    });
                });
            }).fail(function (x, y, z) {
                onError(x);
            }).always(function () {
                onCloseOverlay();
            });
        });

        opciones_nuevo.click(function () {
            mdlNuevaOpcionXModulo.modal('show');
        });

        mdlNuevaOpcionXModulo.on('shown.bs.modal', function () {
            nuevo = true;
            getModulosX();
            getOpcionesXModulos();
            mdlNuevaOpcionXModulo.find("#xModuloXOpcion").focus().select();
        });

        mdlNuevaOpcionXModulo.on('hidden.bs.modal', function () {
            mdlNuevaOpcionXModulo.find("input").val('');
        });


        /*MODULO*/
        NombreIcono.change(function () {
            if ($(this).val()) {
                mdlNuevoModulo.find(".vista_previa").html('<div class="mt-2"></div><span class="' + $(this).val() + ' fa-2x mt-2"></span>');
            }
        });

        btnGuardarModulo.click(function () {
            if (NombreModulo.val() && NombreIcono.val() && Orden.val() && ReferenciaModulo.val()) {
                onOpenOverlay('');
                var p = {
                    ID: mdlNuevoModulo.find("#IDGM").val(),
                    NUEVO: nuevo ? 1 : 0,
                    MODULO: NombreModulo.val(), ICONO: NombreIcono.val(),
                    REFERENCIA: ReferenciaModulo.val(), ORDEN: Orden.val()
                };
                $.post('<?php print base_url('ResourceManager/onGuardarModulo'); ?>', p).done(function (a) {
                    console.log(a);
                    nuevo = true;
                    iMsg("MODULO GUARDADO", "s", function () {
                        onClearPanelInputSelect(mdlNuevoModulo, function () {
                            NombreModulo.focus().select();
                            getModulosGenerales();
                        });
                    });
                }).fail(function (x, y, z) {
                    onError(x);
                }).always(function () {
                    onCloseOverlay();
                });
            } else {
                onCampoInvalido(mdlNuevoModulo, "ES NECESARIO ESPECIFICAR TODO LOS PARAMETROS", function () {
                    if (!NombreModulo.val()) {
                        NombreModulo.focus().select();
                    } else if (!NombreIcono.val()) {
                        NombreIcono.focus().select();
                    } else if (!Orden.val()) {
                        Orden.focus().select();
                    } else if (!ReferenciaModulo.val()) {
                        ReferenciaModulo.focus().select();
                    }
                });
            }
        });

        modulo_nuevo.click(function () {
            mdlNuevoModulo.modal('show');
        });

        mdlNuevoModulo.on('shown.bs.modal', function () {
            nuevo = true;
            mdlNuevoModulo.find("#NombreModulo").focus().select();
            getModulosGenerales();
        });

        mdlNuevoModulo.on('hidden.bs.modal', function () {
            mdlNuevoModulo.find("input").val('');
        });
    });


    function getModulosGenerales() {
        if ($.fn.DataTable.isDataTable('#tblModulos')) {
            Modulos.ajax.reload();
            return;
        }
        Modulos = tblModulos.DataTable({
            dom: 'frtip', "ajax": {
                "url": '<?php print base_url('ResourceManager/getModulosGenerales'); ?>',
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"},
                {"data": "MODULO"},
                {"data": "FECHA"}, {"data": "ICONO"},
                {"data": "REF"}, {"data": "ORDEN"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 25,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": 250,
            "scrollX": true,
            responsive: false,
            "aaSorting": [
                [0, 'desc']/*ID*/
            ],
            initComplete: function () {
            }
        });

        tblModulos.on('click', 'tr', function () {
            nuevo = false;
            var xxx = Modulos.row($(this)).data();
            mdlNuevoModulo.find("#IDGM").val(xxx.ID);
            NombreModulo.val(xxx.MODULO);
            NombreIcono.val(xxx.ICONO);
            Orden.val(xxx.ORDEN);
            ReferenciaModulo.val(xxx.REF);
        });
    }
    function getOpcionesXModulos() {
        if ($.fn.DataTable.isDataTable('#tblOpciones')) {
            OpcionesXModulo.ajax.reload();
            return;
        }
        OpcionesXModulo = tblOpciones.DataTable({
            dom: 'frtip', "ajax": {
                "url": '<?php print base_url('ResourceManager/getOpcionesXModulos'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.MODULO = ModuloXOpcion.val() ? ModuloXOpcion.val() : '';
                }
            },
            "columns": [
                {"data": "ID"},
                {"data": "MODULO"}, {"data": "OPCION"},
                {"data": "FECHA"}, {"data": "ICONO"},
                {"data": "REF"}, {"data": "ORDEN"},
                {"data": "BOTON"}, {"data": "CLASE"}
            ],
            "columnDefs": [
                //ID
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": 300,
            "scrollX": true,
            responsive: false,
            "aaSorting": [
                [0, 'desc']/*ID*/
            ],
            initComplete: function () {
            }
        });

        tblOpciones.on('click', 'tr', function () {
            nuevo = false;
            var xxx = OpcionesXModulo.row($(this)).data();
            rgistro = xxx;
            mdlNuevaOpcionXModulo.find("#IDGMXO").val(xxx.ID);
            xModuloXOpcion.val(xxx.MODULO_ID);
            ModuloXOpcion[0].selectize.setValue(xxx.MODULO_ID);
            NombreOpcion.val(xxx.OPCION);
            NombreIconoOpcion.val(xxx.ICONO);
            ReferenciaOpcion.val(xxx.REF);
            OrdenOpcion.val(xxx.ORDEN);
            EsBoton[0].checked = parseInt(xxx.BOTON) === 0 ? false : true;
            ClaseCss.val(xxx.CLASE);
        });
    }

    function getModulosX() {
        $.getJSON('<?php print base_url('ResourceManager/getModulosX'); ?>').done(function (a) {
            onClearSelect(ModuloXOpcion);
            $.each(a, function (k, v) {
                ModuloXOpcion[0].selectize.addOption({text: v.Modulo, value: v.ID});
            });
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }

    var rgistro = {};
    function onEliminarOpcionXModuloByID() {
        console.log(rgistro, rgistro.length === undefined);
        if (rgistro.length !== undefined) {
            $.post('<?php print base_url('ResourceManager/onEliminarOpcionXModuloByID'); ?>',
                    {ID: rgistro.ID}).done(function (a) {
                onNotifyOldPCF('<span class="fa fa-check"></span>',
                        'SE HA ELIMINADO LA OPCIÓN',
                        'success', {from: "bottom", align: "center"}, function () {
                            rgistro = {};
                            xModuloXOpcion.focus().select();
                });
            }).fail(function (x) {
                getError(x);
            }).always(function () {

            });
        }
    }
</script>