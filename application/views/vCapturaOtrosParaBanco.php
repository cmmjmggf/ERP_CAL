<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8 col-md-8 float-left">
                <legend class="float-left">Captura Aguinalgos/Vacaciones/Caja Ahorro no calculados por el sistema</legend>
            </div>
            <div class="col-12 col-sm-4 col-md-4 animated bounceInLeft" align="right" id="Acciones">
                <button type="button" class="btn btn-success btn-sm " id="btnReporteNominaBanco" >
                    <span class="fa fa-cubes" ></span> GENERA ARCHIVO BANCO
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
                <div class="col-12 col-sm-6 col-md-4 col-xl-4">
                    <label>Sem.<span class="badge badge-info">97-Caja ahorro// 98-Aguinaldos //99-Vacaciones</span></label>
                    <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" required="">
                </div>
                <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                    <label for="" >Empleado</label>
                    <select id="Empleado" name="Empleado" class="form-control form-control-sm required" >
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-6 col-xs-6 col-sm-2 col-lg-1 col-xl-1">
                    <label>Interno</label>
                    <input type="text" id="ImporteD" name="ImporteD" maxlength="10" class="form-control form-control-sm numbersOnly" required="">
                </div>
                <div class="col-6 col-xs-6 col-sm-2 col-lg-1 col-xl-1">
                    <label>Fiscal</label>
                    <input type="text" id="ImporteF" name="ImporteF" maxlength="10" class="form-control form-control-sm numbersOnly" required="">
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
                <legend >Detalle de captura</legend>
                <table id="tblDetalleOtrosBanco" class="table table-sm display" style="width:  100%;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Depto</th>
                            <th scope="col">Empleado</th>
                            <th scope="col">Interno</th>
                            <th scope="col">Fiscal</th>
                            <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" align="center">Total General:</th>
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
<script>
    var master_url = base_url + 'index.php/CapturaOtrosParaBanco/';
    var pnlTablero = $("#pnlTablero div.card-body");
    var DetalleOtrosBanco, tblDetalleOtrosBanco = pnlTablero.find("#tblDetalleOtrosBanco"),
            btnAceptar = pnlTablero.find("#btnAceptar");
    var btnReporteNominaBanco = pnlTablero.find('#btnReporteNominaBanco');
    var nuevo = true;

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
                }
        });
        pnlTablero.find("#Sem").keyup(function (e) {
            if ($(this).val())
                if (e.keyCode === 13) {
                    if (parseInt($(this).val()) > 96 && parseInt($(this).val()) < 100) {
                        //obtener getRecors de la semana, año
                        pnlTablero.find("#Empleado")[0].selectize.focus();
                        getRecords(pnlTablero.find("#Ano").val(), $(this).val());
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "LA SEMANA DEBE DE SER 97, 98 O 99",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            if (action) {
                                $(this).val('').focus();
                            }
                        });
                    }
                }
        });
        pnlTablero.find("#Empleado").change(function () {
            if ($(this).val()) {
                pnlTablero.find("#ImporteD").focus();
            }
        });
        pnlTablero.find("#ImporteD").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    pnlTablero.find("#ImporteF").focus();
                } else {
                    pnlTablero.find("#ImporteD").val('0');
                    pnlTablero.find("#ImporteF").focus();
                }
            }
        });
        pnlTablero.find("#ImporteF").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    btnAceptar.focus();
                } else {
                    pnlTablero.find("#ImporteF").val('0');
                    btnAceptar.focus();
                }
            }
        });
        btnReporteNominaBanco.click(function () {
            $('#mdlGeneraAguinaldos').modal({
                backdrop: 'static',
                keyboard: false
            });
        });
        btnAceptar.click(function () {
            isValid('pnlTablero');
            if (valido) {
                //Valida que no esté cerrada la semana en nomina
                onAgregar();
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });
    });

    function onAgregar() {
        //inserta nuevo
        var frm = new FormData(pnlTablero.find("#frmCaptura")[0]);
        $.ajax(master_url + 'onAgregar', {
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: frm
        }).done(function (data) {
            console.log(data);
            DetalleOtrosBanco.ajax.reload();
            pnlTablero.find("#ImporteD").val("");
            pnlTablero.find("#ImporteF").val("");
            pnlTablero.find("#Empleado")[0].selectize.clear(true);
            pnlTablero.find("#Empleado")[0].selectize.focus();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });

    }

    function getRecords(Ano, Sem) {
        // HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDetalleOtrosBanco')) {
            tblDetalleOtrosBanco.DataTable().destroy();
        }
        DetalleOtrosBanco = tblDetalleOtrosBanco.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataType": "json",
                "type": 'GET',
                "data": {Ano: Ano, Sem: Sem},
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"},
                {"data": "numdepto"},
                {"data": "numemp"},
                {"data": "salariod"},
                {"data": "salfis"},
                {"data": "Eliminar"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [3],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }, {
                    "targets": [4],
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
                        case 4:
                            /*ELIMINAR*/
                            c.addClass('text-strong text-danger');
                            break;
                    }
                });
            },
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 350,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "scrollX": true,
            scrollY: 260,
            keys: false,
            "bSort": true,
            "aaSorting": [
                [1, 'asc']/*ID*/, [2, 'asc']/*ID*/
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                /*Percepciones*/
                var totalPer = api.column(3).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(3).footer()).html(api.column(3, {page: 'current'}).data().reduce(function (a, b) {
                    return "<span class='text-strong text-info'>$" + $.number(parseFloat(totalPer), 2, '.', ',') + '</span>';
                }, 0));
                /*Deducciones*/
                var totalDed = api.column(4).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(4).footer()).html(api.column(4, {page: 'current'}).data().reduce(function (a, b) {
                    return "<span class='text-strong text-success'>$" + $.number(parseFloat(totalDed), 2, '.', ',') + '</span>';
                }, 0));

            },
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        $('#tblDetalleOtrosBanco_filter input[type=search]').addClass('selectNotEnter');
        tblDetalleOtrosBanco.find('tbody').on('click', 'tr', function () {
            nuevo = false;
            tblDetalleOtrosBanco.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }

    function init() {
        nuevo = true;
        getEmpleados();
        pnlTablero.find("#Ano").val(new Date().getFullYear()).focus().select();
        getRecords('', '');
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

    function onEliminarDetalleByID(numemp, ano, sem) {
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
                        Sem: sem
                    }
                }).done(function (data, x, jq) {
                    DetalleOtrosBanco.ajax.reload();
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
$this->load->view('vGeneraAguinaldos');
