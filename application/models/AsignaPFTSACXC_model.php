<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class AsignaPFTSACXC_model extends CI_Model {

    private $limite_inicial = 100;

    function getLimite_inicial() {
        return $this->limite_inicial;
    }

    function setLimite_inicial($limite_inicial) {
        $this->limite_inicial = $limite_inicial;
    }

    public function __construct() {
        parent::__construct();
    }

    public function getControlesAsignados() {
        try {
            $this->db->select("A.ID, A.Empleado, A.Articulo, A.Descripcion, A.Fecha, A.Cargo, A.Abono, A.Devolucion AS Dev, A.Control AS Control")
                    ->from("asignapftsacxc AS A");
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPieles($SEMANA, $CONTROL, $FT) {
        try {
            $xdb = $this->db;
            $xdb->select("OP.ID, OP.ControlT AS CONTROL, OPD.Articulo AS ARTICULO_CLAVE, "
                            . "OPD.ArticuloT AS ARTICULO_DESCRIPCION, OPD.UnidadMedidaT AS UM, OPD.Pieza AS PIEZA, "
                            . "OPD.PiezaT AS PIEZA_DESCRIPCION, OPD.Grupo AS GRUPO, FORMAT(OPD.Cantidad,3) AS CANTIDAD, "
                            . "OP.ControlT AS CONTROL, OP.Semana AS SEMANA, CONCAT(96,99,100) AS FRACCION, "
                            . "OP.Pares AS PARES")
                    ->from("ordendeproduccion AS OP")
                    ->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion');
            if ($SEMANA !== '' && $CONTROL !== '') {
                $xdb->where('OP.Semana', $SEMANA)->where('OP.ControlT', $CONTROL);
            }
            $xdb->where('OPD.Grupo', 1)->where('OPD.Departamento', 10)
                    ->group_by('OPD.OrdenDeProduccion')
                    ->group_by('OP.ControlT')
                    ->group_by('OPD.Pieza')
                    ->group_by('OPD.Articulo')
                    ->group_by('OPD.UnidadMedidaT');
            if ($FT === 1 || $FT === '1') {
                $xdb->limit($this->getLimite_inicial());
            }
            return $xdb->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegresos() {
        try {
            return $this->db->select("A.ID, A.Empleado AS Cortador, A.Control, A.Fraccion AS PiFoFraccion, "
                                    . "A.Estilo, A.Color, A.Pares, A.Articulo, A.Descripcion AS ArticuloT, "
                                    . "A.Abono AS Entregado, A.Devolucion AS  Regreso, A.TipoMov AS Tipo")
                            ->from("asignapftsacxc AS A")->where_in('A.TipoMov', array(1, 2, 34, 40))->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesXControl($CONTROL) {
        try {
            return $this->db->select("OP.Pares AS PARES")
                            ->from("ordendeproduccion AS OP")->like('OP.ControlT', $CONTROL)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            return $this->db->select("E.Numero AS CLAVE, CONCAT(E.Numero,' ', E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS EMPLEADO")
                            ->from("empleados AS E")->where('E.DepartamentoFisico', 10)->where('E.AltaBaja', 1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getForros($SEMANA, $CONTROL, $FT) {
        try {
            $this->db->select("OP.ID, OP.ControlT AS CONTROL, OPD.Articulo AS ARTICULO_CLAVE, "
                            . "OPD.ArticuloT AS ARTICULO_DESCRIPCION, OPD.UnidadMedidaT AS UM, OPD.Pieza AS PIEZA, "
                            . "OPD.PiezaT AS PIEZA_DESCRIPCION, OPD.Grupo AS GRUPO, FORMAT(OPD.Cantidad,3) AS CANTIDAD, "
                            . "OP.ControlT AS CONTROL, OP.Semana AS SEMANA, CONCAT(96,99,100) AS FRACCION, "
                            . "OP.Pares AS PARES")
                    ->from("ordendeproduccion AS OP")
                    ->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion');
            if ($SEMANA !== '' && $CONTROL !== '') {
                $this->db->where('OP.Semana', $SEMANA)->where('OP.ControlT', $CONTROL);
            }
            $this->db->where('OPD.Grupo', 2)->where('OPD.Departamento', 10)
                    ->group_by('OPD.OrdenDeProduccion')
                    ->group_by('OP.ControlT')
                    ->group_by('OPD.Pieza')
                    ->group_by('OPD.Articulo')
                    ->group_by('OPD.UnidadMedidaT');
            if ($FT === 1 || $FT === '1') {
                $this->db->limit($this->getLimite_inicial());
            }
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTextiles($SEMANA, $CONTROL, $FT) {
        try {
            $this->db->select("OP.ID, OP.ControlT AS CONTROL, OPD.Articulo AS ARTICULO_CLAVE, "
                            . "OPD.ArticuloT AS ARTICULO_DESCRIPCION, OPD.UnidadMedidaT AS UM, OPD.Pieza AS PIEZA, "
                            . "OPD.PiezaT AS PIEZA_DESCRIPCION, OPD.Grupo AS GRUPO, FORMAT(OPD.Cantidad,3) AS CANTIDAD, "
                            . "OP.ControlT AS CONTROL, OP.Semana AS SEMANA, CONCAT(96,99,100) AS FRACCION, "
                            . "OP.Pares AS PARES")
                    ->from("ordendeproduccion AS OP")
                    ->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion');
            if ($SEMANA !== '' && $CONTROL !== '') {
                $this->db->where('OP.Semana', $SEMANA)->where('OP.ControlT', $CONTROL);
            }
            $this->db->where('OPD.Grupo', 34)->where('OPD.Departamento', 10)
                    ->group_by('OPD.OrdenDeProduccion')
                    ->group_by('OP.ControlT')
                    ->group_by('OPD.Pieza')
                    ->group_by('OPD.Articulo')
                    ->group_by('OPD.UnidadMedidaT');
            if ($FT === 1 || $FT === '1') {
                $this->db->limit($this->getLimite_inicial());
            }
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSinteticos($SEMANA, $CONTROL, $FT) {
        try {
            $this->db->select("OP.ID, OP.ControlT AS CONTROL, OPD.Articulo AS ARTICULO_CLAVE, "
                            . "OPD.ArticuloT AS ARTICULO_DESCRIPCION, OPD.UnidadMedidaT AS UM, OPD.Pieza AS PIEZA, "
                            . "OPD.PiezaT AS PIEZA_DESCRIPCION, OPD.Grupo AS GRUPO, FORMAT(OPD.Cantidad,3) AS CANTIDAD, "
                            . "OP.ControlT AS CONTROL, OP.Semana AS SEMANA, CONCAT(96,99,100) AS FRACCION, "
                            . "OP.Pares AS PARES")
                    ->from("ordendeproduccion AS OP")
                    ->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion');
            if ($SEMANA !== '' && $CONTROL !== '') {
                $this->db->where('OP.Semana', $SEMANA)->where('OP.ControlT', $CONTROL);
            }
            $this->db->where('OPD.Grupo', 40)->where('OPD.Departamento', 10)
                    ->group_by('OPD.OrdenDeProduccion')
                    ->group_by('OP.ControlT')
                    ->group_by('OPD.Pieza')
                    ->group_by('OPD.Articulo')
                    ->group_by('OPD.UnidadMedidaT');
            if ($FT === 1 || $FT === '1') {
                $this->db->limit($this->getLimite_inicial());
            }
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getExplosionXSemanaControlFraccionArticulo($SEMANA, $CONTROL, $FRACCION, $ARTICULO, $GRUPO) {
        try {
            $this->db->select("SUM(OPD.Cantidad) AS EXPLOSION")
                    ->from("ordendeproduccion AS OP")
                    ->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion')
                    ->join('fraccionesxestilo AS FXE', 'OP.Estilo = FXE.Estilo')
                    ->join('fracciones AS F', 'FXE.Fraccion = F.Clave');
            if ($SEMANA !== '' && $CONTROL !== '') {
                $this->db->where('OP.Semana', $SEMANA)->where('OP.ControlT', $CONTROL);
            }
            if ($FRACCION !== '') {
                $this->db->where('FXE.Fraccion', $FRACCION);
            }
            return $this->db->where('F.Departamento', 10)
                            ->where('OPD.Articulo', $ARTICULO)
                            ->where('OPD.Grupo', $GRUPO)
                            ->group_by('OPD.Articulo')
                            ->group_by('OPD.UnidadMedida')->get()->result();
            
//            SELECT SUM(OPD.Cantidad) AS EXPLOSION FROM ordendeproduccion AS OP 
//                    INNER JOIN ordendeproduccion AS OP 
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida($S) {
        try {
            return $this->db->select("COUNT(*) AS Semana")->from("semanasproduccion AS S")->where("S.Sem", $S)->where("S.Estatus", "ACTIVO")->order_by('S.Sem', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onObtenerPrecioMaquila($ARTICULO) {
        try {
            return $this->db->select("PM.Precio AS PRECIO_MAQUILA_UNO")->from("preciosmaquilas AS PM")->where("PM.Articulo LIKE '$ARTICULO'", null, false)
                            ->where("PM.Maquila", 1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarEntrega($SEMANA, $CONTROL, $ARTICULO, $FRACCION) {
        try {
            return $this->db->select("A.*")
                            ->from("asignapftsacxc AS A")
                            ->where('A.Empleado', 0)
                            ->where('A.Articulo LIKE \'' . $ARTICULO . '\' AND A.Semana LIKE  \'' . $SEMANA . '\' AND A.Control LIKE \'' . $CONTROL . '\' AND A.Fraccion LIKE \'' . $FRACCION . '\' ', null, false)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onObtenerUltimoRegreso($ID) {
        try {
            return $this->db->select("A.Devolucion AS REGRESO")->from("asignapftsacxc AS A")->where('A.ID', $ID)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarMovArt($array) {
        try {
            $this->db->insert("movarticulos", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
