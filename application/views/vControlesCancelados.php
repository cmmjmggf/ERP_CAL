<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center">

        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1 text-danger font-italic ">
                <p class="font-weight-bold badge badge-dark" style="cursor: pointer;" onclick="onTourStart()"> TOUR </p>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-11 col-xl-11 text-center">
                <h3 class="font-weight-bold">Consulta y reactiva controles cancelados</h3>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row" style="padding-left: 15px">
            <div class="col-12 col-sm-6 col-md-4 col-lg-1 col-xl-1 mt-3" align="center">
                <button type="button" class="btn btn-warning" id="btnReload" data-toggle="tooltip" data-placement="top" title="Refrescar"><span class="fa fa-exchange-alt"></span><br></button>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-2 col-xl-2" data-column="9">
                <strong>Maquila</strong>
                <input type="text" class="form-control form-control-sm column_filter numbersOnly" id="col9_filter" autofocus maxlength="4">
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-2 col-xl-2" data-column="8">
                <strong>Semana</strong>
                <input type="text" class="form-control form-control-sm column_filter numbersOnly" id="col8_filter" maxlength="2"  min="1" max="52">
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-2 col-xl-2" data-column="36">
                <strong>Año</strong>
                <input type="text" class="form-control form-control-sm column_filter numbersOnly" id="col36_filter" maxlength="4" minlength="1">
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-2 col-xl-2" data-column="2">
                <strong>Pedido</strong>
                <input type="text" class="form-control form-control-sm numbersOnly column_filter" id="col2_filter" maxlength="25" minlength="1">
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 mt-3">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <button type="button" class="btn btn-danger" id="btnCancelar">
                            CANCELAR
                        </button>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <button type="button" class="btn btn-danger notEnter" id="btnCancelarSeleccionados" data-toggle="tooltip" data-placement="top" title="Cancelar búsqueda seleccionada">
                            CANCELAR (CTRL)
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div id="ControlesCancelados" class="table-responsive">
            <table id="tblControlesCancelados" class="table table-sm display hover" style="width:100%">
                <thead>
                    <tr>
                        <th>CONTROLID</th><!--0-->
                        <th>PEDIDOID</th><!--1-->
                        <th>Pedido</th><!--2-->
                        <th>Cancelo</th><!--3-->
                        <th>Fecha Entrega</th><!--4--> 

                        <th>Cliente</th><!--5-->
                        <th>Estilo</th> <!--6-->
                        <th>Color</th> <!--7-->
                        <th>Semana</th> <!--8-->
                        <th>Maquila</th> <!--9-->

                        <th>Serie</th> 

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

                        <th></th> 
                        <th></th>  

                        <th>Pares</th> 
                        <th>Control</th> 
                        <th>Motivo</th> 
                        <th>Año</th> 
                        <th>-</th> 
                        <th>*</th> 

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
                        <th></th> 

                        <th></th> 
                        <th></th>  

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

