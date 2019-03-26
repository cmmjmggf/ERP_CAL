<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-12 float-left">
                <legend class="float-left">Desarrollo de muestras</legend>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <label>Estilo</label>
                        <input type="text" id="Estilo" name="Estilo" maxlength="10" class="form-control" autofocus="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7">
                        <label>Color</label>
                        <select id="Color" name="Color" class="form-control"></select>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                        <label>Depto</label>
                        <input type="text" id="Depto" name="Depto" class="form-control numbersOnly">
                    </div>
                    <div class="w-100"><br></div>
                    <div class="col-12 col-xs-12 col-md-12 col-lg-12 col-xl-12">
                        <table class="table table-hover" id="tblFichaTecnica">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Estilo</th>
                                    <th scope="col">Pza</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Sec</th>
                                    <th scope="col">Articulo</th>
                                    <th scope="col">-</th>
                                    <th scope="col">Cons</th>
                                    <th scope="col">Rango</th>
                                    <th scope="col">Linea</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2"> 
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active font-weight-bold">
                        DEPARTAMENTO
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">10 CORTE
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">110 PESPUNTE
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">150 TEJIDO
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">180 MONTADO
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">210 ADORNO
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">270 CALCE
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">280 CALIDAD
                    </a>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <img id="Foto" src="<?php print base_url('img/camera.png'); ?>" class="img-responsive img-fluid">
            </div>
        </div>
    </div>
</div>
<style>
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid; 
        border-image: linear-gradient(to bottom,  #0099cc, #ccff00, rgb(0,0,0,0)) 1 100% ;
    }

    .card-header{ 
        background-color: transparent;
        border-bottom: 0px;
    }

    /*LEATHER THEME*/
    .text-success.navbar-brand{
        color: #FFEB3B !important;
    }
    nav > .btn-primary, nav li > .btn-primary{
        background-color: transparent !important; 
        border-color: transparent !important; 
    } 
    .bg-primary{
        background-image: url("<?php print base_url('css/images/leather.jpg'); ?>") !important;
        background-size: contain;   
    }
    #sidebar.bg-primary{
        background-image: url("<?php print base_url('css/images/xxx.jpg'); ?>") !important;
        background-size: contain;   
    }
    .dropdown-item:hover, .dropdown-item:focus {
        color: #ffffff;
        font-weight: bold;
        text-decoration: none;
        background-color: transparent;
        background-image: url(http://127.0.0.1/ERP_CAL/css/images/leather.jpg) !important;
        background-size: contain;
    }
</style>
<script>
    var pnlTablero = $("#pnlTablero"), Estilo = pnlTablero.find("#Estilo"),
            Color = pnlTablero.find("#Color"), Depto = pnlTablero.find("#Depto"),
            FichaTecnica, tblFichaTecnica = pnlTablero.find("#tblFichaTecnica"), Foto = pnlTablero.find("#Foto");
    $(document).ready(function () {

        Color.change(function () {
            if (Estilo.val() && Color.val()) {
                FichaTecnica.ajax.reload();
                Depto.focus();
            }
        });

        Estilo.on('keydown', function (e) {
            if (e.keyCode === 13 && Estilo.val()) {
                getColoresXEstilo();
                getFotoXEstilo();
            }
        }).focusout(function () {
            if (Estilo.val()) {
                getColoresXEstilo();
                getFotoXEstilo();
            }
        }).change(function () {
            if (Estilo.val() && Color.val()) {
                FichaTecnica.ajax.reload();
                getFotoXEstilo();
            }
        });
        var coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ];
        FichaTecnica = tblFichaTecnica.DataTable({
            "dom": 'rtip',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": '<?php print base_url('DesarrolloMuestras/getRecords'); ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.ESTILO = Estilo.val();
                    d.COLOR = Color.val();
                }
            },
            "columns": [
                {"data": "ID"},
                {"data": "Estilo"},
                {"data": "Pza"},
                {"data": "PzaT"},
                {"data": "Sec"},
                {"data": "Articulo"},
                {"data": "ArticuloT"},
                {"data": "Cons"},
                {"data": "Rango"},
                {"data": "Linea"}
            ],
            "columnDefs": coldefs,
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "scrollY": "350px",
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc']
            ]
        });
    });
    function getColoresXEstilo() {
        Color[0].selectize.clear(true);
        Color[0].selectize.clearOptions();
        $.getJSON('<?php print base_url('DesarrolloMuestras/getColoresXEstilo'); ?>', {
            ESTILO: Estilo.val()
        }).done(function (a) {
            if (a.length > 0) {
                a.forEach(function (x) {
                    Color[0].selectize.addOption({text: x.COLOR, value: x.CLAVE});
                });
            } else {
                swal('ATENCIÓN', 'ESTE ESTILO LO TIENE COLORES', 'warning').then((value) => {
                    Estilo.val('');
                    Estilo.focus().select();
                });
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            Color[0].selectize.open();
        });
    }

    function getFotoXEstilo() {
        $.getJSON('<?php print base_url('DesarrolloMuestras/getFotoXEstilo'); ?>', {
            ESTILO: Estilo.val()
        }).done(function (a) {
            console.log(a);
            if (a.length > 0) {
                Foto[0].src = '<?php print base_url() ?>' + a[0].Foto;
            } else {
                Foto[0].src = '<?php print base_url('img/camera.png'); ?>';
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
        });
    }
</script>