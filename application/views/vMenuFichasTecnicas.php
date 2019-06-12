<!-- Contenido  -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <button class="btn btn-primary text-success btn-sm navbar-brand" id="sidebarCollapse">
        <i class="fa fa-file-invoice"></i> Fichas Técnicas
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
        getMenu(4);
    });

    function onLoadListaDePreciosDeCompraAMaq() {
        $.fancybox.open({
            src: '<?php print base_url('ListasPrecioMaquilas.shoes/?origen=FT'); ?>',
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

    function onLoad360VP() { 
          $.fancybox.open({
            src: '<?php print base_url('FichaTecnicaEstilos');?>',
            type: 'iframe',
            opts: {
                afterShow: function (instance, current) {
                    console.info('done!');
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
$this->load->view('vAdicionaMaterialXLinea')->view('vCopyFTaFT')
        ->view('vSupleMatXMat')->view('vSupleMatXLinea')
        ->view('vSupleMatXEstilo')->view('vSuplePiezaXPieza')
        ->view('vEliminaFichaTecnica')
        ->view('vFichaTecnicaCompra')->view('vReporteCorteHiloTejer')
        ->view('vReporteParesPreAsignados')->view('vEtiTrazabilidad')
        ->view('vEtiZapica')->view('vMaterialSemanaProduccionEstilo')->view('vEstilosFotos');
