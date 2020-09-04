<div class="modal " id="mdlCierraInventarioMensual"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cierre mensual de materia prima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmReporte">
                    <div class="row">
                        <div class="col-12">
                            <label class="alert alert-info" style="font-size: 14px;">
                                Se le recuerda que si ya está correcto su inventario de materia prima
                                puede ejecutar este módulo si no es correcto favor de corregir los datos.
                                <br><br>
                                Este programa sólo de deberá ejecutar cada fin de mes
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label>Almacen/Maquila <span class="badge badge-warning mb-2" style="font-size: 12px;">Sólo Almacén [1] y Sub-Almacén [97]</span></label>
                            <select class="form-control form-control-sm required" id="Maq" name="Maq" >
                                <option value=""></option>
                                <option value="articulos">1 Almacén General</option>
                                <option value="articulos10">97 Sub Almacén</option>
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label>Mes a cerrar </label>
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
    var mdlCierraInventarioMensual = $('#mdlCierraInventarioMensual');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlCierraInventarioMensual);
        setFocusSelectToSelectOnChange('#Maq', '#Mes', mdlCierraInventarioMensual);
        setFocusSelectToInputOnChange('#Mes', '#btnAceptar', mdlCierraInventarioMensual);
        mdlCierraInventarioMensual.on('shown.bs.modal', function () {
            handleEnterDiv(mdlCierraInventarioMensual);
            mdlCierraInventarioMensual.find("input").val("");
            $.each(mdlCierraInventarioMensual.find("select"), function (k, v) {
                mdlCierraInventarioMensual.find("select")[k].selectize.clear(true);
            });
            mdlCierraInventarioMensual.find('#Maq')[0].selectize.focus();
        });

        mdlCierraInventarioMensual.find('#btnAceptar').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var mes = mdlCierraInventarioMensual.find('#Mes option:selected').text().toUpperCase();
            swal({

                title: "ESTÁS SEGURO?",
                text: "Desea cerrar el mes: [[ " + mes + " ]]?",
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then((action) => {
                if (action) {
                    var frm = new FormData(mdlCierraInventarioMensual.find("#frmReporte")[0]);
                    $.ajax({
                        url: base_url + 'index.php/CapturaInventarios/onCerrarMesInventario',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data, x, jq) {
                        console.log(data);
                        HoldOn.close();
                        swal({

                            title: "ATENCIÓN",
                            text: "El mes: [[" + mes + "]] se ha cerrado con éxito",
                            icon: "success",
                            closeOnEsc: false,
                            closeOnClickOutside: false
                        }).then((action) => {
                            mdlCierraInventarioMensual.modal('hide');
                        });
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                        HoldOn.close();
                    });
                } else {
                    HoldOn.close();
                }
            });


        });
    });
</script>
