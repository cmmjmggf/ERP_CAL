<?php
switch ($TYPE) {
    case 1:
        print '<div class="fixed-bottom">';
        break;
    case 2:
        print '<div style="    right: 0;    bottom: 0;    left: 0;">';
        break;
}
?>
<div class="col-12 watermark" align="center">
    <p class="font-weight-bold font-italic text-muted">© <?php print Date('Y').", {$this->session->EMPRESA_RAZON}"; ?></p>
</div>
</div>
<style>
    .fixed-bottom {
        z-index: 1000;
    }
    .watermark p{
        color:#333 !important; 
    } 
</style>