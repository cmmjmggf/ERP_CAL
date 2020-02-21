<div class="modal" id="mdlReimprimePagare">
    <div class="modal-dialog modal-lg modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <span class="fa fa-coins"></span> Reimpresión de pagaré </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label>Empleado</label>
                        <div class="row">
                            <div class="col-2">
                                <input type="text" id="xEmpleadoConsulta" name="xEmpleadoConsulta" class="form-control form-control-sm">
                            </div>
                            <div class="col-10">
                                <select id="EmpleadoConsulta" name="EmpleadoConsulta" class="form-control form-control-sm">
                                    <option></option>
                                    <?php
                                    foreach ($this->db->select("E.Numero AS CLAVE, "
                                                    . "CONCAT(E.Numero,' ', E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS EMPLEADO")
                                            ->from("empleados AS E")->where('E.AltaBaja', 1)->get()->result() as $k => $v) {
                                        print "<option value=\"{$v->CLAVE}\">{$v->EMPLEADO}</option>";
                                    }
                                    ?>                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <label>Pagare</label>
                        <input type="text" id="NumPagare" name="NumPagare" autofocus="" placeholder="" autocomplete="off" class="form-control form-control-sm numbersOnly">
                    </div>
                    <div class="col-3">
                        <label>Fecha</label>
                        <input type="text" id="Fecha" name="Fecha" class="form-control form-control-sm date">
                    </div>
                    <div class="col-4 mt-3">
                        <button id="btnImprimePagare" name="btnImprimePagare" class="btn btn-info ">
                            <span class="fa fa-print"></span> Imprime
                        </button>
                        <button id="btnImprimeMultiPagare" name="btnImprimeMultiPagare" class="btn btn-info selectNotEnter notEnter">
                            <span class="fa fa-print"></span> Imprime x fecha
                        </button>
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
                    <div class="w-100"></div>
                    <div class="col-6" align="center"> 
                        <h4 class="font-weight-bold " style="color: #c7210f !important;">Prestado</h4>
                        <h4 class="font-weight-bold total_prestado" style="color: #c7210f !important;">$ 0.0 </h4>
                    </div>
                    <div class="col-6" align="center">
                        <h4 class="font-weight-bold " style="color: #5f7429 !important;">Abonado</h4>
                        <h4 class="font-weight-bold total_abonado" style="color: #5f7429 !important;">$ 0.0 </h4>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<script>
    var mdlReimprimePagare = $("#mdlReimprimePagare"),
            PrestamosConsulta,
            xEmpleadoConsulta = mdlReimprimePagare.find("#xEmpleadoConsulta"),
            EmpleadoConsulta = mdlReimprimePagare.find("#EmpleadoConsulta"),
            tblPrestamosConsulta = mdlReimprimePagare.find("#tblPrestamosConsulta"),
            mdlbtnImprimePagare = mdlReimprimePagare.find("#btnImprimePagare"),
            btnImprimeMultiPagare = mdlReimprimePagare.find("#btnImprimeMultiPagare");

    $(document).ready(function () {
        handleEnterDiv(mdlReimprimePagare);

        btnImprimeMultiPagare.click(function () {
            var fechin = mdlReimprimePagare.find("#Fecha");
            if (fechin.val()) {
                onOpenOverlay('Espere un momento por favor...');
                console.log('ok pagares'); 
                $.post('<?php print base_url('PrestamosEmpleados/getPagares'); ?>',
                        {
                            PAGARE: '', FECHA: mdlReimprimePagare.find("#Fecha").val()
                        }).done(function (a) {
                    console.log('ok imprime');
                    onImprimirReporteFancyAFC(a, function (a, b) {
                        mdlReimprimePagare.find("#Fecha").focus().select();
                    });
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                onCampoInvalido(mdlReimprimePagare, "DEBE DE ESPECIFICAR UNA FECHA VALIDA", function () {
                    fechin.focus().select();
                });
            }
        });

        xEmpleadoConsulta.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xEmpleadoConsulta.val()) {
                    EmpleadoConsulta[0].selectize.setValue(xEmpleadoConsulta.val());
                    if (EmpleadoConsulta.val()) {
                        EmpleadoConsulta[0].selectize.disable();
                        PrestamosConsulta.ajax.reload(function () {
                            HoldOn.close();
                        });
                    } else {
                        iMsg('NUMERO DE EMPLEADO INVÁLIDO, INTENTE CON OTRO', 'w', function () {
                            xEmpleadoConsulta.focus().select();
                        });
                    }
                } else {
                    EmpleadoConsulta[0].selectize.clear(true);
                    EmpleadoConsulta[0].selectize.enable();
                }
            } else {
                EmpleadoConsulta[0].selectize.clear(true);
                EmpleadoConsulta[0].selectize.enable();
                PrestamosConsulta.ajax.reload(function () {
                    HoldOn.close();
                    getAbonado();
                });
            }
        });

        mdlReimprimePagare.find("#EmpleadoConsulta").change(function () {
            PrestamosConsulta.ajax.reload();
        });

        mdlbtnImprimePagare.click(function () {
            var pagare = mdlReimprimePagare.find("#NumPagare").val(),
                    fecha = mdlReimprimePagare.find("#Fecha").val();
            if (pagare || fecha) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Espere un momento por favor...'
                });
                mdlbtnImprimePagare.attr('disabled', true);
                $.post('<?php print base_url('PrestamosEmpleados/getPagares'); ?>', {PAGARE: pagare, FECHA: fecha}).done(function (a) {
                    onImprimirReporteFancyAFC(a, function (a, b) {
                        mdlbtnImprimePagare.attr('disabled', false);
                        mdlReimprimePagare.find("#NumPagare").focus().select();
                    });
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                iMsg('DEBE DE ESPECIFICAR UN PAGARE', 'w', function () {
                    mdlReimprimePagare.find("#NumPagare").focus().select();
                });
            }
        });

        mdlReimprimePagare.find("#NumPagare").on('keydown', function (e) {
            if (e.keyCode === 13 && $(this).val() === '') {
                PrestamosConsulta.ajax.reload(function () {
                    HoldOn.close();
                    getAbonado();
                });
            }
        });

        mdlReimprimePagare.on('hidden.bs.modal', function () {
            mdlReimprimePagare.find("input").val('');
            mdlReimprimePagare.find("select")[0].selectize.clear(true);
            mdlReimprimePagare.find("select")[0].selectize.enable();
        });

        mdlReimprimePagare.on('shown.bs.modal', function () {
            mdlReimprimePagare.find("#NumPagare").val('');
            mdlReimprimePagare.find("#Fecha").val('');
            mdlReimprimePagare.find("#NumPagare").focus();
            getPrestamosConsulta();

        });
    });

    function onValidarReimpresionPagares() {
        if (mdlReimprimePagare.find("#NumPagare").val() || mdlReimprimePagare.find("#Fecha").val()) {
            mdlReimprimePagare.find("#btnImprimePagare").attr('disabled', false);
            PrestamosConsulta.ajax.reload(function () {
                if (PrestamosConsulta.data().count() > 0) {
                    mdlbtnImprimePagare.attr('disabled', false);
                } else {
                    mdlbtnImprimePagare.attr('disabled', true);
                }
            });
        } else if (mdlReimprimePagare.find("#NumPagare").val() === '' ||
                mdlReimprimePagare.find("#Fecha").val() === '') {
            mdlReimprimePagare.find("#btnImprimePagare").attr('disabled', true);
            PrestamosConsulta.ajax.reload(function () {
                if (PrestamosConsulta.data().count() > 0) {
                    mdlbtnImprimePagare.attr('disabled', false);
                } else {
                    mdlbtnImprimePagare.attr('disabled', true);
                }
            });
        }
    }
    function getPrestamosConsulta() {
        if ($.fn.DataTable.isDataTable('#tblPrestamosConsulta')) {
            PrestamosConsulta.ajax.reload(function () {
                HoldOn.close();
                getAbonado();
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
                        d.EMPLEADO = mdlReimprimePagare.find("#EmpleadoConsulta").val() ? mdlReimprimePagare.find("#EmpleadoConsulta").val() : '';
                        d.PAGARE = mdlReimprimePagare.find("#NumPagare").val() ? mdlReimprimePagare.find("#NumPagare").val() : '';
                        d.FECHA = mdlReimprimePagare.find("#Fecha").val() ? mdlReimprimePagare.find("#Fecha").val() : '';
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
                "displayLength": 50,
                "bLengthChange": false,
                "deferRender": true,
                "scrollCollapse": false,
                "bSort": true,
                "scrollY": "250px",
                "scrollX": true,
                "aaSorting": [
                    [0, 'desc']
                ],
                initComplete: function () {
                    HoldOn.close();
                    getAbonado();
                },
                drawCallback: function () {
                    var api = this.api();
                    var prestado = 0, abonado = 0;
                    $.each(api.rows().data(), function (k, v) {
                        prestado += parseFloat(v.PRESTAMO);
                    });
                    mdlReimprimePagare.find(".total_prestado").text("$" + $.number(prestado, 2, '.', ','));
                    getAbonado();
                }
            });
        }
    }

    function getAbonado() {
        $.getJSON('<?php print base_url('PrestamosEmpleados/getAbonado') ?>', {
            EMPLEADO: xEmpleadoConsulta.val() ? xEmpleadoConsulta.val() : '',
            FECHA: mdlReimprimePagare.find("#Fecha").val() ? mdlReimprimePagare.find("#Fecha").val() : '',
            PAGARE: mdlReimprimePagare.find("#NumPagare").val() ? mdlReimprimePagare.find("#NumPagare").val() : ''
        }).done(function (a) {
            if (a.length > 0) {
                mdlReimprimePagare.find(".total_abonado").text("$" + $.number(a[0].ABONADO, 2, '.', ','));
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }
</script>