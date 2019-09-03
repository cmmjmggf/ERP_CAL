<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Existencias SUELA/ENTRESUELA/PLANTA</legend>
            </div>
            <div class="col-sm-4" align="right">
                <button type="button" class="btn btn-info btn-sm " id="btnVerArticulos" >
                    <span class="fa fa-cube" ></span> ARTICULOS
                </button>
                <button type="button" class="btn btn-warning btn-sm " id="btnImprimirInv" >
                    <span class="fa fa-file-pdf" ></span> IMPRIMIR KARDEX
                </button>
            </div>
        </div>
        <div class="row" id="Encabezado">
            <div class="col-12 col-sm-5 col-md-5 col-xl-4" >
                <label for="" >Suela/Entresuela/Planta</label>
                <select id="ArticuloCBZ" name="ArticuloCBZ" class="form-control form-control-sm required" required="" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-12 col-sm-3 col-md-4 col-xl-6" >

            </div>
            <div class="col-12 col-sm-4 col-md-3 col-xl-2">
                <label for="" >Mes</label>
                <select id="Mes" name="Mes" class="form-control form-control-sm selectNotEnter" >
                    <option value=""></option>
                    <option value="1">1 ENERO</option>
                    <option value="2">2 FEBRERO</option>
                    <option value="3">3 MARZO</option>
                    <option value="4">4 ABRIL</option>
                    <option value="5">5 MAYO</option>
                    <option value="6">6 JUNIO</option>
                    <option value="7">7 JULIO</option>
                    <option value="8">8 AGOSTO</option>
                    <option value="9">9 SEPTIEMBRE</option>
                    <option value="10">10 OCTUBRE</option>
                    <option value="11">11 NOVIEMBRE</option>
                    <option value="12">12 DICIEMBRE</option>
                </select>
            </div>
        </div>

        <center><span for="" class="badge badge-info mt-3">Artículos que componen el cabecero</span></center>


        <div class="card-block mt-2">
            <div id="ExistenciasSuelas">
                <table id="tblExistenciasSuelas" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Clave</th>
                            <th>Descripcion</th>
                            <th>Existencia</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/ExistenciasSuelasPlantas/';
    var pnlTablero = $("#pnlTablero");
    var tblExistenciasSuelas = $('#tblExistenciasSuelas');
    var btnVerArticulos = pnlTablero.find('#btnVerArticulos');
    var ExistenciasSuelas;
    $(document).ready(function () {

        btnVerArticulos.click(function () {
            $.fancybox.open({
                src: base_url + '/Articulos/?origen=MATERIALES',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
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
        });

        /*FUNCIONES INICIALES*/
        validacionSelectPorContenedor(pnlTablero);
        handleEnter();
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        getCabeceros();
        pnlTablero.find("#ArticuloCBZ").change(function () {

            var mes = pnlTablero.find("#Mes").val();
            getRecords($(this).val(), mes);
        });

        pnlTablero.find("#Mes").change(function () {
            var art = pnlTablero.find("#ArticuloCBZ").val();
            getRecords(art, $(this).val());
        });

    });

    function getRecords(Art, Mes) {
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblExistenciasSuelas')) {
            tblExistenciasSuelas.DataTable().destroy();
        }
        ExistenciasSuelas = tblExistenciasSuelas.DataTable({
            "dom": 'rtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "data": {Articulo: Art, Mes: Mes},
                "type": "POST"
            },
            "columns": [
                {"data": "Clave"},
                {"data": "Articulo"},
                {"data": "Existencia"}
            ],

            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 15,
            "scrollX": true,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc'], [1, 'asc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 1:
                            /*FECHA ENTREGA*/
                            c.addClass('text-success text-strong');
                            break;

                        case 2:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;

                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblExistenciasSuelas.find('tbody').on('click', 'tr', function () {
            tblExistenciasSuelas.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }

    function getCabeceros() {
        HoldOn.open({theme: 'sk-bounce', message: 'INCIALIZANDO DATOS...'});
        $.when($.getJSON(master_url + 'getCabeceros').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#ArticuloCBZ")[0].selectize.addOption({text: v.Material, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        })).then(function (x) {
            HoldOn.close();
            pnlTablero.find("#ArticuloCBZ")[0].selectize.focus();
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

    span.badge{
        font-size: 100% !important;
    }
</style>



