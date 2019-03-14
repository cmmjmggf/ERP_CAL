<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Seleccionar pedidos por maquilador/semana/año para generar control</h3>
    </div>
    <div class="card-body">
        <div class="row" style="padding-left: 15px">
            <div class="col-12 col-sm-6 col-lg-1 mt-3" align="center">
                <button type="button" class="btn btn-warning" id="btnHistorialDeControles" data-toggle="tooltip" data-placement="top" title="Historial"><span class="fa fa-history"></span><br></button>
            </div>
            <div class="col-12 col-sm-6 col-lg-3" data-column="12">
                <strong>Maquila</strong>
                <input type="text" class="form-control form-control-sm column_filter" id="col12_filter" autofocus>
            </div>
            <div class="col-12 col-sm-6 col-lg-3" data-column="13">
                <strong>Semana</strong>
                <input type="text" class="form-control form-control-sm column_filter" id="col13_filter">
            </div>
            <div class="col-12 col-sm-6 col-lg-3" data-column="14">
                <strong>Año</strong>
                <input type="text" class="form-control form-control-sm column_filter" id="col14_filter">
            </div>
            <div class="col-12 col-sm-6 col-lg-2 mt-3">
                <button type="button" class="btn btn-primary mx-5" id="btnAsignar" data-toggle="tooltip" data-placement="top" title="Asignar"><span class="fa fa-check"></span><br></button>
                <button type="button" class="btn btn-danger d-none" id="btnDeshacer" data-toggle="tooltip" data-placement="top" title="Deshacer"><span class="fa fa-undo"></span><br></button>
                <button type="button" class="btn btn-info" id="btnReload" data-toggle="tooltip" data-placement="top" title="Refrescar"><span class="fa fa-exchange-alt"></span><br></button>
            </div>
        </div>
        <br>
        <div id="CerrarProg" class="table-responsive">
            <table id="tblCerrarProg" class="table table-sm display hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>IdEstilo</th>
                        <th>IdColor</th>
                        <th>Pedido</th>
                        <th>Cliente</th>

                        <th>Estilo</th>
                        <th>Color</th>
                        <th>Serie</th>
                        <th>Fecha</th>
                        <th>Fe - Pe</th>

                        <th>Fe - En</th>
                        <th>Pars</th>
                        <th>Maq</th>
                        <th>Sem</th>
                        <th>Año</th>

                        <th>Control</th>
                        <th>SerieID</th>
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

<div id="mdlHistorial" class="modal modal-fullscreen">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Historial de controles generados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4" data-column="12">
                        <strong>Maquila</strong>
                        <input type="text" class="form-control form-control-sm column_filter" id="col12_filter_history" autofocus>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4" data-column="13">
                        <strong>Semana</strong>
                        <input type="text" class="form-control form-control-sm column_filter" id="col13_filter_history">
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4" data-column="14">
                        <strong>Año</strong>
                        <input type="text" class="form-control form-control-sm column_filter" id="col14_filter_history">
                    </div>
                </div>
                <div class="w-100 m-3"></div>
                <div id="Historial" class="table-responsive">
                    <table id="tblHistorial" class="table table-sm display hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>IdEstilo</th>
                                <th>IdColor</th>
                                <th>Pedido</th>
                                <th>Cliente</th>

                                <th>Estilo</th>
                                <th>Color</th>
                                <th>Serie</th>
                                <th>Fecha</th>
                                <th>Fe - Pe</th>

                                <th>Fe - En</th>
                                <th>Pars</th>
                                <th>Maq</th>
                                <th>Sem</th>
                                <th>Año</th>

                                <th>Control</th>
                                <th>SerieID</th>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>
<div class="dropdown-menu animated flipInX" style="font-size: 12px;" id='menu'>
    <a class="dropdown-item text-primary" href="#" onclick="btnAsignar.trigger('click')"><i class="fa fa-check"></i> Asignar</a>
    <a class="dropdown-item text-danger" href="#" onclick="btnDeshacer.trigger('click')"><i class="fa fa-undo"></i> Deshacer</a>
    <a class="dropdown-item text-info" href="#" onclick="btnReload.trigger('click')"><i class="fa fa-exchange-alt"></i> Refrescar</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item text-warning" href="#"  onclick="btnHistorialDeControles.trigger('click')"><i class="fa fa-history"></i> Historial</a>
