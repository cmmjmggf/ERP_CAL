<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Material a Entregar por Control
                </legend>
            </div>
            <div class="col-sm-4" align="right">
                <button type="button" class="btn btn-warning btn-sm" id="btnReporteMaqSem" >
                    <i class="fa fa-print"></i> IMPRIMIR POR SEM-MAQ-AÑO
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-3 col-md-3 col-lg-2 col-xl-2">
                <label for="Control" >Control*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="10" id="Control" name="Control" required="">
            </div>
            <div class="col-6 col-sm-5 col-md-4 col-lg-4 col-xl-4 mt-4">
                <button type="button" class="btn btn-primary  selectNotEnter" id="btnAceptar" data-toggle="tooltip" data-placement="top" title="Agregar Control">
                    <i class="fa fa-save"></i> ACEPTAR
                </button>
                <button type="button" class="btn btn-success  selectNotEnter" id="btnImprimir" data-toggle="tooltip" data-placement="right" title="Imprimir Reporte">
                    <i class="fa fa-print"></i> IMPRIMIR
                </button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Controles" class="table-responsive">
                <table id="tblControles" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th class="">ID</th>
                            <th>Control</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal " id="mdlMaterialParaEntregaMaqSemAno"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Material a Entregar por Maq-Sem-Año</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row">
                        <div class="col-4 col-sm-4">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                        <div class="col-4 col-sm-4">
                            <label>Sem</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" >
                        </div>
                        <div class="col-4 col-sm-4">
                            <label>Maq</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Maq" name="Maq" >
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-12 col-sm-8">
                            <label>Tipo <span class="badge badge-info mb-2" style="font-size: 12px;">10 Piel/Forro, 80 Suela, 90 Peletería</span></label>
                            <select class="form-control form-control-sm required selectize" id="Tipo" name="Tipo" >
                                <option value=""></option>
                                <option value="0">TODO</option>
                                <option value="10">10 PIEL Y FORRO</option>
                                <option value="80">80 SUELA</option>
                                <option value="90">90 INDIRECTOS</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimirSemMaqAno">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>


