<div class="modal " id="mdlImprimirReporteAsistenciaF"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Imprime Asistencia F Por Año/Sem/Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pnlCapturaReporteAsisF">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12">
                            <label>Nota: <span class="badge badge-info" style="font-size: 14px;">Sí desea una semana completa, sólo capture el AÑO-SEM</span></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoAsistenciaF" name="AnoAsistenciaF" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly " id="SemAsistenciaF" name="SemAsistenciaF" required="">
                        </div>
                        <div class="col-8" id="selectEmpAsisF">
                            <label>Empleado</label>
                            <select id="EmpleadoAsistenciaF" name="EmpleadoAsistenciaF" class="form-control form-control-sm ">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">IMPRIMIR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlImprimirReporteAsistenciaF = $('#mdlImprimirReporteAsistenciaF');


    $(document).ready(function () {
        mdlImprimirReporteAsistenciaF.on('shown.bs.modal', function () {
            handleEnterDiv($('#selectEmpAsisF'));
            mdlImprimirReporteAsistenciaF.find("input").not('#SemAsistenciaF').val("");
            $.each(mdlImprimirReporteAsistenciaF.find("select"), function (k, v) {
                mdlImprimirReporteAsistenciaF.find("select")[k].selectize.clear(true);
            });
            mdlImprimirReporteAsistenciaF.find("#AnoAsistenciaF").val(new Date().getFullYear());
            getSemanaByFechaAsistenciaF(getFechaActualConDiagonales());
            mdlImprimirReporteAsistenciaF.find('#AnoAsistenciaF').focus().select();
            getEmpleadosImprimeAsisF();
        });
        mdlImprimirReporteAsistenciaF.find("#AnoAsistenciaF").keydown(function (e) {
            if (e.keyCode === 13) {
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
                        mdlImprimirReporteAsistenciaF.find("#AnoAsistenciaF").val("");
                        mdlImprimirReporteAsistenciaF.find("#AnoAsistenciaF").focus();
                    });
                } else {
                    mdlImprimirReporteAsistenciaF.find("#SemAsistenciaF").focus().select();
                }
            }
        });
        mdlImprimirReporteAsistenciaF.find("#SemAsistenciaF").keydown(function (e) {
            if (e.keyCode === 13) {
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
                        mdlImprimirReporteAsistenciaF.find("#SemAsistenciaF").val("");
                        mdlImprimirReporteAsistenciaF.find("#SemAsistenciaF").focus();
                    });
                } else {
                    mdlImprimirReporteAsistenciaF.find("#EmpleadoAsistenciaF")[0].selectize.focus();
                }

            }
        });
        mdlImprimirReporteAsistenciaF.find('#btnImprimir').on("click", function () {
            isValid('pnlCapturaReporteAsisF');
            if (valido) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlImprimirReporteAsistenciaF.find("#frmCaptura")[0]);
                $.ajax({
                    url: base_url + 'index.php/ReportesNominaJasper/onImprimirAsistenciasF',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    if (data.length > 0) {

                        $.fancybox.open({
                            src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
                            type: 'iframe',
                            opts: {
                                afterShow: function (instance, current) {
                                    console.info('done!');
                                },
                                iframe: {
                                    // Iframe template
                                    tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                                    preload: true,
                                    // Custom CSS styling for iframe wrapping element
                                    // You can use this to set custom iframe dimensions
                                    css: {
                                        width: "100%",
                                        height: "100%"
                                    },
                                    // Iframe tag attributes
                                    attr: {
                                        scrolling: "auto"
                                    }
                                }
                            }
                        });
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                            icon: "error"
                        }).then((action) => {
                            mdlImprimirReporteAsistenciaF.find('#btnImprimir').focus();
                        });
                    }
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });


    });

    function getEmpleadosImprimeAsisF() {
        $.getJSON(base_url + 'index.php/ConceptosVariablesNomina/getEmpleados', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlImprimirReporteAsistenciaF.find("#EmpleadoAsistenciaF")[0].selectize.addOption({text: v.Empleado, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }
    function getSemanaByFechaAsistenciaF(fecha) {
        $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getSemanaByFecha', {Fecha: fecha}).done(function (data) {
            if (data.length > 0) {
                mdlImprimirReporteAsistenciaF.find('#SemAsistenciaF').val(data[0].sem);
            } else {
                swal('ERROR', 'NO EXISTE SEMANA', 'info');
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

</script>

