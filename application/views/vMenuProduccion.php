<!-- Contenido  -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <button class="btn btn-primary text-success btn-sm navbar-brand" id="sidebarCollapse">
        <i class="fa fa-industry"></i> Producción
    </button>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav w-100"></ul>
    </div>
</nav>
<script>
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
    var menu;
    $(document).ready(function () {
        menu = getParameterByName('parentMenu');
        if (menu !== '' && menu === 'MenuNomina' || menu === 'MenuFichasTecnicas') {
            $('#btnRegresar').removeClass('d-none');
        } else {
            $('#btnRegresar').addClass('d-none');
        }
        getMenu(5);
    });
    handleEnter();
</script>

<?php
$this->load->view('vExplosionSemanal');
$this->load->view('vExplosionSemanalCliente');
$this->load->view('vExplosionSemanalArticulo');
$this->load->view('vCotejaExplosionOrdCom');
$this->load->view('vExplosionSemanalOrdComProyeccion');
$this->load->view('vVisualizaPedido');
$this->load->view('vReporteParesPreAsignados');
$this->load->view('vEstadisticasEntrega');
$this->load->view('vReporteCorteHiloTejer');
$this->load->view('vReporteMatrizFraccionesEstiloLinea');
$this->load->view('vFraccionesCapturadasNominaSem');
$this->load->view('vLotificacionSuelasPlantas');
$this->load->view('vEstiloFraccionNomina');
$this->load->view('vMaterialSemanaProduccionEstilo');
$this->load->view('vConciliaFabricaProduccion');
$this->load->view('vConRelControlesXMaquila');
$this->load->view('vManoObraDirecta');
$this->load->view('vParesAsignadosMaqSemGen');
$this->load->view('vAvanceProduccion');
$this->load->view('vAvanceProduccionSemDia');
$this->load->view('vAvanceProduccionPorLinea');
$this->load->view('vAvanceProduccionPorDepto');
$this->load->view('vDiasPromedioEntregaPorCliente');
$this->load->view('vParesEntregadosCalidadXMaq');
$this->load->view('vCostoInventariosProceso');
$this->load->view('vEtiTrazabilidad');
$this->load->view('vEtiCajasXCliente');
$this->load->view('vEtiZapica');
$this->load->view('vEstatusPedidoXGrupoAgente');
$this->load->view('vFichaTecnicaCompra');
$this->load->view('vMaterialAnoSemMaqDesgloseControlEstilo');
$this->load->view('vCostoManoObraGeneral');
