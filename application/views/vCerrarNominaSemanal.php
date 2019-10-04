<div class="modal " id="mdlCerrarNominaDeSemana"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cierra Nómina Semanal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pnlCapturaReporteCierraNomina">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoCierraNomina" name="AnoCierraNomina" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Sem</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly " id="SemCierraNomina" name="SemCierraNomina" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4 col-xl-4">
                            <label>Del</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="FechaIniCierraNomina" name="FechaIniCierraNomina">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-4">
                            <label>Al</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="FechaFinCierraNomina" name="FechaFinCierraNomina">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnImprimir">CERRAR SEMANA</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlCerrarNominaDeSemana = $('#mdlCerrarNominaDeSemana');
    $(document).ready(function () {
        mdlCerrarNominaDeSemana.on('shown.bs.modal', function () {
            mdlCerrarNominaDeSemana.find("input").val("");
            $.each(mdlCerrarNominaDeSemana.find("select"), function (k, v) {
                mdlCerrarNominaDeSemana.find("select")[k].selectize.clear(true);
            });
            mdlCerrarNominaDeSemana.find("#AnoCierraNomina").val(new Date().getFullYear());
            mdlCerrarNominaDeSemana.find('#AnoCierraNomina').focus().select();
        });
        mdlCerrarNominaDeSemana.find("#AnoCierraNomina").keypress(function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                    swal({
                        title: "ATENCIÓN",
                        text: "AÑO INCORRECTO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        mdlCerrarNominaDeSemana.find("#AnoCierraNomina").val("");
                        mdlCerrarNominaDeSemana.find("#AnoCierraNomina").focus();
                    });
                } else {
                    mdlCerrarNominaDeSemana.find("#SemCierraNomina").focus().select();
                }
            }
        });
        mdlCerrarNominaDeSemana.find("#SemCierraNomina").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var ano = mdlCerrarNominaDeSemana.find("#AnoCierraNomina");
                    onComprobarSemanasNominaCierraNomina($(this), ano.val());
                }
            }
        });

        mdlCerrarNominaDeSemana.find('#btnImprimir').on("click", function () {
            isValid('pnlCapturaReporteCierraNomina');
            if (valido) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlCerrarNominaDeSemana.find("#frmCaptura")[0]);
                $.ajax({
                    url: base_url + 'index.php/CerrarNominaSemanal/onCerrarNomina',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    swal({
                        title: "ATENCIÓN",
                        text: "* NÓMINA CERRADA CORRECTAMENTE *",
                        icon: "success",
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
                                mdlCerrarNominaDeSemana.find("input").val("");
                                mdlCerrarNominaDeSemana.find("#AnoCierraNomina").val(new Date().getFullYear()).focus().select();
                                break;
                        }
                    });
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


    function onComprobarSemanasNominaCierraNomina(v, ano) {
        //Valida que esté creada la semana en nominas
        $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {Clave: $(v).val(), Ano: ano}).done(function (dataUno) {
            if (dataUno.length > 0) {
                //Valida que no esté cerrada la semana en nomina
                $.getJSON(base_url + 'index.php/ConceptosVariablesNomina/onVerificarSemanaNominaCerrada', {Sem: $(v).val(), Ano: ano}).done(function (data) {
                    if (data.length > 0) {//Si existe en prenomina validamos que sólo esté en estatus 1
                        if (parseInt(data[0].status) === 2) {
                            swal({
                                title: "ATENCIÓN",
                                text: "LA NÓMINA DE LA SEMANA " + $(v).val() + " DEL " + ano + " " + "ESTÁ CERRADA",
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
                        } else {//Sí está pero esta en estatus 1
                            mdlCerrarNominaDeSemana.find('#FechaIniCierraNomina').val(dataUno[0].FechaIni);
                            mdlCerrarNominaDeSemana.find('#FechaFinCierraNomina').val(dataUno[0].FechaFin);
                            mdlCerrarNominaDeSemana.find('#btnImprimir').focus();
                        }
                    } else {//Aún no existe la nomina, podemos continuar
                        swal({
                            title: "ATENCIÓN",
                            text: "LA NÓMINA DE LA SEMANA " + $(v).val() + " DEL " + ano + " " + "NO HA SIDO CERRADA TODAVÍA",
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

    function onCerrarNominaSemanal() {
        mdlCerrarNominaDeSemana.modal({
            backdrop: 'static',
            keyboard: false
        });
    }

</script>



