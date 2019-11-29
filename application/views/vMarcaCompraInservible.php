<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Marca O.C. Inservible <span class="badge badge-info">(Click en cualquier renglon de la orden de compra)</span></legend>
            </div>
            <div class="col-sm-4" align="right">

            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Año</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Ano" autofocus maxlength="4" >
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Tp"  maxlength="2" >
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Folio O.C.</label>
                <input type="text" class="form-control form-control-sm  numbersOnly" id="Folio" maxlength="10" >
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-lg-2 col-xl-2 pt-4">
                <button type="button" id="btnBuscar" class="btn btn-info btn-sm ">
                    <span class="fa fa-search"></span> BUSCAR
                </button>
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
                            <th>Nombre</th>
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
    var master_url = base_url + 'index.php/MarcaCompraInservible/';
    var tblCompras = $('#tblCompras');
    var Compras;
    var pnlTablero = $("#pnlTablero");
    $(document).ready(function () {

        /*FUNCIONES INICIALES*/
        init();
        //handleEnter();
        pnlTablero.find("input").val("");
        pnlTablero.find("#Ano").val(getYear()).focus().select();
        pnlTablero.find("#Ano").keypress(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
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
                    pnlTablero.find("#Tp").focus().select();
                }
            }
        });

        pnlTablero.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                var tp = parseInt($(this).val());
                if (tp > 2) {
                    $(this).val('').focus();
                } else {
                    pnlTablero.find("#Folio").focus().select();
                }
            }
        });

        pnlTablero.find("#Folio").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    pnlTablero.find("#btnBuscar").focus();
                }
            }
        });

        pnlTablero.find("#btnBuscar").click(function () {
            var Ano = pnlTablero.find("#Ano").val();
            var Tp = pnlTablero.find("#Tp").val();
            var Folio = pnlTablero.find("#Folio").val();
            getRecords(Ano, Tp, Folio);
        });



    });

    function init() {
        Compras = tblCompras.DataTable({
            "dom": 'Brtip',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
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
                    "targets": [5],
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
            language: lang,

            "autoWidth": true,
            "colReorder": true,
            "displayLength": 15,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true
        });
    }
    function getRecords(Ano, tp, folio) {
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
            "dom": 'Brtip',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "type": "POST",
                "data": {
                    Ano: Ano,
                    Tp: tp,
                    Folio: folio
                }
            },
            "columns": [
                {"data": "GruposT"},
                {"data": "Ano"},
                {"data": "Tipo"},
                {"data": "Tp"},
                {"data": "Folio"},
                {"data": "NombreProveedor"},
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
                    "targets": [5],
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
                            .append('<td></td><td></td><td>Totales: </td>')
                            .append('<td>' + stc + '</td><td>' + stcr + '</td><td></td><td>$' + stp + '</td><td></td><td></td><td></td></tr>');
                },
                dataSrc: "GruposT"
            },
            language: lang,

            "autoWidth": true,
            "colReorder": true,
            "displayLength": 15,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [4, 'asc'], [5, 'asc']/*Folio*/
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
                        case 2:
                            /*FECHA ENTREGA*/
                            c.addClass('text-success text-strong');
                            break;
                        case 3:
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
                $(':input:text:enabled:visible:first').focus().select();
            }
        });

        tblCompras.find('tbody').on('click', 'tr', function () {
            tblCompras.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Compras.row(this).data();
            temp = parseInt(dtm.ID);


            swal("Marcar como Inservible", "Orden de Compra: " + dtm.Folio + ' \nProveedor: ' + dtm.NombreProveedor, {
                buttons: ["Cancelar", true]
            }).then((value) => {
                if (value) {
                    $.post(master_url + 'onModificar', {Tp: dtm.Tp, Folio: dtm.Folio}).done(function (data) {
                        onNotifyOld('fa fa-check', 'OPERACIÓN EXITOSA', 'success');
                        Compras.clear().draw();
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            });
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
</style>
