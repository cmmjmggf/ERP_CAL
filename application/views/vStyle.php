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
    .card {
        background-color: transparent;
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
        background-color: #fff;
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
        background-color: #d7e1e6;
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
    div:not(.card-menu):not(.card-session).card  {
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