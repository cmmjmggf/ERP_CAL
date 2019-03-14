<div class="modal " id="mdlCapturaConteoInvFisico"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Captura Inventario Físico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6">
                            <label>Almacen/Maquila <span class="badge badge-warning mb-2" style="font-size: 12px;">Sólo Almacén [1] y Sub-Almacén [97]</span></label>
                            <select class="form-control form-control-sm required" id="Maq" name="Maq" >
                                <option value=""></option>
                                <option value="articulos">1 Almacén General</option>
                                <option value="articulos10">97 Sub Almacén</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Mes </label>
                            <select class="form-control form-control-sm required" id="Mes" name="Mes" >
                                <option value=""></option>
                                <option value="Ene">1 Enero</option>
                                <option value="Feb">2 Febrero</option>
                                <option value="Mar">3 Marzo</option>
                                <option value="Abr">4 Abril</option>
                                <option value="May">5 Mayo</option>
                                <option value="Jun">6 Junio</option>
                                <option value="Jul">7 Julio</option>
                                <option value="Ago">8 Agosto</option>
                                <option value="Sep">9 Septiembre</option>
                                <option value="Oct">10 Octubre</option>
                                <option value="Nov">11 Noviembre</option>
                                <option value="Dic">12 Diciembre</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <label>Artículo</label>
                            <select class="form-control form-control-sm" id="Articulo" name="Articulo" >
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Unidad </label>
                            <input type="text" maxlength="5" class="form-control form-control-sm numbersOnly" readonly="" id="Unidad" name="Unidad" >
                        </div>
                        <div class="col-6">
                            <label>Existencia Capturada</label>
                            <input type="text" maxlength="5" class="form-control form-control-sm numbersOnly" readonly="" id="ExistenciaCapturada" name="ExistenciaCapturada" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Existencia Física </label>
                            <input type="text" maxlength="5" class="form-control form-control-sm numbersOnly" id="ExistenciaFisica" name="ExistenciaFisica" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptar">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlCapturaConteoInvFisico = $('#mdlCapturaConteoInvFisico');
    var precio_Art = 0;
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlCapturaConteoInvFisico);
        setFocusSelectToSelectOnChange('#Maq', '#Mes', mdlCapturaConteoInvFisico);
        setFocusSelectToSelectOnChange('#Mes', '#Articulo', mdlCapturaConteoInvFisico);
        setFocusSelectToInputOnChange('#Articulo', '#ExistenciaFisica', mdlCapturaConteoInvFisico);
        mdlCapturaConteoInvFisico.on('shown.bs.modal', function () {
            mdlCapturaConteoInvFisico.find("input").val("");
            $.each(mdlCapturaConteoInvFisico.find("select"), function (k, v) {
                mdlCapturaConteoInvFisico.find("select")[k].selectize.clear(true);
            });
            getArticulosConteo();
            mdlCapturaConteoInvFisico.find('#Maq')[0].selectize.focus();
        });

        mdlCapturaConteoInvFisico.find("#Articulo").change(function () {
            var maq = mdlCapturaConteoInvFisico.find("#Maq").val();
            var mes = mdlCapturaConteoInvFisico.find("#Mes").val();

            if (mes !== '' && maq !== '') {
                $.getJSON(base_url + 'index.php/CapturaInventarios/getInfoArticulo', {Articulo: $(this).val(), Maq: maq, Mes: mes}).done(function (data) {
                    precio_Art = data[0].Precio;
                    mdlCapturaConteoInvFisico.find("#Unidad").val(data[0].Unidad);
                    mdlCapturaConteoInvFisico.find("#ExistenciaCapturada").val((data[0].ExistenciaCapturada === null) ? 0 : data[0].ExistenciaCapturada);
                }).fail(function (x) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "Completa los campos de almacén y maquila",
                    icon: "error",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    mdlCapturaConteoInvFisico.find("#Articulo")[0].selectize.clear(true);
                    mdlCapturaConteoInvFisico.find("#Articulo")[0].selectize.focus();
                });
            }
        });

        mdlCapturaConteoInvFisico.find('#btnAceptar').on("click", function () {
            //HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlCapturaConteoInvFisico.find("#frmCaptura")[0]);
            frm.append('Precio', precio_Art);
            $.ajax({
                url: base_url + 'index.php/CapturaInventarios/onCapturarConteoInvFisico',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                mdlCapturaConteoInvFisico.find("input").val("");
                mdlCapturaConteoInvFisico.find("#Articulo")[0].selectize.clear(true);
                mdlCapturaConteoInvFisico.find("#Articulo")[0].selectize.focus();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            });

        });
    });

    function getArticulosConteo() {
        mdlCapturaConteoInvFisico.find("#Articulo")[0].selectize.clear(true);
        mdlCapturaConteoInvFisico.find("#Articulo")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/CapturaInventarios/getArticulos').done(function (data) {
            $.each(data, function (k, v) {
                mdlCapturaConteoInvFisico.find("#Articulo")[0].selectize.addOption({text: v.Articulo, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
</script>