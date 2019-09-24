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

            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8" >
                <div class="row">
                    <div class="col-4">
                        <input type="text" id="ControlF" name="ControlF" class="form-control form-control-sm" placeholder="Control a buscar...">
                    </div>
                    <div class="col-4">
                        <input type="text" id="EstiloF" name="EstiloF" class="form-control form-control-sm" placeholder="Estilo a buscar...">
                    </div>
                    <div class="col-4">
                        <input type="text" id="DocumentoF" name="DocumentoF" class="form-control form-control-sm" placeholder="Documento a buscar...">
                    </div>
                </div>
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
                <input type="text" id="Control" name="Control" disabled="" class="form-control form-control-sm numbersOnly"> 
                <input type="text" id="TP" name="TP" readonly="" class="d-none form-control form-control-sm numbersOnly"> 
                <input type="text" id="DOCUMENTO" name="DOCUMENTO" readonly="" class="d-none form-control form-control-sm numbersOnly"> 
                <input type="text" id="PRECIO" name="PRECIO" readonly="" class="d-none form-control form-control-sm numbersOnly"> 
                <input type="text" id="MAQUILA" name="MAQUILA" readonly="" class="d-none form-control form-control-sm numbersOnly"> 
                <button type="button" class="btn btn-black-o btn-block mt-1" id="btnControlCompleto" name="btnControlCompleto" disabled="">
                    <span class="fa fa-dot-circle"></span>  Ctrl /Completo
                </button>
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
                                    print '<td><input type="text"  id="C' . $index . '" maxlength="3"  readonly="" class="form-control form-control-sm numbersOnly style-pares" name="C' . $index . '"  data-toggle="tooltip" data-placement="top" title="-" onfocus="getTotalPares();" onchange="getTotalPares();" keyup="getTotalPares();" onfocusout="getTotalPares();"></td>';
                                }
                                ?>
                                <td class="font-weight-bold"><input type="text" style="width: 45px;" id="TotalParesEntrega" class="form-control form-control-sm  style-pares" readonly=""  data-toggle="tooltip" data-placement="top" title="0"></td>
                                <td>
                                </td>
                            </tr>
                            <tr class="rCapturaCantidades" id="rCantidades">
                                <td class="font-weight-bold">Pares facturados</td>
                                <?php
                                for ($index = 1; $index < 23; $index++) {
                                    print '<td><input type="text"  id="CF' . $index . '" maxlength="3"  readonly="" class="form-control form-control-sm numbersOnly style-pares" name="CF' . $index . '" onfocus="getTotalPares();" onchange="getTotalPares();" keyup="getTotalPares();" onfocusout="getTotalPares();"></td>';
                                }
                                ?>
                                <td class="font-weight-bold">
                                    <input type="text" style="width: 45px;" id="TotalParesEntregaF" 
                                           class="form-control form-control-sm  style-pares" readonly="" data-toggle="tooltip" data-placement="right" title="0">
                                </td>
                            </tr>
                            <tr class="rCapturaCantidades" id="rCantidades">
                                <td class="font-weight-bold">Pares devueltos</td>
                                <?php
                                for ($index = 1; $index < 23; $index++) {
                                    print '<td><input type="text" id="PDF' . $index . '" indice="' . $index . '" maxlength="3" class="form-control form-control-sm numbersOnly style-pares" name="PDF' . $index . '" onfocus="getTotalPares();" onchange="getTotalPares();" keyup="getTotalPares();" onfocusout="getTotalPares();"></td>';
                                }
                                ?>
                                <td class="font-weight-bold"><input type="text" style="width: 45px;" id="TotalParesEntregaAF" class="form-control form-control-sm  style-pares" readonly=""  data-toggle="tooltip" data-placement="right" title="0"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!--BREAK-->
            <div class="w-100"></div>
            <!--BREAK-->
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <label>Motivo</label>
                <input type="text" id="Motivo" name="Motivo" placeholder="Escriba el motivo por el cual se devuelve..." class="form-control form-control-sm" maxlength="500">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mt-4"> 
                <span class="text-danger font-weight-bold color_t">-</span>
                <input type="text" id="Color" name="Color" class="form-control form-control-sm d-none" readonly=""  maxlength="500">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 mt-4"> 
                <span class="text-danger font-weight-bold estilo_t">-</span>
                <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm d-none" readonly="" maxlength="500">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-1 col-xl-1 mt-4"> 
                <span class="text-danger font-weight-bold color_clave">-</span>
                <input type="text" id="ColorClave" name="ColorClave" class="form-control form-control-sm d-none" readonly=""  maxlength="15">
            </div>
            <!--PEDIDOS-->
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                <table id="tblDevoluciones" class="table table-hover table-sm"  style="width: 100% !important;">
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
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <button type="button" class="btn btn-black-o btn-block" id="btnAcepta" name="btnAcepta" disabled="">
                            <span class="fa fa-check"></span>  Acepta
                        </button>
                    </div>
                    <div class="w-100 my-1"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <button type="button" class="btn btn-black-o btn-block" id="btnReportesDev" name="btnReportesDev">
                            <span class="fa fa-file"></span>  Reportes
                        </button>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <button type="button" class="btn btn-black-o notEnter" id="btnDefectos" name="btnDefectos"><span class="fa fa-file"></span>  Defecto</button>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <button type="button" class="btn btn-black-o notEnter" id="btnDetalle" name="btnDetalle"><span class="fa fa-dot-circle"></span>  Detalle</button>
                    </div>
                    <div class="w-100 my-1"></div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 " align="center"> 
                        <button type="button" class="btn btn-black-o notEnter" id="btnRastreoCtrlDoc" name="btnRastreoCtrlDoc"><span class="fa fa-file"></span> Rastreo ctr/doc</button>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 " align="center"> 
                        <button type="button" class="btn btn-black-o notEnter" id="btnRastreoEstiloCliente" name="btnRastreoEstiloCliente"><span class="fa fa-file"></span> Rastreo est/cte</button>
                    </div>
                </div>
            </div>
            <!--PEDIDOS-->
        </div>
    </div>
