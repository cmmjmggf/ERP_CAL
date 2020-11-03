<script type="text/javascript" src="//unpkg.com/xlsx/dist/shim.min.js"></script>
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

<script type="text/javascript" src="//unpkg.com/blob.js@1.0.1/Blob.js"></script>
<script type="text/javascript" src="//unpkg.com/file-saver@1.3.3/FileSaver.js"></script> 

<div id="pnlPrincipal" class="card m-2">
    <div class="card-body">
        <h4 class="card-title"><span class="fa fa-file"></span> Lista de Precios Estilo-Precio</h4> 
        <div class="row">
            <div class="col-10">
                <label>Lista</label>
                <input type="text" id="ListaFiltro" name="ListaFiltro" class="form-control form-control-sm" maxlength="2" >
            </div> 
            <div class="col-2">
                <button type="button" id="btnAcepta" name="btnAcepta" class="btn btn-sm btn-success mt-3 font-weight-bold">
                    <span class="fa fa-file-excel"></span> Exporta
                </button>
            </div>  
            <div class="col-12 mt-2">
                <table id="tblDatos" class="table table-hover table-sm table-bordered  compact nowrap" 
                       style="width: 100% !important; height: 250px !important;">
                    <thead>  
                        <tr> 
                            <th  >ESTILO</th>
                            <th  >PRECIO</th> 
                        </tr>
                    </thead>
                    <tbody></tbody> 
                </table>
            </div>
        </div>
    </div>
</div>  
<script>
    var pnlPrincipal = $("#pnlPrincipal"),
            ListaFiltro = pnlPrincipal.find("#ListaFiltro"),
            xDatos, tblDatos = pnlPrincipal.find("#tblDatos"),
            btnAcepta = pnlPrincipal.find("#btnAcepta"),
            btnExporta = pnlPrincipal.find("#btnExporta");

    $(document).ready(function () {
        handleEnterDiv(pnlPrincipal);
        ListaFiltro.focus();
        getDatos();
        btnAcepta.click(function () {
            onOpenOverlay('Generando...');
            xDatos.ajax.reload(function () {
                onExportarTabla('xlsx');
                onCloseOverlay();
            });
        }); 

    });

    function getDatos() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDatos')) {
            xDatos.ajax.reload(function () {
                onCloseOverlay();
            });
            return;
        }
        xDatos = tblDatos.DataTable({
            "ajax": {
                "url": '<?php print base_url('ListaDePrecioEstiloPrecioXLS/getDatosListasDePrecio'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.LISTA = ListaFiltro.val() ? ListaFiltro.val() : '';
                }
            },
            "dom": 'rit',
            buttons: buttons,
            "columns": [
                {"data": "ESTILO"}/*0*/, {"data": "PRECIO"}/*1*/
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": true,
                    "searchable": false
                }
            ],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 99999999,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "250px",
            "scrollX": true,
            "aaSorting": [
                [1, 'asc']
            ],
            initComplete: function () {
                onCloseOverlay();
            }
        });
    }

    function onExportarTabla(type) {
        var elt = document.getElementById('tblDatos');
        var wb = XLSX.utils.table_to_book(elt, {sheet: "Sheet JS"});
        return XLSX.writeFile(wb, 'LISTA_DE_PRECIOS ' + ListaFiltro.val() + '_.xlsx');
    }
</script> 
<style>
    .btn-success {
        color: #fff;
        background-color: #8BC34A;
        border-color: #8BC34A;
    }
</style>