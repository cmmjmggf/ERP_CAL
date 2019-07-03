<div class="modal " id="mdlTipoCambio"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tipo de Cambio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmTipoCambio">
                    <div class="row">
                        <div class="col-12">
                            <label>Consulta Online</label>
                            <a id="iframe"class="btn btn-warning" href="http://www.sistemascasa.com.mx/informacion_indicadores_5.php">
                                <i class="fab fa-internet-explorer"></i> IR AL SITIO WEB
                            </a>
                        </div>
                        <div class="col-12">
                            <label>Dolar</label>
                            <input type="text" maxlength="5" class="form-control form-control-sm numbersOnly" id="Dolar" name="Dolar" >
                        </div>
                        <div class="col-12">
                            <label>Euro</label>
                            <input type="text" maxlength="5" class="form-control form-control-sm numbersOnly" id="Euro" name="Euro" >
                        </div>
                        <div class="col-12">
                            <label>Libra</label>
                            <input type="text" maxlength="5" class="form-control form-control-sm numbersOnly" id="Libra" name="Libra" >
                        </div>
                        <div class="col-12">
                            <label>Jen</label>
                            <input type="text" maxlength="5" class="form-control form-control-sm numbersOnly" id="Jen" name="Jen" >
                        </div>


                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnGuardarTipoCambio">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>

    var mdlTipoCambio = $('#mdlTipoCambio');
    $(document).ready(function () {

        $("#iframe").fancybox({
            'width': '75%',
            'height': '75%',
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none',
            'type': 'iframe',
            iframe: {
                preload: false
            }
        });
        mdlTipoCambio.on('shown.bs.modal', function () {
            handleEnterDiv(mdlTipoCambio);
            mdlTipoCambio.find("input").val("");
            getTipoCambio();

        });

        mdlTipoCambio.find('#btnGuardarTipoCambio').on("click", function () {
            var frm = new FormData(mdlTipoCambio.find("#frmTipoCambio")[0]);
            $.ajax({
                url: base_url + 'index.php/TipoCambio/onModificar',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                swal({
                    title: "ATENCIÓN",
                    text: "REGISTROS GUARDADOS",
                    icon: "success"
                }).then((action) => {
                    mdlTipoCambio.find('#btnSalir').focus();
                });
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

    });

    function getTipoCambio() {
        $.getJSON(base_url + 'index.php/TipoCambio/getTipoCambio').done(function (data, x, jq) {
            $.each(data[0], function (k, v) {
                mdlTipoCambio.find("[name='" + k + "']").val(v);
            });
            mdlTipoCambio.find('#Dolar').focus().select();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }


</script>