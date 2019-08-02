<script src="<?php print base_url('js/multiselectjs/multiselect.min.js'); ?>"></script>
<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold font-italic">Accesos</h3>
    </div>
    <div class="card-body">
        <!--MODULOS POR USUARIO-->
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                <div class="row">
                    <div class="col"    >
                        <h4 class="font-italic">MODULOS POR USUARIO</h4>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 pb-3">
                <label>Usuario</label>
                <select id="mxu" name="mxu" class="form-control form-control-sm NotSelectize">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 pb-3"align="right">
                <button id="btnAsignaTodo" type="button" class="btn btn-primary"  data-toggle="tooltip" data-placement="top" title="ASIGNAR TODOS">
                    <span class="fa fa-shield-alt"></span>
                </button>
                <button id="btnAsignaAvaPRD" type="button" class="btn btn-primary d-none"  data-toggle="tooltip" data-placement="top" title="ASIGNAR AVAPRD">
                    <span class="fa fa-shield-alt"></span>
                </button>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <h4>MODULOS NO ASIGNADOS</h4>
            </div>
            <div class="col-2"></div>
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <h4>MODULOS ASIGNADOS</h4>
            </div>
            <div class="w-100"></div>
            <div class="col-5">
                <select name="from[]" id="modulos" class="form-control NotSelectize " size="10" multiple="multiple"> 
                </select>
            </div>
            <div class="col-2 text-center">
                <button type="button" id="modulos_rightAll" class="btn btn-block btn-default" data-toggle="tooltip" data-placement="top" title="ASIGNAR TODOS"><i class="fa fa-forward"></i></button>
                <button type="button" id="modulos_rightSelected" class="btn btn-block  btn-default" data-toggle="tooltip" data-placement="top" title="ASIGNAR"><i class="fa fa-chevron-right"></i></button>
                <button type="button" id="modulos_leftSelected" class="btn btn-block  btn-danger" data-toggle="tooltip" data-placement="top" title="REMOVER"><i class="fa fa-chevron-left"></i></button>
                <button type="button" id="modulos_leftAll" class="btn btn-block  btn-danger" data-toggle="tooltip" data-placement="top" title="REMOVER TODOS"><i class="fa fa-backward"></i></button>

                <button type="button" id="modulo_nuevo" class="btn btn-info mt-2"  data-toggle="tooltip" data-placement="top" title="AGREGAR MODULO"><span class="fa fa-plus"></span></button>
                <button type="button" id="modulo_editor" class="btn btn-warning mt-2" data-toggle="tooltip" data-placement="top" title="EDITAR MODULO"><span class="fa fa-pencil-alt"></span></button>
                <button type="button" id="modulo_eliminar" class="btn btn-danger mt-2" data-toggle="tooltip" data-placement="top" title="ELIMINAR MODULO"><span class="fa fa-trash"></span></button>
            </div>
            <div class="col-5">
                <select name="to[]" id="modulos_to" class="form-control NotSelectize" size="10" multiple="multiple"></select>
            </div> 
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-2" align="right">
                <button type="button" class="btn btn-info" id="btnAsignarModulos"><span class="fa fa-save"></span> GUARDAR</button>
            </div>
        </div>
        <!--FIN MODULOS POR USUARIO-->      
        <!--OPCIONES POR MODULO-->
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-3 text-center">
                <h4 class="font-italic">OPCIONES POR MODULO</h4> 
                <hr>
                <div class="w-100"></div>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 pb-3">
                <label>Usuario</label>
                <select id="oxmu" name="oxmu" class="form-control form-control-sm NotSelectize">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 pb-3">
                <label>Modulo</label>
                <select id="oxmm" name="oxmm" class="form-control form-control-sm">
                </select>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <h4>OPCIONES NO ASIGNADAS</h4>
            </div>
            <div class="col-2"></div>
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <h4>OPCIONES ASIGNADOS</h4>
            </div>
            <div class="w-100"></div>
            <div class="col-5">
                <select name="from[]" id="opciones" class="form-control NotSelectize " size="10" multiple="multiple"> 
                </select>
            </div>
            <div class="col-2 text-center">
                <button type="button" id="opciones_rightAll" class="btn btn-block btn-default"  data-toggle="tooltip" data-placement="top" title="ASIGNAR TODOS"><i class="fa fa-forward"></i></button>
                <button type="button" id="opciones_rightSelected" class="btn btn-block  btn-default" data-toggle="tooltip" data-placement="top" title="ASIGNAR TODOS"><i class="fa fa-chevron-right"></i></button>
                <button type="button" id="opciones_leftSelected" class="btn btn-block  btn-danger" data-toggle="tooltip" data-placement="top" title="REMOVER"><i class="fa fa-chevron-left"></i></button>
                <button type="button" id="opciones_leftAll" class="btn btn-block  btn-danger" data-toggle="tooltip" data-placement="top" title="REMOVER TODOS"><i class="fa fa-backward"></i></button>

                <button type="button" id="opciones_nuevo" class="btn btn-info mt-2" data-toggle="tooltip" data-placement="top" title="AGREGAR OPCION"><span class="fa fa-plus"></span></button>
                <button type="button" id="opciones_editor" class="btn btn-warning mt-2" data-toggle="tooltip" data-placement="top" title="EDITAR OPCION"><span class="fa fa-pencil-alt"></span></button>
                <button type="button" id="opciones_eliminar" class="btn btn-danger mt-2" data-toggle="tooltip" data-placement="top" title="ELIMINAR OPCION"><span class="fa fa-trash"></span></button>
            </div>
            <div class="col-5">
                <select name="to[]" id="opciones_to" class="form-control NotSelectize" size="10" multiple="multiple"></select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-2" align="right">
                <button type="button" class="btn btn-info" id="btnAsignarOpcionesxModulos"><span class="fa fa-save"></span> GUARDAR</button>
            </div>
        </div>     
        <!--FIN OPCIONES POR MODULO--> 
        <!--ITEMS POR OPCION-->
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-3 text-center">
                <h4 class="font-italic">ITEMS POR OPCIÓN</h4> 
                <hr>
                <div class="w-100"></div>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 pb-3">
                <label>Usuario</label>
                <select id="ixou" name="ixou" class="form-control form-control-sm NotSelectize">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 pb-3">
                <label>Modulo</label>
                <select id="ixom" name="ixom" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 pb-3">
                <label>Opcion</label>
                <select id="ixoo" name="ixoo" class="form-control form-control-sm">
                </select>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <h4>ITEMS NO ASIGNADOS</h4>
            </div>
            <div class="col-2"></div>
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <h4>ITEMS ASIGNADOS</h4>
            </div>
            <div class="w-100"></div>
            <div class="col-5">
                <select name="from[]" id="items" class="form-control NotSelectize " size="15" multiple="multiple"> 
                </select>
            </div>
            <div class="col-2 text-center">
                <button type="button" id="items_rightAll" class="btn btn-block btn-default" data-toggle="tooltip" data-placement="top" title="ASIGNAR TODOS"><i class="fa fa-forward"></i></button>
                <button type="button" id="items_rightSelected" class="btn btn-block  btn-default" data-toggle="tooltip" data-placement="top" title="ASIGNAR"><i class="fa fa-chevron-right"></i></button>
                <button type="button" id="items_leftSelected" class="btn btn-block  btn-danger" data-toggle="tooltip" data-placement="top" title="REMOVER"><i class="fa fa-chevron-left"></i></button>
                <button type="button" id="items_leftAll" class="btn btn-block  btn-danger"  data-toggle="tooltip" data-placement="top" title="REMOVER TODOS"><i class="fa fa-backward"></i></button>

                <button type="button" id="items_nuevo" class="btn btn-info mt-2" data-toggle="tooltip" data-placement="top" title="AGREGAR ITEM"><span class="fa fa-plus"></span></button>
                <button type="button" id="items_editor" class="btn btn-warning mt-2"  data-toggle="tooltip" data-placement="top" title="EDITAR ITEM"><span class="fa fa-pencil-alt"></span></button>
                <button type="button" id="items_eliminar" class="btn btn-danger mt-2"  data-toggle="tooltip" data-placement="top" title="ELIMINAR ITEM"><span class="fa fa-trash"></span></button>
            </div>
            <div class="col-5">
                <select name="to[]" id="items_to" class="form-control NotSelectize" size="15" multiple="multiple"></select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-2" align="right">
                <button type="button" class="btn btn-info" id="btnAsignarItemsXOpcionXModulo"><span class="fa fa-save"></span> GUARDAR</button>
            </div>
        </div>     
        <!--FIN ITEMS POR OPCION-->
        <!--SUBITEMS POR ITEM-->
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-3 text-center">
                <h4 class="font-italic">SUBITEMS POR ITEM</h4> 
                <hr>
                <div class="w-100"></div>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 pb-3">
                <label>Usuario</label>
                <select id="sixiu" name="sixiu" class="form-control form-control-sm NotSelectize">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 pb-3">
                <label>Modulo</label>
                <select id="sixim" name="sixim" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 pb-3">
                <label>Opcion</label>
                <select id="sixio" name="sixio" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 pb-3">
                <label>Item</label>
                <select id="sixit" name="sixit" class="form-control form-control-sm">
                </select>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <h4>SUBITEMS NO ASIGNADOS</h4>
            </div>
            <div class="col-2"></div>
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <h4>SUBITEMS ASIGNADOS</h4>
            </div>
            <div class="w-100"></div>
            <div class="col-5">
                <select name="from[]" id="subitems" class="form-control NotSelectize " size="15" multiple="multiple"> 
                </select>
            </div>
            <div class="col-2 text-center">
                <button type="button" id="subitems_rightAll" class="btn btn-block btn-default" data-toggle="tooltip" data-placement="top" title="ASIGNAR TODOS"><i class="fa fa-forward"></i></button>
                <button type="button" id="subitems_rightSelected" class="btn btn-block  btn-default" data-toggle="tooltip" data-placement="top" title="ASIGNAR"><i class="fa fa-chevron-right"></i></button>
                <button type="button" id="subitems_leftSelected" class="btn btn-block  btn-danger" data-toggle="tooltip" data-placement="top" title="REMOVER"><i class="fa fa-chevron-left"></i></button>
                <button type="button" id="subitems_leftAll" class="btn btn-block  btn-danger" data-toggle="tooltip" data-placement="top" title="REMOVER TODOS"><i class="fa fa-backward"></i></button>

                <button type="button" id="subitems_nuevo" class="btn btn-info mt-2" data-toggle="tooltip" data-placement="top" title="AGREGAR SUBITEM"><span class="fa fa-plus"></span></button>
                <button type="button" id="subitems_editor" class="btn btn-warning mt-2" data-toggle="tooltip" data-placement="top" title="EDITAR SUBITEM"><span class="fa fa-pencil-alt"></span></button>
                <button type="button" id="subitems_eliminar" class="btn btn-danger mt-2" data-toggle="tooltip" data-placement="top" title="ELIMINAR SUBITEM"><span class="fa fa-trash"></span></button>
            </div>
            <div class="col-5">
                <select name="to[]" id="subitems_to" class="form-control NotSelectize" size="15" multiple="multiple"></select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-2" align="right">
                <button type="button" class="btn btn-info" id="btnAsignarSubItemsXItemXOpcionXModulo"><span class="fa fa-save"></span> GUARDAR</button>
            </div>
        </div>     
        <!--FIN SUBITEMS POR ITEM-->
        <!--SUBSUBITEMS POR ITEM-->
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-3 text-center">
                <h4 class="font-italic">SUBSUBITEMS POR SUBITEM</h4> 
                <hr>
                <div class="w-100"></div>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 pb-3">
                <label>Usuario</label>
                <select id="ssixiu" name="ssixiu" class="form-control form-control-sm NotSelectize">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 pb-3">
                <label>Modulo</label>
                <select id="ssixim" name="ssixim" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 pb-3">
                <label>Opcion</label>
                <select id="ssixio" name="ssixio" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 pb-3">
                <label>Item</label>
                <select id="ssixit" name="ssixit" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 pb-3">
                <label>SubItem</label>
                <select id="ssixis" name="ssixis" class="form-control form-control-sm">
                </select>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <h4>SUBSUBITEMS NO ASIGNADOS</h4>
            </div>
            <div class="col-2"></div>
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <h4>SUBSUBITEMS ASIGNADOS</h4>
            </div>
            <div class="w-100"></div>
            <div class="col-5">
                <select name="from[]" id="subsubitems" class="form-control NotSelectize " size="15" multiple="multiple"> 
                </select>
            </div>
            <div class="col-2 text-center">
                <button type="button" id="subsubitems_rightAll" class="btn btn-block btn-default" data-toggle="tooltip" data-placement="top" title="ASIGNAR TODOS"><i class="fa fa-forward"></i></button>
                <button type="button" id="subsubitems_rightSelected" class="btn btn-block  btn-default" data-toggle="tooltip" data-placement="top" title="ASIGNAR"><i class="fa fa-chevron-right"></i></button>
                <button type="button" id="subsubitems_leftSelected" class="btn btn-block  btn-danger" data-toggle="tooltip" data-placement="top" title="REMOVER"><i class="fa fa-chevron-left"></i></button>
                <button type="button" id="subsubitems_leftAll" class="btn btn-block  btn-danger" data-toggle="tooltip" data-placement="top" title="REMOVER TODOS"><i class="fa fa-backward"></i></button>

                <button type="button" id="subsubitems_nuevo" class="btn btn-info mt-2" data-toggle="tooltip" data-placement="top" title="AGREGAR SUBSUBITEM"><span class="fa fa-plus"></span></button>
                <button type="button" id="subsubitems_editor" class="btn btn-warning mt-2" data-toggle="tooltip" data-placement="top" title="EDITAR SUBSUBITEM"><span class="fa fa-pencil-alt"></span></button>
                <button type="button" id="subsubitems_eliminar" class="btn btn-danger mt-2" data-toggle="tooltip" data-placement="top" title="ELIMINAR SUBSUBITEM"><span class="fa fa-trash"></span></button>
            </div>
            <div class="col-5">
                <select name="to[]" id="subsubitems_to" class="form-control NotSelectize" size="15" multiple="multiple"></select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-2" align="right">
                <button type="button" class="btn btn-info" id="btnAsignarSubSubItemsXSubItemXItemXOpcionXModulo"><span class="fa fa-save"></span> GUARDAR</button>
            </div>
        </div>     
        <!--FIN SUBSUBITEMS POR ITEM-->
    </div>
