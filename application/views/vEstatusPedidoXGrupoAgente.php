<div class="modal " id="mdlEstatusPedidoXGrupoAgente"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estatus del Pedido Por Grupo ó Agente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6" id="dAgente">
                            <label>Agente</label>
                            <select id="Agente" name="Agente" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="badge badge-info" style="font-size:14px;">Si deseas imprimir por grupo, haz click aquí</label>
                        </div>
                        <div class="col-12">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="bEsPEdXGrupo" name="bEsPEdXGrupo">
                                <label class="custom-control-label text-info labelCheck" for="bEsPEdXGrupo">Imprimir X Grupo</label>
                            </div>
                        </div>
                        <div class="col-6 d-none" id="dGrupo">
                            <label>Grupo</label>
                            <select id="Grupo" name="Grupo" class="form-control form-control-sm required">
                                <option value=""></option>
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
    var mdlEstatusPedidoXGrupoAgente = $('#mdlEstatusPedidoXGrupoAgente');
    $(document).ready(function () {
        mdlEstatusPedidoXGrupoAgente.on('shown.bs.modal', function () {
            handleEnterDiv(mdlEstatusPedidoXGrupoAgente);
            mdlEstatusPedidoXGrupoAgente.find("input").val("");
            $.each(mdlEstatusPedidoXGrupoAgente.find("select"), function (k, v) {
                mdlEstatusPedidoXGrupoAgente.find("select")[k].selectize.clear(true);
            });
            getAgentes();
            getGruposClientes();

            mdlEstatusPedidoXGrupoAgente.find('#Agente')[0].selectize.focus();
        });
        mdlEstatusPedidoXGrupoAgente.find("#bEsPEdXGrupo").change(function () {
            if (mdlEstatusPedidoXGrupoAgente.find("#bEsPEdXGrupo")[0].checked) {
                mdlEstatusPedidoXGrupoAgente.find("#dGrupo").removeClass('d-none');
                mdlEstatusPedidoXGrupoAgente.find("#dAgente").addClass('d-none');
            } else {
                mdlEstatusPedidoXGrupoAgente.find("#dAgente").removeClass('d-none');
                mdlEstatusPedidoXGrupoAgente.find("#dGrupo").addClass('d-none');
            }
        });

        mdlEstatusPedidoXGrupoAgente.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var frm = new FormData(mdlEstatusPedidoXGrupoAgente.find("#frmCaptura")[0]);
            var esGpo = mdlEstatusPedidoXGrupoAgente.find("#bEsPEdXGrupo")[0].checked ? '1' : '0';
            frm.append('EsPorGrupo', esGpo);
            $.ajax({
                url: base_url + 'index.php/ReportesProduccionJasper/onReporteEstatusPedidoXGrupoAgente',
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
                        mdlEstatusPedidoXGrupoAgente.find('#Agente')[0].selectize.focus();
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
        mdlEstatusPedidoXGrupoAgente.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2000 || parseInt($(this).val()) > 2040 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    mdlEstatusPedidoXGrupoAgente.find("#Ano").val("");
                    mdlEstatusPedidoXGrupoAgente.find("#Ano").focus();
                });
            }
        });
    });

    function getGruposClientes() {
        $.getJSON(base_url + 'index.php/GruposClientes/' + 'getGruposClientes').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlEstatusPedidoXGrupoAgente.find("#Grupo")[0].selectize.addOption({text: v.gruposclientes, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getAgentes() {
        $.getJSON(base_url + 'index.php/Agentes/' + 'getAgentesSelect').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlEstatusPedidoXGrupoAgente.find("#Agente")[0].selectize.addOption({text: v.Agente, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }


</script>


