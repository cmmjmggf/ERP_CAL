<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5 float-left">
                <legend >Calcula Minutaje de Semana-Maquila</legend>
            </div>
            <div class="col-sm-7 float-right" align="right">
                <button type="button" class="btn btn-secondary btn-sm" id="btnHistory"><i class="fa fa-history"></i> History Sem-Maq</button>
                <button type="button" class="btn btn-danger btn-sm" id="btnImprime"><i class="fa fa-file-pdf"></i> Reporte</button>
                <button type="button" class="btn btn-warning btn-sm" id="btnCalculaTodo"><i class="fa fa-calculator"></i> Calcula Todo S/Prog</button>
                <button type="button" class="btn btn-info btn-sm" id="btnTiemposXEstilo"><i class="fa fa-clock"></i> Tiempos X Estilo</button>
                <button type="button" class="btn btn-success btn-sm" id="btnCierraSem"><i class="fa fa-check"></i> Cierra Sem</button>
            </div>
        </div>
        <hr>
        <div class="row" id="pnlValidacion">

            <div class="col-1">
                <label class="">Año</label>
                <input type="text" class="form-control form-control-sm numbersOnly" required="" maxlength="4" id="Ano" name="Ano"   >
            </div>
            <div class="col-1">
                <label class="">Maq</label>
                <input type="text" class="form-control form-control-sm numbersOnly" required="" maxlength="2" id="Maq" name="Maq"   >
            </div>
            <div class="col-1">
                <label class="">Sem</label>
                <input type="text" class="form-control form-control-sm numbersOnly" required="" maxlength="2" id="Sem" name="Sem"   >
            </div>
            <div class="col-1">
                <label class="">Pares</label>
                <input type="text" class="form-control form-control-sm numbersOnly" readonly="" maxlength="4" id="Pares" name="Pares"   >
            </div>
            <div class="col-3" >
                <label for="" >Cliente</label>
                <select id="Cliente" name="Cliente" class="form-control form-control-sm  NotSelectize" >
                    <option value=""></option>
                    <?php
                    foreach ($this->db->select("C.Clave AS CLAVE, concat(C.Clave,'-',C.RazonS) AS CLIENTE ", false)
                            ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('abs(C.Clave)', 'ASC')->get()->result() as $k => $v) {
                        print "<option value='{$v->CLAVE}'>{$v->CLIENTE}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-1">
                <label class="">Pedido</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="8" id="Pedido" name="Pedido"   >
            </div>
            <div class="col-1">
                <label class="text-info">Min-Aprob</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="MinutosAprob" name="MinutosAprob"  required="" >
            </div>
            <div class="col-1 " align="right">
                <button type="button" class="btn btn-primary btn-sm mt-4" id="btnCalculaMinutaje"><i class="fa fa-stopwatch"></i> Calcula Minutaje</button>
            </div>
        </div>
        <hr>

        <!--        Ordenamiento-->
        <div class="row">
            <div class="col-1 ">
                <label class="text-info">Ordenar por:</label>
            </div>
            <div class="col-1 ">
                <button type="button" class="btn btn-info btn-sm" id="btnOrdenaXPedido" onclick="ordenaPorPedido()"><i class="fa fa-archive"></i> Pedido</button>
            </div>
            <div class="col-1 ">
                <button type="button" class="btn btn-info btn-sm" id="btnOrdenaXEstiloColor" onclick="ordenaPorEstiloColor()"><i class="fa fa-shoe-prints"></i> Estilo-Color</button>
            </div>
            <div class="col-1 ">
                <button type="button" class="btn btn-info btn-sm" id="btnOrdenaXFecEnt" onclick="ordenaPorFechaEntrega()"><i class="fa fa-calendar-alt"></i> Fecha Entrega</button>
            </div>
        </div>
        <!--Tabla-->
        <div id="Registros" class="datatable-wide">
            <table id="tblRegistros" class="table table-sm display " style="width:100%">
                <thead>
                    <tr>
                        <th>Pedido</th>
                        <th>Cliente</th>
                        <th></th>
                        <th>Fec-Ent</th>
                        <th>Año</th>
                        <th>Semana</th>
                        <th>Maquila</th>
                        <th>Estilo</th>
                        <th>Color</th>
                        <th>Pares</th>
                        <th>Avance</th>
                        <th>Precio</th>
                        <th>Obs</th>
                        <th>Obs 2</th>
                        <th class="d-none">bPedido</th>
                        <th class="d-none">besticolor</th>
                        <th class="d-none">bfecha</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <hr>
        <form id="frmCaptura">
            <!--        tiempos por estilo-->
            <div class="row mt-1">
                <div class="col-2">
                    <label class="text-strong text-danger mt-4">Tiempo x Estilo</label>
                </div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-1">
                            <label class="">Corte</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="tecorte" name="tecorte"   >
                        </div>
                        <div class="col-1">
                            <label class="">Rayado</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="terayado" name="terayado"   >
                        </div>
                        <div class="col-1">
                            <label class="">Rebajado</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="terebaja" name="terebaja"   >
                        </div>
                        <div class="col-1">
                            <label class="">Foleado</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="tefolead" name="tefolead"   >
                        </div>
                        <div class="col-1">
                            <label class="">Entretelado</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="teentrete" name="teentrete"   >
                        </div>
                        <div class="col-1">
                            <label class="">Pespunte</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="tepespu" name="tepespu"   >
                        </div>
                        <div class="col-1">
                            <label class="">Ensuelado</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="teensuel" name="teensuel"   >
                        </div>
                        <div class="col-1">
                            <label class="">Prel-Pes</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="teprepes" name="teprepes"   >
                        </div>
                        <div class="col-1">
                            <label class="">Laser</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="tetejido" name="tetejido"   >
                        </div>
                        <div class="col-1">
                            <label class="">Montado</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="temontado" name="temontado"   >
                        </div>
                        <div class="col-1">
                            <label class="">Adorno</label>
                            <input type="text" class="form-control form-control-sm " readonly="" id="teadorno" name="teadorno"   >
                        </div>
                        <div class="col-1">
                            <label class="">Total</label>
                            <input type="text" class="form-control form-control-sm  azul" readonly="" name="tetotal"  id="tetotal"   >
                        </div>
                    </div>
                </div>
            </div>
            <!--        personal-->
            <div class="row mt-1">
                <div class="col-2">
                    <label class="text-strong text-danger">Personal</label>
                </div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="pcorte" name="pcorte"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="prayado" name="prayado"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="prebaja" name="prebaja"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="pfolead" name="pfolead"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="pentrete" name="pentrete"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="ppespu" name="ppespu"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="pensuel" name="pensuel"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="pprepes" name="pprepes"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="ptejido" name="ptejido"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="pmontado" name="pmontado"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="padorno" name="padorno"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm  azul" readonly=""  id="ptotal"  name="ptotal" >
                        </div>
                    </div>
                </div>
            </div>
            <!--        minutaje-->
            <div class="row mt-1">
                <div class="col-2">
                    <label class="text-strong text-danger">Minutaje Maq-Sem</label>
                </div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="mcorte" name="mcorte"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="mrayado" name="mrayado"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="mrebaja" name="mrebaja"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="mfolead" name="mfolead"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="mentrete" name="mentrete"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="mpespu" name="mpespu"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="mensuel" name="mensuel"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="mprepes" name="mprepes"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="mtejido" name="mtejido"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="mmontado" name="mmontado"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="madorno" name="madorno"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm  azul notSum" readonly=""  id="mtotal" name="mtotal"   >
                        </div>
                    </div>
                </div>
            </div>
            <!--        diferencia-->
            <div class="row mt-1">
                <div class="col-2">
                    <label class="text-strong text-danger">Diferencia</label>
                </div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="dcorte" name="dcorte"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="drayado" name="drayado"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="drebaja" name="drebaja"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="dfolead" name="dfolead"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="dentrete" name="dentrete"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="dpespu" name="dpespu"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="densuel" name="densuel"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="dprepes" name="dprepes"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="dtejido" name="dtejido"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="dmontado" name="dmontado"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm " readonly="" id="dadorno" name="dadorno"   >
                        </div>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm  azul notSum" readonly=""  id="dtotal"  name="dtotal" >
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="dropdown-menu" style="font-size: 12px;" id='menu'>
    <a class="dropdown-item text-primary" href="#" onclick="onModificarRenglonPedido()"><i class="fa fa-pencil-alt"></i> Modificar</a>
</div>
<div class="modal " id="mdlEditarRenglonPedido"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica Pedido (NO modifica FACTURADO/TERMINADO)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-4">
                            <label for="Clave" >Pedido</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="12" id="Pedido" name="Pedido">
                        </div>
                        <div class="col-4">
                            <label for="Clave" >Fec-Ent</label>
                            <input type="text" class="form-control form-control-sm date notEnter"  id="FecEnt" name="FecEnt">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="Clave" >Año</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="4" id="Ano" name="Ano">
                        </div>
                        <div class="col-2">
                            <label for="Clave" >Sem</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="Sem" name="Sem">
                        </div>
                        <div class="col-2">
                            <label for="Clave" >Maq</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="Maq" name="Maq">
                        </div>
                        <div class="col-2">
                            <label for="Clave" >Estilo</label>
                            <input type="text" class="form-control form-control-sm" maxlength="6"  id="Estilo" name="Estilo">
                        </div>
                        <div class="col-2">
                            <label for="Clave" >Color</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2"  id="Color" name="Color">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-4">
                            <label class="badge badge-danger" style="font-size: 14px;">Nota: Sólo capture los campos que se van a modificar</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptar">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/CalculaMinutajeMaqSem/';
    var pnlTablero = $("#pnlTablero");
    var tblRegistros = $('#tblRegistros');
    var Registros;
    var asc = true;
    var asc2 = true;
    var asc3 = true;
    function onModificarRenglonPedido() {
        var renglones_seleccionados = Registros.rows('.selected').data().length;
        if (renglones_seleccionados > 0) {
            $('#mdlEditarRenglonPedido').modal('show');
        } else {
            swal('ATENCIÓN', 'NO HA SELECCIONADO NINGÚN REGISTRO', 'warning');
        }
    }

    $(document).ready(function () {
        init();
        handleEnterDiv(pnlTablero);

        /*Funciones modal*/
        $('#mdlEditarRenglonPedido').on('shown.bs.modal', function () {
            handleEnterDiv($('#mdlEditarRenglonPedido'));
            $('#mdlEditarRenglonPedido').find("input").val("");
            $('#mdlEditarRenglonPedido').find('#Pedido').focus();
        });

        $('#mdlEditarRenglonPedido').find("#btnAceptar").click(function () {

            swal({
                buttons: ["Cancelar", "Aceptar"],
                title: 'Estás Seguro?',
                text: "Esta acción no se puede revertir",
                icon: "warning",
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then((action) => {
                if (action) {
                    var ids_renglones = [];
                    $.each(tblRegistros.find("tbody tr.selected"), function (k, v) {
                        var r = Registros.row($(this)).data();
                        ids_renglones.push({
                            ID: r.ID
                        });
                    });
                    var f = new FormData();
                    f.append('pedido', $('#mdlEditarRenglonPedido').find("#Pedido").val());
                    f.append('fecent', $('#mdlEditarRenglonPedido').find("#FecEnt").val());
                    f.append('ano', $('#mdlEditarRenglonPedido').find("#Ano").val());
                    f.append('sem', $('#mdlEditarRenglonPedido').find("#Sem").val());
                    f.append('maq', $('#mdlEditarRenglonPedido').find("#Maq").val());
                    f.append('estilo', $('#mdlEditarRenglonPedido').find("#Estilo").val());
                    f.append('color', $('#mdlEditarRenglonPedido').find("#Color").val());
                    f.append('renglones', JSON.stringify(ids_renglones));
                    $.ajax({
                        url: '<?php print base_url('CalculaMinutajeMaqSem/onModificarEnMasa'); ?>',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: f
                    }).done(function (data, x, jq) {
                        console.log(data);
                        swal({
                            title: 'INFO',
                            text: 'SE HAN MODIFICADO LOS DATOS CORRECTAMENTE',
                            icon: 'success'
                        }).then((action) => {
                            Registros.ajax.reload();
                            $('#mdlEditarRenglonPedido').modal('hide');
                        });
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            });

        });

        pnlTablero.find('#Registros').on("contextmenu", function (e) {
            e.preventDefault();
            var top = e.pageY - 40;
            var left = e.pageX;
            $("#menu").css({
                display: "block",
                top: top,
                left: left
            });
            return false; //blocks default Webbrowser right click menu
        });
        $(document).click(function () {
            $("#menu").hide();
        });
        pnlTablero.find("#btnTiemposXEstilo").click(function () {
            $.fancybox.open({
                src: base_url + '/TiemposXEstilo.shoes/?origen=PRODUCCION',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
                        console.info('done!');
                    },
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
        });
        pnlTablero.find("#btnImprime").click(function () {
            $('#mdlParesAsignadosXTiempos').modal('show');
        });
        pnlTablero.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    pnlTablero.find("#Ano").val("");
                    pnlTablero.find("#Ano").focus();
                });
            }
        });
        pnlTablero.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
        pnlTablero.find("#Sem").keydown(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var ano = pnlTablero.find("#Ano");
                    onComprobarSemanasProduccion($(this), ano.val());
                }
            }

        });
        pnlTablero.find("#Cliente").change(function () {
            pnlTablero.find("#Pedido").focus().select();
        });
        pnlTablero.find("#Pedido").keydown(function (e) {
            //Registros.column(0).search('^' + $(this).val() + '$', true, false).draw();
            if (e.keyCode === 13) {
                var cte = pnlTablero.find("#Cliente").val();
                if ($(this).val()) {
                    getRegistrosPorCliente(cte, $(this).val());
                }
            }

        });
        pnlTablero.find("#btnCalculaMinutaje").click(function () {
            isValid('pnlValidacion');
            if (valido) {

                var min_apro = pnlTablero.find("#MinutosAprob").val();
                var ano = pnlTablero.find("#Ano").val();
                var sem = pnlTablero.find("#Sem").val();
                var maq = pnlTablero.find("#Maq").val();
                var totalTiempos = 0;
                var sumCorte = 0, sumRayado = 0, sumRebajado = 0, sumFoleado = 0, sumEntrete = 0, sumPespu = 0, sumEnsuel = 0, sumPrepes = 0, sumTejido = 0, sumMontado = 0, sumAdorno = 0;
                //Obtiene minutaje necesitado
                $.ajax({
                    url: master_url + 'getPedidosParaMinutaje',
                    type: "GET",
                    data: {Ano: ano, Sem: sem, Maq: maq},
                    async: false,
                    dataType: "json"
                }).done(function (dataPedidos) {
                    if (dataPedidos.length > 0) {
                        var estilos_sin_tiempos = '';
                        var sintiempos = false;
                        $.each(dataPedidos, function (k, v) {
                            $.ajax({
                                url: master_url + 'getTiemposEstilo',
                                type: "GET",
                                data: {Estilo: v.estilo},
                                async: false,
                                dataType: "json"
                            }).done(function (data) {
                                if (data.length > 0) {
                                    var tiempos = data[0];
                                    var corte = (parseFloat(tiempos.cortef) + parseFloat(tiempos.cortep)) * parseFloat(v.pares);
                                    sumCorte = sumCorte + corte;
                                    var rayado = (parseFloat(tiempos.rayado)) * parseFloat(v.pares);
                                    sumRayado = sumRayado + rayado;
                                    var rebaja = (parseFloat(tiempos.rebaja)) * parseFloat(v.pares);
                                    sumRebajado = sumRebajado + rebaja;
                                    var folead = (parseFloat(tiempos.folead)) * parseFloat(v.pares);
                                    sumFoleado = sumFoleado + folead;
                                    var entrete = (parseFloat(tiempos.entrete)) * parseFloat(v.pares);
                                    sumEntrete = sumEntrete + entrete;
                                    var pespu = (parseFloat(tiempos.pespu)) * parseFloat(v.pares);
                                    sumPespu = sumPespu + pespu;
                                    var ensuel = (parseFloat(tiempos.ensuel)) * parseFloat(v.pares);
                                    sumEnsuel = sumEnsuel + ensuel;
                                    var prepes = (parseFloat(tiempos.prepes)) * parseFloat(v.pares);
                                    sumPrepes = sumPrepes + prepes;
                                    var tejido = (parseFloat(tiempos.tejido)) * parseFloat(v.pares);
                                    sumTejido = sumTejido + tejido;
                                    var montado = (parseFloat(tiempos.montado)) * parseFloat(v.pares);
                                    sumMontado = sumMontado + montado;
                                    var adorno = (parseFloat(tiempos.adorno)) * parseFloat(v.pares);
                                    sumAdorno = sumAdorno + adorno;
                                } else {
                                    sintiempos = true;
                                    estilos_sin_tiempos += v.estilo + " \n";

                                }

                            }).fail(function (x) {
                                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                                console.log(x.responseText);
                            });
                        });

                        //Mensaje de estilos sin tiempos
                        if (sintiempos) {
                            swal('ATENCIÓN', "Estos estilos no tienen tiempos capturados: \n\n" + estilos_sin_tiempos, 'warning').then((value) => {
                            });
                        }
                        // Pinta valores tiempos
                        totalTiempos = sumCorte + sumRayado + sumRebajado + sumFoleado + sumEntrete + sumPespu + sumEnsuel + sumPrepes + sumTejido + sumMontado + sumAdorno;
                        pnlTablero.find("#tecorte").val(sumCorte.toFixed(2));
                        pnlTablero.find("#terayado").val(sumRayado.toFixed(2));
                        pnlTablero.find("#terebaja").val(sumRebajado.toFixed(2));
                        pnlTablero.find("#tefolead").val(sumFoleado.toFixed(2));
                        pnlTablero.find("#teentrete").val(sumEntrete.toFixed(2));
                        pnlTablero.find("#tepespu").val(sumPespu.toFixed(2));
                        pnlTablero.find("#teensuel").val(sumEnsuel.toFixed(2));
                        pnlTablero.find("#teprepes").val(sumPrepes.toFixed(2));
                        pnlTablero.find("#tetejido").val(sumTejido.toFixed(2));
                        pnlTablero.find("#temontado").val(sumMontado.toFixed(2));
                        pnlTablero.find("#teadorno").val(sumAdorno.toFixed(2));

                        pnlTablero.find("#tetotal").val(totalTiempos.toFixed(2));
                    } else {
                        swal('ERROR', 'NO EXISTEN PEDIDOS PARA CALCULAR EL MINUTAJE', 'warning').then((value) => {
                            pnlTablero.find('#Sem').focus().select();
                            return;
                        });
                    }
                }).fail(function (x) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
                //Obtiene el numero de personal

                $.ajax({
                    url: master_url + 'getPersonal',
                    type: "GET",
                    async: false,
                    data: {maq: maq},
                    dataType: "json"
                }).done(function (dataPersonal) {
                    if (dataPersonal.length > 0) {
                        var p = dataPersonal[0];
                        pnlTablero.find("#pcorte").val(p.corte);
                        pnlTablero.find("#prayado").val(p.rayado);
                        pnlTablero.find("#prebaja").val(p.rebajado);
                        pnlTablero.find("#pfolead").val(p.foleado);
                        pnlTablero.find("#pentrete").val(p.entrete);
                        pnlTablero.find("#ppespu").val(p.pespu);
                        pnlTablero.find("#pensuel").val(p.ensuelado);
                        pnlTablero.find("#pprepes").val(p.prepes);
                        pnlTablero.find("#ptejido").val(p.laser);
                        pnlTablero.find("#pmontado").val(p.montado);
                        pnlTablero.find("#padorno").val(p.adorno);
                        var total = parseInt(p.corte) + parseInt(p.rayado) + parseInt(p.rebajado) +
                                parseInt(p.foleado) + parseInt(p.entrete) + parseInt(p.pespu) + parseInt(p.ensuelado) +
                                parseInt(p.prepes) + parseInt(p.laser) + parseInt(p.montado) + parseInt(p.adorno);
                        pnlTablero.find("#ptotal").val(parseInt(total));


                        //Calcula el minutaje con el personal actual
                        var tpcorte = p.corte * min_apro;
                        var tprayado = p.rayado * min_apro;
                        var tprebajado = p.rebajado * min_apro;
                        var tpfoleado = p.foleado * min_apro;
                        var tpentrete = p.entrete * min_apro;
                        var tppespu = p.pespu * min_apro;
                        var tpensuelado = p.ensuelado * min_apro;
                        var tpprepes = p.prepes * min_apro;
                        var tplaser = p.laser * min_apro;
                        var tpmontado = p.montado * min_apro;
                        var tpadorno = p.adorno * min_apro;
                        pnlTablero.find("#mcorte").val((tpcorte).toFixed(2));
                        pnlTablero.find("#mrayado").val((tprayado).toFixed(2));
                        pnlTablero.find("#mrebaja").val((tprebajado).toFixed(2));
                        pnlTablero.find("#mfolead").val((tpfoleado).toFixed(2));
                        pnlTablero.find("#mentrete").val((tpentrete).toFixed(2));
                        pnlTablero.find("#mpespu").val((tppespu).toFixed(2));
                        pnlTablero.find("#mensuel").val((tpensuelado).toFixed(2));
                        pnlTablero.find("#mprepes").val((tpprepes).toFixed(2));
                        pnlTablero.find("#mtejido").val((tplaser).toFixed(2));
                        pnlTablero.find("#mmontado").val((tpmontado).toFixed(2));
                        pnlTablero.find("#madorno").val((tpadorno).toFixed(2));
                        var mtotal = tpcorte + tprayado + tprebajado + tpfoleado + tpentrete + tppespu + tpensuelado + tpprepes + tplaser + tpmontado + tpadorno;
                        pnlTablero.find("#mtotal").val((mtotal).toFixed(2));

                        //Calcula la diferencia entre lo necesitado y lo real
                        pnlTablero.find("#dcorte").val((tpcorte - sumCorte).toFixed(2));
                        pnlTablero.find("#drayado").val((tprayado - sumRayado).toFixed(2));
                        pnlTablero.find("#drebaja").val((tprebajado - sumRebajado).toFixed(2));
                        pnlTablero.find("#dfolead").val((tpfoleado - sumFoleado).toFixed(2));
                        pnlTablero.find("#dentrete").val((tpentrete - sumEntrete).toFixed(2));
                        pnlTablero.find("#dpespu").val((tppespu - sumPespu).toFixed(2));
                        pnlTablero.find("#densuel").val((tpensuelado - sumEnsuel).toFixed(2));
                        pnlTablero.find("#dprepes").val((tpprepes - sumPrepes).toFixed(2));
                        pnlTablero.find("#dtejido").val((tplaser - sumTejido).toFixed(2));
                        pnlTablero.find("#dmontado").val((tpmontado - sumMontado).toFixed(2));
                        pnlTablero.find("#dadorno").val((tpadorno - sumAdorno).toFixed(2));

                        var dtotal = mtotal - totalTiempos;
                        pnlTablero.find("#dtotal").val((dtotal).toFixed(2));
                    } else {
                        swal('ERROR', 'LA MAQUILA NO TIENE CAPTURA DE TIEMPOS', 'warning').then((value) => {
                            pnlTablero.find('#Maq').focus().select();
                            return;
                        });
                    }
                }).fail(function (x) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });

            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });
        pnlTablero.find("#btnHistory").on("click", function () {
            isValid('pnlValidacion');
            if (valido) {
                HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
                var ano = pnlTablero.find("#Ano").val();
                var sem = pnlTablero.find("#Sem").val();
                var maq = pnlTablero.find("#Maq").val();
                $.get(master_url + 'onImprimirHistorico', {Ano: ano, Sem: sem, Maq: maq}).done(function (data, x, jq) {
                    if (data.length > 0) {
                        $.fancybox.open({
                            src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
                            type: 'iframe',
                            opts: {
                                afterShow: function (instance, current) {
                                    console.info('done!');
                                },
                                iframe: {
                                    // Iframe template
                                    tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                                    preload: true,
                                    // Custom CSS styling for iframe wrapping element
                                    // You can use this to set custom iframe dimensions
                                    css: {
                                        width: "95%",
                                        height: "95%"
                                    },
                                    // Iframe tag attributes
                                    attr: {
                                        scrolling: "auto"
                                    }
                                }
                            }
                        });
                    }
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }

        });
        pnlTablero.find("#btnCierraSem").on("click", function () {
            var ano = pnlTablero.find("#Ano").val();
            var sem = pnlTablero.find("#Sem").val();
            var maq = pnlTablero.find("#Maq").val();
            var mina = pnlTablero.find("#MinutosAprob").val();
            var tecorte = pnlTablero.find("#tecorte").val();
            var pares = pnlTablero.find("#Pares").val();
            if (!ano) {
                swal('ATENCIÓN', "Por favor capture un año", 'warning').then((value) => {
                    pnlTablero.find("#Ano").focus().select();
                    return;
                });
            } else if (!sem) {
                swal('ATENCIÓN', "Por favor capture la semana", 'warning').then((value) => {
                    pnlTablero.find("#Sem").focus().select();
                    return;
                });
            } else if (!maq) {
                swal('ATENCIÓN', "Por favor capture una maquila", 'warning').then((value) => {
                    pnlTablero.find("#Maq").focus().select();
                    return;
                });
            } else if (!mina) {
                swal('ATENCIÓN', "Por favor capture los minutos aprobados para esta semana", 'warning').then((value) => {
                    pnlTablero.find("#Maq").focus().select();
                    return;
                });
            } else if (!tecorte) {
                swal('ATENCIÓN', "Por favor, ejecute el calculo de minutaje", 'warning').then((value) => {
                    return;
                });
            } else {
                //Cierra
                var frm = new FormData(pnlTablero.find("#frmCaptura")[0]);
                frm.append('ano', ano);
                frm.append('sem', sem);
                frm.append('maq', maq);
                frm.append('minutos', mina);
                frm.append('pares', pares);
                $.ajax({
                    url: master_url + 'onCerrarSemana',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data) {
                    console.log(data);
                    onNotifyOld('fa fa-check', 'SEMANA CERRADA CORRECTAMENTE', 'info');
                    init();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
            }

        });
    });

    function ordenaPorFechaEntrega() {
        if (asc3) {
            Registros.order([16, 'asc']).draw();
            asc3 = false;
        } else {
            Registros.order([16, 'desc']).draw();
            asc3 = true;
        }
    }

    function ordenaPorPedido() {
        if (asc) {
            Registros.order([14, 'asc']).draw();
            asc = false;
        } else {
            Registros.order([14, 'desc']).draw();
            asc = true;
        }
    }

    function ordenaPorEstiloColor() {
        if (asc2) {
            Registros.order([15, 'asc']).draw();
            asc2 = false;
        } else {
            Registros.order([15, 'desc']).draw();
            asc2 = true;
        }
    }
    function getRegistrosPorCliente(cte, pedido) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblRegistros')) {
            tblRegistros.DataTable().destroy();
        }
        Registros = tblRegistros.DataTable({
            "dom": 'frtp', buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRegistrosPorCliente',
                "dataSrc": "",
                "data": {Cliente: cte, Pedido: pedido},
                "type": "GET"
            },
            "columns": [
                {"data": "pedido"},
                {"data": "cliente"},
                {"data": "nomcliente"},
                {"data": "fecent"},
                {"data": "ano"},
                {"data": "semana"},
                {"data": "maquila"},
                {"data": "estilo"},
                {"data": "color"},
                {"data": "pares"},
                {"data": "stsavan"},
                {"data": "precio"},
                {"data": "Observacion"},
                {"data": "ObservacionDetalle"},
                {"data": "bpedido"},
                {"data": "besticolor"},
                {"data": "bfechaentrega"}
            ],
            "columnDefs": [
                {
                    "targets": [11],
                    "render": function (data, type, row) {
                        return  $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [14],
                    "visible": false,
                    "searchable": true
                },
                {
                    "targets": [15],
                    "visible": false,
                    "searchable": true
                },
                {
                    "targets": [16],
                    "visible": false,
                    "searchable": true
                }
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            c.addClass('text-strong');
                            break;
                        case 1:
                            c.addClass('text-info text-strong');
                            break;
                    }
                });
            },
            select: true,
            keys: true,
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 450,
            "scrollX": true,
            "scrollY": 400,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc']
            ],
            "initComplete": function (x, y) {

            }
        });
    }
    function getRegistros(ano, sem, maq) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblRegistros')) {
            tblRegistros.DataTable().destroy();
        }
        Registros = tblRegistros.DataTable({
            "dom": 'frtp', buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRegistros',
                "dataSrc": "",
                "data": {Ano: ano, Sem: sem, Maq: maq},
                "type": "GET"
            },
            "columns": [
                {"data": "pedido"},
                {"data": "cliente"},
                {"data": "nomcliente"},
                {"data": "fecent"},
                {"data": "ano"},
                {"data": "semana"},
                {"data": "maquila"},
                {"data": "estilo"},
                {"data": "color"},
                {"data": "pares"},
                {"data": "stsavan"},
                {"data": "precio"},
                {"data": "Observacion"},
                {"data": "ObservacionDetalle"},
                {"data": "bpedido"},
                {"data": "besticolor"},
                {"data": "bfechaentrega"}
            ],
            "columnDefs": [
                {
                    "targets": [11],
                    "render": function (data, type, row) {
                        return  $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [14],
                    "visible": false,
                    "searchable": true
                },
                {
                    "targets": [15],
                    "visible": false,
                    "searchable": true
                },
                {
                    "targets": [16],
                    "visible": false,
                    "searchable": true
                }
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            c.addClass('text-strong');
                            break;
                        case 1:
                            c.addClass('text-info text-strong');
                            break;
                    }
                });
            },
            select: true,
            keys: true,
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 450,
            "scrollX": true,
            "scrollY": 300,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc']
            ],
            "initComplete": function (x, y) {

            }
        });
    }
    function init() {
        pnlTablero.find('#Cliente').selectize({
            openOnFocus: false,
        });
        getRegistros(0, 0, 0);
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });

        pnlTablero.find("#MinutosAprob").val(2850);
        var d = new Date();
        pnlTablero.find("#Ano").val(d.getFullYear()).focus().select();
    }
    function onComprobarMaquilas(v) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA MAQUILA " + $(v).val() + " NO ES VALIDA",
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
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function onComprobarSemanasProduccion(v, ano) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
                var maq = pnlTablero.find("#Maq").val();
                getRegistros(ano, $(v).val(), maq);

                $.getJSON(master_url + 'getPares', {Ano: ano, Sem: $(v).val(), Maq: maq}).done(function (data) {
                    if (data[0].pares !== '0') {
                        pnlTablero.find("#Pares").val(data[0].pares);
                    } else {
                        swal('ERROR', 'NO EXISTEN PEDIDOS PARA CALCULAR MINUTAJE', 'warning').then((value) => {
                            $(v).val('');
                            $(v).focus();
                        });
                    }
                });

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
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function onModificarObservacion(value, IDX) {
        $.post(master_url + 'onModificar', {ID: IDX, Observacion: value}).done(function (data) {
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR AL EDITAR REGISTRO', 'info');
            console.log(x, y, z);
        });
    }
    function onModificarEstilo(value, IDX) {
        $.post(master_url + 'onModificar', {ID: IDX, Estilo: value}).done(function (data) {
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR AL EDITAR REGISTRO', 'info');
            console.log(x, y, z);
        });
    }
    function onModificarColor(value, IDX) {
        $.post(master_url + 'onModificar', {ID: IDX, Color: value}).done(function (data) {
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR AL EDITAR REGISTRO', 'info');
            console.log(x, y, z);
        });
    }
    function onModificarMaquila(value, IDX) {
        $.post(master_url + 'onModificar', {ID: IDX, Maquila: value}).done(function (data) {
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR AL EDITAR REGISTRO', 'info');
            console.log(x, y, z);
        });
    }
    function onModificarSemana(value, IDX) {
        $.post(master_url + 'onModificar', {ID: IDX, Semana: value}).done(function (data) {
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR AL EDITAR REGISTRO', 'info');
            console.log(x, y, z);
        });
    }
    function onModificarFechaEntrega(value, IDX) {
        $.post(master_url + 'onModificar', {ID: IDX, FechaEntrega: value}).done(function (data) {
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR AL EDITAR REGISTRO', 'info');
            console.log(x, y, z);
        });
    }
    function onModificarPedido(value, IDX) {
        $.post(master_url + 'onModificar', {ID: IDX, Clave: value}).done(function (data) {
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR AL EDITAR REGISTRO', 'info');
            console.log(x, y, z);
        });
    }
    function onModificarAno(value, IDX) {
        $.post(master_url + 'onModificar', {ID: IDX, Ano: value}).done(function (data) {
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR AL EDITAR REGISTRO', 'info');
            console.log(x, y, z);
        });
    }

    function validate(event, val) {
        if (((event.which !== 46 || (event.which === 46 && val === '')) || val.indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    }

</script>
<style>
    .text-strong {
        font-weight: bolder;
    }

    table tbody tr {
        font-size: 0.75rem !important;
    }

    .verde {

        background-color: #B9F5A2 !important;
    }

    .azul  {
        background-color: #4BEFF1 !important;
    }

    .rojo {
        background-color: #FFBEAC !important;

    }
    label {
        margin-top: 0.12rem;
        margin-bottom: 0.0rem;
    }

    .form-control-sm,  .form-control {
        padding: 0.15rem 0.5rem;
        margin-top:  0.04rem;
        margin-bottom: 0.04rem;
        font-weight: bold;
        font-size: 0.75rem !important;
    }


    .slim{
        width: 100px !important;
    }

    .fat{
        width: 300px !important;
    }

    .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7,
    .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto,
    .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6,
    .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12,
    .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4,
    .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9,
    .col-md-10, .col-md-11, .col-md-12, .col-md,
    .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3,
    .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7,
    .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11,
    .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4,
    .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9,
    .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto {
        padding-right: 10px;
        padding-left: 10px;
    }

    tr {
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Old versions of Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently
                              supported by Chrome, Opera and Firefox */
    }
</style>
