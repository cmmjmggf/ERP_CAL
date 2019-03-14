<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Hormas</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-primary" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar"><span class="fa fa-plus"></span><br></button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Hormas" class="table-responsive">
                <table id="tblHormas" class="table table-sm display " style="width:100%">
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
                        <legend >Horma</legend>
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
                        <input type="text" id="ID" name="ID" class="form-control form-control-sm" >
                    </div>
                    <div class="col-12 col-md-2 col-sm-6">
                        <label for="Clave" >Clave*</label>
                        <input type="text" class="form-control form-control-sm" id="Clave" name="Clave" required>
                    </div>
                    <div class="col-12 col-md-4 col-sm-6">
                        <label for="" >Descripción*</label>
                        <input type="text" id="Descripcion" name="Descripcion" class="form-control form-control-sm" placeholder="" required>
                    </div>
                    <div class="col-12 col-md-3 col-sm-6">
                        <label for="" >Serie*</label>
                        <select id="Serie" name="Serie" class="form-control form-control-sm" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3 col-sm-6">
                        <label for="" >Maquila*</label>
                        <select id="Maquila" name="Maquila" class="form-control form-control-sm" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row my-3">
                    <div class="col-sm-12" style="overflow-x:auto; white-space: nowrap;">
                        <table id="tblTallas" class="Tallas" >
                            <thead></thead>
                            <tbody>
                                <tr id="rTallasBuscaManual">
                                    <td class="text-primary">Tallas</td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T1"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T2"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T3"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T4"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T5"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T6"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T7"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T8"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T9"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T10"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T11"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T12"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T13"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T14"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T15"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T16"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T17"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T18"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T19"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T20"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T21"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" name="T22"></td>
                                </tr>
                                <tr id="rExistencias">
                                    <td class="text-success">Existencias</td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex1"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex2"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex3"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled=""maxlength="3"  name="Ex4"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex5"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex6"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex7"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex8"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex9"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex10"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex11"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex12"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex13"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex14"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex15"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex16"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex17"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex18"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex19"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex20"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex21"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" disabled="" maxlength="3"  name="Ex22"></td>
                                </tr>
                                <tr class="rCapturaCantidades" id="rCantidades">
                                    <td class="text-info">Cantidades</td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  id="C1" name="C1"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C2"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C3"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C4"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C5"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C6"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C7"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C8"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C9"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C10"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C11"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C12"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C13"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C14"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C15"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C16"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C17"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C18"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C19"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C20"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C21"></td>
                                    <td><input type="text" style="width: 35px;" class="numbersOnly" maxlength="3"  name="C22"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row pt-2">
                    <div class="col-6 col-md-6 ">
                        <h6 class="text-danger">Los campos con * son obligatorios</h6>
                    </div>
                    <button type="button" class="btn btn-info btn-lg btn-float" id="btnGuardar" data-toggle="tooltip" data-placement="left" title="Guardar">
                        <i class="fa fa-save"></i>
                    </button>
                    <!--                    <div class="col-6 col-sm-6 col-md-6" align="right">
                                            <button type="button" class="btn btn-raised btn-info btn-sm" id="btnGuardar">
                                                <span class="fa fa-save "></span> GUARDAR
                                            </button>
                                        </div>-->
                </div>
            </fieldset>
        </form>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/Hormas/';
    var tblHormas = $('#tblHormas');
    var Hormas;
    var btnNuevo = $("#btnNuevo"), btnCancelar = $("#btnCancelar"), btnEliminar = $("#btnEliminar"), btnGuardar = $("#btnGuardar");
    var pnlTablero = $("#pnlTablero"), pnlDatos = $("#pnlDatos");
    var nuevo = false;




    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();
        handleEnter();
        validacionSelectPorContenedor(pnlDatos);
        setFocusSelectToSelectOnChange('#Serie', '#Maquila', pnlDatos);
        setFocusSelectToInputOnChange('#Maquila', '#C1', pnlDatos);

        pnlDatos.find("[name='Serie']").change(function () {
            getSerieXClave($(this).val());
        });

        /*FUNCIONES X BOTON*/
        btnGuardar.click(function () {
            isValid('pnlDatos');
            if (valido) {

                if (!nuevo) {
                    var frm = new FormData();
                    frm.append('ID', pnlDatos.find("#ID").val());
                    frm.append('Clave', pnlDatos.find("#Clave").val());
                    frm.append('Descripcion', pnlDatos.find("#Descripcion").val());
                    frm.append('Serie', pnlDatos.find("#Serie").val());
                    frm.append('Maquila', pnlDatos.find("#Maquila").val());
                    for (var i = 1, max = 22; i <= max; i++) {
                        var e = pnlDatos.find("#rExistencias").find("input[name='Ex" + i + "']").val();
                        var c = pnlDatos.find("#rCantidades").find("input[name='C" + i + "']").val();
                        if (e !== '' && c !== '') {
                            frm.append('Ex' + i, e);
                            frm.append('C' + i, c);
                        }
                    }
                    $.ajax({
                        url: master_url + 'onModificar',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data, x, jq) {
                        swal('ATENCIÓN', 'SE HA MODIFICADO EL REGISTRO', 'info');
                        Hormas.ajax.reload();
                        pnlDatos.addClass("d-none");
                        pnlTablero.removeClass("d-none");
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    }).always(function () {
                        HoldOn.close();
                    });
                } else {
                    var frm = new FormData(pnlDatos.find("#frmNuevo")[0]);
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
                        Hormas.ajax.reload();
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
                text: "Nota: No se eliminara ningun registro que tenga alguna relacion con otro dato dentro del sistema",
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
                            Hormas.ajax.reload();
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
        getSeries();
        getMaquilas();
    }

    function getSerieXClave(Serie) {
        $.ajax({
            url: master_url + 'getSerieXClave',
            type: "POST",
            dataType: "JSON",
            data: {
                Clave: Serie
            }
        }).done(function (data, x, jq) {

            if (data.length > 0) {
                $.each(data[0], function (k, v) {
                    var Can = k.replace("T", "C");
                    if (parseInt(v) <= 0) {
                        pnlDatos.find('#rCantidades').find("[name='" + Can + "']").prop('disabled', true);
                    } else if (parseInt(v) > 0) {
                        pnlDatos.find('#rCantidades').find("[name='" + Can + "']").prop('disabled', false);
                        pnlDatos.find('#rTallasBuscaManual').find("[name='" + k + "']").val(v);
                    }
                });
            } else {
                pnlDatos.find('#rTallasBuscaManual').find('#rTallasBuscaManual').find("input").val("");
                pnlDatos.find('#rCantidades').find("input").prop('disabled', true);
            }


        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
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
        if ($.fn.DataTable.isDataTable('#tblHormas')) {
            tblHormas.DataTable().destroy();
        }
        Hormas = tblHormas.DataTable({
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

        $('#tblHormas_filter input[type=search]').focus();

        tblHormas.find('tbody').on('click', 'tr', function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'CARGANDO...'
            });
            nuevo = false;
            tblHormas.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Hormas.row(this).data();
            temp = parseInt(dtm.ID);
            $.getJSON(master_url + 'getHormaByID', {ID: temp}).done(function (data) {
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
                getSerieXClave(data[0].Serie);
                pnlTablero.addClass("d-none");
                pnlDatos.removeClass('d-none');
                btnEliminar.removeClass("d-none");

                pnlDatos.find("[name='C1']").focus().select();
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            }).always(function () {
                HoldOn.close();
            });
        });
        HoldOn.close();
    }
    function getSeries() {
        $.ajax({
            url: master_url + 'getSeries',
            type: "POST",
            dataType: "JSON"
        }).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlDatos.find("[name='Serie']")[0].selectize.addOption({text: v.Serie, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }
    function getMaquilas() {
        $.ajax({
            url: master_url + 'getMaquilas',
            type: "POST",
            dataType: "JSON"
        }).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlDatos.find("[name='Maquila']")[0].selectize.addOption({text: v.Maquila, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }
</script>

<style>
    .rCapturaCantidades input {
        color: #000;
    }
    table tbody tr:hover {
        background-color: transparent !important;
        color: #000 !important;
    }
</style>