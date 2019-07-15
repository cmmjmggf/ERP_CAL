<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Aplica Depositos de Clientes</legend>
            </div>
            <div class="col-sm-6" align="right">
                <button type="button" class="btn btn-primary btn-sm " id="btnAplicarDepositos" >
                    <span class="fa fa-users" ></span> APLICA DEPÓSITOS
                </button>
                <button type="button" class="btn btn-danger btn-sm " id="btnImprimir" >
                    <span class="fa fa-file-pdf" ></span> IMPRIME
                </button>
                <button type="button" class="btn btn-danger btn-sm " id="btnImprimeNoAplicados" >
                    <span class="fa fa-file-pdf" ></span> IMPRIME NO APLICADOS
                </button>
                <button type="button" class="btn btn-success btn-sm " id="btnTipoCambio" >
                    <span class="fa fa-dollar-sign" ></span> T. DE CAMBIO
                </button>
            </div>
        </div>
        <div class="row ">
            <!--primer columna-->
            <div class="col-9 border border-info border-left-0  border-bottom-0">
                <div class="row">
                    <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                        <label>Tp</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Tp" maxlength="1" required="">
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                        <label for="" >Banco</label>
                        <select id="Banco" name="Banco" class="form-control form-control-sm required" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                        <label for="" >Documento</label>
                        <select id="Doc" name="Doc" class="form-control form-control-sm required" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                        <label for="" >Cliente</label>
                        <select id="Cliente" name="Cliente" class="form-control form-control-sm required" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-2 col-xl-2" >
                        <label>Importe</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="ImporteTC" name="ImporteTC" maxlength="10"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-2 col-xl-2" >
                        <label>Aplicado</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="ImporteTC" name="ImporteTC" maxlength="10"  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-2 col-xl-2" >
                        <label>Saldo</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="ImporteTC" name="ImporteTC" maxlength="10"  >
                    </div>
                    <div class="w-100 border border-info mt-1 border-right-0  border-left-0 border-bottom-0"></div>
                    <!--Primer tabla-->
                    <div class="col-12 mt-2" >
                        <label>Documentos con saldo del cliente <span class="badge badge-info" style="font-size: 13px !important;">Doble click para seleccionar</span></label>
                        <div class="card-block ">
                            <div id="AplicaDepositosCliente">
                                <table id="tblAplicaDepositosCliente" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Docto</th>
                                            <th>Tp</th>
                                            <th>Fecha</th>
                                            <th>Importe</th>
                                            <th>Pagos</th>
                                            <th>Saldo</th>
                                            <th>Estatus</th>
                                            <th>Días</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 border border-info mt-1 border-right-0  border-left-0 border-bottom-0"></div>
                    <!--segunda tabla-->
                    <div class="col-12 mt-2" >
                        <label>Pagos de este documento</label>
                        <div class="card-block ">
                            <div id="AplicaDepositosCliente">
                                <table id="tblAplicaDepositosCliente" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Docto</th>
                                            <th>Tp</th>
                                            <th>Fecha Dep</th>
                                            <th>Fecha Cap</th>
                                            <th>Importe</th>
                                            <th>Mv</th>
                                            <th>Referencia</th>
                                            <th>Dias</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--segunda columna-->
            <div class="col-3 border border-info border-right-0  border-left-0 border-bottom-0">
                <div class="row">
                    <div class="col-6 col-sm-2 col-md-2 col-lg-4 col-xl-8" >
                        <label>Depósito</label>
                        <input type="text" class="form-control form-control-sm " id="FechaDeposito" name="FechaDeposito" readonly=""  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-2 col-lg-4 col-xl-4" >
                        <label>Cuenta</label>
                        <input type="text" class="form-control form-control-sm " id="CuentaDeposito" name="CuentaDeposito" readonly=""  >
                    </div>
                    <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-6" >
                        <label>Estatus</label>
                        <input type="text" class="form-control form-control-sm  " id="EstatusDeposito" name="EstatusDeposito" readonly="" >
                    </div>
                    <!--datos aplicacion-->
                    <div class="w-100 border border-info mt-2 border-right-0  border-left-0 border-bottom-0"></div>
                    <div class="col-6 col-sm-2 col-md-2 col-lg-4 col-xl-6" >
                        <label>Docto</label>
                        <input type="text" class="form-control form-control-sm " id="Docto" name="Docto" readonly=""  >
                    </div>
                    <div class="col-6 col-sm-3 col-md-2 col-lg-4 col-xl-6" >
                        <label>Fecha</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly date notEnter" id="FechaDocto" name="FechaDocto" maxlength="12" readonly="">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" >
                        <label>Folio Fiscal</label>
                        <input type="text" class="form-control form-control-sm " readonly="" id="FolioDeposito" name="FolioDeposito">
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Importe</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="ImporteDocto" name="ImporteDocto">
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Pagos</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="PagosDocto" name="PagosDocto">
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Saldo</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="SaldoDocto" name="SaldoDocto">
                    </div>
                    <div class="w-100 border border-info mt-2 border-right-0  border-left-0 border-bottom-0"></div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-12 col-xl-6" >
                        <label>Importe a pagar:</label>
                        <input type="text" class="form-control form-control-sm numbersOnly" id="ImporteAPagar" name="ImporteAPagar">
                    </div>
                    <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4 pt-2">
                        <button type="button" class="btn btn-primary btn-sm" id="btnGuardar" data-toggle="tooltip" data-placement="top" title="Capturar Documento">
                            <i class="fa fa-save"></i> ACEPTAR
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/AplicaDepositosCliente/';
    var tblAplicaDepositosCliente = $('#tblAplicaDepositosCliente');
    var AplicaDepositosCliente;
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');

</script>
<style>
    .text-strong {
        font-weight: bolder;
    }

    tr.group-start:hover td{
        background-color: #e0e0e0 !important;
        color: #000 !important;
    }
    tr.group-end td{
        background-color: #FFF !important;
        color: #000!important;
    }
    td{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    td span.badge{
        font-size: 100% !important;
    }
</style>
