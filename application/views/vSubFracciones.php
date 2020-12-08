<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Desgloce de Fracciones</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-primary" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar"><span class="fa fa-plus"></span><br></button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Fracciones" class="table-responsive">
                <table id="tblFracciones" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>No. Fracción</th>
                            <th>Nombre Fracción</th>
                            <th class="d-none">Departamento</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card m-3 d-none animated fadeIn" id="pnlDatos">
    <div class="card-body text-dark">
        <form id="frmNuevo">
            <fieldset>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 float-left">
                        <legend >Sub Fracciones de la Fracción</legend>
                    </div>
                    <div class="col-12 col-sm-6 col-md-8" align="right">
                        <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                            <span class="fa fa-arrow-left" ></span> REGRESAR
                        </button>

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <label>Fracción</label>
                        <select id="Fraccion" name="Fraccion" class="form-control form-control-sm required" >
                            <option></option>
                            <?php
                            //YA CONTIENE LOS BLOQUEOS DE VENTA
                            $clientes = $this->db->query("SELECT C.Clave AS CLAVE, C.Descripcion AS FRACCION FROM fracciones AS C ORDER BY ABS(CLAVE) ASC;")->result();
                            foreach ($clientes as $k => $v) {
                                print "<option value=\"{$v->CLAVE}\">{$v->CLAVE} - {$v->FRACCION}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="w-100"></div>
                    <div class="d-none">
                        <input type="text"  name="ID" class="form-control form-control-sm" >
                    </div>
                    <div class="col-12 col-sm-4 col-md-2 col-lg-2 col-xl-1">
                        <label for="Clave" >Clave</label>
                        <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="Clave" name="Clave" required>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                        <label for="Descripcion" >Descripción</label>
                        <input type="text" id="Descripcion" name="Descripcion" class="form-control form-control-sm" placeholder="" required>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                        <label>Puesto</label>
                        <select id="Puesto" name="Puesto" class="form-control form-control-sm required" >
                            <option></option>
                            <?php
                            //YA CONTIENE LOS BLOQUEOS DE VENTA
                            $clientes = $this->db->query("SELECT C.Clave AS CLAVE, C.Descripcion AS PUESTO FROM puestos AS C ORDER BY ABS(CLAVE) ASC;")->result();
                            foreach ($clientes as $k => $v) {
                                print "<option value=\"{$v->CLAVE}\">{$v->CLAVE} - {$v->PUESTO}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-2 col-lg-2 col-xl-1 mt-4">
                        <button type="button" class="btn btn-info btn-sm" id="btnGuardar" >
                            <i class="fa fa-save"></i> AGREGAR
                        </button>
                    </div>

                </div>
                <!--DETALLE-->
                <hr class="mt-2 mb-2">
                <div class="row ">
                    <div class="col-12">
                        <label>Desgloce </label>
                        <div class="card-block mt-2">
                            <div class="table-responsive" id="Detalle">
                                <table id="tblDetalle" class="table table-sm  " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="d-none">ID</th>
                                            <th>Subfraccion</th>
                                            <th>Fracción</th>
                                            <th>Puesto</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN DETALLE-->
            </fieldset>
        </form>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/Subfracciones/';
    var tblFracciones = $('#tblFracciones');
    var Fracciones;
    var btnNuevo = $("#btnNuevo"), btnCancelar = $("#btnCancelar"), btnGuardar = $("#btnGuardar");
    var pnlTablero = $("#pnlTablero"), pnlDatos = $("#pnlDatos");
    var nuevo = false;

    /*Detalle*/
    var tblDetalle = $('#tblDetalle');
    var Detalle;

    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();

        pnlTablero.find("#tblFracciones_filter").find('input[type="search"]').on('keydown', function (e) {
            if ($(this).val() && e.keyCode === 13) {
                getSubfraccionByID($(this).val());
            }
        });

        pnlDatos.find("#Fraccion").change(function () {
            if ($(this).val()) {
                Detalle.ajax.reload();
                pnlDatos.find("#Clave").focus();
            }
        });

        pnlDatos.find('#Clave').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtclave = $(this).val();
                if (txtclave) {
                    pnlDatos.find('#Descripcion').focus();
                }
            }
        });

        pnlDatos.find('#Descripcion').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtclave = $(this).val();
                if (txtclave) {
                    pnlDatos.find('#Puesto')[0].selectize.focus();
                }
            }
        });

        pnlDatos.find("#Puesto").change(function () {
            if ($(this).val()) {
                btnGuardar.focus();
            }
        });

        /*FUNCIONES X BOTON*/
        btnGuardar.click(function () {
            isValid('pnlDatos');
            if (valido) {
                var frm = new FormData(pnlDatos.find("#frmNuevo")[0]);
                $.ajax({
                    url: master_url + 'onAgregar',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    Detalle.ajax.reload();
                    pnlDatos.find("#Descripcion").val('');
                    pnlDatos.find("#Puesto")[0].selectize.clear(true);
                    pnlDatos.find("#Clave").val('').focus();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });

        btnNuevo.click(function () {
            nuevo = true;
            pnlDatos.find("input").val("");
            pnlTablero.addClass("d-none");
            pnlDatos.removeClass("d-none");
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
            pnlDatos.find("#Fraccion")[0].selectize.focus();
            Detalle.ajax.reload();
        });

        btnCancelar.click(function () {
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass("d-none");
        });
    });

    function init() {
        getRecords();
        getDesgloce();
    }

    function getSubfraccionByID(ID) {
        $.getJSON(master_url + 'getSubFraccionByID', {ID: ID}).done(function (data) {
            console.log(data);
            if (data.length > 0) {
                pnlDatos.find("input").val("");
                $.each(pnlDatos.find("select"), function (k, v) {
                    pnlDatos.find("select")[k].selectize.clear(true);
                });
                pnlDatos.find("#Fraccion")[0].selectize.addItem(data[0].Fraccion, true);
                pnlTablero.addClass("d-none");
                pnlDatos.removeClass('d-none');
                Detalle.ajax.reload();
            } else {
                swal('ERROR', 'ESTA FRACCIÓN, AÚN NO TIENE SUBFRACCIONES', 'info');
            }

        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblFracciones')) {
            tblFracciones.DataTable().destroy();
        }
        Fracciones = tblFracciones.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"}, {"data": "Clave"}, {"data": "Descripcion"}, {"data": "Departamento"}, {"data": "Depto"}
            ],
            "columnDefs": [
                {
                    "targets": [0, 3, 4],
                    "visible": false,
                    "searchable": false
                }
            ],
            rowGroup: {
                startRender: function (rows, group) {
                    return $('<tr>').append('<td colspan="4" align="center">******' + group + '******</td></tr>');
                },
                dataSrc: "Depto"
            },
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "scrollX": true,
            "scrollY": 250,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [3, 'asc']/*ID*/
            ]
        });

        $('#tblFracciones_filter input[type=search]').focus();

        tblFracciones.find('tbody').on('click', 'tr', function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'CARGANDO...'
            });
            nuevo = false;
            tblFracciones.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Fracciones.row(this).data();
            temp = (dtm.Clave);
            getSubfraccionByID(temp);
        });
        HoldOn.close();
    }

    function getDesgloce() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDetalle')) {
            tblDetalle.DataTable().destroy();
        }
        Detalle = tblDetalle.DataTable({
            "dom": 'rtp',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getDesgloce',
                "dataSrc": "",
                "type": "POST",
                "data": function (d) {
                    d.Fraccion = pnlDatos.find("#Fraccion").val() ? pnlDatos.find("#Fraccion").val() : '';
                }
            },
            "columns": [
                {"data": "ID"},
                {"data": "Subfraccion"},
                {"data": "Fraccion"},
                {"data": "Puesto"},
                {"data": "Eliminar"}
            ],
            "columnDefs": [
                {
                    "targets": [0, 2],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "scrollX": true,
            "scrollY": 400,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [1, 'asc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 2:
                            /*FECHA ENTREGA*/
                            c.addClass('text-danger');
                            break;
                    }
                });
            }
        });
    }

    function onEliminar(IDX) {
        swal({
            title: "¿Deseas eliminar el registro? ", text: "*El registro se eliminará de forma permanente*", icon: "warning", buttons: ["Cancelar", "Aceptar"]
        }).then((willDelete) => {
            if (willDelete) {
                $.post(master_url + 'onEliminar', {ID: IDX}).done(function () {
                    $.notify({
                        // options
                        message: 'SE HA ELIMINADO EL REGISTRO'
                    }, {
                        // settings
                        type: 'success',
                        delay: 500,
                        animate: {
                            enter: 'animated flipInX',
                            exit: 'animated flipOutX'
                        },
                        placement: {
                            from: "top",
                            align: "right"
                        }
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    Detalle.ajax.reload();
                });
            }
        });
    }

</script>