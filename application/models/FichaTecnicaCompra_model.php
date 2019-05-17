<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class FichaTecnicaCompra_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function getDatosEmpresa() {
        try {
            $this->db->select("E.RazonSocial as Empresa, E.Foto as Logo "
                            . " ", false)
                    ->from('empresas AS E')
                    ->where('Estatus', 'ACTIVO');

            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEncabezadoFT($Estilo, $Color) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("FXE.Estilo AS ESTILO,"
                            . "L.CLAVE AS CLINEA, L.DESCRIPCION AS DLINEA, "
                            . "C.CLAVE AS CCOLOR, C.DESCRIPCION AS DCOLOR   "
                            . " ", false)
                    ->from('fichatecnica AS FXE')
                    ->join('estilos AS E', 'ON E.Clave = FXE.Estilo')
                    ->join('lineas AS L', 'ON L.Clave = E.Linea')
                    ->join('colores AS C', 'ON C.Clave = FXE.Color AND C.Estilo = FXE.Estilo')
                    ->where('FXE.Estilo', $Estilo)
                    ->where('FXE.Color', $Color)
                    ->group_by(array('FXE.Estilo', 'E.Descripcion'));

            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGruposFT($Estilo, $Color) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(G.Clave AS SIGNED ) AS CGRUPO , G.Nombre AS DGRUPO, P.Departamento AS CDEPTO "
                            . " ", false)
                    ->from('fichatecnica FT')
                    ->join('articulos AS A', 'ON A.Clave = FT.Articulo')
                    ->join('grupos AS G', 'ON G.Clave =  A.Grupo')
                    ->join('piezas AS P', 'ON P.Clave =  FT.Pieza')
                    ->where('FT.Estilo', $Estilo)
                    ->where('FT.Color', $Color)
                    ->group_by(array('P.Departamento', 'G.Clave'))
                    ->order_by('CDEPTO', 'ASC')
                    ->order_by('CGRUPO', 'ASC');


            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDeptosFT($Estilo, $Color) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(D.Clave AS SIGNED ) AS CDEPTO , D.Descripcion AS DDEPTO "
                            . " ", false)
                    ->from('fichatecnica FT')
                    ->join('piezas AS P', 'ON P.Clave = FT.Pieza')
                    ->join('departamentos AS D', 'ON D.Clave = P.Departamento')
                    ->where('FT.Estilo', $Estilo)
                    ->where('FT.Color', $Color)
                    ->group_by(array('D.Clave'))
                    ->order_by('CDEPTO', 'ASC');


            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFichaTecnicaDetalleByID($Estilo, $Color, $Maquila, $Desperdicio) {
        try {
            $this->db->select('
              CAST(G.Clave AS SIGNED ) AS CGRUPO,
                CAST(D.Clave AS SIGNED ) AS CDEPTO,
CAST(FT.Pieza AS SIGNED ) AS CPIEZA,
P.Descripcion AS DPIEZA,
CAST(FT.Articulo AS SIGNED ) AS CMATERIAL,
A.Descripcion AS DMATERIAL,
U.Descripcion AS UNIDAD,
PM.Precio AS PRECIO,
FT.Consumo AS CONSUMO,
FT.Consumo *  PM.Precio AS COSTO,

CASE WHEN G.Clave IN (1,2)
THEN
FT.Consumo + (FT.Consumo * \'' . $Desperdicio . '\')
ELSE
FT.Consumo
END AS CONSUMO_COSTO,

CASE WHEN G.Clave IN (1,2)
THEN
FT.Consumo *  PM.Precio + ((FT.Consumo *  PM.Precio) * \'' . $Desperdicio . '\')
ELSE
FT.Consumo *  PM.Precio
END AS DESPERDICIO
', false)
                    ->from('fichatecnica AS FT')
                    ->join('piezas AS P', 'P.Clave = FT.Pieza')
                    ->join('departamentos AS D', 'D.Clave = P.Departamento')
                    ->join('articulos AS A', 'A.Clave = FT.Articulo')
                    ->join('grupos AS G', 'G.Clave =  A.Grupo')
                    ->join('unidades AS U', 'U.Clave =  A.UnidadMedida')
                    ->join('preciosmaquilas AS PM', 'ON PM.Articulo = FT.Articulo AND PM.Maquila = \'' . $Maquila . '\' ')
                    ->where('FT.Estilo', $Estilo)
                    ->where('FT.Color', $Color)
                    ->order_by('CDEPTO', 'ASC')
                    ->order_by('CGRUPO', 'ASC')
                    ->order_by('A.Descripcion', 'ASC')
                    ->order_by('CPIEZA', 'ASC');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getManoObra($Estilo) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(D.Clave AS SIGNED ) AS CDEPTO, D.Descripcion AS DDEPTO,SUM(FXE.CostoMO) AS COSTOMO  "
                            . " ", false)
                    ->from('fraccionesxestilo  FXE')
                    ->join('fracciones AS F', 'ON FXE.Fraccion = F.Clave')
                    ->join('departamentos AS D', 'ON F.Departamento =  D.Clave')
                    ->where('FXE.Estilo', $Estilo)
                    ->where('FXE.AfectaCostoVTA', '1')
                    ->group_by(array('DDEPTO'))
                    ->order_by('CDEPTO', 'ASC');


            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
