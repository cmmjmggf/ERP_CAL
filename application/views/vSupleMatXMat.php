<div class="modal animated fadeIn" id="mdlSupleMaterialEnFT">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-retweet"></span> Suple material en ficha tecnica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-5">
                        <label>Material a suplir</label>
                        <select id="MaterialASuplir" name="MaterialASuplir" class="form-control"></select>
                    </div>  
                    <div class="col-5">
                        <label>Material nuevo</label>
                        <select id="MaterialNuevo" name="MaterialNuevo" class="form-control"></select>
                    </div>
                    <div class="col-2">
                        <button type="button" id="btnSuplirMaterial" name="btnSuplirMaterial" class="btn btn-info-blue mt-3" disabled="">
                            Suplir
                        </button>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 text-center mt-2">
                        <p class="text-danger font-weight-bold">Detalle de la ficha técnica</p>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblDetalleFTMaterial" class="table table-hover table-sm" style="width: 100% !important;">
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
    var mdlSupleMaterialEnFT = $("#mdlSupleMaterialEnFT"), MaterialASuplir = mdlSupleMaterialEnFT.find("#MaterialASuplir"),
            MaterialNuevo = mdlSupleMaterialEnFT.find("#MaterialNuevo"),
            btnSuplirMaterial = mdlSupleMaterialEnFT.find("#btnSuplirMaterial"),
            tblDetalleFTMaterial = mdlSupleMaterialEnFT.find("#tblDetalleFTMaterial"), DetalleFTMaterial;

    $(document).ready(function () {

        /*MATERIAL*/
        MaterialNuevo.change(function () {
            if (MaterialASuplir.val() && MaterialNuevo.val()) {
                btnSuplirMaterial.attr('disabled', false);
            } else {
                btnSuplirMaterial.attr('disabled', true);
            }
        });
        MaterialASuplir.change(function () {
            if (MaterialASuplir.val() && MaterialNuevo.val()) {
                btnSuplirMaterial.attr('disabled', false);
            } else {
                btnSuplirMaterial.attr('disabled', true);
            }
        });
        btnSuplirMaterial.click(function () {
            if (MaterialASuplir.val() && MaterialNuevo.val()) {
                $.getJSON('<?php print base_url('FichaTecnica/getNumMaterialesASuplir'); ?>',
                        {MATERIAL: MaterialASuplir.val()}).done(function (a) {
                    console.log(a);
                    if (parseInt(a[0].MATERIALES_A_SUPLIR) > 0) {
                        swal({
                            title: "Se suplirán " + a[0].MATERIALES_A_SUPLIR + " materiales/articulos, ¿Estas seguro?",
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
                                    $.post('<?php print base_url('FichaTecnica/onSuplirMaterialArticulo'); ?>', {
                                        MATERIAL: MaterialASuplir.val(), MATERIALNUEVO: MaterialNuevo.val()
                                    }).done(function (aa, bb, cc) {
                                        swal('ATENCIÓN', 'SE HAN SUPLIDO  ' + a[0].MATERIALES_A_SUPLIR + '  FICHAS TECNICAS', 'success');
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
                            MaterialASuplir[0].selectize.focus();
                        });
                    }
                });
            } else {
                btnSuplirMaterial.attr('disabled', true);
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR LOS MATERIALES', 'warning');
            }
        });

        MaterialASuplir.change(function () {
            console.log($(this).val());
            if ($(this).val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Filtrando coincidencias...'
                });
                DetalleFTMaterial.ajax.reload(function () {
                    HoldOn.close();
                });
            } else {
                DetalleFTMaterial.ajax.reload(function () {
                    HoldOn.close();
                });
            }
        });

        mdlSupleMaterialEnFT.on('shown.bs.modal', function () {
            HoldOn.open({
                theme: 'sk-rect'
            });
            MaterialASuplir[0].selectize.clear(true);
            MaterialNuevo[0].selectize.clear(true);
            if ($.fn.DataTable.isDataTable('#tblDetalleFTMaterial')) {
                DetalleFTMaterial.ajax.reload(function () {
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
                DetalleFTMaterial = tblDetalleFTMaterial.DataTable({
                    "dom": 'ritp',
                    "ajax": {
                        "url": '<?php print base_url('FichaTecnica/getPiezasMaterial'); ?>',
                        "contentType": "application/json",
                        "dataSrc": "",
                        "data": function (d) {
                            d.MATERIAL = (MaterialASuplir.val().trim());
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
            }

            $.when($.getJSON('<?php print base_url('FichaTecnica/getArticulosSuplex'); ?>').done(function (data, x, jq) {
                MaterialNuevo[0].selectize.clear(true);
                MaterialASuplir[0].selectize.clear(true);
                $.each(data, function (k, v) {
                    MaterialNuevo[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                    MaterialASuplir[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                });
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            })).done(function (a) {
                HoldOn.close();
            });
        });

    });

</script>