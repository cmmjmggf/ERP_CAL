<div class="card m-3 animated fadeIn" id="pnlTablero" style="background-color:  #fff !important;">
    <div class="card-body " style="padding: 7px 10px 10px 10px;">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h5 class="text-danger font-italic"> <span class="fa fa-exchange-alt"></span> DEVOLUCION CON APLICACIÓN A CARTERA (NO LO OCUPAN)</h5>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-8 col-xl-8">
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
            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                <label>Fecha</label>
                <input type="text" id="FechaDevolucion" name="FechaDevolucion" class="form-control form-control-sm date notEnter">
            </div>
            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-1 col-xl-1">
                <label>TP</label>
                <select  id="TP" name="TP" class="form-control form-control-sm">
                    <option></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-1 col-xl-1">
                <label>Aplica devolución</label>
                <input type="text" id="AplicaDevolucion" name="AplicaDevolucion" class="form-control form-control-sm">
            </div>

            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
                <label>Clasificación</label>
                <select id="Clasificacion" name="Clasificacion" class="form-control form-control-sm">
                    <option></option> 
                    <option value="1">1 Para venta</option>
                    <option value="2">2 Saldo</option>
                    <option value="3">3 Reparación</option>
                </select>
            </div>

            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
                <label>Cargo</label>
                <select id="Cargo" name="Cargo" class="form-control form-control-sm">
                    <option></option>
                    <option value="0">0 No</option>
                    <option value="1">1 Proveedor</option>
                    <option value="2">2 Maquila</option> 
                </select>
            </div>

            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
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
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
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
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label>Control</label>
                <input type="text" id="Control" name="Control" maxlength="15" class="form-control form-control-sm numbersOnly"> 
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7">
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
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <span class="font-weight-bold text-info serie_control">-</span>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <span class="font-weight-bold text-info estilo_t">-</span>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <span class="font-weight-bold text-info color_clave">-</span>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <span class="font-weight-bold text-info color_t">-</span>
                    </div>  
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <textarea id="ConceptoDev" name="ConceptoDev" class="form-control form-control-sm" cols="3" rows="5">
                        </textarea>
                    </div>
                </div>
            </div>

            <!--TABLAS-->
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <p class="font-weight-bold text-danger">CONTROLES DOCUMENTADOS A ESTE CLIENTE</p>
                <div class="row">  
                    <div class="col-3">
                        <p class="font-weight-bold">Ordernar por</p>
                    </div>
                    <div class="col-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="rControl" name="Reporte" class="custom-control-input" valor="1">
                            <label class="custom-control-label text-info" style="cursor: pointer !important;" for="rControl">Control</label>
                        </div> 
                    </div>
                    <div class="col-2 mx-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="rEstilo" name="Reporte" class="custom-control-input" valor="2">
                            <label class="custom-control-label text-danger" style="cursor: pointer !important;" for="rEstilo">Estilo</label>
                        </div>
                    </div>  
                    <div class="col-2 mx-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="rDocto" name="Reporte" class="custom-control-input" valor="5">
                            <label class="custom-control-label text-info" style="cursor: pointer !important;" for="rDocto">Docto</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="rFecha" name="Reporte" class="custom-control-input" valor="5">
                            <label class="custom-control-label text-info" style="cursor: pointer !important;" for="rFecha">Fecha</label>
                        </div>
                    </div>  
                </div>
                <div class="my-2"></div>
                <table id="tblControlesDocumentadosAEsteCliente" class="table table-hover table-sm"  style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Control</th><!--1-->
                            <th scope="col">Docto</th><!--2-->
                            <th scope="col">TP</th><!--3-->
                            <th scope="col">Fecha</th><!--4-->
                            <th scope="col">Par</th><!--5-->
                            <th scope="col">Estilo</th><!--6--><!--1-->
                            <th scope="col">Color</th><!--7--><!--2-->
                            <th scope="col">Precio</th><!--8--><!--3-->
                            <th scope="col">St</th><!--9--><!--4-->
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <p class="font-weight-bold text-danger">DOCUMENTOS DE ESTE CLIENTE CON SALDO</p>
                <div class="row">  
                    <div class="col-4">
                        <p class="font-weight-bold">Ordernar por</p>
                    </div>
                    <div class="col-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="rTPFX" name="ReporteX" class="custom-control-input" valor="1">
                            <label class="custom-control-label text-info"  style="cursor: pointer !important;" for="rTPFX">TP</label>
                        </div> 
                    </div>
                    <div class="col-2 mx-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="rDoctoFX" name="ReporteX" class="custom-control-input" valor="2">
                            <label class="custom-control-label text-danger" style="cursor: pointer !important;" for="rDoctoFX">Docto</label>
                        </div>
                    </div>  
                    <div class="col-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="rFechaX" name="ReporteX" class="custom-control-input" valor="5">
                            <label class="custom-control-label text-info" style="cursor: pointer !important;" for="rFechaX">Fecha</label>
                        </div>
                    </div> 
                </div>
                <div class="my-2"></div>
                <table id="tblDocumentosClienteConSaldo" class="table table-hover table-sm"  style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">TP</th><!--1-->
                            <th scope="col">Docto</th><!--2-->
                            <th scope="col">Fecha</th><!--3-->
                            <th scope="col">Importe</th><!--4-->
                            <th scope="col">Pagos</th><!--5-->
                            <th scope="col">Saldo</th><!--6--><!--1-->
                            <th scope="col">St</th><!--7--><!--2-->  
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p class="font-weight-bold text-danger">DETALLE DE LA DEVOLUCIÓN</p>
                <table id="tblDetalleDeLaDevolucion" class="table table-hover table-sm"  style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Cte</th><!--1-->
                            <th scope="col">Aplica</th><!--2-->
                            <th scope="col">Control</th><!--3-->
                            <th scope="col">Pares</th><!--4-->
                            <th scope="col">Def</th><!--5-->
                            <th scope="col">Det</th><!--6--><!--1-->
                            <th scope="col">Clasificacion</th><!--7--><!--2-->  
                            <th scope="col">Cargo</th><!--8--><!--3-->  
                            <th scope="col">Maq</th><!--9--><!--4-->  
                            <th scope="col">Fecha</th><!--9--><!--5-->  
                            <th scope="col">TP</th><!--10--><!--6-->  
                            <th scope="col">Concepto</th><!--11--><!--7-->  
                            <th scope="col">Pre-dev</th><!--12--><!--8--> 
                            <th scope="col">Pre-cg</th><!--13--><!--9-->  
                            <th scope="col">nc</th><!--14--><!--10-->  
                            <th scope="col">registro</th><!--15--><!--11-->  
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="w-100"></div>

            <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-2 col-xl-2">
                <label>N.credito</label>
                <input type="text" id="NoCredito" name="NoCredito" class="form-control form-control-sm">
            </div>

            <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-2 col-xl-2">
                <label>Docto</label>
                <input type="text" id="Docto" name="Docto" class="form-control form-control-sm">
            </div>

            <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-2 col-xl-2">
                <label>Saldo</label>
                <input type="text" id="Saldo" name="Saldo" class="form-control form-control-sm">
            </div>

            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="row">
                    <div class="col-3">
                        <button type="button" id="btnAcepta" name="btnAcepta" disabled="" class="btn btn-info btn-block">
                            <span class="fa fa-check"></span> Acepta
                        </button>
                    </div>
                    <div class="col-3">
                        <button type="button" id="btnCierraImprime" name="btnCierraImprime" disabled=""  class="btn btn-info btn-block">
                            <span class="fa fa-file-code"></span> Cierra /Imprime
                        </button>
                    </div>
                    <div class="col-3">
                        <button type="button" id="btnReportes" name="btnReportes" class="btn btn-info btn-block">
                            <span class="fa fa-print"></span> Reportes
                        </button>
                    </div>
                    <div class="col-3">
                        <button type="button" id="btnDefecto" name="btnDefecto" class="btn btn-info btn-block">
                            <span class="fa fa-diagnoses"></span> Defecto
                        </button>
                    </div>
                    <div class="w-100 my-1"></div>
                    <div class="col-3"> 
                        <button type="button" id="btnDetalle" name="btnDetalle" class="btn btn-info btn-block">
                            <span class="fa fa-info-circle"></span> Detalle
                        </button>
                    </div>
                    <div class="col-3">
                        <button type="button" id="btnCtrlCompleto" name="btnCtrlCompleto" disabled=""  class="btn btn-info btn-block">
                            <span class="fa fa-compress"></span> Ctrl / Completo
                        </button>
                    </div>
                    <div class="col-3">
                        <button type="button" id="btnRastreoCtrlDoc" name="btnRastreoCtrlDoc" class="btn btn-info btn-block">
                            <span class="fa fa-search"></span> Rastreo ctr/doc
                        </button>
                    </div>
                    <div class="col-3">
                        <button type="button" id="btnRastreoEstCte" name="btnRastreoEstCte" class="btn btn-info btn-block">
                            <span class="fa fa-search"></span> Rastreo est/cte
                        </button>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), ClienteDevolucion = pnlTablero.find('#ClienteDevolucion'),
            FechaDevolucion = pnlTablero.find('#FechaDevolucion'),
            TP = pnlTablero.find('#TP'),
            AplicaDevolucion = pnlTablero.find('#AplicaDevolucion'),
            Defecto = pnlTablero.find('#Defecto'),
            DetalleDefecto = pnlTablero.find('#DetalleDefecto'),
            Control = pnlTablero.find('#Control'),
            tblTallasF = pnlTablero.find('#tblTallasF'),
            C1 = pnlTablero.find('#C1'),
            C2 = pnlTablero.find('#C2'),
            C3 = pnlTablero.find('#C3'),
            C4 = pnlTablero.find('#C4'),
            C5 = pnlTablero.find('#C5'),
            C6 = pnlTablero.find('#C6'),
            C7 = pnlTablero.find('#C7'),
            C8 = pnlTablero.find('#C8'),
            C9 = pnlTablero.find('#C9'),
            C10 = pnlTablero.find('#C10'),
            C11 = pnlTablero.find('#C11'),
            C12 = pnlTablero.find('#C12'),
            C13 = pnlTablero.find('#C13'),
            C14 = pnlTablero.find('#C14'),
            C15 = pnlTablero.find('#C15'),
            C16 = pnlTablero.find('#C16'),
            C17 = pnlTablero.find('#C17'),
            C18 = pnlTablero.find('#C18'),
            C19 = pnlTablero.find('#C19'),
            C20 = pnlTablero.find('#C20'),
            C21 = pnlTablero.find('#C21'),
            C22 = pnlTablero.find('#C22'),
            TotalParesEntrega = pnlTablero.find('#TotalParesEntrega'),
            CF1 = pnlTablero.find('#CF1'),
            CF2 = pnlTablero.find('#CF2'),
            CF3 = pnlTablero.find('#CF3'),
            CF4 = pnlTablero.find('#CF4'),
            CF5 = pnlTablero.find('#CF5'),
            CF6 = pnlTablero.find('#CF6'),
            CF7 = pnlTablero.find('#CF7'),
            CF8 = pnlTablero.find('#CF8'),
            CF9 = pnlTablero.find('#CF9'),
            CF10 = pnlTablero.find('#CF10'),
            CF11 = pnlTablero.find('#CF11'),
            CF12 = pnlTablero.find('#CF12'),
            CF13 = pnlTablero.find('#CF13'),
            CF14 = pnlTablero.find('#CF14'),
            CF15 = pnlTablero.find('#CF15'),
            CF16 = pnlTablero.find('#CF16'),
            CF17 = pnlTablero.find('#CF17'),
            CF18 = pnlTablero.find('#CF18'),
            CF19 = pnlTablero.find('#CF19'),
            CF20 = pnlTablero.find('#CF20'),
            CF21 = pnlTablero.find('#CF21'),
            CF22 = pnlTablero.find('#CF22'),
            TotalParesEntregaF = pnlTablero.find('#TotalParesEntregaF'),
            PDF1 = pnlTablero.find('#PDF1'),
            PDF2 = pnlTablero.find('#PDF2'),
            PDF3 = pnlTablero.find('#PDF3'),
            PDF4 = pnlTablero.find('#PDF4'),
            PDF5 = pnlTablero.find('#PDF5'),
            PDF6 = pnlTablero.find('#PDF6'),
            PDF7 = pnlTablero.find('#PDF7'),
            PDF8 = pnlTablero.find('#PDF8'),
            PDF9 = pnlTablero.find('#PDF9'),
            PDF10 = pnlTablero.find('#PDF10'),
            PDF11 = pnlTablero.find('#PDF11'),
            PDF12 = pnlTablero.find('#PDF12'),
            PDF13 = pnlTablero.find('#PDF13'),
            PDF14 = pnlTablero.find('#PDF14'),
            PDF15 = pnlTablero.find('#PDF15'),
            PDF16 = pnlTablero.find('#PDF16'),
            PDF17 = pnlTablero.find('#PDF17'),
            PDF18 = pnlTablero.find('#PDF18'),
            PDF19 = pnlTablero.find('#PDF19'),
            PDF20 = pnlTablero.find('#PDF20'),
            PDF21 = pnlTablero.find('#PDF21'),
            PDF22 = pnlTablero.find('#PDF22'),
            TotalParesEntregaAF = pnlTablero.find('#TotalParesEntregaAF'),
            ConceptoDev = pnlTablero.find('#ConceptoDev'),
            rControl = pnlTablero.find('#rControl'),
            rEstilo = pnlTablero.find('#rEstilo'),
            rDocto = pnlTablero.find('#rDocto'),
            rFecha = pnlTablero.find('#rFecha'),
            tblControlesDocumentadosAEsteCliente = pnlTablero.find('#tblControlesDocumentadosAEsteCliente'),
            rTPFX = pnlTablero.find('#rTPFX'),
            rDoctoFX = pnlTablero.find('#rDoctoFX'),
            rFechaX = pnlTablero.find('#rFechaX'),
            DocumentosClienteConSaldo,
            tblDocumentosClienteConSaldo = pnlTablero.find('#tblDocumentosClienteConSaldo'),
            DetalleDeLaDevolucion,
            tblDetalleDeLaDevolucion = pnlTablero.find('#tblDetalleDeLaDevolucion'),
            NoCredito = pnlTablero.find('#NoCredito'),
            Docto = pnlTablero.find('#Docto'),
            Saldo = pnlTablero.find('#Saldo'),
            btnAcepta = pnlTablero.find("#btnAcepta"),
            btnCierraImprime = pnlTablero.find("#btnCierraImprime"),
            btnReportes = pnlTablero.find("#btnReportes"),
            btnDefecto = pnlTablero.find("#btnDefecto"),
            btnDetalle = pnlTablero.find("#btnDetalle"),
            btnCtrlCompleto = pnlTablero.find("#btnCtrlCompleto"),
            btnRastreoCtrlDoc = pnlTablero.find("#btnRastreoCtrlDoc"),
            btnRastreoEstCte = pnlTablero.find("#btnRastreoEstCte"),
            Hoy = '<?php print date('d/m/Y'); ?>';

    $(document).ready(function () {

        FechaDevolucion.val(Hoy);

        btnDefecto.click(function () {
            onOpenWindow('<?php print base_url('Defectos'); ?>');
        });

        btnDetalle.click(function () {
            onOpenWindow('<?php print base_url('DetallesDefectos'); ?>');
        });
        
        DocumentosClienteConSaldo = tblDocumentosClienteConSaldo.DataTable({
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
            }
        });
    });
</script>