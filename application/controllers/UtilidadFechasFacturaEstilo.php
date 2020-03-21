<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class UtilidadFechasFacturaEstilo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuParametros');
                    break;
            }
            $this->load->view('vGeneraCostosVenta')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onSacaUtilidadExcel() {
        try {
            //$lista = $this->input->post('Lista');
            //$linea = $this->input->post('Linea');
            //$corr = $this->input->post('Corrida');
            $response = '';

            $this->db->query("truncate table costoparautilidad ");
            //------------------------------Obtenemos los estilos y colores con su porcentaje de desperdicio------------------------------
            $Estilos = $this->db->query("SELECT
fa.factura,
fa.cliente,
cte.razons AS nomcliente,
SUBSTRING_INDEX(fa.`estilo`, ' ', 1) AS estilo,
e.linea,
e.corrida,
CASE
WHEN e.PiezasCorte = 1 THEN m.PorExtraXBotaAlta
WHEN e.PiezasCorte = 2 THEN m.PorExtraXBota
WHEN e.PiezasCorte > 2 AND e.PiezasCorte <= 10 THEN m.PorExtra3a10
WHEN e.PiezasCorte > 10 AND e.PiezasCorte <= 14 THEN m.PorExtra11a14
WHEN e.PiezasCorte > 14 AND e.PiezasCorte <= 18 THEN m.PorExtra15a18
WHEN e.PiezasCorte > 18  THEN m.PorExtra19a END AS PorcenDesperd,
(SELECT c.clave FROM colores c WHERE c.estilo =  SUBSTRING_INDEX(fa.`estilo`, ' ', 1) AND c.precioventa = 1) AS numcolor,
SUBSTRING(fa.`estilo`, LOCATE(' ' ,fa.`estilo`)+1)AS nomcolor,
fa.`pareped`,
cte.`ListaPrecios` AS lista,
FA.`precto` AS preciofactura
FROM `facturacion` fa
JOIN clientes cte ON cte.clave = fa.`cliente`
JOIN estilos e ON e.clave = SUBSTRING_INDEX(fa.`estilo`, ' ', 1)
JOIN maquilas m ON m.`Clave` = 1
WHERE fa.cliente = 1755 AND fa.staped = 2 AND YEAR(fa.fecha) = 2020 AND fa.tp = 1 AND MONTH(fa.fecha) = 3
ORDER BY fa.`factura`, e.linea, e.clave, ABS(numcolor) ASC  ")->result();

            $txttolera = 0;
            $txtutili = 0;
            if (!empty($Estilos)) {//Si existen estilos empezamos el proceso
                foreach ($Estilos as $key => $E) {
                    $estilo = $E->estilo;
                    $color = $E->numcolor;
                    $colord = $E->nomcolor;
                    $lista = $E->lista;
                    $linea = $E->linea;
                    $corr = $E->corrida;

                    $factura = $E->factura;
                    $cliente = $E->cliente;
                    $nomcliente = $E->nomcliente;
                    $pares = $E->pareped;

                    $preaut = $E->preciofactura;
                    //Verifica si existe clasificacion para precio de venta
                    if ($color !== null) {
                        $porcentajeDesp = $E->PorcenDesperd;
                        //------------------------------Obtenemos la materia prima "materiales"------------------------------
                        $FichaTecnica = $this->db->query("select ft.consumo, a.grupo, pm.precio
                                            from fichatecnica ft
                                            join articulos a on a.clave  = ft.articulo
                                            join preciosmaquilas pm on pm.Articulo = a.clave and pm.maquila = 1
                                            where ft.estilo = '$estilo' and ft.color = '$color' and ft.afectapv = 0
                                            order by abs(a.grupo) asc ")->result();
                        $txtmaprpt = 0;
                        $txtmaprft = 0;
                        $txtmaprig = 0;
                        $txtmapri = 0;
                        foreach ($FichaTecnica as $key => $F) {
                            $precio = floatval($F->precio);
                            $grupo = $F->grupo;
                            $consumo = floatval($F->consumo);
                            if ($grupo === '1') {
                                $txtconsu = floatval($consumo) * floatval($porcentajeDesp);
                                $txtconsup = floatval($txtconsu) * floatval($precio);
                                $txtmaprpt = floatval($txtmaprpt) + floatval($txtconsup);
                            }
                            if ($grupo === '2') {
                                $txtconsu = floatval($consumo) * floatval($porcentajeDesp);
                                $txtconsuf = floatval($txtconsu) * floatval($precio);
                                $txtmaprft = floatval($txtmaprft) + floatval($txtconsuf);
                            }
                            $txtmapr = floatval($consumo) * floatval($precio);
                            $txtmapri = floatval($txtmapri) + floatval($txtmapr);
                            $txtmaprig = floatval($txtmaprig) + floatval($txtmapr);
                        }
                        //------------------------------ Obtenemos la mano de obra ------------------------------
                        $ManoObra = $this->db->query("select sum(CostoVTA) as manoobra "
                                        . "from fraccionesxestilo "
                                        . "where estilo = '$estilo' and AfectaCostoVTA = 1 and fraccion not in ('401','402','403'); ")->result()[0]->manoobra;

                        $Tejida = $this->db->query("select sum(CostoVTA) as tejida "
                                        . "from fraccionesxestilo "
                                        . "where estilo = '$estilo' and AfectaCostoVTA = 1 and fraccion  in ('401','402','403'); ")->result()[0]->tejida;

                        //Nos traemos los parametros fijos GASTOS etc.
                        $ParamFijos = $this->db->query("SELECT * FROM costofijo where lista = $lista ")->result();

                        if (empty($ParamFijos)) {//No existen parametros fijos
                            $response = 0;
                            print $response;
                            exit();
                        } else {//Existen parametros fijos y obtenemos los datos para inserar o actualizar
                            $txttolera = $ParamFijos[0]->toler;
                            $txtgfabri = $ParamFijos[0]->gfabri;
                            $txtgvta = $ParamFijos[0]->gvta;
                            $txtgadmon = $ParamFijos[0]->gadmon;
                            $txthms = $ParamFijos[0]->hms;
                            $txtutili = $ParamFijos[0]->utili;
                            $txtdesc = $ParamFijos[0]->desc;
                            $txtcomic = $ParamFijos[0]->comic;
                            $txtflete = $ParamFijos[0]->flete;

                            //Guardamos registros
                            $this->db->insert("costoparautilidad", array(
                                'factura' => $factura,
                                'cliente' => $cliente,
                                'nomcliente' => $nomcliente,
                                'pares' => $pares,
                                'lista' => $lista,
                                'estilo' => $estilo,
                                'color' => $color,
                                'colord' => $colord,
                                'linea' => $linea,
                                'matpri' => $txtmapri,
                                'maob' => $ManoObra,
                                'toler' => $txttolera,
                                'gfabri' => $txtgfabri,
                                'gvta' => $txtgvta,
                                'gadmon' => $txtgadmon,
                                'hms' => $txthms,
                                'utili' => $txtutili / 100,
                                'desc' => $txtdesc,
                                'comic' => $txtcomic,
                                'tejida' => $Tejida,
                                'precto' => 0,
                                'preaut' => $preaut,
                                'flete' => $txtflete,
                                'pextr' => $porcentajeDesp,
                                'corr' => $corr,
                                'mextr' => floatval($txtmaprpt + $txtmaprft),
                                'fecha' => Date('Y-m-d')
                            ));
                        }
                    } else {
                        //Acumulamos los estilos sin clasificacion para mostrarlos en mensaje
                        $response .= $estilo . " \n";
                    }
                }

                //Actualizamos el precto ya una vez actualizado los campos de costoparautilidad
                $CostoVariaFinal = $this->db->query("SELECT * FROM costoparautilidad ")->result();
                if (empty($CostoVariaFinal)) {//No existen estilos en costo varia para sacar precio final
                    $response = 2;
                    print $response;
                    exit();
                } else {//hacemos la iteración
                    foreach ($CostoVariaFinal as $key => $CF) {
                        $matepri = $CF->matpri;
                        $tolera = $CF->toler;
                        $maob = $CF->maob;
                        $gfabri = $CF->gfabri;
                        $gvta = $CF->gvta;
                        $gadmon = $CF->gadmon;
                        $hms = $CF->hms;
                        $desc = $CF->desc;
                        $comic = $CF->comic;
                        $tejida = $CF->tejida;
                        $mextr = $CF->mextr;
                        $flete = $CF->flete;

                        $txttol9 = floatval($matepri) + floatval($mextr);
                        $txttol = floatval($txttol9) * floatval($txttolera);

                        $txtctopro = floatval($matepri) + floatval($maob) + floatval($tejida) + floatval($gfabri) + floatval($txttol) + floatval($mextr);


                        $txtsubt9 = floatval($txtctopro) + floatval($gvta) + floatval($gadmon) + floatval($hms) + floatval($flete);

                        $porcentaje0 = 0.85;
                        $porcentaje1 = floatval($comic) + floatval($desc);
                        $porcentaje2 = floatval($porcentaje0) - floatval($porcentaje1);

                        $txtsubt99 = floatval($txtsubt9) / floatval($porcentaje2);


                        $txtsubt8 = floatval($txtsubt99) * (floatval($txtutili) / 100);
                        $txtsubt = floatval($txtsubt9) + floatval($txtsubt8);
                        $txtds = floatval($txtsubt99) * floatval($desc);
                        $txtcm = floatval($txtsubt99) * floatval($comic);
                        $txtpreprom = $txtsubt + $txtds + $txtcm;

                        $query = "update costoparautilidad set precto = $txtpreprom where lista = {$CF->lista} and linea = {$CF->linea} and corr = {$CF->corr} and estilo = '$CF->estilo' and color = $CF->color ";
                        $this->db->query($query);
                    }
                }
            } else {//No existen estilos
                $response = 1;
                print $response;
                exit();
            }
            print $response;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Reportes */

    public function onImprimirListaPrecios() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["lista"] = $this->input->post('Lista');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\costos\reporteListasPrecios.jasper');
        $jc->setFilename('REPORTE_LISTAS_PRECIO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

}
