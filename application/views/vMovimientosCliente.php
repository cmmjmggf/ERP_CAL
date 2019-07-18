<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Consulta de Movimientos por Cliente</legend>
            </div>
            <div class="col-sm-4" align="right">

            </div>
        </div>
        <div class="row" id="Encabezado">

            <div class="col-12 col-sm-5 col-md-5 col-xl-3" >
                <label for="" >Cliente</label>
                <select id="Cliente" name="Cliente" class="form-control form-control-sm required" required="" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Tp" maxlength="1" required="">
            </div>
            <div class="col-6 col-sm-3 col-md-3 col-lg-2 col-xl-2" >
                <label>Doc.</label>
                <input type="text" class="form-control form-control-sm  " id="Doc" name="Doc" maxlength="15" required>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="MovimientosClientes">
                <table id="tblMovimientosClientes" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th class="d-none">Cliente</th>
                            <th class="d-none">Docto</th>
                            <th class="d-none">Fecha</th>
                            <th class="d-none">Importe</th>
                            <th class="d-none">Pagos</th>
                            <th class="d-none">Saldo</th>
                            <th class="d-none">Tp</th>
                            <th class="d-none">Sts</th>
                            <th>Fec-Capt</th>
                            <th>Fec-Dep</th>
                            <th>Importe</th>
                            <th>Mov</th>
                            <th>Comisión</th>
                            <th>Ref.</th>
                            <th>Días</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/MovimientosCliente/';
    var tblMovimientosClientes = $('#tblMovimientosClientes');
    var MovimientosClientes;
    var pnlTablero = $("#pnlTablero");
    $(document).ready(function () {

        /*FUNCIONES INICIALES*/
        getClientes();
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#Cliente")[0].selectize.focus();

        pnlTablero.find("#Cliente").change(function () {
            if ($(this).val()) {
                getRecords($(this).val());
                pnlTablero.find("#Tp").focus();
            }
        });

        pnlTablero.find("#Tp").on('keyup', function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTp($(this));
                }
            }
        });
        pnlTablero.find("#Doc").on('keyup', function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    MovimientosClientes.column(1).search('^' + $(this).val() + '$', true, false).draw();
                } else {
                    MovimientosClientes.column(1).search('').draw();
                }
            }
        });

    });
    function getClientes() {
        pnlTablero.find("#Cliente")[0].selectize.clear(true);
        pnlTablero.find("#Cliente")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getClientes').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Cliente")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            MovimientosClientes.column(6).search(tp).draw();
            pnlTablero.find("#Doc").focus();

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

    function getRecords(cliente) {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblMovimientosClientes')) {
            tblMovimientosClientes.DataTable().destroy();
        }
        MovimientosClientes = tblMovimientosClientes.DataTable({
            "dom": 'rtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "data": {Cliente: cliente},
                "type": "POST"
            },
            "columns": [
                {"data": "cliente"},
                {"data": "remicion"},
                {"data": "fechadoc"},
                {"data": "importe"},
                {"data": "pagos"},
                {"data": "saldo"},
                {"data": "tipo"},
                {"data": "status"},
                {"data": "fechacap"},
                {"data": "fechadep"},
                {"data": "importeP"},
                {"data": "mov"},
                {"data": "pagada"},
                {"data": "doctopa"},
                {"data": "dias"}
            ],
            rowGroup: {
                startRender: function (rows, group) {
                    return 'Doc: <span class="badge badge-warning">' + group + '</span>  ' +
                            'Fecha Fact: <span class="badge badge-warning">' + $(rows.data().pluck('fechadoc')).eq(0)[0] + '</span>  ' +
                            '========> ' +
                            'Importe: <span class="badge badge-info">$' + $(rows.data().pluck('importe')).eq(0)[0] + ' </span>' +
                            ' || Pagos: <span class="badge badge-success">$' + $(rows.data().pluck('pagos')).eq(0)[0] + ' </span>' +
                            ' || Saldo: <span class="badge badge-danger">$' + $(rows.data().pluck('saldo')).eq(0)[0] + ' </span>';
                },
                dataSrc: "remicion"
            },
            "columnDefs": [
                {
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7],
                    "visible": false,
                    "searchable": true
                },
                {
                    "targets": [10],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 100,
            "scrollX": true,
            "scrollY": 400,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [8, 'asc']
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
                            c.addClass('text-strong');
                            break;
                        case 2:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong text-success');
                            break;
                        case 5:
                            /*fecha conf*/
                            c.addClass('badge badge-info text-strong');
                            break;
                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });
        tblMovimientosClientes.find('tbody').on('click', 'tr', function () {
            tblMovimientosClientes.find("tbody tr").removeClass("success");
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

