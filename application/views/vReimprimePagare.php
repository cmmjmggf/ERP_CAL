<div class="modal" id="mdlReimprimePagare">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reimpresión de pagare <span class="fa fa-coins"></span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label>Empleado</label>
                        <select id="EmpleadoConsulta" name="EmpleadoConsulta class="form-control form-control-sm"></select>
                    </div> 
                    <div class="col-12">
                        <label>Pagare</label>
                        <input type="text" id="NumPagare" name="NumPagare" autofocus="" placeholder="" autocomplete="off" class="form-control form-control-sm numbersOnly">
                    </div> 
                    <div class="col-12">
                        <label>Fecha</label>
                        <input type="text" id="Fecha" name="Fecha" class="form-control form-control-sm date">
                    </div> 
                </div>
                <div class="col-12">
                    <div id="PrestamosConsulta" class="table-responsive">
                        <table id="tblPrestamosConsulta" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr> 
                                    <th scope="col">ID</th>
                                    <th scope="col">Empleado</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Pagare</th>
                                    <th scope="col">Sem</th>
                                    <th scope="col">Prestamo</th>
                                    <th scope="col">Abono</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnImprimePagare" class="btn btn-primary " disabled="">
                    <span class="fa fa-print"></span> Generar
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlReimprimePagare = $("#mdlReimprimePagare"), PrestamosConsulta, tblPrestamosConsulta = mdlReimprimePagare.find("#tblPrestamosConsulta");

    $(document).ready(function () {

        mdlReimprimePagare.find("#EmpleadoConsulta").change(function () {
            PrestamosConsulta.ajax.reload();
        });

        mdlReimprimePagare.find("#btnImprimePagare").click(function () {
            var pagare = mdlReimprimePagare.find("#NumPagare").val(),
                    fecha = mdlReimprimePagare.find("#Fecha").val();
            if (pagare || fecha) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Espere un momento por favor...'
                });
                $.post('<?php print base_url('PrestamosEmpleados/getPagares'); ?>', {PAGARE: pagare, FECHA: fecha}).done(function (a) {
                    onImprimirReporteFancy('<?php print base_url('js/pdf.js-gh-pages/web/viewer.html?file='); ?>' + a + '#pagemode=thumbs');
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            }
        });

        mdlReimprimePagare.find("#Fecha").on('keydown keyup', function (e) {
            onValidarReimpresionPagares();
        });

        mdlReimprimePagare.find("#NumPagare").on('keydown keyup', function (e) {
            onValidarReimpresionPagares();
        });

        mdlReimprimePagare.on('shown.bs.modal', function () {
            mdlReimprimePagare.find("#NumPagare").val('');
            mdlReimprimePagare.find("#Fecha").val('');
            mdlReimprimePagare.find("#NumPagare").focus();
            getPrestamosConsulta();
            $.getJSON('<?php print base_url('PrestamosEmpleados/getEmpleadosEnPagares'); ?>').done(function (a) {
                mdlReimprimePagare.find("#EmpleadoConsulta")[0].selectize.clear(true);
                mdlReimprimePagare.find("#EmpleadoConsulta")[0].selectize.clearOptions();
                a.forEach(function (v) {
                    mdlReimprimePagare.find("#EmpleadoConsulta")[0].selectize.addOption({text: v.EMPLEADO, value: v.CLAVE});
                });
            }).fail(function (x, y, z) {
                getError(x);
            }).always(function () {
                HoldOn.close();
            });
        });
    });
    
    function onValidarReimpresionPagares() {
        if (mdlReimprimePagare.find("#NumPagare").val() || mdlReimprimePagare.find("#Fecha").val()) {
            mdlReimprimePagare.find("#btnImprimePagare").attr('disabled', false);
            PrestamosConsulta.ajax.reload();
        } else if (mdlReimprimePagare.find("#NumPagare").val() === '' ||
                mdlReimprimePagare.find("#Fecha").val() === '') {
            mdlReimprimePagare.find("#btnImprimePagare").attr('disabled', true);
            PrestamosConsulta.ajax.reload();
        }
    }
    function getPrestamosConsulta() {
        if ($.fn.DataTable.isDataTable('#tblPrestamosConsulta')) {
            PrestamosConsulta.ajax.reload(function () {
                HoldOn.close();
            });
        } else {
            var coldefs = [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ];
            PrestamosConsulta = tblPrestamosConsulta.DataTable({
                "dom": 'ritp',
                "ajax": {
                    "url": '<?php print base_url('PrestamosEmpleados/getPrestamosConsulta'); ?>',
                    "contentType": "application/json",
                    "dataSrc": "",
                    "data": function (d) {
                        d.EMPLEADO = mdlReimprimePagare.find("#EmpleadoConsulta").val();
                        d.PAGARE = mdlReimprimePagare.find("#NumPagare").val();
                        d.FECHA = mdlReimprimePagare.find("#Fecha").val();
                    }
                },
                buttons: buttons,
                "columns": [
                    {"data": "ID"}/*0*/,
                    {"data": "EMPLEADO"}/*1*/,
                    {"data": "FECHA"}/*2*/,
                    {"data": "PAGARE"}/*4*/,
                    {"data": "SEM"}/*5*/,
                    {"data": "PRESTAMO"}/*6*/,
                    {"data": "ABONO"}/*7*/
                ],
                "columnDefs": coldefs,
                language: lang,
                select: true,
                "autoWidth": true,
                "colReorder": true,
                "displayLength": 99999999,
                "bLengthChange": false,
                "deferRender": true,
                "scrollCollapse": false,
                "bSort": true,
                "scrollY": "400px",
                "scrollX": true,
                "aaSorting": [
                    [0, 'desc']
                ],
                initComplete: function () {
                    HoldOn.close();
                }
            });
        }
    }
</script>