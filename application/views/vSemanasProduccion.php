<div class="card border-0 m-3" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Semanas de Producción</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">

                <button type="button" class="btn btn-primary" id="btnNuevo" data-toggle="tooltip" data-placement="top" title="Agregar"><span class="fa fa-plus"></span><br></button>
            </div>
        </div>
        <div class="card-block">
            <div class="table-responsive" id="tblRegistros"></div>
        </div>
    </div>
</div>
<!--GUARDAR-->
<div class="card border-0 m-3  d-none" id="pnlDatos">
    <div class="card-body text-dark">
        <form id="frmNuevo">
            <div class="row">
                <div class="col-md-4 float-left">
                    <legend class="float-left">Semanas de Producción <strong id="lAno"></strong></legend>
                </div>
                <div class="col-md-4 float-right">

                </div>
                <div class="col-md-4 float-right" align="right">
                    <button type="button" class="btn btn-secondary btn-sm" id="btnCancelar"><span class="fa fa-arrow-left"></span> REGRESAR </button>
                    <button type="button" class="btn btn-danger btn-sm d-none" id="btnEliminar" ><span class="fa fa-trash"></span> ELIMINAR</button>
                </div>
            </div>
            <div class="row" id="ControlesEncabezado">
                <div class="d-none">
                    <input type="text" class="" id="ID" name="ID" >
                </div>
                <div class="col-6 col-sm-2">
                    <label for="Ano">Año*</label>
                    <input type="text" class="form-control form-control-sm numbersOnly" maxlength="4" id="Ano" name="Ano" required >
                </div>

                <div class="col-sm-3">
                    <label for="Sem">Fecha Inicio*</label>
                    <input type="text" class="form-control form-control-sm notEnter" id="FechaIni" name="FechaIni" required >
                </div>
                <div class="col-12 col-sm-3">
                    <label for="Sem">Días*</label>
                    <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" data-toggle="tooltip" data-placement="bottom" title="Capture el No. de días a tomar de cada semana" id="Dias" name="Dias" required >
                </div>
                <div class="col-12 col-sm-2">
                    <button type="button"  class="btn btn-primary btn-sm mt-4" id="btnGenerarSemanas" data-toggle="tooltip" data-placement="top" title="Generar Semanas" >
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <button type="button" class="btn btn-info btn-lg btn-float" id="btnGuardar" data-toggle="tooltip" data-placement="left" title="Guardar">
                    <i class="fa fa-save"></i>
                </button>

            </div>
        </form>
    </div>
</div>

<!--AGREGAR EXTRA-->
<div class="card border-0 m-3 d-none" id="ControlesAgregarExtras">
    <div class="card-body text-dark">
        <div class="row" >
            <div class="col-sm-3">
                <label for="Sem">Semana*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="Semana" name="Sem" required >
            </div>
            <div class="col-sm-3">
                <label for="Sem">Fecha Inicio*</label>
                <input type="text" class="form-control form-control-sm notEnter" id="FechaI" name="FechaIni" required >
            </div>
            <div class="col-sm-3">
                <label for="Sem">Fecha Fin*</label>
                <input type="text" class="form-control form-control-sm notEnter" id="FechaF" name="FechaFin" required >
            </div>
            <div class="col-sm-3">
                <br>
                <button type="button"  class="btn btn-primary btn-sm" id="btnAgregarSemExtra" data-toggle="tooltip" data-placement="top" title="Agregar Semanas Extra" >
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!--DETALLE-->
<div class="card d-none m-3" id="pnlDatosDetalle">
    <div class="card-body" >
        <!--DETALLE NUEVO-->
        <div class="row" >
            <div class="table-responsive" id="RegistrosDetalle">
                <table id="tblDetalle" class="table table-sm" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">Año</th>
                            <th scope="col">Semana</th>
                            <th scope="col">Fecha Inicio</th>
                            <th scope="col">Fecha Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>

        </div>
        <!--FIN DETALLE NUEVO-->
        <!--DETALLE EDITAR-->
        <div class="row">
            <div class="table-responsive d-none" id="RegistrosDetalleE">
                <table id="tblRegistrosDetalle" class="table table-sm" width="100%">
                    <thead>
                        <tr>
                            <th>No. Sem</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!--FIN DETALLE EDITAR-->
    </div>
