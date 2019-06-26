<div class="modal " id="mdlCajaAhorroPrestamos"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Imprime Caja de Ahorro y Préstamos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pnlCapturaReporteAhorroPrestamos">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoAhorroPrestamos" name="AnoAhorroPrestamos" required="">
                        </div>
                    </div>
                    <div class="row" id='selectEmpAhorroPrestamos'>
                        <div class="col-6" >
                            <label>Del Empleado</label>
                            <select id="dEmpleadoAhorroPrestamos" name="dEmpleadoAhorroPrestamos" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-6" >
                            <label>Al Empleado</label>
                            <select id="aEmpleadoAhorroPrestamos" name="aEmpleadoAhorroPrestamos" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row" id='selectEmpAhorroPrestamosDos'>
                        <div class="col-4">
                            <label>Tipo<span class="badge badge-info" style="font-size: 14px">1=Préstamos / 2=Caja Ahorro</span></label>
                            <select id="TipoAhorroPrestamos" name="TipoAhorroPrestamos" class="form-control form-control-sm required">
                                <option value=""></option>
                                <option value="1">1 PRÉSTAMOS</option>
                                <option value="2">2 CAJA DE AHORRO</option>
                            </select>
                        </div>
                        <div class="col-8 d-none" id="dTipoPrestamos">
                            <div class="card text-white bg-info mt-2" >
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <label>Selecciona una opción<span class="badge badge-danger" style="font-size: 14px">1=C/Saldo - 2=Histórico</span></label>
                                            <select id="TipoPrestamos" name="TipoPrestamos" class="form-control form-control-sm ">
                                                <option value=""></option>
                                                <option value="1">1 C/SALDO</option>
                                                <option value="2">2 HISTÓRICO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    var mdlCajaAhorroPrestamos = $('#mdlCajaAhorroPrestamos');
    $(document).ready(function () {
        mdlCajaAhorroPrestamos.on('shown.bs.modal', function () {
            handleEnterDiv($('#selectEmpAhorroPrestamos'));
            handleEnterDiv($('#selectEmpAhorroPrestamosDos'));

            setFocusSelectToInputOnChange('#TipoPrestamos', '#btnImprimir', mdlCajaAhorroPrestamos);
            mdlCajaAhorroPrestamos.find("input").val("");
            $.each(mdlCajaAhorroPrestamos.find("select"), function (k, v) {
                mdlCajaAhorroPrestamos.find("select")[k].selectize.clear(true);
            });
            mdlCajaAhorroPrestamos.find("#AnoAhorroPrestamos").val(new Date().getFullYear());
            mdlCajaAhorroPrestamos.find('#AnoAhorroPrestamos').focus().select();
            getEmpleadosImprimeAhorroPrestamos();
        });
        mdlCajaAhorroPrestamos.find("#AnoAhorroPrestamos").keydown(function (e) {
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
                        mdlCajaAhorroPrestamos.find("#AnoAhorroPrestamos").val("");
                        mdlCajaAhorroPrestamos.find("#AnoAhorroPrestamos").focus();
                    });
                } else {
                    mdlCajaAhorroPrestamos.find("#dEmpleadoAhorroPrestamos")[0].selectize.focus();
                }
            }
        });

        mdlCajaAhorroPrestamos.find("#TipoAhorroPrestamos").change(function () {
            if ($(this).val() === '1') {
                mdlCajaAhorroPrestamos.find('#dTipoPrestamos').removeClass('d-none');
                mdlCajaAhorroPrestamos.find("#TipoPrestamos")[0].selectize.focus();
            } else {
                mdlCajaAhorroPrestamos.find('#dTipoPrestamos').addClass('d-none');
                mdlCajaAhorroPrestamos.find('#btnImprimir').focus();
            }
        });

        mdlCajaAhorroPrestamos.find('#btnImprimir').on("click", function () {
            isValid('pnlCapturaReporteAhorroPrestamos');
            if (valido) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlCajaAhorroPrestamos.find("#frmCaptura")[0]);
                $.ajax({
                    url: base_url + 'index.php/ReportesNominaJasper/onImprimirCajaAhorroPrestamos',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
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
                            mdlCajaAhorroPrestamos.find('#btnImprimir').focus();
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
        })

    });

    function getEmpleadosImprimeAhorroPrestamos() {
        $.getJSON(base_url + 'index.php/ConceptosVariablesNomina/getEmpleados', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlCajaAhorroPrestamos.find("#dEmpleadoAhorroPrestamos")[0].selectize.addOption({text: v.Empleado, value: v.Clave});
                mdlCajaAhorroPrestamos.find("#aEmpleadoAhorroPrestamos")[0].selectize.addOption({text: v.Empleado, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

</script>



