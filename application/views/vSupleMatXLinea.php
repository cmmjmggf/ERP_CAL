
<div class="modal animated fadeIn" id="mdlSupleMaterialEnFTXLinea">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-retweet"></span> Suple material en ficha tecnica x linea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label>Linea</label>
                        <select id="LineaDefinidora" name="LineaDefinidora" class="form-control"></select>
                    </div>  
                    <div class="w-100"></div>
                    <div class="col-5">
                        <label>Material a suplir</label>
                        <select id="MaterialASuplirXLinea" name="MaterialASuplirXLinea" class="form-control"></select>
                    </div>  
                    <div class="col-5">
                        <label>Material nuevo</label>
                        <select id="MaterialNuevoXLinea" name="MaterialNuevoXLinea" class="form-control"></select>
                    </div>  
                    <div class="col-2">
                        <label>Consumo</label>
                        <input type="text" id="ConsumoXLinea" name="ConsumoXLinea" class="form-control form-control-sm numbersOnly" maxlength="8">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12" align="right">
                        <button type="button" id="btnSuplirMaterialXLinea" name="btnSuplirMaterialXLinea" class="btn btn-info-blue mt-3" disabled="">
                            Suplir
                        </button>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 text-center">
                        <p class="text-danger font-weight-bold">Detalle de la ficha técnica</p>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblDetalleFTMaterialXLinea" class="table table-hover table-sm" style="width: 100% !important;">
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
    var mdlSupleMaterialEnFTXLinea = $("#mdlSupleMaterialEnFTXLinea"),
            MaterialASuplirXLinea = mdlSupleMaterialEnFTXLinea.find("#MaterialASuplirXLinea"),
            MaterialNuevoXLinea = mdlSupleMaterialEnFTXLinea.find("#MaterialNuevoXLinea"),
            btnSuplirMaterialXLinea = mdlSupleMaterialEnFTXLinea.find("#btnSuplirMaterialXLinea"),
            tblDetalleFTMaterialXLinea = mdlSupleMaterialEnFTXLinea.find("#tblDetalleFTMaterialXLinea"),
            LineaDefinidora = mdlSupleMaterialEnFTXLinea.find("#LineaDefinidora"),
            ConsumoXLinea = mdlSupleMaterialEnFTXLinea.find("#ConsumoXLinea"),
            DetalleFTMaterialXLinea;

    $(document).ready(function () {

        /*LINEA*/
        MaterialNuevoXLinea.on('change', function () {
            onComprobarSuplir();
        });
        MaterialASuplirXLinea.on('change', function () {
            onComprobarSuplir();
        });
        LineaDefinidora.on('change', function () {
            onComprobarSuplir();
        });
        ConsumoXLinea.on('keydown keyup', function () {
            onComprobarSuplir();
        });

        btnSuplirMaterialXLinea.click(function () {
            if (LineaDefinidora.val() && MaterialASuplirXLinea.val() && MaterialNuevoXLinea.val()) {
                $.getJSON('<?php print base_url('FichaTecnica/getNumMaterialesASuplirXLinea'); ?>',
                        {
                            LINEA: LineaDefinidora.val(), MATERIAL: MaterialASuplirXLinea.val()
                        }).done(function (a) {
                    if (parseInt(a[0].MATERIALES_A_SUPLIR_X_LIN) > 0) {
                        swal({
                            title: "Se suplirán " + a[0].MATERIALES_A_SUPLIR_X_LIN + " materiales/articulos, ¿Estas seguro?",
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
                                    $.post('<?php print base_url('FichaTecnica/onSuplirMaterialArticuloXLinea'); ?>', {
                                        LINEA: LineaDefinidora.val(), MATERIAL: MaterialASuplirXLinea.val(),
                                        MATERIALNUEVO: MaterialNuevoXLinea.val(), CONSUMO: ConsumoXLinea.val()
                                    }).done(function (aa, bb, cc) {
                                        swal('ATENCIÓN', 'SE HAN SUPLIDO  ' + a[0].MATERIALES_A_SUPLIR_X_LIN + '  FICHAS TECNICAS', 'success');
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
                        swal('ATENCIÓN', 'NO EXISTEN MATERIALES A SUPLIR, ELIJA OTRA LINEA U OTRO MATERIAL', 'warning').then((value) => {
                            MaterialASuplirXLinea[0].selectize.focus();
                        });
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR UNA LINEA, UN MATERIAL A SUPLIR Y EL NUEVO MATERIAL, EL CONSUMO PUEDE QUEDAR VACIO EN CASO DE QUE NO QUIERA MODIFICARLO', 'warning');
            }
        });

        MaterialASuplirXLinea.change(function () {
            if ($(this).val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                DetalleFTMaterialXLinea.ajax.reload(function () {
                    HoldOn.close();
                });
            }
        });

        LineaDefinidora.change(function () {
            if ($(this).val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                DetalleFTMaterialXLinea.ajax.reload(function () {
                    HoldOn.close();
                });
            }
        });

        mdlSupleMaterialEnFTXLinea.on('shown.bs.modal', function () {
            MaterialASuplirXLinea[0].selectize.clear(true);
            MaterialNuevoXLinea[0].selectize.clear(true);
            if ($.fn.DataTable.isDataTable('#tblDetalleFTMaterialXLinea')) {
                DetalleFTMaterialXLinea.ajax.reload(function () {
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
                DetalleFTMaterialXLinea = tblDetalleFTMaterialXLinea.DataTable({
                    "dom": 'ritp',
                    "ajax": {
                        "url": '<?php print base_url('FichaTecnica/getPiezasMaterialXLinea'); ?>',
                        "contentType": "application/json",
                        "dataSrc": "",
                        "data": function (d) {
                            d.LINEA = (LineaDefinidora.val().trim());
                            d.MATERIAL = (MaterialASuplirXLinea.val().trim());
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
                    }
                });

                $.when($.getJSON('<?php print base_url('FichaTecnica/getLineas'); ?>').done(function (data, x, jq) {
                    LineaDefinidora[0].selectize.clear(true);
                    $.each(data, function (k, v) {
                        LineaDefinidora[0].selectize.addOption({text: v.LINEA, value: v.CLAVE});
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                })).done(function (a) {
                    HoldOn.close();
                });
                $.when($.getJSON('<?php print base_url('FichaTecnica/getArticulosSuplex') ?>').done(function (data, x, jq) {
                    MaterialASuplirXLinea[0].selectize.clear(true);
                    MaterialNuevoXLinea[0].selectize.clear(true);
                    $.each(data, function (k, v) {
                        MaterialASuplirXLinea[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                        MaterialNuevoXLinea[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                })).done(function (a) {
                    HoldOn.close();
                });
            }
        });
    });

    function onComprobarSuplir() {
        if (LineaDefinidora.val() && MaterialASuplirXLinea.val() && MaterialNuevoXLinea.val() && ConsumoXLinea.val()) {
            btnSuplirMaterialXLinea.attr('disabled', false);
        } else {
            btnSuplirMaterialXLinea.attr('disabled', true);
        }
    }
</script>