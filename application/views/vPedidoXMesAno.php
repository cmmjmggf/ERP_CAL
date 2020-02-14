<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> 
<div class="card m-2" style="background-color: #263238; color: #fff;" id="Graficos">
    <div class="card-header">
        Pedidos x mes
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-3">
                <label>Año</label>
                <input type="text" id="Anio" name="Anio" class="form-control form-control-sm numbersOnly" maxlength="4">
            </div>
            <div class="col-3"> 
                <label>Mes</label>
                <select id="Mes" name="Mes" class="form-control form-control-sm">
                    <option></option>
                </select>
            </div>
            <div class="col-3"> 
                <button id="btnActualizarDatos" class="btn btn-info mt-3">
                    <span class="fa fa-retweet"></span> Actualizar
                </button>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <canvas id="CanvasGraficoDePedidosXMesAno" width="400" height="650"></canvas>
            </div> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <canvas id="CanvasGraficoDeParesXSemanaAno" width="400" height="650"></canvas>
            </div> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <canvas id="CanvasGraficoDeParesXMesAno" width="400" height="650"></canvas>
            </div> 
        </div>
    </div>
</div> 
<script>
    var labels = [], datas = [];
    var ChartDataPedidosXMesAno = {
        labels: labels,
        datasets: [{type: 'line', label: 'Linear', borderColor: "#03A9F4",
                borderWidth: 2, fill: false, data: datas},
            {type: 'bar', label: 'Barras', backgroundColor: "rgba(194,211,37,0.7)",
                data: datas, borderWidth: 2
            }]

    };
    var Graficos = $("#Graficos"), Ano_actual = '<?php print Date('Y'); ?>';
    $(document).ready(function () {

        getDatosPorMesAno();

        Graficos.find("#Anio").val(Ano_actual);

        Graficos.find("#Mes").change(function () {
            $('#btnActualizarDatos').trigger('click');
        });

        $('#btnActualizarDatos').on('click', function () {
            $.getJSON('<?php print base_url('PedidoXMesAno/getParesPorMesAno'); ?>',
                    {ANO: Graficos.find("#Anio").val() ? Graficos.find("#Anio").val() : '',
                        MES: Graficos.find("#Mes").val() ? Graficos.find("#Mes").val() : ''}).done(function (a) {
                labels = [];
                datas = [];
                $.each(a, function (k, v) {
                    labels.push(v.NOMBRE + " - " + v.PEDIDOS_ESTE_MES);
                    datas.push(v.PEDIDOS_ESTE_MES);
                    Graficos.find("#Mes")[0].selectize.addOption({text: v.NOMBRE, value: v.MES});
                });
                ChartDataPedidosXMesAno.datasets.forEach(function (dataset) {
                    dataset.data = datas;
                });
                ChartDataPedidosXMesAno.labels = labels;
                window.MixedChartPedidosXMesAno.update();
            }).fail(function (x) {
            }).always(function () {

            });
        });
        onActualizarGrafico();
    });

    function onActualizarGrafico() {
        setTimeout(function () {
            $('#btnActualizarDatos').trigger('click');
            onActualizarGrafico();
        }, 3500);
    }
    function getDatosPorMesAno() {
        $.getJSON('<?php print base_url('PedidoXMesAno/getParesPorMesAno'); ?>', {
            ANO: Graficos.find("#Anio").val() ? Graficos.find("#Anio").val() : Ano_actual,
            MES: Graficos.find("#Mes").val() ? Graficos.find("#Mes").val() : ''}).done(function (a) {
            $.each(a, function (k, v) {
                labels.push(v.NOMBRE + " - " + v.PEDIDOS_ESTE_MES);
                datas.push(v.PEDIDOS_ESTE_MES);
                Graficos.find("#Mes")[0].selectize.addOption({text: v.NOMBRE, value: v.MES});
            });
            /*INICIALIZA CHART*/
            var ctx = document.getElementById('CanvasGraficoDePedidosXMesAno').getContext('2d');
            window.MixedChartPedidosXMesAno = new Chart(ctx, {
                type: 'bar',
                data: ChartDataPedidosXMesAno,
                options: {
                    legend: {
                        labels: {
                            fontColor: "white",
                            fontSize: 18
                        }
                    }, scales: {
                        yAxes: [{
                                ticks: {
                                    fontColor: "white",
                                    fontSize: 14,
                                    stepSize: 25,
                                    beginAtZero: true
                                }
                            }],
                        xAxes: [{
                                ticks: {
                                    fontColor: "white",
                                    fontSize: 14,
                                }
                            }]
                    },
                    responsive: true,
                    title: {
                        fontColor: "white",
                        fontSize: 18,
                        display: true,
                        text: 'PEDIDOS POR MES AÑO'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: true
                    }
                }
            });
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }

</script>
<style>
    #Graficos button, span, input{
        font-weight: bold !important;
    }
</style>