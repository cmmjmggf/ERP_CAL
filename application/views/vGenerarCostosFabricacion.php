<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Costeo inventarios</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-primary btn-sm " id="btnVerFichaTecnica" >
                    <span class="fa fa-search" ></span> FICHA TÉCNICA
                </button>
                <button type="button" class="btn btn-secondary btn-sm " id="btnVerFracciones" >
                    <span class="fa fa-search" ></span> FRACCIONES
                </button>
                <button type="button" class="btn btn-danger btn-sm " id="btnVerEstilos" >
                    <span class="fa fa-search" ></span> ESTILOS
                </button>
                <button type="button" class="btn btn-warning btn-sm " id="btnVerColores" >
                    <span class="fa fa-search" ></span> COLORES
                </button>
                <button type="button" class="btn btn-success btn-sm " id="btnGeneraCostosFabric" >
                    <span class="fa fa-dollar-sign" ></span> GENERA COSTOS
                </button>
            </div>
        </div>
        <hr>
        <div class="row" id="Gastos">
            <div class="col-2 mt-3">
                <label class="badge badge-danger" style="font-size: 15px;">Gastos de Fabricación</label>
            </div>
            <div class="col-1">
                <label class="">Corte</label>
                <input type="text" class="form-control form-control-sm numbersOnly azul" maxlength="5" id="corte" name="corte"   >
            </div>
            <div class="col-1">
                <label class="">Pesp</label>
                <input type="text" class="form-control form-control-sm numbersOnly azul" maxlength="5" id="pespu" name="pespu"   >
            </div>
            <div class="col-1">
                <label class="">Tejido</label>
                <input type="text" class="form-control form-control-sm numbersOnly azul" maxlength="5" id="tejido" name="tejido"   >
            </div>
            <div class="col-1">
                <label class="">Mont</label>
                <input type="text" class="form-control form-control-sm numbersOnly azul" maxlength="5" id="montado" name="montado"   >
            </div>
            <div class="col-1">
                <label class="">Adorno</label>
                <input type="text" class="form-control form-control-sm numbersOnly azul" maxlength="5" id="adorno" name="adorno"   >
            </div>
            <div class="col-1">
                <label class="">Total</label>
                <input type="text" class="form-control form-control-sm numbersOnly azul notSum" readonly="" maxlength="5" id="total" name="total"   >
            </div>
        </div>
        <div class="card-block">
            <div class="table-responsive" id="CosteaInventariosProceso">
                <table id="tblCosteaInventariosProceso" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Maq</th>
                            <th>Estilo</th>
                            <th>Color</th>
                            <th></th>
                            <th class="text-info">Corte</th>
                            <th class="text-info">Pespu</th>
                            <th class="text-info">Tejido</th>
                            <th class="text-info">Monta</th>
                            <th class="text-info">Adorn</th>
                            <th class="text-danger">Ma-Pr</th>
                            <th class="text-success">Corte</th>
                            <th class="text-success">Pespu</th>
                            <th class="text-success">Tejido</th>
                            <th class="text-success">Monta</th>
                            <th class="text-success">Adorn</th>
                            <th class="text-danger">Ma-Ob</th>
                            <th class="text-danger">Termin</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--SCRIPT-->
