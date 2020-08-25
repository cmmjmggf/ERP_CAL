<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="<?php print base_url(); ?>img/manifest.json">


        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php print base_url(); ?>img/favicon/apple-touch-icon-57x57.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php print base_url(); ?>img/favicon/apple-touch-icon-114x114.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php print base_url(); ?>img/favicon/apple-touch-icon-72x72.png" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php print base_url(); ?>img/favicon/apple-touch-icon-144x144.png" />
        <link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php print base_url(); ?>img/favicon/apple-touch-icon-60x60.png" />
        <link rel="apple-touch-icon-precomposed" sizes="120x120" href=<?php print base_url(); ?>img/favicon/"apple-touch-icon-120x120.png" />
        <link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php print base_url(); ?>img/favicon/apple-touch-icon-76x76.png" />
        <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php print base_url(); ?>img/favicon/apple-touch-icon-152x152.png" />
        <link rel="icon" type="image/png" href="<?php print base_url(); ?>img/favicon/favicon-196x196.png" sizes="196x196" />
        <link rel="icon" type="image/png" href="<?php print base_url(); ?>img/favicon/favicon-96x96.png" sizes="96x96" />
        <link rel="icon" type="image/png" href="<?php print base_url(); ?>img/favicon/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="<?php print base_url(); ?>img/favicon/favicon-16x16.png" sizes="16x16" />
        <link rel="icon" type="image/png" href="<?php print base_url(); ?>img/favicon/favicon-128.png" sizes="128x128" />
        <meta name="application-name" content="&nbsp;"/>
        <meta name="msapplication-TileColor" content="#FFFFFF" />
        <meta name="msapplication-TileImage" content="<?php print base_url(); ?>img/favicon/mstile-144x144.png" />
        <meta name="msapplication-square70x70logo" content="<?php print base_url(); ?>img/favicon/mstile-70x70.png" />
        <meta name="msapplication-square150x150logo" content="<?php print base_url(); ?>img/favicon/mstile-150x150.png" />
        <meta name="msapplication-wide310x150logo" content="<?php print base_url(); ?>img/favicon/mstile-310x150.png" />
        <meta name="msapplication-square310x310logo" content="<?php print base_url(); ?>img/favicon/mstile-310x310.png" />
        <meta name="theme-color" content="#ffffff">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>ShoeSystem ERP</title>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?php print base_url(); ?>js/jquery-3.2.1.min.js"></script>
        <!--Estilo principal-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-flaty.css">
        <!--Submenu
        <!--
        <link href="<?php print base_url('js/submenu-boostrap4/bootstrap-4-navbar.min.css') ?>" rel="stylesheet">
        -->
        <!--DataTables Plugin-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>js/tabletools/master/DataTables/datatables.min.css">
        <script src="<?php echo base_url(); ?>js/tabletools/master/DataTables/datatables.js"></script>

