<div class="modal " id="mdlRastreoControlNomina"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rastreo de controles ya capturados en nómina</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoRastreo" name="AnoRastreo" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="SemRastreo" name="SemRastreo" required="">
                        </div>
                        <div class="col-6 col-xs-6 col-sm-3 col-lg-3 col-xl-3">
                            <label>Control</label>
                            <input type="text" id="ControlRastreo" name="ControlRastreo" maxlength="10" class="form-control form-control-sm numeric" required="">
                        </div>
                        <div class="col-5">
                            <label>Estatus Producción</label>
                            <input type="text" class="form-control form-control-sm" readonly="" id="EstatusProduccionRastreo" name="EstatusProduccionRastreo" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2" >
                            <label for="" >Empleado</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="4" required=""  id="iEmpleadoRastreo" name="iEmpleadoRastreo"   >
                        </div>
                        <div class="col-5">
                            <label>-</label>
                            <select id="EmpleadoRastreo" name="EmpleadoRastreo" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-5">
                            <label>Fracción</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" readonly="" id="FraccionRastreo" name="FraccionRastreo" >
                        </div>
                        <div class="col-sm-12 mt-3">
                            <div class="table-responsive" id="ControlesNominaRastreo">
                                <table id="tblControlesNominaRastreo" class="table table-sm  " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Control</th>
                                            <th>Empl</th>
                                            <th>Estilo</th>
                                            <th>Fracc</th>
                                            <th>Fecha</th>
                                            <th>Sem</th>
                                            <th>Pares</th>
                                            <th>Precio</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">IMPRIMIR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlRastreoControlNomina = $('#mdlRastreoControlNomina');
    var tblControlesNominaRastreo = $('#tblControlesNominaRastreo');
    var ControlesNominaRastreo;


    var sem_ini = 0;
    $(document).ready(function () {


        mdlRastreoControlNomina.on('shown.bs.modal', function () {
            handleEnterDiv(mdlRastreoControlNomina);
            validacionSelectPorContenedor(mdlRastreoControlNomina);
            mdlRastreoControlNomina.find("input").not('#SemRastreo').val("");
            $.each(mdlRastreoControlNomina.find("select"), function (k, v) {
                mdlRastreoControlNomina.find("select")[k].selectize.clear(true);
            });
            mdlRastreoControlNomina.find("#AnoRastreo").val(new Date().getFullYear());
            getSemanaByFechaRastreoControlNom(getFechaActualConDiagonales());
            mdlRastreoControlNomina.find('#SemRastreo').focus().select();
            getControlesNominaRastreo('', new Date().getFullYear(), sem_ini, '');
            getEmpleadosRastreoControl();

        });

        mdlRastreoControlNomina.find("#AnoRastreo").change(function () {
            if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    mdlRastreoControlNomina.find("#AnoRastreo").val("");
                    mdlRastreoControlNomina.find("#AnoRastreo").focus();
                });
            } else {
                anoRastreo = $(this).val();
//                getControlesNominaRastreo(contRastreo, anoRastreo, semRastreo, empRastreo);
            }
        });
        mdlRastreoControlNomina.find("#SemRastreo").keydown(function (e) {
            if (e.keyCode === 13) {
                var ano = mdlRastreoControlNomina.find("#AnoRastreo");
                onComprobarSemanasNominaRastreo($(this), ano.val());

            }
        });
        mdlRastreoControlNomina.find('#iEmpleadoRastreo').keydown(function (e) {
            if (e.keyCode === 13) {
                var txtempl = $(this).val();
                if (txtempl) {

                    $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/onVerificarEmpleado', {Empleado: txtempl}).done(function (data) {
                        if (data.length > 0) {
                            var semRastreo = mdlRastreoControlNomina.find("#SemRastreo").val();
                            var contRastreo = mdlRastreoControlNomina.find("#ControlRastreo").val();
                            var anoRastreo = mdlRastreoControlNomina.find("#AnoRastreo").val();
                            mdlRastreoControlNomina.find("#EmpleadoRastreo")[0].selectize.addItem(txtempl, true);
                            getControlesNominaRastreo(contRastreo, anoRastreo, semRastreo, txtempl);
                            mdlRastreoControlNomina.find('#iEmpleadoRastreo').focus().val('');

                        } else {
                            swal('ERROR', 'EMPLEADO INEXISTENTE, DADO DE BAJA O NO ES DESTAJISTA', 'warning').then((value) => {
                                mdlRastreoControlNomina.find('#EmpleadoRastreo')[0].selectize.clear(true);
                                mdlRastreoControlNomina.find('#iEmpleadoRastreo').focus().select();
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlRastreoControlNomina.find("#EmpleadoRastreo").change(function () {

            var semRastreo = mdlRastreoControlNomina.find("#SemRastreo").val();
            var contRastreo = mdlRastreoControlNomina.find("#ControlRastreo").val();
            var anoRastreo = mdlRastreoControlNomina.find("#AnoRastreo").val();
            var empRastreo = $(this).val();
            mdlRastreoControlNomina.find('#iEmpleadoRastreo').val(empRastreo);
            getControlesNominaRastreo(contRastreo, anoRastreo, semRastreo, empRastreo);
            mdlRastreoControlNomina.find('#iEmpleadoRastreo').focus().select();
        });
        mdlRastreoControlNomina.find("#ControlRastreo").keydown(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var semRastreo = mdlRastreoControlNomina.find("#SemRastreo").val();
                    var contRastreo = $(this).val();
                    var anoRastreo = mdlRastreoControlNomina.find("#AnoRastreo").val();
                    var empRastreo = mdlRastreoControlNomina.find("#EmpleadoRastreo").val();

                    $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getControl', {
                        Control: $(this).val()
                    }).done(function (data) {
                        if (data.length > 0) { //Si el control existe primero se valida que no este fact o cancelado
                            mdlRastreoControlNomina.find("#EstatusProduccionRastreo").val(data[0].Depto + '  ' + data[0].DeptoT);
                            getControlesNominaRastreo(contRastreo, anoRastreo, semRastreo, empRastreo);
                        } else { //Si el control no existe
                            swal({
                                title: "ATENCIÓN",
                                text: "EL CONTROL NO EXISTE EN PRODUCCIÓN ",
                                icon: "warning",
                                closeOnClickOutside: false,
                                closeOnEsc: false
                            }).then((action) => {
                                if (action) {
                                    mdlRastreoControlNomina.find("#ControlRastreo").val('').focus();
                                }
                            });
                        }
                    });
                }
            }
        });
        mdlRastreoControlNomina.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});

            var frm = new FormData();
            frm.append('Control', mdlRastreoControlNomina.find("#ControlRastreo").val());

            $.ajax({
                url: base_url + 'index.php/CapturaFraccionesParaNomina/onImprimirReporteRastreoControl',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
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


                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlRastreoControlNomina.find('#btnImprimir').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

    });

    function getSemanaByFechaRastreoControlNom(fecha) {
        $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getSemanaByFecha', {Fecha: fecha}).done(function (data) {
            if (data.length > 0) {
                mdlRastreoControlNomina.find('#SemRastreo').val(data[0].sem);
            } else {
                swal('ERROR', 'NO EXISTE SEMANA', 'info');
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getControlesNominaRastreo(cont, ano, sem, empl) {
        //HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblControlesNominaRastreo')) {
            tblControlesNominaRastreo.DataTable().destroy();
        }
        ControlesNominaRastreo = tblControlesNominaRastreo.DataTable({
            "dom": 'frtip',
            buttons: buttons,
            "ajax": {
                "url": base_url + 'index.php/CapturaFraccionesParaNomina/getControlesNominaRastreo',
                "dataType": "json",
                "type": 'GET',
                "data": {Control: cont, Ano: ano, Sem: sem, Emp: empl},
                "dataSrc": ""
            },
            "columns": [
                {"data": "control"},
                {"data": "numeroempleado"},
                {"data": "estilo"},
                {"data": "numfrac"},
                {"data": "fecha"},
                {"data": "semana"},
                {"data": "pares"},
                {"data": "preciofrac"},
                {"data": "subtot"}
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": false,
            "displayLength": 500,
            scrollY: 320,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: false,
            "bSort": true,
            "aaSorting": [

            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*UNIDAD*/
                            c.addClass('text-info text-strong');
                            break;
                        case 1:
                            /*CONSUMO*/
                            c.addClass('text-success text-strong');
                            break;
                        case 3:
                            /*PZXPAR*/
                            c.addClass('text-strong ');
                            break;
                        case 5:
                            /*PZXPAR*/
                            c.addClass('text-strong ');
                            break;
                        case 8:
                            /*ELIMINAR*/
                            c.addClass('text-strong');
                            break;
                    }
                });
            },
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        $('#tblControlesNominaRastreo_filter input[type=search]').addClass('selectNotEnter');
        tblControlesNominaRastreo.find('tbody').on('click', 'tr', function () {
            tblControlesNominaRastreo.find("tbody tr").removeClass("success");
            $(this).addClass("success");

            var dtm = ControlesNominaRastreo.row(this).data();
            mdlRastreoControlNomina.find("#FraccionRastreo").val(dtm.nomfrac);
            mdlRastreoControlNomina.find("#EmpleadoRastreo")[0].selectize.addItem(dtm.numeroempleado, true);
            mdlRastreoControlNomina.find("#iEmpleadoRastreo").val(dtm.numeroempleado);
            mdlRastreoControlNomina.find("#ControlRastreo").val(dtm.control);
            mdlRastreoControlNomina.find("#SemRastreo").val(dtm.semana);
        });

    }

    function getEmpleadosRastreoControl() {
        $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getEmpleados', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlRastreoControlNomina.find("#EmpleadoRastreo")[0].selectize.addOption({text: v.Empleado, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function onComprobarSemanasNominaRastreo(v, ano) {
        if ($(v).val() > 52) {
            $(v).val('');
            $(v).focus();
        } else {
            var semRastreo = $(v).val();
            var contRastreo = mdlRastreoControlNomina.find("#ControlRastreo").val();
            var anoRastreo = mdlRastreoControlNomina.find("#AnoRastreo").val();
            var empRastreo = mdlRastreoControlNomina.find("#EmpleadoRastreo").val();
            getControlesNominaRastreo(contRastreo, anoRastreo, semRastreo, empRastreo);
        }
    }

</script>