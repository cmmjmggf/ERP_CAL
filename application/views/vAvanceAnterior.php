<div class="modal " id="mdlAvanceAnterior"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Avance por control</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCapturaAvaAnt">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3 col-xl-3">
                            <label for="" >Fecha</label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaAvance" name="FechaAvance" required="">
                        </div>

                        <div class="col-5">
                            <label>Departamento</label>
                            <select id="DeptoAvance" name="DeptoAvance" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-md-2 col-xl-3">
                            <label>Doc.</label>
                            <input type="text" maxlength="14" class="form-control form-control-sm numbersOnly" id="DoctoAvance" name="DoctoAvance" required="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 col-xs-6 col-sm-2 col-lg-3 col-xl-3">
                            <label>Control  <span class="badge badge-danger" style="font-size: 14px;" id="EstatusProduccion"></span></label>
                            <input type="text" id="ControlAvance" name="ControlAvance" maxlength="10" class="form-control form-control-sm numeric" required="">
                        </div>
                        <div class="col-6 col-xs-6 col-sm-2 col-lg-3 col-xl-3">
                            <label>Estilo</label>
                            <input type="text" id="EstiloAvance" name="EstiloAvance" readonly="" class="form-control form-control-sm">
                        </div>
                        <div class="col-6 col-xs-6 col-sm-1 col-lg-2 col-xl-2">
                            <label>Color</label>
                            <input type="text" id="ColorAvance" name="ColorAvance" readonly="" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 col-xs-12 col-sm-1 col-lg-2 col-xl-2">
                            <label>Pares</label>
                            <input type="text" id="ParesAvance" maxlength="4" readonly="" name="ParesAvance" class="form-control form-control-sm numeric " >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-xs-6 col-sm-2 col-lg-3 col-xl-3">
                            <label>Avance Actual:  <span class="badge badge-danger" style="font-size: 14px;" id="EstatusProduccionAvance"></span></label>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary selectNotEnter" id="btnAceptar">ACEPTAR</button>
                <button type="button" class="btn btn-success selectNotEnter" id="btnImprimir">IMPRIMIR</button>
                <button type="button" class="btn btn-secondary selectNotEnter" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlAvanceAnterior = $('#mdlAvanceAnterior');

    $(document).ready(function () {
        setFocusSelectToInputOnChange('#DeptoAvance', '#DoctoAvance', mdlAvanceAnterior);
        mdlAvanceAnterior.on('shown.bs.modal', function () {
            handleEnterDiv(mdlAvanceAnterior);
            mdlAvanceAnterior.find("input").val("");
            $.each(mdlAvanceAnterior.find("select"), function (k, v) {
                mdlAvanceAnterior.find("select")[k].selectize.clear(true);
            });
            mdlAvanceAnterior.find("#FechaAvance").val(getToday()).focus().select();
            getDepartamentosAvanceAnterior();
        });
        mdlAvanceAnterior.find('#btnAceptar').click(function () {
            isValid('mdlAvanceAnterior');
            if (valido) {
                if (mdlAvanceAnterior.find('#ControlAvance').val()) {
                    var deptoAvance = parseInt(mdlAvanceAnterior.find('#DeptoAvance').val());
                    $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getControl', {
                        Control: mdlAvanceAnterior.find('#ControlAvance').val()
                    }).done(function (data) {
                        if (data.length > 0) { //Si el control existe primero se valida que no este fact o cancelado
                            if (data[0].Depto === '270' && data[0].Depto !== '') {
                                swal({
                                    title: "CONTROL CANCELADO POR EL CLIENTE",
                                    text: "****MOTIVO EXTEMPORANEO****",
                                    icon: "warning",
                                    closeOnClickOutside: false,
                                    closeOnEsc: false
                                }).then((action) => {
                                    if (action) {
                                        mdlAvanceAnterior.find('#ControlAvance').val('').focus();
                                    }
                                });
                            } else if (data[0].Depto === '260') {
                                swal({
                                    title: "CONTROL YA FACTURADO",
                                    text: "****El número de control ya ha sido facturado****",
                                    icon: "warning",
                                    closeOnClickOutside: false,
                                    closeOnEsc: false
                                }).then((action) => {
                                    if (action) {
                                        mdlAvanceAnterior.find('#ControlAvance').val('').focus();
                                    }
                                });
                            } else if (data[0].Depto === '240') {
                                swal({
                                    title: "CONTROL YA ESTÁ EN PRODUCTO TERMINADO",
                                    text: "****El número de control ya ha sido avanzado a prod. Terminado****",
                                    icon: "warning",
                                    closeOnClickOutside: false,
                                    closeOnEsc: false
                                }).then((action) => {
                                    if (action) {
                                        mdlAvanceAnterior.find('#ControlAvance').val('').focus();
                                    }
                                });
                            } else { //Si el control no está cancelado y existe nos traemos sus pares y su avance
                                var deptoActual = parseInt(data[0].Depto);
                                if (deptoAvance === 30 && deptoActual === 20) {
                                    agregarAvance(data, 'fec33', '33');
                                } else if (deptoAvance === 40 && deptoActual === 30) {
                                    agregarAvance(data, 'fec4', '4');
                                } else if (deptoAvance === 90 && deptoActual === 40) {
                                    agregarAvance(data, 'fec40', '40');
                                } else if (deptoAvance === 100 && deptoActual === 90) {
                                    agregarAvance(data, 'fec42', '42');
                                } else if (deptoAvance === 105 && deptoActual === 100) {
                                    agregarAvance(data, 'fec44', '44');
                                } else if (deptoAvance === 110 && deptoActual === 105) {
                                    agregarAvance(data, 'fec5', '5');
                                } else if (deptoAvance === 130 && deptoActual === 120) {
                                    agregarAvance(data, 'fec6', '6');
                                } else if (deptoAvance === 140 && deptoActual === 130) {
                                    agregarAvance(data, 'fec55', '55');
                                } else if (deptoAvance === 150 && deptoActual === 140) {
                                    agregarAvance(data, 'fec7', '7');
                                } else if (deptoAvance === 160 && deptoActual === 150) {
                                    agregarAvance(data, 'fec8', '8');
                                } else if (deptoAvance === 180 && deptoActual === 160) {
                                    agregarAvance(data, 'fec9', '9');
                                } else if (deptoAvance === 210 && deptoActual === 180) {
                                    agregarAvance(data, 'fec10', '10');
                                } else if (deptoAvance === 230 && deptoActual === 210) {
                                    agregarAvance(data, 'fec11', '11');
                                } else {
                                    mdlAvanceAnterior.find("#EstatusProduccionAvance").html('');
                                    mdlAvanceAnterior.find("#EstiloAvance").val("");
                                    mdlAvanceAnterior.find("#ColorAvance").val("");
                                    mdlAvanceAnterior.find("#ParesAvance").val("");
                                    swal({
                                        title: "ATENCIÓN",
                                        text: "EL CONTROL NO CONCUERDA CON EL AVANCE QUE DESEA CAPTURAR ",
                                        icon: "warning",
                                        closeOnClickOutside: false,
                                        closeOnEsc: false
                                    }).then((action) => {
                                        if (action) {
                                            mdlAvanceAnterior.find("#ControlAvance").val('').focus();
                                        }
                                    });
                                }

                            }
                        } else { //Si el control no existe
                            swal({
                                title: "ATENCIÓN",
                                text: "EL CONTROL NO EXISTE EN PRODUCCIÓN ",
                                icon: "warning",
                                closeOnClickOutside: false,
                                closeOnEsc: false
                            }).then((action) => {
                                if (action) {
                                    mdlAvanceAnterior.find("#ControlAvance").val('').focus();
                                }
                            });
                        }
                    });
                } else {//Valida que no esté en blanco el campo
                    swal({
                        title: "ATENCIÓN",
                        text: "DEBES DE CAPTURAR UN # DE CONTROL ",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        if (action) {
                            mdlAvanceAnterior.find('#ControlAvance').val('').focus();
                        }
                    });
                }
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });

        mdlAvanceAnterior.find('#btnImprimir').click(function () {
            var docto = mdlAvanceAnterior.find("#DoctoAvance").val();
            if (docto !== '') {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData();
                frm.append('Docto', docto);
                $.ajax({
                    url: base_url + 'index.php/CapturaFraccionesParaNomina/onImprimirReporteEntregaControlesMaquilas',
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
                            mdlAvanceAnterior.find("#DoctoAvance").focus();
                        });
                    }
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBE CAPTURAR EL DOCUMENTO A IMPRIMIR",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    if (action) {
                        mdlAvanceAnterior.find("#DoctoAvance").focus();
                    }
                });
            }

        });

        mdlAvanceAnterior.find('#ControlAvance').keydown(function (e) {
            if (e.keyCode === 13)
                if ($(this).val()) {
                    var deptoAvance = parseInt(mdlAvanceAnterior.find('#DeptoAvance').val());
                    $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getControl', {
                        Control: $(this).val()
                    }).done(function (data) {
                        if (data.length > 0) { //Si el control existe primero se valida que no este fact o cancelado
                            if (data[0].Depto === '270' && data[0].Depto !== '') {
                                swal({
                                    title: "CONTROL CANCELADO POR EL CLIENTE",
                                    text: "****MOTIVO EXTEMPORANEO****",
                                    icon: "warning",
                                    closeOnClickOutside: false,
                                    closeOnEsc: false
                                }).then((action) => {
                                    if (action) {
                                        mdlAvanceAnterior.find('#ControlAvance').val('').focus();
                                    }
                                });
                            } else if (data[0].Depto === '260') {
                                swal({
                                    title: "CONTROL YA FACTURADO",
                                    text: "****El número de control ya ha sido facturado****",
                                    icon: "warning",
                                    closeOnClickOutside: false,
                                    closeOnEsc: false
                                }).then((action) => {
                                    if (action) {
                                        mdlAvanceAnterior.find('#ControlAvance').val('').focus();
                                    }
                                });
                            } else if (data[0].Depto === '240') {
                                swal({
                                    title: "CONTROL YA ESTÁ EN PRODUCTO TERMINADO",
                                    text: "****El número de control ya ha sido avanzado a prod. Terminado****",
                                    icon: "warning",
                                    closeOnClickOutside: false,
                                    closeOnEsc: false
                                }).then((action) => {
                                    if (action) {
                                        mdlAvanceAnterior.find('#ControlAvance').val('').focus();
                                    }
                                });
                            } else { //Si el control no está cancelado y existe nos traemos sus pares y su avance
                                var deptoActual = parseInt(data[0].Depto);
                                if (deptoAvance === 30 && deptoActual === 20) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 40 && deptoActual === 30) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 90 && deptoActual === 40) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 100 && deptoActual === 90) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 105 && deptoActual === 100) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 110 && deptoActual === 105) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 130 && deptoActual === 120) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 140 && deptoActual === 130) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 150 && deptoActual === 140) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 160 && deptoActual === 150) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 180 && deptoActual === 160) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 210 && deptoActual === 180) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 230 && deptoActual === 210) {
                                    concuerdaAvance(data);
                                } else {
                                    mdlAvanceAnterior.find("#EstatusProduccionAvance").html('');
                                    mdlAvanceAnterior.find("#EstiloAvance").val("");
                                    mdlAvanceAnterior.find("#ColorAvance").val("");
                                    mdlAvanceAnterior.find("#ParesAvance").val("");
                                    swal({
                                        title: "ATENCIÓN",
                                        text: "EL CONTROL NO CONCUERDA CON EL AVANCE QUE DESEA CAPTURAR ",
                                        icon: "warning",
                                        closeOnClickOutside: false,
                                        closeOnEsc: false
                                    }).then((action) => {
                                        if (action) {
                                            mdlAvanceAnterior.find("#ControlAvance").val('').focus();
                                        }
                                    });
                                }

                            }
                        } else { //Si el control no existe
                            swal({
                                title: "ATENCIÓN",
                                text: "EL CONTROL NO EXISTE EN PRODUCCIÓN ",
                                icon: "warning",
                                closeOnClickOutside: false,
                                closeOnEsc: false
                            }).then((action) => {
                                if (action) {
                                    mdlAvanceAnterior.find("#ControlAvance").val('').focus();
                                }
                            });
                        }
                    });
                } else {//Valida que no esté en blanco el campo
                    swal({
                        title: "ATENCIÓN",
                        text: "DEBES DE CAPTURAR UN # DE CONTROL ",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        if (action) {
                            mdlAvanceAnterior.find('#ControlAvance').val('').focus();
                        }
                    });
                }
        });
    });

    function agregarAvance(data, campoavaprd, stsavaprd) {
//inserta nuevo
        var nombre_depto = mdlAvanceAnterior.find("#DeptoAvance option:selected").text().split('-').pop();
        var frm = new FormData(mdlAvanceAnterior.find("#frmCapturaAvaAnt")[0]);
        frm.append('Fecha', mdlAvanceAnterior.find("#FechaAvance").val());
        frm.append('DeptoClave', mdlAvanceAnterior.find("#DeptoAvance").val());
        frm.append('DeptoNombre', nombre_depto);
        frm.append('Docto', mdlAvanceAnterior.find("#DoctoAvance").val());
        frm.append('Control', mdlAvanceAnterior.find("#ControlAvance").val());
        frm.append('Estilo', data[0].Estilo);
        frm.append('Color', data[0].Color);
        frm.append('Pares', data[0].Pares);
        frm.append('Campo', campoavaprd);
        frm.append('stsavaprd', stsavaprd);
        $.ajax(base_url + 'index.php/CapturaFraccionesParaNomina/onAgregarAvanceAnt', {
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: frm
        }).done(function (data) {
            console.log(data);
            onNotifyOld('fa fa-check', 'AVANCE REALIZADO CORRECTAMENTE', 'success');
            mdlAvanceAnterior.find("#EstiloAvance").val("");
            mdlAvanceAnterior.find("#ColorAvance").val("");
            mdlAvanceAnterior.find("#ParesAvance").val("");
            mdlAvanceAnterior.find("#EstatusProduccionAvance").html('');
            mdlAvanceAnterior.find("#ControlAvance").val('').focus();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function concuerdaAvance(data) {
        mdlAvanceAnterior.find("#EstatusProduccionAvance").html(data[0].Depto + '  ' + data[0].DeptoT);
        mdlAvanceAnterior.find("#EstiloAvance").val(data[0].Estilo);
        mdlAvanceAnterior.find("#ColorAvance").val(data[0].Color);
        mdlAvanceAnterior.find("#ParesAvance").val(data[0].Pares);
        mdlAvanceAnterior.find("#btnAceptar").focus();
    }

    function getDepartamentosAvanceAnterior() {
        $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getDepartamentosAvanceAnterior', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlAvanceAnterior.find("#DeptoAvance")[0].selectize.addOption({text: v.Departamento, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }


</script>
<style>
    .text-strong {
        font-weight: bolder;
    }

    tr.group-start:hover td{
        background-color: #e0e0e0 !important;
        color: #000 !important;
    }
    tr.group-end td{
        background-color: #FFF !important;
        color: #000!important;
    }

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>