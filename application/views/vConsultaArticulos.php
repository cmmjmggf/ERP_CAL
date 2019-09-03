<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Consulta de Artículos</legend>
            </div>
            <div class="col-sm-4 float-right">
                <label for="" >Grupo</label>
                <select id="Grupo" name="Grupo" class="form-control form-control-sm required" required="" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-sm-2 float-right" align="right">
                <button type="button" class="btn btn-warning btn-sm" id="btnImprimir" >
                    <span class="fa fa-file-pdf" ></span> IMPRIMIR
                </button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Articulos" class="table-responsive">
                <table id="tblArticulos" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Grupo</th>
                            <th>Clave</th>
                            <th>Descripción</th>
                            <th>Unidad</th>
                            <th>Prov 1</th>
                            <th>Prov 2</th>
                            <th>Prov 3</th>
                            <th>Ubic 1</th>
                            <th>Ubic 2</th>
                            <th>Ubic 3</th>
                            <th>Ubic 4</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal " id="mdlConsultaArticulos"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Consulta General de Materiales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-6" >
                            <label for="" >Del Grupo</label>
                            <select id="dGrupo" name="dGrupo" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6" >
                            <label for="" >Al Grupo</label>
                            <select id="aGrupo" name="aGrupo" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                            </select>
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
    var master_url = base_url + 'index.php/ConsultaArticulos/';
    var tblArticulos = $('#tblArticulos');
    var pnlTablero = $('#pnlTablero');
    var Articulos;

    var mdlConsultaArticulos = $('#mdlConsultaArticulos');


    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();
        handleEnter();

        pnlTablero.find('#Grupo').on("change", function () {
            getRecords($(this).val());
        });

        pnlTablero.find('#btnImprimir').on("click", function () {
            mdlConsultaArticulos.modal('show');
        });

        mdlConsultaArticulos.on('shown.bs.modal', function () {
            $.each(mdlConsultaArticulos.find("select"), function (k, v) {
                mdlConsultaArticulos.find("select")[k].selectize.clear(true);
            });
            mdlConsultaArticulos.find('#dGrupo')[0].selectize.focus();
            mdlConsultaArticulos.find('#dGrupo')[0].selectize.open();
        });

        mdlConsultaArticulos.find('#btnAceptar').on("click", function () {

            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlConsultaArticulos.find("#frmCaptura")[0]);


            $.ajax({
                url: base_url + 'index.php/ReportesMaterialesJasper/onReporteConsultaArticulos',
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
                                    width: "95%",
                                    height: "95%"
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
                        mdlConsultaArticulos.find('#aGrupo')[0].selectize.focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });

        });

    });

    function init() {
        getRecords('');
        getGrupos();
    }

    function getGrupos() {
        $.getJSON(base_url + 'index.php/DocDirecConAfectacion/getGrupos').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Grupo")[0].selectize.addOption({text: v.Grupo, value: v.ID});
                mdlConsultaArticulos.find("#dGrupo")[0].selectize.addOption({text: v.Grupo, value: v.ID});
                mdlConsultaArticulos.find("#aGrupo")[0].selectize.addOption({text: v.Grupo, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getRecords(grupo) {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblArticulos')) {
            tblArticulos.DataTable().destroy();
        }
        Articulos = tblArticulos.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "data": {
                    Grupo: grupo
                },
                "type": "POST",
                "dataSrc": ""
            },

            "columns": [
                {"data": "ID"},
                {"data": "Grupo"},
                {"data": "Clave"},
                {"data": "Descripcion"},
                {"data": "Unidad"},
                {"data": "P1"},
                {"data": "P2"},
                {"data": "P3"},
                {"data": "U1"},
                {"data": "U2"},
                {"data": "U3"},
                {"data": "U4"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong text-info');
                            break;
                        case 1:
                            /*FECHA ENTREGA*/
                            c.addClass('text-success text-strong');
                            break;
                        case 2:
                            /*fecha conf*/
                            c.addClass('text-strong');
                            break;
                        case 3:
                            /*fecha conf*/
                            c.addClass('text-strong text-warning');
                            break;
                    }
                });
            },
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 20,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [1, 'desc']/*ID*/
            ],
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        $('#tblArticulos_filter input[type=search]').focus();

    }

</script>
<style>
    .selectize-input {
        border: 1px solid #9E9E9E;
    }
    .form-control {
        border: 1px solid #9E9E9E;
    }
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

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>
