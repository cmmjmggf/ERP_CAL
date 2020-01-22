<script type="text/javascript" src="//unpkg.com/xlsx/dist/shim.min.js"></script>
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

<script type="text/javascript" src="//unpkg.com/blob.js@1.0.1/Blob.js"></script>
<script type="text/javascript" src="//unpkg.com/file-saver@1.3.3/FileSaver.js"></script> 

<div id="pnlPrincipal" class="card m-2">
    <div class="card-body">
        <h4 class="card-title"><span class="fa fa-file"></span> Pares Asignados x semana año</h4> 
        <div class="row">
            <div class="col-4">
                <label>Semana</label>
                <input type="text" id="Semana" name="Semana" class="form-control form-control-sm" maxlength="2" >
            </div>
            <div class="col-4">
                <label>Año</label>
                <input type="text" id="Ano" name="Ano" class="form-control form-control-sm" maxlength="4">
            </div>
            <div class="col-2">
                <button type="button" id="btnAcepta" name="btnAcepta" class="btn btn-sm btn-info mt-3 font-weight-bold">
                    <span class="fa fa-print"></span> Acepta
                </button>
            </div> 
            <div class="col-2">
                <button type="button" id="btnExporta" name="btnExporta" class="btn btn-sm btn-success mt-3 font-weight-bold">
                    <span class="fa fa-file-excel"></span> Exporta
                </button>
            </div>
            <div class="col-12 mt-2">
                <table id="tblDatos" class="table table-hover table-sm table-bordered  compact nowrap" 
                       style="width: 100% !important; height: 250px !important;">
                    <thead>
                        <tr>
                            <th scope="col">PEDIDO</th>
                            <th scope="col">CONTROL</th>
                            <th scope="col">ESTILO</th>
                            <th scope="col">COLOR</th>
                            <th scope="col">COLOR/PIEL</th>

                            <th scope="col">CLIENTE</th>
                            <th scope="col">-</th>
                            <th scope="col">FECHA-ENT</th>
                            <th scope="col">PARES</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>

                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>  
<script>
    var pnlPrincipal = $("#pnlPrincipal"),
            xSemana = pnlPrincipal.find("#Semana"),
            xAno = pnlPrincipal.find("#Ano"),
            xDatos, tblDatos = pnlPrincipal.find("#tblDatos"),
            btnAcepta = pnlPrincipal.find("#btnAcepta"),
            btnExporta = pnlPrincipal.find("#btnExporta");

    $(document).ready(function () {
        handleEnterDiv(pnlPrincipal);
        xSemana.focus();
        xAno.val('<?php print Date('Y'); ?>');
        getDatos();
        btnAcepta.click(function () {
            onOpenOverlay('Buscando...');
            getDatos();
        });
        btnExporta.click(function () {
            onExportarTabla('xlsx', xSemana.val(), xAno.val());
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
                "url": '<?php print base_url('ParesAsignadosExportaXLS/getDatosXSemanaAnio'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.ANIO = xAno.val() ? xAno.val() : '';
                    d.SEMANA = xSemana.val() ? xSemana.val() : '';
                }
            },
            "dom": 'rit',
            buttons: buttons,
            "columns": [
                {"data": "PEDIDO"}/*0*/, {"data": "CONTROL"}/*1*/,
                {"data": "ESTILO"}/*2*/, {"data": "CLAVE_COLOR"},
                {"data": "COLOR_PIEL"}, {"data": "CLIENTE_CLAVE"},
                {"data": "CLIENTE"}, {"data": "FECHA_ENTREGA"}, {"data": "PARES"}
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
                [5, 'asc']
            ],
            initComplete: function () {
                onCloseOverlay();
            },
            "drawCallback": function (settings) {
                var api = this.api();
                var r = 0, prs = 0;
                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };
                $.each(api.rows().data(), function (k, v) {
                    prs += parseInt(v.PARES);
                });
                $(api.column(5).footer()).html('<span class="font-weight-bold">' + prs + ' PARES</span>');
            }
        });
    }

    function onExportarTabla(type, semana, anio) {
        var elt = document.getElementById('tblDatos');
        var wb = XLSX.utils.table_to_book(elt, {sheet: "Sheet JS"});
        return XLSX.writeFile(wb, 'PARES_ASIGNADOS_SEM' + semana + '_ANIO_' + anio + '_.xlsx');
    }
</script> 
<style>

    .card {
        background-color: #efefef;; 
    }
    .btn-success {
        color: #fff;
        background-color: #8BC34A;
        border-color: #8BC34A;
    }
</style>