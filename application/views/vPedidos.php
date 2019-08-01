<div class="card m-3 animated fadeIn d-none" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-2 float-left">
                <legend class="float-left">Pedidos</legend>
            </div>
            <div class="col-sm-5">
                <label>Cliente</label>
                <select id="ClientePedido" name="ClientePedido" style="font-size: 20px; font-style: italic; background-color: #f1f0eb; border-color: #f1f0eb; " class="form-control form-control-sm" >
                    <option></option>
                    <?php
                    $clientes = $this->db->select("C.Clave AS Clave, CONCAT(C.Clave, \" - \",C.RazonS) AS Cliente", false)
                                    ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('ABS(C.Clave)', 'ASC')->get()->result();
                    foreach ($clientes as $k => $v) {
                        print "<option value=\"{$v->Clave}\">{$v->Cliente}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-4">
                <label>Pedido</label>
                <input type="text" id="NumeroDePedido" name="NumeroDePedido" style="font-size: 20px; font-style: italic; background-color: #f1f0eb; border-color: #f1f0eb; " class="form-control form-control-sm  noBorders notEnter numbersOnly" placeholder="# # # # #">
            </div>
            <div class="col-sm-1 float-right" align="right">
                <button type="button" class="btn btn-primary selectNotEnter" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar">
                    <span class="fa fa-plus"></span><br>
                </button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Pedidos" class="table-responsive">
                <table id="tblPedidos" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pedidos</th>
                            <th>Cliente</th>
                            <th>Agente</th>
                            <th>Pares</th>
                            <th>Fecha de entrega</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="animated fadeIn text-dark d-none" id="pnlDatos">
    <form id="frmNuevo">
        <fieldset>
            <!--PRIMER CONTENEDOR-->
            <div class="card  m-3 ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 float-left">
                            <legend >Pedido</legend>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6" align="center">
                            <button type="button" class="btn btn-primary btn-sm" id="btnCapacidad" onclick="onComprobarCapacidades('#Maquila')" data-toggle="tooltip" data-placement="bottom" title="Comprobar capacidad de la maquila">
                                <span class="fa fa-eye" ></span>
                            </button>
                        </div>
                        <div class="col-12 col-sm-12 col-md-3  col-lg-3" align="right">
                            <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                                <span class="fa fa-arrow-left" ></span> VER PEDIDOS
                            </button>
                            <button type="button" class="btn btn-info btn-sm d-none" id="btnImprimir" >
                                <span class="fa fa-print" ></span> IMPRIMIR
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="d-none">
                            <input type="text" id="ID" name="ID" class="form-control form-control-sm d-none" readonly="" >
                            <input type="text" id="pedcte" name="pedcte" class="form-control form-control-sm" readonly="" >
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-2 col-xl-1">
                            <label for="Pedido" >Pedido*</label>
                            <input type="text" class="form-control form-control-sm numbersOnly selectNotEnter" id="Clave" required="" placeholder="" autofocus="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                            <label for="Cliente" >Cliente*</label>
                            <select class="form-control form-control-sm" id="PedidoxCliente" name="PedidoxCliente" required="" placeholder="">
                                <option></option>
                                <?php
                                foreach ($clientes as $k => $v) {
                                    print "<option value=\"{$v->Clave}\">{$v->Cliente}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                            <label for="Agente" >Agente*</label>
                            <select class="form-control form-control-sm" id="Agente" name="Agente" required="" placeholder="">
                                <option></option>
                                <?php
                                foreach ($this->db->query("SELECT A.Clave, CONCAT(A.Clave, \" - \", A.Nombre) AS Agente FROM agentes AS A")->result() as $k => $v) {
                                    print "<option value=\"{$v->Clave}\">{$v->Agente}</option>";
                                }
                                ?>                                    
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-2">
                            <label for="FechaPedido" >Fec-Pedido*</label>
                            <input type="text" id="FechaPedido" name="FechaPedido" class="form-control form-control-sm date notEnter" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                            <label for="FechaEntrega" >Fec-Entrega*</label>
                            <input type="text" id="FechaEntrega" name="FechaEntrega" class="form-control form-control-sm date notEnter">
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-1">
                            <label for="FechaRecepcion" >Fec-Recep*</label>
                            <input type="text" id="FechaRecepcion" name="FechaRecepcion" class="form-control form-control-sm date notEnter" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-1">
                            <label for="Recibido" >Recibido*</label>
                            <select class="form-control form-control-sm" id="Recibido" name="Recibido" required placeholder="">
                                <option></option>
                                <option value="1">1 - Age</option>
                                <option value="3">3 - Tel</option>
                                <option value="4">4 - Per</option>
                                <option value="5">5 - Int</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!--SEGUNDO CONTENEDOR-->
            <div class="card  m-3 ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-4 col-lg-2 col-xl-2">
                            <label for="Estilo" >Estilo*</label>
                            <select class="form-control form-control-sm" id="Estilo" name="Estilo" required placeholder="">
                                <option></option>
                                <?php
                                foreach ($this->db->query("SELECT E.Clave AS Clave,CONCAT(E.Clave,'-',IFNULL(E.Descripcion,'')) AS Estilo FROM estilos AS E  WHERE E.Estatus LIKE 'ACTIVO' GROUP BY E.Clave")->result() as $k => $v) {
                                    print "<option value=\"{$v->Clave}\">{$v->Estilo}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-2 col-xl-2">
                            <label for="Color" >Color*</label>
                            <select class="form-control form-control-sm" id="Color" name="Color" required placeholder="">
                            </select>
                            <div id="spin" class="d-none" align="center"><span class="fa fa-cog fa-spin fa-2x"></span></div>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-2 col-xl-2">
                            <label for="Maquila" >Maquila*</label>
                            <select class="form-control form-control-sm"  type="text" id="Maquila" name="Maquila">
                            </select>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-1 col-xl-1">
                            <label for="Semana" >Sem*</label>
                            <input type="text" id="Semana" name="Semana" class="form-control form-control-sm" placeholder="" onkeyup="onChecarSemanaValida(this)">
                        </div>
                        <!--BREAK-->
                        <div class="col-12 col-sm-4 col-md-4 col-lg-2 col-xl-1">
                            <label for="Recio" >Recio*</label>
                            <input type="text" id="Recio" name="Recio" class="form-control form-control-sm" maxlength="5">
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-2 col-xl-2">
                            <label for="ProduccionMaquilaSemana" >Prod. Maq/Sem*</label>
                            <div class="input-group">
                                <input type="text" id="ProduccionMaquilaSemana" name="ProduccionMaquilaSemana" class="form-control form-control-sm" placeholder="0" disabled="">
                                <span class="input-group-prepend">
                                    <span class="input-group-text text-dark" style="background-color: #3498DB; color: #FFF !important; width: 45px;" id="AgregaObservaciones" onclick="onAgregarObservaciones()" data-toggle="tooltip" data-placement="top" title="Observaciones">
                                        <i class="fa fa-file-alt"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-1 col-xl-1">
                            <label for="Precio" >Precio*</label>
                            <input type="text" id="Precio" name="Precio" class="form-control form-control-sm numbersOnly" maxlength="8" readonly="">
                            <input type="text" id="Serie" class="form-control form-control-sm d-none" readonly="" >
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 d-none">
                            <label for="Observaciones" >Observaciones*</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" id="Observacion" name="Observacion" class="form-control form-control-sm" placeholder="Titulo" maxlength="99">
                                </div>
                                <div class="col-6">
                                    <input type="text" id="ObservacionDetalle" name="ObservacionDetalle" class="form-control form-control-sm" placeholder="Descripción" maxlength="99">
                                </div>
                            </div>
                        </div>
                        <!--TALLAS-->
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-8" >
                                    <div class="table-responsive" style="overflow-x:auto; white-space: nowrap;">
                                        <label class="font-weight-bold" for="Tallas">Tallas</label>
                                        <table id="tblTallas" class="Tallas" >
                                            <thead></thead>
                                            <tbody>
                                                <tr>
                                                    <?php
                                                    for ($index = 1; $index < 23; $index++) {
                                                        print '<td><input type="text" style="width: 37px;" maxlength="4" class="numbersOnly" name="T' . $index . '" disabled></td>';
                                                    }
                                                    ?>
                                                    <td class="font-weight-bold">Pares</td>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    for ($index = 1; $index < 23; $index++) {
                                                        print '<td><input type="text" style="width: 37px;" maxlength="4" class=" numbersOnly" name="C' . $index . '" onfocus="onCalcularPares(this);" on change="onCalcularPares(this);" keyup="onCalcularPares(this);" onfocusout="onCalcularPares(this);"></td>';
                                                    }
                                                    ?>
                                                    <td><input type="text" style="width: 40px;" maxlength="4" class=" numbersOnly font-weight-bold" disabled=""  id="TPares"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 mt-5 d-none" align="left">
                                    <button type="button" class="btn btn-primary" id="btnAgregarDetalle"><span class="fa fa-check"></span></button>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mt-5" align="right">
                                    <button type="button" class="btn btn-primary" id="btnAcepta">
                                        <span class="fa fa-check"></span> Acepta
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2"> 
                        <div class="col-6 col-sm-6 col-md-6" align="right">
                            <button type="button" class="btn btn-info btn-lg btn-float animated slideInUp d-none" disabled="" id="btnGuardar" data-toggle="tooltip" data-placement="left" title="Guardar">
                                <i class="fa fa-save"></i>
                            </button>
                        </div> 
                    </div>
                </div>
            </div>
            <!--FIN SEGUNDO CONTENEDOR-->
            <!--DETALLE-->
            <!--SEGUNDO CONTENEDOR-->
            <div class="card  m-3 ">
                <div class="card-body">
                    <div class="row">
                        <table id="tblPedidoDetalle" class="table table-hover table-sm"  style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th><!--0-->
                                    <th scope="col">Recibido</th><!--1-->
                                    <th scope="col">Estilo</th><!--2-->
                                    <th scope="col">Estilo</th><!--3-->
                                    <th scope="col">Color</th><!--4-->
                                    <th scope="col">Color</th><!--5-->
                                    <th scope="col">Sem</th><!--6-->
                                    <th scope="col">Maq</th><!--7-->

                                    <th scope="col"></th><!--8-->
                                    <th scope="col"></th>
                                    <th scope="col"></th><!--10-->
                                    <th scope="col"></th>
                                    <th scope="col"></th><!--12-->

                                    <th scope="col"></th><!--13-->
                                    <th scope="col"></th>
                                    <th scope="col"></th><!--15-->
                                    <th scope="col"></th>
                                    <th scope="col"></th><!--17-->

                                    <th scope="col"></th><!--18-->
                                    <th scope="col"></th>
                                    <th scope="col"></th><!--20-->
                                    <th scope="col"></th>
                                    <th scope="col"></th><!--22-->

                                    <th scope="col"></th><!--23-->
                                    <th scope="col"></th>
                                    <th scope="col"></th><!--25-->
                                    <th scope="col"></th>
                                    <th scope="col"></th><!--27-->

                                    <th scope="col"></th><!--28-->
                                    <th scope="col"></th><!--29-->

                                    <th scope="col">Precio</th><!--30-->
                                    <th scope="col">Pares</th><!--31-->
                                    <th scope="col">F. Ent</th><!--32-->
                                    <th scope="col">Eliminar</th><!--33-->
                                    <!--OUT-->
                                    <th scope="col">Recio</th><!--34-->
                                    <th scope="col">Titulo Observaciones</th><!--35-->
                                    <th scope="col">Observaciones</th><!--36-->
                                    <th scope="col">Serie</th><!--37-->
                                    <th scope="col">Estatus Registro</th><!--38-->
                                    <th scope="col">Importe</th><!--39-->
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div><!--ROW-->
                    <div class="row mt-3">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 font-weight-bold "></div>

                        <div class="col-12 col-sm-12 col-md-3 col-lg-1 col-xl-1 font-weight-bold" align="center">Pares</div>
                        <div id="ParesTotales" class="col-12 col-sm-12 col-md-3 col-lg-1 col-xl-1 font-weight-bold text-nowrap" align="center"></div>

                        <div class="col-12 col-sm-12 col-md-3 col-lg-1 col-xl-1 font-weight-bold" align="center">Total</div>
                        <div id="Total" class="col-12 col-sm-12 col-md-3 col-lg-1 col-xl-1 font-weight-bold text-nowrap" align="center"></div>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>

<div id="mdlAviso" class="modal fade">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">AVISO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="comment">
                    /* load ide ui */
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/Pedidos/';
    var tblPedidos = $('#tblPedidos');
    var Pedidos;
    var pnlTablero = $("#pnlTablero"), pnlDatos = $("#pnlDatos"), pnlDatosDetalle = $("#pnlDatosDetalle");
    var btnNuevo = pnlTablero.find("#btnNuevo"), btnCancelar = $("#btnCancelar"), btnEliminar = $("#btnEliminar"),
            btnGuardar = $("#btnGuardar"), btnImprimir = pnlDatos.find("#btnImprimir");
    var PedidoDetalle, tblPedidoDetalle = pnlDatos.find("#tblPedidoDetalle");
    var PedidoxCliente = pnlDatos.find("#PedidoxCliente"), Estilo = pnlDatos.find("#Estilo"), Clave = pnlDatos.find("#Clave"), Color = pnlDatos.find("#Color"),
            Semana = pnlDatos.find("#Semana"), Maquila = pnlDatos.find("#Maquila"), Precio = pnlDatos.find("#Precio"),
            btnAcepta = pnlDatos.find("#btnAcepta"), Agente = pnlDatos.find('#Agente'),
            FechaPedido = pnlDatos.find('#FechaPedido'), FechaEntrega = pnlDatos.find('#FechaEntrega'),
            FechaRecepcion = pnlDatos.find('#FechaRecepcion'), Recibido = pnlDatos.find('#Recibido'),
            Recio = pnlDatos.find('#Recio'), Serie = pnlDatos.find('#Serie'), Observacion = pnlDatos.find('#Observacion'),
            ObservacionDetalle = pnlDatos.find('#ObservacionDetalle');

    var nuevo = false;
    var _animate_ = {enter: 'animated fadeInLeft', exit: 'animated fadeOutDown'}, _placement_ = {from: "bottom", align: "left"};
    var Cliente = '';
    var mdlAviso = $("#mdlAviso");
    var btnAgregarDetalle = pnlDatos.find("#btnAgregarDetalle");
    var opciones_detalle = {
        dom: 'rt',
        buttons: buttons,
        "columns": [
            {"data": "PDID"}/*0*/, {"data": "Recibido"}, {"data": "Estilo"}/*2*/, {"data": "EstiloT"},
            {"data": "Color"}/*4*/, {"data": "ColorT"}, {"data": "Semana"}/*6*/, {"data": "Maquila"},
            {"data": "T1"}/*8*/, {"data": "T2"}, {"data": "T3"}/*10*/, {"data": "T4"},
            {"data": "T5"}/*12*/, {"data": "T6"}, {"data": "T7"}/*14*/, {"data": "T8"},
            {"data": "T9"}/*16*/, {"data": "T10"}, {"data": "T11"}/*18*/, {"data": "T12"},
            {"data": "T13"}/*20*/, {"data": "T14"}, {"data": "T15"}/*22*/, {"data": "T16"},
            {"data": "T17"}/*24*/, {"data": "T18"}, {"data": "T19"}/*26*/, {"data": "T20"},
            {"data": "T21"}/*28*/, {"data": "T22"},
            {"data": "Precio"}/*30*/, {"data": "Pares"},
            {"data": "FechaEntrega"}/*32*/, {"data": "ELIMINAR"},
            {"data": "Recio"}/*34*/, {"data": "Observacion"},
            {"data": "ObservacionDetalle"}/*36*/, {"data": "Serie"},
            {"data": "EstatusD"}/*38*/, {"data": "STT"}/*39*/
        ],
        "columnDefs": [
            //ID
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            },
            //RECIBIDO
            {
                "targets": [1],
                "visible": false,
                "searchable": false
            },
            //ESTILO ID
            {
                "targets": [3],
                "visible": false,
                "searchable": false
            },
            //COLOR ID
            {
                "targets": [5],
                "visible": false,
                "searchable": false
            },
            //RECIO
            {
                "targets": [34],
                "visible": false,
                "searchable": false
            },
            //TITULO OBSERVACIONES
            {
                "targets": [35],
                "visible": false,
                "searchable": false
            },
            //TITULO OBSERVACIONES
            {
                "targets": [36],
                "visible": false,
                "searchable": false
            },
            //SERIE
            {
                "targets": [37],
                "visible": false,
                "searchable": false
            },
            //ESTATUS REGISTRO
            {
                "targets": [38],
                "visible": false,
                "searchable": false
            },
            //IMPORTE
            {
                "targets": [39],
                "visible": false,
                "searchable": false
            }
        ],
        language: lang,
        select: true,
        "autoWidth": true,
        "colReorder": true,
        "displayLength": 999,
        "bLengthChange": false,
        "deferRender": true,
        "scrollCollapse": false,
        "bSort": true,
        "scrollY": 450,
        "scrollX": true,
        "createdRow": function (row, data, index) {
            $.each($(row).find("td"), function (k, v) {
                var c = $(v);
                var index = parseInt(k);
                switch (index) {
                    case 0:
                        /*ESTILO*/
                        c.attr('title', data[3]);
                        break;
                    case 1:
                        /*COLOR*/
                        c.attr('title', data[5]);
                        break;
                }
                $(row).find("td").slice(4, 26).addClass("zoom");
            });
        },
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api();//Get access to Datatable API
            // Update footer
            var pares = api.column(31).data().reduce(function (a, b) {
                var ax = 0, bx = 0;
                ax = $.isNumeric(a) ? parseFloat(a) : 0;
                bx = $.isNumeric(b) ? parseFloat(b) : 0;
                return  (ax + bx);
            }, 0);
            var total = api.column(39).data().reduce(function (a, b) {
                var ax = 0, bx = 0;
                ax = $.isNumeric(a) ? parseFloat(a) : 0;
                bx = $.isNumeric(b) ? parseFloat(b) : 0;
                return  (ax + bx);
            }, 0);
            $("#ParesTotales").html("<span class='text-warning'>" + pares + "</span>");
            $("#Total").html("<span class='text-info'>$" + $.number(total, 3, '.', ',') + "</span>");
        },
        initComplete: function (x, y) {
            HoldOn.close();
        }
    };

    const isValidInput = (x) => {
        return x.val().trim().length > 0 ? true : false;
    };

    $.fn.dataTable.ext.errMode = 'throw';
    $(document).ready(function () {
        init();
        handleEnter();

        btnAcepta.click(function () {
            if (Clave.val() && PedidoxCliente.val() && Agente.val() && FechaPedido.val()
                    && FechaEntrega.val() && FechaRecepcion.val()) {
                onOpenOverlay('Guardando...');
                /*1 GUARDAR EL PRIMER REGISTRO*/
                var p = {
                    PEDIDO: Clave.val(), CLIENTE: PedidoxCliente.val(),
                    AGENTE: Agente.val(), FECHA_PEDIDO: FechaPedido.val(),
                    FECHA_RECEPCION: FechaRecepcion.val(), ESTILO: Estilo.val(),
                    COLOR: Color.val(), FECHA_ENTREGA: FechaEntrega.val(),
                    MAQUILA: Maquila.val(), SEMANA: Semana.val(),
                    RECIO: Recio.val(), PRECIO: Precio.val(),
                    OBSERVACION: Observacion.val(),
                    OBSERVACION_DETALLE: ObservacionDetalle.val(),
                    C1: pnlDatos.find("input[name='C1']").val(), C2: pnlDatos.find("input[name='C2']").val(),
                    C3: pnlDatos.find("input[name='C3']").val(), C4: pnlDatos.find("input[name='C4']").val(),
                    C5: pnlDatos.find("input[name='C5']").val(), C6: pnlDatos.find("input[name='C6']").val(),
                    C7: pnlDatos.find("input[name='C7']").val(), C8: pnlDatos.find("input[name='C8']").val(),
                    C9: pnlDatos.find("input[name='C9']").val(), C10: pnlDatos.find("input[name='C10']").val(),
                    C11: pnlDatos.find("input[name='C11']").val(), C12: pnlDatos.find("input[name='C12']").val(),
                    C13: pnlDatos.find("input[name='C13']").val(), C14: pnlDatos.find("input[name='C14']").val(),
                    C15: pnlDatos.find("input[name='C15']").val(), C16: pnlDatos.find("input[name='C16']").val(),
                    C17: pnlDatos.find("input[name='C17']").val(), C18: pnlDatos.find("input[name='C18']").val(),
                    C19: pnlDatos.find("input[name='C19']").val(), C20: pnlDatos.find("input[name='C20']").val(),
                    C21: pnlDatos.find("input[name='C21']").val(), C22: pnlDatos.find("input[name='C22']").val(),
                    RECIBIDO: Recibido.val(), PARES: pnlDatos.find('#TPares').val(),
                    ESTILOT: Estilo.text(), COLORT: Color.text(), SERIE: Serie.val()
                };
                if (nuevo) {
                    /*NUEVO*/
                    $.post('<?php print base_url('Pedidos/onAgregarX'); ?>', p).done(function (a) {
                        if (a.length > 0) {
                            nuevo = false;
                            var xxx = JSON.parse(a);
                            getPedidoByID(xxx[0].Clave, xxx[0].Cliente);
                        }
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                        onCloseOverlay();
                    });
                } else {
                    /*MODIFICANDO*/
                    $.post('<?php print base_url('Pedidos/onModificarX'); ?>', p).done(function (a) {
                         if (a.length > 0) {
                            nuevo = false;
                            var xxx = JSON.parse(a);
                            getPedidoByID(xxx[0].Clave, xxx[0].Cliente);
                        }
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                        onCloseOverlay();
                    });
                }
            } else {
                swal('ATENCIÓN', 'DEBE DE DEFINIR UNA CLAVE DEL PEDIDO Y UN CLIENTE', 'warning').then((value) => {
                    Clave.focus().select();
                });
            }
        });

        Estilo.change(function (e) {
            if ($(this).val()) {
                onOpenOverlay('Por favor espere...');
                /*COMPROBAR QUE EL ESTILO TENGA DEFINIDA SU FICHA TECNICA Y LAS FRACCIONES X ESTILO*/
                $.getJSON('<?php print base_url('Pedidos/onComprobarFichaTecnicaXEstilo'); ?>', {ESTILO: Estilo.val()})
                        .done(function (a) {
                            if (a.length > 0) {
                                if (parseInt(a[0].TIENEFICHA) > 0) {
                                    $.getJSON('<?php print base_url('Pedidos/onComprobarFraccionesXEstilo'); ?>', {ESTILO: Estilo.val()})
                                            .done(function (a) {
                                                if (a.length > 0) {
                                                    /*YOUR WIN*/
                                                } else {
                                                    swal('ATENCIÓN', 'ESTE ESTILO NO TIENE FRACCIONES DEFINIDAS', 'warning').then((value) => {
                                                        Estilo[0].selectize.focus();
                                                    });
                                                }
                                            }).fail(function (x) {
                                        getError(x);
                                    }).always(function () {
                                        onCloseOverlay();
                                    });
                                } else {
                                    swal('ATENCIÓN', 'ESTE ESTILO NO TIENE DEFINIDA UNA FICHA TECNICA', 'warning').then((value) => {
                                        Estilo[0].selectize.focus();
                                    });
                                }
                            }
                        }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    onCloseOverlay();
                });
            }
        });

        pnlTablero.find("#NumeroDePedido").keydown(function (e) {
            if (e.keyCode === 13 && isValidInput($(this)) &&
                    pnlTablero.find("#ClientePedido").val()) {
                HoldOn.open({
                    theme: 'sk-bounce',
                    message: 'Por favor espere...'
                });
                $.getJSON(master_url + 'getIDXClave',
                        {
                            PEDIDO: $(this).val(),
                            CLIENTE: pnlTablero.find("#ClientePedido").val()
                        }).done(function (data) {
                    getPedidoByID(data[0].ID, data[0].Cliente);
                }).fail(function (x, y, z) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            }
            if (isValidInput($(this))) {
                tblPedidos.DataTable().column(1).search($(this).val()).draw();
                tblPedidos.DataTable().column(2).search(pnlTablero.find("#ClientePedido").val()).draw();
            } else {
                tblPedidos.DataTable().column(1).search('').draw();
                tblPedidos.DataTable().column(2).search('').draw();
            }
        }).keyup(function () {
            if (isValidInput($(this))) {
                tblPedidos.DataTable().column(1).search($(this).val()).draw();
                tblPedidos.DataTable().column(2).search(pnlTablero.find("#ClientePedido").val()).draw();
            } else {
                tblPedidos.DataTable().column(1).search('').draw();
                tblPedidos.DataTable().column(2).search('').draw();
            }
        });

        btnAgregarDetalle.click(function () {
            if (pedido_valido) {
                pnlDatos.find("#Recibido")[0].selectize.enable();
                var Color = pnlDatos.find("#Color");
                var Semana = pnlDatos.find("#Semana");
                var Maquila = pnlDatos.find("#Maquila");
                var Precio = pnlDatos.find("#Precio");
                var FechaDeEntrega = pnlDatos.find("#FechaEntrega");
                var Recibido = pnlDatos.find("#Recibido");
                var Recio = pnlDatos.find("#Recio");
                var Titulo = pnlDatos.find("#Observacion");
                var Observaciones = pnlDatos.find("#ObservacionDetalle");
                var total_pares = 0;
                $.each(pnlDatos.find("#tblTallas input[name*='C']"), function (k, v) {
                    total_pares += (parseInt($(v).val()) > 0) ? parseInt($(v).val()) : 0;
                    pnlDatos.find("#TPares").val(total_pares);
                });
                if (total_pares > 0) {
                    //REVISAR SI ESE ESTILO/COLOR NO HA SIDO AGREGADO CON ANTERIORIDAD
                    onRevisarRegistro(Estilo.val(), Color.val());
                    if (!added) {
                        /*
                         //AÑADIR FILA
                         var tal = '<div class="row"><div class="col-12 text-danger text-nowrap talla" align="center">';
                         var cnt = '</div><div class="col-12 cantidad" align="center">';
                         var dtm = [
                         0, //ID
                         Recibido.val(), //Recibido
                         Estilo.val(), //EstiloID
                         Estilo.text(), //Estilo
                         Color.val(), //ColorID
                         Color.text(),
                         Semana.val(),
                         Maquila.val(),
                         tal + getTalla('T1') + cnt + getCantidad('C1') + '</div></div>',
                         tal + getTalla('T2') + cnt + getCantidad('C2') + '</div></div>',
                         tal + getTalla('T3') + cnt + getCantidad('C3') + '</div></div>',
                         tal + getTalla('T4') + cnt + getCantidad('C4') + '</div></div>',
                         tal + getTalla('T5') + cnt + getCantidad('C5') + '</div></div>',
                         tal + getTalla('T6') + cnt + getCantidad('C6') + '</div></div>',
                         tal + getTalla('T7') + cnt + getCantidad('C7') + '</div></div>',
                         tal + getTalla('T8') + cnt + getCantidad('C8') + '</div></div>',
                         tal + getTalla('T9') + cnt + getCantidad('C9') + '</div></div>',
                         tal + getTalla('T10') + cnt + getCantidad('C10') + '</div></div>',
                         tal + getTalla('T11') + cnt + getCantidad('C11') + '</div></div>',
                         tal + getTalla('T12') + cnt + getCantidad('C12') + '</div></div>',
                         tal + getTalla('T13') + cnt + getCantidad('C13') + '</div></div>',
                         tal + getTalla('T14') + cnt + getCantidad('C14') + '</div></div>',
                         tal + getTalla('T15') + cnt + getCantidad('C15') + '</div></div>',
                         tal + getTalla('T16') + cnt + getCantidad('C16') + '</div></div>',
                         tal + getTalla('T17') + cnt + getCantidad('C17') + '</div></div>',
                         tal + getTalla('T18') + cnt + getCantidad('C18') + '</div></div>',
                         tal + getTalla('T19') + cnt + getCantidad('C19') + '</div></div>',
                         tal + getTalla('T20') + cnt + getCantidad('C20') + '</div></div>',
                         tal + getTalla('T21') + cnt + getCantidad('C21') + '</div></div>',
                         tal + getTalla('T22') + cnt + getCantidad('C22') + '</div></div>',
                         Precio.val(),
                         total_pares,
                         FechaDeEntrega.val(),
                         '<button type="button" class="btn btn-danger" onclick="onEliminar(this,1)"><span class="fa fa-trash"></span></button>',
                         Recio.val(),
                         Titulo.val(),
                         Observaciones.val(),
                         pnlDatos.find("#Serie").val(),
                         'N', (total_pares * Precio.val())
                         ];
                         PedidoDetalle.row.add(dtm).draw(false);*/
                        //CLEAR
                        total_pares = 0;
                        pnlDatos.find("#TPares").val(0);
                        pnlDatos.find("[name*='C']").val('');
                        FechaDeEntrega.prop('readonly', true);
                        Semana.prop('readonly', true);
                        Recibido[0].selectize.disable();
                        Maquila[0].selectize.clear(true);
                        Recio.val('');
                        Precio.val('');
                        Estilo[0].selectize.clear(true);
                        agregado = 1;
                        btnGuardar.trigger('click');
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "ESTA COMBINACION DE ESTILO/COLOR YA HA SIDO AGREGADA",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                            buttons: false,
                            timer: 2000
                        });
                    }
                } else {
                    //ZERO PARES
                    console.log('zero');
                }
            }
        });

        mdlAviso.draggable({
            handle: ".modal-header"
        });

        pnlDatos.find("#Semana").focusout(function () {
            onValidarAnioDeEntrega();
            onChecarSemanaValida('#Semana');
            onComprobarSemanaMaquila(pnlDatos.find("#Maquila").val(), pnlDatos.find("#Semana").val());
        });

        pnlDatos.find("#Maquila").change(function () {
            onComprobarCapacidades("#Maquila");
            onChecarSemanaValida('#Semana');
            onComprobarSemanaMaquila(pnlDatos.find("#Maquila").val(), pnlDatos.find("#Semana").val());
        });

        validacionSelectPorContenedor(pnlDatos);

        pnlDatos.find("#Clave:not(:read-only)").on('keydown', function (e) {
            if (e.keyCode === 13) {
                onComprobarClavePedido(this);
            }
        });

        btnImprimir.click(function () {
            if (temp !== '') {
                HoldOn.open({message: 'Espere...', theme: 'sk-cube'});
                $.post(master_url + 'onImprimirPedidoReducido', {ID: temp, CLIENTE: pnlDatos.find("#PedidoxCliente").val()}).done(function (data) {
                    //check Apple device
                    if (isAppleDevice() || isMobile) {
                        window.open(data, '_blank');
                    } else {
                        $.fancybox.open({
                            src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
                            type: 'iframe',
                            opts: { 
                                iframe: {
                                    // Iframe template
                                    tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                                    preload: true,
                                    // Custom CSS styling for iframe wrapping element
                                    // You can use this to set custom iframe dimensions
                                    css: {
                                        width: "100%",
                                        height: "100%"
                                    },
                                    // Iframe tag attributes
                                    attr: {
                                        scrolling: "auto"
                                    }
                                }
                            }
                        });
                    }
                }).fail(function (x, y, z) {
                    getError(x);
                    swal('ATENCIÓN', 'NO HA SIDO POSIBLE MOSTRAR EL PEDIDO PARA SU IMPRESIÓN,VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'warning');
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', 'NO HA SIDO POSIBLE MOSTRAR EL PEDIDO PARA SU IMPRESIÓN', 'warning');
            }
        });

        pnlDatos.find("#Precio").focusout(function () {
            var Precio = pnlDatos.find("#Precio").val();
            if (Precio.length <= 0) {
                swal({
                    title: "ATENCIÓN",
                    text: "ES NECESARIO ESCRIBIR UN PRECIO",
                    icon: "warning",
                    focusConfirm: true,
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((value) => {
                    var p = pnlDatos.find("#Precio");
                    p.prop('readonly', false);
                    p.prop('disabled', false);
                    p.val('');
                    p.focus().select();
                });
            }
        });

        pnlDatos.find("#FechaEntrega").focusout(function () {
            //OBTENER ANOS DE ENTREGA
            onValidarAnioDeEntrega();
            //OBTENER AGENTE POR CLIENTE
            $.getJSON(master_url + 'getSemanaXFechaDeEntrega', {Fecha: $(this).val()}).done(function (data) {
                if (data.length > 0) {
                    pnlDatos.find("#Semana").val(data[0].Semana);
                    getProduccionMaquilaSemana(pnlDatos.find("#Maquila").val(), data[0].Semana);
                }
            }).fail(function (x, y, z) {
                getError(x);
            }).always(function () {

            });
        });

        btnGuardar.click(function () {
            var f = new FormData();
            f.append('Clave', Clave.val());
            f.append('Cliente', pnlDatos.find("#PedidoxCliente").val());
            f.append('Agente', pnlDatos.find("#Agente").val());
            f.append('FechaPedido', pnlDatos.find("#FechaPedido").val());
            f.append('Observacion', pnlDatos.find("#Observacion").val());
            f.append('FechaRecepcion', pnlDatos.find("#FechaRecepcion").val());
            var cte = pnlDatos.find("#pedcte").val();
            if (!nuevo) {
                var detalle = [];
                $.each(tblPedidoDetalle.find("tbody tr"), function (k, v) {
                    var tr = PedidoDetalle.row($(this)).data();
                    if (tr[38] === 'N') {
                        var d = new Date(tr[32]);
                        var n = d.getFullYear();
                        detalle.push({
                            Cte: pnlDatos.find("#IDCliente").val(),
                            Estilo: tr[2],
                            EstiloT: tr[3],
                            Color: tr[4],
                            ColorT: tr[5],
                            FechaEntrega: tr[32],
                            Maquila: tr[7],
                            Semana: tr[6],
                            Recio: tr[34],
                            Precio: tr[30],
                            Observacion: tr[35],
                            ObservacionDetalle: tr[36],
                            Serie: tr[37],
                            Ano: n,
                            Recibido: tr[1],
                            Pares: tr[31],
                            C1: $(tr[8]).find("div.cantidad").text(),
                            C2: $(tr[9]).find("div.cantidad").text(),
                            C3: $(tr[10]).find("div.cantidad").text(),
                            C4: $(tr[11]).find("div.cantidad").text(),
                            C5: $(tr[12]).find("div.cantidad").text(),
                            C6: $(tr[13]).find("div.cantidad").text(),
                            C7: $(tr[14]).find("div.cantidad").text(),
                            C8: $(tr[15]).find("div.cantidad").text(),
                            C9: $(tr[16]).find("div.cantidad").text(),
                            C10: $(tr[17]).find("div.cantidad").text(),
                            C11: $(tr[18]).find("div.cantidad").text(),
                            C12: $(tr[19]).find("div.cantidad").text(),
                            C13: $(tr[20]).find("div.cantidad").text(),
                            C14: $(tr[21]).find("div.cantidad").text(),
                            C15: $(tr[22]).find("div.cantidad").text(),
                            C16: $(tr[23]).find("div.cantidad").text(),
                            C17: $(tr[24]).find("div.cantidad").text(),
                            C18: $(tr[25]).find("div.cantidad").text(),
                            C19: $(tr[26]).find("div.cantidad").text(),
                            C20: $(tr[27]).find("div.cantidad").text(),
                            C21: $(tr[28]).find("div.cantidad").text(),
                            C22: $(tr[29]).find("div.cantidad").text()
                        });
                    }
                });
                f.append('Detalle', JSON.stringify(detalle));
                f.append('ID', temp);
                onSave('onModificar', f, function (e) {
                    nuevo = false;
                    if ($.fn.DataTable.isDataTable('#tblPedidos')) {
                        Pedidos.ajax.reload();
                    } else {
                        getRecords();
                    }
                    getPedidoByID(temp, pnlDatos.find("#PedidoxCliente").val());
                    pnlDatos.find("#Estilo")[0].selectize.focus();
                });
            } else {
                var detalle = [];
                $.each(tblPedidoDetalle.find("tbody tr"), function (k, v) {
                    var tr = PedidoDetalle.row($(this)).data();
                    var d = new Date(tr[32]);
                    var n = d.getFullYear();
                    detalle.push({
                        Estilo: tr[2],
                        EstiloT: tr[3],
                        Color: tr[4],
                        ColorT: tr[5],
                        FechaEntrega: tr[32],
                        Maquila: tr[7],
                        Semana: tr[6],
                        Recio: tr[34],
                        Precio: tr[30],
                        Observacion: tr[35],
                        ObservacionDetalle: tr[36],
                        Serie: tr[37],
                        Ano: n,
                        Recibido: tr[1],
                        Pares: tr[31],
                        C1: $(tr[8]).find("div.cantidad").text(),
                        C2: $(tr[9]).find("div.cantidad").text(),
                        C3: $(tr[10]).find("div.cantidad").text(),
                        C4: $(tr[11]).find("div.cantidad").text(),
                        C5: $(tr[12]).find("div.cantidad").text(),
                        C6: $(tr[13]).find("div.cantidad").text(),
                        C7: $(tr[14]).find("div.cantidad").text(),
                        C8: $(tr[15]).find("div.cantidad").text(),
                        C9: $(tr[16]).find("div.cantidad").text(),
                        C10: $(tr[17]).find("div.cantidad").text(),
                        C11: $(tr[18]).find("div.cantidad").text(),
                        C12: $(tr[19]).find("div.cantidad").text(),
                        C13: $(tr[20]).find("div.cantidad").text(),
                        C14: $(tr[21]).find("div.cantidad").text(),
                        C15: $(tr[22]).find("div.cantidad").text(),
                        C16: $(tr[23]).find("div.cantidad").text(),
                        C17: $(tr[24]).find("div.cantidad").text(),
                        C18: $(tr[25]).find("div.cantidad").text(),
                        C19: $(tr[26]).find("div.cantidad").text(),
                        C20: $(tr[27]).find("div.cantidad").text(),
                        C21: $(tr[28]).find("div.cantidad").text(),
                        C22: $(tr[29]).find("div.cantidad").text()
                    });
                });
                f.append('Detalle', JSON.stringify(detalle));
                onSave('onAgregar', f, function (e) {
                    nuevo = false;
                    var dtm = JSON.parse(e);
                    getPedidoByID(dtm.ID, pnlDatos.find("#PedidoxCliente").val());
                    temp = dtm.ID;
//                        $.each(tblPedidoDetalle.find("tbody tr"), function (k, v) {
//                            PedidoDetalle.cell($(this), 38).data('N').draw();
//                        });

                    if ($.fn.DataTable.isDataTable('#tblPedidos')) {
                        Pedidos.ajax.reload();
                    } else {
                        getRecords();
                    }
                    //NUEVO > MODIFICAR
                    Clave.prop('readonly', true);
                    pnlDatos.find("#FechaPedido").prop('readonly', true);
                    pnlDatos.find("#FechaRecepcion").prop('readonly', true);
                    pnlDatos.find("#FechaEntrega").prop('readonly', true);
                    pnlDatos.find("#PedidoxCliente")[0].selectize.disable();
                    pnlDatos.find("#Agente")[0].selectize.disable();
                    pnlDatos.find("#Estilo")[0].selectize.focus();
                });
            }
        });

        btnNuevo.click(function () { 
            nuevo = true;
            pnlDatos.find("#FechaEntrega").prop('readonly', false);
            pnlDatos.find("#Semana").prop('readonly', false);
            pnlDatos.find("#Recibido")[0].selectize.enable();
            pnlDatos.find("#Precio").prop('readonly', true);
            Clave.prop('readonly', false);
            pnlDatos.find("#PedidoxCliente")[0].selectize.enable();
            pnlDatos.find("#Agente")[0].selectize.enable();
            pnlDatos.find("#FechaPedido").prop('readonly', false);
            pnlDatos.find("#FechaRecepcion").prop('readonly', false);
            pnlDatos.find("input,textarea").val("");
            pnlTablero.addClass("d-none");
            pnlDatos.removeClass("d-none");
            Clave.focus();
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
            if ($.fn.DataTable.isDataTable('#tblPedidoDetalle')) {
                PedidoDetalle.clear().draw();
            } else {
                PedidoDetalle = tblPedidoDetalle.DataTable(opciones_detalle);
                $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
            }
            getID();
        });

        btnCancelar.click(function () {
            btnGuardar.prop("disabled", true);
            pnlDatos.find("#PedidoxCliente")[0].selectize.enable();
            pnlDatos.find("#Agente")[0].selectize.enable();
            pnlDatos.find("#FechaEntrega").prop('readonly', true);
            pnlDatos.find("#Semana").prop('readonly', true);
            pnlDatos.find("#Recibido")[0].selectize.disable();
            Clave.prop('readonly', true);
            pnlDatos.find("#FechaPedido").prop('readonly', true);
            pnlDatos.find("#FechaRecepcion").prop('readonly', true);
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass("d-none");
            btnImprimir.addClass("d-none");
            if ($.fn.DataTable.isDataTable('#tblPedidos')) {
                Pedidos.ajax.reload();
            } else {
                getRecords();
            }
            if ($.fn.DataTable.isDataTable('#tblPedidoDetalle')) {
                PedidoDetalle.clear().draw();
            }
            Cliente = 0;
            pnlTablero.find("#NumeroDePedido").focus().select();
        });

        pnlDatos.find("#PedidoxCliente").change(function () {
            if ($(this).val() !== '' && nuevo) {
                //OBTENER AGENTE POR CLIENTE
                Cliente = pnlDatos.find("#PedidoxCliente").val();
                $.getJSON(master_url + 'getAgenteXCliente', {Cliente: Cliente}).done(function (data) {
                    if (data.length > 0) {
                        pnlDatos.find("#Agente")[0].selectize.clear(true);
                        pnlDatos.find("#Agente")[0].selectize.setValue(data[0].Agente);
                        pnlDatos.find("#Agente")[0].selectize.focus();
                    }
                }).fail(function (x, y, z) {
                    getError(x);
                });
            } else {
                pnlDatos.find("#Agente")[0].selectize.clear(true);
            }
        });

        pnlDatos.find("#Color").change(function () {
            var color = $(this).val();
            if (color !== '') {
                pnlDatos.find("#Precio").prop('readonly', false);
            } else {
                pnlDatos.find("#Precio").prop('readonly', true);
            }
        });

        pnlDatos.find("#Estilo").change(function () {
            var estilo = $(this).val();
            if (estilo !== '') {
                pnlDatos.find("#spin").removeClass("d-none");
                pnlDatos.find("#Color").addClass("d-none");
                pnlDatos.find("#Color")[0].selectize.clear(true);
                pnlDatos.find("#Color")[0].selectize.clearOptions();
                //OBTENER COLORES POR ESTILO
                $.getJSON('<?php print base_url('Pedidos/getColoresXEstilo');?>', {Estilo: $(this).val()}).done(function (data) {
                    $.each(data, function (k, v) {
                        pnlDatos.find("#Color")[0].selectize.addOption({text: v.Color, value: v.Clave});
                    });
                    pnlDatos.find("#spin").addClass("d-none");
                    pnlDatos.find("#Color").removeClass("d-none");
                    pnlDatos.find("#Color")[0].selectize.open();
                }).fail(function (x, y, z) {
                    getError(x);
                });
                //OBTENER MAQUILA/SERIE
                $.getJSON(master_url + 'getMaquilaSerieXEstilo', {Estilo: $(this).val()}).done(function (data) {
                    if (data.length > 0) {
                        var dtm = data[0];
                        pnlDatos.find("#Serie").val(data[0].Serie);
                        pnlDatos.find("#Maquila")[0].selectize.clear(true);
                        pnlDatos.find("#Maquila")[0].selectize.setValue(data[0].Maquila);
                        onComprobarSemanaMaquila(data[0].Maquila, pnlDatos.find("#Semana").val());
                        //SET TALLAS
                        var indice = 0;
                        $.each(data[0], function (k, v) {
                            if (parseInt(v) > 0) {
//                                pnlDatos.find("[name='C" + indice + "']").prop('disabled',false);
                                pnlDatos.find("[name='" + k + "']").val(v);
                            } else {
//                                pnlDatos.find("[name='C" + indice + "']").prop('disabled',true);
                                pnlDatos.find("[name='C" + indice + "']").val('');
                            }
                            indice += 1;
                        });
                        //MOSTRAR FOTO
                        if (dtm.Foto !== null && dtm.Foto !== undefined && dtm.Foto !== '') {
                            var ext = getExt(dtm.Foto);
                            if (ext === "gif" || ext === "jpg" || ext === "png" || ext === "jpeg") {
                                $.notify({
                                    // options
                                    icon: base_url + dtm.Foto
                                }, {
                                    // settings
                                    placement: _placement_,
                                    animate: _animate_,
                                    icon_type: 'img',
                                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                                            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                                            '<img  data-notify="icon" class="col-12 img-circle pull-left">' +
                                            '</div>'
                                });
                            }
                            if (ext !== "gif" && ext !== "jpg" && ext !== "jpeg" && ext !== "png" && ext !== "PDF" && ext !== "Pdf" && ext !== "pdf") {
                                $.notify({
                                    // options
                                    icon: base_url + dtm.Foto
                                }, {
                                    // settings
                                    placement: _placement_,
                                    animate: _animate_,
                                    icon_type: 'img',
                                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                                            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                                            '<img  data-notify="icon" class="col-12 img-circle pull-left">' +
                                            '</div>'
                                });
                            }
                        } else {
                            $.notify({
                                // options
                                icon: base_url + dtm.Foto
                            }, {
                                // settings
                                placement: _placement_,
                                animate: _animate_,
                                icon_type: 'img',
                                template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                                        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                                        '<img  data-notify="icon" class="col-12 img-circle pull-left">' +
                                        '</div>'
                            });
                        }
                    }
                }).fail(function (x, y, z) {
                    getError(x);
                });
            } else {
                pnlDatos.find("#Color")[0].selectize.clear(true);
                pnlDatos.find("#Maquila")[0].selectize.clear(true);
                pnlDatos.find("[name*='T']").val('');
                pnlDatos.find("[name*='C']").val('');
            }
        }).focusout(function () {
            console.log('Estilo; ', $(this).val());
        });
        /*CALLS*/

        btnNuevo.trigger('click');
    });

    function init() {
        getOptions("getMaquilas", "Maquila", "Clave", "Maquila", pnlDatos); //Maquilas
    }

    function getRecords() {
        HoldOn.open({
            theme: 'sk-rect',
            message: 'Cargando...'
        });
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if (!$.fn.DataTable.isDataTable('#tblPedidos')) {
            Pedidos = tblPedidos.DataTable({
                "dom": 'Bfrtip',
                buttons: buttons,
                "ajax": {
                    "url": '<?php print base_url('peds'); ?>',
                    "dataSrc": ""
                },
                "columns": [
                    {"data": "ID"}, {"data": "Clave"}, {"data": "Cliente"},
                    {"data": "Agente"}, {"data": "Pares"}, {"data": "FechaPedido"}
                ],
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    }
                ],
                language: lang,
                select: true,
                "autoWidth": true,
                "colReorder": true,
                "displayLength": 20,
                "scrollX": false,
                "bLengthChange": false,
                "deferRender": true,
                "scrollCollapse": false,
                "bSort": true,
                pageResize: true,
                "aaSorting": [
                    [1, 'ASC']
                ],
                initComplete: function (x, y) {
                    HoldOn.close();
                    pnlTablero.find('#ClientePedido')[0].selectize.focus();
                }
            });
            tblPedidos.find('tbody').on('click', 'tr', function () {
                HoldOn.open({
                    theme: 'sk-cube',
                    message: 'Por favor espere...'
                });
                nuevo = false;
                tblPedidos.find("tbody tr").removeClass("success");
                $(this).addClass("success");
                var dtm = Pedidos.row(this).data();
                temp = dtm.Clave;
                getPedidoByID(temp, dtm.Cliente);
            });
        }
        if (!$.fn.DataTable.isDataTable('#tblPedidoDetalle')) {
            tblPedidoDetalle.DataTable().destroy();
        }
    }

    function getOptions(url, comp, key, field, parent) {
        $.getJSON(master_url + url).done(function (data) {
            $.each(data, function (k, v) {
                parent.find("#" + comp)[0].selectize.addOption({text: v[field], value: v[key]});
            });
        }).fail(function (x, y, z) {
            getError(x);
        });
    }

    function onSave(u, f, fu) {
        $.ajax({
            url: master_url + u,
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: f
        }).done(function (data, x, jq) {
            fu(data);
        }).fail(function (x, y, z) {
            console.log(x.responseText, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getID() {
        $.getJSON(master_url + 'getID').done(function (data, x, jq) {
            if (data.length > 0) {
                var ID = $.isNumeric(data[0].CLAVE) ? parseInt(data[0].CLAVE) + 1 : 1;
                Clave.val(ID);
            } else {
                Clave.val('1');
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    var added = false, agregado = 0, pedido_valido = false;

    function onCalcularPares(e) {
        if (pedido_valido) {
            pnlDatos.find("#Recibido")[0].selectize.enable();
            var Estilo = pnlDatos.find("#Estilo");
            var Color = pnlDatos.find("#Color");
            var Semana = pnlDatos.find("#Semana");
            var Maquila = pnlDatos.find("#Maquila");
            var Precio = pnlDatos.find("#Precio");
            var FechaDeEntrega = pnlDatos.find("#FechaEntrega");
            var Recibido = pnlDatos.find("#Recibido");
            var Recio = pnlDatos.find("#Recio");
            var Titulo = pnlDatos.find("#Observacion");
            var Observaciones = pnlDatos.find("#ObservacionDetalle");
            var total_pares = 0;
            $.each(pnlDatos.find("#tblTallas input[name*='C']"), function (k, v) {
                total_pares += (parseInt($(v).val()) > 0) ? parseInt($(v).val()) : 0;
                pnlDatos.find("#TPares").val(total_pares);
            });

            var encabezados = pnlDatos.find("#tblTallas tbody tr:eq(0)");
            var input = $(e);
            var padre = input.parent().index();
            var indice_valor = encabezados.find("td").eq(padre).find("input").val();
            //VALIDACIONES
            if (Estilo.val() !== '' && Color.val() !== '' && Semana.val() !== '' && Maquila.val() !== '' && parseInt(pnlDatos.find("#TPares").val()) > 0
                    && Estilo.text() !== '' && Precio.val() !== '') {
                if (Precio.val() !== '' && Precio.val().length > 0) {
                    if (indice_valor === '') {
                        if (total_pares > 0) {
                            btnAgregarDetalle.focus();
                        } else {
                            //ZERO PARES
                            console.log('zero');
                        }
                    }
                } else {
                    swal('ATENCIÓN', 'EL PRECIO NO ES VÁLIDO', 'warning');
                }
            }
        }
    }

    function onEliminar(r, index) {
        swal({
            title: "¿Deseas eliminar el registro? ",
            text: "*El registro se eliminará de forma permanente*",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
            closeOnClickOutside: false,
            closeOnEsc: false,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                switch (index) {
                    case 1:
                        //REMOVER (NO GUARDADO)
                        PedidoDetalle.row($(r).parents('tr')).remove().draw();
                        break;
                    case 2:
                        //CHECAR SI TIENE CONTROL
                        var dt = PedidoDetalle.row($(r).parents('tr')).data();
                        $.getJSON(master_url + 'onVerificarByID', {ID: dt[0]}).done(function (data) {
                            console.log(data);
                            var x = data[0];
                            if (parseInt(x.Control) <= 0) {
                                console.log('No Tiene control ', dt[0]);
                                $.post(master_url + 'onEliminar', {ID: dt[0]}).done(function (data) {
                                    //REMOVER AL EDITAR (GUARDADO)
                                    PedidoDetalle.row($(r).parents('tr')).remove().draw();
                                    swal({
                                        title: "ATENCIÓN",
                                        text: "SE HA ELIMINADO EL REGISTRO",
                                        icon: "success",
                                        closeOnClickOutside: false,
                                        closeOnEsc: false,
                                        buttons: false,
                                        timer: 1500
                                    });
                                }).fail(function (x, y, z) {
                                    console.log(x, y, z);
                                }).always(function () {
                                });
                            } else {
                                swal({
                                    title: "ATENCIÓN",
                                    text: "YA TIENE UN CONTROL ASIGNADO, ELIMINE PRIMERO EL CONTROL.",
                                    icon: "error",
                                    closeOnClickOutside: false,
                                    closeOnEsc: false
                                });
                            }
                        });
                        break;
                }
            }
        });
    }

    function getTalla(e) {
        return parseInt(pnlDatos.find("#tblTallas tbody tr:eq(0)").find("[name='" + e + "']").val()) !== '' ? pnlDatos.find("#tblTallas tbody tr:eq(0)").find("[name='" + e + "']").val() : '';
    }

    function getCantidad(e) {
        return parseInt(pnlDatos.find("#tblTallas tbody tr:eq(1)").find("[name='" + e + "']").val()) > 0 ? pnlDatos.find("#tblTallas tbody tr:eq(1)").find("[name='" + e + "']").val() : 0;
    }

    function onRevisarRegistro(estilo, color) {
        added = false;
        if (PedidoDetalle.rows().count() > 0) {
            $.each(tblPedidoDetalle.find("tbody tr"), function () {
                var tr = PedidoDetalle.row($(this)).data();
                if (tr[2] === estilo && tr[4] === color) {
                    added = true;
                    return false;
                }
            });
        } else {
            added = false;
        }
    }

    function getPedidoByID(idx, cliente) {
        $.getJSON('<?php print base_url('pedsid'); ?>', {ID: idx, CLIENTE: cliente}).done(function (data) {
            pnlDatos.find("input").val("");
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
            var dt = data[0];//Encabezado
            //SEGURIDAD
            pnlDatos.find("#ID").val(dt.PDID);
            Clave.val(dt.Clave);
            pnlDatos.find("#pedcte").val(dt.Cliente);
            pnlDatos.find("#PedidoxCliente")[0].selectize.setValue(dt.Cliente);
            pnlDatos.find("#FechaPedido").val(dt.FechaPedido);
            pnlDatos.find("#FechaRecepcion").val(dt.FechaRecepcion);
            pnlDatos.find("#Agente")[0].selectize.setValue(dt.Agente);

            pnlDatos.find("#FechaEntrega").val(dt.FechaEntrega);
            pnlDatos.find("#Semana").val(dt.Semana);
            pnlDatos.find("#Recibido")[0].selectize.setValue(dt.Recibido);

            Clave.prop('readonly', true);
            pnlDatos.find("#FechaPedido").prop('readonly', true);
            pnlDatos.find("#FechaRecepcion").prop('readonly', true);
            pnlDatos.find("#FechaEntrega").prop('readonly', true);
            pnlDatos.find("#Recibido")[0].selectize.disable();
            pnlDatos.find("#PedidoxCliente")[0].selectize.disable();
            pnlDatos.find("#Agente")[0].selectize.disable();

            btnImprimir.removeClass("d-none");
            pnlDatos.find("#PedidoxCliente")[0].selectize.disable();
            pnlTablero.addClass("d-none");
            pnlDatos.removeClass('d-none');
            pnlDatos.find("#Estilo")[0].selectize.focus();
            $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
            temp = dt.Clave;
            opciones_detalle.ajax = {
                "url": '<?php print base_url('pedbyid') ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": {
                    "ID": dt.Clave,
                    "CLIENTE": dt.Cliente
                }
            };
            if ($.fn.DataTable.isDataTable('#tblPedidoDetalle')) {
                tblPedidoDetalle.DataTable().destroy();
            }
            PedidoDetalle = tblPedidoDetalle.DataTable(opciones_detalle);
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
        }).always(function () {
            HoldOn.close();
            onComprobarCapacidades("#Maquila");
        });
    }
    function onReload() {
        PedidoDetalle.ajax.reload();
    }

    function getProduccionMaquilaSemana(M, S) {
        $.getJSON(master_url + 'getProduccionMaquilaSemana', {Maquila: M, Semana: S}).done(function (data) {
            if (data.length > 0) {
                pnlDatos.find("#ProduccionMaquilaSemana").val(data[0].Pares);
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
        });
    }

    function onAgregarObservaciones() {
        swal({
            text: 'Observaciones',
            content: "input",
            button: {
                text: "Aceptar",
                closeModal: true
            },
            closeOnClickOutside: false,
            closeOnEsc: false
        }).then((Observaciones) => {
            pnlDatos.find("#Observacion").val(Observaciones.toUpperCase());
            pnlDatos.find("#ObservacionDetalle").val(Observaciones);
            pnlDatos.find("[name='C1']").focus();
        });
    }

    function isAppleDevice() {
        return (
                (navigator.userAgent.toLowerCase().indexOf("ipad") > -1) ||
                (navigator.userAgent.toLowerCase().indexOf("iphone") > -1) ||
                (navigator.userAgent.toLowerCase().indexOf("ipod") > -1)
                );
    }

    function onComprobarClavePedido(e) {
        $.getJSON(master_url + 'onComprobarClavePedido', {CLAVE: $(e).val()}).done(function (data) {
            console.log(data);
            if (parseInt(data[0].EXISTE) > 0) {
                swal({
                    title: "ATENCIÓN",
                    text: "ESTE FOLIO YA EXISTE, INGRESE UNO DIFERENTE.",
                    icon: "warning",
                    focusConfirm: true,
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1200
                }).then((value) => {
                    Clave.focus().select();
                });
            } else {
                pnlDatos.find("#PedidoxCliente")[0].selectize.focus();
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function onComprobarCapacidades(e) {
        var Semana = $("#Semana").val();
        $.getJSON(master_url + 'getCapacidadMaquila', {CLAVE: pnlDatos.find("#Maquila").val(), SEMANA: Semana}).done(function (data) {
            console.log(data);
            var dx = data[0];
            if (data.length > 0) {
                var x = '<ul class="list-group">';
                var ligr = '<li class="list-group-item d-flex justify-content-between">', ligrpclose = '</li>';
                x += ligr + '<span class="text-info font-weight-bold">CAPACIDAD</span>';
                x += '<span class="badge badge-primary badge-pill font-weight-bold">' + (dx.CAPACIDAD === null ? 0 : dx.CAPACIDAD) + '</span>' + ligrpclose;
                x += ligr + '<span class="text-info font-weight-bold">PARES EN LA SEMANA </span><span class="text-danger font-weight-bold">' + Semana + '</span>';
                x += '<span class="badge badge-primary badge-pill font-weight-bold">' + (dx.PARES === null ? 0 : dx.PARES) + '</span>' + ligrpclose;
                x += ligr + '<span class="text-info font-weight-bold">ESPACIO</span>';
                x += '<span class="badge badge-primary badge-pill font-weight-bold">' + (dx.CAPACIDAD === null ? 0 : (dx.CAPACIDAD - dx.PARES)) + '</span>' + ligrpclose;
                x += '</ul>';
                mdlAviso.find(".modal-body").html(x);
                if (dx.CAPACIDAD !== null && dx.PARES !== null) {
                    var CAPACIDAD = parseFloat(dx.CAPACIDAD), PARES = parseFloat(dx.PARES);
                    if (PARES > CAPACIDAD) {
                        mdlAviso.modal({backdrop: false});
                        setTimeout(function () {
                            mdlAviso.modal('hide');
                        }, 5000);
                    }
                }
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            swal('ATENCION', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLES', 'warning');
        });
    }

    function onComprobarSemanaMaquila(m, s) {
        /*COMPROBAR FECHA POR SEMANA(ABIERTA,CERRADA) Y MAQUILA*/
        $.getJSON(master_url + 'onComprobarSemanaMaquila', {MAQUILA: parseInt(m), SEMANA: s}).done(function (data) {
            console.log(data);
            var cerrada = data[0].EXISTE;
            if (parseInt(cerrada) === 0) {
                console.log('SEMANA , MAQUILA (FECHA) : OK');
                pedido_valido = true;
            } else {
                console.log('LA SEMANA , MAQUILA (FECHA) ESTA CERRADA');
                swal('ATENCIÓN', 'LA SEMANA, MAQUILA POR FECHA DE ENTREGA, ESTA CERRADA', 'warning').then((value) => {
                    pnlDatos.find("#FechaPedido").focus();
                });
                onBeep(2);
                pedido_valido = false;
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
        });
    }

    function onValidarAnioDeEntrega() {
//OBTENER ANOS DE ENTREGA
        $.getJSON(master_url + 'getAnosValidos').done(function (data) {
            var anos = data[0];
            var fecha_valida = false;
            var fe = pnlDatos.find("#FechaEntrega").val();
            if (fe !== '') {
                $.each(data, function (k, v) {
                    if (fe.includes(v.Anos)) {
                        fecha_valida = true;
                        return false;
                    }
                });
                if (!fecha_valida) {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN SEMANAS DE PRODUCCIÓN PARA ESTA FECHA ",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        buttons: false,
                        timer: 1200
                    }).then((value) => {
                        pnlDatos.find("#FechaEntrega").val('');
                        pnlDatos.find("#Semana").val('');
                        pnlDatos.find("#FechaEntrega").focus();
                    });
                }
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        }).always(function () {

        });
    }

    function onChecarSemanaValida(e) {
        var n = $(e);
        if (n.val() !== '') {
            $.getJSON(master_url + 'onChecarSemanaValida', {ID: $(e).val()}).done(function (data) {
                if (parseInt(data[0].Semana) <= 0) {
                    var options = {
                        title: "Indique una semana de producción válida",
                        text: "La semana " + $(e).val() + " no existe o no ha sido generada.",
                        icon: "warning",
                        focusConfirm: true,
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    };
                    swal(options).then((value) => {
//                        onVerificarFormValido();
                        $(e).val('').focus().select();
                    });
                }
            }).fail(function (x) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            }).always(function () {
//                onVerificarFormValido();
            });
        }
    }
</script>
<style>
    #tblPedidoDetalle table tbody{
        height: 300px !important;
    }

    #tblPedidoDetalle tbody td{
        font-weight: bold; 
        left: 20px;
        top: -5px;
    }

    #tblPedidoDetalle tbody tr td{
        border: 2px solid #fff !important;
    }
    #tblPedidoDetalle tbody tr:hover td{
        /*border: 2px solid #007bff !important;*/
        border-width: 2px !important;
        border-style: solid !important;
        border-top-color: #007bff !important;
        border-bottom-color: #007bff !important;
        background-color: #fff !important;
        color: #000 !important;  
    }

    #tblPedidoDetalle tbody tr:hover td:first-child{ 
        border-top-left-radius: 5px !important;
        border-bottom-left-radius: 5px !important;
        border-left-color: #007bff !important;
    }

    #tblPedidoDetalle tbody tr:hover td:last-child{ 
        border-top-right-radius:  5px !important;
        border-bottom-right-radius:  5px !important;
        border-right-color: #007bff !important;
    }

    #tblPedidoDetalle tr:hover td{
        color:#000;
        background-color: #fff;
    } 

    div.zoom:hover{
        cursor: pointer;
        background-color: #fff;
    }

    #tblTallas tbody tr:hover {
        background-color: #333 !important;
        color: #fff !important; 
    } 

    table.dataTable tbody>tr.selected, table.dataTable tbody>tr.selected td{
        border-width: 2px !important;
        border-style: solid !important;
        border-bottom-color: #007bff !important;
        background-color: #fff !important;
        color: #000 !important; 
    }
</style>