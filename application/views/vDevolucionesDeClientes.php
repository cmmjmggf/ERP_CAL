<div class="card m-3 animated fadeIn" id="pnlTablero" >
    <div class="card-body " style="padding: 7px 10px 10px 10px;">
        <div class="row">
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" >
                        <h5 class="text-danger font-italic">DEVOLUCIONES PENDIENTES POR APLICAR
                            <span class="text-info font-weight-bold">&nbsp; &nbsp; Folio: </span><span class="text-dark font-weight-bold" id="FolioDev"></span></h5>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                        <label>Cliente</label>
                        <div class="row">
                            <div class="col-2"  style="padding-right: 10px; padding-left: 10px;">
                                <input type="text" id="xClienteDevolucion" name="xClienteDevolucion" class="form-control form-control-sm" maxlength="12">
                            </div>
                            <div class="col-10">
                                <select id="ClienteDevolucion" name="ClienteDevolucion" class="form-control form-control-sm">
                                    <option></option>
                                    <?php
                                    /* YA CONTIENE LOS BLOQUEOS DE VENTA */
                                    foreach ($this->db->query("SELECT C.Clave AS CLAVE,  C.RazonS  AS CLIENTE, C.Zona AS ZONA, C.ListaPrecios AS LISTADEPRECIO FROM clientes AS C   WHERE C.Estatus IN('ACTIVO')  ORDER BY ABS(C.Clave) ASC;")->result() as $k => $v) {
                                        print "<option value='{$v->CLAVE}'>{$v->CLIENTE}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Fecha</label>
                        <input type="text" id="FechaDevolucion" name="FechaDevolucion" class="form-control form-control-sm date notEnter">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Clasificación</label>
                        <div class="row">
                            <div class="col-3" style="padding-right: 10px; padding-left: 10px;">
                                <input type="text" id="xClasificacion" name="xClasificacion" class="form-control numbersOnly" maxlength="1">
                            </div>
                            <div class="col-9">
                                <select id="Clasificacion" name="Clasificacion" class="form-control form-control-sm">
                                    <option></option>
                                    <option value="1">1 Para venta</option>
                                    <option value="2">2 Saldo</option>
                                    <option value="3">3 Reparación</option>
                                    <option value="4">4 Muestras y prototipos</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Cargo</label>
                        <div class="row">
                            <div class="col-3" style="padding-right: 10px; padding-left: 10px;">
                                <input type="text" id="xCargo" name="xCargo" class="form-control numbersOnly" maxlength="1">
                            </div>
                            <div class="col-9">
                                <select id="Cargo" name="Cargo" class="form-control form-control-sm">
                                    <option></option>
                                    <option value="0">0 No</option>
                                    <option value="1">1 Proveedor</option>
                                    <option value="2">2 Maquila</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Depto</label>
                        <div class="row">
                            <div class="col-3" style="padding-right: 10px; padding-left: 10px;">
                                <input type="text" id="xDepartamento" name="xDepartamento" class="form-control numbersOnly" maxlength="3">
                            </div>
                            <div class="col-9">
                                <select id="Departamento" name="Departamento" class="form-control form-control-sm">
                                    <option></option>
                                    <?php
                                    foreach ($this->db->query("SELECT D.Clave AS CLAVE, D.Descripcion AS DEPTO FROM departamentos AS D ")->result() as $k => $v) {
                                        print "<option value=\"{$v->CLAVE}\">{$v->CLAVE} {$v->DEPTO}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Defecto</label>
                        <div class="row">
                            <div class="col-3" style="padding-right: 10px; padding-left: 10px;">
                                <input type="text" id="xDefecto" name="xDefecto" class="form-control numbersOnly" maxlength="4">
                            </div>
                            <div class="col-9">
                                <select id="Defecto" name="Defecto" class="form-control form-control-sm">
                                    <option></option>
                                    <?php
                                    foreach ($this->db->query("SELECT D.Clave AS CLAVE, D.Descripcion AS DEFECTO FROM defectos AS D ")->result() as $k => $v) {
                                        print "<option value=\"{$v->CLAVE}\">{$v->CLAVE} {$v->DEFECTO}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Detalle</label>
                        <div class="row">
                            <div class="col-3" style="padding-right: 10px; padding-left: 10px;">
                                <input type="text" id="xDetalleDefecto" name="xDetalleDefecto" class="form-control numbersOnly" maxlength="4">
                            </div>
                            <div class="col-9">
                                <select id="DetalleDefecto" name="DetalleDefecto" class="form-control form-control-sm">
                                    <option></option>
                                    <?php
                                    foreach ($this->db->query("SELECT DD.Clave AS CLAVE, DD.Descripcion AS DETALLE_DEFECTO FROM defectosdetalle AS DD ")->result() as $k => $v) {
                                        print "<option value=\"{$v->CLAVE}\">{$v->CLAVE} {$v->DETALLE_DEFECTO}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-2" align="center">
                        <h5 class="text-danger font-weight-bold serie_control font-italic mt-3">-</h5>
                        <input type="text" id="Serie" name="Serie" class="form-control form-control-sm d-none" readonly="">
                    </div>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7" >
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
                <input type="text" id="Control" name="Control"  class="form-control form-control-sm numbersOnly">
                <input type="text" id="TP" name="TP" readonly="" class="d-none form-control form-control-sm numbersOnly">
                <input type="text" id="DOCUMENTO" name="DOCUMENTO" readonly="" class="d-none form-control form-control-sm numbersOnly">
                <input type="text" id="PRECIO" name="PRECIO" readonly="" class="d-none form-control form-control-sm numbersOnly">
                <input type="text" id="MAQUILA" name="MAQUILA" readonly="" class="d-none form-control form-control-sm numbersOnly">
                <button type="button" class="btn btn-info btn-block mt-1" id="btnControlCompleto" name="btnControlCompleto" disabled="">
                    <span class="fa fa-bolt"></span>  Ctrl /Completo
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
                                    print '<td><input type="text"  id="C' . $index . '" maxlength="3"  class="form-control form-control-sm numbersOnly style-pares" name="C' . $index . '"  data-toggle="tooltip" data-placement="top" title="-" onfocus="getTotalPares();" onchange="getTotalPares();" keyup="getTotalPares();" onfocusout="getTotalPares();"></td>';
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
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <button type="button" class="btn btn-success btn-block" id="btnAcepta" name="btnAcepta" disabled="">
                            <span class="fa fa-check"></span>  Aceptar
                        </button>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <button type="button" class="btn btn-info btn-block" id="btnNuevoFolio" name="btnNuevoFolio" onclick="onReloadPagina()">
                            <span class="fa fa-file-invoice"></span>  Nuevo Folio
                        </button>
                    </div>
                    <div class="col-12 my-1">
                        <HR>
                    </div>
                    <div class="w-100 my-1"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <button type="button" class="btn btn-info btn-block selectNotEnter" id="btnReportesDev" name="btnReportesDev">
                            <span class="fa fa-file"></span>  Reportes
                        </button>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <button type="button" class="btn btn-info notEnter selectNotEnter" id="btnDefectos" name="btnDefectos"><span class="fa fa-asterisk"></span>  Defecto</button>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <button type="button" class="btn btn-info notEnter selectNotEnter" id="btnDetalle" name="btnDetalle"><span class="fa fa-ban"></span>  Detalle</button>
                    </div>
                    <div class="w-100 my-1"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 " align="center">
                        <button type="button" class="btn btn-info notEnter selectNotEnter" id="btnRastreoCtrlDoc" name="btnRastreoCtrlDoc"><span class="fa fa-search"></span> Rastreo ctr/doc</button>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 " align="center">
                        <button type="button" class="btn btn-info notEnter selectNotEnter" id="btnRastreoEstiloCliente" name="btnRastreoEstiloCliente"><span class="fa fa-search"></span> Rastreo est/cte</button>
                    </div>
                </div>
            </div>
            <!--PEDIDOS-->
        </div>
    </div>
</div>

<div class="modal" id="mdlReportesDevoluciones">
    <div class="modal-dialog notdraggable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title"><span class="fa fa-print"></span> Devoluciones no aplicadas ni facturadas</h5>
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
                <div class="col-6" align="right">
                    <button type="button" class="btn btn-info" id="btnAceptaReporteDevolucion"><span class="fa fa-print"></span> Aceptar</button>
                </div>
                <div class="col-6" align="left">
                    <button type="button" class="btn btn-success" id="btnAceptaReporteDevolucionXLS"><span class="fa fa-file-excel"></span> Exportar a Excel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"),
            xClienteDevolucion = pnlTablero.find('#xClienteDevolucion'),
            ClienteDevolucion = pnlTablero.find('#ClienteDevolucion'),
            FechaDevolucion = pnlTablero.find('#FechaDevolucion'),
            xClasificacion = pnlTablero.find('#xClasificacion'),
            Clasificacion = pnlTablero.find('#Clasificacion'),
            xCargo = pnlTablero.find('#xCargo'),
            Cargo = pnlTablero.find('#Cargo'),
            xDepartamento = pnlTablero.find('#xDepartamento'),
            Departamento = pnlTablero.find('#Departamento'),
            xDefecto = pnlTablero.find('#xDefecto'),
            Defecto = pnlTablero.find('#Defecto'),
            xDetalleDefecto = pnlTablero.find('#xDetalleDefecto'),
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
            FolioDev = pnlTablero.find("#FolioDev"),
            mdlReportesDevoluciones = $("#mdlReportesDevoluciones"),
            DeLaFechaDev = mdlReportesDevoluciones.find("#DeLaFechaDev"),
            ALaFechaDev = mdlReportesDevoluciones.find("#ALaFechaDev"),
            btnAceptaReporteDevolucion = mdlReportesDevoluciones.find("#btnAceptaReporteDevolucion"),
            btnAceptaReporteDevolucionXLS = mdlReportesDevoluciones.find("#btnAceptaReporteDevolucionXLS");

    $(document).ready(function () {
        getConsecutivo();
        handleEnterDiv(pnlTablero);

        handleEnterDiv(mdlReportesDevoluciones);

        xDetalleDefecto.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xDetalleDefecto.val()) {
                    DetalleDefecto[0].selectize.setValue(xDetalleDefecto.val());
                    if (DetalleDefecto.val()) {
                        DetalleDefecto[0].selectize.disable();
                    } else {
                        onCampoInvalido(pnlTablero, 'NO EXISTE ESTE DETALLE DEFECTO, ESPECIFIQUE OTRO', function () {
                            xDetalleDefecto.focus().select();
                        });
                    }
                } else {
                    DetalleDefecto[0].selectize.enable();
                    DetalleDefecto[0].selectize.clear(true);
                }
            } else {
                DetalleDefecto[0].selectize.enable();
                DetalleDefecto[0].selectize.clear(true);
            }
        });

        DetalleDefecto.change(function () {
            if (DetalleDefecto.val()) {
                xDetalleDefecto.val(DetalleDefecto.val());
                DetalleDefecto[0].selectize.disable();
                xDetalleDefecto.focus();
            } else {
                xDetalleDefecto.val('');
                DetalleDefecto[0].selectize.enable();
                DetalleDefecto[0].selectize.clear(true);
            }
        });

        xDefecto.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xDefecto.val()) {
                    Defecto[0].selectize.setValue(xDefecto.val());
                    if (Defecto.val()) {
                        Defecto[0].selectize.disable();
                    } else {
                        onCampoInvalido(pnlTablero, 'NO EXISTE ESTE DEFECTO, ESPECIFIQUE OTRO', function () {
                            xDefecto.focus().select();
                        });
                    }
                } else {
                    Defecto[0].selectize.enable();
                    Defecto[0].selectize.clear(true);
                }
            } else {
                Defecto[0].selectize.enable();
                Defecto[0].selectize.clear(true);
            }
        });

        Defecto.change(function () {
            if (Defecto.val()) {
                xDefecto.val(Defecto.val());
                Defecto[0].selectize.disable();
                xDefecto.focus();
            } else {
                xDefecto.val('');
                Defecto[0].selectize.enable();
                Defecto[0].selectize.clear(true);
            }
        });

        xDepartamento.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xDepartamento.val()) {
                    Departamento[0].selectize.setValue(xDepartamento.val());
                    if (Departamento.val()) {
                        Departamento[0].selectize.disable();
                    } else {
                        onCampoInvalido(pnlTablero, 'NO EXISTE ESTE DEPARTAMENTO, ESPECIFIQUE OTRO', function () {
                            xDepartamento.focus().select();
                        });
                    }
                } else {
                    Departamento[0].selectize.enable();
                    Departamento[0].selectize.clear(true);
                }
            } else {
                Departamento[0].selectize.enable();
                Departamento[0].selectize.clear(true);
            }
        });

        Departamento.change(function () {
            if (Departamento.val()) {
                xDepartamento.val(Departamento.val());
                Departamento[0].selectize.disable();
                xDefecto.focus();
            } else {
                xDepartamento.val('');
                Departamento[0].selectize.enable();
                Departamento[0].selectize.clear(true);
            }
        });

        xCargo.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xCargo.val()) {
                    Cargo[0].selectize.setValue(xCargo.val());
                    if (Cargo.val()) {
                        Cargo[0].selectize.disable();
                    } else {
                        onCampoInvalido(pnlTablero, 'NO EXISTE ESTE CARGO, ESPECIFIQUE OTRO', function () {
                            xCargo.focus().select();
                        });
                    }
                } else {
                    Cargo[0].selectize.enable();
                    Cargo[0].selectize.clear(true);
                }
            } else {
                Cargo[0].selectize.enable();
                Cargo[0].selectize.clear(true);
            }
        });

        Cargo.change(function () {
            if (Cargo.val()) {
                xCargo.val(Cargo.val());
                Cargo[0].selectize.disable();
                xDepartamento.focus();
            } else {
                xCargo.val('');
                Cargo[0].selectize.enable();
                Cargo[0].selectize.clear(true);
            }
        });

        Clasificacion.change(function () {
            if (Clasificacion.val()) {
                xClasificacion.val(Clasificacion.val());
                Clasificacion[0].selectize.disable();
                xClasificacion.focus();
            } else {
                xClasificacion.val('');
                Clasificacion[0].selectize.enable();
                Clasificacion[0].selectize.clear(true);
            }
        });

        xClasificacion.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xClasificacion.val()) {
                    Clasificacion[0].selectize.setValue(xClasificacion.val());
                    if (Clasificacion.val()) {
                        Clasificacion[0].selectize.disable();
                    } else {
                        onCampoInvalido(pnlTablero, 'NO EXISTE ESTA CLASIFICACIÓN, ESPECIFIQUE OTRA', function () {
                            xClasificacion.focus().select();
                        });
                    }
                } else {
                    Clasificacion[0].selectize.enable();
                    Clasificacion[0].selectize.clear(true);
                }
            } else {
                Clasificacion[0].selectize.enable();
                Clasificacion[0].selectize.clear(true);
            }
        });

        xClienteDevolucion.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xClienteDevolucion.val()) {
                    ClienteDevolucion[0].selectize.setValue(xClienteDevolucion.val());
                    if (ClienteDevolucion.val()) {
                        ClienteDevolucion[0].selectize.disable();
                    } else {
                        onCampoInvalido(pnlTablero, 'NO EXISTE ESTE CLIENTE, ESPECIFIQUE OTRO', function () {
                            xClienteDevolucion.focus().select();
                        });
                    }
                } else {
                    ClienteDevolucion[0].selectize.enable();
                    ClienteDevolucion[0].selectize.clear(true);
                }
            } else {
                ClienteDevolucion[0].selectize.enable();
                ClienteDevolucion[0].selectize.clear(true);
            }
        });

        ClienteDevolucion.click(function () {
            ClienteDevolucion[0].selectize.enable();
        });

        ClienteDevolucion.change(function () {
            if (ClienteDevolucion.val()) {
                xClienteDevolucion.val(ClienteDevolucion.val());
                ClienteDevolucion[0].selectize.disable();
                FechaDevolucion.focus();
            } else {
                xClienteDevolucion.val('');
                ClienteDevolucion[0].selectize.enable();
                ClienteDevolucion[0].selectize.clear(true);
            }
            Pedidos.ajax.reload(function () {
                Devoluciones.ajax.reload(function () {
                });
            });
        });

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
                            onMostraReporte('onImprimirReportePorCliente', p);
                            break;
                        case 3:
                            /* 3 = POR MAQUILA*/
                            onMostraReporte('onImprimirReportePorMaquila', p);
                            break;
                        case 4:
                            /* 4 = POR DEFECTO DETALLE*/
                            onMostraReporte('onImprimirReportePorDefectoDetalle', p);
                            break;
                        case 5:
                            /* 5 = POR AGENTE, POR CLIENTE, POR DEPARTAMENTO, POR DEFECTO Y DETALLE*/
                            onMostraReporte('onImprimirReportePorAgenteClienteDepartamentoDefectoDetalle', p);
                            break;
                    }
                } else {
                    iMsg("DEBE DE ESPECIFICAR UN TIPO DE REPORTE", 'w', function () {

                    });
                }
            } else {
                onCampoInvalido(pnlTablero, "DEBE DE ESPECIFICAR LAS FECHAS", function () {
                    DeLaFechaDev.focus().select();
                });
            }
        });

        btnAceptaReporteDevolucionXLS.click(function () {
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
                            $.post('<?php print base_url('DevolucionesDeClientes/onImprimirRepNormalXLS'); ?>', p).done(function (a) {
                                var b = JSON.parse(a);
//                                    onImprimirReporteFancyArray(JSON.parse(aaa));
//                                   window.open(aaa, '_blank');
                                onOpenWindowBlankArray(b);
                            }).fail(function (x, y, z) {
                                getError(x);
                            }).always(function () {
                                onCloseOverlay();
                            });
                            break;
                        case 2:
                            /* 2 = POR CLIENTE*/
                            onMostraReporte('onImprimirReportePorCliente', p);
                            break;
                        case 3:
                            /* 3 = POR MAQUILA*/
                            onMostraReporte('onImprimirReportePorMaquila', p);
                            break;
                        case 4:
                            /* 4 = POR DEFECTO DETALLE*/
                            onMostraReporte('onImprimirReportePorDefectoDetalle', p);
                            break;
                        case 5:
                            /* 5 = POR AGENTE, POR CLIENTE, POR DEPARTAMENTO, POR DEFECTO Y DETALLE*/
                            onMostraReporte('onImprimirReportePorAgenteClienteDepartamentoDefectoDetalle', p);
                            break;
                    }
                } else {
                    iMsg("DEBE DE ESPECIFICAR UN TIPO DE REPORTE", 'w', function () {

                    });
                }
            } else {
                onCampoInvalido(pnlTablero, "DEBE DE ESPECIFICAR LAS FECHAS", function () {
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
            if (Motivo.val() && Motivo.val().length > 5) {
                $.each(pnlTablero.find("select"), function (k, v) {
                    pnlTablero.find("select")[k].selectize.enable();
                });
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
                    p["FOLIO"] = Folio;

                    $.post('<?php print base_url('DevolucionesDeClientes/onGuardar') ?>', p).done(function (a) {
                        onOpenOverlay('');
                        onResetCampos();
                        pnlTablero.find("input:not(#xClienteDevolucion):not(#FechaDevolucion)").val("");
                        $.each(pnlTablero.find("select:not(#ClienteDevolucion):not(#ClienteDevolucion-selectize)"), function (k, v) {
                            pnlTablero.find("select:not(#ClienteDevolucion):not(#ClienteDevolucion-selectize)")[k].selectize.clear(true);
                        });
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
            } else {
                onCampoInvalido(pnlTablero, "DEBE DE CAPTURAR UN MOTIVO VÁLIDO.", function () {
                    Motivo.focus().select();
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
            onBeep(1);
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
            console.log(e.keyCode);
            if (e.keyCode === 106 || e.keyCode === 107 || e.keyCode === 109 || e.keyCode === 110) {
                e.preventDefault();
            }
            if (Control.val()) {
                console.log($(this).attr("id"), $(this).val());
                if (e.keyCode === 13) {
                    var index = $(this).attr('indice');
                    var cantidad_facturada = (pnlTablero.find("#CF" + index).val() ? pnlTablero.find("#CF" + index).val() : 0);
                    var cantidad_a_devolver = parseInt(($(this).val() ? $(this).val() : 0));
                    if (cantidad_a_devolver > 0 && cantidad_a_devolver <= parseInt(cantidad_facturada)) {
                        console.log($(this).val(), pnlTablero.find("#CF" + index).val());
                        console.log(parseInt($(this).val()) <= parseInt(pnlTablero.find("#CF" + index).val()));
                    } else {
//                        onDisable(btnAcepta);
//                        onCampoInvalido(pnlTablero, 'LA CANTIDAD A DEVOLVER DEBE DE SER MENOR O IGUAL A LA CANTIDAD FACTURADA', function () {
//                            pnlTablero.find("#PDF" + index).focus().select();
//
//                        });
                    }
                }
            } else {
                onCampoInvalido(pnlTablero, 'DEBE DE SELECCIONAR UN CONTROL', function () {

                });
            }
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
                "url": '<?php print base_url('DevolucionesDeClientes/getPedidosFacturados'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = ClienteDevolucion.val() ? ClienteDevolucion.val() : '';
                    d.ESTILO = EstiloF.val() ? EstiloF.val() : '';
                    d.DOCUMENTO = DocumentoF.val() ? DocumentoF.val() : '';
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
            "scrollY": 200,
            "scrollX": true,
            "order": [[4, "desc"]],
            "initComplete": function (settings, json) {
                xClienteDevolucion.focus();
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
                console.log("Z = > ", z);
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
                    getInfoXControl(z.CONTROL, z);
//                    getParesFacturadosXControl(z.CONTROL);
                });
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
            "scrollY": 200,
            "scrollX": true,
            "order": [[10, "desc"]],
            "initComplete": function (settings, json) {
            }
        });
    });

    function onReloadPagina() {
        javascript:location.reload();
    }

    function getInfoXControl(c, r) {
        var indice_f = 0;
        onOpenOverlay('Cargando...');

        for (var i = 1; i < 23; i++) {
            pnlTablero.find("#T" + i).val('');
            pnlTablero.find("#PDF" + i).val('');
            pnlTablero.find("span.T" + i).text('');
            pnlTablero.find("#T" + i).attr("title", '');
            pnlTablero.find("#T" + i).attr("data-original-title", '');
            pnlTablero.find(`#C${i}`).val('');
        }

        $.getJSON('<?php print base_url('DevolucionesDeClientes/getInfoXControl'); ?>', {
            CONTROL: c,
            ID: r.ID,
            DOCTO: r.DOCUMENTO,
            PARES: r.PARES
        }).done(function (a) {
            if (a.length > 0) {
                var xx = a[0];
                console.log(xx);
                Serie.val(xx.Serie);
                pnlTablero.find(".serie_control").text(xx.Serie);
                var t = 0, indice = 0, prs = 0;
                for (var i = 1; i < 23; i++) {
                    if (parseInt(xx["T" + i]) > 0) {
                        pnlTablero.find("#T" + i).val(xx["T" + i]);
                        pnlTablero.find("span.T" + i).text(xx["T" + i]);
                        pnlTablero.find("#T" + i).attr("title", xx["T" + i]);
                        pnlTablero.find("#T" + i).attr("data-original-title", xx["T" + i]);
                        pnlTablero.find(`#C${i}`).val(xx["C" + i]);
//                        console.log("C" + i + " => ", xx["C" + i]);

                        var cantidad_facturada = pnlTablero.find("#CF" + i);
                        var cantidad_a_devolver = pnlTablero.find("#PDF" + i);
                        if (i < 10) {
                            cantidad_facturada.val(xx["par0" + i]);
                        } else {
                            cantidad_facturada.val(xx["par" + i]);
                        }
                        if (parseInt(cantidad_facturada.val()) >= 1) {
                            onEnable(cantidad_a_devolver);
                            prs = prs + 1;
                            cantidad_a_devolver.addClass("pares-ok");
                            if (indice === 0) {
                                indice = i;
                            }
                        } else {
                            onDisable(cantidad_a_devolver);
                            cantidad_a_devolver.removeClass("pares-ok");
                        }
//                        if (parseInt(cantidad_facturada.val()) <= 0) {
//                            onDisable(cantidad_facturada);
//                        } else if (parseInt(cantidad_facturada.val()) >= 1) {
//                            onEnable(cantidad_facturada);
//                        } else {
//                            onDisable(cantidad_facturada);
//                        }
                        /* PDF = Pares Devueltos Facturados*/
                        //                        pnlTablero.find("#PDF" + i).val((parseFloat(xx["C" + i]) > 0 ? parseInt(xx["C" + i]) - cf : 0));
                        pnlTablero.find("#C" + i).attr("title", xx["C" + i]);
                        pnlTablero.find("#C" + i).attr("data-original-title", xx["C" + i]);
                        t += parseInt(xx["C" + i]);
                        TotalParesEntrega.val(t);
                        TotalParesEntregaAF.val(t);
                    } else {
                        pnlTablero.find("#PDF" + i).attr('disabled', true);
                    }
                }
                pnlTablero.find("#PDF" + indice).focus().select();
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

        for (var i = 1; i < 23; i++) {
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
            for (var i = 1; i < 23; i++) {
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
        } else {
            btnAcepta.attr('disabled', true);
        }
    }

    function onMostraReporte(url, p) {
        onOpenOverlay('');
        $.post('<?php print base_url('DevolucionesDeClientes/'); ?>' + url, p).done(function (aaa) {
            if (aaa.length > 0) {
                onImprimirReporteFancy(aaa);
            }
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {
            onCloseOverlay();
        });
    }
    var Folio = 0;
    function getConsecutivo() {
        $.getJSON('<?php print base_url('DevolucionesDeClientes/getConsecutivo') ?>').done(function (a) {
            console.log(a);
            if (a.length > 0) {
                FolioDev.html(a);
                Folio = a;
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
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
    .btn-success {
        color: #fff;
        background-color: #7CB342;
        border-color: #7CB342;
    }
    .btn-success.disabled, .btn-success:disabled {
        color: #fff;
        background-color: #59802F;
        border-color: #59802F;
    }
    .pares-ok{
        /*8BC34A*/
        border: 2px solid #99cc00 !important;
    }
</style>