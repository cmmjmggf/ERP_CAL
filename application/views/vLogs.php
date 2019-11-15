<div id="mdlLogs" class="modal animated fadeIn">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class=""></span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-9">
                        <label>Usuario</label>
                        <div class="row">
                            <div class="col-8 col-sm-6">
                                <input type="text" class="form-control form-control-sm" id="UsuarioLog" name="UsuarioLog" placeholder="2805">
                            </div>
                            <div class="col-4 col-sm-6">
                                <select id="SUsuarioLog" name="SUsuarioLog" class="form-control form-control-sm"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12"> 
                        <div id="Logs" class="table-responsive">
                            <table id="tblLogs" class="table table-sm display " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Empresa</th>
                                        <th>Modulo</th>
                                        <th>Usuario</th>
                                        <th>Departamento</th>
                                        <th>Acción</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Dia</th>
                                        <th>Mes</th>
                                        <th>Año</th>
                                        <th>Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q = "SELECT * FROM logs AS L ORDER BY L.ID DESC";
                                    $row = "";
                                    foreach ($this->db->query($q)->result() as $k => $v) {
                                        $row .= "<tr>";
                                        $row .= "<td>{$v->ID}</td>";
                                        $row .= "<td>{$v->Empresa}</td>"; 
                                        $row .= "<td>{$v->Modulo}</td>"; 
                                        $row .= "<td>{$v->Usuario}</td>"; 
                                        $row .= "<td>{$v->Tipo}</td>"; 
                                        $row .= "<td>{$v->Accion}</td>"; 
                                        $row .= "<td>{$v->Fecha}</td>"; 
                                        $row .= "<td>{$v->Hora}</td>"; 
                                        $row .= "<td>{$v->Dia}</td>"; 
                                        $row .= "<td>{$v->Mes}</td>"; 
                                        $row .= "<td>{$v->Anio}</td>"; 
                                        $row .= "<td>{$v->Registro}</td>"; 
                                        $row .= "</tr>";
                                    }
                                    ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>