<style>
    .selectize-input.focus2 {
        border-color: #597ea2;
        outline: 0;
        /* -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, 0.6); */
        /* box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, 0.6); */
        box-shadow: 0 0 0 0 transparent !important;
    }
    .navbar.navbar-expand-lg{
        /*padding: 4px 4px 4px 4px !important;*/
        padding: 2px 2px 2px 2px !important;
    }
</style>
<script>
    var valido = false;
    var base_url = "<?php print base_url(); ?>";
    var isMobile = false;
    var seg = <?php print (isset($_SESSION["SEG"]) ? $_SESSION["SEG"] : 0); ?>;
    var iframe_opts = {
        // Iframe template
        tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
        preload: true,
        // Custom CSS styling for iframe wrapping element
        // You can use this to set custom iframe dimensions
        css: {
            width: "100%",
            height: "100%"
        },
        // Iframe tag attributes
        attr: {
            scrolling: "auto"
        }
    };
    
    $(document).ready(function () {
        $('html').find('input.date:not(.notEnter)').addClass('notEnter');
        $('html').find('input:not(.form-control-sm)').addClass('form-control-sm');
        $('html').find('select:not(.form-control-sm)').addClass('form-control-sm');
        $('html').find('button:not(.btn-sm)').addClass('btn-sm');
    });
    
    function onOpenWindow(url) {
        onBeep(1);
        $.fancybox.open({
            src: url,
            type: 'iframe',
            opts: {
                iframe: iframe_opts
            }
        });
    }
    function onOpenWindowAFC(url, doafterClose) {
        onBeep(1);
        $.fancybox.open({
            src: url,
            type: 'iframe',
            opts: {
                afterClose: doafterClose,
                iframe: iframe_opts
            }
        });
    }
    function onImprimirReporteFancy(url) {
        $.fancybox.open({
            closeExisting: true,
            smallBtn: true,
            src: '<?php print base_url(); ?>js/pdf.js-gh-pages/web/viewer.php?file=' + url + '#pagemode=thumbs',
            type: 'iframe',
            opts: {
                afterClose: function (instance, current) {
                },
                iframe: iframe_opts
            }
        });
    }
    function onImprimirReporteFancyAFC(url, doafterClose) {
        $.fancybox.open({
            closeExisting: true,
            smallBtn: true,
            src: '<?php print base_url(); ?>js/pdf.js-gh-pages/web/viewer.php?file=' + url + '#pagemode=thumbs',
            type: 'iframe',
            opts: {
                afterClose: doafterClose,
                iframe: iframe_opts
            }
        });
    }

    function onImprimirReporteFancyArray(urls) {
        console.log(urls);
        var files = [];
        $.each(urls, function (k, v) {
            files.push({
                toolbar: false,
                smallBtn: true,
                src: '<?php print base_url(); ?>js/pdf.js-gh-pages/web/viewer.php?file=' + v + '#pagemode=thumbs',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {

                    },
                    iframe: iframe_opts
                }
            });
        });
        $.fancybox.open(files);
    }


    function onImprimirReporteFancyArrayAFC(urls, doafterClose) {
        console.log(urls);
        var files = [];
        $.each(urls, function (k, v) {
            files.push({
                toolbar: false,
                smallBtn: true,
                src: '<?php print base_url(); ?>js/pdf.js-gh-pages/web/viewer.php?file=' + v + '#pagemode=thumbs',
                type: 'iframe',
                opts: {
                    afterClose: doafterClose,
                    iframe: iframe_opts
                }
            });
        });
        $.fancybox.open(files);
    }

    function mobilecheck() {
        (function (a) {
            if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4)))
                isMobile = true;
        })(navigator.userAgent || navigator.vendor || window.opera);
        return isMobile;
    }





    shortcut.add("F5", function () {
        location.reload();
    });


    //Para desactivar la validacion del selectize
    $('html').not(':focus').click(function () {
        validaSelect = false;
        $(this).blur();
    });
    shortcut.add("ESC", function () {
        validaSelect = false;
        $('body').blur();
    });




    var validaSelect = false;
    //Verifica que el select tenga un valor valido
    function verificarValorSelect(id, div) {

        div.find('.selectize-control').find('input' + id + '-selectized').on('keyup', function (e) {
            if (e.keyCode === 27) {
                validaSelect = false;
            } else {
                validaSelect = true;
            }
        });

        div.find('.selectize-control').find('input' + id + '-selectized').on('blur', function () {
            if (validaSelect) {
                var select_actual = div.find(id)[0].selectize.getValue();

                if (select_actual === '') {
                    $(this).focus();
                } else {
                    validaSelect = false;
                }
            }
        });
    }
    //Se pasa el pnl o div que contendra los select a validar
    function validacionSelectPorContenedor(contenedor) {
        $.each(contenedor.find("select"), function (k, v) {
            verificarValorSelect('#' + $(v).attr('id'), contenedor);
        });
    }
    var idDestinoG = '';
    var idOrigenG = '';
    var paramsG;
    //Establece el foco de un select a otro select cuando no tiene el evento change definido
    function setFocusSelectToSelectOnChange(id, idDestino, div) {
        //paramsG = params;
        div.find(id).change(function () {
            div.find(idDestino)[0].selectize.focus();
            validaSelect = false;
        });

    }
    //Establece el foco de un select a un input

    function setFocusSelectToInputOnChange(id, idDestino, div) {
        div.find(id).change(function () {
            div.find(idDestino).focus();
            validaSelect = false;
        });

    }

    /**
     * Convert an image
     * to a base64 url
     * @param  {String}   url
     * @param  {Function} callback
     * @param  {String}   [outputFormat=image/png]
     */
    function convertImgToBase64URL(url, callback, outputFormat) {
        var img = new Image();
        img.crossOrigin = 'Anonymous';
        img.onload = function () {
            var canvas = document.createElement('CANVAS'),
                    ctx = canvas.getContext('2d'), dataURL;
            canvas.height = img.height;
            canvas.width = img.width;
            ctx.drawImage(img, 0, 0);
            dataURL = canvas.toDataURL(outputFormat);
            callback(dataURL);
            canvas = null;
        };
        img.src = url;
    }

    function padLeft(nr, n, str) {
        return Array(n - String(nr).length + 1).join(str || '0') + nr;
    }

