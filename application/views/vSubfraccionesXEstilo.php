<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Subfracciones por Estilo</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-warning btn-sm" id="btnCopiar" ><span class="fa fa-copy" ></span> COPIAR</button>
            </div>
        </div>
        <hr>
        <div class="card-block">
            <div class="row">
                <div class="col-4 col-sm-3 col-md-3 col-lg-2 col-xl-1">
                    <label for="" >Estilo</label>
                    <input type="text" class="form-control form-control-sm " maxlength="7" id="bEstilo" name="bEstilo">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card m-3 d-none animated fadeIn" id="pnlDatos">
    <div class="card-body text-dark">
        <form id="frmNuevo">
            <fieldset>
                <div class="row">
                    <div class="col-12 col-sm-8 col-md-8 float-left">
                        <legend >Sub Fracciones  del Estilo: <span id="spEstilo" class="text-strong text-info" style="font-size: 35px;"></span></legend>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4" align="right">
                        <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                            <span class="fa fa-arrow-left" ></span> REGRESAR
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" id="btnImprimirSubFraccionesXEstilo">
                            <span class="fa fa-file-invoice fa-1x"></span> IMPRIMIR
                        </button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class=" col-md-9 ">
                        <div class="row">
                            <div class="col-12 col-sm-7 col-md-7 col-lg-6 col-xl-5">
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
                            <div class="col-12 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                                <label for="Eficiencia" >Eficiencia %</label>
                                <input type="text" class="form-control form-control-sm numbersOnly" readonly="" id="Eficiencia" name="Eficiencia" >
                            </div>
                            <div class="w-100"></div>
                            <div class="col-12 col-sm-4 col-md-2 col-lg-3 col-xl-2">
                                <label for="Clave" >Sub-Fraccion</label>
                                <input type="text" class="form-control form-control-sm " maxlength="7" id="SubFraccion" name="SubFraccion" required>
                            </div>
                            <div class="col-12 col-sm-7 col-md-7 col-lg-6 col-xl-5">
                                <label>--</label>
                                <select id="sSubFraccion" name="sSubFraccion" class="form-control form-control-sm required" >
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                                <label for="TiempoEstandar" >T. Estandar</label>
                                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="7" id="TiempoEstandar" name="TiempoEstandar" >
                            </div>
                            <div class="col-12 col-sm-4 col-md-2 col-lg-3 col-xl-2 mt-4">
                                <button type="button" class="btn btn-info btn-sm" id="btnGuardar" >
                                    <i class="fa fa-save"></i> AGREGAR
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="">Fotografía</label>
                        <div id="VistaPrevia" >
                            <img src="<?php echo base_url(); ?>img/camera.png" class="img-thumbnail" width="200px"/>
                        </div>
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
                                            <th>Fraccion</th>
                                            <th></th>
                                            <th>Subfracción</th>
                                            <th></th>
                                            <th>Puesto</th>
                                            <th>T.Estandar.</th>
                                            <th>Eficiencia</th>
                                            <th>T. Real</th>
                                            <th>Base</th>
                                            <th>Costo</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="d-none"></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Totales:</th>
                                            <th></th>
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
                </div>
                <!--FIN DETALLE-->
            </fieldset>
        </form>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/SubfraccionesXEstilo/';
    var tblFracciones = $('#tblFracciones');
    var Fracciones;
    var btnCancelar = $("#btnCancelar"), btnGuardar = $("#btnGuardar"), btnCopiar = $("#btnCopiar");
    var pnlTablero = $("#pnlTablero"), pnlDatos = $("#pnlDatos");
    var nuevo = false;

    /*Detalle*/
    var tblDetalle = $('#tblDetalle');
    var Detalle;

    var Estilo;
    var SueldoBase;
    var Puesto;
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();

        pnlDatos.find('#btnImprimirSubFraccionesXEstilo').on("click", function () {
            pnlDatos.find('#btnImprimir').attr('disabled', true);
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var frm = new FormData();
            frm.append('Estilo', Estilo);
            $.ajax({
                url: master_url + 'onImprimirReporteSubfraccionesXEstilo',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                onImprimirReporteFancyAFC((data), function (a, b) {
                    HoldOn.close();
                    pnlDatos.find('#btnImprimirSubFraccionesXEstilo').attr('disabled', false);
                });
            }).fail(function (x, y, z) {
                HoldOn.close();
                console.log(x.responseText);
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            }).always(function () {
                HoldOn.close();
            });
        });

        pnlTablero.find("#bEstilo").keypress(function (e) {
            if (e.keyCode === 13) {
                var val = $(this).val();
                if (val) {
                    $.getJSON(base_url + 'index.php/Estilos/getEstiloByClave', {
                        Clave: val
                    }).done(function (data, x, jq) {
                        if (data.length > 0) {
                            Estilo = val;
                            pnlTablero.addClass('d-none');
                            pnlDatos.removeClass('d-none');
                            Detalle.ajax.reload();
                            pnlDatos.find('#spEstilo').html(val);
                            pnlDatos.find("#Fraccion")[0].selectize.focus();
                            getFotoXEstilo(val);
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


        btnCopiar.click(function () {
            $('#mdlCopiaSubFraccionesEstilo').modal('show');
        });

        pnlDatos.find("#Fraccion").change(function () {
            var fracc = $(this).val();
            if (fracc) {
                $.getJSON(base_url + 'index.php/SubfraccionesXEstilo/getEficiencia', {
                    Fraccion: fracc
                }).done(function (data, x, jq) {
                    if (data.length > 0) {
                        //Cargamos las subfracciones de esta fraccion
                        pnlDatos.find("#Eficiencia").val(data[0].eficiencia * 100);
                        getSubfraccionesXFraccion(fracc);
                        pnlDatos.find("#SubFraccion").focus().select();
                    } else {
                        swal('ERROR', 'LA FRACCIÓN NO EXISTE', 'warning').then((value) => {
                            pnlDatos.find('#Fraccion').focus().val('');
                        });
                    }
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
            }
        });

        pnlDatos.find("#SubFraccion").keypress(function (e) {
            if (e.keyCode === 13) {
                var val = $(this).val();
                var fraccion = pnlDatos.find("#Fraccion").val();
                if (val && fraccion) {
                    $.getJSON(base_url + 'index.php/SubfraccionesXEstilo/getSubfraccionXFraccion', {
                        Subfraccion: val,
                        Fraccion: fraccion
                    }).done(function (data, x, jq) {
                        if (data.length > 0) {
                            SueldoBase = data[0].SueldoBase;
                            Puesto = data[0].Puesto;
                            pnlDatos.find("#sSubFraccion")[0].selectize.addItem(val, true);
                            pnlDatos.find("#TiempoEstandar").focus();
                        } else {
                            swal('ERROR', 'SUBFRACCION NO EXISTENTE', 'warning').then((value) => {
                                pnlDatos.find("#sSubFraccion")[0].selectize.clear(true);
                                pnlDatos.find('#SubFraccion').focus().val('');
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                } else {
                    swal('ERROR', 'DEBES CAPTURAR LA FRACCION Y SUBFRACCION', 'warning').then((value) => {
                        pnlDatos.find("#sSubFraccion")[0].selectize.clear(true);
                        pnlDatos.find('#SubFraccion').focus().val('');
                    });
                }
            }
        });

        pnlDatos.find("#sSubFraccion").change(function () {
            var val = $(this).val();
            var fraccion = pnlDatos.find("#Fraccion").val();
            if (val && fraccion) {
                $.getJSON(base_url + 'index.php/SubfraccionesXEstilo/getSubfraccionXFraccion', {
                    Subfraccion: val,
                    Fraccion: fraccion
                }).done(function (data, x, jq) {
                    if (data.length > 0) {
                        pnlDatos.find("#SubFraccion").val(val);
                        SueldoBase = data[0].SueldoBase;
                        Puesto = data[0].Puesto;
                        pnlDatos.find("#TiempoEstandar").focus();
                    } else {
                        swal('ERROR', 'SUBFRACCION NO EXISTENTE', 'warning').then((value) => {
                            pnlDatos.find("#sSubFraccion")[0].selectize.clear(true);
                            pnlDatos.find('#SubFraccion').focus().val('');
                        });
                    }
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
            } else {
                swal('ERROR', 'DEBES CAPTURAR LA FRACCION Y SUBFRACCION', 'warning').then((value) => {
                    pnlDatos.find("#sSubFraccion")[0].selectize.clear(true);
                    pnlDatos.find('#SubFraccion').focus().val('');
                });
            }
        });

        pnlDatos.find("#TiempoEstandar").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    btnGuardar.focus();
                }
            }
        });

        /*FUNCIONES X BOTON*/
        btnGuardar.click(function () {
            isValid('pnlDatos');
            if (valido) {
                var frm = new FormData(pnlDatos.find("#frmNuevo")[0]);
                var eficiencia = pnlDatos.find("#Eficiencia").val() / 100;
                var tiempo_estandar = pnlDatos.find("#TiempoEstandar").val();
                var sueldo = SueldoBase;
                var minxdia = 2850;//Minutos laborados semanalmente ya que en un dia son 570
                var tiempo_real = tiempo_estandar / eficiencia;
                var costo = (sueldo / minxdia) * tiempo_real;

                frm.append('Puesto', Puesto);
                frm.append('TiempoReal', tiempo_real.toFixed(2));
                frm.append('SueldoBase', sueldo);
                frm.append('Costo', costo.toFixed(2));
                frm.append('Estilo', Estilo);
                frm.append('Eficiencia', eficiencia);

                $.ajax({
                    url: master_url + 'onAgregar',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    Detalle.ajax.reload();
                    pnlDatos.find("#sSubFraccion")[0].selectize.clear(true);
                    pnlDatos.find("#TiempoEstandar").val('');
                    pnlDatos.find("#SubFraccion").val('').focus();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });

        btnCancelar.click(function () {
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass("d-none");
        });
    });

    function init() {
        pnlTablero.find('#bEstilo').focus();
        getDesgloce();
    }

    function getSubfraccionesXFraccion(Fraccion) {
        pnlDatos.find("#sSubFraccion")[0].selectize.clear(true);
        pnlDatos.find("#sSubFraccion")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/SubfraccionesXEstilo/getSubfraccionesXFraccion', {Fraccion: Fraccion}).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlDatos.find("#sSubFraccion")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getFotoXEstilo(Estilo) {
        $.getJSON(base_url + 'index.php/FraccionesXEstilo/getEstiloByID', {Estilo: Estilo}).done(function (data, x, jq) {
            console.log('getFotoXEstilo', data);
            if (data.length > 0) {
                var dtm = data[0];
                var vp = pnlDatos.find("#VistaPrevia");
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
                                vp.html('<img src="' + base_url + dtm.Foto + '" class="img-thumbnail" width="200px" />');
                            }
                            if (ext !== "gif" && ext !== "jpg" && ext !== "jpeg" && ext !== "png" && ext !== "PDF" && ext !== "Pdf" && ext !== "pdf") {
                                vp.html('<img src="' + base_url + 'img/camera.png" class="img-thumbnail" width="200px" />');
                            }
                        } else {
                            vp.html(' <img src="' + esf + '" class="img-thumbnail rounded mx-auto "  width="200px" >');
                        }
                    }
                })
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
        });
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
                "url": master_url + 'getDetalle',
                "dataSrc": "",
                "type": "POST",
                "data": function (d) {
                    d.Estilo = Estilo ? Estilo : '';
                }
            },
            "columns": [
                {"data": "ID"},
                {"data": "numfra"},
                {"data": "nomfra"},
                {"data": "numsubfra"},
                {"data": "nomsubfra"},
                {"data": "puesto"},
                {"data": "tiempoestandar"},
                {"data": "efi"},
                {"data": "tiemporeal"},
                {"data": "sueldobase"},
                {"data": "costo"},
                {"data": "Eliminar"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [6, 8],
                    "render": function (data, type, row) {
                        return $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [7],
                    "render": function (data, type, row) {
                        return $.number(parseFloat(data), 2, '.', ',') + ' %';
                    }
                },
                {
                    "targets": [9, 10],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            rowGroup: {
                endRender: function (rows, group) {
                    var nomfra = rows.data()[0].nomfra;
                    var tiemporeal = $.number(rows.data().pluck('tiemporeal').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    var costo = $.number(rows.data().pluck('costo').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    return $('<tr>').
                            append('<td colspan="3"></td><td colspan="1">Total de: ' + group + " " + nomfra + '</td><td colspan="3"></td>').append('<td>' + tiemporeal + '</td><td></td><td>$' + costo + '</td><td></td></tr>');
                },
                dataSrc: "numfra"
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                var totaltr = api.column(8).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(8).footer()).html(api.column(8, {page: 'current'}).data().reduce(function (a, b) {
                    return $.number(parseFloat(totaltr), 2, '.', ',');
                }, 0));

                var totalcosto = api.column(10).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(10).footer()).html(api.column(10, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(totalcosto), 2, '.', ',');
                }, 0));
            },
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
                        case 0:
                            /*FECHA ENTREGA*/
                            c.addClass('text-strong');
                            break;
                        case 1:
                            /*FECHA ENTREGA*/
                            c.addClass('text-strong');
                            break;
                        case 8:
                            /*FECHA ENTREGA*/
                            c.addClass('text-strong');
                            break;
                        case 9:
                            /*FECHA ENTREGA*/
                            c.addClass('text-strong text-info');
                            break;
                        case 10:
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
<?php
$this->load->view('vCopiarSubFraccionEstiloaEstilo');