</div>
<script type="text/javascript">
    var pnlTablero = $("#pnlTablero"), pnlTableroBody = $("#pnlTablero").find(".card-body");
    var mxu = pnlTableroBody.find("#mxu"), oxmu = pnlTableroBody.find("#oxmu"),
            ixou = pnlTableroBody.find("#ixou"), sixiu = pnlTableroBody.find("#sixiu"),
            oxmm = pnlTableroBody.find("#oxmm"), ixom = pnlTableroBody.find("#ixom"),
            ixoo = pnlTableroBody.find("#ixoo"), sixim = pnlTableroBody.find("#sixim"),
            sixio = pnlTableroBody.find("#sixio"), sixit = pnlTableroBody.find("#sixit"),
            ssixiu = pnlTableroBody.find("#ssixiu"), ssixim = pnlTableroBody.find("#ssixim"),
            ssixio = pnlTableroBody.find("#ssixio"), ssixit = pnlTableroBody.find("#ssixit"),
            ssixis = pnlTableroBody.find("#ssixis"), btnAsignaTodo = pnlTableroBody.find("#btnAsignaTodo");

    var btnAsignarModulos = pnlTableroBody.find("#btnAsignarModulos"),
            btnAsignarOpcionesxModulos = pnlTableroBody.find("#btnAsignarOpcionesxModulos"),
            btnAsignarItemsXOpcionXModulo = pnlTableroBody.find("#btnAsignarItemsXOpcionXModulo"),
            btnAsignarSubItemsXItemXOpcionXModulo = pnlTableroBody.find("#btnAsignarSubItemsXItemXOpcionXModulo"),
            btnAsignarSubSubItemsXSubItemXItemXOpcionXModulo = pnlTableroBody.find("#btnAsignarSubSubItemsXSubItemXItemXOpcionXModulo");
    var usr = '<?php PRINT $this->session->ID; ?>';
    $(document).ready(function () {
        console.log(usr);
        pnlTableroBody.find("#btnAsignaAvaPRD").click(function () {
            HoldOn.open({
                theme: 'sk-rect',
                message: 'Asignando...'
            });
            $.post('<?php print base_url('Accesos/onAsignaAvaPRD') ?>').done(function (x) {
                console.log(x);

            }).fail(function (x) {
                getError(x);
            }).always(function () {
                HoldOn.close();
            });
        });

        btnAsignaTodo.click(function () {
            onBeep(1);
            if (mxu.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Asignando permisos...'
                });
                $.post('<?php print base_url('Accesos/onAsignarTodo'); ?>', {USUARIO: mxu.val()}).done(function (a, b, c) {
                    onBeep(5);
                    swal('ATENCIÓN', 'SE HAN ASIGNADO TODOS LOS PERMISOS CON ÉXITO', 'success');
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });

            } else {
                onBeep(2);
                swal('ATENCIÓN', 'DEBE DE SELECCIONAR AL MENOS UN USUARIO', 'warning').then((value) => {
                    mxu[0].selectize.open();
                });
            }
        });

        pnlTableroBody.find("#mxu, #oxmu,#ixou,#sixiu,#ssixiu").selectize({
            create: true,
            sortField: 'text'
        });
        pnlTableroBody.find('#modulos').multiselect();
        pnlTableroBody.find('#opciones').multiselect();
        pnlTableroBody.find('#items').multiselect();
        pnlTableroBody.find('#subitems').multiselect();
        pnlTableroBody.find('#subsubitems').multiselect();

        $('button[id^="modulos"].btn-default').click(function () {
            onBeep(1);
        });

        $('button[id^="modulos"].btn-danger').click(function () {
            onBeep(3);
        });

        /*SUBSUBITEMS POR SUBITEM*/
        btnAsignarSubSubItemsXSubItemXItemXOpcionXModulo.click(function () {
            if (ssixiu.val() && ssixim.val() && ssixio.val() && ssixit.val() && ssixis.val()) {
                console.log('okoka');
                var subsubitems = [];
                $.each($("#subsubitems_to").find('option'), function (k, v) { 
                    subsubitems.push({SUBSUBITEM: $(v).val(), SUBSUBITEMT: $(v).text()});
                });
                console.log('subsubitems', subsubitems);
                if (subsubitems.length > 0) {
                    onEstablecerSubSubItems(ssixiu.val(), ssixim.val(), ssixio.val(), ssixit.val(), ssixis.val(), subsubitems);
                } else if (subsubitems.length <= 0 && $("#subsubitems option").length > 0) {
                    onBeep(2);
                    console.log($("#subsubitems option"), $("#subsubitems option").length);
                    swal({
                        buttons: ["CANCELAR", "ACEPTAR"],
                        title: 'NO HA SELECCIONADO NINGÚN SUBSUBITEM ESTO VA A ELIMINAR TODOS LOS ACCESOS A LOS SUBSUBITEMS POR SUBITEM PARA ESTE USUARIO, ¿DESEA CONTINUAR?',
                        text: "ESTA ACCIÓN ELIMINARÁ LOS PERMISOS",
                        icon: "warning",
                        closeOnEsc: true,
                        closeOnClickOutside: true
                    }).then((action) => {
                        if (action) {
                            onEstablecerSubSubItems(ssixiu.val(), ssixim.val(), ssixio.val(), ssixit.val(), ssixis.val(), subsubitems);
                        }
                    });
                } else if (subsubitems.length <= 0) {
                    swal('ATENCIÓN', 'NO SE HAN PODIDO ASIGNAR LOS SUBSUBITEMS', 'error');
                }
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'SELECCIONE LOS FILTROS REQUERIDOS', 'warning').then((value) => {
                    if (!ssixiu.val()) {
                        ssixiu[0].selectize.focus();
                        ssixiu[0].selectize.open();
                    } else
                    if (!ssixim.val()) {
                        ssixim[0].selectize.focus();
                        ssixim[0].selectize.open();
                    } else
                    if (!ssixio.val()) {
                        ssixio[0].selectize.focus();
                        ssixio[0].selectize.open();
                    } else
                    if (!ssixit.val()) {
                        ssixit[0].selectize.focus();
                        ssixit[0].selectize.open();
                    } else
                    if (!ssixis.val()) {
                        ssixis[0].selectize.focus();
                        ssixis[0].selectize.open();
                    }
                });
            }
        });

        ssixis.change(function () {
            $("#subsubitems").html('');
            $("#subsubitems_to").html('');
            getSubSubItemsXSubItemXItemXOpcionXModuloXUsuario();
        });

        ssixit.change(function () {
            $("#subsubitems").html('');
            $("#subsubitems_to").html('');
            $.getJSON('<?php print base_url('accesos_subitems_x_item_x_opcion_x_modulo_x_usuario'); ?>',
                    {U: ssixiu.val(), M: ssixim.val(), O: ssixio.val(), I: ssixit.val()}).done(function (dx) {
                console.log('accesos_subitems_x_item_x_opcion_x_modulo_x_usuario', dx);
                if (dx.length > 0) {
                    ssixis[0].selectize.clear(true);
                    ssixis[0].selectize.clearOptions();
                    $.each(dx, function (k, v) {
                        if (parseInt(v.Dropdown) === 1) {
                            ssixis[0].selectize.addOption({text: v.SubItem, value: v.ID});
                        }
                    });
                    ssixis[0].selectize.focus();
                    ssixis[0].selectize.open();
                } else {
                    onBeep(2);
                    swal('ATENCIÓN', 'ESTE USUARIO NO TIENE SUBITEMS EN ESTE ITEM, ASIGNE EN "SUBITEMS POR ITEM" LOS ITEMS.', 'warning');
                }
            }).fail(function (x, y, z) {
                console.log(x.responseText);
            }).always(function () {
            });
        });

        ssixio.change(function () {
            $("#subsubitems").html('');
            $("#subsubitems_to").html('');
            $.getJSON('<?php print base_url('accesos_dropdown_items_x_opcion_x_modulo_x_usuario'); ?>', {U: ssixiu.val(), M: ssixim.val(), O: ssixio.val()}).done(function (dx) {
                console.log(dx);
                if (dx.length > 0) {
                    ssixit[0].selectize.clear(true);
                    ssixit[0].selectize.clearOptions();
                    $.each(dx, function (k, v) {
                        if (parseInt(v.Dropdown) === 1) {
                            ssixit[0].selectize.addOption({text: v.Item, value: v.ID});
                        }
                    });
                    ssixit[0].selectize.focus();
                    ssixit[0].selectize.open();
                } else {
                    onBeep(2);
                    swal('ATENCIÓN', 'ESTE USUARIO NO TIENE OPCIONES EN ESTE MODULO', 'warning');
                }
            }).fail(function (x, y, z) {
                console.log(x.responseText);
            }).always(function () {
            });
        });

        ssixim.change(function () {
            $("#subsubitems").html('');
            $("#subsubitems_to").html('');
            $.getJSON('<?php print base_url('accesos_opciones_x_modulo_x_usuario'); ?>', {U: ssixiu.val(), M: ssixim.val()}).done(function (dx) {
                console.log(dx);
                if (dx.length > 0) {
                    ssixio[0].selectize.clear(true);
                    ssixio[0].selectize.clearOptions();
                    $.each(dx, function (k, v) {
                        ssixio[0].selectize.addOption({text: v.Opcion, value: v.ID});
                    });
                    ssixio[0].selectize.focus();
                    ssixio[0].selectize.open();
                } else {
                    onBeep(2);
                    swal('ATENCIÓN', 'ESTE USUARIO NO TIENE OPCIONES EN ESTE MODULO', 'warning');
                }
            }).fail(function (x, y, z) {
                console.log(x.responseText);
            }).always(function () {
            });
        });

        ssixiu.change(function () {
            $("#subsubitems").html('');
            $("#subsubitems_to").html('');
            $.getJSON('<?php print base_url('accesos_modulos_x_usuario'); ?>', {U: ssixiu.val()}).done(function (dx) {
                ssixim[0].selectize.clear(true);
                ssixim[0].selectize.clearOptions();
                $.each(dx, function (k, v) {
                    ssixim[0].selectize.addOption({text: v.Modulo, value: v.ID});
                });
                ssixim[0].selectize.focus();
                ssixim[0].selectize.open();
            }).fail(function (x, y, z) {
                console.log(x.responseText);
            }).always(function () {
            });
        });
        /*FIN SUBSUBITEMS POR SUBITEM*/

        /*SUBITEMS POR ITEM*/
        btnAsignarSubItemsXItemXOpcionXModulo.click(function () {
            if (sixiu.val() && sixim.val() && sixio.val() && sixit.val()) {
                var subitems = [];
                $.each($("#subitems_to").find('option'), function (k, v) {
                    subitems.push({SUBITEM: $(v).val(), SUBITEMT: $(v).text()});
                });
                if (subitems.length > 0) {
                    onEstablecerSubItems(sixiu.val(), sixim.val(), sixio.val(), sixit.val(), subitems);
                } else {
                    onBeep(2);
                    swal({
                        buttons: ["CANCELAR", "ACEPTAR"],
                        title: 'NO HA SELECCIONADO NINGÚN SUBITEM ESTO VA A ELIMINAR TODOS LOS ACCESOS A LOS SUBITEMS POR ITEM PARA ESTE USUARIO, ¿DESEA CONTINUAR?',
                        text: "ESTA ACCIÓN ELIMINARÁ LOS PERMISOS",
                        icon: "warning",
                        closeOnEsc: true,
                        closeOnClickOutside: true
                    }).then((action) => {
                        if (action) {
                            onEstablecerSubItems(sixiu.val(), sixim.val(), sixio.val(), sixit.val(), subitems);
                        }
                    });
                }
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'SELECCIONE LOS FILTROS REQUERIDOS', 'warning').then((value) => {
                    if (!sixiu.val()) {
                        sixiu[0].selectize.focus();
                        sixiu[0].selectize.open();
                    } else
                    if (!sixim.val()) {
                        sixim[0].selectize.focus();
                        sixim[0].selectize.open();
                    } else
                    if (!sixio.val()) {
                        sixio[0].selectize.focus();
                        sixio[0].selectize.open();
                    } else
                    if (!sixit.val()) {
                        sixit[0].selectize.focus();
                        sixit[0].selectize.open();
                    }
                });
            }
        });

        sixit.change(function () {
            $("#subitems").html('');
            $("#subitems_to").html('');
            getSubItemsXItemXOpcionXModuloXUsuario();
        });

        sixio.change(function () {
            $("#subitems").html('');
            $("#subitems_to").html('');
            $.getJSON('<?php print base_url('accesos_dropdown_items_x_opcion_x_modulo_x_usuario'); ?>', {U: sixiu.val(), M: sixim.val(), O: sixio.val()}).done(function (dx) {
                console.log(dx);
                if (dx.length > 0) {
                    sixit[0].selectize.clear(true);
                    sixit[0].selectize.clearOptions();
                    $.each(dx, function (k, v) {
                        sixit[0].selectize.addOption({text: v.Item, value: v.ID});
                    });
                    sixit[0].selectize.focus();
                    sixit[0].selectize.open();
                } else {
                    onBeep(2);
                    swal('ATENCIÓN', 'ESTE USUARIO NO TIENE OPCIONES EN ESTE MODULO', 'warning');
                }
            }).fail(function (x, y, z) {
                console.log(x.responseText);
            }).always(function () {
            });
        });

        sixim.change(function () {
            $("#subitems").html('');
            $("#subitems_to").html('');
            $.getJSON('<?php print base_url('accesos_opciones_x_modulo_x_usuario'); ?>', {U: sixiu.val(), M: sixim.val()}).done(function (dx) {
                console.log(dx);
                if (dx.length > 0) {
                    sixio[0].selectize.clear(true);
                    sixio[0].selectize.clearOptions();
                    $.each(dx, function (k, v) {
                        sixio[0].selectize.addOption({text: v.Opcion, value: v.ID});
                    });
                    sixio[0].selectize.focus();
                    sixio[0].selectize.open();
                } else {
                    onBeep(2);
                    swal('ATENCIÓN', 'ESTE USUARIO NO TIENE OPCIONES EN ESTE MODULO', 'warning');
                }
            }).fail(function (x, y, z) {
                console.log(x.responseText);
            }).always(function () {
            });
        });

        sixiu.change(function () {
            $("#subitems").html('');
            $("#subitems_to").html('');
            $.getJSON('<?php print base_url('accesos_modulos_x_usuario'); ?>', {U: sixiu.val()}).done(function (dx) {
                sixim[0].selectize.clear(true);
                sixim[0].selectize.clearOptions();
                $.each(dx, function (k, v) {
                    sixim[0].selectize.addOption({text: v.Modulo, value: v.ID});
                });
                sixim[0].selectize.focus();
                sixim[0].selectize.open();
            }).fail(function (x, y, z) {
                console.log(x.responseText);
            }).always(function () {
            });
        });
        /*FIN SUBITEMS POR ITEM*/

        /*ITEMS POR OPCIÓN*/

        btnAsignarItemsXOpcionXModulo.click(function () {
            if (ixom.val() && ixou.val() && ixoo.val()) {
                var items = [];
                $.each($("#items_to").find('option'), function (k, v) {
                    items.push({ITEM: $(v).val(), ITEMT: $(v).text()});
                });
                if (items.length > 0) {
                    onEstablecerItems(ixou.val(), ixom.val(), ixoo.val(), items);
                } else {
                    onBeep(2);
                    swal({
                        buttons: ["CANCELAR", "ACEPTAR"],
                        title: 'NO HA SELECCIONADO NINGÚN ITEM ESTO VA A ELIMINAR TODOS LOS ACCESOS A LOS ITEMS POR OPCIÓN PARA ESTE USUARIO, ¿DESEA CONTINUAR?',
                        text: "ESTA ACCIÓN ELIMINARÁ LOS PERMISOS",
                        icon: "warning",
                        closeOnEsc: true,
                        closeOnClickOutside: true
                    }).then((action) => {
                        if (action) {
                            onEstablecerItems(ixou.val(), ixom.val(), ixoo.val(), items);
                        }
                    });
                }
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'SELECCIONE LOS FILTROS REQUERIDOS', 'warning').then((value) => {
                    ixou[0].selectize.focus();
                    ixou[0].selectize.open();
                });
            }
        });

        ixoo.change(function () {
            $("#items").html('');
            $("#items_to").html('');
            getItemsXOpcionXModuloXUsuario();
        });

        ixom.change(function () {
            $("#items").html('');
            $("#items_to").html('');
            $.getJSON('<?php print base_url('accesos_opciones_x_modulo_x_usuario'); ?>', {U: ixou.val(), M: ixom.val()}).done(function (dx) {
                console.log(dx);
                if (dx.length > 0) {
                    ixoo[0].selectize.clear(true);
                    ixoo[0].selectize.clearOptions();
                    $.each(dx, function (k, v) {
                        ixoo[0].selectize.addOption({text: v.Opcion, value: v.ID});
                    });
                    ixoo[0].selectize.focus();
                    ixoo[0].selectize.open();
                } else {
                    onBeep(2);
                    swal('ATENCIÓN', 'ESTE USUARIO NO TIENE OPCIONES EN ESTE MODULO', 'warning');
                }
            }).fail(function (x, y, z) {
                console.log(x.responseText);
            }).always(function () {
            });
        });

        ixou.change(function () {
            $("#items").html('');
            $("#items_to").html('');
            $.getJSON('<?php print base_url('accesos_modulos_x_usuario'); ?>', {U: ixou.val()}).done(function (dx) {
                ixom[0].selectize.clear(true);
                ixom[0].selectize.clearOptions();
                $.each(dx, function (k, v) {
                    ixom[0].selectize.addOption({text: v.Modulo, value: v.ID});
                });
                ixom[0].selectize.focus();
                ixom[0].selectize.open();
            }).fail(function (x, y, z) {
                console.log(x.responseText);
            }).always(function () {
            });
        });
        /* FIN ITEMS POR OPCIÓN*/

        /*OPCIONES POR MODULO*/
        btnAsignarOpcionesxModulos.click(function () {
            if (oxmm.val() && oxmu.val()) {
                var options = [];
                $.each($("#opciones_to").find('option'), function (k, v) {
                    options.push({OPCION: $(v).val(), OPCIONT: $(v).text()});
                });
                if (options.length > 0) {
                    onEstablecerOpciones(oxmu.val(), oxmm.val(), options);
                } else {
                    onBeep(2);
                    swal({
                        buttons: ["CANCELAR", "ACEPTAR"],
                        title: 'NO HA SELECCIONADO NINGÚNA OPCIÓN ESTO VA A ELIMINAR TODOS LOS ACCESOS A LAS OPCIONES PARA ESTE USUARIO, ¿DESEA CONTINUAR?',
                        text: "ESTA ACCIÓN ELIMINARÁ LOS PERMISOS",
                        icon: "warning",
                        closeOnEsc: true,
                        closeOnClickOutside: true
                    }).then((action) => {
                        if (action) {
                            onEstablecerOpciones(oxmu.val(), oxmm.val(), options);
                        }
                    });
                }
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'SELECCIONE LOS FILTROS REQUERIDOS', 'warning').then((value) => {
                    oxmu[0].selectize.focus();
                    oxmu[0].selectize.open();
                });
            }
        });

        oxmm.change(function () {
            $("#opciones").html('');
            $("#opciones_to").html('');
            getOpcionesXModuloXUsuario();
        });

        oxmu.change(function () {
            $("#opciones").html('');
            $("#opciones_to").html('');
            $.getJSON('<?php print base_url('accesos_modulos_x_usuario'); ?>', {U: oxmu.val()}).done(function (dx) {
                oxmm[0].selectize.clear(true);
                oxmm[0].selectize.clearOptions();
                $.each(dx, function (k, v) {
                    oxmm[0].selectize.addOption({text: v.Modulo, value: v.ID});
                });
                oxmm[0].selectize.focus();
                oxmm[0].selectize.open();
            }).fail(function (x, y, z) {
                console.log(x.responseText);
            }).always(function () {
            });
        });
        /* FIN OPCIONES POR MODULO*/

        /*MODULOS POR USUARIO*/

        $.getJSON('<?php print base_url('Accesos/getUsuarios') ?>').done(function (dx) {
            dx.forEach(function (v) {
                mxu[0].selectize.addOption({text: v.ID + ' ' + v.USUARIO + ' (' + v.TIPO_ACCESO + ')', value: v.ID});
                oxmu[0].selectize.addOption({text: v.ID + ' ' + v.USUARIO + ' (' + v.TIPO_ACCESO + ')', value: v.ID});
                ixou[0].selectize.addOption({text: v.ID + ' ' + v.USUARIO + ' (' + v.TIPO_ACCESO + ')', value: v.ID});
                sixiu[0].selectize.addOption({text: v.ID + ' ' + v.USUARIO + ' (' + v.TIPO_ACCESO + ')', value: v.ID});
                ssixiu[0].selectize.addOption({text: v.ID + ' ' + v.USUARIO + ' (' + v.TIPO_ACCESO + ')', value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        }).always(function () {
            mxu[0].selectize.setValue(usr);
        });

        $.getJSON('<?php print base_url('accesos_modulos') ?>').done(function (dx) {
            $.each(dx, function (k, v) {
                $("#modulos").append('<option value="' + v.ID + '">' + v.Modulo + '</option>');
            });
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        });

        btnAsignarModulos.click(function () {
            if (mxu.val()) {
                var options = [];
                $.each($("#modulos_to").find('option'), function (k, v) {
                    options.push({MODULO: $(v).val(), MODULOT: $(v).text()});
                });
                if (options.length > 0) {
                    onEstablecerModulos(mxu.val(), options);
                } else {
                    onBeep(2);
                    swal({
                        buttons: ["CANCELAR", "ACEPTAR"],
                        title: 'NO HA SELECCIONADO NINGÚN MODULO ESTO VA A ELIMINAR TODOS LOS ACCESOS A LOS MODULOS PARA ESTE USUARIO, ¿DESEA CONTINUAR?',
                        text: "ESTA ACCIÓN ELIMINARÁ LOS PERMISOS",
                        icon: "warning",
                        closeOnEsc: true,
                        closeOnClickOutside: true
                    }).then((action) => {
                        if (action) {
                            onEstablecerModulos(mxu.val(), options);
                        }
                    });
                }
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'SELECCIONE LOS FILTROS REQUERIDOS', 'warning').then((value) => {
                    mxu[0].selectize.focus();
                    mxu[0].selectize.open();
                });
            }
        });

        mxu.change(function () {
            $("#modulos").html('');
            $("#modulos_to").html('');
            getModulosXUsuario();
        });
        /*FIN MODULOS POR USUARIO*/
    });

    /*MODULOS*/
    function getModulosXUsuario() {
        $.getJSON('<?php print base_url('accesos_modulos_x_usuario'); ?>', {U: mxu.val()}).done(function (dx) {
            if (dx.length > 0) {
                var modulos_asignados = [];
                $.each(dx, function (k, v) {
                    $("#modulos_to").append('<option value="' + v.ID + '">' + v.Modulo + '</option>');
                    modulos_asignados.push(v.ID);
                });
                getModulos(2, modulos_asignados);
            } else {
                onBeep(2);
                $.notify({
                    // options
                    message: 'ESTE USUARIO NO TIENE ASIGNADO NINGÚN MODULO'
                }, {
                    // settings
                    type: 'danger',
                    delay: 3500,
                    animate: {
                        enter: 'animated bounceIn',
                        exit: 'animated flipOutX'
                    },
                    placement: {
                        from: "top",
                        align: "center"
                    }
                });
                getModulos(1, []);
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        }).always(function () {

        });
    }

    function onEstablecerModulos(usr, op) {
        var f = new FormData();
        f.append('USR', usr);
        f.append('OPTIONS', JSON.stringify(op));
        $.ajax({
            url: '<?php print base_url('accesos_add_modulos'); ?>',
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: f
        }).done(function (data, x, jq) {
            swal('ATENCIÓN', 'SE HAN GUARDADO LOS CAMBIOS', 'success');
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        }).always(function () {

        });
    }

    function getModulos(action, ma) {
        var modulos = $("#modulos");
        modulos.html('');
        $.getJSON('<?php print base_url('accesos_modulos') ?>').done(function (dx) {
            switch (action) {
                case 1:
                    $("#modulos_to").html('');
                    $.each(dx, function (k, v) {
                        modulos.append('<option value="' + v.ID + '">' + v.Modulo + '</option>');
                    });
                    break;
                case 2:
                    $.each(dx, function (kk, vv) {
                        if (ma.indexOf(vv.ID) === -1) {
                            modulos.append('<option value="' + vv.ID + '">' + vv.Modulo + '</option>');
                        }
                    });
                    break;
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        });
    }
    /*FIN MODULOS*/

    /*OPCIONES*/
    function getOpcionesXModuloXUsuario() {
        $.getJSON('<?php print base_url('accesos_opciones_x_modulo_x_usuario') ?>', {U: oxmu.val(), M: oxmm.val()}).done(function (dx) {
            if (dx.length > 0) {
                var opciones_asignadas = [];
                $.each(dx, function (k, v) {
                    $("#opciones_to").append('<option value="' + v.ID + '">' + v.Opcion + '</option>');
                    opciones_asignadas.push(v.ID);
                });
                getOpciones(2, opciones_asignadas, oxmm.val());
            } else {
                onBeep(2);
                $.notify({
                    // options
                    message: 'ESTE USUARIO NO TIENE ASIGNADO NINGÚNA OPCIÓN EN ESTE MODULO'
                }, {
                    // settings
                    type: 'danger',
                    delay: 3500,
                    animate: {
                        enter: 'animated bounceIn',
                        exit: 'animated flipOutX'
                    },
                    placement: {
                        from: "top",
                        align: "center"
                    }
                });
                getOpciones(1, [], oxmm.val());
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        });
    }

    function getOpciones(action, ops, m) {
        var opciones = $("#opciones");
        opciones.html('');
        $.getJSON('<?php print base_url('accesos_opciones') ?>', {M: m}).done(function (dx) {

            switch (action) {
                case 1:
                    $("#opciones_to").html('');
                    $.each(dx, function (k, v) {
                        opciones.append('<option value="' + v.ID + '">' + v.Opcion + '</option>');
                    });
                    break;
                case 2:
                    $.each(dx, function (kk, vv) {
                        if (ops.indexOf(vv.ID) === -1) {
                            opciones.append('<option value="' + vv.ID + '">' + vv.Opcion + '</option>');
                        }
                    });
                    break;
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        });
    }

    function onEstablecerOpciones(usr, mdl, op) {
        var f = new FormData();
        f.append('USR', usr);
        f.append('MDL', mdl);
        f.append('OPTIONS', JSON.stringify(op));
        $.ajax({
            url: '<?php print base_url('accesos_add_opciones_x_modulo_x_usuario'); ?>',
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: f
        }).done(function (data, x, jq) {
            swal('ATENCIÓN', 'SE HAN GUARDADO LOS CAMBIOS', 'success');
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        }).always(function () {

        });
    }
    /*FIN OPCIONES*/

    /*ITEMS*/
    function getItemsXOpcionXModuloXUsuario() {
        $.getJSON('<?php print base_url('accesos_items_x_opcion_x_modulo_x_usuario') ?>', {U: ixou.val(), M: ixom.val(), O: ixoo.val()}).done(function (dx) {
            if (dx.length > 0) {
                var items_asignados = [];
                $.each(dx, function (k, v) {
                    $("#items_to").append('<option value="' + v.ID + '">' + v.Item + '</option>');
                    items_asignados.push(v.ID);
                });
                getItems(2, items_asignados, ixoo.val());
            } else {
                onBeep(2);
                $.notify({
                    // options
                    message: 'ESTE USUARIO NO TIENE ASIGNADO NINGÚNA OPCIÓN EN ESTE MODULO'
                }, {
                    // settings
                    type: 'danger',
                    delay: 3500,
                    animate: {
                        enter: 'animated bounceIn',
                        exit: 'animated flipOutX'
                    },
                    placement: {
                        from: "top",
                        align: "center"
                    }
                });
                getItems(1, [], ixoo.val());
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        });
    }

    function getItems(action, ops, o) {
        var items = $("#items");
        items.html('');
        $.getJSON('<?php print base_url('accesos_items') ?>', {O: o}).done(function (dx) {
            switch (action) {
                case 1:
                    $("#items_to").html('');
                    $.each(dx, function (k, v) {
                        items.append('<option value="' + v.ID + '">' + v.Item + '</option>');
                    });
                    break;
                case 2:
                    $.each(dx, function (kk, vv) {
                        if (ops.indexOf(vv.ID) === -1) {
                            items.append('<option value="' + vv.ID + '">' + vv.Item + '</option>');
                        }
                    });
                    break;
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        });
    }

    function onEstablecerItems(usr, mdl, op, itms) {
        var f = new FormData();
        f.append('USR', usr);
        f.append('MDL', mdl);
        f.append('OPC', op);
        f.append('OPTIONS', JSON.stringify(itms));
        $.ajax({
            url: '<?php print base_url('accesos_add_item_x_opcion_x_modulo_x_usuario'); ?>',
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: f
        }).done(function (data, x, jq) {
            swal('ATENCIÓN', 'SE HAN GUARDADO LOS CAMBIOS', 'success');
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        }).always(function () {

        });
    }
    /*FIN ITEMS*/


    /*SUBITEMS*/
    function getSubItemsXItemXOpcionXModuloXUsuario() {
        $.getJSON('<?php print base_url('accesos_subitems_x_item_x_opcion_x_modulo_x_usuario') ?>',
                {U: sixiu.val(), M: sixim.val(), O: sixio.val(), I: sixit.val()}).done(function (dx) {
            if (dx.length > 0) {
                var subitems_asignados = [];
                $.each(dx, function (k, v) {
                    $("#subitems_to").append('<option value="' + v.ID + '">' + v.SubItem + '</option>');
                    subitems_asignados.push(v.ID);
                });
                getSubItems(2, subitems_asignados, sixit.val());
            } else {
                onBeep(2);
                $.notify({
                    // options
                    message: 'ESTE USUARIO NO TIENE ASIGNADO NINGÚNA OPCIÓN EN ESTE MODULO'
                }, {
                    // settings
                    type: 'danger',
                    delay: 3500,
                    animate: {
                        enter: 'animated bounceIn',
                        exit: 'animated flipOutX'
                    },
                    placement: {
                        from: "top",
                        align: "center"
                    }
                });
                getSubItems(1, [], sixit.val());
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        });
    }

    function getSubItems(action, ops, i) {
        console.log(action, ops, i);
        var subitems = $("#subitems");
        subitems.html('');
        $.getJSON('<?php print base_url('accesos_subitems') ?>', {I: i}).done(function (dx) {
            switch (action) {
                case 1:
                    console.log('* OPCION 1 SIN SUBITEMS *');
                    console.log(dx);
                    $("#subitems_to").html('');
                    $.each(dx, function (k, v) {
                        subitems.append('<option value="' + v.ID + '">' + v.SubItem + '</option>');
                    });
                    break;
                case 2:
                    $.each(dx, function (kk, vv) {
                        if (ops.indexOf(vv.ID) === -1) {
                            subitems.append('<option value="' + vv.ID + '">' + vv.SubItem + '</option>');
                        }
                    });
                    break;
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        });
    }

    function onEstablecerSubItems(usr, mdl, op, ite, itms) {
        var f = new FormData();
        f.append('USR', usr);
        f.append('MDL', mdl);
        f.append('OPC', op);
        f.append('ITE', ite);
        f.append('OPTIONS', JSON.stringify(itms));
        $.ajax({
            url: '<?php print base_url('accesos_add_subitem_x_item_x_opcion_x_modulo_x_usuario'); ?>',
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: f
        }).done(function (data, x, jq) {
            swal('ATENCIÓN', 'SE HAN GUARDADO LOS CAMBIOS', 'success');
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        }).always(function () {

        });
    }
    /*FIN SUBITEMS*/

    /*SUBSUBITEMS*/
    function getSubSubItemsXSubItemXItemXOpcionXModuloXUsuario() {
        $.getJSON('<?php print base_url('accesos_subsubitems_x_subitems_x_item_x_opcion_x_modulo_x_usuario') ?>',
                {U: ssixiu.val(), M: ssixim.val(), O: ssixio.val(), I: ssixit.val(), SI: ssixis.val()}).done(function (dx) {
            if (dx.length > 0) {
                var subsubitems_asignados = [];
                $.each(dx, function (k, v) {
                    $("#subsubitems_to").append('<option value="' + v.ID + '">' + v.SubSubItem + '</option>');
                    subsubitems_asignados.push(v.ID);
                });
                getSubSubItems(2, subsubitems_asignados, ssixis.val());
            } else {
                onBeep(2);
                $.notify({
                    // options
                    message: 'ESTE USUARIO NO TIENE ASIGNADO NINGÚNA OPCIÓN EN ESTE MODULO'
                }, {
                    // settings
                    type: 'danger',
                    delay: 3500,
                    animate: {
                        enter: 'animated bounceIn',
                        exit: 'animated flipOutX'
                    },
                    placement: {
                        from: "top",
                        align: "center"
                    }
                });
                getSubSubItems(1, [], ssixis.val());
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        });
    }

    function getSubSubItems(action, ops, i) {
        console.log(action, ops, i);
        var subsubitems = $("#subsubitems");
        subsubitems.html('');
        $.getJSON('<?php print base_url('accesos_subsubitems') ?>', {SI: i}).done(function (dx) {
            switch (action) {
                case 1:
                    console.log('* OPCION 1 SIN SUBITEMS *');
                    console.log(dx);
                    $("#subsubitems_to").html('');
                    $.each(dx, function (k, v) {
                        subsubitems.append('<option value="' + v.ID + '">' + v.SubSubItem + '</option>');
                    });
                    break;
                case 2:
                    $.each(dx, function (kk, vv) {
                        if (ops.indexOf(vv.ID) === -1) {
                            subsubitems.append('<option value="' + vv.ID + '">' + vv.SubSubItem + '</option>');
                        }
                    });
                    break;
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        });
    }

    function onEstablecerSubSubItems(usr, mdl, op, ite, site, itms) {
        var f = new FormData();
        f.append('USR', usr);
        f.append('MDL', mdl);
        f.append('OPC', op);
        f.append('ITE', ite);
        f.append('SITE', site);
        f.append('OPTIONS', JSON.stringify(itms));
        $.ajax({
            url: '<?php print base_url('accesos_add_subsubitems_x_subitem_x_item_x_opcion_x_modulo_x_usuario'); ?>',
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: f
        }).done(function (data, x, jq) {
            swal('ATENCIÓN', 'SE HAN GUARDADO LOS CAMBIOS', 'success');
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        }).always(function () {

        });
    }
    /*FIN SUBSUBITEMS*/

</script>
<style>
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid; 
        /*border-image: linear-gradient(to bottom,  #2196F3, #cc0066, rgb(0,0,0,0)) 1 100% ;*/
        border-image: linear-gradient(to bottom,  #0099cc, #ccff00, rgb(0,0,0,0)) 1 100% ;
    }
    .btn-default{
        background-color: #8BC34A;
        color: #fff;
    }
    select.NotSelectize > option{
        font-weight: bold !important;
    }
    select > option:hover, div.option:hover{
        background-color: #007bff !important;
        font-weight: bold !important;
        color: #fff !important;
    }
    select.NotSelectize > option:hover{
        border-radius: 5px !important;
        cursor: pointer !important;
    }
</style>