<!--        <script src="<?php echo base_url(); ?>js/tabletools/master/DataTables/datatables.min.js"></script>-->
        <script src="<?php echo base_url(); ?>js/tabletools/master/DataTables/JSZip-3.1.3/jszip.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/tabletools/master/DataTables/Buttons-1.5.1/js/buttons.html5.min.js" type="text/javascript"></script>
        <!--select2 control-->
        <script src="<?php echo base_url(); ?>js/selectize/js/standalone/selectize.min.js"></script>
        <link href="<?php echo base_url(); ?>js/selectize/css/selectize.bootstrap.css" rel="stylesheet" />

        <!--Third Party-->
        <script src="<?php print base_url('js/printjs/print.min.js'); ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php print base_url('js/printjs/print.min.css'); ?>">


        <!-- PivotTable.js libs from ../dist -->
        <script  src="<?php print base_url(); ?>js/jquery-ui.min.js"></script>
        <link href="<?php print base_url(); ?>css/jquery-ui.min.css" rel="stylesheet" />

        <link rel="stylesheet" href="<?php print base_url(); ?>js/pivot/dist/pivot.css">
        <script  src="<?php print base_url(); ?>js/pivot/dist/pivot.js"></script>

        <!--Pace loading and performance for web applications-->
        <script src="<?php print base_url(); ?>js/pace.min.js"></script>
        <link href="<?php print base_url(); ?>css/pace.css" rel="stylesheet" />
        <!--Font Awesome Icons-->
        <!--<script defer src="<?php print base_url(); ?>js/fontawesome-all.js"></script>-->
        <script defer src="<?php print base_url(); ?>js/all.js"></script>
        <link rel="stylesheet" href="<?php print base_url(); ?>css/animate.min.css">
        <!--HoldOn Stupid Accions-->
        <link href="<?php print base_url(); ?>css/HoldOn.min.css" rel="stylesheet">
        <script src="<?php print base_url(); ?>js/HoldOn/HoldOn.min.js"></script>
        <!--HoldOn Stupid Accions-->
        <script src="<?php print base_url(); ?>js/touch/jquery.touch.min.js"></script>
        <!--MasekdAll-->
        <script src="<?php print base_url(); ?>js/inputmask/dependencyLibs/inputmask.dependencyLib.jquery.js"></script>
        <script src="<?php print base_url(); ?>js/inputmask/jquery.inputmask.bundle.js"></script>
        <script src="<?php print base_url(); ?>js/inputmask/inputmask.js"></script>
        <script src="<?php print base_url(); ?>js/inputmask/inputmask.extensions.js"></script>
        <script src="<?php print base_url(); ?>js/inputmask/inputmask.numeric.extensions.js"></script>
        <script src="<?php print base_url(); ?>js/inputmask/inputmask.date.extensions.js"></script>
        <script src="<?php print base_url(); ?>js/inputmask/inputmask.phone.extensions.js"></script>
        <script src="<?php print base_url(); ?>js/inputmask/jquery.inputmask.min.js"></script>

        <!-- BOOTSTRAP TOUR JS -->
        <link href="<?php echo base_url(); ?>js/bootstrap-tour-master/build/css/bootstrap-tour.min.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>js/bootstrap-tour-master/build/js/bootstrap-tour.js"></script>

        <!--Masked number format money etc-->
        <script src="<?php print base_url(); ?>js/jquery.maskedinput.min.js"></script>
        <!--Masked number format money etc-->
        <script src="<?php print base_url(); ?>js/jquery.maskMoney.min.js"></script>
        <!--Modales simplificados-->
        <script src="<?php print base_url(); ?>js/swal/sweetalert.min.js"></script>

        <!--Notifiers-->
        <script src="<?php echo base_url(); ?>js/notify/bootstrap-notify-3.1.3/bootstrap-notify.min.js"></script>
        <!--jQuery Number Format-->
        <script src="<?php echo base_url(); ?>js/jnumber/jquery.number.min.js"></script>
        <!--JS XLXS API-->
        <script src="<?php echo base_url(); ?>js/js-xlsx/jszip.js"></script>
        <script src="<?php echo base_url(); ?>js/js-xlsx/xlsx.js"></script>
        <!-- Shortcut key -->
        <script src="<?php echo base_url(); ?>js/ShortCut/shortcut.js"></script>

        <!--FancyBoxJS-->
        <link rel="stylesheet" href="<?php echo base_url("js/fancybox/jquery.fancybox.min.css"); ?>" />
        <script src="<?php echo base_url("js/fancybox/jquery.fancybox.min.js"); ?>"></script>

        <!--VegasJS-->
        <link rel="stylesheet" href="<?php echo base_url("js/vegas/vegas.min.css"); ?>" >
        <script src="<?php echo base_url("js/vegas/vegas.min.js"); ?>"></script>

        <!--EasyAutocompleteJS-->
        <!-- JS file -->
        <script src="<?php echo base_url("js/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js"); ?>"></script>
        <!-- CSS file -->
        <link rel="stylesheet" href="<?php echo base_url("js/EasyAutocomplete-1.3.5/easy-autocomplete.min.css"); ?>">
        <!-- Additional CSS Themes file - not required-->
        <link rel="stylesheet" href="<?php echo base_url("js/EasyAutocomplete-1.3.5/easy-autocomplete.themes.min.css"); ?>">
        <!--Cargar scripts de validacion y configuraciones-->
        <?php $this->load->view('vScripts') ?>
        <?php $this->load->view('vStyle') ?>
        <link rel="stylesheet" type="text/css" href="<?php print base_url('js/waves/waves.min.css'); ?>" />
        <script type="text/javascript" src="<?php print base_url('js/waves/waves.min.js'); ?>"></script>
        <!--Formato de fechas para poder ordenar datatables-->
        <!-- Moment.js: -->
        <script src="<?php echo base_url("js/momentjs/moment.min.js"); ?>"></script>
        <!-- Locales for moment.js-->
        <script src="<?php echo base_url("js/momentjs/es.js"); ?>"></script>
        <script src="<?php echo base_url("js/momentjs/datetime-moment.js"); ?>"></script>

        <script>
            $(document).ready(function () {
                Waves.attach('.btn:not(.btn-float)', ['waves-effect']);
                Waves.init();
                $.fancybox.defaults.animationEffect = "zoom-in";
                $.fancybox.defaults.animationEffect = "zoom-in-out";
                $.post('<?php print base_url('FichaTecnica/getIPEquipo'); ?>', ).done(function (a) {
                    console.log(a);
                }).fail(function (x) {
                    console.log(x);
                });
            });
        </script>
    </head>
    <?php
    if (session_status() === 2 && isset($_SESSION["LOGGED"]) && $this->session->USERNAME === 'X') {
        $HOY = Date('Y-m-d');
        $IDX = $this->session->ID;
        $IPX = $_SERVER['REMOTE_ADDR'];
        $this->db->query("UPDATE usuarios SET IP = '{$IPX}' "
                . "WHERE ID = {$IDX} 
            AND YEAR(UltimaModificacion) = YEAR('{$HOY}') 
            AND MONTH(UltimaModificacion) = MONTH('{$HOY}')  
            AND IP <> '{$IPX}'");
    }
    $this->load->view('vPerfil');
    