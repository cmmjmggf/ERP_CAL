<!-- Contenido  -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <button class="btn btn-primary text-success btn-sm navbar-brand" id="sidebarCollapse">
        <i class="fa fa-cogs"></i> Parámetros
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
        getMenu(8);
    });
</script>

<?php
$this->load->view('vFichaTecnicaCompra')->view('vEstilosFotos')->view('vSeleccionaEstiloColorParaEfectoVenta');
