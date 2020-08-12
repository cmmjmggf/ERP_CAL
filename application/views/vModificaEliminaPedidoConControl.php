<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Modifica y elimina pedido con control</legend>
            </div>
            <div class="col-sm-6">
                <button type="button" id="btnRepAsignado" name="btnRepAsignado" class="btn btn-info">
                    <span class="fa fa-exclamation"></span> Rep.Asignado
                </button>
                <button type="button" id="btnVerClientes" name="btnVerClientes" class="btn btn-info">
                    <span class="fa fa-user"></span> Clientes
                </button>
                <button type="button" id="btnObservaciones" name="btnObservaciones" class="btn btn-info d-none">
                    <span class="fa fa-eye"></span> Observaciones
                </button>
                <button type="button" id="btnImprimePedido" name="btnImprimePedido" class="btn btn-info">
                    <span class="fa fa-user"></span> Imprime ped.
                </button>
                <button type="button" id="btnCtrlCancelados" name="btnCtrlCancelados" class="btn btn-info">
                    <span class="fa fa-eye"></span> Ctr-cancelados
                </button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div class="row">
                <div class="col-12 d-none">
                    <label for="">ID</label>
                    <input type="text" id="IDPEDIDO" name="IDPEDIDO" class="form-control form-control-sm numbersOnly d-none">
                </div>
                <div class="col-3">
                    <label for="">Control</label>
                    <input type="text" id="ControlMEPCC" name="ControlMEPCC" class="form-control form-control-sm numbersOnly">
                </div>
                <div class="col-3">
                    <label for="">Pedido</label>
                    <input type="text" id="PedidoMEPCC" name="PedidoMEPCC" class="form-control form-control-sm">
                </div>
                <div class="col-3">
                    <label for="">Cliente</label>
                    <select id="ClienteMEPCC" name="ClienteMEPCC" class="form-control form-control-sm">
                        <option></option>
                        <?php
                        foreach ($this->db->select("C.Clave AS Clave, CONCAT(C.Clave, \" - \",C.RazonS) AS Cliente", false)
                                ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')
                                ->order_by('ABS(C.Clave)', 'ASC')->get()->result() as $k => $v) {
                            print "<option value='{$v->Clave}'>{$v->Cliente}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-3">

                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-8" >
                            <div class="table-responsive" style="overflow-x:auto; white-space: nowrap;">
                                <label class="font-weight-bold" for="Tallas">Tallas</label>
                                <table id="tblTallas" class="Tallas">
                                    <thead></thead>
                                    <tbody>
                                        <tr id="rTallas"  style="justify-content: center; text-align: center;">
                                            <?php
                                            $new_style = "width: 37px;padding-right: 1px;padding-left: 1px; font-weight: bold; ";
                                            for ($i = 1; $i < 23; $i++) {
                                                print '<td><span class="T' . $i . '" style="font-weight: bold; "></span><input type="text" style="' . $new_style . '" maxlength="4" class="numbersOnly d-none" id="xT' . $i . '" name="T' . $i . '" disabled></td>';
                                            }
                                            ?>
                                            <td class="font-weight-bold text-white">Pares</td>
                                        </tr>
                                        <tr>
                                            <?php
                                            for ($index = 1; $index < 23; $index++) {
                                                print '<td><input type="text" style="' . $new_style . '" maxlength="4" class="form-control numbersOnly" id="xC' . $index . '" name="C' . $index . '" onfocus="onCalcularPares(this);" on change="onCalcularPares(this);" keyup="onCalcularPares(this);" onfocusout="onCalcularPares(this);"></td>';
                                            }
                                            ?>
                                            <td><input type="text" style="width: 40px;" maxlength="4" class="form-control numbersOnly font-weight-bold" disabled=""  id="TPares"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                        <div class="col-2">
                            <label>Fecha Entrega</label>
                            <input type="text" id="FechaEntregaModificada" name="FechaEntregaModificada" class="form-control form-control-sm date">
                        </div>
                        <div class="col-2">
                            <button type="button" id="btnModificaRegistro" name="btnModificaRegistro" class="btn btn-sm btn-info">
                                <span class="fa fa-check"></span> Acepta
                            </button>    
                            <button type="button" id="btnModificaRegistroXFecha" name="btnModificaRegistroXFecha" class="btn btn-sm btn-info" style="background-color: #4CAF50; border-color: #4CAF50; font-weight: bold;">
                                <span class="fa fa-check"></span> Acepta (Fecha)
                            </button>    
                        </div>
                    </div>
                </div>
                <!--PEDIDO--> 
                <div class="w-100 my-2"></div>
                <!--SEGUNDO CONTENEDOR-->   
                <table id="tblPedidoDetalle" class="table table-sm table-hover"  style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0--> 
                            <th scope="col">Pedido</th><!--1-->
                            <th scope="col">Fec-ped</th><!--2-->
                            <th scope="col">Fec-Ent</th><!--3-->
                            <th scope="col">Cliente</th><!--4-->
                            <th scope="col">Recibido</th><!--5-->
                            <th scope="col">Estilo</th><!--6-->
                            <th scope="col">Color</th><!--7-->
                            <th scope="col">Sem</th><!--8-->
                            <th scope="col">Maq</th><!--9-->
                            <th scope="col">Ser</th><!--10-->

                            <th scope="col"></th><!--11-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--13-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--15-->

                            <th scope="col"></th><!--16-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--18-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--20-->

                            <th scope="col"></th><!--21-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--23-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--25-->

                            <th scope="col"></th><!--26-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--28-->
                            <th scope="col"></th>
                            <th scope="col"></th><!--30-->

                            <th scope="col"></th><!--31-->
                            <th scope="col"></th><!--32-->

                            <th scope="col">Año</th><!--33-->
                            <th scope="col">Pares</th><!--34-->
                            <th scope="col">Precio</th><!--35-->
                            <th scope="col">Control</th><!--36--> 
                            <th scope="col">Eliminar</th><!--37 -->
                            <th scope="col">STT</th><!--38 -->
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>    
            </div>
        </div>
    </div>
</div> 
<script>
    var pnlTablero = $("#pnlTablero"), PedidoMEPCC = pnlTablero.find("#PedidoMEPCC"),
            ControlMEPCC = pnlTablero.find("#ControlMEPCC"),
            ClienteMEPCC = pnlTablero.find("#ClienteMEPCC"),
            FechaEntregaModificada = pnlTablero.find("#FechaEntregaModificada"),
            TPares = pnlTablero.find("#TPares"), PedidoDetalle,
            tblPedidoDetalle = pnlTablero.find("#tblPedidoDetalle"),
            btnVerClientes = pnlTablero.find("#btnVerClientes"),
            btnImprimePedido = pnlTablero.find("#btnImprimePedido"),
            btnRepAsignado = pnlTablero.find("#btnRepAsignado"),
            btnCtrlCancelados = pnlTablero.find("#btnCtrlCancelados"),
            btnModificaRegistro = pnlTablero.find("#btnModificaRegistro"),
            btnModificaRegistroXFecha = pnlTablero.find("#btnModificaRegistroXFecha");

    var opciones_detalle = {
        dom: 'rtip',
        buttons: buttons,
        "columns": [
            {"data": "PDID"}, {"data": "Pedido"},
            {"data": "FechaPedido"}, {"data": "FechaEntrega"},
            {"data": "Cliente"}, {"data": "Recibido"},
            {"data": "Estilo"}, {"data": "Color"}, {"data": "Semana"},
            {"data": "Maquila"}, {"data": "Serie"},
            {"data": "T1"}, {"data": "T2"}, {"data": "T3"}, {"data": "T4"},
            {"data": "T5"}, {"data": "T6"}, {"data": "T7"}, {"data": "T8"},
            {"data": "T9"}, {"data": "T10"}, {"data": "T11"}, {"data": "T12"},
            {"data": "T13"}, {"data": "T14"}, {"data": "T15"}, {"data": "T16"},
            {"data": "T17"}, {"data": "T18"}, {"data": "T19"}, {"data": "T20"},
            {"data": "T21"}, {"data": "T22"}, {"data": "Ano"},
            {"data": "Pares"}, {"data": "Precio"}, {"data": "Control"},
            {"data": "ELIMINAR"}, {"data": "STT"}
        ],
        "columnDefs": [
            //ID
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            },
            //PEDIDO
            {
                "targets": [1],
                "visible": true,
                "searchable": false
            },
            //PEDIDO
            {
                "targets": [38],
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
        "scrollY": "500px",
        "scrollX": true,
        initComplete: function (x, y) {
            HoldOn.close();
            ControlMEPCC.focus().select();
        }
    };
    $(document).ready(function () {
        handleEnterDiv(pnlTablero);
        PedidoMEPCC.on('keydown', function (e) {
            if (e.keyCode === 13) {
                onOpenOverlay('');
                PedidoDetalle.ajax.reload(function () {
                    onCloseOverlay();
                });
            }
        });
        btnModificaRegistroXFecha.click(function () {
            if (PedidoMEPCC.val() && FechaEntregaModificada.val()) {
                $.post('<?php print base_url('ModificaEliminaPedidoConControl/onModificarFechaXClave') ?>', {
                    CLAVE_PEDIDO: PedidoMEPCC.val(),
                    NUEVA_DE_FECHA_ENTREGA: FechaEntregaModificada.val()
                }).done(function (a) {
                    console.log(a);
                    iMsg("SE HAN GUARDADO LOS CAMBIOS", "s", function () {
                        ControlMEPCC.focus();
                        PedidoDetalle.ajax.reload();
                    });
                }).fail(function (x) {
                    getError(x);
                }).always(function () {

                });
            } else {
                onCampoInvalido(pnlTablero, "DEBE DE ESPECIFICAR LA CLAVE DEL PEDIDO Y LA NUEVA FECHA DE ENTREGA", function () {
                    PedidoMEPCC.focus();
                });
            }
        });
        btnModificaRegistro.click(function () {
            if (ControlMEPCC.val()) {
                var p = {
                    IDPEDIDO: pnlTablero.find("#IDPEDIDO").val(),
                    CLAVE_NUEVO: PedidoMEPCC.val(),
                    FECHA_ENTREGA_NUEVO: FechaEntregaModificada.val(),
                    CLIENTE_NUEVO: ClienteMEPCC.val(),
                    CONTROL: ControlMEPCC.val(),
                    TOTAL_PARES: TPares.val()
                };
                p["CANTIDAD_UNO"] = pnlTablero.find("#xC1").val();
                p["CANTIDAD_DOS"] = pnlTablero.find("#xC2").val();
                p["CANTIDAD_TRES"] = pnlTablero.find("#xC3").val();
                p["CANTIDAD_CUATRO"] = pnlTablero.find("#xC4").val();
                p["CANTIDAD_CINCO"] = pnlTablero.find("#xC5").val();
                p["CANTIDAD_SEIS"] = pnlTablero.find("#xC6").val();
                p["CANTIDAD_SIETE"] = pnlTablero.find("#xC7").val();
                p["CANTIDAD_OCHO"] = pnlTablero.find("#xC8").val();
                p["CANTIDAD_NUEVE"] = pnlTablero.find("#xC9").val();
                p["CANTIDAD_DIEZ"] = pnlTablero.find("#xC10").val();
                p["CANTIDAD_ONCE"] = pnlTablero.find("#xC11").val();
                p["CANTIDAD_DOCE"] = pnlTablero.find("#xC12").val();
                p["CANTIDAD_TRECE"] = pnlTablero.find("#xC13").val();
                p["CANTIDAD_CATORCE"] = pnlTablero.find("#xC14").val();
                p["CANTIDAD_QUINCE"] = pnlTablero.find("#xC15").val();
                p["CANTIDAD_DIESCISEIS"] = pnlTablero.find("#xC16").val();
                p["CANTIDAD_DIECISIETE"] = pnlTablero.find("#xC17").val();
                p["CANTIDAD_DIECIOCHO"] = pnlTablero.find("#xC18").val();
                p["CANTIDAD_DIECINUEVE"] = pnlTablero.find("#xC19").val();
                p["CANTIDAD_VEINTE"] = pnlTablero.find("#xC20").val();
                p["CANTIDAD_VEINTIUNO"] = pnlTablero.find("#xC21").val();
                p["CANTIDAD_VEINTIDOS"] = pnlTablero.find("#xC22").val();

                $.post('<?php print base_url('ModificaEliminaPedidoConControl/onModificarFecha') ?>', p)
                        .done(function (a) {
                            console.log(a);
                            iMsg("SE HAN GUARDADO LOS CAMBIOS", "s", function () {
                                ControlMEPCC.focus();
                                PedidoDetalle.ajax.reload();
                            });
                        }).fail(function (x) {
                    getError(x);
                }).always(function () {

                });
            } else {
                onCampoInvalido(pnlTablero, "DEBE DE ESPECIFICAR UN CONTROL", function () {
                    ControlMEPCC.focus();
                });
            }
        });

        getRecords();

        btnCtrlCancelados.click(function () {
            getVistaPreliminar('<?php print base_url('ControlesCancelados.shoes'); ?>');
        });

        btnRepAsignado.click(function () {
            HoldOn.open({
                theme: 'sk-bounce',
                message: 'Por favor espere...'
            });
            $.post('<?php print base_url('ModificaEliminaPedidoSinControl/getParesPreProgramados'); ?>').done(function (data, x, jq) {
                console.log(data);
                onImprimirReporteFancy(data);
                HoldOn.close();
            }).fail(function (x, y, z) {
                HoldOn.close();
                console.log(x.responseText);
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            });
        });

        btnImprimePedido.click(function () {
            $("#mdlReimprimirPedido").modal('show');
        });

        btnVerClientes.click(function () {
            getVistaPreliminar('<?php print base_url('Clientes.shoes'); ?>');
        });

        ControlMEPCC.keydown(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Espere...'
                });
                $.getJSON('<?php print base_url("ModificaEliminaPedidoConControl/getPedidoXControl"); ?>',
                        {CONTROL: ControlMEPCC.val()})
                        .done(function (a) {
                            if (a.length > 0) {
                                pnlTablero.find("#IDPEDIDO").val(a[0].ID);
                                PedidoMEPCC.val(a[0].Clave);
                                getSerie(a[0].Serie);
                                ClienteMEPCC[0].selectize.setValue(a[0].Cliente);
                                FechaEntregaModificada.val(a[0].FechaEntrega);
                                delete a[0].Clave;
                                delete a[0].Serie;
                                delete a[0].Cliente;
                                $.each(a[0], function (k, v) {
                                    console.log(k, v);
                                    pnlTablero.find("#tblTallas input[name='" + k + "']").val(v);
                                });
                                pnlTablero.find("#tblTallas input[name='C1']").focus().select();
                                PedidoDetalle.ajax.reload();
                            }
                        }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            }
        });
    });

    function onCalcularPares(e) {
        var total = 0;
        $.each(pnlTablero.find("#tblTallas").find("input[name^='C']"), function (k, v) {
            if ($(v).val()) {
                total += parseInt($(v).val());
            }
        });
        TPares.val(total);
    }


    function getSerie(s) {
        $.getJSON('<?php print base_url('ModificaEliminaPedidoConControl/getSerieXControl'); ?>', {
            SERIE: s
        }).done(function (a) {
            $.each(a[0], function (k, v) {
                pnlTablero.find("#tblTallas").find("#rTallas span." + k).text(v);
                pnlTablero.find("#tblTallas input[name='" + k + "']").val(v);
            });
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getRecords() {
        HoldOn.open({
            theme: 'sk-rect',
            message: 'Cargando...'
        });
        temp = 0;
        opciones_detalle.ajax = {
            "url": '<?php print base_url('ModificaEliminaPedidoConControl/getPedidoByID') ?>',
            "dataSrc": "",
            "data": function (d) {
                d.CONTROL = ControlMEPCC.val() ? ControlMEPCC.val() : '';
                d.CLIENTE = ClienteMEPCC.val() ? ClienteMEPCC.val() : '';
                d.PEDIDO = PedidoMEPCC.val() ? PedidoMEPCC.val() : '';
            }
        };
        $.fn.dataTable.ext.errMode = 'throw';
        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
        if ($.fn.DataTable.isDataTable('#tblPedidoDetalle')) {
            tblPedidoDetalle.DataTable().destroy();
        }
        PedidoDetalle = tblPedidoDetalle.DataTable(opciones_detalle);
    }

    function onEliminar(e, id) {
        var p = PedidoDetalle.row($(e).parents('tr')).data();
        console.log(p);
        swal({
            title: "ATENCIÓN",
            text: "VA ELIMINAR EL CONTROL " + p.Control + ", DE ESTE PEDIDO (" + p.Pedido + "), ¿ESTA SEGURO?",
            icon: "info",
            buttons: {
                resumetour: {
                    text: "CANCELAR",
                    value: "cancelar"
                },
                endtour: {
                    text: "ACEPTAR",
                    value: "aceptar"
                }
            }}).then((value) => {
            switch (value) {
                case "aceptar":
                    HoldOn.open({
                        theme: 'sk-rect',
                        message: 'Eliminando...'
                    });
                    $.getJSON('<?php print base_url('ModificaEliminaPedidoConControl/onEliminar'); ?>',
                            {ID: p.PDID, CLAVE: p.Pedido, CONTROL: p.Control})
                            .done(function (a) {
                                onBeep(1);
                                console.log(a);
                                var r = a;
                                switch (parseInt(r.DELETED)) {
                                    case 0:
                                        iMsg('NO SE HA ELIMINADO EL CONTROL PORQUE YA HA SIDO PROCESADO POR DEPARTAMENTO DE CORTE', 'w', function () {
                                            ControlMEPCC.focus().select();
                                        });
                                        break;
                                    case 1:
                                        iMsg('SE HA ELIMINADO EL CONTROL', 's', function () {
                                            ControlMEPCC.focus().select();
                                            PedidoDetalle.ajax.reload();
                                        });
                                        onNotifyOldPC('<span class="fa fa-check"></span>', 'SE HA ELIMINADO EL CONTROL ' + r.CONTROL, 'success', {from: "bottom", align: "center"});
                                        break;
                                }
                            }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                        HoldOn.close();
                    });
                    break;
                case "cancelar":
                    ControlMEPCC.focus().select();
                    break;
            }
        });
    }

    function getVistaPreliminar(url) {
        onBeep(1);
        $.fancybox.open({
            src: url,
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
</script>
<style>
    #tblPedidoDetalle table tbody{
        height: 300px !important;
    }
    table.dataTable tbody>tr.selected, table.dataTable tbody>tr>.selected {
        background-color: #000 !important;
    }

    #tblPedidoDetalle tbody td{
        font-weight: bold; 
        left: 20px;
        top: -5px;
    } 

    div.zoom:hover{
        cursor: pointer;
        background-color: #fff;
    }

    #tblTallas tbody tr:hover {
        background-color: #FFF;
        color: #000 !important;
    }

</style>
<?php
$this->load->view('vVisualizaPedido');
