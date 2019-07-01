<div class="modal " id="mdlCostoManoObraGeneral"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Costeo mano obra completa por semana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pnlCapturaReporteCostoMOGen">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3 col-xl-4">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoCostoMOGen" name="AnoCostoMOGen" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-xl-4">
                            <label>Sem</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly " id="SemCostoMOGen" name="SemCostoMOGen" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4 col-xl-4">
                            <label>Del</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm " readonly="" id="FechaIniCostoMOGen" name="FechaIniCostoMOGen">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-4">
                            <label>Al</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm " readonly="" id="FechaFinCostoMOGen" name="FechaFinCostoMOGen">
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
    var mdlCostoManoObraGeneral = $('#mdlCostoManoObraGeneral');
    $(document).ready(function () {
        mdlCostoManoObraGeneral.on('shown.bs.modal', function () {
            mdlCostoManoObraGeneral.find("input").val("");
            $.each(mdlCostoManoObraGeneral.find("select"), function (k, v) {
                mdlCostoManoObraGeneral.find("select")[k].selectize.clear(true);
            });
            mdlCostoManoObraGeneral.find("#AnoCostoMOGen").val(new Date().getFullYear());
            mdlCostoManoObraGeneral.find('#AnoCostoMOGen').focus().select();
        });
        mdlCostoManoObraGeneral.find("#AnoCostoMOGen").keydown(function (e) {
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
                        mdlCostoManoObraGeneral.find("#AnoCostoMOGen").val("");
                        mdlCostoManoObraGeneral.find("#AnoCostoMOGen").focus();
                    });
                } else {
                    mdlCostoManoObraGeneral.find("#SemCostoMOGen").focus().select();
                }
            }
        });
        mdlCostoManoObraGeneral.find("#SemCostoMOGen").keydown(function (e) {
            if ($(this).val()) {
                if (e.keyCode === 13) {
                    var ano = mdlCostoManoObraGeneral.find("#AnoCostoMOGen");
                    onComprobarSemanasNomina($(this), ano.val());
                }
            }
        });
        mdlCostoManoObraGeneral.find('#btnImprimir').on("click", function () {
            isValid('pnlCapturaReporteCostoMOGen');
            if (valido) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlCostoManoObraGeneral.find("#frmCaptura")[0]);
                $.ajax({
                    url: base_url + 'index.php/ReportesNominaJasper/onImprimirCostoMOGen',
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
                            mdlCostoManoObraGeneral.find('#btnImprimir').focus();
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


    function onComprobarSemanasNomina(v, ano) {
        //Valida que esté creada la semana en nominas
        $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
                mdlCostoManoObraGeneral.find('#FechaIniCostoMOGen').val(data[0].FechaIni);
                mdlCostoManoObraGeneral.find('#FechaFinCostoMOGen').val(data[0].FechaFin);
                mdlCostoManoObraGeneral.find('#btnImprimir').focus();
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

