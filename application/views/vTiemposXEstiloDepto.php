<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Tiempos por estilo departamento</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 d-none">
                <label>ID</label>
                <input type="text" class="form-control form-control-sm d-none" id="ID" maxlength="10" name="ID">
            </div> 
            <div class="col-12 col-sm-6 col-md-4 col-lg-2 col-xl-2">
                <label>Estilo</label>     
                <input type="text" class="form-control form-control-sm" autofocus id="Estilo" name="Estilo" maxlength="10"  min="1" max="10">
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-2 col-xl-2">
                <label>Linea</label>
                <input type="text" class="form-control form-control-sm" id="Linea" maxlength="10" name="Linea">
            </div>  
            <div id="EstiloDescripcion" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 text-center" aling="center"></div>
            <div id="Departamentos" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"></div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-12 col-xl-12 m-2" align="right">
                <button type="button" class="btn btn-primary animated fadeIn" id="btnGuardarTiempo" data-toggle="tooltip" data-placement="top" title="Guardar"><span class="fa fa-save"></span> </button>
                <button type="button" class="btn btn-info animated fadeIn" id="btnImprimirTiempos" data-toggle="tooltip" data-placement="top" title="Imprimir"><span class="fa fa-print"></span> </button>
                <button type="button" class="btn btn-danger animated fadeIn" id="btnCancelarTiempo" data-toggle="tooltip" data-placement="top" title="Cancelar"><span class="fa fa-times"></span> </button>
            </div>
            <div id="TiemposXEstiloDepto" class="table-responsive">
                <table id="tblTiemposXEstiloDepto" class="table table-sm display hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th><!--0-->
                            <th>LINEA</th><!--1-->

                            <th>ESTILO</th><!--2-->
                            <th>DEPARTAMENTO</th><!--3-->

                            <th>TIEMPO</th><!--4--> 
                            <th></th><!--5-->  
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
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div> 

