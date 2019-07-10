<div id="mdlCapturaDeVtaXListaLinea" class="modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Captura precio de venta X lista linea </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label for="">Lista</label>
                        <select id="ListaCPVTAXLTA" name="ListaCPVTAXLTA" class="form-control"></select>
                    </div>
                    <div class="col-12">
                        <label for="">Linea</label>
                        <select id="LineaCPVTAXLTA" name="LineaCPVTAXLTA" class="form-control"></select>
                    </div>
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
                        <button type="button" id="btnPorListasDePrecios" class="btn btn-primary">Por listas de precios 1,2,3 y 12</button>
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
            tblListaDePrecios = mdlCapturaDeVtaXListaLinea.find("#tblListaDePrecios");

    var opciones_detalle = {
        dom: 'rtip',
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
        "displayLength": 999,
        "bLengthChange": false,
        "deferRender": true,
        "scrollCollapse": false,
        "bSort": true,
        "scrollY": "500px",
        "scrollX": true,
        initComplete: function (x, y) {
            HoldOn.close();
        }
    };
    $(document).ready(function () {

        mdlCapturaDeVtaXListaLinea.on('shown.bs.modal', function () {
            getRecords();
            getListasDePrecios();
            getLineas();
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

    function getRecords() {
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