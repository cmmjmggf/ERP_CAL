<div class="modal" id="mdlEstilosFotos">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="fa fa-puzzle-piece"></span>  ESTILOS (FOTO)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-10">
                        <label>Estilo</label>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" id="xEstiloFotoClave" class="form-control form-control-sm" maxlength="10">
                            </div>
                            <div class="col-8">
                                <select id="EstiloFoto" name="EstiloFoto" class="form-control">
                                    <option></option>
                                    <?php
                                    $burl = base_url();
                                    $data = $this->db->select('E.Clave AS CLAVE, CONCAT("' . $burl . '",E.Foto) AS URL, REPLACE(E.Foto,"uploads/Estilos/","") AS FOTO ', false)
                                                    ->from('estilos AS E')->group_by('E.Foto')->get()->result();
                                    foreach ($data as $k => $v) {
                                        print "<option value='{$v->CLAVE}'>{$v->CLAVE}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="table-responsive d-none">
                                <table id="tblEstilosFotos" class="table table-hover table-sm nowrap d-none" style="width: 100% !important;">
                                    <thead>
                                        <tr>
                                            <th scope="col">Estilo</th>
                                            <th scope="col">URL</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $row = "";
                                        foreach ($data as $k => $v) {
                                            $row = "<tr>";
                                            $row .= "<td>{$v->CLAVE}</td>";
                                            $row .= "<td>{$v->URL}</td>";
                                            $row .= "</tr>";
                                            print $row;
                                        }
                                        ?> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <button type="button" id="btnImprimeFotoEstilo" name="btnImprimeFotoEstilo" class=" mt-4 btn btn-sm btn-info">
                            <span class="fa fa-print"></span> Imprimir Foto
                        </button>
                    </div>
                    <div class="w-100 my-2"></div>
                    <div id="xFotoEstilo" class="col-12 text-center">
                        <a href="<?php print base_url('img/LS.png'); ?>"  data-fancybox="images" data-caption="">
                            <img src="<?php print base_url('img/LS.png'); ?>" class="img-thumbnail" id="imgsrc" >
                        </a>
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
            EstiloFotos = mdlEstilosFotos.find("#EstiloFoto"),
            btnImprimeFotoEstilo = mdlEstilosFotos.find("#btnImprimeFotoEstilo");

    $(document).ready(function () {

        btnImprimeFotoEstilo.click(function () {
            if (EstiloFotos.val()) {
                onOpenOverlay('Espere...');
                $.post('<?php print base_url('FichaTecnica/getEstiloParaImprimir'); ?>', {ESTILO: EstiloFotos.val()})
                        .done(function (a) {
                            onImprimirReporteFancy(a) 
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

        xEstiloFotoClave.on('keydown', function (e) {
            if (e.keyCode === 13 && xEstiloFotoClave.val()) {
                onOpenOverlay('Buscando...');
                onBuscarEstilo();
                EstiloFotos[0].selectize.setValue(xEstiloFotoClave.val());
                onCloseOverlay();
                if (EstiloFotos.val() === '') {
                    onDisable(EstiloFotos);
                }
            }
            if (e.keyCode === 46 && xEstiloFotoClave.val() === ''
                    || e.keyCode === 8 && xEstiloFotoClave.val() === '') {
                onEnable(EstiloFotos);
                onClear(EstiloFotos);
                mdlEstilosFotos.find("#imgsrc").parent().attr('data-caption', '');
                mdlEstilosFotos.find("#imgsrc").attr('src', '<?php print base_url('img/LS.png'); ?>');
                mdlEstilosFotos.find("#imgsrc").parent().attr('href', '<?php print base_url('img/LS.png'); ?>');
            }
        });

        EstiloFotos.change(function () {
            if (EstiloFotos.val()) {
                xEstiloFotoClave.val($(this).val());
                var url = "";
                $.each(mdlEstilosFotos.find("#tblEstilosFotos tbody tr"), function (k, v) {
                    var r = $(v).find("td");
                    if (r.eq(0).text() === xEstiloFotoClave.val()) {
                        url = r.eq(1).text();
                        mdlEstilosFotos.find("#imgsrc").parent().attr('data-caption', r.eq(0).text());
                        mdlEstilosFotos.find("#imgsrc").attr('src', url);
                        mdlEstilosFotos.find("#imgsrc").parent().attr('href', url);
                        return false;
                    }
                });
            } else {
                onClear(xEstiloFotoClave);
                mdlEstilosFotos.find("#imgsrc").parent().attr('data-caption', '');
                mdlEstilosFotos.find("#imgsrc").attr('src', '<?php print base_url('img/LS.png'); ?>');
                mdlEstilosFotos.find("#imgsrc").parent().attr('href', '<?php print base_url('img/LS.png'); ?>');
            }
        });

        mdlEstilosFotos.on('shown.bs.modal', function () {
            EstiloFotos[0].selectize.clear(true);
            mdlEstilosFotos.modal('show');
            xEstiloFotoClave.focus().select();
        });
    });

    function onBuscarEstilo() {
        var url = "";
        $.each(mdlEstilosFotos.find("#tblEstilosFotos tbody tr"), function (k, v) {
            var r = $(v).find("td");
            if (r.eq(0).text() === xEstiloFotoClave.val()) {
                url = r.eq(1).text();
                mdlEstilosFotos.find("#imgsrc").parent().attr('data-caption', r.eq(0).text());
                mdlEstilosFotos.find("#imgsrc").attr('src', url);
                mdlEstilosFotos.find("#imgsrc").parent().attr('href', url);
                return false;
            }
        });
    }

    function PrintElem(elem)
    {
        var res_width = screen.width, res_height = screen.height;
//        var mywindow = window.open('', 'PRINT', 'height=800,width=600');
        var mywindow = window.open('', 'PRINT', 'height=' + res_height + ',width=' + res_width);
        var mi_html = mdlEstilosFotos.find("#xFotoEstilo").html();
        console.log(mdlEstilosFotos.find("#FotoEstilo").val());
        console.log(mdlEstilosFotos.find("#xFotoEstilo").val());
        mywindow.document.write('<html><head><meta name="viewport" content="width=device-width, minimum-scale=0.1">');
        mywindow.document.write('<title>' + mdlEstilosFotos.find("#xFotoEstilo").val() + '</title>');
        mywindow.document.write('</head><body style="margin: 0px; background: #0e0e0e;">');
        mywindow.document.write(mi_html);
        mywindow.document.write('</body></html>');
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>