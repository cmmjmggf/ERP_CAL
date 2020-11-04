<div class="modal" id="mdlCodigoXCliente">
    <div class="modal-dialog modal-lg notdraggable modal-dialog-centered" role="document" style="min-width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-barcode"></span> Agregar códigos por cliente estilo talla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <label>Cliente</label>
                        <select id="ClienteCXCXEXT" name="ClienteCXCXEXT" class="form-control">
                            <option></option> 
                        </select>
                    </div>
                    <div class="col-3">
                        <label>Estilo</label> 
                        <select id="EstiloCXCXEXT" name="EstiloCXCXEXT" class="form-control">
                            <option></option> 
                        </select>
                    </div>
                    <div class="col-3">
                        <label>Color</label> 
                        <select id="ColorCXCXEXT" name="ColorCXCXEXT" class="form-control">
                            <option></option> 
                        </select>
                    </div>
                    <div class="col-2 justify-content-center" align="center">
                        <a href="<?php print base_url('img/sin_foto.png'); ?>" data-fancybox="images">
                            <img id="FotoEstiloET" src="<?php print base_url('img/sin_foto.png'); ?>" class="img-fluid" style="max-height: 98px; cursor: pointer;">
                        </a>
                    </div>
                    <div class="col-2">
                        <label>Talla</label> 
                        <input type="text" id="TallaCXCXEXT" name="TallaCXCXEXT" class="form-control" maxlength="4"> 
                    </div>
                    <div class="col-2">
                        <label>Código</label> 
                        <input type="text" id="CodigoCXCXEXT" name="CodigoCXCXEXT" class="form-control"  maxlength="15"> 
                    </div>
                    <div class="col-2">
                        <label>ID artículo</label> 
                        <input type="text" id="IDarticuloCXCXEXT" name="IDarticuloCXCXEXT" class="form-control" maxlength="19"> 
                    </div>
                    <div class="col-2">
                        <label>Proveedor</label> 
                        <input type="text" id="ProveedorCXCXEXT" name="ProveedorCXCXEXT" class="form-control" maxlength="49"> 
                    </div>
                    <div class="col-2">
                        <label>Catálogo</label> 
                        <input type="text" id="CatalogoCXCXEXT" name="CatalogoCXCXEXT" class="form-control" maxlength="49"> 
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-12">
                        <table id="tblEtiquetasDeCodigoDeBarrasXCliente" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Talla</th>
                                    <th scope="col">Código </th>
                                    <th scope="col">ID Artículo </th>
                                    <th scope="col">Proveedor </th>
                                    <th scope="col">Catálogo </th>
                                </tr>
                            </thead>
                            <tbody> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"><span class="fa fa-check"></span> ACEPTA</button> 
            </div>
        </div>
    </div>
</div>
<script>
    var mdlCodigoXCliente = $("#mdlCodigoXCliente"),
            ClienteCXCXEXT = mdlCodigoXCliente.find('#ClienteCXCXEXT'),
            FotoEstiloET = mdlCodigoXCliente.find('#FotoEstiloET'),
            EstiloCXCXEXT = mdlCodigoXCliente.find('#EstiloCXCXEXT'),
            ColorCXCXEXT = mdlCodigoXCliente.find('#ColorCXCXEXT'),
            TallaCXCXEXT = mdlCodigoXCliente.find('#TallaCXCXEXT'),
            CodigoCXCXEXT = mdlCodigoXCliente.find('#CodigoCXCXEXT'),
            IDarticuloCXCXEXT = mdlCodigoXCliente.find('#IDarticuloCXCXEXT'),
            ProveedorCXCXEXT = mdlCodigoXCliente.find('#ProveedorCXCXEXT'),
            CatalogoCXCXEXT = mdlCodigoXCliente.find('#CatalogoCXCXEXT'),
            tblEtiquetasDeCodigoDeBarrasXCliente = mdlCodigoXCliente.find('#tblEtiquetasDeCodigoDeBarrasXCliente');

    $(document).ready(function () {
        getidsInputSelect(mdlCodigoXCliente);
        mdlCodigoXCliente.on('shown.bs.modal', function () {
            onClearSelect(ClienteCXCXEXT);
            onClearSelect(EstiloCXCXEXT);
            $.getJSON('<?php print base_url('CodigosXCliente/getClientes') ?>').done(function (a) {
                $.each(a, function (k, v) {
                    ClienteCXCXEXT[0].selectize.addOption({text: v.Descripcion, value: v.Clave});
                });
                $.getJSON('<?php print base_url('CodigosXCliente/getEstilos') ?>').done(function (a) {
                    $.each(a, function (k, v) {
                        EstiloCXCXEXT[0].selectize.addOption({text: v.Descripcion, value: v.Clave});
                    });
                });
            });
        });

        EstiloCXCXEXT.change(function () {
            if (EstiloCXCXEXT.val()) {
                onOpenOverlay('Cargando colores...');
                onClearSelect(ColorCXCXEXT);
                $.getJSON('<?php print base_url('CodigosXCliente/getFotoXEstilo') ?>', {ESTILO: EstiloCXCXEXT.val()}).done(function (a) {
                    if (a.length > 0) {
                        FotoEstiloET[0].src = a[0].FOTO;
                        $(FotoEstiloET).parent('a')[0].href = a[0].FOTO;
                    }
                }).fail(function (e) {
                    getError(e);
                });
                $.getJSON('<?php print base_url('CodigosXCliente/getColoresXEstilo') ?>', {ESTILO: EstiloCXCXEXT.val()}).done(function (a) {
                    $.each(a, function (k, v) {
                        ColorCXCXEXT[0].selectize.addOption({text: v.Descripcion, value: v.Clave});
                    });
                    onCloseOverlay();
                }).fail(function (e) {
                    getError(e);
                });
            }
        });
    });



</script>