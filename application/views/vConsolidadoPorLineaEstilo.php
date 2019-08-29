<div class="modal " id="mdlConsolidadoPorLineaEstilo"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ventas Consolidado por Linea-Estilo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">

                    <div class="row">

                        <div class="col-6">
                            <label class="mb-1">Del Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="dAnoConsolidadoLineaEstilo" name="dAnoConsolidadoLineaEstilo" >
                        </div>
                        <div class="col-6">
                            <label class="mb-1">Al Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="aAnoConsolidadoLineaEstilo" name="aAnoConsolidadoLineaEstilo" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="mb-1">Tp: <span class="badge badge-info" style="font-size: 14px;">Nota: Para ver todo, dejar en blanco</span></label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpConsolidadoLineaEstilo" name="TpConsolidadoLineaEstilo">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-12">
                            <label class="mb-1">Linea <span class="badge badge-success" style="font-size: 14px;">Para ver todas las lineas no seleccione nada</span></label>
                            <select id="LineaConsolidadoLineaEstilo" name="LineaConsolidadoLineaEstilo" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-12">
                            <label class="mb-1">Filtro <span class="badge badge-danger" style="font-size: 14px;">1 Pares, 2 Pesos</span></label>
                            <select id="FiltroConsolidadoLineaEstilo" name="FiltroConsolidadoLineaEstilo" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                                <option value="1">1 Pares</option>
                                <option value="2">2 Pesos</option>
                            </select>
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
    var mdlConsolidadoPorLineaEstilo = $('#mdlConsolidadoPorLineaEstilo');
    $(document).ready(function () {
        mdlConsolidadoPorLineaEstilo.on('shown.bs.modal', function () {
            mdlConsolidadoPorLineaEstilo.find("input").val("");
            $.each(mdlConsolidadoPorLineaEstilo.find("select"), function (k, v) {
                mdlConsolidadoPorLineaEstilo.find("select")[k].selectize.clear(true);
            });
            getLineasConsolidadoPorLineaEstilo();
            var d = new Date();
            mdlConsolidadoPorLineaEstilo.find('#dAnoConsolidadoLineaEstilo').val(d.getFullYear() - 1);
            mdlConsolidadoPorLineaEstilo.find('#aAnoConsolidadoLineaEstilo').val(d.getFullYear());
            mdlConsolidadoPorLineaEstilo.find('#dAnoConsolidadoLineaEstilo').focus().select();
        });

        mdlConsolidadoPorLineaEstilo.find("#dAnoConsolidadoLineaEstilo").keypress(function (e) {
            if (e.keyCode === 13) {
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
                        mdlConsolidadoPorLineaEstilo.find("#dAnoConsolidadoLineaEstilo").val("");
                        mdlConsolidadoPorLineaEstilo.find("#dAnoConsolidadoLineaEstilo").focus();
                    });
                } else {
                    mdlConsolidadoPorLineaEstilo.find('#aAnoConsolidadoLineaEstilo').focus();
                }
            }
        });

        mdlConsolidadoPorLineaEstilo.find("#aAnoConsolidadoLineaEstilo").keypress(function (e) {
            if (e.keyCode === 13) {
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
                        mdlConsolidadoPorLineaEstilo.find("#aAnoConsolidadoLineaEstilo").val("");
                        mdlConsolidadoPorLineaEstilo.find("#aAnoConsolidadoLineaEstilo").focus();
                    });
                } else {
                    mdlConsolidadoPorLineaEstilo.find('#TpConsolidadoLineaEstilo').focus();
                }
            }
        });
        mdlConsolidadoPorLineaEstilo.find("#TpConsolidadoLineaEstilo").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTp($(this));
                } else {
                    mdlConsolidadoPorLineaEstilo.find('#LineaConsolidadoLineaEstilo')[0].selectize.focus();
                }
            }
        });
        mdlConsolidadoPorLineaEstilo.find("#LineaConsolidadoLineaEstilo").change(function () {
            if ($(this).val()) {
                mdlConsolidadoPorLineaEstilo.find("#FiltroConsolidadoLineaEstilo")[0].selectize.focus();
            } else {
                mdlConsolidadoPorLineaEstilo.find("#FiltroConsolidadoLineaEstilo")[0].selectize.focus();
            }
        });
        mdlConsolidadoPorLineaEstilo.find("#FiltroConsolidadoLineaEstilo").change(function () {
            if ($(this).val()) {
                mdlConsolidadoPorLineaEstilo.find("#btnImprimir").focus();
            }
        });
        mdlConsolidadoPorLineaEstilo.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlConsolidadoPorLineaEstilo.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteConsolidadoLineaEstilo',
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
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlConsolidadoPorLineaEstilo.find('#Cliente')[0].selectize.focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });

    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlConsolidadoPorLineaEstilo.find('#LineaConsolidadoLineaEstilo')[0].selectize.focus();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }

    function getLineasConsolidadoPorLineaEstilo() {
        $.getJSON(base_url + 'index.php/Lineas/' + 'getLineasSelect').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlConsolidadoPorLineaEstilo.find("#LineaConsolidadoLineaEstilo")[0].selectize.addOption({text: v.Linea, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

</script>
