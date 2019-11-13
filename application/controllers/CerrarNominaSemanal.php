<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class CerrarNominaSemanal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function onCerrarNomina() {
        $x = $this->input;
        $sem = $x->post('SemCierraNomina');
        $ano = $x->post('AnoCierraNomina');
        $valida = 0;

        if (intval($sem) > 54) {//Si es de vacaciones y aguinaldo 98,99
            $query_prenominal = "update prenominal set status = 2 where año =  $ano and numsem = $sem ";
            $this->db->query($query_prenominal);

            $query_prenomina = "update prenomina set status = 2 where año =  $ano and numsem = $sem ";
            $this->db->query($query_prenomina);
        } else {
            //Actualizamos prestamos a estatus 2
            $query_prestamos = "update prestamospag set status = 2 where año =  $ano and sem = $sem ";
            $this->db->query($query_prestamos);

            //Actualizamos prenominal
            $query_prenominal = "update prenominal set status = 2 where año =  $ano and numsem = $sem ";
            $this->db->query($query_prenominal);

            /*             * ************PRESTAMOS *************** */
            //Obtenemos el personal con prestamos
            $query_personal_prestamos = "SELECT numemp FROM prenomina where año = $ano and numsem = $sem and numcon = 65 order by numemp;";
            $Prestamos = $this->db->query($query_personal_prestamos)->result();

            if (!empty($Prestamos)) {
                //Iteramos en los registros para hacer el insert/update
                foreach ($Prestamos as $M) {
                    $numemp = $M->numemp;
                    $query_camposEmpleado = "SELECT AbonoPres,SaldoPres FROM empleados  WHERE numero  = $numemp ";
                    $Empleado = $this->db->query($query_camposEmpleado)->result();

                    $saldo = 0;
                    //Si e saldo del prestamo ya es menor al abono actualizamos a 0
                    if (floatval($Empleado[0]->SaldoPres) < floatval($Empleado[0]->AbonoPres)) {
                        //Como ya valida que es el ultimo abono siendo menor al saldo , pone todo en 0's
                        $this->db->query("update empleados set PressAcum = 0,SaldoPres = 0,AbonoPres = 0 where numero =  $numemp ");
                    } else {//si no ponemos el saldo actual menos el abono de la semana
                        $saldo = floatval($Empleado[0]->SaldoPres) - floatval($Empleado[0]->AbonoPres);
                        $this->db->query("update empleados set SaldoPres = $saldo where numero =  $numemp ");
                    }
                }
            }
            /*             * ************ZAPATOS TIENDA Y UNIFORMES *************** */
            //Obtenemos el personal con prestamos
            $query_personal_zaptda = "SELECT Numero,ZapatosTDA,AbonoZap FROM empleados where  ZapatosTDA >0 order by numero;";
            $PersonalZapTda = $this->db->query($query_personal_zaptda)->result();

            if (!empty($PersonalZapTda)) {
                //Iteramos en los registros para hacer el insert/update
                foreach ($PersonalZapTda as $P) {
                    $numempzt = $P->Numero;
                    $zaptda = $P->ZapatosTDA;
                    $zaptdat = $P->AbonoZap;

                    if (intval($zaptdat) === 1) {//Si es el último pago actualiza todo a 0
                        $this->db->query("update empleados set ZapatosTDA = 0 , AbonoZap= 0   where numero =  $numempzt ");
                    } else if (intval($zaptdat) > 1) {//Si hay mas abonos recalcula el saldo y descuenta un pago
                        $importe = floatval($zaptda) / floatval($zaptdat);
                        $saldo = floatval($zaptda) - $importe;
                        $abonos = floatval($zaptdat) - 1;
                        $this->db->query("update empleados set ZapatosTDA = $saldo , AbonoZap= $abonos   where numero =  $numempzt ");
                    }
                }
            }
            /*             * ************FIERABONOS *************** */
            //Obtenemos el personal con prestamos
            $query_personal_fierabono = "SELECT Numero,Fierabono,FieraBonoPagos FROM empleados where  Fierabono >0 order by numero;";
            $Personalfierabono = $this->db->query($query_personal_fierabono)->result();

            if (!empty($Personalfierabono)) {
                //Iteramos en los registros para hacer el insert/update
                foreach ($Personalfierabono as $P) {
                    $numempzt = $P->Numero;
                    $fierabono = $P->Fierabono;
                    $fierabonopagos = $P->FieraBonoPagos;

                    if (intval($fierabonopagos) === 1) {//Si es el último pago actualiza todo a 0
                        $this->db->query("update empleados set Fierabono = 0 , FieraBonoPagos= 0   where numero =  $numempzt ");
                    } else if (intval($fierabonopagos) > 1) {//Si hay mas abonos recalcula el saldo y descuenta un pago
                        $importe = floatval($fierabono) / floatval($fierabonopagos);
                        $saldo = floatval($fierabono) - $importe;
                        $abonos = floatval($fierabonopagos) - 1;
                        $this->db->query("update empleados set Fierabono = $saldo , FieraBonoPagos= $abonos   where numero =  $numempzt ");
                    }
                }
            }

            /*             * ***************** ACTUALIZA ESTATUS ************* */
            //Actualizamos toda la prenomina A STATUS 2 si todo OK si no mandamos a cliente error
            $this->db->query("update prenomina set status = 2 where año =  $ano and numsem = $sem ");
        }
    }

}
