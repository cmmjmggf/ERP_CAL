<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class AvanceProduccionEnPantalla extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion')->view('vFondo')->view('vAvanceProduccionEnPantalla')->view('vFooter');
                    break;
            }
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getAvances() {
        try {
            $x = $this->input->get();
            $this->db->select("PE.Clave AS PEDIDO, PE.Control AS CONTROL, 
              DATE_FORMAT(
              str_to_date(PE.FechaProg,'%Y-%m-%d'), \"%d/%m/%Y\") FECHA_PROGAMACION, 
               CONCAT(PE.stsavan,\" \",( CASE
WHEN (PE.stsavan  = 1) THEN 'Programado'
WHEN (PE.stsavan = 2) THEN 'Corte'  
WHEN (PE.stsavan = 3) THEN 'Rayado'
WHEN (PE.stsavan = 33) THEN 'Rebajado'
WHEN (PE.stsavan = 4) THEN 'Foleado'
WHEN (PE.stsavan = 40) THEN 'Entretelado'
WHEN (PE.stsavan = 42) THEN 'Proceso Maq'
WHEN (PE.stsavan = 44) THEN 'Alm-Corte'
WHEN (PE.stsavan = 5) THEN 'Pespunte'
WHEN (PE.stsavan = 55) THEN 'Ensuelado'
WHEN (PE.stsavan = 6) THEN 'Alm-Pespu'
WHEN (PE.stsavan = 7) THEN 'Tejido'
WHEN (PE.stsavan = 8) THEN 'Alm-Tejido'
WHEN (PE.stsavan = 9) THEN 'Montado'
WHEN (PE.stsavan = 10) THEN 'Adorno'
WHEN (PE.stsavan = 11) THEN 'Alm-Adorno'
WHEN (PE.stsavan = 12) THEN 'Prd-Termi'
END)) AS CLAVE_DEPARTAMENTO_AVANCE,
DATE_FORMAT(
               CASE 
               WHEN (PE.stsavan  = 1) THEN str_to_date(PE.FechaProg,'%Y-%m-%d') 
               WHEN (PE.stsavan = 2) THEN A.fec2 
               WHEN (PE.stsavan = 3) THEN A.fec3 
               WHEN (PE.stsavan = 33) THEN A.fec33 
               WHEN (PE.stsavan = 4) THEN A.fec4 
               WHEN (PE.stsavan = 40) THEN A.fec40 
               WHEN (PE.stsavan = 42) THEN A.fec42 
               WHEN (PE.stsavan = 44) THEN A.fec44 
               WHEN (PE.stsavan = 5) THEN A.fec5 
               WHEN (PE.stsavan = 55) THEN A.fec55 
               WHEN (PE.stsavan = 6) THEN A.fec6 
               WHEN (PE.stsavan = 7) THEN A.fec7 
               WHEN (PE.stsavan = 8) THEN A.fec8 
               WHEN (PE.stsavan = 9) THEN A.fec9 
               WHEN (PE.stsavan = 10) THEN A.fec10 
               WHEN (PE.stsavan = 11) THEN A.fec11 
               WHEN (PE.stsavan = 12) THEN A.fec12 
               END, \"%d/%m/%Y\") AS FECHA_ENTRO, 
                                CASE
                 WHEN (PE.stsavan  = 1) THEN 'Programado'
                 WHEN (PE.stsavan = 2) THEN 'Corte'  
                 WHEN (PE.stsavan = 3) THEN 'Rayado'
                 WHEN (PE.stsavan = 33) THEN 'Rebajado'
                 WHEN (PE.stsavan = 4) THEN 'Foleado'
                 WHEN (PE.stsavan = 40) THEN 'Entretelado'
                 WHEN (PE.stsavan = 42) THEN 'Proceso Maq'
                 WHEN (PE.stsavan = 44) THEN 'Alm-Corte'
                 WHEN (PE.stsavan = 5) THEN 'Pespunte'
                 WHEN (PE.stsavan = 55) THEN 'Ensuelado'
                 WHEN (PE.stsavan = 6) THEN 'Alm-Pespu'
                 WHEN (PE.stsavan = 7) THEN 'Tejido'
                 WHEN (PE.stsavan = 8) THEN 'Alm-Tejido'
                 WHEN (PE.stsavan = 9) THEN 'Montado'
                 WHEN (PE.stsavan = 10) THEN 'Adorno'
                 WHEN (PE.stsavan = 11) THEN 'Alm-Adorno'
                 WHEN (PE.stsavan = 12) THEN 'Prd-Termi'
                 END AS nombreDepto,
                (CASE
                WHEN PE.stsavan = 1 THEN 1
                WHEN PE.stsavan = 2 THEN 2
                WHEN PE.stsavan = 3 THEN 3
                WHEN PE.stsavan = 33 THEN 4
                WHEN PE.stsavan = 4 THEN 5
                WHEN PE.stsavan = 40 THEN 6
                WHEN PE.stsavan = 42 THEN 7
                WHEN PE.stsavan = 44 THEN 8
                WHEN PE.stsavan = 5 THEN 9
                WHEN PE.stsavan = 55 THEN 10
                WHEN PE.stsavan = 6 THEN 11
                WHEN PE.stsavan = 7 THEN 12
                WHEN PE.stsavan = 8 THEN 13
                WHEN PE.stsavan = 9 THEN 14
                WHEN PE.stsavan = 10 THEN 15
                WHEN PE.stsavan = 11 THEN 16
                WHEN PE.stsavan = 12 THEN 17
                WHEN PE.stsavan = 13 THEN 18
                END)  AS DEPTO_N,
                now() AS fecActual, 
                DATEDIFF(NOW(), CASE 
               WHEN (PE.stsavan  = 1) THEN str_to_date(PE.FechaProg,'%Y-%m-%d') 
               WHEN (PE.stsavan = 2) THEN A.fec2 
               WHEN (PE.stsavan = 3) THEN A.fec3 
               WHEN (PE.stsavan = 33) THEN A.fec33 
               WHEN (PE.stsavan = 4) THEN A.fec4 
               WHEN (PE.stsavan = 40) THEN A.fec40 
               WHEN (PE.stsavan = 42) THEN A.fec42 
               WHEN (PE.stsavan = 44) THEN A.fec44 
               WHEN (PE.stsavan = 5) THEN A.fec5 
               WHEN (PE.stsavan = 55) THEN A.fec55 
               WHEN (PE.stsavan = 6) THEN A.fec6 
               WHEN (PE.stsavan = 7) THEN A.fec7 
               WHEN (PE.stsavan = 8) THEN A.fec8 
               WHEN (PE.stsavan = 9) THEN A.fec9 
               WHEN (PE.stsavan = 10) THEN A.fec10 
               WHEN (PE.stsavan = 11) THEN A.fec11 
               WHEN (PE.stsavan = 12) THEN A.fec12 
               END) AS DIAS, 
               
               DATEDIFF(NOW(), str_to_date(PE.FechaProg,'%Y-%m-%d')) AS DIAS_PROG, 

CAST(PE.Pares AS DECIMAL(5,2)) AS PARES,
CAST(IFNULL(PE.ParesFacturados,0) AS decimal(5,2)) AS PARES_FACTURADOS,
CAST(IFNULL(PE.Pares,0) AS SIGNED) - CAST(IFNULL(PE.ParesFacturados,0) AS SIGNED) AS SALDO_PARES,
E.GdoDif,
CASE
WHEN E.Herramental = '1' THEN '1 PATRÓN BASE'
WHEN E.Herramental = '2' THEN '2 CARTÓN BASE'
WHEN E.Herramental = '3' THEN '3 TESEO'
WHEN E.Herramental = '4' THEN '4 SUAJE'
WHEN E.Herramental = '5' THEN '5 SUA-ORI'
ELSE 'N/E'
END AS Herramental,

CASE
WHEN  (PE.stsavan = 7) THEN
IFNULL((
select EM.Busqueda from fracpagnomina FPN
JOIN empleados EM ON EM.Numero = FPN.numeroempleado
WHERE FPN.depto = 150 and FPN.numfrac = 401 and FPN.control = PE.Control
limit 1 ),'')

WHEN  (PE.stsavan = 5) THEN
IFNULL((
SELECT  CASE WHEN av.pespunte <> 5 THEN E.Busqueda ELSE '' END AS empleado
FROM avaprd av
JOIN empleados E ON E.Numero = av.pespunte
WHERE av.contped = PE.Control
limit 1 ),'')

WHEN  (PE.stsavan = 42) THEN
IFNULL((
SELECT mp.descripcion FROM controlpla cp
JOIN maquilasplantillas mp ON mp.clave = cp.tipo
WHERE cp.control = pe.control
ORDER BY cp.id DESC 
LIMIT 1
 ),'')

WHEN  (PE.stsavan = 55) THEN
IFNULL((
SELECT
CASE
WHEN cp.estatus = '1' THEN cp.FraccionT
WHEN cp.estatus = '2' THEN 'PARA CIUCANI'
ELSE ''
END AS Pegado
FROM controlpla cp
WHERE cp.control = pe.control AND cp.Fraccion = 502
ORDER BY cp.id DESC
LIMIT 1
 ),'')
ELSE ''
END AS Empleado,


(CASE
WHEN pe.AsignadoPegado = 2 AND PE.stsavan = 55 THEN
     'PARA TEJIDO'
WHEN pe.AsignadoPegado = 1 AND PE.stsavan = 55 THEN
     CASE WHEN (SELECT COUNT(*) FROM fracpagnomina WHERE numfrac = 502 AND control = pe.control) > 0 THEN 'PARA CIUCANI'
     ELSE 'PEGADO DE SUELA' END
WHEN pe.AsignadoPegado = 0 AND PE.stsavan = 55 THEN
  CASE WHEN (SELECT COUNT(*) FROM fracpagnomina WHERE numfrac = 502 AND control = pe.control) > 0 THEN 'PARA CIUCANI'
     ELSE '' END
END)
AS CiucaniInterno,


IFNULL(L.Descripcion,'N/E') AS LINEA,
PE.Estilo AS ESTILO,
PE.ColorT AS COLOR,
CONCAT(PE.Cliente,\" \",IFNULL(CT.RazonS ,'N/E')) AS CLIENTE,
IFNULL(CT.RazonS ,'N/E') AS ClienteNombre,
date_format(str_to_date(PE.FechaEntrega,'%d/%m/%Y'),'%d/%m/%y') AS FECHA_ENTREGA,
PR.semana,
PR.diaprg,
E.Foto AS FOTO, 
(select sum(CantidadMov) from movarticulos WHERE control = PE.Control and tposuplen = 1) AS suela", false)->from("pedidox PE")
                    ->join("avaprd A", "A.contped = PE.control", "left")
                    ->join("estilos E", "E.Clave = PE.Estilo", "left")
                    ->join("lineas L", "L.clave = E.Linea", "left")
                    ->join("clientes CT", "CT.Clave = PE.Cliente", "left")
                    ->join("programacion PR", "PR.control = PE.control  AND PR.frac = 100", "left")
                    ->where_not_in("PE.stsavan", array(0, 13, 14));
            if ($x['MAQUILA_INICIAL'] !== '' && $x['MAQUILA_FINAL'] !== '' &&
                    $x['SEMANA_INICIAL'] !== '' && $x['SEMANA_FINAL'] !== '' &&
                    $x['ANIO'] !== '') {
                $this->db->where("CAST(PE.maquila AS SIGNED) BETWEEN {$x['MAQUILA_INICIAL']} AND {$x['MAQUILA_FINAL']}
                AND CAST(PE.semana AS SIGNED) BETWEEN {$x['SEMANA_INICIAL']} AND {$x['SEMANA_FINAL']} 
                AND PE.ano ={$x['ANIO']}", null, false);
            } else {
                $this->db->where("PE.maquila", 1234567890);
            }
            if ($x['DEPARTAMENTO_AVANCE'] !== '' && intval($x['DEPARTAMENTO_AVANCE']) > 0) {
                $this->db->where("PE.stsavan", $x['DEPARTAMENTO_AVANCE']);
            }
            $data = $this->db->order_by("DEPTO_N", "ASC")
                            ->order_by("PE.Control", "ASC")->get()->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}