<div class="modal" id="mdlReasignarControles">
    <div class="modal-dialog modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-cogs"></span> Reasignar controles (Maquila/Semana)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" style="padding-left: 15px">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <strong>Ctrl.Inicial</strong>
                        <input type="text" class="form-control form-control-sm numbersOnly" id="ControlInicial" autofocus placeholder="Ej:180152001">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <strong>Ctrl.Final</strong>
                        <input type="text" class="form-control form-control-sm numbersOnly" id="ControlFinal" placeholder="Ej:180152005">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <strong>Maquila asignada</strong>
                        <input type="text" class="form-control form-control-sm " id="MaquilaAsignada" placeholder="Maquila 1" maxlength="4" onblur="onChecarMaquilaValida(this)">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <strong>Semana asignada</strong>
                        <input type="text" class="form-control form-control-sm " id="SemanaAsignada" placeholder="Semana 1" maxlength="3" onblur="onChecarSemanaValida(this);">
                    </div>
                    <div class="w-100 my-1">
                        <hr>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <strong>Maquila a asignar</strong>
                        <input type="text"  class="form-control form-control-sm " id="MaquilaAAsignar" placeholder="Maquila 2" maxlength="4" onblur="onChecarMaquilaValida(this)">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <strong>Semana a asignar</strong>
                        <input type="text" class="form-control form-control-sm " id="SemanaAAsignar" placeholder="Semana 2" maxlength="3" onblur="onChecarSemanaValida(this)">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <strong>Observaciones</strong>
                        <input type="text" id="ObservacionesTitulo" name="Observaciones" class="form-control form-control-sm mb-3" placeholder="Observacion uno" />
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <strong>Observaciones adicionales</strong>
                        <input type="text" id="Observaciones" name="Adicionales" class="form-control form-control-sm" placeholder="Observacion dos" />
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-3" align="left">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="btnReAsignar" disabled=""> <span class="fa fa-save"></span> Acepta</button>
            </div>
        </div>
    </div>
</div>

