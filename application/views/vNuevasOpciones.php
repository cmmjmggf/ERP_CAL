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
                    <div class="col-6 my-2 order-11" align="right">
                        <button type="button" class="btn btn-info" id="btnGuardarModulo"><span class="fa fa-save"></span> Guardar</button> 
                    </div>
                    <div class="col-6 my-2 order-10" align="left">
                        <button type="button" class="btn btn-danger" id="btnEliminarModulo"><span class="fa fa-trash"></span> Eliminar</button> 
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 mt-1 order-12">
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

<div id="mdlNuevoItemXOpcion" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered  notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-puzzle-piece"></span> Nuevo item por opción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 d-none">
                        <input type="text" id="IDITEM" name="IDITEM" class="form-control d-none" readonly="">
                    </div>
                    <div class="col-12">
                        <label>Modulo</label>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" id="xModuloXOpcionXItem" name="xModuloXOpcionXItem" maxlength="2" class="form-control form-control-sm numbersOnly">
                            </div>
                            <div class="col-8">
                                <select id="ModuloXOpcionXItem" name="ModuloXOpcionXItem" class="form-control form-control-sm">
                                </select> 
                            </div>
                        </div> 
                    </div>
                    <div class="col-12">
                        <label>Opción</label>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" id="xOpcionesXItem" name="xOpcionesXItem" autofocus="" maxlength="2" class="form-control form-control-sm numbersOnly">
                            </div>
                            <div class="col-8">
                                <select id="OpcionesXItem" name="OpcionesXItem" class="form-control form-control-sm">
                                    <option value=''></option>       
                                </select> 
                            </div>
                        </div> 
                    </div>
                    <div class="col-12">
                        <label>Nombre</label>
                        <input type="text" id="NombreItem" name="NombreItem" class="form-control form-control-sm notUpperCase">
                    </div>
                    <div class="col-4">
                        <label>Icono</label>
                        <input type="text" id="NombreIconoItem" name="NombreIconoItem" class="form-control form-control-sm notUpperCase">                            
                    </div>
                    <div class="col-4 vista_previa justify-content-center text-center d-none"> 
                    </div>
                    <div class="col-2">
                        <label>Orden</label>
                        <input type="text" id="OrdenItem" name="OrdenItem" class="form-control form-control-sm numbersOnly" maxlength="99">
                    </div>
                    <div class="col-6">
                        <label>Referencia</label>
                        <input type="text" id="ReferenciaItem" name="ReferenciaItem" class="form-control form-control-sm notUpperCase">
                    </div>
                    <div class="w-100 mt-2"></div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="center">
                        <div class="form-group">
                            <span class="switch switch-lg">
                                <input id="EsModal" name="EsModal"  type="checkbox" class="switch">
                                <label for="EsModal">MODAL</label>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="center">
                        <div class="form-group">
                            <span class="switch switch-lg">
                                <input id="TieneBackdrop" name="TieneBackdrop"  type="checkbox" class="switch">
                                <label for="TieneBackdrop">BACKDROP</label>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="center">
                        <div class="form-group">
                            <span class="switch switch-lg">
                                <input id="EsDropdown" name="EsDropdown"  type="checkbox" class="switch">
                                <label for="EsDropdown">DROPDOWN</label>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="center">
                        <div class="form-group">
                            <span class="switch switch-lg">
                                <input id="EsFuncion" name="EsFuncion"  type="checkbox" class="switch">
                                <label for="EsFuncion">FUNCIÓN</label>
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label>Trigger</label>
                        <input type="text" maxlength="100" class="form-control form-control-sm notUpperCase" id="FuncionEjecutable" name="FuncionEjecutable">
                    </div>
                    <div class="w-100 my-1"></div>
                    <div class="col-6 order-11" align="right">
                        <button type="button" class="btn btn-info" id="btnGuardarItemXOpcionxModulo"><span class="fa fa-save"></span> Guardar</button> 
                        <button type="button" class="btn btn-danger" id="btnCancelarItemXOpcionxModulo"><span class="fa fa-ban"></span> Cancelar</button> 
                    </div>
                    <div class="col-6 order-10" align="left">
                        <button type="button" class="btn btn-danger btn-sm" onclick="onEliminarItemXOpcionXModuloByID()">
                            <span class="fa fa-trash"></span>
                        </button>
                    </div>
                    <div class="w-100 my-1"></div>
                    <div class="col-12 order-12 mt-1">
                        <div id="Items" class="table-responsive">
                            <table id="tblItems" class="table table-sm display nowrap table-striped " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th> 
                                        <th>Módulo</th>
                                        <th>Opción</th>
                                        <th>Item</th>
                                        <th>Fecha</th>
                                        <th>Icon</th>

                                        <th>Ref</th>
                                        <th>Modal</th>
                                        <th>Backdrop</th>
                                        <th>Dropdown</th>
                                        <th>Order</th>

                                        <th>Function</th>
                                        <th>Trigger</th> 
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
            btnEliminarModulo = mdlNuevoModulo.find("#btnEliminarModulo"),
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

    var mdlNuevoItemXOpcion = $("#mdlNuevoItemXOpcion"), items_nuevo = $("#items_nuevo"),
            xModuloXOpcionXItem = mdlNuevoItemXOpcion.find("#xModuloXOpcionXItem"),
            ModuloXOpcionXItem = mdlNuevoItemXOpcion.find("#ModuloXOpcionXItem"),
            xOpcionesXItem = mdlNuevoItemXOpcion.find("#xOpcionesXItem"),
            OpcionesXItem = mdlNuevoItemXOpcion.find("#OpcionesXItem"),
            NombreItem = mdlNuevoItemXOpcion.find("#NombreItem"),
            NombreIconoItem = mdlNuevoItemXOpcion.find("#NombreIconoItem"),
            OrdenItem = mdlNuevoItemXOpcion.find("#OrdenItem"),
            ReferenciaItem = mdlNuevoItemXOpcion.find("#ReferenciaItem"),
            EsModal = mdlNuevoItemXOpcion.find("#EsModal"),
            TieneBackdrop = mdlNuevoItemXOpcion.find("#TieneBackdrop"),
            EsDropdown = mdlNuevoItemXOpcion.find("#EsDropdown"),
            EsFuncion = mdlNuevoItemXOpcion.find("#EsFuncion"),
            FuncionEjecutable = mdlNuevoItemXOpcion.find("#FuncionEjecutable"),
            btnGuardarItemXOpcionxModulo = mdlNuevoItemXOpcion.find("#btnGuardarItemXOpcionxModulo"),
            btnCancelarItemXOpcionxModulo = mdlNuevoItemXOpcion.find("#btnCancelarItemXOpcionxModulo");

    var tblItems = mdlNuevoItemXOpcion.find("#tblItems"), ItemsXOpcionesXModulo;

    var nuevo = true;

    $(document).ready(function () {
        handleEnterDiv(mdlNuevoModulo);
        handleEnterDiv(mdlNuevaOpcionXModulo);
        handleEnterDiv(mdlNuevoItemXOpcion);

        /*ITEM*/


        OpcionesXItem.change(function () {
            onOpenOverlay('');
            if (OpcionesXItem.val()) {
                console.log(OpcionesXItem.val());
                xOpcionesXItem.val(OpcionesXItem.val());
                NombreItem.focus().select();
            } else {
                xOpcionesXItem.val('');
                OpcionesXItem[0].selectize.enable();
                OpcionesXItem[0].selectize.clear(true);
            }
            $.getJSON('<?php print base_url('ResourceManager/getUltimoOrdenIXOXM') ?>',
                    {MODULO: ModuloXOpcionXItem.val() ? ModuloXOpcionXItem.val() : '',
                        OPCION: OpcionesXItem.val() ? OpcionesXItem.val() : ''}).done(function (a) {
                if (a.length > 0) {
                    OrdenItem.val(a[0].ULTIMO_ORDEN);
                }
            }).fail(function (x) {
                getError(x);
            }).always(function () {
                onCloseOverlay();
                getItemsXOpcionesXModulos();
            });
        });

        xOpcionesXItem.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xOpcionesXItem.val()) {
                    OpcionesXItem[0].selectize.setValue(xOpcionesXItem.val());
                    if (OpcionesXItem.val()) {
                    } else {
                        onCampoInvalido(mdlNuevoItemXOpcion, 'NO EXISTE ESTA OPCIÓN, ESPECIFIQUE OTRA', function () {
                            xOpcionesXItem.focus().select();
                        });
                        return;
                    }
                } else {
                    OpcionesXItem[0].selectize.enable();
                    OpcionesXItem[0].selectize.clear(true);
                }
            } else {
                OpcionesXItem[0].selectize.enable();
                OpcionesXItem[0].selectize.clear(true);
            }
        });

        ModuloXOpcionXItem.change(function () {
            onOpenOverlay('');
            if (ModuloXOpcionXItem.val()) {
                xModuloXOpcionXItem.val(ModuloXOpcionXItem.val());
                onClear(xOpcionesXItem);
                onClear(OpcionesXItem);
                xOpcionesXItem.focus().select();
            } else {
                xModuloXOpcionXItem.val('');
                ModuloXOpcionXItem[0].selectize.enable();
                ModuloXOpcionXItem[0].selectize.clear(true);
            }
            getItemsXOpcionesXModulos();
            onCloseOverlay();
        });

        xModuloXOpcionXItem.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xModuloXOpcionXItem.val()) {
                    ModuloXOpcionXItem[0].selectize.setValue(xModuloXOpcionXItem.val());
                    if (ModuloXOpcionXItem.val()) {
                        getOpcionesXModuloX(OpcionesXItem, ModuloXOpcionXItem);
                    } else {
                        onCampoInvalido(mdlNuevoItemXOpcion, 'NO EXISTE ESTE MODULO, ESPECIFIQUE OTRO', function () {
                            xModuloXOpcionXItem.focus().select();
                        });
                        return;
                    }
                } else {
                    ModuloXOpcionXItem[0].selectize.enable();
                    ModuloXOpcionXItem[0].selectize.clear(true);
                }
            } else {
                ModuloXOpcionXItem[0].selectize.enable();
                ModuloXOpcionXItem[0].selectize.clear(true);
            }
        });

        mdlNuevoItemXOpcion.on('shown.bs.modal', function () {
            nuevo = true;
            getModulosX(ModuloXOpcionXItem);
            xModuloXOpcionXItem.focus().select();
            getItemsXOpcionesXModulos();
        });

        mdlNuevoItemXOpcion.on('hidden.bs.modal', function () {
            onClearPanelInputSelectEnableDisable(mdlNuevoItemXOpcion, function () {});
        });

        items_nuevo.click(function () {
            mdlNuevoItemXOpcion.modal('show');
        });

        btnCancelarItemXOpcionxModulo.click(function () {
            onClearPanelInputSelect(mdlNuevoItemXOpcion, function () {
                getItemsXOpcionesXModulos();
                xOpcionesXItem.focus().select();
                nuevo = true;
                rgistro = {};
            });
        });


        btnGuardarItemXOpcionxModulo.click(function () {
            onEnable(ModuloXOpcion);
            onOpenOverlay('');
            var p = {
                ID: mdlNuevoItemXOpcion.find("#IDGMXO").val(),
                NUEVO: nuevo ? 1 : 0,
                MODULO: ModuloXOpcion.val(), NOMBRE_OPCION: NombreOpcion.val(),
                ICONO_OPCION: NombreIconoOpcion.val(), REFERENCIA_OPCION: ReferenciaOpcion.val(),
                ORDEN_OPCION: OrdenOpcion.val(), BOTON: mdlNuevoItemXOpcion.find("#EsBoton")[0].checked ? 1 : 0,
                CLASECSS: mdlNuevoItemXOpcion.find("#ClaseCss").val()
            };
            if (!ModuloXOpcion.val()) {
                onCampoInvalido(mdlNuevoItemXOpcion, "ES NECESARIO ESPECIFICAR UN MODULO", function () {
                    xModuloXOpcion.focus().select();
                    onCloseOverlay();
                });
                return;
            }
            if (!NombreOpcion.val()) {
                onCampoInvalido(mdlNuevoItemXOpcion, "ES NECESARIO ESPECIFICAR UN NOMBRE", function () {
                    NombreOpcion.focus().select();
                    onCloseOverlay();
                });
                return;
            }
            if (!NombreIconoOpcion.val()) {
                onCampoInvalido(mdlNuevoItemXOpcion, "ES NECESARIO ESPECIFICAR UN ICONO", function () {
                    NombreIconoOpcion.focus().select();
                    onCloseOverlay();
                });
                return;
            }
            if (!ReferenciaOpcion.val()) {
                onCampoInvalido(mdlNuevoItemXOpcion, "ES NECESARIO ESPECIFICAR UNA REFERENCIA", function () {
                    ReferenciaOpcion.focus().select();
                    onCloseOverlay();
                });
                return;
            }
            if (!OrdenOpcion.val()) {
                onCampoInvalido(mdlNuevoItemXOpcion, "ES NECESARIO ESPECIFICAR UN ORDEN", function () {
                    OrdenOpcion.focus().select();
                    onCloseOverlay();
                });
                return;
            }
            if (!ClaseCss.val()) {
                onCampoInvalido(mdlNuevoItemXOpcion, "ES NECESARIO ESPECIFICAR UNA CLASE CSS", function () {
                    ClaseCss.focus().select();
                    onCloseOverlay();
                });
                return;
            }

            $.post('<?php print base_url('ResourceManager/onGuardarItemXOpcionXModulo'); ?>', p).done(function (a) {
                console.log(a);
                var r = JSON.parse(a);
                console.log(r);
                nuevo = true;
                iMsg("ITEM POR OPCIÓN GUARDADA", "s", function () {
                    onClearPanelInputSelect(mdlNuevoItemXOpcion, function () {
                        xOpcionesXItem.focus().select();
                    });
                });
            }).fail(function (x, y, z) {
                onError(x);
            }).always(function () {
                onCloseOverlay();
            });
        });
        /*FIN ITEMS*/

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
            getModulosX(ModuloXOpcion);
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

        btnEliminarModulo.click(function () {
            console.log(rgistro, rgistro.ID, rgistro.ID !== undefined);
            if (rgistro.ID !== undefined) {
                $.post('<?php print base_url('ResourceManager/onEliminarModuloByID'); ?>',
                        {ID: rgistro.ID}).done(function (a) {
                    Modulos.ajax.reload();
                    onClearPanelInputSelect(mdlNuevoModulo, function () {});
                    onNotifyOldPCF('<span class="fa fa-check"></span>',
                            'SE HA ELIMINADO EL MODULO',
                            'success', {from: "top", align: "center"}, function () {
                        rgistro = {};
                        xModuloXOpcion.focus().select();
                    });
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    getUltimoOrdenXM();
                });
            } else {
                onCampoInvalido(mdlNuevoModulo, "DEBE DE SELECCIONAR UN REGISTRO", function () {
                    rgistro = {};
                });
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
                        getUltimoOrdenXM();
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
            getUltimoOrdenXM();
        });

        mdlNuevoModulo.on('hidden.bs.modal', function () {
            mdlNuevoModulo.find("input").val('');
            location.reload(true);
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
            "deferRender": true, "scrollCollapse": false,
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
            rgistro = xxx;
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
            "deferRender": true, "scrollCollapse": false,
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


    function getItemsXOpcionesXModulos() {
        onOpenOverlay('...');
        if ($.fn.DataTable.isDataTable('#tblItems')) {
            ItemsXOpcionesXModulo.ajax.reload(function () {
                onCloseOverlay();
            });
            return;
        }
        ItemsXOpcionesXModulo = tblItems.DataTable({
            dom: 'frtip', "ajax": {
                "url": '<?php print base_url('ResourceManager/getItemsXOpcionesXModulos'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.MODULO = ModuloXOpcionXItem.val() ? ModuloXOpcionXItem.val() : '';
                    d.OPCION = OpcionesXItem.val() ? OpcionesXItem.val() : '';
                }
            },
            "columns": [
                {"data": "ID"},
                {"data": "MODULO"},
                {"data": "OPCION"},
                {"data": "ITEM"},
                {"data": "FECHA"},

                {"data": "ICONO"}, /*5*/
                {"data": "REF"},
                {"data": "MODAL"},
                {"data": "BACKDROP"},

                {"data": "DROPDOWN"},
                {"data": "ORDEN"},
                {"data": "FUNCION"},
                {"data": "TRIGGER"}
            ],
            "columnDefs": [
                //ID
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                //ID
                {
                    "targets": [1],
                    "visible": false,
                    "searchable": false
                }],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true, "scrollCollapse": false,
            "bSort": false,
            "scrollY": 450,
            "scrollX": true,
            responsive: false,
            "aaSorting": [
                [10, 'DESC']/*ID*/
            ],
            "drawCallback": function (settings) {
                var api = this.api();
                var rows = api.rows({page: 'current'}).nodes();
                var last = null;
                api.column(1, {page: 'current'}).data().each(function (group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                                '<tr class="group"><td colspan="12">' + group + '</td></tr>'
                                );
                        last = group;
                    }
                });
            }
        });
        onCloseOverlay();

        tblItems.on('click', 'tr', function () {
            nuevo = false;
            var xxx = ItemsXOpcionesXModulo.row($(this)).data();
            rgistro = xxx;
            console.log(xxx);
            pnlTablero.find("#IDITEM").val(xxx.ID);
            xModuloXOpcionXItem.val(xxx.MODULO_ID);
            ModuloXOpcionXItem[0].selectize.setValue(xxx.MODULO_ID);
//            EMACS6
//            suma = (a) => (b) => a + b;

            xOpcionesXItem.val(xxx.OPCION_ID);
            $.getJSON('<?php print base_url('ResourceManager/getOpcionesXModuloX'); ?>', {
                MODULO: ModuloXOpcionXItem.val() ? ModuloXOpcionXItem.val() : ''
            }).done(function (a) {
                onClearSelect(OpcionesXItem);
                $.each(a, function (k, v) {
                    OpcionesXItem[0].selectize.addOption({text: v.Opcion, value: v.ID});
                });
                OpcionesXItem[0].selectize.setValue(xxx.OPCION_ID);
            }).fail(function (x) {
                getError(x);
            }).always(function () {

            });
            NombreItem.val(xxx.ITEM);
            NombreIconoItem.val(xxx.ICONOX);
            OrdenItem.val(xxx.ICONOX);
            ReferenciaItem.val(xxx.REF);
            if (parseInt(xxx.ESMODAL) === 1) {
                EsModal[0].checked = true;
            } else {
                EsModal[0].checked = false;
            }

            if (parseInt(xxx.TIENEBACKDROP) === 1) {
                TieneBackdrop[0].checked = true;
            } else {
                TieneBackdrop[0].checked = false;
            }
            if (parseInt(xxx.ESDROPDOWN) > 0) {
                EsDropdown[0].checked = true;
            } else {
                EsDropdown[0].checked = false;
            }
            if (parseInt(xxx.ESFUNCION) > 0) {
                EsFuncion[0].checked = true;
            } else {
                EsFuncion[0].checked = false;
            }
            FuncionEjecutable.val(xxx.TRIGGER);
        });
    }

    function getModulosX(componente) {
        $.getJSON('<?php print base_url('ResourceManager/getModulosX'); ?>').done(function (a) {
            onClearSelect(componente);
            $.each(a, function (k, v) {
                componente[0].selectize.addOption({text: v.Modulo, value: v.ID});
            });
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }

    function setOpcionesXModuloX(xxx) {
        console.log("xxx", xxx);
        OpcionesXItem[0].selectize.setValue(xxx.OPCION_ID);
    }
    function getOpcionesXModuloX(componente, modulo) {
        $.getJSON('<?php print base_url('ResourceManager/getOpcionesXModuloX'); ?>', {
            MODULO: modulo.val() ? modulo.val() : ''
        }).done(function (a) {
            onClearSelect(componente);
            $.each(a, function (k, v) {
                componente[0].selectize.addOption({text: v.Opcion, value: v.ID});
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
        } else {
            onCampoInvalido(mdlNuevaOpcionXModulo, "DEBE DE SELECCIONAR UN REGISTRO", function () {
                rgistro = {};
            });
        }
    }

    function getUltimoOrdenXM() {
        $.getJSON('<?php print base_url('ResourceManager/getUltimoOrdenXM'); ?>').done(function (a) {
            if (a.length > 0) {
                Orden.val(a[0].ULTIMO_ORDEN);
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            onCloseOverlay();
        });
    }


</script>
<style>

    /*SWITCH*/
    .switch {
        font-size: 1rem;
        position: relative;
    }
    .switch input {
        position: absolute;
        height: 1px;
        width: 1px;
        background: none;
        border: 0;
        clip: rect(0 0 0 0);
        clip-path: inset(50%);
        overflow: hidden;
        padding: 0;
    }
    .switch input + label {
        position: relative;
        min-width: calc(calc(2.375rem * .8) * 2);
        border-radius: calc(2.375rem * .8);
        height: calc(2.375rem * .8);
        line-height: calc(2.375rem * .8);
        display: inline-block;
        cursor: pointer;
        outline: none;
        user-select: none;
        vertical-align: middle;
        text-indent: calc(calc(calc(2.375rem * .8) * 2) + .5rem);
    }
    .switch input + label::before,
    .switch input + label::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: calc(calc(2.375rem * .8) * 2);
        bottom: 0;
        display: block;
    }
    .switch input + label::before {
        right: 0;
        background-color: #dee2e6;
        border-radius: calc(2.375rem * .8);
        transition: 0.2s all;
    }
    .switch input + label::after {
        top: 2px;
        left: 2px;
        width: calc(calc(2.375rem * .8) - calc(2px * 2));
        height: calc(calc(2.375rem * .8) - calc(2px * 2));
        border-radius: 50%;
        background-color: white;
        transition: 0.2s all;
    }
    .switch input:checked + label::before {
        background-color: #99cc00;
    }
    .switch input:checked + label::after {
        margin-left: calc(2.375rem * .8);
    }
    .switch input:focus + label::before {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 136, 221, 0.25);
    }
    .switch input:disabled + label {
        color: #868e96;
        cursor: not-allowed;
    }
    .switch input:disabled + label::before {
        background-color: #e9ecef;
    }
    .switch.switch-sm {
        font-size: 0.875rem;
    }
    .switch.switch-sm input + label {
        min-width: calc(calc(1.9375rem * .8) * 2);
        height: calc(1.9375rem * .8);
        line-height: calc(1.9375rem * .8);
        text-indent: calc(calc(calc(1.9375rem * .8) * 2) + .5rem);
    }
    .switch.switch-sm input + label::before {
        width: calc(calc(1.9375rem * .8) * 2);
    }
    .switch.switch-sm input + label::after {
        width: calc(calc(1.9375rem * .8) - calc(2px * 2));
        height: calc(calc(1.9375rem * .8) - calc(2px * 2));
    }
    .switch.switch-sm input:checked + label::after {
        margin-left: calc(1.9375rem * .8);
    }
    .switch.switch-lg {
        font-size: 1.25rem;
    }
    .switch.switch-lg input + label {
        min-width: calc(calc(3rem * .8) * 2);
        height: calc(3rem * .8);
        line-height: calc(3rem * .8);
        text-indent: calc(calc(calc(3rem * .8) * 2) + .5rem);
    }
    .switch.switch-lg input + label::before {
        width: calc(calc(3rem * .8) * 2);
    }
    .switch.switch-lg input + label::after {
        width: calc(calc(3rem * .8) - calc(2px * 2));
        height: calc(calc(3rem * .8) - calc(2px * 2));
    }
    .switch.switch-lg input:checked + label::after {
        margin-left: calc(3rem * .8);
    }
    .switch + .switch {
        margin-left: 1rem;
    }
</style>