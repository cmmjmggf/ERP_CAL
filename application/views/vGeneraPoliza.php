<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Genera Pólizas</legend>
            </div>
            <div class="col-sm-4" align="right">

            </div>
        </div>
        <div class="row" id="Encabezado">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Tp" name="Tp" maxlength="1" required="">
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-xl-2" >
                <label for="" >Póliza</label>
                <select id="Poliza" name="Poliza" class="form-control form-control-sm required" required="" >
                    <option value=""></option>
                    <?php
                    foreach ($this->db->select("C.ID AS CLAVE, CONCAT(C.ID, \" - \",C.despol) AS nompol ", false)
                            ->from('tipopolizas AS C')->order_by('ABS(C.ID)', 'ASC')->get()->result() as $k => $v) {
                        print "<option value='{$v->CLAVE}'>{$v->nompol}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label>Fecha</label>
                <input type="text" class="form-control form-control-sm  numbersOnly date notEnter" id="Fecha" name="Fecha" maxlength="12" required>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-9 col-md-7 col-lg-7 col-xl-5">
                <input type="text" class="form-control form-control-sm " readonly="" id="TipoPoliza" name="TipoPoliza">
            </div>
        </div>

        <div class="card mt-3 bg-info text-white" id = "poliMaquilas">
            <div class="card-header">
                <label style="font-size:15px;">Esta parte es sólo para pólizas de maquilas</label>
            </div>
            <div class="card-body">
                <div class="row" >
                    <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                        <label>Año</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Ano" maxlength="4" >
                    </div>
                    <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                        <label>Maq</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Maq" maxlength="2" >
                    </div>
                    <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                        <label>De la Fecha</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly date notEnter" id="dFecha" name="dFecha" maxlength="12" >
                    </div>
                    <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                        <label>A la Fecha</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly date notEnter" id="aFecha" name="dFecha" maxlength="12" >
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary btn-sm" id="btnAceptar">
                    <i class="fa fa-check"></i> ACEPTAR
                </button>
            </div>
        </div>


    </div>
</div>

<script>
    var master_url = base_url + 'index.php/DocDirecSinAfectacion/';
    var tblDocumentosDirectos = $('#tblDocumentosDirectos');
    var DocumentosDirectos;
    var pnlTablero = $("#pnlTablero");
    var btnAceptar = pnlTablero.find('#btnAceptar');


    $(document).ready(function () {

        /*FUNCIONES INICIALES*/
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#Fecha").val(getToday());
        pnlTablero.find("#Tp").focus();
        pnlTablero.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTp($(this));
                }
            }
        });
        pnlTablero.find("#Poliza").change(function () {
            if ($(this).val()) {
                pnlTablero.find("#Fecha").focus();
            }
        });
        pnlTablero.find("#Fecha").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    btnAceptar.focus();
                }
            }
        });

        pnlTablero.find("#Ano").keypress(function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                    swal({
                        title: "ATENCIÓN",
                        text: "AÑO INCORRECTO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        pnlTablero.find("#Ano").val("");
                        pnlTablero.find("#Ano").focus();
                    });
                } else {
                    pnlTablero.find("#Maq").focus().select();
                }
            }
        });

        pnlTablero.find("#Maq").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onComprobarMaquilas($(this));
                }
            }
        });

        pnlTablero.find("#dFecha").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    pnlTablero.find("#aFecha").focus();
                }
            }
        });

        pnlTablero.find("#aFecha").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    btnAceptar.focus();
                }
            }
        });

        btnAceptar.click(function () {
            isValid('pnlTablero');
            if (valido) {
                swal({
                    buttons: ["Cancelar", "Aceptar"],
                    title: 'Estás Seguro?',
                    text: "Esta acción no se puede revertir",
                    icon: "warning",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {
                        var tp = pnlTablero.find("#Tp").val();
                        var prov = pnlTablero.find("#Proveedor").val();
                        var doc = pnlTablero.find('#Doc').val();
                        var fecDoc = pnlTablero.find('#FechaDoc').val();
                        var importe = pnlTablero.find("#Importe").val();
                        var TipoCont = pnlTablero.find("#TipoCont").val();
                        var Grupo = pnlTablero.find("#Grupo").val();
                        var Flete = pnlTablero.find("#Flete").val();
                        var Moneda = pnlTablero.find("#Moneda").val();
                        var TipoCambio = pnlTablero.find("#TipoCambio").val();
                        $.post(master_url + 'onAgregar', {

                            Tp: tp,
                            Proveedor: prov,
                            Doc: doc,
                            FechaDoc: fecDoc,
                            Importe: importe,
                            TipoCont: TipoCont,
                            Flete: Flete,
                            Moneda: Moneda,
                            TipoCambio: TipoCambio,
                            Grupo: Grupo
                        }).done(function (data) {
                            onNotifyOld('fa fa-check', 'DOCUMENTO GUARDADO', 'info');
                            DocumentosDirectos.ajax.reload();
                            pnlTablero.find("input").val("");
                            $.each(pnlTablero.find("select"), function (k, v) {
                                pnlTablero.find("select")[k].selectize.clear(true);
                            });
                            pnlTablero.find("#FechaDoc").val(getToday());
                            pnlTablero.find("#Moneda")[0].selectize.addItem('MXN', true);
                            pnlTablero.find("#TipoCambio").val('1');
                            pnlTablero.find("#Tp").focus();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        });
                    }
                });
            } else {
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
            }

        });

    });

    function onComprobarMaquilas(v) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {
                pnlTablero.find("#dFecha").focus();
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA MAQUILA " + $(v).val() + " NO ES VALIDA",
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
                            $(v).val('');
                            $(v).focus();
                            break;
                    }
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            pnlTablero.find("#TipoPoliza").val((tp === 1) ? 'Calzado Lobo, S.A. de C.V.' : 'Lobo Solo');
            pnlTablero.find("#Poliza")[0].selectize.focus();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                $(v).val('').focus();
            });
        }
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

    td span.badge{
        font-size: 100% !important;
    }
</style>
