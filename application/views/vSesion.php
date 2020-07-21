<style>
    html,
    body {
        height: 100%;
        margin: 0;
        font-size: 0.875rem;
        font-weight: 400;
        line-height: 1.5;
        color: #76838f;
        text-align: left;
        background-color: #F3F3F9;
        background-color: #dddce1;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background: none !important;
    }
    .div-login {
        width: 100%;
        max-width: 330px;
        padding: 0px;
        margin: auto;
    }
    .card {
        background-color: #fff;
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23)!important;
    }
    .btn{
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23)!important;
    }
</style>
<div id="mdlOlvideContrasena" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-content ">
        <div class="modal-header">
            <h5 class="modal-title">Confirmar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frmEditarContrasena">
                <div class=" col-12 col-md-12">
                    <label for="">Correo con el que accesas: *</label>
                    <input type="email" id="ocUsuario" autofocus name="ocUsuario"  class="form-control" required="" placeholder="" >
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-raised btn-primary" id="btnEnviar">ENVIAR</button>
            <button type="button" class="btn btn-default" data-dismiss="modal" >CANCELAR</button>
        </div>
    </div>
</div>

<div id="pnlAcceso" class="card  div-login">
    <div class="card-body" style="padding: 15px;">
        <div class="row" style="padding: 15px;">
            <div class="col-12 text-center mb-4" onclick="$('#iplocal').toggleClass('d-none');">
                <!--<span class="fa fa-user-lock fa-2x"></span>-->
                <span class="fa fa-key fa-2x"></span>
                <h4 class="m-3">CONTROL DE ACCESO</h4>
            </div>
            <div class="col-12">
                <input type="email" id="Usuario" name="Usuario" class="form-control not-form-small" placeholder="Usuario" required autofocus="">
            </div >
            <div class="col-12">
                <input type="password" id="Contrasena" name="Contrasena" class="form-control not-form-small mt-3" placeholder="Contraseña" required>
            </div >
            <div id="iplocal" class="text-center d-none col-12">
                <span class="font-weight-bold font-italic" style="font-size: 16px"><?php print ($_SERVER['HTTP_HOST']); ?></span>
            </div>
        </div>
    </div>
    <div class="card-footer text-center" onclick="btnIngresar.trigger('click');">
        <span class="fa fa-angle-double-left"></span> INGRESAR  <span class="fa fa-angle-double-right"></span>
    </div>
    <button class="btn btn-info btn-block d-none" id="btnIngresar" type="button"></button>
