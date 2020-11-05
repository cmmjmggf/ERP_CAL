<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Articulos en Estilos</legend>
            </div>
        </div>
        <hr>
        <div class="card-block mt-4">
            <div class="row">
                <div class="col-sm-6">
                    <label>Artículo</label>
                    <select id="Articulo" name="Articulo" class="form-control form-control-sm required" >
                        <option></option>
                        <?php
                        $clientes = $this->db->query("SELECT C.Clave AS CLAVE, C.Descripcion AS ARTICULO FROM articulos AS C ORDER BY CLAVE ASC;")->result();
                        foreach ($clientes as $k => $v) {
                            print "<option value=\"{$v->CLAVE}\">{$v->CLAVE} - {$v->ARTICULO}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <br><hr><br>
            <div id="Estilos" class="table-responsive">
                <table id="tblEstilos" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Estilo</th>
                            <th class="d-none">Foto</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/ConsultaArticulosEnFichasTecnicas/';
    var tblEstilos = $('#tblEstilos');
    var Estilos;
    var pnlTablero = $("#pnlTablero");

    $(document).ready(function () {
        pnlTablero.find('#Articulo')[0].selectize.focus();
        getEstilosPorArticulo();

        pnlTablero.find("#Articulo").change(function () {
            var art = $(this).val();
            if (art) {
                Estilos.ajax.reload();
            }
        });

        tblEstilos.on('click', 'tr', function () {
            onBeep(1);
            var dtm = Estilos.row(this).data();
            onMostrarFoto(dtm.foto);
        });

    });

    var _animate_ = {enter: 'animated fadeInLeft', exit: 'animated fadeOutDown'}, _placement_ = {from: "bottom", align: "left"};
    function onMostrarFoto(path) {
        //MOSTRAR FOTO
        console.log(base_url + path);
        if (path !== null && path !== undefined && path !== '') {
            var ext = getExt(path);
            if (ext === "gif" || ext === "jpg" || ext === "png" || ext === "jpeg") {
                $.notify({
                    // options
                    icon: base_url + path
                }, {
                    // settings
                    placement: _placement_,
                    animate: _animate_,
                    icon_type: 'img',
                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                            '<img  data-notify="icon" class="col-12 img-circle pull-left">' +
                            '</div>'
                });
            }
            if (ext !== "gif" && ext !== "jpg" && ext !== "jpeg" && ext !== "png" && ext !== "PDF" && ext !== "Pdf" && ext !== "pdf") {
                $.notify({
                    // options
                    icon: base_url + path
                }, {
                    // settings
                    placement: _placement_,
                    animate: _animate_,
                    icon_type: 'img',
                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                            '<img  data-notify="icon" class="col-12 img-circle pull-left">' +
                            '</div>'
                });
            }
        } else {
            $.notify({
                // options
                icon: base_url + path
            }, {
                // settings
                placement: _placement_,
                animate: _animate_,
                icon_type: 'img',
                template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                        '<img  data-notify="icon" class="col-12 img-circle pull-left">' +
                        '</div>'
            });
        }
    }

    function getEstilosPorArticulo() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblEstilos')) {
            tblEstilos.DataTable().destroy();
        }
        Estilos = tblEstilos.DataTable({
            "dom": 'rtp',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getEstilosPorArticulo',
                "dataSrc": "",
                "type": "POST",
                "data": function (d) {
                    d.Articulo = pnlTablero.find("#Articulo").val() ? pnlTablero.find("#Articulo").val() : '';
                }
            },
            "columns": [
                {"data": "estilo"},
                {"data": "foto"}
            ],
            "columnDefs": [
                {
                    "targets": [1],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "scrollX": true,
            "scrollY": 400,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
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
                            /*FECHA ENTREGA*/
                            c.addClass('text-strong');
                            break;
                    }
                });
            }
        });
    }

</script>