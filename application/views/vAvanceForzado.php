<div class="modal" id="mdlAvanceForzado">
    <div class="modal-dialog modal-lg notdraggable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-cogs"></span> Avance Forzado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label>Control</label>
                        <input type="text" id="xControlx" name="xControlx" class="form-control form-control-sm font-weight-bold">
                    </div>
                    <div class="col-6">
                        <label>Fecha de (Entrada)</label>
                        <input type="text" id="xFechax" name="xFechax" class="form-control form-control-sm font-weight-bold date">
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-12">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ESTATUS</th>
                                    <th scope="col">DEPARTAMENTO</th>
                                    <th scope="col">AVANCE</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>PRE-PROGRAMADO</td><td>NO APLICA</td><td>0</td> 
                                </tr>
                                <tr>
                                    <td>PROGRAMADO</td><td>NO APLICA</td><td>1</td> 
                                </tr>
                                <tr>
                                    <td>CORTE</td><td>10</td><td>2</td> 
                                </tr>
                                <tr>
                                    <td>RAYADO</td><td>20</td><td>3</td> 
                                </tr>
                                <tr>
                                    <td>REBAJADO</td><td>30</td><td>33</td> 
                                </tr>
                                <tr>
                                    <td>FOLEADO</td><td>40</td><td>4</td> 
                                </tr>
                                <tr>
                                    <td>ENTRETELADO</td><td>90</td><td>40</td> 
                                </tr>
                                <tr>
                                    <td>MAQUILA</td><td>90</td><td>40</td> 
                                </tr>
                                <tr>
                                    <td>ALMACEN CORTE</td><td>105</td><td>44</td> 
                                </tr>
                                <tr>
                                    <td>PESPUNTE</td><td>110</td><td>5</td> 
                                </tr>
                                <tr>
                                    <td>ENSUELADO</td><td>140</td><td>55</td> 
                                </tr>
                                <tr>
                                    <td>ALMACEN PESPUNTE</td><td>130</td><td>6</td> 
                                </tr>
                                <tr>
                                    <td>TEJIDO</td><td>130</td><td>6</td> 
                                </tr>
                                <tr>
                                    <td>ALMACEN TEJIDO</td><td>130</td><td>6</td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">
                    <span class="fa fa-times"></span> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlAvanceForzado = $("#mdlAvanceForzado"), btnAvanceForzado = $("#btnAvanceForzado"),
            xControlx = mdlAvanceForzado.find("#xControlx"), xFechax = mdlAvanceForzado.find("#xFechax");
    $(document).ready(function () {
        btnAvanceForzado.click(function () {
            console.log('oijeqoiwjeqoi');
            mdlAvanceForzado.modal('show');
        });

        mdlAvanceForzado.on('shown.bs.modal', function () {
            xControlx.focus().select();
        });
    });
</script>
<style>

    #mdlAvanceForzado table thead th {
        background-color: #000 !important;
        color: #fff !important;
    }

    #mdlAvanceForzado table tbody td , #mdlAvanceForzado table thead th {
        font-weight: bold !important;
        font-size: 18px !important;
    }

    #mdlAvanceForzado table tbody td   {
        padding-top: 6px !important;
        padding-bottom: 6px !important;
    }
</style>