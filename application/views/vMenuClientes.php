<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <button class="btn btn-primary text-success btn-sm navbar-brand" id="sidebarCollapse">
        <i class="fa fa-users"></i> Clientes
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
        if (menu !== '' && menu === 'MenuNomina' || menu === 'MenuContabilidad') {
            $('#btnRegresar').removeClass('d-none');
        } else {
            $('#btnRegresar').addClass('d-none');
        }
        getMenu(3);
    });
</script>
<?php
$vs = array(
    'vTipoCambio',
    'vBloqueoClientesXCliente',
    'vBloqueoClientesAutomatico',
    'vCajasFlete',
    'vGeneraPinAutoClientes',
    'vCapturaPrecioDeVtaXListaLinea',
    'vFichaTecnicaCompra',
    'vColoresEstiloVista',
    'vAvanceProduccion',
    'vMaterialAnoSemMaqDesgloseControlEstilo',
    'vReimprimeNotaCredito',
    'vCobranzaDiaria',
    'vDocsPorVencer',
    'vReporteDocsVencidos',
    'vReportePagoSeguro',
    'vReportePagoPromedioClientes',
    'vReporteDevolucionesPorAplicar',
    'vEtiquetaCajas',
    'vPagosDiariosClientes',
    'vPagosDiariosClientesEfectivo',
    'vControlesVencimientoPorMaquila',
    'vControlesVencimientoPorCliente',
    'vControlesEntregadosPorFabrica',
    'vEstadoCuenta',
    'vEstadoCuenta8',
    'vEstadoCuentaAgente',
    'vEstadoCuenta306090',
    'vDetalladoMovimientos',
    'vRelacionNotasCredito',
    'vEstatusPedidoXGrupoAgente',
    'vEstatusPedidoXAgenteFechaCaptura',
    'vConsultaPedidoXAgenteFechaCaptura',
    'vPedidosAgenteCuatrimestre',
    'vControlesPorFacturarAClientes',
    'vReimprimeDocto',
    'vPagoComisiones',
    'vParesPesosTiendas',
    'vConsolidadoPorMes',
    'vConsolidadoPorLineaEstilo',
    'vVentasPorClienteAno', 'vVentasPorFecha', 'vModificaAClienteDevoluciones');

foreach ($vs as $v) {
    $this->load->view($v);
}

