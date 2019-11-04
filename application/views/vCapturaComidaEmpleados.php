<div class="modal " id="mdlCapturaComidaEmpleados"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Captura comidas a empleados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoComida" name="AnoComida" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                            <label>Sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="SemComida" name="SemComida" required="">
                        </div>
                        <div class="col-2">
                            <label>Precio</label>
                            <input type="text" maxlength="7" class="form-control form-control-sm numbersOnly" required=""  id="PrecioComida" name="PrecioComida" >
                        </div>
                        <div class="col-2">
                            <button type="button" id="btnEliminaComidaAnterior" class="btn btn-danger btn-sm selectNotEnter">
                                <span class="fa fa-trash"></span> ELIMINA COMIDA ANTERIOR
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2" >
                            <label for="" >Empleado</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="4" required=""  id="EmpleadoComida" name="EmpleadoComida"   >
                        </div>
                        <div class="col-6">
                            <label>-</label>
                            <select id="sEmpleadoComida" name="sEmpleadoComida" class="form-control form-control-sm  ">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label>No. Comidas</label>
                            <input type="text" maxlength="7" class="form-control form-control-sm numbersOnly" required="" id="NoComidas" name="NoComidas" >
                        </div>
                        <div class="col-sm-12 mt-1" align="center">
                            <label class="badge badge-primary" style="font-size: 14px;">Personal con comidas</label>
                        </div>
                        <div class="col-sm-12 mt-1">
                            <div class="table-responsive" id="EmpleadosConComidas">
                                <table id="tblEmpleadosConComidas" class="table table-sm  " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nombre</th>
                                            <th>Importe</th>
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
                <button type="button" class="btn btn-primary selectNotEnter" id="btnAceptarComida">ACEPTAR</button>
                <button type="button" class="btn btn-info selectNotEnter" id="btnVerEmpleadosComidas">EMPLEADOS</button>
                <button type="button" class="btn btn-secondary selectNotEnter" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlCapturaComidaEmpleados = $('#mdlCapturaComidaEmpleados');
    var btnVerEmpleadosComidas = $("#btnVerEmpleadosComidas");
    var tblEmpleadosConComidas = $('#tblEmpleadosConComidas');
    var EmpleadosConComidas;

    $(document).ready(function () {
        btnVerEmpleadosComidas.click(function () {
            $.fancybox.open({
                src: base_url + '/Empleados.shoes/?origen=NOMINAS',
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
        });
        mdlCapturaComidaEmpleados.find("#AnoComida").change(function () {
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
                    mdlCapturaComidaEmpleados.find("#AnoComida").val("");
                    mdlCapturaComidaEmpleados.find("#AnoComida").focus();
                });
            } else {

            }
        });
        mdlCapturaComidaEmpleados.find("#SemComida").keydown(function (e) {
            if (e.keyCode === 13) {
                var ano = mdlCapturaComidaEmpleados.find("#AnoComida");
                onComprobarSemanasNomina($(this), ano.val());
            }
        });
        mdlCapturaComidaEmpleados.find('#EmpleadoComida').keydown(function (e) {
            if (e.keyCode === 13) {
                var txtempl = $(this).val();
                if (txtempl) {
                    $.getJSON(base_url + 'index.php/ConceptosVariablesNomina/onVerificarEmpleadoComidas', {Empleado: txtempl}).done(function (data) {
                        if (data.length > 0) {
                            mdlCapturaComidaEmpleados.find("#sEmpleadoComida")[0].selectize.addItem(txtempl, true);
                            mdlCapturaComidaEmpleados.find('#NoComidas').focus().select();
                        } else {
                            swal('ERROR', 'EMPLEADO NO EXISTE O DADO DE BAJA', 'warning').then((value) => {
                                mdlCapturaComidaEmpleados.find('#sEmpleadoComida')[0].selectize.clear(true);
                                mdlCapturaComidaEmpleados.find('#EmpleadoComida').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlCapturaComidaEmpleados.find("#sEmpleadoComida").change(function () {
            if ($(this).val()) {
                mdlCapturaComidaEmpleados.find('#EmpleadoComida').val($(this).val());
                mdlCapturaComidaEmpleados.find('#NoComidas').focus().select();
            }
        });

        mdlCapturaComidaEmpleados.find("#NoComidas").keydown(function (e) {

            if ($(this).val()) {
                if (e.keyCode === 13) {
                    if (parseInt($(this).val()) > 0 && parseInt($(this).val()) < 6) {
                        mdlCapturaComidaEmpleados.find("#btnAceptarComida").focus();
                    } else {
                        mdlCapturaComidaEmpleados.find("#NoComidas").val("");
                        mdlCapturaComidaEmpleados.find("#NoComidas").focus();
                    }
                }
            }
        });
        mdlCapturaComidaEmpleados.on('shown.bs.modal', function () {
            mdlCapturaComidaEmpleados.find("select").selectize({
                hideSelected: false,
                openOnFocus: false
            });
            handleEnterDiv(mdlCapturaComidaEmpleados);
            validacionSelectPorContenedor(mdlCapturaComidaEmpleados);
            mdlCapturaComidaEmpleados.find("input").not('#SemComida').val("");
            $.each(mdlCapturaComidaEmpleados.find("select"), function (k, v) {
                mdlCapturaComidaEmpleados.find("select")[k].selectize.clear(true);
            });
            getEmpleadosConComidas();
            getEmpleadosComidasSelect();
            getSemanaByFechaComida(getFechaActualConDiagonales());
            mdlCapturaComidaEmpleados.find("#AnoComida").val(new Date().getFullYear());
            mdlCapturaComidaEmpleados.find('#PrecioComida').focus();
        });
        mdlCapturaComidaEmpleados.find('#btnEliminaComidaAnterior').on("click", function () {
            swal({
                title: "ATENCIÓN",
                text: "ESTÁS SEGURO?",
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"]
            }).then((value) => {
                if (value) {
                    HoldOn.open({theme: 'sk-bounce', message: 'POR FAVOR, ESPERE...'});
                    $.ajax({
                        url: base_url + 'index.php/Empleados/onActualizarCampoGeneral',
                        type: "POST",
                        data: {
                            Comida: 0
                        }
                    }).done(function (data, x, jq) {
                        EmpleadosConComidas.ajax.reload();
                        HoldOn.close();
                    }).fail(function (x, y, z) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x, y, z);
                        HoldOn.close();
                    });
                }
            });
        });

        mdlCapturaComidaEmpleados.find('#btnAceptarComida').on("click", function () {
            isValid('mdlCapturaComidaEmpleados');
            if (valido) {
                var empleado = mdlCapturaComidaEmpleados.find("#EmpleadoComida").val();
                var precio = mdlCapturaComidaEmpleados.find("#PrecioComida").val();
                var cantidad = mdlCapturaComidaEmpleados.find("#NoComidas").val();
                $.ajax({
                    url: base_url + 'index.php/Empleados/onModificarExt',
                    type: "POST",
                    data: {
                        Numero: empleado,
                        Comida: precio * cantidad
                    }
                }).done(function (data, x, jq) {
                    EmpleadosConComidas.ajax.reload();
                    mdlCapturaComidaEmpleados.find("#NoComidas").val('');
                    mdlCapturaComidaEmpleados.find("#EmpleadoComida").val('');
                    mdlCapturaComidaEmpleados.find("#sEmpleadoComida")[0].selectize.clear(true);
                    HoldOn.close();
                    mdlCapturaComidaEmpleados.find('#EmpleadoComida').val('').focus();
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });

    });

    function getSemanaByFechaComida(fecha) {
        $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getSemanaByFecha', {Fecha: fecha}).done(function (data) {
            if (data.length > 0) {
                mdlCapturaComidaEmpleados.find("#SemComida").val(data[0].sem);
            } else {
                swal('ERROR', 'NO EXISTE SEMANA', 'info');
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getEmpleadosConComidas() {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblEmpleadosConComidas')) {
            tblEmpleadosConComidas.DataTable().destroy();
        }
        EmpleadosConComidas = tblEmpleadosConComidas.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": base_url + 'index.php/Empleados/getEmpleadosComidas',
                "dataType": "json",
                "type": 'POST',
                "dataSrc": ""
            },
            "columns": [
                {"data": "Clave"},
                {"data": "Nombre"},
                {"data": "Comida"}
            ],
            "columnDefs": [
                {
                    "targets": [2],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": false,
            "displayLength": 1500,
            scrollY: 240,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: false,
            "bSort": true,
            "aaSorting": [

            ],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        $('#tblEmpleadosConComidas_filter input[type=search]').addClass('selectNotEnter');
        tblEmpleadosConComidas.find('tbody').on('click', 'tr', function () {
            tblEmpleadosConComidas.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        tblEmpleadosConComidas.find('tbody').on('dblclick', 'tr', function () {
            var dtm = EmpleadosConComidas.row(this).data();
            swal({
                title: "ESTÁS SEGURO?",
                text: "Desea borra la comida del empleado: \n ****" + dtm.Clave + ' ' + dtm.Nombre + '****',
                icon: "warning",
                buttons: {
                    cancelar: {
                        text: "Cancelar",
                        value: "cancelar"
                    },
                    eliminar: {
                        text: "Aceptar",
                        value: "aceptar"
                    }
                }
            }).then((value) => {
                switch (value) {
                    case "aceptar":
                        $.ajax({
                            url: base_url + 'index.php/Empleados/onModificarExt',
                            type: "POST",
                            data: {
                                Numero: dtm.Clave,
                                Comida: 0
                            }
                        }).done(function (data, x, jq) {
                            EmpleadosConComidas.ajax.reload();
                        }).fail(function (x, y, z) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x, y, z);
                            HoldOn.close();
                        });

                        break;
                    case "cancelar":
                        swal.close();
                        break;
                }
            });
        });
    }

    function getEmpleadosComidasSelect() {
        $.getJSON(base_url + 'index.php/Empleados/getEmpleadosComidasSelect', ).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlCapturaComidaEmpleados.find("#sEmpleadoComida")[0].selectize.addOption({text: v.Nombre, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function onComprobarSemanasNomina(v, ano) {
        //Valida que esté creada la semana en nominas
        $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
                //Valida que no esté cerrada la semana en nomina

            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA SEMANA " + $(v).val() + " DEL " + ano + " " + "NO EXISTE",
                    icon: "warning",
                    buttons: {
                        eliminar: {
                            text: "Aceptar",
                            value: "aceptar"
                        }
                    }
                }).then((value) => {
                    switch (value) {
                        case "aceptar":
                            swal.close();
                            $(v).val('');
                            $(v).focus();
                            break;
                    }
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

</script>