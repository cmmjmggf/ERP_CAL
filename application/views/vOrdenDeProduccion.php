<div class="card m-3 animated fadeIn" id="pnlTablero">    
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Genera orden de producción semana / maquila</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-4 col-md-4 col-lg-2 col-xl-1">
                <button type="button" class="btn btn-warning" id="btnReload" data-toggle="tooltip" data-placement="top" title="Refrescar">
                    <span class="fa fa-retweet"></span>
                </button>
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-3" data-column="12">
                <label>Maquila</label>
                <input type="text" class="form-control form-control-sm column_filter numbersOnly" id="col12_filter" autofocus maxlength="4" onkeyup="onChecarMaquilaValida(this)">
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-3" data-column="13">
                <label>Semana</label>     
                <input type="text" class="form-control form-control-sm column_filter numbersOnly" id="col13_filter" maxlength="2"  min="1" max="52" onkeyup="onChecarSemanaValida(this)">
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-3" data-column="14">
                <label>Año</label>
                <input type="text" class="form-control form-control-sm column_filter numbersOnly" id="col14_filter" maxlength="4" minlength="1">
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-2 col-xl-2 mt-4">
                <button type="button" class="btn btn-primary" id="btnGenerar">Generar</button>
            </div>
            <div id="Resultado" class="col-12 text-center my-2"></div>
            <div id="Controles" class="table-responsive">
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
    var master_url = base_url + 'index.php/OrdenDeProduccion/';
    var pnlTablero = $("#pnlTablero"), Maquila = pnlTablero.find("#col12_filter"),
            Semana = pnlTablero.find("#col13_filter"), Anio = pnlTablero.find("#col14_filter"),
            btnGenerar = pnlTablero.find("#btnGenerar"), AnioValido = (new Date()).getFullYear();

    var Controles;
    var tblControles = $('#tblControles');
    var btnReload = $("#btnReload");
    var options_ordendeproduccion = {
        dom: 'irtp',
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
            "dataSrc": "",
            "data": function (d) {
                d.MAQUILA = (Maquila.val().trim());
                d.SEMANA = (Semana.val().trim());
                d.ANIO = (Anio.val().trim());
            }
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
        },
        initComplete: function (a, b) {
            HoldOn.close();
        }
    };

    // IIFE - Immediately Invoked Function Expression
    (function (yc) {
        // The global jQuery object is passed as a parameter
        yc(window.jQuery, window, document);
    }(function ($, window, document) {
        // The $ is now locally scoped
        // Listen for the jQuery ready event on the document
        $(function () {
            handleEnter();

            Semana.keydown(function (e) {
                if (e.keyCode === 13 && Maquila.val() !== '' && Semana.val() !== '') {
                    HoldOn.open({
                        theme: 'sk-bounce',
                        message: 'Por favor espere...'
                    });
                    $.fn.dataTable.ext.errMode = 'throw';
                    if ($.fn.DataTable.isDataTable('#tblControles')) {
                        Controles.ajax.reload();
                        HoldOn.close();
                    } else {
                        Controles = tblControles.DataTable(options_ordendeproduccion);
                    }
                }
            });

            btnGenerar.prop("disabled", true);
            Anio.val((new Date()).getFullYear());
            Anio.focusout(function () {
                onVerificarFormValido();
            }).keydown(function (e) {
                if (e.keyCode === 13 && Maquila.val() !== '' && Semana.val() !== '') {
                    HoldOn.open({
                        theme: 'sk-bounce',
                        message: 'Por favor espere...'
                    });
                    $.fn.dataTable.ext.errMode = 'throw';
                    if ($.fn.DataTable.isDataTable('#tblControles')) {
                        Controles.ajax.reload();
                        HoldOn.close();
                    } else {
                        Controles = tblControles.DataTable(options_ordendeproduccion);
                    }
                }
            });

            btnReload.click(function () {
                if (Maquila.val() !== '' && Semana.val() !== '') {
                    Controles.ajax.reload();
                }
            });

            btnGenerar.click(function () {
                btnGenerar.prop("disabled", true);
                onAgregarAOrdenDeProduccion();
            });
        });
    }));

    function onAgregarAOrdenDeProduccion() {
        HoldOn.open({
            theme: 'sk-bounce',
            message: 'GENERANDO...'
        });
        $.post(master_url + 'onAgregarAOrdenDeProduccion', {MAQUILA: Maquila.val(), SEMANA: Semana.val(), ANO: Anio.val()}).done(function (data) {
            var nordenes = parseInt(data);
            if (nordenes > 0) {
                $("#Resultado").html('<p class="text-info font-weight-bold mt-2"> SE HAN GENERADO ' + nordenes + ' ORDENES DE PRODUCCIÓN</p>');
                swal('ATENCIÓN', 'SE HAN CREADO ' + nordenes + ' ORDENES DE PRODUCCION DE LA MAQUILA ' + Maquila.val() + ', SEMANA ' + Semana.val() + ', AÑO ' + Anio.val(), 'success').then((value) => {
                    Maquila.focus().select();
                });
            } else {
                swal('ATENCIÓN', 'NO HAY ORDENES DE PRODUCCION DISPONIBLES EN LA MAQUILA ' + Maquila.val() + ', SEMANA ' + Semana.val() + ', AÑO ' + Anio.val(), 'warning').then((value) => {
                    Maquila.focus().select();
                });
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info').then((value) => {
                btnGenerar.prop("disabled", false);
            });
        }).always(function () {
            Controles.ajax.reload();
            btnGenerar.prop("disabled", false);
            HoldOn.close();
        });
    }

    function onChecarMaquilaValida(e) {
        var n = $(e);
        if (n.val() !== '') {
            $.getJSON(master_url + 'onChecarMaquilaValida', {ID: $(e).val()}).done(function (data) {
                if (parseInt(data[0].Maquila) <= 0) {
                    swal({
                        title: "Indique una maquila válida",
                        text: "La maquila " + $(e).val() + " no existe.",
                        icon: "warning",
                        focusConfirm: true,
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((value) => {
                        onVerificarFormValido();
                        $(e).val('').focus().select();
                    });
                }
            }).fail(function (x) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            }).always(function () {
                onVerificarFormValido();
            });
        }
    }

    function onChecarSemanaValida(e) {
        var n = $(e);
        if (n.val() !== '') {
            $.getJSON(master_url + 'onChecarSemanaValida', {ID: $(e).val()}).done(function (data) {
                if (parseInt(data[0].Semana) <= 0) {
                    var options = {
                        title: "Indique una semana de producción válida",
                        text: "La semana " + $(e).val() + " no existe o no ha sido generada.",
                        icon: "warning",
                        focusConfirm: true,
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    };
                    swal(options).then((value) => {
                        onVerificarFormValido();
                        $(e).val('').focus().select();
                    });
                }
            }).fail(function (x) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            }).always(function () {
                onVerificarFormValido();
            });
        }
    }

    function onVerificarFormValido() {
        if (parseInt(Anio.val()) <= parseInt(AnioValido)) {
            if (Maquila.val() !== '' && Semana.val() !== '' && Anio.val() !== '') {
                btnGenerar.prop("disabled", false);
            } else {
                btnGenerar.prop("disabled", true);
            }
        } else {
            swal({
                title: "Imposible realizar esta acción",
                text: "El año no puede ser mayor al año actual " + AnioValido + ", escriba un año valido para este proposito.",
                icon: "warning",
                focusConfirm: true,
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((value) => {
                Anio.focus().select();
            });
        }
    }
</script>
<style>
    td[title]:hover:after {
        text-align: center;
        content: attr(title);
        padding: 3px 5px 0px 5px;
        position: absolute;
        left: 0;
        top: 100%;
        white-space: nowrap;
        z-index: 1;
        background: #0099cc;
        color: #fff;
    }
</style>