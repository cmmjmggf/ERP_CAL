<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Imprime orden de producción</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label>Del control</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="ControlInicial" autofocus maxlength="10" >
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label>Al control</label>     
                <input type="text" class="form-control form-control-sm numbersOnly" id="ControlFinal" maxlength="10"  min="1" max="10" >
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 d-none" data-column="13">
                <label>Semana</label>
                <input type="text" class="form-control form-control-sm column_filter numbersOnly" id="col13_filter" maxlength="2" minlength="1" onfocus="">
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 d-none" data-column="14">
                <label>Año</label>
                <input type="text" class="form-control form-control-sm column_filter numbersOnly" id="col14_filter" maxlength="4" minlength="1" onfocus="">
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-12 col-xl-12 mt-4" align="right">
                <button type="button" class="btn btn-primary" id="btnGenerar">Aceptar</button>
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
    var master_url = base_url + 'index.php/IOrdenDeProduccion/';
    var btnGenerar = $("#btnGenerar");
    var ControlInicial = $("#ControlInicial"), ControlFinal = $("#ControlFinal"), semana = $("#col13_filter"), Anio = $("#col14_filter");
    var Controles;
    var tblControles = $('#tblControles');

    // IIFE - Immediately Invoked Function Expression
    (function (yc) {
        // The global jQuery object is passed as a parameter
        yc(window.jQuery, window, document);
    }(function ($, window, document) {
        // The $ is now locally scoped
        // Listen for the jQuery ready event on the document
        $(function () {
            handleEnter();
//            getRecords();

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
            $("#ControlInicial").focusout(function () {
                onObtenerElUltimoControl(this);
            });

            $("#ControlInicial, #ControlFinal").keydown(function (e) {
                console.log(e.keyCode)
                if (ControlInicial.val() && ControlFinal.val() && e.keyCode === 13) {
                    btnGenerar.prop("disabled", false);
                } else {
                    btnGenerar.prop("disabled", true);
                }
            });

            btnGenerar.click(function () {
                btnGenerar.prop("disabled", true);
                HoldOn.open({
                    theme: 'sk-bounce',
                    message: 'GENERANDO...'
                });
                var params = {INICIO: ControlInicial.val(), FIN: ControlFinal.val(), SEMANA: '', ANIO: ''};
                $.post(master_url + 'getOrdenDeProduccion', params).done(function (data) {
                    //check Apple device
                    if (isAppleDevice() || isMobile) {
                        window.open(data, '_blank');
                    } else {
                        $.fancybox.open({
                            src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
                            type: 'iframe',
                            opts: {
                                afterShow: function (instance, current) {
                                    console.info('done!');
                                },
                                iframe: {
                                    // Iframe template
                                    tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                                    preload: true,
                                    // Custom CSS styling for iframe wrapping element
                                    // You can use this to set custom iframe dimensions
                                    css: {
                                        width: "100%",
                                        height: "100%"
                                    },
                                    // Iframe tag attributes
                                    attr: {
                                        scrolling: "auto"
                                    }
                                }
                            }
                        });
                    }
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    swal('ATENCION', 'HA OCURRIDO UN ERROR AL OBTENER EL REPORTE, REVISE LA CONSOLA PARA MÁS DETALLE', 'warning');
                }).always(function () {
                    HoldOn.close();
                    btnGenerar.prop("disabled", false);
                });
            });

            $('input.column_filter').on('keyup', function () {
                var i = $(this).parents('div').attr('data-column');
                tblControles.DataTable().column(i).search($('#col' + i + '_filter').val()).draw();
            });

        });
    }));

    function isAppleDevice() {
        return (
                (navigator.userAgent.toLowerCase().indexOf("ipad") > -1) ||
                (navigator.userAgent.toLowerCase().indexOf("iphone") > -1) ||
                (navigator.userAgent.toLowerCase().indexOf("ipod") > -1)
                );
    }


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
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL_INICIAL = (ControlInicial.val().trim());
                    d.CONTROL_FINAL = (ControlFinal.val().trim());
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
            initComplete: function () {
                HoldOn.close();
            }
        });
    }

    function onVerificarFormValido() {
        var row_count = Controles.page.info().recordsDisplay;
        if (row_count > 0) {
            btnGenerar.prop("disabled", false);
        } else {
            btnGenerar.prop("disabled", true);
        }
    }

    function onObtenerElUltimoControl(e) {
        var control = $(e).val();
        var semana = parseInt(control.slice(2, 4));
        var maquila = parseInt(control.slice(4, 6));
        $.getJSON(master_url + 'onObtenerElUltimoControl', {SEMANA: semana, MAQUILA: maquila}).done(function (data) {
            var dt = data[0];
            var ControlFinal = $("#ControlFinal");
            if (data.length > 0 && ControlFinal.val() === '' && ControlFinal.val().length <= 0) {
                ControlFinal.val(dt.ULTIMO_CONTROL);
                onBeep(1);
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        });
    }
</script>