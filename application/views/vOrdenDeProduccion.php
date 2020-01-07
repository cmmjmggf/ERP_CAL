<div id="mdlGeneraOrdenDeProduccion" class="modal">
    <div class="modal-dialog modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-cogs"></span> Genera orden de producción semana / maquila</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Maquila</label>
                        <input type="text" class="form-control form-control-sm numbersOnly" id="MaquilaOP" maxlength="4" onkeyup="onChecarMaquilaValida(this)">
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Semana</label>     
                        <input type="text" class="form-control form-control-sm numbersOnly" id="SemanaOP" maxlength="2"  min="1" max="52" onkeyup="onChecarSemanaValida(this)">
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Año</label>
                        <input type="text" class="form-control form-control-sm numbersOnly" id="AnoOP" maxlength="4" minlength="1">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 text-center">
                        <p class="text-danger font-weight-bold font-italic total_pares_msa text-uppercase"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="btnAceptaOP"><span class="fa fa-check"></span> Acepta</button> 
            </div>
        </div>
    </div>
</div>
<script>
    var mdlGeneraOrdenDeProduccion = $("#mdlGeneraOrdenDeProduccion"),
            MaquilaOP = mdlGeneraOrdenDeProduccion.find("#MaquilaOP"),
            SemanaOP = mdlGeneraOrdenDeProduccion.find("#SemanaOP"),
            AnoOP = mdlGeneraOrdenDeProduccion.find("#AnoOP"),
            btnAceptaOP = mdlGeneraOrdenDeProduccion.find("#btnAceptaOP"),
            AnioValido = (new Date()).getFullYear();

    // IIFE - Immediately Invoked Function Expression
    (function (yc) {
        // The global jQuery object is passed as a parameter
        yc(window.jQuery, window, document);
    }(function ($, window, document) {
        // The $ is now locally scoped
        // Listen for the jQuery ready event on the document
        $(function () {
            handleEnterDiv(mdlGeneraOrdenDeProduccion);
            AnoOP.on('keypress', function (e) {
                if (e.keyCode === 13) {
                    getTotalParesXMaquilaXSemanaXAno();
                }
            }).focusout(function () {
                getTotalParesXMaquilaXSemanaXAno();
            });
            SemanaOP.on('keypress', function (e) {
                if (e.keyCode === 13) {
                    getTotalParesXMaquilaXSemanaXAno();
                }
            }).focusout(function () {
                getTotalParesXMaquilaXSemanaXAno();
            });
            MaquilaOP.on('keypress', function (e) {
                if (e.keyCode === 13) {
                    getTotalParesXMaquilaXSemanaXAno();
                }
            }).focusout(function () {
                getTotalParesXMaquilaXSemanaXAno();
            });
            
            mdlGeneraOrdenDeProduccion.on('hidden.bs.modal', function () {
                btnAceptaOP.attr('disabled', true);
                AnoOP.val((new Date()).getFullYear());
                SemanaOP.val('');
                MaquilaOP.val('');
                mdlGeneraOrdenDeProduccion.find("p.total_pares_msa").text("0 PARES");
            });

            mdlGeneraOrdenDeProduccion.on('shown.bs.modal', function () {
                AnoOP.val((new Date()).getFullYear());
                MaquilaOP.focus().select();
            });

            btnAceptaOP.click(function () {
                HoldOn.open({
                    theme: 'sk-bounce',
                    message: 'GENERANDO...'
                });
                $.post('<?php print base_url('OrdenDeProduccion/onAgregarAOrdenDeProduccion'); ?>',
                        {MAQUILA: MaquilaOP.val(), SEMANA: SemanaOP.val(), ANO: AnoOP.val()}
                ).done(function (data) {
                    var r = JSON.parse(data[0]);
                    var nordenes = parseInt(r.ORDENES);
                    if (nordenes > 0) {
                        swal('ATENCIÓN', 'SE HAN CREADO ' + nordenes + ' ORDENES DE PRODUCCION DE LA MAQUILA ' + MaquilaOP.val() + ', SEMANA ' + SemanaOP.val() + ', AÑO ' + AnoOP.val()+'. DEL CONTROL '+r.CONTROLES_INICIAL+' AL CONTROL '+r.CONTROLES_FINAL, 'success').then((value) => {
                            MaquilaOP.focus().select();
                        });
                    } else {
                        swal('ATENCIÓN', 'NO HAY ORDENES DE PRODUCCION DISPONIBLES EN LA MAQUILA ' + MaquilaOP.val() + ', SEMANA ' + SemanaOP.val() + ', AÑO ' + AnoOP.val(), 'warning').then((value) => {
                            MaquilaOP.focus().select();
                        });
                    }
                }).fail(function (x, y, z) {
                    getError(x);
                    MaquilaOP.focus().select();
                }).always(function () {
                    HoldOn.close();
                });
            });

        });
    }));

    function onChecarMaquilaValida(e) {
        var n = $(e);
        if (n.val() !== '') {
            $.getJSON('<?php print base_url('OrdenDeProduccion/onChecarMaquilaValida') ?>', {ID: $(e).val()}).done(function (data) {
                if (parseInt(data[0].Maquila) <= 0) {
                    swal({
                        title: "Indique una maquila válida",
                        text: "La maquila " + $(e).val() + " no existe.",
                        icon: "warning",
                        focusConfirm: true,
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((value) => {
                        onVerificarFormValidoX();
                        $(e).val('').focus().select();
                    });
                }
            }).fail(function (x) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            }).always(function () {
                onVerificarFormValidoX();
            });
        }
    }

    function onChecarSemanaValida(e) {
        var n = $(e);
        if (n.val() !== '') {
            $.getJSON('<?php print base_url('OrdenDeProduccion/onChecarSemanaValida'); ?>', {ID: $(e).val()}).done(function (data) {
                if (parseInt(data[0].Semana) <= 0) {
                    var options = {
                        title: "Indique una semana de producción válida",
                        text: "La semana " + $(e).val() + " no existe o no ha sido generada.",
                        icon: "warning",
                        focusConfirm: true,
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    };
                    swal(options).then((value) => {
                        onVerificarFormValidoX();
                        $(e).val('').focus().select();
                    });
                }
            }).fail(function (x) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            }).always(function () {
                onVerificarFormValidoX();
            });
        }
    }

    function onVerificarFormValidoX() {
        if (parseInt(AnoOP.val()) <= parseInt(AnioValido)) {
            if (MaquilaOP.val() !== '' && SemanaOP.val() !== '' && AnoOP.val() !== '') {
                btnAceptaOP.attr('disabled', false);
            } else {
                btnAceptaOP.attr('disabled', true);
            }
        } else {
            swal({
                title: "Imposible realizar esta acción",
                text: "El año no puede ser mayor al año actual " + AnioValido + ", escriba un año valido para este proposito.",
                icon: "warning",
                focusConfirm: true,
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((value) => {
                AnoOP.focus().select();
            });
        }
    }

    function getTotalParesXMaquilaXSemanaXAno() {
        $.getJSON('<?php print base_url('OrdenDeProduccion/getTotalParesXMaquilaXSemanaXAno') ?>', {
            MAQUILA: MaquilaOP.val() ? MaquilaOP.val() : '',
            SEMANA: SemanaOP.val() ? SemanaOP.val() : '',
            ANIO: AnoOP.val() ? AnoOP.val() : ''
        }).done(function (x) {
            var prs = 0;
            if (x.length > 0) {
                prs = parseInt(x[0].PARES);
            }
            mdlGeneraOrdenDeProduccion.find("p.total_pares_msa").text(prs + " PARES");
            if (prs > 0) {
                btnAceptaOP.attr('disabled', false);
            } else {
                btnAceptaOP.attr('disabled', true);
            }
        }).fail(function (xx) {
            getError(xx);
        }).always(function () {
        });
    }
</script>
<style>
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