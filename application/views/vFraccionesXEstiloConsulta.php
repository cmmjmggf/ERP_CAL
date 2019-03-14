<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Fracciones por Estilo</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
            </div>
        </div>
        <div class="card-block">
            <div class="table-responsive" id="FraccionesXEstilo">
                <table id="tblFraccionesXEstilo" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Estilo</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
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
                    <legend class="float-left">Fracciónes del Estilo</legend>
                </div>
                <div class="col-12 col-sm-6 col-md-8" align="right">
                    <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                        <span class="fa fa-arrow-left" ></span> REGRESAR
                    </button>
                    <button type="button" class="btn btn-warning btn-sm d-none" id="btnImprimirFraccionesXEstilo">
                        <span class="fa fa-file-invoice fa-1x"></span> IMPRIMIR
                    </button>
                </div>
            </div>
            <div class=" row">
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <label for="Estilo">Estilo*</label>
                    <select class="form-control form-control-sm required " id="Estilo" name="Estilo" required>
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <label for="" >F. Alta</label>
                    <input type="text" id="FechaAlta" name="FechaAlta" class="form-control form-control-sm date notEnter" >
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
                    <div class="table-responsive" id="FraccionesXEstiloDetalle">
                        <table id="tblFraccionesXEstiloDetalle" class="table table-sm  " style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fracción</th>
                                    <th>Costo M.O.</th>

                                    <th>Costo VTA.</th>
                                    <th>Afe. Cto.</th>

                                    <th>Eliminar</th>
                                    <th>DeptoCat</th>
                                    <th>Fraccion_ID</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Totales:</th>
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
    var master_url = base_url + 'index.php/FraccionesXEstilo/';
    var pnlDatos = $("#pnlDatos");
    var pnlTablero = $("#pnlTablero");
    var pnlDetalle = $("#pnlDetalle");
    var btnNuevo = $("#btnNuevo");
    var btnImprimirFraccionesXEstilo = $("#btnImprimirFraccionesXEstilo");
    var btnCancelar = pnlDatos.find("#btnCancelar");
    var Estilo = pnlDatos.find("#Estilo");
    var IdMovimiento = 0;
    var nuevo = true;

    $(document).ready(function () {

        validacionSelectPorContenedor(pnlDatos);
        setFocusSelectToInputOnChange('#Estilo', '#FechaAlta', pnlDatos);
        setFocusSelectToSelectOnChange('#Departamento', '#Fraccion', pnlDatos);
        setFocusSelectToInputOnChange('#Fraccion', '#CostoMO', pnlDatos);

        btnImprimirFraccionesXEstilo.click(function () {
            if (temp.length > 0) {
                //HoldOn.open({  message: 'Espere...', theme: 'sk-cube'});
                $.get(master_url + 'onImprimirFraccionesXEstilo', {Estilo: temp}).done(function (data) {

                    $.fancybox.open({
                        src: data,
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
                                    width: "85%",
                                    height: "85%"
                                },
                                // Iframe tag attributes
                                attr: {
                                    scrolling: "auto"
                                }
                            }
                        }
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', 'No existe el estilo', 'warning');
            }
        });

        pnlDatos.find("[name='Estilo']").change(function () {
            if (nuevo) {
                temp = $(this).val();
                getFotoXEstilo($(this).val());
            }
        });

        btnCancelar.click(function () {
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass('d-none');
            pnlDetalle.addClass('d-none');
        });

        getRecords();
        getEstilos();
        handleEnter();
    });

    var tblFraccionesXEstiloDetalle = pnlDetalle.find('#tblFraccionesXEstiloDetalle');
    var FraccionesXEstiloDetalle;
    function getFraccionesXEstiloDetalleByID(Estilo) {

        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblFraccionesXEstiloDetalle')) {
            tblFraccionesXEstiloDetalle.DataTable().destroy();
        }
        FraccionesXEstiloDetalle = tblFraccionesXEstiloDetalle.DataTable({
            "ajax": {
                "url": master_url + 'getFraccionesXEstiloDetalleByID',
                "dataSrc": "",
                "data": {
                    "Estilo": Estilo
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
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }, {
                    "targets": [3],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [5],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [6],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [7],
                    "visible": false,
                    "searchable": false
                }

            ],
            "columns": [
                {"data": "ID"}, /*0*/
                {"data": "Fraccion"}, /*1*/
                {"data": "CostoMO"}, /*2*/
                {"data": "CostoVTA"}, /*3*/
                {"data": "ACV"}, /*4*/
                {"data": "Eliminar"}, /*5*/
                {"data": "DeptoCat"}, /*6*/
                {"data": "Fraccion_ID"} /*7*/
            ],
            rowGroup: {
                endRender: function (rows, group) {
                    var stcMO = $.number(rows.data().pluck('CostoMO').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var stcV = $.number(rows.data().pluck('CostoVTA').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    return $('<tr>').
                            append('<td colspan="1">Total de: ' + group + '</td>').append('<td>$' + stcMO + '</td><td>$' + stcV + '</td><td></td><td></td></tr>');
                },
                dataSrc: "DeptoCat"
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                var totalCO = api.column(2).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(2).footer()).html(api.column(2, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(totalCO), 2, '.', ',');
                }, 0));

                var totalCV = api.column(3).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(3).footer()).html(api.column(3, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(totalCV), 2, '.', ',');
                }, 0));
            },

            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 1:
                            /*COSTO MO*/
                            c.addClass('text-info text-strong');
                            break;
                        case 2:
                            /*CONSUMO*/
                            c.addClass('text-warning text-strong');
                            break;
                        case 4:
                            /*ELIMINAR*/
                            c.addClass('text-danger');
                            break;

                    }
                });
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
            order: [[6, 'asc']],

            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });

        tblFraccionesXEstiloDetalle.find('tbody').on('click', 'tr', function () {
            tblFraccionesXEstiloDetalle.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var tr = $(this);
        });

    }
    var tblFraccionesXEstilo = $('#tblFraccionesXEstilo');
    var FraccionesXEstilo;
    function getRecords() {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblFraccionesXEstilo')) {
            tblFraccionesXEstilo.DataTable().destroy();
        }
        FraccionesXEstilo = tblFraccionesXEstilo.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataType": "json",
                "type": 'POST',
                "dataSrc": ""
            },
            "columns": [
                {"data": "EstiloId"}, {"data": "Descripcion"}
            ],
            "columnDefs": [
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 20,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: true,
            "bSort": true,
            "aaSorting": [
                [0, 'desc']/*ID*/
            ],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        $('#tblFraccionesXEstilo_filter input[type=search]').focus();

        tblFraccionesXEstilo.find('tbody').on('click', 'tr', function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            nuevo = false;
            tblFraccionesXEstilo.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = FraccionesXEstilo.row(this).data();
            temp = dtm.EstiloId;
            $.getJSON(master_url + 'getFraccionXEstiloByEstilo', {Estilo: dtm.EstiloId}).done(function (data, x, jq) {
                pnlDatos.find("input").val("");
                $.each(pnlDatos.find("select"), function (k, v) {
                    pnlDatos.find("select")[k].selectize.clear(true);
                });
                Estilo[0].selectize.disable();
                pnlDatos.find("#FechaAlta").addClass('disabledForms');
                pnlDatos.find("#Estilo")[0].selectize.setValue(data[0].Estilo);
                pnlDatos.find("#FechaAlta").val(data[0].FechaAlta);
                getFotoXEstilo(dtm.EstiloId);
                getFraccionesXEstiloDetalleByID(dtm.EstiloId);
                pnlTablero.addClass("d-none");
                pnlDetalle.removeClass('d-none');
                pnlDatos.removeClass('d-none');
                btnImprimirFraccionesXEstilo.removeClass('d-none');
                $('#tblFraccionesXEstiloDetalle_filter input[type=search]').focus();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            }).always(function () {
            });
        });
    }

    function getEstilos() {
        $.getJSON(master_url + 'getEstilos').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlDatos.find("#Estilo")[0].selectize.addOption({text: v.Estilo, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getFotoXEstilo(Estilo) {
        $.getJSON(master_url + 'getEstiloByID', {Estilo: Estilo}).done(function (data, x, jq) {
            console.log('getFotoXEstilo', data);
            if (data.length > 0) {
                var dtm = data[0];
                var vp = pnlDetalle.find("#VistaPrevia");
                if (dtm.Foto !== null && dtm.Foto !== undefined && dtm.Foto !== '') {
                    var ext = getExt(dtm.Foto);
                    if (ext === "gif" || ext === "jpg" || ext === "png" || ext === "jpeg") {
                        vp.html('<img src="' + base_url + dtm.Foto + '" class="img-thumbnail img-fluid" width="400px" />');
                    }
                    if (ext !== "gif" && ext !== "jpg" && ext !== "jpeg" && ext !== "png" && ext !== "PDF" && ext !== "Pdf" && ext !== "pdf") {
                        vp.html('<img src="' + base_url + 'img/camera.png" class="img-thumbnail img-fluid"/>');
                    }
                } else {
                    vp.html('<img src="' + base_url + 'img/camera.png" class="img-thumbnail img-fluid"/>');
                }
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
    td{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
</style>

