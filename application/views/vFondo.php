<style>
    #watermark {
        height: 100%;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        width: 100%;
        max-width: 900px;
        margin: auto;
        height: 100%;
        opacity: 0.2;
    }
    .fixedWatermark{
        padding-top: 90px;
        align-items: center;
        position:absolute;

    }
</style>
<div id="watermark">
    <div class="card-body text-center mt-5 fixedWatermark" >
        <?php
        if (!is_null($this->session->TEMA) && $this->session->TEMA === "CLÁSICO"
                || is_null($this->session->TEMA) && $this->session->TEMA === "CLÁSICO") {
            ?>
            <img src="<?php print base_url(); ?>img/lsbck.png"  class="img-fluid">
            <?php
        }
        ?>
    </div>
</div>
