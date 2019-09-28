<div class="modal animated flipInY" id="mdlFichaTecnicaPreciosCostos"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Imprimir Ficha Técnica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmFichaTecnicaCompras">
                    <div class="row">

                        <div class="col-12 col-sm-8">
                            <label>Estilo</label>
                            <select class="form-control form-control-sm required selectize" id="Estilo" name="Estilo" required="">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Piezas</label>
                            <input type="text" maxlength="6" class="form-control form-control-sm disabledForms" id="Piezas" name="Piezas" >
                        </div>
                        <div class="col-12 col-sm-12">
                            <label>Color</label>
                            <select class="form-control form-control-sm required selectize" id="Color" name="Color" required="">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-12">
                            <label>Maquila</label>
                            <select class="form-control form-control-sm required selectize" id="Maquila" name="Maquila" required="">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimirFichaTecnica">IMPRIMIR</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
<script>

    var mdlFichaTecnicaPreciosCostos = $('#mdlFichaTecnicaPreciosCostos');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlFichaTecnicaPreciosCostos);
        setFocusSelectToSelectOnChange('#Color', '#Maquila', mdlFichaTecnicaPreciosCostos);

        mdlFichaTecnicaPreciosCostos.find("#Estilo").change(function () {
            $("#Color")[0].selectize.clear(true);
            $("#Color")[0].selectize.clearOptions();
            getColoresXEstiloReporte($(this).val());
            getEstiloByClaveReporte($(this).val());
        });

        mdlFichaTecnicaPreciosCostos.find("#Maquila").change(function () {
            mdlFichaTecnicaPreciosCostos.find("#btnImprimirFichaTecnica").focus();
        });

        mdlFichaTecnicaPreciosCostos.on('shown.bs.modal', function () {
            mdlFichaTecnicaPreciosCostos.find("input").val("");
            $.each(mdlFichaTecnicaPreciosCostos.find("select"), function (k, v) {
                mdlFichaTecnicaPreciosCostos.find("select")[k].selectize.clear(true);
            });
            mdlFichaTecnicaPreciosCostos.find('#Estilo')[0].selectize.focus();
        });

        mdlFichaTecnicaPreciosCostos.find('#btnImprimirFichaTecnica').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData($('#mdlFichaTecnicaPreciosCostos').find("#frmFichaTecnicaCompras")[0]);
            var maq = mdlFichaTecnicaPreciosCostos.find("#Maquila").find("option:selected").text();

            frm.append('NomMaquila', maq);
            $.ajax({
                url: base_url + 'index.php/FichaTecnicaCompra/onImprimirFichaTecnicaCompra',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {

                    $.fancybox.open({
                        src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
                        type: 'iframe',
                        opts: {
                            afterShow: function (instance, current) {
                                console.info('done!');
                            },
                            iframe: {
                                // Iframe template
                                tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                                preload: true,
                                // Custom CSS styling for iframe wrapping element
                                // You can use this to set custom iframe dimensions
                                css: {
                                    width: "85%",
                                    height: "85%"
                                },
                                // Iframe tag attributes
                                attr: {
                                    scrolling: "auto"
                                }
                            }
                        }
                    });


                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "ESTILO NO VÁLIDO",
                        icon: "error"
                    }).then((action) => {
                        mdlFichaTecnicaPreciosCostos.find('#Estilo')[0].selectize.focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
        handleEnterDiv(mdlFichaTecnicaPreciosCostos);
        getEstilosReporte();
        getMaquilasCostosEstilos();
    });

    function getMaquilasCostosEstilos() {
        $.getJSON(base_url + 'index.php/Estilos/getMaquilas').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlFichaTecnicaPreciosCostos.find("#Maquila")[0].selectize.addOption({text: v.Maquila, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getEstilosReporte() {
        $.getJSON(base_url + 'index.php/FichaTecnica/getEstilos').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlFichaTecnicaPreciosCostos.find("#Estilo")[0].selectize.addOption({text: v.Estilo, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getEstiloByClaveReporte(Estilo) {
        $.getJSON(base_url + 'index.php/Estilos/getEstiloByClave', {Clave: Estilo}).done(function (data, x, jq) {
            if (data.length > 0) {
                mdlFichaTecnicaPreciosCostos.find("#Piezas").val(parseInt(data[0].PiezasCorte));
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getColoresXEstiloReporte(Estilo) {

        $.getJSON(base_url + 'index.php/FichaTecnica/getColoresXEstilo', {Estilo: Estilo}).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlFichaTecnicaPreciosCostos.find("#Color")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
            });
            mdlFichaTecnicaPreciosCostos.find("#Color")[0].selectize.focus();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }



</script>