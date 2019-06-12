<div class="modal animated fadeIn" id="mdlArticuloYConsumoXEstiloColor">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-retweet"></span> Suple consumo x estilo, pieza y material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <label>Estilo</label>
                        <select id="EstiloConsumo" name="EstiloConsumo" class="form-control"></select>
                    </div>
                    <div class="col-4">
                        <label>Pieza</label>
                        <select id="PiezaConsumo" name="PiezaConsumo" class="form-control"></select>
                    </div>
                    <div class="col-4">
                        <label>Material</label>
                        <select id="MaterialConsumo" name="MaterialConsumo" class="form-control"></select>
                    </div>
                    <div class="col-4">
                        <label>Consumo</label>
                        <input type="text" id="ConsumoXLineaEstiloColor" name="ConsumoXLineaEstiloColor" class="form-control form-control-sm numbersOnly" maxlength="8">
                    </div>
                    <div class="col-4">
                        <label>Consumo nuevo</label>
                        <input type="text" id="ConsumoNuevoXLineaEstiloColor" name="ConsumoNuevoXLineaEstiloColor" class="form-control form-control-sm numbersOnly" maxlength="8">
                    </div>
                    <div class="col-4" align="center">
                        <button type="button" id="btnSupleConsumo" name="btnSupleConsumo" class="btn btn-info-blue mt-4">
                            Suplir
                        </button>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 text-center">
                        <p class="text-danger font-weight-bold">Detalle de la ficha técnica</p>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblDetalleFTConsumo" class="table table-hover table-sm" style="width: 100% !important;">
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
    var mdlArticuloYConsumoXEstiloColor = $("#mdlArticuloYConsumoXEstiloColor"),
            EstiloConsumo = mdlArticuloYConsumoXEstiloColor.find("#EstiloConsumo"),
            PiezaConsumo = mdlArticuloYConsumoXEstiloColor.find("#PiezaConsumo"),
            MaterialConsumo = mdlArticuloYConsumoXEstiloColor.find("#MaterialConsumo"),
            ConsumoXLineaEstiloColor = mdlArticuloYConsumoXEstiloColor.find("#ConsumoXLineaEstiloColor"),
            ConsumoNuevoXLineaEstiloColor = mdlArticuloYConsumoXEstiloColor.find("#ConsumoNuevoXLineaEstiloColor"),
            btnSupleConsumo = mdlArticuloYConsumoXEstiloColor.find("#btnSupleConsumo"),
            tblDetalleFTConsumo = mdlArticuloYConsumoXEstiloColor.find("#tblDetalleFTConsumo"),
            DetalleFTConsumo;

    $(document).ready(function () {
        
        btnSupleConsumo.click(function () {
            if (EstiloConsumo.val() && PiezaConsumo.val() &&
                    MaterialConsumo.val() && ConsumoXLineaEstiloColor.val() &&
                    ConsumoNuevoXLineaEstiloColor.val()) {
                $.getJSON('<?php print base_url('FichaTecnica/getNumMaterialesASuplirXConsumo'); ?>', {
                    ESTILO: EstiloConsumo.val(), PZA: PiezaConsumo.val(),
                    MATERIAL: MaterialConsumo.val()
                }).done(function (a) {
                    swal({
                        title: "Se suplirán el consumo de " + a[0].MATERIALES_A_SUPLIR + " materiales/articulos, ¿Estas seguro?",
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
                                $.post('<?php print base_url('FichaTecnica/onSuplirConsumos'); ?>', {
                                    ESTILO: EstiloConsumo.val(), PIEZA: PiezaConsumo.val(),
                                    MATERIAL: MaterialConsumo.val(), CONSUMO: ConsumoXLineaEstiloColor.val(),
                                    NUEVOCONSUMO: ConsumoNuevoXLineaEstiloColor.val()
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
                }).fail(function (x, y, z) {
                    getError(x);
                });
            } else {
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR TODOS LOS CAMPOS', 'warning');
            }
        });

        MaterialConsumo.change(function () {
            if (EstiloConsumo.val() || PiezaConsumo.val() ||
                    MaterialConsumo.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                DetalleFTConsumo.ajax.reload(function () {
                    HoldOn.close();
                });
            }
        });

        PiezaConsumo.change(function () {
            if (EstiloConsumo.val() || PiezaConsumo.val() ||
                    MaterialConsumo.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Cargando...'
                });
                DetalleFTConsumo.ajax.reload(function () {
                    HoldOn.close();
                });
            }
        });

        EstiloConsumo.change(function () {
            HoldOn.open({
                theme: 'sk-rect',
                message: 'Cargando...'
            });
            DetalleFTConsumo.ajax.reload(function () {
                HoldOn.close();
            });
        });


        /*CONSUMO*/
        ConsumoNuevoXLineaEstiloColor.on('keydown keyup', function () {
            onSuplirConsumo();
        });

        ConsumoXLineaEstiloColor.on('keydown keyup', function () {
            onSuplirConsumo();
        });

        mdlArticuloYConsumoXEstiloColor.on('shown.bs.modal', function () {
            btnSupleConsumo.attr('disabled', true);

            EstiloConsumo[0].selectize.clear(true);
            PiezaConsumo[0].selectize.clear(true);
            MaterialConsumo[0].selectize.clear(true);

            if ($.fn.DataTable.isDataTable('#tblDetalleFTConsumo')) {
                DetalleFTConsumo.ajax.reload(function () {
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
                DetalleFTConsumo = tblDetalleFTConsumo.DataTable({
                    "dom": 'ritp',
                    "ajax": {
                        "url": '<?php print base_url('FichaTecnica/getPiezasMaterialXConsumos'); ?>',
                        "contentType": "application/json",
                        "dataSrc": "",
                        "data": function (d) {
                            d.ESTILO = (EstiloConsumo.val() ? EstiloConsumo.val() : '');
                            d.PIEZA = (PiezaConsumo.val() ? PiezaConsumo.val() : '');
                            d.MATERIAL = (MaterialConsumo.val() ? MaterialConsumo.val() : '');
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

                EstiloConsumo[0].selectize.clear(true);
                PiezaConsumo[0].selectize.clear(true);
                MaterialConsumo[0].selectize.clear(true);

                $.getJSON('<?php print base_url('FichaTecnica/getPiezas'); ?>').done(function (data, x, jq) {
                    $.each(data, function (k, v) {
                        PiezaConsumo[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
                $.when($.getJSON('<?php print base_url('FichaTecnica/getArticulosSuplex'); ?>').done(function (data, x, jq) {
                    $.each(data, function (k, v) {
                        MaterialConsumo[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                })).done(function (a) {
                    HoldOn.close();
                });
                $.when($.getJSON('<?php print base_url('FichaTecnica/getEstilosConsumos'); ?>').done(function (data, x, jq) {

                    $.each(data, function (k, v) {
                        EstiloConsumo[0].selectize.addOption({text: v.ESTILO, value: v.CLAVE});
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                })).done(function (a) {
                });
            }
        });
    });
    var onSuplirConsumo = function () {
        if (EstiloConsumo.val() && PiezaConsumo.val() &&
                MaterialConsumo.val() && ConsumoXLineaEstiloColor.val() &&
                ConsumoNuevoXLineaEstiloColor.val()) {
            btnSupleConsumo.attr('disabled', false);
        } else {
            btnSupleConsumo.attr('disabled', true);
        }
    };
</script>