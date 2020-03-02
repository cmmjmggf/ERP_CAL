<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4 col-md-4 float-left">
                <legend class="float-left">Captura fracciones para nómina</legend>
            </div>
            <div class="col-12 col-sm-8 col-md-8 animated bounceInLeft" align="right" id="Acciones">
                <button type="button" class="btn btn-primary btn-sm " id="btnVerFracciones" >
                    <span class="fa fa-search" ></span> FRACCIONES
                </button>
                <button type="button" class="btn btn-secondary btn-sm " id="btnVerAvance" >
                    <span class="fa fa-check-double" ></span> AVANCE
                </button>
                <button type="button" class="btn btn-warning btn-sm" id="btnAvanceAnt" >
                    <span class="fa fa-check-double" ></span> AVANCE ANT.
                </button>
                <button type="button" class="btn btn-info btn-sm " id="btnRastreoControl" >
                    <span class="fa fa-cube" ></span> RAST/ CONTROL
                </button>
                <button type="button" class="btn btn-info btn-sm " id="btnRastreoConcepto" >
                    <span class="fa fa-cube" ></span> RAST/ CONCEPTO
                </button>
                <button type="button" class="btn btn-success btn-sm" id="btnCapturaComida" >
                    <span class="fa fa-dollar-sign" ></span> VALES/COMIDA
                </button>
                <button type="button" class="btn btn-danger btn-sm" id="btnCapturaDestajosPiochas" >
                    <span class="fa fa-ban" ></span> DESTAJOS PIOCHAS
                </button>

            </div>
        </div>
        <hr>
        <form id="frmCapturaDestajo">
            <div class="row">
                <div class="col-12 col-sm-1 col-md-2 col-lg-1 col-xl-1" >
                    <label for="" >Empleado</label>
                    <input type="text" class="form-control form-control-sm numbersOnly" maxlength="4" required=""  id="Empleado" name="Empleado"   >
                </div>
                <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                    <label for="" >-</label>
                    <select id="sEmpleado" name="sEmpleado" class="form-control form-control-sm required NotSelectize" >
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                    <label>Año</label>
                    <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" required="">
                </div>
                <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                    <label>Sem.</label>
                    <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" required="">
                </div>
                <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                    <label for="" >Fecha</label>
                    <input type="text" class="form-control form-control-sm date notEnter" id="Fecha" name="Fecha" required="">
                </div>

            </div>
            <div class="row">
                <div class="col-6 col-xs-6 col-sm-2 col-lg-2 col-xl-2">
                    <label>Control  <span class="badge badge-danger" style="font-size: 14px;" id="EstatusProduccion"></span></label>
                    <input type="text" id="Control" name="Control" maxlength="10" class="form-control form-control-sm numeric" required="">
                </div>
                <div class="col-6 col-xs-6 col-sm-2 col-lg-1 col-xl-1">
                    <label>Estilo</label>
                    <input type="text" id="Estilo" name="Estilo"readonly="" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-xs-6 col-sm-1 col-lg-1 col-xl-1">
                    <label>Color</label>
                    <input type="text" id="Color" name="Color"readonly="" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-xs-12 col-sm-1 col-lg-1 col-xl-1">
                    <label>Pares</label>
                    <input type="text" id="Pares" maxlength="4" name="Pares" class="form-control form-control-sm numeric required" required="">
                </div>

                <div class="col-12 col-sm-1 col-md-2 col-lg-1 col-xl-1" >
                    <label for="" >Fracción</label>
                    <input type="text" class="form-control form-control-sm numbersOnly" maxlength="4" required=""  id="Fraccion" name="Fraccion"   >
                </div>
                <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-2" >
                    <label for="" >-</label>
                    <select id="sFraccion" name="sFraccion" class="form-control form-control-sm required NotSelectize">
                        <option value=""></option>
                    </select>
                </div>

                <div class="col-6 col-xs-6 col-sm-2 col-lg-1 col-xl-1">
                    <label>Precio</label>
                    <input type="text" id="Precio" name="Precio" maxlength="7" readonly="" class="form-control form-control-sm numbersOnly">
                </div>
                <div class="col-6 col-xs-6 col-sm-2 col-lg-1 col-xl-1">
                    <label>Subtotal</label>
                    <input type="text" id="Subtotal" name="Subtotal" readonly="" class="form-control form-control-sm numbersOnly">
                </div>

            </div>
        </form>
        <div class="w-100 my-2"></div>
        <div class="row">

            <div class="col-12 col-sm-12 col-md-9">
                <legend >Fracciones capturadas por empleado</legend>
                <table id="tblFraccionesNomina" class="table table-sm display" style="width:  100%;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Empleado</th>
                            <th scope="col">Sem</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Control</th>
                            <th scope="col">Estilo</th>
                            <th scope="col">Fracción</th>
                            <th scope="col">Pares</th>
                            <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="col-12 col-sm-12 col-md-3">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input selectNotEnter" id="cImprimeSemCompletaDest" >
                    <label class="custom-control-label text-info labelCheck" for="cImprimeSemCompletaDest">Imprime toda la semana</label>
                </div>
                <button type="button" id="btnAceptar" disabled="" class="btn btn-primary btn-sm selectNotEnter">
                    <span class="fa fa-check"></span> ACEPTAR
                </button>
                <button type="button" class="btn btn-success btn-sm selectNotEnter" id="btnImprimir">
                    <i class="fa fa-print"></i> IMPRIMIR
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/CapturaFraccionesParaNomina/';
    var pnlTablero = $("#pnlTablero div.card-body");
    var Maq = pnlTablero.find("#Maq"), Control = pnlTablero.find("#Control"),
            FraccionesNomina, tblFraccionesNomina = pnlTablero.find("#tblFraccionesNomina"),
            btnAceptar = pnlTablero.find("#btnAceptar"), btnImprimir = pnlTablero.find("#btnImprimir");
    var btnVerFracciones = pnlTablero.find('#btnVerFracciones');
    var btnVerAvance = pnlTablero.find('#btnVerAvance');

    var btnAvanceAnt = pnlTablero.find('#btnAvanceAnt');
    var btnRastreoControl = pnlTablero.find('#btnRastreoControl');
    var btnRastreoConcepto = pnlTablero.find('#btnRastreoConcepto');
    var btnCapturaComida = pnlTablero.find('#btnCapturaComida');
    var btnCapturaDestajosPiochas = pnlTablero.find('#btnCapturaDestajosPiochas');

    var nuevo = true;
    var pCelula = 0, DeptoEmp = 0, ParesPed = 0;


    $(document).ready(function () {
        setFocusSelectToInputOnChange('#sEmpleado', '#Ano', pnlTablero);
        setFocusSelectToInputOnChange('#sFraccion', '#btnAceptar', pnlTablero);
        init();
        pnlTablero.find("#Ano").keypress(function (e) {
            if (e.keyCode === 13) {
                var empleado = pnlTablero.find('#Empleado').val();
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
                        pnlTablero.find("#Ano").val("");
                        pnlTablero.find("#Ano").focus();
                    });
                } else {
                    getRecords($(this).val(), pnlTablero.find("#Sem").val(), empleado);
                    pnlTablero.find("#Sem").focus().select();
                }
            }
        });
        pnlTablero.find("#Sem").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var ano = pnlTablero.find("#Ano");
                    onComprobarSemanasNominaNormal($(this), ano.val());
                }
            }
        });
        pnlTablero.find('#Empleado').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtempl = $(this).val();
                if (txtempl) {

                    $.getJSON(master_url + 'onVerificarEmpleado', {Empleado: txtempl}).done(function (data) {
                        if (data.length > 0) {
                            pCelula = data[0].pcecula;
                            getDepartamentoByEmpleado(txtempl);
                            pnlTablero.find("#sFraccion")[0].selectize.clear(true);
                            pnlTablero.find("#Fraccion").val('');
                            pnlTablero.find("#sEmpleado")[0].selectize.addItem(txtempl, true);
                            pnlTablero.find('#Ano').focus().select();

                        } else {
                            swal('ERROR', 'EMPLEADO INEXISTENTE, DADO DE BAJA O NO ES DESTAJISTA', 'warning').then((value) => {
                                pnlTablero.find('#sEmpleado')[0].selectize.clear(true);
                                pnlTablero.find('#Empleado').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sEmpleado").change(function () {
            if ($(this).val()) {
                pnlTablero.find('#Empleado').val($(this).val());
                getDepartamentoByEmpleado($(this).val());
                pnlTablero.find("#Fraccion")[0].selectize.clear(true);
                pnlTablero.find("#Fraccion").val('');
                //FraccionesNomina.column(1).search('^' + $(this).val() + '$', true, false).draw();
                pnlTablero.find('#Ano').focus().select();
            }
        });
        pnlTablero.find("#Fecha").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    getSemanaByFecha($(this).val());
                    Control.focus().select();
                }
            }
        });
        pnlTablero.find('#Fraccion').keypress(function (e) {
            var pares = pnlTablero.find("#Pares").val();
            if (e.keyCode === 13) {
                var txtfrac = $(this).val();
                var estilo = pnlTablero.find("#Estilo").val();
                if (txtfrac) {
                    $.getJSON(master_url + 'onVerificarFraccion', {
                        Fraccion: txtfrac,
                        Estilo: estilo,
                        PorCel: pCelula,
                        Pares: pares,
                        Control: Control.val()
                    }).done(function (data) {
                        pnlTablero.find("#sFraccion")[0].selectize.addItem(txtfrac, true);
                        if (data === 1) {
                            swal('ERROR', 'LA FRACCIÓN NO EXISTE EN ESTE ESTILO', 'warning').then((value) => {
                                pnlTablero.find('#sFraccion')[0].selectize.clear(true);
                                pnlTablero.find('#Fraccion').focus().val('');
                                return;
                            });
                        } else if (data === 2) {
                            swal('ERROR', 'LA FRACCIÓN NO TIENE PRECIO', 'warning').then((value) => {
                                pnlTablero.find("#sFraccion")[0].selectize.clear(true);
                                pnlTablero.find("#Fraccion").val('').focus();
                                return;
                            });
                        } else if (data === 3) {
                            swal('ERROR', 'ESTE CONTROL YA FUE REPORTADO', 'warning').then((value) => {
                                pnlTablero.find("#sFraccion")[0].selectize.clear(true);
                                pnlTablero.find("#Fraccion").val('').focus();
                                return;
                            });
                        } else if (data === 4) {
                            swal('ERROR', 'ESTE CONTROL YA FUE COBRADO EN MAQUILAS', 'warning').then((value) => {
                                pnlTablero.find("#sFraccion")[0].selectize.clear(true);
                                pnlTablero.find("#Fraccion").val('').focus();
                                return;
                            });
                        } else {
                            var precio = JSON.parse(data['precio']);
                            pnlTablero.find("#Precio").val(parseFloat(precio).toFixed(2));
                            var subtot = JSON.parse(data['subtot']);
                            pnlTablero.find("#Subtotal").val(parseFloat(subtot).toFixed(2));
                            btnAceptar.prop('disabled', false);
                            btnAceptar.focus();
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sFraccion").change(function () {
            if ($(this).val()) {
                var Empleado = pnlTablero.find("#Empleado").val();
                if (Empleado !== '') {
                    pnlTablero.find('#Fraccion').val($(this).val());
                    var estilo = pnlTablero.find("#Estilo").val();
                    getPrecioFraccion(pnlTablero.find("#sFraccion").val(), estilo);
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "DEBES DE SELECCIONAR UN EMPLEADO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        if (action) {
                            pnlTablero.find("#Empleado").focus().select();
                        }
                    });
                }
            }
        });
        Control.keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    $.getJSON(master_url + 'getControl', {
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
                                        Control.val('').focus();
                                    }
                                });
                            } else { //Si el control no está cancelado y existe nos traemos sus pares y su avance
                                ParesPed = data[0].Pares;
                                pnlTablero.find("#EstatusProduccion").html(data[0].Depto + '  ' + data[0].DeptoT);
                                pnlTablero.find("#Estilo").val(data[0].Estilo);
                                pnlTablero.find("#Color").val(data[0].Color);
                                pnlTablero.find("#Pares").val(data[0].Pares).focus().select();
                                getFraccionesByEstilo(data[0].Estilo);
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
                                    Control.val('').focus();
                                }
                            });
                        }
                    });
                } else {//Valida que no esté en blanco el campo
                    Control.val('').focus();
//                    swal({
//                        title: "ATENCIÓN",
//                        text: "DEBES DE CAPTURAR UN # DE CONTROL ",
//                        icon: "warning",
//                        closeOnClickOutside: false,
//                        closeOnEsc: false
//                    }).then((action) => {
//                        if (action) {
//                            Control.val('').focus();
//                        }
//                    });
                }
            }
        });
        pnlTablero.find("#Pares").keypress(function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val()) > parseInt(ParesPed)) {

                    swal({
                        title: "ATENCIÓN",
                        text: "LA CANTIDAD DE PARES ES MAYOR A LOS PARES DEL PEDIDO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        if (action) {
                            pnlTablero.find("#Pares").val(ParesPed).focus();
                        }
                    });
                } else {
                    pnlTablero.find("#Fraccion").focus().select();
                }
            }
        });

        var handler = function (e) {
            if (Control.val()) {
                btnAceptar.off("click");
                e.preventDefault();
                btnAceptar.prop('disabled', true);
                isValid('pnlTablero');
                if (valido) {
                    //inserta nuevo
                    var sem = pnlTablero.find("#Sem").val();
                    var ano = pnlTablero.find("#Ano").val();
                    var frm = new FormData(pnlTablero.find("#frmCapturaDestajo")[0]);
                    frm.append('DeptoEmp', DeptoEmp);
                    frm.append('Sem', sem);
                    frm.append('Ano', ano);

                    $.ajax(master_url + 'onAgregar', {
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data) {
                        console.log(data);
                        btnAceptar.on('click', handler);
                        if (data === '1') {
                            swal({
                                title: "ATENCIÓN",
                                text: "El EMPLEADO//FRACCIÓN//CONTROL YA HA SIDO CAPTURADO",
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
                                        pnlTablero.find('#sFraccion')[0].selectize.clear(true);
                                        pnlTablero.find('#Fraccion').focus().val('');
                                        break;
                                }
                            });
                            return;
                        }
                        if (data === '2') {
                            swal({
                                title: "ATENCIÓN",
                                text: "LA NÓMINA DE LA SEMANA " + sem + " DEL " + ano + " " + "ESTÁ CERRADA",
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
                                        pnlTablero.find("#Sem").val('');
                                        pnlTablero.find("#Sem").focus();
                                        break;
                                }
                            });
                            return;
                        } else {//Sí está pero esta en estatus 1
                            FraccionesNomina.ajax.reload();
                            pCelula = 0;
                            DeptoEmp = 0;
                            ParesPed = 0;
                            pnlTablero.find("#Estilo").val("");
                            pnlTablero.find("#Color").val("");
                            pnlTablero.find("#Pares").val("");
                            pnlTablero.find("#Precio").val("");
                            pnlTablero.find("#Subtotal").val("");
                            //pnlTablero.find("#sFraccion")[0].selectize.clear(true);
                            //pnlTablero.find("#Fraccion").val('');
                            pnlTablero.find("#EstatusProduccion").html('');
                            pnlTablero.find("#Control").val('').focus();
                        }

                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                        btnAceptar.prop('disabled', false);
                    });

                } else {
                    btnAceptar.prop('disabled', false);
                    swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
                }
            } else {
                Control.focus();
                return;
            }
        };

        btnAceptar.on('click', handler);

        btnImprimir.click(function () {
            var ano = pnlTablero.find("#Ano").val();
            var sem = pnlTablero.find("#Sem").val();
            var emp = pnlTablero.find("#Empleado").val();
            var reporte = '';

            if (ano !== '' && sem !== '') {
                if (pnlTablero.find("#cImprimeSemCompletaDest")[0].checked) {//Imprime sem completa
                    reporte = 'destajoNominaGeneral';
                    onImprimirReportes(reporte, ano, sem, emp);
                } else {
                    if (emp) {
                        reporte = 'destajoNominaEmpleado';
                        onImprimirReportes(reporte, ano, sem, emp);
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "DEBE CAPTURAR EL EMPLEADO",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            if (action) {
                                pnlTablero.find("#Empleado").focus();
                            }
                        });
                    }
                }
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBE CAPTURAR EL AÑO Y LA SEMANA",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    if (action) {
                        pnlTablero.find("#Ano").focus();
                    }
                });
            }

        });
        btnAvanceAnt.click(function () {
            $('#mdlAvanceAnterior').modal('show');
        });
        btnCapturaDestajosPiochas.click(function () {
            $.fancybox.open({
                src: base_url + '/CapturaFraccionesParaNominaPiochas',
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
                            width: "95%",
                            height: "95%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });
        btnVerFracciones.click(function () {
            if (seg === 0) {
                swal('ATENCIÓN', 'USUARIO NO AUTORIZADO PARA VER ESTE MÓDULO', 'error');
            } else {
                $.fancybox.open({
                    src: base_url + '/FraccionesXEstilo/?origen=PRODUCCION',
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
                                width: "95%",
                                height: "95%"
                            },
                            // Iframe tag attributes
                            attr: {
                                scrolling: "auto"
                            }
                        }
                    }
                });
            }

        });
        btnVerAvance.click(function () {
            $.fancybox.open({
                src: base_url + '/Avance.shoes/?origen=PRODUCCION',
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
        });
        btnRastreoControl.click(function () {
            $('#mdlRastreoControlNomina').modal('show');
        });
        btnRastreoConcepto.click(function () {
            $('#mdlRastreoConceptoNomina').modal('show');
        });
        btnCapturaComida.click(function () {
            $('#mdlCapturaComidaEmpleados').modal('show');
        });
    });

    function onImprimirReportes(nombre, ano, sem, empleado) {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});

        var frm = new FormData();
        frm.append('Ano', ano);
        frm.append('Sem', sem);
        frm.append('Emp', empleado);
        frm.append('Reporte', nombre);


        $.ajax({
            url: master_url + 'onImprimirReporteDestajos',
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
                    pnlTablero.find('#btnImprimir').focus();
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }

    function onComprobarSemanasNominaNormal(v, ano) {
        //Valida que esté creada la semana en nominas
        $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
                var empleado = pnlTablero.find('#Empleado').val();
                //Valida que no esté cerrada la semana en nomina
                $.getJSON(master_url + 'onVerificarSemanaNominaCerrada', {Sem: $(v).val(), Ano: ano}).done(function (data) {
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
                            getRecords(pnlTablero.find("#Ano").val(), pnlTablero.find("#Sem").val(), empleado);
                            pnlTablero.find("#Fecha").focus();
                        }
                    } else {//Aún no existe la nomina, podemos continuar
                        getRecords(pnlTablero.find("#Ano").val(), pnlTablero.find("#Sem").val(), empleado);
                        pnlTablero.find("#Fecha").focus();
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

    function getDepartamentoByEmpleado(Empleado) {
        $.getJSON(master_url + 'getDepartamentoByEmpleado', {Empleado: Empleado}).done(function (data) {
            if (data.length > 0) {
                pCelula = data[0].CelulaPorcentaje;
                DeptoEmp = data[0].Depto;
            } else {
                swal('ERROR', 'EMPLEADO INCORRECTO', 'info');
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getRecords(ano, sem, empleado) {
        //HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblFraccionesNomina')) {
            tblFraccionesNomina.DataTable().destroy();
        }
        FraccionesNomina = tblFraccionesNomina.DataTable({
            "dom": 'frtp',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataType": "json",
                "type": 'GET',
                "data": {Ano: ano, Sem: sem, Empleado: empleado},
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"},
                {"data": "numeroempleado"},
                {"data": "semana"},
                {"data": "fecha"},
                {"data": "control"},
                {"data": "estilo"},
                {"data": "numfrac"},
                {"data": "pares"},
                {"data": "Eliminar"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*UNIDAD*/
                            c.addClass('text-info text-strong');
                            break;
                        case 3:
                            /*CONSUMO*/
                            c.addClass('text-success text-strong');
                            break;
                        case 5:
                            /*PZXPAR*/
                            c.addClass('text-strong ');
                            break;
                        case 7:
                            /*ELIMINAR*/
                            c.addClass('text-strong text-danger');
                            break;
                    }
                });
            },
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 200,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "scrollX": true,
            scrollY: 260,
            keys: false,
            "bSort": true,
            "aaSorting": [
                [0, 'desc']/*ID*/
            ],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        $('#tblFraccionesNomina_filter input[type=search]').addClass('selectNotEnter');
        tblFraccionesNomina.find('tbody').on('click', 'tr', function () {
            nuevo = false;
            tblFraccionesNomina.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }

    function init() {
        pnlTablero.find("select").selectize({
            hideSelected: false,
            openOnFocus: false
        });
        nuevo = true;
        pCelula = 0;
        DeptoEmp = 0;
        ParesPed = 0;
        getEmpleados();

        pnlTablero.find("#Fecha").val(getToday());
        getSemanaByFecha(pnlTablero.find("#Fecha").val());
        pnlTablero.find("#Ano").val(new Date().getFullYear());
        pnlTablero.find("#Empleado").focus();
    }

    function getEmpleados() {
        pnlTablero.find("#sEmpleado")[0].selectize.clear(true);
        pnlTablero.find("#sEmpleado")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getEmpleados').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sEmpleado")[0].selectize.addOption({text: v.Empleado, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getFraccionesByEstilo(Estilo) {
        pnlTablero.find("#sFraccion")[0].selectize.clear(true);
        pnlTablero.find("#sFraccion")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getFraccionesByEstilo', {Estilo: Estilo}).done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sFraccion")[0].selectize.addOption({text: v.Fraccion, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getPrecioFraccion(Fraccion, Estilo) {
        $.getJSON(master_url + 'getPrecioFraccion', {Fraccion: Fraccion, Estilo: Estilo}).done(function (data) {
            if (data.length > 0) {
                pnlTablero.find("#Precio").val(data[0].Precio);
                if (parseFloat(pCelula) > 0) {
                    var subtot = (pCelula * data[0].Precio) * pnlTablero.find("#Pares").val();
                    pnlTablero.find("#Subtotal").val(parseFloat(subtot).toFixed(2));
                } else {
                    var subtot = data[0].Precio * pnlTablero.find("#Pares").val();
                    pnlTablero.find("#Subtotal").val(parseFloat(subtot).toFixed(2));
                }
                btnAceptar.prop('disabled', false);
                btnAceptar.focus();
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "FRACCIÓN NO TIENE PRECIO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    if (action) {
                        pnlTablero.find("#sFraccion")[0].selectize.clear(true);
                        pnlTablero.find("#Fraccion").val('').focus();
                    }
                });
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getSemanaByFecha(fecha) {
        var empleado = pnlTablero.find("#Empleado").val();
        $.getJSON(master_url + 'getSemanaByFecha', {Fecha: fecha}).done(function (data) {
            if (data.length > 0) {
                pnlTablero.find("#Sem").val(data[0].sem);
                $('#mdlRastreoControlNomina').find("#SemRastreo").val(data[0].sem);
                sem_ini = data[0].sem;
                getRecords(new Date().getFullYear(), data[0].sem, empleado);
            } else {
                swal('ERROR', 'NO EXISTE SEMANA', 'info').then((action) => {
                    pnlTablero.find("#Fecha").focus().val('');
                });
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onEliminarDetalleByID(numemp, control, numfrac) {
        swal({
            buttons: ["Cancelar", "Aceptar"],
            title: 'Estas Seguro?',
            text: "Deseas dar de baja este movimiento: \n\nEmpleado: " + numemp + " \n Control: " + control + " \n Fracción: " + numfrac,
            icon: "warning",
            closeOnEsc: false,
            closeOnClickOutside: false
        }).then((action) => {
            if (action) {
                $.ajax({
                    url: master_url + 'onEliminarDetalleByID',
                    type: "POST",
                    data: {
                        Control: control,
                        Empleado: numemp,
                        Fraccion: numfrac
                    }
                }).done(function (data, x, jq) {
                    FraccionesNomina.ajax.reload();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                HoldOn.close();
            }
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
<?php
$this->load->view('vRastreoConceptoNomina');
$this->load->view('vAvanceAnterior');
