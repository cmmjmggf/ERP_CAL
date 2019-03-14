<div class="card border-0 m-3" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Gestión de Series</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-primary" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar"><span class="fa fa-plus"></span><br></button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Series" class="table-responsive">
                <table id="tblSeries" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Clave</th>
                            <th>Numeración</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--GUARDAR-->
<div class="card border-0  d-none m-3" id="pnlDatos">
    <div class="card-body text-dark">
        <form id="frmNuevo">

            <div class="row">
                <div class="col-md-2 float-left">
                    <legend class="float-left">Series</legend>
                </div>
                <div class="col-md-7 float-right">

                </div>
                <div class="col-md-3 float-right" align="right">
                    <button type="button" class="btn btn-secondary btn-sm" id="btnCancelar"><span class="fa fa-arrow-left"></span> REGRESAR </button>
                </div>
            </div>
            <div class="row">
                <div class="d-none">
                    <input type="text" class="" id="ID" name="ID" >
                </div>
                <div class="col-12 col-sm-3">
                    <label for="Clave">Clave*</label>
                    <input type="text" class="form-control form-control-sm" id="Clave" name="Clave" required >
                </div>
                <div class="col-12 col-sm-3">
                    <label for="PuntoInicial">Punto Inicial*</label>
                    <input type="text" class="form-control form-control-sm numbersOnly" maxlength="4" id="PuntoInicial" name="PuntoInicial" required >
                </div>
                <div class="col-6 col-sm-3">
                    <label for="MediosPuntos">Medios Puntos</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="MediosPuntos" checked="">
                        <label class="custom-control-label" for="MediosPuntos"></label>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <label for="PuntoFinal">Punto Final*</label>
                    <input type="text"  class="form-control form-control-sm numbersOnly" maxlength="4" id="PuntoFinal" name="PuntoFinal" required >

                </div>
            </div>
            <div class="row">
                <br>
            </div>
            <div class=" " style=" overflow-x:auto; white-space: nowrap;" id="dSerie">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T1">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T2">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T3">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T4">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T5">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T6">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T7">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T8">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T9">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T10">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T11">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T12">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T13">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T14">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T15">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T16">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T17">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T18">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T19">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T20">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T21">
                <input type="text" style="width: 45px;" maxlength="4" class="numbersOnly"   name="T22">

            </div>


            <button type="button" class="btn btn-info btn-lg btn-float" id="btnGuardar" data-toggle="tooltip" data-placement="left" title="Guardar">
                <i class="fa fa-save"></i>
            </button>
            <!--            <div class="row mt-3" >
                            <div class="col-sm"align="right">
                                <button type="button" class="btn btn-primary btn-sm" id="btnGuardar"><span class="fa fa-save "></span> GUARDAR</button>
                            </div>

                        </div>-->
        </form>
    </div>
</div>

<!--SCRIPT-->
<script>
    var master_url = base_url + 'index.php/Series/';
    var pnlDatos = $("#pnlDatos");
    var pnlTablero = $("#pnlTablero");
    var btnNuevo = $("#btnNuevo");
    var btnGuardar = pnlDatos.find("#btnGuardar");
    var btnCancelar = pnlDatos.find("#btnCancelar");
    var btnModificar = pnlDatos.find("#btnModificar");
    var tempDetalle = 0;
    var nuevo = true;

    $(document).ready(function () {
        pnlDatos.find('#PuntoFinal').keydown(function (e) {
            if (e.keyCode === 13) {
                //Borramos los datos para evitar errores
                var contReset = 1;
                while (contReset <= 22) {
                    pnlDatos.find("[name='T" + contReset + "']").val("");
                    contReset++;
                }
                var incremento = parseFloat(pnlDatos.find('#PuntoInicial').val());
                //Se valida que no sea mas granda la talla inicial que la final
                if (parseFloat(pnlDatos.find('#PuntoFinal').val()) > parseFloat(pnlDatos.find('#PuntoInicial').val())) {

                    var cont = 1;
                    //Validamos si las tallas son con medios o sin medios puntos
                    if ($('#MediosPuntos').is(":checked"))
                    {
                        //Crear las tallas
                        while (incremento <= parseFloat(pnlDatos.find('#PuntoFinal').val())) {
                            pnlDatos.find("[name='T" + cont + "']").val(incremento);
                            incremento = incremento + 0.5;
                            cont++;
                        }
                    } else {
                        //Crear las tallas
                        while (incremento <= parseFloat(pnlDatos.find('#PuntoFinal').val())) {
                            pnlDatos.find("[name='T" + cont + "']").val(incremento);
                            incremento = incremento + 1;
                            cont++;
                        }
                    }
                    guardar = true;

                } else {
                    guardar = false;

                    swal({
                        title: "ATENCIÓN",
                        text: "EL PUNTO INICIAL NO DEBE SER MAYOR AL PUNTO FINAL",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        buttons: false,
                        timer: 2000
                    }).then((action) => {
                        pnlDatos.find('#PuntoFinal').focus();
                        pnlDatos.find("#PuntoFinal").select();
                    });

                }
            }

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
                        onNotify('<span class="fa fa-check fa-lg"></span>', 'SE HA MODIFICADO EL REGISTRO', 'success');
                        getRecords();
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
                        onNotify('<span class="fa fa-check fa-lg"></span>', 'SE HA AÑADIDO UN NUEVO REGISTRO', 'success');
                        pnlDatos.find('#ID').val(data);
                        nuevo = false;
                        getRecords();
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    }).always(function () {
                    });
                }
            } else {
                onNotify('<span class="fa fa-times fa-lg"></span>', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'danger');
            }
        });
        btnNuevo.click(function () {
            pnlTablero.addClass("d-none");
            pnlDatos.removeClass('d-none');
            pnlDatos.find("input").val("");
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
            pnlDatos.find('input').removeClass('disabledForms');
            pnlDatos.find('#Clave').addClass('disabledForms');
            pnlDatos.find('#PuntoInicial').focus();
            nuevo = true;
            getUltimoRegistro();
        });
        btnCancelar.click(function () {
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass('d-none');
            nuevo = true;
        });
        getRecords();
        handleEnter();
    });


    var tblSeries = $('#tblSeries');
    var Series;
    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblSeries')) {
            tblSeries.DataTable().destroy();
        }
        Series = tblSeries.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"}, {"data": "Clave"}, {"data": "Numeración"}
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

        $('#tblSeries_filter input[type=search]').focus();

        tblSeries.find('tbody').on('click', 'tr', function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'CARGANDO...'
            });
            nuevo = false;
            tblSeries.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Series.row(this).data();
            temp = parseInt(dtm.ID);
            $.getJSON(master_url + 'getSerieByID', {ID: temp}).done(function (data) {
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
                console.log(x.responseText);
            }).always(function () {
                HoldOn.close();
            });
        });
        HoldOn.close();
    }

    function getUltimoRegistro() {
        $.getJSON(master_url + 'getUltimoRegistro').done(function (data, x, jq) {
            if (data.length > 0) {
                var ultimo = parseInt(data[0].Clave) + 1;
                pnlDatos.find("[name='Clave']").val(ultimo);
            } else {
                pnlDatos.find("[name='Clave']").val('1');
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }
</script>