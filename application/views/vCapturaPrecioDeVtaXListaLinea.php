<div id="mdlCapturaDeVtaXListaLinea" class="modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title">Captura precio de venta X lista linea </h5>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="mdlPanelUno">
                    <div class="col-12">
                        <label for="">Lista</label>
                        <select id="ListaCPVTAXLTA" name="ListaCPVTAXLTA" class="form-control"></select>
                    </div>
                    <div class="col-12">
                        <label for="">Linea</label>
                        <select id="LineaCPVTAXLTA" name="LineaCPVTAXLTA" class="form-control"></select>
                    </div>
                </div>
                <div class="row d-none animated fadeIn" id="mdlPanelDos">
                    <div class="col-12">
                        <label for="">Estilo</label>
                        <input type="text" id="EstiloCPVTAXLTA" name="EstiloCPVTAXLTA" class="form-control form-control-sm" maxlength="15">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 text-center mt-2">
                        <h3>Listas de precios</h3>
                    </div>
                    <div class="col-4">
                        <label for="">Lta-1</label>
                        <input type="text" id="ListaUnoCPVTAXLTA" name="ListaUnoCPVTAXLTA" class="form-control form-control-sm" maxlength="15">
                    </div>
                    <div class="col-4">
                        <label for="">Lta-2</label>
                        <input type="text" id="ListaDosCPVTAXLTA" name="ListaDosCPVTAXLTA" class="form-control form-control-sm" maxlength="15">
                    </div>
                    <div class="col-4">
                        <label for="">Lta-3</label>
                        <input type="text" id="ListaTresCPVTAXLTA" name="ListaTresCPVTAXLTA" class="form-control form-control-sm" maxlength="15">
                    </div>
                    <div class="col-4">
                        <label for="">Lta-6</label>
                        <input type="text" id="ListaSeisCPVTAXLTA" name="ListaSeisCPVTAXLTA" class="form-control form-control-sm" maxlength="15">
                    </div>
                    <div class="col-4">
                        <label for="">Lta-12</label>
                        <input type="text" id="ListaDoceCPVTAXLTA" name="ListaDoceCPVTAXLTA" class="form-control form-control-sm" maxlength="15">
                    </div>
                    <div class="col-4">
                        <label for="">Lta-25</label>
                        <input type="text" id="ListaDosCincoCPVTAXLTA" name="ListaDosCincoCPVTAXLTA" class="form-control form-control-sm" maxlength="15">
                    </div>
                    <div class="col-6 mt-2" align="left">
                        <button type="button" id="btnPorListasDePreciosVolver" class="btn btn-primary d-none">
                            <span class="fa fa-arrow-left"></span> Volver
                        </button>
                    </div>
                    <div class="col-6 mt-2" align="right">
                        <button type="button" id="btnAceptaListaXEstilo" name="btnAceptaListaXEstilo" class="btn btn-primary">
                            <span class="fa fa-check"></span> Acepta
                        </button>
                    </div>
                </div>
                <div class="col-12"  align="left">
                    <button type="button" id="btnPorListasDePrecios" class="btn btn-primary">Por listas de precios 1,2,3 y 12</button>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table id="tblListaDePrecios" class="table table-sm table-hover" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Lista</th>
                                    <th scope="col">Linea</th>
                                    <th scope="col">Estilo</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Serie</th>
                                    <th scope="col">Tipo de piel</th>
                                    <th scope="col">P-Auto</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-12" align="left">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlCapturaDeVtaXListaLinea = $("#mdlCapturaDeVtaXListaLinea"),
            ListaCPVTAXLTA = mdlCapturaDeVtaXListaLinea.find("#ListaCPVTAXLTA"),
            LineaCPVTAXLTA = mdlCapturaDeVtaXListaLinea.find("#LineaCPVTAXLTA"),
            ListaDePrecios, IDX = 0,
            tblListaDePrecios = mdlCapturaDeVtaXListaLinea.find("#tblListaDePrecios"),
            btnPorListasDePreciosVolver = mdlCapturaDeVtaXListaLinea.find("#btnPorListasDePreciosVolver"),
            btnPorListasDePrecios = mdlCapturaDeVtaXListaLinea.find("#btnPorListasDePrecios"),
            EstiloCPVTAXLTA = mdlCapturaDeVtaXListaLinea.find("#EstiloCPVTAXLTA"),
            btnAceptaListaXEstilo = mdlCapturaDeVtaXListaLinea.find("#btnAceptaListaXEstilo"),
            ListaUnoCPVTAXLTA = mdlCapturaDeVtaXListaLinea.find("#ListaUnoCPVTAXLTA"),
            ListaDosCPVTAXLTA = mdlCapturaDeVtaXListaLinea.find("#ListaDosCPVTAXLTA"),
            ListaTresCPVTAXLTA = mdlCapturaDeVtaXListaLinea.find("#ListaTresCPVTAXLTA"),
            ListaSeisCPVTAXLTA = mdlCapturaDeVtaXListaLinea.find("#ListaSeisCPVTAXLTA"),
            ListaDoceCPVTAXLTA = mdlCapturaDeVtaXListaLinea.find("#ListaDoceCPVTAXLTA"),
            ListaDosCincoCPVTAXLTA = mdlCapturaDeVtaXListaLinea.find("#ListaDosCincoCPVTAXLTA");


    var opciones_detalle = {
        dom: 'rtp',
        buttons: buttons,
        "columns": [
            {"data": "ID"},
            {"data": "LISTA"},
            {"data": "LINEA"},
            {"data": "ESTILO"},
            {"data": "COLOR"},
            {"data": "SERIE"},
            {"data": "TIPO DE PIEL"},
            {"data": "PRECIO"}
        ],
        "columnDefs": [
            //ID
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ],
        language: lang,
        select: true,
        "autoWidth": true,
        "colReorder": true,
        "displayLength": 99,
        "bLengthChange": false,
        "deferRender": true,
        "scrollCollapse": false,
        "bSort": true,
        "scrollY": "330px",
        "scrollX": true,
        initComplete: function (x, y) {
            HoldOn.close();
        }
    };
    $(document).ready(function () {
        handleEnterDiv(mdlCapturaDeVtaXListaLinea);

        btnAceptaListaXEstilo.click(function () {
            if (EstiloCPVTAXLTA.val()) {
                if (ListaUnoCPVTAXLTA.val() || ListaDosCPVTAXLTA.val() || ListaTresCPVTAXLTA.val()
                        || ListaSeisCPVTAXLTA.val() || ListaDoceCPVTAXLTA.val() || ListaDosCincoCPVTAXLTA.val()) {
                    HoldOn.open({
                        theme: 'sk-rect',
                        message: 'Modificando precios...por favor espere'
                    });
                    var params = {
                        ESTILO: EstiloCPVTAXLTA.val(),
                        LISTAUNO: ListaUnoCPVTAXLTA.val() ? ListaUnoCPVTAXLTA.val() : '',
                        LISTADOS: ListaDosCPVTAXLTA.val() ? ListaDosCPVTAXLTA.val() : '',
                        LISTATRES: ListaTresCPVTAXLTA.val() ? ListaTresCPVTAXLTA.val() : '',
                        LISTASEIS: ListaSeisCPVTAXLTA.val() ? ListaSeisCPVTAXLTA.val() : '',
                        LISTADOCE: ListaDoceCPVTAXLTA.val() ? ListaDoceCPVTAXLTA.val() : '',
                        LISTADOSCINCO: ListaDosCincoCPVTAXLTA.val() ? ListaDosCincoCPVTAXLTA.val() : ''
                    };
                    $.post('<?php print base_url('CapturaPrecioDeVtaXListaLinea/onModificarPrecioXEstiloLista'); ?>', params).done(function (a) {
                        onBeep(1);
                        onNotifyOld('<span class="fa fa-check"></span>', 'SE HAN ACTUALIZADO LOS PRECIOS EN SUS LISTAS CORRESPONDIENTES', 'success');
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                        HoldOn.close();
                    });
                    console.log(listas);
                } else {
                    console.log("NINGUNO");
                    swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN PRECIO PARA LAS LISTA 1,2,3,6,12 Y 25', 'warning').then((value) => {
                        ListaUnoCPVTAXLTA.focus().select();
                    });
                }
            } else {
                swal('ATENCION', 'DEBE DE ESPECIFICAR UN ESTILO', 'warning').then((value) => {
                    EstiloCPVTAXLTA.focus().select();
                });
            }
        });

        btnPorListasDePreciosVolver.click(function () {
            btnPorListasDePrecios.removeClass("d-none");
            btnPorListasDePreciosVolver.addClass("d-none");
            mdlCapturaDeVtaXListaLinea.find("#mdlPanelUno").removeClass("d-none");
            mdlCapturaDeVtaXListaLinea.find("#mdlPanelDos").addClass("d-none");
            ListaCPVTAXLTA[0].selectize.focus();
        });

        btnPorListasDePrecios.click(function () {
            btnPorListasDePrecios.addClass("d-none");
            btnPorListasDePreciosVolver.removeClass("d-none");
            mdlCapturaDeVtaXListaLinea.find("#mdlPanelUno").addClass("d-none");
            mdlCapturaDeVtaXListaLinea.find("#mdlPanelDos").removeClass("d-none");
            EstiloCPVTAXLTA.focus();
        });

        mdlCapturaDeVtaXListaLinea.on('shown.bs.modal', function () {
            getPreciosVenta();
            getListasDePrecios();
            getLineas();
            ListaCPVTAXLTA[0].selectize.focus();
        });

        ListaCPVTAXLTA.change(function () {
            ListaDePrecios.ajax.reload(function () {
                HoldOn.close();
            });
        });
        LineaCPVTAXLTA.change(function () {
            ListaDePrecios.ajax.reload(function () {
                HoldOn.close();
            });
        });
    });

    function getLineas() {
        $.getJSON('<?php print base_url('CapturaPrecioDeVtaXListaLinea/getLineas') ?>').done(function (a) {
            a.forEach(function (v) {
                LineaCPVTAXLTA[0].selectize.addOption({text: v.Linea, value: v.Clave});
            });
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }

    function getListasDePrecios() {
        $.getJSON('<?php print base_url('CapturaPrecioDeVtaXListaLinea/getListasDePrecios') ?>').done(function (a) {
            a.forEach(function (v) {
                ListaCPVTAXLTA[0].selectize.addOption({text: v.Lista + ' ' + v.Descripcion, value: v.Lista});
            });
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }
    function onCapturaPrecioDeVenta() {
        mdlCapturaDeVtaXListaLinea.modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function getPreciosVenta() {
        HoldOn.open({
            theme: 'sk-rect',
            message: 'Cargando...'
        });
        temp = 0;
        opciones_detalle.ajax = {
            "url": '<?php print base_url('CapturaPrecioDeVtaXListaLinea/getRecords') ?>',
            "contentType": "application/json",
            "dataSrc": "",
            "data": function (d) {
                d.LISTA = ListaCPVTAXLTA.val();
                d.LINEA = LineaCPVTAXLTA.val();
            }
        };
        $.fn.dataTable.ext.errMode = 'throw';
        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
        if ($.fn.DataTable.isDataTable('#tblListaDePrecios')) {
            tblListaDePrecios.DataTable().destroy();
        }
        ListaDePrecios = tblListaDePrecios.DataTable(opciones_detalle);

        tblListaDePrecios.find('tbody').on('click', 'tr', function () {
            var dtm = ListaDePrecios.row(this).data();
            console.log(dtm);
            IDX = dtm.ID;
            swal("CAPTURE EL NUEVO PRECIO", {
                content: "input",
                buttons: {
                    cancelar: {
                        text: "Cancelar",
                        value: "cancelar"
                    },
                    eliminar: {
                        text: "Finalizar",
                        value: "eliminar"
                    }
                }
            }).then((value) => {
                onBeep(1);
                if (value.length > 0) {
                    $.post('<?php print base_url('CapturaPrecioDeVtaXListaLinea/onModificarPrecio') ?>', {
                        ID: IDX, PRECIO: value
                    }).done(function (a) {
                        console.log(a)
                        ListaDePrecios.ajax.reload();
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {

                    });
                }
            });
        });
    }
</script>
<style>
    #tblListaDePrecios table tbody{
        height: 300px !important;
    }
    table.dataTable tbody>tr.selected, table.dataTable tbody>tr>.selected {
        background-color: #000 !important;
    }
</style>