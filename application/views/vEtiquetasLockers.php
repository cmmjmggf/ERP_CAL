<div class="modal " id="mdlEtiquetasLockers"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Impresión Etiquetas Lockers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6">
                            <label>Del Depto.</label>
                            <select id="DeptoLockers" name="DeptoLockers" class="form-control form-control-sm">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary " id="btnImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-info " id="btnVerEmpleadosLockers">EMPLEADOS</button>
                <button type="button" class="btn btn-secondary " id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlEtiquetasLockers = $('#mdlEtiquetasLockers');
    var btnVerEmpleadosLockers = $("#btnVerEmpleadosLockers");
    $(document).ready(function () {
        mdlEtiquetasLockers.on('shown.bs.modal', function () {
            mdlEtiquetasLockers.find("input").val("");
            $.each(mdlEtiquetasLockers.find("select"), function (k, v) {
                mdlEtiquetasLockers.find("select")[k].selectize.clear(true);
            });
            getDepartamentosLockers();
            mdlEtiquetasLockers.find('#DeptoLockers')[0].selectize.focus();
        });
        btnVerEmpleadosLockers.click(function () {
            $.fancybox.open({
                src: base_url + '/Empleados.shoes/?origen=NOMINAS',
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
                            width: "100%",
                            height: "100%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });
        mdlEtiquetasLockers.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var depto = mdlEtiquetasLockers.find('#DeptoLockers').val();
            $.get(base_url + 'index.php/ReportesNominaJasper/onImprimirEtiquetasLockers', {Depto: depto}).done(function (data, x, jq) {
                console.log(data, 'esto');
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
                        mdlEtiquetasLockers.find('#DeptoLockers')[0].selectize.focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            }).always(function () {
                HoldOn.close();
            });


        });
    });
    function getDepartamentosLockers() {
        $.getJSON(base_url + 'index.php/Departamentos/getDepartamentos').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlEtiquetasLockers.find("#DeptoLockers")[0].selectize.addOption({text: v.Departamento, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }
</script>


