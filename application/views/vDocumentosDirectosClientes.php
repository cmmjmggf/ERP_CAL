<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Captura Documentos Directos a Clientes</legend>
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
                <label for="" >Cliente</label>
                <select id="Cliente" name="Cliente" class="form-control form-control-sm required" required="" >
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
                <input type="text" class="form-control form-control-sm numbersOnly " id="Importe" name="Importe" maxlength="10" required >
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                <label>Concepto</label>
                <input type="text" class="form-control form-control-sm " id="Concepto" name="Concepto">
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary captura" id="btnGuardar" data-toggle="tooltip" data-placement="right" title="Capturar Documento">
                    <i class="fa fa-save"></i>
                </button>
            </div>
        </div>
        <div class="card-block mt-3">
            <div id="DocumentosDirectosClientes">
                <table id="tblDocumentosDirectosClientes" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Cliente</th>
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
    var master_url = base_url + 'index.php/DocumentosDirectosClientes/';
    var tblDocumentosDirectosClientes = $('#tblDocumentosDirectosClientes');
    var DocumentosDirectosClientes;
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        getClientes();
        pnlTablero.find("#FechaDoc").val(getToday());
        pnlTablero.find("#Tp").focus();
        pnlTablero.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTp($(this));
                }
            }
        });
        pnlTablero.find("#Cliente").change(function () {
            if ($(this).val()) {
                var tp = pnlTablero.find("#Tp").val();
                getRecords($(this).val(), tp);
                pnlTablero.find("#Doc").focus();
            }
        });
        pnlTablero.find("#Doc").keypress(function (e) {
            var tp = pnlTablero.find("#Tp").val();
            var cte = pnlTablero.find("#Cliente").val();
            var doc = pnlTablero.find("#Doc");
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarExisteDocumento(tp, cte, doc);
                }
            }
        });
        pnlTablero.find("#FechaDoc").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    pnlTablero.find("#Importe").focus();
                }
            }
        });
        pnlTablero.find("#Importe").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    pnlTablero.find("#Concepto").focus();
                }
            }
        });
        pnlTablero.find("#Concepto").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    btnGuardar.focus();
                }
            }
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
                        var prov = pnlTablero.find("#Cliente").val();
                        var doc = pnlTablero.find('#Doc').val();
                        var fecDoc = pnlTablero.find('#FechaDoc').val();
                        var importe = pnlTablero.find("#Importe").val();
                        var concepto = pnlTablero.find("#Concepto").val();
                        $.post(master_url + 'onAgregar', {
                            Tp: tp,
                            Cliente: prov,
                            Doc: doc,
                            FechaDoc: fecDoc,
                            Importe: importe,
                            Concepto: concepto
                        }).done(function (data) {
                            onNotifyOld('fa fa-check', 'DOCUMENTO GUARDADO', 'info');
                            DocumentosDirectosClientes.ajax.reload();
                            pnlTablero.find("input").val("");
                            $.each(pnlTablero.find("select"), function (k, v) {
                                pnlTablero.find("select")[k].selectize.clear(true);
                            });
                            pnlTablero.find("#FechaDoc").val(getToday());
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


    function onVerificarExisteDocumento(tp, cte, v) {
        $.getJSON(master_url + 'onVerificarExisteDocumento', {
            Doc: $(v).val(),
            Tp: tp,
            Cliente: cte
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
                pnlTablero.find("#FechaDoc").focus();
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getRecords(Cliente, Tp) {
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDocumentosDirectosClientes')) {
            tblDocumentosDirectosClientes.DataTable().destroy();
        }
        DocumentosDirectosClientes = tblDocumentosDirectosClientes.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "data": {Tp: Tp, Cliente: Cliente},
                "type": "POST"
            },
            "columns": [
                {"data": "cliente"},
                {"data": "tipo"},
                {"data": "docto"},
                {"data": "fecha"},
                {"data": "importe"},
                {"data": "pagos"},
                {"data": "saldo"}
            ],
            "columnDefs": [
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
                },
                {
                    "targets": [6],
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
                            c.addClass('text-strong');
                            break;

                        case 2:
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
                        case 6:
                            /*fecha conf*/
                            c.addClass('text-success text-strong');
                            break;
                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblDocumentosDirectosClientes.find('tbody').on('click', 'tr', function () {
            tblDocumentosDirectosClientes.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }
    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            pnlTablero.find('#Cliente')[0].selectize.focus();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }
    function getClientes() {
        pnlTablero.find("#Cliente")[0].selectize.clear(true);
        pnlTablero.find("#Cliente")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getClientes').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Cliente")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
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
    td{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    td span.badge{
        font-size: 100% !important;
    }
</style>
