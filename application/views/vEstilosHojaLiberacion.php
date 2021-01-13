<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Estilos</legend>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Estilos" class="table-responsive">
                <table id="tblEstilos" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Estilo</th>
                            <th>Nombre</th>
                            <th>Linea</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th><input type="text" placeholder="Buscar por Estilo" class="form-control form-control-sm" style="width: 100%;"></th>
                            <th><input type="text" placeholder="Buscar por Nombre" class="form-control form-control-sm" style="width: 100%;"></th>
                            <th><input type="text" placeholder="Buscar por Linea" class="form-control form-control-sm" style="width: 100%;"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card m-3 d-none animated fadeIn" id="pnlDatos">
    <div class="card-body text-dark">
        <form id="frmNuevoEstilo">
            <fieldset>
                <div class="row">
                    <div class="col-12 col-sm-4 col-md-4 float-left">
                        <legend>Estilo</legend>
                    </div>
                    <div class="col-6 col-sm-4 col-md-4" align="right">
                        <button type="button" class="btn btn-primary btn-sm" id="btnCancelar" >
                            <span class="fa fa-arrow-left" ></span> REGRESAR
                        </button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <!--DATOS DEL ESTILO-->
                    <div class="col-12 col-md-8 col-lg-8">
                        <!--PRIMER RENGLON-->
                        <div class="row">
                            <div class="d-none">
                                <input type="text"  name="ID" class="form-control form-control-sm" >
                            </div>
                            <div class="col-12 mt-2">
                                <legend class="badge badge-info"> INFORMACIÓN GENERAL DEL ESTILO</legend>
                            </div>
                            <div class="col-6 col-sm-2 col-md-2 col-lg-4 col-xl-3">
                                <label for="Clave" >Clave*</label>
                                <input type="text" class="form-control form-control-sm" id="Clave" name="Clave" required >
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <label for="Descripcion" >Descripción*</label>
                                <input type="text" id="Descripcion" name="Descripcion" class="form-control form-control-sm" readonly="" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 my-2">
                                <legend class="badge badge-success"> HOJA DE LIBERACIÓN</legend>
                            </div>
                            <div class="col-12" align='center'>
                                <input type="file" id="Adjunto" name="Adjunto" class="d-none">

                                <br>
                                <div id="VistaPreviaAdjunto" align="center">

                                </div>
                            </div>
                        </div>

                    </div>

                    <!--FOTO-->
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="row">
                            <div class="col-12 my-2">
                                <legend class="badge badge-success"> FOTOGRAFÍA</legend>
                            </div>
                            <div class="col-12" align='center'>
                                <input type="file" id="Foto" name="Foto" class="d-none">
                                <br>
                                <div id="VistaPrevia" align="center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/Estilos/';
    var tblEstilos = $('#tblEstilos');
    var Estilos;
    var btnNuevo = $("#btnNuevo"), btnCancelar = $("#btnCancelar");
    var pnlTablero = $("#pnlTablero"), pnlDatos = $("#pnlDatos");
    var Archivo = $("#Foto");
    var btnArchivo = $("#btnArchivo");
    var btnCancelarEstilo = $("#btnCancelarEstilo");
    var VistaPrevia = $("#VistaPrevia");
    var foto;
    /*Adjunto*/
    var Adjunto = $("#Adjunto");
    var btnAdjunto = $("#btnAdjunto");
    var VistaPreviaAdjunto = $("#VistaPreviaAdjunto");
    var adjunto;
    var mdlCancelarEstilo = $('#mdlCancelarEstilo');
    var btnAceptarCancelacion = mdlCancelarEstilo.find('#btnAceptarCancelacion');

    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();



        btnCancelar.click(function () {
            pnlTablero.removeClass("d-none");
            pnlDatos.addClass("d-none");
            $('#tblEstilos_filter input[type=search]').focus().select();
        });

        pnlTablero.find("#tblEstilos_filter").find('input[type="search"]').on('keydown', function (e) {
            if ($(this).val() && e.keyCode === 13) {
                getInfoEstilo($(this).val());
            }
        });

        tblEstilos.find('tbody').on('click', 'tr', function () {
            var dtm = Estilos.row(this).data();
            var estilo = (dtm.Clave);
            getInfoEstilo(estilo);
        });

        Estilos.columns().every(function () {
            var that = this;
            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });
    });

    function init() {
        getRecords();
    }

    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblEstilos')) {
            tblEstilos.DataTable().destroy();
        }
        Estilos = tblEstilos.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"}, {"data": "Clave"}, {"data": "Descripcion"}, {"data": "Linea"}
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
                [1, 'desc']/*ID*/
            ],
            initComplete: function (x, y) {
                HoldOn.close();
            }
        });

        $('#tblEstilos_filter input[type=search]').focus();
    }
    function getInfoEstilo(temp) {
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        nuevo = false;
        tblEstilos.find("tbody tr").removeClass("success");
        $(this).addClass("success");


        $.getJSON(master_url + 'getEstiloByID', {ID: temp}).done(function (data) {
            if (data.length > 0) {
                var dtm = data[0];
                pnlDatos.find("input").val("");
                $.each(pnlDatos.find("select"), function (k, v) {
                    pnlDatos.find("select")[k].selectize.clear(true);
                });
                $.each(data[0], function (k, v) {
                    if (k !== 'Foto' && k !== 'Adjunto') {
                        pnlDatos.find("[name='" + k + "']").val(v);
                        if (pnlDatos.find("[name='" + k + "']").is('select')) {
                            pnlDatos.find("[name='" + k + "']")[0].selectize.addItem(v, true);
                        }
                    }
                });
                var esf = '<?php print base_url('uploads/Estilos/esf.jpg'); ?>';
                $.ajax({
                    url: base_url + dtm.Foto,
                    type: 'HEAD',
                    error: function ()
                    {
                        foto = false;
                        VistaPrevia.html(' <img src="' + esf + '" class="img-thumbnail img-fluid rounded mx-auto " >');
                    },
                    success: function ()
                    {
                        if (dtm.Foto !== null && dtm.Foto !== undefined && dtm.Foto !== '') {
                            var ext = getExt(dtm.Foto);

                            if (ext === "gif" || ext === "jpg" || ext === "png" || ext === "jpeg") {
                                foto = true;
                                pnlDatos.find("#VistaPrevia").html('<img id="trtImagen" src="' + base_url + dtm.Foto + '" class ="img-thumbnail img-fluid rounded mx-auto"  onclick="printImg(\' ' + base_url + dtm.Foto + ' \')"  />');
                            }
                            if (ext === "PDF" || ext === "Pdf" || ext === "pdf") {
                                pnlDatos.find("#VistaPrevia").html('<div class="col-md-8"></div><embed src="' + base_url + dtm.Foto + '" type="application/pdf" width="90%" height="800px" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">');
                            }
                            if (ext !== "gif" && ext !== "jpg" && ext !== "jpeg" && ext !== "png" && ext !== "PDF" && ext !== "Pdf" && ext !== "pdf") {
                                VistaPrevia.html(' <img src="' + esf + '" class="img-thumbnail img-fluid rounded mx-auto " >');
                            }
                        } else {
                            VistaPrevia.html(' <img src="' + esf + '" class="img-thumbnail img-fluid rounded mx-auto " >');
                        }
                    }
                });

                //Adjunto
                var sinarch = '<?php print base_url('img/sinarch.jpg'); ?>';
                $.ajax({
                    url: base_url + dtm.Adjunto,
                    type: 'HEAD',
                    error: function ()
                    {
                        adjunto = false;
                        VistaPreviaAdjunto.html(' <img src="' + sinarch + '" class="img-thumbnail img-fluid rounded mx-auto " >');
                    },
                    success: function ()
                    {
                        if (dtm.Adjunto !== null && dtm.Adjunto !== undefined && dtm.Adjunto !== '') {
                            var ext = getExt(dtm.Adjunto);

                            if (ext === "gif" || ext === "jpg" || ext === "png" || ext === "jpeg") {
                                adjunto = true;
                                pnlDatos.find("#VistaPreviaAdjunto").html('<button type="button" class="btn btn-danger btn-sm" id="btnQuitarVP1" name="btnQuitarVP1" onclick="onRemovePreviewAdjunto(this)"><span class="fa fa-times fa-2x danger-icon"></span></button><br><img id="trtImagen" src="' + base_url + dtm.Adjunto + '" class ="img-thumbnail img-fluid rounded mx-auto"  onclick="printImg(\' ' + base_url + dtm.Adjunto + ' \')"  />');
                            }
                            if (ext === "PDF" || ext === "Pdf" || ext === "pdf") {
                                pnlDatos.find("#VistaPreviaAdjunto").html('<div class="col-md-8"></div> <button type="button" class="btn btn-danger btn-sm" id="btnQuitarVP1" name="btnQuitarVP1" onclick="onRemovePreviewAdjunto(this)"><span class="fa fa-times fa-2x danger-icon"></span></button><br><embed src="' + base_url + dtm.Adjunto + '" type="application/pdf" width="90%" height="800px" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">');
                            }
                            if (ext !== "gif" && ext !== "jpg" && ext !== "jpeg" && ext !== "png" && ext !== "PDF" && ext !== "Pdf" && ext !== "pdf") {
                                VistaPreviaAdjunto.html(' <img src="' + sinarch + '" class="img-thumbnail img-fluid rounded mx-auto " >');
                            }
                        } else {
                            VistaPreviaAdjunto.html(' <img src="' + sinarch + '" class="img-thumbnail img-fluid rounded mx-auto " >');
                        }
                    }
                });
                pnlTablero.addClass("d-none");
                pnlDatos.removeClass('d-none');
                btnCancelarEstilo.removeClass("d-none");
                pnlDatos.find("#Clave").addClass('disabledForms');
                pnlDatos.find("#Descripcion").focus().select();
                pnlDatos.find('#dFechaBaja').removeClass('d-none');

                pnlDatos.find("li a").removeClass("active");
                pnlDatos.find("li a").attr("aria-selected", false);
                pnlDatos.find("li:eq(0) a").attr("aria-selected", true);
                pnlDatos.find("li:eq(0) a").addClass("active");
                pnlDatos.find("#estilo").addClass("show active");
                pnlDatos.find("#adjunto").removeClass("show active");
            }


        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');

        }).always(function () {
            HoldOn.close();
        });
    }
    function printImg(url) {
        var win = window.open('');
        win.document.write('<img src="' + url + '" onload="window.print();window.close()" />');
        win.focus();
    }

</script>