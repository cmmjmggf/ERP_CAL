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
            <div class="col-12 m-2"></div>
            <div class="col-12">
                <p class="text-danger font-weight-bold">Nota: Una vez terminado este paso, imprima las tarjetas de producción en su paso normal.</p>
            </div>
            <div class="col-12">
                <p class="text-info font-weight-bold">Nota: Esta rutina no afecta el avance de producción.</p>
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

    // IIFE - Immediately Invoked Function Expression
    (function (yc) {
        // The global jQuery object is passed as a parameter
        yc(window.jQuery, window, document);
    }(function ($, window, document) {
        // The $ is now locally scoped
        // Listen for the jQuery ready event on the document
        $(function () {
            handleEnter();
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

            $("#ControlInicial, #ControlFinal").keyup(function () {
                Controles.draw();
            });

            btnReload.click(function () {
                $("#ControlInicial, #ControlFinal").val('');
                Controles.ajax.reload();
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
</script>