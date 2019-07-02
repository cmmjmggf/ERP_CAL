<div class="modal " id="mdlRecibosNomina"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Imprime Recibos de Nómina por Sem-Depto-Empelado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pnlCapturaReporteRecibos">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12">
                            <label>Nota: <span class="badge badge-info" style="font-size: 14px;">Sí desea una semana completa, sólo capture el AÑO-SEM</span></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoRecibos" name="AnoRecibos" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Sem</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly " id="SemRecibos" name="SemRecibos" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-4">
                            <label>Del</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm " readonly="" id="FechaIni" name="FechaIni">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-4">
                            <label>Al</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm " readonly="" id="FechaFin" name="FechaFin">
                        </div>
                    </div>
                    <div class="row" id='selectEmpRecibos'>
                        <div class="col-6" >
                            <label>Departamento</label>
                            <select id="DeptoRecibos" name="DeptoRecibos" class="form-control form-control-sm ">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-6" >
                            <label>Empleado</label>
                            <select id="EmpleadoRecibos" name="EmpleadoRecibos" class="form-control form-control-sm ">
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
    var mdlRecibosNomina = $('#mdlRecibosNomina');
    $(document).ready(function () {
        mdlRecibosNomina.on('shown.bs.modal', function () {
            handleEnterDiv(mdlRecibosNomina);
            mdlRecibosNomina.find("input").not('#SemRecibos').val("");
            $.each(mdlRecibosNomina.find("select"), function (k, v) {
                mdlRecibosNomina.find("select")[k].selectize.clear(true);
            });
            mdlRecibosNomina.find("#AnoRecibos").val(new Date().getFullYear());
            mdlRecibosNomina.find('#AnoRecibos').focus().select();
            getSemanaByFechaAsistencia(getFechaActualConDiagonales());
            getDeptosImprimeRecibos();
            getEmpleadosImprimeRecibos();
        });
        mdlRecibosNomina.find("#AnoRecibos").keydown(function (e) {
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
                        mdlRecibosNomina.find("#AnoRecibos").val("");
                        mdlRecibosNomina.find("#AnoRecibos").focus();
                    });
                } else {
                    mdlRecibosNomina.find("#SemRecibos").focus().select();
                }
            }
        });
        mdlRecibosNomina.find("#SemRecibos").keydown(function (e) {
            if ($(this).val()) {
                if (e.keyCode === 13) {
                    var ano = mdlRecibosNomina.find("#AnoRecibos");
                    onComprobarSemanasNomina($(this), ano.val());
                }
            }
        });
        mdlRecibosNomina.find('#btnImprimir').on("click", function () {
            isValid('pnlCapturaReporteRecibos');
            if (valido) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlRecibosNomina.find("#frmCaptura")[0]);
                $.ajax({
                    url: base_url + 'index.php/ReportesNominaJasper/onImprimirRecibos',
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
                            mdlRecibosNomina.find('#btnImprimir').focus();
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

    function getDeptosImprimeRecibos() {
        $.getJSON(base_url + 'index.php/Departamentos/getDepartamentos', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlRecibosNomina.find("#DeptoRecibos")[0].selectize.addOption({text: v.Departamento, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }
    function getEmpleadosImprimeRecibos() {
        $.getJSON(base_url + 'index.php/ConceptosVariablesNomina/getEmpleados', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlRecibosNomina.find("#EmpleadoRecibos")[0].selectize.addOption({text: v.Empleado, value: v.Clave});
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
                mdlRecibosNomina.find('#SemRecibos').val(data[0].sem);
            } else {
                swal('ERROR', 'NO EXISTE SEMANA', 'info');
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function onComprobarSemanasNomina(v, ano) {
        //Valida que esté creada la semana en nominas
        $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
                mdlRecibosNomina.find('#FechaIni').val(data[0].FechaIni);
                mdlRecibosNomina.find('#FechaFin').val(data[0].FechaFin);
                mdlRecibosNomina.find('#DeptoRecibos')[0].selectize.focus();
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

