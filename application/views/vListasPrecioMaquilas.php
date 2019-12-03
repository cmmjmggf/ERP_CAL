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
                <input type="text" class="form-control form-control-sm" maxlength="2" id="Maq" name="Maq" required="">
            </div>
            <div class="col-12 col-sm-4 col-md-6 col-lg-4 col-xl-2">
                <label for="" >Linea*</label>
                <select id="Linea" name="Linea" class="form-control form-control-sm required" >
                    <option value=""></option>
                </select>
            </div>
        </div>
        <div class="row" id="Detalle">
            <div class="col-12 col-sm-3 col-md-2 col-lg-1">
                <label for="Estilo">Estilo*</label>
                <input type="text" class="form-control form-control-sm" maxlength="7" id="Estilo" name="estilo"   >
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-3">
                <label>Color</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Color" name="Color" maxlength="2" required="">
                    </div>
                    <div class="col-9">
                        <select id="sColor" name="sColor" class="form-control form-control-sm required NotSelectize" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
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
                <button type="button" class="btn btn-primary btn-sm captura" id="btnGuardar">
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
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        /*FUNCIONES INICIALES*/
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToInputOnChange('#Linea', '#Estilo', pnlTablero);

        //handleEnterDiv(pnlTablero);
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#Maq").focus();
        getLineasPM();
        getRecords(0, 0);
        tblListasPrecioMaquilas.find('tbody').on('click', 'tr', function () {
            tblListasPrecioMaquilas.find("tbody tr").removeClass("success");
            $(this).addClass("success");

        });
        pnlTablero.find("#Maq").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onComprobarMaquilas($(this));

                } else {
                    getRecords(0, 0);
                }
            }
        });
        pnlTablero.find("#Linea").change(function () {
            if ($(this).val()) {
                getRecords(pnlTablero.find("#Maq").val(), pnlTablero.find("#Linea").val());
            } else {
                getRecords(0, 0);
            }
        });
        pnlTablero.find("#Estilo").keypress(function (e) {
            if (e.keyCode === 13) {
                var Estilo = $(this).val();
                if (Estilo) {
                    $.getJSON(base_url + 'index.php/ListasPrecioMaquilas/onVerificarEstilo', {Estilo: Estilo}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            pnlTablero.find('#Color').val('').focus();
                            pnlTablero.find("#Linea")[0].selectize.addItem(data[0].linea, true);
                            getRecords(pnlTablero.find("#Maq").val(), data[0].linea);
                            getColoresByEstilo(Estilo);
                            ListasPrecioMaquilas.column(3).search('^' + Estilo + '$', true, false).draw();
                        } else {
                            swal('ERROR', 'ESTILO NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find('#Estilo').focus().val('');
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                } else {
                    ListasPrecioMaquilas.column(3).search('').draw();
                }
            }
        });
        pnlTablero.find("#Color").keypress(function (e) {
            if (e.keyCode === 13) {
                var col = $(this).val();
                if (col) {
                    var estilo = pnlTablero.find('#Estilo').val();
                    $.getJSON(base_url + 'index.php/ListasPrecioMaquilas/onVerificarEstiloColor', {Estilo: estilo, Color: col}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            pnlTablero.find('#Corrida').val('').focus();
                            pnlTablero.find("#sColor")[0].selectize.addItem(col, true);
                        } else {
                            swal('ERROR', 'COLOR NO EXISTE EN EL ESTILO', 'warning').then((value) => {
                                pnlTablero.find("#sColor")[0].selectize.clear(true);
                                pnlTablero.find('#Color').focus().val('');
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });
        pnlTablero.find("#Corrida").keypress(function (e) {
            if (e.keyCode === 13) {
                var corr = $(this).val();
                if (corr) {
                    pnlTablero.find("#PrecioVta").focus().select();
                }
            }
        });
        pnlTablero.find("#PrecioVta").keypress(function (e) {
            if (e.keyCode === 13) {
                var corr = $(this).val();
                if (corr) {
                    btnGuardar.focus();
                }
            }
        });
        btnGuardar.click(function () {
            btnGuardar.attr('disabled', true);
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
                    btnGuardar.attr('disabled', false);
                    onNotifyOld('fa fa-check', 'REGISTRO AGREGADO', 'info');
                    ListasPrecioMaquilas.ajax.reload();
                    pnlTablero.find("#Corrida").val("");
                    pnlTablero.find("#PrecioVta").val("");
                    pnlTablero.find("#sColor")[0].selectize.clear(true);
                    pnlTablero.find("#Color").val('').focus();
                }).fail(function (x, y, z) {
                    btnGuardar.attr('disabled', false);
                    console.log(x, y, z);
                });

            } else {
                btnGuardar.attr('disabled', false);
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
            }

        });

    });
    function onComprobarMaquilas(v) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {
                //getRecords($(v).val(), pnlTablero.find("#Linea").val());
                pnlTablero.find("#Linea")[0].selectize.focus();
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

    function getColoresByEstilo(estilo) {
        pnlTablero.find("#sColor")[0].selectize.clear(true);
        pnlTablero.find("#sColor")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/ListasPrecioMaquilas/getColoresXEstilo', {Estilo: estilo}).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sColor")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
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

    function getRecords(maq, linea) {
        temp = 0;
//        HoldOn.open({
//            theme: 'sk-cube',
//            message: 'CARGANDO...'
//        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblListasPrecioMaquilas')) {
            tblListasPrecioMaquilas.DataTable().destroy();
        }
        ListasPrecioMaquilas = tblListasPrecioMaquilas.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "type": "POST",
                "data": {Maq: maq, Linea: linea}
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
            "displayLength": 50,
            "scrollX": true,
            "scrollY": 400,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
//            "createdRow": function (row, data, index) {
//                $.each($(row).find("td"), function (k, v) {
//                    var c = $(v);
//                    var index = parseInt(k);
//                    switch (index) {
//                        case 0:
//                            /*FECHA ORDEN*/
//                            c.addClass('text-strong');
//                            break;
//                        case 1:
//                            /*FECHA ENTREGA*/
//                            c.addClass('text-success text-strong');
//                            break;
//
//                        case 5:
//                            /*fecha conf*/
//                            c.addClass('text-info text-strong');
//                            break;
//                        case 6:
//                            /*fecha conf*/
//                            c.addClass('text-danger text-strong');
//                            break;
//                    }
//                });
//            },
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
</style>


