<div class="modal" id="mdlConsPifo">
    <div class="modal-dialog  modal-lg modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="fa fa-cut"></span> Consumo piel forro, cortador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <label>Maquila</label>
                        <input type="text" id="MaquilaCorte" name="MaquilaCorte" class="form-control numbersOnly" maxlength="2">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <label>De la semana</label>
                        <input type="text" id="SemanaIniciaCorte" name="SemanaIniciaCorte" class="form-control numbersOnly" maxlength="2">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <label>A la semana</label>
                        <input type="text" id="SemanaFinalizaCorte" name="SemanaFinalizaCorte" class="form-control numbersOnly" maxlength="2">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <label>Año</label>
                        <input type="text" id="AnioCorte" name="AnioCorte" class="form-control numbersOnly" maxlength="4">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <label>Cortador</label>
                        <select id="EmpleadoCorte" name="EmpleadoCorte" class="form-control">
                            <option></option>
                            <?php
                            $data = $this->db->select("E.Numero AS CLAVE, CONCAT(E.Numero ,' ',E.PrimerNombre, ' ', E.SegundoNombre,' ', E.Paterno,' ', E.Materno) AS EMPLEADO", false)
                                            ->from('empleados AS E')->join('departamentos AS D', 'E.DepartamentoFisico = D.Clave')
                                            ->join('asignapftsacxc AS ACXC', 'E.Numero = ACXC.Empleado')
                                            ->where('D.Descripcion = \'CORTE\'', null, false)
                                            ->where('E.AltaBaja', 1)->group_by('E.Numero')->get()->result();
                            foreach ($data as $k => $v) {
                                print "<option value='{$v->CLAVE}'>{$v->EMPLEADO}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <label>Articulo</label>
                        <select id="ArticuloCorte" name="ArticuloCorte" class="form-control">
                            <option></option> 
                        </select>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-2">
                        <label>Fecha Inicial</label>
                        <input type="text" id="FechaInicialCorte" name="FechaInicialCorte"  class="form-control form-control-sm date notEnter" placeholder="" >
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-2">
                        <label>Fecha Final</label>
                        <input type="text" id="FechaFinalCorte" name="FechaFinalCorte"  class="form-control form-control-sm date notEnter" placeholder="" >
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-6 text-center">
                        <button id="btnConsumoDePiel" type="button" class="btn btn-sm btn-info btn-block">
                            <span class="fa fa-cut"></span> Consumo de piel</button>
                    </div>
                    <div class="col-6 text-center">
                        <button  id="btnConsumoDeForro" type="button" class="btn btn-sm btn-primary btn-block">
                            <span class="fa fa-cut"></span> Consumo de forro</button>
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-6 text-center">
                        <button id="btnConsumoDePielGeneral"  type="button" class="btn btn-sm btn-warning-corte btn-block">
                            <span class="fa fa-cut"></span> Consumo de piel general</button>
                    </div>
                    <div class="col-6 text-center">
                        <button id="btnConsumoDeForroGeneral"  type="button" class="btn btn-sm btn-danger-corte btn-block">
                            <span class="fa fa-cut"></span> Consumo de forro general</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" style="background-color: #2e3535;    border-color: #95a5a6;" data-dismiss="modal">
                    <span class="fa fa-times"></span> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url_modal = base_url + 'index.php/ConsumosPielForroCortadores/';
    var mdlConsumosPielForro = $("#mdlConsumosPielForro");

    var mdlConsPifo = $("#mdlConsPifo");
    var MaquilaCorte = mdlConsPifo.find("#MaquilaCorte"),
            SemanaIniciaCorte = mdlConsPifo.find("#SemanaIniciaCorte"),
            SemanaFinalizaCorte = mdlConsPifo.find("#SemanaFinalizaCorte"),
            AnioCorte = mdlConsPifo.find("#AnioCorte"),
            EmpleadoCorte = mdlConsPifo.find("#EmpleadoCorte"),
            ArticuloCorte = mdlConsPifo.find("#ArticuloCorte"),
            FechaInicialCorte = mdlConsPifo.find("#FechaInicialCorte"),
            FechaFinalCorte = mdlConsPifo.find("#FechaFinalCorte");


    var btnConsumoDePiel = mdlConsPifo.find("#btnConsumoDePiel"),
            btnConsumoDeForro = mdlConsPifo.find("#btnConsumoDeForro"),
            btnConsumoDePielGeneral = mdlConsPifo.find("#btnConsumoDePielGeneral"),
            btnConsumoDeForroGeneral = mdlConsPifo.find("#btnConsumoDeForroGeneral");

    $(document).ready(function () {

        /*MODAL REDISEÑADO*/
        mdlConsPifo.on('shown.bs.modal', function () {
            getArticulosCorte();
            mdlConsPifo.find("input").val('');
            mdlConsPifo.find("#EmpleadoCorte")[0].selectize.clear(true);
            mdlConsPifo.find("#AnioCorte").val(new Date().getFullYear());
            mdlConsPifo.find("#MaquilaCorte").focus();
        });

        btnConsumoDeForroGeneral.click(function () {
            if (MaquilaCorte.val()) {
                HoldOn.open({
                    theme: 'sk-cube',
                    message: 'GENERANDO...'
                });
                $.post('<?php print base_url('ConsumosPielForroCortadores/getReporteConsumoForroGeneral'); ?>',
                        {
                            TIPO: 2,
                            MAQUILA: MaquilaCorte.val(),
                            SEMANA_INICIAL: SemanaIniciaCorte.val(),
                            SEMANA_FINAL: SemanaFinalizaCorte.val(),
                            ANIO: AnioCorte.val(),
                            CORTADOR: EmpleadoCorte.val(),
                            ARTICULO: ArticuloCorte.val(),
                            FECHA_INICIAL: FechaInicialCorte.val(),
                            FECHA_FINAL: FechaFinalCorte.val()
                        }).done(function (data, x, jq) {
                    onImprimirReporteFancy(data);
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    onBeep(2);
                    swal('ATENCIÓN', 'HA OCURRIDO UN PROBLEMA AL GENERAR LOS REPORTES, REVISE LA CONSOLA PARA MÁS DETALLES', 'warning');
                }).always(function () {
                    console.log('ok');
                    HoldOn.close();
                });
            } else {
                onCampoInvalido(mdlConsPifo, "DEBE DE ESPECIFICAR UNA MAQUILA", "w", function () {
                    MaquilaCorte.focus().select();
                });
            }
        });

        btnConsumoDePielGeneral.click(function () {
            if (MaquilaCorte.val()) {
                HoldOn.open({
                    theme: 'sk-cube',
                    message: 'GENERANDO...'
                });
                $.post('<?php print base_url('ConsumosPielForroCortadores/getReporteConsumoPielGeneral'); ?>',
                        {
                            TIPO: 1,
                            MAQUILA: MaquilaCorte.val(),
                            SEMANA_INICIAL: SemanaIniciaCorte.val(),
                            SEMANA_FINAL: SemanaFinalizaCorte.val(),
                            ANIO: AnioCorte.val(),
                            CORTADOR: EmpleadoCorte.val(),
                            ARTICULO: ArticuloCorte.val(),
                            FECHA_INICIAL: FechaInicialCorte.val(),
                            FECHA_FINAL: FechaFinalCorte.val()
                        }).done(function (data, x, jq) {
                    onImprimirReporteFancy(data);
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    onBeep(2);
                    swal('ATENCIÓN', 'HA OCURRIDO UN PROBLEMA AL GENERAR LOS REPORTES, REVISE LA CONSOLA PARA MÁS DETALLES', 'warning');
                }).always(function () {
                    console.log('ok');
                    HoldOn.close();
                });
            } else {
                onCampoInvalido(mdlConsPifo, "DEBE DE ESPECIFICAR UNA MAQUILA", "w", function () {
                    MaquilaCorte.focus().select();
                });
            }
        });

        btnConsumoDeForro.click(function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'GENERANDO...'
            });
            $.post('<?php print base_url('ConsumosPielForroCortadores/getReportePielForro'); ?>',
                    {
                        TIPO: 2,
                        MAQUILA: MaquilaCorte.val(),
                        SEMANA_INICIAL: SemanaIniciaCorte.val(),
                        SEMANA_FINAL: SemanaFinalizaCorte.val(),
                        ANIO: AnioCorte.val(),
                        CORTADOR: EmpleadoCorte.val(),
                        ARTICULO: ArticuloCorte.val(),
                        FECHA_INICIAL: FechaInicialCorte.val(),
                        FECHA_FINAL: FechaFinalCorte.val()
                    }).done(function (data, x, jq) {
                onImprimirReporteFancy(data);
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                onBeep(2);
                swal('ATENCIÓN', 'HA OCURRIDO UN PROBLEMA AL GENERAR LOS REPORTES, REVISE LA CONSOLA PARA MÁS DETALLES', 'warning');
            }).always(function () {
                console.log('ok');
                HoldOn.close();
            });
        });

        btnConsumoDePiel.click(function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'GENERANDO...'
            });
            $.post('<?php print base_url('ConsumosPielForroCortadores/getReportePielForro'); ?>',
                    {
                        TIPO: 1,
                        MAQUILA: MaquilaCorte.val(),
                        SEMANA_INICIAL: SemanaIniciaCorte.val(),
                        SEMANA_FINAL: SemanaFinalizaCorte.val(),
                        ANIO: AnioCorte.val(),
                        CORTADOR: EmpleadoCorte.val(),
                        ARTICULO: ArticuloCorte.val(),
                        FECHA_INICIAL: FechaInicialCorte.val(),
                        FECHA_FINAL: FechaFinalCorte.val()
                    }).done(function (data, x, jq) {
                onImprimirReporteFancy(data);
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                onBeep(2);
                swal('ATENCIÓN', 'HA OCURRIDO UN PROBLEMA AL GENERAR LOS REPORTES, REVISE LA CONSOLA PARA MÁS DETALLES', 'warning');
            }).always(function () {
                console.log('ok');
                HoldOn.close();
            });
        });

        handleEnterDiv(mdlConsPifo);

        /*FIN MODAL REDISEÑADO*/
        SemanaIniciaCorte.on('keydown', function (e) {
            onVerificarSemana(e, $(this));
        });

        SemanaFinalizaCorte.on('keydown', function (e) {
            onVerificarSemana(e, $(this));
        });

        MaquilaCorte.on('keydown', function (e) {
            onComprobarMaquilas(e, $(this));
        });
    });

    function getArticulosCorte() {
        $.getJSON('<?php print base_url('ConsumosPielForroCortadores/getArticulosCorte'); ?>').done(function (a, b, c) {
            ArticuloCorte[0].selectize.clear(true);
            ArticuloCorte[0].selectize.clearOptions();
            $.each(a, function (k, v) {
                ArticuloCorte[0].selectize.addOption({text: v.ARTICULO, value: v.CLAVE});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {

        });
    }

    function onComprobarMaquilas(e, input) {
        if (e.keyCode === 13 && input.val() !== '') {
            $.getJSON('<?php print base_url('ConsumosPielForroCortadores/onComprobarMaquilas'); ?>', {MAQUILA: input.val()}).done(function (data, x, jq) {
                if (parseInt(data[0].EXISTE_MAQUILA) <= 0) {
                    swal('ATENCIÓN', 'LA MAQUILA ESPECIFICADA NO EXISTE', 'warning').then((value) => {
                        input.focus();
                    });
                }
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            }).always(function () {

            });
        }
    }

    function onVerificarSemana(e, input) {
        if (e.keyCode === 13 && input.val() !== '') {
            $.getJSON('<?php print base_url('ConsumosPielForroCortadores/onChecarSemanaValida'); ?>', {SEMANA: input.val()}).done(function (data, x, jq) {
                if (parseInt(data[0].SEMANA_NO_CERRADA) === 1) {
                    swal('ATENCIÓN', 'LA SEMANA ESPECIFICADA NO EXISTE', 'warning').then((value) => {
                        input.focus();
                    });
                }
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            }).always(function () {

            });
        }
    }
</script>
<style>
    input, button,select, p, label{
        font-weight: bold !important;
    }

    .btn-warning-corte { 
        color: #fff !important;
        background-color: #4CAF50 !important;
        border-color: #009688 !important;
    }
    .btn-danger-corte {  
        color: #fff !important;
        background-color: #d62c1a !important;
        border-color: #ca2a19 !important;
    }
    .modal , .modal button{
        text-transform: uppercase !important;
    }
    .modal-content {
        border-radius: 1px !important;
        border-image: linear-gradient(to bottom, #0099cc, #ccff00, rgb(0,0,0,0)) 1 99% !important;
    }
</style>