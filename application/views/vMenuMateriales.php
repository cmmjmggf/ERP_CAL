<!-- Contenido  -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <button class="btn btn-primary text-success btn-sm navbar-brand" id="sidebarCollapse">
        <i class="fa fa-cube"></i> Materiales
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
        getMenu(2);
    });


</script>

<?php
$this->load->view('vTipoCambio');
$this->load->view('vExplosionSemanal');
$this->load->view('vReporteInspeccion');
$this->load->view('vMaterialSemanaProduccionEstilo');
$this->load->view('vReporteCapturaFisica');
$this->load->view('vPreparaMesCapturaInv');
$this->load->view('vCapturaConteoInvfisico');
$this->load->view('vComparativoInvFisInvSis');
$this->load->view('vMovPorAjuste');
$this->load->view('vCierraInvMensual');
$this->load->view('vCostoInvMatPrima');
$this->load->view('vEtiquetasInventario');
$this->load->view('vInventarioAnual');
$this->load->view('vExplosionSemanalCliente');
$this->load->view('vExplosionSemanalArticulo');
$this->load->view('vCotejaExplosionOrdCom');
$this->load->view('vExplosionSemanalOrdComProyeccion');
$this->load->view('vConciliaFabricaProduccion');
$this->load->view('vCuentasPorCobrarMaquilas');
$this->load->view('vCajasEntregaControl');
$this->load->view('vComprasPorFechaGeneral');
$this->load->view('vComprasPorFechaPorArticulo');
$this->load->view('vDevolucionesCompraFecha');
$this->load->view('vSalidasMaquilasPorDia');
$this->load->view('vKardexPorArticulo');
$this->load->view('vKardexPorProveedor');
$this->load->view('vKardexSubAlmacenPorArticulo');
$this->load->view('vReporteCorteHiloTejer');
$this->load->view('vReporteMovimientosPorCompras');
$this->load->view('vReporteMovimientosEntradasOtros');
$this->load->view('vCosteoMatMaqDoc');
$this->load->view('vCosteoMatMaqSem');
$this->load->view('vCosteoMatMaqFecha');
$this->load->view('vEstadoCuentaProveedor');
$this->load->view('vAntiguedadSaldosProveedor');
$this->load->view('vReciboPagoProveedores');
$this->load->view('vMaterialRecibidoPedido');
$this->load->view('vReimprimirNotaCargo');
$this->load->view('vEntSalTipo');
$this->load->view('vEntSalSubAlmacen');
$this->load->view('vEntSalContablesFecha');
$this->load->view('vMatdeOtraMaqEntregadoAMaqUno');
$this->load->view('vListadoOrdComMaqSem');
$this->load->view('vVentaMatMaqSem');
$this->load->view('vFichaTecnicaCompra');
$this->load->view('vSalidaMaqGrupoFechas');
$this->load->view('vMaterialAnoSemMaqDesgloseControlEstilo');
$this->load->view('vConRelControlesXMaquila');