<div class="modal" id="mdlCancelar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estas seguro?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <label for="">Escriba el motivo de la cancelación</label>
                        <textarea class="form-control" id="Motivo" name="Motivo" rows="3" autofocus=""></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer"> 
                <button type="button" id="btnGuardar" class="btn btn-primary">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/ControlesCancelados/';
    var ControlesCancelados, Historial;
    var tblControlesCancelados = $('#tblControlesCancelados');
    var btnCancelar = $("#btnCancelar");
    var btnDeshacer = $("#btnDeshacer");
    var btnReload = $("#btnReload");
    var pnlTablero = $("#pnlTablero");
    var mdlCancelar = $("#mdlCancelar");

    // Instance the tour
    var tour = new Tour({
        name: "tour",
        steps: [
            {
                backdrop: true,
                orphan: true,
                smartPlacement: true,
                backdropContainer: 'body',
                backdropPadding: 18,
                placement: "auto",
                element: "#col9_filter",
                title: "Maquila",
                content: "Permite buscar por maquila en un rango de controles."
            },
            {
                smartPlacement: true,
                backdropContainer: 'body',
                backdropPadding: 18,
                placement: "auto",
                element: "#col8_filter",
                title: "Semana",
                content: "Permite buscar los controles por semana de producción."
            },
            {
                smartPlacement: true,
                backdropContainer: 'body',
                backdropPadding: 18,
                placement: "auto",
                element: "#col36_filter",
                title: "Año",
                content: "Permite buscar por año los controles."
            },
            {
                smartPlacement: true,
                backdropContainer: 'body',
                backdropPadding: 18,
                placement: "auto",
                element: "#col2_filter",
                title: "Número de pedido",
                content: "Permite buscar por número de pedido los controles."
            },
            {
                smartPlacement: true,
                backdropContainer: 'body',
                backdropPadding: 5,
                placement: "auto",
                element: "#btnCancelar",
                title: "Cancelar",
                content: "Permite cancelar los controles filtrados. Se activa después de que la búsqueda obtuvo resultados."
            },
            {
                smartPlacement: true,
                backdropContainer: 'body',
                backdropPadding: 5,
                placement: "auto",
                element: "#tblControlesCancelados",
                title: "Controles",
                content: "Aqui se muestran los controles filtrados o buscados por maquila, semana, año y número de pedido."
            },
            {
                smartPlacement: true,
                backdropContainer: 'body',
                backdropPadding: 5,
                placement: "auto",
                element: "#tblControlesCancelados > tbody > tr:eq(0) ",
                title: "Cancelar",
                content: "Cada registro cuenta con un boton de <button type=\"button\" class=\"btn btn-danger\">CANCELAR</button><br> arroja una ventana donde preguntará cual es el motivo de la cancelación, desaparece el boton una vez cancelado el registro."
            }
        ],
        container: "body",
        smartPlacement: true,
        keyboard: true,
        storage: window.localStorage,
        debug: false,
        backdrop: true,
        backdropContainer: 'body',
        backdropPadding: 0,
        redirect: true,
        orphan: false,
        duration: false,
        delay: false,
        basePath: "",
        afterGetState: function (key, value) {},
        afterSetState: function (key, value) {},
        afterRemoveState: function (key, value) {},
        onStart: function (tour) {},
        onEnd: function (tour) {
            swal({
                title: "Recorrido finalizado",
                text: "En este momento ya es posible conocer a detalle que hace este módulo dentro del sistema.",
                icon: "success",
                buttons: {
                    resumetour: {
                        text: "Reiniciar recorrido",
                        value: "resumetour"
                    },
                    endtour: {
                        text: "Finalizar",
                        value: "endtour"
                    }
                }
            }).then((value) => {
                switch (value) {
                    case "resumetour":
                        tour.init();
                        tour.restart();
                        break;
                    case "endtour":
                        swal.close();
                        break;
                }
            });
        },
        onShow: function (tour) {},
        onShown: function (tour) {},
        onHide: function (tour) {},
        onHidden: function (tour) {},
        onNext: function (tour) {},
        onPrev: function (tour) {},
        onPause: function (tour, duration) {},
        onResume: function (tour, duration) {
            console.log('RESUMIDO');
        },
        onRedirectError: function (tour) {}
    });

    // IIFE - Immediately Invoked Function Expression
    (function (yc) {
        // The global jQuery object is passed as a parameter
        yc(window.jQuery, window, document);
    }(function ($, window, document) {
        // The $ is now locally scoped
        // Listen for the jQuery ready event on the document
        $(function () {
            mdlCancelar.find("#btnGuardar").click(function () {
                onCancelarControlesFiltrados();
            });
            $("#btnCancelarSeleccionados").click(function () {
                onCancelarSeleccionados();
            });

            $('#col9_filter').inputmask({alias: "9999", "placeholder": ""});//MAQUILA
            $('#col8_filter').inputmask({alias: "99", "placeholder": ""});//SEMANA
            $('#col36_filter').inputmask({alias: "9999", "placeholder": "_"});//AÑO

// Initialize the tour
            tour.init();
// Start the tour
            tour.start();

            init();

            $('#ControlesCancelados').on("contextmenu", function (e) {
                e.preventDefault();
                var top = e.pageY + 5;
                var left = e.pageX - 160;
                $("#menu").css({
                    display: "block",
                    top: top,
                    left: left
                });
                return false; //blocks default Webbrowser right click menu
            });

            $(document).click(function () {
                $("#menu").hide();
            });

            btnReload.click(function () {
                ControlesCancelados.ajax.reload();
            });

            btnCancelar.click(function () {
                onValidarFiltro();
            }).keypress(function (e) {
                if (e.keyCode === 13) {
                    onValidarFiltro();
                }
            });

            $('input.column_filter').on('keyup click', function () {
                var i = $(this).parents('div').attr('data-column');
                tblControlesCancelados.DataTable().column(i).search($('#col' + i + '_filter').val()).draw();
            });
        }
        );
    }));

    function onValidarFiltro() {
        var row_count = (tblControlesCancelados.find("tbody tr:not(.Cancelado)").length > 0) ? ControlesCancelados.page.info().recordsDisplay : 0;
        if (row_count > 0) {
            mdlCancelar.find("#Motivo").focus();
            mdlCancelar.modal('show');
        } else {
            swal('ATENCIÓN', 'NO HA SELECCIONADO NINGÚN REGISTRO O NO HAY REGISTROS POR CANCELAR', 'warning').then((value) => {
                pnlTablero.find("#col2_filter").focus();
            });
        }
    }

    function init() {
        getRecords();
        $("#col12_filter").focus();
        handleEnter();
        pnlTablero.find("#col14_filter").val((new Date()).getFullYear());
    }

    function getRecords() {
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblControlesCancelados')) {
            tblControlesCancelados.DataTable().destroy();
        }
        var cdata = [];
        cdata.push({"data": "CONTROLID"});/*0*/
        cdata.push({"data": "PEDIDOID"});/*1*/
        cdata.push({"data": "Pedido"});/*2*/
        cdata.push({"data": "Cancelo"});/*3*/
        cdata.push({"data": "Fecha Entrega"});/*4*/
        cdata.push({"data": "Cliente"});/*5*/
        cdata.push({"data": "Estilo"});/*6*/
        cdata.push({"data": "Color"});/*7*/
        cdata.push({"data": "Semana"});/*8*/
        cdata.push({"data": "Maquila"});/*9*/
        cdata.push({"data": "Serie"});/*10*/
        for (var i = 1, max = 22; i <= max; i++) {
            cdata.push({"data": "C" + i});/*32*/
        }
        cdata.push({"data": "Pares"});/*33*/
        cdata.push({"data": "Control"});/*34*/
        cdata.push({"data": "Motivo"});/*35*/
        cdata.push({"data": "Anio"});/*36*/
        cdata.push({"data": "CANCELA"});/*37*/
        cdata.push({"data": "ControlEstatus"});/*38*/

        ControlesCancelados = tblControlesCancelados.DataTable({
            dom: 'Brt',
            buttons: [
                {
                    text: "Todos",
                    className: 'btn btn-info btn-sm',
                    titleAttr: 'Todos',
                    action: function (dt) {
                        ControlesCancelados.rows({page: 'current'}).select();
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
                    "targets": [36],
                    "visible": false,
                    "searchable": true
                },
                {
                    "targets": [38],
                    "visible": false,
                    "searchable": true
                }],
            "columns": cdata,
            language: lang,
            select: true,
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
                $.each($(row), function (k, v) {
                    if (data["ControlEstatus"] === 'C') {
                        $(v).addClass('Cancelado');
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

    function onCancelarControl(e, c, p, pd) {
        console.log(c, p, pd);
        swal({
            title: "¿Estas seguro?",
            text: "*Escriba el motivo de la cancelación*",
            icon: "warning",
            content: "input",
            closeOnClickOutside: false,
            closeOnEsc: false,
            buttons: true
        }).then((value) => {
            console.log('VALUE ', value);
            if (value !== '' && value.length > 0) {
                $.post(master_url + 'onCancelarControlPedido', {CONTROL: c, PEDIDO: p, PEDIDODETALLE: pd, MOTIVO: value}).done(function (data) {
                    console.log('onCancelarControlPedido: ', data);
                    ControlesCancelados.ajax.reload();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });
            }
        });
    }

    function onCancelarControlesFiltrados() {
        var row_count = ControlesCancelados.page.info().recordsDisplay;
        var motivo = mdlCancelar.find("#Motivo").val();
        if (row_count > 0) {
            if (tblControlesCancelados.find("tbody tr:not(.Cancelado)").length > 0) {
                var nc = tblControlesCancelados.find("tbody tr:not(.Cancelado)").length;
                var controles = [];
                $.each(tblControlesCancelados.find("tbody tr:not(.Cancelado)"), function (k, v) {
                    var r = ControlesCancelados.row(v).data();
                    controles.push({
                        Motivo: motivo,
                        Pedido: r.Pedido,
                        PedidoDetalle: r.PEDIDOID
                    });
                });
                var f = new FormData();
                f.append('Controles', JSON.stringify(controles));
                $.ajax({
                    url: master_url + 'onCancelarControlesPedido',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: f
                }).done(function (data, x, jq) {
                    console.log(data);
                    mdlCancelar.find("#Motivo").val('');
                    mdlCancelar.modal('hide');
                    ControlesCancelados.ajax.reload();
                    swal({
                        title: "ATENCIÓN",
                        text: "SE HAN CANCELADO " + nc + " CONTROLES",
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
            } else {
                swal('ATENCIÓN', 'NO HA FILTRADO NINGÚN REGISTRO', 'warning');
            }
        } else {
            swal('ATENCIÓN', 'NO HA FILTRADO NINGÚN REGISTRO', 'warning');
        }
    }

    function onTourStart() {
        tour.init();
        tour.restart();
    }

    function onCancelarSeleccionados() {
        var rows_selected = tblControlesCancelados.find("tbody tr:not(.Cancelado).selected");
        if (rows_selected.length > 0) {
            var nc = rows_selected.length;
            swal({
                title: "¿Estas seguro?",
                text: "Serán cancelados los '" + nc + "' registros seleccionados, una vez completada la acción",
                icon: "warning",
                content: "input",
                buttons: {
                    confirm: {
                        text: "ACEPTAR",
                        value: 'ACEPTAR'
                    }
                }
            }).then((willDelete) => {
                console.log('value ', willDelete);
                if (willDelete) {
                    var controles = [];
                    $.each(rows_selected, function (k, v) {
                        var r = ControlesCancelados.row(v).data();
                        controles.push({
                            Motivo: willDelete,
                            Pedido: r.Pedido,
                            PedidoDetalle: r.PEDIDOID
                        });
                        console.log('row : ', r, v);
                    });
                    var f = new FormData();
                    f.append('Controles', JSON.stringify(controles));
                    $.ajax({
                        url: master_url + 'onCancelarControlesPedido',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: f
                    }).done(function (data, x, jq) {
                        console.log(data);
                        ControlesCancelados.ajax.reload();
                        swal({
                            title: "ATENCIÓN",
                            text: "SE HAN CANCELADO " + nc + " CONTROLES",
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
            swal('ATENCIÓN', 'NO HA SELECCIONADO NINGÚN REGISTRO', 'warning');
        }
    }
</script> 
<style>
    table tbody td{
        font-weight: bold; 
        left: 20px;
        top: -5px;
    } 

    tr.selected > td{
        background-color: #333333;
    }

    tr.selected > td{
        background-color: #2C3E50;
    }

    tr:hover > td div.text-danger{
        font-weight: bold;
        color: #ffff00  !important;
    }
    tr.selected > td div.text-danger{
        font-weight: bold;
        color: #ffff00  !important;
    }

    table tbody tr:hover {
        background-color: #333333;
    }

    input:in-range {
        border: 2px solid #99cc00 !important;
    }
    input:in-range {
        border: 2px solid #99cc00 !important;
    }
</style>