<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-7 col-md-5 float-left">
                <legend class="float-left">Consulta de Controles Cancelados</legend>
            </div>

            <div class="col-12 col-sm-3 col-md-3 animated bounceInUp" align="right" id="Acciones">
                <input type="text" placeholder="CAPTURA EL CONTROL" class="form-control form-control-sm numbersOnly" maxlength="10" id="Control" name="Control" required="" style="height: 55px; font-size: 36px;">
            </div>
            <div class="col-12 col-sm-3 col-md-4 animated bounceInLeft" align="right" id="Acciones">
                <label for="" > <span class="badge badge-warning" style="font-size: 32px !important; background-color: #cc0000; FONT-STYLE: ITALIC;" id="EstatusProduccion"> -- </span></label>
            </div>
        </div>
        <hr>
        <div class="card-block " id="pnlDatos">
            <form id="frmNuevo">
                <div class="row" >
                    <div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-1">
                        <label for="Pedido" >Pedido</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Pedido" name="Pedido" >
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3">
                        <label for="Folio" >Cliente</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Cliente" name="Cliente" >
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3">
                        <label for="Folio" >Agente</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Agente" name="Agente" >
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                        <label for="FechaPedido" >Fecha Pedido</label>
                        <input type="text" class="form-control form-control-sm" readonly=""  id="FechaPedido" name="FechaPedido" >
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                        <label for="FechaEntrega" >Fecha Entrega</label>
                        <input type="text" class="form-control form-control-sm" readonly=""  id="FechaEntrega" name="FechaEntrega">
                    </div>
                </div>
                <div class="row" >
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3">
                        <label for="Folio" >Linea</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Linea" name="Linea" >
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 col-xl-1">
                        <label for="" >Estilo</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Estilo" name="Estilo" >
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3">
                        <label for="Color" >Color</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Color" name="Color" >
                    </div>
                    <div class="col-12 col-sm-5 col-md-4 col-xl-4">
                        <label for="Observaciones" >Observaciones</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Observaciones" name="Observaciones" >
                    </div>
                </div>


            </form>
        </div>
        <div class="card-block mt-1" id="pnlDatosDetalle" >
            <div class="row" id="ControlesDetalle">

                <!--TALLAS-->
                <div class="col-12">
                    <div class="table-responsive" style="overflow-x:auto; white-space: nowrap;">
                        <label class="font-weight-bold" for="Tallas"></label>
                        <table id="tblTallas" class="Tallas" >
                            <thead></thead>
                            <tbody>
                                <tr id="rTallas">
                                    <td class="font-weight-bold">Tallas</td>
                                    <?php
                                    for ($index = 1; $index < 21; $index++) {
                                        print '<td><input type="text" style="width: 55px;" id="T' . $index . '" name="T' . $index . '" readonly class="form-control form-control-sm "></td>';
                                    }
                                    ?>
                                    <td class="font-weight-bold">Pares</td>
                                </tr>
                                <tr id="rCantidades">
                                    <td class="font-weight-bold">Pares</td>
                                    <?php
                                    for ($index = 1; $index < 21; $index++) {
                                        print '<td><input type="text" style="width: 55px;" id="C' . $index . '" class="form-control form-control-sm " readonly name="C' . $index . '" ></td>';
                                    }
                                    ?>
                                    <td><input type="text" style="width: 55px;" maxlength="4" class="form-control form-control-sm numbersOnly font-weight-bold" disabled=""  id="Pares"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/VisualizaControlesCancelados/';

    var pnlTablero = $("#pnlTablero");
    var tblDetalle = $("#tblDetalle"), Detalle;


    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();

        pnlTablero.find('#Control').keypress(function (e) {
            
            if (e.keyCode === 13 && $(this).val()) {
                onOpenOverlay('Cargando...');
                $.getJSON(master_url + 'getControlCancelado', {
                    Control: $(this).val()
                }).done(function (data) {
                    if (data.length > 0) { //Si el control existe
                        $.each(data[0], function (k, v) {
                            pnlTablero.find("#" + k).val(v);
                        });
                        pnlTablero.find('#EstatusProduccion').text(data[0].EstatusProduccion);
                        pnlTablero.find('#Control').focus().select();
                    } else { //Si el control no existe
                        swal({
                            title: "ATENCIÓN",
                            text: "EL CONTROL NO EXISTE",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            if (action) {
                                pnlTablero.find('#Control').val('').focus();
                            }
                        });
                    }
                    onCloseOverlay();
                });
            }
        });

    });

    function init() {
        pnlTablero.find('#Control').focus();
    }

</script>
<style>
    .text-strong {
        font-weight: bolder;
    }



    tr.group-start:hover td{
        background-color: #e0e0e0 !important;
        color: #000 !important;
    }
    tr.group-end td{
        background-color: #FFF !important;
        color: #000!important;
    }

    td span.badge{
        font-size: 100% !important;
    }

    #tblTallas tbody tr:hover {
        background-color: #FFF !important;
        color: #000 !important;
    }
</style>

