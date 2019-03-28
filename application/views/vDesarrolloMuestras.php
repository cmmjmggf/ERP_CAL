<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-12 float-left">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                        <legend class="float-left font-weight-bold">Desarrollo de muestras</legend>
                    </div>                    
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-4" align="center">
                        <button type="button" id="btnMuestras" class="btn btn-info"><span class="fa fa-eye"></span> VER TODAS LAS MUESTRAS</button>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-4" align="right">
                        <button type="button" id="btnCancelar" class="btn btn-danger d-none"><span class="fa fa-times"></span> CANCELAR</button>
                        <button type="button" id="btnGuardar" class="btn btn-primary"><span class="fa fa-check"></span> GUARDAR</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                        <input type="text" id="ID" name="ID" class="form-control d-none" readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <label>Estilo</label>
                        <input type="text" id="Estilo" name="Estilo" maxlength="10" class="form-control" autofocus="">
                        <input type="text" id="EstiloT" name="EstiloT" class="form-control d-none" readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7">
                        <label>Color</label>
                        <select id="Color" name="Color" class="form-control"></select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                        <label>Depto</label>
                        <input type="text" id="Depto" name="Depto" class="form-control numbersOnly">
                    </div>
                    <div class="w-100"><br></div>
                    <div class="col-12 col-xs-12 col-md-12 col-lg-12 col-xl-12">
                        <table class="table table-hover" id="tblFichaTecnica">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Estilo</th>
                                    <th scope="col">Pza</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Sec</th>
                                    <th scope="col">Articulo</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Cons</th>
                                    <th scope="col">Rango</th>
                                    <th scope="col">Linea</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-2" style="overflow-y:auto; height:500px !important"> 
                <div id="ldeptos" class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active font-weight-bold">
                        DEPARTAMENTO
                    </a> 
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-4 text-center justify-content-center" align="center">
                <img id="Foto" src="<?php print base_url('img/camera.png'); ?>" class="img-responsive img-fluid">
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 text-center">
                        <p class="font-weight-bold">ESPECIFICACIONES</p>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 text-center">
                        <p class="font-weight-bold">ACCIÓNES CORRECTIVAS</p>
                    </div>
                </div>
            </div>
            <div id="Deptos" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="row"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-fullscreen animated fadeIn" id="mdlMuestras">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Muestras</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tblMuestras" class="table table-hover">
                    <thead>
                        <tr> 
                            <th scope="col">ID</th>
                            <th scope="col">ESTILO</th>
                            <th scope="col">-</th>
                            <th scope="col">COLOR</th>
                            <th scope="col">-</th>
                            <th scope="col">CORTE</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (CORTE)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">RAYADO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (RAYADO)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">REBAJADO Y PERFORADO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (REBAJADO Y PERFORADO)</th>
                            <th scope="col">FECHA A.C</th>

                            <th scope="col">FOLEADO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (FOLEADO)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">DOBLILLADO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (DOBLILLADO)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">LASER</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (LASER)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">PREL-CORTE</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (PREL-CORTE)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">RAYADO CONTADO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (RAYADO CONTADO)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">ENTRETELADO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C ENTRETELADO</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">MAQUILA</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (MAQUILA)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">PESPUNTE</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (PESPUNTE)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">PREL-PESPUNTE</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (PREL-PESPUNTE)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">ALMACEN PESPUNTE</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (ALMACEN PESPUNTE)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">ENSUELADO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (ENSUELADO)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">TEJIDO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (TEJIDO)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">ALMACEN TEJIDO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (ALMACEN TEJIDO)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">CHOFERES</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (CHOFERES)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">MONTADO A</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (MONTADO A)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">MONTADO B</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (MONTADO B)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">PEGADO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (PEGADO)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">ADORNO A</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (ADORNO A)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">ADORNO B</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (ADORNO B)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">ALMACEN ADORNO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">A.C (ALMACEN ADORNO)</th>
                            <th scope="col">FECHA A.C</th>
                            <th scope="col">REGISTRO</th>
                            <th scope="col">USUARIO</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), btnGuardar = pnlTablero.find("#btnGuardar"),
            Estilo = pnlTablero.find("#Estilo"), EstiloT = pnlTablero.find("#EstiloT"),
            Color = pnlTablero.find("#Color"), Depto = pnlTablero.find("#Depto"),
            FichaTecnica, tblFichaTecnica = pnlTablero.find("#tblFichaTecnica"),
            Foto = pnlTablero.find("#Foto"), btnCancelar = pnlTablero.find("#btnCancelar"),
            btnMuestras = pnlTablero.find("#btnMuestras"), mdlMuestras = $("#mdlMuestras"),
            Muestras, tblMuestras = mdlMuestras.find("#tblMuestras"),
            nuevo = true;

    $(document).ready(function () {

        getDepartamentos();


        btnMuestras.click(function () {
            if (!$.fn.DataTable.isDataTable('#tblMuestras')) {
                Muestras = tblMuestras.DataTable({
                    "dom": 'Bfrtip',
                    buttons: buttons,
                    orderCellsTop: true,
                    fixedHeader: true,
                    "ajax": {
                        "url": '<?php print base_url('DesarrolloMuestras/getMuestras'); ?>',
                        "contentType": "application/json",
                        "dataSrc": ""
                    },
                    "columns": [
                        {"data": "ID"}, {"data": "Estilo"}, {"data": "EstiloT"}, 
                        {"data": "Color"}, {"data": "ColorT"}, {"data": "EspecificacionCorte"}, 
                        {"data": "FechaCorte"}, {"data": "AccionCorrectivaCorte"}, 
                        {"data": "FechaAccionCorrectivaCorte"}, {"data": "EspecificacionRayado"}, 
                        {"data": "FechaRayado"}, {"data": "AccionCorrectivaRayado"}, 
                        {"data": "FechaAccionCorrectivaRayado"}, {"data": "EspecificacionRebajadoyperforado"}, 
                        {"data": "FechaRebajadoyperforado"}, {"data": "AccionCorrectivaRebajadoyperforado"}, 
                        {"data": "FechaAccionCorrectivaRebajadoyperforado"}, {"data": "EspecificacionFoleado"}, 
                        {"data": "FechaFoleado"}, {"data": "AccionCorrectivaFoleado"}, 
                        {"data": "FechaAccionCorrectivaFoleado"}, {"data": "EspecificacionDoblillado"}, 
                        {"data": "FechaDoblillado"}, {"data": "AccionCorrectivaDoblillado"}, 
                        {"data": "FechaAccionCorrectivaDoblillado"}, {"data": "EspecificacionLaser"}, 
                        {"data": "FechaLaser"}, {"data": "AccionCorrectivaLaser"}, 
                        {"data": "FechaAccionCorrectivaLaser"}, {"data": "EspecificacionPrelcorte"}, 
                        {"data": "FechaPrelcorte"}, {"data": "AccionCorrectivaPrelcorte"}, 
                        {"data": "FechaAccionCorrectivaPrelcorte"}, {"data": "EspecificacionRayadocontado"}, 
                        {"data": "FechaRayadocontado"}, {"data": "AccionCorrectivaRayadocontado"}, 
                        {"data": "FechaAccionCorrectivaRayadocontado"}, {"data": "EspecificacionEntretelado"}, 
                        {"data": "FechaEntretelado"}, {"data": "AccionCorrectivaEntretelado"}, 
                        {"data": "FechaAccionCorrectivaEntretelado"}, {"data": "EspecificacionMaquila"}, 
                        {"data": "FechaMaquila"}, {"data": "AccionCorrectivaMaquila"}, 
                        {"data": "FechaAccionCorrectivaMaquila"}, {"data": "EspecificacionPespunte"}, 
                        {"data": "FechaPespunte"}, {"data": "AccionCorrectivaPespunte"}, 
                        {"data": "FechaAccionCorrectivaPespunte"}, {"data": "EspecificacionPrelpespunte"}, 
                        {"data": "FechaPrelpespunte"}, {"data": "AccionCorrectivaPrelpespunte"}, 
                        {"data": "FechaAccionCorrectivaPrelpespunte"}, {"data": "EspecificacionAlmacenpespunte"}, 
                        {"data": "FechaAlmacenpespunte"}, {"data": "AccionCorrectivaAlmacenpespunte"}, 
                        {"data": "FechaAccionCorrectivaAlmacenpespunte"}, {"data": "EspecificacionEnsuelado"}, 
                        {"data": "FechaEnsuelado"}, {"data": "AccionCorrectivaEnsuelado"}, 
                        {"data": "FechaAccionCorrectivaEnsuelado"}, {"data": "EspecificacionTejido"}, 
                        {"data": "FechaTejido"}, {"data": "AccionCorrectivaTejido"}, 
                        {"data": "FechaAccionCorrectivaTejido"}, {"data": "EspecificacionAlmacentejido"}, 
                        {"data": "FechaAlmacentejido"}, {"data": "AccionCorrectivaAlmacentejido"}, 
                        {"data": "FechaAccionCorrectivaAlmacentejido"}, {"data": "EspecificacionChoferes"}, 
                        {"data": "FechaChoferes"}, {"data": "AccionCorrectivaChoferes"}, 
                        {"data": "FechaAccionCorrectivaChoferes"}, {"data": "EspecificacionMontadoa"}, 
                        {"data": "FechaMontadoa"}, {"data": "AccionCorrectivaMontadoa"}, 
                        {"data": "FechaAccionCorrectivaMontadoa"}, {"data": "EspecificacionMontadob"}, 
                        {"data": "FechaMontadob"}, {"data": "AccionCorrectivaMontadob"}, 
                        {"data": "FechaAccionCorrectivaMontadob"}, {"data": "EspecificacionPegado"}, 
                        {"data": "FechaPegado"}, {"data": "AccionCorrectivaPegado"}, 
                        {"data": "FechaAccionCorrectivaPegado"}, {"data": "EspecificacionAdornoa"}, 
                        {"data": "FechaAdornoa"}, {"data": "AccionCorrectivaAdornoa"}, 
                        {"data": "FechaAccionCorrectivaAdornoa"}, {"data": "EspecificacionAdornob"}, 
                        {"data": "FechaAdornob"}, {"data": "AccionCorrectivaAdornob"}, 
                        {"data": "FechaAccionCorrectivaAdornob"}, {"data": "EspecificacionAlmacenadorno"}, 
                        {"data": "FechaAlmacenadorno"}, {"data": "AccionCorrectivaAlmacenadorno"}, 
                        {"data": "FechaAccionCorrectivaAlmacenadorno"}, {"data": "Registro"}, 
                        {"data": "Usuario"}
                    ],
                    "columnDefs": coldefs,
                    language: lang,
                    "autoWidth": true,
                    "colReorder": true,
                    "displayLength": 500,
                    "scrollY": "600px",
                    "scrollX":true,
                    "bLengthChange": false,
                    "deferRender": true,
                    "scrollCollapse": false,
                    "bSort": true,
                    "aaSorting": [
                        [0, 'asc']
                    ]
                });
            } else {
                Muestras.ajax.reload();
            }

            mdlMuestras.modal('show');
        });

        btnCancelar.click(function () {
            nuevo = true;
            pnlTablero.find("#ID").val('');
            Estilo.val('');
            EstiloT.val('');
            Color.val('');
            Depto.val('');
            pnlTablero.find('#Deptos input[id^="Especificacion"]').val('');
            pnlTablero.find('#Deptos input[id^="Fecha"]').val('');
            pnlTablero.find('#Deptos input[id^="AccionCorrectiva"]').val('');
            pnlTablero.find('#Deptos input[id^="FechaAccionCorrectiva"]').val('');
            $.each(pnlTablero.find("select"), function (k, v) {
                pnlTablero.find("select")[k].selectize.clear(true);
            });
            Foto[0].src = '';
            Estilo.focus().select();
        });

        btnGuardar.click(function () {
            if (Estilo.val() && Color.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Guardando...'
                });
                var f = new FormData();
                $.each(pnlTablero.find('#Deptos input[id^="Especificacion"]'), function (k, v) {
                    f.append($(v).attr('id'), $(v).val());
                });
                $.each(pnlTablero.find('#Deptos input[id^="Fecha"]'), function (k, v) {
                    f.append($(v).attr('id'), $(v).val());
                });
                $.each(pnlTablero.find('#Deptos input[id^="AccionCorrectiva"]'), function (k, v) {
                    f.append($(v).attr('id'), $(v).val());
                });
                $.each(pnlTablero.find('#Deptos input[id^="FechaAccionCorrectiva"]'), function (k, v) {
                    f.append($(v).attr('id'), $(v).val());
                });
                if (nuevo) {
                    f.append('Estilo', Estilo.val());
                    f.append('EstiloT', EstiloT.val());
                    f.append('Color', Color.val());
                    f.append('ColorT', Color.find("option:selected").text());
                    f.append('NUEVO', 1);
                } else {
                    f.append('NUEVO', 2);
                    f.append('ID', pnlTablero.find("#ID").val());
                }
                $.ajax({
                    url: '<?php print base_url('DesarrolloMuestras/onGuardar'); ?>',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: f
                }).done(function (a) {
                    swal('ATENCIÓN', 'SE HAN GUARDADO LOS CAMBIOS', 'success');
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR UN ESTILO Y UN COLOR', 'warning').then((value)=>{
                    Estilo.focus().select();
                });
            }
        });

        Color.change(function () {
            if (Estilo.val() && Color.val()) {
                FichaTecnica.ajax.reload();
                Depto.focus();
                getDatosXEstiloColor();
            } else {
                FichaTecnica.ajax.reload();
            }
        });

        Estilo.on('keydown', function (e) {
            if (e.keyCode === 13 && Estilo.val()) {
                getColoresXEstilo();
                getFotoXEstilo();
            } else {
                FichaTecnica.ajax.reload();
            }
        }).focusout(function () {
            if (Estilo.val()) {
                getColoresXEstilo();
                getFotoXEstilo();
            } else {
                FichaTecnica.ajax.reload();
            }
        }).change(function () {
            if (Estilo.val() && Color.val()) {
                FichaTecnica.ajax.reload();
                getFotoXEstilo();
            } else {
                FichaTecnica.ajax.reload();
            }
        });
        var coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ];
        FichaTecnica = tblFichaTecnica.DataTable({
            "dom": 'rtip',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": '<?php print base_url('DesarrolloMuestras/getRecords'); ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.ESTILO = Estilo.val();
                    d.COLOR = Color.val();
                }
            },
            "columns": [
                {"data": "ID"},
                {"data": "Estilo"},
                {"data": "Pza"},
                {"data": "PzaT"},
                {"data": "Sec"},
                {"data": "Articulo"},
                {"data": "ArticuloT"},
                {"data": "Cons"},
                {"data": "Rango"},
                {"data": "Linea"}
            ],
            "columnDefs": coldefs,
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "scrollY": "350px",
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc']
            ]
        });
    });
    function getColoresXEstilo() {
        Color[0].selectize.clear(true);
        Color[0].selectize.clearOptions();
        $.getJSON('<?php print base_url('DesarrolloMuestras/getColoresXEstilo'); ?>', {
            ESTILO: Estilo.val()
        }).done(function (a) {
            if (a.length > 0) {
                a.forEach(function (x) {
                    Color[0].selectize.addOption({text: x.COLOR, value: x.CLAVE});
                });
            } else {
                swal('ATENCIÓN', 'ESTE ESTILO LO TIENE COLORES', 'warning').then((value) => {
                    Estilo.val('');
                    Estilo.focus().select();
                });
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            Color[0].selectize.open();
        });
    }

    function getFotoXEstilo() {
        $.getJSON('<?php print base_url('DesarrolloMuestras/getFotoXEstilo'); ?>', {
            ESTILO: Estilo.val()
        }).done(function (a) {
            if (a.length > 0) {
                EstiloT.val(a[0].Estilo);
                Foto[0].src = '<?php print base_url() ?>' + a[0].Foto;
                getDatosXEstiloColor();
            } else {
                Foto[0].src = '<?php print base_url('img/camera.png'); ?>';
            }
            btnCancelar.removeClass("d-none");
        }).fail(function (x) {
            getError(x);
        }).always(function () {
        });
    }

    function getDatosXEstiloColor() {
        pnlTablero.find('#Deptos input[id^="Especificacion"]').val('');
        pnlTablero.find('#Deptos input[id^="Fecha"]').val('');
        pnlTablero.find('#Deptos input[id^="AccionCorrectiva"]').val('');
        pnlTablero.find('#Deptos input[id^="FechaAccionCorrectiva"]').val('');
        $.getJSON('<?php print base_url('DesarrolloMuestras/getDesarrolloMuestra'); ?>', {
            ESTILO: Estilo.val(),
            COLOR: Color.val()
        }).done(function (a) {
            console.log(a);
            if (a.length > 0) {
                $.each(a[0], function (k, v) {
                    console.log(k, v);
                    if (pnlTablero.find("#" + k).val() === '') {
                        pnlTablero.find("#" + k).val(v);
                    }
                });
                nuevo = false;
                btnCancelar.removeClass("d-none");
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
        });
    }

    function getDepartamentos() {
        $.getJSON('<?php print base_url('DesarrolloMuestras/getDepartamentos'); ?>').done(function (a) {
            var deptos = "", ldeptos = "";
            a.forEach(function (e) {
                ldeptos += '<a href="#" class="list-group-item list-group-item-action">' + e.CLAVE + ' ' + e.DEPTO + '</a>';
                deptos += '<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">' +
                        '<label  class="text-info">' + e.DEPTO + '</label>' +
                        '</div>' +
                        '<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-3 my-1 form-group has-danger">' +
                        '<input type="text" id="Especificacion' + e.DEPTOR + '" name="Especificacion' + e.DEPTOR + '" class="form-control is-invalid" data-clave="' + e.CLAVE + '">' +
                        '</div>' +
                        '<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-1 my-1 form-group has-danger">' +
                        '<input type="text" id="Fecha' + e.DEPTOR + '" name="Fecha' + e.DEPTOR + '" class="form-control date is-invalid" placeholder="XX/XX/XXXX">' +
                        '</div>' +
                        '<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-5 my-1 form-group has-success">' +
                        '<input type="text" id="AccionCorrectiva' + e.DEPTOR + '" name="AccionCorrectiva' + e.DEPTOR + '" class="form-control is-valid" placeholder="DETALLE SU ACCIÓN CORRECTIVA PARA ' + e.DEPTO + '">' +
                        '</div>' +
                        '<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-1 form-group has-success">' +
                        '<input type="text" id="FechaAccionCorrectiva' + e.DEPTOR + '" name="FechaAccionCorrectiva' + e.DEPTOR + '" class="form-control date is-valid" placeholder="XX/XX/XXXX">' +
                        '</div><div class="w-100 my-2"></div>';
            });
            pnlTablero.find("#Deptos .row").html(deptos);
            pnlTablero.find("#ldeptos:first-child").after(ldeptos);
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }
</script>

<style>
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid; 
        border-image: linear-gradient(to bottom,  #0099cc, #ccff00, rgb(0,0,0,0)) 1 100% ;
    }

    .card-header{ 
        background-color: transparent;
        border-bottom: 0px;
    }
    .btn-success {
        color: #ffffff;
        background-color: #2196F3;
        border-color: #2196F3;
    }

    .was-validated .form-control:valid, .form-control.is-valid, .was-validated
    .custom-select:valid, .custom-select.is-valid {
        border-color: #4CAF50;
    }

    /* width */
    ::-webkit-scrollbar {
        width: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;  
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #2C3E50;  
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #2C3E50; 
    }

    /*LEATHER THEME*/
    /*    .text-success.navbar-brand{
            color: #FFEB3B !important;
        }
        nav > .btn-primary, nav li > .btn-primary{
            background-color: transparent !important; 
            border-color: transparent !important; 
        } 
        .bg-primary{
            background-image: url("<?php print base_url('css/images/leather.jpg'); ?>") !important;
            background-size: contain;   
        }
        #sidebar.bg-primary{
            background-image: url("<?php print base_url('css/images/xxx.jpg'); ?>") !important;
            background-size: contain;   
        }
        .dropdown-item:hover, .dropdown-item:focus {
            color: #ffffff;
            font-weight: bold;
            text-decoration: none;
            background-color: transparent;
            background-image: url(http://127.0.0.1/ERP_CAL/css/images/leather.jpg) !important;
            background-size: contain;
        }*/
</style>