<div class="modal " id="mdlOrdenesCompraSemMaq"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Órdenes de Compra Fincadas-No Entregadas y con Saldo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">

                    <div class="row">
                        <div class="col-3">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoOCMaqSem" name="AnoOCMaqSem" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>De la maq.</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="MaqOCMaqSem" name="MaqOCMaqSem" >
                        </div>
                        <div class="col-3">
                            <label>A la maq.</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="aMaqOCMaqSem" name="aMaqOCMaqSem" >
                        </div>
                        <div class="col-3">
                            <label>De la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="SemOCMaqSem" name="SemOCMaqSem" >
                        </div>
                        <div class="col-3">
                            <label>A la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="aSemOCMaqSem" name="aSemOCMaqSem" >
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label>Tipo <span class="badge badge-info mb-2" style="font-size: 12px;">10 Piel/Forro, 80 Suela, 90 Peletería</span></label>
                            <select class="form-control form-control-sm required selectize" id="TipoOCMaqSem" name="TipoOCMaqSem" >
                                <option value=""></option>
                                <option value="10">10 PIEL Y FORRO</option>
                                <option value="80">80 SUELA</option>
                                <option value="90">90 INDIRECTOS</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="Clave" >Tp</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpOCMaqSem" name="TpOCMaqSem" required="">
                        </div>
                        <div class="col-10">
                            <label for="" >Proveedor</label>
                            <select id="ProveedorOCMaqSem" name="ProveedorOCMaqSem" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                            </select>
                        </div>


                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="cSaldoPendiente">
                                <label class="custom-control-label text-info labelCheck" for="cSaldoPendiente">Con Saldo Pendiente</label>
                            </div>
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
    var mdlOrdenesCompraSemMaq = $('#mdlOrdenesCompraSemMaq');
    $(document).ready(function () {
        mdlOrdenesCompraSemMaq.on('shown.bs.modal', function () {
            handleEnterDiv(mdlOrdenesCompraSemMaq);
            mdlOrdenesCompraSemMaq.find("input").val("");
            $.each(mdlOrdenesCompraSemMaq.find("select"), function (k, v) {
                mdlOrdenesCompraSemMaq.find("select")[k].selectize.clear(true);
            });
            mdlOrdenesCompraSemMaq.find('#AnoOCMaqSem').focus();
        });
        mdlOrdenesCompraSemMaq.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlOrdenesCompraSemMaq.find("#frmCaptura")[0]);

            var cSaldoPendiente = mdlOrdenesCompraSemMaq.find("#cSaldoPendiente")[0].checked ? '1' : '0';

            frm.append('cSaldoPendiente', cSaldoPendiente);

            $.ajax({
                url: base_url + 'index.php/ReportesOrdenesCompraJasper/onImprimirOrdenesCompraMaqSemAno',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {

                    $.fancybox.open({
                        src: data,
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
                        mdlOrdenesCompraSemMaq.find('#AnoOCMaqSem').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        mdlOrdenesCompraSemMaq.find("#TpOCMaqSem").change(function () {
            if ($(this).val()) {
                var tp = parseInt($(this).val());
                if (tp === 1 || tp === 2) {

                    getProveedoresOCMaqSem(tp);
                    mdlOrdenesCompraSemMaq.find('#ProveedorOCMaqSem')[0].selectize.focus();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        buttons: false,
                        timer: 1000
                    }).then((action) => {
                        $(this).val('').focus();
                    });
                }
            } else {
                mdlOrdenesCompraSemMaq.find("#ProveedorOCMaqSem")[0].selectize.clear(true);
                mdlOrdenesCompraSemMaq.find("#ProveedorOCMaqSem")[0].selectize.clearOptions();
            }
        });
        mdlOrdenesCompraSemMaq.find("#AnoOCMaqSem").change(function () {
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
                    mdlOrdenesCompraSemMaq.find("#AnoOCMaqSem").val("");
                    mdlOrdenesCompraSemMaq.find("#AnoOCMaqSem").focus();
                });
            }
        });
        mdlOrdenesCompraSemMaq.find("#MaqOCMaqSem").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlOrdenesCompraSemMaq.find("#aMaqOCMaqSem").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlOrdenesCompraSemMaq.find("#SemOCMaqSem").change(function () {
            var ano = mdlOrdenesCompraSemMaq.find("#AnoOCMaqSem");
            onComprobarSemanasProduccion($(this), ano.val());
        });
        mdlOrdenesCompraSemMaq.find("#aSemOCMaqSem").change(function () {
            var ano = mdlOrdenesCompraSemMaq.find("#AnoOCMaqSem");
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
    function getProveedoresOCMaqSem(tp) {
        mdlOrdenesCompraSemMaq.find("#ProveedorOCMaqSem")[0].selectize.clear(true);
        mdlOrdenesCompraSemMaq.find("#ProveedorOCMaqSem")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/NotasCargo/getProveedoresConClave').done(function (data) {
            $.each(data, function (k, v) {
                mdlOrdenesCompraSemMaq.find("#ProveedorOCMaqSem")[0].selectize.addOption({text: (tp === 1) ? v.ProveedorF : v.ProveedorI, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

</script>