<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Consulta de Movimientos por Proveedor</legend>
            </div>
            <div class="col-sm-4" align="right">

            </div>
        </div>
        <div class="row" id="Encabezado">

            <div class="col-12 col-sm-5 col-md-5 col-xl-4" >
                <label for="" >Proveedor</label>
                <select id="Proveedor" name="Proveedor" class="form-control form-control-sm required" required="" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Tp" maxlength="1" required="">
            </div>
            <div class="col-6 col-sm-5 col-md-4 col-xl-2" >
                <label for="" >Estatus</label>
                <select id="Estatus" name="Estatus" class="form-control form-control-sm">
                    <option value=""></option>
                    <option value="TODO">TODO</option>
                    <option value="SIN PAGAR">SIN PAGAR</option>
                    <option value="PENDIENTE">CON SALDO PENDIENTE</option>
                    <option value="PAGADO">PAGADO</option>
                </select>
            </div>
            <div class="col-6 col-sm-3 col-md-3 col-lg-2 col-xl-2" >
                <label>Doc.</label>
                <input type="text" class="form-control form-control-sm captura " id="Doc" name="Doc" maxlength="15" required>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="DocumentosDirectos">
                <table id="tblDocumentosDirectos" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th class="d-none">Tp</th>
                            <th class="d-none">Documento</th>
                            <th>Fecha Pago</th>
                            <th>Ref. Pago</th>
                            <th>Importe Pago</th>
                            <th>Tipo</th>
                            <th class="d-none">Estatus</th>
                            <th class="d-none">FechaDoc</th>
                            <th class="d-none">ImporteDoc</th>
                            <th class="d-none">Pagos_Doc</th>
                            <th class="d-none">Saldo_Doc</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/MovimientosProveedor/';
    var tblDocumentosDirectos = $('#tblDocumentosDirectos');
    var DocumentosDirectos;
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');
    $(document).ready(function () {

        /*FUNCIONES INICIALES*/
        setFocusSelectToInputOnChange('#Proveedor', '#Tp', pnlTablero);
        setFocusSelectToInputOnChange('#Estatus', '#Doc', pnlTablero);
        handleEnter();
        getProveedores();
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#FechaDoc").val(getToday());
        pnlTablero.find("#Proveedor")[0].selectize.focus();
        pnlTablero.find("#Tp").change(function () {
            onVerificarTp($(this));
        });
        pnlTablero.find("#Proveedor").change(function () {
            getRecords($(this).val());
        });
        pnlTablero.find("#Estatus").on('change', function () {
            if ($(this).val() === 'TODO') {
                DocumentosDirectos.column(6).search('').draw();
            } else {
                DocumentosDirectos.column(6).search($(this).val()).draw();
            }

        });
        pnlTablero.find("#Tp").on('keyup', function () {
            DocumentosDirectos.column(0).search($(this).val()).draw();
        });
        pnlTablero.find("#Doc").on('keyup', function (e) {
            if ($(this).val() !== '') {
                DocumentosDirectos.column(1).search('^' + $(this).val() + '$', true, false).draw();

            } else {
                DocumentosDirectos.column(1).search('').draw();
            }

        });

    });
    function getProveedores() {
        pnlTablero.find("#Proveedor")[0].selectize.clear(true);
        pnlTablero.find("#Proveedor")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Proveedor")[0].selectize.addOption({text: v.ProveedorF, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {


        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false,
                buttons: false,
                timer: 1000
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }

    function getRecords(Proveedor) {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDocumentosDirectos')) {
            tblDocumentosDirectos.DataTable().destroy();
        }
        DocumentosDirectos = tblDocumentosDirectos.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "data": {Proveedor: Proveedor},
                "type": "POST"
            },

            "columns": [
                {"data": "Tp"},
                {"data": "Doc"},
                {"data": "Fecha"},
                {"data": "DocPago"},
                {"data": "Importe"},
                {"data": "TipoPago"},
                {"data": "Estatus"},
                {"data": "FechaDoc"},
                {"data": "ImporteDoc"},
                {"data": "Pagos_Doc"},
                {"data": "Saldo_Doc"}

            ],
            rowGroup: {
                startRender: function (rows, group) {
                    return 'Doc: <span class="badge badge-warning">' + group + '</span>  ' +
                            'Fecha Fact: <span class="badge badge-warning">' + $(rows.data().pluck('FechaDoc')).eq(0)[0] + '</span>  ' +
                            '========> ' +
                            'Importe: <span class="badge badge-info">$' + $(rows.data().pluck('ImporteDoc')).eq(0)[0] + ' </span>' +
                            ' || Pagos: <span class="badge badge-success">$' + $(rows.data().pluck('Pagos_Doc')).eq(0)[0] + ' </span>' +
                            ' || Saldo: <span class="badge badge-danger">$' + $(rows.data().pluck('Saldo_Doc')).eq(0)[0] + ' </span>';
                },
                dataSrc: "Doc"
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": true
                },
                {
                    "targets": [1],
                    "visible": false,
                    "searchable": true
                },

                {
                    "targets": [4],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [6],
                    "visible": false,
                    "searchable": true
                },
                {
                    "targets": [7],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [8],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [9],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [10],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 700,
            "scrollX": true,
            "scrollY": 390,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [1, 'asc'], [2, 'asc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {

                        case 0:
                            /*FECHA ENTREGA*/
                            c.addClass('text-strong');
                            break;
                        case 1:
                            /*FECHA ENTREGA*/
                            c.addClass('text-secondary text-strong');
                            break;
                        case 2:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 3:
                            /*fecha conf*/
                            c.addClass('text-strong');
                            break;
                        case 4:
                            /*fecha conf*/
                            c.addClass('badge badge-secondary text-strong');
                            break;
                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });
        tblDocumentosDirectos.find('tbody').on('click', 'tr', function () {
            tblDocumentosDirectos.find("tbody tr").removeClass("success");
            $(this).addClass("success");
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

    .badge{
        font-size: 100% !important;
    }
</style>

