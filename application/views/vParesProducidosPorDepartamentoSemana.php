<?php
if ($this->session->TipoAcceso === "SUPER ADMINISTRADOR") {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> 
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-style@latest/dist/chartjs-plugin-style.min.js"></script>
    <?php
}
?>
<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Pares producidos por departamento semana</h3>
    </div>
    <div class="card-body">
        <div class="row" align="center"> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Año</label>
                <input type="text" id="Ano" name="Ano" class="form-control form-control-sm  numbersOnly" maxlength="4" >
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Semana nomina actual</label>
                <input type="text" id="Semana" name="Semana" class="form-control form-control-sm  numbersOnly" maxlength="2" autofocus="">
            </div> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>De la fecha</label>
                <input type="text" id="FechaInicial" name="FechaInicial" class="form-control form-control-sm date" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>A la fecha</label>
                <input type="text" id="FechaFinal" name="FechaFinal" class="form-control form-control-sm date" readonly="">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">     
                <button type="button" class="btn btn-info mt-3" id="btnAceptar"><span class="fa fa-print"></span> Aceptar</button>
            </div>
            <div class="w-100 m-2"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="chkDetallePespunte">
                    <label class="custom-control-label" for="chkDetallePespunte" >Detalle de pespunte</label>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="chkDetalleMontado">
                    <label class="custom-control-label" for="chkDetalleMontado" >Detalle montado</label>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="chkDetalleAdorno">
                    <label class="custom-control-label" for="chkDetalleAdorno" >Detalle adorno</label>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="chkDetalleTejido">
                    <label class="custom-control-label" for="chkDetalleTejido" >Detalle tejido</label>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2"></div>
            <div class="col-12 mt-4">
                <p class="font-weight-bold">Nota: Para imprimir todos los departamentos por dia no seleccione ninguna casilla</p>
            </div>
            <div class="w-100 my-3"></div>
            <div class="w-100"></div>

        </div>
        <?php
        if ($this->session->TipoAcceso === "SUPER ADMINISTRADOR") {
            ?>
            <div class="row"> 
                <div class="col-3"> 
                    <button id="btnActualizarGrafico" class="btn btn-success mt-3">
                        <span class="fa fa-retweet"></span> Actualizar
                    </button>
                </div>
                <div class="w-100"></div> 
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                    <canvas id="GraficoParesFabricadosXDeptoSem" style="width: 100%;" height="400"></canvas>
                </div>  
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <canvas id="GraficoBarParesFabricadosXDeptoSem" style="width: 100%;" height="600"></canvas>
                </div>  
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <canvas id="GraficoPieParesFabricadosXDeptoSem" style="width: 100%;" height="350"></canvas>
                </div>  
            </div>
        <?php } ?>
    </div>
    <div class="card-footer">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="right">
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), Anio = pnlTablero.find("#Ano"), Semana = pnlTablero.find("#Semana"),
            btnAceptar = pnlTablero.find("#btnAceptar"),
            FechaInicial = pnlTablero.find("#FechaInicial"),
            FechaFinal = pnlTablero.find("#FechaFinal"),
            Maquila = pnlTablero.find("#Maquila"),
            btnActualizarGrafico = pnlTablero.find('#btnActualizarGrafico');
    var labels = [], datas = [], index_active = 0, xtime = 60;
    var chart_colors = [
        "#388E3C", "#303F9F",
        "#673AB7", "#D32F2F", "#F57C00", "#FFC107",
        "#795548", "#C2185B", "#455A64", "#0288D1"];
    var ConfigParesFabricadosXDeptoSem = {
        type: 'line',
        showTooltips: true,
        backgroundColor: hexToRgbA('#000000'),
        data: {
            labels: ['JUEVES', 'VIERNES', 'SABADO', 'DOMINGO', 'LUNES', 'MARTES', 'MIERCOLES'],
            datasets: []
        },
        options: {
            plugins: {
                // Change options for ALL labels of THIS CHART
                datalabels: {
                    color: '#000',
                    anchor: 'center', offset: 2,
                    align: 'right',
                    font: {weight: 'italic', size: 15}
                },
                zoom: {
                    // Container for pan options
                    pan: {
                        // Boolean to enable panning
                        enabled: true,

                        // Panning directions. Remove the appropriate direction to disable 
                        // Eg. 'y' would only allow panning in the y direction
                        mode: 'xy'
                    },

                    // Container for zoom options
                    zoom: {
                        // Boolean to enable zooming
                        enabled: true,

                        // Zooming directions. Remove the appropriate direction to disable 
                        // Eg. 'y' would only allow zooming in the y direction
                        mode: 'xy',
                    }
                }
            },
            legend: {
                display: true,
                position: "top",
                labels: {
                    fontStyle: "italic",
                    fontColor: "#000",
                    fontSize: 15
                },
                align: 'top'
            },
            responsive: true,
            title: {
                display: true,
                fontSize: 18,
                text: 'PARES FABRICADOS POR DEPARTAMENTO DE LA SEMANA'
            },
            scales: {
                xAxes: [{
                        display: true,
                        ticks: {
                            fontStyle: "italic",
                            fontColor: "#000",
                            fontSize: 18,
                            stepSize: 1,
                            beginAtZero: true
                        },
                        fontStyle: "italic"
                    }],
                yAxes: [{
                        display: true,
                        ticks: {
                            fontColor: "#000",
                            fontSize: 18,
                            stepSize: 200,
                            beginAtZero: true
                        }
                    }]
            } /*SCALES*/

        }/*OPTIONS*/
    };
    var ConfigBarParesFabricadosXDeptoSem = {
        type: 'bar',
        showTooltips: true,
        backgroundColor: hexToRgbA('#000000'),
        data: {
            labels: ['JUEVES', 'VIERNES', 'SABADO', 'DOMINGO', 'LUNES', 'MARTES', 'MIERCOLES'],
            datasets: []
        },
        options: {
            plugins: {
                // Change options for ALL labels of THIS CHART
                datalabels: {
                    color: '#000',
                    anchor: 'end',
                    align: 'top',
                    offset: 6,
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    value: {
                        color: '#000'
                    }
                }, zoom: {
                    // Container for pan options
                    pan: {
                        // Boolean to enable panning
                        enabled: true,

                        // Panning directions. Remove the appropriate direction to disable 
                        // Eg. 'y' would only allow panning in the y direction
                        mode: 'xy'
                    },

                    // Container for zoom options
                    zoom: {
                        // Boolean to enable zooming
                        enabled: true,

                        // Zooming directions. Remove the appropriate direction to disable 
                        // Eg. 'y' would only allow zooming in the y direction
                        mode: 'xy',
                    }
                }
            },
            legend: {
                display: true,
                position: "top",
                labels: {
                    fontStyle: "italic",
                    fontColor: "#000",
                    fontSize: 15
                }
            },
            responsive: true,
            title: {
                display: true,
                fontSize: 18,
                text: 'PARES FABRICADOS POR DEPARTAMENTO DE LA SEMANA'
            },
            scales: {
                xAxes: [{
                        display: true,
                        ticks: {
                            fontStyle: "italic",
                            fontColor: "#000",
                            fontSize: 18,
                            stepSize: 1,
                            beginAtZero: true
                        },
                        fontStyle: "italic"
                    }],
                yAxes: [{
                        display: true,
                        ticks: {
                            fontColor: "#000",
                            fontSize: 18,
                            stepSize: 200,
                            beginAtZero: true
                        }
                    }]
            } /*SCALES*/

        }/*OPTIONS*/
    };
    var ConfigPieParesFabricadosXDeptoSem = {
        "type": "pie",
        "data": {
            "labels": ["", "", "", "", "", "", "", "", "", ""],
            "datasets": [{
                    "label": "PARES FABRICADOS POR DEPARTAMENTO SEMANA",
                    "data": [1, 1, 1, 1,
                        1, 1, 1, 1, 1],
                    "backgroundColor": chart_colors,
                    hoverOffset: 4
                }]
        },
        options: {
            title: "PARES FABRICADOS POR DEPTO SEM",
            plugins: {
                // Change options for ALL labels of THIS CHART
                datalabels: {
                    color: '#fff',
                    font: {weight: 'bold', size: 12},
                    textAlign: 'center',
                    font: {
                        lineHeight: 1.6
                    },
                    formatter: function (value, ctx) {
                        return ctx.chart.data.labels[ctx.dataIndex] + '\n' + value;
                    }
                },
                zoom: {
                    // Container for pan options
                    pan: {
                        // Boolean to enable panning
                        enabled: true,

                        // Panning directions. Remove the appropriate direction to disable 
                        // Eg. 'y' would only allow panning in the y direction
                        mode: 'xy'
                    },

                    // Container for zoom options
                    zoom: {
                        // Boolean to enable zooming
                        enabled: true,

                        // Zooming directions. Remove the appropriate direction to disable 
                        // Eg. 'y' would only allow zooming in the y direction
                        mode: 'xy',
                    }
                }
            }
        }
    };
    var Ano_actual = '<?php print Date('Y'); ?>';
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    function hexToRgbA(hex) {
        var c;
        if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
            c = hex.substring(1).split('');
            if (c.length == 3) {
                c = [c[0], c[0], c[1], c[1], c[2], c[2]];
            }
            c = '0x' + c.join('');
            return 'rgba(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + ',0.1)';
        }
        throw new Error('Bad Hex');
    }

    function onDetallechk(chk) {
        pnlTablero.find("#chkDetallePespunte")[0].checked = false;
        pnlTablero.find("#chkDetalleMontado")[0].checked = false;
        pnlTablero.find("#chkDetalleAdorno")[0].checked = false;
        pnlTablero.find("#chkDetalleTejido")[0].checked = false;
        pnlTablero.find("#" + chk)[0].checked = true;
    }
    $(document).ready(function () {
        handleEnterDiv(pnlTablero);
        Anio.val(new Date().getFullYear());
        getSemanaByFechaNominaBancoControlNom(getFechaActualConDiagonales());
        Semana.on('keydown', function (e) {
            if (e.keyCode === 13 && Semana.val()) {
                onComprobarSemanasNominaNominaBanco(Semana, Anio.val());
            }
        });
        pnlTablero.find("#chkDetallePespunte").on('change', function () {
            if (pnlTablero.find("#chkDetallePespunte")[0].checked) {
                onDetallechk("chkDetallePespunte");
            }
        });
        pnlTablero.find("#chkDetalleMontado").on('change', function () {
            if (pnlTablero.find("#chkDetalleMontado")[0].checked) {
                onDetallechk("chkDetalleMontado");
            }
        });
        pnlTablero.find("#chkDetalleAdorno").on('change', function () {
            if (pnlTablero.find("#chkDetalleAdorno")[0].checked) {
                onDetallechk("chkDetalleAdorno");
            }
        });
        pnlTablero.find("#chkDetalleTejido").on('change', function () {
            if (pnlTablero.find("#chkDetalleTejido")[0].checked) {
                onDetallechk("chkDetalleTejido");
            }
        });
        btnAceptar.click(function () {
            $.getJSON('<?php print base_url('Semanas/onComprobarSemanaNomina'); ?>', {Clave: Semana.val(),
                Ano: Anio.val()}).done(function (dataSem) {
                if (dataSem.length > 0) {
                    FechaInicial.val(dataSem[0].FechaIni);
                    FechaFinal.val(dataSem[0].FechaFin);
                    btnAceptar.attr('disabled', true);
                    HoldOn.open({
                        theme: 'sk-cube',
                        message: 'Por favor espere...'
                    });
                    if (Anio.val() && Semana.val() && FechaInicial.val() && FechaFinal.val()) {
                        $.post('<?php print base_url('ParesProducidosPorDepartamentoSemana/getReporte'); ?>', {
                            FECHA_INICIAL: FechaInicial.val() ? FechaInicial.val() : '',
                            FECHA_FINAL: FechaFinal.val() ? FechaFinal.val() : '',
                            ANIO: Anio.val() ? Anio.val() : '',
                            SEMANA: Semana.val() ? Semana.val() : '',
                            TIPO: pnlTablero.find("#chkDetallePespunte")[0].checked ? 1 :
                                    pnlTablero.find("#chkDetalleMontado")[0].checked ? 2 :
                                    pnlTablero.find("#chkDetalleAdorno")[0].checked ? 3 :
                                    pnlTablero.find("#chkDetalleTejido")[0].checked ? 4 : 0
                        }).done(function (data, x, jq) {
                            onBeep(1);
                            onImprimirReporteFancy(data);
                        }).fail(function (x, y, z) {
                            console.log(x.responseText);
                            swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
                        }).always(function () {
                            HoldOn.close();
                            btnAceptar.attr('disabled', false);
                        });
                    } else {
                        if (!Anio.val()) {
                            swal('ATENCIÓN', 'EL AÑO ES REQUERIDO', 'warning').then((value) => {
                                if (value) {
                                    Anio.focus().select();
                                    btnAceptar.attr('disabled', false);
                                }
                            });
                        }
                        if (!Semana.val()) {
                            swal('ATENCIÓN', 'LA SEMANA ES REQUERIDA', 'warning').then((value) => {
                                if (value) {
                                    Semana.focus().select();
                                    btnAceptar.attr('disabled', false);
                                }
                            });
                        }
                        if (!FechaInicial.val() || !FechaFinal.val()) {
                            swal('ATENCIÓN', 'LAS FECHAS SON REQUERIDAS', 'warning').then((value) => {
                                FechaInicial.focus().select();
                                btnAceptar.attr('disabled', false);
                            });
                        }
                    }
                } else {
                    swal({title: "ATENCIÓN",
                        text: "LA SEMANA " + Semana.val() + " DEL " + Anio.val() + " " + "NO EXISTE",
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
                                Semana.focus();
                                break;
                        }
                    });
                }
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE: btnAceptar', 'info');
                console.log(x.responseText);
            });
        });
        /*chart*/

<?php
if ($this->session->TipoAcceso === "SUPER ADMINISTRADOR") {
    ?>
            btnActualizarGrafico.on('click', function () {
                onDisable(btnActualizarGrafico);
                //            onOpenOverlay('Espere...');
                $.getJSON('<?php print base_url('ParesProducidosPorDepartamentoSemana/getOrigenDeDatos'); ?>',
                        {
                            FECHA_INICIAL: FechaInicial.val() ? FechaInicial.val() : '',
                            FECHA_FINAL: FechaFinal.val() ? FechaFinal.val() : '',
                            ANIO: Anio.val() ? Anio.val() : '',
                            SEMANA: Semana.val() ? Semana.val() : '',
                            TIPO: 0
                        }).done(function (a) {
                    datasets = [];
                    var labels = [];
                    var i = 0;
                    $.each(a, function (k, v) {
                        datasets.push({
                            label: v.DEPARTAMENTO,
                            backgroundColor: hexToRgbA(chart_colors[i]),
                            borderColor: chart_colors[i],
                            fill: false,
                            stepped: true,
                            borderDash: [],
                            pointStyle: 'circle',
                            radius: 5,
                            hoverRadius: 7,
                            borderWidth: 2,
                            hoverBorderWidth: 3,
                            data: []
                        });
                        labels.push(v.DEPARTAMENTO);
                        i++;
                    });
//                    ConfigParesFabricadosXDeptoSem.data.datasets = datasets;
                    ConfigBarParesFabricadosXDeptoSem.data.datasets = datasets;
                    ConfigPieParesFabricadosXDeptoSem.data.labels = labels;/*PIE CHART - LABELS*/
                    i = 0;
                    labels = [];
                    var totales = [0, 0, 0, 0, 0, 0, 0], totales_pie = [];
                    $.each(a, function (k, v) {
                        labels = ["JUEVES " + v.FECHA_JUEVES, "VIERNES " + v.FECHA_VIERNES,
                            "SABADO " + v.FECHA_SABADO, "DOMINGO " + v.FECHA_DOMINGO,
                            "LUNES " + v.FECHA_LUNES, "MARTES " + v.FECHA_MARTES,
                            "MIERCOLES " + v.FECHA_MIERCOLES];
//                        ConfigParesFabricadosXDeptoSem.data.datasets[i].data = [
//                            parseFloat(v.CANTIDAD_JUEVES),
//                            v.CANTIDAD_VIERNES,
//                            v.CANTIDAD_SABADO,
//                            v.CANTIDAD_DOMINGO,
//                            v.CANTIDAD_LUNES,
//                            v.CANTIDAD_MARTES,
//                            v.CANTIDAD_MIERCOLES
//                        ];
                        ConfigBarParesFabricadosXDeptoSem.data.datasets[i].data = [
                            parseFloat(v.CANTIDAD_JUEVES),
                            v.CANTIDAD_VIERNES,
                            v.CANTIDAD_SABADO,
                            v.CANTIDAD_DOMINGO,
                            v.CANTIDAD_LUNES,
                            v.CANTIDAD_MARTES,
                            v.CANTIDAD_MIERCOLES
                        ];
                        totales[0] += parseFloat(v.CANTIDAD_JUEVES);
                        totales[1] += parseFloat(v.CANTIDAD_VIERNES);
                        totales[2] += parseFloat(v.CANTIDAD_SABADO);
                        totales[3] += parseFloat(v.CANTIDAD_DOMINGO);
                        totales[4] += parseFloat(v.CANTIDAD_LUNES);
                        totales[5] += parseFloat(v.CANTIDAD_MARTES);
                        totales[6] += parseFloat(v.CANTIDAD_MIERCOLES);
//                        ConfigParesFabricadosXDeptoSem.data.datasets[i].label = v.DEPARTAMENTO + " " + v.TOTALES;
                        ConfigBarParesFabricadosXDeptoSem.data.datasets[i].label = v.DEPARTAMENTO + " " + v.TOTALES;
                        totales_pie.push(v.TOTALES);
                        i++;
                    });
                    ConfigPieParesFabricadosXDeptoSem.data.datasets[0].data = totales_pie /*PIE CHART - DATASETS*/;
//                    ConfigParesFabricadosXDeptoSem.data.labels = labels;
//                    ConfigParesFabricadosXDeptoSem.options.title.text = "PARES FABRICADOS POR DEPARTAMENTO DE LA SEMANA " + Semana.val();
                    ConfigBarParesFabricadosXDeptoSem.data.labels = labels;
                    ConfigBarParesFabricadosXDeptoSem.options.title.text = "PARES FABRICADOS POR DEPARTAMENTO DE LA SEMANA " + Semana.val();
//                    window.ChartLineFabricadosXDeptoSem.update();
                    window.ChartBarFabricadosXDeptoSem.update();
                    window.ChartPieFabricadosXDeptoSem.update()/*PIE CHART - UPDATE CHART*/;
                    xtime = 60;
                    onEnable(btnActualizarGrafico);
                }).fail(function (x) {
                    console.log(x);
                }).always(function () {

                });
            });
//            var ctx = document.getElementById('GraficoParesFabricadosXDeptoSem').getContext('2d');
//            window.ChartLineFabricadosXDeptoSem = new Chart(ctx, ConfigParesFabricadosXDeptoSem);
            var ctxb = document.getElementById('GraficoBarParesFabricadosXDeptoSem').getContext('2d');
            window.ChartBarFabricadosXDeptoSem = new Chart(ctxb, ConfigBarParesFabricadosXDeptoSem);
            /*PIE CHART*/
            var ctxpie = document.getElementById('GraficoPieParesFabricadosXDeptoSem').getContext('2d');
            window.ChartPieFabricadosXDeptoSem = new Chart(ctxpie, ConfigPieParesFabricadosXDeptoSem);
            onActualizarGrafico();
<?php } ?>
    });
    function onActualizarGrafico() {
        setTimeout(function () {
            btnActualizarGrafico.trigger('click');
            onActualizarGrafico();
        }, 67000);
    }
    function onCheckTime() {
        setTimeout(function () {
            xtime = xtime - 1;
            onCheckTime();
        }, 1000);
    }


    function randomScalingFactor() {
        return Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5));
    }
    function getSemanaByFechaNominaBancoControlNom(fecha) {
        $.getJSON('<?php print base_url('ParesProducidosPorDepartamentoSemana/getSemanaXFecha') ?>', {Fecha: fecha}).done(function (data) {
            if (data.length > 0) {
                Semana.val(data[0].sem);
                FechaInicial.val(data[0].FechaIni);
                FechaFinal.val(data[0].FechaFin);
                btnActualizarGrafico.trigger('click');
            } else {
                swal('ERROR', 'NO EXISTE SEMANA', 'info');
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE: getSemanaByFechaNominaBancoControlNom', 'info');
            console.log(x.responseText);
        });
    }

    function onComprobarSemanasNominaNominaBanco(v, ano) {
        //Valida que esté creada la semana en nominas
        $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {Clave: $(v).val(), Ano: ano}).done(function (dataSem) {
            if (dataSem.length > 0) {
                FechaInicial.val(dataSem[0].FechaIni);
                FechaFinal.val(dataSem[0].FechaFin);
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
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE: onComprobarSemanasNominaNominaBanco', 'info');
            console.log(x.responseText);
        });
    }
</script>
<style>
    .btn-indigo {
        color: #fff;
        background-color: #3F51B5;
        border-color: #3F51B5;
    }
    .btn-indigo:not(:disabled):not(.disabled):active,
    .btn-indigo:not(:disabled):not(.disabled).active,
    .show > .btn-indigo.dropdown-toggle {
        color: #fff;
        background-color: #99cc00;
        border: 2px solid #99cc00;
        font-weight: bold;
    }
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid;
        /*border-image: linear-gradient(to bottom,  #2196F3, #cc0066, rgb(0,0,0,0)) 1 100% ;*/
        border-image: linear-gradient(to bottom,  #0099cc, #ccff00, rgb(0,0,0,0)) 1 100% ;
    }
    .card-header{
        background-color: transparent;
        border-bottom: 0px;
    }
    #pnlTablero.card-body{
        padding-top: 10px;
    }
    .card-header{
        padding: 0px;
    }
    li.list-group-item {
        padding-top: 3px;
        padding-bottom: 3px;
    }
    li.list-group-item:hover {
        font-weight: bold;
        color: #fff;
        cursor: pointer;
        background-color: #3f51b5;
        -webkit-box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        -moz-box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        padding-top: 3px;
        padding-bottom: 3px;
        animation: myfirst .4s;
        -moz-animation:myfirst 1.4s infinite; /* Firefox */
        -webkit-animation:myfirst 1.4s infinite; /* Safari and Chrome */
        border-radius: 5px;
    }
    .li-selected{
        font-weight: bold;
        color: #D32F2F;
        cursor: pointer;
        background-color: #fff;
        padding-top: 3px;
        padding-bottom: 3px;
        border-radius: 0px;
        font-weight: bold;
    }
    .li-selected span.badge-primary{
        font-weight: bold;
        color: #fff;
        background-color: #D32F2F;
        padding-top: 3px;
        padding-bottom: 3px;
    }
    ul.list-group {
        animation: highlight .4s;
        -moz-animation:highlight 1.4s infinite; /* Firefox */
        -webkit-animation:highlight 1.4s infinite; /* Safari and Chrome */
        border-radius: 5px;
    }

    table tbody tr:hover {
        font-weight:normal !important;
    }

    .box-success{
        box-shadow: 0 0 0 0.2rem #CDDC39 !important;
    }

    .box-info{
        box-shadow: 0 0 0 0.2rem #33C2E1 !important;
    }

    @-moz-keyframes myfirst /* Firefox */
    {
        0%   {    border: 1px solid #2196F3}
        50%  {    border: 1px solid #6610f2;        font-weight: bold;}
        100%   {border: 1px solid #2196F3}
    }

    @-webkit-keyframes myfirst /* Firefox */
    {
        0%   {    border: 1px solid #2196F3}
        50%  {    border: 1px solid #6610f2;font-weight: bold;}
        100%   {border: 1px solid #2196F3}
    }

    @-moz-keyframes highlight /* Firefox */
    {
        0%   {    border: 1px solid #3F51B5}
        50%  {    border: 1px solid #2196f3;        }
        100%   {border: 1px solid #3F51B5}
    }

    @-webkit-keyframes highlight /* Firefox */
    {
        0%   {    border: 1px solid #3F51B5}
        50%  {    border: 1px solid #2196f3;}
        100%   {border: 1px solid #3F51B5}
    }

    /*SWITCH*/
    .switch {
        font-size: 1rem;
        position: relative;
    }
    .switch input {
        position: absolute;
        height: 1px;
        width: 1px;
        background: none;
        border: 0;
        clip: rect(0 0 0 0);
        clip-path: inset(50%);
        overflow: hidden;
        padding: 0;
    }
    .switch input + label {
        position: relative;
        min-width: calc(calc(2.375rem * .8) * 2);
        border-radius: calc(2.375rem * .8);
        height: calc(2.375rem * .8);
        line-height: calc(2.375rem * .8);
        display: inline-block;
        cursor: pointer;
        outline: none;
        user-select: none;
        vertical-align: middle;
        text-indent: calc(calc(calc(2.375rem * .8) * 2) + .5rem);
    }
    .switch input + label::before,
    .switch input + label::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: calc(calc(2.375rem * .8) * 2);
        bottom: 0;
        display: block;
    }
    .switch input + label::before {
        right: 0;
        background-color: #dee2e6;
        border-radius: calc(2.375rem * .8);
        transition: 0.2s all;
    }
    .switch input + label::after {
        top: 2px;
        left: 2px;
        width: calc(calc(2.375rem * .8) - calc(2px * 2));
        height: calc(calc(2.375rem * .8) - calc(2px * 2));
        border-radius: 50%;
        background-color: white;
        transition: 0.2s all;
    }
    .switch input:checked + label::before {
        background-color: #08d;
    }
    .switch input:checked + label::after {
        margin-left: calc(2.375rem * .8);
    }
    .switch input:focus + label::before {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 136, 221, 0.25);
    }
    .switch input:disabled + label {
        color: #868e96;
        cursor: not-allowed;
    }
    .switch input:disabled + label::before {
        background-color: #e9ecef;
    }
    .switch.switch-sm {
        font-size: 0.875rem;
    }
    .switch.switch-sm input + label {
        min-width: calc(calc(1.9375rem * .8) * 2);
        height: calc(1.9375rem * .8);
        line-height: calc(1.9375rem * .8);
        text-indent: calc(calc(calc(1.9375rem * .8) * 2) + .5rem);
    }
    .switch.switch-sm input + label::before {
        width: calc(calc(1.9375rem * .8) * 2);
    }
    .switch.switch-sm input + label::after {
        width: calc(calc(1.9375rem * .8) - calc(2px * 2));
        height: calc(calc(1.9375rem * .8) - calc(2px * 2));
    }
    .switch.switch-sm input:checked + label::after {
        margin-left: calc(1.9375rem * .8);
    }
    .switch.switch-lg {
        font-size: 1.25rem;
    }
    .switch.switch-lg input + label {
        min-width: calc(calc(3rem * .8) * 2);
        height: calc(3rem * .8);
        line-height: calc(3rem * .8);
        text-indent: calc(calc(calc(3rem * .8) * 2) + .5rem);
    }
    .switch.switch-lg input + label::before {
        width: calc(calc(3rem * .8) * 2);
    }
    .switch.switch-lg input + label::after {
        width: calc(calc(3rem * .8) - calc(2px * 2));
        height: calc(calc(3rem * .8) - calc(2px * 2));
    }
    .switch.switch-lg input:checked + label::after {
        margin-left: calc(3rem * .8);
    }
    .switch + .switch {
        margin-left: 1rem;
    }
    .dropdown-menu {
        margin-top: 0.75rem;
    }
    .custom-control.custom-checkbox:hover{
        cursor: pointer !important;
    }
</style>A