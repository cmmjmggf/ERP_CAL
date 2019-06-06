<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Rastreo de controles por empleado</legend>
            </div>
            <div class="col-sm-4" align="right">
                <button type="button" class="btn btn-warning" id="btnLimpiarFiltros" data-toggle="tooltip" data-placement="right" title="Limpiar Filtros">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-4 col-lg-3 col-xl-3">
                <label>Empleado</label>
                <select id="Empleado" name="Empleado" class="form-control form-control-sm required">
                    <option value=""></option>
                </select>
            </div>
            <div class="col-2">
                <label>Año</label>
                <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
            </div>
            <div class="col-2">
                <label>Sem</label>
                <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" >
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card-block mt-4">
                    <div id="Registros" class="table-responsive">
                        <table id="tblRegistros" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Control</th>
                                    <th>Fracción</th>
                                    <th>Año</th>
                                    <th>Semana</th>
                                    <th>Estilo</th>
                                    <th>Pares</th>
                                    <th>Fecha</th>
                                    <th>Empleado</th>
                                </tr>
                            </thead>
                            <tbody></tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/RastreoControlesEmpleado/';
    var tblRegistros = $('#tblRegistros');
    var Registros;
    var pnlTablero = $("#pnlTablero"), Empleado = pnlTablero.find("#Empleado"),
            Ano = pnlTablero.find("#Ano"), Sem = pnlTablero.find("#Sem");
    $(document).ready(function () {

        /*FUNCIONES INICIALES*/
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToInputOnChange('#Empleado', '#Ano', pnlTablero);
        init();
        handleEnter();
        pnlTablero.find("input").val("");
        $(':input:text:enabled:visible:first').focus();

        pnlTablero.find('#btnLimpiarFiltros').click(function () {
            pnlTablero.find("input").val("");
            tblRegistros.DataTable().columns().search('').draw();
            $.each(pnlTablero.find("select"), function (k, v) {
                pnlTablero.find("select")[k].selectize.clear(true);
            });
            $(':input:text:enabled:visible:first').focus();
        });


        pnlTablero.find("#Empleado").change(function () {
            if ($(this).val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                Registros.ajax.reload(function () {
                    HoldOn.close();
                });
            }
        });

        pnlTablero.find("#Sem").keyup(function (e) {
            if ($(this).val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                Registros.ajax.reload(function () {
                    HoldOn.close();
                });
            }
        });

        pnlTablero.find("#Ano").keyup(function (e) {
            if ($(this).val() && $(this).val().length > 3) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                Registros.ajax.reload(function () {
                    HoldOn.close();
                });
            }
        });

        pnlTablero.find("#Sem").change(function () {
            if (parseInt($(this).val()) < 1 || parseInt($(this).val()) > 52 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "SEMANA INCORRECTA",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    pnlTablero.find("#Sem").val("");
                    pnlTablero.find("#Sem").focus();
                });
            }
        });

        pnlTablero.find("#Ano").change(function () {
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
                    pnlTablero.find("#Ano").val("");
                    pnlTablero.find("#Ano").focus();
                });
            }
        });

    });

    function init() {
        getRecords();
        getEmpleados();
    }
    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblRegistros')) {
            tblRegistros.DataTable().destroy();
        }
        Registros = tblRegistros.DataTable({
            "dom": 'Brtip',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "data": function (d) {
                    d.EMPLEADO = (Empleado.val() ? Empleado.val() : '');
                    d.ANIO = (Ano.val() ? Ano.val() : '');
                    d.SEMANA = (Sem.val() ? Sem.val() : '');
                }
            },
            "columns": [
                {"data": "Control"},
                {"data": "Fraccion"},
                {"data": "Ano"},
                {"data": "Semana"},
                {"data": "Estilo"},
                {"data": "Pares"},
                {"data": "Fecha"},
                {"data": "Empleado"}

            ],
            "columnDefs": [
                {
                    "targets": [7],
                    "visible": false,
                    "searchable": true
                }
            ],
            rowGroup: {
                startRender: function (rows, group) {
                    return $('<tr>').append('<td colspan="7">Fraccion: ' + group + '</td></tr>');
                },
                dataSrc: "Fraccion"
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
                Ano.val(new Date().getFullYear());
                HoldOn.close();

            }
        });
        tblRegistros.find('tbody').on('click', 'tr', function () {
            tblRegistros.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Registros.row(this).data();

        });
    }

    function getEmpleados() {
        $.getJSON(master_url + 'getEmpleados').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Empleado")[0].selectize.addOption({text: v.Empleado, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
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
