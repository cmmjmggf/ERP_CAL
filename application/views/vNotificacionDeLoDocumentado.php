<div id="mdlNotificacionDeLoDocumentado" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered notdraggable" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-exclamation"></span> Notificación de lo documentado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding-top: 0px;">
                <div class="row">
                    <div class="col-12">
                        <label class="control-label">Cliente</label>
                        <div class="row">
                            <div class="col-12 col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                                <input type="text" id="ClienteClaveNDOC" name="ClienteClaveNDOC" autofocus="" class="form-control form-control-sm" placeholder="CLAVE">
                            </div>
                            <div class="col-12 col-xs-12 col-sm-9 col-md-9 col-lg-9 col-xl-9" >
                                <select id="ClienteFacturaNDOC" name="ClienteFacturaNDOC" class="form-control form-control-sm">
                                    <option></option>
                                    <?php
//                                YA CONTIENE LOS BLOQUEOS DE VENTA
                                    foreach ($this->db->query("SELECT C.Clave AS CLAVE, C.RazonS AS CLIENTE, C.Zona AS ZONA, C.ListaPrecios AS LISTADEPRECIO FROM clientes AS C LEFT JOIN bloqueovta AS B ON C.Clave = B.cliente WHERE C.Estatus IN('ACTIVO') AND B.cliente IS NULL  OR C.Estatus IN('ACTIVO') AND B.`status` = 2 ORDER BY ABS(C.Clave) ASC;")->result() as $k => $v) {
                                        print "<option value='{$v->CLAVE}' lista='{$v->LISTADEPRECIO}' zona='{$v->ZONA}'>{$v->CLIENTE}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <label>Docto</label>
                        <input type="text" id="DoctoNDOC" name="DoctoNDOC" class="form-control form-control-sm" maxlength="35">
                    </div>
                    <div class="col-2">
                        <label>TP</label>
                        <input type="text" id="TPNDOC" name="TPNDOC" class="form-control form-control-sm numbersOnly" maxlength="1">
                    </div>
                    <div class="col-6">
                        <label>Talon</label>
                        <input type="text" id="Talon" name="Talon" class="form-control form-control-sm" maxlength="35">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-2">
                        <label>Cajas</label>
                        <input type="text" id="CajasNDOC" name="CajasNDOC" class="form-control form-control-sm numbersOnly" maxlength="7">
                    </div>
                    <div class="col-9">
                        <label class="control-label">Transporte</label>
                        <div class="row">
                            <div class="col-12 col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4" >
                                <input type="text" id="ClaveTransporteNDOC" name="ClaveTransporteNDOC" autofocus="" class="form-control form-control-sm" placeholder="CLAVE">
                            </div>
                            <div class="col-12 col-xs-12 col-sm-8 col-md-8 col-lg-8 col-xl-8" >
                                <select id="TransporteNDOC" name="TransporteNDOC" class="form-control form-control-sm">
                                    <option></option>
                                    <?php
//                                YA CONTIENE LOS BLOQUEOS DE VENTA
                                    foreach ($this->db->query("SELECT T.Clave AS CLAVE, T.Descripcion AS TRANSPORTE  FROM transportes AS T WHERE T.Estatus IN('ACTIVO')  ORDER BY ABS(T.Descripcion) ASC;")->result() as $k => $v) {
                                        print "<option value='{$v->CLAVE}' >{$v->TRANSPORTE}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <label class="text-danger font-weight-bold">Transporte</label>
                        <span class="font-weight-bold">
                            1 = Noreste michoacan 2 = T-Rodriguez 3 = Inter Bajío
                        </span>
                    </div>
                    <div class="col-4">
                        <input type="text" id="Transporte123" name="Transporte123" class="form-control form-control-sm numbersOnly" maxlength="1">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12">
                        <table id="tblDocumentos" class="table table-hover table-sm" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <!--0 -->
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Docto</th>
                                    <th scope="col">TP</th>
                                    <th scope="col">Talon</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Pares</th>
                                    <th scope="col">Caja</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col">Tra</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-4 justify-content-center text-center">
                        <button type="button" class="btn btn-info" id="btnAceptaNDOC">
                            <span class="fa fa-save"></span> Acepta</button>
                    </div>
                    <div class="col-4 justify-content-center text-center">
                        <button type="button" class="btn btn-info d-none" id="btnImprimeNDOC">
                            <span class="fa fa-print"></span> Imprime</button>
                    </div>
                    <div class="col-4 justify-content-center text-center">
                        <button type="button" class="btn btn-info" id="btnMovimientoNDOC">
                            <span class="fa fa-recycle"></span> Movimiento</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlNotificacionDeLoDocumentado = $("#mdlNotificacionDeLoDocumentado"),
            ClienteFacturaNDOC = mdlNotificacionDeLoDocumentado.find("#ClienteFacturaNDOC"),
            ClienteClaveNDOC = mdlNotificacionDeLoDocumentado.find("#ClienteClaveNDOC"),
            DoctoNDOC = mdlNotificacionDeLoDocumentado.find("#DoctoNDOC"),
            ClaveTransporteNDOC = mdlNotificacionDeLoDocumentado.find("#ClaveTransporteNDOC"),
            TransporteNDOC = mdlNotificacionDeLoDocumentado.find("#TransporteNDOC"),
            TPNDOC = mdlNotificacionDeLoDocumentado.find("#TPNDOC"),
            CajasNDOC = mdlNotificacionDeLoDocumentado.find("#CajasNDOC"),
            Talon = mdlNotificacionDeLoDocumentado.find("#Talon"),
            btnAceptaNDOC = mdlNotificacionDeLoDocumentado.find("#btnAceptaNDOC"),
            tblDocumentos = mdlNotificacionDeLoDocumentado.find("#tblDocumentos"), Documentos,
            btnMovimientoNDOC = mdlNotificacionDeLoDocumentado.find("#btnMovimientoNDOC");

    $(document).ready(function () {
        handleEnterDiv(mdlNotificacionDeLoDocumentado);

        btnMovimientoNDOC.click(function () {
            onOpenWindowAFC('<?php print base_url('MovimientosCliente'); ?>', function () {
                ClienteClaveNDOC.focus().select();
            });
        });

        btnAceptaNDOC.click(function () {
            onDisable(btnAceptaNDOC);
            var p = {
                CLIENTE: ClienteClaveNDOC.val(),
                DOCUMENTO: DoctoNDOC.val(),
                TP: TPNDOC.val(),
                CAJAS: CajasNDOC.val(),
                TALON: Talon.val(),
                TRANSPORTE_CLAVE: ClaveTransporteNDOC.val(),
                TRANSPORTE: TransporteNDOC.find("option:selected").text()
            };
            if (ClienteClaveNDOC.val() === '' || ClienteFacturaNDOC.val() === ''
                    || DoctoNDOC.val() === '' || TPNDOC.val() === '') {
                onCampoInvalido(mdlNotificacionDeLoDocumentado, "POR FAVOR ESPECIFIQUE UN CLIENTE, UN DOCUMENTO Y UN TIPO(TP)", function () {
                    if (ClienteClaveNDOC.val() === '') {
                        ClienteClaveNDOC.focus().select();
                    } else if (DoctoNDOC.val() === '') {
                        DoctoNDOC.focus().select();
                    } else if (TPNDOC.val() === '') {
                        TPNDOC.focus().select();
                    }
                });
                return;
            }
            $.post('<?php print base_url('NotificacionDeLoDocumentado/onNotificar'); ?>', p).done(function (a) {
                console.log(a);
                onNotifyOldPC('<span class="fa fa-check"></span>', 'NOTIFICACION COMPLETADA', 'success', {from: "bottom", align: "center"});
                onClearPanelInputSelect(mdlNotificacionDeLoDocumentado, function () {
                    ClienteClaveNDOC.focus().select();
                    Documentos.ajax.reload();
                    onEnable(btnAceptaNDOC);
//                    Documentos.ajax.reload(function () {
//                        if (Documentos.rows().count() > 0) {
//                            onEnable(btnAceptaNDOC);
//                        } else {
//                            onDisable(btnAceptaNDOC);
//                        }
//                    });
                });
            }).fail(function (x) {
                getError(x);
            }).always(function () {

            });
        });

        DoctoNDOC.on('keydown', function (e) {
            if (e.keyCode === 13 || e.keyCode === 8 || e.keyCode === 9 || e.keyCode === 46) {
//                Documentos.ajax.reload(function () {
//                    if (Documentos.rows().count() > 0) {
//                        onEnable(btnAceptaNDOC);
//                    } else {
//                        onDisable(btnAceptaNDOC);
//                    }
//                });
            }
        }).focusout(function () {
//            Documentos.ajax.reload(function () {
//                if (Documentos.rows().count() > 0) {
//                    onEnable(btnAceptaNDOC);
//                } else {
//                    onDisable(btnAceptaNDOC);
//                }
//            });
        });

        ClienteFacturaNDOC.change(function () {
            if (ClienteFacturaNDOC.val()) {
                ClienteClaveNDOC.val(ClienteFacturaNDOC.val());
                DoctoNDOC.focus().select();
            } else {
                ClienteClaveNDOC.val('');
                ClienteFacturaNDOC[0].selectize.enable();
                ClienteFacturaNDOC[0].selectize.clear(true);
            }
            Documentos.ajax.reload(function () {
                if (ClienteFacturaNDOC.val()) {
                    onEnable(ClienteFacturaNDOC);
                }
            });
        });

        ClienteClaveNDOC.on('keydown', function (e) {
            if (e.keyCode === 13 || e.keyCode === 9) {
                if (ClienteClaveNDOC.val()) {
                    ClienteFacturaNDOC[0].selectize.setValue(ClienteClaveNDOC.val());
                    if (ClienteFacturaNDOC.val()) {
                        onDisable(ClienteFacturaNDOC);
                    } else {
                        onCampoInvalido(mdlNotificacionDeLoDocumentado, 'NO EXISTE ESTE CLIENTE, ESPECIFIQUE OTRO', function () {
                            ClienteClaveNDOC.focus().select();
                        });
                    }
                } else {
                    ClienteFacturaNDOC[0].selectize.enable();
                    ClienteFacturaNDOC[0].selectize.clear(true);
                }
            } else {
                ClienteFacturaNDOC[0].selectize.enable();
                ClienteFacturaNDOC[0].selectize.clear(true);
//                Documentos.ajax.reload(function () {
//                    if (Documentos.rows().count() > 0) {
//                        onEnable(btnAceptaNDOC);
//                    } else {
//                        onDisable(btnAceptaNDOC);
//                    }
//                });
            }
        });

        TransporteNDOC.change(function () {
            if (TransporteNDOC.val()) {
                ClaveTransporteNDOC.val(TransporteNDOC.val());
            } else {
                ClaveTransporteNDOC.val('');
                TransporteNDOC[0].selectize.enable();
                TransporteNDOC[0].selectize.clear(true);
            }
//            Documentos.ajax.reload(function () {
//                if (Documentos.rows().count() > 0) {
//                    onEnable(btnAceptaNDOC);
//                } else {
//                    onDisable(btnAceptaNDOC);
//                }
//            });
        });

        ClaveTransporteNDOC.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (ClaveTransporteNDOC.val()) {
                    TransporteNDOC[0].selectize.setValue(ClaveTransporteNDOC.val());
                    if (TransporteNDOC.val()) {
                    } else {
                        onCampoInvalido(mdlNotificacionDeLoDocumentado, 'NO EXISTE ESTE TRANSPORTE, ESPECIFIQUE OTRO', function () {
                            ClaveTransporteNDOC.focus().select();
                        });
                    }
                } else {
                    TransporteNDOC[0].selectize.enable();
                    TransporteNDOC[0].selectize.clear(true);
                }
            } else {
                TransporteNDOC[0].selectize.enable();
                TransporteNDOC[0].selectize.clear(true);
            }
        });

        TPNDOC.keydown(function (e) {
            if (ClienteClaveNDOC.val()) {
                if (e.keyCode === 13 && parseInt(TPNDOC.val()) >= 1 && parseInt(TPNDOC.val()) <= 2) {
//                    Documentos.ajax.reload(function () {
//                        if (Documentos.rows().count() > 0) {
//                            onEnable(btnAceptaNDOC);
//                        } else {
//                            onDisable(btnAceptaNDOC);
//                        }
//                    });
                    return;
                } else if (e.keyCode === 13 && parseInt(TPNDOC.val()) >= 3) {
                    TPNDOC.focus().select();
                    onCampoInvalido(mdlNotificacionDeLoDocumentado, "SOLO SE PERMITE 1 Y 2", function () {
                        TPNDOC.focus().select();
                    });
                    return;
                }
            } else {
                onCampoInvalido(mdlNotificacionDeLoDocumentado, "DEBE DE ESPECIFICAR UN CLIENTE", function () {
                    ClienteClaveNDOC.focus().select();
                });
                return;
            }
        }).focusout(function () {
            if (ClienteClaveNDOC.val()) {
                if (parseInt(TPNDOC.val()) >= 1 && parseInt(TPNDOC.val()) <= 2) {
//                    Documentos.ajax.reload(function () {
//                        if (Documentos.rows().count() > 0) {
//                            onEnable(btnAceptaNDOC);
//                        } else {
//                            onDisable(btnAceptaNDOC);
//                        }
//                    });
                    return;
                } else if (parseInt(TPNDOC.val()) >= 3) {
                    TPNDOC.focus().select();
                    onCampoInvalido(mdlNotificacionDeLoDocumentado, "SOLO SE PERMITE 1 Y 2", function () {
                        TPNDOC.focus().select();
                    });
                    return;
                }
            } else {
                onCampoInvalido(mdlNotificacionDeLoDocumentado, "DEBE DE ESPECIFICAR UN CLIENTE", function () {
                    ClienteClaveNDOC.focus().select();
                });
                return;
            }
//            Documentos.ajax.reload(function () {
//                if (Documentos.rows().count() > 0) {
//                    onEnable(btnAceptaNDOC);
//                } else {
//                    onDisable(btnAceptaNDOC);
//                }
//            });
        });

        mdlNotificacionDeLoDocumentado.on('shown.bs.modal', function () {
            getDocumentos();
        });

        mdlNotificacionDeLoDocumentado.on('hidden.bs.modal', function () {
            onClearPanelInputSelect(mdlNotificacionDeLoDocumentado, function () {});
        });
    });

    function getDocumentos() {
        ClienteClaveNDOC.focus().select();
        if ($.fn.DataTable.isDataTable('#tblDocumentos')) {
//            Documentos.ajax.reload(function () {
//                if (Documentos.rows().count() > 0) {
//                    onEnable(btnAceptaNDOC);
//                } else {
//                    onDisable(btnAceptaNDOC);
//                }
//            });
            return;
        }
        Documentos = tblDocumentos.DataTable({
            dom: 'rtp',
            "ajax": {
                "url": '<?php print base_url('NotificacionDeLoDocumentado/getCartaFacs'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = ClienteFacturaNDOC.val() ? ClienteFacturaNDOC.val() : '';
                    d.DOCUMENTO = DoctoNDOC.val() ? DoctoNDOC.val() : '';
                    d.TP = TPNDOC.val() ? TPNDOC.val() : '';
                }
            },
            "columns": [
                {"data": "ID"},
                {"data": "CLIENTE"}, {"data": "FACTURA"},
                {"data": "TP"}, {"data": "GUIA"},
                {"data": "FECHA"}, {"data": "PARES"},
                {"data": "CAJAS"}, {"data": "IMPORTE"},
                {"data": "TRANSPORTE"}
            ],
            "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": 250,
            "scrollX": true,
            "aaSorting": [
                [5, 'desc']/*FECHA*/
            ],
            initComplete: function () {
                onCloseOverlay();
            }
        });
    }
</script>
