<div class="modal modal-fullscreen" id="mdlParametrosFijos"  role="dialog">
    <!--    modal-fullscreen-->
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Parámetros Fijos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCapturaPF">
                    <label for="" class="mb-2 mr-sm-2">Lista de precios</label>
                    <div class="form-inline">

                        <input type="text" class="form-control form-control-sm numbersOnly mb-2 mr-sm-2" style="width: 100px;" maxlength="6"  id="ListaPF" name="ListaPF"   >
                        <select id="sListaPF" name="sListaPF" class="form-control form-control-sm required " style="width: 320px;">
                            <option value=""></option>
                            <?php
                            foreach ($this->db->select("C.Lista AS CLAVE, C.Descripcion AS LISTA, C.Descripcion as nomlista ", false)
                                    ->from('listadeprecios AS C')->order_by('LISTA', 'ASC')->get()->result() as $k => $v) {
                                print "<option value='{$v->CLAVE}' >{$v->LISTA}</option>";
                            }
                            ?>
                        </select>
                    </div>


                    <div class="row">
                        <div class="col-12"><hr></div>
                        <div class="w-100"></div>

                        <div class="col-12" align="center">
                            <label class="badge badge-info" style="font-size: 14px; width: 100%;">Nota: Los campos de % deben ser .15 que equivale a 15%</label>
                        </div>
                        <!-- ----------------------------- CAMPOS ----------------------------- -->

                        <div class="col-2">
                            <label>Tolerancia %</label>
                            <input type="text" class="form-control form-control-sm  azul numbersOnly" maxlength= "6"  id="tolerPF" name="tolerPF"   >
                        </div>
                        <div class="col-2">
                            <label>G-Fábrica</label>
                            <input type="text" class="form-control form-control-sm  azul numbersOnly" maxlength= "6"  id="gfabriPF" name="gfabriPF"   >
                        </div>
                        <div class="col-2">
                            <label>G-Venta</label>
                            <input type="text" class="form-control form-control-sm  azul numbersOnly" maxlength= "6"  id="gvtaPF" name="gvtaPF"   >
                        </div>
                        <div class="col-2">
                            <label>G-Admon</label>
                            <input type="text" class="form-control form-control-sm  azul numbersOnly" maxlength= "6"  id="gadmonPF" name="gadmonPF"   >
                        </div>
                        <div class="col-2">
                            <label>Hms</label>
                            <input type="text" class="form-control form-control-sm  azul numbersOnly" maxlength= "6"  id="hmsPF" name="hmsPF"   >
                        </div>
                        <!-- -----------------------------primer renglon----------------------------- -->
                        <div class="w-100"></div>
                        <div class="col-2">
                            <label>% Utilidad</label>
                            <input type="text" class="form-control form-control-sm  azul numbersOnly" maxlength= "6"  id="utiliPF" name="utiliPF"   >
                        </div>
                        <div class="col-2">
                            <label>% Decuento</label>
                            <input type="text" class="form-control form-control-sm  azul numbersOnly" maxlength= "6"  id="descPF" name="descPF"   >
                        </div>
                        <div class="col-2">
                            <label>% Comisión</label>
                            <input type="text" class="form-control form-control-sm  azul numbersOnly" maxlength= "6"  id="comicPF" name="comicPF"   >
                        </div>
                        <div class="col-2">
                            <label>% Extra</label>
                            <input type="text" class="form-control form-control-sm  azul numbersOnly" maxlength= "6"  id="pextrPF" name="pextrPF"   >
                        </div>
                        <div class="col-2">
                            <label>Flete</label>
                            <input type="text" class="form-control form-control-sm  azul numbersOnly" maxlength= "6"  id="fletePF" name="fletePF"   >
                        </div>

                        <!-- ----------------------------- FIN CAMPOS ----------------------------- -->
                        <div class="col-sm-12 mt-2">
                            <div class="table-responsive" id="ParametrosFijos">
                                <table id="tblParametrosFijos" class="table table-sm  " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Lista</th>
                                            <th>Descripción</th>
                                            <th>G-Fabr</th>
                                            <th>G-Vta</th>
                                            <th>G-Admon</th>
                                            <th>Hms</th>
                                            <th>Tolerancia</th>
                                            <th>Utilidad</th>
                                            <th>Desc</th>
                                            <th>Comisión</th>
                                            <th>% Extr</th>
                                            <th>Flete</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 mt-1" align="center">
                            <label class="badge badge-danger" style="font-size: 14px; width: 100%;">Nota. Para eliminar haz doble click en el registro</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnAceptar" class="btn btn-primary"> ACEPTAR</button>
                <button type="button" id="btnListasPreciosPF" class="btn btn-success"> CAT. LISTAS DE PRECIOS</button>
                <button type="button" id="btnClientesPF" class="btn btn-info"> CLIENTES</button>
                <button type="button" class="btn btn-secondary selectNotEnter" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlParametrosFijos = $('#mdlParametrosFijos');
    var tblParametrosFijos = $('#tblParametrosFijos');
    var ParametrosFijos;
    var listaPF;

    $(document).ready(function () {

        mdlParametrosFijos.find("#btnClientesPF").click(function () {
            $.fancybox.open({
                src: base_url + '/Clientes',
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
        mdlParametrosFijos.find("#btnListasPreciosPF").click(function () {
            $.fancybox.open({
                src: base_url + '/ListaDePrecios',
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
        tblParametrosFijos.find('tbody').on('dblclick', 'tr', function () {
            var dtm = ParametrosFijos.row(this).data();
            swal({
                buttons: ["Cancelar", "Aceptar"],
                title: 'Estás Seguro?',
                text: "Esta acción no se puede revertir: \n" + "Eliminar Lista de precios: " + dtm.lista + " " + dtm.nomlista,
                icon: "warning",
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then((action) => {
                if (action) {
                    $.post(master_url + 'onEliminarParametroFijo', {Lista: dtm.lista}).done(function (data) {
                        if (parseInt(data) > 0) {
                            swal('ERROR', 'NO ES POSIBLE ELIMINAR EL REGISTRO PORQUE EXISTEN CLIENTES CON ESTA LISTA DE PRECIOS', 'error');
                        } else {
                            ParametrosFijos.ajax.reload();
                            onNotifyOld('fa fa-check', 'LISTA ELIMINADA CORRECTAMENTE', 'success');
                            mdlParametrosFijos.find("input").val("");
                            $.each(mdlParametrosFijos.find("select"), function (k, v) {
                                mdlParametrosFijos.find("select")[k].selectize.clear(true);
                            });
                            mdlParametrosFijos.find('#ListaPF').focus();
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            });

        });
        mdlParametrosFijos.on('shown.bs.modal', function () {
            mdlParametrosFijos.find("input").val("");
            $.each(mdlParametrosFijos.find("select"), function (k, v) {
                mdlParametrosFijos.find("select")[k].selectize.clear(true);
            });
            getParametrosFijos();
        });


        mdlParametrosFijos.find('#ListaPF').keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    listaPF = $(this).val();
                    mdlParametrosFijos.find("#sListaPF")[0].selectize.addItem(listaPF, true);
                    $.getJSON(master_url + 'getInfoParametrosFijos', {Lista: listaPF}).done(function (data) {
                        if (data.length > 0) {
                            //SI EXSTE CARGAMOS LOS DATOS EN LOS INPUTS
                            mdlParametrosFijos.find("#tolerPF").val(data[0].toler);
                            mdlParametrosFijos.find("#gfabriPF").val(data[0].gfabri);
                            mdlParametrosFijos.find("#gvtaPF").val(data[0].gvta);
                            mdlParametrosFijos.find("#gadmonPF").val(data[0].gadmon);
                            mdlParametrosFijos.find("#hmsPF").val(data[0].hms);
                            mdlParametrosFijos.find("#utiliPF").val(data[0].utili);
                            mdlParametrosFijos.find("#descPF").val(data[0].desc);
                            mdlParametrosFijos.find("#comicPF").val(data[0].comic);
                            mdlParametrosFijos.find("#pextrPF").val(data[0].pextr);
                            mdlParametrosFijos.find("#fletePF").val(data[0].flete);
                            mdlParametrosFijos.find("#tolerPF").focus().select();
                        } else {
                            swal({
                                title: "ATENCIÓN",
                                text: "NO EXISTE PARÁMETROS PARA ESTA LISTA DE PRECIOS, PRESIONE OK PARA CAPTURARLOS ",
                                icon: "warning"
                            }).then((action) => {
                                mdlParametrosFijos.find("#tolerPF").focus().select();
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });


                }
            }
        });

        mdlParametrosFijos.find("#sListaPF").change(function () {
            if ($(this).val()) {
                listaPF = $(this).val();
                mdlParametrosFijos.find('#ListaPF').val(listaPF);
                $.getJSON(master_url + 'getInfoParametrosFijos', {Lista: listaPF}).done(function (data) {
                    if (data.length > 0) {
                        //SI EXSTE CARGAMOS LOS DATOS EN LOS INPUTS
                        mdlParametrosFijos.find("#tolerPF").val(data[0].toler);
                        mdlParametrosFijos.find("#gfabriPF").val(data[0].gfabri);
                        mdlParametrosFijos.find("#gvtaPF").val(data[0].gvta);
                        mdlParametrosFijos.find("#gadmonPF").val(data[0].gadmon);
                        mdlParametrosFijos.find("#hmsPF").val(data[0].hms);
                        mdlParametrosFijos.find("#utiliPF").val(data[0].utili);
                        mdlParametrosFijos.find("#descPF").val(data[0].desc);
                        mdlParametrosFijos.find("#comicPF").val(data[0].comic);
                        mdlParametrosFijos.find("#pextrPF").val(data[0].pextr);
                        mdlParametrosFijos.find("#fletePF").val(data[0].flete);
                        mdlParametrosFijos.find("#tolerPF").focus().select();
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "NO EXISTE PARÁMETROS PARA ESTA LISTA DE PRECIOS, PRESIONE OK PARA CAPTURARLOS ",
                            icon: "warning"
                        }).then((action) => {
                            mdlParametrosFijos.find("#tolerPF").focus().select();
                        });
                    }
                }).fail(function (x) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });


            }
        });
        mdlParametrosFijos.find("#tolerPF").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlParametrosFijos.find("#gfabriPF").focus().select();
                } else {
                    $(this).val(0);
                    mdlParametrosFijos.find("#gfabriPF").focus().select();
                }
            }
        });
        mdlParametrosFijos.find("#gfabriPF").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlParametrosFijos.find("#gvtaPF").focus().select();
                } else {
                    $(this).val(0);
                    mdlParametrosFijos.find("#gvtaPF").focus().select();
                }
            }
        });
        mdlParametrosFijos.find("#gvtaPF").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlParametrosFijos.find("#gadmonPF").focus().select();
                } else {
                    $(this).val(0);
                    mdlParametrosFijos.find("#gadmonPF").focus().select();
                }
            }
        });
        mdlParametrosFijos.find("#gadmonPF").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlParametrosFijos.find("#hmsPF").focus().select();
                } else {
                    $(this).val(0);
                    mdlParametrosFijos.find("#hmsPF").focus().select();
                }
            }
        });
        mdlParametrosFijos.find("#hmsPF").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlParametrosFijos.find("#utiliPF").focus().select();
                } else {
                    $(this).val(0);
                    mdlParametrosFijos.find("#utiliPF").focus().select();
                }
            }
        });
        mdlParametrosFijos.find("#utiliPF").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlParametrosFijos.find("#descPF").focus().select();
                } else {
                    $(this).val(0);
                    mdlParametrosFijos.find("#descPF").focus().select();

                }
            }
        });
        mdlParametrosFijos.find("#descPF").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlParametrosFijos.find("#comicPF").focus().select();
                } else {
                    $(this).val(0);
                    mdlParametrosFijos.find("#comicPF").focus().select();
                }
            }
        });
        mdlParametrosFijos.find("#comicPF").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlParametrosFijos.find("#pextrPF").focus().select();
                } else {
                    $(this).val(0);
                    mdlParametrosFijos.find("#pextrPF").focus().select();
                }
            }
        });
        mdlParametrosFijos.find("#pextrPF").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlParametrosFijos.find("#fletePF").focus().select();
                } else {
                    $(this).val(0);
                    mdlParametrosFijos.find("#fletePF").focus().select();
                }
            }
        });
        mdlParametrosFijos.find("#fletePF").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlParametrosFijos.find("#btnAceptar").focus();
                } else {
                    $(this).val(0);
                    mdlParametrosFijos.find("#btnAceptar").focus();
                }
            }
        });
        mdlParametrosFijos.find("#btnAceptar").click(function () {
            isValid('mdlParametrosFijos');
            if (valido) {
                var frm = new FormData(mdlParametrosFijos.find("#frmCapturaPF")[0]);
                frm.append('Lista', listaPF);
                frm.append('NomLista', mdlParametrosFijos.find("#sListaPF option:selected").text());
                $.ajax({
                    url: master_url + 'onGuardarParametroFijos',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    onNotifyOld('fa fa-check', 'REGISTRO GUARDADO CORRECTAMENTE', 'success');
                    ParametrosFijos.ajax.reload();
                    mdlParametrosFijos.find("input").val("");
                    $.each(mdlParametrosFijos.find("select"), function (k, v) {
                        mdlParametrosFijos.find("select")[k].selectize.clear(true);
                    });
                    mdlParametrosFijos.find('#ListaPF').focus();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                onNotify('<span class="fa fa-times fa-lg"></span>', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'danger');
            }
        });
    });
    function getParametrosFijos() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblParametrosFijos')) {
            tblParametrosFijos.DataTable().destroy();
        }
        ParametrosFijos = tblParametrosFijos.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": base_url + 'index.php/GeneraCostosVenta/getParametrosFijos',
                "dataType": "json",
                "type": 'GET',
                "dataSrc": ""
            },
            "columns": [
                {"data": "lista"},
                {"data": "nomlista"},
                {"data": "gfabri"},
                {"data": "gvta"},
                {"data": "gadmon"},
                {"data": "hms"},
                {"data": "toler"},
                {"data": "utili"},
                {"data": "desc"},
                {"data": "comic"},
                {"data": "pextr"},
                {"data": "flete"}
            ],
            "columnDefs": [
                {
                    "targets": [2, 3, 4, 5, 7, 11],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [6, 8, 9, 10],
                    "render": function (data, type, row) {
                        return   $.number(parseFloat(data), 2, '.', ',') + '%';
                    }
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": false,
            "displayLength": 500,
            scrollY: 350,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*UNIDAD*/
                            c.addClass('text-strong');
                            break;
                        case 1:
                            /*CONSUMO*/
                            c.addClass('text-strong');
                            break;
                    }
                });
            },
            "initComplete": function (x, y) {
                HoldOn.close();
                mdlParametrosFijos.find('#ListaPF').focus();
            }
        });
        tblParametrosFijos.find('tbody').on('click', 'tr', function () {
            tblParametrosFijos.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
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

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>