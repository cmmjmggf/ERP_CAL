<style>


    /* ---------------------------------------------------
        SIDEBAR STYLE
    ----------------------------------------------------- */
    a,
    a:hover,
    a:focus {
        color: inherit;
        text-decoration: none;
        transition: all 0.3s;
    }

    #sidebar {
        width: 250px;
        position: fixed;
        top: 0;
        left: -250px;
        height: 100vh;
        z-index: 1031;
        color: #fff;
        transition: all 0.3s;
        overflow-y: scroll;
        box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.2);

    }

    #sidebar.active {
        left: 0;
    }

    #dismiss {
        width: 35px;
        height: 35px;
        line-height: 35px;
        text-align: center;
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        color: #000;
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
    }

    #dismiss:hover {
        color: #95a5a6;
    }

    .overlay {
        top:0;
        display: none;
        position: fixed;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.7);
        z-index: 1030;
        opacity: 0;
        transition: all 0.5s ease-in-out;
    }
    .overlay.active {
        display: block;
        opacity: 1;
    }

    #sidebar .sidebar-header {
        padding: 20px;
        color: #000;
        background: #FFF;
    }

    #sidebar ul.collapse.show {
        background: #11181f;
    }


    #sidebar ul.components {
        padding: 10px 0;
        border-bottom: 1px solid #FFF;
    }

    #sidebar ul p {
        color: #fff;
        padding: 10px;
    }

    #sidebar ul li a {
        padding: 10px;
        font-size: 1.1em;
        display: block;
    }



    #sidebar ul li a:hover {
        color: #2C3E50;
        background: #fff;
    }

    #sidebar ul li.active>a,
    #sidebar a[aria-expanded="true"] {
        color: #fff;
        background: #11181f;
    }

    #sidebar a[data-toggle="collapse"] {
        position: relative;
    }



    #sidebar .dropdown-toggle::after {
        display: block;
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
    }

    #sidebar ul ul a {
        font-size: 0.9em !important;
        padding-left: 55px !important;

    }

    #sidebar ul ul ul a {
        font-size: 0.9em !important;
        padding-left: 85px !important;
    }
    .navbar{
        box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
        -webkit-box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
    }
</style>

<!-- Sidebar  -->
<nav id="sidebar" class="bg-primary">
    <div id="dismiss">
        <i class="fas fa-arrow-left fa-lg"></i>
    </div>
    <div class="sidebar-header">
        <a href="<?php print base_url() ?>">
            <img src="<?php print base_url(); ?>img/logo_mediano.png" width="160">
        </a>
    </div>
    <!--    <ul class="list-unstyled pl-3 pr-3 pt-3">
            <li>
                <input type="text" class="form-control form-control-sm" autofocus="" placeholder="BUSCAR" id="txtBusqueda">
            </li>
        </ul>-->
    <ul class="list-unstyled components main">
    </ul>
    <ul class="list-unstyled pl-3 pr-3">
        <li>
            <span class="badge badge-warning btn-block px-3 py-2">V 1.0.0</span>
        </li>
    </ul>
</nav>
<div class="overlay"></div>
<script>
    var sidebar = $("#sidebar");
    var components = sidebar.find("ul.list-unstyled.components");
    var options = components.find("li.item");

    $(document).ready(function () {
        /*KEYUP, KEYDOWN, KEYPRESS; SON REQUERIDOS PARA LOS NON-PRINTABLE CHARACTERS*/
        sidebar.find("#txtBusqueda").on('keyup', function (e) {
            onBuscarSideBar(this);
        }).on('keydown', function (e) {
            onBuscarSideBar(this);
        }).on('keypress', function (e) {
            onBuscarSideBar(this);
        });

        sidebar.mCustomScrollbar({
            theme: "minimal"
        });

        $('#dismiss, .overlay').on('click', function () {
            $('#sidebar').removeClass('active');
            $('.overlay').removeClass('active');
            onResetSearch();
            sidebar.find("#txtBusqueda").val('');
        });

        var event;
        if (isMobile) {
            $("#sidebarCollapse").touch();
            event = 'tap';
        } else {
            event = 'click';
        }
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').addClass('active');
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            $('#txtBusqueda').focus();
        });
    });

    function onBuscarSideBar(e) {
        var busqueda = $(e).val();
        onResetSearch();
        if (busqueda.length > 0) {
            /*AGREGANDO CLASES PARA EXPANDIR COMPONENTES*/
            components.find("a.dropdown-toggle.collapsed").removeClass("collapsed");
            components.find("a.dropdown-toggle").attr('aria-expanded', true);
            components.find("a.dropdown-toggle").next().addClass('show');
            /*LEER CADA UNA DE LAS OPCIONES DISPONIBLES*/
            $.each(options, function (k, v) {
                var ul = $(v).parents('li.drop');
                /*ENCUENTRA LA COINCIDENCIA*/
                if ($(v).text().toUpperCase().includes(busqueda.toUpperCase())) {
                    $(v).removeClass("d-none");
                } else {
                    $(v).addClass("d-none");
                    /*VERIFICAR SI LA LISTA TIENE COMPONENTES PARA MOSTRAR DE LO CONTRARIO OCULTARLA*/
                    if (ul.find("li.item").length === ul.find("li.item.d-none").length) {
                        ul.addClass('d-none');
                    }
                }
            });
        } else {
            onResetSearch();
        }
    }
    function onResetSearch() {
        components.find("a.dropdown-toggle").addClass("collapsed");
        components.find("a.dropdown-toggle").attr('aria-expanded', false);
        components.find("a.dropdown-toggle").next().removeClass('show');
        $.each(options, function (k, v) {
            $(v).parents('li.drop').removeClass("d-none");
            $(v).removeClass("d-none");
        });
    }
</script>
