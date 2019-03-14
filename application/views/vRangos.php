<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Rangos</legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-primary" id="btnNuevo" data-toggle="tooltip" data-placement="left" title="Agregar"><span class="fa fa-plus"></span><br></button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Rangos" class="table-responsive">
                <table id="tblRangos" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Clave</th>
                            <th>Serie</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card m-3 d-none animated fadeIn" id="pnlDatos">
    <div class="card-body text-dark">
        <form id="frmNuevo">
            <fieldset>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 float-left">
                        <legend >Rangos</legend>
                    </div>
                    <div class="col-12 col-sm-6 col-md-8" align="right">
                        <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                            <span class="fa fa-arrow-left" ></span> REGRESAR
                        </button>
                        <button type="button" class="btn btn-danger btn-sm d-none" id="btnEliminar">
                            <span class="fa fa-trash fa-1x"></span> ELIMINAR
                        </button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="d-none">
                        <input type="text"  name="ID" class="form-control form-control-sm" >
                    </div>
                    <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label for="Clave" >Clave*</label>
                        <input type="text" class="form-control form-control-sm" id="Clave" name="Clave" maxlength="5" required >
                    </div>
                    <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label for="" >Serie*</label>
                        <select id="Serie" name="Serie" class="form-control form-control-sm" required="">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2" style=" overflow-x:auto; white-space: nowrap;" id="SerieF">
                        <?php
                        for ($i = 1; $i <= 22; $i++) {
                            print '<input type="text" style="width: 45px;" maxlength="4" class="numbersOnly" disabled="" readonly=""  name="T' . $i . '" placeholder="">';
                        }
                        ?>
                    </div>

                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <label for="Rango">De la talla A la talla*</label>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInUno" name="PtoInUno" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinUno" name="PtoFinUno" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInDos" name="PtoInDos" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinDos" name="PtoFinDos" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInTres" name="PtoInTres" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinTres" name="PtoFinTres" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInCuatro" name="PtoInCuatro" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinCuatro" name="PtoFinCuatro" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInCinco" name="PtoInCinco" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinCinco" name="PtoFinCinco" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInSeis" name="PtoInSeis" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinSeis" name="PtoFinSeis" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInSiete" name="PtoInSiete" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinSiete" name="PtoFinSiete" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInOcho" name="PtoInOcho" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinOcho" name="PtoFinOcho" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInNueve" name="PtoInNueve" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinNueve" name="PtoFinNueve" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInDiez" name="PtoInDiez" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinDiez" name="PtoFinDiez" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInOnce" name="PtoInOnce" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinOnce" name="PtoFinOnce" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInDoce" name="PtoInDoce" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinDoce" name="PtoFinDoce" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInTrece" name="PtoInTrece" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinTrece" name="PtoFinTrece" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInCatorce" name="PtoInCatorce" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinCatorce" name="PtoFinCatorce" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <label for="Rango">De la talla A la talla*</label>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInQuince" name="PtoInQuince" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinQuince" name="PtoFinQuince" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInDieciseis" name="PtoInDieciseis" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinDieciseis" name="PtoFinDieciseis" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInDiecisiete" name="PtoInDiecisiete" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinDiecisiete" name="PtoFinDiecisiete" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInDieciocho" name="PtoInDieciocho" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinDieciocho" name="PtoFinDieciocho" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInDiecinueve" name="PtoInDiecinueve" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinDiecinueve" name="PtoFinDiecinueve" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInVeinte" name="PtoInVeinte" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinVeinte" name="PtoFinVeinte" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInVeintiuno" name="PtoInVeintiuno" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinVeintiuno" name="PtoFinVeintiuno" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInVeintidos" name="PtoInVeintidos" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinVeintidos" name="PtoFinVeintidos" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInVeintitres" name="PtoInVeintitres" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinVeintitres" name="PtoFinVeintitres" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInVeinticuatro" name="PtoInVeinticuatro" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinVeinticuatro" name="PtoFinVeinticuatro" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInVeinticinco" name="PtoInVeinticinco" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinVeinticinco" name="PtoFinVeinticinco" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInVeintiseis" name="PtoInVeintiseis" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinVeintiseis" name="PtoFinVeintiseis" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInVeintisiete" name="PtoInVeintisiete" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinVeintisiete" name="PtoFinVeintisiete" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInVeintiocho" name="PtoInVeintiocho" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinVeintiocho" name="PtoFinVeintiocho" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <label for="Rango">De la talla A la talla*</label>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInVeintinueve" name="PtoInVeintinueve" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinVeintinueve" name="PtoFinVeintinueve" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInTreinta" name="PtoInTreinta" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinTreinta" name="PtoFinTreinta" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInTreintayuno" name="PtoInTreintayuno" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinTreintayuno" name="PtoFinTreintayuno" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInTreintaydos" name="PtoInTreintaydos" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinTreintaydos" name="PtoFinTreintaydos" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInTreintaytres" name="PtoInTreintaytres" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinTreintaytres" name="PtoFinTreintaytres" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInTreintaycuatro" name="PtoInTreintaycuatro" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinTreintaycuatro" name="PtoFinTreintaycuatro" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInTreintaycinco" name="PtoInTreintaycinco" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinTreintaycinco" name="PtoFinTreintaycinco" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInTreintayseis" name="PtoInTreintayseis" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinTreintayseis" name="PtoFinTreintayseis" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInTreintaysiete" name="PtoInTreintaysiete" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinTreintaysiete" name="PtoFinTreintaysiete" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInTreintayocho" name="PtoInTreintayocho" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinTreintayocho" name="PtoFinTreintayocho" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInTreintaynueve" name="PtoInTreintaynueve" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinTreintaynueve" name="PtoFinTreintaynueve" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInCuarenta" name="PtoInCuarenta" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinCuarenta" name="PtoFinCuarenta" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInCuarentayuno" name="PtoInCuarentayuno" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinCuarentayuno" name="PtoFinCuarentayuno" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6"><input type="text" id="PtoInCuarentaydos" name="PtoInCuarentaydos" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                            <div class="col-6"><input type="text" id="PtoFinCuarentaydos" name="PtoFinCuarentaydos" class="form-control form-control-sm numbersOnly" maxlength="4"></div>
                        </div>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-12 col-md-12 ">
                        <h6 class="text-danger">Los campos con * son obligatorios</h6>
                    </div>
                    <button type="button" class="btn btn-info btn-lg btn-float" id="btnGuardar" data-toggle="tooltip" data-placement="left" title="Guardar">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/Rangos/';
    var tblRangos = $('#tblRangos');
    var Rangos;
    var pnlTablero = $("#pnlTablero"), pnlDatos = $("#pnlDatos");
    var btnNuevo = $("#btnNuevo"), btnCancelar = $("#btnCancelar"), btnEliminar = $("#btnEliminar"), btnGuardar = pnlDatos.find("#btnGuardar");
    var nuevo = false;

    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();
        handleEnter();
        validacionSelectPorContenedor(pnlDatos);
        setFocusSelectToInputOnChange('#Serie', '#PtoInUno', pnlDatos);

        /*FUNCIONES X BOTON*/
        pnlDatos.find("#Clave").focusout(function () {
            if (nuevo) {
                onComprobarClave(this);
            }
        });

        pnlDatos.find("#Serie").change(function () {
            if ($(this).val() !== '') {
                getSerieXClave($(this).val());
            } else {
                pnlDatos.find('#SerieF').find("input").val('');
            }
        });

        btnGuardar.click(function () {
            isValid('pnlDatos');
            if (valido) {
                var frm = new FormData(pnlDatos.find("#frmNuevo")[0]);
                if (!nuevo) {
                    $.ajax({
                        url: master_url + 'onModificar',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data, x, jq) {
                        swal('ATENCIÓN', 'SE HA MODIFICADO EL REGISTRO', 'info');
                        Rangos.ajax.reload();
                        pnlDatos.addClass("d-none");
                        pnlTablero.removeClass("d-none");
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    }).always(function () {
                        HoldOn.close();
                    });
                } else {
                    btnGuardar.addClass("d-none");
                    frm.append('Estatus', 'ACTIVO');
                    $.ajax({
                        url: master_url + 'onAgregar',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data, x, jq) {
                        pnlDatos.find("[name='ID']").val(data);
                        nuevo = false;
                        Rangos.ajax.reload();
                        pnlDatos.addClass("d-none");
                        pnlTablero.removeClass("d-none");
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    }).always(function () {
                        HoldOn.close();
                        btnGuardar.removeClass("d-none");//SE AGREGO POR QUE SI LE DEJAN APRETADO AL ENTER, ESTE BOTON SE EJECUTA 2 VECES NO ALCANZA A CERRARSE EL FORMULARIO Y EL FOCUS CONTINUA DESPUES DE GUARDARSE EN EL BOTON Y LO VUELVE A EJECUTAR
                    });
                }
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });

        btnEliminar.click(function () {
            swal({
                title: "¿Estas seguro?",
                text: "Nota: No se eliminara ninguna unidad que tenga alguna relacion con otro dato dentro del sistema",
                icon: "warning",
                buttons: {
                    cancelar: {
                        text: "Cancelar",
                        value: "cancelar"
                    },
                    eliminar: {
                        text: "Aceptar",
                        value: "eliminar"
                    }
                }
            }).then((value) => {
                switch (value) {
                    case "eliminar":
                        $.post(master_url + 'onEliminar', {ID: temp}).done(function () {
                            swal('ATENCIÓN', 'SE HA ELIMINADO EL REGISTRO', 'success');
                            Rangos.ajax.reload();
                        }).fail(function (x, y, z) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x.responseText);
                        });
                        break;
                    case "cancelar":
                        swal.close();
                        break;
                }
            });
        });

        btnNuevo.click(function () {
            nuevo = true;
            pnlDatos.find("input").val("");
            pnlTablero.addClass("d-none");
            pnlDatos.removeClass("d-none");
            btnEliminar.addClass("d-none");
            pnlDatos.find("[name='Clave']").focus();
            $.each(pnlDatos.find("select"), function (k, v) {
                pnlDatos.find("select")[k].selectize.clear(true);
            });
        });

        btnCancelar.click(function () {
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass("d-none");
        });
    });

    function init() {
        getRecords();
        getSeries();
    }



    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblRangos')) {
            tblRangos.DataTable().destroy();
        }
        Rangos = tblRangos.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"}, {"data": "Clave"}, {"data": "Serie"}
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
            "displayLength": 20,
            "scrollX": true,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'desc']/*ID*/
            ]
        });

        $('#tblRangos_filter input[type=search]').focus();

        tblRangos.find('tbody').on('click', 'tr', function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'CARGANDO...'
            });
            nuevo = false;
            tblRangos.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Rangos.row(this).data();
            temp = parseInt(dtm.ID);
            $.getJSON(master_url + 'getRangoByID', {ID: temp}).done(function (data) {
                pnlDatos.find("input").val("");
                $.each(pnlDatos.find("select"), function (k, v) {
                    pnlDatos.find("select")[k].selectize.clear(true);
                });
                $.each(data[0], function (k, v) {
                    pnlDatos.find("[name='" + k + "']").val(v);
                    if (pnlDatos.find("[name='" + k + "']").is('select')) {
                        pnlDatos.find("[name='" + k + "']")[0].selectize.addItem(v, true);
                    }
                });
                pnlTablero.addClass("d-none");
                pnlDatos.removeClass('d-none');
                btnEliminar.removeClass("d-none");

                pnlDatos.find("[name='Clave']").addClass('disabledForms');
                pnlDatos.find("#PtoInUno").focus().select();
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            }).always(function () {
                HoldOn.close();
            });
        });
        HoldOn.close();
    }

    function getSeries() {
        $.ajax({
            url: master_url + 'getSeries',
            type: "POST",
            dataType: "JSON"
        }).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlDatos.find("#Serie")[0].selectize.addOption({text: v.Serie, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getSerieXClave(Serie) {
        $.ajax({
            url: master_url + 'getSerieXClave',
            type: "POST",
            dataType: "JSON",
            data: {
                Clave: Serie
            }
        }).done(function (data, x, jq) {
            if (data.length > 0) {
                $.each(data[0], function (k, v) {
                    pnlDatos.find('#SerieF').find("[name='" + k + "']").val(v);
                });
                pnlDatos.find('#Rango').focus();
            } else {
                swal('ATENCIÓN', 'NO SE HAN PODIDO OBTENER LAS SERIES, INTENTE DE NUEVO', 'error');
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }


    function onComprobarClave(e) {
        if (nuevo) {
            $.getJSON(master_url + 'onComprobarClave', {Clave: $(e).val()}).done(function (data) {

                if (data.length > 0) {
                    swal({
                        title: "ATENCIÓN",
                        text: "LA CLAVE " + pnlDatos.find("#Clave").val() + " YA EXISTE",
                        icon: "warning",
                        buttons: {
                            eliminar: {
                                text: "Aceptar",
                                value: "aceptar"
                            }
                        }
                    }).then((value) => {
                        switch (value) {
                            case "aceptar":
                                swal.close();
                                pnlDatos.find("#Clave").val('').focus();
                                break;

                        }
                    });
                } else {
                    pnlDatos.find("#Serie")[0].selectize.focus();
                }
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });
        }
    }
</script>