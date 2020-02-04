<div class="modal " id="mdlAvanceAnterior"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-arrow-up"></span> Avance por control</h5>
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
                            <label>Avance</label>
                            <select id="DeptoAvance" name="DeptoAvance" class="form-control form-control-sm required">
                                <option value="33">33-Rebajado</option>
                                <option value="4">4-Foleado</option>
                                <option value="40">40-Entretelado</option>
                                <option value="42">42-Proceso Maquila</option>
                                <option value="44">44-Alm Corte</option>
                                <option value="5">5-Pespunte</option>
                                <option value="55">55-Ensuelado</option>
                                <option value="6">6-Alm Pespunte</option>
                                <option value="7">7-Tejido</option>
                                <option value="8">8-Alm Tejido</option>
                                <option value="9">9-Montado</option>
                                <option value="10">10-Adorno</option>
                                <option value="11">11-Alm-Adorno</option>
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
                        <div class="w-100"></div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2"></div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <ul id="deptos" class="list-group my-2">
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold" >
                                    <span class="d-none stsavan" des="REBAJADO">33</span><span class="d-none" des="REBAJADO">30</span>33 - REBAJADO<span class="deptodes d-none">REBAJADO Y PERFORADO</span><span class="deptoclave d-none">30</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold" >
                                    <span class="d-none stsavan" des="FOLEADO">4</span><span class="d-none" des="FOLEADO">40</span>4 - FOLEADO<span class="deptodes d-none">FOLEADO</span><span class="deptoclave d-none">40</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold" >
                                    <span class="d-none stsavan" des="ENTRETELADO">40</span><span class="d-none" des="ENTRETELADO">90</span>40 - ENTRETELADO<span class="deptodes d-none">ENTRETELADO</span><span class="deptoclave d-none">90</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold"  >
                                    <span class="d-none stsavan" des="MAQUILA">42</span><span class="d-none" des="MAQUILA">100</span>42 - MAQUILA<span class="deptodes d-none">MAQUILA</span><span class="deptoclave d-none">100</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold" >
                                    <span class="d-none stsavan" des="ALMACEN CORTE">44</span> <span class="d-none" des="ALMACEN CORTE">105</span>44 - ALMACEN CORTE<span class="deptodes d-none">ALMACEN CORTE</span><span class="deptoclave d-none">105</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold" >
                                    <span class="d-none stsavan" des="PESPUNTE">5</span> <span class="d-none" des="PESPUNTE">110</span>5 - PESPUNTE<span class="deptodes d-none">PESPUNTE</span><span class="deptoclave d-none">110</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold" >
                                    <span class="d-none stsavan" des="ENSUELADO">55</span> <span class="d-none" des="ENSUELADO">140</span>55 - ENSUELADO<span class="deptodes d-none">ENSUELADO</span><span class="deptoclave d-none">140</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold" >
                                    <span class="d-none stsavan" des="ALMACEN PESPUNTE">6</span> <span class="d-none" des="ALMACEN PESPUNTE">130</span>6 - ALMACEN PESPUNTE<span class="deptodes d-none">ALMACEN PESPUNTE</span><span class="deptoclave d-none">130</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold" >
                                    <span class="d-none stsavan" des="TEJIDO">7</span><span class="d-none" des="TEJIDO">150</span>7 - TEJIDO<span class="deptodes d-none">TEJIDO</span><span class="deptoclave d-none">150</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold" >
                                    <span class="d-none stsavan" des="ALMACEN TEJIDO">8</span><span class="d-none" des="ALMACEN TEJIDO">160</span>8 - ALMACEN TEJIDO<span class="deptodes d-none">ALMACEN TEJIDO</span><span class="deptoclave d-none">160</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold" >
                                    <span class="d-none stsavan" des="MONTADO">9</span><span class="d-none" des="MONTADO ">180</span>9 - MONTADO "A"<span class="deptodes d-none">MONTADO "A"</span><span class="deptoclave d-none">180</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold" >
                                    <span class="d-none stsavan" des="ADORNO ">10</span>10 - ADORNO "A"<span class="deptodes d-none">ADORNO "A"</span><span class="deptoclave d-none">210</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold" >
                                    <span class="d-none stsavan" des="ALMACEN ADORNO">11</span>11 - ALMACEN ADORNO<span class="deptodes d-none">ALMACEN ADORNO</span><span class="deptoclave d-none">230</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary selectNotEnter" id="btnAceptar">
                    <span class="fa fa-check"></span> ACEPTAR</button>
                <button type="button" class="btn btn-info selectNotEnter" id="btnImprimir">
                    <span class="fa fa-print"></span> IMPRIMIR</button>
                <button type="button" class="btn btn-secondary selectNotEnter" id="btnSalir" data-dismiss="modal">
                    <span class="fa fa-times"></span> SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlAvanceAnterior = $('#mdlAvanceAnterior');

    $(document).ready(function () {
        setFocusSelectToInputOnChange('#DeptoAvance', '#DoctoAvance', mdlAvanceAnterior);

        var ul = $("#deptos");
        ul.find("li").click(function () {
            ul.find("li").removeClass('li-selected');
            var li = $(this);
            li.addClass('li-selected');
            console.log(li.find("span").first().text());
            mdlAvanceAnterior.find("#DeptoAvance")[0].selectize.setValue(parseInt(li.find("span").first().text()));
            mdlAvanceAnterior.find("#DoctoAvance").focus().select();
            onBeep(3);
            console.log(ul.find("li").index())
        });

        mdlAvanceAnterior.on('shown.bs.modal', function () {
            handleEnterDiv(mdlAvanceAnterior);
            mdlAvanceAnterior.find("input").val("");
            $.each(mdlAvanceAnterior.find("select"), function (k, v) {
                mdlAvanceAnterior.find("select")[k].selectize.clear(true);
            });
            mdlAvanceAnterior.find("#FechaAvance").val(getToday()).focus().select();

        });
        mdlAvanceAnterior.find('#btnAceptar').click(function () {
            isValid('mdlAvanceAnterior');
            if (valido) {
                if (mdlAvanceAnterior.find('#ControlAvance').val()) {
                    var deptoAvance = parseInt(mdlAvanceAnterior.find('#DeptoAvance').val());
                    $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getControlAvanAnterior', {
                        Control: mdlAvanceAnterior.find('#ControlAvance').val()
                    }).done(function (data) {
                        if (data.length > 0) { //Si el control existe primero se valida que no este fact o cancelado
                            if (data[0].stsavan === '14') {
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
                            } else if (data[0].stsavan === '13') {
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
                            } else if (data[0].Depto === '12') {
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
                                var deptoActual = parseInt(data[0].stsavan);//Obtenemos el avance actual
                                if (usuario === 'CHEOK') {//Si el usuario es cheo sólo puede dar avande a 7 o 8, estando en 6
                                    if (deptoAvance === 7 && deptoActual === 6) {
                                        agregarAvance(data, 'fec7', '150', 'TEJIDO');
                                    } else if (deptoAvance === 8 && deptoActual === 7) {
                                        agregarAvance(data, 'fec8', '160', 'ALMACEN TEJIDO');
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
                                } else {//Si es ali, puede dar todo
                                    if (deptoAvance === 33 && deptoActual === 3) {
                                        agregarAvance(data, 'fec33', '30', 'REBAJADO Y PERFORADO');
                                    } else if (deptoAvance === 4 && deptoActual === 33) {
                                        agregarAvance(data, 'fec40', '40', 'FOLEADO');
                                    } else if (deptoAvance === 40 && deptoActual === 4) {
                                        agregarAvance(data, 'fec40', '90', 'ENTRETELADO');
                                    } else if (deptoAvance === 42 && deptoActual === 40) {
                                        agregarAvance(data, 'fec42', '100', 'MAQUILA');
                                    } else if (deptoAvance === 44 && deptoActual === 42) {
                                        agregarAvance(data, 'fec44', '105', 'ALMACEN CORTE');
                                    } else if (deptoAvance === 5 && deptoActual === 44) {
                                        agregarAvance(data, 'fec5', '110', 'PESPUNTE');
                                    } else if (deptoAvance === 55 && deptoActual === 5) {
                                        agregarAvance(data, 'fec55', '140', 'ENSUELADO');
                                    } else if (deptoAvance === 6 && deptoActual === 55) {
                                        agregarAvance(data, 'fec6', '130', 'ALMACEN PESPUNTE');
                                    } else if (deptoAvance === 7 && deptoActual === 6) {
                                        agregarAvance(data, 'fec7', '150', 'TEJIDO');
                                    } else if (deptoAvance === 8 && deptoActual === 7) {
                                        agregarAvance(data, 'fec8', '160', 'ALMACEN TEJIDO');
                                    } else if (deptoAvance === 9 && deptoActual === 8) {
                                        agregarAvance(data, 'fec9', '180', 'MONTADO "A"');
                                    } else if (deptoAvance === 10 && deptoActual === 9) {
                                        agregarAvance(data, 'fec10', '210', 'ADORNO "A"');
                                    } else if (deptoAvance === 11 && deptoActual === 10) {
                                        agregarAvance(data, 'fec11', '230', 'ALMACEN ADORNO');
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
                    $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getControlAvanAnterior', {
                        Control: $(this).val()
                    }).done(function (data) {
                        if (data.length > 0) { //Si el control existe primero se valida que no este fact o cancelado
                            if (data[0].stsavan === '14') {
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
                            } else if (data[0].stsavan === '13') {
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
                            } else if (data[0].stsavan === '12') {
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
                                var deptoActual = parseInt(data[0].stsavan);
                                if (deptoAvance === 33 && deptoActual === 3) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 4 && deptoActual === 33) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 40 && deptoActual === 4) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 42 && deptoActual === 40) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 44 && deptoActual === 42) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 5 && deptoActual === 44) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 55 && deptoActual === 5) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 6 && deptoActual === 55) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 7 && deptoActual === 6) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 8 && deptoActual === 7) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 9 && deptoActual === 8) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 10 && deptoActual === 9) {
                                    concuerdaAvance(data);
                                } else if (deptoAvance === 11 && deptoActual === 10) {
                                    concuerdaAvance(data);
                                } else {
                                    mdlAvanceAnterior.find("#EstatusProduccionAvance").html('');
                                    mdlAvanceAnterior.find("#EstiloAvance").val("");
                                    mdlAvanceAnterior.find("#ColorAvance").val("");
                                    mdlAvanceAnterior.find("#ParesAvance").val("");
                                    swal({
                                        title: "ATENCIÓN",
                                        text: "El control está en ***" + data[0].EstatusProduccion + "*** y no concuerda con el avance requerido ",
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

    function agregarAvance(data, campoavaprd, depto, nomdepto) {
//inserta nuevo
        //var nombre_depto = mdlAvanceAnterior.find("#DeptoAvance option:selected").text().split('-').pop();
        var frm = new FormData(mdlAvanceAnterior.find("#frmCapturaAvaAnt")[0]);
        frm.append('Fecha', mdlAvanceAnterior.find("#FechaAvance").val());
        frm.append('DeptoClave', depto);
        frm.append('DeptoNombre', nomdepto);
        frm.append('Docto', mdlAvanceAnterior.find("#DoctoAvance").val());
        frm.append('Control', mdlAvanceAnterior.find("#ControlAvance").val());
        frm.append('Estilo', data[0].Estilo);
        frm.append('Color', data[0].Color);
        frm.append('Pares', data[0].Pares);
        frm.append('Campo', campoavaprd);
        frm.append('stsavaprd', mdlAvanceAnterior.find("#DeptoAvance").val());
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
        mdlAvanceAnterior.find("#EstatusProduccionAvance").html(data[0].stsavan);
        mdlAvanceAnterior.find("#EstiloAvance").val(data[0].Estilo);
        mdlAvanceAnterior.find("#ColorAvance").val(data[0].Color);
        mdlAvanceAnterior.find("#ParesAvance").val(data[0].Pares);
        mdlAvanceAnterior.find("#btnAceptar").focus();
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
    li.list-group-item:hover {
        font-weight: bold;
        color: #fff;
        cursor: pointer;
        background-color: #3f51b5;
        -webkit-box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        -moz-box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        padding-top: 3px;
        padding-bottom: 3px;
        animation: myfirst .4s;
        -moz-animation:myfirst 1.4s infinite; /* Firefox */
        -webkit-animation:myfirst 1.4s infinite; /* Safari and Chrome */
        border-radius: 5px;
    }
    .li-selected{
        font-weight: bold;
        color: #fff;
        cursor: pointer;
        background-color: #3f51b5;
        -webkit-box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        -moz-box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        padding-top: 3px;
        padding-bottom: 3px;
        animation: myfirst .4s;
        -moz-animation:myfirst 1.4s infinite; /* Firefox */
        -webkit-animation:myfirst 1.4s infinite; /* Safari and Chrome */
        border-radius: 5px;
    }
</style>