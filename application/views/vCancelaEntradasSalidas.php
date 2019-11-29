<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-9 float-left">
                <legend class="float-left">Cancela Entradas/Salidas por Sem - Maq - Docto</legend>
            </div>
            <div class="col-sm-3" align="right">
                <button type="button" class="btn btn-info btn-sm " id="btnNuevo" >
                    <span class="fa fa-plus" ></span> NUEVO
                </button>
            </div>
        </div>
        <div class="row" id="Encabezado">
            <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                <label for="" >Maq.*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="Maq" name="Maq" required="">
            </div>
            <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                <label for="" >Año*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="4" id="Ano" name="Ano" required="">
            </div>
            <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                <label for="" >Sem.*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="Sem" name="Sem" required="">
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2" >
                <label>Doc.</label>
                <input type="text" class="form-control form-control-sm "  id="DocMov" name="DocMov" maxlength="15" required>
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary" id="btnGuardar">
                    <i class="fa fa-check"></i> CANCELAR DOCTO
                </button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Movimientos" class="table-responsive">
                <table id="tblMovimientos" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Clave</th>
                            <th>Articulo</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                            <th>FechaMov</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/CancelaEntradasSalidas/';
    var pnlTablero = $("#pnlTablero");
    var btnNuevo = pnlTablero.find('#btnNuevo');
    var btnGuardar = pnlTablero.find('#btnGuardar');
    var tblMovimientos = $('#tblMovimientos');
    var Movimientos;
    var nuevo = true;
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        getRecords('0', '0', '0', '0');
        pnlTablero.find("#Maq").focus();
        pnlTablero.find('#Ano').keypress(function (e) {
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
                    pnlTablero.find("#Sem").focus().select();
                }
            }
        });
        pnlTablero.find('#Maq').keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onComprobarMaquilas($(this));
                }
            }
        });
        pnlTablero.find("#Sem").keypress(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                var ano = pnlTablero.find("#Ano").val();
                var maq = pnlTablero.find("#Maq").val();
                onComprobarSemanasProduccion($(this), ano, maq);
            }
        });
        pnlTablero.find("#DocMov").keypress(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                var maq = pnlTablero.find("#Maq").val();
                var sem = pnlTablero.find("#Sem").val();
                var ano = pnlTablero.find("#Ano").val();
                if (maq !== '' && sem !== '' && $(this).val() !== '') {
                    getRecords($(this).val(), maq, sem, ano);
                    btnGuardar.focus();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "DEBES INTRODUCIR UNA MAQUILA Y UNA SEMANA",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        buttons: true
                    }).then((action) => {
                        $(this).val("");
                        $(this).focus();
                    });
                }
            }
        });
        btnGuardar.click(function () {
            isValid('pnlTablero');
            if (valido) {

                swal({
                    buttons: ["Cancelar", "Aceptar"],
                    title: 'Estás Seguro?',
                    text: "Esta acción cancelará todo el documento seleccionado",
                    icon: "warning",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {
                        var maq = pnlTablero.find("#Maq").val();
                        var sem = pnlTablero.find('#Sem').val();
                        var docMov = pnlTablero.find("#DocMov").val();
                        var ano = pnlTablero.find('#Ano').val();
                        $.post(master_url + 'onCancelarDoctos', {
                            DocMov: docMov,
                            Maq: maq,
                            Sem: sem,
                            Ano: ano
                        }).done(function (data) {
                            onNotifyOld('fa fa-check', 'REGISTRO CANCELADO EXITOSAMENTE', 'info');
                            getRecords('0', '0', '0', '0');
                            pnlTablero.find("input").val('');
                            pnlTablero.find("#Maq").focus();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        });
                    }

                });
            } else {
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
            }
        });
        btnNuevo.click(function () {
            nuevo = true;
            Movimientos.clear().draw();
            pnlTablero.find("input").val("");
            pnlTablero.find("#Maq").focus();
        });
    });
    function getRecords(doc, maq, sem, ano) {
        temp = 0;

        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblMovimientos')) {
            tblMovimientos.DataTable().destroy();
        }
        Movimientos = tblMovimientos.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "data": {
                    DocMov: doc,
                    Maq: maq,
                    Sem: sem,
                    Ano: ano
                },
                "type": "POST",
                "dataSrc": ""
            },
            "columns": [
                {"data": "Articulo"},
                {"data": "DescArticulo"},
                {"data": "CantidadMov"},
                {"data": "PrecioMov"},
                {"data": "Subtotal"},
                {"data": "FechaMov"}
            ],

            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 300,
            scrollY: 300,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [1, 'asc']
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

        tblMovimientos.find('tbody').on('click', 'tr', function () {
            tblMovimientos.find("tbody tr").removeClass("success");
            $(this).addClass("success");

        });
    }
    function onComprobarMaquilas(v) {
        $.getJSON(master_url + 'onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {
                pnlTablero.find("#Ano").focus().select();
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
    function onComprobarSemanasProduccion(v, ano, maq) {
        if ($(v).val() !== '') {
            $.getJSON(master_url + 'onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
                if (data.length > 0) {
                    $.getJSON(master_url + 'onVerificarSemanaProdCerrada', {
                        Ano: ano,
                        Maq: maq,
                        Sem: $(v).val()
                    }).done(function (data) {
                        if (data.length > 0) {
                            if (data[0].Estatus === 'CERRADA') {//CERRADA
                                swal({
                                    title: "ATENCIÓN",
                                    text: "LA SEMANA YA ESTA CERRADA",
                                    icon: "warning"
                                }).then((value) => {
                                    $(v).val('').focus();
                                });
                            } else {//ABIERTA
                                pnlTablero.find("#DocMov").focus().select();
                            }
                        } else {//ABIERTA
                            pnlTablero.find("#DocMov").focus().select();
                        }
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "LA SEMANA " + $(v).val() + " DEL " + ano + " " + "NO EXISTE",
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
