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
        background-color: #f2f2f2;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px; 
    }
    .div-login {
        width: 100%;
        max-width: 330px;
        padding: 0px;
        margin: auto;
    } 
    .btn{
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23)!important;
    }
    body, html {
        height: 100%; 
        /* The image used */ 
        <?php if ($this->session->TEMA === "ACTUAL") { ?>
            background-image: url("<?php print base_url('media/x7.jpg'); ?>");
            <?php
        }
        ?>

        /* Full height */
        height: 100%;

        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
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
<?php if ($this->session->TEMA === "ACTUAL") { ?>
    <div id="pnlAcceso" class="card  div-login animated fadeIn card-session" style="background-color: rgba(255, 255, 255, 0) !important; ">
        <div class="card-body" style="padding: 15px;">
            <div class="row" style="padding: 15px;">
                <div class="col-12 text-center mb-4" onclick="$('#iplocal').toggleClass('d-none');">
                    <!--<span class="fa fa-user-lock fa-2x"></span>-->
                    <span class="fa fa-user fa-2x animated slideInDown"></span>
                    <h4 class="m-3 animated slideInDown">CONTROL DE ACCESO</h4>
                </div>
                <div class="col-12">
                    <input type="email" id="Usuario" name="Usuario" class="form-control not-form-small animated slideInRight" placeholder="Usuario" required autofocus="">
                </div >
                <div class="col-12">
                    <input type="password" id="Contrasena" name="Contrasena" class="form-control not-form-small mt-3  animated slideInLeft" placeholder="Contraseña" required>
                </div >
                <div id="iplocal" class="text-center d-none col-12">
                    <span class="font-weight-bold font-italic" style="font-size: 16px"><?php print ($_SERVER['HTTP_HOST']); ?></span>
                </div>
            </div>
        </div>
        <div class="card-footer text-center" onclick="btnIngresar.trigger('click');">
            <!--<span class="fa fa-angle-double-left"></span> INGRESAR  <span class="fa fa-angle-double-right"></span>-->

            <button class="btn btn-info btn-block font-weight-bold  animated slideInUp" id="btnIngresarr" type="button"
                    style="background: rgb(161,218,242); background: linear-gradient(90deg, rgba(161,218,242,1) 0%, rgba(0,144,179,1) 50%, rgba(0,22,27,1) 100%); border: none !important; font-size: 15px;">
                INGRESAR 
            </button>
        </div>
        <button class="btn btn-block d-none" id="btnIngresar" type="button" style="background-color: rgba(255, 255, 255, 0.3) !important;"></button>
    </div>
    <?php
} else {
    ?>
    <div id="pnlAcceso" class="card  div-login card-session" style="border-radius:none !important; background-color: #0000008a;">
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
    <?php
}
?>
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
    .card-transparent{ 
        color: #fff !important;
        border: none !important;
        box-shadow:none !important;
    } 
    .text-muted{
        color:#fff !important;
        text-shadow: 3px 4px 5px #000000;
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
    }
    .card  .card-body{
        cursor: pointer !important;
        font-weight: bold;  
        <?php  
        if ($this->session->TEMA === "ACTUAL") { ?>
         background-color: transparent;  
         border: none;
        <?php
        } else  
        if ($this->session->TEMA === "OSCURO") { ?>
         background-color: #0000008a;  
        <?php
        } else 
        if ($this->session->TEMA !== "ACTUAL" || $this->session->TEMA !== "OSCURO") { ?>
            color: #000;
            background: #ffffff; /* Old browsers */
            background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #ededed 100%); /* FF3.6-15 */
            background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%); /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom,  #ffffff 0%,#f6f6f6 47%,#ededed 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 ); /* IE6-9 */
        <?php } ?>
    }
    .card .card-footer{
        border-top: none !important;
        cursor: pointer !important; 
        color: #fff;
        <?php if ($this->session->TEMA === "OSCURO") { ?>
        font-size: 20px;
        <?php 
        }else if ($this->session->TEMA !== "ACTUAL" || $this->session->TEMA !== "OSCURO") { ?>
            /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#2b2b2b+0,272727+100 */
            background: #2b2b2b; /* Old browsers */
            background: -moz-linear-gradient(top,  #2b2b2b 0%, #272727 100%); /* FF3.6-15 */
            background: -webkit-linear-gradient(top,  #2b2b2b 0%,#272727 100%); /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom,  #2b2b2b 0%,#272727 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2b2b2b', endColorstr='#272727',GradientType=0 ); /* IE6-9 */
        <?php } ?>
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
        color: #fff; 
        font-style: italic;
        <?php if ($this->session->TEMA === "ACTUAL") { ?>
            border-radius: 10px; 
            text-shadow: 0 0 3px #000, 0 0 5px #0000FF !important;
        <?php } else { ?>
            border-radius:0px !important;
            border: 2px solid #000;
        <?php } ?>
    }

</style>
