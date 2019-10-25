<div class="modal " id="mdlExplosionSemanal"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Explosión Semanal de Materiales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row">
                        <div class="col-12">
                            <label class="text-danger">Nota. El % extra (PIEL Y FORRO) se tomará del No. de piezas del Estilo</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>De la maq.</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="Maq" name="Maq" >
                        </div>
                        <div class="col-6">
                            <label>A la maq.</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="aMaq" name="aMaq" >
                        </div>
                        <div class="col-6">
                            <label>De la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" >
                        </div>
                        <div class="col-6">
                            <label>A la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="aSem" name="aSem" >
                        </div>

                    </div>
                    <div class="w-100 mt-2"></div>
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <label>Tipo <span class="badge badge-info mb-2" style="font-size: 12px;">10 Piel/Forro, 80 Suela, 90 Peletería</span></label>
                            <select class="form-control form-control-sm required selectize" id="Tipo" name="Tipo" >
                                <option value=""></option>
                                <option value="10">10 PIEL Y FORRO</option>
                                <option value="80">80 SUELA</option>
                                <option value="90">90 INDIRECTOS</option>
                                <option value="0">80 SUELA C/ DESGLOSE</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="selectPiel">
                                <label class="custom-control-label text-info labelCheck" for="selectPiel">Con Selección de Piel</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="FaltanteCorte" >
                                <label class="custom-control-label text-info labelCheck" for="FaltanteCorte">Lo faltante X Cortar</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="SinClasif" name="SinClasif" >
                                <label class="custom-control-label text-info labelCheck" for="SinClasif">S/ 1ras 2das 3ras</label>
                            </div>
                        </div>

                        <div class="col-12 col-sm-12 mt-2">
                            <legend class="badge badge-danger" style="font-size: 14px;">Para maquila 98 sale con precios de compra y venta</legend>
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
    var mdlExplosionSemanal = $('#mdlExplosionSemanal');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlExplosionSemanal);
        setFocusSelectToInputOnChange('#Tipo', '#btnImprimir', mdlExplosionSemanal);
        mdlExplosionSemanal.on('shown.bs.modal', function () {
            handleEnterDiv(mdlExplosionSemanal);
            mdlExplosionSemanal.find("input").val("");
            $.each(mdlExplosionSemanal.find("select"), function (k, v) {
                mdlExplosionSemanal.find("select")[k].selectize.clear(true);
            });
            mdlExplosionSemanal.find('#Ano').focus();
        });

        mdlExplosionSemanal.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});

            var Tipo = parseInt(mdlExplosionSemanal.find('#Tipo').val());
            var Reporte = '';

            if (Tipo === 10 || Tipo === 80 || Tipo === 90) {
                Reporte = 'index.php/Explosiones/onReporteExplosionSemana';
            } else {
                Reporte = 'index.php/Explosiones/onReporteExplosionSemanaSuelaDesglose';
            }

            var frm = new FormData(mdlExplosionSemanal.find("#frmExplosion")[0]);
            var SinClasif = mdlExplosionSemanal.find("#SinClasif")[0].checked ? '1' : '0';

            frm.append('SinClasif', SinClasif);
            $.ajax({
                url: base_url + Reporte,
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
                        text: "NO EXISTEN PROGRAMACION DE LA SEMANA/MAQUILA",
                        icon: "error"
                    }).then((action) => {
                        mdlExplosionSemanal.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        mdlExplosionSemanal.find("#Ano").change(function () {
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
                    mdlExplosionSemanal.find("#Ano").val("");
                    mdlExplosionSemanal.find("#Ano").focus();
                });
            }
        });
        mdlExplosionSemanal.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlExplosionSemanal.find("#aMaq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlExplosionSemanal.find("#Sem").change(function () {
            var ano = mdlExplosionSemanal.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
        mdlExplosionSemanal.find("#aSem").change(function () {
            var ano = mdlExplosionSemanal.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
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
    function onComprobarSemanasProduccion(v, ano) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {

            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA SEMANA " + $(v).val() + " DEL " + ano + " " + "NO EXISTE",
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