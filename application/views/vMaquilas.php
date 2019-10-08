<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Maquilas</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-primary" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar"><span class="fa fa-plus"></span><br></button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Maquilas" class="table-responsive">
                <table id="tblMaquilas" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Clave</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card m-3 d-none animated fadeIn" id="pnlDatos">
    <div class="card-body text-dark">
        <form id="frmNuevo">
            <fieldset>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 float-left">
                        <legend >Maquila</legend>
                    </div>
                    <div class="col-12 col-sm-6 col-md-8" align="right">
                        <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                            <span class="fa fa-arrow-left" ></span> REGRESAR
                        </button>
                        <button type="button" class="btn btn-danger btn-sm d-none" id="btnEliminar">
                            <span class="fa fa-trash fa-1x"></span> ELIMINAR
                        </button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="d-none">
                        <input type="text"  name="ID" class="form-control form-control-sm" >
                    </div>
                    <div class="col-6 col-sm-2 col-md-2 ">
                        <label for="Clave" >Clave*</label>
                        <input type="text" class="form-control form-control-sm" id="Clave" name="Clave" required >
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 ">
                        <label for="Nombre" >Nombre*</label>
                        <input type="text" id="Nombre" name="Nombre" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-4 col-md-4 ">
                        <label for="" >Proc. Inicial*</label>
                        <select id="DepartamentoInicial" name="DepartamentoInicial" class="form-control form-control-sm required" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 ">
                        <label for="" >Proc. Final*</label>
                        <select id="DepartamentoFinal" name="DepartamentoFinal" class="form-control form-control-sm required" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-4 ">
                        <label for="" >Entrega Mat. CORTE</label>
                        <select id="EntregaMat1" name="EntregaMat1" class="form-control form-control-sm" >
                            <option value=""></option>
                            <option value="10">SI</option>
                            <option value="0">NO</option>
                        </select>
                    </div>

                    <div class="col-12 col-sm-12 col-md-4 ">
                        <label for="" >Entrega Mat. ENSUELADO</label>
                        <select id="EntregaMat2" name="EntregaMat2" class="form-control form-control-sm" >
                            <option value=""></option>
                            <option value="80">SI</option>
                            <option value="0">NO</option>
                        </select>
                    </div>

                    <div class="col-12 col-sm-12 col-md-4">
                        <label for="" >Entrega Mat. MONTADO/ADORNO</label>
                        <select id="EntregaMat3" name="EntregaMat3" class="form-control form-control-sm" >
                            <option value=""></option>
                            <option value="90">SI</option>
                            <option value="0">NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 ">
                        <label for="Direccion" >Dirección</label>
                        <input type="text" id="Direccion" name="Direccion" class="form-control form-control-sm" >
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 ">
                        <label for="Telefono" >Teléfono</label>
                        <input type="text" id="Telefono" name="Telefono" maxlength="15" class="form-control form-control-sm" >
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 ">
                        <label for="Capacidad" >Capacidad (Pares)*</label>
                        <input type="text" id="CapacidadPares" name="CapacidadPares" maxlength="15" class="form-control form-control-sm numbersOnly" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-2 col-md-2 ">

                    </div>
                    <div class="col-12 col-sm-8 col-md-8" align='center'>
                        <div class="card mb-3 mt-3">
                            <h4 class="card-header">SELECCIONAR PORCENTAJE EXTRA DE MATERIAL*</h4>
                            <div class="card-body">
                                <h5 class="card-title text-warning">Sólo puedes seleccionar una opción</h5>
                                <h6 class="card-subtitle text-muted">
                                    <select id="OpcionPorcentaje" name="OpcionPorcentaje" class="form-control form-control-sm" >
                                        <option value=""></option>
                                        <option value="1">1-POR % DIRECTO</option>
                                        <option value="2">2-POR # DE PIEZAS EN ESTILOS</option>
                                        <option value="3">3-POR RUSS SMALL</option>
                                    </select>
                                </h6>
                            </div>

                            <div class="d-none" id="Opcion1">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <label for="Nombre" >% Extra p' Producción</label>
                                        <input type="text" id="PorExtraXProduccion" name="PorExtraXProduccion" maxlength="5" class="form-control form-control-sm numbersOnly" >
                                    </li>
                                    <li class="list-group-item">
                                        <label for="Nombre" >% Extra p' Explosión y Concilia</label>
                                        <input type="text" id="PorExtraXExplosionConcilia" name="PorExtraXExplosionConcilia" maxlength="5" class="form-control form-control-sm numbersOnly" >
                                    </li>
                                    <li class="list-group-item">
                                        <label for="Nombre" >% Extra p' Fichas Técnicas</label>
                                        <input type="text" id="PorExtraXFichaTecnica" name="PorExtraXFichaTecnica" maxlength="5" class="form-control form-control-sm numbersOnly" >
                                    </li>
                                </ul>
                            </div>

                            <div class="d-none" id="Opcion2">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <label for="" >% Extra p' Bota muy Alta</label>
                                        <input type="text" id="PorExtraXBotaAlta" name="PorExtraXBotaAlta" maxlength="5" class="form-control form-control-sm numbersOnly" >
                                    </li>
                                    <li class="list-group-item">
                                        <label for="" >% Extra p' Bota</label>
                                        <input type="text" id="PorExtraXBota" name="PorExtraXBota" maxlength="5" class="form-control form-control-sm numbersOnly" >
                                    </li>
                                    <li class="list-group-item">
                                        <label for="" >% Extra de 3 a 10 piezas</label>
                                        <input type="text" id="PorExtra3a10" name="PorExtra3a10" maxlength="5" class="form-control form-control-sm numbersOnly" >
                                    </li>
                                    <li class="list-group-item">
                                        <label for="" >% Extra de 11 a 14 piezas</label>
                                        <input type="text" id="PorExtra11a14" name="PorExtra11a14" maxlength="5" class="form-control form-control-sm numbersOnly" >
                                    </li>
                                    <li class="list-group-item">
                                        <label for="" >% Extra de 15 a 18 piezas</label>
                                        <input type="text" id="PorExtra15a18" name="PorExtra15a18" maxlength="5" class="form-control form-control-sm numbersOnly" >
                                    </li>
                                    <li class="list-group-item">
                                        <label for="" >% Extra de mas de 19 piezas</label>
                                        <input type="text" id="PorExtra19a" name="PorExtra19a" maxlength="5" class="form-control form-control-sm numbersOnly" >
                                    </li>
                                </ul>
                            </div>

                            <div class="d-none" id="Opcion3">
                                <ul class="list-group list-group-flush">

                                </ul>
                            </div>

                            <div class="card-footer text-danger">
                                Ej. Sí desea darle un 15%. Capture .15
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-2 col-md-2 ">

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 ">
                        <label for="" >Recibe Material</label>
                        <input type="text" id="RecibeMaterial" name="RecibeMaterial" class="form-control form-control-sm" >
                    </div>
                    <div class="col-12 col-md-6 col-sm-6">
                        <label for="" >Estatus*</label>
                        <select id="Estatus" name="Estatus" class="form-control form-control-sm" >
                            <option value=""></option>
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="INACTIVO">INACTIVO</option>
                        </select>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-6 col-md-6 ">
                        <h6 class="text-danger">Los campos con * son obligatorios</h6>
                    </div>
                    <!--                    <div class="col-6 col-sm-6 col-md-6" align="right">
                                            <button type="button" class="btn btn-raised btn-info btn-sm" id="btnGuardar">
                                                <span class="fa fa-save "></span> GUARDAR
                                            </button>
                                        </div>-->
                    <button type="button" class="btn btn-info btn-lg btn-float" id="btnGuardar" data-toggle="tooltip" data-placement="left" title="Guardar">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/Maquilas/';
    var tblMaquilas = $('#tblMaquilas');
    var Maquilas;
    var btnNuevo = $("#btnNuevo"), btnCancelar = $("#btnCancelar"), btnEliminar = $("#btnEliminar"), btnGuardar = $("#btnGuardar");
    var pnlTablero = $("#pnlTablero"), pnlDatos = $("#pnlDatos");
    var nuevo = false;

    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();
        handleEnter();
        validacionSelectPorContenedor(pnlDatos);
        setFocusSelectToSelectOnChange('#DepartamentoInicial', '#DepartamentoFinal', pnlDatos);
        setFocusSelectToSelectOnChange('#DepartamentoFinal', '#EntregaMat1', pnlDatos);
        setFocusSelectToSelectOnChange('#EntregaMat1', '#EntregaMat2', pnlDatos);
        setFocusSelectToSelectOnChange('#EntregaMat2', '#EntregaMat3', pnlDatos);
        setFocusSelectToInputOnChange('#EntregaMat3', '#Direccion', pnlDatos);
        setFocusSelectToInputOnChange('#Estatus', '#btnGuardar', pnlDatos);

        /*FUNCIONES X BOTON*/
        btnGuardar.click(function () {
            isValid('pnlDatos');
            if (valido) {
                var frm = new FormData(pnlDatos.find("#frmNuevo")[0]);
                if (!nuevo) {
                    $.ajax({
                        url: master_url + 'onModificar',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data, x, jq) {
                        swal('ATENCIÓN', 'SE HA MODIFICADO EL REGISTRO', 'info');
                        Maquilas.ajax.reload();
                        pnlDatos.addClass("d-none");
                        pnlTablero.removeClass("d-none");
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    }).always(function () {
                        HoldOn.close();
                    });
                } else {
                    $.ajax({
                        url: master_url + 'onAgregar',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data, x, jq) {
                        pnlDatos.find("[name='ID']").val(data);
                        nuevo = false;
                        Maquilas.ajax.reload();
                        pnlDatos.addClass("d-none");
                        pnlTablero.removeClass("d-none");
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    }).always(function () {
                        HoldOn.close();
                    });
                }
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });

        btnEliminar.click(function () {
            swal({
                title: "¿Estas seguro?",
                text: "Nota: No se eliminara ninguna unidad que tenga alguna relacion con otro dato dentro del sistema",
                icon: "warning",
                buttons: {
                    cancelar: {
                        text: "Cancelar",
                        value: "cancelar"
                    },
                    eliminar: {
                        text: "Aceptar",
                        value: "eliminar"
                    }
                }
            }).then((value) => {
                switch (value) {
                    case "eliminar":
                        $.post(master_url + 'onEliminar', {ID: temp}).done(function () {
                            swal('ATENCIÓN', 'SE HA ELIMINADO EL REGISTRO', 'success');
                            Maquilas.ajax.reload();
                            pnlDatos.addClass("d-none");
                            pnlTablero.removeClass("d-none");
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
            pnlDatos.find("input").val("");
            pnlTablero.addClass("d-none");
            pnlDatos.removeClass("d-none");
            btnEliminar.addClass("d-none");
            getID();
            pnlDatos.find("[name='Clave']").addClass('disabledForms');
            pnlDatos.find("[name='Nombre']").focus();
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
            pnlDatos.find('#Opcion1').addClass('d-none');
            pnlDatos.find('#Opcion2').addClass('d-none');
            pnlDatos.find('#Opcion3').addClass('d-none');
        });

        btnCancelar.click(function () {
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass("d-none");
        });

        pnlDatos.find("[name='OpcionPorcentaje']").change(function () {
            var opcion = parseInt($(this).val());
            switch (opcion) {
                case 1:
                    pnlDatos.find('#Opcion1').removeClass('d-none');
                    pnlDatos.find('#Opcion2').addClass('d-none');
                    pnlDatos.find('#Opcion3').addClass('d-none');
                    pnlDatos.find('#PorExtraXProduccion').focus().select();

                    break;
                case 2:
                    pnlDatos.find('#Opcion2').removeClass('d-none');
                    pnlDatos.find('#Opcion1').addClass('d-none');
                    pnlDatos.find('#Opcion3').addClass('d-none');
                    pnlDatos.find('#PorExtraXBotaAlta').focus().select();
                    break;
                case 3:
                    pnlDatos.find('#Opcion3').removeClass('d-none');
                    pnlDatos.find('#Opcion1').addClass('d-none');
                    pnlDatos.find('#Opcion2').addClass('d-none');
                    break;

                default:
                    pnlDatos.find('#Opcion1').addClass('d-none');
                    pnlDatos.find('#Opcion2').addClass('d-none');
                    pnlDatos.find('#Opcion3').addClass('d-none');
                    break;
            }

        });
    });

    function init() {
        getRecords();
        getDepartamentos();
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

    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblMaquilas')) {
            tblMaquilas.DataTable().destroy();
        }
        Maquilas = tblMaquilas.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"}, {"data": "Clave"}, {"data": "Nombre"}
            ],
            "columnDefs": [
                {
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
            "scrollX": true,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [1, 'desc']/*ID*/
            ]
        });

        $('#tblMaquilas_filter input[type=search]').focus();

        tblMaquilas.find('tbody').on('click', 'tr', function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'CARGANDO...'
            });
            nuevo = false;
            tblMaquilas.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Maquilas.row(this).data();
            temp = parseInt(dtm.ID);
            $.getJSON(master_url + 'getMaquilaByID', {ID: temp}).done(function (data) {
                pnlDatos.find("input").val("");
                $.each(pnlDatos.find("select"), function (k, v) {
                    pnlDatos.find("select")[k].selectize.clear(true);
                });
                $.each(data[0], function (k, v) {
                    pnlDatos.find("[name='" + k + "']").val(v);
                    if (pnlDatos.find("[name='" + k + "']").is('select')) {
                        pnlDatos.find("[name='" + k + "']")[0].selectize.addItem($.isNumeric(v) ? parseInt(v) : v, true);
                    }
                });
                pnlTablero.addClass("d-none");
                pnlDatos.removeClass('d-none');
                btnEliminar.removeClass("d-none");

                pnlDatos.find("#Clave").addClass('disabledForms');
                pnlDatos.find("#Nombre").focus().select();
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');

            }).always(function () {
                HoldOn.close();
            });
        });
        HoldOn.close();
    }
    function getDepartamentos() {
        $.ajax({
            url: master_url + 'getDepartamentos',
            type: "POST",
            dataType: "JSON"
        }).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlDatos.find("[name='DepartamentoInicial']")[0].selectize.addOption({text: v.Departamento, value: v.Clave});
                pnlDatos.find("[name='DepartamentoFinal']")[0].selectize.addOption({text: v.Departamento, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }
</script>