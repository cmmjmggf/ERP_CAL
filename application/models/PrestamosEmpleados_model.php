<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class PrestamosEmpleados_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getEmpleados() {
        try {
            return $this->db->select("E.Numero AS CLAVE, "
                                    . "CONCAT(E.Numero,' ', E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS EMPLEADO")
                            ->from("empleados AS E")->where('E.AltaBaja', 1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadosEnPagares() {
        try {
            return $this->db->select("E.Numero AS CLAVE, "
                                    . "CONCAT(E.Numero,' ', E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS EMPLEADO")
                            ->from("empleados AS E")->join('prestamos AS P', 'E.Numero = P.numemp')
                            ->where('E.AltaBaja', 1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrestamos($EMPLEADO) {
        try {
            $this->db->select("P.ID AS ID,P.numemp AS EMPLEADO, P.nomemp, "
                            . "P.pagare AS PAGARE,P.sem AS SEM, DATE_FORMAT(P.fechapre,\"%d/%m/%Y\") AS FECHA, "
                            . "P.preemp AS PRESTAMO, P.aboemp AS ABONO, P.salemp, "
                            . "P.pesos,P.fecpag,P.sempag")
                    ->from("prestamos AS P");
            if ($EMPLEADO !== '') {
                $this->db->where('P.numemp', $EMPLEADO);
            }
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrestamosConsulta($PAGARE, $FECHA, $EMPLEADO) {
        try {
            $this->db->select("P.ID AS ID,P.numemp AS EMPLEADO, P.nomemp, "
                            . "P.pagare AS PAGARE,P.sem AS SEM, DATE_FORMAT(P.fechapre,\"%d/%m/%Y\") AS FECHA, "
                            . "P.preemp AS PRESTAMO, P.aboemp AS ABONO, P.salemp, "
                            . "P.pesos,P.fecpag,P.sempag")
                    ->from("prestamos AS P");
            if ($FECHA !== '') {
                $this->db->where("DATE_FORMAT(P.fechapre,\"%d/%m/%Y\") =  \"{$FECHA}\" ", null, false);
            }
            if ($PAGARE !== '') {
                $this->db->where('P.pagare', $PAGARE);
            }
            if ($EMPLEADO !== '') {
                $this->db->where('P.numemp', $EMPLEADO);
            }
            if ($PAGARE === '' && $FECHA === '') {
                $this->db->limit(900);
            }
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrestamosPagos($EMPLEADO) {
        try {
            $this->db->select("PP.ID AS ID, PP.numemp AS EMPLEADO, PP.año, "
                            . "PP.sem AS SEM, DATE_FORMAT(PP.fecha,\"%d/%m/%Y\") AS FECHA, PP.preemp, "
                            . "PP.aboemp AS ABONO, PP.saldoemp, PP.interes AS INTERES, "
                            . "PP.status AS ESTATUS")
                    ->from("prestamospag AS PP");
            if ($EMPLEADO !== '') {
                $this->db->where('PP.numemp', $EMPLEADO);
            }
            $this->db->order_by('PP.fecha', 'DESC');
            if ($EMPLEADO === '') {
                $this->db->limit(20);
            }
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInformacionSemana($Fecha) {
        try {
            return $this->db->select("S.ID ID, S.Ano ANIO, S.Sem AS SEMANA, "
                                    . "S.FechaIni AS FECHA_INICIO, S.FechaFin AS FECHA_FIN", false)
                            ->from('semanasnomina AS S')
                            ->where("str_to_date('$Fecha','%d/%m/%Y') BETWEEN str_to_date(FechaIni, '%d/%m/%Y') AND  str_to_date(FechaFin, '%d/%m/%Y')", null, false)
                            ->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
