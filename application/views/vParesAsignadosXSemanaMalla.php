<script type="text/javascript" src="//unpkg.com/xlsx/dist/shim.min.js"></script>
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

<script type="text/javascript" src="//unpkg.com/blob.js@1.0.1/Blob.js"></script>
<script type="text/javascript" src="//unpkg.com/file-saver@1.3.3/FileSaver.js"></script> 

<div id="pnlPrincipal" class="card m-2">
    <div class="card-body">
        <h4 class="card-title"><span class="fa fa-file"></span> Pares Asignados x semana malla</h4> 
        <div class="row">
            <div class="col-3">
                <label>Semana</label>
                <input type="text" id="Semana" name="Semana" class="form-control form-control-sm" maxlength="2" style="height: 65px; font-size: 55px;" >
            </div>
            <div class="col-3">
                <label>Año</label>
                <input type="text" id="Ano" name="Ano" class="form-control form-control-sm" maxlength="4"  style="height: 65px; font-size: 55px;" >
            </div>
            <div class="col-3 text-center mt-4">
                <h1 class="font-weight-bold font-italic pares_x_semana_malla" style="color:#cc0000;">0 PARES</h1>
            </div> 
            <div class="col-1">
                <button type="button" id="btnExporta" name="btnExporta" class="btn btn-sm btn-success mt-3 font-weight-bold" 
                        style="font-size: 35px;">
                    <span class="fa fa-file-excel"></span> Exporta
                </button>
            </div>
            <div class="col-12 mt-2">
                <table id="tblDatos" class="table table-hover table-sm table-bordered  compact nowrap" 
                       style="width: 100% !important; height: 250px !important; font-weight: bold !important;">
                    <thead>  
                        <tr>
                            <th  >CONTROL</th>
                            <th  >ESTILO</th>
                            <th  >COLOR</th>
                            <th  >PARES</th>
                            <th  >-</th>

                            <th  >-</th>
                            <th  >-</th>
                            <th  >-</th>
                            <th  >-</th>
                            <th  >-</th>

                            <th  >-</th>
                            <th  >-</th>
                            <th  >-</th>
                            <th  >-</th>
                            <th  >-</th>

                            <th  >-</th>
                            <th  >-</th>
                            <th  >-</th>
                            <th  >-</th>
                            <th  >-</th>

                            <th  >-</th>
                            <th  >-</th>
                            <th  >-</th>
                            <th  >-</th>
                            <th  >-</th>
                            <th  >CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody></tbody> 
                </table>
            </div>
            <div class="col-12 mt-2 text-center">
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
        
        xSemana.on('keydown', function (e) {
            if (e.keyCode === 13) {
                onOpenOverlay('Buscando...');
                getDatos();
            }
        });
        
        xAno.on('keydown', function (e) {
            if (e.keyCode === 13) {
                onOpenOverlay('Buscando...');
                getDatos();
            }
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
                "url": '<?php print base_url('ParesAsignadosXSemanaMalla/getDatosXSemanaAnio'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.ANIO = xAno.val() ? xAno.val() : '';
                    d.SEMANA = xSemana.val() ? xSemana.val() : '';
                }
            },
            "dom": 'rit',
            buttons: buttons,
            "columns": [
                {"data": "CONTROL"}/*0*/, {"data": "ESTILO"}/*1*/,
                {"data": "COLOR"}/*2*/, {"data": "PARES"},
                {"data": "C1"}, {"data": "C2"}, {"data": "C3"}, {"data": "C4"}, {"data": "C5"},
                {"data": "C6"}, {"data": "C7"}, {"data": "C8"}, {"data": "C9"}, {"data": "C10"},
                {"data": "C11"}, {"data": "C12"}, {"data": "C13"}, {"data": "C14"}, {"data": "C15"},
                {"data": "C16"}, {"data": "C17"}, {"data": "C18"}, {"data": "C19"}, {"data": "C20"},
                {"data": "C21"}, {"data": "CANTIDAD"}
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
            "scrollY": "300px",
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
                $(".pares_x_semana_malla").text(prs + ' PARES');
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
        background-color: #4CAF50;
        border-color: #4CAF50;
    }
    #tblDatos tbody td
    {
        font-size: 25px !important;
    }
</style>