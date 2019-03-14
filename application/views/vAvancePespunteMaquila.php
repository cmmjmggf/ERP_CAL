<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header">   
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-xl-12 col-lg-12 text-center">
                <h3 class="font-weight-bold" style="margin-bottom: 0px;">Avance a pespunte x maquila</h3>
            </div>
        </div>
    </div>
    <div class="card-body" style="padding-top: 0px; padding-bottom: 10px;">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Maquila</label>
                <select id="Maquila" name="Maquila" class="form-control"></select>
            </div> 
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Documento</label>
                <input type="text" id="Documento" name="Documento" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Control</label>
                <input type="text" id="Control" name="Control" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Frac</label>
                <input type="text" id="Frac" name="Frac" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Estilo</label>
                <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-3 col-lg-3 col-xl-3">
                <label>Color</label>
                <select id="Color" name="Color" class="form-control"></select>
            </div>
            <div class="col-12 col-xs-12 col-sm-1 col-lg-1 col-xl-1">
                <label>Pares</label>
                <input type="text" id="Pares" name="Pares" class="form-control form-control-sm numeric">
            </div>
            <div class="col-12 col-xs-12 col-sm-1 col-lg-1 col-xl-1">
                <label>Status</label>
                <input type="text" id="Ava" name="Ava" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-1 col-lg-1 col-xl-1">
                <label>Sem</label>
                <input type="text"  id="Sem" name="Sem" class="form-control form-control-sm numeric">
            </div>
            <div class="col-12 col-xs-12 col-sm-1 col-lg-1 col-xl-1">
                <label>Fecha</label>
                <input id="Fecha" name="Fecha" class="form-control form-control-sm date notEnter">
            </div>
            <div class="col-12 col-xs-12 col-sm-1 col-lg-1 col-xl-1"> 
                <button type="button" id="btnAgregar" name="btnAgregar" class="btn btn-primary mt-4">
                    <span class="fa fa-check"></span>
                </button>
            </div>
            <div class="w-100 my-3"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <h4>Controles listos para pespunte</h4>
                <table id="tblControlesListosParaPespunte" class="table  table-sm table-bordered" style="width:  100%;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Control</th>
                            <th scope="col">Estilo</th>
                            <th scope="col">Color</th>
                            <th scope="col">Par</th>
                            <th scope="col">Entrega</th>
                            <th scope="col">Maq</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <h4>Controles entregados</h4> 
                <table id="tblControlesEntregados" class="table table-hover table-sm table-bordered  compact nowrap" style="width:  100%;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Maq</th>

                            <th scope="col">Fecha</th>

                            <th scope="col">Control</th>
                            <th scope="col">Estilo</th>

                            <th scope="col">Col</th>
                            <th scope="col">-</th>

                            <th scope="col">Pares</th>
                            <th scope="col">Docto</th>
                            <th scope="col">-</th> 
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div> 
    </div>
