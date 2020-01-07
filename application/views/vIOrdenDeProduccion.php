<div class="modal" id="mdlIOP">
    <div class="modal-dialog modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-print"></span> Imprime orden de producción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <label>Del control</label>
                        <input type="text" class="form-control form-control-sm numbersOnly" id="ControlInicialM" autofocus maxlength="10" >
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <label>Al control</label>     
                        <input type="text" class="form-control form-control-sm numbersOnly" id="ControlFinalM" maxlength="10"  min="1" max="10" >
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <label>Año</label>     
                        <input type="text" class="form-control form-control-sm numbersOnly" id="IOPAnio" name="IOPAnio" autofocus maxlength="5" >
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <label>Semana</label>     
                        <input type="text" class="form-control form-control-sm numbersOnly" id="IOPSemana" name="IOPSemana"  maxlength="2" >
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <label>Día</label>     
                        <input type="text" class="form-control form-control-sm numbersOnly" id="IOPDia" name="IOPDia" maxlength="1" >
                    </div>
                </div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-info" id="btnGenerarM"><span class="fa fa-check"></span> Aceptar</button>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/IOrdenDeProduccion/';
    var btnGenerar = $("#btnGenerar");
    var ControlInicial = $("#ControlInicial"), ControlFinalM = $("#ControlFinalM"), semana = $("#col13_filter"), Anio = $("#col14_filter");
    var Controles;
    var tblControles = $('#tblControles'),
            mdlIOP = $("#mdlIOP"), btnGenerarM = mdlIOP.find("#btnGenerarM"),
            IOPAnio = mdlIOP.find("#IOPAnio"),
            IOPSemana = mdlIOP.find("#IOPSemana"),
            IOPDia = mdlIOP.find("#IOPDia"),
            ControlInicialM = mdlIOP.find("#ControlInicialM"),
            ControlFinalM = mdlIOP.find("#ControlFinalM");

    // IIFE - Immediately Invoked Function Expression
    (function (yc) {
        // The global jQuery object is passed as a parameter
        yc(window.jQuery, window, document);
    }(function ($, window, document) {
        // The $ is now locally scoped
        // Listen for the jQuery ready event on the document
        $(function () {
            handleEnterDiv(mdlIOP);
//            getRecords();

            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var min = $('#ControlInicial').val() !== '' ? parseInt($('#ControlInicial').val()) : 0;
                        var max = $('#ControlFinalM').val() !== '' ? parseInt($('#ControlFinalM').val()) : 9999999999;
                        var age = parseInt(data[15]) || 0; // use data for the age column 
                        if ((isNaN(min) && isNaN(max)) || (isNaN(min) && age <= max) || (min <= age && isNaN(max)) || (min <= age && age <= max))
                        {
                            return true;
                        }
                        return false;
                    }
            );
            ControlInicialM.focusout(function () {
                onObtenerElUltimoControl(this);
            });

            ControlInicialM.keydown(function (e) {
                btnGenerarM.prop("disabled", false);
            });

            ControlFinalM.keydown(function (e) {
                btnGenerarM.prop("disabled", false);
            });

            mdlIOP.on('shown.bs.modal', function () {
                mdlIOP.find("#ControlInicialM").focus().select();
            });

            mdlIOP.on('hidden.bs.modal', function () {
                onClearPanelInputSelect(mdlIOP, function () {});
            });

            btnGenerarM.click(function () {
                btnGenerarM.attr("disabled", true);
                HoldOn.open({
                    theme: 'sk-bounce',
                    message: 'GENERANDO...'
                });
                var params = {
                    INICIO: ControlInicialM.val() ? ControlInicialM.val() : '',
                    FIN: ControlFinalM.val() ? ControlFinalM.val() : '',
                    SEMANA: IOPSemana.val() ? IOPSemana.val() : '',
                    ANIO: IOPAnio.val() ? IOPAnio.val() : '',
                    DIA: IOPDia.val() ? IOPDia.val() : ''};
                $.post('<?php print base_url('IOrdenDeProduccion/getOrdenDeProduccion'); ?>', params).done(function (data) {
                    //check Apple device
                    var dtm = JSON.parse(data);
                    if (parseInt(dtm.PAGINAS) > 0) {
                        if (isAppleDevice() || isMobile) {
                            window.open(dtm.URL, '_blank');
                        } else {
                            onImprimirReporteFancyAFC(dtm.URL, function (a, b) {
                                ControlInicialM.focus().select();
                            });
                        }
                    } else {
                        iMsg("LA BÚSQUEDA NO ARROJO NINGÚN RESULTADO, INTENTE CON OTROS DATOS", 'w', function () {
                            ControlInicialM.focus().select();
                        });
                    }
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    swal('ATENCION', 'HA OCURRIDO UN ERROR AL OBTENER EL REPORTE, REVISE LA CONSOLA PARA MÁS DETALLE', 'warning');
                }).always(function () {
                    HoldOn.close(); 
                    btnGenerarM.attr("disabled", false);
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
                    d.CONTROL_FINAL = (ControlFinalM.val().trim());
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
            btnGenerarM.prop("disabled", false);
        } else {
            btnGenerarM.prop("disabled", true);
        }
    }

    function onObtenerElUltimoControl(e) {
        var control = $(e).val();
        var semana = parseInt(control.slice(2, 4));
        var maquila = parseInt(control.slice(4, 6));
        $.getJSON('<?php print base_url('IOrdenDeProduccion/onObtenerElUltimoControl'); ?>', {SEMANA: semana, MAQUILA: maquila}).done(function (data) {
            var dt = data[0];
            if (data.length > 0 && ControlFinalM.val() === '' && ControlFinalM.val().length <= 0) {
                ControlFinalM.val(dt.ULTIMO_CONTROL);
                onBeep(1);
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        });
    }
</script>