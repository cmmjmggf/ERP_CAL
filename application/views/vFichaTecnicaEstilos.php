<!DOCTYPE html>
<html>
    <head>
        <title>360 Virtual Tour PHP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="360 Virtual Tour PHP"/>
        <meta charset="UTF-8">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
        <!--<link href="<?php // print base_url('js/OwlCarousel2-2.3.4/dist/assets/owl.carousel.css'); ?>" media="all" rel="stylesheet" type="text/css" />-->
        <link href="<?php print base_url('css/360/owl.carousel.css'); ?>" media="all" rel="stylesheet" type="text/css" />
        <style>
            body {
                margin:0;
                padding:0;
                overflow:hidden;
            }

            .panorama-body {
                font-size: 18px;
                line-height: 1.5em;
                position: relative;
                margin: 0;
                padding: 0;
                display: inline-block;
                overflow: hidden;
                background: white;
                text-align: center;
                width:100%;
                height:100%;
                overflow: hidden;
            }

            .panorama-body a {
                color: inherit;
            }

            #panorama{
                width: 100%;
                height: 100%;
                position: relative;
                margin: 0 auto;
                overflow: hidden;
                cursor: move; /* fallback if grab cursor is unsupported */
                cursor: grab;
                cursor: -webkit-grab;
            }

            #panorama:active { 
                cursor: grabbing;
                cursor: -webkit-grabbing;
            }

            #panoramaImage {
                display:none;
            }
            .panorama-body canvas {
                margin-right: auto;
                margin-left: auto;
                margin:auto;
                width: 100%!important;
                height: 100%!important;
            }

            .top_buttons {
                position: absolute;
                right: 26px;
                top: 26px;
                font-size: 32px;
                color: white;
                border-radius: 30px;
                padding: 11px 1px 10px 6px;
                width: 99px;
                height: 45px;
            }

            #fullscreen {
                padding: 5px 9px 2px 9px;
                border-radius: 30px;
                cursor: pointer;
                float: right;
                padding-right: 20px;
            }

            #audio {
                padding: 5px 9px 2px 9px;
                border-radius: 30px;
                opacity: 0.9;
                cursor: pointer;
            }

            .zoom_conrol{
                position: absolute;
                right: 30px;
                bottom: 112px;
                font-size: 32px;
                color: white;
            }

            #zoom_in {
                cursor: pointer;
            }

            #zoom_out {
                cursor: pointer;
            }
            .zoom {
                width: 32px;
                padding: 3px;
            }

            .keys {
                position: absolute;
                right: 10px;
                top: 10px;
                font-size: 32px;
                color: white;
                background: rgba(0, 0, 0, 0.4);
                padding: 56px 14px 14px 14px;
                border-radius: 6px;
                width: 113px;
                height: 99px;
                z-index: 99;
            }
            i.keys{
                cursor:pointer;
            }
            .keys > i {
                cursor: pointer;
            }

            .key-icon {
                margin: 5px 14px 5px 14px
            }
            .key_down {
                margin-left:-6px;
            }

            img#right_key {
                left: 50px;
            }

            img#left_key {
                right: 20px;
            }

            img#up_key {
                bottom: 5px;
            }

            img#down_key {
                bottom: -64px;
            }

            img#elipse_key {
                left: 19px;
                bottom: -25px;
            }

            .control-key {
                position: absolute;
                bottom: 75px;
                width: 29px;
                right: 72px;
            }
            .control_keys {
                position: absolute;
                cursor: pointer;
            }

            .audio_player {
                cursor: pointer;
                background: rgba(0, 0, 0, 0.2);
                padding: 6px 18px 5px 25px;
                margin-left: -88px;
                border-radius: 27px;
                border-bottom-right-radius: 10px;
                border-top-right-radius: 10px;
            }

            #fullScreenMode {
                cursor: pointer;
                position: absolute;
                color: white;
                bottom: 100.5%;
                right: 60px;
                background: rgba(0, 0, 0, 0.4);
                padding: 11px 14px 4px 13px;
            }
            .menu-centered {
                width:100%;
            }

            i#pButton {
                margin-left: -5px;
                margin-top: -10px;
            }


            /* new style */

            #panos-list {
                position: absolute;
                z-index: 100;
                cursor: auto;
            }


            .pan-menu-item {
                text-decoration: none;
                text-transform: uppercase;
            }
            li.pan-menu {
                font-family: 'Open Sans', sans-serif;
                font-weight: 300;
                list-style: none;
                display: inline;
                padding: 1px 1px 3px 1px;
                font-size: 14px;
                border-radius: 1px;
                list-style: none;
                display: inline;
                cursor: pointer;
                float:left;
                background:  rgba(255, 255, 255, 0.76);
                margin: 4px;
                width:98%;
            }
            li.pan-menu:hover {
                background:white;
                color:#333333;
                transition: all .25s ease-in-out;
                -moz-transition: all .25s ease-in-out;
                -webkit-transition: all .25s ease-in-out;

            }

            .panos-menu {
                background: rgba(0, 0, 0, 0.2);
                z-index: 99;
            }
            #panos-list {
                position: absolute;
                z-index: 100;
                background: rgba(0, 0, 0, 0.4);
                padding: 0px 14px 15px 0;
                width: 100%;
                bottom:0px;
            }

            .menu-button {
                cursor: pointer;
                position: absolute;
                color: white;
                bottom: 100%;
                right: 13px;
                background: rgba(0, 0, 0, 0.4);
                padding: 14px;
            }

            .pan-description {
                height: 30px;
                width: auto;
                cursor: pointer;
                position: absolute;
                color: white;
                bottom: 100.5%;
                right: 110px;
                background: rgba(0, 0, 0, 0.4);
                padding: 11px 14px 4px 13px;
                font-family: 'Open Sans', sans-serif;
                font-size: 14px;
                text-align: left;
                cursor: auto;
            }
            .pan-description p {
                font-weight: 200;
                margin: 0;
                padding: 0;
                text-align: left;
                line-height: 19px;
                margin-top: -9px;
                padding-left: 5px;
                padding-right: 5px;
                font-size: 15px;
                color: rgb(236, 236, 233);
                cursor:auto;
            }

            .height-1 {
                max-height:1px;
                -webkit-animation-duration: 1s;
                animation-duration: 1s;
                -webkit-transition:all 1s;
                transition: all 1s;
            }

            #menu-show {
                padding:0;
                margin-top:10px;
                padding-left: 13px;
                padding-right: 13px;
                margin-bottom: 0;
            }
            .now-full-screen {

            }
            img#right_key {
                left:50px;
            }

            img#left_key {
                right:19px;
            }

            img#up_key {
                left:14px;
            }

            img#down_key {
                left:14px;
            }

            .pan-slide-thumb {
                width:100%;
                border-radius: 1px;
                display:block;
            }

            .owl-item {

            }

            /* iPads (portrait and landscape) ----------- */
            @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {    
                li.pan-menu {
                    width: 202px;
                    padding: 1px 0px 8px 0px;
                }
                .owl-item {

                }


            }
            @media only screen and (min-device-width : 768px) and (max-device-width : 770px) {
                .menu-centered {

                }  
            }

            @media only screen and (min-device-width : 1024px) and (max-device-width : 1050px){
                .menu-centered {

                }  
            }

            /* Smartphones (portrait and landscape) ----------- */
            @media only screen and (min-device-width : 320px) and (max-device-width : 480px) { 

                li.pan-menu {

                    padding: 1px 0px 8px 0px;
                }
                .pan-description {
                    display: none;
                }


                #fullScreenMode {
                    cursor: pointer;
                    position: absolute;
                    color: white;
                    bottom: 100.5%;
                    right: 60px;
                    background: rgba(0, 0, 0, 0.4);
                    padding: 11px 14px 4px 13px;
                }

                .keys {
                    display:none;
                }
            }

            #content {
                margin: 0 auto;
                padding-bottom: 50px;
                width: 80%;
                max-width: 978px;
            }  
            .menu-centered {
                margin-right: auto;
                margin-left: auto;
                padding-top:5px;
            }


            p.alert-message {
                background: red;
                color: white;
                margin: 0px;
                padding: 20px;
            }


            .owl-theme .owl-controls{
                margin-top: 2px;
                text-align: center;
            }

            /* Styling Next and Prev buttons */

            .owl-theme .owl-controls .owl-buttons div{
                color: #FFF;
                display: inline-block;
                zoom: 1;
                *display: inline;/*IE7 life-saver */
                margin: 5px;
                padding: 3px 10px;
                font-size: 12px;
                -webkit-border-radius: 30px;
                -moz-border-radius: 30px;
                border-radius: 30px;
                background: #869791;
                filter: Alpha(Opacity=50);/*IE7 fix*/
                opacity: 0.5;
            }
            /* Clickable class fix problem with hover on touch devices */
            /* Use it for non-touch hover action */
            .owl-theme .owl-controls.clickable .owl-buttons div:hover{
                filter: Alpha(Opacity=100);/*IE7 fix*/
                opacity: 1;
                text-decoration: none;
            }

            /* Styling Pagination*/

            .owl-theme .owl-controls .owl-page{
                display: inline-block;
                zoom: 1;
                *display: inline;/*IE7 life-saver */
            }
            .owl-theme .owl-controls .owl-page span{
                display: block;
                width: 15px;
                height: 15px;
                margin: 0px 3px;
                filter: Alpha(Opacity=50);/*IE7 fix*/
                opacity: 0.5;
                -webkit-border-radius: 20px;
                -moz-border-radius: 20px;
                border-radius: 20px;
                background:  rgba(255, 255, 255, 0.9);
            }

            .owl-theme .owl-controls .owl-page.active span,
            .owl-theme .owl-controls.clickable .owl-page:hover span{
                filter: Alpha(Opacity=100);/*IE7 fix*/
                opacity: 1;
            }

            /* If PaginationNumbers is true */

            .owl-theme .owl-controls .owl-page span.owl-numbers{
                height: auto;
                width: auto;
                color: #FFF;
                padding: 2px 10px;
                font-size: 12px;
                -webkit-border-radius: 30px;
                -moz-border-radius: 30px;
                border-radius: 30px;
            }

            /* preloading images */
            .owl-item.loading{
                min-height: 150px;
            }
        </style>
        <link href="<?php print base_url('css/animate.css'); ?>" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php print base_url('css/loaders.css'); ?>" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php print base_url('css/font-awesome.min.css'); ?>" media="all" rel="stylesheet" type="text/css" />
        <script src="<?php print base_url('js/360/jquery-1.12.2.min.js');?>"></script>
        <!--<script src="<?php // print base_url('js/jquery-3.2.1.min.js'); ?>"></script>-->
        <script>
            /* If you want to stop starting auto scroll panorama  just change 'false' value below. */
            var autoScrol = true;
        </script>
    </head>
    <body>
        <div class="panorama-body">
            <div id="panorama">
                <div id="pan-canvas"></div>
                <div class="panos-menu">
                    <div id="panos-list">
                        <ul id="menu-show">
                            <div class="menu-centered">
                                <div class="owl-carousel">
                                </div>
                            </div>
                        </ul>
                        <div class="pan-description"></div>
                        <i id="rotate" class="menu-button fa fa-chevron-down" aria-hidden="true"></i>
                        <span id="fullScreenMode" >
                            <span id="fullscreenPan"><img id="fullscreen-icon" src="<?php print base_url('css/360/fullscreen.png'); ?>"></span>
                        </span>
                        <div id="loader-pan" class="fadeInLeft animated">
                            <div class="wrapper">
                                <div class="cssload-loader"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="loader-wrapper">
                    <div class="first-wrapper">
                        <div class="first-cssload-loader"></div>
                    </div>
                    <div class="loader-section section-left"></div>
                    <div class="loader-section section-right"></div>
                </div>
            </div>
            <div class="top_buttons"></div>

            <div class="keys">
                <div class="zoom_conrol">
                    <span id="zoom_in"><img class="zoom" src="<?php print base_url('css/360/zoom-in.png'); ?>"></span>
                    <span id="zoom_out"><img class="zoom" src="<?php print base_url('css/360/zoom-out.png'); ?>"></span>
                </div>
                <div class="control-key">
                    <img class="control_keys" id="left_key" src="<?php print base_url('css/360/left_button.PNG'); ?>">
                    <img class="control_keys" id="right_key" src="<?php print base_url('css/360/right_button.PNG'); ?>">
                    <img class="control_keys" id="up_key" src="<?php print base_url('css/360/up_button.PNG'); ?>">
                    <img class="control_keys" id="down_key" src="<?php print base_url('css/360/down_button.PNG'); ?>">
                    <img class="control_keys" id="elipse_key" src="<?php print base_url('css/360/elipse.PNG'); ?>">
                </div>
            </div> 
            <!--<script src="<?php // print base_url('js/360/three/build/three.min.js'); ?>"></script>-->
            <script src="<?php print base_url('js/360/three.min.js'); ?>"></script>
            <script src="<?php print base_url('js/360/jquery.fullscreen.js'); ?>"></script>
            <script src="<?php print base_url('js/360/DeviceOrientationControls.js'); ?>"></script>
            <script src="<?php print base_url('js/360/mousehold.js'); ?>"></script>
            <!--<script src="<?php // print base_url('js/OwlCarousel2-2.3.4/dist/owl.carousel.min.js'); ?>"></script>-->
            <script src="<?php print base_url('js/360/owl.carousel.min.js'); ?>"></script>
            <script src="<?php print base_url('js/360/mousetrap.min.js'); ?>"></script>
            <script src="<?php print base_url('js/touch/jquery.touch.js'); ?>"></script>
            <script>
            "use strict";
            $(document).ready(function () {

                var sourceUrl = $('#source-url').val(); // change icons source URLs there
                var camera,
                        scene,
                        element = document.getElementById('pan-canvas'), // Inject scene into this
                        renderer,
                        controls,
                        fullscreenMode = false,
                        onPointerDownPointerX,
                        onPointerDownPointerY,
                        onPointerDownLon,
                        onPointerDownLat,
                        fov = 70, // Field of View
                        isUserInteracting = false,
                        lon = 0,
                        lat = 0,
                        phi = 0,
                        theta = 0,
                        onMouseDownMouseX = 0,
                        onMouseDownMouseY = 0,
                        onMouseDownLon = 0,
                        onMouseDownLat = 0,
                        width = $(document).width(), // int || window.innerWidth
                        height = $(document).height(), // int || window.innerHeight
                        windowHeight,
                        ratio = width / height,
                        touchX,
                        touchY,
                        geometry = [],
                        material = [],
                        mesh = [];
                var clickedMenu = true;
                var touchMove = true;
                var touchMoveStarter = 0;
                var textureNum = 0;
                var oldPan = 0;
                var panoramaImage;
                var texture = [];



                onloadPage();

                function onloadPage() {
                    $.get('<?php print base_url('js/360/data.txt');?>', function (data) {
                        var arrayOfNames = data.split('\n');
                        for (var i = 0; i < arrayOfNames.length; i++) {
                            arrayOfNames[i] = arrayOfNames[i].split(' | ');
                        }
                        arrayOfNames.pop();
                        var count = arrayOfNames.length;
                        var dataHash = 1;
                        // echo test 
                        for (var i = 0; i < arrayOfNames.length; i++) {

                            $('.owl-carousel').append('' +
                                    '<div data-hash="' + dataHash + '">' +
                                    '<li data-pan-id="' + dataHash + '" data-pan-desc="' + arrayOfNames[i][1] + '" id="pan-menu-' + dataHash + '" class="pan-menu">' +
                                    '<a class="pan-menu-item"  id="pan-image-' + dataHash + '" data-pan-href="<?php print base_url('css/360/land/'); ?>' + arrayOfNames[i][2] + '" href="#' + dataHash + '">' +
                                    '<img class="pan-slide-thumb" src="<?php print base_url('css/360/small/'); ?>'+ arrayOfNames[i][2] + '">' +
                                    arrayOfNames[i][0] +
                                    '</a>' +
                                    '</li>' +
                                    '</div>');
                            dataHash++;
                        }


                    }, pageWasloaded(), 'text');

                    function pageWasloaded() {
                        setTimeout(function () {

                            /* Functions */

                            locationHashSupport();
                            panoramaCaruserl();
                            buttonControl();
                            fullscreenPanorama();
                            buttonZoom();
                            playMusic();
                            fullPagePanorama();
                            owlCarousel();
                            changePanImage();
                            loadingOverlay();
                            hideMenu();
                            hideFullscreenOnIos();
                            panSlideSwipeFunction();
                            getPanDescription();
                        }, 500);
                    }

                }

                function locationHashSupport() {
                    if (isNaN(locationHash()) == false && locationHash() !== 0) {
                        panoramaImage = $('#pan-image-' + locationHash()).attr('data-pan-href');
                        $('.pan-description').html($('#pan-menu-' + locationHash()).attr('data-pan-desc'));
                    } else {
                        panoramaImage = $('#pan-image-1').attr('data-pan-href');
                        $('.pan-description').html($('#pan-menu-1').attr('data-pan-desc'));

                    }

                    texture[textureNum] = THREE.ImageUtils.loadTexture(panoramaImage, new THREE.UVMapping(), function () {
                        init();
                        animate();
                        controls.update();
                    });

                }

                function init() {

                    camera = new THREE.PerspectiveCamera(fov, ratio, 1, 3000);
                    controls = new THREE.DeviceOrientationControls(camera);
                    controls.connect();
                    scene = new THREE.Scene();
                    geometry[textureNum] = new THREE.SphereGeometry(1600, 60, 40);
                    material[textureNum] = new THREE.MeshBasicMaterial({
                        map: texture[[textureNum]]
                    });
                    mesh[textureNum] = new THREE.Mesh(geometry[textureNum], material[textureNum]);
                    mesh[textureNum].scale.x = -1;
                    scene.add(mesh[textureNum]);
                    renderer = new THREE.WebGLRenderer({
                        antialias: true
                    });
                    renderer.setSize(width, height);
                    element.appendChild(renderer.domElement);
                    camera.aspect = window.innerWidth / window.innerHeight;
                    camera.updateProjectionMatrix();
                    updateProjection();
                    // renderer.setPixelRatio( window.devicePixelRatio );
                    renderer.setSize(window.innerWidth, window.innerHeight);
                    element.addEventListener('mousedown', onDocumentMouseDown, false);
                    element.addEventListener('mousewheel', onDocumentMouseWheel, false);
                    element.addEventListener('DOMMouseScroll', onDocumentMouseWheel, false);

                    element.addEventListener('touchstart', onDocumentTouchStart, false);
                    element.addEventListener('touchmove', onDocumentTouchMove, false);

                    window.addEventListener('resize', onWindowResize, false);


                }

                function cleanMemory() {
                    if (textureNum !== oldPan) {
                        scene.remove(mesh[oldPan]);
                        geometry[oldPan].dispose();
                        geometry[oldPan] = null;
                        material[oldPan].dispose();
                        material[oldPan] = null;
                        texture[oldPan].dispose();
                        texture[oldPan] = null;
                        mesh[oldPan] = null;
                    }
                }

                function updateProjection() {
                    camera.projectionMatrix.makePerspective(fov, window.innerWidth / window.innerHeight, 1, 3000);
                }

                function onWindowResize() {

                    camera.aspect = window.innerWidth / window.innerHeight;
                    camera.updateProjectionMatrix();
                    renderer.setSize(window.innerWidth, window.innerHeight);
                }

                function onWindowResized(event) {
                    renderer.setSize(width, height);
                    camera.projectionMatrix.makePerspective(fov, ratio, 1, 3000);
                }

                function onDocumentMouseDown(event) {
                    event.preventDefault();
                    onPointerDownPointerX = event.clientX;
                    onPointerDownPointerY = event.clientY;
                    onPointerDownLon = lon;
                    onPointerDownLat = lat;
                    element.addEventListener('mousemove', onDocumentMouseMove, false);
                    element.addEventListener('mouseup', onDocumentMouseUp, false);
                    /* TOUCHSCREENS */
                    element.addEventListener('touchstart', onDocumentTouchStart, false);
                    element.addEventListener('touchmove', onDocumentTouchMove, false);
                }

                function onDocumentTouchMove(event) {

                    if (touchMove) {
                        event.preventDefault();
                        var touch = event.touches[0];
                        lon -= (touch.screenX - touchX) * 0.2;
                        lat -= (touch.screenY - touchY) * 0.2;
                        touchX = touch.screenX;
                        touchY = touch.screenY;
                    }
                }

                function onDocumentTouchStart(event) {

                    event.preventDefault();
                    var touch = event.touches[0];
                    touchX = touch.screenX;
                    touchY = touch.screenY;

                }

                function onDocumentMouseMove(event) {
                    lon = (event.clientX - onPointerDownPointerX) * -0.175 + onPointerDownLon;
                    lat = (event.clientY - onPointerDownPointerY) * -0.175 + onPointerDownLat;
                }

                function onDocumentMouseUp(event) {
                    element.removeEventListener('mousemove', onDocumentMouseMove, false);
                    element.removeEventListener('mouseup', onDocumentMouseUp, false);
                }

                function onDocumentMouseWheel(event) {
                    // WebKit
                    if (event.wheelDeltaY) {
                        fov -= event.wheelDeltaY * 0.05;
                        // Opera / Explorer 9
                    } else if (event.wheelDelta) {
                        fov -= event.wheelDelta * 0.05;
                        // Firefox
                    } else if (event.detail) {
                        fov += event.detail * 1.0;
                    }
                    if (fov < 45 || fov > 90) {
                        fov = (fov < 45) ? 45 : 90;
                    }
                    camera.projectionMatrix.makePerspective(fov, window.innerWidth / window.innerHeight, 1, 3000);

                }

                function animate() {
                    requestAnimationFrame(animate);
                    render();
                }

                Mousetrap.bind('right', function () {
                    onKeyRight();
                });
                Mousetrap.bind('left', function () {
                    onKeyLeft();
                });
                Mousetrap.bind('down', function () {
                    onKeyDown();
                });
                Mousetrap.bind('up', function () {
                    onKeyUp();
                });

                function onKeyRight() {
                    var counter = 0;
                    var tt = setInterval(function () {
                        startTime()
                    }, 10);

                    function startTime() {
                        lon += 0.25;
                        if (counter == 40) {
                            clearInterval(tt);
                        } else {
                            counter++;
                        }
                    }
                }

                function onKeyLeft() {
                    var counter = 0;
                    var tt = setInterval(function () {
                        startTime()
                    }, 10);

                    function startTime() {
                        lon -= 0.25;
                        if (counter == 40) {
                            clearInterval(tt);
                        } else {
                            counter++;
                        }
                    }

                }


                function onKeyDown() {
                    var counter = 0;
                    var tt = setInterval(function () {
                        startTime()
                    }, 10);

                    function startTime() {
                        lat += 0.25;
                        if (counter == 40) {
                            clearInterval(tt);
                        } else {
                            counter++;
                        }
                    }
                }


                function onKeyUp() {
                    var counter = 0;
                    var tt = setInterval(function () {
                        startTime()
                    }, 10);

                    function startTime() {
                        lat -= 0.25;
                        if (counter == 40) {
                            clearInterval(tt);
                        } else {
                            counter++;
                        }
                    }
                }

                function render() {

                    if (isUserInteracting === false) {
                        lon += .05;
                    }
                    lat = Math.max(-85, Math.min(85, lat));
                    phi = THREE.Math.degToRad(90 - lat);
                    theta = THREE.Math.degToRad(lon);
                    camera.position.x = 100 * Math.sin(phi) * Math.cos(theta);
                    camera.position.y = 100 * Math.cos(phi);
                    camera.position.z = 100 * Math.sin(phi) * Math.sin(theta);
                    camera.lookAt(scene.position);
                    renderer.render(scene, camera);
                }






                function locationHash() {
                    return parseInt(window.location.hash.replace('#', ''));
                }

                function panoramaCaruserl() {
                    if (autoScrol === false) {
                        isUserInteracting = true;
                    }
                    $('#elipse_key').click(function () {
                        if (isUserInteracting === false) {
                            isUserInteracting = true;
                        } else {
                            isUserInteracting = false;
                        }
                        render();
                    });
                }

                function buttonControl() {

                    $('#right_key').on('mousedown touchstart', onKeyRight);
                    $('#left_key').on('mousedown touchstart', onKeyLeft);
                    $('#down_key').on('mousedown touchstart', onKeyDown);
                    $('#up_key').on('mousedown touchstart', onKeyUp);

                    $('#right_key').mousehold(function () {
                        onRightHold();
                    });
                    $('#left_key').mousehold(function () {
                        onLeftHold();
                    });

                    $('#down_key').mousehold(function () {
                        onDownHold();
                    });

                    $('#up_key').mousehold(function () {
                        onUpHold();
                    });
                }

                function onRightHold() {

                    var counter = 0;
                    var tt = setInterval(function () {
                        startTime()
                    }, 10);

                    function startTime() {
                        lon += 0.25;
                        if (counter == 40) {
                            clearInterval(tt);
                        } else {
                            counter++;
                        }
                    }

                }

                function onLeftHold() {
                    var counter = 0;
                    var tt = setInterval(function () {
                        startTime()
                    }, 10);

                    function startTime() {
                        lon -= 0.25;
                        if (counter == 40) {
                            clearInterval(tt);
                        } else {
                            counter++;
                        }
                    }
                }

                function onUpHold() {
                    var counter = 0;
                    var tt = setInterval(function () {
                        startTime()
                    }, 10);

                    function startTime() {
                        lat -= 0.25;
                        if (counter == 40) {
                            clearInterval(tt);
                        } else {
                            counter++;
                        }
                    }
                }

                function onDownHold() {
                    var counter = 0;
                    var tt = setInterval(function () {
                        startTime()
                    }, 10);

                    function startTime() {
                        lat += 0.25;
                        if (counter == 40) {
                            clearInterval(tt);
                        } else {
                            counter++;
                        }
                    }
                }

                function buttonZoom() {
                    $('#zoom_in').on('mousedown touchstart', zoomIn);
                    $('#zoom_out').on('mousedown touchstart', zoomOut);
                }



                function zoomIn() {
                    var counter = 0;
                    var tt = setInterval(function () {
                        startTime()
                    }, 10);

                    function startTime() {
                        if (fov < 45 || fov > 90) {
                            fov = (fov < 45) ? 45 : 90;
                        }

                        fov -= 0.25;
                        updateProjection();
                        if (counter == 40) {
                            clearInterval(tt);
                        } else {
                            counter++;
                        }
                    }

                }

                function zoomOut() {
                    var counter = 0;
                    var tt = setInterval(function () {
                        startTime()
                    }, 10);

                    function startTime() {
                        if (fov < 45 || fov > 90) {
                            fov = (fov < 45) ? 45 : 90;
                        }
                        fov += 0.25;
                        updateProjection();
                        if (counter == 40) {
                            clearInterval(tt);
                        } else {
                            counter++;
                        }
                    }

                }

                function fullscreenPanorama() {
                    $('#fullscreenPan').bind('touchstart click', function () {
                        console.log('SOURCE URL :' + sourceUrl);
                        $('#fullscreen-icon').attr("src", sourceUrl + "img/fullscreen.png");
                        if ($(document).fullScreen() == false) {
                            $('#panorama').fullScreen(true);
                            fullscreenMode = true;
                            $('#fullScreenMode').addClass('now-full-screen');
                            $('#fullscreen-icon').attr("src", sourceUrl + "/img/leaveFullScreen.png");
                        } else {
                            $('#panorama').fullScreen(false);
                            fullscreenMode = false;
                            $('#fullScreenMode').removeClass('now-full-screen');
                        }
                    });

                }

                setInterval(function () {
                    if ($(document).fullScreen() == false) {
                        $('#panorama').fullScreen(false);
                        fullscreenMode = false;
                        $('#fullscreen-icon').attr("src", sourceUrl + "/img/fullscreen.png");
                        $('#fullScreenMode').removeClass('now-full-screen');
                    }
                }, 3000);

                setInterval(function () {

                    if ($("#pan-canvas").find('canvas').length > 1) {
                        $('#pan-canvas').children('canvas:first').remove();
                        $('#loader-pan').hide();
                        clickedMenu = true;
                        cleanMemory();
                    } else {
                        // 
                    }
                }, 500);

                function leaveFullScreen() {
                    $('#panorama').fullScreen(false);
                    fullscreenMode = false;
                }

                function playMusic() {
                    $('#pButton').click(function () {
                        if (music.paused) {
                            music.play();
                            // remove play, add pause
                            pButton.className = "";
                            pButton.className = "fa fa-volume-up";
                        } else { // pause music
                            music.pause();
                            // remove pause, add play
                            pButton.className = "";
                            pButton.className = "fa fa-volume-off";
                        }
                    });
                }


                function fullPagePanorama() {
                    $('#pan-canvas').css('height', windowHeight + 'px');

                }

                function resizeFullPage() {
                    $('#pan-canvas').css('height', $(document).height() + 'px');
                }

                function panSlideSwipeFunction() {
                    $('#panos-list').on('swipe', function () {
                        $(".owl-carousel").data('owlCarousel').init({
                            touchDrag: true
                        });
                        touchMove = false;
                    });

                    $('#pan-canvas').on('touchmove', function () {
                        $(".owl-carousel").data('owlCarousel').reinit({
                            touchDrag: false
                        });

                        touchMove = true;
                    });
                }

                function owlCarousel(event) {
                    var owl = $(".owl-carousel");
                    owl.owlCarousel({
                        margin: 0,
                        responsive: true,
                        itemsCustom: [
                            [0, 2],
                            [450, 2],
                            [600, 4],
                            [700, 6],
                            [1000, 8],
                            [1200, 8],
                            [1400, 10],
                            [1600, 10]
                        ],
                        autoWidth: true,
                        loop: true,
                        URLhashListener: true,
                        startPosition: 'URLHash',
                        items: 8

                    });
                }

                function getPanDescription() {

                }

                function changePanImage() {
                    $('.pan-menu').on('click doubleTap', function (e) {
                        if (clickedMenu) {
                            clickedMenu = false;
                            window.location.hash = textureNum;
                            oldPan = textureNum;
                            textureNum = $(this).attr('data-pan-id');
                            $('.pan-description').html($(this).attr('data-pan-desc'));
                            $('.pan-menu').removeClass('hover-effect');
                            $(this).addClass('hover-effect');
                            $('#loader-pan').show();
                            panoramaImage = $(this).find('a').attr('data-pan-href');
                            texture[textureNum] = THREE.ImageUtils.loadTexture(panoramaImage, new THREE.UVMapping(), function () {
                                init();
                            });
                        }
                    });
                }

                function loadingOverlay() {
                    setInterval(function () {
                        if ($("#pan-canvas").find('canvas').length == 1) {
                            $('body').addClass('loaded');
                            $('#panos-list').addClass('animated fadeInDown');
                        }
                    }, 1000);
                    $('body').removeClass('loaded');
                }

                function hideMenu() {
                    function hide() {
                        if ($("#panos-list").css('bottom') == '0px') {
                            $("#panos-list").animate({
                                bottom: '-' + ($('#panos-list').height()) + 'px'
                            }, 300);
                            $('.menu-button').removeClass('fa-chevron-down');
                            $('.menu-button').addClass('fa-chevron-up');
                        } else {
                            show();
                        }
                    }

                    function show() {
                        $("#panos-list").animate({
                            bottom: '0px'
                        }, 300);
                        $('.menu-button').removeClass('fa-chevron-up');
                        $('.menu-button').addClass('fa-chevron-down');
                    }

                    $('#panos-list').on('swipe', function (e, Dx, Dy) {
                        if (Dy < 0) {
                            hide();
                        }
                        if (Dy > 0) {
                            show();
                        }
                    });
                    var degree = '180deg'
                    $('.menu-button').on('click touchstart', function () {
                        hide();
                    });
                }

                function hideFullscreenOnIos() {
                    if (getMobileOperatingSystem() == 'iOS') {
                        $('#fullScreenMode').hide();
                    }
                }


                function getMobileOperatingSystem() {

                    var userAgent = navigator.userAgent || navigator.vendor || window.opera;

                    if (userAgent.match(/iPad/i) || userAgent.match(/iPhone/i) || userAgent.match(/iPod/i)) {
                        return 'iOS';

                    } else if (userAgent.match(/Android/i)) {

                        return 'Android';
                    } else {
                        return 'unknown';
                    }
                }
            });
            </script>  
        </div>
        <input id="source-url" type="hidden" value="css/360">
    </body>
</html>