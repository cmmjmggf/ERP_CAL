<script src="<?php print base_url('js/swal2/sweetalert2@10.js'); ?>"></script>
<div class="card m-2 " id="pnlTablero">
    <div class="card-body" style="padding-top: 5px;">
        <div class="row" >
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <h5 class="font-weight-bold ">
                    <span class="fa fa-file"></span> PROGRAMACION PROVEEDURÍA</h5>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label>TP</label>
                <input type="text" id="PPTP" name="PPTP" class="form-control" autofocus="" maxlength="1">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Del Proveedor</label> 
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="PPClaveDelProveedor" name="PPClaveDelProveedor" maxlength="5" required="">
                    </div>
                    <div class="col-9">
                        <select id="PPDelProveedor" name="PPDelProveedor" class="form-control form-control-sm required" required="" >
                            <option value=""></option>
                            <?php
                            $proveedores = $this->db->select("P.Clave AS ID, "
                                                    . "CONCAT(IFNULL(P.NombreI,'')) AS ProveedorI, "
                                                    . "CONCAT(IFNULL(P.NombreF,'')) AS ProveedorF ", false)
                                            ->from("proveedores AS P")->get()->result();
                            foreach ($proveedores as $k => $v) {
                                print "<option value='{$v->ID}'>{$v->ID} {$v->ProveedorF}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Al Proveedor</label> 
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="PPClaveAlProveedor" name="PPClaveAlProveedor" maxlength="5">
                    </div>
                    <div class="col-9">
                        <select id="PPAlProveedor" name="PPAlProveedor" class="form-control form-control-sm required" required="" >
                            <option value=""></option>
                            <?php
                            foreach ($proveedores as $k => $v) {
                                print "<option value='{$v->ID}'>{$v->ID} {$v->ProveedorF}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Tipo</label>
                <select class="form-control form-control-sm" id="PPTipo" name="PPTipo" >
                    <option value=""></option>
                    <option value="0">0 DIRECTAS</option>
                    <option value="10">10 PIEL Y FORRO</option>
                    <option value="80">80 SUELA</option>
                    <option value="90">90 INDIRECTOS</option>
                </select> 
                <span class="badge badge-info mb-2" style="font-size: 12px;">0 DIRECTAS, 10 Piel/Forro, 80 Suela, 90 Peletería</span>
            </div> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-1 col-xl-1 mt-4">
                <?PHP

                function CreateButton($id, $tipo, $nombre, $icon, $funcion, $class, $style) {
                    if ($icon !== '') {
                        print "<button type='button' id='{$id}' name='{$id}' class='btn btn-{$tipo}{$class}' style='{$style}'><span class='fa fa-{$icon}'></span> {$nombre}</button>";
                    } else {
                        print "<button type='button' id='{$id}' name='{$id}' class='btn btn-{$tipo}{$class}' style='{$style}'>{$nombre}</button>";
                    }
                }

                CreateButton("btnAcepta", "info m-1", "ACEPTA", "check", null, "", null);
                ?>
            </div> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-1 col-xl-1 mt-4">
                <?PHP
                CreateButton("btnImprimePP", "success m-1", "IMPRIMIR", "print", null, "", "background-color:#000;");
                ?>
            </div> 
            <div class="col-12">
                <table id="tblAntiguedadSaldosDelProveedor" class="table table-hover table-sm" style="width: 100%;">
                    <thead>
                        <tr style="font-weight: bold;
                            text-align: center;
                            font-style: italic; 
                            background-color: #000;
                            color: #fff;
                            font-size: 16px;">
                            <th scope="col">-</th> 
                            <th scope="col">PROVEEDOR</th> 
                            <th scope="col">TP</th> 
                            <th scope="col">-</th> 

                            <th scope="col">DOC</th> 
                            <th scope="col">FECHA</th> 
                            <th scope="col">IMPORTE</th>
                            <th scope="col">PAGOS</th>

                            <th scope="col">SALDO</th> 
                            <th scope="col">DIAS</th> 

                            <th scope="col">0-7</th> 
                            <th scope="col">8-15</th>                              
                            <th scope="col">16-21</th> 

                            <th scope="col">22-30</th> 
                            <th scope="col">31-37</th> 
                            <th scope="col">38-45</th> 

                            <th scope="col">46-52</th> 
                            <th scope="col">53-60</th> 
                            <th scope="col">Mas de 61</th> 

                            <th scope="col">Clave</th> 
                            <th scope="col">-</th> 
                            <th scope="col">-</th> 
                            <th scope="col">-</th> 
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), PPTP = pnlTablero.find('#PPTP'),
            PPClaveDelProveedor = pnlTablero.find('#PPClaveDelProveedor'),
            PPDelProveedor = pnlTablero.find('#PPDelProveedor'),
            PPClaveAlProveedor = pnlTablero.find('#PPClaveAlProveedor'),
            PPAlProveedor = pnlTablero.find('#PPAlProveedor'),
            PPTipo = pnlTablero.find('#PPTipo'),
            tblAntiguedadSaldosDelProveedor = pnlTablero.find('#tblAntiguedadSaldosDelProveedor'),
            AntiguedadSaldosDelProveedor, btnAcepta = pnlTablero.find("#btnAcepta"),
            btnImprimePP = pnlTablero.find("#btnImprimePP");

    function onCalcularMontoSeleccionado() {
        tblAntiguedadSaldosDelProveedor.find("tbody tr:not(.group-start):not(.group-end) td:nth-child(1) input[type='checkbox']:not(:checked)").parent().parent().parent().parent().removeClass("row-selected");
        
        $.each(tblAntiguedadSaldosDelProveedor.find("tbody tr:not(.group-start):not(.group-end)"), function (k, v) {
            var row = $(v).find("td");
            var is_checked = row.eq(0).find("input[type='checkbox']");
            var tr = AntiguedadSaldosDelProveedor.row(v).data();
            if (is_checked[0].checked) {
                $(v).addClass("row-selected");
                var tr = AntiguedadSaldosDelProveedor.row(v).data();
                $.post('<?php print base_url('ProgramacionProveeduria/onMarcarParaPago'); ?>', {
                    ID: tr.ID
                });
            }
        });
        onSumarTodoLoSeleccionado();
        onBeep(3);
    }

    var total_seleccionado = 0;
    function onSeleccionarTodoXProveedor(e) {
        tblAntiguedadSaldosDelProveedor.find("tbody tr:not(.group-start):not(.group-end) td:nth-child(1) input[type='checkbox']:not(:checked)").parent().parent().parent().parent().removeClass("row-selected");
        $.each($(e).parents("tr.group-start").nextUntil("tr.group-end").find("td:eq(0) input[type='checkbox']")
                , function (k, v) {
                    if ($(e)[0].checked) {
                        $(v).parents("tr").addClass("row-selected");
                        $(v)[0].checked = true;
                    } else {
                        $(v).parents("tr").removeClass("row-selected");
                        $(v)[0].checked = false;
                    }
                    var tr = AntiguedadSaldosDelProveedor.row($(v).parents("tr")).data();

                });
        onSumarTodoLoSeleccionado();
        onBeep(3);
    }

    function  onSumarTodoLoSeleccionado() {
        total_seleccionado = 0;
        $.each(tblAntiguedadSaldosDelProveedor.find("tbody tr:not(.group-start):not(.group-end)").find("td:eq(0) input[type='checkbox']:checked")
                , function (k, v) {
                    var tr = AntiguedadSaldosDelProveedor.row($(v).parents("tr")).data();
                    total_seleccionado += parseFloat(tr.Saldo_Doc);
                });
        pnlTablero.find("#TOTAL_SELECCIONADO").text("$ " + $.number(total_seleccionado, 2, '.', ','));
    }

    onOpenOverlay('');
    $(document).ready(function () {

        btnImprimePP.click(function () {
            var rows = tblAntiguedadSaldosDelProveedor.find("tbody tr:not(.group-start):not(.group-end)"),
                    rows_checked = rows.find("td:nth-child(1) input[type='checkbox']:checked");
            if (PPTP.val() && PPClaveDelProveedor.val() && PPClaveAlProveedor.val()) {
                if (rows_checked.length > 0) {
                    onOpenOverlay('Generando reporte...');
                    onDisableOnTime(btnImprimePP, 500);
                    var movimientos = [];
                    $.each(rows.find("td:nth-child(1) input[type='checkbox']:checked"), function (k, v) {
                        var r = AntiguedadSaldosDelProveedor.row($(v).parent().parent().parent().parent()).data();
                        movimientos.push(r.ID);
                    });
                    $.post('<?php print base_url('ProgramacionProveeduria/onImprimirAntiguedadDeSaldos'); ?>', {
                        MOVIMIENTOS: JSON.stringify(movimientos),
                        TP: PPTP.val()
                    }).done(function (a) {
                        if (a.length > 0) {
                            onImprimirReporteFancyAFC(a, function (a, b) {
                            });
                        }
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                        onCloseOverlay();
                    });
                } else {
                    onCampoInvalidoSW2(pnlTablero, "DEBE DE SELECCIONAR AL MENOS UN MOVIMIENTO.", function () {
                        rows.find("td:nth-child(1)").addClass("movimiento-no-seleccionado");
                        setTimeout(function () {
                            rows.find("td:nth-child(1)").removeClass("movimiento-no-seleccionado");
                        }, 2000);
                    });
                    return;
                }
            } else {
                if (!PPTP.val()) {
                    onCampoInvalidoSW2(pnlTablero, "DEBE DE ESPECIFICAR UN TP(1,2)", function () {
                        PPTP.focus();
                    });
                    return;
                }
            }
        });
        var cols = [
            {"data": "ID"}/*0*/,
            {"data": "ProveedorF"}/*1*/,
            {"data": "Tp"}/*2*/,
            {"data": "SELECCIONA"}/*3*/,
            {"data": "Doc"}/*4*/,
            {"data": "FechaDoc"}/*5*/,
            {"data": "IMPORTE"}/*6*/,
            {"data": "PAGOS"}/*7*/,
            {"data": "SALDO"}/*7*/,
            {"data": "Dias"}/*8*/,
            {"data": "UNO_F"}/*9*/,
            {"data": "DOS_F"}/*10*/,
            {"data": "TRES_F"}/*11*/,
            {"data": "CUATRO_F"}/*12*/,
            {"data": "CINCO_F"}/*13*/,
            {"data": "SEIS_F"}/*14*/,
            {"data": "SIETE_F"}/*15*/,
            {"data": "OCHO_F"}/*16*/,
            {"data": "NUEVE_F"}/*17*/, {"data": "ClaveNum"}/*18*/,
            {"data": "ImporteDoc"}/*19*/,
            {"data": "Saldo_Doc"}/*20*/,
            {"data": "UNO"}/*21*/,
            {"data": "DOS"}/*22*/,
            {"data": "TRES"}/*23*/,
            {"data": "CUATRO"}/*24*/,
            {"data": "CINCO"}/*25*/,
            {"data": "SEIS"}/*26*/,
            {"data": "SIETE"}/*27*/,
            {"data": "OCHO"}/*28*/,
            {"data": "NUEVE"}/*29*/,
            {"data": "PLAZO"}/*30*/,
        ];
        var coldefs = [
            {
                "targets": [0, 2, 21, 20, 19, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [1],
                "visible": false,
                "searchable": true
            }
        ];
        var xoptions = {
            "dom": 'ritp',
            "ajax": {
                "url": '<?php print base_url('ProgramacionProveeduria/getDocumentosXTipo'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.TP = PPTP.val() ? PPTP.val() : '';
                    d.PROVEEDOR_INICIAL = PPClaveDelProveedor.val() ? PPClaveDelProveedor.val() : '';
                    d.PROVEEDOR_FINAL = PPClaveAlProveedor.val() ? PPClaveAlProveedor.val() : '';
                    d.TIPO = PPTipo.val() ? PPTipo.val() : '';
                }
            },
            buttons: buttons,
            "columns": cols,
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 99999,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true, "scrollY": $(window).height() - 350,
            "scrollX": true,
            "aaSorting": [
                [2, 'ASC']
            ],
            rowGroup: {
                startRender: function (rows, group) {
                    return '<div class="checkbox-big" style=" cursor:pointer;">' +
                            '<label style="font-size: 22px; cursor:pointer;">' +
                            '<input type="checkbox"  onClick="onSeleccionarTodoXProveedor(this)">' +
                            '<span class="cr"><i class="cr-icon fa fa-check fa-lg" style="cursor:pointer;"></i></span>' + group + '(' + rows.count() + ') ===> PLAZO ' + rows.data()[0].PLAZO + ' DÍAS.</label>' +
                            '</div>';
                },
                endRender: function (rows, group) {
//                    console.log(rows.data().pluck('UNO'));
                    var SALDO_DOC = $.number(rows.data().pluck('Saldo_Doc').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var PAGOS_DOC = $.number(rows.data().pluck('Pagos_Doc').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var IMPORTE_DOC = $.number(rows.data().pluck('ImporteDoc').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var IMPORTE_UNO = $.number(rows.data().pluck('UNO').reduce(function (a, b) {
                        b = $.isNumeric(b) ? b : 0;
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var IMPORTE_DOS = $.number(rows.data().pluck('DOS').reduce(function (a, b) {
                        b = $.isNumeric(b) ? b : 0;
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var IMPORTE_TRES = $.number(rows.data().pluck('TRES').reduce(function (a, b) {
                        b = $.isNumeric(b) ? b : 0;
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var IMPORTE_CUATRO = $.number(rows.data().pluck('CUATRO').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var IMPORTE_CINCO = $.number(rows.data().pluck('CINCO').reduce(function (a, b) {
                        b = $.isNumeric(b) ? b : 0;
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var IMPORTE_SEIS = $.number(rows.data().pluck('SEIS').reduce(function (a, b) {
                        b = $.isNumeric(b) ? b : 0;
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var IMPORTE_SIETE = $.number(rows.data().pluck('SIETE').reduce(function (a, b) {
                        b = $.isNumeric(b) ? b : 0;
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var IMPORTE_OCHO = $.number(rows.data().pluck('OCHO').reduce(function (a, b) {
                        b = $.isNumeric(b) ? b : 0;
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var IMPORTE_NUEVE = $.number(rows.data().pluck('NUEVE').reduce(function (a, b) {
                        b = $.isNumeric(b) ? b : 0;
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    return $('<tr>').append('<td></td><td></td><td>TOTAL</td>\n\
            <td >$' + IMPORTE_DOC + '</td>\n\
            <td >$' + PAGOS_DOC + '</td>\n\
            <td >$' + SALDO_DOC + '</td></td><td>\n\
            <td >$' + IMPORTE_UNO + '</td>\n\
            <td >$' + IMPORTE_DOS + '</td>\n\
            <td >$' + IMPORTE_TRES + '</td>\n\
            <td >$' + IMPORTE_CUATRO + '</td>\n\
            <td >$' + IMPORTE_CINCO + '</td>\n\
            <td >$' + IMPORTE_SEIS + '</td>\n\
            <td >$' + IMPORTE_SIETE + '</td>\n\
            <td >$' + IMPORTE_OCHO + '</td>\n\
            <td >$' + IMPORTE_NUEVE + '</td></tr>');
                },
                dataSrc: "ProveedorF"
            },
            "drawCallback": function (settings) {
                var api = this.api();
            },
            initComplete: function () {
                onCloseOverlay();
            }
        };
        if ($.fn.DataTable.isDataTable('#tblFraccionesPagadasFail')) {
            AntiguedadSaldosDelProveedor.ajax.reload();
            return;
        } else {
            AntiguedadSaldosDelProveedor = tblAntiguedadSaldosDelProveedor.DataTable(xoptions);
        }

        btnAcepta.click(function () {
            if (PPTP.val()) {
                onDisableOnTime(btnAcepta, 2000);
                onOpenOverlay('Cargando...');
                AntiguedadSaldosDelProveedor.ajax.reload(function () {
                    var info = pnlTablero.find("#tblAntiguedadSaldosDelProveedor_info").text();
                    pnlTablero.find("#tblAntiguedadSaldosDelProveedor_info").html("<p id='TOTAL_SELECCIONADO' class='font-weight-bold text-center' style='margin-bottom: 0px; color: #3f51b5; font-size: 30px;'>-</p>" + info);
                    onCloseOverlay();
                });
            } else {
                if (!PPTP.val()) {
                    onCampoInvalidoSW2(pnlTablero, "DEBE DE ESPECIFICAR UN TP(1,2)", function () {
                        PPTP.focus();
                    });
                    return;
                }
            }
        });

        PPTipo.change(function () {
            btnAcepta.focus();
        });
        pnlTablero.find("#PPTipo-selectized").keydown(function (e) {
            if (e.keyCode === 13) {
                btnAcepta.focus();
            }
        });


        PPClaveAlProveedor.keydown(function (e) {
            if (e.keyCode === 13 && PPClaveAlProveedor.val()) {
                PPAlProveedor[0].selectize.setValue(PPClaveAlProveedor.val());
                PPTipo[0].selectize.focus();
                return;
            }
            if (e.keyCode === 8 && PPClaveAlProveedor.val() === '') {
                onClear(PPAlProveedor);
            }
        });

        PPClaveDelProveedor.keydown(function (e) {
            if (e.keyCode === 13 && PPClaveDelProveedor.val()) {
                PPDelProveedor[0].selectize.setValue(PPClaveDelProveedor.val());
                PPClaveAlProveedor.focus();
                return;
            }
            if (e.keyCode === 8 && PPClaveDelProveedor.val() === '') {
                onClear(PPDelProveedor);
            }
        });

        PPTP.keydown(function (e) {
            if (e.keyCode === 13 && PPTP.val()) {
                switch (parseInt(PPTP.val())) {
                    case 1:
                    case 2:
                        PPClaveDelProveedor.focus().select();
                        break;
                    default:
                        onCampoInvalidoSW2(pnlTablero, "DEBE DE ESPECIFICAR UN TIPO 1 O 2", function () {
                            PPTP.focus().select();
                        });
                        break;
                }
            }
        });
    });

    function onCampoInvalidoSW2(pnl, msj, fun) {
        $.each($("body").find("select[multiple='multiple']:enabled"), function (k, v) {
            $(v).addClass('campo_no_valido');
            onDisable($(v));
        });
        $.each($("body").find("select.selectized:enabled"), function (k, v) {
            $(v).addClass('campo_no_valido');
            onDisable($(v));
        });
        $.each($("body").find("button:enabled"), function (k, v) {
            $(v).addClass('disabledForms');
            $(v).addClass('boton_no_valido');
            onDisable($(v));
        });
        $("body").find("input:enabled,textarea:enabled").addClass('campo_no_valido').attr('disabled', true);
        onBeep(2);
        setTimeout(function () {
            Swal.fire({
                icon: 'error',
                title: 'ATENCIÓN', text: msj,
                allowEnterKey: true,
                allowOutsideClick: false,
                willClose: () => {
                    $.each($("body").find("select.campo_no_valido:disabled"), function (k, v) {
                        $(v).removeClass('campo_no_valido');
                        onEnable($(v));
                    });
                    $.each($("body").find("button.boton_no_valido:disabled"), function (k, v) {
                        $(v).removeClass('disabledForms');
                        $(v).removeClass('boton_no_valido');
                        onEnable($(v));
                    });
                    $("body").find("input.campo_no_valido:disabled,textarea.campo_no_valido:disabled").removeClass('campo_no_valido').attr('disabled', false);
                    pnl.find("input.campo_no_valido:disabled,textarea.campo_no_valido:disabled").removeClass('campo_no_valido').attr('disabled', false);
                    fun();
                }
            });
        }, 10);
    }
</script>

<style>
    .movimiento-no-seleccionado{
        background:red;
        animation:movns 0.25s;
        -moz-animation:movns 0.25s infinite; /* Firefox */
        -webkit-animation:movns 0.25s infinite; /* Safari and Chrome */
    }


    @-moz-keyframes movns /* Firefox */
    {
        0%   {background:red;}
        50%  {background:yellow;}
        100%   {background:red;}
    }

    @-webkit-keyframes movns /* Firefox */
    {
        0%   {background:red;}
        50%  {background:yellow;}
        100%   {background:red;}
    }

    #tblAntiguedadSaldosDelProveedor_info{
        padding-top: 0px;
    }
    .row-selected{
        background-color: #4caf50 !important;
    }
    .checkbox-big label:after, 
    .radio label:after {
        content: '';
        display: table;
        clear: both;
    }

    .checkbox-big .cr,
    .radio .cr {
        position: relative;
        display: inline-block;
        border: 1px solid #a9a9a9;
        border-radius: .25em;
        width: 1.3em;
        height: 1.3em;
        float: left;
        margin-right: .5em;
    }

    .radio .cr {
        border-radius: 50%;
    }

    .checkbox-big .cr .cr-icon,
    .radio .cr .cr-icon {
        position: absolute; 
        line-height: 0;
        top: 0%;
        left: 0%;
    }

    .radio .cr .cr-icon {
        margin-left: 0.04em;
    }

    .checkbox-big label input[type="checkbox"],
    .radio label input[type="radio"] {
        display: none;
    }

    .checkbox-big label input[type="checkbox"] + .cr > .cr-icon,
    .radio label input[type="radio"] + .cr > .cr-icon {
        opacity: 0;
    }

    .checkbox-big label input[type="checkbox"]:checked + .cr > .cr-icon,
    .radio label input[type="radio"]:checked + .cr > .cr-icon {
        transform: scale(1) rotateZ(0deg);
        opacity: 1;
    }

    .checkbox-big label input[type="checkbox"]:disabled + .cr,
    .radio label input[type="radio"]:disabled + .cr {
        opacity: .5;
    }
    #tblAntiguedadSaldosDelProveedor thead tr th{
        font-weight: bold;
        text-align: center;
        font-style: italic; 
        background-color: #000;
        color: #fff;
        font-size: 18px;
    }    
    #tblAntiguedadSaldosDelProveedor tbody tr td{
        font-weight: bold;
        text-align: center;
        font-size: 17px;
        justify-content: center;
    }      
    #tblAntiguedadSaldosDelProveedor tbody tr td:nth-child(3),  
    #tblAntiguedadSaldosDelProveedor tbody tr td:nth-child(4){ 
        text-align: center !important; 
        justify-content: center !important;
    }    
    table.dataTable tr.group-start td {
        font-style: italic;
        text-align: left !important;
        background-color: #cccccc;
        color: #000;
        font-size: 18px;
    } 
    table.dataTable tr.group-start:hover td {
        font-style: italic;
        text-align: left !important;
        background-color: #000;
        color: #fff;
        font-size: 16px;
    } 
    table.dataTable tr.group-end td {
        font-style: italic;
        background-color: #cccccc;
        color: #000;
        font-size: 14px;
    } 
    table.dataTable tr.group-end:hover td {
        font-style: italic;
        background-color: #000;
        color: #fff;
        font-size: 14px;
    } 
</style>