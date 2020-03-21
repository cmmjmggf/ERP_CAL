<div class="modal " id="mdlImprimirReporteAsistencia"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Imprime Asistencia Por Año/Sem/Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pnlCapturaReporteAsis">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12">
                            <label>Nota: <span class="badge badge-info" style="font-size: 14px;">Sí desea una semana completa, sólo capture el AÑO-SEM</span></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoAsistencia" name="AnoAsistencia" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly " id="SemAsistencia" name="SemAsistencia" required="">
                        </div>
                        <div class="col-8" id="selectEmpAsis">
                            <label>Departamento</label>
                            <select id="DeptoAsistencia" name="DeptoAsistencia" class="form-control form-control-sm ">
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
    var mdlImprimirReporteAsistencia = $('#mdlImprimirReporteAsistencia');
    var ControlesNominaRastreo;

    $(document).ready(function () {
        mdlImprimirReporteAsistencia.on('shown.bs.modal', function () {
            handleEnterDiv($('#selectEmpAsis'));
            mdlImprimirReporteAsistencia.find("input").not('#SemAsistencia').val("");
            $.each(mdlImprimirReporteAsistencia.find("select"), function (k, v) {
                mdlImprimirReporteAsistencia.find("select")[k].selectize.clear(true);
            });
            mdlImprimirReporteAsistencia.find("#AnoAsistencia").val(new Date().getFullYear());
            getSemanaByFechaAsistencia(getFechaActualConDiagonales());
            mdlImprimirReporteAsistencia.find('#AnoAsistencia').focus().select();
            getDeptosImprimeAsis();
        });
        mdlImprimirReporteAsistencia.find("#AnoAsistencia").keydown(function (e) {
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
                        mdlImprimirReporteAsistencia.find("#AnoAsistencia").val("");
                        mdlImprimirReporteAsistencia.find("#AnoAsistencia").focus();
                    });
                } else {
                    mdlImprimirReporteAsistencia.find("#SemAsistencia").focus().select();
                }
            }
        });
        mdlImprimirReporteAsistencia.find("#SemAsistencia").keydown(function (e) {
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
                        mdlImprimirReporteAsistencia.find("#SemAsistencia").val("");
                        mdlImprimirReporteAsistencia.find("#SemAsistencia").focus();
                    });
                } else {
                    mdlImprimirReporteAsistencia.find("#DeptoAsistencia")[0].selectize.focus();
                }

            }
        });
        mdlImprimirReporteAsistencia.find('#btnImprimir').on("click", function () {
            onDisable(mdlImprimirReporteAsistencia.find('#btnImprimir'));
            isValid('pnlCapturaReporteAsis');
            if (valido) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlImprimirReporteAsistencia.find("#frmCaptura")[0]);
                $.ajax({
                    url: base_url + 'index.php/ReportesNominaJasper/onImprimirAsistencias',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    onEnable(mdlImprimirReporteAsistencia.find('#btnImprimir'));
                    if (data.length !== '0') {

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
                            mdlImprimirReporteAsistencia.find('#btnImprimir').focus();
                        });
                    }
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    onEnable(mdlImprimirReporteAsistencia.find('#btnImprimir'));
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                onEnable(mdlImprimirReporteAsistencia.find('#btnImprimir'));
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });


    });

    function getDeptosImprimeAsis() {
        $.getJSON(base_url + 'index.php/Departamentos/getDepartamentos', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlImprimirReporteAsistencia.find("#DeptoAsistencia")[0].selectize.addOption({text: v.Departamento, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }
    function getSemanaByFechaAsistencia(fecha) {
        $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getSemanaByFecha', {Fecha: fecha}).done(function (data) {
            if (data.length > 0) {
                mdlImprimirReporteAsistencia.find('#SemAsistencia').val(data[0].sem);
            } else {
                swal('ERROR', 'NO EXISTE SEMANA', 'info');
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

</script>

