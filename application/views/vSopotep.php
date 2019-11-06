<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Analiza ficha técnica MATERIALES//PROCESO//DISEÑO</legend>
            </div>
            <div class="col-sm-1 float-right" align="right">
                <label for="Estilo" >Estilo</label>
            </div>
            <div class="col-sm-2 float-left" align="left">
                <select class="form-control form-control-sm " id="Estilo" name="Estilo" required="" placeholder="">
                    <option></option>
                    <?php
                    foreach ($this->db->query("SELECT A.Clave, CONCAT(A.Clave, \" - \", A.Descripcion) AS Estilo FROM estilos AS A where A.Estatus = 'ACTIVO' ")->result() as $k => $v) {
                        print "<option value=\"{$v->Clave}\">{$v->Estilo}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <hr>
        <div class="row mt-3">
            <div class="col-12 text-danger" align="center" id="VistaPrevia">

            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $('#pnlTablero');
    var VistaPrevia = pnlTablero.find("#VistaPrevia");

    $(document).ready(function () {
        init();
        pnlTablero.find("#Estilo").change(function () {
            if ($(this).val()) {
                var path = 'uploads/FotosProce/' + $(this).val() + '.pdf';
                $.ajax({
                    url: base_url + path,
                    type: 'HEAD',
                    error: function ()
                    {
                        VistaPrevia.html('<h4>NO EXISTE ARCHIVO SOPOTEP</h4>');
                    },
                    success: function ()
                    {
                        var ext = getExt(path);
                        if (ext === "gif" || ext === "jpg" || ext === "png" || ext === "jpeg") {
                            VistaPrevia.html('<h4>EL ARCHIVO SOPOTEP TIENE QUE ESTAR EN FORMATO PDF</h4>');
                        }
                        if (ext === "PDF" || ext === "Pdf" || ext === "pdf") {
                            onImprimirReporteFancy(base_url + path);
                        }
                        if (ext !== "gif" && ext !== "jpg" && ext !== "jpeg" && ext !== "png" && ext !== "PDF" && ext !== "Pdf" && ext !== "pdf") {
                            VistaPrevia.html('<h4>EL ARCHIVO SOPOTEP TIENE QUE ESTAR EN FORMATO PDF</h4>');
                        }
                    }
                });
            } else {
                VistaPrevia.html('<h4>SELECCIONE UN ESTILO</h4>');
            }
        });
    });

    function init() {
        pnlTablero.find('#Estilo')[0].selectize.focus();
        pnlTablero.find('#Estilo')[0].selectize.open();
    }

</script>


