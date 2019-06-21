<div class="modal fade" id="mdlGeneraNominaDeSemana" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Genera nomina de semana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label>Año</label>
                        <input type="text" id="AnioGDF" name="AnioGDF" max="2050"  maxlength="4" class="form-control numeric" autofocus="" autocomplete="off">
                    </div>
                    <div class="col-12">
                        <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                            <input type="checkbox" class="custom-control-input selectNotEnter" id="ConsultaNominaCerrada" name="ConsultaNominaCerrada" style="cursor: pointer !important;">
                            <label class="custom-control-label text-danger labelCheck" for="ConsultaNominaCerrada" style="cursor: pointer !important;">Consulta nomina cerrada</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <label>Semana</label>
                        <input type="text" id="SemanaGDF" name="SemanaGDF" maxlength="3" class="form-control numeric" autocomplete="off">
                    </div>
                    <div class="col-6">
                        <label>Fecha Inicial</label>
                        <input type="text" id="FechaInicialGDF" name="FechaInicialGDF" maxlength="12" class="form-control date">
                    </div>
                    <div class="col-6">
                        <label>Fecha Final</label>
                        <input type="text" id="FechaFinalGDF" name="FechaFinalGDF" maxlength="12" class="form-control date">
                    </div>  
                </div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-primary" id="btnGuardarGDF">GUARDAR</button>
            </div>
        </div>
    </div>
</div>