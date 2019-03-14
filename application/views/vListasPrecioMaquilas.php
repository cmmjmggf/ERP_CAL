<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-12 float-left">
                <legend class="float-left">Listas de Precios para Maquilas</legend>
            </div>
        </div>
        <div class="row" id="Encabezado">
            <div class="col-12 col-sm-6 col-md-2 col-xl-1">
                <label for="" >Maq.*</label>
                <input type="text" class="form-control form-control-sm" maxlength="3" id="Maq" name="Maq" required="">
            </div>
            <div class="col-12 col-sm-4 col-md-6 col-lg-4 col-xl-2">
                <label for="" >Linea*</label>
                <select id="Linea" name="Linea" class="form-control form-control-sm required" >
                    <option value=""></option>
                </select>
            </div>
        </div>
        <div class="row" id="Detalle">
            <div class="col-12 col-sm-4 col-md-4 col-lg-3">
                <label for="Estilo">Estilo*</label>
                <select class="form-control form-control-sm required " id="Estilo" name="Estilo" required>
                </select>
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-3">
                <label for="Color">Color*</label>
                <select class="form-control form-control-sm required " id="Color" name="Color" required>
                </select>
            </div>
            <div class="col-12 col-sm-4 col-md-2 col-xl-1">
                <label>Corrida</label>
                <input type="text" class="form-control form-control-sm " maxlength="5" id="Corrida" name="Corrida">
            </div>
            <div class="col-12 col-sm-4 col-md-2 col-xl-1">
                <label>Precio</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="PrecioVta" name="PrecioVta">
            </div>

            <div class="col-6 col-sm-3 col-md-2 col-lg-1 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary captura" id="btnGuardar">
                    <i class="fa fa-save"></i> ACEPTAR
                </button>
            </div>
        </div>
        <div class="card-block mt-2">
            <div id="ListasPrecioMaquilas">
                <table id="tblListasPrecioMaquilas" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Maq</th>
                            <th>Linea</th>
                            <th>Estilo</th>
                            <th>Color</th>
                            <th>Corrida</th>
                            <th>Precio</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/ListasPrecioMaquilas/';
    var tblListasPrecioMaquilas = $('#tblListasPrecioMaquilas');
    var ListasPrecioMaquilas;
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');


    $(document).ready(function () {

        /*FUNCIONES INICIALES*/
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToSelectOnChange('#Linea', '#Estilo', pnlTablero);
        setFocusSelectToSelectOnChange('#Estilo', '#Color', pnlTablero);
        setFocusSelectToInputOnChange('#Color', '#Corrida', pnlTablero);

        handleEnter();
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#Maq").focus();
        getLineasPM();
        getRecords();

        tblListasPrecioMaquilas.find('tbody').on('click', 'tr', function () {
            tblListasPrecioMaquilas.find("tbody tr").removeClass("success");
            $(this).addClass("success");

        });
        pnlTablero.find('#Maq').on('keyup', function () {
            if ($(this).val()) {
                ListasPrecioMaquilas.column(1).search('^' + $(this).val() + '$', true, false).draw();
            } else {
                ListasPrecioMaquilas.column(1).search('').draw();
            }
        });
        pnlTablero.find("#Proveedor").change(function () {
            var tp = pnlTablero.find("#Tp").val();
            getRecords($(this).val(), tp);
        });
        pnlTablero.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
        pnlTablero.find("#Linea").change(function () {
            if ($(this).val()) {
                getEstilosByLinea($(this).val());
                ListasPrecioMaquilas.column(2).search('^' + $(this).val() + '$', true, false).draw();
            } else {
                ListasPrecioMaquilas.column(2).search('').draw();
            }
        });
        pnlTablero.find("#Estilo").change(function () {
            if ($(this).val()) {
                getColoresByEstilo($(this).val());
                ListasPrecioMaquilas.column(3).search('^' + $(this).val() + '$', true, false).draw();
            } else {
                ListasPrecioMaquilas.column(3).search('').draw();
            }
        });
        btnGuardar.click(function () {
            isValid('pnlTablero');
            if (valido) {

                var Maq = pnlTablero.find("#Maq").val();
                var Linea = pnlTablero.find("#Linea").val();
                var Estilo = pnlTablero.find('#Estilo').val();
                var Color = pnlTablero.find('#Color').val();
                var Corrida = pnlTablero.find("#Corrida").val();
                var PrecioVta = pnlTablero.find("#PrecioVta").val();
                var Sem = pnlTablero.find("#Sem").val();

                $.post(master_url + 'onAgregar', {
                    Maq: Maq,
                    Linea: Linea,
                    Estilo: Estilo,
                    Color: Color,
                    Corrida: Corrida,
                    PrecioVta: PrecioVta,
                    Sem: Sem
                }).done(function (data) {
                    onNotifyOld('fa fa-check', 'REGISTRO AGREGADO', 'info');
                    ListasPrecioMaquilas.ajax.reload();
                    ListasPrecioMaquilas.search('').columns().search('').draw();
                    pnlTablero.find("input").val("");
                    $.each(pnlTablero.find("select"), function (k, v) {
                        pnlTablero.find("select")[k].selectize.clear(true);
                    });
                    pnlTablero.find("#Maq").focus();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });

            } else {
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
            }

        });

    });
    function onComprobarMaquilas(v) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA MAQUILA " + $(v).val() + " NO ES VALIDA",
                    icon: "warning"
                }).then((value) => {
                    $(v).val('').focus();
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getLineasPM() {

        $.ajax({
            url: base_url + 'index.php/Estilos/getLineas',
            type: "POST",
            dataType: "JSON"
        }).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlTablero.find("[name='Linea']")[0].selectize.addOption({text: v.Linea, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getEstilosByLinea(linea) {
        pnlTablero.find("[name='Estilo']")[0].selectize.clear(true);
        pnlTablero.find("[name='Estilo']")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/FichaTecnica/getEstilosByLinea', {Linea: linea}).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Estilo")[0].selectize.addOption({text: v.Estilo, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getColoresByEstilo(estilo) {
        pnlTablero.find("[name='Color']")[0].selectize.clear(true);
        pnlTablero.find("[name='Color']")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/FichaTecnica/getColoresXEstilo', {Estilo: estilo}).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Color")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function onEliminarDetalleByID(IDX) {
        swal({
            buttons: ["Cancelar", "Aceptar"],
            title: 'Estas Seguro?',
            text: "Esta acción no se puede revertir",
            icon: "warning",
            closeOnEsc: false,
            closeOnClickOutside: false
        }).then((action) => {
            if (action) {
                $.ajax({
                    url: master_url + 'onEliminarDetalleByID',
                    type: "POST",
                    data: {
                        ID: IDX
                    }
                }).done(function (data, x, jq) {
                    ListasPrecioMaquilas.ajax.reload();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });
            }
        });

    }

    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblListasPrecioMaquilas')) {
            tblListasPrecioMaquilas.DataTable().destroy();
        }
        ListasPrecioMaquilas = tblListasPrecioMaquilas.DataTable({
            "dom": 'rtip',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "type": "POST"
            },
            "columns": [
                {"data": "ID"},
                {"data": "Maq"},
                {"data": "Linea"},
                {"data": "Estilo"},
                {"data": "Color"},
                {"data": "Corrida"},
                {"data": "PrecioVta"},
                {"data": "Eliminar"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [6],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }

            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 15,
            "scrollX": true,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
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

                        case 5:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                        case 6:
                            /*fecha conf*/
                            c.addClass('text-danger text-strong');
                            break;
                    }
                });
            }
            ,
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
    td{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    td span.badge{
        font-size: 100% !important;
    }
</style>


