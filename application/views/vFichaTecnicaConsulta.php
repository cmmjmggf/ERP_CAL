<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Fichas Técnicas</legend>
            </div>
        </div>
        <hr>
        <div class="card-block">
            <div class="row">
                <div class="col-1" >
                    <label for="" >Estilo</label>
                    <input type="text" class="form-control form-control-sm " maxlength="7"  id="bEstilo" name="bEstilo"   >
                </div>
                <div class="col-4" >
                    <label>Color</label>
                    <div class="row">
                        <div class="col-3">
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="bColor" name="bColor" maxlength="2" required="">
                        </div>
                        <div class="col-9">
                            <select id="sbColor" name="sbColor" class="form-control form-control-sm required NotSelectize selectNotEnter" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-3" >
                    <button type="button" class="btn btn-info btn-sm mt-4" id="btnBuscarFT">ACEPTAR</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--GUARDAR-->
<div class="card border-0 m-3 d-none animated fadeIn" style="z-index: 99 !important" id="pnlDatos">
    <div class="card-body text-dark">
        <form id="frmNuevo">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 float-left">
                    <legend class="float-left">Ficha Técnica</legend>
                </div>
                <div class="col-12 col-sm-6 col-md-8" align="right">
                    <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                        <span class="fa fa-arrow-left" ></span> REGRESAR
                    </button>
                    <button type="button" class="btn btn-danger btn-sm d-none" id="btnEliminar">
                        <span class="fa fa-trash fa-1x"></span> ELIMINAR
                    </button>
                    <button type="button" class="btn btn-warning btn-sm d-none" id="btnImprimirFichaTecnica">
                        <span class="fa fa-file-invoice fa-1x"></span> FRACCIONES POR ESTILO
                    </button>
                </div>
            </div>
            <div class=" row">
                <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                    <label for="Estilo">Estilo*</label>
                    <select class="form-control form-control-sm required " id="Estilo" name="Estilo" required>
                    </select>
                </div>
                <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                    <label for="Color">Color*</label>
                    <select class="form-control form-control-sm required " id="Color" name="Color" required>
                    </select>
                </div>
                <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                    <label for="FechaAlta">Fecha de alta</label>
                    <input type="text" class="form-control form-control-sm notEnter" id="FechaAlta" name="FechaAlta"  >
                </div>
            </div>
        </form>
    </div>
</div>
<!--DETALLE-->
<div class="card d-none m-3 animated fadeIn" id="pnlDetalle">
    <div class="card-body" >
        <!--DETALLE-->
        <div class="row">
            <div class=" col-md-9 ">
                <div class="row">
                    <div class="table-responsive" id="FichaTecnicaDetalle">
                        <table id="tblFichaTecnicaDetalle" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Pieza_ID</th>
                                    <th>Pieza</th>
                                    <th>Articulo_ID</th>

                                    <th>Articulo</th>
                                    <th>Unidad</th>


                                    <th>Consumo</th>

                                    <th>PzaXPar</th>


                                    <th>ID</th>
                                    <th>Eliminar</th>
                                    <th>DeptoCat</th>
                                    <th>DEP</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <label for="">Fotografía</label>
                <div id="VistaPrevia" >
                    <img src="<?php echo base_url(); ?>img/camera.png" class="img-thumbnail img-fluid"/>
                </div>
            </div>
        </div>
        <!--FIN DETALLE-->
    </div>
</div>


