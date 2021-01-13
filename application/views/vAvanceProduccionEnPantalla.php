<div id="pnlTablero" class="card m-1" style="border:none !important;">
    <div class="card-body">
        <h4 class="card-title"><span class="fa fa-cog"></span> AVANCE EN PANTALLA</h4>
        <div class="row">
            <div class="col-12 col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                <label>AÑO</label>
                <input type="text" id="AvancePantallaAnio" name="AvancePantallaAnio" class="form-control numbersOnly" maxlength="4"> 
            </div>
            <div class="col-12 col-xs-2 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                <label>DE LA MAQUILA</label>
                <input type="text" id="AvancePantallaMaquilaInicial" name="AvancePantallaMaquilaInicial" class="form-control numbersOnly" maxlength="4"> 
            </div>
            <div class="col-12 col-xs-2 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                <label>A LA MAQUILA</label>
                <input type="text" id="AvancePantallaMaquilaFin" name="AvancePantallaMaquilaFin" class="form-control numbersOnly" maxlength="4"> 
            </div> 
            <div class="col-12 col-xs-2 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                <label>DE LA SEMANA</label>
                <input type="text" id="AvancePantallaSemanaInicial" name="AvancePantallaSemanaInicial" class="form-control numbersOnly" maxlength="4"> 
            </div>
            <div class="col-12 col-xs-2 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                <label>A LA SEMANA</label>
                <input type="text" id="AvancePantallaSemanaFin" name="AvancePantallaSemanaFin" class="form-control numbersOnly" maxlength="4"> 
            </div>
            <div class="col-12 col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 d-none">
                <label>TIPO /FILTRO</label>
                <select id="AvancePantallaTipoFiltro" name="AvancePantallaTipoFiltro" class="form-control">
                    <option></option>
                    <option value="1">1 CON CÉLULA DE PESPUNTE</option>
                    <option value="2">2 CON TEJEDORA</option>
                    <option value="3">3 CON SUELA</option>
                    <option value="4">4 ORDENADO POR LINEA/FECHA ENTREGA</option>
                    <option value="5">5 CON MAQUILADORAS</option>
                    <option value="6">6 PRIORIDAD CUARENTENA</option>
                </select>
            </div>
            <div class="col-12 col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <label>DEPARTAMENTO DE AVANCE</label>
                <select id="AvancePantallaDepartamento" name="AvancePantallaDepartamento" class="form-control">
                    <option></option>
                    <option value="1">PROGRAMADO</option>
                    <option value="2">CORTE</option>
                    <option value="3">RAYADO</option>
                    <option value="33">REBAJADO</option>
                    <option value="4">FOLEADO</option>
                    <option value="40">ENTRETELADO</option>
                    <option value="42">MAQUILA</option>
                    <option value="44">ALMACEN DE CORTE</option>
                    <option value="5">PESPUNTE</option>
                    <option value="55">ENSUELADO</option>
                    <option value="6">ALMACEN PESPUNTE</option>
                    <option value="7">TEJIDO</option>
                    <option value="8">ALMACEN DE TEJIDO</option>
                    <option value="9">MONTADO</option>
                    <option value="10">ADORNO</option>
                    <option value="11">ALMACEN DE ADORNO</option>
                    <option value="12">TERMINADO</option> 
                    <option value="13">FACTURADO</option> 
                    <option value="14">CANCELADO</option> 
                </select>
            </div> 
            <div class="col-12 col-xs-2 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                <button type="button" id="btnAceptaAvanceProduccionEnPantalla" class="mt-3 btn btn-info btn-block">
                    <span class="fa fa-check"></span> ACEPTA
                </button>
            </div>
            <div class="col-12 mt-2">
                <table id="tblAvances" class="table table-hover nowrap table-sm" style="width: 100%">
                    <thead>
                        <tr> 
                            <th scope="col">FOTO</th> 
                            <th scope="col">PEDIDO</th> 
                            <th scope="col">CONTROL</th> 
                            <th scope="col">FECHA-PROG</th> 
                            <th scope="col">DEPTO.AVANCE</th> 

                            <th scope="col">ENTRÓ</th> 
                            <th scope="col">DÍAS</th> 
                            <th scope="col">DÍAS PROG.</th> 
                            <th scope="col">PARES</th> 
                            <th scope="col">FACTURADOS</th> 

                            <th scope="col">SALDO PARES</th> 
                            <th scope="col">LINEA </th> 
                            <th scope="col">ESTILO </th> 
                            <th scope="col">COMBINACIÓN </th> 
                            <th scope="col">CLIENTE </th> 

                            <th scope="col">FECHA-ENTREGA </th> 
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr style="background-color: #000 !important;
        color: #ffff00 !important;">
                            <td></td>
                            <td></td>
                            
                            <td class="font-weight-bold" colspan="5">PARES TOTALES</td> 
                            <td class="font-weight-bold" colspan="3">0</td>   
                              
                            <td></td>   
                            <td></td>   
                            <td></td>   

                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div> 
