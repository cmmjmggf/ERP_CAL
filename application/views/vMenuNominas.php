<!-- Contenido  -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <button class="btn btn-primary text-success btn-sm navbar-brand" id="sidebarCollapse">
        <i class="fas fa-hand-holding-usd"></i> Nóminas
    </button>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav w-100"></ul>
    </div>
</nav>
<script>
    $(document).ready(function () {
        getMenu(7);
    });
    handleEnter();
    function onCargarRelojChecador() {
        $.fancybox.open({
            src: '<?php print base_url('RelojChecador.shoes'); ?>',
            type: 'iframe',
            opts: {
                afterShow: function (instance, current) {
                    console.info('done!');
                },
                afterClose: function () {
                },
                iframe: {
                    // Iframe template
                    tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                    preload: true,
                    // Custom CSS styling for iframe wrapping element
                    // You can use this to set custom iframe dimensions
                    css: {
                        width: "100%",
                        height: "100%"
                    },
                    // Iframe tag attributes
                    attr: {
                        scrolling: "auto"
                    }
                }
            }
        });
    }
</script>



<?php
$this->load->view('vCopiarFraccionEstiloaEstilo');
$this->load->view('vCapturaCajaAhorroDirecta');
$this->load->view('vLimpiaCajaAhorroPrestamosEmpleados');
$this->load->view('vCapturaComidaEmpleados');
$this->load->view('vImprimirCredenciales');
$this->load->view('vEtiquetasLockers');
$this->load->view('vValesZapatoTiendas');