<script>
    var master_url = base_url + 'index.php/MaterialControlFecha/';
    var pnlTablero = $("#pnlTablero");
    var btnAceptar = pnlTablero.find('#btnAceptar');
    var btnImprimir = pnlTablero.find('#btnImprimir');
    var btnReporteMaqSem = pnlTablero.find('#btnReporteMaqSem');
    var tblControles = pnlTablero.find('#tblControles');
    var Controles;
    var n = 1;
    var mdlMaterialParaEntregaMaqSemAno = $('#mdlMaterialParaEntregaMaqSemAno');
    var btnImprimirSemMaqAno = mdlMaterialParaEntregaMaqSemAno.find('#btnImprimirSemMaqAno');
    var valida = false;
    $(document).ready(function () {

        handleEnter();
        init();
        pnlTablero.find('#Control').keydown(function (e) {
            if (e.keyCode === 13) {
                valida = false;
                var control = $(this).val().toString();
                if (control !== '') {
                    //---------------Consultar Contro en pedido-------------------
                    $.getJSON(master_url + 'getPedidoByControl', {
                        Control: control
                    }).done(function (data) {
                        if (data.length > 0) { //Si el control existe
                            valida = true;
                            //---------------Consultar orden de produccion por control-------------------
                            $.getJSON(master_url + 'getOrdenProduccionByControl', {
                                Control: control
                            }).done(function (data) {
                                if (data.length > 0) { //Si la orden existe
                                    //btnAceptar.trigger('click');
                                    btnAceptar.focus();
                                } else { //Si el orden existe
                                    swal({
                                        title: "ATENCIÓN",
                                        text: "LA ORDEN DE PRODUCCIÓN PARA EL CONTROL " + control + " NO EXISTE ",
                                        icon: "warning",
                                        closeOnClickOutside: false,
                                        closeOnEsc: false
                                    }).then((action) => {
                                        if (action) {
                                            pnlTablero.find('#Control').val('').focus();
                                        }
                                    });
                                }
                            });
                        } else { //Si el control no existe
                            swal({
                                title: "ATENCIÓN",
                                text: "EL CONTROL " + control + " NO EXISTE ",
                                icon: "warning",
                                closeOnClickOutside: false,
                                closeOnEsc: false
                            }).then((action) => {
                                if (action) {
                                    pnlTablero.find('#Control').val('').focus();
                                }
                            });
                        }
                    });
                }
            }
        });
        btnAceptar.click(function () {

            var control = pnlTablero.find('#Control').val();
            if (control !== '') {
                var existe = false;
                if (pnlTablero.find("#tblControles tbody tr").length > 0) {
                    Controles.rows().every(function (rowIdx, tableLoop, rowLoop) {
                        var data = this.data();
                        if (data[1] === control) {
                            existe = true;
                            return false;
                        }
                    });
                }
                if (!existe) {
                    n = (n > 0) ? n : 1;
                    Controles.row.add([
                        n,
                        control,
                        '<button type="button" class="btn btn-danger btn-sm selectNotEnter" onclick="onEliminarRenglon(this)" title="Eliminar"><i class="fa fa-trash"></i> </button>'
                    ]).draw(false);
                    n += 1;
                    pnlTablero.find('#Control').val('').focus();
                } else {
                    swal({
                        title: "ERROR",
                        text: "YA SE HA AGREGADO ESTE CONTROL, INTRODUCE OTRO",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        if (action) {
                            pnlTablero.find('#Control').val('').focus();
                        }
                    });
                }

            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBE DE INTRODUCIR UN CONTROL ",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    if (action) {
                        pnlTablero.find('#Control').val('').focus();
                    }
                });
            }


        });
        btnImprimir.click(function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var detalle = [];
            //Destruye la instancia de datatable
            if ($.fn.DataTable.isDataTable('#tblControles')) {
                Controles.destroy();
            }

            //Iteramos en la tabla natural
            pnlTablero.find("#tblControles > tbody > tr").each(function (k, v) {
                var row = $(this).find("td");
                //Se declara y llena el objeto obteniendo su valor por el indice y se elimina cualquier espacio
                var controles = {
                    Control: row.eq(1).text().replace(/\s+/g, '')
                };
                //Se mete el objeto al arreglo
                detalle.push(controles);
            });

            //Imprimir
            $.post(master_url + 'onImprimirReportePorControlDepartamento', {
                Controles: JSON.stringify(detalle)
            }).done(function (data) {
                console.log(data);
                if (data.length > 0) {
                    $.fancybox.open({
                        src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
                        type: 'iframe',
                        opts: {
                            afterShow: function (instance, current) {
                                console.info('done!');

                            },
                            afterClose: function () {
                                init();
                                onNotifyOld('fa fa-check', 'REPORTE GENERADO', 'success');
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
                    HoldOn.close();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA EL REPORTE",
                        icon: "error"
                    });
                    HoldOn.close();
                }
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });


        });

        /*Reporte pro maq-sem-año*/
        setFocusSelectToInputOnChange('#Tipo', '#btnImprimirSemMaqAno', mdlMaterialParaEntregaMaqSemAno);
        mdlMaterialParaEntregaMaqSemAno.on('shown.bs.modal', function () {
            mdlMaterialParaEntregaMaqSemAno.find("input").val("");
            $.each(mdlMaterialParaEntregaMaqSemAno.find("select"), function (k, v) {
                mdlMaterialParaEntregaMaqSemAno.find("select")[k].selectize.clear(true);
            });
            mdlMaterialParaEntregaMaqSemAno.find('#Ano').focus();
        });
        mdlMaterialParaEntregaMaqSemAno.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2016 || parseInt($(this).val()) > 2020 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    mdlMaterialParaEntregaMaqSemAno.find("#Ano").val("").focus();
                });
            }
        });
        mdlMaterialParaEntregaMaqSemAno.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlMaterialParaEntregaMaqSemAno.find("#Sem").change(function () {
            var ano = mdlMaterialParaEntregaMaqSemAno.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
        btnReporteMaqSem.click(function () {
            mdlMaterialParaEntregaMaqSemAno.modal('show');
        });
        btnImprimirSemMaqAno.click(function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var ano = mdlMaterialParaEntregaMaqSemAno.find('#Ano').val();
            var sem = mdlMaterialParaEntregaMaqSemAno.find('#Sem').val();
            var maq = mdlMaterialParaEntregaMaqSemAno.find('#Maq').val();
            var tipo = mdlMaterialParaEntregaMaqSemAno.find('#Tipo').val();

            var reporte = '';
            if (tipo === '' || tipo === '0') {
                reporte = 'onImprimirReportePorAnoSemMaq';
            } else {
                reporte = 'onImprimirReportePorAnoSemMaqPorDepartamento';
            }


            //Imprimir
            $.post(master_url + reporte, {
                Ano: ano,
                Sem: sem,
                Maq: maq,
                Tipo: tipo
            }).done(function (data) {
                console.log(data);
                if (data.length > 0) {
                    $.fancybox.open({
                        src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
                        type: 'iframe',
                        opts: {
                            afterShow: function (instance, current) {
                                console.info('done!');
                            },
                            afterClose: function () {
                                onNotifyOld('fa fa-check', 'REPORTE GENERADO', 'success');
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
                    HoldOn.close();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA EL REPORTE",
                        icon: "error"
                    });
                    HoldOn.close();
                }
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });

    function onEliminarRenglon(v) {
        $(v).parent().parent().remove();
        Controles.row($(v).parent().parent()).remove().draw();
    }
    function init() {
        pnlTablero.find('#Control').focus();
        pnlTablero.find("#tblControles > tbody").html("");
        Controles = tblControles.DataTable({
            "dom": 'rti',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 30,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": true
                }],
            "aaSorting": [
                [0, 'desc']
            ]
        });
        pnlTablero.find('#tblControles tbody').on('click', 'tr', function () {
            pnlTablero.find("#tblControles tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        n = 1;
    }

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
