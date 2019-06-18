<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8 col-md-8 float-left">
                <legend class="float-left">Captura Conceptos Variables de Nómina a Empleados</legend>
            </div>
            <div class="col-12 col-sm-4 col-md-4 animated bounceInLeft" align="right" id="Acciones">
                <button type="button" class="btn btn-success btn-sm " id="btnVerConceptos" >
                    <span class="fa fa-cubes" ></span> CONCEPTOS
                </button>
                <button type="button" class="btn btn-info btn-sm " id="btnVerEmpleados" >
                    <span class="fa fa-users" ></span> EMPLEADOS
                </button>

            </div>
        </div>
    </div>
    <hr>
    <div class="card-body" style="padding-top: 0px; padding-bottom: 10px;">
        <form id="frmCaptura">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                    <label>Año</label>
                    <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" required="">
                </div>
                <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                    <label>Sem.</label>
                    <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" required="">
                </div>
                <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                    <label for="" >Empleado</label>
                    <select id="Empleado" name="Empleado" class="form-control form-control-sm required" >
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                    <label for="" >Concepto</label>
                    <select id="Concepto" name="Concepto" class="form-control form-control-sm required">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-6 col-xs-6 col-sm-2 col-lg-1 col-xl-1">
                    <label>Importe</label>
                    <input type="text" id="Importe" name="Importe" maxlength="10" class="form-control form-control-sm" required="">
                </div>
                <div class="col-12 col-sm-6 col-md-1 mt-4">
                    <button type="button" id="btnAceptar" class="btn btn-primary btn-sm">
                        <span class="fa fa-check"></span> ACEPTAR
                    </button>
                </div>
            </div>
        </form>
        <div class="w-100 my-2"></div>
        <div class="row">

            <div class="col-12 col-sm-12 col-md-12">
                <legend >Detalle de conceptos variables</legend>
                <div class="row">
                    <table id="tblConceptosVariables" class="table table-sm display" style="width:  100%;">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">PD</th>
                                <th scope="col">Sem</th>
                                <th scope="col">Emp</th>
                                <th scope="col">Concepto</th>
                                <th scope="col">Percepciones</th>
                                <th scope="col">Deducciones</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" align="center">Total General:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/ConceptosVariablesNomina/';
    var pnlTablero = $("#pnlTablero div.card-body");
    var Maq = pnlTablero.find("#Maq"), Control = pnlTablero.find("#Control"),
            ConceptosVariables, tblConceptosVariables = pnlTablero.find("#tblConceptosVariables"),
            btnAceptar = pnlTablero.find("#btnAceptar"), btnImprimir = pnlTablero.find("#btnImprimir");
    var btnVerConceptos = pnlTablero.find('#btnVerConceptos');
    var btnVerEmpleados = pnlTablero.find('#btnVerEmpleados');
    var nuevo = true;
    var diasAsistencia = 0;
    var tpConcepto = 0;
    var DeptoEmp = 0;
    $(document).ready(function () {
        //validacionSelectPorContenedor(pnlTablero);
        init();
        pnlTablero.find("#Ano").keydown(function (e) {
            if (e.keyCode === 13)
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
                    pnlTablero.find("#Sem").focus();
                    // getRecords($(this).val(), pnlTablero.find("#Sem").val());
                }
        });
        pnlTablero.find("#Sem").keydown(function (e) {
            if (e.keyCode === 13) {
                var ano = pnlTablero.find("#Ano");
                onComprobarSemanasNomina($(this), ano.val());
            }
        });
        pnlTablero.find("#Empleado").change(function () {
            var Ano = pnlTablero.find("#Ano").val();
            var Sem = pnlTablero.find("#Sem").val();
            var Empleado = pnlTablero.find("#Empleado").val();
            if ($(this).val()) {
                pnlTablero.find("#Concepto")[0].selectize.focus();
                getRecords(Empleado, Ano, Sem);
                $.getJSON(master_url + 'getDiasAsistenciaXEmpleadoSem', {Empleado: Empleado, Ano: Ano, Sem: Sem}).done(function (data) {
                    if (data.length > 0) {
                        diasAsistencia = data[0].numasistencias;
                    } else {
                        diasAsistencia = 0;
                    }
                }).fail(function (x) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
                getDepartamentoByEmpleado($(this).val());
            }
        });
        pnlTablero.find("#Concepto").change(function () {
            var Concepto = pnlTablero.find("#Concepto").val();
            var Ano = pnlTablero.find("#Ano").val();
            var Sem = pnlTablero.find("#Sem").val();
            var Empleado = pnlTablero.find("#Empleado").val();
            if ($(this).val()) {
                $.getJSON(master_url + 'onVerificarConceptoCapturado', {Concepto: Concepto, Ano: Ano, Sem: Sem, Empleado: Empleado}).done(function (data) {
                    if (data.length > 0) {
                        swal({
                            title: "ATENCIÓN",
                            text: "ESTE --> CONCEPTO <-- YA HA SIDO CAPTURADO",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            if (action) {
                                pnlTablero.find("#Concepto")[0].selectize.clear(true);
                                pnlTablero.find("#Concepto")[0].selectize.focus();
                            }
                        });
                    } else {
                        pnlTablero.find("#Importe").focus();
                        //Obtener el tipo de concepto
                        $.getJSON(master_url + 'getTipoConcepto', {Concepto: Concepto}).done(function (data) {
                            tpConcepto = data[0].Tipo;
                        }).fail(function (x) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x.responseText);
                        });
                    }
                }).fail(function (x) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });
        pnlTablero.find("#Importe").keyup(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    btnAceptar.focus();
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
        btnVerConceptos.click(function () {
            $.fancybox.open({
                src: base_url + '/ConceptosNomina.shoes',
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
        btnVerEmpleados.click(function () {
            $.fancybox.open({
                src: base_url + '/Empleados.shoes',
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
    });

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
                            //getRecords(pnlTablero.find("#Ano").val(), pnlTablero.find("#Sem").val());
                            pnlTablero.find("#Empleado")[0].selectize.focus();
                        }
                    } else {//Aún no existe la nomina, podemos continuar
                        //getRecords(pnlTablero.find("#Ano").val(), pnlTablero.find("#Sem").val());
                        pnlTablero.find("#Empleado")[0].selectize.focus();
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
        var frm = new FormData(pnlTablero.find("#frmCaptura")[0]);
        frm.append('tpcon', tpConcepto);
        frm.append('deptoemp', DeptoEmp);
        frm.append('diasemp', diasAsistencia);
        $.ajax(master_url + 'onAgregar', {
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: frm
        }).done(function (data) {
            console.log(data);
            ConceptosVariables.ajax.reload();
            diasAsistencia = 0;
            tpConcepto = 0;
            DeptoEmp = 0;
            pnlTablero.find("#Importe").val("");
            pnlTablero.find("#Concepto")[0].selectize.clear(true);
            pnlTablero.find("#Empleado")[0].selectize.clear(true);
            pnlTablero.find("#Empleado")[0].selectize.focus();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });

    }

    function getRecords(Empleado, Ano, Sem) {
        // HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblConceptosVariables')) {
            tblConceptosVariables.DataTable().destroy();
        }
        ConceptosVariables = tblConceptosVariables.DataTable({
            "dom": 'frtp',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataType": "json",
                "type": 'GET',
                "data": {Empleado: Empleado, Ano: Ano, Sem: Sem},
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"},
                {"data": "perded"},
                {"data": "numsem"},
                {"data": "numemp"},
                {"data": "numcon"},
                {"data": "importe"},
                {"data": "imported"},
                {"data": "Eliminar"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [1],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [5],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }, {
                    "targets": [6],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
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
                        case 1:
                            /*CONSUMO*/
                            c.addClass('text-strong');
                            break;
                        case 3:
                            /*PZXPAR*/
                            c.addClass('text-success text-strong ');
                            break;
                        case 4:
                            /*ELIMINAR*/
                            c.addClass('text-strong text-danger');
                            break;
                        case 5:
                            /*ELIMINAR*/
                            c.addClass('text-strong');
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
            scrollY: 280,
            keys: false,
            "bSort": true,
            "aaSorting": [
                [1, 'asc']/*ID*/, [4, 'desc']/*ID*/
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                /*Percepciones*/
                var totalPer = api.column(5).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(5).footer()).html(api.column(5, {page: 'current'}).data().reduce(function (a, b) {
                    return "<span class='text-strong text-success'>$" + $.number(parseFloat(totalPer), 2, '.', ',') + '</span>';
                }, 0));
                /*Deducciones*/
                var totalDed = api.column(6).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(6).footer()).html(api.column(6, {page: 'current'}).data().reduce(function (a, b) {
                    return "<span class='text-strong text-danger'>$" + $.number(parseFloat(totalDed), 2, '.', ',') + '</span>';
                }, 0));
                /*Total*/
                $(api.column(7).footer()).html(api.column(7, {page: 'current'}).data().reduce(function (a, b) {
                    return "<span class='text-strong text-info'>Neto: </span><span class='text-strong badge badge-info'>$" + $.number(parseFloat(totalPer - totalDed), 2, '.', ',') + '</span>';
                }, 0));

            },
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        $('#tblConceptosVariables_filter input[type=search]').addClass('selectNotEnter');
        tblConceptosVariables.find('tbody').on('click', 'tr', function () {
            nuevo = false;
            tblConceptosVariables.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }

    function init() {
        nuevo = true;
        diasAsistencia = 0;
        tpConcepto = 0;
        DeptoEmp = 0;
        getEmpleados();
        getConceptos();
        pnlTablero.find("#Ano").val(new Date().getFullYear()).focus().select();
        getRecords('', '', '');
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

    function getConceptos() {
        pnlTablero.find("#Concepto")[0].selectize.clear(true);
        pnlTablero.find("#Concepto")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getConceptosNomina').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Concepto")[0].selectize.addOption({text: v.Concepto, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onEliminarDetalleByID(numemp, ano, sem, numcon) {
        swal({
            buttons: ["Cancelar", "Aceptar"],
            title: 'Estas Seguro?',
            text: "Deseas eliminar el registro: \n\nEmpleado: " + numemp + " \n Año: " + ano + " \n Semana: " + sem,
            icon: "warning",
            closeOnEsc: false,
            closeOnClickOutside: false
        }).then((action) => {
            if (action) {
                $.ajax({
                    url: master_url + 'onEliminarDetalleByID',
                    type: "POST",
                    data: {

                        Empleado: numemp,
                        Ano: ano,
                        Sem: sem,
                        Concepto: numcon
                    }
                }).done(function (data, x, jq) {
                    ConceptosVariables.ajax.reload();
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

    function getDepartamentoByEmpleado(Empleado) {
        $.getJSON(master_url + 'getDepartamentoByEmpleado', {Empleado: Empleado}).done(function (data) {
            if (data.length > 0) {
                DeptoEmp = data[0].Depto;
            } else {
                swal('ERROR', 'EMPLEADO INCORRECTO', 'info');
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
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
    td{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>
