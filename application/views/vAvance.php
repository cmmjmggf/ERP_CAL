<div class="card mt-2 mx-2 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center">
        <div class="row m-4" style="margin-right: 0px;">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <h3 class="font-weight-bold">Avance</h3>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <button type="button" id="btnRastreoXConcepto" name="btnRastreoXConcepto" class="btn btn-primary" style="box-shadow: 0 0 0 0.2rem #CDDC39 !important;">
                    <span class="fa fa-bullseye"></span>
                    Rastreo X Concepto
                </button>
                <button type="button" id="btnRastreoXControl" name="btnRastreoXControl" class="btn btn-primary ml-2" style="box-shadow: 0 0 0 0.2rem #CDDC39 !important;">
                    <span class="fa fa-globe"></span> 
                    Rastreo X Control
                </button>
                <button type="button" id="btnDesarrolloDeMuestras" name="btnDesarrolloDeMuestras" class="btn btn-primary ml-2" style="box-shadow: 0 0 0 0.2rem #CDDC39 !important;">
                    <span class="fa fa-paint-brush"></span> 
                    Desarrollo de muestras
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <!--SECCION UNO-->
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <input type="text" id="usuario" name="usuario" class="form-control form-control-sm"> 
                </div>
                <div class="w-100"></div>   
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <label>Control</label>
                    <div class="input-group mb-3">
                        <input type="text" id="Control" name="Control" autofocus="" class="form-control form-control-sm numbersOnly" maxlength="11" placeholder="Escriba un control...">
                        <div class="input-group-append">
                            <button type="button" id="btnBuscarControl" name="btnBuscarControl" class="btn btn-info"><span class="fa fa-search"></span></button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                    <label>Fecha</label>
                    <input type="text" id="Fecha" name="Fecha" class="form-control form-control-sm date" > 
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label>Departamento</label>
                    <select type="text" id="Departamento" name="Departamento" class="form-control form-control-sm"></select> 
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                    <label>Semana</label>
                    <input type="text" id="Semana" name="Semana" class="form-control form-control-sm numbersOnly" maxlength="2">
                </div>
                <div class="w-100"></div> 
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <ul id="deptos" class="list-group my-2"> 
                    </ul> 
                </div>
                <div class="w-100"></div>  
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label>Proceso maquila</label>
                    <select id="ProcesoMaquila" name="ProcesoMaquila" class="form-control form-control-sm"></select>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label>Empleado</label>
                    <select id="Empleado" name="Empleado" class="form-control form-control-sm"></select>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <label>Fracción</label>
                    <select id="Fraccion" name="Fraccion" class="form-control form-control-sm"></select>
                </div>
                <div class="w-100"></div> 
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <label>Estilo</label>
                    <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm numbersOnly" maxlength="2">
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <label>Depto.Actual</label>
                    <input type="text" id="DeptoActual" name="DeptoActual" class="form-control form-control-sm numbersOnly" maxlength="2">
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                    <label>Pares</label>
                    <input type="text" id="Pares" name="Pares" class="form-control form-control-sm numbersOnly" maxlength="5">
                </div>
                <div class="col-12 col-sm-12 col-sm-1 col-lg-1 col-xl-1">
                    <button type="button" id="btnAceptar" name="btnAceptar" disabled="" class="btn btn-primary mt-4"  data-toggle="tooltip" data-placement="right" title="Aceptar">
                        <span class="fa fa-check"></span>
                    </button>
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" aling="center">
                    <hr>
                </div>                
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 d-none">
                    <label>Depto des</label>
                    <input type="text" id="DeptoDes" name="DeptoDes" class="form-control" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 d-none">
                    <label>Depto Avance</label>
                    <input type="text" id="DeptoAva" name="DeptoAva" class="form-control" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 d-none">
                    <label>Fraccion descripcion</label>
                    <input type="text" id="DescripcionFraccion" name="DescripcionFraccion" class="form-control" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-none">
                    <label>Precio Fraccion</label>
                    <input type="text" id="PrecioFraccion" name="PrecioFraccion" class="form-control" readonly="">
                </div>
            </div>
            <!--SECCION DOS-->
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <h4>Fracciones pagadas en nomina de este control</h4>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                        <button type="button" id="btnBorrar" name="btnBorrar" class="btn btn-danger">
                            <span class="fa fa-trash"></span>
                        </button>
                    </div>
                </div>
                <table id="tblAvance" class="table table-hover table-sm table-bordered  compact nowrap">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Emp</th>
                            <th scope="col">Semana</th>

                            <th scope="col">Fecha</th>
                            <th scope="col">Control</th>
                            <th scope="col">Maq</th>

                            <th scope="col">Estilo</th>
                            <th scope="col">Frac</th>
                            <th scope="col">Precio</th>

                            <th scope="col">Pares</th>
                            <th scope="col">SubTotal</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table> 
            </div>
            <!--SECCION TRES-->
            <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 text-center">
                <img src="<?= base_url('img/LS.png'); ?>" class="img-responsive"> 
            </div>
        </div>
    </div>
