<div class="modal animated fadeIn" id="mdlAdicionaMaterialXLinea">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-retweet"></span> Adiciona material x linea en ficha técnica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <label>Linea</label>
                        <select id="LineaAdiciona" name="LineaAdiciona" class="form-control"></select>
                    </div>
                    <div class="col-4">
                        <label>Pieza</label>
                        <select id="PiezaAdiciona" name="PiezaAdiciona" class="form-control"></select>
                    </div>
                    <div class="col-4">
                        <label>Articulo</label>
                        <select id="ArticuloAdiciona" name="ArticuloAdiciona" class="form-control"></select>
                    </div>
                    <div class="col-4">
                        <label>Consumo</label>
                        <input type="text" id="ConsumoAdiciona" name="ConsumoAdiciona" class="form-control form-control-sm numbersOnly">
                    </div>
                    <div class="col-4">
                        <label>Piezas x par</label>
                        <input type="text" id="PiezasXParAdiciona" name="PiezasXParAdiciona" class="form-control form-control-sm numbersOnly" maxlength="8">
                    </div>
                    <div class="col-12" align="right">
                        <button type="button" id="btnAdiciona" name="btnAdiciona" class="btn btn-info-blue mt-4">
                            Adiciona
                        </button>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 text-center">
                        <p class="text-danger font-weight-bold">Detalle de la ficha técnica</p>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblDetalleFTAdiciona" class="table table-hover table-sm" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Linea</th>
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
    var mdlAdicionaMaterialXLinea = $("#mdlAdicionaMaterialXLinea"),
            LineaAdiciona = mdlAdicionaMaterialXLinea.find("#LineaAdiciona"),
            PiezaAdiciona = mdlAdicionaMaterialXLinea.find("#PiezaAdiciona"),
            ArticuloAdiciona = mdlAdicionaMaterialXLinea.find("#ArticuloAdiciona"),
            ConsumoAdiciona = mdlAdicionaMaterialXLinea.find("#ConsumoAdiciona"),
            PiezasXParAdiciona = mdlAdicionaMaterialXLinea.find("#PiezasXParAdiciona"),
            btnAdiciona = mdlAdicionaMaterialXLinea.find("#btnAdiciona"),
            tblDetalleFTAdiciona = mdlAdicionaMaterialXLinea.find("#tblDetalleFTAdiciona"),
            DetalleFTAdiciona;

    $(document).ready(function () {

        /*ADICIONA MAT X LINEA*/

        btnAdiciona.click(function () {
            if (LineaAdiciona.val() && PiezaAdiciona.val() && ArticuloAdiciona.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Guardando...'
                });
                $.post('<?php print base_url('FichaTecnica/onAdicionaXLinea'); ?>', {
                    LINEA: LineaAdiciona.val(), PIEZA: PiezaAdiciona.val(), ARTICULO: ArticuloAdiciona.val(),
                    CONSUMO: ConsumoAdiciona.val(), PZASXPAR: PiezasXParAdiciona.val()
                }).done(function (a) {
                    swal('ATENCIÓN', 'SE HAN ADICIONADO LOS MATERIALES A LA LINEA ' + LineaAdiciona.val(), 'success');
                    LineaAdiciona[0].selectize.clear(true);
                    PiezaAdiciona[0].selectize.clear(true);
                    ArticuloAdiciona[0].selectize.clear(true);
                    ConsumoAdiciona.val('');
                    PiezasXParAdiciona.val('');
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR LA LINEA, PIEZA, ARTICULO/MATERIAL, CONSUMO Y EL NUEVO CONSUMO', 'warning');
            }
        });

        ArticuloAdiciona.change(function () {
            if ($(this).val()) {
                DetalleFTAdiciona.ajax.reload();
            }
        });

        PiezaAdiciona.change(function () {
            if ($(this).val()) {
                DetalleFTAdiciona.ajax.reload();
            }
        });

        LineaAdiciona.change(function () {
            if ($(this).val()) {
                DetalleFTAdiciona.ajax.reload();
            }
        });

        mdlAdicionaMaterialXLinea.on('shown.bs.modal', function () {
            LineaAdiciona[0].selectize.clear(true);
            PiezaAdiciona[0].selectize.clear(true);
            ArticuloAdiciona[0].selectize.clear(true);
            ConsumoAdiciona.val('');
            PiezasXParAdiciona.val('');
            if ($.fn.DataTable.isDataTable('#tblDetalleFTAdiciona')) {
                DetalleFTAdiciona.ajax.reload(function () {
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
                DetalleFTAdiciona = tblDetalleFTAdiciona.DataTable({
                    "dom": 'ritp',
                    "ajax": {
                        "url": '<?php print base_url('FichaTecnica/getLineaPiezasMaterialXConsumos'); ?>',
                        "contentType": "application/json",
                        "dataSrc": "",
                        "data": function (d) {
                            d.LINEA = (LineaAdiciona.val() ? LineaAdiciona.val() : '');
                        }
                    },
                    buttons: buttons,
                    "columns": [
                        {"data": "ID"}/*0*/,
                        {"data": "LINEA"}/*1*/,
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
                    LineaAdiciona[0].selectize.clear(true);
                    $.each(data, function (k, v) {
                        LineaAdiciona[0].selectize.addOption({text: v.LINEA, value: v.CLAVE});
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                })).done(function (a) {
                    HoldOn.close();
                });
                $.getJSON('<?php print base_url('FichaTecnica/getPiezas'); ?>').done(function (data, x, jq) {
                    $.each(data, function (k, v) {
                        PiezaAdiciona[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
                $.when($.getJSON('<?php print base_url('FichaTecnica/getArticulosSuplex'); ?>').done(function (data, x, jq) {
                    ArticuloAdiciona[0].selectize.clear(true);
                    $.each(data, function (k, v) {
                        ArticuloAdiciona[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                })).done(function (a) {
                    HoldOn.close();
                });
            }
        });
    });


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
    .btn-info-blue{
        color: #fff;
        background-color: #3F51B5 !important;
        border-color: #3F51B5 !important;
    } 
</style>