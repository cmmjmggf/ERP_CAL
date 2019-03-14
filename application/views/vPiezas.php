<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Piezas</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-primary" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar"><span class="fa fa-plus"></span><br></button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Piezas" class="table-responsive">
                <table id="tblPiezas" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Clave</th>
                            <th>Descripción</th>
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
                        <legend >Pieza</legend>
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
                    <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                        <label for="Clave" >Clave*</label>
                        <input type="text" class="form-control form-control-sm" id="Clave" name="Clave" required>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                        <label for="Descripcion" >Descripción*</label>
                        <input type="text" id="Descripcion" name="Descripcion" class="form-control form-control-sm" placeholder="" required>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >Departamento*</label>
                        <select id="Departamento" name="Departamento" class="form-control form-control-sm" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >Clasificación</label>
                        <select id="Clasificacion" name="Clasificacion" class="form-control form-control-sm">
                            <option value=""></option>
                            <option value="1">1ra</option>
                            <option value="2">2da</option>
                            <option value="3">3ra</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >Tipo Pieza Tallas</label>
                        <select id="TipoPiezaTallas" name="TipoPiezaTallas" class="form-control form-control-sm">
                            <option value=""></option>
                            <option value="1">SUELA</option>
                            <option value="2">PLANTA</option>
                            <option value="3">ENTRESUELA</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >Rango</label>
                        <select id="Rango" name="Rango" class="form-control form-control-sm">
                            <option value=""></option>
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                        <label for="" class="text-info font-weight-bold badge" >Para verificación de piezas  cuando realiza una copia de ficha tecnica a ficha tecnica*</label>
                        <select id="Obliga" name="Obliga" class="form-control form-control-sm" >
                            <option value=""></option>
                            <option value="0">0 = No verifica</option>
                            <option value="1">1 = Si verifica</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <p class="text-danger font-weight-bold">*Nota: Si modifica el nombre de una pieza, ese nombre de la pieza se modifica en todas las fichas tecnicas, solo el nombre de la pieza</p>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-6 col-md-6 ">
                        <h6 class="text-danger">Los campos con * son obligatorios</h6>
                    </div>
                    <button type="button" class="btn btn-info btn-lg btn-float" id="btnGuardar" data-toggle="tooltip" data-placement="left" title="Guardar">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/Piezas/';
    var tblPiezas = $('#tblPiezas');
    var Piezas;
    var btnNuevo = $("#btnNuevo"), btnCancelar = $("#btnCancelar"), btnEliminar = $("#btnEliminar"), btnGuardar = $("#btnGuardar");
    var pnlTablero = $("#pnlTablero"), pnlDatos = $("#pnlDatos");
    var nuevo = false;

    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();
        handleEnter();
        validacionSelectPorContenedor(pnlDatos);
        setFocusSelectToSelectOnChange('#Departamento', '#Clasificacion', pnlDatos);
        setFocusSelectToSelectOnChange('#Clasificacion', '#Rango', pnlDatos);
        setFocusSelectToSelectOnChange('#Rango', '#Obliga', pnlDatos);
        setFocusSelectToInputOnChange('#Obliga', '#btnGuardar', pnlDatos);

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
                        Piezas.ajax.reload();
                        pnlDatos.addClass("d-none");
                        pnlTablero.removeClass("d-none");
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    }).always(function () {
                        HoldOn.close();
                    });
                } else {
                    frm.append('Estatus', 'ACTIVO');
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
                        Piezas.ajax.reload();
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
                text: "Nota: No se eliminara ningun registro que tenga alguna relacion con otro módulo dentro del sistema",
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
                            Piezas.ajax.reload();
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
            pnlDatos.find("[name='Descripcion']").focus();
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });

        });

        btnCancelar.click(function () {
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass("d-none");
        });
    });

    function init() {
        getRecords();
        getDepartamentos();
        getRangos();
    }

    function getID() {
        $.getJSON(master_url + 'getID').done(function (data, x, jq) {
            console.log(data);
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
        if ($.fn.DataTable.isDataTable('#tblPiezas')) {
            tblPiezas.DataTable().destroy();
        }
        Piezas = tblPiezas.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"}, {"data": "Clave"}, {"data": "Descripcion"}
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
                [0, 'desc']/*ID*/
            ]
        });

        $('#tblPiezas_filter input[type=search]').focus();

        tblPiezas.find('tbody').on('click', 'tr', function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'CARGANDO...'
            });
            nuevo = false;
            tblPiezas.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Piezas.row(this).data();
            temp = parseInt(dtm.ID);
            $.getJSON(master_url + 'getPiezaByID', {ID: temp}).done(function (data) {
                pnlDatos.find("input").val("");
                $.each(pnlDatos.find("select"), function (k, v) {
                    pnlDatos.find("select")[k].selectize.clear(true);
                });
                $.each(data[0], function (k, v) {
                    pnlDatos.find("[name='" + k + "']").val(v);
                    if (pnlDatos.find("[name='" + k + "']").is('select')) {
                        pnlDatos.find("[name='" + k + "']")[0].selectize.addItem(v, true);
                    }
                });
                pnlTablero.addClass("d-none");
                pnlDatos.removeClass('d-none');
                btnEliminar.removeClass("d-none");

                pnlDatos.find("[name='Clave']").addClass('disabledForms');
                pnlDatos.find("#Descripcion").focus().select();
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
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
                pnlDatos.find("#Departamento")[0].selectize.addOption({text: v.Departamento, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getRangos() {
        $.getJSON(master_url + 'getRangos').done(function (data) {
            $.each(data, function (k, v) {
                pnlDatos.find("#Rango")[0].selectize.addOption({text: v.Rango, value: v.ID});
            });
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
</script>