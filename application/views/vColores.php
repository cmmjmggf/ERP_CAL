<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <h3> <span class="fa fa-brush fa-lg"></span> Color</h3>
            </div>
            <div class="col-sm-6 float-right" align="right">

                <a class="btn btn-info btn-sm"  href="#" data-toggle="modal" data-target="#mdlSeleccionaEstiloColorParaEfectoVenta">
                    <i class="fa fa-check-square"></i> Clasifica Estilo p' Precio-Vta
                </a>
                <button type="button" class="btn btn-primary" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar"><span class="fa fa-plus"></span><br></button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Colores" class="table-responsive">
                <table id="tblColores" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Estilo</th>
                            <th>Clave</th>
                            <th>Color</th>

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
                        <h3> <span class="fa fa-brush fa-lg"></span> Color</h3>
                    </div>
                    <div class="col-12 col-sm-6 col-md-8" align="right">
                        <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                            <span class="fa fa-arrow-left" ></span> REGRESAR
                        </button>
                        <button type="button" class="btn btn-danger btn-sm d-none" id="btnEliminar">
                            <span class="fa fa-trash fa-1x"></span> ELIMINAR
                        </button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="d-none">
                                    <input type="text"  name="ID" class="form-control form-control-sm" >
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                <label>Estilo</label>
                                <select id="Estilo" name="Estilo" class="form-control form-control-sm" >
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                <label for="Clave" >Clave*</label>
                                <input type="text" class="form-control form-control-sm numbersOnly disabledForms" id="Clave" name="Clave" required placeholder="Clave del color">
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                <label for="" >Descripción</label>
                                <textarea id="Descripcion" name="Descripcion" class="form-control" rows="2" cols="4"></textarea>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                <label>Pieles</label>
                                <!--Articulos Grupo 1-->
                                <select id="Pieles" name="Pieles" class="form-control form-control-sm" >
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <label for="" >Obs.para la orden de producción</label>
                                <textarea id="ObservacionesOrdenProduccion" name="ObservacionesOrdenProduccion" maxlength="100" class="form-control" rows="2" cols="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center justify-content-center">
                        <div class="row">
                            <div class="col-12" id="FotoContenedor">
                                <a href="<?PHP print base_url('img/camera.png'); ?>" data-fancybox="images" >
                                    <img src="<?PHP print base_url('img/camera.png'); ?>" id="FotoEstiloColor" class="img-fluid rounded" style="width: 262px; height: 262px;">
                                </a>
                            </div>
                            <div class="col-12">
                                <input type="file" id="ArchivoFotoEstiloColor" class="d-none">
                                <button type="button" id="btnFotoEstiloColor" class="btn btn-info">
                                    <span class="fa fa-image"></span> CAMBIAR FOTO
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <h6 class="text-danger">*Nota.Colores ya dados de alta sera imposible modificarlos.</h6>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <h6 class="text-danger">*Nota.Para actualizar costo de mano de obra y materiales si desea un solo estilo tecle el numero .</h6>
                    </div>
                    
                    <div class="col-12 col-sm-6 col-md-12 col-lg-12 col-xl-12 d-none">
                        <legend>Datos para etiqueta de trazabilidad.</legend>
                        <hr>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-none">
                        <label>Tamaño y color</label>
                        <select id="trEtiqueta" name="trEtiqueta" class="form-control form-control-sm" required>
                            <option value=""></option>
                            <option value="1">1 = Sin etiqueta</option>
                            <option value="2">2 = 3x3.5 fondo blanco</option>
                            <option value="3">3 = 1.5x3 fondo blanco</option>
                            <option value="4">4 = 3x3.5 fondo negro</option>
                            <option value="5">5 = 1.5x3 fondo negro</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6  d-none">
                        <label for="trPiel" >Piel</label>
                        <input type="text" class="form-control form-control-sm" id="trPiel" name="trPiel"  placeholder="">
                        <label for="trForro" >Forro</label>
                        <input type="text" class="form-control form-control-sm" id="trForro" name="trForro"  placeholder="">
                        <label for="trSuela" >Suela</label>
                        <input type="text" class="form-control form-control-sm" id="trSuela" name="trSuela"  placeholder="">
                    </div>
                    
                </div>
                <div class="row pt-2">
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                        <h6 class="text-danger">Los campos con * son obligatorios</h6>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6" align="right">
                        <button type="button" class="btn btn-info btn-lg btn-float" id="btnGuardar" data-toggle="tooltip" data-placement="left" title="Guardar">
                            <i class="fa fa-save"></i>
                        </button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/Colores/';
    var tblColores = $('#tblColores');
    var Colores;
    var btnNuevo = $("#btnNuevo"), btnCancelar = $("#btnCancelar"), btnEliminar = $("#btnEliminar"), btnGuardar = $("#btnGuardar");
    var pnlTablero = $("#pnlTablero"), pnlDatos = $("#pnlDatos"),
            FotoEstiloColor = pnlDatos.find("#FotoEstiloColor"),
            ArchivoFotoEstiloColor = pnlDatos.find("#ArchivoFotoEstiloColor"),
            btnFotoEstiloColor = pnlDatos.find("#btnFotoEstiloColor"), tfoto;
    var nuevo = false;

    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();
        handleEnterDiv(pnlDatos);
        handleEnterDiv(pnlTablero);
        validacionSelectPorContenedor(pnlDatos);
        setFocusSelectToInputOnChange('#trEtiqueta', '#trPiel', pnlDatos);

        /*FUNCIONES X BOTON*/

        ArchivoFotoEstiloColor.change(function () {
            var imageType = /image.*/;
            if (ArchivoFotoEstiloColor[0].files[0] !== undefined && ArchivoFotoEstiloColor[0].files[0].type.match(imageType)) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    FotoEstiloColor[0].src = reader.result;
                    pnlDatos.find("#FotoContenedor a")[0].href = reader.result;
                };
                reader.readAsDataURL(ArchivoFotoEstiloColor[0].files[0]);
                tfoto = true;
            } else {
                swal('ATENCIÓN', 'EL ELEMENTO TIENE QUE SER UNA IMAGEN.', 'warning');
                tfoto = false;
            }
        });

        btnFotoEstiloColor.click(function () {
            ArchivoFotoEstiloColor.trigger('click');
        });


        pnlDatos.find("#Descripcion").keyup(function () {
            if ($(this).val() !== '') {
                pnlDatos.find("#Pieles")[0].selectize.disable();
            } else {
                pnlDatos.find("#Pieles")[0].selectize.enable();
                pnlDatos.find("#Pieles").removeClass('disabledForms');
            }
        });
        pnlDatos.find("#Descripcion").change(function () {
            if ($(this).val() !== '') {
                pnlDatos.find("#Pieles")[0].selectize.disable();
                pnlDatos.find("#ObservacionesOrdenProduccion").focus();
            } else {
                pnlDatos.find("#Pieles")[0].selectize.enable();
                pnlDatos.find("#Pieles").removeClass('disabledForms');
            }
        });

        btnGuardar.click(function () {
            isValid('pnlDatos');
            if (valido) {
                pnlDatos.find("#Pieles")[0].selectize.enable();
                var frm = new FormData(pnlDatos.find("#frmNuevo")[0]);
                frm.append('FotoEstiloColor', ArchivoFotoEstiloColor[0].files[0]);
                if (!nuevo) {
                    $.ajax({
                        url: master_url + 'onModificar',
                        type: "POST",
                        cache: true,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data, x, jq) {
                        swal('ATENCIÓN', 'SE HA MODIFICADO EL REGISTRO', 'info');
                        Colores.ajax.reload();
                        pnlDatos.addClass("d-none");
                        pnlTablero.removeClass("d-none");
                        FotoEstiloColor[0].src = '<?PHP print base_url('img/camera.png'); ?>';
                        pnlDatos.find("#FotoContenedor a")[0].href = '<?PHP print base_url('img/camera.png'); ?>';
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    }).always(function () {
                        HoldOn.close();
                    });
                } else {
                    frm.append('Estatus', 'ACTIVO');
                    $.ajax({
                        url: master_url + 'onAgregar',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data, x, jq) {
                        pnlDatos.find("[name='ID']").val(data);
                        nuevo = false;
                        Colores.ajax.reload();
                        pnlDatos.addClass("d-none");
                        pnlTablero.removeClass("d-none");
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
                text: "Nota: No se eliminara ninguna unidad que tenga alguna relacion con otro dato dentro del sistema",
                icon: "warning",
                buttons: {
                    cancelar: {
                        text: "Cancelar",
                        value: "cancelar"
                    },
                    eliminar: {
                        text: "Aceptar",
                        value: "eliminar"
                    }
                }
            }).then((value) => {
                switch (value) {
                    case "eliminar":
                        $.post(master_url + 'onEliminar', {ID: temp}).done(function () {
                            swal('ATENCIÓN', 'SE HA ELIMINADO EL REGISTRO', 'success');
                            Colores.ajax.reload();
                            pnlDatos.addClass("d-none");
                            pnlTablero.removeClass("d-none");
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
            nuevo = true;
            pnlDatos.find("input,textarea").val("");
            pnlTablero.addClass("d-none");
            pnlDatos.removeClass("d-none");
            btnEliminar.addClass("d-none");
            pnlDatos.find("[name='Estilo']")[0].selectize.focus();
            pnlDatos.find('#FechaAlta').val(getToday());
            pnlDatos.find("#Pieles")[0].selectize.enable();
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
            FotoEstiloColor[0].src = '<?PHP print base_url('img/camera.png'); ?>';
            pnlDatos.find("#FotoContenedor a")[0].href = '<?PHP print base_url('img/camera.png'); ?>';
        });

        btnCancelar.click(function () {
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass("d-none");
        });
    });

    function init() {
        getRecords();
        getEstilos();
        getPieles();
        pnlDatos.find("[name='Estilo']").change(function () {
            if (nuevo) {
                getUltimaClave($(this).val());
            }
        });
    }

    function getUltimaClave(Estilo) {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        $.ajax({
            url: master_url + 'getUltimaClave',
            type: "POST",
            dataType: "JSON",
            data: {
                Estilo: Estilo
            }
        }).done(function (data, x, jq) {
            console.log(data);
            pnlDatos.find("[name='Clave']").val(data);
            pnlDatos.find("[name='Descripcion']").focus();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
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
        if ($.fn.DataTable.isDataTable('#tblColores')) {
            tblColores.DataTable().destroy();
        }
        Colores = tblColores.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"}, {"data": "Estilo"}, {"data": "Clave"}, {"data": "Color"}
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
            "scrollX": true,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [1, 'ASC']/*ID*/,
                [2, 'ASC']/*ID*/
            ],
            initComplete: function (x, y) {
                HoldOn.close();
            }
        });

        $('#tblColores_filter input[type=search]').focus();

        tblColores.find('tbody').on('click', 'tr', function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'CARGANDO...'
            });
            nuevo = false;
            tblColores.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Colores.row(this).data();
            temp = parseInt(dtm.ID);
            $.getJSON(master_url + 'getColorByID', {ID: temp}).done(function (data) {
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
                var xdes = pnlDatos.find("#Descripcion");
                if (xdes.val() !== '' && xdes.val().length > 0) {
                    pnlDatos.find("#Pieles")[0].selectize.disable();
                } else {
                    pnlDatos.find("#Pieles")[0].selectize.enable();
                }
                pnlTablero.addClass("d-none");
                pnlDatos.removeClass('d-none');
                pnlDatos.find("#Descripcion").focus().select();
                if (data[0].Foto === 'null' || data[0].Foto === 'NULL' || data[0].Foto === null) {
                    FotoEstiloColor[0].src = '<?PHP print base_url('img/camera.png'); ?>';
                    pnlDatos.find("#FotoContenedor a")[0].href = '<?PHP print base_url('img/camera.png'); ?>';
                } else {
                    FotoEstiloColor[0].src = '<?PHP print base_url(); ?>' + data[0].Foto;
                    pnlDatos.find("#FotoContenedor a")[0].href = '<?PHP print base_url(); ?>' + data[0].Foto;
                }
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');

            }).always(function () {
                HoldOn.close();
            });
        });

    }

    function getEstilos() {
        $.getJSON(master_url + 'getEstilos').done(function (data) {
            $.each(data, function (k, v) {
                pnlDatos.find("#Estilo")[0].selectize.addOption({text: v.Estilo, value: v.ID});
            });
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getPieles() {
        $.getJSON(master_url + 'getPieles').done(function (data) {
            $.each(data, function (k, v) {
                pnlDatos.find("#Pieles")[0].selectize.addOption({text: v.Articulo, value: v.ID});
            });
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
</script>
<style>
    .btn-success{
        padding: 5px 15px 5px 15px;
        font-size: 30px;
        text-align: center;
        text-decoration: none;
        border-radius: 50%;
    }
</style>

<?php
$this->load->view('vSeleccionaEstiloColorParaEfectoVenta');
