<div class="modal " id="mdlImprimirCredenciales"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Re-impresión de credenciales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6" id="dEmpleado">
                            <label>Empleado</label>
                            <select id="EmpleadoReimprimeCred" name="EmpleadoReimprimeCred" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="badge badge-info" style="font-size:14px;">Si deseas imprimir por departamentos, haz click aquí</label>
                        </div>
                        <div class="col-12">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="credXDepto" name="credXDepto">
                                <label class="custom-control-label text-info labelCheck" for="credXDepto">Imprimir X Departamento</label>
                            </div>
                        </div>
                    </div>
                    <div class="row d-none" id="dDepto">
                        <div class="col-6">
                            <label>Del Depto.</label>
                            <select id="dDeptoCredenciales" name="dDeptoCredenciales" class="form-control form-control-sm">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Al Depto.</label>
                            <select id="aDeptoCredenciales" name="aDeptoCredenciales" class="form-control form-control-sm">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary " id="btnImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-info " id="btnVerEmpleadosCredenciales">EMPLEADOS</button>
                <button type="button" class="btn btn-secondary " id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlImprimirCredenciales = $('#mdlImprimirCredenciales');
    var btnVerEmpleadosCredenciales = $("#btnVerEmpleadosCredenciales");
    $(document).ready(function () {
        mdlImprimirCredenciales.on('shown.bs.modal', function () {
            handleEnterDiv(mdlImprimirCredenciales);
            validacionSelectPorContenedor(mdlImprimirCredenciales);
            mdlImprimirCredenciales.find("input").val("");
            $.each(mdlImprimirCredenciales.find("select"), function (k, v) {
                mdlImprimirCredenciales.find("select")[k].selectize.clear(true);
            });
            getEmpleadosCredenciales();
            mdlImprimirCredenciales.find('#EmpleadoReimprimeCred')[0].selectize.focus();
        });

        btnVerEmpleadosCredenciales.click(function () {
            $.fancybox.open({
                src: base_url + '/Empleados.shoes/?origen=NOMINAS',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
                        console.info('done!');
                    },
                    iframe: {
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
                    }
                }
            });
        });

        mdlImprimirCredenciales.find("#credXDepto").change(function () {
            if (mdlImprimirCredenciales.find("#credXDepto")[0].checked) {
                getDepartamentosCredenciales();
                mdlImprimirCredenciales.find("#dDepto").removeClass('d-none');
                mdlImprimirCredenciales.find("#dEmpleado").addClass('d-none');
                mdlImprimirCredenciales.find('#dDeptoCredenciales')[0].selectize.focus();
            } else {
                mdlImprimirCredenciales.find("#dEmpleado").removeClass('d-none');
                mdlImprimirCredenciales.find("#dDepto").addClass('d-none');
                mdlImprimirCredenciales.find('#EmpleadoReimprimeCred')[0].selectize.focus();
            }
        });

        mdlImprimirCredenciales.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var num = mdlImprimirCredenciales.find('#EmpleadoReimprimeCred').val();
            var ddepto = mdlImprimirCredenciales.find('#dDeptoCredenciales').val();
            var adepto = mdlImprimirCredenciales.find('#aDeptoCredenciales').val();
            if (mdlImprimirCredenciales.find("#credXDepto")[0].checked) {
                getCredencialXDeptos(ddepto, adepto);
            } else {
                getCredencialXEmpelado(num);
            }


        });
    });
    function getCredencialXDeptos(ddepto, adepto) {
        $.getJSON(base_url + 'index.php/Empleados/getCredenciales', {dDepto: ddepto, aDepto: adepto}).done(function (data, x, jq) {
            console.log(data.URL.length);
            if (data.URL.length > 0) {
                $.fancybox.open({
                    src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data.URL + '#pagemode=thumbs',
                    type: 'iframe',
                    opts: {
                        afterShow: function (instance, current) {
                            console.info('done!');
                        },
                        iframe: {
                            // Iframe template
                            tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                            preload: true,
                            // Custom CSS styling for iframe wrapping element
                            // You can use this to set custom iframe dimensions
                            css: {
                                width: "95%",
                                height: "95%"
                            },
                            // Iframe tag attributes
                            attr: {
                                scrolling: "auto"
                            }
                        }
                    }
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                    icon: "error"
                }).then((action) => {
                    mdlImprimirCredenciales.find('#dDeptoCredenciales')[0].selectize.focus();
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
        }).always(function () {
            HoldOn.close();
        });
    }

    function getCredencialXEmpelado(num) {
        $.getJSON(base_url + 'index.php/Empleados/getCredencial', {ID: num}).done(function (data, x, jq) {
            console.log(data.URL.length);
            if (data.URL.length > 0) {
                $.fancybox.open({
                    src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data.URL + '#pagemode=thumbs',
                    type: 'iframe',
                    opts: {
                        afterShow: function (instance, current) {
                            console.info('done!');
                        },
                        iframe: {
                            // Iframe template
                            tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                            preload: true,
                            // Custom CSS styling for iframe wrapping element
                            // You can use this to set custom iframe dimensions
                            css: {
                                width: "95%",
                                height: "95%"
                            },
                            // Iframe tag attributes
                            attr: {
                                scrolling: "auto"
                            }
                        }
                    }
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                    icon: "error"
                }).then((action) => {
                    mdlImprimirCredenciales.find('#EmpleadoReimprimeCred').focus();
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
        }).always(function () {
            HoldOn.close();
        });
    }

    function getDepartamentosCredenciales() {
        $.getJSON(base_url + 'index.php/Departamentos/getDepartamentos').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlImprimirCredenciales.find("#dDeptoCredenciales")[0].selectize.addOption({text: v.Departamento, value: v.Clave});
                mdlImprimirCredenciales.find("#aDeptoCredenciales")[0].selectize.addOption({text: v.Departamento, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getEmpleadosCredenciales() {
        $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getEmpleadosGeneral').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlImprimirCredenciales.find("#EmpleadoReimprimeCred")[0].selectize.addOption({text: v.Empleado, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }


</script>


