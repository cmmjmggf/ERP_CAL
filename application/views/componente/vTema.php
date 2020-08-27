<?php
if (!is_null($this->session->TEMA) && $this->session->TEMA === "ACTUAL") {
    ?>
    <button type="button" class="btn btn-info btn-block font-weight-bold"  onclick="onCambiarTema(1)">
        <i class="fa fa-paint-brush"></i> VERSIÓN CLÁSICA
    </button>  
    <div class="w-100 my-1"></div>
    <button type="button" class="btn btn-success btn-block font-weight-bold" style="background-color: #3F51B5; border-color: #3F51B5;"  onclick="onCambiarTema(3)">
        <i class="fa fa-paint-brush"></i> VERSIÓN OSCURA
    </button>  
    <?php
}
if (!is_null($this->session->TEMA) && $this->session->TEMA === "CLÁSICO" || is_null($this->session->TEMA) && $this->session->TEMA === "CLÁSICO") {
    ?>
    <button type="button" class="btn btn-info btn-block ml-1 font-weight-bold"   onclick="onCambiarTema(2)" style="background-color: var(--purple); border-color: var(--purple);">
        <i class="fa fa-paint-brush"></i> VERSIÓN NUEVA
    </button>    
    <div class="w-100 my-1"></div>
    <button type="button" class="btn btn-success btn-block font-weight-bold" style="background-color: #3F51B5; border-color: #3F51B5;"  onclick="onCambiarTema(3)">
        <i class="fa fa-paint-brush"></i> VERSIÓN OSCURA
    </button>  
    <?php
}
if (!is_null($this->session->TEMA) && $this->session->TEMA === "OSCURO") {
    ?>
    <button type="button" class="btn btn-info btn-block font-weight-bold"  onclick="onCambiarTema(1)">
        <i class="fa fa-paint-brush"></i> VERSIÓN CLÁSICA
    </button>  
    <div class="w-100 my-1"></div>
    <button type="button" class="btn btn-success btn-block font-weight-bold" style="background-color: #3F51B5; border-color: #3F51B5;"  onclick="onCambiarTema(2)">
        <i class="fa fa-paint-brush"></i> VERSIÓN NUEVA
    </button>  
    <?php
}
?>