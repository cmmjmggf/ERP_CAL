<div class="card m-3 animated fadeIn" id="pnlTablero" style="background-color:  #fff !important;">
    <div class="card-body " style="padding: 7px 10px 10px 10px;">
        <div class="row">
            <div class="w-100"></div> 
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" >
                        <h5 class="text-danger font-italic">DEVOLUCIONES PENDIENTES POR APLICAR</h5>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                        <label>Cliente</label>
                        <select id="ClienteDevolucion" name="ClienteDevolucion" class="form-control">
                            <option></option>
                            <?php
                            /* YA CONTIENE LOS BLOQUEOS DE VENTA */
                            foreach ($this->db->query("SELECT C.Clave AS CLAVE, CONCAT(C.Clave, \" - \",C.RazonS) AS CLIENTE, C.Zona AS ZONA, C.ListaPrecios AS LISTADEPRECIO FROM clientes AS C LEFT JOIN bloqueovta AS B ON C.Clave = B.cliente WHERE C.Estatus IN('ACTIVO') AND B.cliente IS NULL  OR C.Estatus IN('ACTIVO') AND B.`status` = 2 ORDER BY ABS(C.Clave) ASC;")->result() as $k => $v) {
                                print "<option value='{$v->CLAVE}'>{$v->CLIENTE}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Fecha</label>
                        <input type="text" id="FechaDevolucion" name="FechaDevolucion" class="form-control form-control-sm date notEnter">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Clasificación</label>
                        <select id="Clasificacion" name="Clasificacion" class="form-control form-control-sm">
                            <option></option>
                            <option value="1">1 Para venta</option>
                            <option value="2">2 Saldo</option>
                            <option value="3">3 Reparación</option>
                            <option value="4">4 Muestras y prototipos</option>
                        </select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Cargo</label>
                        <select id="Cargo" name="Cargo" class="form-control form-control-sm">
                            <option></option>
                            <option value="0">0 No</option>
                            <option value="1">1 Proveedor</option>
                            <option value="2">2 Maquila</option> 
                        </select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Depto</label>
                        <select id="Departamento" name="Departamento" class="form-control form-control-sm">
                            <option></option>
                            <?php
                            foreach ($this->db->query("SELECT D.Clave AS CLAVE, D.Descripcion AS DEPTO FROM departamentos AS D ")->result() as $k => $v) {
                                print "<option value=\"{$v->CLAVE}\">{$v->CLAVE} {$v->DEPTO}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Defecto</label>
                        <select id="Defecto" name="Defecto" class="form-control form-control-sm">
                            <option></option>
                            <?php
                            foreach ($this->db->query("SELECT D.Clave AS CLAVE, D.Descripcion AS DEFECTO FROM defectos AS D ")->result() as $k => $v) {
                                print "<option value=\"{$v->CLAVE}\">{$v->CLAVE} {$v->DEFECTO}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Detalle</label>
                        <select id="DetalleDefecto" name="DetalleDefecto" class="form-control form-control-sm">
                            <option></option>
                            <?php
                            foreach ($this->db->query("SELECT DD.Clave AS CLAVE, DD.Descripcion AS DETALLE_DEFECTO FROM defectosdetalle AS DD ")->result() as $k => $v) {
                                print "<option value=\"{$v->CLAVE}\">{$v->CLAVE} {$v->DETALLE_DEFECTO}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-2" align="center">
                        <h5 class="text-danger font-weight-bold serie_control font-italic mt-3">-</h5>
                        <input type="text" id="Serie" name="Serie" class="form-control form-control-sm d-none" readonly="">
                    </div>
                </div>
            </div>

            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 border border-info rounded" >
                <table id="tblPedidos" class="table table-hover table-sm"  style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Control</th><!--1-->
                            <th scope="col">Docto</th><!--2-->
                            <th scope="col">TP</th><!--3-->
                            <th scope="col">Fecha</th><!--4-->
                            <th scope="col">Pares</th><!--5-->
                            <th scope="col">Estilo</th><!--6--><!--1-->
                            <th scope="col">Color</th><!--7--><!--2-->
                            <th scope="col">Precio</th><!--8--><!--3-->
                            <th scope="col">ST</th><!--9--><!--4--> 
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <hr>
            </div>

            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Control</label>
                <input type="text" id="Control" name="Control" class="form-control form-control-sm numbersOnly"> 
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-7">
                <div class="table-responsive" style="overflow-x:auto; white-space: nowrap;">
                    <table id="tblTallasF" class="Tallas">
                        <thead></thead>
                        <tbody>
                            <tr id="rTallasBuscaManual">
                                <td class="font-weight-bold">Tallas</td>
                                <?php
                                for ($index = 1; $index < 23; $index++) {
                                    print "<td align='center'><span class=\"T{$index}\">-</span></td>";
                                }
                                ?>                        
                                <td></td> 
                            </tr>  
                            <tr class="rCapturaCantidades" id="rCantidades">
                                <td class="font-weight-bold">Pares d'control</td>
                                <?php
                                for ($index = 1; $index < 23; $index++) {
                                    print '<td><input type="text" style="width: 40px; font-weight: 300 !important; cursor: no-allowed !important;" id="C' . $index . '" maxlength="3"  readonly="" class="form-control form-control-sm numbersOnly " name="C' . $index . '"  data-toggle="tooltip" data-placement="top" title="-" onfocus="getTotalPares();" onchange="getTotalPares();" keyup="getTotalPares();" onfocusout="getTotalPares();"></td>';
                                }
                                ?>
                                <td class="font-weight-bold"><input type="text" style="width: 45px;" id="TotalParesEntrega" class="form-control form-control-sm " readonly=""  data-toggle="tooltip" data-placement="top" title="0"></td>
                                <td>
                                </td>
                            </tr>
                            <tr class="rCapturaCantidades" id="rCantidades">
                                <td class="font-weight-bold">Pares facturados</td>
                                <?php
                                for ($index = 1; $index < 23; $index++) {
                                    print '<td><input type="text" style="width: 40px;font-weight: 300 !important;  cursor: no-allowed !important;" id="CF' . $index . '" maxlength="3"  readonly="" class="form-control form-control-sm numbersOnly " name="CF' . $index . '" onfocus="getTotalPares();" onchange="getTotalPares();" keyup="getTotalPares();" onfocusout="getTotalPares();"></td>';
                                }
                                ?>
                                <td class="font-weight-bold">
                                    <input type="text" style="width: 45px;" id="TotalParesEntregaF" 
                                           class="form-control form-control-sm " readonly="" data-toggle="tooltip" data-placement="right" title="0">
                                </td>
                            </tr>
                            <tr class="rCapturaCantidades" id="rCantidades">
                                <td class="font-weight-bold">Pares devueltos</td>
                                <?php
                                for ($index = 1; $index < 23; $index++) {
                                    print '<td><input type="text" style="width: 40px;font-weight: 300 !important;" id="PDF' . $index . '" maxlength="3" class="form-control form-control-sm numbersOnly " name="PDF' . $index . '" onfocus="getTotalPares();" onchange="getTotalPares();" keyup="getTotalPares();" onfocusout="getTotalPares();"></td>';
                                }
                                ?>
                                <td class="font-weight-bold"><input type="text" style="width: 45px;" id="TotalParesEntregaAF" class="form-control form-control-sm " readonly=""  data-toggle="tooltip" data-placement="right" title="0"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <button type="button" class="btn btn-black btn-block" id="btnAcepta" name="btnAcepta">
                            <span class="fa fa-check"></span>  Acepta
                        </button>
                    </div>
                    <div class="w-100 my-1"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <button type="button" class="btn btn-black btn-block" id="btnReportes" name="btnReportes">
                            <span class="fa fa-file"></span>  Reportes
                        </button>
                    </div>
                    <div class="w-100 my-1"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <button type="button" class="btn btn-black btn-block" id="btnControlCompleto" name="btnControlCompleto">
                            <span class="fa fa-dot-circle"></span>  Ctrl /Completo
                        </button>
                    </div> 
                    <div class="w-100 my-1"></div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-center" align="center"> 
                        <div class="btn-group  btn-group-toggle" data-toggle="buttons" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-black" id="btnDefectos" name="btnDefectos">  <span class="fa fa-file"></span>  Defecto</button>
                            <button type="button" class="btn btn-black" id="btnDetalle" name="btnDetalle">  <span class="fa fa-dot-circle"></span>  Detalle</button>
                            <button type="button" class="btn btn-black" id="btnRastreoCtrlDoc" name="btnRastreoCtrlDoc"><span class="fa fa-file"></span> Rastreo ctr/doc</button>
                            <button type="button" class="btn btn-black" id="btnRastreoCtrlDoc" name="btnRastreoCtrlDoc"><span class="fa fa-file"></span> Rastreo est/cte</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--BREAK-->
            <div class="w-100"></div>
            <!--BREAK-->
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <label>Motivo</label>
                <input type="text" id="Motivo" name="Motivo" class="form-control form-control-sm" maxlength="500">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mt-4"> 
                <input type="text" id="Color" name="Color" class="form-control form-control-sm" maxlength="500">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 mt-4"> 
                <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm" maxlength="500">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-1 col-xl-1 mt-4"> 
                <input type="text" id="ColorClave" name="ColorClave" class="form-control form-control-sm" maxlength="15">
            </div>
            <!--PEDIDOS-->
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
                <table id="tblPedidos" class="table table-hover table-sm"  style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Cte</th><!--1-->
                            <th scope="col">Docto</th><!--2-->
                            <th scope="col">Control</th><!--3-->
                            <th scope="col">Pares</th><!--4-->
                            <th scope="col">Def</th><!--5-->
                            <th scope="col">Det</th><!--6--><!--1-->
                            <th scope="col">Cla</th><!--7--><!--2-->
                            <th scope="col">Cargo</th><!--8--><!--3-->
                            <th scope="col">Maq</th><!--9--><!--4--> 
                            <th scope="col">Fecha</th><!--10--><!--5--> 
                            <th scope="col">Tp</th><!--11--><!--6--> 
                            <th scope="col">Concepto</th><!--12--><!--7--> 
                            <th scope="col">Pre-dev</th><!--13--><!--8--> 
                            <th scope="col">Pre-ceg</th><!--14--><!--9--> 
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!--PEDIDOS-->
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"),
            ClienteDevolucion = pnlTablero.find('#ClienteDevolucion'),
            FechaDevolucion = pnlTablero.find('#FechaDevolucion'),
            Clasificacion = pnlTablero.find('#Clasificacion'),
            Cargo = pnlTablero.find('#Cargo'),
            Departamento = pnlTablero.find('#Departamento'),
            Defecto = pnlTablero.find('#Defecto'),
            DetalleDefecto = pnlTablero.find('#DetalleDefecto'),
            Serie = pnlTablero.find('#Serie'),
            Pedidos,
            tblPedidos = pnlTablero.find('#tblPedidos'),
            Control = pnlTablero.find('#Control'), Serie = pnlTablero.find('#Serie'),
            tblTallasF = pnlTablero.find('#tblTallasF'),
            TotalParesEntrega = pnlTablero.find('#TotalParesEntrega'),
            TotalParesEntregaF = pnlTablero.find('#TotalParesEntregaF'),
            TotalParesEntregaAF = pnlTablero.find('#TotalParesEntregaAF'),
            Hoy = '<?php print Date('d/m/Y'); ?>',
            control_pertenece_a_cliente = false;

    $(document).ready(function () {
        getidsInputSelect(pnlTablero);

        handleEnterDiv(pnlTablero);

        pnlTablero.find("input[id^=PDF]").on('keydown', function (e) {
            console.log($(this).attr("id"), $(this).val());
            if (e.keyCode === 13) {
                var idx = $(this).attr("id");
                var PFA = pnlTablero.find("#")
            }
        });

        ClienteDevolucion.change(function () {
            onOpenOverlay('');
            Pedidos.ajax.reload(function () {
                onCloseOverlay();
            });
        });
        Control.on('keydown', function (e) {
            if (ClienteDevolucion.val()) {
                if (Control.val() && e.keyCode === 13) {
                    onOpenOverlay('Buscando...');
                    getInfoXControl();
                }
            } else {
                swal('ATENCION', 'DEBE DE ESPECIFICAR UN CLIENTE', 'warning').then((value) => {
                    ClienteDevolucion[0].selectize.focus();
                });
                $(".swal-button--confirm").focus();
            }
        });

        Pedidos = tblPedidos.DataTable({
            dom: 'rtp',
            "ajax": {
                "url": '<?php print base_url('DevolucionesDeClientes/getPedidos'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = ClienteDevolucion.val() ? ClienteDevolucion.val() : '';
                }
            },
            "columns": [
                {"data": "ID"},
                {"data": "CONTROL"}, {"data": "DOCUMENTO"},
                {"data": "TP"}, {"data": "FECHA"},
                {"data": "PARES"},
                {"data": "ESTILO"}, {"data": "COLOR"},
                {"data": "PRECIO"}, {"data": "ST"}
            ],
            "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true, "scrollCollapse": false,
            "bSort": true,
            "scrollY": 250,
            "scrollX": true,
            "initComplete": function (settings, json) {
                ClienteDevolucion[0].selectize.focus();
                FechaDevolucion.val(Hoy);
            }
        });

        tblPedidos.on('click', 'tr', function () {
            //            onOpenOverlay('Por favor espere...');
            var campos = ["ClienteDevolucion", "FechaDevolucion", "Clasificacion",
                "Cargo", "Departamento", "Defecto", "DetalleDefecto"];
            var cvalidos = false, cpo = "";
            $.each(campos, function (k, v) {
                if ($("#" + v).val()) {
                    cvalidos = true;
                } else {
                    cvalidos = false;
                    cpo = v;
                    return false;
                }
            });
            if (!cvalidos) {
                iMsg('DEBE DE ESPECIFICAR TODOS LOS FILTROS', 'w', function () {
                    if (pnlTablero.find("#" + cpo).is('select')) {
                        pnlTablero.find("#" + cpo)[0].selectize.open();
                        pnlTablero.find("#" + cpo)[0].selectize.focus();
                    } else {
                        pnlTablero.find("#" + cpo).focus().select();
                    }
                });
            }
            if (cvalidos) {
                var z = Pedidos.row($(this)).data();
                console.log(z);
                Control.val(z.CONTROL);
                getInfoXControl(z.CONTROL);
                getParesFacturadosXControl(z.CONTROL);
            }
        });

    });

    function getInfoXControl(c) {
        onOpenOverlay('Cargando...');
        $.getJSON('<?php print base_url('DevolucionesDeClientes/getInfoXControl'); ?>', {
            CONTROL: c
        }).done(function (a) {
            if (a.length > 0) {
                var xx = a[0];
                Serie.val(xx.Serie);
                pnlTablero.find(".serie_control").text(xx.Serie);
                var t = 0;
                for (var i = 1; i < 21; i++) {
                    if (parseInt(xx["T" + i]) > 0) {
                        pnlTablero.find("#T" + i).val(xx["T" + i]);
                        pnlTablero.find("span.T" + i).text(xx["T" + i]);
                        pnlTablero.find("#T" + i).attr("title", xx["T" + i]);
                        pnlTablero.find("#T" + i).attr("data-original-title", xx["T" + i]);
                        pnlTablero.find(`#C${i}`).val(xx["C" + i]);
                        var cf = (parseInt(pnlTablero.find("#CF" + i).val()) > 0 ? parseInt(pnlTablero.find("#CF" + i).val()) : 0);
                        /* PDF = Pares Devueltos Facturados*/
                        //                        pnlTablero.find("#PDF" + i).val((parseFloat(xx["C" + i]) > 0 ? parseInt(xx["C" + i]) - cf : 0));
                        pnlTablero.find("#C" + i).attr("title", xx["C" + i]);
                        pnlTablero.find("#C" + i).attr("data-original-title", xx["C" + i]);
                        t += parseInt(xx["C" + i]);
                        TotalParesEntrega.val(t);
                        TotalParesEntregaAF.val(t);
                    }
                }
            } else {
                Control.focus().select();
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            onCloseOverlay();
            pnlTablero.find("#PDF1").focus().select();
        });
    }
    function getTotalPares() {
        var ttp = 0, ttpf = 0, ttpaf = 0;
        for (var i = 1; i < 23; i++) {
            var c_component = pnlTablero.find("#C" + i),
                    cf_component = pnlTablero.find("#CF" + i),
                    caf_component = pnlTablero.find("#PDF" + i);
            ttp += (c_component.val() ? parseInt(c_component.val()) : 0);
            ttpf += (cf_component.val() ? parseInt(cf_component.val()) : 0);
            ttpaf += (caf_component.val() ? parseInt(caf_component.val()) : 0);
        }
        TotalParesEntrega.val(ttp);
        TotalParesEntregaF.val(ttpf);
        TotalParesEntregaAF.val(ttpaf);
        pnlTablero.find(".produccionfabricados").text(ttp);
        pnlTablero.find(".produccionfacturados").text(ttpf);
        pnlTablero.find(".produccionsaldo").text((ttpf > 0) ? ttpaf : ttp);
    }
    function onResetCampos() {
        Corrida.val('');
        for (var i = 1; i < 21; i++) {
            pnlTablero.find("#T" + i).val("");
            pnlTablero.find(`#C${i}`).val("");
            pnlTablero.find("#PDF" + i).val("");
        }
        Control.attr('disabled', false);
        TotalParesEntrega.val('');
        TotalParesEntregaF.val('');
        TotalParesEntregaAF.val('');
        getTotalFacturado();
    }

    function getParesFacturadosXControl(c) {
        $.getJSON('<?php print base_url('DevolucionesDeClientes/getParesFacturadosXControl') ?>', {CONTROL: c}).done(function (a) {
            console.log(a);
            var xx = a[0];
            for (var i = 1; i < 21; i++) {
                var cf = (parseInt(pnlTablero.find("#CF" + i).val()) > 0 ? parseInt(pnlTablero.find("#CF" + i).val()) : 0);
                if (i < 10) {
                    pnlTablero.find("#CF" + i).val(xx["par0" + i]);
                } else {
                    pnlTablero.find("#CF" + i).val(xx["par" + i]);
                }
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }
</script>