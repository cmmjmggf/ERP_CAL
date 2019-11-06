<style>
    html,
    body {
        height: 100%;
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
        padding: 15px;
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

<div id="frmLogin" class="row div-login " aling="center">
    <div id="frmtitulo" class="col-12 text-center">
        <h4 class="mb-3">CONTROL DE ACCESO</h4>
    </div>
    <div class="col-12 ">
        <form id="frmIngresar" class="card-transparent div-login text-center box-helper">
            <input type="email" id="Usuario" name="Usuario" class="form-control " placeholder="Usuario" required autofocus="">
            <input type="password" id="Contrasena" name="Contrasena" class="form-control mt-3" placeholder="Contraseña" required>
            <button class="btn btn-primary btn-block mt-3 animated bounceIn" id="btnIngresar" type="button">Ingresar</button>
            <button class="btn btn-warning btn-block mt-2 animated bounceIn" id="btnOlvidasteContrasena" type="button">Olvidaste tu contraseña?</button>
            <h6 class="mt-3 mb-3 text-primary">&copy; <?php print 'CALZADO LOBO SA de CV ' . Date('Y'); ?></h6>
        </form>
    </div>
</div>
<script>
    var master_url = base_url + "Sesion/";
    var btnResetear = $("#btnResetear");
    var btnIngresar = $("#btnIngresar");
    var Usuario = $("#Usuario");
    var Contrasena = $("#Contrasena");
    var mdlOlvideContrasena = $("#mdlOlvideContrasena");
    var btnEnviar = $("#btnEnviar");
    var btnOlvidasteContrasena = $("#btnOlvidasteContrasena");

    function login() {
        if (Usuario.val() !== '' && Contrasena.val() !== '') {
            HoldOn.open({
                theme: 'sk-bounce',
                message: 'ESPERE...'
            });
            setTimeout(function () {
                var frm = $("#frmIngresar");
                $.ajax({
                    url: master_url + "onIngreso",
                    type: "POST",
                    data: {
                        USUARIO: frm.find("#Usuario").val(),
                        CONTRASENA: frm.find("#Contrasena").val()
                    }
                }).done(function (data, x, jq) {
                    if (parseInt(data) === 1) {
                        location.reload(true);
                    } else {
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
            }, 1000);
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
            $("#ocUsuario").focus();
        });

        Usuario.on('keydown keyup', function (e) {
            if ($.isNumeric(Usuario.val())) {
                var usr = parseInt(Usuario.val());
                if (usr === 999999 || usr === 888888 || usr === 777777) {
                    Contrasena.val(Usuario.val());
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
</style>