<script>
    var pnlTablero = $("#pnlTablero"),
            tblAvances = pnlTablero.find("#tblAvances"), Avances;
    AvancePantallaAnio = pnlTablero.find("#AvancePantallaAnio"),
            AvancePantallaMaquilaInicial = pnlTablero.find("#AvancePantallaMaquilaInicial"),
            AvancePantallaMaquilaFin = pnlTablero.find("#AvancePantallaMaquilaFin"),
            AvancePantallaSemanaInicial = pnlTablero.find("#AvancePantallaSemanaInicial"),
            AvancePantallaSemanaFin = pnlTablero.find("#AvancePantallaSemanaFin"),
            AvancePantallaTipoFiltro = pnlTablero.find("#AvancePantallaTipoFiltro"),
            AvancePantallaDepartamento = pnlTablero.find("#AvancePantallaDepartamento"),
            btnAceptaAvanceProduccionEnPantalla = pnlTablero.find("#btnAceptaAvanceProduccionEnPantalla"),
            mdlEstiloFoto = $("#mdlEstiloFoto"), imagen_por_defecto = '<?php print base_url('img/LS.png'); ?>';
    $(document).ready(function () {
        AvancePantallaAnio.val('<?php print Date('Y'); ?>');
        handleEnterDiv(pnlTablero);
        mdlEstiloFoto.on('shown.bs.modal', function () {
            setTimeout(function () {
                mdlEstiloFoto.modal('hide');
            }, 2500);
        });
        mdlEstiloFoto.on('hidden.bs.modal', function () {
            mdlEstiloFoto.find("img").attr("src", imagen_por_defecto);
            mdlEstiloFoto.find("img").parent("a")[0].href = imagen_por_defecto;
            mdlEstiloFoto.find("h5.modal-title").text("ESTILO X");
        });
        btnAceptaAvanceProduccionEnPantalla.click(function () {
            onDisable(btnAceptaAvanceProduccionEnPantalla);
            if (AvancePantallaAnio.val() && AvancePantallaMaquilaInicial.val() &&
                    AvancePantallaMaquilaFin.val() && AvancePantallaSemanaInicial.val() &&
                    AvancePantallaSemanaFin.val()) {
                onOpenOverlay('Espere...');
                Avances.ajax.reload(function () {
                    onEnable(btnAceptaAvanceProduccionEnPantalla);
                    onCloseOverlay();
                });
            } else {
                onCampoInvalido(pnlTablero, "DEBE DE ESPECIFICAR LOS CAMPOS REQUERIDOS", function () {
                    onEnable(btnAceptaAvanceProduccionEnPantalla);
                    AvancePantallaAnio.focus().select();
                });
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
        Avances = tblAvances.DataTable({
            "dom": 'fritp',
            "ajax": {
                "url": '<?php print base_url('AvanceProduccionEnPantalla/getAvances'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.ANIO = AvancePantallaAnio.val() ? AvancePantallaAnio.val() : '';
                    d.MAQUILA_INICIAL = AvancePantallaMaquilaInicial.val() ? AvancePantallaMaquilaInicial.val() : '';
                    d.MAQUILA_FINAL = AvancePantallaMaquilaFin.val() ? AvancePantallaMaquilaFin.val() : '';
                    d.SEMANA_INICIAL = AvancePantallaSemanaInicial.val() ? AvancePantallaSemanaInicial.val() : '';
                    d.SEMANA_FINAL = AvancePantallaSemanaFin.val() ? AvancePantallaSemanaFin.val() : '';
                    d.DEPARTAMENTO_AVANCE = AvancePantallaDepartamento.val() ? AvancePantallaDepartamento.val() : '';
                }
            },
            buttons: buttons,
            "columns": [
                {"data": "FOTO"}/*1*/,
                {"data": "PEDIDO"}/*1*/,
                {"data": "CONTROL"}/*1*/,
                {"data": "FECHA_PROGAMACION"}/*1*/,
                {"data": "CLAVE_DEPARTAMENTO_AVANCE"}/*1*/,
                {"data": "FECHA_ENTRO"}/*1*/,
                {"data": "DIAS"}/*1*/,
                {"data": "DIAS_PROG"}/*1*/,
                {"data": "PARES"}/*1*/,
                {"data": "PARES_FACTURADOS"}/*1*/,
                {"data": "SALDO_PARES"}/*1*/,
                {"data": "LINEA"}/*1*/,
                {"data": "ESTILO"}/*1*/,
                {"data": "COLOR"}/*1*/,
                {"data": "CLIENTE"}/*1*/,
                {"data": "FECHA_ENTREGA"}/*1*/
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "600px",
            "scrollX": true,
            "aaSorting": [
                [4, 'asc']
            ],
            rowGroup: {
                endRender: function (rows, group) {
                    var stc = $.number(rows.data().pluck('PARES').reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0), 2, '.', ',');
                    return $('<tr>').
                            append('<td colspan="7">Total de pares de  ' + group + '</td>').append('<td>' + stc + '</td><td colspan="7"></td></tr>');
                },
                dataSrc: "CLAVE_DEPARTAMENTO_AVANCE"
            },
            initComplete: function () {
                AvancePantallaAnio.focus().select();
            },
            "drawCallback": function () {
                var api = this.api();
                var pares = 0;
                $.each(api.rows().data(), function (k, v) {
                    console.log(v);
                    pares += parseFloat(v.PARES);
                });
                $(api.column(7).footer()).html("<span class='font-weight-bold'>"+pares+"</span>");
            }
        });
        tblAvances.on('click', 'tr', function () { 
            var row = Avances.row(this).data();
            console.log(row);
        });
        tblAvances.on('click', 'td', function () {
            var row = Avances.row(this).data();
            console.log('tr td', $(this).text(), $(this).index(), row);
            switch (parseInt($(this).index())) {
                case 11:
                    var estilo = $(this).text();
                    if (estilo !== '') {
                        onVerEstilo('<?php print base_url(); ?>/' + row.FOTO, estilo);
                    } else {
                        onVerEstilo(imagen_por_defecto, estilo);
                    }
                    break;
            }
        });
    });

    function onVerEstilo(estilo_url, estilo) {
        $.notify({
            mouse_over: null,
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            animate: {
                enter: 'animated bounceInDown',
                exit: 'animated bounceOutUp'
            },
            icon: estilo_url,
            title: 'ESTILO',
            message: estilo,
            target: '_blank'
        }, {
            delay: 2500,
            icon_type: 'image',
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                    '<img data-notify="icon" class="img-fluid">' +
                    '<div class="w-100  text-center"><span data-notify="title" style="font-size: 22px" class="font-weight-bold">{1}</span></div>' +
                    '<p data-notify="message" class="font-weight-bold text-center" style="font-size: 22px">{2}</p>' +
                    '</div>'
        });
    }
</script>
<style>
    #tblAvances tbody tr td{
        font-size: 14px;
        font-weight: bold;
    }
    #tblAvances tbody tr td:nth-child(12){
        text-align: center;
        color: #2E7D32;
        transition: all .2s ease-in-out;
    }

    #tblAvances tbody tr:hover td:nth-child(12), 
    #tblAvances tbody tr td:nth-child(12):hover{
        color: #ffff00;
        border-radius: 10px;
        transform: scale(1.2); 
        text-align: center;
    }

    table.dataTable tbody>tr.selected, table.dataTable tbody>tr>.selected {
        background-color: #000 !important;
        color: #fff !important;
    }

    #tblAvances tbody tr.selected td:nth-child(12){
        color: #ffff00;
    } 
    #tblAvances tbody tr.group-end td{
        background-color: #000 !important;
        color: #fff !important;
    }
    #tblAvances tbody tr.group-end:hover td{
        background-color: #2C3E50 !important;
        color: #fff !important;
    }
    #tblAvances tbody tr.group-end td{
        background-color: #000 !important;
        color: #ffff00 !important;
    }
    #tblAvances tfoot tr, #tblAvances tfoot tr td:nth-child(8){
        background-color: #000 !important;
        color: #ffff00 !important;
    }
</style>