<script>
    var master_url = base_url + 'index.php/GenerarCostosFabricacion/';
    var pnlTablero = $("#pnlTablero");
    var btnGeneraCostosFabric = $("#btnGeneraCostosFabric");

    var btnVerFichaTecnica = $('#btnVerFichaTecnica');
    var btnVerFracciones = $('#btnVerFracciones');
    var btnVerEstilos = $('#btnVerEstilos');
    var btnVerColores = $('#btnVerColores');


    $(document).ready(function () {
        handleEnterDiv(pnlTablero);
        getGastosFab();
        getRecords();

        btnVerColores.click(function () {
            $.fancybox.open({
                src: base_url + '/Colores.shoes/?origen=PRODUCCION',
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

        btnVerEstilos.click(function () {
            $.fancybox.open({
                src: base_url + '/Estilos.shoes/?origen=PRODUCCION',
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

        btnVerFracciones.click(function () {
            $.fancybox.open({
                src: base_url + '/FraccionesXEstilo.shoes/?origen=PRODUCCION',
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

        btnVerFichaTecnica.click(function () {
            $.fancybox.open({
                src: base_url + '/FichaTecnica.shoes/?origen=PRODUCCION',
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

        pnlTablero.find("#Gastos").find('input').blur(function () {
            suma();
        });

        btnGeneraCostosFabric.click(function () {

            swal({
                title: "¿Estás seguro?",
                text: "Nota: Esta acción no se puede revertir",
                icon: "warning",
                closeOnClickOutside: false,
                closeOnEsc: false,
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
                        var corte = pnlTablero.find('#corte').val();
                        var pespu = pnlTablero.find('#pespu').val();
                        var tejido = pnlTablero.find('#tejido').val();
                        var montado = pnlTablero.find('#montado').val();
                        var adorno = pnlTablero.find('#adorno').val();
                        HoldOn.open({theme: "sk-bounce", message: "GENERANDO COSTOS,POR FAVOR ESPERE..."});
                        $.getJSON(master_url + 'onGenerarCostosInventarioProceso', {
                            corte: corte,
                            pespu: pespu,
                            tejido: tejido,
                            montado: montado,
                            adorno: adorno
                        }).done(function (data, x, jq) {
                            console.log(data);
                            HoldOn.close();
                            if (data.pedidos === 0) {
                                swal('ATENCIÓN', 'No existen estilos en producción para costear', 'error').then((value) => {
                                });
                            } else {
                                if (data.fichatecnica.length > 0) {
                                    swal('ATENCIÓN', 'Los siguientes estilos no tienen Ficha Técnica \n' + data.fichatecnica, 'error').then((value) => {
                                        if (data.fracciones.length > 0) {
                                            swal('ATENCIÓN', 'Los siguientes estilos no tienen Fracciones capturadas \n' + data.fracciones, 'error').then((value) => {
                                                swal('ATENCIÓN', 'SE HAN GENERADO LOS COSTOS ', 'success').then((value) => {
                                                    CosteaInventariosProceso.ajax.reload();
                                                });
                                            });
                                        } else {
                                            swal('ATENCIÓN', 'SE HAN GENERADO LOS COSTOS ', 'success').then((value) => {
                                                CosteaInventariosProceso.ajax.reload();
                                            });
                                        }
                                    });
                                } else {
                                    if (data.fracciones.length > 0) {
                                        swal('ATENCIÓN', 'Los siguientes estilos no tienen Fracciones capturadas \n' + data.fracciones, 'error').then((value) => {
                                            swal('ATENCIÓN', 'SE HAN GENERADO LOS COSTOS ', 'success').then((value) => {
                                                CosteaInventariosProceso.ajax.reload();
                                            });
                                        });
                                    } else {
                                        swal('ATENCIÓN', 'SE HAN GENERADO LOS COSTOS ', 'success').then((value) => {
                                            CosteaInventariosProceso.ajax.reload();
                                        });
                                    }
                                }
                            }


                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                            HoldOn.close();
                        });
                    case "cancelar":
                        swal.close();
                        break;
                }
            });
        });

    });
    var tblCosteaInventariosProceso = $('#tblCosteaInventariosProceso');
    var CosteaInventariosProceso;
    function getRecords() {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblCosteaInventariosProceso')) {
            tblCosteaInventariosProceso.DataTable().destroy();
        }
        CosteaInventariosProceso = tblCosteaInventariosProceso.DataTable({
            "dom": 'frtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataType": "json",
                "type": 'POST',
                "dataSrc": ""
            },
            "columns": [
                {"data": "maq"},
                {"data": "estilo"},
                {"data": "color"},
                {"data": "nomcol"},

                {"data": "mapcte"},
                {"data": "mappes"},
                {"data": "maptej"},
                {"data": "mapmon"},
                {"data": "mapado"},
                {"data": "tomap"},

                {"data": "mdocte"},
                {"data": "mdopes"},
                {"data": "mdotej"},
                {"data": "mdomon"},
                {"data": "mdoado"},
                {"data": "tomdo"},

                {"data": "termi"},
                {"data": "fecha"}
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 20,
            "scrollY": "400px",
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: true,
            "bSort": true,
            "aaSorting": [

            ],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        //$('#tblCosteaInventariosProceso_filter input[type=search]').focus();
    }
    function getGastosFab() {
        $.getJSON(master_url + 'getGastosFab').done(function (data) {
            if (data.length > 0) {
                pnlTablero.find('#corte').val(data[0].gfcte);
                pnlTablero.find('#pespu').val(data[0].gfpes);
                pnlTablero.find('#tejido').val(data[0].gftej);
                pnlTablero.find('#montado').val(data[0].gfmon);
                pnlTablero.find('#adorno').val(data[0].gfado);
                pnlTablero.find('#total').val(data[0].total);
                pnlTablero.find('#corte').focus().select();
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function suma() {
        var total = 0;
        pnlTablero.find("#Gastos").find('input:not(.notSum)').each(function () {
            total = total + parseFloat(($(this).val() === '') ? 0 : $(this).val());
        });
        pnlTablero.find('#total').val(parseFloat(total).toFixed(2));
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

    .table-sm th, .table-sm td {
        padding: 0.05rem;
    }
    table tbody tr {
        font-size: 0.7rem !important;
    }

    .verde {

        background-color: #B9F5A2 !important;
    }

    .azul  {
        background-color: #4BEFF1 !important;
    }

    .rojo {
        background-color: #FFBEAC !important;

    }
    label{
        margin-top: 0.0rem;
        margin-bottom: 0.0rem;
    }
</style>