</div>
<!--RASTREO X CONCEPTO-->
<div class="modal animated fadeIn" id="mdlRastreoXConcepto">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">RASTREO POR CONCEPTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Empleado</label>
                        <select id="EmpleadoRXC" name="EmpleadoRXC" class="form-control"></select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Concepto</label>
                        <select id="ConceptoRXC" name="ConceptoRXC" class="form-control"></select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblRastreoXConcepto" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Sem</th>
                                    <th scope="col">Emp</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Per</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col">Ded</th>
                                    <th scope="col">Importe</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Acepta</button>
            </div>
        </div>
    </div>
</div>

<!--RASTREO X CONTROL-->
<div class="modal animated fadeIn" id="mdlRastreoXControl">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">RASTREO POR CONTROL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Control</label>
                        <input type="text" id="ControlRXCTROL" name="ControlRXCTROL" class="form-control numeric">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>Semana</label>
                        <input type="text" id="SemanaRXCTROL" name="SemanaRXCTROL" class="form-control numeric">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <label>Empleado</label>
                        <select id="EmpleadoRXCTROL" name="EmpleadoRXCTROL" class="form-control"></select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <label>Desc.fraccion</label>
                        <select id="FraccionRXCTROL" name="FraccionRXCTROL" class="form-control"></select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Avance actual</label>
                        <input type="text" id="AvanceActual" name="AvanceActual" class="form-control" readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table id="tblRastreoXControl" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Control</th>
                                    <th scope="col">Emp</th>

                                    <th scope="col">Estilo</th>
                                    <th scope="col">Frac</th>
                                    <th scope="col">Fecha</th>

                                    <th scope="col">Semana</th>  
                                    <th scope="col">Pares</th>
                                    <th scope="col">Precio</th>

                                    <th scope="col">SubTotal</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Acepta</button>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = '<?= base_url('Avance/') ?>', pnlTablero = $("#pnlTablero");
    var Fecha = pnlTablero.find("#Fecha"), Departamento = pnlTablero.find("#Departamento"),
            Semana = pnlTablero.find("#Semana"), tblAvance = pnlTablero.find("#tblAvance"),
            Control = pnlTablero.find("#Control"), Avances,
            btnBuscarControl = pnlTablero.find("#btnBuscarControl"),
            Estilo = pnlTablero.find("#Estilo"), Fraccion = pnlTablero.find("#Fraccion"),
            DeptoActual = pnlTablero.find("#DeptoActual"),
            Pares = pnlTablero.find("#Pares"),
            btnAceptar = pnlTablero.find("#btnAceptar"), btnBorrar = pnlTablero.find("#btnBorrar"),
            ProcesoMaquila = pnlTablero.find("#ProcesoMaquila"), Empleado = pnlTablero.find("#Empleado"),
            PrecioFraccion = pnlTablero.find("#PrecioFraccion"), DeptoDes = pnlTablero.find("#DeptoDes"),
            DeptoAva = pnlTablero.find("#DeptoAva"), DescripcionFraccion = pnlTablero.find("#DescripcionFraccion"),
            btnRastreoXConcepto = pnlTablero.find("#btnRastreoXConcepto"),
            btnRastreoXControl = pnlTablero.find("#btnRastreoXControl"),
            mdlRastreoXConcepto = $("#mdlRastreoXConcepto"), mdlRastreoXControl = $("#mdlRastreoXControl"),
            RastreoXConcepto, tblRastreoXConcepto = mdlRastreoXConcepto.find("#tblRastreoXConcepto"),
            RastreoXControl, tblRastreoXControl = mdlRastreoXControl.find("#tblRastreoXControl"),
            EmpleadoRXC = mdlRastreoXConcepto.find("#EmpleadoRXC"),
            ConceptoRXC = mdlRastreoXConcepto.find("#ConceptoRXC"),
            EmpleadoRXCTROL = mdlRastreoXControl.find("#EmpleadoRXCTROL"),
            btnDesarrolloDeMuestras = pnlTablero.find("#btnDesarrolloDeMuestras");

    $(document).ready(function () {

        btnDesarrolloDeMuestras.click(function () {
            $.fancybox.defaults.animationEffect = "zoom-in";
            $.fancybox.defaults.animationEffect = "zoom-in-out";
            $.fancybox.open({
                src: '<?php print base_url('DesarrolloMuestras/?origen=PRODUCCION'); ?>',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
                        console.info('done!');
                    },
                    iframe: {
                        tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                        preload: true,
                        css: {
                            width: "100%",
                            height: "100%"
                        },
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });

        btnRastreoXControl.click(function () {
            mdlRastreoXControl.modal('show');
        });

        btnRastreoXConcepto.click(function () {
            mdlRastreoXConcepto.modal('show');
        });

        btnBorrar.click(function () {
            var row = Avances.rows({selected: true}).data();
            if (parseInt(row.ID) > 0) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Eliminando avance...'
                });
                $.post('<?php print base_url('Avance/onEliminarAvance') ?>', {ID: row.ID}).done(function (a) {
                    console.log(a);
                }).fail(function (x, y, z) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', 'ES NECESARIO SELECCIONAR UN REGISTRO A ELIMINAR', 'warning');
            }
        });

        btnAceptar.click(function () {
            if (PrecioFraccion.val() && DeptoActual.val()) {
                var f = new FormData();
                f.append('CONTROL', Control.val());
                f.append('FECHA', Fecha.val());
                f.append('DEPTO', Departamento.val());
                f.append('SEMANA', Semana.val());
                f.append('PROCESO_MAQUILA', ProcesoMaquila.val());
                f.append('EMPLEADO', Empleado.val());
                f.append('FRACCION', Fraccion.val());
                var frt = Fraccion.find("option:selected").text();
                frt = frt.replace(Fraccion.val() + ' ', '');
                f.append('FRACCIONT', frt);
                f.append('ESTILO', Estilo.val());
                f.append('DEPTOACTUAL', DeptoActual.val());
                f.append('DEPTOT', DeptoDes.val());
                f.append('PARES', Pares.val());
                f.append('PRECIO_FRACCION', PrecioFraccion.val());
                $.ajax({
                    url: master_url + 'onAvanzar',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: f
                }).done(function (a, b, c) {
                    console.log(a);
                    swal('ATENCIÓN', 'SE HA GENERADO UN AVANCE', 'success').then((value) => {
                        Avances.ajax.reload();
                    });
                }).fail(function (x, y, z) {
                    getError(x);
                });
            } else {
                swal('ATENCIÓN', 'ES NECESARIO QUE LA FRACCION TENGA UN PRECIO', 'warning');
            }
        });

        Estilo.on('change keydown keypress', function () {
            getPrecioFraccionXEstiloFraccion();
        });

        Fraccion.on('change keydown keypress', function () {
            getPrecioFraccionXEstiloFraccion();
        });

        btnBuscarControl.click(function () {
            if (Fecha.val() && Departamento.val() && Semana.val()) {
                getDeptosXControl($(this).parent().find("#Control"));
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UNA FECHA', 'warning');
            }
        });

        getDepartamentos();

        $("#usuario").val('<?php print $_SESSION['USERNAME']; ?>').prop('disabled', true);

        $.getJSON('<?php print base_url('avance_maqplant'); ?>').done(function (d) {
            d.forEach(function (v) {
                ProcesoMaquila[0].selectize.addOption({text: v.MaquilasPlantillas, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });

        $.getJSON('<?php print base_url('avance_empleados'); ?>').done(function (d) {
            d.forEach(function (v) {
                Empleado[0].selectize.addOption({text: v.EMPLEADO, value: v.CLAVE});
                EmpleadoRXC[0].selectize.addOption({text: v.EMPLEADO, value: v.CLAVE});
                EmpleadoRXCTROL[0].selectize.addOption({text: v.EMPLEADO, value: v.CLAVE});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });

        $.getJSON('<?php print base_url('avance_fracciones'); ?>').done(function (d) {
            var Fraccion = pnlTablero.find("#Fraccion");
            d.forEach(function (v) {
                Fraccion[0].selectize.addOption({text: v.FRACCION, value: v.CLAVE});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });

        Control.on('keydown', function (e) {
            if (e.keyCode === 13) {
                getDeptosXControl($(this));
                getDeptoActualXControl();
                Avances.ajax.reload();
            }
        });

        Fecha.val(getActualDate());

        $.post('<?php print base_url('Avance/getSemanaNomina'); ?>', {
            FECHA: Fecha.val()
        }).done(function (d) {
            console.log(d);
            var s = JSON.parse(d);
            if (s.length > 0) {
                Semana.val(s[0].SEMANA);
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });

        var cols = [
            {"data": "ID"}/*0*/,
            {"data": "EMPLEADO"}/*1*/,
            {"data": "SEMANA"}/*2*/,
            {"data": "FECHA"}/*3*/,
            {"data": "CONTROL"}/*4*/,
            {"data": "MAQUILA"}/*5*/,
            {"data": "ESTILO"}/*6*/,
            {"data": "NUM_FRACCION"}/*7*/,
            {"data": "PRECIO_FRACCION"}/*8*/,
            {"data": "PARES"}/*9*/,
            {"data": "SUBTOTAL"}/*10*/
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
                "url": '<?php print base_url('Avance/getAvancesNomina'); ?>',
                "type": "POST",
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL = (Control.val().trim());
                }
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
            "aaSorting": [
                [0, 'desc']
            ]
        };
        Avances = tblAvance.DataTable(xoptions); 
        RastreoXConcepto = tblRastreoXConcepto.DataTable({
            "dom": 'ritp',
            "ajax": {
                "url": '<?php print base_url('Avance/getRastreoXConcepto'); ?>',
                "type": "POST",
                "contentType": "application/json",
                "dataSrc": ""
            },
            buttons: buttons,
            "columns": [
                {"data": "ID"}/*0*/,
                {"data": "SEMANA"}/*1*/,
                {"data": "EMPLEADO"}/*2*/,
                {"data": "FECHA"}/*3*/,
                {"data": "CONCEPTO"}/*4*/,
                {"data": "PER"}/*9*/,
                {"data": "IMPORTE"}/*9*/,
                {"data": "DED"}/*9*/,
                {"data": "SUBTOTAL"}/*10*/
            ],
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "498px",
            "scrollX": true,
            "aaSorting": [
                [0, 'desc']
            ]
        });

        RastreoXControl = tblRastreoXControl.DataTable({
            "dom": 'rit',
            "ajax": {
                "url": '<?php print base_url('Avance/getRastreoXControl'); ?>',
                "type": "POST",
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL = (Control.val().trim());
                }
            },
            buttons: buttons,
            "columns": [
                {"data": "ID"}/*0*/,
                {"data": "CONTROL"}/*1*/,
                {"data": "EMPLEADO"}/*2*/,
                {"data": "ESTILO"}/*3*/,
                {"data": "NUM_FRACCION"}/*4*/,
                {"data": "FECHA"}/*5*/,
                {"data": "SEMANA"}/*6*/,
                {"data": "PARES"}/*7*/,
                {"data": "PRECIO_FRACCION"}/*8*/,
                {"data": "SUBTOTAL"}/*10*/
            ],
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
            "aaSorting": [
                [0, 'desc']
            ]
        });
        getConceptosNomina();
    });

    function getPrecioFraccionXEstiloFraccion() {
        console.log(Fraccion.val());
        if (Fraccion.val() && Estilo.val()) {
            $.getJSON('<?php print base_url('Avance/getPrecioFraccionXEstiloFraccion') ?>', {
                ESTILO: Estilo.val(), FRACCION: Fraccion.val()
            }).done(function (a) {
                if (a.length > 0) {
                    console.log(a);
                    PrecioFraccion.val(a[0].COSTO_MO);
                    var frt = Fraccion.find("option:selected").text();
                    frt = frt.replace(Fraccion.val() + ' ', '');
                    DescripcionFraccion.val(frt);
                    btnAceptar.attr('disabled', false);
                } else {
                    onBeep(5);
                    swal('ATENCIÓN', 'ESTE ESTILO NO TIENE DEFINIDA LA FRACCION SELECCIONADA', 'warning').then((value) => {
                        PrecioFraccion.val('');
                        Fraccion[0].selectize.open();
                        btnAceptar.attr('disabled', true);
                    });
                }
            }).fail(function (x, y, z) {
                getError(x);
            }).always(function () {
                HoldOn.close();
            });
        }
    }

    function getDeptoActualXControl() {
        $.post('<?php print base_url('Avance/getDeptoActual'); ?>',
                {CONTROL: Control.val()}).done(function (d) {
            var r = JSON.parse(d);
            if (r.length > 0) {
                var rr = r[0];
                Estilo.val(rr.ESTILO);
                DeptoActual.val(rr.DEPTO);
                Pares.val(rr.PARES);
            }
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getDeptosXControl(ctrl) {
        HoldOn.open({
            theme: 'sk-rect',
            message: 'Comprobando...'
        });
        $.post('<?php print base_url('Avance/onComprobarAvanceXControl'); ?>',
                {CONTROL: ctrl.val()}
        ).done(function (data, x, y) {
            var deptos = [10, 20], deptos_del_control = JSON.parse(data), c = 0;
            deptos_del_control.forEach(function (item) {
                if (deptos.indexOf(item.DEPARTAMENTO) === -1) {
                    c += 1;
                }
            });
            if (c < deptos.length) {
                onBeep(2);
                swal('ATENCIÓN', 'EL CONTROL NO CUMPLE CON LOS DEPARTAMENTOS REQUERIDOS', 'warning').then((value) => {
                    ctrl.focus().select();
                });
            } else if (c === deptos.length) {
                onBeep(5);
                //                swal('ATENCIÓN', 'EL CONTROL CUMPLE CON LOS DEPARTAMENTOS REQUERIDOS, SELECCIONE EL SIGUIENTE DEPARTAMENTO', 'success').then((value) => {
                ctrl.focus().select();
                //                });
            }
            /*
             swal('ATENCIÓN', 'ESTE CONTROL NO HA PASADO POR LOS DEPARTAMENTOS REQUERIDOS','warning').then((value) => {
             });*/
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getActualDate() {
        var d = new Date();
        var day = addZero(d.getDate());
        var month = addZero(d.getMonth() + 1);
        var year = addZero(d.getFullYear());
        return day + "/" + month + "/" + year;
    }

    function addZero(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function getConceptosNomina() {
        $.getJSON('<?php print base_url('Avance/getConceptosNomina'); ?>').done(function (a) {
            console.log(a);
            a.forEach(function (e) {
                ConceptoRXC[0].selectize.addOption({text: e.CLAVE + ' ' + e.CONCEPTO, value: e.CLAVE});
            });
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {

        });
    }

    function getDepartamentos() {
        $.getJSON('<?php print base_url('Avance/getDepartamentos'); ?>').done(function (data) {
            var ul = $("#deptos"), ul_list = '';
            data.forEach(function (v) {
                Departamento[0].selectize.addOption({text: v.Departamento, value: v.Clave});
                ul_list += '<li class="list-group-item d-flex justify-content-between align-items-center">';
                ul_list += '<span class="d-none" des="' + v.DesDepto + '">' + v.Clave + '</span>' + v.Departamento;
                ul_list += '<span class="deptodes d-none">' + v.DesDepto + '</span>';
                ul_list += '<span class="deptoclave d-none">' + v.Clave + '</span>';
                ul_list += '<span class="badge badge-primary badge-pill">!</span>';
                ul_list += '</li>';
            });
            ul.html(ul_list);
            ul.find("li").click(function () {
                ul.find("li").removeClass('li-selected');
                var li = $(this), deptodes = li.find("span.deptodes").text(), clave = li.find("span.deptoclave").text();
                if (parseInt(clave) >= 180) {
                    if (Control.val()) {
                        li.addClass('li-selected');
                        Departamento[0].selectize.setValue(parseInt(li.find("span").first().text()));
                        Semana.focus().select();
                        getDeptoActualXControl();
                        DeptoDes.val(deptodes);
                        DeptoAva.val(clave);
                        onBeep(3);
                    } else {
                        swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CONTROL', 'warning').then((value) => {
                            Control.focus().select();
                        });
                    }
                } else {
                    swal('ATENCIÓN', 'DEPARTAMENTO INVÁLIDO, SELECCIONE UNO DENTRO DEL RANGO DEPARTAMENTOS DE 180,190,210 o 220', 'warning').then((value) => {
                        ul.find("li").removeClass('li-selected');
                    });
                }
            });
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onBuscarAvanceXControl() {
        $.getJSON('<?php print base_url('avance_buscar_avance_x_control'); ?>').done(function (dta) {
            console.log(dta);
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {

        });
    }
</script>
<style>
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid; 
        /*border-image: linear-gradient(to bottom,  #2196F3, #cc0066, rgb(0,0,0,0)) 1 100% ;*/
        border-image: linear-gradient(to bottom,  #0099cc, #ccff00, rgb(0,0,0,0)) 1 100% ;
    }
    .card-header{ 
        background-color: transparent;
        border-bottom: 0px;
    }
    .card-body{
        padding-top: 10px;
    }
    .card-header{
        padding: 0px;
    }
    li.list-group-item {  
        padding-top: 3px;
        padding-bottom: 3px;
    }  
    li.list-group-item:hover { 
        font-weight: bold; 
        color: #fff;
        cursor: pointer;
        background-color: #3f51b5;  
        -webkit-box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        -moz-box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        padding-top: 3px;
        padding-bottom: 3px; 
        animation: myfirst .4s;
        -moz-animation:myfirst 1.4s infinite; /* Firefox */
        -webkit-animation:myfirst 1.4s infinite; /* Safari and Chrome */
        border-radius: 5px;
    }
    .li-selected{
        font-weight: bold; 
        color: #D32F2F;
        cursor: pointer;
        background-color: #fff;   
        padding-top: 3px;
        padding-bottom: 3px;  
        border-radius: 0px;
        font-weight: bold;
    }
    .li-selected span.badge-primary{
        font-weight: bold; 
        color: #fff;
        background-color: #D32F2F;   
        padding-top: 3px;
        padding-bottom: 3px;   
    } 
    ul.list-group {
        animation: highlight .4s;
        -moz-animation:highlight 1.4s infinite; /* Firefox */
        -webkit-animation:highlight 1.4s infinite; /* Safari and Chrome */
        border-radius: 5px;
    }

    table tbody tr:hover { 
        font-weight:normal !important; 
    }

    .box-success{
        box-shadow: 0 0 0 0.2rem #CDDC39 !important;
    }

    .box-info{
        box-shadow: 0 0 0 0.2rem #33C2E1 !important;
    }

    @-moz-keyframes myfirst /* Firefox */
    {
        0%   {    border: 1px solid #2196F3}
        50%  {    border: 1px solid #6610f2;        font-weight: bold;}
        100%   {border: 1px solid #2196F3}
    }

    @-webkit-keyframes myfirst /* Firefox */
    {
        0%   {    border: 1px solid #2196F3}
        50%  {    border: 1px solid #6610f2;font-weight: bold;}
        100%   {border: 1px solid #2196F3}
    }

    @-moz-keyframes highlight /* Firefox */
    {
        0%   {    border: 1px solid #3F51B5}
        50%  {    border: 1px solid #2196f3;        }
        100%   {border: 1px solid #3F51B5}
    }

    @-webkit-keyframes highlight /* Firefox */
    {
        0%   {    border: 1px solid #3F51B5}
        50%  {    border: 1px solid #2196f3;}
        100%   {border: 1px solid #3F51B5}
    }
</style>