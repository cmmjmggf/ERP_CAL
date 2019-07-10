<div id="MnuBlock" class="col-12 row justify-content-center mt-2" align="center">
    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-2 m-2 animated bounceIn" onclick="location.href = '<?php print base_url('Usuarios.shoes'); ?>'">
        <div class="card text-center">
            <div class="card-body">
                <span class="fa fa-user-circle fa-2x mt-5"></span> 
            </div>
            <div class="card-footer">
                <h5>USUARIOS</h5>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-2 m-2 animated bounceIn" onclick="location.href = '<?php print base_url('Accesos.shoes'); ?>'">
        <div class="card text-center">
            <div class="card-body">
                <span class="fa fa-key fa-2x mt-5"></span> 
            </div>
            <div class="card-footer">
                <h5>ACCESOS</h5>
            </div>
        </div>
    </div>
</div>
<style>
    .col-1, .col-2, .col-3, .col-4, .col-5,
    .col-6, .col-7, .col-8, .col-9, .col-10,
    .col-11, .col-12, .col, .col-auto, .col-sm-1,
    .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5,
    .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9,
    .col-sm-10, .col-sm-11, .col-sm-12,
    .col-sm, .col-sm-auto, .col-md-1,
    .col-md-2, .col-md-3, .col-md-4,
    .col-md-5, .col-md-6, .col-md-7,
    .col-md-8, .col-md-9, .col-md-10,
    .col-md-11, .col-md-12, .col-md,
    .col-md-auto, .col-lg-1, .col-lg-2,
    .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6,
    .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10,
    .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto,
    .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4,
    .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8,
    .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12,
    .col-xl, .col-xl-auto {
        padding-right: 1px;
        padding-left: 1px;
    }
    .card:hover img{
        -webkit-transition: all .3s ease-in-out;
        transition: all .3s ease-in-out;
        z-index: 99  !important;
    }
    .card{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
    .card:hover{
        cursor: pointer !important;
        font-weight: bold;
        background-color: #2384c6 !important;
        color: #fff;
    }
    .card:hover .card-body{
        cursor: pointer !important;
        font-weight: bold;
        background-color: #2384c6 !important;
        color: #fff;
    }
    .card:hover .card-footer{
        cursor: pointer !important;
        font-weight: bold;
        background-color: #2384c6 !important;
        color: #fff;
    }
    .card:hover .text-nowrap, .card:hover .figure-caption{
        color: #fff;
    }
    .fa-2x {
        font-size: 7.5em;
    }
    .mt-2, .my-2 {
        margin-top: 0.5rem !important;
        margin-right: 0px;
        margin-left: 0px;
    }

    @media (min-width: 100px) and (max-width: 1199.98px)  {
        #MnuBlock{
            display: none;
        }
    }
    .card.text-center {
        background-color: #fff;
    }
</style>