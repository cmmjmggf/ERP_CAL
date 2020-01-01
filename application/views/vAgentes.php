<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Agentes</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-primary" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar"><span class="fa fa-plus"></span><br></button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Agentes" class="table-responsive">
                <table id="tblAgentes" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Clave</th>
                            <th>Descripcion</th>
                            <th>Direcci&oacute;n</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="d-none animated fadeIn text-dark" id="pnlDatos">
    <form id="frmNuevo">
        <fieldset>
            <!--            PRIMER CONTENEDOR-->
            <div class="card  mx-3 mt-3 ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4 float-left">
                            <legend >Agentes</legend>
                        </div>
                        <div class="col-12 col-sm-6 col-md-8" align="right">
                            <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                                <span class="fa fa-arrow-left" ></span> REGRESAR
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="d-none">
                            <input type="text" id="ID" name="ID" class="form-control form-control-sm" >
                        </div>
                        <div class="col-12 col-sm-4 col-md-3 col-lg-2 col-xl-1">
                            <label for="Clave" >Clave*</label>
                            <input type="text" class="form-control form-control-sm numbersOnly disabledForms" id="Clave" name="Clave" required placeholder="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2">
                            <label for="Nombre" >Nombre</label>
                            <input type="text" class="form-control form-control-sm" id="Nombre" name="Nombre" >
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2">
                            <label for="Descripcion" >Descripcion</label>
                            <input type="text" class="form-control form-control-sm" id="Descripcion" name="Descripcion" >
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2">
                            <label for="Direccion" >Direcci&oacute;n</label>
                            <input type="text" class="form-control form-control-sm" id="Direccion" name="Direccion" >
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2">
                            <label for="Tel" >Tel.</label>
                            <input type="text" class="form-control form-control-sm" id="Tel" name="Tel" >
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2">
                            <label for="Cel" >Cel.</label>
                            <input type="text" class="form-control form-control-sm" id="Cel" name="Cel" >
                        </div>
                    </div>
                </div>
            </div>
            <!--            SEGUNDO CONTENEDOR-->
            <div class="card mx-3 mt-3 ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-3">
                            <label class="font-weight-bold">Enero </label>
                            <div class="row">
                                <div class="col-4">
                                    <label>Cuotas </label>
                                    <input type="text" class="form-control form-control-sm" id="EneroCuota" name="EneroCuota" placeholder="">
                                </div>
                                <div class="col-4">
                                    <label>Pedidos </label>
                                    <input type="text" class="form-control form-control-sm" id="EneroPedido" placeholder="" readonly="" disabled>
                                </div>
                                <div class="col-4">
                                    <label>% </label>
                                    <input type="text" class="form-control form-control-sm" id="EneroPorcentaje" placeholder="" readonly="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-3">
                            <label class="font-weight-bold">Febrero </label>
                            <div class="row">
                                <div class="col-4">
                                    <label>Cuotas </label>
                                    <input type="text" class="form-control form-control-sm" id="FebreroCuota" name="FebreroCuota" placeholder="">
                                </div>
                                <div class="col-4">
                                    <label>Pedidos </label>
                                    <input type="text" class="form-control form-control-sm" id="FebreroPedido" placeholder="" readonly="" disabled>
                                </div>
                                <div class="col-4">
                                    <label>% </label>
                                    <input type="text" class="form-control form-control-sm" id="FebreroPorcentaje" placeholder="" readonly="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-3">
                            <label class="font-weight-bold">Marzo </label>
                            <div class="row">
                                <div class="col-4">
                                    <label>Cuotas </label>
                                    <input type="text" class="form-control form-control-sm" id="MarzoCuota" name="MarzoCuota" placeholder="">
                                </div>
                                <div class="col-4">
                                    <label>Pedidos </label>
                                    <input type="text" class="form-control form-control-sm" id="MarzoPedido" placeholder="" readonly="" disabled>
                                </div>
                                <div class="col-4">
                                    <label>% </label>
                                    <input type="text" class="form-control form-control-sm" id="MarzoPorcentaje" placeholder="" readonly="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-3">
                            <label class="font-weight-bold">Abril </label>
                            <div class="row">
                                <div class="col-4">
                                    <label>Cuotas </label>
                                    <input type="text" class="form-control form-control-sm" id="AbrilCuota" name="AbrilCuota" placeholder="">
                                </div>
                                <div class="col-4">
                                    <label>Pedidos </label>
                                    <input type="text" class="form-control form-control-sm" id="AbrilPedido" placeholder="" readonly="" disabled>
                                </div>
                                <div class="col-4">
                                    <label>% </label>
                                    <input type="text" class="form-control form-control-sm" id="AbrilPorcentaje" placeholder="" readonly="" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-3">
                            <label class="font-weight-bold">Mayo </label>
                            <div class="row">
                                <div class="col-4">
                                    <label>Cuotas </label>
                                    <input type="text" class="form-control form-control-sm" id="MayoCuota" name="MayoCuota" placeholder="">
                                </div>
                                <div class="col-4">
                                    <label>Pedidos </label>
                                    <input type="text" class="form-control form-control-sm" id="MayoPedido" placeholder="" readonly="" disabled>
                                </div>
                                <div class="col-4">
                                    <label>% </label>
                                    <input type="text" class="form-control form-control-sm" id="MayoPorcentaje" placeholder="" readonly="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-3">
                            <label class="font-weight-bold">Junio </label>
                            <div class="row">
                                <div class="col-4">
                                    <label>Cuotas </label>
                                    <input type="text" class="form-control form-control-sm" id="JunioCuota" name="JunioCuota" placeholder="">
                                </div>
                                <div class="col-4">
                                    <label>Pedidos </label>
                                    <input type="text" class="form-control form-control-sm" id="JunioPedido" placeholder="" readonly="" disabled>
                                </div>
                                <div class="col-4">
                                    <label>% </label>
                                    <input type="text" class="form-control form-control-sm" id="JunioPorcentaje" placeholder="" readonly="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-3">
                            <label class="font-weight-bold">Julio </label>
                            <div class="row">
                                <div class="col-4">
                                    <label>Cuotas </label>
                                    <input type="text" class="form-control form-control-sm" id="JulioCuota" name="JulioCuota" placeholder="">
                                </div>
                                <div class="col-4">
                                    <label>Pedidos </label>
                                    <input type="text" class="form-control form-control-sm" id="JulioPedido" placeholder="" readonly="" disabled>
                                </div>
                                <div class="col-4">
                                    <label>% </label>
                                    <input type="text" class="form-control form-control-sm" id="JulioPorcentaje" placeholder="" readonly="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-3">
                            <label class="font-weight-bold">Agosto </label>
                            <div class="row">
                                <div class="col-4">
                                    <label>Cuotas </label>
                                    <input type="text" class="form-control form-control-sm" id="AgostoCuota" name="AgostoCuota" placeholder="">
                                </div>
                                <div class="col-4">
                                    <label>Pedidos </label>
                                    <input type="text" class="form-control form-control-sm" id="AgostoPedido" placeholder="" readonly="" disabled>
                                </div>
                                <div class="col-4">
                                    <label>% </label>
                                    <input type="text" class="form-control form-control-sm" id="AgostoPorcentaje" placeholder="" readonly="" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-3">
                            <label class="font-weight-bold">Septiembre </label>
                            <div class="row">
                                <div class="col-4">
                                    <label>Cuotas </label>
                                    <input type="text" class="form-control form-control-sm" id="SeptiembreCuota" name="SeptiembreCuota" placeholder="">
                                </div>
                                <div class="col-4">
                                    <label>Pedidos </label>
                                    <input type="text" class="form-control form-control-sm" id="SeptiembrePedido" placeholder="" readonly="" disabled>
                                </div>
                                <div class="col-4">
                                    <label>% </label>
                                    <input type="text" class="form-control form-control-sm" id="SeptiembrePorcentaje" placeholder="" readonly="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-3">
                            <label class="font-weight-bold">Octubre </label>
                            <div class="row">
                                <div class="col-4">
                                    <label>Cuotas </label>
                                    <input type="text" class="form-control form-control-sm" id="OctubreCuota" name="OctubreCuota" placeholder="">
                                </div>
                                <div class="col-4">
                                    <label>Pedidos </label>
                                    <input type="text" class="form-control form-control-sm" id="OctubrePedido" placeholder="" readonly="" disabled>
                                </div>
                                <div class="col-4">
                                    <label>% </label>
                                    <input type="text" class="form-control form-control-sm" id="OctubrePorcentaje" placeholder="" readonly="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-3">
                            <label class="font-weight-bold">Noviembre </label>
                            <div class="row">
                                <div class="col-4">
                                    <label>Cuotas </label>
                                    <input type="text" class="form-control form-control-sm" id="NoviembreCuota" name="NoviembreCuota" placeholder="">
                                </div>
                                <div class="col-4">
                                    <label>Pedidos </label>
                                    <input type="text" class="form-control form-control-sm" id="NoviembrePedido" placeholder="" readonly="" disabled>
                                </div>
                                <div class="col-4">
                                    <label>% </label>
                                    <input type="text" class="form-control form-control-sm" id="NoviembrePorcentaje" placeholder=""  readonly="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-3">
                            <label class="font-weight-bold">Diciembre </label>
                            <div class="row">
                                <div class="col-4">
                                    <label>Cuotas </label>
                                    <input type="text" class="form-control form-control-sm" id="DiciembreCuota" name="DiciembreCuota" placeholder="">
                                </div>
                                <div class="col-4">
                                    <label>Pedidos </label>
                                    <input type="text" class="form-control form-control-sm" id="DiciembrePedido" placeholder="" readonly="" disabled>
                                </div>
                                <div class="col-4">
                                    <label>% </label>
                                    <input type="text" class="form-control form-control-sm" id="DiciembrePorcentaje" placeholder="" readonly="" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-6 col-md-6 ">
                            <h6 class="text-danger">Los campos con * son obligatorios</h6>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<div class="card mx-3 mt-3 d-none animated fadeIn" id="pnlDatosDetalle">
    <div class="card-body text-dark">

        <div class="row">
            <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <label for="Dias" class="font-weight-bold">Dias*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="Dias" name="Dias" required placeholder="0">
            </div>
            <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <label for="A" class="font-weight-bold">A*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="A" name="A" required placeholder="">
            </div>
            <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <label for="Porcentaje" class="font-weight-bold">%*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="Porcentaje" name="Porcentaje" required placeholder="">
            </div>
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 my-2 d-sm-block pt-3" align="center">
                <button type="button" id="btnAgregarDetalle" class="btn btn-primary btn-sm d-sm-block "><span class="fa fa-plus"></span></button>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-2 table-responsive">
                <table id="tblAgentesDetalle" class="table table-sm display" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">ID</th><!--0-->
                            <th scope="col">Agente</th><!--1-->
                            <th scope="col">Dias</th><!--2-->
                            <th scope="col">A</th><!--3-->
                            <th scope="col">%</th><!--4-->
                            <th scope="col">Estatus</th><!--5-->
                            <th scope="col">*</th><!--6-->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <button type="button" class="btn btn-info btn-lg btn-float" id="btnGuardar" data-toggle="tooltip" data-placement="left" title="Guardar">
            <i class="fa fa-save"></i>
        </button>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/Agentes/';
    var tblAgentes = $('#tblAgentes');
    var Agentes;
    var btnNuevo = $("#btnNuevo"), btnCancelar = $("#btnCancelar"), btnEliminar = $("#btnEliminar"), btnGuardar = $("#btnGuardar"), btnIgualaPrecios = $("#btnIgualaPrecios");
    var pnlTablero = $("#pnlTablero"), pnlDatos = $("#pnlDatos"), pnlDatosDetalle = $("#pnlDatosDetalle");
    var AgentesDetalle, tblAgentesDetalle = $("#tblAgentesDetalle");
    var nuevo = false, precio_actual = 0;

    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();
        handleEnter();
        /*FUNCIONES X BOTON*/
        pnlDatosDetalle.find("#btnAgregarDetalle").click(function () {
            AgentesDetalle.row.add([0, 0, pnlDatosDetalle.find("#Dias").val(),
                pnlDatosDetalle.find("#A").val(), pnlDatosDetalle.find("#Porcentaje").val(), 'N',
                '<button type="button" class="btn btn-danger" onclick="onEliminarDetalle(this)"><span class="fa fa-trash"></span></button>']).draw(false);
            pnlDatosDetalle.find("#Dias, #A, #Porcentaje").val('');
            pnlDatosDetalle.find("#Dias").focus();
        });

        btnGuardar.click(function () {
            isValid('pnlDatos');
            if (valido) {
                var frm = new FormData(pnlDatos.find("#frmNuevo")[0]);
                if (!nuevo) {
                    var rangos = [];
                    $.each(tblAgentesDetalle.find("tbody tr"), function (k, v) {
                        var r = AgentesDetalle.row($(this)).data();
                        if (r[5] === 'N') {
                            rangos.push({
                                Dias: r[2],
                                A: r[3],
                                Porcentaje: r[4]
                            });
                        }
                    });
                    frm.append('Rangos', JSON.stringify(rangos));
                    $.ajax({
                        url: '<?php print base_url('Agentes/onModificar'); ?>',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data, x, jq) {
                        swal('ATENCIÓN', 'SE HAN GUARDADO LOS CAMBIOS', 'info');
                        nuevo = false;
                        Agentes.clear().draw();
                        AgentesDetalle.clear().draw();
                        Agentes.ajax.reload();
                        pnlDatos.addClass("d-none");
                        pnlDatosDetalle.addClass('d-none');
                        pnlTablero.removeClass("d-none");
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    }).always(function () {
                        HoldOn.close();
                    });
                } else {
                    if (AgentesDetalle.data().count()) {
                        var rangos = [];
                        $.each(tblAgentesDetalle.find("tbody tr"), function (k, v) {
                            var r = AgentesDetalle.row($(this)).data();
                            rangos.push({
                                Dias: r[2],
                                A: r[3],
                                Porcentaje: r[4]
                            });
                        });
                        frm.append('Rangos', JSON.stringify(rangos));
                    }
                    $.ajax({
                        url: '<?php print base_url('Agentes/onAgregar'); ?>',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data, x, jq) {
                        console.log(data);
                        pnlDatos.find("[name='ID']").val(data);
                        nuevo = false;
                        Agentes.ajax.reload();
                        pnlDatos.addClass("d-none");
                        pnlDatosDetalle.addClass('d-none');
                        pnlTablero.removeClass("d-none");
                        btnIgualaPrecios.addClass("d-none");
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    }).always(function () {
                        HoldOn.close();
                    });
                }
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });

        btnEliminar.click(function () {
            swal({
                title: "¿Estas seguro?",
                text: "Nota: No se eliminara ninguna Agente que tenga alguna relacion con otro dato dentro del sistema",
                icon: "warning",
                buttons: {
                    cancelar: {
                        text: "Cancelar",
                        value: "cancelar"
                    },
                    eliminar: {
                        text: "Finalizar",
                        value: "eliminar"
                    }
                }
            }).then((value) => {
                switch (value) {
                    case "eliminar":
                        $.post('<?php print base_url('Agentes/onEliminar'); ?>', {ID: temp}).done(function () {
                            swal('ATENCIÓN', 'SE HA ELIMINADO EL REGISTRO', 'success');
                            Agentes.clear().draw();
                            pnlDatos.addClass("d-none");
                            pnlDatosDetalle.addClass('d-none');
                            pnlTablero.removeClass("d-none");
                            Agentes.ajax.reload();
                        }).fail(function (x, y, z) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x.responseText);
                        });
                        break;
                    case "cancelar":
                        swal.close();
                        break;
                }
            });
        });

        btnNuevo.click(function () {
            AgentesDetalle.clear().draw();
            pnlDatosDetalle.removeClass("d-none");
            nuevo = true;
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
            pnlDatos.find("input,textarea").val("");
            pnlTablero.addClass("d-none");
            pnlDatos.removeClass("d-none");
            btnEliminar.addClass("d-none");
            pnlDatos.find('#Nombre').focus();
            $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
            getID();
        });

        btnCancelar.click(function () {
            AgentesDetalle.clear().draw();
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass("d-none");
            pnlDatosDetalle.addClass("d-none");
            temp = 0;
        });
    });

    //FUNCIONES INICIALES

    function init() {
        getRecords();
        /*INICIALIZAR DETALLE*/
        AgentesDetalle = tblAgentesDetalle.DataTable({
            "dom": 'rti',
            buttons: buttons,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 25,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'desc']/*ID*/
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [1],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [5],
                    "visible": false,
                    "searchable": false
                }
            ],
            createdRow: function (row, data, dataIndex, cells) {
                var event;
                if (isMobile) {
                    $(this).find("td:eq(1)").touch();
                    event = 'tap';
                } else {
                    event = 'dblclick';
                }
                if (!nuevo) {
                    $(row).find("td").eq(1).on(event, function () {
                        var r = AgentesDetalle.row(row).data();
                        var input = '<input type="text" class="form-control form-control-sm numbersOnly" maxlength="10" name="Precio" autofocus>';
                        var exist = $(this).find("#Precio").val();
                        var celda = $(this);
                        if (exist === undefined && celda.text() !== '') {
                            var vActual = celda.text();
                            celda.html(input);
                            var input_precio = celda.find("[name='Precio']");
                            input_precio.val(getNumberFloat(vActual));
                            precio_actual = vActual;
                            var padre = celda.parent();
                            input_precio.focus().select();
                            input_precio.focusout(function () {
                                onModificarPrecioMaquila(r, padre, celda, this);
                            });
                            input_precio.change(function () {
                                onModificarPrecioMaquila(r, padre, celda, this);
                            });
                            input_precio.keyup(function (e) {
                                if (e.keyCode === 13) {
                                    onModificarPrecioMaquila(r, padre, celda, this);
                                }
                            });
                        }
                    });
                }
            }
        });
    }

    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblAgentes')) {
            tblAgentes.DataTable().destroy();
        }
        Agentes = tblAgentes.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('Agentes/getRecords'); ?>',
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"}, {"data": "Clave"}, {"data": "Descripcion"}, {"data": "Direccion"}
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
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'desc']/*ID*/
            ],
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });
        $('#tblAgentes_filter input[type=search]').focus();
        tblAgentes.find('tbody').on('click', 'tr', function () {
            AgentesDetalle.clear().draw();
            HoldOn.open({
                theme: 'sk-cube',
                message: 'CARGANDO...'
            });
            nuevo = false;
            tblAgentes.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Agentes.row(this).data();
            temp = parseInt(dtm.ID);
            $.getJSON('<?php print base_url('Agentes/getAgenteByID'); ?>', {ID: temp}).done(function (data) {
                pnlDatos.find("input").val("");
                $.each(pnlDatos.find("select"), function (k, v) {
                    pnlDatos.find("select")[k].selectize.clear(true);
                });
                $.each(data[0], function (k, v) {
                    pnlDatos.find("[name='" + k + "']").val(v);
                    if (pnlDatos.find("[name='" + k + "']").is('select')) {
                        pnlDatos.find("[name='" + k + "']")[0].selectize.addItem(v, true);
                    }
                });
                btnIgualaPrecios.removeClass("d-none");
                pnlTablero.addClass("d-none");
                pnlDatos.removeClass('d-none');
                pnlDatosDetalle.removeClass('d-none');
                pnlDatos.find('#Nombre').focus().select();
                /*DETALLE*/
                $.getJSON('<?php print base_url('Agentes/getDetalleByID'); ?>', {ID: dtm.Clave}).done(function (data) {
                    if (data.length > 0) {
                        $.each(data, function (k, v) {
                            AgentesDetalle.row.add([v.ID, v.Agente, v.Dias, v.A, v.Porcentaje, 'A', '<button type="button" class="btn btn-danger" onclick="onEliminarDetalle(this)"><span class="fa fa-trash"></span></button>']).draw(false);
                        });
                    }
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                }).always(function () {
                    $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
                });
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            }).always(function () {
                HoldOn.close();
            });
        });

    }

    function onEliminarDetalle(e) {
        var r = AgentesDetalle.row($(e).parents('tr')).data();
        switch (r[5]) {
            case "N":
                AgentesDetalle.row($(e).parents('tr')).remove().draw();
                onNotifyOldPCF('<span class="fa fa-check"></span>',
                        'SE HA ELIMINADO EL REGISTRO DE LA TABLA',
                        'success', {from: "top", align: "center"}, function () {
                });
                console.log('Eliminado de la tabla');
                break;
            case "A":
                console.log(r);
                $.post('<?php print base_url('Agentes/onEliminarDetalle'); ?>', {ID: r[0]}).done(function () {
                    AgentesDetalle.row($(e).parents('tr')).remove().draw();
                    onNotifyOldPCF('<span class="fa fa-check"></span>',
                            'SE HA ELIMINADO EL REGISTRO COMPLETAMENTE',
                            'success', {from: "top", align: "center"}, function () {
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
                console.log('Eliminado de la bd');
                break;
        }
    }

    function getID() {
        $.getJSON('<?php print base_url('Agentes/getID'); ?>').done(function (data, x, jq) {
            if (data.length > 0) {
                var ID = $.isNumeric(data[0].CLAVE) ? parseInt(data[0].CLAVE) + 1 : 1;
                pnlDatos.find("#Clave").val(ID);
            } else {
                pnlDatos.find("#Clave").val('1');
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }
</script>