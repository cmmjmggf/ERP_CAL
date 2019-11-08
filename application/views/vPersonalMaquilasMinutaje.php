<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 float-left">
                <legend >Personal por departamentos de maquilas</legend>
            </div>
        </div>
        <hr>
        <form id="frmCaptura">
            <div class="row">
                <div class="col-11">
                    <div class="row">
                        <div class="col-1">
                            <label class="">Maquila</label>
                            <input type="text" class="form-control form-control-sm" maxlength="5" id="Maq" name="Maq"   >
                        </div>
                        <div class="col-3" >
                            <label for="" >-</label>
                            <select id="sMaquila" class="form-control form-control-sm  NotSelectize" >
                                <option value=""></option>
                                <?php
                                foreach ($this->db->select("C.Clave AS CLAVE, C.Nombre AS MAQUILA ", false)
                                        ->from('maquilas AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('MAQUILA', 'ASC')->get()->result() as $k => $v) {
                                    print "<option value='{$v->CLAVE}'>{$v->MAQUILA}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="DatosEmpleados">
                <div class="col-11">
                    <div class="row">
                        <div class="col-1">
                            <label class="">Corte</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="cortep" name="dep10"   >
                        </div>
                        <div class="col-1">
                            <label class="">Rayado</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="rayado" name="dep15"   >
                        </div>
                        <div class="col-1">
                            <label class="">Rebajado</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="rebaja" name="dep20"   >
                        </div>
                        <div class="col-1">
                            <label class="">Foleado</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="folead" name="dep24"   >
                        </div>
                        <div class="col-1">
                            <label class="">Entretelado</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="entrete" name="dep35"   >
                        </div>
                        <div class="col-1">
                            <label class="">Pespunte</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="pespu" name="dep40"   >
                        </div>
                        <div class="col-1">
                            <label class="">Ensuelado</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="ensuel" name="dep45"   >
                        </div>
                        <div class="col-1">
                            <label class="">Prel-Pes</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="prepes" name="dep46"   >
                        </div>
                        <div class="col-1">
                            <label class="">Tejido</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="tejido" name="dep60"   >
                        </div>
                        <div class="col-1">
                            <label class="">Montado</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="montado" name="dep80"   >
                        </div>
                        <div class="col-1">
                            <label class="">Adorno</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="adorno" name="dep90"   >
                        </div>
                        <div class="col-1">
                            <label class="">Total</label>
                            <input type="text" class="form-control form-control-sm numbersOnly azul notSum" readonly=""  id="total"   >
                        </div>
                    </div>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-primary btn-sm mt-4" id="btnAceptar"><i class="fa fa-check"></i> ACEPTAR</button>
                </div>
            </div>
        </form>
        <hr>
        <!--                Tabla-->
        <!--Primer tabla-->
        <div id="Registros" class="datatable-wide">
            <table id="tblRegistros" class="table table-sm display " style="width:100%">
                <thead>
                    <tr>
                        <th>Maq</th>
                        <th>Corte</th>
                        <th>Rayado</th>
                        <th>Rebajado</th>
                        <th>Foleado</th>
                        <th>Entretel</th>
                        <th>Pespunte</th>
                        <th>Ensuelado</th>
                        <th>Prel-Pes</th>
                        <th>Laser</th>
                        <th>Montado</th>
                        <th>Adorno</th>
                        <th>Fecha</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/PersonalMaquilasMinutaje/';
    var pnlTablero = $("#pnlTablero");
    var esNuevo = true;
    var tblRegistros = $('#tblRegistros');
    var Registros;
    $(document).ready(function () {
        init();
        pnlTablero.find('#Maq').change(function () {
            var txtmaq = $(this).val();
            if (txtmaq && txtmaq !== '1') {
                $.getJSON(base_url + 'index.php/PersonalMaquilasMinutaje/onVerificarMaquila', {Maq: txtmaq}).done(function (data) {
                    if (data.length > 0) {
                        $.getJSON(base_url + 'index.php/PersonalMaquilasMinutaje/onVerificarExisteDeptosMaq', {Maq: txtmaq}).done(function (data) {
                            pnlTablero.find("#DatosEmpleados").find('input').val("");
                            if (data.length > 0) {//Existe y traemos los tiempos
                                esNuevo = false;
                            } else {
                                esNuevo = true;
                            }
                            pnlTablero.find("#sMaquila")[0].selectize.addItem(txtmaq, true);
                            pnlTablero.find('#cortep').focus().select();
                        }).fail(function (x) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x.responseText);
                        });
                    } else {
                        swal('ERROR', 'LA MAQUILA CAPTURADA NO EXISTE', 'warning').then((value) => {
                            pnlTablero.find('#sMaquila')[0].selectize.clear(true);
                            pnlTablero.find('#Maq').focus().val('');
                        });
                    }
                }).fail(function (x) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            } else {
                swal('ERROR', 'MAQUILA INVÁLIDA', 'warning').then((value) => {
                    pnlTablero.find('#sMaquila')[0].selectize.clear(true);
                    pnlTablero.find('#Maq').focus().val('');
                });
            }

        });
        pnlTablero.find('#sMaquila').change(function () {
            if ($(this).val()) {
                var maq = $(this).val();
                pnlTablero.find('#Maq').val(maq);
                pnlTablero.find('#cortep').focus().select();
            }
        });
        pnlTablero.find("#DatosEmpleados").find('input').blur(function () {
            suma();
        });
        pnlTablero.find("#btnAceptar").click(function () {
            var frm = new FormData(pnlTablero.find("#frmCaptura")[0]);
            var funcion = esNuevo === true ? 'onAgregar' : 'onModificar';
            $.ajax({
                url: master_url + funcion,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data) {
                onNotifyOld('fa fa-check', 'REGISTRO GUARDADO', 'info');
                Registros.ajax.reload();
                pnlTablero.find("input").val("");
                $.each(pnlTablero.find("select"), function (k, v) {
                    pnlTablero.find("select")[k].selectize.clear(true);
                });
                pnlTablero.find('#Maq').focus();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            });
        });
    });

    function suma() {
        var total = 0;
        pnlTablero.find("#DatosEmpleados").find('input:not(.notSum)').each(function () {
            total = total + parseFloat(($(this).val() === '') ? 0 : $(this).val());
        });
        pnlTablero.find('#total').val(parseFloat(total).toFixed(2));
    }

    function init() {
        handleEnterDiv(pnlTablero);
        pnlTablero.find('#sMaquila').selectize();
        getRegistros();
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find('#Maq').focus();
    }

    function getRegistros() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblRegistros')) {
            tblRegistros.DataTable().destroy();
        }
        Registros = tblRegistros.DataTable({
            "dom": 'rt', buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRegistros',
                "dataSrc": "",
                "type": "GET"
            },
            "columns": [
                {"data": "numcia"},
                {"data": "dep10"},
                {"data": "dep15"},
                {"data": "dep20"},
                {"data": "dep24"},
                {"data": "dep35"},
                {"data": "dep40"},
                {"data": "dep45"},
                {"data": "dep46"},
                {"data": "dep60"},
                {"data": "dep80"},
                {"data": "dep90"},
                {"data": "fecha"},
                {"data": "eliminar"}
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            c.addClass('text-info text-strong');
                            break;
                        case 13:
                            /*UNIDAD*/
                            c.addClass('text-danger text-success');
                            break;
                    }
                });
            },
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


    function onEliminar(IDX) {
        swal({
            title: "¿Deseas eliminar el registro? ", text: "*El registro se eliminará de forma permanente*", icon: "warning", buttons: ["Cancelar", "Aceptar"]
        }).then((willDelete) => {
            if (willDelete) {
                $.post(master_url + 'onEliminar', {Maq: IDX}).done(function () {
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
                    pnlTablero.find("#DatosEmpleados").find('input').val("");
                    pnlTablero.find('#Maq').val('').focus();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    Registros.ajax.reload();
                });
            }
        });
    }
</script>
<style>
    .text-strong {
        font-weight: bolder;
    }

    table tbody tr {
        font-size: 0.8rem !important;
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
</style>
