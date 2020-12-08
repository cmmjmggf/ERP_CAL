<style>
    .sticky-top {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 1020;
    }
    /* Particle container. */
    #particle-container {
        position:fixed;
        top:0;
        right:0;
        bottom:0;
        left:0;
        z-index:0;
    }

    /*Hacer disbaled de selectize igual a bootstrap*/
    .selectize-control .selectize-input.disabled {
        background-color: #ecf0f1;
        opacity: 1;
    }
    /*Para textos que sobrepasen el largo*/
    .selectize-input {
        padding-right: 18px;
    }
    .selectize-input.focus {
        border-color: #597ea2;
        outline: 0;
        /* -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, 0.6);*/
        /* box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, 0.6); */
        box-shadow: 0 0 0 0.2rem #CDDC39 ;
    }
    /*Legend*/
    legend {
        font-size: 1.3rem;
    }

    /*No edición en controles*/
    .disabledForms {
        background-color: #ecf0f1;
        pointer-events: none;
    }
    /*Fondo aplicacion*/
    html{
        font-family: sans-serif;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
        -ms-overflow-style: scrollbar;
        -webkit-tap-highlight-color: transparent;
        /*        background-color: #f5f5f5;*/
    }

    body{
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-weight: 400;
        color: #495057;
        text-align: left;
        background-color: #F3F3F9;

        font-size: 0.8875rem;
    }
    .card-body {
        background-color: transparent !important;
    }

    /*Formularios*/
    label {
        margin-top: 0.596rem;
        margin-bottom: 0.18rem;
    }

    label.labelCheck {
        display: inline-block;
        margin-bottom: 0.5rem;
        margin-top: 0rem;
    }


    .form-control {
        color: #000 !important;
    }

    .form-control:focus {
        -webkit-box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
        box-shadow: 0 0 0 0.2rem #CDDC39;
        font-weight: bold;
        z-index: 1050 ;
    }

    /*Tablas */
    .table-sm th, .table-sm td {
        padding: 0.05rem;
    }

    table tbody tr{
        cursor: pointer;
        font-size: 0.8rem !important;
        background-color: white;
    }
    table tbody tr:hover td{
        background-color: #000 !important;
    }
    table thead tr{
        cursor: pointer;
        background-color: white;
    }

    table tfoot tr{
        cursor: pointer;
        background-color: white;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 0.5px solid #dee2e6;
    }
    table tbody tr:hover {
        background-color: #2C3E50 !important;
        color: #fff !important;
    }

    .table>tbody>tr>td.success,
    .table>tfoot>tr>td.success,
    .table>tbody>tr>th.success,
    .table>tfoot>tr>th.success,
    .table>tbody>tr.success>td,
    .table>tfoot>tr.success>td,
    .table>tbody>tr.success>th,
    .table>tfoot>tr.success>th {
        background-color: #2C3E50 ;
        color: #fff;
    }

    /*Hacer todo el texto de los inputs mayusculas*/

    input:not(.notEnter):not(.notUpperCase) {
        text-transform: uppercase;
    }
    textarea:not(.notEnter):not(.notUpperCase)  {
        text-transform: uppercase;
    }

    ::-webkit-input-placeholder { /* WebKit browsers */
        text-transform: none;
    }
    :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
        text-transform: none;
    }
    ::-moz-placeholder { /* Mozilla Firefox 19+ */
        text-transform: none;
    }
    :-ms-input-placeholder { /* Internet Explorer 10+ */
        text-transform: none;
    }
    ::placeholder { /* Recent browsers */
        text-transform: none;
    }
    .card {
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23)!important;
    }
    .btn:not(.dropdown-toggle):not(.navbar-brand){
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23)!important;
    }

    .btn-float{
        width: 61.1px;
        height: 61.1px;
        /*        font-size: 1.625rem;*/
        position: fixed;
        bottom: 35px;
        right: 30px;
        margin-bottom: 0;
        z-index: 9999 !important;
        border-radius: 50%;
        min-width: 56px;
    }

    .btn:not(.dropdown-toggle):not(.navbar-brand):focus {
        box-shadow: 0 0 0 0.2rem #CDDC39 !important;
    }
    button.buttons-pdf, button.buttons-pdf:hover{
        color: #fff;
        background-color: #d32f2f;
        border-color: #d32f2f;
    }
    button.buttons-collection, button.buttons-collection:hover{
        color: #fff;
        background-color: #3f51b5;
        border-color: #3f51b5;
    }
    button.buttons-excel, button.buttons-excel:hover{
        color: #fff;
        background-color: #4caf50;
        border-color: #4caf50;
    }
    .dt-button-collection, .dropdown-menu {
        color: #fff !important;
    }

    .dropdown-submenu:not(.show).dropdown-item {
        color: #4a4a4a !important;
    }
    .nav-item > .btn-primary{
        color: #fff;
        background-color: #111 !important;
        border-color: #111 !important;
    }
    label{
        font-weight: bold;
    }

    .swal-title{
        color: #000 !important;
    }
    .swal-text{
        color: #000 !important;
    }
    .swal-overlay {
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#000000+0,000000+100&0.71+0,0.6+51,0.7+100 */
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#000000+0,000000+100&0.71+0,0.19+52,0.7+100 */
        background: -moz-linear-gradient(top,  rgba(0,0,0,0.71) 0%, rgba(0,0,0,0.19) 52%, rgba(0,0,0,0.7) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  rgba(0,0,0,0.71) 0%,rgba(0,0,0,0.19) 52%,rgba(0,0,0,0.7) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  rgba(0,0,0,0.71) 0%,rgba(0,0,0,0.19) 52%,rgba(0,0,0,0.7) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b5000000', endColorstr='#b3000000',GradientType=0 ) !important; /* IE6-9 */

    }
    .swal-icon--success__hide-corners,.swal-icon--success:after, .swal-icon--success:before{
        background-color: transparent !important;
    }


    /*Submenu*/
    /*//Copy this css*/
    .navbar-light .navbar-nav .nav-link {
        color: rgb(64, 64, 64);
    }
    .btco-menu li > a {
        padding: 10px 15px;
        color: #000;

    }

    .btco-menu .active a:focus,
    .btco-menu li a:focus ,
    .navbar > .show > a:focus{
        background: transparent;
        outline: 0;
    }

    .dropdown-menu .show > .dropdown-toggle::after{
        transform: rotate(-90deg);
    }

    .modal-backdrop{
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#000000+0,000000+100 */
        background: rgb(0,0,0); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(0,0,0,1) 0%,rgba(0,0,0,1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(0,0,0,1) 0%,rgba(0,0,0,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#000000',GradientType=0 ); /* IE6-9 */
    }

    .blackdrop{
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#45484d+0,000000+100;Black+3D+%231 */
        background: rgb(69,72,77); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(69,72,77,1) 0%, rgba(0,0,0,1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#45484d', endColorstr='#000000',GradientType=0 ); /* IE6-9 */
    }
    .noBorders{
        border: 1px solid #ffffff;
        font-size: 14px;
        font-weight: bold;
    }
    .noBorders:focus{
        box-shadow: none;
        -webkit-box-shadow: none;
        border-color: #ffffff;
    }
    .badge-fusion-success {
        color: #fff;
        background-color: #8BC34A;
    }
    .badge-fusion{
        color: #fff;
        background-color: #673AB7;
    }
    .card {
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23)!important;
    }

    .card-body .custom-control-label::after {
        position: absolute;
        top: 0.25rem;
        left: 0;
        display: block;
        width: 1rem;
        height: 1rem;
        border-radius: 3px;
        content: "";
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 50% 50%;
        background-color: #2C3E50;
    }

    .btn-info{
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-info:hover{
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-warning:hover{
        color: #fff;
        background-color: #fd7e14;
        border-color: #fd7e14;
    }
    .btn-danger:hover{
        color: #fff;
        background-color:#dc3545;
        border-color: #dc3545;
    }
    .bg-primary {
        background-color: #111 !important;
    }
    nav button.btn-primary{
        background-color: #111 !important;
        border-color: #111 !important;
    }
    .dropdown-item:hover, .dropdown-item:focus {
        color: #fff !important;
        text-decoration: none;
        background-color: #111 !important;

        <?php if (!is_null($this->session->TEMA) && $this->session->TEMA === "OSCURO") {
            ?>
            color: #000 !important;
            text-decoration: none;
            background-color: #ffffff !important;
        <?php } ?>
    }

    label {
        margin-top: 0.14rem;
        margin-bottom: 0.0rem;
    }

    /*ROOTS*/
    /*    --blue: #007bff;
        --indigo: #6610f2;
        --purple: #6f42c1;
        --pink: #e83e8c;
        --red: #dc3545;
        --orange: #fd7e14;
        --yellow: #ffc107;
        --green: #28a745;
        --teal: #20c997;
        --cyan: #17a2b8;
        --white: #fff;
        --gray: #868e96;
        --gray-dark: #343a40;
        --primary: #007bff;
        --secondary: #868e96;
        --success: #28a745;
        --info: #17a2b8;
        --warning: #ffc107;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #343a40;*/
    body{
        color: #000 !important;
    }
    button.navbar-brand.text-success {
        color: #fff !important;
    }
    .dropdown-item {
        color: #000 !important;
    }
    .btn-indigo {
        color: #fff;
        background-color: #3F51B5;
        border-color: #3F51B5;
        box-shadow: 0 0 0 0.2rem #CDDC39 !important;
    }
    .btn-green {
        color: #fff;
        background-color: #4CAF50;
        border-color: #4CAF50;
    }
    .btn-red {
        color: #fff;
        background-color: #D32F2F;
        border-color: #D32F2F;
    }
    .btn-black{
        color: #ffffff;
        background-color: #000000;
        border: solid 2px #fff;
    }
    .btn-black-o{
        color: #000000;
        background-color: #ffffff;
        border: solid 2px #191919;
        font-weight: bold !important;
    }
    .fancybox-show-nav .fancybox-arrow {
        opacity: 1 !important;
    }
    .fancybox-arrow:after {
        background-color: #8BC34A !important
            background-size: 36px 36px !important;
    }

    .blinkb{
        border: 2px solid #ffffff;
        border-radius: 5px;
        -webkit-animation: myfirst 1.5s linear 0.5s infinite alternate; /* Safari 4.0 - 8.0 */
        animation: myfirst 1.5s linear 0.5s infinite alternate;
        box-shadow: 0 0px 12px  #03A9F4;
    }

    /* Safari 4.0 - 8.0 */
    @-webkit-keyframes myfirst {
        25%  {
            border-color:  #007bff;
        }
        50%  {
            border-color:  #ffffff;
        }
        75%  {
            border-color:  #007bff;
        }
        100% {
            border-color:  #ffffff;
        }
    }

    /* Standard syntax */
    @keyframes myfirst {
        0%   {
            border-color:  #007bff;
        }
        25%  {
            border-color:  #ffffff;
        }
        50%  {
            border-color:  #007bff;
        }
        75%  {
            border-color:  #ffffff;
        }
        100% {
            border-color:  #007bff;
        }
    }
    .modal-content{
        border: 2px solid #263238 !important;
        filter: drop-shadow(0 0 0.75rem #000);
    }

    table tbody tr  {
        font-size: 0.72rem !important;
    }
    nav .btn-primary .dropdown-toggle , nav .session-dropdown .dropdown-toggle {
        padding-top: 3px;
        padding-bottom: 3px;
    }

    nav.navbar .btn-primary , ul.dropdown-menu a {
        color: white;
        font-size: 13px;
        text-transform: uppercase;
        font-weight: bold !important;
    }

    input, .selectize-input, textarea, select {
        border: 2px solid #000 !important;
        font-weight: bold !important;
    }
    div:not(.card-menu):not(.card-session).card:not(.bg-danger):not(.bg-info):not(.bg-success):not(.bg-primary):not(.bg-warning) 
    text-transform: uppercase;
    background: rgb(255,255,255);
    background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(199,203,215,1) 100%);
    border-radius: 15px !important;
    }

    button.btn{
        font-weight: bold;
    }
    .loader {
        position: relative;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: linear-gradient(45deg, transparent, transparent 40%, #e5f403);
        animation: animatex 2s linear infinite;
    }

    .loader::before {
        content: "";
        position: absolute;
        top: 6px;
        left: 6px;
        right: 6px;
        bottom: 6px;
        background-color: #333;
        border-radius: 50%;
        z-index: 1000;
    }

    .loader::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, transparent 40%, #e5f403);
        border-radius: 50%;
        z-index: 100;
        filter: blur(2px);
    }

    /* la animacion */

    @keyframes animatex {
        0% {
            transform: rotate(0deg);
            filter: hue-rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
            filter: hue-rotate(360deg);
        }
    }
    .marope-r{
        font-family: 'Manrope-Regular';
        font-size: 15px !important;
        text-transform: uppercase;
    }
    .marope{
        font-family: 'Manrope-Regular';
        text-transform: uppercase;
    }
    @font-face {
        font-family: 'Manrope-Regular';
        src: url('<?php print base_url('fonts/exclusive/Manrope-Regular.eot'); ?>');
        font-weight: 500;
        font-style: normal;
    }
    @font-face {
        font-family: 'Manrope-Regular';
        src: url('data:application/font-woff2;charset=utf-8;base64,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') format('woff2'),
            url('data:application/font-woff;charset=utf-8;base64,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') format('woff'),
            url('<?php print base_url('fonts/exclusive/Manrope-Regular.ttf'); ?>') format('truetype'),
            url('<?php print base_url('fonts/exclusive/Manrope-Regular.svg#Manrope-Regular'); ?>') format('svg');
        font-weight: 500;
        font-style: normal;
        font-display: swap;
    }
</style>
<!--STYLE NEGRO-->
<?php
if (!is_null($this->session->TEMA) && $this->session->TEMA === "ACTUAL" ||
        !is_null($this->session->TEMA) && $this->session->TEMA === "OSCURO") {
    ?>
    <link rel="stylesheet" href="<?php print base_url('js/vegas/vegas.min.css'); ?>">
    <script src="<?php print base_url('js/vegas/vegas.min.js'); ?>"></script>
    <style>
        body{
            /* Location of the image */
            <?php
            if (!is_null($this->session->TEMA) && $this->session->TEMA === "OSCURO") {
                ?>
                background-image: url(<?php print base_url('media/x5.jpg') ?>);
            <?php } else { ?>
                background-image: url(<?php print base_url('media/7.jpg') ?>);
            <?php } ?>
            /* Background image is centered vertically and horizontally at all times */
            background-position: center center;

            /* Background image doesn't tile */
            background-repeat: no-repeat;

            /* Background image is fixed in the viewport so that it doesn't move when
               the content's height is greater than the image's height */
            background-attachment: fixed;

            /* This is what makes the background image rescale based
               on the container's size */
            background-size: cover;

            /* Set a background color that will be displayed
               while the background image is loading */
            background-color: #464646;
        }
        .bg-primary , .dropdown-menu{
            <?php
            if ($this->session->TEMA === "OSCURO") {
                ?>
                background-color: rgba(0,0,0,.65) !important;
            <?php } else { ?>
                background-color: rgba(29,29,31,0.72)!important;
            <?php } ?>
        }
        nav button.btn-primary,  .nav-item > .btn-primary{
            background-color: transparent !important;
            border-color: transparent  !important;
        }
        .dropdown-item {
            color: #fff !important;
        }
        .watermark p {
            color: #d2daed !important;
        }
    </style>
    <?php
}
?>