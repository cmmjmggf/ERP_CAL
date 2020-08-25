<div class="modal" id="mdlPerfilUsuario">
    <div class="modal-dialog notdraggable" role="document">
        <div class="modal-content" style="background-color: transparent; border: none !important;">
            <div class="modal-header" style="border: none !important; background: linear-gradient(90deg, rgba(0,0,0,1) 0%, rgba(56,55,55,0.8407738095238095) 100%);">
                <h5 class="modal-title" style="color: #fff"><span class="fa fa-user"></span> Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: rgba(0, 0, 0, 0.54); color: #ffffff;"> 
                <div class="row">
                    <div class="col-12 text-center">
                        <img src="<?php print base_url("img/usrs/{$this->session->TIPOMH}.jpg"); ?>" alt="..." class="img-thumbnail">
                    </div>
                    <div class="col-12 text-center">
                        <?php
                        print "<p class='font-weight-bold font-italic' style='font-size: 18px;'><span class='fa fa-user'></span>  {$this->session->USERNAME}</p>";
                        print "<p class='font-weight-bold font-italic' style='font-size: 18px;'><span class='fa fa-key'></span> {$this->session->Nombre} {$this->session->Apellidos}</p>";
                        print "<p class='font-weight-bold font-italic' style='font-size: 18px;'>{$this->session->TipoAcceso}</p>";

                        $fechin = Date('d/m/Y');
                        $datan = $this->db->select("S.Sem AS SEMANA_NOMINA", false)
                                        ->from('semanasnomina AS S')
                                        ->where("STR_TO_DATE(\"{$fechin}\", \"%d/%m/%Y\") BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\")", null, false)
                                        ->get()->result();
                        print "<p class='font-weight-bold font-italic' style='font-size: 18px;'>SEMANA: <span style=\"color: #e8ff00\">{$datan[0]->SEMANA_NOMINA}</span></p>";
                        print "<p class='font-weight-bold font-italic' style='font-size: 18px;'>IP: <span style=\"color: #FFC107\">{$_SERVER['REMOTE_ADDR']}</span> </p>";
                        print "<p class='font-weight-bold font-italic' style='font-size: 18px;'>SEGURIDAD: " . (intval($this->session->SEG) === 1 ? "SI" : "NO" ) . "</p>";
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="
                 border-top: 2px solid;
                 background: linear-gradient(90deg, rgba(0,0,0,1) 0%, rgba(56,55,55,0.8407738095238095) 100%); 
                 border-image: conic-gradient(#6b6b6b, #ffffff,#696969) 1;
                 border-image-source: linear-gradient(to left, #000000, #CDDC39,#000000);"> 
                <button type="button" class="btn btn-success font-weight-bold" data-dismiss="modal" style="background-color: #4CAF50; border-color: #4CAF50;"><span class="fa fa-check"></span> ACEPTA</button>
            </div>
        </div>
    </div>
</div>