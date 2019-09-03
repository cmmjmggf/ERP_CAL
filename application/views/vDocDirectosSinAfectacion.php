<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Captura Documentos Directos</legend>
            </div>
            <div class="col-sm-4" align="right">

            </div>
        </div>
        <div class="row" id="Encabezado">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Tp" maxlength="1" required="">
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                <label for="" >Proveedor</label>
                <select id="Proveedor" name="Proveedor" class="form-control form-control-sm required" required="" >
                    <option value=""></option>
                </select>
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
            <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                <label for="" >Tipo Material</label>
                <select id="Grupo" name="Grupo" class="form-control form-control-sm required" required="">
                    <option value=""></option>
                </select>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                <label>Tipo Cont.</label>
                <input type="text" class="form-control form-control-sm " readonly="" id="TipoCont" name="TipoCont">
            </div>
            <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                <label for="" >Es por flete?</label>
                <select id="Flete" name="Flete" class="form-control form-control-sm " required="">
                    <option value=""></option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                <label for="" >Moneda</label>
                <select id="Moneda" name="Moneda" class="form-control form-control-sm " >
                    <option value=""></option>
                    <option value="MXN">PESOS</option>
                    <option value="USD">DOLAR</option>
                    <option value="EUR">EURO</option>
                    <option value="LIB">LIBRA</option>
                    <option value="JEN">JEN</option>
                </select>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>T.C.</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="TipoCambio" name="TipoCambio" maxlength="5">
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary captura" id="btnGuardar" data-toggle="tooltip" data-placement="right" title="Capturar Documento">
                    <i class="fa fa-save"></i>
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
    var master_url = base_url + 'index.php/DocDirecSinAfectacion/';
    var tblDocumentosDirectos = $('#tblDocumentosDirectos');
    var DocumentosDirectos;
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');


    $(document).ready(function () {

        /*FUNCIONES INICIALES*/
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToSelectOnChange('#Grupo', '#Flete', pnlTablero);
        setFocusSelectToSelectOnChange('#Flete', '#Moneda', pnlTablero);
        setFocusSelectToInputOnChange('#Moneda', '#TipoCambio', pnlTablero);

        handleEnter();
        getGrupos();
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#FechaDoc").val(getToday());
        pnlTablero.find("#Tp").focus();
        pnlTablero.find("#Moneda")[0].selectize.addItem('MXN', true);
        pnlTablero.find("#TipoCambio").val('1');
        pnlTablero.find("#Tp").change(function () {
            onVerificarTp($(this));
        });
        pnlTablero.find("#Proveedor").change(function () {
            var tp = pnlTablero.find("#Tp").val();
            getRecords($(this).val(), tp);
        });
        pnlTablero.find("#Doc").change(function () {
            var tp = pnlTablero.find("#Tp").val();
            var prov = pnlTablero.find("#Proveedor").val();
            var fact = pnlTablero.find("#Factura").val();
            onVerificarExisteDocumento($(this), tp, prov, fact);
        });
        pnlTablero.find("#Grupo").change(function () {
            getTipoCont($(this).val());
        });
        pnlTablero.find("#Moneda").change(function () {
            getTipoCambio($(this).val());
        });
        btnGuardar.click(function () {
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
                        var TipoCont = pnlTablero.find("#TipoCont").val();
                        var Grupo = pnlTablero.find("#Grupo").val();
                        var Flete = pnlTablero.find("#Flete").val();
                        var Moneda = pnlTablero.find("#Moneda").val();
                        var TipoCambio = pnlTablero.find("#TipoCambio").val();
                        $.post(master_url + 'onAgregar', {

                            Tp: tp,
                            Proveedor: prov,
                            Doc: doc,
                            FechaDoc: fecDoc,
                            Importe: importe,
                            TipoCont: TipoCont,
                            Flete: Flete,
                            Moneda: Moneda,
                            TipoCambio: TipoCambio,
                            Grupo: Grupo
                        }).done(function (data) {
                            onNotifyOld('fa fa-check', 'DOCUMENTO GUARDADO', 'info');
                            DocumentosDirectos.ajax.reload();
                            pnlTablero.find("input").val("");
                            $.each(pnlTablero.find("select"), function (k, v) {
                                pnlTablero.find("select")[k].selectize.clear(true);
                            });
                            pnlTablero.find("#FechaDoc").val(getToday());
                            pnlTablero.find("#Moneda")[0].selectize.addItem('MXN', true);
                            pnlTablero.find("#TipoCambio").val('1');
                            pnlTablero.find("#Tp").focus();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        });
                    }
                });
            } else {
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
            }

        });

    });
    function getTipoCambio(mnda) {
        $.getJSON(master_url + 'getTipoCambio').done(function (data) {
            if (data.length > 0) {
                switch (mnda) {
                    case 'MXN':
                        pnlTablero.find('#TipoCambio').val(1);
                        break;
                    case 'USD':
                        pnlTablero.find('#TipoCambio').val(data[0].Dolar);
                        break;
                    case 'EUR':
                        pnlTablero.find('#TipoCambio').val(data[0].Euro);
                        break;
                    case 'LIB':
                        pnlTablero.find('#TipoCambio').val(data[0].Libra);
                        break;
                    case 'JEN':
                        pnlTablero.find('#TipoCambio').val(data[0].Jen);
                        break;
                    default:
                        pnlTablero.find('#TipoCambio').val(1);
                }
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getTipoCont(gpo) {
        $.getJSON(master_url + 'getTipoCont', {
            Grupo: gpo
        }).done(function (data) {
            if (data.length > 0) {
                pnlTablero.find('#TipoCont').val(data[0].Tipo);
                pnlTablero.find('#Flete')[0].selectize.focus();
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getGrupos() {
        $.getJSON(master_url + 'getGrupos').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Grupo")[0].selectize.addOption({text: v.Grupo, value: v.ID});
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

            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getRecords(Proveedor, Tp) {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
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
            "columnDefs": [
                {
                    "targets": [3],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [4],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [5],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
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
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 1:
                            /*FECHA ENTREGA*/
                            c.addClass('text-success text-strong');
                            break;

                        case 3:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                        case 4:
                            /*fecha conf*/
                            c.addClass('text-secondary text-strong');
                            break;
                        case 5:
                            /*fecha conf*/
                            c.addClass('text-danger text-strong');
                            break;
                    }
                });
            },
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
            pnlTablero.find('#Proveedor')[0].selectize.focus();
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
        pnlTablero.find("#Proveedor")[0].selectize.clear(true);
        pnlTablero.find("#Proveedor")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Proveedor")[0].selectize.addOption({text: (tp === 1) ? v.ProveedorF : v.ProveedorI, value: v.ID});
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
