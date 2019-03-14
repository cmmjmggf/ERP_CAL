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
    <p class="font-weight-bold font-italic text-muted">© 2019, Calzado Lobo Solo.</p>
    <p class="font-italic text-muted">Calzado Lobo Solo and the Lobo Solo logo are both Copyright © 2019</p>
    <p class="font-italic text-muted">All other content is Copyright © by their respective owners.</p>
</div>
</div>
<style>
    .fixed-bottom { 
        z-index: 1000; 
    }
    .watermark p{
        color:#fff !important;
    }
    html canvas{
        box-shadow: inset 0px 0px 900px 0px rgba(0,0,0,1);
    }
</style>