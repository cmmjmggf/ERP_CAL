<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Reasignar controles (Maquila/Semana)</h3>
    </div>
    <div class="card-body">
        <div class="row" style="padding-left: 15px">
            <div class="col-12 col-sm-1 col-lg-1 col-md-1 col-xl-1" align="center">
                <button type="button" class="btn btn-warning" id="btnReload" data-toggle="tooltip" data-placement="top" title="Refrescar">
                    <span class="fa fa-retweet"></span>
                </button>
            </div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2" data-column="12">
                <strong>Inicial</strong>
                <input type="text" class="form-control form-control-sm" id="ControlInicial" autofocus placeholder="Ej:180152001">
            </div>
            <div class="col-12 col-sm-12 col-lg-3" data-column="13">
                <strong>Final</strong>
                <input type="text" class="form-control form-control-sm" id="ControlFinal" placeholder="Ej:180152005">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6" data-column="12">
                        <strong>Maquila asignada</strong>
                        <input type="text" class="form-control form-control-sm column_filter" id="col12_filter" placeholder="Maquila 1" maxlength="4" onblur="onChecarMaquilaValida(this)"> 
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6" data-column="13">
                        <strong>Semana asignada</strong>
                        <input type="text" class="form-control form-control-sm column_filter" id="col13_filter" placeholder="Semana 1" maxlength="3" onblur="onChecarSemanaValida(this);">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <strong>Maquila a asignar</strong>
                        <input type="text"  class="form-control form-control-sm column_filter" id="Maquila" placeholder="Maquila 2" maxlength="4" onblur="onChecarMaquilaValida(this)"> 
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6" data-column="15">
                        <strong>Semana a asignar</strong>
                        <input type="text" class="form-control form-control-sm column_filter" id="Semana" placeholder="Semana 2" maxlength="3" onblur="onChecarSemanaValida(this)">
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <strong>Observaciones</strong>
                <input type="text" id="ObservacionesTitulo" name="Observaciones" class="form-control form-control-sm mb-3" placeholder="Observacion uno" />
            </div>
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">  
                <strong>Observaciones adicionales</strong>
                <input type="text" id="Observaciones" name="Adicionales" class="form-control form-control-sm" placeholder="Observacion dos" />
            </div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 mt-3" align="left">
                <button type="button" class="btn btn-primary" id="btnAsignar" data-toggle="tooltip" data-placement="top" title="Asignar" disabled="">
                    <span class="fa fa-check"></span>
                </button>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-3" align="left">
            </div>
        </div>
        <br>
        <div id="ReasignarControles" class="table-responsive">
            <table id="tblReasignarControles" class="table table-sm display hover" style="width:100%">
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

<div class="dropdown-menu animated flipInX" style="font-size: 12px;" id='menu'>
    <a class="dropdown-item text-primary" href="#" onclick="btnAsignar.trigger('click')"><i class="fa fa-check"></i> Asignar</a> 
    <a class="dropdown-item text-info" href="#" onclick="btnReload.trigger('click')"><i class="fa fa-exchange-alt"></i> Refrescar</a> 
