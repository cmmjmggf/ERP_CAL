<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class GenerarCostosFabricacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('GenerarCostosFabricacion_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $Seguridad = isset($_SESSION["SEG"]) ? $_SESSION["SEG"] : '0';
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vFondo');

                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas');
                    } else if ($Origen === 'NOMINAS') {
                        $this->load->view('vMenuNominas');
                    } else if ($Origen === 'MATERIALES') {
                        $this->load->view('vMenuMateriales');
                    } else if ($Origen === 'PRODUCCION') {
                        $this->load->view('vMenuProduccion');
                    } else {
                        $this->load->view('vMenuPrincipal');
                    }

                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuNominas');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
            }
            $this->load->view('vGenerarCostosFabricacion');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getGastosFab() {
        try {
            print json_encode($this->db->query("select gfcte, gfpes, gftej, gfmon, gfado,
                                                (gfcte+ gfpes+ gftej+ gfmon+ gfado) as total
                                                from estilosprocesox where linea = '99999' and estilo = '99999' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->db->query("select maq, estilo, color, nomcol,
                        cast(mapcte as decimal(5,2)) as mapcte,
                        cast(mappes as decimal(5,2)) as mappes,
                        cast(maptej as decimal(5,2)) as maptej,
                        cast(mapmon as decimal(5,2)) as mapmon,
                        cast(mapado as decimal(5,2)) as mapado,
                        cast(tomap as decimal(5,2)) as tomap,
                        cast(mdocte as decimal(5,2)) as mdocte,
                        cast(mdopes as decimal(5,2)) as mdopes,
                        cast(mdotej as decimal(5,2)) as mdotej,
                        cast(mdomon as decimal(5,2)) as mdomon,
                        cast(mdoado as decimal(5,2)) as mdoado,
                        cast(tomdo as decimal(5,2)) as tomdo,
                        cast(termi as decimal(5,2)) as termi,
                        date_format(fecha,'%d/%m/%Y') as fecha
                        from estilosprocesox ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGenerarCostosInventarioProceso() {
        try {
            /* Gastos */
            $gfcorte = $this->input->get('corte');
            $gfpespu = $this->input->get('pespu');
            $gftejido = $this->input->get('tejido');
            $gfmontado = $this->input->get('montado');
            $gfadorno = $this->input->get('adorno');


            $response = array();
            $comparaft = array();
            $comparafracc = array();
            $Pedidos = $this->db->query("select
                                        pe.Maquila,
                                        pe.Estilo,
					pe.Color,
                                        pe.ColorT,
                                        (select linea from estilos where clave = pe.estilo limit 1) as Linea
                                        from pedidox pe
                                        where pe.estilo <> '0' and pe.stsavan <> 14 and pe.stsavan <> 13
					group by pe.Maquila,pe.estilo, pe.color
                                        order by abs(pe.Maquila),pe.estilo, pe.color ")->result();

            if (empty($Pedidos)) {//Si no existen salimos del método
                $response['pedidos'] = 0;
            } else {//Si existen pedidos para costear
                $estilossft = '';
                $estilossfrac = '';
                $txtprevta = 0;
                foreach ($Pedidos as $key => $v) {
                    $ncolor = $v->Color;
                    $maq = $v->Maquila;
                    $estilo = $v->Estilo;
                    $txtnomcolor = $v->ColorT;
                    $linea = $v->Linea;

                    $corte = 0;
                    $pesp = 0;
                    $teji = 0;
                    $mont = 0;
                    $ador = 0;
                    $cortef = 0;
                    $pespf = 0;
                    $tejif = 0;
                    $montf = 0;
                    $adorf = 0;
                    // ************************ Saca materia prima ********************
                    if ($maq === '1') {

                        //------------------------------Obtenemos los estilos y colores con su porcentaje de desperdicio------------------------------
                        $PorcenEstilos = $this->db->query("select
                            CASE
                            WHEN e.PiezasCorte = 1 THEN m.PorExtraXBotaAlta
                            WHEN e.PiezasCorte = 2 THEN m.PorExtraXBota
                            WHEN e.PiezasCorte > 2 AND e.PiezasCorte <= 10 THEN m.PorExtra3a10
                            WHEN e.PiezasCorte > 10 AND e.PiezasCorte <= 14 THEN m.PorExtra11a14
                            WHEN e.PiezasCorte > 14 AND e.PiezasCorte <= 18 THEN m.PorExtra15a18
                            WHEN e.PiezasCorte > 18  THEN m.PorExtra19a END AS PorcenDesperd
                            from estilos e
                            join maquilas m on m.Clave = 1
                            where e.clave = '$estilo'  ")->result();
                        $porcentajeDesp = $PorcenEstilos[0]->PorcenDesperd;

                        $FichaTecnica = $this->db->query("select ft.consumo, a.grupo, pm.precio, pi.Departamento as depto, ft.articulo
                                            from fichatecnica ft
                                            join articulos a on a.clave  = ft.articulo
                                            join preciosmaquilas pm on pm.Articulo = a.clave and pm.maquila = 1
                                            join piezas pi on pi.clave = ft.pieza
                                            where ft.estilo = '$estilo' and ft.color = '$ncolor' and ft.afectapv = 0
                                            order by abs(depto) asc ")->result();


                        if (empty($FichaTecnica)) { //No existe ficha tecnica acumula los estilos sin ficha tecnica
                            if (!in_array($estilo . '-' . $ncolor, $comparaft)) {  //Verifica si el dato ya existe en el arreglo a mostrar al usuario
                                array_push($comparaft, $estilo . '-' . $ncolor); //si no existe lo mete al arreglo de comparacion
                                $estilossft .= $estilo . '-' . $ncolor . "\n"; //Concatena el estilo color al response
                            }
                        } else {//Si existe continuamos
                            foreach ($FichaTecnica as $key => $F) {//Iteramos la ficha tecnica por cada estilo color
                                $precio = floatval($F->precio);
                                $grupo = $F->grupo;
                                $consumo = floatval($F->consumo);
                                $depto = floatval($F->depto);

                                //Sacamos los porcentajes de piel y forro
                                if (intval($grupo) < 3) {
                                    $costo1 = floatval($consumo) * floatval($porcentajeDesp);
                                    $costo2 = floatval($costo1) + floatval($consumo);
                                    $costo = floatval($precio) * floatval($costo2);
                                } else {
                                    $costo = floatval($consumo) * floatval($precio);
                                }

                                //Sacamos los acumulados por departamento para el costeo
                                if (intval($depto) >= 10 && intval($depto) <= 90) {
                                    $corte = floatval($corte) + floatval($costo);
                                }
                                if (intval($depto) >= 110 && intval($depto) <= 140) {
                                    $pesp = floatval($pesp) + floatval($costo);
                                }
                                if (intval($depto) >= 150 && intval($depto) <= 160) {
                                    $teji = floatval($teji) + floatval($costo);
                                }
                                if (intval($depto) === 180) {
                                    $mont = floatval($mont) + floatval($costo);
                                }
                                if (intval($depto) >= 210 && intval($depto) <= 240) {
                                    $ador = floatval($ador) + floatval($costo);
                                }
                            }
                        }
                        //****************************** saca Mano de Obra **************************
                        $ManoObra = $this->db->query("select (select departamento from fracciones where clave = fxe.fraccion) as depto , fxe.CostoVTA as manoobra, fxe.fraccion  "
                                        . " from fraccionesxestilo fxe where fxe.estilo = '$estilo' and fxe.AfectaCostoVTA = 1 order by abs(depto), abs(fxe.fraccion) ")->result();
                        if (empty($ManoObra)) {
                            if (!in_array($estilo, $comparafracc)) {  //Verifica si el dato ya existe en el arreglo a mostrar al usuario
                                array_push($comparafracc, $estilo); //si no existe lo mete al arreglo de comparacion
                                $estilossfrac .= $estilo . "\n"; //Concatena el estilo color al response
                            }
                        } else {//Si existen fracciones continuamos
                            foreach ($ManoObra as $key => $Fra) {//Iteramos la ficha tecnica por cada estilo color
                                $costo = floatval($Fra->manoobra);
                                $deptof = $Fra->depto;

                                //Sacamos los acumulados por departamento para el costeo
                                if (intval($deptof) >= 10 && intval($deptof) <= 90) {
                                    $cortef = floatval($cortef) + floatval($costo);
                                }
                                if (intval($deptof) >= 110 && intval($deptof) <= 140) {
                                    $pespf = floatval($pespf) + floatval($costo);
                                }
                                if (intval($deptof) >= 150 && intval($deptof) <= 160) {
                                    $tejif = floatval($tejif) + floatval($costo);
                                }
                                if (intval($deptof) === 180) {
                                    $montf = floatval($montf) + floatval($costo);
                                }
                                if (intval($deptof) >= 210 && intval($deptof) <= 240) {
                                    $adorf = floatval($adorf) + floatval($costo);
                                }
                            }
                        }
                    } else {//Cuando no es maquila uno,traeos el precio de la tabla de preciosmaquilas
                        $PrecioMaquilas = $this->db->query("select PrecioVta from listapreciosmaquilas where Maq = '$maq' and Linea = '$linea' and Estilo = '$estilo' and Color ='$ncolor' ")->result();

                        if (!empty($PrecioMaquilas)) {
                            $txtprevta = $PrecioMaquilas[0]->PrecioVta;
                        }
                    }
                    //Actualizamos si ya existe o agregamos si no existe
                    $EstilosProce = $this->db->query("select * from estilosprocesox where maq = '$maq' and linea = '$linea' and estilo = '$estilo' and color ='$ncolor' ")->result();

                    if (empty($EstilosProce)) {//Si no existe agregamos
                        $this->db->insert("estilosprocesox", array(
                            'linea' => $linea,
                            'estilo' => $estilo,
                            'color' => $ncolor,
                            'maq' => $maq,
                            'nomcol' => $txtnomcolor,
                            'mapcte' => $corte,
                            'mappes' => $pesp,
                            'maptej' => $teji,
                            'mapmon' => $montf,
                            'mapado' => $ador,
                            'mdocte' => $cortef,
                            'mdopes' => $pespf,
                            'mdotej' => $tejif,
                            'mdomon' => $montf,
                            'mdoado' => $adorf,
                            'gfcte' => $gfcorte,
                            'gfpes' => $gfpespu,
                            'gftej' => $gftejido,
                            'gfmon' => $gfmontado,
                            'gfado' => $gfadorno,
                            'termi' => $txtprevta,
                            'fecha' => Date('Y-m-d')
                        ));
                    } else {//Si existe actualizamos datos
                        $this->db->where('estilo', $estilo)->where('color', $ncolor)->where('linea', $linea)->where('maq', $maq)
                                ->update("estilosprocesox", array(
                                    'nomcol' => $txtnomcolor,
                                    'mapcte' => $corte,
                                    'mappes' => $pesp,
                                    'maptej' => $teji,
                                    'mapmon' => $mont,
                                    'mapado' => $ador,
                                    'mdocte' => $cortef,
                                    'mdopes' => $pespf,
                                    'mdotej' => $tejif,
                                    'mdomon' => $montf,
                                    'mdoado' => $adorf,
                                    'gfcte' => $gfcorte,
                                    'gfpes' => $gfpespu,
                                    'gftej' => $gftejido,
                                    'gfmon' => $gfmontado,
                                    'gfado' => $gfadorno,
                                    'termi' => $txtprevta,
                                    'fecha' => Date('Y-m-d')
                        ));
                    }

                    $term1 = $corte + $pesp + $teji + $mont + $ador;
                    $term2 = $cortef + $pespf + $tejif + $montf + $adorf;
                    $term3 = $gfcorte + $gfpespu + $gftejido + $gfmontado + $gfadorno;
                    $terminado = $term1 + $term2 + $term3;

                    $this->db->where('estilo', $estilo)->where('color', $ncolor)->where('linea', $linea)->where('maq', 1)
                            ->update("estilosprocesox", array(
                                'termi' => $terminado,
                                'tomdo' => $term2,
                                'tomap' => $term1
                    ));
                    //Actualiza el registro de gastos
                    $this->db->where('linea', 99999)->where('estilo', 99999)
                            ->update("estilosprocesox", array(
                                'gfcte' => $gfcorte,
                                'gfpes' => $gfpespu,
                                'gftej' => $gftejido,
                                'gfmon' => $gfmontado,
                                'gfado' => $gfadorno,
                    ));
                }
                $response['fichatecnica'] = $estilossft; //Arroja los estilos que no tuvieron ficha tecnica
                $response['fracciones'] = $estilossfrac; //Arroja los estilos que no tuvieron fracciones
            }
            print json_encode($response);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
