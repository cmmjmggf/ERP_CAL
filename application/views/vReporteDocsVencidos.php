<script>

    function onReporteDocsVencidos() {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        $.post(base_url + 'index.php/ReportesClientesJasper/onReporteDocsVencidos').done(function (data) {
            if (data.length > 0) {
                onImprimirReporteFancyAFC(data, function () {
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }
</script>