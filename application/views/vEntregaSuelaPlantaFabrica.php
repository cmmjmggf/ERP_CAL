<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Salida de Suelas-Plantas-Entresuelas a Maquilas
                    <span class="badge badge-danger" >Mat. a Entregar: </span>
                    <span class="badge badge-info" id="MaquilaRecibe"></span>
                </legend>
            </div>
            <div class="col-sm-4" align="right">
                <button type="button" class="btn btn-info btn-sm " id="btnVerCabeceros" >
                    <span class="fab fa-contao" ></span> CABECEROS
                </button>
                <button type="button" class="btn btn-warning btn-sm" id="btnControlCompleto" >
                    <span class="fa fa-check-double" ></span> CTRL COMPLETO
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                <label for="" >Tipo*</label>
                <select id="Tipo" name="Tipo" class="form-control form-control-sm required" required="">
                    <option value=""></option>
                    <option value="1">1 SUELA</option>
                    <option value="2">2 PLANTA</option>
                    <option value="3">3 ENTRESUELA</option>
                </select>
            </div>
            <div class="col-6 col-sm-3 col-md-3 col-lg-2 col-xl-2">
                <label for="Control" >Control*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="10" id="Control" name="Control" required="">
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <label for="Cabecero" >Cabecero</label>
                <input type="text" class="form-control form-control-sm" readonly="" id="Cabecero" name="Cabecero">
            </div>
            <div class="col-4 col-sm-3 col-md-2 col-lg-1 col-xl-1">
                <label for="Maquila" >Maq</label>
                <input type="text" class="form-control form-control-sm" readonly="" id="Maquila" name="Maquila" >
            </div>
            <div class="col-4 col-sm-3 col-md-2 col-lg-1 col-xl-1">
                <label for="Sem" >Sem</label>
                <input type="text" class="form-control form-control-sm" readonly=""  id="Semana" name="Semana" >
            </div>
            <div class="col-4 col-sm-3 col-md-2 col-lg-1 col-xl-1">
                <label for="Año" >Año</label>
                <input type="text" class="form-control form-control-sm" readonly=""  id="Ano" name="Ano" >
            </div>
            <div class="col-4 col-sm-3 col-md-2 col-lg-1 col-xl-1">
                <label for="Serie" >Serie</label>
                <input type="text" class="form-control form-control-sm" readonly=""  id="Serie" name="Serie" >
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label>Fecha*</label>
                <input type="text" class="form-control form-control-sm  numbersOnly date notEnter" readonly="" id="FechaMov" name="FechaMov" maxlength="12" required>
            </div>
            <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label>Docto</label>
                <input type="text" class="form-control form-control-sm  numbersOnly" readonly="" id="DocMov" name="DocMov" maxlength="12" >
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <label for="Cabecero" ><legend class="badge badge-info">Avance Actual</legend></label>
                <input type="text" class="form-control form-control-sm" readonly="" id="EstatusProduccion" name="EstatusProduccion">
            </div>
        </div>
        <div class="row">
            <!--TALLAS-->
            <div class="col-12">
                <div class="table-responsive" style="overflow-x:auto; white-space: nowrap;">
                    <label class="font-weight-bold" for="Tallas"></label>
                    <table id="tblTallas" class="Tallas" >
                        <thead></thead>
                        <tbody>
                            <tr id="rTallasBuscaManual">
                                <td class="font-weight-bold">Tallas</td>
                                <?php
                                for ($index = 1; $index < 21; $index++) {
                                    print '<td><input type="text" style="width: 55px;" id="T' . $index . '" name="T' . $index . '" disabled class="form-control form-control-sm numbersOnly "></td>';
                                }
                                ?>

                            </tr>
                            <tr id="rArticulos">
                                <td class="font-weight-bold">Art.</td>
                                <?php
                                for ($index = 1; $index < 21; $index++) {
                                    print '<td><input type="text" style="width: 55px;" id="A' . $index . '" name="A' . $index . '" disabled class="form-control form-control-sm numbersOnly "></td>';
                                }
                                ?>
                                <td class="font-weight-bold">Total:</td>
                            </tr>
                            <tr id="rPares">
                                <td class="font-weight-bold">Pares</td>
                                <?php
                                for ($index = 1; $index < 21; $index++) {
                                    print '<td><input type="text" style="width: 55px;" id="P' . $index . '" name="P' . $index . '" disabled class="form-control form-control-sm numbersOnly "></td>';
                                }
                                ?>
                                <td class="font-weight-bold"><input type="text" style="width: 55px;" name="Pares" id="Pares" disabled="" class="form-control form-control-sm numbersOnly "></td>
                            </tr>
                            <tr class="rCapturaCantidades" id="rCantidades">
                                <td class="font-weight-bold">Cant.</td>
                                <?php
                                for ($index = 1; $index < 21; $index++) {
                                    print '<td><input type="text" style="width: 55px;" id="C' . $index . '" maxlength="3" class="form-control form-control-sm numbersOnly " name="C' . $index . '" onfocus="onCalcularPares(this);" on change="onCalcularPares(this);" keyup="onCalcularPares(this);" onfocusout="onCalcularPares(this);"></td>';
                                }
                                ?>
                                <td class="font-weight-bold"><input type="text" style="width: 55px;" id="TotalParesEntrega" class="form-control form-control-sm " disabled=""></td>
                                <td>
                                    <button type="button" id="btnAceptar" class="btn btn-primary btn-sm d-sm-block" data-toggle="tooltip" data-placement="right" title="Aceptar"><span class="fa fa-save"></span> ACEPTAR</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/EntregaSuelaPlantaFabrica/';
    var pnlTablero = $("#pnlTablero");
    var btnVerCabeceros = pnlTablero.find('#btnVerCabeceros');
    var btnControlCompleto = pnlTablero.find('#btnControlCompleto');
    var btnAceptar = pnlTablero.find('#btnAceptar');
    var estilo, color, tipoArt;
    $(document).ready(function () {
        init();
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToInputOnChange('#Tipo', '#Control', pnlTablero);
        btnControlCompleto.click(function () {
            var control = pnlTablero.find('#Control').val();
            $.getJSON(master_url + 'getPedidoByControl', {Control: control
            }).done(function (data) {
                if (data.length > 0) { //Si el control existe
                    $.each(data[0], function (k, v) {
                        //Llenamos las cantidades
                        pnlTablero.find('#rCantidades').find("[name='" + k + "']").val(v);
                        //Deshabilitamos campos inecesarios
                        if (v === null || v === 'undefined' || v === '' || v === undefined || parseInt(v) === 0) {
                            pnlTablero.find('#rCantidades').find("[name='" + k + "']").prop('disabled', true);
                        } else {
                            pnlTablero.find('#rCantidades').find("[name='" + k + "']").prop('disabled', false);
                        }
                    });
                    pnlTablero.find('#rCantidades').find('#TotalParesEntrega').val(data[0].Pares);
                    pnlTablero.find('#btnAceptar').focus();
                } else { //Si el control no existe
                    swal({
                        title: "ATENCIÓN",
                        text: "EL CONTROL " + control + " NO EXISTE ",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        if (action) {
                            pnlTablero.find('#Control').val('').focus();
                        }
                    });
                }
            });
        });
        btnVerCabeceros.click(function () {
            $.fancybox.open({
                src: base_url + '/SuelaPlantaCompras',
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
                            width: "85%",
                            height: "85%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });
        pnlTablero.find('#Tipo').change(function () {
            if ($(this).val()) {
                pnlTablero.find('#Control').focus().select();
            }
        });
        pnlTablero.find('#Control').keypress(function (e) {
            if (e.keyCode === 13) {
                var control = $(this).val().toString();
                if (control !== '') {

                    tipoArt = pnlTablero.find('#Tipo').val();
                    var descTipoArt = pnlTablero.find("#Tipo").text();
                    if (tipoArt !== '') {
                        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
                        //Verificamos si ya fue entregado en cada uno de los tipos
                        $.getJSON(master_url + 'onVerificarMaterialEntregado', {
                            Control: $(this).val(),
                            Tipo: tipoArt
                        }).done(function (data) {
                            if (data.length > 0) {
                                //YA FUE ENTREGADA
                                swal({
                                    title: "ATENCIÓN",
                                    text: "EL CONTROL " + control + " YA FUE ENTREGADO EN --> " + descTipoArt,
                                    icon: "warning",
                                    closeOnClickOutside: false,
                                    closeOnEsc: false
                                }).then((action) => {
                                    if (action) {
                                        //Aún así lo dejamos capturar, sólo se le avisa que ya está capturado
                                        onObtenerControlPedidoSerie(control);
                                        btnControlCompleto.addClass('d-none');
                                    }
                                });
                            } else {//EL CONTROL NO HA SIDO ENTREGADO
                                //---------------------------
                                //----------------------------
                                //-----------------------------
                                //---------------Consultar Contro en pedido-------------------
                                onObtenerControlPedidoSerie(control);
                                btnControlCompleto.removeClass('d-none');
                                //---------------------------
                                //----------------------------
                                //-----------------------------

                            }
                        }).fail(function (x, y, z) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x.responseText);
                        });
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "DEBE ELEGIR UN TIPO DE SALIDA",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            if (action) {
                                pnlTablero.find("#Tipo")[0].selectize.focus();
                            }
                        });
                    }

                }
            }
        });
        btnAceptar.click(function () {
            btnAceptar.attr('disabled', true);
            var maq = pnlTablero.find("#Pares").val();
            if (parseInt(maq) === 97) {
                swal("Atención", "LA MAQUILA 97 NO PUEDE ENTREGAR SUELA/PLANTA/ENTRESUELA ", {
                    buttons: ["Cancelar", true]
                }).then((value) => {
                    btnAceptar.attr('disabled', false);
                    pnlTablero.find('#Control').val('').focus();
                });
            } else {

                var pares_pedido = pnlTablero.find("#Pares").val();
                var pares_salida = pnlTablero.find("#TotalParesEntrega").val();
                if (pares_salida > pares_pedido) {
                    swal("Atención", "Cantidad de pares es mayor a la cantidad explosioanda ", {
                        buttons: ["Cancelar", true]
                    }).then((value) => {
                        if (value) {
                            onGuardarMovimiento();
                        }
                    });
                } else {
                    onGuardarMovimiento();
                }
            }
        });
    });
    function init() {
        pnlTablero.find('#Tipo')[0].selectize.focus();
        pnlTablero.find('#Tipo')[0].selectize.open();
        pnlTablero.find("#FechaMov").val(getToday());
    }
    function getFolio() {
        var currentdate = new Date();
        var datetime = currentdate.getFullYear().toString().substr(-2)
                + ('0' + (currentdate.getMonth() + 1)).slice(-2)
                + ('0' + currentdate.getDate()).slice(-2)
                + ('0' + currentdate.getHours()).slice(-2)
                + ('0' + currentdate.getMinutes()).slice(-2)
                + ('0' + currentdate.getSeconds()).slice(-2);
        pnlTablero.find('#DocMov').val(datetime);
    }
    function onCalcularPares(e) {
        var total_pares = 0;
        $.each(pnlTablero.find("#tblTallas input[name*='C']"), function (k, v) {
            total_pares += (parseInt($(v).val()) > 0) ? parseInt($(v).val()) : 0;
            pnlTablero.find("#TotalParesEntrega").val(total_pares);
        });
    }
    function onGuardarMovimiento() {
        var data = [];
        isValid('pnlTablero');
        if (valido) {
            HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
            //traemos la tabla
            var rows = pnlTablero.find("#tblTallas > tbody");
            //Iteramos en los renglones
            $.each(rows.find("tr input.numbersOnly:enabled"), function (index, element) {
                var cant = parseInt($(this).val());
                if (cant > 0) {
                    //Obtenemos los articulos de la tabla con el indice del padre
                    var art = rows.find("#rArticulos").find('td').eq($(this).parent().index()).find('input').val();
                    var fecha = pnlTablero.find('#FechaMov').val();
                    var doc = pnlTablero.find('#DocMov').val();
                    var maq = pnlTablero.find('#Maquila').val();
                    var sem = pnlTablero.find('#Semana').val();
                    var tipo = pnlTablero.find('#Tipo').val();
                    var ctrl = pnlTablero.find('#Control').val();
                    var ano = pnlTablero.find('#Ano').val();
                    data.push({
                        Maquila: pnlTablero.find('#Maquila').val(),
                        Articulo: art,
                        CantidadMov: cant,
                        FechaMov: fecha,
                        DocMov: doc,
                        Maq: maq,
                        Sem: sem,
                        TpoSuPlEn: tipo,
                        Control: ctrl,
                        Ano: ano
                    });
                }
            });
            //Agregar mov_art
            $.ajax({
                url: master_url + 'onAgregar',
                type: "POST",
                async: false,
                data: {
                    movs: JSON.stringify(data)
                }
            }).done(function (data, x, jq) {
                console.log(data);
                btnAceptar.attr('disabled', false);
                total_pares = 0;
                pares_pedido = 0;
                pnlTablero.find('input').val('');
                pnlTablero.find("#FechaMov").val(getToday());
                pnlTablero.find('#MaquilaRecibe').html('');
                pnlTablero.find('#rCantidades').find("input").prop('disabled', true);
                pnlTablero.find('#Control').focus();
                HoldOn.close();
            }).fail(function (x, y, z) {
                btnAceptar.attr('disabled', false);
                console.log(x, y, z);
            });
        }
    }
    function limpiarCampos() {
        total_pares = 0;
        pares_pedido = 0;
        pnlTablero.find('input').val('');
        pnlTablero.find("#FechaMov").val(getToday());
        pnlTablero.find('#MaquilaRecibe').html('');
        pnlTablero.find('#rCantidades').find("input").prop('disabled', true);
        pnlTablero.find('#Tipo')[0].selectize.clear(true);
        pnlTablero.find('#Tipo')[0].selectize.focus();
    }
    function onImprimirValeEntrada(doc) {

        $.post(master_url + 'onImprimirValeEntrada', {
            Doc: doc
        }).done(function (data) {
            HoldOn.close();
            console.log(data);
            $.fancybox.open({
                src: data,
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
                        console.info('done!');
                    },
                    afterClose: function () {
                        limpiarCampos();
                        onNotifyOld('fa fa-check', 'REPORTE GENERADO', 'success');
                    },
                    iframe: {
                        // Iframe template
                        tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                        preload: true,
                        // Custom CSS styling for iframe wrapping element
                        // You can use this to set custom iframe dimensions
                        css: {
                            width: "85%",
                            height: "85%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });
    }
    handleEnterDiv($('#rCantidades'));
    function onObtenerControlPedidoSerie(control) {
        $.getJSON(master_url + 'getPedidoByControl', {Control: control
        }).done(function (data) {
            if (data.length > 0) { //Si el control existe
                getFolio(); //Armamos el documento con la fecha/hora de hoy
                estilo = data[0].Estilo;
                color = data[0].Color;
                $.each(data[0], function (k, v) {
                    var ParesPedido = k.replace("C", "P");
                    //Llenamos los campos
                    pnlTablero.find("[name='" + k + "']").val(v);
                    pnlTablero.find('#rPares').find("[name='" + ParesPedido + "']").val(v);
                    //Deshabilitamos campos inecesarios
                    if (v === null || v === 'undefined' || v === '' || v === undefined || parseInt(v) === 0) {
                        pnlTablero.find('#rCantidades').find("[name='" + k + "']").prop('disabled', true);
                    } else {
                        pnlTablero.find('#rCantidades').find("[name='" + k + "']").prop('disabled', false);
                    }
                });
                pnlTablero.find('#MaquilaRecibe').text(data[0].EntregaMat);
                pnlTablero.find('#rCantidades').find('#TotalParesEntrega').val(data[0].Pares);
                pnlTablero.find('#btnAceptar').focus();
                //pnlTablero.find('#rCantidades input[type="text"]:first-child:enabled:eq(0)').focus().select();

                //Consultar Ficha Tecnica para traer cabecero
                $.getJSON(master_url + 'getCabeceroFichaTecnica', {
                    Estilo: estilo,
                    Color: color,
                    Tipo: tipoArt
                }).done(function (data) {
                    if (data.length > 0) { //Si el cabecero existe
                        $.each(data[0], function (k, v) {
                            pnlTablero.find("[name='" + k + "']").val(v);
                        });
                        HoldOn.close();
                    } else { //Si el cabecero no existe
                        HoldOn.close();
                        swal({
                            title: "ATENCIÓN",
                            text: "NO EXISTE EL CABECERO EN ESTE TIPO/CONTROL ",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            if (action) {
                                pnlTablero.find('#MaquilaRecibe').html('');
                                pnlTablero.find('#tblTallas').find("input").prop('disabled', true);
                                pnlTablero.find('input').val('');
                                pnlTablero.find("#FechaMov").val(getToday());
                                pnlTablero.find('#Control').val('').focus();
                            }
                        });
                    }
                });
            } else { //Si el control no existe
                HoldOn.close();
                swal({
                    title: "ATENCIÓN",
                    text: "EL CONTROL " + control + " NO EXISTE Ó ESTÁ CANCELADO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    if (action) {
                        pnlTablero.find('#MaquilaRecibe').html('');
                        pnlTablero.find('#tblTallas').find("input").prop('disabled', true);
                        pnlTablero.find('input').val('');
                        pnlTablero.find("#FechaMov").val(getToday());
                        pnlTablero.find('#Control').val('').focus();
                    }
                });
            }
        });
    }
</script>
<style>
    #tblTallas tbody tr:hover {
        background-color: #FFF;
        color: #000 !important;
    }
</style>