</div>

<div class="modal" id="mdlReportesDevoluciones">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Devoluciones no aplicadas ni facturadas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <h4>Nota capture fechas y oprima enter</h4>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <label>De la fecha</label> 
                        <input type="text" id="DeLaFechaDev" name="DeLaFechaDev" class="form-control form-control-sm date notEnter">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <label>A la fecha</label>
                        <input type="text" id="ALaFechaDev" name="ALaFechaDev" class="form-control form-control-sm date notEnter">
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="rNormalDev" name="Reporte" class="custom-control-input" valor="1">
                                        <label class="custom-control-label text-info" for="rNormalDev">Normal</label>
                                    </div> 
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="rPorClienteDev" name="Reporte" class="custom-control-input" valor="2">
                                        <label class="custom-control-label text-danger" for="rPorClienteDev">Por cliente</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="rPorMaquilaDev" name="Reporte" class="custom-control-input" valor="3">
                                        <label class="custom-control-label text-info" for="rPorMaquilaDev">Por maquila</label>

                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="rPorDefectoDetalleDev" name="Reporte" class="custom-control-input" valor="4">
                                        <label class="custom-control-label text-danger" for="rPorDefectoDetalleDev">Por defecto detalle</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="rAgtCteDepDefeDetaDev" name="Reporte" class="custom-control-input" valor="5">
                                        <label class="custom-control-label text-info" for="rAgtCteDepDefeDetaDev">Por Agt.Cte.Dep.Defe.Deta</label>
                                    </div>
                                </div>
                            </div><!--ROW-->
                        </div><!--FORM-GROUP-->
                    </div><!--COL-12-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptaReporteDevolucion">Aceptar</button>
            </div>
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
            PRECIO = pnlTablero.find("#PRECIO"),
            MAQUILA = pnlTablero.find("#MAQUILA"),
            Pedidos,
            tblPedidos = pnlTablero.find('#tblPedidos'),
            Control = pnlTablero.find('#Control'),
            DOCUMENTO = pnlTablero.find("#DOCUMENTO"),
            TP = pnlTablero.find("#TP"),
            Color = pnlTablero.find('#Color'),
            Estilo = pnlTablero.find('#Estilo'),
            ColorClave = pnlTablero.find("#ColorClave"),
            tblTallasF = pnlTablero.find('#tblTallasF'),
            TotalParesEntrega = pnlTablero.find('#TotalParesEntrega'),
            TotalParesEntregaF = pnlTablero.find('#TotalParesEntregaF'),
            TotalParesEntregaAF = pnlTablero.find('#TotalParesEntregaAF'),
            btnControlCompleto = pnlTablero.find("#btnControlCompleto"),
            Devoluciones,
            tblDevoluciones = pnlTablero.find('#tblDevoluciones'),
            btnDefectos = pnlTablero.find("#btnDefectos"),
            btnDetalle = pnlTablero.find("#btnDetalle"),
            btnRastreoCtrlDoc = pnlTablero.find("#btnRastreoCtrlDoc"),
            btnRastreoEstiloCliente = pnlTablero.find("#btnRastreoEstiloCliente"),
            Hoy = '<?php print Date('d/m/Y'); ?>',
            control_pertenece_a_cliente = false,
            Motivo = pnlTablero.find("#Motivo"),
            ControlF = pnlTablero.find("#ControlF"),
            EstiloF = pnlTablero.find("#EstiloF"),
            DocumentoF = pnlTablero.find("#DocumentoF"),
            btnAcepta = pnlTablero.find("#btnAcepta"),
            btnReportesDev = pnlTablero.find("#btnReportesDev"),
            mdlReportesDevoluciones = $("#mdlReportesDevoluciones"),
            DeLaFechaDev = mdlReportesDevoluciones.find("#DeLaFechaDev"),
            ALaFechaDev = mdlReportesDevoluciones.find("#ALaFechaDev"),
            btnAceptaReporteDevolucion = mdlReportesDevoluciones.find("#btnAceptaReporteDevolucion");

    $(document).ready(function () {
        handleEnterDiv(pnlTablero);

        btnAceptaReporteDevolucion.click(function () {
            var r = mdlReportesDevoluciones.find("input[name='Reporte']:checked").attr('valor') ? mdlReportesDevoluciones.find("input[name='Reporte']:checked").attr('valor') : 0;
            var indice = parseInt(r);
            if (DeLaFechaDev.val() && ALaFechaDev.val()) {
                var p = {
                    FECHA_INICIAL: DeLaFechaDev.val() ? DeLaFechaDev.val() : '',
                    FECHA_FINAL: ALaFechaDev.val() ? ALaFechaDev.val() : ''
                };
                console.log("INDICE => " + indice);
                if (indice) {
                    switch (indice) {
                        case 1:
                            /*1 = NORMAL (4 REPORTES)*/
                            onOpenOverlay('');
                            $.post('<?php print base_url('DevolucionesDeClientes/onImprimirRepNormal'); ?>', p).done(function (aaa) {
                                if (aaa.length > 0) {
                                    onImprimirReporteFancyArray(JSON.parse(aaa));
                                }
                            }).fail(function (x, y, z) {
                                getError(x);
                            }).always(function () {
                                onCloseOverlay();
                            });
                            break;
                        case 2:
                            /* 2 = POR CLIENTE*/
                            onOpenOverlay('');
                            $.post('<?php print base_url('DevolucionesDeClientes/onImprimirReportePorCliente'); ?>', p).done(function (aaa) {
                                if (aaa.length > 0) {
                                    onImprimirReporteFancy(aaa);
                                }
                            }).fail(function (x, y, z) {
                                getError(x);
                            }).always(function () {
                                onCloseOverlay();
                            });
                            break;
                    }
                } else {
                    iMsg("DEBE DE ESPECIFICAR UN TIPO DE REPORTE", 'w', function () {

                    });
                }
            } else {
                iMsg("DEBE DE ESPECIFICAR LAS FECHAS", 'w', function () {
                    DeLaFechaDev.focus().select();
                });
            }
        });

        btnReportesDev.click(function () {
            ALaFechaDev.val(Hoy);
            DeLaFechaDev.val(Hoy);
            mdlReportesDevoluciones.modal('show');
        });

        pnlTablero.find("#PDF22").on('keydown', function (e) {
            Motivo.focus().select();
        });

        EstiloF.on('keydown', function () {
            Pedidos.columns(6).search(this.value).draw();
        });

        DocumentoF.on('keydown', function () {
            Pedidos.columns(2).search(this.value).draw();
        });

        ControlF.on('keydown', function () {
            Pedidos.columns(1).search(this.value).draw();
        });

        btnAcepta.click(function () {
            if (ClienteDevolucion.val() && FechaDevolucion.val()) {
                getTotalPares();
                var p = {
                    CLIENTE: ClienteDevolucion.val(), FECHA: FechaDevolucion.val(),
                    DOCUMENTO: DOCUMENTO.val(), MOTIVO: Motivo.val(),
                    CONTROL: Control.val(), ESTILO: Estilo.val(),
                    COLOR: ColorClave.val(), TP: TP.val(),
                    PARES_DEVUELTOS: (TotalParesEntregaAF.val() ? TotalParesEntregaAF.val() : 0),
                    PARES_FACTURADOS: (TotalParesEntregaF.val() ? TotalParesEntregaF.val() : 0)
                };
                for (var i = 1; i < 23; i++) {
                    if (i < 10) {
                        p["PAR0" + i] = (pnlTablero.find("#PDF" + i).val() ? pnlTablero.find("#PDF" + i).val() : 0);
                    } else {
                        p["PAR" + i] = (pnlTablero.find("#PDF" + i).val() ? pnlTablero.find("#PDF" + i).val() : 0);
                    }
                }
                p["DEPARTAMENTO"] = Departamento.val();
                p["DEFECTO"] = Defecto.val();
                p["DETALLE"] = DetalleDefecto.val();
                p["CLASIFICACION"] = Clasificacion.val();
                p["CARGO_A"] = Cargo.val();
                p["SERIE"] = Serie.val();
                p["PRECIO"] = PRECIO.val();
                p["MAQUILA"] = Defecto.val();
                p["PRECIO_DEVOLUCION"] = PRECIO.val();

                $.post('<?php print base_url('DevolucionesDeClientes/onGuardar') ?>', p).done(function (a) {
                    onOpenOverlay('');
                    onResetCampos();
                    Pedidos.ajax.reload(function () {
                        Devoluciones.ajax.reload(function () {
                            onCloseOverlay();
                            Clasificacion[0].selectize.focus();
                        });
                    });
                    onNotifyOld('', 'SE HA GUARDADO LA DEVOLUCION', 'success');
                }).fail(function (x) {
                    getError(x);
                }).always(function () {

                });
            }
        });

        btnRastreoEstiloCliente.click(function () {
            onOpenWindow('<?php print base_url('RastreoDeEstilosEnPedidos'); ?>');
        });

        btnRastreoCtrlDoc.click(function () {
            onOpenWindow('<?php print base_url('RastreoDeControlesEnDocumentosClientes'); ?>');
        });

        btnDetalle.click(function () {
            onOpenWindow('<?php print base_url('DetallesDefectos/?origen=CLIENTES'); ?>');
        });

        btnDefectos.click(function () {
            onOpenWindow('<?php print base_url('Defectos/?origen=CLIENTES'); ?>');
        });

        btnControlCompleto.click(function () {
            for (var i = 1; i < 23; i++) {
                pnlTablero.find("#PDF" + i).val(pnlTablero.find("#C" + i).val());
            }
            getTotalPares();
            onRevisarRegistroValido();
            Motivo.focus().select();
        });

        Motivo.on('keydown', function (e) {
            console.log(e.keyCode);
            if (e.keyCode === 13) {
                onRevisarRegistroValido();
                btnAcepta.focus();
            }
        });

        pnlTablero.find("input[id^=PDF]").on('keydown', function (e) {
            if (Control.val()) {
                console.log($(this).attr("id"), $(this).val());
                if (e.keyCode === 13) {
                    var index = $(this).attr('indice');
                    if (parseInt(($(this).val() ? $(this).val() : 0)) <= parseInt((pnlTablero.find("#CF" + index).val() ? pnlTablero.find("#CF" + index).val() : 0))) {
                        console.log($(this).val(), pnlTablero.find("#CF" + index).val());
                        console.log(parseInt($(this).val()) <= parseInt(pnlTablero.find("#CF" + index).val()));
                    } else {
                        iMsg('LA CANTIDAD A DEVOLVER DEBE DE SER MENOR O IGUAL A LA CANTIDAD FACTURADA', 'w', function () {
                            pnlTablero.find("#PDF" + index).focus().select();
                        });
                    }
                    onRevisarRegistroValido();
                }
            } else {
                iMsg('DEBE DE SELECCIONAR UN CONTROL', 'w', function () {

                });
            }
        });

        ClienteDevolucion.change(function () {
            onOpenOverlay('');
            Pedidos.ajax.reload(function () {
                Devoluciones.ajax.reload(function () {
                    onCloseOverlay();
                    ControlF.val('');
                    EstiloF.val('');
                    DocumentoF.val('');
                    Pedidos.columns(1).search('').draw();
                    Pedidos.columns(2).search('').draw();
                    Pedidos.columns(6).search('').draw();
                });
            });
        });

        Control.on('keydown', function (e) {
            //            if (ClienteDevolucion.val()) {
            //                if (Control.val() && e.keyCode === 13) {
            //                    onOpenOverlay('Buscando...');
            //                    getInfoXControl();
            //                }
            //            } else {
            //                swal('ATENCION', 'DEBE DE ESPECIFICAR UN CLIENTE', 'warning').then((value) => {
            //                    ClienteDevolucion[0].selectize.focus();
            //                });
            //                $(".swal-button--confirm").focus();
            //            }
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
                {"data": "PARES"}, {"data": "ESTILO"},
                {"data": "COLOR"}, {"data": "PRECIO"},
                {"data": "ST"}
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
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": 250,
            "scrollX": true,
            "order": [[4, "desc"]],
            "initComplete": function (settings, json) {
                ClienteDevolucion[0].selectize.focus();
                FechaDevolucion.val(Hoy);
            }
        });

        tblPedidos.on('click', 'tr', function () {
            onBeep(1);
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
                console.log("Z = >", z);
                Control.val(z.CONTROL);
                Color.val(z.COLOR);
                Estilo.val(z.ESTILO);
                ColorClave.val(z.COLOR);
                DOCUMENTO.val(z.DOCUMENTO);
                PRECIO.val(z.PRECIO);
                TP.val(z.TP);
                $.getJSON('<?php print base_url('DevolucionesDeClientes/getColorXControl'); ?>', {
                    CONTROL: z.CONTROL
                }).done(function (a) {
                    console.log(a, a.length);
                    if (a.length > 0) {
                        Color.val(a[0].COLOR_T);
                        pnlTablero.find(".color_t").text(a[0].COLOR_T);
                        pnlTablero.find(".estilo_t").text(z.ESTILO);
                        pnlTablero.find(".color_clave").text(z.COLOR);
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {

                });
                getInfoXControl(z.CONTROL);
                getParesFacturadosXControl(z.CONTROL);
                btnControlCompleto.attr('disabled', false);
            }
        });

        Devoluciones = tblDevoluciones.DataTable({
            dom: 'rtp',
            "ajax": {
                "url": '<?php print base_url('DevolucionesDeClientes/getDevoluciones'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = ClienteDevolucion.val() ? ClienteDevolucion.val() : '';
                    d.CONTROL = Control.val() ? Control.val() : '';
                    d.FECHA = FechaDevolucion.val() ? FechaDevolucion.val() : '';
                }
            },
            "columns": [
                {"data": "ID"},
                {"data": "CLIENTE"}, {"data": "DOCUMENTO"},
                {"data": "CONTROL"}, {"data": "PARES"},
                {"data": "DEFECTO"}, {"data": "DETALLE"},
                {"data": "CLASIFICACION"}, {"data": "CARGO"},
                {"data": "MAQUILA"}, {"data": "FECHA"},
                {"data": "TP"}, {"data": "CONCEPTO"},
                {"data": "PRECIO_DEVOLUCION"}, {"data": "PRECIO_CG"}
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
            "order": [[10, "desc"]],
            "initComplete": function (settings, json) {
            }
        });
    });

    function getInfoXControl(c) {
        var indice_f = 0;
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
                        if (parseInt(xx["C" + i]) <= 0) {
                            pnlTablero.find("#PDF" + i).attr('disabled', true);
                        } else {
                            pnlTablero.find("#PDF" + i).attr('disabled', false);
                            if (indice_f === 0) {
                                indice_f = i;
                            }
                        }
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
            pnlTablero.find("#PDF" + indice_f).focus().select();
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

        Clasificacion[0].selectize.clear();
        Cargo[0].selectize.clear();
        Departamento[0].selectize.clear();
        Defecto[0].selectize.clear();
        DetalleDefecto[0].selectize.clear();

        for (var i = 1; i < 21; i++) {
            pnlTablero.find("#T" + i).val("");
            pnlTablero.find(`#C${i}`).val("");
            pnlTablero.find(`#CF${i}`).val("");
            pnlTablero.find("#PDF" + i).val("");
        }

        Control.val('');
        Estilo.val('');
        Color.val('');
        Serie.val('');
        Motivo.val('');

        Control.attr('disabled', false);
        TotalParesEntrega.val('');
        TotalParesEntregaF.val('');
        TotalParesEntregaAF.val('');
        ColorClave.val('');
        DOCUMENTO.val('');
        PRECIO.val('');
        TP.val('');

        /*BORRAR BUSQUEDAS EN LA TABLA UNO*/
        ControlF.val('');
        EstiloF.val('');
        DocumentoF.val('');
        Pedidos.columns(1).search('').draw();
        Pedidos.columns(2).search('').draw();
        Pedidos.columns(6).search('').draw();
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

    function onRevisarRegistroValido() {
        var pares_a_devolver = 0;
        for (var i = 1; i < 23; i++) {
            pares_a_devolver += parseInt(pnlTablero.find("#PDF" + i).val() ? pnlTablero.find("#PDF" + i).val() : 0);
        }
        console.log(pares_a_devolver);
        if (pares_a_devolver > 0) {
            btnAcepta.attr('disabled', false);
            btnReportes.attr('disabled', false);
        } else {
            btnAcepta.attr('disabled', true);
            btnReportes.attr('disabled', true);
        }
    }
</script>
<style>
    .style-pares{
        width: 35px  !important; 
        padding-left: 2px !important;
        padding-right: 2px !important;
        text-align: center !important;
        font-weight: bold !important;
        border: 1px solid #000 !important;
    }
    input,.selectize-input > * {
        font-weight: bold !important;
    }
</style>