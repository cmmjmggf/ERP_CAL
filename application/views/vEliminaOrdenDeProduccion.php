<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Elimina orden de producción semana / maquila</h3>
    </div>
    <div class="card-body">
        <div class="row" aling="center">
            <div class="col-12 col-sm-6 col-md-6 col-lg-1 col-xl-1 mt-4">
                <button type="button" class="btn btn-warning" id="btnReload"><span class="fa fa-retweet"></span></button>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-5 col-xl-5">
                <label>Del control</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="ControlInicial" autofocus maxlength="10">
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-5 col-xl-5">
                <label>Al control</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="ControlFinal" maxlength="10" >
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-2 col-xl-1 mt-4">
                <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar</button>
            </div>
            <div class="w-100 my-3">
                <hr>
            </div>
            <div class="col-3">
                <label>MAQUILA</label>
                <input type="text" id="MaquilaElimina" name="MaquilaElimina" class="form-control form-control-sm numbersOnly" maxlength="2">
            </div>
            <div class="col-2">
                <label>SEMANA</label>
                <input type="text" id="SemanaElimina" name="SemanaElimina" class="form-control form-control-sm numbersOnly" maxlength="2">
            </div>
            <div class="col-2">
                <label>AÑO</label>
                <input type="text" id="AnioElimina" name="AnioElimina" readonly="" class="form-control form-control-sm numbersOnly" maxlength="4">
                <input type="text" id="Ordenes" name="Ordenes" readonly="" class="form-control form-control-sm numbersOnly d-none" maxlength="4">
            </div>
            <div class="col-2 mt-3">
                <span class="font-weight-bold total_ordenes_a_eliminar" style="color:#CC0000; font-size: 24px;">0 ORDENES</span>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 mt-4">
                <button type="button" class="btn btn-danger font-weight-bold" id="btnEliminarXMaquilaSemanaAnio" style="color: #ffff00; background-color: #000" disabled="disabled">ELIMINAR X SEMANA AÑO </button>
            </div>
            <div class="w-100 my-3">
                <hr>
            </div>
            <div class="col-12 m-2"></div>
            <div class="col-12">
                <h2 class="text-danger font-weight-bold" style="color: #cc0000 !important;">NOTA: UNA VEZ TERMINADO ESTE PASO, IMPRIMA LAS TARJETAS DE PRODUCCIÓN EN SU PASO NORMAL.</h2>
            </div>
            <div class="col-12">
                <h2 class="text-info font-weight-bold" style="color: #2196F3 !important;">NOTA: ESTA RUTINA NO AFECTA EL AVANCE DE PRODUCCIÓN.</h2>
            </div>
            <div id="Controles" class="table-responsive d-none">
                <table id="tblControles" class="table table-sm display hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th><!--0-->
                            <th>IdEstilo</th><!--1-->
                            <th>IdColor</th><!--2-->
                            <th>Pedido</th><!--3-->
                            <th>Cliente</th><!--4-->

                            <th>Estilo</th><!--5-->
                            <th>Color</th><!--6-->
                            <th>Serie</th><!--7-->
                            <th>Fecha</th><!--8-->
                            <th>Fe - Pe</th><!--9-->

                            <th>Fe - En</th><!--10-->
                            <th>Pars</th><!--11-->
                            <th>Maq</th><!--12-->
                            <th>Sem</th><!--13-->
                            <th>Año</th><!--14-->

                            <th>Control</th><!--15-->
                            <th>SerieID</th><!--16-->
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>

                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>

                            <th style="text-align:right">Pares</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>

                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/EliminaOrdenDeProduccion/';
    var Controles;
    var tblControles = $('#tblControles');
    var btnReload = $("#btnReload"), btnEliminar = $("#btnEliminar");
    var pnlTablero = $("#pnlTablero"),
            MaquilaElimina = pnlTablero.find("#MaquilaElimina"),
            SemanaElimina = pnlTablero.find("#SemanaElimina"),
            AnioElimina = pnlTablero.find("#AnioElimina"),
            Ordenes = pnlTablero.find("#Ordenes"),
            btnEliminarXMaquilaSemanaAnio = pnlTablero.find("#btnEliminarXMaquilaSemanaAnio"),
            Aniox = '<?php print Date('Y'); ?>';
    // IIFE - Immediately Invoked Function Expression
    (function (yc) {
        // The global jQuery object is passed as a parameter
        yc(window.jQuery, window, document);
    }(function ($, window, document) {
        // The $ is now locally scoped
        // Listen for the jQuery ready event on the document
        $(function () {
            handleEnterDiv(pnlTablero);
            //getRecords();
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var min = $('#ControlInicial').val() !== '' ? parseInt($('#ControlInicial').val()) : 0;
                        var max = $('#ControlFinal').val() !== '' ? parseInt($('#ControlFinal').val()) : 9999999999;
                        var age = parseInt(data[15]) || 0; // use data for the age column
                        if ((isNaN(min) && isNaN(max)) || (isNaN(min) && age <= max) || (min <= age && isNaN(max)) || (min <= age && age <= max))
                        {
                            return true;
                        }
                        return false;
                    }
            );
            AnioElimina.val(Aniox);
            MaquilaElimina.on('keydown', function (e) {
                if (e.keyCode === 13) {
                    getTotalOrdenesAEliminar();
                }
            });
            SemanaElimina.on('keydown', function (e) {
                if (e.keyCode === 13) {
                    getTotalOrdenesAEliminar();
                }
            });
            btnEliminarXMaquilaSemanaAnio.click(function () {
                var s = parseInt(SemanaElimina.val());
                if (MaquilaElimina.val() && s > 0 && s <= 52 && AnioElimina.val()) {
                    swal({
                        title: "¿Estas seguro?",
                        text: "Eliminaras " + Ordenes.val() + " ordenes de producción de la maquila, semana y año seleccionado",
                        icon: "warning",
                        buttons: {
                            cancelar: {
                                text: "CANCELAR",
                                value: 0
                            },
                            cambiar: {
                                text: "ELIMINAR ORDENES",
                                value: 1
                            }
                        }
                    }).then((value) => {
                        switch (value) {
                            case 0:
                                swal.close();
                                break;
                            case 1:
                                onOpenOverlay('');
                                $.post('<?php print base_url('EliminaOrdenDeProduccion/onEliminarControlesXMaquilaSemanaAno') ?>', {
                                    MAQUILA: MaquilaElimina.val() ? MaquilaElimina.val() : '',
                                    SEMANA: SemanaElimina.val() ? SemanaElimina.val() : '',
                                    ANIO: AnioElimina.val() ? AnioElimina.val() : '',
                                    ORDENES: Ordenes.val()
                                }).done(function (a) {
                                    console.log(a);
                                    onCloseOverlay();
                                    iMsg("SE HAN ELIMINADO " + Ordenes.val() + " ORDENES DE PRODUCCIÓN", "s", function () {
                                        MaquilaElimina.focus().select();
                                        pnlTablero.find("span.total_ordenes_a_eliminar").text("0 ORDENES");
                                        pnlTablero.find("#Ordenes").val(0);
                                    });
                                }).fail(function (x) {
                                    getError(x);
                                    onCloseOverlay();
                                });
                                break;
                        }
                    });
                } else {
                    onCampoInvalido(pnlTablero, "DEBE DE ESPECIFICAR TODOS LOS DATOS REQUERIDOS \n *MAQUILA \n *SEMANA", function () {
                        if (!MaquilaElimina.val()) {
                            MaquilaElimina.focus().select();
                            return;
                        }
                        if (!SemanaElimina.val()) {
                            SemanaElimina.focus().select();
                            return;
                        }
                    });
                }
            });

            $("#ControlInicial").focus();

            btnEliminar.click(function () {

                if ($("#ControlInicial").val() && $("#ControlFinal").val()) {

                    swal({
                        title: "Estas seguro?",
                        text: "Serán eliminadas las ordenes de producción seleccionadas, una vez completada la acción",
                        icon: "warning",
                        buttons: true
                    }).then((willDelete) => {
                        if (willDelete) {
                            var nc = 0;
//                        $.each(tblControles.find("tbody tr"), function () {
//                            console.log(Controles.row($(this)).data());
//                            nc += 1;
//                        });
                            $.post(master_url + 'onEliminarEntreControles', {
                                INICIO: $("#ControlInicial").val(),
                                FIN: $("#ControlFinal").val()
                            }).done(function (data, x, jq) {
                                //Controles.ajax.reload();
                                swal({
                                    title: "ATENCIÓN",
                                    text: "SE HAN ELIMINADO " + nc + " CONTROLES",
                                    icon: "success",
                                    closeOnClickOutside: false,
                                    closeOnEsc: false,
                                    buttons: true
                                });
                            }).fail(function (x, y, z) {
                                console.log(x.responseText, y, z);
                            }).always(function () {
                                HoldOn.close();
                            });
                        }
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "Debes de introducir un control inicial y un final",
                        icon: "error",
                        buttons: true
                    }).then((willDelete) => {
                        $("#ControlInicial").focus();
                    });
                }

            });

        });
    }));

    function getRecords() {
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblControles')) {
            tblControles.DataTable().destroy();
        }
        Controles = tblControles.DataTable({
            dom: 'irt',
            buttons: [
                {
                    text: "Todos",
                    className: 'btn btn-info btn-sm',
                    titleAttr: 'Todos',
                    action: function (dt) {
                        Controles.rows({page: 'current'}).select();
                    }
                },
                {
                    extend: 'selectNone',
                    className: 'btn btn-info btn-sm',
                    text: 'Ninguno',
                    titleAttr: 'Deseleccionar Todos'
                }
            ],
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": ""
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [1],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [2],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [16],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [17],
                    "visible": false,
                    "searchable": false
                }],
            "columns": [
                {"data": "ID"}, /*0*/
                {"data": "IdEstilo"}, /*1*/
                {"data": "IdColor"}, /*2*/
                {"data": "Pedido"}, /*3*/
                {"data": "Cliente"}, /*4*/
                {"data": "Estilo"}, /*5*/
                {"data": "Color"}, /*6*/
                {"data": "Serie"}, /*7*/
                {"data": "Fecha Captura"}, /*8*/
                {"data": "Fecha Pedido"}, /*9*/
                {"data": "Fecha Entrega"}, /*10*/
                {"data": "Pares"}, /*11*/
                {"data": "Maq"}, /*12*/
                {"data": "Semana"}, /*13*/
                {"data": "Anio"}, /*14*/
                {"data": "Control"}, /*15*/
                {"data": "SerieID"}/*16*/,
                {"data": "ID_PEDIDO"}/*17*/
            ],
            language: lang,
            select: true,
            keys: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 9999999999,
            "scrollY": 380,
            "scrollX": true,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'desc']/*ID*/
            ],
            "createdRow": function (row, data, dataIndex, cells) {
                $.each($(row).find("td"), function (k, v) {
                    switch (parseInt(k)) {
                        case 1:
                            $(v).attr('title', data["Cliente Razon"]);
                            break;
                        case 2:
                            $(v).attr('title', data["Descripcion Estilo"]);
                            break;
                        case 3:
                            $(v).attr('title', data["Descripcion Color"]);
                            break;
                    }
                });
                $.each($(row), function (k, v) {
                    if (data["Marca"] === '0' && data["Control"] !== null) {
                        $(v).addClass('HasMca');
                    }
                });
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(); //Get access to Datatable API
                // Update footer
                $(api.column(11).footer()).html(api.column(11, {page: 'current'}).data().reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0));
            }
        });
        HoldOn.close();
    }

    function  getTotalOrdenesAEliminar() {
        if (SemanaElimina.val()) {
            $.getJSON('<?php print base_url("EliminaOrdenDeProduccion/getTotalOrdenesAEliminar"); ?>', {
                MAQUILA: MaquilaElimina.val() ? MaquilaElimina.val() : '',
                SEMANA: SemanaElimina.val() ? SemanaElimina.val() : '',
                ANIO: AnioElimina.val() ? AnioElimina.val() : ''
            }).done(function (a) {
                console.log(a);
                if (a.length > 0) {
                    var ordenes = parseInt(a[0].ORDENES);
                    pnlTablero.find("span.total_ordenes_a_eliminar").text(ordenes + " ORDENES");
                    pnlTablero.find("#Ordenes").val(ordenes);
                    if (ordenes > 0) {
                        onEnable(btnEliminarXMaquilaSemanaAnio);
                    } else {
                        onDisable(btnEliminarXMaquilaSemanaAnio);
                        onCampoInvalido(pnlTablero, "NO HAY ORDENES QUE ELIMINAR EN ESTA MAQUILA, SEMANA, AÑO", function () {
                            MaquilaElimina.focus().select();
                        });
                    }
                }
            }).fail(function (x) {
                getError(x);
            });
        }
    }
</script>
<style>
    .swal-button {
        background-color: #cc0000;
    }
</style>