</div>
<script>
    var master_url = base_url + 'index.php/CerrarProg/';
    var CerrarProg, Historial;
    var tblCerrarProg = $('#tblCerrarProg');
    var btnAsignar = $("#btnAsignar");
    var btnDeshacer = $("#btnDeshacer");
    var btnReload = $("#btnReload");
    var btnHistorialDeControles = $("#btnHistorialDeControles");
    var mdlHistorial = $("#mdlHistorial");
    var tblHistorial = mdlHistorial.find('#tblHistorial');
    var pnlTablero = $("#pnlTablero");
    var MaquilaCerrarProg = pnlTablero.find("#col12_filter"), SemanaCerrarProg = pnlTablero.find("#col13_filter"), AnoCerrarProg = pnlTablero.find("#col14_filter");
    var options_cerrarprog = {
        dom: 'Brtip',
        buttons: [
            {
                text: "Todos",
                className: 'btn btn-info btn-sm',
                titleAttr: 'Todos',
                action: function (dt) {
                    CerrarProg.rows({page: 'current'}).select();
                }
            },
            {
                extend: 'selectNone',
                className: 'btn btn-info btn-sm',
                text: 'Ninguno',
                titleAttr: 'Deseleccionar Todos'
            }
        ], "ajax": {
            "url": master_url + 'getRecords',
            "dataSrc": "",
            "data": function (d) {
                d.MAQUILA = (MaquilaCerrarProg.val().trim());
                d.SEMANA = (SemanaCerrarProg.val().trim());
                d.ANIO = (AnoCerrarProg.val().trim());
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
    };

    // IIFE - Immediately Invoked Function Expression
    (function (yc) {
        // The global jQuery object is passed as a parameter
        yc(window.jQuery, window, document);
    }(function ($, window, document) {
        // The $ is now locally scoped
        // Listen for the jQuery ready event on the document
        $(function () {
            // Instance the tour
            var tour = new Tour({
                name: "tour",
                steps: [
                    {
                        smartPlacement: true,
                        backdropContainer: 'body',
                        backdropPadding: 5,
                        placement: "auto",
                        element: "#btnAsignar",
                        title: "Asignación",
                        content: "Con este boton generas los controles para los registros seleccionados"
                    },
                    {
                        smartPlacement: true,
                        backdropContainer: 'body',
                        backdropPadding: 5,
                        placement: "auto",
                        element: "#btnDeshacer",
                        title: "Deshacer",
                        content: "Con este boton reviertes los controles generados."
                    },
                    {
                        smartPlacement: true,
                        backdropContainer: 'body',
                        backdropPadding: 5,
                        placement: "auto",
                        element: "#btnReload",
                        title: "Refrescar",
                        content: "Permite actualizar los registros sin necesidad de actualizar completamente la página, con un performance excepcional."
                    },
                    {
                        smartPlacement: true,
                        backdropContainer: 'body',
                        backdropPadding: 5,
                        placement: "auto",
                        element: "#btnHistorialDeControles",
                        title: "Historial",
                        content: "Muestra el historial de controles revertidos con información detallada."
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
// Initialize the tour
            tour.init();
// Start the tour
            tour.start();
            init();
            
            AnoCerrarProg.keydown(function (e) {
                if (e.keyCode === 13) {
                    onFiltrar();
                }
            });
            
            SemanaCerrarProg.keydown(function (e) {
                if (e.keyCode === 13) { 
                    onFiltrar();
                }
            });

            $('#CerrarProg').on("contextmenu", function (e) {
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
            btnHistorialDeControles.click(function () {
                mdlHistorial.modal('show');
            });
            mdlHistorial.on('shown.bs.modal', function () {
                HoldOn.open({
                    theme: 'sk-bounce',
                    message: 'Por favor espere...'
                });
            });
            mdlHistorial.on('shown.bs.modal', function () {
                HoldOn.close();
                if ($.fn.DataTable.isDataTable('#tblHistorial')) {
                    getHistorialDeControles();
                } else {
                    getHistorial();
                }
            });

            btnReload.click(function () {
                CerrarProg.ajax.reload();
            });

            btnDeshacer.click(function () {
                if (tblCerrarProg.find("tbody tr.HasMca.selected").length > 0) {
                    swal({
                        title: "Estas seguro?",
                        text: "Serán desmarcados los '" + tblCerrarProg.find("tbody tr.HasMca.selected").length + "' registros, una vez completada la acción",
                        icon: "warning",
                        buttons: true
                    }).then((willDelete) => {
                        if (willDelete) {
                            onMarcarDesMarcar(2);
                        }
                    });
                } else {
                    swal('ATENCIÓN', 'NO HA SELECCIONADO NINGÚN REGISTRO', 'warning');
                }
            });

            btnAsignar.click(function () {
                onAsignar();
            });
        }
        );
    }));

    function onFiltrar() {
        if (MaquilaCerrarProg.val().trim() !== '') {
            if (SemanaCerrarProg.val().trim() !== '') {
                if (AnoCerrarProg.val().trim() !== '') {
                    HoldOn.open({
                        theme: 'sk-bounce',
                        message: 'Por favor espere...'
                    });
                    $.fn.dataTable.ext.errMode = 'throw';
                    if ($.fn.DataTable.isDataTable('#tblCerrarProg')) {
                        CerrarProg.ajax.reload();
                        HoldOn.close();
                    } else {
                        CerrarProg = tblCerrarProg.DataTable(options_cerrarprog);
                        HoldOn.close();
                    }
                } else {
                    swal('ATENCION', 'DEBE DE ESPECIFICAR UN AÑO', 'warning').then((value) => {
                        AnoCerrarProg.focus().select();
                    });
                }
            } else {
                swal('ATENCION', 'DEBE DE ESPECIFICAR UNA SEMANA', 'warning').then((value) => {
                    SemanaCerrarProg.focus().select();
                });
            }
        } else {
            swal('ATENCION', 'DEBE DE ESPECIFICAR UNA MAQUILA', 'warning').then((value) => {
                MaquilaCerrarProg.focus().select();
            });
        }
    }

    function onAsignar() {
        var row_count = tblCerrarProg.find("tbody tr.selected:not(.HasMca)").length;
        if (row_count > 0) {
            swal({
                title: "Estas seguro?",
                text: "Serán marcados los '" + tblCerrarProg.find("tbody tr.selected:not(.HasMca)").length + "' registros, una vez completada la acción",
                icon: "warning",
                buttons: true
            }).then((willDelete) => {
                if (willDelete) {
                    onMarcarDesMarcar(1);
                }
            });
        } else {
            if (tblCerrarProg.find("tbody tr > td").length < 5) {
                swal('ATENCIÓN', 'NO HA SELECCIONADO NINGÚN REGISTRO', 'warning');
            } else {
                $.each(tblCerrarProg.find("tbody tr"), function (k, v) {
                    $(v).addClass('selected');
                });
                swal('ATENCIÓN', 'SE ASIGNARÁN ' + tblCerrarProg.find("tbody tr.selected:not(.HasMca)").length + ' REGISTROS, ¿ESTAS SEGURO?', 'info', {
                    buttons: ["Cancelar", true]
                }).then((value) => {
                    if (value) {
                        onMarcarDesMarcar(1);
                    }
                });
            }
        }
    }

    function init() {
        pnlTablero.find("#col14_filter").val((new Date()).getFullYear());
        pnlTablero.find("#col12_filter").focus();
        handleEnter();
    }

    function getHistorial() {

        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblHistorial')) {
            tblHistorial.DataTable().destroy();
        }
        Historial = tblHistorial.DataTable({
            dom: 'Brt',
            buttons: [
                {
                    text: "Todos",
                    className: 'btn btn-info btn-sm',
                    titleAttr: 'Todos',
                    action: function (dt) {
                        Historial.rows({page: 'current'}).select();
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
                "url": master_url + 'getHistorialDeControles',
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
    }

    function onMarcarDesMarcar(i) {
        HoldOn.open({
            theme: 'sk-bounce',
            message: 'ESPERE...'
        });
        var subcontroles = [];
        $.each((i <= 1) ? tblCerrarProg.find("tbody tr.selected:not(.HasMca)") : tblCerrarProg.find("tbody tr.selected.HasMca"), function (k, v) {
            var r = CerrarProg.row($(this)).data();
            subcontroles.push({
                ID: r.ID,
                Estilo: r.IdEstilo,
                Color: r.IdColor,
                Serie: r.SerieID,
                SerieT: r.Serie,
                Cliente: r.Cliente,
                Pares: r.Pares,
                Pedido: r.ID_PEDIDO,
                PedidoDetalle: r.ID,
                Maquila: r.Maq,
                Semana: r.Semana,
                Control: r.Control,
                DescripcionEstilo: r["Descripcion Estilo"],
                ColorDescripcion: r["Descripcion Color"],
                PedidoID: r.Pedido,
                FechaPedido: r["Fecha Pedido"],
                FechaEntregaRecepcion: r["Fecha Entrega"],
                FechaCaptura: r["Fecha Captura"],
                ClaveCliente: r.Cliente,
                ClienteRazon: r["Cliente Razon"],
                Precio: r.Precio,
                Importe: r.Importe,
                Descuento: r.Desc,
                FechaEntrega: r.Entrega,
                Ano: r.Anio,
                Marca: r.Marca
            });
        });
        var f = new FormData();
        f.append('Marca', i);
        f.append('SubControles', JSON.stringify(subcontroles));
        $.ajax({
            url: master_url + 'onGenerarControles',
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: f
        }).done(function (data, x, jq) {
            console.log(data);
            swal({
                title: 'INFO',
                text: 'SE HAN ' + (i > 0 ? 'MARCADO' : 'DESMARCADO') + ' LOS REGISTROS',
                icon: 'success',
                timer: 2500
            });
            CerrarProg.ajax.reload();
            pnlTablero.find("#col12_filter").focus().select();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getHistorialDeControles() {
        Historial.ajax.reload();
        mdlHistorial.find("#col12_filter_history").focus();
    }
</script>
<style>
    .dropdown-item.active, .dropdown-item:active{
        color: #fff !important;
    }
    a[class*="text-"]:hover, a a[class*="text-"]:focus{
        color: #fff !important;
    }
    tr:hover td{
        background-color: #1b4f72;
        color: #fff;
    }
    td, td span{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    td:hover {
        position: relative;
        background-color: #212529 !important;
        font-weight: bold;
        font-size: 12px;
        color:  #fff;
    }
    td:hover span.text-info{
        position: relative; 
        font-weight: bold;
        font-size: 14px;
        color:  #ffeb3b !important;
    }

    td:hover span.text-danger{
        position: relative; 
        font-weight: bold;
        font-size: 14px;
        color:  #fff !important;
    }

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