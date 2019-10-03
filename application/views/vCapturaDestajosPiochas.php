<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4 col-md-4 float-left">
                <legend class="float-left">Captura fracciones para nómina (PIOCHAS)</legend>
            </div>

        </div>
    </div>
    <hr>
    <div class="card-body" style="padding-top: 0px; padding-bottom: 10px;">
        <form id="frmCapturaDestajo">
            <div class="row">
                <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                    <label for="" >Empleado</label>
                    <select id="Empleado" name="Empleado" class="form-control form-control-sm required" >
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
                <div class="col-6 col-xs-6 col-sm-2 col-lg-2 col-xl-2">
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

                <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                    <label for="" >Fracción</label>
                    <select id="Fraccion" name="Fraccion" class="form-control form-control-sm required">
                        <option value=""></option>
                    </select>
                </div>

                <div class="col-6 col-xs-6 col-sm-3 col-lg-2 col-xl-1">
                    <label>Precio</label>
                    <input type="text" id="Precio" name="Precio" maxlength="7" readonly="" class="form-control form-control-sm numbersOnly">
                </div>
                <div class="col-6 col-xs-6 col-sm-3 col-lg-2 col-xl-1">
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
                <button type="button" id="btnAceptar" class="btn btn-primary btn-sm selectNotEnter">
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
    var master_url = base_url + 'index.php/CapturaFraccionesParaNominaPiochas/';
    var pnlTablero = $("#pnlTablero div.card-body");
    var Maq = pnlTablero.find("#Maq"), Control = pnlTablero.find("#Control"),
            FraccionesNomina, tblFraccionesNomina = pnlTablero.find("#tblFraccionesNomina"),
            btnAceptar = pnlTablero.find("#btnAceptar"), btnImprimir = pnlTablero.find("#btnImprimir");

    var nuevo = true;
    var pCelula = 0, DeptoEmp = 0, ParesPed = 0;


    $(document).ready(function () {
        //validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToInputOnChange('#Empleado', '#Ano', pnlTablero);
        setFocusSelectToInputOnChange('#Fraccion', '#btnAceptar', pnlTablero);
        init();
        handleEnter();
        pnlTablero.find("#Ano").change(function () {
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
                getRecords($(this).val(), pnlTablero.find("#Sem").val());
            }
        });
        pnlTablero.find("#Sem").keydown(function (e) {
            if (e.keyCode === 13) {
                var ano = pnlTablero.find("#Ano");
                onComprobarSemanasNomina($(this), ano.val());
            }
        });
        pnlTablero.find("#Empleado").change(function () {
            if ($(this).val()) {
                getDepartamentoByEmpleado($(this).val());
                pnlTablero.find("#Fraccion")[0].selectize.clear(true);
                FraccionesNomina.column(1).search('^' + $(this).val() + '$', true, false).draw();
            }
        });
        pnlTablero.find("#Fraccion").change(function () {
            var Fraccion = pnlTablero.find("#Fraccion").val();
            var Control = pnlTablero.find("#Control").val();
            var Empleado = pnlTablero.find("#Empleado").val();
            if (Empleado !== '') {
                var estilo = pnlTablero.find("#Estilo").val();
                getPrecioFraccion(pnlTablero.find("#Fraccion").val(), estilo);
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE SELECCIONAR UN EMPLEADO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    if (action) {
                        pnlTablero.find("#Empleado")[0].selectize.clear(true);
                        pnlTablero.find("#Empleado")[0].selectize.focus();
                    }
                });
            }
        });
        pnlTablero.find("#Fecha").change(function () {
            getSemanaByFecha($(this).val());
        });
        Control.change(function () {
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
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE CAPTURAR UN # DE CONTROL ",
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
        pnlTablero.find("#Pares").keydown(function (e) {
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
                    pnlTablero.find("#Fraccion")[0].selectize.focus();
                }
            }
        });
        btnAceptar.click(function () {
            var sem = pnlTablero.find("#Sem");
            var ano = pnlTablero.find("#Ano").val();
            isValid('pnlTablero');
            if (valido) {
                //Valida que no esté cerrada la semana en nomina
                $.getJSON(master_url + 'onVerificarSemanaNominaCerrada', {Sem: sem.val(), Ano: ano}).done(function (data) {
                    if (data.length > 0) {//Si existe en prenomina validamos que sólo esté en estatus 1
                        if (parseInt(data[0].status) === 2) {
                            swal({
                                title: "ATENCIÓN",
                                text: "LA NÓMINA DE LA SEMANA " + sem.val() + " DEL " + ano + " " + "ESTÁ CERRADA",
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
                                        sem.val('');
                                        sem.focus();
                                        break;
                                }
                            });
                        } else {//Sí está pero esta en estatus 1
                            onAgregar();
                        }
                    } else {//Aún no existe la nomina, podemos continuar
                        onAgregar();
                    }
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });
        btnImprimir.click(function () {
            var ano = pnlTablero.find("#Ano").val();
            var sem = pnlTablero.find("#Sem").val();
            var emp = pnlTablero.find("#Empleado").val();
            var reporte = '';

            if (ano !== '' && sem !== '') {
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
                            pnlTablero.find("#Empleado")[0].selectize.clear(true);
                            pnlTablero.find("#Empleado")[0].selectize.focus();
                        }
                    });
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

    function onComprobarSemanasNomina(v, ano) {
        //Valida que esté creada la semana en nominas
        $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
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
                            getRecords(pnlTablero.find("#Ano").val(), pnlTablero.find("#Sem").val());
                        }
                    } else {//Aún no existe la nomina, podemos continuar
                        getRecords(pnlTablero.find("#Ano").val(), pnlTablero.find("#Sem").val());
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

    function onAgregar() {
        //inserta nuevo

        var frm = new FormData(pnlTablero.find("#frmCapturaDestajo")[0]);
        frm.append('DeptoEmp', DeptoEmp);

        $.ajax(master_url + 'onAgregar', {
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: frm
        }).done(function (data) {
            console.log(data);
            FraccionesNomina.ajax.reload();
            pCelula = 0;
            DeptoEmp = 0;
            ParesPed = 0;
            pnlTablero.find("#Estilo").val("");
            pnlTablero.find("#Color").val("");
            pnlTablero.find("#Pares").val("");
            pnlTablero.find("#Precio").val("");
            pnlTablero.find("#Subtotal").val("");
            pnlTablero.find("#Fraccion")[0].selectize.clear(true);
            pnlTablero.find("#EstatusProduccion").html('');
            pnlTablero.find("#Control").val('').focus();

        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });

    }

    function getRecords(ano, sem) {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
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
                "data": {Ano: ano, Sem: sem},
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
        nuevo = true;
        pCelula = 0;
        DeptoEmp = 0;
        ParesPed = 0;
        getEmpleados();

        pnlTablero.find("#Fecha").val(getToday());
        getSemanaByFecha(pnlTablero.find("#Fecha").val());
        pnlTablero.find("#Ano").val(new Date().getFullYear());

        pnlTablero.find("#Empleado")[0].selectize.focus();
    }

    function getEmpleados() {
        pnlTablero.find("#Empleado")[0].selectize.clear(true);
        pnlTablero.find("#Empleado")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getEmpleados').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Empleado")[0].selectize.addOption({text: v.Empleado, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getFraccionesByEstilo(Estilo) {
        pnlTablero.find("#Fraccion")[0].selectize.clear(true);
        pnlTablero.find("#Fraccion")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getFraccionesByEstilo', {Estilo: Estilo}).done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Fraccion")[0].selectize.addOption({text: v.Fraccion, value: v.Clave});
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
                    pnlTablero.find("#Subtotal").val((pCelula * data[0].Precio) * pnlTablero.find("#Pares").val());
                } else {
                    pnlTablero.find("#Subtotal").val(data[0].Precio * pnlTablero.find("#Pares").val());
                }
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
                        pnlTablero.find("#Fraccion")[0].selectize.clear(true);
                        pnlTablero.find("#Fraccion")[0].selectize.focus();
                    }
                });
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getSemanaByFecha(fecha) {
        $.getJSON(master_url + 'getSemanaByFecha', {Fecha: fecha}).done(function (data) {
            if (data.length > 0) {
                pnlTablero.find("#Sem").val(data[0].sem);
                $('#mdlRastreoControlNomina').find("#SemRastreo").val(data[0].sem);
                sem_ini = data[0].sem;
                getRecords(new Date().getFullYear(), data[0].sem);
            } else {
                swal('ERROR', 'NO EXISTE SEMANA', 'info');
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
