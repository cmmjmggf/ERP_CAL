<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5 float-left">
                <legend >Edición de Órdenes de Compra ACTIVAS</legend>
            </div>
            <div class="col-sm-7 float-right" align="right">
                <button type="button" class="btn btn-warning btn-sm" id="btnLimpiarFiltros"><i class="fa fa-trash"></i> Limpiar Filtros</button>

            </div>
        </div>
        <hr>
        <div class="row" id="pnlValidacion">

            <div class="col-1">
                <label class="">Año</label>
                <input type="text" class="form-control form-control-sm numbersOnly" required="" maxlength="4" id="Ano" name="Ano"   >
            </div>
            <div class="col-1">
                <label class="">Maq</label>
                <input type="text" class="form-control form-control-sm numbersOnly" required="" maxlength="2" id="Maq" name="Maq"   >
            </div>
            <div class="col-1">
                <label class="">Sem</label>
                <input type="text" class="form-control form-control-sm numbersOnly" required="" maxlength="2" id="Sem" name="Sem"   >
            </div>
            <div class="col-12 col-sm-5 col-md-2 col-lg-1 col-xl-1">
                <label for="Proveedor" >Proveedor</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="Proveedor" name="Proveedor"  placeholder="">
            </div>
            <div class="col-3" >
                <label for="" >-</label>
                <select id="sProveedor" name="sProveedor" class="form-control form-control-sm  NotSelectize notEnter selectNotEnter" >
                    <option value=""></option>
                    <?php
                    foreach ($this->db->select("C.Clave AS CLAVE, concat(C.NombreF) AS PROVEEDOR ", false)
                            ->from('PROVEEDORES AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('PROVEEDOR', 'ASC')->get()->result() as $k => $v) {
                        print "<option value='{$v->CLAVE}'>{$v->PROVEEDOR}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <hr>
        <!--Tabla-->
        <div id="Registros" class="datatable-wide">
            <table id="tblRegistros" class="table table-sm display " style="width:100%">
                <thead>
                    <tr>
                        <th>Tp</th>
                        <th>Proveedor</th>
                        <th>Folio</th>
                        <th>Año</th>
                        <th>Semana</th>
                        <th>Maquila</th>
                        <th>Fec-Ent</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<div class="dropdown-menu" style="font-size: 12px;" id='menu'>
    <a class="dropdown-item text-primary" href="#" onclick="onModificarRenglon()"><i class="fa fa-pencil-alt"></i> Modificar</a>
</div>
<div class="modal " id="mdlEditarRenglon"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica Órden de Compra Activa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-4">
                            <label for="Clave" >Fecha Entrega</label>
                            <input type="text" class="form-control form-control-sm date notEnter"  id="FechaEntrega" name="FechaEntrega">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="Clave" >Año</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="4" id="Ano" name="Ano">
                        </div>
                        <div class="col-2">
                            <label for="Clave" >Sem</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="Sem" name="Sem">
                        </div>
                        <div class="col-2">
                            <label for="Clave" >Maq</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="Maq" name="Maq">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-4">
                            <label class="badge badge-danger" style="font-size: 14px;">Nota: Sólo capture los campos que se van a modificar</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptar">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/ModificaOrdenCompra/';
    var pnlTablero = $("#pnlTablero");
    var tblRegistros = $('#tblRegistros');
    var Registros;

    $(document).ready(function () {
        init();
        handleEnterDiv(pnlTablero);
        /*Funciones modal*/
        $('#mdlEditarRenglon').on('shown.bs.modal', function () {
            handleEnterDiv($('#mdlEditarRenglon'));
            $('#mdlEditarRenglon').find("input").val("");
            $('#mdlEditarRenglon').find('#FechaEntrega').focus();
        });
        $('#mdlEditarRenglon').find("#btnAceptar").click(function () {

            swal({
                buttons: ["Cancelar", "Aceptar"],
                title: 'Estás Seguro?',
                text: "Esta acción no se puede revertir",
                icon: "warning",
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then((action) => {
                if (action) {
                    var ids_renglones = [];
                    $.each(tblRegistros.find("tbody tr.selected"), function (k, v) {
                        var r = Registros.row($(this)).data();
                        ids_renglones.push({
                            TP: r.Tp,
                            Folio: r.Folio,
                            Proveedor: r.Proveedor
                        });
                    });
                    var f = new FormData();
                    f.append('FechaEntrega', $('#mdlEditarRenglon').find("#FechaEntrega").val());
                    f.append('Ano', $('#mdlEditarRenglon').find("#Ano").val());
                    f.append('Sem', $('#mdlEditarRenglon').find("#Sem").val());
                    f.append('Maq', $('#mdlEditarRenglon').find("#Maq").val());
                    f.append('renglones', JSON.stringify(ids_renglones));
                    $.ajax({
                        url: '<?php print base_url('ModificaOrdenCompra/onModificarEnMasa'); ?>',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: f
                    }).done(function (data, x, jq) {
                        console.log(data);
                        swal({
                            title: 'INFO',
                            text: 'SE HAN MODIFICADO LOS DATOS CORRECTAMENTE',
                            icon: 'success'
                        }).then((action) => {
                            Registros.ajax.reload();
                            $('#mdlEditarRenglon').modal('hide');
                        });
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            });

        });

        pnlTablero.find('#Registros').on("contextmenu", function (e) {
            e.preventDefault();
            var top = e.pageY - 40;
            var left = e.pageX;
            $("#menu").css({
                display: "block",
                top: top,
                left: left
            });
            return false; //blocks default Webbrowser right click menu
        });
        $(document).click(function () {
            $("#menu").hide();
        });
        pnlTablero.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    Registros.column(3).search('', true, false).draw();
                    pnlTablero.find("#Ano").val("");
                    pnlTablero.find("#Ano").focus();
                });
            } else {
                Registros.column(3).search('^' + $(this).val() + '$', true, false).draw();
            }
        });
        pnlTablero.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
        pnlTablero.find("#Sem").keydown(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var ano = pnlTablero.find("#Ano");
                    onComprobarSemanasProduccion($(this), ano.val());
                }
            }

        });
        pnlTablero.find('#Proveedor').keydown(function (e) {
            if (e.keyCode === 13) {
                var txtProveedor = $(this).val();
                if (txtProveedor) {
                    $.getJSON(master_url + 'onVerificarProveedor', {Proveedor: txtProveedor}).done(function (data) {
                        if (data.length > 0) {
                            Registros.column(1).search('^' + txtProveedor + '$', true, false).draw();
                            pnlTablero.find("#sProveedor")[0].selectize.addItem(txtProveedor, true);
                        } else {
                            swal('ERROR', 'EL PROVEEDOR CAPTURADO NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sProveedor")[0].selectize.clear(true);
                                pnlTablero.find('#Proveedor').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                } else {
                    Registros.column(1).search('', true, false).draw()
                }
            }
        });
        pnlTablero.find("#sProveedor").change(function () {
            if ($(this).val()) {
                pnlTablero.find('#Proveedor').val($(this).val());
                Registros.column(1).search('^' + $(this).val() + '$', true, false).draw();
            } else {
                Registros.column(1).search('', true, false).draw();
            }
        });
        pnlTablero.find('#btnLimpiarFiltros').click(function () {
            pnlTablero.find("input").val("");
            $.each(pnlTablero.find("select"), function (k, v) {
                pnlTablero.find("select")[k].selectize.clear(true);
            });
            Registros.columns().search('').draw();
            pnlTablero.find("#Ano").focus().select();
        });

    });
    function getRegistros() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblRegistros')) {
            tblRegistros.DataTable().destroy();
        }
        Registros = tblRegistros.DataTable({
            "dom": 'frt', buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,

            "ajax": {
                "url": master_url + 'getRegistros',
                "dataSrc": "",
                "type": "GET"
            },
            "columns": [
                {"data": "Tp"},
                {"data": "Proveedor"},
                {"data": "Folio"},
                {"data": "Ano"},
                {"data": "Sem"},
                {"data": "Maq"},
                {"data": "FechaEntrega"}
            ],
            select: true,
            keys: true,
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "scrollX": true,
            "scrollY": 450,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
        });
    }
    function init() {
        pnlTablero.find('select').selectize({
            openOnFocus: false
        });
        getRegistros();
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        var d = new Date();
        pnlTablero.find("#Ano").val(d.getFullYear()).focus().select();
    }
    function onComprobarMaquilas(v) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {
                Registros.column(5).search('^' + $(v).val() + '$', true, false).draw();
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA MAQUILA " + $(v).val() + " NO ES VALIDA",
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
                            Registros.column(5).search('', true, false).draw();
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
    function onComprobarSemanasProduccion(v, ano) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
                Registros.column(4).search('^' + $(v).val() + '$', true, false).draw();
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
                            Registros.column(4).search('', true, false).draw();
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
    function onModificarRenglon() {
        var renglones_seleccionados = Registros.rows('.selected').data().length;
        if (renglones_seleccionados > 0) {
            $('#mdlEditarRenglon').modal('show');
        } else {
            swal('ATENCIÓN', 'NO HA SELECCIONADO NINGÚN REGISTRO', 'warning');
        }
    }
</script>