</div>  
<script>
    var pnlTablero = $("#pnlTablero"), Maquila = pnlTablero.find("#Maquila");
    var ControlesListosParaPespunte, tblControlesListosParaPespunte = pnlTablero.find("#tblControlesListosParaPespunte"),
            ControlesEntregados, tblControlesEntregados = pnlTablero.find("#tblControlesEntregados"),
            Estilo = pnlTablero.find("#Estilo"), Color = pnlTablero.find("#Color"),
            btnAgregar = pnlTablero.find("#btnAgregar"), Control = pnlTablero.find("#Control"),
            Pares = pnlTablero.find("#Pares"), Semana = pnlTablero.find("#Sem"),
            Frac = pnlTablero.find("#Frac"), Fecha = pnlTablero.find("#Fecha"),
            Documento = pnlTablero.find("#Documento");

    $(document).ready(function () {
        getMaquilas();

        Frac.on('keydown', function (e) {
            if (Control.val() && e.keyCode === 13) {
                Frac.val(297);/*297 PESPUNTE A MAQUILA*/
            }
        });

        Control.on('keydown', function (e) {
            if (Control.val() && e.keyCode === 13) {
                $.getJSON("<?php print base_url('AvancePespunteMaquila/getInfoControl'); ?>", {
                    CONTROL: Control.val()
                }).done(function (a, b, c) {
                    console.log(a);
                    var rq = a[0];
                    Estilo.val(rq.Estilo);
                    getColoresXEstilo(rq.Estilo, rq);
                    Pares.val(rq.Pares);
                    Semana.val(rq.Semana);
                    Fecha.val('<?php print Date("d/m/Y"); ?>');
                    Frac.val(297);/*297 PESPUNTE A MAQUILA*/
                }).fail(function (x, y, z) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            }
        });

        btnAgregar.click(function () {
            HoldOn.close();
            $.getJSON('<?php print base_url('AvancePespunteMaquila/onVerificarAvance') ?>', {
                CONTROL: Control.val()
            }).done(function (a, b, c) {
                var r = a[0];
                if (parseInt(r.EXISTE) <= 0) {
                    if (Maquila.val() && Fecha.val() &&
                            Control.val() && Estilo.val() && Color.val() &&
                            Pares.val() && Documento.val()) {
                        /*AGREGAR AVANCE*/
                        var dta = {
                            CONTROL: Control.val(),
                            MAQUILA: Maquila.val(),
                            MAQUILAT: Maquila.find("option:selected").text(),
                            FECHA: Fecha.val(),
                            ESTILO: Estilo.val(),
                            ESTILOT: Estilo.find("option:selected").text(),
                            COLOR: Color.val(),
                            COLORT: Color.find("option:selected").text(),
                            DOCTO: Documento.val(),
                            PARES: Pares.val(),
                            FRACCION: Frac.val()
                        };
                        $.post('<?php print base_url('AvancePespunteMaquila/onAvanzar') ?>', dta).done(function (a, b, c) {
                            console.log(a);
                            swal({
                                title: "ATENCIÓN",
                                text: "SE HA GENERADO UN NUEVO AVANCE",
                                icon: "success",
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                                buttons: false,
                                timer: 1350
                            }).then((action) => {
                                pnlTablero.find("input").val("");
                                $.each(pnlTablero.find("select"), function (k, v) {
                                    pnlTablero.find("select")[k].selectize.clear(true);
                                });
                            });
                        }).fail(function (x, y, z) {
                            getError(x);
                        }).always(function () {
                            HoldOn.close();
                        });
                    } else {
                        swal('ATENCIÓN', 'TODOS LOS CAMPOS SON REQUERIDOS', 'warning');
                    }
                } else {
                    swal('ATENCIÓN', 'ESTE CONTROL YA HA SIDO AVANZADO', 'warning').then(function () {
                        Control.focus().select();
                    });
                }
            }).fail(function (x, y, z) {
                getError(x);
            }).always(function () {
                HoldOn.close();
            });
        });

        Estilo.on('keydown', function (e) {
            if (e.keyCode === 13) {
                getColoresXEstilo($(this).val(), null);
            }
        });

        var cols = [
            {"data": "ID"}/*0*/, {"data": "CONTROL"}/*1*/,
            {"data": "ESTILO"}/*2*/, {"data": "COLOR"},
            {"data": "PARES"}, {"data": "ENTREGA"}, {"data": "MAQUILA"}
        ];
        var coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ];

        var xoptions = {
            "dom": 'rit',
            "ajax": {
                "url": '<?php print base_url('AvancePespunteMaquila/getControlesParaPespunte'); ?>',
                "type": "POST",
                "contentType": "application/json",
                "dataSrc": ""
            },
            buttons: buttons,
            "columns": cols,
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 99999999,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "498px",
            "scrollX": true,
            createdRow: function (row, data, dataIndex) {
            }
        };
        ControlesListosParaPespunte = tblControlesListosParaPespunte.DataTable(xoptions);


        var cols = [
            {"data": "ID"}/*0*/, {"data": "MAQUILA"}/*1*/,
            {"data": "FECHA"}/*2*/, {"data": "CONTROL"},
            {"data": "ESTILO"}, {"data": "COLOR"},
            {"data": "COLORT"}, {"data": "PARES"},
            {"data": "DOCTO"}, {"data": "ID"}
        ];
        var coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ];
        var xxoptions = {
            "dom": 'rit',
            "ajax": {
                "url": '<?php print base_url('AvancePespunteMaquila/getControlesEnPespunte'); ?>',
                "type": "POST",
                "contentType": "application/json",
                "dataSrc": ""
            },
            buttons: buttons,
            "columns": cols,
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 99999999,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "498px",
            "scrollX": true,
            createdRow: function (row, data, dataIndex) {
                console.log(row, data);
                $(row).find("td:eq(8)").html('<button class="btn btn-danger" onclick="onEliminarAvanceMaquila(' + data.ID + ',' + data.IDA + ')"><span class="fa fa-trash"></span></button>');
            }
        };
        ControlesEntregados = tblControlesEntregados.DataTable(xxoptions);
    });

    function getColoresXEstilo(e, rq) {
        $.getJSON("<?php print base_url('avance_a_pespunte_x_maquila_colores_x_estilo') ?>", {ESTILO: e}).done(function (x, y, z) {
            x.forEach(function (i) {
                Color[0].selectize.addOption({text: i.COLOR, value: i.CLAVE});
            });
            if (rq) {
                Color[0].selectize.setValue(rq.Color);
            }
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getMaquilas() {
        $.getJSON('<?php print base_url('avance_a_pespunte_x_maquila_maquilas'); ?>').done(function (x, y, z) {
            x.forEach(function (i) {
                Maquila[0].selectize.addOption({text: i.MAQUILA, value: i.CLAVE});
            });
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {

        });
    }

    function onEliminarAvanceMaquila(id, ida) {
        swal({
            title: "ATENCIÓN",
            text: "Estas seguro de eliminar este registro?",
            icon: "warning",
            buttons: true
        }).then((response) => {
            if (response) {
                $.post('<?php print base_url('AvancePespunteMaquila/onEliminarAvanceMaquilaByID'); ?>', {
                    ID: id,
                    IDA: ida
                }).done(function (a) {
                    console.log(a);
                    swal({
                        title: "ATENCIÓN",
                        text: "SE HA ELIMINADO ESTE AVANCE",
                        icon: "success",
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        buttons: false,
                        timer: 1350
                    }).then((action) => {
                        ControlesListosParaPespunte.ajax.reload();
                        ControlesEntregados.ajax.reload();
                    });
                }).fail(function (x) {
                    getError(x);
                }).always(function () {

                });
            }
        });
    }
</script>
<style>
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid; 
        border-image: linear-gradient(to bottom,  #0099cc, #cc0000, rgb(0,0,0,0)) 1 100% ;
        border-image: linear-gradient(to bottom,  #0099cc, #cc0000, rgb(0,0,0,0)) 1 100% ;

    }
    .card-header{ 
        background-color: transparent;
        border-bottom: 0px;

    }
</style>