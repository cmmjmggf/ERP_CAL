<div id="pnlTablero">
    <div class="card m-3" >
        <div class="card-body ">
            <div class="row">
                <div class="col-sm-6 float-left">
                    <legend class="float-left">Mat. Fijos Ficha Técnicas</legend>
                </div>
            </div>

            <form id="frmNuevo">
                <div class="row">
                    <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-3">
                        <label for="" >Pieza*</label>
                        <select id="Pieza" name="Pieza" class="form-control form-control-sm required" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-3">
                        <label for="" >Grupo</label>
                        <select id="Grupo" name="Grupo" class="form-control form-control-sm" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-3">
                        <label for="" >Artículo*</label>
                        <select id="Articulo" name="Articulo" class="form-control form-control-sm required" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-lg-2 col-xl-1">
                        <label for="Consumo">Consumo*</label>
                        <input type="text" maxlength="8" class="form-control form-control-sm numbersOnly" id="Consumo" name="Consumo" required="">
                    </div>
                    <button type="button" class="btn btn-info btn-lg btn-float" id="btnGuardar" data-toggle="tooltip" data-placement="left" title="Guardar">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
                <div class="row pt-2">
                    <div class="col-6 col-md-6 ">
                        <h6 class="text-danger">Los campos con * son obligatorios</h6>
                    </div>
                </div>
            </form>


        </div>
    </div>
    <div class="card m-3">
        <div class="card-body ">
            <div class="row">
                <div id="FichaTecnicaFijos" class="table-responsive">
                    <table id="tblFichaTecnicaFijos" class="table table-sm " style="width:100%">
                        <thead>
                            <tr>
                                <th>Pieza</th>
                                <th>Material</th>
                                <th>Departamento</th>
                                <th>Grupo</th>
                                <th>Grupo_ID</th>
                                <th>Consumo</th>
                                <th>Unidad</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Total General:</th>
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
</div>

<script>
    var master_url = base_url + 'index.php/FichaTecnicaFija/';
    var tblFichaTecnicaFijos = $('#tblFichaTecnicaFijos');
    var FichaTecnicaFijos;
    var btnNuevo = $("#btnNuevo");
    btnCancelar = $("#btnCancelar");
    btnEliminar = $("#btnEliminar");
    btnGuardar = $("#btnGuardar");
    var pnlTablero = $("#pnlTablero");
    var nuevo = false;

    $(document).ready(function () {



        /*FUNCIONES INICIALES*/
        init();
        handleEnter();
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToSelectOnChange('#Pieza', '#Grupo', pnlTablero);
        setFocusSelectToSelectOnChange('#Grupo', '#Articulo', pnlTablero);
        setFocusSelectToInputOnChange('#Articulo', '#Consumo', pnlTablero);
        /*FUNCIONES X BOTON*/
        btnGuardar.click(function () {
            isValid('pnlTablero');
            if (valido) {
                var frm = new FormData(pnlTablero.find("#frmNuevo")[0]);
                $.ajax({
                    url: master_url + 'onAgregar',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    limpiarCampos();
                    FichaTecnicaFijos.ajax.reload();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });

            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });
        pnlTablero.find("[name='Grupo']").change(function () {
            pnlTablero.find("[name='Articulo']")[0].selectize.clear(true);
            pnlTablero.find("[name='Articulo']")[0].selectize.clearOptions();
            getArticulos($(this).val());
        });
    });
    function limpiarCampos() {
        pnlTablero.find("input").val("");
        pnlTablero.find("[name='Pieza']")[0].selectize.clear(true);
        pnlTablero.find("[name='Grupo']")[0].selectize.clear(true);
        pnlTablero.find("[name='Articulo']")[0].selectize.clear(true);
        pnlTablero.find("[name='Articulo']")[0].selectize.clearOptions();
        pnlTablero.find("[name='Pieza']")[0].selectize.focus();
    }
    function init() {
        getRecords();
        getPiezas();
        getGrupos();
    }



    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblFichaTecnicaFijos')) {
            tblFichaTecnicaFijos.DataTable().destroy();
        }
        FichaTecnicaFijos = tblFichaTecnicaFijos.DataTable({
            "dom": 'frtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": ""
            },
            "columns": [
                {"data": "Pieza"},
                {"data": "Material"},
                {"data": "Departamento"},
                {"data": "Grupo"},
                {"data": "GID"},
                {"data": "Consumo"},
                {"data": "Unidad"},
                {"data": "Eliminar"}
            ],
            "columnDefs": [
                {
                    "targets": [3],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [4],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 40,
            "scrollX": true,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "order": [[4, 'asc']],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 2:
                            /*DEPTO*/
                            c.addClass('text-info');
                            break;
                        case 3:
                            /*UNIDAD*/
                            c.addClass('text-strong');
                            break;
                        case 4:
                            /*UNIDAD*/
                            c.addClass('text-success');
                            break;

                    }
                });
            },
            rowGroup: {
                endRender: function (rows, group) {
                    var stc = $.number(rows.data().pluck('Consumo').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    return $('<tr class="SubTotales">').append('<td></td><td></td><td colspan="1" >Total de: ' + group + '</td>').append('<td>' + stc + '</td><td></td><td></td></tr>');
                },
                dataSrc: "Grupo"
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();

                /*TOTAL CONSUMO*/
                var TotalC = api.column(5).data().reduce(function (a, b) {
                    return (a) + (b);
                }, 0);
                $(api.column(5).footer()).html(api.column(5, {page: 'current'}).data().reduce(function (a, b) {
                    return $.number(TotalC, 2, '.', ', ');
                }, 0));
            },
            initComplete: function (a, b) {
                HoldOn.close();
                $.each(pnlTablero.find("select"), function (k, v) {
                    pnlTablero.find("select")[k].selectize.clear(true);
                });
                pnlTablero.find("input").val("");
                pnlTablero.find("[name='Pieza']")[0].selectize.focus();
            }
        });
        tblFichaTecnicaFijos.find('tbody').on('click', 'tr', function () {
            tblFichaTecnicaFijos.find("tbody tr").removeClass("success");
            $(this).addClass("success");

        });

    }
    function onEliminar(IDP, IDM) {
        swal({
            title: "¿Estas seguro?",
            text: "Nota: Esta Acción ya no se puede revertir",
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
                    $.post(master_url + 'onEliminar', {IDP: IDP, IDM: IDM}).done(function () {
                        FichaTecnicaFijos.ajax.reload();
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
    }
    function getPiezas() {
        $.ajax({
            url: master_url + 'getPiezas',
            type: "POST",
            dataType: "JSON"
        }).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlTablero.find("[name='Pieza']")[0].selectize.addOption({text: v.Pieza, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }
    function getArticulos(Grupo) {
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.ajax({
            url: master_url + 'getArticulos',
            type: "POST",
            dataType: "JSON",
            data: {
                Grupo: Grupo
            }
        }).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlTablero.find("[name='Articulo']")[0].selectize.addOption({text: v.Articulo, value: v.ID});
            });
            HoldOn.close();
            pnlTablero.find("[name='Articulo']")[0].selectize.open();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }
    function getGrupos() {
        $.ajax({
            url: master_url + 'getGrupos',
            type: "POST",
            dataType: "JSON"
        }).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlTablero.find("[name='Grupo']")[0].selectize.addOption({text: v.Grupo, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
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
</style>