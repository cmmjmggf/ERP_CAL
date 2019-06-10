<div class="modal " id="mdlRastreoConceptoNomina"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rastreo de conceptos de nómina por empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoConcepto" name="AnoConcepto" required="">
                        </div>
                        <div class="col-6">
                            <label>Empleado</label>
                            <select id="EmpleadoConcepto" name="EmpleadoConcepto" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label>Concepto</label>
                            <select id="Concepto" name="Concepto" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <div class="table-responsive" id="ConceptosNominaRastreo">
                                <table id="tblConceptosNominaRastreo" class="table table-sm  " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sem</th>
                                            <th>Empleado</th>
                                            <th>Concepto</th>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Importe</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" align="center">Total General:</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary selectNotEnter" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlRastreoConceptoNomina = $('#mdlRastreoConceptoNomina');
    var tblConceptosNominaRastreo = $('#tblConceptosNominaRastreo');
    var ConceptosNominaRastreo;

    $(document).ready(function () {
        setFocusSelectToSelectOnChange('#EmpleadoConcepto', '#Concepto', mdlRastreoConceptoNomina);
        mdlRastreoConceptoNomina.on('shown.bs.modal', function () {
            mdlRastreoConceptoNomina.find("input").val("");
            $.each(mdlRastreoConceptoNomina.find("select"), function (k, v) {
                mdlRastreoConceptoNomina.find("select")[k].selectize.clear(true);
            });
            mdlRastreoConceptoNomina.find("#AnoConcepto").val(new Date().getFullYear());

            getEmpleadosConceptosNomina();
            getConceptosNomina();
            mdlRastreoConceptoNomina.find('#AnoConcepto').focus().select();
        });
        mdlRastreoConceptoNomina.find("#AnoConcepto").change(function () {
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
                    mdlRastreoConceptoNomina.find("#AnoConcepto").val("");
                    mdlRastreoConceptoNomina.find("#AnoConcepto").focus();
                });
            } else {
                mdlRastreoConceptoNomina.find("#Concepto")[0].selectize.clear(true);
            }
        });
        mdlRastreoConceptoNomina.find("#EmpleadoConcepto").change(function () {
            var ano = mdlRastreoConceptoNomina.find("#AnoConcepto").val();
            var empleado = $(this).val();
            getConceptosNominaRastreo(ano, empleado);
            mdlRastreoConceptoNomina.find("#Concepto")[0].selectize.clear(true);
        });
        mdlRastreoConceptoNomina.find("#Concepto").change(function () {
            var concepto = $(this).val();
            if (concepto) {
                ConceptosNominaRastreo.column(2).search('^' + concepto + '$', true, false).draw();
            } else {
                ConceptosNominaRastreo.search('').draw();
            }
            $(this)[0].selectize.focus();

        });
    });

    function getConceptosNominaRastreo(ano, empleado) {
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblConceptosNominaRastreo')) {
            tblConceptosNominaRastreo.DataTable().destroy();
        }
        ConceptosNominaRastreo = tblConceptosNominaRastreo.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": base_url + 'index.php/CapturaFraccionesParaNomina/getConceptosNominaRastreo',
                "dataType": "json",
                "type": 'GET',
                "data": {Ano: ano, Emp: empleado},
                "dataSrc": ""
            },
            "columns": [
                {"data": "numsem"},
                {"data": "numemp"},
                {"data": "numcon"},
                {"data": "fecha"},
                {"data": "PerDed"},
                {"data": "Importe"}
            ],
            "columnDefs": [
                {
                    "targets": [5],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }

            ],
            language: lang,
            "autoWidth": true,
            "colReorder": false,
            "displayLength": 500,
            scrollY: 370,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc']/*ID*/, [1, 'asc']/*ID*/, [4, 'asc']/*ID*/, [2, 'asc']/*ID*/
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*UNIDAD*/
                            c.addClass('text-info text-strong');
                            break;
                        case 1:
                            /*CONSUMO*/
                            c.addClass('text-success text-strong');
                            break;
                        case 4:
                            /*PZXPAR*/
                            c.addClass('text-strong ');
                            break;
                        case 5:
                            /*PZXPAR*/
                            c.addClass('text-strong ');
                            break;
                    }
                });
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                var totalCO = api.column(5).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(5).footer()).html(api.column(5, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(totalCO), 2, '.', ',');
                }, 0));
            },
            rowGroup: {
                startRender: null,
                endRender: function (rows, group) {
                    var stcV = $.number(rows.data().pluck('Importe').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    return $('<tr>').
                            append('<td colspan="5" align="center">Total semana ' + group + ':</td>').append('<td>$' + stcV + '</td></tr>');
                },
                dataSrc: "numsem"
            },
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        $('#tblConceptosNominaRastreo_filter input[type=search]').addClass('selectNotEnter');
        tblConceptosNominaRastreo.find('tbody').on('click', 'tr', function () {
            tblConceptosNominaRastreo.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });

    }

    function getEmpleadosConceptosNomina() {
        $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getEmpleadosGeneral', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlRastreoConceptoNomina.find("#EmpleadoConcepto")[0].selectize.addOption({text: v.Empleado, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getConceptosNomina() {
        $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getConceptosNomina', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlRastreoConceptoNomina.find("#Concepto")[0].selectize.addOption({text: v.Concepto, value: v.Clave});
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

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>