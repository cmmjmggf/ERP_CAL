<div class="modal " id="mdlMatdeOtraMaqEntregadoAMaqUno"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Material de Otra Maquila Entregado a Maq 1</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">

                    <div class="row">
                        <div class="col-4">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                        <div class="col-4">
                            <label>Maq</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="Maq" name="Maq" >
                        </div>
                        <div class="col-4">
                            <label>Sem</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>

<script>
    var mdlMatdeOtraMaqEntregadoAMaqUno = $('#mdlMatdeOtraMaqEntregadoAMaqUno');
    var mdlReporte = $('#mdlReporte');
    var generado = false;
    $(document).ready(function () {

        mdlMatdeOtraMaqEntregadoAMaqUno.on('shown.bs.modal', function () {
            mdlMatdeOtraMaqEntregadoAMaqUno.find("input").val("");
            $.each(mdlMatdeOtraMaqEntregadoAMaqUno.find("select"), function (k, v) {
                mdlMatdeOtraMaqEntregadoAMaqUno.find("select")[k].selectize.clear(true);
            });
            mdlMatdeOtraMaqEntregadoAMaqUno.find('#Ano').focus();
        });
        mdlMatdeOtraMaqEntregadoAMaqUno.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    mdlMatdeOtraMaqEntregadoAMaqUno.find("#Ano").val("");
                    mdlMatdeOtraMaqEntregadoAMaqUno.find("#Ano").focus();
                });
            }
        });
        mdlMatdeOtraMaqEntregadoAMaqUno.find('#btnImprimir').on("click", function () {

            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlMatdeOtraMaqEntregadoAMaqUno.find("#frmCaptura")[0]);


            $.ajax({
                url: base_url + 'index.php/ReportesMaterialesJasper/onReporteMatOtraMaqEntregadoMaq1',
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
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlMatdeOtraMaqEntregadoAMaqUno.find('#Maq').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });

        });
        mdlMatdeOtraMaqEntregadoAMaqUno.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlMatdeOtraMaqEntregadoAMaqUno.find("#Sem").change(function () {
            if (parseInt($(this).val()) < 1 || parseInt($(this).val()) > 52 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "SEMANA INCORRECTA",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    mdlMatdeOtraMaqEntregadoAMaqUno.find("#Maq").val("");
                    mdlMatdeOtraMaqEntregadoAMaqUno.find("#Maq").focus();
                });
            }
        });
    });

    function onComprobarMaquilas(v) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
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


