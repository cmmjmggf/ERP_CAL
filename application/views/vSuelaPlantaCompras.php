<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Cabeceros PLANTA, SUELA, ENTRESUELA</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-primary" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar"><span class="fa fa-plus"></span><br></button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Articulos" class="table-responsive">
                <table id="tblArticulos" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cabecero</th>
                            <th>Serie</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--GUARDAR-->
<div class="card m-3 d-none animated fadeIn" id="pnlDatos">
    <div class="card-body text-dark">
        <form id="frmNuevo">
            <fieldset>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 float-left">
                        <legend>Componentes del Cabecero</legend>
                    </div>
                    <div class="col-12 col-sm-6 col-md-8" align="right">
                        <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                            <span class="fa fa-arrow-left" ></span> REGRESAR
                        </button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="d-none">
                        <input type="text"  name="ID" class="form-control form-control-sm" >
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2 col-xl-2">
                        <label>Serie</label>
                        <select  id="Serie" name="Serie" class="form-control form-control-sm required" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2 col-xl-2">
                        <label>Tipo</label>
                        <select id="Grupo" name="Grupo" class="form-control form-control-sm required" >
                            <option value=""></option>
                            <option value="3">3 SUELA</option>
                            <option value="50">50 PLANTA</option>
                            <option value="52">52 ENTRESUELA</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-5 col-lg-5 col-xl-3">
                        <label class="text-danger">Nota: Seleccione el cabecero que contenga **CBZ**</label>
                        <select id="ArticuloCBZ" name="ArticuloCBZ" class="form-control form-control-sm required selectNotEnter" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
                        <label class="">Articulos del cabecero</label>
                        <select id="Articulo" name="Articulo" class="form-control form-control-sm selectNotEnter ">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2 col-md-1 col-lg-1 col-xl-1 my-2 d-sm-block pt-4">
                        <button type="button" id="btnAgregar" class="btn btn-primary btn-sm d-sm-block" data-toggle="tooltip" data-placement="right" title="Agregar"><span class="fa fa-plus"></span></button>
                    </div>
                </div>
                <div class="row">
                    <!--TALLAS-->
                    <div class="col-12">
                        <div class="table-responsive" style="overflow-x:auto; white-space: nowrap;">
                            <label class="font-weight-bold" for="Tallas"></label>
                            <table id="tblTallas" class="Tallas" >
                                <thead></thead>
                                <tbody>
                                    <tr id="rTallasBuscaManual">
                                        <td class="font-weight-bold">Tallas</td>
                                        <?php
                                        for ($index = 1; $index < 23; $index++) {
                                            print '<td><input type="text" style="width: 55px;" id="T' . $index . '" name="T' . $index . '" disabled></td>';
                                        }
                                        ?>
                                    </tr>
                                    <tr class="rCapturaCantidades" id="rCantidades">
                                        <td class="font-weight-bold">Artículos</td>
                                        <?php
                                        for ($index = 1; $index < 23; $index++) {
                                            print '<td><input type="text" style="width: 55px;" id="A' . $index . '" class="form-control form-control-sm numbersOnly " name="A' . $index . '" ></td>';
                                        }
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-6 col-sm-6 col-md-6" align="right">
                        <button type="button" class="btn btn-info btn-lg btn-float selectNotEnter" id="btnGuardar" data-toggle="tooltip" data-placement="left" title="Guardar">
                            <i class="fa fa-save"></i>
                        </button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/SuelaPlantaCompras/';
    var tblArticulos = $('#tblArticulos');
    var Articulos;
    var pnlDatos = $("#pnlDatos");
    var pnlControlesDetalle = $('#pnlControlesDetalle');
    var pnlTablero = $("#pnlTablero");
    var pnlDetalle = $("#pnlDetalle");
    var btnNuevo = $("#btnNuevo");
    var btnCancelar = pnlDatos.find("#btnCancelar");
    var btnGuardar = pnlDatos.find("#btnGuardar");
    var btnAgregar = pnlDatos.find("#btnAgregar");
    var nuevo = true;

    $(document).ready(function () {

        /*FUNCIONES INICIALES*/
        init();
        handleEnter();
        validacionSelectPorContenedor(pnlDatos);
        setFocusSelectToSelectOnChange('#Serie', '#Grupo', pnlDatos);
        setFocusSelectToSelectOnChange('#Grupo', '#ArticuloCBZ', pnlDatos);
        setFocusSelectToSelectOnChange('#ArticuloCBZ', '#Articulo', pnlDatos);
        setFocusSelectToInputOnChange('#Articulo', '#btnAgregar', pnlDatos);
        /*FUNCIONES X BOTON*/
        btnNuevo.click(function () {
            pnlTablero.addClass("d-none");
            pnlDatos.removeClass('d-none');
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
            pnlDatos.find("[name='ArticuloCBZ']")[0].selectize.clear(true);
            pnlDatos.find("[name='ArticuloCBZ']")[0].selectize.clearOptions();
            pnlDatos.find("[name='Articulo']")[0].selectize.clear(true);
            pnlDatos.find("[name='Articulo']")[0].selectize.clearOptions();
            pnlDatos.find("input").val("");
            pnlDatos.find("#Serie")[0].selectize.enable();
            pnlDatos.find("#Grupo")[0].selectize.enable();
            pnlDatos.find("#Serie")[0].selectize.focus();
            nuevo = true;
        });

        btnCancelar.click(function () {
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass('d-none');
        });

        btnAgregar.click(function () {
            var art = pnlDatos.find("[name='Articulo']").val();

            $.each((pnlDatos.find('#rCantidades').find('input:enabled')), function (k, v) {
                if ($(v).val() === '') { //Validar que este vacio y que este diferente de disabled si no se va al boton de guardar
                    $(v).val(art);
                    return false;
                }
            });

            pnlDatos.find("#Articulo")[0].selectize.focus();
        });

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
                        Articulos.ajax.reload();
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
                        Articulos.ajax.reload();
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

        pnlDatos.find("#Grupo").change(function () {
            pnlDatos.find("[name='ArticuloCBZ']")[0].selectize.clear(true);
            pnlDatos.find("[name='ArticuloCBZ']")[0].selectize.clearOptions();
            pnlDatos.find("[name='Articulo']")[0].selectize.clear(true);
            pnlDatos.find("[name='Articulo']")[0].selectize.clearOptions();
            getArticulosByGrupo($(this).val());
        });

        pnlDatos.find("#Serie").change(function () {
            getSerieXClave($(this).val());
        });

        pnlDatos.find("#ArticuloCBZ").change(function () {
            if (nuevo) {
                onComprobarArticulo($(this).val());
            }
        });


    });

    function init() {
        getRecords();
        getSeries();
    }

    function onComprobarArticulo(e) {
        if (nuevo) {
            $.getJSON(master_url + 'onComprobarArticulo', {ArticuloCBZ: e}).done(function (data) {
                console.log(data);
                if (data.length > 0) {
                    swal({
                        title: "ATENCIÓN",
                        text: "EL CABECERO YA FUE CAPTURADO",
                        icon: "warning",
                        buttons: {
                            eliminar: {
                                text: "Aceptar",
                                value: "aceptar"
                            }
                        }
                    }).then((value) => {
                        switch (value) {
                            case "aceptar":
                                swal.close();
                                pnlDatos.find("#ArticuloCBZ")[0].selectize.focus();
                                pnlDatos.find("#ArticuloCBZ")[0].selectize.setValue('');
                                break;
                        }
                    });
                }
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });
        }
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
                    var Can = k.replace("T", "A");
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
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"}, {"data": "Cabecero"}, {"data": "Serie"}
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
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [1, 'desc']/*ID*/
            ],
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        $('#tblArticulos_filter input[type=search]').focus();

        tblArticulos.find('tbody').on('click', 'tr', function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'CARGANDO...'
            });
            nuevo = false;
            tblArticulos.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Articulos.row(this).data();
            temp = parseInt(dtm.ID);
            $.getJSON(master_url + 'getSuelaPlantabyID', {ID: temp}).done(function (data) {
                pnlDatos.find("input").val("");
                $.each(pnlDatos.find("select"), function (k, v) {
                    pnlDatos.find("select")[k].selectize.clear(true);
                });
                var grupo = parseInt(data[0].Grupo);
                $.when($.getJSON(master_url + 'getArticulosByGrupo', {Grupo: grupo}).done(function (data, x, jq) {

                    $.each(data, function (k, v) {
                        pnlDatos.find("#ArticuloCBZ")[0].selectize.addOption({text: v.Articulo, value: v.ID});
                        pnlDatos.find("#Articulo")[0].selectize.addOption({text: v.Articulo, value: v.ID});
                    });
                })).done(function (x) {
                    $.each(data[0], function (k, v) {
                        pnlDatos.find("[name='" + k + "']").val(v);
                        if (pnlDatos.find("[name='" + k + "']").is('select')) {
                            pnlDatos.find("[name='" + k + "']")[0].selectize.addItem(parseInt(v), true);
                        }
                    });
                    getSerieXClave(data[0].Serie);
                    pnlDatos.find("#Serie")[0].selectize.disable();
                    pnlDatos.find("#Grupo")[0].selectize.disable();

                    pnlTablero.addClass("d-none");
                    pnlDatos.removeClass('d-none');
                    HoldOn.close();
                });


            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            }).always(function () {

            });
        });

    }
    function getSeries() {
        $.ajax({
            url: master_url + 'getSeries',
            type: "POST",
            dataType: "JSON"
        }).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlDatos.find("#Serie")[0].selectize.addOption({text: v.Serie, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }
    function getArticulosByGrupo(Grupo) {
        if (Grupo !== '' && Grupo !== undefined && Grupo !== null) {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            $.getJSON(master_url + 'getArticulosByGrupo', {Grupo: Grupo}).done(function (data, x, jq) {
                $.each(data, function (k, v) {
                    pnlDatos.find("#ArticuloCBZ")[0].selectize.addOption({text: v.Articulo, value: v.ID});
                    pnlDatos.find("#Articulo")[0].selectize.addOption({text: v.Articulo, value: v.ID});
                });
                HoldOn.close();
                pnlDatos.find("#ArticuloCBZ")[0].selectize.focus();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            });
        }
    }

</script>
<style>
    .selectize-input {
        border: 1px solid #9E9E9E;
    }
    .form-control {
        border: 1px solid #9E9E9E;
    }

    #tblTallas tbody tr:hover {
        background-color: #FFF;
        color: #000 !important;
    }
</style>