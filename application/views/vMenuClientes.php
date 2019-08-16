<!-- Contenido  -->
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
$this->load->view('vTipoCambio')->view('vBloqueoClientesXCliente')
        ->view('vBloqueoClientesAutomatico')->view('vCajasFlete')
        ->view('vGeneraPinAutoClientes')->view('vCapturaPrecioDeVtaXListaLinea')
        ->view('vFichaTecnicaCompra')->view('vColoresEstiloVista');

$this->load->view('vAvanceProduccion');
$this->load->view('vMaterialAnoSemMaqDesgloseControlEstilo');
$this->load->view('vReimprimeNotaCredito');
$this->load->view('vCobranzaDiaria');
$this->load->view('vDocsPorVencer');
$this->load->view('vReporteDocsVencidos');
$this->load->view('vReportePagoSeguro');
$this->load->view('vReportePagoPromedioClientes');
$this->load->view('vReporteDevolucionesPorAplicar');
$this->load->view('vEtiquetaCajas');
$this->load->view('vPagosDiariosClientes');
$this->load->view('vPagosDiariosClientesEfectivo');
$this->load->view('vControlesVencimientoPorMaquila');
$this->load->view('vControlesVencimientoPorCliente');
$this->load->view('vControlesEntregadosPorFabrica');
$this->load->view('vEstadoCuenta');
$this->load->view('vEstadoCuenta8');
$this->load->view('vEstadoCuentaAgente');

