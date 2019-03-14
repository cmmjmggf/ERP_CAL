<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ConsumoPielForroXCortador_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getCortadores() {
        try {
            return $this->db->select("E.Numero AS CLAVE, CONCAT(E.Numero ,' ',E.PrimerNombre, ' ', E.SegundoNombre,' ', E.Paterno,' ', E.Materno) AS EMPLEADO", false)
                            ->from('empleados AS E')->join('departamentos AS D', 'E.DepartamentoFisico = D.Clave')
                            ->join('asignapftsacxc AS ACXC', 'E.Numero = ACXC.Empleado')
                            ->where('D.Descripcion LIKE \'CORTE\'', null, false)->where('E.AltaBaja', 1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulos() {
        try {
            return $this->db->select("A.Clave AS CLAVE, A.Descripcion AS Articulo, CONCAT(A.Clave, ' ',A.Descripcion) AS CLAVE_ARTICULO", false)
                            ->from('articulos AS A')->join('asignapftsacxc AS ACXC', 'A.Clave = ACXC.Articulo')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarMaquilas($Clave) {
        try {
            return $this->db->select("COUNT(*) AS EXISTE_MAQUILA", false)->from("maquilas AS G")->where("G.Clave", $Clave)->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida($S) {
        try {
            return $this->db->select("COUNT(*) AS SEMANA_NO_CERRADA")->from("semanasproduccion AS S")->where("S.Sem", $S)->where("S.Estatus", "ACTIVO")->order_by('S.Sem', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function getCortadoresXMaquilaSemanaArticulo($ARTICULO, $MAQUILA, $SEMANAINICIAL, $SEMANAFINAL, $ANO, $CORTADOR, $TIPO) {
        try {
            $this->db->select("substr(ASI.Control,3,2) AS SEMANA,substr(ASI.Control,5,2) AS MAQUILA, 
                                   IFNULL(E.Numero,0) AS NUMERO, CONCAT(IFNULL(E.PrimerNombre,\"\"), \" \", IFNULL(E.SegundoNombre,\"\"), \" \", IFNULL(E.Paterno,\"\"), \" \", IFNULL(E.Materno,\"\")) AS CORTADOR", false)
                    ->from("asignapftsacxc AS ASI")
                    ->join("empleados AS E", "ASI.Empleado = IFNULL(E.Numero,0)", 'left');
            if ($ARTICULO !== '') {
                $this->db->where("ASI.Articulo LIKE  '$ARTICULO'", null, false);
            }
            if ($CORTADOR !== '') {
                $this->db->where("ASI.Empleado LIKE  '$CORTADOR'", null, false);
                $this->db->where("E.Numero LIKE  '$CORTADOR'", null, false);
            }
            if ($SEMANAINICIAL !== '' && $SEMANAFINAL !== '') {
                $this->db->where("substr(ASI.Control,3,2) BETWEEN '$SEMANAINICIAL' AND '$SEMANAFINAL'", null, false);
            }
            if ($MAQUILA !== '') {
                $this->db->where("substr(ASI.Control,5,2) LIKE '$MAQUILA'", null, false);
            }
            if ($ANO !== '') {
                $this->db->where("YEAR(str_to_date(ASI.Fecha, '%d/%m/%Y')) LIKE '$ANO'", null, false);
            }
            $this->db->where("ASI.TipoMov LIKE '$TIPO'", null, false)->where('E.AltaBaja', 1);
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function getEstilosPorCortador($ARTICULO, $MAQUILA, $SEMANAINICIAL, $SEMANAFINAL, $ANO, $CORTADOR_CLAVE, $TIPO) {
        try {
            $this->db->select("ASI.Estilo AS Estilo_X_Cortador", false)
                    ->from("asignapftsacxc AS ASI")
                    ->join("empleados AS E", "ASI.Empleado = IFNULL(E.Numero,0)", 'left');
            if ($CORTADOR_CLAVE !== '') {
                $this->db->where("ASI.Empleado LIKE  '$CORTADOR_CLAVE'", null, false);
            }
            if ($ARTICULO !== '') {
                $this->db->where("ASI.Articulo LIKE  '$ARTICULO'", null, false);
            }
            if ($SEMANAINICIAL !== '' && $SEMANAFINAL !== '') {
                $this->db->where("substr(ASI.Control,3,2) BETWEEN '$SEMANAINICIAL' AND '$SEMANAFINAL'", null, false);
            }
            if ($MAQUILA !== '') {
                $this->db->where("substr(ASI.Control,5,2) LIKE '$MAQUILA'", null, false);
            }
            if ($ANO !== '') {
                $this->db->where("YEAR(str_to_date(ASI.Fecha, '%d/%m/%Y')) LIKE '$ANO'", null, false);
            }
            $this->db->where("ASI.TipoMov LIKE '$TIPO'", null, false)->where('E.AltaBaja', 1);
            $this->db->group_by('ASI.Estilo');
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function getConsumosPielForroXMaquilaSemanaAnioCortadorArticuloFechaInicialFechaFinal($MAQUILA, $SEMANAINICIAL, $SEMANAFINAL, $ANO, $CORTADOR, $ARTICULO, $FECHAINICIAL, $FECHAFINAL, $EMPLEADO, $ESTILO, $TIPO) {
        try {
            $this->db->select("OP.ControlT AS Control, OP.Estilo, OP.Color, OPD.Articulo, OPD.ArticuloT, "
                            . "ASI.PrecioActual AS Precio, OP.Pares, SUM(OPD.Consumo) AS Consumo, SUM(OPD.Cantidad) AS Cantidad, ASI.Abono, "
                            . "ASI.Devolucion, ASI.Basura, (SUM(OPD.Cantidad) - ASI.Abono)+(IFNULL(ASI.Basura,0)) AS Diferencia,"
                            . "(ASI.PrecioActual * SUM(OPD.Cantidad)) AS SistemaPesos,(ASI.PrecioActual * ASI.Abono) AS RealPesos, "
                            . "((ASI.PrecioActual * SUM(OPD.Cantidad)) - (ASI.PrecioActual * ASI.Abono)) AS DifPesos,"
                            . "(ASI.Abono/OP.Pares) AS DCM2, SUM(OPD.Consumo)/(ASI.Abono/OP.Pares) AS PORCENTAJE", false)
                    ->from("ordendeproduccion AS OP")
                    ->join("ordendeproducciond AS OPD", "OP.ID = OPD.OrdenDeProduccion")
                    ->join("asignapftsacxc AS ASI", "OP.ID = ASI.OrdenProduccion AND ASI.Articulo = OPD.Articulo");

            if ($FECHAINICIAL !== '' && $FECHAFINAL !== '') {
                $this->db->where("STR_TO_DATE(ASI.Fecha, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FECHAFINAL', \"%d/%m/%Y\") AND STR_TO_DATE('$FECHAINICIAL', \"%d/%m/%Y\")");
            }
            if ($ANO !== '') {
                $this->db->where("OP.Ano LIKE '$ANO'", null, false);
            }
            if ($CORTADOR !== '') {
                $this->db->where("ASI.Empleado LIKE '$CORTADOR'", null, false);
            }
            if ($MAQUILA !== '') {
                $this->db->where("OP.Maquila LIKE '$MAQUILA'", null, false);
            }
            if ($ARTICULO !== '') {
                $this->db->where("ASI.Articulo LIKE  '$ARTICULO'", null, false);
            }
            if ($SEMANAINICIAL !== '' && $SEMANAFINAL !== '') {
                $this->db->where("OP.Semana BETWEEN '$SEMANAINICIAL' AND '$SEMANAFINAL'", null, false);
            }
            if ($EMPLEADO !== '') {
                $this->db->where("ASI.Empleado LIKE '$EMPLEADO'", null, false);
            }
            if ($ESTILO !== '') {
                $this->db->where("ASI.Estilo LIKE '$ESTILO'", null, false);
            }
            $this->db->where("ASI.TipoMov LIKE '$TIPO'", null, false);
            $this->db->group_by('OP.ControlT');
            $str = $this->db->last_query();
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
