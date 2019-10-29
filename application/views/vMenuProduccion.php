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
</script>

<?php
$vs = array('vExplosionSemanal', 'vExplosionSemanalCliente', 'vExplosionSemanalArticulo',
    'vCotejaExplosionOrdCom', 'vExplosionSemanalOrdComProyeccion', 'vVisualizaPedido',
    'vReporteParesPreAsignados', 'vEstadisticasEntrega', 'vReporteCorteHiloTejer',
    'vReporteMatrizFraccionesEstiloLinea', 'vFraccionesCapturadasNominaSem',
    'vLotificacionSuelasPlantas', 'vEstiloFraccionNomina', 'vMaterialSemanaProduccionEstilo',
    'vConciliaFabricaProduccion', 'vConRelControlesXMaquila', 'vManoObraDirecta',
    'vParesAsignadosMaqSemGen', 'vAvanceProduccion', 'vAvanceProduccionSemDia',
    'vAvanceProduccionSemDia', 'vAvanceProduccionPorLinea', 'vAvanceProduccionPorDepto',
    'vDiasPromedioEntregaPorCliente', 'vParesEntregadosCalidadXMaq', 'vCostoInventariosProceso',
    'vEtiTrazabilidad', 'vEtiCajasXCliente', 'vEtiZapica', 'vEstatusPedidoXGrupoAgente',
    'vFichaTecnicaCompra', 'vMaterialAnoSemMaqDesgloseControlEstilo', 'vCostoManoObraGeneral',
    'vIOrdenDeProduccion', 'vCopyFTaFT', 'vOrdenDeProduccion', 'vReasignarControles', 'vParesAsignadosXTiempos',
    'vMaterialSemanaProduccionEstilo', 'vControlesADiasDeVencimientoXCliente');
foreach ($vs as $v) {
    $this->load->view($v);
}
