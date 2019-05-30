<style>
    /* Particle container. */
    #particle-container {
        position:fixed;
        top:0;
        right:0;
        bottom:0;
        left:0;
        z-index:0;
    }
    .selectize-input {
        border: 1px solid #9E9E9E;
    }
    .form-control {
        border: 1px solid #9E9E9E;
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
        background-color: #f5f5f5;
    }

    body{
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-weight: 400;
        color: #495057;
        text-align: left;
        background-color: transparent;

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
    table tbody tr{
        cursor: pointer;
        font-size: 0.8rem !important;
        background-color: white;

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
        font-weight: bold !important;
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
    input {
        text-transform: uppercase;
    }
    textarea  {
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
    .btn-group > .btn:not(:first-child), .btn-group > .btn-group:not(:first-child) > .btn {

        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23)!important;
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
    table tbody tr:hover {
        background-color: #000000 !important;
        color: #fff !important;
        font-weight: bold !important;
    }
    .card {
        background-color: #dadfe4;
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


</style>