<script>
    var master_url = base_url + 'index.php/TiemposXEstiloDepto/';
    var pnlTablero = $("#pnlTablero");
    var Linea = pnlTablero.find("#Linea"), Estilo = pnlTablero.find("#Estilo");
    var btnGuardarTiempo = pnlTablero.find("#btnGuardarTiempo"), btnCancelarTiempo = pnlTablero.find("#btnCancelarTiempo");
    var TiemposXEstiloDepto;
    var tblTiemposXEstiloDepto = pnlTablero.find("#tblTiemposXEstiloDepto");
    var Departamentos = pnlTablero.find("#Departamentos");
    var nuevo = false;
    var btnImprimirTiempos = $("#btnImprimirTiempos");

    const isValidInput = (x) => {
        return x.val().trim().length > 0 ? true : false;
    };

    $(document).ready(function () {

        btnImprimirTiempos.click(function () {
            var stilo = Estilo.val();
            if (stilo !== '' && stilo.length > 0) {
                onBeep(1);
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var f = new FormData();
                f.append('ESTILO', Estilo.val());
                $.ajax({
                    url: master_url + 'onObtenerTiemposXEstilo',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: f
                }).done(function (data, x, jq) {
                    if (data.length > 0) {
                        $.fancybox.open({
                            src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
                            type: 'iframe',
                            opts: {
                                afterShow: function (instance, current) {
                                    console.info('done!', data);
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
                        onBeep(2);
                        swal({
                            title: "ATENCIÓN",
                            text: "NO EXISTEN TIEMPOS PARA ESTE ESTILO, SE HA ELIMINADO, HA SIDO CAMBIADO O NO EXISTEN REGISTROS",
                            icon: "error"
                        }).then((action) => {
                            onBeep(2);
                            Estilo.focus().select();
                        });
                    }
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN ESTILO', 'warning').then((value) => {
                    Estilo.focus().select();
                });
            }
        });
        btnGuardarTiempo.click(function () {
            if (isValidInput(Linea) && isValidInput(Estilo)) {
                var dptos = [];
                $.each(pnlTablero.find("#Departamentos input.gen"), function () {
                    if ($(this).val().trim().length > 0) {
                        dptos.push({DEPTO: $(this).attr('id'), DEPTOTIME: $(this).val().trim().length > 0 ? parseFloat($(this).val()) : 0});
                    }
                });
                $.post(master_url + 'onGuardarTiempos', {ID: pnlTablero.find("#ID").val(), LINEA: Linea.val(), ESTILO: Estilo.val(), TIEMPOS: JSON.stringify(dptos), N: (nuevo) ? 0 : 1}).done(function (data, x, jq) {
                    onBeep(1);
                    pnlTablero.find("input").val('');
                    Departamentos.html('');
                    TiemposXEstiloDepto.ajax.reload();
                    nuevo = false;
                    Linea.attr('readonly', false);
                    Estilo.attr('readonly', false);
                    Estilo.select().focus();
                    tblTiemposXEstiloDepto.DataTable().column(1).search('').draw();
                    tblTiemposXEstiloDepto.DataTable().column(2).search('').draw();
                    pnlTablero.find("#EstiloDescripcion").html('');
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                }).always(function () {

                });
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'LA LINEA Y EL ESTILO SON NECESARIOS PARA PODER GUARDAR ESTOS TIEMPOS', 'warning').then((value) => {
                    if (!isValidInput(Linea)) {
                        Linea.focus();
                    } else if (!isValidInput(Estilo)) {
                        Estilo.focus();
                    }
                });
            }
        });
        btnCancelarTiempo.click(function () {
            pnlTablero.find("input").val('');
            Departamentos.html('');
            Linea.attr('readonly', false);
            Estilo.attr('readonly', false);
            pnlTablero.find("#EstiloDescripcion").html('');
            Linea.focus();
            tblTiemposXEstiloDepto.DataTable().column(1).search('').draw();
            tblTiemposXEstiloDepto.DataTable().column(2).search('').draw();
            Estilo.val('').focus();
            Linea.removeClass("highlight-input");
             TiemposXEstiloDepto.ajax.reload();
        });
        Linea.on('keydown', function () {
            if (isValidInput(Linea)) {
                TiemposXEstiloDepto.ajax.reload(function () {
                    tblTiemposXEstiloDepto.DataTable().column(1).search($(this).val()).draw();
                });
            } else {
                TiemposXEstiloDepto.ajax.reload(function () {
                    tblTiemposXEstiloDepto.DataTable().column(1).search('').draw();
                });
            }
        });
        Estilo.on('keydown', function (e) {
            var input = $(this);
            if ($(this).val() !== '') {
                TiemposXEstiloDepto.ajax.reload(function () {
                    tblTiemposXEstiloDepto.DataTable().column(2).search($(this).val()).draw();
                });
            } else {
                TiemposXEstiloDepto.ajax.reload(function () {
                    tblTiemposXEstiloDepto.DataTable().column(2).search('').draw();
                });
            }
            if (e.keyCode === 13 && input.val() !== '') {
                $.getJSON(master_url + 'onComprobarEstilo', {ESTILO: input.val()}).done(function (data, x, jq) {
                    if (parseInt(data[0].EXISTE) <= 0) {
                        swal('ATENCIÓN', 'EL ESTILO ESPECIFICADO NO EXISTE', 'warning').then((value) => {
                            input.focus().select();
                        });
                    } else if (parseInt(data[0].EXISTE) > 0) {
                        if (input.val().trim().length > 0) {
                            HoldOn.open({
                                theme: 'sk-cube',
                                message: 'CARGANDO...'
                            });
                            onBeep(1);
                            $.getJSON(master_url + 'getDepartamentosXEstilo', {ESTILO: input.val()}).done(function (data) {
                                if (data.length > 0) {
                                    var dptos = '<div class="row">';
                                    $.each(data, function (k, v) {
                                        dptos += '<div class="col-12 col-sm-4 col-md-3 col-lg-2 col-xl-2">';
                                        dptos += '<label>' + v.Descripcion + '</label>';
                                        dptos += '<input id="' + v.Clave + '" type="text" max="999" maxlength="5" class="form-control form-control-sm gen" placeholder="0.0">';
                                        dptos += '</div>';
                                    });
                                    dptos += '<div class="col-12 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-2 text-center">';
                                    dptos += '<span class="text-info font-weight-bold">TOTAL </span><br>';
                                    dptos += '<span class="text-danger font-weight-bold ed-total">0.00</span>';
                                    dptos += '</div>';
                                    dptos += '</div>';
                                    Departamentos.html(dptos);
                                    Departamentos.find("input:eq(0)").focus().select();
                                    Departamentos.find("input.gen").on('keydown focusout keyup', function () {
                                        onCalcularTotal();
                                    });
                                    Departamentos.find('input').keypress(function (event) {
                                        var charCode = (event.which) ? event.which : event.keyCode;
                                        if (
                                                (charCode !== 45 || $(this).val().indexOf('-') !== -1) && // “-” CHECK MINUS, AND ONLY ONE.
                                                (charCode !== 46 || $(this).val().indexOf('.') !== -1) && // “.” CHECK DOT, AND ONLY ONE.
                                                (charCode < 48 || charCode > 57))
                                            return false;
                                        return true;
                                    });
                                    $.getJSON(master_url + 'onComprobarTiempoXEstiloDeptos', {ESTILO: input.val()}).done(function (dta) {
                                        if (dta.length > 0) {
                                            $.each(dta, function (k, v) {
                                                Departamentos.find("#" + v.CLAVE_DEPARTAMENTO).val(v.TIEMPO);
                                                Linea.val(v.LINEA);
                                                pnlTablero.find("#ID").val(v.ID);
                                            });
                                            Departamentos.find("input:eq(0)").focus().select();
                                            Linea.attr('readonly', true);
                                            Estilo.attr('readonly', true);
                                            nuevo = false;
                                            onCalcularTotal();
                                            getLineaXEstilo(input);
                                        } else {
                                            Linea.addClass("highlight-input");
                                            setTimeout(function () {
                                                Linea.removeClass("highlight-input");
                                            }, 3500);
                                            getLineaXEstilo(input);
                                            Linea.attr('readonly', false);
                                            Estilo.attr('readonly', false);
                                            nuevo = true;
                                        }
                                    }).fail(function (x, y, z) {
                                        console.log(x.responseText);
                                    }).always(function () {

                                    });
                                } else {
                                    onBeep(2);
                                    nuevo = false;
                                    Departamentos.html('');
                                    Linea.val('');
                                    swal('ATENCIÓN', 'EL ESTILO "' + input.val() + ' NO TIENE FICHA TÉCNICA O NO EXISTE', 'warning').then((value) => {
                                        Estilo.focus().select();
                                    });
                                }
                            }).fail(function (x, y, z) {
                                console.log(x.responseText);
                            }).always(function () {
                                HoldOn.close();
                            });
                        } else {
                            onBeep(2);
                            input.focus();
                        }
                    }
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {

                });
            }
        });
        getTiemposXEstilo();
    });
    function getLineaXEstilo(input) {
        $.getJSON(master_url + 'getLineaXEstilo', {ESTILO: input.val()}).done(function (dt) {
            if (dt.length > 0) {
                Linea.val(dt[0].LINEA);
                pnlTablero.find("#EstiloDescripcion").html('<h1>' + dt[0].ESTILO + '</h1>');
            }
        });
    }

    function getTiemposXEstilo() {
        HoldOn.open({
            theme: 'sk-rect',
            message: 'Cargando...'
        });
        var cols = [
            {"data": "ID"}/*0*/,
            {"data": "LINEA"}/*1*/,
            {"data": "ESTILO"}/*2*/,
            {"data": "DEPARTAMENTO"}/*3*/,
            {"data": "TIEMPO"}/*4*/,
            {"data": "IDD"}/*5*/
        ];
        var coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [1],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [2],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [3],
                "visible": true,
                "searchable": true,
                "orderable": false
            },
            {
                "targets": [4],
                "visible": true,
                "searchable": true,
                "orderable": false
            },
            {
                "targets": [5],
                "visible": false,
                "searchable": true,
                "orderable": false
            }
        ];
        const xoptions = {
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getTiemposXEstiloDepto',
                "dataSrc": "",
                "data": function (d) {
                    d.ESTILO = (Estilo.val().trim());
                    d.LINEA = (Linea.val().trim());
                }
            },
            "columns": cols,
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": false,
            "displayLength": 99999999,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "400px",
            "scrollX": true,
            rowGroup: {
                startRender: function (rows, group) {
                    return '<span class="d-none row-id">' + $(rows.data().pluck('ID')).eq(0)[0] + '</span>Linea ' + $(rows.data().pluck('LINEA')).eq(0)[0] + ' | Estilo ' + group + ' | (' + rows.count() + ' dptos) | <span class="btn btn-danger" onclick="onEliminarTiemposXEstiloDeptos(this)"><span class="fa fa-trash"></span></span>';
                },
                endRender: function (rows, group) {
                    var stc = $.number(rows.data().pluck('TIEMPO').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    return $('<tr>').append('<td align="right">Total del estilo ' + group + ', linea ' + $(rows.data().pluck('LINEA')).eq(0)[0] + '</td><td>' + stc + '</td><td></td></tr>');
                },
                dataSrc: "ESTILO"
            },
            createdRow: function (row, data, dataIndex) {
            },
            initComplete: function (a, b) {
                HoldOn.close();

            }
        };
        TiemposXEstiloDepto = tblTiemposXEstiloDepto.DataTable(xoptions);
        tblTiemposXEstiloDepto.on('click', 'tr', function () {
            var data = TiemposXEstiloDepto.row(this).data();
        });
        Estilo.focus();
    }

    function onEliminarTiemposXEstiloDeptos(r) {
        onBeep(2);
        swal({
            buttons: ["Cancelar", "Aceptar"],
            title: 'Estás Seguro?',
            text: "Esta acción eliminará los tiempos de todos los departamento de esta linea/estilo",
            icon: "warning",
            closeOnEsc: false,
            closeOnClickOutside: false
        }).then((action) => {
            if (action) {
                onBeep(1);
                var IDX = $(r).parents('.group-start').find("span.row-id").text();
                $.post(master_url + 'onEliminarDeptosXEstilo', {ID: IDX}).done(function (data) {
                    swal({
                        title: 'ATENCIÓN',
                        text: 'SE HAN ELIMINADO LOS TIEMPOS DE ESTE ESTILO',
                        icon: 'success',
                        timer: 2000
                    });
                    btnCancelarTiempo.trigger('click');
                    TiemposXEstiloDepto.ajax.reload();
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    swal('ATENCIÓN', 'NO HA SIDO POSIBLE ELIMINAR ESTE TIEMPO, VERIFIQUE LA CONSOLA.', 'warning');
                }).always(function () {
                });
            }
        });
    }

    function onEliminarDeptoXEstilo(r) {
        onBeep(2);
        swal({
            buttons: ["Cancelar", "Aceptar"],
            title: 'Estás Seguro?',
            text: "Esta acción eliminará el tiempo en este departamento de esta linea/estilo",
            icon: "warning",
            closeOnEsc: false,
            closeOnClickOutside: false
        }).then((action) => {
            if (action) {
                var row = TiemposXEstiloDepto.row($(r).parents('tr')).data();
                $.post(master_url + 'onEliminarDeptoXEstilo', {ID: row.ID, IDD: row.IDD}).done(function (data) {
                    btnCancelarTiempo.trigger('click');
                    TiemposXEstiloDepto.row($(r).parents('tr')).remove().draw();
                    swal({
                        title: 'INFO',
                        text: 'SE HA EL TIEMPO DE ESTE ESTILO',
                        icon: 'success',
                        timer: 2000
                    }).then((value) => {
                        Estilo.focus();
                    });
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    swal('ATENCIÓN', 'NO HA SIDO POSIBLE ELIMINAR ESTE TIEMPO, VERIFIQUE LA CONSOLA.', 'warning');
                }).always(function () {
                    Estilo.focus();
                });
            } else {
                Estilo.focus();
            }
        });
    }

    function onCalcularTotal() {
        var t = 0;
        $.each(Departamentos.find("input.gen"), function (k, v) {
            var v = $(this);
            t += $.isNumeric($(v).val()) ? parseFloat($(v).val()) : 0;
        });
        Departamentos.find("span.ed-total").text($.number(t, 2, '.', ','));
    }
</script>
<style> 
    table.dataTable tr.group td{
        font-size: 14px;
        font-weight: normal;
    }

    table tbody tr.group-start:hover,table tbody tr.group-end:hover{
        background-color: #2C3E50;
        color: #000 !important;
    }

    tbody tr.group-start:hover td, table tbody tr.group-end:hover td{
        background-color: #2C3E50;
        color: #FFEB3B !important;
    }

    .highlight-input{  
        color: #000;
        background:#e1fcff;
        animation: myfirst .4s;
        -moz-animation:myfirst .4s infinite; /* Firefox */
        -webkit-animation:myfirst .4s infinite; /* Safari and Chrome */
    }

    .form-control[readonly].highlight-input {
        color: #000;
        background:#e1fcff;
        animation: myfirst .4s;
        -moz-animation:myfirst .4s infinite; /* Firefox */
        -webkit-animation:myfirst .4s infinite; /* Safari and Chrome */
    }

    @-moz-keyframes myfirst /* Firefox */
    {
        0%   {    border: 1px solid #2196F3}
        50%  {    border: 1px solid #ff0000;        font-weight: bold;}
        100%   {border: 1px solid #2196F3}
    }

    @-webkit-keyframes myfirst /* Firefox */
    {
        0%   {    border: 1px solid #2196F3}
        50%  {    border: 1px solid #ff0000;font-weight: bold;}
        100%   {border: 1px solid #2196F3}
    }
</style>