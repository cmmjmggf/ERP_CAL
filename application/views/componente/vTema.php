    <?php
    if (!is_null($this->session->TEMA) && $this->session->TEMA === "ACTUAL") {
        ?>
        <button type="button" class="btn btn-info btn-block font-weight-bold"  onclick="onCambiarTema(1)">
            <i class="fa fa-paint-brush"></i> VERSIÓN CLÁSICA
        </button>   <?php
    }
    if (!is_null($this->session->TEMA) && $this->session->TEMA === "CLÁSICO" || is_null($this->session->TEMA) && $this->session->TEMA === "CLÁSICO") {
        ?>
        <button type="button" class="btn btn-info btn-block ml-1 font-weight-bold"   onclick="onCambiarTema(2)" style="background-color: var(--purple); border-color: var(--purple);">
            <i class="fa fa-paint-brush"></i> VERSIÓN NUEVA
        </button>    
        <?php
    }
    ?>