//examples
//    console.log(padLeft(23, 5));       //=> '00023'
//    console.log((23).padLeft(5));     //=> '00023'
//    console.log((23).padLeft(5, ' ')); //=> '   23'
//    console.log(padLeft(23, 5, '>>'));  //=> '>>>>>>23'

    function formatDateDB(inputDate) {
        var splitDate = inputDate.split('-');
        if (splitDate.count == 0) {
            return null;
        }

        var year = splitDate[0];
        var month = splitDate[1];
        var day = splitDate[2];

        return day + '/' + month + '/' + year;
    }


    $(function () {




        $.fn.dataTable.moment('DD/MM/YYYY');
        moment.locale('es');
        $.fn.dataTable.moment('L', 'es');



        $('.modal-dialog:not(.notdraggable)').draggable();
        $('.modal-content').resizable({
            minHeight: 300,
            minWidth: 450
        });

        mobilecheck();
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
        $('.numbersOnly').keypress(function (event) {
            var charCode = (event.which) ? event.which : event.keyCode;
            if (
                    (charCode !== 45 || $(this).val().indexOf('-') !== -1) && // “-” CHECK MINUS, AND ONLY ONE.
                    (charCode !== 46 || $(this).val().indexOf('.') !== -1) && // “.” CHECK DOT, AND ONLY ONE.
                    (charCode < 48 || charCode > 57))
                return false;

            return true;
        });

        $('.numeric').keypress(function (event) {
            var cc = (event.which) ? event.which : event.keyCode;
            if (cc >= 48 && cc <= 57 || cc === 8 || cc >= 36 && cc <= 40) {
                return true;
            } else {
                return false;
            }
        });

        $('.numericdot').keypress(function (event) {
            var cc = (event.which) ? event.which : event.keyCode;
            if (cc >= 48 && cc <= 57 || cc === 46 || cc === 8 || cc >= 36 && cc <= 40 || $(this).val().indexOf('.') === -1) {
                return true;
            } else {
                return false;
            }
        });

        $("select").not('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false,
            score: function (search)
            {
                return function (option)
                {
                    if (option.text.indexOf(search) === 0)
                    {
                        return 1;
                    } else if (option.text.indexOf(search) >= 3)
                    {
                        return 1;
                    }
                    return 0;
                };
            }
        });

        $('.modal').on('shown.bs.modal', function (e) {
            $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
        });

        $(".date").inputmask({alias: "date"});

        $('.money').maskMoney({prefix: '$', allowNegative: false, thousands: ',', decimal: '.', affixesStay: false});

        $('.decimal').inputmask({mask: ".99"});

        $('[data-provide="datepicker"]').inputmask({alias: "date"});
        $('[data-provide="datepicker"]').addClass("notEnter");
        $('[data-provide="datepicker"]').val();


        $('[data-provide="timepicker"]').inputmask("hh:mm:ss", {
            hourFormat: "24",
            placeholder: "HH:MM:SS",
            insertMode: false,
            showMaskOnHover: false

        }
        );

    });
    function onNotify(span, message, type) {
        swal((type === 'danger') ? 'ERROR' : 'ATENCIÓN', message, (type === 'danger') ? 'warning' : 'info');
    }
    function onNotifyOld(icon, message, type) {
        $.notify({
            icon: icon,
            message: message
        }, {
            type: type,
            z_index: 3031,
            delay: 4000,
            placement: {
                from: "bottom",
                align: "left"
            },
            animate: {
                enter: 'animated fadeInRight',
                exit: 'animated fadeOutRight'
            }
        });
    }
    function onNotifyOldPC(icon, message, type, placement_config) {
        $.notify({
            icon: icon,
            message: message
        }, {
            type: type,
            z_index: 3031,
            delay: 15000,
            newest_on_top: true,
            showProgressbar: false,
            placement: placement_config,
            animate: {
                enter: 'animated bounceIn',
                exit: 'animated fadeOutUp'
            }
        });
    }
    function isValid(p) {
        var inputs = $('#' + p).find("input.form-control:required").length;
        var inputs_textarea = $('#' + p).find("textarea.form-control:required").length;
        var selects = $('#' + p).find("select.required").length;
        var valid_inputs = 0;
        var valid_inputs_textarea = 0;
        var valid_selects = 0;
        $.each($('#' + p).find("input.form-control:required"), function () {
            var e = $(this).parent().find("small.text-danger");
            if ($(this).val() === '' && e.length === 0) {
                $(this).parent().find("label").after("<small class=\"text-danger\"> Este campo es obligatorio</small>");
                $(this).css("border", "1px solid #d01010");
                valido = false;
            } else {
                if ($(this).val() !== '') {
                    $(this).css("border", "1px solid #9E9E9E");
                    $(this).parent().find("small.text-danger").remove();
                    valid_inputs += 1;
                }
            }
        });
        $.each($('#' + p).find("textarea.form-control:required"), function () {
            var e = $(this).parent().find("small.text-danger");
            if ($(this).val() === '' && e.length === 0) {
                $(this).parent().find("label").after("<small class=\"text-danger\"> Este campo es obligatorio</small>");
                $(this).css("border", "1px solid #d01010");
                valido = false;
            } else {
                if ($(this).val() !== '') {
                    $(this).css("border", "1px solid #9E9E9E");
                    $(this).parent().find("small.text-danger").remove();
                    valid_inputs_textarea += 1;
                }
            }
        });
        $.each($('#' + p).find("select.required"), function () {
            var e = $(this).parent().find("small.text-danger");
            if ($(this).val() === '' && e.length === 0) {
                $(this).after("<small class=\"text-danger\"> Este campo es obligatorio</small>");
                $(this).parent().find(".selectize-input").css("border", "1px solid #d01010");
                valido = false;
            } else {
                if ($(this).val() !== '') {
                    $(this).parent().find(".selectize-input").css("border", "1px solid #9E9E9E");
                    $(this).parent().find("small.text-danger").remove();
                    valid_selects += 1;
                }
            }
        });
        if (valid_inputs === inputs && valid_selects === selects && valid_inputs_textarea === inputs_textarea) {
            valido = true;
        }
    }

    var lang = {
        processing: "Cargando datos...",
        search: "Buscar:",
        lengthMenu: "Mostrar _MENU_ Elementos",
        info: "Mostrando  _START_ de _END_ , de _TOTAL_ Elementos.",
        infoEmpty: "Mostrando 0 de 0 A 0 Elementos.",
        infoFiltered: "(Filtrando un total _MAX_ Elementos. )",
        infoPostFix: "",
        loadingRecords: "Procesando los datos...",
        zeroRecords: "No se encontro nada.",
        emptyTable: "No existen datos en la tabla.",
        paginate: {
            first: "Primero",
            previous: "Anterior",
            next: "Siguiente",
            last: "&Uacute;ltimo"
        },
        aria: {
            sortAscending: ": Habilitado para ordenar la columna en orden ascendente",
            sortDescending: ": Habilitado para ordenar la columna en orden descendente"
        },
        buttons: {
            copyTitle: 'Registros copiados a portapapeles',
            copyKeys: 'Copiado con teclas clave.',
            copySuccess: {
                _: ' %d Registros copiados',
                1: ' 1 Registro copiado'
            }
        }
    };



    var logo = '';
    convertImgToBase64URL(base_url + '/img/lsbck.png', function (base64Img) {
        logo = base64Img;
    });

    var buttons = [
        {
            extend: 'excelHtml5',
            text: ' <i class="fa fa-file-excel"></i>',
            titleAttr: 'Excel',
            className: 'selectNotEnter',
            exportOptions: {
                columns: ':visible'
            }
        }
        ,
        {
            extend: 'colvis',
            text: '<i class="fa fa-columns"></i>',
            titleAttr: 'Seleccionar Columnas',
            className: 'selectNotEnter',
            exportOptions: {
                modifier: {
                    page: 'current'
                },
                columns: ':visible'
            }
        },
        {

            exportOptions: {
                columns: ':visible',
                search: 'applied',
                order: 'applied'
            },
            className: 'selectNotEnter',
            extend: 'pdfHtml5',
            filename: 'Reporte del sistema',
            orientation: 'landscape', //portrait
            pageSize: 'letter', //A3 , A5 , A6 , legal , letter
            text: '<i class="fa fa-file-pdf"></i>',
            titleAttr: 'PDF',
            customize: function (doc) {

                var now = new Date();
                var jsDate = now.getDate() + '/' + (now.getMonth() + 1) + '/' + now.getFullYear();
                //Remove the title created by datatTables
                doc.content.splice(0, 1);
                // Set page margins [left,top,right,bottom] or [horizontal,vertical]
                // Dejar espacio para el header y el footer !!!
                //Margenes para el contenido (solo tabla)
                doc.pageMargins = [15, 50, 15, 30];
                // Set the font size fot the entire document
                doc.defaultStyle.fontSize = 6.5;
                // Set the fontsize for the table header
                doc.styles.tableHeader.fontSize = 7.5;
                doc['header'] = (function () {
                    return {
                        columns: [
                            {
                                image: logo,
                                width: 74
                            },
                            {
                                alignment: 'left',
                                bold: true,
                                //italics: true,
                                text: "CALZADO LOBO SA DE CV " + "\nReporte generado desde el sistema ",
                                fontSize: 9,
                                //Margen para esta columna solamente
                                margin: [10, 0]
                            },
                            {
                                alignment: 'right',
                                fontSize: 7.5,
                                text: ['Fecha: ', {text: jsDate.toString()}]
                            }
                        ],
                        //Margen general del header
                        margin: 10
                    };
                });
                // Create a footer object with 2 columns
                // Left side: report creation date
                // Right side: current page and total pages
                doc['footer'] = (function (page, pages) {
                    return {
                        columns: [
                            {
                                fontSize: 7.5,
                                alignment: 'right',
                                text: ['Página ', {text: page.toString()}, ' de ', {text: pages.toString()}]
                            }
                        ],
                        margin: 10
                    };
                });
                // Change dataTable layout (Table styling)
                // To use predefined layouts uncomment the line below and comment the custom lines below
                // doc.content[0].layout = 'lightHorizontalLines'; // noBorders , headerLineOnly

                doc['styles'] = {
                    header: {
                        fontSize: 7,
                        bold: true,
                        margin: [0, 0, 0, 10]
                    },
                    tableHeader: {
                        bold: true,
                        fontSize: 7,
                        color: 'black'
                    }
                };


                var objLayout = {};
                objLayout['hLineWidth'] = function (i, node) {
                    if (i === 0 || i === node.table.body.length) {
                        return 0;
                    }
                    return (i === node.table.headerRows) ? 1 : 0.5;
                };
                objLayout['vLineWidth'] = function (i, node) {
                    return 0;
                };
                objLayout['hLineColor'] = function (i, node) {
                    return i === 1 ? 'black' : 'black';
                };
                objLayout['vLineColor'] = function (i, node) {
                    return 'black';
                };
                objLayout['paddingLeft'] = function (i, node) {
                    return i === 0 ? 0 : 8;
                };
                objLayout['paddingRight'] = function (i, node) {
                    return (i === node.table.widths.length - 1) ? 0 : 8;
                };
                doc.content[0].layout = objLayout;
//                doc.content[0].layout = 'lightHorizontalLines';

            }
        }

    ];
    /*******************************************************************************
     * VAR FOR TEMPORAL DATA
     *******************************************************************************/
    var temp = 0;
    /*******************************************************************************
     * EVENT FOR CLICK ROW
     *******************************************************************************/
    var selected = [];
    /*******************************************************************************
     * OPTIONS FOR TABLES
     *******************************************************************************/
    var tableOptions = {
        "dom": 'Bfrtip',
        buttons: buttons,
        language: {
            processing: "Proceso en curso...",
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ Elementos",
            info: "Mostrando  _START_ de _END_ , de _TOTAL_ Elementos.",
            infoEmpty: "Mostrando 0 de 0 A 0 Elementos.",
            infoFiltered: "(Filtrando un total _MAX_ Elementos. )",
            infoPostFix: "",
            loadingRecords: "Procesando los datos...",
            zeroRecords: "No se encontro nada.",
            emptyTable: "No existen datos en la tabla.",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "&Uacute;ltimo"
            },
            aria: {
                sortAscending: ": Habilitado para ordenar la columna en orden ascendente",
                sortDescending: ": Habilitado para ordenar la columna en orden descendente"
            },
            buttons: {
                copyTitle: 'Registros copiados a portapapeles',
                copyKeys: 'Copiado con teclas clave.',
                copySuccess: {
                    _: ' %d Registros copiados',
                    1: ' 1 Registro copiado'
                }
            }
        },
        "autoWidth": true,
        "colReorder": true,
        "displayLength": 12,
        "bStateSave": true,
        "bLengthChange": false,
        "deferRender": true,
        "scrollY": false,
        "scrollX": true,
        "scrollCollapse": false,
        "aaSorting": [
            [0, 'desc']
        ]
                //    ,
                //    "columnDefs": [
                //        {"width": "20%", "targets": [0]}
                //    ]
    };

    function yearValidation(year, ev, Input) {


        var text = /^[0-9]+$/;
        if (ev.type == "blur" || year.length == 4 && ev.keyCode != 8 && ev.keyCode != 46) {
            if (year != 0) {
                if ((year != "") && (!text.test(year))) {
                    $(Input).val('');
                    //alert("Please Enter Numeric Values Only");
                    return false;
                }

                if (year.length != 4) {
                    $(Input).val('');
                    // alert("Year is not proper. Please check");
                    return false;
                }
                var current_year = new Date().getFullYear();
                if ((year < 2000) || (year > current_year))
                {
                    $(Input).val('');
                    // alert("Year should be in range 1920 to current year");
                    return false;
                }
                return true;
            }
        }
    }

    function getFirstDayMonth() {
        var date = new Date();

        var date = new Date(date.getFullYear(), date.getMonth(), 1);
        var iday = date.getDate();
        var imonth = date.getMonth() + 1;
        var iyear = date.getFullYear();

        if (imonth < 10)
            imonth = "0" + imonth;
        if (iday < 10)
            iday = "0" + iday;
        var ini = iday + "-" + imonth + "-" + iyear;
        return ini;
    }

    function getLastDayMonth() {
        var date = new Date();

        var ldate = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        var fday = ldate.getDate();
        var fmonth = ldate.getMonth() + 1;
        var fyear = ldate.getFullYear();

        if (fmonth < 10)
            fmonth = "0" + fmonth;
        if (fday < 10)
            fday = "0" + fday;
        var fin = fday + "-" + fmonth + "-" + fyear;
        return fin;
    }


    function getToday() {
        var date = new Date();

        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();

        if (month < 10)
            month = "0" + month;
        if (day < 10)
            day = "0" + day;

        var today = day + "-" + month + "-" + year;
        return today;
    }

    function getYear() {
        var date = new Date();
        var year = date.getFullYear();
        return year;
    }
    function getTodayWithTime() {
        var date = new Date();

        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();

        if (month < 10)
            month = "0" + month;
        if (day < 10)
            day = "0" + day;

        var today = day + "-" + month + "-" + year;

        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        var strTime = hours + ':' + minutes + ':' + seconds + ' ' + ampm;

        return today + ' ' + strTime;
    }

    function getFechaActualConDiagonales() {
        var date = new Date();

        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();

        if (month < 10)
            month = "0" + month;
        if (day < 10)
            day = "0" + day;

        var today = day + "/" + month + "/" + year;
        return today;
    }


    function getTable(tblname, data) {
        var column = '';
        var i = 0;
        var div = "<div class=\" \">";
        div = "<table id=\"" + tblname + "\" class=\" table table-sm  \"  width=\"100%\">";
        //Create header
        div += "<thead>";
        div += "<tr class=\"\" >";
        for (var key in data[i]) {
            column += "<th>" + key + "</th>";
        }
        div += column;
        div += "</tr></thead>";
        //Create Rows
        div += "<tbody>";
        $.each(data, function (key, value) {
            div += "<tr data-toggle='tooltip' title='Haga clic para editar' >";
            $.each(value, function (key, value) {
                div += "<td>" + value + "</td>";
            });
            div += "</tr>";
        });
        div += "</tbody>";
        //Create Footer
        div += "<tfoot>";
        div += "<tr class=\"\">";
        div += column;
        div += "</tr></tfoot>";
        div += "</table>";
        div += "</div>";
        return div;
    }

    function getTableConceptosTrabajos(tblname, data) {
        var column = '';
        var i = 0;
        var div = "<div class=\" \">";
        div = "<table id=\"" + tblname + "\" class=\"table table-striped table-hover \"  width=\"100%\">";
        //Create header
        div += "<thead>";
        div += "<tr class=\"\" >";
        for (var key in data[i]) {
            column += "<th>" + key + "</th>";
        }
        div += column;
        div += "</tr></thead>";
        //Create Rows
        div += "<tbody>";
        $.each(data, function (key, value) {
            div += "<tr data-toggle='tooltip' title='Haga clic para editar' >";
            $.each(value, function (key, value) {
                div += "<td>" + value + "</td>";
            });
            div += "</tr>";
        });
        div += "</tbody>";
        //Create Footer
        div += "<tfoot>";
        div += "<tr class=\"\">";
        div += column;
        div += "</tr></tfoot>";
        div += "</table>";
        div += "</div>";
        return div;
    }

    function getExt(filename) {
        var dot_pos = filename.lastIndexOf(".");
        if (dot_pos === -1)
            return "";
        return filename.substr(dot_pos + 1).toLowerCase();
    }


    $('input:not(.notEnter)').keyup(function () {
        $(this).val($(this).val().toUpperCase());
    });


    function handleEnterDiv(divParent) {
        $('input:not(.notEnter)').keyup(function () {
            $(this).val($(this).val().toUpperCase());
        });


        divParent.on('keydown', 'input, select, textarea:not(.notEnter)', function (e) {
            var self = $(this)
                    , form = self.parents('body')
                    , focusable
                    , next
                    ;
            if (e.keyCode === 13) {
                focusable = form.find('input,a,select,button,textarea')
                        .filter(':visible:enabled')
                        .not('.disabledForms').not('.selectNotEnter').not(':input[readonly]');
                next = focusable.eq(focusable.index(this) + 1);
                if (next.length) {
                    next.focus();
                    next.select();
                }
                return false;
            }
            if (e.keyCode === 9) {
                focusable = form.find('input,a,select,button,textarea').filter(':visible:enabled')
                        .not('.disabledForms').not('.selectNotEnter').not(':input[readonly]');
                next = focusable.eq(focusable.index(this) + 1);
                if (next.length) {
                    next.focus();
                    next.select();
                }
                return false;
            }
        });
    }


    function handleEnter() {

        $('input:not(.notEnter)').keyup(function () {
            $(this).val($(this).val().toUpperCase());
        });

        $('body').on('keydown', 'input, select, textarea:not(.notEnter)', function (e) {
            var self = $(this)
                    , form = self.parents('body')
                    , focusable
                    , next
                    ;
            if (e.keyCode === 13) {
                focusable = form.find('input,a,select,button,textarea')
                        .filter(':visible:enabled')
                        .not('.disabledForms').not('.selectNotEnter').not(':input[readonly]');
                next = focusable.eq(focusable.index(this) + 1);
                if (next.length) {
                    next.focus();
                    next.select();
                }
                return false;
            }
            if (e.keyCode === 9) {
                focusable = form.find('input,a,select,button,textarea').filter(':visible:enabled')
                        .not('.disabledForms').not('.selectNotEnter').not(':input[readonly]');
                next = focusable.eq(focusable.index(this) + 1);
                if (next.length) {
                    next.focus();
                    next.select();
                }
                return false;
            }
        });
    }

    function getNumber(x) {
        return x.replace(/\s+/g, '').replace(/,/g, "").replace("$", "");
    }

    function getNumberFloat(x) {
        return parseFloat(x.replace(/\s+/g, '').replace(/,/g, "").replace("$", ""));
    }

    //Función para validar un RFC
    function rfcValido(rfc, aceptarGenerico = true) {
        const re = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
        var validado = rfc.match(re);

        if (!validado)  //Coincide con el formato general del regex?
            return false;

        //Separar el dígito verificador del resto del RFC
        const digitoVerificador = validado.pop(),
                rfcSinDigito = validado.slice(1).join(''),
                len = rfcSinDigito.length,
                //Obtener el digito esperado
                diccionario = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
                indice = len + 1;
        var suma,
                digitoEsperado;

        if (len == 12)
            suma = 0
        else
            suma = 481; //Ajuste para persona moral

        for (var i = 0; i < len; i++)
            suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
        digitoEsperado = 11 - suma % 11;
        if (digitoEsperado == 11)
            digitoEsperado = 0;
        else if (digitoEsperado == 10)
            digitoEsperado = "A";

        //El dígito verificador coincide con el esperado?
        // o es un RFC Genérico (ventas a público general)?
        if ((digitoVerificador != digitoEsperado)
                && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
            return false;
        else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
            return false;
        return rfcSinDigito + digitoVerificador;
    }

    function Unidades(num) {

        switch (num)
        {
            case 1:
                return "UN";
            case 2:
                return "DOS";
            case 3:
                return "TRES";
            case 4:
                return "CUATRO";
            case 5:
                return "CINCO";
            case 6:
                return "SEIS";
            case 7:
                return "SIETE";
            case 8:
                return "OCHO";
            case 9:
                return "NUEVE";
        }

        return "";
    }

    function Decenas(num) {

        decena = Math.floor(num / 10);
        unidad = num - (decena * 10);

        switch (decena)
        {
            case 1:
            switch (unidad)
            {
                case 0:
                    return "DIEZ";
                case 1:
                    return "ONCE";
                case 2:
                    return "DOCE";
                case 3:
                    return "TRECE";
                case 4:
                    return "CATORCE";
                case 5:
                    return "QUINCE";
                default:
                    return "DIECI" + Unidades(unidad);
            }
            case 2:
            switch (unidad)
            {
                case 0:
                    return "VEINTE";
                default:
                    return "VEINTI" + Unidades(unidad);
            }
            case 3:
                return DecenasY("TREINTA", unidad);
            case 4:
                return DecenasY("CUARENTA", unidad);
            case 5:
                return DecenasY("CINCUENTA", unidad);
            case 6:
                return DecenasY("SESENTA", unidad);
            case 7:
                return DecenasY("SETENTA", unidad);
            case 8:
                return DecenasY("OCHENTA", unidad);
            case 9:
                return DecenasY("NOVENTA", unidad);
            case 0:
                return Unidades(unidad);
        }
    }//Unidades()

    function DecenasY(strSin, numUnidades) {
        if (numUnidades > 0)
            return strSin + " Y " + Unidades(numUnidades)

        return strSin;
    }//DecenasY()

    function Centenas(num) {

        centenas = Math.floor(num / 100);
        decenas = num - (centenas * 100);

        switch (centenas)
        {
            case 1:
                if (decenas > 0)
                    return "CIENTO " + Decenas(decenas);
                return "CIEN";
            case 2:
                return "DOSCIENTOS " + Decenas(decenas);
            case 3:
                return "TRESCIENTOS " + Decenas(decenas);
            case 4:
                return "CUATROCIENTOS " + Decenas(decenas);
            case 5:
                return "QUINIENTOS " + Decenas(decenas);
            case 6:
                return "SEISCIENTOS " + Decenas(decenas);
            case 7:
                return "SETECIENTOS " + Decenas(decenas);
            case 8:
                return "OCHOCIENTOS " + Decenas(decenas);
            case 9:
                return "NOVECIENTOS " + Decenas(decenas);
        }

        return Decenas(decenas);
    }//Centenas()

    function Seccion(num, divisor, strSingular, strPlural) {
        cientos = Math.floor(num / divisor)
        resto = num - (cientos * divisor)

        letras = "";

        if (cientos > 0)
            if (cientos > 1)
                letras = Centenas(cientos) + " " + strPlural;
            else
                letras = strSingular;

        if (resto > 0)
            letras += "";

        return letras;
    }//Seccion()

    function Miles(num) {
        divisor = 1000;
        cientos = Math.floor(num / divisor)
        resto = num - (cientos * divisor)

        strMiles = Seccion(num, divisor, "UN MIL", "MIL");
        strCentenas = Centenas(resto);

        if (strMiles == "")
            return strCentenas;

        return strMiles + " " + strCentenas;

        //return Seccion(num, divisor, "UN MIL", "MIL") + " " + Centenas(resto);
    }//Miles()

    function Millones(num) {
        divisor = 1000000;
        cientos = Math.floor(num / divisor)
        resto = num - (cientos * divisor)

        strMillones = Seccion(num, divisor, "UN MILLON", "MILLONES");
        strMiles = Miles(resto);

        if (strMillones == "")
            return strMiles;

        return strMillones + " " + strMiles;

        //return Seccion(num, divisor, "UN MILLON", "MILLONES") + " " + Miles(resto);
    }//Millones()

    function NumeroALetras(num) {
        var data = {
            numero: num,
            enteros: Math.floor(num),
            centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
            letrasCentavos: "",
            letrasMonedaPlural: "PESOS ",
            letrasMonedaSingular: "PESO "
        };

        if (data.centavos >= 0)
            data.letrasCentavos = "" + data.centavos + "/100 MXN";

        if (data.enteros == 0)
            return "CERO " + data.letrasMonedaPlural + "" + data.letrasCentavos;
        if (data.enteros == 1)
            return Millones(data.enteros) + " " + data.letrasMonedaSingular + "" + data.letrasCentavos;
        else
            return Millones(data.enteros) + " " + data.letrasMonedaPlural + "" + data.letrasCentavos;
    }
    /* 1 = OK, 2 = ERROR*/
    function onBeep(index) {
        var audio = new Audio('<?php print base_url(); ?>/media/' + index + '.mp3');
        audio.play();
    }

    var opcion = "";

    function getMenu(m) {
        getQuickMenu(2);
        onComprobarModulos(2);
        $.post('<?php print base_url('menu_opciones_modulos'); ?>', {MOD: m}).done(function (data) {
            var dtm = JSON.parse(data);
            if (dtm.length > 0) {
                var uniqueNames = [], menus = [];
                $.each(dtm, function (i, el) {
                    if ($.inArray(el.Opcion, uniqueNames) === -1) {
                        uniqueNames.push(el.Opcion);
                        menus.push({Opcion: el.Opcion, Icon: el.Icon, Ref: el.Ref, Button: el.Button, Class: el.Class});
                    }
                });
                var n = 0, burl = '<?php print base_url(); ?>';
                var uitems = [], items = [], usubitems = [], subitems = [], usubsubitems = [], subsubitems = [];

                /*USR VAR*/
                var usr = '<?php print $this->session->ID; ?>';
                var u = (usr !== '' ? parseInt(usr) : 0), ui = 0, uis = 0,
                        uiss = 0;

                $.each(dtm, function (i, el) {
                    /*ITEMS*/
                    if ($.inArray(el.Item, uitems) === -1) {
                        uitems.push(el.Item);
                        items.push({Opcion: el.Opcion, Item: el.Item, IconItem: el.IconItem,
                            RefItem: el.RefItem, ItemModal: el.ItemModal,
                            ItemBackdrop: el.ItemBackdrop, ItemDropdown: parseInt(el.ItemDropdown),
                            Function: parseInt(el.Function),
                            Trigger: el.Trigger});
                    }
                    /*ITEMS TIENEN SUBITEMS*/
                    if ($.inArray(el.SubItem, usubitems) === -1) {
                        ui = parseInt(el.USUARIO_ITEM), uis = parseInt(el.USUARIO_SUBITEM);

//                        console.log(u, "=> ", ui, ", ", uis, ", ", uiss, el);
//                        console.log(u === ui, u === uis, u === uiss);
                        if (u === ui && u === uis) {
                            usubitems.push(el.SubItem);
                            subitems.push({Item: el.Item, SubItem: el.SubItem, IconSubItem: el.IconSubItem,
                                RefSubItem: el.RefSubItem, SubItemModal: el.SubItemModal,
                                SubItemBackdrop: el.SubItemBackdrop, SubItemDropdown: el.SubItemDropdown,
                                Function: parseInt(el.FunctionSubItem),
                                Trigger: el.TriggerSubItem, IsSubItem: el.is_subitem});
                        }
                    }
                    /*SUBITEMS TIENEN SUBSUBITEMS*/
                    if ($.inArray(el.SubSubItem, usubsubitems) === -1 && el.RefItem === '#' && el.RefSubItem === '#' && parseInt(el.SubItemDropdown) === 1) {
                        ui = parseInt(el.USUARIO_ITEM), uis = parseInt(el.USUARIO_SUBITEM),
                                uiss = parseInt(el.USUARIO_SUBSUBITEM);

//                        console.log(u, "=> ", ui, ", ", uis, ", ", uiss);
//                        console.log(u === ui, u === uis, u === uiss);
                        if (u === ui && u === uis && u === uiss) {
                            usubsubitems.push(el.SubSubItem);
                            subsubitems.push({SubItem: el.SubItem, SubSubItem: el.SubSubItem, IconSubSubItem: el.IconSubSubItem,
                                RefSubSubItem: el.RefSubSubItem, SubSubItemModal: el.SubSubItemModal, IsSubSubItem: el.is_subsubitem,
                                SubSubItemBackdrop: el.SubSubItemBackdrop});
                        }
                    }
                });
                $.each(menus, function (k, v) {
                    if (parseInt(v.Button) === 0) {
                        opcion += '<li class="nav-item dropdown">';
                        opcion += '<a class="btn btn-primary dropdown-toggle" href="' + v.Ref + '" id="nav' + v.Opcion + '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                        opcion += '<span class="fa fa-' + v.Icon + '"></span> ' + v.Opcion + '</a>';
                        /*START ITEMS*/
                        opcion += '<ul class="dropdown-menu animate  slideIn" aria-labelledby="nav' + v.Opcion + '">';
                        $.each(items, function (kk, vv) {
                            if (v.Opcion === vv.Opcion) {
                                switch (vv.ItemDropdown) {
                                    case 0:
                                        switch (parseInt(vv.ItemModal)) {
                                            case 0:
                                                switch (parseInt(vv.Function)) {
                                                    case 0:
                                                        opcion += '<a class="dropdown-item" href="' + (burl + vv.RefItem) + '"><span class="fa fa-' + vv.IconItem + '"></span> ' + vv.Item + '</a>';
                                                        break;
                                                    case 1:
                                                        opcion += '<a class="dropdown-item" href="#" onclick="' + vv.Trigger + '()"><span class="fa fa-' + vv.IconItem + '"></span> ' + vv.Item + '</a>';
                                                        break;
                                                }
                                                break;
                                            case 1:
                                                opcion += '<a class="dropdown-item" href="#" data-toggle="modal" data-target="' + vv.RefItem + '" data-backdrop=\'true\'><span class="fa fa-' + vv.IconItem + '"></span> ' + vv.Item + '</a>';
                                                break;
                                        }
                                        break;
                                    case 1:
                                        if (n === 0) {
                                            opcion += '<li class="dropdown-submenu">';
                                            opcion += '<a class="dropdown-item dropdown-toggle" href="#"><span class="fa fa-plus"></span> ' + vv.Item + '</a>';
                                            var nav_subitems = vv.ItemDropdown, nav_subsubitems = 0;
                                            if (nav_subitems === 1) {
                                                opcion += '<ul class="dropdown-menu  animate slideIn">';
                                            }
                                            /*NIVEL 2*/
                                            $.each(subitems, function (kkk, vvv) {
                                                if (vv.Item === vvv.Item) {
                                                    switch (parseInt(vvv.SubItemDropdown)) {
                                                        case 0:
                                                            switch (parseInt(vvv.SubItemModal)) {
                                                                case 0:
                                                                    switch (parseInt(vvv.Function)) {
                                                                        case 0:
                                                                            if (vvv.IsSubItem !== null) {
                                                                                opcion += '<a class="dropdown-item" href="' + (burl + vvv.RefSubItem) + '"><span class="fa fa-' + vvv.IconSubItem + '"></span> ' + vvv.SubItem + '</a>';
                                                                            }
                                                                            break;
                                                                        case 1:
                                                                            if (vvv.IsSubItem !== null) {
                                                                                opcion += '<a class="dropdown-item" href="#" onclick="' + vvv.Trigger + '()"><span class="fa fa-' + vvv.IconSubItem + '"></span> ' + vvv.SubItem + '</a>';
                                                                            }
                                                                            break;
                                                                    }
                                                                    break;
                                                                case 1:
                                                                    if (vvv.IsSubItem !== null) {
                                                                        opcion += '<a class="dropdown-item" href="#" data-toggle="modal" data-target="' + vvv.RefSubItem + '" data-backdrop=\'' + vvv.SubItemBackdrop + '\'><span class="fa fa-' + vvv.IconSubItem + '"></span> ' + vvv.SubItem + '</a>';
                                                                    }
                                                                    break;
                                                            }
                                                            break;
                                                        case 1:
                                                            if (vvv.IsSubItem !== null) {
                                                                opcion += '<li class="dropdown-submenu">';
                                                                opcion += '<a class="dropdown-item dropdown-toggle" href="#"><span class="fa fa-plus"></span> ' + vvv.SubItem + '</a>';
                                                                /*NIVEL 3*/
                                                                nav_subsubitems = vvv.SubItemDropdown;
                                                                if (nav_subsubitems === 0) {
                                                                    opcion += '<ul class="dropdown-menu  animate slideIn">';
                                                                }
                                                                $.each(subsubitems, function (kss, vss) {
                                                                    console.log("vss.IsSubSubItem", vss)
                                                                    if (vss.IsSubSubItem !== null) {
                                                                        switch (parseInt(vss.SubSubItemModal)) {
                                                                            case 0:
                                                                                opcion += '<a class="dropdown-item" href="' + (burl + vss.RefSubSubItem) + '"><span class="fa fa-' + vss.IconSubSubItem + '"></span> ' + vss.SubSubItem + '</a>';
                                                                                break;
                                                                            case 1:
                                                                                opcion += '<a class="dropdown-item" href="#" data-toggle="modal" data-target="' + vss.RefSubSubItem + '" data-backdrop=\'' + vss.SubSubItemBackdrop + '\'><span class="fa fa-' + vss.IconSubSubItem + '"></span> ' + vss.SubSubItem + '</a>';
                                                                                break;
                                                                        }
                                                                        nav_subsubitems = 1;
                                                                    }
                                                                });
                                                                if (nav_subsubitems === 1 && parseInt(vvv.SubItemDropdown) === 0) {
                                                                    opcion += '</ul>';
                                                                }
                                                            }
                                                            break;
                                                    }/*END SWITCH*/
                                                }
                                                nav_subitems = 1;
                                            });//each subitems

                                            if (nav_subitems === 1) {
                                                opcion += '</ul>';
                                            }
                                            if (n === 0) {
                                                opcion += '</li>';
                                                n = 1;
                                            }
                                        }
                                        break;
                                }
                            }
                            n = 0;
                        });
                        /*END ITEMS*/
                        opcion += '</ul>';
                        opcion += '</li>';
                    } else {
                        opcion += '<li class="nav-item mx-1">';
                        opcion += '<a class="btn btn-sm btn-' + v.Class + '" href="' + (burl + v.Ref) + '" style="margin-top: 4px;"><span class="fa fa-' + v.Icon + '"></span> ' + v.Opcion + '</a>';
                        opcion += '</li>';
                    }
                });
            } else {
                onSalirSinItems();
            }
        }, "json").fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            opcion += '<li class="nav-item dropdown ml-auto session-dropdown">';
            opcion += '<a class="btn btn-primary dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            opcion += ' <img src="<?php print "https://bootdey.com/img/Content/avatar/avatar" . rand(1, 8) . ".png"; ?>" class="rounded-circle" width="24">';
            opcion += ' <?php echo $this->session->userdata('Nombre') . ' ' . $this->session->userdata('Apellidos'); ?> ';
            opcion += '</a>';
            opcion += '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">';
            opcion += '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#mdlReportarProblema"><i class="fa fa-question-circle"></i> Reportar un problema</a>';
            opcion += '<a class="dropdown-item" href="#"><i class="fa fa-key"></i> Cambiar Contraseña</a>';
            opcion += '<div class="dropdown-divider"></div>';
            opcion += '<a class="dropdown-item" href="<?php print base_url('Sesion/onSalir'); ?>"><i class="fa fa-sign-out-alt"></i> Salir</a>';
            opcion += '</div>';
            opcion += '</li>';
//            console.log(opcion)
            $("#navbarSupportedContent").find("ul.navbar-nav").html(opcion);

            /*AQUI ES DONDE ME CONSAGRO*/
            $("#navbarSupportedContent").find("ul.navbar-nav").find('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
                var $el = $(this);
                var $parent = $(this).offsetParent(".dropdown-menu");
                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                var $subMenu = $(this).next(".dropdown-menu");
                $subMenu.toggleClass('show');

                $(this).parent("li").toggleClass('show');

                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
                    $('.dropdown-menu .show').removeClass("show");
                });
                if (!$parent.parent().hasClass('navbar-nav')) {
                    $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
                }
                return false;
            });
            getAccesosDirectosXModuloXUsuario(m);
        });
    }

    function getAccesosDirectosXModuloXUsuario(m) {
        var usr = '<?php print $this->session->ID; ?>' !== '' ? '<?php print $this->session->ID; ?>' : 0;
        $.getJSON('<?php print base_url('accesos_directos_x_usuario') ?>',
                {MODULO: parseInt(m), USUARIO: usr}).done(function (a) {
            var accesos_directos = "";
            if (a.length > 0) {
                var burl = '<?php print base_url(); ?>';
                $.each(a, function (k, v) {
                    accesos_directos += '<div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-2 m-2 animated bounceIn" onclick="location.href =\'' + (burl + v.Ref) + '\'">' +
                            '<div class="card text-center">' +
                            '<div class="card-body">' +
                            '<span class="fa fa-' + v.Icon + ' fa-2x mt-5"></span>' +
                            '</div>' +
                            '<div class="card-footer">' +
                            '<h5>' + v.Nombre + '</h5>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                });
            }
            $("#MnuBlock").html(accesos_directos);
        }).fail(function (x) {
            console.log("\n ERROR EN ACCESOS DIRECTOS \n", x);
        }).always(function () {

        });
    }

    var modulos_counter = 0;
    function onMenuDisplay(e) {
        window.location.href = '<?php print base_url(); ?>' + e + '.shoes/';
    }

    function onComprobarModulos(type) {
        setTimeout(function () {
            getQuickMenu(type);
            onComprobarModulos(type);
        }, 600000);/*cada 10 min*/
    }

    function onSalirSinItems() {
        swal({
            title: "ATENCIÓN",
            text: "LO SENTIMOS, NO PUDIMOS CONECTAR CON LA BASE DE DATOS O NO TIENE ITEMS ASIGNADOS",
            icon: "warning",
            buttons: {
                eliminar: {
                    text: "Cerrar sesión",
                    value: "aceptatudestino"
                }
            }
        }).then((value) => {
            switch (value) {
                case "aceptatudestino":
                    location.href = '<?php print base_url('Sesion/onSalir'); ?>';
                    break;
                default:
                    location.href = '<?php print base_url('Sesion/onSalir'); ?>';
            }
        });
    }
    function getQuickMenu(type) {
        var burl = '<?php print base_url(); ?>';
        $.getJSON('<?php print base_url('menu_modulos'); ?>').done(function (data) {
            var modulo = "";
            if (modulos_counter === 0) {
                if (data.length > 0) {
                    modulos_counter = data.length;
                    switch (type) {
                        case 1:
                            $.each(data, function (k, v) {
                                modulo += '<div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-2 m-2 animated bounceIn" onclick="onMenuDisplay(\'' + v.Ref + '\');">';
                                modulo += '<div class="card text-center">';
                                modulo += '<div class="card-body">';
                                modulo += '<span class="fa fa-' + v.Icon + ' fa-2x mt-5"></span>';
                                modulo += '</div>';
                                modulo += '<div class="card-footer">';
                                modulo += '<h5>' + v.Modulo + '</h5>';
                                modulo += '</div>';
                                modulo += '</div>';
                                modulo += '</div>';
                            });
                            $("#MnuBlock").html(modulo);
                            modulo = "";
                            $.each(data, function (k, v) {
                                modulo += '<li class="item">';
                                modulo += '<a  href="' + (burl + v.Ref) + '">';
                                modulo += '<i class="fa fa-' + v.Icon + '" style="width: 45px;"></i> ' + v.Modulo;
                                modulo += '</a>';
                                modulo += '</li>';
                            });
                            $("ul.main").html(modulo);
                            break;
                        case 2:
                            modulo = "";
                            $.each(data, function (k, v) {
                                modulo += '<li class="item">';
                                modulo += '<a  href="' + (burl + v.Ref) + '">';
                                modulo += '<i class="fa fa-' + v.Icon + '" style="width: 45px;"></i> ' + v.Modulo;
                                modulo += '</a>';
                                modulo += '</li>';
                            });
                            $("ul.main").html(modulo);
                            break;
                    }
                } else {
                    onSalirSinItems();
                }
            } else if (data.length !== modulos_counter) {
                modulos_counter = 0;
            }
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }
    function getError(x) {
        console.log(x.responseText);
        swal('ERROR', 'HA OCURRIDO UN ERROR, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
    }

    /**
     * @function getVR
     *
     * Valida un campo por medio de la variable, devuelve el valor o un valor vacio
     *
     * @param e Nombre de variable a validar
     * @return type
     */

    /**
     * @syntax getVR(e)
     * @param {Object} e
     * @returns {String}
     * @static
     */
    function getVR(e) {
        return e.val() ? e.val() : '';
    }
    function getidsInputSelect(padre) {
        var inputs_selects = padre.find("input:not(input[id$='selectized']), select,textarea,table");
        var i = 1;
        console.log("var ");
        var logs = "var ";
        $.each(inputs_selects, function (k, v) {
            var xxx = $(v).attr('id') + " = " + padre.attr('id') + ".find('#" + $(v).attr('id') + "')";
            if (i === inputs_selects.length) {
                console.log(xxx + ";\n");
                logs += xxx + ";\n";
            } else {
                if ($(v).attr('id') === undefined) {
                    xxx = $(v).attr('name') + " = " + padre.attr('id') + ".find('#" + $(v).attr('name') + "')";
                    console.log(xxx + ",\n");
                    logs += xxx + ",\n";
                    i += 1;
                } else {
                    console.log(xxx + ",\n");
                    logs += xxx + ",\n";
                    i += 1;
                }
            }
        });
        console.log(logs)
    }

    function onOpenOverlay(msg) {
        HoldOn.open({
            theme: 'sk-rect',
            message: msg
        });
    }
    function onCloseOverlay() {
        HoldOn.close();
    }
    function TestThisJSONURL(url) {
        /*SIRVE PARA LOS DATATABLES, DESCARTAR QUE SEA PROBLEMA DEL SQL O UN METODO MAL EMPLEADO DEL LADO DEL SERVER*/
        $.getJSON(url).done(function (a) {
            console.log(a);
            onNotifyOld('', 'REVISA LA CONSOLA', 'success');
        }).fail(function (x, y, x) {
            console.log(x);
        }).always(function () {

        });
    }

    function iMsg(msg, t, f) {
        swal('ATENCIÓN', msg,
                (t === 's' ? 'success' : (t === 'i' ? 'info' : (t === 'w' ? 'warning' : 'error')))).then(function () {
            f();
        });
    }
</script>
