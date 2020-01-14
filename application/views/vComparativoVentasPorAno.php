<div class="modal " id="mdlComparativoVentasPorAno"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Comparativo de Ventas Por Año</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-9 mb-2">
                            <label>Del agente: <span class="badge badge-info mb-2" style="font-size: 14px;"> Deja en blanco para ver todos los agentes</span></label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="Agente" name="Agente" >
                                </div>
                                <div class="col-9">
                                    <select id="sAgente" name="sAgente" class="form-control form-control-sm required NotSelectize" required="" >
                                        <option value=""></option>
                                        <?php
                                        foreach ($this->db->query("SELECT A.Clave, CONCAT(A.Nombre) AS Agente FROM agentes AS A")->result() as $k => $v) {
                                            print "<option value=\"{$v->Clave}\">{$v->Agente}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-3">
                            <label>Año Inicial</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoI" name="AnoI" >
                        </div>
                        <div class="col-3">
                            <label>Año Final</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoF" name="AnoF" >
                        </div>
                        <div class="col-3">
                            <label>Hasta el Mes:</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Mes" name="Mes" >
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptar">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlComparativoVentasPorAno = $('#mdlComparativoVentasPorAno');
    var precio_Art = 0;
    $(document).ready(function () {
        mdlComparativoVentasPorAno.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        mdlComparativoVentasPorAno.on('shown.bs.modal', function () {
            mdlComparativoVentasPorAno.find("input").val("");
            $.each(mdlComparativoVentasPorAno.find("select"), function (k, v) {
                mdlComparativoVentasPorAno.find("select")[k].selectize.clear(true);
            });
            mdlComparativoVentasPorAno.find("#AnoI").val(new Date().getFullYear() - 1);
            mdlComparativoVentasPorAno.find("#AnoF").val(new Date().getFullYear());
            mdlComparativoVentasPorAno.find('#Mes').val(new Date().getMonth() + 1);
            mdlComparativoVentasPorAno.find('#Agente').focus();
        });

        mdlComparativoVentasPorAno.find('#btnAceptar').on("click", function () {
            onDisable(mdlComparativoVentasPorAno.find('#btnAceptar'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlComparativoVentasPorAno.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteComparativoVentasPorAno',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                onEnable(mdlComparativoVentasPorAno.find('#btnAceptar'));
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        mdlComparativoVentasPorAno.find('#Agente').focus();
                        onEnable(mdlComparativoVentasPorAno.find('#btnAceptar'));
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        onEnable(mdlComparativoVentasPorAno.find('#btnAceptar'));
                        mdlComparativoVentasPorAno.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                onEnable(mdlComparativoVentasPorAno.find('#btnAceptar'));
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        mdlComparativoVentasPorAno.find('#Agente').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtagt = $(this).val();
                if (txtagt) {
                    $.getJSON(base_url + 'index.php/ReportesClientesJasper/onVerificarAgente', {Agente: txtagt}).done(function (data) {
                        if (data.length > 0) {
                            mdlComparativoVentasPorAno.find("#sAgente")[0].selectize.addItem(txtagt, true);
                            mdlComparativoVentasPorAno.find('#AnoI').focus().select();
                        } else {
                            swal('ERROR', 'EL AGENTE NO EXISTE', 'warning').then((value) => {
                                mdlComparativoVentasPorAno.find("#sAgente")[0].selectize.clear(true);
                                mdlComparativoVentasPorAno.find('#Agente').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                } else {
                    mdlComparativoVentasPorAno.find("#sAgente")[0].selectize.clear(true);
                    mdlComparativoVentasPorAno.find('#AnoI').focus().select();
                }
            }
        });
        mdlComparativoVentasPorAno.find("#sAgente").change(function () {
            if ($(this).val()) {
                mdlComparativoVentasPorAno.find("#Agente").val($(this).val());
                mdlComparativoVentasPorAno.find('#AnoI').focus().select();
            }
        });

        mdlComparativoVentasPorAno.find("#AnoI").keypress(function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                    swal({
                        title: "ATENCIÓN",
                        text: "AÑO INCORRECTO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        mdlComparativoVentasPorAno.find("#AnoI").val("");
                        mdlComparativoVentasPorAno.find("#AnoI").focus();
                    });
                } else {
                    mdlComparativoVentasPorAno.find("#AnoF").focus().select();
                }
            }
        });

        mdlComparativoVentasPorAno.find("#AnoF").keypress(function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                    swal({
                        title: "ATENCIÓN",
                        text: "AÑO INCORRECTO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        mdlComparativoVentasPorAno.find("#AnoF").val("");
                        mdlComparativoVentasPorAno.find("#AnoF").focus();
                    });
                } else {
                    mdlComparativoVentasPorAno.find("#Mes").focus().select();
                }
            }
        });
        mdlComparativoVentasPorAno.find("#Mes").keypress(function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val()) < 1 || parseInt($(this).val()) > 12 || $(this).val() === '') {
                    swal({
                        title: "ATENCIÓN",
                        text: "MES INCORRECTO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        mdlComparativoVentasPorAno.find("#Mes").val("");
                        mdlComparativoVentasPorAno.find("#Mes").focus();
                    });
                } else {
                    mdlComparativoVentasPorAno.find('#btnAceptar').focus();
                }
            }
        });


    });
</script>
