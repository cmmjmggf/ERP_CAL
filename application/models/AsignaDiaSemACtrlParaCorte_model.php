<?php

class AsignaDiaSemACtrlParaCorte_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        /*
         * 
         * 98	CORTE FORRO A MANO	10
         * 99	CORTAR FORRO A MAQUINA	10
         * 100	CORTAR PIEL A  MAQUINA	10
         *
         */
    }

    public function getRecords() {
        try {
            return $this->db->select("P.ID, CONCAT('<span class=\"badge badge-info\" style=\"font-size: 100%;\">',P.Control,'</span>') AS Control, P.Cliente, "
                                    . "P.Estilo, P.Color, P.Pares, "
                                    . "P.Semana AS Semana", false)
                            ->from("pedidox AS P")->join('estilos AS E', 'P.Estilo = E.Clave')
                            ->join('tiemposxestilodepto AS TXE', 'P.Estilo = TXE.Estilo')
                            ->join('programacion AS PR', 'P.Control = PR.Control', 'left')
                            ->where('PR.Control IS NULL', null, false)
                            ->where_not_in('P.Control', array(0))
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProgramacion() {
        try {
            $styl= 'style=\"font-size: 100%;\"';
            $sp = "<span class=\"badge badge-pill badge-info\" {$styl}>";
            $spbf = "<span class=\"badge badge-pill badge-fusion\" {$styl}>";
            $sps = "<span class=\"badge badge-pill badge-fusion-success\" {$styl}>";
            $spda = "<span class=\"badge badge-pill badge-danger\" {$styl}>";
            $spd = "<span class=\"badge badge-pill badge-dark\" {$styl}>";
            $spw = "<span class=\"badge badge-pill badge-warning\" {$styl}>";
            $spf = '</span>';
            return $this->db->select("PR.ID, CONCAT('{$sps}',PR.numemp,'{$spf}') AS Emp, CONCAT('{$spw}',PR.control,'{$spf}') AS Control, "
                                    . "PR.año AS Ano, CONCAT('{$spda}',PR.semana,'{$spf}') AS Sem, ELT(PR.diaprg,"
                                    . "'{$sp}LUNES{$spf}','{$sp}MARTES{$spf}','{$sp}MIERCOLES{$spf}',"
                                    . "'{$sp}JUEVES{$spf}','{$sp}VIERNES{$spf}','{$sp}SABADO{$spf}',"
                                    . "'{$sp}DOMINGO{$spf}') AS Dia, "
                                    . " CONCAT('{$spbf}',PR.frac,'{$spf}') AS Frac, PR.fecha AS Fecha, PR.estilo AS Estilo, "
                                    . "PR.par AS Pares, PR.tiempo AS Tiempo, PR.precio AS Precio, "
                                    . "PR.nomart", false)
                            ->from("programacion AS PR")->where_in("PR.frac", array(99, 100))->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCortadores() {
        try {
            return $this->db->select("E.Numero AS CLAVE, CONCAT(E.Numero ,' ',E.PrimerNombre, ' ', E.SegundoNombre,' ', E.Paterno,' ', E.Materno) AS EMPLEADO", false)
                            ->from('empleados AS E')->join('departamentos AS D', 'E.DepartamentoFisico = D.Clave')
                            ->where('D.Descripcion LIKE \'CORTE\'', null, false)->where('E.AltaBaja', 1)->order_by('ABS(E.Numero)', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFracciones() {
        try {
            return $this->db->select("F.Clave AS CLAVE, CONCAT(F.Clave,' ',F.Descripcion) AS FRACCION", false)
                            ->from('fracciones AS F')
                            ->where('F.Departamento = 10', null, false)
                            ->order_by('ABS(F.Clave)', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstiloColorParesTxParPorControl($CONTROL, $FRACCION) {
        try {
            $this->db->select('FT.Estilo AS ESTILO, FT.Color AS COLOR, C.Descripcion AS DES_COLOR, PE.Clave CLAVE_PEDIDO, '
                            . 'FT.Articulo AS CLAVE_ARTICULO, FXE.Fraccion AS FRACCION, '
                            . 'A.Descripcion AS ARTICULO, FR.Departamento AS CLAVE_DEPARTAMENTO, '
                            . 'PE.Pares AS PARES, FXE.CostoMO AS PRECIO, TXE.Total AS TIEMPO, '
                            . '(TXE.Total/PE.Pares) AS TXPAR, (PE.Pares*FXE.CostoMO) AS PESOS', false)
                    ->from('pedidox AS PE')
                    ->join('colores AS C', 'PE.Color = C.Clave AND C.Estilo = PE.Estilo')
                    ->join('fichatecnica AS FT', 'PE.Estilo = FT.Estilo AND PE.Color = FT.Color')
                    ->join('articulos AS A', 'FT.Articulo = A.Clave')
                    ->join('fraccionesxestilo AS FXE', 'FXE.Estilo = FT.Estilo')
                    ->join('fracciones AS FR', 'FXE.Fraccion = FR.Clave')
                    ->join('tiemposxestilodepto AS TXE', 'PE.Estilo = TXE.Estilo')
                    ->join('tiemposxestilodepto_has_deptos AS TXEHD', 'TXE.ID = TXEHD.TiempoXEstiloDepto');
            $this->db->where("FR.Departamento = 10 AND TXEHD.Departamento = 10", null, false);
            if ($CONTROL !== '') {
                $this->db->like("PE.Control", $CONTROL);
            }
            switch ($FRACCION) {
                case 99:
                    $this->db->where("FXE.Fraccion = ", $FRACCION)->where_in("A.Grupo", array(2));
                    break;
                case 100:
                    $this->db->where("FXE.Fraccion = ", $FRACCION)->where_in("A.Grupo", array(1));
                    break;
                case 99100:
                    $this->db->where("FXE.Fraccion = ", $FRACCION)->where_in("A.Grupo", array(1, 2));
                    break;
                default:
                    $this->db->where("FXE.Fraccion = ", $FRACCION)->where_in("A.Grupo", array(1, 2));
                    break;
            }
            $this->db->group_by('A.Descripcion');
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
