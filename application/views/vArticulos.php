<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Articulos</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-success" id="btnHistoryPrecios"><span class="fa fa-dollar-sign"></span> HISTÓRICO DE PRECIOS</button>
                <button type="button" class="btn btn-primary" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar"><span class="fa fa-plus"></span><br></button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Articulos" class="table-responsive">
                <table id="tblArticulos" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Clave</th>
                            <th>Descripción</th>
                            <th>Unidad</th>
                            <th>Precio</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="d-none animated fadeIn text-dark" style="z-index: 99 !important" id="pnlDatos">

    <!-- PRIMER CONTENEDOR-->
    <div class="card  m-3 ">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 float-left">
                    <legend >Articulos</legend>
                </div>
                <div class="col-12 col-sm-6 col-md-8" align="right">
                    <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                        <span class="fa fa-arrow-left" ></span> REGRESAR
                    </button>
                    <button type="button" class="btn btn-danger btn-sm d-none" id="btnEliminar">
                        <span class="fa fa-trash fa-1x"></span> ELIMINAR
                    </button>
                    <button type="button" class="btn btn-raised btn-success btn-sm d-none" id="btnIgualaPrecios">
                        <span class="fa fa-money-bill"></span> IGUALAR PRECIOS A MAQUILAS = MAQ-1
                    </button>
                    <button type="button" class="btn btn-raised btn-info btn-sm d-none" id="btnGeneraPreciosMaq">
                        <span class="fa fa-cogs"></span> GENERAR PRECIO MAQUILAS = MAQ-1
                    </button>
                    <button type="button" class="btn btn-primary" id="btnNuevoDos">
                        <span class="fa fa-plus"></span> NUEVO
                    </button>
                </div>
            </div>
            <hr>
            <form id="frmNuevo">
                <div class="row">
                    <div class="d-none">
                        <input type="text" id="ID" name="ID" class="form-control form-control-sm" >
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-1">
                        <label for="Clave" >Clave*</label>
                        <input type="text" class="form-control form-control-sm numbersOnly disabledForms" id="Clave" name="Clave" required="" placeholder="20180814">
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2">
                        <label for="" >Depto*</label>
                        <select id="Departamento" name="Departamento" class="form-control form-control-sm required" required="">
                            <option value=""></option>
                            <option value="10">10 PIEL/FORRO</option>
                            <option value="80">80 SUELA/PLANTA</option>
                            <option value="90">90 PELETERIA</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >Descripción*</label>
                        <input type="text" class="form-control form-control-sm" id="Descripcion" name="Descripcion" required="" >

                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                        <label for="" >Grupo*</label>
                        <select id="Grupo" name="Grupo" class="form-control form-control-sm required" required="">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-xl-2">
                        <label for="" >Tipo*</label>
                        <select id="TipoArticulo" name="TipoArticulo" class="form-control form-control-sm required"  required="">
                            <option value=""></option>
                            <option value="0">0-PRODUCCIÓN</option>
                            <option value="222">222-PROTOTIPO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-xl-2">
                        <label for="" >Estatus*</label>
                        <select id="Estatus" name="Estatus" class="form-control form-control-sm required"  required="">
                            <option value=""></option>
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="INACTIVO">INACTIVO</option>
                        </select>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                        <label for="" >Unidad*</label>
                        <select id="UnidadMedida" name="UnidadMedida" class="form-control form-control-sm required" required="">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                        <label for="" >Moneda*</label>
                        <select id="Tmnda" name="Tmnda" class="form-control form-control-sm required" required="">
                            <option value=""></option>
                            <option value="1">1-Nacional</option>
                            <option value="2">2-Dolar</option>
                            <option value="3">3-Libra</option>
                            <option value="4">4-Jen</option>
                            <option value="5">5-Euro</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 col-xl-1">
                        <label for="Min" >Min</label>
                        <input type="text" class="form-control form-control-sm" id="Min" name="Min" >
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 col-xl-1">
                        <label for="Max" >Max</label>
                        <input type="text" class="form-control form-control-sm" id="Max" name="Max" >
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                        <label for="" >Fecha Alta</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Registro">
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                        <label for="" >Temporada</label>
                        <select id="Temporada" name="Temporada" class="form-control form-control-sm">
                            <option value=""></option>
                            <option value="1">1-PRIMAVERA/VERANO</option>
                            <option value="2">2-OTOÑO/INVIERNO</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-3 d-none" align="center">
                        <legend>Proveedores del Artículo</legend>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-xl-4">
                        <label for="Max" >Proveedor 1</label>
                        <select id="ProveedorUno" name="ProveedorUno" class="form-control form-control-sm mb-2 required" required="">
                            <option value=""></option>
                        </select>
                        <input type="text" class="form-control form-control-sm numbersOnly mb-2" id="PrecioUno" name="PrecioUno"  placeholder="Precio pactado">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-xl-4">
                        <label for="Max" >Proveedor 2</label>
                        <select id="ProveedorDos" name="ProveedorDos" class="form-control form-control-sm mb-2" required="">
                            <option value=""></option>
                        </select>
                        <input type="text" class="form-control form-control-sm numbersOnly mb-2" id="PrecioDos" name="PrecioDos"   placeholder="Precio pactado">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-xl-4">
                        <label for="Max" >Proveedor 3</label>
                        <select id="ProveedorTres" name="ProveedorTres" class="form-control form-control-sm mb-2" required="">
                            <option value=""></option>
                        </select>
                        <input type="text" class="form-control form-control-sm numbersOnly mb-2" id="PrecioTres" name="PrecioTres"   placeholder="Precio pactado">
                    </div>
                    <div id="ProveedorUltimaCompra" class="col-12 col-sm-12 col-md-12 col-xl-12 d-none">
                        <p>Proveedor U.C</p>
                        <p class="text-info">* * * * *</p>
                    </div>
                </div>
                <div class="row d-none">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-3" align="center">
                        <legend>Ubicación del Almacén</legend>
                    </div>
                    <div class="col-12 col-sm-3 col-md-3 col-xl-3 mb-3">
                        <label for="Max" >Proveedor 3</label>
                        <input type="text" class="form-control form-control-sm" id="UbicacionUno" name="UbicacionUno" placeholder="UBICACION 1">
                    </div>
                    <div class="col-12 col-sm-3 col-md-3 col-xl-3 mb-3">
                        <input type="text" class="form-control form-control-sm" id="UbicacionDos" name="UbicacionDos"  placeholder="UBICACION 2">
                    </div>
                    <div class="col-12 col-sm-3 col-md-3 col-xl-3 mb-3">
                        <input type="text" class="form-control form-control-sm" id="UbicacionTres" name="UbicacionTres"  placeholder="UBICACION 3">
                    </div>
                    <div class="col-12 col-sm-3 col-md-3 col-xl-3 mb-3">
                        <input type="text" class="form-control form-control-sm" id="UbicacionCuatro" name="UbicacionCuatro"  placeholder="UBICACION 4">
                    </div>
                </div>
                <div class="row pt-1">
                    <div class="col-6 col-md-6 ">
                        <h6 class="text-danger">Los campos con * son obligatorios</h6>
                    </div>
                </div>
            </form>

            <div class="d-none" id="pnlDatosDetalle">
                <button type="button" class="btn btn-info btn-lg btn-float" id="btnGuardar" data-toggle="tooltip" data-placement="left" title="Guardar">
                    <i class="fa fa-save"></i>
                </button>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label for="Maquila" >Maquila</label>
                        <!--<input type="text" class="form-control form-control-sm" id="Maquila" name="Maquila" required placeholder="Maquila 1">-->
                        <select id="Maquila" name="Maquila" class="form-control form-control-sm" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-1">
                        <label for="Precio" >Precio</label>
                        <input type="text" class="form-control form-control-sm numbersOnly" id="Precio" name="Precio" placeholder="0.0">
                    </div>
                    <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 my-2 d-sm-block pt-3">
                        <button type="button" id="btnAgregarPrecio" class="btn btn-primary btn-sm d-sm-block "><span class="fa fa-plus"></span></button>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-2 table-responsive">
                        <table id="tblPrecioVentaParaMaquilas" class="table table-sm display" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Maquila</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Estatus</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Maquila</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var master_url = base_url + 'index.php/Articulos/';
    var tblArticulos = $('#tblArticulos');
    var Articulos;
    var btnNuevo = $("#btnNuevo"), btnNuevoDos = $("#btnNuevoDos"), btnCancelar = $("#btnCancelar"), btnEliminar = $("#btnEliminar"), btnGuardar = $("#btnGuardar"),
            btnIgualaPrecios = $("#btnIgualaPrecios"), btnGeneraPreciosMaq = $("#btnGeneraPreciosMaq");
    var pnlTablero = $("#pnlTablero"), pnlDatos = $("#pnlDatos"), pnlDatosDetalle = $("#pnlDatosDetalle");
    var PrecioVentaParaMaquilas, tblPrecioVentaParaMaquilas = $("#tblPrecioVentaParaMaquilas");
    var nuevo = false, precio_actual = 0;
    var ClaveArticulo = 0;
    var btnHistoryPrecios = $('#btnHistoryPrecios');

    $(document).ready(function () {
        /*HISTORIAL DE PRECIOS*/
        btnHistoryPrecios.click(function () {
            $('#mdlImprimeHistoryPrecios').modal('show');
        });


        /*FUNCIONES INICIALES*/
        init();
        handleEnterDiv(pnlTablero);
        handleEnterDiv(pnlDatos);
        handleEnterDiv(pnlDatosDetalle);
        handleEnterDiv($('#mdlImprimeHistoryPrecios'));
        validacionSelectPorContenedor(pnlDatos);
        setFocusSelectToInputOnChange('#Departamento', '#Descripcion', pnlDatos);
        setFocusSelectToSelectOnChange('#Grupo', '#TipoArticulo', pnlDatos);
        setFocusSelectToSelectOnChange('#TipoArticulo', '#UnidadMedida', pnlDatos);
        setFocusSelectToSelectOnChange('#UnidadMedida', '#Tmnda', pnlDatos);
        setFocusSelectToSelectOnChange('#Temporada', '#ProveedorUno', pnlDatos);
        setFocusSelectToInputOnChange('#Tmnda', '#Min', pnlDatos);
        setFocusSelectToInputOnChange('#ProveedorUno', '#PrecioUno', pnlDatos);
        setFocusSelectToInputOnChange('#ProveedorDos', '#PrecioDos', pnlDatos);
        setFocusSelectToInputOnChange('#ProveedorTres', '#PrecioTres', pnlDatos);
        setFocusSelectToInputOnChange('#Maquila', '#Precio', pnlDatosDetalle);

        /*FUNCIONES X BOTON*/


        pnlTablero.find("#tblArticulos_filter").find('input[type="search"]').on('keydown', function (e) {
            if ($(this).val() && e.keyCode === 13) {
                getArticuloByID($(this).val());
            }
        });

        btnGeneraPreciosMaq.click(function () {
            swal({
                title: "¿Estas seguro?",
                text: "Nota: Esta acción no se puede deshacer",
                icon: "warning",
                buttons: {
                    cancelar: {
                        text: "Cancelar",
                        value: "cancelar"
                    },
                    cambiar: {
                        text: "Aceptar",
                        value: "cambiar"
                    }
                }
            }).then((value) => {
                switch (value) {
                    case "cambiar":
                        HoldOn.open({theme: 'sk-cube', message: 'ESPERE...'});
                        $.post(master_url + 'onGenerarPreciosBaseMaquilaUno', {Clave: pnlDatos.find("#Clave").val()}).done(function (data) {
                            console.log(data);
                            if (parseInt(data) === 1) {
                                swal('ATENCIÓN', 'DEBE DE CAPTURAR EL PRECIO PARA LA MAQUILA 1', 'error');
                            } else {
                                /*Si todo sale bien ejecutamos esto para actualizar*/
                                //PrecioVentaParaMaquilas.clear().draw();
                                getDetalleByID(pnlDatos.find("#Clave").val());
                                HoldOn.close();
                                swal('ATENCIÓN', 'SE HAN GENERADO LOS PRECIOS EN BASE A MAQUILA 1', 'success');
                            }
                            HoldOn.close();
                        }).fail(function (x, y, z) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x.responseText);
                            HoldOn.close();
                        });
                        console.log('CAMBIANDO PRECIO...');
                        break;
                    case "cancelar":
                        swal.close();
                        HoldOn.close();
                        break;
                }
            });
        });

        btnIgualaPrecios.click(function () {
            swal({
                title: "¿Estas seguro?",
                text: "Nota: Esta acción no se puede deshacer",
                icon: "warning",
                buttons: {cancelar: {text: "Cancelar",
                        value: "cancelar"
                    },
                    cambiar: {text: "Aceptar",
                        value: "cambiar"
                    }
                }
            }).then((value) => {
                switch (value) {
                    case "cambiar":
                        HoldOn.open({
                            theme: 'sk-cube',
                            message: 'ESPERE...'
                        });
                        $.post(master_url + 'onIgualarPrecios', {Clave: pnlDatos.find("#Clave").val()}).done(function (data) {
                            //PrecioVentaParaMaquilas.clear().draw();
                            getDetalleByID(pnlDatos.find("#Clave").val());
                            HoldOn.close();
                            swal('ATENCIÓN', 'SE HAN CAMBIADO LOS PRECIOS A MAQUILA 1', 'success');
                        }).fail(function (x, y, z) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x.responseText);
                            HoldOn.close();
                        });
                        console.log('CAMBIANDO PRECIO...');
                        break;
                    case "cancelar":
                        swal.close();
                        HoldOn.close();
                        break;
                }
            });
        });

        pnlDatosDetalle.find("#btnAgregarPrecio").click(function () {
            if (!nuevo) {
                var Maquila = pnlDatosDetalle.find("#Maquila"), Precio = pnlDatosDetalle.find("#Precio");
                /*COMPROBAR SI YA SE AGREGÓ*/
                var existe = false;
                if (pnlDatosDetalle.find("#tblPrecioVentaParaMaquilas tbody tr").length > 0) {
                    PrecioVentaParaMaquilas.rows().every(function (rowIdx, tableLoop, rowLoop) {
                        var data = this.data();
                        if (parseInt(data[4]) === parseInt(Maquila.val())) {
                            existe = true;
                            return false;
                        }
                    });
                }
                if (!existe) {
                    if (Maquila.val() !== '' && Precio.val()) {
                        var btn = '<button type="button" class="btn btn-danger" onclick="onEliminarDetalleSN(this)"><span class="fa fa-trash"></span></button>';
                        PrecioVentaParaMaquilas.row.add([
                            0,
                            Maquila.find("option:selected").text(),
                            $.number(Precio.val(), 2, '.', ','),
                            'NUEVO',
                            btn, Maquila.val()]).draw(false);

                        Precio.val('');
                        btnGuardar.trigger('click');
                        btnIgualaPrecios.removeClass("d-none");
                        btnGeneraPreciosMaq.removeClass("d-none");
                        Maquila[0].selectize.focus();
                        Maquila[0].selectize.clear(true);
                    } else {
                        swal('ATENCIÓN', 'DEBE DE ESTABLECER UNA MAQUILA Y UN PRECIO', 'warning').then((action) => {
                            (Maquila.val() === '') ? Maquila[0].selectize.focus() : Precio.focus();
                        });
                    }
                } else {
                    swal('ATENCIÓN', 'ESTA MAQUILA YA HA SIDO AGREGADA', 'warning').then((action) => {
                        Maquila[0].selectize.focus();
                        Maquila[0].selectize.clear(true);
                    });
                }
            } else {
                swal('ATENCIÓN', 'DEBE DE GUARDAR EL ARTICULO ANTES', 'warning').then((action) => {
                    btnGuardar.focus();
                });
            }

        });

        btnGuardar.click(function () {
            onDisable(btnGuardar);
            isValid('pnlDatos');
            onOpenOverlay('Guardando...');
            if (valido) {
                var frm = new FormData(pnlDatos.find("#frmNuevo")[0]);
                if (!nuevo) {
                    if (PrecioVentaParaMaquilas.data().count()>0) {
                        var precios = [];
                        $.each(tblPrecioVentaParaMaquilas.find("tbody tr"), function (k, v) {
                            var r = PrecioVentaParaMaquilas.row($(this)).data();

                            if (r[3] === 'NUEVO') {
                                precios.push({
                                    Maquila: r[5],
                                    Precio: r[2]
                                });
                                console.log(precios);
                            }
                        });
                        frm.append('Precios', JSON.stringify(precios));
                    } 
                    $.ajax({
                        url: master_url + 'onModificar',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data, x, jq) {
                        console.log(data);
                        onCloseOverlay();
                        onEnable(btnGuardar);
//                        swal('ATENCIÓN', 'SE HAN GUARDADO LOS CAMBIOS', 'info');
//                        nuevo = false;
//                        PrecioVentaParaMaquilas.clear().draw();
                        onNotifyOld('fa fa-check', 'SE HAN GUARDADO LOS CAMBIOS', 'success')
                        //pnlDatos.addClass("d-none");
                        //pnlDatosDetalle.addClass('d-none');
                        //pnlTablero.removeClass("d-none");
                    }).fail(function (x, y, z) {
                        onEnable(btnGuardar);
                        console.log(x, y, z);
                    }).always(function () {
                        onEnable(btnGuardar);
                        HoldOn.close();
                        onCloseOverlay();
                    });
                } else {
                    var precios = [];
                    if (parseFloat(pnlDatos.find("#PrecioUno").val()) <= 0 && pnlDatos.find("#ProveedorUno").val() &&
                            parseFloat(pnlDatos.find("#PrecioDos").val()) <= 0 && pnlDatos.find("#ProveedorDos").val() &&
                            parseFloat(pnlDatos.find("#PrecioTres").val()) <= 0 && pnlDatos.find("#ProveedorTres").val() ||
                            pnlDatos.find("#PrecioUno").val() === '' && pnlDatos.find("#ProveedorUno").val() &&
                            pnlDatos.find("#PrecioDos").val() === '' && pnlDatos.find("#ProveedorDos").val() &&
                            pnlDatos.find("#PrecioTres").val() === '' && pnlDatos.find("#ProveedorTres").val())
                    {
                        onCampoInvalido(pnlDatos, "NO SE PUEDE AGREGAR UN ARTICULO SIN UN PROVEEDOR Y PRECIO (js).", function () {
                            if (!pnlDatos.find("#PrecioUno").val()) {
                                pnlDatos.find("#PrecioUno").focus().select();
                                onEnable(btnGuardar);
                                return;
                            } else if (!pnlDatos.find("#PrecioDos").val()) {
                                pnlDatos.find("#PrecioDos").focus().select();
                                onEnable(btnGuardar);
                                return;
                            } else if (!pnlDatos.find("#PrecioTres").val()) {
                                pnlDatos.find("#PrecioTres").focus().select();
                                onEnable(btnGuardar);
                                return;
                            }
                        });
                        return;
                    } else {
                        frm.append('Precios', JSON.stringify(precios));
                        $.ajax({
                            url: master_url + 'onAgregar',
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: frm
                        }).done(function (data, x, jq) {
                            onCloseOverlay();
                            var r = JSON.parse(data);
                            switch (parseInt(r.ESTATUS))
                            {
                                case 0:
                                    onCampoInvalido(pnlDatos, r.MENSAJE, function () {
                                        onEnable(btnGuardar);
                                    });
                                    return;
                                    break;
                                case 1:
                                    pnlDatos.find("[name='ID']").val(data);
                                    nuevo = false;
                                    swal({
                                        title: "ATENCIÓN",
                                        text: r.MENSAJE,
                                        icon: "success",
                                        closeOnClickOutside: false,
                                        closeOnEsc: false
                                    }).then((action) => {
                                        onEnable(btnGuardar);
                                        ClaveArticulo = pnlDatos.find('#Clave').val();
                                        pnlDatosDetalle.find('#Maquila')[0].selectize.focus();
                                        Articulos.ajax.reload(function () {
                                        });
                                    });
                                    break;
                            }
                        }).fail(function (x, y, z) {
                            onCloseOverlay();
                            onEnable(btnGuardar);
                            console.log(x, y, z);
                        }).always(function () {
                            onEnable(btnGuardar);
                            HoldOn.close();
                        });
                    }
                }
            } else {
                onCloseOverlay();
                onCampoInvalido(pnlDatos, "DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS", function () {
                    onEnable(btnGuardar);
                });
            }
        });

        btnEliminar.click(function () {
            swal({
                title: "¿Estas seguro?",
                text: "Nota: No se eliminara ninguna Articulo que tenga alguna relacion con otro dato dentro del sistema",
                icon: "warning",
                buttons: {cancelar: {text: "Cancelar",
                        value: "cancelar"
                    },
                    eliminar: {text: "Finalizar",
                        value: "eliminar"
                    }
                }
            }).then((value) => {
                switch (value) {
                    case "eliminar":
                        $.post(master_url + 'onEliminar', {ID: temp}).done(function () {
                            swal('ATENCIÓN', 'SE HA ELIMINADO EL REGISTRO', 'success');
                            PrecioVentaParaMaquilas.clear().draw();
                            pnlDatos.addClass("d-none");
                            pnlDatosDetalle.addClass('d-none');
                            pnlTablero.removeClass("d-none");
                            Articulos.ajax.reload();
                            $('#tblArticulos_filter input[type=search]').focus().select();
                        }).fail(function (x, y, z) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x.responseText);
                        });
                        break;
                    case "cancelar":
                        swal.close();
                        break;
                }
            });
        });

        btnNuevo.click(function () {
            nuevo = true;
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
            pnlDatos.find("input,textarea").val("");
            pnlTablero.addClass("d-none");
            pnlDatos.removeClass("d-none");
            pnlDatosDetalle.removeClass("d-none");
            btnEliminar.addClass("d-none");
            pnlDatos.find("#Departamento")[0].selectize.focus();
            PrecioVentaParaMaquilas.clear().draw();
            getID();
            $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
            btnIgualaPrecios.addClass("d-none");
            btnGeneraPreciosMaq.addClass("d-none");
            pnlDatos.find("#UnidadMedida")[0].selectize.enable();
            pnlDatos.find("#PrecioUno").prop("readonly", false);
            pnlDatos.find("#PrecioDos").prop("readonly", false);
            pnlDatos.find("#PrecioTres").prop("readonly", false);
        });
        btnNuevoDos.click(function () {
            nuevo = true;
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
            pnlDatos.find("input,textarea").val("");
            btnEliminar.addClass("d-none");
            pnlDatos.find("#Departamento")[0].selectize.focus();
            PrecioVentaParaMaquilas.clear().draw();
            getID();
            $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
            btnIgualaPrecios.addClass("d-none");
            btnGeneraPreciosMaq.addClass("d-none");
            pnlDatos.find("#UnidadMedida")[0].selectize.enable();
            pnlDatos.find("#PrecioUno").prop("readonly", false);
            pnlDatos.find("#PrecioDos").prop("readonly", false);
            pnlDatos.find("#PrecioTres").prop("readonly", false);
        });

        btnCancelar.click(function () {
            PrecioVentaParaMaquilas.clear().draw();
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass("d-none");
            pnlDatosDetalle.addClass("d-none");
            temp = 0;
            ClaveArticulo = 0;
            $('#tblArticulos_filter input[type=search]').focus().select();
        });
    });


    function init() {
        getRecords();
        getGrupos();
        getUnidades();
        getProveedores();
        getMaquilas();
        /*INICIALIZAR DETALLE*/
        PrecioVentaParaMaquilas = tblPrecioVentaParaMaquilas.DataTable({

            "dom": 'rti',
            buttons: buttons,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 25,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [[4, 'asc']/*ID*/
            ],
            "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [3],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [4],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [5],
                    "visible": false,
                    "searchable": false
                }
            ],
            createdRow: function (row, data, dataIndex, cells) {
                var event;
                if (isMobile) {
                    $(this).find("td:eq(1)").touch();
                    event = 'tap';
                } else {
                    event = 'dblclick';
                }
                if (!nuevo) {
                    if (seg === 1) {
                        $(row).find("td").eq(1).on(event, function () {
                            var r = PrecioVentaParaMaquilas.row(row).data();
                            var input = '<input type="text" class="form-control form-control-sm numbersOnly" maxlength="10" name="Precio" autofocus>';
                            var exist = $(this).find("#Precio").val();
                            var celda = $(this);
                            var componente = tblPrecioVentaParaMaquilas.find("[name='Precio']");
                            if (componente.val() !== undefined) {
                                var valor = componente.val();
                                var padre = componente.parent();
                                padre.html(valor);
                            }
                            if (exist === undefined && celda.text() !== '') {
                                var vActual = celda.text();
                                celda.html(input);
                                var input_precio = celda.find("[name='Precio']");
                                input_precio.val(getNumberFloat(vActual));
                                precio_actual = vActual;
                                var padre = celda.parent();
                                input_precio.focus().select();
                                input_precio.focusout(function () {
                                    if (precio_actual !== vActual) {
                                        onModificarPrecioMaquila(r, padre, celda, this);
                                    } else {
                                        celda.html(precio_actual);
                                    }
                                }).change(function () {
                                    onModificarPrecioMaquila(r, padre, celda, this);
                                }).keyup(function (e) {
                                    if (e.keyCode === 13) {
                                        onModificarPrecioMaquila(r, padre, celda, this);
                                    }
                                });
                            }
                        });
                    }
                }
            }
        });
    }
    function onModificarPrecioMaquila(r, padre, celda, field) {
        var input = $(field);
        var v = (input.val());
        if (v !== '' && $.isNumeric(v)) {
            swal({
                title: "¿Estas seguro?",
                text: "Nota: Al cambiar un precio puede afectar las fichas tecnicas que contengan este articulo",
                icon: "warning",
                buttons: {cancelar: {text: "Cancelar",
                        value: "cancelar"
                    },
                    aceptar: {text: "Aceptar",
                        value: "aceptar"
                    }
                }
            }).then((value) => {
                switch (value) {
                    case "aceptar":
                        var precio_format = $.number(v, 2, '.', ',');
                        celda.html(precio_format);
                        PrecioVentaParaMaquilas.cell(padre, 2).data(precio_format).draw();
                        onEditarPrecioPorMaquila({PARENT: temp, ID: r[0], CELDA: 'PRECIO', VALOR: v});
                        break;
                    case "cancelar":
                        var precio_format = $.number(precio_actual, 2, '.', ',');
                        celda.html(precio_format);
                        PrecioVentaParaMaquilas.cell(padre, 2).data(precio_actual).draw();
                        swal.close();
                        input.focus();
                        break;
                }
            });
        } else {
            input.val('');
            swal({
                title: 'ATENCIÓN',
                text: "NO ES UN PRECIO VÁLIDO",
                icon: "warning",
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then((action) => {
                var precio_format = $.number(precio_actual, 2, '.', ',');
                celda.html(precio_format);
                PrecioVentaParaMaquilas.cell(padre, 2).data(precio_actual).draw();
            });
        }
    }
    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblArticulos')) {
            tblArticulos.DataTable().destroy();
        }
        Articulos = tblArticulos.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {"url": master_url + 'getRecords',
                "dataSrc": ""
            },
            "columns": [{"data": "ID"}, {"data": "Clave"}, {"data": "Descripcion"}, {"data": "Unidad"}, {"data": "Precio"}, {"data": "Estatus"}
            ],
            "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 20,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [[1, 'desc']/*ID*/
            ],
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        $('#tblArticulos_filter input[type=search]').focus().select();

        tblArticulos.find('tbody').on('click', 'tr', function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'CARGANDO...'
            });
            nuevo = false;
            tblArticulos.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Articulos.row(this).data();
            ClaveArticulo = parseInt(dtm.Clave);
            getArticuloByID(ClaveArticulo);

        });

    }

    function getArticuloByID(ClaveArticulo) {
        $.getJSON(master_url + 'getArticuloByID', {ID: ClaveArticulo}).done(function (data) {
            if (data.length > 0) {
                pnlDatos.find("input").val("");
                $.each(pnlDatos.find("select"), function (k, v) {
                    pnlDatos.find("select")[k].selectize.clear(true);
                });
                $.each(pnlDatosDetalle.find("select"), function (k, v) {
                    pnlDatosDetalle.find("select")[k].selectize.clear(true);
                });
                $.each(data[0], function (k, v) {
                    pnlDatos.find("[name='" + k + "']").val(v);
                    if (pnlDatos.find("[name='" + k + "']").is('select')) {
                        pnlDatos.find("[name='" + k + "']")[0].selectize.addItem(v, true);
                    }
                });
                pnlDatos.find("#Registro").val(data[0].Registro);
                btnIgualaPrecios.removeClass("d-none");
                btnGeneraPreciosMaq.removeClass("d-none");
                pnlTablero.addClass("d-none");
                pnlDatos.removeClass('d-none');
                pnlDatosDetalle.removeClass('d-none');
                pnlDatos.find("#Departamento")[0].selectize.focus();

                /*DESHABILITAR CAMPOS CLAVE DEL ARTICULO*/
                if (seg === 0) {
                    pnlDatos.find("#UnidadMedida")[0].selectize.disable();
                    pnlDatos.find("#PrecioUno").prop("readonly", true);
                    pnlDatos.find("#PrecioDos").prop("readonly", true);
                    pnlDatos.find("#PrecioTres").prop("readonly", true);
                }
                var user = '<?php print $_SESSION["USERNAME"]; ?>';

                if (user === 'ARABAR') {
                    pnlDatos.find("#UnidadMedida")[0].selectize.enable();
                    pnlDatos.find("#PrecioUno").prop("readonly", false);
                    pnlDatos.find("#PrecioDos").prop("readonly", false);
                    pnlDatos.find("#PrecioTres").prop("readonly", false);
                }


                getDetalleByID(ClaveArticulo);
            } else {
                iMsg('NO EXISTE EL REGISTRO', 'w', function () {
                    $('#tblArticulos_filter input[type=search]').val('').focus().select();
                });
            }

        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        }).always(function () {
            HoldOn.close();
        });
    }
    /*DETALLE*/
    function getDetalleByID(IDX) {
        PrecioVentaParaMaquilas.rows().remove().draw();
        $.getJSON(master_url + 'getDetalleByID', {ID: IDX}).done(function (data) {
            if (data.length > 0) {
                $.each(data, function (k, v) {
                    PrecioVentaParaMaquilas.row.add([v.ID, v.Maquila, v.Precio, v.Estatus, v.ClaveMaquila, '<button type="button" class="btn btn-danger" onclick="onEliminarDetalle(' + v.ID + ',this)"><span class="fa fa-trash"></span></button>', v.Maquila]).draw(false);
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        }).always(function () {
            $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
        });
    }
    function getGrupos() {
        $.getJSON(master_url + 'getGrupos').done(function (data) {
            $.each(data, function (k, v) {
                pnlDatos.find("#Grupo")[0].selectize.addOption({text: v.Grupo, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        }).always(function () {
        });
    }
    function getUnidades() {
        $.getJSON(master_url + 'getUnidades').done(function (data) {
            $.each(data, function (k, v) {
                pnlDatos.find("#UnidadMedida")[0].selectize.addOption({text: v.Unidad, value: v.ID});
            });
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        }).always(function () {
        });
    }
    function getProveedores() {
        $.getJSON(master_url + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                pnlDatos.find("#ProveedorUno")[0].selectize.addOption({text: v.Proveedor, value: v.ID});
                pnlDatos.find("#ProveedorDos")[0].selectize.addOption({text: v.Proveedor, value: v.ID});
                pnlDatos.find("#ProveedorTres")[0].selectize.addOption({text: v.Proveedor, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        }).always(function () {
        });
    }
    function getMaquilas() {
        $.getJSON(master_url + 'getMaquilas', {ID: temp}).done(function (data) {
            $.each(data, function (k, v) {
                pnlDatosDetalle.find("#Maquila")[0].selectize.addOption({text: v.Maquila, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        }).always(function () {
        });
    }
    function getID() {
        $.getJSON(master_url + 'getID').done(function (data, x, jq) {
            if (data.length > 0) {
                var ID = $.isNumeric(data[0].CLAVE) ? parseInt(data[0].CLAVE) + 1 : 1;
                pnlDatos.find("#Clave").val(ID);
            } else {
                pnlDatos.find("#Clave").val('1');
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }
    function onEliminarDetalle(e, c) {
        swal({
            title: "¿Estas seguro?",
            text: "Nota: Esta acción no se puede deshacer",
            icon: "warning",
            buttons: {cancelar: {text: "Cancelar",
                    value: "cancelar"
                },
                eliminar: {text: "Finalizar",
                    value: "eliminar"
                }
            }
        }).then((value) => {
            switch (value) {
                case "eliminar":
                    $.post(master_url + 'onEliminarDetalle', {ID: e}).done(function () {
                        swal('ATENCIÓN', 'SE HA ELIMINADO EL REGISTRO', 'success');
                        PrecioVentaParaMaquilas.row($(c).parents('tr')).remove().draw();
                    }).fail(function (x, y, z) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                    break;
                case "cancelar":
                    swal.close();
                    break;
            }
        });
    }
    function onEliminarDetalleSN(e) {
        PrecioVentaParaMaquilas.row($(e).parents('tr')).remove().draw();
    }
    function onEditarPrecioPorMaquila(x) {
        $.post(master_url + 'onEditarPrecioPorMaquila', x).done(function (data) { }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }
</script>
<style>
    .selectize-input {
        border: 1px solid #9E9E9E;
    }
    .form-control {
        border: 1px solid #9E9E9E;
    }
    .badge {
        font-size: 12px;
    }
</style>