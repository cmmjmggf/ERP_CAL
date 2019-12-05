<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Consulta Ordenes de Compra</legend>
            </div>
            <div class="col-sm-4" align="right">
                <button type="button" class="btn btn-warning" id="btnLimpiarFiltros" data-toggle="tooltip" data-placement="right" title="Limpiar Filtros">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Tp" autofocus maxlength="2" >
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Año</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Ano" maxlength="4" >
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-3 col-xl-3">
                <label>Departamento</label>
                <input type="text" placeholder="10 PIEL/FORRO, 80 SUELA, 90 INDIR." class="form-control form-control-sm  numbersOnly column_filter" id="Depto" maxlength="2" >
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Folio</label>
                <input type="text" class="form-control form-control-sm  numbersOnly column_filter" id="Folio" maxlength="10" >
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Compras" class="table-responsive">
                <table id="tblCompras" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Group</th>
                            <th>Ano</th>
                            <th>Tipo</th>
                            <th>Tp</th>
                            <th>O.C.</th>
                            <th>Prov</th>
                            <th>Fecha</th>
                            <th>Artículo</th>
                            <th>Cantidad</th>
                            <th>Recibida</th>
                            <th>Precio</th>
                            <th>SubTotal</th>
                            <th>Sem</th>
                            <th>Maq</th>
                            <th>Grupo</th>
                            <th>ID</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    var master_url = base_url + 'index.php/MaterialRecibido/';
    var tblCompras = $('#tblCompras');
    var Compras;
    var pnlTablero = $("#pnlTablero");
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();
        //handleEnterDiv(pnlTablero);

        tblCompras.find('tbody').on('click', 'tr', function () {
            tblCompras.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Compras.row(this).data();
            temp = parseInt(dtm.ID);


            swal("Imprimir", "Orden de Compra: " + dtm.Folio + ' \nProveedor: ' + dtm.NombreProveedor, {
                buttons: ["Cancelar", true]
            }).then((value) => {
                if (value) {
                    $.post(master_url + 'onImprimirOrdenCompra', {Tp: dtm.Tp, Folio: dtm.Folio}).done(function (data) {
                        onNotifyOld('fa fa-check', 'REPORTE GENERADO', 'success');
                        onImprimirReporteFancy(data);
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            });
        });
        pnlTablero.find('#btnLimpiarFiltros').click(function () {
            pnlTablero.find("input").val("");
            tblCompras.DataTable().columns().search('').draw();
        });

        pnlTablero.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                var tp = parseInt($(this).val());
                if (tp > 2) {
                    $(this).val('').focus();
                } else {
                    Compras.column(3).search($(this).val()).draw();
                    pnlTablero.find("#Ano").focus().select();
                }
            }
        });

        pnlTablero.find("#Ano").keypress(function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                    swal({
                        title: "ATENCIÓN",
                        text: "AÑO INCORRECTO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        pnlTablero.find("#Ano").val("");
                        pnlTablero.find("#Ano").focus();
                    });
                } else {
                    Compras.column(1).search($(this).val()).draw();
                    pnlTablero.find("#Depto").focus().select();
                }
            }
        });


        pnlTablero.find("#Depto").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var tipo = parseInt($(this).val());
                    if (tipo === 80 || tipo === 90 || tipo === 10) {

                        var ano = pnlTablero.find("#Ano").val();
                        var tp = pnlTablero.find("#Tp").val();
                        var tipo = pnlTablero.find("#Depto").val();
                        getRecords(ano, tp, tipo);

                        pnlTablero.find('#Folio').focus();
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "DEPARTAMENTO INCORRECTO",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            Compras.column(2).search("", false, true).draw();
                            $(this).val('').focus();

                        });
                    }
                } else {
                    Compras.column(2).search("", false, true).draw();
                }
            }
        });

        pnlTablero.find("#Folio").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    Compras.column(4).search($(this).val()).draw();
                } else {
                    Compras.column(4).search("").draw();
                    pnlTablero.find("#Folio").focus().select();
                }
            }
        });


    });

    function init() {
        getRecords('', '', '');
        pnlTablero.find("input").val("");
        $(':input:text:enabled:visible:first').focus();


    }
    function getRecords(ano, tp, tipo) {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblCompras')) {
            tblCompras.DataTable().destroy();
        }
        Compras = tblCompras.DataTable({
            "dom": 'rtp',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "type": "POST",
                "data": {
                    Ano: ano,
                    Tp: tp,
                    Tipo: tipo
                }
            },
            "columns": [
                {"data": "GruposT"},
                {"data": "Ano"},
                {"data": "Tipo"},
                {"data": "Tp"},
                {"data": "Folio"},
                {"data": "Proveedor"},
                {"data": "FechaOrden"},
                {"data": "Articulo"},
                {"data": "Cantidad"},
                {"data": "CantidadRecibida"},
                {"data": "Precio"},
                {"data": "SubTotal"},
                {"data": "Sem"},
                {"data": "Maq"},
                {"data": "Grupo"},
                {"data": "ID"}

            ],

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
                    "targets": [2],
                    "visible": false,
                    "searchable": true
                },
                {
                    "targets": [3],
                    "visible": false,
                    "searchable": true
                },
                {
                    "targets": [10],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [11],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [15],
                    "visible": false,
                    "searchable": true
                }
            ],
            rowGroup: {
                endRender: function (rows, group) {
                    var stc = $.number(rows.data().pluck('Cantidad').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var stcr = $.number(rows.data().pluck('CantidadRecibida').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var stp = $.number(rows.data().pluck('SubTotal').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    return $('<tr>')
                            .append('<td></td><td></td><td></td><td>Totales: </td>')
                            .append('<td>' + stc + '</td><td>' + stcr + '</td><td></td><td>$' + stp + '</td><td></td><td></td><td></td></tr>');
                },
                dataSrc: "GruposT"
            },
            language: lang,
            "scrollY": 450,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": true,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [4, 'asc'], [5, 'asc'], [7, 'asc']/*Folio*/
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 1:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 3:
                            /*FECHA ENTREGA*/
                            c.addClass('text-success text-strong');
                            break;
                        case 4:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                        case 5:
                            /*fecha conf*/
                            c.addClass('text-warning text-strong');
                            break;
                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();

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

    td span.badge{
        font-size: 100% !important;
    }

    table tbody tr {
        font-size: 0.75rem !important;
    }
</style>
