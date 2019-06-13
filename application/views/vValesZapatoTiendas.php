<div class="modal " id="mdlValesZapatoTiendas"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Impresión de Vales para Zapatos de Tiendas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6" >
                            <label>Empleado</label>
                            <select id="EmpleadoZapTda" name="EmpleadoZapTda" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary selectNotEnter" id="btnImprimir">IMPRIMIR</button>
                <button type="button" class="btn btn-secondary selectNotEnter" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlValesZapatoTiendas = $('#mdlValesZapatoTiendas');
    $(document).ready(function () {
        mdlValesZapatoTiendas.on('shown.bs.modal', function () {
            mdlValesZapatoTiendas.find("input").val("");
            $.each(mdlValesZapatoTiendas.find("select"), function (k, v) {
                mdlValesZapatoTiendas.find("select")[k].selectize.clear(true);
            });
            getEmpleadosZapTda();
            mdlValesZapatoTiendas.find('#EmpleadoZapTda')[0].selectize.focus();
        });

        mdlValesZapatoTiendas.find('#EmpleadoZapTda').change(function () {
            if ($(this).val())
                $.getJSON(base_url + 'index.php/Empleados/getInfoEmpleadoZapTda', {Empleado: $(this).val()}).done(function (data, x, jq) {
                    if (data.length > 0) {
                        if (parseFloat(data[0].ZapatosTDA) >= 250) {
                            swal({
                                title: "NO AUTORIZADO",
                                text: "NEL EMPLEADO TIENE DEUDA DE ZAPATOS",
                                icon: "error"
                            }).then((action) => {
                                mdlValesZapatoTiendas.find('#EmpleadoZapTda')[0].selectize.clear(true);
                                mdlValesZapatoTiendas.find('#EmpleadoZapTda')[0].selectize.focus();
                            });
                        } else if (parseFloat(data[0].DiasAlta) < 30) {
                            swal({
                                title: "NO AUTORIZADO",
                                text: "EL EMPLEADO DEBE DE TENER MÍNIMO UN MES LABORADO",
                                icon: "error"
                            }).then((action) => {
                                mdlValesZapatoTiendas.find('#EmpleadoZapTda')[0].selectize.clear(true);
                                mdlValesZapatoTiendas.find('#EmpleadoZapTda')[0].selectize.focus();
                            });
                        } else {
                            //Entra ok
                            mdlValesZapatoTiendas.find('#btnImprimir').focus();
                        }
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "NO EXISTEN DATOS DEL EMPLEADO",
                            icon: "error"
                        }).then((action) => {
                            mdlValesZapatoTiendas.find('#EmpleadoZapTda')[0].selectize.clear(true);
                            mdlValesZapatoTiendas.find('#EmpleadoZapTda')[0].selectize.focus();
                        });
                    }
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });
        });

        mdlValesZapatoTiendas.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var empl = mdlValesZapatoTiendas.find('#EmpleadoZapTda').val();
            $.get(base_url + 'index.php/ReportesNominaJasper/onImprimirValeZapTda', {Empleado: empl}).done(function (data, x, jq) {
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
                        mdlValesZapatoTiendas.find('#EmpleadoZapTda')[0].selectize.focus();
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

    function getEmpleadosZapTda() {
        $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getEmpleadosGeneral').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlValesZapatoTiendas.find("#EmpleadoZapTda")[0].selectize.addOption({text: v.Empleado, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }
</script>


