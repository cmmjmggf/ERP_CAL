<div id="particle-container"></div>
<div class="col-12">
    <div id="MnuBlock" class="col-12 row justify-content-center mt-2" align="center"></div>
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
<script>
    $(document).ready(function () {
        getQuickMenu(1);
        onComprobarModulos(1);
    });
</script>
<script>
    $.ajax({
        url: "https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js",
        dataType: "script",
        success: function () {
            particlesJS("particle-container", {
                "particles": {
                    "number": {
                        "value": 10,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": ["#2C3E50", "#2C3E50"]/* "random" = cualquier color*/
                    },
                    "shape": {
                        "type": "image",
                        "image": {
                            "src": "<?php print base_url('img/LS.png'); ?>", // Set image path.
                            "width": 1, // Width and height don't decide size.
                            "height": 1   // They just decide aspect ratio.
                        }
                    },

                    "opacity": {
                        "value": 0.5,
                        "random": false,
                        "anim": {
                            "enable": false,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 50,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 80,
                            "size_min": 10,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": false,
                        "distance": 150,
                        "color": "#ffffff",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 1,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": true,
                        "attract": {
                            "enable": true,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": false,
                            "mode": "repulse"
                        },
                        "onclick": {
                            "enable": false,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 400,
                            "line_linked": {
                                "opacity": 1
                            }
                        },
                        "bubble": {
                            "distance": 400,
                            "size": 40,
                            "duration": 2,
                            "opacity": 8,
                            "speed": 3
                        },
                        "repulse": {
                            "distance": 200,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 4
                        },
                        "remove": {
                            "particles_nb": 2
                        }
                    }
                },
                "retina_detect": true
            });
        }
    });
</script>