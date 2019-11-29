<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-9 float-left">
                <legend class="float-left">Elimina Entrada de Compra</legend>
            </div>
            <div class="col-sm-3" align="right">
            </div>
        </div>
        <div class="row" id="Encabezado">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" data-column="1">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly" id="Tp" maxlength="1" >
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-xl-4">
                <label>Proveedor*</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Proveedor" name="Proveedor" maxlength="5" required="">
                    </div>
                    <div class="col-9">
                        <select id="sProveedor" name="sProveedor" class="form-control form-control-sm required NotSelectize" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-1" >
                <label>Docto.</label>
                <input type="text" class="form-control form-control-sm numbersOnly " id="DocMov" name="DocMov" maxlength="15" required>
            </div>
            <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-1" >
                <label>Ord Com.</label>
                <input type="text" class="form-control form-control-sm numbersOnly " disabled="" id="OrdenCompra" name="OrdenCompra" maxlength="15">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary" id="btnGuardar">
                    <i class="fa fa-check"></i> ACEPTAR
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/EliminaEntradaCompra/';
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToInputOnChange('#sProveedor', '#DocMov', pnlTablero);
        init();
        pnlTablero.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                var tp = parseInt($(this).val());
                if (tp === 1 || tp === 2) {
                    getProveedores(tp);
                    pnlTablero.find('#Proveedor').focus();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        $(this).val('').focus();
                    });
                }
            }
        });
        pnlTablero.find('#Proveedor').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtprov = $(this).val();
                if (txtprov) {
                    $.getJSON(master_url + 'onVerificarProveedor', {Proveedor: txtprov}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sProveedor")[0].selectize.addItem(txtprov, true);
                            pnlTablero.find('#DocMov').focus().select();
                        } else {
                            swal('ERROR', 'EL PROVEEDOR NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sProveedor")[0].selectize.clear(true);
                                pnlTablero.find('#Proveedor').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sProveedor").change(function () {
            if ($(this).val()) {
                pnlTablero.find('#Proveedor').val($(this).val());
                pnlTablero.find('#DocMov').focus().select();
            }
        });
        pnlTablero.find("#DocMov").keypress(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                var tp = pnlTablero.find("#Tp").val();
                var prov = pnlTablero.find("#Proveedor").val();
                if (tp !== '') {
                    if (prov !== '') {
                        onRevisarDoctoCartProv($(this), tp, prov);
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "DEBES SELECCIONAR UN PROVEEDOR",
                            icon: "error",
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                            buttons: true
                        }).then((action) => {
                            pnlTablero.find("#Proveedor").focus();
                        });
                    }
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "EL TP SÓLO DEBE SER 1 Ó 2",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        buttons: true
                    }).then((action) => {
                        pnlTablero.find("#Tp").focus();
                    });
                }

            }
        });

        btnGuardar.click(function () {
            btnGuardar.attr('disabled', true);
            isValid('pnlTablero');
            if (valido) {

                swal({
                    buttons: ["Cancelar", "Aceptar"],
                    title: 'Estás Seguro?',
                    text: "Esta acción eliminará el documento seleccionado",
                    icon: "warning",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {

                        var tp = pnlTablero.find("#Tp").val();
                        var prov = pnlTablero.find("#Proveedor").val();
                        var doc = pnlTablero.find('#DocMov').val();
                        $.post(master_url + 'onEliminarCompra', {
                            Tp: tp,
                            Proveedor: prov,
                            Doc: doc
                        }).done(function (data) {
                            btnGuardar.attr('disabled', false);
                            swal({
                                title: "DOCUMENTO ELIMINADO",
                                text: "El documento ha sido eliminado con exito",
                                icon: "success",
                                closeOnClickOutside: false,
                                closeOnEsc: false
                            }).then((action) => {
                                init();
                            });
                        }).fail(function (x, y, z) {
                            btnGuardar.attr('disabled', false);
                            console.log(x, y, z);
                        });
                    }
                });

            } else {
                btnGuardar.attr('disabled', false);
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
            }
        });

    });
    function init() {
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#Tp").focus();
    }

    function getProveedores(tp) {
        pnlTablero.find("#sProveedor")[0].selectize.clear(true);
        pnlTablero.find("#sProveedor")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sProveedor")[0].selectize.addOption({text: (tp === 1) ? v.ProveedorF : v.ProveedorI, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onRevisarDoctoCartProv(doc, tp, prov) {
        if ($(doc).val() !== '') {
            $.getJSON(master_url + 'onRevisarDoctoCartProv', {
                Doc: $(doc).val(),
                Tp: tp,
                Proveedor: prov
            }).done(function (data) {
                if (data.length > 0) {//Revisa si existe en cartera de proveedores

                    if (data[0].Estatus_Contable !== '' || parseInt(data[0].Pagos_Doc) > 0) {
                        //Si ya tiene pagos o se pasó a contabilidad ya no se puede eliminar la compra
                        swal({
                            title: "IMPOSIBLE ELIMINAR",
                            text: "El documento ya tiene pagos o se pasó a Contabilidad",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            init();
                        });
                    } else {
                        //se puede eliminar... por lo tanto buscamos la compra para corroborar que exista
                        $.getJSON(master_url + 'onRevisarDoctoCompra', {
                            Doc: $(doc).val(),
                            Tp: tp,
                            Proveedor: prov
                        }).done(function (data) {
                            if (data.length > 0) { //si existe la compra
                                pnlTablero.find("#OrdenCompra").val(data[0].OrdenCompra);
                                btnGuardar.focus();
                            } else {//Si no existe la compra mandar mensaje de alerta
                                swal({
                                    title: "IMPOSIBLE ELIMINAR",
                                    text: "El documento no existe en Compras",
                                    icon: "warning",
                                    closeOnClickOutside: false,
                                    closeOnEsc: false
                                }).then((action) => {
                                    pnlTablero.find("#DocMov").val('').focus();
                                });
                            }
                        });
                    }
                } else {
                    swal({
                        title: "NO EXISTE DOCUMENTO EN CARTERA DE PROVEEDORES",
                        text: "Selecciona un documento válido",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        $(doc).val('').focus();
                    });

                }
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });
        }
    }
</script>



