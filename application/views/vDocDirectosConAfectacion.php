<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-12 float-left">
                <legend class="float-left">Captura Documentos Directos a Maquilas/Proveedores</legend>
            </div>
        </div>
        <div class="row" id="Encabezado">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Tp" maxlength="1" required="">
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-xl-3">
                <label>Proveedor</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Proveedor" name="Proveedor" maxlength="5" required="">
                    </div>
                    <div class="col-9">
                        <select id="sProveedor" name="sProveedor" class="form-control form-control-sm required NotSelectize" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                <label for="" >Maq.*</label>
                <input type="text" class="form-control form-control-sm" maxlength="2" id="Maq" name="Maq" required="">
            </div>
            <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                <label for="" >Sem.*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="Sem" name="Sem" required="">
            </div>

            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Doc.</label>
                <input type="text" class="form-control form-control-sm captura " id="Doc" name="Doc" maxlength="15" required>
            </div>
            <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label>Fecha Doc.</label>
                <input type="text" class="form-control form-control-sm  numbersOnly date notEnter" id="FechaDoc" name="FechaDoc" maxlength="12" required>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Importe</label>
                <input type="text" class="form-control form-control-sm numbersOnly " id="Importe" name="Importe" maxlength="15" required data-toggle="tooltip" data-placement="right" title="El importe se captura sin IVA">
            </div>
        </div>
        <div class="row" id="Detalle">
            <div class="col-12 col-sm-4 col-md-3 col-xl-3">
                <label>Tipo</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Grupo" name="Grupo" maxlength="3" required="">
                    </div>
                    <div class="col-9">
                        <select id="sGrupo" name="sGrupo" class="form-control form-control-sm required NotSelectize" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary captura" id="btnGuardar" data-toggle="tooltip" data-placement="right" title="Capturar Documento">
                    <i class="fa fa-check"></i> ACEPTAR
                </button>
            </div>
        </div>
        <div class="card-block mt-2">
            <div id="DocumentosDirectos">
                <table id="tblDocumentosDirectos" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Tp</th>
                            <th>Documento</th>
                            <th>Fecha</th>
                            <th>Importe</th>
                            <th>Pagos</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/DocDirecConAfectacion/';
    var tblDocumentosDirectos = $('#tblDocumentosDirectos');
    var DocumentosDirectos;
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');


    $(document).ready(function () {
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        /*FUNCIONES INICIALES*/
        validacionSelectPorContenedor(pnlTablero);

        getGrupos();
        getRecords(0, 0);
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#FechaDoc").val(getToday());
        pnlTablero.find("#Tp").focus();

        pnlTablero.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTp($(this));
                }
            }
        });
        pnlTablero.find('#Proveedor').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtprov = $(this).val();
                var tp = pnlTablero.find("#Tp").val();
                if (txtprov) {
                    $.getJSON(master_url + 'onVerificarProveedor', {Proveedor: txtprov}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sProveedor")[0].selectize.addItem(txtprov, true);
                            getRecords(txtprov, tp);
                            pnlTablero.find('#Maq').focus().select();
                        } else {
                            swal('ERROR', 'EL PROVEEDOR NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sProveedor")[0].selectize.clear(true);
                                pnlTablero.find('#Proveedor').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sProveedor").change(function () {
            if ($(this).val()) {
                var tp = pnlTablero.find("#Tp").val();
                getRecords($(this).val(), tp);
                pnlTablero.find('#Maq').focus().select();
            }
        });
        pnlTablero.find('#Maq').keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onComprobarMaquilas($(this));
                }
            }
        });

        pnlTablero.find("#Sem").keypress(function (e) {
            if (e.keyCode === 13) {
                var sem = parseInt($(this).val());
                if (sem > 0 && sem < 53) {
                    pnlTablero.find('#Doc').focus();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "SEMANA NO VÁLIDA",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        $(this).val('').focus();
                    });
                }
            }
        });
        pnlTablero.find("#Doc").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var tp = pnlTablero.find("#Tp").val();
                    var prov = pnlTablero.find("#Proveedor").val();
                    var fact = pnlTablero.find("#Factura").val();
                    onVerificarExisteDocumento($(this), tp, prov, fact);
                }
            }
        });

        pnlTablero.find('#FechaDoc').keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    pnlTablero.find('#Importe').focus();
                }
            }
        });

        pnlTablero.find('#Importe').keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    pnlTablero.find('#Grupo').focus();
                }
            }
        });

        pnlTablero.find('#Grupo').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtgpo = $(this).val();
                if (txtgpo) {
                    $.getJSON(master_url + 'onVerificarGrupo', {Grupo: txtgpo}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sGrupo")[0].selectize.addItem(txtgpo, true);
                            getTipoCont(txtgpo);
                            btnGuardar.focus();
                        } else {
                            swal('ERROR', 'EL PROVEEDOR NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sGrupo")[0].selectize.clear(true);
                                pnlTablero.find('#Grupo').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sGrupo").change(function () {
            if ($(this).val()) {
                pnlTablero.find('#Grupo').val($(this).val());
                getTipoCont($(this).val());
                btnGuardar.focus();
            }
        });

        btnGuardar.click(function () {
            btnGuardar.attr('disabled', true);
            isValid('pnlTablero');
            if (valido) {
                swal({
                    buttons: ["Cancelar", "Aceptar"],
                    title: 'Estás Seguro?',
                    text: "Esta acción no se puede revertir",
                    icon: "warning",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {
                        var tp = pnlTablero.find("#Tp").val();
                        var prov = pnlTablero.find("#Proveedor").val();
                        var doc = pnlTablero.find('#Doc').val();
                        var fecDoc = pnlTablero.find('#FechaDoc').val();
                        var importe = pnlTablero.find("#Importe").val();
                        var Grupo = pnlTablero.find("#Grupo").val();
                        var Flete = pnlTablero.find("#Flete").val();
                        var Maq = pnlTablero.find("#Maq").val();
                        var Sem = pnlTablero.find("#Sem").val();
                        $.post(master_url + 'onAgregar', {

                            Tp: tp,
                            Proveedor: prov,
                            Doc: doc,
                            FechaDoc: fecDoc,
                            Importe: importe,
                            TipoCont: tpcont,
                            Flete: Flete,
                            Grupo: Grupo,
                            Maq: Maq,
                            Sem: Sem
                        }).done(function (data) {
                            btnGuardar.attr('disabled', false);
                            tpcont = '';
                            onNotifyOld('fa fa-check', 'DOCUMENTO GUARDADO', 'info');
                            DocumentosDirectos.ajax.reload();
                            pnlTablero.find("input").val("");
                            $.each(pnlTablero.find("select"), function (k, v) {
                                pnlTablero.find("select")[k].selectize.clear(true);
                            });
                            pnlTablero.find("#FechaDoc").val(getToday());
                            pnlTablero.find("#Tp").focus();
                        }).fail(function (x, y, z) {
                            btnGuardar.attr('disabled', false);
                            console.log(x, y, z);
                        });
                    }
                });
            } else {
                btnGuardar.attr('disabled', false);
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
            }

        });

    });
    var tpcont = '';
    function getTipoCont(gpo) {
        $.getJSON(master_url + 'getTipoCont', {
            Grupo: gpo
        }).done(function (data) {
            if (data.length > 0) {
                tpcont = data[0].Tipo;
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function onComprobarMaquilas(v) {
        $.getJSON(master_url + 'onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {
                pnlTablero.find("#Sem").focus().select();
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA MAQUILA " + $(v).val() + " NO ES VALIDA",
                    icon: "warning"
                }).then((value) => {
                    $(v).val('').focus();
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getGrupos() {
        $.getJSON(master_url + 'getGrupos').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sGrupo")[0].selectize.addOption({text: v.Grupo, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function onVerificarExisteDocumento(v, tp, prov) {
        $.getJSON(master_url + 'onVerificarExisteDocumento', {
            Doc: $(v).val(),
            TpDoc: tp,
            Proveedor: prov
        }).done(function (data) {
            if (data.length > 0) {
                swal({
                    title: "ATENCIÓN",
                    text: "ESTE DOCUMENTO YA FUE CAPTURADO",
                    icon: "warning"
                }).then((value) => {
                    $(v).val('').focus();
                });
            } else {//EL DOCUMENTO NO EXISTE
                pnlTablero.find('#FechaDoc').focus();
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getRecords(Proveedor, Tp) {
        temp = 0;
//        HoldOn.open({
//            theme: 'sk-cube',
//            message: 'CARGANDO...'
//        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDocumentosDirectos')) {
            tblDocumentosDirectos.DataTable().destroy();
        }
        DocumentosDirectos = tblDocumentosDirectos.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "data": {Tp: Tp, Proveedor: Proveedor},
                "type": "POST"
            },
            "columns": [
                {"data": "Tp"},
                {"data": "Doc"},
                {"data": "FechaDoc"},
                {"data": "ImporteDoc"},
                {"data": "Pagos_Doc"},
                {"data": "Saldo_Doc"}
            ],
//            "columnDefs": [
//                {
//                    "targets": [3],
//                    "render": function (data, type, row) {
//                        return '$' + $.number(parseFloat(data), 2, '.', ',');
//                    }
//                },
//                {
//                    "targets": [4],
//                    "render": function (data, type, row) {
//                        return '$' + $.number(parseFloat(data), 2, '.', ',');
//                    }
//                },
//                {
//                    "targets": [5],
//                    "render": function (data, type, row) {
//                        return '$' + $.number(parseFloat(data), 2, '.', ',');
//                    }
//                }
//            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 999,
            "scrollX": true,
            "scrollY": 380,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [1, 'asc'], [2, 'asc']
            ],
//            "createdRow": function (row, data, index) {
//                $.each($(row).find("td"), function (k, v) {
//                    var c = $(v);
//                    var index = parseInt(k);
//                    switch (index) {
//                        case 0:
//                            /*FECHA ORDEN*/
//                            c.addClass('text-strong');
//                            break;
//                        case 1:
//                            /*FECHA ENTREGA*/
//                            c.addClass('text-success text-strong');
//                            break;
//
//                        case 3:
//                            /*fecha conf*/
//                            c.addClass('text-info text-strong');
//                            break;
//                        case 4:
//                            /*fecha conf*/
//                            c.addClass('text-secondary text-strong');
//                            break;
//                        case 5:
//                            /*fecha conf*/
//                            c.addClass('text-danger text-strong');
//                            break;
//                    }
//                });
//            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblDocumentosDirectos.find('tbody').on('click', 'tr', function () {
            tblDocumentosDirectos.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }
    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            pnlTablero.find('#Proveedor').focus().select();
            getProveedores(tp);
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false,
                buttons: false,
                timer: 1000
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }
    function getProveedores(tp) {
        pnlTablero.find("#sProveedor")[0].selectize.clear(true);
        pnlTablero.find("#sProveedor")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sProveedor")[0].selectize.addOption({text: (tp === 1) ? v.ProveedorF : v.ProveedorI, value: v.ID});
            });
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

    td span.badge{
        font-size: 100% !important;
    }
</style>


