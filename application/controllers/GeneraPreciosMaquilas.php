<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class GeneraPreciosMaquilas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function onGeneraPreciosMaquilas() {
        $txtestilo = $this->input->post('Estilo');
        $txtcolor = $this->input->post('Color');
        $txtaño = $this->input->post('Ano');
        $txtsemana = $this->input->post('Sem');

        if ($txtestilo !== '' && $txtcolor !== '') {//Genera por estilo
            $this->db->query("delete from listapreciosmaquilas where Maq = 1 and estilo = '$txtestilo' and color = $txtcolor ");
            $Estilo = $this->db->query("select e.clave as estilo , e.linea,
                            CASE
                            WHEN e.PiezasCorte <= 10 THEN m.PorExtra3a10
                            WHEN e.PiezasCorte > 10 AND e.PiezasCorte <= 14 THEN m.PorExtra11a14
                            WHEN e.PiezasCorte > 14 AND e.PiezasCorte <= 18 THEN m.PorExtra15a18
                            WHEN e.PiezasCorte > 18  THEN m.PorExtra19a END AS PorcenDesperd
                            from estilos e
                            join maquilas m on m.Clave = 1
                            where e.clave = '$txtestilo'  ")->result();
            if (!empty($Estilo)) {
                //Si existe consultamos su ficha tecnica
                $porcentajeDesp = $Estilo[0]->PorcenDesperd;
                $Linea = $Estilo[0]->linea;
                $FichaTecnica = $this->db->query("select ft.articulo, ft.consumo, a.grupo, pm.precio
                                            from fichatecnica ft
                                            join articulos a on a.clave  = ft.articulo
                                            join preciosmaquilas pm on pm.Articulo = a.clave and pm.maquila = 1
                                            where ft.estilo = '$txtestilo' and ft.color = '$txtcolor' and ft.afectapv = 0
                                            order by abs(a.grupo) asc ")->result();
                $txtmaprpt = 0;
                $total = 0;
                foreach ($FichaTecnica as $key => $F) {
                    $precio = floatval($F->precio);
                    $grupo = $F->grupo;
                    $consumo = floatval($F->consumo);
                    if (intval($grupo) < 3) {
                        $txtdesper = floatval($consumo) * floatval($porcentajeDesp);
                        $txtconsumocondesper = floatval($txtdesper) + floatval($consumo);
                        $txtmaprpt = floatval($precio) * floatval($txtconsumocondesper);
                    } else {
                        $txtmaprpt = floatval($consumo) * floatval($precio);
                    }
                    $total = $total + $txtmaprpt;
                }
                // Sacamos su mano de obra
                $ManoObra = $this->db->query("select sum(CostoMO) as manoobra "
                                . "from fraccionesxestilo "
                                . "where estilo = '$txtestilo' and AfectaCostoVTA = 1; ")->result()[0]->manoobra;

                $Precio = floatval($ManoObra) + floatval($total);
                //Guardamos el registro
                $this->db->insert("listapreciosmaquilas", array(
                    'Maq' => 1,
                    'Linea' => $Linea,
                    'Estilo' => $txtestilo,
                    'Color' => $txtcolor,
                    'Corrida' => 8888,
                    'PrecioVta' => $Precio,
                    'Sem' => 0
                ));
            } else {//No existe estilo
                print 0;
            }
        } else if ($txtaño !== '' && $txtsemana !== '') {//Genera por semana
            $Pedidos = $this->db->query("select estilo, color from pedidox where maquila = 1 and semana = $txtsemana and ano=$txtaño and stsavan not in(14) "
                            . " group by estilo, color"
                            . " order by estilo, color asc ")->result();
            if (!empty($Pedidos)) {
                foreach ($Pedidos as $key => $P) {
                    $txtestilo = $P->estilo;
                    $txtcolor = $P->color;
                    $this->db->query("delete from listapreciosmaquilas where Maq = 1 and estilo = '$txtestilo' and color = $txtcolor ");
                    $Estilo = $this->db->query("select e.clave as estilo , e.linea,
                            CASE
                            WHEN e.PiezasCorte <= 10 THEN m.PorExtra3a10
                            WHEN e.PiezasCorte > 10 AND e.PiezasCorte <= 14 THEN m.PorExtra11a14
                            WHEN e.PiezasCorte > 14 AND e.PiezasCorte <= 18 THEN m.PorExtra15a18
                            WHEN e.PiezasCorte > 18  THEN m.PorExtra19a END AS PorcenDesperd
                            from estilos e
                            join maquilas m on m.Clave = 1
                            where e.clave = '$txtestilo'  ")->result();
                    if (!empty($Estilo)) {
                        //Si existe consultamos su ficha tecnica
                        $porcentajeDesp = $Estilo[0]->PorcenDesperd;
                        $Linea = $Estilo[0]->linea;
                        $FichaTecnica = $this->db->query("select ft.articulo, ft.consumo, a.grupo, pm.precio
                                            from fichatecnica ft
                                            join articulos a on a.clave  = ft.articulo
                                            join preciosmaquilas pm on pm.Articulo = a.clave and pm.maquila = 1
                                            where ft.estilo = '$txtestilo' and ft.color = '$txtcolor' and ft.afectapv = 0
                                            order by abs(a.grupo) asc ")->result();
                        $txtmaprpt = 0;
                        $total = 0;
                        foreach ($FichaTecnica as $key => $F) {
                            $precio = floatval($F->precio);
                            $grupo = $F->grupo;
                            $consumo = floatval($F->consumo);
                            if (intval($grupo) < 3) {
                                $txtdesper = floatval($consumo) * floatval($porcentajeDesp);
                                $txtconsumocondesper = floatval($txtdesper) + floatval($consumo);
                                $txtmaprpt = floatval($precio) * floatval($txtconsumocondesper);
                            } else {
                                $txtmaprpt = floatval($consumo) * floatval($precio);
                            }
                            $total = $total + $txtmaprpt;
                        }
                        // Sacamos su mano de obra
                        $ManoObra = $this->db->query("select sum(CostoMO) as manoobra "
                                        . "from fraccionesxestilo "
                                        . "where estilo = '$txtestilo' and AfectaCostoVTA = 1; ")->result()[0]->manoobra;

                        $Precio = floatval($ManoObra) + floatval($total);
                        //Guardamos
                        $this->db->insert("listapreciosmaquilas", array(
                            'Maq' => 1,
                            'Linea' => $Linea,
                            'Estilo' => $txtestilo,
                            'Color' => $txtcolor,
                            'Corrida' => 8888,
                            'PrecioVta' => $Precio,
                            'Sem' => 0
                        ));
                    }
                }
            } else {
                print 1;
            }
        }
    }

    public function onComprobarEstiloColor() {
        try {
            print json_encode($this->db->select("clave as color, estilo")
                                    ->from("colores")
                                    ->where("Estatus", "ACTIVO")
                                    ->where('Clave', $this->input->get('Color'))
                                    ->where('Estilo', $this->input->get('Estilo'))
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
            print json_encode($this->db->select("CAST(C.Clave AS SIGNED ) AS ID, C.Descripcion AS Descripcion ", false)
                                    ->from('colores AS C')
                                    ->where('C.Estilo', $this->input->get('Estilo'))
                                    ->where('C.Estatus', 'ACTIVO')
                                    ->order_by('ID', 'ASC')
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilos() {
        try {
            print json_encode($this->db->select("E.Clave AS Clave, E.Descripcion AS Estilo")
                                    ->from("estilos AS E")
                                    ->where("E.Estatus", "ACTIVO")
                                    ->order_by('Clave', 'ASC')
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
