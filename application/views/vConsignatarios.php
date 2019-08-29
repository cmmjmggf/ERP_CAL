<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Consignatarios</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-primary animated flipInX" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar"><span class="fa fa-plus"></span><br></button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Consignatarios" class="table-responsive">
                <table id="tblConsignatarios" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Consignatario</th>
                            <th>Dirección</th>
                            <th>Colonia</th>
                            <th>Ciudad</th>
                            <th>Tel</th>
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
                        <legend>Consignatario</legend>
                    </div>
                    <div class="col-12 col-sm-6 col-md-8" align="right">
                        <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                            <span class="fa fa-arrow-left" ></span> REGRESAR
                        </button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="d-none">
                            <input type="text"  name="ID" class="form-control form-control-sm" >
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <label>Cliente</label>
                        <select id="Cliente" name="Cliente" class="form-control form-control-sm" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <label for="Clave" >Clave*</label>
                        <input type="text" class="form-control form-control-sm numbersOnly disabledForms" id="Clave" name="Clave" required placeholder="Clave del color">
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >Consignatario*</label>
                        <input type="text" id="Consignatario" name="Consignatario" class="form-control form-control-sm "  required=""/>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-1 col-xl-1">
                        <label for="" >TP*</label>
                        <input type="text" id="TPProveedor" name="TPProveedor" class="form-control form-control-sm  numbersOnly"  required=""/>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >Numero de proveedor*</label>
                        <input type="text" id="NumeroDeProveedor" name="NumeroDeProveedor" class="form-control form-control-sm  numbersOnly"  required=""/>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <label for="Direccion" >Dirección*</label>
                        <textarea id="Direccion" name="Direccion" maxlength="100" required="" class="form-control" rows="2" cols="4"></textarea>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >Colonia*</label>
                        <input type="text" id="Colonia" name="Colonia" class="form-control form-control-sm"  required=""/>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >Ciudad*</label>
                        <input type="text" id="Ciudad" name="Ciudad" class="form-control form-control-sm"  required=""/>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <label>Estado*</label>
                        <select id="Estado" name="Estado" class="form-control form-control-sm" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >Código Postal</label>
                        <input type="text" id="CodigoPostal" name="CodigoPostal" class="form-control form-control-sm numbersOnly"  />
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >#Interior</label>
                        <input type="text" id="NumeroInterior" name="NumeroInterior" class="form-control form-control-sm numbersOnly"  />
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >#Exterior</label>
                        <input type="text" id="NumeroExterior" name="NumeroExterior" class="form-control form-control-sm numbersOnly"  />
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >RFC</label>
                        <input type="text" id="RFC" name="RFC" class="form-control form-control-sm "  />
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >Tel.Oficina</label>
                        <input type="text" id="TelOficina" name="TelOficina" class="form-control form-control-sm"  />
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <label for="" >Tel.Particular</label>
                        <input type="text" id="TelParticular" name="TelParticular" class="form-control form-control-sm"  />
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <label>Transporte</label>
                        <select id="Transporte" name="Transporte" class="form-control form-control-sm" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                        <h6 class="text-danger">Los campos con * son obligatorios</h6>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6" align="right">
                        <button type="button" class="btn btn-info btn-lg btn-float animated slideInUp" id="btnGuardar" data-toggle="tooltip" data-placement="left" title="Guardar">
                            <i class="fa fa-save"></i>
                        </button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/Consignatarios/';
    var tblConsignatarios = $('#tblConsignatarios');
    var Consignatarios;
    var btnNuevo = $("#btnNuevo"), btnCancelar = $("#btnCancelar"), btnEliminar = $("#btnEliminar"), btnGuardar = $("#btnGuardar");
    var pnlTablero = $("#pnlTablero"), pnlDatos = $("#pnlDatos");
    var nuevo = false;

    $(document).ready(function () {
        init();
        handleEnter();
        validacionSelectPorContenedor(pnlDatos);
        setFocusSelectToInputOnChange('#Cliente', '#Clave', pnlDatos);
        setFocusSelectToInputOnChange('#Estado', '#CodigoPostal', pnlDatos);
        setFocusSelectToInputOnChange('#Transporte', '#btnGuardar', pnlDatos);
        pnlDatos.find("#Cliente").change(function () {
            var id = $(this).val();
            $.getJSON(master_url + 'getID', {ID: id}).done(function (data) {
                if (data.length > 0) {
                    var ID = $.isNumeric(data[0].CLAVE) ? parseInt(data[0].CLAVE) + 1 : 1;
                    pnlDatos.find("#Clave").val(ID);
                    pnlDatos.find("#Consignatario").focus();
                } else {
                    if (id !== '') {
                        pnlDatos.find("#Clave").val('1');
                        pnlDatos.find("#Consignatario").focus();
                    } else {
                        pnlDatos.find("#Cliente")[0].selectize.focus();
                    }
                }
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            }).always(function () {
                HoldOn.close();
            });
        });

        btnGuardar.click(function () {
            isValid('pnlDatos');
            if (valido) {
                var frm = new FormData(pnlDatos.find("#frmNuevo")[0]);
                if (!nuevo) {
                    onSave('onModificar', frm, function () {
                        swal('ATENCIÓN', 'SE HA MODIFICADO EL REGISTRO', 'info');
                        nuevo = false;
                        Consignatarios.ajax.reload();
                        pnlDatos.addClass("d-none");
                        pnlTablero.removeClass("d-none");
                    });
                } else {
                    onSave('onAgregar', frm, function () {
                        nuevo = false;
                        Consignatarios.ajax.reload();
                        pnlDatos.addClass("d-none");
                        pnlTablero.removeClass("d-none");
                    });
                }
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });

        btnNuevo.click(function () {
            nuevo = true;
            pnlDatos.find("input,textarea").val("");
            pnlTablero.addClass("d-none");
            pnlDatos.removeClass("d-none");
            pnlDatos.find("#Cliente")[0].selectize.focus();
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
        getOptions("getClientes", "Cliente", "Clave", "Cliente");//Clientes
        getOptions("getEstados", "Estado", "Clave", "Estado");//Estados
        getOptions("getTransportes", "Transporte", "Clave", "Transporte");//Transportes
    }

    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblConsignatarios')) {
            tblConsignatarios.DataTable().destroy();
        }
        Consignatarios = tblConsignatarios.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"}, {"data": "Cliente"}, {"data": "Consignatario"}, {"data": "Direccion"}, {"data": "Colonia"}, {"data": "Ciudad"}, {"data": "TelParticular"}
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
                [1, 'ASC']
            ],
            initComplete: function (x, y) {
                HoldOn.close();
            }
        });

        $('#tblConsignatarios_filter input[type=search]').focus();

        tblConsignatarios.find('tbody').on('click', 'tr', function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'CARGANDO...'
            });
            nuevo = false;
            tblConsignatarios.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Consignatarios.row(this).data();
            temp = parseInt(dtm.ID);
            $.getJSON(master_url + 'getConsignatarioByID', {ID: temp}).done(function (data) {
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
                pnlDatos.find("#Descripcion").focus().select();
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');

            }).always(function () {
                HoldOn.close();
            });
        });

    }

    function getOptions(url, comp, key, field) {
        $.getJSON(master_url + url).done(function (data) {
            $.each(data, function (k, v) {
                pnlDatos.find("#" + comp)[0].selectize.addOption({text: v[field], value: v[key]});
            });
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onSave(u, f, fu) {
        $.ajax({
            url: master_url + u,
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: f
        }).done(function (data, x, jq) {
            fu();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }
</script>