</div>
<script>
    var master_url = base_url + 'index.php/ReasignarControles/';
    var ReasignarControles;
    var tblReasignarControles = $('#tblReasignarControles');
    var btnAsignar = $("#btnAsignar");
    var btnDeshacer = $("#btnDeshacer");
    var btnReload = $("#btnReload");
    var pnlTablero = $("#pnlTablero");
    // IIFE - Immediately Invoked Function Expression
    (function (yc) {
        // The global jQuery object is passed as a parameter
        yc(window.jQuery, window, document);
    }(function ($, window, document) {
        // The $ is now locally scoped
        // Listen for the jQuery ready event on the document
        $(function () {
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var min = parseFloat($('#ControlInicial').val());
                        var max = parseFloat($('#ControlFinal').val());
                        var age = parseFloat(data[15]) || 0; // use data for the age column
                        if ((isNaN(min) && isNaN(max)) || (isNaN(min) && age <= max) || (min <= age && isNaN(max)) || (min <= age && age <= max))
                        {
                            return true;
                        }
                        return false;
                    }
            );

            pnlTablero.find("#ControlInicial").focusout(function () {
                onObtenerElUltimoControl(this);
            });

            $("#ControlInicial,#ControlFinal").keyup(function () {
                ReasignarControles.draw();
            });

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

            $("#col12_filter, #col13_filter, #Maquila, #Semana").focusout(function () {
                console.log($(this).val());
            });

            $('#ReasignarControles').on("contextmenu", function (e) {
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
                ReasignarControles.ajax.reload();
            });

            btnDeshacer.click(function () {
                if (tblReasignarControles.find("tbody tr.HasMca.selected").length > 0) {
                    swal({
                        title: "Estas seguro?",
                        text: "Serán desmarcados los '" + tblReasignarControles.find("tbody tr.HasMca.selected").length + "' registros, una vez completada la acción",
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
                var maquila_nueva = $("#Maquila"), semana_nueva = $("#Semana");
                if (maquila_nueva.val() !== '' && semana_nueva !== '') {
                    if (maquila_nueva.val() !== '' && semana_nueva !== '') {
                        swal({
                            title: "Estas seguro?",
                            text: "Serán reasignados los '" + tblReasignarControles.find("tbody tr").length + "' controles, una vez completada la acción: " + ReasignarControles.rows().count(),
                            icon: "warning",
                            buttons: true
                        }).then((willDelete) => {
                            if (willDelete) {
                                var controles = [];
                                $.each(tblReasignarControles.find("tbody tr"), function () {
                                    var r = ReasignarControles.row($(this)).data(), str = r.Anio, res = str.substr(2, 4);
                                    controles.push({
                                        ID: r.ID,
                                        Ano: res,
                                        Estilo: r.IdEstilo,
                                        Color: r.IdColor,
                                        Serie: r.SerieID,
                                        SerieT: r.Serie,
                                        Cliente: r.Cliente,
                                        Pares: r.Pares,
                                        Pedido: r.ID_PEDIDO,
                                        PedidoDetalle: r.ID,
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
                                        Marca: r.Marca,
                                        Semana: (pnlTablero.find("#Semana").val()),
                                        Maquila: (pnlTablero.find("#Maquila").val()),
                                        Observacion: (pnlTablero.find("#Observaciones").val()),
                                        Adicionales: (pnlTablero.find("#Adicionales").val())
                                    });
                                });
                                var f = new FormData();
                                f.append('INICIO', pnlTablero.find("#ControlInicial").val() !== '' ? pnlTablero.find("#ControlInicial").val() : pnlTablero.find("#ControlInicial").val());
                                f.append('FIN', pnlTablero.find("#ControlFinal").val() !== '' ? pnlTablero.find("#ControlFinal").val() : pnlTablero.find("#ControlInicial").val());
                                f.append('Controles', JSON.stringify(controles));
                                $.ajax({
                                    url: '<?php print base_url('ReasignarControles/onReAsignarControles'); ?>',
                                    type: "POST",
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    data: f
                                }).done(function (data, x, jq) {
                                    console.log(data);
                                    swal({
                                        title: 'INFO',
                                        text: 'SE HAN REASIGNADO LOS REGISTROS',
                                        icon: 'success',
                                        timer: 1500
                                    });
                                    ReasignarControles.ajax.reload();
                                    $("#col12_filter").focus().select();
                                    btnAsignar.prop("disabled", true);
                                }).fail(function (x, y, z) {
                                    console.log(x, y, z);
                                }).always(function () {
                                    HoldOn.close();
                                });
                            }
                        });
                    } else {
                        swal('ATENCIÓN', 'ES NECESARIO ESTABLECER UNA MAQUILA Y UNA SEMANA', 'warning').then((willDelete) => {
                            maquila_nueva.focus();
                        });
                    }
                } else {
                    swal('ATENCIÓN', 'ES NECESARIO ESTABLECER UN CONTROL INICIAL Y UN CONTROL FINAL', 'warning').then((willDelete) => {
                        maquila_nueva.focus();
                    });
                }
            });//ASIGNAR

            $('input.column_filter').on('keyup click', function () {
                var i = $(this).parents('div').attr('data-column');
                tblReasignarControles.DataTable().column(i).search($('#col' + i + '_filter').val()).draw();
            });
        }
        );
    }));

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
                        $(e).val('').focus().select();
                    });
                }
            }).fail(function () {
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
                    swal({
                        title: "Indique una semana de producción válida",
                        text: "La semana " + $(e).val() + " no existe o no ha sido generada.",
                        icon: "warning",
                        focusConfirm: true,
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((value) => {
                        $(e).val('').focus().select();
                    });
                }
            }).fail(function () {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            }).always(function () {
                onVerificarFormValido();
            });
        }
    }

    function pad(str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

    function onVerificarFormValido() {
        var a = pnlTablero.find("#col12_filter"), b = pnlTablero.find("#col13_filter"), c = pnlTablero.find("#Maquila"), d = pnlTablero.find("#Semana");
        if (a.val() !== '' && b.val() !== '' && c.val() !== '' && d.val() !== '') {
            btnAsignar.prop("disabled", false);
        } else {
            btnAsignar.prop("disabled", true);
        }
    }

    function getOptions(url, comp, key, field) {
        $.getJSON(master_url + url).done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#" + comp)[0].selectize.addOption({text: v[field], value: v[key]});
            });
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function init() {
        getRecords();
        $("#ControlInicial").focus();
        handleEnterDiv(pnlTablero);
    }

    function getRecords() {
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblReasignarControles')) {
            tblReasignarControles.DataTable().destroy();
        }
        ReasignarControles = tblReasignarControles.DataTable({
            dom: 'Brt',
            buttons: [
                {
                    text: "Todos",
                    className: 'btn btn-info btn-sm',
                    titleAttr: 'Todos',
                    action: function (dt) {
                        ReasignarControles.rows({page: 'current'}).select();
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
                "url": '<?php print base_url('ReasignarControles/getRecords'); ?>',
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
        HoldOn.close();
    }

    function onObtenerElUltimoControl(e) {
        var control = $(e).val();
        if (control) {
            var semana = parseInt(control.slice(2, 4));
            var maquila = parseInt(control.slice(4, 6));
            $.getJSON(master_url + 'onObtenerElUltimoControl', {SEMANA: semana, MAQUILA: maquila}).done(function (data) {
                var dt = data[0];
                var ControlFinal = pnlTablero.find("#ControlFinal");
                if (data.length > 0 && ControlFinal.val() === '' && ControlFinal.val().length <= 0) {
                    ControlFinal.val(dt.ULTIMO_CONTROL);
                    onBeep(1);
                }
            }).fail(function (x, y, z) {
                console.log(x.responseText);
            });
        }
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