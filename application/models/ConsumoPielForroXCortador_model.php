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
                            ->where('D.Descripcion LIKE \'CORTE\'', null, false)
                            ->where('E.AltaBaja', 1)->get()->result();
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
            $this->db->select("A.Semana AS SEMANA,A.Maquila AS MAQUILA,
                                   IFNULL(E.Numero,0) AS NUMERO, CONCAT(IFNULL(E.PrimerNombre,\"\"), \" \",
                                   IFNULL(E.SegundoNombre,\"\"), \" \", IFNULL(E.Paterno,\"\"), \" \",
                                   IFNULL(E.Materno,\"\")) AS CORTADOR", false)
                    ->from("asignapftsacxc AS A")
                    ->join("empleados AS E", "A.Empleado = IFNULL(E.Numero,0)", 'left');
            if ($ARTICULO !== '') {
                $this->db->where("A.Articulo =  '$ARTICULO'", null, false);
            }
            if ($CORTADOR !== '') {
                $this->db->where("A.Empleado =  '$CORTADOR'", null, false);
                $this->db->where("E.Numero =  '$CORTADOR'", null, false);
            }
            if ($SEMANAINICIAL !== '' && $SEMANAFINAL !== '') {
                $this->db->where("A.Semana BETWEEN '$SEMANAINICIAL' AND '$SEMANAFINAL'", null, false);
            }
            if ($MAQUILA !== '') {
                $this->db->where("A.Maquila = '$MAQUILA'", null, false);
            }
            if ($ANO !== '') {
                $this->db->where("YEAR(str_to_date(A.Fecha, '%d/%m/%Y')) = '$ANO'", null, false);
            }

            switch (intval($TIPO)) {
                case 1:
                    $this->db->where("A.Fraccion = 100", null, false);
                    break;
                case 2:
                    $this->db->where("A.Fraccion = 99", null, false);
                    break;
            }
            $this->db->where("A.TipoMov = '$TIPO'", null, false)->where('E.AltaBaja', 1);
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function getEstilosPorCortador($ARTICULO, $MAQUILA, $SEMANAINICIAL, $SEMANAFINAL, $ANO, $CORTADOR_CLAVE, $TIPO) {
        try {
            $this->db->select("A.Estilo AS Estilo_X_Cortador", false)
                    ->from("asignapftsacxc AS A")
                    ->join("empleados AS E", "A.Empleado = IFNULL(E.Numero,0)", 'left');
            if ($CORTADOR_CLAVE !== '') {
                $this->db->where("A.Empleado = '$CORTADOR_CLAVE'", null, false);
            }
            if ($ARTICULO !== '') {
                $this->db->where("A.Articulo = '$ARTICULO'", null, false);
            }
            if ($SEMANAINICIAL !== '' && $SEMANAFINAL !== '') {
                $this->db->where("A.Semana BETWEEN '$SEMANAINICIAL' AND '$SEMANAFINAL'", null, false);
            }
            if ($MAQUILA !== '') {
                $this->db->where("A.Maquila = '$MAQUILA'", null, false);
            }
            if ($ANO !== '') {
                $this->db->where("YEAR(str_to_date(A.Fecha, '%d/%m/%Y')) = '$ANO'", null, false);
            }

            switch (intval($TIPO)) {
                case 1:
                    $this->db->where("A.Fraccion = 100", null, false);
                    break;
                case 2:
                    $this->db->where("A.Fraccion = 99", null, false);
                    break;
            }
            $this->db->where("A.TipoMov = '$TIPO'", null, false)->where('E.AltaBaja', 1);
            $this->db->group_by('A.Estilo');
            $data = $this->db->get()->result();
//            print $this->db->last_query();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function getConsumosPielForroXMaquilaSemanaAnioCortadorArticuloFechaInicialFechaFinal($MAQUILA, $SEMANAINICIAL, $SEMANAFINAL, $ANO, $CORTADOR, $ARTICULO, $FECHAINICIAL, $FECHAFINAL, $EMPLEADO, $ESTILO, $TIPO) {
        try {
            $this->db->select("OP.ControlT AS Control, OP.Estilo, OP.Color, OPD.Articulo, OPD.ArticuloT, "
                            . "A.PrecioActual AS Precio, OP.Pares, "
                            . "((SELECT SUM(OPDD.Cantidad) FROM ordendeproducciond AS OPDD WHERE OPDD.OrdenDeProduccion = OP.ID AND OPDD.Articulo = OPD.Articulo) /OP.Pares) AS Consumo, "
                            . "ifnull(OP.CantidadPiel1,0) AS Cantidad, A.Fraccion, 
(SELECT SUM(AX.Abono) FROM asignapftsacxc AS AX WHERE AX.Control = A.Control AND AX.Articulo = A.Articulo AND AX.Fraccion = A.Fraccion) AS Abono, "
                            . "A.Devolucion, A.Basura, A.Piocha,"
                            . "(ifnull(OP.CantidadPiel1,0)  - A.Abono)+(IFNULL(A.Basura,0)+(IFNULL(A.Devolucion,0))) AS Diferencia,"
                            . "(A.PrecioActual * SUM(OPD.Cantidad)) AS SistemaPesos,"
                            . "(A.PrecioActual * (IFNULL(A.Abono,0)-(IFNULL(A.Basura,0)+IFNULL(A.Devolucion,0)))) AS RealPesos, "
                            . "(A.PrecioActual * (SUM(OPD.Cantidad) - A.Abono)+(IFNULL(A.Basura,0)+(IFNULL(A.Devolucion,0)))) AS DifPesos,"
                            . "(A.Abono/OP.Pares) AS DCM2,"
                            . " ((A.Abono - IFNULL(A.Devolucion,0))/OP.Pares)/(SUM(OPD.Cantidad)/OP.Pares) AS PORCENTAJE"
                            . ",((SUM(OPD.Cantidad)-(A.Abono-IFNULL(A.Devolucion,0)))/OP.Pares) AS PORCENTAJEx"
                            . "", false)
                    ->from("ordendeproduccion AS OP")
                    ->join("ordendeproducciond AS OPD", "OP.ID = OPD.OrdenDeProduccion")
                    ->join("asignapftsacxc AS A", "OP.ControlT = A.Control AND A.Articulo = OPD.Articulo");

            if ($FECHAINICIAL !== '' && $FECHAFINAL !== '') {
                $this->db->where("STR_TO_DATE(A.Fecha, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FECHAFINAL', \"%d/%m/%Y\") AND STR_TO_DATE('$FECHAINICIAL', \"%d/%m/%Y\")");
            }
            if ($ANO !== '') {
                $this->db->where("OP.Ano = '$ANO'", null, false);
            }
            if ($CORTADOR !== '') {
                $this->db->where("A.Empleado = '$CORTADOR'", null, false);
            }
            if ($MAQUILA !== '') {
                $this->db->where("OP.Maquila = '$MAQUILA'", null, false);
            }
            if ($ARTICULO !== '') {
                $this->db->where("A.Articulo = '$ARTICULO'", null, false);
            }
            if ($SEMANAINICIAL !== '' && $SEMANAFINAL !== '') {
                $this->db->where("OP.Semana BETWEEN '$SEMANAINICIAL' AND '$SEMANAFINAL'", null, false);
            }
            if ($EMPLEADO !== '') {
                $this->db->where("A.Empleado = '$EMPLEADO'", null, false);
            }
            if ($ESTILO !== '') {
                $this->db->where("A.Estilo = '$ESTILO'", null, false);
            }

            switch (intval($TIPO)) {
                case 1:
                    $this->db->where("A.Fraccion = 100", null, false);
                    break;
                case 2:
                    $this->db->where("A.Fraccion = 99", null, false);
                    break;
            }

            $this->db->where("A.TipoMov = '$TIPO' ", null, false)
                    ->group_by('A.Control')->group_by('A.Articulo') 
                    ->order_by('OPD.Articulo', 'ASC')->order_by('OP.ControlT', 'ASC');
            $str = $this->db->last_query();
//            print $str."\n"."\n";
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
