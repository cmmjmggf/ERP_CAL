<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Rastrear Material/Proveedor Compras
                </legend>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label>Proveedor</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Proveedor" name="Proveedor" maxlength="6" required="">
                    </div>
                    <div class="col-9">
                        <select id="sProveedor" name="sProveedor" class="form-control form-control-sm required NotSelectize" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <label>Artículo</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Articulo" name="Articulo" maxlength="6" required="">
                    </div>
                    <div class="col-9">
                        <select id="sArticulo" name="sArticulo" class="form-control form-control-sm required NotSelectize" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
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
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        handleEnterDiv(pnlTablero);
        init();
        validacionSelectPorContenedor(pnlTablero);

        pnlTablero.find('#btnAceptar').click(function () {

            var proveedor = pnlTablero.find('#Proveedor').val();
            var articulo = pnlTablero.find('#Articulo').val();
            getRecords(proveedor, articulo);
        });

        pnlTablero.find('#Proveedor').keydown(function (e) {
            if (e.keyCode === 13) {
                var txtprv = $(this).val();
                if (txtprv) {
                    $.getJSON(base_url + 'index.php/RastreoMatProvCompras/onVerificarProveedor', {Proveedor: txtprv}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sProveedor")[0].selectize.addItem(txtprv, true);
                            pnlTablero.find('#Articulo').focus().select();
                        } else {
                            swal('ERROR', 'EL ARTÍCULO NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sProveedor")[0].selectize.clear(true);
                                pnlTablero.find('#Proveedor').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });

        pnlTablero.find('#sProveedor').change(function () {
            var txtprv = $(this).val();
            if (txtprv) {
                pnlTablero.find('#Proveedor').val(txtprv);
                pnlTablero.find('#Articulo').focus().select();
            }
        });

        pnlTablero.find('#Articulo').keydown(function (e) {
            if (e.keyCode === 13) {
                var txtart = $(this).val();
                if (txtart) {
                    $.getJSON(base_url + 'index.php/RastreoMatProvCompras/onVerificarArticulo', {Articulo: txtart}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sArticulo")[0].selectize.addItem(txtart, true);
                            pnlTablero.find('#btnAceptar').focus();
                        } else {
                            swal('ERROR', 'EL ARTÍCULO NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sArticulo")[0].selectize.clear(true);
                                pnlTablero.find('#Articulo').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });

        pnlTablero.find('#sArticulo').change(function () {
            var txtart = $(this).val();
            if (txtart) {
                pnlTablero.find('#Articulo').val(txtart);
                pnlTablero.find('#btnAceptar').focus();
            }
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
        pnlTablero.find('#Proveedor').focus();
    }

    function getArticulos() {
        pnlTablero.find("#sArticulo")[0].selectize.clear(true);
        pnlTablero.find("#sArticulo")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getArticulos').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sArticulo")[0].selectize.addOption({text: v.Articulo, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getProveedores() {
        pnlTablero.find("#sProveedor")[0].selectize.clear(true);
        pnlTablero.find("#sProveedor")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sProveedor")[0].selectize.addOption({text: v.ProveedorF, value: v.ID});
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
