<script src="<?php print base_url('js/printjs/print.min.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php print base_url('js/printjs/print.min.css'); ?>">

<div class="modal" id="mdlEstilosFotos">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable modal-lg" 
         style="max-width: 80%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <span class="fa fa-puzzle-piece"></span>  ESTILOS (FOTO)</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3">
                        <label>ESTILO</label>
                        <div class="row">
                            <div class="col-12">
                                <input type="text" id="xEstiloFotoClave" class="form-control form-control-sm" maxlength="10">
                            </div>

                            <div class="col-12 table-responsive">
                                <table id="tblEstilosFotos" class="table table-hover table-sm nowrap" style="width: 100% !important;">
                                    <thead>
                                        <tr>
                                            <th scope="col">Estilo</th>
                                            <th scope="col">URL</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                                        $burl = base_url();
//                                        $data = $this->db->select('E.Clave AS CLAVE, CONCAT("' . $burl . '",E.Foto) AS URL, REPLACE(E.Foto,"uploads/Estilos/","") AS FOTO ', false)
//                                                        ->from('estilos AS E')->group_by('E.Foto')
//                                                ->order_by('ABS(E.Clave)','ASC')->get()->result();
//                                        $row = "";
//                                        foreach ($data as $k => $v) {
//                                            $row = "<tr>";
//                                            $row .= "<td>{$v->CLAVE}</td>";
//                                            $row .= "<td>{$v->URL}</td>";
//                                            $row .= "</tr>";
//                                            print $row;
//                                        }
                                        ?> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> 
                    <div class="col-9">
                        <div class="row">
                            <div class="col-12" align="center">
                                <button type="button" id="btnImprimeFotoEstilo" name="btnImprimeFotoEstilo" class="btn btn-sm btn-info my-2">
                                    <span class="fa fa-print"></span> Imprimir Foto
                                </button>
                            </div>
                            <div id="xFotoEstilo" class="col-12 text-center">
                                <a href="<?php print base_url('img/LS.png'); ?>"  data-fancybox="images" data-caption="">
                                    <img src="<?php print base_url('img/LS.png'); ?>" class="img-thumbnail" id="imgsrc" >
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlEstilosFotos = $("#mdlEstilosFotos"),
            xEstiloFotoClave = mdlEstilosFotos.find("#xEstiloFotoClave"),
            btnImprimeFotoEstilo = mdlEstilosFotos.find("#btnImprimeFotoEstilo");
    var EstilosFotos;
    $(document).ready(function () {

        btnImprimeFotoEstilo.click(function () {
            if (xEstiloFotoClave.val()) {
                onOpenOverlay('Espere...');
                var url = "";
                $.each(EstilosFotos.rows().data(), function (k, r) {
                    if (r.CLAVE === xEstiloFotoClave.val()) {
                        url = r.URL;
                        mdlEstilosFotos.find("#imgsrc").parent().attr('data-caption', url);
                        mdlEstilosFotos.find("#imgsrc").attr('src', url);
                        mdlEstilosFotos.find("#imgsrc").parent().attr('href', url);
                        return false;
                    }
                });
                $.post('<?php print base_url('FichaTecnica/getEstiloParaImprimir'); ?>', {
                    ESTILO: xEstiloFotoClave.val(),
                    URL: url
                }).done(function (a) {
                    printJS(a);
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    onCloseOverlay();
                });
            } else {
                onCampoInvalido(mdlEstilosFotos, "DEBE DE ESPECIFICAR UN ESTILO", function () {
                    xEstiloFotoClave.focus().select();
                });
            }
        });

        mdlEstilosFotos.find('[data-fancybox="images"]').fancybox({
            keyboard: true,
            arrows: true,
            transitionEffect: "rotate",
            buttons: true
        });

        xEstiloFotoClave.on('keydown keyup', function (e) {
            if (e.keyCode === 13 && xEstiloFotoClave.val()) {
                onBuscarEstilo();
                EstilosFotos.ajax.reload(function () {
                    xEstiloFotoClave.focus().select();
                });
            }
            if (e.keyCode === 13 && xEstiloFotoClave.val() === '' ||
                    e.keyCode === 46 && xEstiloFotoClave.val() === ''
                    || e.keyCode === 8 && xEstiloFotoClave.val() === '') {

                EstilosFotos.ajax.reload(function () {
                    xEstiloFotoClave.focus().select();
                });
                mdlEstilosFotos.find("#imgsrc").parent().attr('data-caption', '');
                mdlEstilosFotos.find("#imgsrc").attr('src', '<?php print base_url('img/LS.png'); ?>');
                mdlEstilosFotos.find("#imgsrc").parent().attr('href', '<?php print base_url('img/LS.png'); ?>');
            }
        });

        mdlEstilosFotos.on('shown.bs.modal', function () {
            $.fn.dataTable.ext.errMode = 'throw';
            if ($.fn.DataTable.isDataTable('#tblEstilosFotos')) {
                xEstiloFotoClave.val('');
                mdlEstilosFotos.find("#imgsrc").parent().attr('data-caption', '');
                mdlEstilosFotos.find("#imgsrc").attr('src', '<?php print base_url('img/LS.png'); ?>');
                mdlEstilosFotos.find("#imgsrc").parent().attr('href', '<?php print base_url('img/LS.png'); ?>');

                EstilosFotos.ajax.reload(function () {
                    xEstiloFotoClave.focus().select();
                });
                return;
            }
            EstilosFotos = mdlEstilosFotos.find("#tblEstilosFotos").DataTable({
                "dom": 'rit',
                "ajax": {
                    "url": '<?php print base_url('FichaTecnica/getEstilosParaFotos'); ?>',
                    "dataSrc": "",
                    "data": function (d) {
                        d.ESTILO = xEstiloFotoClave.val() ? xEstiloFotoClave.val() : '';
                    }
                },
                "columns": [
                    {"data": "CLAVE"},
                    {"data": "URL"}
                ],
                "columnDefs": [
                    {
                        "targets": [1],
                        "visible": false,
                        "searchable": true
                    }
                ],
                language: lang,
                select: true,
                keys: true,
                "autoWidth": true,
                "colReorder": true,
                "displayLength": 999999999999,
                "bLengthChange": false,
                "deferRender": true,
                "scrollCollapse": false,
                "scrollY": "350px",
                "scrollX": true,
                "bSort": true,
                initComplete: function () {
                    xEstiloFotoClave.focus().select();
                }
            });
        });

        mdlEstilosFotos.find("#tblEstilosFotos tbody").on('click', 'tr', function () {
            console.log($(this), $(this).find("td").eq(1).text());
            xEstiloFotoClave.val($(this).find("td").eq(0).text());
            onBuscarEstilo();
        });
        mdlEstilosFotos.find("#tblEstilosFotos").on('key-focus', function (e, datatable, cell) {
            EstilosFotos.rows().deselect();
            EstilosFotos.row(cell.index().row).select();
            var r = EstilosFotos.row(cell.index().row).data();
            xEstiloFotoClave.val(r.CLAVE);
            var xurl = r.URL;
            mdlEstilosFotos.find("#imgsrc").parent().attr('data-caption', xurl);
            mdlEstilosFotos.find("#imgsrc").attr('src', xurl);
            mdlEstilosFotos.find("#imgsrc").parent().attr('href', xurl);
        });
    });

    function onBuscarEstilo() {
        var url = "";
        $.each(EstilosFotos.rows().data(), function (k, r) {
            if (r.CLAVE === xEstiloFotoClave.val()) {
                url = r.URL;
                mdlEstilosFotos.find("#imgsrc").parent().attr('data-caption', url);
                mdlEstilosFotos.find("#imgsrc").attr('src', url);
                mdlEstilosFotos.find("#imgsrc").parent().attr('href', url);
                return false;
            }
        });
    }
</script>
<style>
    #mdlEstilosFotos table tbody td, #mdlEstilosFotos input, #mdlEstilosFotos button, #mdlEstilosFotos{
        font-weight: bold !important;
        font-size: 25px !important;
    }
    
</style>