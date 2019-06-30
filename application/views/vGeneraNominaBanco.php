<div class="modal " id="mdlGeneraNominaBanco"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Genera Nómina Banco</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoNominaBanco" name="AnoNominaBanco" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="SemNominaBanco" name="SemNominaBanco" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-4">
                            <label>Del</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="FechaINominaBanco" name="FechaINominaBanco">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-4">
                            <label>Al</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="FechaFNominaBanco" name="FechaFNominaBanco">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Fecha de aplicación de la nómina</label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaAplicacionNomina" name="FechaAplicacionNomina" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir"><span class="fa fa-file-alt"></span> EXPORTAR TXT </button>
                <button type="button" class="btn btn-danger" id="btnImprimirPDF"><span class="fa fa-file-pdf"></span> IMPRIMIR PDF</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlGeneraNominaBanco = $('#mdlGeneraNominaBanco');

    function onGeneraNominaFiscal() {
        location.href = base_url + "index.php/ReportesNominaJasper/generaArchivoBancoFiscal";
        HoldOn.close();
    }

    function onGeneraNominaFiscalDos() {
        location.href = base_url + "index.php/ReportesNominaJasper/generaArchivoBancoInterna";
        HoldOn.close();
    }
    $(document).ready(function () {
        mdlGeneraNominaBanco.on('shown.bs.modal', function () {
            mdlGeneraNominaBanco.find("input").not('#SemNominaBanco').val("");
            $.each(mdlGeneraNominaBanco.find("select"), function (k, v) {
                mdlGeneraNominaBanco.find("select")[k].selectize.clear(true);
            });
            mdlGeneraNominaBanco.find("#AnoNominaBanco").val(new Date().getFullYear());
            getSemanaByFechaNominaBancoControlNom(getFechaActualConDiagonales());
            mdlGeneraNominaBanco.find('#AnoNominaBanco').focus().select();
        });
        mdlGeneraNominaBanco.find('#btnImprimirPDF').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlGeneraNominaBanco.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesNominaJasper/onReporteNominaBancoPDF',
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
                                    width: "85%",
                                    height: "85%"
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
                        text: "NO EXISTEN DATOS PARA EL REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlGeneraNominaBanco.find('#FechaAplicacionNomina').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        mdlGeneraNominaBanco.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var frm = new FormData(mdlGeneraNominaBanco.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesNominaJasper/onReporteNominaBanco',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                onGeneraNominaFiscal();
                setTimeout(function () {
                    onGeneraNominaFiscalDos();
                }, 1000);
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                HoldOn.close();
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            }).always(function () {

            });



        });

        mdlGeneraNominaBanco.find("#AnoNominaBanco").keydown(function (e) {
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
                        mdlGeneraNominaBanco.find("#AnoNominaBanco").val("");
                        mdlGeneraNominaBanco.find("#AnoNominaBanco").focus();
                    });
                } else {
                    mdlGeneraNominaBanco.find("#SemNominaBanco").focus().select();
                }
            }
        });
        mdlGeneraNominaBanco.find("#SemNominaBanco").keydown(function (e) {
            if (e.keyCode === 13) {
                var ano = mdlGeneraNominaBanco.find("#AnoNominaBanco");
                onComprobarSemanasNominaNominaBanco($(this), ano.val());
            }
        });
        mdlGeneraNominaBanco.find("#FechaAplicacionNomina").keyup(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlGeneraNominaBanco.find("#btnImprimir").focus().select();
                }
            }
        });
    });

    function getSemanaByFechaNominaBancoControlNom(fecha) {
        $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getSemanaByFecha', {Fecha: fecha}).done(function (data) {
            if (data.length > 0) {
                mdlGeneraNominaBanco.find('#SemNominaBanco').val(data[0].sem);
                mdlGeneraNominaBanco.find('#FechaINominaBanco').val(data[0].FechaIni);
                mdlGeneraNominaBanco.find('#FechaFNominaBanco').val(data[0].FechaFin);
            } else {
                swal('ERROR', 'NO EXISTE SEMANA', 'info');
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onComprobarSemanasNominaNominaBanco(v, ano) {
        //Valida que esté creada la semana en nominas
        $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {Clave: $(v).val(), Ano: ano}).done(function (dataSem) {
            if (dataSem.length > 0) {
                mdlGeneraNominaBanco.find('#FechaINominaBanco').val(dataSem[0].FechaIni);
                mdlGeneraNominaBanco.find('#FechaFNominaBanco').val(dataSem[0].FechaFin);
                mdlGeneraNominaBanco.find("#FechaAplicacionNomina").focus();

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