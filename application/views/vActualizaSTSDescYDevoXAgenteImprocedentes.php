<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Actualiza Estatus-descuentos improcedentes y devoluciones por recibir</legend>
            </div>
            <div class="col-sm-4" align="right">
                <button type="button" class="btn btn-danger btn-sm " id="C" onclick="onImprimirReportes()">
                    <span class="fa fa-file-pdf" ></span> IMPRIMIR
                </button>
                <button type="button" class="btn btn-danger btn-sm " id="XC" onclick="onImprimirReporteXCliente()">
                    <span class="fa fa-file-pdf" ></span> IMPRIMIR X CLIENTE
                </button>

            </div>
        </div>
        <hr>
        <div class="row ">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Tp" maxlength="1" required="">
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                <label for="" >Agente</label>
                <select id="Agente" name="Agente" class="form-control form-control-sm required" required="" >
                    <option value=""></option>
                    <?php
                    foreach ($this->db->select("C.Clave AS CLAVE, CONCAT(c.Clave,'-',C.Nombre) AS AGENTE ", false)
                            ->from('agentes AS C')->order_by('abs(C.Clave)', 'ASC')->get()->result() as $k => $v) {
                        print "<option value='{$v->CLAVE}'>{$v->AGENTE}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mt-1">
            <!--primer columna-->
            <div class="col-6 border border-info border-left-0  border-bottom-0">
                <div class="row">
                    <!--Primer tabla-->
                    <div class="col-12 mt-1" >
                        <label>Descuentos Improcedentes </label>
                        <div class="card-block">
                            <div id="DescuentosImprocedentes" class="datatable-wide">
                                <table id="tblDescuentosImprocedentes" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Docto</th>
                                            <th>Importe</th>
                                            <th>Mov</th>
                                            <th>Concepto</th>
                                            <th class="d-none">Tp</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Total:</th>
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
                    <div class="w-100 border border-info mt-1 border-right-0  border-left-0 border-bottom-0"></div>
                    <!--segunda tabla-->
                    <div class="col-12 mt-2" >
                        <label>Devoluciones Improcedentes</label>
                        <div class="card-block ">
                            <div id="DevolucionesImprocedentes">
                                <table id="tblDevolucionesImprocedentes" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Docto</th>
                                            <th>Importe</th>
                                            <th>Mov</th>
                                            <th>Concepto</th>
                                            <th class="d-none">Tp</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Total:</th>
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
                    <div class="col-12" align="center">
                        <span class="badge badge-danger" style="font-size: 13px !important;">Doble click pasa el documento a descontadas al agente</span>
                    </div>
                </div>
            </div>
            <!--segunda columna-->
            <div class="col-6 border border-info border-right-0  border-left-0 border-bottom-0">
                <div class="row">
                    <!--Tercer tabla-->
                    <div class="col-12 mt-1" >
                        <label>Descontadas a agente</label>
                        <div class="card-block">
                            <div id="DescDescontadasAgente" class="datatable-wide">
                                <table id="tblDescDescontadasAgente" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Docto</th>
                                            <th>Importe</th>
                                            <th>Mov</th>
                                            <th>Concepto</th>
                                            <th class="d-none">Tp</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Total:</th>
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
                    <div class="w-100 border border-info mt-1 border-right-0  border-left-0 border-bottom-0"></div>
                    <!--Cuarta tabla-->
                    <div class="col-12 mt-2" >
                        <label>Descontadas a agente</label>
                        <div class="card-block ">
                            <div id="DevDescontadasAgente">
                                <table id="tblDevDescontadasAgente" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Docto</th>
                                            <th>Importe</th>
                                            <th>Mov</th>
                                            <th>Concepto</th>
                                            <th class="d-none">Tp</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Total:</th>
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
                    <div class="col-12" align="center">
                        <span class="badge badge-info" style="font-size: 13px !important;">Doble click eimina el documento ya pagado x agente</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    var master_url = base_url + 'index.php/ActualizaSTSDescYDevoXAgenteImprocedentes/';
    var pnlTablero = $("#pnlTablero");
    var tblDescuentosImprocedentes = $('#tblDescuentosImprocedentes');
    var DescuentosImprocedentes;
    var tblDescDescontadasAgente = $('#tblDescDescontadasAgente');
    var DescDescontadasAgente;
    var tblDevolucionesImprocedentes = $('#tblDevolucionesImprocedentes');
    var DevolucionesImprocedentes;
    var tblDevDescontadasAgente = $('#tblDevDescontadasAgente');
    var DevDescontadasAgente;

    $(document).ready(function () {
        init();
        pnlTablero.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTp($(this));
                }
            }
        });
        pnlTablero.find("#Agente").change(function () {
            var agente = $(this).val();
            var tp = pnlTablero.find("#Tp").val();
            if (agente) {
                getDescImprocedentes(tp, agente);
                getDescDescImprocedentes(tp, agente);
                getDevImprocedentes(tp, agente);
                getDevDescImprocedentes(tp, agente);
            }
        });
    });
    function init() {
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#Tp").focus();
        getDescImprocedentes(0, 0);
        getDescDescImprocedentes(0, 0);
        getDevImprocedentes(0, 0);
        getDevDescImprocedentes(0, 0);
    }
    var height = 230;
    function getDescImprocedentes(tp, agente) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDescuentosImprocedentes')) {
            tblDescuentosImprocedentes.DataTable().destroy();
        }
        DescuentosImprocedentes = tblDescuentosImprocedentes.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getDescImprocedentes',
                "dataSrc": "",
                "data": {Tp: tp, Agente: agente},
                "type": "GET"
            },
            "columns": [
                {"data": "cliente"},
                {"data": "docto"},
                {"data": "importe"},
                {"data": "mov"},
                {"data": "doctopa"},
                {"data": "tp"}
            ],
            "columnDefs": [
                {
                    "targets": [2],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [5],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 400,
            "scrollX": true,
            "scrollY": height,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc'], [1, 'asc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 1:
                            /*FECHA ENTREGA*/
                            c.addClass('text-info text-strong');
                            break;
                    }
                });
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                var total = api.column(2).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(2).footer()).html(api.column(3, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(total), 2, '.', ',');
                }, 0));
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblDescuentosImprocedentes.find('tbody').on('click', 'tr', function () {
            tblDescuentosImprocedentes.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        tblDescuentosImprocedentes.find('tbody').on('dblclick', 'tr', function () {
            var dtm = DescuentosImprocedentes.row(this).data();
            swal({
                title: "DESEAS MOVER REGISTRO CARGADO AL AGENTE?",
                text: "Cliente: " + dtm.cliente + "\n " + "Docto: " + dtm.docto + "\n Importe: $" + $.number(parseFloat(dtm.importe), 2, '.', ','),
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"]
            }).then((value) => {
                if (value) {
                    $.post(master_url + 'onCargarAAgentes', {ID: dtm.tp}).done(function () {
                        DescuentosImprocedentes.ajax.reload();
                        DescDescontadasAgente.ajax.reload();
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            });
        });
    }
    function getDescDescImprocedentes(tp, agente) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDescDescontadasAgente')) {
            tblDescDescontadasAgente.DataTable().destroy();
        }
        DescDescontadasAgente = tblDescDescontadasAgente.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getDescDescImprocedentes',
                "dataSrc": "",
                "data": {Tp: tp, Agente: agente},
                "type": "GET"
            },
            "columns": [
                {"data": "cliente"},
                {"data": "docto"},
                {"data": "importe"},
                {"data": "mov"},
                {"data": "doctopa"},
                {"data": "tp"}
            ],
            "columnDefs": [
                {
                    "targets": [2],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [5],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 400,
            "scrollX": true,
            "scrollY": height,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc'], [1, 'asc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 1:
                            /*FECHA ENTREGA*/
                            c.addClass('text-info text-strong');
                            break;
                    }
                });
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                var total = api.column(2).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(2).footer()).html(api.column(3, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(total), 2, '.', ',');
                }, 0));
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblDescDescontadasAgente.find('tbody').on('click', 'tr', function () {
            DescDescontadasAgente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        tblDescDescontadasAgente.find('tbody').on('dblclick', 'tr', function () {
            var dtm = DescDescontadasAgente.row(this).data();
            swal({
                title: "DESEAS ELIMINAR REGISTRO DE DOCUMENTO YA RECUPERADO?",
                text: "Cliente: " + dtm.cliente + "\n " + "Docto: " + dtm.docto + "\n Importe: $" + $.number(parseFloat(dtm.importe), 2, '.', ','),
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"]
            }).then((value) => {
                if (value) {
                    $.post(master_url + 'onEliminarRegistro', {ID: dtm.tp}).done(function () {
                        DescDescontadasAgente.ajax.reload();
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            });
        });
    }
    function getDevImprocedentes(tp, agente) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDevolucionesImprocedentes')) {
            tblDevolucionesImprocedentes.DataTable().destroy();
        }
        DevolucionesImprocedentes = tblDevolucionesImprocedentes.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getDevImprocedentes',
                "dataSrc": "",
                "data": {Tp: tp, Agente: agente},
                "type": "GET"
            },
            "columns": [
                {"data": "cliente"},
                {"data": "docto"},
                {"data": "importe"},
                {"data": "mov"},
                {"data": "doctopa"},
                {"data": "tp"}
            ],
            "columnDefs": [
                {
                    "targets": [2],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [5],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 400,
            "scrollX": true,
            "scrollY": height,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc'], [1, 'asc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 1:
                            /*FECHA ENTREGA*/
                            c.addClass('text-info text-strong');
                            break;
                    }
                });
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                var total = api.column(2).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(2).footer()).html(api.column(3, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(total), 2, '.', ',');
                }, 0));
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblDevolucionesImprocedentes.find('tbody').on('click', 'tr', function () {
            tblDescuentosImprocedentes.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        tblDevolucionesImprocedentes.find('tbody').on('dblclick', 'tr', function () {
            var dtm = DevolucionesImprocedentes.row(this).data();
            swal({
                title: "DESEAS MOVER REGISTRO CARGADO AL AGENTE?",
                text: "Cliente: " + dtm.cliente + "\n " + "Docto: " + dtm.docto + "\n Importe: $" + $.number(parseFloat(dtm.importe), 2, '.', ','),
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"]
            }).then((value) => {
                if (value) {
                    $.post(master_url + 'onCargarAAgentes', {ID: dtm.tp}).done(function () {
                        DevolucionesImprocedentes.ajax.reload();
                        DevDescontadasAgente.ajax.reload();
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            });
        });
    }
    function getDevDescImprocedentes(tp, agente) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDevolucionesImprocedentes')) {
            tblDevDescontadasAgente.DataTable().destroy();
        }
        DevDescontadasAgente = tblDevDescontadasAgente.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getDevDescImprocedentes',
                "dataSrc": "",
                "data": {Tp: tp, Agente: agente},
                "type": "GET"
            },
            "columns": [
                {"data": "cliente"},
                {"data": "docto"},
                {"data": "importe"},
                {"data": "mov"},
                {"data": "doctopa"},
                {"data": "tp"}
            ],
            "columnDefs": [
                {
                    "targets": [2],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [5],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 400,
            "scrollX": true,
            "scrollY": height,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc'], [1, 'asc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 1:
                            /*FECHA ENTREGA*/
                            c.addClass('text-info text-strong');
                            break;
                    }
                });
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                var total = api.column(2).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(2).footer()).html(api.column(3, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(total), 2, '.', ',');
                }, 0));
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblDevDescontadasAgente.find('tbody').on('click', 'tr', function () {
            tblDevDescontadasAgente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        tblDevDescontadasAgente.find('tbody').on('dblclick', 'tr', function () {
            var dtm = DevDescontadasAgente.row(this).data();
            swal({
                title: "DESEAS ELIMINAR REGISTRO DE DOCUMENTO YA RECUPERADO?",
                text: "Cliente: " + dtm.cliente + "\n " + "Docto: " + dtm.docto + "\n Importe: $" + $.number(parseFloat(dtm.importe), 2, '.', ','),
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"]
            }).then((value) => {
                if (value) {
                    $.post(master_url + 'onEliminarRegistro', {ID: dtm.tp}).done(function () {
                        DevDescontadasAgente.ajax.reload();
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            });
        });
    }
    function onImprimirReportes() {
        var tp = pnlTablero.find('#Tp').val();
        var agente = pnlTablero.find('#Agente').val();
        if (tp) {
            if (agente) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                $.post(master_url + 'onImprimirReporte', {Tp: tp, Agente: agente}).done(function (data) {
                    onImprimirReporteFancy(data);
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', 'CAPTURA EL TP', 'warning').then((value) => {
                    pnlTablero.find('#Agente')[0].selectize.focus();
                });
            }
        } else {
            swal('ATENCIÓN', 'CAPTURA EL AGENTE', 'warning').then((value) => {
                pnlTablero.find('#Tp').focus();
            });
        }
    }
    function onImprimirReporteXCliente() {
        var tp = pnlTablero.find('#Tp').val();
        var agente = pnlTablero.find('#Agente').val();
        if (tp) {
            if (agente) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                $.post(master_url + 'onImprimirReporteXCliente', {Tp: tp, Agente: agente}).done(function (data) {
                    onImprimirReporteFancy(data);
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', 'CAPTURA EL TP', 'warning').then((value) => {
                    pnlTablero.find('#Agente')[0].selectize.focus();
                });
            }
        } else {
            swal('ATENCIÓN', 'CAPTURA EL AGENTE', 'warning').then((value) => {
                pnlTablero.find('#Tp').focus();
            });
        }
    }
    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            pnlTablero.find('#Agente')[0].selectize.focus();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 y 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }

</script>
<style>
    table tbody tr {
        font-size: 0.75rem !important;
    }

    div.datatable-wide {
        padding-left: 0;
        padding-right: 0;
    }
    label {
        margin-top: 0.12rem;
        margin-bottom: 0.0rem;
    }

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

    div.datatable-wide {
        padding-left: 0;
        padding-right: 0;
    }
</style>
