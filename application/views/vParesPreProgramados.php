<div class="card m-3 animated fadeIn" id="mdlParesPreProgramados">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Rep.Pares en preprogramación</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label>Cliente</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" id="xPaPreProCliente" name="xPaPreProCliente" class="form-control form-control-sm" autofocus="">
                    </div>
                    <div class="col-9">
                        <select id="PaPreProCliente" name="PaPreProCliente" class="form-control form-control-sm">
                            <option></option>
                            <?php
                            $dtm = $this->db->query("SELECT C.Clave AS CLAVE, C.RazonS AS CLIENTE FROM clientes AS C WHERE C.Estatus = 'ACTIVO' ORDER BY ABS(C.Clave) ASC")->result();
                            foreach ($dtm as $k => $v) {
                                print "<option value='{$v->CLAVE}'>{$v->CLIENTE}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                <label>Maquila</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" id="xPaPreProMaquila" name="xPaPreProMaquila" class="form-control form-control-sm" autofocus="">
                    </div>
                    <div class="col-9">
                        <select id="PaPreProMaquila" name="PaPreProMaquila" class="form-control form-control-sm">
                            <option></option>
                            <?php
                            $dtm = $this->db->select('M.Clave AS CLAVE, M.Nombre AS MAQUILA, M.CapacidadPares AS CAPACIDAD_PARES', false)
                                            ->from('pedidox AS P')
                                            ->join('maquilas AS M', 'P.Maquila = M.Clave')
                                            ->where("P.Control = 0 AND P.Estatus LIKE 'A'", null, false)
                                            ->group_by(array('M.Nombre'))
                                            ->order_by('abs(P.Maquila)', 'ASC')
                                            ->order_by('abs(P.Semana)', 'ASC')->get()->result();
                            foreach ($dtm as $k => $v) {
                                print "<option value='{$v->CLAVE}'>{$v->MAQUILA}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                <label>Semana</label>
                <input type="text" id="PaPreProSemana" name="PaPreProSemana" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                <label>Ano</label>
                <input type="text" id="PaPreProAno" name="PaPreProAno" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label>Linea</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" id="xPaPreProLinea" name="xPaPreProLinea" class="form-control form-control-sm" autofocus="">
                    </div>
                    <div class="col-9">
                        <select id="PaPreProLinea" name="PaPreProLinea" class="form-control form-control-sm">
                            <option></option>
                            <?php
                            foreach ($this->db->select('L.Clave AS CLAVE, L.Descripcion AS LINEA', false)
                                    ->from('pedidox AS P')->join('estilos AS E', 'P.Estilo = E.Clave')
                                    ->join('lineas AS L', 'E.Linea = L.Clave')
                                    ->where("P.Control = 0 AND P.Estatus = 'A'", null, false)
                                    ->group_by('L.Clave')->order_by('ABS(L.Clave)', 'ASC')->get()->result() as $k => $v) {
                                print "<option value=\"{$v->CLAVE}\">{$v->LINEA}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label>Estilo</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" id="xPaPreProEstilo" name="xPaPreProEstilo" class="form-control form-control-sm" autofocus="">
                    </div>
                    <div class="col-9">
                        <select id="PaPreProEstilo" name="PaPreProEstilo" class="form-control form-control-sm">
                            <option></option>
                            <?php
                            foreach ($this->db->select('E.Clave AS CLAVE, E.Descripcion AS ESTILO,E.Linea AS LINEA', false)
                                    ->from('estilos AS E')
                                    ->order_by('ABS(E.Clave)', 'ASC')
                                    ->group_by('E.Clave')->get()->result() as $k => $v) {
                                print "<option value=\"{$v->CLAVE}\">{$v->ESTILO}(LINEA {$v->LINEA})</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="w-100"></div>
            <div class="col-12 my-2">
                <hr>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label>De la fecha</label>
                <input type="text" id="PaPreProFecha" name="PaPreProFecha"  class="form-control form-control-sm date notEnter" placeholder="" >
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <label>A la fecha</label>
                <input type="text" id="PaPreProFechaF" name="PaPreProFechaF"  class="form-control form-control-sm date notEnter" placeholder="" >
            </div>
            <div class="w-100"></div>
            <div class="col-12 my-2">
                <hr>
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                <div class="btn-group btn-group-lg" role="group" aria-label="Opciones">
                    <button id="btnClientePreProgramado" type="button" class="btn btn-success"><span class="fa fa-user-circle"></span> Cliente</button>
                    <button id="btnEstiloPreProgramado" type="button" class="btn btn-warning"><span class="fa fa-dot-circle"></span> Estilo</button>
                    <button id="btnLineasPreProgramado" type="button" class="btn btn-info"><span class="fa fa-align-left"></span> Lineas</button>
                </div>
                <div class="btn-group btn-group-lg" role="group" aria-label="Opciones">
                    <button id="btnMaquilasPreProgramado" type="button" class="btn btn-danger"><span class="fa fa-industry"></span> Maquilas</button>
                    <button id="btnSemanaMaquilaPreProgramado" type="button" class="btn btn-default"><span class="fa fa-calendar"></span> Semana/Maquila</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var mdlParesPreProgramados = $("#mdlParesPreProgramados"),
            Anio = '<?php print Date('Y'); ?>',
            PaPreProAno = mdlParesPreProgramados.find('#PaPreProAno'),
            xPaPreProCliente = mdlParesPreProgramados.find("#xPaPreProCliente"),
            PaPreProCliente = mdlParesPreProgramados.find("#PaPreProCliente"),
            xPaPreProMaquila = mdlParesPreProgramados.find("#xPaPreProMaquila"),
            PaPreProMaquila = mdlParesPreProgramados.find("#PaPreProMaquila"),
            xPaPreProLinea = mdlParesPreProgramados.find("#xPaPreProLinea"),
            PaPreProLinea = mdlParesPreProgramados.find("#PaPreProLinea"),
            xPaPreProEstilo = mdlParesPreProgramados.find("#xPaPreProEstilo"),
            PaPreProEstilo = mdlParesPreProgramados.find("#PaPreProEstilo");


    $(document).ready(function () {
        handleEnterDiv(mdlParesPreProgramados);
        PaPreProAno.val(Anio);

        PaPreProInit();


        PaPreProEstilo.change(function () {
            if (PaPreProEstilo.val()) {
                xPaPreProEstilo.val(PaPreProEstilo.val());
                PaPreProEstilo[0].selectize.disable();
            } else {
                xPaPreProEstilo.val('');
                PaPreProEstilo[0].selectize.enable();
                PaPreProEstilo[0].selectize.clear(true);
            }
        });

        xPaPreProEstilo.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xPaPreProEstilo.val()) {
                    PaPreProEstilo[0].selectize.setValue(xPaPreProEstilo.val());
                    if (PaPreProEstilo.val()) {
                        PaPreProEstilo[0].selectize.disable();
                    } else {
                        onCampoInvalido(mdlParesPreProgramados, 'NO EXISTE ESTE ESTILO, ESPECIFIQUE OTRO', function () {
                            xPaPreProEstilo.focus().select();
                        });
                    }
                } else {
                    PaPreProEstilo[0].selectize.enable();
                    PaPreProEstilo[0].selectize.clear(true);
                }
            } else {
                PaPreProEstilo[0].selectize.enable();
                PaPreProEstilo[0].selectize.clear(true);
            }
        });

        PaPreProLinea.change(function () {
            if (PaPreProLinea.val()) {
                xPaPreProLinea.val(PaPreProLinea.val());
                PaPreProLinea[0].selectize.disable();
            } else {
                xPaPreProLinea.val('');
                PaPreProLinea[0].selectize.enable();
                PaPreProLinea[0].selectize.clear(true);
            }
        });

        xPaPreProLinea.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xPaPreProLinea.val()) {
                    PaPreProLinea[0].selectize.setValue(xPaPreProLinea.val());
                    if (PaPreProLinea.val()) {
                        PaPreProLinea[0].selectize.disable();
                    } else {
                        onCampoInvalido(mdlParesPreProgramados, 'NO EXISTE ESTA LINEA, ESPECIFIQUE OTRA', function () {
                            xPaPreProLinea.focus().select();
                        });
                    }
                } else {
                    PaPreProLinea[0].selectize.enable();
                    PaPreProLinea[0].selectize.clear(true);
                }
            } else {
                PaPreProLinea[0].selectize.enable();
                PaPreProLinea[0].selectize.clear(true);
            }
        });

        PaPreProMaquila.change(function () {
            if (PaPreProMaquila.val()) {
                xPaPreProMaquila.val(PaPreProMaquila.val());
                PaPreProMaquila[0].selectize.disable();
            } else {
                xPaPreProMaquila.val('');
                PaPreProMaquila[0].selectize.enable();
                PaPreProMaquila[0].selectize.clear(true);
            }
        });

        xPaPreProMaquila.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xPaPreProMaquila.val()) {
                    PaPreProMaquila[0].selectize.setValue(xPaPreProMaquila.val());
                    if (PaPreProMaquila.val()) {
                        PaPreProMaquila[0].selectize.disable();
                    } else {
                        onCampoInvalido(mdlParesPreProgramados, 'NO EXISTE ESTA MAQUILA, ESPECIFIQUE OTRA', function () {
                            xPaPreProMaquila.focus().select();
                        });
                    }
                } else {
                    PaPreProMaquila[0].selectize.enable();
                    PaPreProMaquila[0].selectize.clear(true);
                }
            } else {
                PaPreProMaquila[0].selectize.enable();
                PaPreProMaquila[0].selectize.clear(true);
            }
        });

        PaPreProCliente.change(function () {
            if (PaPreProCliente.val()) {
                xPaPreProCliente.val(PaPreProCliente.val());
                PaPreProCliente[0].selectize.enable();
            } else {
                xPaPreProCliente.val('');
                PaPreProCliente[0].selectize.enable();
                PaPreProCliente[0].selectize.clear(true);
            }
        });

        xPaPreProCliente.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xPaPreProCliente.val()) {
                    PaPreProCliente[0].selectize.setValue(xPaPreProCliente.val());
                    if (PaPreProCliente.val()) {
                        PaPreProCliente[0].selectize.disable();
                    } else {
                        onCampoInvalido(mdlParesPreProgramados, 'NO EXISTE ESTE CLIENTE, ESPECIFIQUE OTRO', function () {
                            xPaPreProCliente.focus().select();
                        });
                    }
                } else {
                    PaPreProCliente[0].selectize.enable();
                    PaPreProCliente[0].selectize.clear(true);
                }
            } else {
                PaPreProCliente[0].selectize.enable();
                PaPreProCliente[0].selectize.clear(true);
            }
        });

        mdlParesPreProgramados.on('shown.bs.modal', function () {
            HoldOn.close();
        });

        mdlParesPreProgramados.find("#btnClientePreProgramado").click(function () {
            console.log('CLIENTE');
            getParesPreProgramados(1);
        });

        mdlParesPreProgramados.find("#btnEstiloPreProgramado").click(function () {
            console.log('ESTILO');
            if (xPaPreProEstilo.val()) {
                PaPreProEstilo[0].selectize.setValue(xPaPreProEstilo.val());
                getParesPreProgramados(2);
            } else {
                onCampoInvalido(mdlParesPreProgramados, "ESPECIFIQUE UN ESTILO POR FAVOR", function () {
                    xPaPreProEstilo.focus().select();
                });
            }
        });

        mdlParesPreProgramados.find("#btnLineasPreProgramado").click(function () {
            console.log('LINEAS');
            getParesPreProgramados(3);
        });

        mdlParesPreProgramados.find("#btnMaquilasPreProgramado").click(function () {
            console.log('MAQUILAS');
            getParesPreProgramados(4);
        });

        mdlParesPreProgramados.find("#btnSemanaMaquilaPreProgramado").click(function () {
            console.log('SEMANA/MAQUILA');
            getParesPreProgramados(5);
        });
    });

    function getParesPreProgramados(t) {
        mdlParesPreProgramados.find("input,textarea").attr('disabled', false);
        $.each(mdlParesPreProgramados.find("select:disabled"), function (k, v) {
            $(v)[0].selectize.enable();
        });

        var Cliente = mdlParesPreProgramados.find("#PaPreProCliente").val(),
                Maquila = mdlParesPreProgramados.find("#PaPreProMaquila").val(),
                Semana = mdlParesPreProgramados.find("#PaPreProSemana").val(),
                Fecha = mdlParesPreProgramados.find("#PaPreProFecha").val(),
                FechaF = mdlParesPreProgramados.find("#PaPreProFechaF").val(),
                Linea = mdlParesPreProgramados.find("#PaPreProLinea").val(),
                Estilo = mdlParesPreProgramados.find("#PaPreProEstilo").val();
        HoldOn.open({
            theme: 'sk-bounce',
            message: 'Por favor espere...'
        });
        $.post('<?php print base_url('ParesPreProgramados/getParesPreProgramados'); ?>', {
            CLIENTE: Cliente !== '' ? Cliente : '',
            MAQUILA: Maquila !== '' ? Maquila : '',
            SEMANA: Semana !== '' ? Semana : '',
            FECHA: Fecha !== '' ? Fecha : '',
            FECHAF: FechaF !== '' ? FechaF : '',
            LINEA: Linea !== '' ? Linea : '',
            ESTILO: Estilo !== '' ? Estilo : '',
            TIPO: t,
            ANIO: PaPreProAno.val()
        }).done(function (data, x, jq) {
            console.log(data);
            onBeep(1);
            onImprimirReporteFancy(data);
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
        }).always(function () {
            HoldOn.close();
        });
    }

    function PaPreProInit() {
        mdlParesPreProgramados.find("#PaPreProFecha").val(getToday());
        mdlParesPreProgramados.find("#PaPreProFechaF").val(getToday());
    }
</script>