<script>
    var mdlReasignarControles = $("#mdlReasignarControles"),
            ObservacionesTitulo = mdlReasignarControles.find("#ObservacionesTitulo"),
            Observaciones = mdlReasignarControles.find("#Observaciones"),
            MaquilaAsignada = mdlReasignarControles.find("#MaquilaAsignada"),
            MaquilaAAsignar = mdlReasignarControles.find("#MaquilaAAsignar"),
            SemanaAsignada = mdlReasignarControles.find("#SemanaAsignada"),
            SemanaAAsignar = mdlReasignarControles.find("#SemanaAAsignar"),
            ControlInicial = mdlReasignarControles.find("#ControlInicial"),
            ControlFinal = mdlReasignarControles.find("#ControlFinal"),
            btnReAsignar = mdlReasignarControles.find("#btnReAsignar");

    // IIFE - Immediately Invoked Function Expression
    (function (yc) {
        // The global jQuery object is passed as a parameter
        yc(window.jQuery, window, document);
    }(function ($, window, document) {
        // The $ is now locally scoped
        // Listen for the jQuery ready event on the document
        $(function () {
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var min = parseFloat($('#ControlInicial').val());
                        var max = parseFloat($('#ControlFinal').val());
                        var age = parseFloat(data[15]) || 0; // use data for the age column
                        if ((isNaN(min) && isNaN(max)) || (isNaN(min) && age <= max) || (min <= age && isNaN(max)) || (min <= age && age <= max))
                        {
                            return true;
                        }
                        return false;
                    }
            );

            ControlFinal.keydown(function (e) {
                console.log(e.keyCode);
                if (e.keyCode === 13) {
                    getMaquilaSemanaXControl();
                }
            });

            ControlInicial.keydown(function (e) {
                console.log(e.keyCode);
                if (e.keyCode === 13) {
                    onObtenerElUltimoControl(this);
                    getMaquilaSemanaXControl();
                }
            });

            handleEnterDiv(mdlReasignarControles);

            mdlReasignarControles.on('shown.bs.modal', function () {
                mdlReasignarControles.find("input").val('');
                ControlInicial.focus().select();
            });

            btnReAsignar.click(function () {
                if (ControlInicial.val() && ControlFinal.val()) {
                    swal({
                        title: "¿Estas seguro?",
                        text: "Serán reasignados los controles, una vez completada la acción. Nota: Es necesario regenerar las ordenes de producción una vez regenerados los controles. ",
                        icon: "warning",
                        buttons: true
                    }).then((willDelete) => {
                        if (willDelete) {
                            var f = new FormData();
                            f.append('OBSERVACIONES', ObservacionesTitulo.val() !== '' ? ObservacionesTitulo.val() : '');
                            f.append('OBSERVACIONES_ADICIONALES', Observaciones.val() !== '' ? Observaciones.val() : '');
                            f.append('SEMANA_ASIGNADA', SemanaAsignada.val() !== '' ? SemanaAsignada.val() : '');
                            f.append('SEMANA_A_ASIGNAR', SemanaAAsignar.val() !== '' ? SemanaAAsignar.val() : '');
                            f.append('MAQUILA_ASIGNADA', MaquilaAsignada.val() !== '' ? MaquilaAsignada.val() : '');
                            f.append('MAQUILA_A_ASIGNAR', MaquilaAAsignar.val() !== '' ? MaquilaAAsignar.val() : '');
                            f.append('INICIO', ControlInicial.val() !== '' ? ControlInicial.val() : '');
                            f.append('FIN', ControlFinal.val() !== '' ? ControlFinal.val() : '');
                            $.ajax({
                                url: '<?php print base_url('ReasignarControles/onReAsignarControles'); ?>',
                                type: "POST",
                                cache: false,
                                contentType: false,
                                processData: false,
                                data: f
                            }).done(function (data, x, jq) {
                                console.log(data);
                                swal({
                                    title: 'INFO',
                                    text: 'SE HAN REASIGNADO LOS REGISTROS',
                                    icon: 'success',
                                    timer: 1500
                                }).then((value) => {
                                    mdlReasignarControles.find("input").val('');
                                    ControlInicial.focus().select();
                                    btnReAsignar.prop("disabled", true);
                                });
                            }).fail(function (x, y, z) {
                                console.log(x, y, z);
                            }).always(function () {
                                HoldOn.close();
                            });
                        }
                    });
                } else {
                    onBeep(2);
                    iMsg('DEBE DE ESPECIFICAR UN CONTROL', 'w', function () {
                        ControlInicial.focus().select();
                    });
                }
            });//ASIGNAR
        }
        );
    }));

    function onChecarMaquilaValida(e) {
        var n = $(e);
        if (n.val() !== '') {
            $.getJSON('<?php print base_url('ReasignarControles/onChecarMaquilaValida'); ?>', {ID: $(e).val()}).done(function (data) {
                if (parseInt(data[0].Maquila) <= 0) {
                    swal({
                        title: "Indique una maquila válida",
                        text: "La maquila " + $(e).val() + " no existe.",
                        icon: "warning",
                        focusConfirm: true,
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((value) => {
                        $(e).val('').focus().select();
                    });
                }
            }).fail(function () {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            }).always(function () {
                onVerificarFormValido();
            });
        }
    }

    function onChecarSemanaValida(e) {
        var n = $(e);
        if (n.val() !== '') {
            $.getJSON('<?php print base_url('ReasignarControles/onChecarSemanaValida'); ?>', {ID: $(e).val()}).done(function (data) {
                if (parseInt(data[0].Semana) <= 0) {
                    swal({
                        title: "Indique una semana de producción válida",
                        text: "La semana " + $(e).val() + " no existe o no ha sido generada.",
                        icon: "warning",
                        focusConfirm: true,
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((value) => {
                        $(e).val('').focus().select();
                    });
                }
            }).fail(function (x) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            }).always(function () {
                onVerificarFormValido();
            });
        }
    }

    function pad(str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

    function onVerificarFormValido() {
        var a = ControlInicial, b = ControlFinal, c = MaquilaAsignada, d = SemanaAsignada;
        if (a.val() !== '' && b.val() !== '' && c.val() !== '' && d.val() !== '') {
            btnReAsignar.prop("disabled", false);
        } else {
            btnReAsignar.prop("disabled", true);
        }
    }

    function onObtenerElUltimoControl(e) {
        var control = $(e).val();
        if (control) {
            var semana = parseInt(control.slice(2, 4));
            var maquila = parseInt(control.slice(4, 6));
            $.getJSON('<?php print base_url('ReasignarControles/onObtenerElUltimoControl'); ?>',
                    {SEMANA: semana, MAQUILA: maquila}).done(function (data) {
                var dt = data[0];
                if (data.length > 0) {
//                    ControlFinal.val(dt.ULTIMO_CONTROL);
                    onBeep(1);
                }
            }).fail(function (x, y, z) {
                console.log(x.responseText);
            });
        }
    }

    function getMaquilaSemanaXControl() {
        $.getJSON('<?php print base_url('ReasignarControles/getMaquilaSemanaXControl'); ?>', {
            CONTROL_INICIAL: (ControlInicial.val() ? ControlInicial.val() : ''),
            CONTROL_FINAL: ControlFinal.val() ? ControlFinal.val() : ControlInicial.val()
        }).done(function (a) {
            console.log("MAQUILA SEMANA X CONTROL");
            console.log(a, a.length);
            if (a.length > 0) {
                var xxx = a[0];
                MaquilaAsignada.val(xxx.MAQUILA);
                SemanaAsignada.val(xxx.SEMANA);
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }
</script>
<style>

    .dropdown-item.active, .dropdown-item:active{
        color: #fff !important;
    }
    a[class*="text-"]:hover, a a[class*="text-"]:focus{
        color: #fff !important;
    }
    tr:hover td{
        background-color: #1b4f72;
        color: #fff;
    }


    td:hover {
        position: relative;
        background-color: #212529 !important;
        font-weight: bold;
        font-size: 12px;
        color:  #fff;
    }
    td:hover span.text-info{
        position: relative;
        font-weight: bold;
        font-size: 14px;
        color:  #ffeb3b !important;
    }

    td:hover span.text-danger{
        position: relative;
        font-weight: bold;
        font-size: 14px;
        color:  #fff !important;
    }

    td[title]:hover:after {
        text-align: center;
        content: attr(title);
        padding: 3px 5px 0px 5px;
        position: absolute;
        left: 0;
        top: 100%;
        white-space: nowrap;
        z-index: 1;
        background: #0099cc;
        color: #fff;
    }
</style>