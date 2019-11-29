<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Confirmación de Órdenes de Compra</legend>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" data-column="1">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly column_filter" id="col1_filter" autofocus maxlength="2" >
            </div>
            <div class="col-6 col-sm-4 col-md-4 col-lg-2 col-xl-2" data-column="2">
                <label>Departamento</label>
                <input type="text" placeholder="10 PIEL/FORRO, 80 SUELA, 90 INDIR." class="form-control form-control-sm  numbersOnly column_filter" id="col2_filter" maxlength="2" >
            </div>
            <div class="col-6 col-sm-3 col-md-4 col-lg-2 col-xl-2" data-column="3">
                <label>Folio O.C.</label>
                <input type="text" class="form-control form-control-sm  numbersOnly column_filter" id="col3_filter" maxlength="6">
            </div>
            <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2 mt-4">
                <button type="button" class="btn btn-warning selectNotEnter" id="btnLimpiarFiltros" data-toggle="tooltip" data-placement="right" title="Limpiar Filtros">
                    <i class="fa fa-trash"></i>
                </button>
                <button type="button" class="btn btn-info selectNotEnter" id="btnImprimirReporte" data-toggle="tooltip" data-placement="top" title="Imprimir Reporte">
                    <i class="fa fa-print"></i>
                </button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Compras" class="table-responsive">
                <table id="tblCompras" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tp</th>
                            <th>Departamento</th>
                            <th>Folio</th>
                            <th>Proveedor</th>
                            <th>Fecha Orden</th>
                            <th>Fecha Entrega</th>
                            <th>Fecha Confirmación</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal " id="mdlReporteConfirmacion"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmación de Orden es de Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmReporte">
                    <div class="row">
                        <div class="col-4">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                        <div class="col-4">
                            <label>De la maq.</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="Maq" name="Maq" >
                        </div>
                        <div class="col-4">
                            <label>De la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" >
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-12 col-sm-8">
                            <label>Tipo <span class="badge badge-info mb-2" style="font-size: 12px;">10 Piel/Forro, 80 Suela, 90 Peletería</span></label>
                            <select class="form-control form-control-sm required selectize" id="Tipo" name="Tipo" >
                                <option value=""></option>
                                <option value="10">10 PIEL Y FORRO</option>
                                <option value="80">80 SUELA</option>
                                <option value="90">90 INDIRECTOS</option>
                            </select>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>


<script>
    var master_url = base_url + 'index.php/ConfirmarOrdenCompra/';
    var tblCompras = $('#tblCompras');
    var Compras;
    var mdlReporteConfirmacion = $('#mdlReporteConfirmacion');
    var pnlTablero = $("#pnlTablero");
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();
        handleEnterDiv(pnlTablero);
        handleEnterDiv(mdlReporteConfirmacion);
        pnlTablero.find("input").val("");
        pnlTablero.find('#col1_filter').focus();
        validacionSelectPorContenedor(mdlReporteConfirmacion);
        setFocusSelectToInputOnChange('#Tipo', '#btnImprimir', mdlReporteConfirmacion);
        mdlReporteConfirmacion.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    mdlReporteConfirmacion.find("#Ano").val("");
                    mdlReporteConfirmacion.find("#Ano").focus();
                });
            }
        });
        mdlReporteConfirmacion.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlReporteConfirmacion.find("#Sem").change(function () {
            var ano = mdlReporteConfirmacion.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
        mdlReporteConfirmacion.on('shown.bs.modal', function () {
            mdlReporteConfirmacion.find("input").val("");
            $.each(mdlReporteConfirmacion.find("select"), function (k, v) {
                mdlReporteConfirmacion.find("select")[k].selectize.clear(true);
            });
            mdlReporteConfirmacion.find('#Ano').focus();
        });

        mdlReporteConfirmacion.find('#btnImprimir').on("click", function () {
            //HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlReporteConfirmacion.find("#frmReporte")[0]);

            $.ajax({
                url: master_url + 'onImprimirReporteConfirmacion',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {

                    $.fancybox.open({
                        src: data,
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
                                    width: "85%",
                                    height: "85%"
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
                        text: "NO EXISTEN ORDENES DE COMPRA CON ESTOS CRITERIOS",
                        icon: "error"
                    }).then((action) => {
                        mdlReporteConfirmacion.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        pnlTablero.find('#btnImprimirReporte').click(function () {
            mdlReporteConfirmacion.modal('show');
        });

        pnlTablero.find('#btnLimpiarFiltros').click(function () {
            pnlTablero.find("input").val("");
            tblCompras.DataTable().columns().search('').draw();
            pnlTablero.find('#col1_filter').focus();
        });

        pnlTablero.find("#col1_filter").keyup(function () {
            var tp = parseInt($(this).val());
            if (tp > 2) {
                $(this).val('').focus();
            }
        });

        pnlTablero.find("#col2_filter").change(function () {
            var tp = parseInt($(this).val());
            if (tp === 80 || tp === 90 || tp === 10) {

            } else if (isNaN(tp)) {
                $(this).val('').focus();
                tblCompras.DataTable().column(2).search("", false, true).draw();
            } else {
                $(this).val('').focus();
                tblCompras.DataTable().column(2).search("", false, true).draw();
            }
        });

        $('input.column_filter').on('keyup', function () {
            var i = $(this).parents('div').attr('data-column');
            tblCompras.DataTable().column(i).search($('#col' + i + '_filter').val()).draw();
        });

    });

    function init() {
        getRecords();
    }
    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblCompras')) {
            tblCompras.DataTable().destroy();
        }
        Compras = tblCompras.DataTable({
            "dom": 'Brtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"}, {"data": "Tp"}, {"data": "Tipo"},
                {"data": "Folio"}, {"data": "Proveedor"}, {"data": "FechaOrden"},
                {"data": "FechaEnt"}, {"data": "FechaConf"}, {"data": "ObsConf"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },

                {
                    "targets": [2],
                    "visible": false,
                    "searchable": true
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
                [1, 'desc'], [3, 'desc']/*Folio*/
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 2:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 3:
                            /*FECHA ENTREGA*/
                            c.addClass('text-success text-strong');
                            break;
                        case 4:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                        case 5:
                            /*observaciones*/
                            c.addClass('text-info text-strong');
                            break;
                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });


        tblCompras.find('tbody').on('click', 'tr', function () {
            tblCompras.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Compras.row(this).data();
            temp = parseInt(dtm.ID);

            swal("Observaciones", {
                content: "input"
            }).then((value) => {
                $.post(master_url + 'onModificar', {Tp: dtm.Tp, Folio: dtm.Folio, ObservacionesConf: value.toUpperCase()}).done(function (data) {
                    Compras.ajax.reload();
                    pnlTablero.find("input").val("");
                    tblCompras.DataTable().columns().search('').draw();
                    pnlTablero.find('#col1_filter').focus();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
            });

        });

    }
    function onComprobarMaquilas(v) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA MAQUILA " + $(v).val() + " NO ES VALIDA",
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
                            $(v).val('');
                            $(v).focus();
                            break;
                    }
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function onComprobarSemanasProduccion(v, ano) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {

            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA SEMANA " + $(v).val() + " DEL " + ano + " " + "NO EXISTE",
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
                            $(v).val('');
                            $(v).focus();
                            break;
                    }
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
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

    td span.badge{
        font-size: 100% !important;
    }
</style>
