<div class="modal " id="mdlCostoMaterialMaqSemFecha"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" id="mdlCostoMaterialMaqSemFechaDrag" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Costo de Materiales por Maq-Fecha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmParametros">
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-6 col-xl-3">
                            <label for="" >Maq.*</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="3" id="Maq" name="Maq" required="">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="PrecioActual">
                                <label class="custom-control-label text-info labelCheck" for="PrecioActual">Con Precio Actual?</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIni" name="FechaIni" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFin" name="FechaFin" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">IMPRIMIR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>



<script>
    var master_url = base_url + 'index.php/ReportesProveedores/';
    var mdlCostoMaterialMaqSemFecha = $('#mdlCostoMaterialMaqSemFecha');

    $(document).ready(function () {
        handleEnter();
        mdlCostoMaterialMaqSemFecha.find('#mdlCostoMaterialMaqSemFechaDrag').draggable();

        mdlCostoMaterialMaqSemFecha.on('shown.bs.modal', function () {
            mdlCostoMaterialMaqSemFecha.find("input").val("");
            mdlCostoMaterialMaqSemFecha.find('#FechaFin').val(getToday());
            mdlCostoMaterialMaqSemFecha.find('#Maq').focus();
        });

        mdlCostoMaterialMaqSemFecha.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });

        mdlCostoMaterialMaqSemFecha.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlCostoMaterialMaqSemFecha.find("#frmParametros")[0]);
            var conPrecioActual = mdlCostoMaterialMaqSemFecha.find("#PrecioActual")[0].checked ? '1' : '0';
            frm.append('ConPrecioActual', conPrecioActual);

            $.ajax({
                url: master_url + 'onReporteCostoMaterialesMaqFecha',
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
                                    width: "95%",
                                    height: "95%"
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
                        text: "NO EXISTEN DOCUMENTOS ESTA ESTA MAQUILA-FECHA",
                        icon: "error"
                    }).then((action) => {
                        mdlCostoMaterialMaqSemFecha.find('#Maq').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });
    function onComprobarMaquilas(v) {
        $.getJSON(master_url + 'onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA MAQUILA " + $(v).val() + " NO ES VALIDA",
                    icon: "warning",
                    buttons: {
                        eliminar: {
                            text: "Aceptar",
                            value: "aceptar"
                        }
                    }
                }).then((value) => {
                    switch (value) {
                        case "aceptar":
                            swal.close();
                            $(v).val('');
                            $(v).focus();
                            break;
                    }
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }


</script>