<!--SCRIPT-->
<script>
    var master_url = base_url + 'index.php/FichaTecnica/';
    var pnlDatos = $("#pnlDatos");
    var pnlTablero = $("#pnlTablero");
    var pnlDetalle = $("#pnlDetalle");
    var btnNuevo = $("#btnNuevo");
    var btnCancelar = pnlDatos.find("#btnCancelar");
    var btnEliminar = $("#btnEliminar");
    var Estilo = pnlDatos.find("#Estilo");
    var Color = pnlDatos.find("#Color");
    var IdMovimiento = 0;
    var nuevo = true;

    var tblFichaTecnicaDetalle = pnlDetalle.find('#tblFichaTecnicaDetalle');
    var FichaTecnicaDetalle;

    $(document).ready(function () {
        pnlTablero.find('#bEstilo').focus();
        pnlTablero.find("select").selectize({
            hideSelected: false,
            openOnFocus: false
        });
        btnCancelar.click(function () {
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass('d-none');
            pnlDetalle.addClass('d-none');
            pnlTablero.find("#bEstilo").focus().select();
        });

        getEstilos();

        /*Funciones tablero*/
        pnlTablero.find("#bEstilo").keypress(function (e) {
            if (e.keyCode === 13) {
                var Estilo = $(this).val();
                if (Estilo) {
                    $.getJSON(base_url + 'index.php/Estilos/getEstiloByClave', {Clave: Estilo}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            pnlTablero.find("#sbColor")[0].selectize.clear(true);
                            pnlTablero.find("#sbColor")[0].selectize.clearOptions();
                            getColoresXEstiloIni(Estilo);
                            pnlTablero.find("#bColor").focus().select();
                        } else {
                            swal('ERROR', 'ESTILO NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find('#bEstilo').focus().val('');
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });

        pnlTablero.find("#bColor").keypress(function (e) {
            if (e.keyCode === 13) {
                var Color = $(this).val();
                var Estilo = pnlTablero.find("#bEstilo").val();
                if (Color) {
                    $.getJSON(base_url + 'index.php/FichaTecnicaCompra/onComprobarEstiloColor', {Color: Color, Estilo: Estilo}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            pnlTablero.find("#sbColor")[0].selectize.addItem(Color, true);
                            pnlTablero.find("#btnBuscarFT").focus();
                        } else {
                            swal('ERROR', 'EL COLOR NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find('#bColor').focus().val('');
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });
        pnlTablero.find("#sbColor").change(function () {
            if ($(this).val()) {
                pnlTablero.find("#bColor").val($(this).val());
                pnlTablero.find("#btnBuscarFT").focus();
            }
        });

        pnlTablero.find("#btnBuscarFT").click(function () {
            var estilo = pnlTablero.find("#bEstilo").val();
            var color = pnlTablero.find("#bColor").val();
            getFichaTecnicaByEstiloByColor(estilo, color);
        });

    });

    function getFichaTecnicaByEstiloByColor(estilo, color) {
        $.getJSON(master_url + 'getFichaTecnicaByEstiloByColor', {Estilo: estilo, Color: color}).done(function (data, x, jq) {
            if (data.length > 0) {
                pnlDatos.find("input").val("");
                $.each(pnlDatos.find("select"), function (k, v) {
                    pnlDatos.find("select")[k].selectize.clear(true);
                });
                Estilo[0].selectize.disable();
                Color[0].selectize.disable();
                pnlDatos.find("#FechaAlta").prop("readonly", true);
                $.getJSON(master_url + 'getColoresXEstilo', {Estilo: estilo}).done(function (data, x, jq) {
                    $.each(data, function (k, v) {
                        pnlDatos.find("[name='Color']")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
                    });
                    pnlDatos.find("[name='Color']")[0].selectize.addItem(color, true);
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    console.log("\n");
                    console.log(x, y, z);
                });
                pnlDatos.find("#Estilo")[0].selectize.addItem(data[0].Estilo, true);
                pnlDatos.find("#FechaAlta").val(data[0].FechaAlta);
                getFotoXEstilo(estilo);
                getFichaTecnicaDetalleByID(estilo, color);
                pnlTablero.addClass("d-none");
                pnlDetalle.removeClass('d-none');
                pnlDatos.removeClass('d-none');
            } else {
                swal('ATENCIÓN', 'ESTILO NO EXISTE EN FICHAS TÉCNICAS', 'warning').then((value) => {
                    //Acciones
                    pnlTablero.find("#bEstilo").focus().select();
                });
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            console.log("\n");
            console.log(x, y, z);
        });
    }

    function getColoresXEstiloIni(Estilo) {
        $.getJSON(base_url + 'index.php/FichaTecnicaCompra/getColoresXEstilo', {Estilo: Estilo}).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sbColor")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }
    function getFichaTecnicaDetalleByID(Estilo, Color) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblFichaTecnicaDetalle')) {
            tblFichaTecnicaDetalle.DataTable().destroy();
        }
        FichaTecnicaDetalle = tblFichaTecnicaDetalle.DataTable({
            "ajax": {
                "url": master_url + 'getFichaTecnicaDetalleByID',
                "dataSrc": "",
                "data": {
                    "Estilo": Estilo,
                    "Color": Color
                }
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [2],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [7],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [8],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [9],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [10],
                    "visible": false,
                    "searchable": false
                }
            ],
            "columns": [
                {"data": "Pieza_ID"}, /*0*/
                {"data": "Pieza"}, /*1*/
                {"data": "Articulo_ID"}, /*2*/
                {"data": "Articulo"}, /*3*/
                {"data": "Unidad"}, /*4*/
                {"data": "Consumo"}, /*5*/
                {"data": "PzXPar"}, /*6*/
                {"data": "ID"}, /*7*/
                {"data": "Eliminar"}, /*8*/
                {"data": "DeptoCat"}, /*9*/
                {"data": "DEPTO"}/*10*/
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 2:
                            /*UNIDAD*/
                            c.addClass('text-warning text-strong');
                            break;
                        case 3:
                            /*CONSUMO*/
                            c.addClass('');
                            break;
                        case 4:
                            /*PZXPAR*/
                            c.addClass('text-info text-strong');
                            break;


                    }
                });
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                var total = api.column(5).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(5).footer()).html(api.column(5, {page: 'current'}).data().reduce(function (a, b) {
                    return  $.number(parseFloat(total), 3, '.', ',');
                }, 0));
            },
            "dom": 'frt',
            "autoWidth": true,
            language: lang,
            "displayLength": 500,
            "colReorder": true,
            "bLengthChange": false,
            "deferRender": true,
            "scrollY": 295,
            "scrollCollapse": true,
            "bSort": true,
            "keys": true,
            order: [[10, 'asc'], [3, 'asc']],
            rowGroup: {
                endRender: function (rows, group) {
                    var stc = $.number(rows.data().pluck('Consumo').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 4, '.', ',');
                    return $('<tr>').
                            append('<td></td><td colspan="2">Totales de: ' + group + '</td>').append('<td>' + stc + '</td><td colspan="2"></td></tr>');
                },
                dataSrc: "DeptoCat"
            },

            "initComplete": function (x, y) {
                HoldOn.close();
                $('#tblFichaTecnicaDetalle_filter input[type=search]').focus();
            }
        });

        tblFichaTecnicaDetalle.find('tbody').on('click', 'tr', function () {
            tblFichaTecnicaDetalle.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });

    }

    function getEstilos() {
        $.getJSON(master_url + 'getEstilos').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlDatos.find("#Estilo")[0].selectize.addOption({text: v.Estilo, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getFotoXEstilo(Estilo) {
        $.getJSON(master_url + 'getEstiloByID', {Estilo: Estilo}).done(function (data, x, jq) {
            if (data.length > 0) {
                var dtm = data[0];
                var vp = pnlDetalle.find("#VistaPrevia");
                var esf = '<?php print base_url('uploads/Estilos/esf.jpg'); ?>';
                $.ajax({
                    url: base_url + dtm.Foto,
                    type: 'HEAD',
                    error: function ()
                    {
                        vp.html(' <img src="' + esf + '" class="img-thumbnail img-fluid rounded mx-auto " >');
                    },
                    success: function ()
                    {
                        if (dtm.Foto !== null && dtm.Foto !== undefined && dtm.Foto !== '') {
                            var ext = getExt(dtm.Foto);
                            if (ext === "gif" || ext === "jpg" || ext === "png" || ext === "jpeg") {
                                vp.html('<img src="' + base_url + dtm.Foto + '" class="img-thumbnail img-fluid" width="400px" />');
                            }
                            if (ext !== "gif" && ext !== "jpg" && ext !== "jpeg" && ext !== "png" && ext !== "PDF" && ext !== "Pdf" && ext !== "pdf") {
                                vp.html(' <img src="' + esf + '" class="img-thumbnail img-fluid rounded mx-auto " >');
                            }
                        } else {
                            vp.html(' <img src="' + esf + '" class="img-thumbnail img-fluid rounded mx-auto " >');
                        }
                    }
                });
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
        });
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
    .btn-info-blue{
        color: #fff;
        background-color: #3F51B5 !important;
        border-color: #3F51B5 !important;
    }
    table tbody tr  {
        font-size: 0.70rem !important;
    }
</style>