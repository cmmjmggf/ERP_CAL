<link rel="stylesheet" type="text/css" href="<?php print base_url('js/pivot/dist/pivot.css'); ?>">
<script type="text/javascript" src="<?php print base_url('js/pivot/dist/pivot.js'); ?>"></script>


<div class="card marope-r m-1">
    <div class="card-body">
        <h4 class="card-title"><span class="fa fa-chart-bar"></span> ESTADISTICAS DE FACTURACIÓN</h4>
        <div class="row justify-content-center">
            <div class="col-2">
                <input id="AnioEstadistico" name="AnioEstadistico" class="form-control numbersOnly" style="text-align: center; font-size: 18px;" maxlength="4"> 
            </div>
        </div>
        <div id="PivotFacturacion" class="col-12 table-responsive"></div> 
    </div>
</div>
<script>

    var AnioEstadistico = $("#AnioEstadistico");
    var configuracion_inicial = {
        rows: ["TIPO"],
        cols: [],
        vals: ["TOTAL"],
        aggregatorName: "Suma",
        rendererName: "Tabla",
        rendererOptions: {
            table: {
                clickCallback: function (e, value, filters, pivotData) {
                    var names = [];
                    pivotData.forEachMatchingRecord(filters,
                            function (record) {
                                console.log(record);
                            });
                }
            }
        },
        onRefresh: function (config) {
            var config_copy = JSON.parse(JSON.stringify(config));
            delete config_copy["aggregators"];
            delete config_copy["renderers"];
            setCookie("Configuracion", JSON.stringify(config_copy), 30);  
            if (config.aggregatorName === 'Suma') {
                //Formato de moneda
                $.each($('#PivotFacturacion > table > tr > td > table > tbody > tr > td'), function (k, v) {
                    var celda = $(v);
                    var val = (celda.text() !== '' && parseFloat(celda.text()) !== 0) ? '$' + celda.text() : '';
                    celda.text(val);
                });
            }
            //Diseño de bootstrap de select
            $('#PivotFacturacion > table > tr > td > select').addClass('form-control form-control-sm');
            //Botones estilo bootstrap
            $('div.pvtFilterBox > p > button').addClass('btn btn-primary btn-sm mx-1 my-1');
            $('div.pvtFilterBox > p > input').addClass('form-control form-control-sm ml-4').css("width", "250px");
        }
    };


    $(function () {
        AnioEstadistico.val(<?php print Date('Y'); ?>);
        AnioEstadistico.keydown(function (e) {
            if (e.keyCode === 13 && AnioEstadistico.val()) {
                getEstadisticas();
            }
        });
        getEstadisticas();

    });

    function getEstadisticas() {
        onOpenOverlay('Cargando...');
        $.getJSON('<?php print base_url('EstadisticasFacturacion/getEstadistica'); ?>', {ANIO: AnioEstadistico.val() ? AnioEstadistico.val() : 0}).done(function (mps) {
            $("#PivotFacturacion").pivotUI(mps, configuracion_inicial);
            var pivotConfig = getCookie("Configuracion");
            if (pivotConfig === '') {
                $("#PivotFacturacion").pivotUI(mps, configuracion_inicial, true);
            } else {
                $("#PivotFacturacion").pivotUI(mps, JSON.parse(getCookie("Configuracion")), true);
            }
            onCloseOverlay();
        }).fail(function (e) {
            getError(e);
            onCloseOverlay();
        });
    }

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
</script>
<style>

    .pvtFilterBox {
        z-index: 100;
        width: 300px;
        border-radius: 0.25rem;
        border: 1px solid #fff;
        background-color: #fff;
        position: absolute;
        text-align: center;
    }

    .pvtAxisContainer, .pvtVals {
        border-radius: 0.25rem;
        border-color: #e2e2e2;
        border-radius: 0.25rem;
        background: #e2e2e2;
        padding: 5px;
        min-width: 20px;
        min-height: 20px;

    }


    table.pvtTable thead tr th, table.pvtTable tbody tr th {
        border-radius: 0.25rem;
        background-color: #3498DB;
        border: 1px solid #3498DB;
        font-size: 8pt;
        color: white;
        padding: 5px;
    }
    .pvtAxisContainer li span.pvtAttr {
        -webkit-text-size-adjust: 100%;
        background: #F39C12;
        border: none;
        padding: 5px 10px 7px;
        color: #FFF;
        white-space: nowrap;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
    .pvtTriangle {
        cursor: pointer;
        color: white;
    }
    table.pvtTable thead tr th{
        color: #fff !important;
        background-color: #000 !important;
    }
    table.pvtTable tbody tr th {
        color: #000 !important;
        background-color: #fff !important;
    }
    table.pvtTable thead tr:hover th, table.pvtTable tbody tr:hover th.pvtRowLabel {
        background-color: #000000 !important;
        color: #ffffff !important;
    }
    table.pvtUi tbody tr:hover td {
        background-color: #000000;
        color:#fff;
    }
    table.pvtUi tbody tr:hover td {
        background-color: #000000 !important;
        color:#fff !important;
    }
    table tbody tr td{
        font-weight: bold;
    } 
    table tbody tr th.pvtTotalLabel{
        background-color: #000000 !important;
        color:#ffffff  !important;
    }
</style>