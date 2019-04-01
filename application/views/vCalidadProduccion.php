<div class="modal " id="mdlReporteCalidadProd"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Imprimir Reporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmParametros">
                    <div class="row">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIni" name="FechaIni" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFin" name="FechaFin" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimirReporte">IMPRIMIR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>

<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 col-md-6 float-left">
                <legend class="float-left">Controles Revisados por Calidad</legend>
            </div>
            <div class="col-12 col-sm-6 col-md-6 animated bounceInLeft" align="right" id="Acciones">
                <button type="button" class="btn btn-success btn-sm" id="btnImprimir">
                    <i class="fa fa-print"></i> REPORTE
                </button>
            </div>
        </div>
    </div>
    <hr>
    <div class="card-body" style="padding-top: 0px; padding-bottom: 10px;">
        <form id="frmCaptura">
            <div class="row mb-3">
                <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                    <label>Control</label>
                    <input type="text" id="Control" name="Control" maxlength="10" class="form-control form-control-sm numeric" required="">
                </div>
                <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3 d-sm-block pt-4">
                    <button type="button" id="btnAceptar" class="btn btn-primary btn-sm ">
                        <span class="fa fa-check"></span> ACEPTAR
                    </button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12">

                <div class="row">
                    <table id="tblCalidadProduccion" class="table table-sm display" style="width:  100%;">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Control</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/CalidadProduccion/';
    var pnlTablero = $("#pnlTablero div.card-body");
    var Control = pnlTablero.find("#Control"),
            CalidadProduccion, tblCalidadProduccion = pnlTablero.find("#tblCalidadProduccion"),
            btnAceptar = pnlTablero.find("#btnAceptar");
    var btnImprimir = pnlTablero.find('#btnImprimir');


    $(document).ready(function () {

        init();
        handleEnter();

        Control.change(function () {
            var control = $(this).val();
            if ($(this).val()) {
                $.getJSON(master_url + 'getExiste', {
                    Control: control
                }).done(function (data) {
                    if (data.length > 0) {
                        swal({
                            title: "ATENCIÓN",
                            text: "EL CONTROL YA HA SIDO CAPTURADO EN PIOCHAS ",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            if (action) {
                                Control.val('').focus();
                            }
                        });

                    } else {
                        $.getJSON(master_url + 'getControl', {
                            Control: control
                        }).done(function (data) {
                            if (data.length > 0) { //Si el control existe primero se valida que no este fact o cancelado
                                if (data[0].Depto === '260') {
                                    swal({
                                        title: "CONTROL YA FACTURADO",
                                        text: "EL CONTROL YA HA SIDO FACTURADO VERIFIQUE CON VENTAS ",
                                        icon: "warning",
                                        closeOnClickOutside: false,
                                        closeOnEsc: false
                                    }).then((action) => {
                                        if (action) {
                                            Control.val('').focus();
                                        }
                                    });
                                } else if (data[0].Depto === '270') {
                                    swal({
                                        title: "CONTROL CANCELADO POR EL CLIENTE",
                                        text: "****MOTIVO EXTEMPORANEO****",
                                        icon: "warning",
                                        closeOnClickOutside: false,
                                        closeOnEsc: false
                                    }).then((action) => {
                                        if (action) {
                                            Control.val('').focus();
                                        }
                                    });
                                } else { //si el control no está cancelado o facturado permite continuar

                                    btnAceptar.focus();


                                }
                            } else { //Si el control no existe
                                swal({
                                    title: "ATENCIÓN",
                                    text: "EL CONTROL NO EXISTE EN PRODUCCIÓN ",
                                    icon: "warning",
                                    closeOnClickOutside: false,
                                    closeOnEsc: false
                                }).then((action) => {
                                    if (action) {
                                        Control.val('').focus();
                                    }
                                });
                            }
                        });
                    }

                }).done(function (data) {
                });
            } else {//Valida que no esté en blanco el campo
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE CAPTURAR UN # DE CONTROL ",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    if (action) {
                        Control.val('').focus();
                    }
                });
            }

        });
        btnAceptar.click(function () {
            onAgregar();
        });
        /*FUNCIONES X BOTON*/
        btnImprimir.click(function () {
            $('#mdlReporteCalidadProd').modal('show');
        });

        $('#mdlReporteCalidadProd').on('shown.bs.modal', function () {
            $('#mdlReporteCalidadProd').find("input").val("");
            $('#mdlReporteCalidadProd').find('#FechaFin').val(getToday());
            $('#mdlReporteCalidadProd').find('#FechaIni').val(getFirstDayMonth()).focus();
        });

        $('#mdlReporteCalidadProd').find('#btnImprimirReporte').click(function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData($('#mdlReporteCalidadProd').find("#frmParametros")[0]);

            $.ajax({
                url: master_url + 'onReporteCalidadProd',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {

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
                                    width: "95%",
                                    height: "95%"
                                },
                                // Iframe tag attributes
                                attr: {
                                    scrolling: "auto"
                                }
                            }
                        }
                    });


                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        $('#mdlReporteCalidadProd').find('#FechaIni').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

    });

    function onAgregar() {
        isValid('pnlTablero');
        if (valido) {
            var frm = new FormData(pnlTablero.find("#frmCaptura")[0]);
            $.ajax({
                url: master_url + 'onAgregar',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                CalidadProduccion.ajax.reload();
                pnlTablero.find("input").val('');
                $.each(pnlTablero.find("select"), function (k, v) {
                    pnlTablero.find("select")[k].selectize.clear(true);
                });
                pnlTablero.find("#Control").focus();
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        } else {
            swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
        }
    }
    function getCalidadProduccion() {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblCalidadProduccion')) {
            tblCalidadProduccion.DataTable().destroy();
        }
        CalidadProduccion = tblCalidadProduccion.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getCalidadProduccion',
                "dataType": "json",
                "type": 'GET',
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"},
                {"data": "Control"},
                {"data": "Fecha"},
                {"data": "Eliminar"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*UNIDAD*/
                            c.addClass('text-info text-strong');
                            break;
                        case 4:
                            /*ELIMINAR*/
                            c.addClass('text-strong text-warning');
                            break;
                    }
                });
            },
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 20,
            "scrollX": true,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: true,
            "bSort": true,
            "aaSorting": [
                [1, 'asc']/*ID*/
            ],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        tblCalidadProduccion.find('tbody').on('click', 'tr', function () {
            tblCalidadProduccion.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }
    function init() {
        getCalidadProduccion();
        pnlTablero.find("#Control").focus();
    }
    function onEliminarDetalleByID(Control) {

        swal({
            buttons: ["Cancelar", "Aceptar"],
            title: 'Estas Seguro?',
            text: "Desea eliminar el \nControl: " + Control,
            icon: "warning",
            closeOnEsc: false,
            closeOnClickOutside: false
        }).then((action) => {
            if (action) {
                $.ajax({
                    url: master_url + 'onEliminarDetalleByID',
                    type: "POST",
                    data: {
                        Control: Control
                    }
                }).done(function (data, x, jq) {
                    CalidadProduccion.ajax.reload();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                HoldOn.close();
            }
        });


    }
</script>
<style>
    .text-strong {
        font-weight: bolder;
    }

    tr.group-start:hover td{
        background-color: #e0e0e0 !important;
        color: #000 !important;
    }
    tr.group-end td{
        background-color: #FFF !important;
        color: #000!important;
    }
    td{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>

