<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Rastrear Material/Proveedor Compras
                </legend>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-6 col-md-5 col-lg-4">
                <label>Proveedor</label>
                <select class="form-control form-control-sm" id="Proveedor" name="Proveedor" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-6 col-sm-6 col-md-5 col-lg-4">
                <label>Artículo</label>
                <select class="form-control form-control-sm" id="Articulo" name="Articulo" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-6 col-sm-5 col-md-2 col-lg-2 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary" id="btnAceptar" data-toggle="tooltip" data-placement="right" title="Aceptar">
                    <i class="fa fa-check"></i> ACEPTAR
                </button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Registros" class="table-responsive">
                <table id="tblRegistros" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Fecha</th>
                            <th>Ord-Com</th>
                            <th>Tp</th>
                            <th>Artículo</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                            <th>FechaORd</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    var master_url = base_url + 'index.php/RastreoMatProvCompras/';
    var pnlTablero = $("#pnlTablero");
    var tblRegistros = pnlTablero.find('#tblRegistros');
    var Registros;

    var valida = false;
    $(document).ready(function () {

        handleEnter();
        init();
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToInputOnChange('#Proveedor', '#Articulo', pnlTablero);

        pnlTablero.find('#btnAceptar').click(function () {

            var proveedor = pnlTablero.find('#Proveedor').val();
            var articulo = pnlTablero.find('#Articulo').val();
            getRecords(proveedor, articulo);
        });

    });

    function getRecords(proveedor, articulo) {
        temp = 0;

        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblRegistros')) {
            tblRegistros.DataTable().destroy();
        }
        Registros = tblRegistros.DataTable({
            "dom": 'rtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "data": {
                    Proveedor: proveedor,
                    Articulo: articulo
                },
                "type": "POST",
                "dataSrc": ""
            },
            "columns": [
                {"data": "Doc"},
                {"data": "Fecha"},
                {"data": "OC"},
                {"data": "Tp"},
                {"data": "Articulo"},
                {"data": "Cantidad"},
                {"data": "Precio"},
                {"data": "Subtotal"},
                {"data": "FechaOrd"}
            ],

            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 15,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [8, 'desc']
            ],
            "columnDefs": [
                {
                    "targets": [5],
                    "render": function (data, type, row) {
                        return  $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [6],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [7],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [8],
                    "visible": false,
                    "searchable": false
                }
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
                            c.addClass('text-success text-strong');
                            break;
                        case 2:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;

                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();

            }
        });

        tblRegistros.find('tbody').on('click', 'tr', function () {
            tblRegistros.find("tbody tr").removeClass("success");
            $(this).addClass("success");

        });
    }

    function init() {
        getArticulos();
        getProveedores();
        pnlTablero.find('#Proveedor')[0].selectize.focus();
    }

    function getArticulos() {
        pnlTablero.find("#Articulo")[0].selectize.clear(true);
        pnlTablero.find("#Articulo")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getArticulos').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Articulo")[0].selectize.addOption({text: v.Articulo, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

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
