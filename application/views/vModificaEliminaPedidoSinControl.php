<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Modifica o Elimina Pedido sin Control</legend>
            </div>
            <div class="col-sm-4">
                <label>Cliente</label>
                <select id="ClienteModEliPedido" name="ClienteModEliPedido" class="form-control form-control-sm"></select>
            </div>
            <div class="col-sm-2">
                <label>Pedido</label>
                <input type="text" id="PedidoModEliPedido" name="PedidoModEliPedido" class="form-control form-control-sm numbersOnly">
            </div>
        </div>
        <hr>
        <div class="card-block">

            <div class="row">
                <div class="col-sm-6 float-left">
                    <legend class="float-left">Detalle del Pedido <span class="badge badge-info" style="font-size: 14px !important;">HAZ CLICK EN EL RENGLÓN PARA EDITAR</span></legend>
                </div>
                <div class="col-sm-6" align="right">
                    <button type="button" class="btn btn-primary btn-sm " id="btnVerClientes" >
                        <span class="fa fa-users" ></span> CLIENTES
                    </button>
                    <button type="button" class="btn btn-danger btn-sm " id="btnReporteAsignados" >
                        <span class="fa fa-file-pdf" ></span> REP. ASIGNADOS
                    </button>
                    <button type="button" class="btn btn-danger btn-sm " id="btnImprimePedido" >
                        <span class="fa fa-file-pdf" ></span> IMP. PEDIDO
                    </button>
                </div>
            </div>
            <div id = "dTabla" class="row d-none">
                <table id="tblPedidoDetalle" class="table table-sm table-hover "  style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Recibido</th><!--1-->
                            <th scope="col">Estilo</th><!--2-->
                            <th scope="col">Estilo</th><!--3-->
                            <th scope="col">Color</th><!--4-->
                            <th scope="col">Color</th><!--5-->
                            <th scope="col">Sem</th><!--6-->
                            <th scope="col">Maq</th><!--7-->

                            <th scope="col"></th><!--8-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--5-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--12-->

                            <th scope="col"></th><!--13-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--5-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--17-->

                            <th scope="col"></th><!--18-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--5-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--22-->

                            <th scope="col"></th><!--23-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--5-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--27-->

                            <th scope="col"></th><!--28-->
                            <th scope="col"></th><!--29-->

                            <th scope="col">Precio</th><!--30-->
                            <th scope="col">Pares</th><!--31-->
                            <th scope="col">F. Ent</th><!--32-->
                            <th scope="col">Eliminar</th><!--33-->
                            <!--OUT-->
                            <th scope="col">Recio</th><!--34-->
                            <th scope="col">Titulo Observaciones</th><!--35-->
                            <th scope="col">Observaciones</th><!--36-->
                            <th scope="col">Serie</th><!--37-->
                            <th scope="col">Estatus Registro</th><!--38-->
                            <th scope="col">Importe</th><!--39-->
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/ModificaEliminaPedidoSinControl/';
    var pnlTablero = $("#pnlTablero div.card-body");
    var PedidoDetalle, tblPedidoDetalle = pnlTablero.find("#tblPedidoDetalle"), dTabla = pnlTablero.find("#dTabla");
    var btnVerClientes = pnlTablero.find('#btnVerClientes');
    var btnImprimePedido = pnlTablero.find('#btnImprimePedido');
    var btnReporteAsignados = pnlTablero.find('#btnReporteAsignados');
    var id_pedidoDetalle;
    $(document).ready(function () {
        init();
        pnlTablero.find("#ClienteModEliPedido").change(function () {
            if ($(this).val()) {
                pnlTablero.find("#PedidoModEliPedido").focus().select();
            }
        });
        pnlTablero.find("#PedidoModEliPedido").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var Cliente = pnlTablero.find("#ClienteModEliPedido").val();
                    var Clave = $(this).val();
                    //Buscar pedido
                    $.getJSON(master_url + 'getPedidoByClienteNumero', {Pedido: $(this).val(), Cliente: Cliente}).done(function (data) {
                        if (data.length > 0) {
                            //existe y se puede manipular desde aqui
                            getDetallePedido(Cliente, Clave);
                        } else {
                            //el pedido ya tiene control, no se puede eliminar desde aquí, o no existe
                            swal({
                                title: "ATENCIÓN",
                                text: "NO. DE PEDIDO NO EXISTE, O YA TIENE CONTROL, IMPOSIBLE MANIPULAR EN ESTE MÓDULO",
                                icon: "warning",
                                closeOnClickOutside: false,
                                closeOnEsc: false
                            }).then((action) => {
                                if (action) {
                                    pnlTablero.find("#PedidoModEliPedido").val('').focus();
                                }
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        btnReporteAsignados.click(function () {
            HoldOn.open({
                theme: 'sk-bounce',
                message: 'Por favor espere...'
            });
            $.post(master_url + 'getParesPreProgramados').done(function (data, x, jq) {
                console.log(data);
                onImprimirReporteFancy(base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs');
                HoldOn.close();
            }).fail(function (x, y, z) {
                HoldOn.close();
                console.log(x.responseText);
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            });
        });
        btnVerClientes.click(function () {
            $.fancybox.open({
                src: base_url + '/Clientes.shoes',
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
        });
        btnImprimePedido.click(function () {
            $('#mdlReimprimirPedido').modal('show');
        });
    });


    function init() {
        id_pedidoDetalle = 0;
        getClientes();
        pnlTablero.find("#ClienteModEliPedido")[0].selectize.focus();
    }

    function getClientes() {
        pnlTablero.find("#ClienteModEliPedido")[0].selectize.clear(true);
        pnlTablero.find("#ClienteModEliPedido")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getClientes').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#ClienteModEliPedido")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onEliminarDetalleByID(numemp, ano, sem, numcon) {
        swal({
            buttons: ["Cancelar", "Aceptar"],
            title: 'Estas Seguro?',
            text: "Deseas eliminar el registro: \n\nEmpleado: " + numemp + " \n Año: " + ano + " \n Semana: " + sem,
            icon: "warning",
            closeOnEsc: false,
            closeOnClickOutside: false
        }).then((action) => {
            if (action) {
                $.ajax({
                    url: master_url + 'onEliminarDetalleByID',
                    type: "POST",
                    data: {

                        Empleado: numemp,
                        Ano: ano,
                        Sem: sem,
                        Concepto: numcon
                    }
                }).done(function (data, x, jq) {
                    ConceptosVariables.ajax.reload();
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

    function getDetallePedido(Cliente, Clave) {
        dTabla.removeClass('d-none');
        if ($.fn.DataTable.isDataTable('#tblPedidoDetalle')) {
            tblPedidoDetalle.DataTable().destroy();
        }
        PedidoDetalle = tblPedidoDetalle.DataTable({
            "ajax": {
                "url": master_url + 'getPedidoDByID',
                "contentType": "application/json",
                "dataSrc": "",
                "data": {
                    "ID": Clave,
                    "CLIENTE": Cliente
                }
            },
            dom: 'rt',
            buttons: buttons,
            "columns": [
                {"data": "PDID"}, {"data": "Recibido"}, {"data": "Estilo"}, {"data": "EstiloT"},
                {"data": "Color"}, {"data": "ColorT"}, {"data": "Semana"}, {"data": "Maquila"},
                {"data": "T1"}, {"data": "T2"}, {"data": "T3"}, {"data": "T4"},
                {"data": "T5"}, {"data": "T6"}, {"data": "T7"}, {"data": "T8"},
                {"data": "T9"}, {"data": "T10"}, {"data": "T11"}, {"data": "T12"},
                {"data": "T13"}, {"data": "T14"}, {"data": "T15"}, {"data": "T16"},
                {"data": "T17"}, {"data": "T18"}, {"data": "T19"}, {"data": "T20"},
                {"data": "T21"}, {"data": "T22"},
                {"data": "Precio"}, {"data": "Pares"},
                {"data": "FechaEntrega"}, {"data": "ELIMINAR"},
                {"data": "Recio"}, {"data": "Observacion"},
                {"data": "ObservacionDetalle"}, {"data": "Serie"},
                {"data": "EstatusD"}, {"data": "STT"}
            ],
            "columnDefs": [
                //ID
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                //RECIBIDO
                {
                    "targets": [1],
                    "visible": false,
                    "searchable": false
                },
                //ESTILO ID
                {
                    "targets": [3],
                    "visible": false,
                    "searchable": false
                },
                //COLOR ID
                {
                    "targets": [5],
                    "visible": false,
                    "searchable": false
                },
                //RECIO
                {
                    "targets": [34],
                    "visible": false,
                    "searchable": false
                },
                //TITULO OBSERVACIONES
                {
                    "targets": [35],
                    "visible": false,
                    "searchable": false
                },
                //TITULO OBSERVACIONES
                {
                    "targets": [36],
                    "visible": false,
                    "searchable": false
                },
                //SERIE
                {
                    "targets": [37],
                    "visible": false,
                    "searchable": false
                },
                //ESTATUS REGISTRO
                {
                    "targets": [38],
                    "visible": false,
                    "searchable": false
                },
                //IMPORTE
                {
                    "targets": [39],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 999,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": 400,
            "scrollX": true,
            initComplete: function (x, y) {
                HoldOn.close();
            }
        });
        tblPedidoDetalle.find('tbody').on('click', 'tr', function () {
            tblPedidoDetalle.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = PedidoDetalle.row(this).data();
            getPedidoParaEdicion(dtm.PDID);
        });
    }

    function  getPedidoParaEdicion(ID) {
        id_pedidoDetalle = ID;
        $('#mdlObsPedidoModificaEliminaPedidoSinControl').modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function onEliminar(r, index) {
        swal({
            title: "¿Deseas eliminar el registro? ",
            text: "*El registro se eliminará de forma permanente*",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
            closeOnClickOutside: false,
            closeOnEsc: false
        }).then((willDelete) => {
            if (willDelete) {
                var dt = PedidoDetalle.row($(r).parents('tr')).data();
                $.post(master_url + 'onEliminar', {ID: dt[0]}).done(function (data) {
                    PedidoDetalle.row($(r).parents('tr')).remove().draw();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                });
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

    #tblPedidoDetalle table tbody{
        height: 300px !important;
    }

    #tblPedidoDetalle tbody td{
        font-weight: bold;  
        left: 20px;
        top: -5px;
    }

    #tblPedidoDetalle tr:hover{
        color:#000;
        background-color: #fff;
    }

</style>
<?php
$this->load->view('vVisualizaPedido');
$this->load->view('vObsPedidoModificaEliminaPedidoSinControl');
