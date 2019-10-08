<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Semanas Producción Cerradas</legend>
            </div>
            <div class="col-sm-4" align="right">
                <button type="button" class="btn btn-success" id="btnImportar">
                    <i class="fa fa-copy"></i> IMPORTAR DE SISTEMA VIEJO
                </button>
                <button type="button" class="btn btn-warning" id="btnLimpiarFiltros" data-toggle="tooltip" data-placement="right" title="Limpiar Filtros">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" data-column="1">
                <label>Maq</label>
                <input type="text" class="form-control form-control-sm  numbersOnly column_filter" id="col1_filter" >
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" data-column="0">
                <label>Año</label>
                <input type="text" class="form-control form-control-sm  numbersOnly column_filter" id="col0_filter" maxlength="4" >
            </div>

            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1">
                <label>Semana</label>
                <input type="text" id="Semana" class="form-control form-control-sm  numbersOnly" maxlength="2" >
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4">
                <button type="button" class="btn btn-danger" id="btnCerrarSemana" data-toggle="tooltip" data-placement="right" title="Cerrar Semana">
                    <i class="fa fa-lock"></i>
                </button>
            </div>

        </div>
        <div class="card-block mt-4">
            <div id="Semanas" class="table-responsive">
                <table id="tblSemanas" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Año</th>
                            <th>Maquila</th>
                            <th>Semana</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    var master_url = base_url + 'index.php/CerrarSemanasProd/';
    var tblSemanas = $('#tblSemanas');
    var Semanas;
    var pnlTablero = $("#pnlTablero");
    var btnCerrarSemana = $('#btnCerrarSemana');
    $(document).ready(function () {

        /*FUNCIONES INICIALES*/

        init();
        handleEnter();
        pnlTablero.find("input").val("");
        var accion = "";

        pnlTablero.find('#btnImportar').click(function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'CARGANDO...'
            });
            $.post(master_url + 'onImportarSemanasTablaFili').done(function (data) {
                swal({
                    title: 'Atención',
                    text: "IMPORTACIÓN CORRECTA",
                    icon: "success",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {
                        Semanas.ajax.reload();
                        HoldOn.close();
                        pnlTablero.find('#col1_filter').focus().select();
                    }
                });

            });

        });

        btnCerrarSemana.click(function () {
            var ano = pnlTablero.find('#col0_filter').val();
            var sem = pnlTablero.find('#Semana').val();
            var maq = pnlTablero.find('#col1_filter').val();

            $.getJSON(master_url + 'onVerificarSemanaProdCerrada', {
                Ano: ano,
                Maq: maq,
                Sem: sem
            }).done(function (data) {

                if (data.length > 0) {
                    accion = 'onModificar';
                } else {
                    accion = 'onAgregar';
                }

                swal({
                    buttons: ["Cancelar", "Aceptar"],
                    title: 'Confirmar Acción',
                    text: "Estás seguro de cerrar la semana?",
                    icon: "warning",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {
                        $.post(master_url + accion, {
                            Ano: ano,
                            Maq: maq,
                            Sem: sem,
                            Estatus: 'CERRADA'
                        }).done(function (data) {
                            Semanas.ajax.reload();
                            pnlTablero.find('#col1_filter').focus().select();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        });
                    }
                });

            }).fail(function (x, y, z) {
                console.log(x, y, z);
            });


        });

        pnlTablero.find('#btnLimpiarFiltros').click(function () {
            pnlTablero.find("input").val("");
            tblSemanas.DataTable().columns().search('').draw();
            $(':input:text:enabled:visible:first').focus();
        });

        pnlTablero.find("#col0_filter").change(function () {
            if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    pnlTablero.find("#col0_filter").val("");
                    pnlTablero.find("#col0_filter").focus();
                });
            }
        });

        pnlTablero.find("#col1_filter").change(function () {
            onComprobarMaquilas($(this));
        });

        pnlTablero.find("#Semana").change(function () {
            var ano = pnlTablero.find("#col0_filter");
            onComprobarSemanasProduccion($(this), ano.val());
        });

        $('input.column_filter').on('keyup', function () {
            var i = $(this).parents('div').attr('data-column');
            tblSemanas.DataTable().column(i).search($('#col' + i + '_filter').val()).draw();
        });
    }
    );

    function init() {
        if (seg === 1) {
            pnlTablero.find('#btnImportar').removeClass('d-none');
        } else {
            pnlTablero.find('#btnImportar').addClass('d-none');
        }

        getRecords();
    }
    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblSemanas')) {
            tblSemanas.DataTable().destroy();
        }
        Semanas = tblSemanas.DataTable({
            "dom": 'Brtip',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": ""
            },
            "columns": [
                {"data": "Ano"},
                {"data": "Maq"},
                {"data": "Sem"},
                {"data": "Estatus"}

            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 400,
            "scrollY": 400,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'desc'], [1, 'asc'], [2, 'desc']
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
                var d = new Date();
                var n = d.getFullYear();
                pnlTablero.find("#col0_filter").val(n);
                pnlTablero.find('#col1_filter').focus().select();
            }
        });

        tblSemanas.find('tbody').on('click', 'tr', function () {
            tblSemanas.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Semanas.row(this).data();
            temp = ($(dtm.Estatus).text());

            if (temp === 'CERRADA') {
                swal("ATENCION", "Deasea ABRIR la semana: " + dtm.Sem + ' \nMaquila: ' + dtm.Maq + ' \n Año: ' + dtm.Ano, {
                    buttons: ["Cancelar", true]
                }).then((value) => {
                    if (value) {
                        $.post(master_url + 'onModificar', {
                            Ano: dtm.Ano,
                            Maq: dtm.Maq,
                            Sem: dtm.Sem,
                            Estatus: 'ABIERTA'
                        }).done(function (data) {
                            onNotifyOld('fa fa-check', 'SE HA ABIERTO LA SEMANA SELECCIONADA', 'success');
                            Semanas.ajax.reload();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        });
                    }
                });
            } else {
                swal("ATENCION", "Deasea CERRAR la semana: " + dtm.Sem + ' \nMaquila: ' + dtm.Maq + ' \n Año: ' + dtm.Ano, {
                    buttons: ["Cancelar", true]
                }).then((value) => {
                    if (value) {
                        $.post(master_url + 'onModificar', {
                            Ano: dtm.Ano,
                            Maq: dtm.Maq,
                            Sem: dtm.Sem,
                            Estatus: 'CERRADA'
                        }).done(function (data) {
                            onNotifyOld('fa fa-check', 'SE HA CERRADO LA SEMANA SELECCIONADA', 'success');
                            Semanas.ajax.reload();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        });
                    }
                });
            }
        });
    }

    function onComprobarMaquilas(v) {
        $.getJSON(master_url + 'onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {

            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA MAQUILA " + $(v).val() + " NO ES VALIDA",
                    icon: "warning",
                    buttons: {
                        eliminar: {
                            text: "Aceptar",
                            value: "aceptar"
                        }
                    }
                }).then((value) => {
                    switch (value) {
                        case "aceptar":
                            swal.close();
                            $(v).val('');
                            $(v).focus();
                            break;
                    }
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onComprobarSemanasProduccion(v, ano) {
        $.getJSON(master_url + 'onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {

            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA SEMANA " + $(v).val() + " DEL " + ano + " " + "NO EXISTE",
                    icon: "warning",
                    buttons: {
                        eliminar: {
                            text: "Aceptar",
                            value: "aceptar"
                        }
                    }
                }).then((value) => {
                    switch (value) {
                        case "aceptar":
                            swal.close();
                            $(v).val('');
                            $(v).focus();
                            break;
                    }
                });
            }
        }).fail(function (x, y, z) {
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