</div>
<!--SCRIPT-->
<script>
    var master_url = base_url + 'index.php/SemanasProduccion/';
    var pnlDatos = $("#pnlDatos");
    var pnlDatosDetalle = $("#pnlDatosDetalle");
    var pnlTablero = $("#pnlTablero");
    var btnNuevo = $("#btnNuevo");
    var btnGuardar = pnlDatos.find("#btnGuardar");
    var btnCancelar = pnlDatos.find("#btnCancelar");
    var btnAgregarSemExtra = $("#btnAgregarSemExtra");
    var nuevo = true;
    var AnoI;
    /*DATATABLE GLOBAL*/
    var tblDetalleSemanasProduccion;
    var tblDetalleSemanasProduccionE = $('#tblRegistrosDetalle'), RegistrosDetalleE;
    var btnEliminar = $("#btnEliminar");
    var tblInicial = {
        "dom": 'rt',
        "autoWidth": false,
        "displayLength": 500,
        "colReorder": true,
        "bLengthChange": false,
        "deferRender": true,
        "scrollY": 320,
        "scrollCollapse": true,
        "bSort": true,
        "aaSorting": [
            [1, 'asc']/*ID*/
        ],
        initComplete: function (x, y) {
            HoldOn.close();
        }
    };
    var FechaIni;
    $(document).ready(function () {
        pnlDatos.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2016 || parseInt($(this).val()) > 2020) {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    pnlDatos.find("#Ano").val("");
                    pnlDatos.find("#Ano").focus();
                });
            } else {
                $.ajax({
                    url: master_url + 'onValidarExisteAno',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        Ano: $(this).val()
                    }
                }).done(function (data, x, jq) {
                    if (parseInt(data[0].EXISTE) > 0) {
                        pnlDatos.find("#Ano").val('');
                        swal({
                            title: "ATENCIÓN",
                            text: "LAS SEMANAS DE ESTE AÑO YA HAN SIDO GENERADAS",
                            icon: "warning"
                        }).then((action) => {
                            pnlDatos.find("#Ano").focus();
                        });
                    }
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                });
            }

        });
        pnlDatos.find("#Dias").change(function () {
            var diasCapturados = parseInt($(this).val());
            if (diasCapturados > 1 && diasCapturados < 7) {

            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "CANTIDAD DE DÍAS INCORRECTA (debe de ser entre 1 y 7 días)",
                    icon: "warning"
                }).then((action) => {
                    $(this).val('');
                    $(this).focus();

                });

            }
        });
        pnlDatos.find("#FechaIni").inputmask({alias: "date"});
        $('#ControlesAgregarExtras').find("#FechaI").inputmask({alias: "date"});
        $('#ControlesAgregarExtras').find("#FechaF").inputmask({alias: "date"});
        pnlDatos.find("#btnGenerarSemanas").click(function () {
            HoldOn.open({
                theme: "sk-bounce",
                message: "CARGANDO DATOS..."
            });
            if (pnlDatos.find("#Ano").val() !== '') {
                if (pnlDatos.find("#Dias").val() !== '') {
                    if (pnlDatosDetalle.find("#tblDetalle > tbody > tr").length > 0) {
                        HoldOn.close();
                        swal('Atención', 'Ya se han generado las semanas', 'warning');
                    } else {
                        var feC = pnlDatos.find("#FechaIni").val().split("/");
                        var feI = new Date(feC[2], feC[1] - 1, feC[0]);
                        var cont = 1;
                        var Sem = 1;
                        var esInicio = true;
                        var diasRestantes = 0;
                        var diasSemanaNatural = 7;
                        var diasSemana = parseInt(pnlDatos.find("#Dias").val());
                        tblDetalleSemanasProduccion = pnlDatosDetalle.find("#tblDetalle").DataTable(tblInicial);
                        while (cont <= 104) {
                            if (esInicio) {
                                //console.log('Sem: ' + Sem);
                                //console.log(convertDate(feI));
                                esInicio = false;
                            } else {
                                tblDetalleSemanasProduccion.row.add([
                                    pnlDatos.find("#Ano").val(),
                                    Sem,
                                    convertDate(feI),
                                    convertDate(feI.setDate(feI.getDate() + diasSemana))
                                ]).draw(false);
                                Sem++;
                                //console.log(convertDate(feI));
                                diasRestantes = diasSemanaNatural - diasSemana;
                                feI.setDate(feI.getDate() + diasRestantes);
                                esInicio = true;
                            }
                            cont++;
                        }
                        btnGuardar.focus();
                    }
                } else {
                    HoldOn.close();
                    swal({
                        title: "ATENCIÓN",
                        text: "DEBES INGRESAR LOS DÍAS DE LA SEMANA",
                        icon: "warning"
                    }).then((action) => {
                        pnlDatos.find("#Dias").focus();
                    });
                }
            } else {
                HoldOn.close();
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES INGRESAR UN AÑO",
                    icon: "warning"
                }).then((action) => {
                    pnlDatos.find("#Ano").focus();
                });
            }
        });
        btnGuardar.click(function () {
            HoldOn.open({
                theme: "sk-bounce",
                message: "CARGANDO DATOS..."
            });
            AnoI = pnlDatos.find("#Ano").val();
            isValid('pnlDatos');
            if (valido) {

                if (!nuevo) {

                } else {
                    var frm = new FormData(pnlDatos.find("#frmNuevo")[0]);
                    /*AGREGAR DETALLE*/
                    var detalle = [];
                    //Destruye la instancia de datatable
                    tblDetalleSemanasProduccion.destroy();
                    //Iteramos en la tabla natural
                    pnlDatosDetalle.find("#tblDetalle > tbody > tr").each(function (k, v) {
                        var row = $(this).find("td");
                        //Se declara y llena el objeto obteniendo su valor por el indice y se elimina cualquier espacio
                        var SemanasProduccion = {
                            Ano: row.eq(0).text().replace(/\s+/g, ''),
                            Sem: row.eq(1).text().replace(/\s+/g, ''),
                            FechaIni: row.eq(2).text().replace(/\s+/g, ''),
                            FechaFin: row.eq(3).text().replace(/\s+/g, '')
                        };
                        //Se mete el objeto al arreglo
                        detalle.push(SemanasProduccion);
                    });
                    //Convertimos a cadena el objeto en formato json
                    frm.append('Detalle', JSON.stringify(detalle));
                    $.ajax({
                        url: master_url + 'onAgregar',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data, x, jq) {
                        swal('INFO', 'SE HAN GENERADO LAS SEMANAS DE ESTE AÑO', 'success');
                        getRecords();
                        nuevo = false;
                        pnlDatos.find('#lAno').text(AnoI);
                        $('#ControlesEncabezado').addClass("d-none");
                        $('#RegistrosDetalle').addClass("d-none");
                        $('#ControlesAgregarExtras').removeClass("d-none");
                        $('#RegistrosDetalleE').removeClass("d-none");
                        getSemanasProduccionByAno(AnoI);
                        btnGuardar.addClass("d-none");
                        if (seg === 1) {
                            btnEliminar.removeClass('d-none');
                        }
                        HoldOn.close();
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    }).always(function () {

                    });
                }
            } else {
                onNotify('<span class="fa fa-times fa-lg"></span>', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'danger');
            }
        });
        btnNuevo.click(function () {
            if ($.fn.DataTable.isDataTable('#tblDetalle')) {
                tblDetalleSemanasProduccion.destroy();

            }
            pnlDatosDetalle.find("#tblDetalle > tbody").html("");
            if ($.fn.DataTable.isDataTable('#tblRegistrosDetalle')) {
                RegistrosDetalleE.clear().draw();
            }

            pnlTablero.addClass("d-none");
            pnlDatos.removeClass('d-none');
            pnlDatosDetalle.removeClass('d-none');
            $('#RegistrosDetalle').removeClass("d-none");
            $('#ControlesAgregarExtras').addClass("d-none");
            $('#RegistrosDetalleE').addClass("d-none");
            pnlDatos.find("input").val("");
            btnGuardar.removeClass("d-none");
            pnlDatos.find('#lAno').text('');
            $('#ControlesEncabezado').removeClass("d-none");
            pnlDatos.find('#Ano').focus();
            btnEliminar.addClass('d-none');
            nuevo = true;
        });
        btnCancelar.click(function () {
            $('#ControlesAgregarExtras').addClass("d-none");
            pnlTablero.removeClass("d-none");
            pnlDatosDetalle.addClass('d-none');
            pnlDatos.addClass('d-none');
        });
        btnAgregarSemExtra.click(function () {
            if ($('#ControlesAgregarExtras').find('#Semana').val() !== ''
                    && $('#ControlesAgregarExtras').find('#FechaI').val() !== ''
                    && $('#ControlesAgregarExtras').find('#FechaF').val() !== '') {
                $.ajax({
                    url: master_url + 'onAgregarExtra',
                    type: "POST",
                    data: {
                        Ano: temp,
                        Sem: $('#ControlesAgregarExtras').find('#Semana').val(),
                        FechaIni: $('#ControlesAgregarExtras').find('#FechaI').val(),
                        FechaFin: $('#ControlesAgregarExtras').find('#FechaF').val()
                    }
                }).done(function (data, x, jq) {
                    RegistrosDetalleE.ajax.reload();
                    $('#ControlesAgregarExtras').find('input').val('');
                    $('#ControlesAgregarExtras').find('#Semana').focus();
                    swal({
                        title: "INFO",
                        text: "SEMANA AGREGADA",
                        icon: 'success',
                        timer: 1500,
                        buttons: false,
                        closeOnEsc: false,
                        closeOnClickOutside: false
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
            } else {
                swal('ATENCION', 'DEBES COMPLETAR TODOS LOS CAMPOS', 'info');
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES COMPLETAR TODOS LOS CAMPOS",
                    icon: "info"
                }).then((action) => {
                    $('#ControlesAgregarExtras').find('#Semana').focus();
                    $('#ControlesAgregarExtras').find('#Semana').select();
                });
            }

        });
        btnEliminar.click(function () {
            if (temp !== 0 && temp !== undefined && temp > 0) {
                swal({
                    title: "Confirmar", text: "Deseas eliminar el registro?", icon: "warning", buttons: ["Cancelar", "Aceptar"]
                }).then((willDelete) => {
                    if (willDelete) {
                        HoldOn.open({
                            theme: "sk-bounce",
                            message: "CARGANDO DATOS..."
                        });
                        $.ajax({
                            url: master_url + 'onEliminar',
                            type: "POST",
                            data: {
                                Ano: temp
                            }
                        }).done(function (data, x, jq) {

                            pnlDatos.addClass("d-none");
                            pnlDatosDetalle.addClass("d-none");
                            pnlTablero.removeClass("d-none");
                            $('#ControlesAgregarExtras').addClass("d-none");
                            getRecords();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        }).always(function () {
                            HoldOn.close();
                        });
                    }
                });
            }
        });
        /*CALLS*/
        getRecords();
        handleEnter();
    });

    function validate(event, val) {
        if (((event.which !== 46 || (event.which === 46 && val === '')) || val.indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    }
    function onModificarSemanaXID(value, IDX) {
        $.ajax({
            url: master_url + 'onModificar',
            type: "POST",
            data: {
                ID: IDX,
                Sem: value === '' || value === null ? 0 : value
            }
        }).done(function (data, x, jq) {
            RegistrosDetalleE.ajax.reload();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function convertDate(inputFormat) {
        function pad(s) {
            return (s < 10) ? '0' + s : s;
        }
        var d = new Date(inputFormat);
        return [pad(d.getDate()), pad(d.getMonth() + 1), d.getFullYear()].join('/');
    }

    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: "sk-bounce",
            message: "CARGANDO DATOS..."
        });
        $.ajax({
            url: master_url + 'getRecords',
            type: "POST",
            dataType: "JSON"
        }).done(function (data, x, jq) {

            if (data.length > 0) {
                $("#tblRegistros").html(getTable('tblSemanasProduccion', data));
                $('#tblSemanasProduccion tfoot th').each(function () {
                    $(this).addClass('d-none');
                });
                var tblSelected = $('#tblSemanasProduccion').DataTable(tableOptions);
                $('#tblSemanasProduccion_filter input[type=search]').focus();

                $('#tblSemanasProduccion tbody').on('click', 'tr', function () {
                    $("#tblSemanasProduccion tbody tr").removeClass("success");
                    $(this).addClass("success");
                    var id = this.id;
                    var index = $.inArray(id, selected);
                    if (index === -1) {
                        selected.push(id);
                    } else {
                        selected.splice(index, 1);
                    }
                    var dtm = tblSelected.row(this).data();
                    temp = parseInt(dtm[0]);
                    if (temp !== 0 && temp !== undefined && temp > 0) {
                        nuevo = false;
                        HoldOn.open({
                            theme: "sk-bounce",
                            message: "CARGANDO DATOS..."
                        });
                        $.ajax({
                            url: master_url + 'getSemanaProduccionByAno',
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                Ano: temp
                            }
                        }).done(function (data, x, jq) {
                            var dtm = data[0];
                            pnlDatos.find("input").val("");
                            pnlDatos.find('#lAno').text(dtm.Ano);
                            getSemanasProduccionByAno(temp);
                            pnlDatosDetalle.removeClass('d-none');
                            $('#ControlesEncabezado').addClass("d-none");
                            $('#RegistrosDetalle').addClass("d-none");
                            $('#RegistrosDetalleE').removeClass("d-none");
                            $('#ControlesAgregarExtras').removeClass("d-none");
                            $('#Semana').focus();
                            pnlTablero.addClass("d-none");
                            pnlDatos.removeClass('d-none');
                            btnGuardar.addClass("d-none");
                            if (seg === 1) {
                                btnEliminar.removeClass('d-none');
                            }
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        }).always(function () {
                            HoldOn.close();
                        });
                    } else {
                        onNotify('<span class="fa fa-exclamation fa-lg"></span>', 'DEBE DE ELEGIR UN REGISTRO', 'danger');
                    }
                });
                // Apply the search
                tblSelected.columns().every(function () {
                    var that = this;
                    $('input', this.footer()).on('keyup change', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
            } else {
                $("#tblRegistros").html('<div class="col-12 my-4"><center><h3>NO EXISTEN SEMANAS GENERADAS</h3></center></div>');
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getSemanasProduccionByAno(Ano) {
        tblDetalleSemanasProduccionE.DataTable().destroy();
        RegistrosDetalleE = tblDetalleSemanasProduccionE.DataTable({
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getSemanasProduccionByAno',
                "dataType": "json",
                "dataSrc": "",
                type: "POST",
                "data": {
                    Ano: Ano
                }
            },
            "columns": [
                {"data": "NoSem"},
                {"data": "FechaInicio"},
                {"data": "FechaFin"}
            ],
            "dom": 'rt',
            "autoWidth": true,
            "displayLength": 500,
            "colReorder": true,
            "bLengthChange": false,
            "deferRender": true,
            "scrollY": 320,
            "scrollCollapse": true,
            "bSort": true,
            "aaSorting": [
                [0, 'asc']/*ID*/
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "width": "10%"
                }
            ],
            initComplete: function (x, y) {
                HoldOn.close();
            }
        });

    }

</script>