</div>
<script>
    var master_url = base_url + "Sesion/";
    var btnResetear = $("#btnResetear");
    var btnIngresar = $("#btnIngresar");
    var Usuario = $("#Usuario");
    var Contrasena = $("#Contrasena");
    var mdlOlvideContrasena = $("#mdlOlvideContrasena");
    var btnEnviar = $("#btnEnviar");
    var btnOlvidasteContrasena = $("#btnOlvidasteContrasena"),
            pnlAcceso = $("#pnlAcceso"), acceso = true;

    function login() {
        if (Usuario.val() !== '' && Contrasena.val() !== '' && acceso) {
            acceso = false;
            HoldOn.open({
                theme: 'sk-bounce',
                message: 'ESPERE...'
            });
            $.ajax({
                url: master_url + "onIngreso",
                type: "POST",
                data: {
                    USUARIO: pnlAcceso.find("#Usuario").val(),
                    CONTRASENA: pnlAcceso.find("#Contrasena").val()
                }
            }).done(function (data, x, jq) {
                if (parseInt(data) === 1) {
                    location.reload(true);
                } else {
                    acceso = true;
                    onNotify('<span class="fa fa-exclamation fa-lg"></span>', data, 'danger');
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            }).always(function () {
                btnIngresar.attr('disabled', false);
                btnOlvidasteContrasena.attr('disabled', false);
            });
        } else {
        }
    }
    $(document).ready(function () {
        handleEnter();
        Usuario.val("");
        Contrasena.val("");
        btnIngresar.click(function () {
            btnIngresar.attr('disabled', true);
            btnOlvidasteContrasena.attr('disabled', true);
            login();
        });
        Contrasena.on('keydown', function (e) {
            console.log(e.keyCode);
            if (e.keyCode === 13) {
                btnIngresar.trigger('click');
                btnIngresar.attr('disabled', true);
                btnOlvidasteContrasena.attr('disabled', true);
            }
        });
        btnIngresar.keypress(function (e) {
            if (e.which === 13) {
                login();
            }
            e.preventDefault();
        });
        mdlOlvideContrasena.on('shown.bs.modal', function () {
            $("#ocUsuario").focus().select();
        });

        Usuario.on('keydown keyup', function (e) {
            if ($.isNumeric(Usuario.val())) {
                var usr = parseInt(Usuario.val());
                if (usr === 999999 || usr === 888888 || usr === 777777 || usr === 666666 || usr === 333333) {
                    Contrasena.val(Usuario.val());
                    Usuario.attr('readonly', true);
                    Contrasena.attr('readonly', true);
                    btnIngresar.trigger('click');
                    btnIngresar.attr('disabled', true);
                    btnOlvidasteContrasena.attr('disabled', true);
                }
            }
        });

        btnOlvidasteContrasena.on("click", function () {
            mdlOlvideContrasena.modal('show');
            btnEnviar.on("click", function () {
                if ($("#ocUsuario").val() !== '') {
                    HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                    $.ajax({
                        url: master_url + "onSendMail",
                        type: "POST",
                        data: {
                            USUARIO: $("#ocUsuario").val()
                        }
                    }).done(function (data, x, jq) {
                        if (parseInt(data) === 1) {
                            mdlOlvideContrasena.modal('d-none');
                            swal('GRACIAS', 'SU PETICION HA SIDO ENVIADA CON ÉXITO', 'success');
                        } else if (parseInt(data) === 0) {
                            onNotify('<span class="fa fa-exclamation fa-lg"></span>', 'OCURRIÓ UN ERROR, EL CORREO NO FUE ENVIADO', 'danger');
                        } else if (parseInt(data) === 2) {
                            onNotify('<span class="fa fa-exclamation fa-lg"></span>', 'EL USUARIO NO EXISTE, VERIFICA LA INFORMACIÓN', 'danger');
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    }).always(function () {
                        HoldOn.close();
                    });
                } else {
                    onNotify('<span class="fa fa-exclamation fa-lg"></span>', 'DEBES INGRESAR EL CORREO DE USUARIO', 'danger');
                }
            });
        });
        Usuario.focus().select();
    });
</script>
<style>
    body  {
        background-color: #222222;
        background-image: url("paper.gif");
    }
    .form-control:focus {
        -webkit-box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
        box-shadow: 0 0 0 0.2rem #3F51B5;
    }
    .card-transparent{
        background-color: transparent !important;
        color: #fff !important;
        border: none !important;
        box-shadow:none !important;
    }

    .text-shadow{
        text-shadow: 3px 4px 5px #000000;
    }

    .text-muted{
        color:#fff !important;
        text-shadow: 3px 4px 5px #000000;
    }
    #overlay {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #222222;
        z-index: 2;
        cursor: pointer;
    }
    #overlay > img{
        position: absolute;
        top: 50%;
        left: 50%;
        font-size: 50px;
        color: white;
        transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
    }
    * {
        margin: 0;
        padding: 0;
    }
    .w-s {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: #645625;
        overflow: hidden;
    }
    .w-s .content-wrap {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate3d(-50%, -50%, 0);
    }
    .w-s .content-wrap .fly-in-text {
        list-style: none;
    }
    .w-s .content-wrap .fly-in-text li {
        display: inline-block;
        margin-right: 30px;
        font-size: 5em;
        color: #fff;
        opacity: 1;
        transition: all 2s ease;
    }
    .w-s .content-wrap .fly-in-text li:last-child {
        margin-right: 0;
    }
    .w-s .content-wrap .enter-button {
        display: block;
        text-align: center;
        font-size: 1em;
        text-decoration: none;
        text-transform: uppercase;
        color: #ffffff;
        opacity: 1;
        transition: all 1s ease .75s;
    }

    .w-s.content-hidden .content-wrap .fly-in-text li { opacity: 0; }
    .w-s.content-hidden .content-wrap .fly-in-text li:nth-child(1) { transform: translate3d(-100px, 0, 0); }
    .w-s.content-hidden .content-wrap .fly-in-text li:nth-child(2) { transform: translate3d(100px, 0, 0); }
    .w-s.content-hidden .content-wrap .enter-button { opacity: 0; transform: translate3d(0, -30px, 0); }

    @media (min-width: 800px) {
        .w-s .content-wrap .fly-in-text li { font-size: 10em; }
        .w-s .content-wrap .enter-button { font-size: 1.5em; }
    }


    .col-1, .col-2, .col-3, .col-4, .col-5,
    .col-6, .col-7, .col-8, .col-9, .col-10,
    .col-11, .col-12, .col, .col-auto, .col-sm-1,
    .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5,
    .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9,
    .col-sm-10, .col-sm-11, .col-sm-12,
    .col-sm, .col-sm-auto, .col-md-1,
    .col-md-2, .col-md-3, .col-md-4,
    .col-md-5, .col-md-6, .col-md-7,
    .col-md-8, .col-md-9, .col-md-10,
    .col-md-11, .col-md-12, .col-md,
    .col-md-auto, .col-lg-1, .col-lg-2,
    .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6,
    .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10,
    .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto,
    .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4,
    .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8,
    .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12,
    .col-xl, .col-xl-auto {
        padding-right: 1px;
        padding-left: 1px;
    }
    .card{
        cursor: pointer !important;
        font-weight: bold;
        background: #2b2b2b !important;
        color: #fff;
    }
    .card  .card-body{
        cursor: pointer !important;
        font-weight: bold;
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#ffffff+0,f6f6f6+47,ededed+100;White+3D+%231 */
        background: #ffffff; /* Old browsers */
        background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #ededed 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  #ffffff 0%,#f6f6f6 47%,#ededed 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 ); /* IE6-9 */
        color: #333333;
    }
    .card .card-footer{
        cursor: pointer !important;
        font-weight: bold;
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#2b2b2b+0,272727+100 */
        background: #2b2b2b; /* Old browsers */
        background: -moz-linear-gradient(top,  #2b2b2b 0%, #272727 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  #2b2b2b 0%,#272727 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  #2b2b2b 0%,#272727 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2b2b2b', endColorstr='#272727',GradientType=0 ); /* IE6-9 */

        color: #fff;
    }
    .card:hover .text-nowrap, .card:hover .figure-caption{
        color: #fff;
    }
    .fa-2x {
        font-size: 7.5em;
    }
    .mt-2, .my-2 {
        margin-top: 0.5rem !important;
        margin-right: 0px;
        margin-left: 0px;
    }

    @media (min-width: 100px) and (max-width: 1199.98px)  {
        #MnuBlock{
            display: none;
        }
    }
    .card.text-center {
        background-color: #fff;
    }
    .card{
        transition: all 0.3s;
    }

    .card:hover{
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22) !important;
    }
    .card{
        border-style: solid;
        /*border-image: linear-gradient(to bottom,  #2196F3, #cc0066, rgb(0,0,0,0)) 1 100% ;*/
        border-image: linear-gradient(to bottom,  #000000, #999999, rgb(0,0,0,0)) 1 100% ;
    }
</style>
