<div class="modal animated fadeIn" id="mdlSuplePiezaEnFT">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-retweet"></span> Suple piezas en ficha tecnica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-5">
                        <label>Pieza a suplir</label>
                        <select id="PiezaASuplir" name="PiezaASuplir" class="form-control"></select>
                    </div>  
                    <div class="col-5">
                        <label>Pieza nueva</label>
                        <select id="PiezaNueva" name="PiezaNueva" class="form-control"></select>
                    </div>
                    <div class="col-2">
                        <button type="button" id="btnSuplirPieza" name="btnSuplirPieza" class="btn btn-info-blue mt-3" disabled="">
                            Suplir
                        </button>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 text-center mt-2">
                        <p class="text-danger font-weight-bold">Detalle de la ficha técnica</p>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblDetalleFT" class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Estilo</th>
                                    <th scope="col">Col</th>
                                    <th scope="col">Pza</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Sec</th>
                                    <th scope="col">Art</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Cons</th>
                                    <th scope="col">Rango</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>  
                </div>
                <div class="modal-footer"> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlSuplePiezaEnFT = $("#mdlSuplePiezaEnFT"),
            PiezaASuplir = mdlSuplePiezaEnFT.find("#PiezaASuplir"), PiezaNueva = mdlSuplePiezaEnFT.find("#PiezaNueva"),
            btnSuplirPieza = mdlSuplePiezaEnFT.find("#btnSuplirPieza"),
            tblDetalleFT = mdlSuplePiezaEnFT.find("#tblDetalleFT"), DetalleFT;
    $(document).ready(function () {

        /*PIEZA*/
        btnSuplirPieza.click(function () {
            if (PiezaASuplir.val() && PiezaNueva.val()) {
                $.getJSON('<?php print base_url('FichaTecnica/getNumPiezasASuplir'); ?>',
                        {PZA: PiezaASuplir.val()}).done(function (a) {
                    if (parseInt(a[0].PIEZAS_A_SUPLIR) > 0) {
                        swal({
                            title: "Se suplirán " + a[0].PIEZAS_A_SUPLIR + " piezas, ¿Estas seguro?",
                            text: "Nota: Esta acción no se puede deshacer",
                            icon: "warning",
                            buttons: {
                                cancelar: {
                                    text: "Cancelar",
                                    value: "no"
                                },
                                cambiar: {
                                    text: "Aceptar",
                                    value: "ok"
                                }
                            }
                        }).then((value) => {
                            switch (value) {
                                case "ok":
                                    HoldOn.open({
                                        theme: 'sk-rect',
                                        message: 'Supliendo...'
                                    });
                                    $.post('<?php print base_url('FichaTecnica/onSuplirPieza'); ?>', {
                                        PZA: PiezaASuplir.val(), PZANUEVA: PiezaNueva.val()
                                    }).done(function (aa, bb, cc) {
                                        swal('ATENCIÓN', 'SE HAN SUPLIDO ' + a[0].PIEZAS_A_SUPLIR + ' FICHAS TECNICAS', 'success');
                                    }).always(function () {
                                        HoldOn.close();
                                    });
                                    break;
                                case "cancelar":
                                    swal.close();
                                    HoldOn.close();
                                    break;
                            }
                        });
                    } else {
                        swal('ATENCIÓN', 'NO EXISTEN PIEZAS A SUPLIR, ELIJA OTRA PIEZA', 'warning').then((value) => {
                            PiezaASuplir[0].selectize.focus();
                        });
                    }
                });
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR LAS PIEZAS', 'warning');
            }
        });

        PiezaASuplir.change(function () {
            if ($(this).val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                if ($(this).val()) {
                    DetalleFT.ajax.reload(function () {
                        HoldOn.close();
                    });
                }
            }

            if ($(this).val() && PiezaASuplir.val()) {
                btnSuplirPieza.attr('disabled', true);
            } else {
                btnSuplirPieza.attr('disabled', true);
            }
        });

        PiezaNueva.change(function () {
            if ($(this).val() && PiezaASuplir.val()) {
                btnSuplirPieza.attr('disabled', false);
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                if ($(this).val()) {
                    DetalleFT.ajax.reload(function () {
                        HoldOn.close();
                    });
                }
            } else {
                btnSuplirPieza.attr('disabled', true);
            }
        });

        mdlSuplePiezaEnFT.on('shown.bs.modal', function () {
            HoldOn.open({
                theme: 'sk-rect',
                message: 'Cargando...'
            });
            PiezaASuplir[0].selectize.clear(true);
            PiezaNueva[0].selectize.clear(true);
            if ($.fn.DataTable.isDataTable('#tblDetalleFT')) {
                DetalleFT.ajax.reload(function () {
                    HoldOn.close();
                });
            } else {
                var coldefs = [
                    {
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    }
                ];
                DetalleFT = tblDetalleFT.DataTable({
                    "dom": 'ritp',
                    "ajax": {
                        "url": '<?php print base_url('FichaTecnica/getPiezasTable'); ?>',
                        "contentType": "application/json",
                        "dataSrc": "",
                        "data": function (d) {
                            d.PZA = (PiezaASuplir.val().trim());
                        }
                    },
                    buttons: buttons,
                    "columns": [
                        {"data": "ID"}/*0*/,
                        {"data": "ESTILO"}/*1*/,
                        {"data": "COLOR"}/*2*/,
                        {"data": "PIEZA"}/*4*/,
                        {"data": "PIEZAT"}/*5*/,
                        {"data": "SEC"}/*6*/,
                        {"data": "ARTICULO"}/*7*/,
                        {"data": "ARTICULOT"}/*8*/,
                        {"data": "CONSUMO"}/*10*/,
                        {"data": "RANGO"}/*11*/
                    ],
                    "columnDefs": coldefs,
                    language: lang,
                    select: true,
                    "autoWidth": true,
                    "colReorder": true,
                    "displayLength": 99999999,
                    "bLengthChange": false,
                    "deferRender": true,
                    "scrollCollapse": false,
                    "bSort": true,
                    "scrollY": "498px",
                    "scrollX": true,
                    "aaSorting": [
                        [0, 'desc']
                    ],
                    initComplete: function () {
                        HoldOn.close();
                    }
                });
                $.getJSON('<?php print base_url('FichaTecnica/getPiezas'); ?>').done(function (data, x, jq) {
                    $.each(data, function (k, v) {
                        PiezaASuplir[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                        PiezaNueva[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
            }
        });

    });
</script>